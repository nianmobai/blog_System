<?php

function isMobile(): bool
{
    //if exist HTTP_X_WAP_PROFILE return true
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // check via message if including 'wap'
    if (isset($_SERVER['HTTP_VIA'])) {
        // can't find 'wap' = return flase, find 'wap' = retun true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    //judge depend on the message from client
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // check the key wrods in HTTP_USER_AGENT through canonica
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // find the supported protocol (协议法)
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        // only support wml, but not support html => pmd
        // only wml andhtml, nut wml is before html => pmd
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}


function Get_BlogHosterInro()
{
    //TODO
}

function CheckHealth()
{ //check about the data base
    //TODO
}

function Initial(mysqli $con)
{
    $sql = "CREATE DATABASE IF NOT EXISTS blog";
    $result = $con->query($sql);
    if (!$result) {
        die("创建失败" . $con->error);
    } else
        echo "创建成功";
    $con->select_db('blog');
    $sql = "CREATE";
    return;
}

/**
 *  function:turn to the target page
 *  param:$url{string}
 *  return:none
 */
function Turn_Page(string $url): bool
{
    if ($url == "" || $url == null) {
        die('url wrong ,cant turn to the  page');
    } else {
        echo "<script type='text/javascript'>";
        echo "window.location.href = '$url'";
        echo "</script>";
        return true;
    }
}

class Login
{
    private $password;
    private $accountNum;
    public function __construct()
    {
        $link = new LoginData();
        $connect = mysqli_connect($link->__gethost(), $link->__getusrname(), $link->__getusrpassword(), $link->__getdbname());
        if (!$connect) {
            die("Error:" . mysqli_connect_errno());
        }
        $this->accountNum = $this->Get_Account($connect);
        $this->password = $this->Get_Pssword($connect);
        $connect->close();
    }

    public function __getps()
    {
        return $this->password;
    }
    public function __getac()
    {
        return $this->accountNum;
    }

    public function __get_left(): int
    {
        return $_SESSION['left'];
    }

    public function __reset_left(): bool
    {
        session_start();
        $_SESSION['left'] = 5;
        session_write_close(); //save session
        return true;
    }

    public function __set_left_decre(): bool
    {
        session_start();
        if (isset($_SESSION['left'])) {
            $_SESSION['left'] -= 1;
            session_write_close();
            return true;
        } else {
            return false;
        }
    }

    public function Comfirm(string $ac, string $ps, &$error_mes): bool
    {
        if ($ac == $this->accountNum) {
            if ($ps == $this->password) {
                $error_mes = 0;
                return true;
            } else {
                $error_mes = 2;
                return false;
            }
        } else {
            $error_mes = 1;
            return false;
        }
    }

    private function Get_Account(mysqli $con): string
    { //get the account from database
        $sql = "SELECT usr_account FROM usr";
        $ac = mysqli_query($con, $sql);
        $ac = $ac->fetch_array();
        if ($ac == null)
            die("error");
        return $ac[0];
    }

    private function Get_Pssword(mysqli $con): string
    { //get the password from database
        $sql = "SELECT usr_password FROM usr";
        $ps = mysqli_query($con, $sql);
        $ps = $ps->fetch_array();
        if ($ps == null)
            die("error");
        return $ps[0];
    }
}

class LoginData
{
    protected $host = 'localhost';
    private $usrname = 'zsj';
    private $usrpassword = '123456';
    private $db_name = 'blog';
    private $usr_chartName = 'usr';
    private $art_chartName = 'art';
    private $intro_chartName = 'intro';

    public function __gethost(): string
    {
        return $this->host;
    }
    public function __getusrname(): string
    {
        return $this->usrname;
    }
    public function __getusrpassword(): string
    {
        return $this->usrpassword;
    }
    public function __getdbname(): string
    {
        return $this->db_name;
    }
    public function __getusr_chartname(): string
    {
        return $this->usr_chartName;
    }
    public function __getintro_chartname(): string
    {
        return $this->intro_chartName;
    }
    public function __getart_chartname(): string
    {
        return $this->art_chartName;
    }
}

class Vistor
{
    public function Get_ArtIntro()
    {
        //art_id,headline,sort,essaypic_path,briefIntro,create_time
        //TODO
        $db_link = new LoginData();
        $con = new mysqli($db_link->__gethost(), $db_link->__getusrname(), $db_link->__getusrpassword());
        if ($con == null) {
            die("sever link error");
        }
        if ($con->select_db($db_link->__getdbname()) == false)
            die("database select error");
        $sql = "SELECT art_id,headline,sort,essaypic_path,briefIntro,create_time FROM usr";
        $result_org = $con->query($sql);
        $result_ary = mysqli_fetch_array($result_org);
        return $result_ary;
    }

    public function Get_ArticleUrl($id, &$url)
    {
        if ($id == null || $id == "" || $url == null || $url == "") {
            die("void id or void url");
        }
        $link_data = new LoginData();
        $con = new mysqli($link_data->__gethost(), $link_data->__getusrname(), $link_data->__getusrpassword());
        if ($con == null) {
            die("sever link error");
        }
        if ($con->select_db($link_data->__getdbname()) == false) {
            die("datbase select error");
        }
        $sql = "SELECT id, essay_path FROM blog";
        $result_org = $con->query($sql);
        $result_ary = mysqli_fetch_array($result_org);
        foreach ($result_ary as $key => $value) {
            if ($value['art_id'] == $id) {
                $url = $value['essay_path'];
                break;
            }
        }
        return;
    }

    //load file with article translate markdown to html to show
    public function Get_ArticleContent($url)
    {
        //TODO
        return;
    }
    public function Introget()
    {
    }
}

class Control extends LoginData
{
    protected function DelArticle($id)
    {
        //TODO
        //delete the file and remove relavant data from database
    }

    protected function AddArticle()
    {
        //TODO
        //file upload, create a new file to save the article we decide to upload
    }

    protected function ChangeArticle()
    {
        //TODO
    }
    protected function Introchange()
    {
        //TODO
    }
}

class result
{
    public $lr;
    public $script;
    public $errormes;
    public $left;
}
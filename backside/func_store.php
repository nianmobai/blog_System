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
}

class Intro
{
    public $o_name;
    public $headpic_path;
    public $tag;
    public $QQ;
    public $blibli;
    public $mail;
    public $update_judge = false;

    private $name_change = 0;
    private $headpic_change = 1;
    private $tag_change = 2;
    private $QQ_change = 3;
    private $blibli_change = 4;
    private $mail_change = 5;

    public function Intro_Update()
    {
        $data_link = new LoginData();
        $con = new mysqli($data_link->__gethost(), $data_link->__getusrname(), $data_link->__getusrpassword());
        if (!$con) {
            die("sever link error : " . $con->connect_error);
        }
        if ($con->select_db($data_link->__getdbname())) {
            die("database selec error" . $con->error());
        }
        $sql = "SELECT o_name,headpic_path,tag,QQ,blibli,mail FROM intro";
        $org_result = $con->query($sql);
        $asc_result = mysqli_fetch_assoc($org_result);
        $asc_result['tag'] = json_encode($asc_result['tag']); //translate string to array
        $this->o_name = $asc_result['o_name'];
        $this->mail = $asc_result['mail'];
        $this->tag = $asc_result['tag'];
        $this->headpic_path = $asc_result['headpic'];
        $this->blibli = $asc_result['blibli'];
        $this->QQ = $asc_result['QQ'];
        $this->update_judge = true; //set target to check if this function have runned before
        return $asc_result;
    }
    public function Intro_Change(int $target, $ToChange): bool
    {
        if (!$this->update_judge)
            $this->Intro_Update();
        switch ($target) {
            case $this->name_change:
                $this->o_name = $ToChange;
                Write_Intro(0);
                break;
            case $this->headpic_change:
                $this->headpic_path = $ToChange;
                Write_Intro(1);
                break;
            case $this->tag_change:
                $this->tag = $ToChange;
                Write_Intro(2);
                break;
            case $this->QQ_change:
                $this->QQ = $ToChange;
                Write_Intro(3);
                break;
            case $this->blibli_change:
                $this->blibli = $ToChange;
                Write_Intro(4);
                break;
            case $this->mail_change:
                $this->mail = $ToChange;
                Write_Intro(5);
                break;
            default:
                $this->o_name = $ToChange["o_name"];
                $this->headpic_path = $ToChange["headpic_path"];
                $this->tag = $ToChange["tag"];
                $this->QQ = $ToChange["QQ"];
                $this->blibli = $ToChange["blibli"];
                $this->mail = $ToChange["mail"];
                $this->Write_Intro(-1);
                break;
        }
        return false;
    }

    private function Write_Intro(int $select)
    {
        //TODO
        $data_link = new LoginData();
        $con = new mysqli($data_link->__gethost(), $data_link->__getusrname(), $data_link->__getusrpassword());
        if (!$con) {
            die("secer link error" . $con->connect_error);
        }
        if ($con->select_db($data_link->__getdbname()) == false) {
            die("database select error" . $con->error);
        }
        $sql = null;
        switch ($select) {
            case $this->name_change:
                $sql = "UPDATE intro SET o_name = $this->o_name";
                break;
            case $this->headpic_change:
                $sql = "UPDATE intro SET headpic_path = $this->headpic_path";
                break;
            case $this->tag_change:
                $tran_data = json_encode($this->tag); //translate array to string
                $sql = "UPDATE intro SET tag = $tran_data";
                break;
            case $this->QQ_change;
                $sql = "UPDATE intro SET QQ = $this->QQ";
                break;
            case $this->blibli_change:
                $sql = "UPDATE intro SET blibli = $this->blibli";
                break;
            case $this->mail_change:
                $sql = "UPDATE intro SET mail = $this->mail";
                break;
            default:
                //TODO
                $str = json($this->tag);
                $sql = "UPDATE intro SET o_name = $this->o_name, 
                headpic_path = $this->headpic_path,
                tag = $str,
                QQ = $this->QQ,
                blibli = $this->blibli,
                mail = $this->mail";
                break;
        }
        //do with chart"intro" in database blog
        $con->query($sql);
        return;
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
    public function Update_psAndac(string $ps, string $ToChange_ps, string $ToChange_ac)
    {
        //TODO
        $login = new Login();
        if ($login->__getps() != $ps)
            return false;
        $data_link = new LoginData();
        $con = new mysqli($data_link->__gethost(), $data_link->__getusrname(), $data_link->__getusrpassword());
        if (!$con) {
            die("sever link error" . $con->connect_errno);
        }
        if ($con->select_db($data_link->__getdbname()) == false) {
            die("database select error" . $con->error);
        }
        $sql = "UPDATE usr SET usr_password = $ToChange_ps,usr_account = $ToChange_ac";
        $con->query($sql);
        return true;
    }
}

class result
{
    public $lr;
    public $script;
    public $errormes;
    public $left;
}
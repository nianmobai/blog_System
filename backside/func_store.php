<?php

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
    private $art_chartName = '';
    private $intro_chartName = '';

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
}

class Vistor
{
    public function Get_ArticleUrl($id, &$url)
    {
        if ($id == null || $id == "" || $url == null || $url == "") {
            die("void id or void url");
        }
        $link_data = new LoginData();
        $con = new mysqli($link_data->__gethost(), $link_data->__getusrname(), $link_data->__getusrpassword());
        if ($con == null) {
            die("severice link error");
        }
        if ($con->select_db($link_data->__getdbname()) == false) {
            die("datbase select error");
        }
        $sql = "SELECT id, essay_path FROM blog";
        $result = $con->query($sql);
        $result_ary = mysqli_fetch_array($result);
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

class ArtControl extends LoginData
{
    public function GetAllArticle(string $name)
    {
        $logindata = new LoginData();
    }

    protected function DelArticle()
    {
        //TODO
    }

    protected function AddArticle()
    {
        //TODO
    }

    protected function ChangeArticle()
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
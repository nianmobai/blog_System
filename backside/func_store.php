<?php

function Get_BlogHosterInro()
{
}

function CheckHealth()
{ //check about the data base
    $host = 'localhost';
    $dbname = 'test';
    $usrname = 'root';
    $usrpassword = '123456';

    $test = mysqli_connect($host);
    $test = mysqli_connect($host, $usrname, $usrpassword);
    if (!$test) { //数据库不存在
        die("连接错误" . mysqli_connect_errno());
    }
    $sql = "SELECT COUNT(*) as `exists`  FROM information_schema.SCHEMATA WHERE SCHEMATA.SCHEMA_NAME = 'blog'";
    $re = $test->query($sql);
    if ($re == false) {
        die($test->error . $test->errno);
    }
    $row = $re->fetch_object();
    $db_exist = (bool) $row->exists;

    if ($db_exist == true) {
        echo "存在";
    } else {
        //initial
        echo "不存在,创建数据库";
        Initial($test);
        //initialize two charps
    }
    $test->close();
    return;
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
    private $art_chartName = '';

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
    public function Get_ArticleContent($id, $url)
    {
        if ($id == null || $url == null) {
            die("void id or url");
        }
        $link_data = new LoginData();
        $con = new mysqli($link_data->__gethost(), $link_data->__getusrname(), $link_data->__getusrpassword());
        if ($con == null) {
            die("severice link error");
        }
        if ($con->select_db($link_data->__getdbname()) == false) {
            die("datbase link error");
        }
        $sql = "SELECT id,title";
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
    }

    protected function AddArticle()
    {
    }

    protected function ChangeArticle()
    {
    }
}

class result
{
    public $lr;
    public $script;
    public $errormes;
    public $left;
}
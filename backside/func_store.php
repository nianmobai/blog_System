<?php

define( $LOGIN_NOERROR ,0);

function Get_BlogHosterInro()
{
}


function Get_Artitlce()
{//get the article intro
}

function CheckHealth()
{//check about the data base
    $host = 'localhost';
    $dbname = 'test';
    $usrname = 'root';
    $usrpassword = '123456';
    
    $test = mysqli_connect($host);
    $test = mysqli_connect($host,$usrname, $usrpassword);
    if(!$test){//数据库不存在
        die("连接错误".mysqli_connect_errno());
    }
    $sql = "SELECT COUNT(*) as `exists`  FROM information_schema.SCHEMATA WHERE SCHEMATA.SCHEMA_NAME = 'blog'";
    $re = $test->query($sql);
    if($re == false){
      die($test->error . $test->errno);
    }
    $row = $re->fetch_object();
    $db_exist = (bool)$row->exists;

    if($db_exist == true){
        echo "存在";
    }

    else{
        //initial
        echo "不存在,创建数据库";
        Initial($test);
        //再初始化两个表
    }
    $test->close();
    return;
}

function Initial(mysqli $con){
    $sql = "CREATE DATABASE IF NOT EXISTS blog";
        $result = $con->query($sql);
        if(!$result){
            die("创建失败".$con->error);
        }
        else echo "创建成功";
        $con->select_db('blog');
        $sql = "CREATE";
    return;
}

/**
 *  function:turn to the target page
 *  param:$url{string}
 *  return:none
 */
function Turn_Page(string $url) : bool
{
    if($url == "" || $url == null){
        //die('url wrong ,cant turn to the  page');
        return false;
    }
    else {
        echo "<script type='text/javascript'>";
        echo "window.location.href = '$url'";
        echo "</script>";
        return true;
    }
}

class Login
{
    private $password = '';
    private $accountNum = null;
    public function __construct()
    {
        $link = new LoginData();
        $connect = mysqli_connect($link->__gethost(), $link->__getusrname(),$link->__getusrpassword(),$link->__getdbname());
        if(!$connect){
            die("Error:".mysqli_connect_errno());
        }
        $this->accountNum = $this->Get_Account($connect);
        $this->password = $this->Get_Pssword($connect);
        $connect->close();
    }
     public function Comfirm(string $ps,string $ac) : bool
    {
        if ($ac == $this->accountNum && $ps == $this->password) {
            return true;
        } else {
            //throw error
            return false;
        }
    }
    private function Get_Account(mysqli $con) : string
    {//get the account from database
        return "null";
    }
    private function Get_Pssword(mysqli $con) : string
    {//get the password from database
        return "null";
    }
}

class LoginData{
    protected $host = 'localhost';
    protected $usrname = 'dd';
    protected $usrpassword = '123456';
    protected $db_name = 'blog';

    public function __gethost() : string
    {
        return $this->host;
    }
    public function __getusrname() : string
    {
        return $this->usrname;
    }
    public function __getusrpassword() : string
    {
        return $this->usrpassword;
    }
    public function __getdbname() : string
    {
        return $this->db_name;
    }
}


class ArtControl extends LoginData
{
    public function GetArticle(string $name)
    {
        $logindata = new LoginData();
        $sql = 'SELECT art_title,art_url,art_id FROM ART';
        $connect = mysqli_connect($logindata->__gethost(), $logindata->__getusrname(), $logindata->__getusrpassword(), $logindata->__getdbname());
        if ($connect == null) {
            die('Error:' . mysqli_connect_error());
        }
        $result = mysqli_query($connect, $sql);
        if (!$result) { //if result is none
            die('Error:' . mysqli_error($connect));
        }
        $enddata = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $enddata;
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

class result{
    public $lr;
    public $status;
    public $script;
    public $errormes;
    public $left = 5;
    private $con_url = "";
    public function __get_conurl() : string
    {
        return $this->con_url;
    }
}
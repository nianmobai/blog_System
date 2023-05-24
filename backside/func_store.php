<?php
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
function Turn_Page(string $url)
{
    echo "<script type='text/javascript'>";
    echo "window.location.href = '$url'";
    echo "</script>";
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
    public function Comfirm(string $ps,string $ac)
    {
        if ($ac == $this->accountNum && $ps == $this->password) {
            return true;
        } else {
            //throw error
            return false;
        }
    }
    private function Get_Account(mysqli $con)
    {//get the account from database
        return;
    }
    private function Get_Pssword(mysqli $con)
    {//get the password from database
        return;
    }
}

class LoginData{
    protected $host = 'localhost';
    protected $usrname = 'dd';
    protected $usrpassword = '123456';
    protected $db_name = 'blog';

    public function __gethost()
    {
        return $this->host;
    }
    public function __getusrname()
    {
        return $this->usrname;
    }
    public function __getusrpassword()
    {
        return $this->usrpassword;
    }
    public function __getdbname()
    {
        return $this->db_name;
    }
}


class ArtControl extends LoginData
{
    public function GetArticle(string $name)
    {
        $sql = 'SELECT art_title,art_url,art_id FROM ART';
        $connect = mysqli_connect($this->host, $this->usrname, $this->usrpassword, $this->usrname);
        if ($connect == null) {
            die('Error:' . mysqli_connect_error());
        }
        mysqli_select_db($connect, $this->db_name);
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
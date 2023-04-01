<?php
function Get_BlogHosterInro()
{
}
/**
 *  function:turn to the target page
 *  param:$url{string}
 *  return:none
 */
function Turn_Page($url)
{
    echo "<script type='text/javascript'>";
    echo "window.location.href = '$url'";
    echo "</script>";
}
class Login
{
    private $password = null;
    private $accountNum = null;
    private $host = 'localhost';
    private $dbname_HosterIntro = '';
    private $db_password = '';
    public function __construct()
    {
        $this->accountNum = $this->Get_Account();
        $this->password = $this->Get_Pssword();
    }
    public function Comfirm($ps, $ac)
    {

        if ($ac == $this->accountNum && $ps == $this->password) {
            //realize Page Turn
        } else {
            //throw error
        }
    }
    private function Get_Account()
    {
        return;
    }
    private function Get_Pssword()
    {
        return;
    }
}

class ArtControl
{
    private $host = 'localhost';
    private $db_password;
    private $db_name;
    private $db_usr;
    public function GetArticle($name)
    {
        $sql = 'SELECT art_title,art_url,art_id FROM ART';
        $connect = mysqli_connect($this->host, $this->db_usr, $this->db_password);
        if ($connect == null) {
            die('Error:' . mysqli_connect_error());
        }
        mysqli_select_db($connect, $this->db_name);
        $result = mysqli_query($connect, $sql);
        if (!$result) { //if result is none
            die('Error' . mysqli_error($connect));
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

/**
 * 
 */
class Monitor extends ArtControl
{
    public function Query(...$queryString)
    {
        if ($queryString == 'Add')
            $this->AddArticle();
        else if ($queryString == 'Del')
            $this->DelArticle();
        else if ($queryString == 'Change')
            $this->ChangeArticle();
    }
}

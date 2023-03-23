<?php
function Get_BlogHosterInro()
{
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
        $this->accountNum = Get_Account();
        $this->password = Get_Pssword();
    }
    public function Comfirm($ps, $ac)
    {

        if ($ac == $this->accountNum && $ps == $this > password) {
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

/**
 * 
 */
class ArtControl
{
    private $host = 'localhost';
    private $db_password;
    private $db_name;
    private $db_usr;
    public function GetArticle($name)
    {
        $sql = 'SELECT art_title,art_url,art_id FROM ART';
        $result = null;
        $connect = mysqli_connect($this->host, $this->db_usr, $this->db_password);
        if ($connect == null) {
            die('Error:' . mysqli_connect_error());
        }
        mysqli_select_db($connect, $this->db_name);
        mysqli_query($connect, $sql, $result);
        mysqli_fetch_all($result, MYSQL_BOTH);
        return;
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
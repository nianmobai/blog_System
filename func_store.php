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
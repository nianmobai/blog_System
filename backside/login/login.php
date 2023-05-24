<?php
include "./func_store.php";
$login = new Login();
$logindata = file_get_contents('php://input');
$sign = json_encode($logindata['login']);
$login_result =  $login->Comfirm($sign["account"], $sign["password"]);
if($login_result == true){
    //login successfully
}
else{
    //login false
}
?>
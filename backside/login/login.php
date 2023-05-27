<?php
include "./func_store.php";
$login = new Login();
$logindata = file_get_contents('php://input');
$sign = json_encode($logindata['login']);//login data posted by forward
$confirm_result =  $login->Comfirm($sign["account"], $sign["password"]);//comfirm the account and password

$login_result = new result;

if($confirm_result == true){
    //login successfully
    $login_result->lr = true;
    $url = $login_result->__get_conurl();
    $login_result->script = "window.location.href = '$url'";//jump page order
   // $login_result->status = ;
}
else{
    //login false
    $login_result->lr = false;
}
?>
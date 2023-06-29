<?php
include "../func_store.php";
$seven_days_time = 3600 * 24 * 7;
$login = new Login();
$logindata = file_get_contents('php://input');
$sign = json_decode($logindata, true);
$confirm_result = $login->Comfirm($sign['account'], $sign['password'], $error_mes); //comfirm the account and password
$login_result = new result;

if ($confirm_result == true) {
    //login successfully
    $login_result->lr = true;
    $url = "/control/c.html"; //control page url
    $login_result->script = "window.location.href = '$url'"; //jump page order
    $login_result->errormes = $error_mes;
    $login->__reset_left(); //reset the left numbers
    session_start();
    $_SESSION['admin'] = true;
    session_set_cookie_params($seven_days_time); //set life time
    session_write_close();
} else {
    //login false
    $login->__set_left_decre(); //declare left times
    $login_result->lr = false;
    $login_result->script = "";
    $_SESSION['admin'] = false;
    $login_result->errormes = $error_mes;
    $login_result->left = $login->__get_left(); //get the loginnums left
}

$end = json_encode($login_result);
echo $end;

?>
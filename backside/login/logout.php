<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
    $_SESSION['admin'] = false;//reset login status
}
$login_url = "Location :../../blogPage/login/signIn.html";
header($login_url);//turn to page
exit(0);
?>
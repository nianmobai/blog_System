<?php
$left = 5;
$hours = 3600 * 1000; 
//the left num is saved in the session
if($_SESSION['left']){
    $left = $_SESSION['left'];
}
else{
    $_SESSION['left'] = $left;
    session_set_cookie_params($hours);//set life time
}
echo $left;
?>
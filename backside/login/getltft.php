<?php
session_start();
$left;
$hour = 3600; 
//the left num is saved in the session
if(isset($_SESSION['left'])){
    $left = $_SESSION['left'];
}
else{
    $_SESSION['left'] = $left;
    session_set_cookie_params($hour);//set life time
    session_write_close();
}
echo json_encode($left);
?>
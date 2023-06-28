<?php
session_start();
$url;
$seven_days_time = 3600 * 24 * 7;
if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){//judge the admin(login status) exist status if
    header($url, true);
}
session_set_cookie_params($seven_days_time);
session_write_close();
?>
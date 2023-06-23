<?php
session_start();
$seven_days_time = 3600 * 24 * 7;
if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
    header($url, true);
}
session_set_cookie_params($seven_days_time);
session_write_close();
?>
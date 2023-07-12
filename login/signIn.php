<?php
session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    header($url);
} else {
    $_SESSION['admin'] = false;
    echo "<script type='text/javascript'>console.log('auto log in fail');</script>";
}
session_write_close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        @import url('../css/signed.css');
    </style>
</head>

<body class="back">
    <div id="loginpart" class="flex flex-center flex-direction-column">
        <div id="ac" class="flex flex-center"><b class="notice">账号</b><input id="ac-input" name="account" type="text"
                placeholder="account"></input>
        </div>
        <div id="ps" class="flex flex-center"><b class="notice">密码</b><input id="ps-input" name="password"
                type="password" placeholder="password"></input></div>
        <button id="confirm"><b>Confirm</b></button>
    </div>
    <div id="notice" class="flex flex-center"></div>
</body>
<script type="text/javascript" src="/sourcefile/jquery.min.js"></script>
<script type="text/javascript" src="../sourcefile/StockBackSpace.js"></script>
<script type="text/javascript" src="./singin.js"></script>

</html>
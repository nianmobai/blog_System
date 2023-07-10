<?php
session_start(); //启动session服务
if (isset($_SESSION['admin']) && $_SESSION['admin'] == false) {
    header("Location: ../login/signIn.php");
}
session_write_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>
        登录成功，进入控制台页面
    </p>
</body>
</html>
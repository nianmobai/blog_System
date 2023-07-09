<?php
//Delay 3 seconds then turn to  blog page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html,body{
            height:100%
        }
        .head1{
            position: absolute;
            font-size:large;
            left:50%;
            top:50px;
            transform:translateX(-50%);
        }
        .head2{
            font-size:30px;
            position:absolute;
            left:50%;
            top:100px;
            transform:translateX(-50%);
        }
    </style>
</head>
<body>
    <p class='head1'>文章不存在</p>
    <p class='head2'>页面将在3s内跳转</p>
</body>
</html>
<?php
include "./func_store.php";
$intro = new Intro();
$result;
$intro->Intro_Update($result);
echo json_encode($intro);
?>
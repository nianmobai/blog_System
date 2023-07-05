<?php
include "../func_store.php";
$intro = new Intro();
$result;
$result = $intro->Intro_Update();
echo json_encode($intro);
exit(0);
?>
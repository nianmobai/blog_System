<?php
include './backside/func_store.php';
$url;
//check if the client is pmd
if (isMobile()) {
    $url = "./blogPage/blogM.html";
} else {
    $url = "./enterpage/enterindex.html";
}
Turn_Page($url);
?>
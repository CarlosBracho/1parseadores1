<?php
if (!isset($_SESSION)) {
    session_start();
}
$logoutGoTo = "./home.php";
session_destroy();
$nombre ='';
$password ='';
setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()-60);
setcookie("COOKIE_DATA_INDEFINED_SESSION[nombre]", $nombre, time()-60);
setcookie("COOKIE_DATA_INDEFINED_SESSION[password]", $password, time()-60);
if ($logoutGoTo != "") {
    header("Location: $logoutGoTo");
    exit;
}
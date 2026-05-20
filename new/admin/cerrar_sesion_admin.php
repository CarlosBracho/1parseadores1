<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$logoutGoTo = "../index.php";
$_SESSION['MM_Username'] = null;
$_SESSION['MM_UserGroup'] = null;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
header("Location: $logoutGoTo");
exit;

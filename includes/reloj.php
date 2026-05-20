<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');
date_default_timezone_set('Pacific/Honolulu');
$hora1= date("D M j G:i:s T Y");
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);

<?php
if (!isset($_SESSION)) {
    session_start();
}
$hora1=time();
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo $nuevahora1;

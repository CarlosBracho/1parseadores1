<?php
require_once('../Connections/conexionbanca.php');
$query_Recordset5555 = sprintf("/* PARSEADORES1 new\includes\montosminimos.php - QUERY 1 */ SELECT * FROM tasadecambio WHERE Idtasadecambio = 1");
$Recordset5555 = mysqli_query($conexionbanca, $query_Recordset5555) or die(mysqli_error($conexionbanca));
$row_Recordset5555 = mysqli_fetch_assoc($Recordset5555);
$totalRows_Recordset5555 = mysqli_num_rows($Recordset5555);

//$apuestasminimaaganadorbss0='20000';
$usdalcambiodolartoday=$row_Recordset5555['usdabss'];
$copabss=$row_Recordset5555['copabss'];
$solabss=$row_Recordset5555['solabss'];

$apuestaminbs=$row_Recordset5555['apuestaminbs'];
$apuestasminimaaganadorbss0=$row_Recordset5555['usdabss']*$apuestaminbs;
$apuestasminimaaganadorusd1='0.10';
$apuestasminimaaganadorpc2='500';
$apuestasminimaaganadorsp3='1.5';

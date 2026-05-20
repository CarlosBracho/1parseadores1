<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
//$_GET["recordID"]

$query_Recordset4 =  sprintf("/* PARSEADORES1 includes\mensajes.php - QUERY 1 */ SELECT * FROM mensajes
WHERE est_mensaje=%s 
ORDER BY RAND() LIMIT 1",
GetSQLValueString($_GET["recordID"], "int"));
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$mensaje1 = trim($row_Recordset4['mensaje']);
if ($_GET["recordID"]==7){echo "<center><strong><p style=color:#141313;>".$mensaje1."</p></strong></center>";}

// 7 parley taquilla





?>
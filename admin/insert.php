<?php 
require_once('../Connections/conexionbanca.php');
$valor1="Alerta Agregar Cookie";
$valor2="2021-01-01";
$valor3=1;
$valor4="1.30";





//aqui inicia el insert 
$insertSQL1 = sprintf(
"/* PARSEADORES1 admin\insert.php - QUERY 1 */ INSERT 
INTO alertas
(nombrealerta, fec_alerta) 
VALUES (%s, %s)",
GetSQLValueString($valor1, "text"),
GetSQLValueString($valor2, "date"));
$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
//aqui termina el /* PARSEADORES1 admin\insert.php - QUERY 2 */ insert
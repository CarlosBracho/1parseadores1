<?php
require_once("../Connections/conexionbanca.php");
$agencia=26;
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin_lot\eliminadatosagencia.php - QUERY 1 */ SELECT id_agelot
	FROM 
		agencialoterias ag
	WHERE  ag.id_agencia=%s",
    GetSQLValueString($agencia, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
do {
    $query_delete =  sprintf(
        "/* PARSEADORES1 admin_lot\eliminadatosagencia.php - QUERY 2 */ DELETE FROM agencialoterias WHERE id_agelot = %s",
        GetSQLValueString($row_Recordset1['id_agelot'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $query_delete) or die(mysqli_error($conexionbanca));
    
    
    echo $row_Recordset1['id_agelot'];
    echo "<br/>";
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

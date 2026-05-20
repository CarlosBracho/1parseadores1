<?php

require_once('../Connections/conexionbanca.php');
$nticketp4=$_GET['nticketp4'];

//$Id_p2juegosp2=1;

echo "l44 ".$nticketp4."<br><br>";







    $query_Recordset11 = sprintf(
        "/* PARSEADORES1 parley\carculojparley3.php - QUERY 1 */ SELECT * FROM p4jugadas WHERE 
nticketp4 = %s ORDER BY lineatp4 DESC",
        GetSQLValueString($nticketp4, "int")
    );
    $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
    $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
    $totalRows_Recordset11 = mysqli_num_rows($Recordset11);

    $totaljugadas=$totalRows_Recordset11;
    $ganador=1;
    $premio=0;

    do {
        if (($row_Recordset11['estadojugadap4']==1 && $ganador==1) or $row_Recordset11['estadojugadap4']==3) {
            $ganador=1;
        } else {
            $ganador=2;
        }
        if ($row_Recordset11['estadojugadap4']==3 && $premio==0) {
            $premio=$row_Recordset11['mon_ventap4']+$premio;
        }
        if ($premio==0) {
            $premio=$row_Recordset11['mon_ventap4'];
        } else {
            $premio=$premio;
        }
        if ($row_Recordset11['logrop4']>0 && $row_Recordset11['estadojugadap4']==1) {
            $premio=($premio*($row_Recordset11['logrop4']/100))+$premio;
        }
        if ($row_Recordset11['logrop4']<0 && $row_Recordset11['estadojugadap4']==1) {
            $premio=($premio/(($row_Recordset11['logrop4']* -1)/100))+$premio;
        }
    } while ($row_Recordset11 = mysqli_fetch_assoc($Recordset11));
    if ($ganador==1) {
        //echo "linea5 ganador 1".$premio."<br><br>";
        $insertSQL155 = sprintf(
            "/* PARSEADORES1 parley\carculojparley3.php - QUERY 2 */ UPDATE p4jugadas  SET 
premioapagarp4=%s, estadoticketp4=%s
WHERE nticketp4=%s AND lineatp4=%s",
            GetSQLValueString($premio, "double"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($nticketp4, "int"),
            GetSQLValueString(1, "int")
        );
        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
    } else {
       // echo "linea5 else".$premio."<br><br>";
        $insertSQL155 = sprintf(
            "/* PARSEADORES1 parley\carculojparley3.php - QUERY 3 */ UPDATE p4jugadas  SET 
premioapagarp4=%s
WHERE nticketp4=%s AND lineatp4=%s",
            GetSQLValueString(0, "double"),
            GetSQLValueString($nticketp4, "int"),
            GetSQLValueString(1, "int")
        );
        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
    }

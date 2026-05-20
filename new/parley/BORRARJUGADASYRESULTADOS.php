<?php

require_once('../Connections/conexionbanca.php');

///*
$query_Recordsetuno1 = sprintf(
        "/* PARSEADORES1 new\parley\BORRARJUGADASYRESULTADOS.php - QUERY 1 */ DELETE 
    FROM p4jugadas
    WHERE  
    Id_p4jugadasp4 > 0");
    $Recordsetuno1 = mysqli_query($conexionbanca, $query_Recordsetuno1) or die(mysqli_error($conexionbanca));
    $row_Recordsetuno1 = mysqli_fetch_assoc($Recordsetuno1);
    $totalRows_Recordsetuno1 = mysqli_num_rows($Recordsetuno1);
//*/
    $query_Recordsetuno1 = sprintf(
        "/* PARSEADORES1 new\parley\BORRARJUGADASYRESULTADOS.php - QUERY 2 */ DELETE 
    FROM p5resultadosj
    WHERE  
    Id_p5resultadosjp5 > 0");
    $Recordsetuno1 = mysqli_query($conexionbanca, $query_Recordsetuno1) or die(mysqli_error($conexionbanca));
    $row_Recordsetuno1 = mysqli_fetch_assoc($Recordsetuno1);
    $totalRows_Recordsetuno1 = mysqli_num_rows($Recordsetuno1);
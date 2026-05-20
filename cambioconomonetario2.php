<?php
require_once('./Connections/conexionbanca.php');


//taquillas

$query_Recordset2 = sprintf(
    "/* PARSEADORES1 cambioconomonetario2.php - QUERY 1 */ SELECT 
*
 FROM taquilla ta, taquilla_opc_ame tp
WHERE tp.newconomonetario = 1
AND ta.cod_taquilla = tp.cod_taquilla
AND ta.moneda < 3
ORDER BY ta.cod_taquilla ASC LIMIT 10000"
);
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);




echo $totalRows_Recordset2.'<br>';



do {


    $apu_maxtri=$row_Recordset2['apu_maxtri']/1000000;
    $apu_mintri=$row_Recordset2['apu_mintri']/1000000;
    echo ' Cod '.$row_Recordset2['cod_taquilla'].' apu_maxtri '.$row_Recordset2['apu_maxtri'].' new '.$apu_maxtri.' apu_mintri '.$row_Recordset2['apu_mintri'].' new '.$apu_mintri.'';

    if($row_Recordset2['apu_maxtri']>=1000000 && $row_Recordset2['apu_mintri']>=10000){
        echo ' Se Editara ---------------> ';
///*
        $updateSQL = sprintf(
            "/* PARSEADORES1 cambioconomonetario2.php - QUERY 2 */ UPDATE taquilla_opc_ame SET apu_maxtri=%s, apu_mintri=%s, newconomonetario=0
             WHERE cod_taquilla=%s",
            GetSQLValueString($apu_maxtri, "double"),
            GetSQLValueString($apu_mintri, "double"),
            GetSQLValueString($row_Recordset2['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
//*/
    }




    if($row_Recordset2['apu_maxtri']>=10000000 && $row_Recordset2['apu_mintri']<=1000){
        echo ' Se Editara ---------------> ';
///*
        $updateSQL = sprintf(
            "/* PARSEADORES1 cambioconomonetario2.php - QUERY 3 */ UPDATE taquilla_opc_ame SET apu_maxtri=%s, apu_mintri=%s, newconomonetario=0
             WHERE cod_taquilla=%s",
            GetSQLValueString($apu_maxtri, "double"),
            GetSQLValueString("0.01", "double"),
            GetSQLValueString($row_Recordset2['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
//*/
    }





    if($row_Recordset2['apu_maxtri']==500000 && $row_Recordset2['apu_mintri']==20000){
        echo ' Se Editara ---------------> ';
///*
        $updateSQL = sprintf(
            "/* PARSEADORES1 cambioconomonetario2.php - QUERY 4 */ UPDATE taquilla_opc_ame SET apu_maxtri=%s, apu_mintri=%s, newconomonetario=0
             WHERE cod_taquilla=%s",
            GetSQLValueString("500", "double"),
            GetSQLValueString("0.10", "double"),
            GetSQLValueString($row_Recordset2['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
//*/
    }

    if($row_Recordset2['apu_maxtri']==1000000 && $row_Recordset2['apu_mintri']==20000){
        echo ' Se Editara ---------------> ';
///*
        $updateSQL = sprintf(
            "/* PARSEADORES1 cambioconomonetario2.php - QUERY 5 */ UPDATE taquilla_opc_ame SET apu_maxtri=%s, apu_mintri=%s, newconomonetario=0
             WHERE cod_taquilla=%s",
            GetSQLValueString("500", "double"),
            GetSQLValueString("0.10", "double"),
            GetSQLValueString($row_Recordset2['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
//*/
    }
    
    if($row_Recordset2['apu_maxtri']==1000000 && $row_Recordset2['apu_mintri']==50000){
        echo ' Se Editara ---------------> ';
///*
        $updateSQL = sprintf(
            "/* PARSEADORES1 cambioconomonetario2.php - QUERY 6 */ UPDATE taquilla_opc_ame SET apu_maxtri=%s, apu_mintri=%s, newconomonetario=0
             WHERE cod_taquilla=%s",
            GetSQLValueString("500", "double"),
            GetSQLValueString("0.10", "double"),
            GetSQLValueString($row_Recordset2['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
//*/
    }

    if($row_Recordset2['apu_maxtri']==200000 && $row_Recordset2['apu_mintri']==2000){
        echo ' Se Editara ---------------> ';
///*
        $updateSQL = sprintf(
            "/* PARSEADORES1 cambioconomonetario2.php - QUERY 7 */ UPDATE taquilla_opc_ame SET apu_maxtri=%s, apu_mintri=%s, newconomonetario=0
             WHERE cod_taquilla=%s",
            GetSQLValueString("500", "double"),
            GetSQLValueString("0.10", "double"),
            GetSQLValueString($row_Recordset2['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
//*/
    }


    echo  '<br>';

} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));

mysqli_free_result($Recordset1);

//
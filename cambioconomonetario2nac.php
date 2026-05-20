<?php
require_once('./Connections/conexionbanca.php');


//taquillas

$query_Recordset2 = sprintf(
    "/* PARSEADORES1 cambioconomonetario2nac.php - QUERY 1 */ SELECT 
*
 FROM taquilla ta, taquilla_opc_hnac tp
WHERE tp.newconomonetario = 0
AND ta.cod_taquilla = tp.cod_taquilla
AND ta.moneda < 3
ORDER BY ta.cod_taquilla ASC LIMIT 10000"
);
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);




echo $totalRows_Recordset2.'<br>';



do {


    $max_jugtic_hnac=$row_Recordset2['max_jugtic_hnac']/1000000;
    $min_jugtic_hnac=$row_Recordset2['min_jugtic_hnac']/1000000;
    $max_eje_hnac=$row_Recordset2['max_eje_hnac']/1000000;
    echo ' Cod '.$row_Recordset2['cod_taquilla'].' max_jugtic_hnac '.$row_Recordset2['max_jugtic_hnac'].' new '.$max_jugtic_hnac.' min_jugtic_hnac '.$row_Recordset2['min_jugtic_hnac'].' new '.$min_jugtic_hnac.'';
    echo ' max_eje_hnac '.$row_Recordset2['max_eje_hnac'].' new '.$max_eje_hnac;
    if($row_Recordset2['max_jugtic_hnac']>=1000000){
        echo ' Se Editara ---------------> ';
///*
        $updateSQL = sprintf(
            "/* PARSEADORES1 cambioconomonetario2nac.php - QUERY 2 */ UPDATE taquilla_opc_hnac SET max_jugtic_hnac=%s, min_jugtic_hnac=%s, max_eje_hnac=%s, newconomonetario=1
             WHERE cod_taquilla=%s",
            GetSQLValueString($max_jugtic_hnac, "double"),
            GetSQLValueString($min_jugtic_hnac, "double"),
            GetSQLValueString($max_eje_hnac, "double"),
            GetSQLValueString($row_Recordset2['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
//*/
   }










    




    echo  '<br>';

} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));

mysqli_free_result($Recordset2);

//
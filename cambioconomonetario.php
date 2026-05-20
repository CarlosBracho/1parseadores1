<?php
require_once('./Connections/conexionbanca.php');

//jugadas
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 cambioconomonetario.php - QUERY 1 */ SELECT 
ve.num_ticket, ve.mon_venta, ve.pag_premio
 FROM venta ve
WHERE ve.newconomonetario = 0
AND ve.efectivoO < 3
AND ve.num_ticket < 26678649
ORDER BY ve.num_ticket DESC LIMIT 1000"
);
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
///*

    do {
        $mon_venta=$row_Recordset1['mon_venta']/1000000;
               $pag_premio=$row_Recordset1['pag_premio']/1000000;
        echo $row_Recordset1['num_ticket'].' Monto venta '.$row_Recordset1['mon_venta'].' new '.$mon_venta.' Monto Premio '.$row_Recordset1['pag_premio'].' new '.$pag_premio.'';

            $updateSQL = sprintf(
                "/* PARSEADORES1 cambioconomonetario.php - QUERY 2 */ UPDATE venta SET mon_venta=%s, pag_premio=%s, newconomonetario=1
                                                          WHERE num_ticket=%s",
                GetSQLValueString($mon_venta, "double"),
                GetSQLValueString($pag_premio, "double"),
                GetSQLValueString($row_Recordset1['num_ticket'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
if($Result1==1){ echo ' Guardado Con Exito';}
echo  '<br>';

                   } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                   //*/
//taquillas
/*
$query_Recordset2 = sprintf(
    "SELECT 
*
 FROM taquilla ta, taquilla_opc_ame tp
WHERE ta.newconomonetario = 0
AND ta.cod_taquilla = tp.cod_taopcame
AND ta.moneda < 3
ORDER BY ta.cod_taquilla DESC LIMIT 10000"
);
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
echo $totalRows_Recordset2.'<br>';
do {


    $apu_maxgan=$row_Recordset2['apu_maxgan']/1000000;
    $apu_mingan=$row_Recordset2['apu_mingan']/1000000;
    echo ' apu_maxgan '.$row_Recordset2['apu_maxgan'].' new '.$apu_maxgan.' apu_mingan '.$row_Recordset2['apu_mingan'].' new '.$apu_mingan.'';


    


    echo  '<br>';

} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
*/
mysqli_free_result($Recordset1);

//
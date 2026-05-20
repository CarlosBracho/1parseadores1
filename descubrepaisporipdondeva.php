<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('./Connections/conexionbanca.php');
set_time_limit(0);
$query_Recordset1 = sprintf("/* PARSEADORES1 descubrepaisporipdondeva.php - QUERY 1 */ SELECT 
ve.num_ticket, ve.ip_venta, ve.fec_venta
 FROM venta ve 
 USE INDEX(PRIMARY)
WHERE ve.pais IS NULL
AND ve.conomonetario = 0
AND  `fec_venta` BETWEEN '2018-08-01'  AND '2019-08-01' 
ORDER BY ve.num_ticket DESC LIMIT 1");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo $totalRows_Recordset1;
echo '<br>';
echo $row_Recordset1['num_ticket'];
echo '<br>';
echo $row_Recordset1['fec_venta'];
echo '<br>';

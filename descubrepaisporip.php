<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('./Connections/conexionbanca.php');
set_time_limit(0);
$fec=fechaactualbd();

if(function_exists('exec')){
    echo 'Function exists';
 }else{
    echo 'Function does not exists';
 }



$query_Recordset1 = sprintf(
    "/* PARSEADORES1 descubrepaisporip.php - QUERY 1 */ SELECT 
ve.num_ticket, ve.ip_venta, ve.fec_venta
FROM venta ve FORCE INDEX (fec_venta)
WHERE ve.pais IS NULL
AND ve.conomonetario = 0
AND fec_venta >= date_add(NOW(), INTERVAL -3 DAY) AND fec_venta<=%s
ORDER BY ve.num_ticket DESC LIMIT 74",
    GetSQLValueString($fec, "date")
);
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if($totalRows_Recordset1==0){
    
    shell_exec('root mv /etc/cron.d/ipporpais /home/apuestas/crondarchivos/ipporpais').' top ';
    shell_exec('root ls').' top ';

   
    //rename("/etc/cron.d/ipporpais", "/home/apuestas/crondarchivos/ipporpais");
    exec('root mv /etc/cron.d/ipporpais /home/apuestas/crondarchivos/ipporpais');
    echo 'moviendo el archivo.5';
}else{
    echo 'procesando ticket';

    do {
        $ip =$row_Recordset1['ip_venta']; // the IP address to query
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if ($query && $query['status'] == 'success') {
            $country_code = $query['countryCode'];
            $pais=$country_code;
            echo $pais;
            echo '</br>';
            $num_ticket=$row_Recordset1['num_ticket'];
            echo $num_ticket;
            echo '</br>';
            $updateSQL = sprintf(
                "/* PARSEADORES1 descubrepaisporip.php - QUERY 2 */ UPDATE venta SET pais=%s, conomonetario=%s
                                                          WHERE num_ticket=%s",
                GetSQLValueString($pais, "text"),
                GetSQLValueString(1, "int"),
                GetSQLValueString($num_ticket, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $num_ticket=$row_Recordset1['num_ticket'];

            $updateSQL = sprintf(
                "/* PARSEADORES1 descubrepaisporip.php - QUERY 3 */ UPDATE venta SET conomonetario=%s
                                                          WHERE num_ticket=%s",
                GetSQLValueString(2, "int"),
                GetSQLValueString($num_ticket, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));



}
mysqli_free_result($Recordset1);

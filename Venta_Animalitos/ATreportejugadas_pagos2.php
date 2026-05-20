<?php
opcache_reset();
//echo 'opcache_reset<br>';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
}require_once('../Connections/conexionbanca.php');

$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;
$ip_ventap=getRealIP();
if ($_POST['tmodificacion']==1) { // 1 es pagar jugadas ganadoras de este ticket
echo '';
$query_Recordset1 = sprintf(
  "/* PARSEADORES1 Venta_Animalitos\ATreportejugadas_pagos2.php - QUERY 1 */ SELECT 
*
FROM
ani5_jugadas, taquilla_opc_ani
WHERE
ani5_jugadas.estadojugada_ani5 = 1 AND
ani5_jugadas.num_ticket_ani5 = %s AND 
ani5_jugadas.cod_taquilla_ani5 = taquilla_opc_ani.cod_taquilla",
GetSQLValueString($_POST['num_ticket_ani5'], "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
//echo $totalRows_Recordset1.$_POST['num_ticket_ani5'].'<br>';
//echo $row_Recordset1['cierre_adelantado'].' cierre_adelantado <br>';


if( $totalRows_Recordset1>0){
  do {
if($row_Recordset1['estadojugada_ani5']==1){  
//si es ganador
echo 'se proceso el registro del pago<br>';
echo '<br>Numero ticket: '.$row_Recordset1['num_ticket_ani5'];
echo '<br>Fecha: ';
$hora1=$row_Recordset1['fechahora_creacion_ani5'];
$nuevahora11 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora11);
echo date('Y-m-d', $nuevahora11);
echo '<br>Hora: ';

                    echo horaampm($nuevahora1); 

echo '<br>Monto a cancelar= '.$row_Recordset1['mon_pago_ani5'];
if ($row_Recordset1['moneda_ani5']==0) {echo ' BSS';}
if ($row_Recordset1['moneda_ani5']==1) {echo ' BSS';}
if ($row_Recordset1['moneda_ani5']==2) {echo ' BSS';}
if ($row_Recordset1['moneda_ani5']==3) {echo ' USD';}
if ($row_Recordset1['moneda_ani5']==4) {echo ' COP';}
if ($row_Recordset1['moneda_ani5']==5) {echo ' SOL';}


$insertSQL1monto_total = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\ATreportejugadas_pagos2.php - QUERY 2 */ UPDATE ani5_jugadas
      SET
      ip_pago_ani5=%s,
      fechahora_pago_ani5=%s,
      estadojugada_ani5=5
      WHERE 
      id_ticket_ani5=%s",
  GetSQLValueString($ip_ventap, "text"),
  GetSQLValueString($datetime, "date"),
  GetSQLValueString($row_Recordset1['id_ticket_ani5'], "int")
  );
  
  $Result1monto_total = mysqli_query($conexionbanca, $insertSQL1monto_total) or die(mysqli_error($conexionbanca));

//aqui se colocara los detalles del ticket















} 
if($row_Recordset1['estadojugada_ani5']==3){  
  //si es ganador
  echo 'se proceso el registro del pago2';
  $insertSQL1monto_total = sprintf(
      "/* PARSEADORES1 Venta_Animalitos\ATreportejugadas_pagos2.php - QUERY 3 */ UPDATE ani5_jugadas
        SET
        ip_pago_ani5=%s,
        fechahora_pago_ani5=%s,
        estadojugada_ani5=6
        WHERE 
        id_ticket_ani5=%s",
    GetSQLValueString($ip_ventap, "text"),
    GetSQLValueString($datetime, "date"),
    GetSQLValueString($row_Recordset1['id_ticket_ani5'], "int")
    );
    
    $Result1monto_total = mysqli_query($conexionbanca, $insertSQL1monto_total) or die(mysqli_error($conexionbanca));
  
  
  } 




    


  } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

  }

}
if ($_POST['tmodificacion']==3) {
echo 'se proceso la devolucion de jugada';







}
if ($_POST['tmodificacion']==4) { // 4 es eliminar ticket

  $message=0;
  $parar=0;











  $query_Recordset111 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\ATreportejugadas_pagos2.php - QUERY 4 */ SELECT 
  *
  FROM
  ani5_jugadas, taquilla_opc_ani
  WHERE
  ani5_jugadas.estadojugada_ani5 = 0 AND
  ani5_jugadas.num_ticket_ani5 = %s AND 
  ani5_jugadas.cod_taquilla_ani5 = taquilla_opc_ani.cod_taquilla",
  GetSQLValueString($_POST['num_ticket_ani5'], "int"));
  $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
  $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
  $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
  //echo $totalRows_Recordset111.$_POST['num_ticket_ani5'].'<br>';
  //echo $row_Recordset111['cierre_adelantado'].' cierre_adelantado <br>';

  $query_Recordset222 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\ATreportejugadas_pagos2.php - QUERY 5 */ SELECT 
  *
  FROM
  ani5_jugadas
  WHERE
  ani5_jugadas.estadojugada_ani5 = 4 AND
  ani5_jugadas.fechahora_creacion_ani5 > %s AND 
  ani5_jugadas.cod_taquilla_ani5 = %s AND 
  ani5_jugadas.linea_ticket_ani5= 1",
  GetSQLValueString($FechaTxt.' 00:00:01', "date"),
  GetSQLValueString($_SESSION["MM_cod_taquilla"], "int"));
  $Recordset222 = mysqli_query($conexionbanca, $query_Recordset222) or die(mysqli_error($conexionbanca));
  $row_Recordset222 = mysqli_fetch_assoc($Recordset222);
  $totalRows_Recordset222 = mysqli_num_rows($Recordset222);
//echo $totalRows_Recordset222.' $totalRows_Recordset222<br>';
//max_minutos_eliminar
//fechahora_creacion_ani5
$minparapodereliminar=$row_Recordset111['max_minutos_eliminar']*60;
$datetime7 = strtotime('+0 hour', strtotime($row_Recordset111['fechahora_creacion_ani5']));
$datetime7 = $datetime7+$minparapodereliminar;
$datetime7 = date('Y-m-d H:i:s', $datetime7);
//echo $datetime.' >= '.$datetime7.' 1111<br>';
if($parar==0){
  if($datetime>=$datetime7){
   // echo $datetime.' >= '.$datetime7.' 2222<br>';
  $message=4;
  $parar=1;
  }}




if($parar==0){
if($totalRows_Recordset222>=$row_Recordset111['max_ticket_eliminar']){
$message=3;
$parar=1;
}}









  $minxcerrar=$row_Recordset111['cierre_adelantado']*60;
  $datetime2 = strtotime('+6 hour', strtotime($datetime));
  $datetime2 = $datetime2+$minxcerrar;
  $datetime2 = date('Y-m-d H:i:s', $datetime2);











$query_Recordset1 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\ATreportejugadas_pagos2.php - QUERY 6 */ SELECT 
  *
  FROM
  ani5_jugadas, ani4_solteos, taquilla_opc_ani
  WHERE
  ani5_jugadas.estadojugada_ani5 = 0 AND
  ani5_jugadas.num_ticket_ani5 = %s  AND
  ani5_jugadas.id_solteo_ani5 = ani4_solteos.id_solteo_ani4  AND 
  ani5_jugadas.cod_taquilla_ani5 = taquilla_opc_ani.cod_taquilla  AND 
  ani4_solteos.fechahora_solteo_ani4 > %s
  ORDER BY ani5_jugadas.linea_ticket_ani5 DESC
  ",
    GetSQLValueString($_POST['num_ticket_ani5'], "int"),
    GetSQLValueString($datetime2, "date")
  );
  $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
  $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
  $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
  //echo $totalRows_Recordset1.$_POST['num_ticket_ani5'];


if($parar==0){
  if( $totalRows_Recordset1>0){
    $message=1;
    $insertSQL1monto_total = sprintf(
        "/* PARSEADORES1 Venta_Animalitos\ATreportejugadas_pagos2.php - QUERY 7 */ UPDATE ani5_jugadas
          SET
          mon_pago_ani5=mon_venta_ani5,
          fechahora_pago_ani5=%s,
          ip_pago_ani5=%s,
          estadojugada_ani5=4,
          estado_ticket_ani5=4
          WHERE 
          num_ticket_ani5=%s",
          GetSQLValueString($datetime, "date"),
          GetSQLValueString($ip_ventap, "text"),
      GetSQLValueString($_POST['num_ticket_ani5'], "int")
      );
      
      $Result1monto_total = mysqli_query($conexionbanca, $insertSQL1monto_total) or die(mysqli_error($conexionbanca));
  }else{ $message=2;}}

if($message==1){echo 'se proceso la eliminacion de la jugada de jugada'; }
if($message==2){echo 'No se a procesado la eliminacion recuerde que solo se puede eliminar si la hroa del solteo no a llegado'; }
if($message==3){echo 'No se a procesado la eliminacion ya que se a alcanzado la cantidad maxima de ticket a eliminar en un dia'; }
if($message==4){echo 'No se a procesado la eliminacion ya que se sobrepasaron los minutos permitidos para proceder a la eliminacion desde la creacion del ticket'; }


}
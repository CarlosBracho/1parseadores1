<?php

require_once('../Connections/conexionbanca.php');



$inicioD=fechaactualbd();
$timestamp = strtotime('-3 day', strtotime($inicioD));
$newDate = date("Y-m-d", $timestamp );

$inicio=$newDate;
$final=fechaactualbd();

$iniciof=$newDate.' 00:00:01';
$finalf=fechaactualbd().' 23:59:59';

$query_Recordset13 = sprintf("/* PARSEADORES1 new\parley\tickets_aprobar.php - QUERY 1 */ SELECT *
FROM p4jugadas
WHERE
p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.pverificado = 0 AND
p4jugadas.lineatp4= 1 AND p4jugadas.estadoticketp4 = 1",
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);
?>

<div style="display: none">
<?php
if ($row_Recordset13['estadoticketp4'] == 1 && $row_Recordset13['pverificado '] == 0)  { 
 
  $msj= 'Hay uno o mas Ticket por Aprobar en el Sistema en total: '. $totalRows_Recordset13;
  $msjx=utf8_encode($msj);
  $post=[
  'chat_id'=>-1001639542248,
  'text'=>$msjx,
  ];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_exec ($ch);
  curl_close ($ch);
}
?>
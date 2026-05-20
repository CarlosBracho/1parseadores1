<?php
if (!isset($_SESSION)){session_start();} require_once('../Connections/conexionbanca.php');
$horasistema=horaactual();
$fechasistema=fechaactualbd();
echo $horasistema.' hora actual';
echo '</br>';
$date = new DateTime();
//echo $date->format('H:i:s').'2';
//echo '</br>';
$date->modify('-60 second');
$hora30=$date->format('H:i:s');
echo $hora30.' hora -30 segundos';
echo '</br>';



if ($horasistema>="05:30:00" && $horasistema<="17:00:00") {
$query_Recordset1 = sprintf("/* PARSEADORES1 includes\alerta_mtp_twinspires_cierre.php - QUERY 1 */ SELECT 
		al.Idalertas, al.hor_alerta
	FROM alertas al
	WHERE	al.Idalertas=5 AND
    al.fec_alerta=%s AND 
    al.hor_alerta<%s ",
GetSQLValueString($fechasistema, "date"),
GetSQLValueString($hora30, "date"));  
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo '</br>';
echo $totalRows_Recordset1;

if ($totalRows_Recordset1>=1) {



    $msj="Cerrador Twinspire no se esta ejecutanto" . "\n";
    $msjx=utf8_encode($msj);
    $post=[
        'chat_id'=>-214345883,
        'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec ($ch);
    curl_close ($ch);
    
    
    echo "Cerrador Twinspire no se esta ejecutanto";
    
}}


?>











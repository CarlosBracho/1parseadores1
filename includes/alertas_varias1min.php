<?php
// 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();





//inicio alerta temporal de cookie twispire
$query_Recordset111 = sprintf("/* PARSEADORES1 includes\alertas_varias1min.php - QUERY 1 */ SELECT * 
	FROM 
	cookies 
	WHERE
    id_cookie = 1 AND cookinombre = %s
    LIMIT 1",
	GetSQLValueString("twinspire", "text"));   
$Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
$row_Recordset111 = mysqli_fetch_assoc($Recordset111);
$totalRows_Recordset111 = mysqli_num_rows($Recordset111);

$query_Recordsetprueba = sprintf("/* PARSEADORES1 includes\alertas_varias1min.php - QUERY 2 */ SELECT *  
                FROM alertas
                WHERE
                Idalertas = 12"
                );
                $Recordsetprueba = mysqli_query($conexionbanca, $query_Recordsetprueba) or die(mysqli_error($conexionbanca));
                $row_Recordsetprueba = mysqli_fetch_assoc($Recordsetprueba);
                $totalRows_Recordsetprueba = mysqli_num_rows($Recordsetprueba);


if($horaTxt>'00:00:01' && $horaTxt<'17:00:00'){
if(strlen($row_Recordset111['cookiefull'])<20){
//$row_Recordset111['cookiefull']
if ($row_Recordsetprueba['pausa']==0) { 
$msj="twinspire sin cookie manual por favor agreguelo";
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
}else {
    
}

}
}


//fin alerta temporal de cookie twispire

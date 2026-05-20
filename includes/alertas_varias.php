<?php
// 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();


//esta alerta trata sobre la carga en el sistema avisara cuando el sistema este pon encima del 100%

$carga = sys_getloadavg();
//echo $carga[0];
//var_dump($carga);


if ($carga[0] > 15.01) {
echo "Servidor sobrecargado<br>";
$msj="El servidort esta sobregardo en ".$carga[0];
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
} else { echo "Servidor funciona bien sin sobrecarga<br>";}
echo "<br>";

// esta alerta es para saber el procentaje de espacio que le queda a cada unidad


$df=shell_exec('df').' df ';
$dfi=shell_exec('df -i').' df ';
$dfall=$df.$dfi;
//echo $dfall;
echo "<br>";
$y = 0;
$yy = 0;
$x = 75;
do {
//echo "The number is: $x% <br>";
$procentaje=$x.'%';
if (strlen(stristr($dfall, $procentaje))>0) {

    
   echo "<br>";
   $yy=$x;
   $y++;
}


$x++;
} while ($x <= 100);
if($y>0){ 
    echo "Una unidad esta por llenarse"; 
    $msj="Una unidad esta por llenarse esta al $yy%";
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



} else{ 
    echo "Las unidades tiene espacio suficiente22222";

}
echo "<br>";
//fin de esta alerta esta alerta es para saber el procentaje de espacio que le queda a cada unidad
// alerta WiningBet.php no ejecutandoce desde hace 30minutos o mas

if($horaTxt>'00:00:01' && $horaTxt<'17:00:00'){
$horaTxt=horaactual(); $FechaTxt=fechaactualbd(); $fechahora=$FechaTxt.' '.$horaTxt;
$nuevahora11 = strtotime('-15 minutes', strtotime($fechahora)) ;
$nuevahora = date('H:i:s', $nuevahora11);
$nuevafecha = date('Y-m-d', $nuevahora11);
$nuevafechayhora=date('Y-m-d H:i:s', $nuevahora11);
echo $nuevahora.' '.$nuevafecha.'<br>';
$query_Recordset1 = sprintf("/* PARSEADORES1 includes\alertas_varias.php - QUERY 1 */ SELECT *  
FROM alertas
WHERE
Idalertas = 7 AND 
timestamp_alertas < %s",
GetSQLValueString($nuevafechayhora, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

echo '<br>'.$totalRows_Recordset1.' total rows';
if($totalRows_Recordset1 > 0){

if ($row_Recordset1['pausa'] == 0) {
        
    $msj="WiningBet.php no ejecutandoce correstamente desde hace 15 minutos o mas";
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
// finde esta alerta alerta WiningBet.php no ejecutandoce desde hace 15 minutos o mas
 

//inicio alerta maradeportes logros
if($horaTxt>'00:00:01' && $horaTxt<'17:00:00'){


    $horaTxt=horaactual(); $FechaTxt=fechaactualbd(); $fechahora=$FechaTxt.' '.$horaTxt;
    $nuevahora11 = strtotime('-15 minutes', strtotime($fechahora)) ;
    $nuevahora = date('H:i:s', $nuevahora11);
    $nuevafecha = date('Y-m-d', $nuevahora11);
$nuevafechayhora=date('Y-m-d H:i:s', $nuevahora11);
    echo $nuevahora.' '.$nuevafecha.'<br>';

  echo  'si se ejecuto alerta';
$query_Recordset1 = sprintf("/* PARSEADORES1 includes\alertas_varias.php - QUERY 2 */ SELECT *  
FROM alertas
WHERE
Idalertas = 10 AND 
timestamp_alertas < %s",
GetSQLValueString($nuevafechayhora, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo $nuevahora;
echo '<br>'.$totalRows_Recordset1.' total rows';
if($totalRows_Recordset1 > 0){

    $msj="MaradeportesLogros no ejecutandoce correstamente desde hace 15 minutos o mas";
$msjx=utf8_encode($msj);
$post=[
'chat_id'=>-214345883,
'text'=>$msjx,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5218437625:AAHpDKAOQ3Nv-UZD9F_FtIFn9f7sRWLDpsw/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
curl_close ($ch);



}







}
//fin alerta maradeportes logros

//inicio alerta temporal de cookie twispire
$query_Recordset111 = sprintf("/* PARSEADORES1 includes\alertas_varias.php - QUERY 3 */ SELECT * 
	FROM 
	cookies
	WHERE
    id_cookie = 1 AND cookinombre = %s
    LIMIT 1",
	GetSQLValueString("twinspire", "text"));   
$Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
$row_Recordset111 = mysqli_fetch_assoc($Recordset111);
$totalRows_Recordset111 = mysqli_num_rows($Recordset111);

$query_Recordsetprueba = sprintf("/* PARSEADORES1 includes\alertas_varias.php - QUERY 4 */ SELECT *  
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

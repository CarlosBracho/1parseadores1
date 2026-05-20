<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');


  function resta($inicio, $fin)
  {
      $dif=date("H:i:s", strtotime("00:00:00") + strtotime($fin) - strtotime($inicio));
      return $dif;
  }


$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\carreranoconfirmada.php - QUERY 1 */ SELECT * 
	FROM 
	hipodromo,
	carrera 
	WHERE
	hipodromo.nom_hipodromo = carrera.nom_hipodromo AND
	carrera.est_confirmacion = 1 AND
	carrera.est_carrera = 0 AND 
	carrera.fec_carrera=%s 
	ORDER BY carrera.hor_carrera ASC LIMIT 1",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$inicio=$row_Recordset1['hor_carrera'];
$fin=$horasistema;
$diferencia=resta($inicio, $fin);


if ($totalRows_Recordset1>7  && $diferencia>"00:10:00" && $horasistema<="17:00:00") {
    $msj="HAY UNA CARRERA QUE NO SE QUIERE CONFIRMAR POR FAVOR REVISALA" . "\n";
    $msj.= "HIPODROMO: " . $row_Recordset1['nom_hipodromo'] . "\n";
    $msj.= "NUMERO DE CARRERA: " . $row_Recordset1['num_carrera'] . "\n";
    $msj.= "TIEMPO SIN CONFIRMARSE: " . $diferencia . "\n";
    $msj.="REVISA EN ESTA PAGINA SI ES CARRERA DE CABALLOS O CARRETAS" . "\n";
    $msj.= "http://basic.tvg.com/Open/RaceInformation/CurrentOddsResults.aspx" . "\n";
    $msj.="REVISA EN ESTA PAGINA SI ES CARRERA DE GALGOS SOLO LAS DE GALGOS LAS DEMAS NO LAS REVISEN AQUI" . "\n";
    $msj.= "https://bab2ghc.usofftrack.com/Default.aspx?utm_source=bab&utm_medium=link&utm_campaign=choice4cln" . "\n";
    $msj.="CONFIRMA SI SABES METER HASTA LOS DIVIDENDOS DE LAS EXOTICAS SI NO AVISA Y QUE TE EXPLIQUEN Y RECUERDA MANDAR UN CAPTURE A CARLOS PARA QUE TE CONFIRME QUE ESTA BIEN" . "\n";
    $msjx=utf8_encode($msj);
    $post=[
    'chat_id'=>-1001639542248,
    'text'=>$msjx,
];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_exec($ch);
    curl_close($ch);
}


mysqli_free_result($Recordset1);

?>


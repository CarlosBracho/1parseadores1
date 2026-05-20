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
    "/* PARSEADORES1 includes\alerta_carreracerrandoceyabriendoce.php - QUERY 1 */ SELECT * 
	FROM 
	hipodromo,
	carrera 
	WHERE
	hipodromo.nom_hipodromo = carrera.nom_hipodromo AND
	carrera.est_confirmacion = 1 AND
	carrera.contador_cierres > 4 AND
	(carrera.est_cierre = 1 OR carrera.est_cierre = 2) AND 
	carrera.fec_carrera=%s 
	ORDER BY carrera.hor_carrera ASC LIMIT 0, 50",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


$inicio=$row_Recordset1['hor_carrera'];
$fin=$horasistema;
$diferencia=resta($inicio, $fin);
$contador_cierres=$row_Recordset1['contador_cierres'];


if ($totalRows_Recordset1>0 && $horasistema<="17:00:00") {
    $msj=" REPORTARLO YA HAY UNA CARRERA QUE SE ESTA CERRANDO Y ABRIENDO HAY QUE REPORTALO POR TODOS LOS MEDIOS A CARLOS" . "\n";
    $msj.= "HIPODROMO: " . $row_Recordset1['nom_hipodromo'] . "\n";
    $msj.= "NUMERO DE CARRERA: " . $row_Recordset1['num_carrera'] . "\n";
    $msj.= "CANTIDAD DE VECES SE A CERRADO: " . $contador_cierres . "\n";
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


<?php
require_once('../Connections/conexionbanca.php');
$hoy=fechaactualbd();
$horasistema=horaactual();
  if ($horasistema>'04:00:00' && $horasistema<="11:00:00") {
      $query_Recordset1 = sprintf(
          "/* PARSEADORES1 new\includes\alerta_programar_carreras_auto_twinsolo.php - QUERY 1 */ SELECT * FROM alertas  WHERE  fec_alerta=%s AND Idalertas=%s",
          GetSQLValueString($hoy, "date"),
          GetSQLValueString(4, "int")
      );
      $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
      $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
      $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    
      if ($totalRows_Recordset1<1) {
          $msj=" No se crearon algunas carreras por favor reporte esto lo antes posible" . "\n";
          $msjx=utf8_encode($msj);
          $post=[
    'chat_id'=>-214345883,
    'text'=>$msjx,
];
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
          curl_setopt($ch, CURLOPT_TIMEOUT, 30);
          curl_exec($ch);
          curl_close($ch);
      }
  }

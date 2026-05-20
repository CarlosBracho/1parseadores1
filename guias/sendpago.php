<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="description" content="americanas nacionales online sistema online de alquiler para ventas deportivas hipicas">
<meta name="keywords" content="americanassistema online, sistema nacioanles, sistema online de alquiler para ventas deportivas hipicas">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Refresh" content="7;url=./registro_de_pago.php">
<link rel="shortcut icon" href="images/favicon.ico">
<title>Apuestas Hi�picas</title>
<style type="text/css">body {font-family: Verdana, Geneva, sans-serif;color:#FFF;font-size:15px;font-weight:bold;background-color:#000;margin-left:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;}</style>
</head>
<body>
<CENTER>

<?php
if (isset($_POST['cliente'])) {
    if (!isset($_POST['cliente']) ||
!isset($_POST['banco']) ||
!isset($_POST['recibo']) ||
!isset($_POST['montodepositado']) ||
!isset($_POST['telefono']) ||
!isset($_POST['comentario'])) {
        echo "<b>Ocurri� un error y el formulario no ha sido enviado. </b><br />";
        echo "Por favor, vuelva atr�s y verifique la informaci�n ingresada<br />";
        die();
    }

    $email_message = "Detalles del formulario de contacto:\n\n";
    $email_message .= "Cliente: " . $_POST['cliente'] . "\n";
    $email_message .= "Banco Desde Donde Transfirio: " . $_POST['banco'] . "\n";
    $email_message .= "Numero Del Recibo: " . $_POST['recibo'] . "\n";
    $email_message .= "Monto Depositado: " . $_POST['montodepositado'] . "\n";
    $email_message .= "Telefono: " . $_POST['telefono'] . "\n";
    $email_message .= "Comentarios: " . $_POST['comentario'] . "\n\n";
    $email_messagex=utf8_encode($email_message);

    $post=[
    'chat_id'=>138894409,
    'text'=>$email_messagex,
];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_exec($ch);
    curl_close($ch);


    $post=[
    'chat_id'=>-194026641,
    'text'=>$email_messagex,
];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_exec($ch);
    curl_close($ch);


    echo "�El formulario se ha enviado con �xito!";
}




?>

<tr>
    <td height="26" colspan="2" align="center" valign="middle" bgcolor="#151515" style="font-size:10px; font-family: Tahoma, Geneva, sans-serif"><br/><br/><br/>© Copyright 2012. Apuestas1 Hípicas</td>
  </tr>
</CENTER>
</BODY></HTML>
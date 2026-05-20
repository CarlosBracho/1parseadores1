<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu");
$desde=$_POST["nom_usuario_chat"];
$para="Soporte";
$taquilla=$_POST["cod_taquilla_chat"];
$mensaje=$_POST["txtMensaje"];
if ($mensaje!="") {
    $insertSQL = sprintf(
        "/* PARSEADORES1 new\ventas\ventas_chat_enviar.php - QUERY 1 */ INSERT INTO chat2 (from1, to1, message, sentdate, senttime, recd, tipo, id_taquilla) 
			VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString(strtoupper(trim($desde)), "text"),
        GetSQLValueString(trim($para), "text"),
        GetSQLValueString(trim($mensaje), "text"),
        GetSQLValueString(fechaactualbd(), "date"),
        GetSQLValueString(horaactual(), "date"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString($taquilla, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
}
?>



<?php
require_once('../Connections/conexionbanca.php');
$desde=$_POST["nom_usuario_chat"];
$para="Soporte";
$mensaje=$_POST["txtMensaje"];
if ($mensaje!="") {
    $insertSQL = sprintf(
        "/* PARSEADORES1 chat_ad\chat_enviarag.php - QUERY 1 */ INSERT INTO chat7 (from1, to1, message, sentdate, senttime, recd, tipo) 
			VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString(strtoupper(trim($desde)), "text"),
        GetSQLValueString(trim($para), "text"),
        GetSQLValueString(trim($mensaje), "text"),
        GetSQLValueString(fechaactualbd(), "date"),
        GetSQLValueString(horaactual(), "date"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(0, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
}
?>



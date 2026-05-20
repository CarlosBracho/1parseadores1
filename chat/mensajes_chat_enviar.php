<?php
date_default_timezone_set("America/Puerto_Rico");
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (isset($_POST["comment"]) && isset($_POST["from1"]) && isset($_POST["to1"]) &&
    trim($_POST["comment"])!="" && trim($_POST["from1"])!="" && trim($_POST["to1"])!="") {
    $hora=horaactual();
    $insertSQL = sprintf(
        "/* PARSEADORES1 chat\mensajes_chat_enviar.php - QUERY 1 */ INSERT INTO chat (from1, to1, message, sentdate, senttime, recd) 
			VALUES (%s, %s, %s, %s, %s, %s)",
        GetSQLValueString(trim($_POST["from1"]), "text"),
        GetSQLValueString(trim($_POST["to1"]), "text"),
        GetSQLValueString(trim($_POST["comment"]), "text"),
        GetSQLValueString(fechaactualbd(), "date"),
        GetSQLValueString($hora, "date"),
        GetSQLValueString(1, "int")
    );
    $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    echo horaampm($hora)."&nbsp;";
}

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$_POST["txtMensaje"]=trim($_POST["txtMensaje"]);
date_default_timezone_set("Pacific/Honolulu");
$timestamp = date("Y-m-d H:i:s");
if ($_POST["txtMensaje"]!="") {
    $fec=fechaactualbd();
    $query_Recordset11 = sprintf(
        "/* PARSEADORES1 includes\mensajes_chat_enviar_hnac.php - QUERY 1 */ SELECT id FROM chat 
				WHERE 
				sentdate=%s AND from1=%s",
        GetSQLValueString($fec, "date"),
        GetSQLValueString(trim($_POST["para"]), "text")
    );
    $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
    $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
    $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
    if ($totalRows_Recordset11>0) {
        do {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 includes\mensajes_chat_enviar_hnac.php - QUERY 2 */ UPDATE chat 
						SET recd=%s
						WHERE id=%s",
                GetSQLValueString(0, "int"),
                GetSQLValueString($row_Recordset11['id'], "int")
            );
            
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } while ($row_Recordset11 = mysqli_fetch_assoc($Recordset11));
    }
    mysqli_free_result($Recordset11);
    $insertSQL = sprintf(
        "/* PARSEADORES1 includes\mensajes_chat_enviar_hnac.php - QUERY 3 */ INSERT INTO chat (from1, to1, message, sentdate, senttime, recd, tipo, id_taquilla) 
			VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString(trim($_POST["desde"]), "text"),
        GetSQLValueString(trim($_POST["para"]), "text"),
        GetSQLValueString(trim($_POST["txtMensaje"]), "text"),
        GetSQLValueString(fechaactualbd(), "date"),
        GetSQLValueString(horaactual(), "date"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(2, "int"),
        GetSQLValueString($_POST["id_taquilla"], "int")
    );
    
    $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
}

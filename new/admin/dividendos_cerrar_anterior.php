<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodCarrera = "0";
if (isset($_GET["recordID"])) {
    $xCodCarrera = $_GET["recordID"];
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
        $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
    $insertSQL = sprintf(
        "/* PARSEADORES1 new\admin\dividendos_cerrar_anterior.php - QUERY 1 */ UPDATE
						carrera 
						SET
						est_carrera=%s
						WHERE cod_carrera=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($xCodCarrera, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    $tipoProceso=2;
    $cod_carrera=$xCodCarrera;
    if (is_file('../includes/procesar_resultados_tickets_ame.php')) {
        include("../includes/procesar_resultados_tickets_ame.php");
    }
    $insertGoTo = "dividendos_lista.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}

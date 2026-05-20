<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodRetirado = "0";
if (isset($_GET["recordID"])) {
    $xCodRetirado = $_GET["recordID"];
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
        $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
    $insertSQL = sprintf(
        "/* PARSEADORES1 admin_hnac\caballos_reintegrar_hnac.php - QUERY 1 */ UPDATE
						inscritos 
						SET
						est_inscrito_hnac=%s
						WHERE cod_inscrito_hnac=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString($xCodRetirado, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    $car=$_GET["codCarr"];
    $reintegro[0]=$_GET["numCab"];
    include('../includes/procesar_ticket_reintegraret_hnac.php');
    $insertGoTo = "caballos_lista_hnac.php";
    header(sprintf("Location: %s", $insertGoTo));
}

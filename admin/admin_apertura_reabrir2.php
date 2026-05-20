<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xReabrirCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xReabrirCarrera_Recordset1 = $_GET["recordID"];
}

$query_Recordset1 = sprintf("/* PARSEADORES1 admin\admin_apertura_reabrir2.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", GetSQLValueString($xReabrirCarrera_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$nom_hipodro=$row_Recordset1['nom_hipodromo'];
$num_carrera=$row_Recordset1['num_carrera'];
$nom_usuario=$_SESSION['MM_nom_usuario'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$statuscarrera=1;
$statuscierre=2;
$hora = horaactual2();
$min = "00:04:00";
$horaapertura=SumaHoras($hora, $min);
$mtp_control=0;
$updateSQL = sprintf(
    "/* PARSEADORES1 admin\admin_apertura_reabrir2.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, mtp_control=%s, est_carrera=%s, est_cierre=%s 
				WHERE cod_carrera=%s",
    GetSQLValueString($horaapertura, "date"),
    GetSQLValueString($horaapertura, "date"),
    GetSQLValueString($mtp_control, "int"),
    GetSQLValueString($statuscarrera, "int"),
    GetSQLValueString($statuscierre, "int"),
    GetSQLValueString($xReabrirCarrera_Recordset1, "int")
);
$Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
$fechaactual=fechaactualbd();
$descripcion="REABIERTA MANUALMENTE 1 minuto CARRERA <strong>".$nom_hipodro." Carr...".$num_carrera."</strong> por: <u>".$nom_usuario."</u>";
$insertSQL2 = sprintf(
    "/* PARSEADORES1 admin\admin_apertura_reabrir2.php - QUERY 3 */ INSERT 
				INTO bitacora 
				(des_bitacora, hor_bitacora, fec_bitacora) 
				VALUES (%s, %s, %s)",
    GetSQLValueString($descripcion, "text"),
    GetSQLValueString($hora, "date"),
    GetSQLValueString($fechaactual, "date")
);
$Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
$updateGoTo = "admin_apertura_lista.php";
if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
}
mysqli_free_result($Recordset1);
header(sprintf("Location: %s", $updateGoTo));

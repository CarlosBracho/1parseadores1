<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xReabrirCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xReabrirCarrera_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\admin_apertura_reabrir.php - QUERY 1 */ SELECT nom_hipodromo, num_carrera, mtp_control FROM carrera 
WHERE carrera.cod_carrera = %s LIMIT 1", GetSQLValueString($xReabrirCarrera_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$nom_hipodro=$row_Recordset1['nom_hipodromo'];
$num_carrera=$row_Recordset1['num_carrera'];
$query_Recordset2 = sprintf(
    "/* PARSEADORES1 new\admin\admin_apertura_reabrir.php - QUERY 2 */ SELECT bus_auto FROM hipodromo 
WHERE nom_hipodromo = %s OR nom_hipodromo_hpi = %s OR nom_hipodromo_sup = %s OR nom_hipodromo_rac = %s LIMIT 1",
    GetSQLValueString($nom_hipodro, "text"),
    GetSQLValueString($nom_hipodro, "text"),
    GetSQLValueString($nom_hipodro, "text"),
    GetSQLValueString($nom_hipodro, "text")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$mtp_control=$row_Recordset2['bus_auto'];
$nom_usuario=$_SESSION['MM_nom_usuario'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$statuscarrera=1;
$statuscierre=2;
$hora = horaactual2();
$m=abs($_GET["tempo"]);
$min = "00:0".$m.":00";
if ($_GET["tempo"]<0) {
    $horaapertura=MenosHoras($hora, $min);
    $mens1="DISMINUCION DE ".$m."min ";
} else {
    $horaapertura=SumaHoras($hora, $min);
    $mens1="AUMENTO DE ".$m."min ";
}
if ($_GET["mControl"]==0) {
    $mens2="<font color='red'> MTP MANUAL</font>";
    $mtp_control=3;
}
if ($_GET["mControl"]==1 && $mtp_control=2) {
    $mens2="<font color='green'> MTP AUTOMATICO</font>";
} else {
    $mens2="<font color='red'> MTP MANUAL</font>";
    $mtp_control=3;
}

$updateSQL = sprintf(
    "/* PARSEADORES1 new\admin\admin_apertura_reabrir.php - QUERY 3 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, mtp_control=%s, est_carrera=%s, est_cierre=%s 
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
$descripcion=$mens1."CARRERA <strong>".$nom_hipodro." Carr...".$num_carrera."</strong> por: <u>".$nom_usuario."</u>".$mens2;
$insertSQL2 = sprintf(
    "/* PARSEADORES1 new\admin\admin_apertura_reabrir.php - QUERY 4 */ INSERT 
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
if (isset($Recordset1)) {
    mysqli_free_result($Recordset1);
}
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
header(sprintf("Location: %s", $updateGoTo));

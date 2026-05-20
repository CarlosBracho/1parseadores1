<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventashnac_mie\carrera_cierre_hnac.php - QUERY 1 */ SELECT 
		carrera_hnac.cod_carrera_hnac,
		carrera_hnac.num_carrera_hnac,
		hipodromo_hnac.nom_hipodromo_hnac
		FROM 
			carrera_hnac, 
			hipodromo_hnac 
		WHERE 
		carrera_hnac.cod_carrera_hnac = %s AND
		carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac",
    GetSQLValueString($xCarrera_Recordset1, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$nom_hipodro=$row_Recordset1['nom_hipodromo_hnac'];
$num_carrera=$row_Recordset1['num_carrera_hnac'];
$nom_usuario=$_SESSION['MM_nom_usuario'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
  $descripcion="CERRADA MANUALMENTE <strong>".$nom_hipodro." Carr...".$num_carrera." (NAC)</strong> por: <u>".$nom_usuario."</u>";
  $horaactual=horaactual();
  $fechaactual=fechaactualbd();
  $_POST['est_carrera']=0;
  $_POST['est_cierre']=1;
  $_POST['cod_carrera']=$xCarrera_Recordset1;
  $mtp_control=0;
  $updateSQL = sprintf(
      "/* PARSEADORES1 ventashnac_mie\carrera_cierre_hnac.php - QUERY 2 */ UPDATE 
  			carrera_hnac 
			SET 
			est_carrera_hnac=%s, 
			est_cierre_hnac=%s, 
			mtp_control_hnac=%s, 
			hor_carrera_hnac=%s 
			WHERE 
			cod_carrera_hnac = %s",
      GetSQLValueString($_POST['est_carrera'], "int"),
      GetSQLValueString($_POST['est_cierre'], "int"),
      GetSQLValueString($mtp_control, "int"),
      GetSQLValueString($horaactual, "date"),
      GetSQLValueString($_POST['cod_carrera'], "int")
  );
  $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
  $insertSQL2 = sprintf(
      "/* PARSEADORES1 ventashnac_mie\carrera_cierre_hnac.php - QUERY 3 */ INSERT 
					INTO bitacora 
					(des_bitacora, hor_bitacora, fec_bitacora) 
					VALUES (%s, %s, %s)",
      GetSQLValueString($descripcion, "text"),
      GetSQLValueString($horaactual, "date"),
      GetSQLValueString($fechaactual, "date")
  );
  $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
  $updateGoTo = "index.php";
  mysqli_free_result($Recordset1);
  if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

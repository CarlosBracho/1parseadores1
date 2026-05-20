<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$_POST['rA'] = "0";
if (isset($_GET["recordID"])) {
    $_POST['rA'] = $_GET["recordID"];
}
$query_Recordset10 = sprintf(
    "/* PARSEADORES1 admin_hnac\admin_apertura_cancelar_hnac.php - QUERY 1 */ SELECT hi.nom_hipodromo_hnac, ca.num_carrera_hnac, ca.fec_carrera_hnac 
FROM carrera_hnac ca, hipodromo_hnac hi 
WHERE ca.cod_carrera_hnac = %s AND ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac LIMIT 1",
    GetSQLValueString($_POST['rA'], "int")
);
$Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
$row_Recordset10 = mysqli_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysqli_num_rows($Recordset10);
$nom_hipodro=$row_Recordset10['nom_hipodromo_hnac'];
$num_carrera=$row_Recordset10['num_carrera_hnac'];
$nom_usuario=$_SESSION['MM_nom_usuario'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
  $horaactual=horaactual();
  $updateSQL = sprintf(
      "/* PARSEADORES1 admin_hnac\admin_apertura_cancelar_hnac.php - QUERY 2 */ UPDATE carrera_hnac 
		SET 
		est_carrera_hnac=%s, 
		est_cierre_hnac=%s, 
		est_confirmacion_hnac=%s, 
		hor_carrera_hnac=%s 
		WHERE cod_carrera_hnac=%s",
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(1, "int"),
      GetSQLValueString($horaactual, "date"),
      GetSQLValueString($_POST['rA'], "int")
  );
  $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
  $descripcion="CANCELADA <strong>".$nom_hipodro." Carr...".$num_carrera."</strong> por: <u>".$nom_usuario."</u>";
  $horaactual=horaactual();
  $fechaactual=fechaactualbd();
  $insertSQL2 = sprintf(
      "/* PARSEADORES1 admin_hnac\admin_apertura_cancelar_hnac.php - QUERY 3 */ INSERT 
					INTO bitacora 
					(des_bitacora, hor_bitacora, fec_bitacora) 
					VALUES (%s, %s, %s)",
      GetSQLValueString($descripcion, "text"),
      GetSQLValueString($horaactual, "date"),
      GetSQLValueString($fechaactual, "date")
  );
  $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
  if (is_file('../includes/procesar_ticket_cancelar_hnac.php')) {
      include("../includes/procesar_ticket_cancelar_hnac.php");
  }
  echo " Proceso de cálculo culminado!<br/>";
  $updateGoTo = "admin_apertura_lista_hnac.php";
  mysqli_free_result($Recordset10);
  if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  if (isset($_GET["control"])) {
      $_GET["control"]=0;
  } elseif (isset($_GET["eM"])) {
      echo "<font color='#FF0000'>CARRERA CANCELADA!</font>";
  } else {
      header(sprintf("Location: %s", $updateGoTo));
  }

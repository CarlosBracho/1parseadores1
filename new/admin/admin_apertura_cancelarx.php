<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\admin_apertura_cancelarx.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", GetSQLValueString($xCarrera_Recordset1, "int"));
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
  $horaactual=horaactual();
  $_POST['est_carrera']=0;
  $_POST['est_cierre']=0;
  $_POST['est_confirmacion']=0;
  $_POST['cod_carrera']=$xCarrera_Recordset1;
  $updateSQL = sprintf(
      "/* PARSEADORES1 new\admin\admin_apertura_cancelarx.php - QUERY 2 */ UPDATE carrera 
							SET 
							est_carrera=%s, 
							est_cierre=%s, 
							est_confirmacion=%s, 
							hor_carrera=%s, 
							eje_primero=%s, 
							div_primero_gan=%s, 
							div_primero_pla=%s, 
							div_primero_sho=%s, 
							eje_segundo=%s, 
							div_segundo_pla=%s, 
							div_segundo_sho=%s, 
							eje_tercero=%s, 
							div_tercero_sho=%s, 
							eje_doble_primero=%s, 
							div_doble_primero_gan=%s, 
							div_doble_primero_pla=%s, 
							div_doble_primero_sho=%s, 
							eje_doble_segundo=%s, 
							div_doble_segundo_pla=%s, 
							div_doble_segundo_sho=%s, 
							eje_doble_tercero=%s, 
							div_doble_tercero_sho=%s, 
							eje_triple_primero=%s, 
							div_triple_primero_gan=%s, 
							div_triple_primero_pla=%s, 
							div_triple_primero_sho=%s, 
							eje_triple_segundo=%s, 
							div_triple_segundo_pla=%s, 
							div_triple_segundo_sho=%s, 
							eje_triple_tercero=%s, 
							div_triple_tercero_sho=%s,
							div_exacta=%s,
							fac_exacta=%s,
							div_trifecta=%s,
							fac_trifecta=%s,
							div_superfecta=%s,
							fac_superfecta=%s,
							eje_cuarto=%s,
							eje_doble_cuarto=%s,
							eje_triple_cuarto=%s,
							div_exacta_doble=%s,
							div_exacta_triple=%s,
							div_trifecta_doble=%s,
							div_trifecta_triple=%s,
							div_superfecta_doble=%s,
							div_superfecta_triple=%s,
							ord_exacta=%s,
							ord_exacta_doble=%s,
							ord_exacta_triple=%s,
							ord_trifecta=%s,
							ord_trifecta_doble=%s,
							ord_trifecta_triple=%s,
							ord_superfecta=%s,
							ord_superfecta_doble=%s,
							ord_superfecta_triple=%s
				WHERE cod_carrera=%s",
      GetSQLValueString($_POST['est_carrera'], "int"),
      GetSQLValueString($_POST['est_cierre'], "int"),
      GetSQLValueString($_POST['est_confirmacion'], "int"),
      GetSQLValueString($horaactual, "date"),
      GetSQLValueString(99, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(99, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(99, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString(0, "double"),
      GetSQLValueString("0/0", "text"),
      GetSQLValueString("0/0", "text"),
      GetSQLValueString("0/0", "text"),
      GetSQLValueString("0/0/0", "text"),
      GetSQLValueString("0/0/0", "text"),
      GetSQLValueString("0/0/0", "text"),
      GetSQLValueString("0/0/0/0", "text"),
      GetSQLValueString("0/0/0/0", "text"),
      GetSQLValueString("0/0/0/0", "text"),
      GetSQLValueString($_POST['cod_carrera'], "int")
  );
  $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
  $descripcion="CANCELADA <strong>".$nom_hipodro." Carr...".$num_carrera."</strong> por: <u>".$nom_usuario."</u>";
  $horaactual=horaactual();
  $fechaactual=fechaactualbd();
  $insertSQL2 = sprintf(
      "/* PARSEADORES1 new\admin\admin_apertura_cancelarx.php - QUERY 3 */ INSERT 
					INTO bitacora 
					(des_bitacora, hor_bitacora, fec_bitacora) 
					VALUES (%s, %s, %s)",
      GetSQLValueString($descripcion, "text"),
      GetSQLValueString($horaactual, "date"),
      GetSQLValueString($fechaactual, "date")
  );
  $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
  $updateGoTo = "admin_apertura_lista.php";
  mysqli_free_result($Recordset1);
  if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  if (isset($_GET["control"])) {
      $_GET["control"]=0;
  } elseif (isset($_GET["eM"])) {
      echo "<font color='#FF0000'>CARRERA CERRADA!</font>";
  } else {
      header(sprintf("Location: %s", $updateGoTo));
  }

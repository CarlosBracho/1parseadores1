<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\admin_hnac\admin_apertura_cierre_hnac.php - QUERY 1 */ SELECT 
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
      "/* PARSEADORES1 new\admin_hnac\admin_apertura_cierre_hnac.php - QUERY 2 */ UPDATE 
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
      "/* PARSEADORES1 new\admin_hnac\admin_apertura_cierre_hnac.php - QUERY 3 */ INSERT 
					INTO bitacora 
					(des_bitacora, hor_bitacora, fec_bitacora) 
					VALUES (%s, %s, %s)",
      GetSQLValueString($descripcion, "text"),
      GetSQLValueString($horaactual, "date"),
      GetSQLValueString($fechaactual, "date")
  );
  $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));

  // Alerta automatizada de Telegram por cierre manual de carrera (Nacionales HNAC)
  $tiempo_formateado = date('g:i s') . ' segundos';
  $msj = "el usuario " . $nom_usuario . " mandó a cerrar la carrera " . $num_carrera . " de las nacionales a las " . $tiempo_formateado;

  $post = [
      'chat_id' => -1003755064511,
      'text' => $msj,
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_TIMEOUT, 3);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
  curl_exec($ch);
  curl_close($ch);

  $updateGoTo = "admin_apertura_lista_hnac.php";
  mysqli_free_result($Recordset1);
  if (isset($_SERVER['QUERY_STRING'])) {
      $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
      $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

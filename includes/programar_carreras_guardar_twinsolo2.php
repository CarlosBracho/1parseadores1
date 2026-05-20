<?php
require_once('../Connections/conexionbanca.php');

set_time_limit(100);
$xhip="";
$xcan=0;
$cod_banca=2;
$mensaje1="";
$mensaje2="";
$t=0;
echo $_GET["simulcast"];
if (isset($_GET["cHip"]) && isset($_GET["can"])) {
	$xcan = $_GET["can"];
	$xhse = $_GET["horses"];
	$xpre = $_GET["pre"];
	$xcHip = $_GET["cHip"];
	$simulcast = $_GET["simulcast"];
	//echo $simulcast;
	$query_Recordset1 =  sprintf("/* PARSEADORES1 includes\programar_carreras_guardar_twinsolo2.php - QUERY 1 */ SELECT bus_auto, nom_hipodromo
		FROM  
		hipodromo
		WHERE 
		cod_hipodromo = %s", 
		GetSQLValueString($xcHip, "int"));
	$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
	$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
	$bus_auto=$row_Recordset1['bus_auto'];
	$xhip=$row_Recordset1['nom_hipodromo'];
	$hoy=fechaactualbd();
	if ($xhip!="" && $xcan>0) {
		$simulcastx=explode(",",$simulcast);
		$can_caballos=explode(",",$xhse);
		for ($i = 1; $i <= $xcan; $i++) {
			$hipodomo=$xhip;
			$verif=verificarCarrera($hipodomo,$i,$hoy);
			if ($verif==0) {
				$insertSQL = sprintf("/* PARSEADORES1 includes\programar_carreras_guardar_twinsolo2.php - QUERY 2 */ INSERT INTO carrera 
					(cod_banca,
					cod_hipodromo, 
					nom_hipodromo, 
					nom_hipodromo_hpi, 
					fec_carrera, 
					hor_carrera, 
					hor_mtp, 
					num_carrera, 
					est_carrera, 
					est_cierre, 
					est_confirmacion,  
					mtp_control, 					
					can_caballos, 					
					simulcast) 
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($cod_banca, "int"),
					   GetSQLValueString($xcHip, "int"),
					   GetSQLValueString($xhip, "text"),
					   GetSQLValueString($xhip, "text"),
					   GetSQLValueString($hoy, "date"),
					   GetSQLValueString("01:00:00", "date"),
					   GetSQLValueString("01:00:00", "date"),
					   GetSQLValueString($i, "int"),
					   GetSQLValueString(1, "int"),
					   GetSQLValueString(3, "int"),
					   GetSQLValueString(1, "int"),
					   GetSQLValueString(3, "int"),
					   GetSQLValueString($can_caballos[$i-1], "int"),
					   GetSQLValueString($simulcastx[$i-1], "int"));
				$Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
				$mensaje1="Carrera(s) creadas";
			} else {
				$t++;
				if ($t==1) $mensaje2="una carrera ya ha sido creada anteriormente";
				if ($t>1) $mensaje2="varias carreras ya han sido creadas anteriormente";
				if ($t>=$xcan) $mensaje2="Todas las carreras ya han sido creadas anteriormente";
			}
		}
	}
}
if ($mensaje1!="") echo '<font size="1" face="verdana" color="green">'.$mensaje1.'<br/></font>';
echo '<font size="1" face="verdana" color="red">'.$mensaje2.'</font>';
?>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include('../includes/mtp_funcion.php');
$xhip="";
$xcan=0;
$cod_banca=2;
$mensaje1="";
$mensaje2="";
$t=0;
if (isset($_GET["hip"]) && isset($_GET["can"])) {
    $xhip = $_GET["hip"];
    $xcan = $_GET["can"];
    $xmTn = $_GET["mTn"];
    $xpre = $_GET["pre"];
    $xcHip = $_GET["cHip"];
    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 includes\programar_carreras_guardar_tvg.php - QUERY 1 */ SELECT bus_auto
		FROM  
		hipodromo
		WHERE 
		cod_hipodromo = %s",
        GetSQLValueString($xcHip, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $bus_auto=$row_Recordset1['bus_auto'];
    $result1="http://basic.tvg.com/TVGShared/handlers/Results.ashx?TrackAbbr=";
    $result2="&Performance=";
    $result3="&Tote=PORT&RaceDate=";
    $extResu="&RaceNum=";
    $retira1="http://basic.tvg.com/TVGShared/handlers/CurrentInfo.ashx?TrackAbbr=";
    $extReti="&AddVideoInformation=true";
    $hoy=fechaactualbd();
    if ($xhip!="" && $xcan>0) {
        $hipodomo=$xhip;
        $result=$result1.$xpre.$result2.$xmTn.$result3;
        $retiro=$retira1.$xpre.$result2.$xmTn.$result3;
        $updateSQL = sprintf(
            "/* PARSEADORES1 includes\programar_carreras_guardar_tvg.php - QUERY 2 */ UPDATE hipodromo SET 
 						dir_pagresultado_tvg=%s,
						ext_pagresultado_tvg=%s,
						dir_retirado=%s,
						ext_retirado=%s
					WHERE 
						cod_hipodromo=%s",
            GetSQLValueString($result, "text"),
            GetSQLValueString($extResu, "text"),
            GetSQLValueString($retiro, "text"),
            GetSQLValueString($extReti, "text"),
            GetSQLValueString($xcHip, "int")
        );
        $Result2 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        for ($i = 1; $i <= $xcan; $i++) {
            $hipodomo=$xhip;
            $verif=verificarCarrera($hipodomo, $i, $hoy);
            if ($verif==0) {
                $insertSQL = sprintf(
                    "/* PARSEADORES1 includes\programar_carreras_guardar_tvg.php - QUERY 3 */ INSERT INTO carrera 
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
					can_caballos) 
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($cod_banca, "int"),
                    GetSQLValueString($xcHip, "int"),
                    GetSQLValueString($hipodomo, "text"),
                    GetSQLValueString($xhip, "text"),
                    GetSQLValueString($hoy, "date"),
                    GetSQLValueString("01:00:00", "date"),
                    GetSQLValueString("01:00:00", "date"),
                    GetSQLValueString($i, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString(3, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString(3, "int"),
                    GetSQLValueString(25, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                $mensaje1="Carrera(s) creadas";
            } else {
                $t++;
                if ($t==1) {
                    $mensaje2="una carrera ya ha sido creada anteriormente";
                }
                if ($t>1) {
                    $mensaje2="varias carreras ya han sido creadas anteriormente";
                }
                if ($t>=$xcan) {
                    $mensaje2="Todas las carreras ya han sido creadas anteriormente";
                }
            }
        }
    }
}
if ($mensaje1!="") {
    echo '<font size="1" face="verdana" color="green">'.$mensaje1.'<br/></font>';
}
echo '<font size="1" face="verdana" color="red">'.$mensaje2.'</font>';

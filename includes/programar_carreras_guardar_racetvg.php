<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include('../includes/mtp_funcion.php');
list($hi, $mT, $pr, $ca, $ho, $ti, $co, $codTVG)=programar_carreras_tvg();
$xhip="";
$xcan=0;
$cod_banca=2;
$mensaje1="";
$mensaje2="";
$t=0;
$prefijo="";
$tarNoch="";
$result1="http://basic.tvg.com/TVGShared/handlers/Results.ashx?TrackAbbr=";
$result2="&Performance=";
$result3="&Tote=PORT&RaceDate=";
$extResu="&RaceNum=";
$retira1="http://basic.tvg.com/TVGShared/handlers/CurrentInfo.ashx?TrackAbbr=";
$extReti="&AddVideoInformation=true";
if (isset($_GET["hip"]) && isset($_GET["can"])) {
    $xhip = $_GET["hip"];
    $xcan = $_GET["can"];
    $id = $_GET["id"];
    $hoy=fechaactualbd();
    if ($xhip!="" && $xcan>0) {
        list($cod, $hipodomo, $mtp_control)=buscaHip5($xhip);
        $verif=verificarCarrera2($cod, 1, $hoy);
        if ($verif==0) {
            $acceso=0;
            $z=count($codTVG);
            if ($z>0 && $hi[0]!="" && $cod>0) {
                $ky=0;
                foreach ($codTVG as $chip) {
                    if ($chip==$cod) {
                        $result=$result1.$pr[$ky].$result2.$mT[$ky].$result3;
                        $retiro=$retira1.$pr[$ky].$result2.$mT[$ky].$result3;
                        $prefijo=$pr[$ky];
                        $tarNoch=$mT[$ky];
                        $acceso=1;
                        break;
                    }
                    $ky++;
                }
            }
            if ($acceso==1) {
                $updateSQL = sprintf(
                    "/* PARSEADORES1 includes\programar_carreras_guardar_racetvg.php - QUERY 1 */ UPDATE hipodromo SET 
								dir_pagresultado_tvg=%s,
								ext_pagresultado_tvg=%s,
								dir_retirado=%s,
								ext_retirado=%s,
								cod_pagina_rb=%s
							WHERE 
								cod_hipodromo=%s",
                    GetSQLValueString($result, "text"),
                    GetSQLValueString($extResu, "text"),
                    GetSQLValueString($retiro, "text"),
                    GetSQLValueString($extReti, "text"),
                    GetSQLValueString($id, "text"),
                    GetSQLValueString($cod, "int")
                );
            } else {
                $updateSQL = sprintf(
                    "/* PARSEADORES1 includes\programar_carreras_guardar_racetvg.php - QUERY 2 */ UPDATE hipodromo SET 
  						cod_pagina_rb=%s 
						WHERE 
						cod_hipodromo=%s",
                    GetSQLValueString($id, "text"),
                    GetSQLValueString($cod, "int")
                );
            }
            $Result2 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        }
        for ($i = 1; $i <= $xcan; $i++) {
            list($cod, $hipodomo, $mtp_control)=buscaHip5($xhip);
            if ($mtp_control==-1) {
                $mtp_control=3;
            }
            $verif=verificarCarrera2($cod, $i, $hoy);
            if ($verif==0 && $cod!=-1) {
                $insertSQL = sprintf(
                    "/* PARSEADORES1 includes\programar_carreras_guardar_racetvg.php - QUERY 3 */ INSERT INTO carrera 
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
                    GetSQLValueString($cod, "int"),
                    GetSQLValueString($hipodomo, "text"),
                    GetSQLValueString($xhip, "text"),
                    GetSQLValueString($hoy, "date"),
                    GetSQLValueString("01:00:00", "date"),
                    GetSQLValueString("01:00:00", "date"),
                    GetSQLValueString($i, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString(3, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($mtp_control, "int"),
                    GetSQLValueString(200, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                $mensaje1="Carrera(s) creadas";
            } else {
                $t++;
                if ($cod!==1) {
                    $mensaje2="código de hipódromo no existe";
                } else {
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
}
if ($mensaje1!="") {
    echo '<font size="1" face="verdana" color="green">'.$mensaje1." (".$prefijo.")->".$tarNoch.'<br/></font>';
}
echo '<font size="1" face="verdana" color="red">'.$mensaje2.'</font>';

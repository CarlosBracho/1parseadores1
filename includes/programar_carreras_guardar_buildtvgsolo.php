<?php
require_once('../Connections/conexionbanca.php');

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
        $id = explode("/", $_GET["id"]);
        $idH=$id[0];
        $idP=$id[1];
        $hoy=fechaactualbd();
        $url2='http://bab2ghc.usofftrack.com/data/ProgramDetail.json?sdt='.$hoy.'&aid=&pid='.$idH.'&rid='.$idP.'&init=true';
        $str_datos2 = get_url_contents($url2);
        $fulldatos2 = json_decode($str_datos2, true);
        $h=0;
        $id="";
        foreach ($fulldatos2["Result"]["races"] as $da2) {
            $raceNu[$h]=$fulldatos2["Result"]["races"][$h]["RaceNumber"];
            $Runner[$h]=$fulldatos2["Result"]["races"][$h]["NumberOfRunners"];
            $racePr[$h]=$fulldatos2["Result"]["races"][$h]["ProgramID"];
            $raceId[$h]=$fulldatos2["Result"]["races"][$h]["RaceID"];
            if ($h==0) {
                $id=$racePr[$h]."/".$raceId[$h];
            } else {
                $id=$id."/".$raceId[$h];
            }
            $h++;
        }
        list($cod, $hipodomo, $mtp_control)=buscaHip6($xhip);
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
                    "/* PARSEADORES1 includes\programar_carreras_guardar_buildtvgsolo.php - QUERY 1 */ UPDATE hipodromo SET 
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
                $Result = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
            } else {
                $updateSQL = sprintf(
                    "/* PARSEADORES1 includes\programar_carreras_guardar_buildtvgsolo.php - QUERY 2 */ UPDATE hipodromo SET 
  						cod_pagina_rb=%s 
						WHERE 
						cod_hipodromo=%s",
                    GetSQLValueString($id, "text"),
                    GetSQLValueString($cod, "int")
                );
                $Result = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
            }
        }
        for ($i = 1; $i <= $xcan; $i++) {
            list($cod, $hipodomo, $mtp_control)=buscaHip6($xhip);
            if ($mtp_control==-1) {
                $mtp_control=3;
            }
            $verif=verificarCarrera2($cod, $i, $hoy);
            if ($verif==0 && $cod!=-1) {
                $insertSQL = sprintf(
                    "/* PARSEADORES1 includes\programar_carreras_guardar_buildtvgsolo.php - QUERY 3 */ INSERT INTO carrera 
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
 					mtp_tipo,
					can_caballos) 
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                    GetSQLValueString(3, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString(20, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                $mensaje1="Carrera(s) creada(s)";
            } else {
                $t++;
                if ($cod!=1) {
                    $mensaje2="código de hipódromo no existe /".$xhip;
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
    echo '<font size="1" face="verdana" color="green">'.$mensaje1."(".$prefijo.")>".$tarNoch.'<br/></font>';
}
echo '<font size="1" face="verdana" color="red">'.$mensaje2.'</font>';

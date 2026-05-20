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
    if ($xhip!="" && $xcan>0) {
        list($mtp_control, $hipodomo)=buscaHipBuild5($xhip);
        $verif=verificarCarrera2($xhip, 1, $hoy);
        if ($verif==0 && $mtp_control!=-1) {
            //cod_pagina_rb ahora es para buildabet2
            $updateSQL = sprintf(
                "/* PARSEADORES1 new\includes\programar_carreras_guardar_buildabet2.php - QUERY 1 */ UPDATE hipodromo SET 
  					cod_pagina_rb=%s 
					WHERE 
					cod_hipodromo=%s",
                GetSQLValueString($id, "text"),
                GetSQLValueString($xhip, "int")
            );
            $Result2 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        }
        if ($mtp_control==-1) {
            $mtp_control=3;
        }
        for ($i = 1; $i <= $xcan; $i++) {
            $verif=verificarCarrera2($xhip, $i, $hoy);
            if ($verif==0 && $hipodomo!="") {
                $insertSQL = sprintf(
                    "/* PARSEADORES1 new\includes\programar_carreras_guardar_buildabet2.php - QUERY 2 */ INSERT INTO carrera 
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
                    GetSQLValueString($xhip, "int"),
                    GetSQLValueString(strtoupper($hipodomo), "text"),
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
                if ($hipodomo!==1) {
                    $mensaje2="hipódromo no existe";
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
    echo '<font size="1" face="verdana" color="green">'.$mensaje1.'<br/></font>';
}
echo '<font size="1" face="verdana" color="red">'.$mensaje2.'</font>';

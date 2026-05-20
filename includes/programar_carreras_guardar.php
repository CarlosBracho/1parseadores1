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
    $id = $_GET["id"];
    $hoy=fechaactualbd();
    if ($xhip!="" && $xcan>0) {
        list($cod, $hipodomo, $mtp_control)=buscaHip5($xhip);
        $verif=verificarCarrera2($cod, 1, $hoy);
        if ($verif==0) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 includes\programar_carreras_guardar.php - QUERY 1 */ UPDATE hipodromo SET 
  						cod_pagina_rb=%s 
						WHERE 
						cod_hipodromo=%s",
                GetSQLValueString($id, "text"),
                GetSQLValueString($cod, "int")
            );
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
                    "/* PARSEADORES1 includes\programar_carreras_guardar.php - QUERY 2 */ INSERT INTO carrera 
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
    echo '<font size="1" face="verdana" color="green">'.$mensaje1.'<br/></font>';
}
echo '<font size="1" face="verdana" color="red">'.$mensaje2.'</font>';

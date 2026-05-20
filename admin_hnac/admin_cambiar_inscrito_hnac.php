<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarr = "0";
//var ptos={"xCod":cod,"xCab":cab,"xEst":est,"xCarr":carr,"xFav":sfav,"xCam":camb,"rA":Math.random()};

if (isset($_POST["xCarr"]) && isset($_POST["xCab"]) && isset($_POST["xCam"]) && isset($_POST["xCod"])) {
    $xCod = $_POST["xCod"];
    $xCab = $_POST["xCab"];
    $xEst = $_POST["xEst"];
    $xCarr = $_POST["xCarr"];
    $xFav = $_POST["xFav"];
    $xCam = $_POST["xCam"];
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 admin_hnac\admin_cambiar_inscrito_hnac.php - QUERY 1 */ SELECT cod_carrera_hnac 
				FROM inscritos
				WHERE 
				cod_carrera_hnac = %s AND
				cod_inscrito_hnac = %s LIMIT 1",
        GetSQLValueString($xCarr, "int"),
        GetSQLValueString($xCod, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $grabar=0;
        if ($xFav>0 && $xFav<5) {// establece como favorito
            $xEst=1;
            $query_Recordset2 = sprintf(
                "/* PARSEADORES1 admin_hnac\admin_cambiar_inscrito_hnac.php - QUERY 2 */ SELECT cod_carrera_hnac 
						FROM inscritos
						WHERE 
						cod_carrera_hnac = %s AND
						cod_inscrito_hnac = %s AND
						est_favorito_hnac >= 1 AND
						est_favorito_hnac <= 4 LIMIT 1",
                GetSQLValueString($xCarr, "int"),
                GetSQLValueString($xCod, "int")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2==0 && $xCam>0) {
                $query_Recordset3 = sprintf(
                    "/* PARSEADORES1 admin_hnac\admin_cambiar_inscrito_hnac.php - QUERY 3 */ SELECT cod_carrera_hnac 
							FROM inscritos
							WHERE 
							cod_carrera_hnac = %s AND
							num_caballo_hnac <> %s AND
							est_favorito_hnac = %s LIMIT 1",
                    GetSQLValueString($xCarr, "int"),
                    GetSQLValueString($xCab, "int"),
                    GetSQLValueString($xCam, "int")
                );
                $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                if ($totalRows_Recordset3==0) {
                    $grabar=1;
                } else {
                    echo "ya existe favorito #".$xCam;
                }
            } else {
                echo "ya es favorito";
                $query_Recordset4 = sprintf(
                    "/* PARSEADORES1 admin_hnac\admin_cambiar_inscrito_hnac.php - QUERY 4 */ SELECT cod_carrera_hnac 
							FROM inscritos
							WHERE 
							cod_carrera_hnac = %s AND
							est_favorito_hnac = %s LIMIT 1",
                    GetSQLValueString($xCarr, "int"),
                    GetSQLValueString($xCam, "int")
                );
                $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
                $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
                $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
                if ($totalRows_Recordset4==0) {
                    $grabar=1;
                } else {
                    if ($xCam==0) {
                        $grabar=1;
                    } else {
                        echo " * pero ya hay uno";
                    }
                }
            }
        } else {
            if ($xCam==0) {
                $xEst=0;
                $grabar=1;
                $re=0;
            } //retirar 0 0
            if ($xCam==1) {
                $xCam=0;
                $xEst=1;
                $grabar=1;
                $re=1;
            } //reinteger 1 0
            echo "aquiiiiiiii que yyy pasaria a retiro o reintegro";
        }
        echo " { ".$xEst." - ".$xCam." } ";
        if ($grabar==1) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 admin_hnac\admin_cambiar_inscrito_hnac.php - QUERY 5 */ UPDATE inscritos 
				SET
					est_favorito_hnac=%s,
					est_inscrito_hnac=%s 
				WHERE 
				cod_inscrito_hnac=%s",
                GetSQLValueString($xCam, "int"),
                GetSQLValueString($xEst, "int"),
                GetSQLValueString($xCod, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
            if (isset($re) && $re==0) {//procesa retirados en ticket
                $car=$xCarr;
                include('../includes/procesar_ticket_retirados_hnac.php');
            }
            if (isset($re) && $re==1) {//reintegra retirados en ticket
                $car=$xCarr;
                $reintegro[0]=$xCab;
                include('../includes/procesar_ticket_reintegraret_hnac.php');
            }
        }
    } else {
        echo "REGISTRO NO ENCONTRADO!";
    }
    echo "* Carrera: ".$xCarr." Caballo ".$xCab." Cambiar a:".$xCam." [Retirado:".$xEst;
} else {
    echo "No se produjo ningun resultado!";
}

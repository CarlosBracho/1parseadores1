<?php ?><?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (isset($_POST["codCar"]) && isset($_POST["modo"])) {
    $query_Recordset2 = sprintf("/* PARSEADORES1 new\includes\cambio_mtp_hipodromo.php - QUERY 1 */ SELECT cod_hipodromo, nom_hipodromo FROM hipodromo WHERE cod_hipodromo = %s", GetSQLValueString($_POST["codCar"], "int"));
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    if ($totalRows_Recordset2>0) {
        if ($_POST["modo"]==0) {
            $modo="MODO MANUAL ";
        }
        if ($_POST["modo"]==1) {
            $modo="Super +Watchan +Buil +betbird ";
        }
        if ($_POST["modo"]==2) {
            $modo="Super +Watchan +Buil ";
        }
        if ($_POST["modo"]==3) {
            $modo="Super +Watchan ";
        }
        if ($_POST["modo"]==4) {
            $modo="Super +Buil +betbird ";
        }
        if ($_POST["modo"]==5) {
            $modo="Watchan +Buil +betbird ";
        }
        if ($_POST["modo"]==6) {
            $modo="Buil +Watchan +betbird ";
        }
        if ($_POST["modo"]==7) {
            $modo="Watchan +Buil ";
        }
        if ($_POST["modo"]==8) {
            $modo="WATCHANDWAGER ";
        }
        if ($_POST["modo"]==9) {
            $modo="BUILDABET2 ";
        }
        $nom_usuario=$_SESSION['MM_nom_usuario'];
        $nom_hipodro=$row_Recordset2['nom_hipodromo'];
        
        $updateSQL2 = sprintf(
            "/* PARSEADORES1 new\includes\cambio_mtp_hipodromo.php - QUERY 2 */ UPDATE hipodromo SET bus_auto=%s 
				  WHERE cod_hipodromo=%s",
            GetSQLValueString($_POST["modo"], "int"),
            GetSQLValueString($_POST["codCar"], "int")
        );
        $Result2 = mysqli_query($conexionbanca, $updateSQL2) or die(mysqli_error($conexionbanca));
        $des="CAMBIO A ".$modo."<strong> ".$nom_hipodro."</strong> por: <u>".$nom_usuario."</u> desde módulo hipodromo";
        $insertSQL3 = sprintf(
            "/* PARSEADORES1 new\includes\cambio_mtp_hipodromo.php - QUERY 3 */ INSERT 
						INTO bitacora 
						(des_bitacora, hor_bitacora, fec_bitacora) 
						VALUES (%s, %s, %s)",
            GetSQLValueString($des, "text"),
            GetSQLValueString(horaactual(), "date"),
            GetSQLValueString(fechaactualbd(), "date")
        );
        $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));

        $query_Recordset1 = sprintf("/* PARSEADORES1 new\includes\cambio_mtp_hipodromo.php - QUERY 4 */ SELECT carrera.cod_carrera, carrera.num_carrera, carrera.est_carrera, hipodromo.nom_hipodromo FROM carrera, hipodromo WHERE carrera.cod_hipodromo = %s AND carrera.fec_carrera = %s AND hipodromo.cod_hipodromo = carrera.cod_hipodromo", GetSQLValueString($_POST["codCar"], "int"), GetSQLValueString(fechaactualbd(), "date"));
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        if ($totalRows_Recordset1>0) {
            $s=0;
            do {
                $cod=$row_Recordset1['cod_carrera'];
                $est=$row_Recordset1['est_carrera'];
                $num=$row_Recordset1['num_carrera'];
                if ($est==0) {
                    $modo=$modo." (con estado de carrera CERRADA) ";
                } else {
                    $modo=$modo." (con estado de carrera ABIERTA) ";
                }
                if ($_POST["modo"]>=0 && $_POST["modo"]<=9) {
                    $updateSQL1 = sprintf(
                        "/* PARSEADORES1 new\includes\cambio_mtp_hipodromo.php - QUERY 5 */ UPDATE carrera SET mtp_control=%s 
							  WHERE cod_carrera=%s",
                        GetSQLValueString($_POST["modo"], "int"),
                        GetSQLValueString($cod, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $updateSQL1) or die(mysqli_error($conexionbanca));
                    $des1="CAMBIO A ".$modo."<strong> ".$nom_hipodro." Carr...".$num."</strong> por: <u>".$nom_usuario."</u>";
                    $des2=" desde módulo hipodromo";
                    $des=$des1.$des2;
                    $insertSQL12 = sprintf(
                        "/* PARSEADORES1 new\includes\cambio_mtp_hipodromo.php - QUERY 6 */ INSERT 
									INTO bitacora 
									(des_bitacora, hor_bitacora, fec_bitacora) 
									VALUES (%s, %s, %s)",
                        GetSQLValueString($des, "text"),
                        GetSQLValueString(horaactual(), "date"),
                        GetSQLValueString(fechaactualbd(), "date")
                    );
                    $Result12 = mysqli_query($conexionbanca, $insertSQL12) or die(mysqli_error($conexionbanca));
                }
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        }
    }
}
?>
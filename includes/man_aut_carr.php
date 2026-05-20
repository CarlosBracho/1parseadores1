<?php ?><?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (isset($_POST["codCar"]) && isset($_POST["modo"])) {
    $query_Recordset1 = sprintf("/* PARSEADORES1 includes\man_aut_carr.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", GetSQLValueString($_POST["codCar"], "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $nom_hipodro=$row_Recordset1['nom_hipodromo'];
    $num_carrera=$row_Recordset1['num_carrera'];
    $est_carrera=$row_Recordset1['est_carrera'];
    $nom_usuario=$_SESSION['MM_nom_usuario'];
    if ($_POST["modo"]==0) {
        $modo="MODO MANUAL ";
    }
    if ($_POST["modo"]==1) {
        $modo=" 1 opcion 1";
    }
    if ($_POST["modo"]==2) {
        $modo=" 2 opcion 2";
    }
    if ($_POST["modo"]==3) {
        $modo=" 3 opcion 3";
    }
    if ($_POST["modo"]==4) {
        $modo=" 4 opcion 4";
    }
    if ($_POST["modo"]==5) {
        $modo=" 5 opcion 5";
    }
    if ($_POST["modo"]==6) {
        $modo=" 6 opcion 6";
    }
    if ($_POST["modo"]==7) {
        $modo=" 7 opcion 7";
    }
    if ($_POST["modo"]==8) {
        $modo=" solo WATCHANDWAGER";
    }
    if ($_POST["modo"]==9) {
        $modo=" solo BUILDABET2";
    }
    if ($est_carrera==0) {
        $modo=$modo." (con estado de carrera CERRADA) ";
    } else {
        $modo=$modo." (con estado de carrera ABIERTA) ";
    }
    if ($_POST["modo"]>=0 && $_POST["modo"]<=9) {
        $updateSQL = sprintf(
            "/* PARSEADORES1 includes\man_aut_carr.php - QUERY 2 */ UPDATE carrera SET mtp_control=%s 
				  WHERE cod_carrera=%s",
            GetSQLValueString($_POST["modo"], "int"),
            GetSQLValueString($_POST["codCar"], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $horaactual=horaactual();
        $fechaactual=fechaactualbd();
        $des="CAMBIO A ".$modo."<strong> ".$nom_hipodro." Carr...".$num_carrera."</strong> por: <u>".$nom_usuario."</u>";
        $insertSQL2 = sprintf(
            "/* PARSEADORES1 includes\man_aut_carr.php - QUERY 3 */ INSERT 
						INTO bitacora 
						(des_bitacora, hor_bitacora, fec_bitacora) 
						VALUES (%s, %s, %s)",
            GetSQLValueString($des, "text"),
            GetSQLValueString($horaactual, "date"),
            GetSQLValueString($fechaactual, "date")
        );
        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
    }
}
?>
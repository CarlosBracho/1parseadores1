<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (isset($_POST["codCar"]) && isset($_POST["modo"])) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\man_aut_carr_hnac.php - QUERY 1 */ SELECT 
		carrera_hnac.cod_carrera_hnac,
		carrera_hnac.num_carrera_hnac,
		carrera_hnac.est_carrera_hnac,
		hipodromo_hnac.nom_hipodromo_hnac
		FROM 
			carrera_hnac, 
			hipodromo_hnac 
		WHERE 
		carrera_hnac.cod_carrera_hnac = %s AND
		carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac",
        GetSQLValueString($_POST["codCar"], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $nom_hipodro=$row_Recordset1['nom_hipodromo_hnac'];
    $num_carrera=$row_Recordset1['num_carrera_hnac'];
    $est_carrera=$row_Recordset1['est_carrera_hnac'];
    $nom_usuario=$_SESSION['MM_nom_usuario'];
    if ($_POST["modo"]==0) {
        $modo="MANUAL ";
    } else {
        $modo="AUTOMÁTICO ";
    }
    if ($est_carrera==0) {
        $modo=$modo." (con estado de carrera CERRADA) ";
    } else {
        $modo=$modo." (con estado de carrera ABIERTA) ";
    }
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\man_aut_carr_hnac.php - QUERY 2 */ UPDATE carrera_hnac SET mtp_control_hnac=%s 
			  WHERE cod_carrera_hnac=%s",
        GetSQLValueString($_POST["modo"], "int"),
        GetSQLValueString($_POST["codCar"], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    $horaactual=horaactual();
    $fechaactual=fechaactualbd();
    $descripcion="CAMBIO A MODO ".$modo."<strong> ".$nom_hipodro." Carr...".$num_carrera." (NAC) </strong> por: <u>".$nom_usuario."</u>";
    $insertSQL2 = sprintf(
        "/* PARSEADORES1 new\includes\man_aut_carr_hnac.php - QUERY 3 */ INSERT 
					INTO bitacora 
					(des_bitacora, hor_bitacora, fec_bitacora) 
					VALUES (%s, %s, %s)",
        GetSQLValueString($descripcion, "text"),
        GetSQLValueString($horaactual, "date"),
        GetSQLValueString($fechaactual, "date")
    );
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
}

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $car = $_GET["recordID"];
    $deleteSQL = sprintf(
        "/* PARSEADORES1 new\admin_hnac\admin_dividendos_del_hnac.php - QUERY 1 */ DELETE 
		FROM resultados_oficiales_hnac 
		WHERE cod_carrera_hnac = %s",
        GetSQLValueString($car, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $deleteSQL) or die(mysqli_error($conexionbanca));
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\admin_hnac\admin_dividendos_del_hnac.php - QUERY 2 */ UPDATE carrera_hnac 
		SET est_confirmacion_hnac = 0 
		WHERE cod_carrera_hnac=%s",
        GetSQLValueString($car, "int")
    );
    $Result2 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    
    if (is_file('../includes/reintegrar_ticket_hnac.php')) {
        include("../includes/reintegrar_ticket_hnac.php");
    }
    $updateGoTo = "admin_dividendos_lista_hnac.php";
    header(sprintf("Location: %s", $updateGoTo));
}

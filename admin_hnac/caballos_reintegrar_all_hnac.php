<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodCarrera = "0";
if (isset($_GET["recordID"])) {
    $xCodCarrera = $_GET["recordID"];
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
        $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
    $query_Recordset4 = sprintf(
        "/* PARSEADORES1 admin_hnac\caballos_reintegrar_all_hnac.php - QUERY 1 */ SELECT * 
		FROM carrera_hnac, inscritos 
		WHERE 
		carrera_hnac.cod_carrera_hnac = %s AND
		inscritos.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac",
        GetSQLValueString($xCodCarrera, "int")
    );
    $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
    $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
    $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
    if ($totalRows_Recordset4>0) {
        do {
            if ($row_Recordset4['est_inscrito_hnac']==0) {
                $xCodRetirado=$row_Recordset4['cod_inscrito_hnac'];
                $reintegro[0]=$row_Recordset4['num_caballo_hnac'];
                $insertSQL = sprintf(
                    "/* PARSEADORES1 admin_hnac\caballos_reintegrar_all_hnac.php - QUERY 2 */ UPDATE
									inscritos 
									SET
									est_inscrito_hnac=%s
									WHERE cod_inscrito_hnac=%s",
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($xCodRetirado, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                $car=$xCodCarrera;
                include('../includes/procesar_ticket_reintegraret_hnac.php');
            }
        } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
    }
    $insertGoTo = "caballos_lista_hnac.php";
    header(sprintf("Location: %s", $insertGoTo));
}

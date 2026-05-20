<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (isset($_GET["id_pfijo"]) && isset($_GET["cod_taquilla"])) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 ventashnac_mie\quitarPrecioFijo.php - QUERY 1 */ SELECT
		id_pfijo_hnac 
		FROM 
			precio_fijo_hnac pr
			WHERE 
				pr.id_pfijo_hnac = %s AND
				pr.cod_taquilla =  %s
			LIMIT 1",
        GetSQLValueString($_GET["id_pfijo"], "int"),
        GetSQLValueString($_GET["cod_taquilla"], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 ventashnac_mie\quitarPrecioFijo.php - QUERY 2 */ DELETE FROM precio_fijo_hnac WHERE id_pfijo_hnac = %s",
            GetSQLValueString($_GET["id_pfijo"], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    }
}
if (isset($Recordset1)) {
    mysqli_free_result($Recordset1);
}
?>


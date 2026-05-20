<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$cod_retirado = "0";
if (isset($_GET["recordID"])) {
    $cod_retirado = $_GET["recordID"];
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
        $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
    $query_Recordset13 = sprintf(
        "/* PARSEADORES1 admin\caballos_retirar_del.php - QUERY 1 */ SELECT cod_carrera, num_rcaballo 
	  FROM retirados WHERE cod_retirado = %s LIMIT 1",
        GetSQLValueString($cod_retirado, "int")
    );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    $cod_carrera=$row_Recordset13['cod_carrera'];
    $num_caballo=$row_Recordset13['num_rcaballo'];
    mysqli_free_result($Recordset13);
    $insertSQL = sprintf(
        "/* PARSEADORES1 admin\caballos_retirar_del.php - QUERY 2 */ UPDATE
						retirados 
						SET
						cod_carrera=%s
						WHERE cod_retirado=%s",
        GetSQLValueString(-1, "int"),
        GetSQLValueString($cod_retirado, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    if (is_file('../includes/procesar_resultados_tickets_ame.php')) {
        $tipoProceso=3;
        include("../includes/procesar_resultados_tickets_ame.php");
        $tipoProceso=2;
        include("../includes/procesar_resultados_tickets_ame.php");
    }
    $insertGoTo = "caballos_lista.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}

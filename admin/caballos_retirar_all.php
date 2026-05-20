<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodRetirado = "0";
if (isset($_GET["recordID"])) {
    $xCodRetirado = $_GET["recordID"];
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
        $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
    
    $query_Recordset1 = sprintf("/* PARSEADORES1 admin\caballos_retirar_all.php - QUERY 1 */ SELECT * FROM retirados WHERE retirados.cod_carrera = %s", GetSQLValueString($xCodRetirado, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $retirados="";
    if ($totalRows_Recordset1>0) {
        do {
            $codRe=$row_Recordset1['cod_retirado'];
            $insertSQL = sprintf(
                "/* PARSEADORES1 admin\caballos_retirar_all.php - QUERY 2 */ UPDATE
								retirados 
								SET
								cod_carrera=%s
								WHERE cod_retirado=%s",
                GetSQLValueString(-1, "int"),
                GetSQLValueString($codRe, "int")
            );
            
            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    }
    $cod_carrera=$xCodRetirado;
    if (is_file('../includes/procesar_resultados_tickets_ame.php')) {
        $tipoProceso=6;
        include("../includes/procesar_resultados_tickets_ame.php");

        $tipoProceso=1;
        $reset=2;
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

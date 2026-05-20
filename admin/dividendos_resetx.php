<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$xcarrera_Recordset1 = "-1";
if (isset($_GET["recordID"])) {
    $xcarrera_Recordset1 = $_GET["recordID"];
    $query_Recordset1 = sprintf("/* PARSEADORES1 admin\dividendos_resetx.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", GetSQLValueString($xcarrera_Recordset1, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $fecha=$row_Recordset1['fec_carrera'];
    $updateSQL = sprintf(
        "/* PARSEADORES1 admin\dividendos_resetx.php - QUERY 2 */ UPDATE carrera SET est_confirmacion=%s, eje_primero=%s, div_primero_gan=%s, div_primero_pla=%s, div_primero_sho=%s, eje_segundo=%s, div_segundo_pla=%s, div_segundo_sho=%s, eje_tercero=%s, div_tercero_sho=%s, eje_cuarto=%s, eje_doble_primero=%s, div_doble_primero_gan=%s, div_doble_primero_pla=%s, div_doble_primero_sho=%s, eje_doble_segundo=%s, div_doble_segundo_pla=%s, div_doble_segundo_sho=%s, eje_doble_tercero=%s, div_doble_tercero_sho=%s, eje_doble_cuarto=%s, eje_triple_primero=%s, div_triple_primero_gan=%s, div_triple_primero_pla=%s, div_triple_primero_sho=%s, eje_triple_segundo=%s, div_triple_segundo_pla=%s, div_triple_segundo_sho=%s, eje_triple_tercero=%s, div_triple_tercero_sho=%s, eje_triple_cuarto=%s, div_exacta=%s, fac_exacta=%s, div_trifecta=%s, fac_trifecta=%s, div_superfecta=%s, fac_superfecta=%s,
							div_exacta_doble=%s,
							div_exacta_triple=%s,
							div_trifecta_doble=%s,
							div_trifecta_triple=%s,
							div_superfecta_doble=%s,
							div_superfecta_triple=%s,
							
							ord_exacta=%s,
							ord_exacta_doble=%s,
							ord_exacta_triple=%s,
							ord_trifecta=%s,
							ord_trifecta_doble=%s,
							ord_trifecta_triple=%s,
							ord_superfecta=%s,
							ord_superfecta_doble=%s,
							ord_superfecta_triple=%s
					WHERE cod_carrera=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString("0/0", "text"),
        GetSQLValueString("0/0", "text"),
        GetSQLValueString("0/0", "text"),
        GetSQLValueString("0/0/0", "text"),
        GetSQLValueString("0/0/0", "text"),
        GetSQLValueString("0/0/0", "text"),
        GetSQLValueString("0/0/0/0", "text"),
        GetSQLValueString("0/0/0/0", "text"),
        GetSQLValueString("0/0/0/0", "text"),
        GetSQLValueString($_GET["recordID"], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
if (!isset($_GET["eM"])) {
    $insertGoTo = "historial_lista.php?fechaID=".$fecha;
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}

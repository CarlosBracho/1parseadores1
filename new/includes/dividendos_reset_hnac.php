<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xcarrera_Recordset1 = "-1";
if (isset($_GET["recordID"])) {
    $xcarrera_Recordset1 = $_GET["recordID"];
    $query_Recordset1 = sprintf("/* PARSEADORES1 new\includes\dividendos_reset_hnac.php - QUERY 1 */ SELECT fec_carrera_hnac FROM carrera_hnac 
	WHERE cod_carrera_hnac = %s", GetSQLValueString($xcarrera_Recordset1, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $fecha=$row_Recordset1['fec_carrera_hnac'];
    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\dividendos_reset_hnac.php - QUERY 2 */ SELECT * FROM resultados_oficiales_hnac 
		WHERE 
		cod_carrera_hnac = %s AND
		fec_resultado_hnac = %s",
            GetSQLValueString($xcarrera_Recordset1, "int"),
            GetSQLValueString($fecha, "date")
        );
    }
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    echo $row_Recordset2['cod_resultado_hnac'];
        
    if ($totalRows_Recordset2>0) {
        do {
            echo " ".$row_Recordset2['cod_resultado_hnac'];
                
            $xcodR=$row_Recordset2['cod_resultado_hnac'];
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\dividendos_reset_hnac.php - QUERY 3 */ UPDATE resultados_oficiales_hnac 
					SET 
					num_caballo_hnac=%s, 
					div_pago_hnac=%s 
					WHERE cod_resultado_hnac=%s",
                GetSQLValueString(0, "text"),
                GetSQLValueString(0, "double"),
                GetSQLValueString($xcodR, "int")
            );
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
    }
    mysqli_free_result($Recordset1);
    mysqli_free_result($Recordset2);
}
if (!isset($_GET["eM"])) {
    $insertGoTo = "historial_lista.php?fechaID=".$fecha;
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}

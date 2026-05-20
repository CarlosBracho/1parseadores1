<?php
require_once('../Connections/conexionbanca.php');
$query_Recordset1 =  sprintf("/* PARSEADORES1 new\admin\cestado_taquilla.php - QUERY 1 */ SELECT cod_taquilla, est_taquilla 
	FROM taquilla");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($totalRows_Recordset1>0) {
    do {
        $codT=$row_Recordset1['cod_taquilla'];
        $estT=$row_Recordset1['est_taquilla'];
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\admin\cestado_taquilla.php - QUERY 2 */ UPDATE taquilla 
				SET est_taquilla_hnac=%s
				WHERE cod_taquilla=%s",
            GetSQLValueString($estT, "int"),
            GetSQLValueString($codT, "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    echo "Listo...";
}

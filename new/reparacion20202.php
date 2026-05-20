<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('./Connections/conexionbanca.php');


$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\reparacion20202.php - QUERY 1 */ SELECT numticket, Idbalancecli, monto, saldoactualc, cod_taquilla, hor_venta
FROM balanceclientes
WHERE fec_venta = %s
ORDER BY cod_taquilla, hor_venta ASC",
    GetSQLValueString("2021-01-17", "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$anteriol=0;
$saldoanteriol=0;
$taquilla=0;
echo $totalRows_Recordset1;
echo "</br></br></br>";
do {
    echo "</br>";
    echo $row_Recordset1['cod_taquilla'];
    echo "==";
    echo $row_Recordset1['numticket'];
    echo "==";
    echo $row_Recordset1['hor_venta'];
    echo "==";
    echo $row_Recordset1['monto'];
    echo "==";
    echo $row_Recordset1['saldoactualc'];


    if ($row_Recordset1['cod_taquilla']==$taquilla) {
        $saldoanteriol=$saldoanteriol+$row_Recordset1['monto'];
        $insertSQL15 = sprintf(
            "/* PARSEADORES1 new\reparacion20202.php - QUERY 2 */ UPDATE balanceclientes
				SET
				balanceclientes.saldoactualc=%s 
				WHERE 
				balanceclientes.Idbalancecli=%s",
            GetSQLValueString($saldoanteriol, "numeric"),
            GetSQLValueString($row_Recordset1['Idbalancecli'], "int")
        );

        $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));
    } else {
        $saldoanteriol=$row_Recordset1['saldoactualc'];
    }
    $taquilla=$row_Recordset1['cod_taquilla'];

    echo "==";
    echo $saldoanteriol;
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

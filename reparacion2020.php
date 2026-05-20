<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('./Connections/conexionbanca.php');


$query_Recordset1 = sprintf(
    "/* PARSEADORES1 reparacion2020.php - QUERY 1 */ SELECT numticket, Idbalancecli
FROM balanceclientes
WHERE fec_venta = %s AND
tipo = 1
ORDER BY numticket DESC",
    GetSQLValueString("2021-01-17", "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$anteriol=0;
echo $totalRows_Recordset1;
echo "</br></br></br>";
do {
    echo "</br>";
    echo $row_Recordset1['numticket'];
    $insertSQL15 = sprintf(
        "/* PARSEADORES1 reparacion2020.php - QUERY 2 */ UPDATE balanceclientes
				SET
				balanceclientes.saldoactualc=%s 
				WHERE 
				balanceclientes.Idbalancecli=%s",
        GetSQLValueString("0", "numeric"),
        GetSQLValueString($row_Recordset1['Idbalancecli'], "int")
    );

    $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));


    if ($row_Recordset1['numticket']==$anteriol) {
        echo "igual";
        $id=$row_Recordset1['Idbalancecli'];
        $sql = "/* PARSEADORES1 reparacion2020.php - QUERY 3 */ delete from balanceclientes where Idbalancecli=".$id."";
    
        $queryDelete = "/* PARSEADORES1 reparacion2020.php - QUERY 4 */ DELETE FROM balanceclientes WHERE Idbalancecli = ".$id.";";
 
        $resultDelete = mysqli_query($conexionbanca, $queryDelete);
    }

    $anteriol=$row_Recordset1['numticket'];
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

<?php

require_once('../Connections/conexionbanca.php');


$query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin\eliminarcarrerasaaaaa.php - QUERY 1 */ SELECT * FROM carrera
	WHERE
	carrera.nom_hipodromo=%s  ORDER BY RAND() LIMIT 0, 10000",
        GetSQLValueString('AAAAA', "text")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo $totalRows_Recordset1;
echo '<br>';
if ($totalRows_Recordset1>0) {
do {
    echo   '<br>';









echo   $row_Recordset1['nom_hipodromo'].' '.$row_Recordset1['cod_carrera'].'<br>';
$query_Recordset11 = sprintf(
    "/* PARSEADORES1 admin\eliminarcarrerasaaaaa.php - QUERY 2 */ SELECT * FROM venta 
	WHERE
	venta.cod_carrera=%s
  ORDER BY RAND() LIMIT 0, 100000",
    GetSQLValueString($row_Recordset1['cod_carrera'], "int")
);
$Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
$row_Recordset11 = mysqli_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysqli_num_rows($Recordset11);

if ($totalRows_Recordset11>0) {
    do {
        echo   $row_Recordset11['num_ticket'].' '.$row_Recordset11['cod_carrera'].'<br>';

//aqui elimino las jugadas
$deleteSQL2 = sprintf("/* PARSEADORES1 admin\eliminarcarrerasaaaaa.php - QUERY 3 */ DELETE
FROM
venta
WHERE num_ticket=%s",
GetSQLValueString($row_Recordset11['num_ticket'], "int"));
$Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));





    } while ($row_Recordset11 = mysqli_fetch_assoc($Recordset11));
}

//aqui elimino la carrera
$deleteSQL2 = sprintf("/* PARSEADORES1 admin\eliminarcarrerasaaaaa.php - QUERY 4 */ DELETE
FROM
carrera
WHERE cod_carrera=%s",
GetSQLValueString($row_Recordset1['cod_carrera'], "int"));
$Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));






} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}
<?php
require_once('../Connections/conexionbanca.php');
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$query_Recordset2 = sprintf(
    "
/* PARSEADORES1 includes\reconfirmadorrespaldo.php - QUERY 1 */ SELECT 
carrera.nom_hipodromo,
carrera.cod_carrera,
carrera.num_carrera
FROM 
venta, 
carrera
WHERE
carrera.est_confirmacion = 0 AND
carrera.est_carrera = 0 AND
venta.est_ticket!=0 AND 
venta.est_calculo=0 AND 
venta.fec_venta >= %s AND venta.fec_venta <= %s AND 
venta.cod_carrera = carrera.cod_carrera
ORDER BY RAND() LIMIT 1",
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

echo $totalRows_Recordset2;

        if ($totalRows_Recordset2>0) {
            do {
                echo "</br>";
                echo $row_Recordset2['nom_hipodromo'];
                echo "</br>";
                echo $row_Recordset2['num_carrera'];
                echo "</br>";
                echo $row_Recordset2['cod_carrera'];
                echo "</br>";
                $cod_carrera=$row_Recordset2['cod_carrera'];

                $tipoProceso=2;
                include("procesar_resultados_tickets_ame.php");
                echo "<h3><font color='#027BAD'>Proceso de cálculo culminado! ".$cod_carrera."</font></h3>";
            } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
        }

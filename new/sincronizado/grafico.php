<?php
require_once('../Connections/conexionbanca.php');
$horasistema=horaactual();
$fechasistema=fechaactualbd();






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafico de Estadisticas</title>

    <meta http-equiv="Expires" content="0">
 
<meta http-equiv="Last-Modified" content="0">
 
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
 
<meta http-equiv="Pragma" content="no-cache">
<style>
table, th, td {
  border: 1px solid;
}
</style>
</head>
<body>
    
Taquillas que trabajan con parley
<FONT SIZE=3>
<table>
<tr> 
<td>
<?php
$fechasistemamenos11 = strtotime('-14 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';
$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 1 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';





do {
    # code...
    echo '++';


    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>
</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-13 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';
$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 2 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';





do {
    # code...
    echo '++';


    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>
</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-12 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';
$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 3 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';





do {
    # code...
    echo '++';


    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>
</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-11 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';
$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 4 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>

</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-10 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 5 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>

</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-9 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 6 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>

</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-8 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 7 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));


?>
</td>
</tr> 
<tr> 
<td>
<?php

$fechasistemamenos11 = strtotime('-7 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 8 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));

?>
</td>
<td border=1>
<?php
$fechasistemamenos11 = strtotime('-6 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 9 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>
</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-5 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 10 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>

</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-4 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 11 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>

</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-3 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 12 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));
?>

</td>
<td>
<?php
$fechasistemamenos11 = strtotime('-2 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 13 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));


?>
</td>
<td>
<?php

$fechasistemamenos11 = strtotime('-1 day', strtotime($fechasistema));
$fechasistemamenos1 = date('Y-m-d', $fechasistemamenos11);
echo $fechasistemamenos1;
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fechasistemamenos11);
echo ' '.$dias[$dias2].'<br>';

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\grafico.php - QUERY 14 */ SELECT  
p4jugadas.pcan_ticket, taquilla.nom_taquilla
            FROM  p4jugadas, taquilla
            WHERE 
            p4jugadas.cod_taquillap4 = taquilla.cod_taquilla AND
            (p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s)
            AND p4jugadas.lineatp4=1
            AND p4jugadas.pcan_ticket=1",
    GetSQLValueString($fechasistemamenos1.' 00:00:00', "date"),
    GetSQLValueString($fechasistemamenos1.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        //echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

do {
    echo '++';
    echo strtoupper($row_Recordset18D['nom_taquilla']);
    echo '<br>';
} while ($row_Recordset18D = mysqli_fetch_assoc($Recordset18D));

?>
</td>
</tr> 
</table>
</FONT>

















<img src="Grafico_linear_plot4.php" alt="" border="0">
<img src="Grafico_linear_plot5.php" alt="" border="0">
<img src="Grafico_linear_plot0.php" alt="" border="0">
<img src="Grafico_linear_plot1.php" alt="" border="0">
<img src="Grafico_linear_plot2.php" alt="" border="0">
<img src="Grafico_linear_plot3.php" alt="" border="0">

</body>
</html>
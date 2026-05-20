<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";
setlocale(LC_ALL, "es_ES");



$inicio=fechaactualbd();
$final=fechaactualbd();

$iniciof=fechaactualbd().' 00:00:01';
$finalf=fechaactualbd().' 23:59:59';

$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
$codigoUsuario=$_SESSION['MM_id_usuario'];

 



if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction = "" . htmlentities($_SERVER['QUERY_STRING']);
    
}
if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
    $inicio=$_POST['fecha_inicio'];
    $final=$_POST['fecha_fin'];
    $iniciof=$_POST['fecha_inicio'].' 00:00:01';
     $finalf=$_POST['fecha_fin'].' 23:59:59';
    



}


if (isset($_POST['fechaini']) && isset($_POST['fechafi'])) {
    $inicio=$_POST['fechaini'];
    $final=$_POST['fechafi'];
    $iniciof=$_POST['fechaini'].' 00:00:01';
     $finalf=$_POST['fechafi'].' 23:59:59';
    



}
$D=1;
if(isset($_POST['FechaS'])){ 
    $D=$_POST['FechaS']; 
}


if($D==1){
    $query_Recordset13 = sprintf(
        "/* PARSEADORES1 parley\tapcuadrecaja.php - QUERY 1 */ SELECT 
    p4jugadas.lineatp4,
    SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s  AND p4jugadas.monedap4 <= 2 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventabss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadobss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadosbss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_anuladosbss,

SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 3 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventausd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadousd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadosusd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_anuladosusd,

SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 4 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventacop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadocop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadoscop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_anuladoscop,

SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 5 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventasol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND  (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadosol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND  (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadossol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND  (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_anuladossol
    FROM 
    p4jugadas
    WHERE
    p4jugadas.id_usuariop4= %s AND 
    p4jugadas.lineatp4= 1",
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
    GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
    );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);

}elseif($D==2){

    $query_Recordset13 = sprintf(
        "/* PARSEADORES1 parley\tapcuadrecaja.php - QUERY 2 */ SELECT 
    p4jugadas.lineatp4,
    SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s  AND p4jugadas.monedap4 <= 2 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventabss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadobss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadosbss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_anuladosbss,

SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 3 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventausd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadousd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadosusd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_anuladosusd,

SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 4 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventacop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadocop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadoscop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_anuladoscop,

SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 5 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventasol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadosol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadossol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 = 5 THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_anuladossol
    FROM 
    p4jugadas
    WHERE
    p4jugadas.id_usuariop4= %s AND 
    p4jugadas.lineatp4= 1",
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"), 
   GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
    );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);




}





$query_Recordset2 = sprintf("/* PARSEADORES1 parley\tapcuadrecaja.php - QUERY 3 */ SELECT usuario.nom_usuario, usuario.id_usuario, taquilla.nom_taquilla FROM usuario, taquilla 
	WHERE usuario.cod_taquilla = %s AND tip_usuario='U' AND usuario.cod_taquilla = taquilla.cod_taquilla
	ORDER BY usuario.nom_usuario", GetSQLValueString($codigoTaquilla, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$taquillaV=$row_Recordset2['nom_taquilla'];

$query_Recordset3 = sprintf("/* PARSEADORES1 parley\tapcuadrecaja.php - QUERY 4 */ SELECT nom_usuario FROM usuario WHERE usuario.id_usuario = %s AND tip_usuario='U' 
LIMIT 1", GetSQLValueString($codigoUsuario, "int"));
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$vendedor=strtoupper($row_Recordset3['nom_usuario']);






?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>.:Apuestas:.</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrapBootswatchv4.5.2.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/datepicked.gijgo1.9.13.min.js" type="text/javascript"></script>
<link href="../css/datepicked.gijgo1.9.13.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
<header> 
  <!-- Fixed navbar -->
  <?php include('../parley/menutap.php'); ?>
</header>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
onsubmit="return chequearEnvio();">

<input name="fecha_inicio" id="datepicker" width="276" value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>" />
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'yyyy-mm-dd'
        });
    </script>
    <input name="fecha_fin" id="datepicker2" width="276" value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" />
    <script>
        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4'            ,
            dateFormat: 'yyyy-mm-dd'
        });
    </script>
                    <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/>
                 <br><br>

</form>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
onsubmit="return chequearEnvio();">
<?php if($D==2){ ?>

<input type="submit" value="VER NORMAL" class="btn-warning" title="" onClick="return enviado()"
                 />
<input type="hidden" name="FechaS" value="1">
<input type="hidden" name="fecha_inicio" value="<?php echo $inicio; ?>">
<input type="hidden" name="fecha_fin" value="<?php echo $final; ?>">

<?php }?>
<?php if($D==1){ ?>

<input type="submit" value="VER GANANCIAS VS PERDIDAS" class="btn-warning" title="" onClick="return enviado()"/>
<input type="hidden" name="FechaS" value="2">
<input type="hidden" name="fecha_inicio" value="<?php echo $inicio; ?>">
<input type="hidden" name="fecha_fin" value="<?php echo $final; ?>">
<?php }?>

</form>


<?php 
$taquillaV=$row_Recordset2['nom_taquilla'];
$vendedor=strtoupper($row_Recordset3['nom_usuario']);

?>

TAQUILLA: <?php echo $taquillaV."<br>"; ?>
VENDEDOR: <?php echo $vendedor."<br>"; ?>
DESDE: <?php echo $inicio."<br>"; ?>
HASTA: <?php echo $final."<br>"; ?>
HORA: <?php
$hora1=horaactual();
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo $nuevahora1;
$sihay=0;
?>
<br/><strong>CUADRE PARLEY</strong>


<?php
if ($row_Recordset13['total_ventabss']>0 or $row_Recordset13['total_pagadobss']>0) {
    ?>

    <br/>TOTAL VENTAS POR BSS:
    <br/><?php echo number_format($row_Recordset13['total_ventabss'], 2, ",", "."); ?>
    <br/>TOTAL ELIMINADOS POR BSS:
    <br/><?php echo number_format($row_Recordset13['total_eliminadosbss'], 2, ",", "."); ?>
    <br/>TOTAL DEVOLUCION POR BSS:
    <br/><?php echo number_format($row_Recordset13['total_anuladosbss'], 2, ",", "."); ?>
    <br/>PREMIOS PAGADOS EN BSS:
    <br/><?php echo number_format($row_Recordset13['total_pagadobss'], 2, ",", "."); ?>
    <br/>BSS EN CAJA:
    <br/><strong>***<?php echo number_format(($row_Recordset13['total_ventabss']-$row_Recordset13['total_anuladosbss']-$row_Recordset13['total_pagadobss']-$row_Recordset13['total_eliminadosbss']), 2, ",", "."); ?>***</strong>

    <?php $sihay=$sihay+1;
}
if ($row_Recordset13['total_ventausd']>0 or $row_Recordset13['total_pagadousd']>0) {
    ?>
    <br/>TOTAL VENTAS POR USD:
    <br/><?php echo number_format($row_Recordset13['total_ventausd'], 2, ",", "."); ?>
    <br/>TOTAL ELIMINADOS POR USD:
    <br/><?php echo number_format($row_Recordset13['total_eliminadosusd'], 2, ",", "."); ?>
    <br/>TOTAL DEVOLUCION POR USD:
    <br/><?php echo number_format($row_Recordset13['total_anuladosusd'], 2, ",", "."); ?>
    <br/>PREMIOS PAGADOS EN USD:
    <br/><?php echo number_format($row_Recordset13['total_pagadousd'], 2, ",", "."); ?>
    <br/>USD EN CAJA:
    <br/><strong>***<?php echo number_format(($row_Recordset13['total_ventausd']-$row_Recordset13['total_anuladosusd']-$row_Recordset13['total_pagadousd']-$row_Recordset13['total_eliminadosusd']), 2, ",", "."); ?>***</strong>




    <?php $sihay=$sihay+1;
}
if ($row_Recordset13['total_ventacop']>0 or $row_Recordset13['total_pagadocop']>0) {
    ?>
    <br/>TOTAL VENTAS POR COP:
    <br/><?php echo number_format($row_Recordset13['total_ventacop'], 2, ",", "."); ?>
    <br/>TOTAL ELIMINADOS POR COP:
    <br/><?php echo number_format($row_Recordset13['total_eliminadoscop'], 2, ",", "."); ?>
    <br/>TOTAL DEVOLUCION POR COP:
    <br/><?php echo number_format($row_Recordset13['total_anuladoscop'], 2, ",", "."); ?>
    <br/>PREMIOS PAGADOS EN COP:
    <br/><?php echo number_format($row_Recordset13['total_pagadocop'], 2, ",", "."); ?>
    <br/>COP EN CAJA:
    <br/><strong>***<?php echo number_format(($row_Recordset13['total_ventacop']-$row_Recordset13['total_anuladoscop']-$row_Recordset13['total_pagadocop']-$row_Recordset13['total_eliminadoscop']), 2, ",", "."); ?>***</strong>




    <?php $sihay=$sihay+1;

}
if ($row_Recordset13['total_ventasol']>0 or $row_Recordset13['total_pagadosol']>0) {
    ?>
    <br/>TOTAL VENTAS POR SOL:
    <br/><?php echo number_format($row_Recordset13['total_ventasol'], 2, ",", "."); ?>
    <br/>TOTAL ELIMINADOS POR SOL:
    <br/><?php echo number_format($row_Recordset13['total_eliminadossol'], 2, ",", "."); ?>
    <br/>TOTAL DEVOLUCION POR SOL:
    <br/><?php echo number_format($row_Recordset13['total_anuladossol'], 2, ",", "."); ?>
    <br/>PREMIOS PAGADOS EN SOL:
    <br/><?php echo number_format($row_Recordset13['total_pagadosol'], 2, ",", "."); ?>
    <br/>SOL EN CAJA:
    <br/><strong>***<?php echo number_format(($row_Recordset13['total_ventasol']-$row_Recordset13['total_anuladossol']-$row_Recordset13['total_pagadosol']-$row_Recordset13['total_eliminadossol']), 2, ",", "."); ?>***</strong>




    <?php $sihay=$sihay+1; 

    

}
if($sihay==0){
    ?>
<br/>NO HAY VENTAS QUE REFLEJAR EN ESTE RANGO DE FECHA<br/> 

<?php
}


?>

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>

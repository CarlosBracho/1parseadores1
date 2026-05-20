<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
echo $FechaTxt;
$datetime=$FechaTxt.' '.$horaTxt;
    $editFormAction = $_SERVER['PHP_SELF'];
if (empty($_POST['fecha'])) {
    $FechaTxt=fechaactualbd();
} else {
    $FechaTxt=$_POST["fecha"];
}
setlocale(LC_ALL, "es_ES");
echo $FechaTxt;
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 1 */ SELECT * 
FROM p2juegos 
WHERE  
iniciodtp2 >= %s  AND
iniciodtp2 <= %s
ORDER BY iniciodtp2 
ASC",
    GetSQLValueString($FechaTxt." 00:00:01", "date"),
    GetSQLValueString($FechaTxt." 23:59:59", "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

    
?>
<!doctype html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="../css/bootstrap.min4.5.2.css">
<link rel="stylesheet" href="../css/bootstrap-datepicker3.min.css">
<link href="../fonts/font-awesome.min4.7.0.css" rel="stylesheet">
<link media="all" type="text/css" rel="stylesheet" href="../css/style1.css">


<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/popper.min1.16.1.js"></script>
<script src="../js/bootstrap.min4.5.2.js"></script>
<script src="../js/bootstrap-datepicker.min.js"></script>
<title>.:Apuestas:.</title>

</head>

<body>
<?php
require_once('../parley/admenu.php');
?>
<div class="container">
<table class="table">
<th scope="col">
				</th>
				<th scope="col">
				<div><a href="adagregarjuego.php" type="button" class="btn btn-warning">adagregarjuego.php</a></div>
				</th>
				</table>
				<table class="table">
<th scope="col">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">

          
				</th>

				</table>
				SELECCIONE FECHA
<div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
    <input name="fecha" type="text" class="form-control">
    <div class="input-group-addon">
        </br>
		<button type="submit" class="btn btn-primary">Ir a fecha</button>
    </div>
</div>
<script type="text/javascript">
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
});
  </script>
</form> 
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
      
      <table class="table">

        <tbody>
          <?php

do {
    ?>

<tr class="categorias-juegos">

<th class="text-center">
<p><?php
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['iniciodtp2']));
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);

    echo strftime("%A %d", strtotime($nuevahora1))?></br>
<?php echo date("g:ia", strtotime($nuevahora1)); ?></p>
</th>

<th class="text-center">
<p>Ganar </p>
</th>
<th class="text-center">
<p>Alta/Baja</p>
 </th>
<th class="text-center">
<p>RunLine </p>
</th>
<th class="text-center">
<p>Ganar</br> 5to Inn </p>
</th>
<th class="text-center">
<p>A/B</br> 5to Inn </p>
</th>
<th class="text-center">
<p>RL 5to Inn </p>
</th>
<th class="text-center">
<p>Ganar</br> 2da M. </p>
</th>
<th class="text-center">
<p>A/B</br> 2da M. </p>
</th>
<th class="text-center">
<p>Anota</br> 1ero </p>
</th>
<th class="text-center">
<p>SI/NO </p>
</th>
<th class="text-center">
<p>H+R+E </p>
</th>

</tr>
<tr class="border-table  odd ">

<td>
<span class="opcion-a">

<?php
$query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 2 */ SELECT *
FROM p1equipos
WHERE  

Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);

    echo $row_Recordset21['nomequipop1'];
    echo '</br>'; ?>

<small style="font-size:80%;font-weight:normal;">(<?php echo $row_Recordset1['pichee1p2']; ?>)</small>
</span>

</td>

<td class="text-left">
<span>
<label>
<?php
        $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 3 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'ML'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
		<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger"><?php echo $row_Recordset21['logrop3'];  ?></a></br>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=ML&equipo=1&idequipo=<?php echo $row_Recordset1['idequipo1p2'];?>" class="btn btn-outline-danger">NO HAY</a></br> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
        $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 4 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'A'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
		<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">A(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a></br>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=A&equipo=1&idequipo=<?php echo $row_Recordset1['idequipo1p2'];?>" class="btn btn-outline-danger">NO HAY</a></br> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
        $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 5 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'RL'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
		<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a></br>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=RL&equipo=1&idequipo=<?php echo $row_Recordset1['idequipo1p2'];?>" class="btn btn-outline-danger">NO HAY</a></br> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
        $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 6 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = '5ML'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
		<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger"><?php echo $row_Recordset21['logrop3'];  ?></a></br>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=5ML&equipo=1&idequipo=<?php echo $row_Recordset1['idequipo1p2'];?>" class="btn btn-outline-danger">NO HAY</a></br> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
        $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 7 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = '5A'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
		<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">A(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a></br>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=5A&equipo=1&idequipo=<?php echo $row_Recordset1['idequipo1p2'];?>" class="btn btn-outline-danger">NO HAY</a></br> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
        $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 8 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = '5RL'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
		<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a></br>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=5RL&equipo=1&idequipo=<?php echo $row_Recordset1['idequipo1p2'];?>" class="btn btn-outline-danger">NO HAY</a></br> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>

</label>
</span>
</td>
<td class="text-left">
<span>
<label>

</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
        $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 9 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'AP'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
		<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger"><?php echo $row_Recordset21['logrop3'];  ?></a></br>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=AP&equipo=1&idequipo=<?php echo $row_Recordset1['idequipo1p2'];?>" class="btn btn-outline-danger">NO HAY</a></br> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
        $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 10 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'SI'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
		<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger"><?php echo $row_Recordset21['logrop3'];  ?></a></br>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=SI&equipo=1&idequipo=<?php echo $row_Recordset1['idequipo1p2'];?>" class="btn btn-outline-danger">NO HAY</a></br> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
        $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 11 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'AG'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
		<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">AG(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a></br>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=AG&equipo=1&idequipo=<?php echo $row_Recordset1['idequipo1p2'];?>" class="btn btn-outline-danger">NO HAY</a></br> 
 <?php } ?>
</label>
</span>
</td>


</tr>

<tr class="border-table  odd ">

<td>
<span class="opcion-a">

<?php
$query_Recordset22 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 12 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
    echo $row_Recordset22['nomequipop1']; ?>

<small style="font-size:80%;font-weight:normal;">(<?php echo $row_Recordset1['pichee2p2']; ?>)</small>
</span>
						</br><span>
 <a href="adagregarresultado.php?Id_p2juegosp2=<?php echo $row_Recordset1['Id_p2juegosp2']; ?>&equipo1=<?php echo $row_Recordset21['nomequipop1']; ?>&equipo2=<?php echo $row_Recordset22['nomequipop1']; ?>" class="btn btn-outline-danger">Resultado</a> 

			</span>
</td>

<td class="text-left">
<span>
<label>
<?php
                $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 13 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'ML'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
	<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger"><?php echo $row_Recordset21['logrop3'];  ?></a>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=ML&equipo=2&idequipo=<?php echo $row_Recordset1['idequipo2p2'];?>" class="btn btn-outline-danger">NO HAY</a> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
                $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 14 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'B'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
	<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">B(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=B&equipo=2&idequipo=<?php echo $row_Recordset1['idequipo2p2'];?>" class="btn btn-outline-danger">NO HAY</a> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
                $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 15 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'RL'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
	<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=RL&equipo=2&idequipo=<?php echo $row_Recordset1['idequipo2p2'];?>" class="btn btn-outline-danger">NO HAY</a> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
                $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 16 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = '5ML'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
	<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger"><?php echo $row_Recordset21['logrop3'];  ?></a>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=5ML&equipo=2&idequipo=<?php echo $row_Recordset1['idequipo2p2'];?>" class="btn btn-outline-danger">NO HAY</a> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
                $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 17 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = '5B'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
	<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">B(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=5B&equipo=2&idequipo=<?php echo $row_Recordset1['idequipo2p2'];?>" class="btn btn-outline-danger">NO HAY</a> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
                $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 18 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = '5RL'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
	<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=5RL&equipo=2&idequipo=<?php echo $row_Recordset1['idequipo2p2'];?>" class="btn btn-outline-danger">NO HAY</a> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>

</label>
</span>
</td>
<td class="text-left">
<span>
<label>

</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
                $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 19 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'AP'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
	<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger"><?php echo $row_Recordset21['logrop3'];  ?></a>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=AP&equipo=2&idequipo=<?php echo $row_Recordset1['idequipo2p2'];?>" class="btn btn-outline-danger">NO HAY</a> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
                $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 20 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'NO'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
	<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger"><?php echo $row_Recordset21['logrop3'];  ?></a>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=NO&equipo=2&idequipo=<?php echo $row_Recordset1['idequipo2p2'];?>" class="btn btn-outline-danger">NO HAY</a> 
 <?php } ?>
</label>
</span>
</td>
<td class="text-left">
<span>
<label>
<?php
                $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\agente\adlistajuegos.php - QUERY 21 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'BG'",
        GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21); ?><?php if ($row_Recordset21['Id_p3logrosp3']>0) {?>
	<a href="adeditarlogro.php?recordID=<?php echo $row_Recordset21['Id_p3logrosp3'];?>" class="btn btn-outline-danger">BG(<?php echo $row_Recordset21['logroABoRLp3'];?>) <?php echo $row_Recordset21['logrop3'];  ?></a>
<?php } else { ?>
 <a href="adagregarlogro.php?recordID=<?php echo $row_Recordset1['Id_p2juegosp2'];?>&tipoapuesta=BG&equipo=2&idequipo=<?php echo $row_Recordset1['idequipo2p2'];?>" class="btn btn-outline-danger">NO HAY</a> 
 <?php } ?>
</label>
</span>
</td>

</tr>



          <?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
?>
        </tbody>
      </table>
      
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>
<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Toggle first element</a>
</p>
<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample1">
      <div class="card card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
      </div>
    </div>
  </div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.5.1.slim.min.js"></script>
    <script src="../js/popper.min1.16.1.js"></script>
    <script src="../js/bootstrap.min4.5.2.js"></script>
	<script type="text/javascript" src="../js/tcal.js"></script>
  </body>
</html>
<?php
echo '<br>';
echo 'v9<br>';
// 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once('../includes/class.stoper.php');
//instancio un objeto de la clase stoper
$s = new Stoper();


//ejecuto el mï¿½todo Start() para que el objeto stoper comience a contar el tiempo
$s->Start();



if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");




$inicio=fechaactualbd();
$iniciof=fechaactualbd().' 00:00:01';
$finalf=fechaactualbd().' 23:59:59';


if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction = "" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_inicio'])) {
    $inicio=$_POST['fecha_inicio'];
    $final=$_POST['fecha_inicio'];
    $iniciof=$_POST['fecha_inicio'].' 00:00:01';
    $finalf=$_POST['fecha_inicio'].' 23:59:59';
    



}



$query_Recordset13 = sprintf(
"/* PARSEADORES1 parley\adpsinresultados.php - QUERY 1 */ SELECT *
FROM p2juegos
WHERE
iniciodtp2 >= %s AND 
iniciodtp2 <= %s
ORDER BY deportep2 AND iniciodtp2 DESC",
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);


$D=1;

if(isset($_POST['FechaS'])){ 
    $D=$_POST['FechaS']; 
}



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
<?php //include('../parley/menutap.php'); 
?>
</header>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off" onsubmit="return chequearEnvio();">

<input name="fecha_inicio" id="datepicker" width="276" value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>" />
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'yyyy-mm-dd'
        });
    </script>
	


                    <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
				style="width:80px; height:40px"/>




				
<!-- Begin page content -->


		<br><br>

		<center>
<?php if($D==2){ ?>

<input type="submit" value="IR A JUEGOS SIN RESULTADOS CON JUGADAS PENDIENTES" class="btn-warning" title="" onClick="return enviado()"
                 />
<input type="hidden" name="FechaS" value="1">
<br><br><br>
<h2>OTROS JUEGOS SIN RESULTADOS</h2>
<?php }?>
<?php if($D==1){ ?>

<input type="submit" value="IR A OTROS JUEGOS SIN RESULTADOS" class="btn-warning" title="" onClick="return enviado()"/>
<input type="hidden" name="FechaS" value="2">
<br><br><br>
<h2>JUEGOS SIN RESULTADOS CON JUGADAS PENDIENTES</h2>
<?php }?>

</center>
</form>








<div class="container">
<hr>
<div class="row">
<div class="col-12 col-md-12  table-responsive "> 
<!-- Contenido -->
<table class="table">
<thead class="thead-dark">
<tr>


            

</tr>
</thead>
<tbody style="border: solid 1px #000000; ">
<?php





$beisbol=0;
$futbol=0;
if ($totalRows_Recordset13>=1) {
	$jn=0;



	//paro la cuenta del tiempo por el objeto stoper con el mï¿½todo Stop()
$s->Stop();

//acabo mostrando el tiempo total de ejecuciï¿½n del script
echo $s->showResult('Tiempo total de ejecuciï¿½n: ').'<br>';
$tiempo = $s->showResult(' ');


do {
	



	


	$query_Recordset14 = sprintf(
		"/* PARSEADORES1 parley\adpsinresultados.php - QUERY 2 */ SELECT *
		FROM p5resultadosj
		WHERE
		iniciodtp5 >= %s AND 
		iniciodtp5 <= %s AND 
		juegop5 = %s",
		GetSQLValueString($iniciof, "date"),
		GetSQLValueString($finalf, "date"), 
		GetSQLValueString($row_Recordset13['Id_p2juegosp2'], "int"));
		$Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
		$row_Recordset14 = mysqli_fetch_assoc($Recordset14);
		$totalRows_Recordset14 = mysqli_num_rows($Recordset14);
		if($totalRows_Recordset14==0){
			if($D==1){	
//echo $D.'<br>';
			$query_Recordset144 = sprintf(
				"/* PARSEADORES1 parley\adpsinresultados.php - QUERY 3 */ SELECT *
				FROM p4jugadas, p2juegos
				WHERE
				p2juegos.iniciodtp2 >= %s AND 
		        p2juegos.iniciodtp2 <= %s AND 
				p2juegos.Id_p2juegosp2 = %s AND 
				p2juegos.Id_p2juegosp2 = p4jugadas.juegop4 LIMIT 1",
						GetSQLValueString($iniciof, "date"),
						GetSQLValueString($finalf, "date"),
				GetSQLValueString($row_Recordset13['Id_p2juegosp2'], "int"));
				$Recordset144 = mysqli_query($conexionbanca, $query_Recordset144) or die(mysqli_error($conexionbanca));
				$row_Recordset144 = mysqli_fetch_assoc($Recordset144);
				$totalRows_Recordset144 = mysqli_num_rows($Recordset144);
			if($totalRows_Recordset144>=1){

				$jn++;
				$query_Recordset21 = sprintf(
					"/* PARSEADORES1 parley\adpsinresultados.php - QUERY 4 */ SELECT *
					FROM p1equipos
					WHERE  
					
					Id_p1equiposp1 = %s",
					GetSQLValueString($row_Recordset13['idequipo1p2'], "int")
					);
					$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
					$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
					$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
					$equipo1=$row_Recordset21['nomequipop1'];
					$query_Recordset22 = sprintf(
					"/* PARSEADORES1 parley\adpsinresultados.php - QUERY 5 */ SELECT *
					FROM p1equipos
					WHERE  
					
					Id_p1equiposp1 = %s",
					GetSQLValueString($row_Recordset13['idequipo2p2'], "int")
					);
					$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
					$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
					$totalRows_Recordset22 = mysqli_num_rows($Recordset22);
					$equipo2=$row_Recordset22['nomequipop1'];
	
	 ?>
		<tr class="text-center font-weight-bold">
		<td colspan="2" width="40%"> <a href="adpsinresultados2.php?Id_p2juegosp2=<?php echo $row_Recordset13['Id_p2juegosp2']; ?>&equipo1=<?php echo $row_Recordset21['nomequipop1']; ?>&equipo2=<?php echo $row_Recordset22['nomequipop1']; ?>&logrodtp3=<?php echo $row_Recordset13['iniciodtp2'];?>" class="btn btn-outline-danger" target="_blank">Juego Sin Confirmar #     <?php echo ''.$jn.''; ?> </a></td>
		<td colspan="2" width="40%"><?php echo $row_Recordset13['deportep2']; ?> </td>
		<td colspan="2" width="40%"><?php echo $equipo1.'<br>'.$equipo2.'<br>'.$row_Recordset13['iniciodtp2']; ?> </td>
	
	</tr>							
<?php					
			}}

if($D==2){
	//echo $D.'<br>';
			$jn++;
			$query_Recordset21 = sprintf(
				"/* PARSEADORES1 parley\adpsinresultados.php - QUERY 6 */ SELECT *
				FROM p1equipos
				WHERE  
				
				Id_p1equiposp1 = %s",
				GetSQLValueString($row_Recordset13['idequipo1p2'], "int")
				);
				$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
				$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
				$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
				$equipo1=$row_Recordset21['nomequipop1'];
				$query_Recordset22 = sprintf(
				"/* PARSEADORES1 parley\adpsinresultados.php - QUERY 7 */ SELECT *
				FROM p1equipos
				WHERE  
				
				Id_p1equiposp1 = %s",
				GetSQLValueString($row_Recordset13['idequipo2p2'], "int")
				);
				$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
				$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
				$totalRows_Recordset22 = mysqli_num_rows($Recordset22);
				$equipo2=$row_Recordset22['nomequipop1'];

 ?>
	<tr class="text-center font-weight-bold">
	<td colspan="2" width="40%"> <a href="adpsinresultados2.php?Id_p2juegosp2=<?php echo $row_Recordset13['Id_p2juegosp2']; ?>&equipo1=<?php echo $row_Recordset21['nomequipop1']; ?>&equipo2=<?php echo $row_Recordset22['nomequipop1']; ?>&logrodtp3=<?php echo $row_Recordset13['iniciodtp2'];?>" class="btn btn-outline-danger" target="_blank">Juego Sin Confirmar #     <?php echo ''.$jn.''; ?> </a></td>
	<td colspan="2" width="40%"><?php echo $row_Recordset13['deportep2']; ?> </td>
	<td colspan="2" width="40%"><?php echo $equipo1.'<br>'.$equipo2.'<br>'.$row_Recordset13['iniciodtp2']; ?> </td>

</tr>							



<?php





}}
/*
if($row_Recordset13['deportep2']=='futbol' or $row_Recordset13['deportep2']=='futbolamericano' ){
	?>
	
	<?php if($futbol==0){ $futbol=1; ?>
		<tr class="text-center font-weight-bold">
									<td colspan="2" width="40%">Equipo</td>
									<td class="text-center">Juego Completo</td><td class="text-center">Mitad de Juego</td></tr>							<tr style="background-color: #F2FFFF;"> 
	<?php } ?>



						<tr> 
						<td rowspan="2" width="15%" class="text-center"><?php echo substr($row_Recordset13['iniciodtp5'], 0, -8); ?><br><span class="VsOdds">VS</span><br><?php echo substr($row_Recordset13['iniciodtp5'], 10); ?></td>
							
								<td width="25%"><?php echo $row_Recordset13['equipo1p5']; ?></td>
								<td class="text-center"><?php echo $row_Recordset13['r21p5']; ?></td>
																<td class="text-center"><?php echo $row_Recordset13['r23p5']; ?></td>
																							</tr>
							<tr> 
								<td width="25%"><?php echo $row_Recordset13['equipo2p5']; ?></td>
								<td class="text-center"><?php echo $row_Recordset13['r22p5']; ?></td>
																<td class="text-center"><?php echo $row_Recordset13['r24p5']; ?></td>
															</tr>

	<?php
	}
*/




} while ($row_Recordset13 = mysqli_fetch_assoc($Recordset13));
}
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

<script src="../js/bootstrap4.js"></script>
</body>
</html>

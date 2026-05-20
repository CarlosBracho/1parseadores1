<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

$inicio=fechaactualbd();
$iniciof=fechaactualbd().' 00:00:01';
$finalf=fechaactualbd().' 23:59:59';
$horaTxt=horaactual(); $FechaTxt=fechaactualbd(); $fechahora=$FechaTxt.' '.$horaTxt;

echo $fechahora;
$query_Recordset13 = sprintf(
"/* PARSEADORES1 parley\adalertajuegos.php - QUERY 1 */ SELECT *
FROM p2juegos
WHERE
iniciodtp2 >= %s
ORDER BY deportep2 AND iniciodtp2 DESC",
GetSQLValueString($iniciof, "date"));
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);


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
do {
	$query_Recordset14 = sprintf(
		"/* PARSEADORES1 parley\adalertajuegos.php - QUERY 2 */ SELECT Id_p5resultadosjp5
		FROM p5resultadosj
		WHERE
		iniciodtp5 >= %s AND 
		iniciodtp5 <= %s AND 
		juegop5 = %s",
		GetSQLValueString($iniciof, "date"),
		GetSQLValueString($finalf, "date"), GetSQLValueString($row_Recordset13['Id_p2juegosp2'], "date"));
		$Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
		$row_Recordset14 = mysqli_fetch_assoc($Recordset14);
		$totalRows_Recordset14 = mysqli_num_rows($Recordset14);
		if($totalRows_Recordset14==0){

			$query_Recordset144 = sprintf(
				"/* PARSEADORES1 parley\adalertajuegos.php - QUERY 3 */ SELECT p2juegos.deportep2, p2juegos.iniciodtp2
				FROM p4jugadas , p2juegos 
				WHERE
				p2juegos.Id_p2juegosp2 = %s AND p4jugadas.juegop4 = %s",
				GetSQLValueString($row_Recordset13['Id_p2juegosp2'], "date"),
				GetSQLValueString($row_Recordset13['Id_p2juegosp2'], "date")
			);
				$Recordset144 = mysqli_query($conexionbanca, $query_Recordset144) or die(mysqli_error($conexionbanca));
				$row_Recordset144 = mysqli_fetch_assoc($Recordset144);
				$totalRows_Recordset144 = mysqli_num_rows($Recordset144);
			if($totalRows_Recordset144>=1){
if($row_Recordset144['deportep2']=='futbol'){
				$Diego=$row_Recordset144['iniciodtp2'];
				$datetime =$Diego; 
				$datetime = strtotime(' +1 hour , 50 minute', strtotime($datetime)); 
				$datetime = date('Y-m-d H:i:s', $datetime);
}
if($row_Recordset144['deportep2']=='beisbol'){
	$Diego=$row_Recordset144['iniciodtp2'];
	$datetime =$Diego; 
	$datetime = strtotime(' +3 hour , 30 minute', strtotime($datetime)); 
	$datetime = date('Y-m-d H:i:s', $datetime);
}
if($row_Recordset144['deportep2']=='baloncesto'){
	$Diego=$row_Recordset144['iniciodtp2'];
	$datetime =$Diego; 
	$datetime = strtotime('+1 hour , 50 minute', strtotime($datetime)); 
	$datetime = date('Y-m-d H:i:s', $datetime);
}
if($row_Recordset144['deportep2']=='hockey'){
	$Diego=$row_Recordset144['iniciodtp2'];
	$datetime =$Diego; 
	$datetime = strtotime('+1 hour , 50 minute', strtotime($datetime)); 
	$datetime = date('Y-m-d H:i:s', $datetime);
}
				//echo $datetime;

				if($fechahora>$datetime){

				$jn++;
				$query_Recordset21 = sprintf(
					"/* PARSEADORES1 parley\adalertajuegos.php - QUERY 4 */ SELECT nomequipop1
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
					"/* PARSEADORES1 parley\adalertajuegos.php - QUERY 5 */ SELECT nomequipop1
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
<?php	

$msj='Juegos que posiblemente terminaron y tienen jugadas pendientes'."\n".$equipo1.' VS '.$equipo2;
$msjx=utf8_encode($msj);
$post=[
  'chat_id'=>-1001639542248,
  'text'=>$msjx,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
curl_close ($ch);	
}			
			}
			

}
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

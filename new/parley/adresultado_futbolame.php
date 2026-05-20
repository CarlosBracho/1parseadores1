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

</header>


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

$futbolamericano=0;
if ($totalRows_Recordset1futbolame>=1) {
do {

	$query_Recordset301 = sprintf(
            "/* PARSEADORES1 new\parley\adresultado_futbolame.php - QUERY 1 */ SELECT * FROM p2juegos, p5resultadosj WHERE 
p2juegos.iniciodtp2 > %s AND
p2juegos.iniciodtp2 < %s AND
p5resultadosj.iniciodtp5 > %s AND
p5resultadosj.iniciodtp5 < %s AND
p2juegos.Id_p2juegosp2 = %s 
        ORDER BY p2juegos.competicionp2
        ",
		        GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
        GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"),
            GetSQLValueString($row_Recordset1futbolame['juegop5'], "int")
        );
	$Recordset301 = mysqli_query($conexionbanca, $query_Recordset301) or die(mysqli_error($conexionbanca));
	$row_Recordset301 = mysqli_fetch_assoc($Recordset301);
	$totalRows_Recordset301 = mysqli_num_rows($Recordset301);

//Diego
$quienmete2=0;
	if($row_Recordset1futbolame['quienmete']<>0 && $row_Recordset1futbolame['quienmete']<>''){
		$query_Recordset301d = sprintf(
			"/* PARSEADORES1 new\parley\adresultado_futbolame.php - QUERY 2 */ SELECT nom_usuario FROM usuario WHERE 
		id_usuario = %s
		",
			GetSQLValueString($row_Recordset1futbolame['quienmete'], "int")
		);
		$Recordset301d = mysqli_query($conexionbanca, $query_Recordset301d) or die(mysqli_error($conexionbanca));
		$row_Recordset301d = mysqli_fetch_assoc($Recordset301d);
		$totalRows_Recordset301d = mysqli_num_rows($Recordset301d);
$quienmete=$row_Recordset301d['nom_usuario'];
$quienmete2=1;
	}

	if($row_Recordset1futbolame['quienmete']==0 && $row_Recordset1futbolame['quienmete']!=''){
		$quienmete='WINNIGBET';   
		$quienmete2=1;
	}
	if($row_Recordset1futbolame['quienmete']==-1 && $row_Recordset1futbolame['quienmete']!=''){
		$quienmete='SELLATUPARLEY';   
		$quienmete2=1;
	}

//Diego	

    if($row_Recordset1futbolame['deportep5']=='futbolamericano'){
		?>
		
		<?php if($futbolamericano==0){ $futbolamericano=1; ?>
			<tr class="text-center font-weight-bold table-info" style="border: solid; border-color:black">
				<td>Fecha</td>
				<td>Competicion</td>							
				<td>Equipos Futbol Americano</td>
				<td class="text-center">Primera Mitad</td><td class="text-center">Segunda Mitad</td><td class="text-center">Juego Completo</td></tr>							<tr style="background-color: #F2FFFF;"> 
		<?php } ?>
	
	
			<tr> 
				<td rowspan="2" width="15%" class="text-center" style="border: solid;"><a href="adpsinresultados2.php?Id_p2juegosp2=<?php echo $row_Recordset1futbolame['juegop5']; ?>&equipo1=<?php echo $row_Recordset1futbolame['equipo1p5']; ?>&equipo2=<?php echo $row_Recordset1futbolame['equipo2p5']; ?>&logrodtp3=<?php echo $row_Recordset1futbolame['iniciodtp5'];?>" class="btn btn-outline-danger" target="_blank"><?php echo substr($row_Recordset1futbolame['iniciodtp5'], 0, -8); ?><br><span class="VsOdds">VS..</span><br><?php echo substr($row_Recordset1futbolame['iniciodtp5'], 10); ?></a></br><?php if($quienmete2==1){echo 'RESUTALDO INGRESADO POR '.$quienmete; } ?></td>
				<td rowspan="2" width="20%" class="text-center" style="font-size: 15px;"><?php if($row_Recordset301['competicionp2'] <> ' '){echo '<b>'. $row_Recordset301['competicionp2'];}else{}?></td>
	
				<td width="25%" class="text-center"><?php echo $row_Recordset1futbolame['equipo1p5']; ?></td>

				<?php if ($row_Recordset1futbolame['r21p5']==999) {?>
					<td rowspan="2" colspan="3" class="text-center" style="font-size: 30px;"><?php echo "Juego Aplazado";?></td>
					<?php
					}else {
					?>

				<td class="text-center"><?php echo $row_Recordset1futbolame['r21p5']; ?></td>
				<td class="text-center"><?php echo $row_Recordset1futbolame['r23p5']; ?></td>
				<td class="text-center"><?php echo $row_Recordset1futbolame['r23p5']+$row_Recordset1futbolame['r21p5']; ?></td>

					<?php
					}
		  			?>
			</tr>
			
			<tr> 
				<td width="25%" class="text-center"><?php echo $row_Recordset1futbolame['equipo2p5']; ?></td>

				<?php if ($row_Recordset1futbolame['r22p5']==999) {?>
									
					<?php
					}else {
					?>

				<td class="text-center"><?php echo $row_Recordset1futbolame['r22p5']; ?></td>
				<td class="text-center"><?php echo $row_Recordset1futbolame['r24p5']; ?></td>
				<td class="text-center"><?php echo $row_Recordset1futbolame['r24p5']+$row_Recordset1futbolame['r22p5']; ?></td>
			
					<?php 							
					}
		  
          			?>
			
			</tr>
															
	
		<?php
		}



} while ($row_Recordset1futbolame = mysqli_fetch_assoc($Recordset1futbolame));
}
?>
</tbody>
</table>
      
<!-- Fin Contenido --> 
</div>
</div>
<!-- Fin row --> 



<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>

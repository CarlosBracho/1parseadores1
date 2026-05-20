
<?php 
	
	session_start();
	require_once('../Connections/conexionbanca.php');
$hostname_conexionbanca = "p:localhost";
$database_conexionbanca = "apuestas2";
$username_conexionbanca = "root";
$password_conexionbanca = "ios9X4CJ748J";
$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);
mysqli_set_charset($conexionbanca, 'utf8');

 ?>
<div class="row">
	<div class="col-sm-12">
	<h2>Lista de Equipos </h2>
		<table class="table table-hover table-condensed table-bordered">
		<caption>
			<button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo">
				Agregar Nuevo 
				<span class="glyphicon glyphicon-plus"></span>
			</button>
		</caption>
			<tr>
				<td style="background: black; color:white">Nombre en</br>Wininbet</td>
				<td style="background: black; color:white">Nombre en</br> Maradeportes</td>
				<td style="background: black; color:white">Maradeportes Pais</td>
				<td style="background: black; color:white">Nombre en</br> Sellatuparley</td>
				<td style="background: black; color:white">Deporte</td>
				<td style="background: black; color:white">Liga</td>
				<td style="background: black; color:white">Pais</td>
				<td style="background: black; color:white">Editar</td>
				<!--<td>Eliminar</td>-->
			</tr>

			<?php 

				if(isset($_SESSION['consulta'])){
					if($_SESSION['consulta'] > 0){
						$idp=$_SESSION['consulta'];
						$sql="/* PARSEADORES1 parley\tablaBD2.php - QUERY 1 */ SELECT Id_p1equiposp1, nomequipop1, nommara, nomsella, deportep1, liga, pais, nommarapais
						from p1equipos where Id_p1equiposp1='$idp'";
					}else{
						$sql="/* PARSEADORES1 parley\tablaBD2.php - QUERY 2 */ SELECT Id_p1equiposp1, nomequipop1, nommara, nomsella, deportep1, liga, pais, nommarapais
						from p1equipos";
					}
				}else{
					$sql="/* PARSEADORES1 parley\tablaBD2.php - QUERY 3 */ SELECT Id_p1equiposp1, nomequipop1, nommara, nomsella, deportep1, liga, pais, nommarapais
						from p1equipos";
				}

				$result=mysqli_query($conexionbanca,$sql);
				while($ver=mysqli_fetch_row($result)){ 

					$datos=$ver[0]."||".
						   $ver[1]."||".
						   $ver[2]."||".
						   $ver[3]."||".
						   $ver[4]."||".
						   $ver[5]."||".
						   $ver[6]."||".
						   $ver[7];
			 ?>

			<tr>
			   
				<td><?php echo $ver[1] ?></td>
				<td><?php echo $ver[2] ?></td>
				<td><?php echo $ver[7] ?></td>

				<td><?php echo $ver[3] ?></td>
				<td><?php if($ver[4]==0){ echo 'Beisbol'; $ver[4]='Beisbol';} if($ver[4]==1){ echo 'Baloncesto'; $ver[4]='Baloncesto';} if($ver[4]==2){ echo 'Futbol'; $ver[4]='Futbol';} if($ver[4]==3){ echo 'nose3'; $ver[4]='nose3';} if($ver[4]==4){ echo 'Futbol Americano'; $ver[4]='Futbol Americano';} if($ver[4]==5){ echo 'Hockey'; $ver[4]='Hockey';}

?></td>
				<td><?php echo $ver[5] ?></td>
				<td><?php echo $ver[6] ?></td>
				<td>
					<button class="btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#modalEdicion" onclick="agregaform('<?php echo $datos ?>')">
						
					</button>
				</td>
				
			</tr>
			<?php 
		}
			 ?>
		</table>
	</div>
</div>

<?php 
	require_once('../Connections/conexionbanca.php');
	
	
	$id=$_POST['Id_p1equiposp1'];

	$sql="/* PARSEADORES1 new\parley\eliminarDatos.php - QUERY 1 */ DELETE from p1equipos where Id_p1equiposp1='$id'";
	echo $result=mysqli_query($conexionbanca,$sql);
 ?>
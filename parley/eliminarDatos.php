
<?php 
	require_once('../Connections/conexionbanca.php');
	$hostname_conexionbanca = "p:localhost";
$database_conexionbanca = "apuestas2";
$username_conexionbanca = "root";
$password_conexionbanca = "ios9X4CJ748J";
$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);
mysqli_set_charset($conexionbanca, 'utf8');
	
	$id=$_POST['Id_p1equiposp1'];

	$sql="/* PARSEADORES1 parley\eliminarDatos.php - QUERY 1 */ DELETE from p1equipos where Id_p1equiposp1='$id'";
	echo $result=mysqli_query($conexionbanca,$sql);
 ?>
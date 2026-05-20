<?php 

require_once('../Connections/conexionbanca.php');
$hostname_conexionbanca = "p:localhost";
$database_conexionbanca = "apuestas2";
$username_conexionbanca = "root";
$password_conexionbanca = "ios9X4CJ748J";
$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);
mysqli_set_charset($conexionbanca, 'utf8');
	$n=$_POST['nomequipop1'];
	$nm=$_POST['nommara'];
	$ns=$_POST['nomsella'];
	$d=$_POST['deportep1'];
	$l=$_POST['liga'];
	$p=$_POST['pais'];

	$sql="/* PARSEADORES1 new\parley\agregarDatosBD2.php - QUERY 1 */ INSERT into p1equipos (nomequipop1,nommara,nomsella,deportep1,liga,pais)
								values ('$n','$nm','$ns','$d','$l','$p')";
	echo $result=mysqli_query($conexionbanca,$sql);

 ?>
<?php 
	require_once('../Connections/conexionbanca.php');
	$id_equipo=$_POST['Id_p1equiposp1'];
	$n=$_POST['nomequipop1'];
	$nm=$_POST['nommara'];
	$ns=$_POST['nomsella'];
	$d=$_POST['deportep1'];
	$l=$_POST['liga'];
	$p=$_POST['pais'];

	$sql="/* PARSEADORES1 new\parley\actualizaDatos.php - QUERY 1 */ UPDATE p1equipos set nomequipop1='$n',
								nommara='$nm',
								nomsella='$ns',
								deportep1='$d',
								liga='$l',
								pais='$p'
				where Id_p1equiposp1 ='$id_equipo'";
	echo $result=mysqli_query($conexionbanca,$sql);

 ?>
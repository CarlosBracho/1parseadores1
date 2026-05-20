<?php 
	require_once('../Connections/conexionbanca.php');





	$id_equipo=$_POST['Id_p1equiposp1'];
	$n=$_POST['nomequipop1'];
	$nm=$_POST['nommara'];
	$nommarapais=$_POST['nommarapais'];
	$ns=$_POST['nomsella'];
	$d=$_POST['deportep1'];
	$l=$_POST['liga'];
	$p=$_POST['pais'];

	$sql="/* PARSEADORES1 parley\actualizaDatos.php - QUERY 1 */ UPDATE p1equipos set nomequipop1='$n',
								nommara='$nm',
								nommarapais='$nommarapais',
								nomsella='$ns',
								deportep1='$d',
								liga='$l',
								pais='$p'
				where Id_p1equiposp1 ='$id_equipo'";
	echo $result=mysqli_query($conexionbanca,$sql);

 ?>
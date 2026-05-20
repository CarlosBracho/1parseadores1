<?php 

require_once('../Connections/conexionbanca.php');




	$n=$_POST['nomequipop1'];
	$nm=$_POST['nommara'];
	$nommarapais=$_POST['nommarapais'];
	$ns=$_POST['nomsella'];
	$d=$_POST['deportep1'];
	$l=$_POST['liga'];
	$p=$_POST['pais'];

	$sql="/* PARSEADORES1 parley\agregarDatos.php - QUERY 1 */ INSERT into p1equipos (nomequipop1,nommara,nommarapais,nomsella,deportep1,liga,pais)
								values ('$n','$nm','$nommarapais','$ns','$d','$l','$p')";
	echo $result=mysqli_query($conexionbanca,$sql);

 ?>
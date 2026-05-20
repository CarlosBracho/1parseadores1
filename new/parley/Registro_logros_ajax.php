<?php 
	require_once('../Connections/conexionbanca.php');

	$horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $datetime=$FechaTxt.' '.$horaTxt;
	$datetime2=$FechaTxt.' '.$horaTxt;
    $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$datetime = strtotime('+8 hours', strtotime($datetime));
$datetime = date("Y-m-d H:i:s", $datetime );
//echo $datetime;


$datetime2 = strtotime('+30 minute', strtotime($datetime2));
$datetime2 = date("Y-m-d H:i:s", $datetime2 );

		//$tjugada=$_POST['tipojugada'];
		$logro=$_POST['logro2'];
 
		$idj=$_POST['idjuegop32'];
		$equipo=$_POST['numequipo'];
		$tjugada=$_POST['tipojugadap32'];
		if($tjugada=='ML'){
			$logroab="";
		}else{
			$logroab=$_POST['logroABoRL2'];
	}
		$idep1=$_POST['idequipo1p2'];  
	

		$query_Recordset1111 = sprintf(
			"/* PARSEADORES1 new\parley\Registro_logros_ajax.php - QUERY 1 */ SELECT iniciodtp2
			FROM  p2juegos
			WHERE Id_p2juegosp2=%s",
			GetSQLValueString($idj, "int"));
			$Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
			$row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
			$totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
			 
		
			$insertSQL = sprintf(
				"/* PARSEADORES1 new\parley\Registro_logros_ajax.php - QUERY 2 */ INSERT 
						INTO p3logros
						(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
						VALUES (%s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($idj, "int"),
				GetSQLValueString($idep1, "int"),
				GetSQLValueString($equipo, "int"),
				GetSQLValueString($tjugada, "text"),
				GetSQLValueString($logro, "double"),
				GetSQLValueString($datetime2, "date"),
				GetSQLValueString($logroab, "text")
			);
				
			echo $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

 ?>
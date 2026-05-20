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
		$logro=$_POST['logro'];
		$logroab=$_POST['logroABoRL'];
		$idlogro=$_POST['Id_p3logrosp3'];  
	

		$query_Recordset1111 = sprintf(
			"/* PARSEADORES1 new\parley\Actualiza_logros.php - QUERY 1 */ SELECT PDOS.iniciodtp2, PTRES.idjuegop3
			FROM  p3logros PTRES, p2juegos PDOS
			WHERE PTRES.Id_p3logrosp3=%s AND PDOS.Id_p2juegosp2=PTRES.idjuegop3",
			GetSQLValueString($_POST['Id_p3logrosp3'], "int"));
			$Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
			$row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
			$totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);



		$insertSQL = sprintf(
			"/* PARSEADORES1 new\parley\Actualiza_logros.php - QUERY 2 */ UPDATE p3logros
					SET 
					logrop3=%s, logrodtp3=%s, logroABoRLp3=%s 
					WHERE Id_p3logrosp3=%s",
			GetSQLValueString($logro, "double"),
			GetSQLValueString($row_Recordset1111['iniciodtp2'], "date"),
			GetSQLValueString($logroab, "text"),
			GetSQLValueString($idlogro, "int")
		);
			
		echo $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

 ?>
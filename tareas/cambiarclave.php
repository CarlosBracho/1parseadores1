<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('./Connections/conexionbanca.php');


if (!isset($_SESSION['usuario'])) {
	$MM_redirectLoginSuccess = "index.php";
	header("Location: ". $MM_redirectLoginSuccess);
}
$editFormAction = $_SERVER['PHP_SELF'];

$query_Recordset2 = sprintf(
	"/* PARSEADORES1 tareas\cambiarclave.php - QUERY 1 */ SELECT *
	FROM 
		tablausuario
	WHERE 
	id_usuario = %s",
	GetSQLValueString($_SESSION['usuario'], "int"));
	$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
	$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

	if ($totalRows_Recordset2==0) {
		$MM_redirectLoginSuccess = "index.php";
		header("Location: ". $MM_redirectLoginSuccess);
	}

   
	$query_Recordset18 = sprintf("/* PARSEADORES1 tareas\cambiarclave.php - QUERY 2 */ SELECT * FROM tablausuario WHERE id_usuario = %s",
	GetSQLValueString($_SESSION['usuario'], "int"));
	$Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
	$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
	$totalRows_Recordset18 = mysqli_num_rows($Recordset18);
		
	$Novalido=1;
		if(empty($_POST['password1'])){
        }else if($row_Recordset18['pass_usuario']==($_POST['password1'])){


			$insertSQL1 = sprintf(
				"/* PARSEADORES1 tareas\cambiarclave.php - QUERY 3 */ UPDATE tablausuario
					SET
					pass_usuario = %s 
					WHERE id_usuario = %s",
			GetSQLValueString($_POST['password2'], "text"),
			GetSQLValueString($_SESSION['usuario'], "int"));
		
			$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

		  $MM_redirectLoginSuccess = "tareas_finalizadas.php";
		  header("Location: ". $MM_redirectLoginSuccess);
		}else{
			$Novalido=0;	
		} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Edit </title>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
<?php
include("cabecera.php") 
    ?>

<div style="background: black; color:white">

<section id="container">
<center><h2>Edifcion de Tarea.</h2></center>

<h4> <?php echo "Nombre de Usuario: ".$row_Recordset2['nom_usuario'].'<br><br>';?> </h4>
</div>

<table width="100%" style="text-align: center;" border= cellpadding="0" cellspacing="0" style="line-height:14px">
<tr valign="baseline">
                  <td> <br>
                  <form method="POST" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
                      ESTADO DE LA TAREA:<br /><br />
					  <?php if($Novalido==0){  
					 echo "Su Contraseña actual no coincide con la anterior"; 
					}
					  ?><br>
                    <input type="password" name="password1" placeholder="Ingrese vieja contrasena">
					<input type="password" name="password2" placeholder="Ingrese nueva contrasena" >
					<input type="submit" value="enviar">
                  </form>
                  </td>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>
</html>
	
</body>
</html>
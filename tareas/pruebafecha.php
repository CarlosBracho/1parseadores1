<?php  
require_once('./Connections/conexionbanca.php');

$query_Recordset18 = sprintf("/* PARSEADORES1 tareas\pruebafecha.php - QUERY 1 */ SELECT * FROM tablausuario ORDER BY tablausuario.id_usuario ");
$Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);


if(!empty(($_POST['Usuario'])) && !empty($_POST['Tarea'])){
$insertSQL1 = sprintf(
  "/* PARSEADORES1 tareas\pruebafecha.php - QUERY 2 */ INSERT 
  INTO tablatarea
  (id_usuario, tareatext) 
  VALUES (%s, %s)",
  GetSQLValueString(($_POST['Usuario']), "int"),
  GetSQLValueString(($_POST['Tarea']), "text"));
  $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Tareas add</title>
</head>
<body>
  
<?php
include("cabecera.php") 
    ?>

    <div style="background: black; color:white">

<section id="container">
<center><h2>Crear Nueva Tarea.</h2></center>

<h4> <?php echo "Nombre de Usuario: ".$row_Recordset18['nom_usuario'].'<br><br>';?> </h4>
</div>

<form action="./tareas_add.php" method="post" name="Form1" id="Form1"> 
<center><h3 style="font-size:24px; font-weight: bold; background:#020202; color:#FFFFFF; height: 50px; padding: 10px">Asignar Tarea a:</h3></center><br>
  <center>
  <select name="Usuario" id="soflow" style="height:40px; width:280px; margin:-9px 0px 0px 0px; border:solid;">
                      <option value=""> Selecionar</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset18['id_usuario']?>">
							 <?php echo strtoupper($row_Recordset18['nom_usuario']); ?>
               </option>
                      <?php
                } while ($row_Recordset18 = mysqli_fetch_assoc($Recordset18));
                ?>
                    </select><br><br>
<center><h3 style="font-size:24px; font-weight: bold; background:#020202; color:#FFFFFF; height:30px">Descripcion de la Tarea</h3></center><br>
  <input type="text" name="Tarea" id="" style="width: 1000px; padding: 20px; border: solid;"><br><br>
  <input type="submit" value="Crear" style="background-color: black; color:white; font-size:20px">
  </center>
</form>

 <?php
date_default_timezone_set ('America/Venezuela');
$fecha_actual=date("Y-m-d H:i:s")

?>

<form action="" method="post">
<label>FECHA: <br> <input type="datetime" name="fecha" value="<?= $fecha_actual ?>" ></label><br>
<br>

<input type="submit" name="ingresar" value="ingresar Fecha">

</form>

<footer class="text-center text-white fixed-bottom" style="background-color:black;">
  <!-- Grid container -->
  <div class="container p-4"></div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2021 Copyright:
    <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
  </div>
  <!-- Copyright -->
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
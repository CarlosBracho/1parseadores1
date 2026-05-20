<?php  
if (!isset($_SESSION)) {
    session_start();
}
require_once('./Connections/conexionbanca.php');




if (!isset($_SESSION['usuario'])) {
	$MM_redirectLoginSuccess = "index.php";
	header("Location: ". $MM_redirectLoginSuccess);
}


$query_Recordset1 = sprintf(
    "/* PARSEADORES1 tareas\Pruebahome.php - QUERY 1 */ SELECT *
    FROM 
        tablatarea
    WHERE 
        id_usuario = %s AND estado_tarea = 0
    ORDER BY id_tarea",

    GetSQLValueString($_SESSION['usuario'], "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);

    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 tareas\Pruebahome.php - QUERY 2 */ SELECT *
        FROM 
            tablausuario,tablatarea 
        WHERE 
        tablausuario.id_usuario = %s",
        GetSQLValueString($_SESSION['usuario'], "int"));
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);


        if ($totalRows_Recordset2==0) {
            $MM_redirectLoginSuccess = "index.php";
            header("Location: ". $MM_redirectLoginSuccess);
        }


        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="tareas_lista.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <?php
include("cabecera.php")
    ?> <br>

<div style="background: black; color:white">

<section id="container">
<center><h1>Lista de Tareas.</h1></center>

<h4> <?php echo "Nombre de Usuario: ".$row_Recordset2['nom_usuario'].'<br><br>';?> </h4>
</div>


<div style="height:100%; font-size:28px; padding:10px 10px 10px 10px; float:right;">
            <a href="./tareas_add.php" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nueva tarea">
                Añadir Nueva Tarea
            </a>
        </div>
<div style="height:100%; font-size:28px; padding:10px 10px 10px 10px; float:right;">
            <a href="./tareas_finalizadas.php" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="Tareas Pendientes">
                Tareas Finalizadas
            </a>
            
        </div>
        
<table>
<tr>
    <th>ID</th>
    <th>Nombre de Tarea</th>
    <th>Acciones</th>
    <th>Estado</th>
</tr>

<?php 

if($totalRows_Recordset1>0){
do {

    ?>
<tr>
    <td>
    <?php  echo $row_Recordset1['id_tarea'] ?>
    </td>
    <td>
    <?php  echo $row_Recordset1['tareatext'] ?>

    </td>
    <td>
        <a class="link_edit" href="./prueba.php?recordID=<?php echo $row_Recordset1['id_tarea']; ?>">EDITAR</a>
       
    </td>
    <td>
        <?php
    if( $row_Recordset1 ['estado_tarea'] =="1"){
             echo'Finalizada';
          }else{
             echo'Pendiente';
          }
        ?>
    </td>
</tr>
<?php 
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}else{
    ?>
    <tr>
    <td>
<h3>No Tiene Tareas Pendientes</h3>
</td>
</tr>
<?php 
}
?>

</table>

</section>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

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
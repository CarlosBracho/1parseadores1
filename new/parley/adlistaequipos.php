<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

            $where = "WHERE 
			deportep1 >= 0";
    
    if (!empty($_POST)) {
        $valor = $_POST['campo'];
        if (!empty($valor)) {
            $where = "WHERE 
			nomequipop1 LIKE '%$valor%' ";
        }
    }
    $query_Recordset1 = "/* PARSEADORES1 new\parley\adlistaequipos.php - QUERY 1 */ SELECT * FROM p1equipos $where";
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    
    
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>.:Apuestas:.</title>

<!-- Bootstrap core CSS -->
<link href="../bootstrap4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
 <script src="../bootstrap4.5.0/js/bootstrap.min.js"></script>

</head>

<body>
<?php
require_once('../parley/admenu.php');
?>

<div class="container">
<table class="table">
<th scope="col">
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<b>Nombre: </b><input type="text" id="campo" name="campo" />
					<input type="submit" id="enviar" name="enviar" value="Buscar" class="btn btn-info" />
				</form>
				</th>
				<th scope="col">
				<div><a href="adagregarequipo.php" type="button" class="btn btn-warning">Agregar Equipo</a></div>
				</th>
				</table>
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
      
      <table class="table">
        <thead class="thead-dark">
          <tr>

<th scope="col">Nombre del</br>Equipo</th>
<th scope="col">Nombre en </br> Maradeportes</th>
<!--<th scope="col">Nombre en </br>Sella tu Parley</th>-->
<th scope="col">Deporte</th>
<th scope="col">Liga</th>
<th scope="col">Pais</th>
<!--<th scope="col">Orden</th>-->
<th scope="col">Editar</th>
  
          </tr>
        </thead>
        <tbody>
          <?php

do {
    ?>
          <tr>

    <td><?php echo $row_Recordset1['nomequipop1'];
    echo '</br>';
    echo $row_Recordset1['nomdimp1']; ?></td>

      <td><?php echo $row_Recordset1['nommara'];?></td>

      <!--<td><?php //echo $row_Recordset1['nomsella'];?></td>-->
		
		
      <td><?php if ($row_Recordset1['deportep1']==0) {
            echo 'Beisbol';           
            }
            ?>
          <?php if ($row_Recordset1['deportep1']==1) {
            echo 'Baloncesto';           
            }
            ?>
            <?php if ($row_Recordset1['deportep1']==2) {
            echo 'Futbol';           
            }
            ?>
            <?php if ($row_Recordset1['deportep1']==5) {
            echo 'Hockey';           
            }
            ?>
            <?php if ($row_Recordset1['deportep1']==4) {
            echo 'Futbol Americano';           
            }
            ?>
        </td>
		<td><?php echo $row_Recordset1['liga']; ?></td>
    <td><?php echo $row_Recordset1['pais']; ?></td>
		<!--<td><?php //echo $row_Recordset1['ordenp1']; ?></td>-->
        

		<td><a href="adeditarequipo.php?recordID=<?php echo $row_Recordset1['Id_p1equiposp1']; ?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span>Editar</a></td>
          </tr>
          <?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
?>
        </tbody>
      </table>
      
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>
<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

</body>
</html>

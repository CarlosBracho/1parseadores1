<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$codigoAgente=$_SESSION['MM_cod_agente'];

            $where = "WHERE 
			taquilla.tipotaquilla = 3 AND
			taquilla.cod_agencia  = agencia.cod_agencia AND
            agencia.cod_agencia = '$codigoAgente'";
    
    if (!empty($_POST)) {
        $valor = $_POST['campo'];
        if (!empty($valor)) {
            $where = "WHERE 
			taquilla.tipotaquilla = 3 AND
			agencia.cod_agencia = taquilla.cod_agencia AND
            agencia.cod_agencia = '$codigoAgente' AND
			taquilla.nom_taquilla LIKE '%$valor%' ";
        }
    }
    $query_Recordset1 = "/* PARSEADORES1 new\apostador\listaapostadora.php - QUERY 1 */ SELECT * FROM taquilla, agencia $where";
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
<header> 
  <!-- Fixed navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    
	
	
	<ul class="navbar-nav mr-auto">
	  	        <li class="nav-item">
         <a class="dropdown-item" href="listaapostadora.php">Lista De Apostadores</a>
      </li>

	        <li class="nav-item">
        <a class="dropdown-item" href="reporteaa.php">Reporte General<span class="sr-only">(current)</span></a>
      </li>

	        <li class="nav-item">
        <a class="dropdown-item" href="../agente/index.php">Volver<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cerrar_sesion_apostador.php">Salir</a>
      </li>
    </ul>
	
	

  </div>
</nav>
</header>

<!-- Begin page content -->

<div class="container">
<table class="table">
<th scope="col">
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<b>Nombre: </b><input type="text" id="campo" name="campo" />
					<input type="submit" id="enviar" name="enviar" value="Buscar" class="btn btn-info" />
				</form>
				</th>
				<th scope="col">
				<div><a href="crearapostadora.php" type="button" class="btn btn-warning">Crear Apostador</a></div>
				</th>
				</table>
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
      
      <table class="table">
        <thead class="thead-dark">
          <tr>

<th scope="col">Cliente / Telefono</th>
<th scope="col">Saldo</th>
<th scope="col">Modificar Saldo</th>
<th scope="col">Reporte</th>
<th scope="col">Editar</th>
          </tr>
        </thead>
        <tbody>
          <?php

do {
    ?>
          <tr>

            <td><?php echo $row_Recordset1['nom_taquilla'];
    echo '</br>';
    echo $row_Recordset1['tel_taquilla']; ?></td>
			
			
			<?php
                                                        $query_Recordset13 = sprintf(
        "/* PARSEADORES1 new\apostador\listaapostadora.php - QUERY 2 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
        GetSQLValueString(3, "int"),
        GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
    );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    $Idbalancecli=((int)$row_Recordset13['MAX(Idbalancecli)']);
    
    $query_Recordset14 = sprintf(
        "/* PARSEADORES1 new\apostador\listaapostadora.php - QUERY 3 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
        GetSQLValueString(3, "int"),
        GetSQLValueString($Idbalancecli, "int")
    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    $saldoactualc=((float)$row_Recordset14['saldoactualc']); ?>
	
        <td><?php echo $saldoactualc; ?> USD</td>
		<td><a href="modificarsaldoa.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>&recordID2=<?php echo $row_Recordset1['nom_taquilla']; ?>"  class="btn btn-info" />Modificar Saldo</td>
		<td><a href="reporteaa.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>"  class="btn btn-info" />Reporte</td>

		<td><a href="editarapostadora.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span>Editar</a></td>
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

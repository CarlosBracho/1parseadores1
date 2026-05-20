<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$codigoDistri=$_SESSION['MM_cod_banca'];

if (isset($_GET["recordID"])) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\apostador\reportead.php - QUERY 1 */ SELECT *
					FROM balanceclientes, taquilla
					WHERE
					taquilla.cod_taquilla = balanceclientes.cod_taquilla AND
					taquilla.cod_taquilla = %s
					ORDER BY Idbalancecli 
					DESC ",
        GetSQLValueString($_GET["recordID"], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
} else {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\apostador\reportead.php - QUERY 2 */ SELECT *
					FROM balanceclientes, taquilla, agencia, banca
					WHERE
					taquilla.cod_taquilla = balanceclientes.cod_taquilla AND
					agencia.cod_agencia = taquilla.cod_agencia AND
					agencia.cod_banca = banca.cod_banca AND
					banca.cod_banca = %s
					ORDER BY Idbalancecli 
					DESC ",
        GetSQLValueString($codigoDistri, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
}

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
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>

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
         <a class="dropdown-item" href="listaapostadorad.php">Lista De Apostadores</a>
      </li>

	        <li class="nav-item">
        <a class="dropdown-item" href="reportead.php">Reporte General<span class="sr-only">(current)</span></a>
      </li>

	        <li class="nav-item">
        <a class="dropdown-item" href="../distri/index.php">Volver<span class="sr-only">(current)</span></a>
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
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
      
      <table class="table">
        <thead class="thead-dark">
          <tr>

            <th scope="col">Agente</BR>Apostador</BR>Fecha</BR>Registro #</th>
            <th scope="col">Descripcion</th>
			<th scope="col">Tipo /</BR> Agreago Por</th>
            <th scope="col">Monto</th>
            <th scope="col">Saldo</th>
          </tr>
        </thead>
        <tbody>
          <?php

do {
    ?>
          <tr>

            <td><?php echo $row_Recordset1['nom_agencia'];
    echo '</BR>';
    echo $row_Recordset1['nom_taquilla'];
    echo '</BR>';
    echo $row_Recordset1['fec_venta'];
    echo '</BR>';
    echo $row_Recordset1['numticket']; ?></td>
            <td><?php echo $row_Recordset1['jugada']; ?></td>
			<td><?php
if ($row_Recordset1['tipo']==0) {
        echo 'APUESTA /';
    }
    if ($row_Recordset1['tipo']==1) {
        echo 'PREMIO /';
    }
    if ($row_Recordset1['tipo']==2) {
        echo 'RETIRO /';
    }
    if ($row_Recordset1['tipo']==3) {
        echo 'ABONO /';
    }
    if ($row_Recordset1['tipo']==4) {
        echo 'REINTEGRO /';
    }
    if ($row_Recordset1['tipo']==5) {
        echo 'AJUSTE /';
    }
    if ($row_Recordset1['tipo']==6) {
        echo 'ELIMINADA /';
    }
    if ($row_Recordset1['tipo']==7) {
        echo 'RETIRO EXTERNO /';
    }
    if ($row_Recordset1['tipo']==8) {
        echo 'ABONO EXTERNO /';
    }
    if ($row_Recordset1['agregadox']==0) {
        echo '</BR>SISTEMA';
    }
    if ($row_Recordset1['agregadox']==1) {
        echo '</BR>APOSTADOR';
    }
    if ($row_Recordset1['agregadox']==2) {
        echo '</BR>AGENTE';
    }
    if ($row_Recordset1['agregadox']==3) {
        echo '</BR>DISTRIBUIDOR';
    }
    if ($row_Recordset1['agregadox']==4) {
        echo '</BR>ADMINISTRADOR';
    } ?>
			</td>
            <td><?php echo $row_Recordset1['monto'];
    if ($row_Recordset1['monedac']==0) {
        echo ' BSS';
    }
    if ($row_Recordset1['monedac']==1) {
        echo ' BSS';
    }
    if ($row_Recordset1['monedac']==2) {
        echo ' BSS';
    }
    if ($row_Recordset1['monedac']==3) {
        echo ' USD';
    }
    if ($row_Recordset1['monedac']==4) {
        echo ' COP';
    }
    if ($row_Recordset1['monedac']==5) {
        echo ' SOL';
    } ?>
			</td>
            <td><?php echo $row_Recordset1['saldoactualc'];
    if ($row_Recordset1['monedac']==0) {
        echo ' BSS';
    }
    if ($row_Recordset1['monedac']==1) {
        echo ' BSS';
    }
    if ($row_Recordset1['monedac']==2) {
        echo ' BSS';
    }
    if ($row_Recordset1['monedac']==3) {
        echo ' USD';
    }
    if ($row_Recordset1['monedac']==4) {
        echo ' COP';
    }
    if ($row_Recordset1['monedac']==5) {
        echo ' SOL';
    } ?></td>
         
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

<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>

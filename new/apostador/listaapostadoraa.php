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
        if (!empty($_POST['campo'])) {
            $valor = $_POST['campo'];
            if (!empty($valor)) {
                $where = "WHERE 
			taquilla.tipotaquilla = 3 AND
			agencia.cod_agencia = taquilla.cod_agencia AND
            agencia.cod_agencia = '$codigoAgente' AND
			taquilla.nom_taquilla LIKE '%$valor%' ";
            }
        }
        
        if (!empty($_POST['telefonoa'])) {
            $telefonoa = $_POST['telefonoa'];

            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 1 */ UPDATE agencia 
				SET tel_agencia=%s
			
				WHERE cod_agencia=%s",
                GetSQLValueString($_POST['telefonoa'], "text"),
                GetSQLValueString($codigoAgente, "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        }
    }
    $query_Recordset1 = "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 2 */ SELECT * FROM taquilla, agencia $where";
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
<script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
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
         <a class="dropdown-item" href="listaapostadoraa.php">Lista De Apostadores</a>
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
<form class="form-horizontal" name="form1" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" onsubmit="return chequearEnvio();">
<td>
	<div class="form-group">
					
					</div>
					</td><td>
					<div class="form-group">
					
						<input type="tel" class="form-control" id="telefonoa" name="telefonoa" value="<?php echo$row_Recordset1['tel_agencia']; ?>" placeholder="04120000000" >
					</div>
				</td><td>
<button type="submit" class="btn btn-primary">Agregar/Modificar Numero Soporte</button>
<td>
</div>
</form>
</table>
<table class="table">
<th scope="col">
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<b>Nombre: </b><input type="text" id="campo" name="campo" />
					<input type="submit" id="enviar" name="enviar" value="Buscar" class="btn btn-info" />
				</form>
				</th>
				<th scope="col">
				<div><a href="crearapostadoraa.php" type="button" class="btn btn-warning">Crear Apostador</a></div>
				</th>
				</table>
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
      
      <table class="table">
        <thead class="thead-dark">
          <tr>

<th scope="col">Apostador</br>Telefono</th>
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
        "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 3 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
    );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    $Idbalancecli0=((int)$row_Recordset13['MAX(Idbalancecli)']);
    
    $query_Recordset14 = sprintf(
        "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 4 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($Idbalancecli0, "int")
    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    $saldoactualc0=((float)$row_Recordset14['saldoactualc']);
    
    $query_Recordset15 = sprintf(
        "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 5 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
        GetSQLValueString(3, "int"),
        GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
    );
    $Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
    $row_Recordset15 = mysqli_fetch_assoc($Recordset15);
    $totalRows_Recordset15 = mysqli_num_rows($Recordset15);
    $Idbalancecli3=((int)$row_Recordset15['MAX(Idbalancecli)']);
    
    $query_Recordset16 = sprintf(
        "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 6 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
        GetSQLValueString(3, "int"),
        GetSQLValueString($Idbalancecli3, "int")
    );
    $Recordset16 = mysqli_query($conexionbanca, $query_Recordset16) or die(mysqli_error($conexionbanca));
    $row_Recordset16 = mysqli_fetch_assoc($Recordset16);
    $totalRows_Recordset16 = mysqli_num_rows($Recordset16);
    $saldoactualc3=((float)$row_Recordset16['saldoactualc']);
    
    $query_Recordset17 = sprintf(
        "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 7 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
        GetSQLValueString(4, "int"),
        GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
    );
    $Recordset17 = mysqli_query($conexionbanca, $query_Recordset17) or die(mysqli_error($conexionbanca));
    $row_Recordset17 = mysqli_fetch_assoc($Recordset17);
    $totalRows_Recordset17 = mysqli_num_rows($Recordset17);
    $Idbalancecli4=((int)$row_Recordset17['MAX(Idbalancecli)']);
    
    $query_Recordset18 = sprintf(
        "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 8 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
        GetSQLValueString(4, "int"),
        GetSQLValueString($Idbalancecli4, "int")
    );
    $Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
    $row_Recordset18 = mysqli_fetch_assoc($Recordset18);
    $totalRows_Recordset18 = mysqli_num_rows($Recordset18);
    $saldoactualc4=((float)$row_Recordset18['saldoactualc']);
    
    $query_Recordset19 = sprintf(
        "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 9 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
        GetSQLValueString(5, "int"),
        GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
    );
    $Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
    $row_Recordset19 = mysqli_fetch_assoc($Recordset19);
    $totalRows_Recordset19 = mysqli_num_rows($Recordset19);
    $Idbalancecli5=((int)$row_Recordset19['MAX(Idbalancecli)']);
    
    $query_Recordset20 = sprintf(
        "/* PARSEADORES1 new\apostador\listaapostadoraa.php - QUERY 10 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
        GetSQLValueString(5, "int"),
        GetSQLValueString($Idbalancecli5, "int")
    );
    $Recordset20 = mysqli_query($conexionbanca, $query_Recordset20) or die(mysqli_error($conexionbanca));
    $row_Recordset20 = mysqli_fetch_assoc($Recordset20);
    $totalRows_Recordset20 = mysqli_num_rows($Recordset20);
    $saldoactualc5=((float)$row_Recordset20['saldoactualc']); ?>
	
        <td><?php echo $saldoactualc0; ?>_BSS <?php echo $saldoactualc3; ?>_USD <?php echo $saldoactualc4; ?>_COP <?php echo $saldoactualc5; ?>_SOL</td>
		<td><a href="modificarsaldoaa.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>&recordID2=<?php echo $row_Recordset1['nom_taquilla']; ?>"  class="btn btn-info" />Modificar Saldo</td>
		<td><a href="reporteaa.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>"  class="btn btn-info" />Reporte</td>

		<td><a href="editarapostadoraa.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-pencil"></span>Editar</a></td>
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

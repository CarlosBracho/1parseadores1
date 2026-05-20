<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
                            $query_Recordset13 = sprintf(
                                "/* PARSEADORES1 apostador\reportea.php - QUERY 1 */ SELECT cod_taquilla
					FROM usuario
					WHERE
					id_usuario = %s",
                                GetSQLValueString($_SESSION['MM_id_usuario'], "int")
                            );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);





                    $query_Recordset1 = sprintf(
                        "/* PARSEADORES1 apostador\reportea.php - QUERY 2 */ SELECT * 
					FROM balanceclientes
					WHERE
					cod_taquilla = %s ORDER BY Idbalancecli 
					DESC ",
                        GetSQLValueString($row_Recordset13['cod_taquilla'], "int")
                    );
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
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
<script src="../js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript">
 $(document).ready(function() {
	 $("#saldocliente").load('saldoapostador.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	saldocli();
	 }, 30000);

});
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
      <li class="nav-item active">
        <a class="nav-link" href="internacionalesa.php">Apostar Hipismo Internacional<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="reportea.php">Reporte General</a>
      </li>
	  	        <li class="nav-item">
        <a class="dropdown-item" href="cambiomonedaa.php">Cambiar Moneda A Usar</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="dividendosyretiradosa.php">Dividendos y Retirados</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="../gacetas/retrospectosa.php">Retrospectos</a>
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

            <th scope="col"># Ticket Fecha</th>
            <th scope="col">Descripcion</th>
			<th scope="col">tipo</th>
            <th scope="col">Monto</th>
            <th scope="col">Saldo</th>
          </tr>
        </thead>
        <tbody>
          <?php

do {
    ?>
          <tr>

            <td>
<a data-toggle="modal" data-target="#exampleModal" href="../parley/detalle_ticket.php" title="" 
onclick="detalle_ticket(<?php echo $row_Recordset1['numticket']; ?>, <?php echo $row_Recordset1['tipo']; ?>, <?php echo $row_Recordset1['modulo']; ?>); return false">
<?php echo $row_Recordset1['numticket']; ?>
</a></br>
			<?php echo ' ';
    echo $row_Recordset1['fec_venta']; ?>
			
			
			</td>
            <td><?php echo $row_Recordset1['jugada']; ?></td>
			<td><?php
if ($row_Recordset1['tipo']==0) {
        echo 'APUESTA';
    }
    if ($row_Recordset1['tipo']==1) {
        echo 'PREMIO';
    }
    if ($row_Recordset1['tipo']==2) {
        echo 'RETIRO';
    }
    if ($row_Recordset1['tipo']==3) {
        echo 'ABONO';
    }
    if ($row_Recordset1['tipo']==4) {
        echo 'REINTEGRO';
    }
    if ($row_Recordset1['tipo']==5) {
        echo 'AJUSTE';
    }
    if ($row_Recordset1['tipo']==6) {
        echo 'ELIMINADA';
    }
    if ($row_Recordset1['tipo']==7) {
        echo 'RETIRO EXTERNO';
    }
    if ($row_Recordset1['tipo']==8) {
        echo 'ABONO EXTERNO';
    }
    if ($row_Recordset1['modulo']==0 && $row_Recordset1['tipo']==0) {
        echo ' HIPICA';
    }
    if ($row_Recordset1['modulo']==2 && $row_Recordset1['tipo']==0) {
        echo ' PARLEY';
    } ?></td>
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
<script>
    function detalle_ticket(nticket, jtipo, modulo){
        $.post("../parley/detalle_ticket.php", 
        {
		nticket:nticket,
		jtipo:jtipo,
		modulo:modulo
		},
        function(eData){				
            $("#dialog-message").html(eData);
        });	
    } 
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="dialog-message"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div> 
<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$codigoAgente=$_SESSION['MM_cod_agente'];
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$recordID = $_GET['recordID'];
$recordID2 = $_GET['recordID2'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//if ( !empty($_SESSION['act']) && !empty($_POST['act']) && $_POST['act'] == $_SESSION['act'] ) {
if (isset($_POST['tipo'])) {
    $query_Recordset13 = sprintf(
        "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 1 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE 
					
					 monedac = %s AND 
					cod_taquilla = %s",
        GetSQLValueString($_POST['moneda'], "int"),
        GetSQLValueString($_POST['cod_taquilla'], "int")
    );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    $Idbalancecli=((int)$row_Recordset13['MAX(Idbalancecli)']);
    
    $query_Recordset14 = sprintf(
        "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 2 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
        GetSQLValueString($_POST['moneda'], "int"),
        GetSQLValueString($Idbalancecli, "int")
    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    $saldoactualc=((float)$row_Recordset14['saldoactualc']);
                
                
                
                
    $query_Recordset12 = sprintf(
        "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 3 */ SELECT MAX(numticket) 
					FROM balanceclientes
					WHERE 
					monedac = %s AND 
					tipo = %s AND 
					cod_taquilla = %s",
        GetSQLValueString($_POST['moneda'], "int"),
        GetSQLValueString($_POST['tipo'], "int"),
        GetSQLValueString($_POST['cod_taquilla'], "int")
    );
    $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
    $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
    $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
    $numeroticket=((int)$row_Recordset12['MAX(numticket)']);
    
    $insertSQL155 = sprintf(
        "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 4 */ INSERT INTO balanceclientes  
(numticket, cod_taquilla, monto, jugada, fec_venta, hor_venta, saldoactualc, tipo, agregadox, monedac)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($numeroticket+1, "int"),
        GetSQLValueString($_POST['cod_taquilla'], "int"),
        GetSQLValueString($_POST['monto'], "double"),
        GetSQLValueString($_POST['comentario'], "text"),
        GetSQLValueString($FechaTxt, "date"),
        GetSQLValueString($horaTxt, "date"),
        GetSQLValueString($saldoactualc+$_POST['monto'], "double"),
        GetSQLValueString($_POST['tipo'], "int"),
        GetSQLValueString(2, "int"),
        GetSQLValueString($_POST['moneda'], "int")
    );

    $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
    $insertGoTo = "listaapostadoraa.php";

    header(sprintf("Location: %s", $insertGoTo));
}//}
    
                            $query_Recordset13 = sprintf(
                                "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 5 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
                                GetSQLValueString(0, "int"),
                                GetSQLValueString($recordID, "int")
                            );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    $Idbalancecli0=((int)$row_Recordset13['MAX(Idbalancecli)']);
    
                            $query_Recordset14 = sprintf(
                                "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 6 */ SELECT saldoactualc
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
                                    "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 7 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
                                    GetSQLValueString(3, "int"),
                                    GetSQLValueString($recordID, "int")
                                );
    $Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
    $row_Recordset15 = mysqli_fetch_assoc($Recordset15);
    $totalRows_Recordset15 = mysqli_num_rows($Recordset15);
    $Idbalancecli3=((int)$row_Recordset15['MAX(Idbalancecli)']);
    
                            $query_Recordset16 = sprintf(
                                "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 8 */ SELECT saldoactualc
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
                                    "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 9 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
                                    GetSQLValueString(4, "int"),
                                    GetSQLValueString($recordID, "int")
                                );
    $Recordset17 = mysqli_query($conexionbanca, $query_Recordset17) or die(mysqli_error($conexionbanca));
    $row_Recordset17 = mysqli_fetch_assoc($Recordset17);
    $totalRows_Recordset17 = mysqli_num_rows($Recordset17);
    $Idbalancecli4=((int)$row_Recordset17['MAX(Idbalancecli)']);
    
                            $query_Recordset18 = sprintf(
                                "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 10 */ SELECT saldoactualc
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
                                    "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 11 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
                                    GetSQLValueString(5, "int"),
                                    GetSQLValueString($recordID, "int")
                                );
    $Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
    $row_Recordset19 = mysqli_fetch_assoc($Recordset19);
    $totalRows_Recordset19 = mysqli_num_rows($Recordset19);
    $Idbalancecli5=((int)$row_Recordset19['MAX(Idbalancecli)']);
    
                            $query_Recordset20 = sprintf(
                                "/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 12 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
                                GetSQLValueString(5, "int"),
                                GetSQLValueString($Idbalancecli5, "int")
                            );
    $Recordset20 = mysqli_query($conexionbanca, $query_Recordset20) or die(mysqli_error($conexionbanca));
    $row_Recordset20 = mysqli_fetch_assoc($Recordset20);
    $totalRows_Recordset20 = mysqli_num_rows($Recordset20);
    $saldoactualc5=((float)$row_Recordset20['saldoactualc']);
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
<script>
function mostrar(){
var sel=document.getElementById("/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 13 */ select").selectedIndex;
var opt=document.getElementById("/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 14 */ select").options;
document.getElementById("idSeleccionado").value=opt[sel].value;
document.getElementById("textoSeleccionado").value=opt[sel].text;
}
</script>
}
</script>
	</head>
	
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
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
<div class="text-center">
<button type="button" class="btn btn-outline-dark">Saldo actual del apostador <?php echo $recordID2; ?> <?php echo $saldoactualc0; ?> BSS <?php echo $saldoactualc3; ?> USD <?php echo $saldoactualc4; ?> COP <?php echo $saldoactualc5; ?> SOL</button>
 </div>
		<div class="container">
			<div class="row">
				<h3 style="text-align:center">Agregar o Retirar Saldo</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">

								<div class="form-group">
					<label for="estado_civil" class="col-sm-2 control-label">Selecciones Tipo De Ejecucion</label>
					<div class="col-sm-10">
						<select class="form-control" id="/* PARSEADORES1 apostador\modificarsaldoaa.php - QUERY 15 */ select" name="tipo" required onchange="mostrar()">
						    <option value="a" selected="selected">Elige una opción</option>
							<option value="+" class="betoquintanilla">ABONO</option>
							<option value="-" class="betosierra">RETIRO</option>
							<option value="">REINTEGRO</option>
							<option value="">AJUSTE</option>
							<option value="">RETIRO EXTERNO</option>
							<option value="">ABONO EXTERNO</option>
						</select>
						
                       
	
					</div>
				</div>
												<div class="form-group">
					<label for="moneda" class="col-sm-2 control-label">Selecciones Noneda</label>
					<div class="col-sm-10">
						<select class="form-control" id="moneda" name="moneda" required>
						    <option value="">Elige una opción</option>
							<option value="0">Bolivares Soberanos</option>
							<option value="3">Dolar Estadounidense</option>
							<option value="4">Peso Colombiano</option>
							<option value="5">Sol Peruano</option>
						</select>
						

	
	
					</div>
				</div>
				<div class="form-group">
					<label for="nombre" class="col-sm-2 control-label">Comentario Sobre La Ejecucion</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="comentario" name="comentario" placeholder="Comentario"  required>
					</div>
				</div>
				
				
				
				
				<div class="form-group">
					<label for="telefono" class="col-sm-2 control-label">Monto</label>
					<div class="col-sm-10">
                    <p>


						<input type="text" id="idSeleccionado" class="form-control" name="monto" placeholder="Monto" required>
                        </p>
                    </div>
				</div>

				

				

          <input type="hidden" name="cod_taquilla" value="<?php echo $recordID ?>"/>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="listaapostadora.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</div>
				<input type="hidden" id="act" name="act" value="<?php echo (empty($_POST['act']) || $_POST['act']==2)? 1 : 2; ?>">
<?php/*
if ( $_POST['act'] == $_SESSION['act'] ){
    if ( empty( $_SESSION['act'] ) || $_SESSION['act'] == 2 ){
        $_SESSION['act'] = 1;
    } else {
        $_SESSION['act'] = 2;
    }
}*/
?>
				
				
			</form>
		</div>
	</body>
</html>
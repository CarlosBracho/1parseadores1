<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$codigoAgente=$_SESSION['MM_cod_agente'];
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['username'])) {
    $insertSQL = sprintf(
        "/* PARSEADORES1 new\apostador\crearapostadora.php - QUERY 1 */ INSERT 
				INTO taquilla 
				(nom_taquilla, nom_representante, tel_taquilla, tel_taquilla2, tel_taquilla3, cod_agencia, 
taq_vende_ame,
taq_por_ame,
taq_vende_hnac,
taq_cob_hnac,
tipotaquilla,
				est_taquilla) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString(strtoupper($_POST['username']), "text"),
        GetSQLValueString('', "text"),
        GetSQLValueString($_POST['telefono1'], "text"),
        GetSQLValueString(0, "text"),
        GetSQLValueString(0, "text"),
        GetSQLValueString($codigoAgente, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(3, "int"),
        GetSQLValueString(1, "int")
    );// estatus de taquilla
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    
    $query_RecT = "/* PARSEADORES1 new\apostador\crearapostadora.php - QUERY 2 */ SELECT cod_taquilla FROM taquilla ORDER BY cod_taquilla DESC LIMIT 1";
    $RecT = mysqli_query($conexionbanca, $query_RecT) or die(mysqli_error($conexionbanca));
    $row_RecT = mysqli_fetch_assoc($RecT);
    $totalRows_RecT = mysqli_num_rows($RecT);
    $codTaquilla=$row_RecT['cod_taquilla'];
    
    
    
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 new\apostador\crearapostadora.php - QUERY 3 */ INSERT 
		INTO usuario 
		(nom_usuario, nom_completo, tip_usuario, cod_taquilla, pas_usuario, est_usuario, tic_eliminados, 
		cod_barra, hor_inicio, hor_fin, dia_entrada, can_reimpresion, niv_acceso) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString(strtoupper($_POST['username']), "text"),
        GetSQLValueString(strtoupper($_POST['username']), "text"),
        GetSQLValueString("C", "text"),
        GetSQLValueString($codTaquilla, "int"),
        GetSQLValueString($_POST['pas_usuario'], "text"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(9999, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString("00:00:00", "date"),
        GetSQLValueString("23:59:00", "date"),
        GetSQLValueString("1-1-1-1-1-1-1", "text"),
        GetSQLValueString(9999, "text"),
        GetSQLValueString(1, "int")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    
    
    
    
    
    
    $insertSQL2 = sprintf(
        "/* PARSEADORES1 new\apostador\crearapostadora.php - QUERY 4 */ INSERT 
			INTO 
			taquilla_opc_ame 
			(cod_taquilla, apu_maxgan,
			pag_codigo, 
			apu_maxpla,		apu_maxsho, 
			apu_maxexa, 	apu_maxtri, 
			apu_maxsup, 	apu_mingan, 
			apu_minpla, 	apu_minsho,
			apu_minexa, 	apu_mintri, 
			apu_minsup, 	reg_gan, 
			reg_pla, 		reg_sho, 
			reg_exa, 		reg_tri, 
			reg_sup, 		est_gan, 
			est_pla, 		est_sho, 
			est_exa,		est_tri, 
			est_sup, 		max_aganar_gan, 
			max_aganar_pla, max_aganar_sho, 
			max_aganar_exa, max_aganar_tri, 
			max_aganar_sup,	mon_maxticket, 
			mon_maxejemplar,min_ejecarrera,
			por_taquilla, 	anu_regalia, 
			tic_caduca, est_impresion, ver_porpagar, tie_reclamo) 
			VALUES 
			(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
			 %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
			 %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
			 %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($codTaquilla, "int"),
        GetSQLValueString($_POST['montomax'], "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString($_POST['montomax'], "double"),
        GetSQLValueString($_POST['montomax'], "double"),
        GetSQLValueString($_POST['montomax'], "double"),
        GetSQLValueString($_POST['montomax'], "double"),
        GetSQLValueString($_POST['montomax'], "double"),
        GetSQLValueString($_POST['montomin'], "double"),
        GetSQLValueString($_POST['montomin'], "double"),
        GetSQLValueString($_POST['montomin'], "double"),
        GetSQLValueString($_POST['montomin'], "double"),
        GetSQLValueString($_POST['montomin'], "double"),
        GetSQLValueString($_POST['montomin'], "double"),
        GetSQLValueString($_POST['reg_gan'], "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString($_POST['max_aganar_gan'], "double"),
        GetSQLValueString($_POST['max_aganar_pla'], "double"),
        GetSQLValueString($_POST['max_aganar_sho'], "double"),
        GetSQLValueString(999, "double"),
        GetSQLValueString(999, "double"),
        GetSQLValueString(999, "double"),
        GetSQLValueString($_POST['montomax'], "int"),
        GetSQLValueString($_POST['montomax'], "int"),
        GetSQLValueString($_POST['ejemminimos'], "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString($_POST['AnuReg'], "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int")
    );
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
    
    
    $insertGoTo = "listaapostadora.php";

    header(sprintf("Location: %s", $insertGoTo));
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
$(document).ready(function() {    
    $('#nom_taquilla').blur(function(){
		var taquilla = $('input[name=nom_taquilla]').val();
		if(taquilla != '') {
			var nom_taquilla = $(this).val();        
			var dataString = 'nom_taquilla='+nom_taquilla;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarTaquilla.php",
				data: dataString,
				success: function(data) {
					$('#Info1').fadeIn(200).html(data);
				}
			});
		};
    });              
    $('#username').blur(function(){
		var usern = $('input[name=username]').val();
		if(usern != '') {
			var username = $(this).val();        
			var dataString = 'username='+username;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarUsuario.php",
				data: dataString,
				success: function(data) {
					$('#Info32').fadeIn(200).html(data);
				}
			});
		};	
    });
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
});    
function FX_passGenerator(form,element) {
  var thePass = "";
  var randomchar = "";
  var numberofdigits = '5';
  for (var count=1; count<=numberofdigits; count++) {
    var chargroup = Math.floor((Math.random() * 3) + 1);
    if (chargroup==1) {
      randomchar = Math.floor((Math.random() * 26) + 65);
    }
    if (chargroup==2) {
      randomchar = Math.floor((Math.random() * 10) + 48);
    }
    if (chargroup==3) {
      randomchar = Math.floor((Math.random() * 26) + 97);
    }
    thePass+=String.fromCharCode(randomchar);
  }
  thePass = thePass.toUpperCase();
  eval('document.'+form+'.'+element+'.value = thePass');
}
function ValidaSoloNumeros() {
	if (event.keyCode != 46) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
}    
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
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

		<div class="container">
			<div class="row">
				<h3 style="text-align:center">Crear Apostador</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">


				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre De Usuario</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="username" name="username" placeholder="Nombre De Usuario"  
						title="indique un nombre de usuario. 4-30 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{4,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
					<div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00"></div>
					
					
					
					

					<label for="nombre" class="col-sm-8 control-label">Clave de usuario</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="pas_usuario" name="pas_usuario" placeholder="Clave de usuario"  required>
					</div>
				</div>	
								<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Telefono</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="telefono1" name="telefono1" value="" placeholder="04125555555" >
					</div>
				</div>				
				
				
								<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Regalia Un 4 equivale a 20 mas por cada 100 apostados</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="reg_gan" name="reg_gan" value="0" required>
					</div>
				</div>
												<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Anular Regalia Si El Dividendos es Igual o Menor A</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="AnuReg" name="AnuReg" value="0.00" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Monto Minimo a Apostar</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="montomin" name="montomin" value="0.1" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Monto Maximo a Apostar</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="montomax" name="montomax" value="999999999.99" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Ejemplares Minimos en Carrera</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="ejemminimos" name="ejemminimos" value="3" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Dividendo Maximo a Pagar a Ganador</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="max_aganar_gan" name="max_aganar_gan" value="999" required>
					</div>
				</div>
								<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Dividendo Maximo a Pagar a Place</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="max_aganar_pla" name="max_aganar_pla" value="999" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Dividendo Maximo a Pagar a Show</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="max_aganar_sho" name="max_aganar_sho" value="999" required>
					</div>
				</div>
          <input type="hidden" name="cod_taquilla" value="<?php echo $recordID ?>"/>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="listaapostadora.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Crear Usuario Apostador</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$codigoDistri=$_SESSION['MM_cod_banca'];
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $recordID = $_GET['recordID'];
    
    
    
    
    
    
    
    
    $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['telefono1'])) {
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 new\apostador\editarapostadorad.php - QUERY 1 */ UPDATE taquilla 
				SET tel_taquilla=%s, moneda=%s
			
				WHERE cod_taquilla=%s",
        GetSQLValueString($_POST['telefono1'], "text"),
        GetSQLValueString($_POST['moneda'], "int"),
        GetSQLValueString($_POST['cod_taquilla'], "int")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 new\apostador\editarapostadorad.php - QUERY 2 */ UPDATE usuario 
				SET
				pas_usuario=%s
				WHERE id_usuario=%s",
        GetSQLValueString($_POST['pas_usuario'], "text"),
        GetSQLValueString($_POST['id_usuario'], "int")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

    $insertSQL2 = sprintf(
        "/* PARSEADORES1 new\apostador\editarapostadorad.php - QUERY 3 */ UPDATE taquilla_opc_ame
					SET
					apu_maxgan=%s, 
					apu_maxpla=%s, 
					apu_maxsho=%s, 
					apu_maxexa=%s, 
					apu_maxtri=%s, 
					apu_maxsup=%s, 
					apu_mingan=%s, 
					apu_minpla=%s, 
					apu_minsho=%s,	
					apu_minexa=%s, 
					apu_mintri=%s, 
					apu_minsup=%s, 
					reg_gan=%s, 

					max_aganar_gan=%s, 
					max_aganar_pla=%s, 
					max_aganar_sho=%s, 
					mon_maxticket=%s, 
					mon_maxejemplar=%s, 
					min_ejecarrera=%s, 

					anu_regalia=%s

					WHERE cod_taopcame=%s",
        GetSQLValueString($_POST['montomax'], "double"),
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
        GetSQLValueString($_POST['max_aganar_gan'], "int"),
        GetSQLValueString($_POST['max_aganar_pla'], "int"),
        GetSQLValueString($_POST['max_aganar_sho'], "int"),
        GetSQLValueString($_POST['montomax'], "int"),
        GetSQLValueString($_POST['montomax'], "int"),
        GetSQLValueString($_POST['ejemminimos'], "int"),
        GetSQLValueString($_POST['AnuReg'], "double"),
        GetSQLValueString($_POST['cod_taopcame'], "int")
    );
            
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
    
    $insertGoTo = "listaapostadorad.php";

    header(sprintf("Location: %s", $insertGoTo));
}
    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 new\apostador\editarapostadorad.php - QUERY 4 */ SELECT  
*
				FROM  taquilla ta, taquilla_opc_ame tp, usuario us
				WHERE ta.cod_taquilla = %s AND tp.cod_taquilla = ta.cod_taquilla AND tp.cod_taquilla = us.cod_taquilla
				LIMIT 1",
        GetSQLValueString($recordID, "int")
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

		<div class="container">
			<div class="row">
				<h3 style="text-align:center">Editar Apostador</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">


				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre De Usuario</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="username" name="username" value="<?php echo$row_Recordset1['nom_usuario']; ?>" placeholder="Nombre De Usuario"  
						title="indique un nombre de usuario. 4-30 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{4,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						Disabled>
					</div>
					<div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00"></div>
					
					
					
					

					<label for="nombre" class="col-sm-8 control-label">Clave de usuario</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="pas_usuario" name="pas_usuario" value="<?php echo$row_Recordset1['pas_usuario']; ?>"  placeholder="Clave de usuario"  required>
					</div>
				</div>	
								<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Telefono</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="telefono1" name="telefono1" value="<?php echo$row_Recordset1['tel_taquilla']; ?>" placeholder="04125555555" >
					</div>
				</div>				
<div class="form-group">
<label for="moneda" class="col-sm-8 control-label">Selecciones Moneda</label>
<div class="col-sm-4">
                    <select name="moneda" class="selectpicker" data-style="btn-danger">
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($row_Recordset1['moneda'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Bolivares Soberanos</option>
                    <option value="3" 
					<?php if (!(strcmp(3, htmlentities($row_Recordset1['moneda'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Dolar Estadounidense</option>
                    <option value="4" 
					<?php if (!(strcmp(4, htmlentities($row_Recordset1['moneda'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Peso Colombiano</option>
						                      <option value="5" 
					<?php if (!(strcmp(5, htmlentities($row_Recordset1['moneda'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Sol Peruano</option>
                  </select>
				  </div>
				  </div>
				
								<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Regalia Un 4 equivale a 20 mas por cada 100 apostados</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="reg_gan" name="reg_gan" value="<?php echo$row_Recordset1['reg_gan']; ?>" required>
					</div>
				</div>
												<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Anular Regalia Si El Dividendos es Igual o Menor A</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="AnuReg" name="AnuReg" value="<?php echo$row_Recordset1['anu_regalia']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Monto Minimo a Apostar</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="montomin" name="montomin" value="<?php echo$row_Recordset1['apu_mingan']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Monto Maximo a Apostar</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="montomax" name="montomax" value="<?php echo$row_Recordset1['apu_maxgan']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Ejemplares Minimos en Carrera</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="ejemminimos" name="ejemminimos" value="<?php echo$row_Recordset1['min_ejecarrera']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Dividendo Maximo a Pagar a Ganador</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="max_aganar_gan" name="max_aganar_gan" value="<?php echo$row_Recordset1['max_aganar_gan']; ?>" required>
					</div>
				</div>
								<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Dividendo Maximo a Pagar a Place</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="max_aganar_pla" name="max_aganar_pla" value="<?php echo$row_Recordset1['max_aganar_pla']; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-sm-8 control-label">Dividendo Maximo a Pagar a Show</label>
					<div class="col-sm-4">
						<input type="tel" class="form-control" id="max_aganar_sho" name="max_aganar_sho" value="<?php echo$row_Recordset1['max_aganar_sho']; ?>" required>
					</div>
				</div>
          <input type="hidden" name="cod_taquilla" value="<?php echo $recordID ?>"/>
		  <input type="hidden" name="id_usuario" value="<?php echo $row_Recordset1['id_usuario']; ?>"/>
		  <input type="hidden" name="cod_taopcame" value="<?php echo $row_Recordset1['cod_taopcame']; ?>"/>
				
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="listaapostadorad.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Editar Usuario Apostador</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
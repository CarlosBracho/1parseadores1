<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['nomequipo'])) {
    $insertSQL = sprintf(
        "/* PARSEADORES1 parley\parley\adagregarequipo.php - QUERY 1 */ INSERT 
				INTO p1equipos
				(nomequipop1, nomdimp1, deportep1, ligap1, ordenp1) 
				VALUES (%s, %s, %s, %s, %s)",
        GetSQLValueString(strtoupper($_POST['nomequipo']), "text"),
        GetSQLValueString(strtoupper($_POST['nomdim']), "text"),
        GetSQLValueString($_POST['deporte'], "int"),
        GetSQLValueString($_POST['liga'], "int"),
        GetSQLValueString($_POST['orden'], "int")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    
    
    
    
            

    
    
    $insertGoTo = "adlistaequipos.php";

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
<?php
require_once('../parley/admenu.php');
?>

		<div class="container">
			<div class="row">
				<h3 style="text-align:center">Crear Equipo</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">


				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">nomequipo</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="nomequipo" name="nomequipo" placeholder="nomequipo"  
						title="nomequipo. 2-30 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{2,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
					<div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00"></div>
<div class="col-sm-4">
						<input type="text" class="form-control" id="nomdim" name="nomdim" placeholder="nomdim"  
						title="nomdim. 2-30 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{2,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>			
					
					</div>
					
					
								<div class="form-group">
					<label for="deporte" class="col-sm-8 control-label">deporte</label>
					<div class="col-sm-4">
					<select name="deporte"  class="textbox"  id="deporte"  required>
                      <option value="">SELECCIONE</option>
					  <option value="0">beisbol</option>
                      <option value="1">TRACK INFO</option>
                      <option value="2">BASIC TVG</option>
                      <option value="3">BUILDABET2</option>
                      <option value="4">TWINSPIRES</option>
                  </select>
				  </div>
					</div>
					
													<div class="form-group">
					<label for="liga" class="col-sm-8 control-label">liga</label>
					<div class="col-sm-4">
					<select name="liga"  class="textbox"  id="liga"  required>
                      <option value="">SELECCIONE</option>
					  <option value="0">beisbol mlb</option>
                      <option value="1">TRACK INFO</option>
                      <option value="2">BASIC TVG</option>
                      <option value="3">BUILDABET2</option>
                      <option value="4">TWINSPIRES</option>
                  </select>
				  </div>
					</div>
					<div class="form-group">
					<label for="orden" class="col-sm-8 control-label">orden</label>
					<div class="col-sm-4">
					<select name="orden"  class="textbox"  id="orden"  required>
                      <option value="">SELECCIONE</option>
					  <option value="0">1 beisbol mlb</option>
                      <option value="1">TRACK INFO</option>
                      <option value="2">BASIC TVG</option>
                      <option value="3">BUILDABET2</option>
                      <option value="4">TWINSPIRES</option>
                  </select>
				  </div>
					</div>
					
			
								
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="adlistaequipos.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Crear equipo</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
    $recordID = $_GET['recordID'];
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $datetime=$FechaTxt.' '.$horaTxt;
    $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['logro'])) {
    if (empty($_POST['logroABoRL'])) {
        $logroABoRL="";
    } else {
        $logroABoRL=$_POST['logroABoRL'];
    }
    

    $insertSQL = sprintf(
        "/* PARSEADORES1 parley\parley\adagregarlogro.php - QUERY 1 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['idjuego'], "int"),
        GetSQLValueString($_POST['Id_p1equipos'], "int"),
        GetSQLValueString($_POST['equipo'], "int"),
        GetSQLValueString($_POST['tipojugada'], "text"),
        GetSQLValueString($_POST['logro'], "double"),
        GetSQLValueString($datetime, "date"),
        GetSQLValueString($_POST['logroABoRL'], "text")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    
    
    
    
            

    
    
    $insertGoTo = "adlistajuegos.php";

    header(sprintf("Location: %s", $insertGoTo));
}
    
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 parley\parley\adagregarlogro.php - QUERY 2 */ SELECT *
FROM p2juegos WHERE Id_p2juegosp2=%s ",
        GetSQLValueString($recordID, "int")
    );
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 parley\parley\adagregarlogro.php - QUERY 3 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset2['idequipo1p2'], "int")
    );
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    
    $query_Recordset22 = sprintf(
        "/* PARSEADORES1 parley\parley\adagregarlogro.php - QUERY 4 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset2['idequipo2p2'], "int")
    );
$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
$totalRows_Recordset22 = mysqli_num_rows($Recordset22);

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
				<h3 style="text-align:center">Crear Logro</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">


			

					
			
			
							<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">logro</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logro" name="logro" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
					<?php if ($_GET["tipoapuesta"]=="RL") { ?>
					<label for="logroABoRL" class="col-sm-8 control-label">RL</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
			<?php } ?>
			
					<?php if ($_GET["tipoapuesta"]=="SR") { ?>
					<label for="logroABoRL" class="col-sm-8 control-label">SR</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
			<?php } ?>
								<?php if ($_GET["tipoapuesta"]=="5RL") { ?>
					<label for="logroABoRL" class="col-sm-8 control-label">5RL</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
			<?php } ?>
			
								<?php if ($_GET["tipoapuesta"]=="A") { ?>
					<label for="logroABoRL" class="col-sm-8 control-label">ALTA</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
			<?php } ?>
											<?php if ($_GET["tipoapuesta"]=="B") { ?>
					<label for="logroABoRL" class="col-sm-8 control-label">BAJA</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
			<?php } ?>
			
											<?php if ($_GET["tipoapuesta"]=="5A") { ?>
					<label for="logroABoRL" class="col-sm-8 control-label">5 ALTA</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
			<?php } ?>
											<?php if ($_GET["tipoapuesta"]=="5B") { ?>
					<label for="logroABoRL" class="col-sm-8 control-label">5 BAJA</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
			<?php } ?>
			
														<?php if ($_GET["tipoapuesta"]=="AG") { ?>
					<label for="logroABoRL" class="col-sm-8 control-label">AG</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
			<?php } ?>
			
														<?php if ($_GET["tipoapuesta"]=="BG") { ?>
					<label for="logroABoRL" class="col-sm-8 control-label">BG</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" placeholder="logro"  
						title="logro. 2-6 caracteres" size="32"  
maxlength="30"  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
			<?php } ?>
			
			
<input type="hidden" name="tipojugada" value="<?php echo $_GET['tipoapuesta']; ?>"/>					
<input type="hidden" name="equipo" value="<?php echo $_GET['equipo']; ?>"/>					
<input type="hidden" name="Id_p1equipos" value="<?php echo $_GET['idequipo']; ?>"/>
									
<input type="hidden" name="idjuego" value="<?php echo $recordID ?>"/>
					

					
			
								
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="adlistajuegos.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Crear equipo</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
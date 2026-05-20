<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $recordID = $_GET['recordID'];
    
    $cerrar=0;
    
    
    
    
    
    
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

    $insertSQL1 = sprintf(
        "/* PARSEADORES1 parley\parley\adeditarlogro.php - QUERY 1 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
        GetSQLValueString($_POST['logro'], "double"),
        GetSQLValueString($_POST['logroABoRL'], "text"),
        GetSQLValueString($_POST['Id_p3logros'], "int")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                

    
    //$insertGoTo = "adlistajuegos.php";

    //header(sprintf("Location: %s", $insertGoTo));
    
    $cerrar=1;
}
    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 parley\parley\adeditarlogro.php - QUERY 2 */ SELECT  
*
				FROM  p3logros
				WHERE Id_p3logrosp3 = %s
				LIMIT 1",
        GetSQLValueString($recordID, "int")
    );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        
        
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 parley\parley\adeditarlogro.php - QUERY 3 */ SELECT *
FROM p1equipos WHERE Id_p1equiposp1 = %s",
        GetSQLValueString($row_Recordset1['Id_p1equiposp3'], "int")
    );
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    
    echo $row_Recordset2['nomequipop1'];
    
    
    
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
if ($cerrar==1) {
    echo "<script> window.close(); </script>";
}
?>

		<div class="container">
			<div class="row">
				<h3 style="text-align:center">Editar Apostador</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">


				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">logro</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logro" name="logro" value="<?php echo $row_Recordset1['logrop3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php if ($row_Recordset1["tipojugadap3"]=="RL") { ?>
						<label for="nombre" class="col-sm-8 control-label">RL</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" value="<?php echo $row_Recordset1['logroABoRLp3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php } ?>
										<?php if ($row_Recordset1["tipojugadap3"]=="SRL") { ?>
						<label for="nombre" class="col-sm-8 control-label">SR</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" value="<?php echo $row_Recordset1['logroABoRLp3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php } ?>
					
						<?php if ($row_Recordset1["tipojugadap3"]=="5RL") { ?>
						<label for="nombre" class="col-sm-8 control-label">5RL</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" value="<?php echo $row_Recordset1['logroABoRLp3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php } ?>
					
								
										<?php if ($row_Recordset1["tipojugadap3"]=="A") { ?>
						<label for="nombre" class="col-sm-8 control-label">A</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" value="<?php echo $row_Recordset1['logroABoRLp3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php } ?>
					
									
										<?php if ($row_Recordset1["tipojugadap3"]=="B") { ?>
						<label for="nombre" class="col-sm-8 control-label">B</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" value="<?php echo $row_Recordset1['logroABoRLp3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php } ?>
					
									
										<?php if ($row_Recordset1["tipojugadap3"]=="5A") { ?>
						<label for="nombre" class="col-sm-8 control-label">5A</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" value="<?php echo $row_Recordset1['logroABoRLp3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php } ?>
					
				
										<?php if ($row_Recordset1["tipojugadap3"]=="5B") { ?>
						<label for="nombre" class="col-sm-8 control-label">5B</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" value="<?php echo $row_Recordset1['logroABoRLp3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php } ?>
					
			
										<?php if ($row_Recordset1["tipojugadap3"]=="AG") { ?>
						<label for="nombre" class="col-sm-8 control-label">AG</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" value="<?php echo $row_Recordset1['logroABoRLp3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php } ?>
					
				
										<?php if ($row_Recordset1["tipojugadap3"]=="BG") { ?>
						<label for="nombre" class="col-sm-8 control-label">BG</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="logroABoRL" name="logroABoRL" value="<?php echo $row_Recordset1['logroABoRLp3']; ?>" placeholder="nomequipo"  
						title="logro. 2-30 caracteres" size="32"  
maxlength="30" 
						required>
					</div>
					<?php } ?>
					
					

					
					
						
				<input type="hidden" name="Id_p3logros" value="<?php echo $recordID ?>"/>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="adlistajuegos.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Editar equipo</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
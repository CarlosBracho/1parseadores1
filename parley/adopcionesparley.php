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

if(isset($_POST['Swicht'])){
	if($_POST['Swicht']==0)
	{$nom_opcion ='Winnigbet';}

if($_POST['Swicht']==1){
	{$nom_opcion ='Maradeportes';}
}
}
if (isset($_POST['Swicht'])) {
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 parley\adopcionesparley.php - QUERY 1 */ UPDATE opciones_parley 
				SET Swicht=%s,
				nom_opcion=%s

							
				WHERE id_opcionp=%s",
		GetSQLValueString($_POST['Swicht'], "int"),
		GetSQLValueString($nom_opcion, "text"),
        GetSQLValueString(1, "int")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                

    
    $insertGoTo = "../admin/1parley.php";

    header(sprintf("Location: %s", $insertGoTo));
}
 
    

    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 parley\adopcionesparley.php - QUERY 2 */ SELECT  
*
				FROM  opciones_parley
				WHERE id_opcionp=%s
				LIMIT 1",
        GetSQLValueString(1, "int")
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
			var NFLtaString = 'nom_taquilla='+nom_taquilla;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarTaquilla.php",
				NFLta: NFLtaString,
				success: function(NFLta) {
					$('#Info1').fadeIn(200).html(NFLta);
				}
			});
		};
    });              
    $('#username').blur(function(){
		var usern = $('input[name=username]').val();
		if(usern != '') {
			var username = $(this).val();        
			var NFLtaString = 'username='+username;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarUsuario.php",
				NFLta: NFLtaString,
				success: function(NFLta) {
					$('#Info32').fadeIn(200).html(NFLta);
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
function ValiNFLSoloNumeros() {
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
				<h3 style="text-align:center">OPCIONES PARLEY</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">



					
					
								<div class="form-group">
					<label for="deporte" class="col-sm-8 control-label">SELECCIONE LA PAGINA DE LOGROS A PARSEAR</label>
					<div class="col-sm-4">
					<select name="Swicht"  class="textbox"  id="Swicht"  required>
				                      <option value="0" 
					<?php if (!(strcmp(0, htmlentities($row_Recordset1['Swicht'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>WINNIGBET</option>
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($row_Recordset1['Swicht'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>MARADEPORTES</option>
                  </select>
				  </div>
					</div>
												

				


				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="../admin/1parley.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
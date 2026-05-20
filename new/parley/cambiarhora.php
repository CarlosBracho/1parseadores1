<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
//$recordID = $_GET['recordID'];
if(isset($_POST['funcion'])){
  
  $_GET["recordID"] = $_POST['funcion'];
  $recordID = $_GET['recordID'];
}else{$recordID = $_GET['recordID'];}
$cerrar=0;
    $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['deportep2'])) {
    $hora1=$_POST['datetime'];
    $nuevahora1 = strtotime('-6 hour', strtotime($hora1)) ;
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo $datetime;
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 new\parley\cambiarhora.php - QUERY 1 */ UPDATE p2juegos 
				SET  competicionp2=%s, deportep2=%s, pichee1p2=%s, pichee2p2=%s, iniciodtp2=%s, paisp2=%s			
				WHERE Id_p2juegosp2=%s",
        GetSQLValueString($_POST['competicion'], "text"),
        GetSQLValueString($_POST['deportep2'], "text"),
        GetSQLValueString($_POST['pichee1p2'], "text"),
        GetSQLValueString($_POST['pichee2p2'], "text"),
        GetSQLValueString($nuevahora1, "date"),
        GetSQLValueString($_POST['paisp2'], "text"),
        GetSQLValueString($_POST['Id_p2juegosp2'], "int")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        
    

    
            

    
    
    $insertGoTo = "logros_ajax.php";

    header(sprintf("Location: %s", $insertGoTo));
    $cerrar=1;
}
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\parley\cambiarhora.php - QUERY 2 */ SELECT *
FROM p2juegos WHERE Id_p2juegosp2=%s",
            GetSQLValueString($recordID, "int")
        );
$Recordset1 =mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


    $query_Recordset2 = sprintf("/* PARSEADORES1 new\parley\cambiarhora.php - QUERY 3 */ SELECT *
FROM p1equipos ORDER BY nomequipop1");
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);


    $query_Recordset3 = sprintf("/* PARSEADORES1 new\parley\cambiarhora.php - QUERY 4 */ SELECT *
FROM p1equipos ORDER BY nomequipop1");
$Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
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
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">

<link rel="stylesheet" href="../css/bootstrap.min4.5.2.css">
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
<link href="../fonts/font-awesome.min4.7.0.css" rel="stylesheet">

<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/popper.min1.16.1.js"></script>
<script src="../js/bootstrap.min4.5.2.js"></script>
<script src="../js/bootstrap-datetimepicker.min.js"></script>
<title>.:Apuestas:.</title>
 
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
<?php
require_once('../parley/admenu.php');
?>

		<div class="container">
			<div class="row">
				<h3 style="text-align:center">Cambiar Fecha y Hora del Juego</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">




<section id="demo_meridian">
Seleccione Fecha y Hora
<div>
<div class="bs-docs-example">
<div class="input-append date form_datetime6"  data-date-format="dd MM yyyy - HH:ii P">
<input  size="26" type="text" value="<?php
$hora1=$row_Recordset1['iniciodtp2'];
$nuevahora11 = strtotime('+6 hour', strtotime($hora1)) ;
$nuevahora12 = date('Y-m-j H:i:s', $nuevahora11);
$nuevahora1 = date('j F Y - h:i A', $nuevahora11);
echo $nuevahora1;
?>" readonly=""></br>
<span class="add-on"><i class="icon-th"></i></span>
<input type="text" name="datetime"  id="mirror_field" value="<?php echo $nuevahora12; ?>" readonly />
</div>
</div>
</div>
</section>
<script type="text/javascript">
    $(".form_datetime6").datetimepicker({
      format: "dd MM yyyy - HH:ii P",
      autoclose: true,
      todayBtn: true,
	  minuteStep: 1,
	  linkField: "mirror_field",
     linkFormat: "yyyy-mm-dd hh:ii",
      showMeridian: true
    });
  </script>
					
					

          <div style="display: none">

																		<div class="form-group">
					<label for="deportep2" class="col-sm-8 control-label">DEPORTE</label>
					<div class="col-sm-4">

				  				                      <select name="deportep2"  class="textbox" id="deportep2" required>
					<option value="" <?php if (!(strcmp("", htmlentities($row_Recordset1['deportep2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>SELECCIONE DEPORTE</option>
                    <option value="beisbol" <?php if (!(strcmp("beisbol", htmlentities($row_Recordset1['deportep2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>beisbol</option>
<option value="futbol" <?php if (!(strcmp("futbol", htmlentities($row_Recordset1['deportep2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>futbol</option>
<option value="baloncesto" <?php if (!(strcmp("baloncesto", htmlentities($row_Recordset1['deportep2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>baloncesto</option>
<option value="futbolamericano" <?php if (!(strcmp("futbolamericano", htmlentities($row_Recordset1['deportep2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>futbolamericano</option>
<option value="hockey" <?php if (!(strcmp("hockey", htmlentities($row_Recordset1['deportep2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>hockey</option>
                  </select>
				  
				  </div>
					</div>
          </div>
          
					
																							

					
			<input type="hidden" name="Id_p2juegosp2" value="<?php echo $recordID ?>"/>
								
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="logros_ajax.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Crear equipo</button>
					</div>
				</div>
			</form>
		</div>

	</body>

</html>
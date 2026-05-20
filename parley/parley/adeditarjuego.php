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
if (isset($_POST['deportep2'])) {
    $hora1=$_POST['datetime'];
    $nuevahora1 = strtotime('-6 hour', strtotime($hora1)) ;
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo $datetime;
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 parley\parley\adeditarjuego.php - QUERY 1 */ UPDATE p2juegos 
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
        
    

    
            

    
    
    //$insertGoTo = "adlistajuegos.php";

    //header(sprintf("Location: %s", $insertGoTo));
    $cerrar=1;
}
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 parley\parley\adeditarjuego.php - QUERY 2 */ SELECT *
FROM p2juegos WHERE Id_p2juegosp2=%s",
            GetSQLValueString($recordID, "int")
        );
$Recordset1 =mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


    $query_Recordset2 = sprintf("/* PARSEADORES1 parley\parley\adeditarjuego.php - QUERY 3 */ SELECT *
FROM p1equipos ORDER BY nomequipop1");
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);


    $query_Recordset3 = sprintf("/* PARSEADORES1 parley\parley\adeditarjuego.php - QUERY 4 */ SELECT *
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
				<h3 style="text-align:center">Crear Apostador</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">



				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">nomequipo</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="nomequipo1" name="nomequipo1" placeholder="PICHE EQUIPO 1"  readonly="readonly" 
						 size="32"   value="<?php
    $query_Recordset222 = sprintf(
    "/* PARSEADORES1 parley\parley\adeditarjuego.php - QUERY 5 */ SELECT *
FROM p1equipos  WHERE Id_p1equiposp1=%s",
    GetSQLValueString($row_Recordset1['idequipo1p2'], "int")
);
$Recordset222 =mysqli_query($conexionbanca, $query_Recordset222) or die(mysqli_error($conexionbanca));
$row_Recordset222 = mysqli_fetch_assoc($Recordset222);
$totalRows_Recordset222 = mysqli_num_rows($Recordset222);
                         
                         
                         echo $row_Recordset222['nomequipop1']?>"
maxlength="30" pattern="[A-Z a-z0-9]{2,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>
</div></div>


				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">PICHE EQUIPO 1</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="pichee1p2" name="pichee1p2" placeholder="PICHE EQUIPO 1"  
						title="PICHE EQUIPO 1. 2-30 caracteres" size="32"   value="<?php echo $row_Recordset1['pichee1p2']?>"
maxlength="30" pattern="[A-Z a-z0-9]{2,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>


					</div>			
					

					
					
				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">nomequipo2</label>
					<div class="col-sm-4">					
						<input type="text" class="form-control" id="nomequipo2" name="nomequipo2" placeholder="PICHE EQUIPO 1"   readonly="readonly"
						title="PICHE EQUIPO 1. 2-30 caracteres" size="32"   value="<?php
    $query_Recordset222 = sprintf(
                             "/* PARSEADORES1 parley\parley\adeditarjuego.php - QUERY 6 */ SELECT *
FROM p1equipos  WHERE Id_p1equiposp1=%s",
                             GetSQLValueString($row_Recordset1['idequipo2p2'], "int")
                         );
$Recordset222 =mysqli_query($conexionbanca, $query_Recordset222) or die(mysqli_error($conexionbanca));
$row_Recordset222 = mysqli_fetch_assoc($Recordset222);
$totalRows_Recordset222 = mysqli_num_rows($Recordset222);
                         
                         
                         echo $row_Recordset222['nomequipop1']; ?>"
maxlength="30" pattern="[A-Z a-z0-9]{2,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					
					
					
</div></div>

				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">PICHE EQUIPO 2</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="pichee2p2" name="pichee2p2" placeholder="PICHE EQUIPO 1"  
						title="PICHE EQUIPO 2. 2-30 caracteres" size="32"  value="<?php echo $row_Recordset1['pichee2p2']?>"
maxlength="30" pattern="[A-Z a-z0-9]{2,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>


					</div>

<section id="demo_meridian">
Seleccione Fecha y Hora
<div>
<div class="bs-docs-example">
<div class="input-append date form_datetime6"  data-date-format="dd MM yyyy - HH:ii P">
<input  size="26" type="text" value="<?php
$hora1=$row_Recordset1['iniciodtp2'];
$nuevahora11 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
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
					
					

					

																		<div class="form-group">
					<label for="deportep2" class="col-sm-8 control-label">DEPORTE</label>
					<div class="col-sm-4">

				  				                      <select name="deportep2"  class="textbox" id="deportep2" required>
					<option value="" <?php if (!(strcmp("", htmlentities($row_Recordset1['deportep2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>SELECCIONE DEPORTE</option>
                    <option value="Baseball" <?php if (!(strcmp("Baseball", htmlentities($row_Recordset1['deportep2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>beisbol</option>
                  </select>
				  
				  </div>
					</div>
					
																							<div class="form-group">
					<label for="paisp2" class="col-sm-8 control-label">PAIS</label>
					<div class="col-sm-4">

				  
				                      <select name="paisp2"  class="textbox" id="paisp2" required>
					<option value="" <?php if (!(strcmp("", htmlentities($row_Recordset1['paisp2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>SELECCIONE PAIS</option>
                    <option value="ESTADOS UNIDOS" <?php if (!(strcmp("ESTADOS UNIDOS", htmlentities($row_Recordset1['paisp2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ESTADOS UNIDOS</option>
                  </select>
				  
				  </div>
					</div>
					
					
													<div class="form-group">
					<label for="competicion" class="col-sm-8 control-label">competicion</label>
					<div class="col-sm-4">
					
				

					
                    <select name="competicion"  class="textbox" id="competicion" required>
					<option value="" <?php if (!(strcmp("", htmlentities($row_Recordset1['competicionp2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>SELECCIONE</option>
                    <option value="MLB" <?php if (!(strcmp("MLB", htmlentities($row_Recordset1['competicionp2'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>beisbol mlb</option>
                  </select>
				  </div>
					</div>

					
			<input type="hidden" name="Id_p2juegosp2" value="<?php echo $recordID ?>"/>
								
				
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
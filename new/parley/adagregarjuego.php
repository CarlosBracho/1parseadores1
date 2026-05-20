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





$query_Recordsetuno1 = sprintf(
    "/* PARSEADORES1 new\parley\adagregarjuego.php - QUERY 1 */ SELECT * 
FROM p3logros 
WHERE  
idjuegop3 = %s AND
logrodtp3 >= %s",
 GetSQLValueString(999999, "int"),
GetSQLValueString(fechaactualbd()." 00:00:00", "date"));
$Recordsetuno1 = mysqli_query($conexionbanca, $query_Recordsetuno1) or die(mysqli_error($conexionbanca));
$row_Recordsetuno1 = mysqli_fetch_assoc($Recordsetuno1);
$totalRows_Recordsetuno1 = mysqli_num_rows($Recordsetuno1);

if ($totalRows_Recordsetuno1==0) {
    $insertSQL = sprintf(
        "/* PARSEADORES1 new\parley\adagregarjuego.php - QUERY 2 */ INSERT 
INTO p3logros
(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString(999999, "int"),
        GetSQLValueString(999999, "int"),
        GetSQLValueString('100', "int"),
        GetSQLValueString("ML", "text"),
        GetSQLValueString('100', "text"),
        GetSQLValueString(fechaactualbd().' 23:59:59', "date"),
        GetSQLValueString('2', "text")
    );

    $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
}

if (isset($_POST['idequipo1']) && ($_POST['competicion']!='')) {
    $hora1=$_POST['datetime'];
    $nuevahora1 = strtotime('-6 hour', strtotime($hora1)) ;
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo $datetime;
    $insertSQL = sprintf(
        "/* PARSEADORES1 new\parley\adagregarjuego.php - QUERY 3 */ INSERT 
				INTO p2juegos
				(idequipo1p2, idequipo2p2, competicionp2, deportep2, pichee1p2, pichee2p2, iniciodtp2, paisp2, jexterno) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['idequipo1'], "int"),
        GetSQLValueString($_POST['idequipo2'], "int"),
        GetSQLValueString($_POST['competicion'], "text"),
        GetSQLValueString($_POST['deportep2'], "text"),
        GetSQLValueString($_POST['pichee1p2'], "text"),
        GetSQLValueString($_POST['pichee2p2'], "text"),
        GetSQLValueString($nuevahora1, "date"),
        GetSQLValueString($_POST['paisp2'], "text"),
	GetSQLValueString(1, "int")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));



    
    
    

    
            

    
    if(!isset($_POST['D'])){
    $insertGoTo = "adlistajuegos.php";

    header(sprintf("Location: %s", $insertGoTo));

    }else{

      $insertGoTo2 = "logros_ajax.php";

      header(sprintf("Location: %s", $insertGoTo2));

    }
}

if (isset($_POST['idequipo1']) && ($_POST['competicion2'])) {
  $hora1=$_POST['datetime'];
  $nuevahora1 = strtotime('-6 hour', strtotime($hora1)) ;
  $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
  echo $datetime;
  $insertSQL18 = sprintf(
      "/* PARSEADORES1 new\parley\adagregarjuego.php - QUERY 4 */ INSERT 
      INTO p2juegos
      (idequipo1p2, idequipo2p2, competicionp2, deportep2, pichee1p2, pichee2p2, iniciodtp2, paisp2) 
      VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
      GetSQLValueString($_POST['idequipo1'], "int"),
      GetSQLValueString($_POST['idequipo2'], "int"),
      GetSQLValueString($_POST['competicion2'], "text"),
      GetSQLValueString($_POST['deportep2'], "text"),
      GetSQLValueString($_POST['pichee1p2'], "text"),
      GetSQLValueString($_POST['pichee2p2'], "text"),
      GetSQLValueString($nuevahora1, "date"),
      GetSQLValueString($_POST['paisp2'], "text")
  );
      
  $Result18 = mysqli_query($conexionbanca, $insertSQL18) or die(mysqli_error($conexionbanca));

  if(!isset($_POST['D'])){
    $insertGoTo = "adlistajuegos.php";

    header(sprintf("Location: %s", $insertGoTo));

    }else{

      $insertGoTo2 = "logros_ajax.php";

      header(sprintf("Location: %s", $insertGoTo2));

    }
  }
    


$query_Recordset1 =  sprintf(
  "/* PARSEADORES1 new\parley\adagregarjuego.php - QUERY 5 */ SELECT  
*
  FROM  p2juegos"
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
<script languague="javascript">
        function mostrar() {
            div = document.getElementById('flotante');
            div.style.display = '';
        }

        function cerrar() {
            div = document.getElementById('flotante');
            div.style.display = 'none';
        }
</script>
	</head>
	
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">



<?php

 if(!isset($_POST['funcion'])){  
require_once('../parley/admenu.php');


          } 
         
if(isset($_POST['funcion'])){
  
  $_GET["recordID"] = $_POST['funcion'];

}

if (!isset($_GET["recordID"])) { ?>
<div class="container">
			<div class="row">
				<h3 style="text-align:center">Selecione deporte</h3>
			</div>
			<a href="adagregarjuego.php?recordID=0"  class="btn btn-primary btn-lg" role="button">beisbol</a>
			<a href="adagregarjuego.php?recordID=1"  class="btn btn-secondary btn-lg" role="button">baloncesto</a>
			<a href="adagregarjuego.php?recordID=2"  class="btn btn-success btn-lg" role="button">futbol</a>
			<a href="adagregarjuego.php?recordID=5"  class="btn btn-danger btn-lg" role="button">hockey</a>
			<a href="adagregarjuego.php?recordID=4"  class="btn btn-warning btn-lg" role="button">Futbol Americano</a>
			<a href="adagregarjuego.php?recordID=3"  class="btn btn-info btn-lg" role="button">Primary link</a>
			<a href="adagregarjuego.php?recordID=6"  class="btn btn-light btn-lg" role="button">Primary link</a>
			<a href="adagregarjuego.php?recordID=7"  class="btn btn-dark btn-lg" role="button">Primary link</a>
</div>















<?php  } else {
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 new\parley\adagregarjuego.php - QUERY 6 */ SELECT *
		FROM p1equipos 
		WHERE deportep1 = %s
		ORDER BY nomequipop1",
        GetSQLValueString($_GET["recordID"], "int")
    );
    $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        
    $query_Recordset3 = sprintf(
        "/* PARSEADORES1 new\parley\adagregarjuego.php - QUERY 7 */ SELECT *
		FROM p1equipos 
		WHERE deportep1 = %s
		ORDER BY nomequipop1",
        GetSQLValueString($_GET["recordID"], "int")
    );
        
        
    $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
    $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
    $totalRows_Recordset3 = mysqli_num_rows($Recordset3); ?>
   

		<div class="container">
			<div class="row">
				<h3 style="text-align:center">Crear Juego</h3>
			</div>

			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">



				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre del Equipo</label>
					<div class="col-sm-4">
                  <select name="idequipo1" style="width:100%; height: auto" class="textbox" required>
                    <option value="">SELECCIONE
                      <?php
                                    do {
                                        ?>
                    <option value="<?php echo $row_Recordset2['Id_p1equiposp1']?>">
                        <?php echo $row_Recordset2['nomequipop1']?></option>
                    <?php
                                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2)); ?>
                    </select>
</div></div>
<?php if ($_GET["recordID"]==0) {?>
				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">PICHE EQUIPO 1</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="pichee1p2" name="pichee1p2" placeholder="PICHE EQUIPO 1"  
						title="PICHE EQUIPO 1. 2-30 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{2,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>


					</div>			
					<?php } else {?>
						<input type="hidden" name="pichee1p2" value="no requerido" />
						<?php } ?>
					
				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre del Equipo 2</label>
					<div class="col-sm-4">					
					                  <select name="idequipo2" style="width:100%; height: auto" class="textbox" required>
                    <option value="">SELECCIONE
                      <?php
                                    do {
                                        ?>
                    <option value="<?php echo $row_Recordset3['Id_p1equiposp1']?>">
                        <?php echo $row_Recordset3['nomequipop1']?></option>
                    <?php
                                    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3)); ?>
                    </select>
</div></div>
<?php if ($_GET["recordID"]==0) {?>
				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">PICHE EQUIPO 2</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="pichee2p2" name="pichee2p2" placeholder="PICHE EQUIPO 1"  
						title="PICHE EQUIPO 2. 2-30 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{2,30}" onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');"
						required>
					</div>


					</div>
					<?php } else {?>
						<input type="hidden" name="pichee2p2" value="no requerido" />
						<?php } ?>

<section id="demo_meridian">
Seleccione Fecha y Hora
<div>
<div class="bs-docs-example">
<div class="input-append date form_datetime6"  data-date-format="dd MM yyyy - HH:ii P">
<input  size="26" type="text" value="" readonly=""></br>
<span class="add-on"><i class="icon-th"></i></span>
<span class="add-on"><i class="icon-remove"></i>X</span>
<input type="text" name="datetime"  id="mirror_field" value="" readonly />
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
					
					

					

	


					<input type="hidden" name="deportep2" value="<?php
                    if ($_GET["recordID"]==0) {
                        echo "beisbol";
                    }
    if ($_GET["recordID"]==1) {
        echo "baloncesto";
    }
    if ($_GET["recordID"]==2) {
        echo "futbol";
    }
    if ($_GET["recordID"]==5) {
        echo "hockey";
    } 
    if ($_GET["recordID"]==4) {
      echo "futbolamericano";
  }?>" />




					
																							<div class="form-group">
					<label for="paisp2" class="col-sm-8 control-label">PAIS</label>
					<div class="col-sm-4">
					<select name="paisp2"  class="textbox"  id="paisp2"  required>
                      <option value="">SELECCIONE PAIS</option>
					  <option value="ESTADOS UNIDOS">Estados Unidos</option>
            <option value="VENEZUELA">Venezuela</option>
            <option value="ESPAÑA">España</option>
            <option value="INGLATERRA">Inglaterra</option>
            <option value="ITALIA">Italia</option>
            <option value="ALEMANIA">Alemania</option>
            <option value="HOLANDA">Holanda</option>
            <option value="FRANCIA">Francia</option>
                  </select>
				  </div>
					</div>
					
          
          <div class="form-group">
					<label for="competicion" class="col-sm-8 control-label">Nombre de Competicion</label>
					<div class="col-sm-4">
            
          
     <select name="competicion" style="width:100%; height: auto" class="textbox">
                    <option value="">SELECCIONE
                      <?php
                                    do {

                                      if ($_GET["recordID"]==0){ 


                                        if($row_Recordset1['competicionp2'] != '' && $row_Recordset1['deportep2']=='beisbol'){
                                      
                                      
                                        ?>
                    <option value="<?php echo $row_Recordset1['competicionp2'];?>">
                        
                    
                    
                    <?php  echo $row_Recordset1['competicionp2'];} }
                    
                    
                    if ($_GET["recordID"]==1){ 


                      if($row_Recordset1['competicionp2'] != '' && $row_Recordset1['deportep2']=='baloncesto'){
                    
                    
                      ?>
  <option value="<?php echo $row_Recordset1['competicionp2']?>">
      
  <?php  echo $row_Recordset1['competicionp2'];} }
                    
                    
                    if ($_GET["recordID"]==2){ 


                      if($row_Recordset1['competicionp2'] != '' && $row_Recordset1['deportep2']=='futbol'){
                    
                    
                      ?>
  <option value="<?php echo $row_Recordset1['competicionp2']?>">
      
  
  <?php  echo $row_Recordset1['competicionp2'];} }
                    
                    if ($_GET["recordID"]==4){ 


                      if($row_Recordset1['competicionp2'] != '' && $row_Recordset1['deportep2']=='futbolamericano'){
                    
                    
                      ?>
  <option value="<?php echo $row_Recordset1['competicionp2']?>">
      
  
  
  <?php  echo $row_Recordset1['competicionp2'];} }
                    
                    if ($_GET["recordID"]==5){ 


                      if($row_Recordset1['competicionp2'] != '' && $row_Recordset1['deportep2']=='hockey'){
                    
                    
                      ?>
  <option value="<?php echo $row_Recordset1['competicionp2']?>">
      
  
  
  <?php  echo $row_Recordset1['competicionp2'];} }?> </option>
                    <?php
                                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
                    </select>




                  
                    <br>
                    <br>
                    <p><a href="javascript:mostrar();" class="btn btn-primary">Crear Nueva Competicion</a></p>
<div id="flotante" style="display:none;">
     
<div class="form-group">
					<label for="competicion" class="col-sm-8 control-label">Nombre de Competicion</label>
					<div class="col-sm-4">
                    <input type="text" class="form-control" id="competicion" name="competicion2" value="" placeholder="Ingrese Competicion"  
						title="nomequipo. 4-20 caracteres" size="32" maxlength="30">
					</div>
					</div>
          


     <div id="close"><a href="javascript:cerrar();" class="btn btn-primary">cerrar</a></div>
</div>
</div>
</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
            
  
  
<?php if(!isset($_POST['funcion'])){  ?>



						<a href="logros_ajax.php" class="btn btn-default">Regresar</a>
            
						<button type="submit" class="btn btn-primary">Crear Juego</button>
					</div>
				</div>
			</form>
		</div>
    <?php
          }else{
          ?>
   <input type="hidden" name="D" value="10">
    <a href="logros_ajax.php" class="btn btn-default">Regresar</a>
            
						<button type="submit" class="btn btn-primary">Crear Juego</button>
					</div>
				</div>
			</form>
      <?php
          }
          ?>

<?php
          }
          ?>


	</body>

</html>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $recordID = $_GET['recordID'];


	$query_Recordset1 =  sprintf(
        "/* PARSEADORES1 new\parley\adeditarequipo.php - QUERY 1 */ SELECT  
*
				FROM  p1equipos
				WHERE Id_p1equiposp1=%s
				",
        GetSQLValueString($recordID, "int")
    );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    
    
    
   $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if (isset($_POST['nomequipo'])) {
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 new\parley\adeditarequipo.php - QUERY 2 */ UPDATE p1equipos 
				SET nomequipop1=%s,
			nomdimp1=%s,
			nommara=%s,
			nomsella=%s,
			deportep1=%s,
			ordenp1=%s,
			pais=%s

							
				WHERE Id_p1equiposp1=%s",
        GetSQLValueString(trim($_POST['nomequipo']), "text"),
        GetSQLValueString(trim($_POST['nomdim']), "text"),
		GetSQLValueString(trim($_POST['nommara']), "text"),
		GetSQLValueString(trim($_POST['nomsella']), "text"),
        GetSQLValueString($_POST['deporte'], "int"),
        
        GetSQLValueString($_POST['orden'], "int"),
		GetSQLValueString($_POST['pais'], "text"),
        GetSQLValueString($_POST['Id_p1equipos'], "int")
    );
        
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));


if($_POST['liga']<>$row_Recordset1['liga']){
	$insertSQL2 = sprintf(
        "/* PARSEADORES1 new\parley\adeditarequipo.php - QUERY 3 */ UPDATE p1equipos 
				SET 
			liga=%s			
				WHERE Id_p1equiposp1=%s",
		GetSQLValueString($_POST['liga'], "text"),
        GetSQLValueString($_POST['Id_p1equipos'], "int")
    );
        
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
}else{
	$insertSQL2 = sprintf(
        "/* PARSEADORES1 new\parley\adeditarequipo.php - QUERY 4 */ UPDATE p1equipos 
				SET 
			liga=%s			
				WHERE Id_p1equiposp1=%s",
		GetSQLValueString($_POST['competicion'], "text"),
        GetSQLValueString($_POST['Id_p1equipos'], "int")
    );
        
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
}    


if($_POST['pais']<>$row_Recordset1['pais']){
	$insertSQL3 = sprintf(
        "/* PARSEADORES1 new\parley\adeditarequipo.php - QUERY 5 */ UPDATE p1equipos 
				SET 
			pais=%s			
				WHERE Id_p1equiposp1=%s",
		GetSQLValueString($_POST['pais'], "text"),
        GetSQLValueString($_POST['Id_p1equipos'], "int")
    );
        
    $Result2 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
}else{
	$insertSQL3 = sprintf(
        "/* PARSEADORES1 new\parley\adeditarequipo.php - QUERY 6 */ UPDATE p1equipos 
				SET 
			pais=%s			
				WHERE Id_p1equiposp1=%s",
		GetSQLValueString($_POST['competicion2'], "text"),
        GetSQLValueString($_POST['Id_p1equipos'], "int")
    );
        
    $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
}              

    
    $insertGoTo = "adlistaequipos.php";

    header(sprintf("Location: %s", $insertGoTo));
	
}

  
			
$query_Recordset2 =  sprintf(
"/* PARSEADORES1 new\parley\adeditarequipo.php - QUERY 7 */ SELECT DISTINCT  liga
FROM  p1equipos
WHERE deportep1=%s
ORDER BY liga",
GetSQLValueString($row_Recordset1['deportep1'], "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);   

$query_Recordset3 =  sprintf(
	"/* PARSEADORES1 new\parley\adeditarequipo.php - QUERY 8 */ SELECT DISTINCT  pais
	FROM  p1equipos
	ORDER BY pais",
	GetSQLValueString($row_Recordset1['deportep1'], "int")
	);
	$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
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
require_once('../parley/admenu.php');
?>

		<div class="container">
			<div class="row">
				<h3 style="text-align:center">Editar Equipo</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">


				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre del Equipo</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="nomequipo" name="nomequipo" value="<?php echo $row_Recordset1['nomequipop1']; ?>" placeholder="nomequipo"  
						title="nomequipo. 4-20 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{4,100}" 
						required>
					</div>
					<div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00"></div>
<div class="col-sm-4">
						<input type="text" class="form-control" id="nomdim" name="nomdim" value="<?php echo $row_Recordset1['nomdimp1']; ?>" placeholder="nomdim"  
						title="nomdim. 2-20 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{4,100}" 
						required>
					</div>	
					
					<br>

					<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre en Maradeportes</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="nommara" name="nommara" value="<?php echo $row_Recordset1['nommara']; ?>" placeholder="Ingrese el Nombre de Maradeportes"  
						title="nomequipo1. 4-100 caracteres" size="32"  
maxlength="30">
					</div>

<!--
					<br>

					<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre en Sella tu Parley</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="nomsella" name="nomsella" value="<?php echo $row_Recordset1['nomsella']; ?>" placeholder="Ingresa el Nombre en Sella tu Parley"  
						title="nomequipo1. 4-20 caracteres" size="32"  
maxlength="30" pattern="[A-Z a-z0-9]{4,100}" >
					</div>
					



					
					</div>


	-->

	<br>
					
					
								<div class="form-group">
					<label for="deporte" class="col-sm-8 control-label">Deporte al que Pertenece</label>
					<div class="col-sm-4">
					<select name="deporte"  class="textbox"  id="deporte"  required>
				                      <option value="0" 
					<?php if (!(strcmp(0, htmlentities($row_Recordset1['deportep1'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>beisbol</option>
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($row_Recordset1['deportep1'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>baloncesto</option>
                    <option value="2" 
					<?php if (!(strcmp(2, htmlentities($row_Recordset1['deportep1'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Futbol</option>
						                      <option value="3" 
					<?php if (!(strcmp(3, htmlentities($row_Recordset1['deportep1'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Hockey</option>

<option value="4" 
					<?php if (!(strcmp(3, htmlentities($row_Recordset1['deportep1'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>Futbol Americano</option>
                  </select>
				  </div>
					</div>
					
													
<div class="form-group">
	<label for="nombre" class="col-sm-8 control-label">Seleccione Liga a la que pertenece el Equipo</label>
	<div class="col-sm-4">
		

	<select name="competicion" class="textbox" >
                    <option value="<?php echo $row_Recordset1['liga']; ?>"><?php echo $row_Recordset1['liga']; ?></option>
                      <?php
                                    do {

                                     


                                        if($row_Recordset2['liga'] != ''){
                                      
                                      
                                        ?>
                    <option value="<?php echo $row_Recordset2['liga'];?>"
                    <?php if (strtoupper($row_Recordset2['liga'])==$row_Recordset1['liga']) {
                        echo "SELECTED";
                    } ?>>    
                    
                    <?php  echo $row_Recordset2['liga'];} 
                    
                    ?> </option>
                    <?php
                                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2)); ?>
                    </select>

					
					</div>
					</div>


                    <p><a href="javascript:mostrar();" class="btn btn-success" style="font-size: 12px;">Agregar Nueva Liga</a></p>
<div id="flotante" style="display:none;">
     
<div class="form-group">

    <div class="form-group">
					<div class="col-sm-4">
<input type="text" class="form-control" id="liga" name="liga" value="<?php echo $row_Recordset1['liga']; ?>" placeholder="Ingrese nombre de Liga"  
						title="nomequipo. 4-20 caracteres" size="32" maxlength="30">
					</div>
					</div>
          


     <div id="close"><a href="javascript:cerrar();" class="btn btn-success" style="font-size: 12px;" >cerrar</a></div>
</div>


</div>


<div class="form-group">
	<label for="nombre" class="col-sm-8 control-label">Seleccione el Pais del Equipo</label>
	<div class="col-sm-4">
					

	<select name="competicion2" class="textbox">
                    <option value="<?php echo $row_Recordset1['pais']; ?>"><?php echo $row_Recordset1['pais']; ?></option>
                      <?php
                                    do {

                                     


                                        if($row_Recordset3['pais'] != ''){
                                      
                                      
                                        ?>
                    <option value="<?php echo $row_Recordset3['pais'];?>"
                    <?php if (strtoupper($row_Recordset3['pais'])==$row_Recordset1['pais']) {
                        echo "SELECTED";
                    } ?>>    
                    
                    <?php  echo $row_Recordset3['pais'];} 
                    
                    ?> </option>
                    <?php
                                    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3)); ?>
                    </select>


					
					</div>
					</div>


					
<div class="form-group">

    <div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Agregar Nuevo Pais (Solo de no Existir en la Lista)</label>
					<div class="col-sm-4">
<input type="text" class="form-control" id="pais" name="pais" value="<?php echo $row_Recordset1['pais']; ?>" placeholder="Ingrese el Pais"  
title="nomequipo1. 4-100 caracteres" size="32"  
maxlength="30">
					</div>
					</div>


      


</div>

</div>





<!--
					<div class="form-group">
					<label for="orden" class="col-sm-8 control-label">Orden</label>
					<div class="col-sm-4">
					<select name="orden"  class="textbox"  id="orden"  required>
				                      <option value="0" 
					<?php //if (!(strcmp(0, htmlentities($row_Recordset1['ordenp1'], ENT_COMPAT, 'utf-8')))) {
    //echo "SELECTED";
//} ?>>1 beisbol mlb</option>
                    <option value="1" 
					<?php //if (!(strcmp(1, htmlentities($row_Recordset1['ordenp1'], ENT_COMPAT, 'utf-8')))) {
    //echo "SELECTED";
//} ?>>NBA</option>
                    <option value="2" 
					<?php //if (!(strcmp(2, htmlentities($row_Recordset1['ordenp1'], ENT_COMPAT, 'utf-8')))) {
   // echo "SELECTED";
//} ?>>Futbol</option>
						                      <option value="3" 
					<?php //if (!(strcmp(3, htmlentities($row_Recordset1['ordenp1'], ENT_COMPAT, 'utf-8')))) {
    //echo "SELECTED";
//} ?>>Sol Peruano</option>
                                           <option value="4" 
					<?php //if (!(strcmp(3, htmlentities($row_Recordset1['deportep1'], ENT_COMPAT, 'utf-8')))) {
    //echo "SELECTED";
//} ?>>NFL</option>
                  </select>
				  </div>

					</div>

-->
					
				<input type="hidden" name="Id_p1equipos" value="<?php echo $recordID ?>"/>
				


				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="adlistaequipos.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Editar equipo</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
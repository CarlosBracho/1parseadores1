<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
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
        "/* PARSEADORES1 parley\adeditarjuego.php - QUERY 1 */ UPDATE p2juegos 
				SET  deportep2=%s, pichee1p2=%s, pichee2p2=%s, iniciodtp2=%s, paisp2=%s			
				WHERE Id_p2juegosp2=%s",
        
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


if (isset($_POST['nomequipo'])) {
  $insertSQL1 = sprintf(
      "/* PARSEADORES1 parley\adeditarjuego.php - QUERY 2 */ UPDATE p2juegos 
      SET nomequipop1=%s,
    nomdimp1=%s,
    deportep1=%s,
    ligap1=%s,
    ordenp1=%s
    competicionp2=%s				
      WHERE Id_p1equiposp1=%s",
      GetSQLValueString(strtoupper($_POST['nomequipo']), "text"),
      GetSQLValueString(strtoupper($_POST['nomdim']), "text"),
      GetSQLValueString($_POST['deporte'], "int"),
      GetSQLValueString($_POST['liga'], "int"),
      GetSQLValueString($_POST['orden'], "int"),
      GetSQLValueString($_POST['competicion'], "text"),
      GetSQLValueString($_POST['Id_p1equipos'], "int")
  );
      
  $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

}

        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 parley\adeditarjuego.php - QUERY 3 */ SELECT *
FROM p2juegos WHERE Id_p2juegosp2=%s",
            GetSQLValueString($recordID, "int")
        );
$Recordset1 =mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


    $query_Recordset2 = sprintf("/* PARSEADORES1 parley\adeditarjuego.php - QUERY 4 */ SELECT *
FROM p1equipos ORDER BY nomequipop1");
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);


    $query_Recordset3 = sprintf("/* PARSEADORES1 parley\adeditarjuego.php - QUERY 5 */ SELECT *
FROM p1equipos ORDER BY nomequipop1");
$Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$query_Recordset18 = sprintf(
	"/* PARSEADORES1 parley\adeditarjuego.php - QUERY 6 */ SELECT *
FROM p2juegos"
);
$Recordset18 =mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);


echo $row_Recordset1['competicionp2'];

$query_Recordset99 =  sprintf(
  "/* PARSEADORES1 parley\adeditarjuego.php - QUERY 7 */ SELECT  
deportep2, competicionp2
  FROM  p2juegos"
);
      $Recordset99 = mysqli_query($conexionbanca, $query_Recordset99) or die(mysqli_error($conexionbanca));
      $row_Recordset99 = mysqli_fetch_assoc($Recordset99);
      $totalRows_Recordset99 = mysqli_num_rows($Recordset99);



if(isset($_POST['operador'])==5 && (isset($_POST['competicion']))){



    $insertSQL20 = sprintf(
      "/* PARSEADORES1 parley\adeditarjuego.php - QUERY 8 */ UPDATE p2juegos 
      SET  competicionp2=%s		
      WHERE Id_p2juegosp2=%s",
      
      GetSQLValueString($_POST['competicion'], "text"),
      GetSQLValueString($_POST['idfuncion'], "int")
  );



      
  $Result20 = mysqli_query($conexionbanca, $insertSQL20) or die(mysqli_error($conexionbanca));





$insertGoTo = "adeditorparley.php";

    header(sprintf("Location: %s", $insertGoTo));

  
}


if(isset($_POST['operador'])==5 && (isset($_POST['competicion2']))){


  

  


    $insertSQL21 = sprintf(
      "/* PARSEADORES1 parley\adeditarjuego.php - QUERY 9 */ UPDATE p2juegos 
      SET  competicionp2=%s		
      WHERE Id_p2juegosp2=%s",
      
      GetSQLValueString($_POST['competicion2'], "text"),
      GetSQLValueString($_POST['idfuncion'], "int")
  );



      
  $Result21 = mysqli_query($conexionbanca, $insertSQL21) or die(mysqli_error($conexionbanca));



$insertGoTo = "adeditorparley.php";

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
				<h3 style="text-align:center">Editar Juego</h3>
			</div>
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">



				<div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre del Equipo 1</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="nomequipo1" name="nomequipo1" placeholder="PICHE EQUIPO 1"  readonly="readonly" 
						 size="32"   value="<?php
    $query_Recordset222 = sprintf(
    "/* PARSEADORES1 parley\adeditarjuego.php - QUERY 10 */ SELECT *
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
</div>

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
					<label for="nombre" class="col-sm-8 control-label">Nombre del Equipo 2</label>
					<div class="col-sm-4">					
						<input type="text" class="form-control" id="nomequipo2" name="nomequipo2" placeholder="PICHE EQUIPO 1"   readonly="readonly"
						title="PICHE EQUIPO 1. 2-30 caracteres" size="32"   value="<?php
    $query_Recordset222 = sprintf(
                             "/* PARSEADORES1 parley\adeditarjuego.php - QUERY 11 */ SELECT *
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
					
					

							
<br>

<label for="competicion" class="col-sm-8 control-label">competicion</label><br>
                  <?php if($row_Recordset1['deportep2'] == 'futbol') {?>

				  <?php //SELECT CON BASE DE DATOS?>
<select name="competicion" id="competicion" class="form-/* PARSEADORES1 parley\adeditarjuego.php - QUERY 12 */ select" style="text-align: center; border: solid" required>
                      <option value="todos">TODOS</option>
                      <?php
                do {


                  if(($row_Recordset18['deportep2'] == 'futbol') && ($row_Recordset18["competicionp2"] <> '')){
                    ?>
               <option value="<?php echo $row_Recordset18['competicionp2']?>"
               <?php if (strtoupper($row_Recordset18['competicionp2'])) {
                        echo "SELECTED";
                    } ?>>
							 <?php
               if($row_Recordset18['competicionp2'] != ''){
               echo strtoupper($row_Recordset18['competicionp2']); }?>
               </option>
              }
                      <?php
                  }
                }while ($row_Recordset18 = mysqli_fetch_assoc($Recordset18));
                ?>
                    </select>
                    <?php }?>



                    <?php if ($row_Recordset1["deportep2"]=='beisbol') {?>

<?php //SELECT CON BASE DE DATOS?>
<select name="competicion" class="form-/* PARSEADORES1 parley\adeditarjuego.php - QUERY 13 */ select" style="text-align: center; border: solid">
            <option value="todos">TODOS</option>
            <?php
      do {


        if(($row_Recordset18['deportep2'] == 'beisbol') && ($row_Recordset18["competicionp2"] <> '')){
          ?>
     <option value="<?php if($row_Recordset18['competicionp2'] != ''){ echo $row_Recordset18['competicionp2']; }?>"
     <?php if (strtoupper($row_Recordset18['competicionp2'])) {
              echo "SELECTED";
          } ?>>
     <?php echo strtoupper($row_Recordset18['competicionp2']); ?>
     </option>
    }
            <?php
        }
      }while ($row_Recordset18 = mysqli_fetch_assoc($Recordset18));
      ?>
          </select>
          <?php }?>




          <?php if ($row_Recordset1["deportep2"]=='baloncesto') {?>

<?php //SELECT CON BASE DE DATOS?>
<select name="competicion" class="form-/* PARSEADORES1 parley\adeditarjuego.php - QUERY 14 */ select" style="text-align: center; border: solid">
            <option value="todos">TODOS</option>
            <?php
      do {


        if(($row_Recordset18['deportep2'] == 'baloncesto') && ($row_Recordset18["competicionp2"] <> '')){
          ?>
     <option value="<?php if($row_Recordset18['competicionp2'] != ''){ echo $row_Recordset18['competicionp2']; }?>"
     <?php if (strtoupper($row_Recordset18['competicionp2'])) {
              echo "SELECTED";
          } ?>>
     <?php echo strtoupper($row_Recordset18['competicionp2']); ?>
     </option>
    }
            <?php
        }
      }while ($row_Recordset18 = mysqli_fetch_assoc($Recordset18));
      ?>
          </select>
          <?php }?>


          <?php if ($row_Recordset1["deportep2"]=='hockey') {?>

<?php //SELECT CON BASE DE DATOS?>
<select name="competicion" class="form-/* PARSEADORES1 parley\adeditarjuego.php - QUERY 15 */ select" style="text-align: center; border: solid">
            <option value="todos">TODOS</option>
            <?php
      do {


        if(($row_Recordset18['deportep2'] == 'hockey') && ($row_Recordset18["competicionp2"] <> '')){
          ?>
     <option value="<?php if($row_Recordset18['competicionp2'] != ''){ echo $row_Recordset18['competicionp2']; }?>"
     <?php if (strtoupper($row_Recordset18['competicionp2'])) {
              echo "SELECTED";
          } ?>>
     <?php echo strtoupper($row_Recordset18['competicionp2']); ?>
     </option>
    }
            <?php
        }
      }while ($row_Recordset18 = mysqli_fetch_assoc($Recordset18));
      ?>
          </select>
          <?php }?>




          <?php if ($row_Recordset1["deportep2"]=='futbol americano') {?>

<?php //SELECT CON BASE DE DATOS?>
<select name="competicion" class="form-/* PARSEADORES1 parley\adeditarjuego.php - QUERY 16 */ select" style="text-align: center; border: solid">
            <option value="todos">TODOS</option>
            <?php
      do {


        if(($row_Recordset18['deportep2'] == 'futbol americano') && ($row_Recordset18["competicionp2"] <> '')){
          ?>
     <option value="<?php if($row_Recordset18['competicionp2'] != ''){ echo $row_Recordset18['competicionp2']; }?>"
     <?php if (strtoupper($row_Recordset18['competicionp2'])) {
              echo "SELECTED";
          } ?>>
     <?php echo strtoupper($row_Recordset18['competicionp2']); ?>
     </option>
    }
            <?php
        }
      }while ($row_Recordset18 = mysqli_fetch_assoc($Recordset18));
      ?>
          </select>
          <?php }?>
          
                    
					
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
Agregar Competicion
</button>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Agregar Competicion</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

    <div class="form-group">
					<label for="nombre" class="col-sm-8 control-label">Nombre de la Competicion</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="competicion" name="competicion" value="<?php echo $row_Recordset1['competicionp2']; ?>" placeholder="competicion"  
						title="nomequipo. 4-20 caracteres" size="32"  
maxlength="30" 
						>
					</div>
					</div>

      <!-- Modal footer -->
      <div class="modal-footer">
	  <button type="submit" class="btn btn-primary">Guardar</button>
      </div>

    </div>
  </div>
</div>
<br><br>
					
			<input type="hidden" name="Id_p2juegosp2" value="<?php echo $recordID ?>"/>
								
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
          


          <select name="competicion" style="width:100%; height: auto" class="textbox">
                    <option value="">SELECCIONE
                      <?php


if(isset($_POST['funcion'])){
  
  $_GET["recordID"] = $_POST['funcion'];

}
                                    do {

                                      if ($_GET["recordID"]==0){ 


                                        if($row_Recordset99['competicionp2'] != '' && $row_Recordset99['deportep2']=='beisbol'){
                                      
                                      
                                        ?>
                    <option value="<?php echo $row_Recordset99['competicionp2'];?>">
                        
                    
                    
                    <?php  echo $row_Recordset99['competicionp2'];} }
                    
                    
                    if ($_GET["recordID"]==1){ 


                      if($row_Recordset99['competicionp2'] != '' && $row_Recordset99['deportep2']=='baloncesto'){
                    
                    
                      ?>
  <option value="<?php echo $row_Recordset99['competicionp2']?>">
      
  <?php  echo $row_Recordset99['competicionp2'];} }
                    
                    
                    if ($_GET["recordID"]==2){ 


                      if($row_Recordset99['competicionp2'] != '' && $row_Recordset99['deportep2']=='futbol'){
                    
                    
                      ?>
  <option value="<?php echo $row_Recordset99['competicionp2']?>">
      
  
  <?php  echo $row_Recordset99['competicionp2'];} }
                    
                    if ($_GET["recordID"]==4){ 


                      if($row_Recordset99['competicionp2'] != '' && $row_Recordset99['deportep2']=='futbolamericano'){
                    
                    
                      ?>
  <option value="<?php echo $row_Recordset99['competicionp2']?>">
      
  
  
  <?php  echo $row_Recordset99['competicionp2'];} }
                    
                    if ($_GET["recordID"]==5){ 


                      if($row_Recordset99['competicionp2'] != '' && $row_Recordset99['deportep2']=='hockey'){
                    
                    
                      ?>
  <option value="<?php echo $row_Recordset99['competicionp2']?>">
      
  
  
  <?php  echo $row_Recordset1['competicionp2'];} }?> </option>
                    <?php
                                    } while ($row_Recordset99 = mysqli_fetch_assoc($Recordset99)); ?>
                    </select>




                  
                    <br>
                    <br>
                    <p><a href="javascript:mostrar();" class="btn btn-primary">Crear Nueva Competicion</a></p>
<div id="flotante" style="display:none;">
     
<div class="form-group">
					<label for="competicion" class="col-sm-8 control-label">Nombre de Competicion</label>
					<div class="col-sm-4">
                    <input type="text" class="form-control" id="competicion2" name="competicion2" value="" placeholder="Ingrese Competicion"  
						title="nomequipo. 4-20 caracteres" size="32" maxlength="30">
					</div>
					</div>
          


     <div id="close"><a href="javascript:cerrar();" class="btn btn-primary">cerrar</a></div>
</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
          <?php if(!isset($_POST['funcion'])){  ?>



<a href="adlistajuegos.php" class="btn btn-default">Regresar</a>

<button type="submit" class="btn btn-primary">Crear Juego</button>

</div>
				</div>
			</form>
		</div>

<?php
}else{
?>

<a href="adeditorparley.php" class="btn btn-default">Regresar</a>

<button type="submit" class="btn btn-primary">Actualizar Competencia</button>

</div>
				</div>
			</form>
		</div>

<?php
}
?>



	</body>

</html>
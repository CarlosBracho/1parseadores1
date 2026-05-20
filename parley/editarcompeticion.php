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


    $editFormAction = $_SERVER['PHP_SELF'];






$query_Recordset18 = sprintf(
	"/* PARSEADORES1 parley\editarcompeticion.php - QUERY 1 */ SELECT *
FROM p2juegos"
);
$Recordset18 =mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);




$query_Recordset99 =  sprintf(
  "/* PARSEADORES1 parley\editarcompeticion.php - QUERY 2 */ SELECT  
deportep2, competicionp2
  FROM  p2juegos"
);
      $Recordset99 = mysqli_query($conexionbanca, $query_Recordset99) or die(mysqli_error($conexionbanca));
      $row_Recordset99 = mysqli_fetch_assoc($Recordset99);
      $totalRows_Recordset99 = mysqli_num_rows($Recordset99);

      $ID=$_POST['idfuncion'];


if(isset($_POST['competicion'])!=''){



    $insertSQL20 = sprintf(
      "/* PARSEADORES1 parley\editarcompeticion.php - QUERY 3 */ UPDATE p2juegos 
      SET  competicionp2=%s		
      WHERE Id_p2juegosp2=%s",
      
      GetSQLValueString($_POST['competicion'], "text"),
      GetSQLValueString($_POST['D'], "int")
  );



      
  $Result20 = mysqli_query($conexionbanca, $insertSQL20) or die(mysqli_error($conexionbanca));





$insertGoTo = "adeditorparley.php";

    header(sprintf("Location: %s", $insertGoTo));

  
}


if(isset($_POST['competicion2'])!=''){


  

  


    $insertSQL21 = sprintf(
      "/* PARSEADORES1 parley\editarcompeticion.php - QUERY 4 */ UPDATE p2juegos 
      SET  competicionp2=%s		
      WHERE Id_p2juegosp2=%s",
      
      GetSQLValueString($_POST['competicion2'], "text"),
      GetSQLValueString($_POST['D'], "int")
  );



      
  $Result21 = mysqli_query($conexionbanca, $insertSQL21) or die(mysqli_error($conexionbanca));



$insertGoTo = "adeditorparley.php";

    header(sprintf("Location: %s", $insertGoTo));
  
}




echo $_POST['idfuncion'];



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




		
			
			<form class="form-horizontal" name="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">



				
          

            <?php /*/ echo "la seleccion de competicion no esta disponible aun";?>
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
      
  
  
  <?php  echo $row_Recordset99['competicionp2'];} }?> </option>
                    <?php
                                    } while ($row_Recordset99 = mysqli_fetch_assoc($Recordset99)); /*/ ?>
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
                        <input type="hidden" name="D" value="<?php echo $ID;?>">
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
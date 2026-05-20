<?php 
  session_start();

  unset($_SESSION['consulta']);


 ?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

 
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">
  <link rel="stylesheet" type="text/css" href="librerias/select2/css/select2.css">

	<script src="librerias/jquery-3.2.1.min.js"></script>
  <script src="js/Diegologros.js"></script>
	<script src="librerias/bootstrap/js/bootstrap.js"></script>
	<script src="librerias/alertifyjs/alertify.js"></script>
  <script src="librerias/select2/js/select2.js"></script>
</head>
<body>



<div id="editor"></div>


		


	<!-- Modal para registros nuevos -->

    <div class="modal fade" id="modalNuevologros" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agrega Nuevo Equipo</h4>
      </div>
      <div class="modal-body">
        	<input type="hidden" name="" id="idjuegop32" class="form-control input-sm" >
        	<label>TIPO DE JUGADA</label>
        	<input type="text" name="" id="tipojugadap32" class="form-control input-sm" readonly>
        	<input type="hidden" name="" id="idequipo1p2" class="form-control input-sm">
        	<label>NOMBRE DE EQUIPO</label>
        	<input type="text" name="" id="nomequipop1" class="form-control input-sm" readonly>
        	<label>INSERTE LOGRO</label>
        	<input type="text" name="" id="logro2" class="form-control input-sm" autocomplete="off">
          <label>INSERTE LOGRO ALTA Y BAJA O RUNLANE (NO COLOCAR SI ES ML, SI/NO Y ANOTA PRIMERO)</label>
        	<input type="text" name="" id="logroABoRL2" class="form-control input-sm" autocomplete="off">
          <input type="hidden" name="" id="numequipo" class="form-control input-sm" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarnuevo">
        Agregar
        </button>
       
      </div>
    </div>
  </div>
</div>


<!-- Modal para edicion de datos -->

<div class="modal fade" id="modalEdicion2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar Equipo</h4>
      </div>
      <div class="modal-body">
      <label>SI EL TIPO DE JUGADA ES ML, SI/NO Y ANOTA PRIMERO  <br> SOLO COLOCAR EL VALOR DEL LOGRO ARRIBA</label>
         <label>LOGRO</label>
          <input type="text" name="" id="logro" class="form-control input-sm">
        	<label>TIPO DE JUGADA</label>
          <input type="text" name="" id="tipojugadap3" class="form-control input-sm" readonly>
          <label>LOGRO ALTA Y BAJA O RUNLANE (NO COLOCAR SI ES ML, SI/NO Y ANOTA PRIMERO)</label>
        	<input type="text" name="" id="logroABoRL" class="form-control input-sm">
        	<input type="hidden" name="" id="Id_p3logrosp3" class="form-control input-sm">
        	
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="actualizadatos" data-dismiss="modal">Actualizar</button>
        
      </div>
    </div>
  </div>
</div>

</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
		$('#editor').load('editor_ajax.php');
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#guardarnuevo').click(function(){
          logro=$('#logro2').val();
	logroABoRL=$('#logroABoRL2').val();
	idjuegop3=$('#idjuegop32').val();
	tipojugadap3=$('#tipojugadap32').val();
	numequipo=$('#numequipo').val();
	idequipo1p2=$('#idequipo1p2').val();
          Dalogros(logro,logroABoRL,idjuegop3,tipojugadap3,numequipo,idequipo1p2);
        });



        $('#actualizadatos').click(function(){
          Dalogros2();
        });

    });
</script>
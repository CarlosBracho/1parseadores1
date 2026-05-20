<?php 
  session_start();

  unset($_SESSION['consulta']);

 ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Lista de Equipos</title>
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
	<link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">
  <link rel="stylesheet" type="text/css" href="librerias/select2/css/select2.css">

	<script src="librerias/jquery-3.2.1.min.js"></script>
	<script src="librerias/bootstrap/js/bootstrap.js"></script>
	<script src="librerias/alertifyjs/alertify.js"></script>
  <script src="librerias/select2/js/select2.js"></script>

  <script language="javascript">


function agregardatos(nomequipop1,nommara,nommarapais,nomsella,deportep1,liga,pais){

cadena="nomequipop1=" + nomequipop1 + 
    "&nommara=" + nommara +
    "&nommarapais=" + nommarapais +
    "&nomsella=" + nomsella +
    "&deportep1=" + deportep1 +
    "&liga=" + liga +
    "&pais=" + pais;

$.ajax({
  type:"POST",
  url:"agregarDatos.php",
  data:cadena,
  success:function(r){
    if(r==1){
      $('#tabla').load('tabla.php');
       $('#buscador').load('buscador.php');
      alertify.success("agregado con exito :)");
    }else{
      alertify.error("Fallo el servidor :(");
    }
  }
});

}

function agregaform(datos){

d=datos.split('||');



$('#Id_p1equiposp1u').val(d[0]);
$('#nomequipop1u').val(d[1]);
$('#nommarau').val(d[2]);
$('#nomsellau').val(d[3]);
$('#deportep1u').val(d[4]);
$('#ligau').val(d[5]);
$('#paisu').val(d[6]);
$('#nommarapaisu').val(d[7]);
}

function actualizaDatos(){

//alert('asdasdasdsad');
id=$('#Id_p1equiposp1u').val();
nomequipop1=$('#nomequipop1u').val();
nommara=$('#nommarau').val();
nommarapais=$('#nommarapaisu').val();
nomsella=$('#nomsellau').val();
deportep1=$('#deportep1u').val();
liga=$('#ligau').val();
pais=$('#paisu').val();


cadena="Id_p1equiposp1=" + id +
        "&nomequipop1=" + nomequipop1 + 
    "&nommara=" + nommara +
    "&nommarapais=" + nommarapais +
    "&nomsella=" + nomsella +
    "&deportep1=" + deportep1 +
    "&liga=" + liga +
    "&pais=" + pais;

$.ajax({
  type:"POST",
  url:"actualizaDatos.php",
  data:cadena,
  success:function(r){
    
    if(r==1){
      $('#tabla').load('tabla.php');
      alertify.success("Actualizado con exito :)");
    }else{
      alertify.error("Fallo el servidor :(");
    }
  }
});

}

function preguntarSiNo(id){
alertify.confirm('Eliminar Datos', '¿Esta seguro de eliminar este registro?', 
        function(){ eliminarDatos(id) }
              , function(){ alertify.error('Se cancelo')});
}

function eliminarDatos(id){

cadena="Id_p1equiposp1=" + id;

  $.ajax({
    type:"POST",
    url:"eliminarDatos.php",
    data:cadena,
    success:function(r){
      if(r==1){
        $('#tabla').load('tabla.php');
        alertify.success("Eliminado con exito!");
      }else{
        alertify.error("Fallo el servidor :(");
      }
    }
  });
}

</script>
</head>
<body>



	<div class="container">
    <div id="buscador"></div>
		<div id="tabla"></div>
	</div>

	<!-- Modal para registros nuevos -->


<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agrega Nuevo Equipo</h4>
      </div>
      <div class="modal-body">
        	<label>Nombre de Equipo</label>
        	<input type="text" name="" id="nomequipop1" class="form-control input-sm">
        	<label>Nombre en Maradeportes</label>
        	<input type="text" name="" id="nommara" class="form-control input-sm">
        	<label>Pais en Maradeportes</label>
        	<input type="text" name="" id="nommarapais" class="form-control input-sm">
                <label>Nombre en Sellatuparley</label>
        	<input type="text" name="" id="nomsella" class="form-control input-sm">
        	<label>Beisbol=0 Baloncesto=1 Futbol=2 Futbol Americano=4 Hockey=5 <br> Deporte</label>
        	<input type="text" name="" id="deportep1" class="form-control input-sm">
        	<label>Liga</label>
        	<input type="text" name="" id="liga" class="form-control input-sm">
          <label>Pais</label>
        	<input type="text" name="" id="pais" class="form-control input-sm">
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

<div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar Equipo</h4>
      </div>
      <div class="modal-body">
      		<input type="text" hidden="" id="Id_p1equiposp1u" name="">
        	<label>Nombre de Equipo</label>
        	<input type="text" name="" id="nomequipop1u" class="form-control input-sm">
        	<label>Nombre en Maradeportes</label>
        	<input type="text" name="" id="nommarau" class="form-control input-sm">
        	<label>Pais en Maradeportes</label>
        	<input type="text" name="" id="nommarapaisu" class="form-control input-sm">
          <label>Nombre en Sellatuparley</label>
        	<input type="text" name="" id="nomsellau" class="form-control input-sm">
        	<label>
          Beisbol=0 Baloncesto=1 Futbol=2 Futbol Americano=4 Hockey=5 <br>

          
          
          Deporte</label>
        	<input type="text" name="" id="deportep1u" class="form-control input-sm">
        	<label>Liga</label>
        	<input type="text" name="" id="ligau" class="form-control input-sm">
          <label>Pais</label>
        	<input type="text" name="" id="paisu" class="form-control input-sm">
          
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
		$('#tabla').load('tabla.php');
    $('#buscador').load('buscador.php');
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#guardarnuevo').click(function(){
          nom_equipo=$('#nomequipop1').val();
	        nommara=$('#nommara').val();
          nommarapais=$('#nommarapais').val();
          nomsella=$('#nomsella').val();
	        deporte=$('#deportep1').val();
	        liga=$('#liga').val();
	        pais=$('#pais').val();
            agregardatos(nom_equipo,nommara,nommarapais,nomsella,deportep1,liga,pais);
        });



        $('#actualizadatos').click(function(){
          actualizaDatos();
        });

    });
</script>



function agregardatos(nomequipop1,nommara,nomsella,deportep1,liga,pais){

	cadena="nomequipop1=" + nomequipop1 + 
			"&nommara=" + nommara +
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
	
}

function actualizaDatos(){


	id=$('#Id_p1equiposp1u').val();
	nomequipop1=$('#nomequipop1u').val();
	nommara=$('#nommarau').val();
	nomsella=$('#nomsellau').val();
	deportep1=$('#deportep1u').val();
	liga=$('#ligau').val();
	pais=$('#paisu').val();


	cadena="Id_p1equiposp1=" + id +
	        "&nomequipop1=" + nomequipop1 + 
			"&nommara=" + nommara +
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
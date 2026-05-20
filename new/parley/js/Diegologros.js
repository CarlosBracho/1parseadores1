
function Dalogros(logro,logroABoRL,idjuegop3,tipojugadap3,numequipo,idequipo1p2){


	cadena="logro2=" + logro + 
			"&logroABoRL2=" + logroABoRL +
			"&idjuegop32=" + idjuegop3 +
			"&tipojugadap32=" + tipojugadap3 +
			"&numequipo=" + numequipo +
			"&idequipo1p2=" + idequipo1p2;

	$.ajax({
		type:"POST",
		url:"Registro_logros_ajax.php",
		data:cadena,
		success:function(r){
			if(r==1){
				$('#editor').load('editor_ajax.php');
				alertify.success("agregado con exito :)");
			}else{
				alertify.error("Fallo el servidor :(");
			}
		}
	});

}

function agregaformlogros(datos){

	d=datos.split('||');

	

	$('#logro').val(d[0]);
	$('#logroABoRL').val(d[1]);
	$('#Id_p3logrosp3').val(d[2]);
	$('#tipojugadap3').val(d[3]);

	
}

function agregaridlogros(datos){

	d=datos.split('||');

	

	$('#idjuegop32').val(d[0]);
	$('#tipojugadap32').val(d[1]);
	$('#idequipo1p2').val(d[2]);
	$('#nomequipop1').val(d[3]);
	$('#numequipo').val(d[4]);

	
}
function Dalogros2(logro,logroABoRL,Id_p3logrosp3){

	logro=$('#logro').val();
	logroABoRL=$('#logroABoRL').val();
	Id_p3logrosp3=$('#Id_p3logrosp3').val();

	cadena="logro=" + logro + 
			"&logroABoRL=" + logroABoRL +
			"&Id_p3logrosp3=" + Id_p3logrosp3;

	$.ajax({
		type:"POST",
		url:"Actualiza_logros.php",
		data:cadena,
		success:function(r){
			if(r==1){
				$('#editor').load('editor_ajax.php');
				alertify.success("Actualizado con exito :)");
			}else{
				alertify.error("Fallo el servidor :(");
			}
		}
	});

}

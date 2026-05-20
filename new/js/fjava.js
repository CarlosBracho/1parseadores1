$(document).keydown(function(tecla){
	switch(tecla.keyCode) {
		case 37:
			//alert("< izquierda desplega menu hipodromo");
			break;
		case 39:
			//alert("> derecha desplega menu hipodromo");
			break;
		case 66:
			//alert("b cuadre de caja");
			break;
		case 67:
			//alert("c reimprimir último ticket");
			break;
		case 77:
			//alert("m reporte de jugadas");
			break;
		case 90:
			//alert("z botón de actualizar página");
			//location.reload();
			//window.location='index.php';
			break;
		case 106:
			//alert("* botón de pagar apuesta");
			//bProcesaPago();
			break;
		case 107:
			//alert("+ ir a pagar o eliminar");
			//cleanDiv();
			//document.getElementById("pagarT").focus();
			break;
		case 109:
			//alert("- realizar apuesta e imprimir ticket");
			//document.getElementById("form1").submit();
			//bAportarImprimir();
			break;
		case 111:
			//alert("/ botón de eliminar ticket");
			//bEliminaTicket();
			break;
	}
});

function bProcesaPago() {
	if (document.getElementById('pagarT').value!=0) {
		document.getElementById('pagamensaje').style.display = 'block';
		document.getElementById('pagaTicket').style.display = 'none';
		document.getElementById('eliminaTicket').style.display = 'none';
		$('#buttonazul').prop("disabled", true);
		var elElemento=document.getElementById('pagamensaje');
		var url = "../ventas/ventas_pagar_apuestas_procesar.php"; // El script en dónde se realizará la petición.
		var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
		var esper1 = '<img src="../images/buscando.gif" width="60" height="60" /><br/>En Proceso! Por favor espere ...';
		elElemento.style.display = 'block';
		$('#buttonrojo').prop("disabled", true);
		$.ajax({ type: "POST", url: url, global : false, data: $("#form2").serialize(),
			beforeSend: function(){ 
				$('#pagamensaje').html(esper1);
			},
			success: function(data) {
				$("#pagamensaje").html(data);
				$('#buttonrojo').prop("disabled", false);
				$('#buttonazul').prop("disabled", false);
			},
			error: function(){ 
				$("#pagamensaje").html(xerror);
				$('#pagamensaje').fadeOut(119000);
				$('#buttonrojo').prop("disabled", false);
				$('#buttonazul').prop("disabled", false);
			}
		});
		document.getElementById("numCa44").focus();
	}
	return false; // Evitar ejecutar el submit del formulario.
}
function bEliminaTicket() {
	if (document.getElementById('pagarT').value!=0) {
		document.getElementById('pagamensaje').style.display = 'block';
		document.getElementById('pagaTicket').style.display = 'none';
		document.getElementById('eliminaTicket').style.display = 'none';
		$('#buttonazul').prop("disabled", true);
		var elElemento=document.getElementById('pagamensaje');
		var url = "../ventas/ventas_eliminar_ticket.php"; // El script en dónde se realizará la petición.
		var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
 		var esper1 = '<img src="../images/buscando.gif" width="60" height="60" />';
  		var esper2 = '<br/>Eliminación en Proceso! Por favor espere ...';
		elElemento.style.display = 'block';
		$('#buttonrojo').prop("disabled", true);
		$.ajax({ type: "POST", url: url, global : false, data: $("#form2").serialize(),
			beforeSend: function(){ $('#pagamensaje').html(esper1+esper2); },
			success: function(data) { $("#pagamensaje").html(data); 
				$('#buttonrojo').prop("disabled", false);
				$('#buttonazul').prop("disabled", false);
			},
			error: function(){ 
				$("#pagamensaje").html(xerror);
				$('#pagamensaje').fadeOut(119000);
				$('#buttonrojo').prop("disabled", false);
				$('#buttonazul').prop("disabled", false);
			}
		});
	}
	return false; // Evitar ejecutar el submit del formulario.
}

function cleanDiv() {
	document.getElementById('pagarT').value="";
	$("#info1").html('<font color="red"><strong><?php echo $mensaje1; ?></strong></font>');
	$("#info2").html('<font color="red"><strong><?php echo $mensaje2; ?></strong></font>');
	document.getElementById('pagamensaje').style.display = 'none';
	document.getElementById('pagaTicket').style.display = 'block';
	document.getElementById('eliminaTicket').style.display = 'block';
}
//--------------------------------------------------LOTERIA-----------------------------------------------------------------
function java_triter() {
	cambiarOn('numero');
	cambiarOn('monto');
	cambiarOn('cargar');
	cambiarOff('termi'),
    cambiarOff('segui');
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_seguidilla").value="";
	document.getElementById('RadioGroup1_0').checked = "checked";
	contDiv('informacion', '(Activo) <u>Triple/Terminal</u>');
	LenField3('num_apuesta');
	foco('num_apuesta');
	
	//document.getElementById('num_apuesta').focus();
	
}
function java_permuta() {
	//cleanGet();
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_seguidilla").value="";
	cambiarOn('numero');
	cambiarOn('monto');
	cambiarOn('cargar');
	cambiarOff('termi'),
    cambiarOff('segui');
	document.getElementById('RadioGroup1_1').checked = "checked";
	LenField10('num_apuesta');
	contDiv('informacion', '(Activo) <u>Permuta</u>');
	//activar('num_apuesta','mon_apuesta','anadir','imganadir');
	foco('num_apuesta');
}
function java_serie() {
	//cleanGet();
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_seguidilla").value="";
	cambiarOff('termi');
	cambiarOff('segui');
	cambiarOn('numero');
	cambiarOn('monto');
	cambiarOn('cargar');
	document.getElementById('RadioGroup1_2').checked = "checked";
	contDiv('informacion', '(Activo) <u>Serie</u>: use * como comodin. ej: 4*5');
	//activar('num_apuesta','mon_apuesta','anadir','imganadir');
	LenField3('num_apuesta');
	foco('num_apuesta');
	
}
function java_termiauto() {
	//cleanGet();
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_seguidilla").value="";
	cambiarOn('numero');
	cambiarOn('monto');
	cambiarOn('cargar');
	cambiarOff('termi');
	cambiarOff('segui');
	LenField3('num_apuesta');  
	document.getElementById('RadioGroup1_3').checked = "checked";
	contDiv('informacion', '(Activo) <u>Terminal automático</u>');
	//activar('num_apuesta','mon_apuesta','anadir','imganadir');
	
	//document.getElementById('num_apuesta').focus();
	foco('num_apuesta');
	
}
function java_terminal() {
	document.getElementById("num_apuesta").value="";
	document.getElementById("mon_apuesta").value="";
	document.getElementById("mon_terminales").value="";
	cambiarOff('segui');
	cambiarOff('numero');
	cambiarOff('monto');
	cambiarOff('cargar');
	document.getElementById('RadioGroup1_4').checked = "checked";
	contDiv('informacion', '(Activo) <u>Terminales</u> a triples cargados');
	cambiarOn('termi');
	LenField3('num_apuesta');
	foco('mon_terminales');
}
function java_seguidilla() {
	//cleanGet();
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_apuesta").value="";
	document.getElementById("num_apuesta").value="";
	document.getElementById("inicio").value="";
	document.getElementById("fin").value="";
	cambiarOff('numero');
	cambiarOff('monto');
	cambiarOff('cargar');
	cambiarOff('termi'); 
	//desactivar('num_apuesta','mon_apuesta','anadir','imganadir'); 
	document.getElementById('RadioGroup1_5').checked = "checked";
	contDiv('informacion', '(Activo) <u>Seguidillas</u>');
	cambiarOn('segui');
	LenField3('num_apuesta');
	foco('inicio');
}
function selectTodo(id) { document.getElementById(id).select(); }
function cambiarDisplay(id) {
	if (!document.getElementById) 
		return false;
	fila = document.getElementById(id);
	if (fila.style.display != "none") 
		fila.style.display = "none"; //ocultar
	else 
		fila.style.display = ""; //mostrar
}
function cambiarOn(id) {
	if (!document.getElementById) 
		return false;
	fila = document.getElementById(id);
	fila.style.display = ""; //ocultar
}
function cambiarOff(id) {
	if (!document.getElementById) 
		return false;
	fila = document.getElementById(id);
	fila.style.display = "none"; //ocultar
}
function foco(idElemento) { setTimeout("",1100);document.getElementById(idElemento).focus(); }
function ancho(field){
	document.getElementById("field").maxLength = 10;
	document.getElementById(field).disabled = false;
}
function validar_numero(e) {
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true; 
	patron =/[0-9*]/; 
	tecla_final = String.fromCharCode(tecla);
 	return patron.test(tecla_final); 
}
function solo_numero(e) {
 	tecla = (document.all) ? e.keyCode : e.which;
 	if (tecla==8) return true; 
	patron =/[0-9]/; 
	tecla_final = String.fromCharCode(tecla);
 	return patron.test(tecla_final); 
}
function tv_numero(e) {
	document.getElementById(e).onkeypress="return validar_numero(event)";
}
function ts_numero(y) {
	document.getElementById(y).onkeypress="return solo_numero(event)";
}
function numerospunto(e) {
 	tecla = (document.all) ? e.keyCode : e.which;
 	if (tecla==8) return true; 
	patron =/[0-9.]/; 
	tecla_final = String.fromCharCode(tecla);
 	return patron.test(tecla_final); 
}
function showContent() {
      	element = document.getElementById("content2");
        element.style.display='none';		
        element = document.getElementById("content");
        check = document.getElementById("RadioGroup1_4");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
function showContent2() {
      	element = document.getElementById("content");
        element.style.display='none';		
        element = document.getElementById("content2");
        check = document.getElementById("RadioGroup1_5");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
			
function ocultar() {
        element = document.getElementById("content");
            element.style.display='none';
       element = document.getElementById("content2");
            element.style.display='none';			
    }
function cambiaGrupo(chk) {
    var padreDIV=chk;
    while( padreDIV.nodeType==1 && padreDIV.tagName.toUpperCase()!="DIV" )
        padreDIV=padreDIV.parentNode;
    //ahora que padreDIV es el DIV, cogeremos todos sus checkboxes
    var padreDIVinputs=padreDIV.getElementsByTagName("input");
    for(var i=0; i<padreDIVinputs.length; i++) {
        if( padreDIVinputs[i].getAttribute("type")=="checkbox" )
            padreDIVinputs[i].checked = chk.checked;
    }
}
function LenField10(field){ document.getElementById(field).maxLength = 6; }
function LenField3(field){ document.getElementById(field).maxLength = 3; } 
function cleanField(field){ document.getElementById(field).value = ""; }
function marcar(source) {
        checkboxes=document.getElementsByTagName('input');
        for(i=0;i<checkboxes.length;i++) {
            if(checkboxes[i].type == "checkbox") {
				if(checkboxes[i].id == "") {
				checkboxes[i].checked=source.checked;
			}//si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
		}
	}
}
function handleEnter (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	} 
	else
	return true;
} 
function clearDiv() {
	$("#cesta").load("t_vaciarcarrito.php");
	$("#cesta").html("");
	document.getElementById('RadioGroup1_0').checked = "checked";
	activar('num_apuesta','mon_apuesta','anadir','imganadir');
	cambiarOff('termi');
	cambiarOff('segui');
	document.getElementById('todasninguna').checked = false;
	marcar(todasninguna);
	document.getElementById('num_apuesta').value="";
	//document.getElementById('num_apuesta').focus();
}
function cambiacolor_over(celda) { 
	celda.style.backgroundColor="#9FBFD7" 
}  
function cambiacolor_out(celda) {
	celda.style.backgroundColor="#FFFFDD"
} 
function seleccionar_todo(){ 
   for (i=0;i<document.f1.elements.length;i++) 
      if(document.f1.elements[i].type == "checkbox")	
         document.f1.elements[i].checked=1 
} 
function contDiv(idElemento, texto) {
	document.getElementById(idElemento).innerHTML = texto;
}
//------------------------------------------------ FIN LOTERIA -------------------------------------------------------------
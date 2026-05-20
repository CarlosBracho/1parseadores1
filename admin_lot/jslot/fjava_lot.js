//--------------------------------------------------LOTERIA-----------------------------------------------------------------
function java_triter() {
	cambiarOn('numero');
	cambiarOn('monto');
	cambiarOn('cargar');
	cambiarOff('termi');
    cambiarOff('segui');
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_seguidilla").value="";
	document.getElementById('RadioGroup1_0').checked = "checked";
	contDiv('informacion', '- Triple/Terminal -');
	LenField3('num_apuesta');
	foco('num_apuesta');
}
function java_permuta() {
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_seguidilla").value="";
	cambiarOn('numero');
	cambiarOn('monto');
	cambiarOn('cargar');
	cambiarOff('termi'),
    cambiarOff('segui');
	document.getElementById('RadioGroup1_1').checked = "checked";
	LenField10('num_apuesta');
	contDiv('informacion', '- Permuta -');
	foco('num_apuesta');
}
function java_serie() {
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_seguidilla").value="";
	cambiarOff('termi');
	cambiarOff('segui');
	cambiarOn('numero');
	cambiarOn('monto');
	cambiarOn('cargar');
	document.getElementById('RadioGroup1_2').checked = "checked";
	contDiv('informacion', '- Serie - use * como comodin. ej: 4*5');
	LenField3('num_apuesta');
	foco('num_apuesta');
	
}
function java_termiauto() {
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_seguidilla").value="";
	cambiarOn('numero');
	cambiarOn('monto');
	cambiarOn('cargar');
	cambiarOff('termi');
	cambiarOff('segui');
	LenField3('num_apuesta');  
	document.getElementById('RadioGroup1_3').checked = "checked";
	contDiv('informacion', '- Terminal automático -');
	foco('num_apuesta');
}
/////**************************************************************
function java_terminal() {
	document.getElementById("num_apuesta").value="";
	document.getElementById("mon_apuesta").value="";
	document.getElementById("mon_terminales").value="";
	cambiarOff('segui');
	cambiarOff('numero');
	cambiarOff('monto');
	cambiarOff('cargar');
	document.getElementById('RadioGroup1_4').checked = "checked";
	contDiv('informacion', '- Terminales a triples cargados -');
	cambiarOn('termi');
	LenField3('num_apuesta');
	foco('mon_terminales');
}
function java_seguidilla() {
	document.getElementById("mon_terminales").value="";
	document.getElementById("mon_apuesta").value="";
	document.getElementById("num_apuesta").value="";
	document.getElementById("inicio").value="";
	document.getElementById("fin").value="";
	cambiarOff('numero');
	cambiarOff('monto');
	cambiarOff('cargar');
	cambiarOff('termi'); 
	document.getElementById('RadioGroup1_5').checked = "checked";
	contDiv('informacion', '- Seguidillas -');
	cambiarOn('segui');
	LenField3('num_apuesta');
	foco('inicio');
}
function selectTodo(id) { document.getElementById(id).select();}
function cambiarDisplayAni(id, div) {
	if (!document.getElementById) 
		return false;
	fila = document.getElementById(id);
	if (fila.style.display != "none") {
		fila.style.display = "none"; //ocultar
		document.getElementById(div).style.background="#E2E2E2";
		document.getElementById(div).style.color="#000";
	}
	else { 
		fila.style.display = ""; //mostrar
		document.getElementById(div).style.background="#333333";
		document.getElementById(div).style.color="#FFFFFF";
	}
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
function foco(idElemento) { 
	if(typeof(document.getElementById(idElemento)) !== "undefined"){ 
		if (document.getElementById(idElemento).disabled == false) {
			setTimeout(function () { document.getElementById(idElemento).focus();}, 100);
		}
	}
}
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
function LenField10(field){ document.getElementById(field).maxLength = 6; }
function LenField3(field){ document.getElementById(field).maxLength = 3; } 
function cleanField(field){ document.getElementById(field).value = ""; }
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
	$("#cesta").load("t_vaciarcarrito.php"); $("#cesta").html(""); 
	document.getElementById('RadioGroup1_0').checked = "checked";
	//activar('num_apuesta','mon_apuesta','anadir','imganadir'); 
	cambiarOff('termi'); cambiarOff('segui');
	document.getElementById('todasninguna').checked = false; marcar(todasninguna);
	document.getElementById('num_apuesta').value="";
}
function cambiacolor_over(celda) {celda.style.backgroundColor="#9FBFD7"}  
function cambiacolor_out(celda) {celda.style.backgroundColor="#FFFFDD"} 
function seleccionar_todo(){ for (i=0;i<document.f1.elements.length;i++) if(document.f1.elements[i].type == "checkbox")	
document.f1.elements[i].checked=1} 
function contDiv(idElemento, texto) {document.getElementById(idElemento).innerHTML = texto;}
//------------------------------------------------ FIN LOTERIA -------------------------------------------------------------
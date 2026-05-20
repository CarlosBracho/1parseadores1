<link href="../css/menu_dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/menu.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript">
var msg = "Esta función ha sido anulada.";
function RClick(boton){
if (document.layers && boton.which == 3) {
alert(msg); return false; }
if (document.all && event.button == 2 || event.button == 3) {
alert(msg); return false; }
}
document.onmousedown = RClick
	function reportegeneral() { 
	propiedades2="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../admin/reporte_general.php","_blank",propiedades2); 
	}
	function mtp() { 
	propiedades2="width=770,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/mtp_carrera.php","_blank",propiedades2); 
	}
	function mtp_hpi() { 
	propiedades3="width=890,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=no,toolbar=yes";
	window.open("../admin/mtp_carrera_hpi.php","_blank",propiedades3); 
	}
	function mtp_hpi2() { 
	propiedades3="width=890,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/mtp_carrera_hpi2.php","_blank",propiedades3); 
	}
	function mtp_hpi3() { 
	propiedades13="width=890,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/admin_mtp_carrera_hpi2.php","_blank",propiedades13); 
	}
	function mtp_grey() { 
	propiedades13="width=890,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/admin_mtp_carrera_greyhound.php","_blank",propiedades13); 
	}
	function mtp_rbets() { 
	propiedades13="width=890,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	propiedades15="width=890,height=700,menubar=no,maximize=no,resizable=no,left=300,top=300,scrollbars=yes,toolbar=yes";
	window.open("../admin/admin_mtp_carrera_rbets.php","_blank",propiedades13);
	window.open("../admin/retirados_racebets.php","_blank",propiedades15); 	
	}
	function mtp_build() { 
	propiedades13="width=890,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	propiedades15="width=890,height=700,menubar=no,maximize=no,resizable=no,left=300,top=300,scrollbars=yes,toolbar=yes";
	window.open("../admin/admin_mtp_carrera_buildabet2.php","_blank",propiedades13);
	}
	function ret_build() { 
	propiedades13="width=890,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/retirados_BuildaBet2.php","_blank",propiedades13); 
	}
	function mtp_amer() { 
	propiedades2="width=770,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/mtp_carrera_amer.php","_blank",propiedades2); 
	}
	function mtp_WatchandWager() { 
	propiedades2="width=770,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/admin_mtp_carrera_WatchandWager.php","_blank",propiedades2); 
	}
	function ret_tvg() { 
	propiedades2="width=770,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/retirados_tvg.php","_blank",propiedades2); 
	}
	function ret_tvg_rb() { 
	propiedades2="width=770,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/retirados_tvg_rb.php","_blank",propiedades2); 
	}
	function bus_divi() { 
	propiedades2="width=830,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin/busca_dividendos.php","_blank",propiedades2); 
	}
	function abrir_ventana() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/carreras_hoy1.php","_blank",propiedades); 
	} 
	function abrir_ventana1() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/carreras_hoy_hnac.php","_blank",propiedades); 
	} 
function abrir_ventana2() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("http://web1.ameridatos.com:5530/program1.asp","_blank",propiedades); 
	} 
function abrir_ventana3() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../alertasonora.php","_blank",propiedades); 
	} 
	function ultimasjugadas() { 
	propiedades2="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../admin/reporte_ultimasjugadas.php","_blank",propiedades2); 
	}
	 
</script>
<script>
$(document).ready(function(){
   var reId = setInterval(estadoMensaje, 4000);
   $.ajaxSetup({ cache: false });
 });
function estadoMensaje() {
	var rA=Math.random();
	var parametros = { "rA":Math.random() };
		$.ajax({ data:parametros, url:'../includes/admin_nuevoMen.php', type:'get',
		success:function (response) {
			$("#nuevoMen").html(response);
		},
		error: function(){ 
			alertify.error('<font size="4">Verifique su conexión a internet!</font>');
			//setTimeout(loadHora, tiempo);
		}    
	});
}
</script>
<div style="font-size:12px; margin:1px 0px 0px 0px">
<ul class="dropdown dropdown-horizontal" style="font-size:11px">
	
	<li><a target="_blank" href="../parley/dispreportejugadas.php">PARLEY <br/>REPORTE JUGADAS</a></li>
	<li><a target="_blank" href="../parley/registro_logrosad.php">REGISTRO <br/>LOGROS</a></li>
    
    
</ul>

</div>

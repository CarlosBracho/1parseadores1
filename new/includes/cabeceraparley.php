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
	


    <li>
    	<a href="../parley/adpaprobar.php"target="_blank">Ticket Por<br/>Aprobar</a>
    </li>
    <li>
    	<a href="../parley/adpreportejugadas.php"target="_blank">Reporte<br/>Jugadas</a>
    </li>
    <li>
    	<a href="../parley/registro_logros.php"target="_blank">Registro de<br/>Logros</a>
    </li>
    <li>
    	<a href="../guias/enlaces_de_interes.htm"target="_blank">Páginas de<br>interés</a>
    </li>
	
    <?php if ($_SESSION['acceso']=="1") { ?>
	<li><br>
    	<a href="../admin/bancas_lista.php">DISTRIBUIDORES</a>
    </li>
    
	<li>Agentes <br>y Taquillas
		<ul>
			<li><a href="../admin/agencias_listas.php">AGENTES</a></li>
            <li><a href="../admin/taquillas_lista.php">TAQUILLAS</a></li>
		</ul>
	</li>
	<li><br>Usuarios
		<ul>
			<li><a href="../admin/usuarios_ad_lista.php">ADMINISTRADOR</a></li>
			<li><a href="../admin/usuarios_ba_lista.php">DISTRIBUIDOR</a></li>
			<li><a href="../admin/usuarios_ag_lista.php">AGENTE</a></li>
            <li><a href="../admin/usuarios_ve_lista.php">VENDEDOR</a></li>
		</ul>
	</li>
    <?php }?>
	
    <li><br><div class="parpadea" id="nuevoMen" style="height:13px; width:13px; text-align:left; color: #F00; float:left; 
        	display:none">        </div>

	 MENSAJES
		<ul>
			<li><a href="../admin/mensajes_control.php"target="_blank">TAQUILLAS<br> TAQUILLAS<br>TAQUILLAS<br> TAQUILLAS<br><br></a></li>
	                <li><a href="../chat_ad/mensajes_control_ad.php"target="_blank">DISTRIBUIDORES<br> AGENTES<br> DISTRIBUIDORES<br> AGENTES</a></li>
	                <li><a href="../admin/admin_mensajesyalertas.php"target="_blank">MENSAJES<br> Y<br> ALERTAS</a></li>

</ul>    
    </li>
    <li><br/>sistema
   		<ul>
			
            <?php if ($_SESSION['acceso']=="1") { ?>
			<li><a href="javascript:mtp()">MTP BASIC TVG</a></li>
            <li><a href="javascript:ret_tvg()">RETÍROS BASIC TVG</a></li>
			<li><a href="javascript:mtp_amer()">MTP AMERICANA</a></li>
            <li><a href="javascript:ret_tvg_rb()">RETÍROS <br/>RACEBETS - BASIC TVG</a></li>
            <li><a href="javascript:bus_divi()">DIVIDENDOS AUTO</a></li>
            <li><a href="javascript:mtp_WatchandWager()">MTP WATCHANDWAGER</a></li>
            <li><a href="javascript:mtp_grey()">MTP GREYHOUND CHANNEL</a></li>
            <li><a href="javascript:mtp_build()">MTP BUILDABET2</a></li>
            <li><a href="javascript:ret_build()">RETÍROS BUILDABET2</a></li>
            <li><a href="../admin/admin_bitacora_lista.php">BITÁCORA</a></li>
            <?php }?>
		</ul>

    </li>
</ul>

</div>

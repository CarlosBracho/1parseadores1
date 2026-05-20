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
	function chat() { 
	propiedades2="width=900,height=800,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../admin/mensajes_control.php",propiedades2); 
	}
	function chat_ad() { 
	propiedades2="width=900,height=800,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../chat_ad/mensajes_control_ad.php",propiedades2); 
	}
	function bus_divi_hnac() { 
	pro1="width=830,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin_hnac/busca_dividendos_hnac.php","_blank",pro1); 
	}
	function ret_maquinaazul() { 
	pro2="width=530,height=700,menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=yes,toolbar=yes";
	window.open("../admin_hnac/retirados_maqazul_hnac.php","_blank",pro2); 
	}
	function abrir_ventana() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/carreras_hoy1.php","_blank",propiedades); 
	} 
	function abrir_ventana1() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/carreras_hoy_hnac2.php","_blank",propiedades); 
	} 
function abrir_ventana2() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("http://web1.ameridatos.com:6850/program1.asp","_blank",propiedades); 
	} 
function abrir_ventana3() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../alertasonora.php","_blank",propiedades); 
	} 
	function chat_hnac() { 
	pro4="width=900,height=800,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../admin_hnac/mensajes_control_hnac.php","_blank",pro4); 
	}
	function busTicket() { 
	propiedades11="width=500,height=680,Aresizable=no,location=no,menubar=no,scrollbars=yes,status=yes,toolbar=yes,fullscreen=no,dependent=yes";
	window.open("../admin/buscar_ticket.php",propiedades11);
	}
	function busTicket_hnac() { 
	pro5="width=500,height=680,Aresizable=no,location=no,menubar=no,scrollbars=yes,status=yes,toolbar=yes,fullscreen=no,dependent=yes";
	window.open("../admin_hnac/buscar_ticket_hnac.php",pro5); 
	}
	function ultimasjugadas_hnac() { 
	pro6="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../admin_hnac/admin_reporte_ultimasjugadas_hnac.php","_blank",pro6); 
	}
	function jugadas_hnac() { 
	pro7="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../admin_hnac/admin_reporte_jugadas_hnac.php","_blank",pro7); 
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
<div style="font-size:12px; margin:1px 0px 0px 0px;">
<ul class="dropdown dropdown-horizontal" style="font-size:11px;">
	<li>
    	 <a href="../admin_hnac/admin_apertura_lista_hnac.php"> Apertura <br>y Cierre </a>
    </li>
	<li>Resultados<br/>y retiros
		<ul>
            <li><a href="../admin_hnac/admin_dividendos_lista_hnac.php">RESULTADOS</a></li>
            <li><a href="../admin_hnac/admin_historial_lista_hnac.php">HISTORIAL</a></li>
            <li><a href="../admin_hnac/caballos_lista_hnac.php">RETIROS</a></li>
            <li><a href="../admin_hnac/admin_preciofijo.php">PRECIO FIJO</a></li>

		</ul>
    </li>
	<li>CARRERAS<br/> PROGRAMADAS
		<ul>
			<li><a href="javascript:abrir_ventana()")>Programadas<br>Internacionales</a></li>
			<li><a href="javascript:abrir_ventana1()")>Programadas<br>Nacionales</a></li>
			<li><a href="javascript:abrir_ventana2()")>Carreras<br>Ameridaros</li>
			<li><a href="javascript:abrir_ventana3()")>Alerta<br>Sonora</li>
		</ul>    </li>
	<li> BUSCAR<br/> TICKETS
		<ul>
			<li><a href="javascript:busTicket()">INTERNACIONALES<br/> INTERNACIONALES<br/> INTERNACIONALES<br/><br/> </a></li>
	                <li><a href="javascript:busTicket_hnac()"><br/>NACIONALES<br/> NACIONALES<br/> NACIONALES</a></li>

</ul>    
    </li>
    <li>
    	<a href="../guias/enlaces_de_interes.htm"target="_blank">Páginas de<br>interés</a>
    </li>
	<li><br>Reportes
		<ul>
			<li><a href="javascript:ultimasjugadas_hnac()">ÚLTIMAS JUGADAS</a></li>
			<li><a href="javascript:jugadas_hnac()">JUGADAS</a></li>
            <li><a href="../admin_hnac/admin_reporte_cobranza_hnac.php">COBRANZA</a></li>
            <li><a href="../admin_hnac/apuestas_pendientes.php">APUESTAS PENDIENTES</a></li>
            <li><a href="../guias_hnac/enlaces_de_interes.htm"target="_blank">PÁGINAS DE INTERÉS</a></li>
		</ul>
	</li>
	<li>
    	<a href="../admin_hnac/admin_hipodromos_listas_hnac.php"><br/>Hipódromos</a>
    </li>
	<li>
    	<a href="../admin_hnac/ejemplares_listas.php"><br/>EJEMPLARES</a>
    </li>

    <li><br><div class="parpadea" id="nuevoMen" style="height:13px; width:13px; text-align:left; color: #F00; float:left; 
        	display:none">        </div>

	 MENSAJES
		<ul>
			<li><a href="javascript:chat()">TAQUILLAS<br> TAQUILLAS<br>TAQUILLAS<br> TAQUILLAS<br><br></a></li>
	                <li><a href="javascript:chat_ad()">DISTRIBUIDORES<br> AGENTES<br> DISTRIBUIDORES<br> AGENTES</a></li>
	                <li><a href="../admin/admin_mensajesyalertas.php"target="_blank">MENSAJES<br> Y<br> ALERTAS</a></li>
</ul>        
    </li>
    <li><br/>sistema
   		<ul>
			<li><a href="javascript:chat_hnac()">MENSAJES</a></li>
            <?php if ($_SESSION['acceso']=="1") { ?>
            <li><a href="javascript:bus_divi_hnac()">DIVIDENDOS NACIONAL</a></li>
            <li><a href="javascript:mtp_hpi2()">MTP HORSEPLAYER 2</a></li>
			<li><a href="javascript:mtp()">MTP BASIC TVG</a></li>
            <li><a href="javascript:ret_maquinaazul()">RETÍROS MAQUINA AZUL</a></li>
			<li><a href="javascript:mtp_amer()">MTP AMERICANA</a></li>
            <li><a href="javascript:ret_tvg_rb()">RETÍROS <br/>RACEBETS - BASIC TVG</a></li>
            <li><a href="javascript:bus_divi()">DIVIDENDOS AUTO</a></li>
            <li><a href="javascript:mtp_hpi3()">MTP HORSEPLAYER 3</a></li>
            <li><a href="javascript:mtp_rbets()">MTP RACEBETS</a></li>
            <li><a href="javascript:ret_rbets()">RETÍROS RACEBETS</a></li>
            <li><a href="../admin/admin_bitacora_lista.php">BITÁCORA</a></li>
            <li><a href="../admin/administrativo.php">ADMINISTRATIVO</a></li>
            <?php }?>
		</ul>

    </li>
</ul>

</div>

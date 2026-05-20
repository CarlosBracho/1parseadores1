<link href="../css/menu_dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/menu.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript"> 
	function reimprimir() { 
	propiedades="width=800,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventasmie/ventas_reimprimir.php","_blank",propiedades); 
	}
	function reimprimeult() { 
	propiedades="width=200,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes";
	window.open("../ventasmie/ventas_reimprimir_ultimo.php","_blank",propiedades); 
	} 
	function carreras_hoy() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/carreras_hoy.php","_blank",propiedades); 
	} 
	function dividendos() { 
	propiedades2="width=820,height=700,menubar=no,maximize=no,resizable=no,left=20,fullscreen=no,top=20,scrollbars=yes,toolbar=yes";
	window.open("../ventas/ventas_historial_lista.php","_blank",propiedades2); 
	} 
	function winners() { 
	window.open("../gacetas/index.php","_blank"); 
	} 
	function gacetas() { 
	window.open("http://www.tuhipismo.net/simulcast/","_blank"); 
	} 
 
	function reportejugada() { 
	propiedades4="fullscreen=yes,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("ventas_reporte_jugadas.php","_blank"); 
	} 
	function mensajes() { 
	propiedades="width=820,height=465,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventasmie/chat_ventasmie.php","_blank",propiedades); 
	} 
function guias() { 
	propiedades="width=820,height=520,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../guias/listaguiaventasmie.html","_blank",propiedades); 
	} 
	function cambio() 
	{ 
	pro1="width=440,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,";
	pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
	window.open("../ventas/ventas_cambiar_clave_usuario.php","_blank",pro1+pro2); 
	} 
function cambioticket() 
	{ 
	pro4="width=340,height=380,Aresizable=no,location=no,menubar=no,scrollbars=no,";
	pro5="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
	window.open("../ventasmie/ventas_configurar_ticket.php","_blank",pro4+pro5); 
	} 
function veropciones() 
	{ 
pro1="width=980,height=520,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../ventas/ventas_ver_opciones_ame.php","_blank",pro1+pro2); 
} 
</script>
<STYLE TYPE="text/css">
a:link { color: #FFF; text-decoration: none }
a:visited { color: #FFF; text-decoration: none }
a:hover { color: #FFF; text-decoration: none; }
</STYLE>
<div id="menu" style="width:100%; font-size:12px">
    <div style="width:7%; float:left">
        <a href="javascript:reimprimir()">Reimprimir<br/>ticket</a>
    </div>
    <div style="width:8%; float:left">
        <a href="javascript:reimprimeult()">Reimprimir<br/>último ticket</a>
    </div>
    <div style="width:8%; float:left">
        <a href="javascript:carreras_hoy()">Carreras<br/>programadas</a>
    </div>
    <div style="width:8%; float:left">
        <a href="javascript:dividendos()">Dividendos<br/>y retirados</a>
    </div>
    <div style="width:5%; float:left">
        <a href="javascript:winners()">Gacetas<br/>y winner</a>
    </div>
    <div style="width:8%; float:left">
        <a href="javascript:cuadre()">Cuadre de<br/>americanas</a>
    </div>
    <div style="width:7%; float:left">
        <a href="javascript:reportejugada()">Reporte<br/> de jugadas</a>
    </div>
    <div style="width:6%; float:left">
        <a href="javascript:mensajes()"><br/>Mensajes</a>
    </div>
	<div style="width:3%; float:left">
        <a href="javascript:guias()"><br/>Guias</a>
    </div>
    <div style="width:6%; float:left">
        <a href="javascript:cambio()" title=" cambio de clave de acceso ">Cambiar <br/>clave</a>
    </div>
	<div style="width:6%; float:left">
        <a href="javascript:cambioticket()" title=" configura tickets ">Configurar ticket</a>
    </div>
    <div style="width:8%; float:left">
        <a href="javascript:veropciones()" title=" ver opciones activas e inactivas de taquilla ">Ver <br/>configuracion</a>
    </div>
    <div style="width:6%; float:left">
        <a style="color:#FFF" href="../acceso.php" title=" volver a seleccion ">Volver a<br/>seleccion</a>
    </div>
    <div style="width:4%; float:left">
        <a style="color:#FFF" href="../ventas/cerrar_sesion_vendedor.php"><br/>Salir</a>
    </div>
	<?php if ($dist_vende_hnacx==1 && $agen_vende_hnacx==1 && $taq_vende_hnacx==1) { ?>
    <div style="width:8%; height:34px; float: right; background:#0E5157; border:1px solid  #333; font-size:12px;
    	margin:-17px 0px 0px 0px">
        <a style="color:#FFF" href="../ventashnac_mie/index.php" title="ir a CARRERAS NACIONALES">
        ir a carreras<br/>nacionales
        </a>
    </div>
	<?php }?>
	
	<div class="parpadea" id="nuevoMen" style="height:13px; width:13px; text-align:left; color: #F00; float:left; 
        	display:none">        </div>
</div>
	<?php if ($dist_vende_amex==0 or $agen_vende_amex==0 or $taq_vende_amex==0) { ?>
<script type="text/javascript">
window.location="../acceso.php";
</script>
			<?php } ?>
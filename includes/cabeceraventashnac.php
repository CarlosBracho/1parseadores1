<script language="javascript"> 
	function reimprimir() { 
	propiedades="width=800,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/ventas_reimprimir_hnac.php","_blank",propiedades); 
	}
	function reimprimeult() { 
	propiedades="width=230,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/ventas_reimprimir_ultimo_hnac.php","_blank",propiedades); 
	} 
	function dividendos() { 
	propiedades2="width=420,height=800,menubar=no,maximize=no,resizable=no,left=20,fullscreen=no,top=20,scrollbars=yes,toolbar=yes";
	window.open("../ventashnac_mie/incluir_modificar_dividendos_hnac.php","_blank",propiedades2); 
	} 
	function winners() { 
	window.open("../gacetas/index.php","_blank"); 
	} 
	function premio(){ 
	pr10="width=375,height=760,left=0,top=0,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/ventas_tickets_premiados.php","_blank",pr10); 
	} 	
	function gacetas() { 
	window.open("http://www.tuhipismo.net/simulcast/","_blank"); 
	} 
	function cuadre(){ 
	propiedades9="width=500,height=560,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/ventas_reporte_cuadre_hnac.php","_blank"); 
	} 
	function reportejugada() { 
	propiedades4="fullscreen=yes,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../ventashnac_mie/ventas_reporte_jugadas_hnac.php","_blank"); 
	} 
	function mensajes() { 
	pro4="width=820,height=465,Aresizable=no,location=no,menubar=no,left=20,top=20,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/chat_ventasmie_hnac.php","_blank",pro4); 
	} 
	function cambio() 
	{ 
	pro1="width=440,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,";
	pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
	window.open("../ventas/ventas_cambiar_clave_usuario.php","_blank",pro1+pro2); 
	} 
	function car_programadas() { 
	pro3="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/carreras_hoy_hnac.php","_blank",pro3); 
	}
	function cambioticket() 
	{ 
	pro4="width=340,height=380,Aresizable=no,location=no,menubar=no,scrollbars=no,";
	pro5="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
	window.open("../ventashnac_mie/ventas_configurar_ticket.php","_blank",pro4+pro5); 
	} 
	function veropciones() 
		{ 
	pro1="width=980,height=620,Aresizable=yes,location=no,menubar=no,scrollbars=yes,";
	pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
	window.open("../ventashnac_mie/ventas_ver_opciones_nac.php","_blank",pro1+pro2); 
	} 
</script>

<STYLE TYPE="text/css">
a:link { color: #FFF; text-decoration: none }
a:visited { color: #FFF; text-decoration: none }
a:hover { color: #FFF; text-decoration: none; }
</STYLE>
<div id="menu" style="width:100%; font-size:12px">
    <div style="width:6.5%; float:left">
        <a href="javascript:reimprimir()" title=" ir a lista de tickets ">Reimprimir<br/>ticket</a>
    </div>
    <div style="width:7.5%; float:left">
        <a href="javascript:reimprimeult()" title=" reimprime último ticket vendido">Reimprimir<br/>último ticket</a>
    </div>
    <div style="width:8.5%; float:left">
        <a href="javascript:car_programadas()" title=" ver carreras programadas ">Carreras<br/>programadas</a>
    </div>
    
    <div style="width:6.5%; float:left">
        <a href="javascript:dividendos()" title=" Dividendos y retirados ">Dividendos<br/>y retirados</a>
    </div>
    <div style="width:6%; float:left">
        <a href="javascript:premio()" title=" ver/imprimir ticktes premiados ">Tickets<br/>Premiados</a>
    </div>
    <div style="width:5%; float:left">
        <a href="javascript:winners()" title=" ver gacetas "><br/>Gacetas</a>
    </div>
    <div style="width:5.5%; float:left">
       <a href="javascript:gacetas()" title=" ver Guía de ventas carreras nacionales ">Guia de <br/>ventas</a>
    </div>
    
    <div style="width:6.5%; float:left">
        <a href="javascript:cuadre()" title=" ver Cuadre de ventas nacionales ">Cuadre de<br/>nacionales</a>
    </div>
    <div style="width:6.5%; float:left">
        <a href="javascript:reportejugada()" title=" ver reporte de jugadas ">Reporte<br/> de jugadas</a>
    </div>
    <div style="width:6%; float:left">
        <a href="javascript:mensajes()" title=" enviar/ver mensaje "><br/>Mensajes</a>
    </div>
    <div style="width:5%; float:left">
        <a href="javascript:cambio()" title=" cambio de clave de acceso ">Cambiar <br/>clave</a>
    </div>
    <div style="width:6.5%; float:left">
        <a href="javascript:cambioticket()" title=" configura tickets ">Configurar <br/>ticket</a>
    </div>
    <div style="width:6%; float:left">
        <a href="javascript:veropciones()" title=" ver opciones activas e inactivas de taquilla ">Ver <br/>opciones</a>
    </div>
    <div style="width:6.5%; float:left">
        <a style="color:#FFF" href="../acceso.php" title=" volver a seleccion ">Volver a<br/>seleccion</a>
    </div>
    <div style="width:3%; float:left">
        <a style="color:#FFF" href="../ventas/cerrar_sesion_vendedor.php" title=" salir del sistema "><br/>Salir</a>
    </div>
	<?php if ($dist_vende_amex==1 && $agen_vende_amex==1 && $taq_vende_amex==1) { ?>
    <?php if ($est_ame==1) {?>
    <div style="width:8%; height:40px; float: right; background:#0072C6; border:1px solid  #333; font-size:12px; 
    	margin:-17px 0px 0px 0px">
        <a style="color:#FFF" href="../ventasmie/index.php" title="ir a CARRERAS AMERICANAS">ir a carreras<br/>americanas light</a>
    </div> <br><br><br>
	<div style="width:8%; height:40px; float: right; background:#0072C6; border:1px solid  #333; font-size:12px; 
    	margin:-17px 0px 0px 0px">
        <a style="color:#FFF" href="../ventas/index.php" title="ir a CARRERAS AMERICANAS">ir a carreras<br/>americanas full</a>
    </div>
    <?php }?>
	<?php }?>
</div>
	<?php if ($dist_vende_hnacx==0 or $agen_vende_hnacx==0 or $taq_vende_hnacx==0) { ?>
<script type="text/javascript">
window.location="../acceso.php";
</script>
			<?php } ?>

<br><br><br>
	<?php if ($dist_vende_parley==1 && $agen_vende_parley==1 && $taq_vende_parley==1) { ?>


	<div style="width:8%; height:25px; float: right; background:#0072C6; border:1px solid  #333; font-size:12px; 
    margin:-17px 0px 0px 0px">
    <a style="color:#FFF" href="../new/parley/1taparley.php" title="Ir a PARLEY">Ir a <br/>PARLEY</a>
    </div>

	<?php }?>

	<?php if ($dist_vende_parley==0 && $agen_vende_parley==0 && $taq_vende_parley==0) { ?>
	
		<script type="text/javascript">
window.location="../acceso.php";
</script>
			<?php } ?>


<script language="javascript"> 
	function abrir_ventana() 
	{ 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/carreras_hoy.php","_blank",propiedades); 
	} 
	function reimprimir() 
	{ 
	propiedades="width=800,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_reimprimir.php","_blank",propiedades); 
	}
	
	function dividendos() 
	{ 
	propiedades2="width=820,height=700,menubar=no,maximize=no,resizable=no,left=20,fullscreen=no,top=20,scrollbars=yes,toolbar=yes";
	window.open("../ventas/ventas_historial_lista.php","_blank",propiedades2); 
	} 
	
	function balance() 
	{ 
	propiedades="width=750,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_reportes_detallado.php","_blank",propiedades); 
	}    
	
	function ventas() 
	{ 
	propiedades="width=550,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_ventas_premios.php","_blank",propiedades); 
	}   
	
	function taquilla() 
	{ 
	propiedades="width=550,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("ventas_ventas_premios_taquilla.php","_blank",propiedades); 
	}   
	
	function reportejugada() 
	{ 
	propiedades4="fullscreen=yes,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../ventas/ventas_reporte_jugadas.php","_blank",propiedades4); 
	} 
	
	function pagar() 
	{ 
	propiedades8="width=640,height=580,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_pagar_apuesta.php","_blank",propiedades8); 
	} 
	
	function eliminar(){ 
	propiedades9="width=400,height=380,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_eliminar_ticket.php","_blank",propiedades9); 
	} 
	function cuadre(){ 
	propiedades9="width=495,height=640,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_reporte_cuadre_americana.php","_blank"); 
	} 
	function gacetas() 
	{ 
	window.open("http://www.tuhipismo.com/simulcast/","_blank"); 
	} 
	
	function winners() 
	{ 
	window.open("../gacetas/index.php","_blank");
	} 
	function reimprimeult() 
	{ 
	propiedades="width=200,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_reimprimir_ultimo.php","_blank",propiedades); 
	}  
function veropciones() 
	{ 
pro1="width=980,height=520,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../ventas/ventas_ver_opciones_ame.php","_blank",pro1+pro2); 
} 
</script>
<script language="javascript">
var msg = "Esta función ha sido anulada.";
function RClick(boton){
if (document.layers && boton.which == 3) {
alert(msg); return false; }
if (document.all && event.button == 2 || event.button == 3) {
alert(msg); return false; }
}
document.onmousedown = RClick
</script>
<link href="../css/menu_dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/menu.css" media="screen" rel="stylesheet" type="text/css" />
</br></br></br></br></br></br></br>
<div style="background: #939; font-size:12px; margin:-15px 0px 0px 0px"">
  <ul class="dropdown dropdown-horizontal">
	<li>
    	 <a href="javascript:reimprimir()">Reimprimir<br/>ticket111</a>
    </li>
	<li>
    	<a href="javascript:reimprimeult()">Reimprimir<br/>último ticket</a>
    </li>
	<li>
    	<a href="javascript:abrir_ventana()">Carreras<br/>programadas</a>
    </li>
	<li>
    	<a href="javascript:dividendos()">Dividendos<br/>y retirados</a>
    </li>

	<li>
    	<a href="javascript:winners()">Gacetas<br/>y winner</a>
    </li>
	<li>
    	<a href="javascript:gacetas()">Guia de ventas<br/>en americanas</a>
    </li>
	<li>
    	 <a href="javascript:cuadre()">Cuadre de<br/>americanas</a>
    </li>
	<li>
    	<a href="javascript:eliminar()">Eliminar<br/>ticket</a>
    </li>
	<li>
    	<a href="javascript:reportejugada()">Reporte<br/> de jugadas</a>
    </li>
	<li>
	    <a href="javascript:void(0)" onclick="javascript:chatWith('Soporte')"><br/>Mensajes</a>
    </li>
	<li>
        <a href="javascript:veropciones()" title=" ver opciones activas e inactivas de taquilla ">Ver <br/>configuracion</a>
    </li>
  </ul>
</div>

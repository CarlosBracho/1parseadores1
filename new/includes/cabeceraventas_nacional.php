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
	propiedades9="width=400,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_reporte_cuadre_americana.php","_blank",propiedades9); 
	} 
	function gacetas() 
	{ 
	window.open("http://www.tuhipismo.com/simulcast/","_blank"); 
	} 
	
	function winners() 
	{ 
	window.open("http://controlsport.com.ve/upload/libs/listar.php","_blank"); 
	} 
	function reimprimeult() 
	{ 
	propiedades="width=200,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes";
	window.open("../ventas/ventas_reimprimir_ultimo.php","_blank",propiedades); 
	}  
</script>

<link href="../css/menu_dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/menu.css" media="screen" rel="stylesheet" type="text/css" />
<div style="background: #939; font-size:12px; margin:-15px 0px 0px 0px">
  <ul class="dropdown dropdown-horizontal" >
	<li style="background:#0072C6">
    	 <a href="javascript:reimprimir()">Reimprimir<br/>ticket</a>
    </li>
	<li style="background:#0072C6">
    	<a href="javascript:reimprimeult()">Reimprimir<br/>último ticket</a>
    </li>
	<li style="background:#0072C6">
    	<a href="javascript:abrir_ventana()">Carreras<br/>programadas</a>
    </li>
	<li style="background:#0072C6">
    	<a href="javascript:dividendos()">Dividendos<br/>y retirados</a>
    </li>

	<li style="background:#0072C6">
    	<a href="javascript:winners()">Gacetas<br/>y winner</a>
    </li>
	<li style="background:#0072C6">
    	 <a href="javascript:cuadre()">Cuadre de<br/>nacionales</a>
    </li>
	<li style="background:#0072C6">
    	<a href="javascript:eliminar()">Eliminar<br/>ticket</a>
    </li>
	<li style="background:#0072C6">
    	<a href="javascript:reportejugada()">Reporte<br/> de jugadas</a>
    </li>
  </ul>
</div>

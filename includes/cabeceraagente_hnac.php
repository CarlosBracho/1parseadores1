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
	function carrerasProgramadas() { 
	pr="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventashnac_mie/carreras_hoy_hnac.php","_blank",pr); 
	}
	function jugadas() { 
	propiedades2="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../agente_hnac/agente_reporte_jugadas_hnac.php","_blank",propiedades2); 
	}
	function cuadrecaja() { 
	propiedades2="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../agente_hnac/reporte_cuadre_hnac.php","_blank",propiedades2); 
	}
</script>
<div style="font-size:12px; margin:1px 0px 0px 0px">
<ul class="dropdown dropdown-horizontal" style="font-size:11px">
	<li>
    	 <a href="../agente/agente_reporte_general_total.php">Reporte <br/>Global</a>
    </li>
	<li>
    	 <a href="../agente_hnac/agente_reporte_carrera_carrera_hnac.php">Reporte carrera<br/>a carrera</a>
    </li>
	<li>
    	<a href="javascript:cuadrecaja()">Cuadre de<br/>Caja</a>
    </li>
	<li>
    	 <a href="../agente_hnac/agente_preciofijo.php">Precio<br/>Fijo</a>
    </li>
	<li>
    	<a href="javascript:jugadas()">Reporte de jugadas<br/>Nacionales</a>
    </li>
	<li>
    	<a href="javascript:carrerasProgramadas()">Carreras Programadas<br/>Nacionales</a>
    </li>
	<li>
    	<a href="../agente/index.php">chat<br/> soporte</a>
    </li>
</ul>
</div>
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
	window.open("../ventas/carreras_hoy.php","_blank",pr); 
	}
	function jugadas() { 
	propiedades2="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../agente/agente_reporte_jugadas.php","_blank",propiedades2); 
	}
	function busTicket() { 
	propiedades11="width=500,height=680,Aresizable=no,location=no,menubar=no,scrollbars=yes,status=yes,toolbar=yes,fullscreen=no,dependent=yes";
	window.open("../agente/buscar_ticket.php","_blank",propiedades11); 
	}

</script>
<div style="font-size:12px; margin:1px 0px 0px 0px">
<ul class="dropdown dropdown-horizontal" style="font-size:11px">
	<li>
    	 <a href="../agente/agente_reporte_general_total.php">Reporte <br/>global</a>
    </li>
	<li>
    	 <a href="../agente/agente_reporte_vendedores.php">Reporte detallado<br/>Internacionales</a>
    </li>
	<li>
    	<a href="../agente/agente_reporte_carrera_carrera.php">Reporte <br/>carrera a carrera</a>
    </li>
	<li>
    	<a href="javascript:jugadas()">Reporte de jugadas<br/>Internacionales</a>
    </li>
	<li>
    	<a href="javascript:carrerasProgramadas()">Carreras Programadas<br/>Internacionales</a>
    </li>
	<li>
    	<a href="javascript:busTicket()">Buscar<br/>Ticket</a>
    </li>
	<li>
    	<a href="../agente/taquillas_lista.php"><br/>Taquillas</a>
    </li>
		<li>
    	<a href="../agente/agente_mensajesyalertas.php">mensaje<br/>a taquillas</a>
    </li>
	<li>
    	<a href="../agente/index.php">chat<br/> soporte</a>
    </li>
</ul>
</div>
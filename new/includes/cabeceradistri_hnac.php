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
	window.open("../distri_hnac/distri_reporte_jugadas_hnac.php","_blank",propiedades2); 
	}
</script>
<div style="font-size:12px; margin:1px 0px 0px 0px">
<ul class="dropdown dropdown-horizontal" style="font-size:12px">
	<li>
    	 <a href="../distri/distri_reporte_general_total.php">Reporte<br/>global</a>
    </li>
	<li>
    	 <a href="../distri_hnac/distri_control_venta_carrera.php">Reporte carrera a carrera<br/>Carreras Nacionales</a>
    </li>
	<li>
    	<a href="javascript:jugadas()">Reporte de jugadas<br/>Nacionales</a>
    </li>
	<li>
    	<a href="javascript:carrerasProgramadas()">Carreras Programadas<br/>Nacionales</a>
    </li>
	<li>
    	<a href="../distri/agencias_listas.php"><br/>Agentes</a>
    </li>
	<li>
    	<a href="../distri/taquillas_lista.php"><br/>Taquillas</a>
    </li>

    	<li>
    	<a href="../distri/index.php">chat<br/> soporte</a>
    </li>
</ul>
</div>
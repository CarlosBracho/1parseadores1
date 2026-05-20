<link href="../css/menu_dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/menu.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript"> 
	function abrir_ventana() { 
	propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../ventas/carreras_hoy.php","_blank",propiedades); 
	} 
	function reportegeneral() { 
	propiedades2="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../aperturacierre/reporte_general.php","_blank",propiedades2); 
	} 
	
	var msg = "Esta función ha sido anulada.";
	function RClick(boton){
	if (document.layers && boton.which == 3) {
	alert(msg); return false; }
	if (document.all && event.button == 2 || event.button == 3) {
	alert(msg); return false; }
	}
	document.onmousedown = RClick
</script>
<div style="font-size:12px; margin:1px 0px 0px 0px">
<ul class="dropdown dropdown-horizontal">
	<li>
    	 <a href="../aperturacierre/apertura_lista.php">Apertura y Cierre</a>
    </li>
	<li>
    	<a href="../aperturacierre/apertura_add2.php">Apertura múltiple</a>
    </li>
	<li>
    	<a href="../aperturacierre/dividendos_lista.php">Dividendos</a>
    </li>
	<li>
    	<a href="../aperturacierre/caballos_lista.php">Retiros</a>
    </li>
	<li>
    	<a href="../aperturacierre/historial_lista.php">Historial</a>
    </li>
	<li>
    	<a href="javascript:abrir_ventana()">Programadas</a>
    </li>
	<li>
    	<a href="javascript:reportegeneral()">Reporte</a>
    </li>
	<li>
    	<a href="../aperturacierre/apertura_cierre_apuestas_pendientes.php">Apuestas pendientes</a>
    </li>
	<li>
    	<a href="../aperturacierre/apertura_cierre_mensaje_edit.php">Mensajes1</a>
    </li>
</ul>
</div>
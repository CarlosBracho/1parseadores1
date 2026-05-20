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
	function jugadas() { 
	propiedades2="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
	window.open("../agente_lot/agente_reporte_ultimasjugadas_lot.php","_blank",propiedades2); 
	}
	function busTicket() { 
	propiedades11="width=500,height=680,Aresizable=no,location=no,menubar=no,scrollbars=yes,status=yes,toolbar=yes,fullscreen=no,dependent=yes";
	window.open("../agente_lot/agente_buscar_ticket_lot.php","_blank",propiedades11); 
	}
	
</script>
<div style="font-size:12px; margin:1px 0px 0px 0px">
<ul class="dropdown dropdown-horizontal" style="font-size:11px">
	<li>
    	<a href="../agente_lot/agente_resultados_trte_lot.php">RESULTADOS<br/>DE SORTEOS</a>
    </li>
	<li>
		<a href="javascript:jugadas()"><br/>ULTIMAS JUGADAS</a>
	</li>
	<li>
		<a href="../agente_lot/agente_reporte_general_lot.php">REPORTE<br/>LOTERIAS ANIMALITOS</a>
	</li>
	<li>
		<a href="../agente_lot/agente_resumen_ventas_xloterias_lot.php">REPORTE DE VENTAS<br/>POR SORTEOS</a>
	</li>
	<li>
    	<a href="javascript:busTicket()">Buscar<br/>Ticket</a>
    </li>
	<li>
    	<a href="../agente_lot/agente_edit_lot.php"><br/>Loterias</a>
    </li>
	<li>
    	<a href="../agente_lot/agente_taquillas_lista_lot.php"><br/>Taquillas</a>
    </li>
	<li><br>Usuarios
		<ul>
			<li><a href="../agente_lot/agente_usuario_age_edit_lot.php">
                  	<span>CAMBIAR CLAVE</span>
				</a>
			</li>
            <li><a href="../agente_lot/agente_usuarios_ven_lista_lot.php">VENDEDOR</a></li>
		</ul>
	</li>
</ul>
</div>
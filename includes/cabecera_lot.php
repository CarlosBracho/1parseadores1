<link href="../css/menu_dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/menu.css" media="screen" rel="stylesheet" type="text/css" />
<script>s
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
function busTicket_hnac() { 
pro5="width=500,height=680,Aresizable=no,location=no,menubar=no,scrollbars=yes,status=yes,toolbar=yes,fullscreen=no,dependent=yes";
window.open("../admin_lot/admin_buscar_ticket_lot.php","_blank",pro5);}
function ultimasjugadas_lot() { 
pro6="width=900,height=700,menubar=no,maximize=yes,resizable=yes,left=20,top=20,scrollbars=yes,toolbar=yes";
window.open("../admin_lot/admin_reporte_ultimasjugadas_lot.php","_blank",pro6); 
}
</script>

<div style="font-size:12px; margin:1px 0px 0px 0px;">
<ul class="dropdown dropdown-horizontal" style="font-size:11px;">
	<li>
    	<a href="../admin_lot/index.php">Control<br>Loteria</a>
    </li>
	<li>Resultados<br/>y bloqueos
		<ul>
            <li><a href="../admin_lot/admin_resultados_trte_lot.php">RESULTADOS DE SORTEOS</a></li>
            <li><a href="../admin_lot/admin_devolucion_lot.php">DEVOLVER JUGADAS</a></li>
            <li><a href="../admin_lot/admin_bloqueos_lista_lot.php">BOQUEOS Y TOPES A NUMEROS</a></li>
		</ul>
    </li>
	<li>
    	<a href="javascript:busTicket_hnac()">Buscar<br/>Ticket</a>
    </li>
	<li><br>Reportes
		<ul>
			<li><a href="../admin_lot/admin_resumen_ventas_xloterias_lot.php">RESUMEN VENTAS POR SORTEOS</a></li>
			<li><a href="javascript:ultimasjugadas_lot()">ÚLTIMAS JUGADAS</a></li>
            <li><a href="../admin_lot/admin_reporte_cobranza_lot.php">COBRANZA LOTERIAS ANIMALITOS</a></li>
		</ul>
	</li>
    <?php if ($_SESSION['acceso']=="1") { ?>
	<li>DISTRIBUIDORES <br>y MULTIDISTRIBUIDORES
		<ul>
			<li><a href="../admin/bancas_lista.php">DISTRIBUIDORES</a></li>
            <li><a href="../admin/multidistri_lista.php">MULTI<br>DISTRIBUIDORES</a></li>
		</ul>
	</li>
	<li>
    	<a href="../admin_lot/admin_agente_lista_lot.php"><br>Agentes</a>
    </li>
	<li>
    	<a href="../admin_lot/admin_taquillas_lista_lot.php"><br>Taquillas</a>
    </li>
	<li><br>Usuarios
		<ul>
			<li><a href="../admin_lot/admin_usuarios_dis_lista_lot.php">DISTRIBUIDOR</a></li>
			<li><a href="../admin_lot/admin_usuarios_age_lista_lot.php">AGENTE</a></li>
            <li><a href="../admin_lot/admin_usuarios_ven_lista_lot.php">VENDEDOR</a></li>
		</ul>
	</li>
	<li><br>LOTERIAS
		<ul>
			<li><a href="../admin_lot/admin_grupos_lista_lot.php">GRUPOS</a></li>
			<li><a href="../admin_lot/admin_sorteos_lista_lot.php">SORTEOS</a></li>
			<li><a href="../admin_lot/admin_loterias_lista_lot.php">LOTERIAS</a></li>
		</ul>
	</li>
    <?php }?>
    <li><br>
		<div class="parpadea" id="nuevoMen" style="height:13px; width:13px; text-align:left; color: #F00; float:left; 
        	display:none"></div>
	
        <a href="javascript:chat()"> MENSAJES</a>
    </li>
    <li><br/>sistema
   		<ul>
			<li><a href="javascript:chat_hnac()">MENSAJES</a></li>
		</ul>

    </li>
</ul>

</div>

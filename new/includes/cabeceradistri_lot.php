<link href="../css/menu_dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/menu.css" media="screen" rel="stylesheet" type="text/css" />
<script language="javascript">
	function busTicket() { 
	propiedades11="width=500,height=680,Aresizable=no,location=no,menubar=no,scrollbars=yes,status=yes,toolbar=yes,fullscreen=no,dependent=yes";
	window.open("../distri_lot/distri_buscar_ticket_lot.php","_blank",propiedades11); 
	}
	
</script>
<div style="font-size:12px; margin:1px 0px 0px 0px">
<ul class="dropdown dropdown-horizontal" style="font-size:12px">
	<li>
    	<a href="../distri_lot/distri_resultados_trte_lot.php">RESULTADOS<br/>DE SORTEOS</a>
    </li>
	<li>
		<a href="../distri_lot/distri_devolucion_lot.php">DEVOLVER<br/>JUGADAS</a>
	</li>
	<li><br>REPORTES
		<ul>
            <li>
                <a href="../distri_lot/distri_reporte_ultimasjugadas_lot.php">ULTIMAS JUGADAS</a>
            </li>
            <li>
                <a href="../distri_lot/distri_reporte_general_lot.php">REPORTE LOTERIAS ANIMALITOS</a>
            </li>
            <li>
                <a href="../distri_lot/distri_resumen_ventas_xloterias_lot.php">REPORTE DE VENTAS POR SORTEOS</a>
            </li>
		</ul>
	</li>
    
	<li>
    	<a href="../distri_lot/distri_bloqueo_edit_lot.php"><br/>BLOQUEOS</a>
    </li>
    
	<li>
    	<a href="javascript:busTicket()">Buscar<br/>Ticket</a>
    </li>
	<li>
    	<a href="../distri_lot/distri_agente_lista_lot.php"><br/>Agentes</a>
    </li>
	<li>
    	<a href="../distri_lot/distri_taquillas_lista_lot.php"><br/>Taquillas</a>
    </li>
	<li>
    	<a href="../distri_lot/distri_edit_lot.php"><br/>Loterias</a>
    </li>
	<li><br>Usuarios
		<ul>
			<li><a href="../distri_lot/distri_usuario_dis_edit_lot.php">
                  	<span>CAMBIAR CLAVE</span>
				</a>
			</li>
			<li><a href="../distri_lot/distri_usuarios_age_lista_lot.php">AGENTE</a></li>
            <li><a href="../distri_lot/distri_usuarios_ven_lista_lot.php">VENDEDOR</a></li>
		</ul>
	</li>
</ul>
</div>

<?php
    $cambio=0;
    if (strpos($_SERVER["REQUEST_URI"], "/ventaslotan/")===false) {
        $dir=1;
    }
    if (strpos($_SERVER["REQUEST_URI"], "/ventaslot/")===false) {
        $dir=2;
    }
    
    if ((strpos($_SERVER["REQUEST_URI"], "/ventaslotan/"))===false && $row_Recordset6['est_venta_ani']>=1) {
        $cambio=1;
        $aHSistema='<a style="color:#FFF" href="../ventaslotan/index.php" title="ir a ventas Animalitos">ir a ventas<br/>Animalitos</a>';
    } elseif ($row_Recordset6['est_venta_lot']>=1&&(strpos($_SERVER["REQUEST_URI"], "/ventaslot/"))===false) {
        $cambio=1;
        $aHSistema='<a style="color:#FFF" href="../ventaslot/index.php" title="ir a ventas Triples/Terminales">ir a ventas <br/>Triples/Terminales</a>';
    }
?>
<script language="javascript"> 
function reimprimir() { 
re="width=800,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
window.open("ventas_reimprimir_lot.php","_blank",re); }
	
function reimprimeult() { 
ru="width=230,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes";
window.open("../ventaslot/ventas_reimprimir_ultimo_lot.php?tID=<?php echo $dir;?>","_blank",ru); } 
	
function resultados() { 
rs="width=500,height=560,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
window.open("../ventaslot/ventas_reporte_resultados_lot.php","_blank",rs); } 
	
function cuadre(){ 
cu="width=500,height=700,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
window.open("../ventaslot/ventas_reporte_cuadre_lot.php","_blank",cu); } 
	
function reportesorteo(){ 
so="width=645,height=600,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
window.open("../ventaslot/ventas_reporte_sorteo_lot.php","_blank",so); } 

function reportejugadas(){ 
so="width=645,height=600,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
window.open("../ventaslot/ventas_reporte_ultimasjugadas_lot.php","_blank",so); } 
	
function mensajes() { 
me="width=820,height=465,Aresizable=no,location=no,menubar=no,left=20,top=20,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
window.open("../ventashnac_mie/chat_ventasmie_hnac.php","_blank",me); } 

function cambio() { 
pro1="width=440,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../ventas/ventas_cambiar_clave_usuario.php","_blank",pro1+pro2); } 

function cambioticket() { 
pro4="width=340,height=380,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro5="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../ventaslot/ventas_configurar_ticket.php","_blank",pro4+pro5); } 

</script>
<STYLE TYPE="text/css">
a:link { color: #FFF; text-decoration: none }
a:visited { color: #FFF; text-decoration: none }
a:hover { color: #FFF; text-decoration: none; }
</STYLE>
<div id="menu" style="width:100%; font-size:12px">
    <div style="width:7.5%; float:left;">
        <a href="javascript:reimprimir()" title=" ir a lista de tickets ">Reimprimir<br/>ticket</a>
    </div>
    <div style="width:8.5%; float:left">
        <a href="javascript:reimprimeult()" title=" reimprime último ticket vendido">Reimprimir<br/>último ticket</a>
    </div>
    <div style="width:7.5%; float:left;">
        <a href="javascript:resultados()" title=" ver resultados de loterias ">Ver<br/>Resultados</a>
    </div>
    <div style="width:7.5%; float:left">
       <a href="#" title=" ver Guía de ventas de loterias ">Guia de <br/>ventas</a>
    </div>
    
    <div style="width:7.5%; float:left">
        <a href="javascript:cuadre()" title=" ver Cuadre de ventas de loterias ">Cuadre de<br/>Loterias</a>
    </div>
    <div style="width:7.5%; float:left">
        <a href="javascript:reportesorteo()" title=" lista de ventas por sorteo ">Resumen <br/>por Sorteo</a>
    </div>
    <div style="width:7.5%; float:left">
        <a href="javascript:reportejugadas()" title=" lista de jugadas ">Ultimas <br/>Jugadas</a>
    </div>
    <div style="width:7.5%; float:left">
        <a href="javascript:mensajes()" title=" enviar/ver mensaje "><br/>Mensajes</a>
    </div>
    <div style="width:7.5%; float:left">
        <a href="javascript:cambio()" title=" cambio de clave de acceso ">Cambiar <br/>clave</a>
    </div>
    <div style="width:8%; float:left">
        <a href="javascript:cambioticket()" title=" configura tickets ">Configurar <br/>ticket</a>
    </div>
    <div style="width:6%; float:left">
        <a style="color:#FFF" href="../acceso.php" title=" volver a seleccion ">Volver a<br/>seleccion</a>
    </div>
    <div style="width:4.5%; float:left">
        <a style="color:#FFF" href="../ventas/cerrar_sesion_vendedor.php" title=" salir del sistema "><br/>Salir</a>
    </div>
    <?php
    if ($cambio==1) {?>
        <div style="width:11%; height:34px; float: right; background:#0072C6; border:1px solid  #333; font-size:12px; 
            margin:-17px 0px 0px 0px"><?php
            echo $aHSistema;?>       
		</div><?php
    }?>
</div>
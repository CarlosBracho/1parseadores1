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
<script language="javascript"> 
<!-- 
function abrir_ventana() 
{ 
propiedades="width=500,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
window.open("../ventas/carreras_hoy.php","_blank",propiedades); 
} 
function rimprimeultimo() 
{ 
propiedades="width=640,height=580,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
window.open("../ventas/ventas_reimprimir_ultimo.php","_blank",propiedades); 
} 
function reportejugada() 
{ 
propiedades4="menubar=no,maximize=no,resizable=no,left=0,top=0,scrollbars=no,toolbar=no";
window.open("../ventas/ventas_reporte_jugadas.php","_blank",propiedades4); 
} 

function cambio() 
{ 
pro1="width=440,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,";
pro2="status=no,toolbar=no,fullscreen=no,dependent=yes,left=0,top=0";
window.open("../ventas/ventas_cambiar_clave_usuario.php","_blank",pro1+pro2); 
} 
//--> 
</script>
<link href="../estilo/estilomenu.css" rel="stylesheet" type="text/css" />
<nav>
    <ul>
        <li><a href="../distri/index.php">Carreras <br/>Internacionales</a></li>
        <li><a href="../distri_hnac/index.php">CARRERAS <br/>NACIONALES</a></li>
		<li><a href="../distri/1parley.php">PARLEY <br/><br/></a></li>
		<li><a href="../apostador/listaapostadorad.php">LISTA <br/>APOSTADORES</a></li>
        <li><a href="javascript:cambio()">CAMBIAR <br/>CLAVE</a></li>
        <li><a href="../ventas/cerrar_sesion_vendedor.php"><br/>SALIR</a></li>
		<li><a href="<?=$_SERVER["HTTP_REFERER"]?>">Atras</a></li>
    </ul>
</nav>
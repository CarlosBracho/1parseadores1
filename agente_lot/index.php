<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #eeeeee;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<script type="text/javascript" src="jslot/jquery-1.9.1.min.js"></script>
<script src="../modal/js/bootstrap.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);});
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
	<div class="header" style="height:100px; background:#0084B4">
		<?php include("../includes/cabeceraamericana_ag.php");?>
		<div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
			<div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
				position:absolute;border-radius: 0px 0px 5px 5px;">
				<?php include("../includes/cabeceraagente_lot.php");?>
			</div>
		</div> <!-- end .menu -->
	</div> <!-- end .header -->
	<div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
		<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
			Administracion <br/>
		</div>
		Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
		<span id="reloj"></span>
	</div>
	<div class="contentAdmin">
		<div style="height:100%; font-size:26px; padding:160px 0px 160px 0px; width:100%">
			Bienvenido al Módulo de <strong>Loterias</strong>!
		</div>	
	</div>
    <div class="footer" style="background:#0084B4"> Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
</div>
</body>
</html>
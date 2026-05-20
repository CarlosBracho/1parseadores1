<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
ini_set("session.gc_maxlifetime", 43200); # Tiempo de vida de las sesiones
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
var tiempo=3000;
var refreshId =setInterval(function() {$("#divControl").load('../includes/ret_amer.php?&js='+Math.random());}, tiempo);
$(document).ready(function() {
	$("#divControl").load('../includes/ret_amer.php?&js='+Math.random());
});
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
    <div style="background: #036; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align: center; font-size:34px"
    	id="datosUsuario">
        AMERICANA RETIRADOS
	</div>
</div>
<div class="contentAdmin">
	<div style="padding:10px 10px 20px 10px; text-align:left; font-size:18px; height: auto" id="divControl">
    		Cargando información<br/>Por favor espere un momento...
	</div>
</div>
</body>
</html>
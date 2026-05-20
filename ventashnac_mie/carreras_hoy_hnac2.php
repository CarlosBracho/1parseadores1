<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hipicas:.</title>
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
var tiempo=2000;
var refreshId =setInterval(function() {$("#programadas").load('../includes/carreras_programadas_hnac2.php?&js='+Math.random());}, tiempo);
$(document).ready(function() {
	$("#programadas").load('../includes/carreras_programadas_hnac2.php?&js='+Math.random());
});
</script>
</head>
<body style="margin: 0px">
	<div id="programadas"> 
    Cargando información<br/>Por favor espere un momento...
	</div>
</body>
</html>
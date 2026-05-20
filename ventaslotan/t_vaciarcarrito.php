<?php
if (!isset($_SESSION)) {
    session_start();
    ob_start();
}
include("../includes/libreria.php");
unset($_SESSION["ocarritoAni"]);
$_SESSION["ocarritoAni"] = new carrito();
$_SESSION['MM_montoAni']=0;
?>
<script type="text/javascript"> 
	$(document).ready(function() {
		$("#bimprimir").load("t_botonimprimir.php");
		$("#blimpiar").load("t_botonlimpiar.php");
		$("#btotal").load("t_total.php");
	});
</script>
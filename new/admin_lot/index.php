<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$query_Recordset19 = sprintf("/* PARSEADORES1 new\admin_lot\index.php - QUERY 1 */ SELECT * FROM ctrol_ventpag_global_lot LIMIT 1");
$Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
$row_Recordset19 = mysqli_fetch_assoc($Recordset19);
$totalRows_Recordset19 = mysqli_num_rows($Recordset19);
$cod_control=$row_Recordset19['cod_ctrol_ventpag_global_lot'];
$est_control_ventas=$row_Recordset19['est_control_ventas_lot'];
$est_control_pagos=$row_Recordset19['est_control_pagos_lot'];
if (isset($Recordset19)) {
    mysqli_free_result($Recordset19);
}
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
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script type="text/javascript" src="jslot/jquery-1.9.1.min.js"></script>
<script src="../modal/js/bootstrap.min.js"></script>
<script src="../modal/js/functions.js"></script>
<script src="../modal/js/sweetalert.min.js"></script> 
<link href="../css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../js/bootstrap-toggle.min.js"></script>
<script src="../modal/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../modal/css/alertify.min.css" />
<script src="../modal/js/alertify.min.js"></script>    
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
	if ($("#est_control_ventas").val()==0) $('#cVentas').bootstrapToggle('off');
	else $('#cVentas').bootstrapToggle('on');
	if ($("#est_control_pagos").val()==0) $('#cPagos').bootstrapToggle('off');
	else $('#cPagos').bootstrapToggle('on');
	$("#cVentas").change(function(){
		if ($(this).prop('checked')==true) {var cambio=1; $("#est_control_ventas").val("1");}
		if ($(this).prop('checked')==false) {var cambio=0; $("#est_control_ventas").val("0");}
		var parametros = {"cod_control":$("#cod_control").val(), "est_control_ventas":cambio, "est_control_pagos":$("#est_control_pagos").val()};
		$.ajax({ url:"../admin_lot/ctrol_ventaspagos_global_lot.php", type: "POST", data:parametros,
			success: function(){ 
				if (cambio==0) alertify.success('<font size="2">VENTAS DE LOTERIAS SE REANUDARON!</font>');
				if (cambio==1) alertify.error('<font size="2">SE HAN DESHABILITADO LAS VENTAS!</font>');
			}
		});
	});
	$("#cPagos").change(function(){
		if ($(this).prop('checked')==true) {var cambio=1; $("#est_control_pagos").val("1");}
		if ($(this).prop('checked')==false) {var cambio=0; $("#est_control_pagos").val("0");}
		var parametros = {"cod_control":$("#cod_control").val(), "est_control_ventas":$("#est_control_ventas").val(), "est_control_pagos":cambio};
		$.ajax({ url:"../admin_lot/ctrol_ventaspagos_global_lot.php", type: "POST", data:parametros,
			success: function(){ 
				if (cambio==0) alertify.success('<font size="2">PAGOS DE LOTERIAS SE REANUDARON!</font>');
				if (cambio==1) alertify.error('<font size="2">SE HAN DESHABILITADO LOS PAGOS!</font>');
			}
		});
	});
});
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
	<div class="header" style="height:100px; background:#0084B4">
		<?php include("../includes/cabeceraamericana.php");?>
		<div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
			<div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
				position:absolute;border-radius: 0px 0px 5px 5px;">
				<?php include("../includes/cabecera_lot.php");?>
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
			Bienvenido al Módulo de <strong>Loterias Nacionales</strong>!
			<div id="detVentaPago" style=" width:100%;height:100%; font-size:14px;text-align:center; padding:10px">
               	<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="25%">&nbsp;</td>

						<td width="25%" align="center">Habiltar/Deshabilitar Ventas:<br/>
							<input id="cVentas" type="checkbox" checked data-toggle="toggle" data-onstyle="danger" 
                            data-offstyle="success" data-width="180" data-height="15"
                            data-off='<font size="2">VENTAS HABILITADAS</font>' data-on='<font size="2">VENTAS DESHABILITADAS</font>'>
						</td>
						<td width="25%" align="center">Habiltar/Deshabilitar Pagos:<br/>
                            <input id="cPagos" type="checkbox" checked data-toggle="toggle" data-onstyle="danger" 
                            data-offstyle="success" data-width="180" data-height="15"
                            data-off='<font size="2">PAGOS HABILITADOS</font>' data-on='<font size="2">PAGOS DESHABILITADOS</font>'>
						</td>
						<input type="hidden" name="cod_control" id="cod_control" value="<?php echo $cod_control; ?>" />
                        <input type="hidden" name="est_control_ventas" id="est_control_ventas" 
                        	value="<?php echo $est_control_ventas; ?>" />
                        <input type="hidden" name="est_control_pagos" id="est_control_pagos" 
                        	value="<?php echo $est_control_pagos;?>" />
						<td width="25%">&nbsp;</td>
					</tr>
				</table>
			</div>
		</div>	
	</div>
    <div class="footer" style="background:#0084B4"> Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
</div>
</body>
</html>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$horaactual=horaactual();
$fechasistema=fechaactualbd();
$fecha=fechanueva(fechaactualbd());

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechasistema=fechaymd($_POST["fecha"]);
    $fecha=$_POST["fecha"];
}


?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hipicas:.</title>


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
<link href="../modal/css/sweetalert.css" rel="stylesheet">
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
<link rel="stylesheet" href="../modal/css/alertify.min.css" />
<link rel="stylesheet" href="../modal/css/default.min.css" />
<script src="../modal/js/alertify.min.js"></script>    
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<script type="text/javascript">
	function accionCancelar(titulo,pregunta,cCar) {
		swal({
		  title: titulo,
		  text: pregunta,
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonText: "Cancelar",
		  confirmButtonClass: "btn-danger",
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Aceptar",
		  closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				var rA=Math.random();
				var parametros = { "recordID":cCar, "rA":Math.random() };
				$.ajax({ data:parametros, url:'admin_apertura_cancelar.php', type:'get',
					success:function (response) { 
						$("#hipodromo").html(response);
						window.location='admin_apertura_lista.php';
					}
				});
			} else {
				alertify.error('<font size="4">Accion cancelada!</font>');
			}
				 
		});	
	}
	function accionCerrar(titulo,pregunta,cCar) {
		swal({
		  title: titulo,
		  text: pregunta,
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonText: "Cancelar",
		  confirmButtonClass: "btn-danger",
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Aceptar",
		  closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				var rA=Math.random();
				var parametros = { "recordID":cCar, "rA":Math.random() };
				$.ajax({ data:parametros, url:'admin_apertura_cierre.php', type:'get',
					success:function (response) { 
						$("#hipodromo").html(response);
						window.location='admin_apertura_lista.php';
					}
				});
			} else {
				alertify.error('<font size="4">Accion cancelada!</font>');
			}
		});	
	}
	function accionAumentar(titulo,pregunta, cCar, tempo, tipo, mControl) {
		swal({
		  title: titulo,
		  text: pregunta,
		  type: tipo,
		  showCancelButton: true,
		  cancelButtonText: "Cancelar",
		  confirmButtonText: "Aceptar",
		  closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				var rA=Math.random();
				var parametros = { "recordID":cCar, "tempo":tempo, "mControl":mControl, "rA":Math.random() };
				$.ajax({ data:parametros, url:'admin_apertura_reabrir.php', type:'get',
					success:function (response) { 
						$("#hipodromo").html(response);
						window.location='admin_apertura_lista.php';
					}
				});
			} else {
				alertify.error('<font size="4">Aumento de tiempo cancelado!</font>');
			}
		});	
	}
	function accionPausar(titulo, pregunta, cCar, cambio, tipo, pV) {
		swal({
		  title: titulo,
		  text: pregunta,
		  type: tipo,
		  showCancelButton: true,
		  cancelButtonText: "Cancelar",
		  confirmButtonText: "Aceptar",
		  closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				var rA=Math.random();
				var parametros = { "cCar":cCar, "cambio":cambio, "rA":Math.random(), "pV":pV };
				$.ajax({ data:parametros, url:'ctrol_ventaspagos_carrera_ame.php', type:'post',
					success:function (response) { 
						window.location='admin_apertura_lista.php';
					}
				});
			} else {
				if (cambio==0 && pV=="P") alertify.error('<font size="4">Pausar pagos cancelado!</font>');
				else if (cambio==1 && pV=="P") alertify.error('<font size="4">Reanudar pagos cancelado!</font>');
				else if (cambio==0 && pV=="V") alertify.error('<font size="4">Pausar ventas cancelado!</font>');
				else if (cambio==1 && pV=="V") alertify.error('<font size="4">Reanudar ventas cancelado!</font>');
			}
		});	
	}	
	$(document).ready(function(){
		if ($("#est_control_ventas").val()==0) $('#cVentas').bootstrapToggle('off');
		else $('#cVentas').bootstrapToggle('on');
		if ($("#est_control_pagos").val()==0) $('#cPagos').bootstrapToggle('off');
		else $('#cPagos').bootstrapToggle('on');
		$("#cVentas").change(function(){
			if ($(this).prop('checked')==true) {var cambio=1; $("#est_control_ventas").val("1");}
			if ($(this).prop('checked')==false) {var cambio=0; $("#est_control_ventas").val("0");}
			var parametros = {"cod_control":$("#cod_control").val(), "est_control_ventas":cambio, "est_control_pagos":$("#est_control_pagos").val()};
			$.ajax({ url:"../admin/ctrol_ventaspagos_global_ame.php", type: "POST", data:parametros,
				success: function(){ window.location='admin_apertura_lista.php';}
			});
		});
		$("#cPagos").change(function(){
			if ($(this).prop('checked')==true) {var cambio=1; $("#est_control_pagos").val("1");}
			if ($(this).prop('checked')==false) {var cambio=0; $("#est_control_pagos").val("0");}
			var parametros = {"cod_control":$("#cod_control").val(), "est_control_ventas":$("#est_control_ventas").val(), "est_control_pagos":cambio};
			$.ajax({ url:"../admin/ctrol_ventaspagos_global_ame.php", type: "POST", data:parametros,
				success: function(){ window.location='admin_apertura_lista.php';}
			});
		});
	});		
	
</script>
<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
					<?php include("../includes/cabeceraadmin.php");?>
                </div>
            </div> <!-- end .menu -->
  </div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Apertura y cierre de Carreras <br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
  	<div style=" font-size:18px;" class="xfirefox">
        <div style=" font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="admin_apertura_add_auto_buildtvg.php" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:150px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #C90;
                text-decoration:none;" title="crear carreras desde racebets automaticamente">
                 Apertura<br/> BuildABet2/TVG
            </a>

            <a href="admin_apertura_add_auto_tvg.php" class="btn alert-success" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #0CF;
                text-decoration:none; " title="crear carreras desde tvg automaticamente">
                 Apertura<br/> TVG
            </a>
            <a href="admin_apertura_add_auto_twin.php" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #D8FF00;
                text-decoration:none;" title="crear carreras desde Twinspires automaticamente">
                 Apertura<br/> Twinspires
            </a>
            <a href="admin_apertura_add_auto_buildabet2.php" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear carreras desde racebets automaticamente">
                 Apertura<br/> BuildABet2
            </a>
            <a href="../admin/admin_apertura_multiple.php" class="btn alert-success" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #FC0;
                text-decoration:none; " title="crear varias carreras por hipÃ³dromo manualmente">
                 Apertura <br/>MÃºltiple
            </a>
        </div>
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px" >
      <tr>
        <td width="160" align="left">
          <div style="height:40px; font-size:18px; padding:4px 0px 0px 4px; background: #333; color: #fff ">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                Fecha:
                <input name="fecha" type="text" id="dateArrival1" tabindex="1" 
                	style="width:100px; font-size:18px; height: 24px; background-color: #FFFFFF;"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:34px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
          </div>
        </td>
        <td width="359" align="right">
					
        </td>
        </tr>
    </table>
	    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px" >
      <tr>
        <td width="160" align="left">
	<?php
     $query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin\versionexplorador.php - QUERY 1 */ SELECT 
* FROM exploradorversion ex 
ORDER BY ex.Id DESC LIMIT 9999");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    echo "Total Taquillas:."; echo $totalRows_Recordset1;
    echo "<br/><br/><br/>";


?>
  <table width="100%" border="1" align="left" bordercolor="#F4F4F4">
  <tr style="background: #333; color:#FFF;  height:30px">
          <td width="20">PAIS</td>
        <td width="40">DIRECCION IP</td>

  </tr>
  <?php do { ?>
  <tr bgcolor="#FFFFFF" style="background: #333; color:#FFF; font-size:14px">
      <td align="left"><?php echo $row_Recordset1['Id']; ?></td>
    <td align="left"><?php echo $row_Recordset1['exploradorversion']; ?></td>
</tr>
  <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    </table>





<?php
mysqli_free_result($Recordset1);
    echo "<br/>";	echo "<br/>";	echo "<br/>";	echo "<br/>";	echo "<br/>";
    ?>
</body>

</html>

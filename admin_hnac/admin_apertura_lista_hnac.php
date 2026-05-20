<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
    $editFormAction2 .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$maxRows_Recordset1 = 800;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$horaactual=horaactual();
$fechasistema=fechaactualbd();
$fecha=fechanueva(fechaactualbd());
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechasistema=fechaymd($_POST["fecha"]);
    $fecha=$_POST["fecha"];
}
if ((isset($_POST["MM_update2"])) && ($_POST["MM_update2"] == "form2")) {
    echo $_POST["cod_dividendo_macu"].$_POST["div_pago"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin_hnac\admin_apertura_lista_hnac.php - QUERY 1 */ SELECT 
	carrera_hnac.cod_carrera_hnac,
	carrera_hnac.cod_hipodromo_hnac,
	carrera_hnac.fec_carrera_hnac,
	carrera_hnac.hor_carrera_hnac,
	carrera_hnac.est_carrera_hnac,
	carrera_hnac.est_cierre_hnac,
	carrera_hnac.can_caballos_hnac,
	carrera_hnac.num_carrera_hnac,
	carrera_hnac.dis_carrera_hnac,
	carrera_hnac.mtp_control_hnac,
	carrera_hnac.est_confirmacion_hnac,
	carrera_hnac.pau_pagos_hnac,
	carrera_hnac.pau_ventas_hnac,
	hipodromo_hnac.nom_hipodromo_hnac
	FROM 
	carrera_hnac, 
	hipodromo_hnac 
	WHERE 
	carrera_hnac.cod_hipodromo_hnac=hipodromo_hnac.cod_hipodromo_hnac AND
	carrera_hnac.fec_carrera_hnac = %s 
	ORDER BY carrera_hnac.num_carrera_hnac ASC",
    GetSQLValueString($fechasistema, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
//	carrera_hnac.est_confirmacion_hnac=0 AND

if (isset($_GET['totalRows_Recordset1'])) {
    $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
    $all_Recordset1 = mysqli_query($conexionbanca, $query_Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (stristr($param, "pageNum_Recordset1") == false &&
        stristr($param, "totalRows_Recordset1") == false) {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0) {
        $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
if ($totalRows_Recordset1>0) {
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 admin_hnac\admin_apertura_lista_hnac.php - QUERY 2 */ SELECT dv.cod_dividendo_macu, dv.div_pago_macu
		FROM 
			div_oficiales_macu dv
		WHERE 
			dv.fec_dividendo_macu = %s 
		LIMIT 1",
        GetSQLValueString($fechasistema, "date")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    if ($totalRows_Recordset2>0) {
        $div_pago=$row_Recordset2['div_pago_macu'];
        $cod_dividendo_macu=$row_Recordset2['cod_dividendo_macu'];
    } else {
        $div_pago="";
        $cod_dividendo_macu=-1;
    }
} else {
    $div_pago="";
    $cod_dividendo_macu=-1;
}
$query_Recordset3 = sprintf("/* PARSEADORES1 admin_hnac\admin_apertura_lista_hnac.php - QUERY 3 */ SELECT * FROM ctrol_ventpag_global_hnac WHERE cod_ctrol_ventpag_global_hnac = 1");
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$cod_control=$row_Recordset3['cod_ctrol_ventpag_global_hnac'];
$est_control_ventas_hnac=$row_Recordset3['est_control_ventas_hnac'];
$est_control_pagos_hnac=$row_Recordset3['est_control_pagos_hnac'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#DDDDDD" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
function cStatus(id, cCar) {
	if (id==0) modo=" MANUAL?";
	if (id==1) modo=" 1 opcion 1?";
	if (id==2) modo=" 2 opcion 2?";
	if (id==3) modo=" 3 opcion 3?";
	if (id==4) modo=" 4 opcion 4?";
	if (id==5) modo=" 5 opcion 5?";
	if (id==6) modo=" 6 opcion 6?";
	if (id==7) modo=" 7 opcion 7?";
	if (id==8) modo=" 8 opcion 8?";
	if (id==9) modo=" 9 opcion 9?";
	confirma = confirm('¿Desea cambiar Carrera a modo'+modo);
	if(confirma==true){
		var rA=Math.random();
		var parametros = { "codCar":cCar, "modo":id, "rA":Math.random() };
		$.ajax({ data:parametros, url:'../includes/man_aut_carr_hnac.php', type:'post',
			success:function (response) { 
				$("#hipodromo").html(response);
				window.location='admin_apertura_lista_hnac.php';
			}
		}); 
	} else window.location='admin_apertura_lista.php';
	
}
</script>
<style type="text/css"> 
A:link {text-decoration:none;color:#0000cc;} 
A:visited {text-decoration:none;color:#ffcc33;} 
A:active {text-decoration:none;color:#ff0000;} 
A:hover {text-decoration:underline;color:#999999;}
</style> 
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
				$.ajax({ data:parametros, url:'admin_apertura_cancelar_hnac.php', type:'get',
					success:function (response) { 
						window.location='admin_apertura_lista_hnac.php';
					}
				});
			} else {
				alertify.error('<font size="4">Acción cancelada!</font>');
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
				$.ajax({ data:parametros, url:'admin_apertura_cierre_hnac.php', type:'get',
					success:function (response) { 
						window.location='admin_apertura_lista_hnac.php';
					}
				});
			} else {
				alertify.error('<font size="4">Acción cancelada!</font>');
			}
		});	
	}
	function accionAumentar(titulo,pregunta, cCar, tempo, tipo) {
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
				var parametros = { "recordID":cCar, "tempo":tempo, "rA":Math.random() };
				$.ajax({ data:parametros, url:'admin_apertura_reabrir_hnac.php', type:'get',
					success:function (response) { 
						window.location='admin_apertura_lista_hnac.php';
					}
				});
			} else {
				alertify.error('<font size="4">Aumento de tiempo cancelado!</font>');
			}
		});	
	}
	function cambiarDividendo(titulo,pregunta,cDiv,mDiv,nUsu,tipo) {
		mDiv=document.getElementById(mDiv).value;
		
		if (mDiv>0) {
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
					var parametros = { "recordID":cDiv, "divpag":mDiv, "nusu":nUsu, "rA":Math.random() }
					$.ajax({ data:parametros, url:'admin_apertura_moddiv_macu.php', type:'post',
						success:function (response) { 
							window.location='admin_apertura_lista_hnac.php';
						}
					});
				} else {
					window.location='admin_apertura_lista_hnac.php';
				}
			});
		}
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
				$.ajax({ data:parametros, url:'ctrol_ventaspagos_carrera_hnac.php', type:'post',
					success:function (response) { 
						window.location='admin_apertura_lista_hnac.php';
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
	
	function NumCheck(e, field) {
	  key = e.keyCode ? e.keyCode : e.which
	  if (key == 8) return true
	  if (key > 47 && key < 58) {
		if (field.value == "") return true
		regexp = /.[0-9]{5}$/
		return !(regexp.test(field.value))
	  }
	  if (key == 46) {
		if (field.value == "") return false
		regexp = /^[0-9]+$/
		return regexp.test(field.value)
	  }
	  return false
	}
	$(document).ready(function(){
		if ($("#est_control_ventas_hnac").val()==0) $('#cVentas').bootstrapToggle('off');
		else $('#cVentas').bootstrapToggle('on');
		if ($("#est_control_pagos_hnac").val()==0) $('#cPagos').bootstrapToggle('off');
		else $('#cPagos').bootstrapToggle('on');
		$("#cVentas").change(function(){
			if ($(this).prop('checked')==true) {var cambio=1; $("#est_control_ventas_hnac").val("1");}
			if ($(this).prop('checked')==false) {var cambio=0; $("#est_control_ventas_hnac").val("0");}
			var parametros = {"cod_control":$("#cod_control").val(), "est_control_ventas_hnac":cambio, "est_control_pagos_hnac":$("#est_control_pagos_hnac").val()};
			$.ajax({ url:"../admin_hnac/ctrol_ventaspagos_global_hnac.php", type: "POST", data:parametros,
				success: function(){ window.location='admin_apertura_lista_hnac.php';}
			});
		});
		$("#cPagos").change(function(){
			if ($(this).prop('checked')==true) {var cambio=1; $("#est_control_pagos_hnac").val("1");}
			if ($(this).prop('checked')==false) {var cambio=0; $("#est_control_pagos_hnac").val("0");}
			var parametros = {"cod_control":$("#cod_control").val(), "est_control_ventas_hnac":$("#est_control_ventas_hnac").val(), "est_control_pagos_hnac":cambio};
			$.ajax({ url:"../admin_hnac/ctrol_ventaspagos_global_hnac.php", type: "POST", data:parametros,
				success: function(){ window.location='admin_apertura_lista_hnac.php';}
			});
		});
	});		
</script>

<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
<link href='../css/iconfont/css/font-awesome.css' rel='stylesheet'/>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Apertura y cierre de<br/>carreras nacionales
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="#" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #C36;
                text-decoration:none;" title="crear carreras desde tuhipismo.net automáticamente">
                 Apertura Auto <br/>tuhipismo
            </a>
            <a href="admin_apertura_add_auto_hnac.php" class="btn alert-success" 
            	style="font-size:18px; width:140px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #0CF;
                text-decoration:none; " title="crear carreras desde maquinaazul.com.ve automáticamente">
                 Apertura Auto maquinaazul
            </a>
            <a href="admin_apertura_multiple_hnac.php" class="btn alert-success" 
            	style="font-size:18px; width:160px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #FC0;
                text-decoration:none; " title="crear varias carreras por hipódromo manualmente">
                 Apertura Múltiple<br/>Manual
            </a>
            <a href="admin_apertura_add_hnac.php" class="btn alert-success" 
            	style="font-size:18px; width:140px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #C6F;
                text-decoration:none; " title="crear carrera manualmente">
                 Apertura <br/>Manual
            </a>
        </div>
    <table width="100%" border="0" align="center" style="background:#0E5157; color:#FFF; font-size:14px" >
      <tr>
        <td width="160" align="left">
          <div style="height:40px; font-size:18px; padding:4px 0px 0px 4px; background:#0E5157; color: #fff ">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                Fecha:
                <input name="fecha" type="text" id="dateArrival1" tabindex="1" 
                	style="width:100px; font-size:18px; height: 24px; background-color: #FFFFFF;"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" 
                	onClick="return enviado()" style="width:80px; height:34px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
          </div>
        </td>
        <td width="359" align="right" style="color: #F90; font-size:20px">
          CARRERAS NACIONALES:  <?php echo $totalRows_Recordset1 ?>&nbsp;
        </td>
        </tr>
    </table>
    <?php if ($totalRows_Recordset1>=1) { ?>
	<div id="detVentaPago" style="height:100%; padding:4px 0px 4px 0px; font-size:14px">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
              <td width="25%">&nbsp;</td>
              <td width="25%">&nbsp;</td>
              <td width="25%">Habiltar/Deshabilitar Ventas:<br/>
				<input id="cVentas" type="checkbox" checked data-toggle="toggle" data-onstyle="danger" 
				data-offstyle="success" data-width="180" data-height="15"
				data-off='<font size="2">VENTAS HABILITADAS</font>' data-on='<font size="2">VENTAS DESHABILITADAS</font>'>
              </td>
              <td width="25%">Habiltar/Deshabilitar Pagos:<br/>
				<input id="cPagos" type="checkbox" checked data-toggle="toggle" data-onstyle="danger" 
				data-offstyle="success" data-width="180" data-height="15"
				data-off='<font size="2">PAGOS HABILITADOS</font>' data-on='<font size="2">PAGOS DESHABILITADOS</font>'>
              </td>
            </tr>
            </tbody>
		</table>
   </div>
  <div style="height:100%; padding:0px 0px 90px 0px ">  
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr style="background:#0E5157; color:#FFFFFF; height:30px">
    <td colspan="5" valign="bottom">&nbsp;</td>
    <td colspan="9" align="right" valign="top" height="10">
      <div style="height:39px; font-size:18px; padding:1px 2px 0px 0px; color: #000; background:#00BB7E;">
        Dividendo Macuare:
        <input name="div_pago" type="text" id="div_pago"
                style="width:100px; font-size:18px; height: 24px; background-color: #FFFFFF;"
                title="indique dividendo para macuare corto" 
                onkeypress="return NumCheck(event, this)"
                value="<?php echo htmlentities($div_pago, ENT_COMPAT, 'utf-8'); ?>"/>
        <a title="actualizar dividendo para macuare corto" 
            	onclick='cambiarDividendo("<?php echo "DIVIDENDO MACUARE CORTO"; ?>","¿Está seguro de modificar monto del dividendo?","<?php echo $cod_dividendo_macu; ?>","div_pago","<?php echo $_SESSION['MM_nom_usuario']; ?>","info")' href='#'><i class="fa fa-undo fa-2x"></i>  
          </a>
        </div>
    </td>
    </tr>
  <tr style="background:#0E5157; color:#FFFFFF; height:30px" align="center">
    <td width="28" valign="bottom"></td>
    <td valign="bottom">HIPÓDROMO</td>
    <td width="35" valign="bottom" style="font-size:8px">CORREN</td>
    <td width="143" valign="bottom">STATUS</td>
    <td width="54" valign="bottom" >MTP</td>
    <td height="5" colspan="7" valign="bottom">ACCIONES</td>
    <td align="right" valign="bottom" height="5" style="font-size:10px">VENTAS</td>  
    <td align="right" valign="bottom" height="5" style="font-size:10px">PAGOS</td>
    <td align="right" valign="bottom" height="5" style="font-size:10px">DAR RESULTADO</td>     
  </tr>
  <?php
  $k=1;
  do {
      $van=$row_Recordset1['can_caballos_hnac']-cantRetirados_hnac($row_Recordset1['cod_carrera_hnac']);
      if ($row_Recordset1['mtp_control_hnac']==0) {
          $carrA='<font color="red">'.$row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac'].'</font>';
      } else {
          $carrA='<font color="green">'.$row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac'].'</font>';
      } ?>
  <tr bgcolor="#FFFFFF" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"; style="font-size:14px;border-bottom: 1px solid #C1BDBE;">
    <td>
      <?php if ($row_Recordset1['est_carrera_hnac']!=0) {?>
        <a title="cerrar carrera" onclick='accionCerrar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Seguro de CERRAR LA CARRERA?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>")'
            href='#'>
            <i class="fa fa-lock fa-2x"></i>    
        </a>        
        
      <?php } ?>    
      </td>
    <td width="170" align="left">
    <?php
    echo '<strong>'.$carrA.'</strong>';
      $vepa="";
      if ($row_Recordset1['pau_pagos_hnac']==1 && $row_Recordset1['pau_ventas_hnac']==0) {
          $vepa="&nbsp;&nbsp;(PAGOS PAUSADOS)";
      } elseif ($row_Recordset1['pau_pagos_hnac']==0 && $row_Recordset1['pau_ventas_hnac']==1) {
          $vepa="&nbsp;&nbsp;(VENTAS PAUSADAS)";
      } elseif ($row_Recordset1['pau_pagos_hnac']==1 && $row_Recordset1['pau_ventas_hnac']==1) {
          $vepa="&nbsp;&nbsp;(VENTAS Y PAGOS PAUSAD0S)";
      }
      echo '<font color="red"  style="font-size:10px;"><br/>'.$vepa.'</font>' ; ?>
    </td>
    <?php
    $status="";
      if ($row_Recordset1['est_carrera_hnac']==0 && $row_Recordset1['est_cierre_hnac']==2) {
          $status="<font color=\"red\">CERRADA AUTOMATICO</font>";
      }
      if ($row_Recordset1['est_carrera_hnac']==0 && $row_Recordset1['est_cierre_hnac']==1) {
          $status="<font color=\"red\">CERRADA MANUAL</font>";
      }
      if ($row_Recordset1['est_carrera_hnac']==0 && $row_Recordset1['est_cierre_hnac']==0) {
          $status="<font color=\"red\">CANCELADA</font>";
      }
      if ($row_Recordset1['hor_carrera_hnac']>horaactual2() && $row_Recordset1['est_carrera_hnac']==1 &&
        $row_Recordset1['est_cierre_hnac']==3) {
          $status="<font color=\"green\">ABIERTA</font>";
      }
      if ($row_Recordset1['hor_carrera_hnac']<=horaactual2() && $row_Recordset1['est_carrera_hnac']==1 && $row_Recordset1['est_cierre_hnac']==3) {
          $status="<font color=\"orange\">PRE-CERRADA</font>";
      }
      if ($row_Recordset1['est_carrera_hnac']==5 && $row_Recordset1['est_cierre_hnac']==5) {
          $status="<font color=\"gray\">EN ESPERA</font>";
      } ?>
    <td align="center">
      <?php
        if ($van<=3) {
            echo '<font color="red">'.$van."/".$row_Recordset1['can_caballos_hnac'].'</font>';
        } else {
            echo $van."/".$row_Recordset1['can_caballos_hnac'];
        } ?>
      </td>
    <td align="center">
      <?php echo $status; ?><br/>
      <span style="font-size:10px"><?php echo horaampm($row_Recordset1['hor_carrera_hnac']); ?></span>
      </td>
    
    <td align="center"><?php if ($row_Recordset1['hor_carrera_hnac']>horaactual2()) {
            echo restahoraRB(horaactual2(), $row_Recordset1['hor_carrera_hnac']);
        } ?>
      </td>
    <td width="122" align="center" valign="bottom" style="color:#090"><?php
      if ($row_Recordset1['est_confirmacion_hnac']==0) {?>
          <select name="mtp_control"  style="width:122px; height:30px; font-size:13px;" tabindex="4" 
                onchange="cStatus(this.value, <?php echo $row_Recordset1['cod_carrera_hnac'] ?>)"> 
            <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#CC0000">MANUAL</option>
            <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#090">1 opcion 1</option>
            <option value="2" <?php if (!(strcmp(2, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#090">2 opcion 2</option>
            <option value="3" <?php if (!(strcmp(3, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#090">3 opcion 3</option>
            <option value="4" <?php if (!(strcmp(4, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#090">4 opcion 4</option>
            <option value="5" <?php if (!(strcmp(5, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#090">5 opcion 5</option>
            <option value="6" <?php if (!(strcmp(6, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#090">6 opcion 6</option>
            <option value="7" <?php if (!(strcmp(7, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#090">7 opcion 7</option>
            <option value="8" <?php if (!(strcmp(8, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#090">8 opcion 8</option>
            <option value="9" <?php if (!(strcmp(9, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="color:#090">9 opcion 9</option>

          </select><?php
      } ?> 
      </td>
    <td width="30" align="center"><?php
      if ($row_Recordset1['est_confirmacion_hnac']==0) {?>
        <a title="" onclick='accionCancelar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Está seguro de CANCELAR LA CARRERA?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>")'
            href='#'>
            <i class="fa fa-times-circle fa-2x"></i>    
        </a><?php
      } ?> 
      </td>
    <td width="30" align="center"><?php
      if ($row_Recordset1['est_confirmacion_hnac']==0) {?>
        <a title="editar carrera" href="admin_apertura_edit_hnac.php?recordID=<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">		
            <i class="fa fa-pencil fa-2x"></i>
        </a><?php
      } ?> 
    </td>
    <td width="40" align="center"><?php
      if ($row_Recordset1['est_confirmacion_hnac']==0) {?>
        <a title="abrir y aumentar 2 minuto" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Está seguro de abrir y AUMENTAR 2 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",2,"info")'
            href='#'>
            <i class="fa fa-3x"><strong>2</strong></i>    
        </a><?php
      } ?>   
      </td>
    <td width="40" align="center"><?php
      if ($row_Recordset1['est_confirmacion_hnac']==0) {?>
        <a title="abrir y aumentar 5 minuto" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Está seguro de abrir y AUMENTAR 5 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",5,"info")' href='#'> <i class="fa fa-3x"><strong>5</strong></i>    
        </a><?php
      } ?>        
      </td>
    <td width="40" align="center"><?php
      if ($row_Recordset1['est_confirmacion_hnac']==0) {?>
       <a title="abrir y aumentar 10 minuto" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Está seguro de abrir y AUMENTAR 10 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",10,"info")' href='#'><i class="fa fa-3x"><strong>10</strong></i>    
        </a><?php
      } ?>   
      </td>
<td width="40" align="center">
    <?php
    if ($row_Recordset1['hor_carrera_hnac']>horaactual2()) {?>
        <a title="" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Está seguro de DISMINUIR 2 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",-2,"warning",0)'
            href='#'>
            <i class="fa fa-2x"><strong>-2</strong></i>    
        </a>        
           
    <?php } ?>
    </td>
    <td width="40" align="center"><?php
    if ($row_Recordset1['hor_carrera_hnac']>horaactual2() && $row_Recordset1['est_carrera_hnac']==1 &&
        $row_Recordset1['est_cierre_hnac']==3) {
        if ($row_Recordset1['pau_ventas_hnac']==0) {
            $titPago="&nbsp;PAUSAR ventas a carrera #".$row_Recordset1['num_carrera_hnac'];
            $icon="<i class='fa fa-pause fa-lg'></i>";
            $menV="¿Está seguro de PAUSAR VENTAS a esta carrera?";
            $class="btn btn-info";
        } else {
            $titPago="&nbsp;REANUDAR ventas a carrera #".$row_Recordset1['num_carrera_hnac'];
            $icon="<i class='fa fa-play fa-lg'></i>";
            $menV="¿Está seguro de REANUDAR VENTAS a esta carrera?";
            $class="btn btn-warning";
        } ?>
        <a onclick='accionPausar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","<?php echo $menV; ?>","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>","<?php echo $row_Recordset1['pau_ventas_hnac']; ?>","warning","V")' href='#' class="<?php echo $class; ?>" style="height:70%; padding:8px" title="<?php echo $titPago; ?>">
            <?php echo $icon; ?>
        </a>        
    <?php
    } ?>
    </td>
    <td width="40" align="center"><?php
        if ($row_Recordset1['pau_pagos_hnac']==0) {
            $titPago="&nbsp;PAUSAR pagar tickets a carrera #".$row_Recordset1['num_carrera_hnac'];
            $icon="<i class='fa fa-pause fa-lg'></i>";
            $menP="¿Está seguro de PAUSAR PAGOS a esta carrera?";
            $class="btn btn-info";
        } else {
            $titPago="&nbsp;REANUDAR pagar tickets a carrera #".$row_Recordset1['num_carrera_hnac'];
            $icon="<i class='fa fa-play fa-lg'></i>";
            $menP="¿Está seguro de REANUDAR PAGOS a esta carrera?";
            $class="btn btn-warning";
        } ?>
        <a onclick='accionPausar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","<?php echo $menP; ?>","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>","<?php echo $row_Recordset1['pau_pagos_hnac']; ?>","warning","P")' href='#' class="<?php echo $class; ?>" style="height:70%; padding:8px" title="<?php echo $titPago; ?>">
            <?php echo $icon; ?>
        </a>        
    </td>
    <?php if ($row_Recordset1['est_cierre_hnac']==1) {?>
    <td align="center">
		  <?php if ($row_Recordset1['fec_carrera_hnac']<$fecha && $row_Recordset1['est_carrera_hnac']==1) {?>
		  <a href="dividendos_cerrar_anterior.php?recordID=<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" title="cerrar carrera"><i class="fa fa-lock fa-2x"></i></a>
		  <?php } else {?>
			<a href="admin_dividendos_add_hnac.php?recordID=<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" target="_blank" title="incluir dividendos"><i class="fa fa-plus-circle fa-2x"></i></a>
    <?php }?>
		<?php } ?>    
		</td>
  </tr>
  <?php
    $k++;
  } 
  while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    </table>
    </div>
    <?php } else {?>
		<table width="100%" border="1" align="center" bordercolor="#0E5157">
            <tr style="background:#0E5157; color:#FFFFFF; height:30px">
                <td width="43" valign="bottom"></td>
                <td width="213" valign="bottom">HIPÓDROMO</td>
                <td width="36" valign="bottom" style="font-size:8px">CORREN</td>
                <td width="151" valign="bottom">STATUS</td>
                <td width="61" valign="bottom" >MTP</td>
                <td width="396" colspan="6" valign="bottom">&nbsp;</td>
            </tr>
        </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
	<?php }?>    
  </div> 
  </div>
  <input type="hidden" name="cod_control" id="cod_control" value="<?php echo $cod_control; ?>" />
  <input type="hidden" name="est_control_ventas_hnac" id="est_control_ventas_hnac" value="<?php echo $est_control_ventas_hnac; ?>" />
  <input type="hidden" name="est_control_pagos_hnac" id="est_control_pagos_hnac" value="<?php echo $est_control_pagos_hnac; ?>" />
    
      
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
  <div id="hipodromo" style="background: #F9E209">
  </div> 
<script src="../modal/js/bootstrap.min.js"></script>
<script src="../modal/js/functions.js"></script>
<script src="../modal/js/sweetalert.min.js"></script> 
<link href="../css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../js/bootstrap-toggle.min.js"></script>
<script src="../modal/js/bootstrap.min.js"></script>
 
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
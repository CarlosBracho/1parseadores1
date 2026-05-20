<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
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
if(isset($_POST['cod_carrera18']) && $_POST['cod_carrera18']<> ' '){
  $array=$_POST['cod_carrera18'];
  if(!empty($array)){
  Cerradormasivo($array);
}
  $_POST['cod_carrera18']='';
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechasistema=fechaymd($_POST["fecha"]);
    $fecha=$_POST["fecha"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\admin\admin_apertura_lista.php - QUERY 1 */ SELECT * FROM carrera 
	WHERE  
	carrera.fec_carrera = %s AND (carrera.eje_primero=0 OR carrera.pau_pagos=1 OR carrera.pau_ventas=1)
	ORDER BY  carrera.est_cierre ASC, carrera.est_carrera ASC, carrera.hor_carrera ASC, carrera.nom_hipodromo ASC, carrera.num_carrera ASC",
    GetSQLValueString($fechasistema, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
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
$query_Recordset3 = sprintf("/* PARSEADORES1 new\admin\admin_apertura_lista.php - QUERY 2 */ SELECT * FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame =1");
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$cod_control=$row_Recordset3['cod_ctrol_ventpag_global_ame'];
$est_control_ventas=$row_Recordset3['est_control_ventas_ame'];
$est_control_pagos=$row_Recordset3['est_control_pagos_ame'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>

<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#FC6" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<script type="text/javascript">
function cStatus(id, cCar, nHip) {
  if (id==0) modo=" modo MANUAL?";
  if (id==1) modo=" 1 opcion 1?";
  if (id==2) modo=" 2 opcion 2?";
  if (id==3) modo=" 3 opcion 3?";
  if (id==4) modo=" 4 opcion 4?";
  if (id==5) modo=" 5 opcion 5?";
  if (id==6) modo=" 6 opcion 6?";
  if (id==7) modo=" 7 opcion 7?";
  if (id==8) modo=" WATCHANDWAGER?";
  if (id==9) modo=" BUILDABET2?";
  if (id>=0 && id<=9) {

		swal({
		  title: nHip,
		  text: '¿Seguro de cambiar Carrera a'+modo,
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
				var parametros = { "codCar":cCar, "modo":id, "rA":Math.random() };
				$.ajax({ data:parametros, url:'../includes/man_aut_carr.php', type:'post',
					success:function (response) { 
						$("#hipodromo").html(response);
						window.location='admin_apertura_lista.php';
					}
				});
			} else {
				window.location='admin_apertura_lista.php';
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
.text { font-size:28px;font-family:helvetica;font-weight:bold;}
.parpadea { animation-name: parpadeo;animation-duration: 2s;animation-timing-function: linear;animation-iteration-count: infinite; -webkit-animation-name:parpadeo; -webkit-animation-duration: 2s; -webkit-animation-timing-function: linear;
-webkit-animation-iteration-count: infinite;}
@-moz-keyframes parpadeo{  
  0% { opacity: 1.0; }
  50% { opacity: 0.0; }
  100% { opacity: 1.0; }
}
@-webkit-keyframes parpadeo {  
  0% { opacity: 1.0; }
  50% { opacity: 0.0; }
   100% { opacity: 1.0; }
}
@keyframes parpadeo {  
  0% { opacity: 1.0; }
   50% { opacity: 0.0; }
  100% { opacity: 1.0; }
}
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
<link rel="stylesheet" type="text/css" href="../css/bootstrap2.3.2-combined.min.css"/>
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
				alertify.error('<font size="4">Acción cancelada!</font>');
			}
				 
		});	
	}
  function Confirmar(e){
var mensaje = "¿DESEA CANCELAR LAS CARRERAS SELECCIONADAS?";

    if (!confirm(mensaje)){
    e.preventDefault();
}}
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
				alertify.error('<font size="4">Acción cancelada!</font>');
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
<link href='../css/font-awesome4.0.3.css' rel='stylesheet'/>
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
  	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
           
        <div hidden>
        <a href="admin_apertura_add_auto_buildtvg.php" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:150px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #C90;
                text-decoration:none;" title="crear carreras desde racebets automáticamente">
                 Apertura<br/> BuildABet2/TVG
            </a>
            
            <a href="admin_apertura_add_auto_tvg.php" class="btn alert-success" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #0CF;
                text-decoration:none; " title="crear carreras desde tvg automáticamente">
                 Apertura<br/> TVG
            </a>
            </div> 
            <a href="admin_apertura_add_auto_twin.php" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #D8FF00;
                text-decoration:none;" title="crear carreras desde Twinspires automáticamente">
                 Apertura<br/> Twinspires
            </a>
            <a href="admin_apertura_add_auto_buildabet2.php" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear carreras desde racebets automáticamente">
                 Apertura<br/> BuildABet2
            </a>
            <a href="../admin/admin_apertura_multiple.php" class="btn alert-success" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #FC0;
                text-decoration:none; " title="crear varias carreras por hipódromo manualmente">
                 Apertura <br/>Múltiple
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
          Cantidad de carreras:  <?php echo $totalRows_Recordset1 ?>
        </td>
        </tr>
    </table>
    <?php if ($totalRows_Recordset1>=1) { ?>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form18" id="form18" autocomplete="off">
	<div id="detVentaPago" style="height:100%; padding:4px 0px 4px 0px; font-size:14px; font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
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
              
              <td width="25%" >Cancelar Carreras Seleccionadas:<br/><input type="submit"  style="font-size:12px; height:45px;" onclick="Confirmar(event)" class="btn btn-danger" value="Cancelar Carreras" /></td>
            </tr>

            
            </tbody>
		</table>
   </div>
  <div style="height:100%; padding:0px 0px 90px 0px;">
  
  
  <table width="100%" border="0" align="center" cellpadding="0">
  <tr style="background:#5EAEFF; color:#FFFFFF; height:30px; font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
   
    
    <td width="28"></td>
    <td colspan="2" valign="bottom">HIPÓDROMO</td>
    <td width="35" style="font-size:8px" valign="bottom">CORREN INSCRITOS</td>
    <td width="117" valign="bottom">STATUS</td>
    <td width="43" valign="bottom">MTP</td>
    <td colspan="7" valign="bottom" style="font-size:18px">ACCIONES</td>
    <td style="font-size:10px" valign="bottom">Ventas</td>
    <td style="font-size:10px" valign="bottom">Pagos</td>
    <td  ></td>
    </tr>
  <?php do {
    if ($row_Recordset1['eje_primero']==0 && $row_Recordset1['eje_segundo']==0 && $row_Recordset1['eje_tercero']==0 &&
        $row_Recordset1['div_primero_gan']==0 && $row_Recordset1['div_primero_pla']==0 &&
        $row_Recordset1['div_primero_sho']==0 && $row_Recordset1['div_segundo_pla']==0 &&
        $row_Recordset1['div_segundo_sho']==0 && $row_Recordset1['div_tercero_sho']==0) {
        $tView=0;
    } else {
        $tView=1;
    }
    $van=$row_Recordset1['can_caballos'];
    $corrent=$row_Recordset1['can_caballos']-cantRetirados($row_Recordset1['cod_carrera']);
    if ($row_Recordset1['mtp_control']==0) {
        $carrA='<font color="red">'.$row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera'].'</font>';
    } else {
        $carrA='<font color="green">'.$row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera'].'</font>';
    } ?>
  <tr bgcolor="#FFFFFF" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"; style="font-size:14px;border-bottom: 1px solid #C1BDBE;">
	
  <td>
  
    <?php if ($row_Recordset1['est_carrera']!=0) {?>
        <a title="cerrar carrera" onclick='accionCerrar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Seguro de CERRAR LA CARRERA?","<?php echo $row_Recordset1['cod_carrera']; ?>")'
            href='#'>
            <i class="fa fa-lock fa-2x"></i>    
        </a>        
    <?php } ?>    
    </td>
        
    <td width="211" align="left" style="font-size:14px">
		<?php
    echo '<strong>'.$carrA.'</strong></br>';
if($row_Recordset1['simulcast']==0){

        
         echo 'ABI '; echo substr($row_Recordset1['ABIERTOX'], 0, 4); echo ' - ';
         echo 'CER '; echo substr($row_Recordset1['CERRADOX'], 0, 4); ?>
         <a href="#myModal" data-toggle="modal" onclick="detalle_ticket(<?php echo $row_Recordset1['cod_carrera']; ?>); return false">
         <?php echo ' # '; 
if ($row_Recordset1['contador_cierres']>='10') {
  $cierres='<font color="red">'.$row_Recordset1['contador_cierres'].' VF</font>';
} else {
  $cierres='<font color="green">'.$row_Recordset1['contador_cierres'].'</font>';
} 
echo $cierres;
} else {  echo 'simulcast';  }

?></a>
<?php
    $vepa="";
    if ($row_Recordset1['pau_pagos']==1 && $row_Recordset1['pau_ventas']==0) {
        $vepa="&nbsp;&nbsp;(PAGOS PAUSADOS)";
    } elseif ($row_Recordset1['pau_pagos']==0 && $row_Recordset1['pau_ventas']==1) {
        $vepa="&nbsp;&nbsp;(VENTAS PAUSADAS)";
    } elseif ($row_Recordset1['pau_pagos']==1 && $row_Recordset1['pau_ventas']==1) {
        $vepa="&nbsp;&nbsp;(VENTAS Y PAGOS PAUSAD0S)";
    }
    echo '<font color="red"  style="font-size:10px;"><br/>'.$vepa.'</font>' ; ?>
	</td>
  
    <td align="center" width="51">
<?php
      if ($tView==0) {?>
		<button type="button" style="font-size:20px; width:40px; height:40px; text-align:center; text-decoration:none;" 
		class="btn btn-danger" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de AUMENTAR 1 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera']; ?>",1,"info",1)'>
        	+1
		</button>
<?php
      } ?>       
	</td>
    <?php
    $status="";
    if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==3) {
        $status="<font color=\"gray\">EN ESPERA</font>";
    }
    if ($row_Recordset1['est_carrera']==0 && $row_Recordset1['est_cierre']==1) {
        $status="<font color=\"red\">CERRADA (AUT)</font>";
    }
    if ($row_Recordset1['est_carrera']==0 && $row_Recordset1['est_cierre']==0) {
        $status="<font color=\"red\">CERRADA (MAN)</font>";
    }
    if ($row_Recordset1['hor_carrera']>horaactual2() && $row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2) {
        $status="<font color=\"green\">ABIERTA</font>";
    }
    if ($row_Recordset1['hor_carrera']<=horaactual2() && $row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2) {
        $status="<font color=\"orange\">PRE-CERRADA</font>";
    } ?>
    <td align="center" style="font-size:18px">
		<?php
        if ($corrent<=3) {
            echo '<font color="red">'.$corrent.'</font>'; echo '/'.$van;
        } else {
            echo $corrent.'/'.$van;
        } ?>
    </td>
    <td align="center">
		<?php echo $status; ?><br/>
        <span style="font-size:10px"><?php echo horaampm($row_Recordset1['hor_carrera']); ?></span>
    </td>
    
    <td align="right" style="font-size:12px"><?php
        if ($row_Recordset1['hor_carrera']>horaactual2()) {
            echo restahoraRB(horaactual2(), $row_Recordset1['hor_carrera']);
        } ?>
  <td width="155" align="center" valign="middle"><?php
      if ($tView==0) {?>
      <select name="mtp_control" class="alert-success2"  style="width:155px; height:32px; font-size:12px; margin:1px 0px 0px 0px" tabindex="4" 
        	onchange="cStatus(this.value, <?php echo $row_Recordset1['cod_carrera'] ?>, '<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>')"> 
        <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">MANUAL</option>
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">1 opcion 1</option>
        <option value="2" <?php if (!(strcmp(2, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">2 opcion 2</option>
        <option value="3" <?php if (!(strcmp(3, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">3 opcion 3</option>
        <option value="4" <?php if (!(strcmp(4, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">4 opcion 4</option>
        <option value="5" <?php if (!(strcmp(5, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">5 opcion 5</option>
        <option value="6" <?php if (!(strcmp(6, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">6 opcion 6</option>
        <option value="7" <?php if (!(strcmp(7, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">7 opcion 7</option>
        <option value="8" <?php if (!(strcmp(8, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">WATCHANDWAGER</option>  
       <option value="9" <?php if (!(strcmp(9, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
          echo "SELECTED";
      } ?> style="background:#000;color:#CCC">BUILDABET2</option>    
 </select><?php
      } ?>
    </td>
    <td width="26" align="center"><?php
      if ($tView==0) {?>
      <a title="" onclick='accionCancelar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de CANCELAR LA CARRERA?","<?php echo $row_Recordset1['cod_carrera']; ?>")'
            href='#'>
        <i class="fa fa-times-circle fa-2x"></i>    
        </a><?php
      } ?>        
    </td>
    <td width="28" align="center"><?php
      if ($tView==0) {?>
		<a title="editar carrera" href="admin_apertura_edit.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>">
        <i class="fa fa-pencil fa-2x"></i></a><?php
      } ?>    
    </td>
    <td width="26" align="center"><?php
      if ($tView==0) {?>
        <a title="" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de AUMENTAR 10 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera']; ?>",10,"info",0)'
            href='#'>
            <i class="fa fa-2x"><strong>10</strong></i>    
        </a><?php
      } ?>        
    </td>
    <td width="26" align="center"><?php
      if ($tView==0) {?>
        <a title="" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de AUMENTAR 5 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera']; ?>",5,"info",0)'
            href='#'>
            <i class="fa fa-2x"><strong>5</strong></i>    
        </a><?php
      } ?>        
    </td>
    <td width="27" align="center"><?php
      if ($tView==0) {?>
        <a title="" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de AUMENTAR 2 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera']; ?>",2,"info",0)'
            href='#'>
            <i class="fa fa-2x"><strong>2</strong></i>    
        </a><?php
      } ?>        
    </td>
    <td width="27" align="center">
    <?php
    if ($row_Recordset1['hor_carrera']>horaactual2() && $tView==0) {?>
        <a title="" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de DISMINUIR 2 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera']; ?>",-2,"warning",0)'
            href='#'>
            <i class="fa fa-2x"><strong>-2</strong></i>    
        </a>        
    <?php } ?>
    </td>
    <td width="38" align="center"><?php

        if ($row_Recordset1['pau_ventas']==0) {
            $titPago="&nbsp;PAUSAR ventas a ".$row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera'];
            $icon="<i class='fa fa-pause fa-lg'></i>";
            $menV="¿Está seguro de PAUSAR VENTAS a esta carrera?";
            $class="btn btn-info";
        } else {
            $titPago="&nbsp;REANUDAR ventas a ".$row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera'];
            $icon="<i class='fa fa-play fa-lg'></i>";
            $menV="¿Está seguro de REANUDAR VENTAS a esta carrera?";
            $class="btn btn-warning";
        } ?>
        <a onclick='accionPausar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","<?php echo $menV; ?>","<?php echo $row_Recordset1['cod_carrera']; ?>","<?php echo $row_Recordset1['pau_ventas']; ?>","warning","V")' href='#' class="<?php echo $class; ?>" style="height:70%; padding:8px" title="<?php echo $titPago; ?>">
            <?php echo $icon; ?>
        </a>        
    </td>
    <td width="38" align="center"><?php
        if ($row_Recordset1['pau_pagos']==0) {
            $titPago="&nbsp;PAUSAR pagar tickets a ".$row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera'];
            $icon="<i class='fa fa-pause fa-lg'></i>";
            $menP="¿Está seguro de PAUSAR PAGOS a esta carrera?";
            $class="btn btn-info";
        } else {
            $titPago="&nbsp;REANUDAR pagar tickets a ".$row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera'];
            $icon="<i class='fa fa-play fa-lg'></i>";
            $menP="¿Está seguro de REANUDAR PAGOS a esta carrera?";
            $class="btn btn-warning";
        } ?>
        <a onclick='accionPausar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","<?php echo $menP; ?>","<?php echo $row_Recordset1['cod_carrera']; ?>","<?php echo $row_Recordset1['pau_pagos']; ?>","warning","P")' href='#' class="<?php echo $class; ?>" style="height:70%; padding:8px" title="<?php echo $titPago; ?>">
            <?php echo $icon; ?>
        </a>        
    </td>
    <td width="28"><input type="checkbox" name="cod_carrera18[]" value="<?php echo $row_Recordset1['cod_carrera']; ?>"></td>
  </tr>
  <?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    </table>
    </div>
    </form>
    <?php } else {?>
          <table width="100%" border="0" align="center" cellpadding="0">
          <tr style="background:#5EAEFF; color:#FFFFFF; height:30px; font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
            <td width="45"></td>
            <td colspan="2" valign="bottom">HIPÓDROMO</td>
            <td width="40" style="font-size:8px" valign="bottom">CORREN</td>
            <td width="115" valign="bottom">STATUS</td>
            <td width="47" valign="bottom">MTP</td>
            <td colspan="7" valign="bottom" style="font-size:18px">ACCIONES</td>
            <td width="38" valign="bottom" style="font-size:10px">Ventas</td>
            <td width="38" valign="bottom" style="font-size:10px">Pagos</td>
            </tr>
        </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
	<?php }?>    
  </div>
  <input type="hidden" name="cod_control" id="cod_control" value="<?php echo $cod_control; ?>" />
  <input type="hidden" name="est_control_ventas" id="est_control_ventas" value="<?php echo $est_control_ventas; ?>" />
  <input type="hidden" name="est_control_pagos" id="est_control_pagos" value="<?php echo $est_control_pagos; ?>" />
  <div id="hipodromo" style="background:#F9E209"></div>
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
</div>


<!-- Button trigger modal -->
<script>
  $('#myModal').modal('show');
  alert('show222');
    function detalle_ticket(cod_carrera){
      
        $.post("qabreqcierra.php", 
        {
          cod_carrera:cod_carrera
		},
        function(eData){				
            $("#dialog-message").html(eData);
        });	
       
    } 
    
</script>






<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">QUIEN ABRIO QUIEN CERRO</h3>
  </div>
  <div class="modal-body">
  <div id="dialog-message"></div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">CERRAR</button>

  </div>
</div>


<script src="../js/bootstrap2.3.2.min.js"></script>
<script src="../modal/js/functions.js"></script>
<script src="../modal/js/sweetalert.min.js"></script>
<link href="../css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../js/bootstrap-toggle.min.js"></script>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
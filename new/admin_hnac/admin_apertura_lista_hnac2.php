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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechasistema=fechaymd($_POST["fecha"]);
    $fecha=$_POST["fecha"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\admin_hnac\admin_apertura_lista_hnac2.php - QUERY 1 */ SELECT 
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
	hipodromo_hnac.nom_hipodromo_hnac
	FROM 
	carrera_hnac, 
	hipodromo_hnac 
	WHERE 
	carrera_hnac.est_confirmacion_hnac=0 AND
	carrera_hnac.cod_hipodromo_hnac=hipodromo_hnac.cod_hipodromo_hnac AND
	carrera_hnac.fec_carrera_hnac = %s 
	ORDER BY carrera_hnac.num_carrera_hnac ASC",
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#FFFFDD" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
function cStatus(id, cCar) {
	if (id==0) modo=" MANUAL?";
	if (id==1) modo=" AUTOMÁTICO?";
	confirma = confirm('¿Desea cambiar Carrera a modo'+modo);
	if(confirma==true){
		var rA=Math.random();
		var parametros = { "codCar":cCar, "modo":id, "rA":Math.random() };
		$.ajax({ data:parametros, url:'../includes/man_aut_carr_hnac.php', type:'post',
			success:function (response) { 
				$("#hipodromo").html(response);
				window.location='admin_apertura_lista_hnac2.php';
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
						$("#hipodromo").html(response);
						window.location='admin_apertura_lista_hnac2.php';
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
						$("#hipodromo").html(response);
						window.location='admin_apertura_lista_hnac2.php';
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
						$("#hipodromo").html(response);
						window.location='admin_apertura_lista_hnac2.php';
					}
				});
			} else {
				alertify.error('<font size="4">Aumento de tiempo cancelado!</font>');
			}
		});	
	}
</script>
<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
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
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:34px"/>
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
  <div style="height:100%; padding:0px 0px 90px 0px ">  
  <table width="100%" border="2" align="center" bordercolor="#0E5157">
  <tr style="background:#0E5157; color:#FFFFFF; height:30px">
    <td width="43"></td>
    <td>HIPÓDROMO</td>
    <td width="36" style="font-size:8px">CORREN</td>
    <td width="151">STATUS</td>
    <td width="61" >MTP</td>
    <td colspan="6">&nbsp;</td>
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
  <tr bgcolor="#FFFFFF" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"; style="font-size:14px">
    <td>
      <?php if ($row_Recordset1['est_carrera_hnac']!=0) {?>
        <a title="cerrar carrera" onclick='accionCerrar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Seguro de CERRAR LA CARRERA?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>")'
            href='#'>
            <i class="fa fa-lock fa-3x"></i>    
        </a>        
        
      <?php } ?>    
      </td>
    
    <td width="213" align="left"><strong><?php echo $carrA; ?></strong></td>
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
      if ($row_Recordset1['hor_carrera_hnac']<=horaactual2() && $row_Recordset1['est_carrera_hnac']==5 && $row_Recordset1['est_cierre_hnac']==5) {
          $status="<font color=\"orange\">PRE-CERRADA</font>";
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
    <td width="126" align="center" valign="bottom" style="color:#090">
      <select name="mtp_control"  style="width:122px; height:30px; font-size:13px;" tabindex="4" disabled="disabled"
        	onchange="cStatus(this.value, <?php echo $row_Recordset1['cod_carrera_hnac'] ?>)"> 
        <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?> style="color:#CC0000">MANUAL</option>
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['mtp_control_hnac'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?> style="color:#090">AUTOMATICO</option>
        </select>
      </td>
    <td width="48" align="center">
        <a title="" onclick='accionCancelar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Está seguro de CANCELAR LA CARRERA?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>")'
            href='#'>
            <i class="fa fa-times-circle fa-3x"></i>    
        </a>        
      </td>
    <td width="48" align="center">
    <a title="editar carrera" href="admin_apertura_edit_hnac.php?recordID=<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">		
    	<i class="fa fa-pencil fa-2x"></i>
    </a>
    </td>
    <td width="48" align="center">
        <a title="reabrir &#189; minuto" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Está seguro de AUMENTAR &#189; MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",0.5,"info")'
            href='#'>
            <i class="fa fa-3x"><strong>&#189;</strong></i>    
        </a>        
      </td>
    <td width="48" align="center">
        <a title="reabrir 1 minuto" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Está seguro de AUMENTAR 1 MINUTO a la carrera?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",1,"info")'
            href='#'>
            <i class="fa fa-3x"><strong>1</strong></i>    
        </a>        
      </td>
    <td width="48" align="center">
        <a title="reabrir 2 minutos" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo_hnac'].': ...'.$row_Recordset1['num_carrera_hnac']; ?>","¿Está seguro de AUMENTAR 2 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",2,"info")'
            href='#'>
            <i class="fa fa-3x"><strong>2</strong></i>    
        </a>        
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
  </tr>
  <?php
    $k++;
  } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    </table>
    </div>
    <?php } else {?>
		<table width="100%" border="1" align="center" bordercolor="#0E5157">
            <tr style="background:#0E5157; color:#FFFFFF; height:30px">
                <td width="43"></td>
                <td width="213">HIPÓDROMO</td>
                <td width="36" style="font-size:8px">CORREN</td>
                <td width="151">STATUS</td>
                <td width="61" >MTP</td>
                <td width="396" colspan="6">&nbsp;</td>
            </tr>
        </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
	<?php }?>    
  </div> 
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
<script src="../modal/js/bootstrap.min.js"></script>
<script src="../modal/js/functions.js"></script>
<script src="../modal/js/sweetalert.min.js"></script>  
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
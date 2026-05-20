<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$maxRows_Recordset1 = 1000;
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
    "/* PARSEADORES1 new\includes\admin_apertura_lista.php - QUERY 1 */ SELECT * FROM carrera 
	WHERE  
	carrera.eje_primero=0 AND 
	carrera.eje_segundo=0 AND 
	carrera.eje_tercero=0 AND 
	carrera.div_primero_gan=0 AND 
	carrera.div_primero_pla=0 AND 
	carrera.div_primero_sho=0 AND 
	carrera.div_segundo_pla=0 AND 
	carrera.div_segundo_sho=0 AND  
	carrera.div_tercero_sho=0 AND  
	carrera.fec_carrera = %s 
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
	if (id==1) modo=" MTP EQUIBASE?";
	if (id==2) modo=" MTP TRACK INFO?";
	if (id==3) modo=" MTP BUILDABET2?";
	if (id==4) modo=" MTP BASIC TVG?";
	if (id==5) modo=" MTP HORSEPLAYER?";
	if (id==6) modo=" MTP GREYHOUND?";
	if (id==0 || id==3 || id==5 || id==6) {
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
  	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="admin_apertura_add_auto_buildtvg.php" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:150px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #C90;
                text-decoration:none;" title="crear carreras desde racebets automáticamente">
                 Apertura<br/> BuildABet2/TVG
            </a>
            <a href="admin_apertura_add_auto_buildabet2.php" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear carreras desde racebets automáticamente">
                 Apertura<br/> BuildABet2
            </a>
            <a href="admin_apertura_add_auto_tvg.php" class="btn alert-success" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #0CF;
                text-decoration:none; " title="crear carreras desde tvg automáticamente">
                 Apertura<br/> TVG
            </a>
            <a href="../admin/admin_apertura_multiple.php" class="btn alert-success" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #FC0;
                text-decoration:none; " title="crear varias carreras por hipódromo manualmente">
                 Apertura <br/>Múltiple
            </a>
            <a href="admin_apertura_add.php" class="btn alert-success" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #C6F;
                text-decoration:none; " title="crear carrera manualmente">
                 Apertura <br/>Manual
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
  <div style="height:100%; padding:0px 0px 90px 0px;">  
  <table width="100%" border="1" align="center" cellpadding="0" bordercolor="#F2F2F2">
  <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
    <td width="42"></td>
    <td width="298">HIPÓDROMO</td>
    <td width="37" style="font-size:8px">CORREN</td>
    <td width="119">STATUS</td>
    <td width="67">MTP</td>
    <td colspan="8" style="font-size:18px">ACCIONES</td>
    </tr>
  <?php do {
    $van=$row_Recordset1['can_caballos']-cantRetirados($row_Recordset1['cod_carrera']);
    if ($row_Recordset1['mtp_control']==0) {
        $carrA='<font color="red">'.$row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera'].'</font>';
    } else {
        $carrA='<font color="green">'.$row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera'].'</font>';
    } ?>
  <tr bgcolor="#F2F2F2" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"; style="font-size:14px">
	<td>
    <?php if ($row_Recordset1['est_carrera']!=0) {?>
        <a title="cerrar carrera" onclick='accionCerrar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Seguro de CERRAR LA CARRERA?","<?php echo $row_Recordset1['cod_carrera']; ?>")'
            href='#'>
            <i class="fa fa-lock fa-2x"></i>    
        </a>        
    <?php } ?>    
    </td>
        
    <td align="left"><strong><?php echo $carrA; ?></strong></td>
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
    <td align="center">
		<?php
        if ($van<=3) {
            echo '<font color="red">'.$van.'</font>';
        } else {
            echo $van;
        } ?>
    </td>
    <td align="center">
		<?php echo $status; ?><br/>
        <span style="font-size:10px"><?php echo horaampm($row_Recordset1['hor_carrera']); ?></span>
    </td>
    
    <td align="right"><?php
        if ($row_Recordset1['hor_carrera']>horaactual2()) {
            echo restahoraRB(horaactual2(), $row_Recordset1['hor_carrera']);
        } ?>
    </td>
    <td width="127" align="center" valign="middle">
      <select name="mtp_control" class="alert-success2"  style="width:155px; height:32px; font-size:12px; margin:1px 0px 0px 0px" tabindex="4" 
        	onchange="cStatus(this.value, <?php echo $row_Recordset1['cod_carrera'] ?>, '<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>')"> 
        <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?> style="background:#000;color:#CCC">MANUAL</option>
        <option value="3" <?php if (!(strcmp(3, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?> style="background:#000;color:#CCC">BUILDABET2</option>
        <option value="4" <?php if (!(strcmp(4, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?> style="background:#000;color:#CCC">BASICTVG</option>
        <option value="5" <?php if (!(strcmp(5, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?> style="background:#000;color:#CCC">WATCHANDWAGER</option>
        <option value="6" <?php if (!(strcmp(6, htmlentities($row_Recordset1['mtp_control'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?> style="background:#000;color:#CCC">GREYHOUND</option>
      </select>
    </td>
    <td width="30" align="center">
        <a title="" onclick='accionCancelar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de CANCELAR LA CARRERA?","<?php echo $row_Recordset1['cod_carrera']; ?>")'
            href='#'>
            <i class="fa fa-times-circle fa-2x"></i>    
        </a>        
    </td>
    <td width="36" align="center">
		<a title="editar carrera" href="admin_apertura_edit.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>">
        <i class="fa fa-pencil fa-2x"></i></a>    
    </td>
    <td width="1" align="center" style="background:#CCC"></td>
    <td width="30" align="center">
        <a title="" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de AUMENTAR 10 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera']; ?>",10,"info")'
            href='#'>
            <i class="fa fa-2x"><strong>10</strong></i>    
        </a>        
    </td>
    <td width="30" align="center">
        <a title="" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de AUMENTAR 5 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera']; ?>",5,"info")'
            href='#'>
            <i class="fa fa-2x"><strong>5</strong></i>    
        </a>        
    </td>
    <td width="30" align="center">
        <a title="" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de AUMENTAR 2 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera']; ?>",2,"info")'
            href='#'>
            <i class="fa fa-2x"><strong>2</strong></i>    
        </a>        
    </td>
    <td width="37" align="center">
    <?php
    if ($row_Recordset1['hor_carrera']>horaactual2()) {?>
        <a title="" onclick='accionAumentar("<?php echo $row_Recordset1['nom_hipodromo'].': ...'.$row_Recordset1['num_carrera']; ?>","¿Está seguro de DISMINUIR 2 MINUTOS a la carrera?","<?php echo $row_Recordset1['cod_carrera']; ?>",-2,"warning")'
            href='#'>
            <i class="fa fa-2x"><strong>-2</strong></i>    
        </a>        
           
    <?php } ?>
    </td>
  </tr>
  <?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    </table>
    </div>
    <?php } else {?>
        <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
            <td width="30"></td>
            <td width="350">HIPÓDROMO</td>
            <td width="18" style="font-size:8px">CORREN</td>
            <td width="112">STATUS</td>
            <td width="90">FECHA</td>
            <td width="61" style="font-size:12px">HORA CIERRE</td>
            <td colspan="6">&nbsp;</td>
          </tr>
        </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
	<?php }?>    
  </div> 
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
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
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$query_Recordset1 =  sprintf("/* PARSEADORES1 admin_lot\admin_sorteos_lista_lot.php - QUERY 1 */ SELECT 
		so.id_sorteo, so.nom_sorteo, so.est_sorteo, so.hor_sorteo,
		so.lun, so.mar, so.mie, so.jue, so.vie, so.sab, so.dom,
		CASE so.est_sorteo  
			WHEN 0 THEN '<font color=red>INACTIVO</font>'
			WHEN 1 THEN 'ACTIVO'
			ELSE 'NO DEFINIDO'
		END AS estado,
		GROUP_CONCAT(nom_loteria
					ORDER BY let_loteria, nom_loteria ASC
					SEPARATOR ']  [') AS loterias
	FROM 
	sorteos so
	LEFT JOIN loterias lo ON (lo.id_sorteo = so.id_sorteo AND lo.tip_loteria!=2)
	WHERE so.id_sorteo > 1
	GROUP BY id_sorteo
	ORDER BY so.est_sorteo DESC, so.nom_sorteo ASC");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
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
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script></script><script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
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
              Lista de Sorteos<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 10px 10px; float:right;">
            <a href="admin_sorteos_add_lot.php" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nueva taquilla">
                Añadir Nuevo Sorteo
            </a>
        </div>
          <?php if ($totalRows_Recordset1>0) {?>
    <div style="height:100%; padding:0px 0px 200px 0px ">   
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  		<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
  		  <td height="37">&nbsp;</td>
  		  <td colspan="7" align="center" valign="bottom" style="font-size:18px">DIAS DE SORTEO</td>
  		  <td>&nbsp;</td>
  		  <td>&nbsp;</td>
  		  <td >&nbsp;</td>
		  </tr>
  		<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;" valign="bottom">
	<td width="407">NOMBRE</td>
	<td width="33" style="font-size:14px" align="center">LUN</td>
	<td width="33" style="font-size:14px" align="center">MAR</td>
	<td width="33" style="font-size:14px" align="center">MIE</td>
	<td width="33" style="font-size:14px" align="center">JUE</td>
	<td width="33" style="font-size:14px" align="center">VIE</td>
	<td width="33" style="font-size:14px" align="center">SAB</td>
	<td width="33" style="font-size:14px" align="center">DOM</td>
    <td width="116">CIERRE</td>
    <td width="116">STATUS</td>
    <td >ACCION</td>
  </tr>
  <?php do { ?>
    <tr class="brillo" style="border-bottom:1px solid  #D5D5D5; font-size:14px" valign="middle">
      <td align="left" style="line-height:1.1;">
		<?php
        if ($row_Recordset1['loterias']!="") {
            $row_Recordset1['loterias']="[".$row_Recordset1['loterias']."]";
        }
        echo "<strong>".$row_Recordset1['nom_sorteo']."</strong>";
        echo "<br/><div style='width:380px;letter-spacing:-0.5px'><font face='times new roman' size=1.5>";
        echo $row_Recordset1['loterias']."</font></div>";?>
        </td>
      <td align="center">
      	<input type="checkbox" class="textboxsmal" onclick="javascript: return false;" 
			<?php if (!(strcmp(htmlentities($row_Recordset1['lun'], ENT_COMPAT, 'utf-8'), 1))) {
            echo "checked=\"checked\"";
        } ?> />
	  </td>
      <td align="center">
      	<input type="checkbox" class="textboxsmal" onclick="javascript: return false;" 
			<?php if (!(strcmp(htmlentities($row_Recordset1['mar'], ENT_COMPAT, 'utf-8'), 1))) {
            echo "checked=\"checked\"";
        } ?> />
	  </td>
      <td align="center">
      	<input type="checkbox" class="textboxsmal" onclick="javascript: return false;" 
			<?php if (!(strcmp(htmlentities($row_Recordset1['mie'], ENT_COMPAT, 'utf-8'), 1))) {
            echo "checked=\"checked\"";
        } ?> />
	  </td>
      <td align="center">
      	<input type="checkbox" class="textboxsmal" onclick="javascript: return false;" 
			<?php if (!(strcmp(htmlentities($row_Recordset1['jue'], ENT_COMPAT, 'utf-8'), 1))) {
            echo "checked=\"checked\"";
        } ?> />
	  </td>
      <td align="center">
      	<input type="checkbox" class="textboxsmal" onclick="javascript: return false;" 
			<?php if (!(strcmp(htmlentities($row_Recordset1['vie'], ENT_COMPAT, 'utf-8'), 1))) {
            echo "checked=\"checked\"";
        } ?> />
	  </td>
      <td align="center">
      	<input type="checkbox" class="textboxsmal" onclick="javascript: return false;" 
			<?php if (!(strcmp(htmlentities($row_Recordset1['sab'], ENT_COMPAT, 'utf-8'), 1))) {
            echo "checked=\"checked\"";
        } ?> />
	  </td>
      <td align="center">
      	<input type="checkbox" class="textboxsmal" onclick="javascript: return false;" 
			<?php if (!(strcmp(htmlentities($row_Recordset1['dom'], ENT_COMPAT, 'utf-8'), 1))) {
            echo "checked=\"checked\"";
        } ?> />
	  </td>
      <td align="center" valign="middle">
<?php
$hora1=$row_Recordset1['hor_sorteo'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?>








      </td>
      <td align="center" valign="middle"><?php echo $row_Recordset1['estado']; ?></td>
      <td width="94" align="center" valign="middle">
      <a href='admin_sorteos_edit_lot.php?recordID=<?php echo $row_Recordset1['id_sorteo']; ?>'
      	class="btn btn-info" style="text-decoration:none;height:12px;font-size:11px; padding:1px 0 6px 0; width:60px"> 
      	EDITAR 
      </a>
      </td>
    </tr>
<?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
  		<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;" valign="bottom">
        <td height="10" colspan="11">&nbsp;</td>
        </tr>
   </table>
      </div>
       <?php } else {?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  		<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
  		  <td height="37">&nbsp;</td>
  		  <td colspan="7" align="center" valign="bottom" style="font-size:18px">DIAS DE SORTEO</td>
  		  <td>&nbsp;</td>
  		  <td>&nbsp;</td>
  		  <td >&nbsp;</td>
		  </tr>
  		<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;" valign="bottom">
        <td width="407">NOMBRE</td>
        <td width="33" style="font-size:14px" align="center">LUN</td>
        <td width="33" style="font-size:14px" align="center">MAR</td>
        <td width="33" style="font-size:14px" align="center">MIE</td>
        <td width="33" style="font-size:14px" align="center">JUE</td>
        <td width="33" style="font-size:14px" align="center">VIE</td>
        <td width="33" style="font-size:14px" align="center">SAB</td>
        <td width="33" style="font-size:14px" align="center">DOM</td>
        <td width="116">CIERRE</td>
        <td width="116">STATUS</td>
        <td >ACCIONES</td>
      </tr>
      </table>
		<div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
   
      <?php }?>  
</div>
  </div>
  <div class="footer" style="background:#0084B4">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
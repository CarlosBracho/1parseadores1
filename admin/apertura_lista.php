<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$maxRows_Recordset1 = 10000;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$horaactual=horaactual();
$fechasistema=fechaactualbd();

$query_Recordset1 = sprintf("/* PARSEADORES1 admin\apertura_lista.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.eje_primero=0 AND carrera.eje_segundo=0 AND carrera.eje_tercero=0 AND carrera.div_primero_gan=0 AND carrera.div_primero_pla=0 AND carrera.div_primero_sho=0 AND carrera.div_segundo_pla=0 AND carrera.div_segundo_sho=0 AND  carrera.div_tercero_sho=0 AND carrera.fec_carrera = %s ORDER BY carrera.hor_carrera ASC", GetSQLValueString($fechasistema, "date"));
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
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#FFFFDD" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
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
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<!-- InstanceBeginEditable name="aHead" -->
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceraadmin.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
               Apertura y cierre de Carreras <br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px; padding:0px 0px 0px 0px ">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="apertura_add.php" class="btn alert-success" 
            	style="font-size:24px; width:270px; height:30px; padding:10px 0px 0px 0px; text-align:center ">
                 Apertura de Carreras
            </a>
        </div>
    <?php if ($totalRows_Recordset1>=1) { ?>
    
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px" >
      <tr>
        <td width="519" align="right">
          Cantidad de carreras:  <?php echo $totalRows_Recordset1 ?></td>
        </tr>
    </table>
  <div style="height:100%; padding:0px 0px 90px 0px ">  
  <table width="100%" border="1" align="center" bordercolor="#F4F4F4">
  <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
    <td width="428">HIPÓDROMO</td>
    <td width="102">STATUS</td>
    <td width="95">FECHA</td>
    <td width="61">HORA CIERRE</td>
    <td width="92">MTP</td>
    <td colspan="4">ACCIONES</td>
  </tr>
  <?php do { ?>
  <tr bgcolor="#FFFFFF" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"; style="font-size:14px">
    <td align="left"><?php echo ObtenerNombreynumeroJugadaCarrera($row_Recordset1['cod_carrera']); 
    echo '</br>'.$row_Recordset1['contador_cierres'];
    
    ?></td>
    <?php $statusjugada=ObtenerStatusJugadaCarrera($row_Recordset1['cod_carrera']);
    if ($row_Recordset1['hor_carrera']>horaactual2()) {
        $status="<font color=\"green\">ABIERTA</font>";
    } else {
        if ($row_Recordset1['est_carrera']==1) {
            $status="<font color=\"orange\">PRE-CERRADA</font>";
        } else {
            $status="<font color=\"red\">CERRADA</font>";
        }
    } ?>
    <td align="center"><?php echo $status; ?></td>
    <td align="center"><?php echo fechanueva($row_Recordset1['fec_carrera']); ?></td>
    <td align="center"><?php echo horaampm($row_Recordset1['hor_carrera']); ?></td>
    <td align="center"><?php echo horaampm($row_Recordset1['hor_mtp']); ?></td>
    
    <td width="25" align="center"><a title="editar carrera" href="apertura_edit.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>"><img src="../images/edit.png" width="24" height="24" /></a></td>
    
    <td width="25" align="center"><a title="cerrar carrera" href="apertura_cierre.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>"><img src="../images/flag-icon.png" width="24" height="24" /></a></td>
    <td width="24" align="center"><a  title="reabrir 2 minutos" href="apertura_reabrir.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>"><img src="../images/two.png" width="24" height="24" /></a></td>
    <td width="26" align="center"><a title="reabrir 1 minuto" href="apertura_reabrir2.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>"><img src="../images/one.png" width="24" height="24" /></a></td>
  </tr>
  <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    </table>
    </div>
    <?php } else {?>
        <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
            <td width="428">HIPÓDROMO</td>
            <td width="102">STATUS</td>
            <td width="95">FECHA</td>
            <td width="61">HORA CIERRE</td>
            <td width="92">MTP</td>
            <td colspan="4">ACCIONES</td>
          </tr>
        </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
	<?php }?>    
  </div>  
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>
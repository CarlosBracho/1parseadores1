<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xReabrirCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xReabrirCarrera_Recordset1 = $_GET["recordID"];
}

$query_Recordset1 = sprintf("/* PARSEADORES1 admin\apertura_reabrir.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", GetSQLValueString($xReabrirCarrera_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$statuscarrera=1;
$hora = horaactual2();
$min = "00:02:00";
$horaapertura=SumaHoras($hora, $min);
$updateSQL = sprintf(
    "/* PARSEADORES1 admin\apertura_reabrir.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s WHERE cod_carrera=%s",
    GetSQLValueString($horaapertura, "date"),
    GetSQLValueString($horaapertura, "date"),
    GetSQLValueString($statuscarrera, "int"),
    GetSQLValueString($xReabrirCarrera_Recordset1, "int")
);
$Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
$updateGoTo = "apertura_lista.php";
if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
}
header(sprintf("Location: %s", $updateGoTo));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
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
                Administracion <br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
<br class="lineainicio">
    <table width="740" border="0">
  <tr>
    <td width="24" height="41">&nbsp;</td>
    <td width="371" class="mostrarusuario"><img src="../images/Administrator-icon2.png" alt="" width="36" height="36" /><strong>Usuario:<?php echo "  ".  $_SESSION['MM_nom_uadmin']; ?></strong></td>
    <td width="347" class="sitiousuario"><strong>Apertura y Cierre</strong></td>
  </tr>
</table>
    <table width="756" border="0">
      <tr>
        <td width="26" height="29">&nbsp;</td>
        <td width="345" align="center" valign="bottom" class="barraaccionusuario"><p><strong><img src="../images/go-back.png" alt="" width="24" height="24" />Reabrir Carrera</strong></p></td>
        <td align="right" class="fechayhora"><?php  echo verfechaactual() ?></td>
      </tr>
    </table>
    <br/>
    <br/>
    <br/>
    <br/>
    <table width="360" border="0" align="center">
  <tr>
    <td rowspan="2"><img src="../images/go-back.png" width="96" height="96" /></td>
    <td align="center" class="veintepunto"><strong>PRECAUCIÓN!</strong></td>
  </tr>
  <tr>
    <td align="center" class="diesiochopunto">Tenga en cuenta que éste procedimineto reabre la carrera por sólo 5 minutos</td>
  </tr>
</table>
    <br/>
    <blockquote>
    </blockquote>
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
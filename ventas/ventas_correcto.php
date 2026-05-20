<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseVentas.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]><script src="../js/src_ie/html5shiv.js"></script><![endif]-->
</head>

<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
    <div class="container">
		<div class="header" style="height:130px; background:#333">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <?php include("../includes/cabeceraventas.php");?>        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:5px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center">
            	TAQUILLA DE VENTAS<br/>
                <!-- InstanceBeginEditable name="nTaquilla" -->
                <?php echo strtoupper(ObtenerNombreTaquilla($_SESSION['MM_cod_taquilla'])); ?>
                <!-- InstanceEndEditable -->
            </div>
             Usuario:
             <!-- InstanceBeginEditable name="nUsuario" --> 
			 <?php echo " ".ObtenerNombreVendedor($_SESSION['MM_id_usuario']); ?> | <?php echo vfechaActual()." | "; ?>
             <!-- InstanceEndEditable -->
             <span id="reloj"></span>
             
        </div>
		<div class="sidebar3">
		</div> <!-- end .sidebar3 -->    
        <div class="content">
			<!-- InstanceBeginEditable name="Contenido" -->
<br class="lineainicio">
    <table width="740" border="0" class="lineauser">
  <tr>
    <td width="24">&nbsp;</td>
    <td width="371" class="mostrarusuario"><strong>Usuario: <?php echo "  ". ObtenerNombreVendedor($_SESSION['MM_id_usuario']); ?></strong></td>
    <td width="347" align="right" class="mostrarusuario"><strong>Taquilla: <?php echo "  ". ObtenerNombreTaquilla($_SESSION['MM_cod_taquilla']); ?></strong></td>
  </tr>
</table>
    <table width="756" height="42" border="0" class="lineauser">
      <tr>
        <td width="10">&nbsp;</td>
        <td width="304" align="left" valign="middle" class="mostrarusuario2"><p><span class="sitiousuario"><strong>Taquilla de Ventas</strong></span></p></td>
        <td width="440" align="right" class="fechayhora"><?php  echo verfechaactual() ?></td>
      </tr>
    </table>
    <br/> <br/>
 <table width="100" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
    <blockquote>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <table width="386" border="0" align="center">
        <tr>
          <td align="center" valign="bottom"><h1>Proceso Exitoso!</h1></td>
        </tr>
        <tr>
          <td align="center"><h2>Juagada  procesada correctamente.
          </h2>
          <p><a href="index.php">Volver a ventas</a></p></td>
        </tr>
      </table>
    </blockquote>
  <!-- InstanceEndEditable -->
            <div class="footer" style="background:#333">
                <?php echo piedepagina(); ?>
            </div><!-- end .footer -->
        </div><!-- end .content -->
    </div><!-- end .container -->
</body>
<!-- InstanceEnd --></html>
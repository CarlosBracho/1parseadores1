<?php
require_once('../Connections/conexionbanca.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>totalsports.co.ve</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
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
                <!-- TemplateBeginEditable name="nTaquilla" -->
                <?php echo strtoupper(ObtenerNombreTaquilla($_SESSION['MM_cod_taquilla'])); ?>
                <!-- TemplateEndEditable -->
            </div>
             Usuario:
             <!-- TemplateBeginEditable name="nUsuario" --> 
			 <?php echo " ".ObtenerNombreVendedor($_SESSION['MM_id_usuario']); ?> | <?php echo vfechaActual()." | "; ?>
             <!-- TemplateEndEditable -->
             <span id="reloj"></span>
             
        </div>
		<div class="sidebar3">
		</div> <!-- end .sidebar3 -->    
        <div class="content">
			<!-- TemplateBeginEditable name="Contenido" -->Contenido<!-- TemplateEndEditable -->
            <div class="footer" style="background:#333">
                <?php echo piedepagina(); ?>
            </div><!-- end .footer -->
        </div><!-- end .content -->
    </div><!-- end .container -->
</body>
</html>
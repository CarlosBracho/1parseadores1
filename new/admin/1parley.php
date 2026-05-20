<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
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
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 140px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceraparley.php");?>
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




  <div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            

            <a href="../parley/adpsinresultados.php" target="_blank" class="btn alert-success" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #0CF;
                text-decoration:none; " title="">
                 Juegos Sin<br/> Resultados
            </a>
            <a href="../parley/adpresultados.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #D8FF00;
                text-decoration:none;" title="">
                 Juegos Con<br/> Resultados
            </a>
            <a href="../parley/equipos.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:success; color: black;
                text-decoration:none;" title="">
                 Lista de<br/> Equipos
            </a>

            <br><br>

	<a href="../parley/logros_ajax.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:yellow;
                text-decoration:none;" title="">
                 Logros del<br/> Dia
            </a>

	
            <a href="http://localhost/new/logrosresultados/subirresultadoswiningbet.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:purple; color: white;
                text-decoration:none;" title="">
                 Subir<br/> Resultados
            </a>

            <a href="../parley/adopcionesparley.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; color: white; background:#269;
                text-decoration:none;" title="">
                 Opciones<br/> Parley
            </a>
            <a href="http://localhost/new/logrosresultados/WiningBetresultadosMejorado.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:18px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:crimson; color: white;
                text-decoration:none;" title="">
                 Actualizar<br/> Resultados
            </a>
            <br><br>
	    <a href="/new/logros/subirwiningbet.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:15px; width:110px; height:55px; padding:5px 0px 0px 0px; text-align:center; background:black; color: white;
                text-decoration:none;" title="">
                 Subir<br/> Logros WiningBet
            </a>
	    <a href="/new/logros/WiningBet.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:15px; width:110px; height:55px; padding:5px 0px 0px 0px; text-align:center; background:black; color: white;
                text-decoration:none;" title="">
                 Actualizar<br/> Logros WiningBet
            </a>
            <a href="../sincronizado/logrosmaradeportes.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:15px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:black; color: white;
                text-decoration:none;" title="">
                 Sincronizados<br/> Maradeportes
            </a>
            <a href="../logrosresultados/sellatuparleyresultado_angel.php" target="_blank" class="btn alert-success" id="crear" name="crear" 
            	style="font-size:15px; width:110px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:orange; color: white;
                text-decoration:none;" title="">
                Resultados<br/> Sella Tu Parley
            </a>

    


  <div style="height:80%; font-size:40px; padding:120px 0px 120px 0px ">
  	Bienvenido al Modulo de Parley!<br><br><br>Seleccione una Opción en el menú
  </div>	
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>

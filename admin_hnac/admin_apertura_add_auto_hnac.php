<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin_hnac.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<script>
$(document).ready(function() {
    programa();
});

	var programa = function() {
    $.ajax({    
        type: "GET",
        url: "../includes/programar_carreras_auto_hnac.php",             
        dataType: "html", 
        success: function(response) {                    
            $(".divprograma").html(response);
        },
		error: function(){ 
			$("#divprograma").html("<div align='center' style='padding:120px 0px 40px 0px;'><h3 style='text-align:center;'>NO HAY RESPUESTA DEL SERVIDOR</h3><h2 style='text-align:center'>Verifique su conexión de internet</h2><br/><br/><a class='btn btn-warning' style='text-decoration:none; font-size:18px; width:150px' href='javascript:location.reload()'>RECARGAR PÁGINA</a></div>");
		}    
	});
};
function crearCarrera(cod, dia) {
		var mError1="<div style='text-align:center;color:#000;background:#FFF;font-size:24px;";
		var mError2="margin:25px 0px 0px 0px;padding:170px 0px 40px 0px;'>";
		var mError3="ERROR al intentar crear Carreras<br/><br/>Verifique su conexión de internet</div>";
		var esperar1='<div align="center" style="margin:25px 0px 0px 0px;padding:170px 0px 40px 0px;background:#FFF;';
		var esperar2='font-size:24px;">Guardando Por favor espere...<br/><br/>';
		var esperar3='<img src="../images/barraloading.gif" width="128" height="15"/>';
		var esperar4='</div>';
		var paramet1={ "cod":cod, "dia":dia };
		$.ajax({  
			data: paramet1,
			url:'../includes/programar_carreras_guardar_hnac.php', 
			type:'POST',
				beforeSend: function(){ 
					$("#divprograma").html(esperar1+esperar2+esperar3+esperar4); 
				},
				success:function (response) { 
					$("#divprograma").html(response); 
					//bEnable(x);
				},
				error: function(){ 
					$("#divprograma").html(mError1+mError2+mError3);
					//bEnable(x);
				}    
		}); 
}
</script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabecera_hnac.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
                <!-- InstanceBeginEditable name="pagina" -->
               Apertura Automática <br/>MAQUINA AZUL
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
              <a href="../admin_hnac/admin_apertura_lista_hnac.php" class="btn alert-success" 
            	style="font-size:14px;width:140px;height:30px;padding:10px 0px 0px 0px;text-align:center;color:#FFFFFF;
                background: #F90;text-decoration:none; " title="ir a listas">
                 VOLVER A LISTA
              </a>
	</div>
	<div style="height:100%; font-size:18px; padding:0px 0px 0px 0px ">
      <div style="padding:50px 0px 140px 0px;text-align:left;font-size:18px;height:auto" id="divprograma" class="divprograma">
            <div style="color: #000; width:100%; text-align:center; padding:100px 0px 50px 0px; font-size:24px">
                <i class="fa fa-spinner fa-spin fa-2x"></i><br/>
                Cargando información de carreras desde maquinaazul.com.ve<br/><br/>Por favor espere un momento...
            </div>
      </div>
	</div> 
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
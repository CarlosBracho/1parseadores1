<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
ini_set('max_execution_time', 300);
ini_set("session.gc_maxlifetime", 43200); # Tiempo de vida de las sesiones
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
$(document).ready(function() {
    loadHora();
});

var loadHora = function() {
    $.ajax({    
        type: "GET",
        url: "../includes/admin_mtp_hpi_hora.php",             
        dataType: "html",
		beforeSend: function() {
			clearTimeout(loadHora);
		},
        success: function(response) {                    
            $(".divControlHora").html(response);
            setTimeout(loadHora, 20000); 
        },
		error: function(){ 
			$("#divControlHora").html("<br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/><h2>Verifique su conexión a internet<h2/>");
			setTimeout(loadHora, 20000);
		}    
	});
};
$(document).ready(function() {
    loadCierre();
});

var loadCierre = function() {
    $.ajax({    
        type: "GET",
        url: "../includes/admin_mtp_hpi_cierre.php",             
        dataType: "html",
		beforeSend: function() {
			clearTimeout(loadCierre);
		},                   
        success: function(response) {                    
            $(".divControlCierre").html(response);
            setTimeout(loadCierre, 3000); 
        },
		error: function(){ 
			$("#divControlCierre").html("<br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/><h2>Verifique su conexión a internet<h2/>");
			setTimeout(loadCierre, 3000);
		}    
	});
};
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
    <div style="background: #003; height:25px; color:#FFFFFF; padding:25px 0px 0px 0px;text-align:center; font-size:34px; width:100%"
    	id="datosUsuario">
        HORSE PLAYER INTERACTIVE 3 (MTP)
	</div>
</div>
<div class="contentAdmin">
	<div style="padding:0px 0px 40px 0px;text-align:left;font-size:18px;height:auto" id="divControlHora" class="divControlHora">
    	<div style="color: #000; width:100%; text-align:center; padding:20px 0px 0px 0px">
        	<i class="fa fa-spinner fa-spin fa-2x"></i><br/>
    		Iniciando control hora<br/>Por favor espere un momento...
        </div>    
	</div>
	<div style="padding:0px 0px 0px 0px;text-align:left;font-size:18px;height:auto" id="divControlCierre" class="divControlCierre">
    	<div style="color: #000; width:100%; text-align:center; padding:20px 0px 0px 0px">
        	<i class="fa fa-spinner fa-spin fa-2x"></i><br/>
    		Cargando información de cierre<br/>Por favor espere un momento...
        </div>    
	</div>
</div>
</body>
</html>
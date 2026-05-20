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
    loadData();
});

var loadData = function() {
    $.ajax({    
        type: "GET",
        url: "../includes/mtp_hpi.php",             
        dataType: "html",
		beforeSend: function() {
			clearTimeout(loadData);
		},                   
        success: function(response) {                    
            $(".divControl").html(response);
            setTimeout(loadData, 3000); 
        },
		error: function(){ 
			$("#divControl").html("<br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/><h2>Verifique su conexión a internet<h2/>");
			setTimeout(loadData, 3000);
		}    
	});
};
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
    <div style="background: #003; height:25px; color:#FFFFFF; padding:25px 0px 0px 0px;text-align:center; font-size:34px; width:100%"
    	id="datosUsuario">
        HORSE PLAYER INTERACTIVE (MTP)
	</div>
</div>
<div class="contentAdmin">
	<div style="padding:0px 0px 0px 0px; text-align:left; font-size:18px; height: auto" id="divControl" class="divControl">
    	<div style="color: #000; width:100%; text-align:center; padding:20px 0px 0px 0px">
        	<i class="fa fa-spinner fa-spin fa-2x"></i><br/><br/>
    		Cargando información<br/>Por favor espere un momento...
        </div>    
	</div>
</div>
</body>
</html>
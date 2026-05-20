<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
var tiempo = 30000;
var mError = "<br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/><h2>Verifique su conexión a internet<h2/>";
$(document).ready(function() {
    loadData();
});
var loadData = function() {
    $.ajax({  
        type: "GET",
        url: "../includes/dividendos_total.php",             
        dataType: "html",
		beforeSend: function() {
			clearTimeout(loadData);
			var espera1='<i class="fa fa-spinner fa-spin fa-3x"></i><br/>';
			var espera2='Buscando Resultados y Dividendos<br/>Por favor espere un momento...';
    		$(".dDivi").html(espera1+espera2);
  		},                   
        success: function(response) {                    
            $(".divControl").html(response);
            setTimeout(loadData, tiempo); 
        },
		error: function(){ 
			$("#divControl").html(mError);
			setTimeout(loadData, tiempo);
		}    
	});
};
function confirmarDiv(codCarrera, conf, rese, modi) {
	$(conf).html(""); $(rese).html(""); $(modi).html("");
	var parametros1 = { "rA":codCarrera };
	$.ajax({ data:parametros1, url:'../includes/confirma_dividendos.php', type:'post',
		success:function (response) { $(conf).html(response); },
		error: function(){ 
			$(".divControl").html(mError);
			setTimeout(loadData, tiempo);
		} 
	}); 
}
function cancelaCar(codC, e1, e2, e3, e4, diws1, dips1, diss1, dips2, diss2, diss3, exac, trif, supe, cerr, conf, rese, modi) {
	$(cerr).html(""); $(conf).html(""); $(rese).html(""); $(modi).html(""); $(e1).html("99"); $(e2).html("99"); $(e3).html("99"); 
	$(e4).html("99"); $(diws1).html("0.0"); $(dips1).html("0.0"); $(diss1).html("0.0"); $(dips2).html("0.0"); $(diss2).html("0.0");
	$(diss3).html("0.0"); $(exac).html(""); $(trif).html(""); $(supe).html("");
	var parametros3 = { "eM":Math.random(), "recordID":codC };
	$.ajax({ data:parametros3, url:'admin_apertura_cancelar.php', type:'GET',
		success:function (response) { $(conf).html(response); },
		error: function(){ 
			$(".divControl").html(mError);
			setTimeout(loadData, tiempo);
		}    
	}); 

}
function ModiDiv(codModi,tip) {
	var esper1 = '<div style="text-align:center; padding:50px 0px 0px 0px;">';
	var esper2 = '<img src="../images/barraloading.gif" width="128" height="15" /><br/>En Proceso! Por favor espere ...';
	var esper3 = '</div>';
	var parametros2 = { "recordID":codModi, "rA":tip };
	$.ajax({ data:parametros2, url:'confirma_dividendos_edit.php', type:'GET',
		beforeSend: function(){ $('.divControl').html(esper1+esper2+esper3); },
		success:function (response) { $(".divControl").html(response); },
		error: function(){ 
			$(".divControl").html(mError);
			setTimeout(loadData, tiempo);
		}    
 
	}); 
}
function resetDiv(codC, e1, e2, e3, e4, divws1, divps1, divss1, divps2, divss2, divss3, exac, trif, supe, botConf) {
	$(e1).html("0"); $(e2).html("0"); $(e3).html("0"); $(e4).html("0"); $(divws1).html("0.0"); $(divps1).html("0.0"); 
	$(divss1).html("0.0"); $(divps2).html("0.0"); $(divss2).html("0.0"); $(divss3).html("0.0"); $(exac).html(""); 
	$(trif).html(""); $(supe).html(""); $(botConf).html("");
	var parametros3 = { "eM":Math.random(), "recordID":codC };
	$.ajax({ data:parametros3, url:'dividendos_reset.php', type:'GET',
		success:function (response) { $(supe).html(response); },
		error: function(){ 
			$(".divControl").html(mError);
			setTimeout(loadData, tiempo);
		}    
 
	}); 
}
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container1">
    <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align: center; font-size:34px"
    	id="datosUsuario">
        DIVIDENDOS
	</div>
</div>
<div class="contentAdmin" style="width:100%">
	<div style="padding:0px 0px 0px 0px; text-align:left; font-size:18px; height: auto" id="divControl" class="divControl">
    	<div style="color: #000; width:100%; text-align:center; padding:20px 0px 0px 0px"  id="dDivi" class="dDivi">
        </div>    
	</div>
</body>
</html>
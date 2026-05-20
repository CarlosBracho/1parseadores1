<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hipicas:.</title>
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<script type="text/javascript" src="jslot/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
var cuenta=0;
function enviado() { 
	if (cuenta == 0){
		cuenta++;
		return true;
	}
	else {
	alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
	return false;
	}
}
$(function(){
	$("#buttonazul").click(function(){
		if (document.getElementById('pagarT').value!="") {
			var url = '../includes/busca_jugada_lot.php';
			var xerror = '<p id="mpaga"><br/><br/><h3>NO HUBO RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
			var esper1 = '<i class="fa fa-spinner fa-spin fa-2x"></i><br/>En Proceso! Por favor espere ...';
			$('#buttonazul').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form2").serialize(),
				beforeSend: function(){ 
					$('#info1').html(esper1);
				},
				success: function(data) {
					$('#buttonazul').prop("disabled", false);
					$("#info1").html(data);
				},
				error: function(){ 
					$("#info1").html(xerror);
					$('#buttonazul').prop("disabled", false);
				}
			});
			return false; // Evitar ejecutar el submit del formulario.
		} else { cuenta=0; };
	});
});
function ocultaDiv() {
	$('#info1').html("");
}
function handleEnter (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	} 
	else
	return true;
} 
</script>
</head>
<body style="margin: 0px">
	<div style="background:#0084B4; width:100%; float:left; padding:50px 0px 2px 0px;
   		color:#FFF; font-size:28px; text-align:center">
       BUSCAR TICKET LOTERIAS
	</div>
	<div style="background: #FFF; width:100%; float:left; padding:25px 0px 15px 0px; font-size:18px">
  		<form method="post" id="form2">
        	<div style="float:left; padding:8px 0px 0px 10px;">
        		CÓDIGO DE TICKET:
	            <input type="text" name="pagarT" style="width:180px; height:32px; font-size:18px" id="pagarT" 
                tabindex="1" onKeyDown="return handleEnter(this, event)" onclick="ocultaDiv()" value=""/>
            </div>
            <div style="float:left; padding:9px 0px 0px 10px;">
 				<input type="submit" id="buttonazul" value="Buscar" title="buscar ticket" tabindex="2" class="btn-primary"
                	style="width:80px; height:40px"/>
                <input type="hidden" name="tip_usuario" value="<?php echo $_SESSION['MM_UserGroup']; ?>" />
                <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['MM_id_usuario']; ?>" />
            </div>    
		</form>
    </div>    
    <div style="width:100%; float:left; padding:5px 0px 0px 0px; font-size:14px;
        text-align:center; color: #000" id="info1">
    </div>
</div>  
</body>
</html>
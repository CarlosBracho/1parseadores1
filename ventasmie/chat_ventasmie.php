<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu"); $MM_authorizedUsers = "U";
$MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../js/jquery-1.9.1.min.js"></script><style>body{padding:0;margin:0 auto;font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;font-size:11px;height:100px;width:auto}</style><script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true}else{alert("El formulario ya está siendo enviado, por favor aguarde un instante.");return false}}function handleEnter(field,event){var keyCode=event.keyCode?event.keyCode:event.which?event.which:event.charCode;if(keyCode==13){var i;for(i=0;i<field.form.elements.length;i++)if(field==field.form.elements[i])break;i=(i+1)%field.form.elements.length;field.form.elements[i].focus();return false}else return true}var refreshId5=null;function startChat(){refreshId5=setInterval(function(){var rA=Math.random();var parametros={"rA":Math.random()};$.ajax({data:parametros,url:'ventasmie_chat_mostrar.php',type:'post',success:function(response){$("#Chat").html(response);scrollChat()}})},7000)}$(function(){$("#enviarChatBoton").click(function(){if(document.getElementById('txtMensaje').value!=""){var url='../ventas/ventas_chat_enviar.php';$('#enviarChatBoton').prop("disabled",true);$.ajax({type:"POST",url:url,global:false,data:$("#form3").serialize(),success:function(data){$('#enviarChatBoton').prop("disabled",false);document.getElementById('txtMensaje').value="";$("#Chat").load('../ventas/ventas_chat_mostrar.php?&rA='+Math.random());scrollChat()}});return false}})});function scrollChat(){$("#Chat").animate({scrollTop:$('#Chat')[0].scrollHeight},800)}$(document).ready(function(){startChat()});</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1); style="margin: 0px"">
	<div id="mensajeChat" style="font-size:16px; height:100px; width:100%; float:left; 
		text-align:center; padding:0px 0px 0px 0px;">
		<div id="membreteChat" style="font-size:24px; height:65px; width:99.5%; float:left; text-align: right; 
			padding:5px 0px 0px 5px; color: #FFF; background: #0070C1; border-top-style: 
			solid;border-top-width: thin; border-top-color: #FFF;">
            MENSAJES AMERICANAS&nbsp;
				<p style="font-size:12px">Por favor, ante cualquier duda o inconveniente envíenos un mensaje por este medio,
				será respondido en breve&nbsp;</p>
		</div><!-- end .membreteChat -->
		<div id="Chat" style="font-size:14px; height:332px; width:100%; float:left; text-align:left; 
			padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
			position: relative;z-index: 0;">
				<?php include("ventasmie_chat_mostrar.php");?>
		</div><!-- end .Chat -->
		<form method="post" id="form3">
        <div style="height:60px;">
			<div id="enviarChat" style="font-size:18px; height:59px; width:728px; float:left; text-align:left; 
				padding:0px 0px 0px 0px; background:#CCC">
				<textarea id="txtMensaje" name="txtMensaje" placeholder="ESCRIBA SU MENSAJE AQUÍ" 
				style="width:99.6%; height:55px; overflow: auto;resize:none; font-size:12px;border-top: 0px solid #CCC;
				font-family: Arial, Helvetica, sans-serif;"></textarea>
			</div><!-- end .Chat -->
			<div id="enviarBoton" style="font-size:18px; height:55px; width:91px; float:left; text-align: center; 
				padding:1px 0px 1px 0px; border-left:1px solid #CCC;border-top:1px solid #CCC; border-bottom:1px solid #CCC;
                background:#FFF">
				<input name="enviarChatBoton" type="button" id="enviarChatBoton" 
					style="height:55px; background: #CCC; border-color:#CCC; color: #333; width:80px; font-size:12px"
					tabindex="<?php echo $x;?>" value="ENVIAR"/>
			</div><!-- end .Chat -->
			<input type="hidden" name="cod_taquilla_chat" value="<?php echo $_SESSION['MM_cod_taquilla']; ?>" />
			<input type="hidden" name="nom_usuario_chat" value="<?php echo $_SESSION['MM_Username']; ?>" />
        </div>    
		</form>    
	</div><!-- end .mensajeChat -->      
</body>
</html>
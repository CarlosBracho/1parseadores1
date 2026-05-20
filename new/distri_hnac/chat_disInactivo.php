<?php if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');?>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>var statusEnvio=false;function handleEnter(field,event){var keyCode=event.keyCode?event.keyCode:event.which?event.which:event.charCode;if(keyCode==13){var i;for(i=0;i<field.form.elements.length;i++)if(field==field.form.elements[i])break;i=(i+1)%field.form.elements.length;field.form.elements[i].focus();return false}else return true}var refreshId5=null;function startChat(){refreshId5=setInterval(function(){var rA=Math.random();var parametros={"rA":Math.random()};$.ajax({data:parametros,url:'../chat_ad/chat_mostrarag.php',type:'post',success:function(response){$("#Chat").html(response);scrollChat()}})},7000)}$(function(){$("#enviarChatBoton").click(function(){if(document.getElementById('txtMensaje').value!=""){var url='../chat_ad/chat_enviarag.php';$('#enviarChatBoton').prop("disabled",true);$.ajax({type:"POST",url:url,global:false,data:$("#form3").serialize(),success:function(data){$('#enviarChatBoton').prop("disabled",false);document.getElementById('txtMensaje').value="";$("#Chat").load('../chat_ad/chat_mostrarag.php?&rA='+Math.random());scrollChat()}});return false}})});function scrollChat(){$("#Chat").animate({scrollTop:$('#Chat')[0].scrollHeight},800)}$(document).ready(function(){startChat()});</script>


	<div id="mensajeChat" style="font-size:16px; height:100px; width:628px; float:left; 
		text-align:center; padding:0px 0px 0px 0px;">
		<div id="membreteChat" style="font-size:24px; height:65px; width:625px; float:left; text-align: right; 
			padding:5px 0px 0px 5px; color: #FFF; background: #0070C1; border-top-style: 
			solid;border-top-width: thin; border-top-color: #FFF;">
            MENSAJES&nbsp;
		</div><!-- end .membreteChat -->
		<div id="Chat" style="font-size:14px; height:302px; width:100%; float:left; text-align:left; 
			padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
			position: relative;z-index: 0;border: 1px solid #CCC;">
				<?php include("../chat_ad/chat_mostrarag.php");?>
		</div><!-- end .Chat -->
		<form method="post" id="form3">
        <div style="height:60px; width:100.4%;">
			<div id="enviarChat" style="font-size:18px; height:59px; width:622px; float:left; text-align:left; 
				padding:0px 0px 0px 0px; background:#CCC;">
				<textarea id="txtMensaje" name="txtMensaje" placeholder="ESCRIBA SU MENSAJE AQUI"
				style="width:99.6%; height:55px; overflow: auto;resize:none; font-size:14px;border-top: 0px solid #CCC;
				font-family: Arial, Helvetica, sans-serif;"></textarea>
			</div><!-- end .Chat -->
			<div id="enviarBoton" style="font-size:18px; height:55px; width:91px; float:left; text-align: center; 
				padding:1px 0px 1px 0px;background:#FFF">
				<input name="enviarChatBoton" type="button" id="enviarChatBoton" 
					style="height:55px; background: #CCC; border-color:#CCC; color: #333; width:630px; font-size:12px"
					tabindex="1" value="ENVIAR"/>
			</div><!-- end .Chat -->
			<input type="hidden" name="nom_usuario_chat" value="<?php echo $_SESSION['MM_Username']; ?>" />
        </div>    
		</form>   
	</div><!-- end .mensajeChat --> 

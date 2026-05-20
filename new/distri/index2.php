<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseDistri.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true}else{alert("El formulario ya estÃ¡ siendo enviado, por favor aguarde un instante.");return false}}function handleEnter(field,event){var keyCode=event.keyCode?event.keyCode:event.which?event.which:event.charCode;if(keyCode==13){var i;for(i=0;i<field.form.elements.length;i++)if(field==field.form.elements[i])break;i=(i+1)%field.form.elements.length;field.form.elements[i].focus();return false}else return true}var refreshId5=null;function startChat(){refreshId5=setInterval(function(){var rA=Math.random();var parametros={"rA":Math.random()};$.ajax({data:parametros,url:'../chat_ad/chat_mostrarag2.php',type:'post',success:function(response){$("#Chat").html(response);scrollChat()}})},7000)}$(function(){$("#enviarChatBoton").click(function(){if(document.getElementById('txtMensaje').value!=""){var url='../chat_ad/chat_enviarag.php';$('#enviarChatBoton').prop("disabled",true);$.ajax({type:"POST",url:url,global:false,data:$("#form3").serialize(),success:function(data){$('#enviarChatBoton').prop("disabled",false);document.getElementById('txtMensaje').value="";$("#Chat").load('../chat_ad/chat_mostrarag2.php?&rA='+Math.random());scrollChat()}});return false}})});function scrollChat(){$("#Chat").animate({scrollTop:$('#Chat')[0].scrollHeight},800)}$(document).ready(function(){startChat()});</script>

<!-- InstanceBeginEditable name="aHead" -->
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceradistri.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                <?php echo "DISTRIBUIDOR: ".$_SESSION['MM_nom_banca'] ?><br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>






<br/>
<br/>
<br/>
<table  border="4" ALIGN=CENTER>
   <tr>
       <td>

	<div id="mensajeChat" style="font-size:16px; height:100px; width:628px; float:left; 
		text-align:center; padding:0px 0px 0px 0px;">
		<div id="membreteChat" style="font-size:24px; height:65px; width:625px; float:left; text-align: right; 
			padding:5px 0px 0px 5px; color: #FFF; background: #0070C1; border-top-style: 
			solid;border-top-width: thin; border-top-color: #FFF;">
            MENSAJES&nbsp;
				<p style="font-size:12px">Por favor, ante cualquier duda o inconveniente envienos un mensaje por este medio,
				serÃ¡ respondido en breve&nbsp;</p>
		</div><!-- end .membreteChat -->
		<div id="Chat" style="font-size:14px; height:232px; width:628px; float:left; text-align:left; 
			padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
			position: relative;z-index: 0;">
				<?php include("../chat_ad/chat_mostrarag2.php");?>
		</div><!-- end .Chat -->
		<form method="post" id="form3">
        <div style="height:60px;">
			<div id="enviarChat" style="font-size:18px; height:59px; width:623px; float:left; text-align:left; 
				padding:0px 0px 0px 0px; background:#CCC">
				<textarea id="txtMensaje" name="txtMensaje" placeholder="ESCRIBA SU MENSAJE AQUÃ" 
				style="width:99.6%; height:55px; overflow: auto;resize:none; font-size:14px;border-top: 0px solid #CCC;
				font-family: Arial, Helvetica, sans-serif;"></textarea>
			</div><!-- end .Chat -->
			<div id="enviarBoton" style="font-size:18px; height:55px; width:91px; float:left; text-align: center; 
				padding:1px 0px 1px 0px; border-left:1px solid #CCC;border-top:1px solid #CCC; border-bottom:1px solid #CCC;
                background:#FFF">
				<input name="enviarChatBoton" type="button" id="enviarChatBoton" 
					style="height:55px; background: #CCC; border-color:#CCC; color: #333; width:628px; font-size:12px"
					tabindex="<?php echo $x;?>" value="ENVIAR"/>
			</div><!-- end .Chat -->
			<input type="hidden" name="nom_usuario_chat" value="<?php echo $_SESSION['MM_Username']; ?>" />
        </div>    
		</form>    
	</div><!-- end .mensajeChat --> 



<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/><br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
       </td>
   </tr>
</table>






  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>

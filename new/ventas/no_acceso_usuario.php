<?php
if (!isset($_SESSION)) {
    session_start();
} $editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $_SESSION['MM_Username'] = null;
    $_SESSION['MM_UserGroup'] = null;
    $_SESSION['MM_id_usuario'] = null;
    unset($_SESSION['MM_Username']);
    unset($_SESSION['MM_UserGroup']);
    unset($_SESSION['MM_id_usuario']);
    unset($_SESSION['MM_cod_banca']);
    unset($_SESSION['MM_nom_banca']);
    unset($_SESSION['MM_systemE']);
    $MM_redirectLoginSuccess = "../index.php";
    header("Location: ".$MM_redirectLoginSuccess);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<!--[if IE 7]><link rel="stylesheet" href="../css/font-awesome-ie7.min.css"><![endif]-->
<!--[if IE 8]><link rel="stylesheet" href="../css/font-awesome-ie7.min.css"><![endif]-->
<!--[if IE 9]><link rel="stylesheet" href="../css/font-awesome-ie7.min.css"><![endif]-->
<script src="../js/jquery-1.9.1.min.js"></script>
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true}else{alert("El formulario ya está siendo enviado, por favor aguarde un instante.");return false}}function handleEnter(field,event){var keyCode=event.keyCode?event.keyCode:event.which?event.which:event.charCode;if(keyCode==13){var i;for(i=0;i<field.form.elements.length;i++)if(field==field.form.elements[i])break;i=(i+1)%field.form.elements.length;field.form.elements[i].focus();return false}else return true}var refreshId5=null;function startChat(){refreshId5=setInterval(function(){var rA=Math.random();var parametros={"rA":Math.random()};$.ajax({data:parametros,url:'ventasmie_chat_mostrar.php',type:'post',success:function(response){$("#Chat").html(response);scrollChat()}})},7000)}$(function(){$("#enviarChatBoton").click(function(){if(document.getElementById('txtMensaje').value!=""){var url='../ventas/ventas_chat_enviar.php';$('#enviarChatBoton').prop("disabled",true);$.ajax({type:"POST",url:url,global:false,data:$("#form3").serialize(),success:function(data){$('#enviarChatBoton').prop("disabled",false);document.getElementById('txtMensaje').value="";$("#Chat").load('../ventas/ventas_chat_mostrar.php?&rA='+Math.random());scrollChat()}});return false}})});function scrollChat(){$("#Chat").animate({scrollTop:$('#Chat')[0].scrollHeight},800)}$(document).ready(function(){startChat()});</script>
<title>.:Apuestas Hípicas:.</title>
<style type="text/css"> 
#contenedor {
  width: 55%;
  margin: 0 auto;
  padding: 50px 0px 0px 10px;
  font-size:24px;
}
</style> 
</head>
<body style="margin: center">
    <div id="contenedor">
        <div style="width:125px; float:left;" >
            <i class="fa fa-exclamation-triangle fa-5x"></i>
        </div> 
        <div style="width:540px; float:left; line-height:20px; font-size:18px">
			<div style="width:auto; padding:0; text-align:center; float:right; height:42px">
				<form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
					<input type="submit" class="btn" value="VOLVER" style="width:140px; height:40px; font-size:14px;"/>
					<input type="hidden" name="MM_insert" value="form1"/>
				</form>
			</div>
			<?php
            $error="<h1>Taquilla desactivada.</h1>";
            if (!isset($_SESSION['MM_nom_usuario'])) {
                echo "<h1>Algo salio mal!.</h1>"; ?>
				<?php
                echo "<br/>Por favor pongase en contacto con su Agente o su Distribuidor inmediatamente&nbsp;";
            } else {
                echo $error."<br/>El servicio se encuentra desactivado, por favor use el chat para comunicarse con Soporte&nbsp;";
                echo "que sera respondido en breve"; ?>
            <div id="mensajeChat" style="font-size:16px; height:100px; width:100%; float:left; 
                text-align:center; padding:0px 0px 0px 0px;">
                <div id="membreteChat" style="font-size:24px; height:65px; width:99.5%; float:left; text-align: right; 
                    padding:5px 0px 0px 5px; color: #FFF; background: #0070C1; border-top-style: 
                    solid;border-top-width: thin; border-top-color: #FFF;">
                    MENSAJES&nbsp;
                        <p style="font-size:12px">Por favor, ante cualquier duda o inconveniente envíenos un mensaje por este medio,
                        será respondido en breve&nbsp;</p>
                </div><!-- end .membreteChat -->
                <div id="Chat" style="font-size:14px; height:332px; width:100%; float:left; text-align:left; 
                    padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
                    position: relative;z-index: 0;border: 1px solid #CCC;">
                        <?php include("ventasmie_chat_mostrar.php"); ?>
                </div><!-- end .Chat -->
                <form method="post" id="form3">
                <div style="height:60px; width:100.4%">
                    <div id="enviarChat" style="font-size:18px; height:60px; width:82%; float:left; text-align:left; 
                        padding:0px 0px 0px 0px; background:#CCC;border: 1px solid #CCC;">
                        <textarea id="txtMensaje" name="txtMensaje" 
                        style="width:98%; height:55px; overflow: auto;resize:none; font-size:12px;border-top: 0px solid #CCC;
                        font-family: Arial, Helvetica, sans-serif; margin:0px 0 0 0">&nbsp;</textarea>
                    </div><!-- end .Chat -->
                    <div id="enviarBoton" style="font-size:18px; height:63px; width:93px; float: right; text-align: center; 
                        padding:0px 0px 0px 0px; border:1px solid #CCC; background:#FFF">
                        <input name="enviarChatBoton" type="button" id="enviarChatBoton" 
                            style="height:63px; background: #CCC; border-color:#CCC; color: #333; width:94px; font-size:12px"
                            tabindex="1" value="ENVIAR"/>
                    </div><!-- end .Chat -->
                    <input type="hidden" name="cod_taquilla_chat" value="<?php echo $_SESSION['MM_cod_taquilla']; ?>" />
                    <input type="hidden" name="nom_usuario_chat" value="<?php echo $_SESSION['MM_nom_usuario']; ?>" />
                </div>    
                </form>    
            </div><!-- end .mensajeChat -->      
                </form>    
            </div><!-- end .mensajeChat -->      
            <?php
            }
            ?>
        </div>
    </div>
</body>
</html>
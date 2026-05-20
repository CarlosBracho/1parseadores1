<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$query_Recordset1 = sprintf("
/* PARSEADORES1 new\admin_hnac\mensajes_control_hnac.php - QUERY 1 */ SELECT usuario.nom_usuario, usuario.tip_usuario, taquilla.nom_taquilla, taquilla.cod_taquilla 
FROM 
usuario,
taquilla
WHERE
usuario.cod_taquilla=taquilla.cod_taquilla AND
usuario.tip_usuario='U' ORDER BY usuario.nom_usuario");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
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
<link rel="stylesheet" href="../css/modal.css">
<script type="text/JavaScript" src="../js/rounded_corners.inc.js"></script>
<script>
$(document).ready(function() {
	$("#enviarMen").click(function(){
		var url = "../includes/mensajes_chat_enviar_hnac.php"; // El script en dónde se realizará la petición.
		var xerror = '<p id="mpaga"><br/><br/><h3>Mensaje no enviado<h3/>NO HUBO RESPUESTA DEL SERVIDOR</p>';
		$.ajax({ type: "POST", url: url, global : false, data: $("#form3").serialize(),
			success: function(data) {
				cerrarModal();
				location.reload();
			},
			error: function(){
				cerrarModal(); 
				$("#mensajes").html(xerror);
			}
		});
	});
});
	$(document).ready(function() {
	var refreshId1 = null;	
		function startChat() {
			refreshId1 = setInterval(function() {
				var rA=Math.random();
				var parametros = { "rA":Math.random() };
				$.ajax({ data:parametros, url:'../includes/mensajes_chat_hnac.php', type:'post',
					success:function (response) { 
						$("#mensajes").html(response);
						$("#mensajes").animate({ scrollTop: $('#mensajes')[0].scrollHeight}, 100);
						setTimeout(refreshId1, 7000);
					},
					error: function(){
						var menError1='<br/>NO HAY RESPUESTA DEL SERVIDOR!<br/>';
						$("#mensajes").html(menError1);
						setTimeout(refreshId1, 30000);
					} 
				}); 
		 	}, 30000);
			efectoX();
		}
		startChat();
		efectoX();
	});
	function stopChat() {
		clearInterval(refreshId1);
	}
    </script>
	<script>
		function haga(user,id) {
			$("#menPara").html("Para: "+user);
			document.getElementById('para').value=user;
			document.getElementById('id_taquilla').value=id;
		}
		function cerrarModal() {
			$('.overlay-container').fadeOut().end().find('.window-container').removeClass('window-container-visible');
			location.reload();
		}
		$(document).ready(function() {
			$('.botonChat').click(function() {
				type = $(this).attr('data-type');
				$('.overlay-container').fadeIn(function() {
					window.setTimeout(function(){
					$('.window-container.'+type).addClass('window-container-visible');
				}, 20);
				var parametros = { "rA":document.getElementById('para').value };
				$.ajax({ data:parametros, url:'../includes/mensajes_chat_mostrar_hnac.php', type:'post',
					success:function (response) { 
						$("#menUser").html(response);
						$("#menUser").animate({ scrollTop: $('#menUser')[0].scrollHeight}, 100);
					},
					error: function(){
						var menError1='<br/>NO HAY RESPUESTA DEL SERVIDOR!<br/>';
						$("#menUser").html(menError1);
					} 
				}); 
				});
			});
			$('#close').click(function() {
				cerrarModal();
			});
		});
	function efectoX(){
		capa = $(".noLeido");
		capa.fadeOut(900);
		capa.fadeIn(4000, efectoX);
	}
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container1" style="background: #333;">
	<div style="height:700px; width:100%; padding:0px 0px 0px 0px; text-align:left;">
		<div style="background: #333; width:100%; float:left; padding:12px 0px 15px 0px;
   			color:#FFF; font-size:20px; text-align: center">
			MENSAJES NACIONALES 
		</div><!-- end .container -->            
		<div style="height:100%; width:20%; padding:5px 0px 10px 0px; text-align:left; background: #F36; float:left; 
   			color:#FFF; font-size:16px;text-align: center">
    		USUARIOS
    		<div style="height:94%; width:98%; margin:15px 1px 2px 2px; text-align:left; background: #FFF; 
	   			color: #000; font-size:14px;text-align:center; overflow: auto;" id="usuarios">
      			<table width="100%" border="0">
                    <tr align="left">
                        <td width="1%">&nbsp;</td>
                        <td width="99%">
                        	<a href="#" style="font-size:14px;text-decoration:none;" class="botonChat" data-type="zoomout" 
                				onClick="haga('<?php echo 'TODOS'; ?>',
                                '<?php echo '0'; ?>')">
			                        <div class="btn btn-large" 
                                    	style="width:74%; text-align:left; margin: 4px 0px 0px 0px; height:22px;">
		                                <?php echo 'TODOS'; ?>
        		                        <br/>
			                        </div>
            	            </a>
                        </td>
                        <td width="1%">&nbsp;
                        </td>
                    </tr>
				<?php
                do {?>
                    <tr align="left">
                        <td width="1%">&nbsp;</td>
                        <td width="99%">
                        	<a href="#" style="font-size:14px;text-decoration:none;" class="botonChat" data-type="zoomout" 
                				onClick="haga('<?php echo trim($row_Recordset1['nom_usuario']); ?>',
                                '<?php echo $row_Recordset1['cod_taquilla'] ?>')">
			                        <div class="btn btn-large" 
                                    	style="width:74%; text-align:left; margin: 4px 0px 0px 0px; height:22px;">
		                                <?php echo $row_Recordset1['nom_usuario'] ?>
        		                        <br/>
                		                <font style="font-size:10px">
                        		        	(<?php echo $row_Recordset1['nom_taquilla'] ?>)
                                		</font>
			                        </div>
            	            </a>
                        </td>
                        <td width="1%">&nbsp;
                        </td>
                    </tr>
                <?php
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));?>   
                </table>
			</div>
		</div>
		<div style="height:100%; width:80%; padding:5px 0px 10px 0px; text-align:left; background:#0E5157; float:left;
   			color:#FFF; font-size:16px;text-align: center;">
    			CHAT
				<div style="height:94%; width:99%; margin:15px 1px 2px 2px; text-align:left; background: #FFF; 
	   				color: #000; font-size:16px;text-align:center; overflow: auto;" onmouseover="stopChat()" 
                    onmouseout="startChat()" id="mensajes" >
      				<?php
                    include("../includes/mensajes_chat_hnac.php");?>
      			</div>
		</div>
		<div class="overlay-container">
			<div class="window-container zoomout" style="height:400px;" id="window-container">
     			<div style="height:16px; width:100%; background:#23528c; margin:-10px 0px 0px -20px; padding:5px 40px 0px 2px;
            		color:#FFF;  font-size:14px" id="menPara">
        			Para:
				</div>
				<div style="float: right; margin:-20px 0px 0px 92%; background:#CCCCCC; position:absolute;">
        			<span style="font-size:18px" id="close">
                    	<a href="javascript:void(0)" title="cerrar ventana">&nbsp;X&nbsp;</a></span>
        		</div>
				<div style="height:295px; border: 1px solid #888; padding:5px 5px 5px 5px; margin:3px -17px 0px -17px; 
                	overflow:auto"
                	id="menUser">
                
        		</div>
                
				<form method="post" id="form3">
        			<div id="enviarChat" style="font-size:18px; height:60px; width:87.6%; float:left; text-align:left; 
                		padding:0px 0px 0px 0px; margin:2px 0px 0px -18px; background:#FFCC00">
						<textarea id="txtMensaje" name="txtMensaje" placeholder="ESCRIBA SU MENSAJE AQUÍ" 
                    	style="width:100%; height:80px; overflow: auto;resize:none; border: 1px solid #888; font-size:12px;
                    	font-family: Arial, Helvetica, sans-serif;"></textarea>
					</div><!-- end .Chat -->
					<div id="enviarBoton" style="font-size:14px; height:70px; width:85px; float: left; text-align: center; 
                		position:absolute; margin: 16px 0px 0px 80%;">
						<input name="enviarMen" type="button" id="enviarMen" 
                    		style="height:65px; background: #CCC; border-color:#CCC; color: #333"
                        	tabindex="<?php echo $x;?>"
                        	value="ENVIAR" title="enviar mensaje"/>
					</div><!-- end .Chat -->
        			<input type="hidden" name="id_taquilla" id="id_taquilla" value="" />
        			<input type="hidden" name="desde" value="Soporte" />
                    <input type="hidden" name="para" id="para" value="" />
        		</form>    
			</div>
		</div>
	</div>
</div><!-- end .container -->  
<div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
</body>
</html>
<?php
//mysqli_free_result($Recordset2);
mysqli_free_result($Recordset1);
?>
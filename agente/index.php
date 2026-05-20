<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
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
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true}else{alert("El formulario ya está siendo enviado, por favor aguarde un instante.");return false}}function handleEnter(field,event){var keyCode=event.keyCode?event.keyCode:event.which?event.which:event.charCode;if(keyCode==13){var i;for(i=0;i<field.form.elements.length;i++)if(field==field.form.elements[i])break;i=(i+1)%field.form.elements.length;field.form.elements[i].focus();return false}else return true}var refreshId5=null;function startChat(){refreshId5=setInterval(function(){var rA=Math.random();var parametros={"rA":Math.random()};$.ajax({data:parametros,url:'../chat_ad/chat_mostrarag.php',type:'post',success:function(response){$("#Chat").html(response);scrollChat()}})},7000)}$(function(){$("#enviarChatBoton").click(function(){if(document.getElementById('txtMensaje').value!=""){var url='../chat_ad/chat_enviarag.php';$('#enviarChatBoton').prop("disabled",true);$.ajax({type:"POST",url:url,global:false,data:$("#form3").serialize(),success:function(data){$('#enviarChatBoton').prop("disabled",false);document.getElementById('txtMensaje').value="";$("#Chat").load('../chat_ad/chat_mostrarag.php?&rA='+Math.random());scrollChat()}});return false}})});function scrollChat(){$("#Chat").animate({scrollTop:$('#Chat')[0].scrollHeight},800)}$(document).ready(function(){startChat()});</script>

</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<?php
$query_Recordset44 = sprintf("/* PARSEADORES1 agente\index.php - QUERY 1 */ SELECT 
	me.mensaje
	FROM agencia ag, mensajesyalertas me 
	USE INDEX(mostrarhasta) 
	WHERE 
	(me.mostrarhasta >= CURDATE()) AND 
    ((tipo = 5 AND ag.cod_banca = me.para)  OR
	(tipo = 4 AND ag.cod_agencia = me.para)) 	
	AND ag.cod_banca = ag.cod_banca AND ag.cod_agencia = %s  
	
	ORDER BY RAND() LIMIT 1", GetSQLValueString($_SESSION['MM_cod_agente'], "int"));
$Recordset44 = mysqli_query($conexionbanca, $query_Recordset44) or die(mysqli_error($conexionbanca));
$row_Recordset44 = mysqli_fetch_assoc($Recordset44);
$totalRows_Recordset44 = mysqli_num_rows($Recordset44);
$mensaje44 = trim($row_Recordset44['mensaje']);
mysqli_free_result($Recordset44);




$fechaactual_Recordset1 = fechaactualbd();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 agente\index.php - QUERY 2 */ SELECT * 
    FROM 
    bitacora, taquilla
    WHERE  
    taquilla.cod_agencia = %s AND 
    taquilla.cod_taquilla =  bitacora.codtaquilla
    ORDER BY 
    bitacora.Id DESC",
    GetSQLValueString($_SESSION['MM_cod_agente'], "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

?>
<font size="6" style="color:red;" align="center"><?php echo $mensaje44;?></font><br/><br/>
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana_ag.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
					<?php include("../includes/cabeceraagente.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
				margin:5px 0px 0px 0px; width:240px; font-size:16px ">
				<?php echo "AGENTE: ".$_SESSION['MM_nom_agente'] ?><br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
		<br/>
   </div>


        </div>



		<?php if ($totalRows_Recordset1>=1) { ?>
			<table   ALIGN=CENTER height=310>
   <tr>
       <td>
    <div style="font-size:14px; height:300px; width:800; float:left; text-align:left; 
			padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
			position: relative;z-index: 0;">
        <table width="800" border="1" align="center" bordercolor="#F4F4F4">
          <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
            <td width="13%">HORA </br> FECHA</td>
            <td width="87%">DESCRIPCION DE LA BITACORA: AQUI SE REFLEJARAN LAS MODIFICACIONES QUE PUEDEN AFECTAR SUS GANANCIAS</td>
          </tr>
          <?php do { ?>
          <tr align="left" valign="middle" bgcolor="#FFFFFF" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
            <td height="36"><?php            $hora1=$row_Recordset1['hor_bitacora'];
            $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
            $nuevahora1 = date('H:i:s', $nuevahora1);
            echo horaampm($nuevahora1);  echo"</br>"; echo fechanueva($row_Recordset1['fec_bitacora']); ?></td>
            <td style="font-size:12px"><?php echo $row_Recordset1['des_bitacora']; ?></td>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
        </table>
    </div>
    <?php } else {?>
        <table width="800" border="1" align="center" bordercolor="#F4F4F4">
          <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
            <td width="13%">HORA</td>
            <td width="87%">DESCRIPCIÓN</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <div style="height:500; font-size:24px; padding:50px 0px 50px 0px ">
            No existen registros en la bitacora
        </div>
	
		<?php }?> 


</td>
</tr>
</table>




<table  border="4" ALIGN=CENTER height=310>
   <tr>
       <td>

<div id="mensajeChat" style="font-size:16px;  width:628px; float:left; 
		text-align:center; padding:0px 0px 0px 0px;">
		<div id="membreteChat" style="font-size:24px; height:65px; width:625px; float:left; text-align: right; 
			padding:5px 0px 0px 5px; color: #FFF; background: #0070C1; border-top-style: 
			solid;border-top-width: thin; border-top-color: #FFF;">
            MENSAJES&nbsp;
				<p style="font-size:12px">Por favor, ante cualquier duda o inconveniente envíenos un mensaje por este medio,
				será respondido en breve&nbsp;</p>
		</div><!-- end .membreteChat -->
		<div id="Chat" style="font-size:14px; height:132px; width:628px;; float:left; text-align:left; 
			padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
			position: relative;z-index: 0;">
				<?php include("../chat_ad/chat_mostrarag.php");?>
		</div><!-- end .Chat -->
		<form method="post" id="form3">
        <div style="height:60px;">
			<div id="enviarChat" style="font-size:18px; height:59px; width:623px; float:left; text-align:left; 
				padding:0px 0px 0px 0px; background:#CCC">
				<textarea id="txtMensaje" name="txtMensaje" placeholder="ESCRIBA SU MENSAJE AQUÍ" 
				style="width:80%; height:55px; overflow: auto;resize:none; font-size:14px;border-top: 0px solid #CCC;
				font-family: Arial, Helvetica, sans-serif;"></textarea>

				<input name="enviarChatBoton" type="button" id="enviarChatBoton" 
					style="height:55px; background: #CCC; border-color:#CCC; float:right; color: #333; width:18%; font-size:12px"
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

       </td>
   </tr>
</table>





  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>

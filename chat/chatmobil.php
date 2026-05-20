<?php include("../chat/chat_datos.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>chat apuestas hipicas</title>
<link rel="stylesheet" href="../css/minimizemobil.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="../js/uitablefilter.js"></script>
<!--[if gte mso 12]>
> <style type="text/css">
> [a.btn {
	padding:15px 22px !important;
	display:inline-block !important;
}]
> </style>
> <![endif]-->
<script>
var menError='<br/>NO HAY RESPUESTA DEL SERVIDOR!<br/>';
var refreshId1 = null;
var refreshId2 = null;
var tiempo=19000;
	function cambiacolor_over(celda){celda.style.backgroundColor="#E1E1E1";celda.style.color="#000000";}  
	function cambiacolor_out(celda){celda.style.backgroundColor="#FFFFFF";celda.style.color="#000000";}
	function startAnimate() {$("#usChathis").animate({ scrollTop: $("#usChathis")[0].scrollHeight}, 0);}
	function stopAnimate() {$("#usChathis").stop(true); }
	function stopChat() {
		clearInterval(refreshId1); 
		$("#cintUs").hide();
		$("#usChathis").hide();
		$("#usChathis").html("");
		$("#usActual").html("");
		$("#divChat").hide();
		stopAnimate(); 
	}
	
	function stopLista() { clearInterval(refreshId2); $("#busqueda").hide();$("#tabLista").html("");$("#tabLista").hide();}
	
	$(function(){
		$("#q").click(function(){
			document.getElementById("focInput").value="q";
		});	
		$("#btnAtras").click(function(){
			startLista();
		});	
		$("#comment").click(function(){
			document.getElementById("focInput").value="comment";
		});		
		$('#comment').bind('change keyup', function() {
			if ($('#comment').val()!="") $('#btnEnviar').attr('disabled', false);
			else $('#btnEnviar').attr('disabled', true);		
		 });		 
	});
	function cargarChat() {
		stopLista();
		var from1=document.getElementById("from1").value;
		var to1=document.getElementById("to1").value;
		var newD=document.getElementById("newD").value;
		var rA=Math.random();
		var parametros = { "from1":from1, "to1":to1, "newD":newD, "rA":Math.random() };
		$.ajax({ data:parametros, url:'../chat/mensajes_chat.php', type:'post',
			success:function (response) { $("#usChathis").html(response); startAnimate(); },
			error: function(){ $("#usChathis").html(menError1);} 
		});
		refreshId1 = setInterval(function() {
			var parametros = { "from1":from1, "to1":to1, "newD":newD, "rA":Math.random() };
			$.ajax({ data:parametros, url:'../chat/mensajes_chat.php', type:'post',
				success:function (response) { $("#usChathis").html(response); startAnimate(); },
				error: function(){ $("#usChathis").html(menError1);} 
			});
		}, tiempo);
	}
	function startLista() {
		clearInterval(refreshId1);
		clearInterval(refreshId2);
		stopChat();
		$("#busqueda").show();
		$("#tabLista").show();
		refreshId2 = setInterval(function() {
			var parametros = { "rA":Math.random() };
			$.ajax({ data:parametros, url:'../chat/chat_tablista.php', type:'post',
				success:function (response) { $("#tabLista").html(response); },
				error: function(){$("#tabLista").html(menError);} 
			});
		}, tiempo);
		var parametros = { "rA":Math.random() };
		$.ajax({ data:parametros, url:'../chat/chat_tablista.php', type:'post',
			success:function (response) { $("#tabLista").html(response); },
			error: function(){$("#tabLista").html(menError);} 
		});
	}
	function clicAhref(celda,text1,text2,text3,from1,to1,newD){
		if(typeof document.getElementById("celActiva") !== 'undefined') {
			var c=document.getElementById("celActiva").value;
				stopLista();
				$("#cintUs").show();
				$("#usChathis").show();
				$("#divChat").show();
				$("#tabLista").html("");
				$("#usActual").html(to1);
				$("#usChathis").html("");
				document.getElementById("celActiva").value=celda;document.getElementById("nomActiva").value=text1;
				document.getElementById("fecActiva").value=text2;document.getElementById("menActiva").value=text3;
				document.getElementById("from1").value=from1;document.getElementById("to1").value=to1;
				document.getElementById("newD").value=newD;
				cargarChat();
		}
	}
	$(document).ready(function() {
		startLista(); 
	});	
</script>
</head>
<body style="font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="full">
  <tr>
    <td align="center"><table width="550" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth">
        <tr>
          <td>
          <table width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" align="center" class="full" 
          	style="background-color:#26ADE4;">
              <tr>
                <td style="border-bottom:1px solid #dbdbdb;" align="center">
                <div class="midiv2">
                </div>
                </td>
                <td style="border-bottom:1px solid #dbdbdb;" align="center">
					<div class="new-message" id="new-message">
					</div>
                </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="full">
  <tr>
    <td align="center"><table width="550" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth">
        <tr>
          <td>
          <table width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" align="center" class="full" style="background-color:#ffffff;">
          	  <tr>
              	<td height="5">
                </td>
              </tr>
              <tr>
              	<td>
            	<div id="ladoI" style="float:left;width:100%; height:100%;">
                	<div id="cintUs" style="text-align:center;height:35px;width:100%; display:none">&nbsp;
                    	<div style="color: #028ED3; width:19%;height:26px; float:left;">
							<input type="submit" value="atras" id="btnAtras" name="btnAtras">
						</div>
                        <div id="usActual" style="text-align:center;height:26px;width:59%; float:left; font-size:22px">&nbsp;
                        </div>
                    </div>
           			<div id="busqueda" style="padding:0 0 0 10px">
                        <input type="text" id="q" name="q" value="" style="width:83%; height:40px; font-size:22px" />
                    </div>
                    <div id="tabLista" style="overflow-x:hidden;overflow-y:hidden;height:99%; width:99%;
                    	padding:0 0 0 1%;color:#000000; 
						font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
						<?php include("../chat/chat_tablista.php");?>
                	</div>
                	<div id="divChat" style="height:380px;width:100%;font-size:12px;display:none; background:#E7E7E7">
                        <div id="usChathis" style="overflow-x: hidden; overflow-y: scroll; height:80%; width:100%;
                            border-top: 0.2px solid #CFCFCF; border-bottom: 0.2px solid #CFCFCF;
                            background:#E7E7E7" onmouseout="startAnimate()" onmouseover="stopAnimate()">
                        </div>
                    	<div id="fmenssage" 
                        style="border-bottom: 0.2px solid #CFCFCF; height:75px; background:#E7E7E7; padding:10px 0 0 0">
                            <form id="formMenssage" method="post">
                                <div id="divComment" style="height:49px; width:82%; float:left;">
                                    <textarea id="comment" name="comment" class="comment" 
                                    placeholder="Escriba su mensaje aqui..."></textarea>
                                </div>
                                <div id="bEnviar" class="divenviar">
                                    <input type="submit" value="Enviar" id="btnEnviar" name="btnEnviar" class="benviar" 
                                        disabled="disabled">
                                </div>
                                <input type="hidden" id="from1" name="from1" value="" />
                                <input type="hidden" id="to1" name="to1" value="" />
                            </form>
                        </div>
                    </div>
                </div>
                </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full">
  <tr>
    <td align="center"><table width="550" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth">
        <tr>
          <td><table width="100%" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" align="center" class="full" style="border-radius:0 0 7px 7px;">
              <tr>
                <td height="78" valign="bottom" align="center"><span style="font:11px Helvetica,  Arial, sans-serif; color:#000000;">
                &copy; 2012, Todos los derechos reservados. Apuestas Hipicas</span></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
	<input type="hidden" id="celActiva" value="" />
	<input type="hidden" id="nomActiva" value="" />
	<input type="hidden" id="fecActiva" value="" />
	<input type="hidden" id="menActiva" value="" />
	<input type="hidden" id="newD" value="" />
	<input type="hidden" id="focInput" value="q"/>
</body>
<script type="text/javascript">
$(document).ready(function() {
	$(function() { theTable = $("#latabla"); $("#q").keyup(function() { $.uiTableFilter(theTable, this.value); }); });
	$("#formMenssage").submit(function(e) {
        e.preventDefault();
		var d=$.trim($("#comment").val()); var e=$.trim($("#from1").val()); 
		var f=$.trim($("#to1").val()); var g=$.trim($("newD").val());
		if (d!="" && e!="" && f!="") {
			var url = "../chat/mensajes_chat_enviar.php";
			var from1=$("#from1").val(), to1=$("#to1").val(), newD=$("#newD").val();
			$.ajax({ type: "POST", url: url, global : false, data: $("#formMenssage").serialize(),
				beforeSend: function() {$("#comment").val("");clearInterval(refreshId1);},
				success: function(data) { cargarChat(); }
			});
		}
    });
});

</script>		
</html>
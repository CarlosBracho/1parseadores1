<?php include("../chat/chat_datos.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>chat apuestas hipicas</title>
<link rel="stylesheet" href="../css/minimize.css">
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/minimize_ie.css" />
<![endif]-->
<script src="../js/jquery.js"></script>
<script src="../js/uitablefilter.js"></script>
<script type="text/javascript">
var menError='<br/>NO HAY RESPUESTA DEL SERVIDOR!<br/>';
var refreshId1 = null;
var refreshId2 = null;
var tiempo=5000;
	function stopChat() { clearInterval(refreshId1); stopAnimate(); }
	function nullChat() {
		clearInterval(refreshId1);stopAnimate();document.getElementById("from1").value="";
		document.getElementById("to1").value="";document.getElementById("newD").value="";
		document.getElementById("celActiva").value="";document.getElementById("menActiva").value="";
		$("#usActual").html("");$("#usChathis").html("");
	}
	function startAnimate() {$("#usChathis").animate({ scrollTop: $("#usChathis")[0].scrollHeight}, 0);}
	function stopAnimate() {$("#usChathis").stop(true); }
	function menANew(newD) {
		if(typeof document.getElementById(newD) !== 'undefined' && document.getElementById(newD) !== null) {
			var aleer=Number(document.getElementById(newD).innerHTML), gleer=Number(document.getElementById("new-message").innerText);
			var pleer=gleer-aleer;
			if (pleer==0) pleer="";
			document.getElementById(newD).innerHTML = ""; document.getElementById("new-message").innerHTML = pleer;
		}
	}
	function cargarChat() {
		var from1=document.getElementById("from1").value, to1=document.getElementById("to1").value;
		var newD=document.getElementById("newD").value, rA=Math.random();
		var parametros = { "from1":from1, "to1":to1, "newD":newD, "rA":Math.random() };
		$.ajax({ data:parametros, url:'../chat/mensajes_chat.php', type:'post',
			success:function (response) { 
				$("#usChathis").html(response); startAnimate(); 
				document.getElementById(document.getElementById("focInput").value).focus();},
			error: function(){ $("#usChathis").html(menError1);} 
		}); 
	}
	function startLista() {
		clearInterval(refreshId2); 
		refreshId2 = setInterval(function() {
			var parametros = { "rA":Math.random() };
			$.ajax({ data:parametros, url:'../chat/rjson.php', type:'post',
				success:function (response) { $("#tabLista").html(response); },
				error: function(){$("#tabLista").html(menError);} 
			});
			if(typeof document.getElementById("from1") !== 'undefined' && document.getElementById("from1") !== null) {
				var celda=document.getElementById("from1").value;
				if (celda!='') { cargarChat(); }
			}
		}, tiempo);
		//cargarChat();
		var parametros = { "rA":Math.random() };
		$.ajax({ data:parametros, url:'../chat/rjson.php', type:'post',
			success:function (response) { $("#tabLista").html(response); },
			error: function(){$("#tabLista").html(menError);} 
		});
	}
	$(function(){
		$("#chat-window .green-chat").click(function(){$("#chat-window").addClass("clicked");});
		$("#chat-window .green-chat .close").click(function(e) {e.stopPropagation();$("#chat-window").removeClass("clicked");
			 valueIni(); nullChat(); 
			 });
		$("#comment").click(function(){ document.getElementById("focInput").value="comment"; });		
		$("#q").click(function(){ document.getElementById("focInput").value="q"; });	
		$('#comment').bind('change keyup', function() {
			if ($('#comment').val()!="") $('#btnEnviar').attr('disabled', false);
			else $('#btnEnviar').attr('disabled', true);		
		 });		 
	});
	function cambiacolor_over2(celda){celda.style.backgroundColor="#288DD5";celda.style.color="#FFFFFF";}  
	function cambiacolor_out2(celda){celda.style.backgroundColor="#288DD5";celda.style.color="#FFFFFF";} 
	function cambiacolor_over(celda){celda.style.backgroundColor="#E1E1E1";celda.style.color="#000000";}  
	function cambiacolor_out(celda){celda.style.backgroundColor="#FFFFFF";celda.style.color="#000000";}
	function valueIni() {
		if (document.getElementById("menActiva").value!="") {
			document.getElementById(document.getElementById("celActiva").value).style.background="#FFFFFF";
			document.getElementById(document.getElementById("nomActiva").value).style.color="#000000";
			document.getElementById(document.getElementById("fecActiva").value).style.color="#000000";
			document.getElementById(document.getElementById("menActiva").value).style.color="#000000";
			document.getElementById(document.getElementById("celActiva").value).onmouseover ="cambiacolor_over(this)";
			document.getElementById(document.getElementById("celActiva").value).onmouseout ="cambiacolor_out(this)";
		}
	}
	function colorActiva() {
		if(typeof document.getElementById("celActiva") !== 'undefined' && document.getElementById("celActiva") !== null) {
			var celda=document.getElementById("celActiva").value;
			if (celda!='') {
				document.getElementById(document.getElementById("celActiva").value).style.background="#288DD5";
				document.getElementById(document.getElementById("nomActiva").value).style.color="#FFFFFF";
				document.getElementById(document.getElementById("fecActiva").value).style.color="#FFFFFF";
				document.getElementById(document.getElementById("menActiva").value).style.color="#FFFFFF";
				document.getElementById(document.getElementById("celActiva").value).onmouseover = null;
				document.getElementById(document.getElementById("celActiva").value).onmouseout = null;
			}
		}
	}
	function clicAhref(celda,text1,text2,text3,from1,to1,newD){
		if(typeof document.getElementById("celActiva") !== 'undefined') { var c=document.getElementById("celActiva").value;
			if (c!=celda) {
				$("#usChathis").html("");$("#usActual").html(to1);valueIni();
				document.getElementById("celActiva").value=celda;document.getElementById("nomActiva").value=text1;
				document.getElementById("fecActiva").value=text2;document.getElementById("menActiva").value=text3;
				document.getElementById("from1").value=from1;document.getElementById("to1").value=to1;
				document.getElementById("newD").value=newD; colorActiva(); cargarChat();
			}
		}
	}
	$(document).ready(function() { startLista(); });	
</script>
</head>
<body>
	<div class="bodyChat" style="text-align:left;">
		<div class="chat-box-normal" id="chat-window">
			<div class="green-chat">
                <div class="new-message" id="new-message" style="display:none">
                </div>
				<span></span>
				<a href="javascript:void(0)" class="close"></a>
			</div>
			<div class="chat-data">
            	<div id="ladoI" style="float:left;width:49.5%; height:100%;border-right: 1px solid #E1E1E1;">
           			<div id="busqueda">
                        <input type="text" id="q" name="q" value="" style="width:90%;" />
                    </div>
                    <div id="tabLista" style="overflow-x: hidden; overflow-y: scroll; height:88%; width:99%;
                    	padding:0 0 0 1%;color:#000000; 
						font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
						<?php include("../chat/rjson.php");?>
                	</div>
                </div>
            	<div id="ladoD" style="float:left; width:49.5%; height:100%;font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
                	<div id="usActual" style="text-align:center;height:6%;width:94%;">&nbsp;</div>
                	<div id="usChathis" style="overflow-x: hidden; overflow-y: scroll; height:74%; width:96%;
                    	padding:0 0 0 0.5%; border-top: 1px solid #C1BDBE; font-size:11px;
                    	background:#E7E7E7" onmouseout="startAnimate()" onmouseover="stopAnimate()">
                        <div style="margin:45% 0 0 0; text-align:center">
                        Seleccione un usuario para comenzar 
                        <?php include("../chat/mensajes_chat.php");?>
                        </div>
                    </div>
                    <form id="formMenssage" method="post">
                        <div id="usChathis2" style="height:20%; width:76%; float:left;">
                            <textarea id="comment" name="comment" class="comment" placeholder="Escriba su mensaje aqui..." onclick="schat()"></textarea>
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
			<div class="chat-call" id="contact">
					<p><?php echo $contacto;?></p>
			</div>
		</div>
	</div>
	<input type="hidden" id="celActiva" value="" />
	<input type="hidden" id="nomActiva" value="" />
	<input type="hidden" id="fecActiva" value="" />
	<input type="hidden" id="menActiva" value="" />
	<input type="hidden" id="newD" value="" />
	<input type="hidden" id="focInput" value="comment"/>
</body>
<script type="text/javascript">
function schat() {
	var a=document.getElementById("from1"), b=document.getElementById("to1"), c=document.getElementById("newD");
	var d=Number(document.getElementById("new-message").innerText);
	if(typeof a!== 'undefined' && a!== null && b!== 'undefined' && b!== null && c!== 'undefined' && c!== null && d!== 'undefined' && d!== null) {
		if (a.value!="" && b.value!="" && c.value!="" && d.value>0) { menANew(); startLista();}
	}
}
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
				beforeSend: function() {$("#comment").val("");},
				success: function(data) { 
				$('#cMessage tr:last').after('<tr><td><div class="tfrom"></div><div class="tfromDiv"><div style="width:110%;float:left;margin:-2%;color:#FFDC00;font-size:13px;padding:0.5% 0 3% 1%"><b>&nbsp;</b></div>'+d+'<div style="width:100%;padding:3% 0 0 0;font-size:9px;text-align:right;"><div style="width:96%;float:left;">'+data+'</div><div style="float:left;width:4%; height:9px;"><div class="c1" style="background:#B50003"></div></div></div></div></td></tr><tr><td></td></tr>'); startAnimate();
				}
			});
		}
		document.getElementById(document.getElementById("focInput").value).focus();
    });
});
</script>		
</html>
<?php
if (isset($Recordset105)) {
    mysqli_free_result($Recordset105);
}
echo '<table border="0" cellpadding="0" cellspacing="2" class="tablaMen" width="100%" id="cMessage"><tbody></tbody></table>';
?>

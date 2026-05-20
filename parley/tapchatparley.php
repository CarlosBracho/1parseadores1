<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";
$inicio=fechaactualbd();
$final=fechaactualbd();

$iniciof=fechaactualbd().' 00:00:01';
$finalf=fechaactualbd().' 23:59:59';

//var_dump($_SESSION);

$cod_taquilla=$_SESSION['MM_cod_taquilla'];
$nom_usuario=$_SESSION['MM_nom_usuario'];





?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>.:Apuestas:.</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrapBootswatchv4.5.2.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<script src="../js/jquery-3.5.1.min.js"></script>



<script language="javascript">


$(function(){
	$("#enviarChatBoton").click(function(){
		if (document.getElementById('txtMensaje').value!="") {
			var url = 'tapchatparley_chat_enviar.php';
			$('#enviarChatBoton').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form4").serialize(),
				success: function(data) {
					$('#enviarChatBoton').prop("disabled", false);
					document.getElementById('txtMensaje').value="";
					 $("#Chat").load('tapchatparley_chat_mostrar.php?&rA='+Math.random());
                                         scrollChat()
				}
			});
			return false; // Evitar ejecutar el submit del formulario.
		} else { cuenta=0; };
	});
});

function scrollChat() {
	 $("#Chat").animate({ scrollTop: $('#Chat')[0].scrollHeight}, 800);
}
  /*
  $(function(){
$("#enviarChatBoton").click(function() {

var form = $("#form4");
var url = 'tapchatparley_chat_enviar.php';
if (document.getElementById('txtMensaje').value!="") {
$.ajax({
       type: "POST",
       url: url,
       data: form.serialize(), // serializes the form's elements.
       success: function(data)
       {
           alert(data); // show response from the php script.
       }
     });

    });
};
});
*/

</script>
<script>

	var refreshId5 = null;
	function startChat() {
		refreshId5 = setInterval(function() {
		var rA=Math.random();
		var parametros = { "rA":Math.random() };
		$.ajax({ data:parametros, url:'tapchatparley_chat_mostrar.php', type:'post',
			success:function (response) { 
				$("#Chat").html(response);
                                scrollChat()


			} 

		}); 

	 }, 7000);	}
	function stopChat() {
		clearInterval(refreshId5);

	}
</script>
</head>
<script>

	var refreshId5 = null;
	function startChat() {
		refreshId5 = setInterval(function() {
		var rA=Math.random();
		var parametros = { "rA":Math.random() };
		$.ajax({ data:parametros, url:'tapchatparley_chat_mostrar.php', type:'post',
			success:function (response) { 
				$("#Chat").html(response);
                                scrollChat()


			} 

		}); 

	 }, 7000);	}
	function stopChat() {
		clearInterval(refreshId5);

	}
</script>
<body>
<body onload="scrollChat(); Javascript:history.go(1);" onunload="Javascript:history.go(1);">

<header> 
  <!-- Fixed navbar -->
  <?php include('../parley/menutap.php'); ?>
</header>

<!-- Begin page content -->

<div class="container">
  <hr>
  <div class="row">
    <div class="col-12 col-md-12 table-responsive"> 
      <!-- Contenido -->
      


      <div id="mensajeChat" style="font-size:16px; height:177px; width:100%; float:left; 
                    	text-align:center; padding:0px 0px 0px 0px;">
                        
                        <div id="membreteChat" style="font-size:12px; height:18px; width:99.5%; float:left; text-align:left; 
                    		padding:10px 0px 0px 5px; color: #FFF; background:#23528c; border-top-style: 
                        	solid;border-top-width: thin; border-top-color: #FFF;">
                            Por favor, ante cualquier duda o inconveniente env�enos un mensaje por este medio,
                             ser� respondido en breve
                        </div><!-- end .membreteChat -->
                        <div id="Chat" style="font-size:11px; height:90px; width:100%; float:left; text-align:left; 
                    		padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
                            position: relative;z-index: 0;" onmouseover="stopChat()" onmouseout="startChat()" >
	                            <?php include("tapchatparley_chat_mostrar.php");?>


                        </div><!-- end .Chat -->
                        <form method="post" id="form4">
                            <div id="enviarChat" style="font-size:18px; height:50px; width:89.6%; float:left; text-align:left; 
                                padding:0px 0px 0px 0px;">
                                <textarea id="txtMensaje" name="txtMensaje" placeholder="ESCRIBA SU MENSAJE AQUI" 
                                style="width:98%; height:50px; overflow: auto;resize:none; border: 1px solid #888; font-size:12px;
                                font-family: Arial, Helvetica, sans-serif;"></textarea>
                            </div><!-- end .Chat -->
                            <div id="enviarBoton" style="font-size:14px; height:50px; width:98px; float:RIGHT; text-align: center; 
                                padding:5px 0px 0px 0px; border-top: 1px solid #888;">
                                <input name="enviarChatBoton" type="submit" id="enviarChatBoton" 
                                    style="height:45px; background: #CCC; border-color:#CCC; color: #333"
                                    tabindex="<?php echo $x;?>" 
                                    value="ENVIAR"/>
                            </div><!-- end .Chat -->
                            <input type="hidden" id="cod_taquilla_chat" name="cod_taquilla_chat" value="<?php echo $cod_taquilla; ?>" />
                            <input type="hidden" id="nom_usuario_chat" name="nom_usuario_chat" value="<?php echo $nom_usuario; ?>" />
                        </form>    

              </div><!-- end .mensajeChat --> 





      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>
<script>
    function detalle_ticket(nticket, jtipo, modulo){
        $.post("../parley/tappagarticket2.php", 
        {
		nticket:nticket,
		jtipo:jtipo,
		modulo:modulo
		},
        function(eData){				
            $("#dialog-message").html(eData);
        });	
    } 
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pago De apuesta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="dialog-message"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div> 
<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>

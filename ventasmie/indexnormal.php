<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include("index_datos.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link href="../estilo/ventasmie.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 6]><script type="text/javascript">alert("ATENCIÓN: Este software solo funciona con \nMicrosoft Internet Explorer 6 o superior\n\nPor favor, actualice su navegador");location.href='../index.php';</script><![endif]-->
<!--[if lt IE 8]><link href="../estilo/styleIE7.css" rel="stylesheet"> <!--<![endif]-->
<style> body{ background:#e0e0e0;} input:focus{ outline:none !important;border-color:#719ECE;box-shadow:0 0 20px #719ECE;} </style>
<script src="../js/jquery-1.9.1.min.js"></script><script src="../js/fjava.js"></script>
<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true;}else{alert("Datos enviados por favor presione enter solo una vez mas.");return false;}}
</script>

<script>var sAgent = window.navigator.userAgent;var Idx= sAgent.indexOf("MSIE");function GetIEVersion(){var sAgent=window.navigator.userAgent;var Idx=sAgent.indexOf("MSIE");if (Idx > 0) return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));else if(!!navigator.userAgent.match(/Trident\/7\./))return 11;else return 0;}

if (navigator.appName=='Microsoft Internet Explorer' || GetIEVersion()>0){
	if(!factory.object){
		c=confirm('Este software solo funciona con Microsoft Internet Explorer. Por favor, descargue el Active X, Presionando Aceptar, la cual permitirá que el software pueda Imprimir, instálelo y al finalizar la instalación reinicie su equipo e intente de nuevo.');
		if(c==true){window.location = '../download/smsx.exe';}
		else window.location='../acceso.php';}
	}
	else{
		//alert("La Taquilla Ligera Solo Funciona Con Internet Explorer");
		//location.href='../acceso.php';
	} 
	
	
	$( document ).ready(function() {
	function efectoX(){
		capa = $(".noLeido");
		capa.fadeOut(900);
		capa.fadeIn(4000, efectoX);
	}
	efectoX();
});
$(function(){
	$("input[type=text]").focus(function(){this.select();});
	$("#buttonverde").click(function(){
		if (document.getElementById('pagarT').value!=0) {
			document.getElementById('pagamensaje').style.display = 'block';
			document.getElementById('pagaTicket').style.display = 'none';
			document.getElementById('eliminaTicket').style.display = 'none';
			$('#buttonazul').prop("disabled", true);
			var elElemento=document.getElementById('pagamensaje');
			var url = "../ventas/ventas_pagar_apuestas_procesar.php"; // El script en dónde se realizará la petición.
			var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
			var esper1 = '<img src="../images/buscando.gif" width="60" height="60" /><br/>En Proceso! Por favor espere ...';
			elElemento.style.display = 'block';
			$('#buttonrojo').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form2").serialize(),
				beforeSend: function(){ 
					$('#pagamensaje').html(esper1);
				},
				success: function(data) {
					$("#pagamensaje").html(data);
					$('#buttonrojo').prop("disabled", false);
					$('#buttonazul').prop("disabled", false);
				},
				error: function(){ 
					$("#pagamensaje").html(xerror);
					$('#pagamensaje').fadeOut(119000);
					$('#buttonrojo').prop("disabled", false);
					$('#buttonazul').prop("disabled", false);
				}
			});
		}
		return false; // Evitar ejecutar el submit del formulario.
	});
	$("#buttonrojo").click(function(){
		if (document.getElementById('pagarT').value!=0) {
			document.getElementById('pagamensaje').style.display = 'block';
			document.getElementById('pagaTicket').style.display = 'none';
			document.getElementById('eliminaTicket').style.display = 'none';
			$('#buttonazul').prop("disabled", true);
			var elElemento=document.getElementById('pagamensaje');
			var url = "../ventas/ventas_eliminar_ticket.php"; // El script en dónde se realizará la petición.
			var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
	 		var esper1 = '<img src="../images/buscando.gif" width="60" height="60" />';
			var esper2 = '<br/>Eliminación en Proceso! Por favor espere ...';
			elElemento.style.display = 'block';
			$('#buttonrojo').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form2").serialize(),
				beforeSend: function(){ $('#pagamensaje').html(esper1+esper2); },
				success: function(data) { $("#pagamensaje").html(data); 
					$('#buttonrojo').prop("disabled", false);
					$('#buttonazul').prop("disabled", false);
				},
				error: function(){ 
					$("#pagamensaje").html(xerror);
					$('#pagamensaje').fadeOut(119000);
					$('#buttonrojo').prop("disabled", false);
					$('#buttonazul').prop("disabled", false);
				}
			});
		}
		return false; // Evitar ejecutar el submit del formulario.
	});
})
function clean() {
	$("#info1").html('<strong><?php echo $mensaje1; ?></strong>');
	$("#info2").html('<strong><?php echo $_SESSION['MM_mensaje3']; ?></strong>');
	if (document.getElementById("pagamensaje")) {document.getElementById('pagamensaje').style.display = 'none';}
	if (document.getElementById("pagaTicket")) {document.getElementById('pagaTicket').style.display = 'block';}
	if (document.getElementById("eliminaTicket")) {document.getElementById('eliminaTicket').style.display = 'block';}
}
function clean2() {
	if (document.getElementById("pagarT")) {document.getElementById('pagarT').value="";}
	if (document.getElementById("pagamensaje")) {$("#pagamensaje").html('');}
}
function validarNro(e) {
	cuenta=0;
	var key; if(window.event) { key = e.keyCode; } else if(e.which) { key = e.which; } 
	if (key < 48 || key > 57) { if(key == 8 ) { return true; }
	else { return false; } } return true;
}
function rangoNumeros(field, menor, mayor){
	var fi=document.getElementById(field);
	var va=document.getElementById(field).value;
	var me=menor, ma=mayor;
	var mensajeerror="valores entre "+me+" y "+ma;
	if (va!="") {
		if (va>ma){
			alert(mensajeerror);
			document.getElementById(field).focus();
			document.getElementById(field).value="";
		}
		if (va<me){
			alert(mensajeerror);
			document.getElementById(field).focus();
			document.getElementById(field).value="";
		}
	}
}
</script>
<script>
	var refreshId4 = null;
	function startListaHipodromo() {
		refreshId4 = setInterval(function() {
		var hipodSel=document.getElementById('soflow').value;
		var ejeMin=document.getElementById('$ejeMinC').value;
		var rA=Math.random();
		var parametros = { "js":hipodSel, "eM":ejeMin, "rA":Math.random() };
		$.ajax({ data:parametros, url:'ventas_hipodromo_listas.php', type:'post',
			success:function (response) { 
				$("#hipodromo").html(response);
			},
			error: function(){
				var menError1='<br/><div style="font-size:18px;float:left; width:522px; height:32px;background:#FFF;';
				var menError2='margin:2px 0px 0px 20px;padding:3px 0px 0px 0px;text-align:center; color:#C00">';
				var menError3='NO HAY RESPUESTA DEL SERVIDOR! Presione Actualizar Página';
				var menError4='</div>'; 
				$("#hipodromo").html(menError1+menError2+menError3+menError4);
			} 

		}); 
	 }, 60000);
	}
	function stopListaHipodromo() {
		clearInterval(refreshId4);

	}
	
	var refreshId5 = null;
	function startChat() {
		refreshId5 = setInterval(function() {
		var rA=Math.random();
		var parametros = { "rA":Math.random() };
		$.ajax({ data:parametros, url:'../ventas/ventas_chat_mostrar.php', type:'post',
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
<script language="javascript">

$(function(){
	$("#enviarChatBoton").click(function(){
		if (document.getElementById('txtMensaje').value!="") {
			var url = '../ventas/ventas_chat_enviar.php';
			$('#enviarChatBoton').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form3").serialize(),
				success: function(data) {
					$('#enviarChatBoton').prop("disabled", false);
					document.getElementById('txtMensaje').value="";
					 $("#Chat").load('../ventas/ventas_chat_mostrar.php?&rA='+Math.random());
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
</script>

</head>
<body onload="javascript:document.all.form1.focus(); Javascript:history.go(1); scrollChat();" onunload="Javascript:history.go(1);">
    <div id="container" class="container">
		<div id="header" class="header">
			<?php include("../includes/cabeceraventasmie.php");?>
		</div>
        <div id="content" class="content">
			<div id="taquilla" class="taquilla">
				<div id="datos" class="datos" style="background:#333; width:300px;float:left;">
					TAQUILLA DE VENTAS: <?php echo strtoupper($row_Recordset5['nom_taquilla']); ?>
				</div>
				<div style="float:left; font-size:26px;padding:3px 0px 0px 0px; color: #0CF;width:309px;background:#333;">&nbsp;
 					<?php echo "CARRERAS AMERICANAS";?>
				</div>
				<div id="usuario" class="usuario" style="background:#333; width:320px; float:left">
					<?php echo "Usuario: ".strtoupper($row_Recordset5['nom_completo']); ?> | <?php echo vfechaActual(); ?>
 				</div>
            </div>
            <div id="mensaje" class="mensaje">
                <?php echo $mensaje1; ?><BR/><?php echo $_SESSION['MM_mensaje3']; ?>
            </div>
            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">
					<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"
						onsubmit="return chequearEnvio();">
						<div id="men_canticket" style="font-size:16px; background: #333; width:492px; float:left; height:17px; 
							text-align:right; padding:12px 2px 2px 2px; color:#FFF">
							Cantidad ticket creados por Vendedor:
						</div><!-- end .men_canticket -->
                        <div id="mon_canticket" style="font-size:24px; background: #333; width:80px; float:left; height:27px; 
                        	text-align:left; padding:2px 2px 2px 2px; color: #F90;">
                        	<?php include("../includes/infoNumeroTicket.php");?>
                        </div><!-- end .mon_canticket -->
                        <div id="hipodromo" style="font-size:18px; float:left; width:580px; height:35px;background:#CCC">
                        <?php
                        if ($t>0 && isset($cod)) {?>
                        	<select name="cod_carrera" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE HIPÓDROMO AQUÍ";?>
                        		</option><?php
                                foreach ($cod as $cod_carrera) {?>
                                    <option value="<?php echo $cod_carrera;?>" 
                                        <?php if (!(strcmp(
    htmlentities($cod_carrera, ENT_COMPAT, 'utf-8'),
    $_SESSION['selCarrera']
))) {
                                    echo "selected=\"selected\"";
                                }?>>
                                        <?php echo $nom_hipodromo[$x]." Carr: ...".$num_carrera[$x];?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        } else {
                            $_SESSION['selCarrera']=-1; //#e0e0e0?>
                        	<select name="cod_carrera2" 
                        		tabindex="1" style="font-size:20px;width:580px;height:35px" disabled="disabled">
                        		<option value="-1" > <?php echo "En estos momentos no existen carreras abiertas"; ?></option>
                        	</select>
						<?php
                        }?>
						</div><!-- end .hipodromo -->
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">
                            <div style="background:#e0e0e0;float:left;width:40px;height:150px; padding:40px 0px 0px 10px ">
                                                    <img src="../img/permta.png" width="40" height="150" />	
							</div>
                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:left;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	EJEMPLARES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GAN
                            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PLA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SHW
                            </div>
                            <div id="apuesta" class="apuesta" style="float:left; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 4; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:30px; background: #e0e0e0;">
                                        <input type="checkbox" name="<?php echo "per".$i; ?>" size="20" id="<?php echo "per".$i; ?>"
                                        onclick="clean(),clean2()" onchange="clean(),clean2()"
                                        onKeyDown="return handleEnter(this, event)"/>
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="<?php echo "numCa1".$i;?>" style="width:35px; font-size:22px" 
                                        maxlength="2" value="" id="<?php echo "numCa1".$i;?>" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        <input class="textbox" tabindex="<?php echo $x+1;?>" type="text" onchange="clean(),clean2()"
                                        name="<?php echo "numCa2".$i;?>" style="width:35px; font-size:22px"
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)"
                                        onblur=""
                                        maxlength="2" value="" id="<?php echo "numCa2".$i;?>"
                                        title="indique nro de ejemplar"/>
                                         
                                        <input class="textbox" tabindex="<?php echo $x+2;?>" type="text" onchange="clean(),clean2()"
                                        name="<?php echo "numCa3".$i;?>" onkeypress="javascript:return validarNro(event)" 
                                        onclick="clean(),clean2()" onKeyDown="return handleEnter(this, event)"
                                        title="indique nro de ejemplar"
                                        onblur=""
                                        style="width:35px; font-size:22px" maxlength="2" value="" id="<?php echo "numCa3".$i;?>"/>
                                         
                                        <input class="textbox" tabindex="<?php echo $x+3;?>" type="text" onchange="clean(),clean2()" 
                                        name="<?php echo "numCa4".$i;?>" onkeypress="javascript:return validarNro(event)" 
                                        onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" style="width:35px; font-size:22px"
                                        onblur=""
                                        maxlength="2" value="" id="<?php echo "numCa4".$i;?>"
                                        title="indique nro de ejemplar"/> -
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text" name="<?php echo "monGan".$i; ?>" onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        onblur="rangoNumeros('<?php echo "monGan".$i;?>',<?php echo $apMinGan;?>,<?php echo $apGaMax; ?>)"
                                        style="width:85px; font-size:20px" maxlength="8"value="" id="<?php echo "monGan".$i;?>"/>
                                         
                                        <input class="textbox" tabindex="<?php echo $x+5;?>" type="text" 
                                        name="<?php echo "monPla".$i; ?>" onkeypress="javascript:return validarNro(event)" 
                                        title="indique monto" onclick="clean(),clean2()" onchange="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)"
                                        onblur="rangoNumeros('<?php echo "monPla".$i;?>',<?php echo $apMinPla;?>,<?php echo $apPlMax;?>)"
                                        style="width:85px; font-size:20px" maxlength="8" value="" id="<?php echo "monPla".$i;?>"/>
                                         
                                        <input class="textbox" tabindex="<?php echo $x+6;?>" type="text" 
                                        name="<?php echo "monSho".$i; ?>" title="indique monto" onchange="clean(),clean2()"
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" 
                                        onblur="rangoNumeros('<?php echo "monSho".$i;?>',<?php echo $apMinSho;?>,<?php echo $apShMax;?>)"
                                        style="width:85px; font-size:20px" maxlength="8" value="" id="<?php echo "monSho".$i;?>"/>
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
                            <div id="realizarapuesta" style="padding:10px 0px 0px 0px;float:left; width:580px">
                                <input type="submit" id="imprimir" name="imprimir" 
                                value="REALIZAR APUESTA E IMPRIMIR" style="width:400px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="realiza apuesta e imprimir"
                                <?php if ($totalRows_Recordset1==0 || $est_control_ventas==1) {
                                    echo 'disabled="disabled"';
                                } ?>/>
                            </div><!-- end .realizarapuesta -->
                            <div id="recargar" style="padding:10px 0px 0px 0px;float:left; width:580px">
                                <input type="button" onclick="window.location='index.php';"
                                value="ACTUALIZAR PÁGINA" style="width:300px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="actualiza página"/>
                            </div><!-- end .realizarapuesta -->
                        </div><!-- end .centroapuesta -->
						<input type="hidden" name="MM_insert" value="form1" />
						<input type="hidden" name="ser_venta" value="" />
						<input type="hidden" name="ticket" value="" />
						<input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset5['cod_taquilla']; ?>" />
						<input type="hidden" name="fec_venta" value=""/>
						<input type="hidden" name="hor_venta" value="" />
						<input type="hidden" name="id_usuario" value="" />
						<input type="hidden" name="est_ticket" value="1" />
						<input type="hidden" name="est_gan" value="<?php echo $est_gan; ?>" />
						<input type="hidden" name="est_pla" value="<?php echo $est_pla; ?>" />
						<input type="hidden" name="est_sho" value="<?php echo $est_sho; ?>" />
						<input type="hidden" name="est_exa" value="<?php echo $est_exa; ?>" />
						<input type="hidden" name="est_tri" value="<?php echo $est_tri; ?>" />
						<input type="hidden" name="est_sup" value="<?php echo $est_sup; ?>" />
						<input type="hidden" name="apMinGan" value="<?php echo $apMinGan; ?>" />
						<input type="hidden" name="apMinPla" value="<?php echo $apMinPla; ?>" />
						<input type="hidden" name="apMinSho" value="<?php echo $apMinSho; ?>" />
						<input type="hidden" name="apMaxGan" value="<?php echo $apGaMax; ?>" />
						<input type="hidden" name="apMaxPla" value="<?php echo $apPlMax; ?>" />
						<input type="hidden" name="apMaxSho" value="<?php echo $apShMax; ?>" />
						<input type="hidden" name="apMinExa" value="<?php echo $apMinExa; ?>" />
						<input type="hidden" name="apMinTri" value="<?php echo $apMinTri; ?>" />
						<input type="hidden" name="apMinSup" value="<?php echo $apMinSup; ?>" />
						<input type="hidden" name="apMaxExa" value="<?php echo $apExMax; ?>" />
						<input type="hidden" name="apMaxTri" value="<?php echo $apTrMax; ?>" />
						<input type="hidden" name="apMaxSup" value="<?php echo $apSuMax; ?>" />
						<input type="hidden" name="monMaxTi" value="<?php echo $monMaxTi; ?>" />
						<input type="hidden" name="monMaxEj" value="<?php echo $monMaxEj; ?>" />
						<input type="hidden" name="ejeMinC" id="ejeMinC" value="<?php echo $ejeMinCar; ?>" />
					</form>
                </div><!-- end .izquierda -->
                <div id="derecha" style="font-size:16px;width:39.6%;float:left; background:#e0e0e0;height:386px;
                    margin:0px 0px 0px 2px; color:#000">
					<div id="men_pagar" style="font-size:12px; background: #333;width:99.3%; float:left; height:13px; 
						text-align: left; padding:1px 0px 0px 3px; color: #FFF; line-height:13px;border-bottom: 1px black solid;">
						Última jugada realizada:
					</div><!-- end .men_pagar --> 
					<div id="men_pagar" style="font-size:10px; background: #333;width:99.3%; float:left; height:33px; 
						text-align: left; padding:0px 0px 0px 3px; color: #FFF;border-bottom: 1px black solid;">
						<?php include("ventas_ver_ultimo.php");?>
					</div><!-- end .men_pagar --> 
					<div id="men_pagar" style="font-size:24px; background: #333;width:99.3%; float:left; height:30px; 
						text-align:center; padding:19px 0px 0px 3px; color: #FFF">
						PAGAR/ELIMINAR APUESTA
					</div><!-- end .men_pagar -->


                    <div id="pagarapuesta" style="font-size:16px; width:99.3%; height:70.6%; float:left; text-align:center; 
                        padding:15px 0px 0px 3px;">
                        <form method="post" id="form2"><?php
                            if ($pedirCodigoPago==0) {?>
                                INSERTAR CÓDIGO DE TICKET:<br/>
                                <input type="text" name="pagarT" style="width:220px; height:30px; font-size:20px" 
                                onclick="clean(),clean2()" id="pagarT" onkeypress="javascript:return validarNro(event)"/><br/>
                                <div id="pagaTicket" style="height:50px; width:99%; float:left; padding:20px 0px 0px 0px;">
                                <input type="submit" id="buttonverde" onclick="clean()" value="Procesar Pago" 
                                 title="paga apuesta" style="width:180px; font-size:18px; height:40px"
                                 <?php if ($est_control_pagos==1) {
                                echo 'disabled="disabled"';
                            } ?>/>
                                </div>
                                <div id="eliminaTicket" style="height:50px; width:99%; float:left; padding:30px 0px 0px 0px;">
                                <input type="submit" id="buttonrojo" onclick="clean()" value="Eliminar ticket" 
                                 title="elimina apuesta" style="width:180px; font-size:18px; height:40px"/>
                                </div>
                                <input type="hidden" name="id_usuario_pago" value="<?php echo $usuarioVenta; ?>" /><?php
                            } else {?>
                                <div id="pagTicket" style="height:50px; width:97%; float:left; padding:80px 0px 0px 0px ">
                                    <input type="button" style="width:180px; font-size:18px; height:40px" 
                                    value="Ir a pagar apuesta" 
                                    onclick="javascript:window.open('pag_tic_sincodigo.php?recordID=<?php echo $pedirCodigoPago?>&uVenta=<?php echo $usuarioVenta?>', '_blank');" <?php if ($est_control_pagos==1) {
                                echo 'disabled="disabled"';
                            } ?>/>
                                </div>
                                <div id="eliTicket" style="height:50px; width:97%; float:left; padding:30px 0px 0px 0px ">
                                <input type="button" style="width:180px; font-size:18px; height:40px" 
                                    value="Ir a eliminar ticket" 
                                    onclick="javascript:window.open('eli_tic_sincodigo.php?recordID=<?php echo $pedirCodigoPago?>&uVenta=<?php echo $usuarioVenta?>', '_blank');"/>
                                </div><?php
                             }?>
                        </form>
                        <div id="pagamensaje" style="height:185px; width:99%; float:left; color:#CC0000;line-height:15px; 
                            text-align:center; margin:-3px 0px 0px 0px; background:#e0e0e0; display:none; padding:0px 0px 0px 3px ">
                        </div>
                    </div><!-- end .pagarapuesta -->
				</div>
            </div><!-- end .jugada -->
        </div><!-- end .content -->



 <div id="mensajeChat" style="font-size:16px; height:177px; width:100%; float:left; 
                    	text-align:center; padding:0px 0px 0px 0px;">
                        
                        <div id="membreteChat" style="font-size:12px; height:18px; width:99.5%; float:left; text-align:left; 
                    		padding:10px 0px 0px 5px; color: #FFF; background:#23528c; border-top-style: 
                        	solid;border-top-width: thin; border-top-color: #FFF;">
                            Por favor, ante cualquier duda o inconveniente envíenos un mensaje por este medio,
                             será respondido en breve
                        </div><!-- end .membreteChat -->
                        <div id="Chat" style="font-size:11px; height:90px; width:100%; float:left; text-align:left; 
                    		padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
                            position: relative;z-index: 0;" onmouseover="stopChat()" onmouseout="startChat()" >
	                            <?php include("../ventas/ventas_chat_mostrar.php");?>


                        </div><!-- end .Chat -->
                        <form method="post" id="form3">
                            <div id="enviarChat" style="font-size:18px; height:500px; width:89.6%; float:left; text-align:left; 
                                padding:0px 0px 0px 0px;">
                                <textarea id="txtMensaje" name="txtMensaje" placeholder="ESCRIBA SU MENSAJE AQUÍ" 
                                style="width:98%; height:50px; overflow: auto;resize:none; border: 1px solid #888; font-size:12px;
                                font-family: Arial, Helvetica, sans-serif;"></textarea>
                            </div><!-- end .Chat -->
                            <div id="enviarBoton" style="font-size:14px; height:50px; width:98px; float:RIGHT; text-align: center; 
                                padding:5px 0px 0px 0px; border-top: 1px solid #888;">
                                <input name="enviarChatBoton" type="button" id="enviarChatBoton" 
                                    style="height:45px; background: #CCC; border-color:#CCC; color: #333"
                                    tabindex="<?php echo $x;?>" 
                                    value="ENVIAR"/>
                            </div><!-- end .Chat -->
                            <input type="hidden" name="cod_taquilla_chat" value="<?php echo $taquilla; ?>" />
                            <input type="hidden" name="nom_usuario_chat" value="<?php echo $_SESSION['MM_Username']; ?>" />
                        </form>    

              </div><!-- end .mensajeChat -->  





        <div class="footer">EN CASO DE CUALQUIER INCONVENIENTE COMUNICARSE AL ( LLAMADA SMS WHATSAPP 04140698143 ) - (SOLO LLAMADA Y SMS 04167622603) <!-- end .footer --></div>
    </div><!-- end .container -->
</body>
</html>
<script language="javascript">document.getElementById("numCa44").focus();</script>
<?php
mysqli_free_result($Recordset1);mysqli_free_result($Recordset4);mysqli_free_result($Recordset5);?>
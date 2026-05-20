<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include("../includes/libreria.php");
$usuario=$_SESSION['MM_id_usuario'];
$nom_usuario=$_SESSION['MM_nom_usuario'];
$query_Recordset6 = sprintf(
    "/* PARSEADORES1 ventaslotan\index.php - QUERY 1 */ SELECT 
		ag.cod_agencia, ba.cod_banca, ba.con_tope, ta.nom_taquilla, ta.cod_taquilla, tp.est_venta_lot, tp.ord_turno, tp.est_venta_ani,
		ta.est_taquilla
		FROM 
			usuario us, 
			agencia ag,
			banca ba,
			taquilla ta,
			taquilla_opc_lot tp 
		WHERE 
			us.id_usuario = %s AND 
			us.cod_taquilla = ta.cod_taquilla AND
			ag.cod_agencia = ta.cod_agencia AND
			ba.cod_banca = ag.cod_banca AND
			tp.cod_taquilla = ta.cod_taquilla 
		LIMIT 1",
    GetSQLValueString($usuario, "int")
);
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);
if (($totalRows_Recordset6>0 && $row_Recordset6['est_venta_ani']==0) or $totalRows_Recordset6<=0) {
    if ($totalRows_Recordset6<=0) {
        $_SESSION['MM_systemO']=0;
    } elseif ($row_Recordset6['est_venta_ani']==0) {
        $_SESSION['MM_systemO']=1;
    }
    $MM_redirectLoginSuccess = "../no_opciones.php";
    header("Location: ".$MM_redirectLoginSuccess);
}
$nom_taquilla=$row_Recordset6['nom_taquilla'];
$agencia=$row_Recordset6['cod_agencia'];
$banca=$row_Recordset6['cod_banca'];
$con_tope=$row_Recordset6['con_tope'];
$taquilla=$row_Recordset6['cod_taquilla'];
$ord_turno_lot=$row_Recordset6['ord_turno'];
$_SESSION["ocarritoAni"] = new carrito();
include('lista_animalitos.php');
include('../ventaslot/mensajes_lot.php');
$query_Recordset19 = sprintf("/* PARSEADORES1 ventaslotan\index.php - QUERY 2 */ SELECT est_control_ventas_lot, est_control_pagos_lot
	FROM ctrol_ventpag_global_lot LIMIT 1");
$Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
$row_Recordset19 = mysqli_fetch_assoc($Recordset19);
$totalRows_Recordset19 = mysqli_num_rows($Recordset19);
$est_control_ventas=$row_Recordset19['est_control_ventas_lot'];
$est_control_pagos=$row_Recordset19['est_control_pagos_lot'];
if (isset($Recordset19)) {
    mysqli_free_result($Recordset19);
}
if ($est_control_ventas==1) {
    $_SESSION['MM_mensaje1']="VENTAS PAUSADAS MOMENTANEAMENTE<br/>POR FAVOR INTENTELO MAS TARDE";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link href="../css/ventaslot2.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/iconfont/css/font-awesome.min.css">
<!--[if IE 7]>
<link rel="stylesheet" href="../css/iconfont/css/font-awesome-ie7.min.css">
<![endif]-->
<!--[if lt IE 8]><link href="../css/styleIE7.css" rel="stylesheet"> <!--<![endif]-->
<style> 
	body{ background:#e0e0e0;} 
	td{ border-bottom: 1px solid #CCC;}
	input:focus {outline-color:green;}
	button:focus {outline-color:green; background:#F9E209}
</style>
<script type="text/javascript" src="../admin_lot/jslot/jquery-1.9.1.min.js"></script>
</script><script src="../admin_lot/jslot/fjava_lot.js"></script>
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true;}else{alert("El formulario ya está siendo enviado, por favor aguarde un instante.");return false;}}
var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
var esper1 = '<div style="padding:50px 0px 0px 0px;font-size:20px"><i class="fa fa-spinner fa-spin fa-2x"></i>';
var esper2 = '<br/>En Proceso! Por favor espere ...</div>';</script>
<script type="text/javascript">
	var mensaje ="";
	var refresLot = null;
	var chkeo = "";
	document.cookie ='xvar='+chkeo;	
	function cfon(div, id){if(document.getElementById(id).checked == true) document.getElementById(div).style.background="#ABC900";
	else document.getElementById(div).style.background="#EDEDED";foco("mon_apuesta");}
	function startListaLot() {
		refresLot = setInterval(function() {
			var age=document.getElementById('agencia').value;
			var ban=document.getElementById('banca').value;
			var tur=document.getElementById('ord_turno').value;
			var rA=Math.random();
			var parametros = { "banca":ban, "agencia":age, "ordturno":tur, "rA":Math.random() };
			$.ajax({ data:parametros, url:'lista_animalitos.php', type:'GET',
				beforeSend: function(){
					esper1="espere..."; 
					$('#loteria').html(esper1);
				},
				success:function (response) { 
					$("#loteria").html(response);
					foco('mon_apuesta');
				},
				error: function(){
					var menError1='<br/><div style="font-size:18px;float:left; width:330px; height:62px;background:#FFF;';
					var menError2='padding:80px 0px 0px 0px;text-align:center; color:#C00; line-height:25px;">';
					var menError3='NO HAY RESPUESTA DEL SERVIDOR!';
					var menError4='<a href="javascript:location.reload()" style="color:#000000"><br/>';
					var menError5='Presione <u>aquí</u> para actualizar la página</a>';
					var menError6='</div>'; 
				$("#loteria").html(menError1+menError2+menError3+menError4+menError5+menError6);
				} 
			}); 
		}, 109000);
		foco('mon_apuesta');
	}
	function PJugada(){
		var control=1, sel=0;
		if ($("input:checkbox:checked").each(function(){sel++;}));
		if (sel>0) {
			if($("#mon_apuesta").val() <=0) { 
				alert("Indique monto de jugada"); 
				control=0; 
				statusEnvio=false;
				foco("mon_apuesta");
			}
			if (control==1) {
				var monto=$("#mon_apuesta").val();
				$('#anadir').prop("disabled", true);
				var url = "t_procesarjugada.php"; // El script en dónde se realizará la petición.
				var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
				var esper1 = '<div style="padding:50px 0px 0px 0px;font-size:20px"><i class="fa fa-spinner fa-spin fa-2x"></i>';
				var esper2 = '<br/>En Proceso! Por favor espere ...</div>';
				$.ajax({ type: "POST", url: url, global : false, data: $(form1).serialize(), dataType: "html",
					beforeSend: function(){ 
						$('#cesta').html(esper1+esper2);
						$('#anadir').prop('disabled', true);
					},
					success: function(data) {
						$("#cesta").html(data);
						$('#anadir').prop("disabled", false);
						$("#btotal").load("t_total.php");
						$("#bimprimir").load("t_botonimprimir.php");
						$("#blimpiar").load("t_botonlimpiar.php");
						var target = document.getElementById('cesta');
						var isScrolledToBottom = target.scrollTop + target.offsetHeight >= target.scrollHeight;
						target.scrollTop = target.scrollHeight - target.offsetHeight;
						document.getElementById("mon_apuesta").value=monto;
						setTimeout(function () {document.getElementById("mon_apuesta").focus();}, 50);
					},
					error: function(){ 
						$("#cesta").html(xerror);
						$('#anadir').prop("disabled", false);
					}
				});
			}
			statusEnvio=false;
		}
		else {
			alert("Seleccione sorteo"); 
			statusEnvio=false; foco("mon_apuesta");
		}
		
	}
	$(document).ready(function() {
		startListaLot();
		$("input[type=text]").focus(function(){this.select();});
		$("#anadir").click(function(){PJugada();});
		$("#loteria").load("lista_animalitos.php?&banca=<?php echo $banca;?>&agencia=<?php echo $agencia;?>&ordturno=<?php echo $ord_turno_lot;?>&rA="+Math.random());
		$("#bRepetir").click(function(){ repetirTicketANI(); return false; });
	});
</script> 
<script type="text/javascript"> 
function repetirTicketANI() {
	if(typeof(document.getElementById("repetirT")) !== "undefined"){
		if (document.getElementById("repetirT").value!="") {
			var url = "repetir_ticket_lotan.php"; // El script en dónde se realizará la petición.
			$.ajax({ type: "POST", url: url, global : false, data: $(form2).serialize(), dataType: "html",
				beforeSend: function(){
					$('#cesta').html(esper1+esper2);
					$('#bRepetir').prop('disabled', true);
				},
				success: function(data) {
					$("#cesta").html(data);
					$('#anadir').prop("disabled", false);
					$("#btotal").load("t_total.php");
					$("#bimprimir").load("t_botonimprimir.php");
					$("#blimpiar").load("t_botonlimpiar.php");
					var target = document.getElementById('cesta');
					var isScrolledToBottom = target.scrollTop + target.offsetHeight >= target.scrollHeight;
					target.scrollTop = target.scrollHeight - target.offsetHeight;
					setTimeout(function () {document.getElementById("mon_apuesta").focus();}, 50);
					$('#bRepetir').prop('disabled', false);
				},
				error: function(){ 
					$("#cesta").html(xerror);
					$('#bRepetir').prop("disabled", false);
					$('#anadir').prop("disabled", false);
					$("#btotal").load("t_total.php");
					$("#bimprimir").load("t_botonimprimir.php");
					$("#blimpiar").load("t_botonlimpiar.php");
					$('#bRepetir').prop('disabled', false);
				}
			});
		}
		//document.getElementById("repetirT").value="";
	}
}
function cargar(id){
	$("#cesta").load("del_jugada_carrito.php", { id: id }, function(){
        $("#btotal").load("t_total.php");
		$("#blimpiar").load("t_botonlimpiar.php");
		$("#bimprimir").load("t_botonimprimir.php");
		foco('mon_apuesta');
      });
}
function verificarActivar() {
	var varAct2=document.getElementById('mon_apuesta').value;
	if (varAct2>0) {
		$('#anadir').prop('disabled', false);
		document.getElementById("imganadir").src="../img/add.png";
	}
}
function GetIEVersion(){
	var sAgent=window.navigator.userAgent;
	var Idx=sAgent.indexOf("MSIE");
	if (Idx > 0) return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));
	else if(!!navigator.userAgent.match(/Trident\/7\./))return 11;else return 0;}
	if (navigator.appName=='Microsoft Internet Explorer' || GetIEVersion()>0){
		document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');
		if(!factory.object){
			c=confirm('Por favor, descargue el Active X, Presionando Aceptar, la cual permitirá que el software pueda Imprimir, instálelo y al finalizar la instalación reinicie su equipo e intente de nuevo.');
			if(c==true){window.location = 'http://1h.superamericanas.com:5825/smsx.exe';}
			else window.location='../acceso.php';
		}
}
function imprimeTicket(){
	if(typeof(document.getElementById("imprimir")) !== "undefined"){
		if (document.getElementById("imprimir").disabled == false) {
			t=confirm('¿Quiere imprimir el ticket?');
			if(t==true) document.getElementById("form1").submit();
		} 
	}
	foco('mon_apuesta');
}
function triterANI() {cambiarOn('monto');cambiarOn('cargar');}
function validarNro(e) { cuenta=0;var key; if(window.event) { key = e.keyCode; } else if(e.which) { key = e.which; } 
if (key < 48 || key > 57) { if(key == 8 ) { return true; } else { return false; } } return true;}
function limpiaDiv(id) {$(id).html("");}
function desabilitAll(id2) {$('.'+id2).removeAttr("checked");$('.2'+id2).css('background-color','#EDEDED');}		
</script>
</head>
<body onload="foco('mon_apuesta'); Javascript:history.go(1);" onunload="Javascript:history.go(1);">
    <div id="container" class="container">
		<div id="header" class="header" style="background:#333333;">
            <?php include("../includes/cabeceraventaslot.php");?>
		</div>
		<div id="content" class="content" style="border:2px solid #000000; height:100%; width:99.6%;">
            <div id="taquilla" class="taquilla" style="width:100%">
                <div id="datos" class="datos" style="background:#333; width:300px;float:left;">
                    TAQUILLA DE VENTAS: <?php echo strtoupper($row_Recordset6['nom_taquilla']); ?>
                </div>
				<div style="float:left; font-size:26px;padding:3px 0px 0px 0px; color:#FFFFFF;width:309px;background:#333;">
                <?php echo "ANIMALITOS/FRUTAS"; ?>
				</div>
                <div id="usuario" class="usuario" style="background:#333; width:322px; float:left">
                    <?php echo "Usuario: ".strtoupper($nom_usuario); ?> | <?php echo vfechaActual(); ?>
                </div>
            </div>
            <div id="mensaje" class="mensaje" style="font-size:14px">
            	<?php echo $_SESSION['MM_mensaje1']; ?>
            </div>
            <div id="prueba">
            </div>
			<div id="jugadalot" class="jugadalot" style="color:#000000;">
				<form method="post" name="form1" id="form1" autocomplete="off" action="guardar_ticket.php" 
                onsubmit="return chequearEnvio()">
                    <div id="sorCart" style="width:70%;float:left;height:100%;padding: 2px 0px 2px 0px;border-top-width:1px;
                        border-top-style:solid;border-left-style:none;border-top-color:#999;">
                        <div id="sorteos" style="width:49.5%; float:left; margin: 2px 0px 2px 0px;border-top-width:1px;
                            border-top-style:solid;border-left-style:none;border-top-color:#999;height:84%;">
                            <div style="background:#333;float:left;width:40%;height:30px;padding:20px 0px 0px 0px;
                                font-size:18px; color:#FFF;">
                                    SORTEOS
                            </div>
                            <div id="ticCre" style="background:#333;float: right;width:59%;font-size:14px;height:41px; 
                                padding:9px 3px 0px 0px; line-height: 1; text-align:right">
                                <div style="float:left;width:100%;font-size:14px;height:10px;
                                   color:#CCC;">
                                    Ticket creados por Vendedor:
                                    <font color="RED" size="5">
                                        <?php $modulo=2; include("../includes/infoNumeroTicket_lot.php");?>
                                    </font>
                                </div>
                            </div>
                            <?php if ($est_control_ventas==1) {
    $disp="display:none";
} else {
    $disp="";
}?>
                            <div id="loteria" style="text-align:left; height:365px; float:left; width:337px;<?php echo $disp;?>">
                            </div>
                        </div>
                        <div id="apuOpci" style="width:50%; height:50px; float:left; background: #E2E2E2">
                            <div id="apuestas" style="width:100%;float:left;text-align:left;height:60px;padding:0px 0px 0px 0px;">
                                <div id="monto" style="float: left; width:28%; padding:0 0 0 25%">
                                    Monto:
                                    <input style="height:30px; width:80px; font-size:28px"  name="mon_apuesta" 
                                    onkeypress="return numerospunto(event)" onFocus="selectTodo('mon_apuesta')" 
                                    tabindex="2" type="text" value="<?php echo $valormonto ?>" 
                                    size="1" maxlength="5" title=" monto de apuesta " id="mon_apuesta"
                                    <?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
    echo "disabled='disabled'";
} ?> 
                                    onKeyUp="return handleEnter(this, event)"/>
                                </div>
                                <div id="cargar" style="float: left; width:18%; text-align:left;">
                                    <button onClick="return chequearEnvio()" type="button" tabindex="3" value="anadir" 
                                    name="anadir"
                                    title=" añadir a ticket " style="background-color:#E9E9E9; width:52px; height:52px; 
                                    padding:0px 1px 1px 0px" 
                                   <?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
    echo "disabled='disabled'";
}?> 
                                    id="anadir" ><i class="fa fa-plus-circle fa-3x" style="color:#060;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="carrito" style="background:#E2E2E2;width:50%;float:left;margin: 2px 0px 2px 2px;
                            border-top-width:1px; border-top-style:solid;border-top-color:#999;border-left-width:1px; 
                            padding: 1px 0px 5px 0px; border-left-style:solid;border-left-color:#999;height:85%;">
                            <div style="background:#333; float:left; width:15%; font-size:14px;height:30px;padding:8px 0px 2px 2px;
                                color:#FFFFFF">Número
                            </div>
                            <div style="background:#333; float:left; width:20%; font-size:14px;height:30px;padding:8px 0px 2px 0px;
                                color:#FFFFFF">Monto
                            </div>
                            <div style="background:#333;float:left;width:64%;font-size:14px;height:30px;padding:8px 0px 2px 0px;
                                color:#FFFFFF">Sorteo
                            </div>
                            <div id="cesta" style="float:left;overflow:auto;width:100%;height:275px;font-size:12px; 
                                background: #F5F5F5">
                                <?php $_SESSION['MM_montoAni']=$_SESSION["ocarritoAni"]->imprime_carrito(); ?>
                                <input type="hidden" name="impmont" id="impmont" value="<?php echo  $_SESSION['MM_montoAni']; ?>" /> 
                            </div>
                            <div style=" float:left;width:33%; height:13.2%; padding:2px 0px 0px 10px" >
                                <div id="bimprimir" style="float:left; padding:0px 15px 0px 0px;text-align:center">
                                    <?php include('t_botonimprimir.php');?>
                                </div>
                                <div id="blimpiar" style="float:left;text-align:center">
                                    <?php include('t_botonlimpiar.php');?>
                                </div>
                            </div>
                            <div id="btotal" style="float:left;text-align:right;height:40px;width:63%;
                                font-size:26px;padding:5px 0px 0px 0px">
                                <?php echo "Total: ".number_format($_SESSION['MM_montoAni'], 2, ",", "."); ?>
                            </div>          
    
                        </div>
                    </div>
                    <input type="hidden" name="banca" id="banca" value="<?php echo $banca; ?>" />
                    <input type="hidden" name="con_tope" id="con_tope" value="<?php echo $con_tope; ?>" />
                    <input type="hidden" name="agencia" id="agencia" value="<?php echo $agencia; ?>" />
                    <input type="hidden" name="taquilla" id="taquilla" value="<?php echo $taquilla; ?>" />
                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" />
                    <input type="hidden" name="ord_turno" id="ord_turno" value="<?php echo $ord_turno_lot; ?>" />
                    <input type="hidden" name="MM_insert" value="form1" />
                </form>
            	<div id="pagaeli" style="width:29.8%; float:left; height:99%; border-left:1px solid #999;
                	border-top:1px solid #999; padding:0px 0px 3px 0px; background:#e0e0e0">
                    <div id="ultTicket" style="font-size:12px; background: #333;  width:99%; float:left; height:13px; 
                    	text-align: left; padding:2px 0px 0px 3px; color: #FFF; line-height:13px;
                        border-bottom: 1px black solid;">
                        Última jugada realizada:
                    </div>
                    <div id="menu1" style="font-size:12px; background: #333;  width:99%; float:left; height:48px; 
                    	text-align: left; padding:0px 0px 0px 3px; color: #FFF;border-bottom: 1px black solid;">
                        <?php include("ventas_ver_ultimo_lot.php");?>
                    </div>
                    <div id="pagaEli" style="font-size:20px; background: #333;  width:100%; float:left; height:32px; 
                    	text-align:center; padding:9px 0px 0px 0px; color: #FFF">
                   	  	REPETIR TICKET ANIMALITOS
                    </div>
                    <div id="pagarapuesta" style="font-size:16px; width:99.3%; height:74.6%; float:left; text-align:center; 
                        padding:2px 0px 0px 3px;">
                        <form method="post" id="form2">
							INSERTAR CÓDIGO DE TICKET:
							<div id="codigoTicket" style="height:32px; width:99%; float:left; margin:0px 0px 0px 0px;">
                                <input type="text" name="repetirT" style="width:170px; height:24px; font-size:20px" 
									id="repetirT" onkeypress="javascript:return validarNro(event)" value=""
                                    onClick="triterANI()" 
									<?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
    echo 'disabled="disabled"';
} ?>/>
								<input type="submit" id="bRepetir" onclick="limpiaDiv('#repTicket')" value="Buscar" 
									title="buscar ticket" style="width:80px; font-size:16px; height:30px"
                                    <?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
    echo 'disabled="disabled"';
} ?>/>
                                    
							</div>
							<div id="repTicket" style="height:162px; width:99%; float:left;border-bottom:1px solid #D5D5D5;">
							</div>
							<div id="pagTicket" style="height:42px; width:99%; float:left; padding:10px 0px 0px 0px;">
								<input type="button" style="width:180px; font-size:18px; height:40px" value="Ir a pagar apuesta" 
                                onclick="javascript:window.open('../ventaslot/pagar_ticket_lot.php?uVenta=<?php echo $usuario; ?>',
                                    '_blank');" 
									<?php if ($est_control_pagos==1) {
    echo 'disabled="disabled"';
} ?>/>
							</div>
							<div id="eliTicket" style="height:42px; width:99%; float:left; padding:2px 0px 0px 0px;">
                                <input type="button" style="width:180px; font-size:18px; height:40px" value="Ir a eliminar ticket" 
                                onclick="javascript:window.open('../ventaslot/eliminar_ticket_lot.php?uVenta=<?php echo $usuario; ?>',
                                    '_blank');"/>
							</div>
                            <input type="hidden" name="usRep" id="usRep" value="<?php echo $usuario; ?>" />
							<input type="hidden" name="taRep" id="taRep" value="<?php echo $taquilla; ?>" />
							<input type="hidden" name="agRep" id="agRep" value="<?php echo $agencia; ?>" />
						</form>
                        <div id="pagamensaje" style="height:185px; width:99%; float:left; color:#CC0000;line-height:15px; 
                            text-align:center; margin:-3px 0px 0px 0px; background:#e0e0e0; display:none; padding:0px 0px 0px 3px ">
                        </div>
                    </div><!-- end .pagarapuesta -->
                </div>
			</div>            
		</div>
		<div class="footer footerlot" style="background: #333333;"><?php echo piedepagina(); ?><!-- end .footer --></div>
	</div>
</body>
</html>
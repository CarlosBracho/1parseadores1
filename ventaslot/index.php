<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include("../includes/libreria.php");
$usuario=$_SESSION['MM_id_usuario'];
$nom_usuario=$_SESSION['MM_nom_usuario'];
$query_Recordset6 = sprintf(
    "/* PARSEADORES1 ventaslot\index.php - QUERY 1 */ SELECT 
		ag.cod_agencia, ba.cod_banca, ba.con_tope, ta.nom_taquilla, ta.cod_taquilla, tp.est_venta_ani, tp.est_venta_lot, tp.ord_turno,
		ta.est_taquilla
		FROM 
			usuario us, 
			agencia ag,
			banca ba,
			taquilla ta, 
			taquilla_opc_lot tp 
		WHERE 
			tp.cod_taquilla = ta.cod_taquilla AND
			us.id_usuario = %s AND 
			us.cod_taquilla = ta.cod_taquilla AND
			ag.cod_agencia = ta.cod_agencia AND
			ba.cod_banca = ag.cod_banca
		LIMIT 1",
    GetSQLValueString($usuario, "int")
);
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);
if (($totalRows_Recordset6>0 && $row_Recordset6['est_venta_lot']==0) or $totalRows_Recordset6<=0) {
    if ($totalRows_Recordset6<=0) {
        $_SESSION['MM_systemO']=2;
    } elseif ($row_Recordset6['est_venta_lot']==0) {
        $_SESSION['MM_systemO']=3;
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
$query_Recordset19 = sprintf("/* PARSEADORES1 ventaslot\index.php - QUERY 2 */ SELECT est_control_ventas_lot, est_control_pagos_lot
	FROM ctrol_ventpag_global_lot LIMIT 1");
$Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
$row_Recordset19 = mysqli_fetch_assoc($Recordset19);
$totalRows_Recordset19 = mysqli_num_rows($Recordset19);
$est_control_ventas=$row_Recordset19['est_control_ventas_lot'];
$est_control_pagos=$row_Recordset19['est_control_pagos_lot'];
if (isset($Recordset19)) {
    mysqli_free_result($Recordset19);
}

$_SESSION["ocarrito"] = new carrito();
include('lista_loterias.php');
include('../ventaslot/mensajes_lot.php');
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
	table{border-collapse: collapse;} 
	td{ border-bottom: 1px solid #CCC;}
	input:focus {outline-color:green;}
	button:focus {outline-color:green; background:#F9E209;}
</style>
<script type="text/javascript" src="../admin_lot/jslot/jquery-1.9.1.min.js"></script>
<script src="../admin_lot/jslot/fjava_lot.js"></script>
<script type="text/javascript" src="../admin_lot/jslot/botonLot.js"></script>
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true;}else{alert("El formulario ya está siendo enviado, por favor aguarde un instante.");return false;}}
var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
var esper1 = '<div style="padding:50px 0px 0px 0px;font-size:20px"><i class="fa fa-spinner fa-spin fa-2x"></i>';
var esper2 = '<br/>En Proceso! Por favor espere ...</div>';</script>

<script type="text/javascript">
	var mensaje ="";
	var refresLot = null;
	var chkeo = "";
	tiemRefresLot=109000;
	tiemRefresLot=509000;
	document.cookie ='xvar='+chkeo;	
	function cfon(div, chec, tip) {
		if(document.getElementById(chec).checked) { document.getElementById(div).style.background="#333333"; 
			document.getElementById(div).style.color="#FFF";}
		else { document.getElementById(div).style.background="#FFF"; document.getElementById(div).style.color="#000";}
		chk=document.getElementsByName('lot_apuesta[]');
		for(i=0;i<chk.length;i++) 
			if(chk[i].checked)
				chkeo = chkeo+","+chk[i].value;
		document.cookie ='xvar='+chkeo;	
	}
	function startListaLot() {
		refresLot = setInterval(function() {
			var age=document.getElementById('agencia').value;
			var ban=document.getElementById('banca').value;
			var tur=document.getElementById('ord_turno').value;
			var rA=Math.random();
			var parametros = { "banca":ban, "agencia":age, "ordturno":tur, "rA":Math.random() };
			$.ajax({ data:parametros, url:'lista_loterias.php', type:'GET',
				beforeSend: function(){
					esper1="espere..."; 
					$('#loteria').html(esper1);
				},
				success:function (response) { 
					$("#loteria").html(response);
					foco('num_apuesta');
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
		}, tiemRefresLot);
		foco('num_apuesta');
	}
	function PJugada(){
		var control=1, sel=0;
		if ($("input:checkbox:checked").each(function(){sel++;}));
		if (document.getElementById("RadioGroup1_4").checked == true) sel=1;
		if (sel>0) {
			if( $('#RadioGroup1_0').is(':checked') || $('#RadioGroup1_1').is(':checked') 
				|| $('#RadioGroup1_2').is(':checked') || $('#RadioGroup1_3').is(':checked')) {
				if($("#num_apuesta").val().length < 2) { 
					alert("Indique número de jugada"); 
					control=0; 
					statusEnvio=false;
					foco("num_apuesta");
				}
				else {
					if($("#mon_apuesta").val() <=0) { 
						alert("Indique monto de jugada"); 
						control=0; 
						statusEnvio=false;
						foco("mon_apuesta");
					}
				}
			}
			if( $('#RadioGroup1_4').is(':checked') ) {
				if($("#mon_terminales").val() <=0) { 
					alert("Indique monto a terminales"); 
					control=0; 
					statusEnvio=false;
					foco("mon_terminales");
				}
			}
			if( $('#RadioGroup1_5').is(':checked') ) {
				if($("#inicio").val().length < 2) { 
					alert("Indique número de inicio"); 
					control=0; 
					statusEnvio=false; 
					foco("inicio"); 
				}
				else {
					if($("#fin").val().length < 2) { 
						alert("Indique número final"); 
						control=0; statusEnvio=false;
						foco("fin");
					}
					else {
						if($("#mon_seguidilla").val() <=0) { 
							alert("Indique monto a seguidilla"); 
							control=0; 
							statusEnvio=false;
							foco("mon_seguidilla");}
					}
				}
			}
			if (control==1) {
				$('#anadir').prop("disabled", true);
				document.getElementById('acept_seguidilla').disabled=true;
				document.getElementById('acept_terminales').disabled=true;
				var url = "t_procesarjugada.php"; // El script en dónde se realizará la petición.
				$.ajax({ type: "POST", url: url, global : false, data: $(form1).serialize(), dataType: "html",
					beforeSend: function(){ 
						$('#cesta').html(esper1+esper2);
						$('#anadir').prop('disabled', true);
						$('#acept_seguidilla').prop('disabled', true);
						$('#acept_terminales').prop('disabled', true);
					},
					success: function(data) {
						$("#cesta").html(data);
						$('#anadir').prop("disabled", false);
						$('#acept_seguidilla').prop('disabled', false);
						$('#acept_terminales').prop('disabled', false);
						$("#btotal").load("t_total.php");
						$("#bimprimir").load("t_botonimprimir.php");
						$("#blimpiar").load("t_botonlimpiar.php");
						var target = document.getElementById('cesta');
						var isScrolledToBottom = target.scrollTop + target.offsetHeight >= target.scrollHeight;
						target.scrollTop = target.scrollHeight - target.offsetHeight;
						setTimeout(function () {document.getElementById("num_apuesta").focus();}, 50);
					},
					error: function(){ 
						$("#cesta").html(xerror);
						$('#anadir').prop("disabled", false);
						$('#acept_seguidilla').prop('disabled', false);
						$('#acept_terminales').prop('disabled', false);
					}
				});
				if (document.getElementById("mon_terminales").value>0) { java_triter(); }
				if (document.getElementById("mon_seguidilla").value>0) { java_seguidilla(); }
			}
			statusEnvio=false;
		}
		else {
			alert("Seleccione sorteo"); 
			statusEnvio=false; foco("num_apuesta");
		}
	}
	$(document).ready(function() {
		startListaLot();
		$("input[type=text]").focus(function(){this.select();});
		$("#anadir").click(function(){PJugada();});
		$("#acept_terminales").click(function(){PJugada();});
		$("#acept_seguidilla").click(function(){PJugada();});
		$("#loteria").load("lista_loterias.php?&banca=<?php echo $banca;?>&agencia=<?php echo $agencia;?>&ordturno=<?php echo $ord_turno_lot;?>&rA="+Math.random());
		$("#bRepetir").click(function(){ repetirTicket(); return false; });
	});
</script> 
<script type="text/javascript"> 
function cargar(id){
	$("#cesta").load("del_jugada_carrito.php", { id: id }, function(){
        $("#btotal").load("t_total.php");
		$("#blimpiar").load("t_botonlimpiar.php");
		$("#bimprimir").load("t_botonimprimir.php");
		cambiarOff('termi');
		cambiarOff('segui');
		LenField3('num_apuesta');
		cleanField('num_apuesta');
		foco('num_apuesta');
		document.getElementById('RadioGroup1_0').checked = "checked";
		document.getElementById('num_apuesta').value="";
		foco('num_apuesta');
      });
}
function verificarActivar() {
	var varAct1=document.getElementById('num_apuesta').value.length+1;
	var varAct2=document.getElementById('mon_apuesta').value;
	if (varAct1>=2 && varAct2>0) {
		$('#anadir').prop('disabled', false);
		document.getElementById("imganadir").src="../img/add.png";
	}
}
function cambiartiponumero() {
	document.getElementById("num_apuesta").onKeyPress="return validar_numero(event)";
	document.getElementById('num_apuesta').value="";
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
function imprimeTicket(){if(typeof(document.getElementById("imprimir")) !== "undefined"){
if (document.getElementById("imprimir").disabled == false) {t=confirm('¿Quiere imprimir el ticket?'); 
if(t==true) document.getElementById("form1").submit();}}foco('num_apuesta');}

function validarNro(e) { cuenta=0;var key; if(window.event) { key = e.keyCode; } else if(e.which) { key = e.which; } 
if (key < 48 || key > 57) { if(key == 8 ) { return true; } else { return false; } } return true;}

function limpiaDiv(id) {$(id).html("");}
function repetirTicket() {
	if(typeof(document.getElementById("repetirT")) !== "undefined"){
		if (document.getElementById("repetirT").value!="") {
			var url = "repetir_ticket_lot.php"; // El script en dónde se realizará la petición.
			$.ajax({ type: "POST", url: url, global : false, data: $(form2).serialize(), dataType: "html",
				beforeSend: function(){
					java_triter(); 
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
					setTimeout(function () {document.getElementById("num_apuesta").focus();}, 50);
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
		document.getElementById("repetirT").value="";
	}
}
function triter() { 
cambiarOn('numero');cambiarOn('monto');cambiarOn('cargar');cambiarOff('termi');cambiarOff('segui');
document.getElementById("mon_terminales").value="";document.getElementById("mon_seguidilla").value="";
document.getElementById('RadioGroup1_0').checked="checked";contDiv('informacion','- Triple/Terminal -');LenField3('num_apuesta');}
function openTab(b,d) {$('.bhora').css('background-color','');$('.bhora').css('color','#000');$('.thora').css('display','none');
document.getElementById(d).style.display = "block";document.getElementById(b).style.backgroundColor="#333";
document.getElementById(b).style.color="#FFF";document.getElementById("dAct").value=d;	
return false;
}
function xGrupo(chk, tip) {
	var dAct=document.getElementById("dAct").value;
    var padreDIV=chk; while( padreDIV.nodeType==1 && padreDIV.tagName.toUpperCase()!="DIV" ) padreDIV=padreDIV.parentNode;
	var padreDIVinputs=padreDIV.getElementsByTagName("input");
	for(var i=0; i<padreDIVinputs.length; i++) {
		if (tip==1) { 
        	if( padreDIVinputs[i].getAttribute("type")=="checkbox" && padreDIVinputs[i].getAttribute("id").charAt(3)!="_") {
				//alert(" 1: "+padreDIVinputs[i].getAttribute("class")+" 2:"+dAct);
				var claseActual=document.getElementById(padreDIVinputs[i].getAttribute("id")).className;
				if (claseActual==dAct) {
					padreDIVinputs[i].checked = chk.checked;
					div="loteria"+padreDIVinputs[i].getAttribute("id").substring(3, padreDIVinputs[i].getAttribute("id").length);
					if (padreDIVinputs[i].getAttribute("id").substring(0, 3)=="lot") { 
						if (document.getElementById(padreDIVinputs[i].getAttribute("id")).checked==true)
						{ document.getElementById(div).style.background="#333333"; document.getElementById(div).style.color="#FFF";}
						else { document.getElementById(div).style.background="#FFF"; document.getElementById(div).style.color="#000";}
					}
				}
			}
		}
		if (tip==2) { if(padreDIVinputs[i].getAttribute("type")=="checkbox") padreDIVinputs[i].checked = chk.checked;}
    }
	chk=document.getElementsByName('lot_apuesta[]');
	for(i=0;i<chk.length;i++) if(chk[i].checked) chkeo = chkeo+","+chk[i].value;document.cookie ='xvar='+chkeo;
	foco('num_apuesta');
}

</script>
</head>
<body onload="foco('num_apuesta'); Javascript:history.go(1);" onunload="Javascript:history.go(1);">
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
                <?php echo "LOTERIAS"; ?>
				</div>
                <div id="usuario" class="usuario" style="background:#333; width:322px; float:left">
                    <?php echo "Usuario: ".strtoupper($nom_usuario); ?> | <?php echo vfechaActual(); ?>
                </div>
            </div>
            <div id="mensaje" class="mensaje" style="font-size:14px; color:#FB0509">
            	<?php echo $_SESSION['MM_mensaje1']; ?>
            </div>
            
			<div id="jugadalot" class="jugadalot" style="color:#000000;">
				<form method="post" name="form1" id="form1" autocomplete="off" action="guardar_ticket.php" 
                	onsubmit="return chequearEnvio()">
                    <div id="sorCart" style="width:70%;float:left;height:420px;padding: 2px 0px 2px 0px;border-top-width:1px;
                        border-top-style:solid;border-left-style:none;border-top-color:#999;">
                        <div id="apuOpci" style="width:100%; height:60px; float:left; background: #E2E2E2">
                            <div id="apuestas" style="width:33%;float:left;text-align:left;height:60px;padding:5px 0px 0px 0px;">
                                <div id="numero" style="float:left;width:32%;">
                                    Número:
                                    <input style="height:30px; width:63px; font-size:26px" name="num_apuesta" id="num_apuesta" 
                                    onKeyPress="return validar_numero(event)" type="text" value="" size="5" 
                                    maxlength="3" title=" número de apuesta " tabindex="-1"
                                    <?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
    echo "disabled='disabled'";
} ?> 
                                    onKeyUp="return handleEnter(this, event)"/>
                                </div>
                                <div id="monto" style="float: left; width:38%;">
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
                                <div id="cargar" style="float: left; width:30%; text-align:center;">
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
                                <div id="termi" style="display:none;width:100%;float:left;text-align:left;height:60px;
                                    padding:0px 0px 0px 0px;">
                                    <div style="float:left;width:32%;">&nbsp;</div>
                                    <div id="termi2" style="float: left; width:38%;">
                                        Monto:
                                        <input name="mon_terminales" style="height:30px; width:80px; font-size:20px" tabindex="4"
                                        onkeypress="return numerospunto(event)" onkeydown="return handleEnter(this, event)" 
                                        type="text" value="" size="2" maxlength="3" id="mon_terminales" 
                                        title="indique monto para terminal(es)"/>
                                    </div>
                                    <div id="acept_terminales" style="float:left;width:30%;text-align:center; margin:0px 0px 0px 0px">
                                        <button onClick="return chequearEnvio()" type="button" tabindex="5" value="" 
                                        name="acept_terminales"
                                        title=" cargar terminales " style="background-color:#E9E9E9; width:52px; height:52px;
                                        padding:0px 1px 1px 0px;" 
                                       <?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
    echo "disabled='disabled'";
}?> 
                                        id="acept_terminales" ><?php
                                            if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                                echo '<i class="fa fa-plus-circle fa-3x" style="color:#E1E1E1;"></i>';
                                            } else {
                                                echo '<i class="fa fa-plus-circle fa-3x" style="color:#060;"></i>';
                                            }?>
                                        </button>
                                    </div>
                                </div>
                                <div id="segui" style="display:none;width:100%;float:left;text-align:left;height:60px;
                                    padding:0px 0px 0px 0px;">
                                    <div style="float:left;width:20%;">
                                        Inicio:
                                        <input name="inicio" style="height:30px; width:36px; font-size:20px" 
                                        onkeypress="return solo_numero(event)" tabindex="6"
                                        onKeyUp="return handleEnter(this, event)" type="text" value="" size="2" maxlength="3" 
                                        <?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                                echo "disabled='disabled'";
                                            }?> 
                                        title=" indique número inicio " id="inicio" /> 
                                    </div>
                                    <div style="float: left; width:20%;">
                                        Fin:
                                        <input name="fin" style="height:30px; width:36px; font-size:20px" 
                                        onkeypress="return solo_numero(event)" id="fin" tabindex="7"
                                        onKeyUp="return handleEnter(this, event)" type="text" value="" size="2" maxlength="3" 
                                        <?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                                echo "disabled='disabled'";
                                            }?> 
                                        title=" indique número fin "/>
                                    </div>
                                    <div style="float: left; width:33%; text-align:left;">
                                        Monto:
                                        <input name="mon_seguidilla" style="height:30px;width:62px;font-size:20px" id="mon_seguidilla"
                                        onkeypress="return numerospunto(event)" onKeyDown="return handleEnter(this, event)" 
                                        <?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                                echo "disabled='disabled'";
                                            }?> 
                                        type="text" value="" size="2" maxlength="3" tabindex="8" title=" indique monto a seguidilla"/>
                                    </div>
                                    <div style="float: left; width:23%; text-align:center;">
                                        <button onClick="return chequearEnvio()" type="button" tabindex="9" value="" 
                                        name="acept_seguidilla" title=" cargar seguidilla "
                                        style="background-color:#E9E9E9; width:52px; height:52px;padding:0px 1px 1px 0px;" 
                                       <?php if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                                echo "disabled='disabled'";
                                            }?> 
                                        id="acept_seguidilla" ><i class="fa fa-plus-circle fa-3x" style="color:#060"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="Opciones" style="width:67%; float:left; height:60px; font-size:11px;">
                                <div id="triplesterminales" style="float:left; padding:0px 4px 0px 0px; background:#333; 
                                    color:#FFFFFF; width:67px">
                                    <input type="radio" name="RadioGroup1" value="1" id="RadioGroup1_0" 
                                    title=" triple(s) y/o terminal(es) " onClick="java_triter()" 
                                    <?php if (!(strcmp(htmlentities($rad1, ENT_COMPAT, 'utf-8'), "1"))) {
                                                echo"checked=\"checked\"";
                                            }
                                    if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                        echo "disabled='disabled'";
                                    }?>/>
                                    (T)ri/Ter
                                </div>    
                                <div id="permuta" style="float:left; padding:0px 4px 0px 0px; background:#333; color:#FFFFFF; 
                                    width:67px">
                                    <input onclick="java_permuta();" type="radio" name="RadioGroup1" 
                                    value="2" id="RadioGroup1_1" title=" permuta triple(s) o terminal(es) " 
                                    <?php if (!(strcmp(htmlentities($rad2, ENT_COMPAT, 'utf-8'), "1"))) {
                                        echo "checked=\"checked\"";
                                    }
                                    if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                        echo "disabled='disabled'";
                                    }?> />
                                    (P)ermu
                                </div>
                                <div id="serie" style="float:left; padding:0px 4px 0px 0px; background:#333; color:#FFFFFF;
                                    width:67px">
                                    <input onClick="java_serie()" type="radio" name="RadioGroup1" value="3" id="RadioGroup1_2" 
                                    title=" serie(s) de triple(s) y terminal(es) (*)=comodin " 
                                    <?php if (!(strcmp(htmlentities($rad3, ENT_COMPAT, 'utf-8'), "1"))) {
                                        echo "checked=\"checked\"";
                                    }
                                    if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                        echo "disabled='disabled'";
                                    }?> />
                                    (S)erie
                                </div>
                                <div id="terminalautomatico" style="float:left; padding:0px 4px 0px 0px; background:#333; 
                                    color:#FFFFFF; width:82px">
                                    <input onClick="java_termiauto()" 
                                    type="radio" name="RadioGroup1" value="4" id="RadioGroup1_3" title=" terminal(es) automático(s) " 
                                    <?php if (!(strcmp(htmlentities($rad4, ENT_COMPAT, 'utf-8'), "1"))) {
                                        echo "checked=\"checked\"";
                                    }
                                    if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                        echo"disabled='disabled'";
                                    }?>/>
                                    Term.(a)uto
                                </div>
                                <div id="seguidilla" style="float:left; padding:0px 0px 0px 0px; background:#333; color:#FFFFFF;
                                    width:67px">
                                    <input type="radio" name="RadioGroup1" value="5" id="RadioGroup1_5" 
                                    onclick="java_seguidilla()" title=" seguidilla triple(s) o terminal(es) "<?php
                                    if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                        echo"disabled='disabled'";
                                    }?>/>
                                    Se(g)ui.
                                </div>
                                <div id="terminal" style="float:left; text-align:left; padding:0px 3px 0px 3px; 
                                     background:#333; color:#FFFFFF; width:82px">
                                    <input type="radio" name="RadioGroup1" value="6" id="RadioGroup1_4" 
                                    onclick="java_terminal()" 
                                    title=" terminal(es) de triple(s) cargado(s) "<?php
                                    if ($totalRows_Recordset1<=0 or $est_control_ventas==1) {
                                        echo "disabled='disabled'";
                                    }?>/>
                                    Te(r)minales
                                </div>
                                <div id="informacion" style="height:30px;float:left;color:#F00;font-size:16px; width:96%;
                                    padding:8px 5px 0px 0px; text-align:center; font-weight: bold;" align="center">
                                    - Triple/Terminal -
                                </div>
                            </div>
                        </div>
                        <div id="sorteos" style="width:49.5%; float:left; margin: 2px 0px 2px 0px;border-top-width:1px;
                            border-top-style:solid;border-left-style:none;border-top-color:#999;height:84%;">
                            <div style="background:#333;float:left;width:40%;height:30px;padding:11px 0px 0px 0px;
                                font-size:18px; color:#FFF;">
                                    SORTEOS
                            </div>
                            <div id="ticCre" style="background:#333;float: right;width:59%;font-size:14px;height:41px; 
                                padding:0px 3px 0px 0px; line-height: 1; text-align:right">
                                <div style="float:left;width:100%;font-size:14px;height:10px;
                                   color:#CCC;">
                                    Ticket creados por Vendedor:
                                    <font color="RED" size="5">
                                        <?php $modulo=1; include("../includes/infoNumeroTicket_lot.php");?>
                                    </font>
                                </div>
                            </div>
                            <?php if ($est_control_ventas==1) {
                                        $disp="display:none";
                                    } else {
                                        $disp="";
                                    }?>
                            <div id="loteria" style="text-align:left; height:315px; float:left; width:337px;<?php echo $disp;?>">
                            </div>
                        </div>
                        <div id="carrito" style="background:#E2E2E2;width:50%;float:left;margin: 2px 0px 2px 2px;
                            border-top-width:1px; border-top-style:solid;border-top-color:#999;border-left-width:1px; 
                            padding: 1px 0px 5px 0px; border-left-style:solid;border-left-color:#999;height:83%;">
                            <div style="background:#333; float:left; width:15%; font-size:14px;height:30px;padding:8px 0px 2px 2px;
                                color:#FFFFFF">Número
                            </div>
                            <div style="background:#333; float:left; width:20%; font-size:14px;height:30px;padding:8px 0px 2px 0px;
                                color:#FFFFFF">Monto
                            </div>
                            <div style="background:#333;float:left;width:64%;font-size:14px;height:30px;padding:8px 0px 2px 0px;
                                color:#FFFFFF">Sorteo
                            </div>
                            <div id="cesta" style="float:left;overflow:auto;width:100%;height:77%;font-size:12px; 
                                background: #F5F5F5">
                                <?php $_SESSION['MM_monto']=$_SESSION["ocarrito"]->imprime_carrito(); ?>
                                <input type="hidden" name="impmont" id="impmont" value="<?php echo  $_SESSION['MM_monto']; ?>" /> 
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
                                <?php echo "Total: ".number_format($_SESSION['MM_monto'], 2, ",", "."); ?>
                            </div>          
    
                        </div>
                    </div>
                    <input type="hidden" name="con_tope" id="con_tope" value="<?php echo $con_tope; ?>" />
                    <input type="hidden" name="banca" id="banca" value="<?php echo $banca; ?>" />
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
                   	  	REPETIR TICKET LOTERIA
                    </div>
                    <div id="pagarapuesta" style="font-size:16px; width:99.3%; height:74.6%; float:left; text-align:center; 
                        padding:2px 0px 0px 3px;">
                        <form method="post" id="form2">
							INSERTAR CÓDIGO DE TICKET:
							<div id="codigoTicket" style="height:32px; width:99%; float:left; margin:0px 0px 0px 0px;">
                                <input type="text" name="repetirT" style="width:170px; height:24px; font-size:20px" 
									id="repetirT" onkeypress="javascript:return validarNro(event)" value=""
                                    onClick="triter()" 
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
                                    onclick="javascript:window.open('pagar_ticket_lot.php?uVenta=<?php echo $usuario; ?>','_blank');" 
									<?php if ($est_control_pagos==1) {
                                        echo 'disabled="disabled"';
                                    } ?>/>
							</div>
							<div id="eliTicket" style="height:42px; width:99%; float:left; padding:2px 0px 0px 0px;">
                                <input type="button" style="width:180px; font-size:18px; height:40px" value="Ir a eliminar ticket" 
                                    onclick="javascript:window.open('eliminar_ticket_lot.php?uVenta=<?php echo $usuario; ?>',
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
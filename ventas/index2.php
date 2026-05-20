<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";
date_default_timezone_set("America/Puerto_Rico") ;

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }
        global $conexionbanca;
        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conexionbanca, $theValue) : mysqli_escape_string($conexionbanca, $theValue);
        switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
        return $theValue;
    }
}
$xbanca_Recordset1 = 2;

$horasistema=horaactual();
$fechasistema=fechaactualbd();
$usuarioVenta=$_SESSION['MM_id_usuario'];
$query_Recordset6 = sprintf("/* PARSEADORES1 ventas\index2.php - QUERY 1 */ SELECT 
	tp.est_venta_ame
	FROM usuario us, taquilla_opc_ame tp 
	WHERE tp.cod_taquilla = us.cod_taquilla AND us.id_usuario = %s LIMIT 1", GetSQLValueString($usuarioVenta, "int"));
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);
if ($totalRows_Recordset6<=0) {
    if ($totalRows_Recordset6<=0) {
        $_SESSION['MM_systemO']=8;
    } elseif ($row_Recordset6['est_venta_ame']==0) {
        $_SESSION['MM_systemO']=9;
    }
    $MM_redirectLoginSuccess = "../no_opciones.php";
    header("Location: ".$MM_redirectLoginSuccess);
}
if (isset($Recordset6)) {
    mysqli_free_result($Recordset6);
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$marquesinaretirados="";

$query_Recordset4 = "/* PARSEADORES1 ventas\index2.php - QUERY 2 */ SELECT * FROM mensaje WHERE cod_mensaje = 1";
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
if ($row_Recordset4['est_mensaje']==1) {
    $mensaje1=$row_Recordset4['pri_linea'];
    $mensaje2=$row_Recordset4['seg_linea'];
} else {
    $mensaje1="";
    $mensaje2="";
}
$query_Recordset5 = sprintf(
    "
/* PARSEADORES1 ventas\index2.php - QUERY 3 */ SELECT * FROM usuario, taquilla, taquilla_opc_ame, agencia,
			banca
WHERE usuario.id_usuario = %s AND 
usuario.cod_taquilla = taquilla.cod_taquilla AND
taquilla_opc_ame.cod_taquilla = usuario.cod_taquilla AND
taquilla.cod_agencia = agencia.cod_agencia AND
agencia.cod_banca = banca.cod_banca
LIMIT 1",
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
$taquilla=$row_Recordset5['cod_taquilla'];
$tipotaquilla=$row_Recordset5['tipotaquilla']/1;
$tra_codigo=$row_Recordset5['tra_codigo']/1;
$saldoactual=$row_Recordset5['saldoactual']/1;
$cod_agencia=$row_Recordset5['cod_agencia']/1;
$tipo_pagoa=$row_Recordset5['tipo_pagoa']/1;
$cod_barra=$row_Recordset5['cod_barra']/1;
$efectivoOt=$row_Recordset5['efectivoO']/1;
$est_hnac=$row_Recordset5['est_taquilla_hnac']/1;
$apGaMax=$row_Recordset5['apu_maxgan'];
$apPlMax=$row_Recordset5['apu_maxpla'];
$apShMax=$row_Recordset5['apu_maxsho'];
$apMin=$row_Recordset5['apu_minima'];
$apMinGan=$row_Recordset5['apu_mingan'];
$apMinPla=$row_Recordset5['apu_minpla'];
$apMinSho=$row_Recordset5['apu_minsho'];
$apMinExa=$row_Recordset5['apu_minexa'];
$apMinTri=$row_Recordset5['apu_mintri'];
$apMinSup=$row_Recordset5['apu_minsup'];
$apExMax=$row_Recordset5['apu_maxexa'];
$apTrMax=$row_Recordset5['apu_maxtri'];
$apSuMax=$row_Recordset5['apu_maxsup'];
$monMaxTi=$row_Recordset5['mon_maxticket'];
$ejeMinCar=$row_Recordset5['min_ejecarrera'];

$est_gan=$row_Recordset5['est_gan'];
$est_pla=$row_Recordset5['est_pla'];
$est_sho=$row_Recordset5['est_sho'];
$est_exa=$row_Recordset5['est_exa'];
$est_tri=$row_Recordset5['est_tri'];
$est_sup=$row_Recordset5['est_sup'];
$monMaxEj=$row_Recordset5['mon_maxejemplar'];
$tipo_pago=$row_Recordset5['tipo_pago'];
$moneda=$row_Recordset5['moneda'];
$ejemMax=30;
$totalRows_Recordset1=0;

$query_Recordset7 = sprintf("/* PARSEADORES1 ventas\index2.php - QUERY 4 */ SELECT * FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame =1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_ventas=$row_Recordset7['est_control_ventas_ame'];//todas las ventas globales
$est_control_pagos=$row_Recordset7['est_control_pagos_ame']; //todos los pagos globales

$query_Recordset44 = sprintf("/* PARSEADORES1 ventas\index2.php - QUERY 5 */ SELECT 
	me.mensaje
	FROM agencia ag, taquilla ta, usuario us,  mensajesyalertas me 
	WHERE 
	(me.mostrarhasta >= CURDATE()) AND 
    ((tipo = 3 AND ag.cod_banca = me.para)  OR
	(tipo = 2 AND ta.cod_agencia = me.para)  OR
	(tipo = 1 AND ta.cod_taquilla = me.para)) 	
	AND ag.cod_agencia = ta.cod_agencia AND ta.cod_taquilla = us.cod_taquilla AND us.id_usuario = %s 
	
	ORDER BY RAND() LIMIT 1", GetSQLValueString($_SESSION['MM_id_usuario'], "int"));
$Recordset44 = mysqli_query($conexionbanca, $query_Recordset44) or die(mysqli_error($conexionbanca));
$row_Recordset44 = mysqli_fetch_assoc($Recordset44);
$totalRows_Recordset44 = mysqli_num_rows($Recordset44);
$mensaje44 = trim($row_Recordset44['mensaje']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseVentas.dwt.php" codeOutsideHTMLIsLocked="false" -->

  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="../js/jquery3.6.0.min.js"></script>
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
				var menError3='NO HAY RESPUESTA DEL SERVIDOR! Presione Actualizar PÃƒÂ¡gina';
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
		$.ajax({ data:parametros, url:'ventas_chat_mostrar.php', type:'post',
			success:function (response) { 
				$("#Chat").html(response);
				scrollChat();
			} 
		}); 
	 }, 14000);	}
	function stopChat() {
		clearInterval(refreshId5);
	}
</script>
<script language="javascript">
$(function(){
	$("#enviarChatBoton").click(function(){
		if (document.getElementById('txtMensaje').value!="") {
			var url = 'ventas_chat_enviar.php';
			$('#enviarChatBoton').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form3").serialize(),
				success: function(data) {
					$('#enviarChatBoton').prop("disabled", false);
					document.getElementById('txtMensaje').value="";
					 $("#Chat").load('ventas_chat_mostrar.php?&rA='+Math.random());
					 scrollChat();
				},
			});
			return false; // Evitar ejecutar el submit del formulario.
		} else { cuenta=0; };
	});
});

function scrollChat() {
	 $("#Chat").animate({ scrollTop: $('#Chat')[0].scrollHeight}, 800);
}
</script>
<script>
 $(document).ready(function() {
	 startListaHipodromo();
     startChat();
	 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
	 var refreshId1 = setInterval(function() {
	 	$("#reloj").load('../includes/reloj.php?&js='+Math.random());
	 }, 60000);
	 $("#infocarreras").load('../includes/infoCarrera.php?&js='+Math.random());
	 var refreshId2 = setInterval(function() {
	 	infoC();
	 }, 80000);
	 $("#infoticket").load('../includes/infoTicket.php?&js='+Math.random());
	 var refreshId3 = setInterval(function() {
	 	infoT();
	 }, 70000);
	 	 $("#ultimajugada").load('../includes/infoultimo.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	infou();
	 }, 70000);
	 $("#selecionclientes").load('../includes/seleccionclientesventas.php?&js='+Math.random());
	 var refreshId7 = setInterval(function() {
	 	clien1();
	 }, 70000);
	 $("#mon_canticket").load('../includes/infoNumeroTicket.php?&js='+Math.random());
	 $("#soflow").click(function () {
		 stopListaHipodromo();
	 });
	 scrollChat();
});
</script>
<script type="text/javascript"> 
function handleEnter (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	} 
	else
	return true;
} 
</script>
<script>
function validarNro(e) {
	$('#imprimir').prop("disabled", false);
	cuenta=0;
	var key; if(window.event) { key = e.keyCode; } else if(e.which) { key = e.which; } 
	if (key < 48 || key > 57) { if(key == 8 ) { return true; }
	else { return false; } } return true;
}
function validarNro1(e)
{
var tecla;
tecla = (document.all) ? e.keyCode : e.which;
if(tecla == 8)
{return true;}
var patron;
patron = /[0-9.]/
var te;
te = String.fromCharCode(tecla);
return patron.test(te);
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
function retiroCab() {
	var indice = document.getElementById.soflow.value;
	alert(indice);
}
</script>
<script language="javascript">
$(function(){
	$("#imprimir").click(function(){
		if (document.getElementById('soflow').value!=-1) {
			var porId=document.getElementById('soflow').value;
			
			//$('#imprimir').prop("disabled", true);
			//$('#buttonazul').prop("disabled", true);
			var formul='#formulario';
			var url = 't_grabajugadahipicoticket.php'; // El script en dÃƒÂ³nde se realizarÃƒÂ¡ la peticiÃƒÂ³n.
			var esper1 = '<img src="../images/barraloading.gif" width="128" height="15" />';
			var esper2 = '<font color="red">Guardando jugada! Por favor espere ...</font>';
			var xerror1 = '<font color="red"><h3>NO HUBO RESPUESTA DEL SERVIDOR! Ticket no guardado</h3></font>';
			var xerror2 = '<font color="red"><strong><?php echo $mensaje2; ?></strong></font>';
			$.ajax({ type: "POST", url: url, global : false, data: $("#formulario").serialize(),
			beforeSend: function(){ $('#info1').html(esper1); $('#info2').html(esper2);}, 
				success: function(data) {
					$("#divOculto").html(data);
					var $clonecopy = $("#resultado").clone();
					var texto = $clonecopy.text();
					$clonecopy.html(texto);
					
					$("#info2").html(texto);
					$("#info1").html("");
					$('#buttonazul').prop("disabled", false);
					$('#formulario')[0].reset();
					
					document.getElementById('soflow').value=porId;
					infonNumeroT();
					infoC();
					infoT();
					infou();
					infov();
					$("#selecmoneda").load('./selecmoneda.php');
				},
				error: function(){ 
					$("#info1").html('<font color="red"><strong><?php echo $mensaje1; ?></strong></font>');
					$("#info2").html(xerror1);
					$('#imprimir').prop("disabled", false);
					$('#buttonazul').prop("disabled", false);
					document.getElementById('soflow').value=porId;
					infonNumeroT();
					infoC();
					infoT();
					infou();
					infov();
					$("#selecmoneda").load('./selecmoneda.php');
				},
			});
			return false; // Evitar ejecutar el submit del formulario.
		} else { cuenta=0 };
	});
	document.getElementById("numCa44").focus();
});
$(function(){
	$("#barra").click(function(){
		if (document.getElementById('inputPassword2').value!='') {
			var porId2=document.getElementById('inputPassword2').value;//funciona
			//alert(porId2);
  var v = porId2.split('.');//funciona 3374121.3374
  var uno = v[0];//funciona
  var dos = v[1];//funciona
//alert(uno);
		//var formul='#formbarra';
		//alert('#formbarra');
		//'http://' + URLdomain + directorio + '/home'; //+pathname;
		var url = 'ventas_pagar_apuestas_procesar.php?pagoSIN=' + uno + '&uVenta=' + dos + '&codbarra=1'; // El script en dÃƒÂ³nde se realizarÃƒÂ¡ la peticiÃƒÂ³n.
		//var esper1 = '<img src="../images/barraloading.gif" width="128" height="15" />';
		//var esper2 = '<font color="red">Guardando jugada! Por favor espere ...</font>';
		//	var xerror1 = '<font color="red"><h3>NO HUBO RESPUESTA DEL SERVIDOR! Ticket no guardado</h3></font>';
		//	var xerror2 = '<font color="red"><strong><?php echo $mensaje2; ?></strong></font>';
		//alert(url);
		
		$.ajax({
	url: url,
	success: function(respuesta) {
		alert(respuesta);
		$('#formbarra')[0].reset();
		cuenta=0;

	},
	error: function() {
        alert("No se ha podido obtener la información");
		$('#formbarra')[0].reset();
		cuenta=0;
    }
});
return false;

		};

    });		
});
//function barra(){


//}
</script>
<script language="javascript">
function infonNumeroT() {
	var url = '../includes/infoNumeroTicket.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#mon_canticket").html(data);
		}
	});
}
function infoC() {
	var url = '../includes/infoCarrera.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#infocarreras").html(data);
		}
	});
}
function infoT() {
	var url = '../includes/infoTicket.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#infoticket").html(data);
		}
	});
	setTimeout(function(){document.getElementById("numCa44").focus();}, 1000);
	
}
function infou() {
	var url = '../includes/infoultimo.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#ultimajugada").html(data);
		}
	});
}
function infov() {
	var url = '../includes/seleccionclientesventas.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#selecionclientes").html(data);
		}
	});
}
</script>
<script LANGUAGE="JavaScript">
var cuenta=0;
function enviado() { 
	if (cuenta == 0){
		cuenta++;
		return true;
	}
	else {
	// alert("El formulario ya estÃƒÂ¡ siendo enviado, por favor aguarde un instante.");
	return false;
	}
}
</script> 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap4.min.css">



	<script src="../js/jquery3.6.0.min.js"></script>
	<title>.:Apuestas HÃƒÂ­picas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #e0e0e0;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
.headt td {
  min-width: 235px;
  height: 100px;
  background-color: #433;
}

table {
  color: #4ef;
}
</style>



  </head>
  <body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
  <header> 
  <!-- Fixed navbar -->

</header>
  <div class="container" style="font-size:160%;">
<div class="row text-center"> 
<div class="col-sm-12 order-1 order-sm-2 border border-dark">


  <div class="container-fluid border">
  <?php include('../ventas/menutah.php'); ?>
</div>

    <div class="container-fluid border">
  <div class="row">
    <div id="info1" class="col" style=" font-size:16px; color:#ff1a00;font-weight: bold"><?php echo $mensaje1; ?></div>
    <div class="w-100"></div>
    <div id="info2" class="col"  style=" font-size:16px; color:#F90;font-weight: bold"><?php echo $mensaje2; ?></div>

  </div>
</div>
<!-- end .info -->










</div>
    <div class="col-sm-8 order-2 order-sm-2 border border-dark table-responsive" style="border:1px double red; ">


<TABLE class="table" WIDTH="400" HEIGHT="300"  align="center">
<tr>

<td colspan="3" style="font-size:20px; align="center"   style="border:1px double red;">

<button type="button" class="btn btn-danger  btn-sm ">Cantidad de tickets creados: <?php include("../includes/infoNumeroTicket.php");?></button>
</td>


<tr>
<td colspan="6" HEIGHT="20"  class="" style="border:1px double red;">



<form method="post" id="formulario" name="form1" onSubmit="return enviado()" >

<div id="hipodromo" style="font-size:16px; float:center;  margin:-20px 0px 0px -20px; height:40px;"
                        	 onmouseover="stopListaHipodromo()">
							<?php require_once("ventas_hipodromo_listas.php");?>
                        </div><!-- end .hipodromo -->




</td>
</tr>
<tr>
<td colspan="6" align="center" class="" style="border:1px double red;">
<button type="button" class="btn btn-primary">. EJEMPLAR .</button>
<button type="button" class="btn btn-warning">GAN</button>
<button type="button" class="btn btn-warning">PLA</button>
<button type="button" class="btn btn-warning">SHW</button>
</td>
</tr>
<tr>
<td colspan="6" align="center" class="" style="border:1px double red;">
<?php
$x=1;
for ($i = 1; $i <= 4; $i++) {?>
<div style="margin:1px 0px 0px 5px; height:40px; ">
<input type="checkbox" name="<?php echo "per".$i; ?>" size="20" id="<?php echo "per".$i; ?>"/>
<input class="text rounded" tabindex="<?php echo $x;?>"
type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;" name="<?php echo "numCa1".$i;?>" style="width:40px; font-size:22px" 
maxlength="2" value="" id="<?php echo "numCa1".$i;?>" 
/>
<input class="text rounded" tabindex="<?php echo $x+1;?>" type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
name="<?php echo "numCa2".$i;?>" style="width:40px; font-size:22px"
maxlength="2" value="" id="<?php echo "numCa2".$i;?>"/>
<input class="text rounded" tabindex="<?php echo $x+2;?>" type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
name="<?php echo "numCa3".$i;?>"
style="width:40px; font-size:22px" maxlength="2" value="" id="<?php echo "numCa3".$i;?>"/>
<input class="text rounded" tabindex="<?php echo $x+3;?>" type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;" 
name="<?php echo "numCa4".$i;?>"
style="width:40px; font-size:22px"
maxlength="2" value="" id="<?php echo "numCa4".$i;?>"/>
<input class="text rounded" tabindex="<?php echo $x+4;?>" 
type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;" name="<?php echo "monGan".$i; ?>"
style="width:75px; font-size:22px" maxlength="5"value="" id="<?php echo "monGan".$i;?>"/>
<input class="text rounded" tabindex="<?php echo $x+5;?>" type="text" 
onKeyDown="if(event.keyCode==13) event.keyCode=9;" name="<?php echo "monPla".$i; ?>" 
style="width:75px; font-size:22px" maxlength="5" value="" id="<?php echo "monPla".$i;?>"/>
<input class="text rounded" tabindex="<?php echo $x+6;?>" type="text" 
onKeyDown="if(event.keyCode==13) event.keyCode=9;" name="<?php echo "monSho".$i; ?>"
style="width:75px; font-size:22px" maxlength="5" value="" id="<?php echo "monSho".$i;?>"/>
</div>	
<?php
$x=$x+7;
}?>
</td>
</tr>
<tr>
<td colspan="6" font-size:25px align="center"  class="" style="border:1px double red;">
<input type="button"  class="btn btn-success rounded" id="imprimir" name="imprimir"  onClick="return enviado(); imprimeTicket();" 
value="REGISTRAR TICKET" 
tabindex="<?php echo $x;?>"                                 <?php if ($est_control_ventas==1) {
    echo 'disabled="disabled"';
} ?>/>


<?php if ($moneda<=5) {?><input type="hidden" id="efectivoO" name="efectivoO"  form="formulario" value="<?php

if ($moneda==0) {
    echo "0";
}
if ($moneda==1) {
    echo "3";
}
if ($moneda==2) {
    echo "4";
}
if ($moneda==3) {
    echo "5";
}
?>" />
<?php } if ($moneda==10) {?>
																                        
								                       <?php } if ($moneda==10) {
    if (!isset($_SESSION['efectivoOx'])) {
        $_SESSION['efectivoOx']='-1';
    } ?>

                     



<span id="selecmoneda" >
<?php require_once("selecmoneda.php"); ?>
</span><!-- end .hipodromo -->
<?php
} ?>
<div id="selecionclientes" ></div>	
</td>
</tr>








<tr>
<td colspan="6" font-size:30px align="center" style="border:1px double red;">
<input type="button" class="btn btn-primary  rounded" onclick="window.location='index2.php';"
value="ACTUALIZAR PAGINA" style="width:330px; font-size:20px; height:40px"
tabindex="<?php echo $x;?>"/>
</td>
</tr>
</TABLE> 
<input type="hidden" name="MM_insert" value="form1" />
                        <input type="hidden" name="ser_venta" value="" />
                        <input type="hidden" name="ticket" value="" />
                        <input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset5['cod_taquilla'] ?>" />
                        <input type="hidden" name="fec_venta" value=""/>
                        <input type="hidden" name="hor_venta" value="" />
						<input type="hidden" name="id_usuario" value="<?php echo $usuarioVenta; ?>" />
                        <input type="hidden" name="est_ticket" value="1" />
                        <input type="hidden" name="est_gan" value="<?php echo $est_gan ?>" />
                        <input type="hidden" name="est_pla" value="<?php echo $est_pla ?>" />
                        <input type="hidden" name="est_sho" value="<?php echo $est_sho ?>" />
                        <input type="hidden" name="est_exa" value="<?php echo $est_exa ?>" />
                        <input type="hidden" name="est_tri" value="<?php echo $est_tri ?>" />
                        <input type="hidden" name="est_sup" value="<?php echo $est_sup ?>" />
                        <input type="hidden" name="apMinGan" value="<?php echo $apMinGan ?>" />
                        <input type="hidden" name="apMinPla" value="<?php echo $apMinPla ?>" />
                        <input type="hidden" name="apMinSho" value="<?php echo $apMinSho ?>" />
                        <input type="hidden" name="apMaxGan" value="<?php echo $apGaMax ?>" />
                        <input type="hidden" name="apMaxPla" value="<?php echo $apPlMax ?>" />
                        <input type="hidden" name="apMaxSho" value="<?php echo $apShMax ?>" />
                        <input type="hidden" name="apMinExa" value="<?php echo $apMinExa ?>" />
                        <input type="hidden" name="apMinTri" value="<?php echo $apMinTri ?>" />
                        <input type="hidden" name="apMinSup" value="<?php echo $apMinSup ?>" />
                        <input type="hidden" name="apMaxExa" value="<?php echo $apExMax ?>" />
                        <input type="hidden" name="apMaxTri" value="<?php echo $apTrMax ?>" />
                        <input type="hidden" name="apMaxSup" value="<?php echo $apSuMax ?>" />
                        <input type="hidden" name="monMaxTi" value="<?php echo $monMaxTi ?>" />
                        <input type="hidden" name="monMaxEj" value="<?php echo $monMaxEj; ?>" />
                        <input type="hidden" name="tipotaquilla" value="<?php echo $tipotaquilla; ?>" />
                        <input type="hidden" name="saldoactual" value="<?php echo $saldoactual; ?>" />
                        <input type="hidden" name="tra_codigo" value="<?php echo $tra_codigo; ?>" />
                        <input type="hidden" name="tipo_pago" value="<?php echo $tipo_pago; ?>" />	
                        <input type="hidden" name="cod_agencia" value="<?php echo $cod_agencia; ?>" />
                        <input type="hidden" name="tipo_pagoa" value="<?php echo $tipo_pagoa; ?>" />
						
                        <input type="hidden" name="ejeMinC" id="$ejeMinC" value="<?php echo $ejeMinCar ?>" />
</form>



</div>
    <div class="col-sm-4 order-3 order-sm-2 border border-dark">
	<div id="ultimajugada" >


</div>

	<div></br>

	<button type="button" class="btn btn-success">Primary</button>
	</div>
	</br></br></br>
	<div>
	<button type="button" class="btn btn-success">Primary</button>
	</div>






</div>

<div class="col-sm-12 order-4  border border-dark">
      <H1 class="p-4">
	  
	  
	  				<?php if ($cod_barra==1) { ?>
					<form  id="formbarra" name="formbarra" >

  <div class="form-group mx-sm-3 mb-2">

    <input type="password" class="form-control" id="inputPassword2" placeholder="Codigo De Barra" value="">
  
  

  <input type="button" id="barra" name="barra" 
                                onClick="return enviado();" 
                                value="PROCESAR"
                                
/>

  </div>
</form>
<?php } ?>


</H1>
    </div>
	<div class="col-sm-6 order-5  border border-dark">
      <H1 class="p-4">CONTENIDO 2</H1>
    </div>
	<div class="col-sm-6 order-6  border border-dark">
      <H1 class="p-4">CONTENIDO 2</H1>
    </div>
	<div id="divImprime" style="display:none;">
		    </div>
            <div id="divOculto" style="display:none;">
		    </div>

 </div>


</div>











    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script src="../js/bootstrap4.min.js"></script>
  

  </body>
</html>
<script language="javascript">
document.getElementById("numCa44").focus();
</script>
<?php
mysqli_free_result($Recordset4);
mysqli_free_result($Recordset5);
?>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";

date_default_timezone_set('Pacific/Honolulu');
$hora1= date("D M j G:i:s T Y");
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
//echo horaampm($nuevahora1);


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
$query_Recordset6 = sprintf("/* PARSEADORES1 ventas\index.php - QUERY 1 */ SELECT 
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

$query_Recordset4 = "/* PARSEADORES1 ventas\index.php - QUERY 2 */ SELECT * FROM mensaje WHERE cod_mensaje = 1";
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
/* PARSEADORES1 ventas\index.php - QUERY 3 */ SELECT * FROM usuario, taquilla, taquilla_opc_ame, agencia,
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
$_SESSION['hi_blo_list']=$row_Recordset5['hip_bloqueados'];
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

$query_Recordset7 = sprintf("/* PARSEADORES1 ventas\index.php - QUERY 4 */ SELECT * FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame =1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_ventas=$row_Recordset7['est_control_ventas_ame'];//todas las ventas globales
$est_control_pagos=$row_Recordset7['est_control_pagos_ame']; //todos los pagos globales

$query_Recordset44 = sprintf("/* PARSEADORES1 ventas\index.php - QUERY 5 */ SELECT 
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


$query_Recordset51 = sprintf(
    "/* PARSEADORES1 ventas\index.php - QUERY 6 */ SELECT 
   ca.cod_carrera, ca.nom_hipodromo, num_carrera
	FROM 
    carrera ca, hipodromo hi
	WHERE
		ca.fec_carrera = %s AND
		hi.cod_hipodromo = ca.cod_hipodromo AND ca.hor_carrera >= %s",
    GetSQLValueString($fechasistema, "date"),
    GetSQLValueString($horasistema, "date")
);
$Recordset51 = mysqli_query($conexionbanca, $query_Recordset51) or die(mysqli_error($conexionbanca));
$row51 = mysqli_fetch_assoc($Recordset51);
$totalRows_Recordset51 = mysqli_num_rows($Recordset51);
if ($totalRows_Recordset51>0 && $_SESSION['selCarrera']==-1) {
    $carreraActual=$row51['cod_carrera'];
} else {
    $carreraActual=$_SESSION['selCarrera'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseVentas.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas HÃƒÂ­picas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #D4D0C8;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
	var refreshId4 = null;
	function startListaHipodromo() {
		refreshId4 = setInterval(function() {
		var hipodSel=document.getElementById('soflow').value;
		var ejeMin=document.getElementById('$ejeMinC').value;
		var rA=Math.random();
		var parametros = { "js":hipodSel, "eM":ejeMin, "rA":Math.random() };
		$.ajax({ data:parametros, url:'ventas_hipodromo_listas_prueba.php', type:'post',
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
	function pizActualame(carrera) {
	if (carrera.value>0){
		document.getElementById("carreraame").value=carrera.value;
		var u=document.getElementById("idus").value, c=carrera.value, t=document.getElementById("ctaq").value;
		var parametros = { "iD":c, "codtaquilla":t, "codusuario":u, "rA":Math.random()};
		$.ajax({ data:parametros, url:'pizarra_actual_ame.php', type:'post', cache: 'false', global : false,
			success:function (response) { $("#impPiza").html(response); }
		});
	}
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
			
			$('#imprimir').prop("disabled", true);
			$('#buttonazul').prop("disabled", true);
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
	alert("El formulario ya estÃƒÂ¡ siendo enviado, por favor aguarde un instante.");
	return false;
	}
}
</script> 
<!-- InstanceEndEditable -->
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 9]><script src="../js/src_ie/html5shiv.js"></script><![endif]-->

</head>

<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<?php
$sss="1";
if ($row_Recordset5['tipo_pago']==1 && $saldoactual < 1) {?>

<font size="6" style="color:red;" align="center">ESTA TAQUILLA POSEE SALDO NEGATIVO POR ESO NO DEJA REALIZAR JUGADAS POR FAVOR REALICE UNA RECARGA</br></font>
<?php }?>
<font size="6" style="color:red;" align="center"><?php echo $mensaje44;?></font>

    <div class="container"></br>
		<div class="header" style="height:80px; background:#333">
			<?php include("../includes/cabeceraventasmie.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">

            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:5px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center">
            	TAQUILLA DE VENTAS<br/>
                <!-- InstanceBeginEditable name="nTaquilla" -->
                <?php echo strtoupper($row_Recordset5['nom_taquilla']); ?>
                <!-- InstanceEndEditable -->
            </div>
<?php if ($row_Recordset5['tipo_pago']==1) {?>

PUEDE VENDER HASTA: <?php echo $saldoactual." | ";}?> 
TAQUILLA EN
<?php if ($moneda==0) {
    echo 'BOLIVARES | ';
}?> 
<?php if ($moneda==1) {
    echo 'DOLARES | ';
}?> 
<?php if ($moneda==2) {
    echo 'PESOS COL | ';
}?> 
<?php if ($moneda==3) {
    echo 'SOLES PER | ';
}?> 
<?php if ($moneda==10) {
    echo 'MULTIMONERDA | ';
}?> 
             Usuario:
             <!-- InstanceBeginEditable name="nUsuario" --> 
			 <?php echo strtoupper($row_Recordset5['nom_completo']); ?> | <?php echo vfechaActual()." | "; ?>
             <!-- InstanceEndEditable -->
             <span id="reloj"></span>
             
        </div>
		<div class="sidebar3">
		</div> <!-- end .sidebar3 -->    
        <div class="content">
			<!-- InstanceBeginEditable name="Contenido" -->
			<div id="centro" style="padding:5px 0px 0px 0px;">
                <div id="info1" style="padding:0px 0px 0px 0px; font-size:20px; height:20px;font-weight: bold">
                	<font color="red"><strong><?php echo $mensaje1; ?></strong></font>
                </div><!-- end .info1 -->                        
                <div id="info2" style="padding:0px 0px 0px 0px; font-size:20px;height:25px; color:#F90;font-weight: bold">
                	<?php echo $mensaje2; ?></strong></font>
                </div><!-- end .info2 -->
                <div id="izquierda" style="font-size:16px; width:55%; float:left; height:350px; background:#e0e0e0">
					<form method="post" id="formulario" name="form1" onSubmit="return enviado()" >
                        <div id="men_canticket" style="font-size:16px; background: #333; width:84%; float:left; height:17px; 
                            text-align:right; padding:12px 2px 2px 2px; border-radius: 5px 0px 0px 0px; color:#FFF">
                            Cantidad ticket creados por Vendedor:
                        </div><!-- end .men_canticket -->
                        <div id="mon_canticket" style="font-size:24px; background: #333; width:14.4%; float:left; height:27px;
                            text-align:left; padding:2px 2px 2px 2px; border-radius: 0px 5px 0px 0px; color: #F90">
                        </div><!-- end .mon_canticket -->
			<div style="color:red; font-size:25px">
			<?php

				if ($row_Recordset5['24hr'] == 0) {

				if ($nuevahora1 > $row_Recordset5['hor_fin'] OR $nuevahora1 < $row_Recordset5['hor_inicio']) {
					echo 'TAQUILLA CERRADA <br> HORARIO DE VENTAS DE ' .$row_Recordset5['hor_inicio'] .'AM A '.$row_Recordset5['hor_fin']. 'PM'. '<br> COMUNIQUESE CON SU AGENTE';
				}
			else {
			?>
					</div>
                        <div id="hipodromo" style="font-size:16px; float:left; width:51%; margin:-20px 0px 0px -20px; height:76px;"
                        	 onmouseover="stopListaHipodromo()">
							<?php require_once("ventas_hipodromo_listas_prueba.php");?>
                        </div><!-- end .hipodromo -->
                        <div id="jugada" style="font-size:16px;float:left;width:100%;background:#e0e0e0;
                        	padding:0px 0px 8px 0px; height:100%">
                            <div style="background:#e0e0e0;float:left;width:40px;height:150px;margin:0px 0px 0px 0px ">
								<img src="../img/permta.png" width="40" height="150" />                            	
                            </div>
                            <div style="background: #e0e0e0; margin:-20px 0px 0px 0px; width:203px; float:left;height:18px;
                            padding:2px 0px 0px 30px; text-align:center">
                                EJEMPLARES
                            </div>
                            <div style="background:#e0e0e0;margin:-170px 0px 0px 270px;width:227px; float:left; height:18px;  
                                word-spacing:45px; padding:2px 0px 0px 25px; text-align:left">
                                GAN PLA SHW
                            </div>
                            <?php
                            $x=1;
                            for ($i = 1; $i <= 4; $i++) {
                                if ($i == 1) {?>
                                <div style="margin:1px 0px 0px 25px; background: #e0e0e0;">
                                <?php } else {?>
                                <div style="margin:1px 0px 0px 25px; background: #e0e0e0;">
                                <?php } ?>

							
                         <input type="checkbox" name="<?php echo "per".$i; ?>" size="2" id="<?php echo "per".$i; ?>"
                         onclick="clean(),clean2()" onchange="clean(),clean2()"
                         onKeyDown="return handleEnter(this, event)"/>

                         <input class="textbox" tabindex="<?php echo $x; ?>" type="text" name="<?php echo "numCa1".$i; ?>"                         style="width:25px" maxlength="2" value="" id="<?php echo "numCa1".$i; ?>"
                         onkeypress="javascript:return validarNro(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "numCa1".$i; ?>',1,<?php echo $ejemMax ?>)"/>
    
                         <input class="textbox" tabindex="<?php echo $x+1; ?>" type="text" name="<?php echo "numCa2".$i; ?>"                         onkeypress="javascript:return validarNro(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "numCa2".$i; ?>',1,<?php echo $ejemMax ?>)"
                         style="width:20px" maxlength="2" value="" id="<?php echo "numCa2".$i; ?>"/>
    
                         <input class="textbox" tabindex="<?php echo $x+2; ?>" type="text" name="<?php echo "numCa3".$i; ?>"                         onkeypress="javascript:return validarNro(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "numCa3".$i; ?>',1,<?php echo $ejemMax ?>)"
                         style="width:20px" maxlength="2" value="" id="<?php echo "numCa3".$i; ?>"/>
    
	
	
	
                         <input class="textbox" tabindex="<?php echo $x+3; ?>" type="text" name="<?php echo "numCa4".$i; ?>"                         onkeypress="javascript:return validarNro(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "numCa4".$i; ?>',1,<?php echo $ejemMax ?>)"
                         style="width:20px" maxlength="2" value="" id="<?php echo "numCa4".$i; ?>"/> -
    
	
	
	
	
                         <input class="textbox" tabindex="<?php echo $x+4; ?>" type="text" name="<?php echo "monGan".$i; ?>" 
                         onkeypress="javascript:return validarNro1(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "monGan".$i; ?>',<?php echo $apMinGan ?>,<?php echo $apGaMax ?>)"
                         style="width:50px; font-size:17px" maxlength="9"  value="" id="<?php echo "monGan".$i; ?>"/>
    
                         <input class="textbox" tabindex="<?php echo $x+5; ?>" type="text" name="<?php echo "monPla".$i; ?>" 
                         onkeypress="javascript:return validarNro1(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "monPla".$i; ?>',<?php echo $apMinPla ?>,<?php echo $apPlMax ?>)"
                         style="width:50px; font-size:17px" maxlength="9" value="" id="<?php echo "monPla".$i; ?>"/>
    
                         <input class="textbox" tabindex="<?php echo $x+6; ?>" type="text" name="<?php echo "monSho".$i; ?>" 
                         onkeypress="javascript:return validarNro1(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "monSho".$i; ?>',<?php echo $apMinSho ?>,<?php echo $apShMax ?>)"
                         style="width:50px; font-size:17px" maxlength="9" value="" id="<?php echo "monSho".$i; ?>"/>
					    </div><!-- end .apuesta -->		
                        <?php
                            $x=$x+7;
                            }?>
                        </div><!-- end .apuesta -->	
						

		
		
		<div id="realizarapuesta">
		
                                <input type="button" id="imprimir" name="imprimir" 
                                onClick="return enviado(); imprimeTicket();" 
                                value="REALIZAR APUESTA E IMPRIMIR"
                                tabindex="<?php echo $x;?>"
                                <?php if ($est_control_ventas==1) {
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

                        </div><!-- end .realizarapuesta -->
<?php
				}
				}

			else{

				?>

<div id="hipodromo" style="font-size:16px; float:left; width:51%; margin:-20px 0px 0px -20px; height:76px;"
                        	 onmouseover="stopListaHipodromo()">
							<?php require_once("ventas_hipodromo_listas_prueba.php");?>
                        </div><!-- end .hipodromo -->
                        <div id="jugada" style="font-size:16px;float:left;width:100%;background:#e0e0e0;
                        	padding:0px 0px 8px 0px; height:100%">
                            <div style="background:#e0e0e0;float:left;width:40px;height:150px;margin:0px 0px 0px 0px ">
								<img src="../img/permta.png" width="40" height="150" />                            	
                            </div>
                            <div style="background: #e0e0e0; margin:-20px 0px 0px 0px; color:#000; width:203px; float:left;height:18px;
                            padding:2px 0px 0px 30px; text-align:center">
                                EJEMPLARES
                            </div>
                            <div style="background:#e0e0e0;margin:-170px 0px 0px 270px;width:227px; color:#000; float:left; height:18px;  
                                word-spacing:45px; padding:2px 0px 0px 25px; text-align:left">
                                GAN PLA SHW
                            </div>
                            <?php
                            $x=1;
                            for ($i = 1; $i <= 4; $i++) {
                                if ($i == 1) {?>
                                <div style="margin:1px 0px 0px 25px; background: #e0e0e0;">
                                <?php } else {?>
                                <div style="margin:1px 0px 0px 25px; background: #e0e0e0;">
                                <?php } ?>

							
                         <input type="checkbox" name="<?php echo "per".$i; ?>" size="2" id="<?php echo "per".$i; ?>"
                         onclick="clean(),clean2()" onchange="clean(),clean2()"
                         onKeyDown="return handleEnter(this, event)"/>

                         <input class="textbox" tabindex="<?php echo $x; ?>" type="text" name="<?php echo "numCa1".$i; ?>"                         style="width:25px" maxlength="2" value="" id="<?php echo "numCa1".$i; ?>"
                         onkeypress="javascript:return validarNro(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "numCa1".$i; ?>',1,<?php echo $ejemMax ?>)"/>
    
                         <input class="textbox" tabindex="<?php echo $x+1; ?>" type="text" name="<?php echo "numCa2".$i; ?>"                         onkeypress="javascript:return validarNro(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "numCa2".$i; ?>',1,<?php echo $ejemMax ?>)"
                         style="width:20px" maxlength="2" value="" id="<?php echo "numCa2".$i; ?>"/>
    
                         <input class="textbox" tabindex="<?php echo $x+2; ?>" type="text" name="<?php echo "numCa3".$i; ?>"                         onkeypress="javascript:return validarNro(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "numCa3".$i; ?>',1,<?php echo $ejemMax ?>)"
                         style="width:20px" maxlength="2" value="" id="<?php echo "numCa3".$i; ?>"/>
    
	
	
	
                         <input class="textbox" tabindex="<?php echo $x+3; ?>" type="text" name="<?php echo "numCa4".$i; ?>"                         onkeypress="javascript:return validarNro(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "numCa4".$i; ?>',1,<?php echo $ejemMax ?>)"
                         style="width:20px" maxlength="2" value="" id="<?php echo "numCa4".$i; ?>"/> -
    
	
	
	
	
                         <input class="textbox" tabindex="<?php echo $x+4; ?>" type="text" name="<?php echo "monGan".$i; ?>" 
                         onkeypress="javascript:return validarNro1(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "monGan".$i; ?>',<?php echo $apMinGan ?>,<?php echo $apGaMax ?>)"
                         style="width:50px; font-size:17px" maxlength="9"  value="" id="<?php echo "monGan".$i; ?>"/>
    
                         <input class="textbox" tabindex="<?php echo $x+5; ?>" type="text" name="<?php echo "monPla".$i; ?>" 
                         onkeypress="javascript:return validarNro1(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "monPla".$i; ?>',<?php echo $apMinPla ?>,<?php echo $apPlMax ?>)"
                         style="width:50px; font-size:17px" maxlength="9" value="" id="<?php echo "monPla".$i; ?>"/>
    
                         <input class="textbox" tabindex="<?php echo $x+6; ?>" type="text" name="<?php echo "monSho".$i; ?>" 
                         onkeypress="javascript:return validarNro1(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "monSho".$i; ?>',<?php echo $apMinSho ?>,<?php echo $apShMax ?>)"
                         style="width:50px; font-size:17px" maxlength="9" value="" id="<?php echo "monSho".$i; ?>"/>
					    </div><!-- end .apuesta -->		
                        <?php
                            $x=$x+7;
                            }?>
                        </div><!-- end .apuesta -->	
						

		
		
		<div id="realizarapuesta">
		
                                <input type="button" id="imprimir" name="imprimir" 
                                onClick="return enviado(); imprimeTicket();" 
                                value="REALIZAR APUESTA E IMPRIMIR"
                                tabindex="<?php echo $x;?>"
                                <?php if ($est_control_ventas==1) {
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

                        </div><!-- end .realizarapuesta -->

						<?php
}

				?>

                     </div><!-- end .jugada -->
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
                </div><!-- end .izquierda -->
                <div id="derecha" style="margin:0px 0px 0px 1.9px;font-size:16px;width:44.8%;float:left; background:#e0e0e0;
                	border-radius:10px 10px 0px 0px; border-left-width:thin; height:210px">


<div id="men_pagar" style="font-size:12px; background: #333;width:100%; float:left; height:150px; 
						text-align: center; padding:1px 0px 0px 0px; color: #FFF; line-height:13px;border-bottom: 1px black solid;">
						PIZARRA: <br>
                        <?php
                        if (isset($row51['cod_carrera_hnac']) or isset($cod)) {?>
                    <form method="post">
                        <select name="carreraame" onchange="pizActualame(this);" id="carreraame"
                    style="width:99%; height:20px; font-size:16px;background-color:#333; color:#fff;">
						<option value="-1" style="background: #000; color:#FFFFFF;">
							<?php echo "SELECCIONE";?>
						</option><?php
                    do {?>
						<option value="<?php echo $row51['cod_carrera'];?>" style="background: #000; color:#FFFFFF;"
						<?php if (!(strcmp($_SESSION['selCarrera'], htmlentities($row51['cod_carrera'], ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>> <?php echo $row51['nom_hipodromo'].' ..CARRE.. '.$row51['num_carrera'];?>
						</option>
					<?php
                    } while ($row51 = mysqli_fetch_assoc($Recordset51));?>
					</select>
                    <input type="hidden" id name="codigo" value="" />
                    <input type="hidden" id="ctaq"  value="<?php echo $taquilla; ?>" />
                    <input type="hidden" id="idus"  value="<?php echo $usuarioVenta; ?>" />
                    <input type="hidden" name="nomtaquilla" value="<?php echo $nombredetaquilla; ?>" />
                    <input type="hidden" name="nomcompleto" value="<?php echo $nomcompleto; ?>" />
                    </form>
                    <?php } else {
                        echo "<h3 style='background: #333; color: #333'>-</h3>";
                    }?>
                    <div id="impPiza" style="width:100%; height:200px">
                    	<?php include("pizarra_actual_ame.php");?>
					</div>
					</div><!-- diego pizzarra --> 






				                <div id="ultimajugada" style="background:#e0e0e0;float:right;height:100px;width:99.5%; padding:3px 0px 0px 0px;
                	margin:0px 0px 0px 0px;border-radius:0px 5px 0px 0px;border-right-width: thin;border-right-style: solid;
                    border-bottom-style: solid;border-bottom-width: thin; border-right-color: #CCC; border-bottom-color: #CCC;
                    font-size:13px; line-height:10px;">
				</div>  
				<?php if ($cod_barra==1) { ?>
					<form  id="formbarra" name="formbarra" >

  <div style="height:10px; width:99%; float:left; padding:10px 0px 0px 0px;" class="form-group mx-sm-3 mb-1">

    <input type="password" class="form-control" id="inputPassword2" placeholder="Codigo De Barra" value="">
  
  

  <input type="button" id="barra" name="barra" 
                                onClick="return enviado();" 
                                value="PROCESAR"
                                
/>

  </div>
</form>
<?php } ?>

                    <div id="pagarapuesta" style="font-size:16px; height:10px; width:99%; float:left; text-align:left; 
                    	text-align:center; padding:0px 0px 30px 10px; line-height:80px; position: relative;">
                        <form method="post" id="form2">
                            <div id="eliminaTicket" style="height:20px; width:99%; float:left; padding:10px 0px 0px 0px;">

							<input type="submit" id="buttonverde" value="ir a Pagar apuesta" 
                                title="paga apuesta" onclick="javascript:window.open('../ventasmie/pag_tic_sincodigo.php?uVenta=<?php echo $usuarioVenta?>', '_blank');" <?php if ($est_control_pagos==1) {
        echo 'disabled="disabled"';
    } ?>/>
                            	<input type="submit" id="buttonrojo" value="ir a Eliminar ticket" title="elimina apuesta" 
                                onclick="javascript:window.open('../ventasmie/eli_tic_sincodigo.php?uVenta=<?php echo $usuarioVenta?>', '_blank');"/>
                            </div>
                            <input type="hidden" name="id_usuario_pago" value="<?php echo $usuarioVenta; ?>" />
                        </form>
                        <div id="pagamensaje" style="font-size:16px; height:100px; width:95%; float:left; color:#CC0000; 
                        position: absolute; text-align:left; text-align:center; margin:-20px 0px 0px 0px; line-height:10px;
                        background:#e0e0e0; display:none; padding:10px 0px 0px 0px ">
                        </div>
                  </div><!-- end .pagarapuesta -->




				</div> <!-- end .derecha -->
                  <div id="mensajeChat" style="font-size:16px; height:177px; width:100%; float:left; 
                    	text-align:center; padding:0px 0px 0px 0px;">
                        
                        <div id="membreteChat" style="font-size:12px; height:18px; width:99.5%; float:left; text-align:left; 
                    		padding:10px 0px 0px 5px; color: #FFF; background:#23528c; border-top-style: 
                        	solid;border-top-width: thin; border-top-color: #FFF;">
                            Por favor, ante cualquier duda o inconveniente envÃƒÂ­enos un mensaje por este medio,
                             serÃƒÂ¡ respondido en breve
                        </div><!-- end .membreteChat -->
						<div id="infoticket" style="background:#A0A0A0;float:right;height:80ppx;width:50%; padding:3px 0px 0px 0px;
                	margin:0px 0px 0px 0px;border-radius:0px 5px 0px 0px;border-right-width: thin;border-right-style: solid;
                    border-bottom-style: solid;border-bottom-width: thin; border-right-color: #CCC; border-bottom-color: #CCC;
                    font-size:13px; line-height:10px;">
				</div> 
                        <div id="Chat" style="font-size:11px;  height:90px; width:49.65%; float:left; text-align:left; 
                    		padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
                            position: relative;z-index: 0;" onmouseover="stopChat()" onmouseout="startChat()">
	                            <?php include("ventas_chat_mostrar.php");?>
                        </div><!-- end .Chat -->
                        <form method="post" id="form3">
                            <div id="enviarChat" style="font-size:18px; height:260px; width:89.6%; float:left; text-align:left; 
                                padding:0px 0px 0px 0px;">
                                <textarea id="txtMensaje" name="txtMensaje" placeholder="ESCRIBA SU MENSAJE AQUÃƒÂ" 
                                style="width:46%; height:50px; overflow: auto;resize:none; border: 1px solid #888; font-size:12px;
                                font-family: Arial, Helvetica, sans-serif;"></textarea>
								<input name="enviarChatBoton" type="button" id="enviarChatBoton" 
                                    style="height:45px; background: #CCC; border-color:#CCC; color: #333; font-size:14px; height:50px; float:left; border-top: 1px solid #888;"
                                    tabindex="<?php echo $x;?>" 
                                    value="ENVIAR"/>
                            </div><!-- end .Chat -->
                            
                            <input type="hidden" name="cod_taquilla_chat" value="<?php echo $taquilla; ?>" />
                            <input type="hidden" name="nom_usuario_chat" value="<?php echo $_SESSION['MM_Username']; ?>" />
                        </form>    

              </div><!-- end .mensajeChat -->      
				

			  <div id="infocarreras" style="background:#A0A0A0;float:right;height:90px; width:100%; padding:3px 0px 0px 0px; 
                	margin:0px 0px 0px 0px; border-radius:5px 0px 0px 0px; border-left-style: solid; border-left-width: thin;
                    border-bottom-style:solid;border-bottom-width: thin; border-right-width: thin;border-right-style: solid;
                    border-right-color:#CCC;border-bottom-color:#CCC;border-left-color:#CCC;font-size:10px;line-height:10px;">
				</div>                                    
				                                        
			</div><!-- end .centro -->
            
            <div id="divImprime" style="display:none;">
		    </div>
            <div id="divOculto" style="display:none;">
		    </div>
  <!-- InstanceEndEditable -->

        </div><!-- end .content -->
    </div><!-- end .container -->

<!-- Include all compiled plugins (below), or include individual files as needed -->

</body>
<!-- InstanceEnd --></html>
<script language="javascript">
document.getElementById("numCa44").focus();
</script>
<?php
mysqli_free_result($Recordset4);
mysqli_free_result($Recordset5);
?>
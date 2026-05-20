<?php
// if (!isset($_SESSION)){session_start();}
require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "C"; $MM_restrictGoTo = "../index.php";
// include("../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";


$_SESSION['MM_id_usuario']=113;















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
$query_Recordset6 = sprintf("/* PARSEADORES1 apostador\internacionalesc2.php - QUERY 1 */ SELECT 
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

$query_Recordset4 = "/* PARSEADORES1 apostador\internacionalesc2.php - QUERY 2 */ SELECT * FROM mensaje WHERE cod_mensaje = 1";
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
/* PARSEADORES1 apostador\internacionalesc2.php - QUERY 3 */ SELECT * FROM usuario, taquilla, taquilla_opc_ame, agencia,
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

$query_Recordset7 = sprintf("/* PARSEADORES1 apostador\internacionalesc2.php - QUERY 4 */ SELECT * FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame =1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_ventas=$row_Recordset7['est_control_ventas_ame'];//todas las ventas globales
$est_control_pagos=$row_Recordset7['est_control_pagos_ame']; //todos los pagos globales

$query_Recordset44 = sprintf("/* PARSEADORES1 apostador\internacionalesc2.php - QUERY 5 */ SELECT 
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


$horaactual=horaactual();
$fechasistema=fechaactualbd();

$query_Recordset1 = sprintf(
    "/* PARSEADORES1 apostador\internacionalesc2.php - QUERY 6 */ SELECT 
* FROM 
carrera 
WHERE 
carrera.fec_carrera = %s AND 
carrera.hor_carrera >= %s AND 
carrera.est_carrera = 1  AND
carrera.est_cierre = 2
ORDER BY carrera.hor_carrera  LIMIT 0, 20",
    GetSQLValueString($fechasistema, "date"),
    GetSQLValueString($horaactual, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



<link rel="stylesheet" href="../bootstrap4.5.0/css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
 <script src="../bootstrap4.5.0/js/bootstrap.min.js"></script>
 
<script src="../js/jquery-3.5.1.min.js"></script>
    <title>.:Apuestas:.</title>
	<?php
    $tra_codigo=0;
    if ($tra_codigo==0) {
        ?>
	<script type="text/javascript">	
 $(document).ready(function() {
	 $("#ultimajugada").load('infoultimoc.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	infou();
	 }, 70000);
	 $("#saldocliente").load('saldocliente.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	saldocli();
	 }, 30000);

});
function infou() {
	var url = 'infoultimoc.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#ultimajugada").html(data);
		}
	});
}
function saldocli() {
	var url = 'saldocliente.php';
	var js=Math.random();
	$.ajax({ type: "POST", url: url, global : false, data: $("js").serialize(),
		success: function(data) {
			$("#saldocliente").html(data);
		}
	});
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
	
function ActivarCampoOtrohipodromo0(){		
	var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
function ActivarCampoOtrohipodromo1(){		
	var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo2(){		
	var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo3(){		
	var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo4(){		
	var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo5(){		
	var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo6(){		
	var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo7(){		
	var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo8(){		
	var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo9(){		
	var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo10(){		
	var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo11(){		
	var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo12(){		
	var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo13(){		
	var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo14(){		
	var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo15(){		
	var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo16(){		
	var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo17(){		
	var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo18(){		
	var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
	function ActivarCampoOtrohipodromo19(){		
	var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "none";
	return true;	}
		function ActivarCampoOtrohipodromo20(){		
	var contenedor = document.getElementById("Otrohipodromo20");		
	contenedor.style.display = "block";	
		var contenedor = document.getElementById("Otrohipodromo1");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo2");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo3");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo4");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo5");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo6");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo7");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo8");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo9");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo10");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo11");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo12");		
	contenedor.style.display = "none";	
		var contenedor = document.getElementById("Otrohipodromo13");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo14");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo15");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo16");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo17");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo18");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo19");		
	contenedor.style.display = "none";
		var contenedor = document.getElementById("Otrohipodromo0");		
	contenedor.style.display = "none";
	return true;	}
	
	
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
<?php
    }?>
	
	</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="reportec.php">REPORTE</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>



                <div id="info1" style="padding:0px 0px 0px 0px; font-size:20px; height:20px;font-weight: bold">
                	<font color="red"><strong><?php echo $mensaje1; ?></strong></font>
                </div><!-- end .info1 -->                        

<div class="row">
  <div class="col-xs-12 col-sm-12" style="font-size:16px;  float:left; height:110px; background:#adf489">

  

  <div class="col-xs-12 col-sm-6" style="font-size:16px;  float:left; height:25px; background:#adf489">
  

  </div>
  
    <div class="col-xs-12 col-sm-6" style="font-size:16px;  float:left; height:25px; background:#adf489">

  </div>

</div>



<div class="col-xs-12 col-sm-12" style="font-size:16px;  float:left;  background:#adf489">
  

  <div class="col-xs-12 col-sm-6" style="font-size:16px;  float:left;  background:#adf489">
                   
<button type="button" onclick="window.location='internacionalesc2.php';" class="btn btn-primary btn-lg btn-block">ACTUALIZAR PÁGINA</button>


			
  
				                <div id="ultimajugada">
				</div>

    <fieldset>
                <div id="info2" style="padding:0px 0px 0px 0px; font-size:20px;height:25px; color:#F90;font-weight: bold">
                	<?php echo $mensaje2; ?></strong></font>
                </div>
    <div class="col text-center">
      	<button type="button" align="center" class="btn btn-info">SELECCIONE HIPODROMO</button>
    </div></br>
<?php
if ($totalRows_Recordset1>0) {
        $n=0;
    
        do {
            ?>
<form method="post" id="form<?php echo $n ?>">

				<div>
        <label>
		<button 
		type="button" 
		class="btn btn-primary" 
		onclick="ActivarCampoOtrohipodromo<?php echo $n ?>();"><?php echo $row_Recordset1['nom_hipodromo']?>
		</button>
<button type="button" 
class="btn btn-warning"
		onclick="ActivarCampoOtrohipodromo<?php echo $n ?>();"><?php echo $row_Recordset1['num_carrera']?>
</button>

  <div id="Otrohipodromo<?php echo $n ?>" style="display:none;">	
  
</br>
<button form="form<?php echo $n ?>" 
id="imprimir<?php echo $n ?>" 
name="imprimir<?php echo $n ?>" 
class="btn btn-success">REGISTRE SU JUGADA</button></br></br>
<button type="button" class="btn btn-warning btn-sm">#</button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<div class="btn-group" role="group" aria-label="Basic example">

  <button type="button" class="btn btn-secondary">GAN</button>
  <button type="button" class="btn btn-secondary">PLA</button>
  <button type="button" class="btn btn-secondary">SHW</button>
</div>

  
  
  <?php
$t=1;
            $x=0;

            do {
                ?>
	                              <?php
                            $i=1; ?>
						<div class="form-row">
						 <div class="col">
						<button type="button" 
class="btn btn-warning btn-sm"
		><?php	echo $t; ?>
</button>
					
	  </div>
    <div class="col">
								
	                           <input form="form<?php echo $n ?>"  class="form-control"  type="text" name="<?php echo "monGan".$t; ?>" 
                         onkeypress="javascript:return validarNro1(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "monGan".$t; ?>',<?php echo $apMinGan ?>,<?php echo $apGaMax ?>)"
                         style="width:73px; font-size:8px" maxlength="9"  value="" id="<?php echo "monGan".$t; ?>"/>
    </div>
    <div class="col">
                         <input form="form<?php echo $n ?>"  class="form-control"  type="text" name="<?php echo "monPla".$t; ?>" 
                         onkeypress="javascript:return validarNro1(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "monPla".$t; ?>',<?php echo $apMinPla ?>,<?php echo $apPlMax ?>)"
                         style="width:73px; font-size:8px" maxlength="9" value="" id="<?php echo "monPla".$t; ?>"/>
    </div>
    <div class="col">
                         <input form="form<?php echo $n ?>"  class="form-control"  type="text" name="<?php echo "monSho".$t; ?>" 
                         onkeypress="javascript:return validarNro1(event)" onKeyDown="return handleEnter(this, event)"
                         onblur="rangoNumeros('<?php echo "monSho".$t; ?>',<?php echo $apMinSho ?>,<?php echo $apShMax ?>)"
                         style="width:73px; font-size:8px" maxlength="9" value="" id="<?php echo "monSho".$t; ?>"/>
						 
						 </div>
						  </div>
					<?php
                         
      echo '</br>';

                $t++;
            } while ($t <= $row_Recordset1['can_caballos']);
            $cod_carrera=$row_Recordset1['cod_carrera']; ?>
                        <input form="form<?php echo $n ?>" type="hidden" name="MM_insert" value="form0" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset5['cod_taquilla'] ?>" />
						<input form="form<?php echo $n ?>"  type="hidden" name="id_usuario" value="<?php echo $usuarioVenta ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="est_ticket" value="1" />
	                    <input form="form<?php echo $n ?>"  type="hidden" name="cod_carrera" value="<?php echo $cod_carrera ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="est_gan" value="<?php echo $est_gan ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="est_pla" value="<?php echo $est_pla ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="est_sho" value="<?php echo $est_sho ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="est_exa" value="<?php echo $est_exa ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="est_tri" value="<?php echo $est_tri ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="est_sup" value="<?php echo $est_sup ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMinGan" value="<?php echo $apMinGan ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMinPla" value="<?php echo $apMinPla ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMinSho" value="<?php echo $apMinSho ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMaxGan" value="<?php echo $apGaMax ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMaxPla" value="<?php echo $apPlMax ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMaxSho" value="<?php echo $apShMax ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMinExa" value="<?php echo $apMinExa ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMinTri" value="<?php echo $apMinTri ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMinSup" value="<?php echo $apMinSup ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMaxExa" value="<?php echo $apExMax ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMaxTri" value="<?php echo $apTrMax ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="apMaxSup" value="<?php echo $apSuMax ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="monMaxTi" value="<?php echo $monMaxTi ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="monMaxEj" value="<?php echo $monMaxEj; ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="tipotaquilla" value="<?php echo $tipotaquilla; ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="saldoactual" value="<?php echo $saldoactual; ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="tra_codigo" value="<?php echo $tra_codigo; ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="tipo_pago" value="<?php echo $tipo_pago; ?>" />	
                        <input form="form<?php echo $n ?>"  type="hidden" name="cod_agencia" value="<?php echo $cod_agencia; ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="tipo_pagoa" value="<?php echo $tipo_pagoa; ?>" />
						<input form="form<?php echo $n ?>"  type="hidden" name="cod_cliente" value="7" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="ejeMinC" id="$ejeMinC" value="<?php echo $ejeMinCar ?>" />
                        <input form="form<?php echo $n ?>"  type="hidden" name="efectivoO" value="3" />
  </br>
  </div>

        </label>

		</div>
 </form>
 <script type="text/javascript">	
 $(function(){
	$("#imprimir<?php echo $n ?>").click(function(){
		
			$('#imprimir<?php echo $n ?>').prop("disabled", true);

			var formul='#form<?php echo $n ?>';
			var url = 'grabarjugada.php'; 
			var esper1 = '<img src="../images/barraloading.gif" width="128" height="15" />';
			var esper2 = '<font color="red">Registrando jugadas! Por favor espere ...</font>';
			var xerror1 = '<font color="red"><h3>NO HUBO RESPUESTA DEL SERVIDOR! Ticket no guardado</h3></font>';
			$.ajax({ type: "POST", url: url, global : false, data: $("#form<?php echo $n ?>").serialize(),
			beforeSend: function(){ $('#info1').html(esper1); $('#info2').html(esper2);}, 
				success: function(data) {
			        $("#divOculto").html(data);
			 		var $clonecopy = $("#resultado").clone();
					var texto = $clonecopy.text();
					$clonecopy.html(texto);
					$("#info2").html(texto);
					$("#info1").html("");
					alert(texto);
			$('#imprimir<?php echo $n ?>').prop("disabled", false);
			$('#form<?php echo $n ?>')[0].reset();
			 		infou();
					saldocli();
				},
				error: function(){ 
                $('#form<?php echo $n ?>')[0].reset();
					infou();
					saldocli();
				},
			});
			return false; // Evitar ejecutar el submit del formulario.

	});
});
</script>
<?php

        $n++;
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    }
?>
    </fieldset>
  </div>
  
    <div class="col-xs-12 col-sm-6" style="font-size:16px;  float:left;  background:#adf489">


  </div>


  </div>
</div>



</div>

            <div id="divImprime" style="display:none;">
			</div>
            <div id="divOculto" style="display:none;">
		    </div>
			
			<style type="text/css">.redes-flotantes {
position: fixed;
right: 8px;
top: 75%;
z-index: 20;
}
.redes-flotantes img {
float: right; clear: right;
 margin: 5px;
-moz-transform: scale(.8) ;
-webkit-transform: scale(.8) ;
-o-transform: scale(.8) ;
-ms-transform: scale(.8) ;
transform: scale(.8) ;
-webkit-transition: all .2s ease-in-out;
-moz-transition: all .2s ease-in-out;
-o-transition: all .2s ease-in-out;
transition: all .2s ease-in-out;
}
.redes-flotantes img:hover {
-moz-transform: scale(1.1) rotate(6deg);
-webkit-transform: scale(1.1) rotate(6deg);
-o-transform: scale(1.1) rotate(6deg);
-ms-transform: scale(1.1) rotate(6deg);
transform: scale(1.1) rotate(6deg);
}</style>
<div class='redes-flotantes'>


<div class="separator" style="clear: both; text-align: left;">
</div>
<div class="separator" style="clear: both; text-align: center;">
</div>
<div class="separator" style="clear: both; text-align: center;">
</div>
<div class="separator" style="clear: both; text-align: left;">
<a href="http://wa.me/+584126639372 Aquí Tú Teléfono" style="clear: left; float: left; margin-bottom: 1em; margin-right: 1em;" target="_blank"><img border="0" data-original-height="59" data-original-width="59" src="https://1.bp.blogspot.com/-q3Dot9N2qac/XOQgr9etVpI/AAAAAAABT1M/6V4Bqaqr-6UQcl9Fy2_CaVgex0N_OYuQgCLcBGAs/s1600/whatsapp%2Bicono.png" /></a></div>
<div class="separator" style="clear: both; text-align: center;">
<a href="https://m.me/Colocar aquí tu usuario de Facebook Messenger" style="clear: left; float: left; margin-bottom: 1em; margin-right: 1em;" target="_blank"><img border="0" data-original-height="59" data-original-width="59" src="https://3.bp.blogspot.com/-SK4W7Kmjoh8/XOQj5wjwERI/AAAAAAABT1g/2i3wxgGTwdU8v67F1rMOAe3ooWu9f2fEACLcBGAs/s1600/facebook%2Bmessenger%2Bicono.png" /></a></div></div>





</body>
</html>

<?php
?>
<?php
 
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
$query_Recordset6 = sprintf("/* PARSEADORES1 new\ventas\pick.php - QUERY 1 */ SELECT 
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

$query_Recordset4 = "/* PARSEADORES1 new\ventas\pick.php - QUERY 2 */ SELECT * FROM mensaje WHERE cod_mensaje = 1";
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
/* PARSEADORES1 new\ventas\pick.php - QUERY 3 */ SELECT * FROM usuario, taquilla, taquilla_opc_ame, agencia,
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

$query_Recordset7 = sprintf("/* PARSEADORES1 new\ventas\pick.php - QUERY 4 */ SELECT * FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame =1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_ventas=$row_Recordset7['est_control_ventas_ame'];//todas las ventas globales
$est_control_pagos=$row_Recordset7['est_control_pagos_ame']; //todos los pagos globales

$query_Recordset44 = sprintf("/* PARSEADORES1 new\ventas\pick.php - QUERY 5 */ SELECT 
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
$info=detect2();
if (isset($info["version"])) {
} else {
    $info["version"]=11;
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
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap core CSS -->
<link href="../css/bootstrap4.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script language="javascript">


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
</script>

<script type="text/javascript"> 
//Para Select


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
</head>

<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<br><br><br><br><br>
<div class="container-fluid">
<div class="row text-center" > 
<div class="col-sm-7 order-1  table-responsive border border-primary" style="padding: 0;">
<br>
<TABLE class="table" WIDTH="400" HEIGHT="300"  align="center" border="2">
<tr>
<td colspan="2" style="font-size:20px;padding: 0;" align="center"   style="">
<div id="hipodromo" style="font-size:16px; float:center;  margin:-20px 0px 0px 105px; height:30px;"
                        	 onmouseover="stopListaHipodromo()">
							 <?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (isset($_POST["js"])) {
    $_SESSION['selCarrera']=$_POST["js"];
} else {
    $_SESSION['selCarrera']=-1;
}
$hor=horaactual();
$fec=fechaactualbd();
$xbanca_Recordset1 = 2;
if (!isset($ejeMinCar)) {
    if (!isset($ejeMinCar)) {
        $ejeMinCar=$_POST["eM"];
    }
}
$query_Recordset1 = sprintf("/* PARSEADORES1 new\ventas\pick.php - QUERY 6 */ SELECT * FROM carrera WHERE carrera.fec_carrera = %s AND carrera.hor_carrera >= %s AND carrera.est_carrera = 1 AND carrera.cod_banca = %s AND can_caballos>=%s ORDER BY carrera.hor_carrera  LIMIT 0, 20", GetSQLValueString($fec, "date"), GetSQLValueString($hor, "date"), GetSQLValueString($xbanca_Recordset1, "int"), GetSQLValueString($ejeMinCar, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$t=0;
$x=0;
if ($totalRows_Recordset1>0) {
    do {
        list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);
        if ($h==0 && $m<50) {
            $cod[$t]=$row_Recordset1['cod_carrera'];
            $num_carrera[$t]=$row_Recordset1['num_carrera'];
            $nom_hipodromo[$t]=$row_Recordset1['nom_hipodromo'];
            $t++;
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}
if ($t==0) {
    $totalRows_Recordset1=0;
}
 ?>
<script>
function cambioOpcionesSelcet() {
	//aqui estoy
	//alert(document.getElementById('soflow').value);
	codcarrera = document.getElementById('soflow').value;
	$.get( "pick2.php?recordID2="+codcarrera, function( data ) {
 $( "#Exoticasdiv" ).html( data );
});
}
function Tipojugadaahacer() {
	//aqui estoy
	//alert(document.getElementById('soflow').value);
	Tipojugadaahacer = document.getElementById('Tipojugadaahacer').value;
	$.get( "pick2.php?recordID3="+Tipojugadaahacer, function( data2 ) {
 $( "#Tipojugadaahacer" ).html( data2 );
});
}
</script>
<?php
if ($t>0) {?>
	<select name="cod_carrera" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;" id="soflow" 
    style="font-size:20px; width:480px; height:35px" onBlur="startListaHipodromo()" 
	onchange="cambioOpcionesSelcet()">
		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
        	<?php echo "SELECCIONE HIPÓDROMO AQUÍ";?>
        </option>
        <?php
        if (isset($cod)) {
            foreach ($cod as $cod_carrera) {
                ?>
					<option value="<?php echo $cod_carrera; ?>" 
						<?php if (!(strcmp(htmlentities($cod_carrera, ENT_COMPAT, 'utf-8'), $_SESSION['selCarrera']))) {
                    echo "selected=\"selected\"";
                } ?> 
						onfocus="clean()" onclick="clean()">
						<?php echo $nom_hipodromo[$x]." Carr: ...".$num_carrera[$x]; ?>
					</option>
				<?php
                $x++;
            }
        }?>
	</select>
<?php
} else {
            $_SESSION['selCarrera']=-1; ?>
	<select name="cod_carrera" tabindex="1" id="soflow" style="font-size:18px; width:522px; height:35px" disabled="disabled">
		<option value="-1" > <?php echo "En estos momentos no existen carreras abiertas"; ?></option>
	</select>
<?php
        }
mysqli_free_result($Recordset1);
?>
							</td>


































							
							<td>
						
						
						
							<div id="Exoticasdiv">Aqui Se Mostraran las jugadas Permitidas</div>
						
						
					




</td>
</tr>
<tr>
<td colspan="1" style="font-size:20px;padding: 0;" align="center"   style="">


<div id="Tipojugadaahacer">Aqui Se Mostraran los caballos</div>




</td>


</tr>
</div>
</div>
</div>
<script src="../js/bootstrap4.min.js"></script>
</body>
</html>
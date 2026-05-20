<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$men0="";
$men1="";
$men2="";
$men3="";
$men4="";
$men5="";
$men6="";
$men7="";
$men8="";
$men9="";
$men10="";
$men11="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $men0="ERROR: ";
    $graba=31;
    if (isset($_POST['nom_hipodromo']) && $_POST['nom_hipodromo']!="") {
        if (buscaHip($_POST['nom_hipodromo'])>0) {
            $men1="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_hipodromo']=="" || strlen($_POST['nom_hipodromo'])<4) {
        $men1="nombre no válido";
        $graba--;
    }
    if (isset($_POST['pre_hipodromo']) && $_POST['pre_hipodromo']!="") {
        if (buscaHipPre($_POST['pre_hipodromo'])>0) {
            $men2="Ya existe";
            $graba--;
        }
    }
    if ($_POST['pre_hipodromo']=="" || strlen($_POST['pre_hipodromo'])<2) {
        $men2="nombre no válido";
        $graba--;
    }

    if ($_POST['nom_hipodromo_hpi']=="" || strlen($_POST['nom_hipodromo_hpi'])<4) {
        $men3="nombre no válido (HorsePlayer).";
        $graba--;
    }
    if ($_POST['nom_hipodromo_sup']=="" || strlen($_POST['nom_hipodromo_sup'])<4) {
        $men4="nombre no válido (Super).";
        $graba--;
    }
    if ($_POST['nom_hipodromo_rac']=="" || strlen($_POST['nom_hipodromo_rac'])<4) {
        $men5="nombre no válido (Racebets).";
        $graba--;
    }



    if ($_POST['dir_pagresultado']=="" || strlen($_POST['dir_pagresultado'])<4) {
        $men6="dirección (TRACK INFO).";
        $graba--;
    }
    if ($_POST['ext_pagresultado']=="" || strlen($_POST['ext_pagresultado'])<4) {
        $men7="extensión (TRACK INFO).";
        $graba--;
    }

    if ($_POST['dir_pagresultado_tvg']=="" || strlen($_POST['dir_pagresultado_tvg'])<4) {
        $men8="dirección (BASIC TVG).";
        $graba--;
    }
    if ($_POST['ext_pagresultado_tvg']=="" || strlen($_POST['ext_pagresultado_tvg'])<4) {
        $men9="extensión (BASIC TVG).";
        $graba--;
    }

    if ($_POST['dir_retirado']=="" || strlen($_POST['dir_retirado'])<4) {
        $men10="dirección (RETIRADOS).";
        $graba--;
    }
    if ($_POST['ext_retirado']=="" || strlen($_POST['ext_retirado'])<4) {
        $men11="extensión (RETIRADOS).";
        $graba--;
    }

    
    if ($graba==31) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 admin\hipodromos_add.php - QUERY 1 */ INSERT 
				INTO hipodromo 
				(nom_hipodromo, 
				 nom_hipodromo_hpi, 
				 nom_hipodromo_sup, 
				 nom_hipodromo_rac, 
				 pre_hipodromo,
				 pre_build,
				 nom_hipodromo_twi,
				 pre_twin,
				 tip_hipodromo,
				 
				 dir_pagresultado,
				 ext_pagresultado, 

				 dir_pagresultado_tvg,
				 ext_pagresultado_tvg, 
				 bus_retirado,
				 dir_retirado, 
				 ext_retirado, 
				 est_hipodromo, 
				 bus_auto, 
				 bus_resultado_tip,
				 cod_confirmacion) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo_hpi'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo_sup'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo_rac'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['pre_hipodromo'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['pre_build'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo_twi'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['pre_twin'])), "text"),
            GetSQLValueString($_POST['tip_hipodromo'], "int"),
            GetSQLValueString(trim($_POST['dir_pagresultado']), "text"),
            GetSQLValueString(trim($_POST['ext_pagresultado']), "text"),
            GetSQLValueString(trim($_POST['dir_pagresultado_tvg']), "text"),
            GetSQLValueString(trim($_POST['ext_pagresultado_tvg']), "text"),
            GetSQLValueString($_POST['bus_retirado'], "int"),
            GetSQLValueString(trim($_POST['dir_retirado']), "text"),
            GetSQLValueString(trim($_POST['ext_retirado']), "text"),
            GetSQLValueString($_POST['est_hipodromo'], "int"),
            GetSQLValueString($_POST['bus_auto'], "int"),
            GetSQLValueString($_POST['bus_resultado_tip'], "int"),
            GetSQLValueString($_POST['cod_confirmacion'], "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $insertGoTo = "hipodromos_listas.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<style>
  .textbox, .textboxsmal {
  border: 1px solid #DBE1EB;
  font-size: 18px;
  font-family: Arial, Verdana;
  padding-left: 7px;
  padding-right: 7px;
  padding-top: 10px;
  padding-bottom: 10px;
  border-radius: 4px;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  -o-border-radius: 4px;
  background: #FFFFFF;
  background: linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -moz-linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -webkit-linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -o-linear-gradient(left, #FFFFFF, #F7F9FA);
  color: #2E3133;
  height:30px;
  width:420px;
  }
  .textbox:focus, .textboxLargo:focus {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxLargo {
	  width:50px;
	  height:30px;
  }
 </style>
<!-- InstanceEndEditable -->
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #eeeeee;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<!-- InstanceBeginEditable name="aHead" -->
<script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
$(document).ready(function() {    
    $('#nom_hipodromo').blur(function(){
		var taquilla = $('input[name=nom_hipodromo]').val();
		if(taquilla != '') {
			var nom_taquilla = $(this).val();        
			var dataString = 'nom_taquilla='+nom_taquilla;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarHipodromo.php",
				data: dataString,
				success: function(data) {
					$('#Info1').fadeIn(200).html(data);
				}
			});
		};
    });              
});
$(document).ready(function() {    
    $('#pre_hipodromo').blur(function(){
		var usern = $('input[name=pre_hipodromo]').val();
		if(usern != '') {
			var username = $(this).val();        
			var dataString = 'username='+username;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarPrefijoHipodromo.php",
				data: dataString,
				success: function(data) {
					$('#Info2').fadeIn(200).html(data);
				}
			});
		};	
    });              
});    
function FX_passGenerator(form,element) {
  var thePass = "";
  var randomchar = "";
  var numberofdigits = '5';
  for (var count=1; count<=numberofdigits; count++) {
    var chargroup = Math.floor((Math.random() * 3) + 1);
    if (chargroup==1) {
      randomchar = Math.floor((Math.random() * 26) + 65);
    }
    if (chargroup==2) {
      randomchar = Math.floor((Math.random() * 10) + 48);
    }
    if (chargroup==3) {
      randomchar = Math.floor((Math.random() * 26) + 97);
    }
    thePass+=String.fromCharCode(randomchar);
  }
  thePass = thePass.toUpperCase();
  eval('document.'+form+'.'+element+'.value = thePass');
}
function ValidaSoloNumeros() {
	$('#imprimir').prop("disabled", false);
	cuenta=0;
	if ((event.keyCode < 48) || (event.keyCode > 57)) 
  		event.returnValue = false;
}    
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
</script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceraadmin.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                Nuevo hipódromo<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:14px; height: auto">
    	<div id="Info" style="float: left;font-size:18px; color:#F00; width:100%; background:#FFFFFF; text-align:center">
		<?php
        echo $men0." ".$men1." ".$men2." ".$men3." ".$men4." ".$men5." ".$men6." ".$men7." ".$men8." ".$men9." ".$men10." ".$men11;
        ?>
        </div>
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline">
                  <td height="44" colspan="6" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE HIPÓDROMO
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" valign="middle" nowrap>
                  Nombre de hipódromo:<br>
                    <input type="text" name="nom_hipodromo" id="nom_hipodromo" class="textbox" tabindex="1"
                    value="" 
                    size="32" placeholder="nombre de hipódromo" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info1');"
                    maxlength="60" required/>
                    <div id="Info1" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00; 
                    margin:-10px 0px 0px 0px;">
					<?php echo $men1; ?></div>
                  </td>
                  <td align="left">
                  Prefijo:<br>
                  <input type="text" name="pre_hipodromo" class="textboxLargo" tabindex="2" placeholder="prefijo"
                  value="" id="pre_hipodromo" required="required"  
                  size="5" title="indique un prefijo. 1-3 caracteres" onclick="ocultaDiv('Info');"/>
                  </td>
                  <td align="left">&nbsp;</td>
                  <td width="241" align="left">Status:<br/>
                    <select name="est_hipodromo" style="width:140px; height:40px" class="textbox" tabindex="3">
                      <option value="1">ACTIVO</option>
                      <option value="0">INACTIVO</option>
                  </select>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="5" align="left" nowrap>
                  Hipódromo WatchandWager: 
                  <span style="padding:0px 0px 0px 249px">Hipódromo Greyhound Channel:</span><br/>
                  <input type="text" name="nom_hipodromo_hpi" id="nom_hipodromo_hpi" class="textbox" tabindex="4" 
                  value="" required="required" onclick="ocultaDiv('Info');"
                    size="32" placeholder="nombre de hipódromo (Watchandwager)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60" />

                  <input type="text" name="nom_hipodromo_sup" id="nom_hipodromo_sup" class="textbox" tabindex="5"
                    value="" required="required" onclick="ocultaDiv('Info');"
                    size="32" placeholder="nombre de hipódromo (Super)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60"/>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" nowrap>
                  Hipódromo BuildaBet2:<br/>
                  <input type="text" name="nom_hipodromo_rac" id="nom_hipodromo_rac" class="textbox" tabindex="6"
                    value="" required="required" onclick="ocultaDiv('Info');"
                    size="32" placeholder="nombre de hipódromo (Racebets)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60"/>
                  </td>
                  <td align="left" nowrap>Prefijo BuildaBet2:<br />
                  <input type="text" name="pre_build" class="textbox" tabindex="1"
                      required="required" value="" id="pre_build"  size="5" 
                      title="indique un prefijo. 1-3 caracteres" style="height:25px; width:70px"/>                  
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" nowrap>
                  Hipódromo Twinspires:<br/>
                  <input type="text" name="nom_hipodromo_twi" id="nom_hipodromo_twi" class="textbox" tabindex="6"
                    value="" required="required" onclick="ocultaDiv('Info');"
                    size="32" placeholder="nombre de hipódromo (Twinspires)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60"/>
                  </td>
                  <td align="left" nowrap>Prefijo Twinspires:<br />
                  <input type="text" name="pre_twin" class="textbox" tabindex="1"
                      required="required" value="" id="pre_twin"  size="5" 
                      title="indique un prefijo. 1-3 caracteres" style="height:25px; width:70px"/>                  
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>
                  	Tipo:<br/>
                    <select name="tip_hipodromo" style="width:140px; height:40px" class="textbox" tabindex="3">
                      <option value="0">CABALLOS</option>
                      <option value="1">CARRETAS</option>
                      <option value="2">CANINOS</option>
                  </select>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td colspan="6" align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td width="190" align="left" nowrap>
					Busqueda resultados:<br/>
                    <select name="bus_resultado_tip" style="width:190px; height:35px" class="textbox" tabindex="7" 
                    id="bus_resultado_tip">
                      <option value="0">DESHABILITADO</option>
                      <option value="1">TRACK INFO</option>
                      <option value="2">BASIC TVG</option>
                      <option value="3">BUILDABET2</option>
                      <option value="4">TWINSPIRES</option>
                  </select>                  
                  </td>
                  <td width="246" align="left" nowrap>
					Pedir confirmación:<br/>
                    <select name="cod_confirmacion" style="width:150px; height:35px" class="textbox" tabindex="8" 
                    id="cod_confirmacion">
                      <option value="1">Si</option>
                      <option value="0">No</option>
                  </select>                  
                  </td>
                  <td colspan="2" align="left" nowrap>
                  	Programar desde:<br />
                    <select name="programar_desde" style="width:182px; height:40px;" class="textbox" tabindex="9" 
                    id="programar_desde">
                      <option value="0">DESHABILITADO</option>
                      <option value="1">BUILDABET2</option>
                      <option value="2">BASIC TVG</option>
                      <option value="3">TWINSPIRES</option>
	                </select>
                  </td>
                  <td align="left" nowrap>
					Control hora y cierre:<br/>
                    <select name="bus_auto" style="width:190px; height:40px" class="textbox" tabindex="10" id="bus_auto">
                      <option value="0">DESHABILITADO</option>
                      <option value="1">TWINSPIRES</option>
                      <option value="2">TRACK INFO</option>
                      <option value="3">BUILDABET2</option>
                      <option value="4">BASIC TVG</option>
                      <option value="5">WATCHANDWAGER</option>
                      <option value="6">SUPERAMERICANA</option>
                  </select>                  
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" nowrap>
                      TRACK INFO - Buscar resultados desde:<br />
                      <input type="text" name="dir_pagresultado" class="textbox" tabindex="11"
                      size="92" value="" id="dir_pagresultado" required="required"
                      title="indique página de dividendos"
                      onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
                  </td>
                  <td colspan="2" align="left" nowrap>
                      Extensión reultados:<br />
                    <input type="text" name="ext_pagresultado" class="textboxLargo" tabindex="12"
                      size="17" style="width:200px" required="required" value="" id="ext_pagresultado" 
                      title="indique extensión página de dividendos"
                      onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" nowrap>
                      BASIC TVG - Buscar resultados desde:<br />
                      <input type="text" name="dir_pagresultado_tvg" class="textbox" tabindex="13"
                      size="92" value="" required="required" onclick="ocultaDiv('Info');"
                      id="dir_pagresultado_tvg" 
                      title="indique página de dividendos"
                      onKeyUp="return handleEnter(this, event)"/>
                  </td>
                  <td colspan="2" align="left" nowrap>
                  	Extensión resultados:<br />
                    <input type="text" name="ext_pagresultado_tvg" class="textboxLargo" tabindex="14"
                    size="17" style="width:200px"
                    value="" required="required" onclick="ocultaDiv('Info');" 
                    id="ext_pagresultado_tvg"
                    title="indique extensión página de dividendos"
                    onKeyUp="return handleEnter(this, event)"/>
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" nowrap>
                      BUILDABET2 - indique código:<br />
                      <input type="text" name="cod_pagina_rb" class="textbox" tabindex="15"
                      size="400" value="" style="width:500px"
                      id="cod_pagina_rb" 
                      title="indique página de dividendos"
                      onKeyUp="return handleEnter(this, event)"/>
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td colspan="6" align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" nowrap>
                  	Busqueda retirados:
                    <select name="bus_retirado" style="width:200px; height:35px" class="textbox" tabindex="16" 
                    id="bus_retirado">
                      <option 
                      value="0">DESHABILITADO</option>
                      <option 
                      value="1">BASIC TVG</option>
                      <option 
                      value="2">BUILDABET2</option>
                      <option 
                      value="3">TWINSPIRES</option>
                  </select><br />                  
                  </td>
                  <td colspan="2" align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" nowrap>
                      Buscar ejemplares retirados desde:<br />
                      <input type="text" name="dir_retirado" class="textbox" tabindex="17"
                      size="92" value="" id="dir_retirado" onclick="ocultaDiv('Info');"
                      title="indique página de retirados" required="required"
                      onKeyUp="return handleEnter(this, event)"/>
                  </td>
                  <td colspan="2" align="left" nowrap>
                      Extensión retirados:<br />
                      <input type="text" name="ext_retirado" class="textboxLargo" tabindex="18"
                      size="17" style="width:200px" value="" id="ext_retirado" onclick="ocultaDiv('Info');"
                      title="indique extensión página de retirados" required="required"
                      onKeyUp="return handleEnter(this, event)"/>
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="right" nowrap>&nbsp;</td>
                  <td width="111" align="right" nowrap>&nbsp;</td>
                  <td width="102" align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
              </table>
		<table width="924" align="center">
            <tr valign="baseline">
              <td colspan="11" align="left" nowrap bgcolor="#5EAEFF">&nbsp;</td>
            </tr>
                <tr valign="baseline">
                  <td width="37" align="left" nowrap>&nbsp;</td>
                  <td width="182" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="19"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="70" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="199" colspan="2" align="right" valign="bottom" nowrap>
                  <a href='hipodromos_listas.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="43" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="10" align="left" nowrap>&nbsp;</td>
            </tr>
              </table>
               
          </div>
          <input type="hidden" name="MM_insert" value="form1"/>
      </form>
    </div>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
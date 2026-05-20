<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$menNus="";
$menNcus="";
$menPass="";
$menNti="";
$menPas="";
$menHin="";
$menRsup="";
$menMsup="";
$menNti="";
$menTeli="";	// maximo ticket a eliminar
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    $control=0;
    $contron=0;
    if (isset($_POST['nom_usuario']) && $_POST['nom_usuario']!="") {
        if (buscaUsu($_POST['nom_usuario'])>0) {
            $menNus="Ya existe";
            $graba--;
        }
    }
    if (strlen($_POST['pas_usuario'])<=3) {
        $menPass="debe contener 4 caracteres o mas";
        $graba--;
    }
    $hora_ini=$_POST['hor_in'].":".$_POST['min_in'].":".$_POST['am_in'];
    $hora_fin=$_POST['hor_fi'].":".$_POST['min_fi'].":".$_POST['am_fi'];
    $hora_ini=horamysql($hora_ini);
    $hora_fin=horamysql($hora_fin);
    if ($hora_ini>$hora_fin || $hora_ini==$hora_fin) {
        $menHin="error en horas";
        $graba--;
    }
    if (isset($_POST['dia7'])) {
        $trabaja="1";
    } else {
        $trabaja="0";
    }
    if (isset($_POST['dia1'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia2'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia3'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia4'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia5'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia6'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if ($graba==31) {
        $_POST['tip_usuario']="U";
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 distri\usuarios_ve_edit.php - QUERY 1 */ UPDATE usuario 
				SET
				nom_completo=%s, 
				pas_usuario=%s,
				est_usuario=%s, 
				tic_eliminados=%s, 
				cod_barra=%s, 
				hor_inicio=%s, 
				hor_fin=%s, 
				dia_entrada=%s,
				can_reimpresion=%s,
	 			24hr=%s 
				WHERE id_usuario=%s",
            GetSQLValueString(strtoupper($_POST['nom_completo']), "text"),
            GetSQLValueString($_POST['pas_usuario'], "text"),
            GetSQLValueString($_POST['est_usuario'], "int"),
            GetSQLValueString($_POST['tic_eliminados'], "int"),
            GetSQLValueString($_POST['cod_barra'], "int"),
            GetSQLValueString($hora_ini, "date"),
            GetSQLValueString($hora_fin, "date"),
            GetSQLValueString($trabaja, "text"),
            GetSQLValueString($_POST['tic_re'], "int"),
	    GetSQLValueString($_POST['24hr'], "int"),
            GetSQLValueString($_POST['id_usuario'], "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertGoTo = "./taquillas_edit.php?recordID=".$_POST['cod_taquilla7'];
        header(sprintf("Location: %s", $insertGoTo));
    }
}


$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 distri\usuarios_ve_edit.php - QUERY 2 */ SELECT us.id_usuario, us.pas_usuario, us.nom_usuario, us.dia_entrada, us.hor_inicio, us.hor_fin,
	us.nom_completo, us.pas_usuario, us.est_usuario, us.tic_eliminados, us.cod_barra, us.can_reimpresion, 
	ta.nom_taquilla, ta.cod_taquilla
	FROM 
	usuario us, taquilla ta 
	WHERE 
	us.id_usuario = %s AND
	ta.cod_taquilla = us.cod_taquilla LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
list($dia7, $dia1, $dia2, $dia3, $dia4, $dia5, $dia6)=explode("-", $row_Recordset1['dia_entrada']);
list($hor_in, $min_in, $am_in)=explode(":", cambioHoramysql($row_Recordset1['hor_inicio']));
list($hor_fi, $min_fi, $am_fi)=explode(":", cambioHoramysql($row_Recordset1['hor_fin']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
  height:20px;
  }
  .textbox:focus, .textboxsmal:focus {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxsmal {
	  width:50px;
	  height:10px;
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
    $('#username').blur(function(){
		var usern = $('input[name=username]').val();
		if(usern != '') {
			var username = $(this).val();        
			var dataString = 'username='+username;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarUsuario.php",
				data: dataString,
				success: function(data) {
					$('#Info32').fadeIn(200).html(data);
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
</script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceradistri.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                EDITAR VENDEDOR<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center">
                <tr valign="baseline">
                  <td height="44" colspan="3" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE USUARIO
                  VENDEDOR</td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td align="left" valign="middle" nowrap>
                  	<div style="width:98.5%; text-align:left; padding:6px 0px 6px 8px; font-size:18px; background: #FFF">
                    Nombre de usuario:
                  	<?php echo $row_Recordset1['nom_usuario']." | ".$row_Recordset1['nom_taquilla']?>
                    </div>
                    <br>
                  
					
                  </td>
                  <td width="180">&nbsp;</td>
                
                <tr valign="baseline">
                  <td height="26" colspan="3" align="center" valign="middle" nowrap bgcolor="#5EAEFF">DATOS Y OPCIONES DE USUARIO</td>
                </tr>
              </table>
              <table width="921" align="center">
		<tr width="123" align="left" valign="middle">
                  TRABAJAR 24/7: (Desactivarlo eliminara el formato de Hora y Cierre de Ventas<br/>
                  <select name="24hr" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['24hr'], ENT_COMPAT, 'utf-8')))) {
    			echo "SELECTED";
		} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['24hr'], ENT_COMPAT, 'utf-8')))) {
    		echo "SELECTED";
		} ?>>INACTIVO</option>
                    </select>
                  </tr>
                <tr valign="baseline">
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td width="249" align="left" nowrap>
                  	Nombre en ticket:<br />
                  	<input type="text" name="nom_completo" class="textbox" placeholder="nombre en ticket" maxlength="15"
                    pattern="[A-Z a-z 0-9]{0,15}" title="indique un nombre para mostrar en ticket. 4-15 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34"
                    value="<?php echo htmlentities($row_Recordset1['nom_completo'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNcus; ?></div>
                  </td>
                  <td width="212">
                  	Contraseña de acceso:<br />
                    <input type="password" name="pas_usuario" id="pas_usuario" size="32" class="textbox"  
                    placeholder="contraseña" pattern="[A-Z a-z0-9]{4,20}" maxlength="20" style="height: auto"
                    value="<?php echo htmlentities($row_Recordset1['pas_usuario'], ENT_COMPAT, 'utf-8'); ?>" 
                    tabindex="33" onKeyUp="return handleEnter(this, event)"/>
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menPass; ?></div>
                  </td>
                  <td width="123" align="left" valign="middle">
                  	<input name="Botón" type="button" class="btn-primary" value="Generar clave"
                    style="width:auto; height:40px; font-size:11px" 
                    onClick="ocultaDiv('Info34'),FX_passGenerator('form1','pas_usuario')"/>
                  </td>
                  <td width="272">
                    Status de vendedor:<br />
                    <select name="est_usuario" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['est_usuario'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['est_usuario'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
                    </select>
                  </td>
                </tr>
              </table>
              <table width="920" border="0">
                  <tr>
                    <td width="16">&nbsp;</td>
                    <td width="123">&nbsp;</td>
                    <td width="66">&nbsp;</td>
                    <td width="141">&nbsp;</td>
                    <td width="97">&nbsp;</td>
                    <td width="208">Hora de inicio de venta:</td>
                    <td width="239">Hora de cierre de venta:</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right">Máx Ticket a eliminar:</td>
                    <td>
                    	<input type="text" name="tic_eliminados" class="textboxsmal" 
                        style="height:20px" onclick="ocultaDiv('Info36');"
                        value="<?php echo htmlentities($row_Recordset1['tic_eliminados'], ENT_COMPAT, 'utf-8'); ?>" 
                        size="32" onkeypress="ValidaSoloNumeros()" title="indique máximo a eliminar"
                    	onKeyUp="return handleEnter(this, event)" tabindex="35" required pattern="[0-9]{1,5}"/>
                    <div id="Info36" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menTeli; ?></div>
                    </td>
                    <td align="right">Codigo de barra en ticket:</td>
                    <td>
                    	<select name="cod_barra" style="width: auto; height: auto" class="textbox" tabindex="36">
                      		<option value="1" <?php
                            if (!(strcmp(1, htmlentities($row_Recordset1['cod_barra'], ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>SI
                            </option>
                      		<option value="0" <?php
                            if (!(strcmp(0, htmlentities($row_Recordset1['cod_barra'], ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>NO
                            </option>
                    	</select>
                    </td>
                    <td>
                    	<select name="hor_in" style="width: auto; height: auto" class="textbox" tabindex="37" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 1; $i <= 12; $i++) {
                                if ($i<10) {
                                    $v="0".$i;
                                } else {
                                    $v=$i;
                                } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($v, htmlentities($hor_in, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                           <?php
                            }?>
                        </select>
                      	<select name="min_in" style="width: auto; height: auto" class="textbox" tabindex="38" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 0; $i <= 55; $i=$i+5) {
                                if ($i<10) {
                                    $v="0".$i;
                                } else {
                                    $v=$i;
                                } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($v, htmlentities($min_in, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                            <?php
                            }?>
                      </select>
                      <select name="am_in" style="width: auto; height: auto" class="textbox" tabindex="39" 
                        onfocus="ocultaDiv('Info37');">
	                        <option value="AM" <?php
                            if (!(strcmp("AM", htmlentities($am_in, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>AM
                            </option>
                        	<option value="PM" <?php
                            if (!(strcmp("PM", htmlentities($am_in, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>PM
                            </option>
                      </select>
                      <div id="Info37" style="float: left; width:auto; color: #F00; margin:-8px 0px 0px 0px; font-size:12px">
					  <?php echo $menHin; ?></div>
                  </td>
                  <td>
                   	<select name="hor_fi" style="width: auto; height: auto" class="textbox" tabindex="40" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 1; $i <= 12; $i++) {
                                if ($i<10) {
                                    $v="0".$i;
                                } else {
                                    $v=$i;
                                } ?>
                                <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($v, htmlentities($hor_fi, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                                </option>
                           <?php
                            }?>
                    </select>
                   	<select name="min_fi" style="width: auto; height: auto" class="textbox" tabindex="41" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 0; $i <= 55; $i=$i+5) {
                                if ($i<10) {
                                    $v="0".$i;
                                } else {
                                    $v=$i;
                                } ?>
                                <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($v, htmlentities($min_fi, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                                </option>
                            <?php
                            }?>
                    </select>
                      <select name="am_fi" style="width: auto; height: auto" class="textbox" tabindex="42" 
                        onfocus="ocultaDiv('Info37');">
                        	<option value="AM" <?php
                            if (!(strcmp("AM", htmlentities($am_fi, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>AM
                            </option>
                        	<option value="PM" <?php
                            if (!(strcmp("PM", htmlentities($am_fi, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>PM
                            </option>
                    </select></td>
                  </tr>
                </table>
                <table width="924" align="center">
                <tr valign="baseline" style="font-size:12px">
                  <td width="36" align="left" nowrap>&nbsp;</td>
                  <td width="182" align="left" nowrap>&nbsp;</td>
                  <td width="68" align="center" valign="bottom">LUNES</td>
                  <td align="center" valign="bottom">MARTES</td>
                  <td align="center" valign="bottom">MIÉRCOLES</td>
                  <td width="68" align="center" valign="bottom">JUEVES</td>
                  <td width="68" align="center" valign="bottom">VIERNES</td>
                  <td width="68" align="center" valign="bottom">SÁBADO</td>
                  <td width="68" align="center" valign="bottom">DOMINGO</td>
                  <td width="98" rowspan="2" align="right" valign="top">
                  	<strong>Cant. de tickets a reimprimir:</strong>
                  </td>
                  <td colspan="2" rowspan="2" align="left" valign="top">
					<select name="tic_re" style="width: auto; height: auto" class="textbox" tabindex="41">
                        	<?php for ($i = 0; $i <= 40; $i++) {?>
                                <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($row_Recordset1['can_reimpresion'], ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $i; ?>
                                </option>
                           <?php  }?>
                    </select>                  
                  </td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="right">Días que trabaja</td>
                  <td align="center"><input type="checkbox" name="dia1" class="textboxsmal" tabindex="43"
                  value=""  <?php if (!(strcmp(htmlentities($dia1, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> /></td>
                  <td width="68" align="center"><input type="checkbox" name="dia2" class="textboxsmal" tabindex="44"
                  value=""  <?php if (!(strcmp(htmlentities($dia2, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> /></td>
                  <td width="70" align="center"><input type="checkbox" name="dia3" class="textboxsmal" tabindex="45"
                  value=""  <?php if (!(strcmp(htmlentities($dia3, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> /></td> 
                  <td align="center"><input type="checkbox" name="dia4" class="textboxsmal" tabindex="46"
                  value=""  <?php if (!(strcmp(htmlentities($dia4, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> /></td>
                  <td align="center"><input type="checkbox" name="dia5" class="textboxsmal" tabindex="47"
                  value=""  <?php if (!(strcmp(htmlentities($dia5, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> /></td>
                  <td align="center"><input type="checkbox" name="dia6" class="textboxsmal" tabindex="48"
                  value=""  <?php if (!(strcmp(htmlentities($dia6, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> /></td>
                  <td align="center"><input type="checkbox" name="dia7" class="textboxsmal" tabindex="49"
                  value=""  <?php if (!(strcmp(htmlentities($dia7, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> /></td>
                  </tr>
                <tr valign="baseline">
                  <td colspan="12" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td colspan="12" align="left" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td colspan="3" align="right" valign="bottom" nowrap>
                  <a href='./taquillas_edit.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="11" align="left" nowrap>&nbsp;</td>
                  </tr>
              </table>
          </div>
          <input type="hidden" name="MM_insert" value="form1"/>
          <input type="hidden" name="tip_usuario" value="U"/>
		  <input type="hidden" name="id_usuario" value="<?php echo $row_Recordset1['id_usuario'] ?>"/>

          <input type="hidden" name="cod_taquilla7" value="<?php echo $row_Recordset1['cod_taquilla'] ?>"/>
          <input type="hidden" name="pas_usuario2" value="<?php echo $row_Recordset1['pas_usuario'] ?>"/>
      </form>
    </div>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>
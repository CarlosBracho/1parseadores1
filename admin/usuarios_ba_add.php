<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
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
$hor_in="9";
$min_in="0";
$am_in="AM";
$hor_fi="11";
$min_fi="30";
$am_fi="PM";
$dia1="1";
$dia2="1";
$dia3="1";
$dia4="1";
$dia5="1";
$dia6="1";
$dia7="1";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    $control=0;
    $contron=0;
    $hora_ini="00:00:00";
    $hora_fin="23:59:00";
    $trabaja="1-1-1-1-1-1-1";
    if (isset($_POST['nom_usuario']) && $_POST['nom_usuario']!="") {
        if (buscaUsu($_POST['nom_usuario'])>0) {
            $menNus="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_usuario']=="" || strlen($_POST['nom_usuario'])<3) {
        $menNus="nombre no válido";
        $graba--;
    }
    if ($_POST['nom_completo']=="" || strlen($_POST['nom_completo'])<3) {
        $menNcus="nombre no válido";
        $graba--;
    }
    if ($_POST['pas_usuario']=="" || strlen($_POST['pas_usuario'])<=3) {
        $menPass="debe contener 4 caracteres o mas";
        $graba--;
    }
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 admin\usuarios_ba_add.php - QUERY 1 */ INSERT 
		INTO usuario 
		(nom_usuario, nom_completo, tip_usuario, cod_taquilla, pas_usuario, est_usuario, tic_eliminados, 
		cod_barra, hor_inicio, hor_fin, dia_entrada, niv_acceso) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_usuario']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_completo']), "text"),
            GetSQLValueString($_POST['tip_usuario'], "text"),
            GetSQLValueString($_POST['cod_taquilla'], "int"),
            GetSQLValueString($_POST['pas_usuario'], "text"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString($hora_ini, "date"),
            GetSQLValueString($hora_fin, "date"),
            GetSQLValueString($trabaja, "text"),
            GetSQLValueString(1, "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertGoTo = "usuarios_ba_lista.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$query_Recordset2 = "/* PARSEADORES1 admin\usuarios_ba_add.php - QUERY 2 */ SELECT cod_banca, nom_banca FROM banca";
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
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
  .textbox, .textboxsmal
  {
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
  .textbox:focus, .textboxsmal:focus
  {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxsmal
  {
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
                Nuevo Usuario Distribuidor<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE DISTRIBUIDOR
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="365" align="left" valign="middle" nowrap>Distribuidor:<br>
                    <select name="cod_taquilla" style="width:327px; height: auto" class="textbox">
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_Recordset2['cod_banca']?>">
                        <?php echo $row_Recordset2['nom_banca']?></option>
                    <?php
                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                    ?>
                    </select>
                  </td>
                  <td width="117">&nbsp;</td>
                  <td width="232">&nbsp;</td>
                  <td width="180">&nbsp;</td>
                
                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">
                  DATOS Y OPCIONES DE USUARIO DISTRIBUIDOR</td>
                </tr>
              </table>
              <table width="921" align="center">
                <tr valign="baseline">
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td width="249" align="left" nowrap>
                  	Nombre de usuario:<br>
                    <input type="text" name="nom_usuario" class="textbox" id="username"
                    value=""
                    size="32" placeholder="nombre de usuario" 
                    maxlength="30" pattern="[A-Z a-z0-9]{4,30}" title="indique un nombre de usuario. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');" tabindex="32" required />
                    <div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNus; ?></div>
                  </td>
                  <td width="212">
                  	Contraseña de acceso:<br />
                    <input type="text" name="pas_usuario" id="pas_usuario" size="32" class="textbox" 
                    placeholder="contraseña" pattern="[A-Z a-z0-9]{4,20}" maxlength="20" 
                    value="" tabindex="33" onKeyUp="return handleEnter(this, event)"/>
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menPass; ?></div>
                  </td>
                  <td width="123" align="left" valign="middle">
                  	<input name="Botón" type="button" class="btn-primary" value="Generar clave"
                    style="width:auto; height:40px; font-size:11px" 
                    onClick="ocultaDiv('Info34'),FX_passGenerator('form1','pas_usuario')"/>
                  </td>
                  <td width="272">
                  	Nombre completo:<br />
                  	<input type="text" name="nom_completo" class="textbox" placeholder="nombre en ticket" maxlength="20"
                    pattern="[A-Z a-z0-9]{4,20}" title="indique un nombre para mostrar en ticket. 4-20 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34" 
                    value="APUESTA" 
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNcus; ?></div>
                  </td>
                </tr>
              </table>
<table width="924" align="center">
            <tr valign="baseline">
              <td colspan="11" align="left" nowrap>&nbsp;</td>
              </tr>
                <tr valign="baseline">
                  <td colspan="11" align="left" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                  </tr>
                <tr valign="baseline">
                  <td width="37" align="left" nowrap>&nbsp;</td>
                  <td width="182" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="70" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="206" colspan="2" align="right" valign="bottom" nowrap>
                  <a href='usuarios_ba_lista.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="36" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="10" align="left" nowrap>&nbsp;</td>
                  </tr>
              </table>
               
          </div>
          <input type="hidden" name="MM_insert" value="form1"/>
          <input type="hidden" name="tip_usuario" value="D"/>
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
mysqli_free_result($Recordset2);
?>
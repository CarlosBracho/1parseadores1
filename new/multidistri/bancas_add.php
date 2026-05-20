<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "S"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$menTaq="";
$menNre="";
$menTel="";
$menNus="";
$menNcus="";
$menPass="";
$menNti="";
$menPas="";
$menHin="";
$menAmig="";	//monto apuesta minima a gan
$menAmag="";
$menRgan="";
$menMgan="";	// monto maximo a ganar a ganador
$menMmt="";		// monto maximo en ticket
$menAmip="";	//monto apuesta minima a pla
$menAmap="";
$menRpla="";
$menMpla="";
$menAmis="";	//monto apuesta minima a sho
$menAmas="";
$menRsho="";
$menMsho="";
$menMmae="";
$menAmie="";	//monto apuesta minima a exa
$menAmae="";
$menRexa="";
$menMexa="";
$menAmit="";	//monto apuesta minima a tri
$menAmat="";
$menRtri="";
$menMtri="";
$menAmisu="";	//monto apuesta minima a sup
$menAmasu="";
$menRsup="";
$menMsup="";
$menNus="";
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
$menDir="";
$editFormAction = $_SERVER['PHP_SELF'];

$query_Recordset3 =  sprintf(
  "/* PARSEADORES1 new\multidistri\bancas_add.php - QUERY 1 */ SELECT * 
FROM 
usuario
WHERE id_usuario = %s",
GetSQLValueString($_SESSION['MM_id_usuario'], "int"));
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);


$Anom=$row_Recordset3['nom_usuario'];


if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    $hora_ini="00:00:00";
    $hora_fin="23:59:00";
    $trabaja="1-1-1-1-1-1-1";
    $control=0;
    $contron=0;
    $letras = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $fecInicio=fechaactualbd();
    
    $numeros="0123456789";
    
    if (isset($_POST['nom_taquilla']) && $_POST['nom_taquilla']!="") {
        if (buscaDis($_POST['nom_taquilla'])>0) {
            $menTaq="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_taquilla']=="" || strlen($_POST['nom_taquilla'])<=3) {
        $menTaq="nombre no válido";
        $graba--;
    }
    if (isset($_POST['nom_usuario']) && $_POST['nom_usuario']!="") {
        if (buscaUsu($_POST['nom_usuario'])>0) {
            $menNus="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_usuario']=="" || strlen($_POST['nom_usuario'])<=3) {
        $menNus="nombre no válido";
        $graba--;
    }
    if ($_POST['pas_usuario']=="" || strlen($_POST['pas_usuario'])<=3) {
        $menPass="debe contener 4 caracteres o mas";
        $graba--;
    }
    if ($graba==31) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\multidistri\bancas_add.php - QUERY 2 */ INSERT 
				INTO banca 
				(nom_banca, nom_representante, tel_banca, cod_multidistriMDBA, dir_banca,				
dist_vende_ame,
dist_por_ame,
dist_vende_hnac,
dist_cob_hnac,				
				por_banca_lot, por_banca_macu,
				fec_banca, est_banca) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_taquilla']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_representante']), "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString($_POST['cod_banca'], "int"),
            GetSQLValueString(strtoupper($_POST['direccion']), "text"),
            GetSQLValueString($_POST['dist_vende_ame'], "int"),
            GetSQLValueString($_POST['dist_por_ame'], "double"),
            GetSQLValueString($_POST['dist_vende_hnac'], "int"),
            GetSQLValueString($_POST['dist_cob_hnac'], "double"),
            GetSQLValueString(0, "double"),
            GetSQLValueString(0, "double"),
            GetSQLValueString($fecInicio, "date"),
            GetSQLValueString(1, "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $query_RecT = "/* PARSEADORES1 new\multidistri\bancas_add.php - QUERY 3 */ SELECT cod_banca FROM banca ORDER BY cod_banca DESC LIMIT 1";
        $RecT = mysqli_query($conexionbanca, $query_RecT) or die(mysqli_error($conexionbanca));
        $row_RecT = mysqli_fetch_assoc($RecT);
        $totalRows_RecT = mysqli_num_rows($RecT);
        $codTaquilla=$row_RecT['cod_banca'];
        $insertSQL3 = sprintf(
            "/* PARSEADORES1 new\multidistri\bancas_add.php - QUERY 4 */ INSERT 
		INTO usuario 
		(nom_usuario, nom_completo, tip_usuario, cod_taquilla, pas_usuario, est_usuario, tic_eliminados, cod_barra, 
		hor_inicio, hor_fin, dia_entrada, niv_acceso) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_usuario']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_completo']), "text"),
            GetSQLValueString($_POST['tip_usuario'], "text"),
            GetSQLValueString($codTaquilla, "int"),
            GetSQLValueString($_POST['pas_usuario'], "text"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString($hora_ini, "date"),
            GetSQLValueString($hora_fin, "date"),
            GetSQLValueString($trabaja, "text"),
            GetSQLValueString(1, "int")
        );
        
        $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));


        $Dnom=$_POST['nom_usuario'];

/*/
        $msj='El Administrador '. $Anom .' creo un nuevo Distribuidor con el nombre: '.$Dnom;
        $msjx=utf8_encode($msj);
        $post=[
          'chat_id'=>-1001548429339,
          'text'=>$msjx,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5155928341:AAFaxAoro6OLjtRvCMwnri0Zyfnwd-MgPdY/sendMessage");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_exec ($ch);
        curl_close ($ch);
/*/
        $insertGoTo = "bancas_lista.php";
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
    $('#nom_taquilla').blur(function(){
		var taquilla = $('input[name=nom_taquilla]').val();
		if(taquilla != '') {
			var nom_taquilla = $(this).val();        
			var dataString = 'nom_taquilla='+nom_taquilla;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarDistribuidor.php",
				data: dataString,
				success: function(data) {
					$('#Info1').fadeIn(200).html(data);
				}
			});
		};
    });              
});
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
	if (event.keyCode != 46) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
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
			<?php include("../includes/cabeceraamericana_multidistri.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 30px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceramultidistri.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                Nuevo agente<br/>
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
                  	COSTO DEL SISTEMA
                                   </td>
                 </tr> 
                <tr valign="baseline">
                  <td width="420" height="41" align="center" valign="bottom" nowrap bgcolor="#999999">Estado Venta Internacionales:</td>
                  <td width="420" align="center" valign="bottom" nowrap>Estado Venta Nacionales:</td>
                  <td align="center" valign="bottom" nowrap>&nbsp;</td>
                </tr>  
                <tr valign="baseline">
				
                  <td width="420" height="88" align="center" valign="top" nowrap bgcolor="#999999">
                  	
					                    <select name="dist_vende_ame" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1">ACTIVO</option>
                      <option value="0">INACTIVO</option>
					  </select>
					
					<br />Porcentaje Internacionales:<br />
					<input type="text" name="dist_por_ame" class="textbox" style="height:auto; width:50px" 
                    onclick="ocultaDiv('Info7');"
                    value="0.00" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                  	%
					                  

				 </td>
                  <td width="420" align="center" valign="top" nowrap>
				                      <select name="dist_vende_hnac" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1">ACTIVO</option>
                      <option value="0">INACTIVO</option>
					  </select>
					  
                  	
										                  <br />Costo x pto Nacionales:<br />
<input type="text" name="dist_cob_hnac" class="textbox" style="height:auto; width:100px" 
                    onclick="ocultaDiv('Info7');"
                    value="0.00" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                  </td>
                  <td width="419" align="center" valign="top" nowrap>&nbsp;</td>
                </tr>  
                <tr valign="baseline">
                  <td height="20" colspan="5" align="center" valign="bottom" nowrap>&nbsp;</td>
                </tr>
				</table>
				 <table width="919" align="center">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE DISTRIBUIDOR
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="240" align="left" valign="middle" nowrap>
                  Nombre de distribuidor:<br>
                    <input type="text" name="nom_taquilla" id="nom_taquilla" class="textbox" tabindex="1"
                    value="" 
                    size="32" placeholder="nombre de taquilla" title="indique un nombre 4-30 caracteres" 
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info1');"
                    maxlength="33" pattern="[A-Z a-z0-9]{4,30}" required/>
                    <div id="Info1" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
					<?php echo $menTaq; ?></div>
                  </td>
                  <td width="242" align="left">
                  Nombre de representante:<br />
                  <input type="text" name="nom_representante" class="textbox" tabindex="2" placeholder="nombre completo"
                  value="" 
                  size="32" title="indique un nombre de representante. 4-30 caracteres" onclick="ocultaDiv('Info2');"/>
                  <div id="Info2" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menNre; ?></div>
                  </td>
                  <td width="232" align="left">
                  Teléfono de distribuidor:<br />
                  <input type="text" name="tel_taquilla" class="textbox"  tabindex="3"
                  size="32"  maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value=""  
                  placeholder="02120000000" title="indique número de teléfono. 11 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" nowrap>
                  
					Dirección:
                  	<input type="text" name="direccion" class="textbox" placeholder="dirección" maxlength="30"
                    pattern="[A-Z a-z0-9]{0,20}" title="indique dirección. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34" 
                    value="" style="width:350px"
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menDir; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
              </table>
              <table width="919" align="center">
               
                <tr valign="baseline">
                  <td height="36" colspan="5" align="center" valign="bottom" nowrap bgcolor="#5EAEFF">
                  DATOS Y OPCIONES DE USUARIO DISTRIBUIDOR</td>
                </tr>
              </table>
              <table width="921" align="center">
                <tr valign="baseline">
                  <td height="20" align="left" valign="top" nowrap>&nbsp;</td>
                  <td align="left" valign="top" nowrap>&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td width="41" height="89" align="left" valign="top" nowrap>&nbsp;</td>
                  <td width="249" align="left" valign="top" nowrap>
                  	Nombre de usuario:<br>
                    <input type="text" name="nom_usuario" class="textbox" id="username"
                    value=""
                    size="32" placeholder="nombre de usuario" 
                    maxlength="20" pattern="[A-Z a-z0-9]{4,20}" title="indique un nombre de usuario. 4-20 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');" tabindex="32" required />
                    <div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNus; ?></div>
                  </td>
                  <td width="212" valign="top">
                  	Contraseña de acceso:<br />
                    <input type="text" name="pas_usuario" id="pas_usuario" size="32" class="textbox" 
                    placeholder="contraseña" pattern="[A-Z a-z0-9]{4,20}" maxlength="20" 
                    value="" tabindex="33" onKeyUp="return handleEnter(this, event)"/>
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menPass; ?></div>
                  </td>
                  <td width="123" align="left" valign="top">
                  	<input name="Botón" type="button" class="btn-primary" value="Generar clave"
                    style="width:auto; height:40px; font-size:11px" 
                    onClick="ocultaDiv('Info34'),FX_passGenerator('form1','pas_usuario')"/>
                  </td>
                  <td width="272" valign="top">
                  	Nombre completo:<br />
                  	<input type="text" name="nom_completo" class="textbox" placeholder="nombre completo" maxlength="20"
                    pattern="[A-Z a-z0-9]{0,20}" title="indique nombre completo. 4-20 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34" 
                    value="" 
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNcus; ?></div>
                  </td>
                </tr>
              </table>
              
		<table width="924" align="center">
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
                  <td width="199" colspan="2" align="right" valign="bottom" nowrap>
                  <a href='bancas_lista.php'
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
          <input type="hidden" name="cod_banca" value="<?php echo $_SESSION['MM_cod_multidistriMD'] ?>"/>
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
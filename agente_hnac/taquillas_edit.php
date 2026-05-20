<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menTaq="";
$menNre="";
$menTel="";
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $graba=31;
    if (isset($_POST['est_gan'])) {
        $_POST['est_gan']=1;
    } else {
        $_POST['est_gan']=0;
    }
    if (isset($_POST['est_pla'])) {
        $_POST['est_pla']=1;
    } else {
        $_POST['est_pla']=0;
    }
    if (isset($_POST['est_sho'])) {
        $_POST['est_sho']=1;
    } else {
        $_POST['est_sho']=0;
    }
    if (isset($_POST['est_exa'])) {
        $_POST['est_exa']=1;
    } else {
        $_POST['est_exa']=0;
    }
    if (isset($_POST['est_tri'])) {
        $_POST['est_tri']=1;
    } else {
        $_POST['est_tri']=0;
    }
    if (isset($_POST['est_sup'])) {
        $_POST['est_sup']=1;
    } else {
        $_POST['est_sup']=0;
    }
    if (!isset($_POST['apu_maxgan']) || $_POST['apu_maxgan']<=0) {
        $_POST['apu_maxgan']="";
        $menAmag= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxpla']) || $_POST['apu_maxpla']<=0) {
        $_POST['apu_maxpla']="";
        $menAmap= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxsho']) || $_POST['apu_maxsho']<=0) {
        $_POST['apu_maxsho']="";
        $menAmas= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxexa']) || $_POST['apu_maxexa']<=0) {
        $_POST['apu_maxexa']="";
        $menAmae= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxtri']) || $_POST['apu_maxtri']<=0) {
        $_POST['apu_maxtri']="";
        $menAmat= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxsup']) || $_POST['apu_maxsup']<=0) {
        $_POST['apu_maxsup']="";
        $menAmasu="indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_mingan']) || $_POST['apu_mingan']<=0) {
        $_POST['apu_mingan']="";
        $menAmig= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_minpla']) || $_POST['apu_minpla']<=0) {
        $_POST['apu_minpla']="";
        $menAmip= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_minsho']) || $_POST['apu_minsho']<=0) {
        $_POST['apu_minsho']="";
        $menAmis= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_minexa']) || $_POST['apu_minexa']<=0) {
        $_POST['apu_minexa']="";
        $menAmie= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_mintri']) || $_POST['apu_mintri']<=0) {
        $_POST['apu_mintri']="";
        $menAmit= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_minsup']) || $_POST['apu_minsup']<=0) {
        $_POST['apu_minsup']="";
        $menAmisu="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_gan']) || $_POST['reg_gan']<0) {
        $_POST['reg_gan']="";
        $menRgan="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_pla']) || $_POST['reg_pla']<0) {
        $_POST['reg_pla']="";
        $menRpla="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_sho']) || $_POST['reg_sho']<0) {
        $_POST['reg_sho']="";
        $menRsho="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_exa']) || $_POST['reg_exa']<0) {
        $_POST['reg_exa']="";
        $menRexa="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_tri']) || $_POST['reg_tri']<0) {
        $_POST['reg_tri']="";
        $menRtri="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_sup']) || $_POST['reg_sup']<0) {
        $_POST['reg_sup']="";
        $menRsup="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_gan'])||$_POST['max_aganar_gan']<=0) {
        $_POST['max_aganar_gan']="";
        $menMgan="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_pla'])||$_POST['max_aganar_pla']<=0) {
        $_POST['max_aganar_pla']="";
        $menMpla="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_sho'])||$_POST['max_aganar_sho']<=0) {
        $_POST['max_aganar_sho']="";
        $menMsho="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_exa'])||$_POST['max_aganar_exa']<=0) {
        $_POST['max_aganar_exa']="";
        $menMexa="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_tri'])||$_POST['max_aganar_tri']<=0) {
        $_POST['max_aganar_tri']="";
        $menMtri="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_sup'])||$_POST['max_aganar_sup']<=0) {
        $_POST['max_aganar_sup']="";
        $menMsup="indique monto";
        $graba--;
    }
    if (!isset($_POST['mon_maxticket'])||$_POST['mon_maxticket']<=0) {
        $_POST['mon_maxticket']="";
        $menMmt="indique monto";
        $graba--;
    }
    if (!isset($_POST['mon_maxejemplar'])||$_POST['mon_maxejemplar']<=0) {
        $_POST['mon_maxejemplar']="";
        $menMmae="indique monto";
        $graba--;
    }
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 agente_hnac\taquillas_edit.php - QUERY 1 */ UPDATE taquilla 
				SET nom_representante=%s, tel_taquilla=%s, est_taquilla=%s
				WHERE cod_taquilla=%s",
            GetSQLValueString($_POST['nom_representante'], "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString($_POST['est_taquilla'], "int"),
            GetSQLValueString($_POST['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertSQL2 = sprintf(
            "/* PARSEADORES1 agente_hnac\taquillas_edit.php - QUERY 2 */ UPDATE taquilla_opc_ame
				SET 
				apu_maxgan=%s, 
				apu_maxpla=%s, 
				apu_maxsho=%s, 
				apu_maxexa=%s, 
				apu_maxtri=%s, 
				apu_maxsup=%s, 
				apu_mingan=%s, 
				apu_minpla=%s, 
				apu_minsho=%s,	
				apu_minexa=%s, 
				apu_mintri=%s, 
				apu_minsup=%s, 
				reg_gan=%s, 
				reg_pla=%s, 
				reg_sho=%s, 
				reg_exa=%s, 
				reg_tri=%s, 
				reg_sup=%s, 
				est_gan=%s, 
				est_pla=%s, 
				est_sho=%s, 
				est_exa=%s,
				est_tri=%s, 
				est_sup=%s, 
				max_aganar_gan=%s, 
				max_aganar_pla=%s, 
				max_aganar_sho=%s, 
				max_aganar_exa=%s, 
				max_aganar_tri=%s, 
				max_aganar_sup=%s,
				mon_maxticket=%s, 
				mon_maxejemplar=%s, 
				min_ejecarrera=%s, 
				por_taquilla=%s
				WHERE cod_taopcame=%s",
            GetSQLValueString($_POST['apu_maxgan'], "int"),
            GetSQLValueString($_POST['apu_maxpla'], "int"),
            GetSQLValueString($_POST['apu_maxsho'], "int"),
            GetSQLValueString($_POST['apu_maxexa'], "int"),
            GetSQLValueString($_POST['apu_maxtri'], "int"),
            GetSQLValueString($_POST['apu_maxsup'], "int"),
            GetSQLValueString($_POST['apu_mingan'], "int"),
            GetSQLValueString($_POST['apu_minpla'], "int"),
            GetSQLValueString($_POST['apu_minsho'], "int"),
            GetSQLValueString($_POST['apu_minexa'], "int"),
            GetSQLValueString($_POST['apu_mintri'], "int"),
            GetSQLValueString($_POST['apu_minsup'], "int"),
            GetSQLValueString($_POST['reg_gan'], "int"),
            GetSQLValueString($_POST['reg_pla'], "int"),
            GetSQLValueString($_POST['reg_sho'], "int"),
            GetSQLValueString($_POST['reg_exa'], "int"),
            GetSQLValueString($_POST['reg_tri'], "int"),
            GetSQLValueString($_POST['reg_sup'], "int"),
            GetSQLValueString($_POST['est_gan'], "int"),
            GetSQLValueString($_POST['est_pla'], "int"),
            GetSQLValueString($_POST['est_sho'], "int"),
            GetSQLValueString($_POST['est_exa'], "int"),
            GetSQLValueString($_POST['est_tri'], "int"),
            GetSQLValueString($_POST['est_sup'], "int"),
            GetSQLValueString($_POST['max_aganar_gan'], "int"),
            GetSQLValueString($_POST['max_aganar_pla'], "int"),
            GetSQLValueString($_POST['max_aganar_sho'], "int"),
            GetSQLValueString($_POST['max_aganar_exa'], "int"),
            GetSQLValueString($_POST['max_aganar_tri'], "int"),
            GetSQLValueString($_POST['max_aganar_sup'], "int"),
            GetSQLValueString($_POST['mon_maxticket'], "int"),
            GetSQLValueString($_POST['mon_maxejemplar'], "int"),
            GetSQLValueString($_POST['min_ejecarrera'], "int"),
            GetSQLValueString($_POST['porcentaje'], "double"),
            GetSQLValueString($_POST['cod_taopcame'], "int")
        );
        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
        $insertGoTo = "taquillas_lista.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 agente_hnac\taquillas_edit.php - QUERY 3 */ SELECT  
	taquilla.nom_taquilla,
	taquilla.nom_representante, 
	taquilla.tel_taquilla, 
	taquilla.est_taquilla, 
	taquilla.cod_taquilla, 
	taquilla_opc_ame.apu_maxgan,
	taquilla_opc_ame.apu_maxpla,
	taquilla_opc_ame.apu_maxsho,
	taquilla_opc_ame.apu_maxexa,
	taquilla_opc_ame.apu_maxtri,
	taquilla_opc_ame.apu_maxsup,
	taquilla_opc_ame.apu_mingan,
	taquilla_opc_ame.apu_minpla,
	taquilla_opc_ame.apu_minsho,
	taquilla_opc_ame.apu_minexa,
	taquilla_opc_ame.apu_mintri,
	taquilla_opc_ame.apu_minsup,
	taquilla_opc_ame.reg_gan,
	taquilla_opc_ame.reg_pla,
	taquilla_opc_ame.reg_sho,
	taquilla_opc_ame.reg_exa,
	taquilla_opc_ame.reg_tri,
	taquilla_opc_ame.reg_sup,
	taquilla_opc_ame.est_gan,
	taquilla_opc_ame.est_pla,
	taquilla_opc_ame.est_sho,
	taquilla_opc_ame.est_exa,
	taquilla_opc_ame.est_tri,
	taquilla_opc_ame.est_sup,
	taquilla_opc_ame.max_aganar_gan,
	taquilla_opc_ame.max_aganar_pla,
	taquilla_opc_ame.max_aganar_sho,
	taquilla_opc_ame.max_aganar_exa,
	taquilla_opc_ame.max_aganar_tri,
	taquilla_opc_ame.max_aganar_sup,
	taquilla_opc_ame.mon_maxticket,
	taquilla_opc_ame.mon_maxejemplar,
	taquilla_opc_ame.min_ejecarrera,
	taquilla_opc_ame.cod_taopcame,
	taquilla_opc_ame.por_taquilla,
	agencia.nom_agencia
	FROM  
	taquilla, taquilla_opc_ame, agencia 
	WHERE 
	taquilla.cod_taquilla = %s AND
	agencia.cod_agencia = taquilla.cod_agencia AND
	taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
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
                    <?php include("../includes/cabeceraagente.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                Edición de taquilla<br/>
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
                  	DATOS DE TAQUILLA
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" valign="middle" nowrap><br>
                  	<div style="width:98.5%; text-align:left; padding:6px 0px 6px 8px; font-size:18px; background: #FFF">
                    Nombre de taquilla:
                  	<?php echo $row_Recordset1['nom_taquilla'];?>
                    </div>
                    <br>
                  </td>
                <tr valign="baseline">
                  <td align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="240" align="left" valign="middle" nowrap>
                  Nombre de representante:<br />
                  <input type="text" name="nom_representante" class="textbox" tabindex="2" placeholder="nombre completo"
                  value="<?php echo htmlentities($row_Recordset1['nom_representante'], ENT_COMPAT, 'utf-8'); ?>" 
                  size="32" title="indique un nombre de representante. 4-30 caracteres" onclick="ocultaDiv('Info2');"/>
                  <div id="Info2" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menNre; ?></div>
                  </td>
                  <td width="242" align="left">
                  Teléfono de taquilla:<br />
                  <input type="text" name="tel_taquilla" class="textbox" tabindex="3"
                  size="32" pattern="[0-9]{9,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td width="232" align="left">
                  Status de taquilla:<br />
                    <select name="est_taquilla" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['est_taquilla'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['est_taquilla'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
                  </select>
                  </td>
                  <td width="180" align="left">&nbsp;
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">OPCIONES DE TAQUILLA</td>
                </tr>
              </table>
              <table width="920" align="center">
                <tr valign="baseline" style="font-size:10px">
                  <td width="1" align="left" nowrap>&nbsp;</td>
                  <td width="134" align="left" nowrap>&nbsp;</td>
                  <td width="52" align="center" valign="middle">APUESTA MÍNIMA</td>
                  <td width="52" align="center" valign="middle">APUESTA MÁXIMA</td>
                  <td width="52" align="center" valign="middle">RAGALIA</td>
                  <td width="52" align="center" valign="middle">MAXIMO A PAGAR</td>
                  <td width="56" align="center" valign="middle">ACEPTAR JUGADA</td>
                  <td width="127">&nbsp;</td>
                  <td width="116">&nbsp;</td>
                  <td width="234">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">GANADOR:</td>
                  <td>
                  	<input type="text" name="apu_mingan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($row_Recordset1['apu_mingan'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="5" required pattern="[0-9]{1,5}"/>
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>
                  <td>
                      <input type="text" name="apu_maxgan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info5');"
                      value="<?php echo htmlentities($row_Recordset1['apu_maxgan'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="6" required pattern="[0-9]{1,5}"/>
                    <div id="Info5" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmag; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_gan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info6');"
                      value="<?php echo htmlentities($row_Recordset1['reg_gan'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="7" required pattern="[0-9]{1,5}"/>
                    <div id="Info6" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRgan; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="max_aganar_gan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($row_Recordset1['max_aganar_gan'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique máxima a ganar"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required pattern="[0-9]{1,5}"/>
                    <div id="Info7" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMgan; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	<input type="checkbox" name="est_gan" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['est_gan'], ENT_COMPAT, 'utf-8'), "1"))) {
    echo "checked=\"checked\"";
} ?> />
                    </td>
                  <td>&nbsp;</td>
                  <td rowspan="2" align="right" valign="top" style="font-size:12px">Monto máximo en ticket:<br /></td>
                  <td rowspan="2" align="left" valign="top">
                    <input type="text" name="mon_maxticket" class="textboxsmal" style="height:auto; width:90px"
                    value="<?php echo htmlentities($row_Recordset1['mon_maxticket'], ENT_COMPAT, 'utf-8'); ?>"
                    onkeypress="ValidaSoloNumeros()" title="indique máximo en ticket" onclick="ocultaDiv('Info8');"
                    onKeyUp="return handleEnter(this, event)" tabindex="9" required pattern="[0-9]{1,5}"/>
                    <div id="Info8" style="width:auto; color: #F00; margin:-10px 0px 0px 0px; font-size:10px;">
					<?php echo $menMmt; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">PLACE:      </td>
                  <td>
                  	<input type="text" name="apu_minpla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info9');"
                    value="<?php echo htmlentities($row_Recordset1['apu_minpla'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="10" required pattern="[0-9]{1,5}"/>
                    <div id="Info9" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmip; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="apu_maxpla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info10');"
                    value="<?php echo htmlentities($row_Recordset1['apu_maxpla'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="11" required pattern="[0-9]{1,5}"/>
                    <div id="Info10" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmap; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="reg_pla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info11');"
                    value="<?php echo htmlentities($row_Recordset1['reg_pla'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="12" required pattern="[0-9]{1,5}"/>
                    <div id="Info11" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRpla; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="max_aganar_pla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info12');"
                    value="<?php echo htmlentities($row_Recordset1['max_aganar_pla'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="13" required pattern="[0-9]{1,5}"/>
                    <div id="Info12" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMpla; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	<input type="checkbox" name="est_pla" class="textboxsmal"
                    value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['est_pla'], ENT_COMPAT, 'utf-8'), "1"))) {
    echo "checked=\"checked\"";
} ?> /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">SHOW:      </td>
                  <td>
                  	<input type="text" name="apu_minsho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info13');"
                    value="<?php echo htmlentities($row_Recordset1['apu_minsho'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="14" required pattern="[0-9]{1,5}"/>
                    <div id="Info13" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmis; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="apu_maxsho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info14');"
                    value="<?php echo htmlentities($row_Recordset1['apu_maxsho'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="15" required pattern="[0-9]{1,5}"/>
                    <div id="Info14" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmas; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_sho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info15');"
                      value="<?php echo htmlentities($row_Recordset1['reg_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="16" required pattern="[0-9]{1,5}"/>
                    <div id="Info15" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRsho; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="max_aganar_sho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info16');"
                    value="<?php echo htmlentities($row_Recordset1['max_aganar_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="17" required pattern="[0-9]{1,5}"/>
                    <div id="Info16" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMsho; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	<input type="checkbox" name="est_sho" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['est_sho'], ENT_COMPAT, 'utf-8'), "1"))) {
    echo "checked=\"checked\"";
} ?> /></td>
                  <td>&nbsp;</td>
                  <td rowspan="2" align="right" valign="top" style="font-size:12px">Monto máximo por ejemplar:<br /></td>
                  <td rowspan="2" align="left" valign="top">
                    <input type="text" name="mon_maxejemplar" class="textboxsmal" style="height:auto; width:90px"
                      value="<?php echo htmlentities($row_Recordset1['mon_maxejemplar'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto" onclick="ocultaDiv('Info17');"
                    onKeyUp="return handleEnter(this, event)" tabindex="18" required pattern="[0-9]{1,5}"/>
                    <div id="Info17" style="width:auto; color: #F00; margin:-10px 0px 0px 0px; font-size:10px;">
					<?php echo $menMmae; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">EXACTA: </td>
                  <td>
                  	<input type="text" name="apu_minexa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info18');"
                    value="<?php echo htmlentities($row_Recordset1['apu_minexa'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="19" required pattern="[0-9]{1,5}"/>
                    <div id="Info18" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmie; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="apu_maxexa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info19');"
                    value="<?php echo htmlentities($row_Recordset1['apu_maxexa'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="20" required pattern="[0-9]{1,5}"/>
                    <div id="Info19" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmae; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_exa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info20');"
                      value="<?php echo htmlentities($row_Recordset1['reg_exa'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique uregalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="21" required pattern="[0-9]{1,5}"/>
                    <div id="Info20" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRexa; ?></div>
                  </td>
                  <td>
                      <input type="text" name="max_aganar_exa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info21');"
                      value="<?php echo htmlentities($row_Recordset1['max_aganar_exa'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="22" required pattern="[0-9]{1,5}"/>
                    <div id="Info21" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMexa; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	  <input type="checkbox" name="est_exa" class="textboxsmal"
                      value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['est_exa'], ENT_COMPAT, 'utf-8'), "1"))) {
    echo "checked=\"checked\"";
} ?> /></td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td height="28" align="left" nowrap>TRIFECTA:</td>
                  <td>
                      <input type="text" name="apu_mintri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info22');"
                      value="<?php echo htmlentities($row_Recordset1['apu_mintri'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="23" required pattern="[0-9]{1,5}"/>
                    <div id="Info22" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmit; ?></div>
                  </td>
                  <td>
                      <input type="text" name="apu_maxtri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info23');"
                      value="<?php echo htmlentities($row_Recordset1['apu_maxtri'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="24" required pattern="[0-9]{1,5}"/>
                    <div id="Info23" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmat; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_tri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info24');"
                      value="<?php echo htmlentities($row_Recordset1['reg_tri'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="25" required pattern="[0-9]{1,5}"/>
                    <div id="Info24" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRtri; ?></div>
                  </td>
                  <td>
                      <input type="text" name="max_aganar_tri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info25');"
                      value="<?php echo htmlentities($row_Recordset1['max_aganar_tri'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="26" required pattern="[0-9]{1,5}"/>
                    <div id="Info25" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMtri; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	  <input type="checkbox" name="est_tri" class="textboxsmal"
                      value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['est_tri'], ENT_COMPAT, 'utf-8'), "1"))) {
    echo "checked=\"checked\"";
} ?> />
                      </td>
                  <td>&nbsp;</td>
                  <td align="right" valign="top" style="font-size:12px">Ejemplares mínimos en carrera:<br /></td>
                  <td align="left" valign="top">
					  <select name="min_ejecarrera" style="width: auto; height: auto" class="textbox" tabindex="27">
                        	<?php for ($i = 4; $i <= 15; $i++) {?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($row_Recordset1['min_ejecarrera'], ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $i; ?>
                          </option>
                           <?php  }?>
                      </select>                      
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">SUPERFECTA:</td>
                  <td>
                      <input type="text" name="apu_minsup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info26');"
                      value="<?php echo htmlentities($row_Recordset1['apu_minsup'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="28" required pattern="[0-9]{1,5}"/>
                    <div id="Info26" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmisu; ?></div>
                  </td>
                  <td>
                      <input type="text" name="apu_maxsup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info27');"
                      value="<?php echo htmlentities($row_Recordset1['apu_maxsup'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="29" required pattern="[0-9]{1,5}"/>
                    <div id="Info27" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmasu; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_sup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info28');"
                      value="<?php echo htmlentities($row_Recordset1['reg_sup'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="30" required pattern="[0-9]{1,5}"/>
                    <div id="Info28" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRsup; ?></div>
                  </td>
                  <td>
                      <input type="text" name="max_aganar_sup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info29');"
                      value="<?php echo htmlentities($row_Recordset1['max_aganar_sup'], ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="31" required pattern="[0-9]{1,5}"/>
                    <div id="Info29" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMsup; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	  <input type="checkbox" name="est_sup" class="textboxsmal"
                      value=""  <?php if (!(strcmp(htmlentities($row_Recordset1['est_sup'], ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />
                  </td>
                  <td>&nbsp;</td>
                  <td align="right" valign="middle" style="font-size:12px">
                  	Porcentaje:
                  </td>
                  <td align="left" valign="bottom">
                    <input type="text" name="porcentaje" class="textbox" style="height:auto; width:50px" 
                    onclick="ocultaDiv('Info30');"
                    value="<?php echo htmlentities($row_Recordset1['por_taquilla'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                    <div id="Info30" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo ""; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">&nbsp;</td>
                  <td nowrap align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="20" colspan="10" align="center" valign="bottom" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                </tr>
                </table>
              <table width="924" align="center">
                <tr valign="baseline">
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="362" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td width="88" align="left" nowrap>&nbsp;</td>
                  <td width="66" align="left" nowrap>&nbsp;</td>
                  <td width="33" align="left" nowrap>&nbsp;</td>
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td align="right" valign="bottom" nowrap>
                  <a href='../agente - Copia/taquillas_lista.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="37" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="9" align="left" nowrap>&nbsp;</td>
                  </tr>
              </table>
               
          </div>
          <input type="hidden" name="MM_update" value="form1">
          <input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset1['cod_taquilla']; ?>">
          <input type="hidden" name="cod_taopcame" value="<?php echo $row_Recordset1['cod_taopcame']; ?>">
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
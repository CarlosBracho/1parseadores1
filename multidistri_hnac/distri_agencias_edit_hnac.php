<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "S"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
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
$menDir="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $graba=31;
    if ($_POST['nom_representante']=="" || strlen($_POST['nom_representante'])<=3) {
        $menNre="nombre no válido";
        $graba--;
    }
    if ($_POST['tel_taquilla']=="" || strlen($_POST['tel_taquilla'])<=9) {
        $menTel="número no válido";
        $graba--;
    }
    if ($_POST['direccion']=="" || strlen($_POST['direccion'])<=3) {
        $menDir="dirección no válida";
        $graba--;
    }
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 multidistri_hnac\distri_agencias_edit_hnac.php - QUERY 1 */ UPDATE agencia 
				SET nom_representante=%s, tel_agencia=%s, dir_agencia=%s, por_agencia_hnac=%s, est_agencia=%s
				WHERE cod_agencia=%s",
            GetSQLValueString(strtoupper($_POST['nom_representante']), "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString(strtoupper($_POST['direccion']), "text"),
            GetSQLValueString($_POST['porcentaje'], "double"),
            GetSQLValueString($_POST['est_taquilla'], "int"),
            GetSQLValueString($_POST['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertGoTo = "distri_agencias_lista_hnac.php";
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
    "/* PARSEADORES1 multidistri_hnac\distri_agencias_edit_hnac.php - QUERY 2 */ SELECT
	agencia.nom_agencia,
	agencia.cod_banca,
	agencia.nom_representante,
	agencia.tel_agencia,
	agencia.est_agencia,
	agencia.dir_agencia,
	agencia.por_agencia_hnac,
	banca.cod_banca,
	banca.nom_banca
	FROM  
	agencia,
	banca
	WHERE 
	agencia.cod_agencia = %s AND
	agencia.cod_banca = banca.cod_banca AND
	banca.cod_banca = %s",
    GetSQLValueString($xCodigo, "int"),
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
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
</script><script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
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
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabeceradistri_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Edición de agente<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#0E5157" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE AGENTE
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" valign="middle" nowrap><br><br>
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
                  Teléfono de agente:<br />
                  <input type="text" name="tel_taquilla" class="textbox" required tabindex="3"
                  size="32" pattern="[0-9]{11,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_agencia'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02124124124" title="indique número de teléfono. 11 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td width="196" align="left">
                  Status de agente:<br />
                    <select name="est_taquilla" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['est_agencia'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['est_agencia'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
                  </select>
                  </td>
                  <td width="216" align="left">
                    Porcentaje Nacionales:<br/>
                  	<input type="text" name="porcentaje" class="textbox" style="height:auto; width:50px" 
                    onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($row_Recordset1['por_agencia_hnac'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                    <div id="Info7" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMgan; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td height="64" align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
					Dirección:
                  	<input type="text" name="direccion" class="textbox" placeholder="dirección" maxlength="30"
                    pattern="[A-Z a-z0-9]{4,10}" title="indique dirección. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34" required
                    value="<?php echo htmlentities($row_Recordset1['dir_agencia'], ENT_COMPAT, 'utf-8'); ?>" style="width:350px"
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menDir; ?></div>
                  </td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td colspan="5" align="right" nowrap bgcolor="#0E5157">&nbsp;</td>
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
                  <a href='distri_agencias_lista_hnac.php'
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
          <input type="hidden" name="cod_taquilla" value="<?php echo $xCodigo ?>">
      </form>
    </div>
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
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
    echo $_POST['cod_taquilla']." ".$graba;
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 multidistri\bancas_edit.php - QUERY 1 */ UPDATE banca 
				SET nom_representante=%s, nom_banca=%s, tel_banca=%s, dir_banca=%s, 
dist_vende_ame=%s,
dist_por_ame=%s,
dist_vende_parley=%s,
dist_por_parley=%s,
dist_vende_hnac=%s,
dist_cob_hnac=%s,
				por_banca_lot=%s, por_banca_macu=%s, est_banca=%s, sinoclavesdistri = %s, sinomonedadistri = %s
				WHERE cod_banca=%s",
            GetSQLValueString(strtoupper($_POST['nom_representante']), "text"),
            GetSQLValueString($_POST['nom_banca'], "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString(strtoupper($_POST['direccion']), "text"),
            GetSQLValueString($_POST['dist_vende_ame'], "int"),
            GetSQLValueString($_POST['dist_por_ame'], "double"),
            GetSQLValueString($_POST['dist_vende_parley'], "int"),
            GetSQLValueString($_POST['dist_por_parley'], "double"),
            GetSQLValueString($_POST['dist_vende_hnac'], "int"),
            GetSQLValueString($_POST['dist_cob_hnac'], "double"),
            GetSQLValueString(0, "double"),
            GetSQLValueString(0, "double"),
            GetSQLValueString($_POST['est_taquilla'], "int"),
            GetSQLValueString($_POST['sinoclavesdistri'], "int"),  ///aqui va
            GetSQLValueString($_POST['sinomonedadistri'], "int"),  ///aqui va
            GetSQLValueString($_POST['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertGoTo = "bancas_lista.php";
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
    "/* PARSEADORES1 multidistri\bancas_edit.php - QUERY 2 */ SELECT *
	FROM  
	banca
	WHERE 
	banca.cod_banca = %s",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset94 =  sprintf(
  "/* PARSEADORES1 multidistri\bancas_edit.php - QUERY 3 */ SELECT
banca.sinoclavesdistri,
banca.sinomonedadistri
FROM  
banca
WHERE 
banca.cod_banca = %s",
  GetSQLValueString($xCodigo, "int")
);
$Recordset94 = mysqli_query($conexionbanca, $query_Recordset94) or die(mysqli_error($conexionbanca));
$row_Recordset94 = mysqli_fetch_assoc($Recordset94);
$totalRows_Recordset94 = mysqli_num_rows($Recordset94);


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
                Edición de distribuidor<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
                           


						   <table width="400" align="center">
                <tr valign="baseline">
                  <td height="44" colspan="6" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	COSTO DEL SISTEMA
                  </td>
                 </tr> 

				                <tr valign="baseline">
                  <td width="220" height="41" align="center" valign="bottom" nowrap bgcolor="#999999">Estado Venta Internacionales:</td>
                  <td width="220" align="center" valign="bottom" nowrap>Estado Venta Nacionales:</td>
                  <td width="220" align="center" valign="bottom" nowrap>Estado Venta Parley:</td>
                  <td align="center" valign="bottom" nowrap>&nbsp;</td>
                </tr>  
				<tr valign="baseline">
				                  <td width="220" height="88" align="center" valign="top" nowrap bgcolor="#999999">

				                    <select name="dist_vende_ame" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['dist_vende_ame'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['dist_vende_ame'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
						  </select>
						   <br />Porcentaje Internacionales:<br />
                  	<input type="text" name="dist_por_ame" class="textbox" style="height:auto; width:50px" 
                    onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($row_Recordset1['dist_por_ame'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                  	%
					                 

				 </td>






				
                  <td width="220" align="center" valign="top" nowrap>
				                      <select name="dist_vende_hnac" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['dist_vende_hnac'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['dist_vende_hnac'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
						  </select>
						  <br />Costo x pto Nacionales:<br />
                  	<input type="text" name="dist_cob_hnac" class="textbox" style="height:auto; width:100px" 
                    onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($row_Recordset1['dist_cob_hnac'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
										                 

                  </td>




                  				
                  <td width="220" align="center" valign="top" nowrap>
				                      <select name="dist_vende_parley" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['dist_vende_parley'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['dist_vende_parley'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
						  </select>
						  <br />Porcentaje Parley:<br />
                  	<input type="text" name="dist_por_parley" class="textbox" style="height:auto; width:100px" 
                    onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($row_Recordset1['dist_por_parley'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique porcentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
</td>






                  <td width="419" align="center" valign="top" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td colspan="5" align="right" nowrap bgcolor="#5EAEFF">&nbsp;                  </td>
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
                  <td colspan="4" align="left" valign="middle" nowrap><br>
                  	<div style="width:98.5%; text-align:left; padding:6px 0px 6px 8px; font-size:18px; background: #FFF">
                    Nombre de distribuidor:
                  	<?php echo $row_Recordset1['nom_banca'];?>
                    </div>
                    <br>
                  </td>
                <tr valign="baseline">
                  <td align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="240" align="left" valign="middle" nowrap>
                  Nuevo nombre de distribuidor:<br />
                    <input type="text" name="nom_banca" id="nom_banca" size="32" class="textbox"  
                    placeholder="usuario" pattern="[.-,-=+-%-$-(-)-A-Z a-z0-9]{4,20}" maxlength="20" style="height: auto"
                    value="<?php echo htmlentities($row_Recordset1['nom_banca'], ENT_COMPAT, 'utf-8'); ?>" 
                    tabindex="33" onKeyUp="return handleEnter(this, event)"/>
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
                    <?php echo $menNre; ?>
                  </td>
                  <td width="242" align="left">
                  Teléfono de distribuidor:<br />
                  <input type="text" name="tel_taquilla" class="textbox"  tabindex="3"
                  size="32" pattern="[0-9]{11,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_banca'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02124124124" title="indique número de teléfono. 11 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td width="196" align="left">
                  Estado Distribuidor:<br />
                    <select name="est_taquilla" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['est_banca'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['est_banca'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
                  </select>
                  </td>
                  <td width="216" align="left">
                  </td>
                </tr>
                <tr valign="baseline">
                  <td height="64" align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
					Dirección:
                  	<input type="text" name="direccion" class="textbox" placeholder="dirección" maxlength="30"
                    pattern="[A-Z a-z0-9]{4,30}" title="indique dirección. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34" 
                    value="<?php echo htmlentities($row_Recordset1['dir_banca'], ENT_COMPAT, 'utf-8'); ?>" style="width:350px"
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menDir; ?></div>
                  </td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
              </table>


              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:14px">
              <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="font-size:24px; font-weight: bold; background:#5EAEFF; color:#FFFFFF; height:30px"> <br />
                    ACTIVAR ACCESO A CLAVES:<br /><br />
          <select name="sinoclavesdistri" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset94['sinoclavesdistri']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset94['sinoclavesdistri']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>INACTIVO</option>
						  </select>
				          </td>
              </tr>


              <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="font-size:24px; font-weight: bold; background:#5EAEFF; color:#FFFFFF; height:30px"> <br />
                    CAMBIO DE MONEDA:<br /><br />
          <select name="sinomonedadistri" style="width:300px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset94['sinomonedadistri']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>NO CAMBIAR MONEDAS</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset94['sinomonedadistri']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>PERMITIR CAMBIO MONEDAS</option>
						  </select>
				          </td>
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
                  <a href='bancas_lista.php'
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
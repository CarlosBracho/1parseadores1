<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
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
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 admin\agencias_editx.php - QUERY 1 */ UPDATE agencia 
				SET nom_representante=%s, nom_agencia=%s, tel_agencia=%s, dir_agencia=%s, 
agen_vende_ame=%s,
agen_por_ame=%s,
agen_vende_hnac=%s,
agen_cob_hnac=%s,
				por_agencia_lot=%s, por_agencia_macu=%s, est_agencia=%s, cod_banca=%s, sinoclaves=%s  
				WHERE cod_agencia=%s",
            GetSQLValueString(strtoupper($_POST['nom_representante']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_agencia']), "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString(strtoupper($_POST['direccion']), "text"),
            GetSQLValueString($_POST['agen_vende_ame'], "int"),
            GetSQLValueString($_POST['agen_por_ame'], "double"),
            GetSQLValueString($_POST['agen_vende_hnac'], "int"),
            GetSQLValueString($_POST['agen_cob_hnac'], "double"),
            GetSQLValueString(0, "double"),
            GetSQLValueString(0, "double"),
            GetSQLValueString($_POST['est_agencia'], "int"),
            GetSQLValueString($_POST['cod_banca'], "int"),  ///aqui va
            GetSQLValueString($_POST['sinoclaves'], "int"),  ///aqui va
            GetSQLValueString($_POST['cod_taquilla'], "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertGoTo = "agencias_listas.php";
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
    "/* PARSEADORES1 admin\agencias_editx.php - QUERY 2 */ SELECT
	agencia.nom_agencia,
	agencia.cod_banca,
	agencia.nom_representante,
	agencia.tel_agencia,
	agencia.est_agencia,
	agencia.dir_agencia,
agencia.agen_vende_ame,
agencia.agen_por_ame,
agencia.agen_vende_hnac,
agencia.agen_cob_hnac,
	agencia.por_agencia_lot,
	agencia.por_agencia_macu,
	banca.cod_banca,
	banca.nom_banca,
	banca.dist_vende_ame,
banca.dist_vende_hnac
	FROM  
	agencia,
	banca
	WHERE 
	agencia.cod_agencia = %s AND
	banca.cod_banca = agencia.cod_banca",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset94 =  sprintf(
  "/* PARSEADORES1 admin\agencias_editx.php - QUERY 3 */ SELECT
agencia.sinoclaves
FROM  
agencia
WHERE 
agencia.cod_agencia = %s",
  GetSQLValueString($xCodigo, "int")
);
$Recordset94 = mysqli_query($conexionbanca, $query_Recordset94) or die(mysqli_error($conexionbanca));
$row_Recordset94 = mysqli_fetch_assoc($Recordset94);
$totalRows_Recordset94 = mysqli_num_rows($Recordset94);



$query_Recordset2 = "/* PARSEADORES1 admin\agencias_editx.php - QUERY 4 */ SELECT cod_banca, nom_banca FROM banca";
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$query_Recordset22 = sprintf(
  "/* PARSEADORES1 admin\agencias_editx.php - QUERY 5 */ SELECT * 
  	FROM  
	agencia,
	banca
  WHERE 
  agencia.cod_agencia=%s AND
  banca.cod_banca=agencia.cod_banca",
    GetSQLValueString($xCodigo, "int")
);
$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
$totalRows_Recordset22 = mysqli_num_rows($Recordset22);




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
                EDITAR AGENTE<br/>
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
			                   <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;"> <br />
                  SELECCIONE AQUI PARA ACTIVAR O DESACTIVAR ESTE AGENTE:<br /><br />








                    <select name="est_agencia" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['est_agencia'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['est_agencia'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
                  </select>

				  </td>
                </tr>
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	COSTO DEL SISTEMA
                  </td>
                 </tr> 
<tr valign="baseline">
                  <td width="450" height="41" align="center" valign="bottom" nowrap bgcolor="#999999">Estado Venta Internacionales:</td>
                  <td width="450" align="center" valign="bottom" nowrap>Estado Venta Nacionales:<br /></td>
                  <td align="center" valign="bottom" nowrap>&nbsp;</td>
                </tr>  
                 <tr valign="baseline">
				
                  <td width="120" height="88" align="center" valign="top" nowrap bgcolor="#999999">
				                      <select name="agen_vende_ame" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['agen_vende_ame']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['agen_vende_ame']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
						  </select>
						  					<br />Porcentaje Internacionales:<br />

                  	<input type="text" name="agen_por_ame" class="textbox" style="height:auto; width:50px" 
                    onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($row_Recordset1['agen_por_ame']/1, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                  	%


				 </td>
                  <td width="120" align="center" valign="top" nowrap>
				                      <select name="agen_vende_hnac" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['agen_vende_hnac']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['agen_vende_hnac']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
						  </select>
						    <br />Costo x pto Nacionales:<br/>
                  	<input type="text" name="agen_cob_hnac" class="textbox" style="height:auto; width:100px" 
                    onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($row_Recordset1['agen_cob_hnac']/1, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>

                  </td>
				  				    </tr>

                <tr valign="baseline">
                  <td colspan="5" align="right" nowrap bgcolor="#5EAEFF">&nbsp;                  </td>
                </tr>
              </table>
			  
			  <table width="919" align="center">

                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE AGENTE
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" valign="middle" nowrap><br>
                  	<div style="width:98.5%; text-align:left; padding:6px 0px 6px 8px; font-size:18px; background: #FFF">
                    Nombre de agente:
                  	<?php echo $row_Recordset1['nom_agencia']." | Distribuidor: ".$row_Recordset1['nom_banca']?>
                    </div>
                    <br>
                  </td>
                <tr valign="baseline">
                  <td align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="240" align="left" valign="middle" nowrap>
                  Nuevo nombre de agente:<br />
                    <input type="text" name="nom_agencia" id="nom_agencia" size="32" class="textbox"  
                    placeholder="usuario" pattern="[A-Z a-z0-9]{4,20}" maxlength="20" style="height: auto"
                    value="<?php echo htmlentities($row_Recordset1['nom_agencia'], ENT_COMPAT, 'utf-8'); ?>" 
                    tabindex="33" onKeyUp="return handleEnter(this, event)"/>
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
                    <?php echo $menNre; ?>
                  </td>
                  <td width="242" align="left">
                  Teléfono de agente:<br />
                  <input type="text" name="tel_taquilla" class="textbox" tabindex="3"
                  size="32"  maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_agencia'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02120000000" title="indique número de teléfono. 11 caracteres mín"
                  >
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td width="216" align="left">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="64" align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
					Dirección:
                  	<input type="text" name="direccion" class="textbox" placeholder="dirección" maxlength="30"
                    pattern="[A-Z a-z0-9]{0,10}" title="indique dirección. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34" 
                    value="<?php echo htmlentities($row_Recordset1['dir_agencia'], ENT_COMPAT, 'utf-8'); ?>" style="width:350px"
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menDir; ?></div>
                  </td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
              </table>

              
              <center>Cambiar de Distribuidor</center>
              <center><select name="cod_banca" style="width:327px; height: auto" class="textbox">
                    
                                            <option value="<?php echo $row_Recordset22['cod_banca']?>">
                                            <?php echo $row_Recordset22['nom_banca']?></option>
                                            
                                            <?php

                    do {
                        ?>
                        <option value="<?php echo $row_Recordset2['cod_banca']?>">
                        <?php echo $row_Recordset2['nom_banca']?></option>
                    <?php
                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                    ?>
                    </select>
                    </center>
          

            <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:14px">
              <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="font-size:24px; font-weight: bold; background:#5EAEFF; color:#FFFFFF; height:30px"> <br />
                    ACTIVAR ACCESO A CLAVES:<br /><br />
          <select name="sinoclaves" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset94['sinoclaves']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset94['sinoclaves']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>INACTIVO</option>
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
                  <a href='agencias_listas.php'
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
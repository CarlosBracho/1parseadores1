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
$menOpNac="";
$xCodigo = "-1";
$xCodigo2 = "-1";
    include("../includes/taquilla_estandar.php");


$editFormAction = $_SERVER['PHP_SELF'];
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction2 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
    $xCodigo2 = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 agente\taquillas_agregarsaldo.php - QUERY 1 */ SELECT
ta.taq_vende_ame,
ta.taq_por_ame,
ta.taq_vende_hnac,
ta.taq_cob_hnac,
ta.moneda, 
ta.tipo_pago,
ta.saldoactual, 
	ta.nom_taquilla, ta.nom_representante, ta.tel_taquilla, ta.tel_taquilla2, ta.tel_taquilla3, ta.est_taquilla, ta.cod_taquilla,
	ag.nom_agencia 
	FROM  taquilla ta, agencia ag 
	WHERE ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$saldoactualmas=$row_Recordset1['saldoactual']/1;
$moneda=$row_Recordset1['moneda']/1;

$est_taquilla=$row_Recordset1['est_taquilla']/1;
    $taq_vende_ame=$row_Recordset1['taq_vende_ame']/1;
    $taq_por_ame=$row_Recordset1['taq_por_ame']/1;
    $tipo_pago=$row_Recordset1['tipo_pago']/1;
    $taq_cob_hnac=$row_Recordset1['taq_cob_hnac']/1;
    
    
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 agente\taquillas_agregarsaldo.php - QUERY 2 */ SELECT * FROM usuario 
	WHERE tip_usuario='U' 
	AND usuario.cod_taquilla = %s
	ORDER BY usuario.nom_usuario ASC",
            GetSQLValueString($xCodigo, "int")
        );
$Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
$row_Recordset11 = mysqli_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysqli_num_rows($Recordset11);



    
$porcentaje=0;
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $graba=31;
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 agente\taquillas_agregarsaldo.php - QUERY 3 */ UPDATE taquilla 
				SET tipo_pago=%s, saldoactual=%s			
				WHERE cod_taquilla=%s",
            GetSQLValueString($_POST['tipo_pago'], "double"),
            GetSQLValueString($_POST['agregarsaldo']+$saldoactualmas, "int"),
            GetSQLValueString($_POST['cod_taquilla'], "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        
        
        
    
        $insertGoTo = "taquillas_lista.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 agente\taquillas_agregarsaldo.php - QUERY 4 */ SELECT ta.cod_taquilla, ta.nom_taquilla 
FROM taquilla ta, taquilla_opc_ame tp WHERE ta.cod_taquilla = tp.cod_taquilla AND ta.cod_taquilla != %s ORDER BY nom_taquilla",
    GetSQLValueString($xCodigo2, "int")
);
$Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
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
$(document).ready(function() {
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
 });
</script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana_ag.php");?>
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
                EDITAR TAQUILLA<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
    <div style="width:98%; float:right; text-align:right; padding:1.5% 2% 0 0; height:40px; font-size:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
        
    </div>
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              
			  
			  
			  <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:14px">
<tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;"> <br />
                  SELECCIONE AQUI PARA ACTIVAR O DESACTIVAR ESTA TAQUILLA:<br /><br />

                    <select name="est_taquilla" style="width:140px; height: auto" class="textbox" tabindex="4"> 
					                        <option value="1" <?php if (!(strcmp(1, htmlentities($est_taquilla, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($est_taquilla, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
                  </select>
				  </td>
                </tr>
				
				<tr>
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	TIPO DE PAGO
                  </td>
                </tr>  
                 <tr valign="baseline">
                  <td align="center" valign="bottom" nowrap>&nbsp;</td>
                </tr>  
                <tr valign="baseline" >

				                   <td width="120" align="center" valign="top" nowrap>
								                       <select name="tipo_pago" style="width:140px; height: auto" class="textbox" tabindex="4"> 

					  
					                        <option value="1" <?php if (!(strcmp(1, htmlentities($tipo_pago, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>PRE PAGO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($tipo_pago, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>POST PAGO</option>
						  
						  
						  
					</select>
					<br/>SALDO A AGREGAR:<br/>
                  	<input type="text" name="agregarsaldo" class="textbox" style="height:auto; width:100px" 
                    onclick="ocultaDiv('Info7');"
                    value="0" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                  	<br/><input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />     
					
                  </td>
					</tr>	  
						  </table>
			  
			  
			  
			  
			  
			  
			  <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:13px">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE TAQUILLA
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" valign="middle" nowrap><br>
                  	<div style="width:98.5%; text-align:left; padding:6px 0px 6px 8px; font-size:18px; background: #FFF">
                    Nombre de taquilla:
                  	<?php echo $row_Recordset1['nom_taquilla']." | Agente: ".$row_Recordset1['nom_agencia']?>
                    </div>
                    <br>
                  </td>
                <tr valign="baseline">
                  <td align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" valign="middle" nowrap>Nombre de representante:<br />
                  <input type="text" name="nom_representante" class="textbox" tabindex="2" placeholder="nombre completo"
                  value="<?php echo htmlentities($row_Recordset1['nom_representante'], ENT_COMPAT, 'utf-8'); ?>" 
                  size="32" title="indique un nombre de representante. 4-30 caracteres" onclick="ocultaDiv('Info2');"
                  style="width:95%"/>
                  <div id="Info2" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00;">
				  <?php echo $menNre; ?></div>
                  </td>

                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td width="240" align="left" nowrap>
                  Nro de contacto principal:<br />
                  <input type="text" name="tel_taquilla" class="textbox"  tabindex="3"
                  size="32"  maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td width="242" align="left" nowrap>Nro de contacto 1er auxiliar:<br/>
                  <input type="text" name="tel_taquilla2" class="textbox" tabindex="3"
                  size="32"  maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla2'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td align="left" nowrap>Nro de contacto 2do auxiliar:<br/>
                  <input type="text" name="tel_taquilla3" class="textbox" tabindex="3"
                  size="32"  maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla3'], ENT_COMPAT, 'utf-8'); ?>"  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>

                

              </table>
			  
			  
			  
              <table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">












                <tr valign="baseline">
                  <td height="48" align="right" nowrap>&nbsp;</td>
                  <td nowrap align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
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
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="20" colspan="11" align="center" valign="bottom" nowrap bgcolor="#5EAEFF">&nbsp;</td>
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
                  <a href='taquillas_lista.php'
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
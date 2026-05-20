<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}
if (isset($_GET["rA"])) {
    $tip = 0;
} else {
    $tip = 1;
}
$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\confirma_dividendos_edit.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", GetSQLValueString($xCarrera_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$fecha=$row_Recordset1['fec_carrera'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $_POST['est_carrera']=0;
    $_POST['eje_exa1']=$_POST['eje_exa1']/1;
    $_POST['eje_exa2']=$_POST['eje_exa2']/1;
    $ord_exacta=$_POST['eje_exa1']."/".$_POST['eje_exa2'];
    $_POST['eje_exad1']=$_POST['eje_exad1']/1;
    $_POST['eje_exad2']=$_POST['eje_exad2']/1;
    $ord_exacta_doble=$_POST['eje_exad1']."/".$_POST['eje_exad2'];
    $_POST['eje_exat1']=$_POST['eje_exat1']/1;
    $_POST['eje_exat2']=$_POST['eje_exat2']/1;
    $ord_exacta_triple=$_POST['eje_exat1']."/".$_POST['eje_exat2'];
    $_POST['eje_tri1']=$_POST['eje_tri1']/1;
    $_POST['eje_tri2']=$_POST['eje_tri2']/1;
    $_POST['eje_tri3']=$_POST['eje_tri3']/1;
    $ord_trifecta=$_POST['eje_tri1']."/".$_POST['eje_tri2']."/".$_POST['eje_tri3'];
    $_POST['eje_trid1']=$_POST['eje_trid1']/1;
    $_POST['eje_trid2']=$_POST['eje_trid2']/1;
    $_POST['eje_trid3']=$_POST['eje_trid3']/1;
    $ord_trifecta_doble=$_POST['eje_trid1']."/".$_POST['eje_trid2']."/".$_POST['eje_trid3'];
    $_POST['eje_trit1']=$_POST['eje_trit1']/1;
    $_POST['eje_trit2']=$_POST['eje_trit2']/1;
    $_POST['eje_trit3']=$_POST['eje_trit3']/1;
    $ord_trifecta_triple=$_POST['eje_trit1']."/".$_POST['eje_trit2']."/".$_POST['eje_trit3'];
    $_POST['eje_sup1']=$_POST['eje_sup1']/1;
    $_POST['eje_sup2']=$_POST['eje_sup2']/1;
    $_POST['eje_sup3']=$_POST['eje_sup3']/1;
    $_POST['eje_sup4']=$_POST['eje_sup4']/1;
    $ord_superfecta=$_POST['eje_sup1']."/".$_POST['eje_sup2']."/".$_POST['eje_sup3']."/".$_POST['eje_sup4'];
    $_POST['eje_supd1']=$_POST['eje_supd1']/1;
    $_POST['eje_supd2']=$_POST['eje_supd2']/1;
    $_POST['eje_supd3']=$_POST['eje_supd3']/1;
    $_POST['eje_supd4']=$_POST['eje_supd4']/1;
    $ord_superfecta_doble=$_POST['eje_supd1']."/".$_POST['eje_supd2']."/".$_POST['eje_supd3']."/".$_POST['eje_supd4'];
    $_POST['eje_supt1']=$_POST['eje_supt1']/1;
    $_POST['eje_supt2']=$_POST['eje_supt2']/1;
    $_POST['eje_supt3']=$_POST['eje_supt3']/1;
    $_POST['eje_supt4']=$_POST['eje_supt4']/1;
    $ord_superfecta_triple=$_POST['eje_supt1']."/".$_POST['eje_supt2']."/".$_POST['eje_supt3']."/".$_POST['eje_supt4'];
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\admin\confirma_dividendos_edit.php - QUERY 2 */ UPDATE carrera SET est_confirmacion=%s, est_carrera=%s, eje_primero=%s, div_primero_gan=%s, div_primero_pla=%s, div_primero_sho=%s, eje_segundo=%s, div_segundo_pla=%s, div_segundo_sho=%s, eje_tercero=%s, div_tercero_sho=%s, eje_doble_primero=%s, div_doble_primero_gan=%s, div_doble_primero_pla=%s, div_doble_primero_sho=%s, eje_doble_segundo=%s, div_doble_segundo_pla=%s, div_doble_segundo_sho=%s, eje_doble_tercero=%s, div_doble_tercero_sho=%s, eje_triple_primero=%s, div_triple_primero_gan=%s, div_triple_primero_pla=%s, div_triple_primero_sho=%s, eje_triple_segundo=%s, div_triple_segundo_pla=%s, div_triple_segundo_sho=%s, eje_triple_tercero=%s, div_triple_tercero_sho=%s, eje_cuarto=%s, eje_doble_cuarto=%s, eje_triple_cuarto=%s, div_exacta=%s, div_trifecta=%s, div_superfecta=%s, fac_exacta=%s, fac_trifecta=%s, fac_superfecta=%s,
							div_exacta_doble=%s,
							div_exacta_triple=%s,
							div_trifecta_doble=%s,
							div_trifecta_triple=%s,
							div_superfecta_doble=%s,
							div_superfecta_triple=%s,
							ord_exacta=%s,
							ord_exacta_doble=%s,
							ord_exacta_triple=%s,
							ord_trifecta=%s,
							ord_trifecta_doble=%s,
							ord_trifecta_triple=%s,
							ord_superfecta=%s,
							ord_superfecta_doble=%s,
							ord_superfecta_triple=%s
					WHERE cod_carrera=%s",
        GetSQLValueString($tip, "int"),
        GetSQLValueString($_POST['est_carrera'], "int"),
        GetSQLValueString($_POST['eje_primero'], "int"),
        GetSQLValueString($_POST['div_primero_gan'], "double"),
        GetSQLValueString($_POST['div_primero_pla'], "double"),
        GetSQLValueString($_POST['div_primero_sho'], "double"),
        GetSQLValueString($_POST['eje_segundo'], "int"),
        GetSQLValueString($_POST['div_segundo_pla'], "double"),
        GetSQLValueString($_POST['div_segundo_sho'], "double"),
        GetSQLValueString($_POST['eje_tercero'], "int"),
        GetSQLValueString($_POST['div_tercero_sho'], "double"),
        GetSQLValueString($_POST['eje_doble_primero'], "int"),
        GetSQLValueString($_POST['div_doble_primero_gan'], "double"),
        GetSQLValueString($_POST['div_doble_primero_pla'], "double"),
        GetSQLValueString($_POST['div_doble_primero_sho'], "double"),
        GetSQLValueString($_POST['eje_doble_segundo'], "int"),
        GetSQLValueString($_POST['div_doble_segundo_pla'], "double"),
        GetSQLValueString($_POST['div_doble_segundo_sho'], "double"),
        GetSQLValueString($_POST['eje_doble_tercero'], "int"),
        GetSQLValueString($_POST['div_doble_tercero_sho'], "double"),
        GetSQLValueString($_POST['eje_triple_primero'], "int"),
        GetSQLValueString($_POST['div_triple_primero_gan'], "double"),
        GetSQLValueString($_POST['div_triple_primero_pla'], "double"),
        GetSQLValueString($_POST['div_triple_primero_sho'], "double"),
        GetSQLValueString($_POST['eje_triple_segundo'], "int"),
        GetSQLValueString($_POST['div_triple_segundo_pla'], "double"),
        GetSQLValueString($_POST['div_triple_segundo_sho'], "double"),
        GetSQLValueString($_POST['eje_triple_tercero'], "int"),
        GetSQLValueString($_POST['div_triple_tercero_sho'], "double"),
        GetSQLValueString($_POST['eje_cuarto'], "int"),
        GetSQLValueString($_POST['eje_doble_cuarto'], "int"),
        GetSQLValueString($_POST['eje_triple_cuarto'], "int"),
        GetSQLValueString($_POST['div_exacta'], "double"),
        GetSQLValueString($_POST['div_trifecta'], "double"),
        GetSQLValueString($_POST['div_superfecta'], "double"),
        GetSQLValueString($_POST['fac_exacta'], "double"),
        GetSQLValueString($_POST['fac_trifecta'], "double"),
        GetSQLValueString($_POST['fac_superfecta'], "double"),
        GetSQLValueString($_POST['div_exacta_doble'], "double"),
        GetSQLValueString($_POST['div_exacta_triple'], "double"),
        GetSQLValueString($_POST['div_trifecta_doble'], "double"),
        GetSQLValueString($_POST['div_trifecta_triple'], "double"),
        GetSQLValueString($_POST['div_superfecta_doble'], "double"),
        GetSQLValueString($_POST['div_superfecta_triple'], "double"),
        GetSQLValueString($ord_exacta, "text"),
        GetSQLValueString($ord_exacta_doble, "text"),
        GetSQLValueString($ord_exacta_triple, "text"),
        GetSQLValueString($ord_trifecta, "text"),
        GetSQLValueString($ord_trifecta_doble, "text"),
        GetSQLValueString($ord_trifecta_triple, "text"),
        GetSQLValueString($ord_superfecta, "text"),
        GetSQLValueString($ord_superfecta_doble, "text"),
        GetSQLValueString($ord_superfecta_triple, "text"),
        GetSQLValueString($_POST['cod_carrera'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    $cod_carrera=$_POST['cod_carrera'];
    $tipoProceso=2;
    if (is_file('../includes/procesar_resultados_tickets_ame.php')) {
        include("../includes/procesar_resultados_tickets_ame.php");
    }
    echo "<h4><font color='#027BAD'>Cálculo culminado! ".$carrera."</font></h4>";
    $updateGoTo = "busca_dividendos.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
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
<script src="../js/jquery-1.9.1.min.js"></script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container1">
	<div class="contentAdmin">
		<div style="height:100%; padding:0px 0px 0px 0px; text-align:left">
      <table width="100%" border="0" height="50" align="center" style="background: #666; color:#FFFFFF; font-size:14px;">
        <tr>
          <td colspan="2"><?php  echo $row_Recordset1['nom_hipodromo']." Carr: ...".$row_Recordset1['num_carrera']; ?>            
		  <?php  echo " - Fecha de cierre: ".fechanueva($row_Recordset1['fec_carrera']);?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="380"></td>
          <td width="524"></td>
        </tr>
 </table>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline" height="40">
            <td width="61" align="right" nowrap="nowrap">&nbsp;</td>
            <td colspan="4" align="center" valign="bottom" bgcolor="#3399CC" style="color:#FFF;font-size:20px">Carrera Simple</td>
            <td colspan="2" valign="bottom">&nbsp;</td>
            <td colspan="4" align="center" valign="bottom" bgcolor="#009999" style="color:#FFF;font-size:20px">
            Carrera Doble Empate</td>
            <td width="70" valign="bottom">&nbsp;</td>
            <td colspan="4" align="center" valign="bottom" bgcolor="#3399FF" style="color:#FFF;font-size:20px">
            Carrera Triple Empate</td>
          </tr>
          <tr valign="baseline">
            <td width="61" align="right" nowrap="nowrap">&nbsp;</td>
            <td width="60" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">GAN</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">PLA</td>
            <td width="54" align="center" bgcolor="#333" style="color:#FFF">SHW</td>
            <td colspan="2">&nbsp;</td>
            <td width="66" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">GAN</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">PLA</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">SHW</td>
            <td width="70">&nbsp;</td>
            <td width="60" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">GAN</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">PLA</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">SHW</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">1er Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
                <span id="sprytextfield1">
                    <input name="eje_primero" type="text" id="sprytrigger1" 
                    value="<?php echo htmlentities($row_Recordset1['eje_primero'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:30px; font-size:18px" maxlength="2" />
                    <span class="textfieldMaxCharsMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <span id="sprytextfield4">
                    <input name="div_primero_gan" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_primero_gan'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:18px" size="2" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <span id="sprytextfield5">
                    <input type="text" name="div_primero_pla" 
                    value="<?php echo htmlentities($row_Recordset1['div_primero_pla'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:18px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <span id="sprytextfield7">
                    <input type="text" name="div_primero_sho" 
                    value="<?php echo htmlentities($row_Recordset1['div_primero_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:18px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="eje_doble_primero" type="text" 
                value="<?php echo htmlentities($row_Recordset1['eje_doble_primero'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_doble_primero_gan" 
                value="<?php echo htmlentities($row_Recordset1['div_doble_primero_gan'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_doble_primero_pla" 
                value="<?php echo htmlentities($row_Recordset1['div_doble_primero_pla'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_doble_primero_sho" 
                value="<?php echo htmlentities($row_Recordset1['div_doble_primero_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="eje_triple_primero" type="text" 
                value="<?php echo htmlentities($row_Recordset1['eje_triple_primero'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_triple_primero_gan" 
                value="<?php echo htmlentities($row_Recordset1['div_triple_primero_gan'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_triple_primero_pla" 
                value="<?php echo htmlentities($row_Recordset1['div_triple_primero_pla'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_triple_primero_sho" 
                value="<?php echo htmlentities($row_Recordset1['div_triple_primero_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">2do Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
                <span id="sprytextfield2">
                    <input name="eje_segundo" type="text" id="sprytrigger2" 
                    value="<?php echo htmlentities($row_Recordset1['eje_segundo'], ENT_COMPAT, 'utf-8'); ?>"
                    style="width:30px; font-size:18px" maxlength="2" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldMaxCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <span id="sprytextfield6">
                    <input type="text" name="div_segundo_pla" 
                    value="<?php echo htmlentities($row_Recordset1['div_segundo_pla'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:18px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <span id="sprytextfield8">
                    <input type="text" name="div_segundo_sho" 
                    value="<?php echo htmlentities($row_Recordset1['div_segundo_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:18px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="eje_doble_segundo" type="text" 
                value="<?php echo htmlentities($row_Recordset1['eje_doble_segundo'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_doble_segundo_pla" 
                value="<?php echo htmlentities($row_Recordset1['div_doble_segundo_pla'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_doble_segundo_sho" 
                value="<?php echo htmlentities($row_Recordset1['div_doble_segundo_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="eje_triple_segundo" type="text" 
                value="<?php echo htmlentities($row_Recordset1['eje_triple_segundo'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_triple_segundo_pla" 
                value="<?php echo htmlentities($row_Recordset1['div_triple_segundo_pla'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_triple_segundo_sho" 
                value="<?php echo htmlentities($row_Recordset1['div_triple_segundo_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">3er Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
            	<span id="sprytextfield3">
                    <input name="eje_tercero" type="text" id="sprytrigger3" 
                    value="<?php echo htmlentities($row_Recordset1['eje_tercero'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:30px; font-size:18px" maxlength="2" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldMaxCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
            	<span id="sprytextfield9">
                    <input type="text" name="div_tercero_sho" 
                    value="<?php echo htmlentities($row_Recordset1['div_tercero_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:18px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
				</span>
            </td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
            	<input name="eje_doble_tercero" type="text" 
                value="<?php echo htmlentities($row_Recordset1['eje_doble_tercero'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_doble_tercero_sho" 
                value="<?php echo htmlentities($row_Recordset1['div_doble_tercero_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="eje_triple_tercero" type="text" 
                value="<?php echo htmlentities($row_Recordset1['eje_triple_tercero'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="div_triple_tercero_sho" 
                value="<?php echo htmlentities($row_Recordset1['div_triple_tercero_sho'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:50px; font-size:18px" />
            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">4to Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
                    <input name="eje_cuarto" type="text" id="sprytrigger4" 
                    value="<?php echo htmlentities($row_Recordset1['eje_cuarto'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:30px; font-size:18px" maxlength="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="eje_doble_cuarto" type="text" 
                value="<?php echo htmlentities($row_Recordset1['eje_doble_cuarto'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="eje_triple_cuarto" type="text" 
                value="<?php echo htmlentities($row_Recordset1['eje_triple_cuarto'], ENT_COMPAT, 'utf-8'); ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td height="42" colspan="16" align="right" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr valign="baseline"  style="color:#FFF;">
            <td height="20" align="right" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td height="20" align="center" nowrap="nowrap" bgcolor="#3399CC">Div</td>
            <td height="20" align="center" nowrap="nowrap" bgcolor="#3399CC">Factor</td>
            <td height="20" colspan="2" align="center" nowrap="nowrap" bgcolor="#3399CC">Llegada</td>
            <td width="5" height="20" align="right" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="20" height="20" align="right" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td height="20" align="center" nowrap="nowrap" bgcolor="#009999">Div</td>
            <td height="20" colspan="2" align="center" nowrap="nowrap" bgcolor="#009999">LLegada</td>
            <td height="20" align="right" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td height="20" align="right" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td height="20" align="center" nowrap="nowrap" bgcolor="#3399FF">Div</td>
            <td height="20" colspan="2" align="center" nowrap="nowrap" bgcolor="#3399FF">Llegada</td>
            <td height="20" align="right" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td align="left" nowrap="nowrap" bgcolor="#FFFFCC">Exacta:</td>
            <td align="left" nowrap="nowrap" bgcolor="#CCCCCC">
                <span id="sprytextfield11">
                    <input name="div_exacta" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_exacta'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:14px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">
                <span id="sprytextfield14">
                    <input name="fac_exacta" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['fac_exacta'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:18px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC">-
                <input name="eje_exa1" type="text" 
                value="<?php if (isset($eje_exactaS[0])) {
    echo htmlentities($eje_exactaS[0], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_exa2" type="text" 
                value="<?php if (isset($eje_exactaS[1])) {
    echo htmlentities($eje_exactaS[1], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">
                    <input name="div_exacta_doble" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_exacta_doble'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:14px" />
            </td>
            <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC">-
                <input name="eje_exad1" type="text" 
                value="<?php if (isset($eje_exactaD[0])) {
    echo htmlentities($eje_exactaD[0], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_exad2" type="text" 
                value="<?php if (isset($eje_exactaD[1])) {
    echo htmlentities($eje_exactaD[1], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">
                    <input name="div_exacta_triple" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_exacta_triple'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:14px" />
            </td>
            <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC">-
                <input name="eje_exat1" type="text" 
                value="<?php if (isset($eje_exactaT[0])) {
    echo htmlentities($eje_exactaT[0], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_exat2" type="text" 
                value="<?php if (isset($eje_exactaT[1])) {
    echo htmlentities($eje_exactaT[1], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td align="left" nowrap="nowrap" bgcolor="#FFFFCC">Trifecta:</td>
            <td align="left" nowrap="nowrap" bgcolor="#CCCCCC">
                <span id="sprytextfield12">
                    <input name="div_trifecta" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_trifecta'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:14px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">
                <span id="sprytextfield15">
                    <input name="fac_trifecta" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['fac_trifecta'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:18px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC">-
                <input name="eje_tri1" type="text" 
                value="<?php if (isset($eje_trifecS[0])) {
    echo htmlentities($eje_trifecS[0], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_tri2" type="text" 
                value="<?php if (isset($eje_trifecS[1])) {
    echo htmlentities($eje_trifecS[1], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_tri3" type="text" 
                value="<?php if (isset($eje_trifecS[2])) {
    echo htmlentities($eje_trifecS[2], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">
                    <input name="div_trifecta_doble" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_trifecta_doble'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:14px" />
            </td>

            <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC">-
                <input name="eje_trid1" type="text" 
                value="<?php if (isset($eje_trifecD[0])) {
    echo htmlentities($eje_trifecD[0], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_trid2" type="text" 
                value="<?php if (isset($eje_trifecD[1])) {
    echo htmlentities($eje_trifecD[1], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_trid3" type="text" 
                value="<?php if (isset($eje_trifecD[2])) {
    echo htmlentities($eje_trifecD[2], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">
                    <input name="div_trifecta_triple" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_trifecta_triple'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:14px" />
            </td>
            <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC">-
                <input name="eje_trit1" type="text" 
                value="<?php if (isset($eje_trifecT[0])) {
    echo htmlentities($eje_trifecT[0], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_trit2" type="text" 
                value="<?php if (isset($eje_trifecT[1])) {
    echo htmlentities($eje_trifecT[1], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_trit3" type="text" 
                value="<?php if (isset($eje_trifecT[2])) {
    echo htmlentities($eje_trifecT[2], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td align="left" nowrap="nowrap" bgcolor="#FFFFCC">Superfecta
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#CCCCCC">
                <span id="sprytextfield13">
                    <input name="div_superfecta" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_superfecta'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:14px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">
                <span id="sprytextfield16">
                    <input name="fac_superfecta" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['fac_superfecta'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:18px" />
                    <span class="textfieldRequiredMsg"></span>
                    <span class="textfieldMinCharsMsg"></span>
                    <span class="textfieldInvalidFormatMsg"></span>
                    <span class="textfieldMinValueMsg"></span>
                </span>
            </td>
            <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC">-
                <input name="eje_sup1" type="text" 
                value="<?php if (isset($eje_superfS[0])) {
    echo htmlentities($eje_superfS[0], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_sup2" type="text" 
                value="<?php if (isset($eje_superfS[1])) {
    echo htmlentities($eje_superfS[1], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_sup3" type="text" 
                value="<?php if (isset($eje_superfS[2])) {
    echo htmlentities($eje_superfS[2], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_sup4" type="text" 
                value="<?php if (isset($eje_superfS[3])) {
    echo htmlentities($eje_superfS[3], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">
              		<input name="div_superfecta_doble" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_superfecta_doble'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:14px" />
            </td>
            <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC">-
                <input name="eje_supd1" type="text" 
                value="<?php if (isset($eje_superfD[0])) {
    echo htmlentities($eje_superfD[0], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_supd2" type="text" 
                value="<?php if (isset($eje_superfD[1])) {
    echo htmlentities($eje_superfD[1], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_supd3" type="text" 
                value="<?php if (isset($eje_superfD[2])) {
    echo htmlentities($eje_superfD[2], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_supd4" type="text" 
                value="<?php if (isset($eje_superfD[3])) {
    echo htmlentities($eje_superfD[3], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="right" nowrap="nowrap" bgcolor="#CCCCCC">
                    <input name="div_superfecta_triple" type="text" 
                    value="<?php echo htmlentities($row_Recordset1['div_superfecta_triple'], ENT_COMPAT, 'utf-8'); ?>" 
                    style="width:50px; font-size:14px" />
            </td>
            <td colspan="2" align="left" nowrap="nowrap" bgcolor="#CCCCCC">-
                <input name="eje_supt1" type="text" 
                value="<?php if (isset($eje_superfT[0])) {
    echo htmlentities($eje_superfT[0], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_supt2" type="text" 
                value="<?php if (isset($eje_superfT[1])) {
    echo htmlentities($eje_superfT[1], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_supt3" type="text" 
                value="<?php if (isset($eje_superfT[2])) {
    echo htmlentities($eje_superfT[2], ENT_COMPAT, 'utf-8');
} ?>" 
                style="width:20px; font-size:16px" maxlength="2" />
                <input name="eje_supt4" type="text" 
                value="<?php if (isset($eje_superfT[3])) {
    echo htmlentities($eje_superfT[3], ENT_COMPAT, 'utf-8');
} ?>" 
				style="width:20px; font-size:16px" maxlength="2" />
            </td>
            <td align="left" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="15"><p>&nbsp;</p>
            <p>&nbsp;</p></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="15" align="center"> 
            	<input type="submit" value="Guardar y confirmar" class="btn-success" 
                	style="width:180px; height:40px; font-size:16px; margin:0px 20px 0px 0px"/>
            <a href="busca_dividendos.php" class="btn btn-warning" 
            	style="width:100px; height:25px; font-size:16px; text-decoration:none; padding:11px 0px 0px 0px">Volver</a></td>
          </tr>
        </table>
        <input type="hidden" name="est_carrera" value="<?php echo htmlentities($row_Recordset1['est_carrera'], ENT_COMPAT, 'utf-8'); ?>" />
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="cod_carrera" value="<?php echo $row_Recordset1['cod_carrera']; ?>" />
      </form>
      <p>&nbsp;</p>
    </blockquote>
    <div class="tooltipContent" id="sprytooltip3">Número del ejemplar tercer lugar</div>
    <div class="tooltipContent" id="sprytooltip2">Número del ejemplar segundo lugar</div>
    <div class="tooltipContent" id="sprytooltip1">Número del ejemplar primer lugar</div>
    <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {isRequired:false, minChars:1, maxChars:2, minValue:1});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {minChars:1, maxChars:2, minValue:1});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {minChars:1, maxChars:2, minValue:1});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "real", {minValue:0});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "real", {minValue:0});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "real", {minValue:0});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "real", {minValue:0});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "real", {minValue:0});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "real", {minValue:0});
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12", "real", {minValue:0});
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13", "real", {minValue:0});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield14", "real", {minValue:0});
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield15", "real", {minValue:0});
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield16", "real", {minValue:0});
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1");
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger2");
var sprytooltip3 = new Spry.Widget.Tooltip("sprytooltip3", "#sprytrigger3");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {isRequired:false, minChars:1, maxChars:2, minValue:1});
    </script>
    </div>
  </div>
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
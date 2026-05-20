<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$idUsuario=$_SESSION['MM_id_usuario'];

$query_Recordset4 =  sprintf(
    "/* PARSEADORES1 new\parley\ver_opciones_parley.php - QUERY 1 */ SELECT  
	*
	FROM 
		usuario us, taquilla ta, taquilla_opc_parley tp 
	WHERE 
		us.id_usuario = %s AND
		us.cod_taquilla = ta.cod_taquilla AND
		tp.cod_taquilla = ta.cod_taquilla
	LIMIT 1",
    GetSQLValueString($idUsuario, "int")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
    
    $apu_minparley=$row_Recordset4['apu_minparley'];
    $apu_maxparley=$row_Recordset4['apu_maxparley'];
    $comb_minparley=$row_Recordset4['comb_minparley'];
    $comb_maxparley=$row_Recordset4['comb_maxparley'];
    $comb_hembra=$row_Recordset4['comb_hembra'];
    $min_eliminar=$row_Recordset4['min_eliminar'];
    $monto_apuesta=$row_Recordset4['monto_apuesta'];
    $factor_pago=$row_Recordset4['factor_pago'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<style>
body {
	background-color: #333;
	padding:0;
	margin:0 auto;
}
.textboxsmal {
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
	  width:50px;
	  height:10px;
}
.textboxsmal:focus {
	  color: #2E3133;
	  border-color: #FBFFAD;
}
 </style>

</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<div style="background: #333333; width:100%; float:left; padding:50px 2px 2px 2px;
		color:#FFF; font-size:28px; text-align:center">
		OPCIONES DE TAQUILLA PARLEY
	</div><!-- end .container -->
	<div style="background: #FFF; width:100%; float:left; font-size:18px">
  <table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">

<tr valign="baseline">
  
  <td nowrap align="left" bgcolor="#D8D8D8">JUGADA MINIMA:</td>
  <td>
    <input type="text" class="textboxsmal" style="height:auto; width:100px" disabled="disabled"
    value="<?php echo htmlentities($apu_minparley, ENT_COMPAT, 'utf-8'); ?>"/>
  </td>
  <td nowrap align="left" bgcolor="#D8D8D8">JUGADA MAXIMA:</td>
  <td>
      <input type="text" name="apu_maxparley" class="textboxsmal" style="height:auto; width:140px" disabled="disabled"
      value="<?php echo htmlentities($apu_maxparley, ENT_COMPAT, 'utf-8'); ?>"/>
    
  </td>
  
  <tr>
  </tr>
  <td nowrap align="left" bgcolor="#D8D8D8">COMBINACION MINIMA:</td>
  <td>
      <input type="text" name="comb_minparley" class="textboxsmal" style="height:auto; width:100px" disabled="disabled"
      value="<?php echo htmlentities($comb_minparley, ENT_COMPAT, 'utf-8'); ?>" 
      size="10" onkeypress="ValidaSoloNumeros()" title="comb_minparley"/>
    
  </td>
  <td nowrap align="left" bgcolor="#D8D8D8">COMBINACION MAXIMA:</td>
  <td>
      <input type="text" name="comb_maxparley" class="textboxsmal" style="height:auto; width:140px" disabled="disabled"
      value="<?php echo htmlentities($comb_maxparley, ENT_COMPAT, 'utf-8'); ?>" 
      size="10" onkeypress="ValidaSoloNumeros()" title="comb_maxparley"/>
    
  </td>

  
 </tr>
 <tr valign="baseline">

  <td nowrap align="left" bgcolor="#D8D8D8">COMBINACION MAXIMA HEMBRAS:</td>
  <td>
    <input type="text" name="comb_hembra" class="textboxsmal" style="height:auto; width:100px" disabled="disabled"
    value="<?php echo htmlentities($comb_hembra, ENT_COMPAT, 'utf-8'); ?>"/>
    
  </td>

 <td nowrap align="left" bgcolor="#D8D8D8">Monto maximo a pagar por ticket:</td>
  <td>
      <input type="text" name="monto_apuesta" class="textboxsmal" style="height:auto; width:140px" disabled="disabled"
      value="<?php echo htmlentities($monto_apuesta, ENT_COMPAT, 'utf-8'); ?>" 
      size="10" onkeypress="ValidaSoloNumeros()" title="monto_apuesta"/>
    
  </td>
  </tr>


  <tr valign="baseline">
  <td nowrap align="left" bgcolor="#D8D8D8">LIMITE DE MINUTOS PARA PODER<br> <br>ELIMINAR UNA APUESTA:</td>
  <td>
    <input type="text" name="min_eliminar" class="textboxsmal" style="height:auto; width:100px" disabled="disabled"
    value="<?php echo htmlentities($min_eliminar, ENT_COMPAT, 'utf-8'); ?>"/>
    
  </td>

 <td nowrap align="left" bgcolor="#D8D8D8">Maximo a multiplicar por apuestas:</td>
  <td>
      <input type="text" name="factor_pago" class="textboxsmal" style="height:auto; width:140px" disabled="disabled"
      value="<?php echo htmlentities($factor_pago, ENT_COMPAT, 'utf-8'); ?>" 
      size="10" onkeypress="ValidaSoloNumeros()" title="factor_pago"/>
    
  </td>
  

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
</div>  
</body>
</html>
<?php
mysqli_free_result($Recordset4);
?>
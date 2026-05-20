<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$idUsuario=$_SESSION['MM_id_usuario'];

$query_Recordset4 =  sprintf(
    "/* PARSEADORES1 ventas\ventas_ver_opciones_ame.php - QUERY 1 */ SELECT  
	tp.pag_codigo, tp.apu_maxgan, tp.apu_maxpla, tp.apu_maxsho, tp.apu_maxexa, tp.apu_maxtri, tp.apu_maxsup,
	tp.apu_mingan, tp.apu_minpla, tp.apu_minsho, tp.apu_minexa, tp.apu_mintri, tp.apu_minsup, tp.reg_gan, tp.reg_pla,
	tp.reg_sho, tp.reg_exa, tp.reg_tri, tp.reg_sup, tp.est_gan, tp.est_pla, tp.est_sho, tp.est_exa, tp.est_tri, 
	tp.est_sup, tp.max_aganar_gan, tp.max_aganar_pla, tp.max_aganar_sho, tp.max_aganar_exa, tp.max_aganar_tri, 
	tp.max_aganar_sup, tp.mon_maxticket, tp.mon_maxejemplar, tp.min_ejecarrera, tp.cod_taopcame, tp.por_taquilla,
	tp.est_impresion, tp.anu_regalia, tp.tic_caduca, tp.tip_ticket, tp.tie_reclamo, tp.ver_porpagar, tp.est_venta_ame,
	ta.vid_ame_ta, ta.cob_video_ame_ta, ta.vid_hnac_ta, ta.cob_video_hnac_ta
	FROM 
		usuario us, taquilla ta, taquilla_opc_ame tp 
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
$apu_mingan=$row_Recordset4['apu_mingan'];
$apu_maxgan=$row_Recordset4['apu_maxgan'];
$reg_gan=$row_Recordset4['reg_gan'];
$max_aganar_gan=$row_Recordset4['max_aganar_gan'];
$est_gan=$row_Recordset4['est_gan'];
$est_pla=$row_Recordset4['est_pla'];
$est_sho=$row_Recordset4['est_sho'];
$anu_regalia=$row_Recordset4['anu_regalia'];
$ver_porpagar=$row_Recordset4['ver_porpagar'];
$tie_reclamo=$row_Recordset4['tie_reclamo'];
$tic_caduca=$row_Recordset4['tic_caduca'];
$mon_maxejemplar=$row_Recordset4['mon_maxejemplar'];
$tip_ticket=$row_Recordset4['tip_ticket'];
$min_ejecarrera=$row_Recordset4['min_ejecarrera'];
$pag_codigo=$row_Recordset4['pag_codigo'];
$est_impresion=$row_Recordset4['est_impresion'];
$mon_maxticket=$row_Recordset4['mon_maxticket'];
$apu_minpla=$row_Recordset4['apu_minpla'];
$apu_maxpla=$row_Recordset4['apu_maxpla'];
$reg_pla=$row_Recordset4['reg_pla'];
$max_aganar_pla=$row_Recordset4['max_aganar_pla'];
$apu_minsho=$row_Recordset4['apu_minsho'];
$apu_maxsho=$row_Recordset4['apu_maxsho'];
$reg_sho=$row_Recordset4['reg_sho'];
$max_aganar_sho=$row_Recordset4['max_aganar_sho'];
$apu_minexa=$row_Recordset4['apu_minexa'];
$apu_maxexa=$row_Recordset4['apu_maxexa'];
$reg_exa=$row_Recordset4['reg_exa'];
$max_aganar_exa=$row_Recordset4['max_aganar_exa'];
$est_exa=$row_Recordset4['est_exa'];
$apu_mintri=$row_Recordset4['apu_mintri'];
$apu_maxtri=$row_Recordset4['apu_maxtri'];
$reg_tri=$row_Recordset4['reg_tri'];
$max_aganar_tri=$row_Recordset4['max_aganar_tri'];
$est_tri=$row_Recordset4['est_tri'];
$apu_minsup=$row_Recordset4['apu_minsup'];
$apu_maxsup=$row_Recordset4['apu_maxsup'];
$reg_sup=$row_Recordset4['reg_sup'];
$max_aganar_sup=$row_Recordset4['max_aganar_sup'];
$est_sup=$row_Recordset4['est_sup'];
$est_venta_ame=$row_Recordset4['est_venta_ame'];;
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
		OPCIONES DE TAQUILLA
	</div><!-- end .container -->
	<div style="background: #FFF; width:100%; float:left; font-size:18px">
        <table width="920" align="center" border="0"  style="line-height:12px" cellpadding="0" cellspacing="0">
          <tr valign="baseline" style="font-size:10px">
            <td width="1" height="29" align="left" nowrap>&nbsp;</td>
            <td width="129" align="center" nowrap valign="bottom">&nbsp;</td>
            <td width="56" align="center" valign="bottom">APUESTA MÍNIMA<br/></td>
            <td width="76" align="center" valign="bottom">APUESTA MÁXIMA</td>
            <td width="56" align="center" valign="bottom">RAGALIA</td>
            <td width="56" align="center" valign="bottom">MAXIMO A PAGAR</td>
            <td width="56" align="center" valign="bottom">ACEPTAR JUGADA</td>
            <td width="96" align="center" valign="bottom">
            ANULAR REGALIA<span style="font-size:9px"> Div Menor o igual:</span></td>
            <td width="148" align="center" valign="bottom">VER ANULADOS<br/>
            POR PAGAR</td>
            <td colspan="2" align="center" valign="bottom" style="font-size:10px">MONTO MAXIMO<br/>EN TICKET:</td>
          </tr>
          <tr valign="baseline">
            <td height="65" align="left" valign="middle" nowrap bgcolor="#D8D8D8">&nbsp;</td>
            <td align="left" valign="middle" nowrap bgcolor="#D8D8D8">GANADOR:</td>
            <td valign="middle" bgcolor="#D8D8D8">
              <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
              value="<?php echo htmlentities($apu_mingan, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle" bgcolor="#D8D8D8">
                <input type="text" class="textboxsmal" style="height:15px; width:70px" disabled="disabled"
                value="<?php echo htmlentities($apu_maxgan, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle" bgcolor="#D8D8D8">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($reg_gan, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle" bgcolor="#D8D8D8">
              <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
              value="<?php echo htmlentities($max_aganar_gan, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td align="center" valign="middle" bgcolor="#D8D8D8">
              <input type="checkbox" class="textboxsmal" style="height:15px;" disabled="disabled"
              value=""  <?php if (!(strcmp(htmlentities($est_gan, ENT_COMPAT, 'utf-8'), "1"))) {
    echo "checked=\"checked\"";
} ?> />
            </td>
            <td align="center" valign="top" bgcolor="#D8D8D8" style="font-size:12px">
              <input type="text" class="textboxsmal" style="height:15px; width:40px" disabled="disabled"
              value="<?php echo htmlentities($anu_regalia, ENT_COMPAT, 'utf-8'); ?>"/>                  
            </td>
            <td align="center" valign="top" bgcolor="#D8D8D8" style="font-size:12px">
              <select style="width:auto; height: 45px" class="textbox" disabled="disabled"> 
                <option value="1" <?php if (!(strcmp(1, htmlentities($ver_porpagar, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>SI</option>
                <option value="0" <?php if (!(strcmp(0, htmlentities($ver_porpagar, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>NO</option>
              </select>                  
            </td>
            <td colspan="2"  align="center" valign="top" bgcolor="#D8D8D8" style="font-size:12px">
              <input type="text" class="textboxsmal" style="height:15px; width:90px" disabled="disabled"
              value="<?php echo htmlentities($mon_maxticket, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
          </tr>
          <tr valign="baseline">
            <td height="65" align="left" valign="middle" nowrap>&nbsp;</td>
            <td align="left" valign="middle" nowrap>PLACE:</td>
            <td valign="middle">
              <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
              value="<?php echo htmlentities($apu_minpla, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle">
              <input type="text" class="textboxsmal" style="height:15px; width:70px" disabled="disabled"
              value="<?php echo htmlentities($apu_maxpla, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle">
              <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
              value="<?php echo htmlentities($reg_pla, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle">
              <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
              value="<?php echo htmlentities($max_aganar_pla, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td align="center" valign="middle">
              <input type="checkbox" class="textboxsmal" disabled="disabled"
              value=""  <?php if (!(strcmp(htmlentities($est_pla, ENT_COMPAT, 'utf-8'), "1"))) {
    echo "checked=\"checked\"";
} ?> />
            </td>
            <td colspan="2" align="center" valign="bottom" style="font-size: 10px">
				TIEMPO RECLAMO<br/>CODIGO TICKET:<br/>
				<select name="tie_reclamo" style="width: 68px; height: auto" class="textbox" disabled="disabled">
                    <?php for ($i = 0; $i <= 180; $i+= 15) {?>
                      <option value="<?php echo $i; ?>" <?php
                          if (!(strcmp($i, htmlentities($tie_reclamo, ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                          } ?>><?php echo $i; ?>
                    </option><?php  }?>
				</select>min            </td>
            <td width="116" align="center" valign="top" style="font-size:12px">Ticket Caduca:
                 <select style="width: auto; height: auto" class="textbox" disabled="disabled">
                    <?php for ($i = 0; $i <= 30; $i++) {?>
                      <option value="<?php echo $i; ?>" <?php
                          if (!(strcmp($i, htmlentities($tic_caduca, ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                          } ?>><?php echo $i; ?>
                    </option><?php  }?>
              </select>
                 días                      
            </td>
            <td width="82" align="left" valign="middle" style="font-size:10px; color:#900">(0) no caduca</td>
          </tr>
          <tr valign="baseline">
            <td height="65" align="left" nowrap bgcolor="#D8D8D8">&nbsp;</td>
            <td align="left" valign="middle" nowrap bgcolor="#D8D8D8">SHOW:</td>
            <td valign="middle" bgcolor="#D8D8D8">
              <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
              value="<?php echo htmlentities($apu_minsho, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle" bgcolor="#D8D8D8">
              <input type="text" class="textboxsmal" style="height:15px;; width:70px" disabled="disabled"
              value="<?php echo htmlentities($apu_maxsho, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle" bgcolor="#D8D8D8">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($reg_sho, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle" bgcolor="#D8D8D8">
              <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
              value="<?php echo htmlentities($max_aganar_sho, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td align="center" valign="middle" bgcolor="#D8D8D8">
              <input type="checkbox" class="textboxsmal" style="height:15px;" disabled="disabled"
              value=""  <?php if (!(strcmp(htmlentities($est_sho, ENT_COMPAT, 'utf-8'), "1"))) {
                              echo "checked=\"checked\"";
                          } ?> />
            </td>
            <td colspan="2" valign="top" bgcolor="#D8D8D8" style="font-size:10px">&nbsp;</td>
            <td colspan="2" align="center" valign="top" bgcolor="#D8D8D8" style="font-size:12px">Monto máximo por ejemplar:
              <input type="text" class="textboxsmal" style="height:15px; width:90px" disabled="disabled"
                value="<?php echo htmlentities($mon_maxejemplar, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
          </tr>
          <tr valign="baseline">
            <td height="65" align="left" nowrap>&nbsp;</td>
            <td align="left" valign="middle" nowrap>EXACTA: </td>
            <td valign="middle">
              <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
              value="<?php echo htmlentities($apu_minexa, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle">
              <input type="text" class="textboxsmal" style="height:15px; width:70px" disabled="disabled"
              value="<?php echo htmlentities($apu_maxexa, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($reg_exa, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($max_aganar_exa, ENT_COMPAT, 'utf-8'); ?>" 
                size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"/>
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" class="textboxsmal" disabled="disabled"
                value=""  <?php if (!(strcmp(htmlentities($est_exa, ENT_COMPAT, 'utf-8'), "1"))) {
                              echo "checked=\"checked\"";
                          } ?> />
            </td>
            <td colspan="2" align="center" valign="top" style="font-size:12px; color: #F00">
                  Forma de pagar apuesta y<br/>eliminar ticket:<br/>
                  <select style="width:auto; height: auto" class="textbox" disabled="disabled"> 
                    <option value="0" <?php if (!(strcmp(0, htmlentities($pag_codigo, ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                          } ?>>CON CÓDIGO</option>
                    <option value="1" <?php if (!(strcmp(1, htmlentities($pag_codigo, ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                          } ?>>SIN CÓDIGO</option>
                  </select>
			</td>
            <td colspan="2" align="center" valign="top" style="font-size:12px">Tipo de ticket:<br/>
              <select style="width:59px; height: 39px" class="textbox" disabled="disabled">
              <?php
              for ($i = 0;  $i <= 10; $i++) {?>
                  <option value="<?php echo $i; ?>" 
                  <?php if (!(strcmp($i, htmlentities($tip_ticket, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>
                  <?php echo $i; ?>
                  </option>
              <?php
              }?>  
              </select>                    
            </td>
          </tr>
          <tr valign="baseline">
            <td align="left" nowrap bgcolor="#D8D8D8">&nbsp;</td>
            <td height="65" align="left" valign="middle" nowrap bgcolor="#D8D8D8">TRIFECTA:</td>
            <td valign="middle" bgcolor="#D8D8D8">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($apu_mintri, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle" bgcolor="#D8D8D8">
                <input type="text" class="textboxsmal" style="height:15px; width:70px" disabled="disabled"
                value="<?php echo htmlentities($apu_maxtri, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle" bgcolor="#D8D8D8">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($reg_tri, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle" bgcolor="#D8D8D8">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($max_aganar_tri, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td align="center" valign="middle" bgcolor="#D8D8D8">
                <input type="checkbox" class="textboxsmal" disabled="disabled"
                value=""  <?php if (!(strcmp(htmlentities($est_tri, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />
            </td>
            <td colspan="2" align="center" valign="top" bgcolor="#D8D8D8" style="font-size:12px; color: #F00">
            	Confirmación de impresión<br/>de ticket:<br/>
                  <select name="est_impresion" style="width:auto; height: auto" class="textbox" disabled="disabled"> 
                    <option value="0" <?php if (!(strcmp(0, htmlentities($est_impresion, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>INACTIVO</option>
                    <option value="1" <?php if (!(strcmp(1, htmlentities($est_impresion, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>ACTIVO</option>
                  </select>                  
            </td>
            <td colspan="2"  align="center" valign="top" bgcolor="#D8D8D8" style="font-size:12px">Ejemplares mínimos en carrera:
                 <select style="width: auto; height: auto" class="textbox" disabled="disabled">
                    <?php for ($i = 2; $i <= 15; $i++) {?>
                      <option value="<?php echo $i; ?>" <?php
                          if (!(strcmp($i, htmlentities($min_ejecarrera, ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                          } ?>><?php echo $i; ?>
                    </option>                           <?php  }?>
                </select>                      
            </td>
          </tr>
          <tr valign="baseline">
            <td height="65" align="left" nowrap>&nbsp;</td>
            <td align="left" valign="middle" nowrap>SUPERFECTA:</td>
            <td valign="middle">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($apu_minsup, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle">
                <input type="text" class="textboxsmal" style="height:15px; width:70px" disabled="disabled" 
                value="<?php echo htmlentities($apu_maxsup, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($reg_sup, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td valign="middle">
                <input type="text" class="textboxsmal" style="height:15px;" disabled="disabled"
                value="<?php echo htmlentities($max_aganar_sup, ENT_COMPAT, 'utf-8'); ?>"/>
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" name="est_sup" class="textboxsmal" disabled="disabled"
                value=""  <?php if (!(strcmp(htmlentities($est_sup, ENT_COMPAT, 'utf-8'), "1"))) {
                              echo "checked=\"checked\"";
                          } ?> />
            </td>
            <td colspan="2" align="center" valign="top" style="font-size:12px; color: #F00">&nbsp;</td>
            <td colspan="3" align="center" valign="top" style="font-size:12px; color: #F00">&nbsp;</td>          
          </tr>
        </table>
</div>  
</body>
</html>
<?php
mysqli_free_result($Recordset4);
?>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include("index_datos.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HTML> 
<HEAD> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true;}else{alert("Datos enviados por favor presione enter solo una vez mas.");return false;}}
</script>
</HEAD> 
<BODY> 
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
onsubmit="return chequearEnvio();">
<CENTER>
<TABLE WIDTH="750" HEIGHT="400" BGCOLOR="#8258FA" >
<tr>
<td colspan="8" style="font-size:30px; align="center">
Cantidad de tickets creados:
</td>
</tr>
<tr>
<td colspan="8" HEIGHT="80" >
<CENTER>
<div id="mon_canticket" style="font-size:66px;
padding:2px 2px 2px 2px; color: #F90;"><?php include("../includes/infoNumeroTicket.php");?>
</div>
</CENTER>
</td>
</tr>
<tr>
<td height="35" colspan="8"><?php echo $_SESSION['MM_mensaje3']; ?>
</td>
</tr>
<tr>
<td colspan="8" HEIGHT="50" >
<CENTER>
<?php
if ($t>0 && isset($cod)) {?>
<select name="cod_carrera" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"  
style="font-size:20px; width:580px; height:35px"
onChange="javascript:document.getElementById('numCa44').focus()">
<option>
<?php echo "SELECCIONE HIPODROMO AQUI";?>
</option>
<?php
foreach ($cod as $cod_carrera) {?>
<option value="<?php echo $cod_carrera;?>" 
<?php if (!(strcmp(
    htmlentities($cod_carrera, ENT_COMPAT, 'utf-8'),
    $_SESSION['selCarrera']
))) {
    echo "selected=\"selected\"";
}?>>
<?php echo $nom_hipodromo[$x]." Carr: ...".$num_carrera[$x];?>
</option>
<?php
$x++;
}?>
</select>
<?php
} else {
    $_SESSION['selCarrera']=-1; //#e0e0e0?>
<select name="cod_carrera2"
tabindex="1" style="font-size:20px;width:580px;height:35px">
<option value="-1" > <?php echo "En estos momentos no existen carreras abiertas"; ?></option>
</select>
<?php
}?>
</CENTER>
</td>
</tr>
<tr>
<td colspan="8" align="center">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EJEMPLARES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
PLA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
SHW
</td>
</tr>
<tr>
<td colspan="8" align="center">
<?php
$x=1;
for ($i = 1; $i <= 4; $i++) {?>
<div style="margin:1px 0px 0px 5px; height:40px; background:#8258FA;">
<input type="checkbox" name="<?php echo "per".$i; ?>" size="20" id="<?php echo "per".$i; ?>"/>
<input class="textbox" tabindex="<?php echo $x;?>"
type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;" name="<?php echo "numCa1".$i;?>" style="width:40px; font-size:22px" 
maxlength="2" value="" id="<?php echo "numCa1".$i;?>" 
/>
<input class="textbox" tabindex="<?php echo $x+1;?>" type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
name="<?php echo "numCa2".$i;?>" style="width:40px; font-size:22px"
maxlength="2" value="" id="<?php echo "numCa2".$i;?>"/>
<input class="textbox" tabindex="<?php echo $x+2;?>" type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
name="<?php echo "numCa3".$i;?>"
style="width:40px; font-size:22px" maxlength="2" value="" id="<?php echo "numCa3".$i;?>"/>
<input class="textbox" tabindex="<?php echo $x+3;?>" type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;" 
name="<?php echo "numCa4".$i;?>"
style="width:40px; font-size:22px"
maxlength="2" value="" id="<?php echo "numCa4".$i;?>"/>
<input class="textbox" tabindex="<?php echo $x+4;?>" 
type="text" onKeyDown="if(event.keyCode==13) event.keyCode=9;" name="<?php echo "monGan".$i; ?>"
style="width:75px; font-size:22px" maxlength="5"value="" id="<?php echo "monGan".$i;?>"/>
<input class="textbox" tabindex="<?php echo $x+5;?>" type="text" 
onKeyDown="if(event.keyCode==13) event.keyCode=9;" name="<?php echo "monPla".$i; ?>" 
style="width:75px; font-size:22px" maxlength="5" value="" id="<?php echo "monPla".$i;?>"/>
<input class="textbox" tabindex="<?php echo $x+6;?>" type="text" 
onKeyDown="if(event.keyCode==13) event.keyCode=9;" name="<?php echo "monSho".$i; ?>"
style="width:75px; font-size:22px" maxlength="5" value="" id="<?php echo "monSho".$i;?>"/>
</div>	
<?php
$x=$x+7;
}?>
</td>
</tr>
<tr>
<td colspan="8" font-size:30px" align="center">
<input type="submit" id="imprimir" name="imprimir" 
value="REALIZAR APUESTA E IMPRIMIR" style="width:400px; font-size:20px; height:45px" 
tabindex="<?php echo $x;?>"
<?php if ($totalRows_Recordset1==0); ?>/>
</td>
</tr>
<tr>
<td colspan="8" font-size:30px" align="center">
<input type="button" onclick="window.location='index_ventas.php';"
value="ACTUALIZAR PAGINA" style="width:300px; font-size:20px; height:45px"
tabindex="<?php echo $x;?>"/>
</td>
</tr>
</TABLE> 
</CENTER>
<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="ser_venta" value="" />
<input type="hidden" name="ticket" value="" />
<input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset5['cod_taquilla']; ?>" />
<input type="hidden" name="fec_venta" value=""/>
<input type="hidden" name="hor_venta" value="" />
<input type="hidden" name="id_usuario" value="<?php echo $usuarioVenta; ?>" />
<input type="hidden" name="est_ticket" value="1" />
<input type="hidden" name="est_gan" value="<?php echo $est_gan; ?>" />
<input type="hidden" name="est_pla" value="<?php echo $est_pla; ?>" />
<input type="hidden" name="est_sho" value="<?php echo $est_sho; ?>" />
<input type="hidden" name="est_exa" value="<?php echo $est_exa; ?>" />
<input type="hidden" name="est_tri" value="<?php echo $est_tri; ?>" />
<input type="hidden" name="est_sup" value="<?php echo $est_sup; ?>" />
<input type="hidden" name="apMinGan" value="<?php echo $apMinGan; ?>" />
<input type="hidden" name="apMinPla" value="<?php echo $apMinPla; ?>" />
<input type="hidden" name="apMinSho" value="<?php echo $apMinSho; ?>" />
<input type="hidden" name="apMaxGan" value="<?php echo $apGaMax; ?>" />
<input type="hidden" name="apMaxPla" value="<?php echo $apPlMax; ?>" />
<input type="hidden" name="apMaxSho" value="<?php echo $apShMax; ?>" />
<input type="hidden" name="apMinExa" value="<?php echo $apMinExa; ?>" />
<input type="hidden" name="apMinTri" value="<?php echo $apMinTri; ?>" />
<input type="hidden" name="apMinSup" value="<?php echo $apMinSup; ?>" />
<input type="hidden" name="apMaxExa" value="<?php echo $apExMax; ?>" />
<input type="hidden" name="apMaxTri" value="<?php echo $apTrMax; ?>" />
<input type="hidden" name="apMaxSup" value="<?php echo $apSuMax; ?>" />
<input type="hidden" name="monMaxTi" value="<?php echo $monMaxTi; ?>" />
<input type="hidden" name="monMaxEj" value="<?php echo $monMaxEj; ?>" />
<input type="hidden" name="ejeMinC" id="ejeMinC" value="<?php echo $ejeMinCar; ?>" />
<input type="hidden" name="xindex" id="xindex" value="1" />
</form>
</BODY> 
</HTML> 
<script language="javascript">document.getElementById("numCa44").focus();</script>
<?php mysqli_free_result($Recordset1);mysqli_free_result($Recordset4);mysqli_free_result($Recordset5);?>
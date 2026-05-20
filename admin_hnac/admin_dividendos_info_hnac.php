<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin_hnac\admin_dividendos_info_hnac.php - QUERY 1 */ SELECT hi.nom_hipodromo_hnac, ca.cod_carrera_hnac, ca.num_carrera_hnac, ca.fec_carrera_hnac,
	ca.est_carrera_hnac, ca.cod_carrera_hnac
	FROM carrera_hnac ca, hipodromo_hnac hi 
	WHERE ca.cod_carrera_hnac = %s AND ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac",
    GetSQLValueString($xCarrera_Recordset1, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
list($ej1si, $di1si, , $id1si, $fa1si)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 1, 11);
list($ej2si, , $id2si)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 2, 12);
list($ej3si, , $id3si)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 3, 13);
list($ej4si, , $id4si)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 4, 14);
list($ej1do, $di1do, , $id1do, $fa1do)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 1, 21);
list($ej2do, , $id2do)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 2, 22);
list($ej3do, , $id3do)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 3, 23);
list($ej4do, , $id4do)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 4, 24);
list($ej1tr, $di1tr, , $id1tr, $fa1tr)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 1, 31);
list($ej2tr, , $id2tr)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 2, 32);
list($ej3tr, , $id3tr)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 3, 33);
list($ej4tr, , $id4tr)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 4, 34);
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
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Ganadores y Dividendos<br/>Información
			</div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="height:100%; padding:70px 10px 20px 10px; text-align:left">
      <table width="100%" border="0" height="50" align="center" style="background:#0E5157; color:#FFFFFF; font-size:16px;">
        <tr>
          <td colspan="2"><?php  echo $row_Recordset1['nom_hipodromo_hnac']." Carr: ...".$row_Recordset1['num_carrera_hnac']; ?>            
		  <?php  echo " - Fecha de cierre: ".fechanueva($row_Recordset1['fec_carrera_hnac']);?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="380"></td>
          <td width="524"></td>
        </tr>
 	</table>
        <table width="100%" align="center">
          <tr valign="baseline" height="40">
            <td width="61" align="right" nowrap="nowrap">&nbsp;</td>
            <td colspan="3" align="center" valign="bottom" bgcolor="#3399CC" style="color:#FFF;font-size:20px">Carrera Simple</td>
            <td width="37" valign="bottom">&nbsp;</td>
            <td colspan="2" valign="bottom">&nbsp;</td>
            <td colspan="3" align="center" valign="bottom" bgcolor="#009999" style="color:#FFF;font-size:20px">
            	Carrera Doble Empate
            </td>
            <td width="45" valign="bottom">&nbsp;</td>
            <td colspan="4" align="center" valign="bottom" bgcolor="#3399FF" style="color:#FFF;font-size:20px">
            	Carrera Triple Empate
            </td>
          </tr>
          <tr valign="baseline">
            <td width="61" align="right" nowrap="nowrap">&nbsp;</td>
            <td width="84" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="73" align="center" bgcolor="#333" style="color:#FFF">DIV</td>
            <td width="83" align="center" bgcolor="#333" style="color:#FFF">FACTOR</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td width="73" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="65" align="center" bgcolor="#333" style="color:#FFF">DIV</td>
            <td width="95" align="center" bgcolor="#333" style="color:#FFF">FACTOR</td>
            <td width="45">&nbsp;</td>
            <td width="91" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">DIV</td>
            <td width="56" colspan="2" align="center" bgcolor="#333" style="color:#FFF">FACTOR</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">1er Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
				<input name="ej1si" value="<?php echo $ej1si; ?>"  
				style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
				<input name="di1si" type="text" value="<?php echo $di1si; ?>" 
				style="width:50px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
				<input type="text" name="fa1si" value="<?php echo $fa1si; ?>" 
				style="width:50px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej1do" type="text" value="<?php echo $ej1do; ?>" 
                style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="di1do" value="<?php echo $di1do; ?>" 
                style="width:50px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="fa1do" value="<?php echo $fa1do; ?>" 
                style="width:50px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej1tr" type="text" value="<?php echo $ej1tr; ?>" 
                style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="di1tr" value="<?php echo $di1tr; ?>" 
                style="width:50px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td colspan="2" align="center" bgcolor="#CCCCCC">
                <input type="text" name="fa1tr" value="<?php echo $fa1tr; ?>" 
                style="width:50px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">2do Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
				<input name="ej2si" type="text" value="<?php echo $ej2si; ?>"
				style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td rowspan="3" align="center" bgcolor="#CCCCCC">
            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej2do" type="text"  value="<?php echo $ej2do; ?>" 
                style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td rowspan="3" align="center" bgcolor="#CCCCCC">
            </td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej2tr" type="text" value="<?php echo $ej2tr; ?>" 
                style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td colspan="2" rowspan="3" align="center" bgcolor="#CCCCCC">
            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">3er Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
				<input name="ej3si" type="text" value="<?php echo $ej3si; ?>" 
				style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
            	<input name="ej3do" type="text" value="<?php echo $ej3do; ?>" 
                style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej3tr" type="text" value="<?php echo $ej3tr; ?>" 
                style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">4to Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
				<input name="ej4si" type="text" value="<?php echo $ej4si; ?>" 
				style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej4do" type="text" value="<?php echo $ej4do; ?>" 
                style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej4tr" type="text" value="<?php echo $ej4tr; ?>" 
                style="width:30px; font-size:18px; background: #FFC" disabled="disabled" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="14"><p>&nbsp;</p>
            <p>&nbsp;</p></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="14" align="center"> 
            <a href="admin_historial_lista_hnac.php" class="btn btn-warning" 
            	style="width:100px; height:25px; font-size:16px; text-decoration:none; padding:11px 0px 0px 0px">Volver</a></td>
          </tr>
        </table>
      <p>&nbsp;</p>
    </blockquote>
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
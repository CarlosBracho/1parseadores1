<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xcarrera_Recordset1 = "-1";
if (isset($_GET["recordID"])) {
    $xcarrera_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\dividendos_info.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", GetSQLValueString($xcarrera_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$fecha=$row_Recordset1['fec_carrera'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
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
                Historial de carreras<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  <div style="height:100%; padding:70px 10px 50px 10px; text-align:left">
      <table width="100%" border="0" height="50" align="center" style="background:#333; color:#FFFFFF; font-size:16px;">
        <tr>
          <td colspan="2"><?php  echo ObtenerNombreynumeroJugadaCarrera($row_Recordset1['cod_carrera']); ?>            
		  <?php  echo "FECHA Y HORA DE CIERRE ".fechanueva(ObtenerFechaJugadaCarrera($row_Recordset1['cod_carrera']))." - ";
                 echo horaampm($row_Recordset1['hor_carrera']); ?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="380"></td>
          <td width="524"></td>
        </tr>
 	</table>
        <table width="100%" align="center" style="font-size:18px">
          <tr valign="baseline" height="40" style="font-size:12px">
            <td width="61" align="right" nowrap="nowrap">&nbsp;</td>
            <td colspan="4" align="center" valign="bottom" bgcolor="#3399CC" style="color:#FFF;font-size:20px">Carrera Simple</td>
            <td colspan="2" valign="bottom">&nbsp;</td>
            <td colspan="4" align="center" valign="bottom" bgcolor="#009999" style="color:#FFF;font-size:20px">
            	Carrera Doble Empate
            </td>
            <td width="70" valign="bottom">&nbsp;</td>
            <td colspan="4" align="center" valign="bottom" bgcolor="#3399FF" style="color:#FFF;font-size:20px">
            	Carrera Triple Empate
            </td>
          </tr>
          <tr valign="baseline" style="font-size:12px">
            <td width="61" align="right" nowrap="nowrap" style="color:#FFF">&nbsp;</td>
            <td width="60" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="53" align="center" bgcolor="#333" style="color:#FFF">GAN</td>
            <td width="53" align="center" bgcolor="#333" style="color:#FFF">PLA</td>
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
  <tr  style="font-size:18px" align="center">
    <td align="right" bgcolor="#FFFF99"style="font-size:12px" ><strong>1er Lugar:</strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_primero']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_primero_gan']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_primero_pla']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_primero_sho']; ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_doble_primero']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_primero_gan']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_primero_pla']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_primero_sho']; ?></strong></td>
    <td>&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_triple_primero']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_primero_gan']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_primero_pla']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_primero_sho']; ?></strong></td>
  </tr>
  <tr align="center">
    <td align="right" bgcolor="#FFFF99" style="font-size:12px"><strong>2do Lugar:</strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_segundo']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_segundo_pla']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_segundo_sho']; ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_doble_segundo']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_segundo_pla']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_segundo_sho']; ?></strong></td>
    <td>&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_triple_segundo']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_segundo_pla']; ?></strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_segundo_sho']; ?></strong></td>
  </tr>
  <tr align="center">
    <td align="right" bgcolor="#FFFF99" style="font-size:12px"><strong>3er Lugar:</strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_tercero']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_tercero_sho']; ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_doble_tercero']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_doble_tercero_sho']; ?></strong></td>
    <td>&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_triple_tercero']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_triple_tercero_sho']; ?></strong></td>
  </tr>
  <tr align="center">
    <td align="right" bgcolor="#FFFF99" style="font-size:12px"><strong>4to Lugar:</strong></td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_cuarto']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_doble_cuarto']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td>&nbsp;</td>
    <td bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['eje_triple_cuarto']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  <tr class="docepunto" align="center">
    <td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" bgcolor="#FFFFFF">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr class="docepunto" align="center">
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#3399CC" style="color:#FFF">Div</td>
    <td align="right" bgcolor="#3399CC" style="color:#FFF">Factor</td>
    <td colspan="2" bgcolor="#3399CC" style="color:#FFF">Llegada</td>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#009999" style="color:#FFF">Div</td>
    <td bgcolor="#009999">&nbsp;</td>
    <td colspan="2" bgcolor="#009999" style="color:#FFF">Llegada</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#3399FF" style="color:#FFF">Div</td>
    <td bgcolor="#3399FF">&nbsp;</td>
    <td colspan="2" bgcolor="#3399FF" style="color:#FFF">Llegada</td>
    </tr>
  <tr class="docepunto" align="center">
    <td height="28" align="right" bgcolor="#FFFF99" style="font-size:12px"><strong>Exacta:</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_exacta']; ?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><?php echo $row_Recordset1['fac_exacta']; ?></td>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><?php echo $row_Recordset1['ord_exacta']; ?></td>
    <td>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_exacta_doble']; ?></strong></td>
    <td align="left" bgcolor="#CCCCCC">&nbsp;</td>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><?php echo $row_Recordset1['ord_exacta_doble']; ?></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_exacta_triple']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><?php echo $row_Recordset1['ord_exacta_triple']; ?></td>
    </tr>
  <tr class="docepunto" align="center">
    <td height="28" align="right" bgcolor="#FFFF99" style="font-size:12px"><strong>Trifecta:</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_trifecta']; ?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><?php echo $row_Recordset1['fac_trifecta']; ?></td>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><?php echo $row_Recordset1['ord_trifecta']; ?></td>
    <td>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_trifecta_doble']; ?></strong></td>
    <td align="left" bgcolor="#CCCCCC">&nbsp;</td>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><?php echo $row_Recordset1['ord_trifecta_doble']; ?></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_trifecta_triple']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><?php echo $row_Recordset1['ord_trifecta_triple']; ?></td>
    </tr>
  <tr class="docepunto" align="center">
    <td height="28" align="right" bgcolor="#FFFF99" style="font-size:12px"><strong>Superfecta:</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_superfecta']; ?></strong></td>
    <td align="center" bgcolor="#CCCCCC"><?php echo $row_Recordset1['fac_superfecta']; ?></td>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><?php echo $row_Recordset1['ord_superfecta']; ?></td>
    <td>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_superfecta_doble']; ?></strong></td>
    <td align="left" bgcolor="#CCCCCC">&nbsp;</td>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><?php echo $row_Recordset1['ord_superfecta_doble']; ?></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo $row_Recordset1['div_superfecta_triple']; ?></strong></td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><?php echo $row_Recordset1['ord_superfecta_triple']; ?></td>
    </tr>
  <tr>
    <td height="80" colspan="16" align="center">
      <a href="historial_lista.php?fechaID=<?php echo $fecha ?>" class="btn btn-warning" 
      	style="width:100px; height:25px; font-size:16px; text-decoration:none; padding:11px 0px 0px 0px">Volver</a>
      </td>
    </tr>
</table>
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
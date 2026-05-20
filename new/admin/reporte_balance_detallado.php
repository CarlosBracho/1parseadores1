<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$query_Recordset1 = "/* PARSEADORES1 new\admin\reporte_balance_detallado.php - QUERY 1 */ SELECT * FROM banca ORDER BY banca.nom_banca ASC";
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if ($_POST['fecha_inicio']!="" && $_POST['fecha_fin']!="") {
        if (strtotime($_POST['fecha_inicio'])>strtotime($_POST['fecha_fin'])) {
            $fecha=$_POST['fecha_fin'];
            $_POST['fecha_fin']=$_POST['fecha_inicio'];
            $_POST['fecha_inicio']=$fecha;
        }
        $_POST['fecha_inicio']=fechaymd($_POST['fecha_inicio']);
        $_POST['fecha_fin']=fechaymd($_POST['fecha_fin']);
        $query_Recordset2 = sprintf("/* PARSEADORES1 new\admin\reporte_balance_detallado.php - QUERY 2 */ SELECT * FROM banca, taquilla, agencia, usuario WHERE banca.cod_banca = %s AND agencia.cod_banca = %s AND taquilla.cod_agencia = agencia.cod_agencia AND usuario.cod_taquilla = taquilla.cod_taquilla ORDER BY taquilla.nom_taquilla ASC", GetSQLValueString($_POST['cod_banca'], "int"), GetSQLValueString($_POST['cod_banca'], "int"));
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function imprSelec(muestra)
{var ficha=document.getElementById(muestra);var ventimp=window.open(' ','popimpr');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();}
</script>
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
                Administracion <br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  <script language='javascript' src="../calendario/popcalendar.js"></script>
 <br class="lineainicio">
    <table width="740" border="0" class="lista">
  <tr>
    <td width="24">&nbsp;</td>
    <td width="371" class="mostrarusuario"><img src="../images/Administrator-icon.png" alt="" width="36" height="36" /><strong>Usuario:<?php echo "  ".  $_SESSION['MM_nom_uadmin']; ?></strong></td>
    <td width="347" class="sitiousuario"><strong>Administración</strong></td>
  </tr>
</table>
    <table width="756" border="0">
      <tr>
        <td width="26">&nbsp;</td>
        <td width="326" align="center" valign="bottom" class="barraaccionusuario"><p id="sprytrigger4"><strong><img src="../images/printer-icon.png" alt="" width="24" height="24" />REPORTES</strong></p></td>
        <td width="390" align="right" class="fechayhora"><?php  echo verfechaactual() ?></td>
      </tr>
    </table>
   <?php $montototal=0;  ?>
   <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
   		<table width="680" align="center">
        <tr valign="baseline">
          <td align="right" nowrap="nowrap">Desde:</td>
          <td width="60"><input name="fecha_inicio" type="text" id="dateArrival" onclick="popUpCalendar(this, form1.dateArrival, 'dd-mm-yyyy');" size="10" /></td>
          <td width="39">Hasta:</td>
          <td width="65"><input name="fecha_fin" type="text" id="dateArrival2" onclick="popUpCalendar(this, form1.dateArrival2, 'dd-mm-yyyy');" size="10" /></td>
          <td width="264">&nbsp;</td>
          <td width="181" rowspan="2" align="right" valign="middle" class="lista"><a href="javascript:imprSelec('muestra')"><img src="../images/print-icon.png" width="18" height="18" /> Imprimir</a></td>
        </tr>
        <tr valign="baseline">
        	<td width="43" align="right" nowrap="nowrap">Distribuidor:</td>
            <td colspan="4"><select name="cod_banca" tabindex="3" onkeydown="if(event.keyCode==13) event.keyCode=9;">
              <?php do { ?>
              <option value="<?php echo $row_Recordset1['cod_banca']?>"> <?php echo $row_Recordset1['nom_banca'];?></option>
              <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));?>
            </select>
            <input type="submit" value="Buscar" /></td>
          </tr>
        </table>
   <input type="hidden" name="MM_update" value="form1" />
   </form>
   <table width="710" border="0" align="center">
   <tr>
   	<td width="710" align="right"><div id="TabbedPanels1" class="TabbedPanels">
    <ul class="TabbedPanelsTabGroup">
    	<li class="TabbedPanelsTab" tabindex="0">BALANCE GENERAL DETALLADO</li>
    </ul>
        <div class="TabbedPanelsContentGroup">
          <div class="scroll7" id="muestra">
		  	<?php if (isset($totalRows_Recordset2) && $totalRows_Recordset2>0) { ?>
				<table width="622" border="0" align="center">
				  <tr>
					<td align="center">DISTRIBUIDOR: <?php echo ObtenerNombreBanca($_POST['cod_banca']);?></td>
				  </tr>
				</table>

				<?php $totalgeneralven=0; $totalgeneralpre=0; $totalgeneralpor=0; $totalgeneralgp=0; $totalinvalidado=0;
                do {
                    $ventaUsuario=ObtenerVentaDiaVendedor($row_Recordset2['id_usuario'], $_POST['fecha_inicio'], $_POST['fecha_fin']);
                    $ventaAgan=ObtenerVentaUsuarioTipoVenta($row_Recordset2['id_usuario'], $_POST['fecha_inicio'], $_POST['fecha_fin'], 1);
                    $ventaApla=ObtenerVentaUsuarioTipoVenta($row_Recordset2['id_usuario'], $_POST['fecha_inicio'], $_POST['fecha_fin'], 2);
                    $ventaAsho=ObtenerVentaTaquillaTipoVenta($row_Recordset2['id_usuario'], $_POST['fecha_inicio'], $_POST['fecha_fin'], 3);
                    $vpremioAgan=GanadoresporUsuario($row_Recordset2['id_usuario'], $_POST['fecha_inicio'], $_POST['fecha_fin'], 1);
                    $vpremioApla=GanadoresporUsuario($row_Recordset2['id_usuario'], $_POST['fecha_inicio'], $_POST['fecha_fin'], 2);
                    $vpremioAsho=GanadoresporUsuario($row_Recordset2['id_usuario'], $_POST['fecha_inicio'], $_POST['fecha_fin'], 3);
                    
                    $totalpremUsuario=$vpremioAgan+$vpremioApla+$vpremioAsho;
                    //$porcAgan=($ventaAgan*$row_Recordset2['por_agencia'])/100;
                    //$porcApla=($ventaApla*$row_Recordset2['por_agencia'])/100;
                    //$porcAsho=($ventaAsho*$row_Recordset2['por_agencia'])/100;
                    
                    $porcAgan=0;
                    $porcApla=0;
                    $porcAsho=0;
                    
                    $totalporc=$porcAgan+$porcApla+$porcAsho;
                    $gaperAgan=$ventaAgan-$vpremioAgan-$porcAgan;
                    $gaperApla=$ventaApla-$vpremioApla-$porcApla;
                    $gaperAsho=$ventaAsho-$vpremioAsho-$porcAsho;
                    
                    $totalganper=$ventaUsuario-$totalpremUsuario-$totalporc;
                    $totalgeneralven=$totalgeneralven+$ventaUsuario;
                    $totalgeneralpre=$totalgeneralpre+$totalpremUsuario;
                    $totalgeneralpor=$totalgeneralpor+$totalporc;
                    $totalgeneralgp=$totalgeneralgp+$totalganper;
                    $invtaq=ObtenerInvalidadosUsuario($row_Recordset1['id_usuario'], $_POST['fecha_inicio'], $_POST['fecha_fin']);
                    $totalinvalidado=$totalinvalidado+$invtaq;
                    $ganaciaperdidas=$totalganper-$invtaq; ?>   
                    <table width="622" border="0" align="center">
                      <tr>
                        <td colspan="5" align="center"><strong><?php echo "AGENTE: ".$row_Recordset2['nom_agencia']; ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="5" align="center"><strong><?php echo "TAQUILLA: ".$row_Recordset2['nom_taquilla']." - "."VENDEDOR: ".$row_Recordset2['nom_usuario']; ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="5" align="center"><?php echo "Desde: ".fechanueva($_POST['fecha_inicio'])." - "." Hasta: ".fechanueva($_POST['fecha_fin']); ?></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td align="center" bgcolor="#6699CC" class="totalgeneral">VENTAS</td>
                        <td align="center" bgcolor="#6699CC" class="totalgeneral">PREMIOS</td>
                        <td align="center" bgcolor="#6699CC" class="totalgeneral">GAN/PER</td>
                      </tr>
                      <tr class="brillo">
                        <td>GANADOR</td>
                        <td align="right"><?php echo number_format($ventaAgan, 2, ",", "."); ?></td>
                        <td align="right"><?php echo number_format($vpremioAgan, 2, ",", "."); ?></td>
                        <td align="right"><?php echo number_format($gaperAgan, 2, ",", "."); ?></td>
                      </tr>
                      <tr class="brillo">
                        <td>PLACE</td>
                        <td align="right"><?php echo number_format($ventaApla, 2, ",", "."); ?></td>
                        <td align="right"><?php echo number_format($vpremioApla, 2, ",", "."); ?></td>
                        <td align="right"><?php echo number_format($gaperApla, 2, ",", "."); ?></td>
                      </tr>
                      <tr class="brillo">
                        <td>SHOW</td>
                        <td align="right"><?php echo number_format($ventaAsho, 2, ",", "."); ?></td>
                        <td align="right"><?php echo number_format($vpremioAsho, 2, ",", "."); ?></td>
                        <td align="right"><?php echo number_format($gaperAsho, 2, ",", "."); ?></td>
                      </tr>
                      <tr class="rCorners">
                        <td align="right"><strong>TOTAL:</strong></td>
                        <td align="right"><?php echo number_format($ventaUsuario, 2, ",", "."); ?></td>
                        <td align="right"><?php echo number_format($totalpremUsuario, 2, ",", "."); ?></td>
                        <td align="right"><?php echo number_format($totalganper, 2, ",", "."); ?></td>
                      </tr>
                      <tr>
                        <td align="right">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>  <?php // con procentaje colspan="4"?>
                        <td colspan="3" align="right"><strong>TOTAL INVALIDADO:</strong></td>
                        <td align="right" bgcolor="#CCCCCC"><strong><?php echo number_format($invtaq, 2, ",", "."); ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="3" align="right"><strong>TOTAL GANANCIA/PERDIDA DE VENDEDOR:</strong></td>
                        <td align="right" bgcolor="#CCCCCC"><strong><?php echo number_format($ganaciaperdidas, 2, ",", "."); ?></strong></td>
                      </tr>
                      <tr>
                         <td height="24" colspan="5" bgcolor="#CCCCCC">&nbsp;</td>
                      </tr>
                    </table>
				 <?php
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                    $grantotal=$totalgeneralgp-$totalinvalidado;?>
                    <table width="622" border="0" align="center" class="docepunto">
                      <tr>
                        <td>&nbsp;</td>
                        <td align="center" class="totalgeneral">VENTAS</td>
                        <td align="center" class="totalgeneral">PREMIOS</td>
                        <td align="center" class="totalgeneral">GAN/PER</td>
                      </tr>
                      <tr class="diesiochopunto">
                        <td width="162"><strong>TOTAL GENERAL:</strong></td>
                        <td width="111" align="right"><strong><?php echo number_format($totalgeneralven, 2, ",", "."); ?></strong></td>
                        <td width="104" align="right"><strong><?php echo number_format($totalgeneralpre, 2, ",", "."); ?></strong></td>
                        <td width="116" align="right"><strong><?php echo number_format($totalgeneralgp, 2, ",", "."); ?></strong></td>
                      </tr>
                      <tr>
                        <td height="24" colspan="5" bgcolor="#CCCCCC">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="24" colspan="4" align="right" class="diesiochopunto"><strong>TOTAL GENERAL INVALIDADO: </strong></td>
                        <td height="24" align="right" class="diesiochopunto"><strong><?php echo number_format($totalinvalidado, 2, ",", "."); ?></strong></td>
                      </tr>
<tr>
                        <td height="24" colspan="4" align="right" class="diesiochopunto"><strong>TOTAL GENERAL GANANCIAS/PERDIDAS:</strong></td>
                        <td height="24" align="right" class="diesiochopunto"><strong><?php echo number_format($grantotal, 2, ",", "."); ?></strong></td>
                      </tr>
                      <tr class="oncepunto">
                  		<td align="center" colspan="5">&nbsp;</td>
                 	  </tr>
                      <tr class="oncepunto">
                  		<td align="center" colspan="5">Reporte generado el <?php echo "".verfechaactual()." - Design by OSiriTT "; ?></td>
                 	  </tr>
            </table>  
            <?php } else {
                    if (isset($totalRows_BuscarVentasporFecha)) { ?>
						<table width="622" border="0" align="center" class="lineainicio">
                      <tr>
                        <td>No existen ventas...</td>
                      </tr>
                      </table>
					<?php } ?>
				<?php
                }?>              
          </div> 
              <?php // Fin Apuestas pendientes?>
              <div class="scroll">
              </div>
              <?php // Fin Resumen de apuestas?>
              <div class="TabbedPanelsContent">
              </div>
            </div>
          </div></td>
      </tr>
    </table>

 
    <script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
    </script>
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
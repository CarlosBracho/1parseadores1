<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
        if ($_POST['fecha_inicio']!="" && $_POST['fecha_fin']!="") {
            if (strtotime(fechaymd($_POST['fecha_inicio'])) < strtotime(fechaymd($_POST['fecha_fin']))) {
                $inicio=$_POST['fecha_inicio'];
                $final=$_POST['fecha_fin'];
            } else {
                $final=$_POST['fecha_inicio'];
                $inicio=$_POST['fecha_fin'];
            }
            $in=fechaymd($inicio);
            $fi=fechaymd($final);
            if ($_POST['id_distribuidor']!="todos") {
                $query_Recordset10 = sprintf(
                    "/* PARSEADORES1 new\admin_hnac\admin_reporte_cobranza_hnacvvv.php - QUERY 1 */ SELECT cod_banca, nom_banca, tel_banca, cor_banca, por_banca_hnac 
				FROM banca WHERE cod_banca = %s",
                    GetSQLValueString($_POST['id_distribuidor'], "int")
                );
                $v=1;
            }
        }
    }
}
if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && $_POST['id_distribuidor']=="todos") ||
    !isset($_POST["MM_update"])) {
    $query_Recordset10 = sprintf("/* PARSEADORES1 new\admin_hnac\admin_reporte_cobranza_hnacvvv.php - QUERY 2 */ SELECT cod_banca, nom_banca, tel_banca, cor_banca, por_banca_hnac FROM banca");
    $v=0;
}
$Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
$row_Recordset10 = mysqli_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysqli_num_rows($Recordset10);
if (isset($v) && $v==1) {
    $nomb=$row_Recordset10['nom_banca'];
} else {
    $nomb="TODOS";
}
$query_Recordset2 = sprintf("/* PARSEADORES1 new\admin_hnac\admin_reporte_cobranza_hnacvvv.php - QUERY 3 */ SELECT cod_banca, nom_banca FROM banca ORDER BY banca.nom_banca");
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#9FBFD7" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script><style>.boton-top{display:none;position:fixed;bottom:0;right:0;width:40px;height:40px;text-align:center;line-height:40px;color:#fff;background:#F93;cursor:pointer;font-size:18px;}</style>
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
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              COBRANZA
			</div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
	</div>
  <div class="contentAdmin">
<div style="height:100%; font-size:26px; padding:50px 0px 100px 0px ">
       <div style="background: #FFF; width:100%; float:left; padding:5px 0px 0px 10px;
            color:#000; font-size:20px; text-align: left">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                Desde:
                <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" 
                	style="width:100px; font-size:16px; height:30px"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
                Hasta:    
                <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" 
                	style="width:100px; font-size:16px; height:30px"
                    size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" /> 
                 Distribuidores:
             <select name="id_distribuidor" id="soflow" style="height:40px; width:320px; margin:-9px 0px 0px 0px ">
                      <option value="todos" >TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset2['cod_banca']?>"
               <?php if ($row_Recordset2['nom_banca']==$nomb) {
                        echo "SELECTED";
                    } ?>>
			   <?php echo strtoupper($row_Recordset2['nom_banca']); ?>
               </option>
                      <?php
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                ?>
             </select>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
       </div><!-- end .container -->
   <div style="background:#0E5157; width:915px; float:left; padding:12px 13px 0px 12px;
      color:#FFF; font-size:20px;">
   <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo ""; ?></div>
   </div><!-- end .container -->

	<div>
    	<table width="934" border="0" style="color:#000; font-size:12px;">
				<tr style="font-size:14px" valign="middle" align="center">
				  <td width="457" style="font-size:24px">&nbsp;</td>
					<td width="259" colspan="-2" bgcolor="#FF3366" style="color:#FFF">TOTAL A COBRAR POR SISTEMA A DISTRIBUIDORES
                    </td>
					<td width="204" colspan="2" bgcolor="#333" style="color:#FFF">GANANCIA DE DISTRIBUIDORES</td>
				</tr>
		  <tr style="background: #FFF; color: #000; font-size:24px;" valign="middle" align="right" height="37">
					<td></td>
			  <td colspan="-2" bgcolor="#FF3366" style="color:#FFF">
               	 <div id="ganSis"></div>
           	  </td>
			  <td colspan="2" bgcolor="#333" style="color:#FFF">
               	  <div id="ganDis"></div>
			  </td>
				<tr style="font-size:7px" valign="middle" align="center">
				  <td colspan="5" style="font-size:24px">&nbsp;</td>
		  </tr>
		</table>              
	</div>
   <div id="mostrar" style="width:99.7%; float:left; padding:0px 0px 150px 3px; background: #CCC">
   	   	<table width="934" border="0" style="color:#000; font-size:12px;">
			<?php
            $totalSistema=0;
            $totalGenDi=0;
           if ($totalRows_Recordset10>0) {
               do {
                   $ventaDis=0;
                   $totalPreDis=0;
                   $totAnulaDis=0;
                   $totCajaDis=0;
                   $porPagarDis=0;
                   $ganPerDis=0;
                   $porDis=0;
                   $tDis=0; ?>
					
					<tr style="background:#0E5157; color:#FFF; border-color:#333" valign="middle" align="center">
						<td height="35" colspan="9" align="left" style="font-size:18px">
							<strong>
							<?php
                            echo $row_Recordset10['nom_banca']." | Teléfono: ".$row_Recordset10['tel_banca']." ";
                   echo "| Correo: ".$row_Recordset10['cor_banca']; ?>
					    </strong></td>
					</tr>
                    <tr style="background:#5EAEFF; color:#FFF; border-color:#5EAEFF;" valign="middle" align="center">
                        <td width="145">AGENTE</td>
                        <td width="83">VENTAS</td>
                        <td width="94">PREMIOS</td>
                        <td width="95">ANULADOS</td>
                        <td width="95">TOTAL EN CAJA</td>
                        <td width="95">POR PAGAR</td>
                        <td width="95">TOTAL<p style="font-size:8px">INCLUYE TICKETS POR PAGAR</p></td>
                        <td width="69">% COBRO SISTEMA AL AGENTE</td>
                        <td width="112">TOTAL A COBRAR DISTRIBUIDOR</td>
                    </tr><?php
                    $codBanca=$row_Recordset10['cod_banca'];
                   $porBanca=$row_Recordset10['por_banca_hnac'];
                   $query_Recordset3 = sprintf(
                       "/* PARSEADORES1 new\admin_hnac\admin_reporte_cobranza_hnacvvv.php - QUERY 4 */ SELECT cod_agencia, nom_agencia, por_agencia_hnac
							FROM agencia WHERE cod_banca = %s",
                       GetSQLValueString($codBanca, "int")
                   );
                   $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                   $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                   $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                   if ($totalRows_Recordset3>0) {
                       do {
                           $codAgencia=$row_Recordset3['cod_agencia'];
                           $nomAgente=$row_Recordset3['nom_agencia'];
                           $query_Recordset1 = sprintf(
                               "/* PARSEADORES1 new\admin_hnac\admin_reporte_cobranza_hnacvvv.php - QUERY 5 */ SELECT
							por_alquiler_hanc,
							SUM(CASE WHEN fec_venta_hnac >= %s AND fec_venta_hnac <= %s 
								THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
							SUM(CASE WHEN ve.est_ticket_hnac = 2 AND fec_pago_hnac >= %s AND fec_pago_hnac <= %s 
								THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
							SUM(CASE WHEN ve.est_ticket_hnac = 0 AND fec_pago_hnac >= %s AND fec_pago_hnac <= %s
								THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
							SUM(CASE WHEN ve.est_ticket_hnac = 4 AND fec_pago_hnac >= %s AND fec_pago_hnac <= %s
								THEN ve.pag_premio_hnac ELSE 0 END) AS ret_pagos,
							SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND fec_venta_hnac >= %s AND
								fec_venta_hnac <= %s THEN ve.pag_premio_hnac ELSE 0 END) AS ret_porpagar,
							SUM(CASE WHEN ve.est_ticket_hnac = 5 AND fec_pago_hnac >= %s AND fec_pago_hnac <= %s
								THEN ve.pag_premio_hnac ELSE 0 END) AS inv_pagos,
							SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 5 AND fec_venta_hnac >= %s AND
								fec_venta_hnac <= %s THEN ve.pag_premio_hnac ELSE 0 END) AS inv_porpagar,
							SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 2 AND fec_venta_hnac >= %s AND
								fec_venta_hnac <= %sTHEN ve.pag_premio_hnac ELSE 0 END) AS pre_porpagar
							FROM 
							agencia ag, taquilla ta, taquilla_opc_hnac tp, venta_hnac ve, usuario us
							WHERE
							(ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s OR 
							ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s) AND 
							tp.cod_taquilla = ta.cod_taquilla AND us.id_usuario = ve.id_usuario AND
							ta.cod_taquilla = us.cod_taquilla AND ta.cod_agencia = ag.cod_agencia AND
							ag.cod_agencia = %s ORDER BY ta.cod_taquilla ASC",
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date"),
                               GetSQLValueString($codAgencia, "int")
                           );
                           $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                           $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                           $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                           $totCajaAge=0;
                           $ganPerAge=0;
                           $tCobroDistri=0;
                           if ($totalRows_Recordset1>0) {
                               $porAgente=$row_Recordset1['por_alquiler_hanc'];
                               $porPagarAgente=$row_Recordset1['ret_porpagar']+$row_Recordset1['inv_porpagar']+$row_Recordset1['pre_porpagar'];
                               $totCajaAge=$row_Recordset1['total_venta']-($row_Recordset1['tot_premios']+$row_Recordset1['tot_eliminad']);
                               $ganPerAge=$totCajaAge-$porPagarAgente;
                               $tCobroDistri=(($row_Recordset1['total_venta']-$row_Recordset1['tot_eliminad'])*$porAgente)/100;
                               $ventaDis=$ventaDis+$row_Recordset1['total_venta'];
                               $totalPreDis=$totalPreDis+$row_Recordset1['tot_premios'];
                               $totAnulaDis=$totAnulaDis+$row_Recordset1['tot_eliminad'];
                               $totCajaDis=$totCajaDis+$totCajaAge;
                               $porPagarDis=$porPagarDis+$porPagarAgente;
                               $ganPerDis=$ganPerDis+$ganPerAge;
                               $porDis=$porDis+$porAgente;
                               $tDis=$tDis+$tCobroDistri; ?>
								<tr style="background: #FFF; color: #000;" valign="middle" align="right"
                                	onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"
                                    title="<?php echo "Agente: ".$nomAgente ?>">
									<td width="145" align="left"><?php echo $nomAgente ?></td>
									<td width="83">
									<?php echo number_format($row_Recordset1['total_venta'], 2, ",", "."); ?>
                                    </td>
									<td width="94">
									<?php echo number_format($row_Recordset1['tot_premios'], 2, ",", "."); ?>
                                    </td>
									<td width="95">
									<?php echo number_format($row_Recordset1['tot_eliminad'], 2, ",", "."); ?>
                                    </td>
									<td width="95"><?php echo number_format($totCajaAge, 2, ",", "."); ?></td>
									<td width="95"><?php echo number_format($porPagarAgente, 2, ",", "."); ?></td>
									<td width="95"><?php echo number_format($ganPerAge, 2, ",", "."); ?></td>
									<td width="69"><?php echo number_format($porAgente, 2, ",", "."); ?></td>
									<td width="112"><?php echo number_format($tCobroDistri, 2, ",", "."); ?></td>
								</tr>
								<?php
                           }
                       } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
                       $totVentDiSistema=$ventaDis-$totAnulaDis;
                       $cobroSistemaDis=($totVentDiSistema*$porBanca)/100;
                       $totalGananciaDis=$tDis-$cobroSistemaDis;
                       $totalGenDi=$totalGenDi+$totalGananciaDis;
                       $totalSistema=$cobroSistemaDis+$totalSistema; ?>
						<tr style="background: #CCC; color: #000; font-size:14px" valign="middle" align="right">
							<td width="145" height="36" valign="bottom"><strong>TOTALES:</strong></td>
							<td width="83" valign="bottom"><strong>
							<?php echo number_format($ventaDis, 2, ",", "."); ?></strong>
                            </td>
							<td width="94" valign="bottom"><strong>
							<?php echo number_format($totalPreDis, 2, ",", "."); ?></strong></td>
							<td width="95" valign="bottom"><strong>
							<?php echo number_format($totAnulaDis, 2, ",", "."); ?></strong></td>
							<td width="95" valign="bottom"><strong>
							<?php echo number_format($totCajaDis, 2, ",", "."); ?></strong></td>
							<td width="95" valign="bottom"><strong>
							<?php echo number_format($porPagarDis, 2, ",", "."); ?></strong></td>
							<td width="95" valign="bottom"><strong><?php echo number_format($ganPerDis, 2, ",", "."); ?></strong></td>
							<td width="69" valign="bottom"><strong><?php echo number_format($porDis, 2, ",", "."); ?></strong></td>
							<td width="112" valign="bottom"><strong><?php echo number_format($tDis, 2, ",", "."); ?></strong></td>
		  				</tr>
						<tr>
							<td height="30" colspan="9" style="background: #333;font-size:20px; color:#FFF">
                            COSTO DEL SISTEMA AL 
							<?php echo number_format($porBanca, 2, ",", ".")."% - Distribuidor: ".$row_Recordset10['nom_banca']; ?>
                            </td>
						</tr>          
						<tr style="background: #333; color:#FFF; font-size:14px" valign="middle" align="center">
							<td>TOTAL VENTAS</td>
							<td colspan="2">TOTAL ANULADOS</td>
						  <td colspan="2">TOTAL GENERAL</td>
							<td colspan="2" bgcolor="#60c6cf" style="color:#FFFFFF">TOTAL A COBRAR POR SISTEMA A DISTRIBUIDOR</td>
							<td colspan="2" bgcolor="#9999CC" style="color:#FFFFFF">GANANCIA DEL DISTRIBUIDOR</td>
						</tr>
						<tr style="background: #FFF; color: #000; font-size:16px;" valign="middle" align="right">
							<td><strong><?php echo number_format($ventaDis, 2, ",", "."); ?></strong></td>
							<td colspan="2"><strong><?php echo number_format($totAnulaDis, 2, ",", "."); ?></strong></td>
						  <td colspan="2"><strong><?php echo number_format($totVentDiSistema, 2, ",", "."); ?></strong></td>
							<td colspan="2" bgcolor="#60c6cf">
                            	<strong><?php echo number_format($cobroSistemaDis, 2, ",", "."); ?></strong>
                            </td>
							<td colspan="2" bgcolor="#9999CC">
                            	<strong><?php echo number_format($totalGananciaDis, 2, ",", "."); ?></strong>
                            </td>
						</tr>
						<tr>
							<td height="7" colspan="9" style="background:#FFFFFF"></td>
						</tr>
						<tr>
							<td height="57" colspan="9"></td>
						</tr>
						<?php
                   } else {// no existen registros en distribuidor
                        ?>
                        <tr align="left">
                            <td height="66" colspan="9" valign="top" style="background:#FFFFFF; color:#000; font-size:24px">
                            NO EXISTEN DATOS
                            </td>
          				</tr><?php
                    }
               } while ($row_Recordset10 = mysqli_fetch_assoc($Recordset10)); ?>
				<tr>
					<td height="37" colspan="9"><hr/></td>
				</tr>
				<tr style="background: #333; color:#FFF; font-size:14px" valign="middle" align="center">
				  <td colspan="5" style="font-size:24px">TOTAL GENERAL COBRO DE SISTEMA</td>
					<td colspan="2" bgcolor="#FF3366" style="color:#FFF">TOTAL A COBRAR POR SISTEMA A DISTRIBUIDORES</td>
					<td colspan="2" bgcolor="#333" style="color:#FFF">GANANCIA DE DISTRIBUIDORES</td>
				</tr>
		  <tr style="background: #FFF; color: #000; font-size:24px;" valign="middle" align="right" height="37">
					<td colspan="5"></td>
			  <td colspan="2" bgcolor="#FF3366" style="color:#FFF">
               	  <?php echo number_format($totalSistema, 2, ",", "."); ?>
           	  </td>
			  <td colspan="2" bgcolor="#333" style="color:#FFF">
               	  <?php echo number_format($totalGenDi, 2, ",", "."); ?>
			  </td>
		  </tr>
				<?php
           } else {?>
		  <tr align="left">
					<td height="40" colspan="9" style="background: #333; color:#FFF; font-size:24px">NO EXISTEN DATOS</td>
		  </tr><?php
            }
            ?>
	</table>	
</div><!-- end .mostrar -->
<span class="boton-top" title="ir arriba">▲</span>
</div>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});document.getElementById('ganSis').innerHTML = "<?php echo number_format($totalSistema, 2, ",", "."); ?>";document.getElementById('ganDis').innerHTML = "<?php echo number_format($totalGenDi, 2, ",", "."); ?>";</script>
<?php
mysqli_free_result($Recordset2);
if (isset($Recordset1)) {
    mysqli_free_result($Recordset1);
}
?>  	
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
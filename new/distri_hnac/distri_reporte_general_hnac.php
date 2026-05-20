<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset12 = sprintf(
    "/* PARSEADORES1 new\distri_hnac\distri_reporte_general_hnac.php - QUERY 1 */ SELECT por_banca_hnac FROM banca WHERE cod_banca = %s LIMIT 1",
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 new\distri_hnac\distri_reporte_general_hnac.php - QUERY 2 */ SELECT * 
	FROM 
		agencia
	WHERE
		agencia.cod_banca = %s
	ORDER BY agencia.nom_agencia ASC",
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
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
            if ($_POST['id_agencia']!="todos") {
                $query_Recordset3 = sprintf(
                    "/* PARSEADORES1 new\distri_hnac\distri_reporte_general_hnac.php - QUERY 3 */ SELECT * 
					FROM 
						agencia 
					WHERE 
						cod_agencia = %s",
                    GetSQLValueString($_POST['id_agencia'], "int")
                );
                $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
            }
        }
    }
}
$query_Recordset2 = sprintf(
    "/* PARSEADORES1 new\distri_hnac\distri_reporte_general_hnac.php - QUERY 4 */ SELECT * 
	FROM 
		agencia
	WHERE
		agencia.cod_banca = %s
	ORDER BY agencia.nom_agencia ASC",
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
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
</script>
	<style>
	.boton-top{
		display: none;
		position:fixed;
		bottom:0;
		right:0;
		width:50px;
		height: 50px;
		text-align:center;
		line-height:50px;
		color:#fff;
		background: #F93;
		cursor:pointer;
	}
	</style>
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
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabeceradistri_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              REPORTE SOLO NACIONALES
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
                 Agentes:
             <select name="id_agencia" id="soflow" style="height:40px; width:320px; margin:-9px 0px 0px 0px ">
                      <option value="todos" >TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset2['cod_agencia']?>"><?php echo strtoupper($row_Recordset2['nom_agencia']); ?>
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
   <div style="background:#333; width:915px; float:left; padding:12px 13px 0px 12px;
      color:#FFFFFF; font-size:20px;">
   <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo ""; ?></div>
   </div><!-- end .container -->
	<div>
    	             
	</div>
   
   <div id="mostrar" style="width:99.7%; float:left; padding:0px 0px 150px 3px; background: #CCC">
   	   	
			<?php
            $totVentaBanca=0;
            $totAnulaBanca=0;
            $totVentaTaq=0;
            $totPremiTaq=0;
            $totPTaqPpag=0; //total premios pendientes x taquilla
            $totAnulaTaq=0;
            $subTotVenta=0;
            $subTotPremi=0;
            $subPTaqPpag=0; //subtotal premios pendientes general
            $subTotAnula=0;
            $subTotTaquilla=0;
            $totGanPerTaq=0;
            $subGenGanPerTaq=0;
            $totCobraBanca=0;
            $tVe=0;
            $tPr=0;
            $tAn=0;
            $tTc=0;
            $tPp=0;
            $Tge=0;
           if ($totalRows_Recordset3>0) {
               do {
                   $codigoAgente=$row_Recordset3['cod_agencia']; ?>
       			<table width="100%" border="1" style="color:#000; font-size:11px" bordercolor="#F5F5F5" cellpadding="0" 
                	cellspacing="0">
                    <tr style="background:#333; color:#FFF; border-color:#333" valign="middle" align="center">
                        <td height="35" colspan="12" align="left" style="font-size:18px">
                            <strong>
                            <?php
                            echo $row_Recordset3['nom_agencia']." | Teléfono: ".$row_Recordset3['tel_agencia']." ";
                   echo "| Correo: ".$row_Recordset3['cor_agencia']; ?>
                        </strong></td>
                    </tr>
          			<tr style="background:#0E5157; color:#FFF; font-size:9px; line-height:10px" valign="middle" align="center">
                        <td width="12%">TAQUILLA</td>
                        <td width="10%">VENTAS</td>
                        <td width="10%">PREMIOS PAGADOS</td>
                        <td width="8%">ANULADOS PAGADOS</td>
                        <td width="10%">TOTAL EN CAJA</td>
                        <td width="10%">PREMIOS POR PAGAR</td>
                        <td width="8%">ANULADOS POR PAGAR</td>
                        <td width="10%">TOTAL<span style="font-size:8px"><br/>
                          INCLUYE TICKETS POR PAGAR</span></td>
                        <td width="10%">CANTIDAD TICKET<br/>
                          ELIMINADOS</td>
                        <td width="12%"></td>
                    </tr>
					<?php
                    $query_Recordset1 = sprintf(
                       "/* PARSEADORES1 new\distri_hnac\distri_reporte_general_hnac.php - QUERY 5 */ SELECT
						ta.cod_taquilla, 
						ta.nom_taquilla, 
						tp.por_alquiler_hanc,
						ag.por_agencia_hnac,
						SUM(CASE WHEN ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s 
							THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
						SUM(CASE WHEN ve.est_ticket_hnac = 2 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
							THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
						SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
							THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
						SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s 
							THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagos,
						SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
							THEN ve.mon_venta_hnac ELSE 0 END) AS ret_total,
						SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND ve.fec_venta_hnac >= %s AND
							ve.fec_venta_hnac <= %s 
							THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagar,
						SUM(CASE WHEN ve.est_ticket_hnac = 5 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
							THEN ve.mon_venta_hnac ELSE 0 END) AS inv_pagos,
						SUM(CASE WHEN ve.est_calculo_hnac = 5 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
							THEN ve.mon_venta_hnac ELSE 0 END) AS inv_total,
						SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 5 AND ve.fec_venta_hnac >= %s AND
							ve.fec_venta_hnac <= %s 
							THEN ve.mon_venta_hnac ELSE 0 END) AS inv_porpagar,
						SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 2 AND ve.fec_venta_hnac >= %s AND
							ve.fec_venta_hnac <= %s 
							THEN ve.pag_premio_hnac ELSE 0 END) AS pre_porpagar,
						SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s AND
							ve.lin_ticket_hnac = 1
							THEN 1 ELSE 0 END) AS con_tic_eli
					FROM
						agencia ag, taquilla ta, taquilla_opc_hnac tp, venta_hnac ve, usuario us
					WHERE (ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s OR ve.fec_pago_hnac >= %s AND 
						ve.fec_pago_hnac <= %s) AND 
						ta.cod_agencia = ag.cod_agencia AND 
						
						
						
						us.id_usuario = ve.id_usuario AND
						ta.cod_taquilla = us.cod_taquilla AND
						
						tp.cod_taquilla = ta.cod_taquilla AND 
						ag.cod_agencia = %s 
					GROUP BY ta.cod_taquilla 
					ORDER BY ta.cod_taquilla, ve.fec_venta_hnac, ve.num_ticket_hnac ASC",
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
                       GetSQLValueString($in, "date"),
                       GetSQLValueString($fi, "date"),
                       GetSQLValueString($in, "date"),
                       GetSQLValueString($fi, "date"),
                       GetSQLValueString($in, "date"),
                       GetSQLValueString($fi, "date"),
                       GetSQLValueString($codigoAgente, "int")
                   );
                    
                    
                   $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                   $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                   $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                   $porcentaje=$row_Recordset1['por_agencia_hnac'];
                   $totVentaTaq=0;
                   $totPremiTaq=0;
                   $totPTaqPpag=0; //total premios pendientes x taquilla
                   $totAnulaTaq=0;
                   $subTotVenta=0;
                   $subTotPremi=0;
                   $subPTaqPpag=0; //subtotal premios pendientes general
                   $subTotAnula=0;
                   $subTotTaquilla=0;
                   $totGanPerTaq=0;
                   $subGenGanPerTaq=0;
                   $subTotAnupPagar=0;
                   $subTotEliminados=0;
                   $subTotCantEli=0;
                   $cobroAgente=0;
                   $eliminadosAgente=0;
                   if ($totalRows_Recordset1>0) {
                       do {
                           $porTaquilla=$row_Recordset1['por_alquiler_hanc'];
                           $nom=$row_Recordset1['nom_taquilla'];
                           $totVentaTaq=$row_Recordset1['total_venta'];
                           $totPremiTaq=$row_Recordset1['tot_premios'];
                           $totAnulaTaq=$row_Recordset1['ret_pagos']+$row_Recordset1['inv_pagos']+$row_Recordset1['tot_eliminad'];
                           $porPagarEliTaq=$row_Recordset1['ret_porpagar']+$row_Recordset1['inv_porpagar'];
                           $totPTaqPpag=$row_Recordset1['pre_porpagar'];
                           $totTaquilla=$totVentaTaq-($totPremiTaq+$totAnulaTaq);
                           $totGanPerTaq=$totTaquilla-$totPTaqPpag-$porPagarEliTaq;
                            
                           $totalAnulados=$row_Recordset1['ret_total']+$row_Recordset1['inv_total']+$row_Recordset1['tot_eliminad'];
                           $tCobroAgente=(($totVentaTaq-$totalAnulados)*$porTaquilla)/100;
                           if ($totVentaTaq!=0 or $totPremiTaq!=0 or $totAnulaTaq!=0 or $totTaquilla!=0 or $totPTaqPpag!=0 or
                                $porPagarEliTaq!=0 or $totGanPerTaq!=0 or $tCobroAgente!=0) {?>
					 			<tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" height="20" 
									style="background:# FFF; font-size:11px">
								<td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $nom ?></td>
								<td align="right" valign="middle" bgcolor="#FFFFFF">
								<?php echo number_format($totVentaTaq, 2, ",", "."); ?>
								</td>
								<td align="right" valign="middle" bgcolor="#FFFFFF">
								<?php echo number_format($totPremiTaq, 2, ",", "."); ?>
								</td>
								<td align="right" valign="middle" bgcolor="#FFFFFF">
								<?php echo number_format($totAnulaTaq, 2, ",", "."); ?>
								</td>
								<td align="right" valign="middle" bgcolor="#FFFFFF">
								<?php echo number_format($totTaquilla, 2, ",", "."); ?>
								</td>
								<td align="right" valign="middle" bgcolor="#FFFFFF">
								<?php echo number_format($totPTaqPpag, 2, ",", "."); ?>
								</td>
								<td align="right" valign="middle" bgcolor="#FFFFFF">
								<?php echo number_format($porPagarEliTaq, 2, ",", "."); ?>
								</td>
								<td align="right" valign="middle" bgcolor="#FFFFFF">
                                <?php echo number_format($totGanPerTaq, 2, ",", "."); ?>
                                </td>
								<td align="right" valign="middle" bgcolor="#FFFFFF"><?php
                                $tot=$row_Recordset1['con_tic_eli']*1;
                                echo "(".$tot.") ".number_format($row_Recordset1['tot_eliminad'], 2, ",", "."); ?>
                                </td>
								<td align="right" valign="middle" bgcolor="#FFFFFF">
                                </td>
							  </tr><?php
                            }
                           $tVe=$tVe+$totVentaTaq;
                           $tPr=$tPr+$totPremiTaq;
                           $tAn=$tAn+$totAnulaTaq;
                           $tTc=$tTc+$totTaquilla;
                           $tPp=$tPp+$totPTaqPpag;
                           $Tge=$Tge+$totGanPerTaq;
                           $subTotEliminados=$subTotEliminados+$row_Recordset1['tot_eliminad'];
                           $subTotCantEli=$subTotCantEli+$tot;
                           $subTotAnupPagar=$subTotAnupPagar+$porPagarEliTaq;
                           $subTotVenta=$subTotVenta+$totVentaTaq;
                           $subTotPremi=$subTotPremi+$totPremiTaq;
                           $subTotAnula=$subTotAnula+$totAnulaTaq;
                           $subTotTaquilla=$subTotTaquilla+$totTaquilla;
                           $subPTaqPpag=$subPTaqPpag+$totPTaqPpag;
                           $subGenGanPerTaq=$subGenGanPerTaq+$totGanPerTaq;
                           $cobroAgente=$cobroAgente+$tCobroAgente;
                           $eliminadosAgente=$eliminadosAgente+$totalAnulados;
                       } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
						<tr>
						  <td colspan="5">&nbsp;</td>
						</tr>
						<tr bgcolor="#999999" style="font-size:12px;">
						  <td height="35" align="right" valign="middle"><strong>TOTALES:</strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($subTotVenta, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($subTotPremi, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($subTotAnula, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($subTotTaquilla, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($subPTaqPpag, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($subTotAnupPagar, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($subGenGanPerTaq, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo "(".$subTotCantEli.") ".number_format($subTotEliminados, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          </td>
						</tr>
						<?php
                   } ?>  
				   </table>
      			 
      			   <div id="costo1" style="width:100%; float:left; padding:0px 0px 0px 0px">
					   <table width="934" border="0" style="color:#000; font-size:16px" bordercolor="#F5F5F5">
						  <tr style="background:#5EAEFF; color:#FFF" valign="middle" align="center">
							<td width="348" height="46" bgcolor="#333">TOTAL VENTAS</td>
							<td width="180" bgcolor="#333">TOTAL  ANULADOS </td>
							<td width="167" bgcolor="#333">TOTAL</td>
							<td width="218" bgcolor="#FF3366"></td>
						  </tr>
						  <tr style="background: #999; color:# 000" valign="middle" align="center">
							<td align="right" valign="middle" bgcolor="#FFFFFF">
                            	<strong><?php echo number_format($subTotVenta, 2, ",", "."); ?></strong>
                            </td>
							<td align="right" valign="middle" bgcolor="#FFFFFF">
                            	<strong><?php echo number_format($subTotAnula, 2, ",", "."); ?></strong>
                            </td>
							<td align="right" valign="middle" bgcolor="#FFFFFF">
                            	<strong><?php echo number_format($totSistema, 2, ",", "."); ?></strong><strong></strong>
                            </td>
							<td align="right" valign="middle" bgcolor="#FF3366" style="color:#FFF; font-size:20px">
                            	<strong><?php echo number_format($totalPagarSistema, 2, ",", "."); ?></strong>
                            </td>
						  </tr>
						  <tr bgcolor="#999" style="font-size:28px;">
							<td height="63" colspan="6" align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
						  </tr>
                      </table>    
				<?php
               } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3)); ?>
                <HR/>
	    <div style="background: #FF9; width:910px; float:left; padding:12px 13px 2px 12px;font-size:20px; color:#000">
					<strong></strong>
          </div>
				   <div id="costo2" style="width:100%; float:left; padding:0px 0px 0px 0px">
					   <table width="934" border="0" style="color:#000; font-size:16px" bordercolor="#F5F5F5">
						  <tr style="background:#5EAEFF; color:#000" valign="middle" align="center">
							<td width="348" bgcolor="#FF9"><strong>TOTAL VENTAS</strong></td>
							<td width="180" bgcolor="#FF9"><strong>TOTAL  ANULADOS</strong> </td>
							<td width="167" bgcolor="#FF9"><strong>TOTAL</strong></td>
							<td width="218" bgcolor="#FF3366" style="color:#FFFFFF"></td>
					     </tr>
						  <tr style="background: #999; color:# 000" valign="middle" align="center">
							<td align="right" valign="middle" bgcolor="#FFFFFF">
                            	<strong><?php echo number_format($totVentaBanca, 2, ",", "."); ?></strong>
                            </td>
							<td align="right" valign="middle" bgcolor="#FFFFFF">
                            	<strong><?php echo number_format($totAnulaBanca, 2, ",", "."); ?></strong>
                            </td>
							<td align="right" valign="middle" bgcolor="#FFFFFF">
                            	<strong><?php echo number_format($totGenBanca, 2, ",", "."); ?></strong><strong></strong>
                            </td>
							<td align="right" valign="middle" bgcolor="#FF3366" style="color:#FFF; font-size:20px">
                            	<strong><?php echo number_format($totCobraBanca, 2, ",", "."); ?></strong>
                            </td>
						  </tr>
						  <tr bgcolor="#999" style="font-size:28px;">
							<td height="20" colspan="6" align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
						  </tr>
                      </table>
                   </div>       
      			   <div style="background: #333; width:910px; float:left; padding:12px 13px 2px 12px;color:#FFF; 
                   	font-size:20px; color:#FFF">
        </div>
				   <div id="costo3" style="width:100%; float:left; padding:0px 0px 0px 0px">
					 					  <HR/>
                        <table width="100%" border="0" style="font-size:16px; background:#5EAEFF">
                          <tr style="color:#FFF">
                            <td colspan="6" align="center" bgcolor="#333">&nbsp;</td>
                          </tr>
                          <tr style="color:#FFF">
                            <td width="16%" align="center" bgcolor="#333">TOTAL VENTAS</td>
                            <td width="16%" align="center" bgcolor="#333">TOTAL PREMIOS</td>
                            <td width="16%" align="center" bgcolor="#333">TOTAL ANULADOS</td>
                            <td width="16%" align="center" bgcolor="#333">TOTAL EN CAJA</td>
                            <td width="16%" align="center" bgcolor="#333">TOTAL POR PAGAR</td>
                            <td width="20%" align="center" bgcolor="#333">TOTAL INCLUYE TICKET POR PAGAR</td>
                          </tr>
                          <tr height="32" style="color:#000; font-size:18px">
                            <td height="54" align="right" valign="top" bgcolor="#FFFFFF"><strong><em><?php echo number_format($tVe, 2, ",", "."); ?></em></strong></td>
                            <td align="right" valign="top" bgcolor="#FFFFFF"><strong><em><?php echo number_format($tPr, 2, ",", "."); ?></em></strong></td>
                            <td align="right" valign="top" bgcolor="#FFFFFF"><strong><em><?php echo number_format($tAn, 2, ",", "."); ?></em></strong></td>
                            <td align="right" valign="top" bgcolor="#FFFFFF"><strong><em><?php echo number_format($tTc, 2, ",", "."); ?></em></strong></td>
                            <td align="right" valign="top" bgcolor="#FFFFFF"><strong><em><?php echo number_format($tPp, 2, ",", "."); ?></em></strong></td>
                            <td align="right" valign="top" bgcolor="#FFFFFF"><strong><em><?php echo number_format($Tge, 2, ",", "."); ?></em></strong></td>
                          </tr>
                        </table>
                      
		  </div><?php
           } else {?>
           		<table width="941" border="1" style="color:#000; font-size:16px" bordercolor="#F5F5F5">
                    <tr align="left">
                        <td height="40" colspan="9" style="background: #FFF; color:#000; font-size:24px">NO EXISTEN DATOS</td>
                    </tr>
                </table><?php
           }
            ?>
</div>			
</div><!-- end .mostrar -->
<span class="boton-top" title="ir arriba">▲</span>
</div>
	<script>
	$(window).scroll(function(){
	    if ($(this).scrollTop() > 0) {
	        $('.boton-top').fadeIn();
	    } else {
	        $('.boton-top').fadeOut();
	    }
	});

	$('.boton-top').click(function(){
	    $(document.body).animate({scrollTop : 0}, 500);
	    return false;
	});
document.getElementById('ganSis').innerHTML = "<?php echo number_format($cobroaBanca, 2, ",", "."); ?>";document.getElementById('ganDis').innerHTML = "<?php echo number_format($ganBanca, 2, ",", "."); ?>";	
	</script>

<?php
if (isset($Recordset1)) {
                mysqli_free_result($Recordset1);
            }
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
if (isset($Recordset3)) {
    mysqli_free_result($Recordset3);
}
if (isset($Recordset12)) {
    mysqli_free_result($Recordset12);
}

?>  	
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$codigoAgente=$_SESSION['MM_cod_agente'];
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
                    "/* PARSEADORES1 agente\agente_reporte_vendedores.php - QUERY 1 */ SELECT ta.cod_taquilla, ta.nom_taquilla, ta.tel_taquilla, ta.taq_por_ame, 
				ag.agen_por_ame
				FROM taquilla ta, taquilla_opc_ame tp, agencia ag 
				WHERE ta.cod_taquilla = %s AND ta.cod_agencia = %s AND tp.cod_taquilla = ta.cod_taquilla AND
					ag.cod_agencia = ta.cod_agencia",
                    GetSQLValueString($_POST['id_distribuidor'], "int"),
                    GetSQLValueString($codigoAgente, "int")
                );
                $v=1;
            }
        }
    }
}
if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && $_POST['id_distribuidor']=="todos") ||
    !isset($_POST["MM_update"])) {
    $query_Recordset10 = sprintf(
        "/* PARSEADORES1 agente\agente_reporte_vendedores.php - QUERY 2 */ SELECT ta.cod_taquilla, ta.nom_taquilla, ta.tel_taquilla, ta.taq_por_ame, ag.agen_por_ame
	FROM taquilla ta, taquilla_opc_ame tp, agencia ag WHERE tp.cod_taquilla = ta.cod_taquilla AND ta.cod_agencia = %s AND
		ag.cod_agencia = ta.cod_agencia",
        GetSQLValueString($codigoAgente, "int")
    );
    $v=0;
}
$Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
$row_Recordset10 = mysqli_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysqli_num_rows($Recordset10);
if (isset($v) && $v==1) {
    $nomb=$row_Recordset10['nom_taquilla'];
} else {
    $nomb="TODOS";
}

$query_Recordset2 = sprintf(
    "/* PARSEADORES1 agente\agente_reporte_vendedores.php - QUERY 3 */ SELECT cod_taquilla, nom_taquilla FROM taquilla WHERE cod_agencia = %s ORDER BY nom_taquilla",
    GetSQLValueString($codigoAgente, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
//echo $row_Recordset10['agen_por_ame']." / ".$row_Recordset10['taq_por_ame'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<link rel="shortcut icon" href="../images/favicon.ico">
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
			<?php include("../includes/cabeceraamericana_ag.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
					<?php include("../includes/cabeceraagente.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                <?php echo "AGENTE: ".$_SESSION['MM_nom_agente'] ?><br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  <div style="height:100%; font-size:26px; padding:50px 0px 100px 0px ">
		<div style="background:#0088B9; width:100%; float:left; padding:40px 2px 10px 2px;
				color:#FFF; font-size:28px; text-align:center">
				REPORTE DETALLADO POR VENDEDOR SOLO AMERICANAS
        </div>
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
                 Taquillas:
             <select name="id_distribuidor" id="soflow" style="height:40px; width:360px; margin:-9px 0px 0px 0px ">
                      <option value="todos" >TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset2['cod_taquilla']?>"
               <?php if ($row_Recordset2['nom_taquilla']==$nomb) {
                        echo "SELECTED";
                    } ?>>
			   <?php echo strtoupper($row_Recordset2['nom_taquilla']); ?>
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
	<div style="background:#333; width:915px; float:left; padding:12px 13px 0px 12px;color:#FFFFFF; font-size:20px;">
		<div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo ""; ?></div>
	</div><!-- end .container -->
	<div>
		<table width="100%" border="0" style="color:#000; font-size:12px;">
			<tr style="font-size:14px" valign="middle" align="center">
				<td width="457" style="font-size:24px">&nbsp;</td>
			</tr>
		  <tr style="background: #FFF; color: #000; font-size:24px;" valign="middle" align="right" height="37">
				<td></td>
			  <td colspan="-2" bgcolor="#FF3366" style="color:#FFF">
				</td>
			  <td colspan="2" bgcolor="#333" style="color:#FFF">
			</td>
			<tr style="font-size:7px" valign="middle" align="center">
				  <td colspan="5" style="font-size:24px">&nbsp;</td>
		  </tr>
		</table>              
	</div>
	<div id="mostrar" style="width:99.7%; float:left; padding:0px 0px 150px 3px; background: #CCC">
		<table width="100%" border="0" style="color:#000; font-size:11px;" cellpadding="0" cellspacing="0"><?php
            $totalSistema=0;
            $totalGenDi=0;
            $porBanca=$row_Recordset10['agen_por_ame'];
            if ($totalRows_Recordset10>0) {
                do {
                    $ventaDis=0;
                    $totalPreDis=0;
                    $totAnulaBan=0;
                    $totAnulaDis=0;
                    $totCajaDis=0;
                    $porPagarDis=0;
                    $ganPerDis=0;
                    $porDis=0;
                    $tDis=0;
                    $porDis=0;
                    $porPagarAnuDis=0; ?>
					<tr style="background:#CCC; color:#333; border-color:#333" valign="middle" align="center">
						<td height="35" colspan="10" align="left" style="font-size:18px"><?php
                            echo "<strong>".$row_Recordset10['nom_taquilla']."</strong>";
                    echo "| Teléfono: ".$row_Recordset10['tel_taquilla']; ?>
					    </td>
					</tr>
                    <tr style="background:#0088B9; color:#FFFFFF; border-color:#5EAEFF; font-size:10px; line-height:10px" 
                    	valign="middle" align="center">
						<td width="14%" height="35">VENDEDORES</td>
					  <td width="10%">VENTAS</td>
						<td width="10%">PREMIOS PAGADOS</td>
						<td width="8%">ANULADOS PAGADOS</td>
					  <td width="10%">TOTAL EN CAJA</td>
						<td width="10%">PREMIOS POR PAGAR</td>
						<td width="8%">ANULADOS POR PAGAR</td>
					  <td width="10%">TOTAL + TICKETS POR PAGAR</td>
					  <td width="8%">CANTIDAD TICKET <BR/>ELIMINADOS</td>
					  <td width="12%">TOTAL A COBRAR AGENTE</td>
                    </tr><?php
                    $codBanca=$row_Recordset10['cod_taquilla'];
                    $query_Recordset3 = sprintf("/* PARSEADORES1 agente\agente_reporte_vendedores.php - QUERY 4 */ SELECT id_usuario, nom_usuario
						FROM usuario WHERE cod_taquilla = %s ORDER BY nom_usuario", GetSQLValueString($codBanca, "int"));
                    $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                    $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                    $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                    if ($totalRows_Recordset3>0) {
                        do {
                            $codAgencia=$row_Recordset3['id_usuario'];
                            $nomAgente=$row_Recordset3['nom_usuario'];
                            $query_Recordset1 = sprintf(
                                "/* PARSEADORES1 agente\agente_reporte_vendedores.php - QUERY 5 */ SELECT
								SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s 
									THEN ve.mon_venta ELSE 0 END) AS total_venta,
								SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s
									THEN ve.pag_premio ELSE 0 END) AS tot_premios,
								SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
									THEN ve.mon_venta ELSE 0 END) AS tot_eliminad,
								SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s 
									THEN ve.pag_premio ELSE 0 END) AS ret_pagos,
								SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
									THEN ve.pag_premio ELSE 0 END) AS ret_total,
								SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
									THEN ve.pag_premio ELSE 0 END) AS ret_porpagar,
								SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s
									THEN ve.pag_premio ELSE 0 END) AS inv_pagos,
								SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
									THEN ve.pag_premio ELSE 0 END) AS inv_total,
								SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
									THEN ve.pag_premio ELSE 0 END) AS inv_porpagar,
								SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
									THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
								SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
									THEN 1 ELSE 0 END) AS con_tic_eli
							FROM
								usuario us,
								venta ve
USE INDEX(id_us_fe_fe)
							WHERE
								us.id_usuario = %s AND ve.id_usuario = us.id_usuario AND
								(ve.fec_venta >= %s AND ve.fec_venta <= %s OR ve.fec_pago >= %s AND ve.fec_pago <= %s)",
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
                                GetSQLValueString($codAgencia, "int"),
                                GetSQLValueString($in, "date"),
                                GetSQLValueString($fi, "date"),
                                GetSQLValueString($in, "date"),
                                GetSQLValueString($fi, "date")
                            );
                            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                            $ventaAgente=$row_Recordset1['total_venta'];//total ventas
                            $totalPreAgente=$row_Recordset1['tot_premios'];//total premios
                            $totAnulaAge=$row_Recordset1['ret_pagos']+$row_Recordset1['inv_pagos']+$row_Recordset1['tot_eliminad'];//a
                            $totCajaAge=$ventaAgente-($totalPreAgente+$totAnulaAge);//total en caja
                            $porPagarAgente=$row_Recordset1['pre_porpagar'];//premios por pagar
                            $porPagarEliAgente=$row_Recordset1['ret_porpagar']+$row_Recordset1['inv_porpagar'];//anulados por pagar
                            $ganPerAge=$totCajaAge-$porPagarAgente-$porPagarEliAgente;//ganacias y perdidas
                            $porAgente=$row_Recordset10['taq_por_ame'];//porcentaje agente Pacificna
                            $totAnuAgente=$row_Recordset1['ret_total']+$row_Recordset1['inv_total']+$row_Recordset1['tot_eliminad'];
                            $tCobroDistri=(($ventaAgente-$totAnuAgente)*$porAgente)/100;//cobro del distribuidor al agente
                            if ($ventaAgente!=0 or $totalPreAgente!=0 or $totAnulaAge!=0 or $totCajaAge!=0 or $porPagarAgente!=0 or
                                $porPagarEliAgente!=0 or $ganPerAge!=0 or $tCobroDistri!=0) {?>
								<tr style="background: #FFF; color: #000;" valign="middle" align="right"
                                    onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"
                                    title="<?php echo "Usuario: ".$row_Recordset3['nom_usuario'] ?>">
                                    <td align="left"><?php echo $row_Recordset3['nom_usuario']; ?></td>
                                    <td><?php echo number_format($ventaAgente, 2, ",", "."); ?></td>
                                    <td><?php echo number_format($totalPreAgente, 2, ",", "."); ?></td>
                                    <td><?php echo number_format($totAnulaAge, 2, ",", "."); ?></td>
                                    <td><?php echo number_format($totCajaAge, 2, ",", "."); ?></td>
                                    <td><?php echo number_format($porPagarAgente, 2, ",", "."); ?></td>
                                    <td><?php echo number_format($porPagarEliAgente, 2, ",", "."); ?></td>
                                    <td><?php echo number_format($ganPerAge, 2, ",", "."); ?></td>
                                    <td><?php
                                        $tot=$row_Recordset1['con_tic_eli']*1;
                                        echo "(".$tot.") ".number_format($row_Recordset1['tot_eliminad'], 2, ",", "."); ?>
                                    	
                                    </td>
                                    <td><?php echo number_format($tCobroDistri, 2, ",", "."); ?></td>
                                </tr><?php
                            }
                            $ventaDis=$ventaDis+$ventaAgente; // total ventas distribuidor Pacificna
                            $totalPreDis=$totalPreDis+$totalPreAgente; // total prermios distribuidor Pacificna
                            $totAnulaBan=$totAnulaBan+$totAnuAgente; // total anulados distribuidor Pacificna
                            $totAnulaDis=$totAnulaDis+$totAnulaAge; // total anulados distribuidor Pacificna
                            $totCajaDis=$totCajaDis+$totCajaAge; // total en caja agente Pacificna
                            $porPagarDis=$porPagarDis+$porPagarAgente; // total por pagar distribuidor premios Pacificna
                            $porPagarAnuDis=$porPagarAnuDis+$porPagarEliAgente; // total anulados por pagar
                            $ganPerDis=$ganPerDis+$ganPerAge; // total ganancia distribuidor Pacificna
                            $porDis=$porDis+$tCobroDistri; // total sistema distribuidor Pacificna
                        } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
                        if (isset($Recordset1)) {
                            mysqli_free_result($Recordset1);
                        }
                        $totVentDiSistema=$ventaDis-$totAnulaBan;
                        $cobroSistemaDis=($totVentDiSistema*$porBanca)/100;
                        $totalGananciaDis=$porDis-$cobroSistemaDis;
                        $totalGenDi=$totalGenDi+$totalGananciaDis;
                        $totalSistema=$cobroSistemaDis+$totalSistema; ?>
                        <tr style="background: #CCC; color: #000; font-size:12px" valign="middle" align="right">
                            <td height="25" valign="bottom"><strong>TOTALES:</strong></td>
                            <td valign="bottom">
                                <strong><?php echo number_format($ventaDis, 2, ",", "."); ?></strong></td>
                            <td valign="bottom"><strong>
                                <?php echo number_format($totalPreDis, 2, ",", "."); ?></strong></td>
                            <td valign="bottom"><strong>
                                <?php echo number_format($totAnulaDis, 2, ",", "."); ?></strong></td>
                            <td valign="bottom"><strong>
                                <?php echo number_format($totCajaDis, 2, ",", "."); ?></strong></td>
                            <td valign="bottom"><strong>
                                <?php echo number_format($porPagarDis, 2, ",", "."); ?></strong></td>
                            <td valign="bottom"><strong>
                                <?php echo number_format($porPagarAnuDis, 2, ",", "."); ?></strong></td>
                            <td valign="bottom">
                                <strong><?php echo number_format($ganPerDis, 2, ",", "."); ?></strong></td>
                            <td valign="bottom">&nbsp;</td>
                            <td valign="bottom">
                                <strong><?php echo number_format($porDis, 2, ",", "."); ?></strong></td>
                        </tr>
                        <tr>
                            <td height="30" colspan="10" style="background: #333;font-size:18px; color:#FFF">
                                COSTO DEL SISTEMA AL 
                                <?php echo number_format($porBanca, 2, ",", ".")."% - Taquilla: ".$row_Recordset10['nom_taquilla']; ?>
                            </td>
                        </tr>          
                        <tr style="background: #333; color:#FFF; font-size:12px" valign="middle" align="center">
                            <td>TOTAL VENTAS</td>
                            <td colspan="2">TOTAL ANULADOS</td>
                            <td colspan="2">TOTAL GENERAL</td>
                            <td colspan="3" bgcolor="#FFCC66" style="color:#000000">
                                TOTAL A COBRAR POR SISTEMA LA TAQUILLA
                            </td>
                            <td colspan="2" bgcolor="#99CC99" style="color:#000000">GANANCIA DEL AGENTE</td>
                        </tr><?php
                        $totVentDiSistema=$ventaDis-$totAnulaBan;
                        $cobroSistemaDis=($totVentDiSistema*$porBanca)/100;
                        $totalGananciaDis=$porDis-$cobroSistemaDis; ?>
                        <tr style="background: #FFF; color: #000; font-size:16px;" valign="middle" align="right">
                            <td><strong><?php echo number_format($ventaDis, 2, ",", "."); ?></strong></td>
                            <td colspan="2"><strong><?php echo number_format($totAnulaBan, 2, ",", "."); ?></strong></td>
                            <td colspan="2"><strong><?php echo number_format($totVentDiSistema, 2, ",", "."); ?></strong></td>
                            <td colspan="3" bgcolor="#FFCC66">
                                <strong><?php echo number_format($cobroSistemaDis, 2, ",", "."); ?></strong>
                            </td>
                            <td colspan="2" bgcolor="#99CC99">
                                <strong><?php echo number_format($totalGananciaDis, 2, ",", "."); ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td height="7" colspan="10" style="background:#FFFFFF"></td>
                        </tr>
                        <tr>
                            <td height="15" colspan="10" style="background:#FFFFFF"></td>
                        </tr><?php
                    } else {// no existen registros en distribuidor
                            ?>
                            <tr align="left">
                                <td height="36" colspan="10" valign="middle" style="background:#FFFFFF; color:#000; font-size:24px">
                                NO EXISTEN DATOS
                                </td>
          					</tr><?php
                        }
                } while ($row_Recordset10 = mysqli_fetch_assoc($Recordset10)); ?>
                    <tr>
                        <td height="17" colspan="10"><hr/></td>
                    </tr>
                    <tr style="background: #333; color:#FFF; font-size:14px" valign="middle" align="center">
                      
                    </tr>
              <tr style="background: #FFF; color: #000; font-size:24px;" valign="middle" align="right" height="37">
                <td colspan="4"></td>
              </tr><?php
            } else {?>
			<tr align="left">
				<td height="40" colspan="10" style="background: #333; color:#FFF; font-size:24px">NO EXISTEN DATOS</td>
			</tr><?php
            }?>
	</table>	
</div><!-- end .mostrar -->
<span class="boton-top" title="ir arriba">▲</span>
</div>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});document.getElementById('ganSis').innerHTML = "<?php echo number_format($totalSistema, 2, ",", "."); ?>";document.getElementById('ganDis').innerHTML = "<?php echo number_format($totalGenDi, 2, ",", "."); ?>";</script>
<?php
if (isset($Recordset2)) {
                mysqli_free_result($Recordset2);
            }
if (isset($Recordset3)) {
    mysqli_free_result($Recordset3);
}
if (isset($Recordset10)) {
    mysqli_free_result($Recordset10);
}
?>  	
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
echo 'v2<br>';
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$iniciod=fechaactualbd().' 00:00:01';
$finald=fechaactualbd().' 23:59:59';
$in=fechaymd($inicio); $fi=fechaymd($final);
$taquillaspar=0;
$ventasparleyBSS=0;
$totalusd=0;
$parleypagobusd=0;
$totalcop=0;
$parleypagobcop=0;
$p_total_sol=0;
$p_pago_sol=0;
$parleypagobss=0; 
$editFormAction = $_SERVER['PHP_SELF'];

$query_Recordset555 = sprintf("/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 1 */ SELECT * FROM tasadecambio WHERE Idtasadecambio = 1");
$Recordset555 = mysqli_query($conexionbanca, $query_Recordset555) or die(mysqli_error($conexionbanca));
$row_Recordset555 = mysqli_fetch_assoc($Recordset555);
$totalRows_Recordset555 = mysqli_num_rows($Recordset555);



if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$codigoAgente=$_SESSION['MM_cod_agente'];
$query_Recordset6 = sprintf("/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 2 */ SELECT cod_banca FROM agencia 
	WHERE cod_agencia = %s LIMIT 1", GetSQLValueString($codigoAgente, "int"));
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);
$banca=$row_Recordset6['cod_banca'];
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
        if ($_POST['fecha_inicio']!="" && $_POST['fecha_fin']!="") {
            if (strtotime(fechaymd($_POST['fecha_inicio'])) < strtotime(fechaymd($_POST['fecha_fin']))) {
                $inicio=$_POST['fecha_inicio'];
                $final=$_POST['fecha_fin'];
                $iniciod=$_POST['fecha_inicio'].' 00:00:01';
                $finald=$_POST['fecha_fin'].' 23:59:59';
            } else {
                $final=$_POST['fecha_inicio'];
                $inicio=$_POST['fecha_fin'];
                $iniciod=$_POST['fecha_inicio'].' 00:00:01';
                $finald=$_POST['fecha_fin'].' 23:59:59';
            }
            $in=fechaymd($inicio);
            $fi=fechaymd($final);
            if ($_POST['id_usuario']!="todos") {
                $query_Recordset3 = sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 3 */ SELECT
					ta.cod_taquilla, ta.nom_taquilla, ag.agen_por_ame, ag.agen_cob_hnac, ag.agen_por_parley, ag.agen_cob_hnac_tipo, ta.taq_cob_hnac_tipo, ta.taq_cob_hnac
				FROM
					agencia ag, taquilla ta
				WHERE 
					ag.cod_agencia = %s AND ta.cod_taquilla = %s",
                    GetSQLValueString($codigoAgente, "int"),
                    GetSQLValueString($_POST['id_usuario'], "int")
                );
                $v=1;
            }
        }
    }
}
if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && isset($_POST['id_usuario']) && $_POST['id_usuario']=="todos") || (!isset($_POST["MM_update"]))) {
    $query_Recordset3 = sprintf(
        "/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 4 */ SELECT
		ta.cod_taquilla, ta.nom_taquilla, ag.agen_por_ame, ag.agen_cob_hnac, ag.agen_por_parley, ag.agen_cob_hnac_tipo, ta.taq_cob_hnac_tipo, ta.taq_cob_hnac
	FROM
		agencia ag, taquilla ta
	WHERE 
	ag.cod_agencia = %s AND ta.cod_agencia = ag.cod_agencia",
        GetSQLValueString($codigoAgente, "int")
    );
    $vendedor="TODOS";
    $nomb="TODOS";
    $v=0;
}
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
if ($v==0 || !isset($v)) {
    $vendedor="TODOS";
    $nomb="TODOS";
} else {
    $vendedor="Taquilla: ".strtoupper($row_Recordset3['nom_taquilla']);
    $nomb=strtoupper($row_Recordset3['nom_taquilla']);
}
$query_Recordset4 = sprintf("/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 5 */ SELECT cod_taquilla, nom_taquilla FROM taquilla 
	WHERE taquilla.cod_agencia = %s ORDER BY taquilla.nom_taquilla", GetSQLValueString($codigoAgente, "int"));
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$query_Recordset5 = sprintf("/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 6 */ SELECT info1,info11,info2,info22,info3,info33,info4,info44,info5,info55 FROM banca 
	WHERE cod_banca = %s LIMIT 1", GetSQLValueString($banca, "int"));
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
$agen_cob_hnac=$row_Recordset3['agen_cob_hnac'];
$agen_por_parley=$row_Recordset3['agen_por_parley'];
$agen_cob_hnac_tipo=$row_Recordset3['agen_cob_hnac_tipo'];
$agen_cob_hnac=$row_Recordset3['agen_cob_hnac'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#9FBFD7" }
    function cambiacolor_over1(celda){ celda.style.backgroundColor="yellow" }    
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
	function cambiacolor_out2(celda){ celda.style.backgroundColor="#00BFFF" }
    function cambiacolor_out3(celda){ celda.style.backgroundColor="white" }
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
<style>.boton-top{display:none;position:fixed;bottom:0;right:0;width:40px;height:40px;text-align:center;line-height:40px;color:#fff;background:#F93;cursor:pointer;font-size:18px;}</style>
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
<?php
$query_Recordset44 = sprintf("/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 7 */ SELECT 
	me.mensaje
	FROM agencia ag, mensajesyalertas me 
	USE INDEX(mostrarhasta) 
	WHERE 
	(me.mostrarhasta >= CURDATE()) AND 
    ((tipo = 5 AND ag.cod_banca = me.para)  OR
	(tipo = 4 AND ag.cod_agencia = me.para)) 	
	AND ag.cod_banca = ag.cod_banca AND ag.cod_agencia = %s  
	
	ORDER BY RAND() LIMIT 1", GetSQLValueString($_SESSION['MM_cod_agente'], "int"));
$Recordset44 = mysqli_query($conexionbanca, $query_Recordset44) or die(mysqli_error($conexionbanca));
$row_Recordset44 = mysqli_fetch_assoc($Recordset44);
$totalRows_Recordset44 = mysqli_num_rows($Recordset44);
$mensaje44 = trim($row_Recordset44['mensaje']);
mysqli_free_result($Recordset44);
?>
<font size="6" style="color:red;" align="center"><?php echo $mensaje44;?></font><br/><br/>
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
				margin:20px 0px 0px 0px; width:240px; font-size:16px "> <?php echo "AGENTE: ".$_SESSION['MM_nom_agente'] ?><br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="height:100%; font-size:26px; padding:50px 0px 100px 0px ">
       <div style="background: #7DCEA0; width:100%; float:left; padding:40px 2px 10px 2px;
            color:#000; font-size:28px; text-align:center; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
            REPORTE GLOBAL DE VENTAS
       </div><!-- end .container -->
       <div style="background: #FFF; width:100%; float:left; padding:15px 0px 0px 10px;
            color:#000; font-size:20px; text-align: left;font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
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
             <select name="id_usuario" id="soflow" style="height:40px; width:280px; margin:-9px 0px 0px 0px ">
                      <option value="todos" >TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset4['cod_taquilla']?>"
               <?php if (strtoupper($row_Recordset4['nom_taquilla'])==$nomb) {
                        echo "SELECTED";
                    } ?>>
							 <?php echo strtoupper($row_Recordset4['nom_taquilla']); ?>
               </option>
                      <?php
                } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
                ?>
                    </select>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
       </div><!-- end .container -->
       <div style="background: #333; width:915px; float:left; padding:12px 13px 2px 12px;color:#FFF; font-size:20px;">
       	GANANCIA Y TOTAL A PAGAR POR EL SISTEMA  AGENTE AMERICANAS - NACIONALES
       </div>
	   <div>
		<table width="100%" border="0" style="color:#000; font-size:12px;" cellpadding="0" cellspacing="0">
			
                                <tr style="font-size:16px" valign="middle" align="center">
				<td width="32%" colspan="-2" bgcolor="#00FFFF" style="color:#333">
                     GANANCIA POR REVENTA<br/> DEL SISTEMA
					 						 <div id="totalganacia"></div>

                                              <?php
                                              $corbro= $row_Recordset3['agen_por_ame']*$row_Recordset555['usdabss'];
                                                       ?>


						 <div id="GanAgen"></div>
						 <div id="GanAgenusd"></div>
						 <div id="GanAgencop"></div>
						 <div id="GanAgensol"></div> 
                                </td>
				<td width="32%" colspan="-2" bgcolor="#333" style="color:#FFF"><br/>
                    AMERICANAS: <?php echo number_format($row_Recordset3['agen_por_ame'], 2, ",", ".")."%<br/>"; ?>
                    NACIONALES: <?php 
                    if($row_Recordset3['agen_cob_hnac_tipo']==0){ echo number_format($corbro, 2, ",", ".")." Bs/dia<br/>"; }
                    
                    if($row_Recordset3['agen_cob_hnac_tipo']==1){ echo number_format($row_Recordset3['agen_cob_hnac'], 2, ",", ".")."%<br/>";}
                    
                    ?>
                    PARLEY: <?php echo number_format($agen_por_parley, 2, ",", ".")."%<br/><br/><br/>"; ?>
					TASAS DE CAMBIO ACTUAL<br/>
					1 USD >> <?php echo number_format($row_Recordset555['usdabss'], 4, ",", ".")." BSS<br/>"; ?>
                    1 COP >> <?php echo number_format($row_Recordset555['copabss'], 4, ",", ".")." BSS<br/>"; ?>
                    1 SOL >> <?php echo number_format($row_Recordset555['solabss'], 4, ",", ".")." BSS<br/>"; ?>

				</td>
				<td width="32%" colspan="2" bgcolor="#FF3366" style="color:#FFF">
                    TOTAL A PAGAR<br/> POR EL SISTEMA
										<strong><div id="totalapagarusd"></div></strong>
                                        <strong><div id="totalapagarbss"></div></strong>
                                        <strong><div id="totalapagarcop"></div></strong>
                                        <strong><div id="totalapagarsol"></div></strong>
					<div id="pagAgen"></div>
					<div id="pagAgenusd"></div>
					<div id="pagAgencop"></div>
					<div id="pagAgensol"></div>	
                    <div id="totalanacionales"></div>
                    
                    
				</td>
			</tr>
			<tr style="background: #FFF; color: #000; font-size:14px;">
				<td  bgcolor="#00FFFF" style="color:#333; font-size:17px;" align="right">
                         
						 

                                </td>
				<td colspan="-2" bgcolor="#333" style="color:#FFF; font-size:14px;" align="center" height="27"></td>
				<td colspan="2" bgcolor="#FF3366" style="color:#FFF; font-size:17px;" align="right">

				</td>
			</tr>
			<tr style="font-size:7px" valign="middle" align="center">
				<td colspan="5" style="font-size:24px">&nbsp;</td>
			</tr>
		</table>              
      </div>
      <div style="background: #333; width:915px; float:left; padding:12px 13px 2px 12px;
            color:#FFF; font-size:20px;">
            <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo $vendedor; ?></div>
       </div><!-- end .container -->
       <div id="mostrar" style="width:100%; float:left; padding:0px 0px 150px 0px">
       <table width="100%" border="0" style="color:#000; font-size:11px" bordercolor="#F5F5F5" cellpadding="0" cellspacing="0">
          <tr style="background:#7DCEA0; color:#333; font-size:9px; line-height:10px" valign="middle" align="center">
           <td width="21%">TAQUILLA</td>
            <td width="8%">VENTAS</td>
            <td width="8%">PREMIOS <br/>PAGADOS</td>
            <td width="5%">ANULADOS <br/>PAGADOS</td>
            <td width="9%">TOTAL EN<br/> CAJA</td>
            <td width="6%">PREMIOS POR<br/> PAGAR</td>
            <td width="8%">ANULADOS POR<br/> PAGAR</td>
            <td width="9%">TOTAL INCLUYE <br/>TICKETS POR PAGAR</td>
            <td width="10%">CANTIDAD TICKET<br/>ELIMINADOS</td>
            <td width="19%">TOTAL A COBRAR A<br/> TAQUILLA AMERICANA (%)<br/> NACIONALES(X) TOTAL ( )</td>
          </tr>
        <?php
        
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
        $porTaquilla=0;
        $cobroAgente=0;
        $subTotAnupPagar=0;
        $subTotEliminados=0;
        $subTotCantEli=0;
        $eliminadosAgente=0;
        $subTotVentaA=0;
        $eliminadosAgenteA=0;
        $subCobroAgenteN=0;
        $tPuntosAg=0;
        $p_pago_bs=0;
        $p_pago_usd=0;
        $p_pago_cop=0;
        $p_pago_sol=0;
        $totVentaTaqNtotales=0;

        $totVentaTaqNtotalesusd=0;

        $totVentaTaqNtotalescop=0;

        $totVentaTaqNtotalessol=0;

        //usd
        
        $totVentaTaqusd=0;
        $totPremiTaqusd=0;
        $totPTaqPpagusd=0; //total premios pendientes x taquilla
        $totAnulaTaqusd=0;
        $subTotVentausd=0;
        $subTotPremiusd=0;
        $subPTaqPpagusd=0; //subtotal premios pendientes general
        $subTotAnulausd=0;
        $subTotTaquillausd=0;
        $totGanPerTaqusd=0;
        $subGenGanPerTaqusd=0;
        $porTaquillausd=0;
        $cobroAgenteusd=0;
        $subTotAnupPagarusd=0;
        $subTotEliminadosusd=0;
        $subTotCantEliusd=0;
        $eliminadosAgenteusd=0;
        $subTotVentaAusd=0;
        $eliminadosAgenteAusd=0;
        $subCobroAgenteNusd=0;
        $tPuntosAgusd=0;
        //usdfin
        
        
                                    
        
        //cop
        
        $totVentaTaqcop=0;
        $totPremiTaqcop=0;
        $totPTaqPpagcop=0; //total premios pendientes x taquilla
        $totAnulaTaqcop=0;
        $subTotVentacop=0;
        $subTotPremicop=0;
        $subPTaqPpagcop=0; //subtotal premios pendientes general
        $subTotAnulacop=0;
        $subTotTaquillacop=0;
        $totGanPerTaqcop=0;
        $subGenGanPerTaqcop=0;
        $porTaquillacop=0;
        $cobroAgentecop=0;
        $subTotAnupPagarcop=0;
        $subTotEliminadoscop=0;
        $subTotCantElicop=0;
        $eliminadosAgentecop=0;
        $subTotVentaAcop=0;
        $eliminadosAgenteAcop=0;
        $subCobroAgenteNcop=0;
        $tPuntosAgcop=0;
        //copfin
        
        
                                    
        
        //sol
        
        $totVentaTaqsol=0;
        $totPremiTaqsol=0;
        $totPTaqPpagsol=0; //total premios pendientes x taquilla
        $totAnulaTaqsol=0;
        $subTotVentasol=0;
        $subTotPremisol=0;
        $subPTaqPpagsol=0; //subtotal premios pendientes general
        $subTotAnulasol=0;
        $subTotTaquillasol=0;
        $totGanPerTaqsol=0;
        $subGenGanPerTaqsol=0;
        $porTaquillasol=0;
        $cobroAgentesol=0;
        $subTotAnupPagarsol=0;
        $subTotEliminadossol=0;
        $subTotCantElisol=0;
        $eliminadosAgentesol=0;
        $subTotVentaAsol=0;
        $eliminadosAgenteAsol=0;
        $subCobroAgenteNsol=0;
        $tPuntosAgsol=0;
        //solfin
        
        /*
        $row_Recordset1['est_calculo']==0 pendiente 
        $row_Recordset1['est_calculo']==1 perdedor
$row_Recordset1['est_ticket']==2 $estado="PAGO";
$row_Recordset1['est_ticket']==4 $estado="RETIRADO";
$row_Recordset1['est_ticket']==5) $estado="DEVOLUCION";
        */
        
        
        
        if ($totalRows_Recordset3>0) {
            do { // aqui comienzan las taquillas 
                $porcentaje=$row_Recordset3['agen_por_ame'];

                //select americanas in
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 8 */ SELECT
					ta.nom_taquilla, ta.taq_por_ame,
					ag.agen_por_ame,
					SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.mon_venta ELSE 0 END) AS total_venta,
					SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.pag_premio ELSE 0 END) AS tot_premios,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.mon_venta ELSE 0 END) AS tot_eliminad,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.mon_venta ELSE 0 END) AS ret_pagos,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.mon_venta ELSE 0 END) AS ret_total,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.mon_venta ELSE 0 END) AS ret_porpagar,
					SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.mon_venta ELSE 0 END) AS inv_pagos,
					SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.mon_venta ELSE 0 END) AS inv_total,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.mon_venta ELSE 0 END) AS inv_porpagar,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
						THEN 1 ELSE 0 END) AS con_tic_eli,
						
						
						SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
						THEN ve.mon_venta ELSE 0 END) AS total_ventausd,
					SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 3
						THEN ve.pag_premio ELSE 0 END) AS tot_premiosusd,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
						THEN ve.mon_venta ELSE 0 END) AS tot_eliminadusd,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND ve.efectivoO = 3
						THEN ve.mon_venta ELSE 0 END) AS ret_pagosusd,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
						THEN ve.mon_venta ELSE 0 END) AS ret_totalusd,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
						THEN ve.mon_venta ELSE 0 END) AS ret_porpagarusd,
					SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 3
						THEN ve.mon_venta ELSE 0 END) AS inv_pagosusd,
					SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
						THEN ve.mon_venta ELSE 0 END) AS inv_totalusd,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 3
						THEN ve.mon_venta ELSE 0 END) AS inv_porpagarusd,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 3
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagarusd,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND ve.efectivoO = 3
						THEN 1 ELSE 0 END) AS con_tic_eliusd,
						
						
								
								
						
						SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
						THEN ve.mon_venta ELSE 0 END) AS total_ventacop,
					SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 4
						THEN ve.pag_premio ELSE 0 END) AS tot_premioscop,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
						THEN ve.mon_venta ELSE 0 END) AS tot_eliminadcop,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND ve.efectivoO = 4
						THEN ve.mon_venta ELSE 0 END) AS ret_pagoscop,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
						THEN ve.mon_venta ELSE 0 END) AS ret_totalcop,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
						THEN ve.mon_venta ELSE 0 END) AS ret_porpagarcop,
					SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 4
						THEN ve.mon_venta ELSE 0 END) AS inv_pagoscop,
					SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
						THEN ve.mon_venta ELSE 0 END) AS inv_totalcop,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 4
						THEN ve.mon_venta ELSE 0 END) AS inv_porpagarcop,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 4
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagarcop,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND ve.efectivoO = 4
						THEN 1 ELSE 0 END) AS con_tic_elicop,
						
						
								
		
								
						
						SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
						THEN ve.mon_venta ELSE 0 END) AS p_ventas_totales_sol,
					SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 5
						THEN ve.pag_premio ELSE 0 END) AS tot_premiossol,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
						THEN ve.mon_venta ELSE 0 END) AS tot_eliminadsol,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND ve.efectivoO = 5
						THEN ve.mon_venta ELSE 0 END) AS ret_pagossol,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
						THEN ve.mon_venta ELSE 0 END) AS ret_totalsol,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
						THEN ve.mon_venta ELSE 0 END) AS ret_porpagarsol,
					SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 5
						THEN ve.mon_venta ELSE 0 END) AS inv_pagossol,
					SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
						THEN ve.mon_venta ELSE 0 END) AS inv_totalsol,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 5
						THEN ve.mon_venta ELSE 0 END) AS inv_porpagarsol,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 5
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagarsol,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND ve.efectivoO = 5
						THEN 1 ELSE 0 END) AS con_tic_elisol
						
						
						
						
						
				FROM
					agencia ag, taquilla ta, taquilla_opc_ame tp, venta ve

				WHERE (ve.fec_venta >= %s AND ve.fec_venta <= %s OR ve.fec_pago >= %s AND ve.fec_pago <= %s) AND 
					ta.cod_agencia = ag.cod_agencia AND ta.cod_taquilla = ve.cod_taquilla AND
					tp.cod_taquilla = ta.cod_taquilla AND ag.cod_agencia = %s AND ta.cod_taquilla = %s 
				GROUP BY ta.cod_taquilla 
				ORDER BY ta.cod_taquilla, ve.fec_venta, ve.num_ticket ASC",
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
                    GetSQLValueString($codigoAgente, "int"),
                    GetSQLValueString($row_Recordset3['cod_taquilla'], "int")
                );
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                $nom=$row_Recordset1['nom_taquilla']."..AME BSS";
                $nomusd=$row_Recordset1['nom_taquilla']."..AME USD";
                $nomsol=$row_Recordset1['nom_taquilla']."..AME SOL";
                $nomcop=$row_Recordset1['nom_taquilla']."..AME COP";
                $nomeur=$row_Recordset1['nom_taquilla']."..AME EUR";

                $porTaquilla=$row_Recordset1['taq_por_ame'];
                
                //bss in americanas 
                $totVentaTaq=$row_Recordset1['total_venta'];
                $totPremiTaq=$row_Recordset1['tot_premios'];
                $totaleliminados=$row_Recordset1['tot_eliminad'];
                $totAnulaTaq=$row_Recordset1['ret_pagos']+$row_Recordset1['inv_pagos']+$row_Recordset1['tot_eliminad'];
                $totTaquilla=$totVentaTaq-($totPremiTaq+$totAnulaTaq);
                $totPTaqPpag=$row_Recordset1['pre_porpagar'];
                $porPagarEliTaq=$row_Recordset1['ret_porpagar']+$row_Recordset1['inv_porpagar'];
                $totGanPerTaq=$totTaquilla-$totPTaqPpag-$porPagarEliTaq;
                $totalAnulados=$row_Recordset1['ret_total']+$row_Recordset1['inv_total']+$row_Recordset1['tot_eliminad'];
                $tCobroAgente=(($totVentaTaq-$totalAnulados)*$porTaquilla)/100;
                $tot=$row_Recordset1['con_tic_eli'];
//bss in americanas
                
                //usd in americanas
                $totVentaTaqusd=$row_Recordset1['total_ventausd'];
                $totPremiTaqusd=$row_Recordset1['tot_premiosusd'];
                $totaleliminadosusd=$row_Recordset1['tot_eliminadusd'];

                $totAnulaTaqusd=$row_Recordset1['ret_pagosusd']+$row_Recordset1['inv_pagosusd']+$row_Recordset1['tot_eliminadusd'];
                $totTaquillausd=$totVentaTaqusd-($totPremiTaqusd+$totAnulaTaqusd);
                $totPTaqPpagusd=$row_Recordset1['pre_porpagarusd'];
                $porPagarEliTaqusd=$row_Recordset1['ret_porpagarusd']+$row_Recordset1['inv_porpagarusd'];
                $totGanPerTaqusd=$totTaquillausd-$totPTaqPpagusd-$porPagarEliTaqusd;
                $totalAnuladosusd=$row_Recordset1['ret_totalusd']+$row_Recordset1['inv_totalusd']+$row_Recordset1['tot_eliminadusd'];
                $tCobroAgenteusd=(($totVentaTaqusd-$totalAnuladosusd)*$porTaquilla)/100;
                $totusd=$row_Recordset1['con_tic_eliusd'];
                
                //usd fin americanas
                
                
                
                
                                        
                        
                
                //cop in americanas
                $totVentaTaqcop=$row_Recordset1['total_ventacop'];
                $totPremiTaqcop=$row_Recordset1['tot_premioscop'];
                $totaleliminadoscop=$row_Recordset1['tot_eliminadcop'];
                $totAnulaTaqcop=$row_Recordset1['ret_pagoscop']+$row_Recordset1['inv_pagoscop']+$row_Recordset1['tot_eliminadcop'];
                $totTaquillacop=$totVentaTaqcop-($totPremiTaqcop+$totAnulaTaqcop);
                $totPTaqPpagcop=$row_Recordset1['pre_porpagarcop'];
                $porPagarEliTaqcop=$row_Recordset1['ret_porpagarcop']+$row_Recordset1['inv_porpagarcop'];
                $totGanPerTaqcop=$totTaquillacop-$totPTaqPpagcop-$porPagarEliTaqcop;
                $totalAnuladoscop=$row_Recordset1['ret_totalcop']+$row_Recordset1['inv_totalcop']+$row_Recordset1['tot_eliminadcop'];
                $tCobroAgentecop=(($totVentaTaqcop-$totalAnuladoscop)*$porTaquilla)/100;
                $totcop=$row_Recordset1['con_tic_elicop'];
                
                //cop fin americanas
                
                
                
                                        
                        
                
                //sol in americanas
                $totVentaTaqsol=$row_Recordset1['p_ventas_totales_sol'];
                $totPremiTaqsol=$row_Recordset1['tot_premiossol'];
                $totaleliminadossol=$row_Recordset1['tot_eliminadsol'];
                $totAnulaTaqsol=$row_Recordset1['ret_pagossol']+$row_Recordset1['inv_pagossol']+$row_Recordset1['tot_eliminadsol'];
                $totTaquillasol=$totVentaTaqsol-($totPremiTaqsol+$totAnulaTaqsol);
                $totPTaqPpagsol=$row_Recordset1['pre_porpagarsol'];
                $porPagarEliTaqsol=$row_Recordset1['ret_porpagarsol']+$row_Recordset1['inv_porpagarsol'];
                $totGanPerTaqsol=$totTaquillasol-$totPTaqPpagsol-$porPagarEliTaqsol;
                $totalAnuladossol=$row_Recordset1['ret_totalsol']+$row_Recordset1['inv_totalsol']+$row_Recordset1['tot_eliminadsol'];
                $tCobroAgentesol=(($totVentaTaqsol-$totalAnuladossol)*$porTaquilla)/100;
                $totsol=$row_Recordset1['con_tic_elisol'];
                
                //sol fin americanas
                //select americanas fin
                
                
                
                
                /*
                est_ticket_hnac = 2 tot_premiosN
                est_ticket_hnac = 0
                est_ticket_hnac = 4 ret_pagosN
veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 4 ret_porpagarN
veN.est_ticket_hnac = 5 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s inv_pagosN
veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 2  pre_porpagarN

                */
                //select NACIONALES in
                $query_Recordset2 = sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 9 */ SELECT
					ag.agen_cob_hnac, ag.nom_agencia, ta.nom_taquilla,
					SUM(CASE WHEN veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s                           AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS total_ventaN,
					SUM(CASE WHEN veN.est_ticket_hnac = 2 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.pag_premio_hnac ELSE 0 END) AS tot_premiosN,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS tot_eliminadN,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s   AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_pagosN,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_totalN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 4 AND veN.fec_venta_hnac >= %s AND
						                                                                  veN.fec_venta_hnac <= %s   AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2)  
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_porpagarN,
					SUM(CASE WHEN veN.est_ticket_hnac = 5 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_pagosN,
					SUM(CASE WHEN veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_totalN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND
						                                                                veN.fec_venta_hnac <= %s   AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_porpagarN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 2 AND veN.fec_venta_hnac >= %s AND 
						                                                                veN.fec_venta_hnac <= %s   AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.pag_premio_hnac ELSE 0 END) AS pre_porpagarN,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s AND
						                                                                 veN.lin_ticket_hnac = 1   AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN 1 ELSE 0 END) AS con_tic_eliN,
						
						
					SUM(CASE WHEN veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s                           AND veN.efectivoOn = 3
						THEN veN.mon_venta_hnac ELSE 0 END) AS total_ventaNusd,
					SUM(CASE WHEN veN.est_ticket_hnac = 2 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND veN.efectivoOn = 3
						THEN veN.pag_premio_hnac ELSE 0 END) AS tot_premiosNusd,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND veN.efectivoOn  = 3
						THEN veN.mon_venta_hnac ELSE 0 END) AS tot_eliminadNusd,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s   AND veN.efectivoOn = 3
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_pagosNusd,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND veN.efectivoOn = 3
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_totalNusd,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 4 AND veN.fec_venta_hnac >= %s AND
						                                                                  veN.fec_venta_hnac <= %s   AND veN.efectivoOn = 3 
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_porpagarNusd,
					SUM(CASE WHEN veN.est_ticket_hnac = 5 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND veN.efectivoOn = 3
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_pagosNusd,
					SUM(CASE WHEN veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND veN.efectivoOn = 3
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_totalNusd,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND
						                                                                veN.fec_venta_hnac <= %s   AND veN.efectivoOn = 3
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_porpagarNusd,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 2 AND veN.fec_venta_hnac >= %s AND 
						                                                                veN.fec_venta_hnac <= %s   AND veN.efectivoOn = 3
						THEN veN.pag_premio_hnac ELSE 0 END) AS pre_porpagarNusd,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s AND
						                                                                 veN.lin_ticket_hnac = 1   AND veN.efectivoOn = 3
						THEN 1 ELSE 0 END) AS con_tic_eliNusd,
						
						
						
											
						
					SUM(CASE WHEN veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s                           AND veN.efectivoOn = 4
						THEN veN.mon_venta_hnac ELSE 0 END) AS total_ventaNcop,
					SUM(CASE WHEN veN.est_ticket_hnac = 2 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND veN.efectivoOn = 4
						THEN veN.pag_premio_hnac ELSE 0 END) AS tot_premiosNcop,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND veN.efectivoOn  = 4
						THEN veN.mon_venta_hnac ELSE 0 END) AS tot_eliminadNcop,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s   AND veN.efectivoOn = 4
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_pagosNcop,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND veN.efectivoOn = 4
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_totalNcop,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 4 AND veN.fec_venta_hnac >= %s AND
						                                                                  veN.fec_venta_hnac <= %s   AND veN.efectivoOn = 4 
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_porpagarNcop,
					SUM(CASE WHEN veN.est_ticket_hnac = 5 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND veN.efectivoOn = 4
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_pagosNcop,
					SUM(CASE WHEN veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND veN.efectivoOn = 4
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_totalNcop,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND
						                                                                veN.fec_venta_hnac <= %s   AND veN.efectivoOn = 4
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_porpagarNcop,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 2 AND veN.fec_venta_hnac >= %s AND 
						                                                                veN.fec_venta_hnac <= %s   AND veN.efectivoOn = 4
						THEN veN.pag_premio_hnac ELSE 0 END) AS pre_porpagarNcop,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s AND
						                                                                 veN.lin_ticket_hnac = 1   AND veN.efectivoOn = 4
						THEN 1 ELSE 0 END) AS con_tic_eliNcop,
						
						
						
											
						
					SUM(CASE WHEN veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s                           AND veN.efectivoOn = 5
						THEN veN.mon_venta_hnac ELSE 0 END) AS total_ventaNsol,
					SUM(CASE WHEN veN.est_ticket_hnac = 2 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND veN.efectivoOn = 5
						THEN veN.pag_premio_hnac ELSE 0 END) AS tot_premiosNsol,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND veN.efectivoOn  = 5
						THEN veN.mon_venta_hnac ELSE 0 END) AS tot_eliminadNsol,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s   AND veN.efectivoOn = 5
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_pagosNsol,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND veN.efectivoOn = 5
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_totalNsol,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 4 AND veN.fec_venta_hnac >= %s AND
						                                                                  veN.fec_venta_hnac <= %s   AND veN.efectivoOn = 5 
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_porpagarNsol,
					SUM(CASE WHEN veN.est_ticket_hnac = 5 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND veN.efectivoOn = 5
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_pagosNsol,
					SUM(CASE WHEN veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND veN.efectivoOn = 5
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_totalNsol,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND
						                                                                veN.fec_venta_hnac <= %s   AND veN.efectivoOn = 5
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_porpagarNsol,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 2 AND veN.fec_venta_hnac >= %s AND 
						                                                                veN.fec_venta_hnac <= %s   AND veN.efectivoOn = 5
						THEN veN.pag_premio_hnac ELSE 0 END) AS pre_porpagarNsol,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s AND
						                                                                 veN.lin_ticket_hnac = 1   AND veN.efectivoOn = 5
						THEN 1 ELSE 0 END) AS con_tic_eliNsol
						
						
						
						
						
						
					FROM 
						agencia ag, taquilla ta, taquilla_opc_hnac tp, usuario us, venta_hnac veN
USE INDEX(id_us_fe_fe)
					WHERE
						((veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s OR veN.fec_pago_hnac >= %s AND
						veN.fec_pago_hnac <= %s) AND us.id_usuario = veN.id_usuario) AND 
						tp.cod_taquilla = ta.cod_taquilla AND ta.cod_taquilla = us.cod_taquilla AND 
						ta.cod_agencia = ag.cod_agencia AND ag.cod_agencia = %s AND ta.cod_taquilla = %s
						ORDER BY ta.nom_taquilla, ta.cod_taquilla ASC",
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
                    GetSQLValueString($codigoAgente, "int"),
                    GetSQLValueString($row_Recordset3['cod_taquilla'], "int")
                );
                $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
                $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
                
                $nomN=$row_Recordset2['nom_taquilla']."..NAC BSS";
                $nomNusd=$row_Recordset1['nom_taquilla']."..NAC USD";
                $nomNsol=$row_Recordset1['nom_taquilla']."..NAC SOL";
                $nomNcop=$row_Recordset1['nom_taquilla']."..NAC COP";
                $nomNeur=$row_Recordset1['nom_taquilla']."..NAC EUR";
                
                
                $porTaquillaN=$row_Recordset2['agen_cob_hnac'];


                //bss n in 
                $totVentaTaqN=$row_Recordset2['total_ventaN'];
                
                $totPremiTaqN=$row_Recordset2['tot_premiosN'];
                $totAnulaTaqN=$row_Recordset2['ret_pagosN']+$row_Recordset2['inv_pagosN']+$row_Recordset2['tot_eliminadN'];
                
                $totTaquillaN=$totVentaTaqN-($totPremiTaqN+$totAnulaTaqN);
                $totPTaqPpagN=$row_Recordset2['pre_porpagarN'];
                $porPagarEliTaqN=$row_Recordset2['ret_porpagarN']+$row_Recordset2['inv_porpagarN'];
                $totGanPerTaqN=$totTaquillaN-$totPTaqPpagN-$porPagarEliTaqN;
                $totalAnuladosN=$row_Recordset2['ret_totalN']+$row_Recordset2['inv_totalN']+$row_Recordset2['tot_eliminadN'];
                $tCobroAgenteN=$row_Recordset3['agen_cob_hnac']*$totalRows_Recordset2;
                $totN=$row_Recordset2['con_tic_eliN'];
                $totVentaTaqNtotales=($totVentaTaqNtotales+$row_Recordset2['total_ventaN'])-($totAnulaTaqN);
                $totVentaTaqNtotalescobro1=(($totVentaTaqN-$totAnulaTaqN)*$row_Recordset3['taq_cob_hnac'])/100;
                //bss n fin
                //usd n in
                $totVentaTaqNusd=$row_Recordset2['total_ventaNusd'];
                $totPremiTaqNusd=$row_Recordset2['tot_premiosNusd'];
                $totAnulaTaqNusd=$row_Recordset2['ret_pagosNusd']+$row_Recordset2['inv_pagosNusd']+$row_Recordset2['tot_eliminadNusd'];
                $totTaquillaNusd=$totVentaTaqNusd-($totPremiTaqNusd+$totAnulaTaqNusd);
                $totPTaqPpagNusd=$row_Recordset2['pre_porpagarNusd'];
                $porPagarEliTaqNusd=$row_Recordset2['ret_porpagarNusd']+$row_Recordset2['inv_porpagarNusd'];
                $totGanPerTaqNusd=$totTaquillaNusd-$totPTaqPpagNusd-$porPagarEliTaqNusd;
                $totalAnuladosNusd=$row_Recordset2['ret_totalNusd']+$row_Recordset2['inv_totalNusd']+$row_Recordset2['tot_eliminadNusd'];
                $cobroAgenteusd=$row_Recordset3['agen_cob_hnac']*$totalRows_Recordset1;
                $totNusd=$row_Recordset2['con_tic_eliNusd'];
                $totVentaTaqNtotalesusd=($totVentaTaqNtotalesusd+$row_Recordset2['total_ventaNusd'])-($totAnulaTaqNusd);
                $totVentaTaqNtotalescobro1usd=(($totVentaTaqNusd-$totAnulaTaqNusd)*$row_Recordset3['taq_cob_hnac'])/100;
                // usd n fin
                
                
                
                                        
                        
                //cop n
                $totVentaTaqNcop=$row_Recordset2['total_ventaNcop'];
                $totPremiTaqNcop=$row_Recordset2['tot_premiosNcop'];
                $totAnulaTaqNcop=$row_Recordset2['ret_pagosNcop']+$row_Recordset2['inv_pagosNcop']+$row_Recordset2['tot_eliminadNcop'];
                $totTaquillaNcop=$totVentaTaqNcop-($totPremiTaqNcop+$totAnulaTaqNcop);
                $totPTaqPpagNcop=$row_Recordset2['pre_porpagarNcop'];
                $porPagarEliTaqNcop=$row_Recordset2['ret_porpagarNcop']+$row_Recordset2['inv_porpagarNcop'];
                $totGanPerTaqNcop=$totTaquillaNcop-$totPTaqPpagNcop-$porPagarEliTaqNcop;
                $totalAnuladosNcop=$row_Recordset2['ret_totalNcop']+$row_Recordset2['inv_totalNcop']+$row_Recordset2['tot_eliminadNcop'];
                $cobroAgentecop=$row_Recordset3['agen_cob_hnac']*$totalRows_Recordset1;
                $totNcop=$row_Recordset2['con_tic_eliNcop'];
                $totVentaTaqNtotalescop=($totVentaTaqNtotalescop+$row_Recordset2['total_ventaNcop'])-($totAnulaTaqNcop);
                $totVentaTaqNtotalescobro1cop=(($totVentaTaqNcop-$totAnulaTaqNcop)*$row_Recordset3['taq_cob_hnac'])/100;
                // cop n fin
                
                
                                        
                        
                //sol n
                $totVentaTaqNsol=$row_Recordset2['total_ventaNsol'];
                $totPremiTaqNsol=$row_Recordset2['tot_premiosNsol'];
                $totAnulaTaqNsol=$row_Recordset2['ret_pagosNsol']+$row_Recordset2['inv_pagosNsol']+$row_Recordset2['tot_eliminadNsol'];
                $totTaquillaNsol=$totVentaTaqNsol-($totPremiTaqNsol+$totAnulaTaqNsol);
                $totPTaqPpagNsol=$row_Recordset2['pre_porpagarNsol'];
                $porPagarEliTaqNsol=$row_Recordset2['ret_porpagarNsol']+$row_Recordset2['inv_porpagarNsol'];
                $totGanPerTaqNsol=$totTaquillaNsol-$totPTaqPpagNsol-$porPagarEliTaqNsol;
                $totalAnuladosNsol=$row_Recordset2['ret_totalNsol']+$row_Recordset2['inv_totalNsol']+$row_Recordset2['tot_eliminadNsol'];
                $cobroAgentesol=$row_Recordset3['agen_cob_hnac']*$totalRows_Recordset1;
                $totNsol=$row_Recordset2['con_tic_eliNsol'];
                $totVentaTaqNtotalessol=($totVentaTaqNtotalessol+$row_Recordset2['total_ventaNsol'])-($totAnulaTaqNsol);
                $totVentaTaqNtotalescobro1sol=(($totVentaTaqNsol-$totAnulaTaqNsol)*$row_Recordset3['taq_cob_hnac'])/100;
                // sol n fin
                

                $timestamp = strtotime($iniciod);
                $newDate = date("Y-m-d", $timestamp );
                
                $timestamp1 = strtotime($finald); 
                $newDate1 = date("Y-m-d", $timestamp1 );
                
//select NACIONALES fin
//select parley in
//p4jugadas.estadoticketp4 = 1 =
//p4jugadas.estadoticketp4 = 2 =
//p4jugadas.estadoticketp4 = 3 =
//p4jugadas.estadoticketp4 = 4 =
//p4jugadas.estadoticketp4 = 5 =
//p4jugadas.estadoticketp4 = 6 =

/*
estadoticketp4']==0) { echo 'Pendiente';}
estadoticketp4']==1 && ($row_Recordset135['pverificado']==0)) { echo 'Ganador Por Aprobar';} 
estadoticketp4']==1 && ($row_Recordset135['pverificado']==1)) { echo 'Ganador Aprobado';}} 
estadoticketp4']==2) { echo 'Perdio';}
estadoticketp4']==3) { echo 'Devolucion Por Pagar';}
estadoticketp4']==5) { echo 'Ganador Pagado';}   Y LA FECHA DE PAGO CLARO 
estadoticketp4']==6) { echo 'Devolucion Pagado';}  Y LA FECHA DE PAGO CLARO 
estadoticketp4']==7) { echo 'Eliminado';}  Y LA FECHA DE PAGO CLARO 
*/ //aqui
                $query_Recordset50 = sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 10 */ SELECT 
                p4jugadas.lineatp4, ta.nom_taquilla, ta.taq_por_parley,
                

                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 <= 2 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS p_ventas_totales_bs,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND p4jugadas.estadoticketp4 = 5 AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_premios_pagados_bs,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND p4jugadas.estadoticketp4 = 6 AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_anulados_pagados_bs,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 1) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_premios_por_pagar_bs,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 3) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_anulados_por_pagar_bs,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_total_eliminados_bs,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.estadoticketp4 = 7 ELSE 0 END) AS p_cant_eliminados_bs,
                
                

                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 3 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS p_ventas_totales_usd,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND p4jugadas.estadoticketp4 = 5 AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_premios_pagados_usd,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND p4jugadas.estadoticketp4 = 6 AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_anulados_pagados_usd,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 1) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_premios_por_pagar_usd,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 3) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_anulados_por_pagar_usd,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_total_eliminados_usd,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 3  THEN p4jugadas.estadoticketp4 = 7 ELSE 0 END) AS p_cant_eliminados_usd,
                
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 4 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS p_ventas_totales_cop,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND p4jugadas.estadoticketp4 = 5 AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_premios_pagados_cop,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND p4jugadas.estadoticketp4 = 6 AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_anulados_pagados_cop,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 1) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_premios_por_pagar_cop,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 3) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_anulados_por_pagar_cop,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_total_eliminados_cop,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 4  THEN p4jugadas.estadoticketp4 = 7 ELSE 0 END) AS p_cant_eliminados_cop,
                
                
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 5 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS p_ventas_totales_sol,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND p4jugadas.estadoticketp4 = 5 AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_premios_pagados_sol,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND p4jugadas.estadoticketp4 = 6 AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_anulados_pagados_sol,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 1) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_premios_por_pagar_sol,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 3) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_anulados_por_pagar_sol,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS p_total_eliminados_sol,
                SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 5  THEN p4jugadas.estadoticketp4 = 7 ELSE 0 END) AS p_cant_eliminados_sol
                
                
                
                FROM 
                p4jugadas, taquilla ta , agencia ag
                WHERE
                p4jugadas.cod_taquillap4= %s AND 
                p4jugadas.lineatp4= 1 AND
                ta.cod_taquilla = %s AND
                ag.cod_agencia = %s", 
                

                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 

                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 

                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 

                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 


                GetSQLValueString($row_Recordset3['cod_taquilla'], "int"),
                GetSQLValueString($row_Recordset3['cod_taquilla'], "int"),
                GetSQLValueString($codigoAgente, "int")
                );
                $Recordset50 = mysqli_query($conexionbanca, $query_Recordset50) or die(mysqli_error($conexionbanca));
                $row_Recordset50 = mysqli_fetch_assoc($Recordset50);
                $totalRows_Recordset50 = mysqli_num_rows($Recordset50);


                $nomP=$row_Recordset50['nom_taquilla']."..PAR BSS";
                $nomPUSD=$row_Recordset50['nom_taquilla']."..PAR USD";
                $nomPSOL=$row_Recordset50['nom_taquilla']."..PAR SOL";
                $nomPCOP=$row_Recordset50['nom_taquilla']."..PAR COP";
                $nomPEUR=$row_Recordset50['nom_taquilla']."..PAR EUR";
                $p_porcentaje_Taquilla=$row_Recordset50['taq_por_parley'];
                



                //PARLEY BS
                $p_ventas_totales_bs=$row_Recordset50['p_ventas_totales_bs'];
                $p_premios_pagados_bs=$row_Recordset50['p_premios_pagados_bs'];
                $p_anulados_pagados_bs=$row_Recordset50['p_anulados_pagados_bs'];
                $p_total_en_caja_bs=$p_ventas_totales_bs-($p_premios_pagados_bs+$p_anulados_pagados_bs+$row_Recordset50['p_total_eliminados_bs']);
                $p_premios_por_pagar_bs=$row_Recordset50['p_premios_por_pagar_bs'];
                $p_anulados_por_pagar_bs=$row_Recordset50['p_anulados_por_pagar_bs'];
                $p_total_incluye_por_pagar_bs=$p_total_en_caja_bs-$p_premios_por_pagar_bs-$p_anulados_por_pagar_bs;
                $p_total_eliminados_bs=$row_Recordset50['p_total_eliminados_bs'];
                $p_total_anulados_bs=$p_anulados_pagados_bs+$p_anulados_por_pagar_bs+$p_total_eliminados_bs;
                $p_tCobroAgente_bs=(($p_ventas_totales_bs-$p_anulados_pagados_bs-$p_anulados_por_pagar_bs-$p_total_eliminados_bs)*$p_porcentaje_Taquilla)/100;

                //PARLEY USD
                $p_ventas_totales_usd=$row_Recordset50['p_ventas_totales_usd'];
                $p_premios_pagados_usd=$row_Recordset50['p_premios_pagados_usd'];
                $p_anulados_pagados_usd=$row_Recordset50['p_anulados_pagados_usd'];
                $p_total_en_caja_usd=$p_ventas_totales_usd-($p_premios_pagados_usd+$p_anulados_pagados_usd+$row_Recordset50['p_total_eliminados_usd']);
                $p_premios_por_pagar_usd=$row_Recordset50['p_premios_por_pagar_usd'];
                $p_anulados_por_pagar_usd=$row_Recordset50['p_anulados_por_pagar_usd'];
                $p_total_incluye_por_pagar_usd=$p_total_en_caja_usd-$p_premios_por_pagar_usd-$p_anulados_por_pagar_usd;
                $p_total_eliminados_usd=$row_Recordset50['p_total_eliminados_usd'];
                $p_total_anulados_usd=$p_anulados_pagados_usd+$p_anulados_por_pagar_usd+$p_total_eliminados_usd;
                $p_tCobroAgente_usd=(($p_ventas_totales_usd-$p_anulados_pagados_usd-$p_anulados_por_pagar_usd-$p_total_eliminados_usd)*$p_porcentaje_Taquilla)/100;


                 //PARLEY COP
                 $p_ventas_totales_cop=$row_Recordset50['p_ventas_totales_cop'];
                 $p_premios_pagados_cop=$row_Recordset50['p_premios_pagados_cop'];
                 $p_anulados_pagados_cop=$row_Recordset50['p_anulados_pagados_cop'];
                 $p_total_en_caja_cop=$p_ventas_totales_cop-($p_premios_pagados_cop+$p_anulados_pagados_cop+$row_Recordset50['p_total_eliminados_cop']);
                 $p_premios_por_pagar_cop=$row_Recordset50['p_premios_por_pagar_cop'];
                 $p_anulados_por_pagar_cop=$row_Recordset50['p_anulados_por_pagar_cop'];
                 $p_total_incluye_por_pagar_cop=$p_total_en_caja_cop-$p_premios_por_pagar_cop-$p_anulados_por_pagar_cop;
                 $p_total_eliminados_cop=$row_Recordset50['p_total_eliminados_cop'];
                 $p_total_anulados_cop=$p_anulados_pagados_cop+$p_anulados_por_pagar_cop+$p_total_eliminados_cop;
                 $p_tCobroAgente_cop=(($p_ventas_totales_cop-$p_anulados_pagados_cop-$p_anulados_por_pagar_cop-$p_total_eliminados_cop)*$p_porcentaje_Taquilla)/100;
 
                

                 //PARLEY SOL //aqui

                $p_ventas_totales_sol=$row_Recordset50['p_ventas_totales_sol'];
                $p_premios_pagados_sol=$row_Recordset50['p_premios_pagados_sol'];
                $p_anulados_pagados_sol=$row_Recordset50['p_anulados_pagados_sol'];
                $p_total_en_caja_sol=$p_ventas_totales_sol-($p_premios_pagados_sol+$p_anulados_pagados_sol+$row_Recordset50['p_total_eliminados_sol']);
                $p_premios_por_pagar_sol=$row_Recordset50['p_premios_por_pagar_sol'];
                $p_anulados_por_pagar_sol=$row_Recordset50['p_anulados_por_pagar_sol'];
                $p_total_incluye_por_pagar_sol=$p_total_en_caja_sol-$p_premios_por_pagar_sol-$p_anulados_por_pagar_sol;
                $p_total_eliminados_sol=$row_Recordset50['p_total_eliminados_sol'];
                $p_total_anulados_sol=$p_anulados_pagados_sol+$p_anulados_por_pagar_sol+$p_total_eliminados_sol;
                $p_tCobroAgente_sol=(($p_ventas_totales_sol-$p_anulados_pagados_sol-$p_anulados_por_pagar_sol-$p_total_eliminados_sol)*$p_porcentaje_Taquilla)/100;
                
                
                

                //select parley fin


                $query_Recordset7 =  sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 11 */ SELECT id_usuario
					FROM  
					cobro_hnac
					WHERE 
					cod_taquilla = %s AND
					fec_creacion >= %s AND fec_creacion <= %s",
                    GetSQLValueString($row_Recordset3['cod_taquilla'], "int"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date")
                );
                $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
                $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
                $totalRows_Recordset7 = mysqli_num_rows($Recordset7);
                
                
                
                 
                $query_Recordset7 =  sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalaaa.php - QUERY 12 */ SELECT id_usuario
					FROM  
					cobro_hnac
					WHERE 
					cod_taquilla = %s AND
					fec_creacion >= %s AND fec_creacion <= %s",
                    GetSQLValueString($row_Recordset3['cod_taquilla'], "int"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date")
                );
                $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
                $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
                $totalRows_Recordset7 = mysqli_num_rows($Recordset7);


		if($totalRows_Recordset7>0){
                    $taquillaspar++;
                    
                   }



                
                $tCobroAgenteN=$row_Recordset2['agen_cob_hnac']*$totalRows_Recordset7;
                $tCobroAgenteP=$row_Recordset50['taq_por_parley']*$totalRows_Recordset7;
                  //bs americanas in
                if ($totVentaTaq!=0 or $totPremiTaq!=0 or $totAnulaTaq!=0 or $totTaquilla!=0 or $totPTaqPpag!=0 or
                $porPagarEliTaq!=0 or $totGanPerTaq!=0) {?>
                  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" height="20" 
                    style="background:#FFF; font-size:11px">
                    <td align="left" valign="middle"><?php echo $nom; ?></td>
                    <td align="right" valign="middle"><?php if ($totVentaTaq==0.00) {
                } if ($totVentaTaq<>0.00) {
                    echo number_format($totVentaTaq, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totPremiTaq==0.00) {
                } if ($totPremiTaq<>0.00) {
                    echo number_format($totPremiTaq, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totAnulaTaq==0.00) {
                } if ($totAnulaTaq<>0.00) {
                    echo number_format($totAnulaTaq, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="blue"><?php if ($totTaquilla==0.00) {
                } if ($totTaquilla<>0.00) {
                    echo number_format($totTaquilla, 2, ",", ".");
                }?></font></td>
                    <td align="right" valign="middle"><?php if ($totPTaqPpag==0.00) {
                } if ($totPTaqPpag<>0.00) {
                    echo number_format($totPTaqPpag, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($porPagarEliTaq==0.00) {
                } if ($porPagarEliTaq<>0.00) {
                    echo number_format($porPagarEliTaq, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaq==0.00) {
                    echo " ";
                } if ($totGanPerTaq<>0.00) {
                    echo number_format($totGanPerTaq, 2, ",", ".");
                }?></font></td>
                    






            <td align="right" valign="middle"><?php
                        $totN=$row_Recordset1['con_tic_eli']*1;
                                            if ($tot==0) {
                                            }
                                            if ($tot<>0) {
                                                echo "(".$totN.")".number_format($row_Recordset1['tot_eliminad'], 2, ",", ".");
                                            }?>
                    </td>
        <td align="right" valign="middle"><?php
                        echo "AM BSS(".number_format($porTaquilla, 1, ",", ".")."%)";
/*
                                                    echo "NA(".number_format($row_Recordset2['agen_cob_hnac'], 0, ",", ".");
                        echo "x".$totalRows_Recordset7.")";
*/
                                                    $totalpagosistema=$tCobroAgente;
?>							
<font color="red"><?php echo "...(".number_format($totalpagosistema, 2, ",", ".").")";
?></font>
                    </td>

                </tr><?php
            }
            
            
            //bs americanas fin
            // usd americanas in
            
          
            if ($totVentaTaqusd!=0 or $totPremiTaqusd!=0 or $totAnulaTaqusd!=0 or $totTaquillausd!=0 or $totPTaqPpagusd!=0 or
                $porPagarEliTaqusd!=0 or $totGanPerTaqusd!=0) {?>
                  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" height="20" 
                    style="background:#FFF; font-size:11px">
                    <td align="left" valign="middle"><?php echo $nomusd; ?></td>
                    <td align="right" valign="middle"><?php if ($totVentaTaqusd==0.00) {
                } if ($totVentaTaqusd<>0.00) {
                    echo number_format($totVentaTaqusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totPremiTaqusd==0.00) {
                } if ($totPremiTaqusd<>0.00) {
                    echo number_format($totPremiTaqusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totAnulaTaqusd==0.00) {
                } if ($totAnulaTaqusd<>0.00) {
                    echo number_format($totAnulaTaqusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="blue"><?php if ($totTaquilla==0.00) {
                } if ($totTaquillausd<>0.00) {
                    echo number_format($totTaquillausd, 2, ",", ".");
                }?></font></td>
                    <td align="right" valign="middle"><?php if ($totPTaqPpagusd==0.00) {
                } if ($totPTaqPpagusd<>0.00) {
                    echo number_format($totPTaqPpagusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($porPagarEliTaqusd==0.00) {
                } if ($porPagarEliTaqusd<>0.00) {
                    echo number_format($porPagarEliTaqusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqusd==0.00) {
                    echo " ";
                } if ($totGanPerTaqusd<>0.00) {
                    echo number_format($totGanPerTaqusd, 2, ",", ".");
                }?></font></td>
                    






            <td align="right" valign="middle"><?php
                        $totNusd1=$row_Recordset1['con_tic_eliusd']*1;
                                            if ($totusd==0) {
                                            }
                                            if ($totusd<>0) {
                                                echo "(".$totNusd1.")".number_format($row_Recordset1['tot_eliminadusd'], 2, ",", ".");
                                            }?>
                    </td>
        <td align="right" valign="middle"><?php
                        echo "AM USD(".number_format($porTaquilla, 1, ",", ".")."%)";
                                               
                                                    $totalpagosistemausd=$tCobroAgenteusd;
?>							
<font color="red"><?php echo "...(".number_format($totalpagosistemausd, 2, ",", ".").")";
?></font>
                    </td>

                </tr><?php
            }
            
            
            
            
            // usd americanas fin
            
            
            // cop americanas in
            
            
            if ($totVentaTaqcop!=0 or $totPremiTaqcop!=0 or $totAnulaTaqcop!=0 or $totTaquillacop!=0 or $totPTaqPpagcop!=0 or
                $porPagarEliTaqcop!=0 or $totGanPerTaqcop!=0) {?>
                  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" height="20" 
                    style="background:#FFF; font-size:11px">
                    <td align="left" valign="middle"><?php echo $nomcop; ?></td>
                    <td align="right" valign="middle"><?php if ($totVentaTaqcop==0.00) {
                } if ($totVentaTaqcop<>0.00) {
                    echo number_format($totVentaTaqcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totPremiTaqcop==0.00) {
                } if ($totPremiTaqcop<>0.00) {
                    echo number_format($totPremiTaqcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totAnulaTaqcop==0.00) {
                } if ($totAnulaTaqcop<>0.00) {
                    echo number_format($totAnulaTaqcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="blue"><?php if ($totTaquilla==0.00) {
                } if ($totTaquillacop<>0.00) {
                    echo number_format($totTaquillacop, 2, ",", ".");
                }?></font></td>
                    <td align="right" valign="middle"><?php if ($totPTaqPpagcop==0.00) {
                } if ($totPTaqPpagcop<>0.00) {
                    echo number_format($totPTaqPpagcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($porPagarEliTaqcop==0.00) {
                } if ($porPagarEliTaqcop<>0.00) {
                    echo number_format($porPagarEliTaqcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqcop==0.00) {
                    echo " ";
                } if ($totGanPerTaqcop<>0.00) {
                    echo number_format($totGanPerTaqcop, 2, ",", ".");
                }?></font></td>
                    






            <td align="right" valign="middle"><?php
                        $totNcop=$row_Recordset1['con_tic_elicop']*1;
                                            if ($totcop==0) {
                                            }
                                            if ($totcop<>0) {
                                                echo "(".$totNcop.")".number_format($row_Recordset1['tot_eliminadcop'], 2, ",", ".");
                                            }?>
                    </td>
        <td align="right" valign="middle"><?php
                        echo "AM cop(".number_format($porTaquilla, 1, ",", ".")."%)";
                                               
                                                    $totalpagosistemacop=$tCobroAgentecop;
?>							
<font color="red"><?php echo "...(".number_format($totalpagosistemacop, 2, ",", ".").")";
?></font>
                    </td>

                </tr><?php
            }
            
            
            
            
            // cop americanas fin
            
            
            
            
                            
            
            // sol americanas in
            
            
            if ($totVentaTaqsol!=0 or $totPremiTaqsol!=0 or $totAnulaTaqsol!=0 or $totTaquillasol!=0 or $totPTaqPpagsol!=0 or
                $porPagarEliTaqsol!=0 or $totGanPerTaqsol!=0) {?>
                  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" height="20" 
                    style="background:#FFF; font-size:11px">
                    <td align="left" valign="middle"><?php echo $nomsol; ?></td>
                    <td align="right" valign="middle"><?php if ($totVentaTaqsol==0.00) {
                } if ($totVentaTaqsol<>0.00) {
                    echo number_format($totVentaTaqsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totPremiTaqsol==0.00) {
                } if ($totPremiTaqsol<>0.00) {
                    echo number_format($totPremiTaqsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totAnulaTaqsol==0.00) {
                } if ($totAnulaTaqsol<>0.00) {
                    echo number_format($totAnulaTaqsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="blue"><?php if ($totTaquilla==0.00) {
                } if ($totTaquillasol<>0.00) {
                    echo number_format($totTaquillasol, 2, ",", ".");
                }?></font></td>
                    <td align="right" valign="middle"><?php if ($totPTaqPpagsol==0.00) {
                } if ($totPTaqPpagsol<>0.00) {
                    echo number_format($totPTaqPpagsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($porPagarEliTaqsol==0.00) {
                } if ($porPagarEliTaqsol<>0.00) {
                    echo number_format($porPagarEliTaqsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqsol==0.00) {
                    echo " ";
                } if ($totGanPerTaqsol<>0.00) {
                    echo number_format($totGanPerTaqsol, 2, ",", ".");
                }?></font></td>
                    






            <td align="right" valign="middle"><?php
                        $totNsol=$row_Recordset1['con_tic_elisol']*1;
                                            if ($totsol==0) {
                                            }
                                            if ($totsol<>0) {
                                                echo "(".$totNsol.")".number_format($row_Recordset1['tot_eliminadsol'], 2, ",", ".");
                                            }?>
                    </td>
        <td align="right" valign="middle"><?php
                        echo "AM sol(".number_format($porTaquilla, 1, ",", ".")."%)";
                                               
                                                    $totalpagosistemasol=$tCobroAgentesol;
?>							
<font color="red"><?php echo "...(".number_format($totalpagosistemasol, 2, ",", ".").")";
?></font>
                    </td>

                </tr><?php
            }
            
            
            
            
            // sol americanas fin
            
            
             //bs n in
            
            
            
            
            
            
            
            if ($totVentaTaqN!=0 or $totPremiTaqN!=0 or $totAnulaTaqN!=0 or $totTaquillaN!=0 or $totPTaqPpagN!=0 or
                $porPagarEliTaqN!=0 or $totGanPerTaqN!=0) {?>
                  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out2(this)" height="20" 
                    style="background: #00BFFF; font-size:11px">
                    <td align="left" valign="middle"><?php echo $nomN; ?></td>
                    <td align="right" valign="middle"><?php if ($totVentaTaqN==0.00) {
                } if ($totVentaTaqN<>0.00) {
                    echo number_format($totVentaTaqN, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totPremiTaqN==0.00) {
                } if ($totPremiTaqN<>0.00) {
                    echo number_format($totPremiTaqN, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totAnulaTaqN==0.00) {
                } if ($totAnulaTaqN<>0.00) {
                    echo number_format($totAnulaTaqN, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="blue"><?php if ($totTaquillaN==0.00) {
                } if ($totTaquillaN<>0.00) {
                    echo number_format($totTaquillaN, 2, ",", ".");
                }?></font></td>
                    <td align="right" valign="middle"><?php if ($totPTaqPpagN==0.00) {
                } if ($totPTaqPpagN<>0.00) {
                    echo number_format($totPTaqPpagN, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($porPagarEliTaqN==0.00) {
                } if ($porPagarEliTaqN<>0.00) {
                    echo number_format($porPagarEliTaqN, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqN==0.00) {
                } if ($totGanPerTaqN<>0.00) {
                    echo number_format($totGanPerTaqN, 2, ",", ".");
                }?></font></td>
                    



<td align="right" valign="middle"><?php
                        $totN=$row_Recordset2['con_tic_eliN']*1;
                                            if ($totN==0) {
                                            }
                                            if ($totN<>0) {
                                                echo "(".$totN.")".number_format($row_Recordset2['tot_eliminadN'], 2, ",", ".");
                                            }
?>
                    </td>
                    <td align="right" valign="middle">
<?php
if ($totVentaTaqN<>0) { 
if($row_Recordset3['taq_cob_hnac_tipo']==0) { //0
echo "NA(".number_format($row_Recordset3['taq_cob_hnac'], 2, ",", ".");
echo "x".$totalRows_Recordset7.")";
$totVentaTaqNtotalescobro1=$row_Recordset3['taq_cob_hnac']*$totalRows_Recordset7;?>					
<font color="red"><?php
echo "...(".number_format($totVentaTaqNtotalescobro1, 2, ",", ".").")";?>
</font>
<?php }
if($row_Recordset3['taq_cob_hnac_tipo']==1) { //1 
echo "NA BSS(".number_format($porTaquilla, 1, ",", ".")."%)";?>					
<font color="red"><?php
echo "...(".number_format($totVentaTaqNtotalescobro1, 2, ",", ".").")";
?></font><?php }}
?>

</td>
</tr>





                <?php
            }
            
            
            
            
            //bs n fin
            //usd n in
            
            
            if ($totVentaTaqNusd!=0 or $totPremiTaqNusd!=0 or $totAnulaTaqNusd!=0 or $totTaquillaNusd!=0 or $totPTaqPpagNusd!=0 or
                $porPagarEliTaqNusd!=0 or $totGanPerTaqNusd!=0) {?>
                  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out2(this)" height="20" 
                    style="background: #00BFFF; font-size:11px">
                    <td align="left" valign="middle"><?php echo $nomNusd; ?></td>
                    <td align="right" valign="middle"><?php if ($totVentaTaqNusd==0.00) {
                } if ($totVentaTaqNusd<>0.00) {
                    echo number_format($totVentaTaqNusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totPremiTaqNusd==0.00) {
                } if ($totPremiTaqNusd<>0.00) {
                    echo number_format($totPremiTaqNusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totAnulaTaqNusd==0.00) {
                } if ($totAnulaTaqNusd<>0.00) {
                    echo number_format($totAnulaTaqNusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="blue"><?php if ($totTaquillaNusd==0.00) {
                } if ($totTaquillaNusd<>0.00) {
                    echo number_format($totTaquillaNusd, 2, ",", ".");
                }?></font></td>
                    <td align="right" valign="middle"><?php if ($totPTaqPpagNusd==0.00) {
                } if ($totPTaqPpagNusd<>0.00) {
                    echo number_format($totPTaqPpagNusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($porPagarEliTaqNusd==0.00) {
                } if ($porPagarEliTaqNusd<>0.00) {
                    echo number_format($porPagarEliTaqNusd, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqNusd==0.00) {
                } if ($totGanPerTaqNusd<>0.00) {
                    echo number_format($totGanPerTaqNusd, 2, ",", ".");
                }?></font></td>
                    



<td align="right" valign="middle"><?php
                        $totNusd=$row_Recordset2['con_tic_eliNusd']*1;
                                            if ($totNusd==0) {
                                            }
                                            if ($totNusd<>0) {
                                                echo "(".$totNusd.")".number_format($row_Recordset2['tot_eliminadNusd'], 2, ",", ".");
                                            }
?>
                    </td>
                    <td align="right" valign="middle">
<?php
if ($totVentaTaqN<>0) { 
if($row_Recordset3['taq_cob_hnac_tipo']==0) { //0
echo "NA(".number_format($row_Recordset3['taq_cob_hnac'], 2, ",", ".");
echo "x".$totalRows_Recordset7.")";
$totVentaTaqNtotalescobro1=$row_Recordset3['taq_cob_hnac']*$totalRows_Recordset7;?>					
<font color="red"><?php
echo "...(".number_format($totVentaTaqNtotalescobro1, 2, ",", ".").")";?>
</font>
<?php }
if($row_Recordset3['taq_cob_hnac_tipo']==1) { //1 
echo "NA USD(".number_format($porTaquilla, 1, ",", ".")."%)";?>					
<font color="red"><?php
echo "...(".number_format($totVentaTaqNtotalescobro1, 2, ",", ".").")";
?></font><?php }}
?>

</td>
</tr>





                <?php
            }
            
            //usd n fin
            
            
            
                            
            
            
            
            //cop n in
            
            
            if ($totVentaTaqNcop!=0 or $totPremiTaqNcop!=0 or $totAnulaTaqNcop!=0 or $totTaquillaNcop!=0 or $totPTaqPpagNcop!=0 or
                $porPagarEliTaqNcop!=0 or $totGanPerTaqNcop!=0) {?>
                  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out2(this)" height="20" 
                    style="background: #00BFFF; font-size:11px">
                    <td align="left" valign="middle"><?php echo $nomNcop; ?></td>
                    <td align="right" valign="middle"><?php if ($totVentaTaqNcop==0.00) {
                } if ($totVentaTaqNcop<>0.00) {
                    echo number_format($totVentaTaqNcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totPremiTaqNcop==0.00) {
                } if ($totPremiTaqNcop<>0.00) {
                    echo number_format($totPremiTaqNcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totAnulaTaqNcop==0.00) {
                } if ($totAnulaTaqNcop<>0.00) {
                    echo number_format($totAnulaTaqNcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="blue"><?php if ($totTaquillaNcop==0.00) {
                } if ($totTaquillaNcop<>0.00) {
                    echo number_format($totTaquillaNcop, 2, ",", ".");
                }?></font></td>
                    <td align="right" valign="middle"><?php if ($totPTaqPpagNcop==0.00) {
                } if ($totPTaqPpagNcop<>0.00) {
                    echo number_format($totPTaqPpagNcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($porPagarEliTaqNcop==0.00) {
                } if ($porPagarEliTaqNcop<>0.00) {
                    echo number_format($porPagarEliTaqNcop, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqNcop==0.00) {
                } if ($totGanPerTaqNcop<>0.00) {
                    echo number_format($totGanPerTaqNcop, 2, ",", ".");
                }?></font></td>
                    



<td align="right" valign="middle"><?php
                        $totNcop=$row_Recordset2['con_tic_eliNcop']*1;
                                            if ($totNcop==0) {
                                            }
                                            if ($totNcop<>0) {
                                                echo "(".$totNcop.")".number_format($row_Recordset2['tot_eliminadNcop'], 2, ",", ".");
                                            }
?>
                    </td>
                    <td align="right" valign="middle">
<?php
if ($totVentaTaqN<>0) { 
if($row_Recordset3['taq_cob_hnac_tipo']==0) { //0
echo "NA(".number_format($row_Recordset3['taq_cob_hnac'], 2, ",", ".");
echo "x".$totalRows_Recordset7.")";
$totVentaTaqNtotalescobro1=$row_Recordset3['taq_cob_hnac']*$totalRows_Recordset7;?>					
<font color="red"><?php
echo "...(".number_format($totVentaTaqNtotalescobro1, 2, ",", ".").")";?>
</font>
<?php }
if($row_Recordset3['taq_cob_hnac_tipo']==1) { //1 
echo "NA COP(".number_format($porTaquilla, 1, ",", ".")."%)";?>					
<font color="red"><?php
echo "...(".number_format($totVentaTaqNtotalescobro1, 2, ",", ".").")";
?></font><?php }}
?>

</td>
</tr>





                <?php
            }
            
            //cop n fin
            
            
            
            
                                    
            
                            
            
            
            
            
            //sol n in
            
            
            if ($totVentaTaqNsol!=0 or $totPremiTaqNsol!=0 or $totAnulaTaqNsol!=0 or $totTaquillaNsol!=0 or $totPTaqPpagNsol!=0 or
                $porPagarEliTaqNsol!=0 or $totGanPerTaqNsol!=0) {?>
                  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out2(this)" height="20" 
                    style="background: #00BFFF; font-size:11px">
                    <td align="left" valign="middle"><?php echo $nomNsol; ?></td>
                    <td align="right" valign="middle"><?php if ($totVentaTaqNsol==0.00) {
                } if ($totVentaTaqNsol<>0.00) {
                    echo number_format($totVentaTaqNsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totPremiTaqNsol==0.00) {
                } if ($totPremiTaqNsol<>0.00) {
                    echo number_format($totPremiTaqNsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($totAnulaTaqNsol==0.00) {
                } if ($totAnulaTaqNsol<>0.00) {
                    echo number_format($totAnulaTaqNsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="blue"><?php if ($totTaquillaNsol==0.00) {
                } if ($totTaquillaNsol<>0.00) {
                    echo number_format($totTaquillaNsol, 2, ",", ".");
                }?></font></td>
                    <td align="right" valign="middle"><?php if ($totPTaqPpagNsol==0.00) {
                } if ($totPTaqPpagNsol<>0.00) {
                    echo number_format($totPTaqPpagNsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($porPagarEliTaqNsol==0.00) {
                } if ($porPagarEliTaqNsol<>0.00) {
                    echo number_format($porPagarEliTaqNsol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqNsol==0.00) {
                } if ($totGanPerTaqNsol<>0.00) {
                    echo number_format($totGanPerTaqNsol, 2, ",", ".");
                }?></font></td>
                    



<td align="right" valign="middle"><?php
                        $totNsol=$row_Recordset2['con_tic_eliNsol']*1;
                                            if ($totNsol==0) {
                                            }
                                            if ($totNsol<>0) {
                                                echo "(".$totNsol.")".number_format($row_Recordset2['tot_eliminadNsol'], 2, ",", ".");
                                            }
?>
                    </td>
                    <td align="right" valign="middle">
<?php
if ($totVentaTaqN<>0) { 
if($row_Recordset3['taq_cob_hnac_tipo']==0) { //0
echo "NA(".number_format($row_Recordset3['taq_cob_hnac'], 2, ",", ".");
echo "x".$totalRows_Recordset7.")";
$totVentaTaqNtotalescobro1=$row_Recordset3['taq_cob_hnac']*$totalRows_Recordset7;?>					
<font color="red"><?php
echo "...(".number_format($totVentaTaqNtotalescobro1, 2, ",", ".").")";?>
</font>
<?php }
if($row_Recordset3['taq_cob_hnac_tipo']==1) { //1 
echo "NA SOL(".number_format($porTaquilla, 1, ",", ".")."%)";?>					
<font color="red"><?php
echo "...(".number_format($totVentaTaqNtotalescobro1, 2, ",", ".").")";
?></font><?php }}
?>

</td>





<?php
}
?>


</tr>



<?php  
 //sol n fin

//PARLEY in BSS
if ($p_ventas_totales_bs!=0 or $p_premios_pagados_bs!=0 or $p_anulados_pagados_bs!=0 or $p_total_en_caja_bs!=0 or $p_premios_por_pagar_bs!=0 or
$p_anulados_por_pagar_bs!=0 or $p_total_incluye_por_pagar_bs!=0) {?>
  <tr onmouseover="cambiacolor_over1(this)" onmouseout="cambiacolor_out3(this)" height="20" 
    style="background: white; font-size:11px">
    <td align="left" valign="middle"><?php echo $nomP; ?></td>
    <td align="right" valign="middle"><?php if ($p_ventas_totales_bs==0.00) {
} if ($p_ventas_totales_bs<>0.00) {
    echo number_format($p_ventas_totales_bs, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><?php if ($p_premios_pagados_bs==0.00) {
} if ($p_premios_pagados_bs<>0.00) {
    echo number_format($p_premios_pagados_bs, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><?php if ($p_anulados_pagados_bs==0.00) {
} if ($p_anulados_pagados_bs<>0.00) {
    echo number_format($p_anulados_pagados_bs, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><font><?php if ($p_total_en_caja_bs==0.00) {
} if ($p_total_en_caja_bs<>0.00) {
    echo number_format($p_total_en_caja_bs, 2, ",", ".");
}?></font></td>
    <td align="right" valign="middle"><?php if ($p_premios_por_pagar_bs==0.00) {
} if ($p_premios_por_pagar_bs<>0.00) {
    echo number_format($p_premios_por_pagar_bs, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><?php if ($p_anulados_por_pagar_bs==0.00) {
} if ($p_anulados_por_pagar_bs<>0.00) {
    echo number_format($p_anulados_por_pagar_bs, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><font color="red"><?php if ($p_total_incluye_por_pagar_bs==0.00) {
} if ($p_total_incluye_por_pagar_bs<>0.00) {
    echo number_format($p_total_incluye_por_pagar_bs, 2, ",", ".");
}?></font></td>
    
    <?php 
    $p_pago_bs=$p_pago_bs+$p_ventas_totales_bs-$p_anulados_pagados_bs-$p_anulados_por_pagar_bs;
    $p_total_bs=$p_ventas_totales_bs-$p_anulados_pagados_bs-$p_anulados_por_pagar_bs-$p_total_eliminados_bs;
    
    ?>



<td align="right" valign="middle"><?php
        $p_total_eliminados_bs=$row_Recordset50['p_cant_eliminados_bs']*1;
        if ($p_total_eliminados_bs==0) {
        }
        if ($p_total_eliminados_bs<>0) {
            echo "(".$p_total_eliminados_bs.")".number_format($row_Recordset50['p_total_eliminados_bs'], 2, ",", ".");
        }
?>
    </td>
    <td align="right" valign="middle">
    <?php
if ($p_ventas_totales_bs<>0) {
echo "PAR BS(".number_format($p_porcentaje_Taquilla, 1, ",", ".")."%)";
//echo "NA(".number_format($row_Recordset50['taq_por_parley'], 0, ",", ".");
//echo "x".$totalRows_Recordset7.")";
$totalpagosistemaPSOL=$tCobroAgenteP+$p_tCobroAgente_bs;
}
?>					
<font color="red"><?php
if ($p_ventas_totales_bs<>0) {
echo "...(".number_format($p_tCobroAgente_bs, 2, ",", ".").")";
}
}
?></font>

</td>



<?php  
//PARLEY fin BSS
//PARLEY in USD 
if ($p_ventas_totales_usd!=0 or $p_premios_pagados_usd!=0 or $p_anulados_pagados_usd!=0 or $p_total_en_caja_usd!=0 or $p_premios_por_pagar_usd!=0 or
$p_anulados_por_pagar_usd!=0 or $p_total_incluye_por_pagar_usd!=0) {?>
  <tr onmouseover="cambiacolor_over1(this)" onmouseout="cambiacolor_out3(this)" height="20" 
    style="background: white; font-size:11px">
    <td align="left" valign="middle"><?php echo $nomPUSD; ?></td>
    <td align="right" valign="middle"><?php if ($p_ventas_totales_usd==0.00) {
} if ($p_ventas_totales_usd<>0.00) {
    echo number_format($p_ventas_totales_usd, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><?php if ($p_premios_pagados_usd==0.00) {
} if ($p_premios_pagados_usd<>0.00) {
    echo number_format($p_premios_pagados_usd, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><?php if ($p_anulados_pagados_usd==0.00) {
} if ($p_anulados_pagados_usd<>0.00) {
    echo number_format($p_anulados_pagados_usd, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><font><?php if ($p_total_en_caja_usd==0.00) {
} if ($p_total_en_caja_usd<>0.00) {
    echo number_format($p_total_en_caja_usd, 2, ",", ".");
}?></font></td>
    <td align="right" valign="middle"><?php if ($p_premios_por_pagar_usd==0.00) {
} if ($p_premios_por_pagar_usd<>0.00) {
    echo number_format($p_premios_por_pagar_usd, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><?php if ($p_anulados_por_pagar_usd==0.00) {
} if ($p_anulados_por_pagar_usd<>0.00) {
    echo number_format($p_anulados_por_pagar_usd, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><font color="red"><?php if ($p_total_incluye_por_pagar_usd==0.00) {
} if ($p_total_incluye_por_pagar_usd<>0.00) {
    echo number_format($p_total_incluye_por_pagar_usd, 2, ",", ".");
}?></font></td>
    
    <?php 
    $p_pago_usd=$p_pago_usd+$p_ventas_totales_usd-$p_anulados_pagados_usd-$p_anulados_por_pagar_usd;
    $p_total_usd=$p_ventas_totales_usd-$p_anulados_pagados_usd-$p_anulados_por_pagar_usd-$p_total_eliminados_usd;
    
    ?>



<td align="right" valign="middle"><?php
        $p_total_eliminados_usd=$row_Recordset50['p_cant_eliminados_usd']*1;
        if ($p_total_eliminados_usd==0) {
        }
        if ($p_total_eliminados_usd<>0) {
            echo "(".$p_total_eliminados_usd.")".number_format($row_Recordset50['p_total_eliminados_usd'], 2, ",", ".");
        }
?>
    </td>
    <td align="right" valign="middle">
    <?php
if ($p_ventas_totales_usd<>0) {
echo "PAR USD(".number_format($p_porcentaje_Taquilla, 1, ",", ".")."%)";
//echo "NA(".number_format($row_Recordset50['taq_por_parley'], 0, ",", ".");
//echo "x".$totalRows_Recordset7.")";
$totalpagosistemaPSOL=$tCobroAgenteP+$p_tCobroAgente_usd;
}
?>					
<font color="red"><?php
if ($p_ventas_totales_usd<>0) {
echo "...(".number_format($p_tCobroAgente_usd, 2, ",", ".").")";
}
}
?></font>

</td>



<?php  
//PARLEY fin USD
//PARLEY in COP
if ($p_ventas_totales_cop!=0 or $p_premios_pagados_cop!=0 or $p_anulados_pagados_cop!=0 or $p_total_en_caja_cop!=0 or $p_premios_por_pagar_cop!=0 or
$p_anulados_por_pagar_cop!=0 or $p_total_incluye_por_pagar_cop!=0) {?>
  <tr onmouseover="cambiacolor_over1(this)" onmouseout="cambiacolor_out3(this)" height="20" 
    style="background: white; font-size:11px">
    <td align="left" valign="middle"><?php echo $nomPCOP; ?></td>
    <td align="right" valign="middle"><?php if ($p_ventas_totales_cop==0.00) {
} if ($p_ventas_totales_cop<>0.00) {
    echo number_format($p_ventas_totales_cop, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><?php if ($p_premios_pagados_cop==0.00) {
} if ($p_premios_pagados_cop<>0.00) {
    echo number_format($p_premios_pagados_cop, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><?php if ($p_anulados_pagados_cop==0.00) {
} if ($p_anulados_pagados_cop<>0.00) {
    echo number_format($p_anulados_pagados_cop, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><font><?php if ($p_total_en_caja_cop==0.00) {
} if ($p_total_en_caja_cop<>0.00) {
    echo number_format($p_total_en_caja_cop, 2, ",", ".");
}?></font></td>
    <td align="right" valign="middle"><?php if ($p_premios_por_pagar_cop==0.00) {
} if ($p_premios_por_pagar_cop<>0.00) {
    echo number_format($p_premios_por_pagar_cop, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><?php if ($p_anulados_por_pagar_cop==0.00) {
} if ($p_anulados_por_pagar_cop<>0.00) {
    echo number_format($p_anulados_por_pagar_cop, 2, ",", ".");
}?></td>
    <td align="right" valign="middle"><font color="red"><?php if ($p_total_incluye_por_pagar_cop==0.00) {
} if ($p_total_incluye_por_pagar_cop<>0.00) {
    echo number_format($p_total_incluye_por_pagar_cop, 2, ",", ".");
}?></font></td>
    
    <?php 
    $p_pago_cop=$p_pago_cop+$p_ventas_totales_cop-$p_anulados_pagados_cop-$p_anulados_por_pagar_cop;
    $p_total_cop=$p_ventas_totales_cop-$p_anulados_pagados_cop-$p_anulados_por_pagar_cop-$p_total_eliminados_cop;
    
    ?>



<td align="right" valign="middle"><?php
        $p_total_eliminados_cop=$row_Recordset50['p_cant_eliminados_cop']*1;
        if ($p_total_eliminados_cop==0) {
        }
        if ($p_total_eliminados_cop<>0) {
            echo "(".$p_total_eliminados_cop.")".number_format($row_Recordset50['p_total_eliminados_cop'], 2, ",", ".");
        }
?>
    </td>
    <td align="right" valign="middle">
    <?php
if ($p_ventas_totales_cop<>0) {
echo "PAR COP(".number_format($p_porcentaje_Taquilla, 1, ",", ".")."%)";
//echo "NA(".number_format($row_Recordset50['taq_por_parley'], 0, ",", ".");
//echo "x".$totalRows_Recordset7.")";
$totalpagosistemaPSOL=$tCobroAgenteP+$p_tCobroAgente_cop;
}
?>					
<font color="red"><?php
if ($p_ventas_totales_cop<>0) {
echo "...(".number_format($p_tCobroAgente_cop, 2, ",", ".").")";
}
}
?></font>

</td>



<?php  
//PARLEY fin COP
//PARLEY in SOL //aqui
       if ($p_ventas_totales_sol!=0 or $p_premios_pagados_sol!=0 or $p_anulados_pagados_sol!=0 or $p_total_en_caja_sol!=0 or $p_premios_por_pagar_sol!=0 or
                $p_anulados_por_pagar_sol!=0 or $p_total_incluye_por_pagar_sol!=0) {?>
                  <tr onmouseover="cambiacolor_over1(this)" onmouseout="cambiacolor_out3(this)" height="20" 
                    style="background: white; font-size:11px">
                    <td align="left" valign="middle"><?php echo $nomPSOL; ?></td>
                    <td align="right" valign="middle"><?php if ($p_ventas_totales_sol==0.00) {
                } if ($p_ventas_totales_sol<>0.00) {
                    echo number_format($p_ventas_totales_sol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($p_premios_pagados_sol==0.00) {
                } if ($p_premios_pagados_sol<>0.00) {
                    echo number_format($p_premios_pagados_sol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($p_anulados_pagados_sol==0.00) {
                } if ($p_anulados_pagados_sol<>0.00) {
                    echo number_format($p_anulados_pagados_sol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font><?php if ($p_total_en_caja_sol==0.00) {
                } if ($p_total_en_caja_sol<>0.00) {
                    echo number_format($p_total_en_caja_sol, 2, ",", ".");
                }?></font></td>
                    <td align="right" valign="middle"><?php if ($p_premios_por_pagar_sol==0.00) {
                } if ($p_premios_por_pagar_sol<>0.00) {
                    echo number_format($p_premios_por_pagar_sol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><?php if ($p_anulados_por_pagar_sol==0.00) {
                } if ($p_anulados_por_pagar_sol<>0.00) {
                    echo number_format($p_anulados_por_pagar_sol, 2, ",", ".");
                }?></td>
                    <td align="right" valign="middle"><font color="red"><?php if ($p_total_incluye_por_pagar_sol==0.00) {
                } if ($p_total_incluye_por_pagar_sol<>0.00) {
                    echo number_format($p_total_incluye_por_pagar_sol, 2, ",", ".");
                }?></font></td>
                    
                    <?php 
                    $p_pago_sol=$p_pago_sol+$p_ventas_totales_sol-$p_anulados_pagados_sol-$p_anulados_por_pagar_sol;
                    $p_total_sol=$p_ventas_totales_sol-$p_anulados_pagados_sol-$p_anulados_por_pagar_sol-$p_total_eliminados_sol;
                    
                    ?>



<td align="right" valign="middle"><?php
                        $p_total_eliminados_sol=$row_Recordset50['p_cant_eliminados_sol']*1;
                        if ($p_total_eliminados_sol==0) {
                        }
                        if ($p_total_eliminados_sol<>0) {
                            echo "(".$p_total_eliminados_sol.")".number_format($row_Recordset50['p_total_eliminados_sol'], 2, ",", ".");
                        }
?>
                    </td>
                    <td align="right" valign="middle">
                    <?php
if ($p_ventas_totales_sol<>0) {
echo "PAR SOL(".number_format($p_porcentaje_Taquilla, 1, ",", ".")."%)";
//echo "NA(".number_format($row_Recordset50['taq_por_parley'], 0, ",", ".");
//echo "x".$totalRows_Recordset7.")";
$totalpagosistemaPSOL=$tCobroAgenteP+$p_tCobroAgente_sol;
}
?>					
<font color="red"><?php
if ($p_ventas_totales_sol<>0) {
echo "...(".number_format($p_tCobroAgente_sol, 2, ",", ".").")";
} }
?></font>

</td>
</tr>
<?php
//PARLEY fin SOL
                $taquillaspar=$taquillaspar;
                
                //TOTALES bs in 
                $subTotAnupPagar=$subTotAnupPagar+$porPagarEliTaq+$porPagarEliTaqN;
                $subTotEliminados=$subTotEliminados+$row_Recordset1['tot_eliminad']+$row_Recordset2['tot_eliminadN'];
                $subTotCantEli=$subTotCantEli+$tot+$totN+$p_total_eliminados_bs;
                $subTotVenta=$subTotVenta+$totVentaTaq+$totVentaTaqN+$p_ventas_totales_bs; 
    
                $subTotVentaA=$subTotVentaA+$totVentaTaq;
                
                $subTotPremi=$subTotPremi+$totPremiTaq+$totPremiTaqN+$p_premios_pagados_bs;
                $subTotAnula=$subTotAnula+$totAnulaTaq+$totAnulaTaqN+$p_total_anulados_bs;
                $subTotTaquilla=$subTotTaquilla+$totTaquilla+$totTaquillaN+$p_total_en_caja_bs;
                $subPTaqPpag=$subPTaqPpag+$totPTaqPpag+$totPTaqPpagN+$p_premios_por_pagar_bs;
                $subGenGanPerTaq=$subGenGanPerTaq+$totGanPerTaq+$totGanPerTaqN+$p_total_incluye_por_pagar_bs;
                $cobroAgente=$cobroAgente+$tCobroAgente+$tCobroAgenteN+$tCobroAgenteP;
                $eliminadosAgente=$eliminadosAgente+$totalAnulados+$totalAnuladosN+$p_total_anulados_bs;
                
                $eliminadosAgenteA=$eliminadosAgenteA+$totalAnulados;
                
                $subCobroAgenteN=$subCobroAgenteN+$tCobroAgenteN;
                $tPuntosAg=$tPuntosAg+$totalRows_Recordset7;
                
                
                
                
                
                //TOTALES bs fin 
                //TOTALES usd in 
                
                $subTotAnupPagarusd=$subTotAnupPagarusd+$porPagarEliTaqusd+$porPagarEliTaqNusd;
                $subTotEliminadosusd=$subTotEliminadosusd+$row_Recordset1['tot_eliminadusd']+$row_Recordset2['tot_eliminadNusd'];
                $subTotCantEliusd=$subTotCantEliusd+$totusd+$totNusd+$p_total_eliminados_usd;
                $subTotVentausd=$subTotVentausd+$totVentaTaqusd+$totVentaTaqNusd+$p_ventas_totales_usd;
    
                $subTotVentaAusd=$subTotVentaAusd+$totVentaTaqusd;
                
                $subTotPremiusd=$subTotPremiusd+$totPremiTaqusd+$totPremiTaqNusd;
                $subTotAnulausd=$subTotAnulausd+$totAnulaTaqusd+$totAnulaTaqNusd+$p_total_anulados_usd;
                $subTotTaquillausd=$subTotTaquillausd+$totTaquillausd+$totTaquillaNusd+$p_total_en_caja_usd;
                $subPTaqPpagusd=$subPTaqPpagusd+$totPTaqPpagusd+$totPTaqPpagNusd;
                $subGenGanPerTaqusd=$subGenGanPerTaqusd+$totGanPerTaqusd+$totGanPerTaqNusd+$p_total_incluye_por_pagar_usd;
                $cobroAgenteusd=$cobroAgenteusd+$tCobroAgenteusd;
                $eliminadosAgenteusd=$eliminadosAgenteusd+$totalAnuladosusd+$p_total_anulados_usd;
                
                $eliminadosAgenteAusd=$eliminadosAgenteAusd+$totalAnuladosusd;
                
                $subCobroAgenteN=$subCobroAgenteN+$tCobroAgenteN;
                //TOTALES usd fin 
                
                
                
                                
                
                
                
                //TOTALES cop in 
                
                $subTotAnupPagarcop=$subTotAnupPagarcop+$porPagarEliTaqcop+$porPagarEliTaqNcop;
                $subTotEliminadoscop=$subTotEliminadoscop+$row_Recordset1['tot_eliminadcop']+$row_Recordset2['tot_eliminadNcop'];
                $subTotCantElicop=$subTotCantElicop+$totcop+$totNcop+$p_total_eliminados_cop;
                $subTotVentacop=$subTotVentacop+$totVentaTaqcop+$totVentaTaqNcop+$p_ventas_totales_cop;
    
                $subTotVentaAcop=$subTotVentaAcop+$totVentaTaqcop;
                
                $subTotPremicop=$subTotPremicop+$totPremiTaqcop+$totPremiTaqNcop;
                $subTotAnulacop=$subTotAnulacop+$totAnulaTaqcop+$totAnulaTaqNcop+$p_total_anulados_cop;
                $subTotTaquillacop=$subTotTaquillacop+$totTaquillacop+$totTaquillaNcop+$p_total_en_caja_cop;
                $subPTaqPpagcop=$subPTaqPpagcop+$totPTaqPpagcop+$totPTaqPpagNcop;
                $subGenGanPerTaqcop=$subGenGanPerTaqcop+$totGanPerTaqcop+$totGanPerTaqNcop+$p_total_incluye_por_pagar_cop;
                $cobroAgentecop=$cobroAgentecop+$tCobroAgentecop;
                $eliminadosAgentecop=$eliminadosAgentecop+$totalAnuladoscop+$p_total_anulados_cop;
                
                $eliminadosAgenteAcop=$eliminadosAgenteAcop+$totalAnuladoscop;
                
                $subCobroAgenteN=$subCobroAgenteN+$tCobroAgenteN;
                //TOTALES cop fin 
                
                
                                
                
                
                //TOTALES sol in 
                
                $subTotAnupPagarsol=$subTotAnupPagarsol+$porPagarEliTaqsol+$porPagarEliTaqNsol;
                $subTotEliminadossol=$subTotEliminadossol+$row_Recordset1['tot_eliminadsol']+$row_Recordset2['tot_eliminadNsol'];
                $subTotCantElisol=$subTotCantElisol+$totsol+$totNsol+$p_total_eliminados_sol;
                $subTotVentasol=$subTotVentasol+$totVentaTaqsol+$totVentaTaqNsol+$p_ventas_totales_sol;
    
                $subTotVentaAsol=$subTotVentaAsol+$totVentaTaqsol;
                
                $subTotPremisol=$subTotPremisol+$totPremiTaqsol+$totPremiTaqNsol;
                $subTotAnulasol=$subTotAnulasol+$totAnulaTaqsol+$totAnulaTaqNsol+$p_anulados_pagados_sol;
                $subTotTaquillasol=$subTotTaquillasol+$totTaquillasol+$totTaquillaNsol+$p_total_en_caja_sol;
                $subPTaqPpagsol=$subPTaqPpagsol+$totPTaqPpagsol+$totPTaqPpagNsol;
                $subGenGanPerTaqsol=$subGenGanPerTaqsol+$totGanPerTaqsol+$totGanPerTaqNsol+$p_total_incluye_por_pagar_sol;
                $cobroAgentesol=$cobroAgentesol+$tCobroAgentesol;
                $eliminadosAgentesol=$eliminadosAgentesol+$totalAnuladossol+$p_total_anulados_sol;
                
                $eliminadosAgenteAsol=$eliminadosAgenteAsol+$totalAnuladossol;
                
                $subCobroAgenteN=$subCobroAgenteN+$tCobroAgenteN;
                //TOTALES sol fin 
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3)); // aqui terminan las taquillas 
        }
        ?>
            <tr>
              <td colspan="5">&nbsp;</td>
            </tr>
						<?php
                    //TOTALES BSS in    
 if ($subTotVenta!=0 or $subTotPremi!=0 or $subTotAnula!=0 or $subTotTaquilla!=0 or $subPTaqPpag!=0 or
                    $subTotAnupPagar!=0 or $subGenGanPerTaq!=0) { 
     ?>
            <tr bgcolor="#999999" style="font-size:14px;">
              <td height="35" align="right" valign="middle"><strong>TOTALES BSS:</strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotVenta); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotPremi); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotAnula); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotTaquilla); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subPTaqPpag); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotAnupPagar); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subGenGanPerTaq); ?></strong></td>
              <td align="right" valign="middle" style="font-size:12px">
              	<strong><?php echo "(".$subTotCantEli.") ".floor($subTotEliminados); ?></strong>
              </td>
              <td align="right" valign="middle"><strong><?php echo floor($cobroAgente); ?> BSS</strong></td>
            </tr>
			
						<?php
 }//TOTALES BSS fin  
            ?>			
			
			<?php
            //TOTALES usd in 
 if ($subTotVentausd!=0 or $subTotPremiusd!=0 or $subTotAnulausd!=0 or $subTotTaquillausd!=0 or $subPTaqPpagusd!=0 or
                    $subTotAnupPagarusd!=0 or $subGenGanPerTaqusd!=0) {
     ?>
	            <tr bgcolor="#999999" style="font-size:14px;">
              <td height="35" align="right" valign="middle"><strong>TOTALES USD:</strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotVentausd); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotPremiusd); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotAnulausd); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotTaquillausd); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subPTaqPpagusd); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subTotAnupPagarusd); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo floor($subGenGanPerTaqusd); ?></strong></td>
              <td align="right" valign="middle" style="font-size:12px">
              	<strong><?php echo "(".$subTotCantEliusd.") ".floor($subTotEliminadosusd); ?></strong>
              </td>
              <td align="right" valign="middle"><strong><?php echo floor($cobroAgenteusd); ?> USD</strong></td>
            </tr>		
						<?php
 }//TOTALES usd fin 
            ?>
			
			
			<?php
            //TOTALES cop in 
 if ($subTotVentacop!=0 or $subTotPremicop!=0 or $subTotAnulacop!=0 or $subTotTaquillacop!=0 or $subPTaqPpagcop!=0 or
                    $subTotAnupPagarcop!=0 or $subGenGanPerTaqcop!=0) {
     ?>
	            <tr bgcolor="#999999" style="font-size:14px;">
              <td height="35" align="right" valign="middle"><strong>TOTALES COP:</strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotVentacop); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotPremicop); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotAnulacop); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotTaquillacop); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subPTaqPpagcop); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotAnupPagarcop); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subGenGanPerTaqcop); ?></strong></td>
              <td align="right" valign="middle" style="font-size:12px">
              	<strong><?php echo "(".$subTotCantElicop.") ". floor($subTotEliminadoscop); ?></strong>
              </td>
              <td align="right" valign="middle"><strong><?php echo  floor($cobroAgentecop); ?> COP</strong></td>
            </tr>		
						<?php
 } //TOTALES cop fin 
            ?>
			
			
			
							
				
					
			
			
			<?php //TOTALES sol in 
 if ($subTotVentasol!=0 or $subTotPremisol!=0 or $subTotAnulasol!=0 or $subTotTaquillasol!=0 or $subPTaqPpagsol!=0 or
                    $subTotAnupPagarsol!=0 or $subGenGanPerTaqsol!=0) {
     ?>
	            <tr bgcolor="#999999" style="font-size:14px;">
              <td height="35" align="right" valign="middle"><strong>TOTALES SOL:</strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotVentasol); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotPremisol); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotAnulasol); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotTaquillasol); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subPTaqPpagsol); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subTotAnupPagarsol); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo  floor($subGenGanPerTaqsol); ?></strong></td>
              <td align="right" valign="middle" style="font-size:12px">
              	<strong><?php echo "(".$subTotCantElisol.") ". floor($subTotEliminadossol); ?></strong>
              </td>
              <td align="right" valign="middle"><strong><?php echo  floor($cobroAgentesol); ?> SOL</strong></td>
            </tr>		
						<?php
 }//TOTALES sol fin 
            ?>
			
			
			
			
			
            <tr bgcolor="#ffffff" style="font-size:28px;">
              <td height="35" colspan="10" align="right" valign="middle"></td>
            </tr>
            <?php
            
            
            $totSistema=$subTotVentaA-$eliminadosAgenteA;
            $totalPagarSistema=($totSistema*($porcentaje/100));

            


//uso por dia en dolares
if($agen_cob_hnac_tipo==0){ 
    //echo 'corbro'.$corbro;
    //$totalPagarSistemaN=$totVentaTaqNtotales*($agen_cob_hnac/100);
  $totalPagarSistemaN=$corbro*$tPuntosAg; 
}

//porcentaje de ventas nacionales
if($agen_cob_hnac_tipo==1){ 
    $cambiousdabssn=$totVentaTaqNtotalesusd*$row_Recordset555['usdabss'];
    $cambiocopabssn=$totVentaTaqNtotalescop*$row_Recordset555['copabss'];
    $cambiosolabssn=$totVentaTaqNtotalessol*$row_Recordset555['solabss'];

    
    $totalPagarSistemaN=($totVentaTaqNtotales+$cambiousdabssn+$cambiocopabssn+$cambiosolabssn)*($agen_cob_hnac/100); }
                         

            //$totalPagarSistemaN=$corbro*$tPuntosAg;
            
                        $totalPagarSist=$totalPagarSistema+$parleypagobss;
                        $totalGanAgente=$cobroAgente-$totalPagarSist;
                        
                        
                        //usd
                        $totalparleyUSD=$totalusd*$agen_por_parley/100;
            $parleypagoUSD=$parleypagobusd*$row_Recordset555['usdabss']*$agen_por_parley/100;
            $totSistemausd=$subTotVentaAusd-$eliminadosAgenteAusd;
            $totalPagarSistemausd=($totSistemausd*($porcentaje/100));
                        $totalPagarSistusd=$totalPagarSistemausd+$totalparleyUSD;

                        $totalGanAgenteusd=$cobroAgenteusd-$totalPagarSistusd;
                        //usd fin
                        
                                                            
                        
                        //cop
                        $totalparleyCOP=$totalcop*$agen_por_parley/100;
            $parleypagoCOP=$parleypagobcop*$row_Recordset555['copabss']*$agen_por_parley/100;
            $totSistemacop=$subTotVentaAcop-$eliminadosAgenteAcop;
            $totalPagarSistemacop=($totSistemacop*($porcentaje/100));
                        $totalPagarSistcop=$totalPagarSistemacop+$totalparleyCOP;
                        $totalGanAgentecop=$cobroAgentecop-$totalPagarSistcop;
                        //cop fin
                        
                                    
            
                                    
                        
                        //sol
                        $totalparleySOL=$p_total_sol*$agen_por_parley/100;
            $parleypagoSOL=$p_pago_sol*$row_Recordset555['solabss']*$agen_por_parley/100;
            $totSistemasol=$subTotVentaAsol-$eliminadosAgenteAsol;
            $totalPagarSistemasol=($totSistemasol*($porcentaje/100));
                        $totalPagarSistsol=$totalPagarSistemasol+$totalparleySOL;
                        $totalGanAgentesol=$cobroAgentesol-$totalPagarSistsol;
                        //sol fin
                        
                        
                        
                        $cambiousdabss=$totalPagarSistemausd*$row_Recordset555['usdabss']+$parleypagoUSD;
                        $cambiocopabss=$totalPagarSistemacop*$row_Recordset555['copabss']+$parleypagoCOP;
                        $cambiosolabss=$totalPagarSistemasol*$row_Recordset555['solabss']+$parleypagoSOL;
                        
                        $totalapagar=$cambiousdabss+$cambiocopabss+$cambiosolabss+$totalPagarSistemaN+$totalPagarSist;
                        $totalapagarusd=$totalapagar/$row_Recordset555['usdabss'];
                        $totalapagarcop=$totalapagar/$row_Recordset555['copabss'];
                        $totalapagarsol=$totalapagar/$row_Recordset555['solabss'];


                        $gacambiousdabss=$totalGanAgenteusd*$row_Recordset555['usdabss'];
                        $gacambiocopabss=$totalGanAgentecop*$row_Recordset555['copabss'];
                        $gacambiosolabss=$totalGanAgentesol*$row_Recordset555['solabss'];
                        
                        $totalgananciaporreventa=$totalGanAgente+$gacambiousdabss+$gacambiocopabss+$gacambiosolabss;
                        
            mysqli_free_result($Recordset1);
            mysqli_free_result($Recordset2);
            mysqli_free_result($Recordset3);
            mysqli_free_result($Recordset7);
            ?>  
       </table>
	</div><!-- end .mostrar -->
  </div>
  </div>
  <span class="boton-top" title="ir arriba">▲</span>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});
document.getElementById('pagAgen').innerHTML = "<?php echo number_format($totalPagarSist, 2, ",", ".")."&nbsp;BSS"; ?>";
document.getElementById('GanAgen').innerHTML = "<?php echo number_format($totalGanAgente, 2, ",", ".")."&nbsp;BSS"; ?>";

			<?php
            // usd
            ?>
document.getElementById('pagAgenusd').innerHTML = "<?php echo number_format($totalPagarSistusd, 2, ",", ".")."&nbsp;USD > ".number_format($cambiousdabss, 2, ",", ".")."&nbsp;BSS"; ?>";
document.getElementById('GanAgenusd').innerHTML = "<?php echo number_format($totalGanAgenteusd, 2, ",", ".")."&nbsp;USD > ".number_format($gacambiousdabss, 2, ",", ".")."&nbsp;BSS"; ?>";
			<?php
            // usd fin
            ?>
			
						<?php
            // cop
            ?>
document.getElementById('pagAgencop').innerHTML = "<?php echo number_format($totalPagarSistcop, 2, ",", ".")."&nbsp;COP > ".number_format($cambiocopabss, 2, ",", ".")."&nbsp;BSS"; ?>";
document.getElementById('GanAgencop').innerHTML = "<?php echo number_format($totalGanAgentecop, 2, ",", ".")."&nbsp;COP > ".number_format($gacambiocopabss, 2, ",", ".")."&nbsp;BSS"; ?>";
			<?php
            // cop fin
            ?>
			
						<?php
            // sol
            ?>
document.getElementById('pagAgensol').innerHTML = "<?php echo number_format($totalPagarSistsol, 2, ",", ".")."&nbsp;SOL > ".number_format($cambiosolabss, 2, ",", ".")."&nbsp;BSS"; ?>";
document.getElementById('GanAgensol').innerHTML = "<?php echo number_format($totalGanAgentesol, 2, ",", ".")."&nbsp;SOL > ".number_format($gacambiosolabss, 2, ",", ".")."&nbsp;BSS"; ?>";

document.getElementById('totalanacionales').innerHTML = "<?php echo " <br> NACIONALES >> ". number_format($totalPagarSistemaN, 2, ",", ".")."&nbsp;BSS(".$taquillaspar.")"; ?>";





document.getElementById('totalapagarusd').innerHTML = "<?php echo "TOTAL A PAGAR >> ". number_format($totalapagarusd, 2, ",", ".")."&nbsp;USD<br/><br/>"; ?>";
document.getElementById('totalapagarbss').innerHTML = "<?php echo "TOTAL A PAGAR >> ". number_format($totalapagar, 2, ",", ".")."&nbsp;BSS<br/><br/>"; ?>";
document.getElementById('totalapagarcop').innerHTML = "<?php echo "TOTAL A PAGAR >> ". number_format($totalapagarcop, 2, ",", ".")."&nbsp;COP<br/><br/>"; ?>";
document.getElementById('totalapagarsol').innerHTML = "<?php echo "TOTAL A PAGAR >> ". number_format($totalapagarsol, 2, ",", ".")."&nbsp;SOL<br/><br/>"; ?>";




document.getElementById('totalganacia').innerHTML = "<?php echo "TOTAL GANANCIA >> ". number_format($totalgananciaporreventa, 2, ",", ".")."&nbsp;BSS<br/><br/>"; ?>";
			<?php
            // sol fin
            ?>
</script>
</html>
<?php
mysqli_free_result($Recordset4);
mysqli_free_result($Recordset5);
mysqli_free_result($Recordset6);
?>  	

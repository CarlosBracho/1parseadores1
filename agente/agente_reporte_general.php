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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$codigoAgente=$_SESSION['MM_cod_agente'];
$query_Recordset4 = sprintf("/* PARSEADORES1 agente\agente_reporte_general.php - QUERY 1 */ SELECT cod_banca FROM agencia 
	WHERE cod_agencia = %s LIMIT 1", GetSQLValueString($codigoAgente, "int"));
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$banca=$row_Recordset4['cod_banca'];
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
            if ($_POST['id_usuario']!="todos") {
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general.php - QUERY 2 */ SELECT
					ta.cod_taquilla, ta.nom_taquilla, 
					tp.por_taquilla,
					ag.por_agencia,
					SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s 
						THEN ve.mon_venta ELSE 0 END) AS total_venta,
					SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s
						THEN ve.pag_premio ELSE 0 END) AS tot_premios,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.mon_venta ELSE 0 END) AS tot_eliminad,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s 
						THEN ve.mon_venta ELSE 0 END) AS ret_pagos,
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.mon_venta ELSE 0 END) AS ret_total,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
						THEN ve.mon_venta ELSE 0 END) AS ret_porpagar,
					SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s
						THEN ve.mon_venta ELSE 0 END) AS inv_pagos,
					SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.mon_venta ELSE 0 END) AS inv_total,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
						THEN ve.mon_venta ELSE 0 END) AS inv_porpagar,
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
						THEN 1 ELSE 0 END) AS con_tic_eli
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
                    GetSQLValueString($codigoAgente, "int"),
                    GetSQLValueString($_POST['id_usuario'], "int")
                );
                $v=1;
            }
        }
    }
}
if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && isset($_POST['id_usuario']) && $_POST['id_usuario']=="todos") || (!isset($_POST["MM_update"]))) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 agente\agente_reporte_general.php - QUERY 3 */ SELECT
		ta.cod_taquilla, ta.nom_taquilla, 
		tp.por_taquilla,
		ag.por_agencia,
		SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s 
			THEN ve.mon_venta ELSE 0 END) AS total_venta,
		SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s
			THEN ve.pag_premio ELSE 0 END) AS tot_premios,
		SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
			THEN ve.mon_venta ELSE 0 END) AS tot_eliminad,
		SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s 
			THEN ve.mon_venta ELSE 0 END) AS ret_pagos,
		SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
			THEN ve.mon_venta ELSE 0 END) AS ret_total,
		SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
			THEN ve.mon_venta ELSE 0 END) AS ret_porpagar,
		SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s
			THEN ve.mon_venta ELSE 0 END) AS inv_pagos,
		SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
			THEN ve.mon_venta ELSE 0 END) AS inv_total,
		SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
			THEN ve.mon_venta ELSE 0 END) AS inv_porpagar,
		SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
			THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
		SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
			THEN 1 ELSE 0 END) AS con_tic_eli
	FROM
		agencia ag, taquilla ta, taquilla_opc_ame tp, venta ve

	WHERE (ve.fec_venta >= %s AND ve.fec_venta <= %s OR ve.fec_pago >= %s AND ve.fec_pago <= %s) AND 
		ta.cod_agencia = ag.cod_agencia AND ta.cod_taquilla = ve.cod_taquilla AND
		tp.cod_taquilla = ta.cod_taquilla AND ag.cod_agencia = %s
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
        GetSQLValueString($codigoAgente, "int")
    );
    $v=0;
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($v==0 || !isset($v)) {
    $vendedor="TODOS";
    $nomb="TODOS";
}
if ($v==1) {
    $vendedor="Taquilla: ".strtoupper($row_Recordset1['nom_taquilla']);
    $nomb=strtoupper($row_Recordset1['nom_taquilla']);
}
$query_Recordset2 = sprintf("/* PARSEADORES1 agente\agente_reporte_general.php - QUERY 4 */ SELECT cod_taquilla, nom_taquilla FROM taquilla 
	WHERE taquilla.cod_agencia = %s ORDER BY taquilla.nom_taquilla", GetSQLValueString($codigoAgente, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$query_Recordset3 = sprintf("/* PARSEADORES1 agente\agente_reporte_general.php - QUERY 5 */ SELECT info1,info11,info2,info22,info3,info33,info4,info44,info5,info55 FROM banca 
	WHERE cod_banca = %s LIMIT 1", GetSQLValueString($banca, "int"));
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
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


       <div style="background: #5EAEFF; width:100%; float:left; padding:40px 2px 10px 2px;
            color:#FFF; font-size:28px; text-align:center">
            REPORTE SOLO AMERICANAS
       </div><!-- end .container -->
       <div style="background: #FFF; width:100%; float:left; padding:15px 0px 0px 10px;
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
             <select name="id_usuario" id="soflow" style="height:40px; width:280px; margin:-9px 0px 0px 0px ">
                      <option value="todos" >TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset2['cod_taquilla']?>"
               <?php if (strtoupper($row_Recordset2['nom_taquilla'])==$nomb) {
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
       <div style="background: #333; width:915px; float:left; padding:12px 13px 2px 12px;
            color:#FFF; font-size:20px;">
            <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo $vendedor; ?></div>
       </div><!-- end .container -->
       <div id="mostrar" style="width:100%; float:left; padding:0px 0px 150px 0px">
       <table width="100%" border="1" style="color:#000; font-size:11px" bordercolor="#F5F5F5" cellpadding="0" cellspacing="0">
          <tr style="background:#5EAEFF; color:#FFF; font-size:9px; line-height:10px" valign="middle" align="center">
            <td width="12%">TAQUILLA</td>
            <td width="10%">VENTAS</td>
            <td width="10%">PREMIOS PAGADOS</td>
            <td width="8%">ANULADOS PAGADOS</td>
            <td width="10%">TOTAL EN CAJA</td>
            <td width="10%">PREMIOS POR PAGAR</td>
            <td width="8%">ANULADOS POR PAGAR</td>
            <td width="10%">TOTAL<span style="font-size:8px"><br/>INCLUYE TICKETS POR PAGAR</span></td>
            <td width="10%">CANTIDAD TICKET<br/>ELIMINADOS</td>
            <td width="12%">TOTAL A COBRAR AGENTE</td>
          </tr>
        <?php
        $porcentaje=$row_Recordset1['por_agencia'];
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
        if ($totalRows_Recordset1>0) {
            do {
                $nom=$row_Recordset1['nom_taquilla'];
                $porTaquilla=$row_Recordset1['por_taquilla'];
                $totVentaTaq=$row_Recordset1['total_venta'];
                $totPremiTaq=$row_Recordset1['tot_premios'];
                $totAnulaTaq=$row_Recordset1['ret_pagos']+$row_Recordset1['inv_pagos']+$row_Recordset1['tot_eliminad'];
                $totTaquilla=$totVentaTaq-($totPremiTaq+$totAnulaTaq);
                $totPTaqPpag=$row_Recordset1['pre_porpagar'];
                $porPagarEliTaq=$row_Recordset1['ret_porpagar']+$row_Recordset1['inv_porpagar'];
                $totGanPerTaq=$totTaquilla-$totPTaqPpag-$porPagarEliTaq;
                $totalAnulados=$row_Recordset1['ret_total']+$row_Recordset1['inv_total']+$row_Recordset1['tot_eliminad'];
                $tCobroAgente=(($totVentaTaq-$totalAnulados)*$porTaquilla)/100;
                if ($totVentaTaq!=0 or $totPremiTaq!=0 or $totAnulaTaq!=0 or $totTaquilla!=0 or $totPTaqPpag!=0 or
                    $porPagarEliTaq!=0 or $totGanPerTaq!=0 or $tCobroAgente!=0) {?>
					  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" height="20" 
						style="background:# FFF; font-size:11px">
						<td align="left" valign="middle"><?php echo $row_Recordset1['nom_taquilla']; ?></td>
						<td align="right" valign="middle"><?php echo number_format($totVentaTaq, 2, ",", "."); ?></td>
						<td align="right" valign="middle"><?php echo number_format($totPremiTaq, 2, ",", "."); ?></td>
						<td align="right" valign="middle"><?php echo number_format($totAnulaTaq, 2, ",", "."); ?></td>
						<td align="right" valign="middle"><font color="blue"><?php echo number_format($totTaquilla, 2, ",", "."); ?></font></td>
						<td align="right" valign="middle"><?php echo number_format($totPTaqPpag, 2, ",", "."); ?></td>
						<td align="right" valign="middle"><?php echo number_format($porPagarEliTaq, 2, ",", "."); ?></td>
						<td align="right" valign="middle"><font color="red"><?php echo number_format($totGanPerTaq, 2, ",", "."); ?></font></td>
						<td align="right" valign="middle"><?php
                            $tot=$row_Recordset1['con_tic_eli']*1;
                            echo "(".$tot.") ".number_format($row_Recordset1['tot_eliminad'], 2, ",", "."); ?>
						</td>
						<td width="100" align="right" valign="middle">
							<?php echo number_format($tCobroAgente, 2, ",", ".")." (".number_format($porTaquilla, 1, ",", ".")."%)"; ?>
						</td>
					</tr>
					<?php
                }
                $subTotAnupPagar=$subTotAnupPagar+$porPagarEliTaq;
                $subTotEliminados=$subTotEliminados+$row_Recordset1['tot_eliminad'];
                $subTotCantEli=$subTotCantEli+$tot;
                $subTotVenta=$subTotVenta+$totVentaTaq;
                $subTotPremi=$subTotPremi+$totPremiTaq;
                $subTotAnula=$subTotAnula+$totAnulaTaq;
                $subTotTaquilla=$subTotTaquilla+$totTaquilla;
                $subPTaqPpag=$subPTaqPpag+$totPTaqPpag;
                $subGenGanPerTaq=$subGenGanPerTaq+$totGanPerTaq;
                $cobroAgente=$cobroAgente+$tCobroAgente;
                $eliminadosAgente=$eliminadosAgente+$totalAnulados;
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        }
        ?>
            <tr>
              <td colspan="5">&nbsp;</td>
            </tr>
            <tr bgcolor="#999999" style="font-size:14px;">
              <td height="35" align="right" valign="middle"><strong>TOTALES:</strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($subTotVenta, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($subTotPremi, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($subTotAnula, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($subTotTaquilla, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($subPTaqPpag, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($subTotAnupPagar, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($subGenGanPerTaq, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle" style="font-size:12px">
              	<strong><?php echo "(".$subTotCantEli.") ".number_format($subTotEliminados, 2, ",", "."); ?></strong>
              </td>
              <td align="right" valign="middle"><strong><?php echo number_format($cobroAgente, 2, ",", "."); ?></strong></td>
            </tr>
            <tr bgcolor="#ffffff" style="font-size:28px;">
              <td height="35" colspan="10" align="right" valign="middle"></td>
            </tr>
            <?php
            mysqli_free_result($Recordset1);
            mysqli_free_result($Recordset2);
            $totSistema=$subTotVenta-$eliminadosAgente;
            $totalPagarSistema=$totSistema*($porcentaje/100);
            $totalGanAgente=$cobroAgente-$totalPagarSistema;
            ?>  
       </table>
       <div style="background: #333; width:916px; float:left; padding:12px 13px 2px 12px;color:#FFF; font-size:20px;">
       	COSTO DEL SISTEMA DEL AGENTE AL <?php echo number_format($porcentaje, 2, ",", "."); ?>%
       </div>
       <div id="costo" style="width:100%; float:left; padding:0px 0px 0px 0px">
          <table width="941" border="0" style="color:#000; font-size:14px" bordercolor="#F5F5F5">
              <tr style="background:#5EAEFF; color:#FFF" valign="middle" align="center">
                <td width="197" bgcolor="#333">TOTAL VENTAS</td>
                <td width="178" bgcolor="#333">TOTAL  ANULADOS </td>
                <td width="191" bgcolor="#333">TOTAL</td>
                
              </tr>
              <tr style="background: #999; color:# 000" valign="middle" align="center">
                <td height="31" align="right" valign="middle" bgcolor="#FFFFFF"><strong><?php echo number_format($subTotVenta, 2, ",", "."); ?></strong></td>
                <td align="right" valign="middle" bgcolor="#FFFFFF"><strong><?php echo number_format($subTotAnula, 2, ",", "."); ?></strong></td>
                <td align="right" valign="middle" bgcolor="#FFFFFF"><strong><?php echo number_format($totSistema, 2, ",", "."); ?></strong></td>
              </tr>
			  <?php
              if ($row_Recordset3['info1']!="" || $row_Recordset3['info2']!="" || $row_Recordset3['info3']!="" ||
                $row_Recordset3['info4']!="" || $row_Recordset3['info5']!="") {?>
                  <tr bgcolor="#FFC" style="font-size:18px;">
                    <td height="21" colspan="7" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
                  <tr bgcolor="#FFC" style="font-size:18px;">
                    <td height="35" colspan="7" align="center" valign="middle">FORMAS DE PAGO Y FORMAS DE REPORTARLO</td>
                  </tr>
                  <tr bgcolor="#FFC" style="font-size:12px;">
                    <td colspan="7" align="left" valign="middle">
                        <?php
                        if ($row_Recordset3['info1']!="" && $row_Recordset3['info11']!="") {?>
                            <strong><?php echo $row_Recordset3['info1']; ?></strong>
                            <br/>
                            <?php echo $row_Recordset3['info11']; ?>
                            <hr/>
                        <?php
                        }?>    
                        <?php
                        if ($row_Recordset3['info2']!="" && $row_Recordset3['info22']!="") {?>
                            <strong><?php echo $row_Recordset3['info2']; ?></strong>
                            <br/>
                            <?php echo $row_Recordset3['info22']; ?>
                            <hr/>
                        <?php
                        }?>    
                        <?php
                        if ($row_Recordset3['info3']!="" && $row_Recordset3['info33']!="") {?>
                            <strong><?php echo $row_Recordset3['info3']; ?></strong>
                            <br/>
                            <?php echo $row_Recordset3['info33']; ?>
                            <hr/>
                        <?php
                        }?>    
                        <?php
                        if ($row_Recordset3['info4']!="" && $row_Recordset3['info44']!="") {?>
                            <strong><?php echo $row_Recordset3['info4']; ?></strong>
                            <br/>
                            <?php echo $row_Recordset3['info44']; ?>
                            <hr/>
                        <?php
                        }?>    
                        <?php
                        if ($row_Recordset3['info5']!="" && $row_Recordset3['info55']!="") {?>
                            <strong><?php echo $row_Recordset3['info5']; ?></strong>
                            <br/>
                            <?php echo $row_Recordset3['info55']; ?>
                            <hr/>
                        <?php
                        }?>    
                    </td>
                  </tr>
              <?php
              }?>
	          <tr bgcolor="#999" style="font-size:28px;">
                <td colspan="7" align="right" valign="middle"></td>
              </tr>
          </table>  
		</div>          
	</div><!-- end .mostrar -->
  </div>
  </div>
  <span class="boton-top" title="ir arriba">▲</span>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});</script>
</html>
<?php
mysqli_free_result($Recordset3);
mysqli_free_result($Recordset4);
?>  	

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
$query_Recordset6 = sprintf("/* PARSEADORES1 agente\agente_reporte_general_totalold.php - QUERY 1 */ SELECT cod_banca FROM agencia 
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
            } else {
                $final=$_POST['fecha_inicio'];
                $inicio=$_POST['fecha_fin'];
            }
            $in=fechaymd($inicio);
            $fi=fechaymd($final);
            if ($_POST['id_usuario']!="todos") {
                $query_Recordset3 = sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalold.php - QUERY 2 */ SELECT
					ta.cod_taquilla, ta.nom_taquilla, ag.agen_por_ame, ag.agen_cob_hnac 
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
        "/* PARSEADORES1 agente\agente_reporte_general_totalold.php - QUERY 3 */ SELECT
		ta.cod_taquilla, ta.nom_taquilla, ag.agen_por_ame, ag.agen_cob_hnac
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
$query_Recordset4 = sprintf("/* PARSEADORES1 agente\agente_reporte_general_totalold.php - QUERY 4 */ SELECT cod_taquilla, nom_taquilla FROM taquilla 
	WHERE taquilla.cod_agencia = %s ORDER BY taquilla.nom_taquilla", GetSQLValueString($codigoAgente, "int"));
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$query_Recordset5 = sprintf("/* PARSEADORES1 agente\agente_reporte_general_totalold.php - QUERY 5 */ SELECT info1,info11,info2,info22,info3,info33,info4,info44,info5,info55 FROM banca 
	WHERE cod_banca = %s LIMIT 1", GetSQLValueString($banca, "int"));
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
$agen_cob_hnac=$row_Recordset3['agen_cob_hnac'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#9FBFD7" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
	function cambiacolor_out2(celda){ celda.style.backgroundColor="#00BFFF" } 
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
$query_Recordset44 = sprintf("/* PARSEADORES1 agente\agente_reporte_general_totalold.php - QUERY 6 */ SELECT 
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
       	GANANCIA Y TOTAL A PAGAR POR EL SISTEMA  AGENTE AMERICANAS - NACIONALES<br/><br/>
       </div>
	   <div>
		<table width="100%" border="0" style="color:#000; font-size:12px;" cellpadding="0" cellspacing="0">
			
                                <tr style="font-size:16px" valign="middle" align="center">
				<td width="32%" colspan="-2" bgcolor="#00FFFF" style="color:#333">
                     GANANCIA POR VENTA<br/> DEL SISTEMA
                                </td>
				<td width="32%" colspan="-2" bgcolor="#333" style="color:#FFF"><br/>
                    AMERICANAS: <?php echo number_format($row_Recordset3['agen_por_ame'], 2, ",", ".")."%<br/>"; ?>
                    NACIONALES: <?php echo number_format($agen_cob_hnac, 2, ",", ".").""; ?>
				</td>
				<td width="32%" colspan="2" bgcolor="#FF3366" style="color:#FFF">
                    TOTAL A PAGAR<br/> POR EL SISTEMA
				</td>
			</tr>
			<tr style="background: #FFF; color: #000; font-size:14px;">
				<td  bgcolor="#00FFFF" style="color:#333; font-size:24px;" align="right">
                         <div id="GanAgen"></div>
                                </td>
				<td colspan="-2" bgcolor="#333" style="color:#FFF; font-size:14px;" align="center" height="27"></td>
				<td colspan="2" bgcolor="#FF3366" style="color:#FFF; font-size:24px;" align="right">
					<div id="pagAgen"></div>
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
           <td width="11%">TAQUILLA</td>
            <td width="9%">VENTAS</td>
            <td width="9%">PREMIOS <br/>PAGADOS</td>
            <td width="5%">ANULADOS <br/>PAGADOS</td>
            <td width="9%">TOTAL EN<br/> CAJA</td>
            <td width="5%">PREMIOS POR<br/> PAGAR</td>
            <td width="5%">ANULADOS POR<br/> PAGAR</td>
            <td width="9%">TOTAL INCLUYE <br/>TICKETS POR PAGAR</td>
            <td width="10%">CANTIDAD TICKET<br/>ELIMINADOS</td>
            <td width="29%">TOTAL A COBRAR A<br/> TAQUILLA AMERICANA (%)<br/> NACIONALES(X) TOTAL ( )</td>
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
        if ($totalRows_Recordset3>0) {
            do {
                $porcentaje=$row_Recordset3['agen_por_ame'];
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalold.php - QUERY 7 */ SELECT
					ta.nom_taquilla, ta.taq_por_ame,
					ag.agen_por_ame,
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
                    GetSQLValueString($row_Recordset3['cod_taquilla'], "int")
                );
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                $nom=$row_Recordset1['nom_taquilla']."..AME";
                $porTaquilla=$row_Recordset1['taq_por_ame'];
                $totVentaTaq=$row_Recordset1['total_venta'];
                $totPremiTaq=$row_Recordset1['tot_premios'];
                $totAnulaTaq=$row_Recordset1['ret_pagos']+$row_Recordset1['inv_pagos']+$row_Recordset1['tot_eliminad'];
                $totTaquilla=$totVentaTaq-($totPremiTaq+$totAnulaTaq);
                $totPTaqPpag=$row_Recordset1['pre_porpagar'];
                $porPagarEliTaq=$row_Recordset1['ret_porpagar']+$row_Recordset1['inv_porpagar'];
                $totGanPerTaq=$totTaquilla-$totPTaqPpag-$porPagarEliTaq;
                $totalAnulados=$row_Recordset1['ret_total']+$row_Recordset1['inv_total']+$row_Recordset1['tot_eliminad'];
                $tCobroAgente=(($totVentaTaq-$totalAnulados)*$porTaquilla)/100;
                $tot=$row_Recordset1['con_tic_eli'];


                //NACIONALES
                $query_Recordset2 = sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalold.php - QUERY 8 */ SELECT
					ag.agen_cob_hnac, ag.nom_agencia, ta.nom_taquilla,
					SUM(CASE WHEN veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s 
						THEN veN.mon_venta_hnac ELSE 0 END) AS total_ventaN,
					SUM(CASE WHEN veN.est_ticket_hnac = 2 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s
						THEN veN.pag_premio_hnac ELSE 0 END) AS tot_premiosN,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s
						THEN veN.mon_venta_hnac ELSE 0 END) AS tot_eliminadN,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s 
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_pagosN,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_totalN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 4 AND veN.fec_venta_hnac >= %s AND
						veN.fec_venta_hnac <= %s THEN veN.mon_venta_hnac ELSE 0 END) AS ret_porpagarN,
					SUM(CASE WHEN veN.est_ticket_hnac = 5 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_pagosN,
					SUM(CASE WHEN veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_totalN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND
						veN.fec_venta_hnac <= %s THEN veN.mon_venta_hnac ELSE 0 END) AS inv_porpagarN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 2 AND veN.fec_venta_hnac >= %s AND 
						veN.fec_venta_hnac <= %s 
						THEN veN.pag_premio_hnac ELSE 0 END) AS pre_porpagarN,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s AND
						veN.lin_ticket_hnac = 1 THEN 1 ELSE 0 END) AS con_tic_eliN
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
                    GetSQLValueString($codigoAgente, "int"),
                    GetSQLValueString($row_Recordset3['cod_taquilla'], "int")
                );
                $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
                $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
                $nomN=$row_Recordset2['nom_taquilla']."..NAC";
                $porTaquillaN=$row_Recordset2['agen_cob_hnac'];
                $totVentaTaqN=$row_Recordset2['total_ventaN'];
                $totPremiTaqN=$row_Recordset2['tot_premiosN'];
                $totAnulaTaqN=$row_Recordset2['ret_pagosN']+$row_Recordset2['inv_pagosN']+$row_Recordset2['tot_eliminadN'];
                $totTaquillaN=$totVentaTaqN-($totPremiTaqN+$totAnulaTaqN);
                $totPTaqPpagN=$row_Recordset2['pre_porpagarN'];
                $porPagarEliTaqN=$row_Recordset2['ret_porpagarN']+$row_Recordset2['inv_porpagarN'];
                $totGanPerTaqN=$totTaquillaN-$totPTaqPpagN-$porPagarEliTaqN;
                $totalAnuladosN=$row_Recordset2['ret_totalN']+$row_Recordset2['inv_totalN']+$row_Recordset2['tot_eliminadN'];
                $totN=$row_Recordset2['con_tic_eliN'];
                
                $query_Recordset7 =  sprintf(
                    "/* PARSEADORES1 agente\agente_reporte_general_totalold.php - QUERY 9 */ SELECT id_usuario
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
                
                $tCobroAgenteN=$row_Recordset2['agen_cob_hnac']*$totalRows_Recordset7;
                
                if ($totVentaTaq!=0 or $totPremiTaq!=0 or $totAnulaTaq!=0 or $totTaquilla!=0 or $totPTaqPpag!=0 or
                    $porPagarEliTaq!=0 or $totGanPerTaq!=0 or $tCobroAgente!=0) {?>
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
                            echo "AM(".number_format($porTaquilla, 1, ",", ".")."%)";
                                                        echo "NA(".number_format($row_Recordset2['agen_cob_hnac'], 0, ",", ".");
                            echo "x".$totalRows_Recordset7.")";
                                                        $totalpagosistema=$tCobroAgenteN+$tCobroAgente;
?>							
<font color="red"><?php echo "...(".number_format($totalpagosistema, 2, ",", ".").")";
?></font>
						</td>


















					</tr><?php
                }
                if ($totVentaTaqN!=0 or $totPremiTaqN!=0 or $totAnulaTaqN!=0 or $totTaquillaN!=0 or $totPTaqPpagN!=0 or
                    $porPagarEliTaqN!=0 or $totGanPerTaqN!=0 or $tCobroAgenteN!=0) {?>
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
if ($totVentaTaq==0) {
    echo "AM(".number_format($porTaquilla, 1, ",", ".")."%)";
    echo "NA(".number_format($row_Recordset2['agen_cob_hnac'], 0, ",", ".");
    echo "x".$totalRows_Recordset7.")";
    $totalpagosistema=$tCobroAgenteN+$tCobroAgente;
}
?>					
<font color="red"><?php
if ($totVentaTaq==0) {
    echo "...(".number_format($totalpagosistema, 2, ",", ".").")";
}
?></font>

</td>
</tr>






					<?php
                }
                $subTotAnupPagar=$subTotAnupPagar+$porPagarEliTaq+$porPagarEliTaqN;
                $subTotEliminados=$subTotEliminados+$row_Recordset1['tot_eliminad']+$row_Recordset2['tot_eliminadN'];
                $subTotCantEli=$subTotCantEli+$tot+$totN;
                $subTotVenta=$subTotVenta+$totVentaTaq+$totVentaTaqN;
    
                $subTotVentaA=$subTotVentaA+$totVentaTaq;
                
                $subTotPremi=$subTotPremi+$totPremiTaq+$totPremiTaqN;
                $subTotAnula=$subTotAnula+$totAnulaTaq+$totAnulaTaqN;
                $subTotTaquilla=$subTotTaquilla+$totTaquilla+$totTaquillaN;
                $subPTaqPpag=$subPTaqPpag+$totPTaqPpag+$totPTaqPpagN;
                $subGenGanPerTaq=$subGenGanPerTaq+$totGanPerTaq+$totGanPerTaqN;
                $cobroAgente=$cobroAgente+$tCobroAgente+$tCobroAgenteN;
                $eliminadosAgente=$eliminadosAgente+$totalAnulados+$totalAnuladosN;
                
                $eliminadosAgenteA=$eliminadosAgenteA+$totalAnulados;
                
                $subCobroAgenteN=$subCobroAgenteN+$tCobroAgenteN;
                $tPuntosAg=$tPuntosAg+$totalRows_Recordset7;
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
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
            $totSistema=$subTotVentaA-$eliminadosAgenteA;
            $totalPagarSistema=($totSistema*($porcentaje/100));
            $totalPagarSistemaN=$agen_cob_hnac*$tPuntosAg;
                        $totalPagarSist=$totalPagarSistema+$totalPagarSistemaN;
                        $totalGanAgente=$cobroAgente-$totalPagarSist;

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
document.getElementById('pagAgen').innerHTML = "<?php echo number_format($totalPagarSist, 2, ",", ".")."&nbsp;"; ?>";
document.getElementById('GanAgen').innerHTML = "<?php echo number_format($totalGanAgente, 2, ",", ".")."&nbsp;"; ?>";</script>
</html>
<?php
mysqli_free_result($Recordset4);
mysqli_free_result($Recordset5);
mysqli_free_result($Recordset6);
?>  	

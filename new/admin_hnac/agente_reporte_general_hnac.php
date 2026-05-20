<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$codigoAgente=$_SESSION['MM_cod_agente'];
$query_Recordset4 = sprintf("/* PARSEADORES1 new\admin_hnac\agente_reporte_general_hnac.php - QUERY 1 */ SELECT cod_banca FROM agencia 
	WHERE cod_agencia = %s LIMIT 1", GetSQLValueString($codigoAgente, "int"));
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
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
            if ($_POST['id_taquilla']!="todos") {
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 new\admin_hnac\agente_reporte_general_hnac.php - QUERY 2 */ SELECT
					ag.por_agencia_hnac, ag.nom_agencia, ta.nom_taquilla, tp.por_alquiler_hanc,
					SUM(CASE WHEN veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s 
						THEN veN.mon_venta_hnac ELSE 0 END) AS total_ventaN,
					SUM(CASE WHEN veN.est_ticket_hnac = 2 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s 
						THEN veN.pag_premio_hnac ELSE 0 END) AS tot_premiosN,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s
						THEN veN.mon_venta_hnac ELSE 0 END) AS tot_eliminadN,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s
						THEN veN.pag_premio_hnac ELSE 0 END) AS ret_pagosN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 4 AND 
						veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s 
						THEN veN.pag_premio_hnac ELSE 0 END) AS ret_porpagarN,
					SUM(CASE WHEN veN.est_ticket_hnac = 5 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s
						THEN veN.pag_premio_hnac ELSE 0 END) AS inv_pagosN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 5 AND 
						veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s 
						THEN veN.pag_premio_hnac ELSE 0 END) AS inv_porpagarN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 2 AND 
						veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s 
						THEN veN.pag_premio_hnac ELSE 0 END) AS pre_porpagarN
					FROM 
						agencia ag, taquilla ta, taquilla_opc_hnac tp, venta_hnac veN, usuario us
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
                    GetSQLValueString($_POST['id_agente'], "int"),
                    GetSQLValueString($_POST['id_taquilla'], "int")
                );
                $v=1;
            }
        }
    }
}
if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && $_POST['id_taquilla']=="todos") ||
    !isset($_POST["MM_update"])) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\admin_hnac\agente_reporte_general_hnac.php - QUERY 3 */ SELECT
		ag.por_agencia_hnac, ag.nom_agencia, ta.nom_taquilla, tp.por_alquiler_hanc,
		SUM(CASE WHEN veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s 
			THEN veN.mon_venta_hnac ELSE 0 END) AS total_ventaN,
		SUM(CASE WHEN veN.est_ticket_hnac = 2 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s 
			THEN veN.pag_premio_hnac ELSE 0 END) AS tot_premiosN,
		SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s
			THEN veN.mon_venta_hnac ELSE 0 END) AS tot_eliminadN,
		SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s
			THEN veN.pag_premio_hnac ELSE 0 END) AS ret_pagosN,
		SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 4 AND 
			veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s 
			THEN veN.pag_premio_hnac ELSE 0 END) AS ret_porpagarN,
		SUM(CASE WHEN veN.est_ticket_hnac = 5 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s
			THEN veN.pag_premio_hnac ELSE 0 END) AS inv_pagosN,
		SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 5 AND 
			veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s 
			THEN veN.pag_premio_hnac ELSE 0 END) AS inv_porpagarN,
		SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 2 AND 
			veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s 
			THEN veN.pag_premio_hnac ELSE 0 END) AS pre_porpagarN
		FROM 
			agencia ag, taquilla ta, taquilla_opc_hnac tp, venta_hnac veN, usuario us
		WHERE
			((veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s OR veN.fec_pago_hnac >= %s AND
			veN.fec_pago_hnac <= %s) AND us.id_usuario = veN.id_usuario) AND 
			tp.cod_taquilla = ta.cod_taquilla AND ta.cod_taquilla = us.cod_taquilla AND 
			ta.cod_agencia = ag.cod_agencia AND ag.cod_agencia = %s
		GROUP BY ta.cod_taquilla
		ORDER BY ta.nom_taquilla, ta.cod_taquilla",
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
        GetSQLValueString($_SESSION['MM_cod_agente'], "int")
    );
    $v=0;
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if (isset($v) && $v==0) {
    $vendedor="AGENTE: ".strtoupper($_SESSION['MM_nom_agente']);
} else {
    $vendedor="TAQUILLA: ".strtoupper($row_Recordset1['nom_taquilla']);
}
$query_Recordset2 = sprintf("/* PARSEADORES1 new\admin_hnac\agente_reporte_general_hnac.php - QUERY 4 */ SELECT cod_taquilla, nom_taquilla FROM taquilla 
	WHERE cod_agencia = %s ORDER BY nom_taquilla", GetSQLValueString($codigoAgente, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$banca=$row_Recordset4['cod_banca'];
$query_Recordset3 = sprintf("/* PARSEADORES1 new\admin_hnac\agente_reporte_general_hnac.php - QUERY 5 */ SELECT info1,info11,info2,info22,info3,info33,info4,info44,info5,info55 FROM banca 
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
			<?php include("../includes/cabeceraamericana_ag.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
					<?php include("../includes/cabeceraagente_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
				margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
				<?php echo "AGENTE: ".$_SESSION['MM_nom_agente'] ?><br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="height:100%; font-size:26px; padding:50px 0px 100px 0px ">
       <div style="background:#0E5157; width:100%; float:left; padding:40px 2px 10px 2px;
            color:#FFF; font-size:28px; text-align:center">
            REPORTE GENERAL
       NACIONALES</div><!-- end .container -->
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
				<select name="id_taquilla" id="soflow" style="height:40px; width:360px; margin:-9px 0px 0px 0px ">
                      <option value="todos" >TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset2['cod_taquilla']?>">
			   <?php echo strtoupper($row_Recordset2['nom_taquilla']); ?>
               </option>
                      <?php
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                ?>
                    </select>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/>
                <input type="hidden" name="MM_update" value="form1" />
                <input type="hidden" name="id_agente" value="<?php echo $codigoAgente; ?>" />
         </form>  
       </div><!-- end .container -->
       <div style="background: #333; width:915px; float:left; padding:12px 13px 2px 12px;
            color:#FFF; font-size:20px;">
            <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo $vendedor; ?>
            </div>
       </div><!-- end .container -->
	<div>
    	<table width="940" border="0" style="color:#000; font-size:12px;">
				<tr style="font-size:14px" valign="middle" align="center">
				  <td width="444" style="font-size:24px">&nbsp;</td>
					<td width="248" colspan="2" bgcolor="#FF3366" style="color:#FFF">TOTAL A PAGAR POR SISTEMA</td>
					<td width="248" colspan="2" bgcolor="#333" style="color:#FFF">GANANCIA DE AGENTE</td>
				</tr>
		  <tr style="background: #FFF; color: #000; font-size:24px;" valign="middle" align="right" height="37">
					<td></td>
			  <td colspan="2" bgcolor="#FF3366" style="color:#FFF">
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
       
       <div id="mostrar" style="width:100%; float:left; padding:0px 0px 150px 0px">
       <table width="100%" border="0" style="color:#000; font-size:12px" bordercolor="#F5F5F5">
          <tr style="background:#0E5157; color:#FFF" valign="middle" align="center">
            <td width="152">TAQUILLA</td>
            <td width="85">VENTAS</td>
            <td width="85">PREMIOS</td>
            <td width="85">ANULADOS</td>
            <td width="100">TOTAL EN CAJA</td>
            <td width="100">POR PAGAR</td>
            <td width="100">TOTAL<p style="font-size:8px">INCLUYE TICKETS POR PAGAR</p></td>
            <td width="75"> COBRO SISTEMA A TAQUILLA</td>
            <td width="100">TOTAL A COBRAR AGENTE</td>
          </tr>
        <?php
        $aPagAgeN=0;
        $tGanAgeN=0;
        $tVenAgeN=0;
        $tPreAgeN=0;
        $tEliAgeN=0;
        $tCajAgeN=0;
        $xPagAgeN=0;
        $gaPeAgeN=0;
        $tCobAgeN=0;
        $porAgeN=$row_Recordset1['por_agencia_hnac'];//porcentaje taquilla Pacificna
        if ($totalRows_Recordset1>0) {
            do {
                $porTaqN=$row_Recordset1['por_alquiler_hanc'];//porcentaje taquilla Pacificna
                $rPagTaqN=$row_Recordset1['ret_pagosN'];//retirados por pagar Pacificna
                $xRetTaqN=$row_Recordset1['ret_porpagarN'];//retirados pagos Pacificna
                $iPagTaqN=$row_Recordset1['inv_pagosN'];//invalidados por pagar Pacificna
                $xInvTaqN=$row_Recordset1['inv_porpagarN'];//invalidados pagos Pacificna
                $pPagTaqN=$row_Recordset1['pre_porpagarN'];//premios por pagar Pacificna
                $tVenTaqN=$row_Recordset1['total_ventaN']; //total ventas Pacificna
                $tPreTaqN=$row_Recordset1['tot_premiosN']; //total premios Pacificna
                //$tEliTaqN=$row_Recordset1['tot_eliminadA']-$rPagTaqA-$xRetTaqA-$iPagTaqA-$xInvTaqA; //tot elimi Pacificna
                $tEliTaqN=$row_Recordset1['tot_eliminadN']-$rPagTaqN-$iPagTaqN; //total eliminados Pacificna
                $xPagTaqN=$rPagTaqN+$iPagTaqN+$pPagTaqN;// por pagar taquilla Pacificna
                $tCajTaqN=$tVenTaqN-($tPreTaqN+$tEliTaqN); //total en caja Pacificna
                $gaPeTaqN=$tCajTaqN-$xPagTaqN; //ganacia perdida taquilla Pacificna
                $tCobTaqN=($tVenTaqN-$tEliTaqN)*($porTaqN/100);//cobro de sistema Pacificna
                ?>
				<tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" height="20" 
					style="background:# FFF; font-size:14px">
                    <td width="152" align="left" valign="middle">
                        <?php echo $row_Recordset1['nom_taquilla']; ?>
                    </td>
                    <td width="85" align="right" valign="middle">
                        <?php echo number_format($tVenTaqN, 2, ",", "."); ?>
                    </td>
                    <td width="85" align="right" valign="middle">
                        <?php echo number_format($tPreTaqN, 2, ",", "."); ?>
                    </td>
                    <td width="85" align="right" valign="middle">
                        <?php echo number_format($tEliTaqN, 2, ",", "."); ?>
                    </td>
                    <td width="100" align="right" valign="middle">
                        <?php echo number_format($tCajTaqN, 2, ",", "."); ?>
                    </td>
                    <td width="100" align="right" valign="middle">
                        <?php echo number_format($xPagTaqN, 2, ",", "."); ?>
                    </td>
                    <td width="100" align="right" valign="middle">
                        <?php echo number_format($gaPeTaqN, 2, ",", "."); ?>
                    </td>
                    <td width="75" align="right" valign="middle">
                        <?php echo number_format($porTaqN, 2, ",", "."); ?>
                    </td>
                    <td width="100" align="right" valign="middle">
                        <?php echo number_format($tCobTaqN, 2, ",", "."); ?>
                    </td>
				</tr>
				<?php
                $tVenAgeN=$tVenAgeN+$tVenTaqN; // total ventas agente Pacificna
                $tPreAgeN=$tPreAgeN+$tPreTaqN; // total prermios agente Pacificna
                $tEliAgeN=$tEliAgeN+$tEliTaqN; // total anulados agente Pacificna
                $tCajAgeN=$tCajAgeN+$tCajTaqN; // total en caja agente Pacificna
                $xPagAgeN=$xPagAgeN+$xPagTaqN; // total por pagar agente premios Pacificna
                $gaPeAgeN=$gaPeAgeN+$gaPeTaqN; // total ganancia agente Pacificna
                $tCobAgeN=$tCobAgeN+$tCobTaqN; // total sistema agente Pacificna
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
            $aPagAgeN=($tVenAgeN-$tEliAgeN)*($porAgeN/100);
            $tGanAgeN=$tCobAgeN-$aPagAgeN;
        } else {?>
            <tr bgcolor="#FFF" style="font-size:18px;">
              <td colspan="9" height="45" align="left" valign="middle">NO EXISTE VENTAS</td>
            </tr>
            
        <?php
        }
        ?>
            <tr bgcolor="#999999" style="font-size:14px;">
              <td height="35" align="right" valign="middle"><strong>TOTALES:</strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($tVenAgeN, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($tPreAgeN, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($tEliAgeN, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($tCajAgeN, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($xPagAgeN, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle"><strong><?php echo number_format($gaPeAgeN, 2, ",", "."); ?></strong></td>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="right" valign="middle"><strong><?php echo number_format($tCobAgeN, 2, ",", "."); ?></strong></td>
            </tr>
            <tr bgcolor="#ffffff" style="font-size:28px;">
              <td height="35" colspan="9" align="right" valign="middle"></td>
            </tr>
            <?php
            if (isset($Recordset1)) {
                mysqli_free_result($Recordset1);
            }
            if (isset($Recordset2)) {
                mysqli_free_result($Recordset2);
            }
            ?>  
       </table>
       <div style="background: #333; width:916px; float:left; padding:12px 13px 2px 12px;color:#FFF; font-size:20px;">
       	COSTO DEL SISTEMA DEL AGENTE AL <?php echo number_format($porAgeN, 2, ",", "."); ?>%
       </div>
       <div id="costo" style="width:100%; float:left; padding:0px 0px 0px 0px">
          <table width="941" border="0" style="color:#000; font-size:14px" bordercolor="#F5F5F5">
              <tr style="background:#5EAEFF; color:#FFF" valign="middle" align="center">
                <td width="197" bgcolor="#333">TOTAL VENTAS</td>
                <td width="178" bgcolor="#333">TOTAL  ANULADOS </td>
                <td width="191" bgcolor="#333">TOTAL</td>
                <td width="178" bgcolor="#FF3366">TOTAL A PAGAR POR SISTEMA </td>
                <td width="175" style="font-size:16px" bgcolor="#333">GANANCIA DE AGENTE</td>
              </tr>
              <tr style="background: #999; color:# 000" valign="middle" align="center">
                <td height="31" align="right" valign="middle" bgcolor="#FFFFFF"><strong>
				<?php echo number_format($tVenAgeN, 2, ",", "."); ?></strong></td>
                <td align="right" valign="middle" bgcolor="#FFFFFF"><strong>
				<?php echo number_format($tEliAgeN, 2, ",", "."); ?></strong></td>
                <td align="right" valign="middle" bgcolor="#FFFFFF"><strong>
				<?php echo number_format($tVenAgeN-$tEliAgeN, 2, ",", "."); ?></strong></td>
                <td align="right" valign="middle" bgcolor="#FF3366" style="color:#FFF; font-size:20px"><strong>
				<?php echo number_format($aPagAgeN, 2, ",", "."); ?></strong></td>
                <td align="right" valign="middle" bgcolor="#333" style="color:#FFF; font-size:20px"><strong>
				<?php echo number_format($tGanAgeN, 2, ",", "."); ?></strong></td>
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
    <span class="boton-top" title="ir arriba">▲</span>
  </div>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});document.getElementById('ganSis').innerHTML = "<?php echo number_format($aPagAgeN, 2, ",", "."); ?>";document.getElementById('ganDis').innerHTML = "<?php echo number_format($tGanAgeN, 2, ",", "."); ?>";</script>
  
<?php
mysqli_free_result($Recordset3);
mysqli_free_result($Recordset4);
?>  	
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
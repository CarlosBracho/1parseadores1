<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset12 = sprintf(
    "/* PARSEADORES1 distri\distri_reporte_general_total borrar .php - QUERY 1 */ SELECT dist_por_ame, dist_cob_hnac FROM banca WHERE cod_banca = %s LIMIT 1",
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 distri\distri_reporte_general_total borrar .php - QUERY 2 */ SELECT *
	FROM agencia ag
	WHERE ag.cod_banca = %s
	ORDER BY ag.nom_agencia ASC",
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
                    "/* PARSEADORES1 distri\distri_reporte_general_total borrar .php - QUERY 3 */ SELECT *
					FROM agencia ag
					WHERE ag.cod_agencia = %s",
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
    "/* PARSEADORES1 distri\distri_reporte_general_total borrar .php - QUERY 4 */ SELECT ag.cod_agencia, ag.nom_agencia
	FROM agencia ag
	WHERE ag.cod_banca = %s
	ORDER BY ag.nom_agencia ASC",
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseDistri.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
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
<?php
$query_Recordset44 = sprintf("/* PARSEADORES1 distri\distri_reporte_general_total borrar .php - QUERY 5 */ SELECT 
	me.mensaje
	FROM mensajesyalertas me
	USE INDEX(mostrarhasta) 
	WHERE 
	(me.mostrarhasta >= CURDATE()) AND 
    ((tipo = 6 AND me.para = %s)) 		
	ORDER BY RAND() LIMIT 1", GetSQLValueString($_SESSION['MM_cod_banca'], "int"));
$Recordset44 = mysqli_query($conexionbanca, $query_Recordset44) or die(mysqli_error($conexionbanca));
$row_Recordset44 = mysqli_fetch_assoc($Recordset44);
$totalRows_Recordset44 = mysqli_num_rows($Recordset44);
$mensaje44 = trim($row_Recordset44['mensaje']);
mysqli_free_result($Recordset44);
?>
<font size="6" style="color:red;" align="center"><?php echo $mensaje44;?></font><br/><br/>
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceradistri.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->

        <table width="100%" HEIGHT=100 border="0" >
          <tr HEIGHT=30>
             <td VALIGN=BOTTOM bgcolor="#333" style="color:#FFF">	
             </td>
	     <td bgcolor="#333" style="color:#FFF">
	     </td>
	     <td VALIGN=BOTTOM bgcolor="#333" style="color:#FFF" ALIGN=RIGHT>
                 Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
                 <span id="reloj"></span>
	     </td>
          </tr>
          <tr>
             <td VALIGN=BOTTOM bgcolor="#333" style="color:#FFF">
                REPORTE GLOBAL	<br/><br/>
             </td>
	     <td>
                <a href="../guias/registro_de_pago.php" target="_blank"><img src="../images/pagoenlinea.png" width="270" height="65"  alt="Pago en Linea" /></a>
	     </td>
	     <td>
	     </td>
          </tr>
        </table>

  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  <div style="height:100%; font-size:26px; padding:0px 0px 100px 0px ">
         <div style="background: #7DCEA0; width:100%; float:left; padding:20px 2px 10px 2px;
            color:#000; font-size:28px; text-align:center; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
            REPORTE GLOBAL DE VENTAS
       </div><!-- end .container -->





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
       <div style="background: #333; width:915px; float:left; padding:12px 13px 2px 12px;color:#FFF; font-size:20px;">
       	GANANCIA Y TOTAL A PAGAR POR EL SISTEMA DISTRIBUIDOR AMERICANAS - NACIONALES<br/><br/>
       </div>
	   <div>
		<table width="100%" border="0" style="color:#000; font-size:12px;" cellpadding="0" cellspacing="0">
			<tr style="font-size:16px" valign="middle" align="center">
				<td width="33%" colspan="2" bgcolor="#00FFFF" style="color:#333">
                                   GANANCIA POR VENTA<br/> DEL SISTEMA
                                 </td>
				<td width="33%" colspan="-2" bgcolor="#333" style="color:#FFF"><br/>
                    AMERICANAS: <?php echo number_format($row_Recordset12['dist_por_ame'], 2, ",", ".")."%<br/>"; ?>
                    NACIONALES: <?php echo number_format($row_Recordset12['dist_cob_hnac'], 2, ",", ".").""; ?>
				</td>
				<td width="33%" colspan="2" bgcolor="#FF3366" style="color:#FFF">
                    TOTAL A PAGAR<br/> POR EL SISTEMA
				</td>
			         </tr>
			<tr style="background: #FFF; color: #000; font-size:14px;">
				<td colspan="2" bgcolor="#00FFFF" style="color:#333; font-size:24px;" align="right">       
					<div id="GanDistri"></div>

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
       
   <div style="background:#CCC; width:915px; float:left; padding:12px 13px 0px 12px;
      color:#000; font-size:20px;">
   <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo ""; ?></div>
   </div><!-- end .container -->
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
            $subTotTaquilla=0;
            $totGanPerTaq=0;
            $subGenGanPerTaq=0;
            $totCobraBanca=0;
            $totCobraBancaN=0;
            $tVe=0;
            $tPr=0;
            $tAn=0;
            $tTc=0;
            $tPp=0;
            $Tge=0;
            $tPuntosBa=0;
            $tPremPagosAg=0;
            $tVtasAg=0;
            $tAnulAg=0;
            $tCajaAg=0;
            $tPremPagarAg=0;
            $tAnulPagarAg=0;
            $totalAg=0;
            $tCantTickElimAg=0;
            $tMontTickElimAg=0;
            $tCobrAg=0;
           if ($totalRows_Recordset3>0) {
               do {
                   $codigoAgente=$row_Recordset3['cod_agencia'];
                   $porcentaje=$row_Recordset3['agen_por_ame'];
                   $agen_cob_hnac=$row_Recordset3['agen_cob_hnac']; ?>
       			
				
				
				
				
				
				
				
				
				
				
				<table width="100%" border="0" style="color:#000; font-size:11px" bordercolor="#F5F5F5" cellpadding="0" 
                	cellspacing="0">
                    <tr style="background:#333; color:#FFF; border-color:#333" valign="middle" align="center">
                        <td height="35" colspan="12" align="left" style="font-size:18px">
                            <strong>
                            <?php
                            echo $row_Recordset3['nom_agencia']." | Teléfono: ".$row_Recordset3['tel_agencia']." ";
                   echo "| Correo: ".$row_Recordset3['cor_agencia']; ?>
                        </strong></td>
                    </tr>
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
            <td width="29%">TOTAL A COBRAR Al<br/> TAQUILLA AMERICANA (%)<br/> NACIONALES(X) TOTAL ( )</td>
          </tr>

		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
					<?php
                    $query_Recordset30 = sprintf(
                       "/* PARSEADORES1 distri\distri_reporte_general_total borrar .php - QUERY 6 */ SELECT cod_taquilla, nom_taquilla
						FROM taquilla
						WHERE cod_agencia = %s
						ORDER BY nom_taquilla ASC",
                       GetSQLValueString($codigoAgente, "int")
                   );
                   $Recordset30 = mysqli_query($conexionbanca, $query_Recordset30) or die(mysqli_error($conexionbanca));
                   $row_Recordset30 = mysqli_fetch_assoc($Recordset30);
                   $totalRows_Recordset30 = mysqli_num_rows($Recordset30);
                   $tPuntosAg=0;
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
                   $subTotVentaA=0;
                   $subTotVentaN=0;
                   $eliminadosAgenteA=0;
                   $eliminadosAgenteN=0;
                   $subCobroAgenteN=0;
                   $subTotAnulaA=0;
                   $subTotAnulaN=0;
                   $tVtasAgAme=0;
                   $tVtasAgNac=0;
                   $tPremPagosAgAme=0;
                   $tPremPagosAgNac=0;
                   $tAnulAgAme=0;
                   $tAnulAgNac=0;
                   $tCajaAgAme=0;
                   $tCajaAgNac=0;
                   $tPremPagarAgAme=0;
                   $tPremPagarAgNac=0;
                   $tAnulPagarAgAme=0;
                   $tAnulPagarAgNac=0;
                   $totalAgAme=0;
                   $totalAgNac=0;
                   $tCantTickElimAgAme=0;
                   $tCantTickElimAgNac=0;
                   $tMontTickElimAgAme=0;
                   $tMontTickElimAgNac=0;
                   $tCobrAgAme=0;
                   $tCobrAgNac=0;
                   if ($totalRows_Recordset30>0) {
                       do {
                           $codigoTaquilla=$row_Recordset30['cod_taquilla'];
                           $nom=$row_Recordset30['nom_taquilla']."..AME";
                           $nomN=$row_Recordset30['nom_taquilla']."..NAC";
                           $query_Recordset1 = sprintf(
                               "/* PARSEADORES1 distri\distri_reporte_general_total borrar .php - QUERY 7 */ SELECT
								ta.cod_taquilla, ta.nom_taquilla, 
								tp.por_taquilla,
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
								ag.cod_agencia = ta.cod_agencia AND ta.cod_taquilla = ve.cod_taquilla AND
								tp.cod_taquilla = ta.cod_taquilla AND ta.cod_taquilla = %s 
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
                               GetSQLValueString($codigoTaquilla, "int")
                           );
                           $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                           $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                           $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                           ////NACIONALES
                           $query_Recordset21 = sprintf(
                               "/* PARSEADORES1 distri\distri_reporte_general_total borrar .php - QUERY 8 */ SELECT
								ta.cod_taquilla, ta.nom_taquilla, ag.agen_cob_hnac,
								SUM(CASE WHEN ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s 
									THEN ve.mon_venta_hnac ELSE 0 END) AS total_ventaN,
								SUM(CASE WHEN ve.est_ticket_hnac = 2 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
									THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premiosN,
								SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
									THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminadN,
								SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s 
									THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagosN,
								SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
									THEN ve.mon_venta_hnac ELSE 0 END) AS ret_totalN,
								SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND ve.fec_venta_hnac >= %s AND
									ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagarN,
								SUM(CASE WHEN ve.est_ticket_hnac = 5 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
									THEN ve.mon_venta_hnac ELSE 0 END) AS inv_pagosN,
								SUM(CASE WHEN ve.est_calculo_hnac = 5 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
									THEN ve.mon_venta_hnac ELSE 0 END) AS inv_totalN,
								SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 5 AND ve.fec_venta_hnac >= %s AND 
									ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS inv_porpagarN,
								SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 2 AND ve.fec_venta_hnac >= %s AND
									ve.fec_venta_hnac <= %s THEN ve.pag_premio_hnac ELSE 0 END) AS pre_porpagarN,
								SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s AND
									ve.lin_ticket_hnac = 1 THEN 1 ELSE 0 END) AS con_tic_eliN
							FROM
								agencia ag, taquilla ta, usuario us, taquilla_opc_hnac tp, venta_hnac ve
							WHERE (((ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s) OR (ve.fec_pago_hnac >= %s AND 
								ve.fec_pago_hnac <= %s)) AND us.id_usuario = ve.id_usuario) AND 
								ag.cod_agencia = ta.cod_agencia AND us.cod_taquilla = ta.cod_taquilla AND
								tp.cod_taquilla = ta.cod_taquilla AND ta.cod_taquilla = %s 
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
                               GetSQLValueString($codigoTaquilla, "int")
                           );
                           $Recordset21 = mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
                           $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
                           $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
                           $query_Recordset22 =  sprintf(
                               "/* PARSEADORES1 distri\distri_reporte_general_total borrar .php - QUERY 9 */ SELECT cob_taquilla_hnac
								FROM  
								cobro_hnac co, taquilla_opc_hnac tp
								WHERE 
								co.cod_taquilla = %s AND tp.cod_taquilla = co.cod_taquilla AND
								co.fec_creacion >= %s AND co.fec_creacion <= %s",
                               GetSQLValueString($row_Recordset21['cod_taquilla'], "int"),
                               GetSQLValueString($in, "date"),
                               GetSQLValueString($fi, "date")
                           );
                           $Recordset22 = mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
                           $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
                           $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
                           $porTaquilla=$row_Recordset1['por_taquilla'];
                           $totVentaTaq=$row_Recordset1['total_venta'];
                           $totPremiTaq=$row_Recordset1['tot_premios'];
                           $totAnulaTaq=$row_Recordset1['ret_pagos']+$row_Recordset1['inv_pagos']+$row_Recordset1['tot_eliminad'];
                           $porPagarEliTaq=$row_Recordset1['ret_porpagar']+$row_Recordset1['inv_porpagar'];
                           $totPTaqPpag=$row_Recordset1['pre_porpagar'];
                           $totTaquilla=$totVentaTaq-($totPremiTaq+$totAnulaTaq);
                           $totGanPerTaq=$totTaquilla-$totPTaqPpag-$porPagarEliTaq;
                           $totalAnulados=$row_Recordset1['ret_total']+$row_Recordset1['inv_total']+$row_Recordset1['tot_eliminad'];
                           $tCobroAgente=(($totVentaTaq-$totalAnulados)*$porTaquilla)/100;
                           $porTaquillaN=$row_Recordset22['cob_taquilla_hnac'];
                           $totVentaTaqN=$row_Recordset21['total_ventaN'];
                           $totPremiTaqN=$row_Recordset21['tot_premiosN'];
                           $totAnulaTaqN=$row_Recordset21['ret_pagosN']+$row_Recordset21['inv_pagosN']+$row_Recordset21['tot_eliminadN'];
                           $porPagarEliTaqN=$row_Recordset21['ret_porpagarN']+$row_Recordset21['inv_porpagarN'];
                           $totPTaqPpagN=$row_Recordset21['pre_porpagarN'];
                           $totTaquillaN=$totVentaTaqN-($totPremiTaqN+$totAnulaTaqN);
                           $totGanPerTaqN=$totTaquillaN-$totPTaqPpagN-$porPagarEliTaqN;
                           $totalAnuladosN=$row_Recordset21['ret_totalN']+$row_Recordset21['inv_totalN']+$row_Recordset21['tot_eliminadN'];
                           $tCobroAgenteN=$row_Recordset22['cob_taquilla_hnac']*$totalRows_Recordset22;
                           $tot=$row_Recordset1['con_tic_eli']*1;
                           $totN=$row_Recordset21['con_tic_eliN']*1;
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
                                                        echo "NA(".number_format($porTaquillaN, 0, ",", ".");
                            echo "x".$totalRows_Recordset22.")";
                                                        $totalpagosistema=$tCobroAgenteN+$tCobroAgente;
?>							
<font color="red"><?php echo "...(".number_format($totalpagosistema, 2, ",", ".").")";
?></font>
						</td>
























<?php
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
    echo "NA(".number_format($porTaquillaN, 0, ",", ".");
    echo "x".$totalRows_Recordset22.")";
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
                           $tVtasAgAme=$tVtasAgAme+$totVentaTaq;
                           $tVtasAgNac=$tVtasAgNac+$totVentaTaqN;
                           $tVtasAg=$tVtasAgAme+$tVtasAgNac;
                           $tPremPagosAgAme=$tPremPagosAgAme+$totPremiTaq;
                           $tPremPagosAgNac=$tPremPagosAgNac+$totPremiTaqN;
                           $tPremPagosAg=$tPremPagosAgNac+$tPremPagosAgAme;
                           $tAnulAgAme=$tAnulAgAme+$totAnulaTaq;
                           $tAnulAgNac=$tAnulAgNac+$totAnulaTaqN;
                           $tAnulAg=$tAnulAgAme+$tAnulAgNac;
                           $tCajaAgAme=$tCajaAgAme+$totTaquilla;
                           $tCajaAgNac=$tCajaAgNac+$totTaquillaN;
                           $tCajaAg=$tCajaAgAme+$tCajaAgNac;
                           $tPremPagarAgAme=$tPremPagarAgAme+$totPTaqPpag;
                           $tPremPagarAgNac=$tPremPagarAgNac+$totPTaqPpagN;
                           $tPremPagarAg=$tPremPagarAgAme+$tPremPagarAgNac;
                           $tAnulPagarAgAme=$tAnulPagarAgAme+$porPagarEliTaq;
                           $tAnulPagarAgNac=$tAnulPagarAgNac+$porPagarEliTaqN;
                           $tAnulPagarAg=$tAnulPagarAgAme+$tAnulPagarAgNac;
                           $totalAgAme=$totalAgAme+$totGanPerTaq;
                           $totalAgNac=$totalAgNac+$totGanPerTaqN;
                           $totalAg=$totalAgAme+$totalAgNac;
                           $tCantTickElimAgAme=$tCantTickElimAgAme+$tot;
                           $tCantTickElimAgNac=$tCantTickElimAgNac+$totN;
                           $tCantTickElimAg=$tCantTickElimAgAme+$tCantTickElimAgNac;
                           $tMontTickElimAgAme=$tMontTickElimAgAme+$row_Recordset1['tot_eliminad'];
                           $tMontTickElimAgNac=$tMontTickElimAgNac+$row_Recordset21['tot_eliminadN'];
                           $tMontTickElimAg=$tMontTickElimAgAme+$tMontTickElimAgNac;
                           $tCobrAgAme=$tCobrAgAme+$tCobroAgente;
                           $tCobrAgNac=$tCobrAgNac+$tCobroAgenteN;
                           $tCobrAg=$tCobrAgAme+$tCobrAgNac;
                           $tPuntosAg=$tPuntosAg+$totalRows_Recordset22;
                           $tVe=$tVe+$totVentaTaq;
                           $tPr=$tPr+$totPremiTaq;
                           $tAn=$tAn+$totAnulaTaq;
                           $tTc=$tTc+$totTaquilla;
                           $tPp=$tPp+$totPTaqPpag;
                           $Tge=$Tge+$totGanPerTaq;
                           $subTotAnulaA=$subTotAnulaA+$totAnulaTaq;
                           $subTotAnulaN=$subTotAnulaN+$totAnulaTaqN;
                           $subTotVentaA=$subTotVentaA+$totVentaTaq;//total ventas ame
                            $subTotVentaN=$subTotVentaN+$totVentaTaqN;//total ventas ame
                            $eliminadosAgenteA=$eliminadosAgenteA+$totalAnulados;
                           $eliminadosAgenteN=$eliminadosAgenteN+$totalAnuladosN;
                       } while ($row_Recordset30 = mysqli_fetch_assoc($Recordset30)); ?>
						<tr bgcolor="#FFFFFF">
						  <td colspan="10">&nbsp;</td>
						</tr>
						<tr bgcolor="#999999" style="font-size:12px;">
						  <td height="35" align="right" valign="middle"><strong>TOTALES:</strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tVtasAg, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tPremPagosAg, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tAnulAg, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tCajaAg, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tPremPagarAg, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tAnulPagarAg, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($totalAg, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo "(".$tCantTickElimAg.") ".number_format($tMontTickElimAg, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tCobrAg, 2, ",", "."); ?></strong>
                          </td>
						</tr>
						<?php
                   }
                   $totSistemaA=$subTotVentaA-$eliminadosAgenteA;
                   $totSistemaN=$subTotVentaN-$eliminadosAgenteN;
                   $totalPagarSistemaA=$totSistemaA*($porcentaje/100);
                   $totalPagarSistemaN=$tPuntosAg*$agen_cob_hnac;
                   $totVentaBanca=$totVentaBanca+$subTotVentaA;
                   $totAnulaBanca=$totAnulaBanca+$eliminadosAgenteA;
                   $totCobraBanca=$totCobraBanca+$totalPagarSistemaA;
                   $totCobraBancaN=$totCobraBancaN+$totalPagarSistemaN;
                   $tPuntosBa=$tPuntosBa+$tPuntosAg; ?>  
				   </table>
      			   <div style="background: #333; width:910px; float:left; padding:12px 13px 2px 12px;color:#FFF; font-size:20px;">
					<?php echo $row_Recordset3['nom_agencia']."&nbsp;|&nbsp;"; ?>
                    COSTO DEL SISTEMA AMERICANAS: <?php echo number_format($porcentaje, 2, ",", "."); ?>% - 
                    NACIONALES: <?php echo number_format($agen_cob_hnac, 2, ",", "."); ?>
                   </div>
      			   <div id="costo1" style="width:100%; float:left; padding:0px 0px 0px 0px">
					   <table width="934" border="0" style="color:#000; font-size:16px" bordercolor="#F5F5F5">
						  <tr style="background:#5EAEFF; color:#FFF" valign="middle" align="center">
							<td height="46" bgcolor="#333">&nbsp;</td>
							<td width="218" bgcolor="#7DCEA0">TOTAL A COBRAR AL AGENTE</td>
						  </tr>
						  <tr style="background: #999; color:# 000" valign="middle" align="center">
							<td align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;
                            </td>
							<td align="right" valign="middle" bgcolor="#7DCEA0" style="color:#FFF; font-size:20px">
                            	<strong><?php echo number_format($totalPagarSistemaA+$totalPagarSistemaN, 2, ",", "."); ?></strong>
                            </td>
						  </tr>
						  <tr bgcolor="#999" style="font-size:28px;">
							<td height="20" colspan="4" align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
						  </tr>
                      </table>    
				<?php
               } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
               $totGenBanca=$totVentaBanca-$totAnulaBanca;
               $cobroaBanca=($totGenBanca*$row_Recordset12['dist_por_ame'])/100;
               $cobroaBancaN=$row_Recordset12['dist_cob_hnac']*$tPuntosBa;
               $costosistema=$cobroaBanca+$cobroaBancaN;
               $ganBanca1=$totCobraBanca+$totCobraBancaN;
               $ganBanca=$ganBanca1-$costosistema; ?>
                <HR/>
	    <div style="background:#7DCEA0; width:910px; float:left; padding:12px 13px 2px 12px;font-size:20px; color:#000">
					<strong>COSTO DEL SISTEMA DE AGENTE(S)</strong>
          </div>
				   <div id="costo2" style="width:100%; float:left; padding:0px 0px 0px 0px">
					   <table width="934" border="0" style="color:#000; font-size:16px" bordercolor="#F5F5F5">
						  <tr style="background:#7DCEA0; color:#000" valign="middle" align="center">
							<td width="629" bgcolor="#7DCEA0">&nbsp;</td>
							<td width="295" bgcolor="#7DCEA0" style="color:#333">TOTAL A COBRAR POR SISTEMA A AGENTES</td>
					     </tr>
						  <tr style="background: #999; color:# 000" valign="middle" align="center">
							<td height="36" align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;
                            </td>
							<td align="right" valign="middle" bgcolor="#7DCEA0" style="color:#333; font-size:20px">
                            	<strong><?php echo number_format($totCobraBanca+$totCobraBancaN, 2, ",", "."); ?></strong>
                            </td>
						  </tr>
						  <tr bgcolor="#999" style="font-size:28px;">
							<td height="20" colspan="4" align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
						  </tr>
                      </table>
                   </div>       
		   <?php
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
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});
document.getElementById('pagAgen').innerHTML = "<?php echo number_format($costosistema, 2, ",", ".")."&nbsp;"; ?>";
document.getElementById('GanDistri').innerHTML = "<?php echo number_format($ganBanca, 2, ",", ".")."&nbsp;"; ?>";

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
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "S"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$iniciod=fechaactualbd().' 00:00:01';
$finald=fechaactualbd().' 23:59:59';
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
$totSistemaA=0;
$query_Recordset555 = sprintf("/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 1 */ SELECT * FROM tasadecambio WHERE Idtasadecambio = 1");
$Recordset555 = mysqli_query($conexionbanca, $query_Recordset555) or die(mysqli_error($conexionbanca));
$row_Recordset555 = mysqli_fetch_assoc($Recordset555);
$totalRows_Recordset555 = mysqli_num_rows($Recordset555);

$query_Recordset18 = sprintf(
"/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 2 */ SELECT nom_banca, cod_banca  
FROM banca, multidistriMD
WHERE multidistriMD.cod_multidistriMD = banca.cod_multidistriMDBA AND
multidistriMD.cod_multidistriMD = %s 
ORDER BY banca.nom_banca",
GetSQLValueString($_SESSION['MM_cod_multidistriMD'], "int"));
$Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);
$nomb2="TODOS";


if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
    
    $codigobanca=$_POST['Banca'];
}

$query_Recordsetleo = sprintf(
    "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 3 */ SELECT  * FROM multidistriMD WHERE cod_multidistriMD  = %s",
    GetSQLValueString($_SESSION['MM_cod_multidistriMD'], "int"));
$Recordsetleo = mysqli_query($conexionbanca, $query_Recordsetleo) or die(mysqli_error($conexionbanca));
$row_Recordsetleo = mysqli_fetch_assoc($Recordsetleo);
$totalRows_Recordsetleo = mysqli_num_rows($Recordsetleo);

$query_Recordset12 = sprintf(
    "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 4 */ SELECT  nom_banca, dist_por_ame, dist_cob_hnac, dist_por_parley FROM banca WHERE cod_banca = %s",
    GetSQLValueString($codigobanca=$_POST['Banca'], "int")
);

$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 5 */ SELECT *
	FROM  agencia ag
	WHERE ag.cod_banca = %s
	ORDER BY ag.nom_agencia ASC",
    GetSQLValueString($codigobanca=$_POST['Banca'], "int")
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
            if ($_POST['id_agencia']!="todos") {
                $query_Recordset3 = sprintf(
                    "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 6 */ SELECT *
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
    "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 7 */ SELECT ag.cod_agencia, ag.nom_agencia
	FROM agencia ag
	WHERE ag.cod_banca = %s
	ORDER BY ag.nom_agencia ASC",
    GetSQLValueString($codigobanca=$_POST['Banca'], "int")
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
$query_Recordset44 = sprintf("/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 8 */ SELECT 
	me.mensaje
	FROM mensajesyalertas me
	USE INDEX(mostrarhasta) 
	WHERE 
	(me.mostrarhasta >= CURDATE()) AND 
    ((tipo = 6 AND me.para = %s)) 		
	ORDER BY RAND() LIMIT 1", GetSQLValueString($codigobanca=$_POST['Banca'], "int"));
$Recordset44 = mysqli_query($conexionbanca, $query_Recordset44) or die(mysqli_error($conexionbanca));
$row_Recordset44 = mysqli_fetch_assoc($Recordset44);
$totalRows_Recordset44 = mysqli_num_rows($Recordset44);
$mensaje44 = trim($row_Recordset44['mensaje']);
mysqli_free_result($Recordset44);
?>
<font size="6" style="color:red;" align="center"><?php echo $mensaje44;?></font><br/><br/>
<div class="container">
        <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana_multidistri.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 30px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceramultidistri.php");?>
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
          </tr>
          <tr>
             <td VALIGN=BOTTOM bgcolor="#333" style="color:#FFF">
                Reporte General Multi Distribuidor	<br/><br/>
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
                onsubmit="return chequearEnvio();"><br>
                Distribuidor:
             <select name="Banca" id="soflow" style="height:40px; width:320px; margin:-9px 0px 0px 0px ">
                      <option value="todos" ><?php echo $row_Recordset12['nom_banca']?></option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset18['cod_banca']?>"
               <?php if (strtoupper($row_Recordset18['nom_banca'])==($row_Recordset12['nom_banca'])) {
                        echo "SELECTED";
                    } ?>>
                    <?php echo strtoupper($row_Recordset18['nom_banca']); ?>
                    </option>
                    
                      <?php
                } while ($row_Recordset18 = mysqli_fetch_assoc($Recordset18));
                ?>
             </select>
                <td>
             <button class="btn-warning" style=float:right;>
             <a style="color:#fff; width:100px; height:40px; "href="../multidistri/agente_reporte_general_total.php" target="_blank"> Ir a Reportes de agentes</a>
                </button>
	     </td>
                    <br><br>
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
               <option value="<?php echo $row_Recordset2['cod_agencia']?>">
               <?php echo strtoupper($row_Recordset2['nom_agencia']); ?>
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
								    <div id="totalganacia"></div>
								   					<div id="GanDistri"></div>

                <?php
                                              //$corbro= $row_Recordset12['multi_por_ameMD']*$row_Recordset555['usdabss'];
                                              $corbro= $row_Recordsetleo['multi_por_ameMD']*$row_Recordset555['usdabss'];    
                                                       ?>


					<div id="GanDistriusd"></div>
					<div id="GanDistricop"></div>
					<div id="GanDistrisol"></div>	
                                 </td>
				<td width="33%" colspan="-2" bgcolor="#333" style="color:#FFF"><br/>
                    AMERICANAS: <?php echo number_format($row_Recordsetleo['multi_por_ameMD'], 2, ",", ".")."%<br/>"; ?>
                    NACIONALES: <?php echo number_format($corbro, 2, ",", ".")." Bs/dia<br/>"; ?>
                    PARLEY: <?php echo number_format($row_Recordsetleo['multi_por_parleyMD'], 2, ",", ".")."%<br/><br/><br/>"; ?>
					TASAS DE CAMBIO ACTUAL<br/>
					1 USD >> <?php echo number_format($row_Recordset555['usdabss'], 4, ",", ".")." BSS<br/>"; ?>
                    1 COP >> <?php echo number_format($row_Recordset555['copabss'], 6, ",", ".")." BSS<br/>"; ?>
                    1 SOL >> <?php echo number_format($row_Recordset555['solabss'], 4, ",", ".")." BSS<br/>"; ?>
				</td>
				<td width="33%" colspan="2" bgcolor="#FF3366" style="color:#FFF">
                    TOTAL A PAGAR<br/> POR EL SISTEMA
															<strong><div id="totalapagar"></div></strong>

										<div id="pagAgen"></div>             
					<div id="pagAgenusd"></div>	
					<div id="pagAgencop"></div>
					<div id="pagAgensol"></div>
                    <div id="pagAgentodos"></div> 
				</td>
			         </tr>
			<tr style="background: #FFF; color: #000; font-size:14px;">
				<td colspan="2" bgcolor="#00FFFF" style="color:#333; font-size:24px;" align="right">       
				
                                 </td>
				<td colspan="-2" bgcolor="#333" style="color:#FFF; font-size:14px;" align="center" height="27"></td>
				<td colspan="2" bgcolor="#FF3366" style="color:#FFF; font-size:24px;" align="right">
					
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

        $acumuladoagentesventabss=0;
        $acumuladoagentescobrobss=0;
        $ganBancaz=0;
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
            
            
                                $totVentaBancausd=0;
            $totAnulaBancausd=0;
            $totVentaTaqusd=0;
            $totPremiTaqusd=0;
            $totPTaqPpagusd=0; //total premios pendientes x taquilla
            $totAnulaTaqusd=0;
            $subTotVentausd=0;
            $subTotPremiusd=0;
            $subPTaqPpagusd=0; //subtotal premios pendientes general
            $subTotTaquillausd=0;
            $totGanPerTaqusd=0;
            $subGenGanPerTaqusd=0;
            $totCobraBancausd=0;
            $totCobraBancaNusd=0;
            $tVeusd=0;
            $tPrusd=0;
            $tAnusd=0;
            $tTcusd=0;
            $tPpusd=0;
            $Tgeusd=0;
            $tPuntosBausd=0;
            $tPremPagosAgusd=0;
            $tVtasAgusd=0;
            $tAnulAgusd=0;
            $tCajaAgusd=0;
            $tPremPagarAgusd=0;
            $tAnulPagarAgusd=0;
            $totalAgusd=0;
            $tCantTickElimAgusd=0;
            $tMontTickElimAgusd=0;
            $tCobrAgusd=0;
            
                                $totVentaBancacop=0;
            $totAnulaBancacop=0;
            $totVentaTaqcop=0;
            $totPremiTaqcop=0;
            $totPTaqPpagcop=0; //total premios pendientes x taquilla
            $totAnulaTaqcop=0;
            $subTotVentacop=0;
            $subTotPremicop=0;
            $subPTaqPpagcop=0; //subtotal premios pendientes general
            $subTotTaquillacop=0;
            $totGanPerTaqcop=0;
            $subGenGanPerTaqcop=0;
            $totCobraBancacop=0;
            $totCobraBancaNcop=0;
            $tVecop=0;
            $tPrcop=0;
            $tAncop=0;
            $tTccop=0;
            $tPpcop=0;
            $Tgecop=0;
            $tPuntosBacop=0;
            $tPremPagosAgcop=0;
            $tVtasAgcop=0;
            $tAnulAgcop=0;
            $tCajaAgcop=0;
            $tPremPagarAgcop=0;
            $tAnulPagarAgcop=0;
            $totalAgcop=0;
            $tCantTickElimAgcop=0;
            $tMontTickElimAgcop=0;
            $tCobrAgcop=0;
            
            
                                $totVentaBancasol=0;
            $totAnulaBancasol=0;
            $totVentaTaqsol=0;
            $totPremiTaqsol=0;
            $totPTaqPpagsol=0; //total premios pendientes x taquilla
            $totAnulaTaqsol=0;
            $subTotVentasol=0;
            $subTotPremisol=0;
            $subPTaqPpagsol=0; //subtotal premios pendientes general
            $subTotTaquillasol=0;
            $totGanPerTaqsol=0;
            $subGenGanPerTaqsol=0;
            $totCobraBancasol=0;
            $totCobraBancaNsol=0;
            $tVesol=0;
            $tPrsol=0;
            $tAnsol=0;
            $tTcsol=0;
            $tPpsol=0;
            $Tgesol=0;
            $tPuntosBasol=0;
            $tPremPagosAgsol=0;
            $tVtasAgsol=0;
            $tAnulAgsol=0;
            $tCajaAgsol=0;
            $tPremPagarAgsol=0;
            $tAnulPagarAgsol=0;
            $totalAgsol=0;
            $tCantTickElimAgsol=0;
            $tMontTickElimAgsol=0;
            $tCobrAgsol=0;
            
            
            
            
           if ($totalRows_Recordset3>0) {
               do {
                   $codigoAgente=$row_Recordset3['cod_agencia'];
                   $porcentaje=$row_Recordset3['agen_por_ame'];
                   $agen_cob_hnac=$row_Recordset3['agen_cob_hnac']; 
                   $agen_por_parley=$row_Recordset3['agen_por_parley']; ?>
                   
       			
				
				
				
				
				
				
				
				
				
				
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
           <td width="21%">TAQUILLA</td>
            <td width="8%">VENTAS</td>
            <td width="8%">PREMIOS <br/>PAGADOS</td>
            <td width="5%">ANULADOS <br/>PAGADOS</td>
            <td width="8%">TOTAL EN<br/> CAJA</td>
            <td width="5%">PREMIOS POR<br/> PAGAR</td>
            <td width="5%">ANULADOS POR<br/> PAGAR</td>
            <td width="9%">TOTAL INCLUYE <br/>TICKETS POR PAGAR</td>
            <td width="10%">CANTIDAD TICKET<br/>ELIMINADOS</td>
            <td width="19%">TOTAL A COBRAR Al<br/> TAQUILLA AMERICANA (%)<br/> NACIONALES(X) TOTAL ( )</td>
          </tr>

		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
					<?php
                    $query_Recordset30 = sprintf(
                       "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 9 */ SELECT cod_taquilla, nom_taquilla
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
                    
                    
                    
                    
                   $tPuntosAgusd=0;
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
                   $subTotAnupPagarusd=0;
                   $subTotEliminadosusd=0;
                   $subTotCantEliusd=0;
                   $cobroAgenteusd=0;
                   $eliminadosAgenteusd=0;
                   $subTotVentaAusd=0;
                   $subTotVentaNusd=0;
                   $eliminadosAgenteAusd=0;
                   $eliminadosAgenteNusd=0;
                   $subCobroAgenteNusd=0;
                   $subTotAnulaAusd=0;
                   $subTotAnulaNusd=0;
                   $tVtasAgAmeusd=0;
                   $tVtasAgNacusd=0;
                   $tPremPagosAgAmeusd=0;
                   $tPremPagosAgNacusd=0;
                   $tAnulAgAmeusd=0;
                   $tAnulAgNacusd=0;
                   $tCajaAgAmeusd=0;
                   $tCajaAgNacusd=0;
                   $tPremPagarAgAmeusd=0;
                   $tPremPagarAgNacusd=0;
                   $tAnulPagarAgAmeusd=0;
                   $tAnulPagarAgNacusd=0;
                   $totalAgAmeusd=0;
                   $totalAgNacusd=0;
                   $tCantTickElimAgAmeusd=0;
                   $tCantTickElimAgNacusd=0;
                   $tMontTickElimAgAmeusd=0;
                   $tMontTickElimAgNacusd=0;
                   $tCobrAgAmeusd=0;
                   $tCobrAgNacusd=0;
                    
                    
                   $tPuntosAgcop=0;
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
                   $subTotAnupPagarcop=0;
                   $subTotEliminadoscop=0;
                   $subTotCantElicop=0;
                   $cobroAgentecop=0;
                   $eliminadosAgentecop=0;
                   $subTotVentaAcop=0;
                   $subTotVentaNcop=0;
                   $eliminadosAgenteAcop=0;
                   $eliminadosAgenteNcop=0;
                   $subCobroAgenteNcop=0;
                   $subTotAnulaAcop=0;
                   $subTotAnulaNcop=0;
                   $tVtasAgAmecop=0;
                   $tVtasAgNaccop=0;
                   $tPremPagosAgAmecop=0;
                   $tPremPagosAgNaccop=0;
                   $tAnulAgAmecop=0;
                   $tAnulAgNaccop=0;
                   $tCajaAgAmecop=0;
                   $tCajaAgNaccop=0;
                   $tPremPagarAgAmecop=0;
                   $tPremPagarAgNaccop=0;
                   $tAnulPagarAgAmecop=0;
                   $tAnulPagarAgNaccop=0;
                   $totalAgAmecop=0;
                   $totalAgNaccop=0;
                   $tCantTickElimAgAmecop=0;
                   $tCantTickElimAgNaccop=0;
                   $tMontTickElimAgAmecop=0;
                   $tMontTickElimAgNaccop=0;
                   $tCobrAgAmecop=0;
                   $tCobrAgNaccop=0;
                    
                    
                    
                    
                   $tPuntosAgsol=0;
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
                   $subTotAnupPagarsol=0;
                   $subTotEliminadossol=0;
                   $subTotCantElisol=0;
                   $cobroAgentesol=0;
                   $eliminadosAgentesol=0;
                   $subTotVentaAsol=0;
                   $subTotVentaNsol=0;
                   $eliminadosAgenteAsol=0;
                   $eliminadosAgenteNsol=0;
                   $subCobroAgenteNsol=0;
                   $subTotAnulaAsol=0;
                   $subTotAnulaNsol=0;
                   $tVtasAgAmesol=0;
                   $tVtasAgNacsol=0;
                   $tPremPagosAgAmesol=0;
                   $tPremPagosAgNacsol=0;
                   $tAnulAgAmesol=0;
                   $tAnulAgNacsol=0;
                   $tCajaAgAmesol=0;
                   $tCajaAgNacsol=0;
                   $tPremPagarAgAmesol=0;
                   $tPremPagarAgNacsol=0;
                   $tAnulPagarAgAmesol=0;
                   $tAnulPagarAgNacsol=0;
                   $totalAgAmesol=0;
                   $totalAgNacsol=0;
                   $tCantTickElimAgAmesol=0;
                   $tCantTickElimAgNacsol=0;
                   $tMontTickElimAgAmesol=0;
                   $tMontTickElimAgNacsol=0;
                   $tCobrAgAmesol=0;
                   $tCobrAgNacsol=0;
                    
                    
                    
                    
                    
                   if ($totalRows_Recordset30>0) {
                       do {
                           $codigoTaquilla=$row_Recordset30['cod_taquilla'];
                           $nom=$row_Recordset30['nom_taquilla'].".AME.BSS";
                           $nomusd=$row_Recordset30['nom_taquilla'].".AME.USD";
                           $nomsol=$row_Recordset30['nom_taquilla'].".AME.SOL";
                           $nomcop=$row_Recordset30['nom_taquilla'].".AME.COP";
                           $nomeur=$row_Recordset30['nom_taquilla'].".AME.EUR";
                
                
                           $nomN=$row_Recordset30['nom_taquilla'].".NAC.BSS";
                           $nomNusd=$row_Recordset30['nom_taquilla'].".NAC.USD";
                           $nomNsol=$row_Recordset30['nom_taquilla'].".NAC.SOL";
                           $nomNcop=$row_Recordset30['nom_taquilla'].".NAC.COP";
                           $nomNeur=$row_Recordset30['nom_taquilla'].".NAC.EUR";
                            
                            
                            
                            
                            
                           $query_Recordset1 = sprintf(
                               "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 10 */ SELECT
								ta.cod_taquilla, ta.nom_taquilla, 
								ta.taq_por_ame,
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
						THEN ve.mon_venta ELSE 0 END) AS total_ventasol,
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
                               GetSQLValueString($codigoTaquilla, "int")
                           );
                           $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                           $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                           $totalRows_Recordset1 = mysqli_num_rows($Recordset1);

                

                           ////NACIONALES
                           $query_Recordset21 = sprintf(
                               "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 11 */ SELECT
								ta.cod_taquilla, ta.nom_taquilla, ag.agen_cob_hnac, ta.taq_cob_hnac, ta.taq_por_ame,
								
								
								
								SUM(CASE WHEN veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS total_ventaN,
					SUM(CASE WHEN veN.est_ticket_hnac = 2 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.pag_premio_hnac ELSE 0 END) AS tot_premiosN,
					SUM(CASE WHEN veN.est_ticket_hnac = 0 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2)						THEN veN.mon_venta_hnac ELSE 0 END) AS tot_eliminadN,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s   AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2)
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_pagosN,
					SUM(CASE WHEN veN.est_ticket_hnac = 4 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_totalN,
					SUM(CASE WHEN veN.est_ticket_hnac = 1 AND veN.est_calculo_hnac = 4 AND veN.fec_venta_hnac >= %s AND
						                                                                  veN.fec_venta_hnac <= %s   AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2)  
						THEN veN.mon_venta_hnac ELSE 0 END) AS ret_porpagarN,
					SUM(CASE WHEN veN.est_ticket_hnac = 5 AND veN.fec_pago_hnac >= %s AND veN.fec_pago_hnac <= %s  AND (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2) 
						THEN veN.mon_venta_hnac ELSE 0 END) AS inv_pagosN,
					SUM(CASE WHEN veN.est_calculo_hnac = 5 AND veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s  AND  (veN.efectivoOn IS NULL OR veN.efectivoOn <= 2)
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
								agencia ag, taquilla ta, usuario us, taquilla_opc_hnac tp, venta_hnac veN
							WHERE (((veN.fec_venta_hnac >= %s AND veN.fec_venta_hnac <= %s) OR (veN.fec_pago_hnac >= %s AND 
								veN.fec_pago_hnac <= %s)) AND us.id_usuario = veN.id_usuario) AND 
								ag.cod_agencia = ta.cod_agencia AND us.cod_taquilla = ta.cod_taquilla AND
								tp.cod_taquilla = ta.cod_taquilla AND ta.cod_taquilla = %s 
							GROUP BY ta.cod_taquilla 
							ORDER BY ta.cod_taquilla, veN.fec_venta_hnac, veN.num_ticket_hnac ASC",
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
                               GetSQLValueString($codigoTaquilla, "int")
                           );
                           $Recordset21 = mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
                           $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
                           $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
                           $query_Recordset22 =  sprintf(
                               "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 12 */ SELECT cob_taquilla_hnac 
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

                           if($totalRows_Recordset22>0){
                            $taquillaspar++;
                            
                           }
                           
                            
                            
                           $porTaquilla=$row_Recordset1['taq_por_ame'];
                            
                            
                           $totVentaTaq=$row_Recordset1['total_venta'];
                           $totPremiTaq=$row_Recordset1['tot_premios'];
                           $totAnulaTaq=$row_Recordset1['ret_pagos']+$row_Recordset1['inv_pagos']+$row_Recordset1['tot_eliminad'];
                           $porPagarEliTaq=$row_Recordset1['ret_porpagar']+$row_Recordset1['inv_porpagar'];
                           $totPTaqPpag=$row_Recordset1['pre_porpagar'];
                           $totTaquilla=$totVentaTaq-($totPremiTaq+$totAnulaTaq);
                           $totGanPerTaq=$totTaquilla-$totPTaqPpag-$porPagarEliTaq;
                           $totalAnulados=$row_Recordset1['ret_total']+$row_Recordset1['inv_total']+$row_Recordset1['tot_eliminad'];
                           $tCobroAgente=(($totVentaTaq-$totalAnulados)*$porTaquilla)/100;
                           $tot=$row_Recordset1['con_tic_eli'];

                           //usd
                           $totVentaTaqusd=$row_Recordset1['total_ventausd'];
                           $totPremiTaqusd=$row_Recordset1['tot_premiosusd'];
                           $totAnulaTaqusd=$row_Recordset1['ret_pagosusd']+$row_Recordset1['inv_pagosusd']+$row_Recordset1['tot_eliminadusd'];
                           $totTaquillausd=$totVentaTaqusd-($totPremiTaqusd+$totAnulaTaqusd);
                           $totPTaqPpagusd=$row_Recordset1['pre_porpagarusd'];
                           $porPagarEliTaqusd=$row_Recordset1['ret_porpagarusd']+$row_Recordset1['inv_porpagarusd'];
                           $totGanPerTaqusd=$totTaquillausd-$totPTaqPpagusd-$porPagarEliTaqusd;
                           $totalAnuladosusd=$row_Recordset1['ret_totalusd']+$row_Recordset1['inv_totalusd']+$row_Recordset1['tot_eliminadusd'];
                           $tCobroAgenteusd=(($totVentaTaqusd-$totalAnuladosusd)*$porTaquilla)/100;
                           $totusd=$row_Recordset1['con_tic_eliusd'];
                
                           //usd fin
                
                
                
                
                
                                        
                        
                
                           //cop
                           $totVentaTaqcop=$row_Recordset1['total_ventacop'];
                           $totPremiTaqcop=$row_Recordset1['tot_premioscop'];
                           $totAnulaTaqcop=$row_Recordset1['ret_pagoscop']+$row_Recordset1['inv_pagoscop']+$row_Recordset1['tot_eliminadcop'];
                           $totTaquillacop=$totVentaTaqcop-($totPremiTaqcop+$totAnulaTaqcop);
                           $totPTaqPpagcop=$row_Recordset1['pre_porpagarcop'];
                           $porPagarEliTaqcop=$row_Recordset1['ret_porpagarcop']+$row_Recordset1['inv_porpagarcop'];
                           $totGanPerTaqcop=$totTaquillacop-$totPTaqPpagcop-$porPagarEliTaqcop;
                           $totalAnuladoscop=$row_Recordset1['ret_totalcop']+$row_Recordset1['inv_totalcop']+$row_Recordset1['tot_eliminadcop'];
                           $tCobroAgentecop=(($totVentaTaqcop-$totalAnuladoscop)*$porTaquilla)/100;
                           $totcop=$row_Recordset1['con_tic_elicop'];
                
                           //cop fin
                
                
                
                
                
                
                           //sol
                           $totVentaTaqsol=$row_Recordset1['total_ventasol'];
                           $totPremiTaqsol=$row_Recordset1['tot_premiossol'];
                           $totAnulaTaqsol=$row_Recordset1['ret_pagossol']+$row_Recordset1['inv_pagossol']+$row_Recordset1['tot_eliminadsol'];
                           $totTaquillasol=$totVentaTaqsol-($totPremiTaqsol+$totAnulaTaqsol);
                           $totPTaqPpagsol=$row_Recordset1['pre_porpagarsol'];
                           $porPagarEliTaqsol=$row_Recordset1['ret_porpagarsol']+$row_Recordset1['inv_porpagarsol'];
                           $totGanPerTaqsol=$totTaquillasol-$totPTaqPpagsol-$porPagarEliTaqsol;
                           $totalAnuladossol=$row_Recordset1['ret_totalsol']+$row_Recordset1['inv_totalsol']+$row_Recordset1['tot_eliminadsol'];
                           $tCobroAgentesol=(($totVentaTaqsol-$totalAnuladossol)*$porTaquilla)/100;
                           $totsol=$row_Recordset1['con_tic_elisol'];
                
                           //sol fin
                
                
                
                
                
                
                
                
                
                
                                        
                        
                
                
                
                
                
                
                
                            
                           $porTaquillaN=$row_Recordset21['taq_cob_hnac'];
                           $porTaquilla=$row_Recordset21['taq_por_ame'];
                           $poragenteN=$row_Recordset21['agen_cob_hnac'];
                           
                           $totVentaTaqN=$row_Recordset21['total_ventaN'];
                           $totPremiTaqN=$row_Recordset21['tot_premiosN'];
                           $totAnulaTaqN=$row_Recordset21['ret_pagosN']+$row_Recordset21['inv_pagosN']+$row_Recordset21['tot_eliminadN'];
                           $porPagarEliTaqN=$row_Recordset21['ret_porpagarN']+$row_Recordset21['inv_porpagarN'];
                           $totPTaqPpagN=$row_Recordset21['pre_porpagarN'];
                           $totTaquillaN=$totVentaTaqN-($totPremiTaqN+$totAnulaTaqN);
                           $totGanPerTaqN=$totTaquillaN-$totPTaqPpagN-$porPagarEliTaqN;
                           $totalAnuladosN=$row_Recordset21['ret_totalN']+$row_Recordset21['inv_totalN']+$row_Recordset21['tot_eliminadN'];
                           $tCobroAgenteN=$corbro*$totalRows_Recordset22;
                           $totN=$row_Recordset21['con_tic_eliN']*1;
                            
                            
                           //usd n
                           $totVentaTaqNusd=$row_Recordset21['total_ventaNusd']*1;
                           $totPremiTaqNusd=$row_Recordset21['tot_premiosNusd']*1;
                           $totAnulaTaqNusd=$row_Recordset21['ret_pagosNusd']+$row_Recordset21['inv_pagosNusd']+$row_Recordset21['tot_eliminadNusd']*1;
                           $totTaquillaNusd=$totVentaTaqNusd-($totPremiTaqNusd+$totAnulaTaqNusd);
                           $totPTaqPpagNusd=$row_Recordset21['pre_porpagarNusd'];
                           $porPagarEliTaqNusd=$row_Recordset21['ret_porpagarNusd']+$row_Recordset21['inv_porpagarNusd'];
                           $totGanPerTaqNusd=$totTaquillaNusd-$totPTaqPpagNusd-$porPagarEliTaqNusd;
                           $totalAnuladosNusd=$row_Recordset21['ret_totalNusd']+$row_Recordset21['inv_totalNusd']+$row_Recordset21['tot_eliminadNusd'];
                           $tCobrAgNacusd=$corbro*$totalRows_Recordset22;
                           $totNusd=$row_Recordset21['con_tic_eliNusd'];
                           // usd n fin
                
                
                
                                        
                        
                           //cop n
                           $totVentaTaqNcop=$row_Recordset21['total_ventaNcop'];
                           $totPremiTaqNcop=$row_Recordset21['tot_premiosNcop'];
                           $totAnulaTaqNcop=$row_Recordset21['ret_pagosNcop']+$row_Recordset21['inv_pagosNcop']+$row_Recordset21['tot_eliminadNcop'];
                           $totTaquillaNcop=$totVentaTaqNcop-($totPremiTaqNcop+$totAnulaTaqNcop);
                           $totPTaqPpagNcop=$row_Recordset21['pre_porpagarNcop'];
                           $porPagarEliTaqNcop=$row_Recordset21['ret_porpagarNcop']+$row_Recordset21['inv_porpagarNcop'];
                           $totGanPerTaqNcop=$totTaquillaNcop-$totPTaqPpagNcop-$porPagarEliTaqNcop;
                           $totalAnuladosNcop=$row_Recordset21['ret_totalNcop']+$row_Recordset21['inv_totalNcop']+$row_Recordset21['tot_eliminadNcop'];
                           $tCobrAgNaccop=$corbro*$totalRows_Recordset22;
                           $totNcop=$row_Recordset21['con_tic_eliNcop'];
                           // cop n fin
                
                
                                        
                        
                           //sol n
                           $totVentaTaqNsol=$row_Recordset21['total_ventaNsol'];
                           $totPremiTaqNsol=$row_Recordset21['tot_premiosNsol'];
                           $totAnulaTaqNsol=$row_Recordset21['ret_pagosNsol']+$row_Recordset21['inv_pagosNsol']+$row_Recordset21['tot_eliminadNsol'];
                           $totTaquillaNsol=$totVentaTaqNsol-($totPremiTaqNsol+$totAnulaTaqNsol);
                           $totPTaqPpagNsol=$row_Recordset21['pre_porpagarNsol'];
                           $porPagarEliTaqNsol=$row_Recordset21['ret_porpagarNsol']+$row_Recordset21['inv_porpagarNsol'];
                           $totGanPerTaqNsol=$totTaquillaNsol-$totPTaqPpagNsol-$porPagarEliTaqNsol;
                           $totalAnuladosNsol=$row_Recordset21['ret_totalNsol']+$row_Recordset21['inv_totalNsol']+$row_Recordset21['tot_eliminadNsol'];
                           $tCobrAgNacsol=$corbro*$totalRows_Recordset22;
                           $totNsol=$row_Recordset21['con_tic_eliNsol'];
                           // sol n fin
                
                
                           $timestamp = strtotime($iniciod);
                           $newDate = date("Y-m-d", $timestamp );
                           
                           $timestamp1 = strtotime($finald); 
                           $newDate1 = date("Y-m-d", $timestamp1 );
           
           
           
                              $query_Recordset50 = sprintf(
                               "/* PARSEADORES1 multidistri\distri_reporte_general_total.php - QUERY 13 */ SELECT 
           p4jugadas.lineatp4, ta.nom_taquilla, ag.agen_por_parley,
           
           SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s  AND p4jugadas.monedap4 <= 2 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventabss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadobss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadosbss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.pverificado = 0 ELSE 0 END) AS total_eliminadosbssv,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.estadoticketp4 = 7 ELSE 0 END) AS cont_eliminadosbss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 2) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_perdidobss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 3) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_devolucionbssv,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_devolucionbss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 1) AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_ganadorbss,



SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 3 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventausd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadousd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadosusd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 3  THEN p4jugadas.pverificado = 0 ELSE 0 END) AS total_eliminadosusdv,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 3  THEN p4jugadas.estadoticketp4 = 7 ELSE 0 END) AS cont_eliminadosusd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 2) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_perdidousd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 3) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_devolucionusd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_devolucionusdv,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 1) AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_ganadorusd,


SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 4 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventacop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadocop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadoscop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 4  THEN p4jugadas.pverificado = 0 ELSE 0 END) AS total_eliminadoscopv,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 4  THEN p4jugadas.estadoticketp4 = 7 ELSE 0 END) AS cont_eliminadoscop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 2) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_perdidocop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 3) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_devolucioncop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_devolucioncopv,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 1) AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_ganadorcop,




SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.monedap4 = 5 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventasol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 5) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadosol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_eliminadossol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 5  THEN p4jugadas.pverificado = 0 ELSE 0 END) AS total_eliminadossolv,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 7) AND p4jugadas.monedap4 = 5  THEN p4jugadas.estadoticketp4 = 7 ELSE 0 END) AS cont_eliminadossol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 2) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_perdidosol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 3) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_devolucionsol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4pago >= %s AND p4jugadas.jugadadtp4pago <= %s AND (p4jugadas.estadoticketp4 = 6) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_devolucionsolv,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND (p4jugadas.estadoticketp4 = 1) AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_ganadorsol
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
                           GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                           GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                           GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                           GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                           GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                           GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
                           GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"), 
                           GetSQLValueString($newDate.' 00:00:02', "date"), GetSQLValueString($newDate1.' 23:59:59', "date"),
           GetSQLValueString($codigoTaquilla, "int"),
           GetSQLValueString($codigoTaquilla, "int"),
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
        
                        $tCobroAgenteP=$row_Recordset50['agen_por_parley']*$totalRows_Recordset22;
        
                        
        
        
        
                        //PARLEY BS
                        $porTaquillaP=$row_Recordset50['agen_por_parley'];
                        $totVentaTaqP=$row_Recordset50['total_ventabss'];
                        $totPremiTaqP=$row_Recordset50['total_pagadobss'];
                        $totAnulaTaqP=$row_Recordset50['total_devolucionbss']+$row_Recordset50['total_eliminadosbss'];
                        $totTaquillaP=$totVentaTaqP-($row_Recordset50['total_perdidobss']+$totPremiTaqP+$totAnulaTaqP);
                        $totPTaqPpagP=$row_Recordset50['total_ganadorbss'];
                        $porPagarEliTaqP=$row_Recordset50['total_devolucionbssv'];
                        $totGanPerTaqP=$totTaquillaP-$totPTaqPpagP-$porPagarEliTaqP;
                        $totalAnuladosP=$row_Recordset50['total_eliminadosbssv']+$row_Recordset50['total_devolucionbssv'];
                        $totP=$row_Recordset50['total_eliminadosbss'];
                        $tCobroAgentePBS=(($totVentaTaqP-$totalAnuladosP)*$porTaquillaP)/100;
        
                        
        
                        //PARLEY USD
                        //$porTaquillaP=$row_Recordset50['agen_por_parley'];
                        $totVentaTaqPUSD=$row_Recordset50['total_ventausd'];
                        $totPremiTaqPUSD=$row_Recordset50['total_pagadousd'];
                        $totAnulaTaqPUSD=$row_Recordset50['total_perdidousd']+$row_Recordset50['total_devolucionusd']+$row_Recordset50['total_eliminadosusd'];
                        $totTaquillaPUSD=$totVentaTaqPUSD-($totPremiTaqPUSD+$totAnulaTaqPUSD);
                        $totPTaqPpagPUSD=$row_Recordset50['total_ganadorusd'];
                        $porPagarEliTaqPUSD=$row_Recordset50['total_devolucionusdv'];
                        $totGanPerTaqPUSD=$totTaquillaPUSD-$totPTaqPpagPUSD-$porPagarEliTaqPUSD;
                        $totalAnuladosPUSD=$row_Recordset50['total_eliminadosusdv']+$row_Recordset50['total_devolucionusdv'];
                        $totPUSD=$row_Recordset50['total_eliminadosusd'];
                        $tCobroAgentePUSD=(($totVentaTaqPUSD-$totalAnuladosPUSD)*$porTaquillaP)/100;
        
                         //PARLEY COP
                        //$porTaquillaP=$row_Recordset50['agen_por_parley'];
                        $totVentaTaqPCOP=$row_Recordset50['total_ventacop'];
                        $totPremiTaqPCOP=$row_Recordset50['total_pagadocop'];
                        $totAnulaTaqPCOP=$row_Recordset50['total_perdidocop']+$row_Recordset50['total_devolucioncop']+$row_Recordset50['total_eliminadoscop'];
                        $totTaquillaPCOP=$totVentaTaqPCOP-($totPremiTaqPCOP+$totAnulaTaqPCOP);
                        $totPTaqPpagPCOP=$row_Recordset50['total_ganadorcop'];
                        $porPagarEliTaqPCOP=$row_Recordset50['total_devolucioncopv'];
                        $totGanPerTaqPCOP=$totTaquillaPCOP-$totPTaqPpagPCOP-$porPagarEliTaqPCOP;
                        $totalAnuladosPCOP=$row_Recordset50['total_eliminadoscopv']+$row_Recordset50['total_devolucioncopv'];
                        $totPCOP=$row_Recordset50['total_eliminadoscop'];
                        $tCobroAgentePCOP=(($totVentaTaqPCOP-$totalAnuladosPCOP)*$porTaquillaP)/100;
                        
        
                         //PARLEY SOL
                        //$porTaquillaP=$row_Recordset50['agen_por_parley'];
                        $totVentaTaqPSOL=$row_Recordset50['total_ventasol'];
                        $totPremiTaqPSOL=$row_Recordset50['total_pagadosol'];
                        $totAnulaTaqPSOL=$row_Recordset50['total_perdidosol']+$row_Recordset50['total_devolucionsol']+$row_Recordset50['total_eliminadossol'];
                        $totTaquillaPSOL=$totVentaTaqPSOL-($totPremiTaqPSOL+$totAnulaTaqPSOL);
                        $totPTaqPpagPSOL=$row_Recordset50['total_ganadorsol'];
                        $porPagarEliTaqPSOL=$row_Recordset50['total_devolucionsolv'];
                        $totGanPerTaqPSOL=$totTaquillaPSOL-$totPTaqPpagPSOL-$porPagarEliTaqPSOL;
                        $totalAnuladosPSOL=$row_Recordset50['total_eliminadossolv']+$row_Recordset50['total_devolucionsolv'];
                        $totPSOL=$row_Recordset50['total_eliminadossol'];
                        $tCobroAgentePSOL=(($totVentaTaqPSOL-$totalAnuladosPSOL)*$porTaquillaP)/100;
        
                
                
                
                
                            
                            
                            
                            
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
                            echo "AM(".number_format($row_Recordset1['taq_por_ame'], 1, ",", ".")."%)";
                                                        echo "NA(".number_format($row_Recordset21['taq_cob_hnac'], 0, ",", ".");
                            echo "x".$totalRows_Recordset22.")";
                                                        $totalpagosistema=$tCobroAgenteN+$tCobroAgente;
        ?>							
        <font color="red"><?php echo "...(".number_format($totalpagosistema, 2, ",", ".").")";
        ?></font>
                        </td>
        
        
        
        <?php
        } ?>
        
                
                <?php
                // usd
                                if ($totVentaTaqusd!=0 or $totPremiTaqusd!=0 or $totAnulaTaqusd!=0 or $totTaquillausd!=0 or $totPTaqPpagusd!=0 or
                    $porPagarEliTaqusd!=0 or $totGanPerTaqusd!=0 or $tCobroAgenteusd!=0) {?>
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
                    } if ($totTaquilla<>0.00) {
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
                            $totNusd=$row_Recordset1['con_tic_eliusd']*1;
                                                if ($totusd==0) {
                                                }
                                                if ($totusd<>0) {
                                                    echo "(".$totNusd.")".number_format($row_Recordset1['tot_eliminadusd'], 2, ",", ".");
                                                }?>
                        </td>
            <td align="right" valign="middle"><?php
                            echo "AM USD(".number_format($row_Recordset1['taq_por_ame'], 1, ",", ".")."%)";
                                                   
                                                        $totalpagosistemausd=$tCobroAgenteusd;
        ?>							
        <font color="red"><?php echo "...(".number_format($totalpagosistemausd, 2, ",", ".").")";
        ?></font>
                        </td>
        
                    </tr><?php
                }
                
                
                
                
                           // usd fin
                
                
                
                
                
                
                           // cop
                
                
                           if ($totVentaTaqcop!=0 or $totPremiTaqcop!=0 or $totAnulaTaqcop!=0 or $totTaquillacop!=0 or $totPTaqPpagcop!=0 or
                    $porPagarEliTaqcop!=0 or $totGanPerTaqcop!=0 or $tCobroAgentecop!=0) {?>
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
                    } if ($totTaquilla<>0.00) {
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
                            echo "AM cop(".number_format($row_Recordset1['taq_por_ame'], 1, ",", ".")."%)";
                                                   
                                                        $totalpagosistemacop=$tCobroAgentecop;
        ?>							
        <font color="red"><?php echo "...(".number_format($totalpagosistemacop, 2, ",", ".").")";
        ?></font>
                        </td>
        
                    </tr><?php
                }
                
                
                
                
                           // cop fin
                
                
                
                
                                
                
                           // sol
                
                
                           if ($totVentaTaqsol!=0 or $totPremiTaqsol!=0 or $totAnulaTaqsol!=0 or $totTaquillasol!=0 or $totPTaqPpagsol!=0 or
                    $porPagarEliTaqsol!=0 or $totGanPerTaqsol!=0 or $tCobroAgentesol!=0) {?>
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
                    } if ($totTaquilla<>0.00) {
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
                            echo "AM sol(".number_format($row_Recordset1['taq_por_ame'], 1, ",", ".")."%)";
                                                   
                                                        $totalpagosistemasol=$tCobroAgentesol;
        ?>							
        <font color="red"><?php echo "...(".number_format($totalpagosistemasol, 2, ",", ".").")";
        ?></font>
                        </td>
        
                    </tr><?php
                }
                
                
                
                
                           // sol fin
                
                
                
                
                
                
                
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
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
        if ($totVentaTaq==0) {
        echo "AM(".number_format($row_Recordset1['taq_por_ame'], 1, ",", ".")."%)";
        
        //echo "NA(".number_format($poragenteN, 2, ",", ".");
        echo "NA(".number_format($corbro, 2, ",", ".");
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
                
                
                
                
                           //usd n
                
                
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
        if ($totVentaTaq==0) {
        echo "AM(".number_format($row_Recordset1['taq_por_ame'], 1, ",", ".")."%)";
        echo "NA(".number_format($corbro, 2, ",", ".");
        echo "x".$totalRows_Recordset22.")";
        $totalpagosistema=$tCobrAgNacusd+$tCobroAgente;
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
                
                           //usd n fin
                
                
                
                                
                
                
                
                           //cop n
                
                
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
        if ($totVentaTaq==0) {
        echo "AM(".number_format($row_Recordset1['taq_por_ame'], 1, ",", ".")."%)";
        echo "NA(".number_format($corbro, 2, ",", ".");
        echo "x".$totalRows_Recordset22.")";
        $totalpagosistema=$tCobrAgNaccop+$tCobroAgente;
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
                
                           //cop n fin
                
                
                
                
                                        
                
                                
                
                
                
                
                           //sol n
                
                
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
        if ($totVentaTaq==0) {
        echo "AM(".number_format($row_Recordset1['taq_por_ame'], 1, ",", ".")."%)";
        echo "NA(".number_format($corbro, 2, ",", ".");
        echo "x".$totalRows_Recordset22.")";
        $totalpagosistema=$tCobrAgNacsol+$tCobroAgente;
        }
        ?>					
        <font color="red"><?php
        if ($totVentaTaq==0) {
        echo "...(".number_format($totalpagosistema, 2, ",", ".").")";
        }  }
        ?></font>
        
        </td>
        </tr>
        
        <?php  //PARLEY BSS
           if ($totVentaTaqP!=0 or $totPremiTaqP!=0 or $totAnulaTaqP!=0 or $totTaquillaP!=0 or $totPTaqPpagP!=0 or
                    $porPagarEliTaqP!=0 or $totGanPerTaqP!=0) {?>
                      <tr onmouseover="cambiacolor_over1(this)" onmouseout="cambiacolor_out3(this)" height="20" 
                        style="background: white; font-size:11px">
                        <td align="left" valign="middle"><?php echo $nomP; ?></td>
                        <td align="right" valign="middle"><?php if ($totVentaTaqP==0.00) {
                    } if ($totVentaTaqP<>0.00) {
                        echo number_format($totVentaTaqP, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><?php if ($totPremiTaqP==0.00) {
                    } if ($totPremiTaqP<>0.00) {
                        echo number_format($totPremiTaqP, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><?php if ($totAnulaTaqP==0.00) {
                    } if ($totAnulaTaqP<>0.00) {
                        echo number_format($totAnulaTaqP, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><font><?php if ($totTaquillaP==0.00) {
                    } if ($totTaquillaP<>0.00) {
                        echo number_format($totTaquillaP, 2, ",", ".");
                    }?></font></td>
                        <td align="right" valign="middle"><?php if ($totPTaqPpagP==0.00) {
                    } if ($totPTaqPpagP<>0.00) {
                        echo number_format($totPTaqPpagP, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><?php if ($porPagarEliTaqP==0.00) {
                    } if ($porPagarEliTaqP<>0.00) {
                        echo number_format($porPagarEliTaqP, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqP==0.00) {
                    } if ($totGanPerTaqP<>0.00) {
                        echo number_format($totGanPerTaqP, 2, ",", ".");
                    }?></font></td>
                        
        
                        
        
        
        
        <td align="right" valign="middle"><?php
                            $totP=$row_Recordset50['cont_eliminadosbss']*1;
                                                if ($totP==0) {
                                                }
                                                if ($totP<>0) {
                                                    echo "(".$totP.")".number_format($row_Recordset50['total_eliminadosbss'], 2, ",", ".");
                                                }
        ?>
                        </td>
                        <td align="right" valign="middle">
        <?php
        if ($totVentaTaqP==0) {
        echo "AM(".number_format($porTaquillaP, 1, ",", ".")."%)";
        echo "NA(".number_format($row_Recordset50['agen_por_parley'], 0, ",", ".");
        echo "x".$totalRows_Recordset22.")";
        $totalpagosistemaP=$tCobroAgenteP+$tCobroAgentePBS;
        }
        ?>					
        <font color="red"><?php
        if ($totVentaTaqP==0) {
        echo "...(".number_format($totalpagosistemaP, 2, ",", ".").")";
        } }
        ?></font>
        
        </td>
        
        
        
        <?php  //PARLEY USD
           if ($totVentaTaqPUSD!=0 or $totPremiTaqPUSD!=0 or $totAnulaTaqPUSD!=0 or $totTaquillaPUSD!=0 or $totPTaqPpagPUSD!=0 or
                    $porPagarEliTaqPUSD!=0 or $totGanPerTaqPUSD!=0) {?>
                      <tr onmouseover="cambiacolor_over1(this)" onmouseout="cambiacolor_out3(this)" height="20" 
                        style="background: white; font-size:11px">
                        <td align="left" valign="middle"><?php echo $nomPUSD; ?></td>
                        <td align="right" valign="middle"><?php if ($totVentaTaqPUSD==0.00) {
                    } if ($totVentaTaqPUSD<>0.00) {
                        echo number_format($totVentaTaqPUSD, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><?php if ($totPremiTaqPUSD==0.00) {
                    } if ($totPremiTaqPUSD<>0.00) {
                        echo number_format($totPremiTaqPUSD, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><?php if ($totAnulaTaqPUSD==0.00) {
                    } if ($totAnulaTaqPUSD<>0.00) {
                        echo number_format($totAnulaTaqPUSD, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><font><?php if ($totTaquillaPUSD==0.00) {
                    } if ($totTaquillaPUSD<>0.00) {
                        echo number_format($totTaquillaPUSD, 2, ",", ".");
                    }?></font></td>
                        <td align="right" valign="middle"><?php if ($totPTaqPpagPUSD==0.00) {
                    } if ($totPTaqPpagPUSD<>0.00) {
                        echo number_format($totPTaqPpagPUSD, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><?php if ($porPagarEliTaqPUSD==0.00) {
                    } if ($porPagarEliTaqPUSD<>0.00) {
                        echo number_format($porPagarEliTaqPUSD, 2, ",", ".");
                    }?></td>
                        <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqPUSD==0.00) {
                    } if ($totGanPerTaqPUSD<>0.00) {
                        echo number_format($totGanPerTaqPUSD, 2, ",", ".");
                    }?></font></td>
                        
        
                        
        
        
        
        <td align="right" valign="middle"><?php
                            $totPUSD=$row_Recordset50['cont_eliminadosusd']*1;
                                                if ($totPUSD==0) {
                                                }
                                                if ($totPUSD<>0) {
                                                    echo "(".$totPUSD.")".number_format($row_Recordset50['total_eliminadosusd'], 2, ",", ".");
                                                }
        ?>
                        </td>
                        <td align="right" valign="middle">
                        <?php
        if ($totVentaTaqPUSD==0) {
        echo "AM(".number_format($porTaquillaP, 1, ",", ".")."%)";
        echo "NA(".number_format($row_Recordset50['agen_por_parley'], 0, ",", ".");
        echo "x".$totalRows_Recordset22.")";
        $totalpagosistemaPUSD=$tCobroAgenteP+$tCobroAgentePUSD;
        }
        ?>					
        <font color="red"><?php
        if ($totVentaTaqPUSD==0) {
        echo "...(".number_format($totalpagosistemaPUSD, 2, ",", ".").")";
        } }
        ?></font>
        
        </td>
        
        
        
        <?php  //PARLEY COP
                   if ($totVentaTaqPCOP!=0 or $totPremiTaqPCOP!=0 or $totAnulaTaqPCOP!=0 or $totTaquillaPCOP!=0 or $totPTaqPpagPCOP!=0 or
                            $porPagarEliTaqPCOP!=0 or $totGanPerTaqPCOP!=0) {?>
                              <tr onmouseover="cambiacolor_over1(this)" onmouseout="cambiacolor_out3(this)" height="20" 
                                style="background: white; font-size:11px">
                                <td align="left" valign="middle"><?php echo $nomPCOP; ?></td>
                                <td align="right" valign="middle"><?php if ($totVentaTaqPCOP==0.00) {
                            } if ($totVentaTaqPCOP<>0.00) {
                                echo number_format($totVentaTaqPCOP, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><?php if ($totPremiTaqPCOP==0.00) {
                            } if ($totPremiTaqPCOP<>0.00) {
                                echo number_format($totPremiTaqPCOP, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><?php if ($totAnulaTaqPCOP==0.00) {
                            } if ($totAnulaTaqPCOP<>0.00) {
                                echo number_format($totAnulaTaqPCOP, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><font><?php if ($totTaquillaPCOP==0.00) {
                            } if ($totTaquillaPCOP<>0.00) {
                                echo number_format($totTaquillaPCOP, 2, ",", ".");
                            }?></font></td>
                                <td align="right" valign="middle"><?php if ($totPTaqPpagPCOP==0.00) {
                            } if ($totPTaqPpagPCOP<>0.00) {
                                echo number_format($totPTaqPpagPCOP, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><?php if ($porPagarEliTaqPCOP==0.00) {
                            } if ($porPagarEliTaqPCOP<>0.00) {
                                echo number_format($porPagarEliTaqPCOP, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqPCOP==0.00) {
                            } if ($totGanPerTaqPCOP<>0.00) {
                                echo number_format($totGanPerTaqPCOP, 2, ",", ".");
                            }?></font></td>
                                
        
                                
        
        
        
        <td align="right" valign="middle"><?php
                                    $totPCOP=$row_Recordset50['cont_eliminadoscop']*1;
                                    if ($totPCOP==0) {
                                    }
                                    if ($totPCOP<>0) {
                                        echo "(".$totPCOP.")".number_format($row_Recordset50['total_eliminadoscop'], 2, ",", ".");
                                    }
        ?>
                                </td>
                                <td align="right" valign="middle">
                                <?php
        if ($totVentaTaqPCOP==0) {
            echo "AM(".number_format($porTaquillaP, 1, ",", ".")."%)";
            echo "NA(".number_format($row_Recordset50['agen_por_parley'], 0, ",", ".");
            echo "x".$totalRows_Recordset22.")";
            $totalpagosistemaPCOP=$tCobroAgenteP+$tCobroAgentePCOP;
        }
        ?>					
        <font color="red"><?php
        if ($totVentaTaqPCOP==0) {
            echo "...(".number_format($totalpagosistemaPCOP, 2, ",", ".").")";
        } }
        ?></font>
        
        </td>
        
        
        
        <?php  //PARLEY SOL
                   if ($totVentaTaqPSOL!=0 or $totPremiTaqPSOL!=0 or $totAnulaTaqPSOL!=0 or $totTaquillaPSOL!=0 or $totPTaqPpagPSOL!=0 or
                            $porPagarEliTaqPSOL!=0 or $totGanPerTaqPSOL!=0) {?>
                              <tr onmouseover="cambiacolor_over1(this)" onmouseout="cambiacolor_out3(this)" height="20" 
                                style="background: white; font-size:11px">
                                <td align="left" valign="middle"><?php echo $nomPSOL; ?></td>
                                <td align="right" valign="middle"><?php if ($totVentaTaqPSOL==0.00) {
                            } if ($totVentaTaqPSOL<>0.00) {
                                echo number_format($totVentaTaqPSOL, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><?php if ($totPremiTaqPSOL==0.00) {
                            } if ($totPremiTaqPSOL<>0.00) {
                                echo number_format($totPremiTaqPSOL, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><?php if ($totAnulaTaqPSOL==0.00) {
                            } if ($totAnulaTaqPSOL<>0.00) {
                                echo number_format($totAnulaTaqPSOL, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><font><?php if ($totTaquillaPSOL==0.00) {
                            } if ($totTaquillaPSOL<>0.00) {
                                echo number_format($totTaquillaPSOL, 2, ",", ".");
                            }?></font></td>
                                <td align="right" valign="middle"><?php if ($totPTaqPpagPSOL==0.00) {
                            } if ($totPTaqPpagPSOL<>0.00) {
                                echo number_format($totPTaqPpagPSOL, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><?php if ($porPagarEliTaqPSOL==0.00) {
                            } if ($porPagarEliTaqPSOL<>0.00) {
                                echo number_format($porPagarEliTaqPSOL, 2, ",", ".");
                            }?></td>
                                <td align="right" valign="middle"><font color="red"><?php if ($totGanPerTaqPSOL==0.00) {
                            } if ($totGanPerTaqPSOL<>0.00) {
                                echo number_format($totGanPerTaqPSOL, 2, ",", ".");
                            }?></font></td>
                                
        
                                
        
        
        
        <td align="right" valign="middle"><?php
                                    $totPSOL=$row_Recordset50['cont_eliminadossol']*1;
                                    if ($totPSOL==0) {
                                    }
                                    if ($totPSOL<>0) {
                                        echo "(".$totPSOL.")".number_format($row_Recordset50['total_eliminadossol'], 2, ",", ".");
                                    }
        ?>
                                </td>
                                <td align="right" valign="middle">
                                <?php
        if ($totVentaTaqPSOL==0) {
            echo "AM(".number_format($porTaquillaP, 1, ",", ".")."%)";
            echo "NA(".number_format($row_Recordset50['agen_por_parley'], 0, ",", ".");
            echo "x".$totalRows_Recordset22.")";
            $totalpagosistemaPSOL=$tCobroAgenteP+$tCobroAgentePSOL;
        }
        ?>					
        <font color="red"><?php
        if ($totVentaTaqPSOL==0) {
            echo "...(".number_format($totalpagosistemaPSOL, 2, ",", ".").")";
        } }
        ?></font>
        
        </td>
        </tr>
        
        
        
        
        


					<?php
                
                
                           //sol n fin
                
                
                




                           $tVtasAgAme=$tVtasAgAme+$totVentaTaq;
                           $tVtasAgNac=$tVtasAgNac+$totVentaTaqN;
                           $tVtasAg=$tVtasAgAme;
                            
                           $tPremPagosAgAme=$tPremPagosAgAme+$totPremiTaq;
                           $tPremPagosAgNac=$tPremPagosAgNac+$totPremiTaqN;
                           $tPremPagosAg=$tPremPagosAgNac+$tPremPagosAgAme;
                            
                           $tAnulAgAme=$tAnulAgAme+$totAnulaTaq;
                           $tAnulAgNac=$tAnulAgNac+$totAnulaTaqN;
                           $tAnulAg=$tAnulAgAme;
                            
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
                            
                           $eliminadosAgenteAusd=$eliminadosAgenteAusd+$totalAnuladosusd;

                           $subTotVentaAusd=$subTotVentaAusd+$totVentaTaqusd;//total ventas ame
                            
                           $eliminadosAgenteAcop=$eliminadosAgenteAcop+$totalAnuladoscop;

                           $subTotVentaAcop=$subTotVentaAcop+$totVentaTaqcop;//total ventas ame

                           $eliminadosAgenteAsol=$eliminadosAgenteAsol+$totalAnuladossol;

                           $subTotVentaAsol=$subTotVentaAsol+$totVentaTaqsol;//total ventas ame

                            
                            
                            
                            
                            
                                            
                           $subTotAnupPagar=$subTotAnupPagar+$porPagarEliTaq+$porPagarEliTaqN;
                           $subTotEliminados=$subTotEliminados+$row_Recordset1['tot_eliminad']+$row_Recordset2['tot_eliminadN'];
                           $subTotCantEli=$subTotCantEli+$tot+$totN;
                           $subTotVenta=$subTotVenta+$totVentaTaq+$totVentaTaqN;
    
                           //$subTotVentaA=$subTotVentaA+$totVentaTaq;
                
                           $subTotPremi=$subTotPremi+$totPremiTaq+$totPremiTaqN;
                           $subTotAnula=$subTotAnula+$totAnulaTaq+$totAnulaTaqN;
                           $subTotTaquilla=$subTotTaquilla+$totTaquilla+$totTaquillaN;
                           $subPTaqPpag=$subPTaqPpag+$totPTaqPpag+$totPTaqPpagN;
                           $subGenGanPerTaq=$subGenGanPerTaq+$totGanPerTaq+$totGanPerTaqN;
                           $cobroAgente=$cobroAgente+$tCobroAgente+$tCobroAgenteN;
                           $eliminadosAgente=$eliminadosAgente+$totalAnulados+$totalAnuladosN;
                


                
                           $subCobroAgenteN=$subCobroAgenteN+$tCobroAgenteN;
                           //$tPuntosAg=$tPuntosAg+$totalRows_Recordset22;
                
                
                           //usd n
                

                           $tVtasAgAmeusd=$tVtasAgAmeusd+$totVentaTaqusd;
                           $tVtasAgNacusd=$tVtasAgNacusd+$totVentaTaqNusd;
                           $tVtasAgusd=$tVtasAgAmeusd;
                
                           $tPremPagosAgAmeusd=$tPremPagosAgAmeusd+$totPremiTaqusd;
                           $tPremPagosAgNacusd=$tPremPagosAgNacusd+$totPremiTaqNusd;
                           $tPremPagosAgusd=$tPremPagosAgNacusd+$tPremPagosAgAmeusd;
                
                           $tAnulAgAmeusd=$tAnulAgAmeusd+$totAnulaTaqusd;
                           $tAnulAgNacusd=$tAnulAgNacusd+$totAnulaTaqNusd;
                           $tAnulAgusd=$tAnulAgAmeusd;
                
                           $tCajaAgAmeusd=$tCajaAgAmeusd+$totTaquillausd;
                           $tCajaAgNacusd=$tCajaAgNacusd+$totTaquillaNusd;
                           $tCajaAgusd=$tCajaAgAmeusd+$tCajaAgNacusd;

                           $tPremPagarAgAmeusd=$tPremPagarAgAmeusd+$totPTaqPpagusd;
                           $tPremPagarAgNacusd=$tPremPagarAgNacusd+$totPTaqPpagNusd;
                           $tPremPagarAgusd=$tPremPagarAgAmeusd+$tPremPagarAgNacusd;
                
                            
                           $tAnulPagarAgAmeusd=$tAnulPagarAgAmeusd+$porPagarEliTaqusd;
                           $tAnulPagarAgNacusd=$tAnulPagarAgNacusd+$porPagarEliTaqNusd;
                           $tAnulPagarAgusd=$tAnulPagarAgAmeusd+$tAnulPagarAgNacusd;
                            
                           $totalAgAmeusd=$totalAgAmeusd+$totGanPerTaqusd;
                           $totalAgNacusd=$totalAgNacusd+$totGanPerTaqNusd;
                           $totalAgusd=$totalAgAmeusd+$totalAgNacusd;
                
                           $tCantTickElimAgAmeusd=$tCantTickElimAgAmeusd+$totusd;
                           $tCantTickElimAgNacusd=$tCantTickElimAgNacusd+$totNusd;
                           $tCantTickElimAgusd=$tCantTickElimAgAmeusd+$tCantTickElimAgNacusd;
                
                           $tMontTickElimAgAmeusd=$tMontTickElimAgAmeusd+$row_Recordset1['tot_eliminadusd'];
                           $tMontTickElimAgNacusd=$tMontTickElimAgNacusd+$row_Recordset21['tot_eliminadNusd'];
                           $tMontTickElimAgusd=$tMontTickElimAgAmeusd+$tMontTickElimAgNacusd;
                
                           $tCobrAgAmeusd=$tCobrAgAmeusd+$tCobroAgenteusd;
                           $tCobrAgusd=$tCobrAgAmeusd+$tCobrAgNacusd;
                                            
                           //usd fin n
                
                
                
                                
                
                
                
                           //cop n
                
                           $tVtasAgAmecop=$tVtasAgAmecop+$totVentaTaqcop;
                           $tVtasAgNaccop=$tVtasAgNaccop+$totVentaTaqNcop;
                           $tVtasAgcop=$tVtasAgAmecop;
                
                           $tPremPagosAgAmecop=$tPremPagosAgAmecop+$totPremiTaqcop;
                           $tPremPagosAgNaccop=$tPremPagosAgNaccop+$totPremiTaqNcop;
                           $tPremPagosAgcop=$tPremPagosAgNaccop+$tPremPagosAgAmecop;
                
                           $tAnulAgAmecop=$tAnulAgAmecop+$totAnulaTaqcop;
                           $tAnulAgNaccop=$tAnulAgNaccop+$totAnulaTaqNcop;
                           $tAnulAgcop=$tAnulAgAmecop;
                
                           $tCajaAgAmecop=$tCajaAgAmecop+$totTaquillacop;
                           $tCajaAgNaccop=$tCajaAgNaccop+$totTaquillaNcop;
                           $tCajaAgcop=$tCajaAgAmecop+$tCajaAgNaccop;

                           $tPremPagarAgAmecop=$tPremPagarAgAmecop+$totPTaqPpagcop;
                           $tPremPagarAgNaccop=$tPremPagarAgNaccop+$totPTaqPpagNcop;
                           $tPremPagarAgcop=$tPremPagarAgAmecop+$tPremPagarAgNaccop;
                
                            
                           $tAnulPagarAgAmecop=$tAnulPagarAgAmecop+$porPagarEliTaqcop;
                           $tAnulPagarAgNaccop=$tAnulPagarAgNaccop+$porPagarEliTaqNcop;
                           $tAnulPagarAgcop=$tAnulPagarAgAmecop+$tAnulPagarAgNaccop;
                            
                           $totalAgAmecop=$totalAgAmecop+$totGanPerTaqcop;
                           $totalAgNaccop=$totalAgNaccop+$totGanPerTaqNcop;
                           $totalAgcop=$totalAgAmecop+$totalAgNaccop;
                
                           $tCantTickElimAgAmecop=$tCantTickElimAgAmecop+$totcop;
                           $tCantTickElimAgNaccop=$tCantTickElimAgNaccop+$totNcop;
                           $tCantTickElimAgcop=$tCantTickElimAgAmecop+$tCantTickElimAgNaccop;
                
                           $tMontTickElimAgAmecop=$tMontTickElimAgAmecop+$row_Recordset1['tot_eliminadcop'];
                           $tMontTickElimAgNaccop=$tMontTickElimAgNaccop+$row_Recordset21['tot_eliminadNcop'];
                           $tMontTickElimAgcop=$tMontTickElimAgAmecop+$tMontTickElimAgNaccop;
                
                           $tCobrAgAmecop=$tCobrAgAmecop+$tCobroAgentecop;
                           $tCobrAgcop=$tCobrAgAmecop+$tCobrAgNaccop;
                           //cop fin n
                
                
                                
                
                
                           //sol n
                
                           $tVtasAgAmesol=$tVtasAgAmesol+$totVentaTaqsol;
                           $tVtasAgNacsol=$tVtasAgNacsol+$totVentaTaqNsol;
                           $tVtasAgsol=$tVtasAgAmesol;
                
                           $tPremPagosAgAmesol=$tPremPagosAgAmesol+$totPremiTaqsol;
                           $tPremPagosAgNacsol=$tPremPagosAgNacsol+$totPremiTaqNsol;
                           $tPremPagosAgsol=$tPremPagosAgNacsol+$tPremPagosAgAmesol;
                
                           $tAnulAgAmesol=$tAnulAgAmesol+$totAnulaTaqsol;
                           $tAnulAgNacsol=$tAnulAgNacsol+$totAnulaTaqNsol;
                           $tAnulAgsol=$tAnulAgAmesol;
                
                           $tCajaAgAmesol=$tCajaAgAmesol+$totTaquillasol;
                           $tCajaAgNacsol=$tCajaAgNacsol+$totTaquillaNsol;
                           $tCajaAgsol=$tCajaAgAmesol+$tCajaAgNacsol;

                           $tPremPagarAgAmesol=$tPremPagarAgAmesol+$totPTaqPpagsol;
                           $tPremPagarAgNacsol=$tPremPagarAgNacsol+$totPTaqPpagNsol;
                           $tPremPagarAgsol=$tPremPagarAgAmesol+$tPremPagarAgNacsol;
                
                            
                           $tAnulPagarAgAmesol=$tAnulPagarAgAmesol+$porPagarEliTaqsol;
                           $tAnulPagarAgNacsol=$tAnulPagarAgNacsol+$porPagarEliTaqNsol;
                           $tAnulPagarAgsol=$tAnulPagarAgAmesol+$tAnulPagarAgNacsol;
                            
                           $totalAgAmesol=$totalAgAmesol+$totGanPerTaqsol;
                           $totalAgNacsol=$totalAgNacsol+$totGanPerTaqNsol;
                           $totalAgsol=$totalAgAmesol+$totalAgNacsol;
                
                           $tCantTickElimAgAmesol=$tCantTickElimAgAmesol+$totsol;
                           $tCantTickElimAgNacsol=$tCantTickElimAgNacsol+$totNsol;
                           $tCantTickElimAgsol=$tCantTickElimAgAmesol+$tCantTickElimAgNacsol;
                
                           $tMontTickElimAgAmesol=$tMontTickElimAgAmesol+$row_Recordset1['tot_eliminadsol'];
                           $tMontTickElimAgNacsol=$tMontTickElimAgNacsol+$row_Recordset21['tot_eliminadNsol'];
                           $tMontTickElimAgsol=$tMontTickElimAgAmesol+$tMontTickElimAgNacsol;
                
                           $tCobrAgAmesol=$tCobrAgAmesol+$tCobroAgentesol;
                           $tCobrAgsol=$tCobrAgAmesol+$tCobrAgNacsol;



                           $taquillaspar=$taquillaspar;



                           //sol fin n
                       } while ($row_Recordset30 = mysqli_fetch_assoc($Recordset30)); ?>
						<tr bgcolor="#FFFFFF">
						  <td colspan="10">&nbsp;</td>
						</tr>
														   				<?php if ($tVtasAg!=0 or $tPremPagosAg!=0 or $tAnulAg!=0 or $tCajaAg!=0 or $tPremPagarAg!=0 or
                    $tAnulPagarAg!=0 or $totalAg!=0) {?>
					
						<tr bgcolor="#999999" style="font-size:12px;">
						  <td height="35" align="right" valign="middle"><strong>TOTALES BSS:</strong></td>
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
                          <strong><?php echo number_format($tCobrAg, 2, ",", "."); ?> BSS</strong>
                          </td>
						</tr>
										<?php } ?>
								   				<?php if ($tVtasAgusd!=0 or $tPremPagosAgusd!=0 or $tAnulAgusd!=0 or $tCajaAgusd!=0 or $tPremPagarAgusd!=0 or
                    $tAnulPagarAgusd!=0 or $totalAgusd!=0) {?>						
						

						<tr bgcolor="#999999" style="font-size:12px;">
						  <td height="35" align="right" valign="middle"><strong>TOTALES USD:</strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tVtasAgusd, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tPremPagosAgusd, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tAnulAgusd, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tCajaAgusd, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tPremPagarAgusd, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tAnulPagarAgusd, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($totalAgusd, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo "(".$tCantTickElimAgusd.") ".number_format($tMontTickElimAgusd, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php  echo number_format($tCobrAgusd, 2, ",", "."); ?> USD</strong>
                          </td>
						</tr>
						
										<?php } ?>
										
								   				<?php if ($tVtasAgcop!=0 or $tPremPagosAgcop!=0 or $tAnulAgcop!=0 or $tCajaAgcop!=0 or $tPremPagarAgcop!=0 or
                    $tAnulPagarAgcop!=0 or $totalAgcop!=0) {?>			
				
										<tr bgcolor="#999999" style="font-size:12px;">
						  <td height="35" align="right" valign="middle"><strong>TOTALES COP:</strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tVtasAgcop, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tPremPagosAgcop, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tAnulAgcop, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tCajaAgcop, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tPremPagarAgcop, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tAnulPagarAgcop, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($totalAgcop, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo "(".$tCantTickElimAgcop.") ".number_format($tMontTickElimAgcop, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tCobrAgcop, 2, ",", "."); ?> COP</strong>
                          </td>
						</tr>
										<?php } ?>
								   				<?php if ($tVtasAgsol!=0 or $tPremPagosAgsol!=0 or $tAnulAgsol!=0 or $tCajaAgsol!=0 or $tPremPagarAgsol!=0 or
                    $tAnulPagarAgsol!=0 or $totalAgsol!=0) {?>
				
														<tr bgcolor="#999999" style="font-size:12px;">
						  <td height="35" align="right" valign="middle"><strong>TOTALES SOL:</strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tVtasAgsol, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tPremPagosAgsol, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tAnulAgsol, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tCajaAgsol, 2, ",", "."); ?></strong></td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tPremPagarAgsol, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tAnulPagarAgsol, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($totalAgsol, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo "(".$tCantTickElimAgsol.") ".number_format($tMontTickElimAgsol, 2, ",", "."); ?></strong>
                          </td>
						  <td align="right" valign="middle">
                          <strong><?php echo number_format($tCobrAgsol, 2, ",", "."); ?> SOL</strong>
                          </td>
						</tr>
				<?php } ?>
				
				
				
						
						
						
						<?php
                   }
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                   $totSistemaA=$totSistemaA-($eliminadosAgenteA/1);
                   $totalPagarSistemaA=($totSistemaA)*($porcentaje/100);
                                        
                   $totSistemaAusd=$subTotVentaAusd-$eliminadosAgenteAusd;
                   $totalPagarSistemaAusd=($totSistemaAusd)*($porcentaje/100);

                   $totSistemaAcop=$subTotVentaAcop-$eliminadosAgenteAcop;
                   $totalPagarSistemaAcop=($totSistemaAcop)*($porcentaje/100);

                   $totSistemaAsol=$subTotVentaAsol-$eliminadosAgenteAsol;
                   $totalPagarSistemaAsol=($totSistemaAsol)*($porcentaje/100);
                    
                    
                   $totalPagarSistemaN=$tPuntosAg*$agen_cob_hnac;
                   $totVentaBanca=$totVentaBanca+$subTotVentaA;
                   $totAnulaBanca=$totAnulaBanca+$eliminadosAgenteA;
                   $totCobraBanca=$totCobraBanca+$totalPagarSistemaA;
                   $totCobraBancaN=$totCobraBancaN+$totalPagarSistemaN;
                   $tPuntosBa=$tPuntosBa+$tPuntosAg;
                    
                   $totVentaBancausd=$totVentaBancausd+$subTotVentaAusd;
                   $totAnulaBancausd=$totAnulaBancausd+$eliminadosAgenteAusd;
                   $totCobraBancausd=$totCobraBancausd+$totalPagarSistemaAusd;
                    
                   $totVentaBancacop=$totVentaBancacop+$subTotVentaAcop;
                   $totAnulaBancacop=$totAnulaBancacop+$eliminadosAgenteAcop;
                   $totCobraBancacop=$totCobraBancacop+$totalPagarSistemaAcop;
                    
                   $totVentaBancasol=$totVentaBancasol+$subTotVentaAsol;
                   $totAnulaBancasol=$totAnulaBancasol+$eliminadosAgenteAsol;
                   $totCobraBancasol=$totCobraBancasol+$totalPagarSistemaAsol;
                    
                   $totCobraBancausdx=$totCobraBancausd*$row_Recordset555['usdabss'];
                   $totCobraBancacopx=$totCobraBancacop*$row_Recordset555['copabss'];
                   $totCobraBancasolx=$totCobraBancasol*$row_Recordset555['solabss'];
                        
                   $totalacobrar=$totalPagarSistemaA+$totCobraBancausdx+$totCobraBancacopx+$totCobraBancasolx; ?>  
				   </table>
      			   <div style="background: #333; width:910px; float:left; padding:12px 13px 2px 12px;color:#FFF; font-size:20px;">
					<?php echo $row_Recordset3['nom_agencia']."&nbsp;|&nbsp;"; ?>
                    COSTO DEL SISTEMA AMERICANAS: <?php echo number_format($porcentaje, 2, ",", "."); ?>% - 
                    NACIONALES: <?php echo number_format($agen_cob_hnac, 2, ",", "."); ?>-
                    PARLEY: <?php echo number_format($agen_por_parley, 2, ",", "."); ?>%
                   </div>
      			   <div id="costo1" style="width:100%; float:left; padding:0px 0px 0px 0px">
														<?php
                            $tVtasAgAmez=((($tVtasAgAme-$tAnulAgAme-$tAnulPagarAgAme)/100)*($porcentaje));
                   $tVtasAgusdz=((($tVtasAgusd-$tAnulAgusd-$tAnulPagarAgusd)/100)*($porcentaje));
                   $tVtasAgusd2z=$tVtasAgusdz*$row_Recordset555['usdabss'];
                   $tVtasAgcopz=((($tVtasAgcop-$tAnulAgcop-$tAnulPagarAgcop)/100)*($porcentaje));
                   $tVtasAgcop2z=$tVtasAgcopz*$row_Recordset555['copabss'];
                   $tVtasAgsolz=((($tVtasAgsol-$tAnulAgsol-$tAnulPagarAgsol)/100)*($porcentaje));
                   $tVtasAgsol2z=$tVtasAgsolz*$row_Recordset555['solabss'];
                   $totalbssagente2020=$tVtasAgAmez+$tVtasAgusd2z+$tVtasAgcop2z+$tVtasAgsol2z;
                            
                   $acumuladoagentescobrobss=$acumuladoagentescobrobss+$tVtasAgAmez;
                   $acumuladoagentesventabss=$acumuladoagentesventabss+$totSistemaA; ?>
					   
					   <?php if ($totalbssagente2020!=0) {?>
					   <table width="934" border="0" style="color:#000; font-size:16px" bordercolor="#F5F5F5">
						  <tr style="background:#5EAEFF; color:#FFF" valign="middle" align="center">
							<td height="46" bgcolor="#333">&nbsp;</td>
							<td width="418" bgcolor="#7DCEA0"  style="color:#FFF; font-size:20px">COBRAR AL AGENTE<br/>

							                            	<strong><?php echo "TOTAL A COBRAR.. >> ". number_format($totalbssagente2020, 2, ",", "."); ?> BSS</strong>
</td>
			   </tr>
			   								   				<?php if ($totalPagarSistemaA!=0) {?>
						  <tr style="background: #999; color:# 000" valign="middle" align="center">
							<td align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;
                            </td>
							<td align="right" valign="middle" bgcolor="#7DCEA0" style="color:#FFF; font-size:15px">
                            	<strong><?php echo number_format($tVtasAgAmez, 2, ",", "."); ?> BSS</strong>
                            </td>
						  </tr>
<?php } ?>
			   								   				<?php if ($totalPagarSistemaAusd!=0) {?>
						  <tr style="background: #999; color:# 000" valign="middle" align="center">
							<td align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;
                            </td>
							<td align="right" valign="middle" bgcolor="#7DCEA0" style="color:#FFF; font-size:15px">

                            	<strong><?php echo number_format($tVtasAgusdz, 2, ",", ".")."&nbsp;USD.. > ".number_format($tVtasAgusd2z, 2, ",", ".")."&nbsp;BSS"; ?></strong>
                            </td>
						  </tr>
<?php } ?>						  
			   								   				<?php if ($totalPagarSistemaAcop!=0) {?>						
				  <tr style="background: #999; color:# 000" valign="middle" align="center">
							<td align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;
                            </td>
							<td align="right" valign="middle" bgcolor="#7DCEA0" style="color:#FFF; font-size:15px">
                            	<strong><?php echo number_format($tVtasAgcopz, 2, ",", ".")."&nbsp;COP > ".number_format($tVtasAgcop2z, 2, ",", ".")."&nbsp;BSS"; ?></strong>
                            </td>
						  </tr>
<?php } ?>						  
			   								   				<?php if ($totalPagarSistemaAsol!=0) {?>						  
						  						  <tr style="background: #999; color:# 000" valign="middle" align="center">
							<td align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;
                            </td>
							<td align="right" valign="middle" bgcolor="#7DCEA0" style="color:#FFF; font-size:15px">
                            	<strong><?php echo number_format($tVtasAgsolz, 2, ",", ".")."&nbsp;SOL > ".number_format($tVtasAgsol2z, 2, ",", ".")."&nbsp;BSS"; ?></strong>
                            </td>
						  </tr>
						  
<?php } ?>
						
						  <tr bgcolor="#999" style="font-size:28px;">
							<td height="20" colspan="4" align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
						  </tr>
                      </table>    
<?php } ?>					  
					  
					  
				<?php
echo '<br/><br/><br/>';
               } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
               $totGenBanca=$totVentaBanca-$totAnulaBanca;
               $cobroaBanca=($totGenBanca*$row_Recordset12['dist_por_ame'])/100;
               $cobroaBancaN=$row_Recordset12['dist_cob_hnac']*$tPuntosBa;
               $costosistema=$cobroaBanca+$cobroaBancaN;
               $ganBanca1=$totCobraBanca+$totCobraBancaN;
               //$ganBanca=$ganBanca1-$costosistema;
               $ganBanca=$totCobraBancaN;
                
                
               $totGenBancausd=$totVentaBancausd-$totAnulaBancausd;
               $cobroaBancausd=($totGenBancausd*$row_Recordset12['dist_por_ame'])/100;
               $cobroaBancaNusd=0*$tPuntosBa;
               $costosistemausd=$cobroaBancausd;
               $ganBanca1usd=$totCobraBancausd+$totCobraBancaNusd;
               $ganBancausd=$ganBanca1usd-$costosistemausd;

                
               $totGenBancacop=$totVentaBancacop-$totAnulaBancacop;
               $cobroaBancacop=($totGenBancacop*$row_Recordset12['dist_por_ame'])/100;
               $cobroaBancaNcop=0*$tPuntosBa;
               $costosistemacop=$cobroaBancacop;
               $ganBanca1cop=$totCobraBancacop+$totCobraBancaNcop;
               $ganBancacop=$ganBanca1cop-$costosistemacop;
                
               $totGenBancasol=$totVentaBancasol-$totAnulaBancasol;
               $cobroaBancasol=($totGenBancasol*$row_Recordset12['dist_por_ame'])/100;
               $cobroaBancaNsol=0*$tPuntosBa;
               $costosistemasol=$cobroaBancasol;
               $ganBanca1sol=$totCobraBancasol+$totCobraBancaNsol;
               $ganBancasol=$ganBanca1sol-$costosistemasol;

               $cambiousdabss=$costosistemausd*$row_Recordset555['usdabss'];
               $cambiocopabss=$costosistemacop*$row_Recordset555['copabss'];
               $cambiosolabss=$costosistemasol*$row_Recordset555['solabss'];

               $puntosnacionales=$cambiousdabss+$cambiocopabss+$cambiosolabss;
                        
               //$totalapagar=$costosistema+$cambiousdabss+$cambiocopabss+$cambiosolabss;
               $totalapagar=$corbro+$cambiousdabss+$cambiocopabss+$cambiosolabss+$puntosnacionales;
                        
               $gacambiousdabss=$ganBancausd*$row_Recordset555['usdabss'];
               $gacambiocopabss=$ganBancacop*$row_Recordset555['copabss'];
               $gacambiosolabss=$ganBancasol*$row_Recordset555['solabss'];
                        
               $totalgananciaporreventa=$ganBanca+$gacambiousdabss+$gacambiocopabss+$gacambiosolabss;
                
                
                
               $acumuladoagentesventabss=($acumuladoagentesventabss/100)*$row_Recordset12['dist_por_ame'];
               $ganBancaz=$acumuladoagentescobrobss-$costosistema;
                
               $totalgananciaporreventa=$ganBancaz+$gacambiousdabss+$gacambiocopabss+$gacambiosolabss; ?>
                <HR/>
								  <?php /* ?>
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
                                <strong><?php echo number_format($totCobraBanca+$totCobraBancaN,2,",","."); ?></strong>
                            </td>
                          </tr>
                          <tr bgcolor="#999" style="font-size:28px;">
                            <td height="20" colspan="4" align="right" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                          </tr>
                      </table>
                   </div>

                   <?php */ ?>
				   
				   
		   <?php
           } else {?>
           		<table width="941" border="1" style="color:#000; font-size:16px" bordercolor="#F5F5F5">
                    <tr align="left">
                        <td height="40" colspan="9" style="background: #FFF; color:#000; font-size:24px">NO EXISTEN DATOS</td>
                    </tr>
                </table><?php
           }
           //Modificacion Angel
           $costosistema=$corbro;
           //Fin
            ?>
            
</div>			
</div><!-- end .mostrar -->
<span class="boton-top" title="ir arriba">▲</span>
</div>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});
document.getElementById('pagAgen').innerHTML = "<?php echo number_format($costosistema, 2, ",", ".")."&nbsp;BSS"; ?>";
document.getElementById('GanDistri').innerHTML = "<?php echo number_format($ganBancaz, 2, ",", ".")."&nbsp;BSS.."; ?>";

document.getElementById('pagAgenusd').innerHTML = "<?php echo number_format($costosistemausd, 2, ",", ".")."&nbsp;USD > ".number_format($cambiousdabss, 2, ",", ".")."&nbsp;BSS"; ?>";
document.getElementById('GanDistriusd').innerHTML = "<?php echo number_format($ganBancausd, 2, ",", ".")."&nbsp;USD > ".number_format($gacambiousdabss, 2, ",", ".")."&nbsp;BSS"; ?>";

document.getElementById('pagAgencop').innerHTML = "<?php echo number_format($costosistemacop, 2, ",", ".")."&nbsp;COP > ".number_format($cambiocopabss, 2, ",", ".")."&nbsp;BSS"; ?>";
document.getElementById('GanDistricop').innerHTML = "<?php echo number_format($ganBancacop, 2, ",", ".")."&nbsp;COP > ".number_format($gacambiocopabss, 2, ",", ".")."&nbsp;BSS"; ?>";

document.getElementById('pagAgensol').innerHTML = "<?php echo number_format($costosistemasol, 2, ",", ".")."&nbsp;SOL > ".number_format($cambiosolabss, 2, ",", ".")."&nbsp;BSS"; ?>";
document.getElementById('GanDistrisol').innerHTML = "<?php echo number_format($ganBancasol, 2, ",", ".")."&nbsp;SOL > ".number_format($gacambiosolabss, 2, ",", ".")."&nbsp;BSS"; ?>";

document.getElementById('pagAgentodos').innerHTML = "<?php echo "<br> NACIONALES >> ". number_format($puntosnacionales, 2, ",", ".")."&nbsp;BSS(".$taquillaspar.")"; ?>";

document.getElementById('totalapagar').innerHTML = "<?php echo "TOTAL A PAGAR >> ". number_format($totalapagar, 2, ",", ".")."&nbsp;BSS<br/><br/>"; ?>";
document.getElementById('totalganacia').innerHTML = "<?php echo "TOTAL GANANCIA >> ". number_format($totalgananciaporreventa, 2, ",", ".")."&nbsp;BSS<br/><br/>"; ?>";
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
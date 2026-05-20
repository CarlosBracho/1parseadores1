<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xVarUsuario_Recordset1=$_SESSION['MM_id_usuario'];
$xHora=horaactual2();
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$fechasistema=fechaactualbd();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventaslot\ventas_reimprimir_lot.php - QUERY 1 */ SELECT 
	ve.ticket_lot,
	ve.hor_venta_lot,
	ba.hor_cierre,
	SUM(ve.mon_apuesta_lot) AS monto
FROM 
	venta_lot ve,
	loterias lt,
	bancaloterias ba,
	agencia ag,
	taquilla ta,
	taquilla_opc_lot tp,
	usuario us
WHERE
	ve.tip_loteria_lot < 4 AND 
	ve.est_ticket_lot = 1 AND ve.fec_venta_lot = %s AND ve.id_usuario = %s AND
	us.id_usuario = ve.id_usuario AND us.cod_taquilla = ta.cod_taquilla AND
	tp.cod_taquilla = ta.cod_taquilla AND lt.id_loteria = ve.id_loteria AND
	ta.cod_agencia = ag.cod_agencia AND ba.id_banca = ag.cod_banca AND
	ba.id_loteria = ve.id_loteria 
GROUP BY ve.ticket_lot
ORDER BY ve.hor_venta_lot ASC, ve.num_ticket_lot DESC",
    GetSQLValueString($fechasistema, "date"),
    GetSQLValueString($xVarUsuario_Recordset1, "int")
);
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysqli_query($conexionbanca, $query_limit_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
if (isset($_GET['totalRows_Recordset1'])) {
    $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
    $all_Recordset1 = mysqli_query($conexionbanca, $query_Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
$currentPage = $_SERVER["PHP_SELF"];
$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (stristr($param, "pageNum_Recordset1") == false &&
        stristr($param, "totalRows_Recordset1") == false) {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0) {
        $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseVentas2.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
</head>

<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="content5">
	<!-- InstanceBeginEditable name="Contenido" -->
	<div style="background: #333333; width:100%; float:left; padding:50px 2px 2px 2px;color:#FFF; font-size:28px; text-align:center;
		font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
        REIMPRIMIR TICKET
	</div><!-- end .container -->	        
	<div style="background: #DDDDDD; width:100%; float:left; text-align:right; padding:20px 2px 60px 2px;
   		color: #000; font-size:18px; text-align:center;  height:100%;
        font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
        <div style="float:left; width:35%; border-bottom:1px solid #C1BDBE;
        	border-bottom-width: thin;">TICKET</div>
        <div style="float:left; width:25%; border-bottom:1px solid #C1BDBE;
        	border-bottom-width: thin;">HORA</div>
        <div style="float:left; width:25%; border-bottom:1px solid #C1BDBE;
        	border-bottom-width: thin;">MONTO</div>
        <div style="float:left; width:15%; border-bottom:1px solid #C1BDBE;
        	border-bottom-width: thin;">ACCIÓN</div>
		<?php
        if ($totalRows_Recordset1>0) {
            $d=0;
            do {
                if ($d%2==0) {
                    $bgr="#FFF";
                } else {
                    $bgr="#DDDDDD";
                } ?>	
                <div style="float:left; width:35%;background:<?php echo $bgr; ?>; font-size:16px; text-align:right;height:21px">
                	<?php echo $row_Recordset1['ticket_lot']; ?>
                </div>
                <div style="float:left; width:25%;background:<?php echo $bgr; ?>; font-size:16px;height:21px">
                	<?php echo horaampm($row_Recordset1['hor_venta_lot']); ?>
                </div>
                <div style="float:left; width:25%; background:<?php echo $bgr; ?>; font-size:16px;text-align:right;height:21px">
                    <?php echo " ".$row_Recordset1['monto']; ?>
                </div>
                <div style="float:left; width:15%; background:<?php echo $bgr; ?>; font-size:16px;height:21px">
					<?php
                    $horacarrerabd=$row_Recordset1['hor_venta_lot'];
                if ($horacarrerabd<"23:55:00") {
                    $aumento=$horacarrerabd."+5 min";
                    $horacarrerabd=(date('H:i', strtotime($aumento)));
                }
                if ($horacarrerabd >= horaactual() or $row_Recordset1['hor_venta_lot']>=horaactual()) {
                    $ticket2=$row_Recordset1['ticket_lot'];
                    $insertGoTo = "ventas_reimprimir_ultimo_lot.php?recordID=$ticket2"; ?>
						<a href="#" title="imprimir ticket #:<?php echo $row_Recordset1['ticket_lot']; ?>"
                        onclick="javascript:window.open('<?php echo $insertGoTo ?>','Ticket','width=230,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes');"><img src="../images/printer-icon.png" width="19" height="19" />
                        </a>
						<?php
                } else {
                    echo "CERRADO";
                } ?>                                        	
                </div><?php
                 $d++;
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        } else {?>
		<div style="float:left; width:100%; background: #FFF; color:#C00; text-align:left; padding:0px 0px 0px 10px; font-size:16px;
        	font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
        	No existen registros
        </div>        
		<?php } //no Existen registros?> 
   </div><!-- end .container -->
  <!-- InstanceEndEditable -->
</div><!-- end .container -->
</body>
<!-- InstanceEnd --></html>
<?php mysqli_free_result($Recordset1); ?>
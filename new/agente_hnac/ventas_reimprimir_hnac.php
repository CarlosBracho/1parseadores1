<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xVarUsuario_Recordset1=$_SESSION['MM_id_usuario'];
$xHora=horaactual2();
$maxRows_Recordset1 = 15;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$fechasistema=fechaactualbd();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\agente_hnac\ventas_reimprimir_hnac.php - QUERY 1 */ SELECT 
venta_hnac.ticket_hnac,
venta_hnac.hor_venta_hnac,
carrera_hnac.cod_carrera_hnac,
carrera_hnac.hor_carrera_hnac,
hipodromo_hnac.nom_hipodromo_hnac,
carrera_hnac.num_carrera_hnac,
carrera_hnac.est_carrera_hnac,
SUM(venta_hnac.mon_venta_hnac) AS monto
FROM 
venta_hnac,
hipodromo_hnac,
carrera_hnac
WHERE 
venta_hnac.est_ticket_hnac=1 AND 
venta_hnac.fec_venta_hnac = %s AND 
venta_hnac.id_usuario = %s AND
carrera_hnac.est_carrera_hnac = 1 AND
carrera_hnac.hor_carrera_hnac >= %s AND
carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND

carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac
GROUP BY venta_hnac.ticket_hnac
ORDER BY venta_hnac.num_ticket_hnac DESC
",
    GetSQLValueString($fechasistema, "date"),
    GetSQLValueString($xVarUsuario_Recordset1, "int"),
    GetSQLValueString($xHora, "date")
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
   <div style="background: #0E5157; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center">
        REIMPRIMIR TICKET
   </div><!-- end .container -->
   <div style="background: #CCC; width:100%; float: left; padding:10px 10px 0px 0px;
   		color: #000; font-size:12px; text-align: right">
        Ticket <?php echo($startRow_Recordset1 + 1) ?>-<?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> de <?php echo $totalRows_Recordset1 ?>
        <?php if ($pageNum_Recordset1 > 0) { // Show if not first page?>
        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="../images/First.gif" /></a>
        <?php } // Show if not first page?>
<?php if ($pageNum_Recordset1 > 0) { // Show if not first page?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="../images/Previous.gif" /></a>
          <?php } // Show if not first page?>
        <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="../images/Next.gif" /></a>
          <?php } // Show if not last page?>
         <?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="../images/Last.gif" /></a>
          <?php } // Show if not last page?>           
   </div>	        
   <div style="background: #CCC; width:100%; float:left; text-align:right; padding:20px 2px 60px 2px;
   		color: #000; font-size:18px; text-align:center;  height:100%;">
        <div style="float:left; width:25%; border-bottom-color: #333; border-bottom-style: solid;
        	border-bottom-width: thin;">TICKET</div>
        <div style="float:left; width:15%; border-bottom-color: #333; border-bottom-style: solid;
        	border-bottom-width: thin;">HORA</div>
        <div style="float:left; width:35%; border-bottom-color: #333; border-bottom-style: solid;
        	border-bottom-width: thin;">HIPÓDROMO</div>
        <div style="float:left; width:15%; border-bottom-color: #333; border-bottom-style: solid;
        	border-bottom-width: thin;">MONTO</div>
        <div style="float:left; width:10%; border-bottom-color: #333; border-bottom-style: solid;
        	border-bottom-width: thin;">ACCIÓN</div>
		<?php
        if ($totalRows_Recordset1>0) {
            $d=0;
            do {
                if ($d%2==0) { ?>	
                <div style="float:left; width:20%; background:#FFF; font-size:16px; text-align:right;height:21px">
                	<?php echo $row_Recordset1['ticket_hnac']; ?>
                </div>
                <div style="float:left; width:15%; background:#FFF; font-size:16px;height:21px">
                	<?php echo horaampm($row_Recordset1['hor_venta_hnac']); ?>
                </div>
                <div style="float:left; width:35%; background:#FFF; font-size:16px;height:21px">
                	<?php echo $row_Recordset1['nom_hipodromo_hnac']." Carr: ...".$row_Recordset1['num_carrera_hnac']; ?>
                </div>
                <div style="float:left; width:15%; background:#FFF; font-size:16px;text-align:right;height:21px">
                    <?php echo " ".$row_Recordset1['monto']; ?>
                </div>
                <div style="float:left; width:15%; background:#FFF; font-size:16px;height:21px">
					<?php
                    $statusdecarrera=$row_Recordset1['est_carrera_hnac'];
                    $horacarrerabd=$row_Recordset1['hor_carrera_hnac'];
                    if ($horacarrerabd<"23:55:00") {
                        $aumento=$horacarrerabd."+5 min";
                        $horacarrerabd=(date('H:i', strtotime($aumento)));
                    }
                    if ($horacarrerabd >= horaactual() && $statusdecarrera==1) {?>
                        <?php
                        $ticket2=$row_Recordset1['ticket_hnac'];
                        $insertGoTo = "ventas_reimprimir_ultimo_hnac.php?recordID=$ticket2";	?>
						<a href="#" title="imprimir ticket #:<?php echo $row_Recordset1['ticket_hnac']; ?>"
                        onclick="javascript:window.open('<?php echo $insertGoTo ?>','Ticket','width=230,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes');"><img src="../images/printer-icon.png" width="19" height="19" />
                        </a>
						<?php
                    } else {
                        echo "CERRADA";
                    }?>                                        	
                </div>
                <?php } else {?>
                <div style="float:left; width:20%; font-size:16px; text-align:right;height:21px">
                 	<?php echo $row_Recordset1['ticket_hnac']; ?>
                </div>
                <div style="float:left; width:15%; font-size:16px;height:21px">
                    <?php echo horaampm($row_Recordset1['hor_venta_hnac']); ?>
                </div>
                <div style="float:left; width:35%; font-size:16px;height:21px">
					<?php echo $row_Recordset1['nom_hipodromo_hnac']." Carr: ...".$row_Recordset1['num_carrera_hnac']; ?>
                </div>
                <div style="float:left; width:15%; font-size:16px; text-align:right;height:21px">
					<?php echo " ".$row_Recordset1['monto']; ?>
                </div>
                <div style="float:left; width:15%; font-size:16px;height:21px">
					<?php
                    $statusdecarrera=$row_Recordset1['est_carrera_hnac'];
                    $horacarrerabd=$row_Recordset1['hor_carrera_hnac'];
                    if ($horacarrerabd<"23:55:00") {
                        $aumento=$horacarrerabd."+5 min";
                        $horacarrerabd=(date('H:i', strtotime($aumento)));
                    }
                    if ($horacarrerabd >= horaactual() && $statusdecarrera==1) {?>
                        <?php
                        $ticket2=$row_Recordset1['ticket_hnac'];
                        $insertGoTo = "ventas_reimprimir_ultimo_hnac.php?recordID=$ticket2";?>
						<a href="#" title="imprimir ticket #:<?php echo $row_Recordset1['ticket_hnac']; ?>"
                        onclick="javascript:window.open('<?php echo $insertGoTo ?>','Ticket','width=230,height=620,left=0,         top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes');"><img src="../images/printer-icon.png" width="19" height="19" />
                        </a>
						<?php
                    } else {
                        echo "CERRADA";
                    }?>                                        	
                </div>
                <?php }
                $d++;
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        } else {?>
		<div style="float:left; width:100%; background: #FFF; color:#C00; text-align:left; padding:0px 0px 0px 10px; font-size:16px">
        	No existen registros
        </div>        
		<?php } //no Existen registros?> 
   </div><!-- end .container -->
  <!-- InstanceEndEditable -->
</div><!-- end .container -->
</body>
<!-- InstanceEnd --></html>
<?php mysqli_free_result($Recordset1); ?>
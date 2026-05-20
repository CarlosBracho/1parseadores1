<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xVarUsuario_Recordset1=$_SESSION['MM_id_usuario'];
$xHora=horaactual2();
$maxRows_Recordset1 = 100;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$fechasistema=fechaactualbd();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventasmie\ventas_reimprimir.php - QUERY 1 */ SELECT 
venta.ticket,
venta.hor_venta,
venta.tra_codigo,
venta.cod_cliente,
venta.efectivoO,
carrera.cod_carrera,
carrera.hor_carrera,
carrera.nom_hipodromo,
carrera.num_carrera,
carrera.est_carrera
FROM 
venta,
carrera
WHERE 
venta.lin_ticket = 1 AND 
venta.est_ticket=1 AND 
venta.fec_venta = %s AND 
venta.id_usuario = %s AND
carrera.control_dividendo >= 0 AND 
carrera.control_dividendo <= 1 AND
carrera.cod_carrera = venta.cod_carrera
ORDER BY venta.num_ticket DESC",
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
 <div style="background: #333; width:100%; float:left; padding:50px 2px 2px 2px;
 		color:#FFF; font-size:28px; text-align:center">
REIMPRIMIR TICKET
 </div><!-- end .container -->
 <div style="background: #CCC; width:100%; float:left; text-align:right; padding:20px 2px 60px 2px;
 		color: #000; font-size:18px; text-align:center;height:100%;">
<div style="float:left; width:25%; border-bottom-color: #333; border-bottom-style: solid;
	border-bottom-width: thin;">TICKET/CLIENTE</div>
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
<div style="float:left; width:20%; background:#FFF; font-size:16px; text-align:right">
	<?php
        if ($row_Recordset1['tra_codigo']==0) {
            echo $row_Recordset1['ticket'];
        } elseif ($row_Recordset1['tra_codigo']==1) {
            echo $row_Recordset1['cod_cliente'];
        }
    ?>
</div>
<div style="float:left; width:15%; background:#FFF; font-size:16px; ">
	<?php
$hora1=$row_Recordset1['hor_venta'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?>
</div>
<div style="float:left; width:35%; background:#FFF; font-size:16px">
	<?php echo $row_Recordset1['nom_hipodromo']." Carr: ...".$row_Recordset1['num_carrera']; ?>
</div>
<div style="float:left; width:15%; background:#FFF; font-size:16px;text-align:right">
					<?php echo ObtenerMonTototalVenta($row_Recordset1['ticket']); ?>
</div>
<div style="float:left; width:15%; background:#FFF; font-size:16px">
					<?php
$statusdecarrera=$row_Recordset1['est_carrera'];
$horacarrerabd=horaactual2();
                    if ($horacarrerabd<"23:20:00") {
                        $aumento=$horacarrerabd."+1 min";
                        $horacarrerabd=(date('H:i', strtotime($aumento)));
                    }
if ($horacarrerabd >= horaactual()) {?>
<?php
$ticket2=$row_Recordset1['ticket'];
$insertGoTo = "ventas_revistaticket.php?recordID=$ticket2";	?>
						<a href="#" title="imprimir ticket #:<?php echo $row_Recordset1['ticket']; ?>"
onclick="javascript:window.open('<?php echo $insertGoTo ?>','Ticket','width=200,height=620,left=0, top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes');"><img src="../images/printer-icon.png" width="19" height="19" />
</a>
						<?php
                    } else {
                echo "CERRADA";
            }?>	
</div>
<?php } else {?>
<div style="float:left; width:20%; font-size:16px; text-align:right">
 	<?php echo $row_Recordset1['ticket']; ?>
</div>
<div style="float:left; width:15%; font-size:16px">
	<?php
$hora1=$row_Recordset1['hor_venta'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?>
</div>
<div style="float:left; width:35%; font-size:16px">
					<?php echo$row_Recordset1['nom_hipodromo']." Carr: ...".$row_Recordset1['num_carrera']; ?>
</div>
<div style="float:left; width:15%; font-size:16px; text-align:right">
					<?php echo ObtenerMonTototalVenta($row_Recordset1['ticket']); ?>
</div>
<div style="float:left; width:15%; font-size:16px">
					<?php
$statusdecarrera=$row_Recordset1['est_carrera'];
$horacarrerabd=horaactual2();;
                    if ($horacarrerabd<"23:20:00") {
                        $aumento=$horacarrerabd."+1 min";
                        $horacarrerabd=(date('H:i', strtotime($aumento)));
                    }
if ($horacarrerabd >= horaactual()) {?>
<?php
$ticket2=$row_Recordset1['ticket'];
$insertGoTo = "ventas_revistaticket.php?recordID=$ticket2";?>
						<a href="#" title="imprimir ticket #:<?php echo $row_Recordset1['ticket']; ?>"
onclick="javascript:window.open('<?php echo $insertGoTo ?>','Ticket','width=200,height=620,left=0, top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes');"><img src="../images/printer-icon.png" width="19" height="19" />
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
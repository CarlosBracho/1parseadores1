<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$maxRows_Recordset1 = 9;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$xTicket_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf("/* PARSEADORES1 ventas\ventas_vistaticket.php - QUERY 1 */ SELECT * FROM venta WHERE venta.ticket = %s ORDER BY venta.cod_tventa", GetSQLValueString($xTicket_Recordset1, "int"));
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
$editFormAction = $_SERVER['PHP_SELF'];
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $insertGoTo = "index.php";
    header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
</head>
<html><head>
</head>
<body onload="javascript:document.all.cmdPrint.focus();" bgcolor="#E1F0F8" text="black" link="blue" vlink="purple" alink="red"><object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72">
</object>
<script language="vbscript">
<!--
function doPrint()
document.all.item("noprint").style.display="none"
document.all.item("printtitle").style.display="none"
document.all.item()
with factory.printing
.header = ""
.footer = ""
.topMargin = 0.4
.bottomMargin = 0.4
.leftMargin = 0.4
.rightMargin = 0.4
.Print(false)
end with
document.all.item("noprint").style.display=""
document.all.item("printtitle").style.display=""
end function
//-->
</script>
<title>.:Apuestas Hípicas:.</title>
<div id="printtitle" align="left" style="margin: 0px">
<?php $horacarrerabd=ObtenerHoraJugadaCarrera($row_Recordset1['cod_carrera']);
$aumento=$horacarrerabd."+5 min"; $horacarrerabd=(date('H:i', strtotime($aumento)));
$usuarioTicket=$row_Recordset1['id_usuario']; $taquillaTicket=ObtenerCodigoUsuarioTaquilla($usuarioTicket);
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta']==fechaactualbd() && $totalRows_Recordset1>0 && $_SESSION['MM_id_usuario']==$usuarioTicket && $taquillaTicket==$row_Recordset1['cod_taquilla']) {
    ?>
</div>
<form name="form1" action="confirma1.asp" method="post">
<table width="225" border="0" align="left">
  <tr>
    <td colspan="3" align="center" class="imprimir" scope="col"><strong><?php echo ObtenerNombreTaquilla($row_Recordset1['cod_taquilla']); ?></strong></td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="imprimir" scope="col"><strong>--ORIGINAL--</strong></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="imprimir" scope="col">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta']); ?></span></td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="imprimir" scope="col">Hora: <?php echo horaampm($row_Recordset1['hor_venta']); ?></span></td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket']; ?></span></td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="imprimirnroticket">Serial:<?php echo $row_Recordset1['ser_venta']; ?></span></td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="imprimir">Vendedor: <?php echo ObtenerNombreVendedor($row_Recordset1['id_usuario']); ?></span></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="imprimir">#:<?php echo $row_Recordset1['can_ticket']; ?></span></td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="apuestajugada"><?php echo "  ". ObtenerNombreynumeroJugadaCarrera($row_Recordset1['cod_carrera']); ?></td>
    </tr>
  <tr class="imprimir" align="center">
    <td width="100">EJEMPLAR</td>
    <td width="25">APUESTA</td>
    <td width="100">MONTO</td>
  </tr>
 <?php
  $montoapagar=0;
    $ip=$row_Recordset1['ip_venta'];
    do { ?>
  <tr class="apuestajugada" align="center">
    <td><?php echo $row_Recordset1['num_caballo']; ?></td>
    <td><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?></td>
    <td align="right"><?php echo number_format($row_Recordset1['mon_venta'], 2, ",", "."); ?></td>
  </tr>
  		<?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?>
  <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
  <tr>
    <td colspan="3" class="imprimirnroticket" height="8" align="center">-------------------</td>
  </tr>
  <tr>
    <td colspan="3" class="imprimirnroticket" height="8" align="right"><strong><?php echo "Total: Bs. ".number_format($montoapagar, 2, ",", "."); ?></strong></td>
    </tr>
  <tr>
    <td colspan="3" align="left"><span class="imprimirnroticket">IP:<?php echo $ip; ?></span></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>.</p></td>
    </tr>
</table>
<div id="noprint" align="center">
    <div align="left">
<br>.<br><br>
<script language="JavaScript">
doprint();
window.location="index.php";
</script>

</div>
</div> 
</form>	 
    <p>
      <?php
} else {
            echo "No se produjo ningún resultado"; ?>
    </p>
    <p>
    </p>
    <p><a href="index.php">Volver a taquilla</a></p> 
    <?php
        } ?>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
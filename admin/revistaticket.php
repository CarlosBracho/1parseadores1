<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 admin\revistaticket.php - QUERY 1 */ SELECT ser_venta, est_ticket, cod_taquilla, fec_venta, hor_venta, ticket, id_usuario, ip_venta,
	mon_venta, can_ticket, cod_carrera, num_caballo, cod_tventa 
	FROM venta WHERE ticket = %s",
    GetSQLValueString($xTicket_Recordset1, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$serial=$row_Recordset1['ser_venta'];
$rest = substr($serial, 0, 2);
$rest = $rest.$xTicket_Recordset1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style media="print" type="text/css">
#imprimir {
visibility:hidden
}
</style>
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
</head>
<body style="margin: 0px">
    <div>
    <?php
    if ($row_Recordset1['est_ticket']==0) {
        $estado="--ELIMINADO--";
    } else {
        $estado="--COPIA--";
    }
    ?>
<table width="225" border="0" align="left"><form id="form1" name="form1" method="post" action="">
  <tr>
    <td colspan="4" align="center" class="imprimir"><?php echo ObtenerNombreTaquilla($row_Recordset1['cod_taquilla']); ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimir"><?php echo $estado; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta']); ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimir">Hora: <?php echo horaampm($row_Recordset1['hor_venta']); ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket']; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimirnroticket">Codigo de ticket: <?php echo $rest; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="imprimir">Vendedor: <?php echo ObtenerNombreVendedor($row_Recordset1['id_usuario']); ?> #:<?php echo $row_Recordset1['can_ticket']; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="center" class="apuestajugada"><?php echo "  ". ObtenerNombreynumeroJugadaCarrera($row_Recordset1['cod_carrera']); ?></td>
  </tr>
  <tr class="imprimir">
    <td width="163" align="center">EJEMPLAR</td>
    <td colspan="2" align="center">APUESTA</td>
    <td width="171" align="center">MONTO</td>
  </tr>
  <?php
  $montoapagar=0; $ip=$row_Recordset1['ip_venta'];
  do { ?>
  <tr  class="apuestajugada">
    <td align="center">
        <?php echo $row_Recordset1['num_caballo']; ?>
       
    <td colspan="2" align="center"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?></td>
    <td align="right"><?php echo number_format($row_Recordset1['mon_venta'], 2, ",", "."); ?></td>
    <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?>
  </tr>
  <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
  <tr>
    <td class="imprimirnroticket" height="8" colspan="4" align="right"><p><span class="imprimir">-------------------- <br/>
          <strong><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></strong></span></p>
      <p><span class="imprimir"><?php echo $estado; ?></span></p>
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td class="imprimir" height="8" colspan="4" align="left"><span class="imprimir"><?php echo "Reimp.: ".verfechaactualcorta(); ?></span></td>
    </tr>
  <tr>
    <td height="10" colspan="4" align="left"><span class="imprimir">IP: <?php echo $ip; ?>  
    </span>
    <tr>

    <td height="10" colspan="4" align="center">
<label>
<input type="button" name="imprimir" id="imprimir" value="Imprimir Ticket" onclick="window.print(); self.close();" />
</label>
</form></td>
        </tr>
    </table>
    </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
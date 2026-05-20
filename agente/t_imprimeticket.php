<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1=0;
$usuario_venta=0;
if (isset($_GET["recordID"]) && isset($_GET["uVenta"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
    $usuario_venta = $_GET["uVenta"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 agente\t_imprimeticket.php - QUERY 1 */ SELECT 
venta.fec_venta, 
venta.hor_venta,
venta.ser_venta,
venta.can_ticket,
venta.num_caballo,
venta.ip_venta,
venta.ticket,
venta.cod_tventa,
venta.mon_venta,
usuario.nom_usuario,
usuario.cod_barra,
taquilla.nom_taquilla,
carrera.nom_hipodromo,
carrera.num_carrera,
carrera.hor_carrera
FROM 
venta,
carrera,
usuario,
taquilla 
WHERE 
venta.ticket = %s AND
venta.id_usuario = %s AND
carrera.cod_carrera = venta.cod_carrera AND
usuario.id_usuario = venta.id_usuario AND
usuario.cod_taquilla = taquilla.cod_taquilla
ORDER BY venta.cod_tventa",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($usuario_venta, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$horacarrerabd=$row_Recordset1['hor_carrera'];
if ($horacarrerabd<"23:55:00") {
    $aumento=$horacarrerabd."+5 min";
    $horacarrerabd=(date('H:i', strtotime($aumento)));
}
$cod=0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas H�picas:.</title>
<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72">
</object>
<script language="vbscript">
<!--
function doPrint()
	document.all.item("noprint").style.display="none"
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
end function
//-->
</script>
</head>
<html>
<body onload="javascript:document.all.cmdPrint.focus();">
<?php
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta']==fechaactualbd() && $totalRows_Recordset1>0) {
    $serial=$row_Recordset1['ser_venta'];
    $estadoCodBarra=$row_Recordset1['cod_barra'];
    $rest = substr($serial, 0, 2);
    $rest = $rest.$xTicket_Recordset1;
    echo '<div id="printtitle" align="left" style="margin: 0px">'; ?>
        <table width="225" border="0" align="left">
          <tr align="center">
            <th colspan="4" class="imprimir" scope="col"><?php echo $row_Recordset1['nom_taquilla']; ?></th>
          </tr>
          <tr align="center">
            <th colspan="4" class="imprimir" scope="col">-ORIGINAL-</th>
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
            <td colspan="4" align="center" class="imprimir">
            	Vendedor: <?php echo $row_Recordset1['nom_usuario']; ?> 
                #:<?php echo $row_Recordset1['can_ticket']; ?>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera']; ?>
            </td>
          </tr>
          <tr class="imprimir">
            <td width="163" align="center">EJEMPLAR</td>
            <td colspan="2" align="center">APUESTA</td>
            <td width="171" align="center">MONTO</td>
          </tr>
          
          <?php
          $montoapagar=0;
    $ip=$row_Recordset1['ip_venta'];
    do { ?>
          <tr  class="apuestajugada">
            <td align="center">
                <?php echo $row_Recordset1['num_caballo']; ?>
               
            <td colspan="2" align="center"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?></td>
            <td align="right">
				<?php
                    $ley="";
                    if ($row_Recordset1['cod_tventa']>=7 && $row_Recordset1['cod_tventa']<=9) {
                        if ($row_Recordset1['cod_tventa']==7) {
                            $fact=2;
                        }
                        if ($row_Recordset1['cod_tventa']==8) {
                            $fact=6;
                        }
                        if ($row_Recordset1['cod_tventa']==9) {
                            $fact=24;
                        }
                        $montoVenta=$row_Recordset1['mon_venta']/$fact;
                        $ley="c/u";
                    } else {
                        $montoVenta=$row_Recordset1['mon_venta'];
                    }
                    echo $ley.number_format($montoVenta, 2, ",", ".");
                ?>
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right"><p><strong><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></strong></p></td>
          </tr>
          <tr>
            <td colspan="4" align="center">-ORIGINAL-<tr>
            <td colspan="4" align="center">
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$xTicket_Recordset1;
                    echo "<img src='../includes/barcode2.php?s=code128&wq=4&d=".$rest."'>";
                } ?>          
            <td height="10" colspan="4" align="center">&nbsp;
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>

                <td colspan="4" align="center">.          
              <tr>
		  <?php } ?>	          
     </table>
    <?php
    $cod=1;
    echo "</div>"; ?>
	<div id="noprint" align="center">
		<div align="left">
			<br>.<br><br>
			<script language="JavaScript">
				doprint();
				
				
				<?php
                if ($_GET["xIndex"]==1) {?>
					setTimeout("window.location='index_ventas.php?rID=<?php echo $cod ?>'",10);
				<?php } else {?>
					setTimeout("window.location='index.php?rID=<?php echo $cod ?>'",10);
				<?php } ?>	          
			</script>
	    </div>
    </div>
<?php
} else {
                    $cod=2;
                    echo "<p><h1>No se produjo ning�n resultado</h1></p>";
                    echo '<p><a href="index.php?rID=<?php echo $cod ?>">Volver a taquilla</a></p>';
                } ?>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
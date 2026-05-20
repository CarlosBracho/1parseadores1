<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
?>
<script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#FC0" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#A0A0A0" }
</script>
<?php
$fechasistema=fechaactualbd();
$horasistema=horaactual();
$query_Recordset5 = sprintf(
    "/* PARSEADORES1 new\includes\infoTicket.php - QUERY 1 */ SELECT ticket, hor_venta FROM venta 
USE INDEX(id_us_fe_fe)
WHERE 
venta.lin_ticket = 1 AND venta.est_ticket=1 AND venta.fec_venta = %s AND venta.id_usuario = %s 
ORDER BY venta.num_ticket DESC LIMIT 5",
    GetSQLValueString($fechasistema, "date"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
?>
                  <table style="width:100%">
                      <tr bgcolor="#FFFFFF" style="font-size:12px; color: #000000;">
                        <td width="36%" height="12" align="center">ÚLTIMOS TICKETS</br> CREADOS </td>
                        <td width="27%" align="center">APUESTA</td>
                        <td width="37%" align="center">TIEMPO DESDE SU</br> CREACIÓN</td>
                      </tr>
                      <?php
                      if ($totalRows_Recordset5>0) {
                          do { ?>
							  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" style="font-size:12px; color: #000000;">
								<td align="right"><?php echo $row_Recordset5['ticket']; ?></td>
								<td align="right"><?php echo ObtenerMonTototalVenta($row_Recordset5['ticket'])." "; ?></td>
								<td align="right">
									<?php echo horaCreacionTicket($row_Recordset5['hor_venta'], $horasistema) ?>
                                </td>
							  </tr>
						  <?php
                          } while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));
                      } else {?>
							  <tr style="font-size:12px; color: #000000;">
								<td colspan="3" align="right">Aún no existen ticket</td>
							  </tr>
						  <?php
                          }
                      ?>                        
                  </table>
<?php
mysqli_free_result($Recordset5);
?>
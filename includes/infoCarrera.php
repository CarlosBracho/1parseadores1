<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
?>
<script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#FC0" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#A0A0A0" }
</script>
<?php
$fechasistema=fechaactualbd();
$horasistema=horaactual();
$query_Recordset6 = sprintf("/* PARSEADORES1 includes\infoCarrera.php - QUERY 1 */ SELECT nom_hipodromo, hor_carrera, num_carrera, eje_primero, eje_segundo, eje_tercero, eje_cuarto
 FROM carrera USE INDEX(fec_carrera) WHERE eje_primero>0 AND eje_segundo>0 AND eje_tercero AND fec_carrera = %s ORDER BY hor_carrera DESC LIMIT 5", GetSQLValueString($fechasistema, "date"));
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);
?>
                    <table style="width:100%" class="redondos">
                       <tr bgcolor="#FFFFFF" style="font-size:10px">
                         <td width="37%" height="12" align="center">ÚLTIMAS CARRERAS CONFIRMADAS </td>
                         <td width="32%" align="center"> TIEMPO DESDE CONFIRMACIÓN</td>
                         <td width="31%" align="center">ORDEN DE LLEGADA</td>
                       </tr>
                        <?php
                        if ($totalRows_Recordset6>0) {
                            do { ?>
                           <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
                             <td align="left">
							 	<?php echo $row_Recordset6['nom_hipodromo']." Carrera#:".$row_Recordset6['num_carrera']; ?>
                             </td>
                             <td align="left">
							 	<?php echo horaCreacionTicket($row_Recordset6['hor_carrera'], $horasistema) ?>
                             </td>
                             <td align="left">
                             	<?php
                                if ($row_Recordset6['eje_primero']==99) {
                                    echo "<font color=\"red\">CARRERA CANCELADA</font>";
                                } else {
                                    echo "1)".$row_Recordset6['eje_primero']."-";
                                    echo "2)".$row_Recordset6['eje_segundo']."-";
                                    echo "3)".$row_Recordset6['eje_tercero']."-";
                                    echo "4)".$row_Recordset6['eje_cuarto'];
                                }
                                ?>
                             </td>
                           </tr>
                       <?php
                       } while ($row_Recordset6 = mysqli_fetch_assoc($Recordset6));
                        } else {?>
						   <tr>
							<td colspan="3" align="left">Aún no hay carreras confirmadas</td>
						   </tr>
                       <?php
                       }
                      ?>       
                    </table>
<?php
mysqli_free_result($Recordset6);
?>
        <table width="225" border="0" align="left">
 <tr>
            <td colspan="4" align="center" class="imprimir">-NACIONALES-</td>
          </tr>
          <tr align="center">
            <th colspan="4" class="imprimir" scope="col"><?php echo $row_Recordset1['nom_taquilla']; ?></th>
          </tr>
          <tr align="center">
            <th colspan="4" class="imprimir" scope="col">-ORIGINAL2-</th>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Hora: <?php echo horaampm($row_Recordset1['hor_venta_hnac']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket_hnac">Ticket: <?php echo $row_Recordset1['ticket_hnac']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket_hnac">Cod: <?php echo $rest; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">
            	Vend: <?php echo $row_Recordset1['nom_completo']; ?> 
                #:<?php echo $row_Recordset1['can_ticket_hnac']; ?>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo_hnac']." Carr..".$row_Recordset1['num_carrera_hnac']; ?>
            </td>
          </tr>
          <tr class="imprimir">
            <td width="163" align="center">EJEMPLAR</td>
            <td colspan="2" align="center">APUESTA</td>
            <td width="171" align="center">MONTO</td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta_hnac'];
          do { ?>
          <tr  class="apuestajugada">
            <td align="center">
                <?php echo $row_Recordset1['num_caballo_hnac']; ?>
               
            <td colspan="2" align="center"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa_hnac']); ?></td>
            <td align="right">
				<?php
                    $ley="";
                    if ($row_Recordset1['cod_tventa_hnac']>=7 && $row_Recordset1['cod_tventa_hnac']<=9) {
                        if ($row_Recordset1['cod_tventa_hnac']==7) {
                            $fact=2;
                        }
                        if ($row_Recordset1['cod_tventa_hnac']==8) {
                            $fact=6;
                        }
                        if ($row_Recordset1['cod_tventa_hnac']==9) {
                            $fact=24;
                        }
                        $montoVenta=$row_Recordset1['mon_venta_hnac']/$fact;
                        $ley="c/u";
                    } else {
                        $montoVenta=$row_Recordset1['mon_venta_hnac'];
                    }
                    echo $ley.number_format($montoVenta, 2, ",", ".");
                ?>
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta_hnac']; ?>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
          <tr>
            <td class="imprimirnroticket_hnac" height="8" colspan="4" align="center"><strong><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></strong></td>
          </tr>
          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="center"><?php echo "Caduca a los ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <tr>
            <td colspan="4" align="center">
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$xTicket_Recordset1;
                    echo "<img src='../includes/generadorBarra.php?codigo=".$rest."'>";
                }?>     
<?php if ($estadoCodBarra==1) {
                    echo "$rest";
                }?>     
          <?php for ($i = 0; $i < $largo; ++$i) {?><br/><?php } ?>     
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
		  <?php }?>	          
     </table>

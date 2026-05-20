          <tr align="center">
            <th colspan="4" class="imprimir" scope="col"><?php echo $row_Recordset1['nom_taquilla']; ?>-ORIG3-#:<?php echo $row_Recordset1['can_ticket_hnac']; ?>
</th>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimir"><?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?>-<?php
$hora1=$row_Recordset1['hor_venta_hnac'];
$nuevahora1 = strtotime('+6 hour', strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimirnroticket_hnac">Cod: <?php echo $rest; ?></td>
          </tr>
          <br/><tr>
          <td colspan="4" align="center" class="imprimirnroticket_hnac">N* Ticket: <?php echo $xTicket_Recordset1; ?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="left" class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo_hnac']." #:.".$row_Recordset1['num_carrera_hnac']; ?>
            </td>
          </tr>          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta_hnac'];
          do { ?>
          <br/><tr  class="apuestajugada">
            <td align="center">
                <?php echo $row_Recordset1['num_caballo_hnac']; ?> . . </td>
               
            <td colspan="2" align="center"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa_hnac']); ?> . . </td>
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
						<?php
if ($row_Recordset1['efectivoOn']==1) {
                    echo '<br/>DEBITO BSS';
                }
if ($row_Recordset1['efectivoOn']==2) {
    echo '<br/>TRANSFERENCIA BSS';
}
if ($row_Recordset1['efectivoOn']==3) {
    echo '<br/>DOLAR AMERICANO';
}
if ($row_Recordset1['efectivoOn']==4) {
    echo '<br/>PESO COLOMBIANO';
}
if ($row_Recordset1['efectivoOn']==5) {
    echo '<br/>SOL PERUANO';
}
 ?>
          </tr>

          <br/><tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="center"><strong>
              <?php if($row_Recordset1['efectivoOn']==1){ echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); 
              }
              if($row_Recordset1['efectivoOn']==2){ echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); 
              }
              if($row_Recordset1['efectivoOn']==3){ echo "Total: USD:".number_format($montoapagar, 2, ",", "."); 
              }
              if($row_Recordset1['efectivoOn']==4){ echo "Total: COP:".number_format($montoapagar, 2, ",", "."); 
              }
              if($row_Recordset1['efectivoOn']==5){ echo "Total: SOL:".number_format($montoapagar, 2, ",", "."); 
              }
              ?>
            </strong></td>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
  
          <?php if ($tic_caduca>0) { ?>
          <br/><tr>
            <td colspan="4" align="center"><?php echo "Caduca a los ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <br/><tr>
            <td colspan="4" align="center">
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 2);
                    $rest = $xTicket_Recordset1;
                    echo "<img src='../includes/generadorBarra.php?codigo=".$rest."'>";
                }?>
	        </td>
          </tr>


          <br/><tr>
            <td colspan="4" align="center">
<?php if ($estadoCodBarra==1) {
                    echo "$rest";
                }?>     
          <?php for ($i = 0; $i < $largo; ++$i) {?><br/><?php } ?>     
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
		  <?php }?>	          

<?php
if (!isset($_SESSION)) {
    session_start();
}?>         <tr align="center">
            <th colspan="4" class="imprimir" scope="col"><?php echo $row_Recordset1['nom_taquilla']; ?></th>
          </tr>
          <br/><tr align="center">
            <th colspan="4" class="imprimir" scope="col">-ORIGINAL2-</th>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta']); ?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimir">Hora: <?php
$hora1=$row_Recordset1['hor_venta'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket']; ?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimirnroticket">Cod: <?php echo $rest; ?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimir">
            	Vend: <?php echo $row_Recordset1['nom_completo']; ?> 
                #:<?php echo $row_Recordset1['can_ticket']; ?>
            </td>
          </tr>
          <br/><tr>
            <td colspan="4" align="left" class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo']." Carr..".$row_Recordset1['num_carrera']; ?>
            </td>
          </tr>
          <br/><tr class="imprimir">
            <td width="163" align="center">EJEM</td>
            <td colspan="2" align="center">APUE</td>
            <td width="171" align="center">MONT</td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta'];
          do { ?>
          <br/><tr  class="apuestajugada">
            <td align="center">
                <?php echo $row_Recordset1['num_caballo']; ?> . . </td>
               
            <td colspan="2" align="center"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?> . . </td>
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
                ?> . . 
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?>
<?php
if ($row_Recordset1['efectivoO']==1) {
                    echo '<br/>DEBITO BSS';
                }
if ($row_Recordset1['efectivoO']==2) {
    echo '<br/>TRANSFERENCIA BSS';
}
if ($row_Recordset1['efectivoO']==3) {
    echo '<br/>DOLAR AMERICANO';
}
if ($row_Recordset1['efectivoO']==4) {
    echo '<br/>PESO COLOMBIANO';
}
if ($row_Recordset1['efectivoO']==5) {
    echo '<br/>SOL PERUANO';
}
 ?>

          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
          <br/><tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="center"><strong><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></strong></td>
          </tr>
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
                    $rest = $rest.$xTicket_Recordset1;
                    echo "<img src='../includes/generadorBarra.php?codigo=".$rest."'>";
                }?>     
<br/><?php if ($estadoCodBarra==1) {
                    echo "$rest";
                }?>     
          <?php for ($i = 0; $i < $largo; ++$i) {?><br/><?php } ?>     
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
		  <?php }?>.	         
<?php
if (!isset($_SESSION)) {
    session_start();
}?>
 <tr>
            <td colspan="4" align="center" class="imprimir"><?php echo $row_Recordset1['nom_taquilla']; ?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimir">-COPIA2-</td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimir">Hora: <?php
$hora1=$row_Recordset1['hor_venta_hnac'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimirnroticket_hnac">Ticket: <?php echo $row_Recordset1['ticket_hnac']; ?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimirnroticket_hnac">Cod: <?php echo $rest; ?></td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="imprimir">
            	Vend: <?php echo $row_Recordset1['nom_completo']; ?> 
                #:<?php echo $row_Recordset1['can_ticket_hnac']; ?>
            </td>
          </tr>
          <br/><tr>
            <td colspan="4" align="center" class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo_hnac']." Carr...".$row_Recordset1['num_carrera_hnac']; ?>
            </td>
          </tr>
          <br/><tr class="imprimir">
            <td width="163" align="center">EJEMP</td>
            <td colspan="2" align="center">APUE</td>
            <td width="171" align="center">MONT</td>
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
                ?> . . 
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta_hnac']; ?>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
            <br/><td class="imprimirnroticket_hnac" height="8" colspan="4" align="right"><span class="imprimir"><strong><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></strong></span></td>
          </tr>
          <?php if ($tic_caduca>0) { ?>
          <br/><tr>
            <td colspan="4" align="center"><?php echo "Caduca a los ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <br/><tr>
            <td colspan="4" align="center">
				<span class="imprimir">
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
                </span>
            </td>
          </tr>      
        </tr>
<br/><tr>
            <td height="10" colspan="4" align="left">
            <DIV id="noprint" align="center" style="float:left; width: auto;">
                <DIV align="center">
                    <form name="form1">
                    <input style="FONT-STYLE: normal; FONT-FAMILY: 'MS Sans Serif'; FONT-SIZE: 15px; FONT-WEIGHT: normal" id="cmdPrint" class="boton"  <?php if ($navegador['browser']=="IE") {
                    echo 'onclick="doprint1()"';
                } else {
                    echo 'onclick="doprint2()"';
                } ?> name="cmdPrint" value="Imprimir" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <A onclick=window.close() href="#"><FONT color=#1b007f><SPAN style="FONT-SIZE: 16pt"><B>Cerrar</B></SPAN></FONT></A>
	                 </form>
                </DIV>
            </DIV>
            
            </td>
          </tr>

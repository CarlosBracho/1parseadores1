<?php
if (!isset($_SESSION)) {
    session_start();
}?>-NACIONALES-
<br/><?php echo $row_Recordset1['nom_taquilla']; ?>-COP1-#:<?php echo $row_Recordset1['can_ticket_hnac']; ?>
<br/><?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?>-<?php
$hora1=$row_Recordset1['hor_venta_hnac'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?>
<br/>Cod: <?php echo $rest; ?>
<br/><?php echo "  ".$row_Recordset1['nom_hipodromo_hnac']." #:".$row_Recordset1['num_carrera_hnac']; ?>
 <br/>         <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta_hnac'];
          do { ?>
                          <?php echo $row_Recordset1['num_caballo_hnac']; ?> . . 
               
            <?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa_hnac']); ?> . . 
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
                        <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta_hnac']; ?><br/>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
<strong><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></strong>
<br/>          <?php if ($tic_caduca>0) { ?>
         <?php echo "Caduca a los ".$tic_caduca." dias";?>
          <?php }?><br/>
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
<tr>
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
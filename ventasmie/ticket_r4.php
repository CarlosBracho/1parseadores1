<?php
if (!isset($_SESSION)) {
    session_start();
}?><?php //echo $row_Recordset1['nom_taquilla']; ?>-COP1-#:<?php echo $row_Recordset1['can_ticket']; ?>
<br/>Ticket: <?php echo $row_Recordset1['ticket']; ?>
<br/>Cod: <?php echo $rest; ?>
<br/><?php echo "  ".$row_Recordset1['nom_hipodromo']." #:".$row_Recordset1['num_carrera']; ?>
 <br/>         <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta'];
          do { ?>
                          <?php echo $row_Recordset1['num_caballo']; ?> . . 
               
            <?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?> . . 
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
                        <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?><br/>
<?php
if ($row_Recordset1['efectivoO']==1) {
                    echo 'DEBITO BSS<br/>';
                }
if ($row_Recordset1['efectivoO']==2) {
    echo 'TRANSFERENCIA BSS<br/>';
}
if ($row_Recordset1['efectivoO']==3) {
    echo 'DOLAR AMERICANO<br/>';
}
if ($row_Recordset1['efectivoO']==4) {
    echo 'PESO COLOMBIANO<br/>';
}
if ($row_Recordset1['efectivoO']==5) {
    echo 'SOL PERUANO<br/>';
}
 ?>

<strong><?php if($row_Recordset1['efectivoO']==1){ echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); 
              }
              if($row_Recordset1['efectivoO']==2){ echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); 
              }
              if($row_Recordset1['efectivoO']==3){ echo "Total: USD:".number_format($montoapagar, 2, ",", "."); 
              }
              if($row_Recordset1['efectivoO']==4){ echo "Total: COP:".number_format($montoapagar, 2, ",", "."); 
              }
              if($row_Recordset1['efectivoO']==5){ echo "Total: SOL:".number_format($montoapagar, 2, ",", "."); 
              }
              ?>
              </strong>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
<br/>          <?php if ($tic_caduca>0) { ?>
         <?php echo "Caduca a los ".$tic_caduca." dias";?>
          <?php }?><br/>
          				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 3);
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

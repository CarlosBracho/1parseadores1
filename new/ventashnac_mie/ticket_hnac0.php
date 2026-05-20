<?php
if (!isset($_SESSION)) {
    session_start();
}?>-NACIONALES-
<br/><?php echo $row_Recordset1['nom_taquilla']; ?>
<br/>-ORIGINAL0-
<br/>Fecha: <?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?>
<br/>Hora: <?php
$hora1=$row_Recordset1['hor_venta_hnac'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?>
<br/>Cod: <?php echo $rest; ?>
<br/>Vend: <?php echo $row_Recordset1['nom_completo']; ?> 
#:<?php echo $row_Recordset1['can_ticket_hnac']; ?>
<br/><?php echo "  ".$row_Recordset1['nom_hipodromo_hnac']." #:".$row_Recordset1['num_carrera_hnac']; ?>
<br/>EJEMP-APUE-MONT
<br/>           <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta_hnac'];
          do { ?>
                <?php echo $row_Recordset1['num_caballo_hnac']; ?> . . 
               
 <?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa_hnac']); ?> . . 
				<?php
                    $ley=" ";
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
			<?php
if ($row_Recordset1['efectivoOn']==1) {
                    echo 'DEBITO BSS<br/>';
                }
if ($row_Recordset1['efectivoOn']==2) {
    echo 'TRANSFERENCIA BSS<br/>';
}
if ($row_Recordset1['efectivoOn']==3) {
    echo 'DOLAR AMERICANO<br/>';
}
if ($row_Recordset1['efectivoOn']==4) {
    echo 'PESO COLOMBIANO<br/>';
}
if ($row_Recordset1['efectivoOn']==5) {
    echo 'SOL PERUANO<br/>';
}
 ?>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
<strong><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></strong>
<br/>          <?php if ($tic_caduca>0) { ?>
          <?php echo "Caduca a los ".$tic_caduca." dias";?>
          <?php }?>
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$xTicket_Recordset1;
                    echo "<img src='../includes/generadorBarra.php?codigo=".$rest."'>";
                }?>          
	             <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
              		  <?php }?>
<br/><?php if ($estadoCodBarra==1) {
              echo "$rest";
          }?>     
          <?php for ($i = 0; $i < $largo; ++$i) {?><br/><?php } ?>
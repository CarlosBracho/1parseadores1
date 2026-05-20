<?php
if (!isset($_SESSION)) {
    session_start();
}?><?php echo $row_Recordset1['nom_taquilla']; ?>
<br/>-ORIGINAL0-
<br/>Fecha: <?php echo fechanueva($row_Recordset1['fec_venta']); ?>
<br/>Hora: 
<?php
$hora1=$row_Recordset1['hor_venta'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?>
<br/>Ticket: <?php echo $row_Recordset1['ticket']; ?>
<br/>Cod: <?php echo $rest; ?>
<br/>Vend: <?php echo $row_Recordset1['nom_completo']; ?> 
#:<?php echo $row_Recordset1['can_ticket']; ?>
<br/><?php echo "  ".$row_Recordset1['nom_hipodromo']." #:".$row_Recordset1['num_carrera']; ?>
<br/>EJEMP-APUE-MONT
<br/>           <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta'];
          do { ?>
                <?php echo $row_Recordset1['num_caballo']; ?> . . 
               
 <?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?> . . 
				<?php
                    $ley=" ";
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
          <?php }?>
<br/> 
				<?php
                if ($estadoCodBarra==1) {
                    $rest = substr($serial, 0, 3);
                    echo "<img src='../includes/generadorBarra.php?codigo=".$rest."'>";
                }?>
<br/><?php if ($estadoCodBarra==1) {
                    echo "$rest";
                }?>               
	             <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
              		  <?php }?>
          <?php for ($i = 0; $i < $largo; ++$i) {?><br/><?php } ?>.
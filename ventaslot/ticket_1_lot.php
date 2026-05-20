<?php
if (!isset($_SESSION)) {
    session_start();
}?><?php echo $row_Recordset1['nom_taquilla'];?>
<br/>-ORIGINAL0-
<br/>Fecha: <?php echo fechanueva($row_Recordset1['fec_venta_lot']);?>
<?php $hora1=$row_Recordset1['hor_venta_lot'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);?>
<br/>Hora: <?php echo horaampm($nuevahora1);?>
<br/>Cod: <?php echo $rest;?>
<br/>Vend: <?php echo $row_Recordset1['nom_completo'];?> 
<br/>#: <?php echo $row_Recordset1['can_ticket_lot'];?>
<br/>


<?php
        $ip=$row_Recordset1['ip_venta_lot'];
        do {
            $codigoRegistro=$row_Recordset1['id_loteria'];
            if ($row_Recordset1['tip_loteria_lot']==2) {
                $terTriple=ObtenerTripledeTerminal($row_Recordset1['id_loteria']);
                if ($terTriple==$row_Recordset1['id_loteria']);
                {
                    $codigoRegistro=$terTriple;
                }
            }
            if ($row_Recordset1['tip_loteria_lot']==1 or ($row_Recordset1['tip_loteria_lot']==2 && $row_Recordset1['id_signo']==0)) {
                $maxCol=3;
            } else {
                $maxCol=2;
            }
            if ($cod!=$codigoRegistro) {
                //if ($columnas==$maxCol) {
                if ($columnas==2) {
                    print('--------&nbsp;--------<br/>');
                }
                if ($columnas==3) {
                    print('--------<br/>');
                }
                //} ?>




				<strong>-<?php echo $row_Recordset1['nom_loteria']; ?> </strong><br/>



				&nbsp;Nro&nbsp;


&nbsp;Bs&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;Nro&nbsp;
&nbsp;Bs&nbsp;

<?php

                if ($maxCol==3) {?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nro&nbsp;
&nbsp;Bs&nbsp;


				<?php } ?>


<br/>


<?php
                $cod=$codigoRegistro;
                $filas=0;
                $columnas=1;
            }
            if ($filas==0) {
                $filas=1;
            } ?>



				<?php echo $row_Recordset1['num_apuesta_lot']; ?>
				<?php echo $row_Recordset1['nsigno']; ?>
				x<?php echo number_format($row_Recordset1['mon_apuesta_lot'], 2, ",", ".")." "; ?>
&nbsp;

<?php

                $columnas++ ;
            if ($columnas==($maxCol+1)) {
                $filas=0;
                $columnas=1; ?>
<br/>
<?php
            }
            $montoapagar=$montoapagar+$row_Recordset1['mon_apuesta_lot'];
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));





        if ($columnas==2) {
            ;
        }?>

--------&nbsp;--------<br/>
<?php
        if ($columnas==3) {
            ;
        } ?>

--------<br/>

------------------------- <br/>

<strong>Total: <?php echo number_format($montoapagar, 2, ",", ".");?> </strong><br/>

<?php		if ($tic_caduca>0) {?>

 
Caduca a los <?php echo $tic_caduca;?> dias<br/>


<?php

        }
        if ($estadoCodBarra==1) {
            $rest = substr($serial, 0, 2);
            $rest = $rest.$xTicket_Recordset1;


            echo "<img src='../includes/generadorBarra.php?codigo=".$rest."'>"; ?>
<br/>


	<?php
        }
        if ($estadoCodBarra==1) {
            echo $rest."<br/>";
        }
        for ($i = 0; $i < $largo; ++$i) {
            echo "<br/>";
        }
?>
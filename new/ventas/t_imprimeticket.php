<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
?>
<style type="text/css" media="print">
#Imprime {
	height: auto;
	width: 0px;
	margin: 0px;
	padding: 0px;
	float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 7px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	color: #000;
}
@page{
   margin: 0;
}
</style>
<?php
$xTicket_Recordset1 = "0";
if (isset($_POST["iD"])) {
    $xTicket_Recordset1 = $_POST["iD"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventas\t_imprimeticket.php - QUERY 1 */ SELECT 
venta.fec_venta, 
venta.hor_venta,
venta.ser_venta,
venta.can_ticket,
venta.num_caballo,
venta.ip_venta,
venta.ticket,
venta.cod_tventa,
venta.mon_venta,
venta.efectivoO,
usuario.nom_usuario,
usuario.cod_barra,
taquilla.cod_taquilla,
taquilla.nom_taquilla,
taquilla.especialfuncion1,
carrera.nom_hipodromo,
carrera.num_carrera,
carrera.hor_carrera,
taquilla_opc_ame.tic_caduca,
taquilla_opc_ame.lar_ticket,
taquilla_opc_ame.tip_ticket,
taquilla_opc_ame.tam_ticket
FROM 
venta,
carrera,
usuario,
taquilla,
taquilla_opc_ame 
WHERE 
venta.ticket = %s AND
venta.id_usuario = %s AND
carrera.cod_carrera = venta.cod_carrera AND
usuario.id_usuario = venta.id_usuario AND
taquilla.cod_taquilla = usuario.cod_taquilla AND
taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla
ORDER BY venta.cod_tventa",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$horacarrerabd=$row_Recordset1['hor_carrera'];
$largo=$row_Recordset1['lar_ticket']+1;
$tamletras=$row_Recordset1['tam_ticket'];
$moneda=$row_Recordset1['efectivoO'];
$cod_taquilla=$row_Recordset1['cod_taquilla'];
if ($horacarrerabd<"23:55:00") {
    $aumento=$horacarrerabd."+5 min";
    $horacarrerabd=(date('H:i', strtotime($aumento)));
}
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta']==fechaactualbd() && $totalRows_Recordset1>0) {
    $serial=$row_Recordset1['ser_venta'];
    $estadoCodBarra=$row_Recordset1['cod_barra'];
    $especialfuncion1=$row_Recordset1['especialfuncion1'];
    $rest = substr($serial, 0, 3);
    $tic_caduca=$row_Recordset1['tic_caduca'];
    echo "<div id='resultado2' style='line-height: 0.5em;'>"; ?>



<?php if ($row_Recordset1['tip_ticket']==0) { //00000?>

<font size="<?php echo $tamletras; ?>" face="Arial" >
        <table width="225" border="0" align="left">
          <tr>
            <th colspan="4" class="imprimir" scope="col"><?php echo $row_Recordset1['nom_taquilla']; ?></th>
          </tr>
          <tr>
            <th colspan="4" class="imprimir" scope="col">-ORIGINAL0-</th>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Hora: <?php
$hora1=$row_Recordset1['hor_venta'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Cod: <?php echo $rest; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">
            	Vendedor: <?php echo $row_Recordset1['nom_usuario']; ?> 
                #:<?php echo $row_Recordset1['can_ticket']; ?>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera']; ?>
            </td>
          </tr>
          <tr class="imprimir">
            <td width="163" align="center">EJEMPLAR</td>
            <td colspan="2" align="center">APUESTA</td>
            <td width="171" align="center">MONTO</td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta'];
          do { ?>
          <tr  class="apuestajugada">
            <td align="center">
                <?php echo $row_Recordset1['num_caballo']; ?>
               
            <td colspan="2" align="center"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?></td>
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
                ?>
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?>


          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right"><p><strong><?php
if ($moneda<=2) {
                    echo "Total Bss:.".number_format($montoapagar, 2, ",", ".");
                }
if ($moneda==3) {
    echo "Total Usd:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==4) {
    echo "Total Cop:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==5) {
    echo "Total Sol:.".number_format($montoapagar, 2, ",", ".");
}
             ?></strong></p>


</td>
          </tr>

          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="center"><?php echo "Ticket caduca a los ".$tic_caduca." dias";?></td>
            </tr>
          <?php }?>
          <tr><td colspan="4" align="center">-ORIGINAL0-</td></tr>
          <tr>
            <td colspan="4" align="center">
				<?php
            if ($estadoCodBarra==1) {
                $rest = substr($serial, 0, 2);
                $rest = $rest.$xTicket_Recordset1;
                echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=0&w=110&d=".$xTicket_Recordset1."'>";
            }
            if ($estadoCodBarra==1 && $especialfuncion1==1) {
                echo '</br>';
            }
            if ($especialfuncion1==1) {
                $rest = substr($serial, 0, 2);
                $rest = $rest.$xTicket_Recordset1;
                echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=30&w=300&d=".$xTicket_Recordset1.'+'.$montoVenta.'+'.$cod_taquilla."'>";
            }
                    
                    ?>        
	        </td>
          </tr>
          <tr>
            <td height="10" colspan="4" align="left">IP: <?php echo $ip; ?>  
            <tr>
            <td height="10" colspan="4" align="center">&nbsp;
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">.          
              <tr>
		  <?php }?>	          
     </table></font>
	 
	 <?php } //00000?> 
	 
	 <?php if ($row_Recordset1['tip_ticket']==1) { //11111?>
	 <font size="<?php echo $tamletras; ?>" face="Arial" >
        <table width="225" border="0" align="left">
          <tr>
            <td colspan="4" class="imprimir" scope="col" align="left"><?php echo $rest2 = substr($row_Recordset1['nom_taquilla'], 0, 5); ?>-ORIG#:<?php echo $row_Recordset1['can_ticket']; ?></td>

          </tr>
          <tr>
            <td colspan="4"  align="left" class="imprimir"><?php echo $rest3 = substr(fechanueva($row_Recordset1['fec_venta']), 0, 6);
            $hora1=$row_Recordset1['hor_venta'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?></td>
          </tr>

          <tr>
            <td colspan="4" align="left" class="imprimirnroticket">T: <?php echo $row_Recordset1['ticket']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="imprimirnroticket">Cod: <?php echo $rest; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="imprimir">
            	Ven: <?php echo $row_Recordset1['nom_usuario']; ?> 
                
            </td>
          </tr>
          <tr>
            <td colspan="4" align="left"class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo']." #".$row_Recordset1['num_carrera']; ?>
            </td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta'];
          do { ?>
          <tr  class="apuestajugada">
            <td align="left">
                <?php echo $row_Recordset1['num_caballo']; ?>
               
            <td colspan="2" align="left"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?>
            
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
                    echo number_format($montoVenta, 2, ",", ".");
                ?>
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?>
			<?php

 ?>

          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>

          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="left"><p><strong><?php
if ($moneda<=2) {
     echo "Total Bss:.".number_format($montoapagar, 2, ",", ".");
 }
if ($moneda==3) {
    echo "Total Usd:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==4) {
    echo "Total Cop:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==5) {
    echo "Total Sol:.".number_format($montoapagar, 2, ",", ".");
}
             ?></strong></p>


</td>
          </tr>

          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="left"><?php echo "Caduca a ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <tr>
            <td colspan="4" align="left">
				<?php
            if ($estadoCodBarra==1) {
                $rest = substr($serial, 0, 2);
                $rest = $rest.$xTicket_Recordset1;
                echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=0&w=110&d=".$xTicket_Recordset1."'>";
            }
            if ($estadoCodBarra==1 && $especialfuncion1==1) {
                echo '</br>';
            }
          if ($especialfuncion1==1) {
              $rest = substr($serial, 0, 2);
              $rest = $rest.$xTicket_Recordset1;
              echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=30&w=300&d=".$xTicket_Recordset1.'+'.$montoVenta.'+'.$cod_taquilla."'>";
          }
                    
                    ?>         
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
		  
                      
           
		  <?php }?>	 
		  
		  <?php for ($i = 0; $i < $largo; ++$i) {?><tr><td colspan="4" align="left">&nbsp;</td></tr><?php } ?>
   <tr><td colspan="4" align="left">.</td></tr>		  
     </table></font>
	 <?php } //11111?> 
	 
	 
	 <?php if ($row_Recordset1['tip_ticket']==2) {  //22222?>
	 
	 <font size="<?php echo $tamletras; ?>" face="Arial" >
        <table width="225" border="0" align="left">
          <tr>
            <th colspan="4" class="imprimir" scope="col"><?php echo $row_Recordset1['nom_taquilla']; ?></th>
          </tr>
          <tr>
            <th colspan="4" class="imprimir" scope="col">-ORIGINAL2-</th>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Hora: <?php
$hora1=$row_Recordset1['hor_venta'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Cod: <?php echo $rest; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">
            	Vendedor: <?php echo $row_Recordset1['nom_usuario']; ?> 
                #:<?php echo $row_Recordset1['can_ticket']; ?>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera']; ?>
            </td>
          </tr>
          <tr class="imprimir">
            <td width="163" align="center">EJEMPLAR</td>
            <td colspan="2" align="center">APUESTA</td>
            <td width="171" align="center">MONTO</td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta'];
          do { ?>
          <tr  class="apuestajugada">
            <td align="center">
                <?php echo $row_Recordset1['num_caballo']; ?>
               
            <td colspan="2" align="center"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?></td>
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
                ?>
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?>


          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right"><p><strong><?php
if ($moneda<=2) {
                    echo "Total Bss:.".number_format($montoapagar, 2, ",", ".");
                }
if ($moneda==3) {
    echo "Total Usd:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==4) {
    echo "Total Cop:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==5) {
    echo "Total Sol:.".number_format($montoapagar, 2, ",", ".");
}
             ?></strong></p>


</td>
          </tr>

          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="center"><?php echo "Ticket caduca a los ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <tr><td colspan="4" align="center">-ORIGINAL2-</td></tr>
          <tr>
            <td colspan="4" align="center">
				<?php
            if ($estadoCodBarra==1) {
                $rest = substr($serial, 0, 2);
                $rest = $rest.$xTicket_Recordset1;
                echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=0&w=110&d=".$xTicket_Recordset1."'>";
            }
            if ($estadoCodBarra==1 && $especialfuncion1==1) {
                echo '</br>';
            }
          if ($especialfuncion1==1) {
              $rest = substr($serial, 0, 2);
              $rest = $rest.$xTicket_Recordset1;
              echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=30&w=300&d=".$xTicket_Recordset1.'+'.$montoVenta.'+'.$cod_taquilla."'>";
          }
                    
                    ?>          
	        </td>
          </tr>
          <tr>
            <td height="10" colspan="4" align="left">IP: <?php echo $ip; ?>  
            <tr>
            <td height="10" colspan="4" align="center">&nbsp;
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">.          
              <tr>
		  <?php }?>	          
     </table></font>
	 <?php }  //22222?> 
	 
	 
<?php if ($row_Recordset1['tip_ticket']==3) {  //33333?>
<font size="<?php echo $tamletras; ?>" face="Arial" >
        <table width="225" border="0" align="left">
          <tr>
            <td colspan="4" class="imprimir" scope="col" align="left"><?php echo $rest2 = substr($row_Recordset1['nom_taquilla'], 0, 5); ?>-ORIG#:<?php echo $row_Recordset1['can_ticket']; ?></td>

          </tr>
          <tr>
            <td colspan="4"  align="left" class="imprimir"><?php echo $rest3 = substr(fechanueva($row_Recordset1['fec_venta']), 0, 6);
            $hora1=$row_Recordset1['hor_venta'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?></td>
          </tr>

          <tr>
            <td colspan="4" align="left" class="imprimirnroticket">T: <?php echo $row_Recordset1['ticket']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="imprimirnroticket">Cod: <?php echo $rest; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="left" class="imprimir">
            	Ven: <?php echo $row_Recordset1['nom_usuario']; ?> 
                
            </td>
          </tr>
          <tr>
            <td colspan="4" align="left"class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo']." #".$row_Recordset1['num_carrera']; ?>
            </td>
          </tr>
          
          <?php
          $montoapagar=0; $ip=$row_Recordset1['ip_venta'];
          do { ?>
          <tr  class="apuestajugada">
            <td align="left">
                <?php echo $row_Recordset1['num_caballo']; ?>
               
            <td colspan="2" align="left"><?php echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']); ?>
            
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
                    echo number_format($montoVenta, 2, ",", ".");
                ?>
            </td>
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?>
			<?php
$moneda=$row_Recordset1['efectivoO'];
 ?>

          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>

          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="left"><p><strong><?php
if ($moneda<=2) {
     echo "Total Bss:.".number_format($montoapagar, 2, ",", ".");
 }
if ($moneda==3) {
    echo "Total Usd:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==4) {
    echo "Total Cop:.".number_format($montoapagar, 2, ",", ".");
}
if ($moneda==5) {
    echo "Total Sol:.".number_format($montoapagar, 2, ",", ".");
}
             ?></strong></p>


</td>
          </tr>

          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="left"><?php echo "Caduca a ".$tic_caduca." dias";?></td>
          </tr>
          <?php }?>
          <tr>
            <td colspan="4" align="left">
				<?php
            if ($estadoCodBarra==1) {
                $rest = substr($serial, 0, 2);
                $rest = $rest.$xTicket_Recordset1;
                echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=0&w=110&d=".$xTicket_Recordset1."'>";
            }
            if ($estadoCodBarra==1 && $especialfuncion1==1) {
                echo '</br>';
            }
          if ($especialfuncion1==1) {
              $rest = substr($serial, 0, 2);
              $rest = $rest.$xTicket_Recordset1;
              echo "<img src='../includes/barcode2.php?s=code-128&wq=4&p=3&ph=30&w=300&d=".$xTicket_Recordset1.'+'.$montoVenta.'+'.$cod_taquilla."'>";
          }
                    
                    ?>        
	        </td>
          </tr>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
          if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
		  
                      
           
		  <?php }?>	 
		  
		  <?php for ($i = 0; $i < $largo; ++$i) {?><tr><td colspan="4" align="left">&nbsp;</td></tr><?php } ?>
   <tr><td colspan="4" align="left">.</td></tr>		  
     </table></font>
	 <?php }  //33333?> 
	 
	 
    <?php
    echo "</div>";
} else {
    echo "No se produjo ningún resultado";
} ?>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
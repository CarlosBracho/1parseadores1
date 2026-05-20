<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xserTic="";
$xnroTicket="";
$mensaje='';
$xserDB="";
$usuarioPago="";
$hoy=fechaactualbd();
if (isset($_POST["pagarT"])) {
    $xnroTicket = $_POST["pagarT"];
    $usuarioPago=$_POST["id_usuario"];
    $tip_usuario=$_POST["tip_usuario"];
}
if ($tip_usuario=="A") {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 includes\busca_jugada_hnac.php - QUERY 1 */ SELECT *
		FROM 
			venta_hnac,
			carrera_hnac,
			usuario,
			taquilla,
			taquilla_opc_hnac,
			hipodromo_hnac 
		WHERE 
			venta_hnac.ticket_hnac = %s AND
			carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
			carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac AND
			usuario.id_usuario = venta_hnac.id_usuario AND
			usuario.cod_taquilla = taquilla.cod_taquilla AND
			taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla
		ORDER BY venta_hnac.cod_tventa_hnac",
        GetSQLValueString($xnroTicket, "int")
    );
}
if ($tip_usuario=="U") {
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 includes\busca_jugada_hnac.php - QUERY 2 */ SELECT venta.est_ticket, venta.ser_venta, carrera.est_carrera, carrera.est_confirmacion 
			 FROM venta, carrera 
			 WHERE venta.ticket = %s AND venta.cod_carrera = carrera.cod_carrera AND venta.id_usuario = %s",
        GetSQLValueString($xnroTicket, "int"),
        GetSQLValueString($usuarioPago, "int")
    );
}
if ($tip_usuario=="G") {
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 includes\busca_jugada_hnac.php - QUERY 3 */ SELECT venta.est_ticket, venta.ser_venta, carrera.est_carrera, carrera.est_confirmacion 
			 FROM venta, carrera, usuario 
			 WHERE venta.ticket = %s AND venta.cod_carrera = carrera.cod_carrera AND
			 		venta.cod_taquilla = usuario.cod_taquilla AND 
			 		usuario.id_usuario = %s",
        GetSQLValueString($xnroTicket, "int"),
        GetSQLValueString($usuarioPago, "int")
    );
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$controlSer=1;
$ver=0;
if ($totalRows_Recordset1>0) {
    if ($xserTic==substr($row_Recordset1['ser_venta_hnac'], 0, 2)) {
        $controlSer=1;
    }
    $serVenta=$row_Recordset1['ser_venta_hnac'];
    $rest = substr($serVenta, 0, 3);
    $rest = $rest;
}
if ($totalRows_Recordset1>0 && $controlSer==1 && $row_Recordset1['est_ticket_hnac']!=0
    && $row_Recordset1['est_carrera_hnac']==0) {
    $query_Recordset3 = sprintf(
        "/* PARSEADORES1 includes\busca_jugada_hnac.php - QUERY 4 */ SELECT *
		FROM 
			resultados_hnac
		WHERE 
			cod_carrera_hnac = %s AND
			fec_resultado_hnac = %s",
        GetSQLValueString($row_Recordset1['cod_carrera_hnac'], "int"),
        GetSQLValueString($hoy, "date")
    );
    $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
    $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
    $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
    if ($totalRows_Recordset3==0) {
        $ver=1;
        $mensaje='<br/><p style="font-size:18px;color:#CC0000;">TAQUILLA NO HA CARGADO RESULTADOS!</p>';
    } else {
        $ver=1;
    }
} else {
    if ($controlSer==0 || $totalRows_Recordset1==0) {
        $mensaje='<br/><br/><br/><p style="font-size:20px;color:#CC0000;"><strong>TICKET NO ENCONTRADO!</strong></p>';
    }
    if ($row_Recordset1['est_ticket_hnac']==0 && $totalRows_Recordset1>0) {
        $mensaje='<br/><br/><br/><p style="font-size:20px;color:#CC0000;"><strong>TICKET ELIMINADO!</strong></p>';
        $ver=1;
    }
    if ($row_Recordset1['est_carrera_hnac']==1) {
        $mensaje='<p style="font-size:18px;color:#CC0000;"><strong>CARRERA NO CERRADA!</strong></p>';
        $ver=1;
    }
    //if ($row_Recordset1['est_confirmacion_hnac']==0 && $row_Recordset1['est_carrera_hnac']==0) {
            //$mensaje='<p style="font-size:18px;color:#CC0000;"><strong>CARRERA AÚN NO CONFIRMADA!</strong></p>'; $ver=1;}
}
if ($ver==1) {
    if ($row_Recordset1['est_carrera_hnac']==0 && $row_Recordset1['est_cierre_hnac']==1
        && $row_Recordset1['est_ticket_hnac']!=0 && $totalRows_Recordset3>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 includes\busca_jugada_hnac.php - QUERY 5 */ SELECT *
		FROM 
			venta_hnac,
			carrera_hnac,
			usuario,
			taquilla,
			taquilla_opc_hnac 
		WHERE 
			venta_hnac.ticket_hnac = %s AND
			carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
			usuario.id_usuario = venta_hnac.id_usuario AND
			usuario.cod_taquilla = taquilla.cod_taquilla AND
			taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla
		ORDER BY venta_hnac.cod_tventa_hnac",
            GetSQLValueString($xnroTicket, "int")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        $codigoCarrera=$row_Recordset2['cod_carrera_hnac'];
        $fecCarrera=$row_Recordset2['fec_carrera_hnac'];
        $numTicket=$row_Recordset2['num_ticket_hnac'];
        $serVenta=$row_Recordset2['ser_venta_hnac'];
        $editFormAction = $_SERVER['PHP_SELF'];
        $ipPago=getRealIP();
        $horaPago=horaactual();
        $montoapagar=0;
        $montoretiro=0;
        do {
            $pago=0;
            $aE1=0;
            $retiro=0;
            $retiro=RetiradosSimple_hnac($codigoCarrera, $row_Recordset2['num_caballo_hnac']);
            if ($retiro==0) {
                if ($row_Recordset2['est_ticket_hnac']==1 && $row_Recordset2['est_carrera_hnac']==0
                    && $row_Recordset2['est_cierre_hnac']==1) {
                    list($a1, $a2, $aE1, $t1)=
                    buscaDivTaquilla(
                        $row_Recordset2['cod_carrera_hnac'],
                        $row_Recordset2['fec_carrera_hnac'],
                        $row_Recordset2['cod_taquilla'],
                        1,
                        11
                    );
                    list($b1, $b2, $aE3, $t3)=
                    buscaDivTaquilla(
                        $row_Recordset2['cod_carrera_hnac'],
                        $row_Recordset2['fec_carrera_hnac'],
                        $row_Recordset2['cod_taquilla'],
                        1,
                        21
                    );
                    $query_Recordset21 = sprintf(
                        "/* PARSEADORES1 includes\busca_jugada_hnac.php - QUERY 6 */ SELECT resultados_hnac.div_pago_hnac, inscritos.est_favorito_hnac,
							 resultados_hnac.num_caballo_hnac, inscritos.est_inscrito_hnac
						FROM 
						resultados_hnac,
						inscritos 
						WHERE
						resultados_hnac.cod_carrera_hnac = inscritos.cod_carrera_hnac AND
						resultados_hnac.num_caballo_hnac = inscritos.num_caballo_hnac AND
						resultados_hnac.num_caballo_hnac = %s AND
						resultados_hnac.cod_carrera_hnac = %s AND
						resultados_hnac.fec_resultado_hnac = %s AND
						resultados_hnac.cod_taquilla = %s AND
						resultados_hnac.cod_tventa_hnac = %s",
                        GetSQLValueString($row_Recordset2['num_caballo_hnac'], "text"),
                        GetSQLValueString($row_Recordset2['cod_carrera_hnac'], "int"),
                        GetSQLValueString($row_Recordset2['fec_carrera_hnac'], "date"),
                        GetSQLValueString($row_Recordset2['cod_taquilla'], "int"),
                        GetSQLValueString($row_Recordset2['cod_tventa_hnac'], "int")
                    );
                    $Recordset21 = mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
                    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
                    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
                }
                if ($row_Recordset2['est_ticket_hnac']==1 && $aE1!=0 && $totalRows_Recordset21>0) {
                    if ($row_Recordset2['cod_tventa_hnac']>=1 && $row_Recordset2['cod_tventa_hnac']<=3) {
                        if ($row_Recordset2['num_caballo_hnac']==$row_Recordset21['num_caballo_hnac']) {
                            $pago=($row_Recordset21['div_pago_hnac']/10)*$row_Recordset2['mon_venta_hnac'];
                        }
                    }
                    if ($row_Recordset2['cod_tventa_hnac']>=4 && $row_Recordset2['cod_tventa_hnac']<=9) {
                    }
                    if ($pago>0) {
                        $montoapagar=$pago+$montoapagar;
                    }
                    $pago=0;
                }
                if ($row_Recordset2['est_ticket_hnac']==2) {
                    $pago=$row_Recordset2['pag_premio_hnac'];
                    if ($pago>0) {
                        $montoapagar=$pago+$montoapagar;
                    }
                    $pago=0;
                }
            } else {
                $montoretiro=$montoretiro+$row_Recordset2['mon_venta_hnac'];
            }
        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
        $montoapagar=$montoapagar+$montoretiro;
        if ($montoapagar>0) {
            $mensaje="";
            $mensaje='<font color="red"><h3><strong>TICKET GANADOR!</strong></h3></font>';
            $mensaje=$mensaje.'<h2><strong>Monto a pagar:'.number_format($montoapagar, 2, ",", ".").'</strong></h2></font>';
            if ($row_Recordset1['est_ticket_hnac']>1) {
                $mensaje=$mensaje.'<strong>YA HA SIDO CANCELADO</strong>';
            }
            if ($row_Recordset1['est_ticket_hnac']==1) {
                $mensaje=$mensaje.'<strong>AÚN NO CANCELADO</strong>';
            }
        }
        if ($montoapagar==0) {
            $mensaje='<p style="font-size:18px;color:#000000;"><strong>TICKET NO GANADOR</strong></p>';
        }
    } ?>

	<div id="printtitle" align="center" style="margin: 0 auto; background:#FFF; width:255px; padding:0px 0px 20px 0px">
        <table width="235" border="0" align="center">
          <tr>
            <td colspan="4" align="center" class="imprimir"><?php echo $row_Recordset1['nom_taquilla']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">-COPIA-</td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Fecha: <?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">Hora: <?php echo horaampm($row_Recordset1['hor_venta_hnac']); ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket_hnac']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Cod. pago: <?php echo $rest; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimir">
            	Vendedor: <?php echo $row_Recordset1['nom_usuario']; ?> 
                #:<?php echo $row_Recordset1['can_ticket_hnac']; ?>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="apuestajugada">
				<?php echo "  ".$row_Recordset1['nom_hipodromo_hnac']." Carr...".$row_Recordset1['num_carrera_hnac']; ?>
            </td>
          </tr>
          <tr class="imprimir">
            <td width="163" align="center">EJEMPLAR</td>
            <td colspan="2" align="center">APUESTA</td>
            <td width="171" align="center">MONTO</td>
          </tr>
          
          <?php
          $montoapagar=0;
    $ip=$row_Recordset1['ip_venta_hnac'];
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
            <?php
                $montoapagar = $montoapagar+$row_Recordset1['mon_venta_hnac'];
            ?>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right"><p><span class="imprimir"><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></span></p></td>
          </tr>
          <tr>
            <td colspan="4" align="center">
            </td>
          </tr>      
          <tr>
            <td height="10" colspan="4" align="left">
            	<span class="imprimir">IP: <?php echo $ip; ?></span>
            </td>    
          <tr>
              <td height="10" colspan="4" align="center"><?php echo $mensaje; ?>
        </td>
        </tr>
            </table>
	</div>
<?php
} else {
                echo $mensaje;
            }
mysqli_free_result($Recordset1);
?>
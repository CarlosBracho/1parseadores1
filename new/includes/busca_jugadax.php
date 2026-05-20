<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A";
$xserTic="";
$xnroTicket="";
$mensaje='';
$xserDB="";
$usuarioPago="";
$tip_usuario="";
echo  "numeroticketreset";

if (isset($_GET["numeroticketreset"])) {
    $xnroTicket = $_GET["numeroticketreset"];
    $usuarioPago=$_GET["id_usuario"];
    echo  $tip_usuario;
    $tip_usuario=$_GET["tip_usuario"];
} else {
    if (isset($_POST["pagarT"])) {
        $xnroTicket = $_POST["pagarT"];
        $usuarioPago=$_POST["id_usuario"];
        $tip_usuario=$_POST["tip_usuario"];
    }
}
if ($tip_usuario=="A") {
    $MM_authorizedUsers = "A";
} elseif ($tip_usuario=="G") {
    $MM_authorizedUsers = "G";
} elseif ($tip_usuario=="U") {
    $MM_authorizedUsers = "U";
} elseif ($tip_usuario=="D") {
    $MM_authorizedUsers = "D";
}
$MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if ($tip_usuario=="A") {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\busca_jugadax.php - QUERY 1 */ SELECT *
		FROM 
			venta,
			carrera,
			usuario,
			taquilla,
			taquilla_opc_ame 
		WHERE 
			venta.ticket = %s AND
			carrera.cod_carrera = venta.cod_carrera AND
			usuario.id_usuario = venta.id_usuario AND
			usuario.cod_taquilla = taquilla.cod_taquilla AND
			taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla
		ORDER BY venta.cod_tventa",
        GetSQLValueString($xnroTicket, "int")
    );
}
if ($tip_usuario=="U") {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\busca_jugadax.php - QUERY 2 */ SELECT venta.est_ticket, venta.ser_venta, venta.fec_venta, venta.hor_venta,
			carrera.est_carrera, carrera.est_confirmacion 
			 FROM venta, carrera 
			 WHERE venta.ticket = %s AND venta.cod_carrera = carrera.cod_carrera AND venta.id_usuario = %s",
        GetSQLValueString($xnroTicket, "int"),
        GetSQLValueString($usuarioPago, "int")
    );
}
if ($tip_usuario=="G") {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\busca_jugadax.php - QUERY 3 */ SELECT 
			ve.est_ticket, 
			ve.ser_venta, 
			ve.fec_venta, 
			ve.hor_venta,
			ve.num_caballo,
			ve.cod_tventa,
			ve.mon_venta,
			ve.can_ticket,
			ve.ip_venta,
			tp.tie_reclamo,
			ta.nom_taquilla,
			ve.fec_venta,
			ve.hor_venta,
			ve.ticket,
			us.nom_usuario,
			ca.est_carrera,
			ca.nom_hipodromo,
			ca.num_carrera, 
			ca.est_confirmacion 
			 FROM 
				agencia ag,
				usuario us,
				taquilla ta,
				taquilla_opc_ame tp,
				venta ve,
				carrera ca
			WHERE	
				ta.cod_agencia = ag.cod_agencia AND
				tp.cod_taquilla = ta.cod_taquilla AND
				us.cod_taquilla = ta.cod_taquilla AND
				ve.id_usuario = us.id_usuario AND
				ca.cod_carrera = ve.cod_carrera AND
				ve.ticket = %s AND
				ag.cod_agencia = %s
			ORDER BY ve.cod_tventa",
        GetSQLValueString($xnroTicket, "int"),
        GetSQLValueString($_POST["cod_agencia"], "int")
    );
}
if ($tip_usuario=="D") {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\busca_jugadax.php - QUERY 4 */ SELECT 
			ve.est_ticket, 
			ve.ser_venta, 
			ve.fec_venta, 
			ve.hor_venta,
			ve.num_caballo,
			ve.cod_tventa,
			ve.mon_venta,
			ve.can_ticket,
			ve.ip_venta,
			tp.tie_reclamo,
			ta.nom_taquilla,
			ve.fec_venta,
			ve.hor_venta,
			ve.ticket,
			us.nom_usuario,
			ca.est_carrera,
			ca.nom_hipodromo,
			ca.num_carrera, 
			ca.est_confirmacion 
	
			FROM
				banca ba, 
				agencia ag,
				usuario us,
				taquilla ta,
				taquilla_opc_ame tp,
				venta ve,
				carrera ca
			WHERE
				ag.cod_banca = ba.cod_banca AND
				ta.cod_agencia = ag.cod_agencia AND
				tp.cod_taquilla = ta.cod_taquilla AND
				us.cod_taquilla = ta.cod_taquilla AND
				ve.id_usuario = us.id_usuario AND
				ca.cod_carrera = ve.cod_carrera AND
				ve.ticket = %s AND
				ba.cod_banca = %s
			ORDER BY ve.cod_tventa",
        GetSQLValueString($xnroTicket, "int"),
        GetSQLValueString($_POST["cod_banca"], "int")
    );
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$numerodelticket=$row_Recordset1['ticket'];
$controlSer=1;
$ver=0;
if ($totalRows_Recordset1>0) {
    if ($xserTic==substr($row_Recordset1['ser_venta'], 0, 2)) {
        $controlSer=1;
    }
    $serVenta=$row_Recordset1['ser_venta'];
    $rest = substr($serVenta, 0, 3);
}
if ($totalRows_Recordset1>0 && $controlSer==1 && $row_Recordset1['est_ticket']!=0 && $row_Recordset1['est_carrera']==0 &&
    $row_Recordset1['est_confirmacion']==0) {
    $ver=1;
} else {
    if ($controlSer==0 || $totalRows_Recordset1==0) {
        $mensaje='<br/><br/><br/><p style="font-size:20px;color:#CC0000;"><strong>por favor verifique bien el codigo de ticket en reporte de jugadas y vuelva a pasarmelo al parecer esta mal lamentamos el inconveniente</strong></p>';
    }
    if ($row_Recordset1['est_ticket']==0 && $totalRows_Recordset1>0) {
        $mensaje='<br/><br/><br/><p style="font-size:20px;color:#CC0000;"><strong>TICKET ELIMINADO!</strong></p>';
        $ver=1;
    }
    if ($row_Recordset1['est_carrera']==1) {
        $mensaje='<p style="font-size:18px;color:#CC0000;"><strong>CARRERA NO CERRADA!</strong></p>';
        $ver=1;
    }
    if ($row_Recordset1['est_confirmacion']==1 && $row_Recordset1['est_carrera']==0) {
        $mensaje='<p style="font-size:18px;color:#CC0000;"><strong>CARRERA A�N NO CONFIRMADA!</strong></p>';
        $ver=1;
    }
}
$horaInicial=$row_Recordset1['hor_venta'];
$horaActual=horaActual();
if ($tip_usuario=="D" or $tip_usuario=="G") {
    $ver=1;
} else {
    if ($row_Recordset1['tie_reclamo']!=0) {
        $me1='<br/><br/><br/><p style="font-size:20px;color:#CC0000;"><strong>';
        $me3='</strong></p>';
        if ($row_Recordset1['fec_venta']==fechaactualbd()) {
            $minutoAnadir=$row_Recordset1['tie_reclamo'];
            $nuevo = strtotime('+'.$minutoAnadir.' minutes', strtotime($horaInicial));
            $nuevaHora = date('H:i:s', $nuevo);
            $nuevaFecha = date('Y-m-d', $nuevo);
            if ($horaActual>$nuevaHora && fechaactualbd()==$nuevaFecha) {
                $me2='Disculpenos ya no podemos acceder al ticket solicitado por favor pidale el codigo de pago a la persona con acceso al agente el la buscara en la opcion de buscar ticket lamentamos este inconveniente el tiempo que podemos acceder nosotros a esa informacion para poder darsela a usted se configura por agente asi que escapa de nuestras manos';
                $mensaje=$me1.$me2.$me3;
            }
        } else {
            $me2='Disculpenos ya no podemos acceder al ticket solicitado por favor pidale el codigo de pago a la persona con acceso al agente el la buscara en la opcion de buscar ticket lamentamos este inconveniente el tiempo que podemos acceder nosotros a esa informacion para poder darsela a usted se configura por agente asi que escapa de nuestras manos';
            $mensaje=$me1.$me2.$me3;
        }
    } else {
        $tiempoGlobal=180;///AJUSTA EL TIEMPO AQUI
        $me1='<br/><br/><br/><p style="font-size:20px;color:#CC0000;"><strong>';
        $me3='</strong></p>';
        if ($tiempoGlobal>=0 && $totalRows_Recordset1>0) {
            if ($row_Recordset1['fec_venta']==fechaactualbd()) {
                $minutoAnadir=$tiempoGlobal;
                $nuevo = strtotime('+'.$minutoAnadir.' minutes', strtotime($horaInicial));
                $nuevaHora = date('H:i:s', $nuevo);
                $nuevaFecha = date('Y-m-d', $nuevo);
                if ($horaActual>$nuevaHora && fechaactualbd()==$nuevaFecha) {
                    $me2='Disculpenos ya no podemos acceder al ticket solicitado por favor pidale el codigo de pago a la persona con acceso al agente el la buscara en la opci�n de buscar ticket lamentamos este inconveniente el tiempo que podemos acceder nosotros a esa informacion para poder darsela a usted se configura por agente asi que escapa de nuestras manos';
                    $mensaje=$me1.$me2.$me3;
                }
            } else {
                $me2='Disculpenos ya no podemos acceder al ticket solicitado por favor pidale el codigo de pago a la persona con acceso al agente el la buscara en la opci�n de buscar ticket lamentamos este inconveniente el tiempo que podemos acceder nosotros a esa informacion para poder darsela a usted se configura por agente asi que escapa de nuestras manos';
                $mensaje=$me1.$me2.$me3;
            }
        }
    }
}

if ($ver==1) {
    if ($row_Recordset1['est_confirmacion']==0 && $row_Recordset1['est_carrera']==0 && $row_Recordset1['est_ticket']!=0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\busca_jugadax.php - QUERY 5 */ SELECT
			SUM(CASE WHEN ve.est_calculo = 2 OR ve.est_calculo = 4 OR ve.est_calculo = 5  
				THEN ve.pag_premio ELSE 0 END) AS tot_premios,
			SUM(CASE WHEN ve.est_ticket = 2 OR ve.est_ticket = 4 OR ve.est_ticket = 5  
				THEN 1 ELSE 0 END) AS estado
		FROM venta ve
		WHERE ve.ticket = %s",
            GetSQLValueString($xnroTicket, "int")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        $montoapagar=$row_Recordset2['tot_premios'];
        if ($montoapagar>0) {
            $mensaje="";
            $mensaje='<font color="red"><h3><strong>TICKET GANADOR!</strong></h3></font>';
            $mensaje=$mensaje.'<h2><strong>Monto a pagar:'.number_format($montoapagar, 2, ",", ".").'</strong></h2></font>';
            if ($row_Recordset2['estado']>=1) {
                $mensaje=$mensaje.'<strong>YA HA SIDO CANCELADO</strong>';
            } elseif ($row_Recordset2['estado']==0) {
                $mensaje=$mensaje.'<strong>A�N NO CANCELADO</strong>';
            }
        }
        if ($montoapagar==0) {
            $mensaje='<p style="font-size:18px;color:#000000;"><strong>TICKET NO GANADOR</strong></p>';
        }
        mysqli_free_result($Recordset2);
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
            <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket'];
    $ticketticket=$row_Recordset1['ticket']; ?></td>
          </tr>
          <tr>

            <td colspan="4" align="center" class="imprimirnroticket"><br><br>Codigo de ticket: ***<?php echo $rest; ?>***  No responda a este msj recuerde que siempre que no salga un ticket puede reimprimirlo o tomar el codigo de pago de el ultimo ticket creado dicho registro que se le muestra en taquilla de la ultima jugada realizada esta encima de pagar/eliminar apuesta.<br><br></td>
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
          $montoapagar=0;
    $ip=$row_Recordset1['ip_venta'];
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
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta'];
            
            
            
            
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
          <tr>
            <td height="10" colspan="4" align="left">

            <a href='buscar_ticketx.php?numeroticketreset=<?php echo $numerodelticket; ?>&tip_usuario=<?php echo $_SESSION['MM_UserGroup']; ?>&id_usuario=<?php echo $_SESSION['MM_id_usuario']; ?>'class="btn btn-info"> RECETIAR ESTE TICKET </a>
            </td>    
          <tr>
              <td height="10" colspan="4" align="center"><?php echo $mensaje; ?>
        </td>
        </tr>
        </table>


    <?php
if (isset($_GET["numeroticketreset"])) {
                ?>
<script language="javascript">
function abrir1Ventanas(cod) 
{
a= window.open("http://localhost/admin/dividendos_edit2.php?recordID="+cod,"_blank",
"width=385,height=180,top=0,left=0',status,toolbar =1,scrollbars,location");
}

</script>
 
echo "<script>";
    echo "abrir1Ventanas(".$cod_carrera.")";
    echo "</script>";
}
echo 'iiiiiiiiiiiiiiiiiii 337425254737';
echo $ticketticket;
if (isset($ticketticket11)) {
    ?>

     	<a href='taquillas_edit.php?recordID=<?php echo $row_Recordset1['ticket']; ?>'class="btn btn-info"> EDITAR </a>

		 <?php
            } ?>
<?php
} else {
                echo $mensaje;
            }



    ?>
	</div>
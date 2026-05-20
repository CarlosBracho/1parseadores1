<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$usuario=$_SESSION['MM_id_usuario'];
$xHora=horaactual2();
$FechaTxt=fechaactualbd();
$query_Recordset2 = sprintf("/* PARSEADORES1 new\ventas\ventas_reimprimir_ultimo.php - QUERY 1 */ SELECT ticket FROM venta
USE INDEX(id_us_fe_fe)
WHERE venta.id_usuario = %s AND venta.fec_venta = %s AND est_ticket = 1
ORDER BY venta.num_ticket DESC LIMIT 1", GetSQLValueString($usuario, "int"), GetSQLValueString($FechaTxt, "date"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$xTicket_Recordset1=$row_Recordset2['ticket'];
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventas\ventas_reimprimir_ultimo.php - QUERY 2 */ SELECT 
venta.fec_venta, 
venta.hor_venta,
venta.ser_venta,
venta.can_ticket,
venta.num_caballo,
venta.ip_venta,
venta.ticket,
venta.cod_tventa,
venta.mon_venta,
venta.num_ticket,
venta.rei_ticket,
usuario.nom_usuario,
usuario.cod_barra,
usuario.id_usuario,
usuario.can_reimpresion,
taquilla.nom_taquilla,
carrera.nom_hipodromo,
carrera.num_carrera,
carrera.hor_carrera,
taquilla_opc_ame.tic_caduca
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
    GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
    GetSQLValueString($xHora, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style media="print" type="text/css">
#imprimir {
visibility:hidden
}
#noimprimir {
visibility: hidden;
}
</style>
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
</head>
<body style="margin:0px; background:#FFFFFF">
<?php
$horacarrerabd=horaactual2();
if ($horacarrerabd<"23:55:00") {
    $aumento=$horacarrerabd."+5 min";
    $horacarrerabd=(date('H:i', strtotime($aumento)));
}
$rimp=-1;
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta']==fechaactualbd() && $totalRows_Recordset1>0) {
    list($ctaRimp, $idReim)=ctaReimpresion($row_Recordset1['id_usuario'], 1); //id usuario - tipo programa
    if ($row_Recordset1['can_reimpresion']>0 && $row_Recordset1['rei_ticket']==0) {
        $totRimp=$row_Recordset1['can_reimpresion'];
        if ($ctaRimp>=$totRimp) {
            $rimp=-1;
        } else {
            $rimp=1;
            $conte=$ctaRimp+1;
        }
    } else {
        $rimp=0;
    }
}
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta']==fechaactualbd() && $totalRows_Recordset1>0 &&
    $rimp!=-1) {
    if ($row_Recordset1['rei_ticket']==0) {
        $rT=$row_Recordset1['can_reimpresion']-($ctaRimp+1);
    } else {
        $rT=$row_Recordset1['can_reimpresion']-$ctaRimp;
    }
    echo "<div id='noimprimir' style='background:#990000; color:#FFFFFF'>";
    echo "Reimpresiones restantes: ".$rT;
    echo "</div>";
    $serial=$row_Recordset1['ser_venta'];
    $idTic=$row_Recordset1['num_ticket'];
    $estadoCodBarra=$row_Recordset1['cod_barra'];
    $rest = substr($serial, 0, 3);
    $tic_caduca=$row_Recordset1['tic_caduca'];
    if ($rimp==1 && $row_Recordset1['rei_ticket']==0) {
        if ($conte==1) {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\ventas\ventas_reimprimir_ultimo.php - QUERY 3 */ INSERT 
					INTO reimpresion 
					(id_usuario, can_actual, fec_reimpresion, tip_programa) 
					VALUES (%s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['id_usuario'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString(fechaactualbd(), "date"),
                GetSQLValueString(1, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\ventas\ventas_reimprimir_ultimo.php - QUERY 4 */ UPDATE reimpresion 
					SET can_actual=%s
					WHERE id_reimpresion=%s",
                GetSQLValueString($conte, "int"),
                GetSQLValueString($idReim, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        }
        $insertSQL2 = sprintf(
            "/* PARSEADORES1 new\ventas\ventas_reimprimir_ultimo.php - QUERY 5 */ UPDATE venta 
				SET rei_ticket=%s
				WHERE num_ticket=%s",
            GetSQLValueString(1, "int"),
            GetSQLValueString($idTic, "int")
        );
        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
    } ?>
    <div>
        <table width="225" border="0" align="left"><form id="form1" name="form1" method="post" action="">
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
            <td colspan="4" align="center" class="imprimirnroticket">Ticket: <?php echo $row_Recordset1['ticket']; ?></td>
          </tr>
          <tr>
            <td colspan="4" align="center" class="imprimirnroticket">Codigo de Ticket: <?php echo $rest; ?></td>
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
            <?php $montoapagar = $montoapagar+$row_Recordset1['mon_venta']; ?>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td class="imprimirnroticket" height="8" colspan="4" align="right"><p><span class="imprimir"><?php echo "Total: Bs:".number_format($montoapagar, 2, ",", "."); ?></span></p></td>
          </tr>
          <?php if ($tic_caduca>0) { ?>
          <tr>
            <td colspan="4" align="center"><?php echo "Ticket caduca a los ".$tic_caduca." dias";?></td>
          </tr>
          <?php } ?>
          <tr>
            <td colspan="4" align="center">
				<span class="imprimir">
				<?php
                if ($estadoCodBarra==1) {
                    echo "<img src='../includes/barcode2.php?s=code128&wq=4&d=".$rest."'>";
                } ?>          
                </span>
            </td>
          </tr>      
          <tr>
            <td height="10" colspan="4" align="left">
            	<span class="imprimir">IP: <?php echo $ip; ?></span>
            </td>    
            <tr>
        
            <td height="10" colspan="4" align="center">
        <label>
        <input type="button" name="imprimir" id="imprimir" value="Imprimir Ticket" onclick="window.print(); self.close();" />
        </label>
        </td>
        </tr>
                </form>
          <?php $explorador = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/MSIE/i', $explorador) && !preg_match('/Opera/i', $explorador)) {?>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">&nbsp;          
              <tr>
              <tr>
                <td colspan="4" align="center">.          
              <tr>
		  <?php } ?>	          
            </table>
    </div>
    <?php
} else {
            echo "No se produjo ningún resultado<br/><br/>";
        }
        if (isset($ctaRimp) && isset($totRimp) && $ctaRimp>=$totRimp) {
            echo "ATENCION: No puede reimprimir más tickets por hoy";
        }
?>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset2);
?>
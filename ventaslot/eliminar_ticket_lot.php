<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
date_default_timezone_set("America/New_York") ;
$MM_authorizedUsers = "U";
$MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$uVenta=0;
if (isset($_GET["uVenta"])) {
    $uVenta = $_GET["uVenta"];
}
$inicio=fechaactualbd();
$xHora=horaactual2();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventaslot\eliminar_ticket_lot.php - QUERY 1 */ SELECT 
	SUM(ve.mon_apuesta_lot) AS total_venta,
	ve.fec_venta_lot,
	ve.hor_venta_lot, 
	ve.ticket_lot, 
	us.id_usuario, 
	tp.pag_codigo_lot,
	IF(bl.hor_cierre > %s,0,1) AS est_cierre,
	IF(ve.tip_loteria_lot < 4,'(LOTERIA)','(ANIMALITOS)') AS nom_tipo
FROM 
	banca ba, agencia ag, taquilla ta, taquilla_opc_lot tp, venta_lot ve, usuario us, bancaloterias bl
WHERE 
	ve.fec_venta_lot = %s AND
	us.cod_taquilla = ta.cod_taquilla AND 
	us.id_usuario = ve.id_usuario AND
	us.id_usuario = %s AND 
	tp.cod_taquilla = ta.cod_taquilla AND 
	ve.est_ticket_lot = 1 AND
	ve.est_calculo_lot = 0 AND
	ag.cod_agencia = ta.cod_agencia AND
	ba.cod_banca = ag.cod_banca AND
	bl.id_banca = ba.cod_banca AND
	ve.id_loteria = bl.id_loteria
GROUP BY ve.ticket_lot DESC
ORDER BY ve.hor_venta_lot DESC",
    GetSQLValueString($xHora, "date"),
    GetSQLValueString($inicio, "date"),
    GetSQLValueString($uVenta, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$acceso=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hipicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<style>@charset "utf-8";body{margin:0;padding:0;font-family:Tahoma, Geneva, sans-serif;font-size:14px;color:#000;background-color:#E5E5E5;background-repeat:repeat-x;background-image:none;text-align:center}.btn-primary,.btn-primary:hover{color:#fff;text-shadow:0 -1px 0 rgba(0,0,0,0.25)}.btn-primary.active{color:rgba(255,255,255,0.75)}.btn-primary{background-color:#0074cc;*background-color:#05c;background-image:-ms-linear-gradient(top,#08c,#05c);background-repeat:repeat-x;border-color:#05c #05c #003580;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc',endColorstr='#0055cc',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}
</style>
<script language="javascript">function cOver(celda){celda.style.backgroundColor="#FFFFDD"}function cOut(celda){ celda.style.backgroundColor="#E5E5E5"} 
var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true;}else{alert("El formulario ya está siendo enviado, por favor aguarde un instante.");return false;}}
function deshabilita(id){document.getElementById(id).disabled=true;}
</script>
</head>
<body style="margin: 0px">
	<?php
    if ($acceso==1) {?>
        <div style="background: #900; width:100%; float:left; text-align:right; padding:10px 2px 2px 2px;
            color:#FFF; font-size:28px; text-align:center">
            ELIMINAR TICKETS
        </div><!-- end .container -->
		<?php
        if ($totalRows_Recordset1>0) {?>
            <div style="width:99%; float:left; padding:0px 0px 0px 0px; color:#000; font-size:20px; text-align: left">
            	<table width="100%" border="0" align="center">
				<tr style="background:#0084B4; color:#FFF">
                    <td width="35%" align="center">Código</td>
                    <td width="14%" align="center">Fecha/Hora</td>
                    <td width="37%" align="center">Apuesta</td>
                    <td width="14%" align="center">Acción</td>
				</tr><?php
                $x1=0;
                do {
                    if ($row_Recordset1['est_cierre']==0) {
                        $ticket2=$row_Recordset1['ticket_lot']; ?>
						<tr onmouseover="cOver(this)" onmouseout="cOut(this)" style="font-size:14px">
						  <td height="32" align="right" valign="middle" style="font-size:18px"><?php echo $ticket2; ?></td>
						  <td align="center" style="font-size:12px">
							<?php echo fechanueva($row_Recordset1['fec_venta_lot'])." ".horaampm($row_Recordset1['hor_venta_lot']); ?>
						  </td>
						  <td style="font-size:18px">
						  <?php echo $row_Recordset1['total_venta']." ".$row_Recordset1['nom_tipo']; ?>
						  </td>
						  <td align="center" valign="middle">
							<input type="button" name="bAceptar<?php echo $ticket2; ?>" 
                            	id="bAceptar<?php echo $ticket2; ?>"
                            	style="width:100px; font-size:12px; height:30px; background:#990000; color:#FFF" 
                                title="eliminar ticket"
							value="Eliminar"
	onclick="deshabilita('bAceptar<?php echo $ticket2; ?>'), location.href = '../ventaslot/ventas_eliminar_ticket_lot.php?pagoSIN=<?php echo $ticket2; ?>&uVenta=<?php echo $row_Recordset1['id_usuario']; ?>'"/>
						  </td>
						</tr><?php
                            $x1++;
                    }
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                if ($x1>0) {?>
                   	<tr style="background:#0084B4; color:#FFF">
						<td colspan="4">&nbsp;</td>
					</tr><?php
                }?>
			  </table>

            </div><?php
            if ($x1==0) {
                echo '<font size="6" color="red">No existen tickets</font>';
            }
        } else {
            echo '<font size="6" color="red">No se produjo ningún resultado</font>';
        }
    } else {
        echo '<font size="6" color="red">No se produjo ningún resultado</font>';
    } ?>
</body>
</html>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;
$MM_authorizedUsers = "U";
$MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$uVenta=0;
if (isset($_GET["uVenta"])) {
    $uVenta = $_GET["uVenta"];
}
$inicio=fechaactualbd();
$xHora=horaactual2();
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventashnac_mie\eli_tic_sincodigo_hnac.php - QUERY 1 */ SELECT 
ve.ticket_hnac,
ve.hor_venta_hnac,
ve.ser_venta_hnac,
ve.fec_venta_hnac,
ve.id_usuario,
ca.cod_carrera_hnac,
ca.hor_carrera_hnac,
hi.nom_hipodromo_hnac,
ca.num_carrera_hnac,
ca.est_carrera_hnac,
tp.pag_codigo_hnac,
us.nom_usuario,
ta.nom_taquilla
FROM 
venta_hnac ve,
carrera_hnac ca,
hipodromo_hnac hi,
taquilla_opc_hnac tp,
taquilla ta,
usuario us
WHERE
ve.fec_venta_hnac = %s AND 
ve.id_usuario = %s AND
ca.hor_carrera_hnac >= %s AND 
ve.est_ticket_hnac = 1 AND
ca.cod_carrera_hnac = ve.cod_carrera_hnac AND
ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac AND
us.id_usuario = ve.id_usuario AND
ta.cod_taquilla = us.cod_taquilla AND
tp.cod_taquilla = ta.cod_taquilla
GROUP BY ve.ticket_hnac
ORDER BY ve.num_ticket_hnac",
    GetSQLValueString($inicio, "date"),
    GetSQLValueString($uVenta, "int"),
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
<title>.:Apuestas Hipicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<style>@charset "utf-8";body{margin:0;padding:0;font-family:Tahoma, Geneva, sans-serif;font-size:14px;color:#000;background-color:#E5E5E5;background-repeat:repeat-x;background-image:none;text-align:center}.btn-primary,.btn-primary:hover{color:#fff;text-shadow:0 -1px 0 rgba(0,0,0,0.25)}.btn-primary.active{color:rgba(255,255,255,0.75)}.btn-primary{background-color:#0074cc;*background-color:#05c;background-image:-ms-linear-gradient(top,#08c,#05c);background-repeat:repeat-x;border-color:#05c #05c #003580;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc',endColorstr='#0055cc',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}
</style>
<script language="javascript">function cOver(celda){celda.style.backgroundColor="#FFFFDD"}function cOut(celda){ celda.style.backgroundColor="#E5E5E5"} 
</script>
</head>
<body style="margin: 0px">
	<?php
    if ($row_Recordset1['pag_codigo_hnac']==1) {?>
        <div style="background:#0E5157; width:100%; float:left; text-align:right; padding:10px 2px 2px 2px;
            color:#FFF; font-size:28px; text-align:center">
            ELIMINAR TICKETS NACIONALES
        </div><!-- end .container -->
		<?php
        if ($totalRows_Recordset1>0) {?>
            <div style="width:100%; float:left; padding:0px 0px 0px 0px; color:#000; font-size:20px; text-align: left">
            	<table width="100%" border="0" align="center">
				<tr style="background:#333; color:#FFF">
                    <td width="18%" align="center">Código</td>
                    <td width="16%" align="center">Fecha/Hora</td>
                    <td width="55%" align="center">Hipódromo/Carrera</td>
                    <td width="11%" align="center">Acción</td>
				</tr><?php
                $x1=0;
                do {
                    $carrera=$row_Recordset1['nom_hipodromo_hnac']." Carr..".$row_Recordset1['num_carrera_hnac'];
                    $ticket2=$row_Recordset1['ticket_hnac'];
                    $serial=$row_Recordset1['ser_venta_hnac'];
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$ticket2; ?>
					<tr onmouseover="cOver(this)" onmouseout="cOut(this)" style="font-size:14px">
					  <td height="32" align="right" valign="middle" style="font-size:18px"><?php echo $rest; ?></td>
					  <td align="center" style="font-size:14px">
					  	<?php
                        echo fechanueva($row_Recordset1['fec_venta_hnac'])."/".horaampm($row_Recordset1['hor_venta_hnac']); ?>
                      </td>
				      <td style="font-size:18px"><?php echo $carrera; ?></td>
					  <td align="center" valign="middle">
                       	<input type="button" style="width:100px; font-size:12px; height:30px; background:#990000; color:#FFF" title="eliminar ticket"
                        value="Eliminar"
onclick="location.href = '../ventashnac_mie/ventas_eliminar_ticket_hnac.php?pagoSIN=<?php echo $rest; ?>&uVenta=<?php echo $row_Recordset1['id_usuario']; ?>'"/>
                      </td>
			  		</tr><?php
                        $x1++;
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                if ($x1>0) {?>
                   	<tr style="background:#333; color:#FFF">
						<td colspan="5">&nbsp;</td>
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
    }
    if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }
    ?>
</body>
</html>
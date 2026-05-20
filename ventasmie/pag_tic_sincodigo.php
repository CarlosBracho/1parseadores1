<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (is_file('../includes/calculodepago.php')) {
    include("../includes/calculodepago.php");
}
date_default_timezone_set("America/New_York") ;
$MM_authorizedUsers = "U";
$MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$uVenta=0;
if (isset($_GET["uVenta"])) {
    $uVenta = $_GET["uVenta"];
}
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
        if ($_POST['fecha_inicio']!="" && $_POST['fecha_fin']!="") {
            if (strtotime(fechaymd($_POST['fecha_inicio'])) < strtotime(fechaymd($_POST['fecha_fin']))) {
                $inicio=$_POST['fecha_inicio'];
                $final=$_POST['fecha_fin'];
            } else {
                $final=$_POST['fecha_inicio'];
                $inicio=$_POST['fecha_fin'];
            }
            $in=fechaymd($inicio);
            $fi=fechaymd($final);
        }
    }
}
$query_Recordset1 = sprintf("/* PARSEADORES1 ventasmie\pag_tic_sincodigo.php - QUERY 1 */ SELECT  
	SUM(ve.mon_venta) AS total_venta,
	GROUP_CONCAT(ve.num_caballo SEPARATOR '*') AS cab_apuesta,
	GROUP_CONCAT(
		(CASE ve.cod_tventa 
			WHEN '1' THEN 'GAN'
			WHEN '2' THEN 'PLA'
			WHEN '3' THEN 'SHO'
			WHEN '4' THEN 'EXA'
			WHEN '5' THEN 'TRI'
			WHEN '6' THEN 'SUP'
			WHEN '7' THEN '[P]EXA'
			WHEN '8' THEN '[P]TRI'
			WHEN '9' THEN '[P]SUP'
		END)
		SEPARATOR '*') AS tip_apuesta_nom,
	GROUP_CONCAT(ve.mon_venta SEPARATOR '*') AS mon_apuesta,
	CONCAT(ca.nom_hipodromo, ' Carr...', ca.num_carrera) AS carrera,
	ve.fec_venta, 
	ve.ticket, 
	ve.cod_cliente,
	ve.tra_codigo,
		ve.efectivoO,
	us.id_usuario, 
	tp.tic_caduca,
	ca.pau_pagos,
ve.efectivoO,
	tp.pag_codigo
FROM 
	taquilla ta, taquilla_opc_ame tp, venta ve, usuario us, carrera ca
WHERE 
	us.cod_taquilla = ta.cod_taquilla AND 
	us.id_usuario = ve.id_usuario AND
	us.id_usuario = %s AND 
	tp.cod_taquilla = ta.cod_taquilla AND 
	ve.cod_carrera = ca.cod_carrera AND 
	ve.fec_venta >= %s AND 
	ve.fec_venta <= %s AND 
	ve.est_ticket = 1 AND
	ve.est_calculo >= 2 AND
	ve.est_calculo <= 5
GROUP BY ve.ticket DESC", GetSQLValueString($uVenta, "int"), GetSQLValueString($in, "date"), GetSQLValueString($fi, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset7 = sprintf("/* PARSEADORES1 ventasmie\pag_tic_sincodigo.php - QUERY 2 */ SELECT est_control_pagos_ame FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame = 1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_pagos=$row_Recordset7['est_control_pagos_ame']; //todos los pagos globales
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
</script>
</head>
<body style="margin: 0px">
	<?php
    if ($acceso==1 && $est_control_pagos==0) {?>
        <div style="background: #333; width:100%; float:left; text-align:right; padding:10px 2px 2px 2px;
            color:#FFF; font-size:28px; text-align:center">
            PAGO DE APUESTAS
        </div><!-- end .container -->
        <div style="background: #FFF; width:100%; float:left; padding:10px 0px 0px 10px;
            color:#000; font-size:20px; text-align: left">
            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                Desde:
                <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" style="width:100px; font-size:16px; height:25px"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
                Hasta:    
                <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" style="width:100px; font-size:16px; height:25px"
                    size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" /> 
                <input type="submit" value="Buscar" class="btn-primary" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/>
                <input type="hidden" name="MM_update" value="form1" />
            </form>  
        </div><!-- end .container --><?php
        if ($totalRows_Recordset1>0) {?>
            <div style="width:99.9%; float:left; padding:0px 0px 1px 0px; color:#000; font-size:20px; text-align: left;">
            	<table width="100%" border="0" align="center">
				<tr style="background:#099; color:#FFF;font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
                    <td width="8%" align="center">Fecha</td>
                    <td width="50%" align="center">Apuesta</td>
                    <td width="20%" align="center">Cliente</td>
                    <td width="13%" align="center">Ticket</td>
                    <td width="9%" align="center">Acción</td>
				</tr><?php
                $x1=0;
                $tic_caduca=$row_Recordset1['tic_caduca'];
                do {
                    if ($tic_caduca>0) {
                        $diasTrancurridos=dias_transcurridos(fechaactualbd(), $row_Recordset1['fec_venta']);
                    } else {
                        $diasTrancurridos=0;
                    }
                    if ($diasTrancurridos<=$tic_caduca) {
                        $ticket2=$row_Recordset1['ticket'];
                        $caballos=explode('*', $row_Recordset1['cab_apuesta']);
                        $tipo=explode('*', $row_Recordset1['tip_apuesta_nom']);
                        $monto=explode('*', $row_Recordset1['mon_apuesta']);
                        $jFinal='<font size="2.5" color="blue">';
                        $x=0;
                        foreach ($caballos as $valor) {
                            if ($tipo[$x]=='[P]EXA') {
                                $monto[$x]="c/u*".number_format(($monto[$x]/2), 2, ",", ".");
                            }
                            if ($tipo[$x]=='[P]TRI') {
                                $monto[$x]="c/u*".number_format(($monto[$x]/6), 2, ",", ".");
                            }
                            if ($tipo[$x]=='[P]SUP') {
                                $monto[$x]="c/u*".number_format(($monto[$x]/24), 2, ",", ".");
                            }
                            $jFinal.="(".$valor."-".$tipo[$x]."*".$monto[$x].") ";
                            $x++;
                        }
                        if ($row_Recordset1['efectivoO']==0) {
                            $efectivoO=' BSS EFECTIVO';
                        }
                        if ($row_Recordset1['efectivoO']==1) {
                            $efectivoO=' BSS DEBITO';
                        }
                        if ($row_Recordset1['efectivoO']==2) {
                            $efectivoO=' BSS TRASNFERENCIA';
                        }
                        if ($row_Recordset1['efectivoO']==3) {
                            $efectivoO=' USD';
                        }
                        if ($row_Recordset1['efectivoO']==4) {
                            $efectivoO=' COP';
                        }
                        if ($row_Recordset1['efectivoO']==5) {
                            $efectivoO=' SOL';
                        } ?>
						<tr onmouseover="cOver(this)" onmouseout="cOut(this)" style="font-size:14px">
						  <td align="center" style="font-size:16px"><?php echo fechanueva($row_Recordset1['fec_venta']); ?></td>
					      <td style="font-size:18px"><?php echo $row_Recordset1['carrera']."--> ".$jFinal."--> ".$row_Recordset1['total_venta'].$efectivoO."</font>"; ?></td>
 							


  <td height="34" align="right" valign="middle" style="font-size:16px">
						  <?php
echo $row_Recordset1['cod_cliente']
                          ?>
                          </td>



						  <td height="34" align="right" valign="middle" style="font-size:16px">
						  <?php
                            echo $ticket2; ?>
                          </td>


  <td align="center" valign="middle">
                          <?php if ($row_Recordset1['pau_pagos']==0) {?>
                          	<input type="button" style="width:100px; font-size:12px; height:30px" title="procesa pago"
                            value="Procesar pago" 
onclick="location.href = '../ventas/ventas_pagar_apuestas_procesar.php?pagoSIN=<?php echo $ticket2;?>&uVenta=<?php echo $row_Recordset1['id_usuario'];?>'"/><?php
                          } else {
                              echo '<font size="1" color="red">PAGOS ESTAN PAUSADOS</font>';
                          } ?>
                          </td>
				  		</tr><?php
                        $x1++;
                    }
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                if ($x1>0) {?>
                   	<tr style="background:#099; color:#FFF">
						<td colspan="5">&nbsp;</td>
					</tr><?php
                }?>
			  </table>

            </div><?php
            if ($x1==0) {
                echo '<font size="6" color="red">No existen tickets por pagar</font>';
            }
        } else {
            echo '<font size="6" color="red">No se produjo ningún resultado</font>';
        }
    } elseif ($est_control_pagos==1) {
        echo '<font size="5" color="red">EN ESTOS MOMENTOS LOS PAGOS ESTAN PAUSADOS<BR/>POR FAVOR INTENTE MAS TARDE</font>';
    } else {
            echo '<font size="6" color="red">No se produjo ningún resultado</font>';
        }?>
</body>
</html>

<?php
mysqli_free_result($Recordset1);mysqli_free_result($Recordset7);?>
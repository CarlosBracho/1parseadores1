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
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\pag_tic_sincodigo_hnac.php - QUERY 1 */ SELECT tp.tic_caduca_hnac, us.id_usuario, ve.ticket_hnac, ve.ser_venta_hnac, 
ve.fec_venta_hnac, ca.est_carrera_hnac, pau_pagos_hnac
FROM taquilla ta, taquilla_opc_hnac tp, venta_hnac ve, usuario us, carrera_hnac ca, hipodromo_hnac hi
WHERE us.cod_taquilla = ta.cod_taquilla AND us.id_usuario = ve.id_usuario AND us.id_usuario = %s AND
tp.cod_taquilla = ta.cod_taquilla AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s AND
ve.est_ticket_hnac = 1 AND ve.cod_carrera_hnac = ca.cod_carrera_hnac AND ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac
GROUP BY ve.ticket_hnac 
ORDER BY ve.num_ticket_hnac ASC",
    GetSQLValueString($uVenta, "int"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 = sprintf("/* PARSEADORES1 new\ventashnac_mie\pag_tic_sincodigo_hnac.php - QUERY 2 */ SELECT tp.pag_codigo_hnac FROM taquilla_opc_hnac tp, usuario us
WHERE tp.cod_taquilla = us.cod_taquilla AND us.id_usuario = %s LIMIT 1", GetSQLValueString($uVenta, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$query_Recordset7 = sprintf("/* PARSEADORES1 new\ventashnac_mie\pag_tic_sincodigo_hnac.php - QUERY 3 */ SELECT est_control_pagos_hnac FROM ctrol_ventpag_global_hnac WHERE cod_ctrol_ventpag_global_hnac =1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_pagos_hnac=$row_Recordset7['est_control_pagos_hnac'];

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
    if ($row_Recordset2['pag_codigo_hnac']==1 && $est_control_pagos_hnac==0) {?>
        <div style="background:#0E5157; width:100%; float:left; text-align:right; padding:10px 2px 2px 2px;
            color:#FFF; font-size:28px; text-align:center">
            PAGO DE APUESTAS NACIONALES
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
            <div style="width:99%; float:left; padding:10px 0px 10px 10px; color:#000; font-size:20px; text-align: left">
            	<table width="100%" border="0" align="center">
				<tr style="background:#099; color:#FFF">
                    <td width="15%" align="center">Código</td>
                    <td width="12%" align="center">Fecha</td>
                    <td width="64%" align="center">Jugada</td>
                    <td width="9%" align="center">Acción</td>
				</tr><?php
                $x1=0;
                $anterior=0;
                $pre=1;
                $tic_caduca=$row_Recordset1['tic_caduca_hnac'];
                $s=0;
                do {
                    $s++;
                    //echo $s." * ".$row_Recordset1['ticket_hnac']."<br/>";
                    $total=buscarSiTicketpremiado_hnac($row_Recordset1['ticket_hnac']);
                    
                    if ($total==0) {
                        $pre=1;
                        list($pre, $car, $rT, $cabMin, $tEjem)=verificarPremio_hnac(
                            $row_Recordset1['ticket_hnac'],
                            $row_Recordset1['id_usuario']
                        );
                        if ($tic_caduca>0) {
                            $diasTrancurridos=dias_transcurridos(fechaactualbd(), $row_Recordset1['fec_venta_hnac']);
                        } else {
                            $diasTrancurridos=0;
                        }
                        //echo $pre." - ".$rT."<br/>";
                        if (($pre>0 || $rT>0) && $diasTrancurridos<=$tic_caduca) {
                            $ticket2=$row_Recordset1['ticket_hnac'];
                            $serial=$row_Recordset1['ser_venta_hnac'];
                            $rest = substr($serial, 0, 2);
                            $rest = $rest.$ticket2; ?>
							<tr onmouseover="cOver(this)" onmouseout="cOut(this)" style="font-size:14px">
							  <td height="34" align="right" valign="middle" style="font-size:16px"><?php echo $rest; ?></td>
							  <td align="center" style="font-size:16px">
							  <?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?>
							  </td>
							  <td style="font-size:18px">
							  <?php echo $car;
                                
                            if ($diasTrancurridos>$tic_caduca) {
                                echo " <font color='#990000'>>CADUCÓ</font>";
                            } ?>
                              </td>
							  <td align="center" valign="middle">
								  <?php
                                  //echo $rT;
                                  if ((($rT>=1 && $row_Recordset1['est_carrera_hnac']==1) ||
                                        $row_Recordset1['est_carrera_hnac']==0 || ($cabMin>=$tEjem)) &&
                                        $row_Recordset1['pau_pagos_hnac']==0) {?>
									<input type="button" style="width:100px; font-size:12px; height:30px" title="procesa pago"
									value="Procesar pago" 
		onclick="location.href = '../ventashnac_mie/ventas_pagar_apuestas_procesar_hnac.php?pagoSIN=<?php echo $rest;?>&uVenta=<?php echo $row_Recordset1['id_usuario'];?>'"/>
								  <?php } elseif ($row_Recordset1['pau_pagos_hnac']==1) {
                                            echo '<font size="1" color="red">PAGOS ESTAN PAUSADOS</font>';
                                        } ?>
							  </td>
							</tr><?php
                            $x1++;
                        }
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
    } elseif ($est_control_pagos_hnac==1) {
        echo '<font size="5" color="red">EN ESTOS MOMENTOS LOS PAGOS ESTAN PAUSADOS<BR/>POR FAVOR INTENTE MAS TARDE</font>';
    } else {
        echo '<font size="6" color="red">No se produjo ningún resultado</font>';
    }
    if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }
    if (isset($Recordset2)) {
        mysqli_free_result($Recordset2);
    }
    ?>
</body>
</html>
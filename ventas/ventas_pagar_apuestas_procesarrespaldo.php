<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$mensaje="";$ver=1;
if (isset($_GET["pagoSIN"]) && isset($_GET["uVenta"])) {
    $xTicket = $_GET["pagoSIN"];
    $usuarioPago=$_GET["uVenta"];
} else {
    if (!isset($_GET["pagoSIN"])) {
        $xTicket = "";
    }
    if (!isset($_GET["uVenta"])) {
        $usuarioPago="";
    }
    $mensaje="�NO ENCONTRADO!";
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 1 */ SELECT ve.ser_venta, ve.efectivoO, tp.pag_codigo, pau_pagos, ve.tra_codigo, ve.cod_cliente, tp.pag_codigo, ta.tipo_pago
	FROM venta ve, carrera ca, taquilla ta, taquilla_opc_ame tp
	WHERE ve.ticket = %s AND ve.cod_carrera = ca.cod_carrera AND ve.est_ticket != 0 AND
		ta.cod_taquilla = ve.cod_taquilla AND tp.cod_taquilla = ta.cod_taquilla LIMIT 1",
    GetSQLValueString($xTicket, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$ser_venta=substr($row_Recordset1['ser_venta'], 0, 3);
$tra_codigo=$row_Recordset1['tra_codigo'];
$cod_cliente=$row_Recordset1['cod_cliente'];

$query_Recordset7 = sprintf("/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 2 */ SELECT est_control_pagos_ame FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame = 1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_pagos=$row_Recordset7['est_control_pagos_ame']; //todos los pagos globales
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ($row_Recordset1['pag_codigo']==1) {
    $_POST["MM_update"]="form1";
    $_POST["ticket"]=$_GET["pagoSIN"];
    $_POST["ser_venta"]=substr($row_Recordset1['ser_venta'], 0, 3);
    $_POST["uVenta"]=$_GET["uVenta"];
    $ver=0;
}
if (isset($_POST["MM_update"]) && $_POST["MM_update"] == "form1" && isset($_POST["ticket"]) && isset($_POST["uVenta"])) {
    $ver=0;
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 3 */ SELECT us.cod_taquilla FROM usuario us WHERE us.id_usuario = %s LIMIT 1",
        GetSQLValueString($_POST["uVenta"], "int")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    if ($totalRows_Recordset2>0) {
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 4 */ SELECT 
			SUM(CASE WHEN ve.est_ticket=2 OR ve.est_ticket=4 OR ve.est_ticket=5 THEN 1 ELSE 0 END) AS est_pagos, 
			SUM(CASE WHEN ve.est_calculo=2 THEN ve.pag_premio ELSE 0 END) AS pag_premios, 
			SUM(CASE WHEN ve.est_calculo=4 OR ve.est_calculo=5 THEN ve.mon_venta ELSE 0 END) AS pag_devolucion, 
			SUM(CASE WHEN ve.ticket>0 THEN 1 ELSE 0 END) AS can_jugadas,
			SUM(CASE WHEN ve.ticket>0 AND (ve.est_calculo=2 OR ve.est_calculo=4 OR ve.est_calculo=5) 
				THEN 1 ELSE 0 END) AS can_jugadas_apagar,
			ve.est_ticket, ve.ser_venta, ve.est_calculo, ve.fec_venta,
			ca.est_confirmacion, ca.est_carrera, ca.pau_pagos, tp.pag_codigo,
			tp.tic_caduca, ta.cod_taquilla, ta.tipotaquilla, ta.saldoactual, ve.efectivoO, ta.tipo_pago, ag.cod_agencia, ag.tipo_pagoa, ag.saldoactuala 
			FROM venta ve, carrera ca, taquilla ta, taquilla_opc_ame tp, agencia ag
			WHERE ve.ticket = %s AND ve.cod_carrera = ca.cod_carrera AND ve.est_ticket != 0 AND
				ta.cod_taquilla = ve.cod_taquilla AND tp.cod_taquilla = ta.cod_taquilla AND ta.cod_agencia = ag.cod_agencia",
            GetSQLValueString($_POST["ticket"], "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        if ($row_Recordset1['cod_taquilla']==$row_Recordset2['cod_taquilla']) {
            if (isset($_POST["ser_venta"]) && $_POST["ser_venta"]==substr($row_Recordset1['ser_venta'], 0, 3)) {
                $query_Recordset7 = sprintf("/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 5 */ SELECT est_control_pagos_ame FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame = 1");
                $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
                $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
                $totalRows_Recordset7 = mysqli_num_rows($Recordset7);
                $can_jugadas_apagar=$row_Recordset1['can_jugadas_apagar'];
                $can_jugadas=$row_Recordset1['can_jugadas'];
                if ($row_Recordset1['est_confirmacion']!="" && $row_Recordset1['pau_pagos']==0 &&
                    $row_Recordset7['est_control_pagos_ame']==0) {
                    if (($row_Recordset1['est_confirmacion']==1 && $can_jugadas_apagar!=$can_jugadas) or
                        $row_Recordset1['est_calculo']==0) {
                        $mensaje="<h3><strong>NO PUEDE SER AUN PROCESADO!";
                        if ($can_jugadas_apagar!=$can_jugadas) {
                            $mensaje.="<br/>POSEE OTRA(S) JUGADA(S)";
                        }
                        $mensaje.="</strong></h3>";
                    } else {
                        if ($row_Recordset1['est_pagos']==0) {
                            $apagar=$row_Recordset1['pag_premios']+$row_Recordset1['pag_devolucion'];
                            if ($apagar>0) {
                                $tic_caduca=$row_Recordset1['tic_caduca'];
                                if ($tic_caduca==0) {
                                    $diasTrancurridos=0;
                                } else {
                                    $diasTrancurridos=dias_transcurridos(fechaactualbd(), $row_Recordset1['fec_venta']);
                                }
                                if ($diasTrancurridos>$tic_caduca) {
                                    $mensaje='<font color="red"><strong>�HA CADUCADO!</strong></font>';
                                } else {
                                    $mensaje='<font color="red"><h1><strong>�';
                                    if ($row_Recordset1['pag_premios']>0) {
                                        $mensaje=$mensaje.'GANADOR';
                                    }
                                    if ($row_Recordset1['pag_premios']>0 && $row_Recordset1['pag_devolucion']>0) {
                                        $mensaje=$mensaje.'+';
                                    }
                                    if ($row_Recordset1['pag_devolucion']>0) {
                                        $mensaje=$mensaje.'DEVOLUCION';
                                    }
                                    $mensaje=$mensaje.'!</h1></strong></font>';
                                    $mensaje=$mensaje.'<font color="red"><h2>Monto a pagar: ';
                                    $mensaje=$mensaje.number_format($apagar, 2, ",", ".").'</h2></font>';

                                    if ($row_Recordset1['efectivoO']==0) {
                                        $mensaje=$mensaje.'<font size="30" color="black"><h2><br/>EFECTIVO'.'</h2></font>';
                                    }
                                    if ($row_Recordset1['efectivoO']==1) {
                                        $mensaje=$mensaje.'<font size="30" color="black"><h2><br/>DEBITO'.'</h2></font>';
                                    }
                                    if ($row_Recordset1['efectivoO']==2) {
                                        $mensaje=$mensaje.'<font size="30" color="black"><h2><br/>TRANSFERENCIA'.'</h2></font>';
                                    }
                                    if ($row_Recordset1['efectivoO']==3) {
                                        $mensaje=$mensaje.'<font size="30" color="black"><h2><br/>DOLAR AMERICANO'.'</h2></font>';
                                    }
                                    if ($row_Recordset1['efectivoO']==4) {
                                        $mensaje=$mensaje.'<font size="30" color="black"><h2><br/>PESO COLOMBIANO'.'</h2></font>';
                                    }
                                    if ($row_Recordset1['efectivoO']==5) {
                                        $mensaje=$mensaje.'<font size="30" color="black"><h2><br/>SOL PERUANO'.'</h2></font>';
                                    }
                                    $query_Recordset3 = sprintf(
                                        "/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 6 */ SELECT ve.num_ticket, ve.est_calculo FROM venta ve 
									WHERE ve.ticket = %s AND (ve.est_calculo=2 OR ve.est_calculo=4 OR ve.est_calculo=5)",
                                        GetSQLValueString($_POST["ticket"], "int")
                                    );
                                    $Recordset3=mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                                    $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                                    $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                                    $horaPago=horaactual();
                                    $ipPago=getRealIP();
                                    $fecpago=fechaactualbd();
                                    do {
                                        $numTicket=$row_Recordset3['num_ticket'];
                                        $estCalcul=$row_Recordset3['est_calculo'];
                                        $updateSQL = sprintf(
                                            "/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 7 */ UPDATE venta 
										   SET est_ticket=%s, fec_pago=%s, cod_usuario_pago=%s, ip_pago=%s, hor_pago=%s 
											   WHERE num_ticket=%s",
                                            GetSQLValueString($estCalcul, "int"),
                                            GetSQLValueString($fecpago, "date"),
                                            GetSQLValueString($_POST["uVenta"], "int"),
                                            GetSQLValueString($ipPago, "text"),
                                            GetSQLValueString($horaPago, "date"),
                                            GetSQLValueString($numTicket, "int")
                                        );
                                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                        
                                        $usdabss=0;
                                        if ($row_Recordset1['tipo_pago']==1 && $row_Recordset1['pag_devolucion']>0) {
                                            $query_Recordset55 = sprintf(
                                                "
/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 8 */ SELECT * FROM tasadecambio
WHERE Idtasadecambio = %s 
LIMIT 100",
                                                GetSQLValueString(1, "int")
                                            );
                                            $Recordset55 = mysqli_query($conexionbanca, $query_Recordset55) or die(mysqli_error($conexionbanca));
                                            $row_Recordset55 = mysqli_fetch_assoc($Recordset55);
                                            $totalRows_Recordset55 = mysqli_num_rows($Recordset55);
                                            $usdabss=$row_Recordset55['usdabss'];
                                            $copabss=$row_Recordset55['copabss'];
                                            $solabss=$row_Recordset55['solabss'];
                                            $tasa=1;
                                            if ($row_Recordset1['efectivoO']<=2) {
                                                $tasa=1;
                                            }
                                            if ($row_Recordset1['efectivoO']==3) {
                                                $tasa=$usdabss;
                                            }
                                            if ($row_Recordset1['efectivoO']==4) {
                                                $tasa=$copabss;
                                            }
                                            if ($row_Recordset1['efectivoO']==5) {
                                                $tasa=$solabss;
                                            }



                                            $montodevuelto=$row_Recordset1['pag_devolucion']*$tasa;
                                            $insertSQL15 = sprintf(
                                                "/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 9 */ UPDATE taquilla 
				SET
				saldoactual=saldoactual+%s
				WHERE 
				cod_taquilla=%s",
                                                GetSQLValueString($montodevuelto, "double"),
                                                GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
                                            );

                                            $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));
                                        }
                                        if ($row_Recordset1['tipo_pagoa']==1 && $row_Recordset1['pag_devolucion']>0) {
                                            if ($usdabss==0) {
                                                $query_Recordset55 = sprintf(
                                                    "
/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 10 */ SELECT * FROM tasadecambio
WHERE Idtasadecambio = %s 
LIMIT 100",
                                                    GetSQLValueString(1, "int")
                                                );
                                                $Recordset55 = mysqli_query($conexionbanca, $query_Recordset55) or die(mysqli_error($conexionbanca));
                                                $row_Recordset55 = mysqli_fetch_assoc($Recordset55);
                                                $totalRows_Recordset55 = mysqli_num_rows($Recordset55);
                                                $usdabss=$row_Recordset55['usdabss'];
                                                $copabss=$row_Recordset55['copabss'];
                                                $solabss=$row_Recordset55['solabss'];
                                                $tasa=1;
                                                if ($row_Recordset1['efectivoO']<=2) {
                                                    $tasa=1;
                                                }
                                                if ($row_Recordset1['efectivoO']==3) {
                                                    $tasa=$usdabss;
                                                }
                                                if ($row_Recordset1['efectivoO']==4) {
                                                    $tasa=$copabss;
                                                }
                                                if ($row_Recordset1['efectivoO']==5) {
                                                    $tasa=$solabss;
                                                }
                                            }



                                            $montodevuelto=$row_Recordset1['pag_devolucion']*$tasa;
                                            $insertSQL15 = sprintf(
                                                "/* PARSEADORES1 ventas\ventas_pagar_apuestas_procesarrespaldo.php - QUERY 11 */ UPDATE agencia 
				SET
				saldoactuala=saldoactuala+%s
				WHERE 
				cod_agencia=%s",
                                                GetSQLValueString($montodevuelto, "double"),
                                                GetSQLValueString($row_Recordset1['cod_agencia'], "int")
                                            );

                                            $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));
                                        }
                                    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
                                }
                            } else {
                                $mensaje='<font color="red"><strong>NO GANADOR!</strong></font>';
                            }
                        } else {
                            $mensaje='<font color="red"><strong>YA CANCELADO!</strong></font>';
                        }
                    }
                } else {
                    if ($row_Recordset7['est_control_pagos_ame']==1 or $row_Recordset1['pau_pagos']==1) {
                        $mensaje='<font color="red">PAGOS PAUSADOS MOMENTANEAMENTE<BR/><br/>POR FAVOR INTENTE MAS TARDE</font>';
                    }
                }
            } else {
                $mensaje="<font color='red'>�ERROR EN CODIGO DE PAGO!</font>";
                $ver=1;
            }
        } else {
            $mensaje="<font color='red'>�TICKET NO PUEDE SER PAGADO POR ESTA TAQUILLA!</font>";
        }
    } else {
        $mensaje="<font color='red'>�USUARIO NO ENCONTRADO!</font>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas H�picas:.</title>
<style>@charset "utf-8";body{margin:0;padding:0;font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;font-size:16px;color:#000;background-color:#E5E5E5;background-repeat:repeat-x;background-image:none;text-align:center}.btn-primary,.btn-primary:hover{color:#fff;text-shadow:0 -1px 0 rgba(0,0,0,0.25)}.btn-primary.active{color:rgba(255,255,255,0.75)}.btn-primary{background-color:#0074cc;*background-color:#05c;background-image:-ms-linear-gradient(top,#08c,#05c);background-repeat:repeat-x;border-color:#05c #05c #003580;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc',endColorstr='#0055cc',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}.btn-success,.btn-success:hover{color:#fff;text-shadow:0 -0.5px 0 rgba(0,0,0,0.25)}.btn-success.active{color:rgba(255,255,255,0.75)}.btn-success{background-color:#1A6F01;*background-color:#1A6F01;background-image:-ms-linear-gradient(top,#1A6F01,#1A6F01);background-repeat:repeat-x;border-color:#1A6F01 #1A6F01 #1A6F01;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#1A6F01',endColorstr='#1A6F01',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}
</style>
</head>
<body>
<?php
    echo'<div style="background:#333;width:100%;float:left;text-align:right;padding:10px 0px 0px 0px;color:#FFF;font-size:28px; text-align:center;line-height:1;">';
    echo'PAGO DE APUESTAS';
    echo'</div>';
    if ($tra_codigo==1) {
        echo '<font color="red"><br/><h3>CLIENTE: '.$cod_cliente.'</h3></font>';
    } else {
        echo '<font color="red"><br/><h3>Ticket#: '.$xTicket.'</h3></font>';
    }
    echo "<h2>".$mensaje."</h2>";?>
	<div style="padding:30px 0px 0px 0px; width:100%; text-align:center">
    <div style="width:30%; text-align:center; display: inline-block;">
	<?php
    if (isset($_GET["pagoSIN"]) && $ver==1 && $row_Recordset1['pag_codigo']==0) {
        $width="50%"; ?>
		<form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
			<input type="hidden" name="MM_update" value="form1">
			<input type="hidden" name="ticket" value="<?php echo $xTicket; ?>">
            <input type="hidden" name="uVenta" value="<?php echo $usuarioPago; ?>">
            <?php
            if ($tra_codigo==1) {?>
				<input type="hidden" name="ser_venta" value="<?php echo $ser_venta; ?>">
                <div style="width:100%;float:left;text-align:right;color:#000;font-size:14px; padding:0 0 15px 0;
                    text-align:center;">
                    PRESIONE ACEPTAR PARA PROCESAR EL TICKET
                </div><?php
            } else {?>
                <div style="width:100%;float:left;text-align:right;color:#000;font-size:14px; padding:0 0 15px 0;
                    text-align:center;">
    POR FAVOR, INDIQUE LOS <br/>3 DIGITOS DEL CODIGO DE TICKET:
                    <input type="text" name="ser_venta" id="ser_venta" style="height:20px; width:150px; font-size:16px" value="" 
                        size="10" onkeypress="ValidaSoloNumeros()" title="indique codigo de pago" required max="100"/>
                </div><?php
            } ?>
            <div style="width:50%;float:left;text-align:right;color:#FFF;font-size:28px;
            	text-align:center;">
                <input type="submit" style="width:120px; font-size:18px; height:50px" title="pagar apuesta" value="Aceptar" 
                class="btn-success"/>	
            </div>
        </form>
	<?php
    } else {
        $width="100%";
    }?>
	<div style="width:<?php echo $width; ?>;float:left;text-align:right;color:#FFF;font-size:28px; text-align:center;">
		<input type="button" style="width:120px; font-size:18px; height:50px" title="volver" value="Volver" 
		class="btn-primary" 
		onclick="location.href = '../ventasmie/pag_tic_sincodigo.php?recordID=<?php echo "1";?>&uVenta=<?php echo $usuarioPago;?>'"/>	
	</div>
    </div>
    </div>
</body>
</html>
<script language="javascript">
function ValidaSoloNumeros(){if (event.keyCode != 46){if ((event.keyCode < 48) || (event.keyCode > 57)) event.returnValue = false;}}
if(typeof document.getElementById("ser_venta") !== 'undefined'){document.getElementById("ser_venta").focus();}
</script>
<?php
if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
if (isset($Recordset3)) {
    mysqli_free_result($Recordset3);
}
if (isset($Recordset7)) {
    mysqli_free_result($Recordset7);
}
?>
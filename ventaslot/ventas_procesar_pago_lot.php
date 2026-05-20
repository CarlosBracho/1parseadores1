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
    $mensaje="¡NO ENCONTRADO!";
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventaslot\ventas_procesar_pago_lot.php - QUERY 1 */ SELECT ve.ticket_lot, ve.ser_ticket_lot, tp.pag_codigo_lot, ta.cod_taquilla
	FROM 
		venta_lot ve, 
		usuario us,
		taquilla ta, 
		taquilla_opc_lot tp
	WHERE 
		ve.ticket_lot = %s AND 
		ve.est_ticket_lot != 0 AND
		us.id_usuario = ve.id_usuario AND
		ta.cod_taquilla = us.cod_taquilla AND 
		tp.cod_taquilla = ta.cod_taquilla LIMIT 1",
    GetSQLValueString($xTicket, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$pag_codigo=$row_Recordset1['pag_codigo_lot'];
$editFormAction = $_SERVER['PHP_SELF'];
$query_Recordset19 = sprintf("/* PARSEADORES1 ventaslot\ventas_procesar_pago_lot.php - QUERY 2 */ SELECT est_control_pagos_lot FROM ctrol_ventpag_global_lot LIMIT 1");
$Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
$row_Recordset19 = mysqli_fetch_assoc($Recordset19);
$totalRows_Recordset19 = mysqli_num_rows($Recordset19);
$est_control_pagos=$row_Recordset19['est_control_pagos_lot'];
if (isset($Recordset19)) {
    mysqli_free_result($Recordset19);
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ($pag_codigo==1) {
    $_POST["MM_update"]="form1";
    $_POST["ticket"]=$_GET["pagoSIN"];
    $_POST["ser_ticket_lot"]=substr($row_Recordset1['ser_ticket_lot'], 0, 3);
    $_POST["uVenta"]=$_GET["uVenta"];
    $ver=0;
    $_POST["ser_ticket_lot"]=substr($row_Recordset1['ser_ticket_lot'], 0, 2).substr($row_Recordset1['ticket_lot'], 0, 1);
}
if (isset($_POST["MM_update"]) && $_POST["MM_update"] == "form1" && isset($_POST["ticket"]) && isset($_POST["uVenta"])) {
    $ver=0;
    if ($totalRows_Recordset1>0 && $est_control_pagos==0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 ventaslot\ventas_procesar_pago_lot.php - QUERY 3 */ SELECT 
				SUM(ve.pag_premio_lot) AS total_premio,
				ve.fec_venta_lot,
				ve.ticket_lot, 
				ve.ser_ticket_lot, 
				ve.est_ticket_lot,
				us.id_usuario, 
				tp.pag_codigo_lot,
				tp.tic_caduca_lot,
				ta.cod_taquilla, 
				IF(ve.fec_venta_lot = %s,(IF(bl.hor_cierre < %s,0,1)),0) AS est_pago
			FROM 
				banca ba, agencia ag, taquilla ta, taquilla_opc_lot tp, venta_lot ve, usuario us, bancaloterias bl
			WHERE 
				ve.ticket_lot = %s AND
				us.cod_taquilla = ta.cod_taquilla AND 
				us.id_usuario = ve.id_usuario AND
				us.id_usuario = %s AND 
				tp.cod_taquilla = ta.cod_taquilla AND 
				ve.est_ticket_lot != 0 AND
				(ve.est_calculo_lot = 2 OR ve.est_calculo_lot = 5) AND
				ag.cod_agencia = ta.cod_agencia AND
				ba.cod_banca = ag.cod_banca AND
				bl.id_banca = ba.cod_banca AND
				ve.id_loteria = bl.id_loteria
			GROUP BY ve.ticket_lot DESC
			ORDER BY ve.num_ticket_lot ASC, ve.est_ticket_lot DESC",
            GetSQLValueString(fechaactualbd(), "date"),
            GetSQLValueString(horaactual2(), "date"),
            GetSQLValueString($_POST["ticket"], "int"),
            GetSQLValueString($_POST["uVenta"], "int")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        if ($totalRows_Recordset2>0) {
            if ($row_Recordset1['cod_taquilla']==$row_Recordset2['cod_taquilla']) {
                $serial=substr($row_Recordset2['ser_ticket_lot'], 0, 2).substr($row_Recordset2['ticket_lot'], 0, 1);
                //echo $_POST["ser_ticket_lot"]." * ".$serial;
                if (isset($_POST["ser_ticket_lot"]) && $_POST["ser_ticket_lot"]==$serial) {
                    if ($row_Recordset2['est_ticket_lot']==1) {
                        if ($row_Recordset2['est_pago']==0) {
                            $mensaje='<font color="green"><h4><strong>TICKET GANADOR</strong></h4></font>';
                            $query_Recordset3 = sprintf("/* PARSEADORES1 ventaslot\ventas_procesar_pago_lot.php - QUERY 4 */ SELECT num_ticket_lot, ve.est_calculo_lot, ve.pag_premio_lot
								FROM venta_lot ve 
								WHERE  ve.ticket_lot = %s AND ve.pag_premio_lot > 0", GetSQLValueString($_POST["ticket"], "int"));
                            $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                            $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                            $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                            if ($totalRows_Recordset3>0) {
                                $horaPago=horaactual();
                                $ipPago=getRealIP();
                                $fecpago=fechaactualbd();
                                $montoapagar=0;
                                do {
                                    $updateSQL = sprintf(
                                        "/* PARSEADORES1 ventaslot\ventas_procesar_pago_lot.php - QUERY 5 */ UPDATE venta_lot
										SET est_ticket_lot=%s, fec_pago_lot=%s, cod_usuario_pago_lot=%s, 
										ip_pago_lot=%s, hor_pago_lot=%s
										WHERE num_ticket_lot=%s",
                                        GetSQLValueString($row_Recordset3['est_calculo_lot'], "int"),
                                        GetSQLValueString($fecpago, "date"),
                                        GetSQLValueString($_POST["uVenta"], "int"),
                                        GetSQLValueString($ipPago, "text"),
                                        GetSQLValueString($horaPago, "date"),
                                        GetSQLValueString($row_Recordset3['num_ticket_lot'], "int")
                                    );
                                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                    $montoapagar=$montoapagar+$row_Recordset3['pag_premio_lot'];
                                } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
                                $mensaje.='<font color="red"><strong>Monto a pagar: '.number_format($montoapagar, 2, ",", ".").'</strong></font>';
                            } else {
                                $mensaje='<font color="red"><h3><strong>TICKET NO GANADOR!</strong></h3></font>';
                            }
                        } else {
                            $mensaje="<font color='red'>¡NO PUEDE SER AUN PROCESADO!<br/><p style='font-size:12px;color:#000000;'>ALGUNAS JUGADAS POSEEN SORTEOS ABIERTOS!</p></font>";
                        }
                    } elseif ($row_Recordset2['est_ticket_lot']>=2) {
                        $mensaje="<h3><strong>TICKET YA FUE PROCESADO!</strong></h3>";
                    }
                } else {
                    $mensaje="<font color='red'>¡ERROR EN CODIGO DE PAGO!</font>";
                    $ver=1;
                }
            } else {
                $mensaje="<font color='red'>¡TICKET NO PUEDE SER ELIMINADO POR ESTA TAQUILLA!</font>";
            }
        } else {
            $mensaje="<font color='red'>¡TICKET NO ENCONTRADO!</font>";
        }
    } else {
        if ($totalRows_Recordset1>0) {
            $mensaje="<font color='red'>¡TICKET NO ENCONTRADO!</font>";
        } elseif ($est_control_pagos==1) {
            $mensaje='<font size="5" color="red">EN ESTOS MOMENTOS LOS PAGOS ESTAN PAUSADOS';
            $mensaje.='<BR/>POR FAVOR INTENTE MAS TARDE</font>';
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<style>@charset "utf-8";body{margin:0;padding:0;font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;font-size:16px;color:#000;background-color:#E5E5E5;background-repeat:repeat-x;background-image:none;text-align:center}.btn-primary,.btn-primary:hover{color:#fff;text-shadow:0 -1px 0 rgba(0,0,0,0.25)}.btn-primary.active{color:rgba(255,255,255,0.75)}.btn-primary{background-color:#0074cc;*background-color:#05c;background-image:-ms-linear-gradient(top,#08c,#05c);background-repeat:repeat-x;border-color:#05c #05c #003580;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc',endColorstr='#0055cc',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}.btn-success,.btn-success:hover{color:#fff;text-shadow:0 -0.5px 0 rgba(0,0,0,0.25)}.btn-success.active{color:rgba(255,255,255,0.75)}.btn-success{background-color:#1A6F01;*background-color:#1A6F01;background-image:-ms-linear-gradient(top,#1A6F01,#1A6F01);background-repeat:repeat-x;border-color:#1A6F01 #1A6F01 #1A6F01;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#1A6F01',endColorstr='#1A6F01',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}
</style>
</head>
<body>
<?php
    echo'<div style="background:#333;width:100%;float:left;text-align:right;padding:10px 0px 0px 0px;color:#FFF;font-size:28px; text-align:center;line-height:1;">';
    echo'PAGO DE APUESTAS LOTERIAS';
    echo'</div>';

    echo '<font color="red"><br/><h3>Ticket#: '.$xTicket.'</h3></font>';
    echo "<h2>".$mensaje."</h2>";?>
	<div style="padding:30px 0px 0px 0px; width:100%; text-align:center">
    <div style="width:30%; text-align:center; display: inline-block;">
	<?php
    if (isset($_GET["pagoSIN"]) && $ver==1 && $pag_codigo==0) {
        $width="50%"; ?>
		<form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
			<input type="hidden" name="MM_update" value="form1">
			<input type="hidden" name="ticket" value="<?php echo $xTicket; ?>">
            <input type="hidden" name="uVenta" value="<?php echo $usuarioPago; ?>">
            <div style="width:100%;float:left;text-align:right;color:#000;font-size:14px; padding:0 0 15px 0;
            	text-align:center;">
                POR FAVOR, INDIQUE LOS <br/>3 PRIMEROS DIGITOS DEL CODIGO DE PAGO:
				<input type="text" name="ser_ticket_lot" id="ser_ticket_lot" 
                	style="height:20px; width:150px; font-size:16px" value="" 
					size="10" onkeypress="ValidaSoloNumeros()" title="indique codigo de pago" required max="100"/>
            </div>
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
		<input type="hidden" id="ser_ticket_lot" value=""/>
		<input type="button" style="width:120px; font-size:18px; height:50px" title="volver" value="Volver" 
		class="btn-primary" 
		onclick="location.href = '../ventaslot/pagar_ticket_lot.php?uVenta=<?php echo $usuarioPago;?>'"/>	
	</div>
    </div>
    </div>
</body>
</html>
<script language="javascript">
function ValidaSoloNumeros(){if (event.keyCode != 46){if ((event.keyCode < 48) || (event.keyCode > 57)) event.returnValue = false;}}
if(typeof document.getElementById("ser_ticket_lot") !== 'undefined'){document.getElementById("ser_ticket_lot").focus();}
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
?>
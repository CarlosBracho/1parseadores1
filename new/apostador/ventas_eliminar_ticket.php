<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "C"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
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
    "/* PARSEADORES1 new\apostador\ventas_eliminar_ticket.php - QUERY 1 */ SELECT ve.ser_venta, ve.tra_codigo, ve.cod_cliente, tp.pag_codigo
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

$pag_codigo=$row_Recordset1['pag_codigo'];
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
    if ($totalRows_Recordset1>0) {
        $query_Recordset1 = sprintf("/* PARSEADORES1 new\apostador\ventas_eliminar_ticket.php - QUERY 2 */ SELECT us.tic_eliminados, us.cod_taquilla, tp.pag_codigo
			FROM usuario us, taquilla_opc_ame tp WHERE id_usuario = %s AND us.cod_taquilla = tp.cod_taquilla  
			LIMIT 1", GetSQLValueString($_POST["uVenta"], "int"));
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        $pag_codigo=$row_Recordset1['pag_codigo'];
        if (BuscarTicketEliminados($_POST["uVenta"], fechaactualbd())<$row_Recordset1['tic_eliminados']) {
            $query_Recordset2 = sprintf(
                "/* PARSEADORES1 new\apostador\ventas_eliminar_ticket.php - QUERY 3 */ SELECT 
					ve.est_ticket, 
					ve.id_usuario, 
					ve.ser_venta,
					ve.cod_taquilla,
					ve.mon_venta,
					ve.efectivoO,
					ca.est_carrera, 
					ca.hor_carrera,
					ta.saldoactual,
					ta.tipo_pago,
					ta.tipotaquilla,
					ta.cod_agencia,
					ag.saldoactuala,
					ve.efectivoO,
					ag.tipo_pagoa
				FROM 
					venta ve, carrera ca, taquilla ta, agencia ag
				WHERE 
				ta.cod_agencia = ag.cod_agencia AND
				    ve.cod_taquilla = ta.cod_taquilla AND
					ve.cod_carrera = ca.cod_carrera AND 
					ve.ticket = %s AND
					ca.fec_carrera = %s",
                GetSQLValueString($_POST["ticket"], "int"),
                GetSQLValueString(fechaactualbd(), "date")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            $cod_agencia=$row_Recordset2['cod_agencia'];
            $saldoactuala=$row_Recordset2['saldoactuala'];
            $tipo_pagoa=$row_Recordset2['tipo_pagoa'];
            if ($totalRows_Recordset2>0) {
                $saldoactual=$row_Recordset2['saldoactual'];
                $tipotaquilla=$row_Recordset2['tipotaquilla'];
                $tipo_pago=$row_Recordset2['tipo_pago'];
                $efectivoO=$row_Recordset2['efectivoO'];
                $monto=$row_Recordset2['mon_venta'];
                $codigoTaquilla=$row_Recordset2['cod_taquilla'];
                if ($row_Recordset1['cod_taquilla']==$row_Recordset2['cod_taquilla']) {
                    if (isset($_POST["ser_venta"]) && $_POST["ser_venta"]==substr($row_Recordset2['ser_venta'], 0, 3)) {
                        if ($row_Recordset2['est_ticket']==1) {
                            if ($row_Recordset2['est_carrera']==1 or $row_Recordset2['hor_carrera']>=horaactual()) {
                                $mensaje="<font color='red'>¡SE ELIMINO CORRECTAMENTE!<br/></font>";
                                if ($row_Recordset2['efectivoO']==0) {
                                    $mensaje=$mensaje.'<font size="30" color="black"><h2>REALIZADA EN<br/>EFECTIVO'.'</h2></font>';
                                }
                                if ($row_Recordset2['efectivoO']==1) {
                                    $mensaje=$mensaje.'<font size="30" color="black"><h2>REALIZADA EN<br/>DEBITO'.'</h2></font>';
                                }
                                if ($row_Recordset2['efectivoO']==2) {
                                    $mensaje=$mensaje.'<font size="30" color="black"><h2>REALIZADA EN<br/>TRANSFERENCIA'.'</h2></font>';
                                }
                                if ($row_Recordset2['efectivoO']==3) {
                                    $mensaje=$mensaje.'<font size="30" color="black"><h2>REALIZADA EN<br/>DOLAR AMERICANO'.'</h2></font>';
                                }
                                if ($row_Recordset2['efectivoO']==4) {
                                    $mensaje=$mensaje.'<font size="30" color="black"><h2>REALIZADA EN<br/>PESO COLOMBIANO'.'</h2></font>';
                                }
                                if ($row_Recordset2['efectivoO']==5) {
                                    $mensaje=$mensaje.'<font size="30" color="black"><h2>REALIZADA EN<br/>SOL PERUANO'.'</h2></font>';
                                }
                                $query_Recordset3 = sprintf("/* PARSEADORES1 new\apostador\ventas_eliminar_ticket.php - QUERY 4 */ SELECT num_ticket 
									FROM venta ve 
									WHERE  ve.ticket = %s", GetSQLValueString($_POST["ticket"], "int"));
                                $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                                $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                                $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                                if ($totalRows_Recordset3>0) {
                                    $horaPago=horaactual();
                                    $ipPago=getRealIP();
                                    $fecpago=fechaactualbd();
                                    do {
                                        $numTicket=$row_Recordset3['num_ticket'];
                                        $updateSQL = sprintf(
                                            "/* PARSEADORES1 new\apostador\ventas_eliminar_ticket.php - QUERY 5 */ UPDATE venta 
										   SET est_ticket=%s, fec_pago=%s, cod_usuario_pago=%s, ip_pago=%s, hor_pago=%s 
											   WHERE num_ticket=%s",
                                            GetSQLValueString(0, "int"),
                                            GetSQLValueString($fecpago, "date"),
                                            GetSQLValueString($_POST["uVenta"], "int"),
                                            GetSQLValueString($ipPago, "text"),
                                            GetSQLValueString($horaPago, "date"),
                                            GetSQLValueString($numTicket, "int")
                                        );
                                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                        
                                        
                                        if ($row_Recordset2['efectivoO']<=2) {
                                            $montobss=$monto;
                                        } else {
                                            $montobss=0;
                                        }
                                        if ($row_Recordset2['efectivoO']==3) {
                                            $montousd=$monto;
                                        } else {
                                            $montousd=0;
                                        }
                                        if ($row_Recordset2['efectivoO']==4) {
                                            $montocop=$monto;
                                        } else {
                                            $montocop=0;
                                        }
                                        if ($row_Recordset2['efectivoO']==5) {
                                            $montosol=$monto;
                                        } else {
                                            $montosol=0;
                                        }
                
                                        $insertSQL16 = sprintf(
                                            "/* PARSEADORES1 new\apostador\ventas_eliminar_ticket.php - QUERY 6 */ UPDATE taquilla 
				SET
				saldoactual=saldoactual+%s,
				saldoactualusd=saldoactualusd+%s,
				saldoactualcop=saldoactualcop+%s,
				saldoactualsol=saldoactualsol+%s											
				WHERE 
				cod_taquilla=%s",
                                            GetSQLValueString($montobss, "double"),
                                            GetSQLValueString($montousd, "double"),
                                            GetSQLValueString($montocop, "double"),
                                            GetSQLValueString($montosol, "double"),
                                            GetSQLValueString($codigoTaquilla, "int")
                                        );

                                        $Result16 = mysqli_query($conexionbanca, $insertSQL16) or die(mysqli_error($conexionbanca));
                                        
                                    



                                        if ($tipo_pagoa==1) {
                                            $query_Recordset55 = sprintf(
                                                "
/* PARSEADORES1 new\apostador\ventas_eliminar_ticket.php - QUERY 7 */ SELECT * FROM tasadecambio
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
                                            if ($efectivoO<=2) {
                                                $tasa=1;
                                            }
                                            if ($efectivoO==3) {
                                                $tasa=$usdabss;
                                            }
                                            if ($efectivoO==4) {
                                                $tasa=$copabss;
                                            }
                                            if ($efectivoO==5) {
                                                $tasa=$solabss;
                                            }
                                            


                                            $montoapuesta=$monto*$tasa;
                                            $insertSQL155 = sprintf(
                                                "/* PARSEADORES1 new\apostador\ventas_eliminar_ticket.php - QUERY 8 */ UPDATE agencia 
				SET
				saldoactuala=saldoactuala+%s
				WHERE 
				cod_agencia=%s",
                                                GetSQLValueString($montoapuesta, "double"),
                                                GetSQLValueString($cod_agencia, "int")
                                            );

                                            $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
                                        }
                                    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
                                    $aE=$row_Recordset1['tic_eliminados']-BuscarTicketEliminados($_POST["uVenta"], fechaactualbd());
                                    $mensaje.='<br/><p style="font-size:12px;color:#000000;">Tiene la posibilidad de eliminar '.$aE.' ticket(s) mas por hoy</p>';
                                } else {
                                    $mensaje="<font color='red'>¡SE PRODUJO UN ERROR AL INTENTAR ELIMINAR EL TICKET!</font>";
                                }
                            } else {
                                $mensaje="<font color='red'>¡NO PUEDE SER ELIMINADO!<br/><br/>CARRERA CERRADA!</font>";
                            }
                        } else {
                            $mensaje="<font color='red'>¡HA SIDO ELIMINADO ANTERIORMENTE!</font>";
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
            $mensaje="<br/><br/>HA SUPERADO EL MAXIMO DE TICKET A ELIMINAR";
        }
    } else {
        $mensaje="<font color='red'>¡TICKET NO ENCONTRADO!</font>";
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
    echo'ELIMINAR TICKETS';
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
    if (isset($_GET["pagoSIN"]) && $ver==1 && $pag_codigo==0) {
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
                    PRESIONE ACEPTAR PARA ELIIMINAR EL TICKET
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
		onclick="location.href = 'eli_tic_sincodigo.php?uVenta=<?php echo $usuarioPago;?>'"/>	
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
?>
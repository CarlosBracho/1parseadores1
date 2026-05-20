<?php
include("../includes/libreria.php");
require_once('../Connections/conexionbanca.php');
$insertGoTo = "index.php";
$query_Recordset19 = sprintf("/* PARSEADORES1 new\ventaslot\guardar_ticket.php - QUERY 1 */ SELECT est_control_ventas_lot, est_control_pagos_lot
	FROM ctrol_ventpag_global_lot LIMIT 1");
$Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
$row_Recordset19 = mysqli_fetch_assoc($Recordset19);
$totalRows_Recordset19 = mysqli_num_rows($Recordset19);
$est_control_ventas=$row_Recordset19['est_control_ventas_lot'];
if (isset($Recordset19)) {
    mysqli_free_result($Recordset19);
}
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"] == "form1" && $_SESSION["ocarrito"]->sumar_carrito()>0 &&
    $est_control_ventas==0) {
    $query_Recordset6 = sprintf("/* PARSEADORES1 new\ventaslot\guardar_ticket.php - QUERY 2 */ SELECT tp.mon_minticket_lot
		FROM taquilla_opc_lot tp WHERE tp.cod_taquilla = %s LIMIT 1", GetSQLValueString($_POST['taquilla'], "int"));
    $Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
    $row_Recordset6 = mysqli_fetch_assoc($Recordset6);
    $totalRows_Recordset6 = mysqli_num_rows($Recordset6);
    $totalCarrito=$_SESSION["ocarrito"]->sumar_carrito();
    if ($totalCarrito>=$row_Recordset6['mon_minticket_lot']) {
        $ipVe=getRealIP(); //ip venta
        $nTic=$_POST['usuario'].ultimaVentaLot(); //nro ticket
        $serT=generarCodigo(5, $nTic); //serial ticket
        $staT=1;	//estatus ticket
        $cAge=$_POST['agencia']; // cod agencia
        $cTaq=$_POST['taquilla']; //cod taquilla
        $cLot=$_SESSION["ocarrito"]->enviar_carrito(1); 	// extrae codigo loterias
        $xsig=$_SESSION["ocarrito"]->enviar_carrito(2);		// extrae codigo signo
        $xnum=$_SESSION["ocarrito"]->enviar_carrito(3);	// extrae numero a apostar
        $xmon=$_SESSION["ocarrito"]->enviar_carrito(4);	// extrae monto de apuesta
        unset($_SESSION["ocarrito"]);
        $_SESSION["ocarrito"] = new carrito();
        $xhoy=fechaactualbd();
        $xhAc=horaactual();
        $cantTicket=ObtenerNumeroJugada_lot($_POST['usuario'], $xhoy, 1)+1;
        if (sizeof($cLot)>0) {
            if ($_POST['con_tope']==2) {
                $query_Recordset11 = sprintf(
                    "/* PARSEADORES1 new\ventaslot\guardar_ticket.php - QUERY 3 */ SELECT ba.top_triple_lot, ba.top_terminal_lot FROM banca ba
				WHERE cod_banca = %s LIMIT 1",
                    GetSQLValueString($_POST['banca'], "int")
                );
                $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
                $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
                $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
                $topeVentaTer=$row_Recordset1['top_terminal_lot'];
                $topeVentaTri=$row_Recordset1['top_triple_lot'];
                mysqli_free_result($Recordset11);
            }
            $x=0;
            //NombreAlerta(1,"Una o varias apuestas no se realizaron según lo solicitado! Por favor revise la jugada");
            $yu=1;
            foreach ($cLot as $xlot) {
                if ($xlot!=0) {
                    //echo $xnum[$x]." ".$xmon[$x]." ".$xlot." ".$xsig[$x]."<br/> ";
                    //echo $_POST['banca']." ".$_POST['agencia']." ".$_POST['usuario']."<br/> ";
                    $xhCi=horaCierreSorteo($xlot, $_POST['banca']);
                    $tLot=tipoLoterias($xlot);
                    if ($_POST['con_tope']<=1) {
                        $xtopeagencia=agenciaTopeLot($_POST['banca'], $_POST['agencia'], $xlot, $_POST['con_tope']);
                    } else {
                        if ($tLot==2) {
                            $xtopeagencia=$topeVentaTer;
                        } else {
                            $xtopeagencia=$topeVentaTri;
                        }
                    }
                    $xmontoVendido=numMontoVendidoLot($_POST['agencia'], $xnum[$x], $xlot, $xsig[$x], $xhoy);
                    $xquedanAgencia=$xtopeagencia-$xmontoVendido;
                    //$staT
                    if ($xhAc<$xhCi) {
                        if ($xquedanAgencia>0) { // pregunta si no ha excedido el limite en agencia
                            if ($xmon[$x]>$xquedanAgencia) {
                                $xmon[$x]=$xquedanAgencia;
                            }
                            // aqui va guaradr en base de datos
                            
                            $yu++;
                            $insertSQL = sprintf(
                                "/* PARSEADORES1 new\ventaslot\guardar_ticket.php - QUERY 4 */ INSERT INTO venta_lot (num_apuesta_lot, mon_apuesta_lot, id_loteria, id_signo, fec_venta_lot, hor_venta_lot, id_usuario, est_ticket_lot, tip_loteria_lot, ticket_lot, ip_venta_lot, ser_ticket_lot, can_ticket_lot, lin_ticket_lot) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($xnum[$x], "text"),
                                GetSQLValueString($xmon[$x], "double"),
                                GetSQLValueString($xlot, "int"),
                                GetSQLValueString($xsig[$x], "int"),
                                GetSQLValueString($xhoy, "date"),
                                GetSQLValueString($xhAc, "date"),
                                GetSQLValueString($_POST['usuario'], "int"),
                                GetSQLValueString($staT, "int"),
                                GetSQLValueString($tLot, "int"),
                                GetSQLValueString($nTic, "int"),
                                GetSQLValueString($ipVe, "text"),
                                GetSQLValueString($serT, "int"),
                                GetSQLValueString($cantTicket, "int"),
                                GetSQLValueString($yu, "int")
                            );
                            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                        } else {
                            $bandera=1;
                            $eTope="(EXCEDE TOPE)";
                        }
                    } else {
                        $bandera=1;
                        $eHora="(SORTEO CERRADO)";
                    } // fin comparacion de horas
                }
                $x++;
            } // fin bucle array codigo loterias
            $insertGoTo = "ventas_imprimir_ticket_lot.php?recordID=$nTic";
            if (isset($_SERVER['QUERY_STRING'])) {
                $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                $insertGoTo .= $_SERVER['QUERY_STRING'];
            } else {
                $insertGoTo = "index.php";
            }
            header(sprintf("Location: %s", $insertGoTo));
        }
    } else {
        $insertGoTo = "index.php?mensID=1&valorID=".$row_Recordset6['mon_minticket_lot'];
    }
} else {
    $insertGoTo = "index.php";
}
if ($est_control_ventas==1) {
    $_SESSION['MM_mensaje1']="VENTAS PAUSADAS MOMENTANEAMENTE<br/>TICKET NO GUARDADO";
}
 
header(sprintf("Location: %s", $insertGoTo));

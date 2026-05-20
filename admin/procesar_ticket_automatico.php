<?php
if (isset($_POST["recordID"])) {
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once('../Connections/conexionbanca.php');
    if (is_file('../includes/calculodepago.php')) {
        include("../includes/calculodepago.php");
    }

    $xTicket_Recordset1 = $_POST["recordID"];
    $query_Recordset11 = sprintf(
        "/* PARSEADORES1 admin\procesar_ticket_automatico.php - QUERY 1 */ SELECT * 
		FROM 
			venta, carrera 
		WHERE 
			venta.ticket = %s AND 
			venta.cod_carrera = carrera.cod_carrera",
        GetSQLValueString($xTicket_Recordset1, "int")
    );
    $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
    $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
    $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
    do {
        $_nTi=$row_Recordset11['num_ticket'];
        $updateSQL11 = sprintf(
            "/* PARSEADORES1 admin\procesar_ticket_automatico.php - QUERY 2 */ UPDATE venta 
			SET est_ticket=%s, pag_premio=%s 
			WHERE num_ticket=%s",
            GetSQLValueString(1, "int"),
            GetSQLValueString(0, "double"),
            GetSQLValueString($_nTi, "int")
        );
        $Result11 = mysqli_query($conexionbanca, $updateSQL11) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset11 = mysqli_fetch_assoc($Recordset11));
    //----------------------------------------
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 admin\procesar_ticket_automatico.php - QUERY 3 */ SELECT * 
		FROM 
			venta, carrera 
		WHERE 
			venta.ticket = %s AND 
			venta.cod_carrera = carrera.cod_carrera",
        GetSQLValueString($xTicket_Recordset1, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $xVendedor=$row_Recordset1['id_usuario'];
    $query_Recordset3 = sprintf(
        "/* PARSEADORES1 admin\procesar_ticket_automatico.php - QUERY 4 */ SELECT * 
	FROM 
	usuario, taquilla, taquilla_opc_ame 
	WHERE 
	usuario.id_usuario = %s AND
	taquilla.cod_taquilla = usuario.cod_taquilla AND
	taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla",
        GetSQLValueString($xVendedor, "int")
    );
    $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
    $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
    $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
    $query_Recordset4 = sprintf(
        "/* PARSEADORES1 admin\procesar_ticket_automatico.php - QUERY 5 */ SELECT num_caballo, cod_tventa 
								 FROM venta, carrera 
								 WHERE venta.ticket = %s AND venta.cod_carrera = carrera.cod_carrera AND est_ticket=1",
        GetSQLValueString($xTicket_Recordset1, "int")
    );
    $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
    $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
    $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
    $retiro2=0;
    $codigoCarrera=$row_Recordset1['cod_carrera'];
    $retirados=arrayRetirados($codigoCarrera);
    if ($totalRows_Recordset4>0) {
        do {
            if ($retirados[0]!="0") {
                if (in_array($row_Recordset4['num_caballo'], $retirados, true)) {
                    $retiro2=1;
                }
                if ((int)$row_Recordset4['cod_tventa']>=4 && (int)$row_Recordset4['cod_tventa']<=9) {
                    $fcab=explode("-", $row_Recordset4['num_caballo']);
                    foreach ($fcab as $mtz1) {
                        if (in_array($mtz1, $retirados, true)) {
                            $retiro2=1;
                            break;
                        }
                    }
                }
            }
            if ($retiro2==1) {
                break;
            }
        } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
    }
    $montoapagar=0;
    $montoretiro=0;
    $i=0;
    $estado=array(0);
    $_nTicket=array(0);
    $premio[$i]=array(0);
    $h=0;


    //--------------
    do {
        $pago[0]=0;
        $pago[1]="";
        $retiro=0;
        if ($retirados[0]!="0") {
            if (in_array($row_Recordset1['num_caballo'], $retirados, true)) {
                $retiro=1;
            }
            if ((int)$row_Recordset1['cod_tventa']>=4 && (int)$row_Recordset1['cod_tventa']<=9) {
                $fcab=explode("-", $row_Recordset1['num_caballo']);
                foreach ($fcab as $mtz1) {
                    if (in_array($mtz1, $retirados, true)) {
                        $retiro=1;
                        break;
                    }
                }
            }
        }
        if ($retiro==0) {
            if ($row_Recordset1['est_confirmacion']==0) {
                $anuReg=$row_Recordset3['anu_regalia'];
                if ($row_Recordset1['cod_tventa']>=1 && $row_Recordset1['cod_tventa']<=3) {
                    if ($row_Recordset1['cod_tventa']==1) {
                        $topJugada=$row_Recordset3['max_aganar_gan'];
                        $regalo=$row_Recordset3['reg_gan'];
                    }
                    if ($row_Recordset1['cod_tventa']==2) {
                        $topJugada=$row_Recordset3['max_aganar_pla'];
                        $regalo=$row_Recordset3['reg_pla'];
                    }
                    if ($row_Recordset1['cod_tventa']==3) {
                        $topJugada=$row_Recordset3['max_aganar_sho'];
                        $regalo=$row_Recordset3['reg_sho'];
                    }
                    $pago=jNormal(
                        $row_Recordset1['num_caballo'],
                        $row_Recordset1['cod_tventa'],
                        $row_Recordset1['mon_venta'],
                        $row_Recordset1['eje_primero'],
                        $row_Recordset1['eje_doble_primero'],
                        $row_Recordset1['eje_triple_primero'],
                        $row_Recordset1['div_primero_gan'],
                        $row_Recordset1['div_primero_pla'],
                        $row_Recordset1['div_primero_sho'],
                        $row_Recordset1['div_doble_primero_gan'],
                        $row_Recordset1['div_doble_primero_pla'],
                        $row_Recordset1['div_doble_primero_sho'],
                        $row_Recordset1['div_triple_primero_gan'],
                        $row_Recordset1['div_triple_primero_pla'],
                        $row_Recordset1['div_triple_primero_sho'],
                        $row_Recordset1['eje_segundo'],
                        $row_Recordset1['eje_doble_segundo'],
                        $row_Recordset1['eje_triple_segundo'],
                        $row_Recordset1['div_segundo_pla'],
                        $row_Recordset1['div_segundo_sho'],
                        $row_Recordset1['div_doble_segundo_pla'],
                        $row_Recordset1['div_doble_segundo_sho'],
                        $row_Recordset1['div_triple_segundo_pla'],
                        $row_Recordset1['div_triple_segundo_sho'],
                        $row_Recordset1['eje_tercero'],
                        $row_Recordset1['eje_doble_tercero'],
                        $row_Recordset1['eje_triple_tercero'],
                        $row_Recordset1['div_tercero_sho'],
                        $row_Recordset1['div_doble_tercero_sho'],
                        $row_Recordset1['div_triple_tercero_sho'],
                        $topJugada,
                        $regalo,
                        $anuReg
                    );
                    if ($pago[0]>0) {
                        $montoapagar=$pago[0]+$montoapagar;
                        $premio[$i]=$pago[0];
                        $_nTicket[$i]=$row_Recordset1['num_ticket'];
                        $estado[$i]=$pago[1];
                        $i=$i+1;
                    }
                }
                if ($row_Recordset1['cod_tventa']>=4 && $row_Recordset1['cod_tventa']<=9) {
                    if ($row_Recordset1['cod_tventa']==4 || $row_Recordset1['cod_tventa']==7) {
                        $fact=$row_Recordset1['fac_exacta'];
                        $topJugada=$row_Recordset3['max_aganar_exa'];
                        $regalo=$row_Recordset3['reg_exa'];
                    }
                    if ($row_Recordset1['cod_tventa']==5 || $row_Recordset1['cod_tventa']==8) {
                        $fact=$row_Recordset1['fac_trifecta'];
                        $topJugada=$row_Recordset3['max_aganar_tri'];
                        $regalo=$row_Recordset3['reg_tri'];
                    }
                    if ($row_Recordset1['cod_tventa']==6 || $row_Recordset1['cod_tventa']==9) {
                        $fact=$row_Recordset1['fac_superfecta'];
                        $topJugada=$row_Recordset3['max_aganar_sup'];
                        $regalo=$row_Recordset3['reg_sup'];
                    }
                    $base=2;
                    $pago=jExotica2(
                        $row_Recordset1['num_caballo'],
                        $row_Recordset1['cod_tventa'],
                        $row_Recordset1['mon_venta'],
                        $row_Recordset1['div_exacta'],
                        $row_Recordset1['ord_exacta'],
                        $row_Recordset1['div_trifecta'],
                        $row_Recordset1['ord_trifecta'],
                        $row_Recordset1['div_superfecta'],
                        $row_Recordset1['ord_superfecta'],
                        $row_Recordset1['div_exacta_doble'],
                        $row_Recordset1['ord_exacta_doble'],
                        $row_Recordset1['div_trifecta_doble'],
                        $row_Recordset1['ord_trifecta_doble'],
                        $row_Recordset1['div_superfecta_doble'],
                        $row_Recordset1['ord_superfecta_doble'],
                        $row_Recordset1['div_exacta_triple'],
                        $row_Recordset1['ord_exacta_triple'],
                        $row_Recordset1['div_trifecta_triple'],
                        $row_Recordset1['ord_trifecta_triple'],
                        $row_Recordset1['div_superfecta_triple'],
                        $row_Recordset1['ord_superfecta_triple'],
                        $topJugada,
                        $regalo,
                        $fact,
                        $base
                    );
                    if ($pago[0]>0) {
                        $montoapagar=$pago[0]+$montoapagar;
                        $premio[$i]=$pago[0];
                        $_nTicket[$i]=$row_Recordset1['num_ticket'];
                        $estado[$i]=$pago[1];
                        $i=$i+1;
                    }
                }
            } else {
                if ($retiro2==1) {
                    $montoapagar=$montoapagar+$row_Recordset1['mon_venta'];
                    $premio[$i]=$row_Recordset1['mon_venta'];
                    $_nTicket[$i]=$row_Recordset1['num_ticket'];
                    $estado[$i]=5;
                    $i=$i+1;
                }
            }
        } else {
            $montoretiro=$montoretiro+$row_Recordset1['mon_venta'];
            $_nTicket[$i]=$row_Recordset1['num_ticket'];
            $premio[$i]=$row_Recordset1['mon_venta'];
            $estado[$i]="4";
            $i=$i+1;
        }
        $xTic2[$h]=$row_Recordset1['num_ticket'];
        $h++;
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    $montoapagar=$montoapagar+$montoretiro;
    $x=0;
    $dev2=0;
    $dev4=0;
    $dev5=0;
    if ($montoapagar>0) {
        do {
            if ($_POST["est_ticket"]!=6) {
                $estado[$x]=$_POST["est_ticket"];
            }
            $updateSQL = sprintf(
                "/* PARSEADORES1 admin\procesar_ticket_automatico.php - QUERY 6 */ UPDATE venta 
				SET est_ticket=%s, pag_premio=%s 
				WHERE num_ticket=%s",
                GetSQLValueString($estado[$x], "int"),
                GetSQLValueString($premio[$x], "double"),
                GetSQLValueString($_nTicket[$x], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
            if ($estado[$x]==5) {
                $dev5=1;
            }
            if ($estado[$x]==4) {
                $dev4=1;
            }
            if ($estado[$x]==2) {
                $dev2=1;
            }
            $x++;
        } while ($x < $i);
    }
    $x=0;
    do {
        $updateSQL2 = sprintf(
            "/* PARSEADORES1 admin\procesar_ticket_automatico.php - QUERY 7 */ UPDATE venta SET est_calculo=%s WHERE num_ticket=%s",
            GetSQLValueString(1, "int"),
            GetSQLValueString($xTic2[$x], "int")
        );
        $Result2 = mysqli_query($conexionbanca, $updateSQL2) or die(mysqli_error($conexionbanca));
        $x++;
    } while ($x < $h);
    print"<hr/>";
    if ($montoapagar>0) {
        if ($retiro2==0 && $dev2==1 && $dev4==0 && $dev5==0) {
            echo '<font color="red"><h3><strong>TICKET GANADOR!</strong></h3></font>';
        } else {
            if (($dev5==1 || $dev4==1 || $retiro2>0) && $dev2==0) {
                echo '<font color="red"><h3><strong>DEVOLUCION!</strong></h3></font>';
            }
        }
    } else {
        echo '<font color="red"><h2><strong>TICKET NO GANADOR!</strong></h2></font>';
    }
    if ($montoapagar>0) {
        echo '<font color="red"><h2><strong>Monto a pagar:'.number_format($montoapagar, 2, ",", ".").'</strong></h2></font>';
    }
}

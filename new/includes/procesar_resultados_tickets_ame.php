<?php
    if (!isset($_SESSION)) {
        session_start();
    } require_once('../Connections/conexionbanca.php');
if (isset($_GET["recordID"])) {
    $cod_carrera = $_GET["recordID"];
    $tipoProceso=2;
}
    if (!function_exists('jNormal')) {
        if (is_file('../includes/calculodepago.php')) {
            require("../includes/calculodepago.php");
        }
    }
    
    
    if (isset($reset)) {// reset dividendos
        if ($reset==1) {// reset dividendos todos los ticket
            $query_Recordset12 = sprintf(
                "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 1 */ SELECT num_ticket 
			  FROM venta WHERE cod_carrera = %s AND est_ticket=1 AND est_calculo!=4",
                GetSQLValueString($cod_carrera, "int")
            );
            $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
            $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
            $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
            if ($totalRows_Recordset12>0) {
                do {
                    $num_ticket=$row_Recordset12['num_ticket'];
                    $insertSQL12 = sprintf(
                        "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 2 */ UPDATE venta 
					SET pag_premio=%s, est_calculo=%s
						WHERE num_ticket=%s",
                        GetSQLValueString(0, "double"),
                        GetSQLValueString(0, "int"),
                        GetSQLValueString($num_ticket, "int")
                    );
                    $Result12 = mysqli_query($conexionbanca, $insertSQL12) or die(mysqli_error($conexionbanca));
                } while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));
            }
            mysqli_free_result($Recordset12);
        }
        if ($reset==2) {// reset dividendos todos los ticket
            $query_Recordset12 = sprintf(
                "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 3 */ SELECT num_ticket 
			  FROM venta WHERE cod_carrera = %s AND est_ticket=1",
                GetSQLValueString($cod_carrera, "int")
            );
            $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
            $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
            $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
            if ($totalRows_Recordset12>0) {
                do {
                    $num_ticket=$row_Recordset12['num_ticket'];
                    $insertSQL12 = sprintf(
                        "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 4 */ UPDATE venta 
					SET pag_premio=%s, est_calculo=%s
						WHERE num_ticket=%s",
                        GetSQLValueString(0, "double"),
                        GetSQLValueString(0, "int"),
                        GetSQLValueString($num_ticket, "int")
                    );
                    $Result12 = mysqli_query($conexionbanca, $insertSQL12) or die(mysqli_error($conexionbanca));
                } while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));
            }
            mysqli_free_result($Recordset12);
        }
    }
    if ($tipoProceso==2) { //proceso de premiacion
        $query_Recordset10 = sprintf("/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 5 */ SELECT cod_taquilla FROM taquilla");
        $Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
        $row_Recordset10 = mysqli_fetch_assoc($Recordset10);
        $totalRows_Recordset10 = mysqli_num_rows($Recordset10);
        $x=0;
        do {
            $taq=$row_Recordset10['cod_taquilla'];
            $query_Recordset11 = sprintf(
                "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 6 */ SELECT 
				ve.num_caballo, ve.cod_tventa, ve.mon_venta, ve.num_ticket, ve.pag_premio, ve.est_ticket, ve.fec_venta,
				ca.eje_primero, ca.eje_doble_primero, ca.eje_triple_primero, ca.div_primero_gan, ca.div_primero_pla,
				ca.div_primero_sho, ca.div_doble_primero_gan, ca.div_doble_primero_pla, ca.div_doble_primero_sho,
				ca.div_triple_primero_gan, ca.div_triple_primero_pla, ca.div_triple_primero_sho, ca.eje_segundo,
				ca.eje_doble_segundo, ca.eje_triple_segundo, ca.div_segundo_pla, ca.div_segundo_sho,
				ca.div_doble_segundo_pla, ca.div_doble_segundo_sho, ca.div_triple_segundo_pla, ca.div_triple_segundo_sho,
				ca.eje_tercero, ca.eje_doble_tercero, ca.eje_triple_tercero, ca.div_tercero_sho, ca.div_doble_tercero_sho, 
				ca.div_triple_tercero_sho, ca.fac_exacta, ca.fac_trifecta, ca.fac_superfecta, ca.div_exacta, ca.ord_exacta,
				ca.div_trifecta, ca.ord_trifecta, ca.div_superfecta, ca.ord_superfecta, ca.div_exacta_doble, ca.ord_exacta_doble,
				ca.div_trifecta_doble, ca.ord_trifecta_doble, ca.div_superfecta_doble, ca.ord_superfecta_doble,
				ca.div_exacta_triple,
				ca.ord_exacta_triple, ca.div_trifecta_triple, ca.ord_trifecta_triple, ca.div_superfecta_triple,
				ca.ord_superfecta_triple, ca.can_caballos, ca.cod_carrera, ca.est_confirmacion, tp.anu_regalia, tp.max_aganar_gan,
				tp.reg_gan, tp.max_aganar_pla, tp.reg_pla, tp.max_aganar_sho, tp.reg_sho, tp.max_aganar_exa, tp.reg_exa,
				tp.max_aganar_tri, tp.reg_tri, tp.max_aganar_sup, tp.reg_sup, tp.min_ejecarrera
				FROM 
					venta ve,
					carrera ca, 
					taquilla_opc_ame tp 
				WHERE 
					tp.cod_taquilla = ve.cod_taquilla AND ca.cod_carrera = ve.cod_carrera AND ca.est_confirmacion = 0 AND
					ve.cod_taquilla = %s AND ca.cod_carrera = %s AND 
					((ve.est_ticket!=0 AND ve.est_calculo=0) OR (ve.est_ticket!=0 AND ve.est_ticket=1 AND ve.est_calculo!=0))
				ORDER BY ca.cod_carrera",
                GetSQLValueString($taq, "int"),
                GetSQLValueString($cod_carrera, "int")
            );
            $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
            $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
            $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
            //echo "total ticket ".$totalRows_Recordset11."<br/>";
            if ($totalRows_Recordset11>0) {
                $codigoCarrera=$row_Recordset11['cod_carrera'];
                $retirados=arrayRetirados($codigoCarrera);
                $van=$row_Recordset11['can_caballos']-cantRetirados($row_Recordset11['cod_carrera']);
                $ejeMin=$row_Recordset11['min_ejecarrera'];
                do {
                    $pago[0]=0;
                    $pago[1]="";
                    $retiro=0;
                    $_nTicket=$row_Recordset11['num_ticket'];
                    $_xPremio=0;
                    $_xEstado=1;
                    if ($van>=$ejeMin) {
                        if ($retirados[0]!="0") {
                            if (in_array($row_Recordset11['num_caballo'], $retirados, true)) {
                                $retiro=1;
                            }
                            if ((int)$row_Recordset11['cod_tventa']>=4 && (int)$row_Recordset11['cod_tventa']<=9) {
                                $fcab=explode("-", $row_Recordset11['num_caballo']);
                                foreach ($fcab as $mtz1) {
                                    if (in_array($mtz1, $retirados, true)) {
                                        $retiro=1;
                                        break;
                                    }
                                }
                            }
                        }
                        if ($retiro==0) {
                            if ($row_Recordset11['est_confirmacion']==0) {
                                $anuReg=$row_Recordset11['anu_regalia'];
                                if ($row_Recordset11['cod_tventa']>=1 && $row_Recordset11['cod_tventa']<=3) {
                                    if ($row_Recordset11['cod_tventa']==1) {
                                        $topJugada=$row_Recordset11['max_aganar_gan'];
                                        $regalo=$row_Recordset11['reg_gan'];
                                    }
                                    if ($row_Recordset11['cod_tventa']==2) {
                                        $topJugada=$row_Recordset11['max_aganar_pla'];
                                        $regalo=$row_Recordset11['reg_pla'];
                                    }
                                    if ($row_Recordset11['cod_tventa']==3) {
                                        $topJugada=$row_Recordset11['max_aganar_sho'];
                                        $regalo=$row_Recordset11['reg_sho'];
                                    }
                                    $pago=jNormal(
                                        $row_Recordset11['num_caballo'],
                                        $row_Recordset11['cod_tventa'],
                                        $row_Recordset11['mon_venta'],
                                        $row_Recordset11['eje_primero'],
                                        $row_Recordset11['eje_doble_primero'],
                                        $row_Recordset11['eje_triple_primero'],
                                        $row_Recordset11['div_primero_gan'],
                                        $row_Recordset11['div_primero_pla'],
                                        $row_Recordset11['div_primero_sho'],
                                        $row_Recordset11['div_doble_primero_gan'],
                                        $row_Recordset11['div_doble_primero_pla'],
                                        $row_Recordset11['div_doble_primero_sho'],
                                        $row_Recordset11['div_triple_primero_gan'],
                                        $row_Recordset11['div_triple_primero_pla'],
                                        $row_Recordset11['div_triple_primero_sho'],
                                        $row_Recordset11['eje_segundo'],
                                        $row_Recordset11['eje_doble_segundo'],
                                        $row_Recordset11['eje_triple_segundo'],
                                        $row_Recordset11['div_segundo_pla'],
                                        $row_Recordset11['div_segundo_sho'],
                                        $row_Recordset11['div_doble_segundo_pla'],
                                        $row_Recordset11['div_doble_segundo_sho'],
                                        $row_Recordset11['div_triple_segundo_pla'],
                                        $row_Recordset11['div_triple_segundo_sho'],
                                        $row_Recordset11['eje_tercero'],
                                        $row_Recordset11['eje_doble_tercero'],
                                        $row_Recordset11['eje_triple_tercero'],
                                        $row_Recordset11['div_tercero_sho'],
                                        $row_Recordset11['div_doble_tercero_sho'],
                                        $row_Recordset11['div_triple_tercero_sho'],
                                        $topJugada,
                                        $regalo,
                                        $anuReg
                                    );
                                    if ($pago[0]>0) {
                                        $_xPremio=$pago[0];
                                        $_nTicket=$row_Recordset11['num_ticket'];
                                        $_xEstado=$pago[1];
                                    }
                                }
                                if ($row_Recordset11['cod_tventa']>=4 && $row_Recordset11['cod_tventa']<=9) {
                                    if ($row_Recordset11['cod_tventa']==4 || $row_Recordset11['cod_tventa']==7) {
                                        $fact=$row_Recordset11['fac_exacta'];
                                        $topJugada=$row_Recordset11['max_aganar_exa'];
                                        $regalo=$row_Recordset11['reg_exa'];
                                    }
                                    if ($row_Recordset11['cod_tventa']==5 || $row_Recordset11['cod_tventa']==8) {
                                        $fact=$row_Recordset11['fac_trifecta'];
                                        $topJugada=$row_Recordset11['max_aganar_tri'];
                                        $regalo=$row_Recordset11['reg_tri'];
                                    }
                                    if ($row_Recordset11['cod_tventa']==6 || $row_Recordset11['cod_tventa']==9) {
                                        $fact=$row_Recordset11['fac_superfecta'];
                                        $topJugada=$row_Recordset11['max_aganar_sup'];
                                        $regalo=$row_Recordset11['reg_sup'];
                                    }
                                    $base=2;
                                    $pago=jExotica2(
                                        $row_Recordset11['num_caballo'],
                                        $row_Recordset11['cod_tventa'],
                                        $row_Recordset11['mon_venta'],
                                        $row_Recordset11['div_exacta'],
                                        $row_Recordset11['ord_exacta'],
                                        $row_Recordset11['div_trifecta'],
                                        $row_Recordset11['ord_trifecta'],
                                        $row_Recordset11['div_superfecta'],
                                        $row_Recordset11['ord_superfecta'],
                                        $row_Recordset11['div_exacta_doble'],
                                        $row_Recordset11['ord_exacta_doble'],
                                        $row_Recordset11['div_trifecta_doble'],
                                        $row_Recordset11['ord_trifecta_doble'],
                                        $row_Recordset11['div_superfecta_doble'],
                                        $row_Recordset11['ord_superfecta_doble'],
                                        $row_Recordset11['div_exacta_triple'],
                                        $row_Recordset11['ord_exacta_triple'],
                                        $row_Recordset11['div_trifecta_triple'],
                                        $row_Recordset11['ord_trifecta_triple'],
                                        $row_Recordset11['div_superfecta_triple'],
                                        $row_Recordset11['ord_superfecta_triple'],
                                        $topJugada,
                                        $regalo,
                                        $fact,
                                        $base
                                    );
                                    if ($pago[0]>0) {
                                        $_xPremio=$pago[0];
                                        $_xEstado=$pago[1];
                                    }
                                }
                            }
                        }///
                        else {//retirar
                            $_xPremio=$row_Recordset11['mon_venta'];
                            $_xEstado=4;
                        }
                    } else {//devolver cuando haya menos ejemplares
                        $_xPremio=$row_Recordset11['mon_venta'];
                        $_xEstado=5;
                    }
                    $updateSQL = sprintf(
                        "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 7 */ UPDATE venta 
						SET est_calculo=%s, pag_premio=%s 
						WHERE num_ticket=%s",
                        GetSQLValueString($_xEstado, "int"),
                        GetSQLValueString($_xPremio, "double"),
                        GetSQLValueString($_nTicket, "int")
                    );
                    $Result11 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                } while ($row_Recordset11 = mysqli_fetch_assoc($Recordset11));
                mysqli_free_result($Recordset11);
            }
        } while ($row_Recordset10 = mysqli_fetch_assoc($Recordset10));
        mysqli_free_result($Recordset10);
    }// fin tipo proceso 2
    else {
        if ($tipoProceso==5) {// devolucion
            $query_Recordset12 = sprintf(
                "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 8 */ SELECT num_ticket, mon_venta 
		  FROM venta WHERE cod_carrera = %s AND est_ticket=1 AND est_calculo=0",
                GetSQLValueString($cod_carrera, "int")
            );
            $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
            $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
            $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
            if ($totalRows_Recordset12 >0) {
                do {
                    $num_ticket=$row_Recordset12['num_ticket'];
                    $mon_venta=$row_Recordset12['mon_venta'];
                    $insertSQL12 = sprintf(
                        "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 9 */ UPDATE venta 
					SET pag_premio=%s, est_calculo=%s
					WHERE num_ticket=%s",
                        GetSQLValueString($mon_venta, "double"),
                        GetSQLValueString(5, "int"),
                        GetSQLValueString($num_ticket, "int")
                    );
                    $Result12 = mysqli_query($conexionbanca, $insertSQL12) or die(mysqli_error($conexionbanca));
                } while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));
            }
            mysqli_free_result($Recordset12);
        }//fin tipo proceso 5
        else {
            if ($tipoProceso==4) {// retiro de caballo
                $query_Recordset12 = sprintf(
                    "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 10 */ SELECT num_ticket, mon_venta, cod_tventa, num_caballo 
				  FROM venta 
				  WHERE cod_carrera = %s AND est_ticket=1 AND 
				  ((num_caballo = %s AND cod_tventa<=3) OR (cod_tventa>=4 AND cod_tventa<=9))",
                    GetSQLValueString($cod_carrera, "int"),
                    GetSQLValueString($num_caballo, "int")
                );
                $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
                $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
                $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
                if ($totalRows_Recordset12>0) {
                    $retirados=arrayRetirados($codigoCarrera);
                    do {
                        $retiro=0;
                        if ($row_Recordset12['cod_tventa']>=4 && $row_Recordset12['cod_tventa']<=9) {
                            $fcab=explode("-", $row_Recordset12['num_caballo']);
                            if (in_array($num_caballo, $fcab, true)) {
                                $retiro=1;
                            }
                        } else {
                            if ($row_Recordset12['num_caballo']==$num_caballo) {
                                $retiro=1;
                            }
                        }
                          
                        if ($retiro==1) {
                            $num_ticket=$row_Recordset12['num_ticket'];
                            $mon_venta=$row_Recordset12['mon_venta'];
                            $insertSQL12 = sprintf(
                                "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 11 */ UPDATE venta 
								SET pag_premio=%s, est_calculo=%s
								WHERE num_ticket=%s",
                                GetSQLValueString($mon_venta, "double"),
                                GetSQLValueString(4, "int"),
                                GetSQLValueString($num_ticket, "int")
                            );
                            $Result12 = mysqli_query($conexionbanca, $insertSQL12) or die(mysqli_error($conexionbanca));
                        }
                    } while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));
                }
                mysqli_free_result($Recordset12);
                $query_Recordset13 = sprintf("/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 12 */ SELECT cod_taquilla FROM taquilla");
                $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
                $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
                $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
                $x=0;
                do {
                    $taq=$row_Recordset13['cod_taquilla'];
                    $query_Recordset14 = sprintf(
                        "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 13 */ SELECT 
						ve.mon_venta, ve.num_ticket, ve.est_ticket, ca.can_caballos, ca.cod_carrera, tp.min_ejecarrera
						FROM venta ve, carrera ca, taquilla_opc_ame tp 
						WHERE tp.cod_taquilla = ve.cod_taquilla AND ca.cod_carrera = ve.cod_carrera AND ve.cod_taquilla = %s AND 
							ca.cod_carrera = %s AND ve.est_ticket = 1
						ORDER BY ca.cod_carrera",
                        GetSQLValueString($taq, "int"),
                        GetSQLValueString($cod_carrera, "int")
                    );
                    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
                    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
                    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
                    do {
                        $van=$row_Recordset14['can_caballos']-cantRetirados($cod_carrera);
                        if ($row_Recordset14['min_ejecarrera']>$van) {
                            $num_ticket=$row_Recordset14['num_ticket'];
                            $mon_venta=$row_Recordset14['mon_venta'];
                            $insertSQL15 = sprintf(
                                "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 14 */ UPDATE venta 
								SET pag_premio=%s, est_calculo=%s
								WHERE num_ticket=%s",
                                GetSQLValueString($mon_venta, "double"),
                                GetSQLValueString(5, "int"),
                                GetSQLValueString($num_ticket, "int")
                            );
                            $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));
                        } else {
                            break;
                        }
                    } while ($row_Recordset14 = mysqli_fetch_assoc($Recordset14));
                } while ($row_Recordset13 = mysqli_fetch_assoc($Recordset13));
                if (isset($Recordset14)) {
                    mysqli_free_result($Recordset14);
                }
                mysqli_free_result($Recordset13);
            }//fin tipo proceso 4
            else {
                if ($tipoProceso==1) {// reset dividendos
                    $query_Recordset12 = sprintf(
                        "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 15 */ SELECT num_ticket 
				  FROM venta WHERE cod_carrera = %s AND est_ticket=1 AND est_calculo!=4",
                        GetSQLValueString($cod_carrera, "int")
                    );
                    $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
                    $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
                    $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
                    if ($totalRows_Recordset12>0) {
                        do {
                            $num_ticket=$row_Recordset12['num_ticket'];
                            $insertSQL12 = sprintf(
                                "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 16 */ UPDATE venta 
							SET pag_premio=%s, est_calculo=%s
							WHERE num_ticket=%s",
                                GetSQLValueString(0, "double"),
                                GetSQLValueString(0, "int"),
                                GetSQLValueString($num_ticket, "int")
                            );
                            $Result12 = mysqli_query($conexionbanca, $insertSQL12) or die(mysqli_error($conexionbanca));
                        } while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));
                    }
                    mysqli_free_result($Recordset12);
                }//fin tipo proceso 1
                else {
                    if ($tipoProceso==3) {// reintegro de caballo
                        $query_Recordset12 = sprintf(
                            "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 17 */ SELECT num_ticket, cod_tventa, num_caballo 
							  FROM venta 
							  WHERE cod_carrera = %s AND est_ticket=1 AND est_calculo = 4 AND
							  ((num_caballo = %s AND cod_tventa<=3) OR (cod_tventa>=4 AND cod_tventa<=9))",
                            GetSQLValueString($cod_carrera, "int"),
                            GetSQLValueString($num_caballo, "int")
                        );
                        $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
                        $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
                        $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
                        if ($totalRows_Recordset12>0) {
                            $retirados=arrayRetirados($cod_carrera);
                            do {
                                $acceso=1;
                                if ($retirados[0]!="0") {
                                    if ($row_Recordset12['cod_tventa']>=4 && $row_Recordset12['cod_tventa']<=9) {
                                        $fcab=explode("-", $row_Recordset12['num_caballo']);
                                        foreach ($fcab as $mtz1) {
                                            if (in_array($mtz1, $retirados, true)) {
                                                $acceso=0;
                                                break;
                                            }
                                        }
                                    } else {
                                        if (in_array($row_Recordset12['num_caballo'], $retirados, true)) {
                                            $acceso=0;
                                        }
                                    }
                                }
                                if ($acceso==1) {
                                    $acceso2=0;
                                    if ($row_Recordset12['cod_tventa']>=4 && $row_Recordset12['cod_tventa']<=9) {
                                        $fcab=explode("-", $row_Recordset12['num_caballo']);
                                        if (in_array($num_caballo, $fcab, true)) {
                                            $acceso2=1;
                                        }
                                    } else {
                                        if ($row_Recordset12['num_caballo']==$num_caballo) {
                                            $acceso2=1;
                                        }
                                    }
                                    if ($acceso2==1) {
                                        $num_ticket=$row_Recordset12['num_ticket'];
                                        $insertSQL12 = sprintf(
                                            "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 18 */ UPDATE venta 
										SET pag_premio=%s, est_calculo=%s
										WHERE num_ticket=%s",
                                            GetSQLValueString(0, "double"),
                                            GetSQLValueString(0, "int"),
                                            GetSQLValueString($num_ticket, "int")
                                        );
                                        $Result12 = mysqli_query($conexionbanca, $insertSQL12) or die(mysqli_error($conexionbanca));
                                    }
                                }
                            } while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));
                        }
                        mysqli_free_result($Recordset12);
                    }//fin tipo proceso 3
                    else {
                        if ($tipoProceso==6) {// reintegro de TODOS caballo
                            $query_Recordset12 = sprintf(
                                "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 19 */ SELECT num_ticket 
								  FROM venta 
								  WHERE cod_carrera = %s AND est_ticket = 1 AND est_calculo = 4",
                                GetSQLValueString($cod_carrera, "int")
                            );
                            $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
                            $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
                            $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
                            if ($totalRows_Recordset12>0) {
                                do {
                                    $num_ticket=$row_Recordset12['num_ticket'];
                                    $insertSQL12 = sprintf(
                                        "/* PARSEADORES1 new\includes\procesar_resultados_tickets_ame.php - QUERY 20 */ UPDATE venta 
										SET pag_premio=%s, est_calculo=%s
										WHERE num_ticket=%s",
                                        GetSQLValueString(0, "double"),
                                        GetSQLValueString(0, "int"),
                                        GetSQLValueString($num_ticket, "int")
                                    );
                                    $Result12 = mysqli_query($conexionbanca, $insertSQL12) or die(mysqli_error($conexionbanca));
                                } while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));
                            }
                            mysqli_free_result($Recordset12);
                        }//fin tipo proceso 6
                    }
                }
            }
        }
    }

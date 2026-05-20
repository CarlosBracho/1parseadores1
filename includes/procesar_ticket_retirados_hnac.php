<?php
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($car)) {
    $query_Recordset0 = sprintf("/* PARSEADORES1 includes\procesar_ticket_retirados_hnac.php - QUERY 1 */ SELECT ta.cod_taquilla 
		FROM taquilla ta, taquilla_opc_hnac tp 
		WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND 
		tp.est_taquilla_hnac = 1
		ORDER BY ta.cod_taquilla ASC");
    $Recordset0 = mysqli_query($conexionbanca, $query_Recordset0) or die(mysqli_error($conexionbanca));
    $row_Recordset0 = mysqli_fetch_assoc($Recordset0);
    $totalRows_Recordset0 = mysqli_num_rows($Recordset0);
    $fechaactualbd = fechaactualbd();

    if ($totalRows_Recordset0>0) {
        $retirados=arrayRetiradosHNAC($car);
        print_r($retirados);
        do {
            $taq=$row_Recordset0['cod_taquilla'];
            $query_Recordset3 = sprintf(
                "/* PARSEADORES1 includes\procesar_ticket_retirados_hnac.php - QUERY 2 */ SELECT ve.num_ticket_hnac, ve.mon_venta_hnac, ve.num_caballo_hnac, ve.cod_tventa_hnac
				FROM 
				venta_hnac ve, 
				carrera_hnac ca, 
				usuario us,
				taquilla_opc_hnac tp
				WHERE 
                ve.fec_venta_hnac = %s AND
				ve.cod_carrera_hnac = %s AND
				tp.cod_taquilla = %s AND
				ve.est_ticket_hnac = 1 AND
				ve.id_usuario = us.id_usuario AND
				us.cod_taquilla = tp.cod_taquilla AND 
				ca.cod_carrera_hnac = ve.cod_carrera_hnac
				ORDER BY ve.num_ticket_hnac ASC",
                GetSQLValueString($fechaactualbd, "date"),
                GetSQLValueString($car, "int"),
                GetSQLValueString($taq, "int")
                
            );
            $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
            $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
            $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
            if ($totalRows_Recordset3>0) {
                $x_nTicket=array(0);
                $x_pagoSencillo=array(0);
                $i=0;
                do {
                    $retiro=0;
                    if ($retirados[0]!="0") {
                        if (in_array($row_Recordset3['num_caballo_hnac'], $retirados, true)) {
                            $retiro=1;
                        }
                        if ($row_Recordset3['cod_tventa_hnac']>=4 && $row_Recordset3['cod_tventa_hnac']<=9) {
                            $fcab=explode("-", $row_Recordset3['num_caballo_hnac']);
                            foreach ($fcab as $mtz1) {
                                if (in_array($mtz1, $retirados, true)) {
                                    $retiro=1;
                                    break;
                                }
                            }
                        }
                    }
                    if ($retiro==1) {
                        $x_nTicket[$i]=$row_Recordset3['num_ticket_hnac'];
                        $x_pagoSencillo[$i]=$row_Recordset3['mon_venta_hnac'];
                        $i=$i+1;
                    }
                } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
                $x=0;
                if ($i>0) {
                    do {
                        $updateSQL3 = sprintf(
                            "/* PARSEADORES1 includes\procesar_ticket_retirados_hnac.php - QUERY 3 */ UPDATE venta_hnac 
						SET pag_premio_hnac=%s, est_calculo_hnac=%s 
							WHERE 
                            fec_venta_hnac = %s AND
                            num_ticket_hnac=%s",
                            GetSQLValueString($x_pagoSencillo[$x], "double"),
                            GetSQLValueString(5, "int"),
                            GetSQLValueString($fechaactualbd, "date"),
                            GetSQLValueString($x_nTicket[$x], "int")
                        );
                        $Result3 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));
                        $x++;
                    } while ($x < $i);
                }
            }
        } while ($row_Recordset0 = mysqli_fetch_assoc($Recordset0));
    }
    if (isset($Recordset0)) {
        mysqli_free_result($Recordset0);
    }
    if (isset($Recordset3)) {
        mysqli_free_result($Recordset3);
    }
}

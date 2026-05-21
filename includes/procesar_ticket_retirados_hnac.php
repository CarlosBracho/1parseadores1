<?php

if (isset($car)) {
    $fechaactualbd = fechaactualbd();
    $retirados = arrayRetiradosHNAC($car);

    // QUERY CONSOLIDADO: 1 sola query reemplaza N queries por taquilla (Causa #2 - Optimización N×M)
    $query_Recordset3 = sprintf(
        "/* Origen: procesar_ticket_retirados_hnac.php */ SELECT ve.num_ticket_hnac, ve.mon_venta_hnac, ve.num_caballo_hnac, ve.cod_tventa_hnac
        FROM venta_hnac ve
        JOIN usuario us ON us.id_usuario = ve.id_usuario
        JOIN taquilla_opc_hnac tp ON tp.cod_taquilla = us.cod_taquilla
        WHERE ve.fec_venta_hnac = %s
          AND ve.cod_carrera_hnac = %s
          AND tp.est_taquilla_hnac = 1
          AND ve.est_ticket_hnac = 1
        ORDER BY ve.num_ticket_hnac ASC",
        GetSQLValueString($fechaactualbd, "date"),
        GetSQLValueString($car, "int")
    );
    $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
    $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
    $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

    if ($totalRows_Recordset3 > 0) {
        $x_nTicket = array(0);
        $x_pagoSencillo = array(0);
        $i = 0;
        do {
            $retiro = 0;
            if ($retirados[0] != "0") {
                if (in_array($row_Recordset3['num_caballo_hnac'], $retirados, true)) {
                    $retiro = 1;
                }
                if ($row_Recordset3['cod_tventa_hnac'] >= 4 && $row_Recordset3['cod_tventa_hnac'] <= 9) {
                    $fcab = explode("-", $row_Recordset3['num_caballo_hnac']);
                    foreach ($fcab as $mtz1) {
                        if (in_array($mtz1, $retirados, true)) {
                            $retiro = 1;
                            break;
                        }
                    }
                }
            }
            if ($retiro == 1) {
                $x_nTicket[$i] = $row_Recordset3['num_ticket_hnac'];
                $x_pagoSencillo[$i] = $row_Recordset3['mon_venta_hnac'];
                $i = $i + 1;
            }
        } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));

        $x = 0;
        if ($i > 0) {
            do {
                $updateSQL3 = sprintf(
                    "/* Origen: procesar_ticket_retirados_hnac.php */ UPDATE venta_hnac
                    SET pag_premio_hnac=%s, est_calculo_hnac=%s
                    WHERE fec_venta_hnac = %s AND num_ticket_hnac=%s",
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

    if (isset($Recordset3)) {
        mysqli_free_result($Recordset3);
    }
}


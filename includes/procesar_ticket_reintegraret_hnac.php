<?php

if (isset($car)) {
    $fechaactualbd = fechaactualbd();

    // QUERY CONSOLIDADO: Unifica lectura de taquillas y tickets en 1 sola query (Causa #1 - Optimización N+1)
    $query_Recordset3 = sprintf(
        "/* Origen: procesar_ticket_reintegraret_hnac.php */ SELECT ve.num_ticket_hnac, ve.num_caballo_hnac, ve.cod_tventa_hnac
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

    $tickets_a_reintegrar = array();

    if ($totalRows_Recordset3 > 0) {
        do {
            $reint = 0;
            if ($reintegro[0] != "0") {
                if (in_array($row_Recordset3['num_caballo_hnac'], $reintegro, true)) {
                    $reint = 1;
                }
                if ($row_Recordset3['cod_tventa_hnac'] >= 4 && $row_Recordset3['cod_tventa_hnac'] <= 9) {
                    $fcab = explode("-", $row_Recordset3['num_caballo_hnac']);
                    foreach ($fcab as $mtz1) {
                        if (in_array($mtz1, $reintegro, true)) {
                            $reint = 1;
                            break;
                        }
                    }
                }
            }
            if ($reint == 1) {
                $tickets_a_reintegrar[] = $row_Recordset3['num_ticket_hnac'];
            }
        } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
    }

    if (!empty($tickets_a_reintegrar)) {
        // Escritura en bloque estructurada por lotes (chunks) para no exceder max_allowed_packet
        $chunks = array_chunk($tickets_a_reintegrar, 200);
        foreach ($chunks as $chunk) {
            $ids_escaped = array();
            foreach ($chunk as $id) {
                $ids_escaped[] = GetSQLValueString($id, "int");
            }
            $in_clause = implode(",", $ids_escaped);

            $updateSQL3 = sprintf(
                "/* Origen: procesar_ticket_reintegraret_hnac.php */ UPDATE venta_hnac 
                SET pag_premio_hnac = %s, est_calculo_hnac = %s 
                WHERE fec_venta_hnac = %s AND num_ticket_hnac IN ($in_clause)",
                GetSQLValueString(0, "double"),
                GetSQLValueString(0, "int"),
                GetSQLValueString($fechaactualbd, "date")
            );
            $Result3 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));
        }
    }

    if (isset($Recordset3)) {
        mysqli_free_result($Recordset3);
    }
}

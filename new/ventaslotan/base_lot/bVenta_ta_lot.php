<?php
                $query_Recordset81 = sprintf(
    "/* PARSEADORES1 new\ventaslotan\base_lot\bVenta_ta_lot.php - QUERY 1 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla,
					ta.cod_taquilla,
					tp.por_taquilla_lot,
					tp.ver_porpagar_lot,
					SUM(CASE WHEN fec_venta_lot >= %s AND fec_venta_lot <= %s 
						THEN ve.mon_apuesta_lot ELSE 0 END) AS total_venta_lot,
						
					SUM(CASE WHEN ve.est_ticket_lot = 2 AND fec_pago_lot >= %s AND fec_pago_lot <= %s 
						THEN ve.pag_premio_lot ELSE 0 END) AS tot_premios_lot,
					
					SUM(CASE WHEN ve.est_ticket_lot = 0 AND fec_pago_lot >= %s AND fec_pago_lot <= %s
						THEN ve.mon_apuesta_lot ELSE 0 END) AS tot_eliminad_lot,

					SUM(CASE WHEN ve.est_ticket_lot = 5 AND fec_pago_lot >= %s AND fec_pago_lot <= %s
						THEN ve.mon_apuesta_lot ELSE 0 END) AS inv_pagos_lot,

					SUM(CASE WHEN ve.est_calculo_lot = 5 AND ve.fec_venta_lot >= %s AND ve.fec_venta_lot <= %s
						THEN ve.mon_apuesta_lot ELSE 0 END) AS inv_total_lot,

					SUM(CASE WHEN ve.est_ticket_lot = 1 AND ve.est_calculo_lot = 5 AND 
						ve.fec_venta_lot >= %s AND ve.fec_venta_lot <= %s
						THEN ve.mon_apuesta_lot ELSE 0 END) AS inv_porpagar_lot,
					
					SUM(CASE WHEN ve.est_ticket_lot = 1 AND ve.est_calculo_lot = 2 AND 
						ve.fec_venta_lot >= %s AND ve.fec_venta_lot <= %s 
						THEN ve.pag_premio_lot ELSE 0 END) AS pre_porpagar_lot,
						
					SUM(CASE WHEN ve.est_ticket_lot = 0 AND ve.fec_venta_lot >= %s AND 
						ve.fec_venta_lot <= %s AND ve.lin_ticket_lot = 1
						THEN 1 ELSE 0 END) AS con_tic_eli_lot
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_lot tp, 
					venta_lot ve,
					usuario us
					WHERE
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta_lot >= %s AND ve.fec_venta_lot <= %s OR 
					ve.fec_pago_lot >= %s AND ve.fec_pago_lot <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					ta.cod_taquilla = %s 
					ORDER BY ve.fec_venta_lot, ta.cod_taquilla, ve.num_ticket_lot ASC",
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($codigoTaquilla, "int")
);
                $Recordset81 = mysqli_query($conexionbanca, $query_Recordset81) or die(mysqli_error($conexionbanca));
                $row_Recordset81 = mysqli_fetch_assoc($Recordset81);
                $totalRows_Recordset81 = mysqli_num_rows($Recordset81);
                $vendedor="TODOS";
                $query_Recordset = sprintf(
                    "/* PARSEADORES1 new\ventaslotan\base_lot\bVenta_ta_lot.php - QUERY 2 */ SELECT cod_taquilla FROM taquilla_opc_lot WHERE cod_taquilla = %s LIMIT 1",
                    GetSQLValueString($codigoTaquilla, "int")
                );
                $Recordset = mysqli_query($conexionbanca, $query_Recordset) or die(mysqli_error($conexionbanca));
                $row_Recordset = mysqli_fetch_assoc($Recordset);$totalRows_Recordset = mysqli_num_rows($Recordset);
                if ($totalRows_Recordset>0) {
                    $hnac=1;
                } else {
                    $hnac=0;
                } mysqli_free_result($Recordset);
                $Atotal_venta=$row_Recordset81['total_venta_lot'];
                $Atot_premios=$row_Recordset81['tot_premios_lot'];
                $Ainv_pagos=$row_Recordset81['inv_pagos_lot'];
                $Atot_eliminad=$row_Recordset81['tot_eliminad_lot'];
                $Ainv_porpagar=$row_Recordset81['inv_porpagar_lot'];
                $Apre_porpagar=$row_Recordset81['pre_porpagar_lot'];
                $AinvCanAnu=$row_Recordset81['tot_eliminad_lot']+$row_Recordset81['inv_pagos_lot'];
                $AinvCanAnu2=$AinvCanAnu+$row_Recordset81['inv_porpagar_lot'];
                $AenCaja=$row_Recordset81['total_venta_lot']-$AinvCanAnu-$row_Recordset81['tot_premios_lot'];
                $totAnuTaquilla=$row_Recordset81['inv_total_lot']+$row_Recordset81['tot_eliminad_lot'];
                $ApagoSistema=(($row_Recordset81['total_venta']-$totAnuTaquilla)*$row_Recordset81['por_taquilla_lot'])/100;
                $Aeliminados=$row_Recordset81['con_tic_eli_lot'];

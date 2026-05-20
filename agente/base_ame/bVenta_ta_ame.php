<?php
                $query_Recordset81 = sprintf(
    "/* PARSEADORES1 agente\base_ame\bVenta_ta_ame.php - QUERY 1 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla,
					ta.cod_taquilla,
					ta.taq_por_ame,
					SUM(CASE WHEN fec_venta >= %s AND fec_venta <= %s 
						THEN ve.mon_venta ELSE 0 END) AS total_venta,
						
					SUM(CASE WHEN ve.est_ticket = 2 AND fec_pago >= %s AND fec_pago <= %s 
						THEN ve.pag_premio ELSE 0 END) AS tot_premios,
					
					SUM(CASE WHEN ve.est_ticket = 0 AND fec_pago >= %s AND fec_pago <= %s
						THEN ve.mon_venta ELSE 0 END) AS tot_eliminad,
					
					SUM(CASE WHEN ve.est_ticket = 4 AND fec_pago >= %s AND fec_pago <= %s
						THEN ve.mon_venta ELSE 0 END) AS ret_pagos,
	
					SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.mon_venta ELSE 0 END) AS ret_total,

					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.mon_venta ELSE 0 END) AS ret_porpagar,
					
					SUM(CASE WHEN ve.est_ticket = 5 AND fec_pago >= %s AND fec_pago <= %s
						THEN ve.mon_venta ELSE 0 END) AS inv_pagos,

					SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.mon_venta ELSE 0 END) AS inv_total,

					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.mon_venta ELSE 0 END) AS inv_porpagar,
					
					SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s 
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
						THEN 1 ELSE 0 END) AS con_tic_eli
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_ame tp, 
					usuario us,
					venta ve
 
					WHERE
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta >= %s AND ve.fec_venta <= %s OR 
					ve.fec_pago >= %s AND ve.fec_pago <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					ag.cod_agencia = %s 
					ORDER BY ve.fec_venta, ta.cod_taquilla, ve.num_ticket ASC",
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
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($codigoAgente, "int")
);
                $Recordset81 = mysqli_query($conexionbanca, $query_Recordset81) or die(mysqli_error($conexionbanca));
                $row_Recordset81 = mysqli_fetch_assoc($Recordset81);
                $totalRows_Recordset81 = mysqli_num_rows($Recordset81);
                $vendedor="TODOS";
                $query_Recordset = sprintf(
                    "/* PARSEADORES1 agente\base_ame\bVenta_ta_ame.php - QUERY 2 */ SELECT cod_taquilla FROM taquilla_opc_hnac WHERE cod_taquilla = %s LIMIT 1",
                    GetSQLValueString($codigoAgente, "int")
                );
                $Recordset = mysqli_query($conexionbanca, $query_Recordset) or die(mysqli_error($conexionbanca));
                $row_Recordset = mysqli_fetch_assoc($Recordset);$totalRows_Recordset = mysqli_num_rows($Recordset);
                if ($totalRows_Recordset>0) {
                    $hnac=1;
                } else {
                    $hnac=0;
                } mysqli_free_result($Recordset);
                $Atotal_venta=$row_Recordset81['total_venta'];
                $Atot_premios=$row_Recordset81['tot_premios'];
                $Aret_pagos=$row_Recordset81['ret_pagos'];
                $Ainv_pagos=$row_Recordset81['inv_pagos'];
                $Atot_eliminad=$row_Recordset81['tot_eliminad'];
                $Aret_porpagar=$row_Recordset81['ret_porpagar'];
                $Ainv_porpagar=$row_Recordset81['inv_porpagar'];
                $Apre_porpagar=$row_Recordset81['pre_porpagar'];
                $AinvCanAnu=$row_Recordset81['tot_eliminad']+$row_Recordset81['inv_pagos']+$row_Recordset81['ret_pagos'];
                $AinvCanAnu2=$AinvCanAnu+$row_Recordset81['inv_porpagar']+$row_Recordset81['ret_porpagar'];
                $AenCaja=$row_Recordset81['total_venta']-$AinvCanAnu-$row_Recordset81['tot_premios'];
                $totAnuTaquilla=$row_Recordset81['ret_total']+$row_Recordset81['inv_total']+$row_Recordset81['tot_eliminad'];
                $ApagoSistema=(($row_Recordset81['total_venta']-$totAnuTaquilla)*$row_Recordset81['taq_por_ame'])/100;
                $Aeliminados=$row_Recordset81['con_tic_eli'];

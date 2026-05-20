<?php
                $query_Recordset81 = sprintf(
    "/* PARSEADORES1 distri_hnac\base_hnac\bVenta_ta_hnac.php - QUERY 1 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla,
					ta.cod_taquilla,
					tp.ver_porpagar_hnac,
					ta.taq_cob_hnac,
					SUM(CASE WHEN fec_venta_hnac >= %s AND fec_venta_hnac <= %s 
						THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,

					SUM(CASE WHEN ve.est_ticket_hnac = 2 AND fec_pago_hnac >= %s AND fec_pago_hnac <= %s 
						THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND fec_pago_hnac >= %s AND fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND fec_pago_hnac >= %s AND fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagos,
	
					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 5 AND fec_pago_hnac >= %s AND fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS inv_pagos,
	
					SUM(CASE WHEN ve.est_calculo_hnac = 5 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS inv_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 5 AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS inv_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 2 AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.pag_premio_hnac ELSE 0 END) AS pre_porpagar,

					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s AND 
						ve.lin_ticket_hnac = 1 THEN 1 ELSE 0 END) AS con_tic_eli
						
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_hnac tp, 
					venta_hnac ve,
					usuario us,
					carrera_hnac ca 
					WHERE
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta_hnac >= %s AND 
					ve.fec_venta_hnac <= %s OR 
					ve.fec_pago_hnac >= %s AND 
					ve.fec_pago_hnac <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					ve.cod_carrera_hnac = ca.cod_carrera_hnac AND
					ta.cod_taquilla = %s 
					ORDER BY ve.fec_venta_hnac,ta.cod_taquilla,ve.num_ticket_hnac ASC",
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
    GetSQLValueString($codigoTaquilla, "int")
);
                $Recordset81 = mysqli_query($conexionbanca, $query_Recordset81) or die(mysqli_error($conexionbanca));
                $row_Recordset81 = mysqli_fetch_assoc($Recordset81);
                $totalRows_Recordset81 = mysqli_num_rows($Recordset81);
                $vendedor="TODOS";
                $Ntotal_venta=$row_Recordset81['total_venta'];
                $Ntot_premios=$row_Recordset81['tot_premios'];
                $Nret_pagos=$row_Recordset81['ret_pagos'];
                $Ninv_pagos=$row_Recordset81['inv_pagos'];
                $Ntot_eliminad=$row_Recordset81['tot_eliminad'];
                $Nret_porpagar=$row_Recordset81['ret_porpagar'];
                $Ninv_porpagar=$row_Recordset81['inv_porpagar'];
                $Npre_porpagar=$row_Recordset81['pre_porpagar'];
                $NinvCanAnu=$row_Recordset81['tot_eliminad']+$row_Recordset81['inv_pagos']+$row_Recordset81['ret_pagos'];
                $NinvCanAnu2=$NinvCanAnu+$row_Recordset81['inv_porpagar']+$row_Recordset81['ret_porpagar'];
                $NenCaja=$row_Recordset81['total_venta']-$NinvCanAnu-$row_Recordset81['tot_premios'];
                $totAnuTaquilla=$row_Recordset81['ret_total']+$row_Recordset81['inv_total']+$row_Recordset81['tot_eliminad'];
                $NpagoSistema=(($row_Recordset81['total_venta']-$totAnuTaquilla)*$row_Recordset81['taq_cob_hnac'])/100;
                $Neliminados=$row_Recordset81['con_tic_eli'];

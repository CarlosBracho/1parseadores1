<?php
                $query_Recordset81 = sprintf(
    "/* PARSEADORES1 agente_hnac\base_hnac\bVenta_us_hnac.php - QUERY 1 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla, ta.efectivoO,
					ta.taq_cob_hnac,
					tp.ver_porpagar_hnac,
					SUM(CASE WHEN fec_venta_hnac >= %s AND fec_venta_hnac <= %s 
						THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 2 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s 
						THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagos,

					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 5 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
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
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset81 = mysqli_query($conexionbanca, $query_Recordset81) or die(mysqli_error($conexionbanca));
                $row_Recordset81 = mysqli_fetch_assoc($Recordset81);
                $totalRows_Recordset81 = mysqli_num_rows($Recordset81);
                $vendedor=strtoupper($row_Recordset81['nom_usuario']);
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

?>
<?php
                $query_Recordset900 = sprintf(
    "/* PARSEADORES1 agente_hnac\base_hnac\bVenta_us_hnac.php - QUERY 2 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla, ta.efectivoO,
					ta.taq_cob_hnac,
					tp.ver_porpagar_hnac,
					SUM(CASE WHEN fec_venta_hnac >= %s AND fec_venta_hnac <= %s 
						THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 2 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s 
						THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagos,

					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 5 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
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
					ve.efectivoOn = 0 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta_hnac >= %s AND 
					ve.fec_venta_hnac <= %s OR 
					ve.fec_pago_hnac >= %s AND 
					ve.fec_pago_hnac <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					ve.cod_carrera_hnac = ca.cod_carrera_hnac AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset900 = mysqli_query($conexionbanca, $query_Recordset900) or die(mysqli_error($conexionbanca));
                $row_Recordset900 = mysqli_fetch_assoc($Recordset900);
                $totalRows_Recordset900 = mysqli_num_rows($Recordset900);
                $vendedor900=strtoupper($row_Recordset900['nom_usuario']);
                $Ntotal_venta900=$row_Recordset900['total_venta'];
                $Ntot_premios900=$row_Recordset900['tot_premios'];
                $Nret_pagos900=$row_Recordset900['ret_pagos'];
                $Ninv_pagos900=$row_Recordset900['inv_pagos'];
                $Ntot_eliminad900=$row_Recordset900['tot_eliminad'];
                $Nret_porpagar900=$row_Recordset900['ret_porpagar'];
                $Ninv_porpagar900=$row_Recordset900['inv_porpagar'];
                $Npre_porpagar900=$row_Recordset900['pre_porpagar'];
                $NinvCanAnu900=$row_Recordset900['tot_eliminad']+$row_Recordset900['inv_pagos']+$row_Recordset900['ret_pagos'];
                $NinvCanAnu2900=$NinvCanAnu900+$row_Recordset900['inv_porpagar']+$row_Recordset900['ret_porpagar'];
                $NenCaja900=$row_Recordset900['total_venta']-$NinvCanAnu900-$row_Recordset900['tot_premios'];
                $totAnuTaquilla900=$row_Recordset900['ret_total']+$row_Recordset900['inv_total']+$row_Recordset900['tot_eliminad'];
                $NpagoSistema900=(($row_Recordset900['total_venta']-$totAnuTaquilla900)*$row_Recordset900['taq_cob_hnac'])/100;
                $Neliminados900=$row_Recordset900['con_tic_eli'];
?>
<?php
                $query_Recordset901 = sprintf(
    "/* PARSEADORES1 agente_hnac\base_hnac\bVenta_us_hnac.php - QUERY 3 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla, ta.efectivoO,
					ta.taq_cob_hnac,
					tp.ver_porpagar_hnac,
					SUM(CASE WHEN fec_venta_hnac >= %s AND fec_venta_hnac <= %s AND ve.efectivoOn = 1 
						THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 2 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s  AND ve.efectivoOn = 1 
						THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s AND ve.efectivoOn = 1 
						THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s AND ve.efectivoOn = 1 
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagos,

					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s AND ve.efectivoOn = 1 
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND ve.efectivoOn = 1  AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 5 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s AND ve.efectivoOn = 1 
						THEN ve.mon_venta_hnac ELSE 0 END) AS inv_pagos,
	
					SUM(CASE WHEN ve.est_calculo_hnac = 5 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s AND ve.efectivoOn = 1
						THEN ve.mon_venta_hnac ELSE 0 END) AS inv_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 5 AND ve.efectivoOn = 1  AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS inv_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 2 AND ve.efectivoOn = 1  AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.pag_premio_hnac ELSE 0 END) AS pre_porpagar,

					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s AND ve.efectivoOn = 1  AND 
						ve.lin_ticket_hnac = 1 THEN 1 ELSE 0 END) AS con_tic_eli
						
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_hnac tp, 
					usuario us,
					carrera_hnac ca,
					venta_hnac ve
					USE INDEX(id_us_fe_fe)
					WHERE
					ve.efectivoOn = 1 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta_hnac >= %s AND 
					ve.fec_venta_hnac <= %s OR 
					ve.fec_pago_hnac >= %s AND 
					ve.fec_pago_hnac <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					ve.cod_carrera_hnac = ca.cod_carrera_hnac AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset901 = mysqli_query($conexionbanca, $query_Recordset901) or die(mysqli_error($conexionbanca));
                $row_Recordset901 = mysqli_fetch_assoc($Recordset901);
                $totalRows_Recordset901 = mysqli_num_rows($Recordset901);
                $vendedor901=strtoupper($row_Recordset901['nom_usuario']);
                $Ntotal_venta901=$row_Recordset901['total_venta'];
                $Ntot_premios901=$row_Recordset901['tot_premios'];
                $Nret_pagos901=$row_Recordset901['ret_pagos'];
                $Ninv_pagos901=$row_Recordset901['inv_pagos'];
                $Ntot_eliminad901=$row_Recordset901['tot_eliminad'];
                $Nret_porpagar901=$row_Recordset901['ret_porpagar'];
                $Ninv_porpagar901=$row_Recordset901['inv_porpagar'];
                $Npre_porpagar901=$row_Recordset901['pre_porpagar'];
                $NinvCanAnu901=$row_Recordset901['tot_eliminad']+$row_Recordset901['inv_pagos']+$row_Recordset901['ret_pagos'];
                $NinvCanAnu2901=$NinvCanAnu901+$row_Recordset901['inv_porpagar']+$row_Recordset901['ret_porpagar'];
                $NenCaja901=$row_Recordset901['total_venta']-$NinvCanAnu901-$row_Recordset901['tot_premios'];
                $totAnuTaquilla901=$row_Recordset901['ret_total']+$row_Recordset901['inv_total']+$row_Recordset901['tot_eliminad'];
                $NpagoSistema901=(($row_Recordset901['total_venta']-$totAnuTaquilla901)*$row_Recordset901['taq_cob_hnac'])/100;
                $Neliminados901=$row_Recordset901['con_tic_eli'];

?>
<?php
                $query_Recordset902 = sprintf(
    "/* PARSEADORES1 agente_hnac\base_hnac\bVenta_us_hnac.php - QUERY 4 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla, ta.efectivoO,
					ta.taq_cob_hnac,
					tp.ver_porpagar_hnac,
					SUM(CASE WHEN fec_venta_hnac >= %s AND fec_venta_hnac <= %s 
						THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 2 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s 
						THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagos,

					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 5 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
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
					ve.efectivoOn = 2 AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset902 = mysqli_query($conexionbanca, $query_Recordset902) or die(mysqli_error($conexionbanca));
                $row_Recordset902 = mysqli_fetch_assoc($Recordset902);
                $totalRows_Recordset902 = mysqli_num_rows($Recordset902);
                $vendedor902=strtoupper($row_Recordset902['nom_usuario']);
                $Ntotal_venta902=$row_Recordset902['total_venta'];
                $Ntot_premios902=$row_Recordset902['tot_premios'];
                $Nret_pagos902=$row_Recordset902['ret_pagos'];
                $Ninv_pagos902=$row_Recordset902['inv_pagos'];
                $Ntot_eliminad902=$row_Recordset902['tot_eliminad'];
                $Nret_porpagar902=$row_Recordset902['ret_porpagar'];
                $Ninv_porpagar902=$row_Recordset902['inv_porpagar'];
                $Npre_porpagar902=$row_Recordset902['pre_porpagar'];
                $NinvCanAnu902=$row_Recordset902['tot_eliminad']+$row_Recordset902['inv_pagos']+$row_Recordset902['ret_pagos'];
                $NinvCanAnu2902=$NinvCanAnu902+$row_Recordset902['inv_porpagar']+$row_Recordset902['ret_porpagar'];
                $NenCaja902=$row_Recordset902['total_venta']-$NinvCanAnu902-$row_Recordset902['tot_premios'];
                $totAnuTaquilla902=$row_Recordset902['ret_total']+$row_Recordset902['inv_total']+$row_Recordset902['tot_eliminad'];
                $NpagoSistema902=(($row_Recordset902['total_venta']-$totAnuTaquilla902)*$row_Recordset902['taq_cob_hnac'])/100;
                $Neliminados902=$row_Recordset902['con_tic_eli'];

?>
<?php
                $query_Recordset903 = sprintf(
    "/* PARSEADORES1 agente_hnac\base_hnac\bVenta_us_hnac.php - QUERY 5 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla, ta.efectivoO,
					ta.taq_cob_hnac,
					tp.ver_porpagar_hnac,
					SUM(CASE WHEN fec_venta_hnac >= %s AND fec_venta_hnac <= %s 
						THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 2 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s 
						THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagos,

					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 5 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
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
					ve.efectivoOn = %s AND
					us.id_usuario = %s 
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
    GetSQLValueString(3, "int"),
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset903 = mysqli_query($conexionbanca, $query_Recordset903) or die(mysqli_error($conexionbanca));
                $row_Recordset903 = mysqli_fetch_assoc($Recordset903);
                $totalRows_Recordset903 = mysqli_num_rows($Recordset903);
                $vendedor903=strtoupper($row_Recordset903['nom_usuario']);
                $Ntotal_venta903=$row_Recordset903['total_venta'];
                $Ntot_premios903=$row_Recordset903['tot_premios'];
                $Nret_pagos903=$row_Recordset903['ret_pagos'];
                $Ninv_pagos903=$row_Recordset903['inv_pagos'];
                $Ntot_eliminad903=$row_Recordset903['tot_eliminad'];
                $Nret_porpagar903=$row_Recordset903['ret_porpagar'];
                $Ninv_porpagar903=$row_Recordset903['inv_porpagar'];
                $Npre_porpagar903=$row_Recordset903['pre_porpagar'];
                $NinvCanAnu903=$row_Recordset903['tot_eliminad']+$row_Recordset903['inv_pagos']+$row_Recordset903['ret_pagos'];
                $NinvCanAnu2903=$NinvCanAnu903+$row_Recordset903['inv_porpagar']+$row_Recordset903['ret_porpagar'];
                $NenCaja903=$row_Recordset903['total_venta']-$NinvCanAnu903-$row_Recordset903['tot_premios'];
                $totAnuTaquilla903=$row_Recordset903['ret_total']+$row_Recordset903['inv_total']+$row_Recordset903['tot_eliminad'];
                $NpagoSistema903=(($row_Recordset903['total_venta']-$totAnuTaquilla903)*$row_Recordset903['taq_cob_hnac'])/100;
                $Neliminados903=$row_Recordset903['con_tic_eli'];

?>
<?php
                $query_Recordset904 = sprintf(
    "/* PARSEADORES1 agente_hnac\base_hnac\bVenta_us_hnac.php - QUERY 6 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla, ta.efectivoO,
					ta.taq_cob_hnac,
					tp.ver_porpagar_hnac,
					SUM(CASE WHEN fec_venta_hnac >= %s AND fec_venta_hnac <= %s 
						THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 2 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s 
						THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagos,

					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 5 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
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
					ve.efectivoOn = 4 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta_hnac >= %s AND 
					ve.fec_venta_hnac <= %s OR 
					ve.fec_pago_hnac >= %s AND 
					ve.fec_pago_hnac <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					ve.cod_carrera_hnac = ca.cod_carrera_hnac AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset904 = mysqli_query($conexionbanca, $query_Recordset904) or die(mysqli_error($conexionbanca));
                $row_Recordset904 = mysqli_fetch_assoc($Recordset904);
                $totalRows_Recordset904 = mysqli_num_rows($Recordset904);
                $vendedor904=strtoupper($row_Recordset904['nom_usuario']);
                $Ntotal_venta904=$row_Recordset904['total_venta'];
                $Ntot_premios904=$row_Recordset904['tot_premios'];
                $Nret_pagos904=$row_Recordset904['ret_pagos'];
                $Ninv_pagos904=$row_Recordset904['inv_pagos'];
                $Ntot_eliminad904=$row_Recordset904['tot_eliminad'];
                $Nret_porpagar904=$row_Recordset904['ret_porpagar'];
                $Ninv_porpagar904=$row_Recordset904['inv_porpagar'];
                $Npre_porpagar904=$row_Recordset904['pre_porpagar'];
                $NinvCanAnu904=$row_Recordset904['tot_eliminad']+$row_Recordset904['inv_pagos']+$row_Recordset904['ret_pagos'];
                $NinvCanAnu2904=$NinvCanAnu904+$row_Recordset904['inv_porpagar']+$row_Recordset904['ret_porpagar'];
                $NenCaja904=$row_Recordset904['total_venta']-$NinvCanAnu904-$row_Recordset904['tot_premios'];
                $totAnuTaquilla904=$row_Recordset904['ret_total']+$row_Recordset904['inv_total']+$row_Recordset904['tot_eliminad'];
                $NpagoSistema904=(($row_Recordset904['total_venta']-$totAnuTaquilla904)*$row_Recordset904['taq_cob_hnac'])/100;
                $Neliminados904=$row_Recordset904['con_tic_eli'];

?>
<?php
                $query_Recordset905 = sprintf(
    "/* PARSEADORES1 agente_hnac\base_hnac\bVenta_us_hnac.php - QUERY 7 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla, ta.efectivoO,
					ta.taq_cob_hnac,
					tp.ver_porpagar_hnac,
					SUM(CASE WHEN fec_venta_hnac >= %s AND fec_venta_hnac <= %s 
						THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 2 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s 
						THEN ve.pag_premio_hnac ELSE 0 END) AS tot_premios,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 0 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS tot_eliminad,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_pagos,

					SUM(CASE WHEN ve.est_ticket_hnac = 4 AND ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
						THEN ve.mon_venta_hnac ELSE 0 END) AS ret_total,

					SUM(CASE WHEN ve.est_ticket_hnac = 1 AND ve.est_calculo_hnac = 4 AND 
						ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s THEN ve.mon_venta_hnac ELSE 0 END) AS ret_porpagar,
					
					SUM(CASE WHEN ve.est_ticket_hnac = 5 AND ve.fec_pago_hnac >= %s AND ve.fec_pago_hnac <= %s
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
					ve.efectivoOn = 5 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta_hnac >= %s AND 
					ve.fec_venta_hnac <= %s OR 
					ve.fec_pago_hnac >= %s AND 
					ve.fec_pago_hnac <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					ve.cod_carrera_hnac = ca.cod_carrera_hnac AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset905 = mysqli_query($conexionbanca, $query_Recordset905) or die(mysqli_error($conexionbanca));
                $row_Recordset905 = mysqli_fetch_assoc($Recordset905);
                $totalRows_Recordset905 = mysqli_num_rows($Recordset905);
                $vendedor905=strtoupper($row_Recordset905['nom_usuario']);
                $Ntotal_venta905=$row_Recordset905['total_venta'];
                $Ntot_premios905=$row_Recordset905['tot_premios'];
                $Nret_pagos905=$row_Recordset905['ret_pagos'];
                $Ninv_pagos905=$row_Recordset905['inv_pagos'];
                $Ntot_eliminad905=$row_Recordset905['tot_eliminad'];
                $Nret_porpagar905=$row_Recordset905['ret_porpagar'];
                $Ninv_porpagar905=$row_Recordset905['inv_porpagar'];
                $Npre_porpagar905=$row_Recordset905['pre_porpagar'];
                $NinvCanAnu905=$row_Recordset905['tot_eliminad']+$row_Recordset905['inv_pagos']+$row_Recordset905['ret_pagos'];
                $NinvCanAnu2905=$NinvCanAnu905+$row_Recordset905['inv_porpagar']+$row_Recordset905['ret_porpagar'];
                $NenCaja905=$row_Recordset905['total_venta']-$NinvCanAnu905-$row_Recordset905['tot_premios'];
                $totAnuTaquilla905=$row_Recordset905['ret_total']+$row_Recordset905['inv_total']+$row_Recordset905['tot_eliminad'];
                $NpagoSistema905=(($row_Recordset905['total_venta']-$totAnuTaquilla905)*$row_Recordset905['taq_cob_hnac'])/100;
                $Neliminados905=$row_Recordset905['con_tic_eli'];

?>
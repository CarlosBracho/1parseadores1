<?php
                $query_Recordset81 = sprintf(
    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 1 */ SELECT
 					us.nom_usuario,
					ta.nom_taquilla,
					ta.taq_por_ame,
					ta.moneda,
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
					
					SUM(CASE WHEN  ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
						THEN 1 ELSE 0 END) AS con_tic_eli
					FROM 
					agencia ag,
                    banca ba, 
					taquilla ta,
					taquilla_opc_ame tp, 
					usuario us,
					venta ve
USE INDEX(id_us_fe_fe)
					WHERE
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta >= %s AND 
					ve.fec_venta <= %s OR 
					ve.fec_pago >= %s AND 
					ve.fec_pago <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
                    ag.cod_banca = ba.cod_banca AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset81 = mysqli_query($conexionbanca, $query_Recordset81) or die(mysqli_error($conexionbanca));
                $row_Recordset81 = mysqli_fetch_assoc($Recordset81);
                $totalRows_Recordset81 = mysqli_num_rows($Recordset81);
                $vendedor=strtoupper($row_Recordset81['nom_usuario']);
                $query_Recordset = sprintf(
                    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 2 */ SELECT cod_taquilla FROM taquilla_opc_hnac WHERE cod_taquilla = %s LIMIT 1",
                    GetSQLValueString($codigoDistri, "int")
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
?>
<?php
                $query_Recordset900 = sprintf(
    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 3 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla,
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
					
					SUM(CASE WHEN  ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
						THEN 1 ELSE 0 END) AS con_tic_eli
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_ame tp, 
					usuario us,
                    banca ba,
					venta ve
USE INDEX(id_us_fe_fe)
					WHERE
					ve.efectivoO = 0 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta >= %s AND 
					ve.fec_venta <= %s OR 
					ve.fec_pago >= %s AND 
					ve.fec_pago <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
                    ag.cod_banca = ba.cod_banca AND
					ba.cod_banca = %s 
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
    GetSQLValueString($codigoDistri, "int")
);
                $Recordset900 = mysqli_query($conexionbanca, $query_Recordset900) or die(mysqli_error($conexionbanca));
                $row_Recordset900 = mysqli_fetch_assoc($Recordset900);
                $totalRows_Recordset900 = mysqli_num_rows($Recordset900);
                $vendedor0=strtoupper($row_Recordset900['nom_usuario']);
                $query_Recordset = sprintf(
                    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 4 */ SELECT cod_taquilla FROM taquilla_opc_hnac WHERE cod_taquilla = %s LIMIT 1",
                    GetSQLValueString($codigoDistri, "int")
                );
                $Recordset = mysqli_query($conexionbanca, $query_Recordset) or die(mysqli_error($conexionbanca));
                $row_Recordset = mysqli_fetch_assoc($Recordset);$totalRows_Recordset = mysqli_num_rows($Recordset);
                if ($totalRows_Recordset>0) {
                    $hnac=1;
                } else {
                    $hnac=0;
                } mysqli_free_result($Recordset);
                $Atotal_venta0=$row_Recordset900['total_venta'];
                $Atot_premios0=$row_Recordset900['tot_premios'];
                $Aret_pagos0=$row_Recordset900['ret_pagos'];
                $Ainv_pagos0=$row_Recordset900['inv_pagos'];
                $Atot_eliminad0=$row_Recordset900['tot_eliminad'];
                $Aret_porpagar0=$row_Recordset900['ret_porpagar'];
                $Ainv_porpagar0=$row_Recordset900['inv_porpagar'];
                $Apre_porpagar0=$row_Recordset900['pre_porpagar'];
                $AinvCanAnu0=$row_Recordset900['tot_eliminad']+$row_Recordset900['inv_pagos']+$row_Recordset900['ret_pagos'];
                $AinvCanAnu20=$AinvCanAnu0+$row_Recordset900['inv_porpagar']+$row_Recordset900['ret_porpagar'];
                $AenCaja0=$row_Recordset900['total_venta']-$AinvCanAnu0-$row_Recordset900['tot_premios'];
                $totAnuTaquilla0=$row_Recordset900['ret_total']+$row_Recordset900['inv_total']+$row_Recordset900['tot_eliminad'];
                $ApagoSistema0=(($row_Recordset900['total_venta']-$totAnuTaquilla0)*$row_Recordset900['taq_por_ame'])/100;
                $Aeliminados0=$row_Recordset900['con_tic_eli'];
?>

<?php
                $query_Recordset901 = sprintf(
    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 5 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla,
					ta.taq_por_ame,
					ta.efectivoO,
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
					
					SUM(CASE WHEN  ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
						THEN 1 ELSE 0 END) AS con_tic_eli
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_ame tp, 
					usuario us,
                    banca ba,
					venta ve
USE INDEX(id_us_fe_fe)
					WHERE
					ve.efectivoO = 1 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta >= %s AND 
					ve.fec_venta <= %s OR 
					ve.fec_pago >= %s AND 
					ve.fec_pago <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
                    ag.cod_banca = ba.cod_banca AND
					ba.cod_banca = %s 
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
    GetSQLValueString($codigoDistri, "int")
);
                $Recordset901 = mysqli_query($conexionbanca, $query_Recordset901) or die(mysqli_error($conexionbanca));
                $row_Recordset901 = mysqli_fetch_assoc($Recordset901);
                $totalRows_Recordset901 = mysqli_num_rows($Recordset901);
                $vendedor1=strtoupper($row_Recordset901['nom_usuario']);
                $query_Recordset = sprintf(
                    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 6 */ SELECT cod_taquilla FROM taquilla_opc_hnac WHERE cod_taquilla = %s LIMIT 1",
                    GetSQLValueString($codigoDistri, "int")
                );
                $Recordset = mysqli_query($conexionbanca, $query_Recordset) or die(mysqli_error($conexionbanca));
                $row_Recordset = mysqli_fetch_assoc($Recordset);$totalRows_Recordset = mysqli_num_rows($Recordset);
                if ($totalRows_Recordset>0) {
                    $hnac=1;
                } else {
                    $hnac=0;
                } mysqli_free_result($Recordset);
                $Atotal_venta1=$row_Recordset901['total_venta'];
                $Atot_premios1=$row_Recordset901['tot_premios'];
                $Aret_pagos1=$row_Recordset901['ret_pagos'];
                $Ainv_pagos1=$row_Recordset901['inv_pagos'];
                $Atot_eliminad1=$row_Recordset901['tot_eliminad'];
                $Aret_porpagar1=$row_Recordset901['ret_porpagar'];
                $Ainv_porpagar1=$row_Recordset901['inv_porpagar'];
                $Apre_porpagar1=$row_Recordset901['pre_porpagar'];
                $AinvCanAnu1=$row_Recordset901['tot_eliminad']+$row_Recordset901['inv_pagos']+$row_Recordset901['ret_pagos'];
                $AinvCanAnu21=$AinvCanAnu1+$row_Recordset901['inv_porpagar']+$row_Recordset901['ret_porpagar'];
                $AenCaja1=$row_Recordset901['total_venta']-$AinvCanAnu1-$row_Recordset901['tot_premios'];
                $totAnuTaquilla1=$row_Recordset901['ret_total']+$row_Recordset901['inv_total']+$row_Recordset901['tot_eliminad'];
                $ApagoSistema1=(($row_Recordset901['total_venta']-$totAnuTaquilla1)*$row_Recordset901['taq_por_ame'])/100;
                $Aeliminados1=$row_Recordset901['con_tic_eli'];
?>
<?php
                $query_Recordset902 = sprintf(
    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 7 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla,
					ta.taq_por_ame,
					ta.efectivoO,
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
					
					SUM(CASE WHEN  ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
						THEN 1 ELSE 0 END) AS con_tic_eli
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_ame tp, 
					usuario us,
                    banca ba,
					venta ve
USE INDEX(id_us_fe_fe)
					WHERE
					ve.efectivoO = 2 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta >= %s AND 
					ve.fec_venta <= %s OR 
					ve.fec_pago >= %s AND 
					ve.fec_pago <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset902 = mysqli_query($conexionbanca, $query_Recordset902) or die(mysqli_error($conexionbanca));
                $row_Recordset902 = mysqli_fetch_assoc($Recordset902);
                $totalRows_Recordset902 = mysqli_num_rows($Recordset902);
                $vendedor2=strtoupper($row_Recordset902['nom_usuario']);
                $query_Recordset = sprintf(
                    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 8 */ SELECT cod_taquilla FROM taquilla_opc_hnac WHERE cod_taquilla = %s LIMIT 1",
                    GetSQLValueString($codigoDistri, "int")
                );
                $Recordset = mysqli_query($conexionbanca, $query_Recordset) or die(mysqli_error($conexionbanca));
                $row_Recordset = mysqli_fetch_assoc($Recordset);$totalRows_Recordset = mysqli_num_rows($Recordset);
                if ($totalRows_Recordset>0) {
                    $hnac=1;
                } else {
                    $hnac=0;
                } mysqli_free_result($Recordset);
                $Atotal_venta2=$row_Recordset902['total_venta'];
                $Atot_premios2=$row_Recordset902['tot_premios'];
                $Aret_pagos2=$row_Recordset902['ret_pagos'];
                $Ainv_pagos2=$row_Recordset902['inv_pagos'];
                $Atot_eliminad2=$row_Recordset902['tot_eliminad'];
                $Aret_porpagar2=$row_Recordset902['ret_porpagar'];
                $Ainv_porpagar2=$row_Recordset902['inv_porpagar'];
                $Apre_porpagar2=$row_Recordset902['pre_porpagar'];
                $AinvCanAnu2=$row_Recordset902['tot_eliminad']+$row_Recordset902['inv_pagos']+$row_Recordset902['ret_pagos'];
                $AinvCanAnu22=$AinvCanAnu2+$row_Recordset902['inv_porpagar']+$row_Recordset902['ret_porpagar'];
                $AenCaja2=$row_Recordset902['total_venta']-$AinvCanAnu2-$row_Recordset902['tot_premios'];
                $totAnuTaquilla2=$row_Recordset902['ret_total']+$row_Recordset902['inv_total']+$row_Recordset902['tot_eliminad'];
                $ApagoSistema2=(($row_Recordset902['total_venta']-$totAnuTaquilla2)*$row_Recordset902['taq_por_ame'])/100;
                $Aeliminados2=$row_Recordset902['con_tic_eli'];
?>
<?php
                $query_Recordset903 = sprintf(
    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 9 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla,
					ta.taq_por_ame,
					ta.efectivoO,
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
					
					SUM(CASE WHEN  ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
						THEN 1 ELSE 0 END) AS con_tic_eli
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_ame tp, 
					usuario us,
                    banca ba,
					venta ve
USE INDEX(id_us_fe_fe)
					WHERE
					ve.efectivoO = 3 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta >= %s AND 
					ve.fec_venta <= %s OR 
					ve.fec_pago >= %s AND 
					ve.fec_pago <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset903 = mysqli_query($conexionbanca, $query_Recordset903) or die(mysqli_error($conexionbanca));
                $row_Recordset903 = mysqli_fetch_assoc($Recordset903);
                $totalRows_Recordset903 = mysqli_num_rows($Recordset903);
                $vendedor3=strtoupper($row_Recordset903['nom_usuario']);
                $query_Recordset = sprintf(
                    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 10 */ SELECT cod_taquilla FROM taquilla_opc_hnac WHERE cod_taquilla = %s LIMIT 1",
                    GetSQLValueString($codigoDistri, "int")
                );
                $Recordset = mysqli_query($conexionbanca, $query_Recordset) or die(mysqli_error($conexionbanca));
                $row_Recordset = mysqli_fetch_assoc($Recordset);$totalRows_Recordset = mysqli_num_rows($Recordset);
                if ($totalRows_Recordset>0) {
                    $hnac=1;
                } else {
                    $hnac=0;
                } mysqli_free_result($Recordset);
                $Atotal_venta3=$row_Recordset903['total_venta'];
                $Atot_premios3=$row_Recordset903['tot_premios'];
                $Aret_pagos3=$row_Recordset903['ret_pagos'];
                $Ainv_pagos3=$row_Recordset903['inv_pagos'];
                $Atot_eliminad3=$row_Recordset903['tot_eliminad'];
                $Aret_porpagar3=$row_Recordset903['ret_porpagar'];
                $Ainv_porpagar3=$row_Recordset903['inv_porpagar'];
                $Apre_porpagar3=$row_Recordset903['pre_porpagar'];
                $AinvCanAnu3=$row_Recordset903['tot_eliminad']+$row_Recordset903['inv_pagos']+$row_Recordset903['ret_pagos'];
                $AinvCanAnu23=$AinvCanAnu2+$row_Recordset903['inv_porpagar']+$row_Recordset903['ret_porpagar'];
                $AenCaja3=$row_Recordset903['total_venta']-$AinvCanAnu3-$row_Recordset903['tot_premios'];
                $totAnuTaquilla3=$row_Recordset903['ret_total']+$row_Recordset903['inv_total']+$row_Recordset903['tot_eliminad'];
                $ApagoSistema3=(($row_Recordset903['total_venta']-$totAnuTaquilla3)*$row_Recordset903['taq_por_ame'])/100;
                $Aeliminados3=$row_Recordset903['con_tic_eli'];
?>
<?php
                $query_Recordset904 = sprintf(
    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 11 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla,
					ta.taq_por_ame,
					ta.efectivoO,
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
					
					SUM(CASE WHEN  ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
						THEN 1 ELSE 0 END) AS con_tic_eli
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_ame tp, 
					usuario us,
					venta ve
USE INDEX(id_us_fe_fe)
					WHERE
					ve.efectivoO = 4 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta >= %s AND 
					ve.fec_venta <= %s OR 
					ve.fec_pago >= %s AND 
					ve.fec_pago <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset904 = mysqli_query($conexionbanca, $query_Recordset904) or die(mysqli_error($conexionbanca));
                $row_Recordset904 = mysqli_fetch_assoc($Recordset904);
                $totalRows_Recordset904 = mysqli_num_rows($Recordset904);
                $vendedor4=strtoupper($row_Recordset904['nom_usuario']);
                $query_Recordset = sprintf(
                    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 12 */ SELECT cod_taquilla FROM taquilla_opc_hnac WHERE cod_taquilla = %s LIMIT 1",
                    GetSQLValueString($codigoDistri, "int")
                );
                $Recordset = mysqli_query($conexionbanca, $query_Recordset) or die(mysqli_error($conexionbanca));
                $row_Recordset = mysqli_fetch_assoc($Recordset);$totalRows_Recordset = mysqli_num_rows($Recordset);
                if ($totalRows_Recordset>0) {
                    $hnac=1;
                } else {
                    $hnac=0;
                } mysqli_free_result($Recordset);
                $Atotal_venta4=$row_Recordset904['total_venta'];
                $Atot_premios4=$row_Recordset904['tot_premios'];
                $Aret_pagos4=$row_Recordset904['ret_pagos'];
                $Ainv_pagos4=$row_Recordset904['inv_pagos'];
                $Atot_eliminad4=$row_Recordset904['tot_eliminad'];
                $Aret_porpagar4=$row_Recordset904['ret_porpagar'];
                $Ainv_porpagar4=$row_Recordset904['inv_porpagar'];
                $Apre_porpagar4=$row_Recordset904['pre_porpagar'];
                $AinvCanAnu4=$row_Recordset904['tot_eliminad']+$row_Recordset904['inv_pagos']+$row_Recordset904['ret_pagos'];
                $AinvCanAnu24=$AinvCanAnu4+$row_Recordset904['inv_porpagar']+$row_Recordset904['ret_porpagar'];
                $AenCaja4=$row_Recordset904['total_venta']-$AinvCanAnu4-$row_Recordset904['tot_premios'];
                $totAnuTaquilla4=$row_Recordset904['ret_total']+$row_Recordset904['inv_total']+$row_Recordset904['tot_eliminad'];
                $ApagoSistema4=(($row_Recordset904['total_venta']-$totAnuTaquilla4)*$row_Recordset904['taq_por_ame'])/100;
                $Aeliminados4=$row_Recordset904['con_tic_eli'];
?>
<?php
                $query_Recordset905 = sprintf(
    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 13 */ SELECT 
					us.nom_usuario,
					ta.nom_taquilla,
					ta.taq_por_ame,
					ta.efectivoO,
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
					
					SUM(CASE WHEN  ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s
						THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
					
					SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1
						THEN 1 ELSE 0 END) AS con_tic_eli
					FROM 
					agencia ag, 
					taquilla ta,
					taquilla_opc_ame tp, 
					usuario us,
					venta ve
USE INDEX(id_us_fe_fe)
					WHERE
					ve.efectivoO = 5 AND
					ta.cod_taquilla = us.cod_taquilla AND
					ve.id_usuario = us.id_usuario AND
					(ve.fec_venta >= %s AND 
					ve.fec_venta <= %s OR 
					ve.fec_pago >= %s AND 
					ve.fec_pago <= %s) AND 
					ag.cod_agencia = ta.cod_agencia AND 
					tp.cod_taquilla = ta.cod_taquilla AND
					us.id_usuario = %s 
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
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset905 = mysqli_query($conexionbanca, $query_Recordset905) or die(mysqli_error($conexionbanca));
                $row_Recordset905 = mysqli_fetch_assoc($Recordset905);
                $totalRows_Recordset905 = mysqli_num_rows($Recordset905);
                $vendedor5=strtoupper($row_Recordset905['nom_usuario']);
                $query_Recordset = sprintf(
                    "/* PARSEADORES1 distri\base_ame\bVenta_us_ame.php - QUERY 14 */ SELECT cod_taquilla FROM taquilla_opc_hnac WHERE cod_taquilla = %s LIMIT 1",
                    GetSQLValueString($codigoDistri, "int")
                );
                $Recordset = mysqli_query($conexionbanca, $query_Recordset) or die(mysqli_error($conexionbanca));
                $row_Recordset = mysqli_fetch_assoc($Recordset);$totalRows_Recordset = mysqli_num_rows($Recordset);
                if ($totalRows_Recordset>0) {
                    $hnac=1;
                } else {
                    $hnac=0;
                } mysqli_free_result($Recordset);
                $Atotal_venta5=$row_Recordset905['total_venta'];
                $Atot_premios5=$row_Recordset905['tot_premios'];
                $Aret_pagos5=$row_Recordset905['ret_pagos'];
                $Ainv_pagos5=$row_Recordset905['inv_pagos'];
                $Atot_eliminad5=$row_Recordset905['tot_eliminad'];
                $Aret_porpagar5=$row_Recordset905['ret_porpagar'];
                $Ainv_porpagar5=$row_Recordset905['inv_porpagar'];
                $Apre_porpagar5=$row_Recordset905['pre_porpagar'];
                $AinvCanAnu5=$row_Recordset905['tot_eliminad']+$row_Recordset905['inv_pagos']+$row_Recordset905['ret_pagos'];
                $AinvCanAnu25=$AinvCanAnu5+$row_Recordset905['inv_porpagar']+$row_Recordset905['ret_porpagar'];
                $AenCaja5=$row_Recordset905['total_venta']-$AinvCanAnu5-$row_Recordset905['tot_premios'];
                $totAnuTaquilla5=$row_Recordset905['ret_total']+$row_Recordset905['inv_total']+$row_Recordset905['tot_eliminad'];
                $ApagoSistema5=(($row_Recordset905['total_venta']-$totAnuTaquilla5)*$row_Recordset905['taq_por_ame'])/100;
                $Aeliminados5=$row_Recordset905['con_tic_eli'];
?>


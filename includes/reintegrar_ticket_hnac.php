<?php
    $query_Recordset10 = sprintf("/* PARSEADORES1 includes\reintegrar_ticket_hnac.php - QUERY 1 */ SELECT cod_hipodromo_hnac  
		FROM carrera_hnac WHERE cod_carrera_hnac", GetSQLValueString($car, "int"));
    $Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
    $row_Recordset10 = mysqli_fetch_assoc($Recordset10);
    $totalRows_Recordset10 = mysqli_num_rows($Recordset10);
    if ($row_Recordset10['cod_hipodromo_hnac']==1) {
        $query_Recordset0 = sprintf("/* PARSEADORES1 includes\reintegrar_ticket_hnac.php - QUERY 2 */ SELECT ta.cod_taquilla FROM taquilla ta, taquilla_opc_hnac tp WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND tp.est_taquilla_hnac = 1 AND tp.def_ran_regdiv_hnac = 1");
    }
    if ($row_Recordset10['cod_hipodromo_hnac']==2) {
        $query_Recordset0 = sprintf("/* PARSEADORES1 includes\reintegrar_ticket_hnac.php - QUERY 3 */ SELECT ta.cod_taquilla FROM taquilla ta, taquilla_opc_hnac tp WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND tp.est_taquilla_hnac = 1 AND tp.def_san_regdiv_hnac = 1");
    }
    if ($row_Recordset10['cod_hipodromo_hnac']==3) {
        $query_Recordset0 = sprintf("/* PARSEADORES1 includes\reintegrar_ticket_hnac.php - QUERY 4 */ SELECT ta.cod_taquilla FROM taquilla ta, taquilla_opc_hnac tp WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND tp.est_taquilla_hnac = 1 AND tp.def_val_regdiv_hnac = 1");
    }
    if ($row_Recordset10['cod_hipodromo_hnac']==4) {
        $query_Recordset0 = sprintf("/* PARSEADORES1 includes\reintegrar_ticket_hnac.php - QUERY 5 */ SELECT ta.cod_taquilla FROM taquilla ta, taquilla_opc_hnac tp WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND tp.est_taquilla_hnac = 1 AND tp.def_rin_regdiv_hnac = 1");
    }
    $Recordset0 = mysqli_query($conexionbanca, $query_Recordset0) or die(mysqli_error($conexionbanca));
    $row_Recordset0 = mysqli_fetch_assoc($Recordset0);
    $totalRows_Recordset0 = mysqli_num_rows($Recordset0);
    if ($totalRows_Recordset0>0) {
        do {
            $taq=$row_Recordset0['cod_taquilla'];
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 includes\reintegrar_ticket_hnac.php - QUERY 6 */ SELECT ve.num_ticket_hnac
				FROM 
				venta_hnac ve, 
				carrera_hnac ca, 
				usuario us,
				taquilla_opc_hnac tp
				WHERE 
				ve.cod_carrera_hnac = %s AND
				tp.cod_taquilla = %s AND
				ve.est_ticket_hnac = 1 AND
				ve.est_calculo_hnac > 0 AND
				ve.pag_premio_hnac > 0 AND
				ve.id_usuario = us.id_usuario AND
				us.cod_taquilla  = tp.cod_taquilla AND 
				ca.cod_carrera_hnac = ve.cod_carrera_hnac",
                GetSQLValueString($car, "int"),
                GetSQLValueString($taq, "int")
            );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            if ($totalRows_Recordset1>0) {
                $updateSQL3 = sprintf(
                    "/* PARSEADORES1 includes\reintegrar_ticket_hnac.php - QUERY 7 */ UPDATE venta_hnac 
				SET pag_premio_hnac=%s, est_calculo_hnac=%s 
					WHERE num_ticket_hnac=%s",
                    GetSQLValueString(0, "double"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString($row_Recordset1['num_ticket_hnac'], "int")
                );
                $Result3 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));
            }
        } while ($row_Recordset0 = mysqli_fetch_assoc($Recordset0));
    }
    if (isset($Recordset0)) {
        mysqli_free_result($Recordset0);
    }
    if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }

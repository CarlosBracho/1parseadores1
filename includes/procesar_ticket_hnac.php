<?php
    if ($row_Recordset10['cod_hipodromo_hnac']==1) {
        $query_Recordset0 = sprintf("/* PARSEADORES1 includes\procesar_ticket_hnac.php - QUERY 1 */ SELECT ta.cod_taquilla FROM taquilla ta, taquilla_opc_hnac tp WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND ta.est_taquilla_hnac = 1 AND tp.def_ran_regdiv_hnac = 1");
    }
    if ($row_Recordset10['cod_hipodromo_hnac']==2) {
        $query_Recordset0 = sprintf("/* PARSEADORES1 includes\procesar_ticket_hnac.php - QUERY 2 */ SELECT ta.cod_taquilla FROM taquilla ta, taquilla_opc_hnac tp WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND ta.est_taquilla_hnac = 1 AND tp.def_san_regdiv_hnac = 1");
    }
    if ($row_Recordset10['cod_hipodromo_hnac']==3) {
        $query_Recordset0 = sprintf("/* PARSEADORES1 includes\procesar_ticket_hnac.php - QUERY 3 */ SELECT ta.cod_taquilla FROM taquilla ta, taquilla_opc_hnac tp WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND ta.est_taquilla_hnac = 1 AND tp.def_val_regdiv_hnac = 1");
    }
    if ($row_Recordset10['cod_hipodromo_hnac']==4) {
        $query_Recordset0 = sprintf("/* PARSEADORES1 includes\procesar_ticket_hnac.php - QUERY 4 */ SELECT ta.cod_taquilla FROM taquilla ta, taquilla_opc_hnac tp WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND ta.est_taquilla_hnac = 1 AND tp.def_rin_regdiv_hnac = 1");
    }
    $Recordset0 = mysqli_query($conexionbanca, $query_Recordset0) or die(mysqli_error($conexionbanca));
    $row_Recordset0 = mysqli_fetch_assoc($Recordset0);
    $totalRows_Recordset0 = mysqli_num_rows($Recordset0);
    if ($totalRows_Recordset0>0) {
        if (is_file('../includes/calculodepago_hnac.php')) {
            include("../includes/calculodepago_hnac.php");
        }
        $fec=$row_Recordset10['fec_carrera_hnac'];
        $car=$_POST['rA'];
        do {
            $taq=$row_Recordset0['cod_taquilla'];
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 includes\procesar_ticket_hnac.php - QUERY 5 */ SELECT 
						ve.id_usuario, ve.cod_carrera_hnac, ve.fec_venta_hnac, ve.num_ticket_hnac, ve.mon_venta_hnac,
						ve.ser_venta_hnac, ve.cod_tventa_hnac, ca.cod_carrera_hnac, ve.est_ticket_hnac, 
						ca.est_carrera_hnac, ca.est_cierre_hnac, ca.cod_hipodromo_hnac, ca.fec_carrera_hnac,
						us.cod_taquilla, tp.tic_caduca_hnac, ve.pag_premio_hnac,
						
						tp.div_ran_pdes_hnac, tp.div_ran_phas_hnac, tp.opc_ran_pdiv_hnac, tp.pag_ran_pdiv_hnac, 
						tp.div_ran_sdes_hnac, tp.div_ran_shas_hnac, tp.opc_ran_sdiv_hnac, tp.pag_ran_sdiv_hnac, 
						tp.div_ran_tdes_hnac, tp.div_ran_thas_hnac, tp.opc_ran_tdiv_hnac, tp.pag_ran_tdiv_hnac, 
						tp.div_ran_ddes_hnac, tp.div_ran_dhas_hnac, tp.opc_ran_ddiv_hnac, tp.pag_ran_ddiv_hnac, 
						tp.div_ran_qdes_hnac, tp.div_ran_qhas_hnac, tp.opc_ran_qdiv_hnac, tp.pag_ran_qdiv_hnac, 
						tp.def_ran_regdiv_hnac,

						tp.ran_eje_des1_hnac, tp.ran_eje_has1_hnac, tp.ran_eje_des2_hnac, tp.ran_eje_has2_hnac,
						tp.ran_eje_des3_hnac, tp.ran_eje_has3_hnac, tp.ran_eje_des4_hnac, tp.ran_eje_has4_hnac,
						tp.ran_eje_des5_hnac, tp.ran_eje_has5_hnac,

						tp.div_san_pdes_hnac, tp.div_san_phas_hnac, tp.opc_san_pdiv_hnac, tp.pag_san_pdiv_hnac, 
						tp.div_san_sdes_hnac, tp.div_san_shas_hnac, tp.opc_san_sdiv_hnac, tp.pag_san_sdiv_hnac, 
						tp.div_san_tdes_hnac, tp.div_san_thas_hnac, tp.opc_san_tdiv_hnac, tp.pag_san_tdiv_hnac, 
						tp.div_san_ddes_hnac, tp.div_san_dhas_hnac, tp.opc_san_ddiv_hnac, tp.pag_san_ddiv_hnac, 
						tp.div_san_qdes_hnac, tp.div_san_qhas_hnac, tp.opc_san_qdiv_hnac, tp.pag_san_qdiv_hnac, 
						tp.def_san_regdiv_hnac,

						tp.san_eje_des1_hnac, tp.san_eje_has1_hnac, tp.san_eje_des2_hnac, tp.san_eje_has2_hnac,
						tp.san_eje_des3_hnac, tp.san_eje_has3_hnac, tp.san_eje_des4_hnac, tp.san_eje_has4_hnac,
						tp.san_eje_des5_hnac, tp.san_eje_has5_hnac,

						tp.div_val_pdes_hnac, tp.div_val_phas_hnac, tp.opc_val_pdiv_hnac, tp.pag_val_pdiv_hnac, 
						tp.div_val_sdes_hnac, tp.div_val_shas_hnac, tp.opc_val_sdiv_hnac, tp.pag_val_sdiv_hnac, 
						tp.div_val_tdes_hnac, tp.div_val_thas_hnac, tp.opc_val_tdiv_hnac, tp.pag_val_tdiv_hnac, 
						tp.div_val_ddes_hnac, tp.div_val_dhas_hnac, tp.opc_val_ddiv_hnac, tp.pag_val_ddiv_hnac, 
						tp.div_val_qdes_hnac, tp.div_val_qhas_hnac, tp.opc_val_qdiv_hnac, tp.pag_val_qdiv_hnac, 
						tp.def_val_regdiv_hnac,
						
						tp.val_eje_des1_hnac, tp.val_eje_has1_hnac, tp.val_eje_des2_hnac, tp.val_eje_has2_hnac,
						tp.val_eje_des3_hnac, tp.val_eje_has3_hnac, tp.val_eje_des4_hnac, tp.val_eje_has4_hnac,
						tp.val_eje_des5_hnac, tp.val_eje_has5_hnac, 					

						tp.div_rin_pdes_hnac, tp.div_rin_phas_hnac, tp.opc_rin_pdiv_hnac, tp.pag_rin_pdiv_hnac, 
						tp.div_rin_sdes_hnac, tp.div_rin_shas_hnac, tp.opc_rin_sdiv_hnac, tp.pag_rin_sdiv_hnac, 
						tp.div_rin_tdes_hnac, tp.div_rin_thas_hnac, tp.opc_rin_tdiv_hnac, tp.pag_rin_tdiv_hnac, 
						tp.div_rin_ddes_hnac, tp.div_rin_dhas_hnac, tp.opc_rin_ddiv_hnac, tp.pag_rin_ddiv_hnac, 
						tp.div_rin_qdes_hnac, tp.div_rin_qhas_hnac, tp.opc_rin_qdiv_hnac, tp.pag_rin_qdiv_hnac, 
						tp.def_rin_regdiv_hnac,
						
						tp.rin_eje_des1_hnac, tp.rin_eje_has1_hnac, tp.rin_eje_des2_hnac, tp.rin_eje_has2_hnac,
						tp.rin_eje_des3_hnac, tp.rin_eje_has3_hnac, tp.rin_eje_des4_hnac, tp.rin_eje_has4_hnac,
						tp.rin_eje_des5_hnac, tp.rin_eje_has5_hnac,
						
						tp.div_rin_6des_hnac, tp.div_rin_6has_hnac, tp.opc_rin_6div_hnac, tp.pag_rin_6div_hnac, 
						tp.div_rin_7des_hnac, tp.div_rin_7has_hnac, tp.opc_rin_7div_hnac, tp.pag_rin_7div_hnac,	
						tp.div_rin_8des_hnac, tp.div_rin_8has_hnac, tp.opc_rin_8div_hnac, tp.pag_rin_8div_hnac,	
						tp.div_val_6des_hnac, tp.div_val_6has_hnac, tp.opc_val_6div_hnac, tp.pag_val_6div_hnac,
						tp.div_val_7des_hnac, tp.div_val_7has_hnac, tp.opc_val_7div_hnac, tp.pag_val_7div_hnac,
						tp.div_val_8des_hnac, tp.div_val_8has_hnac, tp.opc_val_8div_hnac, tp.pag_val_8div_hnac,
						tp.div_san_6des_hnac, tp.div_san_6has_hnac, tp.opc_san_6div_hnac, tp.pag_san_6div_hnac,
						tp.div_san_7des_hnac, tp.div_san_7has_hnac, tp.opc_san_7div_hnac, tp.pag_san_7div_hnac,
						tp.div_san_8des_hnac, tp.div_san_8has_hnac, tp.opc_san_8div_hnac, tp.pag_san_8div_hnac,
						tp.div_ran_6des_hnac, tp.div_ran_6has_hnac, tp.opc_ran_6div_hnac, tp.pag_ran_6div_hnac,
						tp.div_ran_7des_hnac, tp.div_ran_7has_hnac, tp.opc_ran_7div_hnac, tp.pag_ran_7div_hnac,
						tp.div_ran_8des_hnac, tp.div_ran_8has_hnac, tp.opc_ran_8div_hnac, tp.pag_ran_8div_hnac,
						tp.rin_eje_des6_hnac, tp.rin_eje_has6_hnac, tp.rin_eje_des7_hnac, tp.rin_eje_has7_hnac,
						tp.rin_eje_des8_hnac, tp.rin_eje_has8_hnac, tp.val_eje_des6_hnac, tp.val_eje_has6_hnac,
						tp.val_eje_des7_hnac, tp.val_eje_has7_hnac, tp.val_eje_des8_hnac, tp.val_eje_has8_hnac,
						tp.san_eje_des6_hnac, tp.san_eje_has6_hnac, tp.san_eje_des7_hnac, tp.san_eje_has7_hnac,
						tp.san_eje_des8_hnac, tp.san_eje_has8_hnac, tp.ran_eje_des6_hnac, tp.ran_eje_has6_hnac,
						tp.ran_eje_des7_hnac, tp.ran_eje_has7_hnac, tp.ran_eje_des8_hnac, tp.ran_eje_has8_hnac,
						
						tp.emp_ran_reg1_hnac, tp.emp_ran_reg2_hnac, tp.emp_ran_reg3_hnac, tp.emp_ran_reg4_hnac,
						tp.emp_ran_reg5_hnac, tp.emp_ran_reg6_hnac, tp.emp_ran_reg7_hnac, tp.emp_ran_reg8_hnac,
						tp.emp_san_reg1_hnac, tp.emp_san_reg2_hnac, tp.emp_san_reg3_hnac, tp.emp_san_reg4_hnac,
						tp.emp_san_reg5_hnac, tp.emp_san_reg6_hnac, tp.emp_san_reg7_hnac, tp.emp_san_reg8_hnac,
						tp.emp_val_reg1_hnac, tp.emp_val_reg2_hnac, tp.emp_val_reg3_hnac, tp.emp_val_reg4_hnac,
						tp.emp_val_reg5_hnac, tp.emp_val_reg6_hnac, tp.emp_val_reg7_hnac, tp.emp_val_reg8_hnac,
						tp.emp_rin_reg1_hnac, tp.emp_rin_reg2_hnac, tp.emp_rin_reg3_hnac, tp.emp_rin_reg4_hnac,
						tp.emp_rin_reg5_hnac, tp.emp_rin_reg6_hnac, tp.emp_rin_reg7_hnac, tp.emp_rin_reg8_hnac,

						top_pfav_hnac, top_sfav_hnac, top_tfav_hnac, top_dem_hnac, ve.est_calculo_hnac,
						
						est_tope_ran, top_pfav_ran_hnac, top_sfav_ran_hnac, top_tfav_ran_hnac, top_dem_ran_hnac, 
						est_tope_val, top_pfav_val_hnac, top_sfav_val_hnac, top_tfav_val_hnac, top_dem_val_hnac,
						est_tope_san, top_pfav_san_hnac, top_sfav_san_hnac, top_tfav_san_hnac, top_dem_san_hnac,
						est_tope_rin, top_pfav_rin_hnac, top_sfav_rin_hnac, top_tfav_rin_hnac, top_dem_rin_hnac,

						ve.num_caballo_hnac, tp.cab_min_hnac, ca.est_confirmacion_hnac, tp.redondeo_hnac
				FROM 
				venta_hnac ve, 
				carrera_hnac ca, 
				usuario us,
				taquilla_opc_hnac tp
				WHERE 
				ve.cod_carrera_hnac = %s AND
				tp.cod_taquilla = %s AND
				ve.fec_venta_hnac = %s AND
				ve.est_ticket_hnac = 1 AND
				ve.id_usuario = us.id_usuario AND
				us.cod_taquilla  = tp.cod_taquilla AND 
				ca.cod_carrera_hnac = ve.cod_carrera_hnac",
                GetSQLValueString($car, "int"),
                GetSQLValueString($taq, "int"),
                GetSQLValueString($fec, "date")
            );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            if ($totalRows_Recordset1>0) {
                $redondeo_hnac=$row_Recordset1['redondeo_hnac'];
                $montoapagar=0;
                $retirados=arrayRetiradosHNAC($car);
                $montoapagar=0;
                $montoretiro=0;
                $i=0;
                $estado=array(0);
                $x_nTicket=array(0);
                $x_pagoSencillo=array(0);
                $cabMin=$row_Recordset1['cab_min_hnac'];
                $tEjem=enCarrera_HNAC($car);//ejemplares en carrera
                if ($tEjem>=$cabMin) {
                    if ($row_Recordset1['cod_hipodromo_hnac']==1) {
                        $defi_regla=$row_Recordset1['def_ran_regdiv_hnac'];
                    }// ran
                    if ($row_Recordset1['cod_hipodromo_hnac']==2) {
                        $defi_regla=$row_Recordset1['def_san_regdiv_hnac'];
                    }// san
                    if ($row_Recordset1['cod_hipodromo_hnac']==3) {
                        $defi_regla=$row_Recordset1['def_val_regdiv_hnac'];
                    }// val
                    if ($row_Recordset1['cod_hipodromo_hnac']==4) {
                        $defi_regla=$row_Recordset1['def_rin_regdiv_hnac'];
                    }// rin
                    $tope1=$row_Recordset1['top_pfav_hnac'];  ///topes globales
                    $tope2=$row_Recordset1['top_sfav_hnac'];  ///topes globales
                    $tope3=$row_Recordset1['top_tfav_hnac'];  ///topes globales
                    $tope4=$row_Recordset1['top_dem_hnac'];   ///topes globales
                    if ($row_Recordset1['cod_hipodromo_hnac']==1) {
                        $regla1_desd=$row_Recordset1['div_ran_pdes_hnac'];
                        $regla1_hast=$row_Recordset1['div_ran_phas_hnac'];
                        $regla1_opci=$row_Recordset1['opc_ran_pdiv_hnac'];
                        $regla1_paga=$row_Recordset1['pag_ran_pdiv_hnac'];
                        $regla2_desd=$row_Recordset1['div_ran_sdes_hnac'];
                        $regla2_hast=$row_Recordset1['div_ran_shas_hnac'];
                        $regla2_opci=$row_Recordset1['opc_ran_sdiv_hnac'];
                        $regla2_paga=$row_Recordset1['pag_ran_sdiv_hnac'];
                        $regla3_desd=$row_Recordset1['div_ran_tdes_hnac'];
                        $regla3_hast=$row_Recordset1['div_ran_thas_hnac'];
                        $regla3_opci=$row_Recordset1['opc_ran_tdiv_hnac'];
                        $regla3_paga=$row_Recordset1['pag_ran_tdiv_hnac'];
                        $regla4_desd=$row_Recordset1['div_ran_ddes_hnac'];
                        $regla4_hast=$row_Recordset1['div_ran_dhas_hnac'];
                        $regla4_opci=$row_Recordset1['opc_ran_ddiv_hnac'];
                        $regla4_paga=$row_Recordset1['pag_ran_ddiv_hnac'];
                        $regla5_desd=$row_Recordset1['div_ran_qdes_hnac'];
                        $regla5_hast=$row_Recordset1['div_ran_qhas_hnac'];
                        $regla5_opci=$row_Recordset1['opc_ran_qdiv_hnac'];
                        $regla5_paga=$row_Recordset1['pag_ran_qdiv_hnac'];
                        $regla6_desd=$row_Recordset1['div_ran_6des_hnac'];
                        $regla6_hast=$row_Recordset1['div_ran_6has_hnac'];
                        $regla6_opci=$row_Recordset1['opc_ran_6div_hnac'];
                        $regla6_paga=$row_Recordset1['pag_ran_6div_hnac'];
                        $regla7_desd=$row_Recordset1['div_ran_7des_hnac'];
                        $regla7_hast=$row_Recordset1['div_ran_7has_hnac'];
                        $regla7_opci=$row_Recordset1['opc_ran_7div_hnac'];
                        $regla7_paga=$row_Recordset1['pag_ran_7div_hnac'];
                        $regla8_desd=$row_Recordset1['div_ran_8des_hnac'];
                        $regla8_hast=$row_Recordset1['div_ran_8has_hnac'];
                        $regla8_opci=$row_Recordset1['opc_ran_8div_hnac'];
                        $regla8_paga=$row_Recordset1['pag_ran_8div_hnac'];
                        $regla1_EjeD=$row_Recordset1['ran_eje_des1_hnac'];
                        $regla1_EjeH=$row_Recordset1['ran_eje_has1_hnac'];
                        $regla2_EjeD=$row_Recordset1['ran_eje_des2_hnac'];
                        $regla2_EjeH=$row_Recordset1['ran_eje_has2_hnac'];
                        $regla3_EjeD=$row_Recordset1['ran_eje_des3_hnac'];
                        $regla3_EjeH=$row_Recordset1['ran_eje_has3_hnac'];
                        $regla4_EjeD=$row_Recordset1['ran_eje_des4_hnac'];
                        $regla4_EjeH=$row_Recordset1['ran_eje_has4_hnac'];
                        $regla5_EjeD=$row_Recordset1['ran_eje_des5_hnac'];
                        $regla5_EjeH=$row_Recordset1['ran_eje_has5_hnac'];
                        $regla6_EjeD=$row_Recordset1['ran_eje_des6_hnac'];
                        $regla6_EjeH=$row_Recordset1['ran_eje_has6_hnac'];
                        $regla7_EjeD=$row_Recordset1['ran_eje_des7_hnac'];
                        $regla7_EjeH=$row_Recordset1['ran_eje_has7_hnac'];
                        $regla8_EjeD=$row_Recordset1['ran_eje_des8_hnac'];
                        $regla8_EjeH=$row_Recordset1['ran_eje_has8_hnac'];
                        $emp_regla1=$row_Recordset1['emp_ran_reg1_hnac'];
                        $emp_regla2=$row_Recordset1['emp_ran_reg2_hnac'];
                        $emp_regla3=$row_Recordset1['emp_ran_reg3_hnac'];
                        $emp_regla4=$row_Recordset1['emp_ran_reg4_hnac'];
                        $emp_regla5=$row_Recordset1['emp_ran_reg5_hnac'];
                        $emp_regla6=$row_Recordset1['emp_ran_reg6_hnac'];
                        $emp_regla7=$row_Recordset1['emp_ran_reg7_hnac'];
                        $emp_regla8=$row_Recordset1['emp_ran_reg8_hnac'];
                        if ($row_Recordset1['est_tope_ran']==1) {
                            $tope1=$row_Recordset1['top_pfav_ran_hnac'];
                            $tope2=$row_Recordset1['top_sfav_ran_hnac'];
                            $tope3=$row_Recordset1['top_tfav_ran_hnac'];
                            $tope4=$row_Recordset1['top_dem_ran_hnac'];
                        }
                    }
                    if ($row_Recordset1['cod_hipodromo_hnac']==2) {
                        $regla1_desd=$row_Recordset1['div_san_pdes_hnac'];
                        $regla1_hast=$row_Recordset1['div_san_phas_hnac'];
                        $regla1_opci=$row_Recordset1['opc_san_pdiv_hnac'];
                        $regla1_paga=$row_Recordset1['pag_san_pdiv_hnac'];
                        $regla2_desd=$row_Recordset1['div_san_sdes_hnac'];
                        $regla2_hast=$row_Recordset1['div_san_shas_hnac'];
                        $regla2_opci=$row_Recordset1['opc_san_sdiv_hnac'];
                        $regla2_paga=$row_Recordset1['pag_san_sdiv_hnac'];
                        $regla3_desd=$row_Recordset1['div_san_tdes_hnac'];
                        $regla3_hast=$row_Recordset1['div_san_thas_hnac'];
                        $regla3_opci=$row_Recordset1['opc_san_tdiv_hnac'];
                        $regla3_paga=$row_Recordset1['pag_san_tdiv_hnac'];
                        $regla4_desd=$row_Recordset1['div_san_ddes_hnac'];
                        $regla4_hast=$row_Recordset1['div_san_dhas_hnac'];
                        $regla4_opci=$row_Recordset1['opc_san_ddiv_hnac'];
                        $regla4_paga=$row_Recordset1['pag_san_ddiv_hnac'];
                        $regla5_desd=$row_Recordset1['div_san_qdes_hnac'];
                        $regla5_hast=$row_Recordset1['div_san_qhas_hnac'];
                        $regla5_opci=$row_Recordset1['opc_san_qdiv_hnac'];
                        $regla5_paga=$row_Recordset1['pag_san_qdiv_hnac'];
                        $regla6_desd=$row_Recordset1['div_san_6des_hnac'];
                        $regla6_hast=$row_Recordset1['div_san_6has_hnac'];
                        $regla6_opci=$row_Recordset1['opc_san_6div_hnac'];
                        $regla6_paga=$row_Recordset1['pag_san_6div_hnac'];
                        $regla7_desd=$row_Recordset1['div_san_7des_hnac'];
                        $regla7_hast=$row_Recordset1['div_san_7has_hnac'];
                        $regla7_opci=$row_Recordset1['opc_san_7div_hnac'];
                        $regla7_paga=$row_Recordset1['pag_san_7div_hnac'];
                        $regla8_desd=$row_Recordset1['div_san_8des_hnac'];
                        $regla8_hast=$row_Recordset1['div_san_8has_hnac'];
                        $regla8_opci=$row_Recordset1['opc_san_8div_hnac'];
                        $regla8_paga=$row_Recordset1['pag_san_8div_hnac'];
                        $regla1_EjeD=$row_Recordset1['san_eje_des1_hnac'];
                        $regla1_EjeH=$row_Recordset1['san_eje_has1_hnac'];
                        $regla2_EjeD=$row_Recordset1['san_eje_des2_hnac'];
                        $regla2_EjeH=$row_Recordset1['san_eje_has2_hnac'];
                        $regla3_EjeD=$row_Recordset1['san_eje_des3_hnac'];
                        $regla3_EjeH=$row_Recordset1['san_eje_has3_hnac'];
                        $regla4_EjeD=$row_Recordset1['san_eje_des4_hnac'];
                        $regla4_EjeH=$row_Recordset1['san_eje_has4_hnac'];
                        $regla5_EjeD=$row_Recordset1['san_eje_des5_hnac'];
                        $regla5_EjeH=$row_Recordset1['san_eje_has5_hnac'];
                        $regla6_EjeD=$row_Recordset1['san_eje_des6_hnac'];
                        $regla6_EjeH=$row_Recordset1['san_eje_has6_hnac'];
                        $regla7_EjeD=$row_Recordset1['san_eje_des7_hnac'];
                        $regla7_EjeH=$row_Recordset1['san_eje_has7_hnac'];
                        $regla8_EjeD=$row_Recordset1['san_eje_des8_hnac'];
                        $regla8_EjeH=$row_Recordset1['san_eje_has8_hnac'];
                        $emp_regla1=$row_Recordset1['emp_san_reg1_hnac'];
                        $emp_regla2=$row_Recordset1['emp_san_reg2_hnac'];
                        $emp_regla3=$row_Recordset1['emp_san_reg3_hnac'];
                        $emp_regla4=$row_Recordset1['emp_san_reg4_hnac'];
                        $emp_regla5=$row_Recordset1['emp_san_reg5_hnac'];
                        $emp_regla6=$row_Recordset1['emp_san_reg6_hnac'];
                        $emp_regla7=$row_Recordset1['emp_san_reg7_hnac'];
                        $emp_regla8=$row_Recordset1['emp_san_reg8_hnac'];
                        if ($row_Recordset1['est_tope_san']==1) {
                            $tope1=$row_Recordset1['top_pfav_san_hnac'];
                            $tope2=$row_Recordset1['top_sfav_san_hnac'];
                            $tope3=$row_Recordset1['top_tfav_san_hnac'];
                            $tope4=$row_Recordset1['top_dem_san_hnac'];
                        }
                    }
                    if ($row_Recordset1['cod_hipodromo_hnac']==3) {
                        $regla1_desd=$row_Recordset1['div_val_pdes_hnac'];
                        $regla1_hast=$row_Recordset1['div_val_phas_hnac'];
                        $regla1_opci=$row_Recordset1['opc_val_pdiv_hnac'];
                        $regla1_paga=$row_Recordset1['pag_val_pdiv_hnac'];
                        $regla2_desd=$row_Recordset1['div_val_sdes_hnac'];
                        $regla2_hast=$row_Recordset1['div_val_shas_hnac'];
                        $regla2_opci=$row_Recordset1['opc_val_sdiv_hnac'];
                        $regla2_paga=$row_Recordset1['pag_val_sdiv_hnac'];
                        $regla3_desd=$row_Recordset1['div_val_tdes_hnac'];
                        $regla3_hast=$row_Recordset1['div_val_thas_hnac'];
                        $regla3_opci=$row_Recordset1['opc_val_tdiv_hnac'];
                        $regla3_paga=$row_Recordset1['pag_val_tdiv_hnac'];
                        $regla4_desd=$row_Recordset1['div_val_ddes_hnac'];
                        $regla4_hast=$row_Recordset1['div_val_dhas_hnac'];
                        $regla4_opci=$row_Recordset1['opc_val_ddiv_hnac'];
                        $regla4_paga=$row_Recordset1['pag_val_ddiv_hnac'];
                        $regla5_desd=$row_Recordset1['div_val_qdes_hnac'];
                        $regla5_hast=$row_Recordset1['div_val_qhas_hnac'];
                        $regla5_opci=$row_Recordset1['opc_val_qdiv_hnac'];
                        $regla5_paga=$row_Recordset1['pag_val_qdiv_hnac'];
                        $regla6_desd=$row_Recordset1['div_val_6des_hnac'];
                        $regla6_hast=$row_Recordset1['div_val_6has_hnac'];
                        $regla6_opci=$row_Recordset1['opc_val_6div_hnac'];
                        $regla6_paga=$row_Recordset1['pag_val_6div_hnac'];
                        $regla7_desd=$row_Recordset1['div_val_7des_hnac'];
                        $regla7_hast=$row_Recordset1['div_val_7has_hnac'];
                        $regla7_opci=$row_Recordset1['opc_val_7div_hnac'];
                        $regla7_paga=$row_Recordset1['pag_val_7div_hnac'];
                        $regla8_desd=$row_Recordset1['div_val_8des_hnac'];
                        $regla8_hast=$row_Recordset1['div_val_8has_hnac'];
                        $regla8_opci=$row_Recordset1['opc_val_8div_hnac'];
                        $regla8_paga=$row_Recordset1['pag_val_8div_hnac'];
                        $regla1_EjeD=$row_Recordset1['val_eje_des1_hnac'];
                        $regla1_EjeH=$row_Recordset1['val_eje_has1_hnac'];
                        $regla2_EjeD=$row_Recordset1['val_eje_des2_hnac'];
                        $regla2_EjeH=$row_Recordset1['val_eje_has2_hnac'];
                        $regla3_EjeD=$row_Recordset1['val_eje_des3_hnac'];
                        $regla3_EjeH=$row_Recordset1['val_eje_has3_hnac'];
                        $regla4_EjeD=$row_Recordset1['val_eje_des4_hnac'];
                        $regla4_EjeH=$row_Recordset1['val_eje_has4_hnac'];
                        $regla5_EjeD=$row_Recordset1['val_eje_des5_hnac'];
                        $regla5_EjeH=$row_Recordset1['val_eje_has5_hnac'];
                        $regla6_EjeD=$row_Recordset1['val_eje_des6_hnac'];
                        $regla6_EjeH=$row_Recordset1['val_eje_has6_hnac'];
                        $regla7_EjeD=$row_Recordset1['val_eje_des7_hnac'];
                        $regla7_EjeH=$row_Recordset1['val_eje_has7_hnac'];
                        $regla8_EjeD=$row_Recordset1['val_eje_des8_hnac'];
                        $regla8_EjeH=$row_Recordset1['val_eje_has8_hnac'];
                        $emp_regla1=$row_Recordset1['emp_val_reg1_hnac'];
                        $emp_regla2=$row_Recordset1['emp_val_reg2_hnac'];
                        $emp_regla3=$row_Recordset1['emp_val_reg3_hnac'];
                        $emp_regla4=$row_Recordset1['emp_val_reg4_hnac'];
                        $emp_regla5=$row_Recordset1['emp_val_reg5_hnac'];
                        $emp_regla6=$row_Recordset1['emp_val_reg6_hnac'];
                        $emp_regla7=$row_Recordset1['emp_val_reg7_hnac'];
                        $emp_regla8=$row_Recordset1['emp_val_reg8_hnac'];
                        if ($row_Recordset1['est_tope_val']==1) {
                            $tope1=$row_Recordset1['top_pfav_val_hnac'];
                            $tope2=$row_Recordset1['top_sfav_val_hnac'];
                            $tope3=$row_Recordset1['top_tfav_val_hnac'];
                            $tope4=$row_Recordset1['top_dem_val_hnac'];
                        }
                    }
                    if ($row_Recordset1['cod_hipodromo_hnac']==4) {
                        $regla1_desd=$row_Recordset1['div_rin_pdes_hnac'];
                        $regla1_hast=$row_Recordset1['div_rin_phas_hnac'];
                        $regla1_opci=$row_Recordset1['opc_rin_pdiv_hnac'];
                        $regla1_paga=$row_Recordset1['pag_rin_pdiv_hnac'];
                        $regla2_desd=$row_Recordset1['div_rin_sdes_hnac'];
                        $regla2_hast=$row_Recordset1['div_rin_shas_hnac'];
                        $regla2_opci=$row_Recordset1['opc_rin_sdiv_hnac'];
                        $regla2_paga=$row_Recordset1['pag_rin_sdiv_hnac'];
                        $regla3_desd=$row_Recordset1['div_rin_tdes_hnac'];
                        $regla3_hast=$row_Recordset1['div_rin_thas_hnac'];
                        $regla3_opci=$row_Recordset1['opc_rin_tdiv_hnac'];
                        $regla3_paga=$row_Recordset1['pag_rin_tdiv_hnac'];
                        $regla4_desd=$row_Recordset1['div_rin_ddes_hnac'];
                        $regla4_hast=$row_Recordset1['div_rin_dhas_hnac'];
                        $regla4_opci=$row_Recordset1['opc_rin_ddiv_hnac'];
                        $regla4_paga=$row_Recordset1['pag_rin_ddiv_hnac'];
                        $regla5_desd=$row_Recordset1['div_rin_qdes_hnac'];
                        $regla5_hast=$row_Recordset1['div_rin_qhas_hnac'];
                        $regla5_opci=$row_Recordset1['opc_rin_qdiv_hnac'];
                        $regla5_paga=$row_Recordset1['pag_rin_qdiv_hnac'];
                        $regla6_desd=$row_Recordset1['div_rin_6des_hnac'];
                        $regla6_hast=$row_Recordset1['div_rin_6has_hnac'];
                        $regla6_opci=$row_Recordset1['opc_rin_6div_hnac'];
                        $regla6_paga=$row_Recordset1['pag_rin_6div_hnac'];
                        $regla7_desd=$row_Recordset1['div_rin_7des_hnac'];
                        $regla7_hast=$row_Recordset1['div_rin_7has_hnac'];
                        $regla7_opci=$row_Recordset1['opc_rin_7div_hnac'];
                        $regla7_paga=$row_Recordset1['pag_rin_7div_hnac'];
                        $regla8_desd=$row_Recordset1['div_rin_8des_hnac'];
                        $regla8_hast=$row_Recordset1['div_rin_8has_hnac'];
                        $regla8_opci=$row_Recordset1['opc_rin_8div_hnac'];
                        $regla8_paga=$row_Recordset1['pag_rin_8div_hnac'];
                        $regla1_EjeD=$row_Recordset1['rin_eje_des1_hnac'];
                        $regla1_EjeH=$row_Recordset1['rin_eje_has1_hnac'];
                        $regla2_EjeD=$row_Recordset1['rin_eje_des2_hnac'];
                        $regla2_EjeH=$row_Recordset1['rin_eje_has2_hnac'];
                        $regla3_EjeD=$row_Recordset1['rin_eje_des3_hnac'];
                        $regla3_EjeH=$row_Recordset1['rin_eje_has3_hnac'];
                        $regla4_EjeD=$row_Recordset1['rin_eje_des4_hnac'];
                        $regla4_EjeH=$row_Recordset1['rin_eje_has4_hnac'];
                        $regla5_EjeD=$row_Recordset1['rin_eje_des5_hnac'];
                        $regla5_EjeH=$row_Recordset1['rin_eje_has5_hnac'];
                        $regla6_EjeD=$row_Recordset1['rin_eje_des6_hnac'];
                        $regla6_EjeH=$row_Recordset1['rin_eje_has6_hnac'];
                        $regla7_EjeD=$row_Recordset1['rin_eje_des7_hnac'];
                        $regla7_EjeH=$row_Recordset1['rin_eje_has7_hnac'];
                        $regla8_EjeD=$row_Recordset1['rin_eje_des8_hnac'];
                        $regla8_EjeH=$row_Recordset1['rin_eje_has8_hnac'];
                        $emp_regla1=$row_Recordset1['emp_rin_reg1_hnac'];
                        $emp_regla2=$row_Recordset1['emp_rin_reg2_hnac'];
                        $emp_regla3=$row_Recordset1['emp_rin_reg3_hnac'];
                        $emp_regla4=$row_Recordset1['emp_rin_reg4_hnac'];
                        $emp_regla5=$row_Recordset1['emp_rin_reg5_hnac'];
                        $emp_regla6=$row_Recordset1['emp_rin_reg6_hnac'];
                        $emp_regla7=$row_Recordset1['emp_rin_reg7_hnac'];
                        $emp_regla8=$row_Recordset1['emp_rin_reg8_hnac'];
                        if ($row_Recordset1['est_tope_rin']==1) {
                            $tope1=$row_Recordset1['top_pfav_rin_hnac'];
                            $tope2=$row_Recordset1['top_sfav_rin_hnac'];
                            $tope3=$row_Recordset1['top_tfav_rin_hnac'];
                            $tope4=$row_Recordset1['top_dem_rin_hnac'];
                        }
                    }
                    do {
                        $pago[0]=0;
                        $pago[1]="";
                        $retiro=0;
                        if ($retirados[0]!="0") {
                            if (in_array($row_Recordset1['num_caballo_hnac'], $retirados, true)) {
                                $retiro=1;
                            }
                            if ($row_Recordset1['cod_tventa_hnac']>=4 && $row_Recordset1['cod_tventa_hnac']<=9) {
                                $fcab=explode("-", $row_Recordset1['num_caballo_hnac']);
                                foreach ($fcab as $mtz1) {
                                    if (in_array($mtz1, $retirados, true)) {
                                        $retiro=1;
                                        break;
                                    }
                                }
                            }
                        }
                        if ($retiro==0) {
                            if ($row_Recordset1['cod_tventa_hnac']>=1 && $row_Recordset1['cod_tventa_hnac']<=3) {
                                $numCab=$row_Recordset1['num_caballo_hnac'];
                                $tipVenta=$row_Recordset1['cod_tventa_hnac'];
                                $monVenta=$row_Recordset1['mon_venta_hnac'];
                                $pago=jNormaHNAC(
                                    $defi_regla,
                                    $numCab,
                                    $car,
                                    $fec,
                                    $monVenta,
                                    $taq,
                                    $tipVenta,
                                    $regla1_desd,
                                    $regla1_hast,
                                    $regla1_opci,
                                    $regla1_paga,
                                    $regla2_desd,
                                    $regla2_hast,
                                    $regla2_opci,
                                    $regla2_paga,
                                    $regla3_desd,
                                    $regla3_hast,
                                    $regla3_opci,
                                    $regla3_paga,
                                    $regla4_desd,
                                    $regla4_hast,
                                    $regla4_opci,
                                    $regla4_paga,
                                    $regla5_desd,
                                    $regla5_hast,
                                    $regla5_opci,
                                    $regla5_paga,
                                    $regla6_desd,
                                    $regla6_hast,
                                    $regla6_opci,
                                    $regla6_paga,
                                    $regla7_desd,
                                    $regla7_hast,
                                    $regla7_opci,
                                    $regla7_paga,
                                    $regla8_desd,
                                    $regla8_hast,
                                    $regla8_opci,
                                    $regla8_paga,
                                    $tope1,
                                    $tope2,
                                    $tope3,
                                    $tope4,
                                    $regla1_EjeD,
                                    $regla1_EjeH,
                                    $regla2_EjeD,
                                    $regla2_EjeH,
                                    $regla3_EjeD,
                                    $regla3_EjeH,
                                    $regla4_EjeD,
                                    $regla4_EjeH,
                                    $regla5_EjeD,
                                    $regla5_EjeH,
                                    $regla6_EjeD,
                                    $regla6_EjeH,
                                    $regla7_EjeD,
                                    $regla7_EjeH,
                                    $regla8_EjeD,
                                    $regla8_EjeH,
                                    $emp_regla1,
                                    $emp_regla2,
                                    $emp_regla3,
                                    $emp_regla4,
                                    $emp_regla5,
                                    $emp_regla6,
                                    $emp_regla7,
                                    $emp_regla8,
                                    $redondeo_hnac
                                );
                                if ($pago[0]>0) {
                                    $montoapagar=$pago[0]+$montoapagar;
                                    $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                                    $estado[$i]=$pago[1];
                                    $x_pagoSencillo[$i]=$pago[0];
                                    $i=$i+1;
                                } else {
                                    $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                                    $estado[$i]=1;
                                    $x_pagoSencillo[$i]=0;
                                    $i=$i+1;
                                }
                            }
                        } else {
                            $montoretiro=$montoretiro+$row_Recordset1['mon_venta_hnac'];
                            $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                            $estado[$i]="4";
                            $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                            $i=$i+1;
                        }
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                } else {
                    if ($tEjem<$cabMin) {
                        do {
                            $montoapagar=$montoapagar+$row_Recordset1['mon_venta_hnac'];
                            $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                            $estado[$i]="5";
                            $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                            $i=$i+1;
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    }
                }
                $x=0;
                do {
                    $updateSQL3 = sprintf(
                        "/* PARSEADORES1 includes\procesar_ticket_hnac.php - QUERY 6 */ UPDATE venta_hnac 
					SET pag_premio_hnac=%s, est_calculo_hnac=%s 
						WHERE num_ticket_hnac=%s",
                        GetSQLValueString($x_pagoSencillo[$x], "double"),
                        GetSQLValueString($estado[$x], "int"),
                        GetSQLValueString($x_nTicket[$x], "int")
                    );
                    $Result3 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));
                    $x++;
                } while ($x < $i);
            }
        } while ($row_Recordset0 = mysqli_fetch_assoc($Recordset0));
    }
    if (isset($Recordset0)) {
        mysqli_free_result($Recordset0);
    }
    if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }

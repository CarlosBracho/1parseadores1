<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menAgen="";
$menTaq="";
$menNre="";
$menTel="";
$menAmig="";	//monto apuesta minima a gan
$menAmag="";
$menRgan="";
$menMgan="";	// monto maximo a ganar a ganador
$menMmt="";		// monto maximo en ticket
$menAmip="";	//monto apuesta minima a pla
$menAmap="";
$menRpla="";
$menMpla="";
$menAmis="";	//monto apuesta minima a sho
$menAmas="";
$menRsho="";
$menMsho="";
$menMmae="";
$menAmie="";	//monto apuesta minima a exa
$menAmae="";
$menRexa="";
$menMexa="";
$menAmit="";	//monto apuesta minima a tri
$menAmat="";
$menRtri="";
$menMtri="";
$menAmisu="";	//monto apuesta minima a sup
$menAmasu="";
$menRsup="";
$menMsup="";
$menNus="";
$menNti="";
$menTeli="";	// maximo ticket a eliminar
$hor_in="9";
$min_in="0";
$am_in="AM";
$hor_fi="11";
$min_fi="55";
$am_fi="PM";
$dia1="1";
$dia2="1";
$dia3="1";
$dia4="1";
$dia5="1";
$dia6="1";
$dia7="1";
$menNus="";
$menNcus="";
$menPass="";
$menHin="";

$est_tope_rin="";
$top_pfav_rin_hnac="";
$top_sfav_rin_hnac="";
$top_tfav_rin_hnac="";
$top_dem_rin_hnac="";

$est_tope_ran="";
$top_pfav_ran_hnac="";
$top_sfav_ran_hnac="";
$top_tfav_ran_hnac="";
$top_dem_ran_hnac="";

$est_tope_san="";
$top_pfav_san_hnac="";
$top_sfav_san_hnac="";
$top_tfav_san_hnac="";
$top_dem_san_hnac="";

$est_tope_val="";
$top_pfav_val_hnac="";
$top_sfav_val_hnac="";
$top_tfav_val_hnac="";
$top_dem_val_hnac="";

$editFormAction = $_SERVER['PHP_SELF'];
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction2 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$menOpNac="";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    $control=0;
    $contron=0;
    $hora_ini=$_POST['hor_in'].":".$_POST['min_in'].":".$_POST['am_in'];
    $hora_fin=$_POST['hor_fi'].":".$_POST['min_fi'].":".$_POST['am_fi'];
    $hora_ini=horamysql($hora_ini);
    $hora_fin=horamysql($hora_fin);
    if (isset($_POST['nom_taquilla']) && $_POST['nom_taquilla']!="") {
        if (buscaTaq($_POST['nom_taquilla'])>0) {
            $menTaq="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_taquilla']=="" || strlen($_POST['nom_taquilla'])<=3) {
        $menTaq="nombre no válido";
        $graba--;
    }
    
    if (isset($_POST['nom_usuario']) && $_POST['nom_usuario']!="") {
        if (buscaUsu($_POST['nom_usuario'])>0) {
            $menNus="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_usuario']=="" || strlen($_POST['nom_usuario'])<=3) {
        $menNus="nombre no válido";
        $graba--;
    }
    if ($_POST['pas_usuario']=="" || strlen($_POST['pas_usuario'])<=3) {
        $menPass="debe contener 4 caracteres o mas";
        $graba--;
    }
    if ($hora_ini>$hora_fin || $hora_ini==$hora_fin) {
        $menHin="error en horas";
        $graba--;
    }
    if (isset($_POST['dia7'])) {
        $trabaja="1";
    } else {
        $trabaja="0";
    }
    if (isset($_POST['dia1'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia2'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia3'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia4'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia5'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia6'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if ($graba==31) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 distri_hnac\distri_taquillas_add_hnac.php - QUERY 1 */ INSERT 
			INTO taquilla 
			(nom_taquilla, nom_representante, tel_taquilla, tel_taquilla2, tel_taquilla3, cod_agencia, est_taquilla) 
			VALUES (%s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_taquilla']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_representante']), "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString($_POST['tel_taquilla2'], "text"),
            GetSQLValueString($_POST['tel_taquilla3'], "text"),
            GetSQLValueString($_POST['cod_agencia'], "int"),
            GetSQLValueString(1, "int")
        );// estatus de taquilla
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $query_RecT = "/* PARSEADORES1 distri_hnac\distri_taquillas_add_hnac.php - QUERY 2 */ SELECT cod_taquilla FROM taquilla ORDER BY cod_taquilla DESC LIMIT 1";
        $RecT = mysqli_query($conexionbanca, $query_RecT) or die(mysqli_error($conexionbanca));
        $row_RecT = mysqli_fetch_assoc($RecT);
        $totalRows_RecT = mysqli_num_rows($RecT);
        $codTaquilla=$row_RecT['cod_taquilla'];
        if (isset($_POST['est_gan_hnac'])) {
            $_POST['est_gan_hnac']=1;
        } else {
            $_POST['est_gan_hnac']=0;
        }
        if (isset($_POST['est_pla_hnac'])) {
            $_POST['est_pla_hnac']=1;
        } else {
            $_POST['est_pla_hnac']=0;
        }
        if (isset($_POST['est_sho_hnac'])) {
            $_POST['est_sho_hnac']=1;
        } else {
            $_POST['est_sho_hnac']=0;
        }
        if (isset($_POST['est_exa_hnac'])) {
            $_POST['est_exa_hnac']=1;
        } else {
            $_POST['est_exa_hnac']=0;
        }
        if (isset($_POST['est_tri_hnac'])) {
            $_POST['est_tri_hnac']=1;
        } else {
            $_POST['est_tri_hnac']=0;
        }
        if (isset($_POST['est_sup_hnac'])) {
            $_POST['est_sup_hnac']=1;
        } else {
            $_POST['est_sup_hnac']=0;
        }

        if (isset($_POST['est_ven_rin_hnac'])) {
            $_POST['est_ven_rin_hnac']=1;
        } else {
            $_POST['est_ven_rin_hnac']=0;
        }
        if (isset($_POST['est_ven_val_hnac'])) {
            $_POST['est_ven_val_hnac']=1;
        } else {
            $_POST['est_ven_val_hnac']=0;
        }
        if (isset($_POST['est_ven_san_hnac'])) {
            $_POST['est_ven_san_hnac']=1;
        } else {
            $_POST['est_ven_san_hnac']=0;
        }
        if (isset($_POST['est_ven_ran_hnac'])) {
            $_POST['est_ven_ran_hnac']=1;
        } else {
            $_POST['est_ven_ran_hnac']=0;
        }

        if (isset($_POST['emp_rin_reg1_hnac'])) {
            $_POST['emp_rin_reg1_hnac']=1;
        } else {
            $_POST['emp_rin_reg1_hnac']=0;
        }
        if (isset($_POST['emp_rin_reg2_hnac'])) {
            $_POST['emp_rin_reg2_hnac']=1;
        } else {
            $_POST['emp_rin_reg2_hnac']=0;
        }
        if (isset($_POST['emp_rin_reg3_hnac'])) {
            $_POST['emp_rin_reg3_hnac']=1;
        } else {
            $_POST['emp_rin_reg3_hnac']=0;
        }
        if (isset($_POST['emp_rin_reg4_hnac'])) {
            $_POST['emp_rin_reg4_hnac']=1;
        } else {
            $_POST['emp_rin_reg4_hnac']=0;
        }
        if (isset($_POST['emp_rin_reg5_hnac'])) {
            $_POST['emp_rin_reg5_hnac']=1;
        } else {
            $_POST['emp_rin_reg5_hnac']=0;
        }
        if (isset($_POST['emp_rin_reg6_hnac'])) {
            $_POST['emp_rin_reg6_hnac']=1;
        } else {
            $_POST['emp_rin_reg6_hnac']=0;
        }
        if (isset($_POST['emp_rin_reg7_hnac'])) {
            $_POST['emp_rin_reg7_hnac']=1;
        } else {
            $_POST['emp_rin_reg7_hnac']=0;
        }
        if (isset($_POST['emp_rin_reg8_hnac'])) {
            $_POST['emp_rin_reg8_hnac']=1;
        } else {
            $_POST['emp_rin_reg8_hnac']=0;
        }

        if (isset($_POST['emp_val_reg1_hnac'])) {
            $_POST['emp_val_reg1_hnac']=1;
        } else {
            $_POST['emp_val_reg1_hnac']=0;
        }
        if (isset($_POST['emp_val_reg2_hnac'])) {
            $_POST['emp_val_reg2_hnac']=1;
        } else {
            $_POST['emp_val_reg2_hnac']=0;
        }
        if (isset($_POST['emp_val_reg3_hnac'])) {
            $_POST['emp_val_reg3_hnac']=1;
        } else {
            $_POST['emp_val_reg3_hnac']=0;
        }
        if (isset($_POST['emp_val_reg4_hnac'])) {
            $_POST['emp_val_reg4_hnac']=1;
        } else {
            $_POST['emp_val_reg4_hnac']=0;
        }
        if (isset($_POST['emp_val_reg5_hnac'])) {
            $_POST['emp_val_reg5_hnac']=1;
        } else {
            $_POST['emp_val_reg5_hnac']=0;
        }
        if (isset($_POST['emp_val_reg6_hnac'])) {
            $_POST['emp_val_reg6_hnac']=1;
        } else {
            $_POST['emp_val_reg6_hnac']=0;
        }
        if (isset($_POST['emp_val_reg7_hnac'])) {
            $_POST['emp_val_reg7_hnac']=1;
        } else {
            $_POST['emp_val_reg7_hnac']=0;
        }
        if (isset($_POST['emp_val_reg8_hnac'])) {
            $_POST['emp_val_reg8_hnac']=1;
        } else {
            $_POST['emp_val_reg8_hnac']=0;
        }

        if (isset($_POST['emp_san_reg1_hnac'])) {
            $_POST['emp_san_reg1_hnac']=1;
        } else {
            $_POST['emp_san_reg1_hnac']=0;
        }
        if (isset($_POST['emp_san_reg2_hnac'])) {
            $_POST['emp_san_reg2_hnac']=1;
        } else {
            $_POST['emp_san_reg2_hnac']=0;
        }
        if (isset($_POST['emp_san_reg3_hnac'])) {
            $_POST['emp_san_reg3_hnac']=1;
        } else {
            $_POST['emp_san_reg3_hnac']=0;
        }
        if (isset($_POST['emp_san_reg4_hnac'])) {
            $_POST['emp_san_reg4_hnac']=1;
        } else {
            $_POST['emp_san_reg4_hnac']=0;
        }
        if (isset($_POST['emp_san_reg5_hnac'])) {
            $_POST['emp_san_reg5_hnac']=1;
        } else {
            $_POST['emp_san_reg5_hnac']=0;
        }
        if (isset($_POST['emp_san_reg6_hnac'])) {
            $_POST['emp_san_reg6_hnac']=1;
        } else {
            $_POST['emp_san_reg6_hnac']=0;
        }
        if (isset($_POST['emp_san_reg7_hnac'])) {
            $_POST['emp_san_reg7_hnac']=1;
        } else {
            $_POST['emp_san_reg7_hnac']=0;
        }
        if (isset($_POST['emp_san_reg8_hnac'])) {
            $_POST['emp_san_reg8_hnac']=1;
        } else {
            $_POST['emp_san_reg8_hnac']=0;
        }

        if (isset($_POST['emp_ran_reg1_hnac'])) {
            $_POST['emp_ran_reg1_hnac']=1;
        } else {
            $_POST['emp_ran_reg1_hnac']=0;
        }
        if (isset($_POST['emp_ran_reg2_hnac'])) {
            $_POST['emp_ran_reg2_hnac']=1;
        } else {
            $_POST['emp_ran_reg2_hnac']=0;
        }
        if (isset($_POST['emp_ran_reg3_hnac'])) {
            $_POST['emp_ran_reg3_hnac']=1;
        } else {
            $_POST['emp_ran_reg3_hnac']=0;
        }
        if (isset($_POST['emp_ran_reg4_hnac'])) {
            $_POST['emp_ran_reg4_hnac']=1;
        } else {
            $_POST['emp_ran_reg4_hnac']=0;
        }
        if (isset($_POST['emp_ran_reg5_hnac'])) {
            $_POST['emp_ran_reg5_hnac']=1;
        } else {
            $_POST['emp_ran_reg5_hnac']=0;
        }
        if (isset($_POST['emp_ran_reg6_hnac'])) {
            $_POST['emp_ran_reg6_hnac']=1;
        } else {
            $_POST['emp_ran_reg6_hnac']=0;
        }
        if (isset($_POST['emp_ran_reg7_hnac'])) {
            $_POST['emp_ran_reg7_hnac']=1;
        } else {
            $_POST['emp_ran_reg7_hnac']=0;
        }
        if (isset($_POST['emp_ran_reg8_hnac'])) {
            $_POST['emp_ran_reg8_hnac']=1;
        } else {
            $_POST['emp_ran_reg8_hnac']=0;
        }
        
        if (isset($_POST['est_ven_rin_macu'])) {
            $_POST['est_ven_rin_macu']=1;
        } else {
            $_POST['est_ven_rin_macu']=0;
        }
        if (isset($_POST['est_ven_val_macu'])) {
            $_POST['est_ven_val_macu']=1;
        } else {
            $_POST['est_ven_val_macu']=0;
        }
        if (isset($_POST['est_ven_san_macu'])) {
            $_POST['est_ven_san_macu']=1;
        } else {
            $_POST['est_ven_san_macu']=0;
        }
        if (isset($_POST['est_ven_ran_macu'])) {
            $_POST['est_ven_ran_macu']=1;
        } else {
            $_POST['est_ven_ran_macu']=0;
        }

        $insertSQL3 = sprintf(
            "/* PARSEADORES1 distri_hnac\distri_taquillas_add_hnac.php - QUERY 3 */ INSERT INTO taquilla_opc_hnac (cod_taquilla, con_divid_hnac, mod_divid_hnac, max_jugtic_hnac, min_jugtic_hnac, max_eje_hnac, cab_min_hnac, top_pfav_hnac, top_sfav_hnac, top_tfav_hnac, top_dem_hnac, def_rin_regdiv_hnac, div_rin_pdes_hnac, div_rin_phas_hnac, pag_rin_pdiv_hnac, div_rin_sdes_hnac, div_rin_shas_hnac, pag_rin_sdiv_hnac, div_rin_tdes_hnac, div_rin_thas_hnac, pag_rin_tdiv_hnac, div_rin_ddes_hnac, div_rin_dhas_hnac, pag_rin_ddiv_hnac, def_val_regdiv_hnac, div_val_pdes_hnac, div_val_phas_hnac, pag_val_pdiv_hnac, div_val_sdes_hnac, div_val_shas_hnac, pag_val_sdiv_hnac, div_val_tdes_hnac, div_val_thas_hnac, pag_val_tdiv_hnac, div_val_ddes_hnac, div_val_dhas_hnac, pag_val_ddiv_hnac, def_san_regdiv_hnac, div_san_pdes_hnac, div_san_phas_hnac, pag_san_pdiv_hnac, div_san_sdes_hnac, div_san_shas_hnac, pag_san_sdiv_hnac, div_san_tdes_hnac, div_san_thas_hnac, pag_san_tdiv_hnac, div_san_ddes_hnac, div_san_dhas_hnac, pag_san_ddiv_hnac, def_ran_regdiv_hnac, div_ran_pdes_hnac, div_ran_phas_hnac, pag_ran_pdiv_hnac, div_ran_sdes_hnac, div_ran_shas_hnac, pag_ran_sdiv_hnac, div_ran_tdes_hnac, div_ran_thas_hnac, pag_ran_tdiv_hnac, div_ran_ddes_hnac, div_ran_dhas_hnac, pag_ran_ddiv_hnac, cob_taquilla_hnac, est_gan_hnac, 
est_pla_hnac, est_exa_hnac, est_tri_hnac, est_sup_hnac,
			
			opc_rin_pdiv_hnac, opc_rin_sdiv_hnac, opc_rin_tdiv_hnac, opc_rin_ddiv_hnac, opc_rin_qdiv_hnac,
			opc_val_pdiv_hnac, opc_val_sdiv_hnac, opc_val_tdiv_hnac, opc_val_ddiv_hnac, opc_val_qdiv_hnac,
			opc_san_pdiv_hnac, opc_san_sdiv_hnac, opc_san_tdiv_hnac, opc_san_ddiv_hnac, opc_san_qdiv_hnac,
			opc_ran_pdiv_hnac, opc_ran_sdiv_hnac, opc_ran_tdiv_hnac, opc_ran_ddiv_hnac, opc_ran_qdiv_hnac,
			div_rin_qdes_hnac, div_rin_qhas_hnac, pag_rin_qdiv_hnac,
			div_val_qdes_hnac, div_val_qhas_hnac, pag_val_qdiv_hnac,
			div_san_qdes_hnac, div_san_qhas_hnac, pag_san_qdiv_hnac,
			div_ran_qdes_hnac, div_ran_qhas_hnac, pag_ran_qdiv_hnac,
			
			rin_eje_des1_hnac, rin_eje_has1_hnac, rin_eje_des2_hnac, rin_eje_has2_hnac,
			rin_eje_des3_hnac, rin_eje_has3_hnac, rin_eje_des4_hnac, rin_eje_has4_hnac,
			rin_eje_des5_hnac, rin_eje_has5_hnac, val_eje_des1_hnac, val_eje_has1_hnac,
			val_eje_des2_hnac, val_eje_has2_hnac, val_eje_des3_hnac, val_eje_has3_hnac,
			val_eje_des4_hnac, val_eje_has4_hnac, val_eje_des5_hnac, val_eje_has5_hnac,
			san_eje_des1_hnac, san_eje_has1_hnac, san_eje_des2_hnac, san_eje_has2_hnac,
			san_eje_des3_hnac, san_eje_has3_hnac, san_eje_des4_hnac, san_eje_has4_hnac,
			san_eje_des5_hnac, san_eje_has5_hnac, ran_eje_des1_hnac, ran_eje_has1_hnac,
			ran_eje_des2_hnac, ran_eje_has2_hnac, ran_eje_des3_hnac, ran_eje_has3_hnac,
			ran_eje_des4_hnac, ran_eje_has4_hnac, ran_eje_des5_hnac, ran_eje_has5_hnac, 
			
			tic_caduca_hnac, pag_codigo_hnac,
			
			div_rin_6des_hnac, div_rin_6has_hnac, opc_rin_6div_hnac, pag_rin_6div_hnac, 
			div_rin_7des_hnac, div_rin_7has_hnac, opc_rin_7div_hnac, pag_rin_7div_hnac,	
			div_rin_8des_hnac, div_rin_8has_hnac, opc_rin_8div_hnac, pag_rin_8div_hnac,	
			div_val_6des_hnac, div_val_6has_hnac, opc_val_6div_hnac, pag_val_6div_hnac,
			div_val_7des_hnac, div_val_7has_hnac, opc_val_7div_hnac, pag_val_7div_hnac,
			div_val_8des_hnac, div_val_8has_hnac, opc_val_8div_hnac, pag_val_8div_hnac,
			div_san_6des_hnac, div_san_6has_hnac, opc_san_6div_hnac, pag_san_6div_hnac,
			div_san_7des_hnac, div_san_7has_hnac, opc_san_7div_hnac, pag_san_7div_hnac,
			div_san_8des_hnac, div_san_8has_hnac, opc_san_8div_hnac, pag_san_8div_hnac,
			div_ran_6des_hnac, div_ran_6has_hnac, opc_ran_6div_hnac, pag_ran_6div_hnac,
			div_ran_7des_hnac, div_ran_7has_hnac, opc_ran_7div_hnac, pag_ran_7div_hnac,
			div_ran_8des_hnac, div_ran_8has_hnac, opc_ran_8div_hnac, pag_ran_8div_hnac,
			rin_eje_des6_hnac, rin_eje_has6_hnac, rin_eje_des7_hnac, rin_eje_has7_hnac,
			rin_eje_des8_hnac, rin_eje_has8_hnac, val_eje_des6_hnac, val_eje_has6_hnac,
			val_eje_des7_hnac, val_eje_has7_hnac, val_eje_des8_hnac, val_eje_has8_hnac,
			san_eje_des6_hnac, san_eje_has6_hnac, san_eje_des7_hnac, san_eje_has7_hnac,
			san_eje_des8_hnac, san_eje_has8_hnac, ran_eje_des6_hnac, ran_eje_has6_hnac,
			ran_eje_des7_hnac, ran_eje_has7_hnac, ran_eje_des8_hnac, ran_eje_has8_hnac,
			
			est_ven_rin_hnac, est_ven_val_hnac, est_ven_san_hnac, est_ven_ran_hnac,
			
			
			tie_venta_hnac, emp_rin_reg1_hnac, emp_rin_reg2_hnac, emp_rin_reg3_hnac, emp_rin_reg4_hnac,
			emp_rin_reg5_hnac, emp_rin_reg6_hnac, emp_rin_reg7_hnac, emp_rin_reg8_hnac,
			emp_val_reg1_hnac, emp_val_reg2_hnac, emp_val_reg3_hnac, emp_val_reg4_hnac,
			emp_val_reg5_hnac, emp_val_reg6_hnac, emp_val_reg7_hnac, emp_val_reg8_hnac,
			emp_ran_reg1_hnac, emp_ran_reg2_hnac, emp_ran_reg3_hnac, emp_ran_reg4_hnac,
			emp_ran_reg5_hnac, emp_ran_reg6_hnac, emp_ran_reg7_hnac, emp_ran_reg8_hnac,
			emp_san_reg1_hnac, emp_san_reg2_hnac, emp_san_reg3_hnac, emp_san_reg4_hnac,
			emp_san_reg5_hnac, emp_san_reg6_hnac, emp_san_reg7_hnac, emp_san_reg8_hnac,
			tip_taq_hnac, pre_fijo_hnac, tip_ticket_hnac,
			
			est_ven_macu, est_ven_rin_macu, est_ven_val_macu, est_ven_san_macu, est_ven_ran_macu, apu_min_macu,
			apu_max_macu, lim_max_macu, div_ofi_macu, mod_div_macu, apu_cor_macu, apu_lar_macu,
			est_taquilla_hnac, opc_jornadai_macu, por_alquiler_macu,
			
			est_tope_rin, top_pfav_rin_hnac, top_sfav_rin_hnac, top_tfav_rin_hnac, top_dem_rin_hnac, 
			est_tope_ran, top_pfav_ran_hnac, top_sfav_ran_hnac, top_tfav_ran_hnac, top_dem_ran_hnac, 
			est_tope_san, top_pfav_san_hnac, top_sfav_san_hnac, top_tfav_san_hnac, top_dem_san_hnac, 
			est_tope_val, top_pfav_val_hnac, top_sfav_val_hnac, top_tfav_val_hnac, top_dem_val_hnac
			
			) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
			
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,

%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,

%s, %s, %s, %s, %s,
%s, %s, %s, %s, %s,
%s, %s, %s, %s, %s,
%s, %s, %s, %s, %s

)",
            GetSQLValueString($codTaquilla, "int"),
            GetSQLValueString($_POST['con_divid_hnac'], "int"),
            GetSQLValueString($_POST['mod_divid_hnac'], "int"),
            GetSQLValueString($_POST['max_jugtic_hnac'], "double"),
            GetSQLValueString($_POST['min_jugtic_hnac'], "double"),
            GetSQLValueString($_POST['max_eje_hnac'], "double"),
            GetSQLValueString($_POST['cab_min_hnac'], "int"),
            GetSQLValueString($_POST['top_pfav_hnac'], "double"),
            GetSQLValueString($_POST['top_sfav_hnac'], "double"),
            GetSQLValueString($_POST['top_tfav_hnac'], "double"),
            GetSQLValueString($_POST['top_dem_hnac'], "double"),
            GetSQLValueString($_POST['def_rin_regdiv_hnac'], "int"),
            GetSQLValueString($_POST['div_rin_pdes_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_phas_hnac'], "double"),
            GetSQLValueString($_POST['pag_rin_pdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_sdes_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_shas_hnac'], "double"),
            GetSQLValueString($_POST['pag_rin_sdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_tdes_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_thas_hnac'], "double"),
            GetSQLValueString($_POST['pag_rin_tdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_ddes_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_dhas_hnac'], "double"),
            GetSQLValueString($_POST['pag_rin_ddiv_hnac'], "double"),
            GetSQLValueString($_POST['def_val_regdiv_hnac'], "int"),
            GetSQLValueString($_POST['div_val_pdes_hnac'], "double"),
            GetSQLValueString($_POST['div_val_phas_hnac'], "double"),
            GetSQLValueString($_POST['pag_val_pdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_val_sdes_hnac'], "double"),
            GetSQLValueString($_POST['div_val_shas_hnac'], "double"),
            GetSQLValueString($_POST['pag_val_sdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_val_tdes_hnac'], "double"),
            GetSQLValueString($_POST['div_val_thas_hnac'], "double"),
            GetSQLValueString($_POST['pag_val_tdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_val_ddes_hnac'], "double"),
            GetSQLValueString($_POST['div_val_dhas_hnac'], "double"),
            GetSQLValueString($_POST['pag_val_ddiv_hnac'], "double"),
            GetSQLValueString($_POST['def_san_regdiv_hnac'], "int"),
            GetSQLValueString($_POST['div_san_pdes_hnac'], "double"),
            GetSQLValueString($_POST['div_san_phas_hnac'], "double"),
            GetSQLValueString($_POST['pag_san_pdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_san_sdes_hnac'], "double"),
            GetSQLValueString($_POST['div_san_shas_hnac'], "double"),
            GetSQLValueString($_POST['pag_san_sdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_san_tdes_hnac'], "double"),
            GetSQLValueString($_POST['div_san_thas_hnac'], "double"),
            GetSQLValueString($_POST['pag_san_tdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_san_ddes_hnac'], "double"),
            GetSQLValueString($_POST['div_san_dhas_hnac'], "double"),
            GetSQLValueString($_POST['pag_san_ddiv_hnac'], "double"),
            GetSQLValueString($_POST['def_ran_regdiv_hnac'], "int"),
            GetSQLValueString($_POST['div_ran_pdes_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_phas_hnac'], "double"),
            GetSQLValueString($_POST['pag_ran_pdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_sdes_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_shas_hnac'], "double"),
            GetSQLValueString($_POST['pag_ran_sdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_tdes_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_thas_hnac'], "double"),
            GetSQLValueString($_POST['pag_ran_tdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_ddes_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_dhas_hnac'], "double"),
            GetSQLValueString($_POST['pag_ran_ddiv_hnac'], "double"),
            GetSQLValueString($_POST['cob_taquilla_hnac'], "double"),
            GetSQLValueString($_POST['est_gan_hnac'], "int"),
            GetSQLValueString($_POST['est_pla_hnac'], "int"),
            GetSQLValueString($_POST['est_exa_hnac'], "int"),
            GetSQLValueString($_POST['est_tri_hnac'], "int"),
            GetSQLValueString($_POST['est_sup_hnac'], "int"),
            GetSQLValueString($_POST['opc_rin_pdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_rin_sdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_rin_tdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_rin_ddiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_rin_qdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_val_pdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_val_sdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_val_tdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_val_ddiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_val_qdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_san_pdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_san_sdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_san_tdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_san_ddiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_san_qdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_ran_pdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_ran_sdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_ran_tdiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_ran_ddiv_hnac'], "int"),
            GetSQLValueString($_POST['opc_ran_qdiv_hnac'], "int"),
            GetSQLValueString($_POST['div_rin_qdes_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_qhas_hnac'], "double"),
            GetSQLValueString($_POST['pag_rin_qdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_val_qdes_hnac'], "double"),
            GetSQLValueString($_POST['div_val_qhas_hnac'], "double"),
            GetSQLValueString($_POST['pag_val_qdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_san_qdes_hnac'], "double"),
            GetSQLValueString($_POST['div_san_qhas_hnac'], "double"),
            GetSQLValueString($_POST['pag_san_qdiv_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_qdes_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_qhas_hnac'], "double"),
            GetSQLValueString($_POST['pag_ran_qdiv_hnac'], "double"),
            GetSQLValueString($_POST['rin_eje_des1_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_has1_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_des2_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_has2_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_des3_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_has3_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_des4_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_has4_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_des5_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_has5_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_des1_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_has1_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_des2_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_has2_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_des3_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_has3_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_des4_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_has4_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_des5_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_has5_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_des1_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_has1_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_des2_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_has2_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_des3_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_has3_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_des4_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_has4_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_des5_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_has5_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_des1_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_has1_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_des2_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_has2_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_des3_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_has3_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_des4_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_has4_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_des5_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_has5_hnac'], "int"),
            GetSQLValueString($_POST['tic_caduca_hnac'], "int"),
            GetSQLValueString($_POST['pag_codigo_hnac'], "int"),
            GetSQLValueString($_POST['div_rin_6des_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_6has_hnac'], "double"),
            GetSQLValueString($_POST['opc_rin_6div_hnac'], "int"),
            GetSQLValueString($_POST['pag_rin_6div_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_7des_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_7has_hnac'], "double"),
            GetSQLValueString($_POST['opc_rin_7div_hnac'], "int"),
            GetSQLValueString($_POST['pag_rin_7div_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_8des_hnac'], "double"),
            GetSQLValueString($_POST['div_rin_8has_hnac'], "double"),
            GetSQLValueString($_POST['opc_rin_8div_hnac'], "int"),
            GetSQLValueString($_POST['pag_rin_8div_hnac'], "double"),
            GetSQLValueString($_POST['div_val_6des_hnac'], "double"),
            GetSQLValueString($_POST['div_val_6has_hnac'], "double"),
            GetSQLValueString($_POST['opc_val_6div_hnac'], "int"),
            GetSQLValueString($_POST['pag_val_6div_hnac'], "double"),
            GetSQLValueString($_POST['div_val_7des_hnac'], "double"),
            GetSQLValueString($_POST['div_val_7has_hnac'], "double"),
            GetSQLValueString($_POST['opc_val_7div_hnac'], "int"),
            GetSQLValueString($_POST['pag_val_7div_hnac'], "double"),
            GetSQLValueString($_POST['div_val_8des_hnac'], "double"),
            GetSQLValueString($_POST['div_val_8has_hnac'], "double"),
            GetSQLValueString($_POST['opc_val_8div_hnac'], "int"),
            GetSQLValueString($_POST['pag_val_8div_hnac'], "double"),
            GetSQLValueString($_POST['div_san_6des_hnac'], "double"),
            GetSQLValueString($_POST['div_san_6has_hnac'], "double"),
            GetSQLValueString($_POST['opc_san_6div_hnac'], "int"),
            GetSQLValueString($_POST['pag_san_6div_hnac'], "double"),
            GetSQLValueString($_POST['div_san_7des_hnac'], "double"),
            GetSQLValueString($_POST['div_san_7has_hnac'], "double"),
            GetSQLValueString($_POST['opc_san_7div_hnac'], "int"),
            GetSQLValueString($_POST['pag_san_7div_hnac'], "double"),
            GetSQLValueString($_POST['div_san_8des_hnac'], "double"),
            GetSQLValueString($_POST['div_san_8has_hnac'], "double"),
            GetSQLValueString($_POST['opc_san_8div_hnac'], "int"),
            GetSQLValueString($_POST['pag_san_8div_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_6des_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_6has_hnac'], "double"),
            GetSQLValueString($_POST['opc_ran_6div_hnac'], "int"),
            GetSQLValueString($_POST['pag_ran_6div_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_7des_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_7has_hnac'], "double"),
            GetSQLValueString($_POST['opc_ran_7div_hnac'], "int"),
            GetSQLValueString($_POST['pag_ran_7div_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_8des_hnac'], "double"),
            GetSQLValueString($_POST['div_ran_8has_hnac'], "double"),
            GetSQLValueString($_POST['opc_ran_8div_hnac'], "int"),
            GetSQLValueString($_POST['pag_ran_8div_hnac'], "double"),
            GetSQLValueString($_POST['rin_eje_des6_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_has6_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_des7_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_has7_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_des8_hnac'], "int"),
            GetSQLValueString($_POST['rin_eje_has8_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_des6_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_has6_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_des7_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_has7_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_des8_hnac'], "int"),
            GetSQLValueString($_POST['val_eje_has8_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_des6_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_has6_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_des7_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_has7_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_des8_hnac'], "int"),
            GetSQLValueString($_POST['san_eje_has8_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_des6_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_has6_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_des7_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_has7_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_des8_hnac'], "int"),
            GetSQLValueString($_POST['ran_eje_has8_hnac'], "int"),
            GetSQLValueString($_POST['est_ven_rin_hnac'], "int"),
            GetSQLValueString($_POST['est_ven_val_hnac'], "int"),
            GetSQLValueString($_POST['est_ven_san_hnac'], "int"),
            GetSQLValueString($_POST['est_ven_ran_hnac'], "int"),
            GetSQLValueString($_POST['tie_venta_hnac'], "int"),
            GetSQLValueString($_POST['emp_rin_reg1_hnac'], "int"),
            GetSQLValueString($_POST['emp_rin_reg2_hnac'], "int"),
            GetSQLValueString($_POST['emp_rin_reg3_hnac'], "int"),
            GetSQLValueString($_POST['emp_rin_reg4_hnac'], "int"),
            GetSQLValueString($_POST['emp_rin_reg5_hnac'], "int"),
            GetSQLValueString($_POST['emp_rin_reg6_hnac'], "int"),
            GetSQLValueString($_POST['emp_rin_reg7_hnac'], "int"),
            GetSQLValueString($_POST['emp_rin_reg8_hnac'], "int"),
            GetSQLValueString($_POST['emp_val_reg1_hnac'], "int"),
            GetSQLValueString($_POST['emp_val_reg2_hnac'], "int"),
            GetSQLValueString($_POST['emp_val_reg3_hnac'], "int"),
            GetSQLValueString($_POST['emp_val_reg4_hnac'], "int"),
            GetSQLValueString($_POST['emp_val_reg5_hnac'], "int"),
            GetSQLValueString($_POST['emp_val_reg6_hnac'], "int"),
            GetSQLValueString($_POST['emp_val_reg7_hnac'], "int"),
            GetSQLValueString($_POST['emp_val_reg8_hnac'], "int"),
            GetSQLValueString($_POST['emp_ran_reg1_hnac'], "int"),
            GetSQLValueString($_POST['emp_ran_reg2_hnac'], "int"),
            GetSQLValueString($_POST['emp_ran_reg3_hnac'], "int"),
            GetSQLValueString($_POST['emp_ran_reg4_hnac'], "int"),
            GetSQLValueString($_POST['emp_ran_reg5_hnac'], "int"),
            GetSQLValueString($_POST['emp_ran_reg6_hnac'], "int"),
            GetSQLValueString($_POST['emp_ran_reg7_hnac'], "int"),
            GetSQLValueString($_POST['emp_ran_reg8_hnac'], "int"),
            GetSQLValueString($_POST['emp_san_reg1_hnac'], "int"),
            GetSQLValueString($_POST['emp_san_reg2_hnac'], "int"),
            GetSQLValueString($_POST['emp_san_reg3_hnac'], "int"),
            GetSQLValueString($_POST['emp_san_reg4_hnac'], "int"),
            GetSQLValueString($_POST['emp_san_reg5_hnac'], "int"),
            GetSQLValueString($_POST['emp_san_reg6_hnac'], "int"),
            GetSQLValueString($_POST['emp_san_reg7_hnac'], "int"),
            GetSQLValueString($_POST['emp_san_reg8_hnac'], "int"),
            GetSQLValueString($_POST['tip_taq_hnac'], "int"),
            GetSQLValueString($_POST['pre_fijo_hnac'], "int"),
            GetSQLValueString($_POST['tip_ticket_hnac'], "int"),
            GetSQLValueString($_POST['est_ven_macu'], "int"),
            GetSQLValueString($_POST['est_ven_rin_macu'], "int"),
            GetSQLValueString($_POST['est_ven_val_macu'], "int"),
            GetSQLValueString($_POST['est_ven_san_macu'], "int"),
            GetSQLValueString($_POST['est_ven_ran_macu'], "int"),
            GetSQLValueString($_POST['apu_min_macu'], "double"),
            GetSQLValueString($_POST['apu_max_macu'], "double"),
            GetSQLValueString($_POST['lim_max_macu'], "double"),
            GetSQLValueString($_POST['div_ofi_macu'], "int"),
            GetSQLValueString($_POST['mod_div_macu'], "int"),
            GetSQLValueString($_POST['apu_cor_macu'], "int"),
            GetSQLValueString($_POST['apu_lar_macu'], "int"),
            GetSQLValueString($_POST['est_opc_hnac'], "int"),
            GetSQLValueString($_POST['opc_jornadai_macu'], "int"),
            GetSQLValueString($_POST['por_alquiler_macu'], "double"),
            GetSQLValueString($_POST['est_tope_rin'], "int"),
            GetSQLValueString($_POST['top_pfav_rin_hnac'], "double"),
            GetSQLValueString($_POST['top_sfav_rin_hnac'], "double"),
            GetSQLValueString($_POST['top_tfav_rin_hnac'], "double"),
            GetSQLValueString($_POST['top_dem_rin_hnac'], "double"),
            GetSQLValueString($_POST['est_tope_ran'], "int"),
            GetSQLValueString($_POST['top_pfav_ran_hnac'], "double"),
            GetSQLValueString($_POST['top_sfav_ran_hnac'], "double"),
            GetSQLValueString($_POST['top_tfav_ran_hnac'], "double"),
            GetSQLValueString($_POST['top_dem_ran_hnac'], "double"),
            GetSQLValueString($_POST['est_tope_san'], "int"),
            GetSQLValueString($_POST['top_pfav_san_hnac'], "double"),
            GetSQLValueString($_POST['top_sfav_san_hnac'], "double"),
            GetSQLValueString($_POST['top_tfav_san_hnac'], "double"),
            GetSQLValueString($_POST['top_dem_san_hnac'], "double"),
            GetSQLValueString($_POST['est_tope_val'], "int"),
            GetSQLValueString($_POST['top_pfav_val_hnac'], "double"),
            GetSQLValueString($_POST['top_sfav_val_hnac'], "double"),
            GetSQLValueString($_POST['top_tfav_val_hnac'], "double"),
            GetSQLValueString($_POST['top_dem_val_hnac'], "double")
        );
        $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));

        
        
        $insertSQL2 = sprintf(
            "/* PARSEADORES1 distri_hnac\distri_taquillas_add_hnac.php - QUERY 4 */ INSERT 
		INTO usuario 
		(nom_usuario, nom_completo, tip_usuario, cod_taquilla, pas_usuario, est_usuario, tic_eliminados, cod_barra, 
		hor_inicio, hor_fin, dia_entrada, niv_acceso, ini_programa) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_usuario']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_completo']), "text"),
            GetSQLValueString($_POST['tip_usuario'], "text"),
            GetSQLValueString($codTaquilla, "int"),
            GetSQLValueString($_POST['pas_usuario'], "text"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['tic_eliminados'], "int"),
            GetSQLValueString($_POST['cod_barra'], "int"),
            GetSQLValueString($hora_ini, "date"),
            GetSQLValueString($hora_fin, "date"),
            GetSQLValueString($trabaja, "text"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['ini_programa'], "int")
        );
        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
        $insertGoTo = "distri_taquillas_lista_hnac.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$porcentaje=0;
$cod_taopc_hnac="";
$con_divid_hnac="1";
$mod_divid_hnac="0";
$max_jugtic_hnac="10000";
$min_jugtic_hnac="10";
$max_eje_hnac="5000";
$cab_min_hnac="3";
$top_pfav_hnac="5000";
$top_sfav_hnac="4000";
$top_tfav_hnac="3000";
$top_dem_hnac="10000";
$por_alquiler_hnac="1000";
$por_alquiler_macu="3";
$est_opc_hnac="1";
$def_rin_regdiv_hnac="0";
$div_rin_pdes_hnac="0";
$div_rin_phas_hnac="0";
$pag_rin_pdiv_hnac="0";
$div_rin_sdes_hnac="0";
$div_rin_shas_hnac="0";
$pag_rin_sdiv_hnac="0";
$div_rin_tdes_hnac="0";
$div_rin_thas_hnac="0";
$pag_rin_tdiv_hnac="0";
$div_rin_ddes_hnac="0";
$div_rin_dhas_hnac="0";
$pag_rin_ddiv_hnac="0";
$div_rin_qdes_hnac="0";
$div_rin_qhas_hnac="0";
$pag_rin_qdiv_hnac="0";
$opc_rin_pdiv_hnac="1";
$opc_rin_sdiv_hnac="1";
$opc_rin_tdiv_hnac="1";
$opc_rin_ddiv_hnac="1";
$opc_rin_qdiv_hnac="1";
$def_val_regdiv_hnac="0";
$div_val_pdes_hnac="0";
$div_val_phas_hnac="0";
$pag_val_pdiv_hnac="0";
$div_val_sdes_hnac="0";
$div_val_shas_hnac="0";
$pag_val_sdiv_hnac="0";
$div_val_tdes_hnac="0";
$div_val_thas_hnac="0";
$pag_val_tdiv_hnac="0";
$div_val_ddes_hnac="0";
$div_val_dhas_hnac="0";
$pag_val_ddiv_hnac="0";
$div_val_qdes_hnac="0";
$div_val_qhas_hnac="0";
$pag_val_qdiv_hnac="0";
$opc_val_pdiv_hnac="1";
$opc_val_sdiv_hnac="1";
$opc_val_tdiv_hnac="1";
$opc_val_ddiv_hnac="1";
$opc_val_qdiv_hnac="1";
$def_san_regdiv_hnac="0";
$div_san_pdes_hnac="0";
$div_san_phas_hnac="0";
$pag_san_pdiv_hnac="0";
$div_san_sdes_hnac="0";
$div_san_shas_hnac="0";
$pag_san_sdiv_hnac="0";
$div_san_tdes_hnac="0";
$div_san_thas_hnac="0";
$pag_san_tdiv_hnac="0";
$div_san_ddes_hnac="0";
$div_san_dhas_hnac="0";
$pag_san_ddiv_hnac="0";
$div_san_qdes_hnac="0";
$div_san_qhas_hnac="0";
$pag_san_qdiv_hnac="0";
$opc_san_pdiv_hnac="1";
$opc_san_sdiv_hnac="1";
$opc_san_tdiv_hnac="1";
$opc_san_ddiv_hnac="1";
$opc_san_qdiv_hnac="1";
$def_ran_regdiv_hnac="0";
$div_ran_pdes_hnac="0";
$div_ran_phas_hnac="0";
$pag_ran_pdiv_hnac="0";
$div_ran_sdes_hnac="0";
$div_ran_shas_hnac="0";
$pag_ran_sdiv_hnac="0";
$div_ran_tdes_hnac="0";
$div_ran_thas_hnac="0";
$pag_ran_tdiv_hnac="0";
$div_ran_ddes_hnac="0";
$div_ran_dhas_hnac="0";
$pag_ran_ddiv_hnac="0";
$div_ran_qdes_hnac="0";
$div_ran_qhas_hnac="0";
$pag_ran_qdiv_hnac="0";
$opc_ran_pdiv_hnac="1";
$opc_ran_sdiv_hnac="1";
$opc_ran_tdiv_hnac="1";
$opc_ran_ddiv_hnac="1";
$opc_ran_qdiv_hnac="1";
$ver_porpagar_hnac=0;
$est_gan_hnac="1";
$est_pla_hnac="0";
$est_exa_hnac="0";
$est_tri_hnac="0";
$est_sup_hnac="0";
$rin_eje_des1_hnac=2;
$rin_eje_has1_hnac=25;
$rin_eje_des2_hnac=2;
$rin_eje_has2_hnac=25;
$rin_eje_des3_hnac=2;
$rin_eje_has3_hnac=25;
$rin_eje_des4_hnac=2;
$rin_eje_has4_hnac=25;
$rin_eje_des5_hnac=2;
$rin_eje_has5_hnac=25;
$val_eje_des1_hnac=2;
$val_eje_has1_hnac=25;
$val_eje_des2_hnac=2;
$val_eje_has2_hnac=25;
$val_eje_des3_hnac=2;
$val_eje_has3_hnac=25;
$val_eje_des4_hnac=2;
$val_eje_has4_hnac=25;
$val_eje_des5_hnac=2;
$val_eje_has5_hnac=25;
$san_eje_des1_hnac=2;
$san_eje_has1_hnac=25;
$san_eje_des2_hnac=2;
$san_eje_has2_hnac=25;
$san_eje_des3_hnac=2;
$san_eje_has3_hnac=25;
$san_eje_des4_hnac=2;
$san_eje_has4_hnac=25;
$san_eje_des5_hnac=2;
$san_eje_has5_hnac=25;
$ran_eje_des1_hnac=2;
$ran_eje_has1_hnac=25;
$ran_eje_des2_hnac=2;
$ran_eje_has2_hnac=25;
$ran_eje_des3_hnac=2;
$ran_eje_has3_hnac=25;
$ran_eje_des4_hnac=2;
$ran_eje_has4_hnac=25;
$ran_eje_des5_hnac=2;
$ran_eje_has5_hnac=25;
$ran_eje_des6_hnac=2;
$ran_eje_has6_hnac=25;
$ran_eje_des7_hnac=2;
$ran_eje_has7_hnac=25;
$ran_eje_des8_hnac=2;
$ran_eje_has8_hnac=2;
$san_eje_des6_hnac=2;
$san_eje_has6_hnac=25;
$san_eje_des7_hnac=2;
$san_eje_has7_hnac=25;
$san_eje_des8_hnac=2;
$san_eje_has8_hnac=25;
$val_eje_des6_hnac=2;
$val_eje_has6_hnac=25;
$val_eje_des7_hnac=2;
$val_eje_has7_hnac=25;
$val_eje_des8_hnac=2;
$val_eje_has8_hnac=25;
$rin_eje_des6_hnac=2;
$rin_eje_has6_hnac=25;
$rin_eje_des7_hnac=2;
$rin_eje_has7_hnac=25;
$rin_eje_des8_hnac=2;
$rin_eje_has8_hnac=25;
$opc_ran_6div_hnac=1;
$opc_ran_7div_hnac=1;
$opc_ran_8div_hnac=1;
$opc_san_6div_hnac=1;
$opc_san_7div_hnac=1;
$opc_san_8div_hnac=1;
$opc_val_6div_hnac=1;
$opc_val_7div_hnac=1;
$opc_val_8div_hnac=1;
$opc_rin_6div_hnac=1;
$opc_rin_7div_hnac=1;
$opc_rin_8div_hnac=1;
$div_ran_6des_hnac=0;
$div_ran_6has_hnac=0;
$pag_ran_6div_hnac=0;
$div_ran_7des_hnac=0;
$div_ran_7has_hnac=0;
$pag_ran_7div_hnac=0;
$div_ran_8des_hnac=0;
$div_ran_8has_hnac=0;
$pag_ran_8div_hnac=0;
$div_san_6des_hnac=0;
$div_san_6has_hnac=0;
$pag_san_6div_hnac=0;
$div_san_7des_hnac=0;
$div_san_7has_hnac=0;
$pag_san_7div_hnac=0;
$div_san_8des_hnac=0;
$div_san_8has_hnac=0;
$pag_san_8div_hnac=0;
$div_val_6des_hnac=0;
$div_val_6has_hnac=0;
$pag_val_6div_hnac=0;
$div_val_7des_hnac=0;
$div_val_7has_hnac=0;
$pag_val_7div_hnac=0;
$div_val_8des_hnac=0;
$div_val_8has_hnac=0;
$pag_val_8div_hnac=0;
$div_rin_6des_hnac=0;
$div_rin_6has_hnac=0;
$pag_rin_6div_hnac=0;
$div_rin_7des_hnac=0;
$div_rin_7has_hnac=0;
$pag_rin_7div_hnac=0;
$div_rin_8des_hnac=0;
$div_rin_8has_hnac=0;
$pag_rin_8div_hnac=0;
$tic_caduca_hnac=0;
$pag_codigo_hnac=0;
$est_ven_rin_hnac=1;
$est_ven_val_hnac=1;
$est_ven_san_hnac=1;
$est_ven_ran_hnac=1;
$tie_venta_hnac=0;
$emp_rin_reg1_hnac=1;
$emp_rin_reg2_hnac=1;
$emp_rin_reg3_hnac=1;
$emp_rin_reg4_hnac=1;
$emp_rin_reg5_hnac=1;
$emp_rin_reg6_hnac=1;
$emp_rin_reg7_hnac=1;
$emp_rin_reg8_hnac=1;
$emp_val_reg1_hnac=1;
$emp_val_reg2_hnac=1;
$emp_val_reg3_hnac=1;
$emp_val_reg4_hnac=1;
$emp_val_reg5_hnac=1;
$emp_val_reg6_hnac=1;
$emp_val_reg7_hnac=1;
$emp_val_reg8_hnac=1;
$emp_ran_reg1_hnac=1;
$emp_ran_reg2_hnac=1;
$emp_ran_reg3_hnac=1;
$emp_ran_reg4_hnac=1;
$emp_ran_reg5_hnac=1;
$emp_ran_reg6_hnac=1;
$emp_ran_reg7_hnac=1;
$emp_ran_reg8_hnac=1;
$emp_san_reg1_hnac=1;
$emp_san_reg2_hnac=1;
$emp_san_reg3_hnac=1;
$emp_san_reg4_hnac=1;
$emp_san_reg5_hnac=1;
$emp_san_reg6_hnac=1;
$emp_san_reg7_hnac=1;
$emp_san_reg8_hnac=1;
$tip_taq_hnac=0;
$pre_fijo_hnac=0;
$tip_ticket_hnac=0;
///---------OPCIONES MACUARE ------------------------------
$est_ven_macu=1;
$est_ven_rin_macu=1;
$est_ven_val_macu=1;
$est_ven_san_macu=1;
$est_ven_ran_macu=1;
$apu_min_macu=10;
$apu_max_macu=5000;
$lim_max_macu=10000;
$div_ofi_macu=1;
$mod_div_macu=0;
$apu_cor_macu=1;
$apu_lar_macu=1;
$opc_jornadai_macu=0; //opcion de jornada incompleta
$est_tope_rin=0;
$top_pfav_rin_hnac=5000;
$top_sfav_rin_hnac=4000;
$top_tfav_rin_hnac=3000;
$top_dem_rin_hnac=10000;
$est_tope_ran=0;
$top_pfav_ran_hnac=5000;
$top_sfav_ran_hnac=4000;
$top_tfav_ran_hnac=3000;
$top_dem_ran_hnac=10000;
$est_tope_san=0;
$top_pfav_san_hnac=5000;
$top_sfav_san_hnac=4000;
$top_tfav_san_hnac=3000;
$top_dem_san_hnac=10000;
$est_tope_val=0;
$top_pfav_val_hnac=5000;
$top_sfav_val_hnac=4000;
$top_tfav_val_hnac=3000;
$top_dem_val_hnac=10000;
$porcentaje=0;
if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
    if (isset($_POST["exp_agencia"]) && $_POST["exp_agencia"]>0) {
        $query_Recordset2 =  sprintf(
            "/* PARSEADORES1 distri_hnac\distri_taquillas_add_hnac.php - QUERY 5 */ SELECT * 
			FROM  
			taquilla_opc_hnac 
			WHERE 
			cod_taquilla = %s",
            GetSQLValueString($_POST["exp_agencia"], "int")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        
        $cod_taopc_hnac=$row_Recordset2['cod_taopc_hnac'];
        $con_divid_hnac=$row_Recordset2['con_divid_hnac'];
        $mod_divid_hnac=$row_Recordset2['mod_divid_hnac'];
        $max_jugtic_hnac=$row_Recordset2['max_jugtic_hnac'];
        $min_jugtic_hnac=$row_Recordset2['min_jugtic_hnac'];
        $max_eje_hnac=$row_Recordset2['max_eje_hnac'];
        $cab_min_hnac=$row_Recordset2['cab_min_hnac'];
        $top_pfav_hnac=$row_Recordset2['top_pfav_hnac'];
        $top_sfav_hnac=$row_Recordset2['top_sfav_hnac'];
        $top_tfav_hnac=$row_Recordset2['top_tfav_hnac'];
        $top_dem_hnac=$row_Recordset2['top_dem_hnac'];
        $def_rin_regdiv_hnac=$row_Recordset2['def_rin_regdiv_hnac'];
        $div_rin_pdes_hnac=$row_Recordset2['div_rin_pdes_hnac'];
        $div_rin_phas_hnac=$row_Recordset2['div_rin_phas_hnac'];
        $pag_rin_pdiv_hnac=$row_Recordset2['pag_rin_pdiv_hnac'];
        $div_rin_sdes_hnac=$row_Recordset2['div_rin_sdes_hnac'];
        $div_rin_shas_hnac=$row_Recordset2['div_rin_shas_hnac'];
        $pag_rin_sdiv_hnac=$row_Recordset2['pag_rin_sdiv_hnac'];
        $div_rin_tdes_hnac=$row_Recordset2['div_rin_tdes_hnac'];
        $div_rin_thas_hnac=$row_Recordset2['div_rin_thas_hnac'];
        $pag_rin_tdiv_hnac=$row_Recordset2['pag_rin_tdiv_hnac'];
        $div_rin_ddes_hnac=$row_Recordset2['div_rin_ddes_hnac'];
        $div_rin_dhas_hnac=$row_Recordset2['div_rin_dhas_hnac'];
        $pag_rin_ddiv_hnac=$row_Recordset2['pag_rin_ddiv_hnac'];
        
        $div_rin_qdes_hnac=$row_Recordset2['div_rin_qdes_hnac'];
        $div_rin_qhas_hnac=$row_Recordset2['div_rin_qhas_hnac'];
        $pag_rin_qdiv_hnac=$row_Recordset2['pag_rin_qdiv_hnac'];
    
        $div_rin_6des_hnac=$row_Recordset2['div_rin_6des_hnac'];
        $div_rin_6has_hnac=$row_Recordset2['div_rin_6has_hnac'];
        $pag_rin_6div_hnac=$row_Recordset2['pag_rin_6div_hnac'];
        $div_rin_7des_hnac=$row_Recordset2['div_rin_7des_hnac'];
        $div_rin_7has_hnac=$row_Recordset2['div_rin_7has_hnac'];
        $pag_rin_7div_hnac=$row_Recordset2['pag_rin_7div_hnac'];
        $div_rin_8des_hnac=$row_Recordset2['div_rin_8des_hnac'];
        $div_rin_8has_hnac=$row_Recordset2['div_rin_8has_hnac'];
        $pag_rin_8div_hnac=$row_Recordset2['pag_rin_8div_hnac'];
    
    
        $def_val_regdiv_hnac=$row_Recordset2['def_val_regdiv_hnac'];
        $div_val_pdes_hnac=$row_Recordset2['div_val_pdes_hnac'];
        $div_val_phas_hnac=$row_Recordset2['div_val_phas_hnac'];
        $pag_val_pdiv_hnac=$row_Recordset2['pag_val_pdiv_hnac'];
        $div_val_sdes_hnac=$row_Recordset2['div_val_sdes_hnac'];
        $div_val_shas_hnac=$row_Recordset2['div_val_shas_hnac'];
        $pag_val_sdiv_hnac=$row_Recordset2['pag_val_sdiv_hnac'];
        $div_val_tdes_hnac=$row_Recordset2['div_val_tdes_hnac'];
        $div_val_thas_hnac=$row_Recordset2['div_val_thas_hnac'];
        $pag_val_tdiv_hnac=$row_Recordset2['pag_val_tdiv_hnac'];
        $div_val_ddes_hnac=$row_Recordset2['div_val_ddes_hnac'];
        $div_val_dhas_hnac=$row_Recordset2['div_val_dhas_hnac'];
        $pag_val_ddiv_hnac=$row_Recordset2['pag_val_ddiv_hnac'];
    
        $div_val_qdes_hnac=$row_Recordset2['div_val_qdes_hnac'];
        $div_val_qhas_hnac=$row_Recordset2['div_val_qhas_hnac'];
        $pag_val_qdiv_hnac=$row_Recordset2['pag_val_qdiv_hnac'];
    
        $div_val_6des_hnac=$row_Recordset2['div_val_6des_hnac'];
        $div_val_6has_hnac=$row_Recordset2['div_val_6has_hnac'];
        $pag_val_6div_hnac=$row_Recordset2['pag_val_6div_hnac'];
        $div_val_7des_hnac=$row_Recordset2['div_val_7des_hnac'];
        $div_val_7has_hnac=$row_Recordset2['div_val_7has_hnac'];
        $pag_val_7div_hnac=$row_Recordset2['pag_val_7div_hnac'];
        $div_val_8des_hnac=$row_Recordset2['div_val_8des_hnac'];
        $div_val_8has_hnac=$row_Recordset2['div_val_8has_hnac'];
        $pag_val_8div_hnac=$row_Recordset2['pag_val_8div_hnac'];
    
    
        $def_san_regdiv_hnac=$row_Recordset2['def_san_regdiv_hnac'];
        $div_san_pdes_hnac=$row_Recordset2['div_san_pdes_hnac'];
        $div_san_phas_hnac=$row_Recordset2['div_san_phas_hnac'];
        $pag_san_pdiv_hnac=$row_Recordset2['pag_san_pdiv_hnac'];
        $div_san_sdes_hnac=$row_Recordset2['div_san_sdes_hnac'];
        $div_san_shas_hnac=$row_Recordset2['div_san_shas_hnac'];
        $pag_san_sdiv_hnac=$row_Recordset2['pag_san_sdiv_hnac'];
        $div_san_tdes_hnac=$row_Recordset2['div_san_tdes_hnac'];
        $div_san_thas_hnac=$row_Recordset2['div_san_thas_hnac'];
        $pag_san_tdiv_hnac=$row_Recordset2['pag_san_tdiv_hnac'];
        $div_san_ddes_hnac=$row_Recordset2['div_san_ddes_hnac'];
        $div_san_dhas_hnac=$row_Recordset2['div_san_dhas_hnac'];
        $pag_san_ddiv_hnac=$row_Recordset2['pag_san_ddiv_hnac'];
    
        $div_san_qdes_hnac=$row_Recordset2['div_san_qdes_hnac'];
        $div_san_qhas_hnac=$row_Recordset2['div_san_qhas_hnac'];
        $pag_san_qdiv_hnac=$row_Recordset2['pag_san_qdiv_hnac'];
    
        $div_san_6des_hnac=$row_Recordset2['div_san_6des_hnac'];
        $div_san_6has_hnac=$row_Recordset2['div_san_6has_hnac'];
        $pag_san_6div_hnac=$row_Recordset2['pag_san_6div_hnac'];
        $div_san_7des_hnac=$row_Recordset2['div_san_7des_hnac'];
        $div_san_7has_hnac=$row_Recordset2['div_san_7has_hnac'];
        $pag_san_7div_hnac=$row_Recordset2['pag_san_7div_hnac'];
        $div_san_8des_hnac=$row_Recordset2['div_san_8des_hnac'];
        $div_san_8has_hnac=$row_Recordset2['div_san_8has_hnac'];
        $pag_san_8div_hnac=$row_Recordset2['pag_san_8div_hnac'];
    
    
        $def_ran_regdiv_hnac=$row_Recordset2['def_ran_regdiv_hnac'];
        $div_ran_pdes_hnac=$row_Recordset2['div_ran_pdes_hnac'];
        $div_ran_phas_hnac=$row_Recordset2['div_ran_phas_hnac'];
        $pag_ran_pdiv_hnac=$row_Recordset2['pag_ran_pdiv_hnac'];
        $div_ran_sdes_hnac=$row_Recordset2['div_ran_sdes_hnac'];
        $div_ran_shas_hnac=$row_Recordset2['div_ran_shas_hnac'];
        $pag_ran_sdiv_hnac=$row_Recordset2['pag_ran_sdiv_hnac'];
        $div_ran_tdes_hnac=$row_Recordset2['div_ran_tdes_hnac'];
        $div_ran_thas_hnac=$row_Recordset2['div_ran_thas_hnac'];
        $pag_ran_tdiv_hnac=$row_Recordset2['pag_ran_tdiv_hnac'];
        $div_ran_ddes_hnac=$row_Recordset2['div_ran_ddes_hnac'];
        $div_ran_dhas_hnac=$row_Recordset2['div_ran_dhas_hnac'];
        $pag_ran_ddiv_hnac=$row_Recordset2['pag_ran_ddiv_hnac'];
    
        $div_ran_qdes_hnac=$row_Recordset2['div_ran_qdes_hnac'];
        $div_ran_qhas_hnac=$row_Recordset2['div_ran_qhas_hnac'];
        $pag_ran_qdiv_hnac=$row_Recordset2['pag_ran_qdiv_hnac'];
    
        $div_ran_6des_hnac=$row_Recordset2['div_ran_6des_hnac'];
        $div_ran_6has_hnac=$row_Recordset2['div_ran_6has_hnac'];
        $pag_ran_6div_hnac=$row_Recordset2['pag_ran_6div_hnac'];
        $div_ran_7des_hnac=$row_Recordset2['div_ran_7des_hnac'];
        $div_ran_7has_hnac=$row_Recordset2['div_ran_7has_hnac'];
        $pag_ran_7div_hnac=$row_Recordset2['pag_ran_7div_hnac'];
        $div_ran_8des_hnac=$row_Recordset2['div_ran_8des_hnac'];
        $div_ran_8has_hnac=$row_Recordset2['div_ran_8has_hnac'];
        $pag_ran_8div_hnac=$row_Recordset2['pag_ran_8div_hnac'];
    
        
        $est_opc_hnac=$row_Recordset2['est_taquilla_hnac'];//desde tabla taquilla opciones
        $por_alquiler_hnac=$row_Recordset2['cob_taquilla_hnac'];
        $por_alquiler_macu=$row_Recordset2['por_alquiler_macu'];
        $est_gan_hnac=$row_Recordset2['est_gan_hnac'];
        $est_pla_hnac=$row_Recordset2['est_pla_hnac'];
        $est_exa_hnac=$row_Recordset2['est_exa_hnac'];
        $est_tri_hnac=$row_Recordset2['est_tri_hnac'];
        $est_sup_hnac=$row_Recordset2['est_sup_hnac'];
    
        $opc_rin_pdiv_hnac=$row_Recordset2['opc_rin_pdiv_hnac'];
        $opc_rin_sdiv_hnac=$row_Recordset2['opc_rin_sdiv_hnac'];
        $opc_rin_tdiv_hnac=$row_Recordset2['opc_rin_tdiv_hnac'];
        $opc_rin_ddiv_hnac=$row_Recordset2['opc_rin_ddiv_hnac'];
        $opc_rin_qdiv_hnac=$row_Recordset2['opc_rin_qdiv_hnac'];
    
        $opc_rin_6div_hnac=$row_Recordset2['opc_rin_6div_hnac'];
        $opc_rin_7div_hnac=$row_Recordset2['opc_rin_7div_hnac'];
        $opc_rin_8div_hnac=$row_Recordset2['opc_rin_8div_hnac'];
    
        $opc_val_pdiv_hnac=$row_Recordset2['opc_val_pdiv_hnac'];
        $opc_val_sdiv_hnac=$row_Recordset2['opc_val_sdiv_hnac'];
        $opc_val_tdiv_hnac=$row_Recordset2['opc_val_tdiv_hnac'];
        $opc_val_ddiv_hnac=$row_Recordset2['opc_val_ddiv_hnac'];
        $opc_val_qdiv_hnac=$row_Recordset2['opc_val_qdiv_hnac'];
    
        $opc_val_6div_hnac=$row_Recordset2['opc_val_6div_hnac'];
        $opc_val_7div_hnac=$row_Recordset2['opc_val_7div_hnac'];
        $opc_val_8div_hnac=$row_Recordset2['opc_val_8div_hnac'];
    
        $opc_san_pdiv_hnac=$row_Recordset2['opc_san_pdiv_hnac'];
        $opc_san_sdiv_hnac=$row_Recordset2['opc_san_sdiv_hnac'];
        $opc_san_tdiv_hnac=$row_Recordset2['opc_san_tdiv_hnac'];
        $opc_san_ddiv_hnac=$row_Recordset2['opc_san_ddiv_hnac'];
        $opc_san_qdiv_hnac=$row_Recordset2['opc_san_qdiv_hnac'];
    
        $opc_san_6div_hnac=$row_Recordset2['opc_san_6div_hnac'];
        $opc_san_7div_hnac=$row_Recordset2['opc_san_7div_hnac'];
        $opc_san_8div_hnac=$row_Recordset2['opc_san_8div_hnac'];
    
        $opc_ran_pdiv_hnac=$row_Recordset2['opc_ran_pdiv_hnac'];
        $opc_ran_sdiv_hnac=$row_Recordset2['opc_ran_sdiv_hnac'];
        $opc_ran_tdiv_hnac=$row_Recordset2['opc_ran_tdiv_hnac'];
        $opc_ran_ddiv_hnac=$row_Recordset2['opc_ran_ddiv_hnac'];
        $opc_ran_qdiv_hnac=$row_Recordset2['opc_ran_qdiv_hnac'];
    
        $opc_ran_6div_hnac=$row_Recordset2['opc_ran_6div_hnac'];
        $opc_ran_7div_hnac=$row_Recordset2['opc_ran_7div_hnac'];
        $opc_ran_8div_hnac=$row_Recordset2['opc_ran_8div_hnac'];
    
        $ver_porpagar_hnac=$row_Recordset2['ver_porpagar_hnac'];
        
        $rin_eje_des1_hnac=$row_Recordset2['rin_eje_des1_hnac'];
        $rin_eje_has1_hnac=$row_Recordset2['rin_eje_has1_hnac'];
        $rin_eje_des2_hnac=$row_Recordset2['rin_eje_des2_hnac'];
        $rin_eje_has2_hnac=$row_Recordset2['rin_eje_has2_hnac'];
        $rin_eje_des3_hnac=$row_Recordset2['rin_eje_des3_hnac'];
        $rin_eje_has3_hnac=$row_Recordset2['rin_eje_has3_hnac'];
        $rin_eje_des4_hnac=$row_Recordset2['rin_eje_des4_hnac'];
        $rin_eje_has4_hnac=$row_Recordset2['rin_eje_has4_hnac'];
        $rin_eje_des5_hnac=$row_Recordset2['rin_eje_des5_hnac'];
        $rin_eje_has5_hnac=$row_Recordset2['rin_eje_has5_hnac'];
        $rin_eje_des6_hnac=$row_Recordset2['rin_eje_des6_hnac'];
        $rin_eje_has6_hnac=$row_Recordset2['rin_eje_has6_hnac'];
        $rin_eje_des7_hnac=$row_Recordset2['rin_eje_des7_hnac'];
        $rin_eje_has7_hnac=$row_Recordset2['rin_eje_has7_hnac'];
        $rin_eje_des8_hnac=$row_Recordset2['rin_eje_des8_hnac'];
        $rin_eje_has8_hnac=$row_Recordset2['rin_eje_has8_hnac'];
        
        $val_eje_des1_hnac=$row_Recordset2['val_eje_des1_hnac'];
        $val_eje_has1_hnac=$row_Recordset2['val_eje_has1_hnac'];
        $val_eje_des2_hnac=$row_Recordset2['val_eje_des2_hnac'];
        $val_eje_has2_hnac=$row_Recordset2['val_eje_has2_hnac'];
        $val_eje_des3_hnac=$row_Recordset2['val_eje_des3_hnac'];
        $val_eje_has3_hnac=$row_Recordset2['val_eje_has3_hnac'];
        $val_eje_des4_hnac=$row_Recordset2['val_eje_des4_hnac'];
        $val_eje_has4_hnac=$row_Recordset2['val_eje_has4_hnac'];
        $val_eje_des5_hnac=$row_Recordset2['val_eje_des5_hnac'];
        $val_eje_has5_hnac=$row_Recordset2['val_eje_has5_hnac'];
        $val_eje_des6_hnac=$row_Recordset2['val_eje_des6_hnac'];
        $val_eje_has6_hnac=$row_Recordset2['val_eje_has6_hnac'];
        $val_eje_des7_hnac=$row_Recordset2['val_eje_des7_hnac'];
        $val_eje_has7_hnac=$row_Recordset2['val_eje_has7_hnac'];
        $val_eje_des8_hnac=$row_Recordset2['val_eje_des8_hnac'];
        $val_eje_has8_hnac=$row_Recordset2['val_eje_has8_hnac'];
        
        $san_eje_des1_hnac=$row_Recordset2['san_eje_des1_hnac'];
        $san_eje_has1_hnac=$row_Recordset2['san_eje_has1_hnac'];
        $san_eje_des2_hnac=$row_Recordset2['san_eje_des2_hnac'];
        $san_eje_has2_hnac=$row_Recordset2['san_eje_has2_hnac'];
        $san_eje_des3_hnac=$row_Recordset2['san_eje_des3_hnac'];
        $san_eje_has3_hnac=$row_Recordset2['san_eje_has3_hnac'];
        $san_eje_des4_hnac=$row_Recordset2['san_eje_des4_hnac'];
        $san_eje_has4_hnac=$row_Recordset2['san_eje_has4_hnac'];
        $san_eje_des5_hnac=$row_Recordset2['san_eje_des5_hnac'];
        $san_eje_has5_hnac=$row_Recordset2['san_eje_has5_hnac'];
        $san_eje_des6_hnac=$row_Recordset2['san_eje_des6_hnac'];
        $san_eje_has6_hnac=$row_Recordset2['san_eje_has6_hnac'];
        $san_eje_des7_hnac=$row_Recordset2['san_eje_des7_hnac'];
        $san_eje_has7_hnac=$row_Recordset2['san_eje_has7_hnac'];
        $san_eje_des8_hnac=$row_Recordset2['san_eje_des8_hnac'];
        $san_eje_has8_hnac=$row_Recordset2['san_eje_has8_hnac'];
        
        $ran_eje_des1_hnac=$row_Recordset2['ran_eje_des1_hnac'];
        $ran_eje_has1_hnac=$row_Recordset2['ran_eje_has1_hnac'];
        $ran_eje_des2_hnac=$row_Recordset2['ran_eje_des2_hnac'];
        $ran_eje_has2_hnac=$row_Recordset2['ran_eje_has2_hnac'];
        $ran_eje_des3_hnac=$row_Recordset2['ran_eje_des3_hnac'];
        $ran_eje_has3_hnac=$row_Recordset2['ran_eje_has3_hnac'];
        $ran_eje_des4_hnac=$row_Recordset2['ran_eje_des4_hnac'];
        $ran_eje_has4_hnac=$row_Recordset2['ran_eje_has4_hnac'];
        $ran_eje_des5_hnac=$row_Recordset2['ran_eje_des5_hnac'];
        $ran_eje_has5_hnac=$row_Recordset2['ran_eje_has5_hnac'];
        $ran_eje_des6_hnac=$row_Recordset2['ran_eje_des6_hnac'];
        $ran_eje_has6_hnac=$row_Recordset2['ran_eje_has6_hnac'];
        $ran_eje_des7_hnac=$row_Recordset2['ran_eje_des7_hnac'];
        $ran_eje_has7_hnac=$row_Recordset2['ran_eje_has7_hnac'];
        $ran_eje_des8_hnac=$row_Recordset2['ran_eje_des8_hnac'];
        $ran_eje_has8_hnac=$row_Recordset2['ran_eje_has8_hnac'];
        
        $tic_caduca_hnac=$row_Recordset2['tic_caduca_hnac'];
        $pag_codigo_hnac=$row_Recordset2['pag_codigo_hnac'];
        $est_ven_rin_hnac=$row_Recordset2['est_ven_rin_hnac'];
        $est_ven_val_hnac=$row_Recordset2['est_ven_val_hnac'];
        $est_ven_san_hnac=$row_Recordset2['est_ven_san_hnac'];
        $est_ven_ran_hnac=$row_Recordset2['est_ven_ran_hnac'];
        
        $tie_venta_hnac=$row_Recordset2['tie_venta_hnac'];
        $emp_rin_reg1_hnac=$row_Recordset2['emp_rin_reg1_hnac'];
        $emp_rin_reg2_hnac=$row_Recordset2['emp_rin_reg2_hnac'];
        $emp_rin_reg3_hnac=$row_Recordset2['emp_rin_reg3_hnac'];
        $emp_rin_reg4_hnac=$row_Recordset2['emp_rin_reg4_hnac'];
        $emp_rin_reg5_hnac=$row_Recordset2['emp_rin_reg5_hnac'];
        $emp_rin_reg6_hnac=$row_Recordset2['emp_rin_reg6_hnac'];
        $emp_rin_reg7_hnac=$row_Recordset2['emp_rin_reg7_hnac'];
        $emp_rin_reg8_hnac=$row_Recordset2['emp_rin_reg8_hnac'];
    
        $emp_val_reg1_hnac=$row_Recordset2['emp_val_reg1_hnac'];
        $emp_val_reg2_hnac=$row_Recordset2['emp_val_reg2_hnac'];
        $emp_val_reg3_hnac=$row_Recordset2['emp_val_reg3_hnac'];
        $emp_val_reg4_hnac=$row_Recordset2['emp_val_reg4_hnac'];
        $emp_val_reg5_hnac=$row_Recordset2['emp_val_reg5_hnac'];
        $emp_val_reg6_hnac=$row_Recordset2['emp_val_reg6_hnac'];
        $emp_val_reg7_hnac=$row_Recordset2['emp_val_reg7_hnac'];
        $emp_val_reg8_hnac=$row_Recordset2['emp_val_reg8_hnac'];
    
        $emp_ran_reg1_hnac=$row_Recordset2['emp_ran_reg1_hnac'];
        $emp_ran_reg2_hnac=$row_Recordset2['emp_ran_reg2_hnac'];
        $emp_ran_reg3_hnac=$row_Recordset2['emp_ran_reg3_hnac'];
        $emp_ran_reg4_hnac=$row_Recordset2['emp_ran_reg4_hnac'];
        $emp_ran_reg5_hnac=$row_Recordset2['emp_ran_reg5_hnac'];
        $emp_ran_reg6_hnac=$row_Recordset2['emp_ran_reg6_hnac'];
        $emp_ran_reg7_hnac=$row_Recordset2['emp_ran_reg7_hnac'];
        $emp_ran_reg8_hnac=$row_Recordset2['emp_ran_reg8_hnac'];
    
        $emp_san_reg1_hnac=$row_Recordset2['emp_san_reg1_hnac'];
        $emp_san_reg2_hnac=$row_Recordset2['emp_san_reg2_hnac'];
        $emp_san_reg3_hnac=$row_Recordset2['emp_san_reg3_hnac'];
        $emp_san_reg4_hnac=$row_Recordset2['emp_san_reg4_hnac'];
        $emp_san_reg5_hnac=$row_Recordset2['emp_san_reg5_hnac'];
        $emp_san_reg6_hnac=$row_Recordset2['emp_san_reg6_hnac'];
        $emp_san_reg7_hnac=$row_Recordset2['emp_san_reg7_hnac'];
        $emp_san_reg8_hnac=$row_Recordset2['emp_san_reg8_hnac'];
        $tip_taq_hnac=$row_Recordset2['tip_taq_hnac'];
        $pre_fijo_hnac=$row_Recordset2['pre_fijo_hnac'];
        $tip_ticket_hnac=$row_Recordset2['tip_ticket_hnac'];
        //----------------------MACUARE OPCIONES
        $est_ven_macu=$row_Recordset2['est_ven_macu'];
        $est_ven_rin_macu=$row_Recordset2['est_ven_rin_macu'];
        $est_ven_val_macu=$row_Recordset2['est_ven_val_macu'];
        $est_ven_san_macu=$row_Recordset2['est_ven_san_macu'];
        $est_ven_ran_macu=$row_Recordset2['est_ven_ran_macu'];
        $apu_min_macu=$row_Recordset2['apu_min_macu'];
        $apu_max_macu=$row_Recordset2['apu_max_macu'];
        $lim_max_macu=$row_Recordset2['lim_max_macu'];
        $div_ofi_macu=$row_Recordset2['div_ofi_macu'];
        $mod_div_macu=$row_Recordset2['mod_div_macu'];
        $apu_cor_macu=$row_Recordset2['apu_cor_macu'];
        $apu_lar_macu=$row_Recordset2['apu_lar_macu'];
        $opc_jornadai_macu=$row_Recordset2['opc_jornadai_macu'];
        
        $est_tope_rin=$row_Recordset2['est_tope_rin'];
        $top_pfav_rin_hnac=$row_Recordset2['top_pfav_rin_hnac'];
        $top_sfav_rin_hnac=$row_Recordset2['top_sfav_rin_hnac'];
        $top_tfav_rin_hnac=$row_Recordset2['top_tfav_rin_hnac'];
        $top_dem_rin_hnac=$row_Recordset2['top_dem_rin_hnac'];
        
        $est_tope_ran=$row_Recordset2['est_tope_ran'];
        $top_pfav_ran_hnac=$row_Recordset2['top_pfav_ran_hnac'];
        $top_sfav_ran_hnac=$row_Recordset2['top_sfav_ran_hnac'];
        $top_tfav_ran_hnac=$row_Recordset2['top_tfav_ran_hnac'];
        $top_dem_ran_hnac=$row_Recordset2['top_dem_ran_hnac'];
        
        $est_tope_san=$row_Recordset2['est_tope_san'];
        $top_pfav_san_hnac=$row_Recordset2['top_pfav_san_hnac'];
        $top_sfav_san_hnac=$row_Recordset2['top_sfav_san_hnac'];
        $top_tfav_san_hnac=$row_Recordset2['top_tfav_san_hnac'];
        $top_dem_san_hnac=$row_Recordset2['top_dem_san_hnac'];
        
        $est_tope_val=$row_Recordset2['est_tope_val'];
        $top_pfav_val_hnac=$row_Recordset2['top_pfav_val_hnac'];
        $top_sfav_val_hnac=$row_Recordset2['top_sfav_val_hnac'];
        $top_tfav_val_hnac=$row_Recordset2['top_tfav_val_hnac'];
        $top_dem_val_hnac=$row_Recordset2['top_dem_val_hnac'];
    }
}
$has=50;
$query_Recordset4 = sprintf(
    "/* PARSEADORES1 distri_hnac\distri_taquillas_add_hnac.php - QUERY 6 */ SELECT ag.cod_agencia, ag.nom_agencia 
FROM banca ba, agencia ag
WHERE ag.cod_banca = ba.cod_banca AND ba.cod_banca = %s ORDER BY ag.nom_agencia",
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset4 =mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 distri_hnac\distri_taquillas_add_hnac.php - QUERY 7 */ SELECT ta.cod_taquilla, ta.nom_taquilla 
FROM taquilla ta, taquilla_opc_hnac tp, agencia ag, banca ba 
WHERE ta.cod_taquilla = tp.cod_taquilla AND ag.cod_agencia = ta.cod_agencia AND 
ba.cod_banca = ag.cod_banca AND ba.cod_banca = %s
ORDER BY nom_taquilla",
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
  .textbox, .textboxsmal {
	  border: 1px solid #DBE1EB;
	  font-size: 18px;
	  font-family: Arial, Verdana;
	  padding-left: 7px;
	  padding-right: 7px;
	  padding-top: 10px;
	  padding-bottom: 10px;
	  border-radius: 4px;
	  -moz-border-radius: 4px;
	  -webkit-border-radius: 4px;
	  -o-border-radius: 4px;
	  background: #FFFFFF;
	  background: linear-gradient(left, #FFFFFF, #F7F9FA);
	  background: -moz-linear-gradient(left, #FFFFFF, #F7F9FA);
	  background: -webkit-linear-gradient(left, #FFFFFF, #F7F9FA);
	  background: -o-linear-gradient(left, #FFFFFF, #F7F9FA);
	  color: #2E3133;
	  height:20px;
  }
  .textbox:focus, .textboxsmal:focus {
	  color: #2E3133;
	  border-color: #FBFFAD;
  }
  .textboxsmal {
	  width:50px;
	  height:10px;
  }
 </style>
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script><script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
function ValidaSoloNumeros() {
	if (event.keyCode != 46) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
}   
function mos_ocu(div,bot){
if (document.getElementById(div).style.display == 'none') {document.getElementById(div).style.display = 'block';
document.getElementById(bot).innerHTML = "Ocultar";} else {document.getElementById(div).style.display = 'none'; document.getElementById(bot).innerHTML = "Mostar"}} 
$(document).ready(function() {
    $('#nom_taquilla').blur(function(){
		var taquilla = $('input[name=nom_taquilla]').val();
		if(taquilla != '') {
			var nom_taquilla = $(this).val();        
			var dataString = 'nom_taquilla='+nom_taquilla;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarTaquilla.php",
				data: dataString,
				success: function(data) {
					$('#Info1').fadeIn(200).html(data);
				}
			});
		};
    });              
    $('#username').blur(function(){
		var usern = $('input[name=username]').val();
		if(usern != '') {
			var username = $(this).val();        
			var dataString = 'username='+username;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarUsuario.php",
				data: dataString,
				success: function(data) {
					$('#Info32').fadeIn(200).html(data);
				}
			});
		};	
    });
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
 });
 function FX_passGenerator(form,element) {
  var thePass = "";
  var randomchar = "";
  var numberofdigits = '5';
  for (var count=1; count<=numberofdigits; count++) {
    var chargroup = Math.floor((Math.random() * 3) + 1);
    if (chargroup==1) {
      randomchar = Math.floor((Math.random() * 26) + 65);
    }
    if (chargroup==2) {
      randomchar = Math.floor((Math.random() * 10) + 48);
    }
    if (chargroup==3) {
      randomchar = Math.floor((Math.random() * 26) + 97);
    }
    thePass+=String.fromCharCode(randomchar);
  }
  thePass = thePass.toUpperCase();
  eval('document.'+form+'.'+element+'.value = thePass');
}
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabeceradistri_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
  </div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              AGREGAR TAQUILLA<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
      <div style="width:98%; float:right; text-align:right; padding:1.5% 2% 0 0; height:40px; font-size:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
        <form method="post" name="form2" action="<?php echo $editFormAction2; ?>" onsubmit="return chequearEnvio();">
        	Exportar opciones de:
            <select name="exp_agencia" id="exp_agencia" style="width:25%; height: auto; background:#9E1C0A; color:#FFFFFF" 
            	class="textbox">
                <option value="" style="background:#9E1C0A; color:#FFFFFF">SELECCIONE<?php
                do {?>
                    <option value="<?php echo $row_Recordset3['cod_taquilla']?>" style="background:#FFF; color:#000">
                        <?php echo $row_Recordset3['nom_taquilla']?></option><?php
                } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
            </select>
			<input name="botExp" id="botExp" type="submit"  value="Exportar" class=" btn-info" 
            	style="width:70px; height:35px; font-size:12px;" disabled="disabled"/>
			<input type="hidden" name="MM_insert2" value="form2"/>
        </form>
    </div>

	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
            
              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:14px">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#0E5157" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE TAQUILLA<br/>
                  </td>
                <tr valign="baseline">
                  <td width="1" height="66" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" valign="middle" nowrap>Agente:<font color="red">***</font><br>
                    
                  <select name="cod_agencia" style="width:100%; height: auto" class="textbox">
                    <option value="">SELECCIONE
                      <?php
                                    do {
                                        ?>
                    <option value="<?php echo $row_Recordset4['cod_agencia']?>">
                        <?php echo $row_Recordset4['nom_agencia']?></option>
                    <?php
                                    } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
                                    ?>
                    </select>
                    <div id="Info46" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
                    <?php echo $menAgen; ?></div>
                    
                  </td>
                  <td colspan="2" align="center" style="font-size:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;"><font color="red">*** = DATOS REQUERIDOS</font></td>
                <tr valign="baseline">
                  <td align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="240" align="left" valign="middle" nowrap>
                  Nombre de taquilla:<font color="red">***</font><br>
                    <input type="text" name="nom_taquilla" id="nom_taquilla" class="textbox" tabindex="1"
                    value="" 
                    size="32" placeholder="nombre de taquilla" title="indique un nombre 4-30 caracteres" 
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info1');"
                    maxlength="33" pattern="[A-Z a-z0-9]{4,30}" required/>
                    <div id="Info1" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
					<?php echo $menTaq; ?></div>
                  </td>
                  <td width="242" align="left">
                  Nombre de representante:<br />
                  <input type="text" name="nom_representante" class="textbox" tabindex="2" placeholder="nombre completo"
                  value="representante" 
                  size="32" title="indique un nombre de representante. 4-30 caracteres" onclick="ocultaDiv('Info2');"/>
                  <div id="Info2" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menNre; ?></div>
                  </td>
                  <td width="232" align="left">&nbsp;
                  </td>
                  <td align="left">
                  Status de taquilla:<br />
                    <select name="est_taquilla" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1">ACTIVO2</option>
                      <option value="0">INACTIVO2</option>
                  </select></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="left" nowrap>
                  Nro de contacto principal:<br />
                  <input type="text" name="tel_taquilla" class="textbox" tabindex="3"
                  size="32" pattern="[0-9]{9,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value=""  
                  placeholder="021200000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td align="left" nowrap>
                  Nro de contacto 1er auxiliar:<br />
                  <input type="text" name="tel_taquilla2" class="textbox" tabindex="3"
                  size="32" pattern="[0-9]{9,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value=""  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  </td>
                  <td align="left" nowrap>
                  Nro de contacto 2do auxiliar:<br />
                  <input type="text" name="tel_taquilla3" class="textbox" tabindex="3"
                  size="32" pattern="[0-9]{9,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value=""  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  </td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="40" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="background:#333333; font-size:20px; color: #FFF">
					DATOS Y OPCIONES DE USUARIO VENDEDOR
                  </td>
                </tr>
              </table>
              <div id="nacional" style="float: left; width:auto; color: #000;"> 
              <table width="921" align="center">
                <tr valign="baseline">
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td width="249" align="left" nowrap>
                  	Nombre de usuario:<font color="red">***</font><br>
                    <input type="text" name="nom_usuario" class="textbox" id="username"
                    value=""
                    size="32" placeholder="nombre de usuario" 
                    maxlength="30" pattern="[A-Z a-z0-9]{4,30}" title="indique un nombre de usuario. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');" tabindex="32" required />
                    <div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNus; ?></div>
                  </td>
                  <td width="212">
                  	Contraseña de acceso:<font color="red">***</font><br />
                    <input type="text" name="pas_usuario" id="pas_usuario" size="32" class="textbox" 
                    placeholder="contraseña" pattern="[A-Z a-z0-9]{4,20}" maxlength="20" 
                    value="" tabindex="33" onKeyUp="return handleEnter(this, event)"/>
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menPass; ?></div>
                  </td>
                  <td width="123" align="left" valign="middle">
                  	<input name="Botón" type="button" class="btn-primary" value="Generar clave"
                    style="width:auto; height:40px; font-size:11px" 
                    onClick="ocultaDiv('Info34'),FX_passGenerator('form1','pas_usuario')"/>
                  </td>
                  <td width="272">
                  	Nombre en ticket:<br />
                  	<input type="text" name="nom_completo" class="textbox" placeholder="nombre en ticket" maxlength="30"
                    pattern="[A-Z a-z0-9]{4,30}" title="indique un nombre para mostrar en ticket. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34"
                    value="" 
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNcus; ?></div>
                  </td>
                </tr>
              </table>
              <table width="920" border="0">
                  <tr>
                    <td width="16">&nbsp;</td>
                    <td width="123">&nbsp;</td>
                    <td width="66">&nbsp;</td>
                    <td width="141">&nbsp;</td>
                    <td width="97">&nbsp;</td>
                    <td width="208">Hora de inicio de venta:</td>
                    <td width="239">Hora de cierre de venta:</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right">Máx Ticket a eliminar:</td>
                    <td>
                    	<input type="text" name="tic_eliminados" class="textboxsmal" 
                        style="height:20px" onclick="ocultaDiv('Info36');"
                        value="15" 
                        size="32" onkeypress="ValidaSoloNumeros()" title="indique máximo a eliminar"
                    	onKeyUp="return handleEnter(this, event)" tabindex="35" required pattern="[0-9]{1,7}"/>
                    <div id="Info36" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menTeli; ?></div>
                    </td>
                    <td align="right">Codigo de barra en ticket:</td>
                    <td>
                    	<select name="cod_barra" style="width: auto; height: auto" class="textbox" tabindex="36">
                      		<option value="0">NO
                            </option>
                      		<option value="1">SI
                            </option>
                    	</select>
                    </td>
                    <td>
                    	<select name="hor_in" style="width: auto; height: auto" class="textbox" tabindex="37" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 1; $i <= 12; $i++) {
                                        if ($i<10) {
                                            $v="0".$i;
                                        } else {
                                            $v=$i;
                                        } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($hor_in, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                           <?php
                                    }?>
                        </select>
                      	<select name="min_in" style="width: auto; height: auto" class="textbox" tabindex="38" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 0; $i <= 55; $i=$i+5) {
                                        if ($i<10) {
                                            $v="0".$i;
                                        } else {
                                            $v=$i;
                                        } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($min_in, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                            <?php
                                    }?>
                      </select>
                      <select name="am_in" style="width: auto; height: auto" class="textbox" tabindex="39" 
                        onfocus="ocultaDiv('Info37');">
	                        <option value="AM" <?php
                            if (!(strcmp("AM", htmlentities($am_in, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>AM
                            </option>
                        	<option value="PM" <?php
                            if (!(strcmp("PM", htmlentities($am_in, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>PM
                            </option>
                      </select>
                      <div id="Info37" style="float: left; width:auto; color: #F00; margin:-8px 0px 0px 0px; font-size:12px">
					  <?php echo $menHin; ?></div>
                  </td>
                  <td>
                   	<select name="hor_fi" style="width: auto; height: auto" class="textbox" tabindex="40" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 1; $i <= 12; $i++) {
                                if ($i<10) {
                                    $v="0".$i;
                                } else {
                                    $v=$i;
                                } ?>
                                <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($hor_fi, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                                </option>
                           <?php
                            }?>
                    </select>
                   	<select name="min_fi" style="width: auto; height: auto" class="textbox" tabindex="41" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 0; $i <= 55; $i=$i+5) {
                                if ($i<10) {
                                    $v="0".$i;
                                } else {
                                    $v=$i;
                                } ?>
                                <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($min_fi, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                                </option>
                            <?php
                            }?>
                    </select>
                      <select name="am_fi" style="width: auto; height: auto" class="textbox" tabindex="42" 
                        onfocus="ocultaDiv('Info37');">
                        	<option value="AM" <?php
                            if (!(strcmp("AM", htmlentities($am_fi, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>AM
                            </option>
                        	<option value="PM" <?php
                            if (!(strcmp("PM", htmlentities($am_fi, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>PM
                            </option>
                    </select></td>
                  </tr>
              </table>
                <table width="924" align="center">
                <tr valign="baseline" style="font-size:12px">
                  <td width="36" align="left" nowrap>&nbsp;</td>
                  <td width="182" align="left" nowrap>&nbsp;</td>
                  <td width="68" align="center" valign="bottom">LUNES</td>
                  <td align="center" valign="bottom">MARTES</td>
                  <td align="center" valign="bottom">MIÉRCOLES</td>
                  <td width="68" align="center" valign="bottom">JUEVES</td>
                  <td width="68" align="center" valign="bottom">VIERNES</td>
                  <td width="68" align="center" valign="bottom">SÁBADO</td>
                  <td width="68" align="center" valign="bottom">DOMINGO</td>
                  <td width="26" align="center" valign="bottom">&nbsp;</td>
                  <td colspan="2" align="left" valign="bottom" bgcolor="#333333" style="font-size:20px; color:#FFF">
                  &nbsp;Inicia sistema en:
                  </td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="right">Días que trabaja</td>
                  <td align="center"><input type="checkbox" name="dia1" class="textboxsmal" tabindex="43"
                  value=""  <?php if (!(strcmp(htmlentities($dia1, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td width="68" align="center"><input type="checkbox" name="dia2" class="textboxsmal" tabindex="44"
                  value=""  <?php if (!(strcmp(htmlentities($dia2, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td width="70" align="center"><input type="checkbox" name="dia3" class="textboxsmal" tabindex="45"
                  value=""  <?php if (!(strcmp(htmlentities($dia3, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td> 
                  <td align="center"><input type="checkbox" name="dia4" class="textboxsmal" tabindex="46"
                  value=""  <?php if (!(strcmp(htmlentities($dia4, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td align="center"><input type="checkbox" name="dia5" class="textboxsmal" tabindex="47"
                  value=""  <?php if (!(strcmp(htmlentities($dia5, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td align="center"><input type="checkbox" name="dia6" class="textboxsmal" tabindex="48"
                  value=""  <?php if (!(strcmp(htmlentities($dia6, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td align="center"><input type="checkbox" name="dia7" class="textboxsmal" tabindex="49"
                  value=""  <?php if (!(strcmp(htmlentities($dia7, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td>&nbsp;</td>
                  <td colspan="2" align="left">
					<select name="ini_programa" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                      <option value="0">SELECCIÓN</option>
                      <option value="1">AMERICANAS</option>
                      <option value="2">NACIONALES</option>
                 	</select>
                  </td>
                  </tr>
                <tr valign="baseline">
                  <td height="52" colspan="12" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="background:#333333; font-size:24px; color: #FFF">
					<strong>OPCIONES DE TAQUILLA CARRERAS NACIONALES</strong>
                  </td>
                </tr>
              </table>
              
               
              <table width="920" align="center" border="0" cellpadding="0" cellspacing="0"
              style="background:#0E5157;color:#FFF; font-size:10px; line-height:11px">
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    <td align="center" valign="top">&nbsp;</td>
                    <td align="center" valign="top">&nbsp;</td>
                    <td align="center" valign="top">&nbsp;</td>
                    <td align="center" valign="top">&nbsp;</td>
                    <td align="center" valign="top">&nbsp;</td>
                    <td colspan="5" align="center" valign="top" style="background:#009745;color:#000;">TOPES GLOBALES</td>
                  </tr>
                  <tr>
                    <td width="74" align="center" valign="top">CONFIRMAR DIVIDENDO:
                      <select name="con_divid_hnac" style="width:68px; height: 39px" class="textbox">
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($con_divid_hnac, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>SI</option>
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($con_divid_hnac, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>NO</option>
                    </select></td>
                    <td width="74" align="center" valign="top">MODIFICA DIVIDENDOS:
                      <select name="mod_divid_hnac" style="width:68px; height: 39px" class="textbox">
        				<option value="1" 
						<?php if (!(strcmp(1, htmlentities($mod_divid_hnac, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>SI</option>
       				 <option value="0" 
					 <?php if (!(strcmp(0, htmlentities($mod_divid_hnac, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>NO</option>
      				</select>
                    </td>
                    <td width="106" align="center" valign="top">MONTO MÁXIMO EN TICKET:
                    <input type="text" name="max_jugtic_hnac" class="textboxsmal" 
                    style="height:16px; width:70px; font-size:16px" 
                    onkeypress="ValidaSoloNumeros()" title="indique monto máximo en ticket"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($max_jugtic_hnac, ENT_COMPAT, 'utf-8'); ?>" >
                    </td>
                    <td width="100" align="center" valign="top">MONTO MÍNIMO EN TICKET:
                   	<input type="text" name="min_jugtic_hnac" class="textboxsmal" style="height:16px; width:70px"
                    onkeypress="ValidaSoloNumeros()" title="indique monto mínimo en ticket"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($min_jugtic_hnac, ENT_COMPAT, 'utf-8'); ?>">
                    </td>
                    <td width="100" align="center" valign="top">MONTO MÁXIMO JUGADO A EJEMP.:
                    <input type="text" name="max_eje_hnac" class="textboxsmal" style="height:16px; width:70px; font-size:16px"
                    onkeypress="ValidaSoloNumeros()" title="indique monto máximo jugado a ejemplar"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($max_eje_hnac, ENT_COMPAT, 'utf-8'); ?>">
                    </td>
                    <td width="87" align="center" valign="top">EJEMP. MÍNIMOS EN CARRERA:
                    <select name="cab_min_hnac" style="width:59px; height: 39px" class="textbox">
					<?php
                    for ($i = 2;  $i <= 10; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($cab_min_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
                    </select>                    
                    </td>
                    <td width="87" align="center" valign="top" bgcolor="#009745">TOPE MÁXIMO 1er FAVORITO:
					<input type="text" name="top_pfav_hnac" class="textboxsmal" style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del primer favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_pfav_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                    </td>
                    <td width="78" align="center" valign="top" bgcolor="#009745">TOPE MÁXIMO 2do FAVORITO:
					<input type="text" name="top_sfav_hnac" class="textboxsmal" style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del segundo favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_sfav_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                    </td>
                    <td colspan="2" align="center" valign="top" bgcolor="#009745">TOPE MÁXIMO 3er FAVORITO:
					<input type="text" name="top_tfav_hnac" class="textboxsmal" style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del tercer favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_tfav_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                    </td>
                    <td width="101" align="center" valign="top" bgcolor="#009745">TOPE MÁXIMO AL RESTO:
					<input type="text" name="top_dem_hnac" class="textboxsmal" 
                    style="height:16px; width:65px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo al resto de ejemplares"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_dem_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                    </td>
                  </tr>
                  <tr>
                    <td rowspan="2" align="center" valign="bottom">
                    TICKET CADUCA:
					   <select name="tic_caduca_hnac" style="width:59px; height: 39px" class="textbox" 
                       	title="(0) no caduca">
                          <?php for ($i = 0; $i <= 30; $i++) {?>
                            <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($tic_caduca_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $i; ?>
                          </option>                           <?php  }?>
                    </select>
					</td>
                    <td colspan="2" rowspan="2" align="center" valign="bottom">
                    FORMA DE PAGAR APUESTA Y <br/>ELIMINAR TICKET:
					<select name="pag_codigo_hnac" style="width:auto; height:40px" class="textbox" tabindex="4"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($pag_codigo_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>SIN CÓDIGO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($pag_codigo_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>CON CÓDIGO</option>
                 	</select> 
                    </td>
                    <td rowspan="2" align="center" valign="top" style="font-size:9px">
                    ACEPTA APUESTAS<br/>HIPODROMO<br/>LA RINCONADA<br/>
					<input type="checkbox" name="est_ven_rin_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_ven_rin_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />                    
                    </td>
                    <td rowspan="2" align="center" valign="top" style="font-size:9px">
                    ACEPTA APUESTAS<br/>HIPODROMO<br/>VALENCIA<br/>
					<input type="checkbox" name="est_ven_val_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_ven_val_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />                    
                    </td>
                    <td rowspan="2" align="center" valign="top" style="font-size:9px">
                    ACEPTA APUESTAS<br/>HIPODROMO<br/>SANTA RITA<br/>
					<input type="checkbox" name="est_ven_san_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_ven_san_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />                    
                    </td>
                    <td rowspan="2" align="center" valign="top" style="font-size:9px">
                    ACEPTA APUESTAS<br/>HIPODROMO<br/>RANCHO ALEGRE<br/>
					<input type="checkbox" name="est_ven_ran_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_ven_ran_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />                    
                    </td>
                    <td rowspan="2" align="center" valign="top" style="font-size:9px">
                    TIPO TAQUILLA:
                  <select name="tip_taq_hnac" 
                	style="width:50px; height: 41px; font-size:20px; margin:1px 0px 0px 0px" class="textbox">
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($tip_taq_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>A</option>
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($tip_taq_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>B</option>
                    <option value="2" 
					<?php if (!(strcmp(2, htmlentities($tip_taq_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>C</option>
                    <option value="3" 
					<?php if (!(strcmp(3, htmlentities($tip_taq_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>D</option>
                </select></td>
                    <td colspan="3" align="center" valign="top" style="font-size:9px">
                    VENDER CUANDO FALTEN:<br/>
                      <select name="tie_venta_hnac" style="width:99px;height:41px;font-size:20px;" class="textbox">
                        <?php
                        for ($i = 0;  $i <=30; $i++) {?>
                            <option value="<?php echo $i; ?>" 
                            <?php if (!(strcmp($i, htmlentities($tie_venta_hnac, ENT_COMPAT, 'utf-8')))) {
                            echo "SELECTED";
                        } ?>>
                            <?php echo $i." min"; ?>
                            </option>
                        <?php
                        }?>  
                    </select>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center" valign="top" style="font-size:9px">PARA LA PARTIDA</td>
                  </tr>
                  <tr>
                    <td align="center" valign="bottom">VER PREMIOS<br/>POR PAGAR</td>
                    <td align="center" valign="bottom">MANEJA PRECIO FIJO</td>
                    <td align="center" valign="bottom">ACEPTA  A<br/>GANADOR</td>
                    <td align="center" valign="bottom">ACEPTA A<br/>PLACE</td>
                    <td align="center" valign="bottom">ACEPTA<br/>EXACTAS</td>
                    <td align="center" valign="bottom">ACEPTA <br/>TRIFECTAS</td>
                    <td align="center" valign="bottom">ACEPTA SUPERFECTAS</td>
                    <td align="center" valign="bottom">TIPO DE<br/>TICKET</td>
                    <td colspan="2" align="center" valign="bottom">&nbsp;</td>
                    <td align="center" valign="bottom">&nbsp;</td>
                </tr>
                  <tr>
                    <td align="center" valign="top">
                      <select name="ver_porpagar_hnac" style="width:68px; height: 39px" class="textbox">
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($ver_porpagar_hnac, ENT_COMPAT, 'utf-8')))) {
                            echo "SELECTED";
                        } ?>>SI
                        </option>
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($ver_porpagar_hnac, ENT_COMPAT, 'utf-8')))) {
                            echo "SELECTED";
                        } ?>>NO
                        </option>
                    </select>
                    </td>
                    <td align="center" valign="top">
                      <select name="pre_fijo_hnac" style="width:68px; height: 39px" class="textbox">
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($pre_fijo_hnac, ENT_COMPAT, 'utf-8')))) {
                            echo "SELECTED";
                        } ?>>SI
                        </option>
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($pre_fijo_hnac, ENT_COMPAT, 'utf-8')))) {
                            echo "SELECTED";
                        } ?>>NO
                        </option>
                    </select>
                    </td>
                    <td align="center" valign="top">
					<input type="checkbox" name="est_gan_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_gan_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                            echo "checked=\"checked\"";
                        } ?> />                    
                    </td>
                    <td align="center" valign="top">
					<input type="checkbox" name="est_pla_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_pla_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                            echo "checked=\"checked\"";
                        } ?> />                    
                    </td>
                    <td align="center" valign="top">
					<input type="checkbox" name="est_exa_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_exa_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                            echo "checked=\"checked\"";
                        } ?> />                    
                    </td>
                    <td align="center" valign="top">
					<input type="checkbox" name="est_tri_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_tri_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                            echo "checked=\"checked\"";
                        } ?> />                    
                    </td>
                    <td align="center" valign="top">
					<input type="checkbox" name="est_sup_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_sup_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                            echo "checked=\"checked\"";
                        } ?> />                    
                    </td>
                    <td align="center" valign="top">
					<select name="tip_ticket_hnac" style="width:59px; height: 39px" class="textbox">
					<?php
                    for ($i = 0;  $i <= 10; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($tip_ticket_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
                    </select>                    
                    </td>
                    <td width="90" align="right" valign="middle">COSTO X&nbsp;<BR/> PUNTO:&nbsp;
                    </td>
                    <td colspan="2" align="left" valign="middle">
                      <input type="text" name="cob_taquilla_hnac" class="textboxsmal" style="height:16px; width:100px"
                    onkeypress="ValidaSoloNumeros()" title="indique costo por alquiler"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($por_alquiler_hnac, ENT_COMPAT, 'utf-8'); ?>">                    </td>
                  </tr>
                </table>
              <table width="920" align="center" style="background:#00BB7E;color:#FFF; font-size:10px; line-height:11px"
               border="0">
                  <tr>
                  <td height="52" colspan="10" align="center" valign="middle" nowrap 
                  style="background:#333333; font-size:24px; color: #FFF">
               	  <strong>OPCIONES VENTAS MACUARE</strong>
                  </td>
                </tr>
                  <tr>
                    <td align="center" valign="bottom">ACTIVAR VENTAS</td>
                    <td width="87" rowspan="2" align="center" valign="top">
                    	ACEPTA APUESTAS<br/>HIPODROMO<br/>LA RINCONADA<br/>
						<input type="checkbox" name="est_ven_rin_macu" class="textboxsmal" style="height:auto"
                    	value=""  <?php if (!(strcmp(htmlentities($est_ven_rin_macu, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                    </td>
                    <td width="87" rowspan="2" align="center" valign="top">
                    	ACEPTA APUESTAS<br/>HIPODROMO<br/>VALENCIA<br/>
						<input type="checkbox" name="est_ven_val_macu" class="textboxsmal" style="height:auto"
                    	value=""  <?php if (!(strcmp(htmlentities($est_ven_val_macu, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                    </td>
                    <td width="83" rowspan="2" align="center" valign="top">
                    	ACEPTA APUESTAS<br/>HIPODROMO<br/>SANTA RITA<br/>
						<input type="checkbox" name="est_ven_san_macu" class="textboxsmal" style="height:auto"
                    	value=""  <?php if (!(strcmp(htmlentities($est_ven_san_macu, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                    </td>
                    <td width="91" rowspan="2" align="center" valign="top">
                        ACEPTA APUESTAS<br/>HIPODROMO<br/>RANCHO ALEGRE<br/>
                        <input type="checkbox" name="est_ven_ran_macu" class="textboxsmal" style="height:auto"
                        value=""  <?php if (!(strcmp(htmlentities($est_ven_ran_macu, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                    </td>
                    <td align="center" valign="top">ACEPTA MACUARE LARGO</td>
                    <td align="center" valign="top">ACEPTA MACUARE CORTO</td>
                    <td align="center" valign="bottom">MONTO JUGADA MINIMA</td>
                    <td align="center" valign="bottom">MONTO JUGADA MAXIMA</td>
                    <td align="center" valign="top">LIMITE MAXIMO MACUARES IGUALES</td>
                  </tr>
                  <tr>
                    <td width="82" align="center" valign="top">
                      <select name="est_ven_macu" style="width:68px; height: 39px" class="textbox">
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($est_ven_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($est_ven_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
                      </select>
                    </td>
                    <td width="75" align="center" valign="top">
                      <select name="apu_lar_macu" style="width:68px; height: 39px" class="textbox">
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($apu_lar_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($apu_lar_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
                      </select>
                    </td>
                    <td width="75" align="center" valign="top">
                      <select name="apu_cor_macu" style="width:68px; height: 39px" class="textbox">
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($apu_cor_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($apu_cor_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
                      </select>
                    </td>
                    <td width="90" align="center" valign="top">
                    <input type="text" name="apu_min_macu" class="textboxsmal" 
                    style="height:16px; width:70px; font-size:16px" 
                    onkeypress="ValidaSoloNumeros()" title="indique monto mìnimo de macuare"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($apu_min_macu, ENT_COMPAT, 'utf-8'); ?>" >
                    </td>
                    <td width="93" align="center" valign="top">
                    <input type="text" name="apu_max_macu" class="textboxsmal" 
                    style="height:16px; width:70px; font-size:16px" 
                    onkeypress="ValidaSoloNumeros()" title="indique monto máximo de macuare"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($apu_max_macu, ENT_COMPAT, 'utf-8'); ?>" >
                    </td>
                    <td width="93" align="center" valign="top">
                    <input type="text" name="lim_max_macu" class="textboxsmal" 
                    style="height:16px; width:70px; font-size:16px" 
                    onkeypress="ValidaSoloNumeros()" title="indique lìmite máximo de macuare"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($lim_max_macu, ENT_COMPAT, 'utf-8'); ?>" >
                    </td>
                  </tr>
                  <tr>
                  <td align="center" valign="middle">USAR DIVIDENDO OFICIAL</td>
                  <td align="center" valign="middle">AGREGAR MODIFICAR DIVIDENDO</td>
                  <td colspan="2" align="center" valign="bottom">CON JORNADA INCOMPLETA<br/>LA JUGADA SE</td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="bottom">PORCENTAJE MACUARE</td>
                  </tr>
                  <tr>
                  <td align="center" valign="top">
                      <select name="div_ofi_macu" style="width:68px; height: 39px" class="textbox">
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($div_ofi_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($div_ofi_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
                    </select>
                  </td>
                  <td align="center" valign="top">
                      <select name="mod_div_macu" style="width:68px; height: 39px" class="textbox">
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($mod_div_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($mod_div_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
                    </select>
                  </td>
                  <td colspan="2" align="center" valign="top">
                      <select name="opc_jornadai_macu" style="width:150px; height: 39px" class="textbox">
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($opc_jornadai_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>PAGA MITAD</option>
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($opc_jornadai_macu, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>DEVUELVE</option>
                    </select>
                  </td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="middle">&nbsp;</td>
                  <td align="center" valign="top">
                    <input type="text" name="por_alquiler_macu" class="textboxsmal" style="height:16px; width:60px"
                    onkeypress="ValidaSoloNumeros()" title="indique porcentaje por alquiler"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($por_alquiler_macu, ENT_COMPAT, 'utf-8'); ?>">                    
                  </td>
                  </tr>
                </table>
              <table width="920" align="center" 
              style="color:#333;font-size:11px;line-height:11px" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="155" bgcolor="#333" style="font-size:16px; color:#FFF"><strong>LA RINCONADA:</strong></td>
                <td colspan="11" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
                	DEFINE USO DE REGLAS PARA DIVIDENDOS:&nbsp;               
                  <select name="def_rin_regdiv_hnac" 
                	style="width:70px; height: 41px; font-size:20px; margin:1px 0px 0px 0px" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($def_rin_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($def_rin_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
                </select></td>
                <td width="72" align="right" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
				<a href='#' id="bh1" onclick="mos_ocu('rh1','bh1')"
                  class="btn btn-inverse" 
                  style="width:40px; height:15px; font-size:9px;text-decoration:none; margin-right:2px; color:#FFFFFF">
                  	Ocultar
                  </a>

                </td>
                </tr>
              <tr>
              </table>
              <?php //-------------------------------------?>
              <div id="rh1">
              <table width="920" align="center" 
              style="color:#333;font-size:11px;line-height:11px" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="39">&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #1</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td width="3" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="67" align="center" valign="bottom" bgcolor="#FFFFCC">PAGA:</td>
                <td width="56" align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td width="38">&nbsp;</td>
                <td width="161" align="center" bgcolor="#009745" style="color:#FFFFFF">TOPES PARCIALES</td>
                <td width="50" align="center">&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="46">&nbsp;</td>
                <td width="105" align="center">
				<select name="rin_eje_des1_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_des1_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td width="108" align="center">
				<select name="rin_eje_has1_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_has1_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="94" align="center" valign="top">
                  <input type="text" name="div_rin_pdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_pdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td width="97" align="center" valign="top">
				<input type="text" name="div_rin_phas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_phas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_rin_pdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_rin_pdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_rin_pdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>
                </td>
                <td>&nbsp;</td>
                <td align="center">
				<input type="text" name="pag_rin_pdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_rin_pdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">                
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_rin_reg1_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg1_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                      <select name="est_tope_rin" style="width:150px; height: 39px" class="textbox">
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($est_tope_rin, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>INACTIVO</option>
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($est_tope_rin, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>ACTIVO</option>
                    </select>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #2</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGA:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 1er FAVORITO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center">
				<select name="rin_eje_des2_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_des2_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center">
				<select name="rin_eje_has2_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_has2_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="94" align="center" valign="top">
                  <input type="text" name="div_rin_sdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_sdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td width="97" align="center" valign="top">
				<input type="text" name="div_rin_shas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_shas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
                <select name="opc_rin_sdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_rin_sdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_rin_sdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>
                </td>
                <td>&nbsp;</td>
                <td align="center">
				<input type="text" name="pag_rin_sdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_rin_sdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_rin_reg2_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg2_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_pfav_rin_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del primer favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_pfav_rin_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #3</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGA:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 2do FAVORITO</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center">
				<select name="rin_eje_des3_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_des3_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center">
				<select name="rin_eje_has3_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_has3_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="94" align="center" valign="top">
                  <input type="text" name="div_rin_tdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_tdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td width="97" align="center" valign="top">
				<input type="text" name="div_rin_thas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_thas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_rin_tdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_rin_tdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_rin_tdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>
                </td>
                <td>&nbsp;</td>
                <td align="center">
                <input type="text" name="pag_rin_tdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_rin_tdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_rin_reg3_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg3_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_sfav_rin_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del segundo favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_sfav_rin_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #4</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGA:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 3er FAVORITO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center">
				<select name="rin_eje_des4_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_des4_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center">
				<select name="rin_eje_has4_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_has4_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="94" align="center" valign="top">
                  <input type="text" name="div_rin_ddes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_ddes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td width="97" align="center" valign="top">
				<input type="text" name="div_rin_dhas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_dhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_rin_ddiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_rin_ddiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_rin_ddiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center">
                <input type="text" name="pag_rin_ddiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_rin_ddiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_rin_reg4_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg4_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_tfav_rin_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del tercer favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_tfav_rin_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #5</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGA:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO AL RESTO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center">
				<select name="rin_eje_des5_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_des5_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center">
				<select name="rin_eje_has5_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_has5_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="94" align="center" valign="top">
                  <input type="text" name="div_rin_qdes_hnac" class="textboxsmal" style="height:9px; width:60px;"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_qdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td width="97" align="center" valign="top">
				<input type="text" name="div_rin_qhas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_qhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_rin_qdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_rin_qdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_rin_qdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center">
                <input type="text" name="pag_rin_qdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_rin_qdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_rin_reg5_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg5_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_dem_rin_hnac" class="textboxsmal" 
                    style="height:16px; width:65px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo al resto de ejemplares"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_dem_rin_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #6</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGA:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center">
				<select name="rin_eje_des6_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_des6_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center">
				<select name="rin_eje_has6_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_has6_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="94" align="center" valign="top">
                  <input type="text" name="div_rin_6des_hnac" class="textboxsmal" style="height:9px; width:60px;"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_6des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td width="97" align="center" valign="top">
				<input type="text" name="div_rin_6has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_6has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_rin_6div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_rin_6div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_rin_6div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center">
                <input type="text" name="pag_rin_6div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_rin_6div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_rin_reg6_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg6_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #7</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGA:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center">
				<select name="rin_eje_des7_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_des7_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center">
				<select name="rin_eje_has7_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_has7_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="94" align="center" valign="top">
                  <input type="text" name="div_rin_7des_hnac" class="textboxsmal" style="height:9px; width:60px;"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_7des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td width="97" align="center" valign="top">
				<input type="text" name="div_rin_7has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_7has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_rin_7div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_rin_7div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_rin_7div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center">
                <input type="text" name="pag_rin_7div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_rin_7div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_rin_reg7_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg7_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #8</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGA:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center">
				<select name="rin_eje_des8_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_des8_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center">
				<select name="rin_eje_has8_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($rin_eje_has8_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="94" align="center" valign="top">
                  <input type="text" name="div_rin_8des_hnac" class="textboxsmal" style="height:9px; width:60px;"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_8des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td width="97" align="center" valign="top">
				<input type="text" name="div_rin_8has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_rin_8has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="3" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_rin_8div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_rin_8div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_rin_8div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center">
                <input type="text" name="pag_rin_8div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_rin_8div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_rin_reg8_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg8_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>

              </table>
   			  </div>
              <div style="background:#FFFFFF; height:3px"></div>
              <table width="920" align="center" style="background: #757575; color:#333;font-size:11px;line-height:11px" 
              border="0"  cellpadding="0" cellspacing="0">
              <tr>
                <td width="155" bgcolor="#333" style="font-size:16px; color:#FFF"><strong>VALENCIA:</strong></td>
                <td colspan="11" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
                	DEFINE USO DE REGLAS PARA DIVIDENDOS:&nbsp;               
                  <select name="def_val_regdiv_hnac" 
                	style="width:70px; height: 41px; font-size:20px; margin:1px 0px 0px 0px" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($def_val_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($def_val_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
                </select></td>
                <td width="112" align="right" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
				<a href='#' id="bh2" onclick="mos_ocu('rh2','bh2')"
                  class="btn btn-inverse" 
                  style="width:40px; height:15px; font-size:9px;text-decoration:none; margin-right:2px; color:#FFFFFF">
                  	Ocultar
                  </a>
                </td>
              </tr>
              </table>
              <?php //-------------------------------------?>
              <div id="rh2">
              <table width="920" align="center" style="background: #757575; color:#333;font-size:11px;line-height:11px" 
              border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="39">&nbsp;</td>
                <td width="48" align="left" valign="bottom" bgcolor="#FFFFCC">Regla #1</td>
                <td width="104" align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td width="107" align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td width="1" align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="68" align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td width="56" align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td width="34">&nbsp;</td>
                <td width="155" align="center" bgcolor="#009745" style="color:#FFFFFF">TOPES PARCIALES</td>
                <td width="35">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="val_eje_des1_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_des1_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="val_eje_has1_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_has1_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_val_pdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_pdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_val_phas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_phas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_val_pdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_val_pdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_val_pdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_val_pdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_val_pdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_val_reg1_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg1_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                      <select name="est_tope_val" style="width:150px; height: 39px" class="textbox">
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($est_tope_val, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>INACTIVO</option>
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($est_tope_val, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>ACTIVO</option>
                    </select>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #2</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 1er FAVORITO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="val_eje_des2_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_des2_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="val_eje_has2_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_has2_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_val_sdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_sdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_val_shas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_shas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_val_sdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_val_sdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_val_sdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_val_sdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_val_sdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_val_reg2_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg2_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                <input type="text" name="top_pfav_val_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del primer favorito"
                    onkeyup="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_pfav_val_hnac, ENT_COMPAT, 'utf-8'); ?>" />
				</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #3</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 2do FAVORITO</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="val_eje_des3_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_des3_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="val_eje_has3_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_has3_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_val_tdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_tdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_val_thas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_thas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_val_tdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_val_tdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_val_tdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_val_tdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_val_tdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_val_reg3_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg3_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_sfav_val_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del segundo favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_sfav_val_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #4</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 3er FAVORITO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="val_eje_des4_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_des4_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="val_eje_has4_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_has4_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_val_ddes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_ddes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_val_dhas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_dhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_val_ddiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_val_ddiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_val_ddiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_val_ddiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_val_ddiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_val_reg4_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg4_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_tfav_val_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del tercer favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_tfav_val_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #5</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO AL RESTO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="val_eje_des5_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_des5_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="val_eje_has5_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_has5_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_val_qdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_qdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_val_qhas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_qhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_val_qdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_val_qdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_val_qdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_val_qdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_val_qdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_val_reg5_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg5_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_dem_val_hnac" class="textboxsmal" 
                    style="height:16px; width:65px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo al resto de ejemplares"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_dem_val_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #6</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="val_eje_des6_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_des6_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="val_eje_has6_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_has6_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_val_6des_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_6des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_val_6has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_6has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_val_6div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_val_6div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_val_6div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_val_6div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_val_6div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_val_reg6_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg6_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #7</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="val_eje_des7_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_des7_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="val_eje_has7_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_has7_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_val_7des_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_7des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_val_7has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_7has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_val_7div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_val_7div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_val_7div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_val_7div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_val_7div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_val_reg7_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg7_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #8</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="val_eje_des8_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_des8_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="val_eje_has8_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($val_eje_has8_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_val_8des_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_8des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_val_8has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_val_8has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_val_8div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_val_8div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_val_8div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_val_8div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_val_8div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_val_reg8_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg8_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              </table>
   			  </div>
              <div style="background:#FFFFFF; height:3px"></div>
              <table width="920" align="center" style="color:#333; font-size:11px;line-height:11px" border="0"  
              cellpadding="0" cellspacing="0">
              <tr>
                <td width="155" bgcolor="#333" style="font-size:16px; color:#FFF"><strong>SANTA RITA:</strong></td>
                <td colspan="11" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
                	DEFINE USO DE REGLAS PARA DIVIDENDOS:&nbsp;               
                  <select name="def_san_regdiv_hnac" 
                	style="width:70px; height: 41px; font-size:20px; margin:1px 0px 0px 0px" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($def_san_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($def_san_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
                </select></td>
                <td width="74" align="right" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
				<a href='#' id="bh3" onclick="mos_ocu('rh3','bh3')"
                  class="btn btn-inverse" 
                  style="width:40px; height:15px; font-size:9px;text-decoration:none; margin-right:2px; color:#FFFFFF">
                  	Ocultar
                  </a>
                </td>
                </tr>
              </table>
              <?php //-------------------------------------?>
              <div id="rh3">
              <table width="920" align="center" style="color:#333; font-size:11px;line-height:11px" border="0"  
              cellpadding="0" cellspacing="0">
              <tr>
                <td width="39">&nbsp;</td>
                <td width="48" align="left" valign="bottom" bgcolor="#FFFFCC">Regla #1</td>
                <td width="104" align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td width="107" align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td width="1" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="68" align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td width="56" align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td width="35">&nbsp;</td>
                <td width="154" align="center" bgcolor="#009745" style="color:#FFFFFF">TOPES PARCIALES</td>
                <td width="35">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="san_eje_des1_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_des1_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="san_eje_has1_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_has1_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_san_pdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_pdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_san_phas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_phas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_san_pdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_san_pdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_san_pdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>				                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_san_pdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_san_pdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_san_reg1_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_san_reg1_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                      <select name="est_tope_san" style="width:150px; height: 39px" class="textbox">
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($est_tope_san, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>INACTIVO</option>
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($est_tope_san, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>ACTIVO</option>
                    </select>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #2</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 1er FAVORITO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="san_eje_des2_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_des2_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="san_eje_has2_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_has2_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_san_sdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_sdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_san_shas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_shas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
                <select name="opc_san_sdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_san_sdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_san_sdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_san_sdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_san_sdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_san_reg2_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_san_reg2_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                	<input type="text" name="top_pfav_san_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del primer favorito"
                    onkeyup="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_pfav_san_hnac, ENT_COMPAT, 'utf-8'); ?>" />
				</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #3</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 2do FAVORITO</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="san_eje_des3_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_des3_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="san_eje_has3_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_has3_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_san_tdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_tdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_san_thas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_thas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_san_tdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_san_tdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_san_tdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_san_tdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_san_tdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_san_reg3_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_san_reg3_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                	<input type="text" name="top_sfav_san_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del segundo favorito"
                    onkeyup="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_sfav_san_hnac, ENT_COMPAT, 'utf-8'); ?>" />
				</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #4</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 3er FAVORITO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="san_eje_des4_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_des4_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="san_eje_has4_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_has4_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_san_ddes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_ddes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_san_dhas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_dhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_san_ddiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_san_ddiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_san_ddiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_san_ddiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_san_ddiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_san_reg4_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_san_reg4_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_tfav_san_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del tercer favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_tfav_san_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #5</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO AL RESTO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="san_eje_des5_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_des5_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="san_eje_has5_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_has5_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_san_qdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_qdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_san_qhas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_qhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_san_qdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_san_qdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_san_qdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_san_qdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_san_qdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_san_reg5_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_san_reg5_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_dem_san_hnac" class="textboxsmal" 
                    style="height:16px; width:65px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo al resto de ejemplares"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_dem_san_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #6</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="san_eje_des6_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_des6_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="san_eje_has6_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_has6_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_san_6des_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_6des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_san_6has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_6has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_san_6div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_san_6div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_san_6div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_san_6div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_san_6div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_san_reg6_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_san_reg6_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #7</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="san_eje_des7_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_des7_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="san_eje_has7_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_has7_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_san_7des_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_7des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_san_7has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_7has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_san_7div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_san_7div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_san_7div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_san_7div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_san_7div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_san_reg7_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_san_reg7_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #8</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#999999">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="san_eje_des8_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_des8_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="san_eje_has8_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($san_eje_has8_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_san_8des_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_8des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_san_8has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_san_8has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_san_8div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_san_8div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_san_8div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_san_8div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_san_8div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_san_reg8_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_san_reg8_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              </table>
   			  </div>
              <div style="background:#FFFFFF; height:3px"></div>
              <table width="920" align="center" style="background: #757575;color:#333; font-size:11px;line-height:11px" 
              border="0"  cellpadding="0" cellspacing="0">
              <tr>
                <td width="155" bgcolor="#333" style="font-size:14px; color:#FFF"><strong>RANCHO ALEGRE:</strong></td>
                <td colspan="11" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
                	DEFINE USO DE REGLAS PARA DIVIDENDOS:&nbsp;               
                  <select name="def_ran_regdiv_hnac" 
                	style="width:70px; height: 41px; font-size:20px; margin:1px 0px 0px 0px" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($def_ran_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($def_ran_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
                </select></td>
                <td width="71" align="right" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
				<a href='#' id="bh4" onclick="mos_ocu('rh4','bh4')"
                  class="btn btn-inverse" 
                  style="width:40px; height:15px; font-size:9px;text-decoration:none; margin-right:2px; color:#FFFFFF">
                  	Ocultar
                  </a>
                </td>
                </tr>
              </table>
              <?php //-------------------------------------?>
              <div id="rh4">
              <table width="920" align="center" style="background: #757575;color:#333; font-size:11px;line-height:11px" 
              border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="42">&nbsp;</td>
                <td width="48" align="left" valign="bottom" bgcolor="#FFFFCC">Regla #1</td>
                <td width="104" align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td width="107" align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td width="1" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="68" align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td width="56" align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td width="35">&nbsp;</td>
                <td width="151" align="center" bgcolor="#009745" style="color:#FFFFFF">TOPES PARCIALES</td>
                <td width="35">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="ran_eje_des1_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_des1_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="ran_eje_has1_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_has1_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_ran_pdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_pdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_ran_phas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_phas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_ran_pdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ran_pdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ran_pdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_ran_pdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_ran_pdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_ran_reg1_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg1_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                      <select name="est_tope_ran" style="width:150px; height: 39px" class="textbox">
                        <option value="0" 
						<?php if (!(strcmp(0, htmlentities($est_tope_ran, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>INACTIVO</option>
                        <option value="1" 
						<?php if (!(strcmp(1, htmlentities($est_tope_ran, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>ACTIVO</option>
                    </select>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #2</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 1er FAVORITO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="ran_eje_des2_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_des2_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="ran_eje_has2_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_has2_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_ran_sdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_sdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_ran_shas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_shas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_ran_sdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ran_sdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ran_sdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_ran_sdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_ran_sdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_ran_reg2_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg2_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                	<input type="text" name="top_pfav_ran_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del primer favorito"
                    onkeyup="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_pfav_ran_hnac, ENT_COMPAT, 'utf-8'); ?>" />
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #3</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 2do FAVORITO</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="ran_eje_des3_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_des3_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="ran_eje_has3_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_has3_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_ran_tdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_tdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_ran_thas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_thas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_ran_tdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ran_tdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ran_tdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_ran_tdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_ran_tdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_ran_reg3_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg3_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                	<input type="text" name="top_sfav_ran_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del segundo favorito"
                    onkeyup="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_sfav_ran_hnac, ENT_COMPAT, 'utf-8'); ?>" />
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #4</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO 3er FAVORITO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="ran_eje_des4_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_des4_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="ran_eje_has4_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_has4_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_ran_ddes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_ddes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_ran_dhas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_dhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_ran_ddiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ran_ddiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ran_ddiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_ran_ddiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_ran_ddiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_ran_reg4_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg4_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_tfav_ran_hnac" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo del tercer favorito"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_tfav_ran_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #5</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td>&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#009745" style="color:#FFFFFF">TOPE MÁXIMO AL RESTO:</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="ran_eje_des5_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_des5_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="ran_eje_has5_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_has5_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_ran_qdes_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_qdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_ran_qhas_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_qhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_ran_qdiv_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ran_qdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ran_qdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_ran_qdiv_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_ran_qdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_ran_reg5_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg5_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" name="top_dem_ran_hnac" class="textboxsmal" 
                    style="height:16px; width:65px; font-size:14px"
                    onkeypress="ValidaSoloNumeros()" title="indique tope máximo al resto de ejemplares"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($top_dem_ran_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #6</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="ran_eje_des6_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_des6_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="ran_eje_has6_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_has6_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_ran_6des_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_6des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_ran_6has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_6has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_ran_6div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ran_6div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ran_6div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_ran_6div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_ran_6div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_ran_reg6_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg6_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #7</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="ran_eje_des7_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_des7_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="ran_eje_has7_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_has7_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_ran_7des_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_7des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_ran_7has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_7has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_ran_7div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ran_7div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ran_7div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_ran_7div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_ran_7div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_ran_reg7_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg7_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="bottom" bgcolor="#FFFFCC">Regla #8</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES DESDE:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">EJEMPLARES HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO DESDE:</td>
                <td valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">DIVIDENDO HASTA:</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">&nbsp;</td>
                <td width="50" align="center" valign="bottom" bgcolor="#FFFFCC">OPCION:</td>
                <td bgcolor="#FFFFCC">&nbsp;</td>
                <td align="center" valign="bottom" bgcolor="#FFFFCC">PAGO:</td>
                <td align="center" valign="bottom" bgcolor="#CCCCCC">EMPATE</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
				<select name="ran_eje_des8_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_des8_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>                
                </td>
                <td align="center" valign="top">
				<select name="ran_eje_has8_hnac" style="width:59px; height: 30px" class="textbox">
					<?php
                    for ($i = 2;  $i <=$has; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($ran_eje_has8_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
				</select>
                </td>
                <td width="93" align="center" valign="top">
                  <input type="text" name="div_ran_8des_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_8des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" name="div_ran_8has_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($div_ran_8has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select name="opc_ran_8div_hnac" 
                	style="width:50px; height: 30px; font-size:16px; font-weight: bold;" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ran_8div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ran_8div_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                </select>                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <input type="text" name="pag_ran_8div_hnac" class="textboxsmal" style="height:9px; width:60px"
                onkeypress="ValidaSoloNumeros()" title="indique pago según dividendo"
                onKeyUp="return handleEnter(this, event)"
                value="<?php echo htmlentities($pag_ran_8div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" name="emp_ran_reg8_hnac" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg8_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
              </table>
   			  </div>
              <div style="background:#FFFFFF; height:3px"></div>
			</div>
              <table width="924" align="center">
                <tr valign="baseline">
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="362" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td width="88" align="left" nowrap>&nbsp;</td>
                  <td width="66" align="left" nowrap>&nbsp;</td>
                  <td width="33" align="left" nowrap>&nbsp;</td>
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td align="right" valign="bottom" nowrap>
                  <a href='distri_taquillas_lista_hnac.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="37" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="9" align="left" nowrap>&nbsp;</td>
                </tr>
              </table>
          </div>
          <input type="hidden" name="MM_update" value="form1">
          <input type="hidden" name="tip_usuario" value="U"/>
      </form>
    </div>
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
</div>
</body>
</html>
<?php
if (isset($Recordset2)) {
                        mysqli_free_result($Recordset2);
                    }
if (isset($Recordset3)) {
    mysqli_free_result($Recordset3);
}
if (isset($Recordset4)) {
    mysqli_free_result($Recordset4);
}
?>
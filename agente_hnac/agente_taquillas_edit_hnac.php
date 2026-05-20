<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");

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


$xCodigo = "-1";
$xCodigo2 = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
    $xCodigo2 = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 agente_hnac\agente_taquillas_edit_hnac.php - QUERY 1 */ SELECT  
	ta.nom_taquilla,
	ta.nom_representante, 
	ta.tel_taquilla, 
	ta.tel_taquilla2, 
	ta.tel_taquilla3, 
	ta.cod_taquilla,
	ta.est_taquilla_hnac,
	ag.nom_agencia
	FROM  
	taquilla ta, agencia ag 
	WHERE ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia AND ag.cod_agencia = %s 
	LIMIT 1",
    GetSQLValueString($_GET["recordID"], "int"),
    GetSQLValueString($_SESSION['MM_cod_agente'], "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $graba=31;
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 agente_hnac\agente_taquillas_edit_hnac.php - QUERY 2 */ UPDATE taquilla 
				SET nom_representante=%s, tel_taquilla=%s, tel_taquilla2=%s, tel_taquilla3=%s, est_taquilla_hnac=%s
				WHERE cod_taquilla=%s",
            GetSQLValueString($_POST['nom_representante'], "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString($_POST['tel_taquilla2'], "text"),
            GetSQLValueString($_POST['tel_taquilla3'], "text"),
            GetSQLValueString($_POST['est_opc_hnac'], "int"),
            GetSQLValueString($_POST['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
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

        if ($_POST['existe']==0) {
            $insertSQL3 = sprintf(
                "/* PARSEADORES1 agente_hnac\agente_taquillas_edit_hnac.php - QUERY 3 */ INSERT INTO taquilla_opc_hnac (cod_taquilla, con_divid_hnac, mod_divid_hnac, max_jugtic_hnac, min_jugtic_hnac, max_eje_hnac, cab_min_hnac, top_pfav_hnac, top_sfav_hnac, top_tfav_hnac, top_dem_hnac, def_rin_regdiv_hnac, div_rin_pdes_hnac, div_rin_phas_hnac, pag_rin_pdiv_hnac, div_rin_sdes_hnac, div_rin_shas_hnac, pag_rin_sdiv_hnac, div_rin_tdes_hnac, div_rin_thas_hnac, pag_rin_tdiv_hnac, div_rin_ddes_hnac, div_rin_dhas_hnac, pag_rin_ddiv_hnac, def_val_regdiv_hnac, div_val_pdes_hnac, div_val_phas_hnac, pag_val_pdiv_hnac, div_val_sdes_hnac, div_val_shas_hnac, pag_val_sdiv_hnac, div_val_tdes_hnac, div_val_thas_hnac, pag_val_tdiv_hnac, div_val_ddes_hnac, div_val_dhas_hnac, pag_val_ddiv_hnac, def_san_regdiv_hnac, div_san_pdes_hnac, div_san_phas_hnac, pag_san_pdiv_hnac, div_san_sdes_hnac, div_san_shas_hnac, pag_san_sdiv_hnac, div_san_tdes_hnac, div_san_thas_hnac, pag_san_tdiv_hnac, div_san_ddes_hnac, div_san_dhas_hnac, pag_san_ddiv_hnac, def_ran_regdiv_hnac, div_ran_pdes_hnac, div_ran_phas_hnac, pag_ran_pdiv_hnac, div_ran_sdes_hnac, div_ran_shas_hnac, pag_ran_sdiv_hnac, div_ran_tdes_hnac, div_ran_thas_hnac, pag_ran_tdiv_hnac, div_ran_ddes_hnac, div_ran_dhas_hnac, pag_ran_ddiv_hnac, cob_taquilla_hnac, est_gan_hnac, 
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
			est_tope_val, top_pfav_val_hnac, top_sfav_val_hnac, top_tfav_val_hnac, top_dem_val_hnac,
            redondeo_hnac
			
			) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
			
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,

%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,

%s, %s, %s, %s, %s,
%s, %s, %s, %s, %s,
%s, %s, %s, %s, %s,
%s, %s, %s, %s, %s, %s

)",
                GetSQLValueString($_POST['cod_taquilla'], "int"),
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
                GetSQLValueString($_POST['top_dem_val_hnac'], "double"),
                GetSQLValueString($_POST['redondeo_hnac'], "int")
            );
            $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
        } else {
            echo "aquii ".$_POST['cod_taquilla']." ".$_POST['cod_taopc_hnac'];
            if (!isset($_POST['emp_rin_reg2_hnac'])) {
                $_POST['emp_rin_reg2_hnac']=0;
            }
            if (!isset($_POST['emp_rin_reg3_hnac'])) {
                $_POST['emp_rin_reg3_hnac']=0;
            }
            if (!isset($_POST['emp_rin_reg4_hnac'])) {
                $_POST['emp_rin_reg4_hnac']=0;
            }
            if (!isset($_POST['emp_rin_reg5_hnac'])) {
                $_POST['emp_rin_reg5_hnac']=0;
            }
            if (!isset($_POST['emp_rin_reg6_hnac'])) {
                $_POST['emp_rin_reg6_hnac']=0;
            }
            if (!isset($_POST['emp_rin_reg7_hnac'])) {
                $_POST['emp_rin_reg7_hnac']=0;
            }
            if (!isset($_POST['emp_rin_reg8_hnac'])) {
                $_POST['emp_rin_reg8_hnac']=0;
            }

            if (!isset($_POST['emp_val_reg1_hnac'])) {
                $_POST['emp_val_reg1_hnac']=0;
            }
            if (!isset($_POST['emp_val_reg2_hnac'])) {
                $_POST['emp_val_reg2_hnac']=0;
            }
            if (!isset($_POST['emp_val_reg3_hnac'])) {
                $_POST['emp_val_reg3_hnac']=0;
            }
            if (!isset($_POST['emp_val_reg4_hnac'])) {
                $_POST['emp_val_reg4_hnac']=0;
            }
            if (!isset($_POST['emp_val_reg5_hnac'])) {
                $_POST['emp_val_reg5_hnac']=0;
            }
            if (!isset($_POST['emp_val_reg6_hnac'])) {
                $_POST['emp_val_reg6_hnac']=0;
            }
            if (!isset($_POST['emp_val_reg7_hnac'])) {
                $_POST['emp_val_reg7_hnac']=0;
            }
            if (!isset($_POST['emp_val_reg8_hnac'])) {
                $_POST['emp_val_reg8_hnac']=0;
            }

            if (!isset($_POST['emp_ran_reg1_hnac'])) {
                $_POST['emp_ran_reg1_hnac']=0;
            }
            if (!isset($_POST['emp_ran_reg2_hnac'])) {
                $_POST['emp_ran_reg2_hnac']=0;
            }
            if (!isset($_POST['emp_ran_reg3_hnac'])) {
                $_POST['emp_ran_reg3_hnac']=0;
            }
            if (!isset($_POST['emp_ran_reg4_hnac'])) {
                $_POST['emp_ran_reg4_hnac']=0;
            }
            if (!isset($_POST['emp_ran_reg5_hnac'])) {
                $_POST['emp_ran_reg5_hnac']=0;
            }
            if (!isset($_POST['emp_ran_reg6_hnac'])) {
                $_POST['emp_ran_reg6_hnac']=0;
            }
            if (!isset($_POST['emp_ran_reg7_hnac'])) {
                $_POST['emp_ran_reg7_hnac']=0;
            }
            if (!isset($_POST['emp_ran_reg8_hnac'])) {
                $_POST['emp_ran_reg8_hnac']=0;
            }

            if (!isset($_POST['emp_san_reg1_hnac'])) {
                $_POST['emp_san_reg1_hnac']=0;
            }
            if (!isset($_POST['emp_san_reg2_hnac'])) {
                $_POST['emp_san_reg2_hnac']=0;
            }
            if (!isset($_POST['emp_san_reg3_hnac'])) {
                $_POST['emp_san_reg3_hnac']=0;
            }
            if (!isset($_POST['emp_san_reg4_hnac'])) {
                $_POST['emp_san_reg4_hnac']=0;
            }
            if (!isset($_POST['emp_san_reg5_hnac'])) {
                $_POST['emp_san_reg5_hnac']=0;
            }
            if (!isset($_POST['emp_san_reg6_hnac'])) {
                $_POST['emp_san_reg6_hnac']=0;
            }
            if (!isset($_POST['emp_san_reg7_hnac'])) {
                $_POST['emp_san_reg7_hnac']=0;
            }
            if (!isset($_POST['emp_san_reg8_hnac'])) {
                $_POST['emp_san_reg8_hnac']=0;
            }

            
            $updateSQL4 = sprintf(
                "/* PARSEADORES1 agente_hnac\agente_taquillas_edit_hnac.php - QUERY 4 */ UPDATE taquilla_opc_hnac SET con_divid_hnac=%s, mod_divid_hnac=%s, max_jugtic_hnac=%s, min_jugtic_hnac=%s, max_eje_hnac=%s, cab_min_hnac=%s, top_pfav_hnac=%s, top_sfav_hnac=%s, top_tfav_hnac=%s, top_dem_hnac=%s, def_rin_regdiv_hnac=%s, div_rin_pdes_hnac=%s, div_rin_phas_hnac=%s, pag_rin_pdiv_hnac=%s, div_rin_sdes_hnac=%s, div_rin_shas_hnac=%s, pag_rin_sdiv_hnac=%s, div_rin_tdes_hnac=%s, div_rin_thas_hnac=%s, pag_rin_tdiv_hnac=%s, div_rin_ddes_hnac=%s, div_rin_dhas_hnac=%s, pag_rin_ddiv_hnac=%s, def_val_regdiv_hnac=%s, div_val_pdes_hnac=%s, div_val_phas_hnac=%s, pag_val_pdiv_hnac=%s, div_val_sdes_hnac=%s, div_val_shas_hnac=%s, pag_val_sdiv_hnac=%s, div_val_tdes_hnac=%s, div_val_thas_hnac=%s, pag_val_tdiv_hnac=%s, div_val_ddes_hnac=%s, div_val_dhas_hnac=%s, pag_val_ddiv_hnac=%s, def_san_regdiv_hnac=%s, div_san_pdes_hnac=%s, div_san_phas_hnac=%s, pag_san_pdiv_hnac=%s, div_san_sdes_hnac=%s, div_san_shas_hnac=%s, pag_san_sdiv_hnac=%s, div_san_tdes_hnac=%s, div_san_thas_hnac=%s, pag_san_tdiv_hnac=%s, div_san_ddes_hnac=%s, div_san_dhas_hnac=%s, pag_san_ddiv_hnac=%s, def_ran_regdiv_hnac=%s, div_ran_pdes_hnac=%s, div_ran_phas_hnac=%s, pag_ran_pdiv_hnac=%s, div_ran_sdes_hnac=%s, div_ran_shas_hnac=%s, pag_ran_sdiv_hnac=%s, div_ran_tdes_hnac=%s, div_ran_thas_hnac=%s, pag_ran_tdiv_hnac=%s, div_ran_ddes_hnac=%s, div_ran_dhas_hnac=%s, pag_ran_ddiv_hnac=%s, cob_taquilla_hnac=%s, est_gan_hnac=%s, est_pla_hnac=%s, est_exa_hnac=%s, est_tri_hnac=%s, est_sup_hnac=%s,
		  
			opc_rin_pdiv_hnac=%s, opc_rin_sdiv_hnac=%s, opc_rin_tdiv_hnac=%s, opc_rin_ddiv_hnac=%s, opc_rin_qdiv_hnac=%s,
			opc_val_pdiv_hnac=%s, opc_val_sdiv_hnac=%s, opc_val_tdiv_hnac=%s, opc_val_ddiv_hnac=%s, opc_val_qdiv_hnac=%s,
			opc_san_pdiv_hnac=%s, opc_san_sdiv_hnac=%s, opc_san_tdiv_hnac=%s, opc_san_ddiv_hnac=%s, opc_san_qdiv_hnac=%s,
			opc_ran_pdiv_hnac=%s, opc_ran_sdiv_hnac=%s, opc_ran_tdiv_hnac=%s, opc_ran_ddiv_hnac=%s, opc_ran_qdiv_hnac=%s,
			div_rin_qdes_hnac=%s, div_rin_qhas_hnac=%s, pag_rin_qdiv_hnac=%s,
			div_val_qdes_hnac=%s, div_val_qhas_hnac=%s, pag_val_qdiv_hnac=%s,
			div_san_qdes_hnac=%s, div_san_qhas_hnac=%s, pag_san_qdiv_hnac=%s,
			div_ran_qdes_hnac=%s, div_ran_qhas_hnac=%s, pag_ran_qdiv_hnac=%s, ver_porpagar_hnac=%s,
			
			
			rin_eje_des1_hnac=%s, rin_eje_has1_hnac=%s, rin_eje_des2_hnac=%s, rin_eje_has2_hnac=%s,
			rin_eje_des3_hnac=%s, rin_eje_has3_hnac=%s, rin_eje_des4_hnac=%s, rin_eje_has4_hnac=%s,
			rin_eje_des5_hnac=%s, rin_eje_has5_hnac=%s, val_eje_des1_hnac=%s, val_eje_has1_hnac=%s,
			val_eje_des2_hnac=%s, val_eje_has2_hnac=%s, val_eje_des3_hnac=%s, val_eje_has3_hnac=%s,
			val_eje_des4_hnac=%s, val_eje_has4_hnac=%s, val_eje_des5_hnac=%s, val_eje_has5_hnac=%s,
			san_eje_des1_hnac=%s, san_eje_has1_hnac=%s, san_eje_des2_hnac=%s, san_eje_has2_hnac=%s,
			san_eje_des3_hnac=%s, san_eje_has3_hnac=%s, san_eje_des4_hnac=%s, san_eje_has4_hnac=%s,
			san_eje_des5_hnac=%s, san_eje_has5_hnac=%s, ran_eje_des1_hnac=%s, ran_eje_has1_hnac=%s,
			ran_eje_des2_hnac=%s, ran_eje_has2_hnac=%s, ran_eje_des3_hnac=%s, ran_eje_has3_hnac=%s,
			ran_eje_des4_hnac=%s, ran_eje_has4_hnac=%s, ran_eje_des5_hnac=%s, ran_eje_has5_hnac=%s,
			
			tic_caduca_hnac=%s, pag_codigo_hnac=%s,
			
			div_rin_6des_hnac=%s, div_rin_6has_hnac=%s, opc_rin_6div_hnac=%s, pag_rin_6div_hnac=%s, 
			div_rin_7des_hnac=%s, div_rin_7has_hnac=%s, opc_rin_7div_hnac=%s, pag_rin_7div_hnac=%s,	
			div_rin_8des_hnac=%s, div_rin_8has_hnac=%s, opc_rin_8div_hnac=%s, pag_rin_8div_hnac=%s,	
			div_val_6des_hnac=%s, div_val_6has_hnac=%s, opc_val_6div_hnac=%s, pag_val_6div_hnac=%s,
			div_val_7des_hnac=%s, div_val_7has_hnac=%s, opc_val_7div_hnac=%s, pag_val_7div_hnac=%s,
			div_val_8des_hnac=%s, div_val_8has_hnac=%s, opc_val_8div_hnac=%s, pag_val_8div_hnac=%s,
			div_san_6des_hnac=%s, div_san_6has_hnac=%s, opc_san_6div_hnac=%s, pag_san_6div_hnac=%s,
			div_san_7des_hnac=%s, div_san_7has_hnac=%s, opc_san_7div_hnac=%s, pag_san_7div_hnac=%s,
			div_san_8des_hnac=%s, div_san_8has_hnac=%s, opc_san_8div_hnac=%s, pag_san_8div_hnac=%s,
			div_ran_6des_hnac=%s, div_ran_6has_hnac=%s, opc_ran_6div_hnac=%s, pag_ran_6div_hnac=%s,
			div_ran_7des_hnac=%s, div_ran_7has_hnac=%s, opc_ran_7div_hnac=%s, pag_ran_7div_hnac=%s,
			div_ran_8des_hnac=%s, div_ran_8has_hnac=%s, opc_ran_8div_hnac=%s, pag_ran_8div_hnac=%s,
			rin_eje_des6_hnac=%s, rin_eje_has6_hnac=%s, rin_eje_des7_hnac=%s, rin_eje_has7_hnac=%s,
			rin_eje_des8_hnac=%s, rin_eje_has8_hnac=%s, val_eje_des6_hnac=%s, val_eje_has6_hnac=%s,
			val_eje_des7_hnac=%s, val_eje_has7_hnac=%s, val_eje_des8_hnac=%s, val_eje_has8_hnac=%s,
			san_eje_des6_hnac=%s, san_eje_has6_hnac=%s, san_eje_des7_hnac=%s, san_eje_has7_hnac=%s,
			san_eje_des8_hnac=%s, san_eje_has8_hnac=%s, ran_eje_des6_hnac=%s, ran_eje_has6_hnac=%s,
			ran_eje_des7_hnac=%s, ran_eje_has7_hnac=%s, ran_eje_des8_hnac=%s, ran_eje_has8_hnac=%s,
			
			est_ven_rin_hnac=%s, est_ven_val_hnac=%s, est_ven_san_hnac=%s, est_ven_ran_hnac=%s,
			
			tie_venta_hnac=%s, emp_rin_reg1_hnac=%s, emp_rin_reg2_hnac=%s, emp_rin_reg3_hnac=%s, emp_rin_reg4_hnac=%s,
			emp_rin_reg5_hnac=%s, emp_rin_reg6_hnac=%s, emp_rin_reg7_hnac=%s, emp_rin_reg8_hnac=%s, 
			emp_val_reg1_hnac=%s, emp_val_reg2_hnac=%s, emp_val_reg3_hnac=%s, emp_val_reg4_hnac=%s, 
			emp_val_reg5_hnac=%s, emp_val_reg6_hnac=%s, emp_val_reg7_hnac=%s, emp_val_reg8_hnac=%s, 
			emp_ran_reg1_hnac=%s, emp_ran_reg2_hnac=%s, emp_ran_reg3_hnac=%s, emp_ran_reg4_hnac=%s,
			emp_ran_reg5_hnac=%s, emp_ran_reg6_hnac=%s, emp_ran_reg7_hnac=%s, emp_ran_reg8_hnac=%s,
			emp_san_reg1_hnac=%s, emp_san_reg2_hnac=%s, emp_san_reg3_hnac=%s, emp_san_reg4_hnac=%s,
			emp_san_reg5_hnac=%s, emp_san_reg6_hnac=%s, emp_san_reg7_hnac=%s, emp_san_reg8_hnac=%s,
			
			tip_taq_hnac=%s, pre_fijo_hnac=%s, tip_ticket_hnac=%s,
			
			est_ven_macu=%s, est_ven_rin_macu=%s, est_ven_val_macu=%s, est_ven_san_macu=%s, est_ven_ran_macu=%s,
			apu_min_macu=%s, apu_max_macu=%s, lim_max_macu=%s, div_ofi_macu=%s, mod_div_macu=%s, apu_cor_macu=%s,
			apu_lar_macu=%s,
			
			est_taquilla_hnac=%s, opc_jornadai_macu=%s, por_alquiler_macu=%s,
			
			
			est_tope_rin=%s, top_pfav_rin_hnac=%s, top_sfav_rin_hnac=%s, top_tfav_rin_hnac=%s, top_dem_rin_hnac=%s, 

			est_tope_ran=%s, top_pfav_ran_hnac=%s, top_sfav_ran_hnac=%s, top_tfav_ran_hnac=%s, top_dem_ran_hnac=%s, 

			est_tope_san=%s, top_pfav_san_hnac=%s, top_sfav_san_hnac=%s, top_tfav_san_hnac=%s, top_dem_san_hnac=%s, 

			est_tope_val=%s, top_pfav_val_hnac=%s, top_sfav_val_hnac=%s, top_tfav_val_hnac=%s, top_dem_val_hnac=%s,
            redondeo_hnac=%s, limit_ticket=%s 
 


		  			 WHERE cod_taopc_hnac=%s",
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
                GetSQLValueString($_POST['ver_porpagar_hnac'], "int"),
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
                GetSQLValueString($_POST['top_dem_val_hnac'], "double"),
                GetSQLValueString($_POST['redondeo_hnac'], "int"),
                GetSQLValueString($_POST['limit_ticket'], "int"),
                GetSQLValueString($_POST['cod_taopc_hnac'], "int")
            );

if ($_POST['def_rin_regdiv_hnac']<>$row_Recordset3['def_rin_regdiv_hnac'] || $_POST['rin_eje_has1_hnac']<>$row_Recordset3['rin_eje_has1_hnac'] || $_POST['rin_eje_des1_hnac']<>$row_Recordset3['rin_eje_des1_hnac'] || $_POST['div_rin_pdes_hnac']<>$row_Recordset3['div_rin_pdes_hnac'] || $_POST['div_rin_phas_hnac']<>$row_Recordset3['div_rin_phas_hnac'] || $_POST['opc_rin_pdiv_hnac']<>$row_Recordset3['opc_rin_pdiv_hnac'] || $_POST['pag_rin_pdiv_hnac']<>$row_Recordset3['pag_rin_pdiv_hnac'] || $_POST['emp_rin_reg1_hnac']<>$row_Recordset3['emp_rin_reg1_hnac'] || $_POST['rin_eje_des2_hnac']<>$row_Recordset3['rin_eje_des2_hnac'] || $_POST['rin_eje_has2_hnac']<>$row_Recordset3['rin_eje_has2_hnac'] || $_POST['rin_eje_des2_hnac']<>$row_Recordset3['rin_eje_des2_hnac'] || $_POST['div_rin_sdes_hnac']<>$row_Recordset3['div_rin_sdes_hnac'] || $_POST['div_rin_shas_hnac']<>$row_Recordset3['div_rin_shas_hnac'] || $_POST['opc_rin_sdiv_hnac']<>$row_Recordset3['opc_rin_sdiv_hnac'] || $_POST['pag_rin_sdiv_hnac']<>$row_Recordset3['pag_rin_sdiv_hnac'] || $_POST['emp_rin_reg2_hnac']<>$row_Recordset3['emp_rin_reg2_hnac'] || $_POST['rin_eje_des3_hnac']<>$row_Recordset3['rin_eje_des3_hnac'] || $_POST['rin_eje_has3_hnac']<>$row_Recordset3['rin_eje_has3_hnac'] || $_POST['div_rin_tdes_hnac']<>$row_Recordset3['div_rin_tdes_hnac'] || $_POST['div_rin_thas_hnac']<>$row_Recordset3['div_rin_thas_hnac'] || $_POST['opc_rin_tdiv_hnac']<>$row_Recordset3['opc_rin_tdiv_hnac'] || $_POST['pag_rin_tdiv_hnac']<>$row_Recordset3['pag_rin_tdiv_hnac'] || $_POST['emp_rin_reg3_hnac']<>$row_Recordset3['emp_rin_reg3_hnac']|| $_POST['rin_eje_des4_hnac']<>$row_Recordset3['rin_eje_des4_hnac'] || $_POST['rin_eje_has4_hnac']<>$row_Recordset3['rin_eje_has4_hnac'] || $_POST['div_rin_ddes_hnac']<>$row_Recordset3['div_rin_ddes_hnac'] || $_POST['div_rin_dhas_hnac']<>$row_Recordset3['div_rin_dhas_hnac'] || $_POST['opc_rin_ddiv_hnac']<>$row_Recordset3['opc_rin_ddiv_hnac'] || $_POST['pag_rin_ddiv_hnac']<>$row_Recordset3['pag_rin_ddiv_hnac'] || $_POST['emp_rin_reg4_hnac']<>$row_Recordset3['emp_rin_reg4_hnac'] || $_POST['rin_eje_des5_hnac']<>$row_Recordset3['rin_eje_des5_hnac'] || $_POST['rin_eje_has5_hnac']<>$row_Recordset3['rin_eje_has5_hnac'] || $_POST['div_rin_qdes_hnac']<>$row_Recordset3['div_rin_qdes_hnac'] || $_POST['div_rin_qhas_hnac']<>$row_Recordset3['div_rin_qhas_hnac'] || $_POST['opc_rin_qdiv_hnac']<>$row_Recordset3['opc_rin_qdiv_hnac'] || $_POST['pag_rin_qdiv_hnac']<>$row_Recordset3['pag_rin_qdiv_hnac'] || $_POST['emp_rin_reg5_hnac']<>$row_Recordset3['emp_rin_reg5_hnac'] || $_POST['rin_eje_des6_hnac']<>$row_Recordset3['rin_eje_des6_hnac'] || $_POST['rin_eje_has6_hnac']<>$row_Recordset3['rin_eje_has6_hnac'] || $_POST['div_rin_6des_hnac']<>$row_Recordset3['div_rin_6des_hnac'] || $_POST['div_rin_6has_hnac']<>$row_Recordset3['div_rin_6has_hnac'] || $_POST['opc_rin_6div_hnac']<>$row_Recordset3['opc_rin_6div_hnac'] || $_POST['pag_rin_6div_hnac']<>$row_Recordset3['pag_rin_6div_hnac'] || $_POST['emp_rin_reg6_hnac']<>$row_Recordset3['emp_rin_reg6_hnac'] || $_POST['rin_eje_des7_hnac']<>$row_Recordset3['rin_eje_des7_hnac'] || $_POST['rin_eje_has7_hnac']<>$row_Recordset3['rin_eje_has7_hnac'] || $_POST['div_rin_7des_hnac']<>$row_Recordset3['div_rin_7des_hnac'] || $_POST['div_rin_7has_hnac']<>$row_Recordset3['div_rin_7has_hnac'] || $_POST['opc_rin_7div_hnac']<>$row_Recordset3['opc_rin_7div_hnac'] || $_POST['pag_rin_7div_hnac']<>$row_Recordset3['pag_rin_7div_hnac'] || $_POST['emp_rin_reg7_hnac']<>$row_Recordset3['emp_rin_reg7_hnac'] || $_POST['rin_eje_des8_hnac']<>$row_Recordset3['rin_eje_des8_hnac'] || $_POST['rin_eje_has8_hnac']<>$row_Recordset3['rin_eje_has8_hnac'] || $_POST['div_rin_8des_hnac']<>$row_Recordset3['div_rin_8des_hnac'] || $_POST['div_rin_8has_hnac']<>$row_Recordset3['div_rin_8has_hnac'] || $_POST['opc_rin_8div_hnac']<>$row_Recordset3['opc_rin_8div_hnac'] || $_POST['pag_rin_8div_hnac']<>$row_Recordset3['pag_rin_8div_hnac'] || $_POST['emp_rin_reg8_hnac']<>$row_Recordset3['emp_rin_reg8_hnac'] || $_POST['def_val_regdiv_hnac']<>$row_Recordset3['def_val_regdiv_hnac'] || $_POST['val_eje_des1_hnac']<>$row_Recordset3['val_eje_des1_hnac'] || $_POST['val_eje_has1_hnac']<>$row_Recordset3['val_eje_has1_hnac'] || $_POST['div_val_pdes_hnac']<>$row_Recordset3['div_val_pdes_hnac'] || $_POST['div_val_phas_hnac']<>$row_Recordset3['div_val_phas_hnac'] || $_POST['opc_val_pdiv_hnac']<>$row_Recordset3['opc_val_pdiv_hnac'] || $_POST['pag_val_pdiv_hnac']<>$row_Recordset3['pag_val_pdiv_hnac'] || $_POST['emp_val_reg1_hnac']<>$row_Recordset3['emp_val_reg1_hnac'] || $_POST['val_eje_des2_hnac']<>$row_Recordset3['val_eje_des2_hnac'] || $_POST['val_eje_has2_hnac']<>$row_Recordset3['val_eje_has2_hnac'] || $_POST['div_val_sdes_hnac']<>$row_Recordset3['div_val_sdes_hnac'] || $_POST['div_val_shas_hnac']<>$row_Recordset3['div_val_shas_hnac'] || $_POST['opc_val_sdiv_hnac']<>$row_Recordset3['opc_val_sdiv_hnac'] || $_POST['pag_val_sdiv_hnac']<>$row_Recordset3['pag_val_sdiv_hnac'] || $_POST['emp_val_reg2_hnac']<>$row_Recordset3['emp_val_reg2_hnac'] || $_POST['val_eje_des3_hnac']<>$row_Recordset3['val_eje_des3_hnac'] || $_POST['val_eje_has3_hnac']<>$row_Recordset3['val_eje_has3_hnac'] || $_POST['div_val_tdes_hnac']<>$row_Recordset3['div_val_tdes_hnac'] || $_POST['div_val_thas_hnac']<>$row_Recordset3['div_val_thas_hnac'] || $_POST['opc_val_tdiv_hnac']<>$row_Recordset3['opc_val_tdiv_hnac'] || $_POST['pag_val_tdiv_hnac']<>$row_Recordset3['pag_val_tdiv_hnac'] || $_POST['emp_val_reg3_hnac']<>$row_Recordset3['emp_val_reg3_hnac'] || $_POST['val_eje_des4_hnac']<>$row_Recordset3['val_eje_des4_hnac'] || $_POST['val_eje_has4_hnac']<>$row_Recordset3['val_eje_has4_hnac'] || $_POST['div_val_ddes_hnac']<>$row_Recordset3['div_val_ddes_hnac'] || $_POST['div_val_dhas_hnac']<>$row_Recordset3['div_val_dhas_hnac'] || $_POST['opc_val_ddiv_hnac']<>$row_Recordset3['opc_val_ddiv_hnac'] || $_POST['pag_val_ddiv_hnac']<>$row_Recordset3['pag_val_ddiv_hnac'] || $_POST['emp_val_reg4_hnac']<>$row_Recordset3['emp_val_reg4_hnac'] || $_POST['val_eje_des5_hnac']<>$row_Recordset3['val_eje_des5_hnac'] || $_POST['val_eje_has5_hnac']<>$row_Recordset3['val_eje_has5_hnac'] || $_POST['div_val_qdes_hnac']<>$row_Recordset3['div_val_qdes_hnac'] || $_POST['div_val_qhas_hnac']<>$row_Recordset3['div_val_qhas_hnac'] || $_POST['opc_val_qdiv_hnac']<>$row_Recordset3['opc_val_qdiv_hnac'] || $_POST['pag_val_qdiv_hnac']<>$row_Recordset3['pag_val_qdiv_hnac'] || $_POST['emp_val_reg5_hnac']<>$row_Recordset3['emp_val_reg5_hnac'] || $_POST['val_eje_des6_hnac']<>$row_Recordset3['val_eje_des6_hnac'] || $_POST['val_eje_has6_hnac']<>$row_Recordset3['val_eje_has6_hnac'] || $_POST['div_val_6des_hnac']<>$row_Recordset3['div_val_6des_hnac'] || $_POST['div_val_6has_hnac']<>$row_Recordset3['div_val_6has_hnac'] || $_POST['opc_val_6div_hnac']<>$row_Recordset3['opc_val_6div_hnac'] || $_POST['pag_val_6div_hnac']<>$row_Recordset3['pag_val_6div_hnac'] || $_POST['emp_val_reg6_hnac']<>$row_Recordset3['emp_val_reg6_hnac'] || $_POST['val_eje_des7_hnac']<>$row_Recordset3['val_eje_des7_hnac'] || $_POST['val_eje_has7_hnac']<>$row_Recordset3['val_eje_has7_hnac'] || $_POST['div_val_7des_hnac']<>$row_Recordset3['div_val_7des_hnac'] || $_POST['div_val_7has_hnac']<>$row_Recordset3['div_val_7has_hnac'] || $_POST['opc_val_7div_hnac']<>$row_Recordset3['opc_val_7div_hnac'] || $_POST['pag_val_7div_hnac']<>$row_Recordset3['pag_val_7div_hnac'] || $_POST['emp_val_reg7_hnac']<>$row_Recordset3['emp_val_reg7_hnac'] || $_POST['val_eje_des8_hnac']<>$row_Recordset3['val_eje_des8_hnac'] || $_POST['val_eje_has8_hnac']<>$row_Recordset3['val_eje_has8_hnac'] || $_POST['div_val_8des_hnac']<>$row_Recordset3['div_val_8des_hnac'] || $_POST['div_val_8has_hnac']<>$row_Recordset3['div_val_8has_hnac'] || $_POST['opc_val_8div_hnac']<>$row_Recordset3['opc_val_8div_hnac'] || $_POST['pag_val_8div_hnac']<>$row_Recordset3['pag_val_8div_hnac'] || $_POST['emp_val_reg8_hnac']<>$row_Recordset3['emp_val_reg8_hnac'] || $_POST['def_san_regdiv_hnac']<>$row_Recordset3['def_san_regdiv_hnac'] || $_POST['san_eje_des1_hnac']<>$row_Recordset3['san_eje_des1_hnac'] || $_POST['san_eje_has1_hnac']<>$row_Recordset3['san_eje_has1_hnac'] || $_POST['div_san_pdes_hnac']<>$row_Recordset3['div_san_pdes_hnac'] || $_POST['div_san_phas_hnac']<>$row_Recordset3['div_san_phas_hnac'] || $_POST['opc_san_pdiv_hnac']<>$row_Recordset3['opc_san_pdiv_hnac'] || $_POST['pag_san_pdiv_hnac']<>$row_Recordset3['pag_san_pdiv_hnac'] || $_POST['emp_san_reg1_hnac']<>$row_Recordset3['emp_san_reg1_hnac'] || $_POST['san_eje_des2_hnac']<>$row_Recordset3['san_eje_des2_hnac'] || $_POST['san_eje_has2_hnac']<>$row_Recordset3['san_eje_has2_hnac'] || $_POST['div_rin_sdes_hnac']<>$row_Recordset3['div_san_sdes_hnac'] || $_POST['div_san_shas_hnac']<>$row_Recordset3['div_san_shas_hnac'] || $_POST['opc_san_sdiv_hnac']<>$row_Recordset3['opc_san_sdiv_hnac'] || $_POST['pag_san_sdiv_hnac']<>$row_Recordset3['pag_san_sdiv_hnac'] || $_POST['emp_san_reg2_hnac']<>$row_Recordset3['emp_san_reg2_hnac'] || $_POST['san_eje_des3_hnac']<>$row_Recordset3['san_eje_des3_hnac'] || $_POST['san_eje_has3_hnac']<>$row_Recordset3['san_eje_has3_hnac'] || $_POST['div_san_tdes_hnac']<>$row_Recordset3['div_san_tdes_hnac'] || $_POST['div_san_thas_hnac']<>$row_Recordset3['div_san_thas_hnac'] || $_POST['opc_san_tdiv_hnac']<>$row_Recordset3['opc_san_tdiv_hnac'] || $_POST['pag_san_tdiv_hnac']<>$row_Recordset3['pag_san_tdiv_hnac'] || $_POST['emp_san_reg3_hnac']<>$row_Recordset3['emp_san_reg3_hnac'] || $_POST['san_eje_des4_hnac']<>$row_Recordset3['san_eje_des4_hnac'] || $_POST['san_eje_has4_hnac']<>$row_Recordset3['san_eje_has4_hnac'] || $_POST['div_san_ddes_hnac']<>$row_Recordset3['div_san_ddes_hnac'] || $_POST['div_san_dhas_hnac']<>$row_Recordset3['div_san_dhas_hnac'] || $_POST['opc_san_ddiv_hnac']<>$row_Recordset3['opc_san_ddiv_hnac'] || $_POST['pag_san_ddiv_hnac']<>$row_Recordset3['pag_san_ddiv_hnac'] || $_POST['emp_san_reg4_hnac']<>$row_Recordset3['emp_san_reg4_hnac'] ||$_POST['san_eje_des5_hnac']<>
            $row_Recordset3['san_eje_des5_hnac'] || $_POST['san_eje_has5_hnac']<>$row_Recordset3['san_eje_has5_hnac'] || $_POST['div_san_qdes_hnac']<>$row_Recordset3['div_san_qdes_hnac'] || $_POST['div_san_qhas_hnac']<>$row_Recordset3['div_san_qhas_hnac'] || $_POST['opc_san_qdiv_hnac']<>$row_Recordset3['opc_san_qdiv_hnac'] || $_POST['pag_san_qdiv_hnac']<>$row_Recordset3['pag_san_qdiv_hnac'] || $_POST['emp_san_reg5_hnac']<>$row_Recordset3['emp_san_reg5_hnac'] || $_POST['san_eje_des6_hnac']<>$row_Recordset3['san_eje_des6_hnac'] || $_POST['san_eje_has6_hnac']<>$row_Recordset3['san_eje_has6_hnac'] || $_POST['div_san_6des_hnac']<>$row_Recordset3['div_san_6des_hnac'] || $_POST['div_san_6has_hnac']<>$row_Recordset3['div_san_6has_hnac'] || $_POST['opc_san_6div_hnac']<>$row_Recordset3['opc_san_6div_hnac'] || $_POST['pag_san_6div_hnac']<>$row_Recordset3['pag_san_6div_hnac'] || $_POST['emp_san_reg6_hnac']<>$row_Recordset3['emp_san_reg6_hnac'] || $_POST['san_eje_des7_hnac']<>$row_Recordset3['san_eje_des7_hnac'] || $_POST['san_eje_has7_hnac']<>$row_Recordset3['san_eje_has7_hnac'] || $_POST['div_san_7des_hnac']<>$row_Recordset3['div_san_7des_hnac'] || $_POST['div_san_7has_hnac']<>$row_Recordset3['div_san_7has_hnac'] || $_POST['opc_san_7div_hnac']<>$row_Recordset3['opc_san_7div_hnac'] || $_POST['pag_san_7div_hnac']<>$row_Recordset3['pag_san_7div_hnac'] || $_POST['emp_san_reg7_hnac']<>$row_Recordset3['emp_san_reg7_hnac'] || $_POST['san_eje_des8_hnac']<>$row_Recordset3['san_eje_des8_hnac'] || $_POST['san_eje_has8_hnac']<>$row_Recordset3['san_eje_has8_hnac'] || $_POST['div_san_8des_hnac']<>$row_Recordset3['div_san_8des_hnac'] || $_POST['div_san_8has_hnac']<>$row_Recordset3['div_san_8has_hnac'] || $_POST['opc_san_8div_hnac']<>$row_Recordset3['opc_san_8div_hnac'] || $_POST['pag_san_8div_hnac']<>$row_Recordset3['pag_san_8div_hnac'] || $_POST['emp_san_reg8_hnac']<>$row_Recordset3['emp_san_reg8_hnac'] || $_POST['def_ran_regdiv_hnac']<>$row_Recordset3['def_ran_regdiv_hnac'] || $_POST['ran_eje_des1_hnac']<>$row_Recordset3['ran_eje_des1_hnac'] || $_POST['ran_eje_has1_hnac']<>$row_Recordset3['ran_eje_has1_hnac'] || $_POST['div_ran_pdes_hnac']<>$row_Recordset3['div_ran_pdes_hnac'] || $_POST['div_ran_phas_hnac']<>$row_Recordset3['div_ran_phas_hnac'] || $_POST['opc_ran_pdiv_hnac']<>$row_Recordset3['opc_ran_pdiv_hnac'] || $_POST['pag_ran_pdiv_hnac']<>$row_Recordset3['pag_ran_pdiv_hnac'] || $_POST['emp_ran_reg1_hnac']<>$row_Recordset3['emp_ran_reg1_hnac'] || $_POST['ran_eje_des2_hnac']<>$row_Recordset3['ran_eje_des2_hnac'] || $_POST['ran_eje_has2_hnac']<>$row_Recordset3['ran_eje_has2_hnac'] || $_POST['div_ran_sdes_hnac']<>$row_Recordset3['div_ran_sdes_hnac'] || $_POST['div_ran_shas_hnac']<>$row_Recordset3['div_ran_shas_hnac'] || $_POST['opc_ran_sdiv_hnac']<>$row_Recordset3['opc_ran_sdiv_hnac'] || $_POST['pag_ran_sdiv_hnac']<>$row_Recordset3['pag_ran_sdiv_hnac'] || $_POST['emp_ran_reg2_hnac']<>$row_Recordset3['emp_ran_reg2_hnac'] || $_POST['ran_eje_des3_hnac']<>$row_Recordset3['ran_eje_des3_hnac'] || $_POST['ran_eje_has3_hnac']<>$row_Recordset3['ran_eje_has3_hnac'] || $_POST['div_ran_tdes_hnac']<>$row_Recordset3['div_ran_tdes_hnac'] || $_POST['div_ran_thas_hnac']<>$row_Recordset3['div_ran_thas_hnac'] || $_POST['opc_ran_tdiv_hnac']<>$row_Recordset3['opc_ran_tdiv_hnac'] || $_POST['pag_ran_tdiv_hnac']<>$row_Recordset3['pag_ran_tdiv_hnac'] || $_POST['emp_ran_reg3_hnac']<>$row_Recordset3['emp_ran_reg3_hnac'] || $_POST['ran_eje_des4_hnac']<>$row_Recordset3['ran_eje_des4_hnac'] || $_POST['ran_eje_has4_hnac']<>$row_Recordset3['ran_eje_has4_hnac'] || $_POST['div_ran_ddes_hnac']<>$row_Recordset3['div_ran_ddes_hnac'] || $_POST['div_ran_dhas_hnac']<>$row_Recordset3['div_ran_dhas_hnac'] || $_POST['opc_ran_ddiv_hnac']<>$row_Recordset3['opc_ran_ddiv_hnac'] || $_POST['pag_ran_ddiv_hnac']<>$row_Recordset3['pag_ran_ddiv_hnac'] || $_POST['emp_ran_reg4_hnac']<>$row_Recordset3['emp_ran_reg4_hnac'] || $_POST['ran_eje_des5_hnac']<>$row_Recordset3['ran_eje_des5_hnac'] || $_POST['ran_eje_has5_hnac']<>$row_Recordset3['ran_eje_has5_hnac'] || $_POST['div_ran_qdes_hnac']<>$row_Recordset3['div_ran_qdes_hnac'] || $_POST['div_ran_qhas_hnac']<>$row_Recordset3['div_ran_qhas_hnac'] || $_POST['opc_ran_qdiv_hnac']<>$row_Recordset3['opc_ran_qdiv_hnac'] || $_POST['pag_ran_qdiv_hnac']<>$row_Recordset3['pag_ran_qdiv_hnac'] || $_POST['emp_ran_reg5_hnac']<>$row_Recordset3['emp_ran_reg5_hnac'] || $_POST['ran_eje_des6_hnac']<>$row_Recordset3['ran_eje_des6_hnac'] || $_POST['ran_eje_has6_hnac']<>$row_Recordset3['ran_eje_has6_hnac'] || $_POST['div_ran_6des_hnac']<>$row_Recordset3['div_ran_6des_hnac'] || $_POST['div_ran_6has_hnac']<>$row_Recordset3['div_ran_6has_hnac'] || $_POST['opc_ran_6div_hnac']<>$row_Recordset3['opc_ran_6div_hnac'] || $_POST['pag_ran_6div_hnac']<>$row_Recordset3['pag_ran_6div_hnac'] || $_POST['emp_ran_reg6_hnac']<>$row_Recordset3['emp_ran_reg6_hnac'] || $_POST['ran_eje_des7_hnac']<>$row_Recordset3['ran_eje_des7_hnac'] || $_POST['ran_eje_has7_hnac']<>$row_Recordset3['ran_eje_has7_hnac'] || $_POST['div_ran_7des_hnac']<>$row_Recordset3['div_ran_7des_hnac'] || $_POST['div_ran_7has_hnac']<>$row_Recordset3['div_ran_7has_hnac'] || $_POST['opc_ran_7div_hnac']<>$row_Recordset3['opc_ran_7div_hnac'] || $_POST['pag_ran_7div_hnac']<>$row_Recordset3['pag_ran_7div_hnac'] || $_POST['emp_ran_reg7_hnac']<>$row_Recordset3['emp_ran_reg7_hnac'] || $_POST['ran_eje_des8_hnac']<>$row_Recordset3['ran_eje_des8_hnac'] || $_POST['ran_eje_has8_hnac']<>$row_Recordset3['ran_eje_has8_hnac'] || $_POST['div_ran_8des_hnac']<>$row_Recordset3['div_ran_8des_hnac'] || $_POST['div_ran_8has_hnac']<>$row_Recordset3['div_ran_8has_hnac'] || $_POST['opc_ran_8div_hnac']<>$row_Recordset3['opc_ran_8div_hnac'] || $_POST['pag_ran_8div_hnac']<>$row_Recordset3['pag_ran_8div_hnac'] || $_POST['emp_ran_reg8_hnac']<>$row_Recordset3['emp_ran_reg8_hnac']) {
                //$msj=' EL ADMINISTRADOR: '.$_SESSION['MM_nom_usuario']."\n".'CAMBIO LOS PARAMTROS DE LA TAQUILLA: '.$row_Recordset1['nom_taquilla']. "\n"." QUE PERTENECE AL AGENTE AGENTE: " . $row_Recordse1['nom_agencia'] . "\n";
            
                if($_POST['redondeo_hnac']==0 && $_POST['redondeo_hnac']<>$row_Recordset3['redondeo_hnac']){
                    $msj=' SE HA DESACTIVADO EL REDONDEO NACIONAL'.' DE LA TAQUILLA '.$row_Recordset1['nom_taquilla']. "\n";
                    $msj.= "DEL AGENTE: " . $row_Recordset1['nom_agencia'] . "\n";
                }
                if($_POST['redondeo_hnac']==1 && $_POST['redondeo_hnac']<>$row_Recordset3['redondeo_hnac']){
                    $msj=' EL REDONDEO'.' DE LA TAQUILLA '.$row_Recordset1['nom_taquilla'] .' HA CAMBIADO A REDONDEO HACIA ABAJO EN NACIONALES'. "\n";
                    $msj.= "DEL AGENTE: " . $row_Recordset1['nom_agencia'] . "\n";
        
                }
                if($_POST['redondeo_hnac']==2 && $_POST['redondeo_hnac']<>$row_Recordset3['redondeo_hnac']){
                    $msj=' EL REDONDEO'.' DE LA TAQUILLA '.$row_Recordset1['nom_taquilla'] .' HA CAMBIADO A REDONDEO CONVENCIONAL EN NACIONALES'. "\n";
                    $msj.= "DEL AGENTE: " . $row_Recordset1['nom_agencia'] . "\n";
                }

               
                /*/
            if ($_POST['def_val_regdiv_hnac']<>$row_Recordset3['def_val_regdiv_hnac'] || $_POST['val_eje_des1_hnac']<>$row_Recordset3['val_eje_des1_hnac'] || $_POST['val_eje_has1_hnac']<>$row_Recordset3['val_eje_has1_hnac'] || $_POST['div_val_pdes_hnac']<>$row_Recordset3['div_val_pdes_hnac'] || $_POST['div_val_phas_hnac']<>$row_Recordset3['div_val_phas_hnac'] || $_POST['opc_val_pdiv_hnac']<>$row_Recordset3['opc_val_pdiv_hnac'] || $_POST['pag_val_pdiv_hnac']<>$row_Recordset3['pag_val_pdiv_hnac'] || $_POST['emp_val_reg1_hnac']<>$row_Recordset3['emp_val_reg1_hnac'] || $_POST['val_eje_des2_hnac']<>$row_Recordset3['val_eje_des2_hnac'] || $_POST['val_eje_has2_hnac']<>$row_Recordset3['val_eje_has2_hnac'] || $_POST['div_val_sdes_hnac']<>$row_Recordset3['div_val_sdes_hnac'] || $_POST['div_val_shas_hnac']<>$row_Recordset3['div_val_shas_hnac'] || $_POST['opc_val_sdiv_hnac']<>$row_Recordset3['opc_val_sdiv_hnac'] || $_POST['pag_val_sdiv_hnac']<>$row_Recordset3['pag_val_sdiv_hnac'] || $_POST['emp_val_reg2_hnac']<>$row_Recordset3['emp_val_reg2_hnac'] || $_POST['val_eje_des3_hnac']<>$row_Recordset3['val_eje_des3_hnac'] || $_POST['val_eje_has3_hnac']<>$row_Recordset3['val_eje_has3_hnac'] || $_POST['div_val_tdes_hnac']<>$row_Recordset3['div_val_tdes_hnac'] || $_POST['div_val_thas_hnac']<>$row_Recordset3['div_val_thas_hnac'] || $_POST['opc_val_tdiv_hnac']<>$row_Recordset3['opc_val_tdiv_hnac'] || $_POST['pag_val_tdiv_hnac']<>$row_Recordset3['pag_val_tdiv_hnac'] || $_POST['emp_val_reg3_hnac']<>$row_Recordset3['emp_val_reg3_hnac'] || $_POST['val_eje_des4_hnac']<>$row_Recordset3['val_eje_des4_hnac'] || $_POST['val_eje_has4_hnac']<>$row_Recordset3['val_eje_has4_hnac'] || $_POST['div_val_ddes_hnac']<>$row_Recordset3['div_val_ddes_hnac'] || $_POST['div_val_dhas_hnac']<>$row_Recordset3['div_val_dhas_hnac'] || $_POST['opc_val_ddiv_hnac']<>$row_Recordset3['opc_val_ddiv_hnac'] || $_POST['pag_val_ddiv_hnac']<>$row_Recordset3['pag_val_ddiv_hnac'] || $_POST['emp_val_reg4_hnac']<>$row_Recordset3['emp_val_reg4_hnac'] || $_POST['val_eje_des5_hnac']<>$row_Recordset3['val_eje_des5_hnac'] || $_POST['val_eje_has5_hnac']<>$row_Recordset3['val_eje_has5_hnac'] || $_POST['div_val_qdes_hnac']<>$row_Recordset3['div_val_qdes_hnac'] || $_POST['div_val_qhas_hnac']<>$row_Recordset3['div_val_qhas_hnac'] || $_POST['opc_val_qdiv_hnac']<>$row_Recordset3['opc_val_qdiv_hnac'] || $_POST['pag_val_qdiv_hnac']<>$row_Recordset3['pag_val_qdiv_hnac'] || $_POST['emp_val_reg5_hnac']<>$row_Recordset3['emp_val_reg5_hnac'] || $_POST['val_eje_des6_hnac']<>$row_Recordset3['val_eje_des6_hnac'] || $_POST['val_eje_has6_hnac']<>$row_Recordset3['val_eje_has6_hnac'] || $_POST['div_val_6des_hnac']<>$row_Recordset3['div_val_6des_hnac'] || $_POST['div_val_6has_hnac']<>$row_Recordset3['div_val_6has_hnac'] || $_POST['opc_val_6div_hnac']<>$row_Recordset3['opc_val_6div_hnac'] || $_POST['pag_val_6div_hnac']<>$row_Recordset3['pag_val_6div_hnac'] || $_POST['emp_val_reg6_hnac']<>$row_Recordset3['emp_val_reg6_hnac'] || $_POST['val_eje_des7_hnac']<>$row_Recordset3['val_eje_des7_hnac'] || $_POST['val_eje_has7_hnac']<>$row_Recordset3['val_eje_has7_hnac'] || $_POST['div_val_7des_hnac']<>$row_Recordset3['div_val_7des_hnac'] || $_POST['div_val_7has_hnac']<>$row_Recordset3['div_val_7has_hnac'] || $_POST['opc_val_7div_hnac']<>$row_Recordset3['opc_val_7div_hnac'] || $_POST['pag_val_7div_hnac']<>$row_Recordset3['pag_val_7div_hnac'] || $_POST['emp_val_reg7_hnac']<>$row_Recordset3['emp_val_reg7_hnac'] || $_POST['val_eje_des8_hnac']<>$row_Recordset3['val_eje_des8_hnac'] || $_POST['val_eje_has8_hnac']<>$row_Recordset3['val_eje_has8_hnac'] || $_POST['div_val_8des_hnac']<>$row_Recordset3['div_val_8des_hnac'] || $_POST['div_val_8has_hnac']<>$row_Recordset3['div_val_8has_hnac'] || $_POST['opc_val_8div_hnac']<>$row_Recordset3['opc_val_8div_hnac'] || $_POST['pag_val_8div_hnac']<>$row_Recordset3['pag_val_8div_hnac'] || $_POST['emp_val_reg8_hnac']<>$row_Recordset3['emp_val_reg8_hnac']) {
                $msj=' EL ADMINISTRADOR: '.$_SESSION['MM_nom_usuario']."\n".'CAMBIO LOS PARAMTROS DE LA TAQUILLA: '.$row_Recordset11['nom_taquilla']. "\n"." QUE PERTENECE AL AGENTE AGENTE: " . $row_Recordset11['nom_agencia'] . "\n";
/*/
                /*/$msj.= " SE HA MODIFICADO LA REGLA #1 LA RINCONADA" ."\n";

            if ($_POST['def_rin_regdiv_hnac']<>$row_Recordset3['def_rin_regdiv_hnac']) {
                $msj.= " DEFINE USO DE REGLAS PARA DIVIDENDOS ANTES ".$row_Recordset3['def_rin_regdiv_hnac']." Y DESPUES ".$_POST['def_rin_regdiv_hnac']."\n";
            }

            if ($_POST['rin_eje_des1_hnac']<>$row_Recordset3['rin_eje_des1_hnac']) {
                $msj.= " EJEMPLARES DESDE DESDE ".$row_Recordset3['rin_eje_des1_hnac']." Y DESPUES ".$_POST['rin_eje_des1_hnac']."\n";

            }

            if ($_POST['rin_eje_has1_hnac']<>$row_Recordset3['rin_eje_has1_hnac']) {
                $msj.= " EJEMPLARES DESDE HASTA ".$row_Recordset3['rin_eje_has1_hnac']." Y DESPUES ".$_POST['rin_eje_has1_hnac']."\n";

            }

            if ($_POST['div_rin_pdes_hnac']<>$row_Recordset3['div_rin_pdes_hnac']) {
                $msj.= " EJEMPLARES DESDE HASTA ".$row_Recordset3['div_rin_pdes_hnac']." Y DESPUES ".$_POST['div_rin_pdes_hnac']."\n";

            }/*/


        }/*/}/*//*/}/*/
            $msjx=utf8_encode($msj);
            $post=[
              'chat_id'=>-1001548429339,
              'text'=>$msjx,
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5155928341:AAFaxAoro6OLjtRvCMwnri0Zyfnwd-MgPdY/sendMessage");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_exec ($ch);
            curl_close ($ch);



            $Result4 = mysqli_query($conexionbanca, $updateSQL4) or die(mysqli_error($conexionbanca));
        }
        $insertGoTo = "../agente/taquillas_edit.php?recordID=".$row_Recordset1['cod_taquilla'];

        header(sprintf("Location: %s", $insertGoTo));
    }
}

$query_Recordset2 =  sprintf(
    "/* PARSEADORES1 agente_hnac\agente_taquillas_edit_hnac.php - QUERY 5 */ SELECT * FROM taquilla_opc_hnac 
	WHERE cod_taquilla = %s",
    GetSQLValueString($xCodigo, "int"),
    GetSQLValueString($_SESSION['MM_cod_agente'], "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$porcentaje=0;
if ($totalRows_Recordset2>0) {
    $existe=1;
    $porcentaje=$row_Recordset2['cob_taquilla_hnac'];
}
if ($totalRows_Recordset2==0 && (!isset($_POST["MM_insert2"]))) {
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
    $por_alquiler_hanc="1000";
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
    $redondeo_hnac=0;
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
    $menOpNac="ATENCIÓN: Los datos para Carreras Nacionales y Macuare de esta taquilla no han sido creadas";
    $existe=0;
    $porcentaje=0;

    $porcentaje=0;
    $cod_taopc_hnac="";
    $con_divid_hnac="1";
    $mod_divid_hnac="1";
    $max_jugtic_hnac="100000";
    $min_jugtic_hnac="10";
    $max_eje_hnac="500000";
    $cab_min_hnac="4";
    $top_pfav_hnac="100";
    $top_sfav_hnac="100";
    $top_tfav_hnac="100";
    $top_dem_hnac="100";
    $por_alquiler_hnac="0";
    $por_alquiler_macu="0";
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
    $ver_porpagar_hnac=1;
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
    $est_ven_san_hnac=0;
    $est_ven_ran_hnac=0;
    $tie_venta_hnac=0;
    $emp_rin_reg1_hnac=0;
    $emp_rin_reg2_hnac=0;
    $emp_rin_reg3_hnac=0;
    $emp_rin_reg4_hnac=0;
    $emp_rin_reg5_hnac=0;
    $emp_rin_reg6_hnac=0;
    $emp_rin_reg7_hnac=0;
    $emp_rin_reg8_hnac=0;
    $emp_val_reg1_hnac=0;
    $emp_val_reg2_hnac=0;
    $emp_val_reg3_hnac=0;
    $emp_val_reg4_hnac=0;
    $emp_val_reg5_hnac=0;
    $emp_val_reg6_hnac=0;
    $emp_val_reg7_hnac=0;
    $emp_val_reg8_hnac=0;
    $emp_ran_reg1_hnac=0;
    $emp_ran_reg2_hnac=0;
    $emp_ran_reg3_hnac=0;
    $emp_ran_reg4_hnac=0;
    $emp_ran_reg5_hnac=0;
    $emp_ran_reg6_hnac=0;
    $emp_ran_reg7_hnac=0;
    $emp_ran_reg8_hnac=0;
    $emp_san_reg1_hnac=0;
    $emp_san_reg2_hnac=0;
    $emp_san_reg3_hnac=0;
    $emp_san_reg4_hnac=0;
    $emp_san_reg5_hnac=0;
    $emp_san_reg6_hnac=0;
    $emp_san_reg7_hnac=0;
    $emp_san_reg8_hnac=0;
    $tip_taq_hnac=0;
    $redondeo_hnac=0;
    $pre_fijo_hnac=1;
    $tip_ticket_hnac=0;
    ///---------OPCIONES MACUARE ------------------------------
    $est_ven_macu=0;
    $est_ven_rin_macu=1;
    $est_ven_val_macu=1;
    $est_ven_san_macu=0;
    $est_ven_ran_macu=0;
    $apu_min_macu=10;
    $apu_max_macu=5000;
    $lim_max_macu=10000;
    $div_ofi_macu=1;
    $mod_div_macu=0;
    $apu_cor_macu=1;
    $apu_lar_macu=1;
    $opc_jornadai_macu=0; //opcion de jornada incompleta
    $est_tope_rin=0;
    $top_pfav_rin_hnac=100;
    $top_sfav_rin_hnac=100;
    $top_tfav_rin_hnac=100;
    $top_dem_rin_hnac=100;
    $est_tope_ran=0;
    $top_pfav_ran_hnac=100;
    $top_sfav_ran_hnac=100;
    $top_tfav_ran_hnac=100;
    $top_dem_ran_hnac=100;
    $est_tope_san=0;
    $top_pfav_san_hnac=100;
    $top_sfav_san_hnac=100;
    $top_tfav_san_hnac=100;
    $top_dem_san_hnac=100;
    $est_tope_val=0;
    $top_pfav_val_hnac=100;
    $top_sfav_val_hnac=100;
    $top_tfav_val_hnac=100;
    $top_dem_val_hnac=100;
    $menOpNac="ATENCIÓN: Los datos para Carreras Nacionales y Macuare de esta taquilla no han sido creadas";
    $existe=0;
    $porcentaje=0;
    $limit_ticket=0;
} else {
    $cod_taopc_hnac=$row_Recordset2['cod_taopc_hnac'];
    if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
        if (isset($_POST["exp_agencia"]) && $_POST["exp_agencia"]>0) {
            $r2=$totalRows_Recordset2;
            $query_Recordset2 =  sprintf(
                "/* PARSEADORES1 agente_hnac\agente_taquillas_edit_hnac.php - QUERY 6 */ SELECT * 
				FROM  
				taquilla_opc_hnac 
				WHERE 
				cod_taquilla = %s",
                GetSQLValueString($_POST["exp_agencia"], "int")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($r2==0) {
                $menOpNac="ATENCIÓN: Los datos para Carreras Nacionales y Macuare de esta taquilla no han sido creadas*";
            }
        }
    }
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
    $por_alquiler_hanc=$row_Recordset2['cob_taquilla_hnac'];
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
    $redondeo_hnac=$row_Recordset2['redondeo_hnac'];
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
    $limit_ticket=$row_Recordset2['limit_ticket'];
}
$has=50;
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 agente_hnac\agente_taquillas_edit_hnac.php - QUERY 7 */ SELECT ta.cod_taquilla, ta.nom_taquilla 
FROM taquilla ta, taquilla_opc_hnac tp, agencia ag
WHERE ta.cod_taquilla = tp.cod_taquilla AND ta.cod_taquilla != %s AND 
ag.cod_agencia = ta.cod_agencia AND ag.cod_agencia = %s
ORDER BY nom_taquilla",
    GetSQLValueString($xCodigo2, "int"),
    GetSQLValueString($_SESSION['MM_cod_agente'], "int")
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
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
 });
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana_ag.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabeceraagente_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
  </div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              EDITAR TAQUILLA<br/>
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
                <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td colspan="5" bgcolor="#0E5157" height="44" style="color:#FFF; font-size:24px; font-weight: bold;"
                      align="center">
                      DATOS DE TAQUILLA
                      </td>
                    </tr>
                    <tr>
                        <td width="1%">&nbsp;</td>
                        <td colspan="3">
                       		Nombre de taquilla:<br>
                            <div style="width:95%; text-align:left; padding:7px 0px 7px 8px; font-size:18px; background: #FFF">
                            <?php echo $row_Recordset1['nom_taquilla'];?>
                            </div>
                        </td>
						<td width="19%">Status de taquilla:<br/>
                            <select name="est_opc_hnac" style="width:auto; height: auto" class="textbox">
                            <option value="1" 
                            <?php if (!(strcmp(1, htmlentities($est_opc_hnac, ENT_COMPAT, 'utf-8')))) {
                    echo "SELECTED";
                } ?>>
                            ACTIVO
                            </option>
                            <option value="0" 
                            <?php if (!(strcmp(0, htmlentities($est_opc_hnac, ENT_COMPAT, 'utf-8')))) {
                    echo "SELECTED";
                } ?>>
                            INACTIVO
                            </option>
                            </select>
						</td>
                    </tr>
                    <tr style="font-size:16px">
                        <td>&nbsp;</td>
                        <td width="42%">
							Nombre de representante:<br />
							<input type="text" name="nom_representante" class="textbox" tabindex="2" placeholder="nombre completo"
							value="<?php echo htmlentities($row_Recordset1['nom_representante'], ENT_COMPAT, 'utf-8'); ?>" 
							size="42" title="indique un nombre de representante. 4-30 caracteres" onclick="ocultaDiv('Info2');"/>
							<div id="Info2" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
							<?php echo $menNre; ?></div>
                        </td>
                        <td width="19%">
                          Nro de contacto principal:<br />
                          <input type="text" name="tel_taquilla" class="textbox" tabindex="3"
                          size="32" pattern="[0-9]{0,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                          value="<?php echo htmlentities($row_Recordset1['tel_taquilla'], ENT_COMPAT, 'utf-8'); ?>"  
                          placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                          onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                          <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
                          <?php echo $menTel; ?></div>
                        </td>
                        <td width="19%">
                          Nro de contacto 1er auxiliar:<br />
                          <input type="text" name="tel_taquilla2" class="textbox" tabindex="4"
                          size="32" pattern="[0-9]{0,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                          value="<?php echo htmlentities($row_Recordset1['tel_taquilla2'], ENT_COMPAT, 'utf-8'); ?>"  
                          placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                          onKeyUp="return handleEnter(this, event)"/>
                        </td>
                        <td width="19%">
                          Nro de contacto 2do auxiliar:<br />
                          <input type="text" name="tel_taquilla3" class="textbox" tabindex="5"
                          size="32" pattern="[0-9]{0,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                          value="<?php echo htmlentities($row_Recordset1['tel_taquilla3'], ENT_COMPAT, 'utf-8'); ?>"  
                          placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                          onKeyUp="return handleEnter(this, event)"/>
                        </td>
                    </tr>
                    <tr>
					  <?php if ($menOpNac!="") {?>
                      <td height="33" colspan="5" align="center" valign="middle" nowrap style="background:#CC0000; color:#FFF">
                      <?php echo $menOpNac."<br/></td>";
                      } else {?>
                      <td colspan="5" align="center" nowrap></td>
                      <?php }?>
                    </tr>
                </table>
              <table width="920" align="center" cellpadding="0" cellspacing="0">
                <tr valign="baseline">
                  <?php if ($totalRows_Recordset2==0) {?>
                  <td height="82" colspan="10" align="center" valign="middle" nowrap 
                  style="background:#333333; font-size:24px; color: #FFF">
                  <?php } else {?>
                  <td height="52" colspan="10" align="center" valign="middle" nowrap 
                  style="background:#333333; font-size:24px; color: #FFF">
                  <?php }?>
                  
               	  <strong>OPCIONES DE TAQUILLA CARRERAS NACIONALES</strong>
                  </td>
                </tr>
              </table>
              <div id="nacional" style="float: left; width:auto; color: #F00;">  
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
                <td rowspan="2" align="center" valign="top" style="font-size:9px">
                    REDONDEO DE DIVIDENDO:
                  <select name="redondeo_hnac" 
                	style="width:50px; height: 41px; font-size:20px; margin:1px 0px 0px 0px" class="textbox">
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($redondeo_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>SIN REDONDEO</option>
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($redondeo_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>REDONDEO HACIA ABAJO</option>
                    <option value="2" 
					<?php if (!(strcmp(2, htmlentities($redondeo_hnac, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>REDONDEO CONVENCIONAL</option> 
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
                    <td align="center" valign="bottom">TIEMPO DE IMPRESION DE <br/>TICKETS DUPLICADOS</td>
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
                    <select name="limit_ticket" style="width:68px; height: 39px" class="textbox"> 
                      <option value="0" <?php if (!(strcmp(0, htmlentities($limit_ticket, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>5 Seg</option>
                      <option value="1" <?php if (!(strcmp(1, htmlentities($limit_ticket, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>15 Seg</option>
                     <option value="2" <?php if (!(strcmp(2, htmlentities($limit_ticket, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>30 Seg</option>
                      <option value="3" <?php if (!(strcmp(3, htmlentities($limit_ticket, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>60 Seg</option>
                      <option value="4" <?php if (!(strcmp(4, htmlentities($limit_ticket, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>120 Seg</option>                               
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
                    onkeypress="ValidaSoloNumeros()" title="indique porcentaje por alquiler"
                    onKeyUp="return handleEnter(this, event)"
                    value="<?php echo htmlentities($porcentaje, ENT_COMPAT, 'utf-8'); ?>">                    </td>
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
                  <a href='../agente/taquillas_edit.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'
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
          <input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset1['cod_taquilla']; ?>">
          <input type="hidden" name="existe" value="<?php echo $existe; ?>">
          <input type="hidden" name="cod_taopc_hnac" value="<?php echo $cod_taopc_hnac; ?>">
      </form>
    </div>
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
</div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
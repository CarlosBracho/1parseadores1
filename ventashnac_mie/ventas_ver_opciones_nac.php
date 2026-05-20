<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$idUsuario=$_SESSION['MM_id_usuario'];

$query_Recordset2 =  sprintf(
    "/* PARSEADORES1 ventashnac_mie\ventas_ver_opciones_nac.php - QUERY 1 */ SELECT *
	FROM 
		usuario us, taquilla ta, taquilla_opc_hnac tp 
	WHERE 
		us.id_usuario = %s AND
		us.cod_taquilla = ta.cod_taquilla AND
		tp.cod_taquilla = ta.cod_taquilla
	LIMIT 1",
    GetSQLValueString($idUsuario, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
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
$has=50;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<style>
body {
	background-color: #333;
	padding:0;
	margin:0 auto;
}
.textboxsmal {
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
	  width:50px;
	  height:10px;
}
.textboxsmal:focus {
	  color: #2E3133;
	  border-color: #FBFFAD;
}
 </style>

</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<div style="background: #333333; width:100%; float:left; padding:50px 2px 2px 2px;
		color:#FFF; font-size:28px; text-align:center">
		OPCIONES DE TAQUILLA
	</div><!-- end .container -->
	<div style="background: #FFF; width:100%; height:90%; float:left; font-size:18px; overflow:auto">
		<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0"
        	style="background:#0E5157;color:#FFF; font-size:10px; line-height:11px">
            <tr>
              <td width="9%" align="center" valign="top">&nbsp;</td>
              <td width="10%" align="center" valign="top">&nbsp;</td>
              <td width="10%" align="center" valign="top">&nbsp;</td>
              <td width="10%" align="center" valign="top">&nbsp;</td>
              <td width="10%" align="center" valign="top">&nbsp;</td>
              <td width="8%" align="center" valign="top">&nbsp;</td>
              <td colspan="5" align="center" valign="top" style="background:#009745;color:#000;">TOPES GLOBALES</td>
            </tr>
            <tr>
              <td align="center" valign="top">CONFIRMAR DIVIDENDO:
                <select disabled="disabled" style="width:68px; height: 39px" class="textbox">
                  <option value="1" 
                  <?php if (!(strcmp(1, htmlentities($con_divid_hnac, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>SI</option>
                  <option value="0" 
                  <?php if (!(strcmp(0, htmlentities($con_divid_hnac, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>NO</option>
              </select></td>
              <td align="center" valign="top">MODIFICA DIVIDENDOS:
                <select disabled="disabled" style="width:68px; height: 39px" class="textbox">
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
              <td align="center" valign="top">MONTO MÁXIMO EN TICKET:
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:70px; font-size:16px"
              value="<?php echo htmlentities($max_jugtic_hnac, ENT_COMPAT, 'utf-8'); ?>" >
              </td>
              <td align="center" valign="top">MONTO MÍNIMO EN TICKET:
              <input type="text" disabled="disabled" class="textboxsmal" style="height:16px; width:70px"
              value="<?php echo htmlentities($min_jugtic_hnac, ENT_COMPAT, 'utf-8'); ?>">
              </td>
              <td align="center" valign="top">MONTO MÁXIMO JUGADO A EJEMP.:
              <input type="text" disabled="disabled" class="textboxsmal" style="height:16px; width:70px; font-size:16px"
              value="<?php echo htmlentities($max_eje_hnac, ENT_COMPAT, 'utf-8'); ?>">
              </td>
              <td align="center" valign="top">EJEMP. MÍNIMOS EN CARRERA:
              <select disabled="disabled" style="width:59px; height: 39px" class="textbox">
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
              <td width="9%" align="center" valign="top" bgcolor="#009745">TOPE MÁXIMO 1er FAVORITO:
              <input type="text" disabled="disabled" class="textboxsmal" style="height:16px; width:60px; font-size:14px"
              value="<?php echo htmlentities($top_pfav_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
              </td>
              <td width="8%" align="center" valign="top" bgcolor="#009745">TOPE MÁXIMO 2do FAVORITO:
              <input type="text" disabled="disabled" class="textboxsmal" style="height:16px; width:60px; font-size:14px"
              value="<?php echo htmlentities($top_sfav_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
              </td>
              <td width="8%" align="center" valign="top" bgcolor="#009745">TOPE MÁXIMO 3er FAVORITO:
              <input type="text" disabled="disabled" class="textboxsmal" style="height:16px; width:60px; font-size:14px"
              value="<?php echo htmlentities($top_tfav_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
              </td>
              <td width="10%" colspan="2" align="center" valign="top" bgcolor="#009745">TOPE MÁXIMO AL RESTO:
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:65px; font-size:14px"
              value="<?php echo htmlentities($top_dem_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
              </td>
            </tr>
            <tr>
              <td align="center" valign="bottom">
              TICKET CADUCA:
                 <select disabled="disabled" style="width:59px; height: 39px" class="textbox" 
                  title="(0) no caduca">
                    <?php for ($i = 0; $i <= 30; $i++) {?>
                      <option value="<?php echo $i; ?>" <?php
                          if (!(strcmp($i, htmlentities($tic_caduca_hnac, ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                          } ?>><?php echo $i; ?>
                    </option>                           <?php  }?>
              </select>
              </td>
              <td colspan="2" align="center" valign="bottom">
              FORMA DE PAGAR APUESTA Y <br/>ELIMINAR TICKET:
              <select disabled="disabled" style="width:auto; height:40px" class="textbox" tabindex="4"> 
                <option value="1" <?php if (!(strcmp(1, htmlentities($pag_codigo_hnac, ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                          } ?>>SIN CÓDIGO</option>
                <option value="0" <?php if (!(strcmp(0, htmlentities($pag_codigo_hnac, ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                          } ?>>CON CÓDIGO</option>
              </select> 
              </td>
              <td align="center" valign="top" style="font-size:9px">
              ACEPTA APUESTAS<br/>HIPODROMO<br/>LA RINCONADA<br/>
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($est_ven_rin_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                              echo "checked=\"checked\"";
                          } ?> />                    
              </td>
              <td align="center" valign="top" style="font-size:9px">
              ACEPTA APUESTAS<br/>HIPODROMO<br/>VALENCIA<br/>
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($est_ven_val_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                              echo "checked=\"checked\"";
                          } ?> />                    
              </td>
              <td align="center" valign="top" style="font-size:9px">
              ACEPTA APUESTAS<br/>HIPODROMO<br/>SANTA RITA<br/>
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($est_ven_san_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                              echo "checked=\"checked\"";
                          } ?> />                    
              </td>
              <td align="center" valign="top" style="font-size:9px">
              ACEPTA APUESTAS<br/>HIPODROMO<br/>RANCHO ALEGRE<br/>
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($est_ven_ran_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                              echo "checked=\"checked\"";
                          } ?> />                    
              </td>
              <td align="center" valign="top" style="font-size:9px">
              TIPO TAQUILLA:
            <select disabled="disabled" 
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
              <td colspan="3" align="center" valign="top" style="font-size:9px;">
              VENDER CUANDO FALTEN PARA LA PARTIDA:<br/>
                <select disabled="disabled" style="width:99px;height:41px;font-size:20px;" class="textbox">
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
              <td align="center" valign="bottom">VER PREMIOS<br/>POR PAGAR</td>
              <td align="center" valign="bottom">MANEJA PRECIO FIJO</td>
              <td align="center" valign="bottom">ACEPTA  A<br/>GANADOR</td>
              <td align="center" valign="bottom">ACEPTA A<br/>PLACE</td>
              <td align="center" valign="bottom">ACEPTA<br/>EXACTAS</td>
              <td align="center" valign="bottom">ACEPTA <br/>TRIFECTAS</td>
              <td align="center" valign="bottom">ACEPTA SUPERFECTAS</td>
              <td align="center" valign="bottom">TIPO DE<br/>TICKET</td>
              <td colspan="3" align="center" valign="bottom">&nbsp;</td>
          </tr>
            <tr>
              <td align="center" valign="top">
                <select disabled="disabled" style="width:68px; height: 39px" class="textbox">
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
                <select disabled="disabled" style="width:68px; height: 39px" class="textbox">
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
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($est_gan_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                      echo "checked=\"checked\"";
                  } ?> />                    
              </td>
              <td align="center" valign="top">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($est_pla_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                      echo "checked=\"checked\"";
                  } ?> />                    
              </td>
              <td align="center" valign="top">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($est_exa_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                      echo "checked=\"checked\"";
                  } ?> />                    
              </td>
              <td align="center" valign="top">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($est_tri_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                      echo "checked=\"checked\"";
                  } ?> />                    
              </td>
              <td align="center" valign="top">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($est_sup_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                      echo "checked=\"checked\"";
                  } ?> />                    
              </td>
              <td align="center" valign="top">
              <select disabled="disabled" style="width:59px; height: 39px" class="textbox">
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
              <td align="right" valign="middle">&nbsp;
              </td>
              <td colspan="2" align="left" valign="middle">&nbsp;</td>
            </tr>
          </table>
          <table width="100%" align="center" 
				style="color:#333;font-size:11px;line-height:1" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%" bgcolor="#333" style="font-size:16px; color:#FFF"><strong>LA RINCONADA:</strong></td>
                <td width="80%" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
                    DEFINE USO DE REGLAS PARA DIVIDENDOS:&nbsp;               
                  <select disabled="disabled" 
                    style="width:70px; height: 41px; font-size:20px; margin:6px 0px 0px 0px" class="textbox">
                    <option value="1" 
                    <?php if (!(strcmp(1, htmlentities($def_rin_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>SI</option>
                    <option value="0" 
                    <?php if (!(strcmp(0, htmlentities($def_rin_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>NO</option>
                </select></td>
                </tr>
              <tr>
          </table>
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
              <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_pdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td width="97" align="center" valign="top">
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_phas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">
            <select disabled="disabled" 
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($pag_rin_pdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">                
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg1_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                    echo "checked=\"checked\"";
                } ?> />                    
            </td>
            <td>&nbsp;</td>
            <td align="center" valign="top" bgcolor="#009745">
                  <select disabled="disabled" style="width:150px; height: 39px" class="textbox">
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
              <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_sdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td width="97" align="center" valign="top">
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_shas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">
            <select disabled="disabled" 
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($pag_rin_sdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg2_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                    echo "checked=\"checked\"";
                } ?> />                    
            </td>
            <td>&nbsp;</td>
            <td align="center" valign="top" bgcolor="#009745">
                <input type="text" disabled="disabled" class="textboxsmal" 
                style="height:16px; width:60px; font-size:14px"
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
              <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_tdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td width="97" align="center" valign="top">
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_thas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">
            <select disabled="disabled" 
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($pag_rin_tdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg3_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                    echo "checked=\"checked\"";
                } ?> />                    
            </td>
            <td>&nbsp;</td>
            <td align="center" valign="top" bgcolor="#009745">
                <input type="text" disabled="disabled" class="textboxsmal" 
                style="height:16px; width:60px; font-size:14px"
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
              <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_ddes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td width="97" align="center" valign="top">
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_dhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">
            <select disabled="disabled" 
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($pag_rin_ddiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg4_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                    echo "checked=\"checked\"";
                } ?> />                    
            </td>
            <td>&nbsp;</td>
            <td align="center" valign="top" bgcolor="#009745">
                <input type="text" disabled="disabled" class="textboxsmal" 
                style="height:16px; width:60px; font-size:14px"
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
              <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px;"
            value="<?php echo htmlentities($div_rin_qdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td width="97" align="center" valign="top">
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_qhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">
            <select disabled="disabled" 
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($pag_rin_qdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg5_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                    echo "checked=\"checked\"";
                } ?> />                    
            </td>
            <td>&nbsp;</td>
            <td align="center" valign="top" bgcolor="#009745">
                <input type="text" disabled="disabled" class="textboxsmal" 
                style="height:16px; width:65px; font-size:14px"
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
              <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px;"
            value="<?php echo htmlentities($div_rin_6des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td width="97" align="center" valign="top">
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_6has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">
            <select disabled="disabled" 
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($pag_rin_6div_hnac, ENT_COMPAT, 'utf-8'); ?>">
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
              <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px;"
            value="<?php echo htmlentities($div_rin_7des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td width="97" align="center" valign="top">
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_7has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">
            <select disabled="disabled" 
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($pag_rin_7div_hnac, ENT_COMPAT, 'utf-8'); ?>">
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
              <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px;"
            value="<?php echo htmlentities($div_rin_8des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td width="97" align="center" valign="top">
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($div_rin_8has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
            </td>
            <td width="3" align="center" valign="top">&nbsp;</td>
            <td align="center" valign="top">
            <select disabled="disabled" 
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
            value="<?php echo htmlentities($pag_rin_8div_hnac, ENT_COMPAT, 'utf-8'); ?>">
            </td>
            <td align="center" valign="middle">
                <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                value=""  <?php if (!(strcmp(htmlentities($emp_rin_reg8_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                    echo "checked=\"checked\"";
                } ?> />                    
            </td>
            <td colspan="3">&nbsp;</td>
          </tr>
          </table>
          <table width="100%" align="center" style="background: #757575; color:#333;font-size:11px;line-height:11px" 
          border="0"  cellpadding="0" cellspacing="0">
          <tr>
            <td width="20%" bgcolor="#333" style="font-size:16px; color:#FFF"><strong>VALENCIA:</strong></td>
            <td width="80%" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
                DEFINE USO DE REGLAS PARA DIVIDENDOS:&nbsp;               
              <select disabled="disabled" 
                style="width:70px; height: 41px; font-size:20px; margin:6px 0px 0px 0px" class="textbox">
                <option value="1" 
                <?php if (!(strcmp(1, htmlentities($def_val_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                    echo "SELECTED";
                } ?>>SI</option>
                <option value="0" 
                <?php if (!(strcmp(0, htmlentities($def_val_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                    echo "SELECTED";
                } ?>>NO</option>
            </select></td>
          </tr>
          </table>
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
                  <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_pdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_phas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select disabled="disabled"
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
                <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($pag_val_pdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg1_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                      <select disabled="disabled" style="width:150px; height: 39px" class="textbox">
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
                  <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_sdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_shas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select disabled="disabled"
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
                <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($pag_val_sdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg2_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
                <input type="text" disabled="disabled" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
                  <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_tdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_thas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select disabled="disabled"
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
                <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($pag_val_tdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg3_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" disabled="disabled" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
                  <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_ddes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_dhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select disabled="disabled" 
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
                <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($pag_val_ddiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg4_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" disabled="disabled" class="textboxsmal" 
                    style="height:16px; width:60px; font-size:14px"
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
                  <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_qdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_qhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select disabled="disabled"
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
                <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($pag_val_qdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg5_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top" bgcolor="#009745">
					<input type="text" disabled="disabled" class="textboxsmal" 
                    style="height:16px; width:65px; font-size:14px"
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
                  <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_6des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_6has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select disabled="disabled" 
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
                <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($pag_val_6div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
                  <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_7des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_7has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select disabled="disabled" 
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
                <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($pag_val_7div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
				<select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
                  <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_8des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td width="96" align="center" valign="top">
				<input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($div_val_8has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
                </td>
                <td width="1" align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top">
				<select disabled="disabled" 
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
                <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
                value="<?php echo htmlentities($pag_val_8div_hnac, ENT_COMPAT, 'utf-8'); ?>">
                </td>
                <td align="center" valign="middle">
					<input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($emp_val_reg8_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />                    
                </td>
                <td colspan="3">&nbsp;</td>
              </tr>
		</table>
        <table width="100%" align="center" style="color:#333; font-size:11px;line-height:11px" border="0"  
        cellpadding="0" cellspacing="0">
        <tr>
          <td width="20%" bgcolor="#333" style="font-size:16px; color:#FFF"><strong>SANTA RITA:</strong></td>
          <td width="80%" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
              DEFINE USO DE REGLAS PARA DIVIDENDOS:&nbsp;               
            <select disabled="disabled" 
              style="width:70px; height: 41px; font-size:20px; margin:6px 0px 0px 0px" class="textbox">
              <option value="1" 
              <?php if (!(strcmp(1, htmlentities($def_san_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>SI</option>
              <option value="0" 
              <?php if (!(strcmp(0, htmlentities($def_san_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>NO</option>
          </select></td>
          </tr>
        </table>
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_pdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_phas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_san_pdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_san_reg1_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
                <select disabled="disabled" style="width:150px; height: 39px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_sdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_shas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_san_sdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" v class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_san_reg2_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:60px; font-size:14px"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_tdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_thas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_san_tdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_san_reg3_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:60px; font-size:14px"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_ddes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_dhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_san_ddiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_san_reg4_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:60px; font-size:14px"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_qdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_qhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_san_qdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_san_reg5_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:65px; font-size:14px"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_6des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_6has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled"
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_san_6div_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_7des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_7has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_san_7div_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_8des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_san_8has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_san_8div_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_san_reg8_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td colspan="3">&nbsp;</td>
        </tr>
        </table>
        
        <table width="100%" align="center" style="background: #757575;color:#333; font-size:11px;line-height:11px" 
        border="0"  cellpadding="0" cellspacing="0">
        <tr>
          <td width="20%" bgcolor="#333" style="font-size:16px; color:#FFF"><strong>RANCHO ALEGRE:</strong></td>
          <td width="80%" valign="middle" bgcolor="#FF9933" style="font-size:16px; color:#000">
              DEFINE USO DE REGLAS PARA DIVIDENDOS:&nbsp;               
            <select disabled="disabled" 
              style="width:70px; height: 41px; font-size:20px; margin:6px 0px 0px 0px" class="textbox">
              <option value="1" 
              <?php if (!(strcmp(1, htmlentities($def_ran_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>SI</option>
              <option value="0" 
              <?php if (!(strcmp(0, htmlentities($def_ran_regdiv_hnac, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>NO</option>
          </select></td>
          </tr>
        </table>
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_pdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_phas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_ran_pdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg1_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
                <select disabled="disabled" style="width:150px; height: 39px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
          onKeyUp="return handleEnter(this, event)"
          value="<?php echo htmlentities($div_ran_sdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          onkeypress="ValidaSoloNumeros()" title="indique dividendo de regla"
          onKeyUp="return handleEnter(this, event)"
          value="<?php echo htmlentities($div_ran_shas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_ran_sdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg2_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:60px; font-size:14px"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_tdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_thas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_ran_tdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg3_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:60px; font-size:14px"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_ddes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_dhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled" 
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_ran_ddiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg4_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:60px; font-size:14px"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_qdes_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_qhas_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled"
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_ran_qdiv_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg5_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td>&nbsp;</td>
          <td align="center" valign="top" bgcolor="#009745">
              <input type="text" disabled="disabled" class="textboxsmal" 
              style="height:16px; width:65px; font-size:14px"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_6des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_6has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled"
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_ran_6div_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_7des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_7has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled"
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_ran_7div_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
          <select disabled="disabled" style="width:59px; height: 30px" class="textbox">
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
            <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_8des_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td width="96" align="center" valign="top">
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($div_ran_8has_hnac, ENT_COMPAT, 'utf-8'); ?>">                    
          </td>
          <td width="1" align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">
          <select disabled="disabled"
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
          <input type="text" disabled="disabled" class="textboxsmal" style="height:9px; width:60px"
          value="<?php echo htmlentities($pag_ran_8div_hnac, ENT_COMPAT, 'utf-8'); ?>">
          </td>
          <td align="center" valign="middle">
              <input type="checkbox" disabled="disabled" class="textboxsmal" style="height:auto"
              value=""  <?php if (!(strcmp(htmlentities($emp_ran_reg8_hnac, ENT_COMPAT, 'utf-8'), "1"))) {
                  echo "checked=\"checked\"";
              } ?> />                    
          </td>
          <td colspan="3">&nbsp;</td>
        </tr>
        </table>
	</div>  
</body>
</html>
<?php
mysqli_free_result($Recordset2);
?>
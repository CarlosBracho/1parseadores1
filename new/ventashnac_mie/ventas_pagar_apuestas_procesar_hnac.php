<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (is_file('../includes/calculodepago_hnac.php')) {
    include("../includes/calculodepago_hnac.php");
}
$query_Recordset7 = sprintf("/* PARSEADORES1 new\ventashnac_mie\ventas_pagar_apuestas_procesar_hnac.php - QUERY 1 */ SELECT est_control_pagos_hnac FROM ctrol_ventpag_global_hnac WHERE cod_ctrol_ventpag_global_hnac =1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_pagos_hnac=$row_Recordset7['est_control_pagos_hnac'];

$xTicket_Recordset1 = "0";
$xserTic="";
$xnroTicket="";
if (isset($_POST["pagarT"])) {
    $xnroTicket = $_POST["pagarT"];
    $xTicket_Recordset1 = substr($xnroTicket, 2, strlen($xnroTicket)-2);
    $xserTic=substr($xnroTicket, 0, 2);
    $usuarioPago=$_POST["id_usuario_pago"];
}
if (isset($_GET["pagoSIN"])) {
    $xnroTicket = $_GET["pagoSIN"];
    $xTicket_Recordset1 = substr($xnroTicket, 2, strlen($xnroTicket)-2);
    $xserTic=substr($xnroTicket, 0, 2);
    $usuarioPago=$_GET["uVenta"];
    echo'<div style="background:#333;width:100%;float:left;text-align:right;padding:10px 0px 0px 0px;color:#FFF;font-size:28px; text-align:center">';
    echo'PAGO DE APUESTAS';
    echo'</div>';
}
if (!isset($_GET["pagoSIN"])) {
    echo "<hr/> <h3><strong> PAGO DE APUESTA</strong></h3>";
}
$xserDB="";
$query_Recordset2 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\ventas_pagar_apuestas_procesar_hnac.php - QUERY 2 */ SELECT venta_hnac.est_ticket_hnac, venta_hnac.ser_venta_hnac 
							 FROM venta_hnac, carrera_hnac 
							 WHERE 
							 venta_hnac.ticket_hnac = %s AND 
							 venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND 
							 est_ticket_hnac>=2",
    GetSQLValueString($xTicket_Recordset1, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
if ($totalRows_Recordset2>0) {
    $xserDB2=substr($row_Recordset2['ser_venta_hnac'], 0, 2);
} else {
    $xserDB2="";
}
if ($totalRows_Recordset2==0 && $est_control_pagos_hnac==0) {
    $query_Recordset8 = sprintf(
        "/* PARSEADORES1 new\ventashnac_mie\ventas_pagar_apuestas_procesar_hnac.php - QUERY 3 */ SELECT cod_taquilla
								 FROM usuario 
								 WHERE id_usuario = %s LIMIT 1",
        GetSQLValueString($usuarioPago, "int")
    );
    $Recordset8 = mysqli_query($conexionbanca, $query_Recordset8) or die(mysqli_error($conexionbanca));
    $row_Recordset8 = mysqli_fetch_assoc($Recordset8);
    $totalRows_Recordset8 = mysqli_num_rows($Recordset8);
    $taqVenta=$row_Recordset8['cod_taquilla'];
    //----------------------------------------
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\ventashnac_mie\ventas_pagar_apuestas_procesar_hnac.php - QUERY 4 */ SELECT 
						ve.id_usuario, ve.cod_carrera_hnac, ve.fec_venta_hnac, ve.num_ticket_hnac, ve.mon_venta_hnac,
						ve.ser_venta_hnac, ve.cod_tventa_hnac, ca.cod_carrera_hnac, ve.est_ticket_hnac, 
						ca.est_carrera_hnac, ca.est_cierre_hnac, ca.cod_hipodromo_hnac, ca.fec_carrera_hnac,
						us.cod_taquilla, tp.tic_caduca_hnac, ve.pag_premio_hnac, ca.pau_pagos_hnac,
						
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
						ve.num_caballo_hnac, tp.cab_min_hnac, ca.est_confirmacion_hnac
					FROM 
					venta_hnac ve, 
					carrera_hnac ca, 
					usuario us,
					taquilla_opc_hnac tp
					WHERE 
					ve.ticket_hnac = %s AND
					ve.id_usuario = us.id_usuario AND
					tp.cod_taquilla = us.cod_taquilla AND 
					ve.cod_carrera_hnac = ca.cod_carrera_hnac ",
        GetSQLValueString($xTicket_Recordset1, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $xVendedor=$row_Recordset1['id_usuario'];
    $xCarrera=$row_Recordset1['cod_carrera_hnac'];
    $pau_ventas_hnac=$row_Recordset1['pau_pagos_hnac'];
    if ($totalRows_Recordset1>0) {
        $xserDB=substr($row_Recordset1['ser_venta_hnac'], 0, 2);
    }
    $montoapagar=0;
    $devu=0;
    $cPr=1;
    $ctaR=0;
    $ctaG=0;
    $fec1=fechaactualbd();
    $fec2=$row_Recordset1['fec_venta_hnac'];
    $tic_caduca=$row_Recordset1['tic_caduca_hnac'];
    $diasTrancurridos=dias_transcurridos($fec1, $fec2);
    list($pre, $car, $rT)=verificarPremio_hnac($xTicket_Recordset1, $row_Recordset1['id_usuario']);
    if ($tic_caduca==0) {
        $diasTrancurridos=0;
    }
    if ((($totalRows_Recordset1>0 && $row_Recordset1['est_carrera_hnac']==0 && $xserDB==$xserTic &&
     $row_Recordset1['est_ticket_hnac']==1 && $taqVenta==$row_Recordset1['cod_taquilla'] && $diasTrancurridos<=$tic_caduca) ||
     ($diasTrancurridos<=$tic_caduca && $pre>0) && $rT>0 && $row_Recordset1['est_carrera_hnac']==1 &&
     $row_Recordset1['est_ticket_hnac']==1) && $pau_ventas_hnac==0) {
        if ($row_Recordset1['cod_hipodromo_hnac']==1) {
            $defi_regla=$row_Recordset1['def_ran_regdiv_hnac'];
        }// rancho
        if ($row_Recordset1['cod_hipodromo_hnac']==2) {
            $defi_regla=$row_Recordset1['def_san_regdiv_hnac'];
        }// santa
        if ($row_Recordset1['cod_hipodromo_hnac']==3) {
            $defi_regla=$row_Recordset1['def_val_regdiv_hnac'];
        }// valencia
        if ($row_Recordset1['cod_hipodromo_hnac']==4) {
            $defi_regla=$row_Recordset1['def_rin_regdiv_hnac'];
        }// rinconada
        
        if ($defi_regla==0) {
            $query_Recordset13 = sprintf("/* PARSEADORES1 new\ventashnac_mie\ventas_pagar_apuestas_procesar_hnac.php - QUERY 5 */ SELECT num_caballo_hnac FROM resultados_hnac WHERE 
			cod_carrera_hnac = %s", GetSQLValueString($xCarrera, "int"));
        } else {
            $query_Recordset13 = sprintf("/* PARSEADORES1 new\ventashnac_mie\ventas_pagar_apuestas_procesar_hnac.php - QUERY 6 */ SELECT num_caballo_hnac FROM resultados_oficiales_hnac WHERE 
			cod_carrera_hnac = %s", GetSQLValueString($xCarrera, "int"));
        }
        $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
        $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
        $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
        if ($totalRows_Recordset13>0 || $row_Recordset1['est_cierre_hnac']==0 || $rT>0) {
            $fecCarrera=$row_Recordset1['fec_carrera_hnac'];
            $numTicket=$row_Recordset1['num_ticket_hnac'];
            $serVenta=$row_Recordset1['ser_venta_hnac'];
            $retirados=arrayRetiradosHNAC($row_Recordset1['cod_carrera_hnac']);
            $editFormAction = $_SERVER['PHP_SELF'];
            $ipPago=getRealIP();
            $horaPago=horaactual();
            $montoapagar=0;
            $montoretiro=0;
            $i=0;
            $estado=array(0);
            $x_nTicket=array(0);
            $x_pagoSencillo=array(0);
            $cabMin=$row_Recordset1['cab_min_hnac'];
            $tEjem=enCarrera_HNAC($row_Recordset1['cod_carrera_hnac']);//ejemplares en carrera
            if ($row_Recordset1['est_cierre_hnac']!=0 && $tEjem>=$cabMin) {
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
                }
                $tope1=$row_Recordset1['top_pfav_hnac'];
                $tope2=$row_Recordset1['top_sfav_hnac'];
                $tope3=$row_Recordset1['top_tfav_hnac'];
                $tope4=$row_Recordset1['top_dem_hnac'];
                if (($pre>0 && $rT>0 && $row_Recordset1['est_carrera_hnac']==1) || ($rT==$totalRows_Recordset1)) {// devolucion completa RETIRO
                    do {
                        $montoapagar=$montoapagar+$row_Recordset1['mon_venta_hnac'];
                        $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                        $estado[$i]="4";
                        $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                        $i=$i+1;
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    $devu=1;
                } else {
                    if ($row_Recordset1['est_carrera_hnac']==0 && $totalRows_Recordset13>0) {// cerrada y con premios
                        do {
                            if ($row_Recordset1['est_calculo_hnac']==0) {//si no se ha echo el calculo
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
                                            $xCarrera,
                                            $fecCarrera,
                                            $monVenta,
                                            $taqVenta,
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
                                            $emp_regla8
                                        );
                                        if ($pago[0]>0) {
                                            $montoapagar=$pago[0]+$montoapagar;
                                            $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                                            $estado[$i]=$pago[1];
                                            $x_pagoSencillo[$i]=$pago[0];
                                            $i=$i+1;
                                            $ctaG++;
                                        }
                                    }
                                    if ($row_Recordset1['cod_tventa_hnac']>=4 && $row_Recordset1['cod_tventa_hnac']<=9) { //exo
                                    }
                                } else {
                                    $montoretiro=$montoretiro+$row_Recordset1['mon_venta_hnac'];
                                    $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                                    $estado[$i]="4";
                                    $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                                    $i=$i+1;
                                    $ctaR++;
                                }
                            } else {// si se hizo el calculo anteriormente
                                if ($row_Recordset1['est_calculo_hnac']>=2) {
                                    $montoapagar=$row_Recordset1['pag_premio_hnac']+$montoapagar;
                                    $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                                    $estado[$i]=$row_Recordset1['est_calculo_hnac'];
                                    $x_pagoSencillo[$i]=$row_Recordset1['pag_premio_hnac'];
                                    $i=$i+1;
                                }
                            }
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    } else {
                        $cPr=0;
                        echo '<h3><strong>';
                        echo 'CARRERA NO CONFIRMADA. Intente mas tarde';
                        echo '</strong></h3>';
                    }
                }
            } else {
                if ($tEjem<$cabMin || $row_Recordset1['est_cierre_hnac']==0) {
                    do {
                        $montoapagar=$montoapagar+$row_Recordset1['mon_venta_hnac'];
                        $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                        $estado[$i]="5";
                        $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                        $i=$i+1;
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    $devu=1;
                }
            }
            $montoapagar=$montoapagar+$montoretiro;
            $x=0;
            $codusuario_pago=$usuarioPago;
            $fecpago=fechaactualbd();
            if ($montoapagar>0) {
                do {
                    $updateSQL = sprintf(
                        "/* PARSEADORES1 new\ventashnac_mie\ventas_pagar_apuestas_procesar_hnac.php - QUERY 7 */ UPDATE venta_hnac 
						SET est_ticket_hnac=%s, fec_pago_hnac=%s, cod_usuario_pago_hnac=%s, 
						ip_pago_hnac=%s, hor_pago_hnac=%s, pag_premio_hnac=%s, est_calculo_hnac=%s 
						WHERE num_ticket_hnac=%s",
                        GetSQLValueString($estado[$x], "int"),
                               //GetSQLValueString(1, "int"),
                               GetSQLValueString($fecpago, "date"),
                        GetSQLValueString($codusuario_pago, "int"),
                        GetSQLValueString($ipPago, "text"),
                        GetSQLValueString($horaPago, "date"),
                        GetSQLValueString($x_pagoSencillo[$x], "double"),
                        GetSQLValueString($estado[$x], "int"),
                        GetSQLValueString($x_nTicket[$x], "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    $x++;
                } while ($x < $i);
            }
            if ($montoapagar>0) {
                echo '<font color="green"><h4><strong>';
                if ($montoapagar>0 && $devu==0 && $ctaR==0 || ($ctaG>0 && $montoapagar>0)) {
                    echo 'TICKET GANADOR';
                }
                if ((($ctaG>0 && $ctaR>0) || ($ctaG>0 && $devu>0)) && $montoapagar>0) {
                    echo ' + DEV.';
                }
                if ($montoapagar>0 && $ctaG==0 && ($devu==1 || $ctaR>0)) {
                    echo 'DEVOLUCION';
                }
                echo '</strong></h4></font>';
            }
            if ($montoapagar<=0 && $cPr==1) {
                echo '<font color="red"><h3><strong>TICKET NO GANADOR!</strong></h3></font>';
            }
            echo '<font color="red"><h3>Ticket#: '.$xTicket_Recordset1.'</h3></font>';
            if ($montoapagar>0) {
                echo '<font color="red"><strong>Monto a pagar: '.number_format($montoapagar, 2, ",", ".").'</strong></font>';
            }
        } else {
            echo '<h3><strong>';
            echo 'CARRERA NO CONFIRMADA ';
            if (($rT!=$totalRows_Recordset1 && $row_Recordset1['est_confirmacion_hnac']==0)) {
                echo "Y EL TICKET POSEE MAS DE UNA JUGADA. Intente mas tarde";
            }
            echo '</strong></h3>';
        }
    } else {
        if (!isset($_GET["pagoSIN"])) {
            if ($totalRows_Recordset1==0 || $row_Recordset1['est_ticket_hnac']==0 || $xserDB!=$xserTic) {
                echo '<h3><strong>TICKET NO ENCONTRADO!</strong></h3>';
            }
            if ($totalRows_Recordset1>0 && $row_Recordset1['est_ticket_hnac']>=2) {
                echo '<h3><strong>TICKET YA FUE PROCESADO!</strong></h3>';
            }
            if (($row_Recordset1['est_confirmacion_hnac']==0 && $row_Recordset1['est_carrera_hnac']==0 && $xserDB==$xserTic) ||
                $row_Recordset1['est_carrera_hnac']==1) {
                echo '<h4><strong>CARRERA AÚN NO CONFIRMADA1!</strong></h4>';
            }
            if ($taqVenta!=$row_Recordset1['cod_taquilla'] && $totalRows_Recordset1>0) {
                echo '<h3><strong>TICKET NO PUEDE SER <br/><br/>PAGADO POR ESTA TAQUILLA!</strong></h3>';
            }
        }
        if ($diasTrancurridos>$tic_caduca) {
            echo '<font color="red"><h3><strong>TICKET HA CADUCADO!</strong></h3></font>';
        }
        if ($pau_ventas_hnac==1) {
            echo '<h4><strong>PAGOS PAUSADOS MOMENTANEAMENTE<br/><br/>INTENTE MAS TARDE</strong></h4>';
        }
    }
} else {
    if ($est_control_pagos_hnac==1) {
        echo '<h4><strong>PAGOS PAUSADOS MOMENTANEAMENTE<br/><br/>INTENTE MAS TARDE</strong></h4>';
    } elseif (!isset($_GET["pagoSIN"])) {
        if ($totalRows_Recordset2>0) {
            echo '<h3><strong>TICKET YA FUE PROCESADO!</strong></h3>';
        }
        if ($xserDB2!=$xserTic) {
            echo '<h3><strong>TICKET NO ENCONTRADO!</strong></h3>';
        }
    }
}
echo '</font>';
if (isset($Recordset1)) {
    mysqli_free_result($Recordset1);
}
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
if (isset($Recordset13)) {
    mysqli_free_result($Recordset13);
}
if (isset($Recordset8)) {
    mysqli_free_result($Recordset8);
}

?>
<style>@charset "utf-8";body{margin:0;padding:0;font-family:Tahoma, Geneva, sans-serif;font-size:14px;color:#000;background-color:#E5E5E5;background-repeat:repeat-x;background-image:none;text-align:center}.btn-primary,.btn-primary:hover{color:#fff;text-shadow:0 -1px 0 rgba(0,0,0,0.25)}.btn-primary.active{color:rgba(255,255,255,0.75)}.btn-primary{background-color:#0074cc;*background-color:#05c;background-image:-ms-linear-gradient(top,#08c,#05c);background-repeat:repeat-x;border-color:#05c #05c #003580;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc',endColorstr='#0055cc',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}
</style>
<?php
if (isset($_GET["pagoSIN"])) {?>
	<div style="width:100%; float:left; text-align:right; padding:100px 0px 0px 0px; color:#FFF; font-size:28px; text-align:center">
		<input type="button" style="width:120px; font-size:18px; height:50px" title="volver" value="Volver" class="btn-primary" 
		onclick="location.href = '../ventashnac_mie/pag_tic_sincodigo_hnac.php?recordID=<?php echo "1";?>&uVenta=<?php echo $usuarioPago;?>'"/>	</div>
<?php } ?>
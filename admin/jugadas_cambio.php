<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio']) && $_POST['fecha_inicio']!="") {
        $in=fechaymd($_POST['fecha_inicio']);
        $inicio=$_POST['fecha_inicio'];
        if ($_POST['id_agente']!="todos" && $_POST['id_hipod']=="todos" && $_POST['id_carrera']=="todas") {
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 admin\jugadas_cambio.php - QUERY 1 */ SELECT venta.ser_venta, venta.est_calculo,
					venta.ticket, venta.ip_venta, venta.fec_venta, venta.hor_venta, venta.mon_venta, venta.cod_usuario_pago, 
					venta.pag_premio,venta.est_ticket, venta.can_ticket, taquilla_opc_ame.anu_regalia, venta.hor_pago, 
					taquilla.nom_taquilla, usuario.nom_usuario, carrera.eje_primero, carrera.eje_doble_primero,
					venta.est_ticket, carrera.est_confirmacion, venta.cod_tventa, venta.fec_pago, venta.ip_pago,
					venta.num_caballo, taquilla_opc_ame.max_aganar_gan,	taquilla_opc_ame.reg_gan, 
					carrera.est_confirmacion, carrera.num_carrera, carrera.nom_hipodromo,
					carrera.eje_triple_primero, carrera.div_primero_gan, carrera.div_primero_pla,
					carrera.div_primero_sho, carrera.div_doble_primero_gan, carrera.div_doble_primero_pla,
					carrera.div_doble_primero_sho, carrera.div_triple_primero_gan, carrera.div_triple_primero_pla,
					carrera.div_triple_primero_sho,	carrera.eje_segundo, carrera.eje_doble_segundo,
					carrera.eje_triple_segundo,	carrera.div_segundo_pla, carrera.div_segundo_sho,
					carrera.div_doble_segundo_pla, carrera.div_doble_segundo_sho, carrera.div_triple_segundo_pla,
					carrera.div_triple_segundo_sho,	carrera.eje_tercero, carrera.eje_doble_tercero,
					carrera.eje_triple_tercero, carrera.div_tercero_sho, carrera.div_doble_tercero_sho,
					carrera.div_triple_tercero_sho, agencia.nom_agencia,			taquilla_opc_ame.max_aganar_pla,
					taquilla_opc_ame.reg_pla, taquilla_opc_ame.max_aganar_sho, taquilla_opc_ame.reg_sho,
					carrera.fac_superfecta, taquilla_opc_ame.max_aganar_sup, taquilla_opc_ame.reg_sup, carrera.div_exacta, 
					carrera.ord_exacta, carrera.div_trifecta, carrera.ord_trifecta, carrera.div_superfecta,
					carrera.ord_superfecta, carrera.div_exacta_doble, carrera.ord_exacta_doble, carrera.div_trifecta_doble,
					carrera.ord_trifecta_doble, carrera.div_superfecta_doble, carrera.ord_superfecta_doble, 
					carrera.div_exacta_triple, carrera.ord_exacta_triple, div_trifecta_triple, carrera.ord_trifecta_triple, 
					carrera.div_superfecta_triple, carrera.ord_superfecta_triple, carrera.fac_trifecta, 
					taquilla_opc_ame.max_aganar_tri, taquilla_opc_ame.reg_tri, carrera.fac_exacta, 
					taquilla_opc_ame.max_aganar_exa, taquilla_opc_ame.reg_exa												
				FROM agencia, taquilla, taquilla_opc_ame, venta, usuario, carrera 
				WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND
				usuario.id_usuario = venta.id_usuario AND
				(venta.fec_venta = %s OR venta.fec_pago = %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND agencia.cod_agencia = %s 
				ORDER BY venta.fec_venta, venta.hor_venta DESC LIMIT 0,8000",
                GetSQLValueString($in, "date"),
                GetSQLValueString($in, "date"),
                GetSQLValueString($_POST['id_agente'], "int")
            );
            $est=1;
        }
        if ($_POST['id_agente']!="todos" && $_POST['id_hipod']!="todos" && $_POST['id_carrera']=="todas") {
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 admin\jugadas_cambio.php - QUERY 2 */ SELECT venta.ser_venta, venta.est_calculo,
					venta.ticket, venta.ip_venta, venta.fec_venta, venta.hor_venta, venta.mon_venta, venta.cod_usuario_pago, 
					venta.pag_premio,venta.est_ticket, venta.can_ticket, taquilla_opc_ame.anu_regalia, venta.hor_pago, 
					taquilla.nom_taquilla, usuario.nom_usuario, carrera.eje_primero, carrera.eje_doble_primero,
					venta.est_ticket, carrera.est_confirmacion, venta.cod_tventa, venta.fec_pago, venta.ip_pago,
					venta.num_caballo, taquilla_opc_ame.max_aganar_gan,	taquilla_opc_ame.reg_gan, 
					carrera.est_confirmacion, carrera.num_carrera, carrera.nom_hipodromo,
					carrera.eje_triple_primero, carrera.div_primero_gan, carrera.div_primero_pla,
					carrera.div_primero_sho, carrera.div_doble_primero_gan, carrera.div_doble_primero_pla,
					carrera.div_doble_primero_sho, carrera.div_triple_primero_gan, carrera.div_triple_primero_pla,
					carrera.div_triple_primero_sho,	carrera.eje_segundo, carrera.eje_doble_segundo,
					carrera.eje_triple_segundo,	carrera.div_segundo_pla, carrera.div_segundo_sho,
					carrera.div_doble_segundo_pla, carrera.div_doble_segundo_sho, carrera.div_triple_segundo_pla,
					carrera.div_triple_segundo_sho,	carrera.eje_tercero, carrera.eje_doble_tercero,
					carrera.eje_triple_tercero, carrera.div_tercero_sho, carrera.div_doble_tercero_sho,
					carrera.div_triple_tercero_sho, agencia.nom_agencia,			taquilla_opc_ame.max_aganar_pla,
					taquilla_opc_ame.reg_pla, taquilla_opc_ame.max_aganar_sho, taquilla_opc_ame.reg_sho,
					carrera.fac_superfecta, taquilla_opc_ame.max_aganar_sup, taquilla_opc_ame.reg_sup, carrera.div_exacta, 
					carrera.ord_exacta, carrera.div_trifecta, carrera.ord_trifecta, carrera.div_superfecta,
					carrera.ord_superfecta, carrera.div_exacta_doble, carrera.ord_exacta_doble, carrera.div_trifecta_doble,
					carrera.ord_trifecta_doble, carrera.div_superfecta_doble, carrera.ord_superfecta_doble, 
					carrera.div_exacta_triple, carrera.ord_exacta_triple, div_trifecta_triple, carrera.ord_trifecta_triple, 
					carrera.div_superfecta_triple, carrera.ord_superfecta_triple, carrera.fac_trifecta, 
					taquilla_opc_ame.max_aganar_tri, taquilla_opc_ame.reg_tri, carrera.fac_exacta, 
					taquilla_opc_ame.max_aganar_exa, taquilla_opc_ame.reg_exa												
				FROM agencia, taquilla, taquilla_opc_ame, venta, usuario, carrera 
				WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND
				usuario.id_usuario = venta.id_usuario AND
				(venta.fec_venta = %s OR venta.fec_pago = %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND agencia.cod_agencia = %s AND carrera.cod_hipodromo = %s 
				ORDER BY venta.fec_venta, venta.hor_venta DESC LIMIT 0,8000",
                GetSQLValueString($in, "date"),
                GetSQLValueString($in, "date"),
                GetSQLValueString($_POST['id_agente'], "int"),
                GetSQLValueString($_POST['id_hipod'], "int")
            );
            $est=2;
        }
        if ($_POST['id_agente']!="todos" && $_POST['id_hipod']!="todos" && $_POST['id_carrera']!="todas") {
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 admin\jugadas_cambio.php - QUERY 3 */ SELECT venta.ser_venta, venta.est_calculo,
					venta.ticket, venta.ip_venta, venta.fec_venta, venta.hor_venta, venta.mon_venta, venta.cod_usuario_pago, 
					venta.pag_premio,venta.est_ticket, venta.can_ticket, taquilla_opc_ame.anu_regalia, venta.hor_pago, 
					taquilla.nom_taquilla, usuario.nom_usuario, carrera.eje_primero, carrera.eje_doble_primero,
					venta.est_ticket, carrera.est_confirmacion, venta.cod_tventa, venta.fec_pago, venta.ip_pago,
					venta.num_caballo, taquilla_opc_ame.max_aganar_gan,	taquilla_opc_ame.reg_gan, 
					carrera.est_confirmacion, carrera.num_carrera, carrera.nom_hipodromo,
					carrera.eje_triple_primero, carrera.div_primero_gan, carrera.div_primero_pla,
					carrera.div_primero_sho, carrera.div_doble_primero_gan, carrera.div_doble_primero_pla,
					carrera.div_doble_primero_sho, carrera.div_triple_primero_gan, carrera.div_triple_primero_pla,
					carrera.div_triple_primero_sho,	carrera.eje_segundo, carrera.eje_doble_segundo,
					carrera.eje_triple_segundo,	carrera.div_segundo_pla, carrera.div_segundo_sho,
					carrera.div_doble_segundo_pla, carrera.div_doble_segundo_sho, carrera.div_triple_segundo_pla,
					carrera.div_triple_segundo_sho,	carrera.eje_tercero, carrera.eje_doble_tercero,
					carrera.eje_triple_tercero, carrera.div_tercero_sho, carrera.div_doble_tercero_sho,
					carrera.div_triple_tercero_sho, agencia.nom_agencia,			taquilla_opc_ame.max_aganar_pla,
					taquilla_opc_ame.reg_pla, taquilla_opc_ame.max_aganar_sho, taquilla_opc_ame.reg_sho,
					carrera.fac_superfecta, taquilla_opc_ame.max_aganar_sup, taquilla_opc_ame.reg_sup, carrera.div_exacta, 
					carrera.ord_exacta, carrera.div_trifecta, carrera.ord_trifecta, carrera.div_superfecta,
					carrera.ord_superfecta, carrera.div_exacta_doble, carrera.ord_exacta_doble, carrera.div_trifecta_doble,
					carrera.ord_trifecta_doble, carrera.div_superfecta_doble, carrera.ord_superfecta_doble, 
					carrera.div_exacta_triple, carrera.ord_exacta_triple, div_trifecta_triple, carrera.ord_trifecta_triple, 
					carrera.div_superfecta_triple, carrera.ord_superfecta_triple, carrera.fac_trifecta, 
					taquilla_opc_ame.max_aganar_tri, taquilla_opc_ame.reg_tri, carrera.fac_exacta, 
					taquilla_opc_ame.max_aganar_exa, taquilla_opc_ame.reg_exa												
				FROM agencia, taquilla, taquilla_opc_ame, venta, usuario, carrera 
				WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND
				usuario.id_usuario = venta.id_usuario AND
				(venta.fec_venta = %s OR venta.fec_pago = %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND agencia.cod_agencia = %s AND carrera.cod_carrera = %s 
				ORDER BY venta.fec_venta, venta.hor_venta DESC LIMIT 0,8000",
                GetSQLValueString($in, "date"),
                GetSQLValueString($in, "date"),
                GetSQLValueString($_POST['id_agente'], "int"),
                GetSQLValueString($_POST['id_carrera'], "int")
            );
            $est=3;
        }
        if ($_POST['id_agente']=="todos" && $_POST['id_hipod']!="todos" && $_POST['id_carrera']=="todas") {
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 admin\jugadas_cambio.php - QUERY 4 */ SELECT venta.ser_venta, venta.est_calculo,
					venta.ticket, venta.ip_venta, venta.fec_venta, venta.hor_venta, venta.mon_venta, venta.cod_usuario_pago, 
					venta.pag_premio,venta.est_ticket, venta.can_ticket, taquilla_opc_ame.anu_regalia, venta.hor_pago, 
					taquilla.nom_taquilla, usuario.nom_usuario, carrera.eje_primero, carrera.eje_doble_primero,
					venta.est_ticket, carrera.est_confirmacion, venta.cod_tventa, venta.fec_pago, venta.ip_pago,
					venta.num_caballo, taquilla_opc_ame.max_aganar_gan,	taquilla_opc_ame.reg_gan, 
					carrera.est_confirmacion, carrera.num_carrera, carrera.nom_hipodromo,
					carrera.eje_triple_primero, carrera.div_primero_gan, carrera.div_primero_pla,
					carrera.div_primero_sho, carrera.div_doble_primero_gan, carrera.div_doble_primero_pla,
					carrera.div_doble_primero_sho, carrera.div_triple_primero_gan, carrera.div_triple_primero_pla,
					carrera.div_triple_primero_sho,	carrera.eje_segundo, carrera.eje_doble_segundo,
					carrera.eje_triple_segundo,	carrera.div_segundo_pla, carrera.div_segundo_sho,
					carrera.div_doble_segundo_pla, carrera.div_doble_segundo_sho, carrera.div_triple_segundo_pla,
					carrera.div_triple_segundo_sho,	carrera.eje_tercero, carrera.eje_doble_tercero,
					carrera.eje_triple_tercero, carrera.div_tercero_sho, carrera.div_doble_tercero_sho,
					carrera.div_triple_tercero_sho, agencia.nom_agencia,			taquilla_opc_ame.max_aganar_pla,
					taquilla_opc_ame.reg_pla, taquilla_opc_ame.max_aganar_sho, taquilla_opc_ame.reg_sho,
					carrera.fac_superfecta, taquilla_opc_ame.max_aganar_sup, taquilla_opc_ame.reg_sup, carrera.div_exacta, 
					carrera.ord_exacta, carrera.div_trifecta, carrera.ord_trifecta, carrera.div_superfecta,
					carrera.ord_superfecta, carrera.div_exacta_doble, carrera.ord_exacta_doble, carrera.div_trifecta_doble,
					carrera.ord_trifecta_doble, carrera.div_superfecta_doble, carrera.ord_superfecta_doble, 
					carrera.div_exacta_triple, carrera.ord_exacta_triple, div_trifecta_triple, carrera.ord_trifecta_triple, 
					carrera.div_superfecta_triple, carrera.ord_superfecta_triple, carrera.fac_trifecta, 
					taquilla_opc_ame.max_aganar_tri, taquilla_opc_ame.reg_tri, carrera.fac_exacta, 
					taquilla_opc_ame.max_aganar_exa, taquilla_opc_ame.reg_exa												
				FROM agencia, taquilla, taquilla_opc_ame, venta, usuario, carrera 
				WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND
				usuario.id_usuario = venta.id_usuario AND
				(venta.fec_venta = %s OR venta.fec_pago = %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND carrera.cod_hipodromo = %s 
				ORDER BY venta.fec_venta, venta.hor_venta DESC LIMIT 0,8000",
                GetSQLValueString($in, "date"),
                GetSQLValueString($in, "date"),
                GetSQLValueString($_POST['id_hipod'], "int")
            );
            $est=4;
        }
        if ($_POST['id_agente']=="todos" && $_POST['id_hipod']!="todos" && $_POST['id_carrera']!="todas") {
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 admin\jugadas_cambio.php - QUERY 5 */ SELECT venta.ser_venta, venta.est_calculo,
					venta.ticket, venta.ip_venta, venta.fec_venta, venta.hor_venta, venta.mon_venta, venta.cod_usuario_pago, 
					venta.pag_premio,venta.est_ticket, venta.can_ticket, taquilla_opc_ame.anu_regalia, venta.hor_pago, 
					taquilla.nom_taquilla, usuario.nom_usuario, carrera.eje_primero, carrera.eje_doble_primero,
					venta.est_ticket, carrera.est_confirmacion, venta.cod_tventa, venta.fec_pago, venta.ip_pago,
					venta.num_caballo, taquilla_opc_ame.max_aganar_gan,	taquilla_opc_ame.reg_gan, 
					carrera.est_confirmacion, carrera.num_carrera, carrera.nom_hipodromo,
					carrera.eje_triple_primero, carrera.div_primero_gan, carrera.div_primero_pla,
					carrera.div_primero_sho, carrera.div_doble_primero_gan, carrera.div_doble_primero_pla,
					carrera.div_doble_primero_sho, carrera.div_triple_primero_gan, carrera.div_triple_primero_pla,
					carrera.div_triple_primero_sho,	carrera.eje_segundo, carrera.eje_doble_segundo,
					carrera.eje_triple_segundo,	carrera.div_segundo_pla, carrera.div_segundo_sho,
					carrera.div_doble_segundo_pla, carrera.div_doble_segundo_sho, carrera.div_triple_segundo_pla,
					carrera.div_triple_segundo_sho,	carrera.eje_tercero, carrera.eje_doble_tercero,
					carrera.eje_triple_tercero, carrera.div_tercero_sho, carrera.div_doble_tercero_sho,
					carrera.div_triple_tercero_sho, agencia.nom_agencia,			taquilla_opc_ame.max_aganar_pla,
					taquilla_opc_ame.reg_pla, taquilla_opc_ame.max_aganar_sho, taquilla_opc_ame.reg_sho,
					carrera.fac_superfecta, taquilla_opc_ame.max_aganar_sup, taquilla_opc_ame.reg_sup, carrera.div_exacta, 
					carrera.ord_exacta, carrera.div_trifecta, carrera.ord_trifecta, carrera.div_superfecta,
					carrera.ord_superfecta, carrera.div_exacta_doble, carrera.ord_exacta_doble, carrera.div_trifecta_doble,
					carrera.ord_trifecta_doble, carrera.div_superfecta_doble, carrera.ord_superfecta_doble, 
					carrera.div_exacta_triple, carrera.ord_exacta_triple, div_trifecta_triple, carrera.ord_trifecta_triple, 
					carrera.div_superfecta_triple, carrera.ord_superfecta_triple, carrera.fac_trifecta, 
					taquilla_opc_ame.max_aganar_tri, taquilla_opc_ame.reg_tri, carrera.fac_exacta, 
					taquilla_opc_ame.max_aganar_exa, taquilla_opc_ame.reg_exa												
				FROM agencia, taquilla, taquilla_opc_ame, venta, usuario, carrera 
				WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND
				usuario.id_usuario = venta.id_usuario AND
				(venta.fec_venta = %s OR venta.fec_pago = %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND carrera.cod_carrera = %s 
				ORDER BY venta.fec_venta, venta.hor_venta DESC LIMIT 0,8000",
                GetSQLValueString($in, "date"),
                GetSQLValueString($in, "date"),
                GetSQLValueString($_POST['id_carrera'], "int")
            );
            $est=5;
        }
    }
}
if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && $_POST['id_agente']=="todos" && $_POST['id_hipod']=="todos" && $_POST['id_carrera']=="todas") ||
    (!isset($_POST["MM_update"]))) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 admin\jugadas_cambio.php - QUERY 6 */ SELECT venta.ser_venta, venta.est_calculo,
				venta.ticket, venta.ip_venta, venta.fec_venta, venta.hor_venta, venta.mon_venta, venta.cod_usuario_pago, 
				venta.pag_premio,venta.est_ticket, venta.can_ticket, taquilla_opc_ame.anu_regalia, venta.hor_pago, 
				taquilla.nom_taquilla, usuario.nom_usuario, carrera.eje_primero, carrera.eje_doble_primero,
				venta.est_ticket, carrera.est_confirmacion, venta.cod_tventa, venta.fec_pago, venta.ip_pago,
				venta.num_caballo, taquilla_opc_ame.max_aganar_gan,	taquilla_opc_ame.reg_gan, 
				carrera.est_confirmacion, carrera.num_carrera, carrera.nom_hipodromo,
				carrera.eje_triple_primero, carrera.div_primero_gan, carrera.div_primero_pla,
				carrera.div_primero_sho, carrera.div_doble_primero_gan, carrera.div_doble_primero_pla,
				carrera.div_doble_primero_sho, carrera.div_triple_primero_gan, carrera.div_triple_primero_pla,
				carrera.div_triple_primero_sho,	carrera.eje_segundo, carrera.eje_doble_segundo,
				carrera.eje_triple_segundo,	carrera.div_segundo_pla, carrera.div_segundo_sho,
				carrera.div_doble_segundo_pla, carrera.div_doble_segundo_sho, carrera.div_triple_segundo_pla,
				carrera.div_triple_segundo_sho,	carrera.eje_tercero, carrera.eje_doble_tercero,
				carrera.eje_triple_tercero, carrera.div_tercero_sho, carrera.div_doble_tercero_sho,
				carrera.div_triple_tercero_sho, agencia.nom_agencia,			taquilla_opc_ame.max_aganar_pla,
				taquilla_opc_ame.reg_pla, taquilla_opc_ame.max_aganar_sho, taquilla_opc_ame.reg_sho,
				carrera.fac_superfecta, taquilla_opc_ame.max_aganar_sup, taquilla_opc_ame.reg_sup, carrera.div_exacta, 
				carrera.ord_exacta, carrera.div_trifecta, carrera.ord_trifecta, carrera.div_superfecta,
				carrera.ord_superfecta, carrera.div_exacta_doble, carrera.ord_exacta_doble, carrera.div_trifecta_doble,
				carrera.ord_trifecta_doble, carrera.div_superfecta_doble, carrera.ord_superfecta_doble, 
				carrera.div_exacta_triple, carrera.ord_exacta_triple, div_trifecta_triple, carrera.ord_trifecta_triple, 
				carrera.div_superfecta_triple, carrera.ord_superfecta_triple, carrera.fac_trifecta, 
				taquilla_opc_ame.max_aganar_tri, taquilla_opc_ame.reg_tri, carrera.fac_exacta, 
				taquilla_opc_ame.max_aganar_exa, taquilla_opc_ame.reg_exa												
		FROM agencia, taquilla, taquilla_opc_ame, venta, usuario, carrera 
		WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND usuario.id_usuario = venta.id_usuario AND
		(venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s AND venta.fec_pago <= %s) AND
		taquilla.cod_agencia = agencia.cod_agencia AND taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
		venta.cod_carrera = carrera.cod_carrera 
		ORDER BY venta.fec_venta, venta.hor_venta DESC LIMIT 0,8000",
        GetSQLValueString($in, "date"),
        GetSQLValueString($in, "date"),
        GetSQLValueString($in, "date"),
        GetSQLValueString($in, "date")
    );
    $est=0;
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($est==0) {
    $xagencia="TODOS";
    $vendedor="TODOS";
    $hipodromo="TODOS";
    $xcarrera="TODAS";
}
if ($est==1) {
    $xagencia=strtoupper($row_Recordset1['nom_agencia']);
    $vendedor="AGENTE: ".strtoupper($row_Recordset1['nom_agencia']);
}
if ($est==2) {
    $xagencia=strtoupper($row_Recordset1['nom_agencia']);
    $vendedor="AGENTE: ".strtoupper($row_Recordset1['nom_agencia'])." - ".strtoupper($row_Recordset1['nom_hipodromo']);
}
if ($est==3) {
    $xagencia=strtoupper($row_Recordset1['nom_agencia']);
    $vendedor="AGENTE: ".strtoupper($row_Recordset1['nom_agencia']);
    $vendedor=$vendedor." - HIPODROMO: ".strtoupper($row_Recordset1['nom_hipodromo']);
    $vendedor=$vendedor." Carr...".strtoupper($row_Recordset1['num_carrera']);
}
if ($est==4) {
    $xagencia="TODOS";
    $vendedor="AGENTE: TODOS";
    $vendedor=$vendedor." - HIPODROMO: ".strtoupper($row_Recordset1['nom_hipodromo']);
    $vendedor=$vendedor." Carr... TODAS";
}
if ($est==5) {
    $xagencia="TODOS";
    $vendedor="AGENTE: TODOS";
    $vendedor=$vendedor." - HIPODROMO: ".strtoupper($row_Recordset1['nom_hipodromo']);
    $vendedor=$vendedor." Carr...".strtoupper($row_Recordset1['num_carrera']);
    ;
}
$query_Recordset2 = "/* PARSEADORES1 admin\jugadas_cambio.php - QUERY 7 */ SELECT agencia.cod_agencia, agencia.nom_agencia FROM agencia ORDER BY agencia.nom_agencia";
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$query_Recordset3 = sprintf(
    "/* PARSEADORES1 admin\jugadas_cambio.php - QUERY 8 */ SELECT 
	cod_carrera, nom_hipodromo, num_carrera, cod_hipodromo
FROM 
	carrera
WHERE 	
	fec_carrera	= %s
GROUP BY
	cod_hipodromo
ORDER BY 
	nom_hipodromo, num_carrera ASC",
    GetSQLValueString($in, "date")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
//echo $totalRows_Recordset3;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link rel="shortcut icon" href="../images/favicon.ico">
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<style>.boton-top{display:none;position:fixed;bottom:0;right:0;width:40px;height:40px;text-align:center;line-height:40px;color:#fff;background:#F93;cursor:pointer;font-size:18px;}</style>


<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#F93"; celda.style.color="#FFFFFF"; 
	celda.style.fontWeight="bold";}  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF"; celda.style.color="#000000";
	celda.style.fontWeight="normal";} 
	function cStatus(cTic) {
		confirma = confirm('¿DESEA ELIMINAR EL TICKET# '+cTic+"? ");
		if(confirma==true){
			var rA=Math.random();
			var parametros = { "cTic":cTic, "rA":Math.random() };
			$.ajax({ data:parametros, url:'../includes/elimina_ticket.php', type:'post',
				success:function (response) { 
					$("#hipodromo").html(response);
				}
			});
			window.location='reporte_ultimasjugadas.php'; 
		}
	}
	function ver1() {
		if (document.getElementById("soflow").value!=-1) {
			alert(document.getElementById("soflow").value);
			var parametros1 = { 
				"codCarrera":$("#soflow").val(), 
				"fecCarrera":document.getElementById("dateArrival1").value};
			$.ajax({ data:parametros1, url:'ver_carrera_reporte.php', type:'post',
				success: function(opciones) {                    
					$("#div01").html(opciones);
				},
				error: function(){ 
					alert();
				}    
			});
		} else alert("Seleccione una taquilla por favor!");
	}
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#id_hipod").change(function(){
		var parametros = { 
			"cod_hipodromo":$("#id_hipod").val(), 
			"fecCarrera":document.getElementById("dateArrival1").value};
    $.ajax({
      url:"ver_carrera_reporte.php",
      type: "POST",
      data:parametros,
      success: function(opciones){
        $("#nrocarrera").html(opciones);
      }
    })
  });
});
</script>

</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
   <div style="background: #099; width:99.8%; float:left; padding:30px 2px 10px 2px;
   		color:#FFF; font-size:28px; font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; text-align:center">
        REPORTE DE LAS ÚLTIMAS 8000 JUGADAS
   </div><!-- end .container -->
   <div style="background: #FFF; width:100%; float:left; padding:5px 0px 0px 10px;
   		color:#000; font-size:20px; text-align: left; font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
       <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
            onsubmit="return chequearEnvio();">
            <table width="99%" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td width="13%" align="left" valign="bottom">
                  Fecha:<br/>
					<input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" style="width:80%; 
                    font-size:16px; height:30px" title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
                  </td>
                  <td width="17%" align="left" valign="bottom">
                    Agente:<br/>
                    <select name="id_agente" id="id_agente" style="height:40px; font-size:16px; width:99%">
                          <option value="todos" <?php if ($row_Recordset2['nom_agencia']==$xagencia) {
    echo "SELECTED";
} ?>>
                          TODOS
                          </option>
                          <?php
                    do {
                        ?>
                   <option value="<?php echo $row_Recordset2['cod_agencia']?>"
                        <?php if ($row_Recordset2['nom_agencia']==$xagencia) {
                            echo "SELECTED";
                        } ?>>
                        <?php echo strtoupper($row_Recordset2['nom_agencia'])?>
                   </option>
                          <?php
                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                    ?>
					</select>
                  </td>
                  <td width="20%" align="left" valign="bottom">
                    Hipodromo:<br/>
                    <select name="id_hipod" id="id_hipod" style="height:40px; font-size:16px; width:99%" >
                          <option value="todos">
                          TODOS
                          </option>
                          <?php
                    do {
                        ?>
                   <option value="<?php echo $row_Recordset3['cod_hipodromo']?>">
                        <?php echo strtoupper($row_Recordset3['nom_hipodromo'])?>
                   </option>
                          <?php
                    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
                    ?>
					</select>
                  </td>
                  <td width="10%" align="left" valign="bottom">
                  Carrera:<br/>
                  <select id="nrocarrera" name="id_carrera" style="height:40px; width:90%; font-size:16px">
                  <option value="todas"> TODAS</option></select>
                  </td>
                  <td width="40%" align="left" valign="bottom">
					<input type="submit" value="Buscar" class="btn-primary" title="iniciar busqueda" 
                    onClick="return enviado()" style="width:80px; height:40px"/>
                  </td>
                </tr>
              </tbody>
            </table>
                
            <input type="hidden" name="MM_update" value="form1" />
     </form>  
     
     
     
     
     
</div><!-- end .container -->
   <div id="gener" style="width:100%; float:left;">
       <div style="background: #333; width:98.3%; float:left; padding:12px 13px 12px 12px;
            color:#FFF; font-size:22px; font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif">
            <span style="float:left;"><?php echo $vendedor; ?></span>
            <span style="float:right;">FECHA: <?php echo $inicio; ?></span>
       </div>

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr style="background:#099; color:#FFF; font-size:12px; font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
        <td width="16" align="center">&nbsp;</td>
        <td width="80" align="center">Taquilla</td>
        <td width="80" align="center">Vendedor</td>
        <td width="65" align="center">Serial#</td>
        <td width="24" align="center">Nro</td>
        <td width="60" align="center">Fecha</td>
        <td width="50" align="center">Hora</td>
        <td width="182" align="center">Jugada</td>
        <td width="70" align="center">Estado</td>
        <td width="75" align="center">Monto x pagar</td>
    	<td width="75" align="center">Monto pagado</td>
        <td width="80" align="center">Vendedor pago</td>
        <td width="60" align="center">Fecha pago</td>
        <td width="50" align="center">Hora pago</td>
        <td width="65" align="center">IP Pago</td>
        <td width="15" align="center">&nbsp;</td>
      </tr>
<?php
if ($totalRows_Recordset1>0) {
                        $estado="Por definir";
                        $montoJugado=0;
                        $pagado=0;
                        $porpagar=0;
                        $totalMontoJugado=0;
                        $totalporpagar=0;
                        $totalpagado=0;
                        do {
                            $pa[0]=0;
                            $pa[1]="";
                            if ($row_Recordset1['est_ticket']==0) {
                                $estado="ELIMINADO";
                                $montoJugado=0;
                                $pagado=0;
                                $porpagar=0;
                            } else {
                                $anuReg=$row_Recordset1['anu_regalia'];
                                if ($row_Recordset1['est_ticket']==1 || $row_Recordset1['est_ticket']==3) {
                                    if ($row_Recordset1['eje_primero']<=0 && $row_Recordset1['eje_segundo']<=0 && $row_Recordset1['eje_tercero']<=0) {
                                        if ($row_Recordset1['est_calculo']==4) {
                                            $ganador=0;
                                        } else {
                                            $ganador=1;
                                        }
                                    } else {
                                        $ganador=0;
                                    }
                                    if ($ganador>0) {
                                        $estado="PENDIENTE";
                                        $montoJugado=$row_Recordset1['mon_venta'];
                                        $porpagar=0;
                                        $pagado="0";
                                    } else {
                                        if ($row_Recordset1['pag_premio']==0) {
                                            if ($row_Recordset1['cod_tventa']>=1 && $row_Recordset1['cod_tventa']<=3) {
                                                if ($row_Recordset1['cod_tventa']==1) {
                                                    $topJugada=$row_Recordset1['max_aganar_gan'];
                                                    $regalo=$row_Recordset1['reg_gan'];
                                                }
                                                if ($row_Recordset1['cod_tventa']==2) {
                                                    $topJugada=$row_Recordset1['max_aganar_pla'];
                                                    $regalo=$row_Recordset1['reg_pla'];
                                                }
                                                if ($row_Recordset1['cod_tventa']==3) {
                                                    $topJugada=$row_Recordset1['max_aganar_sho'];
                                                    $regalo=$row_Recordset1['reg_sho'];
                                                }
                                                $base=2;
                                                $pa=jNormal(
                                                    $row_Recordset1['num_caballo'],
                                                    $row_Recordset1['cod_tventa'],
                                                    $row_Recordset1['mon_venta'],
                                                    $row_Recordset1['eje_primero'],
                                                    $row_Recordset1['eje_doble_primero'],
                                                    $row_Recordset1['eje_triple_primero'],
                                                    $row_Recordset1['div_primero_gan'],
                                                    $row_Recordset1['div_primero_pla'],
                                                    $row_Recordset1['div_primero_sho'],
                                                    $row_Recordset1['div_doble_primero_gan'],
                                                    $row_Recordset1['div_doble_primero_pla'],
                                                    $row_Recordset1['div_doble_primero_sho'],
                                                    $row_Recordset1['div_triple_primero_gan'],
                                                    $row_Recordset1['div_triple_primero_pla'],
                                                    $row_Recordset1['div_triple_primero_sho'],
                                                    $row_Recordset1['eje_segundo'],
                                                    $row_Recordset1['eje_doble_segundo'],
                                                    $row_Recordset1['eje_triple_segundo'],
                                                    $row_Recordset1['div_segundo_pla'],
                                                    $row_Recordset1['div_segundo_sho'],
                                                    $row_Recordset1['div_doble_segundo_pla'],
                                                    $row_Recordset1['div_doble_segundo_sho'],
                                                    $row_Recordset1['div_triple_segundo_pla'],
                                                    $row_Recordset1['div_triple_segundo_sho'],
                                                    $row_Recordset1['eje_tercero'],
                                                    $row_Recordset1['eje_doble_tercero'],
                                                    $row_Recordset1['eje_triple_tercero'],
                                                    $row_Recordset1['div_tercero_sho'],
                                                    $row_Recordset1['div_doble_tercero_sho'],
                                                    $row_Recordset1['div_triple_tercero_sho'],
                                                    $topJugada,
                                                    $regalo,
                                                    $anuReg
                                                );
                                                $bandera=$pa[0];
                                            }
                                            if ($row_Recordset1['cod_tventa']>=4 && $row_Recordset1['cod_tventa']<=9) {
                                                if ($row_Recordset1['cod_tventa']==4 || $row_Recordset1['cod_tventa']==7) {
                                                    $fact=$row_Recordset1['fac_exacta'];
                                                    $topJugada=$row_Recordset1['max_aganar_exa'];
                                                    $regalo=$row_Recordset1['reg_exa'];
                                                }
                                                if ($row_Recordset1['cod_tventa']==5 || $row_Recordset1['cod_tventa']==8) {
                                                    $fact=$row_Recordset1['fac_trifecta'];
                                                    $topJugada=$row_Recordset1['max_aganar_tri'];
                                                    $regalo=$row_Recordset1['reg_tri'];
                                                }
                                                if ($row_Recordset1['cod_tventa']==6 || $row_Recordset1['cod_tventa']==9) {
                                                    $fact=$row_Recordset1['fac_superfecta'];
                                                    $topJugada=$row_Recordset1['max_aganar_sup'];
                                                    $regalo=$row_Recordset1['reg_sup'];
                                                }
                                                $base=2;
                                                $pa=jExotica2(
                                                    $row_Recordset1['num_caballo'],
                                                    $row_Recordset1['cod_tventa'],
                                                    $row_Recordset1['mon_venta'],
                                                    $row_Recordset1['div_exacta'],
                                                    $row_Recordset1['ord_exacta'],
                                                    $row_Recordset1['div_trifecta'],
                                                    $row_Recordset1['ord_trifecta'],
                                                    $row_Recordset1['div_superfecta'],
                                                    $row_Recordset1['ord_superfecta'],
                                                    $row_Recordset1['div_exacta_doble'],
                                                    $row_Recordset1['ord_exacta_doble'],
                                                    $row_Recordset1['div_trifecta_doble'],
                                                    $row_Recordset1['ord_trifecta_doble'],
                                                    $row_Recordset1['div_superfecta_doble'],
                                                    $row_Recordset1['ord_superfecta_doble'],
                                                    $row_Recordset1['div_exacta_triple'],
                                                    $row_Recordset1['ord_exacta_triple'],
                                                    $row_Recordset1['div_trifecta_triple'],
                                                    $row_Recordset1['ord_trifecta_triple'],
                                                    $row_Recordset1['div_superfecta_triple'],
                                                    $row_Recordset1['ord_superfecta_triple'],
                                                    $topJugada,
                                                    $regalo,
                                                    $fact,
                                                    $base
                                                );
                                                $bandera=$pa[0];
                                            }
                                        } else {
                                            $bandera=$row_Recordset1['pag_premio'];
                                        }
                                        if ($bandera>0) {
                                            if ($row_Recordset1['est_calculo']==2) {
                                                $estado="GANADOR";
                                            } elseif ($row_Recordset1['est_calculo']==4) {
                                                $estado="RETIRADO";
                                            } elseif ($row_Recordset1['est_calculo']==5) {
                                                $estado="DEVOLUCION";
                                            }
                                            if ($pa[1]=="5") {
                                                $estado="DEVOLUCION";
                                            }
                                            $montoJugado=$row_Recordset1['mon_venta'];
                                            $pagado=0;
                                            $porpagar=$bandera;
                                            $totalporpagar=$totalporpagar+$porpagar;
                                        }
                                        if ($bandera<=0) {
                                            $estado="PERDEDOR";
                                            $montoJugado=$row_Recordset1['mon_venta'];
                                            $pagado=0;
                                            $porpagar=0;
                                        }
                                    }
                                }
                                if ($row_Recordset1['est_ticket']==2) {
                                    if ($row_Recordset1['fec_pago']>=$in && $row_Recordset1['fec_pago']<=$fi) {
                                        $estado="PAGO";
                                        if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                                            $montoJugado=$row_Recordset1['mon_venta'];
                                        }
                                        if ($row_Recordset1['pag_premio']==0) {
                                            if ($row_Recordset1['cod_tventa']>=1 && $row_Recordset1['cod_tventa']<=3) {
                                                if ($row_Recordset1['cod_tventa']==1) {
                                                    $topJugada=$row_Recordset1['max_aganar_gan'];
                                                    $regalo=$row_Recordset1['reg_gan'];
                                                }
                                                if ($row_Recordset1['cod_tventa']==2) {
                                                    $topJugada=$row_Recordset1['max_aganar_pla'];
                                                    $regalo=$row_Recordset1['reg_pla'];
                                                }
                                                if ($row_Recordset1['cod_tventa']==3) {
                                                    $topJugada=$row_Recordset1['max_aganar_sho'];
                                                    $regalo=$row_Recordset1['reg_sho'];
                                                }
                                                $base=2;
                                                $pagado=jNormal(
                                                    $row_Recordset1['num_caballo'],
                                                    $row_Recordset1['cod_tventa'],
                                                    $row_Recordset1['mon_venta'],
                                                    $row_Recordset1['eje_primero'],
                                                    $row_Recordset1['eje_doble_primero'],
                                                    $row_Recordset1['eje_triple_primero'],
                                                    $row_Recordset1['div_primero_gan'],
                                                    $row_Recordset1['div_primero_pla'],
                                                    $row_Recordset1['div_primero_sho'],
                                                    $row_Recordset1['div_doble_primero_gan'],
                                                    $row_Recordset1['div_doble_primero_pla'],
                                                    $row_Recordset1['div_doble_primero_sho'],
                                                    $row_Recordset1['div_triple_primero_gan'],
                                                    $row_Recordset1['div_triple_primero_pla'],
                                                    $row_Recordset1['div_triple_primero_sho'],
                                                    $row_Recordset1['eje_segundo'],
                                                    $row_Recordset1['eje_doble_segundo'],
                                                    $row_Recordset1['eje_triple_segundo'],
                                                    $row_Recordset1['div_segundo_pla'],
                                                    $row_Recordset1['div_segundo_sho'],
                                                    $row_Recordset1['div_doble_segundo_pla'],
                                                    $row_Recordset1['div_doble_segundo_sho'],
                                                    $row_Recordset1['div_triple_segundo_pla'],
                                                    $row_Recordset1['div_triple_segundo_sho'],
                                                    $row_Recordset1['eje_tercero'],
                                                    $row_Recordset1['eje_doble_tercero'],
                                                    $row_Recordset1['eje_triple_tercero'],
                                                    $row_Recordset1['div_tercero_sho'],
                                                    $row_Recordset1['div_doble_tercero_sho'],
                                                    $row_Recordset1['div_triple_tercero_sho'],
                                                    $topJugada,
                                                    $regalo,
                                                    $anuReg
                                                );
                                            }
                                            if ($row_Recordset1['cod_tventa']>=4 && $row_Recordset1['cod_tventa']<=9) {
                                                if ($row_Recordset1['cod_tventa']==4 || $row_Recordset1['cod_tventa']==7) {
                                                    $fact=$row_Recordset1['fac_exacta'];
                                                    $topJugada=$row_Recordset1['max_aganar_exa'];
                                                    $regalo=$row_Recordset1['reg_exa'];
                                                }
                                                if ($row_Recordset1['cod_tventa']==5 || $row_Recordset1['cod_tventa']==8) {
                                                    $fact=$row_Recordset1['fac_trifecta'];
                                                    $topJugada=$row_Recordset1['max_aganar_tri'];
                                                    $regalo=$row_Recordset1['reg_tri'];
                                                }
                                                if ($row_Recordset1['cod_tventa']==6 || $row_Recordset1['cod_tventa']==9) {
                                                    $fact=$row_Recordset1['fac_superfecta'];
                                                    $topJugada=$row_Recordset1['max_aganar_sup'];
                                                    $regalo=$row_Recordset1['reg_sup'];
                                                }
                                                $base=2;
                                                $pagado=jExotica(
                                                    $row_Recordset1['num_caballo'],
                                                    $row_Recordset1['cod_tventa'],
                                                    $row_Recordset1['mon_venta'],
                                                    $row_Recordset1['eje_primero'],
                                                    $row_Recordset1['eje_doble_primero'],
                                                    $row_Recordset1['eje_triple_primero'],
                                                    $row_Recordset1['eje_segundo'],
                                                    $row_Recordset1['eje_doble_segundo'],
                                                    $row_Recordset1['eje_triple_segundo'],
                                                    $row_Recordset1['eje_tercero'],
                                                    $row_Recordset1['eje_doble_tercero'],
                                                    $row_Recordset1['eje_triple_tercero'],
                                                    $row_Recordset1['eje_cuarto'],
                                                    $row_Recordset1['eje_doble_cuarto'],
                                                    $row_Recordset1['eje_triple_cuarto'],
                                                    $row_Recordset1['div_exacta'],
                                                    $row_Recordset1['div_trifecta'],
                                                    $row_Recordset1['div_superfecta'],
                                                    $topJugada,
                                                    $regalo,
                                                    $fact,
                                                    $base
                                                );
                                            }
                                            $porpagar=0;
                                            $pagado=$pagado[0];
                                        } else {
                                            $porpagar=0;
                                            $pagado=$row_Recordset1['pag_premio'];
                                        }
                                        $totalpagado=$totalpagado+$pagado;
                                    } else {
                                        $estado="DIFERIDO";
                                        $pagado=$row_Recordset1['pag_premio'];
                                        $porpagar=0;
                                        if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                                            $montoJugado=$row_Recordset1['mon_venta'];
                                        }
                                    }
                                }
                                if ($row_Recordset1['est_ticket']==4 || $row_Recordset1['est_ticket']==5) {
                                    if ($row_Recordset1['fec_pago']>=$in && $row_Recordset1['fec_pago']<=$fi) {
                                        $estado="RETIRADO";
                                        if ($row_Recordset1['est_ticket']==5) {
                                            $estado="DEVOLUCION";
                                        }
                                        if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                                            $montoJugado=$row_Recordset1['mon_venta'];
                                        }
                                        $pagado=$row_Recordset1['mon_venta'];
                                        $porpagar=0;
                                        $totalpagado=$totalpagado+$pagado;
                                    } else {
                                        $estado="DIFERIDO";
                                        $pagado=$row_Recordset1['pag_premio'];
                                        $porpagar=0;
                                        if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                                            $montoJugado=$row_Recordset1['mon_venta'];
                                        }
                                    }
                                }
                            }
                            if ($row_Recordset1['est_ticket']!=0) {
                                if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                                    $totalMontoJugado=$totalMontoJugado+$row_Recordset1['mon_venta'];
                                }
                            }
                            $ticket2=$row_Recordset1['ticket'];
                            $serial=$row_Recordset1['ser_venta'];
                            $rest = substr($serial, 0, 2);
                            $rest = $rest.$ticket2;
                            $insertGoTo = "revistaticket.php?recordID=$ticket2"; ?> 
  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" 
  	style="font-size:12px;border-bottom:1px solid  #D5D5D5">
	<td align="center" ><a title="ver ticket: <?php echo $rest ?>" href="#" style="background:#FF0004; color:#FFFFFF" onclick="window.open('<?php echo $insertGoTo; ?>', 'Ticket', 'width=250,height=620,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes')">&nbsp;VER&nbsp;</a></td>  
    <td align="left"><?php echo $row_Recordset1['nom_taquilla']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_usuario']; ?></td>
    <td align="right"><?php echo $rest; ?></td>
    <td align="right"><?php echo $row_Recordset1['can_ticket']; ?></td>
    <td align="center" style="font-size:12px"><?php echo fechanueva($row_Recordset1['fec_venta']); ?></td>
    <td align="center" style="font-size:12px"><?php echo $row_Recordset1['hor_venta']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_hipodromo']." Carr: ...".$row_Recordset1['num_carrera']." ".$row_Recordset1['num_caballo']."-".ObtenerNombreApuesta2($row_Recordset1['cod_tventa'])."-".$row_Recordset1['mon_venta']; ?></td>
    <td align="center"><?php echo $estado; ?></td>
    <td align="right" height="25"><?php echo number_format($porpagar, 2, ",", "."); ?></td>
    <td align="right" height="25"><?php echo number_format($pagado, 2, ",", "."); ?></td>
    <?php if ($row_Recordset1['est_ticket']>=2 && $row_Recordset1['est_ticket']<=5 && $row_Recordset1['cod_usuario_pago']!=0) {?>
    <td><?php echo "&nbsp;&nbsp;&nbsp;".NombreVendedor($row_Recordset1['cod_usuario_pago']); ?></td>
    <td align="center" style="font-size:12px"><?php echo fechanueva($row_Recordset1['fec_pago']); ?></td>
    <td align="center" style="font-size:12px"><?php echo $row_Recordset1['hor_pago']; ?></td>
    <td align="left"><?php echo $row_Recordset1['ip_pago']; ?></td>
    <td align="center" >
    <?php if ($row_Recordset1['est_ticket']==1) {?>
    <a href="#" onclick="cStatus(<?php echo $rest ?>)" title="eliminar ticket"><i class="fa fa-times fa-2x"></i></a>
    <?php }?>
    </td>
    <?php } else {?>
     <td><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="left"><?php echo ""; ?></td>
    <td align="center">
    <?php if ($row_Recordset1['est_ticket']==1) {?>
    <a href="#" onclick="cStatus(<?php echo $rest ?>)" title="eliminar ticket: <?php echo $rest ?>">
    	<i class="fa fa-times fa-2x" style="color:#C00"></i>
    </a>
     <?php }?>
    </td>

    <?php } ?>
  </tr>
<?php
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    <?php
                    } else {?>
    <tr class="docepunto">
    <td colspan="17" align="left" style="font-size:18px"><strong>No existen datos</strong></td>
    </tr>
	<?php }?>  
</table>
</div>
<span class="boton-top" title="ir arriba">?</span>
</body>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});</script>
</html>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset2);
?>
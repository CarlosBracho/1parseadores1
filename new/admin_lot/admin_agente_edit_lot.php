<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A";$MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$menS="";
$menE="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1" && isset($_POST["guardarAge"]))) {
    $graba=31;
    if ($_POST['por_lot']<0) {
        $menE.="&nbsp;&nbsp;COSTO DEL SISTEMA DEBE SER MAYOR O IGUAL A CERO &nbsp;&nbsp;";
        $graba--;
    }
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 1 */ UPDATE agencia SET por_agencia_lot=%s WHERE cod_agencia=%s",
            GetSQLValueString($_POST['por_lot'], "double"),
            GetSQLValueString($_POST['cod_agenciaU'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $menS="&nbsp;&nbsp; DATOS DEL <strong>AGENTE</strong> &nbsp;&nbsp;<br/>";
        $menS.="&nbsp;&nbsp; SE GUARDARON CORRECTAMENTE &nbsp;&nbsp;";
        $menE="";
    }
}
if (isset($_POST["guardar"])) {
    $d=0;
    $cta=0;
    $graba=31;
    $top_ventaage_tri=$_POST["top_ventaage_tri"];
    $top_ventaage_ter=$_POST["top_ventaage_ter"];
    $tip_loteria=$_POST['tip_loteria'];
    $nom_loteria=$_POST['nom_loteria'];
    foreach ($_POST["idtr_agelot"] as $nom) {
        if ($top_ventaage_tri[$d]==0) {
            $menE="&nbsp;&nbsp; ".$nom_loteria[$d]." &nbsp;&nbsp;<br/>";
            $menE.="&nbsp;&nbsp;TOPE DE VENTA DEL TRIPLE DEBE SER MAYOR A CERO &nbsp;&nbsp;";
            $graba--;
            $menS="";
            break;
        }
        if ($top_ventaage_ter[$d]==0&&$tip_loteria[$d]<4) {
            $menE="&nbsp;&nbsp; ".$nom_loteria[$d]." &nbsp;&nbsp;<br/>";
            $menE.="&nbsp;&nbsp;TOPE DE VENTA DEL TERMINAL DEBE SER MAYOR A CERO &nbsp;&nbsp;";
            $graba--;
            $menS="";
            break;
        }
        $d++;
    }
    if ($graba==31) {
        $est_loteria=$_POST['est_loteria'];
        $id_ter_agelot=$_POST['idte_agelot'];
        $cta=0;
        foreach ($_POST["idtr_agelot"] as $idl) {
            if (!isset($_POST['lun'.$idl])) {
                $lun=0;
            } else {
                $lun=1;
            }
            if (!isset($_POST['mar'.$idl])) {
                $mar=0;
            } else {
                $mar=1;
            }
            if (!isset($_POST['mie'.$idl])) {
                $mie=0;
            } else {
                $mie=1;
            }
            if (!isset($_POST['jue'.$idl])) {
                $jue=0;
            } else {
                $jue=1;
            }
            if (!isset($_POST['vie'.$idl])) {
                $vie=0;
            } else {
                $vie=1;
            }
            if (!isset($_POST['sab'.$idl])) {
                $sab=0;
            } else {
                $sab=1;
            }
            if (!isset($_POST['dom'.$idl])) {
                $dom=0;
            } else {
                $dom=1;
            }
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 2 */ UPDATE agencialoterias 
					SET
					est_agelot=%s, lun_loteria=%s, mar_loteria=%s, mie_loteria=%s, jue_loteria=%s, vie_loteria=%s, sab_loteria=%s,
					dom_loteria=%s, top_ventaage=%s
					WHERE id_agelot=%s",
                GetSQLValueString($est_loteria[$cta], "int"),
                GetSQLValueString($lun, "int"),
                GetSQLValueString($mar, "int"),
                GetSQLValueString($mie, "int"),
                GetSQLValueString($jue, "int"),
                GetSQLValueString($vie, "int"),
                GetSQLValueString($sab, "int"),
                GetSQLValueString($dom, "int"),
                GetSQLValueString($top_ventaage_tri[$cta], "double"),
                GetSQLValueString($idl, "int")
            );
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            if ($tip_loteria[$cta]<4) {
                $insertSQL3 = sprintf(
                    "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 3 */ UPDATE agencialoterias 
						SET
						est_agelot=%s, lun_loteria=%s, mar_loteria=%s, mie_loteria=%s, jue_loteria=%s, vie_loteria=%s, sab_loteria=%s,
						dom_loteria=%s, top_ventaage=%s
						WHERE id_agelot=%s",
                    GetSQLValueString($est_loteria[$cta], "int"),
                    GetSQLValueString($lun, "int"),
                    GetSQLValueString($mar, "int"),
                    GetSQLValueString($mie, "int"),
                    GetSQLValueString($jue, "int"),
                    GetSQLValueString($vie, "int"),
                    GetSQLValueString($sab, "int"),
                    GetSQLValueString($dom, "int"),
                    GetSQLValueString($top_ventaage_ter[$cta], "double"),
                    GetSQLValueString($id_ter_agelot[$cta], "int")
                );
                $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
            }
            $cta++;
        }
        $menS="&nbsp;&nbsp; LOS DATOS DEL SORTEO <strong>".$_POST['sorteo']."</strong> &nbsp;&nbsp;<br/>";
        $menS.="&nbsp;&nbsp; SE GUARDARON CORRECTAMENTE &nbsp;&nbsp;";
        $menE="";
    }
}
if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
    $query_Recordset6 =  sprintf(
        "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 4 */ SELECT 
			lo.id_loteria, 
			lo.tip_loteria, 
			lo.id_triple, 
			lo.id_terminal, 
			lo.id_sorteo, 
			lo.nom_loteria, 
			bl.est_banlot, 
			bl.top_venta, 
			bl.lun_loteriabanca, 
			bl.mar_loteriabanca, 
			bl.mie_loteriabanca, 
			bl.jue_loteriabanca, 
			bl.vie_loteriabanca, 
			bl.sab_loteriabanca, 
			bl.dom_loteriabanca
		FROM 
			loterias lo, 
			sorteos so, 
			bancaloterias bl, 
			agencia ag 
		WHERE 
			lo.id_sorteo = so.id_sorteo AND 
			lo.id_loteria = bl.id_loteria AND 
			ag.cod_banca = bl.id_banca AND 
			ag.cod_agencia = %s",
        GetSQLValueString($_POST['cod_agencia'], "int")
    );
    $Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
    $row_Recordset6 = mysqli_fetch_assoc($Recordset6);
    $totalRows_Recordset6 = mysqli_num_rows($Recordset6);
    if ($totalRows_Recordset6>0) {
        $menS="&nbsp;&nbsp; OPCIONES CREADAS CORRECTAMENTE &nbsp;&nbsp;";
        $menE="";
        do {
            $query_Recordset7 =  sprintf(
                "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 5 */ SELECT id_loteria
				FROM agencialoterias 
				WHERE id_loteria = %s AND id_agencia = %s LIMIT 1",
                GetSQLValueString($row_Recordset6['id_loteria'], "int"),
                GetSQLValueString($_POST['cod_agencia'], "int")
            );
            $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
            $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
            $totalRows_Recordset7 = mysqli_num_rows($Recordset7);
            if ($totalRows_Recordset7==0) {
                $insertSQL2 = sprintf(
                    "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 6 */ INSERT 
					INTO agencialoterias
					(id_agencia, id_loteria, est_agelot, top_ventaage, lun_loteria, mar_loteria, 
					mie_loteria, jue_loteria, vie_loteria, sab_loteria, dom_loteria) 
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($_POST['cod_agencia'], "int"),
                    GetSQLValueString($row_Recordset6['id_loteria'], "int"),
                    GetSQLValueString($row_Recordset6['est_banlot'], "int"),
                    GetSQLValueString($row_Recordset6['top_venta'], "int"),
                    GetSQLValueString($row_Recordset6['lun_loteriabanca'], "int"),
                    GetSQLValueString($row_Recordset6['mar_loteriabanca'], "int"),
                    GetSQLValueString($row_Recordset6['mie_loteriabanca'], "int"),
                    GetSQLValueString($row_Recordset6['jue_loteriabanca'], "int"),
                    GetSQLValueString($row_Recordset6['vie_loteriabanca'], "int"),
                    GetSQLValueString($row_Recordset6['sab_loteriabanca'], "int"),
                    GetSQLValueString($row_Recordset6['dom_loteriabanca'], "int")
                );
                $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            }
        } while ($row_Recordset6 = mysqli_fetch_assoc($Recordset6));
    } else {
        $menE="&nbsp;&nbsp; HUBO UN ERROR INTENTE NUEVAMENTE &nbsp;&nbsp;";
        $menS="";
    }
    if (isset($Recordset6)) {
        mysqli_free_result($Recordset6);
    }
    if (isset($Recordset7)) {
        mysqli_free_result($Recordset7);
    }
}
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}

//**********************
if ((isset($_POST["MM_inserto"])) && ($_POST["MM_inserto"] == "formo") && (isset($_POST["mProcesa"]))) {
    $menS="";
    $menE="";
    if (isset($_POST["tipA"]) && $_POST["tipA"]>=0) {
        if ($_POST["tipA"]>=0 && $_POST["tipA"]<=4 && isset($_POST["od_loteria"])) {
            $loteria=implode("','", $_POST["od_loteria"]);
            $query_Recordset1 =  sprintf(
                "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 7 */ SELECT 
				al.id_agelot, lo.tip_loteria, id_agencia,
				CASE lo.tip_loteria
					WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 8 */ SELECT alo.id_agelot FROM agencialoterias alo WHERE alo.id_loteria = lo.id_terminal AND 
						ag.cod_agencia = alo.id_agencia LIMIT 1)
					WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 9 */ SELECT alo.id_agelot FROM agencialoterias alo WHERE alo.id_loteria = lo.id_terminal AND 
						ag.cod_agencia = alo.id_agencia LIMIT 1)
					ELSE 0
				END AS id_terminal	
				FROM agencia ag, agencialoterias al, loterias lo
				WHERE ag.cod_agencia = %s AND al.id_agencia = ag.cod_agencia AND lo.id_loteria = al.id_loteria AND 
				al.id_agelot IN ('$loteria')",
                GetSQLValueString($xCodigo, "int")
            );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            if ($totalRows_Recordset1>0) {
                if ($_POST["tipA"]==0) {//dias
                    if (!isset($_POST['lunA'])) {
                        $lun=0;
                    } else {
                        $lun=1;
                    }
                    if (!isset($_POST['marA'])) {
                        $mar=0;
                    } else {
                        $mar=1;
                    }
                    if (!isset($_POST['mieA'])) {
                        $mie=0;
                    } else {
                        $mie=1;
                    }
                    if (!isset($_POST['jueA'])) {
                        $jue=0;
                    } else {
                        $jue=1;
                    }
                    if (!isset($_POST['vieA'])) {
                        $vie=0;
                    } else {
                        $vie=1;
                    }
                    if (!isset($_POST['sabA'])) {
                        $sab=0;
                    } else {
                        $sab=1;
                    }
                    if (!isset($_POST['domA'])) {
                        $dom=0;
                    } else {
                        $dom=1;
                    }
                    do {
                        $insertSQL2 = sprintf(
                            "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 10 */ UPDATE agencialoterias 
							SET lun_loteria=%s, mar_loteria=%s, mie_loteria=%s, jue_loteria=%s,
								vie_loteria=%s, sab_loteria=%s, dom_loteria=%s
								WHERE id_agelot=%s",
                            GetSQLValueString($lun, "int"),
                            GetSQLValueString($mar, "int"),
                            GetSQLValueString($mie, "int"),
                            GetSQLValueString($jue, "int"),
                            GetSQLValueString($vie, "int"),
                            GetSQLValueString($sab, "int"),
                            GetSQLValueString($dom, "int"),
                            GetSQLValueString($row_Recordset1['id_agelot'], "int")
                        );
                        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        if ($row_Recordset1['tip_loteria']==1 or $row_Recordset1['tip_loteria']==3) {
                            $insertSQL2 = sprintf(
                                "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 11 */ UPDATE agencialoterias 
								SET lun_loteria=%s, mar_loteria=%s, mie_loteria=%s, jue_loteria=%s,
									vie_loteria=%s, sab_loteria=%s, dom_loteria=%s
									WHERE id_agelot=%s",
                                GetSQLValueString($lun, "int"),
                                GetSQLValueString($mar, "int"),
                                GetSQLValueString($mie, "int"),
                                GetSQLValueString($jue, "int"),
                                GetSQLValueString($vie, "int"),
                                GetSQLValueString($sab, "int"),
                                GetSQLValueString($dom, "int"),
                                GetSQLValueString($row_Recordset1['id_terminal'], "int")
                            );
                            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        }
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                } elseif ($_POST["tipA"]==1) {//estatus staA
                    do {
                        $insertSQL2 = sprintf(
                            "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 12 */ UPDATE agencialoterias SET est_agelot=%s WHERE id_agelot=%s",
                            GetSQLValueString($_POST['staA'], "int"),
                            GetSQLValueString($row_Recordset1['id_agelot'], "int")
                        );
                        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        if ($row_Recordset1['tip_loteria']==1 or $row_Recordset1['tip_loteria']==3) {
                            $insertSQL2 = sprintf(
                                "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 13 */ UPDATE agencialoterias SET est_agelot=%s WHERE id_agelot=%s",
                                GetSQLValueString($_POST['staA'], "int"),
                                GetSQLValueString($row_Recordset1['id_terminal'], "int")
                            );
                            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        }
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                } elseif ($_POST["tipA"]==2) {//tope triple toptrA
                    if ($_POST['toptrA']>0) {
                        do {
                            $insertSQL3 = sprintf(
                                "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 14 */ UPDATE agencialoterias 
								SET top_ventaage=%s
								WHERE id_agelot=%s",
                                GetSQLValueString($_POST['toptrA'], "double"),
                                GetSQLValueString($row_Recordset1['id_agelot'], "int")
                            );
                            $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    } else {
                        $menE="&nbsp;&nbsp;TOPE DE TRIPLE DEBE SER MAYOR A CERO&nbsp;<br/>DATOS NO GUARDADOS&nbsp;&nbsp;";
                    }
                } elseif ($_POST["tipA"]==3) {//tope terminal topteA
                    if ($_POST['topteA']>0) {
                        do {
                            if ($row_Recordset1['tip_loteria']==1 or $row_Recordset1['tip_loteria']==3) {
                                $insertSQL3 = sprintf(
                                    "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 15 */ UPDATE agencialoterias 
									SET top_ventaage=%s
									WHERE id_agelot=%s",
                                    GetSQLValueString($_POST['topteA'], "double"),
                                    GetSQLValueString($row_Recordset1['id_terminal'], "int")
                                );
                                $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
                            }
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    } else {
                        $menE="&nbsp;&nbsp;TOPE DE TERMINAL DEBE SER MAYOR A CERO&nbsp;<br/>DATOS NO GUARDADOS&nbsp;&nbsp;";
                    }
                }
            } else {
                $menE="&nbsp;&nbsp; ALGO SALIO MAL&nbsp;&nbsp;<br/>DATOS NO GUARDADOS&nbsp;&nbsp;";
            }
        } elseif (!isset($_POST["od_loteria"]) && ($_POST["tipA"]>=0 && $_POST["tipA"]<=4)) {
            $menE="&nbsp;&nbsp;DEBE SELECCIONAR UNA LOTERIA&nbsp;&nbsp;<br/>DATOS NO GUARDADO&nbsp;&nbsp;";
        }
    } else {
        $menE="&nbsp;&nbsp;POR FAVOR, SELECCIONE UNO DE LOS&nbsp;&nbsp;<br/>TIPOS DE ACCIONES RAPIDAS&nbsp;&nbsp;";
    }
}

//**********************
if ((isset($_POST["MM_inserto"])) && ($_POST["MM_inserto"] == "formo") && (isset($_POST["od_sorteo"]))) {
    $osorteo = implode("','", $_POST["od_sorteo"]);
    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 16 */ SELECT 
		ag.cod_agencia, ag.nom_agencia, ag.por_agencia_lot,
		al.lun_loteria, al.mar_loteria, al.mie_loteria, al.jue_loteria, al.vie_loteria, 
		al.sab_loteria, al.dom_loteria, al.id_agelot, al.est_agelot, al.top_ventaage,
		lo.nom_loteria, lo.tip_loteria, bl.id_banlot, bl.est_banlot, ba.con_tope,
		bl.hor_cierre, bl.pre_loteria,
		so.nom_sorteo,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 17 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 18 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			ELSE 0
		END AS pre_terminal,	
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 19 */ SELECT al2.id_agelot FROM agencialoterias al2 WHERE al2.id_loteria = lo.id_terminal AND 
				ag.cod_agencia = al2.id_agencia LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 20 */ SELECT al2.id_agelot FROM agencialoterias al2 WHERE al2.id_loteria = lo.id_terminal AND 
				ag.cod_agencia = al2.id_agencia LIMIT 1)
			ELSE 0
		END AS id_agelot_ter,	
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 21 */ SELECT alo.top_ventaage FROM agencialoterias alo WHERE alo.id_loteria = lo.id_terminal AND 
				ag.cod_agencia = alo.id_agencia LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 22 */ SELECT alo.top_ventaage FROM agencialoterias alo WHERE alo.id_loteria = lo.id_terminal AND 
				ag.cod_agencia = alo.id_agencia LIMIT 1)
			ELSE 0
		END top_terminal	
		FROM 
			agencia ag, 
			agencialoterias al,
			bancaloterias bl, 
			loterias lo,
			sorteos so,
			banca ba 
		WHERE 
			ag.cod_agencia = %s AND 
			ba.cod_banca = ag.cod_banca AND
			ba.cod_banca = bl.id_banca AND
			al.id_agencia = ag.cod_agencia AND 
			lo.id_loteria = al.id_loteria AND 
			lo.tip_loteria != 2 AND
			lo.id_loteria = bl.id_loteria AND 
			lo.est_loteria = 1 AND 
			lo.id_sorteo = so.id_sorteo AND 
			so.est_sorteo = 1 AND 
			bl.est_banlot = 1 AND 
			so.id_sorteo IN ('$osorteo')
		ORDER BY lo.id_sorteo ASC, let_loteria ASC",
        GetSQLValueString($xCodigo, "int")
    );
    $osorteo = $_POST["od_sorteo"];
} else {
    $osorteo=array();
    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 23 */ SELECT 
		ag.cod_agencia, ag.nom_agencia, ag.por_agencia_lot,
		al.lun_loteria, al.mar_loteria, al.mie_loteria, al.jue_loteria, al.vie_loteria, 
		al.sab_loteria, al.dom_loteria, al.id_agelot, al.est_agelot, al.top_ventaage,
		lo.nom_loteria, lo.tip_loteria, bl.id_banlot, bl.est_banlot, ba.con_tope,
		bl.hor_cierre, bl.pre_loteria,
		so.nom_sorteo,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 24 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 25 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			ELSE 0
		END AS pre_terminal,	
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 26 */ SELECT al2.id_agelot FROM agencialoterias al2 WHERE al2.id_loteria = lo.id_terminal AND 
				ag.cod_agencia = al2.id_agencia LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 27 */ SELECT al2.id_agelot FROM agencialoterias al2 WHERE al2.id_loteria = lo.id_terminal AND 
				ag.cod_agencia = al2.id_agencia LIMIT 1)
			ELSE 0
		END AS id_agelot_ter,	
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 28 */ SELECT alo.top_ventaage FROM agencialoterias alo WHERE alo.id_loteria = lo.id_terminal AND 
				ag.cod_agencia = alo.id_agencia LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 29 */ SELECT alo.top_ventaage FROM agencialoterias alo WHERE alo.id_loteria = lo.id_terminal AND 
				ag.cod_agencia = alo.id_agencia LIMIT 1)
			ELSE 0
		END top_terminal	
		FROM 
			agencia ag, 
			agencialoterias al,
			bancaloterias bl, 
			loterias lo,
			sorteos so,
			banca ba 
		WHERE 
			ag.cod_agencia = %s AND 
			ba.cod_banca = ag.cod_banca AND
			ba.cod_banca = bl.id_banca AND
			al.id_agencia = ag.cod_agencia AND 
			lo.id_loteria = al.id_loteria AND 
			lo.tip_loteria != 2 AND
			lo.id_loteria = bl.id_loteria AND 
			lo.est_loteria = 1 AND 
			lo.id_sorteo = so.id_sorteo AND 
			so.est_sorteo = 1 AND 
			bl.est_banlot = 1 
		ORDER BY lo.id_sorteo ASC, let_loteria ASC",
        GetSQLValueString($xCodigo, "int")
    );
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 30 */ SELECT 
	so.id_sorteo, so.nom_sorteo	
	FROM 
		agencia ag, 
		agencialoterias al,
		bancaloterias bl, 
		loterias lo,
		sorteos so 
	WHERE ag.cod_agencia = %s AND al.id_agencia = ag.cod_agencia AND lo.id_loteria = al.id_loteria AND lo.tip_loteria != 2 AND
		lo.id_loteria = bl.id_loteria AND lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1 AND 
		bl.est_banlot = 1
	GROUP BY so.id_sorteo	
	ORDER BY lo.nom_loteria ASC",
    GetSQLValueString($xCodigo, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$query_Recordset3 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_agente_edit_lot.php - QUERY 31 */ SELECT 
	lo.nom_loteria, al.id_agelot	
	FROM 
		agencia ag, 
		agencialoterias al,
		bancaloterias bl, 
		loterias lo
	WHERE ag.cod_agencia = %s AND al.id_agencia = ag.cod_agencia AND lo.id_loteria = al.id_loteria AND lo.tip_loteria != 2 AND
		lo.id_loteria = bl.id_loteria AND lo.est_loteria = 1 AND bl.est_banlot = 1 AND ag.cod_banca = bl.id_banca
	ORDER BY lo.id_sorteo ASC, lo.let_loteria ASC, lo.tip_loteria ASC",
    GetSQLValueString($xCodigo, "int")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
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
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #eeeeee;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script type="text/javascript" src="../admin_lot/jslot/jquery-1.9.1.min.js"></script>
 <script type="text/javascript" src="../admin_lot/jslot/bootstrap.min.js"></script>
 <script type="text/javascript" src="../admin_lot/jslot/multiselect.js"></script>

<script>
	$(document).ready(function() {
		$("#reloj").load('../includes/reloj.php?&js='+Math.random());
		var refreshId1 = setInterval(function() { $("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);
		$('#divS, #divE').fadeOut(12000);
		$('#od_sorteo, #od_loteria').multiselect({
			includeSelectAllOption: true, // add select all option as usual
			enableCaseInsensitiveFiltering: true, numberDisplayed: 3, buttonWidth: 285, maxHeight: 400,
			optionClass: function(element) {
				var value = $(element).val();
				if (value%2 == 0) { return 'odd'; }
				else { return 'even'; }
			}
		});
		$("#filtro, #mAccion").css('display','');
		$('#mAccion').click(function(e){
			if ($('.oculA').is(":hidden")){
				document.getElementById("tipA").selectedIndex = 0;
				$(".oculA").css('display','');
				$(".verA").css('display','none');
				$(".tr1").css('color', '#FFF');
				$('#mAccion').attr('title', 'ver mas opciones');
				$("#mAccion").val("+Acciones"); 
				$(".tr1").css('background', '#0084B4');
				$("#afiltro").css('display','');
				$("#aloteri, .verB").css('display','none');
			}
			else { 
				$(".oculA").css('display','none'); 
				$(".verA").css('display','');
				$("#mAccion").val("Ocultar");
				$(".tr1").css('background', '#FEFCE7');
				$(".tr1").css('color', '#333'); 
				$("#afiltro").css('display','none');
				$('#mAccion').attr('title', 'ocultar opciones');
			}
			return false;
		});
		//ptrA
		//pteA
		$('#tipA').change(function(){
		if ($('#tipA').val()==0) {
			$("#diaA").css('display','');$("#horsA, #statA, #totrA, #toteA").css('display','none');
		} else if ($('#tipA').val()==1) {
			$("#statA").css('display','');$("#diaA, #horsA, #totrA, #toteA").css('display','none');
		} else if ($('#tipA').val()==2) {
			$("#totrA").css('display','');$("#statA, #diaA, #horsA, #toteA").css('display','none');$("#toptrA").focus();
		} else if ($('#tipA').val()==3) {
			$("#toteA").css('display','');$("#statA, #diaA, #horsA, #totrA").css('display','none');$("#topteA").focus();
		} 
		else {$("#od_sorteo, #statA, #diaA, #horsA, #totrA, #toteA").css('display','none');}
		if ($('#tipA').val()>=0 && $('#tipA').val()<=4) {$("#afiltro").css('display','none');$("#aloteri").css('display','');} 
		else { if ($('#tipA').val()>=0) { $("#afiltro").css('display','');$("#aloteri").css('display','none');}
		else {$("#afiltro, #aloteri").css('display','none');}}
		});	
	});
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true; return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false; }
}
function ValidaSoloNumeros(){if (event.keyCode!=46){if ((event.keyCode<48) || (event.keyCode>57)) event.returnValue=false;}} 
function dtcambio(cambio, guarda) {
	if (document.getElementById(cambio).value==1) {	document.getElementById(cambio).value=0;
		document.getElementById(guarda).disabled=true; document.getElementById(guarda).style.display = 'none';}
	else { document.getElementById(cambio).value=1;document.getElementById(guarda).disabled=false; 
		document.getElementById(guarda).style.display = '';}
	
}
function handleEnter (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	} 
	else
	return true;
} 
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<div class="container">
		<div class="header" style="height:100px; background:#0084B4">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_lot.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
        	id="datosUsuario">
        	<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            	margin:20px 0px 0px 0px; width:240px; font-size:16px"> 
              EDITAR AGENTE<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
		<div class="contentAdmin">
            <div style="padding:5px 0px; float:right; color:#FFFFFF;background: #58D98F;font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divS">
                <?php echo $menS; ?>
            </div>
            <div style="padding:5px 0px; float:right; color:#FFFFFF;background:#FF9A9C;font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divE">
                <?php echo $menE; ?>   
            </div>
			<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto"><?php
                if ($totalRows_Recordset1>0) {?>
				<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
				  <form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();" style="margin:0">
						<table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr valign="baseline">
								<td height="52" colspan="10" align="center" valign="middle" nowrap 
									style="background:#333333; font-size:24px; color: #FFF">
									<strong>DATOS Y OPCIONES DE AGENTE</strong>
								</td>
							</tr>
						</table>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr class="oculA">
								<td height="35" align="center" colspan="3" style="font-size:10px;">
                                	Nombre de Agente:<br />
                                    <?php echo '<font size="5">--- '.$row_Recordset1['nom_agencia'].' ---</font>'; ?>
                                </td>
								<td width="35%" align="center" height="30">
                                    <?php
                                        echo '<font size="2" color="red">';
                                        echo "<strong>NOTA:</strong><br/>";
                                        echo "Control de topes de ventas de triples<br/>y terminales estan activos";
                                        if ($row_Recordset1['con_tope']==0) {
                                            echo "<strong> por agente</strong>";
                                        }
                                        if ($row_Recordset1['con_tope']==1) {
                                            echo "<strong> por sorteos</strong>";
                                        }
                                        if ($row_Recordset1['con_tope']==2) {
                                            echo "<strong> de forma global</strong>";
                                        }
                                        echo '</font>';
                                     ?>
                                </td>
								<td width="20%">Costo del Sistema:<br />
                                  <input type="text" name="por_lot" class="textbox" style="height:auto; width:50px" 
                                    value="<?php echo htmlentities($row_Recordset1['por_agencia_lot'], ENT_COMPAT, 'utf-8'); ?>" 
                                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                                    onKeyUp="return handleEnter(this, event)" tabindex="1" max="100"/>
                                    %
                                </td>
								<td width="10%">
									<input type="submit" name="guardarAge" class="btn btn-primary" value="GUARDAR" style="width:80px; height:auto;font-size:12px; margin:5px;" title="guardar datos de agente" />
								</td>
                                <input type="hidden" name="cod_agenciaU" value="<?php echo $xCodigo;?>"/>
                                <input type="hidden" name="MM_update" value="form1"/>
							</tr>
						</table>
					</form>
					<table width="100%" border="0" style="font-size:12px;text-align:center
                      	font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif" 
                        cellpadding="0" cellspacing="0">
						<form action="<?php echo $editFormAction; ?>" method="POST" name="formo" id="formo" 
							autocomplete="off" onsubmit="return chequearEnvio();">
                          <tr style="background:#0084B4;color:#FFFFFF" valign="bottom" class="tr1">
							<form method="post" name="formo" id="formo" action="<?php echo $editFormAction; ?>" style="margin:0">
                                <td align="left" valign="bottom" nowrap colspan="6" 
                                    style="font-size:18px;padding:5px 0 5px 10px; display:none" id="filtro">
                                    <div style="display: block">
                                    	<div style="float:left;width:100%;display:none" class="verA">
                                        TIPO DE ACCION:<br/>
                                            <select name="tipA" id="tipA" style="width:280px; height:18; font-size:12px" 
                                                class="textbox"> 
                                                <option value="-1">Seleccione</option>
                                                <option value="0">CAMBIAR DIAS DE JUEGO</option>
                                                <option value="1">CAMBIAR STATUS DE LOTERIA</option><?php
                                                if ($row_Recordset1['con_tope']==0) {?>
                                                	<option value="2">CAMBIAR TOPE DE TRIPLES</option>
                                                    <option value="3">CAMBIAR TOPE DE TERMINALES</option><?php
                                                }?>
                                            </select>
                                        </div>
                                        <div style="float:left; margin:1px 0 0 5px;width:200px" id="afiltro">
                                            <div style="float:left; padding:7px 0 7px 0; width:100%;">
                                            	<span class="oculA">FILTRAR POR SORTEO:</span>
                                            	<span class="verA" style="display:none">SELECCIONE SORTEO:</span>
                                            </div>
                                            <div style="float:left">
                                            <select multiple="multiple" name="od_sorteo[]" id="od_sorteo" class="noefec"
                                                style="width:227px; height:50px; font-size:16px;margin:2px 0 2px 10px;float:left;">
												<?php
                                                do {?>
                                                    <option value="<?php echo $row_Recordset2['id_sorteo']?>" 
                                                    <?php if (in_array($row_Recordset2['id_sorteo'], $osorteo)) {
                                                    echo"selected=\"selected\"";
                                                }?>>
                                                    <?php echo $row_Recordset2['nom_sorteo']?></option><?php
                                                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));?>
                                            </select>
                                            </div>
                                        </div>
                                        <div style="float:left; margin:1px 0 0 5px;display:none" id="aloteri">
                                            <div style="float:left;padding:7px 0 7px 0;width:100%;">
                                            SELECCIONE LOTERIAS:
                                            </div>
                                            <div style="float:left">
                                            <select multiple="multiple" name="od_loteria[]" id="od_loteria" class="noefec"
                                                style="width:227px; height:50px; font-size:16px;margin:2px 0 2px 10px;float:left;">
												<?php
                                                do {?>
                                                    <option value="<?php echo $row_Recordset3['id_agelot'];?>">
                                                    <?php echo $row_Recordset3['nom_loteria']?></option><?php
                                                } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
                                            </select>
                                            </div>
                                        </div>
                                        <div style="float:left; margin:0 0 0 5px;" class="oculA">
                                        <input type="submit" value="Filtrar" class="btn btn-danger noefec" title="iniciar busqueda" 
                                            style="width:80px; height:30px;"/>
                                        </div>
                                    	<input type="hidden" name="MM_inserto" value="formo"/>
                                    </div>
								</td>
                                <td width="18%" colspan="2" style="font-size:12px;" valign="middle" align="left">
                                    <input type="submit" id="mAccion" value="+Acciones" class="btn btn-warning noefec" 
                                    	title="ver mas opciones" style="width:80px; height:30px; display:none"/>
                                </td>
                          </tr>
                          <tr>
							<td colspan="8" style="background:#FEFCE7;font-size:16px;color:#333">
                            	<div style="display:none; height:120px;text-align:left; padding:5px 0 2px 15px" class="verA">
                                    <div style="width:50%;float:left;">
                                        <div id="diaA" style="float:left;display:none;width:100%" class="verB">
                                        	INDIQUE DIAS DE SORTEO:<br/>
                                            <font style="font-size:12px;letter-spacing:-1px;line-height:1; color:#333">
                                            LU-MA-MI-JU-VI-SA-DO
                                            </font><br/>
                                            <input type="checkbox" name="lunA" value="0" title="lunes"
                                                style="padding:0px; -webkit-transform:scale(1.2,1.2);transform:scale(1.2,1.2);"/>
                                            <input type="checkbox" name="marA" value="0" title="martes"
                                                style="padding:0px; -webkit-transform:scale(1.2,1.2);transform:scale(1.2,1.2);"/>
                                            <input type="checkbox" name="mieA" value="0" title="miercoles"
                                                style="padding:0px; -webkit-transform:scale(1.2,1.2);transform:scale(1.2,1.2);"/>
                                            <input type="checkbox" name="jueA" value="0" title="jueves"
                                                style="padding:0px; -webkit-transform:scale(1.2,1.2);transform:scale(1.2,1.2);"/>
                                            <input type="checkbox" name="vieA" value="0" title="viernes"
                                                style="padding:0px; -webkit-transform:scale(1.2,1.2); transform:scale(1.2,1.2);"/>
                                            <input type="checkbox" name="sabA" value="0" title="sabado"
                                                style="padding:0px; -webkit-transform:scale(1.2,1.2);transform:scale(1.2,1.2);"/>
                                            <input type="checkbox" name="domA" value="0" title="domingo"
                                                style="padding:0px; -webkit-transform:scale(1.2,1.2);transform:scale(1.2,1.2);"/>
                                                    
                                        </div>
                                        <div id="horsA" style="float:left;display:none;width:100%" class="verB">
                                        	CERRAR LOTERIA ANTES DEL SORTEO:<br/>
												<select name="min_cierreA"
													style="width:70px;height:22px;font-size:12px;padding:0;margin:1px 0 0 0">
                                                        <?php for ($i = 0; $i <= 60; $i=$i+5) {
                                                    if ($i<10) {
                                                        $v="0".$i;
                                                    } else {
                                                        $v=$i;
                                                    } ?>
														<option value="<?php echo $i; ?>"><?php echo $v." min"; ?></option>
													<?php
                                                }?>
												</select>
                                        </div>
                                        <div id="statA" style="float:left;display:none;width:100%" class="verB">
                                        	INDIQUE STATUS:<br/>
											<select name="staA" class="textbox" 
                                                style="width:110px; height:25px; font-size:12px; padding:0; margin:1px 0 0 0;"> 
                                                <option value="1">ACTIVO</option>
                                                <option value="0">INACTIVO</option>
											</select>
										</div>
                                        <div id="totrA" style="float:left;display:none;width:100%" class="verB">
                                        	INDIQUE TOPE A TRIPLE:<br/>
                                        	<input type="text" name="toptrA" id="toptrA" 
                                            style="height:20px;width:85px;font-size:12px;text-align:right;padding:0;margin:1px 0 0 0"
                                            onkeypress="ValidaSoloNumeros()" title="indique tope de venta al triple" 
                                            onKeyUp="return handleEnter(this, event)" value="">
                                        </div>
                                        <div id="toteA" style="float:left;display:none;width:100%" class="verB">
                                        	INDIQUE TOPE A TERMINAL:<br/>
                                        	<input type="text" name="topteA" id="topteA" 
                                            style="height:20px;width:85px;font-size:12px;text-align:right;padding:0;margin:1px 0 0 0"
                                            onkeypress="ValidaSoloNumeros()" title="indique tope de venta al triple" 
                                            onKeyUp="return handleEnter(this, event)" value="">
                                        </div>
                                        <div style="float:left;padding:5px 0 0 0">
										<input type="submit" id="mProcesa" name="mProcesa" value="Procesar" 
                                        	class="btn btn-info noefec" 
                                    		title="procesar acciones" style="width:80px; height:30px;"/>
										</div>
                                    </div>
                                    
                                    <div style="width:48%;float:left;text-align:center;font-size:15px;padding:1%;color:#A6A6A6;">
                                    	ACCIONES RAPIDAS<br/>
                                    	Por favor, indique el tipo de accion, seleccione sorteos o loterias, cambie el valor y
                                        presione el boton procesar 
                                    </div>
                                </div>
							</td>
                          </tr>
                          </form>
                          <tr style="background:#0084B4;color:#FFFFFF;letter-spacing: -1px;line-height: 1" valign="bottom"
                          	align="center">
                            <td width="20%" style="font-size:12px">&nbsp;SORTEOS</td>
                            <td width="22%" style="font-size:12px">LOTERIAS</td>
                            <td width="7%" style="font-size:11px">PREMIO<br/>TRIPLE</td>
                            <td width="8%" style="font-size:12px">PREMIO<br/>TERMINAL</td>
                            <td width="10%" style="font-size:12px">TOPE VENTA<br/>TRIPLE</td>
                            <td width="10%" style="font-size:12px">TOPE VENTA<br/>TERMINAL</td>
                            <td width="14%" style="font-size:11px">DIAS<br/>LU-MA-MI-JU-VI-SA-DO</td>
                            <td width="9%" style="font-size:12px">STATUS</td>
                          </tr>
					</table><?php
                    $sorteo="";$c=0;$cambio=1;
                    $nom_sorteo=$row_Recordset1['nom_sorteo'];
                    do {
                        if ($row_Recordset1['est_banlot']==1) {
                            list($hor, $min, $am)=explode(":", cambioHoramysql($row_Recordset1['hor_cierre']));
                            if ($sorteo!=$row_Recordset1['nom_sorteo']) {
                                if ($c>0) {
                                    echo '<table width="100%" border="0">';
                                    echo '<tr valign="bottom" align="right">';
                                    echo '<td>'; ?>
										<input type="submit" name="guardar" class="btn btn-success" value="GUARDAR CAMBIOS" style="width:140px; height:30px; font-size:12px; margin:5px" title="&nbsp;guardar cambios<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo; ?>" /><?php
                                        echo '</td>';
                                    echo '</tr>';
                                    echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                                    echo '<td>';
                                    echo '</td>';
                                    echo '</tr>';
                                    echo '</table>';
                                    echo '</form>';
                                }
                                $cambio=1;
                                $nom_sorteo=$row_Recordset1['nom_sorteo'];
                            }
                            if ($cambio==1) {
                                echo '<form method="post" action="'.$editFormAction.'" onsubmit="return chequearEnvio();" style="margin:0">';
                            }
                            //if ($c==0) echo "<br/>";
                            $gu="bg".$row_Recordset1['id_banlot']; ?>
								<table width="100%" border="0" style="font-size:12px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;text-align:center;" cellpadding="0" cellspacing="0">
									<tr valign="bottom">
										<td width="20%" align="left" style="font-size:12px;" title="nombre de sorteo/hora cierre">
											<?php
                                            if ($sorteo!=$row_Recordset1['nom_sorteo']) {
                                                echo "<strong>&nbsp;".$row_Recordset1['nom_sorteo']."</strong><br/>&nbsp;Cierre:";
                                                echo $hor.":".$min.$am;
                                                $sorteo=$row_Recordset1['nom_sorteo'];
                                                echo '<input type="hidden" name="sorteo" value="'.$sorteo.'"/>';
                                            }
                            if ($row_Recordset1['est_agelot']==1) {
                                $color="#E1E1E1";
                            } else {
                                $color="#FFB7B8";
                            } ?>
										</td>
										<td width="80%" align="left" style="font-size:12px;">
											<table width="100%" border="0" style="font-size:12px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;text-align:center; background:<?php echo $color; ?>" cellpadding="0" cellspacing="0">
												<tr class="brillo" style="border-bottom:1px solid  #D5D5D5;line-height:-1;" >
												  <td align="left" width="27%" title="nombre de loteria">
														&nbsp;
														<?php echo $row_Recordset1['nom_loteria']; ?>
												  </td>
												  <td align="right" width="10%" title="premio por triple">
														<?php echo $row_Recordset1['pre_loteria']; ?>
												  </td>
												  <td align="right" width="10%" title="premio por terminal">
												  <?php  if ($row_Recordset1['tip_loteria']!=4) {
                                echo $row_Recordset1['pre_terminal'];
                            } ?>
												  </td>
												  <td title="tope maximo venta triple"><?php
                                                      if ($row_Recordset1['con_tope']==0) {?>
														<input type="text" name="top_ventaage_tri[]" 
														style="height:20px;width:85px;font-size:12px;text-align:right;padding:0;
                                                        margin:1px 0 0 0"
														onkeypress="ValidaSoloNumeros()" title="indique tope maximo de venta triple"
														onKeyUp="return handleEnter(this, event)"
														value="<?php echo htmlentities($row_Recordset1['top_ventaage'], ENT_COMPAT, 'utf-8'); ?>"><?php
                                                    } else {?>
														<input type="hidden" name="top_ventaage_tri[]" 
                                                        value="<?php echo $row_Recordset1['top_ventaage']; ?>"><?php
                                                        echo '<div style=" text-align:right; width:90px; background:#FFF;">';
                                                        if ($row_Recordset1['con_tope']==1) {
                                                            echo $row_Recordset1['top_venta'];
                                                        }
                                                        if ($row_Recordset1['con_tope']==2) {
                                                            echo $row_Recordset1['top_triple_lot'];
                                                        }
                                                        echo '</div>';
                                                    } ?>
												  </td>
												  <td title="tope maximo venta terminal"><?php
                                                  if ($row_Recordset1['tip_loteria']<4) {
                                                      if ($row_Recordset1['con_tope']==0) {?>
														<input type="text" name="top_ventaage_ter[]" 
														style="height:20px;width:85px;font-size:12px;text-align:right;
                                                        padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" 
                                                        title="indique tope maximo de venta terminal"
														onKeyUp="return handleEnter(this, event)"
														value="<?php echo htmlentities($row_Recordset1['top_terminal'], ENT_COMPAT, 'utf-8'); ?>"><?php
                                                        } else {?>
													    <input type="hidden" name="top_ventaage_ter[]" 
                                                        value="<?php echo $row_Recordset1['top_terminal']; ?>"><?php
                                                            echo '<div style=" text-align:right; width:90px; background:#FFF;">';
                                                            if ($row_Recordset1['con_tope']==1) {
                                                                echo $row_Recordset1['top_venta_terminal'];
                                                            }
                                                            if ($row_Recordset1['con_tope']==2) {
                                                                echo $row_Recordset1['top_terminal_lot'];
                                                            }
                                                            echo '</div>';
                                                        }
                                                  } else { ?>  
														<input type="hidden" name="top_ventaage_ter[]" value="0">
												  <?php } ?>
												  </td>
												  <td>
														<input type="checkbox" name="lun<?php echo $row_Recordset1['id_agelot']; ?>" value="" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['lun_loteria'], ENT_COMPAT, 'utf-8'), 1))) {
                                                      echo "checked=\"checked\"";
                                                  } ?> title="lunes"/>
														<input type="checkbox" name="mar<?php echo $row_Recordset1['id_agelot']; ?>" value="" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['mar_loteria'], ENT_COMPAT, 'utf-8'), 1))) {
                                                      echo "checked=\"checked\"";
                                                  } ?> title="martes"/>
														<input type="checkbox" name="mie<?php echo $row_Recordset1['id_agelot']; ?>" value="" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['mie_loteria'], ENT_COMPAT, 'utf-8'), 1))) {
                                                      echo "checked=\"checked\"";
                                                  } ?> title="miercoles"/>
														<input type="checkbox" name="jue<?php echo $row_Recordset1['id_agelot']; ?>" value="" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['jue_loteria'], ENT_COMPAT, 'utf-8'), 1))) {
                                                      echo "checked=\"checked\"";
                                                  } ?> title="jueves"/>
														<input type="checkbox" name="vie<?php echo $row_Recordset1['id_agelot']; ?>" value="" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['vie_loteria'], ENT_COMPAT, 'utf-8'), 1))) {
                                                      echo "checked=\"checked\"";
                                                  } ?> title="viernes"/>
														<input type="checkbox" name="sab<?php echo $row_Recordset1['id_agelot']; ?>" value="" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['sab_loteria'], ENT_COMPAT, 'utf-8'), 1))) {
                                                      echo "checked=\"checked\"";
                                                  } ?>  title="sabado"/>
														<input type="checkbox" name="dom<?php echo $row_Recordset1['id_agelot']; ?>" value="" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['dom_loteria'], ENT_COMPAT, 'utf-8'), 1))) {
                                                      echo "checked=\"checked\"";
                                                  } ?> title="domingo"/>
												  </td>
												  <td title="status de loteria">
														<select name="est_loteria[]" class="textbox" id="<?php echo $gu."St"; ?>"
															style="width:80px; height:22px; font-size:12px; padding:0; margin:1px 0 0 0"> 
														  <option value="1" 
														  <?php if (!(strcmp(1, htmlentities($row_Recordset1['est_agelot'], ENT_COMPAT, 'utf-8')))) {
                                                      echo "SELECTED";
                                                  } ?>>ACTIVO</option>
														  <option value="0" 
														  <?php if (!(strcmp(0, htmlentities($row_Recordset1['est_agelot'], ENT_COMPAT, 'utf-8')))) {
                                                      echo "SELECTED";
                                                  } ?>>INACTIVO</option>
														</select>
												  </td>
												</tr>
											<input type="hidden" name="idtr_agelot[]"
												value="<?php echo $row_Recordset1['id_agelot']; ?>"/>
											<input type="hidden" name="idte_agelot[]"
												value="<?php echo $row_Recordset1['id_agelot_ter']; ?>"/>
											<input type="hidden" name="tip_loteria[]" 
												value="<?php echo $row_Recordset1['tip_loteria']; ?>"/>
											<input type="hidden" name="nom_loteria[]" 
												value="<?php echo $row_Recordset1['nom_loteria']; ?>"/>
											</table>
										</td>
									</tr>
								</table>
									<?php
                                    $c++;
                        }
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                        if ($c>0) {
                            echo '<table width="100%" border="0">';
                            echo '<tr valign="bottom" align="right">';
                            echo '<td>'; ?>
							<input type="submit" name="guardar" class="btn btn-success" value="GUARDAR CAMBIOS" style="width:140px; height:30px; font-size:12px; margin:5px" title="&nbsp;guardar cambios<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo; ?>" /><?php
                            echo '</td>';
                            echo '</tr>';
                            echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                            echo '<td>';
                            echo '</td>';
                            echo '</tr>';
                            echo '</table>';
                            echo '</form>';
                        } else {
                            echo '<div style="padding:100px 0;color:#FB0734;text-align:center;">TODOS LOS SORTEOS Y LOTERIAS<br/>';
                            echo "PARA ESTE AGENTES ESTAN DESACTIVADAS</div>";
                        }?>
				</div><?php
                } else {?>
					<div style="font-size:24px; text-align:center; line-height:1; padding:120px 0 ; 
                    	font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
                    	ATENCION:<br/><br/>LAS OPCIONES DE LOTERIAS PARA ESTE AGENTE<br/>NO HAN SIDO CREADAS
                    
                        <table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td align="center">
                                    <td height="82" align="center" valign="bottom"><?php
                                    if (isset($xCodigo) && $xCodigo>0) {?>
                                        <form method="post" name="form2" action="<?php echo $editFormAction; ?>"  
                                            onsubmit="return chequearEnvio();">
                                            <input type="submit" class="btn btn-warning" value="CREAR OPCIONES"
                                            style="width:180px; height:50px; font-size:16px;" />
                                            <input type="hidden" name="MM_insert2" value="form2"/>
                                            <input type="hidden" name="cod_agencia" value="<?php echo $xCodigo;?>"/>
                                        </form><?php
                                    } else {?> 
                                        <a href='admin_distri_lista_lot.php' class="btn  btn-danger"
                                             style="width:150px; height:40px; font-size:16px; text-decoration:none; color:#FFFFFF">
                                        	<div style="padding:10px 0px 0px 0px">SALIR</div>
										</a>
                                    <?php }?>   
                                    </td>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div><?php
                }?>
			</div>
		</div>
		<div class="footer" style="background:#0084B4">Copyright © Apuestas Hípicas</div>
	</div>
</body>
</html>
<?php
if (isset($Recordset1)) {
                    mysqli_free_result($Recordset1);
                }
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
?>
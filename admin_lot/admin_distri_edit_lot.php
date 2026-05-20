<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menS="";
$menE="";
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

function calcular_tiempo_trasnc($hora1, $hora2)
{
    $separar[1]=explode(':', $hora1);
    $separar[2]=explode(':', $hora2);
    $total_minutos_trasncurridos[1] = ($separar[1][0]*60)+$separar[1][1];
    $total_minutos_trasncurridos[2] = ($separar[2][0]*60)+$separar[2][1];
    $total_minutos_trasncurridos = $total_minutos_trasncurridos[1]-$total_minutos_trasncurridos[2];
    return($total_minutos_trasncurridos);
}

if (isset($_POST["guardar"])) {
    $d=0;
    $cta=0;
    $graba=31;
    $pre_triple=$_POST['pre_triple'];
    $pre_terminal=$_POST['pre_terminal'];
    $tip_loteria=$_POST['tip_loteria'];
    $nom_loteria=$_POST['nom_loteria'];
    foreach ($_POST["idtr_banlot"] as $nom) {
        if ($pre_triple[$d]==0) {
            $menE="&nbsp;&nbsp; ".$nom_loteria[$d]." &nbsp;&nbsp;<br/>";
            $menE.="&nbsp;&nbsp;MONTO DEL PREMIO DEL TRIPLE DEBE SER MAYOR A CERO &nbsp;&nbsp;";
            $menS="";
            $graba--;
            break;
        }
        if ($pre_terminal[$d]==0&&$tip_loteria[$d]<4) {
            $menE="&nbsp;&nbsp; ".$nom_loteria[$d]." &nbsp;&nbsp;<br/>";
            $menE.="&nbsp;&nbsp;MONTO DEL PREMIO DE TERMINAL DEBE SER MAYOR A CERO &nbsp;&nbsp;";
            $menS="";
            $graba--;
            break;
        }
        $d++;
    }
    if ($graba==31) {
        $nom_loteria=$_POST['nom_loteria'];
        $est_loteria=$_POST['est_loteria'];
        $id_ter_banlot=$_POST['idte_banlot'];
        $min_cierre=$_POST["min_cierre"];
        $cta=0;
        $query_Recordset8 =  sprintf(
            "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 1 */ SELECT so.hor_sorteo
			FROM loterias lo, sorteos so, bancaloterias bl 
			WHERE bl.id_banlot = %s AND lo.id_loteria = bl.id_loteria AND lo.id_sorteo = so.id_sorteo
			LIMIT 1",
            GetSQLValueString($_POST["idtr_banlot"][0], "int")
        );
        $Recordset8 = mysqli_query($conexionbanca, $query_Recordset8) or die(mysqli_error($conexionbanca));
        $row_Recordset8 = mysqli_fetch_assoc($Recordset8);
        $totalRows_Recordset8 = mysqli_num_rows($Recordset8);
        foreach ($_POST["idtr_banlot"] as $idl) {
            if ($min_cierre[$cta]>0) {
                $disminuir=$row_Recordset8['hor_sorteo']."-".$min_cierre[$cta]." min";
                $hora=(date('H:i', strtotime($disminuir)));
            } else {
                $hora=$row_Recordset8['hor_sorteo'];
            }
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
                "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 2 */ UPDATE bancaloterias 
					SET
					hor_cierre=%s,
					est_banlot=%s,
					lun_loteriabanca=%s,
					mar_loteriabanca=%s,
					mie_loteriabanca=%s,
					jue_loteriabanca=%s,
					vie_loteriabanca=%s,
					sab_loteriabanca=%s,
					dom_loteriabanca=%s,
					pre_loteria=%s,
					top_venta=%s
					WHERE id_banlot=%s",
                GetSQLValueString($hora, "date"),
                GetSQLValueString($est_loteria[$cta], "int"),
                GetSQLValueString($lun, "int"),
                GetSQLValueString($mar, "int"),
                GetSQLValueString($mie, "int"),
                GetSQLValueString($jue, "int"),
                GetSQLValueString($vie, "int"),
                GetSQLValueString($sab, "int"),
                GetSQLValueString($dom, "int"),
                GetSQLValueString($pre_triple[$cta], "double"),
                GetSQLValueString($_POST['top_triple_sorteo'], "double"),
                GetSQLValueString($idl, "int")
            );
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            if ($tip_loteria[$cta]<4) {
                $insertSQL3 = sprintf(
                    "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 3 */ UPDATE bancaloterias 
						SET
						hor_cierre=%s,
						est_banlot=%s,
						lun_loteriabanca=%s,
						mar_loteriabanca=%s,
						mie_loteriabanca=%s,
						jue_loteriabanca=%s,
						vie_loteriabanca=%s,
						sab_loteriabanca=%s,
						dom_loteriabanca=%s,
						pre_loteria=%s,
						top_venta=%s
						WHERE id_banlot=%s",
                    GetSQLValueString($hora, "date"),
                    GetSQLValueString($est_loteria[$cta], "int"),
                    GetSQLValueString($lun, "int"),
                    GetSQLValueString($mar, "int"),
                    GetSQLValueString($mie, "int"),
                    GetSQLValueString($jue, "int"),
                    GetSQLValueString($vie, "int"),
                    GetSQLValueString($sab, "int"),
                    GetSQLValueString($dom, "int"),
                    GetSQLValueString($pre_terminal[$cta], "double"),
                    GetSQLValueString($_POST['top_terminal_sorteo'], "double"),
                    GetSQLValueString($id_ter_banlot[$cta], "int")
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1" && isset($_POST["guardarDis"]))) {
    $graba=31;
    if ($_POST['por_lot']<0) {
        $menE.="&nbsp;&nbsp;COSTO DEL SISTEMA DEBE SER MAYOR O IGUAL A CERO &nbsp;&nbsp;";
        $graba--;
        $menS="";
    }
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 4 */ UPDATE banca 
			SET
			por_banca_lot=%s, 
			mod_resultado=%s,
			top_triple_lot=%s,
			top_terminal_lot=%s,
			con_tope=%s
			WHERE cod_banca=%s",
            GetSQLValueString($_POST['por_lot'], "double"),
            GetSQLValueString($_POST['mod_resultado'], "int"),
            GetSQLValueString($_POST['top_triple_lot'], "double"),
            GetSQLValueString($_POST['top_terminal_lot'], "double"),
            GetSQLValueString($_POST['con_tope'], "int"),
            GetSQLValueString($_POST['cod_banca'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $menS="&nbsp;&nbsp; DATOS DEL <strong>DISTRIBUIDOR</strong> &nbsp;&nbsp;<br/>";
        $menS.="&nbsp;&nbsp; SE GUARDARON CORRECTAMENTE &nbsp;&nbsp;";
        $menE="";
    }
}
if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 5 */ UPDATE banca 
		SET
		mod_resultado=%s,
		top_triple_lot=%s,
		top_terminal_lot=%s
		WHERE cod_banca=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString(9999, "double"),
        GetSQLValueString(9999, "double"),
        GetSQLValueString($_POST['cod_banca'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    $query_Recordset6 =  sprintf("/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 6 */ SELECT 
			lo.id_loteria, lo.tip_loteria, lo.id_triple, lo.id_terminal, lo.id_sorteo, lo.nom_loteria, 
			so.hor_sorteo, so.lun, so.mar, so.mie, so.jue, so.vie, so.sab, so.dom,
			CASE lo.tip_loteria  
				WHEN 2 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 7 */ SELECT lot.tip_loteria FROM loterias lot WHERE lo.id_triple = lot.id_loteria LIMIT 1)
				ELSE '0'
			END AS tipo
		FROM loterias lo, sorteos so 
		WHERE lo.id_sorteo = so.id_sorteo");
    $Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
    $row_Recordset6 = mysqli_fetch_assoc($Recordset6);
    $totalRows_Recordset6 = mysqli_num_rows($Recordset6);
    if ($totalRows_Recordset6>0) {
        $menS="&nbsp;&nbsp; OPCIONES CREADAS CORRECTAMENTE &nbsp;&nbsp;";
        $menE="";
        do {
            $query_Recordset7 =  sprintf(
                "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 8 */ SELECT id_loteria
				FROM bancaloterias 
				WHERE id_loteria = %s AND id_banca = %s LIMIT 1",
                GetSQLValueString($row_Recordset6['id_loteria'], "int"),
                GetSQLValueString($_POST['cod_banca'], "int")
            );
            $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
            $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
            $totalRows_Recordset7 = mysqli_num_rows($Recordset7);
            if ($totalRows_Recordset7==0) {
                $premio=0;
                if ($row_Recordset6['tip_loteria']==1) {
                    $premio=600;
                } elseif ($row_Recordset6['tip_loteria']==2) {
                    if ($row_Recordset6['tipo']==1) {
                        $premio=60;
                    } elseif ($row_Recordset6['tipo']==3) {
                        $premio=600;
                    }
                } elseif ($row_Recordset6['tip_loteria']==3) {
                    $premio=6000;
                } elseif ($row_Recordset6['tip_loteria']>3&&$row_Recordset6['tip_loteria']<6) {
                    $premio=30;
                } else {
                    $premio=32;
                }
                $insertSQL2 = sprintf(
                    "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 9 */ INSERT 
					INTO bancaloterias 
					(id_banca, id_loteria, est_banlot, hor_cierre, top_venta, pre_loteria,
					lun_loteriabanca, mar_loteriabanca, 
					mie_loteriabanca, jue_loteriabanca, vie_loteriabanca, sab_loteriabanca, dom_loteriabanca) 
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($_POST['cod_banca'], "int"),
                    GetSQLValueString($row_Recordset6['id_loteria'], "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($row_Recordset6['hor_sorteo'], "date"),
                    GetSQLValueString(9000, "double"),
                    GetSQLValueString($premio, "double"),
                    GetSQLValueString($row_Recordset6['lun'], "int"),
                    GetSQLValueString($row_Recordset6['mar'], "int"),
                    GetSQLValueString($row_Recordset6['mie'], "int"),
                    GetSQLValueString($row_Recordset6['jue'], "int"),
                    GetSQLValueString($row_Recordset6['vie'], "int"),
                    GetSQLValueString($row_Recordset6['sab'], "int"),
                    GetSQLValueString($row_Recordset6['dom'], "int")
                );
                $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            }
            if (isset($Recordset7)) {
                mysqli_free_result($Recordset7);
            }
        } while ($row_Recordset6 = mysqli_fetch_assoc($Recordset6));
    } else {
        $menE="&nbsp;&nbsp; HUBO UN ERROR INTENTE NUEVAMENTE &nbsp;&nbsp;";
        $menS="";
    }
    if (isset($Recordset6)) {
        mysqli_free_result($Recordset6);
    }
}
if ((isset($_POST["MM_inserto"])) && ($_POST["MM_inserto"] == "formo") && (isset($_POST["mProcesa"]))) {
    $menS="";
    $menE="";
    if (isset($_POST["tipA"]) && $_POST["tipA"]>=0) {
        if ($_POST["tipA"]>=0 && $_POST["tipA"]<=4 && isset($_POST["od_loteria"])) {
            $loteria=implode("','", $_POST["od_loteria"]);
            $query_Recordset1 =  sprintf(
                "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 10 */ SELECT 
				bl.id_banlot, lo.tip_loteria, so.hor_sorteo,
				CASE lo.tip_loteria
					WHEN 1 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 11 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
						ba.cod_banca = blo.id_banca LIMIT 1)
					WHEN 3 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 12 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
						ba.cod_banca = blo.id_banca LIMIT 1)
					ELSE 0
				END AS id_terminal	
				FROM banca ba, bancaloterias bl, loterias lo, sorteos so
				WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND lo.est_loteria = 1 AND 
					lo.id_sorteo = so.id_sorteo AND bl.id_banlot IN ('$loteria')",
                GetSQLValueString($xCodigo, "int")
            );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            //echo $totalRows_Recordset1." ".$row_Recordset1['id_banlot']." ".$row_Recordset1['id_terminal']."<br/>";
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
                            "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 13 */ UPDATE bancaloterias 
							SET lun_loteriabanca=%s, mar_loteriabanca=%s, mie_loteriabanca=%s, jue_loteriabanca=%s,
								vie_loteriabanca=%s, sab_loteriabanca=%s, dom_loteriabanca=%s
								WHERE id_banlot=%s",
                            GetSQLValueString($lun, "int"),
                            GetSQLValueString($mar, "int"),
                            GetSQLValueString($mie, "int"),
                            GetSQLValueString($jue, "int"),
                            GetSQLValueString($vie, "int"),
                            GetSQLValueString($sab, "int"),
                            GetSQLValueString($dom, "int"),
                            GetSQLValueString($row_Recordset1['id_banlot'], "int")
                        );
                        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        if ($row_Recordset1['tip_loteria']==1 or $row_Recordset1['tip_loteria']==3) {
                            $insertSQL2 = sprintf(
                                "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 14 */ UPDATE bancaloterias 
								SET lun_loteriabanca=%s, mar_loteriabanca=%s, mie_loteriabanca=%s, jue_loteriabanca=%s,
									vie_loteriabanca=%s, sab_loteriabanca=%s, dom_loteriabanca=%s
									WHERE id_banlot=%s",
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
                } elseif ($_POST["tipA"]==1) {//hora
                    do {
                        if ($_POST['min_cierreA']>0) {
                            $disminuir=$row_Recordset1['hor_sorteo']."-".$_POST['min_cierreA']." min";
                            $hora=(date('H:i', strtotime($disminuir)));
                        } else {
                            $hora=$row_Recordset1['hor_sorteo'];
                        }
                        $insertSQL2 = sprintf(
                            "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 15 */ UPDATE bancaloterias SET hor_cierre=%s WHERE id_banlot=%s",
                            GetSQLValueString($hora, "date"),
                            GetSQLValueString($row_Recordset1['id_banlot'], "int")
                        );
                        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        if ($row_Recordset1['tip_loteria']==1 or $row_Recordset1['tip_loteria']==3) {
                            $insertSQL2 = sprintf(
                                "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 16 */ UPDATE bancaloterias SET hor_cierre=%s WHERE id_banlot=%s",
                                GetSQLValueString($hora, "date"),
                                GetSQLValueString($row_Recordset1['id_terminal'], "int")
                            );
                            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        }
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                } elseif ($_POST["tipA"]==2) {//premio triple triA
                    if ($_POST['triA']>0) {
                        do {
                            $insertSQL3 = sprintf(
                                "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 17 */ UPDATE bancaloterias 
								SET pre_loteria=%s
								WHERE id_banlot=%s",
                                GetSQLValueString($_POST['triA'], "double"),
                                GetSQLValueString($row_Recordset1['id_banlot'], "int")
                            );
                            $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    } else {
                        $menE="&nbsp;&nbsp;PREMIO DE TRIPLE DEBE SER MAYOR A CERO&nbsp;&nbsp;<br/>DATOS NO GUARDADOS&nbsp;&nbsp;";
                    }
                } elseif ($_POST["tipA"]==3) {//premio terminal terA
                    if ($_POST['terA']>0) {
                        do {
                            if ($row_Recordset1['tip_loteria']==1 or $row_Recordset1['tip_loteria']==3) {
                                $insertSQL3 = sprintf(
                                    "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 18 */ UPDATE bancaloterias 
									SET pre_loteria=%s
									WHERE id_banlot=%s",
                                    GetSQLValueString($_POST['terA'], "double"),
                                    GetSQLValueString($row_Recordset1['id_terminal'], "int")
                                );
                                $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
                            }
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    } else {
                        $menE="&nbsp;&nbsp;PREMIO DE TERMINAL DEBE SER MAYOR A CERO&nbsp;<br/>DATOS NO GUARDADOS&nbsp;&nbsp;";
                    }
                } elseif ($_POST["tipA"]==4) {//estatus staA
                    do {
                        $insertSQL2 = sprintf(
                            "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 19 */ UPDATE bancaloterias SET est_banlot=%s WHERE id_banlot=%s",
                            GetSQLValueString($_POST['staA'], "int"),
                            GetSQLValueString($row_Recordset1['id_banlot'], "int")
                        );
                        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        if ($row_Recordset1['tip_loteria']==1 or $row_Recordset1['tip_loteria']==3) {
                            $insertSQL2 = sprintf(
                                "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 20 */ UPDATE bancaloterias SET est_banlot=%s WHERE id_banlot=%s",
                                GetSQLValueString($_POST['staA'], "int"),
                                GetSQLValueString($row_Recordset1['id_terminal'], "int")
                            );
                            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        }
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                }
            } else {
                $menE="&nbsp;&nbsp; ALGO SALIO MAL&nbsp;&nbsp;<br/>DATOS NO GUARDADOS&nbsp;&nbsp;";
            }
        } elseif ($_POST["tipA"]>=5 && isset($_POST["od_sorteo"])) {
            if ($_POST["tipA"]==5 && $_POST["toptrA"]>0) {
                $sorteo=implode("','", $_POST["od_sorteo"]);
                $query_Recordset1 =  sprintf(
                    "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 21 */ SELECT bl.id_banlot, bl.top_venta
					FROM banca ba, bancaloterias bl, loterias lo, sorteos so 
					WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND 
					lo.tip_loteria != 2 AND lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1 AND 
					so.id_sorteo IN ('$sorteo')",
                    GetSQLValueString($xCodigo, "int")
                );
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                if ($totalRows_Recordset1>0) {
                    do {
                        //echo $row_Recordset1['id_banlot']."<br/>";
                        $insertSQL1 = sprintf(
                            "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 22 */ UPDATE bancaloterias 
							SET
							top_venta=%s
							WHERE id_banlot=%s",
                            GetSQLValueString($_POST["toptrA"], "double"),
                            GetSQLValueString($row_Recordset1['id_banlot'], "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    $menS="&nbsp;&nbsp; TOPES DE TRIPLES POR SORTEOS&nbsp;&nbsp;<br/>GUARDADOS CORRECTAMENTE";
                } else {
                    $menE="&nbsp;&nbsp; ALGO SALIO MAL&nbsp;&nbsp;<br/>DATOS NO GUARDADOS&nbsp;&nbsp;";
                }
                mysqli_free_result($Recordset1);
            } elseif ($_POST["tipA"]==6 && $_POST["topteA"]>0) {
                //aqui guardar tope por sorteo de terminal
                $sorteo=implode("','", $_POST["od_sorteo"]);
                $query_Recordset1 =  sprintf(
                    "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 23 */ SELECT bl.id_banlot, bl.top_venta
					FROM banca ba, bancaloterias bl, loterias lo, sorteos so 
					WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND 
					lo.tip_loteria = 2 AND lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1 AND 
					so.id_sorteo IN ('$sorteo')",
                    GetSQLValueString($xCodigo, "int")
                );
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                if ($totalRows_Recordset1>0) {
                    do {
                        echo $row_Recordset1['id_banlot']."<br/>";
                        $insertSQL1 = sprintf(
                            "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 24 */ UPDATE bancaloterias 
							SET
							top_venta=%s
							WHERE id_banlot=%s",
                            GetSQLValueString($_POST["topteA"], "double"),
                            GetSQLValueString($row_Recordset1['id_banlot'], "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    $menS="&nbsp;&nbsp; TOPES DE TERMINALES POR SORTEOS&nbsp;&nbsp;<br/>GUARDADOS CORRECTAMENTE";
                } else {
                    $menE="&nbsp;&nbsp; ALGO SALIO MAL&nbsp;&nbsp;<br/>DATOS NO GUARDADOS&nbsp;&nbsp;";
                }
            } elseif (($_POST["tipA"]==6 && $_POST["topteA"]<=0) or ($_POST["tipA"]==5 && $_POST["toptrA"]<=0)) {
                $menE="&nbsp;&nbsp;DEBE INDICAR UN VALOR MAYOR A CERO&nbsp;&nbsp;<br/>DATOS NO GUARDADO&nbsp;&nbsp;";
            }
        } elseif (!isset($_POST["od_loteria"]) && ($_POST["tipA"]>=0 && $_POST["tipA"]<=4)) {
            $menE="&nbsp;&nbsp;DEBE SELECCIONAR UNA LOTERIA&nbsp;&nbsp;<br/>DATOS NO GUARDADO&nbsp;&nbsp;";
        } elseif (!isset($_POST["od_sorteo"]) && $_POST["tipA"]>=5) {
            $menE="&nbsp;&nbsp;DEBE SELECCIONAR UN SORTEO&nbsp;&nbsp;<br/>DATOS NO GUARDADO&nbsp;&nbsp;";
        }
    } else {
        $menE="&nbsp;&nbsp;POR FAVOR, SELECCIONE UNO DE LOS&nbsp;&nbsp;<br/>TIPOS DE ACCIONES RAPIDAS&nbsp;&nbsp;";
    }
}


if ((isset($_POST["MM_inserto"])) && ($_POST["MM_inserto"] == "formo") && (isset($_POST["od_sorteo"]))) {
    $osorteo = implode("','", $_POST["od_sorteo"]);
    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 25 */ SELECT ba.cod_banca, ba.nom_banca, ba.por_banca_lot, ba.mod_resultado,
		ba.con_tope, ba.top_triple_lot, ba.top_terminal_lot, so.hor_sorteo,
		bl.lun_loteriabanca, bl.mar_loteriabanca, bl.mie_loteriabanca, bl.jue_loteriabanca, bl.vie_loteriabanca, 
		bl.sab_loteriabanca, bl.dom_loteriabanca, bl.est_banlot, bl.hor_cierre, bl.pre_loteria, bl.id_banlot, bl.top_venta, 
		lo.nom_loteria, lo.id_loteria, lo.id_terminal, lo.tip_loteria, so.nom_sorteo,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 26 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 27 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			ELSE 0
		END AS pre_terminal,	
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 28 */ SELECT blo.top_venta FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 29 */ SELECT blo.top_venta FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			ELSE 0
		END AS top_venta_terminal,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 30 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 31 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			ELSE 0
		END AS id_banlot_ter	
		FROM banca ba, bancaloterias bl, loterias lo, sorteos so 
		WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND lo.tip_loteria != 2 AND
		lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1 AND so.id_sorteo IN ('$osorteo')
		ORDER BY lo.id_sorteo ASC, let_loteria ASC",
        GetSQLValueString($xCodigo, "int")
    );
    $osorteo = $_POST["od_sorteo"];
} else {
    $osorteo=array();
    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 32 */ SELECT ba.cod_banca, ba.nom_banca, ba.por_banca_lot, ba.mod_resultado, 
		ba.con_tope, ba.top_triple_lot, ba.top_terminal_lot, so.hor_sorteo, 
		bl.lun_loteriabanca, bl.mar_loteriabanca, bl.mie_loteriabanca, bl.jue_loteriabanca, bl.vie_loteriabanca, 
		bl.sab_loteriabanca, bl.dom_loteriabanca, bl.est_banlot, bl.hor_cierre, bl.pre_loteria, bl.id_banlot, bl.top_venta,
		lo.nom_loteria, lo.id_loteria, lo.id_terminal, lo.tip_loteria, so.nom_sorteo,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 33 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 34 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			ELSE 0
		END AS pre_terminal,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 35 */ SELECT blo.top_venta FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 36 */ SELECT blo.top_venta FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			ELSE 0
		END AS top_venta_terminal,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 37 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 38 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal AND 
				ba.cod_banca = blo.id_banca LIMIT 1)
			ELSE 0
		END AS id_banlot_ter	
		FROM banca ba, bancaloterias bl, loterias lo, sorteos so 
		WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND lo.tip_loteria != 2 AND
		lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1
		ORDER BY lo.id_sorteo ASC, let_loteria ASC",
        GetSQLValueString($xCodigo, "int")
    );
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 =  sprintf(
    "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 39 */ SELECT so.id_sorteo, so.nom_sorteo
	FROM banca ba, bancaloterias bl, loterias lo, sorteos so 
	WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND lo.tip_loteria != 2 AND
	lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1
	GROUP BY so.id_sorteo
	ORDER BY lo.nom_loteria ASC",
    GetSQLValueString($xCodigo, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$query_Recordset3 =  sprintf(
    "/* PARSEADORES1 admin_lot\admin_distri_edit_lot.php - QUERY 40 */ SELECT lo.nom_loteria, bl.id_banlot
	FROM banca ba, bancaloterias bl, loterias lo
	WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND lo.tip_loteria != 2 AND
	lo.est_loteria = 1
	ORDER BY lo.id_sorteo ASC, lo.let_loteria ASC, lo.tip_loteria",
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
<!--[if lte IE 7]><link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" /><![endif]-->
<style>
body {background-color: #eeeeee;padding:0;margin:0 auto;font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;	font-size:11px;}
    #example-optionClass-container .multiselect-container li.odd {background:#eeeeee;}
    #example-optionClass-container .multiselect-all {background: #eeeeee; color:#EB0408}
	.noefec2 {
	webkit-border-radius:0px !important;
	border-radius: 0px !important;
	background-repeat: no-repeat !important; 
	border-color: transparent !important; 
	background-image: none !important; 
	box-shadow: none !important;		
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
$(document).ready(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());var refreshId1 = setInterval(function() {
$("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);$('#divS, #divE').fadeOut(12000);
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
	$('#con_tope').change(function(){
		if ($('#con_tope').val()==0) {
			$("#tope0").css('display','');$(".tope1").css('display','none');$("#tope2").css('display','none');
		} else if ($('#con_tope').val()==1) {
			$("#tope0").css('display','none');$(".tope1").css('display','');$("#tope2").css('display','none');
		} else if ($('#con_tope').val()==2) {
			$("#tope0").css('display','none');$(".tope1").css('display','none');$("#tope2").css('display','');
		}
	});	
	$('#mAccion').click(function(e){
		if ($('.oculA').is(":hidden")){
			document.getElementById("tipA").selectedIndex = 0;$(".oculA").css('display','');$(".verA").css('display','none');
			$(".tr1").css('color', '#FFF');$('#mAccion').attr('title', 'ver mas opciones');$("#mAccion").val("+Acciones"); 
			$(".tr1").css('background', '#0084B4');$("#afiltro").css('display','');$("#aloteri, .verB").css('display','none');}
		else { $(".oculA").css('display','none'); $(".verA").css('display','');$("#mAccion").val("Ocultar");
			$(".tr1").css('background', '#FEFCE7');$(".tr1").css('color', '#333'); $("#afiltro").css('display','none');
			$('#mAccion').attr('title', 'ocultar opciones');}
		return false;
	});
	$('#tipA').change(function(){
		if ($('#tipA').val()==0) {
			$("#diaA").css('display','');$("#horsA, #ptrA, #pteA, #statA, #totrA, #toteA").css('display','none');
		} else if ($('#tipA').val()==1) {
			$("#horsA").css('display','');$("#diaA, #ptrA, #pteA, #statA, #totrA, #toteA").css('display','none');
		} else if ($('#tipA').val()==2) {
			$("#ptrA").css('display','');$("#diaA, #pteA, #horsA, #statA, #totrA, #toteA").css('display','none');$("#triA").focus();
		} else if ($('#tipA').val()==3) {
			$("#pteA").css('display','');$("#diaA, #ptrA, #horsA, #statA, #totrA, #toteA").css('display','none');$("#terA").focus();
		} else if ($('#tipA').val()==4) {
			$("#statA").css('display','');$("#diaA, #ptrA, #horsA, #pteA, #totrA, #toteA").css('display','none');
		} else if ($('#tipA').val()==5) {
			$("#totrA").css('display','');$("#statA, #diaA, #ptrA, #horsA, #pteA, #toteA").css('display','none');$("#toptrA").focus();
		} else if ($('#tipA').val()==6) {
			$("#toteA").css('display','');$("#statA, #diaA, #ptrA, #horsA, #pteA, #totrA").css('display','none');$("#topteA").focus();
		} 
		else {$("#od_sorteo, #statA, #diaA, #ptrA, #horsA, #pteA, #totrA, #toteA").css('display','none');}
		if ($('#tipA').val()>=0 && $('#tipA').val()<=4) {$("#afiltro").css('display','none');$("#aloteri").css('display','');} 
		else { if ($('#tipA').val()>=0) { $("#afiltro").css('display','');$("#aloteri").css('display','none');}
		else {$("#afiltro, #aloteri").css('display','none');}}
	});	
});
var statusEnvio = false;
function chequearEnvio() {if (!statusEnvio) { statusEnvio = true; return true;} else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false; }}
function ValidaSoloNumeros(){if (event.keyCode!=46){if ((event.keyCode<48) || (event.keyCode>57)) event.returnValue=false;}} 
function handleEnter (field, event) {var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode==13) {var i;for (i = 0; i<field.form.elements.length; i++) if (field==field.form.elements[i]) break; i=(i+1) % field.form.elements.length;field.form.elements[i].focus();return false;}else return true;} 
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<div class="container">
		<div class="header" style="height:100px; background:#0084B4">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
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
              EDITAR DISTRIBUIDOR<br/>
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
					<form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();"
                    	style="margin:0">
						<table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr valign="baseline">
								<td height="52" colspan="10" align="center" valign="middle" nowrap 
									style="background:#333333; font-size:24px; color: #FFF">
									<strong>DATOS Y OPCIONES DE DISTRIBUIDOR</strong>
								</td>
							</tr>
						</table>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td colspan="5" style="font-size:10px;border-bottom:1px solid  #D5D5D5;" height="45" align="center">
                                	Distribuidor:<br />
									<?php echo '<font size="5">--- '.$row_Recordset1['nom_banca'].' ---</font>'; ?>
                                </td>
							</tr>
							<tr class="oculA">
								<td width="21%">Resultados loterias:<br />
								  <select name="mod_resultado" style="width:160px; height: auto" class="textbox"> 
										<option value="1" <?php
                                            if (!(strcmp(1, htmlentities($row_Recordset1['mod_resultado'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>AUTOMATICO</option>
                                      	<option value="0" <?php
                                            if (!(strcmp(0, htmlentities($row_Recordset1['mod_resultado'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>MANUAL</option>
                                    </select>
								</td>
                            	<td width="16%">Costo Sistema:<br />
                                  <input type="text" name="por_lot" class="textbox" style="height:auto; width:50px" 
                                    value="<?php echo htmlentities($row_Recordset1['por_banca_lot'], ENT_COMPAT, 'utf-8'); ?>" 
                                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                                    onKeyUp="return handleEnter(this, event)" tabindex="1" max="100"/>%
                                </td>
								<td width="22%" valign="top">Control Tope:<br/>
                                	<?php $con_tope=$row_Recordset1['con_tope']; ?>
								  <select name="con_tope" id="con_tope" style="width:190px; height: auto;" 
                                  	class="textbox"> 
										<option value="0" <?php
                                            if (!(strcmp(0, htmlentities($row_Recordset1['con_tope'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>POR AGENTES</option>
                                      	<option value="1" <?php
                                            if (!(strcmp(1, htmlentities($row_Recordset1['con_tope'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>POR SORTEO</option>
                                      	<option value="2" <?php
                                            if (!(strcmp(2, htmlentities($row_Recordset1['con_tope'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>GLOBAL</option>
                                    </select>
                                </td>
                            	<td width="31%" valign="top"><?php
                                    if ($row_Recordset1['con_tope']==0) {
                                        $d0="";
                                        $d1="none";
                                        $d2="none";
                                    } elseif ($row_Recordset1['con_tope']==1) {
                                            $d0="none";
                                            $d1="";
                                            $d2="none";
                                        } elseif ($row_Recordset1['con_tope']==2) {
                                                $d0="none";
                                                $d1="none";
                                                $d2="";
                                            }
                                    echo '<div id="tope0" style="display:'.$d0.';text-align:center">';
                                        echo '<font size="2" color="red">';
                                        echo "<strong>NOTA:</strong><br/>";
                                        echo "Los topes de triples y terminales se configuran en el modulo agente de loterias";
                                        echo '</font>';
                                    echo '</div>';
                                    echo '<div id="tope2" style="display:'.$d2.'; font-size:14px;text-align:center">';?>
                                    	<div style="float:left;width:115px;text-align:center">&nbsp;
                                        Topes triples:<br/>&nbsp;
										<input type="text" name="top_triple_lot" style="height:30px;width:85px;font-size:16px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique tope maximo de triple" onKeyUp="return handleEnter(this, event)" value="<?php echo $row_Recordset1['top_triple_lot']; ?>"><?php
                                        ?>
                                        </div>
                                        <div style="float:left;text-align:center">&nbsp;
                                        Topes terminales:<br/>&nbsp;
										<input type="text" name="top_terminal_lot" style="height:30px;width:85px;font-size:16px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique tope maximo de terminal" onKeyUp="return handleEnter(this, event)" value="<?php echo $row_Recordset1['top_terminal_lot']; ?>">
										</div><?php
                                    echo '</div>';?>
                                </td>
								<td width="10%">
									<input type="submit" name="guardarDis" class="btn btn-primary noefec" value="GUARDAR" 
                                    	style="width:80px; height:auto;font-size:12px; margin:5px;" 
                                        title="guardar datos de distribuidor" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="cod_banca" value="<?php echo $xCodigo;?>"/>
						<input type="hidden" name="MM_update" value="form1"/>
					</form>
                      <table width="100%" border="0" style="font-size:12px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;text-align:center" cellpadding="0" cellspacing="0">
						<form action="<?php echo $editFormAction; ?>" method="POST" name="formo" id="formo" 
							autocomplete="off" onsubmit="return chequearEnvio();">
							<tr style="background:#0084B4;color:#FFFFFF" valign="bottom" class="tr1">
                                <td align="left" valign="bottom" nowrap colspan="6" 
                                    style="font-size:18px;padding:5px 0 5px 10px; display:none" id="filtro">
                                    <div style="display: block">
                                    	<div style="float:left;width:100%;display:none" class="verA">
                                        TIPO DE ACCION:<br/>
                                            <select name="tipA" id="tipA" style="width:280px; height:18; font-size:12px" 
                                                class="textbox"> 
                                                <option value="-1">Seleccione</option>
                                                <option value="0">CAMBIAR DIAS DE JUEGO</option>
                                                <option value="1">CAMBIAR TIEMPO DE CIERRE</option>
                                                <option value="2">CAMBIAR PREMIO DE TRIPLE</option>
                                                <option value="3">CAMBIAR PREMIO DE TERMINAL</option>
                                                <option value="4">CAMBIAR STATUS DE LOTERIA</option><?php
                                                if ($con_tope==1) {?>
                                                	<option value="5">CAMBIAR TOPE DE TRIPLES (Sorteo)</option>
                                                    <option value="6">CAMBIAR TOPE DE TERMINALES (Sorteo)</option><?php
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
                                                    <option value="<?php echo $row_Recordset3['id_banlot'];?>">
                                                    <?php echo $row_Recordset3['nom_loteria']?></option><?php
                                                } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
                                            </select>
                                            </div>
                                        </div>
                                        <div style="float:left; margin:0 0 0 5px;" class="oculA">
                                        <input type="submit" value="Filtrar" class="btn btn-danger noefec" title="iniciar busqueda" 
                                            style="width:80px; height:30px;"/>
                                        </div>
                                    </div>
                                    <input type="hidden" name="MM_inserto" value="formo"/>
                                </td>
                                <td width="18%" style="font-size:12px;" valign="middle" align="left">
                                    <input type="submit" id="mAccion" value="+Acciones" class="btn btn-warning noefec" 
                                    	title="ver mas opciones" style="width:80px; height:30px; display:none"/>
                                </td>
							
                          </tr>
                          <tr>
							<td colspan="7" style="background:#FEFCE7;font-size:16px;color:#333">
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
                                        <div id="ptrA" style="float:left;display:none;width:100%" class="verB">
                                        	INDIQUE PREMIO A TRIPLE:<br/>
                                        	<input type="text" name="triA" id="triA" 
                                            style="height:20px;width:85px;font-size:12px;text-align:right;padding:0;margin:1px 0 0 0"
                                            onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al triple" 
                                            onKeyUp="return handleEnter(this, event)" value="">
                                        </div>
                                        <div id="pteA" style="float:left;display:none;width:100%" class="verB">
                                        	INDIQUE PREMIO A TERMINAL:<br/>
                                        	<input type="text" name="terA" id="terA" 
                                            style="height:20px;width:85px;font-size:12px;text-align:right;padding:0;margin:1px 0 0 0"
                                            onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al triple" 
                                            onKeyUp="return handleEnter(this, event)" value="">
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
						</table>
					</div>
                    <div style="display: block">
						<table width="100%" border="0" style="font-size:12px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;text-align:center" cellpadding="0" cellspacing="0">
							<tr style="background:#FFF;color:#FFFFFF;letter-spacing: -1px;line-height: 1" valign="bottom">
								<td colspan="7" style="font-size:12px"> ____</td>
							</tr>
							<tr style="background:#0084B4;color:#FFFFFF;letter-spacing: -1px;line-height: 1" valign="bottom">
                                <td width="22%" style="font-size:12px">SORTEOS</td>
                                <td width="21%" style="font-size:12px">LOTERIAS</td>
                                <td width="15%" style="font-size:11px">DIAS<br/>LU-MA-MI-JU-VI-SA-DO</td>
                                <td width="12%" style="font-size:12px">MINUTOS DE CIERRE<br/>ANTES DEL SORTEO</td>
                                <td width="10%" style="font-size:12px">PREMIO<br/>TRIPLE</td>
                                <td width="10%" style="font-size:12px">PREMIO<br/>TERMINAL</td>
                                <td width="10%" style="font-size:12px">STATUS</td>
							</tr>
						</table>
						<?php
                        $sorteo="";$c=0;$cambio=1;
                        $nom_sorteo=$row_Recordset1['nom_sorteo'];
                        do {
                            $min_cierre=calcular_tiempo_trasnc($row_Recordset1['hor_sorteo'], $row_Recordset1['hor_cierre']);
                            if ($sorteo!=$row_Recordset1['nom_sorteo']) {
                                if ($c>0) {
                                    echo '<table width="100%" border="0">';
                                    echo '<tr valign="top" align="right">';
                                    echo '<td width="40%" align="left">';
                                    echo '<div class="tope1" style="display:'.$d1.';color:#FFF;background:#333;">';
                                    echo '<div style="float:left;font-size:13px;width:120px;padding:0 0 5px 2px;background:#333">';
                                    if ($tipoActual>3) {
                                        echo 'TOPE VENTA:<br/>';
                                    } else {
                                        echo 'TOPE TRIPLE:<br/>';
                                    } ?>
												<input type="text" name="top_triple_sorteo" style="height:18px;width:85px;font-size:12px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al triple" onKeyUp="return handleEnter(this, event)" value="<?php echo $topeTripleSorteo; ?>"><?php
                                                
                                                
                                            echo '</div>';
                                    if ($tipoActual<4) {
                                        echo '<div style="float:left;font-size:13px;width:120px;padding:0 0 5px 2px;background:#333">';
                                        echo 'TOPE TERMINAL:<br/>'; ?>
													<input type="text" name="top_terminal_sorteo" style="height:18px;width:85px;font-size:12px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al triple" onKeyUp="return handleEnter(this, event)" value="<?php echo $topeTerminalSorteo; ?>"><?php
                                                echo '</div>';
                                    } else {?>
												<input type="hidden" name="top_terminal_sorteo" value="0"><?php
                                            }
                                    echo '</div>';
                                    echo '</td>';

                                    echo '<td width="60%" valign="bottom" class="oculA">'; ?>
                                            <input type="submit" name="guardar" class="btn btn-success noefec" 
                                            style="width:140px; height:30px; font-size:12px; margin:5px" value="GUARDAR CAMBIOS"
                                            title="&nbsp;guardar cambios<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo; ?>" /><?php
                                        echo '</td>';
                                    echo '</tr>';
                                    echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                                    echo '<td colspan="2">';
                                    echo '</td>';
                                    echo '</tr>';
                                    echo '</table>';
                                    echo '</form>';
                                }
                                $cambio=1;
                                $nom_sorteo=$row_Recordset1['nom_sorteo'];
                            }
                            if ($cambio==1) {
                                echo '<form method="post" action="'.$editFormAction.'" onsubmit="return chequearEnvio();" style="margin:0; padding:0">';
                            } ?>
							<table width="100%" border="0" style="font-size:12px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;text-align:center;line-height:-1;" cellpadding="0" cellspacing="0">
								<tr valign="bottom">
                                    <td width="22%" align="left" style="font-size:12px;" title="nombre de sorteo">
                                        <?php
                                        if ($sorteo!=$row_Recordset1['nom_sorteo']) {
                                            echo "<strong>&nbsp;".$row_Recordset1['nom_sorteo']."</strong><br/>";
                                            echo "&nbsp;Hora Sorteo:".cambioHoramysql($row_Recordset1['hor_sorteo']);
                                            $sorteo=$row_Recordset1['nom_sorteo'];
                                            echo '<input type="hidden" name="sorteo" value="'.$sorteo.'"/>';
                                            $tipoActual=$row_Recordset1['tip_loteria'];
                                            
                                            $topeTripleSorteo=$row_Recordset1['top_venta'];
                                            $topeTerminalSorteo=$row_Recordset1['top_venta_terminal'];
                                        }
                            if ($row_Recordset1['est_banlot']==1) {
                                $color="#E1E1E1";
                            } else {
                                $color="#FFB7B8";
                            } ?>
                                    </td>
                                    <td width="78%" align="left" style="font-size:12px;">
                                        <table width="100%" border="0" style="font-size:12px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;text-align:center; background:<?php echo $color; ?>" cellpadding="0" cellspacing="0">
                                            <tr class="brillo" style="border-bottom:1px solid  #D5D5D5;line-height:-1;" >
                                                <td width="27%" title="nombre de loteria">
													<?php echo "&nbsp;".$row_Recordset1['nom_loteria']; ?>
                                                </td>
                                                <td width="20%">
                                                    <input type="checkbox" name="lun<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['lun_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> title="lunes"/>
                                                    <input type="checkbox" name="mar<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['mar_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> title="martes"/>
                                                    <input type="checkbox" name="mie<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['mie_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> title="miercoles"/>
                                                    <input type="checkbox" name="jue<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['jue_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> title="jueves"/>
                                                    <input type="checkbox" name="vie<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['vie_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> title="viernes"/>
                                                    <input type="checkbox" name="sab<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['sab_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> title="sabado"/>
                                                    <input type="checkbox" name="dom<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['dom_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                echo "checked=\"checked\"";
                            } ?> title="domingo"/>
                                                </td>
                                                <td width="15%" title="cerrar loteria minutos antes del sorteo">
                                                    <select name="min_cierre[]"
                                                        style="width:70px;height:22px;font-size:12px;padding:0;margin:1px 0 0 0">
                                                        <?php for ($i = 0; $i <= 60; $i=$i+5) {
                                if ($i<10) {
                                    $v="0".$i;
                                } else {
                                    $v=$i;
                                } ?>
                                                      <option value="<?php echo $i; ?>" <?php
                                                            if (!(strcmp($i, htmlentities($min_cierre, ENT_COMPAT, 'utf-8')))) {
                                                                echo "SELECTED";
                                                            } ?>><?php echo $v." min"; ?>
                                                      </option>
                                                       <?php
                            } ?>
                                                    </select>
                                                </td>
                                                <td width="13%" title="premio de triple">
                                                    <input type="text" name="pre_triple[]" style="height:20px;width:85px;font-size:12px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al triple" onKeyUp="return handleEnter(this, event)" value="<?php echo $row_Recordset1['pre_loteria']; ?>">   
                                                </td>
                                                <td width="13%" title="premio de terminal">
												  <?php if ($row_Recordset1['tip_loteria']<4) {?>
                                                        <input type="text" name="pre_terminal[]" style="height:20px;width:85px;font-size:12px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al terminal" onKeyUp="return handleEnter(this, event)" value="<?php echo $row_Recordset1['pre_terminal']; ?>">
                                                  <?php } else { ?>  
                                                        <input type="hidden" name="pre_terminal[]" value="0">
                                                  <?php } ?>
                                                </td>
                                                <td width="12%" title="status de loteria">
                                                    <select name="est_loteria[]" class="textbox" style="width:80px; height:22px; font-size:12px; padding:0; margin:1px 0 0 0;"> 
                                                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['est_banlot'], ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>ACTIVO</option>
                                                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['est_banlot'], ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>INACTIVO</option>
                                                    </select>
										<input type="hidden" name="idtr_banlot[]"
                                        	value="<?php echo $row_Recordset1['id_banlot']; ?>"/>
										<input type="hidden" name="idte_banlot[]"
                                        	value="<?php echo $row_Recordset1['id_banlot_ter']; ?>"/>
                                        <input type="hidden" name="tip_loteria[]" 
                                        	value="<?php echo $row_Recordset1['tip_loteria']; ?>"/>
                                        <input type="hidden" name="nom_loteria[]" 
                                        	value="<?php echo $row_Recordset1['nom_loteria']; ?>"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
								</tr>
							</table>
							
							<?php
                            $c++;
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                                    echo '<table width="100%" border="0">';
                                        echo '<tr valign="top" align="right">';
                                        echo '<td width="40%" align="left">';
                                        echo '<div class="tope1" style="display:'.$d1.';color:#FFF;background:#333;">';
                                            echo '<div style="float:left;font-size:13px;width:120px;padding:0 0 5px 2px;background:#333">';
                                                if ($tipoActual>3) {
                                                    echo 'TOPE VENTA:<br/>';
                                                } else {
                                                    echo 'TOPE TRIPLE:<br/>';
                                                }?>
												<input type="text" name="top_triple_sorteo" style="height:18px;width:85px;font-size:12px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al triple" onKeyUp="return handleEnter(this, event)" value="<?php echo $topeTripleSorteo; ?>"><?php
                                                
                                                
                                            echo '</div>';
                                            if ($tipoActual<4) {
                                                echo '<div style="float:left;font-size:13px;width:120px;padding:0 0 5px 2px;background:#333">';
                                                echo 'TOPE TERMINAL:<br/>'; ?>
													<input type="text" name="top_terminal_sorteo" style="height:18px;width:85px;font-size:12px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al triple" onKeyUp="return handleEnter(this, event)" value="<?php echo $topeTerminalSorteo; ?>"><?php
                                                echo '</div>';
                                            } else {?>
												<input type="hidden" name="top_terminal_sorteo" value="0"><?php
                                            }
                                        echo '</div>';
                                        echo '</td>';

                                        echo '<td width="60%" valign="bottom" class="oculA">';?>
                                            <input type="submit" name="guardar" class="btn btn-success noefec" 
                                            style="width:140px; height:30px; font-size:12px; margin:5px" value="GUARDAR CAMBIOS"
                                            title="&nbsp;guardar cambios<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo;?>" /><?php
                                        echo '</td>';
                                        echo '</tr>';
                                        echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                                        echo '<td colspan="2">';
                                        echo '</td>';
                                        echo '</tr>';
                                    echo '</table>';
                                    echo '</form>';
                        ?>
				</div><?php
                } else {?>
					<div style="font-size:24px; text-align:center; line-height:1; padding:120px 0 ; 
                    	font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
                    	ATENCION:<br/><br/>LAS OPCIONES DE LOTERIAS PARA ESTE DISTRIBUIDOR<br/>NO HAN SIDO CREADAS
                    
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
                                            <input type="hidden" name="cod_banca" value="<?php echo $xCodigo;?>"/>
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
if (isset($Recordset3)) {
    mysqli_free_result($Recordset3);
}
?>
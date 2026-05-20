<?php
function jNormaHNAC(
    $defi_regla,
    $numCab,
    $codigoCarrera,
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
) {
    if (is_file('../Connections/conexionbanca.php')) {
        require_once('../Connections/conexionbanca.php');
    }
    global $conexionbanca;
    $montoapagar[0]=0; //monto a pagar
    $montoapagar[1]="2"; // estado del ticket 2=pago con dividendo	5=pago devuelto
    $dPago=0;
    if ($defi_regla==0) {
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\includes\calculodepago_hnac.php - QUERY 1 */ SELECT re.div_pago_hnac, ic.est_favorito_hnac 
			FROM resultados_hnac re, inscritos ic
			WHERE
			re.cod_carrera_hnac = ic.cod_carrera_hnac AND re.num_caballo_hnac = ic.num_caballo_hnac AND
			re.num_caballo_hnac = %s AND re.cod_carrera_hnac = %s AND re.fec_resultado_hnac = %s AND
			re.cod_taquilla = %s AND re.cod_tventa_hnac = %s LIMIT 1",
            GetSQLValueString($numCab, "text"),
            GetSQLValueString($codigoCarrera, "int"),
            GetSQLValueString($fecCarrera, "date"),
            GetSQLValueString($taqVenta, "int"),
            GetSQLValueString($tipVenta, "int")
        );
    } else {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\calculodepago_hnac.php - QUERY 2 */ SELECT ic.est_inscrito_hnac 
			FROM inscritos ic
			WHERE ic.est_inscrito_hnac = 1 AND ic.cod_carrera_hnac = %s",
            GetSQLValueString($codigoCarrera, "int")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $tEjem = mysqli_num_rows($Recordset2);
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\includes\calculodepago_hnac.php - QUERY 3 */ SELECT re.div_pago_hnac, ic.est_favorito_hnac, re.est_empate_hnac 
			FROM resultados_oficiales_hnac re, inscritos ic
			WHERE
			re.cod_carrera_hnac = ic.cod_carrera_hnac AND re.num_caballo_hnac = ic.num_caballo_hnac AND
			re.num_caballo_hnac = %s AND re.cod_carrera_hnac = %s AND re.fec_resultado_hnac = %s AND
			re.cod_tventa_hnac = %s LIMIT 1",
            GetSQLValueString($numCab, "text"),
            GetSQLValueString($codigoCarrera, "int"),
            GetSQLValueString($fecCarrera, "date"),
            GetSQLValueString($tipVenta, "int")
        );
    }
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $div_oficial=$row_Recordset1['div_pago_hnac'];
        $montoapagar[2]=$div_oficial;
        list($tRec, $pFijo)=pFijoEjemplarHNAC($numCab, $codigoCarrera, $taqVenta);
        if ($defi_regla==1 && ($tRec==0 or $pFijo==0)) {
            //echo $div_oficial.">=".$regla2_desd." y ".$div_oficial."<=".$regla2_hast." y ".$tEjem.">=".$regla2_EjeD." y ".$tEjem."<=".$regla2_EjeH." y ".$row_Recordset1['est_empate_hnac']."==".$emp_regla2;
            if ($div_oficial>=$regla1_desd && $div_oficial<=$regla1_hast && $tEjem>=$regla1_EjeD && $tEjem<=$regla1_EjeH &&
                    $row_Recordset1['est_empate_hnac']==$emp_regla1) {
                if ($regla1_opci==0) { // +
                    $dPago=(($regla1_paga/10)+($div_oficial/10));
                }
                if ($regla1_opci==1) { //=
                    $dPago=$regla1_paga/10;
                }
            } elseif ($div_oficial>=$regla2_desd && $div_oficial<=$regla2_hast && $tEjem>=$regla2_EjeD &&
                    $tEjem<=$regla2_EjeH && $row_Recordset1['est_empate_hnac']==$emp_regla2) {
                if ($regla2_opci==0) {
                    $dPago=(($regla2_paga/10)+($div_oficial/10));
                }
                if ($regla2_opci==1) {
                    $dPago=$regla2_paga/10;
                }
            } elseif ($div_oficial>=$regla3_desd && $div_oficial<=$regla3_hast  && $tEjem>=$regla3_EjeD &&
                        $tEjem<=$regla3_EjeH && $row_Recordset1['est_empate_hnac']==$emp_regla3) {
                if ($regla3_opci==0) {
                    $dPago=(($regla3_paga/10)+($div_oficial/10));
                }
                if ($regla3_opci==1) {
                    $dPago=$regla3_paga/10;
                }
            } elseif ($div_oficial>=$regla4_desd && $div_oficial<=$regla4_hast && $tEjem>=$regla4_EjeD &&
                        $tEjem<=$regla4_EjeH && $row_Recordset1['est_empate_hnac']==$emp_regla4) {
                if ($regla4_opci==0) {
                    $dPago=(($regla4_paga/10)+($div_oficial/10));
                }
                if ($regla4_opci==1) {
                    $dPago=$regla4_paga/10;
                }
            } elseif ($div_oficial>=$regla5_desd && $div_oficial<=$regla5_hast && $tEjem>=$regla5_EjeD &&
                            $tEjem<=$regla5_EjeH && $row_Recordset1['est_empate_hnac']==$emp_regla5) {
                if ($regla5_opci==0) {
                    $dPago=(($regla5_paga/10)+($div_oficial/10));
                }
                if ($regla5_opci==1) {
                    $dPago=$regla5_paga/10;
                }
            } elseif ($div_oficial>=$regla6_desd && $div_oficial<=$regla6_hast && $tEjem>=$regla6_EjeD &&
                            $tEjem<=$regla6_EjeH && $row_Recordset1['est_empate_hnac']==$emp_regla6) {
                if ($regla6_opci==0) {
                    $dPago=(($regla6_paga/10)+($div_oficial/10));
                }
                if ($regla6_opci==1) {
                    $dPago=$regla6_paga/10;
                }
            } elseif ($div_oficial>=$regla7_desd && $div_oficial<=$regla7_hast && $tEjem>=$regla7_EjeD &&
                              $tEjem<=$regla7_EjeH && $row_Recordset1['est_empate_hnac']==$emp_regla7) {
                if ($regla7_opci==0) {
                    $dPago=(($regla7_paga/10)+($div_oficial/10));
                }
                if ($regla7_opci==1) {
                    $dPago=$regla7_paga/10;
                }
            } elseif ($div_oficial>=$regla8_desd && $div_oficial<=$regla8_hast && $tEjem>=$regla8_EjeD &&
                                $tEjem<=$regla8_EjeH && $row_Recordset1['est_empate_hnac']==$emp_regla8) {
                if ($regla8_opci==0) {
                    $dPago=(($regla8_paga/10)+($div_oficial/10));
                }
                if ($regla8_opci==1) {
                    $dPago=$regla8_paga/10;
                }
            }
            if ($row_Recordset1['est_favorito_hnac']==1 || $row_Recordset1['est_favorito_hnac']==2 ||
                    $row_Recordset1['est_favorito_hnac']==3) {
                if ($row_Recordset1['est_favorito_hnac']==1) {
                    if ($dPago>($tope1/10)) {
                        $dPago=$tope1/10;
                    }
                }
                if ($row_Recordset1['est_favorito_hnac']==2) {
                    if ($dPago>($tope2/10)) {
                        $dPago=$tope2/10;
                    }
                }
                if ($row_Recordset1['est_favorito_hnac']==3) {
                    if ($dPago>($tope3/10)) {
                        $dPago=$tope3/10;
                    }
                }
            } elseif ($dPago>($tope4/10)) {
                $dPago=$tope4/10;
            }
        } else {
            if ($tRec>0 && $pFijo>0) {
                $dPago=$pFijo/10;
            } else {
                $dPago=$row_Recordset1['div_pago_hnac']/10;
            }
        }
        $montoapagar[0]=$monVenta*$dPago;
    }
    if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }
    if (isset($Recordset2)) {
        mysqli_free_result($Recordset2);
    }
    return $montoapagar;
}
function jNormaSimpleHNAC(
    $numCab,
    $codigoCarrera,
    $fecCarrera,
    $monVenta,
    $taqVenta,
    $tipVenta
) {
    if (is_file('../Connections/conexionbanca.php')) {
        require_once('../Connections/conexionbanca.php');
    }
    global $conexionbanca;
    $montoapagar[0]=0; //monto a pagar
    $montoapagar[1]="2";
    $dPago=0;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\calculodepago_hnac.php - QUERY 4 */ SELECT re.div_pago_hnac, ic.est_favorito_hnac 
		FROM resultados_hnac re, inscritos ic
		WHERE
		re.cod_carrera_hnac = ic.cod_carrera_hnac AND re.num_caballo_hnac = ic.num_caballo_hnac AND
		re.num_caballo_hnac = %s AND re.cod_carrera_hnac = %s AND re.fec_resultado_hnac = %s AND
		re.cod_taquilla = %s AND re.cod_tventa_hnac = %s",
        GetSQLValueString($numCab, "text"),
        GetSQLValueString($codigoCarrera, "int"),
        GetSQLValueString($fecCarrera, "date"),
        GetSQLValueString($taqVenta, "int"),
        GetSQLValueString($tipVenta, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        list($tRec, $pFijo)=pFijoEjemplarHNAC($numCab, $codigoCarrera, $taqVenta);
        if ($tRec>0) {
            $dPago=$pFijo/10;
        } else {
            $dPago=$row_Recordset1['div_pago_hnac']/10;
        }
        $montoapagar[0]=$monVenta*$dPago;
    }
    if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }
    return $montoapagar;
}
function pFijoEjemplarHNAC($numCab, $codigoCarrera, $taqVenta)
{
    if (is_file('../Connections/conexionbanca.php')) {
        require_once('../Connections/conexionbanca.php');
    }
    global $conexionbanca;
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 new\includes\calculodepago_hnac.php - QUERY 5 */ SELECT pr.pre_fijo_hnac 
		FROM 
			inscritos ic, precio_fijo_hnac pr
		WHERE
			ic.num_caballo_hnac = %s AND
			ic.cod_carrera_hnac = %s AND
			pr.cod_inscrito_hnac = ic.cod_inscrito_hnac AND
			pr.cod_taquilla = %s AND
			pr.cod_carrera_hnac = ic.cod_carrera_hnac",
        GetSQLValueString($numCab, "int"),
        GetSQLValueString($codigoCarrera, "int"),
        GetSQLValueString($taqVenta, "int")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    $tRec=$totalRows_Recordset2;
    if ($totalRows_Recordset2>0) {
        $pFijo=$row_Recordset2['pre_fijo_hnac'];
    } else {
        $pFijo=0;
    }
    if (isset($Recordset2)) {
        mysqli_free_result($Recordset2);
    }
    return array($tRec,$pFijo);
}

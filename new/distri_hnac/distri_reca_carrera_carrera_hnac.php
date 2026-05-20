<?php
require_once('../Connections/conexionbanca.php');
if (!isset($codagencia) && isset($_POST["codAge"])) {
    $codagencia=$_POST["codAge"];
} elseif (!isset($codagencia)) {
    $codagencia="";
}
if (!isset($codcarrera) && isset($_POST["codCar"])) {
    $codcarrera=$_POST["codCar"];
} elseif (!isset($codcarrera)) {
    $codcarrera="";
}
if (!isset($codHipodromo) && isset($_POST["codHipodromo"])) {
    $codHipodromo=$_POST["codHipodromo"];
} elseif (!isset($codHipodromo)) {
    $codHipodromo="";
}
if (!isset($in) && isset($_POST["fecCar"])) {
    $in=fechaymd($_POST["fecCar"]);
} elseif (!isset($in)) {
    $in="";
}
if (!isset($cod_banca) && isset($_POST["codBan"])) {
    $cod_banca=$_POST["codBan"];
} elseif (!isset($cod_banca)) {
    $cod_banca="";
}
$GanPer=0;
//echo "banca:".$cod_banca." agencia:".$codagencia." - carrera:".$codcarrera." - hipodromo:".$codHipodromo;
if (($codagencia>0 or $codagencia=="todos") && ($codcarrera>0 or $codcarrera=="todas") && $in!="" && $codHipodromo!=-1 && $codHipodromo!="") {
    $totApuesta=0;
    $totxPagar=0;
    $totPagado=0;
    $exoApuestas=0;
    $exoPagado=0;
    $exoPorpagar=0;
    $result=0;
    if ($codcarrera!="todas") {
        $query_Recordset7 = sprintf(
            "/* PARSEADORES1 new\distri_hnac\distri_reca_carrera_carrera_hnac.php - QUERY 1 */ SELECT 
			ca.can_caballos_hnac, 
			ca.cod_carrera_hnac, 
			ca.est_carrera_hnac, 
			ca.est_cierre_hnac, 
			ca.est_confirmacion_hnac
		FROM carrera_hnac ca
		WHERE fec_carrera_hnac = %s AND cod_carrera_hnac = %s
		LIMIT 1",
            GetSQLValueString($in, "date"),
            GetSQLValueString($codcarrera, "int")
        );
        $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
        $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
        $totalRows_Recordset7 = mysqli_num_rows($Recordset7);
        $result=1;
    } else {
        $query_Recordset7 = sprintf(
            "/* PARSEADORES1 new\distri_hnac\distri_reca_carrera_carrera_hnac.php - QUERY 2 */ SELECT 
			ca.can_caballos_hnac, 
			ca.cod_carrera_hnac, 
			ca.est_carrera_hnac, 
			ca.est_cierre_hnac, 
			ca.est_confirmacion_hnac
		FROM carrera_hnac ca, 
			hipodromo_hnac hi
		WHERE 
			ca.fec_carrera_hnac = %s AND 
			hi.cod_hipodromo_hnac = %s AND
			ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac
		ORDER BY can_caballos_hnac DESC",
            GetSQLValueString($in, "date"),
            GetSQLValueString($codHipodromo, "int")
        );
        $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
        $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
        $totalRows_Recordset7 = mysqli_num_rows($Recordset7);
    }
    if ($totalRows_Recordset7>0) {
        do {
            if ($totalRows_Recordset7==1) {
                if (($row_Recordset7['est_carrera_hnac']==0 && $row_Recordset7['est_cierre_hnac']==0) or
                    ($row_Recordset7['est_carrera_hnac']==0 && $row_Recordset7['est_cierre_hnac']==1)) {
                    $est_confirmacion=' <font color="#000000">CERRADA</font> ';
                } elseif ($row_Recordset7['est_cierre_hnac']==3) {
                    $est_confirmacion=' ABIERTA ';
                } else {
                    $est_confirmacion=' <font color="#000000">CERRADA</font> ';
                }
                $query_Recordset10 = sprintf(
                    "/* PARSEADORES1 new\distri_hnac\distri_reca_carrera_carrera_hnac.php - QUERY 3 */ SELECT 
					re.cod_tventa_hnac,
					re.num_caballo_hnac,
					re.div_pago_hnac,
					re.fac_div_hnac
				FROM 
					resultados_oficiales_hnac re
				WHERE 
					re.cod_carrera_hnac = %s
				ORDER BY re.cod_tventa_hnac ASC",
                    GetSQLValueString($codcarrera, "int")
                );
                $Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
                $row_Recordset10 = mysqli_fetch_assoc($Recordset10);
                $totalRows_Recordset10 = mysqli_num_rows($Recordset10);
                $cta1=0;
                $cta2=0;
                $cta3=0;
                $cta4=0;
                $eje_primero="";
                $div_primero_gan="";
                $fac_primero_gan="";
                $eje_primero_emp2="";
                $div_primero_emp2_gan="";
                $fac_primero_emp2_gan="";
                $eje_primero_emp3="";
                $div_primero_emp3_gan="";
                $fac_primero_emp3_gan="";
                $eje_segundo="";
                $eje_segundo_emp2="";
                $eje_segundo_emp3="";
                $eje_tercero="";
                $eje_tercero_emp2="";
                $eje_tercero_emp3="";
                $eje_cuarto="";
                $eje_cuarto_emp2="";
                $eje_cuarto_emp3="";
                
                if ($totalRows_Recordset10>0) {
                    do {
                        if ($row_Recordset10['cod_tventa_hnac']==1) {
                            if ($cta1==0) {
                                $eje_primero=$row_Recordset10['num_caballo_hnac'];
                                $div_primero_gan=$row_Recordset10['div_pago_hnac'];
                                $fac_primero_gan=$row_Recordset10['fac_div_hnac'];
                            }
                            if ($cta1==1) {
                                $eje_primero_emp2=$row_Recordset10['num_caballo_hnac'];
                                $div_primero_emp2_gan=$row_Recordset10['div_pago_hnac'];
                                $fac_primero_emp2_gan=$row_Recordset10['fac_div_hnac'];
                            }
                            if ($cta1==3) {
                                $eje_primero_emp3=$row_Recordset10['num_caballo_hnac'];
                                $div_primero_emp3_gan=$row_Recordset10['div_pago_hnac'];
                                $fac_primero_emp3_gan=$row_Recordset10['fac_div_hnac'];
                            }
                            $cta1++;
                        }
                        if ($row_Recordset10['cod_tventa_hnac']==2) {
                            if ($cta2==0) {
                                $eje_segundo=$row_Recordset10['num_caballo_hnac'];
                            }
                            if ($cta2==1) {
                                $eje_segundo_emp2=$row_Recordset10['num_caballo_hnac'];
                            }
                            if ($cta2==2) {
                                $eje_segundo_emp3=$row_Recordset10['num_caballo_hnac'];
                            }
                            $cta2++;
                        }
                        if ($row_Recordset10['cod_tventa_hnac']==3) {
                            if ($cta3==0) {
                                $eje_tercero=$row_Recordset10['num_caballo_hnac'];
                            }
                            if ($cta3==1) {
                                $eje_tercero_emp2=$row_Recordset10['num_caballo_hnac'];
                            }
                            if ($cta3==2) {
                                $eje_tercero_emp3=$row_Recordset10['num_caballo_hnac'];
                            }
                            $cta3++;
                        }
                        if ($row_Recordset10['cod_tventa_hnac']==4) {
                            if ($cta4==0) {
                                $eje_cuarto=$row_Recordset10['num_caballo_hnac'];
                            }
                            if ($cta4==1) {
                                $eje_cuarto_emp2=$row_Recordset10['num_caballo_hnac'];
                            }
                            if ($cta4==2) {
                                $eje_cuarto_emp3=$row_Recordset10['num_caballo_hnac'];
                            }
                            $cta4++;
                        }
                    } while ($row_Recordset10 = mysqli_fetch_assoc($Recordset10));
                }
            }
            $codcarrera=$row_Recordset7['cod_carrera_hnac'];
            for ($numCab = 1; $numCab <= $row_Recordset7['can_caballos_hnac']; $numCab++) {
                if ($codagencia!="todos") {
                    $query_Recordset8 = sprintf(
                        "/* PARSEADORES1 new\distri_hnac\distri_reca_carrera_carrera_hnac.php - QUERY 4 */ SELECT 
						SUM(ve.mon_venta_hnac) AS apuestas,
						SUM(CASE WHEN ve.est_ticket_hnac = 2 
							THEN ve.pag_premio_hnac ELSE 0 END) AS tpremios,
						SUM(CASE WHEN ve.est_ticket_hnac >= 4 AND ve.est_ticket_hnac <= 5
							THEN ve.mon_venta_hnac ELSE 0 END) AS tinvalidos,
							
						SUM(CASE WHEN ve.est_calculo_hnac = 2  AND ve.est_ticket_hnac = 1
							THEN ve.pag_premio_hnac ELSE 0 END) AS tpremiosP,
						SUM(CASE WHEN ve.est_calculo_hnac >= 4 AND ve.est_calculo_hnac <= 5 AND ve.est_ticket_hnac = 1
							THEN ve.mon_venta_hnac ELSE 0 END) AS tinvalidosP
						FROM 
							venta_hnac ve,
							usuario us,
							taquilla ta
							
						WHERE 
							ve.fec_venta_hnac = %s AND 
							ve.cod_carrera_hnac = %s AND
							
							ta.cod_taquilla = %s AND
							us.cod_taquilla = ta.cod_taquilla AND
							ve.id_usuario = us.id_usuario AND
							
							ve.num_caballo_hnac = %s AND
							ve.est_ticket_hnac !=0 AND
							ve.cod_tventa_hnac>0 AND ve.cod_tventa_hnac<=3",
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($codcarrera, "int"),
                        GetSQLValueString($codagencia, "int"),
                        GetSQLValueString($numCab, "text")
                    );
                } else {
                    $query_Recordset8 = sprintf(
                        "/* PARSEADORES1 new\distri_hnac\distri_reca_carrera_carrera_hnac.php - QUERY 5 */ SELECT 
						SUM(ve.mon_venta_hnac) AS apuestas,
						SUM(CASE WHEN ve.est_ticket_hnac = 2 
							THEN ve.pag_premio_hnac ELSE 0 END) AS tpremios,
						SUM(CASE WHEN ve.est_ticket_hnac >= 4 AND ve.est_ticket_hnac <= 5
							THEN ve.mon_venta_hnac ELSE 0 END) AS tinvalidos,
							
						SUM(CASE WHEN ve.est_calculo_hnac = 2 AND est_ticket_hnac = 1
							THEN ve.pag_premio_hnac ELSE 0 END) AS tpremiosP,
						SUM(CASE WHEN ve.est_calculo_hnac >= 4 AND ve.est_calculo_hnac <= 5 AND est_ticket_hnac = 1
							THEN ve.mon_venta_hnac ELSE 0 END) AS tinvalidosP
						FROM 
							venta_hnac ve,
							usuario us,
							taquilla ta,
							agencia ag,
							banca ba
						WHERE 
							ve.fec_venta_hnac = %s AND 
							ve.cod_carrera_hnac = %s AND
							ve.num_caballo_hnac = %s AND
							ve.est_ticket_hnac !=0 AND
							ve.cod_tventa_hnac>0 AND ve.cod_tventa_hnac<=3 AND
							ve.id_usuario = us.id_usuario AND
							us.cod_taquilla = ta.cod_taquilla AND
							ta.cod_agencia = ag.cod_agencia AND
							ag.cod_banca = ba.cod_banca AND
							ba.cod_banca = %s",
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($codcarrera, "int"),
                        GetSQLValueString($numCab, "text"),
                        GetSQLValueString($cod_banca, "int")
                    );
                }
                $Recordset8 = mysqli_query($conexionbanca, $query_Recordset8) or die(mysqli_error($conexionbanca));
                $row_Recordset8 = mysqli_fetch_assoc($Recordset8);
                $totalRows_Recordset8 = mysqli_num_rows($Recordset8);
                $caballos{$numCab}=$numCab;
                if (!isset($apuestas{$numCab})) {
                    $apuestas{$numCab}=$row_Recordset8['apuestas']*1;
                } else {
                    $apuestas{$numCab}+=$row_Recordset8['apuestas']*1;
                }
                if (!isset($pagado{$numCab})) {
                    $pagado{$numCab}=($row_Recordset8['tpremios']+$row_Recordset8['tinvalidos'])*1;
                } else {
                    $pagado{$numCab}+=($row_Recordset8['tpremios']+$row_Recordset8['tinvalidos'])*1;
                }
                if (!isset($porpagar{$numCab})) {
                    $porpagar{$numCab}=($row_Recordset8['tpremiosP']+$row_Recordset8['tinvalidosP'])*1;
                } else {
                    $porpagar{$numCab}+=($row_Recordset8['tpremiosP']+$row_Recordset8['tinvalidosP'])*1;
                }
            }
        } while ($row_Recordset7 = mysqli_fetch_assoc($Recordset7));
    } ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody><?php
            foreach ($caballos as $cab) {
                if ($cab>25) {
                    break;
                } ?>
				<tr class="brillo" style="border-bottom:1px solid  #D5D5D5; font-size:12px;">
					<td width="4%" >&nbsp;</td>
					<td width="10%"  align="right" >#<?php echo $cab; ?></td>
                    <td width="22%"  align="right"><?php echo number_format($apuestas{$cab}, 2, ",", "."); ?></td>
					<td width="22%"  align="right"><?php echo number_format($porpagar{$cab}, 2, ",", "."); ?></td>
					<td width="22%"  align="right"><?php echo number_format($pagado{$cab}, 2, ",", "."); ?></td>
					<td width="20%" >&nbsp;</td>
				</tr><?php
                $totApuesta+=$apuestas{$cab};
                $totxPagar+=$porpagar{$cab};
                $totPagado+=$pagado{$cab};
            }
    $totApuesta+=$exoApuestas;
    $totxPagar+=$exoPorpagar;
    $totPagado+=$exoPagado;
    $GanPer=$totApuesta-($totxPagar+$totPagado); ?>
			<tr>
				<td height="39" bgcolor="#E0E0E0">&nbsp;</td>
				<td rowspan="3" align="right" valign="middle" bgcolor="#E0E0E0">TOTALES:</td>
				<td align="right" valign="bottom" bgcolor="#E0E0E0">
					<?php echo number_format($totApuesta, 2, ",", "."); ?>
				</td>
				<td align="right" valign="bottom" bgcolor="#E0E0E0">
					<?php echo number_format($totxPagar, 2, ",", "."); ?>
				</td>
				<td align="right" valign="bottom" bgcolor="#E0E0E0">
					<?php echo number_format($totPagado, 2, ",", "."); ?>
				</td>
				<td bgcolor="#E0E0E0">&nbsp;</td>
			</tr>
			<tr>
				<td height="1" bgcolor="#E0E0E0">&nbsp;</td>
				<td colspan="2" align="right" valign="bottom" bgcolor="#E0E0E0">&nbsp;</td>
				<td align="right" valign="bottom" bgcolor="#E0E0E0">&nbsp;</td>
				<td bgcolor="#E0E0E0">&nbsp;</td>
			</tr>
		</tbody>
	</table>
	<?php  if ($result==1) {?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr style="border-bottom:1px solid  #D5D5D5; font-size:22px;">
					<td height="46" colspan="6" align="center" valign="bottom">RESULTADOS OFICIALES Y RETIRADOS
						<span class="badge" style="float:right"><?php
                            echo $est_confirmacion;?>
						</span>
					</td>
				</tr>
				<tr style="border-bottom:1px solid  #D5D5D5; font-size:12px;">
					<td width="4%" align="center">POS</td>
					<td width="6%" align="center" valign="bottom" bgcolor="#E0E0E0">LLEGADA</td>
					<td width="7%" align="center" valign="bottom">DIV</td>
					<td width="7%" align="center" valign="bottom" bgcolor="#E0E0E0">FACT</td>
					<td width="8%" align="right">&nbsp;</td>
					<td width="57%" align="left">&nbsp;</td>
				</tr>
			  <tr style="border-bottom:1px solid  #D5D5D5; font-size:12px;">
					<td align="right">1ro</td>
					<td align="center" bgcolor="#E0E0E0"><?php echo $eje_primero; ?></td>
					<td align="right"><?php echo $div_primero_gan; ?></td>
					<td align="right" bgcolor="#E0E0E0"><?php echo $fac_primero_gan; ?></td>
					<td align="right">&nbsp;</td>
					<td align="left">&nbsp;</td>
				</tr>
				<tr style="border-bottom:1px solid  #D5D5D5; font-size:12px;">
					<td align="right">2do</td>
					<td align="center" bgcolor="#E0E0E0"><?php echo $eje_segundo; ?></td>
					<td align="right">&nbsp;</td>
					<td align="right" bgcolor="#E0E0E0">&nbsp;</td>
					<td align="right">&nbsp;</td>
					<td align="left">&nbsp;</td>
				</tr>
				<tr style="border-bottom:1px solid  #D5D5D5; font-size:12px;">
					<td align="right">3ro</td>
					<td align="center" bgcolor="#E0E0E0"><?php echo $eje_tercero; ?></td>
					<td align="right">&nbsp;</td>
					<td align="right" bgcolor="#E0E0E0">&nbsp;</td>
					<td align="right">RETIRADOS:</td>
					<td>&nbsp;<?php echo verRetirados_hnac($codcarrera);?></td>
				</tr>
			</tbody>
		</table>
	<?php
    }
    $gp=number_format($GanPer, 2, ",", "."); ?>
	<script>
		document.getElementById('monto').innerHTML="<?php echo "<br/>&nbsp;TOTAL GANANCIAS/PERDIDAS: ".$gp."&nbsp;"; ?>";
	</script>
<?php
}?>


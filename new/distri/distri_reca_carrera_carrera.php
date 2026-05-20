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
            "/* PARSEADORES1 new\distri\distri_reca_carrera_carrera.php - QUERY 1 */ SELECT 
			can_caballos, cod_carrera, est_carrera, est_cierre, est_confirmacion,
			eje_primero, div_primero_gan, div_primero_pla, div_primero_sho, 
			eje_segundo, div_segundo_pla, div_segundo_sho,
			eje_tercero, div_tercero_sho,
			eje_cuarto,
			div_exacta, ord_exacta,
			div_trifecta, ord_trifecta,
			div_superfecta, ord_superfecta
			FROM carrera
			WHERE fec_carrera = %s AND cod_carrera = %s
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
            "/* PARSEADORES1 new\distri\distri_reca_carrera_carrera.php - QUERY 2 */ SELECT 
			ca.can_caballos, ca.cod_carrera, est_carrera, est_cierre, est_confirmacion,
			eje_primero, div_primero_gan, div_primero_pla, div_primero_sho, 
			eje_segundo, div_segundo_pla, div_segundo_sho,
			eje_tercero, div_tercero_sho,
			eje_cuarto,
			div_exacta, ord_exacta,
			div_trifecta, ord_trifecta,
			div_superfecta, ord_superfecta
			FROM carrera ca, hipodromo hi
			WHERE 
				ca.fec_carrera = %s AND 
				hi.cod_hipodromo = %s AND
				ca.nom_hipodromo = hi.nom_hipodromo
			ORDER BY can_caballos DESC",
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
                $ord_exacta=$row_Recordset7['ord_exacta'];
                $div_exacta=$row_Recordset7['div_exacta'];
                $eje_primero=$row_Recordset7['eje_primero'];
                $div_primero_gan=$row_Recordset7['div_primero_gan'];
                $div_primero_pla=$row_Recordset7['div_primero_pla'];
                $div_primero_sho=$row_Recordset7['div_primero_sho'];
                $ord_trifecta=$row_Recordset7['ord_trifecta'];
                $div_trifecta=$row_Recordset7['div_trifecta'];
                $eje_segundo=$row_Recordset7['eje_segundo'];
                $div_segundo_pla=$row_Recordset7['div_segundo_pla'];
                $div_segundo_sho=$row_Recordset7['div_segundo_sho'];
                $ord_superfecta=$row_Recordset7['ord_superfecta'];
                $div_superfecta=$row_Recordset7['div_superfecta'];
                $eje_tercero=$row_Recordset7['eje_tercero'];
                $div_tercero_sho= $row_Recordset7['div_tercero_sho'];
                if (($row_Recordset7['est_carrera']==0 && $row_Recordset7['est_cierre']==0) or
                    ($row_Recordset7['est_carrera']==0 && $row_Recordset7['est_cierre']==1)) {
                    $est_confirmacion=' <font color="#000000">CERRADA</font> ';
                } elseif ($row_Recordset7['est_confirmacion']!=0) {
                    $est_confirmacion=' ABIERTA ';
                } else {
                    $est_confirmacion=' <font color="#000000">CERRADA</font> ';
                }
            }
            $codcarrera=$row_Recordset7['cod_carrera'];
            for ($numCab = 1; $numCab <= $row_Recordset7['can_caballos']; $numCab++) {
                if ($codagencia!="todos") {
                    $query_Recordset8 = sprintf(
                        "/* PARSEADORES1 new\distri\distri_reca_carrera_carrera.php - QUERY 3 */ SELECT 
						SUM(mon_venta) AS apuestas,
						SUM(CASE WHEN est_ticket = 2 
							THEN pag_premio ELSE 0 END) AS tpremios,
						SUM(CASE WHEN est_ticket >= 4 AND est_ticket <= 5
							THEN mon_venta ELSE 0 END) AS tinvalidos,
							
						SUM(CASE WHEN est_calculo = 2  AND est_ticket = 1
							THEN pag_premio ELSE 0 END) AS tpremiosP,
						SUM(CASE WHEN est_calculo >= 4 AND est_calculo <= 5 AND est_ticket = 1
							THEN mon_venta ELSE 0 END) AS tinvalidosP
						FROM 
							venta

						WHERE 
							fec_venta = %s AND 
							cod_carrera = %s AND
							cod_taquilla = %s AND
							num_caballo = %s AND
							est_ticket !=0 AND
							cod_tventa>0 AND cod_tventa<=3",
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($codcarrera, "int"),
                        GetSQLValueString($codagencia, "int"),
                        GetSQLValueString($numCab, "text")
                    );
                } else {
                    $query_Recordset8 = sprintf(
                        "/* PARSEADORES1 new\distri\distri_reca_carrera_carrera.php - QUERY 4 */ SELECT 
						SUM(ve.mon_venta) AS apuestas,
						SUM(CASE WHEN ve.est_ticket = 2 
							THEN ve.pag_premio ELSE 0 END) AS tpremios,
						SUM(CASE WHEN ve.est_ticket >= 4 AND ve.est_ticket <= 5
							THEN ve.mon_venta ELSE 0 END) AS tinvalidos,
							
						SUM(CASE WHEN ve.est_calculo = 2 AND est_ticket = 1
							THEN ve.pag_premio ELSE 0 END) AS tpremiosP,
						SUM(CASE WHEN ve.est_calculo >= 4 AND ve.est_calculo <= 5 AND est_ticket = 1
							THEN ve.mon_venta ELSE 0 END) AS tinvalidosP
						FROM 
							banca ba,
							taquilla ta,
							agencia ag,
							venta ve

						WHERE 
							ve.fec_venta = %s AND 
							ve.cod_carrera = %s AND
							ve.num_caballo = %s AND
							ve.est_ticket !=0 AND
							ve.cod_tventa>0 AND ve.cod_tventa<=3 AND
							ve.cod_taquilla = ta.cod_taquilla AND
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
            if ($codagencia!="todos") {
                $query_Recordset9 = sprintf(
                    "/* PARSEADORES1 new\distri\distri_reca_carrera_carrera.php - QUERY 5 */ SELECT 
						SUM(mon_venta) AS apuestas,
						SUM(CASE WHEN est_ticket = 2 
							THEN pag_premio ELSE 0 END) AS tpremios,
						SUM(CASE WHEN est_ticket >= 4 AND est_ticket <= 5
							THEN mon_venta ELSE 0 END) AS tinvalidos,
						SUM(CASE WHEN est_calculo = 2 AND est_ticket = 1 
							THEN pag_premio ELSE 0 END) AS tpremiosP,
						SUM(CASE WHEN est_calculo >= 4 AND est_calculo <= 5 AND est_ticket = 1
							THEN mon_venta ELSE 0 END) AS tinvalidosP
						FROM 
							venta


						WHERE 
							fec_venta = %s AND 
							cod_carrera = %s AND
							cod_taquilla = %s AND
							est_ticket !=0 AND
							cod_tventa>3",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($codcarrera, "int"),
                    GetSQLValueString($codagencia, "int")
                );
            } else {
                $query_Recordset9 = sprintf(
                    "/* PARSEADORES1 new\distri\distri_reca_carrera_carrera.php - QUERY 6 */ SELECT 
						SUM(ve.mon_venta) AS apuestas,
						SUM(CASE WHEN ve.est_ticket = 2 
							THEN ve.pag_premio ELSE 0 END) AS tpremios,
						SUM(CASE WHEN ve.est_ticket >= 4 AND ve.est_ticket <= 5
							THEN ve.mon_venta ELSE 0 END) AS tinvalidos,
						SUM(CASE WHEN ve.est_calculo = 2 AND est_ticket = 1 
							THEN ve.pag_premio ELSE 0 END) AS tpremiosP,
						SUM(CASE WHEN ve.est_calculo >= 4 AND ve.est_calculo <= 5 AND est_ticket = 1
							THEN ve.mon_venta ELSE 0 END) AS tinvalidosP
						FROM 
							banca ba,
							taquilla ta,
							agencia ag,
							venta ve


						WHERE 
							ve.fec_venta = %s AND 
							ve.cod_carrera = %s AND
							ve.est_ticket !=0 AND
							ve.cod_tventa>3 AND
							ve.cod_taquilla = ta.cod_taquilla AND
							ta.cod_agencia = ag.cod_agencia AND
							ag.cod_banca = ba.cod_banca AND
							ba.cod_banca = %s",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($codcarrera, "int"),
                    GetSQLValueString($cod_banca, "int")
                );
            }
            $Recordset9 = mysqli_query($conexionbanca, $query_Recordset9) or die(mysqli_error($conexionbanca));
            $row_Recordset9 = mysqli_fetch_assoc($Recordset9);
            $totalRows_Recordset9 = mysqli_num_rows($Recordset9);
            $exoApuestas+=$row_Recordset9['apuestas']*1;
            $exoPagado+=($row_Recordset9['tpremios']+$row_Recordset9['tinvalidos'])*1;
            $exoPorpagar+=($row_Recordset9['tpremiosP']+$row_Recordset9['tinvalidosP'])*1;
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
			<tr class="brillo" style="border-bottom:1px solid  #D5D5D5; font-size:12px" align="right" valign="bottom">
				<td height="32">&nbsp;</td>
				<td>EXOTICAS:</td>
				<td>
					<?php echo number_format($exoApuestas, 2, ",", "."); ?>
				</td>
				<td>
					<?php echo number_format($exoPorpagar, 2, ",", "."); ?>
				</td>
				<td>
					<?php echo number_format($exoPagado, 2, ",", "."); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
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
					<td height="46" colspan="8" align="center" valign="bottom">RESULTADOS Y RETIRADOS
						<span class="badge" style="float:right"><?php
                            echo $est_confirmacion;?>
						</span>
					</td>
				</tr>
				<tr style="border-bottom:1px solid  #D5D5D5; font-size:12px;">
					<td width="4%" align="center">POS</td>
					<td width="6%" align="center" valign="bottom" bgcolor="#E0E0E0">LLEGADA</td>
					<td width="7%" align="center" valign="bottom">GAN</td>
					<td width="7%" align="center" valign="bottom" bgcolor="#E0E0E0">PLA</td>
					<td width="7%" align="center" valign="bottom">SHW</td>
					<td width="4%" bgcolor="#E0E0E0">&nbsp;</td>
					<td width="8%" align="right">EXACTA:</td>
					<td width="57%" align="left">&nbsp;
						<?php echo str_replace("/", "-", $ord_exacta)." * ".$div_exacta;?>
					</td>
				</tr>
				<tr style="border-bottom:1px solid  #D5D5D5; font-size:12px;">
					<td align="right">1ro</td>
					<td align="center" bgcolor="#E0E0E0"><?php echo $eje_primero; ?></td>
					<td align="right"><?php echo $div_primero_gan; ?></td>
					<td align="right" bgcolor="#E0E0E0"><?php echo $div_primero_pla; ?></td>
					<td align="right"><?php echo $div_primero_sho; ?></td>
					<td bgcolor="#E0E0E0">&nbsp;</td>
					<td align="right">TRIFECTA:</td>
					<td align="left">&nbsp;
						<?php echo str_replace("/", "-", $ord_trifecta)." * ".$div_trifecta;?>
					</td>
				</tr>
				<tr style="border-bottom:1px solid  #D5D5D5; font-size:12px;">
					<td align="right">2do</td>
					<td align="center" bgcolor="#E0E0E0"><?php echo $eje_segundo; ?></td>
					<td align="right">&nbsp;</td>
					<td align="right" bgcolor="#E0E0E0"><?php echo $div_segundo_pla; ?></td>
					<td align="right"><?php echo $div_segundo_sho; ?></td>
					<td bgcolor="#E0E0E0">&nbsp;</td>
					<td align="right">SUPERFECTA:</td>
					<td align="left">&nbsp;
						<?php echo str_replace("/", "-", $ord_superfecta)." * ".$div_superfecta;?>
					</td>
				</tr>
				<tr style="border-bottom:1px solid  #D5D5D5; font-size:12px;">
					<td align="right">3ro</td>
					<td align="center" bgcolor="#E0E0E0"><?php echo $eje_tercero; ?></td>
					<td align="right">&nbsp;</td>
					<td align="right" bgcolor="#E0E0E0">&nbsp;</td>
					<td align="right"><?php echo $div_tercero_sho; ?></td>
					<td bgcolor="#E0E0E0">&nbsp;</td>
					<td align="right">RETIRADOS:</td>
					<td>&nbsp;<?php echo BuscarRetirados($codcarrera);?></td>
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


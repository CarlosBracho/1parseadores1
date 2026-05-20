<?php
$query_Recordset81 = sprintf(
    "/* PARSEADORES1 agente_hnac\baseAgente_hnac\ventas_carrera_ta.php - QUERY 1 */ SELECT *, 
		SUM(ven.mon_venta_hnac) AS total_venta,
		SUM(CASE WHEN ven.est_ticket_hnac >= 1 AND ven.est_ticket_hnac <= 2 AND
					  ins.est_inscrito_hnac = 1
						THEN ven.mon_venta_hnac ELSE 0 END) AS total_jugada,
		SUM(CASE WHEN ven.est_ticket_hnac >= 1 AND ven.est_ticket_hnac <= 2 AND 
					  ven.num_caballo_hnac = ins.num_caballo_hnac AND
					  ins.est_inscrito_hnac = 1
						THEN ven.mon_venta_hnac ELSE 0 END) AS monto_por_caballo,
		SUM(CASE WHEN ven.est_ticket_hnac = 0 AND ins.est_inscrito_hnac = 1
						THEN ven.mon_venta_hnac ELSE 0 END) AS jugada_elim
	FROM
		taquilla AS taq,
		usuario AS usu,
		carrera_hnac AS car,
		venta_hnac AS ven
	LEFT JOIN inscritos AS ins
		ON ins.cod_carrera_hnac = ven.cod_carrera_hnac
	WHERE
		car.cod_carrera_hnac = ven.cod_carrera_hnac AND
		usu.cod_taquilla = taq.cod_taquilla AND
		ven.id_usuario = usu.id_usuario AND
		ven.fec_venta_hnac = %s AND
		ven.cod_carrera_hnac = %s AND
		taq.cod_taquilla = %s
	GROUP BY ins.num_caballo_hnac
	ORDER BY ins.num_caballo_hnac",
    GetSQLValueString($inicio, "date"),
    GetSQLValueString($codCarrera, "int"),
    GetSQLValueString($codigoTaquilla, "int")
);
$Recordset81 = mysqli_query($conexionbanca, $query_Recordset81) or die(mysqli_error($conexionbanca));
$row_Recordset81 = mysqli_fetch_assoc($Recordset81);
$totalRows_Recordset81 = mysqli_num_rows($Recordset81);
$total_venta=$row_Recordset81['total_venta'];
$jugada_elim=$row_Recordset81['jugada_elim'];
$total_venta=$total_venta-$jugada_elim;
$query_Recordset82 = sprintf(
    "/* PARSEADORES1 agente_hnac\baseAgente_hnac\ventas_carrera_ta.php - QUERY 2 */ SELECT *
	FROM 
		resultados_hnac AS res
	WHERE
		res.cod_carrera_hnac = %s AND
		res.cod_taquilla = %s",
    GetSQLValueString($codCarrera, "int"),
    GetSQLValueString($codigoTaquilla, "int")
);
$Recordset82 = mysqli_query($conexionbanca, $query_Recordset82) or die(mysqli_error($conexionbanca));
$row_Recordset82 = mysqli_fetch_assoc($Recordset82);
$totalRows_Recordset82 = mysqli_num_rows($Recordset82);
$leyenda='<font style="font-size:12px">RESULTADOS Y DIVIDENDOS&nbsp;</font>';
if ($totalRows_Recordset82==0) {
    $leyenda=$leyenda.'<br/><span style="font-size:16px; text-align:right">NO HAY DATOS&nbsp;</span>';
} else {
    $leyenda=$leyenda.'<br/><span style="font-size:16px; text-align:right">GAN:'.$row_Recordset82['num_caballo_hnac'];
    $leyenda=$leyenda." | Div:".$row_Recordset82['div_pago_hnac'].'&nbsp;</span>';
}

?>
<div style="background:#09C; width:50%; margin:10px 0px 0px 10px; padding:5px 0px 0px 0px; border-bottom:#09C; float:left;">
<table width="100%" border="1" bordercolor="#F0F0F0" cellpadding="2" style="background:#FFFFFF">
	<tr>
		<td height="36" colspan="3">CARRERA #
		<?php
        if ($totalRows_Recordset81>0) {
            echo $row_Recordset81['num_carrera_hnac'];
        } else {
            echo $numCarrera;
        }
        ?>
        </td>
	</tr>
<?php
?>
<?php
if ($totalRows_Recordset81>0) {
            echo '<tr style="font-size:12px">';
            echo '<td width="6%">No</td>';
            echo '<td width="56%">EJEMPLAR</td>';
            echo '<td width="38%">TOTAL</td>';
            echo '</tr>';
            $n=0;
            do {
                if ($n%2==0) {
                    echo '<tr style="font-size:12px; background: #EEE">';
                } else {
                    echo '<tr style="font-size:12px; background: #FFF">';
                }
                echo '<td width="6%">'.$row_Recordset81['num_caballo_hnac'].'</td>';
                echo '<td width="56%" align="left">'.$row_Recordset81['nom_caballo_hnac'].'</td>';
                echo '<td width="38%" align="right">'.$row_Recordset81['monto_por_caballo'].'</td>';
                echo '</tr>';
                echo '';
                echo '';
                echo '';
                $n++;
            } while ($row_Recordset81 = mysqli_fetch_assoc($Recordset81)); ?>
		<tr style="font-size:24px; background: #EEE" align="right">
			<td height="44" colspan="2">TOTAL:&nbsp;</td>
			<td width="38%">
			<?php
            echo number_format($total_venta, 2, ",", "."); ?>
            </td>
		</tr>
	<?php
        } else {
    echo '<tr style="font-size:24px">';
    echo '<td height="306" colspan="3">';
    echo '<i class="fa fa-info-circle fa-3x pull-left;" style="text-align:center;color:#CCC"></i><br/>';
    echo "No existen ventas para esta carrera";
    echo '</td>';
    echo '</tr>';
}?>    
</table>
</div>

<div style="background: #D96C00; width:15%; margin:10px 0px 0px 10px; padding:20px 0px 0px 0px; height:85px; float:left;
	color:#FFFFFF; font-size:24px">
    <i class="fa fa-tag fa-3x"></i>
</div>
<div style="background: #f39c12; width:30%; margin:10px 0px 0px 0px; padding:5px 0px 0px 5px; height:45px; float:left;
	color:#FFFFFF; font-size:14px; text-align:left">
	TOTAL VENTAS<br/>
    <p style="font-size:24px"><?php echo number_format($total_venta, 2, ",", "."); ?></p>
</div>
<div style="background: #f39c12; width:30%; margin:3px 0px 0px 0px; padding:2px 0px 0px 5px; height:50px; float:left;
	color:#FFFFFF; font-size:12px; text-align:right">
    <?php echo $leyenda; ?>
</div>
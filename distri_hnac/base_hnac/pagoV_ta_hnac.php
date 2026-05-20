<?php
$query_Recordset82 = sprintf(
    "/* PARSEADORES1 distri_hnac\base_hnac\pagoV_ta_hnac.php - QUERY 1 */ SELECT 
		WEEK(venta_hnac.fec_venta_hnac) AS semanas,
		COUNT(*) AS jugadas
	FROM 
		venta_hnac,
		agencia,
		taquilla, 
		usuario
	WHERE
	taquilla.cod_taquilla = usuario.cod_taquilla AND
	venta_hnac.id_usuario = usuario.id_usuario AND
	agencia.cod_agencia = taquilla.cod_agencia AND 
	venta_hnac.fec_venta_hnac >= %s AND
	venta_hnac.fec_venta_hnac <= %s AND
	venta_hnac.est_ticket_hnac >= 1 AND
	venta_hnac.est_ticket_hnac <= 2 AND
	taquilla.cod_taquilla = %s
	GROUP BY semanas
	ORDER BY semanas",
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($codigoTaquilla, "int")
);
$Recordset82 = mysqli_query($conexionbanca, $query_Recordset82) or die(mysqli_error($conexionbanca));
$row_Recordset82 = mysqli_fetch_assoc($Recordset82);
$totalRows_Recordset82 = mysqli_num_rows($Recordset82);
$pagSemanal=500; $pagoSistema=0;
do {
    if ($row_Recordset82['jugadas']>=$canJugada) {
        $pagoSistema=$pagoSistema+$pagSemanal;
    }
} while ($row_Recordset82 = mysqli_fetch_assoc($Recordset82));

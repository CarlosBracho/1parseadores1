<?php
if ($ecie==0 &&	$ecar==0) {
    $query_Recordset81 = sprintf(
        "/* PARSEADORES1 agente_hnac\base_hnac\bPremio_ta_hnac.php - QUERY 1 */ SELECT 
					venta_hnac.ser_venta_hnac,
					venta_hnac.ticket_hnac,
					venta_hnac.mon_venta_hnac,
					carrera_hnac.num_carrera_hnac,
					carrera_hnac.fec_carrera_hnac,
					carrera_hnac.est_carrera_hnac,
					carrera_hnac.est_cierre_hnac
					FROM 
					agencia, 
					taquilla,
					venta_hnac,
					usuario,
					carrera_hnac
					WHERE
					taquilla.cod_taquilla = usuario.cod_taquilla AND
					venta_hnac.id_usuario = usuario.id_usuario AND
					agencia.cod_agencia = taquilla.cod_agencia AND 
					carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
					venta_hnac.fec_venta_hnac = %s AND
					taquilla.cod_taquilla = %s AND
					venta_hnac.cod_carrera_hnac = %s  
					ORDER BY venta_hnac.num_ticket_hnac ASC",
        GetSQLValueString($in, "date"),
        GetSQLValueString($codigoTaquilla, "int"),
        GetSQLValueString($cCa, "int")
    );
} else {
    $query_Recordset81 = sprintf(
        "/* PARSEADORES1 agente_hnac\base_hnac\bPremio_ta_hnac.php - QUERY 2 */ SELECT 
					venta_hnac.ser_venta_hnac,
					venta_hnac.ticket_hnac,
					venta_hnac.mon_venta_hnac,
					resultados_hnac.div_pago_hnac,
					carrera_hnac.num_carrera_hnac,
					carrera_hnac.fec_carrera_hnac,
					carrera_hnac.est_carrera_hnac,
					carrera_hnac.est_cierre_hnac
					FROM 
					agencia, 
					taquilla,
					taquilla_opc_hnac, 
					venta_hnac,
					usuario,
					carrera_hnac,
					resultados_hnac 
					WHERE
					taquilla.cod_taquilla = usuario.cod_taquilla AND
					venta_hnac.id_usuario = usuario.id_usuario AND
					agencia.cod_agencia = taquilla.cod_agencia AND 
					taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
					carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
					venta_hnac.num_caballo_hnac = resultados_hnac.num_caballo_hnac AND
					venta_hnac.cod_tventa_hnac = resultados_hnac.cod_tventa_hnac AND
					carrera_hnac.cod_carrera_hnac = resultados_hnac.cod_carrera_hnac AND
					carrera_hnac.fec_carrera_hnac = resultados_hnac.fec_resultado_hnac AND
					venta_hnac.fec_venta_hnac = resultados_hnac.fec_resultado_hnac AND
					taquilla.cod_taquilla = resultados_hnac.cod_taquilla AND
					venta_hnac.fec_venta_hnac = %s AND
					taquilla.cod_taquilla = %s AND
					venta_hnac.cod_carrera_hnac = %s  
					ORDER BY venta_hnac.num_ticket_hnac ASC",
        GetSQLValueString($in, "date"),
        GetSQLValueString($codigoTaquilla, "int"),
        GetSQLValueString($cCa, "int")
    );
}
$Recordset81 = mysqli_query($conexionbanca, $query_Recordset81) or die(mysqli_error($conexionbanca));
$row_Recordset81 = mysqli_fetch_assoc($Recordset81);
$totalRows_Recordset81 = mysqli_num_rows($Recordset81);

<?php
                $query_Recordset1 = sprintf(
    "/* PARSEADORES1 distri_hnac\base_hnac\jugada_us_hnac.php - QUERY 1 */ SELECT 
					venta_hnac.ip_venta_hnac,
					venta_hnac.ticket_hnac,
					venta_hnac.can_ticket_hnac,
					venta_hnac.fec_venta_hnac,
					venta_hnac.hor_venta_hnac,
					venta_hnac.cod_tventa_hnac,
					venta_hnac.mon_venta_hnac,
					venta_hnac.fec_pago_hnac,
					venta_hnac.hor_pago_hnac,
					venta_hnac.pag_premio_hnac,
					venta_hnac.num_caballo_hnac,
					venta_hnac.est_ticket_hnac,
					venta_hnac.efectivoOn, 
					hipodromo_hnac.nom_hipodromo_hnac,
					carrera_hnac.num_carrera_hnac,
					carrera_hnac.est_cierre_hnac,
					carrera_hnac.cod_carrera_hnac,
					usuario.nom_usuario
				FROM 
				agencia, 
				taquilla,
				taquilla_opc_hnac, 
				venta_hnac,
				usuario,
				carrera_hnac,
				hipodromo_hnac
				WHERE
					usuario.cod_taquilla = taquilla.cod_taquilla AND
					usuario.id_usuario = venta_hnac.id_usuario AND
					(venta_hnac.fec_venta_hnac >= %s AND venta_hnac.fec_venta_hnac <= %s OR 
					venta_hnac.fec_pago_hnac >= %s AND venta_hnac.fec_pago_hnac <= %s) AND 
					taquilla.cod_agencia = agencia.cod_agencia AND 
					taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
					venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND
					hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac AND
					usuario.id_usuario = %s 
				ORDER BY venta_hnac.fec_venta_hnac,usuario.cod_taquilla,venta_hnac.num_ticket_hnac ASC",
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($codigoUsuario, "int")
);
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                $nomb=$row_Recordset1['nom_usuario'];
                $ver=1;

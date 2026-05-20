<?php
    $query_Recordset0 = sprintf("/* PARSEADORES1 includes\procesar_ticket_cancelar_hnac.php - QUERY 1 */ SELECT ta.cod_taquilla 
		FROM taquilla ta, taquilla_opc_hnac tp 
		WHERE 
		tp.cod_taquilla = ta.cod_taquilla AND 
		tp.est_taquilla_hnac = 1");
    $Recordset0 = mysqli_query($conexionbanca, $query_Recordset0) or die(mysqli_error($conexionbanca));
    $row_Recordset0 = mysqli_fetch_assoc($Recordset0);
    $totalRows_Recordset0 = mysqli_num_rows($Recordset0);
    if ($totalRows_Recordset0>0) {
        $fec=$row_Recordset10['fec_carrera_hnac'];
        $car=$_POST['rA'];
        do {
            $taq=$row_Recordset0['cod_taquilla'];
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 includes\procesar_ticket_cancelar_hnac.php - QUERY 2 */ SELECT ve.num_ticket_hnac, ve.mon_venta_hnac
				FROM 
				venta_hnac ve, 
				carrera_hnac ca, 
				usuario us,
				taquilla_opc_hnac tp
				WHERE 
				ve.cod_carrera_hnac = %s AND
				tp.cod_taquilla = %s AND
				ve.fec_venta_hnac = %s AND
				ve.est_ticket_hnac = 1 AND
				ve.id_usuario = us.id_usuario AND
				us.cod_taquilla  = tp.cod_taquilla AND 
				ca.cod_carrera_hnac = ve.cod_carrera_hnac",
                GetSQLValueString($car, "int"),
                GetSQLValueString($taq, "int"),
                GetSQLValueString($fec, "date")
            );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            if ($totalRows_Recordset1>0) {
                $x_nTicket=array(0);
                $x_pagoSencillo=array(0);
                $i=0;
                do {
                    $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                    $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                    $i=$i+1;
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                $x=0;
                if ($i>0) {
                    do {
                        $updateSQL3 = sprintf(
                            "/* PARSEADORES1 includes\procesar_ticket_cancelar_hnac.php - QUERY 3 */ UPDATE venta_hnac 
						SET pag_premio_hnac=%s, est_calculo_hnac=%s 
							WHERE num_ticket_hnac=%s",
                            GetSQLValueString($x_pagoSencillo[$x], "double"),
                            GetSQLValueString(5, "int"),
                            GetSQLValueString($x_nTicket[$x], "int")
                        );
                        $Result3 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));
                        $x++;
                    } while ($x < $i);
                }
            }
        } while ($row_Recordset0 = mysqli_fetch_assoc($Recordset0));
    }
    if (isset($Recordset0)) {
        mysqli_free_result($Recordset0);
    }
    if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }

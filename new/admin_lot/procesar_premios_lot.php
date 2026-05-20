<?php
if (isset($_POST["fec_resultado"])&&isset($xpTriple)&&isset($xpTermin)&&isset($xganador)&&isset($cod_signo)) {
    $query_Recordset14 = sprintf(
        "/* PARSEADORES1 new\admin_lot\procesar_premios_lot.php - QUERY 1 */ SELECT
		ve.num_ticket_lot, ve.tip_loteria_lot, ve.num_apuesta_lot, ve.mon_apuesta_lot, ve.id_signo, ve.id_loteria,
		(/* PARSEADORES1 new\admin_lot\procesar_premios_lot.php - QUERY 2 */ SELECT pre_loteria FROM bancaloterias bl WHERE bl.id_loteria=ve.id_loteria AND 
			bl.id_banca = ag.cod_banca LIMIT 1) AS pPremio
		FROM 
			venta_lot ve, banca ba, agencia ag, taquilla ta, usuario us
		WHERE ve.fec_venta_lot	= %s AND 
			(ve.id_loteria = %s OR ve.id_loteria = %s) AND ba.cod_banca = ag.cod_banca AND
			((ba.mod_resultado = 1) OR (ba.mod_resultado = 0 AND ba.cod_banca = %s)) AND 
			ag.cod_agencia = ta.cod_agencia AND ta.cod_taquilla = us.cod_taquilla AND
			us.id_usuario = ve.id_usuario",
        GetSQLValueString($_POST["fec_resultado"], "date"),
        GetSQLValueString($xpTriple, "int"),
        GetSQLValueString($xpTermin, "int"),
        GetSQLValueString($xcBanca, "int")
    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    if (!isset($u)) {
        $u=0;
    }
    if ($totalRows_Recordset14>0) {
        do {
            $numP=$xganador;
            $codP=$xpTriple;
            if ($row_Recordset14['tip_loteria_lot']==2) {
                $numP=substr($xganador, 1, 2);
                $codP=$xpTermin;
            }
            $apagar=0;
            $staTicket=1;
            if (($numP*1)<=0) {
                if ($codP==$row_Recordset14['id_loteria'] && $numP===$row_Recordset14['num_apuesta_lot'] &&
                    $cod_signo==$row_Recordset14['id_signo']) {
                    $apagar=$row_Recordset14['mon_apuesta_lot']*$row_Recordset14['pPremio'];
                    $staTicket=2;
                }
            } elseif ($codP==$row_Recordset14['id_loteria'] && $numP==$row_Recordset14['num_apuesta_lot'] &&
                $cod_signo==$row_Recordset14['id_signo']) {
                $apagar=$row_Recordset14['mon_apuesta_lot']*$row_Recordset14['pPremio'];
                $staTicket=2;
            }
            $ticketPre[$u][0]=$row_Recordset14['num_ticket_lot'];//numero ticket
            $ticketPre[$u][1]=$apagar;//premio
            $ticketPre[$u][2]=$staTicket;//estado
            $u++;
        } while ($row_Recordset14 = mysqli_fetch_assoc($Recordset14));
    }
    if (isset($Recordset14)) {
        mysqli_free_result($Recordset14);
    }
}

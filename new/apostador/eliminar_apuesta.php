<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "C"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$mensaje="JUGADA NO ELIMINADA";


if (isset($_POST["ticket"]) && isset($_POST["id_usuario"])) {
    $xTicket =$_POST["ticket"];
    $usuarioPago=$_POST["id_usuario"];
    $fechasistema=fechaactualbd();
    $horasistema=horaactual();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\apostador\eliminar_apuesta.php - QUERY 1 */ SELECT 
ve.cod_taquilla,
ve.est_ticket, 
ve.efectivoO,
ve.mon_venta,
ve.cod_taquilla,
ca.est_carrera, 
ca.hor_carrera 
	FROM 
	venta ve, 
	carrera ca
	WHERE 
	ve.ticket = %s AND 
	ve.cod_carrera = ca.cod_carrera 
	LIMIT 1",
        GetSQLValueString($xTicket, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);


    if ($row_Recordset1['est_ticket']!=0 && $row_Recordset1['hor_carrera']>=$horasistema && $row_Recordset1['est_carrera']==1) {
        $query_Recordset3 = sprintf("/* PARSEADORES1 new\apostador\eliminar_apuesta.php - QUERY 2 */ SELECT num_ticket, mon_venta
FROM venta ve 
WHERE  ve.ticket = %s", GetSQLValueString($_POST["ticket"], "int"));
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($totalRows_Recordset3>0) {
            $horaPago=horaactual();
            $ipPago=getRealIP();
            $fecpago=fechaactualbd();
                                    
            do {
                $numTicket=$row_Recordset3['num_ticket'];
                $updateSQL = sprintf(
                    "/* PARSEADORES1 new\apostador\eliminar_apuesta.php - QUERY 3 */ UPDATE venta 
										   SET est_ticket=%s, fec_pago=%s, cod_usuario_pago=%s, ip_pago=%s, hor_pago=%s 
											   WHERE num_ticket=%s",
                    GetSQLValueString(0, "int"),
                    GetSQLValueString($fecpago, "date"),
                    GetSQLValueString($usuarioPago, "int"),
                    GetSQLValueString($ipPago, "text"),
                    GetSQLValueString($horaPago, "date"),
                    GetSQLValueString($numTicket, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                        
                $query_Recordset13 = sprintf(
                    "/* PARSEADORES1 new\apostador\eliminar_apuesta.php - QUERY 4 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
                    GetSQLValueString($row_Recordset1['efectivoO'], "int"),
                    GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
                );
                $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
                $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
                $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
                $Idbalancecli=((int)$row_Recordset13['MAX(Idbalancecli)']);
    
                $query_Recordset14 = sprintf(
                    "/* PARSEADORES1 new\apostador\eliminar_apuesta.php - QUERY 5 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
                    GetSQLValueString($row_Recordset1['efectivoO'], "int"),
                    GetSQLValueString($Idbalancecli, "int")
                );
                $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
                $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
                $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
                $saldoactualc=((float)$row_Recordset14['saldoactualc']);
                                        
                $query_Recordset15 = sprintf(
                    "/* PARSEADORES1 new\apostador\eliminar_apuesta.php - QUERY 6 */ SELECT 
	SUM(ve.mon_venta) AS total_venta,
	GROUP_CONCAT(ve.num_caballo SEPARATOR '*') AS cab_apuesta,
	GROUP_CONCAT(
		(CASE ve.cod_tventa 
			WHEN '1' THEN 'GAN'
			WHEN '2' THEN 'PLA'
			WHEN '3' THEN 'SHO'
			WHEN '4' THEN 'EXA'
			WHEN '5' THEN 'TRI'
			WHEN '6' THEN 'SUP'
			WHEN '7' THEN '[P]EXA'
			WHEN '8' THEN '[P]TRI'
			WHEN '9' THEN '[P]SUP'
		END)
		SEPARATOR '*') AS tip_apuesta_nom,
	GROUP_CONCAT(ve.mon_venta SEPARATOR '*') AS mon_apuesta,
	CONCAT(ca.nom_hipodromo, ' Carr...', ca.num_carrera,' Ejem...') AS carrera,
	ve.num_ticket
FROM 
	venta ve, carrera ca
WHERE 
ve.num_ticket = %s AND
	ve.fec_venta = %s AND
	ve.cod_taquilla = %s AND 
	ve.cod_carrera = ca.cod_carrera

GROUP BY ve.num_ticket DESC LIMIT 1",
                    GetSQLValueString($numTicket, "int"),
                    GetSQLValueString($fecpago, "date"),
                    GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
                );
                $Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
                $row_Recordset15 = mysqli_fetch_assoc($Recordset15);
                $totalRows_Recordset15 = mysqli_num_rows($Recordset15);
                                        





                $wwww=$row_Recordset15['carrera'].$row_Recordset15['cab_apuesta'].$row_Recordset15['tip_apuesta_nom'];
                $insertSQL155 = sprintf(
                    "/* PARSEADORES1 new\apostador\eliminar_apuesta.php - QUERY 7 */ INSERT INTO balanceclientes  
(numticket, cod_taquilla, monto, jugada, fec_venta, hor_venta, saldoactualc, monedac, tipo)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($numTicket, "int"),
                    GetSQLValueString($row_Recordset1['cod_taquilla'], "int"),
                    GetSQLValueString($row_Recordset3['mon_venta'], "double"),
                    GetSQLValueString($wwww, "text"),
                    GetSQLValueString($fecpago, "date"),
                    GetSQLValueString($horaPago, "date"),
                    GetSQLValueString($saldoactualc+$row_Recordset3['mon_venta'], "double"),
                    GetSQLValueString($row_Recordset1['efectivoO'], "int"),
                    GetSQLValueString(6, "int")
                );
                $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
        }
    
        $mensaje="JUGADA ELIMINADA";
    }
}

    echo "<div id='resultado' style='line-height: 0.5em;'>";
    echo $mensaje;
    echo "</div>";

<?php



    $insertSQL = sprintf(
        "/* PARSEADORES1 apostador\grabarjugada2.php - QUERY 1 */ INSERT INTO venta (ser_venta, ticket, cod_taquilla, fec_venta, hor_venta, cod_tventa,
					 num_caballo, mon_venta, cod_carrera, id_usuario, est_ticket, can_ticket, ip_venta, lin_ticket, cod_cliente, tra_codigo, efectivoO) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($serial, "text"),
        GetSQLValueString($numerotiket2, "int"),
        GetSQLValueString($codigoTaquilla, "int"),
        GetSQLValueString($FechaTxt, "date"),
        GetSQLValueString($horaTxt, "date"),
        GetSQLValueString($tipo, "int"),
        GetSQLValueString($numcaballo, "int"),
        GetSQLValueString($monto, "double"),
        GetSQLValueString($_POST['cod_carrera'], "int"),
        GetSQLValueString($usuarioVenta, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString($cantTicket, "int"),
        GetSQLValueString($ipVenta, "text"),
        GetSQLValueString($linea, "int"),
        GetSQLValueString(strtoupper($_POST["cod_cliente"]), "text"),
        GetSQLValueString(1, "int"),
        GetSQLValueString($_POST['moneda'], "int")
    );
                
                $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

$montobss=0; $montousd=0; $montocop=0; $montosol=0;
                if ($_POST['moneda']<=2) {
                    $montobss=$monto;
                }
                if ($_POST['moneda']==3) {
                    $montousd=$monto;
                }
                if ($_POST['moneda']==4) {
                    $montocop=$monto;
                }
                if ($_POST['moneda']==5) {
                    $montosol=$monto;
                }
                
                
                                            $query_Recordset13 = sprintf(
                                                "/* PARSEADORES1 apostador\grabarjugada2.php - QUERY 2 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
                                                GetSQLValueString($_POST['moneda'], "int"),
                                                GetSQLValueString($codigoTaquilla, "int")
                                            );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    $Idbalancecli=((int)$row_Recordset13['MAX(Idbalancecli)']);
    
                            $query_Recordset14 = sprintf(
                                "/* PARSEADORES1 apostador\grabarjugada2.php - QUERY 3 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
                                GetSQLValueString($_POST['moneda'], "int"),
                                GetSQLValueString($Idbalancecli, "int")
                            );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    $saldoactualc=((float)$row_Recordset14['saldoactualc']);
                
                
                
                
                    $query_Recordset12 = sprintf(
                        "/* PARSEADORES1 apostador\grabarjugada2.php - QUERY 4 */ SELECT MAX(num_ticket) 
					FROM venta
					WHERE cod_taquilla = %s",
                        GetSQLValueString($codigoTaquilla, "int")
                    );
    $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
    $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
    $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
    $numeroticket=((int)$row_Recordset12['MAX(num_ticket)']);
                        


$query_Recordset15 = sprintf(
    "/* PARSEADORES1 apostador\grabarjugada2.php - QUERY 5 */ SELECT 
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
	ve.cod_carrera = ca.cod_carrera AND 
	ve.est_ticket = 1 AND
	ve.est_calculo = 0
GROUP BY ve.num_ticket DESC LIMIT 1",
    GetSQLValueString($numeroticket, "int"),
    GetSQLValueString($FechaTxt, "date"),
    GetSQLValueString($codigoTaquilla, "int")
);
$Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
$row_Recordset15 = mysqli_fetch_assoc($Recordset15);
$totalRows_Recordset15 = mysqli_num_rows($Recordset15);
    

$wwww=$row_Recordset15['carrera'].$row_Recordset15['cab_apuesta'].$row_Recordset15['tip_apuesta_nom'];

                    

    
    
            $insertSQL155 = sprintf(
                "/* PARSEADORES1 apostador\grabarjugada2.php - QUERY 6 */ INSERT INTO balanceclientes  
(numticket, agregadox, cod_taquilla, monto, jugada, fec_venta, hor_venta, saldoactualc, monedac)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($numeroticket, "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString($codigoTaquilla, "int"),
                GetSQLValueString('-'.$monto, "double"),
                GetSQLValueString($wwww, "text"),
                GetSQLValueString($FechaTxt, "date"),
                GetSQLValueString($horaTxt, "date"),
                GetSQLValueString($saldoactualc-$monto, "double"),
                GetSQLValueString($_POST['moneda'], "int")
            );

        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
                
                
                
                
                
                
                
                
                
$mensaje="JUGADAS REGISTRADAS! ";

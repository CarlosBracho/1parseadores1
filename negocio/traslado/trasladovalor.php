<?php
require_once('../Connections/conexionbanca.php');

                $query_Recordset13 = sprintf('/* PARSEADORES1 negocio\traslado\trasladovalor.php - QUERY 1 */ SELECT 
		inventarioydemas.id_inventarioydemas, inventarioydemas.id_productoinventarioydemas, producto.precio_actual, producto.precioultimacompra

		FROM 
			inventarioydemas, producto
		WHERE  
			inventarioydemas.id_productoinventarioydemas = producto.Id_producto AND inventarioydemas.valor = 0.01 AND inventarioydemas.tipoinventarioydemas = 3');
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);


    do {
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\trasladovalor.php - QUERY 2 */ UPDATE inventarioydemas 
										   SET valor=%s
											   WHERE id_inventarioydemas = %s",
            GetSQLValueString($row_Recordset12['precio_actual'], "int"),
            GetSQLValueString($row_Recordset12['id_inventarioydemas'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset13 = mysqli_fetch_assoc($Recordset13));

<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;




if (isset($_GET['numero'])) {
    $numero=$_GET['numero'];
    ;
}




$query_Recordset2 = sprintf(
    "/* PARSEADORES1 new\negocio\venta\eliminarultimaventa.php - QUERY 1 */ SELECT 
inventarioydemas.id_documentoinventarioydemas, 
inventarioydemas.fecha, 
inventarioydemas.cantidad, 
inventarioydemas.valor, 
producto.productoensede, 
producto.id_categoriaenproductoensede, 
usuario.usuario_nombre, 
inventarionegocios.id_productoinventarionegocios,
inventarionegocios.cantidadinventarionegocios,
negocio.nombre_negocio
FROM 
inventarioydemas,
inventarionegocios,
producto,
usuario,
negocio
WHERE
inventarioydemas.id_documentoinventarioydemas = %s 
AND producto.Id_producto = inventarioydemas.id_productoinventarioydemas
AND usuario.id_usuario = inventarioydemas.id_usuarioreninventario
AND negocio.Id_negocio = inventarioydemas.id_negocio
AND negocio.Id_negocio = inventarionegocios.id_negocioinventarionegocios
AND producto.Id_producto = inventarionegocios.id_productoinventarionegocios
ORDER BY 
inventarioydemas.id_inventarioydemas 
ASC 
LIMIT 99999",
    GetSQLValueString($numero, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$tVta1=0;
$x=0;


if ($totalRows_Recordset2>0) {
    do {
        $updateSQL = sprintf(
            "/* PARSEADORES1 new\negocio\venta\eliminarultimaventa.php - QUERY 2 */ UPDATE inventarioydemas 
										   SET tipoinventarioydemas= 9
											   WHERE id_documentoinventarioydemas = %s",
            GetSQLValueString($row_Recordset2['id_documentoinventarioydemas'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                        
                                        
                                        
        $updateSQL = sprintf(
            "/* PARSEADORES1 new\negocio\venta\eliminarultimaventa.php - QUERY 3 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_productoinventarionegocios = %s",
            GetSQLValueString($row_Recordset2['cantidad'], "int"),
            GetSQLValueString($row_Recordset2['id_productoinventarionegocios'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
}





















header("Location: ultimaventa.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->


<!-- InstanceBeginEditable name="aHead" -->
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">










</body>
<!-- InstanceEnd --></html>

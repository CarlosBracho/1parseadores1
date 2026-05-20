<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;
$horaactual=horaactual();
$fechasistema=fechaactualbd();
//echo $fechasistema;
$hora1=$horaactual;
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
//echo horaampm($nuevahora1);
//echo $nuevahora1;

    $query_Recordset2 = sprintf('/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 1 */ SELECT 
		inventarioydemas.id_documentoinventarioydemas 
		FROM 
			inventarioydemas 
		WHERE  
			inventarioydemas.tipoinventarioydemas = 1
		ORDER BY 
			inventarioydemas.id_inventarioydemas DESC LIMIT 1');
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$ultimacompra=$row_Recordset2['id_documentoinventarioydemas']+1;


    $query_Recordset1 = sprintf('/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 2 */ SELECT 
		producto.id_producto, producto.productoensede, producto.cantidadensede
		FROM 
			producto 
		ORDER BY 
			producto.productoensede');
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$z=0;
$t=0;
$x=0;
if ($totalRows_Recordset1>0) {
    do {
        $id_pro[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede[$t]=$row_Recordset1['productoensede'];
        $cantidadensede[$t]=$row_Recordset1['cantidadensede'];
        $id_pro1[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede1[$t]=$row_Recordset1['productoensede'];
        $cantidadensede1[$t]=$row_Recordset1['cantidadensede'];
        $id_pro2[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede2[$t]=$row_Recordset1['productoensede'];
        $cantidadensede2[$t]=$row_Recordset1['cantidadensede'];
        $id_pro3[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede3[$t]=$row_Recordset1['productoensede'];
        $cantidadensede3[$t]=$row_Recordset1['cantidadensede'];
        $id_pro4[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede4[$t]=$row_Recordset1['productoensede'];
        $cantidadensede4[$t]=$row_Recordset1['cantidadensede'];
        $id_pro5[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede5[$t]=$row_Recordset1['productoensede'];
        $cantidadensede5[$t]=$row_Recordset1['cantidadensede'];
        $id_pro6[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede6[$t]=$row_Recordset1['productoensede'];
        $cantidadensede6[$t]=$row_Recordset1['cantidadensede'];
        $id_pro7[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede7[$t]=$row_Recordset1['productoensede'];
        $cantidadensede7[$t]=$row_Recordset1['cantidadensede'];
        $id_pro8[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede8[$t]=$row_Recordset1['productoensede'];
        $cantidadensede8[$t]=$row_Recordset1['cantidadensede'];
        $id_pro9[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede9[$t]=$row_Recordset1['productoensede'];
        $cantidadensede9[$t]=$row_Recordset1['cantidadensede'];
        $id_pro10[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede10[$t]=$row_Recordset1['productoensede'];
        $cantidadensede10[$t]=$row_Recordset1['cantidadensede'];
        $id_pro11[$t]=$row_Recordset1['id_producto'];
        ;
        $productoensede11[$t]=$row_Recordset1['productoensede'];
        $cantidadensede11[$t]=$row_Recordset1['cantidadensede'];
            
        $t++;
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}

if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
    echo "COMPRA REGISTRADA";
    echo '<br/>';

    if ($_POST['id_prox']>0 &&  $_POST['cantidad']>0 && $_POST['costoxunidad']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 3 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox'], "int"),
            GetSQLValueString($_POST['cantidad'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad']*$_POST['cantidad'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 4 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad'], "int"),
            GetSQLValueString($_POST['costoxunidad'], "double"),
            GetSQLValueString($_POST['id_prox'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                
        $z=1;
    }
    if ($_POST['id_prox1']>0 &&  $_POST['cantidad1']>0 && $_POST['costoxunidad1']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 5 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox1'], "int"),
            GetSQLValueString($_POST['cantidad1'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad1']*$_POST['cantidad1'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 6 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad1'], "int"),
            GetSQLValueString($_POST['costoxunidad1'], "double"),
            GetSQLValueString($_POST['id_prox1'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox2']>0 &&  $_POST['cantidad2']>0 && $_POST['costoxunidad2']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 7 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox2'], "int"),
            GetSQLValueString($_POST['cantidad2'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad2']*$_POST['cantidad2'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 8 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad2'], "int"),
            GetSQLValueString($_POST['costoxunidad2'], "double"),
            GetSQLValueString($_POST['id_prox2'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox3']>0 &&  $_POST['cantidad3']>0 && $_POST['costoxunidad3']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 9 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox3'], "int"),
            GetSQLValueString($_POST['cantidad3'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad3']*$_POST['cantidad3'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 10 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad3'], "int"),
            GetSQLValueString($_POST['costoxunidad3'], "double"),
            GetSQLValueString($_POST['id_prox3'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox4']>0 &&  $_POST['cantidad4']>0 && $_POST['costoxunidad4']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 11 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox4'], "int"),
            GetSQLValueString($_POST['cantidad4'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad4']*$_POST['cantidad4'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 12 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad4'], "int"),
            GetSQLValueString($_POST['costoxunidad4'], "double"),
            GetSQLValueString($_POST['id_prox4'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox5']>0 &&  $_POST['cantidad5']>0 && $_POST['costoxunidad5']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 13 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox5'], "int"),
            GetSQLValueString($_POST['cantidad5'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad5']*$_POST['cantidad5'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 14 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad5'], "int"),
            GetSQLValueString($_POST['costoxunidad5'], "double"),
            GetSQLValueString($_POST['id_prox5'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox6']>0 &&  $_POST['cantidad6']>0 && $_POST['costoxunidad6']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 15 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox6'], "int"),
            GetSQLValueString($_POST['cantidad6'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad6']*$_POST['cantidad6'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 16 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad6'], "int"),
            GetSQLValueString($_POST['costoxunidad6'], "double"),
            GetSQLValueString($_POST['id_prox6'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox7']>0 &&  $_POST['cantidad7']>0 && $_POST['costoxunidad7']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 17 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox7'], "int"),
            GetSQLValueString($_POST['cantidad7'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad7']*$_POST['cantidad7'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 18 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad7'], "int"),
            GetSQLValueString($_POST['costoxunidad7'], "double"),
            GetSQLValueString($_POST['id_prox7'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox8']>0 &&  $_POST['cantidad8']>0 && $_POST['costoxunidad8']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 19 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox8'], "int"),
            GetSQLValueString($_POST['cantidad8'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad8']*$_POST['cantidad8'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 20 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad8'], "int"),
            GetSQLValueString($_POST['costoxunidad8'], "double"),
            GetSQLValueString($_POST['id_prox8'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox9']>0 &&  $_POST['cantidad9']>0 && $_POST['costoxunidad9']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 21 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox9'], "int"),
            GetSQLValueString($_POST['cantidad9'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad9']*$_POST['cantidad9'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 22 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad9'], "int"),
            GetSQLValueString($_POST['costoxunidad9'], "double"),
            GetSQLValueString($_POST['id_prox9'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox10']>0 &&  $_POST['cantidad10']>0 && $_POST['costoxunidad10']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 23 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox10'], "int"),
            GetSQLValueString($_POST['cantidad10'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad10']*$_POST['cantidad10'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 24 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad10'], "int"),
            GetSQLValueString($_POST['costoxunidad10'], "double"),
            GetSQLValueString($_POST['id_prox10'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
    if ($_POST['id_prox11']>0 &&  $_POST['cantidad11']>0 && $_POST['costoxunidad11']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 25 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimacompra, "int"),
            GetSQLValueString($_POST['id_prox11'], "int"),
            GetSQLValueString($_POST['cantidad11'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['costoxunidad11']*$_POST['cantidad11'], "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\compras\registrarcompra.php - QUERY 26 */ UPDATE producto 
										   SET cantidadensede=cantidadensede+%s, precioultimacompra=%s 
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad11'], "int"),
            GetSQLValueString($_POST['costoxunidad11'], "double"),
            GetSQLValueString($_POST['id_prox11'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $z=1;
    }
}
            if ($z==1) {
                header("Location: registrarcompra.php");
            }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>.:Apuestas Hípicas:.</title>
<link href="../estilo/ventasmie.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 6]><script type="text/javascript">alert("ATENCIÓN: Este software solo funciona con \nMicrosoft Internet Explorer 6 o superior\n\nPor favor, actualice su navegador");location.href='../acceso.php';</script><![endif]-->
<!--[if lt IE 8]><link href="../estilo/styleIE7.css" rel="stylesheet"> <!--<![endif]-->
<style> body{ background:#e0e0e0;} input:focus{ outline:none !important;border-color:#719ECE;box-shadow:0 0 20px #719ECE;} </style>
<script src="../js/jquery-1.9.1.min.js"></script><script src="../js/fjava.js"></script>
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true;}else{alert("Datos enviados por favor presione enter solo una vez mas.");return false;}}
</script>




</head>
<body onload="javascript:document.all.form1.focus(); scrollChat(); Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<CENTER>


            <br/><input type="button" onclick="window.location='./index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Volver Menu Anteriol" />
				</CENTER>
<CENTER>

<table>
<tr>
    <th>

<FONT SIZE=6 COLOR=red>Verifique Los Datos Antes de Darle a Registrar</FONT>
</th>
</tr>

        <tr><td>


 
	
	<div id="container" class="container">

        <div id="content" class="content">
			<div id="taquilla" class="taquilla">

				<div style="float:Center; font-size:16px;padding:3px 0px 0px 0px; color: #0CF;width:309px;background:#333;">&nbsp;
 					<?php echo "REGISTRAR COMPRAS";?>
				</div>

            </div>

</td></tr>
        <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">
					<form  method="post" name="form1" id="form1" autocomplete="off"
						onsubmit="return chequearEnvio();">
						
 <div id="hipodromo" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        if ($t>0 && isset($id_pro)) {?>
                        	<select name="id_prox" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro as $id_producto) {?>
                                    <option value="<?php echo $id_producto;?>" 
                                        >
                                        <?php echo $productoensede[$x]." Disponible: ...".$cantidadensede[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad" id="costoxunidad" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro1)) {?>
                        	<select name="id_prox1" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro1 as $id_producto1) {?>
                                    <option value="<?php echo $id_producto1;?>" 
                                        >
                                        <?php echo $productoensede1[$x]." Disponible: ...".$cantidadensede1[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad1" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad1" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad1" id="costoxunidad1" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro2)) {?>
                        	<select name="id_prox2" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro2 as $id_producto2) {?>
                                    <option value="<?php echo $id_producto2;?>" 
                                        >
                                        <?php echo $productoensede2[$x]." Disponible: ...".$cantidadensede2[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad2" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad2" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad2" id="costoxunidad2" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro3)) {?>
                        	<select name="id_prox3" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro3 as $id_producto3) {?>
                                    <option value="<?php echo $id_producto3;?>" 
                                        >
                                        <?php echo $productoensede3[$x]." Disponible: ...".$cantidadensede3[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad3" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad3" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad3" id="costoxunidad3" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro4)) {?>
                        	<select name="id_prox4" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro4 as $id_producto4) {?>
                                    <option value="<?php echo $id_producto4;?>" 
                                        >
                                        <?php echo $productoensede4[$x]." Disponible: ...".$cantidadensede4[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad4" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad4" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad4" id="costoxunidad4" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro5)) {?>
                        	<select name="id_prox5" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro5 as $id_producto5) {?>
                                    <option value="<?php echo $id_producto5;?>" 
                                        >
                                        <?php echo $productoensede5[$x]." Disponible: ...".$cantidadensede5[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad5" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad5" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad5" id="costoxunidad5" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro6)) {?>
                        	<select name="id_prox6" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro6 as $id_producto6) {?>
                                    <option value="<?php echo $id_producto6;?>" 
                                        >
                                        <?php echo $productoensede6[$x]." Disponible: ...".$cantidadensede6[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad6" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad6" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad6" id="costoxunidad6" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro7)) {?>
                        	<select name="id_prox7" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro7 as $id_producto7) {?>
                                    <option value="<?php echo $id_producto7;?>" 
                                        >
                                        <?php echo $productoensede7[$x]." Disponible: ...".$cantidadensede7[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad7" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad7" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad7" id="costoxunidad7" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro8)) {?>
                        	<select name="id_prox8" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro8 as $id_producto8) {?>
                                    <option value="<?php echo $id_producto8;?>" 
                                        >
                                        <?php echo $productoensede8[$x]." Disponible: ...".$cantidadensede8[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad8" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad8" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad8" id="costoxunidad8" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro9)) {?>
                        	<select name="id_prox9" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro9 as $id_producto9) {?>
                                    <option value="<?php echo $id_producto9;?>" 
                                        >
                                        <?php echo $productoensede9[$x]." Disponible: ...".$cantidadensede9[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad9" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad9" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad9" id="costoxunidad9" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro10)) {?>
                        	<select name="id_prox10" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro1 as $id_producto10) {?>
                                    <option value="<?php echo $id_producto10;?>" 
                                        >
                                        <?php echo $productoensede10[$x]." Disponible: ...".$cantidadensede10[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad10" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad10" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad10" id="costoxunidad10" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
 <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">

						
 <div id="hipodromo1" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                        $x=0;
                        if ($t>0 && isset($id_pro11)) {?>
                        	<select name="id_prox11" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:580px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE PRODUCTO AQUÍ";?>
                        		</option><?php
                                foreach ($id_pro11 as $id_producto11) {?>
                                    <option value="<?php echo $id_producto11;?>" 
                                        >
                                        <?php echo $productoensede11[$x]." Disponible: ...".$cantidadensede11[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COSTO X UNIDAD
                            	
                            </div>
							

							

                            <div id="apuesta" class="apuesta" style="float:Center; font-size:18px"><?php
                                $x=1;
                                for ($i = 1; $i <= 1; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background: #e0e0e0;">
                                        
										


						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cantidad11" style="width:72px; font-size:19px" 
                                        maxlength="7" value="" id="cantidad11" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" name="costoxunidad11" id="costoxunidad11" 
                                        onkeypress="javascript:return validarNro(event)"
                                        type="text"  onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        style="width:110px; font-size:18px" maxlength="19"value="" />
                                         
                                       
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
							</td>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<tr>
<td>
<br/><br/><br/><br/>

<input type="hidden" name="MM_insert" value="form1" />

                            <div id="realizarapuesta" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="submit" id="imprimir" name="imprimir" 
                                value="REGISTRAR COMPRA" style="width:340px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="REGISTRAR COMPRA"
                               />

 





                            </div><!-- end .realizarapuesta -->

<br/><br/><br/><br/>



                            <div id="recargar" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="button" onclick="window.location='registrarcompra.php';"
                                value="ACTUALIZAR PÁGINA" style="width:300px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="actualiza página"/>
                            </div><!-- end .realizarapuesta -->
                        </div><!-- end .centroapuesta -->

					</form>
                </div><!-- end .izquierda -->
                
				</div>
            </div><!-- end .jugada -->
        </div><!-- end .content -->
 
 
 
                        </form>    

              </div><!-- end .mensajeChat -->  


        <div class="footer"><!-- end .footer --></div>
    </div><!-- end .container -->
	
	</td></tr>







</table>

</CENTER>
</body>
</html>
<script language="javascript">document.getElementById("numCa1").focus();</script>

<?php
mysqli_free_result($Recordset1);?>
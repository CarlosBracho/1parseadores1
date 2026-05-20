<?php
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
 
    $query_Recordset12 = sprintf('/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 1 */ SELECT 
		inventarionegocios.id_productoinventarionegocios, inventarionegocios.cantidadinventarionegocios, producto.productoensede, producto.precio_actual, producto.precioultimacompra

		FROM 
			inventarionegocios, producto
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = 2 AND inventarionegocios.id_productoinventarionegocios = producto.id_producto
			
			ORDER BY 
			producto.productoensede');
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);

$z=0;
$t=0;
$x=0;
if ($totalRows_Recordset12>0) {
    do {
        $id_pro[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual[$t]=$row_Recordset12['precio_actual'];

        $id_pro1[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre1[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios1[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual1[$t]=$row_Recordset12['precio_actual'];

        $id_pro2[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre2[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios2[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual2[$t]=$row_Recordset12['precio_actual'];

        $precio_actual[$t]=$row_Recordset12['precio_actual'];
        $id_pro3[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre3[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios3[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual3[$t]=$row_Recordset12['precio_actual'];
        
        $id_pro4[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre4[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios4[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual4[$t]=$row_Recordset12['precio_actual'];
            
        $id_pro5[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre5[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios5[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual5[$t]=$row_Recordset12['precio_actual'];
        
        $id_pro6[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre6[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios6[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual6[$t]=$row_Recordset12['precio_actual'];

        $id_pro7[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre7[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios7[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual7[$t]=$row_Recordset12['precio_actual'];
    
        $id_pro8[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre8[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios8[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual8[$t]=$row_Recordset12['precio_actual'];
        
        $id_pro9[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre9[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios9[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual9[$t]=$row_Recordset12['precio_actual'];
        
        $id_pro10[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre10[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios10[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual10[$t]=$row_Recordset12['precio_actual'];
        
        $id_pro11[$t]=$row_Recordset12['id_productoinventarionegocios'];
        $producto_nombre11[$t]=$row_Recordset12['productoensede'];
        $cantidadinventarionegocios11[$t]=$row_Recordset12['cantidadinventarionegocios'];
        $precio_actual11[$t]=$row_Recordset12['precio_actual'];

        $t++;
    } while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));
}



    $query_Recordset2 = sprintf('/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 2 */ SELECT 
		inventarioydemas.id_documentoinventarioydemas 
		FROM 
			inventarioydemas 
		WHERE  
			inventarioydemas.tipoinventarioydemas = 4
		ORDER BY 
			inventarioydemas.id_inventarioydemas DESC LIMIT 1');
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$ultimaventa=$row_Recordset2['id_documentoinventarioydemas']+1;




    $query_Recordset3 = sprintf('/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 3 */ SELECT 
		negocio.id_negocio, negocio.nombre_negocio
		
		FROM 
			negocio
		WHERE  
			negocio.id_negocio >= 2
		ORDER BY 
			negocio.id_negocio');
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$t=0;
$x=0;
if ($totalRows_Recordset3>0) {
    do {
        $id_nego[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego[$t]=$row_Recordset3['nombre_negocio'];
                                 
        $t++;
    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
}

    $query_Recordset4 = sprintf('/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 4 */ SELECT 
		usuario.id_usuario, usuario.usuario_nombre
		
		FROM 
			usuario
		WHERE  
			usuario.usuario_tipo = 3
		ORDER BY 
			usuario.usuario_nombre');
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);



$t=0;
$x=0;
if ($totalRows_Recordset4>0) {
    do {
        $usuario_nombre[$t]=$row_Recordset4['usuario_nombre'];
        $id_usuario[$t]=$row_Recordset4['id_usuario'];
        $t++;
    } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
}









if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
    echo "COMPRA REGISTRADA";
    echo '<br/>';
    echo $_POST['id_prox'];
    echo '<br/>';
    echo '<br/>';
    echo $_POST['cantidad'];
    echo '<br/>';
    echo '<br/>';
    if ($_POST['id_prox']>0 &&  $_POST['cantidad']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 5 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox'], "int"),
            GetSQLValueString($_POST['cantidad'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 6 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad'], "int"),
            GetSQLValueString($_POST['id_prox'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                
        $z=1;
    }
    if ($_POST['id_prox1']>0 &&  $_POST['cantidad1']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 7 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox1'], "int"),
            GetSQLValueString($_POST['cantidad1'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 8 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad1'], "int"),
            GetSQLValueString($_POST['id_prox1'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                        
        $z=1;
    }
    if ($_POST['id_prox2']>0 &&  $_POST['cantidad2']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 9 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox2'], "int"),
            GetSQLValueString($_POST['cantidad2'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 10 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad2'], "int"),
            GetSQLValueString($_POST['id_prox2'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                        
        $z=1;
    }
    if ($_POST['id_prox3']>0 &&  $_POST['cantidad3']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 11 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox3'], "int"),
            GetSQLValueString($_POST['cantidad3'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 12 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad3'], "int"),
            GetSQLValueString($_POST['id_prox3'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                        
                                                
        $z=1;
    }
    if ($_POST['id_prox4']>0 &&  $_POST['cantidad4']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 13 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox4'], "int"),
            GetSQLValueString($_POST['cantidad4'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 14 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad4'], "int"),
            GetSQLValueString($_POST['id_prox4'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                                                                
        $z=1;
    }
    if ($_POST['id_prox5']>0 &&  $_POST['cantidad5']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 15 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox5'], "int"),
            GetSQLValueString($_POST['cantidad5'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 16 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad5'], "int"),
            GetSQLValueString($_POST['id_prox5'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                                                                
        $z=1;
    }
    if ($_POST['id_prox6']>0 &&  $_POST['cantidad6']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 17 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox6'], "int"),
            GetSQLValueString($_POST['cantidad6'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 18 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad6'], "int"),
            GetSQLValueString($_POST['id_prox6'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                                                                
        $z=1;
    }
    if ($_POST['id_prox7']>0 &&  $_POST['cantidad7']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 19 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox7'], "int"),
            GetSQLValueString($_POST['cantidad7'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 20 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad7'], "int"),
            GetSQLValueString($_POST['id_prox7'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                                                                
                                                    
        $z=1;
    }
    if ($_POST['id_prox8']>0 &&  $_POST['cantidad8']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 21 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox8'], "int"),
            GetSQLValueString($_POST['cantidad8'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 22 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad8'], "int"),
            GetSQLValueString($_POST['id_prox8'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                                                                
        $z=1;
    }
    if ($_POST['id_prox9']>0 &&  $_POST['cantidad9']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 23 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox9'], "int"),
            GetSQLValueString($_POST['cantidad9'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 24 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad9'], "int"),
            GetSQLValueString($_POST['id_prox9'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                                                                
        $z=1;
    }
    if ($_POST['id_prox10']>0 &&  $_POST['cantidad10']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 25 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox10'], "int"),
            GetSQLValueString($_POST['cantidad10'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 26 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad10'], "int"),
            GetSQLValueString($_POST['id_prox10'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                                                                
                                                    
        $z=1;
    }
    if ($_POST['id_prox11']>0 &&  $_POST['cantidad11']>0 && $_POST['local']>1 && $_POST['usuario']>0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 27 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, 
	id_usuarioreninventario, id_negocio, valor, costo, fecha, hora
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimaventa, "int"),
            GetSQLValueString($_POST['id_prox11'], "int"),
            GetSQLValueString($_POST['cantidad11'], "int"),
            GetSQLValueString(4, "int"),
            GetSQLValueString($_POST['usuario'], "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 28 */ UPDATE inventarionegocios
										   SET cantidadinventarionegocios=cantidadinventarionegocios-%s
											   WHERE id_productoinventarionegocios = %s AND id_negocioinventarionegocios = 2",
            GetSQLValueString($_POST['cantidad11'], "int"),
            GetSQLValueString($_POST['id_prox11'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                                                                
                                            

        $z=1;
    }
}
                $query_Recordset13 = sprintf('/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 29 */ SELECT 
		inventarioydemas.id_inventarioydemas, inventarioydemas.id_productoinventarioydemas, producto.precio_actual, producto.precioultimacompra

		FROM 
			inventarioydemas, producto
		WHERE  
			inventarioydemas.id_productoinventarioydemas = producto.Id_producto AND inventarioydemas.valor = 0.01 AND inventarioydemas.tipoinventarioydemas = 4');
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);


    do {
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\descargo\descargo.php - QUERY 30 */ UPDATE inventarioydemas 
										   SET valor=%s, costo=%s
											   WHERE id_inventarioydemas = %s",
            GetSQLValueString($row_Recordset13['precio_actual'], "double"),
            GetSQLValueString($row_Recordset13['precioultimacompra'], "double"),
            GetSQLValueString($row_Recordset13['id_inventarioydemas'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset13 = mysqli_fetch_assoc($Recordset13));
            if ($z==1) {
                header("Location: descargo.php");
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
 					<?php echo "REGISTRAR VENTA";?>
				</div>

            </div>

</td></tr>
        <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">
					<form  method="post" name="form1" id="form1" autocomplete="off"
						onsubmit="return chequearEnvio();">
						                          <?php
                                                $x=0;

                        if ($t>0 && isset($id_nego)) {?>
                        	<select name="local" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:340px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE LOCAL";?>
                        		</option><?php
                                foreach ($id_nego as $id_negomas) {?>
                                    <option value="<?php echo $id_negomas;?>" 
                                        >
                                        <?php echo $nombre_nego[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>
							                          <?php
                                                $x=0;

                        if ($t>0 && isset($id_usuario)) {?>
                        	<select name="usuario" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:140px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE VENDEDOR";?>
                        		</option><?php
                                foreach ($id_usuario as $id_usuariox) {?>
                                    <option value="<?php echo $id_usuariox;?>" 
                                        >
                                        <?php echo $usuario_nombre[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>					
						
						
 <div id="hipodromo" style="font-size:18px; float:Center; width:580px; height:35px;background:#CCC">
                        <?php
                                                $x=0;

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
                                        <?php echo $producto_nombre[$x]." Disponible: ...".$cantidadinventarionegocios[$x]." Precio: ...".$precio_actual[$x]?>

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
                                        <?php echo $producto_nombre1[$x]." Disponible: ...".$cantidadinventarionegocios1[$x]." Precio: ...".$precio_actual1[$x]?>
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
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre2[$x]." Disponible: ...".$cantidadinventarionegocios2[$x]." Precio: ...".$precio_actual2[$x]?>
                                    </option><?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:400px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre3[$x]." Disponible: ...".$cantidadinventarionegocios3[$x]." Precio: ...".$precio_actual3[$x]?>
                                    </option>

									<?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:400px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre4[$x]." Disponible: ...".$cantidadinventarionegocios4[$x]." Precio: ...".$precio_actual4[$x]?>
                                    </option><?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre5[$x]." Disponible: ...".$cantidadinventarionegocios5[$x]." Precio: ...".$precio_actual5[$x]?>
                                    </option><?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre6[$x]." Disponible: ...".$cantidadinventarionegocios6[$x]." Precio: ...".$precio_actual6[$x]?>
                                    </option><?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre7[$x]." Disponible: ...".$cantidadinventarionegocios7[$x]." Precio: ...".$precio_actual7[$x]?>
                                    </option><?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre8[$x]." Disponible: ...".$cantidadinventarionegocios8[$x]." Precio: ...".$precio_actual8[$x]?>
                                    </option><?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre9[$x]." Disponible: ...".$cantidadinventarionegocios9[$x]." Precio: ...".$precio_actual9[$x]?>
                                    </option><?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre10[$x]." Disponible: ...".$cantidadinventarionegocios10[$x]." Precio: ...".$precio_actual10[$x]?>
                                    </option><?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                        <?php echo $producto_nombre11[$x]." Disponible: ...".$cantidadinventarionegocios11[$x]." Precio: ...".$precio_actual11[$x]?>
                                    </option><?php                        		$x++;
                                }?>
                        	</select><?php
                        }?>

						
						
						</div><!-- end .hipodromo -->
						
						</td><td>

						
						
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px">

                            <div style="background:#e0e0e0; margin:0px 0px 0px 0px; width:500px; float:Center;height:28px;
                            	padding:2px 0px 0px 30px; text-align:center; color:#000;">
                            	CANTIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            	
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
                                value="REGISTRAR VENTA" style="width:340px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="REGISTRAR VENTA"
                               />

 





                            </div><!-- end .realizarapuesta -->

<br/><br/><br/><br/>



                            <div id="recargar" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="button" onclick="window.location='descargo.php';"
                                value="ACTUALIZAR PÁGINA" style="width:300px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="actualiza página"/>
                            </div><!-- end .realizarapuesta -->
                        </div><!-- end .centroapuesta -->

					</form>
                </div><!-- end .izquierda -->
                
				</div>
            </div><!-- end .jugada -->
        </div><!-- end .content -->
 



        <div class="footer"><!-- end .footer --></div>
    </div><!-- end .container -->
	
	</td></tr>







</table>

</CENTER>
</body>
</html>
<script language="javascript">document.getElementById("numCa1").focus();</script>

<?php



mysqli_free_result($Recordset12);?>
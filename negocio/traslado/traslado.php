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





    $query_Recordset1 = sprintf('/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 1 */ SELECT 
		producto.id_producto, producto.productoensede, producto.cantidadensede, producto.precioultimacompra
		
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
        $productoensede[$t]=$row_Recordset1['productoensede'];
        $cantidadensede[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro1[$t]=$row_Recordset1['id_producto'];
        $productoensede1[$t]=$row_Recordset1['productoensede'];
        $cantidadensede1[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra1[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro2[$t]=$row_Recordset1['id_producto'];
        $productoensede2[$t]=$row_Recordset1['productoensede'];
        $cantidadensede2[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra2[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro3[$t]=$row_Recordset1['id_producto'];
        $productoensede3[$t]=$row_Recordset1['productoensede'];
        $cantidadensede3[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra3[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro4[$t]=$row_Recordset1['id_producto'];
        $productoensede4[$t]=$row_Recordset1['productoensede'];
        $cantidadensede4[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra4[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro5[$t]=$row_Recordset1['id_producto'];
        $productoensede5[$t]=$row_Recordset1['productoensede'];
        $cantidadensede5[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra5[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro6[$t]=$row_Recordset1['id_producto'];
        $productoensede6[$t]=$row_Recordset1['productoensede'];
        $cantidadensede6[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra6[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro7[$t]=$row_Recordset1['id_producto'];
        $productoensede7[$t]=$row_Recordset1['productoensede'];
        $cantidadensede7[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra7[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro8[$t]=$row_Recordset1['id_producto'];
        $productoensede8[$t]=$row_Recordset1['productoensede'];
        $cantidadensede8[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra8[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro9[$t]=$row_Recordset1['id_producto'];
        $productoensede9[$t]=$row_Recordset1['productoensede'];
        $cantidadensede9[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra9[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro10[$t]=$row_Recordset1['id_producto'];
        $productoensede10[$t]=$row_Recordset1['productoensede'];
        $cantidadensede10[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra10[$t]=$row_Recordset1['precioultimacompra'];
        $id_pro11[$t]=$row_Recordset1['id_producto'];
        $productoensede11[$t]=$row_Recordset1['productoensede'];
        $cantidadensede11[$t]=$row_Recordset1['cantidadensede'];
        $precioultimacompra11[$t]=$row_Recordset1['precioultimacompra'];
        $t++;
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}



    $query_Recordset2 = sprintf('/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 2 */ SELECT 
		inventarioydemas.id_documentoinventarioydemas 
		FROM 
			inventarioydemas 
		WHERE  
			inventarioydemas.tipoinventarioydemas = 2
		ORDER BY 
			inventarioydemas.id_inventarioydemas DESC LIMIT 1');
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$ultimotraslado=$row_Recordset2['id_documentoinventarioydemas']+1;




    $query_Recordset3 = sprintf('/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 3 */ SELECT 
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
        $id_nego1[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego1[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego2[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego2[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego3[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego3[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego4[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego4[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego5[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego5[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego6[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego6[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego7[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego7[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego8[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego8[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego9[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego9[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego10[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego10[$t]=$row_Recordset3['nombre_negocio'];
        $id_nego11[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego11[$t]=$row_Recordset3['nombre_negocio'];
        $t++;
    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
}











if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
    if ($_POST['id_prox']>0 &&  $_POST['cantidad']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 4 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox'], "int"),
            GetSQLValueString($_POST['cantidad'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 5 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad'], "int"),
            GetSQLValueString($_POST['id_prox'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                
            
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 6 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
            
            
            
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 7 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 8 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox'], "int"),
                GetSQLValueString($_POST['cantidad'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
            
        $z=1;
    }
    if ($_POST['id_prox1']>0 &&  $_POST['cantidad1']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 9 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox1'], "int"),
            GetSQLValueString($_POST['cantidad1'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 10 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad1'], "int"),
            GetSQLValueString($_POST['id_prox1'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                        
                                        
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 11 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox1'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                        
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox1'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 12 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad1'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox1'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 13 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox1'], "int"),
                GetSQLValueString($_POST['cantidad1'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox2']>0 &&  $_POST['cantidad2']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 14 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox2'], "int"),
            GetSQLValueString($_POST['cantidad2'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 15 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad2'], "int"),
            GetSQLValueString($_POST['id_prox2'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 16 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox2'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                        
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox2'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 17 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad2'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox2'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 18 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox2'], "int"),
                GetSQLValueString($_POST['cantidad2'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox3']>0 &&  $_POST['cantidad3']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 19 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox3'], "int"),
            GetSQLValueString($_POST['cantidad3'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 20 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad3'], "int"),
            GetSQLValueString($_POST['id_prox3'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 21 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox3'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                        
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox3'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 22 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad3'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 23 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox3'], "int"),
                GetSQLValueString($_POST['cantidad3'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox4']>0 &&  $_POST['cantidad4']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 24 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox4'], "int"),
            GetSQLValueString($_POST['cantidad4'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 25 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad4'], "int"),
            GetSQLValueString($_POST['id_prox4'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 26 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox4'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                                                                
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox4'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 27 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad4'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox4'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 28 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox4'], "int"),
                GetSQLValueString($_POST['cantidad4'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox5']>0 &&  $_POST['cantidad5']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 29 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox5'], "int"),
            GetSQLValueString($_POST['cantidad5'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 30 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad5'], "int"),
            GetSQLValueString($_POST['id_prox5'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 31 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox5'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                                                                
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox5'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 32 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad5'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox5'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 33 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox5'], "int"),
                GetSQLValueString($_POST['cantidad5'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox6']>0 &&  $_POST['cantidad6']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 34 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario, 
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox6'], "int"),
            GetSQLValueString($_POST['cantidad6'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 35 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad6'], "int"),
            GetSQLValueString($_POST['id_prox6'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 36 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox6'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                                                                
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox6'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 37 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad6'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox6'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 38 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox6'], "int"),
                GetSQLValueString($_POST['cantidad6'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox7']>0 &&  $_POST['cantidad7']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 39 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario,
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox7'], "int"),
            GetSQLValueString($_POST['cantidad7'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 40 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad7'], "int"),
            GetSQLValueString($_POST['id_prox7'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 41 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox7'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                                                                
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox7'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 42 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad7'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox7'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 43 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox7'], "int"),
                GetSQLValueString($_POST['cantidad7'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox8']>0 &&  $_POST['cantidad8']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 44 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario,
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox8'], "int"),
            GetSQLValueString($_POST['cantidad8'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 45 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad8'], "int"),
            GetSQLValueString($_POST['id_prox8'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 46 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox8'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                                                                
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox8'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 47 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad8'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox8'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 48 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox8'], "int"),
                GetSQLValueString($_POST['cantidad8'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox9']>0 &&  $_POST['cantidad9']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 49 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario,
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox9'], "int"),
            GetSQLValueString($_POST['cantidad9'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 50 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad9'], "int"),
            GetSQLValueString($_POST['id_prox9'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 51 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox9'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                                                                
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox9'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 52 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad9'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox9'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 53 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox9'], "int"),
                GetSQLValueString($_POST['cantidad9'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox10']>0 &&  $_POST['cantidad10']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 54 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario,
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox10'], "int"),
            GetSQLValueString($_POST['cantidad10'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 55 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad10'], "int"),
            GetSQLValueString($_POST['id_prox10'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 56 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox10'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                                                                
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox10'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 57 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad10'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox10'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 58 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox10'], "int"),
                GetSQLValueString($_POST['cantidad10'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $z=1;
    }
    if ($_POST['id_prox11']>0 &&  $_POST['cantidad11']>=0 && $_POST['local']>1) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 59 */ INSERT INTO inventarioydemas (id_documentoinventarioydemas, id_productoinventarioydemas, cantidad, tipoinventarioydemas, id_usuarioreninventario,
	id_negocio, valor, fecha, hora
					 ) 
 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($ultimotraslado, "int"),
            GetSQLValueString($_POST['id_prox11'], "int"),
            GetSQLValueString($_POST['cantidad11'], "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString(0.01, "double"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString($nuevahora1, "date")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 60 */ UPDATE producto 
										   SET cantidadensede=cantidadensede-%s
											   WHERE id_producto = %s",
            GetSQLValueString($_POST['cantidad11'], "int"),
            GetSQLValueString($_POST['id_prox11'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset111 = sprintf(
            '/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 61 */ SELECT 
		inventarionegocios.Id_inventarionegocios, inventarionegocios.id_productoinventarionegocios, inventarionegocios.id_negocioinventarionegocios
		
		FROM 
			inventarionegocios
		WHERE  
			inventarionegocios.id_negocioinventarionegocios = %s AND inventarionegocios.id_productoinventarionegocios = %s',
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['id_prox11'], "int")
        );
        $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
        $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
        $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
                                                                                
        if ($row_Recordset111['id_productoinventarionegocios']==$_POST['id_prox11'] && $row_Recordset111['id_negocioinventarionegocios']==$_POST['local']) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 62 */ UPDATE inventarionegocios 
										   SET cantidadinventarionegocios=cantidadinventarionegocios+%s
											   WHERE id_negocioinventarionegocios = %s AND  id_productoinventarionegocios = %s",
                GetSQLValueString($_POST['cantidad11'], "int"),
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox11'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 63 */ INSERT INTO inventarionegocios (id_negocioinventarionegocios, id_productoinventarionegocios, cantidadinventarionegocios
					 ) 
					 VALUES (%s, %s, %s)",
                GetSQLValueString($_POST['local'], "int"),
                GetSQLValueString($_POST['id_prox11'], "int"),
                GetSQLValueString($_POST['cantidad11'], "int")
            );
                
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
            
        
        
    
        $z=1;
    }
}

    
            $query_Recordset12 = sprintf('/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 64 */ SELECT 
		inventarioydemas.id_inventarioydemas, inventarioydemas.id_productoinventarioydemas, producto.precio_actual, producto.precioultimacompra

		FROM 
			inventarioydemas, producto
		WHERE  
			inventarioydemas.id_productoinventarioydemas = producto.Id_producto AND inventarioydemas.valor = 0.01 AND inventarioydemas.tipoinventarioydemas = 2');
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);


    do {
        $updateSQL = sprintf(
            "/* PARSEADORES1 negocio\traslado\traslado.php - QUERY 65 */ UPDATE inventarioydemas 
										   SET valor=%s
											   WHERE id_inventarioydemas = %s",
            GetSQLValueString($row_Recordset12['precioultimacompra'], "double"),
            GetSQLValueString($row_Recordset12['id_inventarioydemas'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset12 = mysqli_fetch_assoc($Recordset12));


            if ($z==1) {
                header("Location: traslado.php");
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
						                          <?php
                                                $x=0;

                        if ($t>0 && isset($id_nego)) {?>
                        	<select name="local" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:140px; height:35px"
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
                                        <?php echo $productoensede[$x]." Disponible: ...".$cantidadensede[$x]." Precio Ult Compra: ...".$precioultimacompra[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select>
							

							<?php
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
                                        <?php echo $productoensede1[$x]." Disponible: ...".$cantidadensede1[$x]." Precio Ult Compra: ...".$precioultimacompra1[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede2[$x]." Disponible: ...".$cantidadensede2[$x]." Precio Ult Compra: ...".$precioultimacompra2[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede3[$x]." Disponible: ...".$cantidadensede3[$x]." Precio Ult Compra: ...".$precioultimacompra3[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede4[$x]." Disponible: ...".$cantidadensede4[$x]." Precio Ult Compra: ...".$precioultimacompra4[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede5[$x]." Disponible: ...".$cantidadensede5[$x]." Precio Ult Compra: ...".$precioultimacompra5[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede6[$x]." Disponible: ...".$cantidadensede6[$x]." Precio Ult Compra: ...".$precioultimacompra6[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede7[$x]." Disponible: ...".$cantidadensede7[$x]." Precio Ult Compra: ...".$precioultimacompra7[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede8[$x]." Disponible: ...".$cantidadensede8[$x]." Precio Ult Compra: ...".$precioultimacompra8[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede9[$x]." Disponible: ...".$cantidadensede9[$x]." Precio Ult Compra: ...".$precioultimacompra9[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede10[$x]." Disponible: ...".$cantidadensede10[$x]." Precio Ult Compra: ...".$precioultimacompra10[$x]?>
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
                            	CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                        <?php echo $productoensede11[$x]." Disponible: ...".$cantidadensede11[$x]." Precio Ult Compra: ...".$precioultimacompra11[$x]?>
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
                            	DISPONIBLE &nbsp;&nbsp;&nbsp;&nbsp;CANTIDAD A MOVER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DESTINO
                            	
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
                                value="REGISTRAR TRASLADO" style="width:340px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="REGISTRAR TRASLADO"
                               />

 





                            </div><!-- end .realizarapuesta -->

<br/><br/><br/><br/>



                            <div id="recargar" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="button" onclick="window.location='traslado.php';"
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
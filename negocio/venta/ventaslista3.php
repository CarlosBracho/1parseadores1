<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;


$fechadesde = $_GET['fechadesde'];
$fechahasta = $_GET['fechahasta'];
$usuario = $_GET['usuario'];


$horaactual=horaactual();
$fechasistema=fechaactualbd();
//echo $fechasistema;
$hora1=$horaactual;
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
//echo horaampm($nuevahora1);
//echo $nuevahora1;

$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}



if ($usuario == -1) {
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 negocio\venta\ventaslista3.php - QUERY 1 */ SELECT 
inventarioydemas.id_documentoinventarioydemas,
inventarioydemas.cantidad, 
inventarioydemas.valor, 
inventarioydemas.hora,
inventarioydemas.fecha,
producto.productoensede, 
producto.id_categoriaenproductoensede, 
usuario.usuario_nombre, 
negocio.nombre_negocio

FROM 
inventarioydemas,
producto,
usuario,
negocio
WHERE

(inventarioydemas.fecha >= %s AND
inventarioydemas.fecha <= %s)
					
AND inventarioydemas.tipoinventarioydemas = 3 
AND producto.Id_producto = inventarioydemas.id_productoinventarioydemas
AND usuario.usuario_negocio = 4
AND usuario.id_usuario = inventarioydemas.id_usuarioreninventario
AND negocio.Id_negocio = inventarioydemas.id_negocio
ORDER BY 
inventarioydemas.fecha,
usuario.usuario_nombre
ASC",
        GetSQLValueString($fechadesde, "date"),
        GetSQLValueString($fechahasta, "date")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
} else {
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 negocio\venta\ventaslista3.php - QUERY 2 */ SELECT 
inventarioydemas.id_documentoinventarioydemas,
inventarioydemas.cantidad, 
inventarioydemas.valor, 
inventarioydemas.hora,
inventarioydemas.fecha,
producto.productoensede, 
producto.id_categoriaenproductoensede, 
usuario.usuario_nombre, 
negocio.nombre_negocio

FROM 
inventarioydemas,
producto,
usuario,
negocio
WHERE

(inventarioydemas.fecha >= %s AND
inventarioydemas.fecha <= %s)
					
AND inventarioydemas.tipoinventarioydemas = 3 
AND producto.Id_producto = inventarioydemas.id_productoinventarioydemas
AND usuario.usuario_negocio = 4
AND usuario.id_usuario = inventarioydemas.id_usuarioreninventario
AND inventarioydemas.id_usuarioreninventario = %s
AND negocio.Id_negocio = inventarioydemas.id_negocio
ORDER BY 
inventarioydemas.fecha,
usuario.usuario_nombre
ASC",
        GetSQLValueString($fechadesde, "date"),
        GetSQLValueString($fechahasta, "date"),
        GetSQLValueString($usuario, "int")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
}






$tVta1=0;
$x=0;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>

<script src="../js/jquery-1.9.1.min.js"></script>

<!-- InstanceBeginEditable name="aHead" -->
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">


<CENTER>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
            <br/><input type="button" onclick="window.location='./index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Volver Menu Anteriol" />
				</CENTER>
<div class="container">
  
  
  
  
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px;" class="xfirefox">
    <?php if ($totalRows_Recordset2>0) {?>    

    <div style="height:100%; padding:0px 0px 200px 0px ">   
	<table width="100%" border="0" align="center" border="4" >
  		<tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td width="92">NUMERO DE FACTURA</td>
		  		            <td width="112">FECHA</td>

		  <td width="192">VENDEDOR</td>
          <td width="638">PRODUCTO</td>
		  <td width="92">CANTIDAD</td>
          <td width="121">PRECIO C/U</td>
          <td width="121">VALOR X CANTIDAD</td>

        </tr>
        <?php do { ?>
          <tr class="brillo">

		              <td align="left"><?php echo $row_Recordset2['id_documentoinventarioydemas']; ?></td>
					  		  		  		              <td align="left"><?php echo $row_Recordset2['fecha']; ?></td>

		              <td align="left"><?php echo $row_Recordset2['usuario_nombre']; ?></td>

            <td align="left"><?php echo $row_Recordset2['productoensede']; ?></td>

			            <td align="center"><?php echo $row_Recordset2['cantidad']; ?></td>

            <td align="left"><?php echo $row_Recordset2['valor'];?>
            <td align="left"><?php
            $PRECIOXCANTIDAD=$row_Recordset2['valor']*$row_Recordset2['cantidad'];
            
            echo $PRECIOXCANTIDAD;?>  
			
			<?php
$tVta=$PRECIOXCANTIDAD;
            
 $tVta1 += $tVta;?>
</td>
          </tr>
		  
          <?php } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2)); ?>
		  
	  TOTAL VENTAS:. <strong><?php echo number_format($tVta1, 2, ",", "."); ?></strong></td>

      </table>
      </div>

	      <?php }?>  
</div>
                            <div id="recargar" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="button" onclick="window.location='ventasfecha2.php';"
                                value="ACTUALIZAR PÁGINA" style="width:300px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="actualiza página"/>
                            </div><!-- end .realizarapuesta -->
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php

?>
<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;
$fecha=fechaactualbd();

$query_Recordset1 = "/* PARSEADORES1 negocio\inventariolistadeprecios\inventariodiariocadadia.php - QUERY 1 */ SELECT 
producto.productoensede, 
producto.precio_actual, 
inventarionegocios.cantidadinventarionegocios, 
inventarionegocios.Id_inventarionegocios, 
producto.Id_producto, 
producto.id_categoriaenproductoensede
FROM 
producto,
inventarionegocios  
WHERE
inventarionegocios.id_negocioinventarionegocios = 2 AND inventarionegocios.id_productoinventarionegocios = producto.id_producto
ORDER BY 
inventarionegocios.Id_inventarionegocios ASC";
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset2 = "/* PARSEADORES1 negocio\inventariolistadeprecios\inventariodiariocadadia.php - QUERY 2 */ SELECT 
inventariodiario.id_numerodeinventariodiario 
FROM 
inventariodiario
ORDER BY 
inventariodiario.id_numerodeinventariodiario DESC LIMIT 1";
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$numerodeinventariodiarioagrabar=$row_Recordset2['id_numerodeinventariodiario']+1;
$fechadeldocumento=$_POST['datepicker'];


$t=0;
$x=0;

if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
    $numeroregistros = $_POST["id_producto"];
    $numeroregistros = count($numeroregistros);
    $i=0;
    $id_producto = $_POST["id_producto"];
    $cantidad = $_POST["cantidad"];
    $linea = $_POST["linea"];
    $precio = $_POST["precio"];

    for ($i=0;$i<$numeroregistros;$i++) {
        // En este caso el número de registros será de 3
        // La consulta insert se ejecutará por tanto 3 veces, tantas como decimos en el bucle for
        
        
        

        $id_productomult = $id_producto[$i];
        $cantidadmult = $cantidad[$i];
        $lineamult = $linea[$i];
        $preciomult = $precio[$i];
        
        
          
          
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\inventariolistadeprecios\inventariodiariocadadia.php - QUERY 3 */ INSERT INTO inventariodiario (id_numerodeinventariodiario, id_negocioeninventariodiario, id_productoeninventariodiario,
				cantidaddedichoinventario, fechadeinventariodiario, lineainventariodiario, precioinventariodiario) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($numerodeinventariodiarioagrabar, "int"),
            GetSQLValueString(2, "int"),
            GetSQLValueString($id_productomult, "int"),
            GetSQLValueString($cantidadmult, "int"),
            GetSQLValueString($fechadeldocumento, "date"),
            GetSQLValueString($lineamult, "int"),
            GetSQLValueString($preciomult, "double")
        );

        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    }
}
 
 
 
 









/*
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1"  ) {
            $f=0;
            $exito=1;
            $id_producto = $_POST["id_producto"];
        $numeroregistros = count($id_producto);//contamos el número de registros introducidos
for ($i=0;$i<$numeroregistros;$i++) {
                $insertSQL = sprintf("INSERT INTO inventariodiario (id_numerodeinventariodiario, id_negocioeninventariodiario, id_productoeninventariodiario,
                cantidaddedichoinventario, fechadeinventariodiario, lineainventariodiario, precioinventariodiario)
                     VALUES (%s, %s, %s, %s, %s, %s, %s)",
                           GetSQLValueString($numerodeinventariodiarioagrabar, "int"),
                           GetSQLValueString($localselecionado, "int"),
                           GetSQLValueString($_POST['id_producto'], "int"),
                           GetSQLValueString($_POST['cantidad'], "int"),
                           GetSQLValueString($fechadeldocumento, "date"),
                           GetSQLValueString($_POST['linea'], "int"),
                           GetSQLValueString($_POST['precio'], "double"));

                $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
            }
}
*/

$x=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>


<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui.js"></script>
<script>
$(function() { 
 $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
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
					<form  method="post" name="form1" id="form1" autocomplete="off"
						>
						
						Fecha:
<input type="text" name="datepicker" id="datepicker" value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>" />
					<br/><br/><br/><br/><br/><br/><br/><br/>
						
						
						
						
    <?php if ($totalRows_Recordset1>0) {
    $cant= 0; ?>    

    <div style="height:100%; padding:0px 0px 300px 0px ">   
	<table width="100%" border="4" align="center" >
  		<tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
				          <td width="50">N</td>

          <td width="638">NOMBRE</td>
          <td width="92">CANTIDAD</td>
		  <td width="92">PRECIO</td>
        </tr>
		
        <?php

        
        do {
            ?>
          <tr class="brillo">
		  	

            <td align="left"><?php echo $row_Recordset1['productoensede']; ?></td>


          </tr>
          <?php
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
		  </div></div>
		  </table>
<table width="100%" border="4" align="center" >
<tr><td>
	      <?php
}?>  
		              <input type="hidden" name="MM_insert" value="form1" />

		                              <div id="realizarelregistrodelinventariodiario" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="submit" id="imprimir" name="imprimir" 
                                value="REGISTRAR INVENTARIO DIARIO" style="width:340px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="REGISTRAR INVENTARIO DIARIO"
                               />
							   </div>
                                      <div id="recargar" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="button" onclick="window.location='inventariolistadeprecioscadadia1.php';"
                                value="ACTUALIZAR PÁGINA" style="width:300px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="actualiza página"/>
                            </div><!-- end .realizarapuesta -->
		  
</td></tr>
</table>

      
      

		  
		  

</form>

  <!-- InstanceEndEditable -->
  </div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
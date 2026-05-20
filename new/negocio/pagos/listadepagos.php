<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;


$query_Recordset1 = "/* PARSEADORES1 new\negocio\pagos\listadepagos.php - QUERY 1 */ SELECT * FROM pagospendientes,
categoria WHERE  pagospendientes.idcategoriaengopendiente = categoria.Id_categoria_producto   ORDER BY pagospendientes.Id_pagopendiente DESC";
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


$x=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hipicas:.</title>

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

    <?php if ($totalRows_Recordset1>0) {?>    

    <div style="height:100%; padding:0px 0px 300px 0px ">   
	<table width="100%" border="4" align="center">
  		<tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
				<td width="11">NUMERO</td>

          <td width="70">FECHA</td>
		            <td width="121">CUENTA DONDE SE PAGARA</td>

          <td width="70">MONTO</td>
		  <td width="121">REPORTADO</td>
		  <td width="121">DEPARTAMENTO</td>
          <td width="92">TELEFONO PARA REPORTAR EL PAGO</td>
		  <td width="121">DATOS DEL PAGO REALIZADO</td>
          <td width="92">PRODUCTO O SERVICIO A CANCELAR</td>
		            <td width="92">EDITAR</td>

        </tr>
        <?php do { ?>
          <tr class="brillo">
		    <td align="left"><?php echo $row_Recordset1['Id_pagopendiente']; ?></td>
            <td align="left"><?php echo $row_Recordset1['fechapago']; ?></td>
			            <td align="left"><?php echo $row_Recordset1['cuentabanco']; ?></td>

            <td align="left"><?php echo $row_Recordset1['monto']; ?></td>
            <td align="left"><?php echo $row_Recordset1['reportado']; ?></td>
            <td align="left"><?php echo $row_Recordset1['nombre_categoria_producto']; ?></td>
            <td align="left"><?php echo $row_Recordset1['telefono']; ?></td>			
			<td align="left"><?php echo $row_Recordset1['datosdelpagohecho']; ?></td>
            <td align="center"><?php echo $row_Recordset1['productoacancelar']; ?></td>
			<td align="center">
			<input type="button" onclick="window.location='editarunpago.php?numero=<?php echo $row_Recordset1['Id_pagopendiente'];?>';"
                                value="Editar" style="width:70px; font-size:20px; height:100px"
                                 title="Editar"/>
</td>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
      </table>
      </div>
	      <?php }?>  
</div>
                            <div id="recargar" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="button" onclick="window.location='listadepagos.php';"
                                value="ACTUALIZAR PÃGINA" style="width:300px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="actualiza pÃ¡gina"/>
                            </div><!-- end .realizarapuesta -->
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas HÃ­picas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>
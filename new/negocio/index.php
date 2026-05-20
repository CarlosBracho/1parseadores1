<?php
require_once('./Connections/conexionbanca.php');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>.:Modulo Compras:.</title>



<!-- InstanceBeginEditable name="aHead" -->
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">

<CENTER>
<table>
<tr>
    <th>

<FONT SIZE=6 COLOR=red>Seleccione una opcion para continuar</FONT>
</th>
</tr>

        <tr><td>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
            <br/><input type="button" onclick="window.location='./venta/index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Modulo Ventas" />
</td></tr>
        <tr><td>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
            <br/><input type="button" onclick="window.location='./descargo/index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Modulo De Descargos" />
</td></tr>
        <tr><td>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
            <br/><input type="button" onclick="window.location='./inventariolistadeprecios/index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Ver Inventario y Lista De Precios" />
</td></tr>
        <tr><td>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
            <br/><input type="button" onclick="window.location='./pagos/index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Registrar Pagos Pendientes" />
</td></tr>
        <tr><td>
		
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>	
Solo Para Usar Por Carlos
	  <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
	  <br/><input align="center" type="button" onclick="window.location='./productos/index.php';"
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Modulo Productos" />
</td></tr>
        <tr><td>
Solo Para Usar Por Carlos
	  <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
	  <br/><input align="center" type="button" onclick="window.location='./traslado/index.php';"
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Modulo Traslados" />
</td></tr>
        <tr><td>
Solo Para Usar Por Carlos
	  <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
	  <br/><input align="center" type="button" onclick="window.location='./compras/index.php';"
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Modulo Compras" />
</td></tr>

</table>

</CENTER>
</body>
<!-- InstanceEnd --></html>

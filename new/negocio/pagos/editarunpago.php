<?php
require_once('../Connections/conexionbanca.php');


if (isset($_GET['numero'])) {
    $numero=$_GET['numero'];
}
    if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
        $numero=$_POST['numero'];
    }
    
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\negocio\pagos\editarunpago.php - QUERY 1 */ SELECT * FROM pagospendientes  
WHERE
pagospendientes.Id_pagopendiente = %s",
    GetSQLValueString($numero, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$z=0;
$x=0;
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\negocio\pagos\editarunpago.php - QUERY 2 */ UPDATE pagospendientes 
										   SET telefono= %s, fechapago= %s, reportado= %s, datosdelpagohecho= %s
											   WHERE Id_pagopendiente = %s",
        GetSQLValueString($_POST['telefono'], "text"),
        GetSQLValueString($_POST['datepicker'], "date"),
        GetSQLValueString($_POST['reportado'], "text"),
        GetSQLValueString($_POST['datosdelpagohecho'], "text"),
        GetSQLValueString($_POST['numero'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    header("Location: listadepagos.php");
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>.:Modulo Compras:.</title>

<script src="../js/jquery-1.9.1.js"></script>
<script src="../js/jquery-ui.js"></script>
<script>
$(function() { 
 $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>



</head>
<body onload="javascript:document.all.form1.focus(); scrollChat(); Javascript:history.go(1);" onunload="Javascript:history.go(1);">

<CENTER>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
            <br/><input type="button" onclick="window.location='./listadepagos.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Volver A Lista De Pagos" />
				<br/><br/><br/><FONT SIZE=99 COLOR=red>Es importante que salga la fecha, hora, monto y numero de referencia..</FONT><br/><br/><br/>
<div class="container">
  
  
  
  
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px;" class="xfirefox">


    <div style="height:100%; padding:0px 0px 300px 0px ">   
	<table width="100%" border="4" align="center">
						<form  method="post" name="form1" id="form1" autocomplete="off"
						onsubmit="return chequearEnvio();">
						
  		<tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
		<td width="11">NUMERO</td>
          <td width="92">FECHA</td>
          <td width="92">MONTO</td>
		            <td width="121">REPORTADO</td>
          <td width="92">TELEFONO PARA REPORTAR EL PAGO</td>
          <td width="121">CUENTA DONDE SE PAGARA</td>
		  <td width="121">DATOS DEL PAGO REALIZADO</td>
          <td width="92">PRODUCTO O SERVICIO A CANCELAR</td>


        </tr>
          <tr class="brillo">
		  
		  	                           <td align="left"><?php echo $row_Recordset1['Id_pagopendiente']; ?></td>

		  
            <td align="left">
			<input type="text" name="datepicker" id="datepicker" value="<?php echo htmlentities($row_Recordset1['fechapago'], ENT_COMPAT, 'utf-8'); ?>" />

			
			</td>
			
			
			
			
			
			
			
            <td align="left"><?php echo $row_Recordset1['monto']; ?></td>
			            <td align="left">
			                                        <input class="textbox" onchange="clean(),clean2()"
                                        type="text" name="reportado" style="width:142px; font-size:19px" 
                                        maxlength="1000" value="<?php echo $row_Recordset1['reportado']; ?>" id="reportado" 
                                         onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique como se reporto"
                                        onblur=""/>
			</td>			
            <td align="left">
			                                        <input class="textbox" onchange="clean(),clean2()"
                                        type="text" name="telefono" style="width:142px; font-size:19px" 
                                        maxlength="18" value="<?php echo $row_Recordset1['telefono']; ?>" id="telefono" 
                                         onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de telefono"
                                        onblur=""/>
			</td>			
			</td>
            <td align="left"><?php echo $row_Recordset1['cuentabanco']; ?></td>
			<td align="left">
						                                        <input class="textbox" onchange="clean(),clean2()"
                                        type="text" name="datosdelpagohecho" style="width:142px; font-size:19px" 
                                        maxlength="1000" value="<?php echo $row_Recordset1['datosdelpagohecho']; ?>" id="datosdelpagohecho" 
                                         onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique datosdelpagohecho"
                                        onblur=""/>
			
			</td>
            <td align="center"><?php echo $row_Recordset1['productoacancelar']; ?></td>
      </table>
	  <input type="hidden" name="MM_insert" value="form1" />

	                          <input type="hidden" name="numero" value="<?php echo $row_Recordset1['Id_pagopendiente']; ?>" />

      </div>
</div>
                            <div id="realizarapuesta" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="submit" id="imprimir" name="imprimir" 
                                value="REGISTRAR MODIFICACION" style="width:340px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="REGISTRAR MODIFICACION"
                               />


					</form>



  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas HÃ­picas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>

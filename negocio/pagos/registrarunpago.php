<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;
$horaactual=horaactual();
$fechasistema=fechaactualbd();
$fecha=fechaactualbd();
$z=0;
$t=0;
$x=0;
    




    $query_Recordset3 = sprintf('/* PARSEADORES1 negocio\pagos\registrarunpago.php - QUERY 1 */ SELECT 
		negocio.id_negocio, negocio.nombre_negocio
		
		FROM 
			negocio
		WHERE  
			negocio.id_negocio >= 1
		ORDER BY 
			negocio.id_negocio');
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

    $query_Recordset4 = sprintf('/* PARSEADORES1 negocio\pagos\registrarunpago.php - QUERY 2 */ SELECT 
		categoria.Id_categoria_producto, categoria.nombre_categoria_producto
		
		FROM 
			categoria
		
		ORDER BY 
			categoria.nombre_categoria_producto');
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$t=0;
$x=0;
if ($totalRows_Recordset4>0) {
    do {
        $Id_categoria_producto[$t]=$row_Recordset4['Id_categoria_producto'];
        $nombre_categoria_producto[$t]=$row_Recordset4['nombre_categoria_producto'];
        $t++;
    } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
}


$t=0;
$x=0;
if ($totalRows_Recordset3>0) {
    do {
        $id_nego[$t]=$row_Recordset3['id_negocio'];
        $nombre_nego[$t]=$row_Recordset3['nombre_negocio'];
                                 
        $t++;
    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
}








if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
    if ($_POST['local']>=0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 negocio\pagos\registrarunpago.php - QUERY 3 */ INSERT INTO pagospendientes (tipodepagopendiente, cuentabanco, fechapago, estadopago, datosdelpagohecho, id_negocioenpagopendiente, productoacancelar, idcategoriaengopendiente, telefono, monto
					 ) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(0, "int"),
            GetSQLValueString($_POST['cuentabanco'], "text"),
            GetSQLValueString($_POST['datepicker'], "date"),
            GetSQLValueString(0, "int"),
            GetSQLValueString('PENDIENTE', "text"),
            GetSQLValueString($_POST['local'], "int"),
            GetSQLValueString($_POST['productoacancelar'], "text"),
            GetSQLValueString($_POST['categoria_producto'], "text"),
            GetSQLValueString($_POST['telefono'], "text"),
            GetSQLValueString($_POST['monto'], "double")
        );
                
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                
                
        $z=1;
    }
}

            if ($z==1) {
                header("Location: registrarunpago.php");
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
 					<?php echo "AGREGAR PAGO PENDIENTE";?>
				</div>

            </div>

</td></tr>
        <tr><td>


            <div id="jugada" class="jugada" style="height:75%">
 				<div id="izquierda" class="izquierda">
					<form  method="post" name="form1" id="form1" autocomplete="off"
						onsubmit="return chequearEnvio();">
												<br/><br/><br/>

										<div style="float:Center; font-size:16px;padding:3px 0px 0px 0px; color: #0CF;width:309px;background:#333;">&nbsp;
 					<?php echo "SELECIONES NEGOCIO";?>
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
						
				</div>
						                   
						<br/><br/><br/>
									<div style="float:Center; font-size:16px;padding:3px 0px 0px 0px; color: #0CF;width:309px;background:#333;">&nbsp;
 					<?php echo "SELECIONES CATEGORIA DE PRODUCTO";?>
				</div>
						                          <?php
                                                $x=0;

                        if ($t>0 && isset($Id_categoria_producto)) {?>
                        	<select name="categoria_producto" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:740px; height:35px"
                        		onChange="javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECIONES CATEGORIA DE PRODUCTO";?>
                        		</option><?php
                                foreach ($Id_categoria_producto as $Id_categoria_productox) {?>
                                    <option value="<?php echo $Id_categoria_productox;?>" 
                                        >
                                        <?php echo $nombre_categoria_producto[$x]?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        }?>
						<br/><br/><br/>
						
																			<div style="float:Center; font-size:16px;padding:3px 0px 0px 0px; color: #0CF;width:309px;background:#333;">&nbsp;
 					<?php echo "SELECIONE LA FECHA DEL DIA QUE LLEGO LA MERCANCIA:";?>
				</div>		
<input type="text" name="datepicker" id="datepicker" value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>" />
					<br/><br/><br/><br/><br/><br/><br/><br/>
						<br/><br/>
						
						
						
						
						
						
																<div style="float:Center; font-size:16px;padding:3px 0px 0px 0px; color: #0CF;width:309px;background:#333;">&nbsp;
 					<?php echo "ESCRIBA EL PRODUCTO QUE SE VA A CANCELAR";?>
				</div>
						
						
 <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="productoacancelar" style="width:772px; font-size:19px" 
                                        maxlength="177" value="" id="productoacancelar" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique que se esta pagando"
                                        onblur=""/>
										
										<br/><br/><br/><br/>
										<div style="float:Center; font-size:16px;padding:3px 0px 0px 0px; color: #0CF;width:309px;background:#333;">&nbsp;
 					<?php echo "ESCRIBA LOS DATOS BANCARIOS DE LA CUENTA A DODNE SE VA A DEPOSITAR";?>
				</div>
						
						
 <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="cuentabanco" style="width:772px; font-size:19px" 
                                        maxlength="177" value="" id="cuentabanco" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique datos bancarios"
                                        onblur=""/>
										<br/><br/><br/><br/>
																				<div style="float:Center; font-size:16px;padding:3px 0px 0px 0px; color: #0CF;width:309px;background:#333;">&nbsp;
 					<?php echo "ESCRIBA EL MONTO A CANCELAR";?>
				</div>
										
										 <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="monto" style="width:772px; font-size:19px" 
                                        maxlength="17" value="" id="monto" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique monto"
                                        onblur=""/>
										<br/><br/><br/><br/>
										<div style="float:Center; font-size:16px;padding:3px 0px 0px 0px; color: #0CF;width:309px;background:#333;">&nbsp;
 					<?php echo "ESCRIBA NUMERO DE TELEFONO PARA PODER REPORTAR";?>
				</div>
										
										 <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="telefono" style="width:772px; font-size:19px" 
                                        maxlength="27" value="" id="telefono" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique telefono"
                                        onblur=""/>
										<br/><br/><br/><br/>


<tr>
<td>
<br/><br/><br/><br/>

<input type="hidden" name="MM_insert" value="form1" />

                            <div id="realizarapuesta" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="submit" id="imprimir" name="imprimir" 
                                value="AGREGAR PAGO PENDIENTE" style="width:540px; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="AGREGAR PRODUCTO AL SISTEMA"
                               />

 





                            </div><!-- end .realizarapuesta -->

<br/><br/><br/><br/>



                            <div id="recargar" style="padding:10px 0px 0px 0px;float:Center; width:580px">
                                <input type="button" onclick="window.location='registrarunpago.php';"
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

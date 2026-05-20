<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && isset($_POST['fecha_inicio'])) {
    $fechaBusqueda=fechaymd($_POST['fecha_inicio']);
    $inicio=$_POST['fecha_inicio'];
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 ventas\ventas_historial_lista.php - QUERY 1 */ SELECT * FROM carrera 
		WHERE 
			carrera.est_confirmacion=0 AND 
			carrera.fec_carrera = %s 
		ORDER BY carrera.hor_carrera DESC",
        GetSQLValueString($fechaBusqueda, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
} else {
    $inicio=fechanueva(fechaactualbd());
    $fechaBusqueda=fechaactualbd();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 ventas\ventas_historial_lista.php - QUERY 2 */ SELECT * FROM carrera 
		WHERE 
			carrera.est_confirmacion=0 AND 
			carrera.fec_carrera = %s 
		ORDER BY carrera.hor_carrera DESC",
        GetSQLValueString($fechaBusqueda, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
}
$fechaInicial=fechanueva(fechaactualbd());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseVentas2.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#FFF" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#E5E5E5" } 
</script>
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
</head>

<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="content5">
	<!-- InstanceBeginEditable name="Contenido" -->
   <div style="background: #333; width:100%; float:left; padding:50px 2px 2px 2px; color:#FFF; font-size:28px; text-align:center">
        DIVIDENDOS Y RETIRADOS
   </div><!-- end .container -->
   
	<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
	onsubmit="return chequearEnvio();">   
       <div style="width:100%; float:left; text-align:right; padding:10px 2px 2px 2px;font-size:18px;">
            Dividendos anteriores: 
    		<input name="fecha_inicio" style="font-size:18px; width:100px; heigth:18px;" type="text" id="fecha" 
        	tabindex="1" title="formato: dd-mm-aaaa" class="tcal" 
        	value="<?php echo htmlentities($fechaInicial, ENT_COMPAT, 'utf-8'); ?>"/>
            <input type="submit" value="Aceptar" onClick="return enviado()" title="buscar dividendos anteriores" />
       </div><!-- end .container -->
	   <input type="hidden" name="MM_update" value="form1" />
	</form>    
	<?php
    if ($totalRows_Recordset1>=1) {
        do { ?>
			<table width="100%" border="0" style="font-size:12px; background:#FFFFFF; border-collapse:collapse;

  border: none;">
			  <tr style="background: #5EAEFF;color:#FFF; font-size:14px;">
				<td width="47%" align="center" valign="middle">HIPÓDROMO</td>
				<td width="13%" align="center" valign="middle"># CARRERA</td>
				<td colspan="2" align="center" valign="middle">LLEGADA</td>
				<td width="11%" align="center" valign="middle">GANADOR</td>
				<td width="8%" align="center" valign="middle">PLACE</td>
				<td width="7%" align="center" valign="middle">SHOW</td>
			  </tr>
			  <tr>
				<td rowspan="4" align="center" valign="middle" style="font-size:28px; background:#CCCCCC">
					<?php echo $row_Recordset1['nom_hipodromo']; ?>
                </td>
				<td rowspan="4" align="center" valign="middle" style="font-size:28px; background:#CCCCCC">
                	<?php echo $row_Recordset1['num_carrera']; ?>
                </td>
				<td width="4%" align="right">1ro</td>
				<td width="10%">
                	<?php echo $row_Recordset1['eje_primero']; ?>
                </td>
				<td>
					<?php echo $row_Recordset1['div_primero_gan']; ?>
                </td>
				<td>
					<?php echo $row_Recordset1['div_primero_pla']; ?>
                </td>
				<td>
                	<?php echo $row_Recordset1['div_primero_sho']; ?>
                </td>
			  </tr>
			  <tr>
				<td align="right">2do</td>
				<td>
<?php
if ($row_Recordset1['eje_segundo']<>99) {
            echo $row_Recordset1['eje_segundo'];
        }
?>
<?php
if ($row_Recordset1['eje_segundo']==99) {
    echo $row_Recordset1['eje_doble_primero'];
}
?>
                </td>
				<td>
<?php
if ($row_Recordset1['eje_segundo']<>99) {
}
?>
<?php
if ($row_Recordset1['eje_segundo']==99) {
    echo $row_Recordset1['div_doble_primero_gan'];
}
?>
                </td>
				<td>
<?php
if ($row_Recordset1['eje_segundo']<>99) {
    echo $row_Recordset1['div_segundo_pla'];
}
?>
<?php
if ($row_Recordset1['eje_segundo']==99) {
    echo $row_Recordset1['div_doble_primero_pla'];
}
?>
                </td>

		
				<td>
<?php
if ($row_Recordset1['eje_segundo']<>99) {
    echo $row_Recordset1['div_segundo_sho'];
}
?>
<?php
if ($row_Recordset1['eje_segundo']==99) {
    echo $row_Recordset1['div_doble_primero_sho'];
}
?>
                </td>
			  </tr>




			  <tr>
				<td align="right">3ro</td>
			<td>
<?php
if ($row_Recordset1['eje_tercero']<>99) {
    echo $row_Recordset1['eje_tercero'];
}
?>
<?php
if ($row_Recordset1['eje_tercero']==99) {
    echo $row_Recordset1['eje_doble_segundo'];
}
?>

                </td>
				<td>&nbsp;</td>
				<td>
<?php
if ($row_Recordset1['eje_tercero']<>99) {
}
?>
<?php
if ($row_Recordset1['eje_tercero']==99) {
    echo $row_Recordset1['div_doble_segundo_pla'];
}
?>
</td>
				<td>
<?php
if ($row_Recordset1['eje_tercero']<>99) {
    echo $row_Recordset1['div_tercero_sho'];
}
?>
<?php
if ($row_Recordset1['eje_tercero']==99) {
    echo $row_Recordset1['div_doble_segundo_sho'];
}
?>


                </td>
			  </tr>

<tr>
<td align="right">4ro</td>
				<td>
                	<?php echo $row_Recordset1['eje_cuarto']; ?>
	</td>		
<td>



                </td>
				<td>&nbsp;</td>

				<td>
<?php
if ($row_Recordset1['div_doble_tercero_sho']<>0.00) {
    echo $row_Recordset1['div_doble_tercero_sho'];
}
?>
<?php
if ($row_Recordset1['div_doble_tercero_sho']==0.00) {
}
?>
                </td>

			  </tr>









			  <tr style="background:#CCCCCC">
				<td colspan="2" align="left">
                	EXÓTICAS: 
                    Ex-> <?php echo $row_Recordset1['ord_exacta']." ".$row_Recordset1['div_exacta']." | "; ?>
                    Tr-> <?php echo $row_Recordset1['ord_trifecta']." ".$row_Recordset1['div_trifecta']." | "; ?>
                    Su-> <?php echo $row_Recordset1['ord_superfecta']." ".$row_Recordset1['div_superfecta']." | "; ?>
                </td>
				<td colspan="5" align="left">
<?php
if ($row_Recordset1['eje_primero']<>99) {
}
?>

<?php
if ($row_Recordset1['eje_primero']==99) {
    echo "CARRERA CANCELADA";
}
?>

                	RETIRADOS:
                    <?php echo BuscarRetirados($row_Recordset1['cod_carrera']);?>
                    </td>
				</tr>
			  <tr style="background:#FFF">
				<td height="1" colspan="7" align="right">&nbsp;</td>
				</tr>
			</table>
		<?php
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
	<?php
    } else { ?>
        <table style="width:100%; font-size:28px" align="left">
            <tr class="brillo">
              <td colspan="4"><?php echo "No existen registros";?></td>
              </tr>
        </table>
	<?php }?>
</td>
  </tr>
</table>
  <!-- InstanceEndEditable -->
</div><!-- end .container -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>
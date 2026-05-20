<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xVendedor_Recordset1 = $_SESSION['MM_id_usuario'];
$codigotaquilla=$_SESSION['MM_cod_taquilla'];
$query_Recordset1 = sprintf("/* PARSEADORES1 ventas\ventas_pagar_apuesta.php - QUERY 1 */ SELECT * FROM venta WHERE venta.cod_taquilla = %s", GetSQLValueString($codigotaquilla, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && ($_POST["ticket"]!="") && ($_POST["ser_venta"]!="")) {
    $numerotiket2=$_POST['ticket'];
    $serial=$_POST['ser_venta'];
    $query_Recordset2 = sprintf("/* PARSEADORES1 ventas\ventas_pagar_apuesta.php - QUERY 2 */ SELECT * FROM venta, carrera WHERE venta.cod_carrera = carrera.cod_carrera AND venta.ticket = %s AND venta.ser_venta = %s AND venta.cod_taquilla = %s", GetSQLValueString($_POST['ticket'], "int"), GetSQLValueString($_POST['ser_venta'], "text"), GetSQLValueString($codigotaquilla, "int"));
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    $bandera=0;
    $est_carrera=$row_Recordset2['est_carrera'];
    $eje_primero=$row_Recordset2['eje_primero'];
    $eje_segundo=$row_Recordset2['eje_segundo'];
    $eje_tercero=$row_Recordset2['eje_tercero'];
    if ($totalRows_Recordset2>=1) {
        do {
            if ($row_Recordset2['est_ticket']==2) {
                $bandera=1;
            } // ticket cancelado
             if ($row_Recordset2['est_ticket']==0) {
                 $bandera=2;
             } // ticket eliminado
        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
    }
    if ($totalRows_Recordset2>=1 && ($bandera==0) && ($est_carrera==0 && $eje_primero>0 && $eje_segundo>0 && $eje_tercero>0)) {
        $insertGoTo = "ventas_pagar_apuestas_procesar.php?recordID=$numerotiket2";
    } else {
        $variable=$numerotiket2." Serial: ".$serial."";
        $insertGoTo = "ventas_ticket_no_cerrada.php?recordID=$variable";
        if ($totalRows_Recordset2==0) { //No existe
            $variable=$numerotiket2." Serial: ".$serial."";
            $insertGoTo = "ventas_ticket_no_encontrado.php?recordID=$variable";
        }
        if ($bandera==1) { //Ya cancelado
            $variable=$numerotiket2." Serial: ".$serial."";
            $insertGoTo = "ventas_ticket_ya_cancelado.php?recordID=$variable";
        }
        if ($bandera==2) { //Eliminado
            $variable=$numerotiket2." Serial: ".$serial."";
            $insertGoTo = "ventas_ticket_no_encontrado.php?recordID=$variable";
        }
    }
    header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseVentas2.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script LANGUAGE="JavaScript">
<!--
var cuenta=0;
function enviado() { 
if (cuenta == 0)
{
cuenta++;
return true;
}
else 
{
alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
return false;
}
}
// -->
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
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
</head>

<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="content5">
	<!-- InstanceBeginEditable name="Contenido" -->

<table width="600" border="0" align="left">
 <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return chequearEnvio();">
  <tr>
    <td colspan="3" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><span class="veintepunto"><strong>PAGAR APUESTA</strong></span></td>
    </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Número del Ticket:</td>
    <td colspan="2"><input type="text" name="ticket" value="" size="20" title="indique número de ticket" /></td>
  </tr>
  <tr>
    <td align="right">Serial:</td>
    <td colspan="2"><input type="text" name="ser_venta" value="" size="20" title="indique serial del ticket" /></td>
  </tr>
  <tr>
    <td width="293" align="right">&nbsp;</td>
    <td width="156" align="right"><input type="submit" value="Aceptar" onClick="return enviado()" title="buscar ticket" /></td>
    <td width="137">&nbsp;</td>
  </tr>
  <input type="hidden" name="MM_insert" value="form1" />
  </form>
</table>
  <!-- InstanceEndEditable -->
</div><!-- end .container -->
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>
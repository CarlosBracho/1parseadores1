<?php
if (isset($_GET["recordID"]) && isset($_GET["uVenta"]) && isset($_GET["xIndex"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
    $usuario_venta = $_GET["uVenta"];
}
$xaction = $_SERVER['PHP_SELF'];
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1" && (isset($_POST["aceptar"]) || isset($_POST["cancelar"]))) {
    if (isset($_POST["aceptar"])) {
        require_once('../Connections/conexionbanca.php');
        $nti=$_POST["numerotiket2"];
        $query_Recordset1 = sprintf("/* PARSEADORES1 ventasmie\conf_ticket.php - QUERY 1 */ SELECT num_ticket 
			FROM venta 
			WHERE ticket = %s", GetSQLValueString($nti, "int"));
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        if ($totalRows_Recordset1>0) {
            do {
                $nt=$row_Recordset1['num_ticket'];
                $insertSQL2 = sprintf(
                    "/* PARSEADORES1 ventasmie\conf_ticket.php - QUERY 2 */ UPDATE venta
							SET 
							est_impresion=%s
							WHERE num_ticket=%s",
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($nt, "int")
                );
                $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        }
        if (!isset($_POST["xindex"])) {
            $insertGoTo = "index_ventas.php";
        } else {
            $insertGoTo = "index.php";
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
    if (isset($_POST["cancelar"])) {
        $numerotiket2=$_POST["numerotiket2"];
        $usuarioVenta=$_POST["usuario"];
        $xindex=$_POST["xindex"];
        if (isset($_POST["xindex"])) {
            $xindex=0;
        } else {
            $xindex=1;
        }
        $insertGoTo = "t_imprimeticket.php?recordID=$numerotiket2&uVenta=$usuarioVenta&xIndex=$xindex&paso=1";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        } else {
            if (isset($_POST["xindex"])) {
                $insertGoTo = "index_ventas.php";
            } else {
                $insertGoTo = "index.php";
            }
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script>
function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true;}else{alert("El formulario ya está siendo enviado, por favor aguarde un instante.");return false;}}
</script>
</head>
<body>
<form action="<?php echo $xaction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
	onsubmit="return chequearEnvio();">
    <table width="100%" border="0" style="font-size:28px;">
        <tr align="center">
            <td height="156" colspan="3">
            <font size="+4">Atención:</font><br/>
            El ticket #<?php echo $_GET["xTicket"]; ?> fue impreso correctamente?</td>
        </tr>
        <tr>
            <td width="48%" height="67" align="right">
                <input type="submit" id="aceptar" name="aceptar" value="Si" style="width:150px; font-size:20px; height:45px"
                title="aceptar"/>
            </td>
            <td width="2%" align="left">&nbsp;</td>
            <td width="50%" align="left">
                <input type="submit" id="cancelar" name="cancelar" value="No" style="width:150px; font-size:20px; height:45px"
                title="cancelar"/>
            </td>
        </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="numerotiket2" value="<?php echo $_GET["xTicket"]; ?>" />
    <input type="hidden" name="xindex" value="<?php echo $_GET["xIndex"]; ?>" />
    <input type="hidden" name="usuario" value="<?php echo $usuario_venta; ?>" />
</form>    
</body>
</html>
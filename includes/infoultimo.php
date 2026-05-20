<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
?>
<script language="javascript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#FC0" } 
function cambiacolor_out(celda){ celda.style.backgroundColor="#A0A0A0" }
</script>
<?php
$fechasistema=fechaactualbd();
$horasistema=horaactual();
$query_Recordset4 = sprintf(
    "/* PARSEADORES1 includes\infoultimo.php - QUERY 1 */ SELECT 
venta.ticket, 
venta.hor_venta 
FROM 
venta
USE INDEX(id_us_fe_fe)
WHERE 
venta.lin_ticket = 1 AND 
venta.est_ticket=1 AND 
venta.fec_venta = %s AND
venta.id_usuario = %s 
ORDER BY venta.num_ticket DESC LIMIT 1",
    GetSQLValueString($fechasistema, "date"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$query_Recordset5 = sprintf(
    "/* PARSEADORES1 includes\infoultimo.php - QUERY 2 */ SELECT 
venta.ticket, 
venta.hor_venta, 
venta.cod_tventa,
venta.mon_venta,
venta.cod_cliente,
venta.efectivoO,
venta.num_caballo,
carrera.nom_hipodromo, 
carrera.num_carrera,
venta.ser_venta 
FROM 
venta, 
carrera 
WHERE 
venta.cod_carrera = carrera.cod_carrera AND  
venta.est_ticket=1 AND 
venta.fec_venta = %s AND
venta.id_usuario = %s AND
venta.ticket = %s 
ORDER BY venta.lin_ticket DESC LIMIT 100",
    GetSQLValueString($fechasistema, "date"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
    GetSQLValueString($row_Recordset4['ticket'], "int")
);
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
$nom_hipodromo=$row_Recordset5['nom_hipodromo'];
$num_carrera=$row_Recordset5['num_carrera'];
$serial=$row_Recordset5['ser_venta'];
$rest = substr($serial, 0, 3);
$tipo=$row_Recordset5['cod_tventa']/1;
$monto=$row_Recordset5['mon_venta']/1;
$ejemplar=$row_Recordset5['num_caballo']/1;
$efectivoO=$row_Recordset5['efectivoO']/1;

?>

<table width="100%" border="1" cellpadding="0" cellspacing="0" 
        	style="line-height:12px; font-size:14px; background:#e0e0e0; color:#000000">
 <tr>
                <td width="30%" height="20" align="center">
                	<font color="#000000"><?php echo $nom_hipodromo; ?></font>
                </td>
                <td width="30%" align="center">CARRERA:&nbsp;<font color="#000000"><?php echo $num_carrera; ?></font></td>
                <td width="40%" align="center">CODIGO DE PAGO:&nbsp;<font color="#000000"><?php echo $rest; ?></font></td>
            </tr>
        </table>
      <table width="100%" border="2" cellpadding="0" cellspacing="0" 
        	style="line-height:12px; font-size:16px; background:#e0e0e0; color:#000000">
        	<tr>
				<td width="30%" align="center">CLIENTE</td>
                <td width="15%" height="21" align="center">EJEMP</td>
                <td width="25%" align="center">APU</td>
                <td width="30%" align="center">MONTO</td>
            </tr><?php
            $s=0;
            $apostado=0;
            do { ?>
				
                <tr>
									<td height="21" align="center">
						<font color="#000000"><?php echo $row_Recordset5['cod_cliente'] ?></font>
                    </td>
                    <td height="21" align="center">
						<font color="#000000"><?php echo $row_Recordset5['num_caballo'] ?></font>
                    </td>
                    <td align="center">
						<font color="#000000">
						<?php
                        if ($row_Recordset5['cod_tventa']=="1") {
                            echo "GAN";
                        } elseif ($row_Recordset5['cod_tventa']=="2") {
                            echo "PLA";
                        } elseif ($row_Recordset5['cod_tventa']=="3") {
                            echo "SHO";
                        } elseif ($row_Recordset5['cod_tventa']=="4") {
                            echo "EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="5") {
                            echo "TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="6") {
                            echo "SUPE";
                        } elseif ($row_Recordset5['cod_tventa']=="7") {
                            echo "(P)EXA";
                        } elseif ($row_Recordset5['cod_tventa']=="8") {
                            echo "(P)TRIF";
                        } elseif ($row_Recordset5['cod_tventa']=="9") {
                            echo "(P)SUPE";
                        }
                        
                        ?>
                        </font>





                    </td>

                    <td align="center">
						<font color="#000000"><?php echo $row_Recordset5['mon_venta']; ?></font>


                    </td>
                </tr><?php
                $s++;
            } while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));?> 
        	<tr>
			<td colspan="4" height="21" align="right">
			<?php
if ($efectivoO==0) {
                echo 'APOSTADO POR BSS';
            }
if ($efectivoO==1) {
    echo 'APOSTADO POR DEBITO BSS';
}
if ($efectivoO==2) {
    echo 'APOSTADO POR TRANSFERENCIA BSS';
}
if ($efectivoO==3) {
    echo 'APOSTADO POR DOLAR AMERICANO';
}
if ($efectivoO==4) {
    echo 'APOSTADO POR PESO COLOMBIANO';
}
if ($efectivoO==5) {
    echo 'APOSTADO POR SOLES PERUANOS';
}
 ?>
                TOTAL:<font color="#000000"><?php echo ObtenerMonTototalVenta($row_Recordset4['ticket'])." "; ?>&nbsp;</font></td>
            </tr> 
        </table>


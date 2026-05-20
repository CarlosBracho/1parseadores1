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
?>

<table width="70%" border="0" cellpadding="0" cellspacing="0" >
 <tr><td>
						<?php $query_Recordset115 = sprintf(
    "/* PARSEADORES1 new\includes\seleccionclientesventas.php - QUERY 1 */ SELECT ve.cod_cliente 
		FROM 
			usuario us, 
			taquilla ta, 
			venta ve 
		WHERE 
			us.id_usuario = %s AND 
			us.cod_taquilla = ta.cod_taquilla AND
			ve.cod_taquilla = us.cod_taquilla AND
			ve.tra_codigo = 1 AND
			ve.fec_venta = %s 
		GROUP BY ve.cod_cliente",
    GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
    GetSQLValueString(fechaactualbd(), "date")
);
$Recordset115 = mysqli_query($conexionbanca, $query_Recordset115) or die(mysqli_error($conexionbanca));
$row_Recordset115 = mysqli_fetch_assoc($Recordset115);
$totalRows_Recordset115 = mysqli_num_rows($Recordset115);


?>
						                    <input class="textbox" form="formulario"  
                    type="text" name="cod_cliente" style="width:35%; font-size:16px;  height:28px;" 
                    maxlength="15" value="" id="cod_cliente" placeholder="CREE CLIENTE AQUI"
                    onKeyDown="return handleEnter(this, event)" title="CREE CLIENTE AQUI"/><?php
                    if ($totalRows_Recordset115>0) {?> 
                        <select name="cod_cliente2" tabindex="4" form="formulario"  style="font-size:16px; width:60%; height:28px;">
                        	<option value="-1X" style="background: #C15; color:#FFFFFF;">
                        		<?php echo "O SELECCIONE CLIENTE AQUI";?>
                        	</option><?php
                            do {?>
								<option value="<?php echo $row_Recordset115['cod_cliente'];?>">
									<?php echo $row_Recordset115['cod_cliente'];?>
								</option><?php
                            } while ($row_Recordset115 = mysqli_fetch_assoc($Recordset115));?>
						</select><?php
                    } else {?>
                    	<input type="hidden" name="cod_cliente2" form="formulario"  value="-1X" /><?php
                    }?>
					  </td> </tr>
        </table>
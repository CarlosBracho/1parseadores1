<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_POST["js"])) {
    $_SESSION['selCarrera']=$_POST["js"];
} else {
    $_SESSION['selCarrera']=-1;
}
require_once('../Connections/conexionbanca.php');
$hor=horaactual();
$fec=fechaactualbd();
$xbanca_Recordset1 = 2;
$ejeMinCar=4;
$query_Recordset1 = sprintf("/* PARSEADORES1 new\ventas\listas_hipodromos.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.fec_carrera = %s AND carrera.hor_carrera >= %s AND carrera.est_carrera = 1 AND carrera.cod_banca = %s AND can_caballos>=%s ORDER BY carrera.hor_carrera  LIMIT 0, 10", GetSQLValueString($fec, "date"), GetSQLValueString($hor, "date"), GetSQLValueString($xbanca_Recordset1, "int"), GetSQLValueString($ejeMinCar, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

if ($totalRows_Recordset1>0) {?>
	<script src="../js/jquery-1.9.1.min.js"></script>
	<script language="javascript">
		$("#realizarapuesta").load('ventas_boton_realizar_apuesta.php?&js='+Math.random());
	</script>
	<select name="cod_carrera" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;" id="soflow" 
    style="font-size:20px; width:521px" onBlur="startListaHipodromo()">
		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
        	<?php echo "SELECCIONE HIPÓDROMO AQUÍ";?>
        </option>
        <?php
        do { ?>
        	<option value="<?php echo $row_Recordset1['cod_carrera']?>" 
				<?php if (!(strcmp(htmlentities($row_Recordset1['cod_carrera'], ENT_COMPAT, 'utf-8'), $_SESSION['selCarrera']))) {
            echo "selected=\"selected\"";
        }?> 
                onfocus="clean()" onclick="clean()">
                <?php echo $row_Recordset1['nom_hipodromo']." Carr: ...".$row_Recordset1['num_carrera'];?>
			</option>
		<?php
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));?>
	</select>
<?php
} else {?>
	<select name="cod_carrera" tabindex="1" id="soflow" style="font-size:18px; width:520px" disabled="disabled">
		<option value="-1" > <?php echo "Aún no existen carreras programadas";?></option>
	</select>
<?php
}
mysqli_free_result($Recordset1);
?>
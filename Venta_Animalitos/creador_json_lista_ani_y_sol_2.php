<?php
////opcache_reset();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;
//echo $datetime.' 222<br>';

//$Fechahoramara = strtotime('-5 hour', strtotime($Fechahoramara));
//$timestamp = strtotime('-6 day', strtotime($datetime));
//$newDate = date("Y-m-d", $timestamp );

$query_Recordset1_ani3 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\creador_json_lista_ani_y_sol_2.php - QUERY 1 */ SELECT 
*
    FROM 
	 taquilla_opc_ani
	WHERE taquilla_opc_ani.cod_taquilla=%s 
 LIMIT 1",
		   GetSQLValueString($_GET['act'], "int")
		   );
    $Recordset1_ani3 = mysqli_query($conexionbanca, $query_Recordset1_ani3) or die(mysqli_error($conexionbanca));
    $row_Recordset1_ani3 = mysqli_fetch_assoc($Recordset1_ani3);
    $totalRows_Recordset1_ani3 = mysqli_num_rows($Recordset1_ani3);











?>
<div class="panel-body">
		<div class="listado-animalitos">
			<div class="row">

			<?php







$query_Recordset1_ani1_loterias_y_nombres = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\creador_json_lista_ani_y_sol_2.php - QUERY 2 */ SELECT 
id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1
    FROM 
	ani1_loterias_y_nombres
	WHERE id_Loterias_y_nombres_ani1=%s
   ORDER BY id_Loterias_y_nombres_ani1 LIMIT 1",
		   GetSQLValueString($_GET['lot'], "int")
		   );
    $Recordset1_ani1_loterias_y_nombres = mysqli_query($conexionbanca, $query_Recordset1_ani1_loterias_y_nombres) or die(mysqli_error($conexionbanca));
    $row_Recordset1_ani1_loterias_y_nombres = mysqli_fetch_assoc($Recordset1_ani1_loterias_y_nombres);
    $totalRows_Recordset1_ani1_loterias_y_nombres = mysqli_num_rows($Recordset1_ani1_loterias_y_nombres);

	$animalitos = explode(",", $row_Recordset1_ani1_loterias_y_nombres["animales_Loterias_y_nombres_ani1"]);
	foreach ($animalitos as $animalitosvalor) {
	$animalitos_div = explode(".", $animalitosvalor);

	

?>

									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="<?php echo $animalitos_div[0];?>" data-numero="<?php echo $animalitos_div[1];?>" data-nombre="<?php echo $animalitos_div[2];?>" data-alias="<?php echo $animalitos_div[1].' - '.$animalitos_div[2];?>">
									<span class="label label-info2-filter multiline capitalize"><?php echo $animalitos_div[1].' - '.$animalitos_div[2];?></span>
								</label>
							</div>
						</div>
					</div>


					<?php
}

?>






							</div>
		</div>
	</div>


								</div>
							</div> <!-- .panel.panel-default -->
						</div> <!-- .col-* -->


						.....



		<div class="listado-sorteos">
			<div class="row">

			<?php		
			$varios_x_loteria=$row_Recordset1_ani3["varios_x_loteria"];
if (isset($varios_x_loteria)) {
		
	$varios_x_loteria = explode("-", $varios_x_loteria); 
	
	foreach ($varios_x_loteria as $varios_x_loteria2) { 
		$varios_x_loteria2 = explode(",", $varios_x_loteria2); 			
		if($varios_x_loteria2[0]==$_GET['lot']){
			$cierre_adelantado=$varios_x_loteria2[4];
			
		}
	}}

	if($row_Recordset1_ani3['opc_cierre']==0){
		$minxcerrar=$row_Recordset1_ani3['cierre_adelantado']*60;
		}else{
			$minxcerrar=$cierre_adelantado*60;
		}
		$datetime5 = strtotime('+6 hour', strtotime($datetime));
		$datetime5 = $datetime5+$minxcerrar;
		$datetime5 = date('Y-m-d H:i:s', $datetime5);


$query_Recordset1_ani4_solteos = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\creador_json_lista_ani_y_sol_2.php - QUERY 3 */ SELECT 
id_solteo_ani4, fechahora_solteo_ani4
    FROM 
	ani4_solteos
	WHERE id_Loterias_y_nombres_ani4=%s AND fechahora_solteo_ani4>%s AND estado_ani4=0
   ORDER BY fechahora_solteo_ani4 LIMIT 20",
		   GetSQLValueString($_GET['lot'], "int"),
		   GetSQLValueString($datetime5, "date")
		   );
    $Recordset1_ani4_solteos = mysqli_query($conexionbanca, $query_Recordset1_ani4_solteos) or die(mysqli_error($conexionbanca));
    $row_Recordset1_ani4_solteos = mysqli_fetch_assoc($Recordset1_ani4_solteos);
    $totalRows_Recordset1_ani4_solteos = mysqli_num_rows($Recordset1_ani4_solteos);
	


	
		
	

		
	do{
		//$currentDateTime = '08/04/2010 22:15:00';
		//$newDateTime = date('h:i A', strtotime($currentDateTime));


		$valor_horas_solteos_ani1 =str_replace('.', ' ', $row_Recordset1_ani4_solteos["fechahora_solteo_ani4"]);
		$valor_horas_solteos_ani1 = date("h:i A", strtotime($valor_horas_solteos_ani1));


?>


					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
							<label>
									<input type="checkbox" name="sorteo_seleccionado" data-id="<?php echo $row_Recordset1_ani4_solteos["id_solteo_ani4"]; ?>" data-hora="<?php echo $row_Recordset1_ani4_solteos["fechahora_solteo_ani4"]; ?>" data-hora-cierre="<?php echo $row_Recordset1_ani4_solteos["fechahora_solteo_ani4"]; ?>">
									<span class="label label-info2-filter multiline capitalize">
									 <?php echo $row_Recordset1_ani1_loterias_y_nombres["nom_Loterias_y_nombres_ani1"]; ?><br>
										<?php echo $valor_horas_solteos_ani1; ?>
									</span>
								</label>
							</div>
						</div>
					</div>

					<?php
} while ($row_Recordset1_ani4_solteos = mysqli_fetch_assoc($Recordset1_ani4_solteos));

?>



							</div> <!-- .row -->
		</div>
	</div> <!-- .panel-body -->
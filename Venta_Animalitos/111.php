<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

$query_Recordset1_busca_loterias = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\111.php - QUERY 1 */ SELECT  DISTINCT
id_Loterias_y_nombres_ani1
    FROM 
	ani1_loterias_y_nombres
   ORDER BY id_Loterias_y_nombres_ani1");
    $Recordset1_busca_loterias = mysqli_query($conexionbanca, $query_Recordset1_busca_loterias) or die(mysqli_error($conexionbanca));
    $row_Recordset1_busca_loterias = mysqli_fetch_assoc($Recordset1_busca_loterias);
    $totalRows_Recordset1_busca_loterias = mysqli_num_rows($Recordset1_busca_loterias);
	do{







} while ($row_Recordset1_busca_loterias = mysqli_fetch_assoc($Recordset1_busca_loterias));



?>
<div class="panel-body">
		<div class="listado-animalitos">
			<div class="row">







									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="1" data-numero="0" data-nombre="DELFIN" data-alias="0 - DELFIN">
									<span class="label label-info2-filter multiline capitalize">0 - DELFIN</span>
								</label>
							</div>
						</div>
					</div>









									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="2" data-numero="1" data-nombre="CARNERO" data-alias="1 - CARNERO">
									<span class="label label-info2-filter multiline capitalize">1 - CARNERO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="3" data-numero="2" data-nombre="TORO" data-alias="2 - TORO">
									<span class="label label-info2-filter multiline capitalize">2 - TORO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="4" data-numero="3" data-nombre="CIEMPIES" data-alias="3 - CIEMPIES">
									<span class="label label-info2-filter multiline capitalize">3 - CIEMPIES</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="5" data-numero="4" data-nombre="ALACRAN" data-alias="4 - ALACRAN">
									<span class="label label-info2-filter multiline capitalize">4 - ALACRAN</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="6" data-numero="5" data-nombre="LEON" data-alias="5 - LEON">
									<span class="label label-info2-filter multiline capitalize">5 - LEON</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="7" data-numero="6" data-nombre="RANA" data-alias="6 - RANA">
									<span class="label label-info2-filter multiline capitalize">6 - RANA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="8" data-numero="7" data-nombre="PERICO" data-alias="7 - PERICO">
									<span class="label label-info2-filter multiline capitalize">7 - PERICO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="9" data-numero="8" data-nombre="RATON" data-alias="8 - RATON">
									<span class="label label-info2-filter multiline capitalize">8 - RATON</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="10" data-numero="9" data-nombre="AGUILA" data-alias="9 - AGUILA">
									<span class="label label-info2-filter multiline capitalize">9 - AGUILA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="11" data-numero="10" data-nombre="TIGRE" data-alias="10 - TIGRE">
									<span class="label label-info2-filter multiline capitalize">10 - TIGRE</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="12" data-numero="11" data-nombre="GATO" data-alias="11 - GATO">
									<span class="label label-info2-filter multiline capitalize">11 - GATO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="13" data-numero="12" data-nombre="CABALLO" data-alias="12 - CABALLO">
									<span class="label label-info2-filter multiline capitalize">12 - CABALLO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="14" data-numero="13" data-nombre="MONO" data-alias="13 - MONO">
									<span class="label label-info2-filter multiline capitalize">13 - MONO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="15" data-numero="14" data-nombre="PALOMA" data-alias="14 - PALOMA">
									<span class="label label-info2-filter multiline capitalize">14 - PALOMA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="16" data-numero="15" data-nombre="ZORRO" data-alias="15 - ZORRO">
									<span class="label label-info2-filter multiline capitalize">15 - ZORRO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="17" data-numero="16" data-nombre="OSO" data-alias="16 - OSO">
									<span class="label label-info2-filter multiline capitalize">16 - OSO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="18" data-numero="17" data-nombre="PAVO" data-alias="17 - PAVO">
									<span class="label label-info2-filter multiline capitalize">17 - PAVO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="19" data-numero="18" data-nombre="BURRO" data-alias="18 - BURRO">
									<span class="label label-info2-filter multiline capitalize">18 - BURRO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="20" data-numero="19" data-nombre="CHIVO" data-alias="19 - CHIVO">
									<span class="label label-info2-filter multiline capitalize">19 - CHIVO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="21" data-numero="20" data-nombre="CERDO" data-alias="20 - CERDO">
									<span class="label label-info2-filter multiline capitalize">20 - CERDO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="22" data-numero="21" data-nombre="GALLO" data-alias="21 - GALLO">
									<span class="label label-info2-filter multiline capitalize">21 - GALLO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="23" data-numero="22" data-nombre="CAMELLO" data-alias="22 - CAMELLO">
									<span class="label label-info2-filter multiline capitalize">22 - CAMELLO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="24" data-numero="23" data-nombre="CEBRA" data-alias="23 - CEBRA">
									<span class="label label-info2-filter multiline capitalize">23 - CEBRA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="25" data-numero="24" data-nombre="IGUANA" data-alias="24 - IGUANA">
									<span class="label label-info2-filter multiline capitalize">24 - IGUANA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="26" data-numero="25" data-nombre="GALLINA" data-alias="25 - GALLINA">
									<span class="label label-info2-filter multiline capitalize">25 - GALLINA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="27" data-numero="26" data-nombre="VACA" data-alias="26 - VACA">
									<span class="label label-info2-filter multiline capitalize">26 - VACA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="28" data-numero="27" data-nombre="PERRO" data-alias="27 - PERRO">
									<span class="label label-info2-filter multiline capitalize">27 - PERRO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="29" data-numero="28" data-nombre="ZAMURO" data-alias="28 - ZAMURO">
									<span class="label label-info2-filter multiline capitalize">28 - ZAMURO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="30" data-numero="29" data-nombre="ELEFANTE" data-alias="29 - ELEFANTE">
									<span class="label label-info2-filter multiline capitalize">29 - ELEFANTE</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="31" data-numero="30" data-nombre="CAIMAN" data-alias="30 - CAIMAN">
									<span class="label label-info2-filter multiline capitalize">30 - CAIMAN</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="32" data-numero="31" data-nombre="LAPA" data-alias="31 - LAPA">
									<span class="label label-info2-filter multiline capitalize">31 - LAPA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="33" data-numero="32" data-nombre="ARDILLA" data-alias="32 - ARDILLA">
									<span class="label label-info2-filter multiline capitalize">32 - ARDILLA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="34" data-numero="33" data-nombre="PESCADO" data-alias="33 - PESCADO">
									<span class="label label-info2-filter multiline capitalize">33 - PESCADO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="35" data-numero="34" data-nombre="VENADO" data-alias="34 - VENADO">
									<span class="label label-info2-filter multiline capitalize">34 - VENADO</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="36" data-numero="35" data-nombre="JIRAFA" data-alias="35 - JIRAFA">
									<span class="label label-info2-filter multiline capitalize">35 - JIRAFA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="37" data-numero="36" data-nombre="CULEBRA" data-alias="36 - CULEBRA">
									<span class="label label-info2-filter multiline capitalize">36 - CULEBRA</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="animalito_seleccionado" data-id="39" data-numero="38" data-nombre="BALLENA" data-alias="38 - BALLENA">
									<span class="label label-info2-filter multiline capitalize">38 - BALLENA</span>
								</label>
							</div>
						</div>
					</div>
							</div>
		</div>
	</div>
								</div>
							</div> <!-- .panel.panel-default -->
						</div> <!-- .col-* -->



						.....









		<div class="listado-sorteos">
			<div class="row">








			
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="1" data-hora="09:00 AM" data-hora-cierre="08:46:00">
									<span class="label label-info2-filter multiline">
										1 Lottoactivo <br>
										09:00 AM
									</span>
								</label>
							</div>
						</div>
					</div>










									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="2" data-hora="10:00 AM" data-hora-cierre="09:46:00">
									<span class="label label-info2-filter multiline">
										2 Lottoactivo <br>
										10:00 AM
									</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="3" data-hora="11:00 AM" data-hora-cierre="10:46:00">
									<span class="label label-info2-filter multiline">
										3 Lottoactivo <br>
										11:00 AM
									</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="4" data-hora="12:00 PM" data-hora-cierre="11:46:00">
									<span class="label label-info2-filter multiline">
										4 Lottoactivo <br>
										12:00 PM
									</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="5" data-hora="01:00 PM" data-hora-cierre="12:46:00">
									<span class="label label-info2-filter multiline">
										5 Lottoactivo <br>
										01:00 PM
									</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="6" data-hora="02:00 PM" data-hora-cierre="13:46:00">
									<span class="label label-info2-filter multiline">
										6 Lottoactivo <br>
										02:00 PM
									</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="7" data-hora="03:00 PM" data-hora-cierre="14:46:00">
									<span class="label label-info2-filter multiline">
										7 Lottoactivo <br>
										03:00 PM
									</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="8" data-hora="04:00 PM" data-hora-cierre="15:46:00">
									<span class="label label-info2-filter multiline">
										8 Lottoactivo <br>
										04:00 PM
									</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="9" data-hora="05:00 PM" data-hora-cierre="16:46:00">
									<span class="label label-info2-filter multiline">
										9 Lottoactivo <br>
										05:00 PM
									</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="10" data-hora="06:00 PM" data-hora-cierre="17:46:00">
									<span class="label label-info2-filter multiline">
										10 Lottoactivo <br>
										06:00 PM
									</span>
								</label>
							</div>
						</div>
					</div>
									<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<div class="checkbox">
								<label style="display:inline-block">
									<input type="checkbox" name="sorteo_seleccionado" data-id="98" data-hora="07:00 PM" data-hora-cierre="18:46:00">
									<span class="label label-info2-filter multiline">
										98 Lottoactivo <br>
										07:00 PM
									</span>
								</label>
							</div>
						</div>
					</div>
							</div> <!-- .row -->
		</div>
	</div> <!-- .panel-body -->
<?php
 
error_reporting(E_ALL);
ini_set('display_errors', '1');
//echo 'v1<br>';


if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$hor=horaactual();
$fec=fechaactualbd();
$query_Recordset1z = sprintf("/* PARSEADORES1 ventas\Venta_Internacionales.php - QUERY 1 */ SELECT cod_hipodromo, nom_hipodromo FROM carrera WHERE carrera.fec_carrera = %s  AND carrera.est_carrera = 1 ORDER BY carrera.hor_carrera  LIMIT 200", 
GetSQLValueString($fec, "date"));
$Recordset1z = mysqli_query($conexionbanca, $query_Recordset1z) or die(mysqli_error($conexionbanca));
$row_Recordset1z = mysqli_fetch_assoc($Recordset1z);
$totalRows_Recordset1z = mysqli_num_rows($Recordset1z);
?>
<!DOCTYPE html>
<html lang="en" style="height: 100%;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script language="JavaScript">
		  javascript:window.history.forward(1);
		</script>
		
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!-- Bootstrap core CSS -->
<link href="./Venta Internacionales_files/bootstrap.min.css" rel="stylesheet">
<link href="./Venta Internacionales_files/mystyle.css" rel="stylesheet">

		<title>Venta Internacionales</title>
		<style>
			.th1 {
				padding: 12px 8px;
			}
			.td1 {
				padding: 1px 8px;
			}
			.th1, .td1 {
				color: #555;
				border-bottom: 1px solid #eee;
				border-collapse: collapse;
			}
			.th1 {
				background: #f7a330;
				color: #fff;
				text-transform: uppercase;
				font-size: 12px;
			}
			.th1.last {
				border-right: none;
			}
			input[type=checkbox]{
				width:20px;
				height:20px;
			}
			input[type=button]{
				height:20px;
			}
			.number{
				width:90px;
				border: 1px solid #999;
				font-size: 16px;
				font-family: Arial;
				padding-left: 3px;
				padding-right: 0px;
				padding-top: 2px;
				padding-bottom: 2px;
				border-radius: 4px;
				-moz-border-radius: 4px;
				-webkit-border-radius: 4px;
				-o-border-radius: 4px;
				background: #FFFFFF;
				background: linear-gradient(left, #FFFFFF, #F7F9FA);
				background: -moz-linear-gradient(left, #FFFFFF, #F7F9FA);
				background: -webkit-linear-gradient(left, #FFFFFF, #F7F9FA);
				background: -o-linear-gradient(left, #FFFFFF, #F7F9FA);
				color: #2E3133;
			}
			.button-0 {
				font-family:Arial;
				font-size:16px;
			}
			/* PARSEADORES1 ventas\Venta_Internacionales.php - QUERY 2 */ select {
				border: 1px solid #ccc;
				font-size: 14px;
				height: 24px;
			}
		</style>
	</head>
	<body marginheight="0" marginwidth="0" style="height: 100%;">
		<table width="100%" height="93%" cellpadding="0" cellspacing="0" border="0">
			<tbody><tr>
		        <td height="1" colspan="3">
		        
				
				
				
				
				
				
				
				







<script src="./Venta Internacionales_files/jquery.min.js"></script>
<script src="./Venta Internacionales_files/bootstrap.min.js"></script>		        </td>
		    </tr>



			<tr>
				<td align="center" valign="middle" height="100%">
									</td>
				<td align="center" valign="middle">
										<form id="form1" name="form1" method="post" action="t_grabajugadahipicoticket2.php" onsubmit="return enviar_jugada()">
						<input name="id_usu" id="id_usu_ban" type="hidden" value="3374">
						<input name="tipo_s" id="tipo_s_ban" type="hidden" value="Cliente">
						<input id="inp_tot" name="inp_tot" type="hidden" value="">
						<input id="nom_hip" name="nom_hip" type="hidden" value="Saratoga">
						<input name="tik" id="tik_ban" type="hidden" value="">
						<input name="salto" type="hidden" value="0">

						<input id="limite_wps" name="limite_wps" type="hidden" value="">

						<input name="l1" id="l1_ban" type="hidden" value="">
						<input name="l2" id="l2_ban" type="hidden" value="">
						<input name="l3" id="l3_ban" type="hidden" value="">
						<input name="sin_imp" id="sin_imp_ban" type="hidden" value="1">
						<input name="mon" type="hidden" value="1">
						<input name="token" id="token_ban" type="hidden" value="0">
						<table style="padding: 15px; border: #A9A9A9 1px solid;">
							<tbody><tr>
								<td>
									<select name="hip" id="hip" required="required" onchange="select_hip();">

										<option value="-1">Seleccione Carrera</option>
										<option value="-1">Seleccione Carrera</option>
										<?php    ?>


<?php
$hipodromoesta=',';
$ArrayLogros=array();
if($totalRows_Recordset1z>0){
while ($rowLG = $Recordset1z->fetch_array()) { 
if(!strpos($hipodromoesta, $rowLG["nom_hipodromo"])){ //}else{ 
		
	?>
<option value="<?php echo $rowLG["cod_hipodromo"]; ?>"> <?php echo $rowLG["nom_hipodromo"]; ?></option>
<?php    
$hipodromoesta=$hipodromoesta.$rowLG["nom_hipodromo"].',';
$ArrayLogros[] = $rowLG;
}}}



/*
if (in_array("mac", $os)) {
    echo "Existe mac";

	if (in_array($rowLG["nom_hipodromo"], $ArrayLogros)) {
}
*/
									?>
								</select>


								
								</td>
								<td>
									<select name="car" id="car" required="required" onchange="select_car();">
										
</select>
								</td>
								<td>
									<select name="jug" id="jug" required="required">
										
</select>
								</td>
							</tr>
							<tr style="display: none">
								<td colspan="3" align="center" valign="middle" height="44">
									<table>
										<tbody><tr>
											<td>
												Nro:<input style="width:32px" class="number" type="text" name="nro" id="nro" value="" autocomplete="off" autofocus="">
											</td>
											<td>
												&nbsp;Ganar:<input style="width:72px" class="number" type="number" step="0.1" name="gan" id="gan" value="" autocomplete="off" min="1.00" max="5.00">
											</td>
											<td>
												&nbsp;Place:<input style="width:72px" class="number" type="number" step="0.1" name="pla" id="pla" value="" autocomplete="off" min="1.00" max="5.00">
											</td>
											<td>
												&nbsp;Show:<input style="width:72px" class="number" type="number" step="0.1" name="sho" id="sho" value="" autocomplete="off" min="1.00" max="5.00">
											</td>
								 		</tr>
								 	</tbody></table>
							 	</td>
							</tr>
							<tr>
								<td colspan="3" id="apuestas_1" align="center" valign="middle"></td>
						 	</tr>
							<tr id="inputApuestaUnitaria">
								<td colspan="2" align="right">
									Apuesta Unitaria:
								</td>
								<td align="right">
									<input class="number" type="number" step="0.1" name="bs" id="bs" min="1.00" max="5.00" value="" autocomplete="off">
								</td>
							</tr>
							<tr>
								<td>
									Nro de Jugadas: <span id="nro_jug">0</span>
								</td>
								<td align="right">
									Total:
								</td>
								<td align="right">
									<span id="tot">0,00</span>
								</td>
							</tr>
							<tr>
								<td align="left">
									<input type="button" value="Actualizar" onclick="location.reload();" style="width: 95px; height: 25px; background: #f7a330; color: #ffffff; cursor: pointer; border: 0px;">
								</td>
								<td align="center"></td>
								<td align="right">
									<input disabled="" type="submit" name="enviar" id="enviar" class="boton" value="Enviar" style="width: 95px; height: 25px;">
								</td>
							</tr>
						</tbody></table>
					</form>
										<div id="result"></div>
					<br>
				</td>
				<td align="right" valign="top">

									</td>
	 		</tr>
		</tbody></table>
		<script src="./Venta Internacionales_files/jquery.js" type="text/javascript"></script>
		<script type="text/javascript">

			var tipo_s = "Cliente";
			var idUser = "3374"; //3374 es el usuario prueban
			var payValue = "";

			function selectVideo(selectVideoValue){

				//selectVideoValue = document.getElementById("selectVideo").value;

				var viewVideo = "<iframe scrolling = 'no' frameborder='0' allowfullscreen src='"+selectVideoValue+"'  height='300' width='475' style='border:none;'></iframe>";

				$('#viewVideo').html(viewVideo);
			}

			function numberFormat(value){
				value = value.toLocaleString();
				return(value);
			}



			



			var ruta = "../../";

			if("Cliente"=="Vendedor"){
				document.getElementById("diap").value = "27";
				document.getElementById("mesp").value = "07";
				document.getElementById("aniop").value = "2022";

				document.getElementById("diaa").value = "27";
				document.getElementById("mesa").value = "07";
				document.getElementById("anioa").value = "2022";
			}





			function enviar_jugada(id_usu, user, sin_imp, lim_ven_eje) {

				if((document.getElementById("nro").value!="")&&(document.getElementById("gan").value=="")&&(document.getElementById("pla").value=="")&&(document.getElementById("sho").value=="")){
					document.getElementById('gan').focus();
				}
				else{
					if(
						(document.getElementById("jug").value == "Tabla Fija")||
						(document.getElementById("jug").value == "Tabla Dinamica")||
						(document.getElementById("jug").value == "Puesto")||
						(document.getElementById("gan").value >= 1.00)||
						(document.getElementById("pla").value >= 1.00)||
						(document.getElementById("sho").value >= 1.00)||
						(document.getElementById("bs").value >= 1.00)
					){

						if((document.getElementById("gan").value > 5.00)||(document.getElementById("pla").value > 5.00)||(document.getElementById("sho").value > 5.00)||(document.getElementById("bs").value > 5.00)){
							alert('venta maxia permitida 5.00');
						}
						else{
							var id_div = 'result';
						    var form = 'form1';

						    if (id_usu) {
						    	if (document.getElementById("enviar")) {
									if (!document.getElementById("enviar").disabled){
								    	var r = confirm("Esta seguro de realizar la jugada al cliente: "+user);
					                    if (r == true) {
					                        document.getElementById("token_ban").value = '1';
					                        document.getElementById("id_usu_ban").value = id_usu;
					                        document.getElementById("tipo_s_ban").value = 'Cliente';
					                        document.getElementById("sin_imp_ban").value = sin_imp;
					                        document.getElementById("tik_ban").value = 'Usuario: '+user;
					                        document.getElementById("l1_ban").value = '';
					                        document.getElementById("l2_ban").value = '';
					                        document.getElementById("l3_ban").value = '';
					                    
					                        enviar_formulario(form, id_div);
					                        limpiar_form1();

					                        document.getElementById("token_ban").value = '0';
									        document.getElementById("id_usu_ban").value = '3374';
									        document.getElementById("tipo_s_ban").value = 'Cliente';
									        document.getElementById("sin_imp_ban").value = '1';
									        document.getElementById("tik_ban").value = '';
									        document.getElementById("l1_ban").value = '';
									        document.getElementById("l2_ban").value = '';
									        document.getElementById("l3_ban").value = '';
					                    }
					                }else{
							            alert('Complete los datos del formulario Venta');
							        }
					            }else{
	                				alert('Se esta enviando informacion. Aguarde un momento o actualice la pagina');
	            				}
						    }else{
						    	enviar_formulario(form, id_div);
						    	limpiar_form1();
						    }
						}
					}
					else{alert('venta minima permitida 1.00');}
				}
				if (!id_usu) {
			    	return false;
				}
			}







			function enviar_formulario(form, id_div){
			    //convierto los datos del formulario en un array con serializeArray
			    //data = $('#'+form).serializeArray();
			    data = $('#'+form).serialize();
			    url = $('#'+form).attr('action');

				var select_jug = document.getElementById("jug").value;

				for (var i = 2; i <= 6; i++) {
					if (i == 2) {
						var pickName = "Daily Double";
					}else{
						var pickName = "Pick "+i+"";
					}
					if(select_jug == pickName){
						for (var j = 2; j <= i; j++) {
							data = data + "& id_car" + j + "=" + eval("id_car" + j);
						}
					}
				}

			    $.post(url, data, function(respo){
			        $('#'+id_div).html(respo);
			    });
			}

			function limpiar_form1(){
				if (tipo_s == 'Vendedor') {
					document.getElementById('nro').focus();
				}
				document.getElementById("nro").value = '';
				document.getElementById("gan").value = '';
				document.getElementById("pla").value = '';
				document.getElementById("sho").value = '';
				destildar(0);
			}


			$(document).ready(function() {
				$('#form2, #form3, #form4').submit(function() {
					// Enviamos el formulario usando AJAX
					$.ajax({
						type: 'POST',
						url: $(this).attr('action'),
						data: $(this).serialize(),
						// Mostramos un mensaje con la respuesta de PHP
						success: function(data) {
							$('#result').html(data);
						},
						error: function() {
			        		$('#result').text('Se Produjo un Error');
			     		}
					})
					if(1==1){
						if (tipo_s == 'Vendedor') {
							document.getElementById("nro").focus();
						}
						document.getElementById("nro").value = '';
						document.getElementById("gan").value = '';
						document.getElementById("pla").value = '';
						document.getElementById("sho").value = '';
						document.getElementById("enviar").disabled=true;
						document.getElementById("bs").value = '';
						$("#tot").text("0,00");
						$("#nro_jug").text("0");
					}
					return false;
				});
			});

			var arrayCompetidor = Array();

			function tablero(id_hip, id_car, jug){

				//console.log(jug)
				if (tipo_s == 'Vendedor') {
					document.getElementById('nro').focus();
				}
				document.getElementById("nro").value = '';
				document.getElementById("gan").value = '';
				document.getElementById("pla").value = '';
				document.getElementById("sho").value = '';
				document.getElementById("bs").value = '';
				$("#tot").text("0,00");
				$("#nro_jug").text("0");
				document.getElementById("enviar").disabled=true;

				if(jug == "wps"){
					var apuestas_1 = "<table class=tab1>";
					apuestas_1 += "<tr>";
					apuestas_1 += "<td class='th1'> N. </td>";
					apuestas_1 += "<td class='th1'> EJEMPLAR </td>";
					apuestas_1 += "<td class='th1'> GANAR </td>";
					apuestas_1 += "<td class='th1'> PLACE </td>";
					apuestas_1 += "<td class='th1'> SHOW </td>";
					apuestas_1 += "</tr>";

					for (id_competidor in v_car_ejemplar[id_car]) {
						var nro = v_car_ejemplar[id_car][id_competidor]['nro'];
						var status = v_car_ejemplar[id_car][id_competidor]['status'];
						var nom = v_car_ejemplar[id_car][id_competidor]['nom'];

						tablero_2(status, nom);

						apuestas_1 += "<tr class='tr1'>";
						apuestas_1 += "<td class='td1'>"+nro+"</td>";
						apuestas_1 += "<td class='td1'>"+nom_eje+"</td>";
						apuestas_1 += "<td class='td1'><input onclick='validar()' name='a"+id_competidor+"' id='aa"+id_competidor+"' type='checkbox' "+disabled+" /></td>";
						apuestas_1 += "<td class='td1'><input onclick='validar()' name='b"+id_competidor+"' id='bb"+id_competidor+"' type='checkbox' "+disabled+" /></td>";
						apuestas_1 += "<td class='td1'><input onclick='validar()' name='c"+id_competidor+"' id='cc"+id_competidor+"' type='checkbox' "+disabled+" /></td>";
						apuestas_1 += "</tr>";
					}

					apuestas_1 += "</table>";

					$('#apuestas_1').html( apuestas_1 );
				}
				if(jug == "Exacta" || jug == "Quinella"){
					var apuestas_1="<table class=tab1>";
					apuestas_1 += "<tr>";
					apuestas_1 += "<td class=th1 >N.</td>";
					apuestas_1 += "<td class=th1 >EJEMPLAR</td>";
					apuestas_1 += "<td class=th1>1RO</td>";
					apuestas_1 += "<td class=th1>2DO</td>";
					apuestas_1 += "<td class=th1>CUALQUIER ORDEN</td>";
					apuestas_1 += "</tr>";

					for (id_competidor in v_car_ejemplar[id_car]) {

						var nro = v_car_ejemplar[id_car][id_competidor]['nro'];
						var status = v_car_ejemplar[id_car][id_competidor]['status'];
						var nom = v_car_ejemplar[id_car][id_competidor]['nom'];

						tablero_2(status, nom);

						apuestas_1 += "<tr class=tr1>";
						apuestas_1 += "<td class=td1 >" + nro + "</td>";
						apuestas_1 += "<td class=td1 >" + nom_eje + "</td>";
						apuestas_1 += "<td class=td1 ><input onclick=validar() name=a"+id_competidor+" id=aa"+id_competidor+" type=checkbox "+disabled+" /></td>";
						apuestas_1 += "<td class=td1 ><input onclick=validar() name=b"+id_competidor+" id=bb"+id_competidor+" type=checkbox "+disabled+" /></td>";
						apuestas_1 += "<td class=td1 ><input onclick=sel("+id_competidor+") type=button name=Button id=ee"+id_competidor+" value=Seleccionar "+disabled+" /></td>";
						apuestas_1 += "</tr>";
					}
					apuestas_1 += "</table>";

					$('#apuestas_1').html( apuestas_1 );
				}
				if(jug == "Trifecta"){
					var apuestas_1 = "<table class=tab1>";
					apuestas_1 += "<tr>";
					apuestas_1 += "<td class=th1 >N.</td>";
					apuestas_1 += "<td class=th1 >EJEMPLAR</td>";
					apuestas_1 += "<td class=th1>1RO</td>";
					apuestas_1 += "<td class=th1>2DO</td>";
					apuestas_1 += "<td class=th1>3RO</td>";
					apuestas_1 += "<td class=th1>CUALQUIER ORDEN</td>";
					apuestas_1 += "</tr>";

					for (id_competidor in v_car_ejemplar[id_car]) {

						var nro = v_car_ejemplar[id_car][id_competidor]['nro'];
						var status = v_car_ejemplar[id_car][id_competidor]['status'];
						var nom = v_car_ejemplar[id_car][id_competidor]['nom'];

						tablero_2(status, nom);

						apuestas_1 += "<tr class=tr1>";
						apuestas_1 += "<td class=td1 >" + nro + "</td>";
						apuestas_1 += "<td class=td1 >" + nom_eje + "</td>";
						apuestas_1 += "<td class=td1 ><input onclick=validar() name=a" + id_competidor + " id=aa" + id_competidor + " type=checkbox "+disabled+" /></td>";
						apuestas_1 += "<td class=td1 ><input onclick=validar() name=b" + id_competidor + " id=bb" + id_competidor + " type=checkbox "+disabled+" /></td>";
						apuestas_1 += "<td class=td1 ><input onclick=validar() name=c" + id_competidor + " id=cc" + id_competidor + " type=checkbox "+disabled+" /></td>";
						apuestas_1 += "<td class=td1 ><input onclick=sel(" + id_competidor + ") type=button name=Button id=ee" + id_competidor + " value=Seleccionar "+disabled+" /></td>";
						apuestas_1 += "</tr>";
					}

					apuestas_1 += "</table>";

					$('#apuestas_1').html( apuestas_1 );
				}
				if(jug == "Superfecta"){
					var apuestas_1 = "<table class=tab1>";
					apuestas_1 += "<tr>";
					apuestas_1 += "<td class=th1 >N.</td>";
					apuestas_1 += "<td class=th1 >EJEMPLAR</td>";
					apuestas_1 += "<td class=th1>1RO</td>";
					apuestas_1 += "<td class=th1>2DO</td>";
					apuestas_1 += "<td class=th1>3RO</td>";
					apuestas_1 += "<td class=th1>4TO</td>";
					apuestas_1 += "<td class=th1>CUALQUIER ORDEN</td>";
					apuestas_1 += "</tr>";

					for (id_competidor in v_car_ejemplar[id_car]) {

						var nro = v_car_ejemplar[id_car][id_competidor]['nro'];
						var status = v_car_ejemplar[id_car][id_competidor]['status'];
						var nom = v_car_ejemplar[id_car][id_competidor]['nom'];

						tablero_2(status, nom);

						apuestas_1 += "<tr class=tr1>";
						apuestas_1 += "<td class=td1 >" + nro + "</td>";
						apuestas_1 += "<td class=td1 >"+nom_eje+"</td>";
						apuestas_1 += "<td class=td1 ><input onclick=validar() name=a" + id_competidor + " id=aa" + id_competidor + " type=checkbox "+disabled+" /></td>";
						apuestas_1 += "<td class=td1 ><input onclick=validar() name=b" + id_competidor + " id=bb" + id_competidor + " type=checkbox "+disabled+" /></td>";
						apuestas_1 += "<td class=td1 ><input onclick=validar() name=c" + id_competidor + " id=cc" + id_competidor + " type=checkbox "+disabled+" /></td>";
						apuestas_1 += "<td class=td1 ><input onclick=validar() name=d" + id_competidor + " id=dd" + id_competidor + " type=checkbox "+disabled+" /></td>";
						apuestas_1 += "<td class=td1 ><input onclick=sel(" + id_competidor + ") type=button name=Button id=ee" + id_competidor + " value=Seleccionar "+disabled+" /></td>";
						apuestas_1 += "</tr>";
					}

					apuestas_1 += "</table>";

					$('#apuestas_1').html( apuestas_1 );
				}

				for (var i = 2; i <= 6; i++) {
					if (i == 2) {
						var pickName = "Daily Double";
					}else{
						var pickName = "Pick "+i+"";
					}
					if(jug == pickName){
						jug_pick(i);
						break;
					}
				}

				if((jug == "Tabla Fija")||(jug == "Tabla Dinamica")||(jug == "Puesto")){

					$('#inputApuestaUnitaria').hide();


					$('#apuestas_1').html( "<img src='../../imagenes/tableandpost/loading.gif' />");

					var data = {
				      'id_carrera': id_car,
				      'id_usu': idUser,
				      'privilegio': 'Taquilla',
				      'game': jug
				    };
				    
					$.post('../tableandpost/search_competidor.php', data, function(resp){

						var resp = $.parseJSON(resp);
						arrayCompetidor = resp["arrayCompetidor"];
						arrayValueGame = resp["arrayValueGame"];
						arrayBetData = resp["arrayBetData"];

						var monto_min = 0;
						var monto_max = 16777215;

						// console.log(arrayCompetidor);

						//LE COLOCO EL MAXIMO PERMITIDO AL INPUT NRO DE JUGADA RAPIDA SEGUN LA CANTIDAD DE EJEMPLARES DE LA COMPETENCIA
						//document.getElementById("nro").max = arrayCompetidor['competidor'].length;		

						if (arrayValueGame.length == 0) {

							var apuestas_1 = "<table width='300' height='300'>";
							apuestas_1 += "<tr>";
							apuestas_1 += "<td>";
							apuestas_1 += "Por el momento no han registrado los valores de "+jug+".<br>Por favor <input type='button' name='carrera' onclick='tablero("+id_hip+", "+id_car+", \""+jug+"\");' value='intente de nuevo'> mas tarde.";
							apuestas_1 += "</td>";
							apuestas_1 += "</tr>";
							apuestas_1 += "</table>";


							// $('#apuestas_1').html( tablero(id_hip, id_car, jug) );


							$('#apuestas_1').html( apuestas_1 );

						}else{

							var decimal = "";
							if (jug == 'Puesto') {
								decimal = "step='any'";
							}

							var apuestas_1 = "<table class=tab1>";

							apuestas_1 += "<tr>";
							apuestas_1 += "<td class='th1'> N. </td>";
							apuestas_1 += "<td class='th1'> EJEMPLAR </td>";
							apuestas_1 += "<td class='th1'> VALOR </td>";
							apuestas_1 += "<td class='th1'> # DE TABLAS </td>";
							apuestas_1 += "<td class='th1'> VENTA </td>";
							apuestas_1 += "</tr>";

							for (key in arrayCompetidor) {
								var nro = arrayCompetidor[key]['nro'];
								var status = arrayCompetidor[key]['status'];
								var nom = arrayCompetidor[key]['nom'];
								var id_competidor = arrayCompetidor[key]['id_competidor'];

								var valueTable = '';
								for (keyValueGame in arrayValueGame) {
									if(id_competidor == arrayValueGame[keyValueGame]['id_competidor']){
										valueTable = arrayValueGame[keyValueGame]['valor'];
										// terminar el ciclo
										break;
									}
								}


								if(status == 'retirado'){
									nom_eje = "<del>" + nom + "</del> (<font color=red>Retirado</font>)";
									disabled = "disabled";
								}
								if(status == 'invalido'){
									nom_eje = "<del>" + nom + "</del> (<font color=red>Invalidado</font>)";
									disabled = "disabled";
								}
								if((status == '')||(status == 'favorito')){
									nom_eje = nom;
									disabled = "";
								}

								var apostado = '';
								for( var iBetData = 0; iBetData < arrayBetData.length; iBetData++){

									if (arrayBetData[iBetData]['nro'] == nro) {

										//apostado = parseFloat();

										apostado = numberFormat(arrayBetData[iBetData]['apostado']);
									}
								}

								apuestas_1 += "<tr class='tr1'>";
								apuestas_1 += "<td class='td1'>"+nro+"</td>";
								apuestas_1 += "<td class='td1'>"+nom_eje+"</td>";
								apuestas_1 += "<td class='td1'><input type='hidden' name='valueTable"+id_competidor+"' value='"+valueTable+"'>"+valueTable+"</td>";
								apuestas_1 += "<td class='td1'><input style = 'width:90px;' type='number' name='monto_"+id_competidor+"' id='monto_"+id_competidor+"' "+decimal+" min='"+monto_min+"' max='"+monto_max+"' value='' autocomplete='off' "+disabled+"></td>";
								apuestas_1 += "<td class='td1' align='right'>"+apostado+"</td>";
								apuestas_1 += "</tr>";
							}

							if((jug == "Tabla Fija")||(jug == "Tabla Dinamica")){
								payValue = resp['valor'];
								apuestas_1 += "<input type='hidden' name='payValue' value='"+payValue+"'>";
								apuestas_1 += "<tr class='tr1'>";
								apuestas_1 += "<td class='td1' colspan='5'> &nbsp;&nbsp;&nbsp;&nbsp;"+jug+" (PAGA = "+payValue+") </td>";
								apuestas_1 += "</tr>";
							}

							apuestas_1 += "</table>";
							

							if(jug == "Tabla Fija"){
								var limitBet = limiteTablaFija;
							}
							if(jug == "Tabla Dinamica"){
								var limitBet = limiteTablaDinamica;
							}
							if(jug == "Puesto"){
								var limitBet = limitePuesto;
							}

							apuestas_1 += "<input type='hidden' name='limitBet' value='"+limitBet+"'>";

							$('#apuestas_1').html( apuestas_1 );

							for (key in arrayCompetidor) {
								var id_competidor = arrayCompetidor[key]['id_competidor'];
								$("#monto_"+id_competidor).on("change paste keyup", changeMontoTotalFormat);
							}
						}
				 	});
				}else{
					$('#inputApuestaUnitaria').show();
				}
			}


			function changeMontoTotalFormat(){

		    var monto_total = 0;
		    var nroJugadas = 0;

		    for (key in arrayCompetidor) {
					var status = arrayCompetidor[key]['status'];
					var id_competidor = arrayCompetidor[key]['id_competidor'];
					
					var valueTable = '';
					for (keyValueGame in arrayValueGame) {
						if(id_competidor == arrayValueGame[keyValueGame]['id_competidor']){
							valueTable = arrayValueGame[keyValueGame]['valor'];
							// terminar el ciclo
							break;
						}
					}

					var monto = document.getElementById("monto_"+id_competidor).value;

					if (monto != "") {
						nroJugadas ++;

						if((jug == "Tabla Fija")||(jug == "Tabla Dinamica")){
							monto = monto * valueTable;
						}
						monto = Number(monto);
						monto_total = monto + monto_total;
					}
				}

				// console.log(" monto="+nroJugadas);

				$("#tot").text(numberFormat(monto_total));
				$("#nro_jug").text(nroJugadas);

				document.getElementById("nro").value = '';
				document.getElementById("gan").value = '';
				document.getElementById("pla").value = '';
				document.getElementById("sho").value = '';
				//document.getElementById("bs").disabled=true;

				if(monto_total==0){
					document.getElementById("enviar").disabled=true;
				}else{
					document.getElementById("enviar").disabled=false;
				}
				document.getElementById("inp_tot").value=monto_total;

				// var hacer_apuesta = document.getElementById("hacer_apuesta");
				// if (monto_total == 0) {
				// 	hacer_apuesta.disabled = true;
				// 	$("#monto_total_format").text("");
				// }else{
				// 	$("#monto_total_format").text(formatter.format(monto_total)+" "+money);
				// 	hacer_apuesta.disabled = false;
				// }
		    }

			function jug_pick(pick){

				var id_hip = document.getElementById("hip").value;
				// variable id_car(1) que contiene el id de la carrera donde inicia el pick
				var id_car1 = document.getElementById("car").value;
				// variable car(1) que contiene el numero de la carrera donde inicia el pick
				var car1 = v_hip_car[id_hip][id_car1]['car'];

				// ciclo for que repite la operacion segun el numero de pick
				for (var i = 2; i <= pick; i++) {
					// creo las variables car(i) que va a contener los numeros de las carreras
					var proxima_car = parseInt(car1) + i - 1;
					eval("var car"+i+"=" + proxima_car);
				}

				// recorro el array para obtener el id de las carreras que estan en las variables car(i)
				for (idCarrera in v_hip_car[id_hip]) {
					// ciclo for que repite la operacion segun el numero de pick
					for (var i = 2; i <= pick; i++) {

						if (v_hip_car[id_hip][idCarrera]['car'] == eval("car"+i)){
							// el numero de la carrera es igual a car(i) creo las variables id_car(i) que va a contener los id de las carreras
							eval("id_car"+i+"=" + idCarrera);
						}
					}
				}


				// ya tengo el numero de las carreras(car(i)) el id de las carreras(id_car(i)) ahora obtengo el id de los participantes en cada carrera (v_car(i)_num_id[(nro_competidor)]) y status de los participantes en cada carrera (v_car(i)_num_status[(nro_competidor)]) y el numero maximo de competidores de las carreras donde se jugaran el pick (max_nro).
				max_nro = 0;
				var nro_competidor = 0;
				for (var i = 1; i <= pick; i++) {

					eval("v_car"+i+"_num_id=new Array()");
					eval("var v_car"+i+"_num_status=new Array()");

					for (id_competidor in v_car_ejemplar[eval("id_car"+i)]) {
						nro_competidor = v_car_ejemplar[eval("id_car"+i)][id_competidor]['nro'];

						eval("v_car"+i+"_num_id['"+nro_competidor+"'] = "+id_competidor);
						eval("v_car"+i+"_num_status['"+nro_competidor+"'] = v_car_ejemplar[id_car"+i+"][id_competidor]['status']");

						if (parseInt(nro_competidor) > parseInt(max_nro)) {
							max_nro = nro_competidor;
						}
					}
				}

				var apuestas_1 = "<table class=tab1>";
				apuestas_1 += "<tr>";
				apuestas_1 += "<td class=th1 >N.</td>";

				for (var i = 1; i <= pick; i++) {
					apuestas_1 += "<td class=th1 align=center>CAR "+eval("car"+i)+"</td>";
				}

				apuestas_1 += "</tr>";
				//numero de participantes
				for ( i=1; i <= max_nro; i++) {

					apuestas_1 += "<tr class=tr1><td class=td1 >" + i + "</td>";
					// ciclo for que repite la operacion segun el numero de pick
					for (var j = 1; j <= pick; j++) {
						// NRO DE EJEMPLAR = i
						var disabledEjemplarPick = "";
						var idEjemplarPick = eval("v_car"+j+"_num_id["+i+"]");
						
						//obtengo varible que contiene id del competidor
						if (idEjemplarPick == undefined){
							disabledEjemplarPick = "disabled";
						}else{
							var statusEjemplarPick = eval("v_car"+j+"_num_status["+i+"]");
							var idCarrera = eval("id_car"+j);

							if(statusEjemplarPick == 'retirado'){
								//nom_eje = "<del>" + nom + "</del> (<font color=red>Retirado</font>)";

								//PARA COLOCAR DISIBLE LOS CHECKBOX, ADEMAS DE ESTAR RETIRADO EL EJEMPLAR DEBEMOS AVERIGUAR SI EXISTE OTRO NRO IGUAL CON LA LETRA A (1A) Y QUE NO ESTE RETIRADO.
								//SUMAMOS UN NUMERO AL ID DEL EJEMPLAR
								var id_competidor_siguiente = parseInt(idEjemplarPick)+1;
								//VALIDAMOS SI EXISTE EL ID SIGUIENTE PORQUE CUANDO SEA EL ULTIMO NUMERO NO TENDRA ID SIGUIENTE
								if (v_car_ejemplar[idCarrera][id_competidor_siguiente]) {
									// OBTENEMOS EL NRO SIGUIENTE PARA COMPARARLO
									var nro_siguiente = v_car_ejemplar[idCarrera][id_competidor_siguiente]['nro'];

									//console.log(idCarrera+" "+idEjemplarPick)
									//console.log(nro+" "+nro_siguiente)
									// LE ANADIMOS LA LETRA A AL NRO PARA COMPARARLO CON EL SIGUIENTE NRO
									if (i+"A" == nro_siguiente || i+"B" == nro_siguiente || i+"C" == nro_siguiente || i+"D" == nro_siguiente || i+"X" == nro_siguiente) {
										// SI EXISTE ENTONCES AVERIGUAMOS CUAL ES EL ESTATUS Y SI ES RETIRADO ENTONCES SI PODEMOS COLOCAR DISABLED LOS CHECKBOX
										var status_siguiente = v_car_ejemplar[idCarrera][id_competidor_siguiente]['status'];
										if (status_siguiente == 'retirado') {
											disabledEjemplarPick = "disabled";
										}else{
											idEjemplarPick = id_competidor_siguiente;
										}
									}else{
										// EN CASO DE NO TENER OTRO NRO IGUAL CON LA LETRA A PODEMOS COLOCAR DISABLED
										disabledEjemplarPick = "disabled";
									}
								}else{
									disabledEjemplarPick = "disabled";
								}
							}
							if(statusEjemplarPick == 'invalido'){
								//nom_eje = "<del>" + nom + "</del> (<font color=red>Invalidado</font>)";
								disabledEjemplarPick = "disabled";
							}
							if((statusEjemplarPick == null)||(statusEjemplarPick == 'favorito')){
								//nom_eje = nom;
								disabledEjemplarPick = "";
							}
						}
						apuestas_1=apuestas_1+"<td class=td1 align=center><input onclick=validar() name=" + idEjemplarPick + " id=" + idEjemplarPick + " type=checkbox "+ disabledEjemplarPick +" /></td>";
					}

					apuestas_1=apuestas_1+"</tr>";
				}


				apuestas_1=apuestas_1+"</table>";

				$('#apuestas_1').html( apuestas_1 );
			}
			function tablero_2(status, nom){
				if(status == 'retirado'){
					nom_eje = "<del>" + nom + "</del> (<font color=red>Retirado</font>)";
					disabled = "disabled";
				}
				if(status == 'invalido'){
					nom_eje = "<del>" + nom + "</del> (<font color=red>Invalidado</font>)";
					disabled = "disabled";
				}
				if((status == null)||(status == 'favorito')){
					nom_eje = nom;
					disabled = "";
				}
			}


			function jugada(id_car){

				document.getElementById("jug").options.length=0;

				$("#jug").append("<option value='wps'>Ganar/Place/Show</option>");

				if (arrayCarBet[id_car]) {
					for (var i = 0; i < arrayCarBet[id_car].length; i++) {
						var betName = arrayCarBet[id_car][i];
						$("#jug").append("<option  value='"+betName+"'>"+betName+"</option>");
					}
				}

			}



			if(1==1){

				var v_hip={<?php
					$query_Recordset1z2 = sprintf("/* PARSEADORES1 ventas\Venta_Internacionales.php - QUERY 3 */ SELECT cod_hipodromo, nom_hipodromo FROM carrera WHERE carrera.fec_carrera = %s  AND carrera.est_carrera = 1 ORDER BY carrera.hor_carrera  LIMIT 200", 
GetSQLValueString($fec, "date"));
$Recordset1z2 = mysqli_query($conexionbanca, $query_Recordset1z2) or die(mysqli_error($conexionbanca));
$row_Recordset1z2 = mysqli_fetch_assoc($Recordset1z2);
$totalRows_Recordset1z2 = mysqli_num_rows($Recordset1z2);




					$hipodromoesta2=',';
if($totalRows_Recordset1z2>0){
//	echo 'xx';
	while ($rowLG2 = $Recordset1z2->fetch_array()) { 

	if(!strpos($hipodromoesta2, $rowLG2["nom_hipodromo"])){// }else{ 
			

		?>"<?php echo $rowLG2["cod_hipodromo"]; ?>":"<?php echo $rowLG2["nom_hipodromo"]; ?>",<?php // echo '<br>'; 
	 
	 
	 $hipodromoesta2=$hipodromoesta2.$rowLG2["nom_hipodromo"].',';

	}}}
	?>"9999":"falso"};
				var v_clase_hip={<?php
					$query_Recordset1z3 = sprintf("/* PARSEADORES1 ventas\Venta_Internacionales.php - QUERY 4 */ SELECT cod_hipodromo, nom_hipodromo FROM carrera WHERE carrera.fec_carrera = %s  AND carrera.est_carrera = 1 ORDER BY carrera.hor_carrera  LIMIT 200", 
GetSQLValueString($fec, "date"));
$Recordset1z3 = mysqli_query($conexionbanca, $query_Recordset1z3) or die(mysqli_error($conexionbanca));
$row_Recordset1z3 = mysqli_fetch_assoc($Recordset1z3);
$totalRows_Recordset1z3 = mysqli_num_rows($Recordset1z3);




					$hipodromoesta3=',';
if($totalRows_Recordset1z3>0){
//	echo 'xx';
	while ($rowLG3 = $Recordset1z3->fetch_array()) { 
		//if(!strpos($hipodromoesta, $rowLG["nom_hipodromo"])){ //}else{ 

	if(!strpos($hipodromoesta3, $rowLG3["cod_hipodromo"])){// }else{ 
			

		?>"<?php echo $rowLG3["cod_hipodromo"]; ?>":"a",<?php // echo '<br>'; 
	 
	 
	 $hipodromoesta3=$hipodromoesta3.$rowLG3["cod_hipodromo"].',';

	}}}?>"9999":"a"};

				var limite_wps_a = "";
				var limite_wps_b = "";
				var limite_wps_c = "";
				var limite_wps_d = "";
				var limite_wps_e = "";
				var limite_wps_f = "";

				var limiteTablaFija = "";
				var limiteTablaDinamica = "";
				var limitePuesto = "";
				var limiteMarca = "";

				var v_hip_car=<?php


$paso7='d1d';
$query_Recordset1z4 = sprintf("/* PARSEADORES1 ventas\Venta_Internacionales.php - QUERY 5 */ SELECT hor_carrera, num_carrera, cod_hipodromo, nom_hipodromo FROM carrera WHERE carrera.fec_carrera = %s  AND carrera.est_carrera = 1 ORDER BY carrera.cod_carrera DESC", 
GetSQLValueString($fec, "date"));
$Recordset1z4 = mysqli_query($conexionbanca, $query_Recordset1z4) or die(mysqli_error($conexionbanca));
//$row_Recordset1z4 = mysqli_fetch_assoc($Recordset1z4);
//$totalRows_Recordset1z4 = mysqli_num_rows($Recordset1z4);
//echo $totalRows_Recordset1z4.' totalRows_Recordset1z4';

$final4=',';
$hipodromoesta4=',';

				



//{=x1x }=y1y  "=z1z :=s1s ,=r1r  d1d=nada
$medio40=array();
$num1=0;
$num2=0;

while ($rowLG4 = mysqli_fetch_assoc($Recordset1z4)) {

	$inicio4='x1xz1z'.$rowLG4["cod_hipodromo"].'z1zs1sx1x';
	$medio4='d1d';
if(!strpos($hipodromoesta4, $rowLG4["nom_hipodromo"])){
	$num1++;
	$hipodromoesta4=$hipodromoesta4.$rowLG4["nom_hipodromo"];

	$query_Recordset1z5 = sprintf("/* PARSEADORES1 ventas\Venta_Internacionales.php - QUERY 6 */ SELECT hor_carrera,  cod_carrera, num_carrera, cod_hipodromo, nom_hipodromo 
	FROM carrera 
	WHERE carrera.cod_hipodromo = %s  AND carrera.fec_carrera = %s  AND carrera.est_carrera = 1 
	ORDER BY carrera.num_carrera  ASC", 
	GetSQLValueString($rowLG4["cod_hipodromo"], "int"),
	GetSQLValueString($fec, "date"));
	$Recordset1z5 = mysqli_query($conexionbanca, $query_Recordset1z5) or die(mysqli_error($conexionbanca));

$medio41=array();

while ($rowLG5 = mysqli_fetch_assoc($Recordset1z5)) {
$num2++;







$medio44 ='z1z'.$rowLG5["cod_carrera"].'z1zs1sx1xz1zcarz1zs1sz1z'.$rowLG5["num_carrera"].'z1zr1rz1zpostTimez1zs1sz1z'.$rowLG5["hor_carrera"].'z1zy1yr1r';


$medio4=$medio4.$medio44;




}



$paso6='z1z'.$rowLG4["cod_hipodromo"].'z1zs1sx1x'.$medio4;
$paso6 = substr($paso6, 0, -3);
$paso6=$paso6.'y1yr1r';

$paso7=$paso7.$paso6;
$hipodromoesta=$hipodromoesta.$rowLG["nom_hipodromo"].',';
}}


//{=x1x }=y1y  "=z1z :=s1s ,=r1r  d1d=nada

$paso7='x1x'.$paso7;
$paso7=str_replace('x1x', '{', $paso7); 
$paso7=str_replace('y1y', '}', $paso7);
$paso7=str_replace('z1z', '"', $paso7);
$paso7=str_replace('s1s', ':', $paso7);
$paso7=str_replace('r1r', ',', $paso7);
$paso7=str_replace('d1d', '', $paso7);

$paso7 = substr($paso7, 0, -1);

print_r($paso7);





?>};



				var v_car_ejemplar={<?php
				$query_Recordset1z6 = sprintf("/* PARSEADORES1 ventas\Venta_Internacionales.php - QUERY 7 */ SELECT can_caballos, hor_carrera,  cod_carrera, num_carrera, cod_hipodromo, nom_hipodromo 
	FROM carrera 
	WHERE  carrera.fec_carrera = %s  AND carrera.est_carrera = 1 
	ORDER BY carrera.num_carrera  ASC", 
	GetSQLValueString($fec, "date"));
	$Recordset1z6 = mysqli_query($conexionbanca, $query_Recordset1z6) or die(mysqli_error($conexionbanca));
	$medio6='d1d';

	$paso88='d1d';
while ($rowLG6 = mysqli_fetch_assoc($Recordset1z6)) {

$inicio66=$rowLG6["cod_carrera"].' ';

//estoy aqui 

$i = 1;

$medio66='d1d';
while ($i <= $rowLG6["can_caballos"]) {
	$i100=$i+100;


	$medio6=$rowLG6["cod_carrera"].$i100;
	$medio66=$medio66.'z1zs1sx1xz1z'.$medio6.'z1zs1sx1xz1znroz1zs1sz1z'.$i.'z1zr1rz1znomz1zs1sz1z'.$i.'z1zr1rz1zstatusz1zs1snull';
$i++; 
}
// ":{" z1zs1sx1xz1z  //":" z1zs1sz1z //"," z1zr1rz1z //": z1zs1s //null":{" nullz1zs1sx1xz1z //null}," nully1yr1rz1z //null" nullz1z
//null}}, nully1yy1yr1r //}}, y1yy1yr1r
//{=x1x }=y1y  "=z1z :=s1s ,=r1r  d1d=nada
//final null}}, final correcto null}}};
//}}; y1yy1yv1v
$paso8='z1z'.$rowLG6["cod_carrera"].'z1zs1sx1xz1z'.$medio66.'y1yy1yr1r';
//echo $paso8;
//echo $paso8;
$paso8=str_replace('nullz1zs1sx1xz1z', 'nully1yr1rz1z', $paso8); 
//$paso8=str_replace('nullz1z', 'nully1yy1yr1r', $paso8); 

$paso8=str_replace('z1zs1sx1xz1zd1dz1zs1sx1xz1z', 'z1zs1sx1xz1z', $paso8); 
$paso8=str_replace('x1x', '{', $paso8); 
$paso8=str_replace('y1y', '}', $paso8);
$paso8=str_replace('z1z', '"', $paso8);
$paso8=str_replace('s1s', ':', $paso8);
$paso8=str_replace('r1r', ',', $paso8);
$paso8=str_replace('d1d', '', $paso8);
$paso88=$paso88.$paso8;
}
$paso88=str_replace('d1d', '', $paso88);
$paso88 = substr($paso88, 0, -1);
$paso88 =$paso88;
$paso88=str_replace('x1x', '{', $paso88);
$paso88=str_replace('y1y', '}', $paso88);
$paso88=str_replace('v1v', ';', $paso88);
echo $paso88;	
?>};











var v_car_pick=



{
					
					"234478":{"2":"1","3":"1"},
					"234479":{"2":"2","3":"2","5":"2"},
					"648380":{"2":"3","3":"3","4":"3"},
					"234481":{"2":"4","3":"4"},
					"234482":{"2":"5","3":"5","6":"5"},
					"234483":{"2":"6","3":"6","5":"6"},
					"234484":{"2":"7","3":"7","4":"7"},
					"234485":{"2":"8","3":"8"},
					"234486":{"2":"9"},
					"234488":{"2":"1","3":"1","4":"1"},
					"234489":{"2":"2","3":"2"},
					"234490":{"2":"3","3":"3","4":"3"},
					"234491":{"2":"4","3":"4"},
					"234492":{"2":"5","3":"5","4":"5"},
					"234493":{"2":"6","3":"6"},
					"234494":{"2":"7","3":"7","5":"7"},
					"234495":{"2":"8","3":"8","4":"8"},
					"234496":{"2":"9","3":"9"},
					"234497":{"2":"10"},
					"234499":{"2":"1","3":"1","4":"1"},
					"234500":{"2":"2","3":"2"},
					"234501":{"2":"3","3":"3","5":"3"},
					"234502":{"2":"4","3":"4"},
					"234503":{"2":"5","3":"5","4":"5"},
					"234504":{"2":"6","3":"6"},
					"234505":{"2":"7"}};
					var arrayCarBet={<?php
									$query_Recordset1z61 = sprintf("/* PARSEADORES1 ventas\Venta_Internacionales.php - QUERY 8 */ SELECT carrera.TipoApuestas, carrera.cod_carrera
									FROM carrera 
									WHERE  carrera.fec_carrera = %s  AND carrera.est_carrera = 1 
									ORDER BY carrera.cod_carrera  ASC", 
									GetSQLValueString($fec, "date"));
									$Recordset1z61 = mysqli_query($conexionbanca, $query_Recordset1z61) or die(mysqli_error($conexionbanca));
					//{
					$ini6='';
					//nada
					$med61='d1d';
					$med612='d1d';
					//};
					$fin6='';
									//{=x1x }=y1y  "=z1z :=s1s ,=r1r  d1d=nada k1k=[   j1j=]
									//",] z1zr1rj1j //z1zj1j
									while ($rowLG61 = mysqli_fetch_assoc($Recordset1z61)) {
									//	$med61x=$med61'd1d';
										
					$med61='z1z'.$rowLG61["cod_carrera"].'z1zs1sk1kz1zExactaz1zr1rz1zTrifectaz1zr1rz1zSuperfectaz1zr1r';
					$TipoApuestas='9'.$rowLG61["TipoApuestas"];
					if(strpos($TipoApuestas, '2')){ $med61=$med61.'z1zDaily Doublez1zr1r'; }
					if(strpos($TipoApuestas, '3')){ $med61=$med61.'z1zPick 3z1zr1r'; }
					if(strpos($TipoApuestas, '4')){ $med61=$med61.'z1zPick 4z1zr1r'; }
					if(strpos($TipoApuestas, '5')){ $med61=$med61.'z1zPick 5z1zr1r'; }



					//$med61=str_replace('z1zr1rj1j', 'z1zj1j', $med61); 
					$med61=str_replace('k1k', '[', $med61); 
					$med61=str_replace('j1j', ']', $med61);
					$med61=str_replace('x1x', '{', $med61); 
					$med61=str_replace('y1y', '}', $med61);
					$med61=str_replace('z1z', '"', $med61);
					$med61=str_replace('s1s', ':', $med61);
					$med61=str_replace('r1r', ',', $med61);
					$med61=str_replace('d1d', '', $med61);
					$med61=$med61.'j1jr1r';
					$med61=str_replace('j1j', ']', $med61);
					$med61=str_replace('r1r', ',', $med61);
					$med612=$med612.$med61;
					$med612=str_replace('d1d', '', $med612);
					$med612=str_replace('",]', '"]', $med612);
									}
									//"234478":["Exacta","Trifecta","Superfecta","Daily Double","Pick 3"],
									//"234479":["Exacta","Trifecta","Superfecta","Daily Double","Pick 3","Pick 5"]
									$med612 = substr($med612, 0, -1);
									echo $med612;	
					
					?>};
				//console.log(v_hip_car);


				function select_hip(){

					id_hip = document.getElementById("hip").value;


					document.getElementById("car").options.length=0;

					var i = 1;
					for (id_car in v_hip_car[id_hip]) {
						if (i == 1) {
							var id_car1 = id_car;
						}
						i = 0;
						$('#car').append('<option  id=car' + id_car + ' value=' + id_car + ' >Carrera '+v_hip_car[id_hip][id_car]['car']+' / Hora ' + v_hip_car[id_hip][id_car]['postTime'] + '</option>');
					}

					id_car = id_car1;

					jugada(id_car);

					$('#apuestas_1').html( tablero(id_hip, id_car, "wps") );

					document.getElementById("nom_hip").value = v_hip[id_hip];
					document.getElementById("limite_wps").value = eval("limite_wps_" + v_clase_hip[id_hip]);
				}

				function select_car(){
					id_car = document.getElementById("car").value;
					jugada(id_car);
					$('#apuestas_1').html( tablero(id_hip, id_car, "wps") );
				}

				$("#jug").change(function(){

					jug=$(this).val();
					tablero(id_hip, id_car, jug);
				});
				 
				var tot=0;
				var nro_jug=0;
				// selecciona 1ero 2do 3ro y 4to lugar al precionar el boton seleccionar
				function sel(sel) {

					var select_jug = document.getElementById("jug").value;

					var sel_aa = document.getElementById("aa"+sel).checked;
					var sel_bb = document.getElementById("bb"+sel).checked;

					if((sel_aa == false)||(sel_bb == false)){
						document.getElementById("aa"+sel).checked=true;
						document.getElementById("bb"+sel).checked=true;
					}else{
						document.getElementById("aa"+sel).checked=false;
						document.getElementById("bb"+sel).checked=false;
					}

					if(select_jug == "Trifecta" || select_jug == "Superfecta"){
						var sel_cc = document.getElementById("cc"+sel).checked;
						if((sel_aa == false)||(sel_bb == false)||(sel_cc == false)){
							document.getElementById("cc"+sel).checked=true;
						}else{
							document.getElementById("cc"+sel).checked=false;
						}
					}

					if(select_jug == "Superfecta"){
						var sel_dd = document.getElementById("dd"+sel).checked;
						if((sel_aa == false)||(sel_bb == false)||(sel_cc == false)||(sel_dd == false)){
							document.getElementById("dd"+sel).checked=true;
						}else{
							document.getElementById("dd"+sel).checked=false;
						}
					}
					validar();
				}

				function substraerLetra(nro){
					//devuelve true si existe A en el nro
					// RegExp lo que hace es poner un / al inicio y al final
					var letraA = new RegExp("A");
					var letraB = new RegExp("B");
					var letraC = new RegExp("C");
					var letraD = new RegExp("D");
					var letraX = new RegExp("X");
					// El método test () prueba una coincidencia en una cadena.
					// Este método devuelve verdadero si encuentra una coincidencia; de lo contrario, devuelve falso.
					if(letraA.test(nro) || letraB.test(nro) || letraC.test(nro) || letraD.test(nro) || letraX.test(nro)){
						//resta el ultimo caracter a la cadena
						nro = nro.slice(0,-1);
					}
					return nro;
				}



				function validar_2(bs){

					tot=0;
					nro_jug=0;
					var select_jug = document.getElementById("jug").value;
					var id_car = document.getElementById("car").value;

					if(select_jug == "wps"){
						for (id_competidor in v_car_ejemplar[id_car]) {
							if (document.getElementById('aa'+id_competidor).checked == true){
								tot = Number(tot) + Number(bs);
								nro_jug++;
							}
							if (document.getElementById('bb'+id_competidor).checked == true){
								tot = Number(tot) + Number(bs);
								nro_jug++;
							}
							if (document.getElementById('cc'+id_competidor).checked == true){
								tot = Number(tot) + Number(bs);
								nro_jug++;
							}
						}
					}

					if(select_jug == "Exacta" || select_jug == "Quinella"){
						for (id_competidor in v_car_ejemplar[id_car]) {
							if (document.getElementById('aa'+id_competidor).checked == true){
								var nro = substraerLetra(v_car_ejemplar[id_car][id_competidor]['nro']);				
								for (id_competidor_b in v_car_ejemplar[id_car]) {
									var nro_b = substraerLetra(v_car_ejemplar[id_car][id_competidor_b]['nro']);
									if ((document.getElementById('bb'+id_competidor_b).checked == true) && (nro != nro_b)){
										tot = Number(tot) + Number(bs);
										nro_jug++;
									}
								}
							}
						}
					}

					if(select_jug == "Trifecta"){
						for (id_competidor in v_car_ejemplar[id_car]) {
							if (document.getElementById('aa'+id_competidor).checked==true){
								var nro = substraerLetra(v_car_ejemplar[id_car][id_competidor]['nro']);
								for (id_competidor_b in v_car_ejemplar[id_car]) {
									var nro_b = substraerLetra(v_car_ejemplar[id_car][id_competidor_b]['nro']);
									if ((document.getElementById('bb'+id_competidor_b).checked==true)&&(nro != nro_b)){
										for (id_competidor_c in v_car_ejemplar[id_car]) {
											var nro_c = substraerLetra(v_car_ejemplar[id_car][id_competidor_c]['nro']);
											if ((document.getElementById('cc'+id_competidor_c).checked==true)&&(nro_c != nro)&&(nro_c != nro_b)){
												tot = Number(tot) + Number(bs);
												nro_jug++;
											}
										}
									}
								}
							}
						}
					}

					if(select_jug == "Superfecta"){
						for (id_competidor in v_car_ejemplar[id_car]) {
							if (document.getElementById('aa'+id_competidor).checked==true){
								var nro = substraerLetra(v_car_ejemplar[id_car][id_competidor]['nro']);
								for (id_competidor_b in v_car_ejemplar[id_car]) {
									var nro_b = substraerLetra(v_car_ejemplar[id_car][id_competidor_b]['nro']);
									if ((document.getElementById('bb'+id_competidor_b).checked==true)&&(nro != nro_b)){
										for (id_competidor_c in v_car_ejemplar[id_car]) {
											var nro_c = substraerLetra(v_car_ejemplar[id_car][id_competidor_c]['nro']);
											if ((document.getElementById('cc'+id_competidor_c).checked==true)&&(nro_c != nro)&&(nro_c != nro_b)){
												for (id_competidor_d in v_car_ejemplar[id_car]) {
													var nro_d = substraerLetra(v_car_ejemplar[id_car][id_competidor_d]['nro']);
													if ((document.getElementById('dd'+id_competidor_d).checked == true)&&(nro_d != nro)&&(nro_d != nro_b)&&(nro_d!=nro_c)){
														tot = Number(tot) + Number(bs);
														nro_jug++;
													}
												}
											}
										}
									}
								}
							}
						}
					}

					for (var i = 2; i <= 6; i++) {

						if (i == 2) {
							var pickName = "Daily Double";
						}else{
							var pickName = "Pick "+i+"";
						}

						if(select_jug == pickName){
							//INICIO ACCION
							nro_jug = 1;
							for ( j=1; j <= i; j++) {
								
								eval("nro_jug_car"+j+" = 0");
								for (nro_competidor in eval("v_car"+j+"_num_id")) {

									var pickCheckboxId = document.getElementById(eval("v_car"+j+"_num_id[nro_competidor]"));

									if (pickCheckboxId) {

										if (pickCheckboxId.checked == true){
											eval("nro_jug_car"+j+"++");
										}
									}

								}

								nro_jug = nro_jug * eval("nro_jug_car"+j+"++");
							}
							tot = bs * nro_jug;
							break;
						}
					}
				}

				function validar() {
					if (tipo_s == 'Vendedor') {
						document.getElementById('bs').focus();
					}
					document.getElementById("nro").value = '';
					document.getElementById("gan").value = '';
					document.getElementById("pla").value = '';
					document.getElementById("sho").value = '';
					var bs = document.getElementById("bs").value;

					validar_2(bs);

					//tot = tot.toFixed(2);
					$("#tot").text(numberFormat(tot));
					$("#nro_jug").text(nro_jug);
					if(tot==0){
						document.getElementById("enviar").disabled=true;
					}else{
						document.getElementById("enviar").disabled=false;
					}
					document.getElementById("inp_tot").value=tot;
				}
				 
				$("#bs").on("change paste keyup", function() {
					var bs=$(this).val();

					validar_2(bs);

					//tot = tot.toFixed(2);
					$("#tot").text(numberFormat(tot));

					if(tot==0){
						document.getElementById("enviar").disabled=true;
					}else{
						document.getElementById("enviar").disabled=false;
					}

					document.getElementById("inp_tot").value=tot;
				});

				function destildar(valor){
					document.getElementById("bs").value = '';
					$("#tot").text("0,00");
					$("#nro_jug").text("0");

					var select_jug = document.getElementById("jug").value;
					var id_car = document.getElementById("car").value;

					if(select_jug == "wps" || select_jug == "Exacta" || select_jug == "Quinella" || select_jug == "Trifecta" || select_jug == "Superfecta"){
						for (id_competidor in v_car_ejemplar[id_car]) {
							document.getElementById("aa"+id_competidor).checked=false;
							document.getElementById("bb"+id_competidor).checked=false;
							if(select_jug == "wps" || select_jug == "Trifecta" || select_jug == "Superfecta"){
								document.getElementById("cc"+id_competidor).checked=false;
							}
							if(select_jug == "Superfecta"){
								document.getElementById("dd"+id_competidor).checked=false;
							}
						}
					}


					for (var i = 2; i <= 6; i++) {

						if (i == 2) {
							var pickName = "Daily Double";
						}else{
							var pickName = "Pick "+i+"";
						}

						if(select_jug == pickName){

							for ( j=1; j <= max_nro; j++) {

								for (var k = 1; k <= i; k++) {
									// SI RETIRAN A UN NRO QUE TENGA UNA LLAVE CON LETRA QUE NO ESTE RETIRADO EL ID DEL INPUT DEL NRO NO ESTARA POR LO CUAL EN CASO DE QUE NO ESTE LE SUMO UN NRO AL ID EJEMPLAR QUE VENDRA A SER EL NRO CON LA LETRA
									var idEjemplarPick = eval("v_car"+k+"_num_id["+j+"]");
									var inputChekbox = document.getElementById(idEjemplarPick);
									if (inputChekbox == null) {
										idEjemplarPick++;
									}
									document.getElementById(idEjemplarPick).checked=false;
								}
							}
							break;
						}
					}

					if((select_jug == "Tabla Fija")||(select_jug == "Tabla Dinamica")||(select_jug == "Puesto")){
						if (payValue != "") {
							for (id_competidor in v_car_ejemplar[id_car]) {
								document.getElementById("monto_"+id_competidor).value='';
							}
						};
					}

					if((document.getElementById("nro").value!="")&&((document.getElementById("pla").value!="")||(document.getElementById("gan").value!="")||(document.getElementById("sho").value!="")||(valor == 1))){

						document.getElementById("enviar").disabled=false;
					}else{
						document.getElementById("enviar").disabled=true;
					}
				}

				$("#nro").on("change paste keyup", function() {
					destildar(1);
				});

				$("#gan").on("change paste keyup", function() {
					destildar(0);
				});

				$("#pla").on("change paste keyup", function() {
					destildar(0);
				});

				$("#sho").on("change paste keyup", function() {
					destildar(0);
				});
			

				document.getElementById("hip").remove("cero");
				document.getElementById("car").remove("cero");
				document.getElementById("jug").remove("cero");
				var id_hip = document.getElementById("hip").value;
				var id_car = document.getElementById("car").value;
				document.getElementById("nom_hip").value = v_hip[id_hip];
				document.getElementById("limite_wps").value = eval("limite_wps_" + v_clase_hip[id_hip]);
				
				//console.log( eval("limite_wps_" + v_clase_hip[id_hip]) );

				var jug = "wps";
				$('#apuestas_1').html( tablero(id_hip, id_car, jug) );
				document.getElementById("hip").disabled=false;
				document.getElementById("car").disabled=false;
				document.getElementById("jug").disabled=false;

				document.getElementById("gan").disabled=false;
				document.getElementById("pla").disabled=false;
				document.getElementById("sho").disabled=false;

			}
			document.addEventListener("DOMContentLoaded", function(){
                //Refrescar cada 10 minutos para evitar que se cierre la session
                var milisegundos = 10*60*1000;
                setInterval(function(){
                    fetch(ruta+"refresh_session.php");
                },milisegundos);
            });
		</script>
	
</body></html>


<?php	

//$json=json_encode($requisito,JSON_UNESCAPED_SLASHES);
//echo $json;


//echo $hipodromoesta; 
//print_r($ArrayLogros);


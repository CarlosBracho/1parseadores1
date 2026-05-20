<?php
  
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;

			$datetime4 = strtotime('+6 hour', strtotime($datetime));
				$datetime4 = date('Y-m-d H:i:s', $datetime4);
				
//echo '<br><br><br><br><br><br>';
//var_dump($_SESSION);
//echo '<br><br><br><br><br><br>';
//SELECT DISTINCT id,apellido,nombre FROM mitabla
$query_Recordset10 = sprintf(
	"/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 1 */ SELECT * 
	FROM 
	tasadecambio"
  );
  $Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
  $row_Recordset10 = mysqli_fetch_assoc($Recordset10);
  $totalRows_Recordset10 = mysqli_num_rows($Recordset10);

if (!isset($_SESSION["monedaani"])){$_SESSION["monedaani"] = "0";}
function cambiomoneda($moneda)
{
if($moneda==0){$_SESSION["monedaani"] = "0";}
if($moneda==3){$_SESSION["monedaani"] = "3";}
if($moneda==4){$_SESSION["monedaani"] = "4";}
}



$query_Recordset1_ani3 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 2 */ SELECT 
*
    FROM 
	 taquilla_opc_ani
	WHERE taquilla_opc_ani.cod_taquilla=%s 
 LIMIT 1",
		   GetSQLValueString($_SESSION["MM_cod_taquilla"], "date")
		   );
    $Recordset1_ani3 = mysqli_query($conexionbanca, $query_Recordset1_ani3) or die(mysqli_error($conexionbanca));
    $row_Recordset1_ani3 = mysqli_fetch_assoc($Recordset1_ani3);
    $totalRows_Recordset1_ani3 = mysqli_num_rows($Recordset1_ani3);
//echo $row_Recordset1_ani3["varios_x_loteria"];
//echo $row_Recordset1_ani3["varios_x_loteria"].'<br>';
$varios_x_loteria = explode("-", $row_Recordset1_ani3["varios_x_loteria"]);
//echo $varios_x_loteria[1].' <br>';



$query_Recordset1_1erselect1 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 3 */ SELECT 
id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1
    FROM 
	ani1_loterias_y_nombres
   ORDER BY id_Loterias_y_nombres_ani1");
    $Recordset1_1erselect1 = mysqli_query($conexionbanca, $query_Recordset1_1erselect1) or die(mysqli_error($conexionbanca));
    $row_Recordset1_1erselect1 = mysqli_fetch_assoc($Recordset1_1erselect1);
    $totalRows_Recordset1_1erselect1 = mysqli_num_rows($Recordset1_1erselect1);

	$vueltas=0;




?>
<!DOCTYPE html>
<!-- saved from url=(0039)https://apuestas1.us.to.com/taquilla/ventas/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>.:Apuestas:.</title>
		<link href="../css/bootstrap4.css" rel="stylesheet">
	
        		            <link href="./Venta _ Lotoriente_files/bootstrap.css" rel="stylesheet" type="text/css">
							
            <link href="./Venta _ Lotoriente_files/font-awesome.css" rel="stylesheet" type="text/css">
            <link href="./Venta _ Lotoriente_files/animalito.css" rel="stylesheet" type="text/css">
            <link href="./Venta _ Lotoriente_files/animalito-bootstrap-theme.css" rel="stylesheet" type="text/css">
        
	<link href="./Venta _ Lotoriente_files/menu.css" rel="stylesheet" type="text/css">

	<link type="text/css" rel="stylesheet" href="./Venta _ Lotoriente_files/ntf.css">
	<link href="./Venta _ Lotoriente_files/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="./Venta _ Lotoriente_files/datatables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">




</head>
    <body>
	<header> 
  <!-- Fixed navbar -->
  <?php include('menutaa.php'); ?>
</header>




	
			<div class="bg-warning" style="height:30px; color:#000; padding:5px 5px 5px 5px; text-align:right;">
 Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             1 USD: <?php echo $row_Recordset10['usdabss']; ?> 1 COP: <?php echo $row_Recordset10['copabss']; ?> 1 SOL: <?php echo $row_Recordset10['solabss']; ?>
			 </div><br>



	<div>
	<select id="loteria_seleccionada" class="form-control input-sm form-/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 4 */ select" title="Loterías">
						
						<?php		

			
			
			
						$selected=0;
			
						do{

					$query_Recordset1_1erselect2 = sprintf(
						"/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 5 */ SELECT  
					id_solteo_ani4
						FROM 
						ani4_solteos
					   WHERE id_Loterias_y_nombres_ani4=%s AND fechahora_solteo_ani4>%s LIMIT 1",
					   GetSQLValueString($row_Recordset1_1erselect1["id_Loterias_y_nombres_ani1"], "int"),
					   GetSQLValueString($datetime4, "date")
					   );
						$Recordset1_1erselect2 = mysqli_query($conexionbanca, $query_Recordset1_1erselect2) or die(mysqli_error($conexionbanca));
						$row_Recordset1_1erselect2 = mysqli_fetch_assoc($Recordset1_1erselect2);
						$totalRows_Recordset1_1erselect2 = mysqli_num_rows($Recordset1_1erselect2);
			
				//echo 'Nombre '.$row_Recordset1_1erselect_int["nom_Loterias_y_nombres_ani1"].' hora '.$row_Recordset1_1erselect["id_Loterias_y_nombres_ani4"].'<br>';
				$vueltas++;

				$varios_x_loteria2 = explode(",", $varios_x_loteria[$row_Recordset1_1erselect1["id_Loterias_y_nombres_ani1"]]);
				//echo 'varios_x_loteria2 '.$varios_x_loteria2[1].' <br>';
				$yyy1=$varios_x_loteria2[2];
				//if($yyy1==0){
					if($varios_x_loteria2[1]==1){
			if($totalRows_Recordset1_1erselect2==1){
				

			?>
			
			<option value="<?php  echo $row_Recordset1_1erselect1["id_Loterias_y_nombres_ani1"];  ?>" data-url="creador_json_lista_ani_y_sol.php?lot=<?php  echo $row_Recordset1_1erselect1["id_Loterias_y_nombres_ani1"];  ?>&act=<?php  echo $_SESSION["MM_cod_taquilla"];  ?>" data-nombre="<?php  echo $row_Recordset1_1erselect1["nom_Loterias_y_nombres_ani1"];  ?>" <?php  if($selected==0){$selected=1; ?> selected="selected" 
				<?php $lotactual=$row_Recordset1_1erselect1["id_Loterias_y_nombres_ani1"];
				?>





				
				<?php } ?>>
									 <?php  echo $row_Recordset1_1erselect1["nom_Loterias_y_nombres_ani1"];  ?>
							</option>
			
			
			<?php	
			}}

			if($varios_x_loteria2[0]==$lotactual){
			$cierre_adelantado=$varios_x_loteria2[4];
		}
			
			} while ($row_Recordset1_1erselect1 = mysqli_fetch_assoc($Recordset1_1erselect1));
						
				
			if($row_Recordset1_ani3['opc_cierre']==0){
				$minxcerrar=$row_Recordset1_ani3['cierre_adelantado']*60;
				}else{
					$minxcerrar=$cierre_adelantado*60;
				}
				$datetime5 = strtotime('+6 hour', strtotime($datetime));
				$datetime5 = $datetime5+$minxcerrar;
				$datetime5 = date('Y-m-d H:i:s', $datetime5);

			?>
						
			
			
			
			
							  
			
			
			
			
			
			
			
								</select>

								</div>
								




		<div class="dashboard-data">
			<div class="container-fluid">
	<div id="print-ticket-area"></div>
	<input type="hidden" id="hidden_id_loteria" value="2">
	<input type="hidden" id="hidden_nombre_loteria" value="LOTTO ACTIVO2">
	<input type="hidden" id="hidden_id_agencia" value="130">
	<div class="row">
		<div class="col-md-8 col-lg-8 no-padding-right">
			<div class="panel panel-default">
				<div class="jugada-rapida">
					<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
		<form id="form-numero-animalito">
			<div class="form-group"  hidden>
				<input type="text" id="numero_animalito" class="form-control" placeholder="Animalitos">
			</div>
		</form>
	</div>
	<div class="col-sm-3 col-md-3 col-lg-3 padding-left-right-5px">
		<form id="form-hora-sorteo">
			<div class="form-group typeahead-input"  hidden>
				<input type="text" id="hora_sorteo" class="form-control" placeholder="Sorteos">
			</div>
		</form>
	</div>
	<form id="form-monto">
		<div class="col-sm-5 col-md-5 col-lg-5 padding-left-right-5px">
			<div class="form-group">
				<div class="input-group">
											<input type="text" id="monto" class="form-control monto" placeholder="Monto" data-mask="#.00" data-mask-reverse="true" autocomplete="off">
						<div class="input-group-btn">						
							<button  type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-moneda="2,Bs" data-minimo="1.00"  hidden>
									 <span  class="caret"></span>
							</button>
							
							<ul id="seleccion-monedaxx" class="dropdown-menu"  hidden>
									<li>
										<a  data-id-monedaxx="1" data-minimoxx="1.00">Bs</a>
									</li>
									<li>
										<a  data-id-monedaxx="2" data-minimoxx="1.00">USD</a>
									</li>
                            </ul>



						</div>
									</div>
			</div>

		</div>

		<div class="col-sm-2 col-md-2 col-lg-2 padding-left-right-5px">
		<select id="ddlViewBy">
  <option value="0" <?php if($_SESSION["monedaani"]==0 ) { ?> selected="selected" <?php } ?> >Bs</option>
  <option value="3" <?php if($_SESSION["monedaani"]==3 ) { ?> selected="selected" <?php } ?> >Usd</option>
  <option value="4" <?php if($_SESSION["monedaani"]==4 ) { ?> selected="selected" <?php } ?> >Cop</option>
  <option value="5" <?php if($_SESSION["monedaani"]==5 ) { ?> selected="selected" <?php } ?> >Sol</option>
</select>

	 <table>
    <tr><td  hidden>

    <td></tr>



</table>


					</div>

					&nbsp;&nbsp;&nbsp;&nbsp;









					<div class="col-sm-2 col-md-2 col-lg-2 padding-left-right-5px"  hidden>
					<input class="form-check-input" type="checkbox" value="" id="Tripleta">
      <label class="form-check-label" for="invalidCheck">
	  &nbsp;&nbsp; Tripleta
      </label>
					</div>






		<div class="col-sm-2 col-md-2 col-lg-2 padding-left-right-5px">
							<button type="submit" class="btn btn-success">Ok</button>
					</div>
	</form>
</div> <!-- .row -->				</div> <!-- .jugada-rapida -->
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-8 col-md-8 col-lg-8 no-padding-left-right">
							<div class="panel panel-default panel-seleccion panel-seleccion-animalitos">
								<div class="panel-heading">
									<div class="checkbox">
										<label>
											<input type="checkbox" data-toggle="/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 6 */ select-all-animalitos">
											<strong>Animalitos</strong>
										</label>
									</div>
								</div>
<div class="seleccion-animalito">
										


<?php	
if (isset($lotactual)) {
	?>

<div class="panel-body">
		<div class="listado-animalitos">
			<div class="row">

			<?php







$query_Recordset1_ani1_loterias_y_nombres = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 7 */ SELECT 
id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1
    FROM 
	ani1_loterias_y_nombres
	WHERE id_Loterias_y_nombres_ani1=%s
   ORDER BY id_Loterias_y_nombres_ani1 LIMIT 1",
		   GetSQLValueString($lotactual, "int")
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
							</div> <!-- .panel.panel-default -->
						</div> <!-- .col-* -->

						<?php	
}
	?>







</div><!-- seleccion-animalito -->
							</div> <!-- .panel.panel-default -->
						</div> <!-- .col-* -->
						<div class="col-sm-4 col-md-4 col-lg-4 no-padding-left-right">
							<div class="panel panel-default panel-seleccion panel-seleccion-sorteos">
								<div class="panel-heading">
									<div class="checkbox">
										<label>
											<input type="checkbox" data-toggle="/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 8 */ select-all-sorteos">
											<strong>Sorteos</strong>
										</label>
									</div>
								</div>
								<div class="seleccion-sorteo">
										<div class="panel-body">
		<div class="listado-sorteos">
			<div class="row">
								


			<?php	
if (isset($lotactual)) {
	?>



			<?php


$query_Recordset1_ani4_solteos = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 9 */ SELECT 
id_solteo_ani4, fechahora_solteo_ani4
    FROM 
	ani4_solteos
	WHERE id_Loterias_y_nombres_ani4=%s AND fechahora_solteo_ani4>%s AND estado_ani4=0
   ORDER BY fechahora_solteo_ani4 LIMIT 20",
		   GetSQLValueString($lotactual, "int"),
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









<?php
}

?>







			</div>
		</div>
	</div> <!-- .panel-body -->















								</div>
							</div> <!-- .panel.panel-default -->
						</div> <!-- .col-* -->
					</div> <!-- .row -->
				</div> <!-- .container-fluid -->
			</div> <!-- .panel.panel-default -->
		</div> <!-- .col-* -->
		<div class="col-md-4 col-lg-4">
			<div class="panel panel-primary detalle-ticket">
	<div class="panel-heading">
		<div class="hotkeys btn-toolbar">
	<div class="btn-group btn-group-xs" role="group" aria-label="..."  hidden>
  		<form name="imprimir_ticket" method="post" action="saveTicket.php">
			<button class="btn btn-warning btn-xs" data-toggle="save" title="Guardar ticket (F1)" disabled="">
				<span class="fa fa-save"></span>
			</button>
		</form>
	</div>
     <div class="btn-group btn-group-xs" role="group" aria-label="...">
        <form name="save_and_imprimir_ticket" method="post" action="saveTicket.php">
            <button class="btn btn-warning btn-xs" data-toggle="save" title="Guardar e imprimir ticket (Ctrl+F1)" disabled="">
                <span class="fa fa-print"></span>
            </button>
        </form>
    </div>
	<div class="btn-group btn-group-xs" role="group" aria-label="...">
  		<button class="btn btn-warning" data-toggle="cancel" title="Cancelar todas las jugadas (ESC)">
  			<span class="fa fa-times"></span>
  		</button>
	</div>
	<div class="btn-group btn-group-xs" role="group" aria-label="..."  hidden>
  		<button class="btn btn-warning" data-toggle="modal" title="Repetir ticket (F2)" data-target="#modal_repetir_ticket">
  			<span class="fa fa-repeat"></span>
  		</button>
	</div>



	<?php





$query_Recordset1reimp = sprintf("/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 10 */ SELECT * FROM ani5_jugadas 
WHERE  fechahora_creacion_ani5 >= %s AND id_usuario_ani5 = %s ORDER BY id_ticket_ani5 DESC LIMIT 1", 
GetSQLValueString($FechaTxt.' 00:00:01', "date"), 
GetSQLValueString($_SESSION["MM_id_usuario"], "int"));
$Recordset1reimp = mysqli_query($conexionbanca, $query_Recordset1reimp) or die(mysqli_error($conexionbanca));
$row_Recordset1reimp = mysqli_fetch_assoc($Recordset1reimp);
$totalRows_Recordset1reimp = mysqli_num_rows($Recordset1reimp);
echo $row_Recordset1reimp["can_ticket_ani5"];

//aqui
?>
	<div class="btn-group btn-group-xs" role="group" aria-label="...">
	<form name="reimprimir_ticket" method="post" action="saveTicket.php">
  		<button class="btn btn-warning" data-toggle="modal" title="Reimprimir ultimo ticket">
  			<span class="fa fa-repeat"></span>
  		</button>
		  </form>
	</div>


	<div class="btn-group btn-group-xs" role="group" aria-label="..."  hidden>
  		<button class="btn btn-warning" data-toggle="modal" title="Consultar últimos tickets vendidos (F3)" data-target="#modal_listado_ventas_recientes">
  			<span class="fa fa-clock-o"></span>
  		</button>
	</div>
</div>		<span  hidden>Detalles ticket <span class="badge" id="cantidad_jugadas_ticket">0</span></span>
	</div>
	<div class="panel-doby">
		<div class="encabezado">
			<div class="detalle-monto">
				<strong>Total: </strong>
				<span class="badge" id="monto_total_ticket">0.00</span>
				<strong id='moneda2' class="simbolo-moneda">
									Bs
							</strong>
			</div>
		</div>
		<div class="list-group">
			<!-- -->
		</div>
	</div>
</div>		</div>
	</div> <!-- .row -->
	<div class="modal fade" id="modal_listado_ventas_recientes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-url="/taquilla/ventas/ventasRecientes">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Ventas recientes</h4>
			</div>
			<div class="modal-body">
				<section class="listado_ventas_recientes">
	      			<table id="table_ventas_recientes" class="table table-striped table-hover table-condensed DataTable" cellspacing="0" width="100%" data-order="false">
				        <thead>
				            <tr>
				                <th data-orderable="false">Nro. ticket</th>
				                <th data-orderable="false">Hora</th>
								<th data-orderable="false">Moneda</th>
				                <th data-orderable="false">Monto</th>
				                <th data-orderable="false">Premio</th>
				                <th data-orderable="false">Email</th>
				                <th data-orderable="false">SMS</th>
				                <th data-orderable="false">Estatus</th>
				                <th data-orderable="false">Acción</th>
				            </tr>
				        </thead>
		    		</table>
				</section>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div> <!-- .modal -->
	<div class="modal fade" id="modal_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-type="show-ticket">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Ticket</h4>
			</div>
			<div class="modal-body">
				<div class="cargando">
      				<span class="fa fa-circle-o-notch fa-spin fa-fw"></span>
      			</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button class="btn btn-success" data-action="copy" disabled="">Copiar</button>
				<button class="btn btn-success" data-action="print" disabled="">Imprimir</button>
				<button class="btn btn-success" data-action="email" disabled="" data-toggle="modal" data-target="#modal_send_email" data-url="/taquilla/ventas/sendTicketEmail">
					Email
				</button>
									<button class="btn btn-success" data-action="sms" disabled="" data-toggle="modal" data-target="#modal_send_sms" data-url="/taquilla/ventas/sendTicketSMS">
						SMS
					</button>
								<button class="btn btn-danger" data-action="anular" disabled="" data-target="#modal_anular_ticket" data-toggle="modal" data-url="/movimientos/anularTicket/0/anularAjax">
					Anular
				</button>
			</div>
		</div>
	</div>
</div> <!-- .modal -->


<div class="modal fade" id="modal_reporte_jugadas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-url="ATreportejugadas.php">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Reporte Jugadas</h4>
			</div>
			<div class="modal-body">
				<section class="reporte_jugadas">
					<div class="cargando">
	      				<span class="fa fa-circle-o-notch fa-spin fa-fw"></span>
	      			</div>
				</section>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button class="btn btn-success" data-action="print">Imprimir</button>
			</div>
		</div>
	</div>
</div> <!-- .modal -->



	<div class="modal fade" id="modal_reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-url="/taquilla/ventas/reporteGananciaPerdida/-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Ganancia y pérdida</h4>
			</div>
			<div class="modal-body">
				<section class="reporte">
					<div class="cargando">
	      				<span class="fa fa-circle-o-notch fa-spin fa-fw"></span>
	      			</div>
				</section>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button class="btn btn-success" data-action="print">Imprimir</button>
			</div>
		</div>
	</div>
</div> <!-- .modal -->
	<div class="modal fade" id="modal_resultados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Resultados</h4>
			</div>
			<div class="modal-body">
				<form name="ventas_buscar_resultados" action="https://apuestas1.us.to.com/taquilla/ventas/resultados">
					<div class="row">
						<div class="col-xs-12 col-md-5 col-lg-5">
							<div class="form-group">
								<div class="input-group">
									<input type="text" name="buscar_resultados_fecha" id="buscar_resultados_fecha" class="form-control" placeholder="Fecha">
									<span class="input-group-btn">
								        <button class="btn btn-default" type="submit">
								        	<span class="fa fa-search"></span>
								        </button>
      								</span>
								</div>
							</div>
						</div>
					</div>
				</form>
				<section class="resultados">
					<!-- -->
				</section>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div> <!-- .modal -->
	<div class="modal fade" id="modal_listado_pagos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-url="/taquilla/ventas/pagos">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Pagos pendientes</h4>
			</div>
			<div class="modal-body">
				<section class="listado_pagos">
	      			<table id="table_pagos" class="display table table-striped table-hover table-condensed DataTable" cellspacing="0" width="100%" data-order="false">
				        <thead>
				            <tr>
				                <th data-orderable="false">Nro. ticket</th>
				                <th data-orderable="false">Fecha</th>
				                <th data-orderable="false">Hora</th>
								<th data-orderable="false">Moneda</th>
				                <th data-orderable="false">Monto</th>
				                <th data-orderable="false">Email</th>
				                <th data-orderable="false">SMS</th>
				                <th data-orderable="false">Premio</th>
				                <th data-orderable="false">Acción</th>
				            </tr>
				        </thead>
		    		</table>
				</section>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div> <!-- .modal -->
	<div class="modal fade" id="modal_pagar_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-ticket="0">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Ingresar serial</h4>
			</div>
			<form name="venta_pagos_pagar_ticket" action="https://apuestas1.us.to.com/taquilla/ventas/pagos/pagarTicket">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="venta_pagos_pagar_ticket_serial">Serial</label>
								<input type="text" class="form-control" name="venta_pagos_pagar_ticket_serial" id="venta_pagos_pagar_ticket_serial" value="">
							</div>
							<input type="hidden" class="form-control" name="venta_pagos_pagar_ticket_id_ticket" id="venta_pagos_pagar_ticket_id_ticket">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="https://apuestas1.us.to.com/taquilla/ventas/#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
					<button class="btn btn-danger"><span></span> Pagar</button>
				</div>
			</form>
		</div>
	</div>
</div> <!-- .modal -->
	<div class="modal fade" id="modal_buscar_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-type="show-ticket">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Buscar ticket</h4>
			</div>
			<div class="modal-body">
				<form name="buscar_ticket" action="https://apuestas1.us.to.com/taquilla/ventas/buscarTicket">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label for="buscar_ticket_id_ticket">Número ticket</label>
				<div class="input-group">
					<input type="text" name="buscar_ticket_id_ticket" id="buscar_ticket_id_ticket" class="form-control">
					<span class="input-group-btn">
				        <button class="btn btn-default" type="submit">
				        	<span class="fa fa-search"></span>
				        </button>
    				</span>
				</div>
			</div>
		</div>
	</div>
</form>				<section class="ticket_area">
					<!-- -->
				</section>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div> <!-- .modal -->
	<div class="modal fade" id="modal_anular_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-type="show-ticket">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Anular ticket</h4>
			</div>
			<div class="modal-body">
				<form name="buscar_ticket" action="https://apuestas1.us.to.com/taquilla/ventas/buscarTicket">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label for="buscar_ticket_id_ticket">Número ticket</label>
				<div class="input-group">
					<input type="text" name="buscar_ticket_id_ticket" id="buscar_ticket_id_ticket" class="form-control">
					<span class="input-group-btn">
				        <button class="btn btn-default" type="submit">
				        	<span class="fa fa-search"></span>
				        </button>
    				</span>
				</div>
			</div>
		</div>
	</div>
</form>				<section class="ticket_area">
					<!-- -->
				</section>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button class="btn btn-danger" data-action="anular" data-target="#modal_confirmar" data-toggle="modal" data-url="/movimientos/anularTicket/0/anularAjax" data-title="Confirmar anular ticket" disabled="">
					Anular
				</button>
			</div>
		</div>
	</div>
</div> <!-- .modal -->
	<div class="modal fade" id="modal_repetir_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-url="/taquilla/ventas/repetirTicket">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Repetir ticket</h4>
			</div>
			<div class="modal-body">
				<form name="repetir_ticket_buscar" action="https://apuestas1.us.to.com/taquilla/ventas/repetirTicket">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="repetir_ticket_buscar_numero_ticket">Número ticket</label>
								<div class="input-group">
									<input type="text" name="repetir_ticket_buscar_numero_ticket" id="repetir_ticket_buscar_numero_ticket" class="form-control">
									<span class="input-group-btn">
								        <button class="btn btn-default" type="submit">
								        	<span class="fa fa-search"></span>
								        </button>
      								</span>
								</div>
							</div>
						</div>
					</div>
				</form>
				<form name="repetir_ticket_cargar" action="https://apuestas1.us.to.com/taquilla/ventas/repetirTicket">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="repetir_ticket_cargar_loterias">Loterías</label>
								<select name="repetir_ticket_cargar_loterias" id="repetir_ticket_cargar_loterias" class="form-control" data-/* PARSEADORES1 Venta_Animalitos\index.php - QUERY 11 */ select-dependent-child="&quot;sorteos&quot;" disabled="">
									<option value="">Todos</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="repetir_ticket_cargar_sorteos">Sorteos</label>
								<select name="repetir_ticket_cargar_sorteos" id="repetir_ticket_cargar_sorteos" class="form-control" disabled="">
									<option value="">Todos</option>
								</select>
							</div>
						</div>
					</div>
					<input type="hidden" name="repetir_ticket_cargar_id_ticket" id="repetir_ticket_cargar_id_ticket">
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button class="btn btn-success" data-action="cargar" disabled=""><span></span> Cargar jugada</button>
			</div>
		</div>
	</div>
</div> <!-- .modal -->
	<div class="modal fade" id="modal_confirmar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-type="ajax">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<input type="hidden" id="hidden_id">
			<input type="hidden" id="hidden_multiple">
			<input type="hidden" id="hidden_confirmar_url">
			<div class="modal-body">
				<div class="cargando">
      				<span class="fa fa-circle-o-notch fa-spin fa-fw"></span>
      			</div>
			</div>
		</div>
	</div>
</div> <!-- .modal -->	<div class="modal fade" id="modal_send_email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Enviar ticket vía email</h4>
			</div>
			<input type="hidden" id="hidden_email_id_ticket">
			<input type="hidden" id="hidden_email_url">
			<div class="modal-body">
				<div class="cargando">
      				<span class="fa fa-circle-o-notch fa-spin fa-fw"></span>
      			</div>
			</div>
		</div>
	</div>
</div> <!-- .modal -->	<div class="modal fade" id="modal_send_sms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Enviar ticket vía SMS</h4>
			</div>
			<input type="hidden" id="hidden_sms_id_ticket">
			<input type="hidden" id="hidden_sms_url">
			<div class="modal-body">
				<div class="cargando">
      				<span class="fa fa-circle-o-notch fa-spin fa-fw"></span>
      			</div>
			</div>
		</div>
	</div>
</div> <!-- .modal -->
				<!-- Modal buscador tickets -->
				

<div class="modal fade" id="modal_busqueda_global_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-type="show-ticket">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Buscar ticket</h4>
            </div>
            <div class="modal-body">                
                <form name="form_busqueda_global_ticket" action="https://apuestas1.us.to.com/admin/buscador/">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label for="buscar_ticket_id_ticket">Número ticket</label>
				<div class="input-group">
					<input type="text" name="buscar_ticket_id_ticket" autocomplete="off" id="buscar_ticket_id_ticket" class="form-control">
					<span class="input-group-btn">
				        <button class="btn btn-default" type="submit">
				        	<span class="fa fa-search"></span>
				        </button>
    				</span>
				</div>
			</div>
		</div>
	</div>
</form>
                <section class="ticket_data">
                    
                </section>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" data-target="#modal_ticket_detalles_new_format" data-action="detalles" data-toggle="modal" disabled="">Ver detalles
                </button>
                <button class="btn btn-danger" data-title="Anular ticket" data-action="anular" data-ajax="true" data-target="#modal_confirmar_global" data-toggle="modal" data-id="0" data-url="/admin/movimientos/anularTicket/0/anularAjax" disabled="">Anular
                </button>
                                <a class="btn btn-default" data-dismiss="modal">Cerrar</a>
            </div>
        </div>
    </div>
    <div class="m-overlay"></div>
</div>				<div class="modal fade" id="modal_ticket_detalles_new_format" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-type="show-ticket">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Detalles ticket</h4>
            </div>
            <div class="modal-body">
                <section class="ticket_area">
                    <!-- -->
                </section>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default" data-dismiss="modal">Cerrar</a>
            </div>
        </div>
    </div>
</div>
				<!-- Modal confirmación global -->
				<div class="modal fade" id="modal_confirmar_global" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel"></h4>
			</div>
			<input type="hidden" id="hidden_id">
			<input type="hidden" id="hidden_action">
			<input type="hidden" id="hidden_confirmar_url">
			<div class="modal-body">
				<div class="cargando">
      				<span class="fa fa-circle-o-notch fa-spin fa-fw"></span>
      			</div>
			</div>
		</div>
	</div>
</div> <!-- .modal -->
				<!-- Modal pago ticket global -->
				<div class="modal fade" id="modal_pagar_ticket_global" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Ingresar serial</h4>
			</div>
			<form name="form_pagar_ticket_global" action="https://apuestas1.us.to.com/taquilla/ventas/#">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="pagar_ticket_serial">Serial</label>
								<input type="text" class="form-control" name="pagar_ticket_serial" id="pagar_ticket_serial" value="">
							</div>
							<input type="hidden" class="form-control" name="pagar_ticket_id_ticket" id="pagar_ticket_id_ticket">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="https://apuestas1.us.to.com/taquilla/ventas/#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
					<button class="btn btn-danger"><span></span> Pagar</button>
				</div>
			</form>
		</div>
	</div>
</div> <!-- .modal -->

			</div> <!-- .container-fluid -->
		</div> <!-- .container-data -->
	</div> <!-- .container-cmfv01 -->

        			            <script type="text/javascript" src="./Venta _ Lotoriente_files/jquery-3.2.1.min.js"></script>
            <script type="text/javascript" src="./Venta _ Lotoriente_files/bootstrap.min.js"></script>
            <script type="text/javascript" src="./Venta _ Lotoriente_files/global.js"></script>
        
	<script type="text/javascript" src="./Venta _ Lotoriente_files/menu.js"></script>

	<script type="text/javascript" src="./Venta _ Lotoriente_files/extranet.js"></script>

	<script type="text/javascript" src="./Venta _ Lotoriente_files/ntf.js"></script>
	<script type="text/javascript" src="./Venta _ Lotoriente_files/jquery-hotkeys.js"></script>
	<script type="text/javascript" src="./Venta _ Lotoriente_files/moment.min.js"></script>
	<script type="text/javascript" src="./Venta _ Lotoriente_files/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="./Venta _ Lotoriente_files/datatables.min.js"></script>
	<script type="text/javascript" src="./Venta _ Lotoriente_files/jquery.mask.js"></script>
	<script type="text/javascript" src="./Venta _ Lotoriente_files/venta.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
	<script type="text/javascript">
		$(function() {
	        $('form[name="ventas_buscar_resultados"] input[name="buscar_resultados_fecha"]').datetimepicker({
	    	  	format: 'DD-MM-YYYY',
	    	   	locale: 'es'
	        });
		});
	</script>
    

</form>

<script>
            $(document).ready(function(){
				
            $('#myDropDownMoneda').change(function(){
                //Selected value
				//alert('oooo');
                var inputValue = $(this).val();
                alert("value in js "+inputValue);

                //Ajax for calling php function
                $.post('submit.php', { dropdownValue: inputValue }, function(data){
                    alert('ajax completed. Response:  '+data);
                    //do after submission operation in DOM
                });
            });
        });
        </script>


<script>
    function actualizar(opcion){
		//alert(opcion.value);
if (opcion.value == '1') {
	
console.log("Actualizando datos",opcion.value);
document.getElementById("objetoval").value='1,bs';
document.getElementById("objetoval2").value='2,bs';

document.getElementById("datamoneda1").innerHTML='1,bs';
alert('111');
//document.getElementById("moneda2").innerHTML = "BS";
//document.getElementById("seleccion-moneda").innerHTML = "BS";
}
if (opcion.value == '2') {
	alert('222');
console.log("Actualizando datos",opcion.value);
document.getElementById("objetoval").value='3,usd';
//document.getElementById("datamoneda1").data-moneda='1,usd';
//document.getElementById("moneda2").innerHTML = "usd";
//document.getElementById("seleccion-moneda").innerHTML = "usd";
}
if (opcion.value == '3') {
	alert('333');
console.log("Actualizando datos",opcion.value);
document.getElementById("objetoval").value='4,cop';
//document.getElementById("datamoneda1").data-moneda='1,usd';
//document.getElementById("moneda2").innerHTML = "usd";
//document.getElementById("seleccion-moneda").innerHTML = "usd";
    }}
</script>
</body></html>
<?php
 opcache_reset();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../../index.php"; include("../../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";
	$horaTxt=horaactual();
	$FechaTxt=fechaactualbd();
	$datetime=$FechaTxt.' '.$horaTxt;
$query_Recordset1 = sprintf("/* PARSEADORES1 Venta_Animalitos\imprimeTicket\impnew.php - QUERY 1 */ SELECT fechahora_creacion_ani5, id_solteo_ani5, id_animalito_ani5, mon_venta_ani5, ser_venta_ani5, can_ticket_ani5, id_loteria_ani5 FROM ani5_jugadas 
WHERE  fechahora_creacion_ani5 >= %s AND num_ticket_ani5 = %s AND id_usuario_ani5 = %s ORDER BY id_ticket_ani5 ASC", 
GetSQLValueString($FechaTxt.' 00:00:01', "date"), 
GetSQLValueString($_GET["num"], "int"),
GetSQLValueString($_SESSION["MM_id_usuario"], "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$apuestasindi=$row_Recordset1['mon_venta_ani5']*$totalRows_Recordset1;


$query_Recordset1111 = sprintf(
	"/* PARSEADORES1 Venta_Animalitos\imprimeTicket\impnew.php - QUERY 2 */ SELECT id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1
  FROM  ani1_loterias_y_nombres
   ORDER BY id_Loterias_y_nombres_ani1 ASC");
  $Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
  $row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
  $totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
  
  $dir = array();
  $cont = 0;
  if ($totalRows_Recordset1111>=1) {
	do {
	 $dir[$cont] = $row_Recordset1111;
	 $cont++;
	} while ($row_Recordset1111 = mysqli_fetch_assoc($Recordset1111));
  }






  $query_Recordset1111_solteos = sprintf(
	"/* PARSEADORES1 Venta_Animalitos\imprimeTicket\impnew.php - QUERY 3 */ SELECT id_solteo_ani4,
	id_Loterias_y_nombres_ani4,
	fechahora_solteo_ani4
  FROM  ani4_solteos
  WHERE 
  fechahora_solteo_ani4 >= %s 
   ORDER BY id_solteo_ani4 ASC",
		GetSQLValueString($FechaTxt.' 00:00:01', "date") );
  $Recordset1111_solteos =mysqli_query($conexionbanca, $query_Recordset1111_solteos) or die(mysqli_error($conexionbanca));
  $row_Recordset1111_solteos = mysqli_fetch_assoc($Recordset1111_solteos);
  $totalRows_Recordset1111_solteos = mysqli_num_rows($Recordset1111_solteos);
  
  $dir_solteos = array();
  $cont_solteos = 0;
  if ($totalRows_Recordset1111_solteos>=1) {
	do {
	 $dir_solteos[$cont_solteos] = $row_Recordset1111_solteos;
	 $cont_solteos++;
	} while ($row_Recordset1111_solteos = mysqli_fetch_assoc($Recordset1111_solteos));
  }






  $imp_tipo=2;


  if($imp_tipo==1){
?>
<style>
	.table-ticket {
		width: 268px;
		font-family: arial, 'courier new';
	}
	.table-ticket > thead > tr > th,
	.table-ticket > tfoot > tr > th {
		text-align: left;
		font-weight: bold;
	}
	.table-ticket > tbody > tr > th,
	.table-ticket > tbody > tr > td {
		font-weight: bold;
	}
	.divisor {
		font-size: 10px;
	}
	.padding-left {
		padding-left: 30px;
	}
</style>

	<style>
		.table-ticket {			
			font-size: 13px;
		}
	</style>


	<table class="table-ticket driver">
		<thead>
			<tr class="copy" data-copy="Agencia Prueba / Taquilla Nro. 1">
				<th>
					Agencia <?php echo $_SESSION["MM_Username"]; ?> 
				</th>
			</tr>
			<tr class="copy" data-copy="Fecha: 29-01-2023 / Hora: 09:24 am">
				<th>
					Fecha: <?php echo $FechaTxt; ?> /

					Hora:<?php
					$hora1=$row_Recordset1['fechahora_creacion_ani5'];
                    $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
                    $nuevahora1 = date('H:i:s', $nuevahora1);
                    echo horaampm($nuevahora1); ?>



				</th>
			</tr>
			<tr class="copy" data-copy="Nro. 203489 / SN: D22B">
				<th>
					Nro. <?php echo $_GET["num"]; ?> / <span>Serial: <?php echo $row_Recordset1["ser_venta_ani5"]; ?>


					</span>
				</th>
			</tr>
			<tr class="copy" data-copy="-----------------------------">
				<th class="divisor">----------------------------------------------------------------------------</th>
			</tr>
		</thead>
		<tbody>
<?php			
do{
?>
<tr class="copy" data-copy="LOTTO ACTIVO 10:00 am">
<th>
<strong>
<span>

</span>
<?php	
foreach ($dir_solteos as $clave_solteos) { 
if($clave_solteos['id_solteo_ani4']==$row_Recordset1['id_solteo_ani5']){


$clave_solteos_fechahora_solteo_ani4 = date("h:i A", strtotime($clave_solteos['fechahora_solteo_ani4']));

}
        }

		?>

</strong>
</th>
</tr>
<tr>
<td>
<span class="copy" data-copy="TOROx5" data-copy-loteria="LOTTO ACTIVO 10:00 am">
<?php



foreach ($dir as $clave) { 
	if($clave['id_Loterias_y_nombres_ani1']==$row_Recordset1['id_loteria_ani5']){ 

		echo $clave['nom_Loterias_y_nombres_ani1'].' -- '; 

	$claveexp=explode(',', $clave['animales_Loterias_y_nombres_ani1']);


	foreach ($claveexp as $claveexp2) { 
	$claveexp3=explode('.', $claveexp2);
	if($claveexp3[0]==$row_Recordset1['id_animalito_ani5']){  
		



		echo $claveexp3[2].' --d '; 

		
	}}


}

	}
	echo $clave_solteos_fechahora_solteo_ani4.' -- ';
?>

</span>
<?php

echo 'x'.$row_Recordset1['mon_venta_ani5'];
?>
</td>
</tr>
<?php
if($row_Recordset1["mon_venta_ani5"]>0)	{ $mon_venta_ani5=$row_Recordset1["mon_venta_ani5"];}																
?>
							
<?php
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));														
?>
						
						
						</tbody>
		<tfoot>
			<tr class="copy" data-copy="-----------------------------">
				<th class="divisor">----------------------------------------------------------------------------</th>
			</tr>
			<tr class="copy" data-copy="Apuesta Bs 20,00">
				<th>Apuesta Bs <?php echo $apuestasindi; ?></th>
			</tr>
			<tr class="copy" data-copy="REVISE SU TICKET">
				<th>REVISE SU TICKET</th>
			</tr>
							<tr class="copy" data-copy="CADUCA A LOS 3 DIAS">
					<th>CADUCA A LOS 3 DIAS</th>
				</tr>
										<tr class="copy" data-copy="GRACIAS">
					<th>GRACIAS</th>
				</tr>
										<tr class="copy" data-copy=".">
					<th>.</th>
				</tr>
								</tfoot>
	</table>

	<?php
}














if($imp_tipo==2){ ?>

<style type="text/css" media="print">
#Imprime {
	height: auto;
	width: 0px;
	margin: 0px;
	padding: 0px;
	float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 30px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	color: #000;
}
@page{
   margin: 20;
}
.card{
   font-family: Arial, Helvetica, sans-serif;
}

</style>

<div class="card">
    <div class="card-body">
        
		Nro. <?php echo $_GET["num"]; ?> / <span>Serial: <?php echo $row_Recordset1["ser_venta_ani5"]; ?>
<br/>
        Fecha: <?php echo $FechaTxt; ?>
		</br>

Hora:<?php
					$hora1=$row_Recordset1['fechahora_creacion_ani5'];
                    $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
                    $nuevahora1 = date('H:i:s', $nuevahora1);
                    echo horaampm($nuevahora1); ?><br/>
         Taquilla: <?php echo $_SESSION["MM_Username"]; ?><br/>







</div>


          




	
<?php
 $premio=0;
do { ?>



<?php	
foreach ($dir_solteos as $clave_solteos) { 
if($clave_solteos['id_solteo_ani4']==$row_Recordset1['id_solteo_ani5']){


$clave_solteos_fechahora_solteo_ani4 = date("h:i A", strtotime($clave_solteos['fechahora_solteo_ani4']));

}
        }

		?>






	
<?php



foreach ($dir as $clave) { 
	if($clave['id_Loterias_y_nombres_ani1']==$row_Recordset1['id_loteria_ani5']){ 
		?>

<div class="card-body"><?php echo $clave['nom_Loterias_y_nombres_ani1'].' -- '; ?></div>

		
		<?php
	$claveexp=explode(',', $clave['animales_Loterias_y_nombres_ani1']);


	foreach ($claveexp as $claveexp2) { 
	$claveexp3=explode('.', $claveexp2);
	if($claveexp3[0]==$row_Recordset1['id_animalito_ani5']){  
		
		?>
 <div class="card-body"><?php echo $claveexp3[2].' --d '; 
		?></div>

		
		<?php
		
	}}


}

	}
	?>

	<div class="card-body"><?php echo $clave_solteos_fechahora_solteo_ani4.' -- '; ?></div>

	



	<div class="card-body"><?php echo 'x'.$row_Recordset1['mon_venta_ani5']; ?></div>



<?php
if($row_Recordset1["mon_venta_ani5"]>0)	{ $mon_venta_ani5=$row_Recordset1["mon_venta_ani5"];}																
?>

<?php
   

 


} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));


?>






 <?php // echo number_format($apuestasindi, 2, '.', ''); 
 ?>

<div class="card-body">.</td></div>		  
     	  
    





</div>

</body>
</html>


	<?php
} ?>
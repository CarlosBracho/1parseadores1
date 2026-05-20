<?php
 

if (!isset($_SESSION)) {
    session_start();
} require_once('../../Connections/conexionbanca.php');


$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../../index.php"; include("../../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";
	$horaTxt=horaactual();
	$FechaTxt=fechaactualbd();
	$datetime=$FechaTxt.' '.$horaTxt;

	if (isset($_GET["reimpresion"])) {
		$query_Recordset122 = sprintf("/* PARSEADORES1 Venta_Animalitos\imprimeTicket\imp.php - QUERY 1 */ SELECT * FROM ani5_jugadas 
		WHERE  fechahora_creacion_ani5 >= %s AND id_usuario_ani5 = %s ORDER BY id_ticket_ani5 DESC LIMIT 1", 
		GetSQLValueString($FechaTxt.' 00:00:01', "date"), 
		GetSQLValueString($_SESSION["MM_id_usuario"], "int"));
		$Recordset122 = mysqli_query($conexionbanca, $query_Recordset122) or die(mysqli_error($conexionbanca));
		$row_Recordset122 = mysqli_fetch_assoc($Recordset122);
		$totalRows_Recordset122 = mysqli_num_rows($Recordset122);


		$query_Recordset1 = sprintf("/* PARSEADORES1 Venta_Animalitos\imprimeTicket\imp.php - QUERY 2 */ SELECT * FROM ani5_jugadas 
		WHERE  fechahora_creacion_ani5 >= %s AND num_ticket_ani5 = %s AND id_usuario_ani5 = %s ORDER BY id_ticket_ani5 ASC", 
		GetSQLValueString($FechaTxt.' 00:00:01', "date"), 
		GetSQLValueString($row_Recordset122['num_ticket_ani5'], "int"),
		GetSQLValueString($_SESSION["MM_id_usuario"], "int"));
		$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
		$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
		$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


	}else{




$query_Recordset1 = sprintf("/* PARSEADORES1 Venta_Animalitos\imprimeTicket\imp.php - QUERY 3 */ SELECT * FROM ani5_jugadas 
WHERE  fechahora_creacion_ani5 >= %s AND num_ticket_ani5 = %s AND id_usuario_ani5 = %s ORDER BY id_ticket_ani5 ASC", 
GetSQLValueString($FechaTxt.' 00:00:01', "date"), 
GetSQLValueString($_GET["num"], "int"),
GetSQLValueString($_SESSION["MM_id_usuario"], "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
}
$apuestasindi=0;

$query_Recordset1111 = sprintf(
	"/* PARSEADORES1 Venta_Animalitos\imprimeTicket\imp.php - QUERY 4 */ SELECT id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1
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
	"/* PARSEADORES1 Venta_Animalitos\imprimeTicket\imp.php - QUERY 5 */ SELECT id_solteo_ani4,
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


  $query_Recordset4 =  sprintf(
	"/* PARSEADORES1 Venta_Animalitos\imprimeTicket\imp.php - QUERY 6 */ SELECT tp.tic_caduca, tp.coletilla_ani, tp.config_varias, tp.largoticketani FROM  taquilla ta, taquilla_opc_ani tp, usuario us 
	WHERE us.id_usuario = %s AND ta.cod_taquilla = us.cod_taquilla AND tp.cod_taquilla = ta.cod_taquilla
	LIMIT 1",
	GetSQLValueString($_SESSION["MM_id_usuario"], "int")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$tic_caduca=$row_Recordset4['tic_caduca'];
$coletilla_ani=$row_Recordset4['coletilla_ani'];
$configuracion=$row_Recordset4['config_varias'];
$largo=$row_Recordset4['largoticketani'];
?>
<style>
	.table-ticket {
		width: 268px;
		
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
	.espacio{
    font-size: 5px;
    height: 30px;
}
</style>
<?php $configuracion = explode("*", $configuracion);
 foreach ($configuracion as $configuracion2){
  $configuracion2 = explode(",,,", $configuracion2);
  if($configuracion2['3']==1){     ?>
	<style>
		.table-ticket {			
			font-size:<?php echo $configuracion2['1'].'px' ?>;
    font-style:<?php echo $configuracion2['2'] ?>;
		}
	</style>
<?php }else{ ?>
	<style>
		.table-ticket {			
			font-family: arial, 'courier new';
			font-size: 13px;
		}
	</style>
	
	<?php
}} ?>
	<table class="table-ticket driver">
		<thead>
			<tr class="copy" data-copy="Agencia Prueba / Taquilla Nro. 1">
				<th>
					Taquilla <?php echo $_SESSION["MM_Username"]; ?> 
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
					Nro. <?php echo $row_Recordset1['num_ticket_ani5']; ?> / <span>Serial: <?php echo $row_Recordset1["ser_venta_ani5"]; ?>


					</span>
				</th>
			</tr>
			<tr class="copy" data-copy="-----------------------------">
				<th class="divisor">--------------------------------</th>
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
		



		echo $claveexp3[2].' -- '; 

		
	}}


}

	}
	echo $clave_solteos_fechahora_solteo_ani4.' -- ';
?>

</span>
<?php
$apuestasindi=$apuestasindi+$row_Recordset1['mon_venta_ani5'];
echo 'x'.$row_Recordset1['mon_venta_ani5'];
?>
</td>
</tr>
<?php
if($row_Recordset1["mon_venta_ani5"]>0)	{ $mon_venta_ani5=$row_Recordset1["mon_venta_ani5"];}																
?>
							
<?php
				          if ($row_Recordset1['moneda_ani5']==0) {$moneda_ani5=' BSS';}
						  if ($row_Recordset1['moneda_ani5']==1) {$moneda_ani5=' BSS';}
						  if ($row_Recordset1['moneda_ani5']==2) {$moneda_ani5=' BSS';}
						  if ($row_Recordset1['moneda_ani5']==3) {$moneda_ani5=' USD';}
						  if ($row_Recordset1['moneda_ani5']==4) {$moneda_ani5=' COP';}
						  if ($row_Recordset1['moneda_ani5']==5) {$moneda_ani5=' SOL';}

} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));														
?>
						
						
						</tbody>
		<tfoot>
			<tr class="copy" data-copy="-----------------------------">
				<th class="divisor">----------------------------------------------------------------------------</th>
			</tr>
			<tr class="copy" data-copy="Apuesta Bs 20,00">
				<th>Apuesta <?php echo $apuestasindi.$moneda_ani5; 
 
					
				
				?></th>
			</tr>
			<?php if (isset($_GET["reimpresion"])) { ?>
			<tr class="copy" data-copy="REVISE SU TICKET">
				<th>COPIA</th>
			</tr>
			<?php } ?>
			<?php
 
 if($coletilla_ani<>''){
 $coletilla_ani = explode("*", $coletilla_ani);
 foreach ($coletilla_ani as $coletilla_ani2){ 
   $coletilla_ani2 = explode(",,,", $coletilla_ani2);

   if($coletilla_ani2[0]=='D'){ if(strlen($coletilla_ani2[1])>2 || strlen($coletilla_ani2[2])>2){
	 if(strlen($coletilla_ani2[1])>2){$apto=1;}else{$apto=0;} if(strlen($coletilla_ani2[2])>2){$apto2=1;}else{$apto2=0;}
	 
	 if($apto==1){$cole=$coletilla_ani2[1];} if($apto2==1){$cole2=$coletilla_ani2[2];}
	   ?>
	 <tr ><th colspan="5" align="left"><?php echo $cole;  ?></th></tr>
	 <?php ?>
	 <tr ><th colspan="5" align="left"><?php echo $cole2; ?></th></tr>
	 <?php ?>  
	 <?php }else{$D=1;}}

if($coletilla_ani2[0]=='A' && $D==1){ if(strlen($coletilla_ani2[1])>2 || strlen($coletilla_ani2[2])>2){
if(strlen($coletilla_ani2[1])>2){$apto=1;}else{$apto=0;} if(strlen($coletilla_ani2[2])>2){$apto2=1;}else{$apto2=0;}

if($apto==1){$cole=$coletilla_ani2[1];} if($apto2==1){$cole2=$coletilla_ani2[2];}
?>
<tr ><th colspan="5" align="left"><?php echo $cole;  ?></th></tr>
<?php ?>
<tr ><th colspan="5" align="left"><?php echo $cole2; ?></th></tr>
<?php ?>  
<?php }else{$A=1;}}

if($coletilla_ani2[0]=='U' && $A==1){ if(strlen($coletilla_ani2[1])>2 || strlen($coletilla_ani2[2])>2){
 if(strlen($coletilla_ani2[1])>2){$apto=1;}else{$apto=0;} if(strlen($coletilla_ani2[2])>2){$apto2=1;}else{$apto2=0;}

 if($apto==1){$cole=$coletilla_ani2[1];} if($apto2==1){$cole2=$coletilla_ani2[2];}
   ?>
 <tr ><th colspan="5" align="left"><?php echo $cole;  ?></th></tr>
 <?php ?>
 <tr ><th colspan="5" align="left"><?php echo $cole2; ?></th></tr>
 <?php ?>  
 <?php }}



}}?>
			
<?php if ($tic_caduca>0) { ?>
			<tr class="copy" data-copy="REVISE SU TICKET">
				<th>REVISE SU TICKET</th>
			</tr>
							<tr class="copy" data-copy="CADUCA A LOS 3 DIAS">
					<th>CADUCA A LOS <?php echo $tic_caduca ?> DIAS</th>
				</tr>
										<tr class="copy" data-copy="GRACIAS">
					<th>GRACIAS</th>
				</tr>
								
				<?php } ?>
				<?php for ($i = 0; $i < $largo; ++$i) {?><tr><td class="espacio" colspan="4" align="left">.</td></tr><?php } ?>
   <tr><td colspan="4" align="left">.</td></tr>		
								</tfoot>
	</table>
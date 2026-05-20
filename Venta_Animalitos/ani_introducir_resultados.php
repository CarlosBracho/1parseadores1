<?php
  //opcache_reset();
  echo 'opcache_reset<br>';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
setlocale(LC_ALL, "es_ES");


if (isset($_GET['idsol'])) {
  ////////////////////////////////////////////////////inicia si hay get lo de guardar los resultados
  echo 'gggggggggggggggg<br>';
// $_GET['idsol'];
// $_GET['idani'];
// $_GET['fecha'];
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;

$query_Recordset1_solteos_resultados = sprintf(
"/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 1 */ SELECT id_resultado_ani6
FROM  ani6_resultados
WHERE 
id_solteo_ani6 = %s  AND
fechahora_resultado_ani6 >= %s AND fechahora_resultado_ani6 <= %s
 ORDER BY id_resultado_ani6  DESC LIMIT 1",
GetSQLValueString($_GET['idsol'], "int"),
GetSQLValueString($_GET['fecha'].' 00:00:01', "date"), 
GetSQLValueString($_GET['fecha'].' 23:59:59', "date") );
$Recordset1_solteos_resultados =mysqli_query($conexionbanca, $query_Recordset1_solteos_resultados) or die(mysqli_error($conexionbanca));
$row_Recordset1_solteos_resultados = mysqli_fetch_assoc($Recordset1_solteos_resultados);
$totalRows_Recordset1_solteos_resultados = mysqli_num_rows($Recordset1_solteos_resultados);
if($totalRows_Recordset1_solteos_resultados==0){
  echo 'totalRows_Recordset1_solteos_resultados  '.$totalRows_Recordset1_solteos_resultados.'<br>';

  $insertSQL155 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 2 */ INSERT INTO ani6_resultados 
(id_solteo_ani6, resultado_ani6, fechahora_resultado_ani6)
VALUES (%s, %s, %s)",
GetSQLValueString($_GET['idsol'], "int"),
GetSQLValueString($_GET['idani'], "int"),
GetSQLValueString($_GET['fecha'].' '.$horaTxt, "date"));

  $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));


}else{
  $insertSQL1monto_total = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 3 */ UPDATE ani6_resultados
      SET
      resultado_ani6=%s,
      fechahora_resultado_ani6=%s
      WHERE 
      id_resultado_ani6=%s",
  GetSQLValueString($_GET['idani'], "int"), 
  GetSQLValueString($_GET['fecha'].' 23:59:59', "date"),
  GetSQLValueString($row_Recordset1_solteos_resultados['id_resultado_ani6'], "int")
  );
  
  $Result1monto_total = mysqli_query($conexionbanca, $insertSQL1monto_total) or die(mysqli_error($conexionbanca));


}





//////////////////////// aqui inicia el proceso de procesar las jugadas es un proceso dentro de guardar los resultados

$id_solteo =$_GET['idsol'];
$resultado =$_GET['idani'];



   
    $query_Recordset1_3331_ = sprintf(
  "/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 4 */ SELECT ani5_jugadas.id_ticket_ani5, ani5_jugadas.num_ticket_ani5, ani5_jugadas.id_animalito_ani5, ani5_jugadas.mon_venta_ani5, 
  ani1_loterias_y_nombres.multiplooficial_ani1, ani1_loterias_y_nombres.id_Loterias_y_nombres_ani1, ani5_jugadas.cod_taquilla_ani5
  FROM ani5_jugadas, ani1_loterias_y_nombres
  WHERE
  ani5_jugadas.estado_ticket_ani5 < 4 AND
  ani5_jugadas.id_solteo_ani5 = %s   AND
  ani5_jugadas.id_loteria_ani5 = ani1_loterias_y_nombres.id_Loterias_y_nombres_ani1
  ORDER BY ani5_jugadas.id_ticket_ani5 DESC", 
  GetSQLValueString($id_solteo, "int"));
  $Recordset1_3331_ = mysqli_query($conexionbanca, $query_Recordset1_3331_) or die(mysqli_error($conexionbanca));
  $row_Recordset1_3331_ = mysqli_fetch_assoc($Recordset1_3331_);
  $totalRows_Recordset1_3331_ = mysqli_num_rows($Recordset1_3331_);
  if($totalRows_Recordset1_3331_>0){
do{


$estadojugada_ani5=0;
if($resultado==$row_Recordset1_3331_['id_animalito_ani5']){$estadojugada_ani5=1;  
  $query_Recordset1_ani3 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 5 */ SELECT 
*
    FROM 
	 taquilla_opc_ani
	WHERE taquilla_opc_ani.cod_taquilla=%s 
 LIMIT 1",
		   GetSQLValueString($row_Recordset1_3331_['cod_taquilla_ani5'], "date")
		   );
    $Recordset1_ani3 = mysqli_query($conexionbanca, $query_Recordset1_ani3) or die(mysqli_error($conexionbanca));
    $row_Recordset1_ani3 = mysqli_fetch_assoc($Recordset1_ani3);
    $totalRows_Recordset1_ani3 = mysqli_num_rows($Recordset1_ani3);
//echo $totalRows_Recordset1_ani3;
//echo $row_Recordset1_ani3["varios_x_loteria"].'<br>';
$varios_x_loteria = explode("-", $row_Recordset1_ani3["varios_x_loteria"]);

$varios_x_loteria2 = explode(",", $varios_x_loteria[$row_Recordset1_3331_["id_Loterias_y_nombres_ani1"]]);
$guacharo=0;
if($row_Recordset1_3331_["id_Loterias_y_nombres_ani1"]==9 && $row_Recordset1_3331_['id_animalito_ani5']==77 && $estadojugada_ani5==1){

  $guacharo=1;
}


  echo $varios_x_loteria2[2].' varios_x_loteria2';
if($varios_x_loteria2[2]==0){

  if($guacharo==1){$Special=$row_Recordset1_3331_['multiplooficial_ani1']*2;
  
$mon_pago_ani5=$row_Recordset1_3331_['mon_venta_ani5']*$Special; 
}else{

  $mon_pago_ani5=$row_Recordset1_3331_['mon_venta_ani5']*$row_Recordset1_3331_['multiplooficial_ani1']; 
}


}else{

  if($guacharo==1){$Special=$varios_x_loteria2[2]*2;
  
    $mon_pago_ani5=$row_Recordset1_3331_['mon_venta_ani5']*$Special; 
    }else{
    
      $mon_pago_ani5=$row_Recordset1_3331_['mon_venta_ani5']*$varios_x_loteria2[2];  
    }

}

}else{$estadojugada_ani5=2;   $mon_pago_ani5=0; }

    $insertSQL1_jugada_update = sprintf(
        "/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 6 */ UPDATE ani5_jugadas
            SET
            mon_pago_ani5=%s,
            estadojugada_ani5=%s
            WHERE 
            id_ticket_ani5=%s",
    GetSQLValueString($mon_pago_ani5, "double"),
    GetSQLValueString($estadojugada_ani5, "int"),
    GetSQLValueString($row_Recordset1_3331_['id_ticket_ani5'], "int"));
    
    $Result1_jugada_update = mysqli_query($conexionbanca, $insertSQL1_jugada_update) or die(mysqli_error($conexionbanca));
/*
if($estadojugada_ani5==1){
  $query_Recordset1_555_ = sprintf(
    "SELECT id_ticket_ani5, num_ticket_ani5, id_animalito_ani5, mon_venta_ani5
FROM ani5_jugadas
WHERE
estado_ticket_ani5 < 4 AND
num_ticket_ani5 = %s  ORDER BY id_ticket_ani5 DESC",
   
    GetSQLValueString($id_solteo, "int"));
$Recordset1_555_ = mysqli_query($conexionbanca, $query_Recordset1_555_) or die(mysqli_error($conexionbanca));
$row_Recordset1_555_ = mysqli_fetch_assoc($Recordset1_555_);
$totalRows_Recordset1_555_ = mysqli_num_rows($Recordset1_555_);



}
*/







echo 'id_ticket_ani5='.$row_Recordset1_3331_['id_ticket_ani5'].' '.'id_animalito_ani5='.$row_Recordset1_3331_['id_animalito_ani5'];










} while ($row_Recordset1_3331_ = mysqli_fetch_assoc($Recordset1_3331_));
}
 

//////////////////////// aqui termina el proceso de procesar las jugadas es un proceso dentro de guardar los resultados


















////////////////////////////////////////////////////termina si hay get lo de guardar los resultados
} else{
////////////////////////////////////////////////////inicia muestra la lista de solteos con o sin resultados se pueden agregar o modificar



$iniciof=fechaactualbd();
$finalf=fechaactualbd();


if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction = "" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['fecha_inicio'])) {

    $iniciof=$_POST['fecha_inicio'];
     $finalf=$_POST['fecha_inicio'];

}
if(isset($_POST['Div'])){

  $div=$_POST['Div'];
}else{

  $div=0;
}

echo 2*2;
$query_Recordset1111 = sprintf(
  "/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 7 */ SELECT id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1
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

//$dir=json_encode($dir);
//print_r($dir);
//var_dump($dir);


$query_Recordset1111_solteos = sprintf(
  "/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 8 */ SELECT id_solteo_ani4,
  id_Loterias_y_nombres_ani4,
  fechahora_solteo_ani4
FROM  ani4_solteos
WHERE 
fechahora_solteo_ani4 >= %s AND fechahora_solteo_ani4 <= %s
ORDER BY id_solteo_ani4 ASC",
GetSQLValueString($iniciof.' 00:00:01', "date"), GetSQLValueString($finalf.' 23:59:59', "date") );
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


//print_r($dir_solteos);

if($div==0){

$query_Recordset13 = sprintf(
"/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 9 */ SELECT *
FROM ani4_solteos
WHERE
fechahora_solteo_ani4 >= %s AND fechahora_solteo_ani4 <= %s  ORDER BY id_solteo_ani4 ASC",
GetSQLValueString($iniciof.' 00:00:01', "date"), GetSQLValueString($finalf.' 23:59:59', "date") );
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);
echo $totalRows_Recordset13.' ------------------- '.$iniciof.'-------------------'.$finalf;

}elseif($div>0){

  $query_Recordset13 = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 10 */ SELECT *
    FROM ani4_solteos
    WHERE
    fechahora_solteo_ani4 >= %s AND fechahora_solteo_ani4 <= %s AND id_Loterias_y_nombres_ani4 = %s ORDER BY id_solteo_ani4 ASC",
    GetSQLValueString($iniciof.' 00:00:01', "date"), GetSQLValueString($finalf.' 23:59:59', "date"), GetSQLValueString($div, "int"));
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    echo $totalRows_Recordset13.' ------------------- '.$iniciof.'-------------------'.$finalf;

}





    



?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>.:Apuestas:.</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrapBootswatchv4.5.2.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/datepicked.gijgo1.9.13.min.js" type="text/javascript"></script>
<link href="../css/datepicked.gijgo1.9.13.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
<header> 
  <!-- Fixed navbar -->
  
</header>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off" onsubmit="return chequearEnvio();">

<input name="fecha_inicio" id="datepicker" width="276" value="<?php echo htmlentities($iniciof, ENT_COMPAT, 'utf-8'); ?>" />
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            dateFormat: 'yyyy-mm-dd'
        });
    </script>

<select name="Div" id="soflow" style="height:40px; width:280px; margin:-9px 0px 0px 0px ">
                      <option value="0" >TODOS</option>
                      <?php
                foreach ($dir as $clave) { 
                   

                    ?>
               <option value="<?php echo $clave['id_Loterias_y_nombres_ani1']?>"
               <?php if (($clave['id_Loterias_y_nombres_ani1'])==$div) {
                        echo "SELECTED";
                    } ?>>
							 <?php echo strtoupper($clave['nom_Loterias_y_nombres_ani1']); ?>
               </option>
                      <?php
                }
                ?>
                
                    </select>


                    <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/>



                 
</form>  
<!-- Begin page content -->

<div class="container">
  <hr>
  <div class="row">
    <div class="col-12 col-md-12  table-responsive "> 
      <!-- Contenido -->
      
      <table class="table">
        <thead class="thead-dark">
          <tr>

            <th scope="col">Loteria</th>
            <th scope="col">Sorteo</th>
            <th scope="col">Resultado</th>
            <th scope="col">Eiminar Resultados</th>
            

          </tr>
        </thead>
        <tbody>
          <?php
if ($totalRows_Recordset13>=1) {
  $selectenum=1;
    do {
        ?>
<tr>
<td>
<?php
$query_Recordset1_resultado = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 11 */ SELECT *
    FROM ani6_resultados
    WHERE  id_solteo_ani6 = %s AND
    fechahora_resultado_ani6 >= %s AND fechahora_resultado_ani6 <= %s    ORDER BY id_resultado_ani6 DESC",
    GetSQLValueString($row_Recordset13['id_solteo_ani4'], "int"),
    GetSQLValueString($iniciof.' 00:00:01', "date"), GetSQLValueString($finalf.' 23:59:59', "date") );
    $Recordset1_resultado = mysqli_query($conexionbanca, $query_Recordset1_resultado) or die(mysqli_error($conexionbanca));
    $row_Recordset1_resultado = mysqli_fetch_assoc($Recordset1_resultado);
    $totalRows_Recordset1_resultado = mysqli_num_rows($Recordset1_resultado);


foreach ($dir as $clave) { 
if($clave['id_Loterias_y_nombres_ani1']==$row_Recordset13['id_Loterias_y_nombres_ani4']){ echo $clave['nom_Loterias_y_nombres_ani1']; 
    $claveexp=explode(',', $clave['animales_Loterias_y_nombres_ani1']);
    if($totalRows_Recordset1_resultado==1){
    foreach ($claveexp as $claveexp2) { 
    $claveexp3=explode('.', $claveexp2);
    if($claveexp3[0]==$row_Recordset1_resultado['resultado_ani6']){  $animalitoganador=$claveexp3[2].' -- ';  }}}
}
}


?>
</td>
<td>
<?php
$idsolteoenuso=0;
foreach ($dir_solteos as $clave_solteos) { 
if($clave_solteos['id_solteo_ani4']==$row_Recordset13['id_solteo_ani4']){
  $idsolteoenuso=$row_Recordset13['id_solteo_ani4'];
echo $idsolteoenuso.'  ';
$clave_solteos_fechahora_solteo_ani4 = date("h:i A", strtotime($clave_solteos['fechahora_solteo_ani4']));
echo $clave_solteos_fechahora_solteo_ani4;
}


        }

        ?>

</td>
<td>


<select id="Resultado_selecionado<?php echo $selectenum; ?>" class="form-control input-sm form-/* PARSEADORES1 Venta_Animalitos\ani_introducir_resultados.php - QUERY 12 */ select" title="Animalitos">

<option 
      value="7777" 

      data-nombre="SELECIONE" 
  

      
     >SELECIONE SELECIONE SELECIONE SELECIONE
			</option>

<?php		
foreach ($dir as $clave) { 
  if($clave['id_Loterias_y_nombres_ani1']==$row_Recordset13['id_Loterias_y_nombres_ani4']){ //echo $clave['nom_Loterias_y_nombres_ani1']; 
      $claveexp=explode(',', $clave['animales_Loterias_y_nombres_ani1']);

      foreach ($claveexp as $claveexp2) { 
      $claveexp3=explode('.', $claveexp2);





       $animalitoganador=$claveexp3[2].' -- '; 
       //aqui se prudicra el select
       ?>
      


      <option 
      value="<?php  echo $claveexp3[0];  ?>" 
      data-url="ani_introducir_resultados.php?idsol=<?php echo $idsolteoenuso; ?>&idani=<?php  echo $claveexp3[0];  ?>&fecha=<?php  echo $iniciof;  ?>" 
      data-nombre="<?php  echo $claveexp3[0];  ?>" 
      <?php  
      if($claveexp3[0]==$row_Recordset1_resultado['resultado_ani6']){  $animalitoganador=$claveexp3[2].' -- '; ?> selected="selected" <?php 
        //$idsolteoenuso=0;
      } ?>
      
      
     >
			<?php  echo $claveexp3[2].'-'.$claveexp3[1];  ?>
			</option>
      <?php


      
      }
  }
  }
  ?>
  </select>

  <td>
<?php
$idsolteoenuso=0;
foreach ($dir_solteos as $clave_solteos) { 
if($clave_solteos['id_solteo_ani4']==$row_Recordset13['id_solteo_ani4']){
  $idsolteoenuso=$row_Recordset13['id_solteo_ani4'];

  if($totalRows_Recordset1_resultado>0){
//echo $idsolteoenuso.'  ';
?>
<center><input type="submit" value="BORRAR RESULTADO" class="btn-danger" title="CONFIRME QUE TODO ESTA CORRECTO" 
          data-toggle="modal" data-target="#exampleModal" title="" 
onclick="detalle_ticket(<?php echo $idsolteoenuso; ?>, 0, 2); return false"   /></center>
<?php
}
}


        }

        ?>

</td>
  <script>
	$(function() {
		$('#Resultado_selecionado<?php echo $selectenum; ?>').on('change', function(event) {
      //alert('fffffffffffffffffffff');
			var $option_seleced = $(this).children(':selected');
			var loteria = {'nombre': $option_seleced.data('nombre'), 'id': $option_seleced.val()};
			var url = $option_seleced.data('url');
			updateListadoAnimalitosAndSorteos<?php echo $selectenum; ?>(url, loteria);
		});
	});

  function updateListadoAnimalitosAndSorteos<?php echo $selectenum; ?>(url, loteria) {
		$.ajax({
			dataType: 'JSON',
			type: 'GET',
			url: url,
			beforeSend: function() {
				$('.dashboard-data').addClass('cargando-full-screen');
			},
			success: function(response) {
			},
			error: function() {
				showMessage('danger', AJAX_ERROR_INESPERADO);
			}
		});
	}

  function detalle_ticket(nticket, jtipo, modulo){
        $.post("../Venta_Animalitos/eliminar_resul_ani.php", 
        {
		nticket:nticket,
		jtipo:jtipo,
		modulo:modulo
		},
        function(eData){				
            $("#dialog-message").html(eData);
        });	
    }

  </script>





  <?php







?>
</td>

</tr>
<?php
$selectenum++;
} while ($row_Recordset13 = mysqli_fetch_assoc($Recordset13));
}
?>

        </tbody>
      </table>
      
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 
  
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="dialog-message"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>
<?php
} ////////////////////////////////////////////////////termina muestra la lista de solteos con o sin resultados se pueden agregar o modificar
?>


















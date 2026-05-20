<?php
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
setlocale(LC_ALL, "es_ES");

if (isset($_GET['idsol'])) {
  ////////////////////////////////////////////////////inicia  si hay get editar estado de solteo
  echo 'gggggggggggggggg<br>';
// $_GET['idsol'];
// $_GET['idani'];
// $_GET['fecha'];
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;

$insertSQL1monto_total = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\listar_solteos_y_editar.php - QUERY 1 */ UPDATE ani4_solteos
      SET
      estado_ani4=%s
      WHERE 
      id_solteo_ani4=%s",
  GetSQLValueString($_GET['estado_ani4'], "int"), 
  GetSQLValueString($_GET['idsol'], "int")
  );
  
  $Result1monto_total = mysqli_query($conexionbanca, $insertSQL1monto_total) or die(mysqli_error($conexionbanca));






 

//////////////////////// aqui termina el proceso de editar estado solteo


















////////////////////////////////////////////////////termina si hay get editar estado de solteo
} else{
////////////////////////////////////////////////////inicia muestra la lista de solteos del dia



$iniciof=fechaactualbd();
$finalf=fechaactualbd();


if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction = "" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['fecha_inicio'])) {

    $iniciof=$_POST['fecha_inicio'];
     $finalf=$_POST['fecha_inicio'];

}


$query_Recordset1111 = sprintf(
  "/* PARSEADORES1 Venta_Animalitos\listar_solteos_y_editar.php - QUERY 2 */ SELECT id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1
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
  "/* PARSEADORES1 Venta_Animalitos\listar_solteos_y_editar.php - QUERY 3 */ SELECT id_solteo_ani4,
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





$query_Recordset13 = sprintf(
"/* PARSEADORES1 Venta_Animalitos\listar_solteos_y_editar.php - QUERY 4 */ SELECT *
FROM ani4_solteos
WHERE
fechahora_solteo_ani4 >= %s AND fechahora_solteo_ani4 <= %s  ORDER BY id_solteo_ani4 DESC",
GetSQLValueString($iniciof.' 00:00:01', "date"), GetSQLValueString($finalf.' 23:59:59', "date") );
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);
echo $totalRows_Recordset13.' ------------------- '.$iniciof.'-------------------'.$finalf;







    



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
            <th scope="col">Solteo</th>
            <th scope="col">Resultado</th>
            

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
    "/* PARSEADORES1 Venta_Animalitos\listar_solteos_y_editar.php - QUERY 5 */ SELECT *
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



	




<select id="id_solteo_ani4<?php echo $selectenum; ?>" style="width:140px; height: auto" class="textbox" tabindex="4"> 
<option value="0" 
data-url="listar_solteos_y_editar.php?idsol=<?php echo $idsolteoenuso; ?>&estado_ani4=0&fecha=<?php  echo $iniciof;  ?>"
<?php if (!(strcmp(0, htmlentities($row_Recordset13['estado_ani4'], ENT_COMPAT, 'utf-8')))) {
echo "SELECTED";
} ?>>ACTIVO</option>
<option value="1"
data-url="listar_solteos_y_editar.php?idsol=<?php echo $idsolteoenuso; ?>&estado_ani4=1&fecha=<?php  echo $iniciof;  ?>"
<?php if (!(strcmp(1, htmlentities($row_Recordset13['estado_ani4'], ENT_COMPAT, 'utf-8')))) {
echo "SELECTED";
} ?>>INACTIVO</option>

</select>

<?php	


















  ?>
  </select>
  <script>
	$(function() {
		$('#id_solteo_ani4<?php echo $selectenum; ?>').on('change', function(event) {
      
			var $option_seleced = $(this).children(':selected');
			var url = $option_seleced.data('url');
           // alert(url);
			updateListadoAnimalitosAndSorteos<?php echo $selectenum; ?>(url);
		});
	});

  function updateListadoAnimalitosAndSorteos<?php echo $selectenum; ?>(url) {
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




<!-- Fin container -->


<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.js"></script>
</body>
</html>
<?php
} ////////////////////////////////////////////////////termina  muestra la lista de solteos del dia
?>


















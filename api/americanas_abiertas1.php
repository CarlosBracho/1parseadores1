<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
//include ("file.php");

require_once('../Connections/conexionbanca.php');
$horasistema=horaactual();
$fechasistema=fechaactualbd();




$query_RecordsetAE =  sprintf("/* PARSEADORES1 api\americanas_abiertas1.php - QUERY 1 */ SELECT carrera.nom_hipodromo, carrera.num_carrera, carrera.hor_carrera 
FROM carrera 
WHERE carrera.fec_carrera = %s AND carrera.hor_carrera >= %s AND carrera.est_carrera = 1 
ORDER BY carrera.hor_mtp", 
GetSQLValueString($fechasistema, "date"), 
GetSQLValueString($horasistema, "date"));



if ($resultAE = mysqli_query($conexionbanca, $query_RecordsetAE) or die(mysqli_error($conexionbanca))) {

$ArrayCarrerasAbiertas['FechaHoraCreacion'][]['FechaHoraCreacion'] = $fechasistema.' '.$horasistema;
  while ($rowAE = $resultAE->fetch_assoc()) {

 

$ArrayCarrerasAbiertas['CarrerasAbiertas'][] = $rowAE;



  }
  mysqli_free_result($resultAE);
}
echo '<br>';


///*



//var_dump($ArrayCarrerasAbiertas);
print_r($ArrayCarrerasAbiertas);
$str = json_encode($ArrayCarrerasAbiertas);
echo $str;

$file = fopen("americanas_abiertas2", "w+");

fwrite($file, $str);

 fclose($file);



?>
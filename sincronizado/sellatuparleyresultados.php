<?php require_once('../Connections/conexionbanca.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo 'holamundo<br>';

$url='http://localhost/new/sincronizado/SELLATUPARLEY%20-%20Results.html';

$iniciof='2022-03-03 00:00:01';
$finalf='2022-03-03 23:59:59';



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$datoscurl = curl_exec($ch);
curl_close($ch);
$datoscurl=preg_replace('/\s+/', 's7s', $datoscurl);
$datoscurl=str_replace('(', 'ZZ', $datoscurl); 
$datoscurl=str_replace(')', 'ZZ', $datoscurl);
$borrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"' , "/" , '%');
$datoscurl=str_replace($borrardecurl, '', $datoscurl);
//echo $datoscurl;

$datoscurl=explode('03-Mar-2022', $datoscurl);
//var_dump($datoscurl);
///*
//echo $datoscurl[1];





$query_Recordset13 = sprintf(
  "/* PARSEADORES1 sincronizado\sellatuparleyresultados.php - QUERY 1 */ SELECT *
  FROM p2juegos
  WHERE
  iniciodtp2 >= %s AND 
  iniciodtp2 <= %s
  ORDER BY deportep2 AND iniciodtp2 DESC",
  GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
  $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
  $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
  $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
  if ($totalRows_Recordset13>=1) {
    $jn=0;
  do {
    $query_Recordset14 = sprintf(
      "/* PARSEADORES1 sincronizado\sellatuparleyresultados.php - QUERY 2 */ SELECT *
      FROM p5resultadosj
      WHERE
      iniciodtp5 >= %s AND 
      iniciodtp5 <= %s AND 
      juegop5 = %s",
      GetSQLValueString($iniciof, "date"),
      GetSQLValueString($finalf, "date"), GetSQLValueString($row_Recordset13['Id_p2juegosp2'], "date"));
      $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
      $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
      $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
      if($totalRows_Recordset14==0){




$juegos=1;
foreach ($datoscurl as $datoscurl2) { if(!strpos($datoscurl2, 'displayBackdropss')) { 
 // substr($cadena, 0, 23);
//     pmspans7sclass_s7s_1s7sspanBURTONs7sALBIONspans7sclass_s7s
//preg_match_all("(pmspans7sclass_s7s_1s7sspan(.*)spans7sclass_s7s(.*))siU", $datoscurl2, $datoscurl3);
//preg_match_all("(s7sclass_s7s_1s7sspan(.*)spans7sclass_s7s(.*))siU", $datoscurl2, $datoscurl3);
$datoscurl2=substr($datoscurl2, 0, 600); //esto no funciona en el preg_match_all pero si  aqui explicar
preg_match_all("(,s7s(.*)s7s(.*)s7sths7stds7sclasstit-th1s7sstylepadding-left:s7s2px!importantheight:s7s37pxs7s!importants7s(.*):s7s(.*)br(.*):s7s(.*)brs7stds7stds7stitleDEPORTEs7ss7sLIGAs7sclassdet-th1s7s(.*)s7sZZ(.*)ZZs7stds7sths7sclassdet-th1(.*)brbr(.*)s7sths7sths7sclassdet-th1s7s(.*)s7sths7sths7sclassdet-th1s7s(.*)s7sths7sths7sclassdet-th1(.*)brbr(.*)s7sths7sths7sclassdet-th1s7s(.*)s7sths7sths7sclassdet-th1s7s(.*)s7sths7sths7sclassdet(.*))siU", substr($datoscurl2, 0, 600), $datoscurl3);
//echo $datoscurl3;
//var_dump($datoscurl3);


if (isset($datoscurl3[4][0])){
 // echo 'si exicte <br>';
$nombree1=str_replace('s7s', ' ', $datoscurl3[4][0]);
$nombree1=str_replace('br', '', $nombree1);

$nombree2=str_replace('s7s', ' ', $datoscurl3[6][0]);
$nombree2=str_replace('br', '', $nombree2);

$nombree3=str_replace('s7s', ' ', $datoscurl3[7][0]);
$nombree3=str_replace('br', '', $nombree3);
$nombree3=str_replace('ZZ', '', $nombree3);

$nombree4=str_replace('s7s', ' ', $datoscurl3[8][0]);
$nombree4=str_replace('br', '', $nombree4);
$nombree4=str_replace('ZZ', '', $nombree4);
$deportevalido=0;
if($nombree4=='Basketball'){$deportevalido=1; }
if($nombree4=='Hockey'){$deportevalido=1; }
if($nombree4=='Futbol'){$deportevalido=1; }
if($nombree4=='Baseball'){$deportevalido=1; }

$query_Recordset21 = sprintf(
  "/* PARSEADORES1 sincronizado\sellatuparleyresultados.php - QUERY 3 */ SELECT *
  FROM p1equipos
  WHERE  
  
  Id_p1equiposp1 = %s",
  GetSQLValueString($row_Recordset13['idequipo1p2'], "int")
  );
  $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
  $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
  $totalRows_Recordset21 = mysqli_num_rows($Recordset21);

  $query_Recordset22 = sprintf(
    "/* PARSEADORES1 sincronizado\sellatuparleyresultados.php - QUERY 4 */ SELECT *
    FROM p1equipos
    WHERE  
    
    Id_p1equiposp1 = %s",
    GetSQLValueString($row_Recordset13['idequipo2p2'], "int")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
//echo $row_Recordset21['nomequipop1'].' ---- '.$nombree1.'  ---- <br>';
$str = strtoupper($row_Recordset21['nomequipop1']);
$str2 = strtoupper($row_Recordset22['nomequipop1']);

//echo strpos($nombree1, $str);

if(strpos($nombree1, $str)){
if(strpos($nombree2, $str2)){
  echo 'primer paso <br>';
if($deportevalido==1){

echo $juegos.' >>';
echo strlen($datoscurl2).' - - ';
echo ' - - - '.$nombree1.' - - - '.$nombree2.' - - - '.$nombree3.' - - - '.$nombree4.'<br>';
   
echo ' JC E1 >> '.$datoscurl3[9][0].' . JC E2 >> '.$datoscurl3[10][0].' . MJ E1 >> '.$datoscurl3[13][0].' . MJ E2 >> '.$datoscurl3[14][0].'<br>';

$Resultadotp1=$datoscurl3[9][0]-$datoscurl3[13][0];
$Resultadotp2=$datoscurl3[10][0]-$datoscurl3[14][0];


if($juegos==0){
//var_dump($datoscurl2);
}

  $juegos++;

}

}}






}
//else{ //echo $datoscurl2; //aqui se vera los datos malos
// }
}



}
}
} while ($row_Recordset13 = mysqli_fetch_assoc($Recordset13));
}











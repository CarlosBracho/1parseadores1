<?php
$insertSQL155 = sprintf(
    "/* PARSEADORES1 parley\carculojparley2.php - QUERY 1 */ UPDATE p4jugadas  SET 
estadojugadap4=%s 
WHERE Id_p4jugadasp4=%s",
    GetSQLValueString($estadojugadap4, "int"),
    GetSQLValueString($row_Recordset1['Id_p4jugadasp4'], "int")
);
$Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
//echo '<a href=carculojparley3.php?nticketp4='.$row_Recordset1['nticketp4'].'>';
if($estadojugadap4==2){


  //echo "perdedor ".$row_Recordset1['Id_p4jugadasp4']."<br>";

  $query_Recordset189 = sprintf(
  "/* PARSEADORES1 parley\carculojparley2.php - QUERY 2 */ SELECT * 
  FROM 
  p4jugadas
  WHERE 
  p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND
  p4jugadas.Id_p4jugadasp4 = %s ",
  GetSQLValueString($Fechacal.' 00:00:02', "date"),
  GetSQLValueString($Fechacal.' 23:59:59', "date"),
  GetSQLValueString($row_Recordset1['Id_p4jugadasp4'], "int"));
  $Recordset189 = mysqli_query($conexionbanca, $query_Recordset189) or die(mysqli_error($conexionbanca));
  $row_Recordset189 = mysqli_fetch_assoc($Recordset189);
  $totalRows_Recordset189 = mysqli_num_rows($Recordset189);
  //echo "totalrow ".$totalRows_Recordset189."<br>";

  if( $totalRows_Recordset189==1){

   // echo "linea1 ".$row_Recordset189['nticketp4']."<br>";
///*

  $insertSQL155 = sprintf(
    "/* PARSEADORES1 parley\carculojparley2.php - QUERY 3 */ UPDATE p4jugadas  SET 
  estadoticketp4=%s 
  WHERE nticketp4=%s AND lineatp4 = 1",
    GetSQLValueString(2, "int"),
    GetSQLValueString($row_Recordset189['nticketp4'], "int")
  );
  $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
//*/
}

  }
//require_once('carculojparley3.php?nticketp4='.$row_Recordset1['nticketp4']);
$varlosx='nticketp4='.$row_Recordset1['nticketp4'];
//echo "linea2 ".$varlosx." ".$estadojugadap4."<br><br>";

$nticketp4=$row_Recordset1['nticketp4'];








$query_Recordset117 = sprintf(
  "/* PARSEADORES1 parley\carculojparley2.php - QUERY 4 */ SELECT * FROM p4jugadas WHERE 
  jugadadtp4 >= %s AND jugadadtp4 <= %s AND
nticketp4 = %s ORDER BY lineatp4 DESC",
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
  GetSQLValueString($nticketp4, "int")
);
$Recordset117 = mysqli_query($conexionbanca, $query_Recordset117) or die(mysqli_error($conexionbanca));
$row_Recordset117 = mysqli_fetch_assoc($Recordset117);
$totalRows_Recordset117 = mysqli_num_rows($Recordset117);

$totaljugadas=$totalRows_Recordset117;
$query_Recordset1890 = sprintf(
  "/* PARSEADORES1 parley\carculojparley2.php - QUERY 5 */ SELECT monto_apuesta, factor_pago, factor_de_hembra, factor_de_macho
   FROM 
   taquilla_opc_parley
   WHERE 
   cod_taquilla = %s ",
   GetSQLValueString($row_Recordset117['cod_taquillap4'], "int"));
    $Recordset1890 = mysqli_query($conexionbanca, $query_Recordset1890) or die(mysqli_error($conexionbanca));
    $row_Recordset1890 = mysqli_fetch_assoc($Recordset1890);
    $totalRows_Recordset1890 = mysqli_num_rows($Recordset1890);
    $totalfactor=$row_Recordset117['mon_ventap4']*$row_Recordset1890['factor_pago'];
    $factordehembra=$row_Recordset1890['factor_de_hembra'];
    $factordemacho=$row_Recordset1890['factor_de_macho'];
    if($factordehembra==0){
      $factordehembra=100;
  }
  if($factordemacho==0){
      $factordemacho=100;
  }
$ganador=1;
$premio=0;
$Perdedor=0;
do {
  if($row_Recordset117['estadojugadap4']==2){$Perdedor=1;}
  if (($row_Recordset117['estadojugadap4']==1 && $ganador==1) or $row_Recordset117['estadojugadap4']==3 && $ganador==1) {
      $ganador=1;
  } else {
      $ganador=2;
  }
  if ($row_Recordset117['estadojugadap4']==3 && $premio==0) {
      $premio=$row_Recordset117['mon_ventap4']+$premio;
  }
  if ($premio==0) {
      $premio=$row_Recordset117['mon_ventap4'];
  } else {
      $premio=$premio;
  }
  if ($row_Recordset117['logrop4']>0 && $row_Recordset117['estadojugadap4']==1) {
      $premio=($premio*($row_Recordset117['logrop4']/$factordehembra))+$premio;
  }
  if ($row_Recordset117['logrop4']<0 && $row_Recordset117['estadojugadap4']==1) {
      $premio=($premio/(($row_Recordset117['logrop4']* -1)/$factordemacho))+$premio;
  }
} while ($row_Recordset117 = mysqli_fetch_assoc($Recordset117));

    
    if($row_Recordset1890['monto_apuesta']>0 && $premio>$row_Recordset1890['monto_apuesta']){
      $premio=$row_Recordset1890['monto_apuesta'];
  }
  
  
  if($totalfactor>0 && $premio>$totalfactor){
      $premio=$totalfactor;
  }   
if ($ganador==1 && $Perdedor==0) {
  //echo "linea5 ganador 1".$premio."<br><br>";
  $insertSQL155 = sprintf(
      "/* PARSEADORES1 parley\carculojparley2.php - QUERY 6 */ UPDATE p4jugadas  SET 
premioapagarp4=%s, estadoticketp4=%s
WHERE nticketp4=%s AND lineatp4=%s",
      GetSQLValueString($premio, "double"),
      GetSQLValueString(1, "int"),
      GetSQLValueString($nticketp4, "int"),
      GetSQLValueString(1, "int")
  );
  $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
  
} else {
 // echo "linea5 else".$premio."<br><br>";
  $insertSQL155 = sprintf(
      "/* PARSEADORES1 parley\carculojparley2.php - QUERY 7 */ UPDATE p4jugadas  SET 
premioapagarp4=%s
WHERE nticketp4=%s AND lineatp4=%s",
      GetSQLValueString(0, "double"),
      GetSQLValueString($nticketp4, "int"),
      GetSQLValueString(1, "int")
  );
  $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
}











?>
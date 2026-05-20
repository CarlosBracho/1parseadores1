<?php
$nticketp4=$row_Recordset188['nticketp4'];
$query_Recordset118 = sprintf(
    "/* PARSEADORES1 new\parley\carculojparleyD.php - QUERY 1 */ SELECT * FROM p4jugadas WHERE 
  nticketp4 = %s ORDER BY lineatp4",
    GetSQLValueString($nticketp4, "int")
  );
  $Recordset118 = mysqli_query($conexionbanca, $query_Recordset118) or die(mysqli_error($conexionbanca));
  $row_Recordset118 = mysqli_fetch_assoc($Recordset118);
  $totalRows_Recordset118 = mysqli_num_rows($Recordset118);
  
  $totaljugadas188=$totalRows_Recordset118;
  $ganador=1;
  $premio=0;
  $Dev=0;
  $mon=0;
  do {
    if (($row_Recordset118['estadojugadap4']==1 && $ganador==1) or $row_Recordset118['estadojugadap4']==3) {
        $ganador=1;
    } else {
        $ganador=2;
    }
    if ($row_Recordset118['estadojugadap4']==3 && $premio==0) {
        $premio=$row_Recordset118['mon_ventap4']+$premio;
    }
    if ($premio==0) {
        $premio=$row_Recordset118['mon_ventap4'];
    } else {
        $premio=$premio;
    }
    if ($row_Recordset118['logrop4']>0 && $row_Recordset118['estadojugadap4']==1) {
        $premio=($premio*($row_Recordset118['logrop4']/100))+$premio;
    }
    if ($row_Recordset118['logrop4']<0 && $row_Recordset118['estadojugadap4']==1) {
        $premio=($premio/(($row_Recordset118['logrop4']* -1)/100))+$premio;
    }

   if ($row_Recordset118['estadoticketp4']==1 && $row_Recordset118['estadojugadap4']==3 && $row_Recordset118['premioapagarp4']==$premio=$row_Recordset118['mon_ventap4'] ) {
        $Dev=2;
       $mon=$row_Recordset118['premioapagarp4'];
    }


  } while ($row_Recordset118 = mysqli_fetch_assoc($Recordset118));
  if ($ganador==1) {
    //echo "linea5 ganador 1".$premio."<br><br>";
    $insertSQL155 = sprintf(
             "/* PARSEADORES1 new\parley\carculojparleyD.php - QUERY 2 */ UPDATE p4jugadas  SET 
       premioapagarp4=%s, estadoticketp4=%s
       WHERE nticketp4=%s AND lineatp4=%s AND estadoticketp4=%s",
             GetSQLValueString($premio, "double"),
             GetSQLValueString(1, "int"),
             
             GetSQLValueString($nticketp4, "int"),
             GetSQLValueString(1, "int"),
             GetSQLValueString(0, "int")
         );
         $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
        }


        $premio=$row_Recordset188['mon_ventap4'];
        $mon=$row_Recordset188['mon_ventap4'];
        if($row_Recordset188['estadojugadap4'] <> 1 && $row_Recordset188['estadojugadap4'] <> 2){
        $insertSQL1556 = sprintf(
            "/* PARSEADORES1 new\parley\carculojparleyD.php - QUERY 3 */ UPDATE p4jugadas  SET 
        premioapagarp4=%s, estadojugadap4=%s, estadoticketp4=%s
        WHERE nticketp4=%s AND lineatp4=%s AND premioapagarp4=%s",
            GetSQLValueString($premio, "double"),
            GetSQLValueString(3, "int"),
            GetSQLValueString(3, "int"),
            GetSQLValueString($nticketp4, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($mon, "int")
            
        );
        $Result1556 = mysqli_query($conexionbanca, $insertSQL1556) or die(mysqli_error($conexionbanca));
        
        }


        echo 'realizado';



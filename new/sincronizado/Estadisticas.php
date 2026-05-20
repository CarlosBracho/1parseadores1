<?php
require_once('../Connections/conexionbanca.php');
$horasistema=horaactual();
$fechasistema=fechaactualbd();


//$fechasistema = strtotime('-1 day', strtotime($fechasistema));
//$fechasistema = date('Y-m-d', $fechasistema);


echo $fechasistema.' <br>';

//incio 0 ame taquillas 
$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 1 */ SELECT  
can_ticket
            FROM  venta
            WHERE 
            fec_venta=%s
            AND lin_ticket=1
            AND can_ticket=1",
    GetSQLValueString($fechasistema, "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        echo 'ame taquillas '.$totalRows_Recordset18D.'<br>';

///*
$insertSQL = sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 2 */ INSERT 
  INTO estadisticas
  (tipo_estadistica, tiempo_estadistica, can_estadisitcas) 
  VALUES (%s, %s, %s)",
  GetSQLValueString(0, "int"),
     GetSQLValueString($fechasistema, "date"),
  GetSQLValueString($totalRows_Recordset18D, "int")
  );
  
  $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
//*/


//fin  0 ame taquillas 

//inicio   1 ame jugadas

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 3 */ SELECT  
can_ticket
            FROM  venta
            WHERE 
            fec_venta=%s
            AND lin_ticket=1",
    GetSQLValueString($fechasistema, "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        echo 'ame jugadas '.$totalRows_Recordset18D.'<br>';

///*
$insertSQL = sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 4 */ INSERT 
  INTO estadisticas
  (tipo_estadistica, tiempo_estadistica, can_estadisitcas) 
  VALUES (%s, %s, %s)",
  GetSQLValueString(1, "int"),
     GetSQLValueString($fechasistema, "date"),
  GetSQLValueString($totalRows_Recordset18D, "int")
  );
  
  $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
//*/




//fin  1 ame jugadas 










//incio 2 nac taquillas 
$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 5 */ SELECT  
can_ticket_hnac
            FROM  venta_hnac
            WHERE 
            fec_venta_hnac=%s
            AND lin_ticket_hnac=1
            AND can_ticket_hnac=1",
    GetSQLValueString($fechasistema, "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        echo 'nac taquillas '.$totalRows_Recordset18D.'<br>';

///*
$insertSQL = sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 6 */ INSERT 
  INTO estadisticas
  (tipo_estadistica, tiempo_estadistica, can_estadisitcas) 
  VALUES (%s, %s, %s)",
  GetSQLValueString(2, "int"),
     GetSQLValueString($fechasistema, "date"),
  GetSQLValueString($totalRows_Recordset18D, "int")
  );
  
  $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
//*/


//fin  2 nac taquillas 

//inicio   3 nac jugadas

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 7 */ SELECT  
can_ticket_hnac
            FROM  venta_hnac
            WHERE 
            fec_venta_hnac=%s
            AND lin_ticket_hnac=1",
    GetSQLValueString($fechasistema, "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        echo 'nac jugadas '.$totalRows_Recordset18D.'<br>';

///*
$insertSQL = sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 8 */ INSERT 
  INTO estadisticas
  (tipo_estadistica, tiempo_estadistica, can_estadisitcas) 
  VALUES (%s, %s, %s)",
  GetSQLValueString(3, "int"),
     GetSQLValueString($fechasistema, "date"),
  GetSQLValueString($totalRows_Recordset18D, "int")
  );
  
  $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
//*/




//fin  3 nac jugadas 










//incio 4 parl taquillas 
$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 9 */ SELECT  
pcan_ticket
            FROM  p4jugadas
            WHERE 
            (jugadadtp4 >= %s AND jugadadtp4 <= %s)
            AND lineatp4=1
            AND pcan_ticket=1",
    GetSQLValueString($fechasistema.' 00:00:00', "date"),
    GetSQLValueString($fechasistema.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        echo 'Parl taquillas '.$totalRows_Recordset18D.'<br>';

///*
$insertSQL = sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 10 */ INSERT 
  INTO estadisticas
  (tipo_estadistica, tiempo_estadistica, can_estadisitcas) 
  VALUES (%s, %s, %s)",
  GetSQLValueString(4, "int"),
     GetSQLValueString($fechasistema, "date"),
  GetSQLValueString($totalRows_Recordset18D, "int")
  );
  
  $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
//*/


//fin  4 parl taquillas 

//inicio   5 parl jugadas

$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 11 */ SELECT  
pcan_ticket
            FROM  p4jugadas
            WHERE 
            (jugadadtp4 >= %s AND jugadadtp4 <= %s)
            AND lineatp4=1",
    GetSQLValueString($fechasistema.' 00:00:00', "date"),
    GetSQLValueString($fechasistema.' 23:59:59', "date")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);


        echo 'Parl jugadas '.$totalRows_Recordset18D.'<br>';

///*
$insertSQL = sprintf(
    "/* PARSEADORES1 new\sincronizado\Estadisticas.php - QUERY 12 */ INSERT 
  INTO estadisticas
  (tipo_estadistica, tiempo_estadistica, can_estadisitcas) 
  VALUES (%s, %s, %s)",
  GetSQLValueString(5, "int"),
   GetSQLValueString($fechasistema, "date"),
  GetSQLValueString($totalRows_Recordset18D, "int")
  );
  
  $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
//*/




//fin  5 parl jugadas 
<?php require_once('../Connections/conexionbanca.php');

$datetime="2022-03-20 00:00:00";

$query_Recordset1111 = sprintf(
    "/* PARSEADORES1 new\sincronizado\php.php - QUERY 1 */ SELECT Id_p2juegosp2
FROM  p2juegos
WHERE iniciodtp2 >= %s AND Id_p2juegosp2 >= 0 ORDER BY Id_p2juegosp2 DESC",
    GetSQLValueString($datetime, "date"));
$Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
$row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
$totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
  //echo  $totalRows_Recordset111;
  $totalvueltas=$totalRows_Recordset1111;
  echo $totalvueltas;


  do {
    $query_Recordset3 = sprintf(
        "/* PARSEADORES1 new\sincronizado\php.php - QUERY 2 */ SELECT logrop3, Id_p3logrosp3, logroABoRLp3, idjuegop3, equipop3, tipojugadap3
    FROM  p3logros
    WHERE logrodtp3 >= %s AND idjuegop3 = %s ORDER BY idjuegop3 DESC LIMIT 1",
     GetSQLValueString($datetime, "date"),
    GetSQLValueString($row_Recordset1111['Id_p2juegosp2'], "int"));
    $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
    $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
    $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
    if($totalRows_Recordset3>0){echo 'si tiene logros ';}else{
        echo 'este juego le cambiare la fecha';

        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\sincronizado\php.php - QUERY 3 */ UPDATE p2juegos 
				SET iniciodtp2=%s 
				WHERE Id_p2juegosp2=%s",
                GetSQLValueString($datetime, "date"),
            GetSQLValueString($row_Recordset1111['Id_p2juegosp2'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

    }



echo $row_Recordset1111['Id_p2juegosp2'].'<br>';




} while ($row_Recordset1111 = mysqli_fetch_assoc($Recordset1111));
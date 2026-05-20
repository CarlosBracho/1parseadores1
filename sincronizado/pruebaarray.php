<?php
echo "Memoria Inicial --> " . memory_get_usage();
include_once('../includes/class.stoper.php');
//instancio un objeto de la clase stoper
$hostname_conexionbanca = "p:localhost";
$database_conexionbanca = "apuestas2";
$username_conexionbanca = "root";
$password_conexionbanca = "ios9X4CJ748J";
$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);
mysqli_set_charset($conexionbanca, 'utf8');
$s = new Stoper();


//ejecuto el mï¿½todo Start() para que el objeto stoper comience a contar el tiempo
$s->Start();


require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual(); $FechaTxt=fechaactualbd(); $fechahora=$FechaTxt.' '.$horaTxt;
$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 1 */ SELECT  
*
            FROM  opciones_parley
            WHERE id_opcionp=%s
            LIMIT 1",
    GetSQLValueString(1, "int")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);
//string(1) "0" [13]=> string(1) "0" ["parseconp2"]=> string(1) "0" [14]=> string(12) "Maradeportes" ["quinregistrap2"]=> string(12) "Maradeportes" [15]=> string(19) "2022-05-26 19:00:08" ["p2time"]=> string(19) "2022-05-26 19:00:08" [16]=> string(1) "0" ["p2vecesactualizado"]=> string(1) "0" }





//inicio array de equipos
$query_RecordsetAE =  sprintf(
    "/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 2 */ SELECT
   Id_p1equiposp1,nomequipop1,deportep1,nommara,nommarapais
  FROM  
  p1equipos
");


if ($resultAE = mysqli_query($conexionbanca, $query_RecordsetAE) or die(mysqli_error($conexionbanca))) {
    while ($rowAE = $resultAE->fetch_array()) {
        $ArrayEquipos[] = $rowAE;
    }
    mysqli_free_result($resultAE);
}
echo '<br>';
//var_dump($tlarray1juego[0]["iniciodtp2"]);
//var_dump($ArrayEquipos);
//final array de equipos





if($row_Recordset18D['Swicht']==1){
//inicio array de juegos
$query_RecordsetAJ =  sprintf(
    "/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 3 */ SELECT
  Id_p2juegosp2, idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2
  FROM  
  p2juegos
  WHERE 
  iniciodtp2 > %s  ORDER BY Id_p2juegosp2 ASC",
  GetSQLValueString('2022-05-27 00:00:00', "date"));


if ($resultAJ = mysqli_query($conexionbanca, $query_RecordsetAJ) or die(mysqli_error($conexionbanca))) {
    while ($rowAJ = $resultAJ->fetch_array()) {
        $ArrayJuegos[] = $rowAJ;
    }
    mysqli_free_result($resultAJ);
}
//echo '<br><br><br><br><br>';
//var_dump($ArrayJuegos[0]["iniciodtp2"]);
//var_dump($ArrayJuegos[0]);
//final array de juegos



///*
//inicio unir los nombres de los juegos a los equipos
foreach ($ArrayJuegos as $clave=>$valorAJ) {
    $nommara1='';
    $nommara2='';
    $Id_p2juegosp2='';
    foreach ($ArrayEquipos as $clave=>$valorAE) {
    if($valorAJ["idequipo1p2"]==$valorAE["Id_p1equiposp1"]){ 
     
       // echo 'equipo 1 '.$valorAE["nommara"].'<br>';
        $nommara1=$valorAE["nommara"];
        $nommarapais1=$valorAE["nommarapais"];

    }
    if($valorAJ["idequipo2p2"]==$valorAE["Id_p1equiposp1"]){ 
     
      //  echo 'equipo 2 '.$valorAE["nommara"].'<br>';
        $nommara2=$valorAE["nommara"];
        $nommarapais2=$valorAE["nommarapais"];
    }

   

}
$iniciodtp2=$valorAJ["iniciodtp2"];
$Id_p2juegosp2=$valorAJ["Id_p2juegosp2"];
$idequipo1p2=$valorAJ["idequipo1p2"];
$idequipo2p2=$valorAJ["idequipo2p2"];
 //aqui se crara el array
 $ArrayJuegosCN[] = array('Id_p2juegosp2' => $Id_p2juegosp2, 'nommara1' => $nommara1, 'nommarapais1' => $nommarapais1, 'idequipo1p2' => $idequipo1p2, 'nommara2' => $nommara2, 'nommarapais2' => $nommarapais2, 'idequipo2p2' => $idequipo2p2, 'iniciodtp2' => $iniciodtp2);

//echo '<br><br>';
}
//var_dump($ArrayJuegosCN[2]);
//fin unir los nombres de los juegos a los equipos


$query_RecordsetLG =  sprintf(
    "/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 4 */ SELECT
  Id_p3logrosp3, idjuegop3, equipop3, tipojugadap3, logroABoRLp3, logrop3
  FROM  
  p3logros
  WHERE logrodtp3 >= %s AND actxp3 = 1 AND Id_p3logrosp3 >= 0 ORDER BY Id_p3logrosp3 ASC",
  GetSQLValueString('2022-05-27 00:00:00', "date"));


if ($resultLG = mysqli_query($conexionbanca, $query_RecordsetLG) or die(mysqli_error($conexionbanca))) {
    while ($rowLG = $resultLG->fetch_array()) {
        $ArrayLogros[] = $rowLG;
    }
    mysqli_free_result($resultLG);
}


}else{
//inicio array de juegos
$query_RecordsetAJ =  sprintf(
    "/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 5 */ SELECT
  Id_p2juegosp2, idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2
  FROM  
  p10juegos
  WHERE 
  iniciodtp2 > %s  ORDER BY Id_p2juegosp2 ASC",
  GetSQLValueString('2022-05-27 00:00:00', "date"));


if ($resultAJ = mysqli_query($conexionbanca, $query_RecordsetAJ) or die(mysqli_error($conexionbanca))) {
    while ($rowAJ = $resultAJ->fetch_array()) {
        $ArrayJuegos[] = $rowAJ;
    }
    mysqli_free_result($resultAJ);
}
//echo '<br><br><br><br><br>';
//var_dump($ArrayJuegos[0]["iniciodtp2"]);
//var_dump($ArrayJuegos[0]);
//final array de juegos





///*
//inicio unir los nombres de los juegos a los equipos
foreach ($ArrayJuegos as $clave=>$valorAJ) {
    $nommara1='';
    $nommara2='';
    $Id_p2juegosp2='';
    foreach ($ArrayEquipos as $clave=>$valorAE) {
    if($valorAJ["idequipo1p2"]==$valorAE["Id_p1equiposp1"]){ 
     
       // echo 'equipo 1 '.$valorAE["nommara"].'<br>';
        $nommara1=$valorAE["nommara"];
        $nommarapais1=$valorAE["nommarapais"];

    }
    if($valorAJ["idequipo2p2"]==$valorAE["Id_p1equiposp1"]){ 
     
      //  echo 'equipo 2 '.$valorAE["nommara"].'<br>';
        $nommara2=$valorAE["nommara"];
        $nommarapais2=$valorAE["nommarapais"];
    }

   

}
$iniciodtp2=$valorAJ["iniciodtp2"];
$Id_p2juegosp2=$valorAJ["Id_p2juegosp2"];
$deportep2=$valorAJ["deportep2"];
$idequipo1p2=$valorAJ["idequipo1p2"];
$idequipo2p2=$valorAJ["idequipo2p2"];


 //aqui se crara el array
 $ArrayJuegosCN[] = array('Id_p2juegosp2' => $Id_p2juegosp2, 'nommara1' => $nommara1, 'nommarapais1' => $nommarapais1, 'idequipo1p2' => $idequipo1p2, 'nommara2' => $nommara2, 'nommarapais2' => $nommarapais2, 'idequipo2p2' => $idequipo2p2, 'iniciodtp2' => $iniciodtp2);

//echo '<br><br>';
}
//var_dump($ArrayJuegosCN[2]);
//fin unir los nombres de los juegos a los equipos

$query_RecordsetLG =  sprintf(
    "/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 6 */ SELECT
  Id_p3logrosp3, idjuegop3, equipop3, tipojugadap3, logroABoRLp3, logrop3
  FROM  
  p10logros
  WHERE logrodtp3 >= %s AND actxp3 = 1 AND Id_p3logrosp3 >= 0 ORDER BY Id_p3logrosp3 ASC",
  GetSQLValueString('2022-05-27 00:00:00', "date"));


if ($resultLG = mysqli_query($conexionbanca, $query_RecordsetLG) or die(mysqli_error($conexionbanca))) {
    while ($rowLG = $resultLG->fetch_array()) {
        $ArrayLogros[] = $rowLG;
    }
    mysqli_free_result($resultLG);
}

}//}else{
//*/

echo '<br><br>';



/*
var_dump($ArrayLogros[2]);


//ininical curl
$link='http://winnerscol.com/routerlogros';
$filename='/home/apuestas/public_html/new/sincronizado/maradeporteslogros.pdf';
$output = shell_exec("wget '".$link."' -O '".$filename."' 2>&1");
//echo "<pre>$output</pre>";
$output2 = shell_exec("pdftohtml maradeporteslogros.pdf maradeporteslogros.html");
//echo "<pre>$output2</pre>";
$salida = shell_exec('ls -lart');
//echo "<pre>$salida</pre>";
//*/

$url='http://localhost/new/sincronizado/maradeporteslogross.html';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
$datoscurl = curl_exec($ch);
curl_close($ch);
$datoscurl=preg_replace('/\s+/', 's7s', $datoscurl);
$datoscurl=str_replace('(', '..Z', $datoscurl); 
$datoscurl=str_replace(')', 'Z..', $datoscurl);
$datoscurl=str_replace('FúTBOL', 'FUTBOL', $datoscurl);
$datoscurl=str_replace('/', 'sts', $datoscurl);

$borrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"', '/', '%');
$datoscurl=str_replace($borrardecurl, '', $datoscurl);
$datoscurl=str_replace('brs7shrs7sas7sname2ab', 'brs7sb', $datoscurl);
$datoscurl=str_replace('pm&160', 'corteaquipm&160', $datoscurl);
$datoscurl=str_replace('am&160', 'corteaquiam&160', $datoscurl);
$datoscurl=str_replace('pmbrstss', 'corteaquipmbrstss', $datoscurl);
$datoscurl=str_replace('ambrstss', 'corteaquiambrstss', $datoscurl);

$datoscurl=str_replace('s7sAbbrs7shrs7sas7sname5a', 'bbrs7s', $datoscurl);
$datoscurl=str_replace('ame3stsa', 'brstss7s', $datoscurl);

$datoscurl=str_replace('brs7shrs7sas7sname4a', 'brs7s', $datoscurl);
$datoscurl=str_replace('brstss7shrstss7sas7sname2stsab', 'brstss7sb', $datoscurl);
$datoscurl=str_replace('brstss7shrstss7sas7sncorteaquiame2stsab', 'brstss7sb', $datoscurl);
$datoscurl=str_replace('brstss7sJcorteaquiamtlands7s', 'brstss7s', $datoscurl);
$datoscurl=str_replace('brstss7shrstss7sas7sncorteaquibrstss', 'brstss7s', $datoscurl);
$datoscurl=str_replace('s7sAstsbbrstss7shrstss7sas7sncorteaquiame5stsa', 'stsbbrstss7s', $datoscurl);
$datoscurl=str_replace(':', 'sxs', $datoscurl);

//120brstss7s0sts0brstss7shrstss7sas7sname3stsa12:30"
//echo $datoscurl;

preg_match_all("((.*)HOJAs7sDEs7sLOGROSs7sDELs7sDIAs7s(.*)s7s(.*)s7s(.*)s7s(.*)s7sDEs7s(.*)stsb(.*))siU", $datoscurl, $datoscurl2ini);
//var_dump($datoscurl2ini);
//23 DE MARZO 2022
if($datoscurl2ini[5][0]=='ENERO'){$mes='01';}
if($datoscurl2ini[5][0]=='FEBRERO'){$mes='02';}
if($datoscurl2ini[5][0]=='MARZO'){$mes='03';}
if($datoscurl2ini[5][0]=='ABRIL'){$mes='04';}
if($datoscurl2ini[5][0]=='MAYO'){$mes='05';}
if($datoscurl2ini[5][0]=='JUNIO'){$mes='06';}
if($datoscurl2ini[5][0]=='JULIO'){$mes='07';}
if($datoscurl2ini[5][0]=='AGOSTO'){$mes='08';}
if($datoscurl2ini[5][0]=='SEPTIEMBRE'){$mes='09';}
if($datoscurl2ini[5][0]=='OCTUBRE'){$mes='10';}
if($datoscurl2ini[5][0]=='NOVIEMBRE'){$mes='11';}
if($datoscurl2ini[5][0]=='DICIEMBRE'){$mes='12';}
//echo $FechaTxt.' fecha sistema<br>';
$FechaTxtMARA=$datoscurl2ini[6][0].'-'.$mes.'-'.$datoscurl2ini[3][0];
//echo '<br>'.$FechaTxtMARA.' fecha mara<br>';


//culmina curl


$datoscurl=explode('brstss7sb', $datoscurl);
//var_dump($datoscurl);
///*
//echo $datoscurl[1];
$idjuegox=0;
$equipox=0;
$logrox=0;
$tipologrox=0;
$juegos=0;

foreach ($datoscurl as $datoscurl2) { //incio foreach principal
  if(strpos($datoscurl2, 'DOCTYPE')) { 
      //var_dump($datoscurl2);
//HOJAs7sDEs7sLOGROSs7sDELs7sDIAs7sMIERCOLESs7s23s7sDEs7sMARZOs7sDEs7s2022stsb








    }
  if(!strpos($datoscurl2, 'DOCTYPE')) { 
 if(!strpos($datoscurl2, 'Visitante')) { 
  if(strlen($datoscurl2)>='50') { 

















//echo strlen($datoscurl2).' - - <br>';
$datoscurl22=explode('corteaqui', $datoscurl2);
foreach ($datoscurl22 as $datoscurl222) {
//var_dump($datoscurl222);
if(strpos($datoscurl222, 'FUTBOL')){
echo 'si es futbol<br>';
}
if(strpos($datoscurl222, 'HOCKEY')){
  echo 'si es HOCKEY<br>';
  }
  if(strlen($datoscurl222)<='100') { 


   
    $hora=0;
    $competicion=0;
    $deporte=0;

//BEISBOLs7sMLBstsbbrstss7s12sxs05
//inicio BEISBOL
$siesbesibol = substr($datoscurl222, 0, 7);
if($siesbesibol=='BEISBOL'){
preg_match_all("((.*)s7s(.*)stsbbrstss7s(.*))siU", $datoscurl222, $datoscurl223);
  $hora = substr($datoscurl222, -7);
  $hora=str_replace('sxs', ':', $hora);
  $competicion=str_replace('s7s', ' ', $datoscurl223[2][0]);
  $deporte=$datoscurl223[1][0];
//echo 'Deporte '.$deporte.' competicion '.$competicion.' hora '.$hora.'<br>';
}
//fin BEISBOL
//inicio futbol
//string(51) "FUTBOLs7sDEs7sMEXICOs7sLIGAs7sMXstsbbrstss7s07sxs00" .....
//if(strpos($datoscurl222, 'FUTBOL')){
  if(!strpos($datoscurl222, 'COPA')){

    if(strpos($datoscurl222, 's7sDEs7s')){
      if(strpos($datoscurl222, 'stsbbrstss7s')){
        preg_match_all("((.*)s7s(.*)s7s(.*)stsbbrstss7s(.*))siU", $datoscurl222, $datoscurl223);
  
      $hora = substr($datoscurl222, -7);
      $hora=str_replace('sxs', ':', $hora);
      $competicion=str_replace('s7s', ' ', $datoscurl223[3][0]);
      $deporte=$datoscurl223[1][0];
  //echo 'Deporte '.$deporte.' competicion '.$competicion.' hora '.$hora.'<br>';

  }
  }
  }
  //}
  //fin futbol
  
  //string(59) "FUTBOLs7sCOPAs7sSANTANDERs7sLIBERTADORESstsbbrstss7s05sxs00" .....
  //string(59) "(.*)s7sCOPAs7s(.*)stsbbrstss(.*)" .....
  //inicio futbol con copa
  if(strpos($datoscurl222, 'COPA')){
    if(strpos($datoscurl222, 'UTBOL')){
    if(strpos($datoscurl222, 'stsbbrstss7s')){
      preg_match_all("((.*)s7sCOPAs7s(.*)stsbbrstss(.*))siU", $datoscurl222, $datoscurl223);
  
    $hora = substr($datoscurl222, -7);
    $hora=str_replace('sxs', ':', $hora);
    $competicion='COPA '.str_replace('s7s', ' ', $datoscurl223[2][0]);
    $deporte=$datoscurl223[1][0];
  //echo 'Deporte '.$deporte.' competicion '.$competicion.' hora '.$hora.'<br>';

  }
  }
  }

  if(strpos($datoscurl222, 'CUP')){
    if(strpos($datoscurl222, 'UTBOL')){
    if(strpos($datoscurl222, 'stsbbrstss7s')){
      preg_match_all("((.*)s7sUSs7s(.*)stsbbrstss(.*))siU", $datoscurl222, $datoscurl223);
  
    $hora = substr($datoscurl222, -7);
    $hora=str_replace('sxs', ':', $hora);
    $competicion='US '.str_replace('s7s', ' ', $datoscurl223[2][0]);
    $deporte=$datoscurl223[1][0];
  //echo 'Deporte '.$deporte.' competicion '.$competicion.' hora '.$hora.'<br>';

  }
  }
  }

  if(strpos($datoscurl222, 'CANADA')){
    if(strpos($datoscurl222, 'UTBOL')){
    if(strpos($datoscurl222, 'stsbbrstss7s')){
      preg_match_all("((.*)s7sCANADAs7s(.*)stsbbrstss(.*))siU", $datoscurl222, $datoscurl223);
  
    $hora = substr($datoscurl222, -7);
    $hora=str_replace('sxs', ':', $hora);
    $competicion='CANADA '.str_replace('s7s', ' ', $datoscurl223[2][0]);
    $deporte=$datoscurl223[1][0];
  //echo 'Deporte '.$deporte.' competicion '.$competicion.' hora '.$hora.'<br>';

  }
  }
  }
  //fin futbol con copa
//inicio BASKET
//BASKETs7sENGLANDs7sBBLs7sCUPstsbbrstss7s02sxs30
  if(strpos($datoscurl222, 'stsbbrstss7s')){

    $siesbasquet = substr($datoscurl222, 0, 6);
    if($siesbasquet=='BASKET'){
    preg_match_all("((.*)s7s(.*)stsbbrstss7s(.*))siU", $datoscurl222, $datoscurl223);
  $hora = substr($datoscurl222, -7);
  $hora=str_replace('sxs', ':', $hora);
  $competicion=str_replace('s7s', ' ', $datoscurl223[2][0]);
  $deporte=$datoscurl223[1][0];
//echo 'Deporte '.$deporte.' competicion '.$competicion.' hora '.$hora.'<br>';
}
}
//fin BASKET
//inicio HOCKEY
//HOCKEYs7sNHLstsbbrstss7s07sxs05
if(strpos($datoscurl222, 'stsbbrstss7s')){

    $siesbasquet = substr($datoscurl222, 0, 6);
    if($siesbasquet=='HOCKEY'){
    preg_match_all("((.*)s7s(.*)stsbbrstss7s(.*))siU", $datoscurl222, $datoscurl223);
  $hora = substr($datoscurl222, -7);
  $hora=str_replace('sxs', ':', $hora);
  $competicion=str_replace('s7s', ' ', $datoscurl223[2][0]);
  $deporte=$datoscurl223[1][0];
//echo 'Deporte '.$deporte.' competicion '.$competicion.' hora '.$hora.'<br>';
}
}
//fin HOCKEY
}
//agregar juego
//var_dump($datoscurl2222);
if(strlen($datoscurl222)>='100') { 
  $ampm=substr($datoscurl222, 0, 2);
  $datoscurl2222=str_replace('brstss7s', '&160', $datoscurl222);
//(.*)&160(.*)&160(.*)&160(.*)sts(.*)&160(.*)sts(.*)&160(.*)s7s&160&160(.*)s7s&160&160(.*)sts(.*)&160(.*)s7s&160&160(.*)&160(.*)sts(.*)&160(.*)sts(.*)&160(.*)&160(.*)&160(.*)&160(.*)sts(.*)&160(.*)sts(.*)&160(.*)s7s&160&160(.*)s7s&160&160(.*)sts(.*)&160(.*)s7s&160&160(.*)&160(.*)sts(.*)&160(.*)sts(.*)&160(.*)
preg_match_all("((.*)&160(.*)&160(.*)&160(.*)sts(.*)&160(.*)sts(.*)&160(.*)s7s&160&160(.*)s7s&160&160(.*)sts(.*)&160(.*)s7s&160&160(.*)&160(.*)sts(.*)&160(.*)sts(.*)&160(.*)&160(.*)&160(.*)&160(.*)sts(.*)&160(.*)sts(.*)&160(.*)s7s&160&160(.*)s7s&160&160(.*)sts(.*)&160(.*)s7s&160&160(.*)&160(.*)sts(.*)&160(.*)sts(.*))siU", $datoscurl2222, $datoscurl2223);
//var_dump($datoscurl2222);
$equipo1=str_replace('s7s', ' ', $datoscurl2223[2][0]);
$equipo1=str_replace('..Z', '(', $equipo1);
$equipo1=str_replace('Z..', ')', $equipo1);
$equipo1=str_replace('ZZ', ' ', $equipo1);
$equipo1=str_replace('  ', ' ', $equipo1);
$equipo1=rtrim($equipo1);
$equipo2=str_replace('s7s', ' ', $datoscurl2223[19][0]);
$equipo2=str_replace('..Z', '(', $equipo2);
$equipo2=str_replace('Z..', ')', $equipo2);
$equipo2=str_replace('ZZ', ' ', $equipo2);
$equipo2=str_replace('  ', ' ', $equipo2);
$equipo2=rtrim($equipo2);
//
if(preg_match("/[a-z]/i", $datoscurl2223[18][0])){
  print "it has alphabet!";
  $equipo2=str_replace('s7s', ' ', $datoscurl2223[18][0]);
  $equipo2=str_replace('ZZ', ' ', $equipo2);
  $equipo2=str_replace('..Z', '(', $equipo2);
$equipo2=str_replace('Z..', ')', $equipo2);
  $datoscurl2223[18][0]=$datoscurl2223[19][0];
}
if(preg_match("/[a-z]/i", $datoscurl2223[20][0])){
  $equipo1=$equipo1.' '.$equipo2;
  $equipo2=str_replace('s7s', ' ', $datoscurl2223[20][0]);
  $equipo2=str_replace('ZZ', ' ', $equipo2);
  $equipo2=str_replace('..Z', '(', $equipo2);
  $equipo2=str_replace('Z..', ')', $equipo2);
  //-155&160-1.5
  preg_match_all("((.*)&160(.*))siU", $datoscurl2223[21][0], $datoscurlx1);
  $datoscurl2223[20][0]=$datoscurlx1[1][0];
  $datoscurl2223[21][0]=$datoscurlx1[2][0];
}
$horamilitar=date( "H:i:s", strtotime( $hora.' '.$ampm ) );
$Fechahoramara=$FechaTxtMARA.' '.$horamilitar;
$Fechahoramara = strtotime('-5 hour', strtotime($Fechahoramara));
$Fechahoramara = date('Y-m-j H:i:s', $Fechahoramara);


echo '<br>datos del juego deporte '.$deporte.' hora jeugo '.$hora.' '.$ampm.'  > '.$horamilitar.' Competicion '.$competicion.' <br>';
//echo ' Equipo1 >> '.$equipo1.' lmle1 >> '.$datoscurl2223[3][0].' runlineptse1 >> '.$datoscurl2223[4][0].' logrorlre1 >> '.$datoscurl2223[5][0].' alta >> '.$datoscurl2223[6][0].' logroalta >> '.$datoscurl2223[7][0].' Logro1erIn >> '.$datoscurl2223[8][0].' AnotaPrimero >> '.$datoscurl2223[9][0].' BoxScoreA >> '.$datoscurl2223[10][0].' BoxScoreALogro >> '.$datoscurl2223[11][0].' TotalCarrPar >> '.$datoscurl2223[12][0].' 1raMLogroe1 >> '.$datoscurl2223[13][0].' 1raMAlvalor >> '.$datoscurl2223[14][0].' 1raMAlLogro >> '.$datoscurl2223[15][0].' 1raM RLPst >> '.$datoscurl2223[16][0].' 1raM RL Logro >> '.$datoscurl2223[17][0].' Empate >> '.$datoscurl2223[18][0].'<br>';
//echo ' Equipo2 >> '.$equipo2.' lmle2 >> '.$datoscurl2223[20][0].' runlineptse2 >> '.$datoscurl2223[21][0].' logrorlre1 >> '.$datoscurl2223[22][0].' baja >> '.$datoscurl2223[23][0].' bajalogro >> '.$datoscurl2223[24][0].' Logro1erIn >> '.$datoscurl2223[25][0].' AnotaPrimero >> '.$datoscurl2223[26][0].' BoxScoreB >> '.$datoscurl2223[27][0].' BoxScoreBLogro >> '.$datoscurl2223[28][0].' TotalCarrImp >> '.$datoscurl2223[29][0].' 1raMLogroe2 >> '.$datoscurl2223[30][0].' 1raMBJvalor >> '.$datoscurl2223[31][0].' 1raMBJLogro >> '.$datoscurl2223[32][0].' 1raM RLPst >> '.$datoscurl2223[33][0].' 1raM RL Logro >> '.$datoscurl2223[17][0].'<br>';
if($deporte=='BEISBOL'){$deportecod=0; $deportenombre='beisbol'; }
if($deporte=='BASKET'){$deportecod=1; $deportenombre='baloncesto';}
if($deporte=='FUTBOL'){$deportecod=2; $deportenombre='futbol'; }
if($deporte=='HOCKEY'){$deportecod=5; $deportenombre='hockey'; }


$yaestaequipo1=0;
$yaestaequipo2=0;
$yaestaequipo1cod=0;
$yaestaequipo2cod=0;
foreach ($ArrayJuegosCN as $clave=>$valore) {


  if($valore["nommara1"]==$equipo1 && $valore["deportep1"]==$deportecod){    $yaestaequipo1=1; $yaestaequipo1cod=$valore["idequipo1p2"];  }
  if($valore["nommara2"]==$equipo2 && $valore["deportep1"]==$deportecod){    $yaestaequipo2=1; $yaestaequipo2cod=$valore["idequipo2p2"];  }

  if($yaestaequipo1==0){
    $equipo112=$valore["nommara1"].' ('.$valore["nommarapais"].')';
    if($equipo112==$equipo1 && $valore["deportep1"]==$deportecod){  $yaestaequipo1=1; $yaestaequipo1cod=$valore["idequipo1p2"];  }
  }
  if($yaestaequipo2==0){
    $equipo114=$valore["nommara2"].' ('.$valore["nommarapais"].')';
    if($equipo114==$equipo2 && $valore["deportep1"]==$deportecod){  $yaestaequipo2=1; $yaestaequipo2cod=$valore["idequipo2p2"];  }
  }

  if($yaestaequipo1==0){
    $equipo112=$valore["nommara1"].'('.$valore["nommarapais"].')';
    if($equipo112==$equipo1 && $valore["deportep1"]==$deportecod){  $yaestaequipo1=1; $yaestaequipo1cod=$valore["idequipo1p2"];  }
  }
  if($yaestaequipo2==0){
    $equipo114=$valore["nommara2"].'('.$valore["nommarapais"].')';
    if($equipo114==$equipo2 && $valore["deportep1"]==$deportecod){  $yaestaequipo2=1; $yaestaequipo2cod=$valore["idequipo2p2"];  }
  }


}

if($yaestaequipo1==0){ echo '<br>1No esta Este equipo '.$equipo1.'<br>'; $noestaequipo++; }
if($yaestaequipo2==0){ echo '<br>2No esta Este equipo '.$equipo2.'<br>'; $noestaequipo++; }

  $idp10juego=0;
if($yaestaequipo1==1 && $yaestaequipo2==1){
$yaestajuego=0;
$yaestajuegohorajuego=0;


foreach ($ArrayJuegosCN as $clave=>$valor2) {
  if($valor2["idequipo1p2"]==$yaestaequipo1cod && $valor2["idequipo2p2"]==$yaestaequipo2cod)  { $idp10juego=$valor2["Id_p2juegosp2"]; $yaestajuego=1;

  if($valor2["iniciodtp2"]<>$Fechahoramara){ 
    $idp10juego=$valor2["Id_p2juegosp2"];
    echo 'se cambiara la hora <br>';
    
    
    
    
    
    
    
    
    
    $yaestajuegohorajuego=1;
  }
}
}

if($yaestajuego==0){ echo 'se creara el juego<br>'; 



  if($row_Recordset18D['Swicht']==1){
$insertSQL = sprintf(
"/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 7 */ INSERT 
INTO p2juegos
(idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2) 
VALUES (%s, %s, %s, %s, %s)",
    GetSQLValueString($yaestaequipo1cod, "int"),
    GetSQLValueString($yaestaequipo2cod, "int"),
    GetSQLValueString($deportenombre, "text"),
    GetSQLValueString($competicion, "text"),
    GetSQLValueString($Fechahoramara, "date")
);
$Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

}else{ //if($row_Recordset18D['Swicht']==1){

  $insertSQL = sprintf(
    "/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 8 */ INSERT 
    INTO p10juegos
    (idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2) 
    VALUES (%s, %s, %s, %s, %s)",
        GetSQLValueString($yaestaequipo1cod, "int"),
        GetSQLValueString($yaestaequipo2cod, "int"),
        GetSQLValueString($deportenombre, "text"),
        GetSQLValueString($competicion, "text"),
        GetSQLValueString($Fechahoramara, "date")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

}//}else{
}else{ echo 'ya esta creara el juego<br>';
  $juegos++;
  
}







if($yaestajuego==1 && $yaestajuegohorajuego==1){ echo 'se actualiza hora del juego<br>'; 



  if($row_Recordset18D['Swicht']==1){
     

    $insertSQL24 = sprintf(
      "/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 9 */ UPDATE p2juegos 
SET iniciodtp2=%s			
WHERE 
Id_p2juegosp2 = %s", 

      GetSQLValueString($Fechahoramara, "date"),

      GetSQLValueString($idp10juego, "int")
  );
  //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
  $Result24 = mysqli_query($conexionbanca, $insertSQL24);



    
}else{ //if($row_Recordset18D['Swicht']==1){


    $insertSQL24 = sprintf(
      "/* PARSEADORES1 sincronizado\pruebaarray.php - QUERY 10 */ UPDATE p10juegos 
SET iniciodtp2=%s			
WHERE 
Id_p2juegosp2 = %s", 

      GetSQLValueString($Fechahoramara, "date"),

      GetSQLValueString($idp10juego, "int")
  );
  //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
  $Result24 = mysqli_query($conexionbanca, $insertSQL24);


}//}else{
}

















$hora = substr($datoscurl222, -7);
$hora=str_replace('sxs', ':', $hora);
}

////aqui comienza la funcion de agregar logro si no esta o si es distinto si esta en cero no lo agregara



if($idp10juego>0){
$logrodate=$Fechahoramara;
//estoy aqui
  //mle1
if($datoscurl2223[3][0]<>0){ 
$tipojugada='ML';
list($logroactualizado)=verificarlogro($yaestaequipo1cod, $datoscurl2223[3][0], $tipojugada, $idp10juego, 1, $logrodate, $tlarray1lg, $Fechahoramara, 0); if($logroactualizado==1){ $la++; $logroactualizado=0; } } 
  //mle2
if($datoscurl2223[20][0]<>0){
$tipojugada='ML';
list($logroactualizado)=verificarlogro($yaestaequipo2cod, $datoscurl2223[20][0], $tipojugada, $idp10juego, 2, $logrodate, $tlarray1lg, $Fechahoramara, 0); if($logroactualizado==1){ $la++; $logroactualizado=0; } }  
//rle1
if($datoscurl2223[5][0]<>0){
  $tipojugada='RL';
  list($logroactualizado)=verificarlogro($yaestaequipo1cod, $datoscurl2223[5][0], $tipojugada, $idp10juego, 1, $logrodate, $tlarray1lg, $Fechahoramara, $datoscurl2223[4][0]); if($logroactualizado==1){ $la++; $logroactualizado=0; } }  
//rle2
if($datoscurl2223[22][0]<>0){
  $tipojugada='RL';
  list($logroactualizado)=verificarlogro($yaestaequipo2cod, $datoscurl2223[22][0], $tipojugada, $idp10juego, 2, $logrodate, $tlarray1lg, $Fechahoramara, $datoscurl2223[21][0]); if($logroactualizado==1){ $la++; $logroactualizado=0; } }  
//al
if($datoscurl2223[7][0]<>0){
  $tipojugada='A';
  list($logroactualizado)=verificarlogro($yaestaequipo1cod, $datoscurl2223[7][0], $tipojugada, $idp10juego, 1, $logrodate, $tlarray1lg, $Fechahoramara, $datoscurl2223[6][0]); if($logroactualizado==1){ $la++; $logroactualizado=0; } } 
//ba
if($datoscurl2223[24][0]<>0){
  $tipojugada='B';
  list($logroactualizado)=verificarlogro($yaestaequipo2cod, $datoscurl2223[24][0], $tipojugada, $idp10juego, 2, $logrodate, $tlarray1lg, $Fechahoramara, $datoscurl2223[23][0]); if($logroactualizado==1){ $la++; $logroactualizado=0; } }  


  //EML
  if($datoscurl2223[18][0]<>0){ 
    $tipojugada='EML';
    list($logroactualizado)=verificarlogro($yaestaequipo1cod, $datoscurl2223[18][0], $tipojugada, $idp10juego, 0, $logrodate, $tlarray1lg, $Fechahoramara, 0); if($logroactualizado==1){ $la++; $logroactualizado=0; } } 
     



    //5mle1
if($datoscurl2223[13][0]<>0){ 
  $tipojugada='5ML';
  list($logroactualizado)=verificarlogro($yaestaequipo1cod, $datoscurl2223[13][0], $tipojugada, $idp10juego, 1, $logrodate, $tlarray1lg, $Fechahoramara, 0); if($logroactualizado==1){ $la++; $logroactualizado=0; } } 
    //5mle2
  if($datoscurl2223[30][0]<>0){
  $tipojugada='5ML';
  list($logroactualizado)=verificarlogro($yaestaequipo2cod, $datoscurl2223[30][0], $tipojugada, $idp10juego, 2, $logrodate, $tlarray1lg, $Fechahoramara, 0); if($logroactualizado==1){ $la++; $logroactualizado=0; } } 
  //5rle1
  if($datoscurl2223[17][0]<>0){
    $tipojugada='5RL';
    list($logroactualizado)=verificarlogro($yaestaequipo1cod, $datoscurl2223[17][0], $tipojugada, $idp10juego, 1, $logrodate, $tlarray1lg, $Fechahoramara, $datoscurl2223[16][0]); if($logroactualizado==1){ $la++; $logroactualizado=0; } } 
  //5rle2
  if($datoscurl2223[17][0]<>0){
    $tipojugada='5RL';
    list($logroactualizado)=verificarlogro($yaestaequipo2cod, $datoscurl2223[17][0], $tipojugada, $idp10juego, 2, $logrodate, $tlarray1lg, $Fechahoramara, $datoscurl2223[33][0]); if($logroactualizado==1){ $la++; $logroactualizado=0; } } 
  //5al
  if($datoscurl2223[15][0]<>0){
    $tipojugada='5A';
    list($logroactualizado)=verificarlogro($yaestaequipo1cod, $datoscurl2223[15][0], $tipojugada, $idp10juego, 1, $logrodate, $tlarray1lg, $Fechahoramara, $datoscurl2223[14][0]); if($logroactualizado==1){ $la++; $logroactualizado=0; } } 
  //5ba
  if($datoscurl2223[32][0]<>0){
    $tipojugada='5B';
    list($logroactualizado)=verificarlogro($yaestaequipo2cod, $datoscurl2223[32][0], $tipojugada, $idp10juego, 2, $logrodate, $tlarray1lg, $Fechahoramara, $datoscurl2223[31][0]); if($logroactualizado==1){ $la++; $logroactualizado=0; } } 



} 

//var_dump($datoscurl223);









}
//echo '<br>';
echo '---------------------------------------------------------------------------------------------';
}
/*
//     pmspans7sclass_s7s_1s7sspanBURTONs7sALBIONspans7sclass_s7s
//preg_match_all("(pmspans7sclass_s7s_1s7sspan(.*)spans7sclass_s7s(.*))siU", $datoscurl2, $datoscurl3);
preg_match_all("(s7sclass_s7s_1s7sspan(.*)spans7sclass_s7s(.*))siU", $datoscurl2, $datoscurl3);
//echo $datoscurl3;
//var_dump($datoscurl3);
$nombree1=str_replace('s7s', ' ', $datoscurl3[1][0]);
echo strlen($datoscurl2).' - - ';
echo $nombree1.'<br>';
*/

//var_dump($datoscurl2);
echo '<br>';
//}






/*

  $idjuegox=$valor2["idp10juego"];
  $equipox=$equipo1;
  $logrox=0;
  $tipologrox=0;


*/



}
}
}
}//final foreeach principal














echo '<br><br>';
//paro la cuenta del tiempo por el objeto stoper con el mï¿½todo Stop()
$s->Stop();

//acabo mostrando el tiempo total de ejecuciï¿½n del script
echo $s->showResult('Tiempo total de ejecuciï¿½n: ').'<br>';
$tiempo = $s->showResult(' ');





echo "Memoria final --> " .  memory_get_usage(); ?>
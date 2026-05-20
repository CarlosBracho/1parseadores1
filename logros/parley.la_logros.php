<?php

if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
echo fechaactualbd().' fecha hoy<br>';

$inicio=fechaactualbd();

$horasistema=horaactual();


function inicio_semana($fecha){

  $diaInicio="Monday";
  $diaFin="Sunday";

  $strFecha = strtotime($fecha);

  $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));

  if(date("l",$strFecha)==$diaInicio){
      $fechaInicio= date("Y-m-d",$strFecha);
  }
  return $fechaInicio;
}
function fin_semana($fecha, $dia){

  $diaInicio="Monday";

  if($dia==1){
    $diaFin="Friday";
  }if($dia==2){
  $diaFin="Saturday";
}if($dia==3){
  $diaFin="Sunday";
}

  $strFecha = strtotime($fecha);

  $fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));

  if(date("l",$strFecha)==$diaFin){
      $fechaFin= date("Y-m-d",$strFecha);
  }
  return $fechaFin;
}

$fecha=fechaactualbd();
//$fecha=strtotime('+6 day', strtotime($fecha));
//$fecha=date('Y-m-d', $fecha);
$semIni=inicio_semana($fecha);

$viernes=fin_semana($fecha,1);
$sabado=fin_semana($fecha,2);
$domingo=fin_semana($fecha,3);
echo $fecha;
echo '<br>';
echo $semIni;
echo '<br>';
echo $viernes;
echo '<br>';
echo $sabado;
echo '<br>';
echo $domingo;
echo '<br>';

$query_Recordset18D =  sprintf(
	"/* PARSEADORES1 logros\parley.la_logros.php - QUERY 1 */ SELECT  
*
		  FROM  opciones_parley
		  WHERE id_opcionp=%s
		  LIMIT 1",
	GetSQLValueString(2, "int")
  );
  $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
  $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
  $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);
  
  echo '<br>';
  if ($row_Recordset18D['Swicht'] == 0) {
	echo 'esta autorizado a crear con Manual<br>';
  }
  if ($row_Recordset18D['Swicht'] == 1) {
	echo 'esta autorizado a crear con MARA<br>';
  }
  if ($row_Recordset18D['Swicht'] == 2) {
	echo 'esta autorizado a crear con WININ<br>';
  }
  if ($row_Recordset18D['Swicht'] == 3) {
	echo 'esta autorizado a crear con SELLA<br>';
  }
  echo '<br>';

$inicio = strtotime('+0 day', strtotime($inicio));
$inicio = date('Y-m-d', $inicio);

$fechahora=$inicio.' '.$horasistema;



function repetido($equipo1, $equipo2, $horajuegopela){
  global $conexionbanca;
  $inicio=fechaactualbd();

  $query_RecordsetAE =  sprintf(
    "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 2 */ SELECT
     Id_p1equiposp1,nomequipop1,deportep1,nom_parley, nomequipop1, nomwinningbet, nomsella
    FROM  
    p1equipos  
    WHERE
    deportep1 = 0
  "
    );
  
  
    if ($resultAE = mysqli_query($conexionbanca, $query_RecordsetAE) or die(mysqli_error($conexionbanca))) {
    while ($rowAE = $resultAE->fetch_array()) {
      $ArrayEquipos[] = $rowAE;
    }
    mysqli_free_result($resultAE);
    }
    
    $par_juego_sin_array[] =array(
      "deporte_sin"    => 99999,
      "Primerequipo_sin"    => 99999,
      "Primerequipo2_sin"  => 99999,
    
    );
    $ArrayJuegos[] = array('Id_p2juegosp2' => '99999', 'nomequipop11' => '99999', 'nommara1' => '99999', 'nommarapais1' => '99999', 'idequipo1p2' => '99999', 'nomequipop12' => '99999', 'nommara2' => '99999', 'nommarapais2' => '99999', 'idequipo2p2' => '99999', 'iniciodtp2' => '99999', 'deportep2' => '99999', 'parseconp2' => '99999');
  
    $query_RecordsetAJ =  sprintf(
    "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 3 */ SELECT
    Id_p2juegosp2, idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, parseconp2
    FROM  
    p2juegos
    WHERE 
    iniciodtp2 >= %s  AND deportep2 = 'beisbol' ORDER BY Id_p2juegosp2 DESC",
    GetSQLValueString($inicio.' 00:00:01', "date")
    );
  
  
    if ($resultAJ = mysqli_query($conexionbanca, $query_RecordsetAJ) or die(mysqli_error($conexionbanca))) {
    while ($rowAJ = $resultAJ->fetch_array()) {
      $ArrayJuegos[] = $rowAJ;
    }
    mysqli_free_result($resultAJ);
    }

               
      

    foreach ($ArrayJuegos as $clave => $valor2) {
    
      foreach ($ArrayEquipos as  $ArrayEquipos2) {
        $acesso=0;
        if($valor2["deportep2"]=="beisbol" OR $valor2["deportep2"]=="99999"){
              
                  
                    
                  
                    
        if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo1)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo1)) OR trim(strtolower($ArrayEquipos2["nomwinningbet"])) == trim(strtolower($equipo1)) OR trim(strtolower($ArrayEquipos2["nomsella"])) == trim(strtolower($equipo1)) &&  $equipo1 <> '') {
  
        $yaestaequipo1 = 1;
        $yaestaequipo1cod = $ArrayEquipos2["Id_p1equiposp1"];
        
        }

        if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo2)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo2)) OR trim(strtolower($ArrayEquipos2["nomwinningbet"])) == trim(strtolower($equipo2)) OR trim(strtolower($ArrayEquipos2["nomsella"])) == trim(strtolower($equipo2)) &&  $equipo2 <> '') {
        $yaestaequipo2 = 1;
        $yaestaequipo2cod = $ArrayEquipos2["Id_p1equiposp1"];
        
        }
      
        if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
         
      if ($valor2["idequipo1p2"] == $yaestaequipo1cod && $valor2["idequipo2p2"] == $yaestaequipo2cod) {
        
     
      $horap2= $valor2["iniciodtp2"];


      $horarango = strtotime('-1 hour', strtotime($horap2));

      $horarango = date("Y-m-d H:i:s", $horarango); 

      $horalimite = strtotime('+1 hour', strtotime($horap2));

      $horalimite = date("Y-m-d H:i:s", $horalimite); 

      //
if($horajuegopela>$horarango && $horajuegopela<$horalimite){

  $acesso=1;
  //echo $horap2;
  if($acesso==1){
      $parseconp2 = $valor2["parseconp2"];
      $idjuego = $valor2["Id_p2juegosp2"];
      $yaestajuego = 1;
      $equipo1cod=$valor2["idequipo1p2"];
      $equipo2cod=$valor2["idequipo2p2"];

      //echo $yaestaequipo1cod.$yaestaequipo2cod;
    }
      }
    
    }
          
    }	
    
      }
      
      }}

return array($idjuego, $equipo1cod, $equipo2cod);
}

function verificarlogro($yaestaequipo1cod, $logro, $tipojugada, $idjuego, $equipo1o2, $logrodate, $ArrayLogros2, $Fechahoramarafun, $valorabrl)
  {
    global $conexionbanca;
    $yaestalg = 0;
    $yaestalgperonoigual = 0;
    $Id_p3logrosp3 = 0;
    $logroactualizado = 0;
    foreach ($ArrayLogros2 as $clave => $valor2) {
      if ($valor2["idjuegop3"] == $idjuego && $valor2["equipop3"] == $equipo1o2 && $valor2["tipojugadap3"] == $tipojugada) {
        $yaestalg = 1;
        $Id_p3logrosp3 = $valor2["Id_p3logrosp3"];
      }
    }

    if ($idjuego > 0 && $yaestalg == 1) {

      //var_dump($ArrayLogros2);
      foreach ($ArrayLogros2 as $clave => $valor2) {
        if ($valor2["idjuegop3"] == $idjuego && $valor2["equipop3"] == $equipo1o2 && $valor2["tipojugadap3"] == $tipojugada && $valor2["logrop3"] == $logro  && $valor2["logroABoRLp3"] == $valorabrl) {
          $yaestalgperonoigual = 1;
          $Id_p3logrosp3 = $valor2["Id_p3logrosp3"];
          // var_dump($valor2["logroABoRLp3"]);
        }
      }
    }


    if ($idjuego > 0 && $yaestalg == 0 && $yaestaequipo1cod > 0) {


      $insertSQL = sprintf(
        "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 4 */ INSERT 
    INTO p3logros
    (idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3, actxp3) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($idjuego, "int"),
        GetSQLValueString($yaestaequipo1cod, "int"),
        GetSQLValueString($equipo1o2, "int"),
        GetSQLValueString($tipojugada, "text"),
        GetSQLValueString($logro, "text"),
        GetSQLValueString($logrodate, "date"),
        GetSQLValueString($valorabrl, "text"),
        GetSQLValueString(1, "int")
      );

      $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

      $insertSQL = sprintf(
        "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 5 */ INSERT 
    INTO p7histolg
    (idjuegop7, Id_p1equiposp7, equipop7, tipojugadap7, logrop7, logroABoRLp7, actxp7) 
    VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($idjuego, "int"),
        GetSQLValueString($yaestaequipo1cod, "int"),
        GetSQLValueString($equipo1o2, "int"),
        GetSQLValueString($tipojugada, "text"),
        GetSQLValueString($logro, "text"),
        GetSQLValueString($valorabrl, "text"),
        GetSQLValueString(1, "int")
      );

      $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    }
    //echo 'error1 '.$idjuego.' error2 '.$yaestalgperonoigual.' error2 '.$Id_p3logrosp3;
    if ($idjuego > 0 && $yaestalgperonoigual == 0 &&  $Id_p3logrosp3 > 0) {
      //echo ' es distinto';
      $logroactualizado = 1;
      $insertSQL1 = sprintf(
        "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 6 */ UPDATE p3logros 
        SET logrop3=%s, logroABoRLp3=%s	
        WHERE 
        actxp3<>%s AND
        Id_p3logrosp3=%s",

        GetSQLValueString($logro, "text"),
        GetSQLValueString($valorabrl, "text"),
        GetSQLValueString(55, "int"),
        GetSQLValueString($Id_p3logrosp3, "int")
      );

      $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

      $insertSQL = sprintf(
        "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 7 */ INSERT 
      INTO p7histolg
      (idjuegop7, Id_p1equiposp7, equipop7, tipojugadap7, logrop7, logroABoRLp7, actxp7) 
    VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($idjuego, "int"),
        GetSQLValueString($yaestaequipo1cod, "int"),
        GetSQLValueString($equipo1o2, "int"),
        GetSQLValueString($tipojugada, "text"),
        GetSQLValueString($logro, "text"),
        GetSQLValueString($valorabrl, "text"),
        GetSQLValueString(1, "int")
      );

      $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    }





    return array($logroactualizado);
  }

$query_RecordsetLG =  sprintf(
	"/* PARSEADORES1 logros\parley.la_logros.php - QUERY 8 */ SELECT
	Id_p3logrosp3, idjuegop3, equipop3, tipojugadap3, logroABoRLp3, logrop3
	FROM  
	p3logros
	WHERE logrodtp3 >= %s  AND Id_p3logrosp3 >= 0 ORDER BY Id_p3logrosp3 DESC",
	GetSQLValueString($inicio . ' 00:00:01', "date")
  );


  if ($resultLG = mysqli_query($conexionbanca, $query_RecordsetLG) or die(mysqli_error($conexionbanca))) {
	while ($rowLG = $resultLG->fetch_array()) {
	  $ArrayLogros[] = $rowLG;
	}
	mysqli_free_result($resultLG);
  }


  $query_RecordsetAE =  sprintf(
	"/* PARSEADORES1 logros\parley.la_logros.php - QUERY 9 */ SELECT
   Id_p1equiposp1,nomequipop1,deportep1,nom_parley, nomequipop1
  FROM  
  p1equipos
"
  );


  if ($resultAE = mysqli_query($conexionbanca, $query_RecordsetAE) or die(mysqli_error($conexionbanca))) {
	while ($rowAE = $resultAE->fetch_array()) {
	  $ArrayEquipos[] = $rowAE;
	}
	mysqli_free_result($resultAE);
  }
  
  $par_juego_sin_array[] =array(
    "deporte_sin"    => 99999,
    "Primerequipo_sin"    => 99999,
    "Primerequipo2_sin"  => 99999,
  
  );
  $ArrayJuegos[] = array('Id_p2juegosp2' => '99999', 'nomequipop11' => '99999', 'nommara1' => '99999', 'nommarapais1' => '99999', 'idequipo1p2' => '99999', 'nomequipop12' => '99999', 'nommara2' => '99999', 'nommarapais2' => '99999', 'idequipo2p2' => '99999', 'iniciodtp2' => '99999', 'deportep2' => '99999', 'parseconp2' => '99999');

  $query_RecordsetAJ =  sprintf(
	"/* PARSEADORES1 logros\parley.la_logros.php - QUERY 10 */ SELECT
	Id_p2juegosp2, idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, parseconp2
	FROM  
	p2juegos
	WHERE 
	iniciodtp2 >= %s  ORDER BY Id_p2juegosp2 DESC",
	GetSQLValueString($inicio.' 00:00:01', "date")
  );


  if ($resultAJ = mysqli_query($conexionbanca, $query_RecordsetAJ) or die(mysqli_error($conexionbanca))) {
	while ($rowAJ = $resultAJ->fetch_array()) {
	  $ArrayJuegos[] = $rowAJ;
	}
	mysqli_free_result($resultAJ);
  }
function divlogro($logro, $tipo, $num){
  $resultado='';
if($logro<>'-tt-td-tt-td-tt-'){

  if($tipo=='PC' && $num==1){
    preg_match_all("(small-tt-stylefont-size:80font-weight:normal_ZZ(.*)ZZ_small-(.*))siU", $logro, $logrodesglosado);
            
    $resultado=$logrodesglosado[1][0];
   }
  if($tipo=='HCE' && $num==3){
    preg_match_all("(-tt-pAnota-tt-1ero(.*)-tt-_ZZ(.*)ZZ_-tt-(.*))siU", $logro, $logrodesglosado);
    $resultado=$logrodesglosado[2][0];
   }

  $logro2=explode('ALTA-tt-O-tt-BAJA',$logro);

 if($tipo=='ML' && $num==1){
  preg_match_all("(-tt----tt----tt-LOGRO-tt----tt-(.*)-tt(.*))siU", $logro2[1], $logrodesglosado);
          
  $resultado=$logrodesglosado[1][0];
 }elseif($tipo=='ML' && $num==2){
  preg_match_all("(-tt----tt----tt-LOGRO-tt----tt-(.*)-tt(.*))siU", $logro2[2], $logrodesglosado);
  $resultado=$logrodesglosado[1][0];
 }
 if($tipo=='EML' && $num==3){
  preg_match_all("(-tt----tt----tt-LOGRO-tt----tt-(.*)-tt(.*))siU", $logro2[1], $logrodesglosado);
  $resultado=$logrodesglosado[1][0];
 }
 if($tipo=='ALTA' && $num==1){
  preg_match_all("(-tt----tt----tt-LOGRO-tt----tt-(.*)-tt(.*))siU", $logro2[1], $logrodesglosado);
          
  $resultado=$logrodesglosado[1][0];
 }elseif($tipo=='BAJA' && $num==2){
  preg_match_all("(-tt----tt----tt-LOGRO-tt----tt-(.*)-tt(.*))siU", $logro2[2], $logrodesglosado);
  $resultado=$logrodesglosado[1][0];
 }
 if($tipo=='RL' && $num < 3){
  preg_match_all("(-tt----tt-(.*)-tt----tt-LOGRO-tt----tt-(.*)-tt-(.*))siU", $logro2[1], $logrodesglosado);
  if($num==1){
    $resultado=$logrodesglosado[1][0];
  }else{
    $resultado=$logrodesglosado[2][0];
  }
 }elseif($tipo=='RL' && $num > 2){
  preg_match_all("(-tt----tt-(.*)-tt----tt-LOGRO-tt----tt-(.*)-tt-(.*))siU", $logro2[2], $logrodesglosado);
  if($num==3){
    $resultado=$logrodesglosado[1][0];
  }else{
    $resultado=$logrodesglosado[2][0];
  }
 }
 if($tipo=='SI' && $num==1){
  preg_match_all("(-tt----tt----tt-LOGRO-tt----tt-(.*)-tt(.*))siU", $logro2[1], $logrodesglosado);
          
  $resultado=$logrodesglosado[1][0];
 }elseif($tipo=='NO' && $num==2){
  preg_match_all("(-tt----tt----tt-LOGRO-tt----tt-(.*)-tt(.*))siU", $logro2[2], $logrodesglosado);
  $resultado=$logrodesglosado[1][0];
 }
 if($tipo=='HCE' && $num==1){
  preg_match_all("(-tt----tt----tt-LOGRO-tt----tt-(.*)-tt(.*))siU", $logro2[1], $logrodesglosado);
          
  $resultado=$logrodesglosado[1][0];
 }elseif($tipo=='HCE' && $num==2){
  preg_match_all("(-tt----tt----tt-LOGRO-tt----tt-(.*)-tt(.*))siU", $logro2[2], $logrodesglosado);
  $resultado=$logrodesglosado[1][0];
 }
}
return ($resultado);
}



$horaTxt=horaactual(); $FechaTxt=fechaactualbd(); $fechahora=$FechaTxt.' '.$horaTxt;
if (!isset($_GET['hoy'])) {
$FechaTxtayer = strtotime('-1 day', strtotime($FechaTxt));
}else{
  $FechaTxtayer = strtotime('-0 day', strtotime($FechaTxt));
}
$FechaTxtayer = date("Y-m-d", $FechaTxtayer );
if (isset($_GET['FechaTxtayer'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
}



//https://sellatuparley.com/results/index/2022-04-28
//$urlhoy='https://sellatuparley.com/results/index/'.$FechaTxt;
$urlayer='https://parseadores1.us.to/logros/autosave.html';
//$url='https://sellatuparley.com/results/index/';

echo $urlayer.' fecha<br>';



//$filePath= 'C:/laragon/www/proyectosglobales/primertrabajo/apuestas/new/logrosresultados/sellatuparley.html';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urlayer);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 100);
$datoscurl = curl_exec($ch);
/*/$fd = fopen($filePath, 'w');
fwrite ($fd, $datoscurl); // Escribe el resultado de curl en el archivo
fclose($fd);/*/
curl_close($ch);

$datoscurl=preg_replace('/\s+/', '-tt-', $datoscurl);
//var_dump($datoscurl);
//$datoscurl=str_replace('-tt-', ' ', $datoscurl); 
$datoscurl=str_replace('(', '_ZZ', $datoscurl); 
$datoscurl=str_replace('<br/>', '-br-', $datoscurl); 
$datoscurl=str_replace('<br/>', '-br-', $datoscurl); 
$datoscurl=str_replace('Í', 'I', $datoscurl); 
$datoscurl=str_replace(')', 'ZZ_', $datoscurl);
$borrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"' , "/" , '%' , '!');
$datoscurl=str_replace($borrardecurl, '', $datoscurl);
/*
$file = "autosave.html";
if (!unlink($file)) {
echo("Error deleting $file").'<br>';
} else {
echo("Deleted $file").'<br>';
}
*/
//parley.laimgdeportes3.png-tt-onerrorthi

//var_dump($ArrayJuegos);
$datoscurl=explode('NOMBRE-tt-DE-tt-LA-tt-LIGA-tt-Y-tt-CANTIDAD-tt-DE-tt-JUEGOS', $datoscurl);

foreach ($datoscurl as $datoscurl2) {

    if(!strpos($datoscurl2, 'OCTYPE-tt-html-tt-html')){
      //esto solo se utiliza para crear juegos
	if(empty($ArrayJuegos)){

		$ArrayJuegos[] = array('Id_p2juegosp2' => '99999', 'nomequipop11' => '99999', 'nommara1' => '99999', 'nommarapais1' => '99999', 'idequipo1p2' => '99999', 'nomequipop12' => '99999', 'nommara2' => '99999', 'nommarapais2' => '99999', 'idequipo2p2' => '99999', 'iniciodtp2' => '99999', 'deportep2' => '99999', 'parseconp2' => '99999');

	}
	//fin de crear juegos

      
         if(strpos($datoscurl2, 'parley.laimgdeportes3.png-tt-onerrorthi')){
$deportenom='beisbol';

preg_match_all("((.*)primary-tt-hidebtn-tt-data-togglecollapse-tt-data-targetcollapseme(.*)-tt-(.*)-tt---tt-(.*))siU", $datoscurl2, $datoscurl222);
if(!empty($datoscurl222)){
$competicion=str_replace('-tt-', ' ', $datoscurl222[3][0]);
}

//echo $datoscurl2.'<br>'.'<br>';
$datoscurl3=explode('INFORMACIÓN-tt-DE-tt-JUEGO-tt-Y-tt-TIPOS-tt-DE-tt-APUESTA', $datoscurl2);

//var_dump($datoscurl3);
foreach ($datoscurl3 as $datoscurl33) {
          
  if(!strpos($datoscurl33, 'EVENTO-tt-FUTURO')){

    if(strpos($datoscurl33, 'TIPOS-tt-DE-tt-APUESTA')){

      
//echo '<br>'.$datoscurl33.'<br>'; 

preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)-tt-p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanar-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAltaBaja(.*)-tt-p-tt-th-tt-th-tt-classtext-center-tt-pRunLine-tt-p-tt-th-tt-th-tt-classtext-center-tt-pGanar-tt-5to-tt-Inn-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAB-tt-5to-tt-Inn(.*)p-tt-th-tt-th-tt-classtext-center-tt-pRL-tt-5to-tt-Inn-tt-p-tt-th-tt-th-tt-classtext-center(.*)CAMPOS-tt-VACIOS-tt-(.*)EQUIPOS-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-(.*)NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-(.*)LOGROS-tt----tt-td-tt-classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)-tt-CAMPOS-tt-VACIOS-tt-(.*)---tt-)siU", $datoscurl33, $datoscurlprimer);
$acceso=0;       
if(isset($datoscurlprimer[1][0])){

  $acceso=1;
 }else{

  preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)-tt-p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanar-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAltaBaja(.*)-tt-p-tt-th-tt-th-tt-classtext-center-tt-pRunLine-tt-p-tt-th-tt-th-tt-classtext-center-tt-pGanar-tt-5to-tt-Inn-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAB-tt-5to-tt-Inn(.*)p-tt-th-tt-th-tt-classtext-center-tt-pRL-tt-5to-tt-Inn-tt-p-tt-th-tt-th-tt-classtext-center(.*)CAMPOS-tt-VACIOS-tt-(.*)EQUIPOS-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-(.*)NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-(.*)LOGROS-tt----tt-td-tt-classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)-tt-CAMPOS-tt-VACIOS(.*))siU", $datoscurl33, $datoscurlprimer);

  if(isset($datoscurlprimer[1][0])){
    $acceso=1;
  }
 }



//var_dump($datoscurlprimer).'<br>'.'<br>'.'<br>';  
if($acceso==1){
$horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
$altabaja=str_replace('-tt-_ZZ', ' ', $datoscurlprimer[2][0]); $altabaja=str_replace('ZZ_', ' ', $altabaja);
$altabaja5=str_replace('-tt-_ZZ', ' ', $datoscurlprimer[3][0]); $altabaja5=str_replace('ZZ_-tt-', ' ', $altabaja5);
$equipo1=str_replace('-tt-', ' ', $datoscurlprimer[6][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
$equipo2=str_replace('-tt-', ' ', $datoscurlprimer[8][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
$ml1=divlogro($datoscurlprimer[10][0], 'ML', 1);
$ml2=divlogro($datoscurlprimer[10][0], 'ML', 2);
$altalogro=divlogro($datoscurlprimer[11][0], 'ALTA', 1);
$bajalogro=divlogro($datoscurlprimer[11][0], 'BAJA', 2);
$altalogro5=divlogro($datoscurlprimer[14][0], 'ALTA', 1);
$bajalogro5=divlogro($datoscurlprimer[14][0], 'BAJA', 2);
$runline1factor=divlogro($datoscurlprimer[12][0], 'RL', 1);
$runline2factor=divlogro($datoscurlprimer[12][0], 'RL', 3);
$runline1=divlogro($datoscurlprimer[12][0], 'RL', 2);
$runline2=divlogro($datoscurlprimer[12][0], 'RL', 4);
$runline15factor=divlogro($datoscurlprimer[15][0], 'RL', 1);
$runline25factor=divlogro($datoscurlprimer[15][0], 'RL', 3);
$runline15=divlogro($datoscurlprimer[15][0], 'RL', 2);
$runline25=divlogro($datoscurlprimer[15][0], 'RL', 4);
$ml15=divlogro($datoscurlprimer[13][0], 'ML', 1);
$ml25=divlogro($datoscurlprimer[13][0], 'ML', 2);
$SI=divlogro($datoscurlprimer[19][0], 'SI', 1);
$NO=divlogro($datoscurlprimer[19][0], 'NO', 2);
$AP1=divlogro($datoscurlprimer[16][0], 'SI', 1);
$AP2=divlogro($datoscurlprimer[16][0], 'NO', 2);
$deporte=0;
$HCE1=divlogro($datoscurlprimer[17][0], 'HCE', 1);
$HCE1factor=divlogro($datoscurlprimer[4][0], 'HCE', 3);
$HCE2=divlogro($datoscurlprimer[17][0], 'HCE', 2);
$HCE2factor=divlogro($datoscurlprimer[4][0], 'HCE', 3);
$picher1=divlogro($datoscurlprimer[7][0], 'PC', 1);
$picher1=str_replace('-tt-', ' ', $picher1);
$picher2=divlogro($datoscurlprimer[9][0], 'PC', 1);
$picher2=str_replace('-tt-', ' ', $picher2);

echo '<br>'.$competicion.'<br>';  
echo '<br>'.$horajuego.'<br>';

echo '<br>'.$equipo1.' PICHER 1 '.$picher1.' ML '.$ml1.' RUNLINE '.$runline1.' factor '.$runline1factor.' SRUNLINE '.$Srunline1.' factor '.$Srunline1factor.' ALTA '.$altalogro.' factor '.$altabaja.' SI '.$SI.' anota primero1 '.$AP1.' HCE '.$HCE1.' factor '.$HCE1factor.'<br>';
	echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml15.' RUNLINE '.$runline15.' factor '.$runline15factor.' ALTA '.$altalogro5.' factor '.$altabaja5.'<br>';
	
	
	echo '<br>'.$equipo2.' PICHER 2 '.$picher2.' ML '.$ml2.' RUNLINE '.$runline2.' factor '.$runline2factor.' SRUNLINE '.$Srunline2.' factor '.$Srunline2factor.' BAJA '.$bajalogro.' factor '.$altabaja.' NO '.$NO.' anota primero2 '.$AP2.' HCE '.$HCE2.' factor '.$HCE2factor.'<br>';
	echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml25.' RUNLINE '.$runline25.' factor '.$runline25factor.' ALTA '.$bajalogro5.' factor '.$altabaja5.'<br>';
    
         

  $duplicado=0;
  $parseconp2=0;
	$yaestajuego = 0;
	$yaestaequipo1 = 0;
                $yaestaequipo2 = 0;
                $yaestaequipo1cod = 0;
                $yaestaequipo2cod = 0;
			$yaestajuegohorajuego = 0;

      //para juegos j1 y j2 
      $Fechahorasella = $horajuego.' '.$inicio;
                        $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                        $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
     

      $horajuego2 = strtotime('+0 hour', strtotime($horajuego));

      $horajuego2 = date("h:i A", $horajuego2);

      //
      if(strlen($equipo1)>0 OR strlen($equipo2)>0){ 
        
	foreach ($ArrayJuegos as $clave => $valor2) {
    
		foreach ($ArrayEquipos as  $ArrayEquipos2) {
      if($valor2["deportep2"]=="beisbol" OR $valor2["deportep2"]=="99999"){
		  if($ArrayEquipos2["deportep1"] == $deporte ){
                
                  
                  
                
                  
		  if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo1)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo1))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo1 <> '') {

			$yaestaequipo1 = 1;
			$yaestaequipo1cod = $ArrayEquipos2["Id_p1equiposp1"];
      
		  }
		  if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo2)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo2))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo2 <> '') {
			$yaestaequipo2 = 1;
			$yaestaequipo2cod = $ArrayEquipos2["Id_p1equiposp1"];
      
		  }
		
		  if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
			 
	  if ($valor2["idequipo1p2"] == $yaestaequipo1cod && $valor2["idequipo2p2"] == $yaestaequipo2cod) {
      
		$parseconp2 = $valor2["parseconp2"];
		$idjuego = $valor2["Id_p2juegosp2"];
		$yaestajuego = 1;
    $horap2= $valor2["iniciodtp2"];
	  }
	  	  
	}	
	}
		}
		
		}}
    if($idjuego > 0){

      $horap2 = strtotime('+0 hour', strtotime($horap2));

      $horap2 = date("Y-m-d H:i:s", $horap2);
      //echo $horap2.'<br>';
      if($horap2<>$Fechahorasella){
        echo $Fechahorasella.'  REPETIDO   ';
  
        list($idjuego,$yaestaequipo1cod,$yaestaequipo2cod) = repetido($equipo1,$equipo2,$Fechahorasella);
  
        echo $idjuego.'  '.$yaestaequipo1cod.'  '.$yaestaequipo2cod.' <br> ';
        }
      
      //echo 'ESA ES LA HORA DENTRO DEL SISTEMA'.$horasjuego.'<br>';
      echo $idjuego."parseconp2=" . $parseconp2 . '<br>';
      if ($JuegosQEstan == ',') {
        $JuegosQEstan = $idjuego;
        } else {
        $JuegosQEstan = ',' . $JuegosQEstan . ',' . $idjuego;
        }
        $juego++;
    }else{
      $juegonuevo[]=array(
        "deporte_sin"    => $deporte,
        "Primerequipo_sin"    => $equipo1,
        "Primerequipo2_sin"  => $equipo2,
      
      );
      $par_juego_sin_array=array_merge($par_juego_sin_array, $juegonuevo);
      
      //var_dump($juegonuevo);
      echo 'REVISAR LOS EQUIPOS PARA INGRESAR JUEGO <br>';
      unset($juegonuevo);
      $juegonuevo=array();
    } }

    $nov = "";
    if ($parseconp2 == 2) {
		if ($idjuego > 0) {

			// SI ACTUALIZA LOS LOGROS POR MARA, ESTE CODIGO VA A SER QUE ACTUALIZE EL JUEGO
			$insertSQL24 = sprintf(
				"/* PARSEADORES1 logros\parley.la_logros.php - QUERY 11 */ UPDATE p2juegos 
			SET  p2vecesactualizado=p2vecesactualizado+1		
			WHERE 
			Id_p2juegosp2 = %s",                  
				GetSQLValueString($idjuego, "int")
			  );
			  //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
			  $Result24 = mysqli_query($conexionbanca, $insertSQL24);

			$Fechahorasella = $horajuego.' '.$inicio;
                $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
			$logrodate = $Fechahorasella;


			if ($deporte <> 6) {
			  $tipojugada = 'ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'RL';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline1factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'RL';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline2factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'A';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }
			  $tipojugada = 'B';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'SI';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $SI, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'NO';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $NO, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'AP';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'AP';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }



			  $tipojugada = 'AG';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $HCE1factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'BG';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $HCE2factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'SRL';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $Srunline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline1factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'SRL';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $Srunline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline2factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }



			  //var_dump($datoscurl2223[25][0]);




			  $tipojugada = 'EML';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'E5ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate5, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }




			  $tipojugada = '5ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5RL';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline15factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5RL';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline25factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5A';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro5, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja5);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5B';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro5, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja5);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }
			} else {
			} //finaliza la inversion de los equipos si es futbol
		  }}
      if ($row_Recordset18D['Swicht'] == 2) {
      if($idjuego==0){

        $Fechahorasella = $horajuego.' '.$inicio;
                $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
			$logrodate = $Fechahorasella;
			
echo $logrodate;
        $query_Recordsetvrfjuego =  sprintf(
          "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 12 */ SELECT  
  deportep2
      FROM  p2juegos
      WHERE 
      iniciodtp2=%s
      AND idequipo1p2=%s
      AND idequipo2p2=%s",
          GetSQLValueString($FechaTxt . ' 00:00:00', "date"),
          GetSQLValueString($yaestaequipo1cod, "int"),
          GetSQLValueString($yaestaequipo2cod, "int")
          );
          $Recordsetvrfjuego = mysqli_query($conexionbanca, $query_Recordsetvrfjuego) or die(mysqli_error($conexionbanca));
          $row_Recordsetvrfjuego = mysqli_fetch_assoc($Recordsetvrfjuego);
          $totalRows_Recordsetvrfjuego = mysqli_num_rows($Recordsetvrfjuego);
  
        
  
          if ($totalRows_Recordsetvrfjuego == 0) {
        
        if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
          
  echo 'ESTE JUEGO SE CREARA'.$yaestaequipo1cod.'    '.$yaestaequipo2cod;
  
  
  $insertSQL = sprintf(
    "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 13 */ INSERT 
INTO p2juegos
(idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, jexterno, parseconp2, pichee1p2, pichee2p2 ) 
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
    GetSQLValueString($yaestaequipo1cod, "int"),
    GetSQLValueString($yaestaequipo2cod, "int"),
    GetSQLValueString($deportenom, "text"),
    GetSQLValueString($competicion, "text"),
    GetSQLValueString($logrodate, "date"),
    GetSQLValueString(0, "int"),
    GetSQLValueString(2, "int"),
    GetSQLValueString($picher1, "text"),
    GetSQLValueString($picher2, "text")
  );
  $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        
        }}
         
      }}
         $idjuego = 0;

}}}}//aqui esta el foreach de los juegos de beisbol


        }



        if(strpos($datoscurl2, 'parley.laimgdeportes5.png-tt-onerrorthi')){
          $deportenom='futbol';
          
          preg_match_all("((.*)primary-tt-hidebtn-tt-data-togglecollapse-tt-data-targetcollapseme(.*)-tt-(.*)-tt---tt-)siU", $datoscurl2, $datoscurl222);
          $competicion=str_replace('-tt-', ' ', $datoscurl222[3][0]);

          
          
          
          
          $datoscurl3=explode('INFORMACIÓN-tt-DE-tt-JUEGO-tt-Y-tt-TIPOS-tt-DE-tt-APUESTA', $datoscurl2);
          
          //var_dump($datoscurl3);
          foreach ($datoscurl3 as $datoscurl33) {
          
            if(!strpos($datoscurl33, 'EVENTO-tt-FUTURO')){
              if(strpos($datoscurl33, 'TIPOS-tt-DE-tt-APUESTA')){
          
                preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)-tt-p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanar-tt-p-tt-th-tt-th-tt-classtext-center-tt-pEmpate-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAltaBaja(.*)-tt-p-tt-th-tt-th-tt-classtext-center-tt-pRunLine-tt-p-tt-th-tt-th-tt-classtext-center-tt-pGanar-tt-1er-tt-T.-tt-p-tt-th-tt-th-tt-classtext-center-tt-pEmpate-tt-1er-tt-T.-tt-p-tt-th-tt----tt-CAMPOS-tt-VACIOS(.*)classborder(.*)EQUIPOS-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-span-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-td-tt----tt-LOGROS-tt----tt-td-tt-classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)CAMPOS-tt-VACIOS-tt-(.*))siU", $datoscurl33, $datoscurlprimer);
          
               //var_dump($datoscurlprimer).'<br>'.'<br>'.'<br>';  
               if(isset($datoscurlprimer[1][0])){
$horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
$altabaja=str_replace('-tt-_ZZ', ' ', $datoscurlprimer[2][0]); $altabaja=str_replace('ZZ_', ' ', $altabaja);
$equipo1=str_replace('-tt-', ' ', $datoscurlprimer[5][0]); $equipo1=str_replace('_ZZ', '', $equipo1); $equipo1=str_replace('ZZ_', '', $equipo1); $equipo1=str_replace('/', '', $equipo1);
$equipo2=str_replace('-tt-', ' ', $datoscurlprimer[6][0]); $equipo2=str_replace('_ZZ', '', $equipo2); $equipo2=str_replace('ZZ_', '', $equipo2);
$ml1=divlogro($datoscurlprimer[7][0], 'ML', 1);
$ml2=divlogro($datoscurlprimer[7][0], 'ML', 2);
$empate=divlogro($datoscurlprimer[8][0], 'EML', 3);
$altalogro=divlogro($datoscurlprimer[9][0], 'ALTA', 1);
$bajalogro=divlogro($datoscurlprimer[9][0], 'BAJA', 2);
$runline1factor=divlogro($datoscurlprimer[10][0], 'RL', 1);
$runline2factor=divlogro($datoscurlprimer[10][0], 'RL', 3);
$runline1=divlogro($datoscurlprimer[10][0], 'RL', 2);
$runline2=divlogro($datoscurlprimer[10][0], 'RL', 4);
$ml15=divlogro($datoscurlprimer[11][0], 'ML', 1);
$ml25=divlogro($datoscurlprimer[11][0], 'ML', 2);
$empate5=divlogro($datoscurlprimer[12][0], 'EML', 3);
$deporte=2; 

echo '<br>'.$competicion.'<br>';  
echo '<br>'.$horajuego.'<br>';

echo '<br>'.$equipo1.' ML '.$ml1.' Empate '.$empate.' ALTA '.$altalogro.' factor '.$altabaja.'<br>';
echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml15.' EMPATE5 '.$empate5.'<br>';


echo '<br>'.$equipo2.' ML '.$ml2.' Empate '.$empate.' BAJA '.$bajalogro.' factor '.$altabaja.'<br>';
echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml25.' EMPATE5 '.$empate5.'<br>';

if($equipo1=='Bodo  Glimt'){

  
  $equipo1='Bodo Glimt';
}
//var_dump($equipo1);               

$jerarquia=1;
$parseconp2=0;
$yaestajuego = 0;
$yaestaequipo1 = 0;
              $yaestaequipo2 = 0;
              $yaestaequipo1cod = 0;
              $yaestaequipo2cod = 0;
    $yaestajuegohorajuego = 0;
    $invertido = 0;
    if(strlen($equipo1)>0 OR strlen($equipo2)>0){ 


foreach ($ArrayJuegos as $clave => $valor2) {
  if($valor2["deportep2"]=="futbol" OR $valor2["deportep2"]=="99999"){
  foreach ($ArrayEquipos as  $ArrayEquipos2) {

    if($ArrayEquipos2["deportep1"] == $deporte ){
              
    if (trim(strtolower($ArrayEquipos2["nom_parley"])) == strtolower($equipo1) OR strtolower($ArrayEquipos2["nomequipop1"]) == trim(strtolower($equipo1))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo1 <> '' ) {
      //echo $equipo1;
    $yaestaequipo1 = 1;
    $yaestaequipo1cod = $ArrayEquipos2["Id_p1equiposp1"];
    

    //var_dump ($yaestaequipo1cod);
    
    }
    if (trim(strtolower($ArrayEquipos2["nom_parley"])) == strtolower($equipo2) OR strtolower($ArrayEquipos2["nomequipop1"]) == trim(strtolower($equipo2))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo2 <> '' ) {
    $yaestaequipo2 = 1;
    $yaestaequipo2cod = $ArrayEquipos2["Id_p1equiposp1"];
    //echo $yaestaequipo2cod;
    
    }

    
  
    if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
     //echo $valor2["idequipo1p2"];
  if ($valor2["idequipo1p2"] == $yaestaequipo1cod && $valor2["idequipo2p2"] == $yaestaequipo2cod) {
  $parseconp2 = $valor2["parseconp2"];
  $idjuego = $valor2["Id_p2juegosp2"];
  $yaestajuego = 1;
  }elseif($valor2["idequipo1p2"] == $yaestaequipo2cod && $valor2["idequipo2p2"] == $yaestaequipo1cod){

    $parseconp2 = $valor2["parseconp2"];
    $idjuego = $valor2["Id_p2juegosp2"];
    $yaestajuego = 1;
    $invertido = 1;

  }
      
}	
}
  }
  //echo $yaestaequipo1cod.' '.$yaestaequipo2cod;
  }}
  if($idjuego > 0){
    echo $idjuego."parseconp2=" . $parseconp2 . '<br>';
    if ($JuegosQEstan == ',') {
      $JuegosQEstan = $idjuego;
      } else {
      $JuegosQEstan = ',' . $JuegosQEstan . ',' . $idjuego;
      }
      $juego++;
  }else{
    echo 'REVISAR LOS EQUIPOS PARA INGRESAR JUEGO <br>';
  } }

  $nov = "";
  if ($parseconp2 == 2) {
  if ($idjuego > 0) {

    // SI ACTUALIZA LOS LOGROS POR MARA, ESTE CODIGO VA A SER QUE ACTUALIZE EL JUEGO
    $insertSQL24 = sprintf(
      "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 14 */ UPDATE p2juegos 
    SET  p2vecesactualizado=p2vecesactualizado+1		
    WHERE 
    Id_p2juegosp2 = %s",                  
      GetSQLValueString($idjuego, "int")
      );
      //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
      $Result24 = mysqli_query($conexionbanca, $insertSQL24);

    $Fechahorasella = $horajuego.' '.$inicio;
              $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
              $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
    $logrodate = $Fechahorasella;
 

    if ($invertido == 0) {
      $tipojugada = 'ML';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = 'ML';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = 'RL';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline1factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = 'RL';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline2factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = 'A';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }
      $tipojugada = 'B';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = 'SI';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $SI, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }

      $tipojugada = 'NO';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $NO, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }

      $tipojugada = 'AP';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }

      $tipojugada = 'AP';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }



      $tipojugada = 'AG';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $HCE1factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }

      $tipojugada = 'BG';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $HCE2factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }

      $tipojugada = 'SRL';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $Srunline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline1factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = 'SRL';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $Srunline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline2factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }



      //var_dump($datoscurl2223[25][0]);




      $tipojugada = 'EML';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }

      $tipojugada = 'E5ML';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate5, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }




      $tipojugada = '5ML';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5ML';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5RL';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline15factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5RL';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline25factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5A';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro5, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altafactor5);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5B';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro5, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja5);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }
    } else {

$tipojugada = 'ML';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml1, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = 'ML';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml2, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }



      $tipojugada = 'B';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
 //echo $yaestaequipo1cod.$altalogro;
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }

      $tipojugada = 'A';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }




      $tipojugada = 'EML';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }

      $tipojugada = 'E5ML';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate5, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }




      $tipojugada = '5ML';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml15, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5ML';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml25, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5RL';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline15, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline15factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5RL';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline25, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline25factor);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5A';
      list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro5, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altafactor5);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }


      $tipojugada = '5B';
      list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro5, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja5);
      if ($logroactualizado == 1) {
      $la++;
      $logroactualizado = 0;
      }
    

    } //finaliza la inversion de los equipos si es futbol
    }}
    if ($row_Recordset18D['Swicht'] == 2) {
    if($idjuego==0){

      $Fechahorasella = $horajuego.' '.$inicio;
              $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
              $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
    $logrodate = $Fechahorasella;
    
echo $logrodate;
      $query_Recordsetvrfjuego =  sprintf(
        "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 15 */ SELECT  
deportep2
    FROM  p2juegos
    WHERE 
    iniciodtp2=%s
    AND idequipo1p2=%s
    AND idequipo2p2=%s",
        GetSQLValueString($FechaTxt . ' 00:00:00', "date"),
        GetSQLValueString($yaestaequipo1cod, "int"),
        GetSQLValueString($yaestaequipo2cod, "int")
        );
        $Recordsetvrfjuego = mysqli_query($conexionbanca, $query_Recordsetvrfjuego) or die(mysqli_error($conexionbanca));
        $row_Recordsetvrfjuego = mysqli_fetch_assoc($Recordsetvrfjuego);
        $totalRows_Recordsetvrfjuego = mysqli_num_rows($Recordsetvrfjuego);

      

        if ($totalRows_Recordsetvrfjuego == 0) {
      
      if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
        
echo 'ESTE JUEGO SE CREARA'.$yaestaequipo1cod.'    '.$yaestaequipo2cod;


if($competicion=='ITALIA SERIE A' or $competicion=='INGLATERRA PREMIER LEAGUE' or $competicion=='ESPANA LA LIGA' or $competicion=='ALEMANIA BUNDESLIGA' or $competicion=='FRANCIA LIGUE 1'){

  $jerarquia=0;
}

        $insertSQL = sprintf(
          "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 16 */ INSERT 
INTO p2juegos
(idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, jexterno, parseconp2, jerarquia) 
VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
          GetSQLValueString($yaestaequipo1cod, "int"),
          GetSQLValueString($yaestaequipo2cod, "int"),
          GetSQLValueString($deportenom, "text"),
          GetSQLValueString($competicion, "text"),
          GetSQLValueString($logrodate, "date"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(2, "int"),
          GetSQLValueString($jerarquia, "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        
      
      }}
       
    }}
       $idjuego = 0;

          
          
          
             } }}}
                  }



                  if(strpos($datoscurl2, 'parley.laimgdeportes4.png-tt-onerrorthi')){
                    $deportenom='hockey';
                    
                    //var_dump($datoscurl2);
                    preg_match_all("((.*)primary-tt-hidebtn-tt-data-togglecollapse-tt-data-targetcollapseme(.*)-tt-(.*)-tt---tt-)siU", $datoscurl2, $datoscurl222);
                    $competicion=str_replace('-tt-', ' ', $datoscurl222[3][0]);
          
                    
                    
                    //echo '<br>'.$competicion.'<br>';  
                    
                    $datoscurl3=explode('INFORMACIÓN-tt-DE-tt-JUEGO-tt-Y-tt-TIPOS-tt-DE-tt-APUESTA', $datoscurl2);
                    
                    //var_dump($datoscurl3);
                    foreach ($datoscurl3 as $datoscurl33) {
                    
                      if(!strpos($datoscurl33, 'EVENTO-tt-FUTURO')){
                        if(strpos($datoscurl33, 'TIPOS-tt-DE-tt-APUESTA')){
                    
                         // echo '<br>'.$datoscurl33.'<br>'; 
                          preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)-tt-p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanar-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAltaBaja(.*)-tt-p-tt-th-tt-th-tt-classtext-center-tt-pRunLine-tt-p-tt-th-tt(.*)classborder(.*)EQUIPOS-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-span-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-td-tt----tt-LOGROS-tt----tt-td-tt-classtext-left(.*)classtext-left(.*)classtext-left(.*)span(.*)-tt-td-tt----tt-CAMPOS-tt-VACIOS-tt----(.*))siU", $datoscurl33, $datoscurlprimer);
                    
                          if($datoscurlprimer[1][0]==NULL){
                            preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)-tt-p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanar-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAltaBaja(.*)-tt-p-tt-th-tt-th-tt-classtext-center-tt-pRunLine-tt-p-tt-th-tt(.*)classborder(.*)EQUIPOS-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-span-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-td-tt----tt-LOGROS-tt----tt-td-tt-classtext-left(.*)classtext-left(.*)classtext-left(.*)-tt-CAMPOS-tt-VACIOS-tt-(.*))siU", $datoscurl33, $datoscurlprimer);
                    

                          }

                         //var_dump($datoscurlprimer).'<br>'.'<br>'.'<br>';  
                         if(isset($datoscurlprimer[1][0])){
          $horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
          $altabaja=str_replace('-tt-_ZZ', ' ', $datoscurlprimer[2][0]); $altabaja=str_replace('ZZ_', ' ', $altabaja);
          $equipo1=str_replace('-tt-', ' ', $datoscurlprimer[5][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
          $equipo2=str_replace('-tt-', ' ', $datoscurlprimer[6][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
          $ml1=divlogro($datoscurlprimer[7][0], 'ML', 1);
          $ml2=divlogro($datoscurlprimer[7][0], 'ML', 2);
          $altalogro=divlogro($datoscurlprimer[8][0], 'ALTA', 1);
          $bajalogro=divlogro($datoscurlprimer[8][0], 'BAJA', 2);
          $runline1factor=divlogro($datoscurlprimer[10][0], 'RL', 1);
          $runline2factor=divlogro($datoscurlprimer[10][0], 'RL', 3);
          $runline1=divlogro($datoscurlprimer[10][0], 'RL', 2);
          $runline2=divlogro($datoscurlprimer[10][0], 'RL', 4);
          $deporte=5;
                          
          //var_dump($equipo1);
echo '<br>'.$competicion.'<br>';  
echo '<br>'.$horajuego.'<br>';

echo '<br>'.$equipo1.' ML '.$ml1.' RUNLINE '.$runline1.' factor '.$runline1factor.' ALTA '.$altalogro.' factor '.$altabaja.'<br>';
echo '<br>'.$equipo2.' ML '.$ml2.' RUNLINE '.$runline2.' factor '.$runline2factor.' BAJA '.$bajalogro.' factor '.$altabaja.'<br>';
		

                    
  

  $parseconp2=0;
	$yaestajuego = 0;
	$yaestaequipo1 = 0;
                $yaestaequipo2 = 0;
                $yaestaequipo1cod = 0;
                $yaestaequipo2cod = 0;
			$yaestajuegohorajuego = 0;
      if(strlen($equipo1)>0 OR strlen($equipo2)>0){ 
	foreach ($ArrayJuegos as $clave => $valor2) {
    if($valor2["deportep2"]=="hockey" OR $valor2["deportep2"]=="99999"){
		foreach ($ArrayEquipos as  $ArrayEquipos2) {

		  if($ArrayEquipos2["deportep1"] == $deporte ){
                
                  
                  
                
                  
		  if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo1)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo1))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo1 <> '') {

			$yaestaequipo1 = 1;
			$yaestaequipo1cod = $ArrayEquipos2["Id_p1equiposp1"];
      
		  }
		  if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo2)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo2))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo2 <> '') {
			$yaestaequipo2 = 1;
			$yaestaequipo2cod = $ArrayEquipos2["Id_p1equiposp1"];
      
		  }
		
		  if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
			 
	  if ($valor2["idequipo1p2"] == $yaestaequipo1cod && $valor2["idequipo2p2"] == $yaestaequipo2cod) {
		$parseconp2 = $valor2["parseconp2"];
		$idjuego = $valor2["Id_p2juegosp2"];
		$yaestajuego = 1;
	  }
	  	  
	}	
	}
		}}
  }
		
    if($idjuego > 0){
      echo $idjuego."parseconp2=" . $parseconp2 . '<br>';
      if ($JuegosQEstan == ',') {
        $JuegosQEstan = $idjuego;
        } else {
        $JuegosQEstan = ',' . $JuegosQEstan . ',' . $idjuego;
        }
        $juego++;
    }else{
      //echo 'REVISAR LOS EQUIPOS PARA INGRESAR JUEGO <br>';
    } 
  }
    $nov = "";
    if ($parseconp2 == 2) {
		if ($idjuego > 0) {

			// SI ACTUALIZA LOS LOGROS POR MARA, ESTE CODIGO VA A SER QUE ACTUALIZE EL JUEGO
			$insertSQL24 = sprintf(
				"/* PARSEADORES1 logros\parley.la_logros.php - QUERY 17 */ UPDATE p2juegos 
			SET  p2vecesactualizado=p2vecesactualizado+1		
			WHERE 
			Id_p2juegosp2 = %s",                  
				GetSQLValueString($idjuego, "int")
			  );
			  //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
			  $Result24 = mysqli_query($conexionbanca, $insertSQL24);

			$Fechahorasella = $horajuego.' '.$inicio;
                $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
			$logrodate = $Fechahorasella;
			
//echo $logrodate;

			if ($deporte <> 6) {
			  $tipojugada = 'ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'RL';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline1factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'RL';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline2factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'A';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }
			  $tipojugada = 'B';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'SI';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $SI, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'NO';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $NO, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'AP';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'AP';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }



			  $tipojugada = 'AG';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $HCE1factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'BG';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $HCE2factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'SRL';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $Srunline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline1factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = 'SRL';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $Srunline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline2factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }



			  //var_dump($datoscurl2223[25][0]);




			  $tipojugada = 'EML';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }

			  $tipojugada = 'E5ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate5, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }




			  $tipojugada = '5ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5ML';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5RL';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline15factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5RL';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline25factor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5A';
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro5, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altafactor5);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }


			  $tipojugada = '5B';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro5, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja5);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }
			} else {
			} //finaliza la inversion de los equipos si es futbol
		  }}
      if ($row_Recordset18D['Swicht'] == 2) {
      if($idjuego==0){

        $Fechahorasella = $horajuego.' '.$inicio;
                $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
			$logrodate = $Fechahorasella;
			
echo $logrodate;
        $query_Recordsetvrfjuego =  sprintf(
          "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 18 */ SELECT  
  deportep2
      FROM  p2juegos
      WHERE 
      iniciodtp2=%s
      AND idequipo1p2=%s
      AND idequipo2p2=%s",
          GetSQLValueString($FechaTxt . ' 00:00:00', "date"),
          GetSQLValueString($yaestaequipo1cod, "int"),
          GetSQLValueString($yaestaequipo2cod, "int")
          );
          $Recordsetvrfjuego = mysqli_query($conexionbanca, $query_Recordsetvrfjuego) or die(mysqli_error($conexionbanca));
          $row_Recordsetvrfjuego = mysqli_fetch_assoc($Recordsetvrfjuego);
          $totalRows_Recordsetvrfjuego = mysqli_num_rows($Recordsetvrfjuego);
  
        
  
          if ($totalRows_Recordsetvrfjuego == 0) {
        
        if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
          
  echo 'ESTE JUEGO SE CREARA'.$yaestaequipo1cod.'    '.$yaestaequipo2cod;
  
  
  
          $insertSQL = sprintf(
            "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 19 */ INSERT 
  INTO p2juegos
  (idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, jexterno, parseconp2 ) 
  VALUES (%s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($yaestaequipo1cod, "int"),
            GetSQLValueString($yaestaequipo2cod, "int"),
            GetSQLValueString($deportenom, "text"),
            GetSQLValueString($competicion, "text"),
            GetSQLValueString($logrodate, "date"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(2, "int")
          );
          $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
          
        
        }}
         
      }}
         $idjuego = 0;               
 

                    
                    
                    
                        }  }}}
                            }


                            if(strpos($datoscurl2, 'parley.laimgdeportes2.png-tt-onerrorthi')){
                              $deportenom='baloncesto';
                              
                              //var_dump($datoscurl2);
                              preg_match_all("((.*)primary-tt-hidebtn-tt-data-togglecollapse-tt-data-targetcollapseme(.*)-tt-(.*)-tt---tt-)siU", $datoscurl2, $datoscurl222);
                              $competicion=str_replace('-tt-', ' ', $datoscurl222[3][0]);
                    
                              
                              
                              //echo '<br>'.$competicion.'<br>';  
                         $pase=0;     
                              $datoscurl3=explode('INFORMACIÓN-tt-DE-tt-JUEGO-tt-Y-tt-TIPOS-tt-DE-tt-APUESTA', $datoscurl2);
                              
                              //var_dump($datoscurl3);
                              foreach ($datoscurl3 as $datoscurl33) {
                              
                                if(!strpos($datoscurl33, 'EVENTO-tt-FUTURO') && $competicion<>'WNBA ALL-STAR GAME'){
                                  if(strpos($datoscurl33, 'TIPOS-tt-DE-tt-APUESTA')){
                              
                                    //

                                    
                                    
                              
                                    if($competicion=='COLLEGE BASKETBALL'){

                                      if($fecha<>$viernes && $fecha<>$sabado && $fecha<>$domingo){
                                      //echo '<br>'.$datoscurl33.'<br>'; 
                                      preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)-tt-p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanar-tt-p-tt-th-tt-th-tt-classtext-center-tt-pSpread-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAltaBaja-tt-(.*)-tt-p-tt-th-tt----tt-CAMPOS-tt-VACIOS-tt-(.*)classborder-table(.*)EQUIPOS-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-span-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-td-tt----tt-LOGROS-tt----tt-td-tt-classtext-left(.*)classtext-left(.*)classtext-left(.*)td-tt----tt-CAMPOS-tt-VACIOS-tt-(.*))siU", $datoscurl33, $datoscurlprimer);
                                    //var_dump($datoscurlprimer).'<br>'.'<br>'.'<br>';  
                                    $horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
                                    $altabaja=str_replace('_ZZ', ' ', $datoscurlprimer[2][0]); $altabaja=str_replace('ZZ_', ' ', $altabaja);
                                    $equipo1=str_replace('-tt-', ' ', $datoscurlprimer[5][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
                                    $equipo2=str_replace('-tt-', ' ', $datoscurlprimer[6][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
                                    $ml1=divlogro($datoscurlprimer[7][0], 'ML', 1);
                                    $ml2=divlogro($datoscurlprimer[7][0], 'ML', 2);
                                    $altalogro=divlogro($datoscurlprimer[9][0], 'ALTA', 1);
                                    $bajalogro=divlogro($datoscurlprimer[9][0], 'BAJA', 2);
                                    $runline1factor=divlogro($datoscurlprimer[8][0], 'RL', 1);
                                    $runline2factor=divlogro($datoscurlprimer[8][0], 'RL', 3);
                                    $runline1=divlogro($datoscurlprimer[8][0], 'RL', 2);
                                    $runline2=divlogro($datoscurlprimer[8][0], 'RL', 4);
                                    $deporte=1;
                                    
                    //// medio tiempo 
		$ml15=divlogro($datoscurlprimer[11][0], 'ML', 1); $ml25=divlogro($datoscurlprimer[11][0], 'ML', 2);
		$runline15=divlogro($datoscurlprimer[12][0], 'RL', 2); $runline15factor=divlogro($datoscurlprimer[12][0], 'RL', 1);
		$runline25=divlogro($datoscurlprimer[12][0], 'RL', 4); $runline25factor=divlogro($datoscurlprimer[12][0], 'RL', 3);
		$altalogro5=divlogro($datoscurlprimer[13][0], 'ALTA', 1); $altafactor5=str_replace('_ZZ', ' ', $datoscurlprimer[3][0]); $altafactor5=str_replace('ZZ_', ' ', $altafactor5); $altafactor5=str_replace('-tt-', ' ', $altafactor5);
		$bajalogro5=divlogro($datoscurlprimer[13][0], 'BAJA', 2); $altabaja5=str_replace('_ZZ', ' ', $datoscurlprimer[3][0]); $altabaja5=str_replace('ZZ_', ' ', $altabaja5); $altabaja5=str_replace('-tt-', ' ', $altabaja5);
		
    
          echo '<br>'.$competicion.'<br>';  
          echo '<br>'.$horajuego.'<br>';
          
          echo '<br>'.$equipo1.' ML '.$ml1.' RUNLINE '.$runline1.' factor '.$runline1factor.' ALTA '.$altalogro.' factor '.$altabaja.'<br>';
 echo '<br>'.$equipo2.' ML '.$ml2.' RUNLINE '.$runline2.' factor '.$runline2factor.' BAJA '.$bajalogro.' factor '.$altabaja.'<br>';
          
                                    
} }else{
                                   
                                   preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)-tt-p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanar-tt-p-tt-th-tt-th-tt-classtext-center-tt-pSpread-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAltaBaja-tt-(.*)-tt-p-tt-th-tt-th-tt-classtext-center-tt-pGanar-tt-1era-tt-M-tt-p-tt-th-tt-th-tt-classtext-center-tt-pRL-tt-1era-tt-M-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAB-tt-1era-tt-M-tt-(.*)p-tt-th-tt-th-tt-classtext-center-tt-pRL-tt-1er-tt-C.-tt-p-tt-th-tt-th-tt-classtext-center(.*)-tt-CAMPOS-tt-VACIOS-tt----tt-tr-tt-tr-tt-classborder(.*)EQUIPOS-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-span-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-td-tt----tt-LOGROS-tt----tt-td-tt-classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)CAMPOS-tt-VACIOS-tt----tt-tr-tt-(.*))siU", $datoscurl33, $datoscurlprimer);       

                    $horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
                    $altabaja=str_replace('_ZZ', ' ', $datoscurlprimer[2][0]); $altabaja=str_replace('ZZ_', ' ', $altabaja);
                    $equipo1=str_replace('-tt-', ' ', $datoscurlprimer[6][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
                    $equipo2=str_replace('-tt-', ' ', $datoscurlprimer[7][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
                    $ml1=divlogro($datoscurlprimer[8][0], 'ML', 1);
                    $ml2=divlogro($datoscurlprimer[8][0], 'ML', 2);
                    $altalogro=divlogro($datoscurlprimer[10][0], 'ALTA', 1);
                    $bajalogro=divlogro($datoscurlprimer[10][0], 'BAJA', 2);
                    $runline1factor=divlogro($datoscurlprimer[9][0], 'RL', 1);
                    $runline2factor=divlogro($datoscurlprimer[9][0], 'RL', 3);
                    $runline1=divlogro($datoscurlprimer[9][0], 'RL', 2);
                    $runline2=divlogro($datoscurlprimer[9][0], 'RL', 4);
                    $deporte=1;
                                    
                    //// medio tiempo 
		$ml15=divlogro($datoscurlprimer[11][0], 'ML', 1); $ml25=divlogro($datoscurlprimer[11][0], 'ML', 2);
		$runline15=divlogro($datoscurlprimer[12][0], 'RL', 2); $runline15factor=divlogro($datoscurlprimer[12][0], 'RL', 1);
		$runline25=divlogro($datoscurlprimer[12][0], 'RL', 4); $runline25factor=divlogro($datoscurlprimer[12][0], 'RL', 3);
		$altalogro5=divlogro($datoscurlprimer[13][0], 'ALTA', 1); $altafactor5=str_replace('_ZZ', ' ', $datoscurlprimer[3][0]); $altafactor5=str_replace('ZZ_', ' ', $altafactor5); $altafactor5=str_replace('-tt-', ' ', $altafactor5);
		$bajalogro5=divlogro($datoscurlprimer[13][0], 'BAJA', 2); $altabaja5=str_replace('_ZZ', ' ', $datoscurlprimer[3][0]); $altabaja5=str_replace('ZZ_', ' ', $altabaja5); $altabaja5=str_replace('-tt-', ' ', $altabaja5);
		
    
          echo '<br>'.$competicion.'<br>';  
          echo '<br>'.$horajuego.'<br>';
          
          echo '<br>'.$equipo1.' ML '.$ml1.' RUNLINE '.$runline1.' factor '.$runline1factor.' ALTA '.$altalogro.' factor '.$altabaja.'<br>';
          echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml15.' RUNLINE '.$runline15.' factor '.$runline15factor.' ALTA5 '.$altalogro5.' factor '.$altafactor5.'<br>';
		echo '<br>'.$equipo2.' ML '.$ml2.' RUNLINE '.$runline2.' factor '.$runline2factor.' BAJA '.$bajalogro.' factor '.$altabaja.'<br>';
          echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml25.' RUNLINE '.$runline25.' factor '.$runline25factor.' BAJA5 '.$bajalogro5.' factor '.$altabaja5.'<br>';
                                    }
          
          if(isset($datoscurlprimer[1][0])){                   
                           
        

        $parseconp2=0;
        $yaestajuego = 0;
        $yaestaequipo1 = 0;
                      $yaestaequipo2 = 0;
                      $yaestaequipo1cod = 0;
                      $yaestaequipo2cod = 0;
            $yaestajuegohorajuego = 0;
            $equipo1=trim($equipo1);
            $equipo2=trim($equipo2);
            if(strlen($equipo1)>0 OR strlen($equipo2)>0){ 
        foreach ($ArrayJuegos as $clave => $valor2) {
          if($valor2["deportep2"]=="baloncesto" OR $valor2["deportep2"]=="99999"){
          foreach ($ArrayEquipos as  $ArrayEquipos2) {
      
            if($ArrayEquipos2["deportep1"] == $deporte ){
                      
                        
                        
                      
                        
            if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo1)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo1))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo1 <> '') {
      
            $yaestaequipo1 = 1;
            $yaestaequipo1cod = $ArrayEquipos2["Id_p1equiposp1"];
            
            }
            if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo2)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo2))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo2 <> '') {
            $yaestaequipo2 = 1;
            $yaestaequipo2cod = $ArrayEquipos2["Id_p1equiposp1"];
            
            }

            
$cadena = "Me encanta cantar la la lalaLa :-)";
$buscado="lalala"; // busco "lalala" en $cadena
$buscado= "/".$buscado."/i";




          
            if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
             
          if ($valor2["idequipo1p2"] == $yaestaequipo1cod && $valor2["idequipo2p2"] == $yaestaequipo2cod) {
          $parseconp2 = $valor2["parseconp2"];
          $idjuego = $valor2["Id_p2juegosp2"];
          $yaestajuego = 1;
          }
              
        }	
        }
       
          }
          
          }}
          if($idjuego > 0){
            echo $idjuego."parseconp2=" . $parseconp2 . '<br>';
            if ($JuegosQEstan == ',') {
              $JuegosQEstan = $idjuego;
              } else {
              $JuegosQEstan = ',' . $JuegosQEstan . ',' . $idjuego;
              }
              $juego++;
          }else{
            

            echo 'REVISAR LOS EQUIPOS PARA INGRESAR JUEGO <br>';
          } }
      
          $nov = "";
          if ($parseconp2 == 2) {
          if ($idjuego > 0) {
      
            // SI ACTUALIZA LOS LOGROS POR MARA, ESTE CODIGO VA A SER QUE ACTUALIZE EL JUEGO
            $insertSQL24 = sprintf(
              "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 20 */ UPDATE p2juegos 
            SET  p2vecesactualizado=p2vecesactualizado+1		
            WHERE 
            Id_p2juegosp2 = %s",                  
              GetSQLValueString($idjuego, "int")
              );
              //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
              $Result24 = mysqli_query($conexionbanca, $insertSQL24);
      
            $Fechahorasella = $horajuego.' '.$inicio;
                      $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                      $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
            $logrodate = $Fechahorasella;
            
      //echo 'aqui';
      
            if ($deporte <> 6) {
              $tipojugada = 'ML';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = 'ML';
              list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = 'RL';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline1factor);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = 'RL';
              list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline2factor);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = 'A';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
              $tipojugada = 'B';
              list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = 'SI';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $SI, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
              $tipojugada = 'NO';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $NO, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
              $tipojugada = 'AP';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
              $tipojugada = 'AP';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
      
              $tipojugada = 'AG';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $HCE1factor);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
              $tipojugada = 'BG';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $HCE2factor);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
              $tipojugada = 'SRL';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $Srunline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline1factor);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = 'SRL';
              list($logroactualizado) = verificarlogro($yaestaequipo2cod, $Srunline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline2factor);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
      
              //var_dump($datoscurl2223[25][0]);
      
      
      
      
              $tipojugada = 'EML';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
              $tipojugada = 'E5ML';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate5, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
      
      
              $tipojugada = '5ML';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = '5ML';
              list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = '5RL';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline15factor);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = '5RL';
              list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline25factor);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = '5A';
              list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro5, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altafactor5);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
      
      
              $tipojugada = '5B';
              list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro5, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja5);
              if ($logroactualizado == 1) {
              $la++;
              $logroactualizado = 0;
              }
            } else {
            } //finaliza la inversion de los equipos si es futbol
            }}
            if ($row_Recordset18D['Swicht'] == 2) {
            if($idjuego==0){
      
              $Fechahorasella = $horajuego.' '.$inicio;
                      $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                      $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
            $logrodate = $Fechahorasella;
            
      echo $logrodate;
              $query_Recordsetvrfjuego =  sprintf(
                "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 21 */ SELECT  
        deportep2
            FROM  p2juegos
            WHERE 
            iniciodtp2=%s
            AND idequipo1p2=%s
            AND idequipo2p2=%s",
                GetSQLValueString($FechaTxt . ' 00:00:00', "date"),
                GetSQLValueString($yaestaequipo1cod, "int"),
                GetSQLValueString($yaestaequipo2cod, "int")
                );
                $Recordsetvrfjuego = mysqli_query($conexionbanca, $query_Recordsetvrfjuego) or die(mysqli_error($conexionbanca));
                $row_Recordsetvrfjuego = mysqli_fetch_assoc($Recordsetvrfjuego);
                $totalRows_Recordsetvrfjuego = mysqli_num_rows($Recordsetvrfjuego);
        
              
        
                if ($totalRows_Recordsetvrfjuego == 0) {
              
              if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
                
        echo 'ESTE JUEGO SE CREARA'.$yaestaequipo1cod.'    '.$yaestaequipo2cod;
        
        
        
                $insertSQL = sprintf(
                  "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 22 */ INSERT 
        INTO p2juegos
        (idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, jexterno, parseconp2 ) 
        VALUES (%s, %s, %s, %s, %s, %s, %s)",
                  GetSQLValueString($yaestaequipo1cod, "int"),
                  GetSQLValueString($yaestaequipo2cod, "int"),
                  GetSQLValueString($deportenom, "text"),
                  GetSQLValueString($competicion, "text"),
                  GetSQLValueString($logrodate, "date"),
                  GetSQLValueString(0, "int"),
                  GetSQLValueString(2, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                
              
              }}
               
            }}
               $idjuego = 0;
      
                              
                              
                              
                              }}}}
                                      }

//echo $datoscurl2;
                                      if(strpos($datoscurl2, 'parley.laimgdeportes1.png-tt-onerrorthi')){
                                        $deportenom='futbolamericano';
                                        
                                        
                                        preg_match_all("((.*)primary-tt-hidebtn-tt-data-togglecollapse-tt-data-targetcollapseme(.*)-tt-(.*)-tt---tt-)siU", $datoscurl2, $datoscurl222);
                                        $competicion=str_replace('-tt-', ' ', $datoscurl222[3][0]);
                              
                                        
                                        
                                        echo '<br>'.$competicion.'<br>';  
                                   $pase=0;     
                                        $datoscurl3=explode('INFORMACIÓN-tt-DE-tt-JUEGO-tt-Y-tt-TIPOS-tt-DE-tt-APUESTA', $datoscurl2);
                                        
                                        //var_dump($datoscurl3);
                                        foreach ($datoscurl3 as $datoscurl33) {
                                        
                                          if(!strpos($datoscurl33, 'EVENTO-tt-FUTURO')){
                                            if(strpos($datoscurl33, 'TIPOS-tt-DE-tt-APUESTA')){
                                        
                                      
                                              

                                               
                                                //echo '<br>'.$datoscurl33.'<br>'; 
                                                preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)-tt-p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanar-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAltaBaja-tt-(.*)-tt-p-tt-th-tt(.*)classborder-table(.*)EQUIPOS-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-span-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-td-tt----tt-LOGROS-tt----tt-td-tt-classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)td-tt----tt-CAMPOS-tt-VACIOS-tt-(.*))siU", $datoscurl33, $datoscurlprimer);
                                              //var_dump($datoscurlprimer).'<br>'.'<br>'.'<br>';  
                                              if(isset($datoscurlprimer[1][0])){ 
                                              $horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
                                              $altabaja=str_replace('_ZZ', ' ', $datoscurlprimer[2][0]); $altabaja=str_replace('ZZ_', ' ', $altabaja);
                                              $equipo1=str_replace('-tt-', ' ', $datoscurlprimer[5][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
                                              $equipo2=str_replace('-tt-', ' ', $datoscurlprimer[6][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
                                              $ml1=divlogro($datoscurlprimer[7][0], 'ML', 1);
                                              $ml2=divlogro($datoscurlprimer[7][0], 'ML', 2);
                                              $altalogro=divlogro($datoscurlprimer[8][0], 'ALTA', 1);
                                              $bajalogro=divlogro($datoscurlprimer[8][0], 'BAJA', 2);
                                              $runline1factor=divlogro($datoscurlprimer[9][0], 'RL', 1);
                                              $runline2factor=divlogro($datoscurlprimer[9][0], 'RL', 3);
                                              $runline1=divlogro($datoscurlprimer[9][0], 'RL', 2);
                                              $runline2=divlogro($datoscurlprimer[9][0], 'RL', 4);
                                              $deporte=4;
                                              
                              //// medio tiempo 
              $ml15=divlogro($datoscurlprimer[11][0], 'ML', 1); $ml25=divlogro($datoscurlprimer[11][0], 'ML', 2);
              $runline15=divlogro($datoscurlprimer[12][0], 'RL', 2); $runline15factor=divlogro($datoscurlprimer[12][0], 'RL', 1);
              $runline25=divlogro($datoscurlprimer[12][0], 'RL', 4); $runline25factor=divlogro($datoscurlprimer[12][0], 'RL', 3);
              $altalogro5=divlogro($datoscurlprimer[13][0], 'ALTA', 1); $altafactor5=str_replace('_ZZ', ' ', $datoscurlprimer[3][0]); $altafactor5=str_replace('ZZ_', ' ', $altafactor5); $altafactor5=str_replace('-tt-', ' ', $altafactor5);
              $bajalogro5=divlogro($datoscurlprimer[13][0], 'BAJA', 2); $altabaja5=str_replace('_ZZ', ' ', $datoscurlprimer[3][0]); $altabaja5=str_replace('ZZ_', ' ', $altabaja5); $altabaja5=str_replace('-tt-', ' ', $altabaja5);
              
              
                    echo '<br>'.$competicion.'<br>';  
                    echo '<br>'.$horajuego.'<br>';
                    
                    echo '<br>'.$equipo1.' ML '.$ml1.' RUNLINE '.$runline1.' factor '.$runline1factor.' ALTA '.$altalogro.' factor '.$altabaja.'<br>';
           echo '<br>'.$equipo2.' ML '.$ml2.' RUNLINE '.$runline2.' factor '.$runline2factor.' BAJA '.$bajalogro.' factor '.$altabaja.'<br>';
                    
                                              }else{
           
                                             
                                             preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)-tt-p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanar-tt-p-tt-th-tt-th-tt-classtext-center-tt-pSpread-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAltaBaja-tt-(.*)-tt-p-tt-th-tt-th-tt-classtext-center-tt-pGanar-tt-1era-tt-M-tt-p-tt-th-tt-th-tt-classtext-center-tt-pRL-tt-1era-tt-M-tt-p-tt-th-tt-th-tt-classtext-center-tt-pAB-tt-1era-tt-M-tt-(.*)p-tt-th-tt-th-tt-classtext-center-tt-pRL-tt-1er-tt-C.-tt-p-tt-th-tt-th-tt-classtext-center(.*)-tt-CAMPOS-tt-VACIOS-tt----tt-tr-tt-tr-tt-classborder(.*)EQUIPOS-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-span-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt----tt-PITCHER-tt----tt-span-tt-td-tt----tt-LOGROS-tt----tt-td-tt-classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)classtext-left(.*)CAMPOS-tt-VACIOS-tt----tt-tr-tt-(.*))siU", $datoscurl33, $datoscurlprimer);       
          
                              $horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
                              $altabaja=str_replace('_ZZ', ' ', $datoscurlprimer[2][0]); $altabaja=str_replace('ZZ_', ' ', $altabaja);
                              $equipo1=str_replace('-tt-', ' ', $datoscurlprimer[6][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
                              $equipo2=str_replace('-tt-', ' ', $datoscurlprimer[7][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
                              $ml1=divlogro($datoscurlprimer[8][0], 'ML', 1);
                              $ml2=divlogro($datoscurlprimer[8][0], 'ML', 2);
                              $altalogro=divlogro($datoscurlprimer[10][0], 'ALTA', 1);
                              $bajalogro=divlogro($datoscurlprimer[10][0], 'BAJA', 2);
                              $runline1factor=divlogro($datoscurlprimer[9][0], 'RL', 1);
                              $runline2factor=divlogro($datoscurlprimer[9][0], 'RL', 3);
                              $runline1=divlogro($datoscurlprimer[9][0], 'RL', 2);
                              $runline2=divlogro($datoscurlprimer[9][0], 'RL', 4);
                              $deporte=4;
                                              
                              //// medio tiempo 
              $ml15=divlogro($datoscurlprimer[11][0], 'ML', 1); $ml25=divlogro($datoscurlprimer[11][0], 'ML', 2);
              $runline15=divlogro($datoscurlprimer[12][0], 'RL', 2); $runline15factor=divlogro($datoscurlprimer[12][0], 'RL', 1);
              $runline25=divlogro($datoscurlprimer[12][0], 'RL', 4); $runline25factor=divlogro($datoscurlprimer[12][0], 'RL', 3);
              $altalogro5=divlogro($datoscurlprimer[13][0], 'ALTA', 1); $altafactor5=str_replace('_ZZ', ' ', $datoscurlprimer[3][0]); $altafactor5=str_replace('ZZ_', ' ', $altafactor5); $altafactor5=str_replace('-tt-', ' ', $altafactor5);
              $bajalogro5=divlogro($datoscurlprimer[13][0], 'BAJA', 2); $altabaja5=str_replace('_ZZ', ' ', $datoscurlprimer[3][0]); $altabaja5=str_replace('ZZ_', ' ', $altabaja5); $altabaja5=str_replace('-tt-', ' ', $altabaja5);
              
              
                    echo '<br>'.$competicion.'<br>';  
                    echo '<br>'.$horajuego.'<br>';
                    
                    echo '<br>'.$equipo1.' ML '.$ml1.' RUNLINE '.$runline1.' factor '.$runline1factor.' ALTA '.$altalogro.' factor '.$altabaja.'<br>';
                    echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml15.' RUNLINE '.$runline15.' factor '.$runline15factor.' ALTA5 '.$altalogro5.' factor '.$altafactor5.'<br>';
              echo '<br>'.$equipo2.' ML '.$ml2.' RUNLINE '.$runline2.' factor '.$runline2factor.' BAJA '.$bajalogro.' factor '.$altabaja.'<br>';
                    echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml25.' RUNLINE '.$runline25.' factor '.$runline25factor.' BAJA5 '.$bajalogro5.' factor '.$altabaja5.'<br>';
                                              }         
                    
                    if(isset($datoscurlprimer[1][0])){                   
                                     
                  
          
                  $parseconp2=0;
                  $yaestajuego = 0;
                  $yaestaequipo1 = 0;
                                $yaestaequipo2 = 0;
                                $yaestaequipo1cod = 0;
                                $yaestaequipo2cod = 0;
                      $yaestajuegohorajuego = 0;
                      $equipo1=trim($equipo1);
                      $equipo2=trim($equipo2);
                      if(strlen($equipo1)>0 OR strlen($equipo2)>0){ 
                  foreach ($ArrayJuegos as $clave => $valor2) {
                    if($valor2["deportep2"]=="futbolamericano" OR $valor2["deportep2"]=="99999"){
                    foreach ($ArrayEquipos as  $ArrayEquipos2) {
                
                      if($ArrayEquipos2["deportep1"] == $deporte ){
                                
                                  
                                  
                                
                                  
                      if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo1)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo1))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo1 <> '') {
                
                      $yaestaequipo1 = 1;
                      $yaestaequipo1cod = $ArrayEquipos2["Id_p1equiposp1"];
                      
                      }
                      if (trim(strtolower($ArrayEquipos2["nom_parley"])) == trim(strtolower($equipo2)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo2))  && $ArrayEquipos2["deportep1"] == $deporte && $equipo2 <> '') {
                      $yaestaequipo2 = 1;
                      $yaestaequipo2cod = $ArrayEquipos2["Id_p1equiposp1"];
                      
                      }
      
          
                    
                      if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
                       
                    if ($valor2["idequipo1p2"] == $yaestaequipo1cod && $valor2["idequipo2p2"] == $yaestaequipo2cod) {
                    $parseconp2 = $valor2["parseconp2"];
                    $idjuego = $valor2["Id_p2juegosp2"];
                    $yaestajuego = 1;
                    }
                        
                  }	
                  }
                 
                    }
                    
                    }}
                    if($idjuego > 0){
                      echo $idjuego."parseconp2=" . $parseconp2 . '<br>';
                      if ($JuegosQEstan == ',') {
                        $JuegosQEstan = $idjuego;
                        } else {
                        $JuegosQEstan = ',' . $JuegosQEstan . ',' . $idjuego;
                        }
                        $juego++;
                    }else{
                      
          
                      echo 'REVISAR LOS EQUIPOS PARA INGRESAR JUEGO <br>';
                    } }
                
                    $nov = "";
                    if ($parseconp2 == 2) {
                    if ($idjuego > 0) {
                
                      // SI ACTUALIZA LOS LOGROS POR MARA, ESTE CODIGO VA A SER QUE ACTUALIZE EL JUEGO
                      $insertSQL24 = sprintf(
                        "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 23 */ UPDATE p2juegos 
                      SET  p2vecesactualizado=p2vecesactualizado+1		
                      WHERE 
                      Id_p2juegosp2 = %s",                  
                        GetSQLValueString($idjuego, "int")
                        );
                        //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                        $Result24 = mysqli_query($conexionbanca, $insertSQL24);
                
                      $Fechahorasella = $horajuego.' '.$inicio;
                                $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                                $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
                      $logrodate = $Fechahorasella;
                      
                //echo 'aqui';
                
                      if ($deporte <> 6) {
                        $tipojugada = 'ML';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = 'ML';
                        list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = 'RL';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline1factor);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = 'RL';
                        list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline2factor);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = 'A';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                        $tipojugada = 'B';
                        list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = 'SI';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $SI, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                        $tipojugada = 'NO';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $NO, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                        $tipojugada = 'AP';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                        $tipojugada = 'AP';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $AP2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                
                        $tipojugada = 'AG';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $HCE1factor);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                        $tipojugada = 'BG';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $HCE2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $HCE2factor);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                        $tipojugada = 'SRL';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $Srunline1, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline1factor);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = 'SRL';
                        list($logroactualizado) = verificarlogro($yaestaequipo2cod, $Srunline2, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $Srunline2factor);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                
                        //var_dump($datoscurl2223[25][0]);
                
                
                
                
                        $tipojugada = 'EML';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                        $tipojugada = 'E5ML';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $empate5, $tipojugada, $idjuego, 0, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                
                
                        $tipojugada = '5ML';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $ml15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = '5ML';
                        list($logroactualizado) = verificarlogro($yaestaequipo2cod, $ml25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $nov);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = '5RL';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $runline15, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $runline15factor);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = '5RL';
                        list($logroactualizado) = verificarlogro($yaestaequipo2cod, $runline25, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $runline25factor);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = '5A';
                        list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro5, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altafactor5);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                
                
                        $tipojugada = '5B';
                        list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro5, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $altabaja5);
                        if ($logroactualizado == 1) {
                        $la++;
                        $logroactualizado = 0;
                        }
                      } else {
                      } //finaliza la inversion de los equipos si es futbol
                      }}
                      if ($row_Recordset18D['Swicht'] == 2) {
                      if($idjuego==0){
                
                        $Fechahorasella = $horajuego.' '.$inicio;
                                $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                                $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
                      $logrodate = $Fechahorasella;
                      
                echo $logrodate;
                        $query_Recordsetvrfjuego =  sprintf(
                          "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 24 */ SELECT  
                  deportep2
                      FROM  p2juegos
                      WHERE 
                      iniciodtp2=%s
                      AND idequipo1p2=%s
                      AND idequipo2p2=%s",
                          GetSQLValueString($FechaTxt . ' 00:00:00', "date"),
                          GetSQLValueString($yaestaequipo1cod, "int"),
                          GetSQLValueString($yaestaequipo2cod, "int")
                          );
                          $Recordsetvrfjuego = mysqli_query($conexionbanca, $query_Recordsetvrfjuego) or die(mysqli_error($conexionbanca));
                          $row_Recordsetvrfjuego = mysqli_fetch_assoc($Recordsetvrfjuego);
                          $totalRows_Recordsetvrfjuego = mysqli_num_rows($Recordsetvrfjuego);
                  
                        
                  
                          if ($totalRows_Recordsetvrfjuego == 0) {
                        
                        if ($yaestaequipo1 == 1 && $yaestaequipo2 == 1) {
                          
                  echo 'ESTE JUEGO SE CREARA'.$yaestaequipo1cod.'    '.$yaestaequipo2cod;
                  
                  
                  
                          $insertSQL = sprintf(
                            "/* PARSEADORES1 logros\parley.la_logros.php - QUERY 25 */ INSERT 
                  INTO p2juegos
                  (idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, jexterno, parseconp2 ) 
                  VALUES (%s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($yaestaequipo1cod, "int"),
                            GetSQLValueString($yaestaequipo2cod, "int"),
                            GetSQLValueString($deportenom, "text"),
                            GetSQLValueString($competicion, "text"),
                            GetSQLValueString($logrodate, "date"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(2, "int")
                          );
                          $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                          
                        
                        }}
                         
                      }}
                         $idjuego = 0;
                
                                        
                                        
                                        
                                        }}}}
                                                }
    }
 }
 
/*
$YAKE='Algodoneros De Guasave';

 //var_dump($par_juego_sin_array);

 foreach ($par_juego_sin_array as $equipo_descubrir){
echo 'pase';
$caracteres1=strlen($equipo_descubrir["Primerequipo_sin"]);
$caracteres1=$caracteres1+2;
$caracteres2=strlen($equipo_descubrir["Primerequipo2_sin"]);
$caracteres2=$caracteres2+2;
echo '<br>'.$equipo_descubrir["Primerequipo_sin"].$caracteres1.' '.$equipo_descubrir["Primerequipo2_sin"].$caracteres2;
$equipo1_desglosado = explode(" ", $equipo_descubrir["Primerequipo_sin"]);
$equipo2_desglosado = explode(" ", $equipo_descubrir["Primerequipo2_sin"]);
  foreach ($ArrayEquipos as  $ArrayEquipos2) {
    if($ArrayEquipos2["deportep1"] == $equipo_descubrir["deporte_sin"] ){
//ESTE FOREACH ES EQUIPO1 DESGLOSADO
$coincidencia=0;
$coincidencia2=0;
foreach ($equipo1_desglosado as  $equipo1_desglosado1) { 
  
  
  $cadena=strval($ArrayEquipos2["nomequipop1"]);
  $buscado= strval($equipo1_desglosado1);
    // busco "lalala" en $cadena
  $buscado= "/".$buscado."/i";

  //var_dump($cadena);
  if (preg_match($buscado, $cadena)) {
    $coincidencia++;

    if($coincidencia>1){
      
      if(strlen($ArrayEquipos2["nomequipop1"]) <= $caracteres1){
        
       echo '<br>'.'<br>'.$ArrayEquipos2["nomequipop1"].'  '. $ArrayEquipos2["Id_p1equiposp1"].'<br>'.'<br>';
      }    }  
  }         
}
foreach ($equipo2_desglosado as  $equipo2_desglosado2) { 
  
  
  $cadena2=strval($ArrayEquipos2["nomequipop1"]);
  $buscado2= strval($equipo2_desglosado2);
    // busco "lalala" en $cadena
  $buscado2= "/".$buscado2."/i";

  //var_dump($cadena);
  if (preg_match($buscado2, $cadena2)) {
    $coincidencia2++;

    if($coincidencia2>1){
      
       echo '<br>'.'<br>DIEGO'.$ArrayEquipos2["nomequipop1"].'  '. $ArrayEquipos2["Id_p1equiposp1"].'<br>'.'<br>';
      }      
  }         
}
  }}}

*/
  echo 'FIN 20';
  

 
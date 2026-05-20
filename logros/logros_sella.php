<?php 

if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbancaprueba.php');

$inicio=fechaactualbd();
$tiempo_inicial = microtime(true);
$horasistema=horaactual();

$fechahora=$inicio.' '.$horasistema;
echo $fechahora;

$fech=fechaactualbd();
$horasistema=horaactual();
$fecha=fechaactualbd();
$hora=horaactual();
//parseadores2.us.to/includes/108.json
$fechahora=$fecha.' '.$hora;
echo '.<br>';
echo $fechahora.'<br>';

$query_Recordset1_alertas = sprintf(
        "/* PARSEADORES1 logros\logros_sella.php - QUERY 1 */ SELECT * FROM 
alertas
WHERE  
idalertas=40",
        GetSQLValueString($fecha, "date")
    );
    $Recordset1_alertas = mysqli_query($conexionbanca, $query_Recordset1_alertas) or die(mysqli_error($conexionbanca));
    $row_Recordset1_alertas = mysqli_fetch_assoc($Recordset1_alertas);
    $totalRows_Recordset1_alertas = mysqli_num_rows($Recordset1_alertas);
    echo 'Idalertas= '.$row_Recordset1_alertas['Idalertas'].'<br>';

    $mini_para_repetir='-'.$row_Recordset1_alertas['mini_para_repetir'].' second';
    $tiemponorepeticion = strtotime($mini_para_repetir, strtotime($hora)) ;
    $tiemponorepeticion = date('H:i:s', $tiemponorepeticion);
    $tiemponorepeticion = $fecha.' '.$tiemponorepeticion;
    //echo 'tiemponorepeticion= '.$tiemponorepeticion.'<br>';


    $min_para_reportar='-'.$row_Recordset1_alertas['min_para_reportar'].' minute';
    $tiemporeportar = strtotime($min_para_reportar, strtotime($hora)) ;
    $tiemporeportar = date('H:i:s', $tiemporeportar);
    $tiemporeportar = $fecha.' '.$tiemporeportar;
    //echo '$tiemporeportar= '.$tiemporeportar.'<br>';

    if($row_Recordset1_alertas['horainicio']<$hora & $row_Recordset1_alertas['horafin']>$hora){}else{
        echo 'no esta en el rango de horas de trabjo si desea que se ejecute modificque la hora de ejecucion permitida<br>';}
        if($row_Recordset1_alertas['activo_archivo']==0){}else{
        echo 'no esta activo el codigo por lo tanto no se ejecutara modifiquelo en alertas para que se pueda ejecutar<br>';}
        if($tiemponorepeticion>$row_Recordset1_alertas['ultima_bien']){}else{
        echo 'no a pasado el tiempo para que se pueda ejecutar de nuevo si desea que se ejecute antes redusca o elimine el tiempo de reposo entre ejecucion en alertas para que se pueda ejecutar<br>';}
        
//hora de inicio y hora de fin y si esta activo
if($row_Recordset1_alertas['horainicio']<$hora & $row_Recordset1_alertas['horafin']>$hora & $row_Recordset1_alertas['activo_archivo']==0 & $tiemponorepeticion>$row_Recordset1_alertas['ultima_bien']){




$query_Recordset111 = sprintf("/* PARSEADORES1 logros\logros_sella.php - QUERY 2 */ SELECT * 
	FROM 
	cookies 
	WHERE
    id_cookie = 3 AND cookinombre = %s
    LIMIT 1",
	GetSQLValueString("Sella", "text"));   
$Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
$row_Recordset111 = mysqli_fetch_assoc($Recordset111);
$totalRows_Recordset111 = mysqli_num_rows($Recordset111);


$cookiefull=$row_Recordset111['cookiefull'];
$cookie='Cookie:'.$cookiefull;


$query_RecordsetLG =  sprintf(
	"/* PARSEADORES1 logros\logros_sella.php - QUERY 3 */ SELECT
	Id_p3logrosp3, idjuegop3, equipop3, tipojugadap3, logroABoRLp3, logrop3
	FROM  
	p3logros
	WHERE logrodtp3 >= %s  AND Id_p3logrosp3 >= 0 ORDER BY Id_p3logrosp3 DESC",
	GetSQLValueString($inicio . ' 00:00:00', "date")
  );


  if ($resultLG = mysqli_query($conexionbanca, $query_RecordsetLG) or die(mysqli_error($conexionbanca))) {
	while ($rowLG = $resultLG->fetch_array()) {
	  $ArrayLogros[] = $rowLG;
	}
	mysqli_free_result($resultLG);
  }


  $query_RecordsetAE =  sprintf(
	"/* PARSEADORES1 logros\logros_sella.php - QUERY 4 */ SELECT
   Id_p1equiposp1,nomequipop1,deportep1,nomsella, array_sella, nomequipop1
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


  $ArrayJuegos[] = array('Id_p2juegosp2' => '99999', 'nomequipop11' => '99999', 'nommara1' => '99999', 'nommarapais1' => '99999', 'idequipo1p2' => '99999', 'nomequipop12' => '99999', 'nommara2' => '99999', 'nommarapais2' => '99999', 'idequipo2p2' => '99999', 'iniciodtp2' => '99999', 'deportep2' => '99999', 'parseconp2' => '99999');

  $query_RecordsetAJ =  sprintf(
	"/* PARSEADORES1 logros\logros_sella.php - QUERY 5 */ SELECT
	Id_p2juegosp2, idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, parseconp2
	FROM  
	p2juegos
	WHERE 
	iniciodtp2 >= %s  ORDER BY Id_p2juegosp2 DESC",
	GetSQLValueString($fechahora, "date")
  );


  if ($resultAJ = mysqli_query($conexionbanca, $query_RecordsetAJ) or die(mysqli_error($conexionbanca))) {
	while ($rowAJ = $resultAJ->fetch_array()) {
	  $ArrayJuegos[] = $rowAJ;
	}
	mysqli_free_result($resultAJ);
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
        "/* PARSEADORES1 logros\logros_sella.php - QUERY 6 */ INSERT 
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
        "/* PARSEADORES1 logros\logros_sella.php - QUERY 7 */ INSERT 
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
        "/* PARSEADORES1 logros\logros_sella.php - QUERY 8 */ UPDATE p3logros 
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
        "/* PARSEADORES1 logros\logros_sella.php - QUERY 9 */ INSERT 
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




  $query_Recordset18D =  sprintf(
	"/* PARSEADORES1 logros\logros_sella.php - QUERY 10 */ SELECT  
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

$query_Recordset1 =  sprintf(
	"/* PARSEADORES1 logros\logros_sella.php - QUERY 11 */ SELECT  
*
			FROM  opciones_parley
			WHERE id_opcionp=%s
			LIMIT 3",
	GetSQLValueString(3, "int")
);
		$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
		$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
		$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

		$JuegosQEstan = ',';
		$juego=0;

$ARRAY=explode('*',$row_Recordset1['parseo_sella']);

foreach ($ARRAY as $link){

	$link2=explode('-',$link);
if($link2[0]<>'' && $link2[0]==0 OR $link2[0]==4 OR $link2[0]==1){
	
	
	$link=$link2[1]; $deporte=$link2[0]; $fecha=$inicio;
	$FechaTxt = fechaactualbd();
	if(isset($link2[2])){
		$link=$link2[1].'-'.$link2[2];
	   }
	
$link3=$link;
$link3 = str_replace('%20', ' ', $link);
//echo $link3;

$link='https://sellatuparley.com/sport/games/byleague'.$link.$fecha;
$url=$link;

echo $url.'<br>';



	 $ch = curl_init();

	 curl_setopt($ch, CURLOPT_URL, $url);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	 
	 curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); 
     curl_setopt($ch, CURLOPT_TIMEOUT, 7); //timeout in seconds

	 $headers = array();
	 $headers[] = 'Authority: www.sellatuparley.com';
     $headers[] = 'Accept-language: es-US,es-419;q=0.9,es;q=0.8,en;q=0.7';
     $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
	 $headers[] = 'Cache-Control: max-age=0';
	 $headers[] = 'Sec-ch-ua: ^\^"Not_A Brand^\^";v=^\^"99^\^", ^\^"Google Chrome^\^";v=^\^"109^\^", ^\^"Chromium^\^";v=^\^"109^\^"';
	 $headers[] = 'Sec-Ch-Ua-Mobile: ?1';
	 $headers[] = 'Sec-Ch-Ua-Platform: ^^Android^^\"\"';
	 $headers[] = 'User-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Mobile Safari/537.36';
     $headers[] = 'Sec-Fetch-Site: none';
	 $headers[] = 'Sec-Fetch-Mode: navigate';
	 $headers[] = 'Sec-Fetch-User: ?1';
	 $headers[] = 'Sec-Fetch-Dest: document';
	 $headers[] = $cookie;
	 
   //  $headers[] = $row_Recordset111['num_carrera'];
	 
	 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	 
	 $result2 = curl_exec($ch);
	 
	 curl_close($ch);





//$str_datos = get_url_contents($url); 
//$fp = fopen('capital_dividendos_conall.json', 'x'); 
//fwrite($fp, $str_datos); 
//fclose($fp);
$fulldatos = json_decode($result2,true); 
//echo '<br>';
//var_dump($fulldatos); 
if($fulldatos<>NULL){

	
echo '<br>';
$x=0;
foreach($fulldatos as $Parseo) {
	
	
	$sacocompeticion= explode('/', $link3);
$competicion=$sacocompeticion[2];

	//var_dump($sacocompeticion[2]);
	
if($Parseo['Team']['0']['first']==0){
 $equipo2=$Parseo['Team']['0']['team_name'];  
 $equipo1=$Parseo['Team']['1']['team_name'];
}else{$equipo1=$Parseo['Team']['0']['team_name'];
	$equipo2=$Parseo['Team']['1']['team_name'];}



if($deporte==0){///BEISBOL LOGROS
	$deportenom='beisbol';
	$ml1=$Parseo['odds']['FT']['1']['odd']; $ml2=$Parseo['odds']['FT']['2']['odd'];
	$altalogro=$Parseo['odds']['FT']['5']['odd']; $altafactor=$Parseo['odds']['FT']['5']['factor'];
	$bajalogro=$Parseo['odds']['FT']['6']['odd']; $bajafactor=$Parseo['odds']['FT']['6']['factor'];
	
	$runline1=$Parseo['odds']['FT']['3']['odd']; $runline1factor=$Parseo['odds']['FT']['3']['factor'];
	$runline2=$Parseo['odds']['FT']['4']['odd']; $runline2factor=$Parseo['odds']['FT']['4']['factor'];
	$Srunline1=$Parseo['odds']['FT']['8']['odd']; $Srunline1factor=$Parseo['odds']['FT']['8']['factor'];
	$Srunline2=$Parseo['odds']['FT']['9']['odd']; $Srunline2factor=$Parseo['odds']['FT']['9']['factor'];
	$SI=$Parseo['odds']['FT']['14']['odd']; $NO=$Parseo['odds']['FT']['15']['odd']; 
	$AP1=$Parseo['odds']['FT']['16']['odd']; $AP2=$Parseo['odds']['FT']['17']['odd'];
	$HCE1=$Parseo['odds']['FT']['18']['odd']; $HCE1factor=$Parseo['odds']['FT']['18']['factor'];
	$HCE2=$Parseo['odds']['FT']['19']['odd']; $HCE2factor=$Parseo['odds']['FT']['19']['factor'];
	
	//// medio tiempo 
	$ml15=$Parseo['odds']['HT']['1']['odd']; $ml25=$Parseo['odds']['HT']['2']['odd'];
	$runline15=$Parseo['odds']['HT']['3']['odd']; $runline15factor=$Parseo['odds']['HT']['3']['factor'];
	$runline25=$Parseo['odds']['HT']['4']['odd']; $runline25factor=$Parseo['odds']['HT']['4']['factor'];
	$altalogro5=$Parseo['odds']['HT']['5']['odd']; $altafactor5=$Parseo['odds']['HT']['5']['factor'];
	$bajalogro5=$Parseo['odds']['HT']['6']['odd']; $bajafactor5=$Parseo['odds']['HT']['6']['factor'];
	//echo '<br>'.$equipo1.'<br>';
	echo '<br>'.$equipo1.' ML '.$ml1.' RUNLINE '.$runline1.' factor '.$runline1factor.' SRUNLINE '.$Srunline1.' factor '.$Srunline1factor.' ALTA '.$altalogro.' factor '.$altafactor.' SI '.$SI.' anota primero1 '.$AP1.' HCE '.$HCE1.' factor '.$HCE1factor.'<br>';
	echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml15.' RUNLINE '.$runline15.' factor '.$runline15factor.' ALTA '.$altalogro5.' factor '.$altafactor5.'<br>';
	
	
	echo '<br>'.$equipo2.' ML '.$ml2.' RUNLINE '.$runline2.' factor '.$runline2factor.' SRUNLINE '.$Srunline2.' factor '.$Srunline2factor.' BAJA '.$bajalogro.' factor '.$bajafactor.' NO '.$NO.' anota primero2 '.$AP2.' HCE '.$HCE2.' factor '.$HCE2factor.'<br>';
	echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml25.' RUNLINE '.$runline25.' factor '.$runline25factor.' ALTA '.$bajalogro5.' factor '.$bajafactor5.'<br>';
	echo $Parseo['time'].'<br>'.'<br>';
	

	}elseif($deporte==2){///FUTBOL LOGROS
		$deportenom='futbol';
	//var_dump($Parseo['odds']['HT']).'<br>';
	
	$ml1=$Parseo['odds']['FT']['1']['odd']; $ml2=$Parseo['odds']['FT']['2']['odd'];
	$altalogro=$Parseo['odds']['FT']['5']['odd']; $altafactor=$Parseo['odds']['FT']['5']['factor'];
	$bajalogro=$Parseo['odds']['FT']['6']['odd']; $bajafactor=$Parseo['odds']['FT']['6']['factor'];
	
	$empate=$Parseo['odds']['FT']['7']['odd']; 
	
	
	//// medio tiempo 
	$ml15=$Parseo['odds']['HT']['1']['odd']; $ml25=$Parseo['odds']['HT']['2']['odd'];
	$altalogro5=$Parseo['odds']['HT']['5']['odd']; $altafactor5=$Parseo['odds']['HT']['5']['factor'];
	$bajalogro5=$Parseo['odds']['HT']['6']['odd']; $bajafactor5=$Parseo['odds']['HT']['6']['factor'];
	$empate5=$Parseo['odds']['HT']['7']['odd']; 


	echo '<br>'.$equipo1.' ML '.$ml1.' Empate '.$empate.' ALTA '.$altalogro.' factor '.$altafactor.'<br>';
echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml15.' EMPATE5 '.$empate5.' ALTA '.$altalogro5.' factor '.$altafactor5.'<br>';


echo '<br>'.$equipo2.' ML '.$ml2.' Empate '.$empate.' BAJA '.$bajalogro.' factor '.$bajafactor.'<br>';
echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml25.' EMPATE5 '.$empate5.' ALTA '.$bajalogro5.' factor '.$bajafactor5.'<br>';
echo $Parseo['time'].'<br>'.'<br>';


	}elseif($deporte==1){
		$deportenom='baloncesto';
		$ml1=$Parseo['odds']['FT']['1']['odd']; $ml2=$Parseo['odds']['FT']['2']['odd'];
		$altalogro=$Parseo['odds']['FT']['5']['odd']; $altafactor=$Parseo['odds']['FT']['5']['factor'];
		$bajalogro=$Parseo['odds']['FT']['6']['odd']; $bajafactor=$Parseo['odds']['FT']['6']['factor'];
		
		$runline1=$Parseo['odds']['FT']['3']['odd']; $runline1factor=$Parseo['odds']['FT']['3']['factor'];
		$runline2=$Parseo['odds']['FT']['4']['odd']; $runline2factor=$Parseo['odds']['FT']['4']['factor'];
		
		//// medio tiempo 
		$ml15=$Parseo['odds']['HT']['1']['odd']; $ml25=$Parseo['odds']['HT']['2']['odd'];
		$runline15=$Parseo['odds']['HT']['3']['odd']; $runline15factor=$Parseo['odds']['HT']['3']['factor'];
		$runline25=$Parseo['odds']['HT']['4']['odd']; $runline25factor=$Parseo['odds']['HT']['4']['factor'];
		$altalogro5=$Parseo['odds']['HT']['5']['odd']; $altafactor5=$Parseo['odds']['HT']['5']['factor'];
		$bajalogro5=$Parseo['odds']['HT']['6']['odd']; $bajafactor5=$Parseo['odds']['HT']['6']['factor'];
		

		echo '<br>'.$equipo1.' ML '.$ml1.' RUNLINE '.$runline1.' factor '.$runline1factor.' ALTA '.$altalogro.' factor '.$altafactor.'<br>';
		echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml15.' RUNLINE '.$runline15.' factor '.$runline15factor.' ALTA '.$altalogro5.' factor '.$altafactor5.'<br>';
		
		
		echo '<br>'.$equipo2.' ML '.$ml2.' RUNLINE '.$runline2.' factor '.$runline2factor.' BAJA '.$bajalogro.' factor '.$bajafactor.'<br>';
		echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml25.' RUNLINE '.$runline25.' factor '.$runline25factor.' ALTA '.$bajalogro5.' factor '.$bajafactor5.'<br>';
		echo $Parseo['time'].'<br>'.'<br>';

	}elseif($deporte==4){
		$deportenom='futbolamericano';
		$ml1=$Parseo['odds']['FT']['1']['odd']; $ml2=$Parseo['odds']['FT']['2']['odd'];
		$altalogro=$Parseo['odds']['FT']['5']['odd']; $altafactor=$Parseo['odds']['FT']['5']['factor'];
		$bajalogro=$Parseo['odds']['FT']['6']['odd']; $bajafactor=$Parseo['odds']['FT']['6']['factor'];
		
		$runline1=$Parseo['odds']['FT']['3']['odd']; $runline1factor=$Parseo['odds']['FT']['3']['factor'];
		$runline2=$Parseo['odds']['FT']['4']['odd']; $runline2factor=$Parseo['odds']['FT']['4']['factor'];
		
		//// medio tiempo 
		$ml15=$Parseo['odds']['HT']['1']['odd']; $ml25=$Parseo['odds']['HT']['2']['odd'];
		$runline15=$Parseo['odds']['HT']['3']['odd']; $runline15factor=$Parseo['odds']['HT']['3']['factor'];
		$runline25=$Parseo['odds']['HT']['4']['odd']; $runline25factor=$Parseo['odds']['HT']['4']['factor'];
		$altalogro5=$Parseo['odds']['HT']['5']['odd']; $altafactor5=$Parseo['odds']['HT']['5']['factor'];
		$bajalogro5=$Parseo['odds']['HT']['6']['odd']; $bajafactor5=$Parseo['odds']['HT']['6']['factor'];
		

	
echo '<br>'.$equipo1.' ML '.$ml1.' RUNLINE '.$runline1.' factor '.$runline1factor.' ALTA '.$altalogro.' factor '.$altafactor.'<br>';
echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml15.' RUNLINE '.$runline15.' factor '.$runline15factor.' ALTA '.$altalogro5.' factor '.$altafactor5.'<br>';


echo '<br>'.$equipo2.' ML '.$ml2.' RUNLINE '.$runline2.' factor '.$runline2factor.' BAJA '.$bajalogro.' factor '.$bajafactor.'<br>';
echo ' MEDIO TIEMPO LOGROS'.' ML5 '.$ml25.' RUNLINE '.$runline25.' factor '.$runline25factor.' ALTA '.$bajalogro5.' factor '.$bajafactor5.'<br>';
echo $Parseo['time'].'<br>'.'<br>';
	}		
	
	
if(isset($equipo1)){
//esto solo se utiliza para crear juegos
	if(empty($ArrayJuegos)){

		$ArrayJuegos[] = array('Id_p2juegosp2' => '99999', 'nomequipop11' => '99999', 'nommara1' => '99999', 'nommarapais1' => '99999', 'idequipo1p2' => '99999', 'nomequipop12' => '99999', 'nommara2' => '99999', 'nommarapais2' => '99999', 'idequipo2p2' => '99999', 'iniciodtp2' => '99999', 'deportep2' => '99999', 'parseconp2' => '99999');

	}
	//fin de crear juegos
	$parseconp2=0;
	$yaestajuego = 0;
	$yaestaequipo1 = 0;
                $yaestaequipo2 = 0;
                $yaestaequipo1cod = 0;
                $yaestaequipo2cod = 0;
			$yaestajuegohorajuego = 0;
	foreach ($ArrayJuegos as $clave => $valor2) {
		foreach ($ArrayEquipos as  $ArrayEquipos2) {

          $sellamuchos=$ArrayEquipos2["array_sella"]; 

		  if($ArrayEquipos2["deportep1"] == $deporte){
                $lop = explode(",,", $sellamuchos);
                foreach ($lop as $datos) {
                  
                  
                
                  
		  if (trim(strtolower($datos)) == trim(strtolower($equipo1)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo1))  && $ArrayEquipos2["deportep1"] == $deporte) {

			$yaestaequipo1 = 1;
			$yaestaequipo1cod = $ArrayEquipos2["Id_p1equiposp1"];
	
		  }
		  if (trim(strtolower($datos)) == trim(strtolower($equipo2)) OR trim(strtolower($ArrayEquipos2["nomequipop1"])) == trim(strtolower($equipo2))  && $ArrayEquipos2["deportep1"] == $deporte) {
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
		}
		
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
			echo 'REVISAR LOS EQUIPOS PARA INGRESAR JUEGO <br>';
		}

		if ($parseconp2 == 3) {
			
		$nov = "";
		if ($idjuego > 0) {

			// SI ACTUALIZA LOS LOGROS POR MARA, ESTE CODIGO VA A SER QUE ACTUALIZE EL JUEGO
			$insertSQL24 = sprintf(
				"/* PARSEADORES1 logros\logros_sella.php - QUERY 12 */ UPDATE p2juegos 
			SET  p2vecesactualizado=p2vecesactualizado+1		
			WHERE 
			Id_p2juegosp2 = %s",                  
				GetSQLValueString($idjuego, "int")
			  );
			  //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
			  $Result24 = mysqli_query($conexionbanca, $insertSQL24);

			$Fechahorasella = $Parseo['time'];
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
			  list($logroactualizado) = verificarlogro($yaestaequipo1cod, $altalogro, $tipojugada, $idjuego, 1, $logrodate, $ArrayLogros, $Fechahorasella, $altafactor);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }
			  $tipojugada = 'B';
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $bajafactor);
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
			  list($logroactualizado) = verificarlogro($yaestaequipo2cod, $bajalogro5, $tipojugada, $idjuego, 2, $logrodate, $ArrayLogros, $Fechahorasella, $bajafactor5);
			  if ($logroactualizado == 1) {
				$la++;
				$logroactualizado = 0;
			  }
			} else {
			} //finaliza la inversion de los equipos si es futbol
		  }
		   }
		   if ($row_Recordset18D['Swicht'] == 3) {

		   if($idjuego==0){

			$Fechahorasella = $Parseo['time'];
                $Fechahorasella = strtotime('-6 hour', strtotime($Fechahorasella));
                $Fechahorasella = date('Y-m-d H:i:s', $Fechahorasella);
			$logrodate = $Fechahorasella;
			$query_Recordsetvrfjuego =  sprintf(
				"/* PARSEADORES1 logros\logros_sella.php - QUERY 13 */ SELECT  
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
				  "/* PARSEADORES1 logros\logros_sella.php - QUERY 14 */ INSERT 
INTO p2juegos
(idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, jexterno, parseconp2 ) 
VALUES (%s, %s, %s, %s, %s, %s, %s)",
				  GetSQLValueString($yaestaequipo1cod, "int"),
				  GetSQLValueString($yaestaequipo2cod, "int"),
				  GetSQLValueString($deportenom, "text"),
				  GetSQLValueString($competicion, "text"),
				  GetSQLValueString($logrodate, "date"),
				  GetSQLValueString(0, "int"),
				  GetSQLValueString(3, "int")
				);
				$Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
			  
			
			}}
		   
		}}
		   $idjuego = 0;
		
}}



}
}
}

if ($la > 0) {
    $msj = 'SELLATUPARLEY  Se act ' . $la . ' lg  ';
    $sitelegram = 1;
  }
 
  if ($sitelegram == 1) {
    $msjx = utf8_encode($msj);
    $post = [
      'chat_id' => -4098425891,
      'text' => $msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_exec($ch);
    curl_close($ch);
  }

  if ($juego <> 0) {

	$fechahora5 = strtotime('-5 minute', strtotime($fechahora));
	$fechahora5 = date('Y-m-d H:i:s', $fechahora5);



	///.$JuegosQEstan
	if ($row_Recordset18D['Swicht'] == 3) {
	  $query_Recordset1b = sprintf(
		"/* PARSEADORES1 logros\logros_sella.php - QUERY 15 */ SELECT Id_p2juegosp2 FROM p2juegos WHERE 
iniciodtp2 > %s AND
idequipo1p2 > 0 AND
idequipo1p2 > 0 AND
parseconp2 = 3 AND 
  jexterno = 0 
ORDER BY iniciodtp2 
DESC",

		GetSQLValueString($fechahora, "date")
	  );
	}
	$Recordset1b = mysqli_query($conexionbanca, $query_Recordset1b) or die(mysqli_error($conexionbanca));
	$row_Recordset1b = mysqli_fetch_assoc($Recordset1b);
	$totalRows_Recordset1b = mysqli_num_rows($Recordset1b);
	$juxp = 0;
	if ($totalRows_Recordset1b > 0) {

	 
	}
  }
}


$tiempo_final = microtime(true);
//Restamos los dos tiempos
$tiempo_ejecucion = $tiempo_final - $tiempo_inicial;

echo 'La página tard&oacute; '.round($tiempo_ejecucion,4).' segundos en ejecutarse';



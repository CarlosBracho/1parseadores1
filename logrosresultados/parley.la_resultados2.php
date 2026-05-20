<?php

if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
echo fechaactualbd().' fecha hoy<br>';

//echo "  ".$_SESSION['MM_nom_usuario'];
$inicio=fechaactualbd();

$horasistema=horaactual();

$query_Recordset18D =  sprintf(
	"/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 1 */ SELECT  
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




  $query_RecordsetAE =  sprintf(
	"/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 2 */ SELECT
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
	"/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 3 */ SELECT
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

$horda=$FechaTxtayer;

//https://sellatuparley.com/results/index/2022-04-28
//$urlhoy='https://sellatuparley.com/results/index/'.$FechaTxt;
$urlayer='http://parseadores1.us.to/logrosresultados/autosave.html';
//$url='https://sellatuparley.com/results/index/';
$file='autosave.html';
echo $urlayer.' fecha<br>'.$FechaTxtayer;


//$filePath= 'C:/laragon/www/proyectosglobales/primertrabajo/apuestas/new/logrosresultados/sellatuparley.html';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $urlayer);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 50);
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


//parley.laimgdeportes3.png-tt-onerrorthi


$datoscurl=explode('NOMBRE-tt-DE-tt-LA-tt-LIGA-tt-Y-tt-CANTIDAD-tt-DE-tt-JUEGOS', $datoscurl);

foreach ($datoscurl as $datoscurl2) {

    if(!strpos($datoscurl2, 'OCTYPE-tt-html-tt-html')){
      //esto solo se utiliza para crear juegos
      
      



preg_match_all("(-tt----tt-tr-tt-id(.*)-tt-td-tt-colspan13-tt-classtext-left-tt-fecha-juego-tt-p-tt-(.*)-tt---tt-(.*))siU", $datoscurl2, $datoscurl222);
$competicion=str_replace('-tt-', ' ', $datoscurl222[2][0]);

echo $competicion.'<br>'.'<br>'.'<br>';

$datoscurl3=explode('INFORMACIÓN-tt-DE-tt-JUEGO-tt-Y-tt-TIPOS-tt-DE-tt-APUESTA', $datoscurl2);


foreach ($datoscurl3 as $datoscurl33) {
  $reinicio=0; 
  if(!strpos($datoscurl33, 'EVENTO-tt-FUTURO')){

    if(!strpos($datoscurl33, 'JUEGOS-tt-DE-tt-LA-tt-LIGA')){

      if(strpos($datoscurl33, 'H+R+E')){ //BEISBOLL

      //echo $datoscurl33.'<br>'.'<br>'.'<br>'; 

preg_match_all("(-tt----tt-tr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-p(.*)p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pGanarp(.*)pAltaBajap(.*)pSuper-tt-RunLinep(.*)pAB-tt-5to-tt-Innp(.*)pGanar-tt-2da-tt-M.p(.*)pAnota-tt-1erop(.*)CAMPOS-tt-VACIOS-tt----tt-tr-tt-tr-tt-classborder-table(.*)EQUIPO-tt-A-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt-(.*)-tt-span-tt-classjugador(.*)span-tt-span-tt-td-tt----tt-RESULTADOS-tt-A-tt----tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan2-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan2-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan2-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan2-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan2-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan2-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-CAMPOS-tt-VACIOS-tt----tt-tr-tt-tr-tt-classborder-table(.*)EQUIPO-tt-B-tt----tt-td-tt-span-tt-classopcion-a-tt----tt-NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt-(.*)-tt-span-tt-classjugador(.*)span-tt-span-tt-td-tt----tt-RESULTADOS-tt-B-tt----tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt----tt-RESULTADO-tt----tt----tt-RESULTADO-tt----tt----tt-RESULTADO-tt----tt----tt-CAMPOS-tt-VACIOS-tt----tt-tr-tt----tt-(.*))siU", $datoscurl33, $datoscurlprimer);
          
//var_dump($datoscurlprimer).'<br>'.'<br>'.'<br>';  


if(isset($datoscurlprimer[1][0])){
  $horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
  $picher1=str_replace('-tt-', ' ', $datoscurlprimer[11][0]);
  $picher2=str_replace('-tt-', ' ', $datoscurlprimer[26][0]);
  $equipo1=str_replace('-tt-', ' ', $datoscurlprimer[10][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
  $equipo2=str_replace('-tt-', ' ', $datoscurlprimer[25][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
  $juegocompleto1=$datoscurlprimer[12][0];
  $juegocompleto2=$datoscurlprimer[27][0];
  $anotaprimero=$datoscurlprimer[20][0];  $anotaprimero=str_replace('_ZZ', ' ', $anotaprimero); $anotaprimero=str_replace('ZZ_', ' ', $anotaprimero); $anotaprimero=str_replace('-tt-', ' ', $anotaprimero);
  $SINO=$datoscurlprimer[21][0];
  if($SINO=='SI'){$SINO=1;}else{$SINO=2;}
  
  $HRE=$datoscurlprimer[22][0];
  $juegomedio1=$datoscurlprimer[15][0];
  $juegomedio2=$datoscurlprimer[29][0];
  $deporte=0;
  
  echo '<br>'.$competicion.'<br>';  
  echo '<br>'.$horajuego.'<br>';
  
  echo '<br>'.$equipo1.' juego completo1: '.$juegocompleto1.' juego medio1: '.$juegomedio1.' Anota primero: '.$anotaprimero.' SI NO: '.$datoscurlprimer[21][0].' HRE: '.$HRE.'<br>';
    
    
    echo '<br>'.$equipo2.' juego completo2: '.$juegocompleto2.' juego medio2: '.$juegomedio2.'<br>';
   
      
           
  }


        
 


	$yaestaequipo1 = 0;
                $yaestaequipo2 = 0;
                $yaestaequipo1cod = 0;
                $yaestaequipo2cod = 0;
			$yaestajuegohorajuego = 0;
      if(strlen($equipo1)>0 OR strlen($equipo2)>0){ 
        
 
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
		
		
	}
		}
		
		}
     

   
     echo $yaestaequipo1cod.'<br>'.$yaestaequipo2cod.'<br>'; 
           
                 
           
          
                        $query_Recordset177 = sprintf(
                          "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 4 */ SELECT *
                        FROM  p2juegos
                        WHERE idequipo1p2 = %s AND idequipo2p2 = %s AND iniciodtp2 >= %s AND iniciodtp2 <= %s ",
              GetSQLValueString($yaestaequipo1cod, "int"),
              GetSQLValueString($yaestaequipo2cod, "int"),
                        GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
                        GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
                      );
                        $Recordset177 =mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
                        $row_Recordset177 = mysqli_fetch_assoc($Recordset177);
                        $totalRows_Recordset177 = mysqli_num_rows($Recordset177);

                        
                        $query_Recordset1444 = sprintf(
                          "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 5 */ SELECT * FROM p5resultadosj WHERE 
                          iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
                          GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
                          GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
                          GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
                      );
                      $Recordset1444 = mysqli_query($conexionbanca, $query_Recordset1444) or die(mysqli_error($conexionbanca));
                      $row_Recordset1444 = mysqli_fetch_assoc($Recordset1444);
                      $totalRows_Recordset1444 = mysqli_num_rows($Recordset1444);
            
                     if($totalRows_Recordset1444==0){
                      echo 'aqui estoy'.$row_Recordset177['Id_p2juegosp2'];
                     
                      if ($row_Recordset177['Id_p2juegosp2']>0) {
                        echo 'creando';
      
                        $insertSQL155 = sprintf(
                          "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 6 */ INSERT INTO p5resultadosj  
          (deportep5, juegop5, equipo1p5, equipo2p5, anotaprimerop5, iniciodtp5, tiemposjugadosp5,
           r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
           r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
           r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
          VALUES (%s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                          GetSQLValueString("beisbol", "text"),
                          GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
                          GetSQLValueString($equipo1, "text"),
                          GetSQLValueString($equipo2, "text"),
                          GetSQLValueString($anotaprimero, "text"),
                          GetSQLValueString($horda.' '.$horajuego, "date"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString($juegocompleto1, "int"),
                          GetSQLValueString($juegocompleto2, "int"),
                          GetSQLValueString($juegomedio1, "int"),
                          GetSQLValueString($juegomedio2, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString($SINO, "int"),
                          GetSQLValueString($HRE, "int"),
                          GetSQLValueString(0, "int")
                      );
                      $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
    
   
   
    }
  
    echo '<br>';
   
    $Fechacal=$FechaTxtayer;
  //include('../parley/carculojparley.php');
  }}//aqui esta el foreach de los juegos de beisbol
   
   
    if(strpos($datoscurl33, '4to-tt-CUARTO')){
    //echo $datoscurl33.'<br>'.'<br>'.'<br>';

    preg_match_all("(-tt----tt-tbodytr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-stylewidth:-tt-35-tt-p(.*)p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pFULL-tt-GAMEp(.*)p2da-tt-MITADp(.*)p3er-tt-CUARTOp(.*)p4to-tt-CUARTOp-tt-th-tt----tt-CAMPOS-tt-VACIOS-tt----tt-tr-tt-tr-tt-classborder-table(.*)NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt-br-tt-(.*)-tt-span-tt-classjugadorspan-tt-span-tt-td-tt----tt-RESULTADOS-tt-A-tt----tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-CAMPOS-tt-VACIOS-tt----tt-tr-tt-tr-tt-classborder-table(.*)NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt-br-tt-(.*)-tt-span-tt-classjugadorspan-tt-span-tt-td-tt----tt-RESULTADOS-tt-B-tt----tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-CAMPOS-tt-VACIOS(.*))siU", $datoscurl33, $datoscurlprimer);
          
//var_dump($datoscurlprimer).'<br>'.'<br>'.'<br>';  

if(isset($datoscurlprimer[1][0])){
  $horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
  $equipo1=str_replace('-tt-', ' ', $datoscurlprimer[7][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
  $equipo2=str_replace('-tt-', ' ', $datoscurlprimer[17][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
  $juegocompleto1=$datoscurlprimer[8][0];
  $juegocompleto2=$datoscurlprimer[18][0];
  
  $juegomedio1=$datoscurlprimer[9][0];
  $juegomedio2=$datoscurlprimer[19][0];

  $primeramitad=$juegocompleto1-$juegomedio1;
  $primeramitad2=$juegocompleto2-$juegomedio2;

  
  $deporte=1;
  
  echo '<br>'.$competicion.'<br>';  
  echo '<br>'.$horajuego.'<br>';
  
  echo '<br>'.$equipo1.' juego completo1: '.$primeramitad.' juego medio1: '.$juegomedio1.'<br>';
    
    
    echo '<br>'.$equipo2.' juego completo2: '.$primeramitad2.' juego medio2: '.$juegomedio2.'<br>';
   
      
           
  }


        
 

 
	$yaestaequipo1 = 0;
                $yaestaequipo2 = 0;
                $yaestaequipo1cod = 0;
                $yaestaequipo2cod = 0;
		
      if(strlen($equipo1)>0 OR strlen($equipo2)>0){ 
        
 
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
		
		
	}
		}
		
		}
     

   
     echo $yaestaequipo1cod.'<br>'.$yaestaequipo2cod.'<br>'; 
           
                 
     $query_Recordset177 = sprintf(
      "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 7 */ SELECT *
    FROM  p2juegos
    WHERE idequipo1p2 = %s AND idequipo2p2 = %s AND iniciodtp2 >= %s AND iniciodtp2 <= %s ",
GetSQLValueString($yaestaequipo1cod, "int"),
GetSQLValueString($yaestaequipo2cod, "int"),
    GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
    GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
  );
    $Recordset177 =mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
    $row_Recordset177 = mysqli_fetch_assoc($Recordset177);
    $totalRows_Recordset177 = mysqli_num_rows($Recordset177);

    echo $totalRows_Recordset177;

    $query_Recordset1444 = sprintf(
      "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 8 */ SELECT * FROM p5resultadosj WHERE 
      iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
      GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
      GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
      GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
  );
  $Recordset1444 = mysqli_query($conexionbanca, $query_Recordset1444) or die(mysqli_error($conexionbanca));
  $row_Recordset1444 = mysqli_fetch_assoc($Recordset1444);
  $totalRows_Recordset1444 = mysqli_num_rows($Recordset1444);

 if($totalRows_Recordset1444==0){
  echo 'aqui estoy'.$row_Recordset177['Id_p2juegosp2'];
 
  if ($row_Recordset177['Id_p2juegosp2']>0) {

      echo 'creando';
      $insertSQL1555 = sprintf(
          "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 9 */ INSERT INTO p5resultadosj  
(deportep5, juegop5, equipo1p5, equipo2p5, iniciodtp5, tiemposjugadosp5,
r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
VALUES (%s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
          GetSQLValueString("baloncesto", "text"),
          GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
          GetSQLValueString($equipo1, "text"),
          GetSQLValueString($equipo2, "text"),
          GetSQLValueString($horda.' '.$horajuego, "date"),
          GetSQLValueString(1, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString($juegomedio1, "int"),
          GetSQLValueString($juegomedio2, "int"),
          GetSQLValueString($primeramitad, "int"),
          GetSQLValueString($primeramitad2, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int"),
          GetSQLValueString(0, "int")
      );
      $Result1555 = mysqli_query($conexionbanca, $insertSQL1555) or die(mysqli_error($conexionbanca));


      
}    
echo '<br>';
   
  $Fechacal=$FechaTxtayer;
//include('../parley/carculojparley.php');
    }}
    
    
    if(!strpos($datoscurl33, '4to-tt-CUARTO') && strpos($datoscurl33, '2da-tt-MITAD')){

      preg_match_all("(-tt----tt-tbodytr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-stylewidth:-tt-35-tt-p(.*)p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pFULL-tt-GAMEp(.*)classtext-center-tt-p2da-tt-MITADp(.*)CAMPOS-tt-VACIOS(.*)NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt-br-tt-(.*)-tt-span-tt-classjugadorspan-tt-span-tt-td-tt----tt-RESULTADOS-tt-A-tt----tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-CAMPOS-tt-VACIOS(.*)NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt-br-tt-(.*)-tt-span-tt-classjugadorspan-tt-span-tt-td-tt----tt-RESULTADOS-tt-B-tt----tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-CAMPOS-tt-VACIOS(.*))siU", $datoscurl33, $datoscurlprimer);
      //echo $datoscurl33.'<br>'.'<br>'.'<br>'; 
      
      
      //var_dump($datoscurlprimer).'<br>'.'<br>'.'<br>';  
      
      if(isset($datoscurlprimer[1][0])){
        $horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
        $equipo1=str_replace('-tt-', ' ', $datoscurlprimer[6][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
        $equipo2=str_replace('-tt-', ' ', $datoscurlprimer[12][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
        $juegocompleto1=$datoscurlprimer[7][0];
        $juegocompleto2=$datoscurlprimer[13][0];
       
        $juegomedio1=$datoscurlprimer[8][0];
        $juegomedio2=$datoscurlprimer[14][0];

        $primeramitad=$juegocompleto1-$juegomedio1;
        $primeramitad2=$juegocompleto2-$juegomedio2;
      
        
        $deporte=2;
        
        echo '<br>'.$competicion.'<br>';  
        echo '<br>'.$horajuego.'<br>';
        
        echo '<br>'.$equipo1.' juego completo1: '.$juegocompleto1.' juego medio1: '.$juegomedio1.'<br>';
          
          
          echo '<br>'.$equipo2.' juego completo2: '.$juegocompleto2.' juego medio2: '.$juegomedio2.'<br>';
         
            
                 
        }
   
        $yaestaequipo1 = 0;
        $yaestaequipo2 = 0;
        $yaestaequipo1cod = 0;
        $yaestaequipo2cod = 0;

if(strlen($equipo1)>0 OR strlen($equipo2)>0){ 


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


}
}

}



echo $yaestaequipo1cod.'<br>'.$yaestaequipo2cod.'<br>'; 
   
         
$query_Recordset177 = sprintf(
"/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 10 */ SELECT *
FROM  p2juegos
WHERE idequipo1p2 = %s AND idequipo2p2 = %s AND iniciodtp2 >= %s AND iniciodtp2 <= %s ",
GetSQLValueString($yaestaequipo1cod, "int"),
GetSQLValueString($yaestaequipo2cod, "int"),
GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
);
$Recordset177 =mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
$row_Recordset177 = mysqli_fetch_assoc($Recordset177);
$totalRows_Recordset177 = mysqli_num_rows($Recordset177);


$query_Recordset1444 = sprintf(
"/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 11 */ SELECT * FROM p5resultadosj WHERE 
iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
);
$Recordset1444 = mysqli_query($conexionbanca, $query_Recordset1444) or die(mysqli_error($conexionbanca));
$row_Recordset1444 = mysqli_fetch_assoc($Recordset1444);
$totalRows_Recordset1444 = mysqli_num_rows($Recordset1444);

if($totalRows_Recordset1444==0){
echo 'aqui estoy'.$row_Recordset177['Id_p2juegosp2'];

if ($row_Recordset177['Id_p2juegosp2']>0) {

echo 'creando';
$insertSQL1555 = sprintf(
  "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 12 */ INSERT INTO p5resultadosj  
(deportep5, juegop5, equipo1p5, equipo2p5, iniciodtp5, tiemposjugadosp5,
r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
VALUES (%s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
  GetSQLValueString("futbol", "text"),
  GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
  GetSQLValueString($equipo1, "text"),
  GetSQLValueString($equipo2, "text"),
  GetSQLValueString($horda.' '.$horajuego, "date"),
  GetSQLValueString(1, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString($juegomedio1, "int"),
  GetSQLValueString($juegomedio2, "int"),
  GetSQLValueString($primeramitad, "int"),
  GetSQLValueString($primeramitad2, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(0, "int")
);
$Result1555 = mysqli_query($conexionbanca, $insertSQL1555) or die(mysqli_error($conexionbanca));



}    

   
    
echo '<br>';
   
  $Fechacal=$FechaTxtayer;
//include('../parley/carculojparley.php');
   
    }}//aqui termina Futbol

    if(!strpos($datoscurl33, '4to-tt-CUARTO') && !strpos($datoscurl33, '2da-tt-MITAD') && !strpos($datoscurl33, 'H+R+E')){

      preg_match_all("(-tt----tt-tbodytr-tt-classcategorias-juegos-tt----tt-HORA-tt-DE-tt-JUEGO-tt----tt-th-tt-classtext-center-tt-stylewidth:-tt-35-tt-p(.*)p-tt-th-tt----tt-TIPOS-tt-DE-tt-APUESTA-tt----tt-th-tt-classtext-center-tt-pFULL-tt-GAMEp(.*)classtext-center-tt-p3er-tt-TERCIOp-tt-th-tt----tt-CAMPOS-tt-VACIOS-tt----tt-tr-tt-tr-tt-classborder-table(.*)NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt-br-tt-(.*)-tt-span-tt-classjugadorspan-tt-span-tt-td-tt----tt-RESULTADOS-tt-A-tt----tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-ROW-tt-SPAN-tt----tt----tt-RESULTADO-tt----tt-td-tt-rowspan-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-CAMPOS-tt-VACIOS-tt----tt-tr-tt-tr-tt-classborder-table-tt(.*)NOMBRE-tt-EQUIPO-tt----tt-(.*)-tt-br-tt-(.*)-tt-span-tt-classjugadorspan-tt-span-tt-td-tt----tt-RESULTADOS-tt-B-tt----tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-RESULTADO-tt----tt-td-tt-label-tt-(.*)-tt-label-tt-td-tt----tt-CAMPOS-tt-VACIOS(.*))siU", $datoscurl33, $datoscurlprimer);
      //echo $datoscurl33.'<br>'.'<br>'.'<br>'; 
      
      
     
      
      if(isset($datoscurlprimer[1][0])){
        var_dump($datoscurlprimer).'<br>'.'<br>'.'<br>';  
        $horajuego=str_replace('-tt-', ' ', $datoscurlprimer[1][0]);
        $equipo1=str_replace('-tt-', ' ', $datoscurlprimer[5][0]); $equipo1=str_replace('_ZZ', ' ', $equipo1); $equipo1=str_replace('ZZ_', ' ', $equipo1);
        $equipo2=str_replace('-tt-', ' ', $datoscurlprimer[12][0]); $equipo2=str_replace('_ZZ', ' ', $equipo2); $equipo2=str_replace('ZZ_', ' ', $equipo2);
        $juegocompleto1=$datoscurlprimer[6][0];
        $juegocompleto2=$datoscurlprimer[13][0];
        $deporte=5;
        
        echo '<br>'.$competicion.'<br>';  
        echo '<br>'.$horajuego.'<br>';
        
        echo '<br>'.$equipo1.' juego completo1: '.$juegocompleto1.'<br>';
          
          
          echo '<br>'.$equipo2.' juego completo2: '.$juegocompleto2.'<br>';
         
            
                 
        }


        if(strlen($equipo1)>0 OR strlen($equipo2)>0){ 


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
          
          
          }
          }
          
          }
          
          
          
          echo $yaestaequipo1cod.'<br>'.$yaestaequipo2cod.'<br>'; 
             
                   
          $query_Recordset177 = sprintf(
          "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 13 */ SELECT *
          FROM  p2juegos
          WHERE idequipo1p2 = %s AND idequipo2p2 = %s AND iniciodtp2 >= %s AND iniciodtp2 <= %s ",
          GetSQLValueString($yaestaequipo1cod, "int"),
          GetSQLValueString($yaestaequipo2cod, "int"),
          GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
          GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
          );
          $Recordset177 =mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
          $row_Recordset177 = mysqli_fetch_assoc($Recordset177);
          $totalRows_Recordset177 = mysqli_num_rows($Recordset177);
          
          
          $query_Recordset1444 = sprintf(
          "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 14 */ SELECT * FROM p5resultadosj WHERE 
          iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
          GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
          GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
          GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
          );
          $Recordset1444 = mysqli_query($conexionbanca, $query_Recordset1444) or die(mysqli_error($conexionbanca));
          $row_Recordset1444 = mysqli_fetch_assoc($Recordset1444);
          $totalRows_Recordset1444 = mysqli_num_rows($Recordset1444);
          
          if($totalRows_Recordset1444==0){
          echo 'aqui estoy'.$row_Recordset177['Id_p2juegosp2'];
          
          if ($row_Recordset177['Id_p2juegosp2']>0) {
          
          echo 'creando';
          $insertSQL1555 = sprintf(
            "/* PARSEADORES1 logrosresultados\parley.la_resultados2.php - QUERY 15 */ INSERT INTO p5resultadosj  
          (deportep5, juegop5, equipo1p5, equipo2p5, iniciodtp5, tiemposjugadosp5,
          r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
          r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
          r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
          VALUES (%s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString("hockey", "text"),
            GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
            GetSQLValueString($equipo1, "text"),
            GetSQLValueString($equipo2, "text"),
            GetSQLValueString($horda.' '.$horajuego, "date"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString($juegocompleto1, "int"),
            GetSQLValueString($juegocompleto2, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int")
          );
          $Result1555 = mysqli_query($conexionbanca, $insertSQL1555) or die(mysqli_error($conexionbanca));
          
          
          
          }    
          
          echo '<br>';
   
  $Fechacal=$FechaTxtayer;
//include('../parley/carculojparley.php');
             
              }}//AQUI TERMINA HOCKEY
    

        }}}}}




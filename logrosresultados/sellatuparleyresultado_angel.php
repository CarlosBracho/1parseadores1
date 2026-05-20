<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
echo fechaactualbd().' fecha hoy<br>';

//echo "  ".$_SESSION['MM_nom_usuario'];

$usuario=$_SESSION['MM_nom_usuario'];




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





echo $FechaTxtayer.' 00:00:02<br>';

			
        $horda=$FechaTxtayer;

        
      

$timestamp = strtotime($horda);
$newDate = date("y-m-d", $timestamp );
$newDate2 = date("m", $timestamp );
$newDate3 = date("Y", $timestamp );
$newDate4 = date("d", $timestamp );
echo $newDate2.' mes<br>';

if($newDate2=='01'){
  $newDate2=$newDate4.'-Ene-'.$newDate3;
}
if($newDate2=='02'){ 
  $newDate2=$newDate4.'-Feb-'.$newDate3;
}
if($newDate2=='03'){
  $newDate2=$newDate4.'-Mar-'.$newDate3;
}
if($newDate2=='04'){
  $newDate2=$newDate4.'-Abr-'.$newDate3;
}
if($newDate2=='05'){
  $newDate2=$newDate4.'-May-'.$newDate3;
}
if($newDate2=='06'){
  $newDate2=$newDate4.'-Jun-'.$newDate3;
}
if($newDate2=='07'){
  $newDate2=$newDate4.'-Jul-'.$newDate3;
}
if($newDate2=='08'){
  $newDate2=$newDate4.'-Ago-'.$newDate3;
}
if($newDate2=='09'){
  $newDate2=$newDate4.'-Sep-'.$newDate3;
}
if($newDate2=='10'){
  $newDate2=$newDate4.'-Oct-'.$newDate3;
}
if($newDate2=='11'){
  $newDate2=$newDate4.'-Nov-'.$newDate3;
}
if($newDate2=='12'){
  $newDate2=$newDate4.'-Dic-'.$newDate3;
}

echo '<br>'.$newDate2.'newDate2<br>' ;

//echo $FechaTxtayer;
//$newDate2=$newDate4.'-Jul-'.$newDate3;
$ja=0;
$juegos=0;
//echo $newDate2;



//2022-04-28
//28-Abr-2022



//https://sellatuparley.com/results/index/2022-04-28
//$urlhoy='https://sellatuparley.com/results/index/'.$FechaTxt;
$urlayer='https://sellatuparley.com/results/index/'.$FechaTxtayer;
//$url='https://sellatuparley.com/results/index/';

echo $urlayer.' fecha<br>';



//$urlayer='http://localhost/proyectosglobales/primertrabajo/apuestas/new/logrosresultados/sellatuparley.html';


$ja=0;
$muestramelo=0;

$FechaTxtbr=$FechaTxt.'br';




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
$datoscurl=preg_replace('/\s+/', '.tt.', $datoscurl);
//$datoscurl=str_replace('.tt.', ' ', $datoscurl); 
$datoscurl=str_replace('(', 'ZZ', $datoscurl); 
$datoscurl=str_replace(')', 'ZZ', $datoscurl);
$borrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"' , "/" , '%');
$datoscurl=str_replace($borrardecurl, '', $datoscurl);



$ja=0;


//$newDate2= 'May';

$datoscurl=explode($newDate2, $datoscurl);

//var_dump($datoscurl);

foreach ($datoscurl as $datoscurl2) {
 // echo 'se muestras<br>';



  






    $mostrar=0;

    if(!strpos($datoscurl2, 'OCTYPE.tt.html.tt.html')){


      //var_dump( $datoscurl2);

      



    
       if(strpos($datoscurl2, 'ZZFutbolZZ')){
            //echo 'si es futbol<br>';
            $mostrar=1;
            }
           if(strpos($datoscurl2, 'ZZHockeyZZ')){
           // echo 'si es hockey<br>';
              $mostrar=1;
              }
              if(strpos($datoscurl2, 'ZZBaseballZZ')){
               // echo 'si es beisbol<br>';
                $mostrar=1;
                }
               if(strpos($datoscurl2, 'ZZBasketballZZ')){
               // echo 'si es baloncesto<br>';
                    $mostrar=1;
                    }
                    if(strpos($datoscurl2, 'ZZFootball.tt.AmericanoZZ')){
                       //echo 'si es futbolame<br>';
                           $mostrar=1;
                           }
                    

                    //echo $datoscurl2.'<br><br><br>';

if($mostrar==1){


            
  if(strpos($datoscurl2, 'ZZFutbolZZ')){
            



            

            
//echo $datoscurl2;


            
              //echo 'DIVA<br>';
              
              $mostrar=1;
              
                      //preg_match_all("(spanclassVsOddsVSspanbr(.*)tdtdwidth25(.*)-(.*)tdtdclasstext-center(.*))siU", $datoscurl2, $datoscurl3);
                      //preg_match_all("(,(.*)thtdclasstit-th1stylepadding-left:2px!importantheight:37px!important39579:FUKUSHIMAUNITEDFCbr39580:SCSAGAMIHARAbrtdtdtitleDEPORTELIGA)siU", $datoscurl2, $datoscurl3);
                      preg_match_all("(,.tt.(.*).tt.(.*).tt.th.tt.td.tt.classtit-th1.tt.stylepadding-left:.tt.2px!importantheight:.tt.37px.tt.!important.tt.(.*):.tt.(.*)br(.*):.tt.(.*)br.tt.td.tt.td.tt.titleDEPORTE.tt..tt.LIGA.tt.classdet-th1.tt.(.*).tt.ZZFutbolZZ.tt.td.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*))siU", $datoscurl2, $datoscurl3);
                      //echo $datoscurl3;
                      if (isset($datoscurl3[13][0])){ 
          



          $hora=str_replace('.tt.', ' ', $datoscurl3[1][0]); 
          $Primerequipo=str_replace('.tt.', ' ', $datoscurl3[4][0]); 
          $Primerequipo2=str_replace('.tt.', ' ', $datoscurl3[6][0]); 
          $liga=str_replace('.tt.', ' ', $datoscurl3[7][0]); 
          $deporte=2;
          $hora=$hora.':00';
          
           
         
          
                      
          
                      //echo '<br>'.$datoscurl2.'<br><br><br>';




                      $segundamitad=$datoscurl3[8][0]-$datoscurl3[12][0];
              $segundamitad2=$datoscurl3[9][0]-$datoscurl3[13][0];

              //echo 'HORA '.$hora.' '.$datoscurl3[2][0].'<br> Primer equipo '.$Primerequipo.' Segundo equipo '.$Primerequipo2.' <br>Liga '.$liga.' Deporte '.$datoscurl3[8][0].' <br>RESJC: '.$datoscurl3[8][0].'-'.$datoscurl3[9][0].' A/BJC: '.$datoscurl3[10][0].' RLJC: '.$datoscurl3[11][0].' RESMJ: '.$datoscurl3[12][0].'-'.$datoscurl3[13][0].' A/BMJ: '.$datoscurl3[14][0].' RLMJ: '.$datoscurl3[15][0].' <br><br> ';

              $query_Recordset1111 = sprintf(
                "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 1 */ SELECT nomequipop1, Id_p1equiposp1
              FROM p1equipos
              WHERE nomsella = %s AND deportep1 = %s",
              GetSQLValueString($Primerequipo, "text"),
              GetSQLValueString($deporte, "text"));
              $Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
              $row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
              $totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
              $nom_equi1=$row_Recordset1111['nomequipop1'];

              $query_Recordset1112 = sprintf(
                "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 2 */ SELECT nomequipop1, Id_p1equiposp1
              FROM p1equipos
              WHERE nomsella = %s AND deportep1 = %s",
              GetSQLValueString($Primerequipo2, "text"),
              GetSQLValueString($deporte, "int"));
              $Recordset1112 =mysqli_query($conexionbanca, $query_Recordset1112) or die(mysqli_error($conexionbanca));
              $row_Recordset1112 = mysqli_fetch_assoc($Recordset1112);
              $totalRows_Recordset1112 = mysqli_num_rows($Recordset1112);
              $nom_equi2=$row_Recordset1112['nomequipop1'];
 

              $query_Recordset177 = sprintf(
                "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 3 */ SELECT *
              FROM  p2juegos
              WHERE idequipo1p2 = %s AND idequipo2p2 = %s AND iniciodtp2 >= %s AND iniciodtp2 <= %s ",
              GetSQLValueString($row_Recordset1111['Id_p1equiposp1'], "int"),
              GetSQLValueString($row_Recordset1112['Id_p1equiposp1'], "int"),
              GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
              GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
            );
              $Recordset177 =mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
              $row_Recordset177 = mysqli_fetch_assoc($Recordset177);
              $totalRows_Recordset177 = mysqli_num_rows($Recordset177);
              echo $totalRows_Recordset177.' cantidad de juegos<br>';
              if($totalRows_Recordset177>0){
              //echo ' HORA '.$hora.$datoscurl3[2][0].'<br> Primer equipo '.$Primerequipo.' Segundo equipo '.$Primerequipo2.' <br>Liga '.$liga.' Deporte '.$datoscurl3[8][0].' <br>RESJC: '.$datoscurl3[9][0].'-'.$datoscurl3[10][0].' A/BJC: '.$datoscurl3[11][0].' RLJC: '.$datoscurl3[12][0].' RESMJ: '.$datoscurl3[13][0].'-'.$datoscurl3[14][0].' A/BMJ: '.$datoscurl3[15][0].' RLMJ: '.$datoscurl3[16][0].' <br><br> ';
              
            $query_Recordset14 = sprintf(
              "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 4 */ SELECT * FROM p5resultadosj WHERE 
              iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
              GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
              GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
              GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
          );
          $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
          $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
          $totalRows_Recordset14 = mysqli_num_rows($Recordset14);

         if($totalRows_Recordset14==0){
         
          
          if ($row_Recordset177['Id_p2juegosp2']>0) {
            echo 'creando';
            $insertSQL155 = sprintf(
                "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 5 */ INSERT INTO p5resultadosj  
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
                GetSQLValueString($nom_equi1, "text"),
                GetSQLValueString($nom_equi2, "text"),
                GetSQLValueString($horda.' '.$hora, "date"),
                GetSQLValueString(2, "int"),
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
                GetSQLValueString($datoscurl3[12][0], "int"),
                GetSQLValueString($datoscurl3[13][0], "int"),
                GetSQLValueString($segundamitad, "int"),
                GetSQLValueString($segundamitad2, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(-1, "int")
            );
            $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
        



            
            $ja++;

            
    }

    
    
echo '<br>';
  } 
  $Fechacal=$FechaTxtayer;
  include('../parley/carculojparley.php');
}
}
}       

                      



if(strpos($datoscurl2, 'ZZBasketballZZ')){

        
          $mostrar=1;
          
                 
    
//echo $datoscurl2;
                  
                    //echo 'DIVA3<br>';
                   // echo ' BALONCESTO '; $ja++; echo '# '.$ja.' '.strlen($datoscurl2);

                  //preg_match_all("(spanclassVsOddsVSspanbr(.*)tdtdwidth25(.*)-(.*)tdtdclasstext-center(.*))siU", $datoscurl2, $datoscurl3);
                  //preg_match_all("(,(.*)thtdclasstit-th1stylepadding-left:2px!importantheight:37px!important39579:FUKUSHIMAUNITEDFCbr39580:SCSAGAMIHARAbrtdtdtitleDEPORTELIGA)siU", $datoscurl2, $datoscurl3);
                  preg_match_all("(,.tt.(.*).tt.(.*).tt.th.tt.td.tt.classtit-th1.tt.stylepadding-left:.tt.2px!importantheight:.tt.37px.tt.!important.tt.(.*):.tt.(.*)br(.*):.tt.(.*)br.tt.td.tt.td.tt.titleDEPORTE.tt..tt.LIGA.tt.classdet-th1.tt.(.*).tt.ZZBasketballZZ.tt.td.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*))siU", $datoscurl2, $datoscurl3);
                  //var_dump($datoscurl3);
                  if (isset($datoscurl3[13][0])){ 

      
      $hora=str_replace('.tt.', ' ', $datoscurl3[1][0]); 
      $Primerequipo=str_replace('.tt.', ' ', $datoscurl3[4][0]); 
      $Primerequipo2=str_replace('.tt.', ' ', $datoscurl3[6][0]); 
      $liga=str_replace('.tt.', ' ', $datoscurl3[7][0]); 
      $deporte=1;
      $hora=$hora.':00';
      

      
      
      //echo 'HORA '.$hora.' '.$datoscurl3[2][0].'<br> Primer equipo '.$Primerequipo.' Segundo equipo '.$Primerequipo2.' <br>Liga '.$liga.' Deporte '.$datoscurl3[8][0].' <br>RESJC: '.$datoscurl3[8][0].'-'.$datoscurl3[9][0].' A/BJC: '.$datoscurl3[10][0].' RLJC: '.$datoscurl3[11][0].' RESMJ: '.$datoscurl3[12][0].'-'.$datoscurl3[13][0].' A/BMJ: '.$datoscurl3[14][0].' RLMJ: '.$datoscurl3[15][0].' <br><br> ';
      
                  //echo '<br>'.$datoscurl2.'<br><br><br>';
      

              $segundamitad=$datoscurl3[8][0]-$datoscurl3[12][0];
              $segundamitad2=$datoscurl3[9][0]-$datoscurl3[13][0];

      
              $query_Recordset1111 = sprintf(
                "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 6 */ SELECT nomequipop1, Id_p1equiposp1
              FROM p1equipos
              WHERE nomsella = %s AND deportep1 = %s",
              GetSQLValueString($Primerequipo, "text"),
              GetSQLValueString($deporte, "text"));
              $Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
              $row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
              $totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
  
              $nom_equi1=$row_Recordset1111['nomequipop1'];

              $query_Recordset1112 = sprintf(
                "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 7 */ SELECT nomequipop1, Id_p1equiposp1
              FROM p1equipos
              WHERE nomsella = %s AND deportep1 = %s",
              GetSQLValueString($Primerequipo2, "text"),
              GetSQLValueString($deporte, "int"));
              $Recordset1112 =mysqli_query($conexionbanca, $query_Recordset1112) or die(mysqli_error($conexionbanca));
              $row_Recordset1112 = mysqli_fetch_assoc($Recordset1112);
              $totalRows_Recordset1112 = mysqli_num_rows($Recordset1112);
              $nom_equi2=$row_Recordset1112['nomequipop1'];
 
  
 

              $query_Recordset177 = sprintf(
                "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 8 */ SELECT *
              FROM  p2juegos
              WHERE idequipo1p2 = %s AND idequipo2p2 = %s AND iniciodtp2 >= %s AND iniciodtp2 <= %s ",
               GetSQLValueString($row_Recordset1111['Id_p1equiposp1'], "int"),
              GetSQLValueString($row_Recordset1112['Id_p1equiposp1'], "int"),
              GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
              GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
            );
              $Recordset177 =mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
              $row_Recordset177 = mysqli_fetch_assoc($Recordset177);
              $totalRows_Recordset177 = mysqli_num_rows($Recordset177);





      
                  
      
                  
      
                  
            $query_Recordset14 = sprintf(
              "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 9 */ SELECT * FROM p5resultadosj WHERE 
              iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
              GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
              GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
              GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
          );
          $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
          $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
          $totalRows_Recordset14 = mysqli_num_rows($Recordset14);

         if($totalRows_Recordset14==0){
          //echo 'aqui estoy'.$row_Recordset177['Id_p2juegosp2'];
          
          if ($row_Recordset177['Id_p2juegosp2']>0) {
                  echo 'creando';
                  $insertSQL1555 = sprintf(
                      "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 10 */ INSERT INTO p5resultadosj  
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
                      GetSQLValueString($nom_equi1, "text"),
                      GetSQLValueString($nom_equi2, "text"),
                      GetSQLValueString($horda.' '.$hora, "date"),
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
                      GetSQLValueString($datoscurl3[12][0], "int"),
                      GetSQLValueString($datoscurl3[13][0], "int"),
                      GetSQLValueString($segundamitad, "int"),
                      GetSQLValueString($segundamitad2, "int"),
                      GetSQLValueString(0, "int"),
                      GetSQLValueString(0, "int"),
                      GetSQLValueString(0, "int"),
                      GetSQLValueString(0, "int"),
                      GetSQLValueString(0, "int"),
                      GetSQLValueString(0, "int"),
                      GetSQLValueString(-1, "int")
                  );
                  $Result1555 = mysqli_query($conexionbanca, $insertSQL1555) or die(mysqli_error($conexionbanca));
                  $ja++;

                  
          }

          
      
        }
        $Fechacal=$FechaTxtayer;
        include('../parley/carculojparley.php');
                  }
                  }
      
                
                  if(strpos($datoscurl2, 'ZZHockeyZZ')){
            
                 
                //echo $datoscurl2;
               // echo ' HOCKEY '; $ja++; echo '# '.$ja.' '.strlen($datoscurl2);
                $mostrar=1;
                
                        //preg_match_all("(spanclassVsOddsVSspanbr(.*)tdtdwidth25(.*)-(.*)tdtdclasstext-center(.*))siU", $datoscurl2, $datoscurl3);
                        //preg_match_all("(,(.*)thtdclasstit-th1stylepadding-left:2px!importantheight:37px!important39579:FUKUSHIMAUNITEDFCbr39580:SCSAGAMIHARAbrtdtdtitleDEPORTELIGA)siU", $datoscurl2, $datoscurl3);
                        preg_match_all("(,.tt.(.*).tt.(.*).tt.th.tt.td.tt.classtit-th1.tt.stylepadding-left:.tt.2px!importantheight:.tt.37px.tt.!important.tt.(.*):.tt.(.*)br(.*):.tt.(.*)br.tt.td.tt.td.tt.titleDEPORTE.tt..tt.LIGA.tt.classdet-th1.tt.(.*).tt.ZZHockeyZZ.tt.td.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*))siU", $datoscurl2, $datoscurl3);
                        //var_dump($datoscurl3);
            
                        if (isset($datoscurl3[13][0])){

                        
              

            $hora=str_replace('.tt.', ' ', $datoscurl3[1][0]); 
            $Primerequipo=str_replace('.tt.', ' ', $datoscurl3[4][0]); 
            $Primerequipo2=str_replace('.tt.', ' ', $datoscurl3[6][0]); 
            $liga=str_replace('.tt.', ' ', $datoscurl3[7][0]); 
            $deporte=5;
            $hora=$hora.':00';
            
            
            
            
            
            //echo 'HORA '.$hora.' '.$datoscurl3[2][0].'<br> Primer equipo '.$Primerequipo.' Segundo equipo '.$Primerequipo2.' <br>Liga '.$liga.' Deporte '.$datoscurl3[8][0].' <br>RESJC: '.$datoscurl3[8][0].'-'.$datoscurl3[9][0].' A/BJC: '.$datoscurl3[10][0].' RLJC: '.$datoscurl3[11][0].' RESMJ: '.$datoscurl3[12][0].'-'.$datoscurl3[13][0].' A/BMJ: '.$datoscurl3[14][0].' RLMJ: '.$datoscurl3[15][0].' <br><br> ';
            
                        //echo '<br>'.$datoscurl2.'<br><br><br>';
            
            
            
                        $segundamitad=$datoscurl3[8][0]-$datoscurl3[12][0];
              $segundamitad2=$datoscurl3[9][0]-$datoscurl3[13][0];

                        $query_Recordset1111 = sprintf(
                          "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 11 */ SELECT nomequipop1, Id_p1equiposp1
                        FROM p1equipos
                        WHERE nomsella = %s AND deportep1 = %s",
                        GetSQLValueString($Primerequipo, "text"),
                        GetSQLValueString($deporte, "text"));
                        $Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
                        $row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
                        $totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
           
                        $nom_equi1=$row_Recordset1111['nomequipop1'];

                        $query_Recordset1112 = sprintf(
                          "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 12 */ SELECT nomequipop1, Id_p1equiposp1
                        FROM p1equipos
                        WHERE nomsella = %s AND deportep1 = %s",
                        GetSQLValueString($Primerequipo2, "text"),
                        GetSQLValueString($deporte, "int"));
                        $Recordset1112 =mysqli_query($conexionbanca, $query_Recordset1112) or die(mysqli_error($conexionbanca));
                        $row_Recordset1112 = mysqli_fetch_assoc($Recordset1112);
                        $totalRows_Recordset1112 = mysqli_num_rows($Recordset1112);
                        $nom_equi2=$row_Recordset1112['nomequipop1'];
           
                 
           
          
                        $query_Recordset177 = sprintf(
                          "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 13 */ SELECT *
                        FROM  p2juegos
                        WHERE idequipo1p2 = %s AND idequipo2p2 = %s AND iniciodtp2 >= %s AND iniciodtp2 <= %s ",
                         GetSQLValueString($row_Recordset1111['Id_p1equiposp1'], "int"),
                        GetSQLValueString($row_Recordset1112['Id_p1equiposp1'], "int"),
                        GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
                        GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
                      );
                        $Recordset177 =mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
                        $row_Recordset177 = mysqli_fetch_assoc($Recordset177);
                        $totalRows_Recordset177 = mysqli_num_rows($Recordset177);

                        
            
                        
            
                        $query_Recordset1444 = sprintf(
                          "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 14 */ SELECT * FROM p5resultadosj WHERE 
                          iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
                          GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
                          GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
                          GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
                      );
                      $Recordset1444 = mysqli_query($conexionbanca, $query_Recordset1444) or die(mysqli_error($conexionbanca));
                      $row_Recordset1444 = mysqli_fetch_assoc($Recordset1444);
                      $totalRows_Recordset1444 = mysqli_num_rows($Recordset1444);
            
                     if($totalRows_Recordset1444==0){
                      //echo 'aqui estoy'.$row_Recordset177['Id_p2juegosp2'];
                      
                      if ($row_Recordset177['Id_p2juegosp2']>0) {
                        echo 'creando';
                        $insertSQL155 = sprintf(
                            "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 15 */ INSERT INTO p5resultadosj  
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
                            GetSQLValueString($nom_equi1, "text"),
                            GetSQLValueString($nom_equi2, "text"),
                            GetSQLValueString($horda.' '.$hora, "date"),
                            GetSQLValueString(5, "int"),
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
                            GetSQLValueString($datoscurl3[8][0], "int"),
                            GetSQLValueString($datoscurl3[9][0], "int"),
                            GetSQLValueString($segundamitad, "int"),
                            GetSQLValueString($segundamitad2, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(-1, "int")
                        );
                        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
                        $ja++;

                        
                } 
                
             
                        }
                        $Fechacal=$FechaTxtayer;
                        include('../parley/carculojparley.php');
                      }
                     }

                     
                     if(strpos($datoscurl2, 'ZZBaseballZZ')){
                           
                  

                             
                    //echo $datoscurl2;
                    //echo ' BEISBOL '; $ja++; echo '# '.$ja.' '.strlen($datoscurl2);
                    $mostrar=1;
                    
                            //preg_match_all("(spanclassVsOddsVSspanbr(.*)tdtdwidth25(.*)-(.*)tdtdclasstext-center(.*))siU", $datoscurl2, $datoscurl3);
                            //preg_match_all("(,(.*)thtdclasstit-th1stylepadding-left:2px!importantheight:37px!important39579:FUKUSHIMAUNITEDFCbr39580:SCSAGAMIHARAbrtdtdtitleDEPORTELIGA)siU", $datoscurl2, $datoscurl3);
                            preg_match_all("(,.tt.(.*).tt.(.*).tt.th.tt.td.tt.classtit-th1.tt.stylepadding-left:.tt.2px!importantheight:.tt.37px.tt.!important.tt.(.*):.tt.(.*)br(.*):.tt.(.*)br.tt.td.tt.td.tt.titleDEPORTE.tt..tt.LIGA.tt.classdet-th1.tt.(.*).tt.ZZBaseballZZ.tt.td.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.(.*))siU", $datoscurl2, $datoscurl3);
                            //var_dump($datoscurl3);
                
                            if (isset($datoscurl3[14][0])) {
                            
                  

                $hora=str_replace('.tt.', ' ', $datoscurl3[1][0]); 
                $Primerequipo=str_replace('.tt.', ' ', $datoscurl3[4][0]); 
                $Primerequipo2=str_replace('.tt.', ' ', $datoscurl3[6][0]); 
                $liga=str_replace('.tt.', ' ', $datoscurl3[7][0]); 
                $deporte=0;
                $hora=$hora.':00';
                $anotaprimero=0;
                
                
                
                            //echo 'HORA '.$hora.' '.$datoscurl3[2][0].'<br> Primer equipo '.$Primerequipo.' Segundo equipo '.$Primerequipo2.' <br>Liga '.$liga.' Deporte '.$datoscurl3[8][0].' <br>RESJC: '.$datoscurl3[8][0].'-'.$datoscurl3[9][0].' A/BJC: '.$datoscurl3[10][0].' RLJC: '.$datoscurl3[11][0].' RESMJ: '.$datoscurl3[12][0].'-'.$datoscurl3[13][0].' A/BMJ: '.$datoscurl3[14][0].' RLMJ: '.$datoscurl3[15][0].'   '.$datoscurl3[16][0].'   '.$datoscurl3[17][0].'   '.$datoscurl3[18][0].' <br><br> ';
                
                            //echo '<br>'.$datoscurl2.'<br><br><br>';


                            
                            if($datoscurl3[16][0]=='S'){$sinoj=1;}else{$sinoj=2;}

                
                if($datoscurl3[17][0] == 'H' ){
                  $anotaprimero=$Primerequipo2;
                }
                if($datoscurl3[17][0] == 'V' ){
                  $anotaprimero=$Primerequipo;
                }
                

                $query_Recordset1111 = sprintf(
                  "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 16 */ SELECT nomequipop1, Id_p1equiposp1
                FROM p1equipos
                WHERE nomsella = %s AND deportep1 = %s",
                GetSQLValueString($Primerequipo, "text"),
                GetSQLValueString($deporte, "text"));
                $Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
                $row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
                $totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
   
                $nom_equi1=$row_Recordset1111['nomequipop1'];

                $query_Recordset1112 = sprintf(
                  "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 17 */ SELECT nomequipop1, Id_p1equiposp1
                FROM p1equipos
                WHERE nomsella = %s AND deportep1 = %s",
                GetSQLValueString($Primerequipo2, "text"),
                GetSQLValueString($deporte, "int"));
                $Recordset1112 =mysqli_query($conexionbanca, $query_Recordset1112) or die(mysqli_error($conexionbanca));
                $row_Recordset1112 = mysqli_fetch_assoc($Recordset1112);
                $totalRows_Recordset1112 = mysqli_num_rows($Recordset1112);
                $nom_equi2=$row_Recordset1112['nomequipop1'];
   
   
  
                $query_Recordset177 = sprintf(
                  "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 18 */ SELECT *
                FROM  p2juegos
                WHERE idequipo1p2 = %s AND idequipo2p2 = %s AND iniciodtp2 >= %s AND iniciodtp2 <= %s ",
                 GetSQLValueString($row_Recordset1111['Id_p1equiposp1'], "int"),
                GetSQLValueString($row_Recordset1112['Id_p1equiposp1'], "int"),
                GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
                GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
              );
                $Recordset177 =mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
                $row_Recordset177 = mysqli_fetch_assoc($Recordset177);
                $totalRows_Recordset177 = mysqli_num_rows($Recordset177);

                //echo $row_Recordset1112['Id_p2juegosp2'];


                              
                  
                              $query_Recordset444 = sprintf(
                                "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 19 */ SELECT * FROM p5resultadosj WHERE 
                                iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
                                GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
                                GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
                                GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
                            );
                            $Recordset444 = mysqli_query($conexionbanca, $query_Recordset444) or die(mysqli_error($conexionbanca));
                            $row_Recordset444 = mysqli_fetch_assoc($Recordset444);
                            $totalRows_Recordset444 = mysqli_num_rows($Recordset444);
                  
                           if($totalRows_Recordset444==0){
                            //echo 'aqui estoy'.$row_Recordset177['Id_p2juegosp2'];
                            
                            if ($row_Recordset177['Id_p2juegosp2']>0) {
                              echo 'creando';
                              $insertSQL155 = sprintf(
                                  "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 20 */ INSERT INTO p5resultadosj  
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
                                  GetSQLValueString($nom_equi1, "text"),
                                  GetSQLValueString($nom_equi2, "text"),
                                  GetSQLValueString($anotaprimero, "text"),
                                  GetSQLValueString($horda.' '.$hora, "date"),
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
                                  GetSQLValueString($datoscurl3[8][0], "int"),
                                  GetSQLValueString($datoscurl3[9][0], "int"),
                                  GetSQLValueString($datoscurl3[12][0], "int"),
                                  GetSQLValueString($datoscurl3[13][0], "int"),
                                  GetSQLValueString(0, "int"),
                                  GetSQLValueString(0, "int"),
                                  GetSQLValueString(0, "int"),
                                  GetSQLValueString(0, "int"),
                                  GetSQLValueString($sinoj, "int"),
                                  GetSQLValueString($datoscurl3[18][0], "int"),
                                  GetSQLValueString(-1, "int")
                              );
                              $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
                              $ja++;


                              
                      }
                      
                    }
                    $Fechacal=$FechaTxtayer;
                    include('../parley/carculojparley.php');
                  
                  }
                
                }

                if(strpos($datoscurl2, 'ZZFootball.tt.AmericanoZZ')){
            



            

            

//echo $datoscurl2;

            
                  //echo 'DIVA<br>';
                  
                  $mostrar=1;
                  
                          //preg_match_all("(spanclassVsOddsVSspanbr(.*)tdtdwidth25(.*)-(.*)tdtdclasstext-center(.*))siU", $datoscurl2, $datoscurl3);
                          //preg_match_all("(,(.*)thtdclasstit-th1stylepadding-left:2px!importantheight:37px!important39579:FUKUSHIMAUNITEDFCbr39580:SCSAGAMIHARAbrtdtdtitleDEPORTELIGA)siU", $datoscurl2, $datoscurl3);
                          preg_match_all("(,.tt.(.*).tt.(.*).tt.th.tt.td.tt.classtit-th1.tt.stylepadding-left:.tt.2px!importantheight:.tt.37px.tt.!important.tt.(.*):.tt.(.*)br(.*):.tt.(.*)br.tt.td.tt.td.tt.titleDEPORTE.tt..tt.LIGA.tt.classdet-th1.tt.(.*).tt.ZZFootball.tt.AmericanoZZ.tt.td.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1(.*)brbr(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*).tt.th.tt.th.tt.classdet-th1.tt.(.*))siU", $datoscurl2, $datoscurl3);
                          //var_dump($datoscurl3);
                          if (isset($datoscurl3[13][0])){ 
              
    
    
    
              $hora=str_replace('.tt.', ' ', $datoscurl3[1][0]); 
              $Primerequipo=str_replace('.tt.', ' ', $datoscurl3[4][0]);   
              $Primerequipo2=str_replace('.tt.', ' ', $datoscurl3[6][0]); 
              $liga=str_replace('.tt.', ' ', $datoscurl3[7][0]); 

              echo $liga;
              $deporte=4;
              $hora=$hora.':00';
              
              
             //echo $hora.'<br>'.$Primerequipo.' VS '.$Primerequipo2.'<br>'.$liga.$hora;
              
                          
              
                          //echo '<br>'.$datoscurl2.'<br><br><br>';
    
    
    
    
                          $segundamitad=$datoscurl3[8][0]-$datoscurl3[12][0];
              $segundamitad2=$datoscurl3[9][0]-$datoscurl3[13][0];
    
                  //echo $datoscurl3[13][0].$datoscurl3[14][0].'<br>';
    
                  $query_Recordset1111 = sprintf(
                    "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 21 */ SELECT nomequipop1, Id_p1equiposp1
                  FROM p1equipos
                  WHERE nomsella = %s AND deportep1 = %s",
                  GetSQLValueString($Primerequipo, "text"),
                  GetSQLValueString($deporte, "text"));
                  $Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
                  $row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
                  $totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
                  $nom_equi1=$row_Recordset1111['nomequipop1'];
    //echo $nom_equi1;
                  $query_Recordset1112 = sprintf(
                    "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 22 */ SELECT nomequipop1, Id_p1equiposp1
                  FROM p1equipos
                  WHERE nomsella = %s AND deportep1 = %s",
                  GetSQLValueString($Primerequipo2, "text"),
                  GetSQLValueString($deporte, "int"));
                  $Recordset1112 =mysqli_query($conexionbanca, $query_Recordset1112) or die(mysqli_error($conexionbanca));
                  $row_Recordset1112 = mysqli_fetch_assoc($Recordset1112);
                  $totalRows_Recordset1112 = mysqli_num_rows($Recordset1112);
                  $nom_equi2=$row_Recordset1112['nomequipop1'];
     //echo $nom_equi2;
    
                  $query_Recordset177 = sprintf(
                    "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 23 */ SELECT *
                  FROM  p2juegos
                  WHERE idequipo1p2 = %s AND idequipo2p2 = %s AND iniciodtp2 >= %s AND iniciodtp2 <= %s ",
                   GetSQLValueString($row_Recordset1111['Id_p1equiposp1'], "int"),
                  GetSQLValueString($row_Recordset1112['Id_p1equiposp1'], "int"),
                  GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
                  GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
                );
                  $Recordset177 =mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
                  $row_Recordset177 = mysqli_fetch_assoc($Recordset177);
                  $totalRows_Recordset177 = mysqli_num_rows($Recordset177);
                  echo $totalRows_Recordset177.' cantidad de juegos<br>';
                  if($totalRows_Recordset177>0){
                  //echo ' HORA '.$hora.$datoscurl3[2][0].'<br> Primer equipo '.$Primerequipo.' Segundo equipo '.$Primerequipo2.' <br>Liga '.$liga.' Deporte '.$datoscurl3[8][0].' <br>RESJC: '.$datoscurl3[9][0].'-'.$datoscurl3[10][0].' A/BJC: '.$datoscurl3[11][0].' RLJC: '.$datoscurl3[12][0].' RESMJ: '.$datoscurl3[13][0].'-'.$datoscurl3[14][0].' A/BMJ: '.$datoscurl3[15][0].' RLMJ: '.$datoscurl3[16][0].' <br><br> ';
                  
                $query_Recordset14 = sprintf(
                  "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 24 */ SELECT * FROM p5resultadosj WHERE 
                  iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
                  GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
                  GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
                  GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
              );
              $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
              $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
              $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    
             if($totalRows_Recordset14==0){
             
              
              if ($row_Recordset177['Id_p2juegosp2']>0) {
               
        
                echo 'creando';
                $insertSQL155 = sprintf(
                    "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 25 */ INSERT INTO p5resultadosj  
    (deportep5, juegop5, equipo1p5, equipo2p5, iniciodtp5, tiemposjugadosp5,
     r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
     r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
     r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
    VALUES (%s, %s, %s, %s, %s, %s, %s, 
    %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
    %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
    %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString("futbolamericano", "text"),
                    GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
                    GetSQLValueString($nom_equi1, "text"),
                    GetSQLValueString($nom_equi2, "text"),
                    GetSQLValueString($horda.' '.$hora, "date"),
                    GetSQLValueString(2, "int"),
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
                    GetSQLValueString($datoscurl3[12][0], "int"),
                    GetSQLValueString($datoscurl3[13][0], "int"),
                    GetSQLValueString($segundamitad, "int"),
                    GetSQLValueString($segundamitad2, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(-1, "int")
                );
                $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
            
    
    
    
                
                $ja++;
    
                
        }
    
        
        
    echo '<br>';
      } 
      $Fechacal=$FechaTxtayer;
      include('../parley/carculojparley.php');
    }
    }
    } 



              }      
              



              
            
            } 
            
                                

            
          }






          

   
      
      



        $msj='El Administradorrr '.$usuario. ' actualizo resultados  de ' .$ja. ' en total desde SellatuParley';
$msjx=utf8_encode($msj);
$post=[
  'chat_id'=>-576782283,
  'text'=>$msjx,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
curl_close ($ch);
           
           
         
        echo '<br><br><br> Se actualizaron resultados de sella tu parley : '.$ja.'<br><br><br>';


        $query_RecordsetD = sprintf(
          "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 26 */ SELECT *
        FROM  p2juegos
        WHERE iniciodtp2 >= %s AND iniciodtp2 <= %s ",
        GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
        GetSQLValueString($FechaTxtayer.' 23:59:59', "date")
      );
        $RecordsetD =mysqli_query($conexionbanca, $query_RecordsetD) or die(mysqli_error($conexionbanca));
        $row_RecordsetD = mysqli_fetch_assoc($RecordsetD);
        $totalRows_RecordsetD = mysqli_num_rows($RecordsetD);

       
     $query_RecordsetL = sprintf(
      "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 27 */ SELECT * FROM p5resultadosj WHERE 
      iniciodtp5 >= %s AND iniciodtp5 <= %s AND juegop5 = %s",
      GetSQLValueString($FechaTxtayer.' 00:00:02', "date"),
      GetSQLValueString($FechaTxtayer.' 23:59:59', "date"),
      GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
      );
      $RecordsetL = mysqli_query($conexionbanca, $query_RecordsetL) or die(mysqli_error($conexionbanca));
      $row_RecordsetL = mysqli_fetch_assoc($RecordsetL);
      $totalRows_RecordsetL = mysqli_num_rows($RecordsetL);

       

        echo 'PORFAVOR INGRESE LOS NOMBRES DE LOS SIGUIENTES EQUIPOS PARA METER SUS RESULTADOS <br><br><br>';
/*/
        $msj= 'Hay juegos en Sella tu Parley que no pudieron subir sus resultados. Por favor revisa los equipos para que puedan actualizarse por completo';
        $msjx=utf8_encode($msj);
        $post=[
          'chat_id'=>-1001639542248,
          'text'=>$msjx,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_exec ($ch);
        curl_close ($ch);
        
/*/
        do{

        

        $query_RecordsetD1 = sprintf(
          "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 28 */ SELECT * FROM p5resultadosj WHERE 
              juegop5 = %s",
          GetSQLValueString($row_RecordsetD['Id_p2juegosp2'], "int")
      );
      $RecordsetD1 = mysqli_query($conexionbanca, $query_RecordsetD1) or die(mysqli_error($conexionbanca));
      $row_RecordsetD1 = mysqli_fetch_assoc($RecordsetD1);
      $totalRows_RecordsetD1 = mysqli_num_rows($RecordsetD1);

if($totalRows_RecordsetD1==0){

  $query_RecordsetDP = sprintf(
    "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 29 */ SELECT nomequipop1
  FROM p1equipos
  WHERE Id_p1equiposp1 = %s ",
  GetSQLValueString($row_RecordsetD['idequipo1p2'], "text"));
  $RecordsetDP =mysqli_query($conexionbanca, $query_RecordsetDP) or die(mysqli_error($conexionbanca));
  $row_RecordsetDP = mysqli_fetch_assoc($RecordsetDP);
  $totalRows_RecordsetDP = mysqli_num_rows($RecordsetDP);

//echo $row_RecordsetDP['Id_p1equiposp1'];
  $query_RecordsetDP2 = sprintf(
    "/* PARSEADORES1 logrosresultados\sellatuparleyresultado_angel.php - QUERY 30 */ SELECT nomequipop1
  FROM p1equipos
  WHERE Id_p1equiposp1 = %s",
  GetSQLValueString($row_RecordsetD['idequipo2p2'], "text"));
  $RecordsetDP2 =mysqli_query($conexionbanca, $query_RecordsetDP2) or die(mysqli_error($conexionbanca));
  $row_RecordsetDP2 = mysqli_fetch_assoc($RecordsetDP2);
  $totalRows_RecordsetDP2 = mysqli_num_rows($RecordsetDP2);

  //echo $row_RecordsetDP['nomequipop1'].' VS '.$row_RecordsetDP2['nomequipop1'].'<br><br>';
/*/
$msj= $row_RecordsetDP['nomequipop1'].' VS '.$row_RecordsetDP2['nomequipop1'];
$msjx=utf8_encode($msj);
$post=[
  'chat_id'=>-1001639542248,
  'text'=>$msjx,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
curl_close ($ch);
/*/ 
}




      
    }while ($row_RecordsetD = mysqli_fetch_assoc($RecordsetD));



    //http://www.aprenderaprogramar.com/newuser.php?nombre=Pepe&apellido=Flores&email=h52turam%40uco.es&sexo=Mujer


    if (!isset($_GET['hoy'])) {


    $urlayer='http://localhost/logrosresultados/sellatuparleyresultado_angel.php?hoy=hoy';

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
}

?>

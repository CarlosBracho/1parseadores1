<?php
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
    echo '<br>';
//	$url='https://parley.la/logros';
//fullogros
$url='http://localhost/newangel2021/socialredsite/Vendedor8112021fulllogros.html';
//casisinlogros
//$url='http://localhost/newangel2021/socialredsite/Vendedor8122021primerahorasincasilogros.html';
    //$url='http://localhost/logros/logrosraw/29%20con%20juegos%20fitiros.html';
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result=curl_exec($ch);
    curl_close($ch);
    //echo $result;
    $resultsin=preg_replace('/\s+/', '', $result);
    $resultsin=str_replace('"', '', $resultsin);
    $resultsin=str_replace("'", "", $resultsin);
    $resultsin=str_replace('/', 'x', $resultsin);
    $resultsin=str_replace('(', 'Y', $resultsin); 
    $resultsin=str_replace(')', 'Y', $resultsin); 
    $resultsin=str_replace('[', '', $resultsin); 
    $resultsin=str_replace(']', '', $resultsin); 
    $resultsin=str_replace('onmouseout=changeCellOut', 'xx', $resultsin); 
    $resultsin=str_replace('onmouseover=changeCell_mobil', 'xx', $resultsin); 
    $resultsin=str_replace('onmouseover=changeCell', 'xx', $resultsin); 
    $resultsin=str_replace('<td><tr><tr><tr><tbody><table>', '<td><tr><tr><tr><trclass=table-dark><th><h6><smallclass=font-weight-bold>', $resultsin); 
    $resultsin=str_replace('<smallclass=font-weight-bold>', '', $resultsin); 
 // $resultsin=str_replace('Ganar<xsmall>RL<xsmall>SRL<xsmall>AxB<xsmall>½Ganar<xsmall>½RL<xsmall>½AxB<xsmall>SxN<xsmall>VxH<xsmall>HCE<xsmall><xh6><xth><xtr><trclass=table-light>', '', $resultsin); 
   $resultsin=str_replace('<xth><th>', '', $resultsin); 
    $resultsin=str_replace('<xh6><h6>', '', $resultsin); 
    $resultsin=str_replace('<divclass=text-centerfont-weight-bold>', '', $resultsin); 
    $resultsin=str_replace('<smallclass=text-danger>', '', $resultsin); 
    $resultsin=str_replace('<tdid=', '<td>', $resultsin); 
    $resultsin=str_replace('<=style=cursor:pointer;color:rgbY0,0,0Y;', '', $resultsin); 
    $resultsin=str_replace('style=cursor:pointer;color:rgbY0,0,0Y;', '', $resultsin); 
    $resultsin=str_replace('<smallclass=text-muted>', '', $resultsin); 
    //$resultsin=$resultsin.'147';
    //echo $resultsin;
///*

    preg_match_all("(REF.<xsmall>(.*)<xsmall>Ganar<xsmall>RL<xsmall>SRL<xsmall>AxB<xsmall>½Ganar<xsmall>½RL<xsmall>½AxB<xsmall>SxN<xsmall>VxH<xsmall>HCE<xsmall>(.*)<b>B(.*)<xb><xsmall><br>(.*)<xtd>)siU", $resultsin, $matches1);
    $y=0;
    $z=0;
    //var_dump($matches1[1]).'<br>';
   // echo '<br>';
foreach ($matches1[1] as $datos) {
//echo $y.'<br>';
//echo strlen($matches1[1][$y].$matches1[2][$y].$matches1[3][$y].$matches1[4][$y]).'<br>';
if (strlen($matches1[1][$y].$matches1[2][$y].$matches1[3][$y].$matches1[4][$y])>=1000 && strlen($matches1[1][$y].$matches1[2][$y].$matches1[3][$y].$matches1[4][$y])<=10000){
//echo $matches1[1][$y].'<br><br>si<br><br><br><br><br><br>';
$marca[$z]=$matches1[1][$y].$matches1[2][$y].'B'.$matches1[3][$y].'xxx'.$matches1[4][$y].'<xtd>';
preg_match_all("((.*)<xh6><xth><xtr><trclass=table-light><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><xtr><tr><xtr><trclass=table-light><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd>)siU", $marca[$z], $matches155);
//var_dump($matches155).'<br>';;
echo 'FECHA Y HORA='.$matches155[1][0].'* ';
preg_match_all("(imgwidth=22pxheight=22pxclass=img-fluidsrc=(.*).png>(.*)<p><smallclass=text-dangerfont-weight-bold>(.*)<xsmall><xp>)siU", $matches155[3][0], $matches1001);
echo '<br>PRIMER EQUIPO='.$matches1001[2][0].'* ';
echo 'PITCHET PRIMER EQUIPO='.$matches1001[3][0].'<br>';

// en la siguiente logro ml
if($matches155[4][0]<>""){
preg_match_all("((.*)=>(.*))siU", $matches155[4][0], $matches1002);
$largo=strlen($matches1002[1][0])+2;
echo 'ml='.substr($matches155[4][0], $largo).'* ';
} else {echo 'ml=0* '; }

// en la siguiente valor rl y logro rl
if($matches155[5][0]<>""){
preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[5][0], $matches1003);      
$largo=strlen($matches1003[1][0].$matches1003[2][0])+2+13;
echo 'rlv='.$matches1003[2][0].'* rlL='.substr($matches155[5][0], $largo).'* ';
} else {echo 'rlv=0* rlL=0* '; }

// en la siguiente valor srl y logro srl
if($matches155[6][0]<>""){
preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[6][0], $matches1004);
$largo=strlen($matches1004[1][0].$matches1004[2][0])+2+13;
echo 'srlv='.$matches1004[2][0].'* srlL='.substr($matches155[6][0], $largo).'* ';
} else {echo 'srlv=0* srlL=0* '; }

// en la siguiente valor alta y logro alta
if($matches155[7][0]<>""){
preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[7][0], $matches1005);   
$largo=strlen($matches1005[1][0].$matches1005[2][0])+2+12;
echo 'alv='.substr($matches1005[2][0], 1).'* alL='.substr($matches155[7][0], $largo).'* ';
} else {echo 'alv=0* alL=0* '; }


// en la siguiente logro ml medio juego
if($matches155[8][0]<>""){
preg_match_all("((.*)=>(.*))siU", $matches155[8][0], $matches1006);
$largo=strlen($matches1006[1][0])+2;
echo 'ml5='.substr($matches155[8][0], $largo).'* ';
} else {echo 'ml5=0* '; }

      
// en la siguiente valor rl5 y logro rl5
if($matches155[9][0]<>""){
preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[9][0], $matches1007);
$largo=strlen($matches1007[1][0].$matches1007[2][0])+2+13;
echo 'rl5v='.$matches1007[2][0].'* rl5l='.substr($matches155[9][0], $largo).'* ';
} else {echo 'rl5v=0* rl5l=0* '; }

// en la siguiente valor alta5 y logro alta5
if($matches155[10][0]<>""){
preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[10][0], $matches1008);  
$largo=strlen($matches1008[1][0].$matches1008[2][0])+2+12;
echo 'alv5='.substr($matches1008[2][0], 1).'* alL5='.substr($matches155[10][0], $largo).'* ';
} else {echo 'alv5=0* alL5=0* '; }

// en la siguiente logro si no
if($matches155[11][0]<>""){
  preg_match_all("((.*)=>(.*))siU", $matches155[11][0], $matches1009);
  $largo=strlen($matches1009[1][0])+19;
  echo 'si='.substr($matches155[11][0], $largo).'* ';
  } else {echo 'si=0* '; }

  // en la siguiente logro v/h

if($matches155[12][0]<>""){
  preg_match_all("((.*)=>(.*))siU", $matches155[12][0], $matches10010);
  $largo=strlen($matches10010[1][0])+2;
  echo 'v/h='.substr($matches155[12][0], $largo).'* ';
  } else {echo 'v/h=0* '; }

// en la siguiente valor alta hce y logro alta hce
if($matches155[13][0]<>""){
  preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[13][0], $matches10011);
  $largo=strlen($matches10011[1][0].$matches10011[2][0])+2+17;
  echo 'Ahcev='.substr($matches10011[2][0], 1).'* Ahcel='.substr($matches155[13][0], $largo).'* ';
  } else {echo 'Ahcev=0* Ahcel=0* '; }

//aqui termina el primer equipo y comienza el segundo equipo de besibol

preg_match_all("(imgwidth=22pxheight=22pxclass=img-fluidsrc=(.*).png>(.*)<p><smallclass=text-dangerfont-weight-bold>(.*)<xsmall><xp>)siU", $matches155[15][0], $matches1001);
echo '<br>SEGUNDO EQUIPO='.$matches1001[2][0].'* ';
echo 'PITCHET SEGUNDO EQUIPO='.$matches1001[3][0].'<br>';

// en la siguiente logro ml
if($matches155[16][0]<>""){
  preg_match_all("((.*)=>(.*))siU", $matches155[16][0], $matches1002);
  $largo=strlen($matches1002[1][0])+2;
  echo 'ml='.substr($matches155[16][0], $largo).'* ';
  } else {echo 'ml=0* '; }
  
  // en la siguiente valor rl y logro rl
  if($matches155[17][0]<>""){
  preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[17][0], $matches1003);      
  $largo=strlen($matches1003[1][0].$matches1003[2][0])+2+13;
  echo 'rlv='.$matches1003[2][0].'* rlL='.substr($matches155[17][0], $largo).'* ';
  } else {echo 'rlv=0* rlL=0* '; }
  
  // en la siguiente valor srl y logro srl
  if($matches155[18][0]<>""){
  preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[18][0], $matches1004);
  $largo=strlen($matches1004[1][0].$matches1004[2][0])+2+13;
  echo 'srlv='.$matches1004[2][0].'* srlL='.substr($matches155[18][0], $largo).'* ';
  } else {echo 'srlv=0* srlL=0* '; }
  
  // en la siguiente valor baja y logro baja

  if($matches155[19][0]<>""){
  preg_match_all("((.*)=>(.*)<xb><xsmall>(.*))siU", $matches155[19][0], $matches1005);   
  $largo=strlen($matches1005[1][0].$matches1005[2][0])+2+12;
  echo 'Blv='.substr($matches1005[2][0], 1).'* BlL='.substr($matches155[19][0], $largo).'* ';
  } else {echo 'Blv=0* BlL=0* '; }
  
  
  // en la siguiente logro ml medio juego
  if($matches155[20][0]<>""){
  preg_match_all("((.*)=>(.*))siU", $matches155[20][0], $matches1006);
  $largo=strlen($matches1006[1][0])+2;
  echo 'ml5='.substr($matches155[20][0], $largo).'* ';
  } else {echo 'ml5=0* '; }
  
        
  // en la siguiente valor rl5 y logro rl5
  if($matches155[21][0]<>""){
  preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[21][0], $matches1007);
  $largo=strlen($matches1007[1][0].$matches1007[2][0])+2+13;
  echo 'rl5v='.$matches1007[2][0].'* rl5l='.substr($matches155[21][0], $largo).'* ';
  } else {echo 'rl5v=0* rl5l=0* '; }
  
  // en la siguiente valor baja5 y logro baja5
  if($matches155[22][0]<>""){
  preg_match_all("((.*)<b>(.*)<xb><xsmall>(.*))siU", $matches155[22][0], $matches1008);  
  $largo=strlen($matches1008[1][0].$matches1008[2][0])+2+12;
  echo 'Blv5='.substr($matches1008[2][0], 1).'* BlL5='.substr($matches155[22][0], $largo).'* ';
  } else { echo 'Blv5=0* BlL5=0* '; }
  
  // en la siguiente logro si no
  if($matches155[23][0]<>""){
    preg_match_all("((.*)=>(.*))siU", $matches155[23][0], $matches1009);
    $largo=strlen($matches1009[1][0])+19;
    echo 'NO='.substr($matches155[23][0], $largo).'* ';
    } else {echo 'NO=0* '; }
  
    // en la siguiente logro v/h
  if($matches155[24][0]<>""){
    preg_match_all("((.*)=>(.*))siU", $matches155[24][0], $matches10010);
    $largo=strlen($matches10010[1][0])+2;
    echo 'v/h='.substr($matches155[24][0], $largo).'* ';
    } else {echo 'v/h=0* '; }
  
  // en la siguiente valor baja hce y logro baja hce
  //echo $matches155[25][0];
  if($matches155[25][0]<>"" && strlen($matches155[25][0]>10)){
    preg_match_all("((.*)=>(.*)xxx(.*))siU", $matches155[25][0], $matches10011);
    $largo=strlen($matches10011[1][0].$matches10011[2][0])+5;
    echo 'Bhcev='.substr($matches10011[2][0], 4).'* Bhcel='.substr($matches155[25][0], $largo).'* ';
    } else {echo 'Bhcev=0* Bhcel=0* '; }






      // echo 'si<br>';
       echo '<br><br><br>';
           $z++;
        }else { //echo 'no<br>';
        }

        $y++;
    }
  //  echo $z.'zzzz<br><br><br><br><br><br>';
  //echo $matches155[1].'<br>';
  //var_dump($matches155);
  //echo $marca[0];

   //   preg_match_all("((.*)<xh6><xth><xtr><trclass=table-light><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><xtr><tr><xtr><trclass=table-light><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd><td>(.*)<xtd>)siU", $marca[0], $matches155);
     // echo $matches155[1].'<br>';
     // var_dump($matches155);
 //  echo '<br><br><br><br><br><br><br><br>';
 //  echo $marca[1];
 // echo '<br><br><br><br><br><br><br><br>';
 //  echo $marca[2];
 // echo '<br><br><br><br><br><br><br><br>';
 //echo $marca[3];
//  echo '<br><br><br><br><br><br><br><br>';
// echo $marca[4];
 // echo '<br><br><br><br><br><br><br><br>';
 // echo $marca[5];
//echo '<br><br><br><br><br><br><br><br>';
 //  echo $marca[6];
 // echo '<br><br><br><br><br><br><br><br>';
 //echo $marca[7];
 // echo '<br><br><br><br><br><br><br><br>';
  //echo $marca[8];
  // echo '<br><br><br><br><br><br><br><br>';
  // echo $marca[9];
  //echo '<br><br><br><br><br><br><br><br>';
  //echo $marca[10];
  //echo '<br><br><br><br><br><br><br><br>';

  // echo $marca[11];

   //echo '<br><br><br><br><br><br><br><br>';

//echo '<br><br><br><br><br><br><br><br>';
//*/









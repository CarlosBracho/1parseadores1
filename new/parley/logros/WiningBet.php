<?php
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
//	$url='https://parley.la/logros';
$url='http://localhost/WiningBet/WiningBet.html';
    //$url='http://localhost/logros/logrosraw/29%20con%20juegos%20fitiros.html';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    //echo $result;
    $resultsin = preg_replace('/\s+/', '', $result);
    $resultsin=str_replace('"', '', $resultsin);
    $resultsin=str_replace("'", "", $resultsin);
    $resultsin=str_replace('/', '', $resultsin);
      //$resultsin=str_replace('<br>', '', $resultsin);
      //$resultsin=str_replace('<td>', '', $resultsin);
      //$resultsin=str_replace('</td>', '', $resultsin);
      //$resultsin=str_replace('<tbody><table>', '', $resultsin);
      $resultsin=str_replace('<trstyle=background-color:#F2FFFF;><td><tableclass=text-leftcellspacing=0cellpadding=0style=border:none;>', '<tr><td><tableclass=text-leftcellspacing=0cellpadding=0style=border:none;>', $resultsin);
      $resultsin=str_replace('<td><tr><tr><tdrowspan=2class=tdsdatetext-center>', '<td><tr><trstyle=background-color:#F2FFFF;><tdrowspan=2class=tdsdatetext-center>', $resultsin);
      $resultsin=str_replace('<tbody><table><div><aid=', '<trstyle=background-color:#F2FFFF;><aid=', $resultsin);
      $resultsin=str_replace('<tr><td><tableclass=text-left><tbody><tr><tdstyle=border:none;rowspan=2><imgsrc', '<trstyle=background-color:#F2FFFF;><imgsrc', $resultsin);
      $resultsin=str_replace('class=img-responsiveimgLogowidth=30height=30', '', $resultsin); //solo para reducir tamano
      $resultsin=str_replace('<buttononclick=location.href=&#39;#HOME&#39;;class=btnbtn-smbtn-secondarybtn-roundfloat-rightp-0m-0>', '', $resultsin); //solo para reducir tamano
   
      $resultsin=str_replace('<tbody><tr><tdstyle=border:none;rowspan=2>', '', $resultsin); //solo para reducir tamano
    
      $resultsin=str_replace('<td><tdstyle=border:none;><b>', '', $resultsin); //solo para reducir tamano.
    
      $resultsin=str_replace('<tableclass=text-leftstyle=border:none;cellspacing=0cellpadding=0><tbody><trstyle=border:none;><tdrowspan=2style=border:none;>', '', $resultsin); //solo para reducir tamano.
    
      $resultsin=str_replace('<td><tr><tr><td><tableclass=text-leftcellspacing=0cellpadding=0style=border:none;>', '', $resultsin); //solo para reducir tamano.
    
      $resultsin=str_replace('.pngclass=img-responsivewidth=10height=10><td><tr><tbody><table><td><tdclass=tdsmlb>', '', $resultsin); //solo para reducir tamano.
      $resultsin=str_replace('<td><tdclass=tdsmlb>', '<td>', $resultsin); //solo para reducir tamano.
      $resultsin=str_replace('<tdstyle=border:none;>', '<td>', $resultsin); //solo para reducir tamano.
      $resultsin=str_replace('(', 'HH', $resultsin); 
      $resultsin=str_replace(')', 'HH', $resultsin); 
      $resultsin=str_replace('[', '', $resultsin); 
      $resultsin=str_replace(']', '', $resultsin); 
    preg_match_all("(<tdrowspan=2class=tdsdatetext-center>(.*)<trstyle=background-color:#F2FFFF;>)siU", $resultsin, $matches1);
//print_r($matches1[1]);
   //echo $resultsin;
   ///*
   $y=0;
   $deporte=0;
   foreach ($matches1[1] as $datos) {
    $y++;
    if (str_contains($datos, 'WiningBet_filesmlb')) { $deporte='beisbolmlb'; 
      
    echo '-----'.$y.'-----'.$deporte.'<br>';
      preg_match_all("((.*)<br><spanclass=VsOdds>VS<span><br>(.*)<td><td><imgsrc=.WiningBet_filesmlb.png>(.*)<b><td><tr><tr><td>#(.*)<td><tr><tbody><table><td>(.*)<td>HH(.*)HH(.*)<td>HH(.*)HH(.*)<td>HH(.*)HH(.*)<td>(.*)<td>HH(.*)HH(.*)<td>HH(.*)HH(.*)<td>(.*)<td>(.*)<td>HH(.*)HH(.*)<imgsrc=.WiningBet_filesmlb.png>(.*)<b><td><tr><tr><td>#(.*)<imgsrc=.WiningBet_fileshome(.*)<td>HH(.*)HH(.*)<td>HH(.*)HH(.*)<td>HH(.*)HH(.*)<td>(.*)<td>HH(.*)HH(.*)<td>HH(.*)HH(.*)<td>(.*)<td>(.*)<td>HH(.*)HH(.*)<td><tr>)siU", $datos, $matches12);
      
      echo ' ANO='.$matches12[1][0].' HORA='.$matches12[2][0].'<br>';
      echo  ' PRIMER EQUIPO='.$matches12[3][0].'  PICHE='.preg_replace('/[0-9]+/', '', $matches12[4][0]).'<br>';
      echo  ' lg gan='.$matches12[5][0].' va alta='.$matches12[6][0].' lg alta='.$matches12[7][0].' va rl='.$matches12[8][0].' lg rl='.$matches12[9][0].' va srl='.$matches12[10][0].' lg srl='.$matches12[11][0].' ml5='.$matches12[12][0].' lg alta5='.$matches12[13][0].' lg alta5='.$matches12[14][0].' va rl5='.$matches12[15][0].' lg rl5='.$matches12[16][0].' ap='.$matches12[17][0].' sn='.$matches12[18][0].' hre v='.$matches12[19][0].' hre lg='.$matches12[20][0].'<br>';
      echo  ' SEGUNDO EQUIPO='.$matches12[21][0].' PICHE='.preg_replace('/[0-9]+/', '', $matches12[22][0]).'<br>';
      echo  ' lg gan='.$matches12[23][0].' va alta='.$matches12[24][0].' lg alta='.$matches12[25][0].' va rl='.$matches12[26][0].' lg rl='.$matches12[27][0].' va srl='.$matches12[28][0].' lg srl='.$matches12[29][0].' ml5='.$matches12[30][0].' lg alta5='.$matches12[31][0].' lg alta5='.$matches12[32][0].' va rl5='.$matches12[33][0].' lg rl5='.$matches12[34][0].' ap='.$matches12[35][0].' sn='.$matches12[36][0].' hre v='.$matches12[37][0].' hre lg='.$matches12[38][0];
     
      echo '<br><br>';
    }
    $deporte=0;
    if (str_contains($datos, 'WiningBet_filesnba')) { $deporte='nba'; echo '-----'.$y.'-----'.$deporte.'<br>'; 
    
    }
    if (str_contains($datos, 'WiningBet_filesfut')) { $deporte='fut';  echo '-----'.$y.'-----'.$deporte.'<br>';
    
    }
    
    
   }
   //*/















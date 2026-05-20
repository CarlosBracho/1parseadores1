<?php
// 
error_reporting(E_ALL);
ini_set('display_errors', '1');
echo 'v2<br>';
require_once('../Connections/conexionbanca.php');
set_time_limit(0);
$fecha=fechaactualbd();
date_default_timezone_set("Pacific/Honolulu");
$url='https://www.videobetsamerica007.com/revistas/betsamerica007/';
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
//preg_match_all("(<font color=#0000CC>&nbsp;<B>(.*)</font> <font color=red><font size=3>&nbsp;(.*)</B></font><br><br></td><td align=center>&nbsp;&nbsp;<B><b><font size=3><font color=red>(.*)&nbsp;min.</b>)siU", $result, $matches1);
preg_match_all("(<a href=\"(.*)\" style=\"font-size:24px;\" target=\"_blank\"><span style=\"color\:#000000;\"><span style=\"background-color:LIME;\">(.*)<\/span>)siU", $result, $matches1);
//echo $matches1[1];
print_r($matches1);
$gacetasyabajadas=shell_exec('ls ../gacetas/');
$link[0]="";
$nombre[0]="";

if (!empty($matches1[1])) {
    $link=$matches1[1];
    $x=0;
    $j=0;
    $g=0;
    foreach ($matches1[1] as $datos) {
      $nombre[$x]=trim(strtoupper($matches1[2][$j]));
      if (strlen(stristr($gacetasyabajadas, $nombre[$x]))>0) { } else {

        // if (str_contains($gacetasyabajadas, $nombre[$x])) { } else {
        $link[$x]=$datos;
        //echo $link[$x].'<br>';
       $url='https://www.videobetsamerica007.com/revistas/betsamerica007/'.$link[$x];
      //  exec("wget ".$url);
        
       // $str_datos = get_url_contents($url); 
//$fp = fopen($nombre[$x], 'x'); 
//fwrite($fp, $str_datos); 
//fclose($fp);
        echo $url.'<br>';
      //  172.96.187.248/revistas/betsamerica007/PRX_20210726.pdf
       // rename("/home/apuestas/public_html/gacetas/".$link[$x], "/home/apuestas/public_html/gacetas/".$nombre[$x].".pdf");
echo $nombre[$x].'<br>';
echo $link[$x].'<br>';

//$url='https://www.videobetsamerica007.com/revistas/betsamerica007/PRX_20210726.pdf';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
curl_setopt($ch, CURLOPT_REFERER, 'https://www.videobetsamerica007.com/revistas/betsamerica007/');
$result = curl_exec($ch);
$largo=strlen($result);
echo strlen($largo);
echo '<br>';

if($largo>=100000){
  $fechahoy=str_replace("-", "", $fecha);
  if (strlen(stristr($link[$x], $fechahoy))>0) {

   echo  $nombre[$x];


    $g++;
$fp = fopen($nombre[$x].'.pdf', 'x'); 
fwrite($fp, $result); 
fclose($fp);
echo '<br>si hay<br>';



}}
}
        $x++;
        $j++;
        
        //exec("wget http://63.251.104.167:8090/race/images/items/".$link[$z]);
        //rename("/home/apuestas/public_html/gacetas2/".$link[$z], "/home/apuestas/public_html/gacetas/".$hipodr[$z].".pdf");

    }
}
$gacetasyabajadas2=shell_exec('ls ../gacetas/');
$totalgacetas=substr_count($gacetasyabajadas2, 'RESTROPECTO');



$msj='De la pagina videobetsamerica007 se bajaron '.$g.' Gacetas y hay '.$totalgacetas.' de esta pagina';
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



$copiaranew=shell_exec('cp /home/apuestas/public_html/gacetas/*.pdf /home/apuestas/public_html/new/gacetas/');

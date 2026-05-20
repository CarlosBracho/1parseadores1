<?php

$url='http://pollamacaco.com/Revistas/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);
$result = str_replace(" ", "", $result);
//echo $result;
//preg_match_all("(<td><a href=\"(.*)\">(.*)<\/a>(.*)<\/td><td align=\"right\">(.*)<\/td>)siU", $result, $matches1);
//preg_match_all("(<tr><tdvalign=\"top\">&nbsp\;<\/td><td><ahref=\"(.*)\">(.*)<\/a><\/td><tdalign=\"right\">(.*)<\/td>)siU", $result, $matches1);
preg_match_all("(<tr><tdvalign=\"top\">&nbsp\;<\/td><td><ahref=\"(.*)\">(.*)<\/a><\/td><tdalign=\"right\">(.*)<\/td>)siU", $result, $matches1);

//var_dump($matches1[1][1]);

//     /*
$x=0;
foreach ($matches1[1] as $datos) {
//echo $x.".....".$matches1[1][$x];
echo"http://pollamacaco.com/Revistas/".$matches1[1][$x];
//var_dump($datos);
echo "<br>";
echo" ".substr($matches1[3][$x], 0, -5);

//var_dump($datos);
echo "<br>";
$x++;
}



<?php
   $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.bookmaker.eu/horses-thoroughbreds-racebook');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$result = curl_exec($ch);
$data = curl_error($ch);
 curl_close($ch);

preg_match_all("(<div class=\"RaceNumber\">(.*)</div>)siU", $result, $matches1);


$carreras = $matches1[0][0];
echo "<pre>";
print_r($matches1);
echo "</pre>";

$str = "Esto Es un ejemplo2";
$str = strtoupper($str);
echo $str;

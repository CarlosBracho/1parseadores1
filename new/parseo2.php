<?php
   $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.paribet.com/');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
$data = curl_error($ch);
 curl_close($ch);

preg_match_all("(\s\s\s\s\s\s\s\s\s\s\s\s<a+\s+\s+href=\"\/race\/(.*)\/(.*)\/(.*)\/(.*)\"\sclass=\"(.*)\">(.*)<\/a>)siU", $result, $matches1);



echo "<pre>";
print_r($matches1[3]);
echo "</pre>";
echo "<pre>";
print_r($matches1[6]);
echo "</pre>";
echo "<pre>";
print_r($matches1[5]);
echo "</pre>";


$str = "Esto Es un ejemplo2";
$str = strtoupper($str);
echo $str;

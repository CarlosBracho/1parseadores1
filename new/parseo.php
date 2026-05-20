<?php
   $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.localhost/program1.php');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
$data = curl_error($ch);
 curl_close($ch);

preg_match_all("(<font color=#0000CC>&nbsp;<B>(.*)</font> <font color=red><font size=3>&nbsp;(.*)</B></font><br><br></td><td align=center>&nbsp;&nbsp;<B><b><font size=3><font color=red>(.*)&nbsp;min.</b>)siU", $result, $matches1);


$carreras = $matches1[0][0];
echo "<pre>";
print_r($matches1);
echo "</pre>";


$horaCa[0]=""; $hipodr[0]=""; $carrer[0]=""; $tiempo[0]=""; $horacier[0]="";
if (!empty($matches1[2])) {
    $hipodr=$matches1[1];
    $strx = strtoupper($hipodr);
    $carrer=$matches1[2];
    $tiempo=$matches1[3];
    $horacier[0]="";
    foreach ($strx as $datos) {
        echo $datos."<br/>";
    }
}

$str = "Esto Es un ejemplo2";
$str = strtoupper($str);
echo $str;

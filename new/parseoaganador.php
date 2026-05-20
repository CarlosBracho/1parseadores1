<?php
   $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.aganador.net.ve/apuestas/demo.php');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
$data = curl_error($ch);
 curl_close($ch);

preg_match_all("(<div class=\"parte\"><center>Apuestas abiertas para Carrera No. (.*) (.*)<hr>)siU", $result, $matches1);

$ncarrera = $matches1[1][0];

echo "<pre>";
print_r($ncarrera);
echo "</pre>";

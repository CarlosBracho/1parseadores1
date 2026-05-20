<?php
    
$cookietmp='.';
$target_url = "https://m.capitalotbbet.com";
//$target_url = "https://www.bookingh10hotels.com/reservasweb/solicitud_presupuesto.asp";
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target_url);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_NOBODY, true);
$html = curl_exec($ch);
curl_close($ch);
 
echo "<pre>";
echo $html;
echo "</pre>";

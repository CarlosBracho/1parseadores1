<?php
echo 'v3<br>';
$url='http://localhost/server-status';


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$datoscurl = curl_exec($ch);
curl_close($ch);

echo  $datoscurl;

$url='http://localhost/server-info';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$datoscurl = curl_exec($ch);
curl_close($ch);

echo  $datoscurl;






echo  shell_exec('ps aux');

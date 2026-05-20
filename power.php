<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/jquery-1.9.1.min.js"></script>


</head>

<body>




</body>

</html>
<?php

$url = 'https://www.localhost/';
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); 
curl_setopt($ch, CURLOPT_TIMEOUT, 7); //timeout in seconds
//curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt'); 
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt'); 
$headers = array();
$headers[] = 'Authority: www.twinspires.com';
$headers[] = 'Cache-Control: max-age=0';
$headers[] = 'Sec-Ch-Ua: ^^Chromium^^\";v=^^\"94^^\",';
$headers[] = 'Sec-Ch-Ua-Mobile: ?1';
$headers[] = 'Sec-Ch-Ua-Platform: ^^Android^^\"\"';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.81 Mobile Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Sec-Fetch-Site: none';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Accept-Language: es-ES,es;q=0.9';
//$headers[] = $cookie;
//  $headers[] = $row_Recordset111['num_carrera'];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result2 = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

var_dump($result2);


//curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt'); 
//curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt'); 
<?php


//datoshtml.php
$lot=$_GET['lot'];
$act=$_GET['act'];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://localhost/Venta_Animalitos/creador_json_lista_ani_y_sol_2.php?lot='.$lot.'&act='.$act);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
curl_setopt($ch, CURLOPT_TIMEOUT, 7); //timeout in seconds
$headers = array();
//$headers[] = 'Authority: www.twinspires.com';
$headers[] = 'Cache-Control: max-age=0';
$headers[] = 'Sec-Ch-Ua: ^^';
$headers[] = 'Sec-Ch-Ua-Mobile: ?1';
$headers[] = 'Sec-Ch-Ua-Platform: ^^Android^^\"\"';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Mobile Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Sec-Fetch-Site: none';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Accept-Language: es-ES,es;q=0.9';


curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
       
       $result2 = curl_exec($ch);
      // var_dump($result2);
       if (curl_errno($ch)) {
           echo 'Error:' . curl_error($ch);

}
       curl_close($ch);
       
       $result2=explode('.....', $result2);

       //var_dump($result2);


$animalitos=$result2[0];
$sorteos=$result2[1];
$Morada='pruebacreeacionjson.json,sdfasdfasdfasd';
$miArray = array("animalitos"=>$animalitos, "sorteos"=>$sorteos);

$result=json_encode($miArray);
print($result);

//$fp = fopen('pruebacreeacionjson.json', 'w'); fwrite($fp, $result); fclose($fp);

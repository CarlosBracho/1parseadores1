<?php
$ch = curl_init('http://www.accionhipica.com/juegos/estado_carrera_server.php?id_carrera=9404');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
$result = curl_exec($ch);
$matches1 = $result[0];
echo "<pre>";
print_r($result);
echo "</pre>";

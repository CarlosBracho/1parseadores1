<?php

$url = 'https://www.twinspires.com/php/fw/php_BRIS_BatchAPI/2.3/Tote/CurrentRace?ip=71.212.122.168&affid=2800&debug=off&username=my_sports&password=Gltbatm&output=json';

//  Iniciamos curl
$curl = curl_init();
// Desactivamos verificaci�n SSL
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
// Devuelve respuesta aunque sea falsa
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// Especificamo los MIME-Type que son aceptables para la respuesta.
curl_setopt($curl, CURLOPT_HTTPHEADER, [ 'Accept: application/json' ]);
// Establecemos la URL
curl_setopt($curl, CURLOPT_URL, $url);
//Timeout
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
// Ejecutmos curl
$json = curl_exec($curl);
// Cerramos curl
curl_close($curl);
$respuestas = json_decode($json, true);

var_dump($respuestas);

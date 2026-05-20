<?php

define('BOT_TOKEN', '5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8');
define('CHAT_ID', '-1001639542248');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

enviar_telegram("Hay un msj sin leer en el sistema vaya a http://localhost/admin/mensajes_control.php");


function enviar_telegram($msj)
{
    $queryArray = [
    'chat_id'  => CHAT_ID,
    'text'     => $msj,
    ];
    $url = 'https://api.telegram.org/bot'.BOT_TOKEN.'/sendMessage?'
           . http_build_query($queryArray);
    $result = file_get_contents($url);
}

<?php

define('BOT_TOKEN', '309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE');
define('CHAT_ID', '138894409');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

enviar_telegram("crond funciona bien puedes estar tranquilo de momento");


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

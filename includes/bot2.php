<?php

$botToken='309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE';

$website="https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE";
$chatId=138894409;  //Receiver Chat Id
$params=[
    'chat_id'=>$chatID,
    'text'=>$email_message,
];
$ch = curl_init($website . '/sendMessage');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);
echo $website;
echo "<br/>";
echo $result;

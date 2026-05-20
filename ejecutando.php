<?php

$msj = "Prueba desde PHP";
$post = [
    'chat_id' => -1003755064511,
    'text' => $msj,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// ❌ APAGAR LA VERIFICACIÓN SSL (SOLO PARA PRUEBAS LOCALES)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

if ($response === false) {
    echo "Error de cURL: " . curl_error($ch);
} else {
    echo "Respuesta de Telegram:<br>";
    var_dump(json_decode($response, true));
}

curl_close($ch);
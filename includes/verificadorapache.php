<?php

echo 'Capitol<br>';
$capital = shell_exec('ps aux | grep /home/apuestas/public_html/includes/capi | awk \'{print $2}\'');
echo "<pre>$capital</pre>";

if (strlen($capital)>40){
    echo strlen($capital);
    echo " es mayor a 40";
    $capitalcierre = shell_exec('for i in `ps aux | grep /home/apuestas/public_html/includes/capital | awk \'{print $2}\'`; do kill -9 $i; done');
    echo "<pre>$capitalcierre</pre>";

    $msj="Capital esta fallando en general actualizar cookie" . "\n";
    $msjx=utf8_encode($msj);
    $post=[
    'chat_id'=>-214345883,
    'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec ($ch);
    curl_close ($ch);
    
    
    echo "Capital esta fallando en general actualizar cookie";

}else{
    echo strlen($capital);
    echo " es menor a 40";
}
echo '<br><br><br><br><br>';


echo 'Twinspire<br>';
$twinspire = shell_exec('ps aux | grep /home/apuestas/public_html/includes/twinspire | awk \'{print $2}\'');
echo "<pre>$twinspire</pre>";

if (strlen($twinspire)>40){
    echo strlen($twinspire);
    echo " es mayor a 40";
    $twinspirecierre = shell_exec('for i in `ps aux | grep /home/apuestas/public_html/includes/twinspire | awk \'{print $2}\'`; do kill -9 $i; done');
    $msj="Twinspires esta fallando en general actualizar cookie" . "\n";
$msjx=utf8_encode($msj);
$post=[
'chat_id'=>-214345883,
'text'=>$msjx,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
curl_close ($ch);


echo "Twinspires esta fallando en general actualizar cookie";

}else{
    echo strlen($twinspire);
    echo " es menor a 40";



}
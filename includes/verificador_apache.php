<?php
// 
error_reporting(E_ALL);
ini_set('display_errors', '1');


echo "<br>top v5";
echo "<br>";
//$top=passthru('/usr/bin/top -b -n 1').' top ';
$top=shell_exec('/usr/bin/top -b -n 1').' top ';

$top=preg_replace('/\s+/', '', $top);
$top=str_replace(')', '', $top);
$top=str_replace('(', '', $top); 
$borrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"' , "/");
$top=str_replace($borrardecurl, '', $top);
echo "<br><br><br>";
$top = substr($top, 0, 150);
//substr('abcdef', 0, 4);
//echo $top;
echo "<br><br><br><br>";
preg_match_all("((.*)Tasks:(.*)total,(.*)running)siU", $top, $topx);
//var_dump($topx);
echo "<br><br><br><br>";
//print_r($topx);
echo "<br><br>";
echo $topx[2][0];
echo "<br><br>";
//$reiniciarphp=exec('root mv /home/apuestas/crondarchivos/reiniciarapache /etc/cron.d/reiniciarapache');
//rename("/home/apuestas/crondarchivos/reiniciarapache", "/home/apuestas/reiniciarapache");

if($topx[2][0]>1000){ 
   // $reiniciarphp=shell_exec('root /sbin/service php-fpm70 restart').' top ';
   // $reiniciarapache=shell_exec('root /sbin/service httpd restart').' top ';
   // $reiniciarphp=exec('root mv /home/apuestas/crondarchivos/reiniciarapache /etc/cron.d/reiniciarapache  > /dev/null 2>&1').' top ';
    //$reiniciarapache=exec('/usr/bin/sudo  /sbin/service httpd restart').' top ';
  //  /sbin/service httpd restart
// /sbin/service php-fpm70 restart
    /*
$fichero = '/home/apuestas/crondarchivos/reiniciarapache';
$nuevo_fichero = '/home/apuestas/reiniciarapache';

if (!copy($fichero, $nuevo_fichero)) {
}
*/


    $msj='Apache se a reiniciado con '.$topx[2][0].' esta cantidad de ejecuciones en el sistema';
    $msjx=utf8_encode($msj);
    $post=[
      'chat_id'=>-576782283,
      'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
    curl_exec ($ch);
    curl_close ($ch);

    $connection = ssh2_connect('172.233.161.9', 52457);
ssh2_auth_password($connection, 'root', 'mzyO.6zjKf1.3');


$stream = ssh2_exec($connection, '/sbin/service httpd restart');
    echo "iiiiiiiiiiiiiiiiiiii"; }




<?php
if (!isset($_SESSION)) {
    session_start();
}
echo '<br/>';
require_once('./Connections/conexionbanca.php');
$hora1=horaactual();
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
echo '<br/>';
echo '<br/>';
echo '<br/>';
echo '<br/>';
$ip = $_SERVER['REMOTE_ADDR'];
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if ($query && $query['status'] == 'success') {
    echo 'My IP: '.$query['query'].', '.$query['isp'].', '.$query['org'].', '.$query ['country'].', '.$query['regionName'].', '.$query['city'].'!';
} else {
    echo 'Unable to get location';
}

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min4.5.2.css">
    <link href="../fonts/font-awesome.min4.7.0.css" rel="stylesheet">
    <title>Hello, world!</title>
  </head>
  <body>
<table>
<?php
        echo "<tr>";
        echo "<td>track_name</td>";
        echo "<td>number</td>";
        echo "</tr>";
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
function consultaCierrebetbird()
{
    //$url = 'localhost/1/includes/betbird.json';
    $url = 'http://www.localhost/includes/betbird.json';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $track_name=array();
    $number=array();
    if (isset($fulldatos["data"]["races"])) {
        $g=0;

        foreach ($fulldatos["data"]["races"] as $data) {
            $track_name[$g]=strtoupper($data["track_name"]);
            $number[$g]=$data["number"];
            $fecha = date_create();
            $fechayhora= date_timestamp_get($fecha);
            $mtp[$g]=ceil((((strtotime($data["schedule_time_utc"]))-$fechayhora)/60)-600);
            echo "<tr>";
            echo "<td>$track_name[$g]</td>";
            echo "<td>$number[$g] </td>";
            echo "</tr>";
            $g++;
        }
    }
    return array($track_name, $number, $mtp);
}

    list($track_name, $number, $mtp)=consultaCierrebetbird();
?>
</table>
  </body>
</html>
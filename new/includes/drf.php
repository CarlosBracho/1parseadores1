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
        echo "<td>trackName</td>";
        echo "<td>currentRace</td>";
        echo "<td>mtpDisplay</td>";
        echo "<td>cardOver</td>";
        echo "</tr>";
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');
set_time_limit(0);
function consultaCierredrf()
{
    //$url = 'localhost/1/includes/betbird.json';
    $url = 'https://proservice-bets.drf.com/proservice/superBets/entries?drfpro';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $trackName=array();
    if (isset($fulldatos["data"]["trackList"])) {
        $g=0;

        foreach ($fulldatos["data"]["trackList"] as $data) {
            $trackName[$g]=strtoupper($data["trackName"]);
            $currentRace[$g]=strtoupper($data["currentRace"]);
            $mtpDisplay[$g]=strtoupper($data["mtpDisplay"]);
            $cardOver[$g]=strtoupper($data["cardOver"]);
            
            echo "<tr>";
            echo "<td>$trackName[$g]</td>";
            echo "<td>$currentRace[$g]</td>";
            echo "<td>$mtpDisplay[$g]</td>";
            echo "<td>$cardOver[$g]</td>";
            echo "</tr>";
            $g++;
        }
    }
    return array($trackName, $currentRace, $mtpDisplay, $cardOver);
}

    list($trackName, $currentRace, $mtpDisplay, $cardOver)=consultaCierredrf();
?>
</table>
  </body>
</html>
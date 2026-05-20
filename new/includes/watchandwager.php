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
        echo "<td>DisplayName</td>";
        echo "<td>RaceNum</td>";
        echo "<td>restante</td>";
        echo "</tr>";
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);


function new_consultaCierreWatchandWager2()
{
    $url = 'https://www.watchandwager.com/data/cards';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $horacarr=array();
    $hipodomo=array();
    $numeroca=array();
    $restante=array();
    $horacier=array();
    if (isset($fulldatos["upcoming_races"])) {
        $g=0;

        foreach ($fulldatos["card_list"] as $data) {
            $card_id=$data["id"];
            $name_ra=$data["name"];
            $current_race=$data["current_race_number"];
            foreach ($fulldatos["card_list"][$card_id]["races"] as $race) {
                $id=$race["id"];
                $status_race=$fulldatos["card_list"][$card_id]["races"][$id]["status"];
                if ($status_race=="O") {
                    $hipodomo[$g]=strtoupper($name_ra);
                    $numeroca[$g]=$fulldatos["card_list"][$card_id]["races"][$id]["number"];
                    $restante[$g]=$data["mtp"]+1;
                    $horacarr[$g]=horaactual();
                    $horacier[$g]=horaactual();
                    echo "<tr>";
                    echo "<td>$hipodomo[$g]</td>";
                    echo "<td>$numeroca[$g] </td>";
                    echo "<td> $restante[$g]</td>";
                    echo "</tr>";
                    
                    $g++;
                }
            }
        }
    }
    return array($horacarr, $hipodomo, $numeroca, $restante, $horacier);
}

    list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=new_consultaCierreWatchandWager2();
function new_consultaCierreWatchandWager3()
{
    $url = 'https://www.watchandwager.com/data/cards';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $horacarr=array();
    $hipodomo=array();
    $numeroca=array();
    $restante=array();
    $horacier=array();
    if (isset($fulldatos["upcoming_races"])) {
        $g=0;

        foreach ($fulldatos["card_list"] as $data) {
            $card_id=$data["id"];
            $name_ra=$data["name"];
            $current_race=$data["current_race_number"];
            foreach ($fulldatos["card_list"][$card_id]["races"] as $race) {
                $id=$race["id"];
                $status_race=$fulldatos["card_list"][$card_id]["races"][$id]["status"];
                if ($status_race<>"O") {
                    $hipodomo3[$g]=strtoupper($name_ra);
                    $numeroca3[$g]=$fulldatos["card_list"][$card_id]["races"][$id]["number"];
                    $restante3[$g]=$data["mtp"]+1;
                    $horacarr3[$g]=horaactual();
                    $horacier3[$g]=horaactual();
                    
                    
                    $g++;
                }
            }
        }
    }
    return array($horacarr3, $hipodomo3, $numeroca3, $restante3, $horacier3);
}

    list($horacarr3, $hipodomo3, $numeroca3, $restante3, $horacier3)=new_consultaCierreWatchandWager3();
?>
</table>
  </body>
</html>
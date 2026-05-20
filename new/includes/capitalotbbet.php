<?php
if (!isset($_SESSION)){session_start();} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
?>


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
        echo "<td>HIPODROMO</td>";
        echo "<td>CARRERA</td>";
		echo "<td>MTP</td>";
        echo "<td>ESTADO</td>";
        echo "</tr>";

function consultaCierrecapitalotbbet() {
	$hipodromo[0]=""; $carrera[0]=""; $estado[0]=""; $estado2[0]=""; $estado3[0]=""; $estado4[0]="";
	
$url = 'https://www.capitalotbbet.com/adw/todays-tracks?affid=4200&sortOrder=nextUp';
$str_datos = get_url_contents($url); 
$fulldatos = json_decode($str_datos,true); 
//var_dump($fulldatos); 

if (isset($fulldatos)) {
	$x=0;
	foreach($fulldatos as $CurrentRace) {
		$hipodromo[$x]=strtoupper($CurrentRace["name"]);
		$carrera[$x]=strtoupper($CurrentRace["currentRaceNumber"]);
		foreach($CurrentRace["races"] as $CurrentRace2) {
		//$cn=strtoupper($CurrentRace["races"]["races"]);

		if ($CurrentRace2["raceNumber"]==$CurrentRace["currentRaceNumber"]){
			//echo strtoupper($CurrentRace2["raceNumber"]);
			//echo strtoupper($CurrentRace2["status"]);
			//echo "</br>";
			$estado[$x]=strtoupper($CurrentRace2["status"]);
			$mtp[$x]=strtoupper($CurrentRace2["mtp"]);
	}
	}
		
		$estado2[$x]=strtoupper($CurrentRace["hasBetTypes"]);
		$estado3[$x]=strtoupper($CurrentRace["allowsConditionalWagering"]);
		$estado4[$x]=strtoupper($CurrentRace["allowsBetShareWagering"]);
		echo "<tr>";
		echo "<td>$hipodromo[$x] </td>";
		echo "<td>$carrera[$x] </td>";
		echo "<td> $mtp[$x] </td>";
		echo "<td> $estado[$x] </td>";
		echo "</tr>";



//echo strtoupper($CurrentRace["currentRaceNumber"]);
//echo "</br>";


$x++;
	}
}
return array($hipodromo, $carrera, $estado, $estado2, $estado3, $estado4, $mtp);
}


list($hipodromo, $carrera, $estado, $estado2, $estado3, $estado4, $mtp)=consultaCierrecapitalotbbet();

$f=0;
if ($hipodromo[0]!="") {
	foreach($hipodromo as $hip){
//echo $hip.' ------ '.$carrera[$f].' ------ '.$estado[$f];
//echo "</br>";
$f++;
	}
}
//print($hipodromo);
?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 30000);
 //-->
 //]]>
</script>


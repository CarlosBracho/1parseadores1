<?php




function consultaCierrecapitalotbbet() {
	$nombre[0]=""; $horacarr[0]=""; $BrisCode[0]=""; $numeroca[0]=""; $restante[0]=""; $horacier[0]="";
	$url = 'https://www.capitalotbbet.com/adw/todays-tracks?affid=4200&sortOrder=nextUp';
	$proxy = '5.196.247.77:8080';
	//$proxyauth = 'user:password';
	$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSLVERSION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
$headers[] = 'Accept-Language: es-AR,es;q=0.8,en-US;q=0.5,en;q=0.3';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'Cache-Control: max-age=0';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
//$fp = fopen('capital.json', 'w'); fwrite($fp, $result); fclose($fp);

$fulldatos = json_decode($result,true);
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
	}
	}
		
		$estado2[$x]=strtoupper($CurrentRace["hasBetTypes"]);
		$estado3[$x]=strtoupper($CurrentRace["allowsConditionalWagering"]);
		$estado4[$x]=strtoupper($CurrentRace["allowsBetShareWagering"]);

//echo strtoupper($CurrentRace["currentRaceNumber"]);
//echo "</br>";


$x++;
	}
}
return array($hipodromo, $carrera, $estado, $estado2, $estado3, $estado4);
}


list($hipodromo, $carrera, $estado, $estado2, $estado3, $estado4)=consultaCierrecapitalotbbet();

$f=0;
if ($hipodromo[0]!="") {
	foreach($hipodromo as $hip){
echo $hip.' ------ '.$carrera[$f].' ------ '.$estado[$f];
echo "</br>";
$f++;
	}
}
//print($hipodromo);
?>

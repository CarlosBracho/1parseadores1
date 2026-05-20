<?php
if (!isset($_SESSION)){session_start();} require_once('../Connections/conexionbanca.php');
set_time_limit(0);


$fech=fechaactualbd();
echo $fech;
$horasistema=horaactual();
echo $horasistema;
$query_Recordset1 = sprintf("/* PARSEADORES1 new\includes\capitalotbbet_solocierre.php - QUERY 1 */ SELECT 
		hi.mtp_paribetnom,
		hi.nom_hipodromo,
		ca.cod_carrera,
		ca.num_carrera,
 		ca.est_carrera,
 		ca.hor_carrera,
		ca.est_cierre,
		ca.contador_cierres,
		ca.mtp1,
		ca.mtp2,
		ca.mtp3,
		ca.mtp4,
		ca.mtp5,		
        ca.mtp6,
		ca.mtp7
	FROM carrera ca, hipodromo hi
	WHERE	ca.cod_hipodromo=hi.cod_hipodromo AND
		(ca.est_cierre=1 OR ca.est_cierre=2) AND 
		ca.est_carrera=1 AND 
				hi.mtp_paribet=1 AND 
		ca.eje_primero=0 AND
		ca.fec_carrera=%s",
GetSQLValueString($fech, "date"));  
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


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
		//echo "<tr>";
		//echo "<td>$hipodromo[$x] </td>";
		//echo "<td>$carrera[$x] </td>";
		//echo "<td> $mtp[$x] </td>";
		//echo "<td> $estado[$x] </td>";
		//echo "</tr>";



//echo strtoupper($CurrentRace["currentRaceNumber"]);
//echo "</br>";


$x++;
	}
}
return array($hipodromo, $carrera, $estado, $mtp);
}
echo '</br>';
echo $totalRows_Recordset1;
echo '</br>';
if ($totalRows_Recordset1>0) { 
list($hipodromo, $carrera, $estado, $mtp)=consultaCierrecapitalotbbet();
$last = end($carrera);
$last = $last/1;
echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";
echo $last;
echo "<br/>";echo "<br/>";echo "<br/>";echo "<br/>";



if ($last==0 && $horasistema<="17:00:00") {



	$msj="cerrador capitalotbbet esta fallando" . "\n";
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
	
	
	echo "cerrador capitalotbbet esta fallando";
	
	} else {
	
	$updateSQL = sprintf("/* PARSEADORES1 new\includes\capitalotbbet_solocierre.php - QUERY 2 */ UPDATE alertas SET contadoralerta=contadoralerta+1, fec_alerta=%s, hor_alerta=%s
	WHERE idalertas=%s",
	GetSQLValueString($fech, "date"),
	GetSQLValueString($horasistema, "date"),
	GetSQLValueString(3, "int"));
	$Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
	
	
	}


$date = new DateTime();
//echo $date->format('H:i:s').'2';
//echo '</br>';
$date->modify('+30 second');
$hora30=$date->format('H:i:s');
$horaInicial=horaactual();


do {
	$f=0;
	$tiempo=0;
	$cont=1;
	if ($hipodromo[0]!="") {
		foreach($hipodromo as $hip){
			$tiempo=$mtp[$f];
			if (trim($hipodromo[$f])==trim($row_Recordset1['mtp_paribetnom']) && $carrera[$f]==$row_Recordset1['num_carrera']) {
				if (trim($hipodromo[$f])==trim($row_Recordset1['mtp_paribetnom']) && $carrera[$f]==$row_Recordset1['num_carrera'] && $estado[$f]=='OPEN') {		
				if ($row_Recordset1['hor_carrera']<=$hora30) {
					$minutoAnadir=3;
					$segundos_horaInicial=strtotime($horaInicial);
					$segundos_minutoAnadir=$minutoAnadir*60;
echo $row_Recordset1['hor_carrera'];
echo "<br/>"; 
					$nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
					$nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
 
echo $row_Recordset1['nom_hipodromo']." +2<br/>";
					$updateSQL = sprintf("/* PARSEADORES1 new\includes\capitalotbbet_solocierre.php - QUERY 3 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s 
									  WHERE cod_carrera=%s",
									GetSQLValueString($nuevaHora, "date"),
									GetSQLValueString($nuevaHora, "date"),
									GetSQLValueString($row_Recordset1['cod_carrera'], "int"));
					$Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
				}
				
				
				
				
				echo '</br>';
echo $row_Recordset1['mtp_paribetnom'];
echo $row_Recordset1['num_carrera'];
echo 'abierta';
echo '</br>';

$cont=0;
}
if (trim($hipodromo[$f])==trim($row_Recordset1['mtp_paribetnom']) && $carrera[$f]==$row_Recordset1['num_carrera'] && $estado[$f]<>'OPEN') {	
	$contador_cierres=$row_Recordset1['contador_cierres']+1;
	
	
	$updateSQL = sprintf("/* PARSEADORES1 new\includes\capitalotbbet_solocierre.php - QUERY 4 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, est_cierre=%s, CERRADOX=%s, contador_cierres=%s, mtp1=%s  

	WHERE cod_carrera=%s",
  GetSQLValueString($horasistema, "date"),
  GetSQLValueString($horasistema, "date"),
  GetSQLValueString(0, "int"),
  GetSQLValueString(1, "int"),
  GetSQLValueString("CAPITALOTBBET", "text"),
  GetSQLValueString($contador_cierres, "int"), 
  GetSQLValueString(1, "int"), 
  GetSQLValueString($row_Recordset1['cod_carrera'], "int"));
$Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));






}
}
$f++;

}

}
if ($cont==1){
echo '</br>';
echo $row_Recordset1['mtp_paribetnom'];
echo $row_Recordset1['num_carrera'];
echo 'cerrando';
echo '</br>';
}
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));


}
?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 3000);
 //-->
 //]]>
</script>


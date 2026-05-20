<?php
echo 'v1<br>';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)){session_start();} require_once('../Connections/conexionbanca.php');
$horasistema=horaactual();
$fech=fechaactualbd();


$url="localhost/includes/5.json";


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);



curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); 
curl_setopt($ch, CURLOPT_TIMEOUT, 7); //timeout in seconds
$headers = array();
$headers[] = 'Cache-Control: max-age=0';
$headers[] = 'Sec-Ch-Ua: ^^';
$headers[] = 'Sec-Ch-Ua-Mobile: ?1';
$headers[] = 'Sec-Ch-Ua-Platform: ^^Android^^\"\"';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Mobile Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Sec-Fetch-Site: none';
$headers[] = 'Sec-Fetch-Mode: navigate';
$headers[] = 'Sec-Fetch-User: ?1';
$headers[] = 'Sec-Fetch-Dest: document';
$headers[] = 'Accept-Language: es-ES,es;q=0.9';

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);





$result2 = curl_exec($ch);
if (curl_errno($ch)) {
  echo 'Error:' . curl_error($ch);
}
curl_close($ch);
  //var_dump($result2);




  $car=5;












  $fulldatos = json_decode($result2,true); 
  
   
	$eje1LugarSimple[$car]="";    //
	$eje1LugarDoble[$car]="";    //
	$eje1LugarTriple[$car]="";    //
	$eje2LugarSimple[$car]="";    //
	$eje2LugarDoble[$car]="";    //
	$eje2LugarTriple[$car]="";    //
	$eje3LugarSimple[$car]="";    //
	$eje3LugarDoble[$car]="";    //
	$eje3LugarTriple[$car]="";    //
	$eje4LugarSimple[$car]="";
	$eje4LugarDoble[$car]="";
	$eje4LugarTriple[$car]="";
	$DivWinPriLugar[$car]="";    //
	$DivWinPriLugarDoble[$car]="";  //
	$DivWinPriLugarTriple[$car]="";//
	$DivPlaPriLugar[$car]="";    //
	$DivPlaPriLugarDoble[$car]="";  //
	$DivPlaPriLugarTriple[$car]="";//
	$DivShoPriLugar[$car]="";    //
	$DivShoPriLugarDoble[$car]="";  //
	$DivShoPriLugarTriple[$car]="";//
	$DivPlaSegLugar[$car]="";    //
	$DivPlaSegLugarDoble[$car]="";  //
	$DivPlaSegLugarTriple[$car]="";//
	$DivShoSegLugar[$car]="";    //
	$DivShoSegLugarDoble[$car]="";  //
	$DivShoSegLugarTriple[$car]="";//
	$DivShoTerLugar[$car]="";    //
	$DivShoTerLugarDoble[$car]="";  //
	$DivShoTerLugarTriple[$car]="";//
	$divExotic[$car]="";
	$cAct[0]="";
	 $x=0;
	$i=0;
	$cwin=0;
	$cpla=0;
	$csho=0;
	$cuar=0;

	//var_dump($fulldatos);
	//print_r($fulldatos);
	echo '<br><br>';
	//print_r($fulldatos["track"]["displayName"]);
	print_r($fulldatos["raceDetails"]["winPools"][0]["winPayout"]);
	if (isset($fulldatos)) {
	  $cAct[0]=$fulldatos["raceDetails"]["raceNumber"];
	  $nCar=$cAct[0];



	  foreach($fulldatos["raceDetails"]["winPools"] as $Entries) {
		$cwincorte=0;
	
			if ($cwin==0) {
			  $eje1LugarSimple[$nCar]=$Entries["programNumber"];
			  $DivWinPriLugar[$nCar]=$Entries["winPayout"]*1;
			  $DivPlaPriLugar[$nCar]=$Entries["placePayout"]*1;
			  $DivShoPriLugar[$nCar]=$Entries["showPayout"]*1;
			  //$cwin++;
			 // break;
			 echo 'primera vuelta<br>';
			}
			if ($cwin==1) {
			  $eje1LugarDoble[$nCar]=$Entries["programNumber"];
			  $DivWinPriLugarDoble[$nCar]=$Entries["winPayout"]*1;
			  $DivPlaPriLugarDoble[$nCar]=$Entries["placePayout"]*1;
			  $DivShoPriLugarDoble[$nCar]=$Entries["showPayout"]*1;
		    //$cwin++;
			  //break;
			  echo 'segunda vuelta<br>';
			}
			if ($cwin==2) {
			  $eje1LugarTriple[$nCar]=$Entries["programNumber"];
			  $DivWinPriLugarTriple[$nCar]=$Entries["winPayout"]*1;
			  $DivPlaPriLugarTriple[$nCar]=$Entries["placePayout"]*1;
			  $DivShoPriLugarTriple[$nCar]=$Entries["showPayout"]*1;
			  //break;
			}

      $cwin++;
	//	if($cwin==0 && $cwincorte=0) {$cwin++; $cwincorte=1; }
	//	if($cwin==1 && $cwincorte=0) {$cwin++; $cwincorte=1; }	
	  }

	  foreach($fulldatos["raceDetails"]["placePools"] as $Entries2) {
		
	
		if ($cpla==0) {
			$eje2LugarSimple[$nCar]=$Entries2["programNumber"];
			$DivPlaSegLugar[$nCar]=$Entries2["placePayout"]*1;
			$DivShoSegLugar[$nCar]=$Entries2["showPayout"]*1;
			//$cpla++;
		//	break;
		  }
		  if ($cpla==1) {
			$eje2LugarDoble[$nCar]=$Entries2["programNumber"];
			$DivPlaSegLugarDoble[$nCar]=$Entries2["placePayout"]*1;
			$DivShoSegLugarDoble[$nCar]=$Entries2["showPayout"]*1;
		//	$cpla++;
		//	break;
		  }
		  if ($cpla==2) {
			$eje2LugarTriple[$nCar]=$Entries2["programNumber"];
			$DivPlaSegLugarTriple[$nCar]=$Entries2["placePayout"]*1;
			$DivShoSegLugarTriple[$nCar]=$Entries2["showPayout"]*1;
		//	$cpla++;
		//	break;
		  }
      $cpla++;
	  }

	  foreach($fulldatos["raceDetails"]["showPools"] as $Entries3) {
		
	
		if ($csho==0) {
			$eje3LugarSimple[$nCar]=$Entries3["programNumber"];
			$DivShoTerLugar[$nCar]=$Entries3["showPayout"]*1;
		//	$csho++;
		//	break;
		  }
		  if ($csho==1) {
			$eje3LugarDoble[$nCar]=$Entries3["programNumber"];
			$DivShoTerLugarDoble[$nCar]=$Entries3["showPayout"]*1;
		//	$csho++;
		//	break;
		  }
		  if ($csho==2) {
			$eje3LugarTriple[$nCar]=$Entries3["programNumber"];
			$DivShoTerLugarTriple[$nCar]=$Entries3["showPayout"]*1;
		//	$csho++;
		//	break;
		  }
      $csho++;
	  }









	  
	  $ctaEx=0;
	  $ctaTr=0;
	  $ctaSu=0;
    $divExotic = array();
	  foreach($fulldatos["raceDetails"]["exoticPools"] as $Pools) {
      
		if ($Pools["poolCode"]=="EX") {      
      
		  $divExotic[$nCar][0][$ctaEx][0]="EXACTA"; // tipo de exotica
		  $divExotic[$nCar][0][$ctaEx][1]=$Pools["result"];//llegada
		  $divExotic[$nCar][0][$ctaEx][2]=$Pools["value"];//dividendo
		  $divExotic[$nCar][0][$ctaEx][3]=$Pools["base"];//factor
		  $ctaEx++;
		}
		if ($Pools["poolCode"]=="TR"){
		  $divExotic[$nCar][1][$ctaTr][0]="TRIFECTA"; // tipo de exotica
		  $divExotic[$nCar][1][$ctaTr][1]=$Pools["result"];//llegada
		  $divExotic[$nCar][1][$ctaTr][2]=$Pools["value"];//dividendo
		  $divExotic[$nCar][1][$ctaTr][3]=$Pools["base"];//factor
		  $ctaTr++;
		}
		if ($Pools["poolCode"]=="QD"){  
		  $divExotic[$nCar][2][$ctaSu][0]="SUPERFECTA"; // tipo de exotica
		  $divExotic[$nCar][2][$ctaSu][1]=$Pools["result"];//llegada
		  $divExotic[$nCar][2][$ctaSu][2]=$Pools["value"];//dividendo
		  $divExotic[$nCar][2][$ctaSu][3]=$Pools["base"];//factor
		  $ctaSu++;
		}
			  if ($eje1LugarSimple[$nCar]=="0")  
							  {
				  $eje1LugarSimple[$nCar]=99;		//
				  $eje1LugarDoble[$nCar]="";		//
				  $eje1LugarTriple[$nCar]="";		//
				  $eje2LugarSimple[$nCar]=99;		//
				  $eje2LugarDoble[$nCar]="";		//
				  $eje2LugarTriple[$nCar]="";		//
				  $eje3LugarSimple[$nCar]=99;		//
				  $eje3LugarDoble[$nCar]="";		//
				  $eje3LugarTriple[$nCar]="";		//
				  $eje4LugarSimple[$nCar]=99;
				  $eje4LugarDoble[$nCar]="";
				  $eje4LugarTriple[$nCar]="";
				  $DivWinPriLugar[$nCar]="0";		//
				  $DivWinPriLugarDoble[$nCar]="";	//
				  $DivWinPriLugarTriple[$nCar]="";//
				  $DivPlaPriLugar[$nCar]="0";		//
				  $DivPlaPriLugarDoble[$nCar]="";	//
				  $DivPlaPriLugarTriple[$nCar]="";//
				  $DivShoPriLugar[$nCar]="0";		//
				  $DivShoPriLugarDoble[$nCar]="";	//
				  $DivShoPriLugarTriple[$nCar]="";//
				  $DivPlaSegLugar[$nCar]="0";		//
				  $DivPlaSegLugarDoble[$nCar]="";	//
				  $DivPlaSegLugarTriple[$nCar]="";//
				  $DivShoSegLugar[$nCar]="0";		//
				  $DivShoSegLugarDoble[$nCar]="";	//
				  $DivShoSegLugarTriple[$nCar]="";//
				  $DivShoTerLugar[$nCar]="0";		//
				  $DivShoTerLugarDoble[$nCar]="";	//
				  $DivShoTerLugarTriple[$nCar]="";//
				  $divExotic[$nCar][0][0][0]="EXACTA"; // tipo de exotica
				  $divExotic[$nCar][0][0][1]="0-0";	 // llegada
				  $divExotic[$nCar][0][0][2]=0; // dividendo
				  $divExotic[$nCar][0][0][3]=0; /// factor
				  $divExotic[$nCar][1][0][0]="TRIFECTA"; // tipo de exotica
				  $divExotic[$nCar][1][0][1]="0-0-0";	 // llegada
				  $divExotic[$nCar][1][0][2]=0; // dividendo
				  $divExotic[$nCar][1][0][3]=0; /// factor
				  $divExotic[$nCar][2][0][0]="SUPERFECTA"; // tipo de exotica
				  $divExotic[$nCar][2][0][1]="0-0-0-0";	 // llegada
				  $divExotic[$nCar][2][0][2]=floatval(0); // dividendo
				  $divExotic[$nCar][2][0][3]=0; /// factor
			  }
	  }
	}
echo 'inicia datos<br>';
print_r($ctaEx);  echo 'ctaEx<br>';
print_r($cAct);  echo ' numero carrera<br>';
print_r($eje1LugarSimple);  echo ' ejemplar primero<br>';
print_r($eje1LugarDoble);  echo 'ejemplar primero empate<br>';
print_r($eje1LugarTriple);  echo '<br>';
print_r($eje2LugarSimple);  echo '<br>';
print_r($eje2LugarDoble);  echo '<br>';
print_r($eje2LugarTriple);  echo '<br>';
print_r($eje3LugarSimple);  echo ' eje3LugarSimple<br>';
print_r($eje3LugarDoble);  echo '<br>';
print_r($eje3LugarTriple);  echo '<br>';
print_r($eje4LugarSimple);  echo '<br>';
print_r($eje4LugarDoble);  echo '<br>';
print_r($eje4LugarTriple);  echo '<br>';
print_r($DivWinPriLugar);  echo ' DivWinPriLugar<br>';
print_r($DivWinPriLugarDoble);  echo ' DivWinPriLugarDoble<br>';
print_r($DivWinPriLugarTriple);  echo ' DivWinPriLugarTriple<br>';
print_r($DivPlaPriLugar);  echo ' DivPlaPriLugar<br>';
print_r($DivPlaPriLugarDoble);  echo ' DivPlaPriLugarDoble<br>';
print_r($DivPlaPriLugarTriple);  echo ' DivPlaPriLugarTriple<br>';
print_r($DivShoPriLugar);  echo ' DivShoPriLugar<br>';
print_r($DivShoPriLugarDoble);  echo ' DivShoPriLugarDoble<br>';
print_r($DivShoPriLugarTriple);  echo ' DivShoPriLugarTriple<br>';
print_r($DivPlaSegLugar);  echo ' DivPlaSegLugar<br>';
print_r($DivPlaSegLugarDoble);  echo '<br>';
print_r($DivPlaSegLugarTriple);  echo '<br>';
print_r($DivShoSegLugar);  echo '<br>';
print_r($DivShoSegLugarDoble);  echo '<br>';
print_r($DivShoSegLugarTriple);  echo '<br>';
print_r($DivShoTerLugar);  echo '<br>';
print_r($DivShoTerLugarDoble);  echo '<br>';
print_r($DivShoTerLugarTriple);  echo '<br>';
print_r($divExotic);  echo '<br>';
/*
$nn=0;
foreach($divExotic[0] as $divExotic2) {
  print_r($divExotic2[$nn]);  echo '<br><br><br><br><br><br><br><br>';
  $nn++;
}
 // return array($cAct,$eje1LugarSimple,$eje1LugarDoble,$eje1LugarTriple,$eje2LugarSimple,$eje2LugarDoble,$eje2LugarTriple,$eje3LugarSimple,$eje3LugarDoble,$eje3LugarTriple,$eje4LugarSimple,$eje4LugarDoble,$eje4LugarTriple,$DivWinPriLugar,$DivWinPriLugarDoble,$DivWinPriLugarTriple,$DivPlaPriLugar,$DivPlaPriLugarDoble,$DivPlaPriLugarTriple,$DivShoPriLugar,$DivShoPriLugarDoble,$DivShoPriLugarTriple,$DivPlaSegLugar,$DivPlaSegLugarDoble,$DivPlaSegLugarTriple,$DivShoSegLugar,$DivShoSegLugarDoble,$DivShoSegLugarTriple,$DivShoTerLugar,$DivShoTerLugarDoble,$DivShoTerLugarTriple,$divExotic)


/*
 Array ( 
  [0] => Array ( [1] => Array ( [0] => EXACTA [1] => 4/6 [2] => 14.4 [3] => 2 ) ) 
  [1] => Array ( 
  [0] => Array ( [0] => TRIFECTA [1] => 6/4/3 [2] => 32.9 [3] => 0.5 ) 
  [1] => Array ( [0] => TRIFECTA [1] => 4/6/3 [2] => 23 [3] => 0.5 ) ) 
  
  [2] => Array ( 
  [0] => Array ( [0] => SUPERFECTA [1] => 6/4/3/9 [2] => 22.41 [3] => 0.1 ) 
  [1] => Array ( [0] => SUPERFECTA [1] => 4/6/3/9 [2] => 14.18 [3] => 0.1 ) ) )
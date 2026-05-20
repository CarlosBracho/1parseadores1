<?php
$usuario=222;
$array = array("nticket"=>$usuario, "error"=>"0");
echo "<pre>";
print_r($array);
echo "</pre>";
$json = json_encode($array);

echo "<pre>";
print_r($json);
echo "</pre>";
// $array2=json_decode($json, TRUE);
// echo "<pre>";

// print($array2);
// echo "<pre>";
$jsonText = $json;
$decodedText = html_entity_decode($jsonText);
$myArray = json_decode($decodedText, true);
echo "<pre>";
print_r($myArray);
echo "<pre>";

function consultaCierreTwinspires47()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost/includes/capitalotbbet.json");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    curl_close($ch);

    $decodedText2 = html_entity_decode($response);
    $myArray2 = json_decode($decodedText2, true);
    echo "<pre>";
    print_r($myArray2);
    echo "<pre>";
    
    echo "<pre>";
    print_r($myArray2[0]["brisCode"]);
    echo "<pre>";
    //function json2() {
    $brisCode=array();
    if (isset($myArray2)) {
        $g=0;
        echo "</br>";
        foreach ($myArray2 as $data) {
            $name[$g]=$data["name"];
            $currentRaceNumber[$g]=$data["currentRaceNumber"];
            $numero=$data["currentRaceNumber"]-1;
            $status[$g]=$data["races"][$numero]["status"];
            echo $name[$g];
            echo "---";
            echo $currentRaceNumber[$g];
            echo "---";
            echo $status[$g];
            echo "</br>";
            $currentRaceNumber[$g]=$data["currentRaceNumber"];
            
            
            $g++;

            echo "</br>";
        }
    }
    return array( $name, $currentRaceNumber, $status);
}
    
    list($name, $currentRaceNumber, $status)=consultaCierreTwinspires47();
    
    echo "</br>";
    echo "</br>";
    echo "</br>";
//	echo $brisCode;
        echo "</br>";
    echo "</br>";
    echo "</br>";
//}
//list($brisCode)=json2();
$a = array( $name, $currentRaceNumber, $status);
echo "<pre>";
print_r($a);
echo "<pre>";

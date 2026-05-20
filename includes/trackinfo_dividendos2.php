<?php
 
error_reporting(E_ALL);
ini_set('display_errors', '1');
//echo "This is a warning error";
//include ("file.php");




$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.trackinfo.com/results-print-all.jsp?trackcode=TTUP&racedate=2023-03-04&raceperf=D');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 50);
$datoscurl = curl_exec($ch);
/*/$fd = fopen($filePath, 'w');
fwrite ($fd, $datoscurl); // Escribe el resultado de curl en el archivo
fclose($fd);/*/
curl_close($ch);
$datoscurl=preg_replace('/\s+/', '.tt.', $datoscurl);
$datoscurl=str_replace('&nbsp;', '.tt.', $datoscurl);
$datoscurl = str_replace("\n", '', $datoscurl);
$datoscurl = str_replace(PHP_EOL, '', $datoscurl);

//$datoscurl=str_replace('.tt.', ' ', $datoscurl); 
$datoscurl=str_replace('(', 'ZZ', $datoscurl); 
$datoscurl=str_replace(')', 'ZZ', $datoscurl);
$borrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"' , "/" , '%');
$datoscurl=str_replace($borrardecurl, '', $datoscurl);


$datoscurl=explode('Race:.tt.', $datoscurl);

foreach ($datoscurl as $value) {

   // echo substr('abcdef', 0, 4);  // abcd
    # code...echo 
    if(!strpos($value, 'http-equivContent-Type')){
        //str_replace('.', '', substr($value, 0, 2)); 
    echo 'Numero carrera= '.str_replace('.', '', substr($value, 0, 2)).'<br>';}

    $value2=explode('td.tt.tr.tt.tr.tt.td.tt.align.tt..tt.center', $value);
    $y1=0;
    foreach ($value2 as $value22) {
        $ordenllegada1=substr($value22, 0, 2);
        $ordenllegada1=str_replace('PR', '', $ordenllegada1); 
        $ordenllegada1=str_replace('t', '', $ordenllegada1); 
        $ordenllegada1=str_replace('.', '', $ordenllegada1); 
        if(strlen($ordenllegada1)>0){
            if($y1>0){
echo $ordenllegada1.'<br><br>';}
        }
        $y1++;
    }
}


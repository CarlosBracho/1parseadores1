<?php 



   $ch = curl_init (); 
    curl_setopt ( $ch , CURLOPT_URL, 'https://www.bookmaker.eu/horses-thoroughbreds-racebook'); 
    curl_setopt ( $ch , CURLOPT_USERAGENT ,  'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'); 
    curl_setopt ( $ch , CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en")); 
    curl_setopt ( $ch , CURLOPT_TIMEOUT, 10); 
    curl_setopt ( $ch , CURLOPT_FOLLOWLOCATION,1); 
    curl_setopt ( $ch , CURLOPT_RETURNTRANSFER, 1); 

$result = curl_exec ($ch);
$data = curl_error ($ch);
 curl_close ($ch);

//preg_match_all("(<div class=\"parte\"><center>Apuestas abiertas para Carrera No. (.*) (.*)<hr>)siU", $result, $matches1); 
preg_match_all("(<td class=\"upItemTra\">
        <a href=\"javascript:UncomingRacesAsyncRequest(\'(.*)|(.*)|(.*)|(.*)\',\'(.*)\');">(.*)</a>
      </td>)siU", $result, $matches1); 

$numeroca = $matches1[1][0];
$numeroca2 = $matches1[2][0];
echo "<pre>";
print_r($numeroca);
echo "</pre>";
echo "<pre>";
print_r($numeroca2);
echo "</pre>";

?>
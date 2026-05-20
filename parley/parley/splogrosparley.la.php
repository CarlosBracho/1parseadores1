<?php


function consultalogrosparleyla()
{
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
    //$url='https://parley.la/logros';
    //$url='http://localhost/logros/parley.la29septiembre.php';
    $url='http://localhost/logros/logrosraw/29%20con%20juegos%20fitiros.html';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    
    $result = str_replace(" <", "<", $result);
    preg_match_all("%<tr class=\"categorias-juegos\">

<th class=\"text-center\">
<p>(.*) PM<\/p>
<\/th>

<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>
<th class=\"text-center\">(.*)<\/th>

<th><\/th>
<th><\/th>
<th><\/th>
<\/tr>
<tr class=\"(.*)\">

<td>
<span class=\"opcion-a\">(.*)<small style=\"font-size:80\%;font-weight:normal;\">\((.*)\)<\/small>
<\/span>
<span>(.*)<small style=\"font-size:80\%;font-weight:normal;\">\((.*)\)<\/small>
<\/span>
<\/td>

<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>
<td class=\"text-left\">(.*)<\/td>

<td><\/td>
<td><\/td>
<td><\/td>
<\/tr>%siU", $result, $matches10);
    $o11=$matches10;
    echo "<pre>";
    print_r($o11);
    echo "</pre>";

    $x=0;
    if (!empty($matches10[14])) {
        echo "hola";
        $ml=$matches10[18];
        foreach ($matches10[14] as $datos) {
            $equipo1[$x]=trim(strtoupper($datos));
            $x++;
        }
    }
}

list($equipo1, $ml)=consultalogrosparleyla();
echo $equipo1[0];

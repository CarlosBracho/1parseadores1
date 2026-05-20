<?php

function download_file_from_url($url, $path)

{
    $new_file_name = $path;
    $file = fopen ($url, "rb");

    if ($file) {
        $newf = fopen ($new_file_name, "wb");

        if ($newf) {
            while (!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
            }
        }
    }

    if ($file) {
        fclose($file);
    }

    if ($newf) {
        fclose($newf);
    }
}

function get_filetime($link)
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_FILETIME, true);

    $result = curl_exec($curl);
    $info = curl_getinfo($curl);

    return $info['filetime'];
}

$url='http://pollamacaco.com/Revistas/';
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FILETIME, true);

$result = curl_exec($ch);

curl_close($ch);

preg_match_all("(<tr><td valign=\"top\">&nbsp\;<\/td><td><a href=\"(.*)\">)siU", $result, $matches);

$revistas_raw = $matches[1];
$revistas = [];


/* $date = date_create()->format("Y-m-d_His"); */

foreach ($revistas_raw as $datos) {
    if (strpos($datos, ".pdf") !== false) {
        $revistas[] = [
            "name" => $datos,
            "link" => "http://pollamacaco.com/Revistas/" . $datos,
        ];
    }
} 

echo "<h2>Descargando...<h2>";
foreach ($revistas as $index => $link) {
    $date_file = (new Datetime())->setTimestamp(get_filetime($link['link']))->format("Y-m-d");
    $now = (new Datetime())->format("Y-m-d");

    if ($now === $date_file) {
        /* $file_name = basename($link['link']); */
        /* file_put_contents($file_name,file_get_contents($link['link'])); */
        download_file_from_url($link['link'], $link['name']);

    }
}
echo "<h2>Completada<h2>";

/* var_dump($revistas); */


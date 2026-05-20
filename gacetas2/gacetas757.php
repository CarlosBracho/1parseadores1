<?php
function consultaPacificna()
{
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
    $url='http://63.251.104.167:8090/race/programas.do';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    preg_match_all("(<img src=\"images/flecha.gif\"/>&nbsp;<a style=\"font-size:24px;\" href=\"images/items/(.*)\" target=\"_blank\">(.*)</a><br>)siU", $result, $matches1);
    $link[0]="";
    $hipodr[0]="";


    if (!empty($matches1[1])) {
        $hipodr=$matches1[2];
        $x=0;
        foreach ($matches1[1] as $datos) {
            $link[$x]=$datos;
            $x++;
        }
    }
    return array($link, $hipodr);
}

list($link, $hipodr)=consultaPacificna();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<![endif]-->
<pre>
<?php
$a = array($link, $hipodr);

$cantidadgacetas=count($link, COUNT_RECURSIVE)/1;
echo $cantidadgacetas;

echo "<pre>";


echo "<pre>";

$contador = 0;
$z=0;
    do {
        $contador++;
        if ($link[0]!="") {
            exec("wget http://63.251.104.167:8090/race/images/items/".$link[$z]);
            rename("/home/apuestas/public_html/gacetas2/".$link[$z], "/home/apuestas/public_html/gacetas/".$hipodr[$z].".pdf");

            $z++;
        }
    } while ($contador < count($link, COUNT_RECURSIVE));

?>
</pre>
</body>
<!-- InstanceEnd --></html>
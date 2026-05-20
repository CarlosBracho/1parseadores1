<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

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


carreras abiertas 
<?php

function paribet2()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.paribet.com/');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = strtoupper(curl_exec($ch));
    $data = curl_error($ch);
    curl_close($ch);
    
    preg_match_all("(\s\s\s\s\s\s\s\s\s\s\s\s<a+\s+\s+href=\"\/race\/(.*)\/(.*)\/(.*)\/(.*)\"\sclass=\"(.*)\">(.*)<\/a>)siU", $result, $matches1);
    $hipodr[0]="";
    $carrer[0]="";
    $estado[0]="";
    if (!empty($matches1[3])) {
        $x=0;
        $y=0;
        foreach ($matches1[3] as $datos) {
            if ($matches1[5][$y]==trim("") or $matches1[5][$y]==trim("ORANGE")) {
                $carrer[$x]=$matches1[6][$y];
                $hipodr[$x]=trim(strtoupper($datos));
                $x++;
            }
            $y++;
        }
    }
    return array($hipodr, $carrer);
}
list($hipodr, $carrer)=paribet2();
$a = array($hipodr, $carrer, $estado);
echo "<pre>";
print_r($a);
echo "</pre>";
?>
</pre>


carreras cerradas

<pre>
<?php
function paribet21()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.paribet.com/');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = strtoupper(curl_exec($ch));
    $data = curl_error($ch);
    curl_close($ch);
    
    preg_match_all("(\s\s\s\s\s\s\s\s\s\s\s\s<a+\s+\s+href=\"\/race\/(.*)\/(.*)\/(.*)\/(.*)\"\sclass=\"(.*)\">(.*)<\/a>)siU", $result, $matches121);
    $hipodr21[0]="";
    $carrer21[0]="";
    $estado21[0]="";
    if (!empty($matches121[3])) {
        $x=0;
        $y=0;
        foreach ($matches121[3] as $datos) {
            if ($matches121[5][$y]==trim("RED") or $matches121[5][$y]==trim("RED")) {
                $carrer21[$x]=$matches121[6][$y];
                $hipodr21[$x]=trim(strtoupper($datos));
                $x++;
            }
            $y++;
        }
    }
    return array($hipodr21, $carrer21);
}
list($hipodr21, $carrer21)=paribet21();
$a = array($hipodr, $carrer, $estado);
echo "<pre>";
print_r($a);
echo "</pre>";
?>
</pre>
</body>
<!-- InstanceEnd --></html>
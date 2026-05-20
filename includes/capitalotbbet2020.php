<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);






    //$url = 'localhost/1/includes/capitalotbbet.json';
    $url = 'http://www.localhost/includes/capitalotbbet.json';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    
    if (isset($fulldatos["name"])) {
        $x=0;
        foreach ($fulldatos["name"] as $CurrentRace) {
            $nombre[$x]=$CurrentRace["name"];

            $x++;
        }
    }
    return array($nombre);


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
<pre>
<?php

echo "<pre>";
print_r($nombre);
echo "</pre>";
echo "<pre>";
print_r($fulldatos);
echo "</pre>";



?>
</pre>

<br><br><br><br><br><br><br>
</body>
<!-- InstanceEnd --></html>
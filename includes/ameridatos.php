<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');


function consultaPacificna()
{
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
    $url='http://web1.ameridatos.com:6850/program1.asp';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    preg_match_all("(<font color=#0000CC>&nbsp;<B>(.*)</font> <font color=red><font size=3>&nbsp;(.*)</B></font><br><br></td><td align=center>&nbsp;&nbsp;<B><b><font size=3><font color=red>(.*)&nbsp;min.</b>)siU", $result, $matches1);
    $horaCa[0]="";
    $hipodr[0]="";
    $carrer[0]="";
    $tiempo[0]="";
    $horacier[0]="";
    if (!empty($matches1[1])) {
        $carrer=$matches1[2];
        $tiempo=$matches1[3];
        $x=0;
        foreach ($matches1[1] as $datos) {
            $hipodr[$x]=trim(strtoupper($datos));
            $h1="+".$tiempo[$x]." minute";
            $horacier[$x]=date("H:i:s", strtotime($h1));
            $horaCa[$x]=date("h:i:s", strtotime($h1));
            $x++;
        }
    }
    return array($horaCa, $hipodr, $carrer, $tiempo, $horacier);
}

list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=consultaPacificna();
$fech=fechaactualbd();
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
$a = array($hipodomo, $numeroca);
echo "<pre>";
print_r($a);
echo "</pre>";
?>
</pre>
</body>
<!-- InstanceEnd --></html>
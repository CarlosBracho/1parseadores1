<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$now = date('Y-m-d H:i:s');
echo $now;
echo '<br/>';
function betamerica($p)
{
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    switch ($p) {
        case "1": $url = 'https://api.betamerica.com/hds/service/tracklistitems'; break;
        case "2": $url = 'https://www.racebets.com/ajax/events/calendar/date/yesterday'; break;
        case "3": $url = 'https://www.racebets.com/ajax/events/calendar/date/tomorrow'; break;
    }
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $g=0;
    $nHipodro[$g]=0;
    $nCarrera[$g]=0;
    $horagmt[$g]=0;
    $cerradoono[$g]=0;
    if (isset($fulldatos)) {
        foreach ($fulldatos as $da) {
            if ($fulldatos[$g]["trackName"]==$fulldatos[$g]["raceNum"]); else {
                $nHipodro[$g]=$fulldatos[$g]["trackName"];
            }
            
            $nHipodro[$g]=strtoupper($fulldatos[$g]["trackName"]);
            $nCarrera[$g]=$fulldatos[$g]["raceNum"];
            $horagmt[$g]=$fulldatos[$g]["gmtPostDttm"];
            $cerradoono[$g]=strtoupper($fulldatos[$g]["isWageringClosed"])/1;
            $g++;
        }
    }
    return array($nHipodro,$nCarrera,$horagmt,$cerradoono);
}
    list($nHipodro, $nCarrera, $horagmt, $cerradoono)=betamerica(1);
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
$a = array($nHipodro, $nCarrera, $horagmt, $cerradoono);
echo "<pre>";
print_r($a);
echo "</pre>";
?>
</pre>
</body>
<!-- InstanceEnd --></html>
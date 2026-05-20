<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

function mtptvg2($p)
{
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    switch ($p) {
        case "1": $url = 'https://www.tvg.com/ajax/upcoming-races/id/upcomingList/date/'.$hoy.'/wp/AllTracks'; break;
        case "2": $url = 'https://www.racebets.com/ajax/events/calendar/date/yesterday'; break;
        case "3": $url = 'https://www.racebets.com/ajax/events/calendar/date/tomorrow'; break;
    }
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $g=0;
    $nHipodro[$g]=0;
    $nCarrera[$g]=0;
    if (isset($fulldatos)) {
        foreach ($fulldatos as $da) {
            if ($fulldatos[$g]["TrackName"]==$fulldatos[$g]["RaceNumber"]); else {
                $nHipodro[$g]=$fulldatos[$g]["TrackAbbr"];
            }
            
            $nHipodrox[$g]=$fulldatos[$g]["TrackName"];
            $nHipodro[$g]=$fulldatos[$g]["TrackAbbr"];
            $nCarrera[$g]=$fulldatos[$g]["RaceNumber"];
            $g++;
        }
    }
    return array($nHipodrox,$nHipodro,$nCarrera);
}
    list($nHipodrox, $nHipodro, $nCarrera)=mtptvg2(1);
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
$a = array($nHipodrox, $nHipodro, $nCarrera);
echo "<pre>";
print_r($a);
echo "</pre>";
?>
</pre>
</body>
<!-- InstanceEnd --></html>
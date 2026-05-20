<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');


function consultaCierreTwinspires47()
{
    $nombre[0]="";
    $horacarr[0]="";
    $BrisCode[0]="";
    $numeroca[0]="";
    $restante[0]="";
    $horacier[0]="";
    $url = 'https://www.twinspires.com/php/fw/php_BRIS_BatchAPI/2.3/Tote/CurrentRace?ip=71.212.122.168&affid=2800&debug=off&username=my_sports&password=Gltbatm&output=json';
    //$proxy = '5.196.247.77:8080';
    //$proxyauth = 'user:password';
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_PROXY, $proxy);
    //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0';
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
    $headers[] = 'Accept-Language: es-AR,es;q=0.8,en-US;q=0.5,en;q=0.3';
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    $headers[] = 'Cache-Control: max-age=0';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $fulldatos = json_decode($result, true);


    if (isset($fulldatos["CurrentRace"])) {
        $x=0;
        foreach ($fulldatos["CurrentRace"] as $CurrentRace) {
            $nombre[$x]=$CurrentRace["DisplayName"];
            $BrisCode[$x]=strtoupper($CurrentRace["BrisCode"]);

            $RaceStatus=$CurrentRace["RaceStatus"];
            if ($RaceStatus=="Off" or $RaceStatus=="Closed") {
                $restante[$x]=0;
            } elseif ($RaceStatus=="Open" && $CurrentRace["Mtp"]==0) {
                $restante[$x]=2;
            } else {
                $restante[$x]=$CurrentRace["Mtp"];
            }
            $numeroca[$x]=$CurrentRace["RaceNum"];
            $horaInicial=horaactual8();
            $minutoAnadir=$restante[$x];
            $segundos_horaInicial=strtotime($horaInicial);
            $segundos_minutoAnadir=$minutoAnadir*60;
            $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
            $horacier[$x]=$nuevaHora;
            $horacarr[$x]=$nuevaHora;
            $x++;
        }
    }
    return array($nombre, $BrisCode, $numeroca, $restante, $horacier);
}

list($nombre, $hipodomo, $numeroca, $restante, $horacier)=consultaCierreTwinspires47();
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
$a = array($nombre, $hipodomo, $numeroca, $restante, $horacier);
echo "<pre>";
print_r($a);
echo "</pre>";
?>
</pre>
</body>
<!-- InstanceEnd --></html>
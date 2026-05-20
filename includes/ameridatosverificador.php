<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$horasistema=horaactual();
$fechasistema=fechaactualbd();

function consultaPacificnax()
{
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
    $url='http://web2.interamericanas.com:9930/program1.asp';
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
    return array($hipodr, $carrer, $tiempo);
}

list($hipodr, $carrer, $tiempo)=consultaPacificnax();
$fech=fechaactualbd();



//$query_Carrera= sprintf("SELECT nom_hipodromo_sup,num_carrera,hor_mtp,hor_carrera FROM carrera WHERE carrera.fec_carrera = %s AND carrera.hor_carrera >= %s AND carrera.est_carrera = 1 ORDER BY carrera.hor_mtp", GetSQLValueString($fechasistema, "date"), GetSQLValueString($horasistema, "date"));
//$Carrera = mysqli_query($conexionbanca, $query_Carrera) or die(mysqli_error($conexionbanca));
//$row_Carrera = mysqli_fetch_assoc($Carrera);
//$totalRows_Carrera = mysqli_num_rows($Carrera);
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 includes\ameridatosverificador.php - QUERY 1 */ SELECT * FROM carrera ca, hipodromo hi WHERE ca.eje_primero=0 AND ca.fec_carrera=%s  AND ca.cod_hipodromo=hi.cod_hipodromo ORDER BY hor_carrera",
        GetSQLValueString($fech, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);


?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 3000);
 //-->
 //]]>
</script>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas H�picas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<!-- [endif]-->
</head>
<body>
<pre>
<?php
$a = array($hipodr, $carrer, $tiempo);
$ameridatosabiertas=count($hipodr, COUNT_RECURSIVE)/1;
$i=9;
$c=0;
$f=0;
    if ($hipodr[0]!="") {
        do {
            $c++;

            $query_Recordset11 = sprintf(
                "/* PARSEADORES1 includes\ameridatosverificador.php - QUERY 2 */ SELECT * 
	FROM carrera ca, hipodromo hi 
	WHERE ca.eje_primero=0 AND
	hi.nom_hipodromo_sup=%s AND
	ca.est_cierre!=3 AND
	ca.num_carrera=%s AND
	ca.fec_carrera=%s AND
	ca.cod_hipodromo=hi.cod_hipodromo 
	ORDER BY hor_carrera DESC LIMIT 0, 1",
                GetSQLValueString($hipodr[$f], "text"),
                GetSQLValueString($carrer[$f], "int"),
                GetSQLValueString($fech, "date")
            );
            $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
            $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
            $totalRows_Recordset11 = mysqli_num_rows($Recordset11);

            if ($totalRows_Recordset11==0 && $tiempo[$f]<=15) {
                $msj=" la siguiente carrera esta abierta en ameridatos y no en nustro sistema revisarla reportala" . "\n".$hipodr[$f]." numero ".$carrer[$f];

                $msjx=utf8_encode($msj);
                $post=[
    'chat_id'=>-214345883,
    'text'=>$msjx,
];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_exec($ch);
                curl_close($ch);
            }

            $f++;
        } while ($c < $ameridatosabiertas);
    }


?>
</pre>
</body>
<!-- InstanceEnd -->
</html>
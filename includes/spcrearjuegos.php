<?php
require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
echo  $FechaTxt;
$esononx='+150';
    if (is_numeric($esononx)) {
        echo var_export($esononx, true) . " es numérico", PHP_EOL;
    } else {
        echo var_export($esononx, true) . " NO es numérico", PHP_EOL;
    }
    
$datetime=$FechaTxt.' '.$horaTxt;
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
    $url='https://parley.la/logros';
//$url='http://localhost/logros/parley.la29septiembre.php';
    //$url='http://localhost/logros/logrosraw/29%20con%20juegos%20fitiros.html';
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
<p>(.*)<span style=\"color:\#AE0000; font-weight: bold;\">EVENTO FUTURO \((.*)\)<\/span><\/p>
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
//print_r($o11);
echo "</pre>";

$x=0;
foreach ($matches10[0] as $datos) {
    $dia=substr($matches10[2][$x], 0, 2);
    $ano=substr($FechaTxt, 0, 4);
    $mes=substr($matches10[2][$x], 3, 3);
    $horaj=substr($matches10[1][$x], 0, 7);
    $horaj=date('H:i:s', strtotime($horaj));
    $datetime=$ano.'-'.$mes.'-'.$dia.' '.$horaj;
    echo $datetime;
    $datetime = strtotime('-6 hour', strtotime($datetime));
    $datetime = date('Y-m-j H:i:s', $datetime);
    echo "</br>";

    echo $matches10[15][$x];
    echo "</br>";
    echo $matches10[16][$x];
    echo "</br>";
    echo $matches10[17][$x];
    echo "</br>";
    echo $matches10[18][$x];
    echo "</br>";
    echo "</br>";
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 includes\spcrearjuegos.php - QUERY 1 */ SELECT *
FROM p1equipos
WHERE  
nomequipop1 = %s",
        GetSQLValueString(trim(strtoupper($matches10[15][$x])), "text")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);

    if ($totalRows_Recordset21==0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 includes\spcrearjuegos.php - QUERY 2 */ INSERT 
				INTO p1equipos
				(nomequipop1, nomdimp1, deportep1, ligap1, ordenp1) 
				VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString(trim(strtoupper($matches10[15][$x])), "text"),
            GetSQLValueString(trim(strtoupper($matches10[15][$x])), "text"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset21 = sprintf(
            "/* PARSEADORES1 includes\spcrearjuegos.php - QUERY 3 */ SELECT *
FROM p1equipos
WHERE  
nomequipop1 = %s",
            GetSQLValueString(trim(strtoupper($matches10[15][$x])), "text")
        );
        $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
        $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
        $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    }

    //echo $totalRows_Recordset21;
    //echo "</br>";
    //echo $row_Recordset21['Id_p1equiposp1'];
    //echo "</br>";
    $query_Recordset22 = sprintf(
        "/* PARSEADORES1 includes\spcrearjuegos.php - QUERY 4 */ SELECT *
FROM p1equipos
WHERE  
nomequipop1 = %s",
        GetSQLValueString(trim(strtoupper($matches10[17][$x])), "text")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
    if ($totalRows_Recordset22==0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 includes\spcrearjuegos.php - QUERY 5 */ INSERT 
				INTO p1equipos
				(nomequipop1, nomdimp1, deportep1, ligap1, ordenp1) 
				VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString(trim(strtoupper($matches10[17][$x])), "text"),
            GetSQLValueString(trim(strtoupper($matches10[17][$x])), "text"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset22 = sprintf(
            "/* PARSEADORES1 includes\spcrearjuegos.php - QUERY 6 */ SELECT *
FROM p1equipos
WHERE  
nomequipop1 = %s",
            GetSQLValueString(trim(strtoupper($matches10[17][$x])), "text")
        );
        $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
        $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
        $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
    }
    //echo $totalRows_Recordset22;
    //echo "</br>";
    //echo $row_Recordset22['Id_p1equiposp1'];
    //echo "</br>";
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 includes\spcrearjuegos.php - QUERY 7 */ SELECT * 
FROM p2juegos 
WHERE  
idequipo1p2 = %s  AND
pichee1p2 = %s  AND
idequipo2p2 = %s  AND
pichee2p2 = %s  AND
iniciodtp2 >= %s  AND
iniciodtp2 <= %s",
        GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
        GetSQLValueString(trim($matches10[16][$x]), "text"),
        GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
        GetSQLValueString(trim($matches10[18][$x]), "text"),
        GetSQLValueString($ano.'-'.$mes.'-'.$dia." 00:00:01", "date"),
        GetSQLValueString($ano.'-'.$mes.'-'.$dia." 23:59:59", "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    //echo $totalRows_Recordset1;
    //echo "</br>";
    echo $totalRows_Recordset1;
    if ($totalRows_Recordset1==0) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 includes\spcrearjuegos.php - QUERY 8 */ INSERT 
				INTO p2juegos
				(idequipo1p2, idequipo2p2, competicionp2, deportep2, pichee1p2, pichee2p2, iniciodtp2, paisp2) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
            GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
            GetSQLValueString("MLB", "text"),
            GetSQLValueString("Baseball", "text"),
            GetSQLValueString($matches10[16][$x], "text"),
            GetSQLValueString($matches10[18][$x], "text"),
            GetSQLValueString($datetime, "date"),
            GetSQLValueString("ESTADOS UNIDOS", "text")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    }

    $x++;
}
      echo "</br>";echo "</br>";echo "</br>";echo "</br>";
      //echo $x;
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
// $a = array ($hipodomo, $numeroca);
// echo "<pre>";
// print_r($a);
// echo "</pre>";
?>
</pre>
</body>
<!-- InstanceEnd --></html>
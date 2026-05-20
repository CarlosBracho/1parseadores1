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
<p>(.*) PM<\/p>
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
    echo "</br>";
    echo $matches10[14][$x];
    echo "</br>";
    $piche1 = str_replace(")", ",", $matches10[15][$x]);
    $piche1 = $piche1;
    $piche1 = explode(", ", $piche1);
    $piche1=$piche1[0];
    echo $piche1;
    echo "</br>";
    echo $matches10[16][$x];
    echo "</br>";
    $piche2 = str_replace(")", ",", $matches10[17][$x]);
    $piche2 = $piche2;
    $piche2 = explode(", ", $piche2);
    $piche2=$piche2[0];
    echo $piche2;
    echo "</br>";
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 1 */ SELECT *
FROM p1equipos
WHERE  
nomequipop1 = %s",
        GetSQLValueString(trim(strtoupper($matches10[14][$x])), "text")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    //echo $totalRows_Recordset21;
    //echo "</br>";
    //echo $row_Recordset21['Id_p1equiposp1'];
    //echo "</br>";
    $query_Recordset22 = sprintf(
        "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 2 */ SELECT *
FROM p1equipos
WHERE  
nomequipop1 = %s",
        GetSQLValueString(trim(strtoupper($matches10[16][$x])), "text")
    );
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
    //echo $totalRows_Recordset22;
    //echo "</br>";
    //echo $row_Recordset22['Id_p1equiposp1'];
    //echo "</br>";
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 3 */ SELECT * 
FROM p2juegos 
WHERE  
idequipo1p2 = %s  AND
pichee1p2 = %s  AND
idequipo2p2 = %s  AND
pichee2p2 = %s  AND
iniciodtp2 >= %s  AND
iniciodtp2 <= %s",
        GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
        GetSQLValueString(trim($piche1), "text"),
        GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
        GetSQLValueString(trim($matches10[17][$x]), "text"),
        GetSQLValueString($FechaTxt." 00:00:01", "date"),
        GetSQLValueString($FechaTxt." 23:59:59", "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    //echo $totalRows_Recordset1;
    //echo "</br>";



    $iML=$matches10[18][$x];
    $iML = str_replace(" ", "", $iML);
    preg_match_all("%<span>
<label>(.*)<\/label>
<\/span>
<span>
<label>(.*)<\/label>
<\/span>%siU", $iML, $matchesML);
    echo "ML e1 ";
    echo $matchesML[1][0];
    echo "</br>";
    echo "ML e2 ";
    echo $matchesML[2][0];



    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 4 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'ML'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        if ($row_Recordset2['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 5 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesML[1][0], "text"),
                GetSQLValueString(0, "text"),
                GetSQLValueString($row_Recordset2['Id_p3logrosp3'], "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 6 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString("ML", "text"),
                GetSQLValueString($matchesML[1][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString(0, "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 7 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'ML'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($row_Recordset3['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 8 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesML[2][0], "text"),
                GetSQLValueString(0, "text"),
                GetSQLValueString($row_Recordset3['Id_p3logrosp3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 9 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString(2, "int"),
                GetSQLValueString("ML", "text"),
                GetSQLValueString($matchesML[2][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString(0, "text")
            );
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    echo "</br>";


    echo "A/B ";
    $AB = str_replace(" ", "", $matches10[3][$x]);
    $AB = str_replace("Alta/Baja(", "", $AB);
    $AB = str_replace(")", "", $AB);
    $AB = str_replace("<p>", "", $AB);
    $AB = str_replace("</p>", "", $AB);
    echo $AB;
    echo "</br>";

    $iAB=$matches10[19][$x];
    $iAB = str_replace(" ", "", $iAB);
    preg_match_all("%<span>
<label>

A


(.*)
<\/label>
<\/span>
<span>
<label>

B


(.*)
<\/label>
<\/span>%siU", $iAB, $matchesAB);
    echo "Alta L ";
    echo $matchesAB[1][0];
    echo "</br>";
    echo "Baja L ";
    echo $matchesAB[2][0];
    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 10 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'A'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        if ($row_Recordset2['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 11 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesAB[1][0], "text"),
                GetSQLValueString($AB, "text"),
                GetSQLValueString($row_Recordset2['Id_p3logrosp3'], "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 12 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString("A", "text"),
                GetSQLValueString($matchesAB[1][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($AB, "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 13 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'B'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($row_Recordset3['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 14 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesAB[2][0], "text"),
                GetSQLValueString($AB, "text"),
                GetSQLValueString($row_Recordset3['Id_p3logrosp3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 15 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString(2, "int"),
                GetSQLValueString("B", "text"),
                GetSQLValueString($matchesAB[2][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($AB, "text")
            );
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    echo "</br>";


    $iRL=$matches10[20][$x];
    $iRL= str_replace(" ", "", $iRL);
    preg_match_all("%<span>
<label>

(.*)

(.*)
<\/label>
<\/span>
<span>
<label>

(.*)

(.*)
<\/label>
<\/span>%siU", $iRL, $matchesRL);
    echo "RL ";
    echo $matchesRL[1][0];
    echo "</br>";
    echo "RL L";
    echo $matchesRL[2][0];
    echo "</br>";
    echo "RL ";
    echo $matchesRL[3][0];
    echo "</br>";
    echo "RL L";
    echo $matchesRL[4][0];
    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 16 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'RL'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        if ($row_Recordset2['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 17 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesRL[2][0], "text"),
                GetSQLValueString($matchesRL[1][0], "text"),
                GetSQLValueString($row_Recordset2['Id_p3logrosp3'], "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 18 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString("RL", "text"),
                GetSQLValueString($matchesRL[1][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($matchesRL[1][0], "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 19 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'RL'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($row_Recordset3['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 20 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesRL[4][0], "text"),
                GetSQLValueString($matchesRL[3][0], "text"),
                GetSQLValueString($row_Recordset3['Id_p3logrosp3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 21 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString(2, "int"),
                GetSQLValueString("RL", "text"),
                GetSQLValueString($matchesRL[4][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($matchesRL[3][0], "text")
            );
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    echo "</br>";


    $iML5in=$matches10[21][$x];
    $iML5in= str_replace(" ", "", $iML5in);
    preg_match_all("%<span>
<label>(.*)<\/label>
<\/span>
<span>
<label>(.*)<\/label>
<\/span>%siU", $iML5in, $matchesML5in);
    echo "ML5in e1 ";
    echo $matchesML5in[1][0];
    echo "</br>";
    echo "ML5in e2 ";
    echo $matchesML5in[2][0];
    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 22 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = '5ML'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        if ($row_Recordset2['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 23 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesML5in[1][0], "text"),
                GetSQLValueString(0, "text"),
                GetSQLValueString($row_Recordset2['Id_p3logrosp3'], "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 24 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString("5ML", "text"),
                GetSQLValueString($matchesML5in[1][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString(0, "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 25 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = '5ML'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($row_Recordset3['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 26 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesML5in[2][0], "text"),
                GetSQLValueString(0, "text"),
                GetSQLValueString($row_Recordset3['Id_p3logrosp3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 27 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString(2, "int"),
                GetSQLValueString("5ML", "text"),
                GetSQLValueString($matchesML5in[2][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString(0, "text")
            );
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    echo "</br>";

    echo "A/B 5in";
    $AB5in = str_replace(" ", "", $matches10[6][$x]);
    $AB5in = str_replace("A/B5toInn(", "", $AB5in);
    $AB5in = str_replace(")", "", $AB5in);
    $AB5in = str_replace("<p>", "", $AB5in);
    $AB5in = str_replace("</p>", "", $AB5in);
    echo $AB5in;
    echo "</br>";

    $iAB5in=$matches10[22][$x];
    $iAB5in = str_replace(" ", "", $iAB5in);
    preg_match_all("%<span>
<label>

A


(.*)
<\/label>
<\/span>
<span>
<label>

B


(.*)
<\/label>
<\/span>%siU", $iAB5in, $matchesAB5in);
    echo "Alta5in L ";
    echo $matchesAB5in[1][0];
    echo "</br>";
    echo "Baja5in L ";
    echo $matchesAB5in[2][0];
    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 28 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = '5A'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        if ($row_Recordset2['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 29 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesAB5in[1][0], "text"),
                GetSQLValueString($AB5in, "text"),
                GetSQLValueString($row_Recordset2['Id_p3logrosp3'], "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 30 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString("5A", "text"),
                GetSQLValueString($matchesAB5in[1][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($AB5in, "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 31 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = '5B'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($row_Recordset3['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 32 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesAB5in[2][0], "text"),
                GetSQLValueString($AB5in, "text"),
                GetSQLValueString($row_Recordset3['Id_p3logrosp3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 33 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString(2, "int"),
                GetSQLValueString("5B", "text"),
                GetSQLValueString($matchesAB5in[2][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($AB5in, "text")
            );
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    echo "</br>";

    $iRL5in=$matches10[20][$x];
    $iRL5in= str_replace(" ", "", $iRL5in);
    preg_match_all("%<span>
<label>

(.*)

(.*)
<\/label>
<\/span>
<span>
<label>

(.*)

(.*)
<\/label>
<\/span>%siU", $iRL5in, $matchesRL5in);
    echo "RL5in ";
    echo $matchesRL5in[1][0];
    echo "</br>";
    echo "RL5in L";
    echo $matchesRL5in[2][0];
    echo "</br>";
    echo "RL5in ";
    echo $matchesRL5in[3][0];
    echo "</br>";
    echo "RL5in L";
    echo $matchesRL5in[4][0];
    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 34 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = '5RL'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        if ($row_Recordset2['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 35 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesRL5in[2][0], "text"),
                GetSQLValueString($matchesRL5in[1][0], "text"),
                GetSQLValueString($row_Recordset2['Id_p3logrosp3'], "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 36 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString("5RL", "text"),
                GetSQLValueString($matchesRL5in[2][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($matchesRL5in[1][0], "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 37 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = '5RL'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($row_Recordset3['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 38 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesRL5in[4][0], "text"),
                GetSQLValueString($matchesRL5in[3][0], "text"),
                GetSQLValueString($row_Recordset3['Id_p3logrosp3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 39 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString(2, "int"),
                GetSQLValueString("5RL", "text"),
                GetSQLValueString($matchesRL5in[4][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($matchesRL5in[3][0], "text")
            );
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    echo "</br>";

    $Anota1ero=$matches10[26][$x];
    $Anota1ero = str_replace(" ", "", $Anota1ero);
    preg_match_all("%<span>
<label>(.*)<\/label>
<\/span>
<span>
<label>(.*)<\/label>
<\/span>%siU", $Anota1ero, $matchesAnota1ero);
    echo "Anota1ero e1 ";
    echo $matchesAnota1ero[1][0];
    echo "</br>";
    echo "Anota1ero e2 ";
    echo $matchesAnota1ero[2][0];
    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 40 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'AP'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        if ($row_Recordset2['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 41 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesAnota1ero[1][0], "text"),
                GetSQLValueString(0, "text"),
                GetSQLValueString($row_Recordset2['Id_p3logrosp3'], "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 42 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString("AP", "text"),
                GetSQLValueString($matchesAnota1ero[1][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString(0, "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 43 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'AP'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($row_Recordset3['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 44 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesAnota1ero[2][0], "text"),
                GetSQLValueString(0, "text"),
                GetSQLValueString($row_Recordset3['Id_p3logrosp3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 45 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString(2, "int"),
                GetSQLValueString("AP", "text"),
                GetSQLValueString($matchesAnota1ero[2][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString(0, "text")
            );
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    echo "</br>";

    //SINO
    $SINO=$matches10[27][$x];
    $SINO = str_replace(" ", "", $SINO);
    preg_match_all("%<span>
<label>

SI


(.*)
<\/label>
<\/span>
<span>
<label>

NO


(.*)
<\/label>
<\/span>%siU", $SINO, $matchesSINO);
    echo "SI ";
    echo $matchesSINO[1][0];
    echo "</br>";
    echo "NO ";
    echo $matchesSINO[2][0];
    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 46 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'SI'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        if ($row_Recordset2['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 47 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesSINO[1][0], "text"),
                GetSQLValueString(0, "text"),
                GetSQLValueString($row_Recordset2['Id_p3logrosp3'], "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 48 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString("SI", "text"),
                GetSQLValueString($matchesSINO[1][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString(0, "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 49 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'NO'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($row_Recordset3['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 50 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesSINO[2][0], "text"),
                GetSQLValueString(0, "text"),
                GetSQLValueString($row_Recordset3['Id_p3logrosp3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 51 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString(2, "int"),
                GetSQLValueString("NO", "text"),
                GetSQLValueString($matchesSINO[2][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString(0, "text")
            );
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    echo "</br>";

    //H+R+E
    echo "HCE";
    $HCE = str_replace(" ", "", $matches10[12][$x]);
    $HCE = str_replace("H+R+E(", "", $HCE);
    $HCE = str_replace(")", "", $HCE);
    $HCE = str_replace("<p>", "", $HCE);
    $HCE = str_replace("</p>", "", $HCE);
    echo $HCE;
    echo "</br>";
    $iABHCE=$matches10[28][$x];
    $iABHCE = str_replace(" ", "", $iABHCE);
    preg_match_all("%<span>
<label>

A


(.*)
<\/label>
<\/span>
<span>
<label>

B


(.*)
<\/label>
<\/span>%siU", $iABHCE, $matchesABHCE);
    echo "AltaHCE L ";
    echo $matchesABHCE[1][0];
    echo "</br>";
    echo "BajaHCE L ";
    echo $matchesABHCE[2][0];
    echo "</br>";
    if ($totalRows_Recordset1>0) {
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 52 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =1 AND
idjuegop3 = %s AND
tipojugadap3 = 'AG'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        if ($row_Recordset2['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 53 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesABHCE[1][0], "text"),
                GetSQLValueString($HCE, "text"),
                GetSQLValueString($row_Recordset2['Id_p3logrosp3'], "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 54 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString("AG", "text"),
                GetSQLValueString($matchesABHCE[1][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($HCE, "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 55 */ SELECT *
FROM  p3logros
WHERE 
equipop3 =2 AND
idjuegop3 = %s AND
tipojugadap3 = 'BG'",
            GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int")
        );
        $Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        if ($row_Recordset3['Id_p3logrosp3']>0) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 56 */ UPDATE p3logros 
				SET logrop3=%s, logroABoRLp3=%s			
				WHERE Id_p3logrosp3=%s",
                GetSQLValueString($matchesABHCE[2][0], "text"),
                GetSQLValueString($HCE, "text"),
                GetSQLValueString($row_Recordset3['Id_p3logrosp3'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\includes\splogrosparleyla.php - QUERY 57 */ INSERT 
				INTO p3logros
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['Id_p2juegosp2'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString(2, "int"),
                GetSQLValueString("BG", "text"),
                GetSQLValueString($matchesABHCE[2][0], "text"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($HCE, "text")
            );
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    echo "</br>";


    echo "</br>";

    echo "</br>";





    $x++;
}
      echo "</br>";echo "</br>";echo "</br>";echo "</br>";
      echo $x;
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
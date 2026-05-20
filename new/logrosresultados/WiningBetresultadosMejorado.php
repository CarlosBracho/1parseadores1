<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
//$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");

//echo "  ".$_SESSION['MM_nom_usuario'];

$usuario=$_SESSION['MM_nom_usuario'];
//echo $usuario.'<br>';


$url='http://localhost/new/logrosresultados/WiningBet.html';

//$url='http://localhost/mega/proyectosglobales/primertrabajo/apuestas/new/logrosresultados/WiningBet.html';


$horaTxt=horaactual(); $FechaTxt=fechaactualbd(); $fechahora=$FechaTxt.' '.$horaTxt;
$datetime =$fechahora; $datetime = strtotime('-6 hour', strtotime($datetime)); $datetime = date('Y-m-j H:i:s', $datetime);
echo $FechaTxt.'<br>';

echo substr($FechaTxt, 0, 5).'<br>';


$query_Recordset1771 = sprintf(
    "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 1 */ SELECT *
FROM variables 
WHERE  
variablenom = %s ",
    GetSQLValueString('fechalogrosresultados', "text")
);
$Recordset1771 = mysqli_query($conexionbanca, $query_Recordset1771) or die(mysqli_error($conexionbanca));
$row_Recordset1771 = mysqli_fetch_assoc($Recordset1771);
$totalRows_Recordset1771 = mysqli_num_rows($Recordset1771);
$totaltotalRows=$totalRows_Recordset1771;
$FechaTxt=$row_Recordset1771['variabledat'];

$FechaTxtbr=$FechaTxt.'br';
echo $FechaTxt.'<br>';

$ja=0;
$juegos=0;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$datoscurl = curl_exec($ch);
curl_close($ch);
$datoscurl=preg_replace('/\s+/', 's7s', $datoscurl);
$datoscurl=str_replace('(', 'ZZ', $datoscurl); 
$datoscurl=str_replace(')', 'ZZ', $datoscurl);
$borrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"' , "/" , '%');
$datoscurl=str_replace($borrardecurl, '', $datoscurl);


$ja=0;



if(strlen($datoscurl)>100){

    
    $datoscurl=explode(substr($FechaTxt, 0, 5), $datoscurl);

    foreach ($datoscurl as $datoscurl2) { if(strpos($datoscurl2, 'VsOddsVS')) { 
        echo $datoscurl2.'<br>';
        
               preg_match_all("((.*)brspans7sclassVsOddsVSspanbr(.*)tds7stds7swidth25(.*)-(.*)tds7stds7sclasstext-center(.*))siU", $datoscurl2, $datoscurl3);
              

               $datoscurl3[2][0]=str_replace('s7s', ' ', $datoscurl3[2][0]);


               $datoscurl3[3][0]=str_replace('s7s', ' ', $datoscurl3[3][0]);


              $datoscurl3[4][0]=str_replace('s7s', ' ', $datoscurl3[4][0]);


    echo '1 >> '.$datoscurl3[1][0].' 2 >> '.$datoscurl3[2][0].' 3 >> '.$datoscurl3[3][0].' 4 >> '.$datoscurl3[4][0];

    $query_Recordset177 = sprintf(
        "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 2 */ SELECT Id_p2juegosp2, idequipo1p2, idequipo2p2, pichee1p2, pichee2p2, codWiningBet_empate, deportep2
    FROM p2juegos 
    WHERE  
    iniciodtp2 > %s AND
    iniciodtp2 < %s AND
    codWiningBet = %s ",
        GetSQLValueString(substr($FechaTxt, 0, 5).$datoscurl3[1][0].' 00:00:01', "date"),
        GetSQLValueString(substr($FechaTxt, 0, 5).$datoscurl3[1][0].' 23:59:59', "date"),
        GetSQLValueString($datoscurl3[3][0], "int")
    );
    $Recordset177 = mysqli_query($conexionbanca, $query_Recordset177) or die(mysqli_error($conexionbanca));
    $row_Recordset177 = mysqli_fetch_assoc($Recordset177);
    $totalRows_Recordset177 = mysqli_num_rows($Recordset177);
    $totaltotalRows=$totalRows_Recordset177;
    $deportep2=0;
    $deportep2=$row_Recordset177['deportep2'];
    echo ' deporte >> '.$deportep2.' total row >>  '.$totalRows_Recordset177;
    $FechaTxt77=substr($FechaTxt, 0, 5).$datoscurl3[1][0];
    



echo ' -- salto <br><br><br>';

if($totalRows_Recordset177==1){
    if($deportep2=='futbol'){ echo ' Futbol '; $ja++; echo '# '.$ja.' '.strlen($datoscurl2);

        //preg_match_all("(spanclassVsOddsVSspanbr(.*)tdtdwidth25(.*)-(.*)tdtdclasstext-center(.*)tdtdclasstext-center(.*)tdtrtr(.*)width25(.*)-(.*)tdtdclasstext-center(.*)tdtdclasstext-center(.*)tdtrt(.*))siU", $datoscurl2, $datoscurl3);
        preg_match_all("(spans7sclassVsOddsVSspanbr(.*)tds7stds7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7strs7strs7s(.*)s7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7strs7st(.*))siU", $datoscurl2, $datoscurl3);

        $nombree1=str_replace('s7s', ' ', $datoscurl3[3][0]);
        $nombree2=str_replace('s7s', ' ', $datoscurl3[8][0]);
        echo $datoscurl3[1][0].' - '.$datoscurl3[2][0].' - '.$nombree1.' - '.$datoscurl3[4][0].' - '.$datoscurl3[5][0].' - '.$nombree2.' - '.' - '.$datoscurl3[9][0].' - '.$datoscurl3[10][0].'<br>';
   

        $Resultadotp1=$datoscurl3[4][0]-$datoscurl3[5][0];
        $Resultadotp2=$datoscurl3[9][0]-$datoscurl3[10][0];
        
        
       // /*
        
        
        
        
        
        
                $query_Recordset14 = sprintf(
                    "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 3 */ SELECT * FROM p5resultadosj WHERE 
                        juegop5 = %s",
                    GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
                );
                $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
                $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
                $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
                
                if ($totalRows_Recordset14==0) {
                    if ($row_Recordset177['Id_p2juegosp2']>0) {
                        echo 'creando';
                        $insertSQL155 = sprintf(
                            "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 4 */ INSERT INTO p5resultadosj  
            (deportep5, juegop5, equipo1p5, equipo2p5, anotaprimerop5, iniciodtp5, tiemposjugadosp5,
             r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
             r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
             r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, 
            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
            %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString("futbol", "text"),
                            GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
                            GetSQLValueString($nombree1, "text"),
                            GetSQLValueString($nombree2, "text"),
                            GetSQLValueString("", "text"),
                            GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                            GetSQLValueString(2, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString($datoscurl3[5][0], "int"),
                            GetSQLValueString($datoscurl3[10][0], "int"),
                            GetSQLValueString($Resultadotp1, "int"),
                            GetSQLValueString($Resultadotp2, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int")
                        );
                        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
                    }
                } else {
                    echo 'actualizando';
            
                    $insertSQL155 = sprintf(
                        "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 5 */ UPDATE p5resultadosj  SET 
            deportep5=%s, equipo1p5=%s, equipo2p5=%s, anotaprimerop5=%s, tiemposjugadosp5=%s, iniciodtp5=%s,
            r1p5=%s, r2p5=%s, r3p5=%s, r4p5=%s, r5p5=%s, r6p5=%s, r7p5=%s, r8p5=%s, r9p5=%s, r10p5=%s, r11p5=%s, r12p5=%s, r13p5=%s, r14p5=%s, r15p5=%s, r16p5=%s, r17p5=%s, r18p5=%s, r19p5=%s, r20p5=%s, r21p5=%s, r22p5=%s, r23p5=%s, r24p5=%s, r25p5=%s, r26p5=%s, r27p5=%s, r28p5=%s, r29p5=%s, r30p5=%s
            WHERE juegop5=%s",
                            GetSQLValueString("futbol", "text"),
                            GetSQLValueString($nombree1, "text"),
                            GetSQLValueString($nombree2, "text"),
                            GetSQLValueString("", "text"),
                            
                            GetSQLValueString(2, "int"),
                            GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString($datoscurl3[5][0], "int"),
                            GetSQLValueString($datoscurl3[10][0], "int"),
                            GetSQLValueString($Resultadotp1, "int"),
                            GetSQLValueString($Resultadotp2, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                        GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
                    );
                    $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
                }
        $Fechacal=$FechaTxt77;
        include('../parley/carculojparley.php');
        
        
        
        
        
       // */











    }
           if($deportep2=='beisbol'){ echo ' Beisbol '; $ja++; 
        //echo $datoscurl2.'<br><br><br>'; 
        
        
        
        
                preg_match_all("(spans7sclassVsOddsVSspanbr(.*)tds7stds7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7stds7srowspan2(.*)tds7stds7srowspan2(.*)tds7stds7srowspan2(.*)tds7strs7strs7(.*)width25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7strs7st(.*)width15s7sclasstext-center)siU", $datoscurl2, $datoscurl3);
                $nombree1=preg_replace('/\B([A-Z])/', ' $1', $datoscurl3[3][0]);
                $nombree1=str_replace('s7s', ' ', $datoscurl3[3][0]);
                $nombree2=preg_replace('/\B([A-Z])/', ' $1', $datoscurl3[11][0]);
                $nombree2=str_replace('s7s', ' ', $datoscurl3[11][0]);
                $anota1=preg_replace('/\B([A-Z])/', ' $1', $datoscurl3[7][0]);
                $anota1=str_replace('s7s', ' ', $datoscurl3[7][0]);
                echo $datoscurl3[1][0].' - '.$datoscurl3[2][0].' - '.$nombree1.' - '.$datoscurl3[4][0].' - '.$datoscurl3[5][0].' - '.$datoscurl3[6][0].' - '.$anota1.' - '.$datoscurl3[8][0].' - '.$nombree2.' - '.$datoscurl3[12][0].' - '.$datoscurl3[13][0].' -.. '.'<br>';
           
                
                echo '# '.$ja.' '.strlen($datoscurl2).'<br>';
            if($datoscurl3[8][0]=='NO'){$sinoj=2;}else{$sinoj=1;}
        
        

       $query_Recordset14 = sprintf(
        "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 6 */ SELECT * FROM p5resultadosj WHERE 
            juegop5 = %s",
        GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    
    if ($totalRows_Recordset14==0) {
        if ($row_Recordset177['Id_p2juegosp2']>0) {
            echo 'creando';
            $insertSQL155 = sprintf(
                "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 7 */ INSERT INTO p5resultadosj  
(deportep5, juegop5, equipo1p5, equipo2p5, anotaprimerop5, iniciodtp5, tiemposjugadosp5,
 r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
 r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
 r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString("beisbol", "text"),
                GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
                GetSQLValueString($nombree1, "text"),
                GetSQLValueString($nombree2, "text"),
                GetSQLValueString($anota1, "text"),
                GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                GetSQLValueString(2, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString($datoscurl3[4][0], "int"),
                GetSQLValueString($datoscurl3[12][0], "int"),
                GetSQLValueString($datoscurl3[5][0], "int"),
                GetSQLValueString($datoscurl3[13][0], "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString($sinoj, "int"),
                GetSQLValueString($datoscurl3[6][0], "int"),
                GetSQLValueString(0, "int")
            );
            $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
        }
    } else {
        echo 'actualizando';

        $insertSQL155 = sprintf(
            "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 8 */ UPDATE p5resultadosj  SET 
deportep5=%s, equipo1p5=%s, equipo2p5=%s, anotaprimerop5=%s, tiemposjugadosp5=%s, iniciodtp5=%s,
r1p5=%s, r2p5=%s, r3p5=%s, r4p5=%s, r5p5=%s, r6p5=%s, r7p5=%s, r8p5=%s, r9p5=%s, r10p5=%s, r11p5=%s, r12p5=%s, r13p5=%s, r14p5=%s, r15p5=%s, r16p5=%s, r17p5=%s, r18p5=%s, r19p5=%s, r20p5=%s, r21p5=%s, r22p5=%s, r23p5=%s, r24p5=%s, r25p5=%s, r26p5=%s, r27p5=%s, r28p5=%s, r29p5=%s, r30p5=%s
WHERE juegop5=%s",
                GetSQLValueString("beisbol", "text"),
                GetSQLValueString($nombree1, "text"),
                GetSQLValueString($nombree2, "text"),
                GetSQLValueString($anota1, "text"),
                
                GetSQLValueString(0, "int"),
                GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString($datoscurl3[4][0], "int"),
                GetSQLValueString($datoscurl3[12][0], "int"),
                GetSQLValueString($datoscurl3[5][0], "int"),
                GetSQLValueString($datoscurl3[13][0], "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString($sinoj, "int"),
                GetSQLValueString($datoscurl3[6][0], "int"),
            GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
        );
        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
    }

    $Fechacal=$FechaTxt77;
 include('../parley/carculojparley.php');










}
if($deportep2=='beisbol'){ echo ' Beisbol '; $ja++; 
    //echo $datoscurl2.'<br><br><br>'; 
    
    
    
    
            preg_match_all("(spans7sclassVsOddsVSspanbr(.*)tds7stds7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7stds7srowspan2(.*)tds7stds7srowspan2(.*)tds7stds7srowspan2(.*)tds7strs7strs7(.*)width25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7strs7st(.*)width15s7sclasstext-center)siU", $datoscurl2, $datoscurl3);
            $nombree1=preg_replace('/\B([A-Z])/', ' $1', $datoscurl3[3][0]);
            $nombree1=str_replace('s7s', ' ', $datoscurl3[3][0]);
            $nombree2=preg_replace('/\B([A-Z])/', ' $1', $datoscurl3[11][0]);
            $nombree2=str_replace('s7s', ' ', $datoscurl3[11][0]);
            $anota1=preg_replace('/\B([A-Z])/', ' $1', $datoscurl3[7][0]);
            $anota1=str_replace('s7s', ' ', $datoscurl3[7][0]);
            echo $datoscurl3[1][0].' - '.$datoscurl3[2][0].' - '.$nombree1.' - '.$datoscurl3[4][0].' - '.$datoscurl3[5][0].' - '.$datoscurl3[6][0].' - '.$anota1.' - '.$datoscurl3[8][0].' - '.$nombree2.' - '.$datoscurl3[12][0].' - '.$datoscurl3[13][0].' -.. '.'<br>';
       
            
            echo '# '.$ja.' '.strlen($datoscurl2).'<br>';
        if($datoscurl3[8][0]=='NO'){$sinoj=0;}else{$sinoj=1;}
    
    

   $query_Recordset14 = sprintf(
    "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 9 */ SELECT * FROM p5resultadosj WHERE 
        juegop5 = %s",
    GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
);
$Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
$row_Recordset14 = mysqli_fetch_assoc($Recordset14);
$totalRows_Recordset14 = mysqli_num_rows($Recordset14);

if ($totalRows_Recordset14==0) {
    if ($row_Recordset177['Id_p2juegosp2']>0) {
        echo 'creando';
        $insertSQL155 = sprintf(
            "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 10 */ INSERT INTO p5resultadosj  
(deportep5, juegop5, equipo1p5, equipo2p5, anotaprimerop5, iniciodtp5, tiemposjugadosp5,
r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString("beisbol", "text"),
            GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
            GetSQLValueString($nombree1, "text"),
            GetSQLValueString($nombree2, "text"),
            GetSQLValueString($anota1, "text"),
            GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
            GetSQLValueString(2, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString($datoscurl3[4][0], "int"),
            GetSQLValueString($datoscurl3[12][0], "int"),
            GetSQLValueString($datoscurl3[5][0], "int"),
            GetSQLValueString($datoscurl3[13][0], "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString($sinoj, "int"),
            GetSQLValueString($datoscurl3[6][0], "int"),
            GetSQLValueString(0, "int")
        );
        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
    }
} else {
    echo 'actualizando';

    $insertSQL155 = sprintf(
        "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 11 */ UPDATE p5resultadosj  SET 
deportep5=%s, equipo1p5=%s, equipo2p5=%s, anotaprimerop5=%s, tiemposjugadosp5=%s, iniciodtp5=%s,
r1p5=%s, r2p5=%s, r3p5=%s, r4p5=%s, r5p5=%s, r6p5=%s, r7p5=%s, r8p5=%s, r9p5=%s, r10p5=%s, r11p5=%s, r12p5=%s, r13p5=%s, r14p5=%s, r15p5=%s, r16p5=%s, r17p5=%s, r18p5=%s, r19p5=%s, r20p5=%s, r21p5=%s, r22p5=%s, r23p5=%s, r24p5=%s, r25p5=%s, r26p5=%s, r27p5=%s, r28p5=%s, r29p5=%s, r30p5=%s
WHERE juegop5=%s",
            GetSQLValueString("beisbol", "text"),
            GetSQLValueString($nombree1, "text"),
            GetSQLValueString($nombree2, "text"),
            GetSQLValueString($anota1, "text"),
            
            GetSQLValueString(0, "int"),
            GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString($datoscurl3[4][0], "int"),
            GetSQLValueString($datoscurl3[12][0], "int"),
            GetSQLValueString($datoscurl3[5][0], "int"),
            GetSQLValueString($datoscurl3[13][0], "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString($sinoj, "int"),
            GetSQLValueString($datoscurl3[6][0], "int"),
        GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
    );
    $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
}

$Fechacal=$FechaTxt77;
include('../parley/carculojparley.php');










}
    if($deportep2=='baloncesto'){ echo ' Baloncesto '; $ja++; echo '# '.$ja.' '.strlen($datoscurl2).'<br>';


        //preg_match_all("(spanclassVsOddsVSspanbr(.*)tdtdwidth25(.*)-(.*)tdtdclasstext-center(.*)tdtdclasstext-center(.*)tdtrtr(.*)width25(.*)-(.*)tdtdclasstext-center(.*)tdtdclasstext-center(.*)tdtrt(.*))siU", $datoscurl2, $datoscurl3);
        preg_match_all("(spans7sclassVsOddsVSspanbr(.*)tds7stds7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7strs7strs7s(.*)s7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7strs7st(.*))siU", $datoscurl2, $datoscurl3);

        $nombree1=str_replace('s7s', ' ', $datoscurl3[3][0]);
        $nombree2=str_replace('s7s', ' ', $datoscurl3[8][0]);
        echo $datoscurl3[1][0].' - '.$nombree1.' - '.$datoscurl3[4][0].' - '.$datoscurl3[5][0].' - '.$nombree2.' - '.' - '.$datoscurl3[9][0].' - '.$datoscurl3[10][0].'<br>';
      

///*
      
        $Resultadotp1=$datoscurl3[4][0]-$datoscurl3[5][0];
        $Resultadotp2=$datoscurl3[9][0]-$datoscurl3[10][0];
      
      
      
      
              $query_Recordset14 = sprintf(
                  "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 12 */ SELECT * FROM p5resultadosj WHERE 
                      juegop5 = %s",
                  GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
              );
              $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
              $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
              $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
              
              if ($totalRows_Recordset14==0) {
                  if ($row_Recordset177['Id_p2juegosp2']>0) {
                      echo 'creando';
                      $insertSQL155 = sprintf(
                          "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 13 */ INSERT INTO p5resultadosj  
          (deportep5, juegop5, equipo1p5, equipo2p5, anotaprimerop5, iniciodtp5, tiemposjugadosp5,
           r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
           r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
           r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
          VALUES (%s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                          GetSQLValueString("baloncesto", "text"),
                          GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
                          GetSQLValueString($nombree1, "text"),
                          GetSQLValueString($nombree2, "text"),
                          GetSQLValueString("", "text"),
                          GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                          GetSQLValueString(2, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString($datoscurl3[5][0], "int"),
                          GetSQLValueString($datoscurl3[10][0], "int"),
                          GetSQLValueString($Resultadotp1, "int"),
                          GetSQLValueString($Resultadotp2, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int")
                      );
                      $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
                  }
              } else {
                  echo 'actualizando';
          
                  $insertSQL155 = sprintf(
                      "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 14 */ UPDATE p5resultadosj  SET 
          deportep5=%s, equipo1p5=%s, equipo2p5=%s, anotaprimerop5=%s, tiemposjugadosp5=%s, iniciodtp5=%s,
          r1p5=%s, r2p5=%s, r3p5=%s, r4p5=%s, r5p5=%s, r6p5=%s, r7p5=%s, r8p5=%s, r9p5=%s, r10p5=%s, r11p5=%s, r12p5=%s, r13p5=%s, r14p5=%s, r15p5=%s, r16p5=%s, r17p5=%s, r18p5=%s, r19p5=%s, r20p5=%s, r21p5=%s, r22p5=%s, r23p5=%s, r24p5=%s, r25p5=%s, r26p5=%s, r27p5=%s, r28p5=%s, r29p5=%s, r30p5=%s
          WHERE juegop5=%s",
                          GetSQLValueString("baloncesto", "text"),
                          GetSQLValueString($nombree1, "text"),
                          GetSQLValueString($nombree2, "text"),
                          GetSQLValueString("", "text"),
                          
                          GetSQLValueString(2, "int"),
                          GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString($datoscurl3[5][0], "int"),
                          GetSQLValueString($datoscurl3[10][0], "int"),
                          GetSQLValueString($Resultadotp1, "int"),
                          GetSQLValueString($Resultadotp2, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                      GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
                  );
                  $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
              }
      
              $Fechacal=$FechaTxt77;
            include('../parley/carculojparley.php');
      
      
      
      
      
      //*/


    }

    if($deportep2=='futbolamericano'){ echo ' futbolamericano '; $ja++; echo '# '.$ja.' '.strlen($datoscurl2).'<br>';


        //preg_match_all("(spanclassVsOddsVSspanbr(.*)tdtdwidth25(.*)-(.*)tdtdclasstext-center(.*)tdtdclasstext-center(.*)tdtrtr(.*)width25(.*)-(.*)tdtdclasstext-center(.*)tdtdclasstext-center(.*)tdtrt(.*))siU", $datoscurl2, $datoscurl3);
        preg_match_all("(spans7sclassVsOddsVSspanbr(.*)tds7stds7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7strs7strs7s(.*)s7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7stds7sclasstext-center(.*)tds7strs7st(.*))siU", $datoscurl2, $datoscurl3);

        $nombree1=str_replace('s7s', ' ', $datoscurl3[3][0]);
        $nombree2=str_replace('s7s', ' ', $datoscurl3[8][0]);
        echo $datoscurl3[1][0].' - '.$nombree1.' - '.$datoscurl3[4][0].' - '.$datoscurl3[5][0].' - '.$nombree2.' - '.' - '.$datoscurl3[9][0].' - '.$datoscurl3[10][0].'<br>';
      

///*
      
        $Resultadotp1=$datoscurl3[4][0]-$datoscurl3[5][0];
        $Resultadotp2=$datoscurl3[9][0]-$datoscurl3[10][0];
      
      
      
      
              $query_Recordset14 = sprintf(
                  "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 15 */ SELECT * FROM p5resultadosj WHERE 
                      juegop5 = %s",
                  GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
              );
              $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
              $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
              $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
              
              if ($totalRows_Recordset14==0) {
                  if ($row_Recordset177['Id_p2juegosp2']>0) {
                      echo 'creando';
                      $insertSQL155 = sprintf(
                          "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 16 */ INSERT INTO p5resultadosj  
          (deportep5, juegop5, equipo1p5, equipo2p5, anotaprimerop5, iniciodtp5, tiemposjugadosp5,
           r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
           r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
           r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
          VALUES (%s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
          %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                          GetSQLValueString("futbolamericano", "text"),
                          GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
                          GetSQLValueString($nombree1, "text"),
                          GetSQLValueString($nombree2, "text"),
                          GetSQLValueString("", "text"),
                          GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                          GetSQLValueString(2, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString($datoscurl3[5][0], "int"),
                          GetSQLValueString($datoscurl3[10][0], "int"),
                          GetSQLValueString($Resultadotp1, "int"),
                          GetSQLValueString($Resultadotp2, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int")
                      );
                      $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
                  }
              } else {
                  echo 'actualizando';
          
                  $insertSQL155 = sprintf(
                      "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 17 */ UPDATE p5resultadosj  SET 
          deportep5=%s, equipo1p5=%s, equipo2p5=%s, anotaprimerop5=%s, tiemposjugadosp5=%s, iniciodtp5=%s,
          r1p5=%s, r2p5=%s, r3p5=%s, r4p5=%s, r5p5=%s, r6p5=%s, r7p5=%s, r8p5=%s, r9p5=%s, r10p5=%s, r11p5=%s, r12p5=%s, r13p5=%s, r14p5=%s, r15p5=%s, r16p5=%s, r17p5=%s, r18p5=%s, r19p5=%s, r20p5=%s, r21p5=%s, r22p5=%s, r23p5=%s, r24p5=%s, r25p5=%s, r26p5=%s, r27p5=%s, r28p5=%s, r29p5=%s, r30p5=%s
          WHERE juegop5=%s",
                          GetSQLValueString("futbolamericano", "text"),
                          GetSQLValueString($nombree1, "text"),
                          GetSQLValueString($nombree2, "text"),
                          GetSQLValueString("", "text"),
                          
                          GetSQLValueString(2, "int"),
                          GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString($datoscurl3[5][0], "int"),
                          GetSQLValueString($datoscurl3[10][0], "int"),
                          GetSQLValueString($Resultadotp1, "int"),
                          GetSQLValueString($Resultadotp2, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                          GetSQLValueString(0, "int"),
                      GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
                  );
                  $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
              }
      
              $Fechacal=$FechaTxt77;
            include('../parley/carculojparley.php');
      
      
      
      
      
      //*/


    }

    if($deportep2=='hockey'){ echo ' hockey '; $ja++; echo '# '.$ja.' '.strlen($datoscurl2);

       // preg_match_all("(spanclassVsOddsVSspanbr(.*)tdtdwidth(.*)-(.*)tdtdclasstext-center(.*)tdtrtr(.*)tdwidth(.*)-(.*)tdtdclasstext-center(.*)td(.*)tdrowspan2width15classtext-center)siU", $datoscurl2, $datoscurl3);

        preg_match_all("(spans7sclassVsOddsVSspanbr(.*)tds7stds7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)tds7strs7str(.*)tds7swidth25(.*)s7s-s7s(.*)tds7stds7sclasstext-center(.*)td(.*))siU", $datoscurl2, $datoscurl3);
        
        $nombree1=str_replace('s7s', ' ', $datoscurl3[3][0]);
        $nombree2=str_replace('s7s', ' ', $datoscurl3[7][0]);
        echo $datoscurl3[1][0].' - '.$datoscurl3[2][0].' - '.$nombree1.' - '.$datoscurl3[4][0].' - '.$datoscurl3[6][0].' - '.$nombree2.' - '.' - '.$datoscurl3[8][0].' - '.'<br>';
        
        $Resultadotp1=-$datoscurl3[4][0];
        $Resultadotp2=-$datoscurl3[8][0];

       // /*


        $query_Recordset14 = sprintf(
            "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 18 */ SELECT * FROM p5resultadosj WHERE 
                juegop5 = %s",
            GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
        );
        $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
        $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
        $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
        
        if ($totalRows_Recordset14==0) {
            if ($row_Recordset177['Id_p2juegosp2']>0) {
                echo 'creando';
                $insertSQL155 = sprintf(
                    "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 19 */ INSERT INTO p5resultadosj  
    (deportep5, juegop5, equipo1p5, equipo2p5, anotaprimerop5, iniciodtp5, tiemposjugadosp5,
     r1p5, r2p5, r3p5, r4p5, r5p5, r6p5, r7p5, r8p5, r9p5, r10p5, 
     r11p5, r12p5, r13p5, r14p5, r15p5, r16p5, r17p5, r18p5, r19p5, r20p5, 
     r21p5, r22p5, r23p5, r24p5, r25p5, r26p5, r27p5, r28p5, r29p5, r30p5, quienmete)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, 
    %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
    %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
    %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString("hockey", "text"),
                    GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int"),
                    GetSQLValueString($nombree1, "text"),
                    GetSQLValueString($nombree2, "text"),
                    GetSQLValueString("", "text"),
                    GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString($datoscurl3[4][0], "int"),
                    GetSQLValueString($datoscurl3[8][0], "int"),
                    GetSQLValueString($Resultadotp1, "int"),
                    GetSQLValueString($Resultadotp2, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int")
                );
                $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
            }
        } else {
            echo 'actualizando';
    
            $insertSQL155 = sprintf(
                "/* PARSEADORES1 new\logrosresultados\WiningBetresultadosMejorado.php - QUERY 20 */ UPDATE p5resultadosj  SET 
    deportep5=%s, equipo1p5=%s, equipo2p5=%s, anotaprimerop5=%s, tiemposjugadosp5=%s, iniciodtp5=%s,
    r1p5=%s, r2p5=%s, r3p5=%s, r4p5=%s, r5p5=%s, r6p5=%s, r7p5=%s, r8p5=%s, r9p5=%s, r10p5=%s, r11p5=%s, r12p5=%s, r13p5=%s, r14p5=%s, r15p5=%s, r16p5=%s, r17p5=%s, r18p5=%s, r19p5=%s, r20p5=%s, r21p5=%s, r22p5=%s, r23p5=%s, r24p5=%s, r25p5=%s, r26p5=%s, r27p5=%s, r28p5=%s, r29p5=%s, r30p5=%s
    WHERE juegop5=%s",
                    GetSQLValueString("hockey", "text"),
                    GetSQLValueString($nombree1, "text"),
                    GetSQLValueString($nombree2, "text"),
                    GetSQLValueString("", "text"),
                    
                    GetSQLValueString(0, "int"),
                    GetSQLValueString($FechaTxt77.' '.$datoscurl3[1][0], "date"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString($datoscurl3[4][0], "int"),
                    GetSQLValueString($datoscurl3[8][0], "int"),
                    GetSQLValueString($Resultadotp1, "int"),
                    GetSQLValueString($Resultadotp2, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int"),
                GetSQLValueString($row_Recordset177['Id_p2juegosp2'], "int")
            );
            $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
        }

        $Fechacal=$FechaTxt77;
      include('../parley/carculojparley.php');





//*/










    }


    echo '<br><br>';
}





}
}
}



/*/
$file = "WiningBet.html";
if (!unlink($file)) {
    echo("Error deleting $file");
} else {
   echo("Deleted $file");
   
    
    $msj='Se actualizaron ' .$ja. ' resultados en total desde Winninbet';
$msjx=utf8_encode($msj);
$post=[
  'chat_id'=>-576782283,
  'text'=>$msjx,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_exec ($ch);
curl_close ($ch);


}/*/
//*/
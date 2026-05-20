<?php
require_once('../Connections/conexionbanca.php');
//externo
//$hostname_conexionbanca = "172.104.217.49";$database_conexionbanca = "apuestas";$username_conexionbanca = "externo2021";$password_conexionbanca = "myAyO6*zvku";$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);mysqli_set_charset($conexionbanca, 'utf8');
//local
//$hostname_conexionbanca = "p:localhost";$database_conexionbanca = "apuestas";$username_conexionbanca = "root1";$password_conexionbanca = "CHCa5SHPHB9w";$conexionbanca = mysqli_connect($hostname_conexionbanca, $username_conexionbanca, $password_conexionbanca, $database_conexionbanca);mysqli_set_charset($conexionbanca, 'utf8');

$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;

function verificarjuego($cod_wuaosite)
{
    global $conexionbanca;

    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $datetime=$FechaTxt.' '.$horaTxt;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 logros\wuao.site.php - QUERY 1 */ SELECT Id_p2juegosp2, idequipo1p2, idequipo2p2, pichee1p2, pichee2p2, cod_wuaosite_empate
    FROM p2juegos 
    WHERE  
    cod_wuaosite = %s ",
        GetSQLValueString($cod_wuaosite, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $totaltotalRows=$totalRows_Recordset1;
    $Id_p2juegosp2=$row_Recordset1['Id_p2juegosp2'];
    $idequipo1p2=$row_Recordset1['idequipo1p2'];
    $idequipo2p2=$row_Recordset1['idequipo2p2'];
    $pichee1p2=$row_Recordset1['pichee1p2'];
    $pichee2p2=$row_Recordset1['pichee2p2'];
    $cod_wuaosite_empate=$row_Recordset1['cod_wuaosite_empate'];
    return array($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2, $cod_wuaosite_empate);
}
function verificarlogro($Id_p2juegosp2, $equipo, $tipol)
{
    global $conexionbanca;

    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $datetime=$FechaTxt.' '.$horaTxt;
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 logros\wuao.site.php - QUERY 2 */ SELECT Id_p3logrosp3, logrop3, logroABoRLp3, equipop3
    FROM  p3logros
    WHERE 
    equipop3 = %s AND
    idjuegop3 = %s AND
 
    tipojugadap3 = %s ",
        GetSQLValueString($equipo, "int"),
        GetSQLValueString($Id_p2juegosp2, "int"),
        GetSQLValueString($tipol, "text")
    );
    $Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    $totaltotalRowslogro=$totalRows_Recordset2;
    $Id_p3logrosp3=$row_Recordset2['Id_p3logrosp3'];
    $logrop3=$row_Recordset2['logrop3'];
    $logroABoRLp3=$row_Recordset2['logroABoRLp3'];
    $equipop3=$row_Recordset2['equipop3'];
    return array($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3);
}
function updatepiche($matches10px, $todox, $equipo)
{
    global $conexionbanca;

    if ($equipo==1) {
        $horaTxt=horaactual();
        $FechaTxt=fechaactualbd();
        $datetime=$FechaTxt.' '.$horaTxt;
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 logros\wuao.site.php - QUERY 3 */ UPDATE p2juegos  
SET pichee1p2=%s			
WHERE cod_wuaosite=%s",
            GetSQLValueString($matches10px, "text"),
            GetSQLValueString($todox, "int")
        );
        // $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or trigger_error("Query Failed! SQL: $insertSQL1 - Error: ".mysqli_error($conexionbanca), E_USER_ERROR);
    }
    if ($equipo==2) {
        $horaTxt=horaactual();
        $FechaTxt=fechaactualbd();
        $datetime=$FechaTxt.' '.$horaTxt;
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 logros\wuao.site.php - QUERY 4 */ UPDATE p2juegos  
SET pichee2p2=%s			
WHERE cod_wuaosite=%s",
            GetSQLValueString($matches10px, "text"),
            GetSQLValueString($todox, "int")
        );
        //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or trigger_error("Query Failed! SQL: $insertSQL1 - Error: ".mysqli_error($conexionbanca), E_USER_ERROR);
    }
}
function updatelogro($todolo1, $todolo2, $Id_p3logrosp3)
{
    global $conexionbanca;

    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $datetime=$FechaTxt.' '.$horaTxt;
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 logros\wuao.site.php - QUERY 5 */ UPDATE p3logros 
      SET logrop3=%s, logroABoRLp3=%s			
      WHERE Id_p3logrosp3=%s",
        GetSQLValueString($todolo1, "text"),
        GetSQLValueString($todolo2, "text"),
        GetSQLValueString($Id_p3logrosp3, "int")
    );
      
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
}
function insertlogro($Id_p2juegosp2in, $Id_p1equiposp1in, $equipoin, $todoin1, $todoin2, $datetimein, $todoin3)
{
    global $conexionbanca;

    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $datetime=$FechaTxt.' '.$horaTxt;
    $insertSQL = sprintf(
        "/* PARSEADORES1 logros\wuao.site.php - QUERY 6 */ INSERT 
INTO p3logros
(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($Id_p2juegosp2in, "int"),
        GetSQLValueString($Id_p1equiposp1in, "int"),
        GetSQLValueString($equipoin, "int"),
        GetSQLValueString($todoin1, "text"),
        GetSQLValueString($todoin2, "text"),
        GetSQLValueString($datetimein, "date"),
        GetSQLValueString($todoin3, "text")
    );

    $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
}











$query_Recordsetuno1 = sprintf(
    "/* PARSEADORES1 logros\wuao.site.php - QUERY 7 */ SELECT Id_p2juegosp2 
FROM p2juegos 
WHERE  
iniciodtp2 >= %s  AND
iniciodtp2 <= %s",
    GetSQLValueString($FechaTxt." 00:00:00", "date"),
    GetSQLValueString($FechaTxt." 24:00:00", "date")
);
$Recordsetuno1 = mysqli_query($conexionbanca, $query_Recordsetuno1) or die(mysqli_error($conexionbanca));
$row_Recordsetuno1 = mysqli_fetch_assoc($Recordsetuno1);
$totalRows_Recordsetuno1 = mysqli_num_rows($Recordsetuno1);



if ($totalRows_Recordsetuno1==0) {
    $insertSQL = sprintf(
        "/* PARSEADORES1 logros\wuao.site.php - QUERY 8 */ INSERT 
INTO p3logros
(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString(999999, "int"),
        GetSQLValueString(999999, "int"),
        GetSQLValueString('100', "int"),
        GetSQLValueString("ML", "text"),
        GetSQLValueString('100', "text"),
        GetSQLValueString($FechaTxt.' 23:59:59', "date"),
        GetSQLValueString('2', "text")
    );

    $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
}








echo $datetime;
echo "</br>";echo "</br>";
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
//	$url='https://parley.la/logros';
$url='http://localhost/gacetas/Vendedor.html';
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


    
    
    
    
    
    
    
    
 
$result = str_replace("return ", "", $result);
$result = str_replace("(", "", $result);
$result = str_replace(")", "", $result);
    preg_match_all("%id=\"(.*)\" onmouseover=\"changeCellthis\" onmouseout=\"changeCellOutthis\" class=\"(.*)\">%siU", $result, $matches10);

    
    $x=0;
    foreach ($matches10[2] as $datos) {
        $todo=$matches10[2][$x];
        $todo = explode(",", $todo);

        echo $todo[9];
        echo " . . .";
        echo $todo[8];
        echo " . . .";
        echo $todo[5];
        echo " . . .";
    
    
    
        //comienza el futbol

        if ($todo[9]==3) {
            echo "es futbol";
            echo " . . .";

    

            list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2, $cod_wuaosite_empate)=verificarjuego($todo[8]);
            

            $empate=substr($todo[1], 0, 1);
            if ($empate=="E" && $totaltotalRows==0) {
                echo "juego no exicte es futbol y se creara";
                echo " . . .";
    
                if ($totaltotalRows==0) {
                    $datetime =$FechaTxt.' '.$todo[11];
                    $datetime = strtotime('-6 hour', strtotime($datetime));
                    $datetime = date('Y-m-j H:i:s', $datetime);
                    $insertSQL = sprintf(
                        "/* PARSEADORES1 logros\wuao.site.php - QUERY 9 */ INSERT 
				INTO p2juegos
				(deportep2, cod_wuaosite, cod_wuaosite_empate, iniciodtp2) 
				VALUES (%s, %s, %s, %s)",
                        GetSQLValueString("futbol", "text"),
                        GetSQLValueString($todo[8], "int"),
                        GetSQLValueString($todo[0], "int"),
                        GetSQLValueString($datetime, "date")
                    );
        
                    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));


                    list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2, $cod_wuaosite_empate)=verificarjuego($todo[8]);
                }
            }
    
            if ($empate!="E" && $totaltotalRows==1) {
                echo " . . .";
                echo "es futbol no empate";
                echo " . . .";
                $query_Recordset21 = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 10 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwuaosite = %s",
                    GetSQLValueString(trim($todo[5]), "text")
                );
                $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
                $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
                $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
                if ($totalRows_Recordset21==0) {
                    echo "se creo equipo de  futbol";
                    echo " . . .";
                    $insertSQL = sprintf(
                        "/* PARSEADORES1 logros\wuao.site.php - QUERY 11 */ INSERT 
				INTO p1equipos
				(nomequipop1, nomdimp1, nomwuaosite, deportep1, ordenp1) 
				VALUES (%s, %s, %s, %s, %s)",
                        GetSQLValueString(trim(strtoupper($todo[5])), "text"),
                        GetSQLValueString(trim(strtoupper($todo[5])), "text"),
                        GetSQLValueString(trim($todo[5]), "text"),
                        GetSQLValueString(2, "int"),
                        GetSQLValueString(0, "int")
                    );
        
                    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                    $query_Recordset21 = sprintf(
                        "/* PARSEADORES1 logros\wuao.site.php - QUERY 12 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwuaosite = %s",
                        GetSQLValueString(trim($todo[5]), "text")
                    );
                    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
                    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
                    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
                }
                $equipov=$cod_wuaosite_empate-$todo[0];
                if ($equipov==2) {
                    $equipo=1;
                } else {
                    $equipo=2;
                }
    
                if ($idequipo1p2=='' && $equipo==1) {
                    $insertSQL1 = sprintf(
                        "/* PARSEADORES1 logros\wuao.site.php - QUERY 13 */ UPDATE p2juegos 
				SET idequipo1p2=%s		
				WHERE
cod_wuaosite = %s",
                        GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "text"),
                        GetSQLValueString($todo[8], "int")
                    );
        
                    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                }
                if ($idequipo2p2=='' && $equipo==2) {
                    $insertSQL1 = sprintf(
                        "/* PARSEADORES1 logros\wuao.site.php - QUERY 14 */ UPDATE p2juegos 
				SET idequipo2p2=%s		
				WHERE
cod_wuaosite = %s",
                        GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "text"),
                        GetSQLValueString($todo[8], "int")
                    );
        
                    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                }

                if ($todo[1]=="ML") {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }


                if ($todo[1]=="A") {
                    $AB=$todo[2];
                    if ($totaltotalRows>0) {
                        list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                        verificarlogro($Id_p2juegosp2, 1, $todo[1]);

                        if ($Id_p3logrosp3>0) {
                            updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                        } else {
                            insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                        }
                    }
                }




                if ($todo[1]=="B") {
                    $AB=$todo[2];
                    if ($totaltotalRows>0) {
                        list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                        verificarlogro($Id_p2juegosp2, 2, $todo[1]);

                        if ($Id_p3logrosp3>0) {
                            updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                        } else {
                            insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                        }
                    }
                }

                if ($todo[1]=="RL") {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }

                if ($todo[1]=="5ML") {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }
            if ($empate=="E") {
                if ($todo[1]=="EML" && $totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 0, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        echo 'yyyyyyyy';
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 0, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
                if ($todo[1]=="E5ML" && $totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 0, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 0, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }
        }
    
    
    
    
    
    
    
    
    
    
        //termina el futbol
    
    
    
    
        //comienza el beisbol
    
        if ($todo[9]==4) {
            echo "es beisbol";
            echo " . . .";
            $query_Recordset21 = sprintf(
                "/* PARSEADORES1 logros\wuao.site.php - QUERY 15 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwuaosite = %s",
                GetSQLValueString(trim($todo[5]), "text")
            );
            $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
            $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
            $totalRows_Recordset21 = mysqli_num_rows($Recordset21);

            if ($totalRows_Recordset21==0) {
                echo "se creo equipo de  beisbol";
                echo " . . .";
                $insertSQL = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 16 */ INSERT 
				INTO p1equipos
				(nomequipop1, nomdimp1, nomwuaosite, deportep1, ordenp1) 
				VALUES (%s, %s, %s, %s, %s)",
                    GetSQLValueString(trim(strtoupper($todo[5])), "text"),
                    GetSQLValueString(trim(strtoupper($todo[5])), "text"),
                    GetSQLValueString(trim($todo[5]), "text"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(0, "int")
                );
        
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                $query_Recordset21 = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 17 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwuaosite = %s",
                    GetSQLValueString(trim($todo[5]), "text")
                );
                $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
                $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
                $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
            }



            list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($todo[8]);
            
            if ($totaltotalRows==0) {
                echo $totaltotalRows."juego no exicte es beisbol y se creara".$todo[8];
                echo " . . .";
                if ($totaltotalRows==0) {
                    $datetime =$FechaTxt.' '.$todo[11];
                    $datetime = strtotime('-6 hour', strtotime($datetime));
                    $datetime = date('Y-m-j H:i:s', $datetime);
                    $insertSQL = sprintf(
                        "/* PARSEADORES1 logros\wuao.site.php - QUERY 18 */ INSERT 
				INTO p2juegos
				(idequipo1p2, deportep2, cod_wuaosite, iniciodtp2) 
				VALUES (%s, %s, %s, %s)",
                        GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                        GetSQLValueString("beisbol", "text"),
                        GetSQLValueString($todo[8], "int"),
                        GetSQLValueString($datetime, "date")
                    );
        
                    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

                    list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($todo[8]);
                }
            }
            $query_Recordset22 = sprintf(
                "/* PARSEADORES1 logros\wuao.site.php - QUERY 19 */ SELECT Id_p1equiposp1, nomwuaosite
FROM p1equipos
WHERE  
Id_p1equiposp1 = %s",
                GetSQLValueString($idequipo1p2, "int")
            );
            $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
            $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
            $totalRows_Recordset22 = mysqli_num_rows($Recordset22);

            echo $row_Recordset22['nomwuaosite'];
            echo " . . .";
            echo trim($todo[5]);
            $nombresege=trim($todo[5]);
            echo " . . .";
            if ($idequipo2p2=="" && $row_Recordset22['nomwuaosite']!=$nombresege) {
                echo "segundo equipo";
                echo " . . .";
                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 20 */ UPDATE p2juegos 
				SET idequipo2p2=%s		
				WHERE Id_p2juegosp2=%s",
                    GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                    GetSQLValueString($Id_p2juegosp2, "int")
                );
        
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
            }
    
    
            if ($row_Recordset22['nomwuaosite']!=$nombresege) {
                $equipo=2;
            } else {
                $equipo=1;
            }
    
    
    
            if ($todo[1]=="ML") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }
    
    
    
    
            if ($todo[1]=="A") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 1, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }




            if ($todo[1]=="B") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 2, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }


            if ($todo[1]=="RL") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }


            if ($todo[1]=="5ML") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }
    
    
            if ($todo[1]=="5A") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 1, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }




            if ($todo[1]=="5B") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 2, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }


            if ($todo[1]=="5RL") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }


            if ($todo[1]=="SI") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, 1, $todo[1]);
                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }

            if ($todo[1]=="NO") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, 2, $todo[1]);

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }





            if ($todo[1]=="AP") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);
                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }



            if ($todo[1]=="5A") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 1, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }




            if ($todo[1]=="5B") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 2, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }


            if ($todo[1]=="AG") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 1, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }




            if ($todo[1]=="BG") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 2, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }
            // <tr class="table-light"><td><img width='22px' height='22px' class="img-fluid" src=https://www.mismarcadores.com/res/image/data/YsFz7vWg-6Ja0iGga.png > Padres de San Diego<p><small class="text-danger font-weight-bold">Mike Clevinger </small></p></td>

            $equipop=$nombresege;
            $resultp = str_replace("> ", ">", $result);
            $resultp = str_replace(" <", "<", $resultp);
            preg_match_all("%src=(.*)>$equipop<p><small class=\"text-danger font-weight-bold\">(.*)<\/small>%siU", $resultp, $matches10p);
            if ($equipo==1) {
                if ($matches10p[2][0]!=$pichee1p2) {
                    updatepiche($matches10p[2][0], $todo[8], $equipo);
                }
            }
            if ($equipo==2) {
                if ($matches10p[2][0]!=$pichee2p2) {
                    updatepiche($matches10p[2][0], $todo[8], $equipo);
                }
            }
        }
    
    
    
    
    
        
    
    
    
    
    
    
    
    
    
    
    
    
    
        if ($todo[9]==5) {
            echo "es futbolAME";
            echo " . . .";
        }
    
    
    
        //inicia baloncesto
    
        if ($todo[9]==6) {
            echo "es baloncesto";
            echo " . . .";
            $query_Recordset21 = sprintf(
                "/* PARSEADORES1 logros\wuao.site.php - QUERY 21 */ SELECT *
FROM p1equipos
WHERE  
nomwuaosite = %s",
                GetSQLValueString(trim($todo[5]), "text")
            );
            $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
            $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
            $totalRows_Recordset21 = mysqli_num_rows($Recordset21);

            if ($totalRows_Recordset21==0) {
                echo "se creo equipo de  baloncesto";
                echo " . . .";
                $insertSQL = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 22 */ INSERT 
				INTO p1equipos
				(nomequipop1, nomdimp1, nomwuaosite, deportep1, ordenp1) 
				VALUES (%s, %s, %s, %s, %s)",
                    GetSQLValueString(trim(strtoupper($todo[5])), "text"),
                    GetSQLValueString(trim(strtoupper($todo[5])), "text"),
                    GetSQLValueString(trim($todo[5]), "text"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString(0, "int")
                );
        
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                $query_Recordset21 = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 23 */ SELECT *
FROM p1equipos
WHERE  
nomwuaosite = %s",
                    GetSQLValueString(trim($todo[5]), "text")
                );
                $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
                $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
                $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
            }
            
            list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($todo[8]);
            
            if ($totaltotalRows==0) {
                echo "juego no exicte es baloncestol y se creara";
                echo " . . .";
                if ($totaltotalRows==0) {
                    $datetime =$FechaTxt.' '.$todo[11];
                    $datetime = strtotime('-6 hour', strtotime($datetime));
                    $datetime = date('Y-m-j H:i:s', $datetime);
                    $insertSQL = sprintf(
                        "/* PARSEADORES1 logros\wuao.site.php - QUERY 24 */ INSERT 
				INTO p2juegos
				(idequipo1p2, deportep2, cod_wuaosite, iniciodtp2) 
				VALUES (%s, %s, %s, %s)",
                        GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                        GetSQLValueString("baloncesto", "text"),
                        GetSQLValueString($todo[8], "int"),
                        GetSQLValueString($datetime, "date")
                    );
        
                    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

                    list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($todo[8]);
                }
            }
            $query_Recordset22 = sprintf(
                "/* PARSEADORES1 logros\wuao.site.php - QUERY 25 */ SELECT *
FROM p1equipos
WHERE  
Id_p1equiposp1 = %s",
                GetSQLValueString($idequipo1p2, "int")
            );
            $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
            $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
            $totalRows_Recordset22 = mysqli_num_rows($Recordset22);

            echo $row_Recordset22['nomwuaosite'];
            echo " . . .";
            echo trim($todo[5]);
            $nombresege=trim($todo[5]);
            echo " . . .";
            if ($idequipo2p2=="" && $row_Recordset22['nomwuaosite']!=$nombresege) {
                echo "segundo equipo";
                echo " . . .";
                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 26 */ UPDATE p2juegos 
				SET idequipo2p2=%s		
				WHERE Id_p2juegosp2=%s",
                    GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                    GetSQLValueString($Id_p2juegosp2, "int")
                );
        
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
            }
    
    
            if ($row_Recordset22['nomwuaosite']!=$nombresege) {
                $equipo=2;
            } else {
                $equipo=1;
            }
    
            if ($todo[1]=="ML") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }
    
            if ($todo[1]=="A") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 1, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }




            if ($todo[1]=="B") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 2, $todo[1]);

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }

            if ($todo[1]=="RL") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, $todo[1]);

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }


            if ($todo[1]=="5ML") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, "5ML");

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }
    
    
            if ($todo[1]=="5A") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 1, "5A");

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }




            if ($todo[1]=="5B") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 2, "5B");

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }


            if ($todo[1]=="5RL") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, "5RL");

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }
        }		 //fin baloncesto
    
    
    
    
    
        //inicia hockey
    
        if ($todo[9]==1) {
            echo "es hockey";
            echo " . . .";
            $query_Recordset21 = sprintf(
                "/* PARSEADORES1 logros\wuao.site.php - QUERY 27 */ SELECT *
FROM p1equipos
WHERE  
nomwuaosite = %s",
                GetSQLValueString(trim($todo[5]), "text")
            );
            $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
            $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
            $totalRows_Recordset21 = mysqli_num_rows($Recordset21);

            if ($totalRows_Recordset21==0) {
                echo "se creo equipo de  hockey";
                echo " . . .";
                $insertSQL = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 28 */ INSERT 
				INTO p1equipos
				(nomequipop1, nomdimp1, nomwuaosite, deportep1, ordenp1) 
				VALUES (%s, %s, %s, %s, %s)",
                    GetSQLValueString(trim(strtoupper($todo[5])), "text"),
                    GetSQLValueString(trim(strtoupper($todo[5])), "text"),
                    GetSQLValueString(trim($todo[5]), "text"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString(0, "int")
                );
        
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                $query_Recordset21 = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 29 */ SELECT *
FROM p1equipos
WHERE  
nomwuaosite = %s",
                    GetSQLValueString(trim($todo[5]), "text")
                );
                $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
                $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
                $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
            }
            
            list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($todo[8]);
            
            if ($totaltotalRows==0) {
                echo "juego no exicte es hockey y se creara";
                echo " . . .";
                if ($totaltotalRows==0) {
                    $datetime =$FechaTxt.' '.$todo[11];
                    $datetime = strtotime('-6 hour', strtotime($datetime));
                    $datetime = date('Y-m-j H:i:s', $datetime);
                    $insertSQL = sprintf(
                        "/* PARSEADORES1 logros\wuao.site.php - QUERY 30 */ INSERT 
				INTO p2juegos
				(idequipo1p2, deportep2, cod_wuaosite, iniciodtp2) 
				VALUES (%s, %s, %s, %s)",
                        GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                        GetSQLValueString("hockey", "text"),
                        GetSQLValueString($todo[8], "int"),
                        GetSQLValueString($datetime, "date")
                    );
        
                    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

                    list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($todo[8]);
                }
            }
            $query_Recordset22 = sprintf(
                "/* PARSEADORES1 logros\wuao.site.php - QUERY 31 */ SELECT *
FROM p1equipos
WHERE  
Id_p1equiposp1 = %s",
                GetSQLValueString($idequipo1p2, "int")
            );
            $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
            $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
            $totalRows_Recordset22 = mysqli_num_rows($Recordset22);

            echo $row_Recordset22['nomwuaosite'];
            echo " . . .";
            echo trim($todo[5]);
            $nombresege=trim($todo[5]);
            echo " . . .";
            if ($idequipo2p2=="" && $row_Recordset22['nomwuaosite']!=$nombresege) {
                echo "segundo equipo";
                echo " . . .";
                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 logros\wuao.site.php - QUERY 32 */ UPDATE p2juegos 
				SET idequipo2p2=%s		
				WHERE Id_p2juegosp2=%s",
                    GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                    GetSQLValueString($Id_p2juegosp2, "int")
                );
        
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
            }
    
    
            if ($row_Recordset22['nomwuaosite']!=$nombresege) {
                $equipo=2;
            } else {
                $equipo=1;
            }
    
            if ($todo[1]=="ML") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, "ML");

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }
    
            if ($todo[1]=="A") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 1, "A");

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }




            if ($todo[1]=="B") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarjuego($Id_p2juegosp2, 2, "B");

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }

            if ($todo[1]=="RL") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, "RL");

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }


            if ($todo[1]=="5ML") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, "5ML");

                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                }
            }
    
    
            if ($todo[1]=="5A") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, 1, "5A");

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }




            if ($todo[1]=="5B") {
                $AB=$todo[2];
                if ($totaltotalRows>0) {
                    list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                    verificarlogro($Id_p2juegosp2, '2', "5B");

                    if ($Id_p3logrosp3>0) {
                        updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                    } else {
                        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], $equipo, $todo[1], $todo[4], $datetime, $todo[2]);
                    }
                }
            }


            if ($todo[1]=="5RL") {
                list($totaltotalRowslogro, $Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
                verificarlogro($Id_p2juegosp2, $equipo, "5RL");




                if ($Id_p3logrosp3>0) {
                    updatelogro($todo[4], $todo[2], $Id_p3logrosp3);
                } else {
                    $insertSQL = sprintf(
                        "/* PARSEADORES1 logros\wuao.site.php - QUERY 33 */ INSERT 
				
				(idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
				VALUES (%s, %s, %s, %s, %s, %s, %s)",
                        GetSQLValueString($Id_p2juegosp2, "int"),
                        GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                        GetSQLValueString($equipo, "int"),
                        GetSQLValueString("5RL", "text"),
                        GetSQLValueString($todo[4], "text"),
                        GetSQLValueString($datetime, "date"),
                        GetSQLValueString($todo[2], "text")
                    );
        
                    $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                }
            }
        }		 //fin hockey
    
    
    
    
    
        echo "</br>";
        $x++;
    }
    
    
    
    
    
    
    
    
    
    
    echo "<pre>";
print_r($matches10[2]);
echo "</pre>";
echo "<pre>";
print_r($matches10[2][0]);
echo "</pre>";
$entre=$matches10[2][0];
$entre = explode(",", $entre);
echo "<pre>";
print_r($entre[1]);
echo "</pre>";

 $file = "../gacetas/Vendedor.html";
if (!unlink($file)) {
    echo("Error deleting $file");
} else {
    echo("Deleted $file");
}

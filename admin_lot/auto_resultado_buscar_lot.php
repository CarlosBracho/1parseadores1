<?php
function weekyear_hnac($date)
{
    list($year, $month, $day)=explode('-', $date);
    return strftime("%YW%W", mktime(0, 0, 0, $month, $day, $year));
}
function get_week_start_hnac($fecha)
{
    $dato=weekyear_hnac($fecha);
    $timestamp=strtotime($dato);
    return date('Y-m-d', $timestamp);
}
function get_week_end_hnac($fecha)
{
    list($year, $month, $day)=explode('-', $fecha);
    $dato=weekyear_hnac($fecha);
    $timestamp=strtotime($dato)+518400;
    return date('Y-m-d', $timestamp);
}
    $controlL=1;
    $controlA=1;
    require_once('../Connections/conexionbanca.php');
    include('../includes/simple_html_dom.php');
    $_POST["bu_sorteo"]=1;
    $_POST["fec_resultado"]=fechaactualbd();
    $diahoy=diaSegunFecha($_POST["fec_resultado"]);
    $cDia=loteriaHoyAdmin($diahoy);
    $fechaIni=get_week_start_hnac($_POST["fec_resultado"]);
    $fechaURL=$resultado = str_replace("-", "/", $_POST["fec_resultado"]);
    $fURL2=explode("/", $fechaURL);
    $fechaURL2=$fURL2[2]."/".$fURL2[1]."/".$fURL2[0];
    $sem1=weekyear_hnac($_POST["fec_resultado"]);
    $sem2=weekyear_hnac(fechaactualbd());
    $dia=diaSegunFecha($_POST["fec_resultado"]);
    if ($_POST["fec_resultado"]==fechaactualbd()) {
        $hora=horaactual();
    } else {
        $hora="23:00";
    }
    if (!isset($_POST["cod_banca"])) {
        $_POST["cod_banca"]=0;
    }
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 admin_lot\auto_resultado_buscar_lot.php - QUERY 1 */ SELECT 
		lo.nom_loteria, lo.id_loteria, lo.id_terminal, lo.tip_loteria, lo.let_loteria,
		so.nom_sorteo, so.hor_sorteo, so.id_sorteo,
		re.id_resultado, re.fec_resultado, re.num_resultado, re.sig_resultado
		FROM 
			sorteos so,
			loterias lo
		LEFT JOIN resultados_lot re ON re.id_loteria = lo.id_loteria AND re.fec_resultado = %s AND re.id_banca = %s 
		WHERE ((lo.tip_loteria = 1 OR lo.tip_loteria>=3) AND lo.est_loteria=1) AND 
		$cDia = 1 AND so.id_sorteo = lo.id_sorteo AND so.est_sorteo=1 AND re.num_resultado IS NULL AND
		so.hor_sorteo < %s
		ORDER BY  so.hor_sorteo, so.id_sorteo, lo.let_loteria, lo.tip_loteria ASC",
        GetSQLValueString($_POST["fec_resultado"], "date"),
        GetSQLValueString($_POST["cod_banca"], "int"),
        GetSQLValueString($hora, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $cLot=array(); $e=0;
    if ($totalRows_Recordset1>0) {
        do {
            $cLot[$e]=$row_Recordset1['id_loteria'];
            $e++;
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        //Paginas busqueda se resultados
        $urlFA = 'http://www.faunactiva.com.ve/result_ant2.php?fecha='.$fechaURL2;
        if ($sem1==$sem2) {
            $url = 'http://www.tuazar.com/loteria/resultados/semana/';
        } else {
            $url = 'http://www.tuazar.com/loteria/resultados/'.$fechaURL."/";
        }
        if ($_POST["fec_resultado"]=fechaactualbd()) {
            $urlLA = 'http://lottoactivo.com/resumen';
        }
        $rSorteo=array();
        $rSorteoAn=array();
        $resultados=array();
        $signo=array("ARI","TAU","GEM","CAN","LEO","VIR","LIB","ESC","SAG","CAP","ACU","PIS");
        if (isset($url)) {
            $html = file_get_html($url);
        }
        if (isset($urlLA)) {
            $htmlLA = file_get_html($urlLA);
        }
        if (isset($urlFA)) {
            $htmlFA = file_get_html($urlFA);
        }
        $c=0;
        if (isset($html)) {
            foreach ($html->find('div [class=col-md-8 resultados table-responsive]') as $article) {
                foreach ($article->find("text") as $article2) {
                    $resultados[$c]=trim($article2);
                    //echo $c."---------->".$resultados[$c].' <br>';
                    $c++;
                }
            }
        }
        $c=0;
        if (isset($htmlA)) {
            $htmlA= file_get_html($urlA);//animalitos
            foreach ($htmlA->find('div [class=col-md-8 resultados table-responsive]') as $article2) {
                foreach ($article2->find("text") as $article3) {
                    $resultadosA[$c]=trim($article3);
                    //echo $c."---------->".$resultadosA[$c].' <br>';
                    $c++;
                }
            }
        }
        $c=0;
        if ($dia==0) {
            $x=36;
        } else {
            $x=22+($dia*2);
        }
        if (isset($html)) {
            foreach ($resultados as $xres) {
                $pas=0;
                if ($xres=="TRIPLE ZULIA") {
                    $i=18;
                    $pas=1;
                    $y=0;
                    $z=74;
                    $nSorteo="ZULIA";
                    $cTriM="1-3-5-7";
                    $cTerM="2-4-6-8";
                    $cTriT="105-107-109-111";
                    $cTerT="106-108-110-112";
                    $cTriN="83-85-87-89";
                    $cTerN="84-86-88-90";
                }
                if ($xres=="CHANCE") {//$resultados[267]
                    $i=18;
                    $pas=1;
                    $y=243;
                    $z=74;
                    $nSorteo="CHANCE";
                    $cTriM="9-11-13-15";
                    $cTerM="10-12-14-16";
                    $cTriT="33-35-37-39";
                    $cTerT="34-36-38-40";
                    $cTriN="41-43-45-47";
                    $cTerN="42-44-46-48";
                }
                if ($xres=="TRIPLE TACHIRA") {//$resultados[510]
                    $i=18;
                    $pas=1;
                    $y=486;
                    $z=74;
                    $nSorteo="TACHIRA";
                    $cTriM="17-19-21-23";
                    $cTerM="18-20-22-24";
                    $cTriT="25-27-29-31";
                    $cTerT="26-28-30-32";
                    $cTriN="49-51-53-55";
                    $cTerN="50-52-54-56";
                }
                if ($xres=="TRIPLE LEON CCS") {//$resultados[753]
                    $i=18;
                    $pas=1;
                    $y=729;
                    $z=74;
                    $nSorteo="LEON CCS";
                    $cTriM="57-59-61-63";
                    $cTerM="58-60-62-64";
                    $cTriT="113-115-117-119";
                    $cTerT="114-116-118-120";
                    $cTriN="121-123-125-127";
                    $cTerN="122-124-126-128";
                }
                if ($xres=="TRIPLE GORDO ONLINE") {//$resultados[995]
                    $i=18;
                    $pas=1;
                    $y=971;
                    $z=56;
                    $nSorteo="TRIPLE GORDO";
                    $cTriM="265-267-269";
                    $cTerM="266-268-270";
                    $cTriT="273-275-277";
                    $cTerT="274-276-278";
                    $cTriN="281-283-285";
                    $cTerN="282-284-286";
                }
                if ($xres=="TRIPLE TIGRE") {//$resultados[996]
                    $i=18;
                    $pas=1;
                    $y=972;
                    $z=74;
                    $nSorteo="TIGRE";
                    $cTriM="145-147-149-151";
                    $cTerM="146-148-150-152";
                    $cTriT="153-155-157-159";
                    $cTerT="154-156-158-160";
                    $cTriN="161-163-165-167";
                    $cTerN="162-164-166-168";
                }
                if ($xres=="TRIPLE ZAMORANO") {//$resultados[1239]
                    $i=18;
                    $pas=1;
                    $y=1215;
                    $z=56;
                    $nSorteo="ZAMORANO";
                    $cTriM="65-67-69";
                    $cTerM="66-68-70";
                    $cTriT="71-73-75";
                    $cTerT="72-74-76";
                    $cTriN="77-79-81";
                    $cTerN="78-80-82";
                }
                if ($xres=="TRIPLE MANIA") {//$resultados[1428]
                    $i=18;
                    $pas=1;
                    $y=1404;
                    $z=74;
                    $nSorteo="MANIA";
                    $cTriM="217-219-221-223";
                    $cTerM="218-220-222-224";
                    $cTriT="225-227-229-231";
                    $cTerT="226-228-230-232";
                    $cTriN="233-235-237-239";
                    $cTerN="234-236-238-240";
                }
                if ($xres=="MULTI TRIPLE") {//$resultados[1671]
                    $i=18;
                    $pas=1;
                    $y=1647;
                    $z=74;
                    $nSorteo="MULTI TRIPLE";
                    $cTriM="241-243-245-247";
                    $cTerM="242-244-246-248";
                    $cTriT="249-251-253-255";
                    $cTerT="250-252-254-256";
                    $cTriN="257-259-261-263";
                    $cTerN="258-260-262-264";
                }
                if ($xres=="RIENTAL") {//$resultados[1916]
                    $i=18;
                    $pas=1;
                    $y=1892;
                    $z=74;
                    $nSorteo="ORIENTAL";
                    $cTriM="129-131-133-135";
                    $cTerM="130-132-134-136";
                    $cTriT="137-139-141-143";
                    $cTerT="138-140-142-144";
                    $cTriN="91-93-95-97";
                    $cTerN="92-94-96-98";
                }
                if ($xres=="TRIPLE CALIENTE") {//$resultados[2347] //$resultados[2159]
                    $i=18;
                    $pas=1;
                    $y=2135;
                    $z=74;
                    $nSorteo="CALIENTE";
                    $cTriM="193-195-197-199";
                    $cTerM="194-196-198-200";
                    $cTriT="201-203-205-207";
                    $cTerT="202-204-206-208";
                    $cTriN="209-211-213-215";
                    $cTerN="210-212-214-216";
                }
                if ($xres=="TRIPLE TRADICIONAL") {//$resultados[2590] //$resultados[2402]
                    $i=18;
                    $pas=1;
                    $y=2378;
                    $z=74;
                    $nSorteo="TRADICIONAL";
                    $cTriM="169-171-173-175";
                    $cTerM="170-172-174-176";
                    $cTriT="177-179-181-183";
                    $cTerT="178-180-182-184";
                    $cTriN="185-187-189-191";
                    $cTerN="186-188-190-192";
                }
                if ($pas==1 && $controlL==1) {
                    $k=0;
                    $pTriple=explode("-", $cTriM);
                    if (strpos($resultados[$x+$y], '-') === false && (in_array($pTriple[0], $cLot))) {
                        $rSorteo[$c][$k][0]=$cTriM; //codigos triple
                        $rSorteo[$c][$k][1]=$cTerM; //codigos terminal
                        $rSorteo[$c][$k][2]=$nSorteo; //nombre sorteo
                        $rSorteo[$c][$k][3]=$resultados[$x+$y]; //numero ganador A
                        $rSorteo[$c][$k][4]=$resultados[$x+$i+$y]; //numero ganador B
                        $rSorteo[$c][$k][5]=$resultados[$x+($i*2)+$y]; //numero ganador C
                        if ($xres=="TRIPLE ZAMORANO") {
                            $rSorteo[$c][$k][5]=$resultados[$x+$i+$y];
                        }
                        $rSorteo[$c][$k][6]=$resultados[$x+($i*2)+$y]; //numero ganador zodiacal
                        $rSorteo[$c][$k][7]=$resultados[$x+($i*3)+$y]; //numero ganador signo
                        if (!in_array($rSorteo[$c][$k][count($pTriple)+3], $signo)) {
                            $rSorteo[$c][$k][count($pTriple)+3]=0;
                        }
                        $rSorteo[$c][$k][8]="MAÑ";
                        $k++;
                    }
                    $pTriple=explode("-", $cTriT);
                    if (strpos($resultados[$x+74+$y], '-') === false && (in_array($pTriple[0], $cLot))) {
                        $rSorteo[$c][$k][0]=$cTriT; //codigos triple
                        $rSorteo[$c][$k][1]=$cTerT; //codigos terminal
                        $rSorteo[$c][$k][2]=$nSorteo; //codigos terminal
                        $rSorteo[$c][$k][3]=$resultados[$x+$z+$y]; //numero ganador A
                        $rSorteo[$c][$k][4]=$resultados[$x+$z+$i+$y]; //numero ganador B
                        $rSorteo[$c][$k][5]=$resultados[$x+$z+($i*2)+$y]; //numero ganador C
                        if ($xres=="TRIPLE ZAMORANO") {
                            $rSorteo[$c][$k][5]=$resultados[$x+$z+$i+$y];
                        }
                        $rSorteo[$c][$k][6]=$resultados[$x+$z+($i*2)+$y]; //numero ganador zodiacal
                        $rSorteo[$c][$k][7]=$resultados[$x+$z+($i*3)+$y]; //numero ganador signo
                        if (!in_array($rSorteo[$c][$k][count($pTriple)+3], $signo)) {
                            $rSorteo[$c][$k][count($pTriple)+3]=0;
                        }
                        $rSorteo[$c][$k][8]="TAR";
                        $k++;
                    }
                    $pTriple = explode("-", $cTriN);
                    if (strpos($resultados[$x+148+$y], '-') === false && (in_array($pTriple[0], $cLot))) {
                        $rSorteo[$c][$k][0]=$cTriN; //codigos triple
                        $rSorteo[$c][$k][1]=$cTerN; //codigos terminal
                        $rSorteo[$c][$k][2]=$nSorteo; //codigos terminal
                        $rSorteo[$c][$k][3]=$resultados[$x+($z*2)+$y]; //numero ganador A
                        $rSorteo[$c][$k][4]=$resultados[$x+($z*2)+$i+$y]; //numero ganador B
                        $rSorteo[$c][$k][5]=$resultados[$x+($z*2)+($i*2)+$y]; //numero ganador C
                        if ($xres=="TRIPLE ZAMORANO") {
                            $rSorteo[$c][$k][5]=$resultados[$x+($z*2)+$i+$y];
                        }	 //numero ganador C
                        $rSorteo[$c][$k][6]=$resultados[$x+($z*2)+($i*2)+$y]; //numero ganador zodiacal
                        $rSorteo[$c][$k][7]=$resultados[$x+($z*2)+($i*3)+$y]; //numero ganador signo
                        if (!in_array($rSorteo[$c][$k][count($pTriple)+3], $signo)) {
                            $rSorteo[$c][$k][count($pTriple)+3]=0;
                        }
                        $rSorteo[$c][$k][8]="NOC";
                    }
                    $pas=0;
                    $c++;
                }
            }//fin ciclo loterias
        }
        $k=0;
        if ($dia==0) {
            $t=14;
        } else {
            $t=$dia*2;
        }
        if (isset($htmlA)) {
            foreach ($resultadosA as $xres) {
                $pas=0;
                if ($xres=="LOTTO ACTIVO") {//$resultados[23]
                    $pas=2;
                    $y=-3;
                    $nSorteo="LOTTO ACTIVO";
                    $cTriM="100-101-289-292-293-295-294-290";
                }
                if ($xres=="FAUNA ACTIVA") {//$resultados[348]
                    $pas=2;
                    $y=322;
                    $nSorteo="FAUNA ACTIVA";
                    $cTriM="304-305-306-307-308-309-310-311";
                }
                if ($pas==2 && $controlA==1) {
                    $pTriple=explode("-", $cTriM);
                    $i=0;
                    foreach ($pTriple as $trip) {
                        if (strpos($resultadosA[$x+$y+2+($i*38)], '-') === false && (in_array($pTriple[0], $cLot))) {
                            //echo "aquii ";
                            $rSorteoAn[$k][0]=$trip;//codigos animalito
                            $rSorteoAn[$k][1]=$nSorteo." ".$resultadosA[$x+$y+($i*38)-$t];//nombre y hora sorteo
                            $rSorteoAn[$k][2]=$resultadosA[$x+$y+2+($i*38)]; //numero ganador
                            $rSorteoAn[$k][3]=$resultadosA[$x+$y+20+($i*38)]; //animal ganador
                            //echo $rSorteoAn[$k][1]." ".$rSorteoAn[$k][2]."<br/>";
                            $k++;
                        }
                        $i++;
                    }
                }
            }//fin ciclo animalitos
        }
        $k=0;
        if (isset($htmlLA)) {//LOTTO ACTIVO PAGINA OFICIAL
            $c=0;
            $f=0;
            $cTriM="100-101-289-292-293-295-294-290";
            $cTriM=explode("-", $cTriM);
            $nSorteo="LOTTO ACTIVO";
            foreach ($htmlLA->find('img') as $article) {
                $scr=explode("/", $article->src);//resultado
                $alt=$article->alt;//hora
                $animal=explode("_", $scr[7]);
                if (in_array($cTriM[$c], $cLot) && trim($animal[0])!="" && $animal[0]!="logolottoactivo") {
                    $rSorteoAn[$k][0]=$cTriM[$c];//codigos animalito
                    $rSorteoAn[$k][1]=$nSorteo." ".$alt;//nombre y hora sorteo
                    if ($animal[0]!="0" or $animal[0]!="00") {
                        $animal[0]=$animal[0]*1;
                    }
                    $rSorteoAn[$k][2]=$animal[0]; //numero ganador
                    $rSorteoAn[$k][3]="no disponible"; //animal ganador
                    //$resultados[$c]=$animal[0]; echo $c."---------->".$alt." * ".$resultados[$c].' <br>';
                    $k++;
                }
                $c++;
            }
        }
        if (isset($htmlFA)) {//FAUNA ACTIVA PAGINA OFICIAL
            $c=0;
            $f=0;
            $cTriM="304-305-306-307-308-309-310-311";
            $cTriM=explode("-", $cTriM);
            $nSorteo="FAUNA ACTIVA";
            foreach ($htmlFA->find('tr') as $article) {
                $scr=explode(" ", $article->find("text", 1));
                $hS[$f]=$scr[1];
                if ($scr[0]="SORTEO" && $f>1) {
                    foreach ($article->find('img') as $article2) {
                        $scr=$article2->src;
                        $arrSCR=explode("/", $scr);
                        $arrSCR2=explode(" ", $arrSCR[1]);
                        if (in_array($cTriM[$c], $cLot) && trim($arrSCR2[0])!="") {
                            $arrSCR3=explode(".", $arrSCR2[1]);
                            $rSorteoAn[$k][0]=$cTriM[$c];//codigos animalito
                            $rSorteoAn[$k][1]=$nSorteo." ".$hS[$f-1];//nombre y hora sorteo
                            $arrSCR2[0]=trim($arrSCR2[0]);
                            if ($arrSCR2[0]!="0" or $arrSCR2[0]!="00") {
                                $arrSCR2[0]=$arrSCR2[0]*1;
                            }
                            $rSorteoAn[$k][2]=$arrSCR2[0]; //numero ganador
                            $rSorteoAn[$k][3]=strtoupper($arrSCR3[0]); //animal ganador
                            //$resultados[$c]=trim($arrSCR2[0]);
                            //echo " ".$c."---------->".$resultados[$c].' <br>';
                            $k++;
                        }
                        $c++;
                    }
                }
                $f++;
            }
        }
        $s="";
        $p=0;
        if (isset($rSorteo) or isset($rSorteoAn)) {
            $id_banca=0;
            $t=0;
            $premiar=0;
            $xcBanca=0;
            $u=0;
            if (isset($rSorteo)) {
                foreach ($rSorteo as $xres1) {
                    foreach ($xres1 as $xres) {
                        $cod_triple=$xres[0];
                        $cod_termin=$xres[1];
                        $x_ganador[0]=$xres[3];
                        $x_ganador[1]=$xres[4];
                        $x_ganador[2]=$xres[5];
                        $x_ganador[3]=$xres[6];
                        $x_ganador[4]=$xres[7];
                        $pTriple = explode("-", $cod_triple);
                        $pTermin = explode("-", $cod_termin);
                        $signo=array("","ARI","TAU","GEM","CAN","LEO","VIR","LIB","ESC","SAG","CAP","ACU","PIS");
                        for ($i = 0; $i < count($pTriple); ++$i) {
                            if ($i==count($pTriple)-1) {
                                $cod_signo=array_search($x_ganador[$i+1], $signo);
                            } else {
                                $cod_signo=0;
                            }
                            $cod_signo=$cod_signo*1;
                            if (strlen(trim($x_ganador[$i]))==3) {
                                $query_Recordset13 =  sprintf(
                                    "/* PARSEADORES1 admin_lot\auto_resultado_buscar_lot.php - QUERY 2 */ SELECT re.num_resultado, re.sig_resultado, re.id_resultado
										FROM resultados_lot re WHERE id_loteria=%s AND fec_resultado=%s AND id_banca=%s LIMIT 1",
                                    GetSQLValueString($pTriple[$i], "int"),
                                    GetSQLValueString($_POST["fec_resultado"], "date"),
                                    GetSQLValueString($id_banca, "int")
                                );
                                $Recordset13=mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
                                $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
                                $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
                                if ($totalRows_Recordset13==0) {
                                    $insertSQL2 = sprintf(
                                        "/* PARSEADORES1 admin_lot\auto_resultado_buscar_lot.php - QUERY 3 */ INSERT 
											INTO resultados_lot 
											(num_resultado, id_loteria, sig_resultado, fec_resultado, id_banca) 
											VALUES (%s, %s, %s, %s, %s)",
                                        GetSQLValueString(trim($x_ganador[$i]), "text"),
                                        GetSQLValueString($pTriple[$i], "int"),
                                        GetSQLValueString($cod_signo, "int"),
                                        GetSQLValueString($_POST["fec_resultado"], "date"),
                                        GetSQLValueString($id_banca, "int")
                                    );
                                    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                                    $premiar=1;
                                } elseif ($row_Recordset13['num_resultado']!=$x_ganador[$i] or
                                        $row_Recordset13['sig_resultado']!=$cod_signo) {
                                    $insertSQL1 = sprintf(
                                        "/* PARSEADORES1 admin_lot\auto_resultado_buscar_lot.php - QUERY 4 */ UPDATE resultados_lot SET num_resultado=%s, sig_resultado=%s
											WHERE id_resultado=%s",
                                        GetSQLValueString($x_ganador[$i], "text"),
                                        GetSQLValueString($cod_signo, "int"),
                                        GetSQLValueString($row_Recordset13['id_resultado'], "int")
                                    );
                                    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                                    $premiar=1;
                                }
                                mysqli_free_result($Recordset13);
                            }
                            $premiar=0;
                            if ($premiar==1) {
                                $xpTriple=$pTriple[$i];
                                $xpTermin=$pTermin[$i];
                                $xganador=$x_ganador[$i];
                                include("../admin_lot/procesar_premios_lot.php");
                                if (isset($ticketPre)) {
                                    include("../admin_lot/procesar_ticket_premiados_lot.php");
                                }
                            }
                        }
                    }
                }
            }
            if (isset($rSorteoAn)) {
                $premiar=0;
                foreach ($rSorteoAn as $xres2) {
                    $termin=$xres2[2];
                    $cod_animal=$xres2[0];
                    if ($cod_animal>0) {
                        $query_Recordset13 =  sprintf(
                            "/* PARSEADORES1 admin_lot\auto_resultado_buscar_lot.php - QUERY 5 */ SELECT re.num_resultado, re.sig_resultado, re.id_resultado
								FROM resultados_lot re WHERE id_loteria=%s AND fec_resultado=%s AND id_banca=%s LIMIT 1",
                            GetSQLValueString($cod_animal, "int"),
                            GetSQLValueString($_POST["fec_resultado"], "date"),
                            GetSQLValueString($id_banca, "int")
                        );
                        $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
                        $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
                        $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
                        if ($totalRows_Recordset13==0) {
                            $insertSQL2 = sprintf(
                                "/* PARSEADORES1 admin_lot\auto_resultado_buscar_lot.php - QUERY 6 */ INSERT 
									INTO resultados_lot 
									(num_resultado, id_loteria, fec_resultado, id_banca) 
									VALUES (%s, %s, %s, %s)",
                                GetSQLValueString(trim($termin), "text"),
                                GetSQLValueString($cod_animal, "int"),
                                GetSQLValueString($_POST["fec_resultado"], "date"),
                                GetSQLValueString($id_banca, "int")
                            );
                            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                            $premiar=1;
                        } elseif ($row_Recordset13['num_resultado']!=$termin) {
                            $insertSQL1 = sprintf(
                                "/* PARSEADORES1 admin_lot\auto_resultado_buscar_lot.php - QUERY 7 */ UPDATE resultados_lot SET num_resultado=%s 
									WHERE id_resultado=%s",
                                GetSQLValueString($termin, "text"),
                                GetSQLValueString($row_Recordset13['id_resultado'], "int")
                            );
                            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                            $premiar=1;
                        }
                        mysqli_free_result($Recordset13);
                    }
                    if ($premiar==1) {
                        $xpTriple=$cod_animal;
                        $xpTermin=0;
                        $xganador=$termin;
                        $cod_signo=0;
                        include("../admin_lot/procesar_premios_lot.php");
                        if (isset($ticketPre)) {
                            include("../admin_lot/procesar_ticket_premiados_lot.php");
                        }
                    }
                    $t++;
                }
            }
        }
    }

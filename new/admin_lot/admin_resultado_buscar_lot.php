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
if (isset($_POST["fecha"])&&isset($_POST["bu_sorteo"])) {
    $controlL=1;
    $controlA=1;
    require_once('../Connections/conexionbanca.php');
    include('../includes/simple_html_dom.php');
    $_POST["fec_resultado"]=fechaymd($_POST["fecha"]);
    $diahoy=diaSegunFecha($_POST["fec_resultado"]);
    $cDia=loteriaHoyAdmin($diahoy);
    $fechaIni=get_week_start_hnac($_POST["fec_resultado"]);
    $fechaURL=str_replace("-", "/", $_POST["fec_resultado"]);
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
    //$hora="16:50";// hora de prueba
    if (!isset($_POST["cod_banca"])) {
        $_POST["cod_banca"]=0;
    }
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\admin_lot\admin_resultado_buscar_lot.php - QUERY 1 */ SELECT 
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
    $cLot=array();
    $e=0;
    if ($totalRows_Recordset1>0) {
        do {
            $cLot[$e]=$row_Recordset1['id_loteria'];
            $e++;
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        //Paginas busqueda se resultados
        if ($_POST["bu_sorteo"]==1) {
            $urlFA = 'http://www.faunactiva.com.ve/result_ant2.php?fecha='.$fechaURL2;
            $urlTA = 'http://www.trucoactivo.com/loadresult.php?catID='.$_POST["fec_resultado"];
            if ($sem1==$sem2) {
                $url = 'http://www.tuazar.com/loteria/resultados/semana/';
            } else {
                $url = 'http://www.tuazar.com/loteria/resultados/'.$fechaURL."/";
            }
            if ($_POST["fec_resultado"]=fechaactualbd()) {
                $urlLA = 'http://lottoactivo.com/resumen';
            }
        } elseif ($_POST["bu_sorteo"]==2) {
            if ($sem1==$sem2) {
                $url = 'http://www.tuazar.com/loteria/resultados/semana/';
            } else {
                $url = 'http://www.tuazar.com/loteria/resultados/'.$fechaURL."/";
            }
        } elseif ($_POST["bu_sorteo"]==3) {
            $urlFA = 'http://www.faunactiva.com.ve/result_ant2.php?fecha='.$fechaURL2;
            $urlTA = 'http://www.trucoactivo.com/loadresult.php?catID='.$_POST["fec_resultado"];
            if ($_POST["fec_resultado"]=fechaactualbd()) {
                $urlLA = 'http://lottoactivo.com/resumen';
            }
        }
        echo '<div style="text-align:center">';
        echo '<div style="padding:10px 0px;font-size:20px;">';
        echo "<font size=3>".verfechaF($_POST["fec_resultado"])."</font>";
        echo '</div>';
        echo '</div>';
        //*****************************************************************************
        //**********************************pagina de prueba
        //$url = 'tuazar.html'; //pagina de prueba
        //$dia=1;
        //*****************************************************************************
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
        if (isset($urlTA)) {
            $htmlTA = file_get_html($urlTA);
        }//TRUCO ACTIVO
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
                            $rSorteoAn[$k][4]=0; //signo ganador
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
                    $rSorteoAn[$k][4]=0; //signo ganador
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
                            $rSorteoAn[$k][4]=0; //signo ganador
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
        if (isset($htmlTA)) {//TRUCO ACTIVO PAGINA OFICIAL
            $c=0;
            $i=1;
            $cTriM="296-297-298-299-300-301-302-303";
            $cTriM=explode("-", $cTriM);
            $nSorteo="TRUCO ACTIVO";
            foreach ($htmlTA->find('h3') as $article) {
                $h3[$i]=strtoupper($article->find("text", 0));
                if ($i%2==0) {
                    $hA=explode(" ", $h3[$i]);
                    if (isset($hA[0]) && trim($hA[0])=="SORTEO") {
                        if (trim($hA[0])=="SORTEO") {
                            $animal=explode("DE", $h3[$i-1]);
                            if (isset($animal[1])) {
                                $animal[1]=trim($animal[1]);
                                if ($animal[1]=="OROS" or $animal[1]=="COPAS" or $animal[1]=="ESPADAS" or $animal[1]=="BASTOS") {
                                    $animal[0]=$animal[0]*1;
                                    if (in_array($cTriM[$c], $cLot) && $animal[0]>0) {
                                        if (trim($animal[1])=="OROS") {
                                            $palo=1;
                                        } elseif (trim($animal[1])=="COPAS") {
                                            $palo=2;
                                        } elseif (trim($animal[1])=="ESPADAS") {
                                            $palo=3;
                                        } elseif (trim($animal[1])=="BASTOS") {
                                            $palo=4;
                                        }
                                        $rSorteoAn[$k][0]=$cTriM[$c];//codigos animalito
                                        $rSorteoAn[$k][1]=$nSorteo." ".$hA[1].$hA[2];//nombre y hora sorteo
                                        $rSorteoAn[$k][2]=$animal[0]; //numero ganador
                                        $rSorteoAn[$k][3]=$animal[1]; //nombre palo ganador
                                        $rSorteoAn[$k][4]=$palo; //palo ganador
                                        //$resultados[$c]=$animal[0];
                                        //echo $c."---------->".$rSorteoAn[$k][1]."*".$rSorteoAn[$k][2]." ".$rSorteoAn[$k][4].'<br>';
                                        $k++;
                                    }
                                }
                            }
                        }
                        $c++;
                    }
                }
                $i++;
            }
        }
        $s="";
        $p=0;
        if (isset($rSorteo) or isset($rSorteoAn)) {
            if (!isset($_POST["cod_banca"]) or $_POST["cod_banca"]==0) {
                $editFormAction = "admin_resultados_trte_lot.php";
            } else {
                $editFormAction = "distri_resultados_trte_lot.php";
            }
            echo '<form method="post" action="'.$editFormAction.'" onsubmit="return chequearEnvio();" name="form2" id="form">';
                
            if (isset($rSorteo) && $controlL==1) {
                foreach ($rSorteo as $xres1) {
                    foreach ($xres1 as $xres) {
                        echo '<input type="hidden" name="nom[]" value="'.$xres[2].'" />';
                        echo '<input type="hidden" name="cod_triple[]" value="'.$xres[0].'" />';
                        echo '<input type="hidden" name="cod_termin[]" value="'.$xres[1].'" />';
                        echo '<input type="hidden" name="num_resulA[]" value="'.$xres[3].'" />';
                        echo '<input type="hidden" name="num_resulB[]" value="'.$xres[4].'" />';
                        echo '<input type="hidden" name="num_resulC[]" value="'.$xres[5].'" />';
                        echo '<input type="hidden" name="num_resulZ[]" value="'.$xres[6].'" />';
                        echo '<input type="hidden" name="num_resulS[]" value="'.$xres[7].'" />';
                        $pTriple = explode("-", $xres[0]);
                        if ($xres[2]!=$s) {
                            $s=$xres[2];
                            if ($p>0) {
                                echo "</div>";
                            }
                            echo '<div style="float:left;width:220px;font-size:14px;background:#EDEDED;';
                            echo 'margin:0 5px 5px 5px;height:75px">';
                            echo "<font size=4>".$xres[2].":</font><br/>";
                        }
                        if (isset($xres[8])) {
                            echo "<strong>".$xres[8].":</strong> ";
                        }
                        for ($i = 0; $i < count($pTriple)+1; ++$i) {
                            echo $xres[$i+3]." ";
                        }
                        echo "<br/>";
                    }
                    $p++;
                }
            }
            echo '</div>';
            echo '<div style="text-align:center;float:left;width:920px;padding:2px;">';
            echo '</div>';
            $p=0;
            if (isset($rSorteoAn) && $controlA==1) {
                foreach ($rSorteoAn as $xres2) {
                    if ($p>0) {
                        echo "</div>";
                    }
                    echo '<div style="float:left;width:220px;font-size:14px;background:#EDEDED;';
                    echo 'margin:0 5px 5px 5px;padding:0 0 10px 0">';
                    echo "<font size=4>".$xres2[1]."</font>:<br/>".$xres2[2]."-".$xres2[3];
                    echo '<input type="hidden" name="cod_animal[]" value="'.$xres2[0].'" />';
                    echo '<input type="hidden" name="res_animal[]" value="'.$xres2[2].'" />';
                    echo '<input type="hidden" name="res_signo[]" value="'.$xres2[4].'" />';
                    $p++;
                }
                echo '</div>';
            }
            echo '<div style="text-align:center;float:left;width:920px;padding:20px 0px;">';
            if (count($rSorteoAn)>0 or count($rSorteo)>0) {
                echo '<input type="submit" value="GUARGAR" name="guardar_Res" class="btn-success" title="guardar resultados" onClick="r_guardar()" style="width:80px; height:30px; margin:0 30px 0 0"/>';
            } else {
                echo '<div style="padding:100px 0px;font-size:20px;">';
                echo "<font size=6>Aun no hay RESULTADOS</font><br/><br/>Por favor intentelo mas tarde<br/><br/>";
                echo "</div>";
            }
            echo '<input type="submit" value="VOLVER" class="btn-danger" title="volver a resultados" onClick="" style="width:80px; height:30px; margin:0 30px 0 0"/>';
            echo '<input type="hidden" name="fec_resultado" value="'.$_POST["fec_resultado"].'" />';
            echo '<input type="hidden" name="MM_updateRes" value="form2" />';
            echo "</div>";
            echo '</form>';
        } else {
            echo '<div style="text-align:center">';
            echo '<div style="padding:100px 0px;font-size:20px;background:#EDEDED">';
            echo "<font size=6>Aun no hay RESULTADOS</font><br/><br/>Por favor intentelo mas tarde<br/><br/>";
            echo '<a href="admin_resultados_trte_lot.php" class="btn alert-success" style="font-size:16px; width:140px; height:30px;padding:7px 0px 0px 0px;text-align:center;background:#C6F;text-decoration:none;" title="volver a resultados">VOLVER</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div style="text-align:center">';
        echo '<div style="padding:100px 0px;font-size:20px;background:#EDEDED">';
        echo "<font size=6>Aun no existen Sorteos cerrados</font><br/><br/>";
        echo "Por favor intentelo mas tarde<br/><br/>";
        echo '<a href="admin_resultados_trte_lot.php" class="btn alert-success" style="font-size:16px; width:140px; height:30px;padding:7px 0px 0px 0px;text-align:center;background:#C6F;text-decoration:none;" title="volver a resultados">VOLVER</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div style="text-align:center">';
    echo '<div style="padding:100px 0px;font-size:20px;background:#EDEDED">';
    echo "<font size=6>Algo salio mal!</font><br/><br/>Por favor intente nuevamente<br/><br/>";
    echo '<a href="admin_resultados_trte_lot.php" class="btn alert-success" style="font-size:16px; width:140px; height:30px; padding:7px 0px 0px 0px; text-align:center; background: #C6F; text-decoration:none; " title="vover a resultados">VOLVER</a>';
    echo '</div>';
    echo '</div>';
}

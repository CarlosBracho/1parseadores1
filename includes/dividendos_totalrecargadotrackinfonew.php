<?php
// 
error_reporting(E_ALL);
ini_set('display_errors', '1');
echo 'v4<br>';
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$eje1LugarSimple=0;
include('../includes/dividendos_funcion.php');
$fech=fechaactualbd();
list($a, $m, $d)=explode("-", $fech);
$fe=$m.$d.substr($a, 2, 2);
$horasistema=horaactual();
function resultadoTrackInfo2($url, $permite)
{
    echo $url;
    //$url='https://www.trackinfo.com/results-print-all.jsp?trackcode=TGP$&racedate=2022-09-11&raceperf=D';
    set_time_limit(0);
    //error_reporting(0);
    date_default_timezone_set("Pacific/Honolulu") ;
    $existe=0;
    $cAct=array();
    $eje1LugarSimple=array();
    $eje1LugarDoble=array();
    $eje1LugarTriple=array();
    $eje2LugarSimple=array();
    $eje2LugarDoble=array();
    $eje2LugarTriple=array();
    $eje3LugarSimple=array();
    $eje3LugarDoble=array();
    $eje3LugarTriple=array();
    $eje4LugarSimple=array();
    $eje4LugarDoble=array();
    $eje4LugarTriple=array();
    $DivWinPriLugar=array();
    $DivWinPriLugarDoble=array();
    $DivWinPriLugarTriple=array();
    $DivPlaPriLugar=array();
    $DivPlaPriLugarDoble=array();
    $DivPlaPriLugarTriple=array();
    $DivShoPriLugar=array();
    $DivShoPriLugarDoble=array();
    $DivShoPriLugarTriple=array();
    $DivPlaSegLugar=array();
    $DivPlaSegLugarDoble=array();
    $DivPlaSegLugarTriple=array();
    $DivShoSegLugar=array();
    $DivShoSegLugarDoble=array();
    $DivShoSegLugarTriple=array();
    $DivShoTerLugar=array();
    $DivShoTerLugarDoble=array();
    $DivShoTerLugarTriple=array();
    $divExotic=array();
    if (existe($url)) {
        $existe=1;
        include_once('simple_html_dom.php');
        $html=file_get_html($url);
        $a=0;
        $b=0;
        foreach ($html->find('table[border="1"] text') as $info1) {
            $tabla1[$a]=trim(strip_tags($info1));
            $a++;
        }
        $a=0;
        $b=0;
        foreach ($html->find('table[border="1"] text') as $info2) {
            $info2=trim(strip_tags($info2));
            if (strpos($info2, "Race:")!==false) {
                if (strpos($info2, "Race: 1")!==false) {
                    $cAct[$b]=1;
                }
                if (strpos($info2, "Race: 2")!==false) {
                    $cAct[$b]=2;
                }
                if (strpos($info2, "Race: 3")!==false) {
                    $cAct[$b]=3;
                }
                if (strpos($info2, "Race: 4")!==false) {
                    $cAct[$b]=4;
                }
                if (strpos($info2, "Race: 5")!==false) {
                    $cAct[$b]=5;
                }
                if (strpos($info2, "Race: 6")!==false) {
                    $cAct[$b]=6;
                }
                if (strpos($info2, "Race: 7")!==false) {
                    $cAct[$b]=7;
                }
                if (strpos($info2, "Race: 8")!==false) {
                    $cAct[$b]=8;
                }
                if (strpos($info2, "Race: 9")!==false) {
                    $cAct[$b]=9;
                }
                if (strpos($info2, "Race: 10")!==false) {
                    $cAct[$b]=10;
                }
                if (strpos($info2, "Race: 11")!==false) {
                    $cAct[$b]=11;
                }
                if (strpos($info2, "Race: 12")!==false) {
                    $cAct[$b]=12;
                }
                if (strpos($info2, "Race: 13")!==false) {
                    $cAct[$b]=13;
                }
                if (strpos($info2, "Race: 14")!==false) {
                    $cAct[$b]=14;
                }
                if (strpos($info2, "Race: 15")!==false) {
                    $cAct[$b]=15;
                }
                if (strpos($info2, "Race: 16")!==false) {
                    $cAct[$b]=16;
                }
                if (strpos($info2, "Race: 17")!==false) {
                    $cAct[$b]=17;
                }
                if (strpos($info2, "Race: 18")!==false) {
                    $cAct[$b]=18;
                }
                if (strpos($info2, "Race: 19")!==false) {
                    $cAct[$b]=19;
                }
                if (strpos($info2, "Race: 20")!==false) {
                    $cAct[$b]=20;
                }
                if (strpos($info2, "Race: 21")!==false) {
                    $cAct[$b]=21;
                }
                if (strpos($info2, "Race: 22")!==false) {
                    $cAct[$b]=22;
                }
                if (strpos($info2, "Race: 23")!==false) {
                    $cAct[$b]=23;
                }
                if (strpos($info2, "Race: 24")!==false) {
                    $cAct[$b]=24;
                }
                if (strpos($info2, "Race: 25")!==false) {
                    $cAct[$b]=25;
                }
                if (strpos($info2, "Race: 26")!==false) {
                    $cAct[$b]=26;
                }
                if (strpos($info2, "Race: 27")!==false) {
                    $cAct[$b]=27;
                }
                if (strpos($info2, "Race: 28")!==false) {
                    $cAct[$b]=28;
                }
                if (strpos($info2, "Race: 29")!==false) {
                    $cAct[$b]=29;
                }
                if (strpos($info2, "Race: 30")!==false) {
                    $cAct[$b]=30;
                }
                $nCar=$cAct[$b];
                if (strpos($tabla1[$a+16], "A")!==false) {
                    $tabla1[$a+16]=str_replace("A", "", $tabla1[$a+16]);
                }
                if (strpos($tabla1[$a+16], "B")!==false) {
                    $tabla1[$a+16]=str_replace("B", "", $tabla1[$a+16]);
                }
                if (strpos($tabla1[$a+16], "C")!==false) {
                    $tabla1[$a+16]=str_replace("C", "", $tabla1[$a+16]);
                }
                if (strpos($tabla1[$a+16], "D")!==false) {
                    $tabla1[$a+16]=str_replace("D", "", $tabla1[$a+16]);
                }
                if (strpos($tabla1[$a+16], "E")!==false) {
                    $tabla1[$a+16]=str_replace("E", "", $tabla1[$a+16]);
                }
                if (strpos($tabla1[$a+16], "X")!==false) {
                    $tabla1[$a+16]=str_replace("X", "", $tabla1[$a+16]);
                }
                $eje1LugarSimple[$nCar]=$tabla1[$a+16];		// nro de ejemplar 1er lugar
                $eje1LugarDoble[$nCar]=0;
                $eje1LugarTriple[$nCar]=0;
                //----------------------------------------------------------------------------------------
                if (strpos($tabla1[$a+28], "A")!==false) {
                    $tabla1[$a+28]=str_replace("A", "", $tabla1[$a+28]);
                }
                if (strpos($tabla1[$a+28], "B")!==false) {
                    $tabla1[$a+28]=str_replace("B", "", $tabla1[$a+28]);
                }
                if (strpos($tabla1[$a+28], "C")!==false) {
                    $tabla1[$a+28]=str_replace("C", "", $tabla1[$a+28]);
                }
                if (strpos($tabla1[$a+28], "D")!==false) {
                    $tabla1[$a+28]=str_replace("D", "", $tabla1[$a+28]);
                }
                if (strpos($tabla1[$a+28], "E")!==false) {
                    $tabla1[$a+28]=str_replace("E", "", $tabla1[$a+28]);
                }
                if (strpos($tabla1[$a+28], "X")!==false) {
                    $tabla1[$a+28]=str_replace("X", "", $tabla1[$a+28]);
                }
                $eje2LugarSimple[$nCar]=$tabla1[$a+28];		// nro de ejemplar 2do lugar
                $eje2LugarDoble[$nCar]=0;
                $eje2LugarTriple[$nCar]=0;
                //----------------------------------------------------------------------------------------
                if (strpos($tabla1[$a+40], "A")!==false) {
                    $tabla1[$a+40]=str_replace("A", "", $tabla1[$a+40]);
                }
                if (strpos($tabla1[$a+40], "B")!==false) {
                    $tabla1[$a+40]=str_replace("B", "", $tabla1[$a+40]);
                }
                if (strpos($tabla1[$a+40], "C")!==false) {
                    $tabla1[$a+40]=str_replace("C", "", $tabla1[$a+40]);
                }
                if (strpos($tabla1[$a+40], "D")!==false) {
                    $tabla1[$a+40]=str_replace("D", "", $tabla1[$a+40]);
                }
                if (strpos($tabla1[$a+40], "E")!==false) {
                    $tabla1[$a+40]=str_replace("E", "", $tabla1[$a+40]);
                }
                if (strpos($tabla1[$a+40], "X")!==false) {
                    $tabla1[$a+40]=str_replace("X", "", $tabla1[$a+40]);
                }
                $eje3LugarSimple[$nCar]=$tabla1[$a+40];		// nro de ejemplar 3er lugar
                $eje3LugarDoble[$nCar]=0;
                $eje3LugarTriple[$nCar]=0;
                //----------------------------------------------------------------------------------------
                $eje4LugarSimple[$nCar]=0;					// nro de ejemplar 4to lugar
                $eje4LugarDoble[$nCar]=0;
                $eje4LugarTriple[$nCar]=0;
                $DivWinPriLugar[$nCar]=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+20])))/1;// dividendo gan 1er lugar
                $DivWinPriLugar[$nCar]=str_replace(',', '', $DivWinPriLugar[$nCar]);
                $DivPlaPriLugar[$nCar]=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+22])))/1;// dividendo pla 1er lugar
                $DivPlaPriLugar[$nCar]=str_replace(',', '', $DivPlaPriLugar[$nCar]);
                $DivShoPriLugar[$nCar]=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+24])))/1;// dividendo sho 1er lugar
                $DivShoPriLugar[$nCar]=str_replace(',', '', $DivShoPriLugar[$nCar]);
                $DivPlaSegLugar[$nCar]=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+34])))/1;// dividendo pla 2do lugar
                $DivPlaSegLugar[$nCar]=str_replace(',', '', $DivPlaSegLugar[$nCar]);
                $DivShoSegLugar[$nCar]=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+36])))/1;// dividendo sho 2do lugar
                $DivShoSegLugar[$nCar]=str_replace(',', '', $DivShoSegLugar[$nCar]);
                $DivShoTerLugar[$nCar]=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+48])))/1;// dividendo sho 3er lugar
                $DivShoTerLugar[$nCar]=str_replace(',', '', $DivShoTerLugar[$nCar]);
                $DivWinPriLugarDoble[$nCar]=0;// dividendo gan 1er lugar doble
                $DivPlaPriLugarDoble[$nCar]=0;// dividendo pla 1er lugar doble
                $DivShoPriLugarDoble[$nCar]=0;// dividendo sho 1er lugar doble
                $DivPlaSegLugarDoble[$nCar]=0;// dividendo pla 2do lugar doble
                $DivShoSegLugarDoble[$nCar]=0;// dividendo sho 2do lugar doble
                $DivShoTerLugarDoble[$nCar]=0;// dividendo sho 3er lugar doble
                $DivWinPriLugarTriple[$nCar]=0;// dividendo gan 1er lugar triple
                $DivPlaPriLugarTriple[$nCar]=0;// dividendo pla 1er lugar triple
                $DivShoPriLugarTriple[$nCar]=0;// dividendo sho 1er lugar triple
                $DivPlaSegLugarTriple[$nCar]=0;// dividendo pla 2do lugar triple
                $DivShoSegLugarTriple[$nCar]=0;// dividendo sho 2do lugar triple
                $DivShoTerLugarTriple[$nCar]=0;// dividendo sho 3er lugar triple
                $empP=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+32])))/1;
                if ($empP>0) {
                    $eje1LugarDoble[$nCar]=$eje2LugarSimple[$nCar];
                    $DivWinPriLugarDoble[$nCar]=str_replace(',', '', $empP);
                    $DivPlaPriLugarDoble[$nCar]=str_replace(',', '', $DivPlaSegLugar[$nCar]);
                    $DivShoPriLugarDoble[$nCar]=str_replace(',', '', $DivShoSegLugar[$nCar]);
                    $eje2LugarSimple[$nCar]=99;
                    $DivPlaSegLugar[$nCar]=0;
                    $DivShoSegLugar[$nCar]=0;
                }
                $empS=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+46])))/1;
                $empS2=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+44])))/1;
                if ($empS>0 && $empS2==0) {
                    $eje2LugarDoble[$nCar]=$eje3LugarSimple[$nCar];
                    $DivPlaSegLugarDoble[$nCar]=str_replace(',', '', $empS);
                    $DivShoSegLugarDoble[$nCar]=str_replace(',', '', $DivShoTerLugar[$nCar]);
                    $eje3LugarSimple[$nCar]=99;
                    $DivShoTerLugar[$nCar]=0;
                }
                if (strpos($tabla1[$a+52], "A")!==false || strpos($tabla1[$a+52], "B")!==false ||
                    strpos($tabla1[$a+52], "C")!==false ||
                    strpos($tabla1[$a+52], "D")!==false || strpos($tabla1[$a+52], "E")!==false ||
                    strpos($tabla1[$a+52], "X")!==false) {
                    $cuarto=$permite;
                    $tabla1[$a+52]=str_replace('A', '', $tabla1[$a+52]);
                    $tabla1[$a+52]=str_replace('B', '', $tabla1[$a+52]);
                    $tabla1[$a+52]=str_replace('C', '', $tabla1[$a+52]);
                    $tabla1[$a+52]=str_replace('D', '', $tabla1[$a+52]);
                    $tabla1[$a+52]=str_replace('E', '', $tabla1[$a+52]);
                    $tabla1[$a+52]=str_replace('X', '', $tabla1[$a+52]);
                } else {
                    $cuarto=1;
                }
                if ($cuarto==1) {
                    $empT=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+52])))/1;
                    if ($empT>0) {
                        $divW=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+56])))/1;
                        $divP=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+58])))/1;
                        $divS=str_replace("&nbsp;", "", trim(strip_tags($tabla1[$a+60])))/1;
                        if ($divW>0 && $divP>0 && $divS>0) {
                            $eje1LugarDoble[$nCar]=$empT;
                            $DivWinPriLugarDoble[$nCar]=$divW;
                            $DivPlaPriLugarDoble[$nCar]=$divP;
                            $DivShoPriLugarDoble[$nCar]=$divS;
                        }
                        
                        if ($divW==0 && $divP>0 && $divS>0) {
                            $eje2LugarDoble[$nCar]=$empT;
                            $DivPlaSegLugarDoble[$nCar]=$divP;
                            $DivShoSegLugarDoble[$nCar]=$divS;
                        }
                        
                        if ($divW==0 && $divP==0 && $divS>0) {
                            $eje3LugarDoble[$nCar]=$empT;
                            $DivShoTerLugarDoble[$nCar]=$divS;
                        }
                    }
                }
                $b++;
                $ctaEx=0;
                $ctaTr=0;
                $ctaSu=0;
                $ctaDD=0;
                $ctaP3=0;
                $ctaP4=0;
            }
            if (strpos($info2, "EXACTA")!==false || strpos($info2, "0 EX")!==false) {
                $df=explode(" ", $info2);
                $divExotic[$nCar][0][$ctaEx][0]="EXACTA"; // tipo de exotica
                $divExotic[$nCar][0][$ctaEx][1]=str_replace("/", "-", trim(strip_tags($df[2])));	 // llegada
                $divExotic[$nCar][0][$ctaEx][2]=str_replace("$", "", trim(strip_tags($df[4]))); // dividendo
                $divExotic[$nCar][0][$ctaEx][2]=str_replace(',', '', $divExotic[$nCar][0][$ctaEx][2]);
                $divExotic[$nCar][0][$ctaEx][3]=str_replace("$", "", trim(strip_tags($df[0])));	 // factor
                $ctaEx++;
            }
            if (strpos($info2, "TRIFECTA")!==false || strpos($info2, "0 TR")!==false) {
                $df=explode(" ", $info2);
                $divExotic[$nCar][1][$ctaTr][0]="TRIFECTA"; // tipo de exotica
                $divExotic[$nCar][1][$ctaTr][1]=str_replace("/", "-", trim(strip_tags($df[2])));	 // llegada
                $divExotic[$nCar][1][$ctaTr][2]=str_replace("$", "", trim(strip_tags($df[4]))); // dividendo
                $divExotic[$nCar][1][$ctaTr][2]=str_replace(',', '', $divExotic[$nCar][1][$ctaTr][2]);
                $divExotic[$nCar][1][$ctaTr][3]=str_replace("$", "", trim(strip_tags($df[0])));	 // factor
                $ctaTr++;
            }
            if (strpos($info2, "SUPERFECTA")!==false || strpos($info2, "0 SU")!==false) {
                $df=explode(" ", $info2);
                $divExotic[$nCar][2][$ctaSu][0]="SUPERFECTA"; // tipo de exotica
                $divExotic[$nCar][2][$ctaSu][1]=str_replace(',', '', trim(strip_tags($df[2])));
                $divExotic[$nCar][2][$ctaSu][1]=str_replace('-', '', $divExotic[$nCar][2][$ctaSu][1]);
                $divExotic[$nCar][2][$ctaSu][1]=str_replace("/", "-", $divExotic[$nCar][2][$ctaSu][1]);	 // llegada
                $divExotic[$nCar][2][$ctaSu][2]=str_replace("$", "", trim(strip_tags($df[4]))); // dividendo
                $divExotic[$nCar][2][$ctaSu][2]=str_replace(',', '', $divExotic[$nCar][2][$ctaSu][2]);
                $divExotic[$nCar][2][$ctaSu][3]=str_replace("$", "", trim(strip_tags($df[0])));	 // factor
                $llegada=explode("/", strip_tags($df[2]));
                $eje4LugarSimple[$nCar]=$llegada[3];
                $ctaSu++;
            }
            if (strpos($info2, "DOUBLE")!==false || strpos($info2, "0 DD")!==false) {
                $df=explode(" ", $info2);
                $divExotic[$nCar][3][$ctaDD][0]="DOUBLE"; // tipo de exotica
                $divExotic[$nCar][3][$ctaDD][1]=str_replace("/", "-", trim(strip_tags($df[2])));	 // llegada
                $divExotic[$nCar][3][$ctaDD][2]=str_replace("$", "", trim(strip_tags($df[4]))); // dividendo
                $divExotic[$nCar][3][$ctaDD][2]=str_replace(',', '', $divExotic[$nCar][3][$ctaDD][2]);
                $divExotic[$nCar][3][$ctaDD][3]=str_replace("$", "", trim(strip_tags($df[0])));	 // factor
                $ctaDD++;
            }
            if (strpos($info2, "PICK THREE")!==false || strpos($info2, "0 P3")!==false) {
                $df=explode(" ", $info2);
                $divExotic[$nCar][4][$ctaP3][0]="PICKTHREE"; // tipo de exotica
                $divExotic[$nCar][4][$ctaP3][1]=str_replace("/", "-", trim(strip_tags($df[3])));	 // llegada
                $divExotic[$nCar][4][$ctaP3][2]=str_replace("$", "", trim(strip_tags($df[5]))); // dividendo
                $divExotic[$nCar][4][$ctaP3][2]=str_replace(',', '', $divExotic[$nCar][4][$ctaP3][2]);
                $divExotic[$nCar][4][$ctaP3][3]=str_replace("$", "", trim(strip_tags($df[0])));	 // factor
                $ctaP3++;
            }
            if (strpos($info2, "PICK FOUR")!==false || strpos($info2, "FOUR")!==false) {
                //$2.00 PICK FOUR 1/5/1,5,6/4 paid $535.60
                //$2.00 PICK FOUR 4/3/7/1 paid $20,564.60

        $info2=str_replace('(', '', $info2); 
        $info2=str_replace(')', '', $info2); 
        $info2=str_replace(' 4 right', '', $info2); 
                $df=explode(" ", $info2);
                //var_dump($df);
// array(6) { [0]=> string(5) "$2.00" [1]=> string(4) "PICK" [2]=> string(4) "FOUR" [3]=> string(11) "1/5/1,5,6/4" [4]=> string(4) "paid" [5]=> string(7) "$535.60" } 
// array(6) { [0]=> string(5) "$2.00" [1]=> string(4) "PICK" [2]=> string(4) "FOUR" [3]=> string(7) "4/3/7/1"      [4]=> string(4) "paid" [5]=> string(10) "$20,564.60" }

                $divExotic[$nCar][5][$ctaP4][0]="PICKFOUR"; // tipo de exotica
                $divExotic[$nCar][5][$ctaP4][1]=str_replace(',', '', trim(strip_tags($df[3])));
                $divExotic[$nCar][5][$ctaP4][1]=str_replace('-', '', $divExotic[$nCar][5][$ctaP4][1]);
                $divExotic[$nCar][5][$ctaP4][1]=str_replace("/", "-", $divExotic[$nCar][5][$ctaP4][1]);	 // llegada
                $divExotic[$nCar][5][$ctaP4][2]=str_replace("$", "", trim(strip_tags($df[5])));
                $divExotic[$nCar][5][$ctaP4][2]=str_replace(',', '', $divExotic[$nCar][5][$ctaP4][2]); // dividendo
                $divExotic[$nCar][5][$ctaP4][3]=str_replace("$", "", trim(strip_tags($df[0])));	 // factor
                $ctaP4++;
            }




            if (strpos($info2, "PICK FIVE")!==false || strpos($info2, "FIVE")!==false) {
                //$2.00 PICK FOUR 1/5/1,5,6/4 paid $535.60
                //$2.00 PICK FOUR 4/3/7/1 paid $20,564.60

        $info2=str_replace('(', '', $info2); 
        $info2=str_replace(')', '', $info2); 
        $info2=str_replace(' 5 right', '', $info2); 
                $df=explode(" ", $info2);
                //var_dump($df);
// array(6) { [0]=> string(5) "$2.00" [1]=> string(4) "PICK" [2]=> string(4) "FOUR" [3]=> string(11) "1/5/1,5,6/4" [4]=> string(4) "paid" [5]=> string(7) "$535.60" } 
// array(6) { [0]=> string(5) "$2.00" [1]=> string(4) "PICK" [2]=> string(4) "FOUR" [3]=> string(7) "4/3/7/1"      [4]=> string(4) "paid" [5]=> string(10) "$20,564.60" }

                $divExotic[$nCar][6][$ctaP4][0]="PICKFIVE"; // tipo de exotica
                $divExotic[$nCar][6][$ctaP4][1]=str_replace(',', '', trim(strip_tags($df[3])));
                $divExotic[$nCar][6][$ctaP4][1]=str_replace('-', '', $divExotic[$nCar][6][$ctaP4][1]);
                $divExotic[$nCar][6][$ctaP4][1]=str_replace("/", "-", $divExotic[$nCar][6][$ctaP4][1]);	 // llegada
                $divExotic[$nCar][6][$ctaP4][2]=str_replace("$", "", trim(strip_tags($df[5])));
                $divExotic[$nCar][6][$ctaP4][2]=str_replace(',', '', $divExotic[$nCar][6][$ctaP4][2]); // dividendo
                $divExotic[$nCar][6][$ctaP4][3]=str_replace("$", "", trim(strip_tags($df[0])));	 // factor
                $ctaP4++;
            }







            $a++;
        }
        foreach ($cAct as $y) {
            if ($eje1LugarSimple[$y]==$eje2LugarSimple[$y]) {
                $eje2LugarSimple[$y]=99;
                $DivPlaSegLugar[$y]=0;
                $DivShoSegLugar[$y]=0;
            }
            if ($eje1LugarSimple[$y]==$eje3LugarSimple[$y]) {
                $eje3LugarSimple[$y]=99;
                $DivShoTerLugar[$y]=0;
            }
            if ($eje2LugarSimple[$y]==$eje3LugarSimple[$y]) {
                $eje3LugarSimple[$y]=99;
                $DivShoTerLugar[$y]=0;
            }
        }
    }
    return array($cAct,$eje1LugarSimple,$eje1LugarDoble,$eje1LugarTriple,$eje2LugarSimple,$eje2LugarDoble,$eje2LugarTriple,$eje3LugarSimple,$eje3LugarDoble,$eje3LugarTriple,$eje4LugarSimple,$eje4LugarDoble,$eje4LugarTriple,$DivWinPriLugar,$DivWinPriLugarDoble,$DivWinPriLugarTriple,$DivPlaPriLugar,$DivPlaPriLugarDoble,$DivPlaPriLugarTriple,$DivShoPriLugar,$DivShoPriLugarDoble,$DivShoPriLugarTriple,$DivPlaSegLugar,$DivPlaSegLugarDoble,$DivPlaSegLugarTriple,$DivShoSegLugar,$DivShoSegLugarDoble,$DivShoSegLugarTriple,$DivShoTerLugar,$DivShoTerLugarDoble,$DivShoTerLugarTriple,$divExotic,$existe);
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\dividendos_totalrecargadotrackinfonew.php - QUERY 1 */ SELECT * 
	FROM 
	hipodromo,
	carrera 
	WHERE
	hipodromo.nom_hipodromo = carrera.nom_hipodromo AND
	carrera.est_confirmacion = 1 AND
	carrera.est_carrera = 0 AND
(carrera.confirmandox = 0 OR carrera.confirmandox = 1) AND	
(hipodromo.bus_resultado_tip = 1 OR hipodromo.bus_resultado_tip = 5 OR hipodromo.bus_resultado_tip = 6 OR hipodromo.bus_resultado_tip = 7) AND
	carrera.fec_carrera = %s  ORDER BY RAND() LIMIT 20",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo 'Total Carreras '.$totalRows_Recordset1;


?>
<div style="background:#20c8a8; color: #FFF; width:100%;">
<table width="100%" border="0" style="font-family:Verdana, Geneva, sans-serif;font-size:16px; color:#FFFFFF">
  <tr  style="color: #906">
  	<td height="41" align="right" valign="middle">
	</td>
  	<td height="41" align="right" valign="middle">&nbsp;</td>
  	<td width="211" height="41" align="right" valign="middle" style="font-size:36px; color:#000000">
		<?php echo $horasistema ?>
    </td>
  	<td width="5" align="right" valign="middle">&nbsp;
    
    </td>
    </tr>
  <tr align="center">
  	<td width="73"> CIERRE</td>
    <td width="688"> HIPÓDROMO</td>
    <td colspan="2" align="center">RESULTADOS</td>
    </tr>
</table>
</div>
<?php
if ($totalRows_Recordset1>0) {
    $t=0;
    
    do {
        
        //echo $row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera']."<br/>";
        //echo $row_Recordset1['bus_auto']." - ".$row_Recordset1['bus_resultado_tip']."<br/>";
        if ($totalRows_Recordset1>0) {
            $f=0;
            $cont=1;
            $ddydemas=',,';
            if (($row_Recordset1['bus_resultado_tip']==1 or $row_Recordset1['bus_resultado_tip']==5 or $row_Recordset1['bus_resultado_tip']==6 or $row_Recordset1['bus_resultado_tip']==7) && ($row_Recordset1['confirmandox']==0 or $row_Recordset1['confirmandox']==1)) {
                echo 'track info';
                $confirmandox=1;
                $dir_pag=trim($row_Recordset1['dir_pagresultado']);
                $ext_pag=trim($row_Recordset1['ext_pagresultado']);
                $url=$dir_pag.$row_Recordset1['fec_carrera'].$ext_pag;
      //echo $url."<br/>";
              
            list($cAct, $eje1LugarSimple, $eje1LugarDoble, $eje1LugarTriple, $eje2LugarSimple, $eje2LugarDoble, $eje2LugarTriple, $eje3LugarSimple, $eje3LugarDoble, $eje3LugarTriple, $eje4LugarSimple, $eje4LugarDoble, $eje4LugarTriple, $DivWinPriLugar, $DivWinPriLugarDoble, $DivWinPriLugarTriple, $DivPlaPriLugar, $DivPlaPriLugarDoble, $DivPlaPriLugarTriple, $DivShoPriLugar, $DivShoPriLugarDoble, $DivShoPriLugarTriple, $DivPlaSegLugar, $DivPlaSegLugarDoble, $DivPlaSegLugarTriple, $DivShoSegLugar, $DivShoSegLugarDoble, $DivShoSegLugarTriple, $DivShoTerLugar, $DivShoTerLugarDoble, $DivShoTerLugarTriple, $divExotic, $existe)=resultadoTrackInfo2($url, 1);// 0 no permite ABCDEX   //1 permite ABCDEX
            }

            if (isset($cAct) && isset($cAct[0]) && $cAct[0]>0) {
                foreach ($cAct as $hip) {
                    if ($hip==$row_Recordset1['num_carrera']) {
                        $control_dividendo=$row_Recordset1['control_dividendo']; ?>
                    <table width="100%" border="1" bordercolor="#20c8a8">
					  <tr>
						<td width="53" align="center"><?php echo $row_Recordset1['hor_carrera'] ?></td>
						<td style="font-size:16px"><strong>
							<?php
                            if ($row_Recordset1['bus_resultado_tip']==0) {
                                $pagina="";
                            }
                        if ($row_Recordset1['bus_resultado_tip']==1) {
                            $pagina="--> TRACK";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==2) {
                            $pagina="--> BASIC TVG";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==3) {
                            $pagina="--> BUILDABET";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==4) {
                            $pagina="--> TWINSPIRES";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==5) {
                            $pagina="--> ";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==21) {
                            $pagina="--> TRACK 21 pruebas";
                        }

                        list($a, $m, $d)=explode("-", $row_Recordset1['fec_carrera']);
                        $fecha=$d."-".$m."-".$a;
                        $carrera=$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera'];
                        echo $carrera." (".$fecha.") ".$pagina; ?></strong>
                        </td>
						<td width="80" align="center">
                        <div id="ejes1<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php if (isset($eje1LugarSimple[$hip])) {
                            echo $eje1LugarSimple[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>    
                        </td>
						<td width="40" align="right">
                        <div id="divws1<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php if (isset($DivWinPriLugar[$hip])) {
                            echo $DivWinPriLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td width="40" align="right">
                        <div id="divps1<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivPlaPriLugar[$hip])) {
                            echo $DivPlaPriLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td width="40" align="right">
                        <div id="divss1<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivShoPriLugar[$hip])) {
                            echo $DivShoPriLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
						<td align="center" style="font-size:14px;">CORREN</td>
						<td style="font-size:12px">
						
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <div id="exac<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        /*
                        $divExotic[$hip][0][$ctaEx][0]="EXACTA"; // tipo de exotica
                        $divExotic[$hip][0][$ctaEx][1]=str_replace("/", "-",trim(strip_tags($df[2])));	 // llegada
                        $divExotic[$hip][0][$ctaEx][2]=str_replace("$", "",trim(strip_tags($df[4]))); // dividendo
                        $divExotic[$hip][0][$ctaEx][3]=str_replace("$", "",trim(strip_tags($df[0])));	 // factor
                        */
                        $div_exacta=0;
                        $fac_exacta=0;
                        $div_exacta_doble=0;
                        $div_exacta_triple=0;
                        
                        $ord_exacta="0/0";
                        $ord_exacta_doble="0/0";
                        $ord_exacta_triple="0/0";
                        if (isset($divExotic[$hip][0][0][0])) {
                            $div_exacta=$divExotic[$hip][0][0][2];
                            $fac_exacta=$divExotic[$hip][0][0][3];
                            $ord_exacta=str_replace("-", "/", $divExotic[$hip][0][0][1]);
                            echo"EX: ".$ord_exacta." Pago: ".$div_exacta." ->".$fac_exacta;
                            if (isset($divExotic[$hip][0][1][0])) {
                                $ord_exacta_doble=str_replace("-", "/", $divExotic[$hip][0][1][1]);

                                echo " | EX2: ".$ord_exacta_doble." Pago: ".$divExotic[$hip][0][1][2]." ->".$divExotic[$hip][0][1][3];
                                $div_exacta_doble=$divExotic[$hip][0][1][2];
                            }
                            if (isset($divExotic[$hip][0][2][0])) {
                                $ord_exacta_triple=str_replace("-", "/", $divExotic[$hip][0][2][1]);
                                echo " | EX3: ".$ord_exacta_triple." Pago: ".$divExotic[$hip][0][2][2]." ->".$divExotic[$hip][0][2][3];
                                $div_exacta_triple=$divExotic[$hip][0][2][2];
                            }
                        } ?>
                        </div>


                        <div id="DOUBLE<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        /*
                        $divExotic[$hip][0][$ctaEx][0]="DOUBLE"; // tipo de exotica
                        $divExotic[$hip][0][$ctaEx][1]=str_replace("/", "-",trim(strip_tags($df[2])));	 // llegada
                        $divExotic[$hip][0][$ctaEx][2]=str_replace("$", "",trim(strip_tags($df[4]))); // dividendo
                        $divExotic[$hip][0][$ctaEx][3]=str_replace("$", "",trim(strip_tags($df[0])));	 // factor
                        */ 
                   
                        $div_DOUBLE=0;
                        $fac_DOUBLE=0;
                        $div_DOUBLE_doble=0;
                        $div_DOUBLE_triple=0;
                        
                        $ord_DOUBLE="0/0";
                        $ord_DOUBLE_doble="0/0";
                        $ord_DOUBLE_triple="0/0";
                        if (isset($divExotic[$hip][3][0][0])) {
                            //echo '<br>ffffffff<br>';
                            $div_DOUBLE=$divExotic[$hip][3][0][2];
                            $fac_DOUBLE=$divExotic[$hip][3][0][3];
                            $ord_DOUBLE=str_replace("-", "/", $divExotic[$hip][3][0][1]);
                            echo"DD: ".$ord_DOUBLE." Pago: ".$div_DOUBLE." ->".$fac_DOUBLE;
                            $ddydemas=$ddydemas.'--dd--'.$ord_DOUBLE.'--'.$div_DOUBLE.'--'.$fac_DOUBLE.',,';
                            if (isset($divExotic[$hip][3][1][0])) {
                                $ord_DOUBLE_doble=str_replace("-", "/", $divExotic[$hip][3][1][1]);

                                echo " | DD2: ".$ord_DOUBLE_doble." Pago: ".$divExotic[$hip][3][1][2]." ->".$divExotic[$hip][3][1][3];
                                $div_DOUBLE_doble=$divExotic[$hip][3][1][2];
                                $ddydemas=$ddydemas.'--dd2--'.$ord_DOUBLE_doble.'--'.$div_DOUBLE_doble.'--'.$fac_DOUBLE.',,';

                            }
                            if (isset($divExotic[$hip][3][2][0])) {
                                $ord_DOUBLE_triple=str_replace("-", "/", $divExotic[$hip][3][2][1]);
                                echo " | DD3: ".$ord_DOUBLE_triple." Pago: ".$divExotic[$hip][3][2][2]." ->".$divExotic[$hip][3][2][3];
                                $div_DOUBLE_triple=$divExotic[$hip][3][2][2];
                                $ddydemas=$ddydemas.'--dd3--'.$ord_DOUBLE_triple.'--'.$div_DOUBLE_triple.'--'.$fac_DOUBLE.',,';

                            }
//echo 'kk '.$ddydemas.' kk';

                        } ?>
                        </div>








                        </td>
						<td align="center">
						<div id="ejes2<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($eje2LugarSimple[$hip])) {
                            echo $eje2LugarSimple[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td align="right">&nbsp;</td>
						<td align="right">
						<div id="divps2<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivPlaSegLugar[$hip])) {
                            echo $DivPlaSegLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td align="right">
						<div id="divss2<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivShoSegLugar[$hip])) {
                            echo $DivShoSegLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
                      	<?php $van=$row_Recordset1['can_caballos']-cantRetirados($row_Recordset1['cod_carrera']); ?>
						<td rowspan="2" align="center" style="font-size:34px;color:#FFF;background:#C00;"><?php echo $van; ?></td>
						<td style="font-size:12px">
						
                        
                        
                        
                        
                        
                        
                        <div id="trif<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        $div_trifecta=0;
                        $fac_trifecta=0;
                        $div_trifecta_doble=0;
                        $div_trifecta_triple=0;
                        $ord_trifecta="0/0/0";
                        $ord_trifecta_doble="0/0/0";
                        $ord_trifecta_triple="0/0/0";
                        if (isset($divExotic[$hip][1][0][0])) {
                            $div_trifecta=$divExotic[$hip][1][0][2];
                            $fac_trifecta=$divExotic[$hip][1][0][3];
                            
                            
                            $ord_trifecta=str_replace("-", "/", $divExotic[$hip][1][0][1]);
                            echo"TR: ".$ord_trifecta." Pago: ".$div_trifecta." ->".$fac_trifecta;
                            if (isset($divExotic[$hip][1][1][0])) {
                                $ord_trifecta_doble=str_replace("-", "/", $divExotic[$hip][1][1][1]);
                                echo " | TR2: ".$ord_trifecta_doble." Pago: ".$divExotic[$hip][1][1][2]." ->".$divExotic[$hip][1][1][3];
                                $div_trifecta_doble=$divExotic[$hip][1][1][2];
                            }
                            if (isset($divExotic[$hip][1][2][0])) {
                                $ord_trifecta_triple=str_replace("-", "/", $divExotic[$hip][1][2][1]);
                                echo " | TR3: ".$ord_trifecta_triple." Pago: ".$divExotic[$hip][1][2][2]." ->".$divExotic[$hip][1][2][3];
                                $div_trifecta_triple=$divExotic[$hip][1][2][2];
                            }
                        } ?>
                        </div>




                        <div id="p3<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        $div_p3=0;
                        $fac_p3=0;
                        $div_p3_doble=0;
                        $div_p3_triple=0;
                        $ord_p3="0/0/0";
                        $ord_p3_doble="0/0/0";
                        $ord_p3_triple="0/0/0";
                        if (isset($divExotic[$hip][4][0][0])) {
                            $div_p3=$divExotic[$hip][4][0][2];
                            $fac_p3=$divExotic[$hip][4][0][3];
                            
                            
                            $ord_p3=str_replace("-", "/", $divExotic[$hip][4][0][1]);
                            echo"p3: ".$ord_p3." Pago: ".$div_p3." ->".$fac_p3;
                            $ddydemas=$ddydemas.'--p3--'.$ord_p3.'--'.$div_p3.'--'.$fac_p3.',,';

                            if (isset($divExotic[$hip][4][1][0])) {
                                $ord_p3_doble=str_replace("-", "/", $divExotic[$hip][4][1][1]);
                                echo " | p32: ".$ord_p3_doble." Pago: ".$divExotic[$hip][4][1][2]." ->".$divExotic[$hip][4][1][3];
                                $div_p3_doble=$divExotic[$hip][4][1][2];
                                $ddydemas=$ddydemas.'--p32--'.$ord_p3_doble.'--'.$div_p3_doble.'--'.$fac_p3.',,';

                            }
                            if (isset($divExotic[$hip][4][2][0])) {
                                $ord_p3_triple=str_replace("-", "/", $divExotic[$hip][4][2][1]);
                                echo " | p33: ".$ord_p3_triple." Pago: ".$divExotic[$hip][4][2][2]." ->".$divExotic[$hip][4][2][3];
                                $div_p3_triple=$divExotic[$hip][4][2][2];
                                $ddydemas=$ddydemas.'--p33--'.$ord_p3_triple.'--'.$div_p3_triple.'--'.$fac_p3.',,';

                            }
                        } ?>
                        </div>








                        </td>
						<td align="center">
						<div id="ejes3<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($eje3LugarSimple[$hip])) {
                            echo $eje3LugarSimple[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td align="right">
						<div id="divss3<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivShoTerLugar[$hip])) {
                            echo $DivShoTerLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
					    <td style="font-size:12px">
						
                        
                        
                        
                        
                        
                        
                        
                        
                        <div id="supe<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        $div_superfecta=0;
                        $fac_superfecta=0;
                        $div_superfecta_doble=0;
                        $div_superfecta_triple=0;
                        $ord_superfecta="0/0/0/0";
                        $ord_superfecta_doble="0/0/0/0";
                        $ord_superfecta_triple="0/0/0/0";
                        if (isset($divExotic[$hip][2][0][0])) {
                            $div_superfecta=$divExotic[$hip][2][0][2];
                            $fac_superfecta=$divExotic[$hip][2][0][3];
                            $ord_superfecta=str_replace("-", "/", $divExotic[$hip][2][0][1]);
                            echo"SU: ".$ord_superfecta." Pago: ".$div_superfecta." ->".$fac_superfecta;
                            if (isset($divExotic[$hip][2][1][0])) {
                                $ord_superfecta_doble=str_replace("-", "/", $divExotic[$hip][2][1][1]);
                                echo " | SU2:".$ord_superfecta_doble." Pago: ".$divExotic[$hip][2][1][2]." ->".$divExotic[$hip][2][1][3];
                                $div_superfecta_doble=$divExotic[$hip][2][1][2];
                            }
                            if (isset($divExotic[$hip][2][2][0])) {
                                $ord_superfecta_triple=str_replace("-", "/", $divExotic[$hip][2][2][1]);
                                echo " | SU3:".$ord_superfecta_triple." Pago: ".$divExotic[$hip][2][2][2]." ->".$divExotic[$hip][2][2][3];
                                $div_superfecta_triple=$divExotic[$hip][2][2][2];
                            }
                        } ?>
                        </div>








                        <div id="p4<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        $div_p4=0;
                        $fac_p4=0;
                        $div_p4_doble=0;
                        $div_p4_triple=0;
                        $ord_p4="0/0/0/0";
                        $ord_p4_doble="0/0/0/0";
                        $ord_p4_triple="0/0/0/0";
                        if (isset($divExotic[$hip][5][0][0])) {
                            $div_p4=$divExotic[$hip][5][0][2];
                            $fac_p4=$divExotic[$hip][5][0][3];
                            $ord_p4=str_replace("-", "/", $divExotic[$hip][5][0][1]);
                            echo"p4: ".$ord_p4." Pago: ".$div_p4." ->".$fac_p4;
                            $ddydemas=$ddydemas.'--p4--'.$ord_p4.'--'.$div_p4.'--'.$fac_p4.',,';

                            if (isset($divExotic[$hip][5][1][0])) {
                                $ord_p4_doble=str_replace("-", "/", $divExotic[$hip][5][1][1]);
                                echo " | p42:".$ord_p4_doble." Pago: ".$divExotic[$hip][5][1][2]." ->".$divExotic[$hip][5][1][3];
                                $div_p4_doble=$divExotic[$hip][5][1][2];
                                $ddydemas=$ddydemas.'--p42--'.$ord_p4_doble.'--'.$div_p4_doble.'--'.$divExotic[$hip][5][1][3].',,';

                            }
                            if (isset($divExotic[$hip][5][2][0])) {
                                $ord_p4_triple=str_replace("-", "/", $divExotic[$hip][5][2][1]);
                                echo " | p43:".$ord_p4_triple." Pago: ".$divExotic[$hip][5][2][2]." ->".$divExotic[$hip][5][2][3];
                                $div_p4_triple=$divExotic[$hip][5][2][2];
                                $ddydemas=$ddydemas.'--p43--'.$ord_p4_triple.'--'.$divExotic[$hip][5][2][2].'--'.$divExotic[$hip][5][2][3].',,';

                            }
                        } ?>
                        </div>



                        <div id="p5<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        $div_p5=0;
                        $fac_p5=0;
                        $div_p5_doble=0;
                        $div_p5_triple=0;
                        $ord_p5="0/0/0/0/0";
                        $ord_p5_doble="0/0/0/0/0";
                        $ord_p5_triple="0/0/0/0/0";
                        if (isset($divExotic[$hip][6][0][0])) {
                            $div_p5=$divExotic[$hip][6][0][2];
                            $fac_p5=$divExotic[$hip][6][0][3];
                            $ord_p5=str_replace("-", "/", $divExotic[$hip][6][0][1]);
                            echo"p5: ".$ord_p5." Pago: ".$div_p5." ->".$fac_p5;
                            $ddydemas=$ddydemas.'--p5--'.$ord_p5.'--'.$div_p5.'--'.$fac_p5.',,';

                            if (isset($divExotic[$hip][6][1][0])) {
                                $ord_p5_doble=str_replace("-", "/", $divExotic[$hip][6][1][1]);
                                echo " | p52:".$ord_p5_doble." Pago: ".$divExotic[$hip][6][1][2]." ->".$divExotic[$hip][6][1][3];
                                $div_p5_doble=$divExotic[$hip][6][1][2];
                                $ddydemas=$ddydemas.'--p52--'.$ord_p5_doble.'--'.$div_p5_doble.'--'.$divExotic[$hip][6][1][3].',,';

                            }
                            if (isset($divExotic[$hip][6][2][0])) {
                                $ord_p5_triple=str_replace("-", "/", $divExotic[$hip][6][2][1]);
                                echo " | p53:".$ord_p5_triple." Pago: ".$divExotic[$hip][6][2][2]." ->".$divExotic[$hip][6][2][3];
                                $div_p5_triple=$divExotic[$hip][6][2][2];
                                $ddydemas=$ddydemas.'--p53--'.$ord_p5_triple.'--'.$divExotic[$hip][6][2][2].'--'.$divExotic[$hip][6][2][3].',,';

                            }
                        } ?>
                        </div>










                        </td>
					    <td align="center">
                        <div id="ejes4<?php echo $row_Recordset1['cod_carrera']; ?>">
                        	<?php
                                if (isset($eje4LugarSimple[$hip]) && $eje4LugarSimple[$hip]>0) {
                                    echo $eje4LugarSimple[$hip];
                                } ?>
                        </div>
                        </td>
					    <td align="right">&nbsp;</td>
					    <td align="right">&nbsp;</td>
					    <td align="right">&nbsp;</td>
  					  </tr>
					  <tr>
					    <td colspan="6" align="left" valign="top">
                        <?php
                        if ($row_Recordset1['cod_confirmacion']==1) {?>
                        	<div id="botReset<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            style="float:left; padding:0px 15px 0px 0px">
                            	<a href="#" onClick="resetDiv('<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divws1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divps1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divps2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss3<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#exac<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#trif<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#supe<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>')"
                                id="confB<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	title="reset dividendos <?php echo $carrera; ?>" class="btn btn-info" style="color: #FFF">Reset</a>
                            </div>   
                             
                            <div id="botModifica<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="float:left; padding:0px 15px 0px 0px;">
                            	<a href="#" onClick="ModiDiv('<?php echo $row_Recordset1['cod_carrera']; ?>','1')" 
                            	title="modificar dividendos <?php echo $carrera; ?>" 
                                class="btn btn-inverse" style="color: #FFF">Modificar</a>
                        	</div>
                        	<div id="botCancela<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="padding:0px 390px 0px 0px;float:left">
									<a onclick='if(confirm("¿Seguro quiere cancelar la carrera?"))cancelaCar(
										"<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divws1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#exac<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#trif<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#supe<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#botCancela<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botReset<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>")' 
                                    class="btn btn-danger" 
                                    style="color: #FFF" 
                                    title="cancelar <?php echo $carrera; ?>">Cancelar</a>
                            </div>
                        	<div id="botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="float:left; text-align:center">
                            <?php
                            if (($eje1LugarSimple[$hip]>0&&$DivWinPriLugar[$hip]>0&&$row_Recordset1['control_dividendo']==2
                            or ($eje1LugarSimple[$hip]==99&&$DivWinPriLugar[$hip]==0&&$row_Recordset1['control_dividendo']==2))) {	?>
                                <a href="#" 
                                onClick="confirmarDiv(<?php echo $row_Recordset1['cod_carrera']; ?>,
                                '#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botReset<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>');"
                                title="confirmar dividendos <?php echo $carrera; ?>" 
                                class="btn btn-success" style="color: #FFF">Confirmar</a>
                             	<?php
                             } else { ?>
                                 <div style="float:right; text-align:center; background: #903; width:195px; height:auto;
                                 	color:#FFF; padding:2px 0px 2px 0px; font-size:14px">
									<i>Verificando resultados<br/>antes de confirmar...</i>
                                 </div>
                                 <?php
                             }?>   
                            </div>
						<?php
                        } else {
                            if (isset($eje1LugarSimple[$hip]) && isset($DivWinPriLugar[$hip]) &&  $eje1LugarSimple[$hip]>0 && $DivWinPriLugar[$hip]>0 && $row_Recordset1['control_dividendo']==2) {
                                echo
                                "<DIV align='center' style='color:red; text-align:center'><strong>CARRERA CONFIRMADA</strong></DIV>";
                            } else {?>
                                 <div style="float:right; text-align:center; background: #F06; width:195px; height:auto;
                                 	color:#FFF; padding:5px 0px 2px 0px; font-size:18px">
									<i>Verificando resultados...</i>
                                 </div>
                                 <?php
                            }
                        } ?>
                        </td>
				      </tr>
                      </table>
					<?php
                        $cod_carrera=$row_Recordset1['cod_carrera'];
                        if (isset($eje1LugarSimple[$hip])) {
                            $eje_primero=$eje1LugarSimple[$hip];
                        } else {
                            $eje_primero=0;
                        }
                        if (isset($eje1LugarDoble[$hip])) {
                            $eje_doble_primero=$eje1LugarDoble[$hip];
                        } else {
                            $eje_doble_primero=0;
                        }
                        if (isset($eje1LugarTriple[$hip])) {
                            $eje_triple_primero=$eje1LugarTriple[$hip];
                        } else {
                            $eje_triple_primero=0;
                        }
                        if (isset($eje2LugarSimple[$hip])) {
                            $eje_segundo=$eje2LugarSimple[$hip];
                        } else {
                            $eje_segundo=0;
                        }
                        if (isset($eje2LugarDoble[$hip])) {
                            $eje_doble_segundo=$eje2LugarDoble[$hip];
                        } else {
                            $eje_doble_segundo=0;
                        }
                        if (isset($eje2LugarTriple[$hip])) {
                            $eje_triple_segundo=$eje2LugarTriple[$hip];
                        } else {
                            $eje_triple_segundo =0;
                        }
                        if (isset($eje3LugarSimple[$hip])) {
                            $eje_tercero =$eje3LugarSimple[$hip];
                        } else {
                            $eje_tercero=0;
                        }
                        if (isset($eje3LugarDoble[$hip])) {
                            $eje_doble_tercero=$eje3LugarDoble[$hip];
                        } else {
                            $eje_doble_tercero=0;
                        }
                        if (isset($eje3LugarTriple[$hip])) {
                            $eje_triple_tercero=$eje3LugarTriple[$hip];
                        } else {
                            $eje_triple_tercero=0;
                        }
                        if (isset($DivWinPriLugar[$hip])) {
                            $div_primero_gan=$DivWinPriLugar[$hip];
                        } else {
                            $div_primero_gan=0;
                        }
                        if (isset($DivPlaPriLugar[$hip])) {
                            $div_primero_pla=$DivPlaPriLugar[$hip];
                        } else {
                            $div_primero_pla=0;
                        }
                        if (isset($DivShoPriLugar[$hip])) {
                            $div_primero_sho=$DivShoPriLugar[$hip];
                        } else {
                            $div_primero_sho=0;
                        }
                        if (isset($DivWinPriLugarDoble[$hip])) {
                            $div_doble_primero_gan=$DivWinPriLugarDoble[$hip];
                        } else {
                            $div_doble_primero_gan =0;
                        }
                        if (isset($DivPlaPriLugarDoble[$hip])) {
                            $div_doble_primero_pla=$DivPlaPriLugarDoble[$hip];
                        } else {
                            $div_doble_primero_pla=0;
                        }
                        if (isset($DivShoPriLugarDoble[$hip])) {
                            $div_doble_primero_sho=$DivShoPriLugarDoble[$hip];
                        } else {
                            $div_doble_primero_sho=0;
                        }
                        if (isset($DivWinPriLugarTriple[$hip])) {
                            $div_triple_primero_gan=$DivWinPriLugarTriple[$hip];
                        } else {
                            $div_triple_primero_gan =0;
                        }
                        if (isset($DivPlaPriLugarTriple[$hip])) {
                            $div_triple_primero_pla=$DivPlaPriLugarTriple[$hip];
                        } else {
                            $div_triple_primero_pla=0;
                        }
                        if (isset($DivShoPriLugarTriple[$hip])) {
                            $div_triple_primero_sho=$DivShoPriLugarTriple[$hip];
                        } else {
                            $div_triple_primero_sho=0;
                        }
                        if (isset($DivPlaSegLugar[$hip])) {
                            $div_segundo_pla=$DivPlaSegLugar[$hip];
                        } else {
                            $div_segundo_pla=0;
                        }
                        if (isset($DivShoSegLugar[$hip])) {
                            $div_segundo_sho=$DivShoSegLugar[$hip];
                        } else {
                            $div_segundo_sho=0;
                        }
                        if (isset($DivPlaSegLugarDoble[$hip])) {
                            $div_doble_segundo_pla=$DivPlaSegLugarDoble[$hip];
                        } else {
                            $div_doble_segundo_pla=0;
                        }
                        if (isset($DivShoSegLugarDoble[$hip])) {
                            $div_doble_segundo_sho=$DivShoSegLugarDoble[$hip];
                        } else {
                            $div_doble_segundo_sho=0;
                        }
                        if (isset($DivPlaSegLugarTriple[$hip])) {
                            $div_triple_segundo_pla=$DivPlaSegLugarTriple[$hip];
                        } else {
                            $div_triple_segundo_pla=0;
                        }
                        if (isset($DivShoSegLugarTriple[$hip])) {
                            $div_triple_segundo_sho=$DivShoSegLugarTriple[$hip];
                        } else {
                            $div_triple_segundo_sho=0;
                        }
                        if (isset($DivShoTerLugar[$hip])) {
                            $div_tercero_sho=$DivShoTerLugar[$hip];
                        } else {
                            $div_tercero_sho=0;
                        }
                        if (isset($DivShoTerLugarDoble[$hip])) {
                            $div_doble_tercero_sho=$DivShoTerLugarDoble[$hip];
                        } else {
                            $div_doble_tercero_sho=0;
                        }
                        if (isset($DivShoTerLugarTriple[$hip])) {
                            $div_triple_tercero_sho=$DivShoTerLugarTriple[$hip];
                        } else {
                            $div_triple_tercero_sho=0;
                        }
                        if (isset($eje4LugarSimple[$hip])) {
                            $eje_cuarto=$eje4LugarSimple[$hip];
                        } else {
                            $eje_cuarto=0;
                        }
                        if ($eje_primero==0 && $eje_segundo==99 && $eje_tercero =99) {
                            $eje_primero=99;
                        }
                        
                        
                        
                        
                        
                        //aqui comienza
                        if ($row_Recordset1['bus_resultado_tip']==1 or $row_Recordset1['bus_resultado_tip']==5 or $row_Recordset1['bus_resultado_tip']==6 or $row_Recordset1['bus_resultado_tip']==7) {
                            if ($row_Recordset1['control_dividendo']==1) {
                                if ($row_Recordset1['eje_primero']==$eje_primero*1 &&
                    number_format($row_Recordset1['div_primero_gan'], 2)==number_format(floatval($div_primero_gan), 2) &&
                    number_format($row_Recordset1['div_primero_pla'], 2)==number_format(floatval($div_primero_pla), 2) &&
                    number_format($row_Recordset1['div_primero_sho'], 2)==number_format(floatval($div_primero_sho), 2) &&
                    $row_Recordset1['eje_segundo']==$eje_segundo*1 &&
                    number_format($row_Recordset1['div_segundo_pla'], 2)==number_format(floatval($div_segundo_pla), 2) &&
                    number_format($row_Recordset1['div_segundo_sho'], 2)==number_format(floatval($div_segundo_sho), 2) &&
                    $row_Recordset1['eje_tercero']==$eje_tercero*1 &&
                    number_format($row_Recordset1['div_tercero_sho'], 2)==number_format(floatval($div_tercero_sho), 2) &&
                    $row_Recordset1['eje_doble_primero']==$eje_doble_primero*1 &&
                    number_format($row_Recordset1['div_doble_primero_gan'], 2)==number_format(floatval($div_doble_primero_gan), 2) &&
                    number_format($row_Recordset1['div_doble_primero_pla'], 2)==number_format(floatval($div_doble_primero_pla), 2) &&
                    number_format($row_Recordset1['div_doble_primero_sho'], 2)==number_format(floatval($div_doble_primero_sho), 2) &&
                    $row_Recordset1['eje_doble_segundo']==$eje_doble_segundo*1 &&
                    number_format($row_Recordset1['div_doble_segundo_pla'], 2)==number_format(floatval($div_doble_segundo_pla), 2) &&
                    number_format($row_Recordset1['div_doble_segundo_sho'], 2)==number_format(floatval($div_doble_segundo_sho), 2) &&
                    $row_Recordset1['eje_doble_tercero']==$eje_doble_tercero*1 &&
                    number_format($row_Recordset1['div_doble_tercero_sho'], 2)==number_format(floatval($div_doble_tercero_sho), 2) &&
                    $row_Recordset1['eje_triple_primero']==$eje_triple_primero*1 &&
                    number_format($row_Recordset1['div_triple_primero_gan'], 2)==number_format(floatval($div_triple_primero_gan), 2) &&
                    number_format($row_Recordset1['div_triple_primero_pla'], 2)==number_format(floatval($div_triple_primero_pla), 2) &&
                    number_format($row_Recordset1['div_triple_primero_sho'], 2)==number_format(floatval($div_triple_primero_sho), 2) &&
                    $row_Recordset1['eje_triple_segundo']==$eje_triple_segundo*1 &&
                    number_format($row_Recordset1['div_triple_segundo_pla'], 2)==number_format(floatval($div_triple_segundo_pla), 2) &&
                    number_format($row_Recordset1['div_triple_segundo_sho'], 2)==number_format(floatval($div_triple_segundo_sho), 2) &&
                    $row_Recordset1['eje_triple_tercero']==$eje_triple_tercero*1 &&
                    number_format($row_Recordset1['div_triple_tercero_sho'], 2)==number_format(floatval($div_triple_tercero_sho), 2) &&
                    $row_Recordset1['eje_cuarto']==$eje_cuarto*1 &&
                    number_format($row_Recordset1['div_exacta'], 2)==number_format(floatval($div_exacta), 2) &&
                    number_format($row_Recordset1['fac_exacta'], 2)==number_format(floatval($fac_exacta), 2) &&
                    number_format($row_Recordset1['div_trifecta'], 2)==number_format(floatval($div_trifecta), 2) &&
                    number_format($row_Recordset1['fac_trifecta'], 2)==number_format(floatval($fac_trifecta), 2) &&
                    number_format($row_Recordset1['div_superfecta'], 2)==number_format(floatval($div_superfecta), 2) &&
                    number_format($row_Recordset1['fac_superfecta'], 2)==number_format(floatval($fac_superfecta), 2) &&
                    number_format($row_Recordset1['div_exacta_doble'], 2)==number_format(floatval($div_exacta_doble), 2) &&
                    number_format($row_Recordset1['div_exacta_triple'], 2)==number_format(floatval($div_exacta_triple), 2) &&
                    number_format($row_Recordset1['div_trifecta_doble'], 2)==number_format(floatval($div_trifecta_doble), 2) &&
                    number_format($row_Recordset1['div_trifecta_triple'], 2)==number_format(floatval($div_trifecta_triple), 2) &&
                    number_format($row_Recordset1['div_superfecta_doble'], 2)==number_format(floatval($div_superfecta_doble), 2) &&
                    number_format($row_Recordset1['div_superfecta_triple'], 2)==number_format(floatval($div_superfecta_triple), 2) &&
                    $row_Recordset1['ord_exacta']==trim($ord_exacta) &&
                    $row_Recordset1['ord_exacta_doble']==trim($ord_exacta_doble) &&
                    $row_Recordset1['ord_exacta_triple']==trim($ord_exacta_triple) &&
                    $row_Recordset1['ord_trifecta']==trim($ord_trifecta) &&
                    $row_Recordset1['ord_trifecta_doble']==trim($ord_trifecta_doble) &&
                    $row_Recordset1['ord_trifecta_triple']==trim($ord_trifecta_triple) &&
                    $row_Recordset1['ord_superfecta']==trim($ord_superfecta) &&
                    $row_Recordset1['ord_superfecta_doble']==trim($ord_superfecta_doble) &&
                    $row_Recordset1['ord_superfecta_triple']==trim($ord_superfecta_triple)) {
                                    $control_dividendo=2;
                                } else {
                                    $control_dividendo=1;
                                    $est_confirmacion=1;
                                }
                            }
                        
                        
                        
                        
                        
                        
                        
                            if ($row_Recordset1['cod_confirmacion']==1 && $eje1LugarSimple[$hip]>0) {
                                $est_confirmacion=1;
                            } else {
                                if ($row_Recordset1['control_dividendo']==2) {
                                    $est_confirmacion=0;
                                } else {
                                    $est_confirmacion=1;
                                }
                            }
                        
                        
                            $tiempodesdecierre=restahoras($row_Recordset1['hor_carrera'], $horasistema);
                            echo $tiempodesdecierre;
                            if (($div_exacta>0) OR ($div_primero_gan>0 && $div_primero_gan>0 && $tiempodesdecierre>='00:07:00')){
                            
                        
                        //if ($control_dividendo==2) $est_confirmacion=0;
                                //echo number_format($row_Recordset1['div_superfecta'],2)." - ".number_format(floatval($div_superfecta),2);
                                if ((isset($eje1LugarSimple[$hip]) && isset($DivWinPriLugar[$hip]) && $eje1LugarSimple[$hip]>0 &&
                            $DivWinPriLugar[$hip]>0) ||
                            (isset($eje1LugarSimple[$hip]) && isset($DivWinPriLugar[$hip]) && $eje1LugarSimple[$hip]==99 &&
                            $DivWinPriLugar[$hip]==0)) {
                                    if ($row_Recordset1['control_dividendo']==0) {
                                        $control_dividendo=1;
                                    }
                                    if ($control_dividendo==2){ $hconfir=$horasistema;  }else{$hconfir='00:00:00';}
                                    $updateSQL = sprintf(
                                        "/* PARSEADORES1 includes\dividendos_totalrecargadotrackinfonew.php - QUERY 2 */ UPDATE carrera 
							SET 
							confirmandox=%s,
								est_confirmacion=%s,
								control_dividendo=%s,
								eje_primero=%s, 
								div_primero_gan=%s, 
								div_primero_pla=%s, 
								div_primero_sho=%s, 
								eje_segundo=%s, 
								div_segundo_pla=%s, 
								div_segundo_sho=%s, 
								eje_tercero=%s, 
								div_tercero_sho=%s, 
								eje_doble_primero=%s, 
								div_doble_primero_gan=%s, 
								div_doble_primero_pla=%s, 
								div_doble_primero_sho=%s, 
								eje_doble_segundo=%s, 
								div_doble_segundo_pla=%s, 
								div_doble_segundo_sho=%s, 
								eje_doble_tercero=%s, 
								div_doble_tercero_sho=%s, 
								eje_triple_primero=%s, 
								div_triple_primero_gan=%s, 
								div_triple_primero_pla=%s, 
								div_triple_primero_sho=%s, 
								eje_triple_segundo=%s, 
								div_triple_segundo_pla=%s, 
								div_triple_segundo_sho=%s, 
								eje_triple_tercero=%s, 
								div_triple_tercero_sho=%s,
								eje_cuarto=%s,
								div_exacta=%s,
								fac_exacta=%s,
								div_trifecta=%s,
								fac_trifecta=%s,
								div_superfecta=%s,
								fac_superfecta=%s,
								div_exacta_doble=%s,
								div_exacta_triple=%s,
								div_trifecta_doble=%s,
								div_trifecta_triple=%s,
								div_superfecta_doble=%s,
								div_superfecta_triple=%s,
								
								ord_exacta=%s,
								ord_exacta_doble=%s,
								ord_exacta_triple=%s,
								ord_trifecta=%s,
								ord_trifecta_doble=%s,
								ord_trifecta_triple=%s,
								ord_superfecta=%s,
								ord_superfecta_doble=%s,
								ord_superfecta_triple=%s,
								hconfir=%s,
								pickresultados=%s
							WHERE cod_carrera=%s",
                                        GetSQLValueString(1, "int"),
                                        GetSQLValueString($est_confirmacion, "int"),
                                        GetSQLValueString($control_dividendo, "int"),
                                        GetSQLValueString($eje_primero, "int"),
                                        GetSQLValueString($div_primero_gan, "double"),
                                        GetSQLValueString($div_primero_pla, "double"),
                                        GetSQLValueString($div_primero_sho, "double"),
                                        GetSQLValueString($eje_segundo, "int"),
                                        GetSQLValueString($div_segundo_pla, "double"),
                                        GetSQLValueString($div_segundo_sho, "double"),
                                        GetSQLValueString($eje_tercero, "int"),
                                        GetSQLValueString($div_tercero_sho, "double"),
                                        GetSQLValueString($eje_doble_primero, "int"),
                                        GetSQLValueString($div_doble_primero_gan, "double"),
                                        GetSQLValueString($div_doble_primero_pla, "double"),
                                        GetSQLValueString($div_doble_primero_sho, "double"),
                                        GetSQLValueString($eje_doble_segundo, "int"),
                                        GetSQLValueString($div_doble_segundo_pla, "double"),
                                        GetSQLValueString($div_doble_segundo_sho, "double"),
                                        GetSQLValueString($eje_doble_tercero, "int"),
                                        GetSQLValueString($div_doble_tercero_sho, "double"),
                                        GetSQLValueString($eje_triple_primero, "int"),
                                        GetSQLValueString($div_triple_primero_gan, "double"),
                                        GetSQLValueString($div_triple_primero_pla, "double"),
                                        GetSQLValueString($div_triple_primero_sho, "double"),
                                        GetSQLValueString($eje_triple_segundo, "int"),
                                        GetSQLValueString($div_triple_segundo_pla, "double"),
                                        GetSQLValueString($div_triple_segundo_sho, "double"),
                                        GetSQLValueString($eje_triple_tercero, "int"),
                                        GetSQLValueString($div_triple_tercero_sho, "double"),
                                        GetSQLValueString($eje_cuarto, "int"),
                                        GetSQLValueString($div_exacta, "double"),
                                        GetSQLValueString($fac_exacta, "double"),
                                        GetSQLValueString($div_trifecta, "double"),
                                        GetSQLValueString($fac_trifecta, "double"),
                                        GetSQLValueString($div_superfecta, "double"),
                                        GetSQLValueString($fac_superfecta, "double"),
                                        GetSQLValueString($div_exacta_doble, "double"),
                                        GetSQLValueString($div_exacta_triple, "double"),
                                        GetSQLValueString($div_trifecta_doble, "double"),
                                        GetSQLValueString($div_trifecta_triple, "double"),
                                        GetSQLValueString($div_superfecta_doble, "double"),
                                        GetSQLValueString($div_superfecta_triple, "double"),
                                        GetSQLValueString($ord_exacta, "text"),
                                        GetSQLValueString($ord_exacta_doble, "text"),
                                        GetSQLValueString($ord_exacta_triple, "text"),
                                        GetSQLValueString($ord_trifecta, "text"),
                                        GetSQLValueString($ord_trifecta_doble, "text"),
                                        GetSQLValueString($ord_trifecta_triple, "text"),
                                        GetSQLValueString($ord_superfecta, "text"),
                                        GetSQLValueString($ord_superfecta_doble, "text"),
                                        GetSQLValueString($ord_superfecta_triple, "text"),
                                        GetSQLValueString($hconfir, "date"),
                                        GetSQLValueString($ddydemas, "text"),
                                        GetSQLValueString($cod_carrera, "int")
                                        
                                    );
                                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));

							if ($est_confirmacion==1) {
                $fechaactual=fechaactualbd();
                $insertSQL = sprintf(
                    "/* PARSEADORES1 includes\dividendos_totalrecargadotrackinfonew.php - QUERY 3 */ INSERT INTO quiencierrayabre 
					(codcarrera, 
					fechaquien, 
					que) 
					VALUES (%s, %s, %s)",
                    GetSQLValueString($cod_carrera, "int"),
                    GetSQLValueString($fechaactual, "date"),
                    GetSQLValueString(21, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca)); }


                                    if ($est_confirmacion==0) {
                $fechaactual=fechaactualbd();
                $insertSQL = sprintf(
                    "/* PARSEADORES1 includes\dividendos_totalrecargadotrackinfonew.php - QUERY 4 */ INSERT INTO quiencierrayabre 
					(codcarrera, 
					fechaquien, 
					que) 
					VALUES (%s, %s, %s)",
                    GetSQLValueString($cod_carrera, "int"),
                    GetSQLValueString($fechaactual, "date"),
                    GetSQLValueString(26, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));



                                        $tipoProceso=2;
                                        include("procesar_resultados_tickets_ame.php");
                                        echo "<h3><font color='#027BAD'>Proceso de cálculo culminado! ".$carrera."</font></h3>";
                                    }
                                }
                            }
                        
                        
                        
                        
                        
                        
                        
                            //aqui termina
                        }
                        
                        











                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        $cont=0;
                        break;
                    }
                    $f++;
                }
            } else {?>
			<table width="100%" border="1" bordercolor="#20c8a8">
				<tr>
					<td width="53" align="center"><?php echo $row_Recordset1['hor_carrera'] ?></td>
					<td width="678" rowspan="3"><?php
                        if ($row_Recordset1['bus_resultado_tip']==0) {
                            $pagina="";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==1) {
                            $pagina="--> TRACK INFO";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==2) {
                            $pagina="--> BASIC TVG";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==3) {
                            $pagina="--> BUILDABET";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==4) {
                            $pagina="--> ";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==5) {
                            $pagina="--> ";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==21) {
                            $pagina="--> TRACK 21 pruebas";
                        }
                        list($a, $m, $d)=explode("-", $row_Recordset1['fec_carrera']);
                        $fecha=$d."-".$m."-".$a;
                        $carrera=$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera'];
                        echo $carrera." (".$fecha.") ".$pagina; ?>
                        <div id="botCancela<?php echo $row_Recordset1['cod_carrera']; ?>" 
                           	style="padding:0px 390px 0px 0px;float:left">
							<a onclick='if(confirm("¿Seguro quiere cancelar la carrera?"))cancelaCar(
								"<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divws1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#exac<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#trif<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#supe<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#botCancela<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botReset<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>")' 
								class="btn btn-danger" style="color: #FFF" title="cancelar <?php echo $carrera; ?>">Cancelar
							</a>
						</div>
                    </td>
					<td width="379" rowspan="3" align="center">Esperando por resultados...
					</td>
				</tr>
				<tr>
					
					<td align="center"><span style="font-size:14px;">CORREN</span>
					</td>
			    </tr>
				<tr>
                	<?php $van=$row_Recordset1['can_caballos']-cantRetirados($row_Recordset1['cod_carrera']); ?>
					<td height="43" align="center"style="font-size:34px;color:#FFF;background:#C00;"><?php echo $van; ?></td>
				</tr>
			</table>
		<?php
        }
        }	//fin if si es track info
        else {?>
                    <table width="100%" border="1" bordercolor="#F90" style="color:#FF0000">
					  <tr>
					    <td colspan="6" align="center"><strong>--CARGAR DIVIDENDOS MANUALMENTE--</strong></td>
				      </tr>
					  <tr>
						<td width="53" align="center"><?php echo $row_Recordset1['hor_carrera'] ?></td>
						<td>
							<?php
                            list($a, $m, $d)=explode("-", $row_Recordset1['fec_carrera']);
                            $fecha=$d."-".$m."-".$a;
                            $carrera=$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera'];
                            echo $carrera." (".$fecha.")"; ?>
                        </td>
						<td width="80" align="center">
                        <div id="ejes1<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['eje_primero']; ?>
                        </div>    
                        </td>
						<td width="40" align="right">
                        <div id="divws1<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_primero_gan']; ?>
                        </div>
                        </td>
						<td width="40" align="right">
                        <div id="divps1<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_primero_pla']; ?>
                        </div>
                        </td>
						<td width="40" align="right">
                        <div id="divss1<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_primero_sho']; ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
						<td align="center">&nbsp;</td>
						<td style="font-size:12px">
						<div id="exac<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                            if ($row_Recordset1['eje_tercero']>0 && $row_Recordset1['eje_segundo']>0) {
                                $eex=$row_Recordset1['eje_primero']."-".$row_Recordset1['eje_segundo'];
                                echo"EX: ".$eex." Pago: ".$row_Recordset1['div_exacta']." ->".$row_Recordset1['fac_exacta'];
                            }
                        ?>
                        </div>
                        </td>
						<td align="center">
						<div id="ejes2<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['eje_segundo']; ?>
                        </div>
                        </td>
						<td align="right">&nbsp;</td>
						<td align="right">
						<div id="divps2<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_segundo_pla']; ?>
                        </div>
                        </td>
						<td align="right">
						<div id="divss2<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_segundo_sho']; ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
						<td align="center">&nbsp;</td>
						<td style="font-size:12px">
						<div id="trif<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                            if ($row_Recordset1['eje_tercero']>0 && $row_Recordset1['eje_segundo']>0
                                && $row_Recordset1['eje_primero']>0) {
                                $etr=$row_Recordset1['eje_primero']."-".$row_Recordset1['eje_segundo']."-".$row_Recordset1['eje_tercero'];
                                echo "| TR".$etr." Pago: ".$row_Recordset1['div_trifecta'];
                                " ->".$row_Recordset1['fac_trifecta'];
                            }
                        ?>
                        </div>
                        </td>
						<td align="center">
						<div id="ejes3<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['eje_tercero']; ?>
                        </div>
                        </td>
						<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td align="right">
						<div id="divss3<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_tercero_sho']; ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
					    <td align="center">&nbsp;</td>
					    <td style="font-size:12px">
						<div id="supe<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                            if ($row_Recordset1['eje_tercero']>0 && $row_Recordset1['eje_segundo']>0
                                && $row_Recordset1['eje_primero']>0 && $row_Recordset1['eje_cuarto']>0) {
                                $esp=$row_Recordset1['eje_primero']."-".$row_Recordset1['eje_segundo']."-".$row_Recordset1['eje_tercero']."-".$row_Recordset1['eje_cuarto'];
                                echo"SU: ".$esp." Pago: ".$row_Recordset1['div_superfecta']." ->".$row_Recordset1['fac_superfecta'];
                            }
                        ?>
                        </div>
                        </td>
					    <td align="center">
                        <div id="ejes4<?php echo $row_Recordset1['cod_carrera']; ?>">
                        	<?php echo $row_Recordset1['eje_cuarto']; ?>
                        </div>
                        </td>
					    <td align="right">&nbsp;</td>
					    <td align="right">&nbsp;</td>
					    <td align="right">&nbsp;</td>
  					  </tr>
					  <tr>
					    <td colspan="6" align="left" valign="top">
                        	<div id="botReset<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            style="float:left; padding:0px 15px 0px 0px">
                            	<a href="#" onClick="resetDiv('<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divws1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divps1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divps2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss3<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#exac<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#trif<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#supe<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>')"
                                id="botR<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	title="reset dividendos <?php echo $carrera; ?>" class="btn btn-info" style="color: #FFF">Reset</a>
                            </div>   
                             
                            <div id="botModifica<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            style="float:left; padding:0px 15px 0px 0px">
                            	<a href="#" onClick="ModiDiv('<?php echo $row_Recordset1['cod_carrera']; ?>','1')" 
                            	title="modificar dividendos <?php echo $carrera; ?>" 
                                class="btn btn-inverse" style="color: #FFF">Modificar</a>
                        	</div>
                        	<div id="botCancela<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="padding:0px 390px 0px 0px;float:left">
									<a onclick='if(confirm("¿Seguro quiere cancelar la carrera?"))cancelaCar(
										"<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divws1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#exac<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#trif<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#supe<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#botCancela<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botReset<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>")' 
                                    class="btn btn-danger" 
                                    style="color: #FFF" 
                                    title="cancelar <?php echo $carrera; ?>">Cancelar</a>
                            </div>
                        	<div id="botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="float:left; text-align:center">
                            <?php
                            if ($row_Recordset1['eje_primero']>0) {?>
                                <a href="#" onClick="confirmarDiv(<?php echo $row_Recordset1['cod_carrera']; ?>,
                                '#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botReset<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>');"
                                title="confirmar dividendos <?php echo $carrera; ?>" 
                                class="btn btn-success" style="color: #FFF">Confirmar</a>
                            	<?php
                            }?>    
                            </div>
                        </td>
				      </tr>
                      </table>
	<?php }

        if ($eje1LugarSimple[$hip]=="0") {
            echo "cancelar";
            echo "<br>";
        }
        echo $eje1LugarSimple[$hip];
        echo "<br>";
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    
    mysqli_free_result($Recordset1);
}
if (!isset($f)) {?>
	<div style="float:right; text-align:center; background: #FFF; width:100%; height:auto;
	color: #333; padding:25px 0px 2px 0px; font-size:24px">
		<i class="fa fa-refresh fa-spin"></i> Esperando por cierre de alguna carrera
	</div>
	<?php
}

?>
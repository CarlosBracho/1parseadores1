<?php
 
error_reporting(E_ALL);
ini_set('display_errors', '1');
echo  'V3<br>';
 require_once('../Connections/conexionbanca.php');
$eje1LugarSimple=0;
include('../includes/dividendos_funcion.php');
$fech=fechaactualbd();
list($a, $m, $d)=explode("-", $fech);
$fe=$m.$d.substr($a, 2, 2);
$horasistema=horaactual();
echo 'wwwwwwwwwwwwwww<br>';
function resultadoTrackInfo2($url, $permite)
{
    echo 'wwwwwwwwwwwwwww<br>';
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
        //$html=str_replace('(', '', $html); 
        //$html=str_replace(')', '', $html); 
        //$html=str_replace(' 4 right', '', $html); 
        

        //echo $html;
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
                    $tabla1[$a+16]=str_replace("A", "99", $tabla1[$a+16]);
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
                    $tabla1[$a+28]=str_replace("A", "99", $tabla1[$a+28]);
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
                    $tabla1[$a+40]=str_replace("A", "99", $tabla1[$a+40]);
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
                $divExotic[$nCar][0][$ctaEx][2]=str_replace("$", "", trim(strip_tags($df[4])));
                $divExotic[$nCar][0][$ctaEx][2]=str_replace(',', '', $divExotic[$nCar][0][$ctaEx][2]); // dividendo
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
                $divExotic[$nCar][3][$ctaDD][2]=str_replace(',', '', $divExotic[$nCar][0][$ctaDD][2]);
                $divExotic[$nCar][3][$ctaDD][3]=str_replace("$", "", trim(strip_tags($df[0])));	 // factor
                $ctaDD++;
            }
            if (strpos($info2, "PICK THREE")!==false || strpos($info2, "0 P3")!==false) {
                $df=explode(" ", $info2);
                $divExotic[$nCar][4][$ctaP3][0]="PICKTHREE"; // tipo de exotica
                $divExotic[$nCar][4][$ctaP3][1]=str_replace("/", "-", trim(strip_tags($df[3])));	 // llegada
                $divExotic[$nCar][4][$ctaP3][2]=str_replace("$", "", trim(strip_tags($df[5]))); // dividendo
                $divExotic[$nCar][4][$ctaP3][2]=str_replace(',', '', $divExotic[$nCar][1][$ctaP3][2]);
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
                var_dump($df);
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
                var_dump($df);
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
    //print_r($divExotic);
    
    return array($cAct,$eje1LugarSimple,$eje1LugarDoble,$eje1LugarTriple,$eje2LugarSimple,$eje2LugarDoble,$eje2LugarTriple,$eje3LugarSimple,$eje3LugarDoble,$eje3LugarTriple,$eje4LugarSimple,$eje4LugarDoble,$eje4LugarTriple,$DivWinPriLugar,$DivWinPriLugarDoble,$DivWinPriLugarTriple,$DivPlaPriLugar,$DivPlaPriLugarDoble,$DivPlaPriLugarTriple,$DivShoPriLugar,$DivShoPriLugarDoble,$DivShoPriLugarTriple,$DivPlaSegLugar,$DivPlaSegLugarDoble,$DivPlaSegLugarTriple,$DivShoSegLugar,$DivShoSegLugarDoble,$DivShoSegLugarTriple,$DivShoTerLugar,$DivShoTerLugarDoble,$DivShoTerLugarTriple,$divExotic,$existe);
}
$url='https://www.trackinfo.com/results-print-all.jsp?trackcode=TGG$&racedate=2022-09-04&raceperf=D';
list($cAct, $eje1LugarSimple, $eje1LugarDoble, $eje1LugarTriple, $eje2LugarSimple, $eje2LugarDoble, $eje2LugarTriple, $eje3LugarSimple, $eje3LugarDoble, $eje3LugarTriple, $eje4LugarSimple, $eje4LugarDoble, $eje4LugarTriple, $DivWinPriLugar, $DivWinPriLugarDoble, $DivWinPriLugarTriple, $DivPlaPriLugar, $DivPlaPriLugarDoble, $DivPlaPriLugarTriple, $DivShoPriLugar, $DivShoPriLugarDoble, $DivShoPriLugarTriple, $DivPlaSegLugar, $DivPlaSegLugarDoble, $DivPlaSegLugarTriple, $DivShoSegLugar, $DivShoSegLugarDoble, $DivShoSegLugarTriple, $DivShoTerLugar, $DivShoTerLugarDoble, $DivShoTerLugarTriple, $divExotic, $existe)=resultadoTrackInfo2($url, 1);// 0 no permite ABCDEX   //1 permite ABCDEX

//echo $cAct, $eje1LugarSimple, $eje1LugarDoble, $eje1LugarTriple, $eje2LugarSimple, $eje2LugarDoble, $eje2LugarTriple, $eje3LugarSimple, $eje3LugarDoble, $eje3LugarTriple, $eje4LugarSimple, $eje4LugarDoble, $eje4LugarTriple, $DivWinPriLugar, $DivWinPriLugarDoble, $DivWinPriLugarTriple, $DivPlaPriLugar, $DivPlaPriLugarDoble, $DivPlaPriLugarTriple, $DivShoPriLugar, $DivShoPriLugarDoble, $DivShoPriLugarTriple, $DivPlaSegLugar, $DivPlaSegLugarDoble, $DivPlaSegLugarTriple, $DivShoSegLugar, $DivShoSegLugarDoble, $DivShoSegLugarTriple, $DivShoTerLugar, $DivShoTerLugarDoble, $DivShoTerLugarTriple, $divExotic, $existe
//print_r($divExotic);
echo '<br><br><br><br><br><br>';
foreach($divExotic as $divExotic2){ 
    print_r($divExotic2); 
    echo '<br><br><br><br><br><br>';
    
    }

<?php
function url_exists($url)
{
    set_time_limit(0);
    $h = get_headers($url);
    $status = array();
    preg_match('/HTTP\/.* ([0-9]+) .*/', $h[0], $status);
    return ($status[1] == 200);
}
function xml2array($url, $get_attributes = 1, $priority = 'tag')
{
    $contents = "";
    if (!function_exists('xml_parser_create')) {
        return array();
    }
    $parser = xml_parser_create('');
    if (!($fp = @ fopen($url, 'rb'))) {
        return array();
    }
    while (!feof($fp)) {
        $contents .= fread($fp, 8192);
    }
    fclose($fp);
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if (!$xml_values) {
        return;
    } //Hmm...
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();
    $current = & $xml_array;
    $repeated_tag_index = array();
    foreach ($xml_values as $data) {
        unset($attributes, $value);
        extract($data);
        $result = array();
        $attributes_data = array();
        if (isset($value)) {
            if ($priority == 'tag') {
                $result = $value;
            } else {
                $result['value'] = $value;
            }
        }
        if (isset($attributes) and $get_attributes) {
            foreach ($attributes as $attr => $val) {
                if ($priority == 'tag') {
                    $attributes_data[$attr] = $val;
                } else {
                    $result['attr'][$attr] = $val;
                } //Set all the attributes in a array called 'attr'
            }
        }
        if ($type == "open") {
            $parent[$level -1] = & $current;
            if (!is_array($current) or (!in_array($tag, array_keys($current)))) {
                $current[$tag] = $result;
                if ($attributes_data) {
                    $current[$tag . '_attr'] = $attributes_data;
                }
                $repeated_tag_index[$tag . '_' . $level] = 1;
                $current = & $current[$tag];
            } else {
                if (isset($current[$tag][0])) {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                } else {
                    $current[$tag] = array(
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                    if (isset($current[$tag . '_attr'])) {
                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                        unset($current[$tag . '_attr']);
                    }
                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = & $current[$tag][$last_item_index];
            }
        } elseif ($type == "complete") {
            if (!isset($current[$tag])) {
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                if ($priority == 'tag' and $attributes_data) {
                    $current[$tag . '_attr'] = $attributes_data;
                }
            } else {
                if (isset($current[$tag][0]) and is_array($current[$tag])) {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    if ($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag . '_' . $level]++;
                } else {
                    $current[$tag] = array(
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $get_attributes) {
                        if (isset($current[$tag . '_attr'])) {
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset($current[$tag . '_attr']);
                        }
                        if ($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                }
            }
        } elseif ($type == 'close') {
            $current = & $parent[$level -1];
        }
    }
    return ($xml_array);
}
function existe($url)
{
    $handle = @fopen($url, "r");
    if ($handle == false) {
        return false;
    }
    fclose($handle);
    return true;
}
function buscarExoticas($xpalabra, $text)
{
    $resultado="0";
    if (strpos($text, $xpalabra) !== false) {
        $resultado="1";
    }
    return $resultado;
}
function resultadoCarreras($url)
{
    $cAct=array();
    $eje1LugarSimple=array();
    $eje2LugarSimple=array();
    $eje3LugarSimple=array();
    $eje4LugarSimple=array();
    $DivWinPriLugar=array();
    $DivPlaPriLugar=array();
    $DivShoPriLugar=array();
    $DivPlaSegLugar=array();
    $DivShoSegLugar=array();
    $DivShoTerLugar=array();
    $divExotic=array();
    set_time_limit(0);
    $existe=url_exists($url);
    if ($existe==1) {
        $jExoticas=array("DAILY DOUBLE","EXACTA","EXACTOR","SUPERFECTA","TRIFECTA","TRIACTOR","PICK 3","PICK 4","PICK 5","PICK 6","JACKPOT PICK 9","JACKPOT HIGH-5","QUINELLA", "PICK 10");
        include_once('simple_html_dom.php');
        $html = file_get_html($url);
        foreach ($html->find('div[class="interior-content col-sm-8"]') as $article) {
            $x1=$article->find('h5[class="lightgreenbg padding-summary"]');
            $x2=$article->find('table[class="table-hover clear"]');
            $x5=$article->find('table[class="table-hover wagerTable"]');
            $xy=$article->find('div[style="width:100%; margin-bottom:15px;"]');
            $bb=$article->find('span[class="whitetxt allcaps padding"]');
            $j1=$article->find('strong');
            $y=0;
            foreach ($j1 as $j11) {
                if (strpos($j11, "Race")!==false && strpos($j11, "Race Type")==false) {
                    $resultado="1";
                } else {
                    $resultado="0";
                }
                if ($resultado==1) {
                    $nCar=trim(strip_tags($j11));
                    $nCar=explode(" ", $nCar);
                    $nCar=trim($nCar[1]);
                    $cAct[$y]=$nCar;
                    $y++;
                }
            }
            $y=0;
            foreach ($x2 as $x111111) {
                $x3=$x2[$y]->find('tr');
                foreach ($x3 as $x31) {
                    $x4=$x2[$y]->find('td');
                    $z=0;
                    foreach ($x4 as $x41) {
                        $res[$z]=$x41->plaintext;
                        if ($z==17) {
                            $nCar=$cAct[$y];
                            $ejePriLugar[$nCar]=$res[0];			// nro de ejemplar 1er lugar
                            $DivWinPriLugar[$nCar]=$res[3];		// dividendo win 1er lugar
                            $DivPlaPriLugar[$nCar]=$res[4];		// dividendo pla 1er lugar
                            $DivShoPriLugar[$nCar]=$res[5];		// dividendo sho 1er lugar
                            $ejeSegLugar[$nCar]=$res[6];			// nro de ejemplar 2do lugar
                            $DivPlaSegLugar[$nCar]=$res[10];		// dividendo pla 2do lugar
                            $DivShoSegLugar[$nCar]=$res[11];		// dividendo sho 2do lugar
                            $ejeTerLugar[$nCar]=$res[12];		// nro de ejemplar 3er lugar
                            $DivShoTerLugar[$nCar]=$res[17];		// dividendo sho 3er lugar
                        }
                        $z++;
                    }
                }
                $y++;
            }
            $r=1;
            foreach ($xy as $xz) { // del cuarto al noveno lugar
                $xz=$xz->plaintext;
                $cua=explode(":", $xz);
                $cua=explode(",", $cua[1]);
                if (isset($cua[0])) {
                    $ejemplar=explode("-", $cua[0]);
                    $ejeCuaLugar[$r]=trim($ejemplar[0]);
                }
                if (isset($cua[1])) {
                    $ejemplar=explode("-", $cua[1]);
                    $ejeQuiLugar[$r]=trim($ejemplar[0]);
                }
                if (isset($cua[2])) {
                    $ejemplar=explode("-", $cua[2]);
                    $ejeSexLugar[$r]=trim($ejemplar[0]);
                }
                if (isset($cua[3])) {
                    $ejemplar=explode("-", $cua[3]);
                    $ejeSepLugar[$r]=trim($ejemplar[0]);
                }
                if (isset($cua[4])) {
                    $ejemplar=explode("-", $cua[4]);
                    $ejeOctLugar[$r]=trim($ejemplar[0]);
                }
                if (isset($cua[5])) {
                    $ejemplar=explode("-", $cua[5]);
                    $ejeNovLugar[$r]=trim($ejemplar[0]);
                }
                $r++;
            }
            for ($i = 0; $i < $y; $i++) {
                for ($j = 0; $j < count($jExoticas); $j++) {
                    $divExotic[$i][$j][0]="";
                    $divExotic[$i][$j][1]="";
                }
            }
            $a=0;
            foreach ($x5 as $x51) {
                $x6=$x5[$a]->find('tr');
                $b=0;
                foreach ($x6 as $x61) {
                    $x7=$x61->find('td');
                    $c=0;
                    foreach ($x7 as $x71) {
                        $exoti[$c]=strtoupper($x71);
                        $exoti[$c]=trim($exoti[$c]);
                        if ($c==2) {
                            $d=0;
                            foreach ($jExoticas as $xl) {
                                $comp=buscarExoticas($jExoticas[$d], $exoti[0]);
                                if ($comp==1) {
                                    $e=strip_tags($exoti[0]);
                                    $e=explode(" ", $e);
                                    $wp=$cAct[$a];
                                    $divExotic[$wp][$d][0]=trim(strtoupper($e[1])); // tipo de exotica
                                    $divExotic[$wp][$d][1]=$exoti[2]; // dividendo
                                    $divExotic[$wp][$d][2]=str_replace("$", "", $e[0]);	 // factor
                                    $llegada=explode("-", strip_tags($exoti[1]));
                                    if (!isset($eje1LugarSimple[$wp])) {
                                        $eje1LugarSimple[$wp]=0;
                                        $eje1LugarTriple[$wp]=0;
                                        $eje1LugarDoble[$wp]=0;
                                        $eje2LugarSimple[$wp]=0;
                                        $eje2LugarTriple[$wp]=0;
                                        $eje2LugarDoble[$wp]=0;
                                        $eje3LugarSimple[$wp]=0;
                                        $eje3LugarTriple[$wp]=0;
                                        $eje3LugarDoble[$wp]=0;
                                        $eje4LugarSimple[$wp]=0;
                                        $eje4LugarTriple[$wp]=0;
                                        $eje4LugarDoble[$wp]=0;
                                    }
                                    if (count($llegada)>=1 && $divExotic[$wp][$d][0]=="EXACTA") {
                                        $uno=explode("/", $llegada[0]);
                                        $eje1LugarSimple[$wp]=$uno[0];
                                        if (isset($uno[1])) {
                                            $eje1LugarDoble[$wp]=$uno[1];
                                            if (isset($uno[2])) {
                                                $eje1LugarTriple[$wp]=$uno[2];
                                            }
                                        }
                                    }
                                    if (count($llegada)>=2 &&
                                    ($divExotic[$wp][$d][0]=="EXACTA" || $divExotic[$wp][$d][0]=="EXACTOR")) {
                                        $uno=explode("/", $llegada[1]);
                                        $eje2LugarSimple[$wp]=$uno[0];
                                        if (isset($uno[1])) {
                                            $eje2LugarDoble[$wp]=$uno[1];
                                            if (isset($uno[2])) {
                                                $eje2LugarTriple[$wp]=$uno[2];
                                            }
                                        }
                                    }
                                    if (count($llegada)>=3 &&
                                    $divExotic[$wp][$d][0]=="TRIFECTA" || $divExotic[$wp][$d][0]=="TRIACTOR") {
                                        $uno=explode("/", $llegada[2]);
                                        $eje3LugarSimple[$wp]=$uno[0];
                                        if (isset($uno[1])) {
                                            $eje3LugarDoble[$wp]=$uno[1];
                                            if (isset($uno[2])) {
                                                $eje3LugarTriple[$wp]=$uno[2];
                                            }
                                        }
                                    }
                                    if (count($llegada)>=4 && $divExotic[$wp][$d][0]=="SUPERFECTA") {
                                        $uno=explode("/", $llegada[3]);
                                        $eje4LugarSimple[$wp]=$uno[0];
                                        if (isset($uno[1])) {
                                            $eje4LugarDoble[$wp]=$uno[1];
                                            if (isset($uno[2])) {
                                                $eje4LugarTriple[$wp]=$uno[2];
                                            }
                                        }
                                    }
                                }
                                $d++;
                            }
                        }
                        $c++;
                    }
                    $b++;
                }
                $a++;
            }
        }
        $y=1;
        foreach ($ejePriLugar as $x41) {
            if ($eje1LugarSimple[$y]==0) {
                if ($ejePriLugar[$y]!="") {
                    $eje1LugarSimple[$y]=$ejePriLugar[$y];
                }
            }
            if ($eje2LugarSimple[$y]==0) {
                if ($ejeSegLugar[$y]!="") {
                    $eje2LugarSimple[$y]=$ejeSegLugar[$y];
                }
            }
            if ($eje3LugarSimple[$y]==0) {
                if ($ejeTerLugar[$y]!="") {
                    $eje3LugarSimple[$y]=$ejeTerLugar[$y];
                }
            }
            if ($eje4LugarSimple[$y]==0) {
                if (isset($ejeCuaLugar[$y]) && $ejeCuaLugar[$y]!=0) {
                    $eje4LugarSimple[$y]=$ejeCuaLugar[$y];
                }
            }
            $y++;
        }
    } //fin existe
    return array($cAct,$eje1LugarSimple,$eje2LugarSimple,$eje3LugarSimple,$eje4LugarSimple,$DivWinPriLugar,$DivPlaPriLugar,$DivShoPriLugar,$DivPlaSegLugar,$DivShoSegLugar,$DivShoTerLugar,$eje1LugarDoble,$eje1LugarTriple,$eje2LugarDoble,$eje2LugarTriple,$eje3LugarDoble,$eje3LugarTriple,$eje4LugarTriple,$eje4LugarDoble,$divExotic);
}

function resultadoTrackInfo($url, $permite)
{
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
                $divExotic[$nCar][2][$ctaSu][1]=str_replace("/", "-", trim(strip_tags($df[2])));	 // llegada
                $divExotic[$nCar][2][$ctaSu][2]=str_replace("$", "", trim(strip_tags($df[4]))); // dividendo
                $divExotic[$nCar][2][$ctaSu][2]=str_replace(',', '', $divExotic[$nCar][2][$ctaSu][2]);
                $divExotic[$nCar][2][$ctaSu][3]=str_replace("$", "", trim(strip_tags($df[0])));	 // factor
                $llegada=explode("/", strip_tags($df[2]));
                $eje4LugarSimple[$nCar]=$llegada[3];
                $ctaSu++;
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

function download_page($path)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $path);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $retValue = curl_exec($ch);
    curl_close($ch);
    return $retValue;
}
//********************************************************************************************
class assoc_array2xml
{
    public $text;
    public $arrays;
 
    public $keys;
 
    public $node_flag;
 
    public $depth;
 
    public $xml_parser;
    public function array2xml($array)
    {
        $this->text="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?><array>";
        $this->text.= $this->array_transform($array);
        $this->text .="</array>";
        return $this->text;
    }
    public function array_transform($array)
    {
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                $this->text .= "<$key>$value</$key>";
            } else {
                $this->text.="<$key>";
                $this->array_transform($value);
                $this->text.="</$key>";
            }
        }
        return $array_text;
    }
    public function startElement($parser, $name, $attrs)
    {
        $this->keys[]=$name; //We add a key
        $this->node_flag=1;
        $this->depth++;
    }
    public function characterData($parser, $data)
    {
        $key=end($this->keys);
        $this->arrays[$this->depth][$key]=$data;
        $this->node_flag=0; //So that we don't add as an array, but as an element
    }
    public function endElement($parser, $name)
    {
        $key=array_pop($this->keys);
        if ($this->node_flag==1) {
            $this->arrays[$this->depth][$key]=$this->arrays[$this->depth+1];
            unset($this->arrays[$this->depth+1]);
        }
        $this->node_flag=1;
        $this->depth--;
    }
    public function xml2array2($contents, $get_attributes=1, $priority = 'tag')
    {
        if (!$contents) {
            return array();
        }
    
        if (!function_exists('xml_parser_create')) {
            return array();
        }
        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $xml_values);
        xml_parser_free($parser);
        if (!$xml_values) {
            return;
        }
        $xml_array = array();
        $parents = array();
        $opened_tags = array();
        $arr = array();
        $current = &$xml_array;
        $repeated_tag_index = array();
        foreach ($xml_values as $data) {
            unset($attributes,$value);
            extract($data);
            $result = array();
            $attributes_data = array();
            if (isset($value)) {
                if ($priority == 'tag') {
                    $result = $value;
                } else {
                    $result['value'] = $value;
                }
            }
            if (isset($attributes) and $get_attributes) {
                foreach ($attributes as $attr => $val) {
                    if ($priority == 'tag') {
                        $attributes_data[$attr] = $val;
                    } else {
                        $result['attr'][$attr] = $val;
                    }
                }
            }
            if ($type == "open") {
                $parent[$level-1] = &$current;
                if (!is_array($current) or (!in_array($tag, array_keys($current)))) {
                    $current[$tag] = $result;
                    if ($attributes_data) {
                        $current[$tag. '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    $current = &$current[$tag];
                } else {
                    if (isset($current[$tag][0])) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        $repeated_tag_index[$tag.'_'.$level]++;
                    } else {
                        $current[$tag] = array($current[$tag],$result);
                        $repeated_tag_index[$tag.'_'.$level] = 2;
                        if (isset($current[$tag.'_attr'])) {
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
                    }
                    $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                    $current = &$current[$tag][$last_item_index];
                }
            } elseif ($type == "complete") {
                if (!isset($current[$tag])) {
                    $current[$tag] = $result;
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if ($priority == 'tag' and $attributes_data) {
                        $current[$tag. '_attr'] = $attributes_data;
                    }
                } else {
                    if (isset($current[$tag][0]) and is_array($current[$tag])) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        if ($priority == 'tag' and $get_attributes and $attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                        $repeated_tag_index[$tag.'_'.$level]++;
                    } else {
                        $current[$tag] = array($current[$tag],$result);
                        $repeated_tag_index[$tag.'_'.$level] = 1;
                        if ($priority == 'tag' and $get_attributes) {
                            if (isset($current[$tag.'_attr'])) {
                                $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                                unset($current[$tag.'_attr']);
                            }
                            if ($attributes_data) {
                                $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                            }
                        }
                        $repeated_tag_index[$tag.'_'.$level]++;
                    }
                }
            } elseif ($type == 'close') {
                $current = &$parent[$level-1];
            }
        }
        return($xml_array);
    }
}
//********************************************************************************************
function resultadoTVG($url, $permite)
{
    set_time_limit(0);
    $existe=0;
    $cAct[0]="";
    $eje1LugarSimple[0]="";		//
    $eje1LugarDoble[0]="";		//
    $eje1LugarTriple[0]="";		//
    $eje2LugarSimple[0]="";		//
    $eje2LugarDoble[0]="";		//
    $eje2LugarTriple[0]="";		//
    $eje3LugarSimple[0]="";		//
    $eje3LugarDoble[0]="";		//
    $eje3LugarTriple[0]="";		//
    $eje4LugarSimple[0]="";
    $eje4LugarDoble[0]="";
    $eje4LugarTriple[0]="";
    $DivWinPriLugar[0]="";		//
    $DivWinPriLugarDoble[0]="";	//
    $DivWinPriLugarTriple[0]="";//
    $DivPlaPriLugar[0]="";		//
    $DivPlaPriLugarDoble[0]="";	//
    $DivPlaPriLugarTriple[0]="";//
    $DivShoPriLugar[0]="";		//
    $DivShoPriLugarDoble[0]="";	//
    $DivShoPriLugarTriple[0]="";//
    $DivPlaSegLugar[0]="";		//
    $DivPlaSegLugarDoble[0]="";	//
    $DivPlaSegLugarTriple[0]="";//
    $DivShoSegLugar[0]="";		//
    $DivShoSegLugarDoble[0]="";	//
    $DivShoSegLugarTriple[0]="";//
    $DivShoTerLugar[0]="";		//
    $DivShoTerLugarDoble[0]="";	//
    $DivShoTerLugarTriple[0]="";//
    $divExotic[0]="";
    $retirados[0]="";
    //$url="file:///C:/xampp/htdocs/hipico_actual/includes/Results9.xml";
    if (trim($url)!="" && trim($url)!="") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $converter= new assoc_array2xml;
        $datosXML=$converter->xml2array2($result);
        if (isset($datosXML["TrackResults"]["results"]["finisher"]["0_attr"]["position"]) or
            (isset($datosXML["TrackResults"]["results"]["exotic"][0]) &&
            strpos($datosXML["TrackResults"]["results"]["exotic"][0], "Refund"))
            ) {
            if (isset($datosXML["TrackResults"]["results_attr"]["race"])) {
                $cAct[0]=$datosXML["TrackResults"]["results_attr"]["race"];
                $cA=$cAct[0];
                $nCar=$datosXML["TrackResults"]["results_attr"]["race"]/1;
                if (isset($datosXML["TrackResults"]["results"]["scratches"])) {
                    $r1=$datosXML["TrackResults"]["results"]["scratches"];
                    $r2=explode(",", $r1);
                    $x=0;
                    foreach ($r2 as $y) {
                        $r3=explode("-", $y);
                        $retirados[$cA][$x]=$r3[0];
                        $x++;
                    }
                }
            }
            $ctaPst=0;
            $ctaSst=0;
            $ctaTst=0;
            $ctaCst=0;
            $ctaEx=0;
            $ctaTr=0;
            $ctaSu=0;
            for ($i = 0; $i <= 20; $i++) {
                $attr=$i."_attr";
                if (isset($datosXML["TrackResults"]["results"]["finisher"][$attr]["position"])) {
                    $existe=1;
                    if ($datosXML["TrackResults"]["results"]["finisher"][$attr]["position"]=="1st") {
                        $eje=explode("-", $datosXML["TrackResults"]["results"]["finisher"][$attr]["horse"]);
                        $uno=$datosXML["TrackResults"]["results"]["finisher"][$attr]["winamount"];
                        $dos=$datosXML["TrackResults"]["results"]["finisher"][$attr]["placeamount"];
                        $tre=$datosXML["TrackResults"]["results"]["finisher"][$attr]["showamount"];
                        if ($ctaPst==0) {
                            $eje1LugarSimple[$cA]=$eje[0];
                            $DivWinPriLugar[$cA]=str_replace("$", "", $uno)/1;
                            $DivPlaPriLugar[$cA]=str_replace("$", "", $dos)/1;
                            $DivShoPriLugar[$cA]=str_replace("$", "", $tre)/1;
                        }
                        if ($ctaPst==1) {
                            $eje1LugarDoble[$cA]=$eje[0];
                            $DivWinPriLugarDoble[$cA]=str_replace("$", "", $uno)/1;
                            $DivPlaPriLugarDoble[$cA]=str_replace("$", "", $dos)/1;
                            $DivShoPriLugarDoble[$cA]=str_replace("$", "", $tre)/1;
                            $eje2LugarSimple[$cA]=99;
                        }
                        if ($ctaPst==2) {
                            $eje1LugarTriple[$cA]=$eje[0];
                            $DivWinPriLugarTriple[$cA]=str_replace("$", "", $uno)/1;
                            $DivPlaPriLugarTriple[$cA]=str_replace("$", "", $dos)/1;
                            $DivShoPriLugarTriple[$cA]=str_replace("$", "", $tre)/1;
                            $eje3LugarSimple[$cA]=99;
                        }
                        $ctaPst++;
                    }
                    if ($datosXML["TrackResults"]["results"]["finisher"][$attr]["position"]=="2nd") {
                        $eje2=explode("-", $datosXML["TrackResults"]["results"]["finisher"][$attr]["horse"]);
                        $dos=$datosXML["TrackResults"]["results"]["finisher"][$attr]["placeamount"];
                        $tre=$datosXML["TrackResults"]["results"]["finisher"][$attr]["showamount"];
                        if ($ctaSst==0) {
                            $eje2LugarSimple[$cA]=$eje2[0];
                            $DivPlaSegLugar[$cA]=str_replace("$", "", $dos)/1;
                            $DivShoSegLugar[$cA]=str_replace("$", "", $tre)/1;
                            $eje3LugarSimple[$cA]=99;
                        }
                        if ($ctaSst==1) {
                            $eje2LugarDoble[$cA]=$eje2[0];
                            $DivPlaSegLugarDoble[$cA]=str_replace("$", "", $dos)/1;
                            $DivShoSegLugarDoble[$cA]=str_replace("$", "", $tre)/1;
                            $eje3LugarSimple[$cA]=99;
                        }
                        if ($ctaSst==2) {
                            $eje2LugarTriple[$cA]=$eje2[0];
                            $DivPlaSegLugarTriple[$cA]=str_replace("$", "", $dos)/1;
                            $DivShoSegLugarTriple[$cA]=str_replace("$", "", $tre)/1;
                            $eje3LugarSimple[$cA]=99;
                        }
                        $ctaSst++;
                    }
                    if ($datosXML["TrackResults"]["results"]["finisher"][$attr]["position"]=="3rd") {
                        $eje3=explode("-", $datosXML["TrackResults"]["results"]["finisher"][$attr]["horse"]);
                        $tre=$datosXML["TrackResults"]["results"]["finisher"][$attr]["showamount"];
                        if ($ctaTst==0) {
                            $eje3LugarSimple[$cA]=$eje3[0];
                            $DivShoTerLugar[$cA]=str_replace("$", "", $tre)/1;
                        }
                        if ($ctaTst==1) {
                            $eje3LugarDoble[$cA]=$eje3[0];
                            $DivShoTerLugarDoble[$cA]=str_replace("$", "", $tre)/1;
                        }
                        if ($ctaTst==2) {
                            $eje3LugarTriple[$cA]=$eje3[0];
                            $DivShoTerLugarTriple[$cA]=str_replace("$", "", $tre)/1;
                        }
                        $ctaTst++;
                    }
                    if ($datosXML["TrackResults"]["results"]["finisher"][$attr]["position"]=="4th") {
                        if ($ctaCst==0) {
                            $eje4=explode("-", $datosXML["TrackResults"]["results"]["finisher"][$attr]["horse"]);
                            $eje4LugarSimple[$cA]=$eje4[0];
                        }
                        $ctaCst++;
                    }
                }
                if (isset($datosXML["TrackResults"]["results"]["exotic"][$i])) {
                    if (strpos($datosXML["TrackResults"]["results"]["exotic"][$i], "EXACTA")!==false) {
                        $df=explode(" ", $datosXML["TrackResults"]["results"]["exotic"][$i]);
                        $divExotic[$nCar][0][$ctaEx][0]="EXACTA"; // tipo de exotica
                        if (str_replace("/", "-", trim(strip_tags($df[3])))!="Refund" &&
                          str_replace("/", "-", trim(strip_tags($df[3])))!="CarryOver") {
                            $divExotic[$nCar][0][$ctaEx][1]=str_replace("/", "-", trim(strip_tags($df[3])));	 // llegada
                            $divExotic[$nCar][0][$ctaEx][2]=0;
                            $divExotic[$nCar][0][$ctaEx][3]=0;
                            if (isset($df[4])) {
                                $divExotic[$nCar][0][$ctaEx][2]=str_replace("$", "", trim(strip_tags($df[4])))/1; // dividendo
                                $divExotic[$nCar][0][$ctaEx][3]=str_replace("$", "", trim(strip_tags($df[0])))/1; /// factor
                            }
                        } else {
                            $divExotic[$nCar][0][$ctaEx][1]=0;	 // llegada
                            $divExotic[$nCar][0][$ctaEx][2]=0; // dividendo
                            $divExotic[$nCar][0][$ctaEx][3]=0; /// factor
                        }
                        if (str_replace("/", "-", trim(strip_tags($df[3])))!="Refund") {
                            $ctaEx++;
                        }
                    }
                    if (strpos($datosXML["TrackResults"]["results"]["exotic"][$i], "TRIFECTA")!==false) {
                        $df=explode(" ", $datosXML["TrackResults"]["results"]["exotic"][$i]);
                        $divExotic[$nCar][1][$ctaTr][0]="TRIFECTA"; // tipo de exotica
                        if (str_replace("/", "-", trim(strip_tags($df[3])))!="Refund" &&
                          str_replace("/", "-", trim(strip_tags($df[3])))!="CarryOver") {
                            $divExotic[$nCar][1][$ctaTr][1]=str_replace("/", "-", trim(strip_tags($df[3])));	 // llegada
                            $divExotic[$nCar][1][$ctaTr][2]=0;
                            $divExotic[$nCar][1][$ctaTr][3]=0;
                            if (isset($df[4])) {
                                $divExotic[$nCar][1][$ctaTr][2]=str_replace("$", "", trim(strip_tags($df[4])))/1; // dividendo
                                $divExotic[$nCar][1][$ctaTr][3]=str_replace("$", "", trim(strip_tags($df[0])))/1; /// factor
                            }
                        } else {
                            $divExotic[$nCar][1][$ctaTr][1]=0;	 // llegada
                            $divExotic[$nCar][1][$ctaTr][2]=0; // dividendo
                            $divExotic[$nCar][1][$ctaTr][3]=0; /// factor
                        }
                        if (str_replace("/", "-", trim(strip_tags($df[3])))!="CarryOver") {
                            $ctaTr++;
                        }
                    }
                    if (strpos($datosXML["TrackResults"]["results"]["exotic"][$i], "SUPERFECTA")!==false) {
                        $df=explode(" ", $datosXML["TrackResults"]["results"]["exotic"][$i]);
                        $divExotic[$nCar][2][$ctaSu][0]="SUPERFECTA"; // tipo de exotica
                        if (str_replace("/", "-", trim(strip_tags($df[3])))!="Refund" &&
                          str_replace("/", "-", trim(strip_tags($df[3])))!="CarryOver") {
                            $divExotic[$nCar][2][$ctaSu][1]=str_replace("/", "-", trim(strip_tags($df[3])));	 // llegada
                            $divExotic[$nCar][2][$ctaSu][2]=0;
                            $divExotic[$nCar][2][$ctaSu][3]=0;
                            if (isset($df[4])) {
                                $divExotic[$nCar][2][$ctaSu][2]=str_replace("$", "", trim(strip_tags($df[4])))/1; // dividendo
                                $divExotic[$nCar][2][$ctaSu][3]=str_replace("$", "", trim(strip_tags($df[0])))/1; /// factor
                            }
                        } else {
                            $divExotic[$nCar][2][$ctaSu][1]=0;	 // llegada
                            $divExotic[$nCar][2][$ctaSu][2]=0; // dividendo
                            $divExotic[$nCar][2][$ctaSu][3]=0; /// factor
                        }
                        if (str_replace("/", "-", trim(strip_tags($df[3])))!="CarryOver") {
                            $ctaSu++;
                        }
                    }
                }
            }

            
            if ((isset($nCar) && $ctaEx==0 && $ctaCst==0 && $ctaTst==0 && $ctaSst==0 && $ctaPst==0 && $divExotic[$nCar][2][$ctaSu-1][1]==0 &&
$divExotic[$nCar][1][$ctaTr-1][1]==0)
                            ) {
                $eje1LugarSimple[$nCar]=99;		//
                $eje1LugarDoble[$nCar]="";		//
                $eje1LugarTriple[$nCar]="";		//
                $eje2LugarSimple[$nCar]=99;		//
                $eje2LugarDoble[$nCar]="";		//
                $eje2LugarTriple[$nCar]="";		//
                $eje3LugarSimple[$nCar]=99;		//
                $eje3LugarDoble[$nCar]="";		//
                $eje3LugarTriple[$nCar]="";		//
                $eje4LugarSimple[$nCar]=99;
                $eje4LugarDoble[$nCar]="";
                $eje4LugarTriple[$nCar]="";
                $DivWinPriLugar[$nCar]="0";		//
                $DivWinPriLugarDoble[$nCar]="";	//
                $DivWinPriLugarTriple[$nCar]="";//
                $DivPlaPriLugar[$nCar]="0";		//
                $DivPlaPriLugarDoble[$nCar]="";	//
                $DivPlaPriLugarTriple[$nCar]="";//
                $DivShoPriLugar[$nCar]="0";		//
                $DivShoPriLugarDoble[$nCar]="";	//
                $DivShoPriLugarTriple[$nCar]="";//
                $DivPlaSegLugar[$nCar]="0";		//
                $DivPlaSegLugarDoble[$nCar]="";	//
                $DivPlaSegLugarTriple[$nCar]="";//
                $DivShoSegLugar[$nCar]="0";		//
                $DivShoSegLugarDoble[$nCar]="";	//
                $DivShoSegLugarTriple[$nCar]="";//
                $DivShoTerLugar[$nCar]="0";		//
                $DivShoTerLugarDoble[$nCar]="";	//
                $DivShoTerLugarTriple[$nCar]="";//
                $divExotic[$nCar][0][0][0]="EXACTA"; // tipo de exotica
                $divExotic[$nCar][0][0][1]="0-0";	 // llegada
                $divExotic[$nCar][0][0][2]=0; // dividendo
                $divExotic[$nCar][0][0][3]=0; /// factor
                $divExotic[$nCar][1][0][0]="TRIFECTA"; // tipo de exotica
                $divExotic[$nCar][1][0][1]="0-0-0";	 // llegada
                $divExotic[$nCar][1][0][2]=0; // dividendo
                $divExotic[$nCar][1][0][3]=0; /// factor
                $divExotic[$nCar][2][0][0]="SUPERFECTA"; // tipo de exotica
                $divExotic[$nCar][2][0][1]="0-0-0-0";	 // llegada
                $divExotic[$nCar][2][0][2]=floatval(0); // dividendo
                $divExotic[$nCar][2][0][3]=0; /// factor
            }
        }//////
    }
    return array($cAct,$eje1LugarSimple,$eje1LugarDoble,$eje1LugarTriple,$eje2LugarSimple,$eje2LugarDoble,$eje2LugarTriple,$eje3LugarSimple,$eje3LugarDoble,$eje3LugarTriple,$eje4LugarSimple,$eje4LugarDoble,$eje4LugarTriple,$DivWinPriLugar,$DivWinPriLugarDoble,$DivWinPriLugarTriple,$DivPlaPriLugar,$DivPlaPriLugarDoble,$DivPlaPriLugarTriple,$DivShoPriLugar,$DivShoPriLugarDoble,$DivShoPriLugarTriple,$DivPlaSegLugar,$DivPlaSegLugarDoble,$DivPlaSegLugarTriple,$DivShoSegLugar,$DivShoSegLugarDoble,$DivShoSegLugarTriple,$DivShoTerLugar,$DivShoTerLugarDoble,$DivShoTerLugarTriple,$divExotic,$existe);

    //--------------------------------------------------------***************
}

function resultadoCarrerasBuild($idH, $idC, $hoy, $numC)
{
    $url='http://bab2ghc.usofftrack.com/data/ProgramDetail.json?sdt='.$hoy.'&aid=&pid='.$idH.'&rid='.$idC.'&init=true';
    echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $fulldatos = curl_exec($ch);
    curl_close($ch);
    $fulldatos = json_decode($fulldatos, true);
    $g=0;
    $cAct=array();
    $eje1LugarSimple[$numC]="";		//
    $eje1LugarDoble[$numC]="";		//
    $eje1LugarTriple[$numC]="";		//
    $eje2LugarSimple[$numC]="";		//
    $eje2LugarDoble[$numC]="";		//
    $eje2LugarTriple[$numC]="";		//
    $eje3LugarSimple[$numC]="";		//
    $eje3LugarDoble[$numC]="";		//
    $eje3LugarTriple[$numC]="";		//
    $eje4LugarSimple[$numC]="";
    $eje4LugarDoble[$numC]="";
    $eje4LugarTriple[$numC]="";
    $DivWinPriLugar[$numC]="";		//
    $DivWinPriLugarDoble[$numC]="";	//
    $DivWinPriLugarTriple[$numC]="";//
    $DivPlaPriLugar[$numC]="";		//
    $DivPlaPriLugarDoble[$numC]="";	//
    $DivPlaPriLugarTriple[$numC]="";//
    $DivShoPriLugar[$numC]="";		//
    $DivShoPriLugarDoble[$numC]="";	//
    $DivShoPriLugarTriple[$numC]="";//
    $DivPlaSegLugar[$numC]="";		//
    $DivPlaSegLugarDoble[$numC]="";	//
    $DivPlaSegLugarTriple[$numC]="";//
    $DivShoSegLugar[$numC]="";		//
    $DivShoSegLugarDoble[$numC]="";	//
    $DivShoSegLugarTriple[$numC]="";//
    $DivShoTerLugar[$numC]="";		//
    $DivShoTerLugarDoble[$numC]="";	//
    $DivShoTerLugarTriple[$numC]="";//
    $divExotic[$numC]="";
    $existe=1;
    if (isset($fulldatos["Result"]) && $fulldatos["Result"]["races"][$numC-1]["RaceResult"]!="") {
        $cAct[0]=$fulldatos["Result"]["raceinfo"]["RaceNumber"];
        $nCar=$cAct[0];
        $cwin=0;
        $cpla=0;
        $csho=0;
        $cuar=0;
        $acceso=0;
        foreach ($fulldatos["Result"]["powps"] as $da) {
            if ($fulldatos["Result"]["powps"][$g]["RaceKey"]==$idC) {
                $acceso=1;
                if ($fulldatos["Result"]["powps"][$g]["OrderOfFinish"]==1) {
                    if ($cwin==0) {
                        $eje1LugarSimple[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                        $DivWinPriLugar[$nCar]=$fulldatos["Result"]["powps"][$g]["Win"]*1;
                        $DivPlaPriLugar[$nCar]=$fulldatos["Result"]["powps"][$g]["Place"]*1;
                        $DivShoPriLugar[$nCar]=$fulldatos["Result"]["powps"][$g]["Show"]*1;
                    }
                    if ($cwin==1) {
                        $eje1LugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
    
                        $DivWinPriLugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["Win"]*1;
                        $DivPlaPriLugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["Place"]*1;
                        $DivShoPriLugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["Show"]*1;
                    }
                    if ($cwin==2) {
                        $eje1LugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                        $DivWinPriLugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["Win"]*1;
                        $DivPlaPriLugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["Place"]*1;
                        $DivShoPriLugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["Show"]*1;
                    }
                    $cwin++;
                }
                if ($fulldatos["Result"]["powps"][$g]["OrderOfFinish"]==2) {
                    if ($cpla==0) {
                        $eje2LugarSimple[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                        $DivPlaSegLugar[$nCar]=$fulldatos["Result"]["powps"][$g]["Place"]*1;
                        $DivShoSegLugar[$nCar]=$fulldatos["Result"]["powps"][$g]["Show"]*1;
                    }
                    if ($cpla==1) {
                        $eje2LugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                        $DivPlaSegLugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["Place"]*1;
                        $DivShoSegLugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["Show"]*1;
                    }
                    if ($cpla==2) {
                        $eje2LugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                        $DivPlaSegLugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["Place"]*1;
                        $DivShoSegLugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["Show"]*1;
                    }
                    $cpla++;
                }
                if ($fulldatos["Result"]["powps"][$g]["OrderOfFinish"]==3) {
                    if ($csho==0) {
                        $eje3LugarSimple[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                        $DivShoTerLugar[$nCar]=$fulldatos["Result"]["powps"][$g]["Show"]*1;
                    }
                    if ($csho==1) {
                        $eje3LugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                        $DivShoTerLugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["Show"]*1;
                    }
                    if ($csho==2) {
                        $eje3LugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                        $DivShoTerLugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["Show"]*1;
                    }
                    $csho++;
                }
                if ($fulldatos["Result"]["powps"][$g]["OrderOfFinish"]==104) {
                    if ($cuar==0) {
                        $eje4LugarSimple[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                    }
                    if ($cuar==1) {
                        $eje4LugarDoble[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                    }
                    if ($cuar==2) {
                        $eje4LugarTriple[$nCar]=$fulldatos["Result"]["powps"][$g]["EntryNumber"];
                    }
                    $cuar++;
                }
                $g++;
            }
        }
        $g=0;
        $ctaEx=0;
        $ctaTr=0;
        $ctaSu=0;
        if ($acceso==1) {
            foreach ($fulldatos["Result"]["poexotics"] as $da) {
                if (($fulldatos["Result"]["poexotics"][$g]["BetTypeCode"]=="PER" &&
                    $fulldatos["Result"]["poexotics"][$g]["RunnerList"]!="Box") ||
                    ($fulldatos["Result"]["poexotics"][$g]["BetTypeCode"]=="EXA" &&
                    $fulldatos["Result"]["poexotics"][$g]["RunnerList"]!="Box")) {
                    $aE=1;
                    if ($ctaEx>0) {
                        if ($fulldatos["Result"]["poexotics"][$g]["RunnerList"]==$divExotic[$nCar][0][$ctaEx-1][1]) {
                            $aE=0;
                        }
                    }
                    if ($aE==1) {
                        $divExotic[$nCar][0][$ctaEx][0]="EXACTA"; // tipo de exotica
                        $divExotic[$nCar][0][$ctaEx][1]=$fulldatos["Result"]["poexotics"][$g]["RunnerList"];//llegada
                        $divExotic[$nCar][0][$ctaEx][2]=$fulldatos["Result"]["poexotics"][$g]["PayoutAmount"];//dividendo
                        $divExotic[$nCar][0][$ctaEx][3]=$fulldatos["Result"]["poexotics"][$g]["BetAmount"];//factor
                        $ctaEx++;
                    }
                }
                if (($fulldatos["Result"]["poexotics"][$g]["BetTypeCode"]=="TRI" &&
                    $fulldatos["Result"]["poexotics"][$g]["RunnerList"]!="Box") ||
                    ($fulldatos["Result"]["poexotics"][$g]["BetTypeCode"]=="TT1" &&
                    $fulldatos["Result"]["poexotics"][$g]["RunnerList"]!="Box") ||
                    ($fulldatos["Result"]["poexotics"][$g]["BetTypeCode"]=="TS1" &&
                    $fulldatos["Result"]["poexotics"][$g]["RunnerList"]!="Box")) {
                    $aT=1;
                    if ($ctaTr>0) {
                        if ($fulldatos["Result"]["poexotics"][$g]["RunnerList"]==$divExotic[$nCar][1][$ctaTr-1][1]) {
                            $aT=0;
                        }
                    }
                    if ($aT==1) {
                        $divExotic[$nCar][1][$ctaTr][0]="TRIFECTA"; // tipo de exotica
                        $divExotic[$nCar][1][$ctaTr][1]=$fulldatos["Result"]["poexotics"][$g]["RunnerList"];//llegada
                        $divExotic[$nCar][1][$ctaTr][2]=$fulldatos["Result"]["poexotics"][$g]["PayoutAmount"];//dividendo
                        $divExotic[$nCar][1][$ctaTr][3]=$fulldatos["Result"]["poexotics"][$g]["BetAmount"];//factor
                        $ctaTr++;
                    }
                }
                if ($fulldatos["Result"]["poexotics"][$g]["BetTypeCode"]=="SUP" &&
                    $fulldatos["Result"]["poexotics"][$g]["RunnerList"]!="Box") {
                    $aS=1;
                    if ($ctaSu>0) {
                        if ($fulldatos["Result"]["poexotics"][$g]["RunnerList"]==$divExotic[$nCar][2][$ctaSu-1][1]) {
                            $aS=0;
                        }
                    }
                    if ($aS==1) {
                        $divExotic[$nCar][2][$ctaSu][0]="SUPERFECTA"; // tipo de exotica
                        $divExotic[$nCar][2][$ctaSu][1]=$fulldatos["Result"]["poexotics"][$g]["RunnerList"];//llegada
                        $divExotic[$nCar][2][$ctaSu][2]=$fulldatos["Result"]["poexotics"][$g]["PayoutAmount"];//dividendo
                        $divExotic[$nCar][2][$ctaSu][3]=$fulldatos["Result"]["poexotics"][$g]["BetAmount"];//factor
                        $ctaSu++;
                    }
                }
                $g++;
            }
        }
    }
    return array($cAct,$eje1LugarSimple,$eje1LugarDoble,$eje1LugarTriple,$eje2LugarSimple,$eje2LugarDoble,$eje2LugarTriple,$eje3LugarSimple,$eje3LugarDoble,$eje3LugarTriple,$eje4LugarSimple,$eje4LugarDoble,$eje4LugarTriple,$DivWinPriLugar,$DivWinPriLugarDoble,$DivWinPriLugarTriple,$DivPlaPriLugar,$DivPlaPriLugarDoble,$DivPlaPriLugarTriple,$DivShoPriLugar,$DivShoPriLugarDoble,$DivShoPriLugarTriple,$DivPlaSegLugar,$DivPlaSegLugarDoble,$DivPlaSegLugarTriple,$DivShoSegLugar,$DivShoSegLugarDoble,$DivShoSegLugarTriple,$DivShoTerLugar,$DivShoTerLugarDoble,$DivShoTerLugarTriple,$divExotic,$existe);
}
function dividendosNacionales($dia)
{
    //$dia="LUNES";
    $url = 'http://www.maquinaazul.com.ve/dividendosact.php?dia='.$dia;
    $existe=1;
    $ejePrim[0]=0;
    $ejeSegu[0]=0;
    $ejeTerc[0]=0;
    $ejeCuar[0]=0;
    if ($existe==1) {
        $c=0;
        include_once('simple_html_dom.php');
        $html = file_get_html($url);
        foreach ($html->find('table') as $article) {
            foreach ($article->find("text") as $article2) {
                if (trim($article2)!="") {
                    $resultado0 = strpos($article2, "Hip");
                    if ($resultado0 !== false) {
                        $c=0;
                    }
                    $datos[$c]=trim($article2);
                    $datos2[$c]=trim($article2);
                    $c++;
                }
            }
        }
        $c=0;
        $d=0;
        $f=0;
        $e=0;
        $ctaG=0;
        $ctaE=0;
        $ctaT=0;
        $ctaS=0;
        $ctaP=0;
        $acceso=0;
        $divExotic[0][0][0][0]=-1;
        $dx=explode(" ", $datos[2]);
        $cantCarreras=$dx[3]/1;
        $j=0;
        $control=0;
        foreach ($datos as $pr) {
            $resultado0 = strpos($pr, "N GANADORA");
            if ($resultado0 !== false) {
                $pr="";
            }
            $resultado1 = strpos($pr, "Carrera");
            $resultado2 = strpos($pr, "GANADOR");
            $resultado3 = strpos($pr, "EXACTA");
            $resultado4 = strpos($pr, "TRIFECTA");
            $resultado5 = strpos($pr, "SUPERFECTA");
            $resultado6 = strpos($pr, "PLACE");
            if ($resultado1 !== false) {
                $nCar=$datos[$c+1];
                $nCar = str_replace(":", "", $nCar);
                $nCar = $nCar/1;
                $ctaG=0;
                $ctaE=0;
                $ctaT=0;
                $ctaS=0;
                $ctaP=0;
            }
            if ($resultado2 !== false) {
                $datos[$c+3] = trim(str_replace(".", "", $datos[$c+3]));
                $datos[$c+3] = trim(str_replace(",", ".", $datos[$c+3]));
                
                $divExotic[$nCar][0][$ctaG][0]="1"; 	// tipo de exotica
                $divExotic[$nCar][0][$ctaG][1]=$datos[$c+1]/1; 	// llegada
                $divExotic[$nCar][0][$ctaG][2]=$datos[$c+3]; 	// dividendo
                if ($ctaG==0) {
                    $divExotic[$nCar][1][$ctaP][1]=$divExotic[$nCar][0][$ctaG][1];
                }
                //echo $nCar."/".$ctaG." => ".$divExotic[$nCar][0][$ctaG][1]." - ".$divExotic[$nCar][0][$ctaG][2]."<br>";
                //echo "divExotic[".$nCar."][0][".$ctaG."]["."<br>";
                $ctaG++;
            }
            if ($resultado6 !== false) {
                if (isset($divExotic[$nCar][1][$ctaP][1])) {
                    if ($divExotic[$nCar][1][$ctaP][1]!=($datos[$c+1]/1)) {
                        $datos[$c+3] = trim(str_replace(".", "", $datos[$c+3]));
                        $datos[$c+3] = trim(str_replace(",", ".", $datos[$c+3]));
                        $divExotic[$nCar][1][$ctaP][0]="2"; 	// tipo de exotica
                        $divExotic[$nCar][1][$ctaP][1]=$datos[$c+1]/1; 	// llegada
                        $divExotic[$nCar][1][$ctaP][2]=$datos[$c+3]; 	// dividendo
                        //echo $nCar." => ".$divExotic[$nCar][1][$ctaP][1]. " - ".$divExotic[$nCar][1][$ctaP][2]."<br>";
                        $ctaP++;
                    } else {
                        $ctaP++;
                        $datos[$c+3] = trim(str_replace(".", "", $datos[$c+3]));
                        $datos[$c+3] = trim(str_replace(",", ".", $datos[$c+3]));
                        $divExotic[$nCar][1][$ctaP][0]="2"; 	// tipo de exotica
                        $divExotic[$nCar][1][$ctaP][1]=$datos[$c+1]/1; 	// llegada
                        $divExotic[$nCar][1][$ctaP][2]=$datos[$c+3]; 	// dividendo
                        //echo $nCar." => ".$divExotic[$nCar][1][$ctaP][1]. " - ".$divExotic[$nCar][1][$ctaP][2]."<br>";
                        $ctaP--;
                    }
                } else {
                    $datos[$c+3] = trim(str_replace(".", "", $datos[$c+3]));
                    $datos[$c+3] = trim(str_replace(",", ".", $datos[$c+3]));
                    $divExotic[$nCar][1][$ctaP][0]="2"; 	// tipo de exotica
                    $divExotic[$nCar][1][$ctaP][1]=$datos[$c+1]/1; 	// llegada
                    $divExotic[$nCar][1][$ctaP][2]=$datos[$c+3]; 	// dividendo
                    //echo $nCar." => ".$divExotic[$nCar][1][$ctaP][1]. " - ".$divExotic[$nCar][1][$ctaP][2]."<br>";
                    $ctaP++;
                }
            }
            if ($resultado3 !== false) {		//exacta
                if ($datos[$c+3]!="NO HUBO") {
                    $datos[$c+3] = trim(str_replace(".", "", $datos[$c+3]));
                    $datos[$c+3] = trim(str_replace(",", ".", $datos[$c+3]));
                    $divExotic[$nCar][2][$ctaE][0]="4"; 	// tipo de exotica
                    $lleg1=explode("-", $datos[$c+1]);			// llegada
                    $divExotic[$nCar][2][$ctaE][1]=($lleg1[0]/1)."-".($lleg1[1]/1); 	// llegada
                    $divExotic[$nCar][2][$ctaE][2]=$datos[$c+3]; 	// dividendo
                    $ctaE++;
                }
            }
            if ($resultado4 !== false) {		// trifecta
                if ($datos[$c+3]!="NO HUBO") {
                    $datos[$c+3] = trim(str_replace(".", "", $datos[$c+3]));
                    $datos[$c+3] = trim(str_replace(",", ".", $datos[$c+3]));
                    $divExotic[$nCar][3][$ctaT][0]="5"; 	// tipo de exotica
                    $lleg2=explode("-", $datos[$c+1]);			// llegada
                    $divExotic[$nCar][3][$ctaT][1]=($lleg2[0]/1)."-".($lleg2[1]/1)."-".($lleg2[2]/1); 	// llegada
                    $divExotic[$nCar][3][$ctaT][2]=$datos[$c+3]; 	// dividendo
                    $ctaT++;
                }
            }
            if ($resultado5 !== false) {		// superfeta
                if ($datos[$c+3]!="NO HUBO") {
                    $datos[$c+3] = trim(str_replace(".", "", $datos[$c+3]));
                    $datos[$c+3] = trim(str_replace(",", ".", $datos[$c+3]));
                    $divExotic[$nCar][4][$ctaS][0]="6"; 	// tipo de exotica
                    $lleg3=explode("-", $datos[$c+1]);
                    $divExotic[$nCar][4][$ctaS][1]=($lleg3[0]/1)."-".($lleg3[1]/1)."-".($lleg3[2]/1)."-".($lleg3[3]/1); // llegada
                $divExotic[$nCar][4][$ctaS][2]=$datos[$c+3]; 	// dividendo
                $ctaS++;
                }
            }
            $c++;
            if ($control==1 && $nCar!=$cantCarreras) {
                break;
            }
            if (isset($nCar)) {
                if ($nCar==$cantCarreras) {
                    $control=1;
                }
            }
        }
    }
    /*
    echo "<pre>";
    print_r($divExotic);
    echo "</pre>";
    */
    return array($divExotic, $cantCarreras);
}
function ganSimpleHNAC($nomDia)
{
    $url = 'http://www.maquinaazul.com.ve/resultadosact.php?dia='.$nomDia;
    $existe=url_exists($url);
    $ganadores[0][0]=0;
    $ejemRetiro[0][0]=0;
    if ($existe==1) {
        $c=0;
        include_once('simple_html_dom.php');
        $html = file_get_html($url);
        foreach ($html->find('table') as $article) {
            foreach ($article->find("text") as $article2) {
                if (trim($article2)!="") {
                    $resultado0 = strpos($article2, "Hip");
                    if ($resultado0 !== false) {
                        $c=0;
                    }
                    $datos[$c]=trim($article2);
                    $c++;
                }
            }
        }
        $c=0;
        $d=0;
        $f=0;
        $e=0;
        $acceso=0;
        $dx=explode(" ", $datos[2]);
        $cantCarreras=$dx[3];
        foreach ($datos as $pr) {
            $resultado1 = strpos($pr, "Carrera");
            $resultado3 = strpos($pr, "JINETE");
            if ($resultado1 !== false) {
                $d++;
                $f=0;
                $e=0;
                $acceso=0;
            }
            if ($resultado3 !== false && $acceso==0) {
                $acceso=1;
                $e=0;
            }
            if ($acceso==1) {
                if (($e % 4) == 0) {
                    if ($datos[$c+2]) {
                        $datos[$c+2] = trim(str_replace(".", "", $datos[$c+2]));
                        $datos[$c+2] = trim(str_replace(",", ".", $datos[$c+2]));
                        
                        
                        
                        $ganadores[$d][$f]=$datos[$c+2];
                        $f++;
                    }
                }
                $e++;
            }
            
            if ($acceso==0) {
                $e=0;
                $f=0;
            }
            $c++;
            if ($d>$cantCarreras) {
                break;
            }
        }
    }
    return $ganadores;
}
function retiradosNacionales($nomDia)
{
    $url = 'http://www.maquinaazul.com.ve/retiradosact.php?dia='.$nomDia;
    
    $existe=url_exists($url);
    $ejemRetiro[0][0]=0;
    if ($existe==1) {
        $c=0;
        include_once('simple_html_dom.php');
        $html = file_get_html($url);
        foreach ($html->find('table') as $article) {
            foreach ($article->find("text") as $article2) {
                if (trim($article2)!="") {
                    $resultado0 = strpos($article2, "Hip");
                    if ($resultado0 !== false) {
                        $c=0;
                    }
                    $datos[$c]=trim($article2);
                    $c++;
                }
            }
        }
        $c=0;
        $d=0;
        $f=0;
        $e=0;
        $acceso=0;
        $dx=explode(" ", $datos[2]);
        $cantCarreras=$dx[3];
        foreach ($datos as $pr) {
            $resultado1 = strpos($pr, "Carrera");
            $resultado3 = strpos($pr, "JINETE");
            if ($resultado1 !== false) {
                $d++;
                $f=0;
                $e=0;
                $acceso=0;
            }
            if ($resultado3 !== false && $acceso==0) {
                $acceso=1;
                $e=0;
            }
            if ($acceso==1) {
                if (($e % 3) == 0) {
                    if (is_numeric($datos[$c+1])) {
                        $ejemRetiro[$d][$f]=$datos[$c+1];
                        //echo $d." - ".$f." /".$ejemRetiro[$d][$f]."<br/>";
                        $f++;
                    }
                }
                $e++;
            }
            
            if ($acceso==0) {
                $e=0;
                $f=0;
            }
            $c++;
            if ($d>$cantCarreras) {
                break;
            }
        }
    }
    //print_r($ejemRetiro);
    return $ejemRetiro;
}
function twinspiresResults($car, $fec, $tip, $BrisCode)
{
    if ($tip==0) {
        $tipoHip="THOROUGHBRED";
    } elseif ($tip==1) {
        $tipoHip="HARNESS";
    } elseif ($tip==2) {
        $tipoHip="";
    }
    $fecUrl=str_replace("-", "", $fec);
    $url="http://www.twinspires.com/php/fw/php_BRIS_BatchAPI/2.3/Tote/Results?ip=71.212.122.168&affid=2800&debug=off&cDate=".$fecUrl."&password=Gltbatm&track=".$BrisCode."&output=json&username=my_sports&race=".$car."&type=".$tipoHip;
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $eje1LugarSimple[$car]="";    //
  $eje1LugarDoble[$car]="";    //
  $eje1LugarTriple[$car]="";    //
  $eje2LugarSimple[$car]="";    //
  $eje2LugarDoble[$car]="";    //
  $eje2LugarTriple[$car]="";    //
  $eje3LugarSimple[$car]="";    //
  $eje3LugarDoble[$car]="";    //
  $eje3LugarTriple[$car]="";    //
  $eje4LugarSimple[$car]="";
    $eje4LugarDoble[$car]="";
    $eje4LugarTriple[$car]="";
    $DivWinPriLugar[$car]="";    //
  $DivWinPriLugarDoble[$car]="";  //
  $DivWinPriLugarTriple[$car]="";//
  $DivPlaPriLugar[$car]="";    //
  $DivPlaPriLugarDoble[$car]="";  //
  $DivPlaPriLugarTriple[$car]="";//
  $DivShoPriLugar[$car]="";    //
  $DivShoPriLugarDoble[$car]="";  //
  $DivShoPriLugarTriple[$car]="";//
  $DivPlaSegLugar[$car]="";    //
  $DivPlaSegLugarDoble[$car]="";  //
  $DivPlaSegLugarTriple[$car]="";//
  $DivShoSegLugar[$car]="";    //
  $DivShoSegLugarDoble[$car]="";  //
  $DivShoSegLugarTriple[$car]="";//
  $DivShoTerLugar[$car]="";    //
  $DivShoTerLugarDoble[$car]="";  //
  $DivShoTerLugarTriple[$car]="";//
  $divExotic[$car]="";
    $cAct[0]="";
    $x=0;
    $i=0;
    $cwin=0;
    $cpla=0;
    $csho=0;
    $cuar=0;
    if (isset($fulldatos["Results"]["WPS"]["Entries"])) {
        $cAct[0]=$fulldatos["Results"]["WPS"]["RaceNum"];
        $nCar=$cAct[0];
        foreach ($fulldatos["Results"]["WPS"]["Entries"] as $Entries) {
            $ejemplar=$Entries["ProgramNumber"];
            foreach ($Entries["Pools"] as $Pools) {
                if ($Pools["PoolType"]=="WN") {
                    if ($cwin==0) {
                        $eje1LugarSimple[$nCar]=$ejemplar;
                        $DivWinPriLugar[$nCar]=$Pools["Value"]*1;
                        $DivPlaPriLugar[$nCar]=$fulldatos["Results"]["WPS"]["Entries"][$i]["Pools"]["1"]["Value"]*1;
                        $DivShoPriLugar[$nCar]=$fulldatos["Results"]["WPS"]["Entries"][$i]["Pools"]["2"]["Value"]*1;
                        $cwin++;
                        break;
                    }
                    if ($cwin==1) {
                        $eje1LugarDoble[$nCar]=$ejemplar;
                        $DivWinPriLugarDoble[$nCar]=$Pools["Value"]*1;
                        $DivPlaPriLugarDoble[$nCar]=$fulldatos["Results"]["WPS"]["Entries"][$i]["Pools"]["1"]["Value"]*1;
                        $DivShoPriLugarDoble[$nCar]=$fulldatos["Results"]["WPS"]["Entries"][$i]["Pools"]["2"]["Value"]*1;
                        $cwin++;
                        break;
                    }
                    if ($cwin==2) {
                        $eje1LugarTriple[$nCar]=$ejemplar;
                        $DivWinPriLugarTriple[$nCar]=$Pools["Value"]*1;
                        $DivPlaPriLugarTriple[$nCar]=$fulldatos["Results"]["WPS"]["Entries"][$i]["Pools"]["1"]["Value"]*1;
                        $DivShoPriLugarTriple[$nCar]=$fulldatos["Results"]["WPS"]["Entries"][$i]["Pools"]["2"]["Value"]*1;
                        $cwin++;
                        break;
                    }
                }
                if ($Pools["PoolType"]=="PL") {
                    if ($cpla==0) {
                        $eje2LugarSimple[$nCar]=$ejemplar;
                        $DivPlaSegLugar[$nCar]=$Pools["Value"]*1;
                        $DivShoSegLugar[$nCar]=$fulldatos["Results"]["WPS"]["Entries"][$i]["Pools"]["1"]["Value"]*1;
                        $cpla++;
                        break;
                    }
                    if ($cpla==1) {
                        $eje2LugarDoble[$nCar]=$ejemplar;
                        $DivPlaSegLugarDoble[$nCar]=$Pools["Value"]*1;
                        $DivShoSegLugarDoble[$nCar]=$fulldatos["Results"]["WPS"]["Entries"][$i]["Pools"]["1"]["Value"]*1;
                        $cpla++;
                        break;
                    }
                    if ($cpla==2) {
                        $eje2LugarTriple[$nCar]=$ejemplar;
                        $DivPlaSegLugarTriple[$nCar]=$Pools["Value"]*1;
                        $DivShoSegLugarTriple[$nCar]=$fulldatos["Results"]["WPS"]["Entries"][$i]["Pools"]["1"]["Value"]*1;
                        $cpla++;
                        break;
                    }
                }
                if ($Pools["PoolType"]=="SH") {
                    if ($csho==0) {
                        $eje3LugarSimple[$nCar]=$ejemplar;
                        $DivShoTerLugar[$nCar]=$Pools["Value"]*1;
                        $csho++;
                        break;
                    }
                    if ($csho==1) {
                        $eje3LugarDoble[$nCar]=$ejemplar;
                        $DivShoTerLugarDoble[$nCar]=$Pools["Value"]*1;
                        $csho++;
                        break;
                    }
                    if ($csho==2) {
                        $eje3LugarTriple[$nCar]=$ejemplar;
                        $DivShoTerLugarTriple[$nCar]=$Pools["Value"]*1;
                        $csho++;
                        break;
                    }
                }
            }
      
            $i++;
        }
        $ctaEx=0;
        $ctaTr=0;
        $ctaSu=0;
        foreach ($fulldatos["Results"]["Exotics"]["Pools"] as $Pools) {
            if ($Pools["Type"]=="EX") {
                $divExotic[$nCar][0][$ctaEx][0]="EXACTA"; // tipo de exotica
        $divExotic[$nCar][0][$ctaEx][1]=$Pools["Result"];//llegada
        $divExotic[$nCar][0][$ctaEx][2]=$Pools["Value"];//dividendo
        $divExotic[$nCar][0][$ctaEx][3]=$Pools["Base"];//factor
        $ctaEx++;
            }
            if ($Pools["Type"]=="TR") {
                $divExotic[$nCar][1][$ctaTr][0]="TRIFECTA"; // tipo de exotica
        $divExotic[$nCar][1][$ctaTr][1]=$Pools["Result"];//llegada
        $divExotic[$nCar][1][$ctaTr][2]=$Pools["Value"];//dividendo
        $divExotic[$nCar][1][$ctaTr][3]=$Pools["Base"];//factor
        $ctaTr++;
            }
            if ($Pools["Type"]=="QD") {
                $divExotic[$nCar][2][$ctaSu][0]="SUPERFECTA"; // tipo de exotica
        $divExotic[$nCar][2][$ctaSu][1]=$Pools["Result"];//llegada
        $divExotic[$nCar][2][$ctaSu][2]=$Pools["Value"];//dividendo
        $divExotic[$nCar][2][$ctaSu][3]=$Pools["Base"];//factor
        $ctaSu++;
            }
            if ($eje1LugarSimple[$nCar]=="0") {
                $eje1LugarSimple[$nCar]=99;		//
                $eje1LugarDoble[$nCar]="";		//
                $eje1LugarTriple[$nCar]="";		//
                $eje2LugarSimple[$nCar]=99;		//
                $eje2LugarDoble[$nCar]="";		//
                $eje2LugarTriple[$nCar]="";		//
                $eje3LugarSimple[$nCar]=99;		//
                $eje3LugarDoble[$nCar]="";		//
                $eje3LugarTriple[$nCar]="";		//
                $eje4LugarSimple[$nCar]=99;
                $eje4LugarDoble[$nCar]="";
                $eje4LugarTriple[$nCar]="";
                $DivWinPriLugar[$nCar]="0";		//
                $DivWinPriLugarDoble[$nCar]="";	//
                $DivWinPriLugarTriple[$nCar]="";//
                $DivPlaPriLugar[$nCar]="0";		//
                $DivPlaPriLugarDoble[$nCar]="";	//
                $DivPlaPriLugarTriple[$nCar]="";//
                $DivShoPriLugar[$nCar]="0";		//
                $DivShoPriLugarDoble[$nCar]="";	//
                $DivShoPriLugarTriple[$nCar]="";//
                $DivPlaSegLugar[$nCar]="0";		//
                $DivPlaSegLugarDoble[$nCar]="";	//
                $DivPlaSegLugarTriple[$nCar]="";//
                $DivShoSegLugar[$nCar]="0";		//
                $DivShoSegLugarDoble[$nCar]="";	//
                $DivShoSegLugarTriple[$nCar]="";//
                $DivShoTerLugar[$nCar]="0";		//
                $DivShoTerLugarDoble[$nCar]="";	//
                $DivShoTerLugarTriple[$nCar]="";//
                $divExotic[$nCar][0][0][0]="EXACTA"; // tipo de exotica
                $divExotic[$nCar][0][0][1]="0-0";	 // llegada
                $divExotic[$nCar][0][0][2]=0; // dividendo
                $divExotic[$nCar][0][0][3]=0; /// factor
                $divExotic[$nCar][1][0][0]="TRIFECTA"; // tipo de exotica
                $divExotic[$nCar][1][0][1]="0-0-0";	 // llegada
                $divExotic[$nCar][1][0][2]=0; // dividendo
                $divExotic[$nCar][1][0][3]=0; /// factor
                $divExotic[$nCar][2][0][0]="SUPERFECTA"; // tipo de exotica
                $divExotic[$nCar][2][0][1]="0-0-0-0";	 // llegada
                $divExotic[$nCar][2][0][2]=floatval(0); // dividendo
                $divExotic[$nCar][2][0][3]=0; /// factor
            }
        }
    }
    echo $url;

    return array($cAct,$eje1LugarSimple,$eje1LugarDoble,$eje1LugarTriple,$eje2LugarSimple,$eje2LugarDoble,$eje2LugarTriple,$eje3LugarSimple,$eje3LugarDoble,$eje3LugarTriple,$eje4LugarSimple,$eje4LugarDoble,$eje4LugarTriple,$DivWinPriLugar,$DivWinPriLugarDoble,$DivWinPriLugarTriple,$DivPlaPriLugar,$DivPlaPriLugarDoble,$DivPlaPriLugarTriple,$DivShoPriLugar,$DivShoPriLugarDoble,$DivShoPriLugarTriple,$DivPlaSegLugar,$DivPlaSegLugarDoble,$DivPlaSegLugarTriple,$DivShoSegLugar,$DivShoSegLugarDoble,$DivShoSegLugarTriple,$DivShoTerLugar,$DivShoTerLugarDoble,$DivShoTerLugarTriple,$divExotic);
}

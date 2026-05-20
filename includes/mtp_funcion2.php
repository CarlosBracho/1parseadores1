<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        global $conexionbanca;
        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conexionbanca, $theValue) : mysqli_escape_string($conexionbanca, $theValue);

        switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
        return $theValue;
    }
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

function consultaCierre()
{
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu") ;
    $url="http://basic.tvg.com/Open/Schedule/BroadcastSchedule.aspx";
    $existe=1;
    $horacarr[0]="";
    $hipodomo[0]="";
    $numeroca[0]="";
    $restante[0]="";
    $horacier[0]="";
    if ($existe==1) {
        include_once('simple_html_dom.php');
        $html = file_get_html($url);
        $a=0;
        foreach ($html->find('tr[class="ItemRowEven"] text') as $info1) {
            $tabla1[$a]=$info1;
            $a++;
        }
        $a=0;
        foreach ($html->find('tr[class="ItemRowOdd"] text') as $info1) {
            $tabla2[$a]=$info1;
            $a++;
        }
        $a=0;
        $b=0;
        $x=0;
        $cant=count($tabla1);
        foreach ($tabla1 as $info1) {
            if (($a % 7) == 0 && $a!=0) {
                $horacarr[$b]=$tabla1[$a-6];				// hora
                $hipodomo[$b]=trim(strtoupper($tabla1[$a-5]));	// hipodromo
                $numeroca[$b]=$tabla1[$a-4];				// número carrera
                $restante[$b]=trim($tabla1[$a-3]);				// tiempo restante
                $r3="+".$restante[$b]." minute";
                $horacier[$b]=date("h:i", strtotime($r3)); // hora de cierre
                if (isset($tabla2[$a])) {
                    $b++;
                    $horacarr[$b]=$tabla2[$a-6];				// hora
                    $hipodomo[$b]=trim(strtoupper($tabla2[$a-5]));	// hipodromo
                    $numeroca[$b]=$tabla2[$a-4];				// número carrera
                    $restante[$b]=trim($tabla2[$a-3]);				// tiempo restante
                    $r3="+".$restante[$b]." minute";
                    $horacier[$b]=date("h:i", strtotime($r3)); // hora de cierre
                }
                $b++;
            }
            $a=$a+7;
            $x++;
            if ($a>$cant) {
                break;
            }
        }
    }
    return array($horacarr, $hipodomo, $numeroca, $restante, $horacier);
}
function consultaPacificna()
{
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu") ;
    $url="http://localhost/program1.php";
    $existe=1;
    $horaCa[0]="";
    $hipodr[0]="";
    $carrer[0]="";
    $tiempo[0]="";
    $horacier[0]="";
    if ($existe==1) {
        include_once('simple_html_dom.php');
        $html = file_get_html($url);
        $f=is_object($html);
        if ($html) {
            $t=0;
            foreach ($html->find('div[align="left"] text') as $info1) {
                $arr[$t]=trim($info1);
                $t++;
            }
            $t=0;
            $u=0;
            if (!empty($arr)) {
                foreach ($arr as $info2) {
                    $busca1 = strpos($info2, "AM");
                    $busca2 = strpos($info2, "PM");
                    if ($busca1 !== false || $busca2 !== false) {
                        $temp1=explode("&nbsp;", $info2);
                        $horaCa[$u]=$temp1[0];
                        $hipodr[$u]=trim(strtoupper($arr[$t+4]));
                        $carrer[$u]=$arr[$t+6];
                        $carrer[$u]=str_replace("&nbsp;", "", $carrer[$u]);
                        $temp=explode("&nbsp;", $arr[$t+10]);
                        $tiempo[$u]=$temp[0];
                        $r3="+".$tiempo[$u]." minute";
                        $horacier[$u]=date("h:i", strtotime($r3)); // hora de cierre
                        $u++;
                    }
                    $t++;
                }
            }
        }
    }
    return array($horaCa, $hipodr, $carrer, $tiempo, $horacier);
}

function consultaTVGRetirados($url, $ext, $car, $fec)
{
    if (trim($url)!="" && trim($url)!="") {
        $dia=substr($fec, 8, 2);
        $mes=substr($fec, 5, 2);
        $ano=substr($fec, 0, 4);
        $fec=$mes."/".$dia."/".$ano;
        $car="&RaceNum=".$car;
        $url=trim($url).$fec.$car.$ext;
        $xml = simplexml_load_file($url) or die("feed not loading");
        $datosXML=xml2array($url);
        $j=0;
        $horse=array();
        $oddss=array();
        $retiro=array();
        $programados=0;
        for ($i = 0; $i <= 40; $i++) {
            $attr=$i."_attr";
            if (isset($datosXML["dynamicInfo"]["currentodds"]["BI"][$attr]["number"])) {
                $horse[$i] = $datosXML["dynamicInfo"]["currentodds"]["BI"][$attr]["number"];
                $oddss[$i] = $datosXML["dynamicInfo"]["currentodds"]["BI"][$attr]["currentOdds"];
                $programados=$horse[$i];
                if ($datosXML["dynamicInfo"]["currentodds"]["BI"][$attr]["currentOdds"]=="-") {
                    $retiro[$j]=$horse[$i];
                    $j++;
                }
            } else {
                break;
            }
        }
    }
    return array($horse, $oddss, $retiro,$programados);
}

function consultaPacificnaRetirados()
{
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu") ;
    $url="http://1h.superamericanas.com:5825/retirados.asp";
    $existe=1;
    $hipoCar[0]=0;
    $caballo[0]=0;
    if ($existe==1) {
        include_once('simple_html_dom.php');
        $html = file_get_html($url);
        $t=0;
        $control=0;
        foreach ($html->find('br text') as $info1) {
            $in=strip_tags($info1, "&nbsp;");
            $in=trim($in);
            if ($in=="------------------------------") {
                $control=1;
            }
            if ($control==1 && $in!="------------------------------") {
                if ($in!="") {
                    $arr[$t]=$in;
                    $t++;
                }
            }
        }
        if (!empty($arr)) {
            $v=0;
            $hasta=count($arr)-4;
            for ($i = 0; $i <= $hasta; $i=$i+2) {
                $hipoCar[$v]=strtoupper(substr($arr[$i], 0, -1));
                $caballo[$v]=$arr[$i+1];
                $v++;
            }
        }
    }
    return array($hipoCar, $caballo);
}
function consultaCierreHorsePlayer()
{
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu") ;
    $url="http://seoparser.com/?url=http%3A%2F%2Fwww.horseplayerinteractive.com%2FRacing%2FFullOddsView.aspx";
    $existe=1;
    $horacarr[0]="";
    $hipodomo[0]="";
    $numeroca[0]="";
    $restante[0]="";
    $horacier[0]="";
    if ($existe==1) {
        include_once('simple_html_dom.php');
        $html = file_get_html($url);
        $t=0;
        $control=0;
        $a=0;
        $b=0;
        foreach ($html->find('li text') as $info1) {
            $variable[$a]=trim(strtoupper($info1));
            $busca1 = strpos($variable[$a], "RACE");
            if ($busca1 !== false) {
                $var2=explode(",", $variable[$a]);
                $var3=explode(" ", $var2[0]);
                $var4=explode(" ", $var2[1]);
                $restante[$b]=$var4[1];
                if ($var4[1]=="OFF") {
                    $restante[$b]=0;
                }
                if ($var4[1]=="0") {
                    $restante[$b]=1;
                }
                $numeroca[$b]=trim($var3[1]);
                $r3="+".$restante[$b]." minute";
                $horacier[$b]=date("h:i", strtotime($r3));
                $horacier[$b]=horamysqlMTP2($horacier[$b]);
                $horacarr[$b]="";
                $hipodomo[$b]=trim($variable[$a-1]);
                $b++;
            }
            $a++;
        }
    }
    return array($horacarr, $hipodomo, $numeroca, $restante, $horacier);
}
function consultaCierreHorsePlayer2()
{
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
    $url="http://seoparser.com/?url=http%3A%2F%2Fwww.horseplayerinteractive.com%2FRacing%2FFullOddsView.aspx";
    $existe=1;
    $horacarr[0]="";
    $hipodomo[0]="";
    $numeroca[0]="";
    $restante[0]="";
    $horacier[0]="";
    if ($existe==1) {
        include_once('simple_html_dom.php');
        $html = file_get_html($url);
        $t=0;
        $control=0;
        $a=0;
        $b=0;
        foreach ($html->find('li text') as $info1) {
            $variable[$a]=trim(strtoupper($info1));
            $busca1 = strpos($variable[$a], "RACE");
            if ($busca1 !== false) {
                $var2=explode(",", $variable[$a]);
                if (isset($var2[1])) {
                    $var3=explode(" ", $var2[0]);
                    $var4=explode(" ", $var2[1]);
                    $restante[$b]=$var4[1];
                    if ($var4[1]=="OFF") {
                        $restante[$b]=0;
                    }
                    if ($var4[1]=="0") {
                        $restante[$b]=2;
                    }
                    $numeroca[$b]=trim($var3[1]);
                    $horaInicial=horaactual8();
                    $minutoAnadir=$restante[$b];
                    $segundos_horaInicial=strtotime($horaInicial);
                    $segundos_minutoAnadir=$minutoAnadir*60;
                    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                    $horacier[$b]=$nuevaHora;
                    $horacarr[$b]="";
                    $hipodomo[$b]=trim($variable[$a-1]);
                    $b++;
                }
            }
            $a++;
        }
    }
    return array($horacarr, $hipodomo, $numeroca, $restante, $horacier);
}
function consultaCierreHorsePlayer3()
{
    class HttpConnection
    {
        private $curl;
        private $cookie;
        private $cookie_path="/cookies";
        private $id;
      
        public function __construct()
        {
            $this->id = time();
        }
        public function init($cookie=null)
        {
            if ($cookie) {
                $this->cookie = $cookie;
            } else {
                $this->cookie = $this->cookie_path . $this->id;
            }
      
            $this->curl=curl_init();
            curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
            curl_setopt($this->curl, CURLOPT_HEADER, false);
            curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookie);
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array("Accept-Language: es-es,en"));
            curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookie);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($this->curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($this->curl, CURLOPT_TIMEOUT, 60);
            curl_setopt($this->curl, CURLOPT_AUTOREFERER, true);
        }
        public function setCookiePath($path)
        {
            $this->cookie_path = $path;
        }
        public function get($url, $follow=false)
        {
            $this->init();
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_POST, false);
            curl_setopt($this->curl, CURLOPT_HEADER, $follow);
            curl_setopt($this->curl, CURLOPT_REFERER, '');
            curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $follow);
            curl_setopt($this->curl, CURLOPT_TIMEOUT, 30);
            $result=curl_exec($this->curl);
            if ($result === false) {
                echo curl_error($this->curl);
            }
            $this->_close();
            return $result;
        }
        public function post($url, $post_elements, $follow=false, $header=false)
        {
            $this->init();
            $elements=array();
            foreach ($post_elements as $name=>$value) {
                $elements[] = "{$name}=".urlencode($value);
            }
            $elements = join("&", $elements);
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_POST, true);
            curl_setopt($this->curl, CURLOPT_REFERER, '');
            curl_setopt($this->curl, CURLOPT_HEADER, $header or $follow);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $elements);
            curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $follow);
            curl_setopt($this->curl, CURLOPT_TIMEOUT, 30);
            $result=curl_exec($this->curl);
            $this->_close();
            return $result;
        }
        public function getBinary($url)
        {
            $this->init();
            curl_setopt($this->curl, CURLOPT_URL, $url);
            curl_setopt($this->curl, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($this->curl, CURLOPT_TIMEOUT, 30);
            $result = curl_exec($this->curl);
            $this->_close();
            return $result;
        }
        private function _close()
        {
            curl_close($this->curl);
        }
        public function close()
        {
            if (file_exists($this->cookie)) {
                unlink($this->cookie);
            }
        }
    }
    set_time_limit(0);
    date_default_timezone_set("Pacific/Honolulu");
    $url="http://www.horseplayerinteractive.com/Racing/FullOddsView.aspx";
    $horacarr[0]="";
    $hipodomo[0]="";
    $numeroca[0]="";
    $restante[0]="";
    $horacier[0]="";
    $http = new HttpConnection();
    $http->setCookiePath("/my_cookie_path/");
    $http->init();
    $web=$http->get($url);
    $http->close();
    $dom = new DomDocument;
    @$dom->loadHtml($web);
    $dom->preserveWhiteSpace = false;
    $xpath = new DomXPath($dom);
    $rowData = array();
    $x=0;
    $i=0;
    foreach ($xpath->query('//table[@id="ucTT_rpt_ctl00_g"]/tr') as $node) {
        foreach ($xpath->query('td', $node) as $cell) {
            if ($x==0 || $x == 21) {
                $rowcleaned = str_replace("\xc2\xa0", "", $cell->textContent);
                $rowcleaned = str_replace("Race", "", $rowcleaned);
                $rowData[] = trim($rowcleaned);
                $td1=explode(",", $rowcleaned);
                
                $td2=explode(" ", $td1[0]);  //separa nombre de hipodromo y nro de carrera
                $td3=explode(" ", $td1[1]);  //separa tiempo y estado de carrera
                
                $hipodomo[$i]=strtoupper($td2[0]);
                $numeroca[$i]=$td2[1];
                
                if (isset($td2[2])) {
                    $hipodomo[$i]=strtoupper($td2[0])." ".strtoupper($td2[1]);
                    $numeroca[$i]=$td2[2];
                }
                if (isset($td2[3])) {
                    $hipodomo[$i]=strtoupper($td2[0])." ".strtoupper($td2[1])." ".strtoupper($td2[2]);
                    $numeroca[$i]=$td2[3];
                }
                if (isset($td2[4])) {
                    $hipodomo[$i]=strtoupper($td2[0])." ".strtoupper($td2[1])." ".strtoupper($td2[2])." ".strtoupper($td2[3]);
                    $numeroca[$i]=$td2[4];
                }
                if (isset($td2[5])) {
                    $hipodomo[$i]=strtoupper($td2[0])." ".strtoupper($td2[1])." ".strtoupper($td2[2])." ".strtoupper($td2[3])." ".strtoupper($td2[4]);
                    $numeroca[$i]=$td2[5];
                }
                $horacarr[$i]="";
                $restante[$i]=trim($td3[1]);
                if (trim($td3[1])=="Off" || trim($td3[1])=="OFF") {
                    $restante[$i]=0;
                }
                if (trim($td3[1])=="0") {
                    $restante[$i]=2;
                }
                $horaInicial=horaactual8();
                $minutoAnadir=$restante[$i];
                $segundos_horaInicial=strtotime($horaInicial);
                $segundos_minutoAnadir=$minutoAnadir*60;
                $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                $horacier[$i]=$nuevaHora;
                $x=0;
                $i++;
            }
            $x++;
        }
    }
    
    return array($horacarr, $hipodomo, $numeroca, $restante, $horacier);
}

function consultaCierreWatchandWager()
{
    $horacarr[0]="";
    $hipodomo[0]="";
    $numeroca[0]="";
    $restante[0]="";
    $horacier[0]="";
    if (is_file("simple_html_dom.php")) {
        include('simple_html_dom.php');
    }
    $url = 'https://www.watchandwager.com/';
    $html = file_get_html($url);
    $r=0;
    foreach ($html->find('tr') as $article) {
        foreach ($article->find("td text") as $article2) {
            $datos=$article->find("td text");
            $resultado = strpos($article2, ":");
            if ($resultado !== false) {
                $horacarr[$r]=$datos[0];
                $hipo=explode("(", strtoupper($datos[2]));
                $hipodomo[$r]=trim($hipo[0]);
                $nca=explode("/", $datos[3]);
                $numeroca[$r]=$nca[0]*1;
                if (isset($datos[4])) {
                    $restante[$r]=trim($datos[4])*1;
                } else {
                    $restante[$r]="0";
                }
                if ($restante[$r]=="0") {
                    $restante[$r]=2;
                }
                $horaInicial=horaactual8();
                $minutoAnadir=$restante[$r];
                $segundos_horaInicial=strtotime($horaInicial);
                $segundos_minutoAnadir=$minutoAnadir*60;
                $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                $horacier[$r]=$nuevaHora;
                $r++;
            }
        }
    }
    return array($horacarr, $hipodomo, $numeroca, $restante, $horacier);
}

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);

//include('../includes/mtp_funcion.php');


//list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=new_consultaCierreWatchandWager();
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\alerta_watchandwager_cambionombre.php - QUERY 1 */ SELECT carrera.cod_carrera,
    carrera.nom_hipodromo,
    hipodromo.nom_hipodromo_hpi,
    carrera.num_carrera,
    carrera.hor_carrera,
    carrera.est_carrera,
    carrera.est_cierre,
    carrera.supercontrol,
    carrera.ABIERTOX,
	carrera.horaapertura,
    carrera.delayapertura
	FROM carrera, hipodromo 
	WHERE
carrera.cod_hipodromo=hipodromo.cod_hipodromo AND
carrera.simulcast=0 AND
carrera.num_carrera=1 AND
		carrera.fec_carrera=%s AND 
        hipodromo.mtp_WatchandWager=1",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo $totalRows_Recordset1;
?>
<div style="background:#eaeaea; color: #FFF; width:100%;">
<table width="100%" border="1">
  <tr>
  	<td height="41" colspan="2" align="left" valign="middle" style="font-size:28px; color:#32c75f">CONTROL CIERRE</td>
  	<td height="41" align="right" valign="middle" style="font-size:46px; color:#000000"><?php echo $horasistema ?></td>
    </tr>
</table>
</div>
<?php
if ($totalRows_Recordset1>0) {
    function new_consultaCierreWatchandWager()
    {
        $url = 'https://www.watchandwager.com/data/cards';
        $str_datos = get_url_contents($url);
        $fulldatos = json_decode($str_datos, true);
        $horacarr=array();
        $hipodomo=array();
        $numeroca=array();
        $restante=array();
        $horacier=array();
        if (isset($fulldatos["upcoming_races"])) {
            $g=0;

            foreach ($fulldatos["card_list"] as $data) {
                $card_id=$data["id"];
                $name_ra=$data["name"];
                $current_race=$data["current_race_number"];
                foreach ($fulldatos["card_list"][$card_id]["races"] as $race) {
                    $id=$race["id"];
                    $status_race=$fulldatos["card_list"][$card_id]["races"][$id]["status"];
                    if ($fulldatos["card_list"][$card_id]["races"][$id]["number"]==$current_race) {
                        $hipodomo[$g]=strtoupper($name_ra);
                        $numeroca[$g]=$fulldatos["card_list"][$card_id]["races"][$id]["number"];
                        $restante[$g]=$data["mtp"]+1;
                        $horaInicial=horaactual();
                        $segundos_horaInicial=strtotime($horaInicial);
                        $segundos_minutoAnadir=$restante[$g]*60;
                        $nuevaHora=date("H:i:s",$segundos_horaInicial+$segundos_minutoAnadir);
                        


                        $horacarr[$g]=$nuevaHora;
                        $horacier[$g]=$nuevaHora;
                        $g++;
                    }
                }
            }
        }
        return array($horacarr, $hipodomo, $numeroca, $restante, $horacier);
    }
    list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=new_consultaCierreWatchandWager();



    $g=1;
    
    do {
        $seencuentra=0;
        $f=0;
        if ($hipodomo[0]!="") {
            foreach ($hipodomo as $hip) {
                if (trim($hipodomo[$f])==trim($row_Recordset1['nom_hipodromo_hpi'])) {
                   // echo $row_Recordset1['nom_hipodromo_hpi'];
                    //echo '<br>';
                    
                    $seencuentra=1;
                    $g++;
                    break;
                }
                $hipopagina=$hipodomo[$f];
                $f++;
            } 
        }
if($seencuentra==0){

    $msj="Hay una carrera que posiblemente cambio de nombre en watchandwager o simplemente no la estan vendiendo hoy" . "\n".$row_Recordset1['nom_hipodromo_hpi'];
    $msjx=utf8_encode($msj);
    $post=[
    'chat_id'=>-1001639542248,
    'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec ($ch);
    curl_close ($ch);

   
    echo $row_Recordset1['nom_hipodromo_hpi'];
    echo $hipopagina;
    echo '<br>';
}

        // aqui comunico que no se encuentra
        $seencuentra=0; 
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}
?>

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
$fecha=fechaactualbd();
$hora=horaactual();
$fechahora=$fecha.' '.$hora;
echo '.<br>';
echo $fechahora.'<br>';

$query_Recordset1_alertas = sprintf(
        "/* PARSEADORES1 includes\admin_mtp_watchandwager_hora2.php - QUERY 1 */ SELECT * FROM 
alertas
WHERE  
idalertas=22",
        GetSQLValueString($fecha, "date")
    );
    $Recordset1_alertas = mysqli_query($conexionbanca, $query_Recordset1_alertas) or die(mysqli_error($conexionbanca));
    $row_Recordset1_alertas = mysqli_fetch_assoc($Recordset1_alertas);
    $totalRows_Recordset1_alertas = mysqli_num_rows($Recordset1_alertas);
    echo 'Idalertas= '.$row_Recordset1_alertas['Idalertas'].'<br>';

    $mini_para_repetir='-'.$row_Recordset1_alertas['mini_para_repetir'].' second';
    $tiemponorepeticion = strtotime($mini_para_repetir, strtotime($hora)) ;
    $tiemponorepeticion = date('H:i:s', $tiemponorepeticion);
    $tiemponorepeticion = $fecha.' '.$tiemponorepeticion;
    //echo 'tiemponorepeticion= '.$tiemponorepeticion.'<br>';


    $min_para_reportar='-'.$row_Recordset1_alertas['min_para_reportar'].' minute';
    $tiemporeportar = strtotime($min_para_reportar, strtotime($hora)) ;
    $tiemporeportar = date('H:i:s', $tiemporeportar);
    $tiemporeportar = $fecha.' '.$tiemporeportar;
    //echo '$tiemporeportar= '.$tiemporeportar.'<br>';

    if($row_Recordset1_alertas['horainicio']<$hora & $row_Recordset1_alertas['horafin']>$hora){}else{
        echo 'no esta en el rango de horas de trabjo si desea que se ejecute modificque la hora de ejecucion permitida<br>';}
        if($row_Recordset1_alertas['activo_archivo']==0){}else{
        echo 'no esta activo el codigo por lo tanto no se ejecutara modifiquelo en alertas para que se pueda ejecutar<br>';}
        if($tiemponorepeticion>$row_Recordset1_alertas['ultima_bien']){}else{
        echo 'no a pasado el tiempo para que se pueda ejecutar de nuevo si desea que se ejecute antes redusca o elimine el tiempo de reposo entre ejecucion en alertas para que se pueda ejecutar<br>';}
        




//hora de inicio y hora de fin y si esta activo
if($row_Recordset1_alertas['horainicio']<$hora & $row_Recordset1_alertas['horafin']>$hora & $row_Recordset1_alertas['activo_archivo']==0 & $tiemponorepeticion>$row_Recordset1_alertas['ultima_bien']){
    //echo 'hora de inicio y hora de fin<br>';

//list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=new_consultaCierreWatchandWager();
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\admin_mtp_watchandwager_hora2.php - QUERY 2 */ SELECT carrera.cod_carrera,
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
		(carrera.est_cierre=1 OR carrera.est_cierre=3) AND 
		carrera.eje_primero=0 AND 
		carrera.fec_carrera=%s AND 
		(carrera.mtp_control=3 OR carrera.mtp_control=4 OR carrera.mtp_control=8)",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 10000);
 //-->
 //]]>
</script>
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
                    if ($fulldatos["card_list"][$card_id]["races"][$id]["number"]==$current_race&&$status_race=="O") {
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
    $last = end($numeroca);
    $last = $last/1;
    echo $last;
  
    if ($last==0) {

        $updateSQL = sprintf(
            "/* PARSEADORES1 includes\admin_mtp_watchandwager_hora2.php - QUERY 3 */ UPDATE alertas SET contadorfallos=1+contadorfallos
                              WHERE idalertas=%s",
            GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        if($row_Recordset1_alertas['contadorfallos']>$row_Recordset1_alertas['cont_fallos_reporte'] && $row_Recordset1_alertas['id_chat_error']<>0 && $tiemporeportar>$row_Recordset1_alertas['ultima_bien']){
            echo 'se envio alerta por contador de fallos<br>';
        $msj=$row_Recordset1_alertas['mensajealerta_error'];
        $msjx=utf8_encode($msj);
        $post=[
        'chat_id'=>$row_Recordset1_alertas['id_chat_error'],
        'text'=>$msjx,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_exec($ch);
        curl_close($ch);
        
        //-214345883
        //al reportar en telegran se reinicia el contador de fallos y cuando se ejecuta todo bien tambien
        $updateSQL = sprintf(
            "/* PARSEADORES1 includes\admin_mtp_watchandwager_hora2.php - QUERY 4 */ UPDATE alertas SET contadorfallos=%s
                              WHERE idalertas=%s",
            GetSQLValueString(0, "int"),
            GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        //fin reinicio de contador de fallos
        
        
        }
    
        }

        if ($last>0) {
            $updateSQL = sprintf(
                "/* PARSEADORES1 includes\admin_mtp_watchandwager_hora2.php - QUERY 5 */ UPDATE alertas SET contadorfallos=0, ultima_bien=%s
                                  WHERE idalertas=%s",
                GetSQLValueString($fechahora, "date"),
                GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));



    $g=1;
    do {
        $f=0;
        if ($hipodomo[0]!="") {
            foreach ($hipodomo as $hip) {
                if (trim($hipodomo[$f])==trim($row_Recordset1['nom_hipodromo_hpi']) &&  $restante[$f]<=50 && trim($numeroca[$f])==trim($row_Recordset1['num_carrera'])) {
                    $hor_carrera=$horacier[$f];
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $est=1;
                    $cie=2;
                    if ($restante[$f]=="0") {
                        $est=0;
                    } ?>
                      
                    <div style="background: #F2F2F2; color: #FFF; width:100%; text-align:right; height:40px; font-size:24px; 
                        margin:2px 0px 0px 0px ">
                        <div style="background: #FF9; color: #000; width:65%; height:30px; float:left; text-align:left; 
                            padding:10px 0px 0px 5px "><?php echo $row_Recordset1['nom_hipodromo']; ?>
                        </div>
                        <div style="background: #FF9; color: #000; width:10%; height:30px; float:left; text-align: center; 
                            padding:10px 0px 0px 0px">#<?php echo $row_Recordset1['num_carrera']; ?>
                        </div>
                        <div style="width:0; height:0; border-top: 20px solid transparent;  float:left;
                        	border-bottom: 20px solid transparent; border-left: 20px solid #FF9;">
                        </div>
                        <div style="background: #F2F2F2; color: #000; width:20%; height:30px; float:left; text-align: right; 
                            padding:10px 0px 0px 0px">
							<?php if ($restante[$f]==0) {
                        echo "CERRADA";
                    } else {
                        echo $restante[$f]." min.";
                    } ?>
                        </div>
                    </div>
					<?php

if ($est!=0  && $row_Recordset1['delayapertura']<=1) {


    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\admin_mtp_watchandwager_hora2.php - QUERY 6 */ UPDATE carrera SET delayapertura=delayapertura+1
                              WHERE cod_carrera=%s",

        GetSQLValueString($cod_carrera, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));




}
                    if ($est!=0  && $row_Recordset1['delayapertura']>=2) {
                        if($row_Recordset1['ABIERTOX']==0){$abiertox="WATCHAN";}else{$abiertox=0;}
                        if($row_Recordset1['horaapertura']=='00:00:00'){$horaapertura=$horasistema;}else{$horaapertura=$row_Recordset1['horaapertura'];}
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 includes\admin_mtp_watchandwager_hora2.php - QUERY 7 */ UPDATE carrera SET hor_carrera=%s, 
                            hor_mtp=%s, 
                            est_carrera=%s, 
                            est_cierre=%s, 
                            supercontrol=%s, 
                            ABIERTOX=%s, 
                            horaapertura=%s 
												  WHERE cod_carrera=%s",
                            GetSQLValueString($hor_carrera, "date"),
                            GetSQLValueString($hor_carrera, "date"),
                            GetSQLValueString($est, "int"),
                            GetSQLValueString($cie, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString($abiertox, "text"),
                            GetSQLValueString($horaapertura, "date"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));

                                  $fechaactual=fechaactualbd();
                $insertSQL = sprintf(
                    "/* PARSEADORES1 includes\admin_mtp_watchandwager_hora2.php - QUERY 8 */ INSERT INTO quiencierrayabre 
					(codcarrera, 
					fechaquien, 
					que) 
					VALUES (%s, %s, %s)",
                    GetSQLValueString($cod_carrera, "int"),
                    GetSQLValueString($fechaactual, "date"),
                    GetSQLValueString(10, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

                    }
                    $g++;
                    break;
                }
                $f++;
            }
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}}}
?>

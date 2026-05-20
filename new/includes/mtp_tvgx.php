<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
$fech=fechaactualbd();
$horasistema=horaactual();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\mtp_tvgx.php - QUERY 1 */ SELECT ca.cod_carrera,hi.pre_hipodromo,ca.num_carrera,ca.hor_carrera,ca.est_carrera,ca.est_cierre,ca.supercontrol,ca.contador_cierres FROM carrera ca, hipodromo hi WHERE ca.est_cierre=2 AND ca.eje_primero=0 AND ca.fec_carrera=%s AND (ca.mtp_control=0 OR ca.mtp_control=1 OR ca.mtp_control=2 OR ca.mtp_control=3 OR ca.mtp_control=4 OR ca.mtp_control=6 OR ca.mtp_control=7 OR ca.mtp_control=8) AND ca.cod_hipodromo=hi.cod_hipodromo AND (hi.mtp_betbird=0 OR hi.mtp_betbird=1) ORDER BY hor_carrera",
        GetSQLValueString($fech, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);

                        $horaactualcarrera=horaactual(); $faltan=restahoras($horaactualcarrera, $row_Recordset1['hor_carrera']);



echo $totalRows_Recordset1;
?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 3000);
 //-->
 //]]>
</script>
<div style="background: #F90; color: #FFF; width:100%">
<table width="100%" border="0">
  <tr>
  	<td height="41" colspan="4" align="right" valign="middle" style="font-size:36px; color:#000000"><?php echo $horasistema ?></td>
    </tr>
  <tr>
  	<td width="100"> CIERRE</td>
    <td width="510">HIPODROMO</td>
    <td width="51" align="center">#</td>
    <td width="80" align="center">RESTAN</td>
  </tr>
</table>
</div>
<table width="100%" border="1" bordercolor="#FFCC00">
<?php
if ($totalRows_Recordset1>0) {
    function mtptvg2($p)
    {
        date_default_timezone_set("America/Puerto_Rico");
        $hoy=fechaactualbd();
        switch ($p) {
        case "1": $url = 'https://www.tvg.com/ajax/upcoming-races/id/upcomingList/date/'.$hoy.'/wp/AllTracks'; break;
        case "2": $url = 'https://www.racebets.com/ajax/events/calendar/date/yesterday'; break;
        case "3": $url = 'https://www.racebets.com/ajax/events/calendar/date/tomorrow'; break;
    }
        $str_datos = get_url_contents($url);
        $fulldatos = json_decode($str_datos, true);
        $g=0;
        $nHipodro[$g]=0;
        $nCarrera[$g]=0;
        if (isset($fulldatos)) {
            foreach ($fulldatos as $da) {
                if ($fulldatos[$g]["TrackName"]==$fulldatos[$g]["RaceNumber"]); else {
                    $nHipodro[$g]=$fulldatos[$g]["TrackAbbr"];
                }
            
                $nHipodro[$g]=$fulldatos[$g]["TrackAbbr"];
                $nCarrera[$g]=$fulldatos[$g]["RaceNumber"];
                $g++;
            }
        }
        return array($nHipodro,$nCarrera);
    }
    list($nHipodro, $nCarrera)=mtptvg2(1);
    $last = end($nCarrera);
    $t=0;
    $g=1;
    do {
        echo $last;
        if ($last==0 && $horasistema<="17:00:00") {
            $msj="mtp tvg esta fallando" . "\n";
            $msjx=utf8_encode($msj);
            $post=[
    'chat_id'=>-214345883,
    'text'=>$msjx,
];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_exec($ch);
            curl_close($ch);


            echo "mtp tvg esta fallando";
        }
        $f=0;
        $cont=1;
        list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);

        if ($nHipodro[0]!="") {
            foreach ($nHipodro as $hip) {
                if (trim($nHipodro[$f])==trim($row_Recordset1['pre_hipodromo']) && $nCarrera[$f]==$row_Recordset1['num_carrera'] && $last!=0) {
                    //$hora=explode(" ",$horacarr[$f]);
                    //$hor_carrera=horamysqlMTP($horacier[$f].":".$hora[1]);
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $mtp_control=1;
                    $cie=2;
                    $est=1;
                    $mtc=5;
                    $horaactualcarrera=horaactual();
                    $faltan=restahoras($horaactualcarrera, $row_Recordset1['hor_carrera']);

                    if ($g%2==0) {?>
					  <tr bgcolor="#FFFFFF" style="color:#003" height="31" >
                      <?php } else {?>
                      <tr bgcolor="#FFFF99" style="color:#003" height="31">





<?php
                $horaactualcarrera2=horaactual(); $faltan2=restahoras($horaactualcarrera2, $row_Recordset1['hor_carrera']);
                        $horaInicial=horaactual();
                        list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);
                                                $h=$h/1; $m=$m/1; $s=$s/1;
                        if (($faltan2<="00:01:30") or ($row_Recordset1['hor_carrera']<=$horasistema)) {
                            $minutoAnadir=3;
                            $segundos_horaInicial=strtotime($horaInicial);
                            $segundos_minutoAnadir=$minutoAnadir*60;
                            echo $row_Recordset1['hor_carrera'];
                            echo "<br/>";
                            $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                            $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                            echo $faltan2;
                            echo "<br/>";
                            echo $nuevaHora;
                            echo "<br/>";
                            //echo $row_Recordset1['nom_hipodromo']." | ".$h.":".$m.".".$s." +2<br/>";
                            $updateSQL = sprintf(
                                "/* PARSEADORES1 new\includes\mtp_tvgx.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s 
											  WHERE cod_carrera=%s",
                                GetSQLValueString($nuevaHora, "date"),
                                GetSQLValueString($nuevaHora, "date"),
                                GetSQLValueString($cod_carrera, "int")
                            );
                            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                        }



?>








                     <?php  } ?>
						<td width="510"><?php echo $row_Recordset1['pre_hipodromo']; ?></td>
						<td width="51" align="center"><?php echo $row_Recordset1['num_carrera']; ?></td>
						<td width="80" align="right"><?php echo $faltan; ?>
                        </td>
						
					  </tr>
					<?php


        
                                        
                    $cont=0;
                    $g++;
                    break;
                }
                $f++;
            }
        }

        if ($cont==1) {
            if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $last!=0) {
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $contador_cierres=$row_Recordset1['contador_cierres']+1;
                $est=0;
                $cie=1;
                $mtp=3;
                $updateSQL = sprintf(
                    "/* PARSEADORES1 new\includes\mtp_tvgx.php - QUERY 3 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, est_cierre=%s, CERRADOX=%s, contador_cierres=%s  
							  WHERE cod_carrera=%s",
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString("TVG", "text"),
                    GetSQLValueString($contador_cierres, "int"),
                    GetSQLValueString($cod_carrera, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
            }
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}
?>
</table>
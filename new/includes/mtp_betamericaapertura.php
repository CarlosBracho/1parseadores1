<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);

$cuarentaminmas = date('Y-m-d H:i:s', (time() + 38400));
$fech=fechaactualbd();
$horasistema=horaactual();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\mtp_betamericaapertura.php - QUERY 1 */ SELECT * FROM carrera ca, hipodromo hi WHERE 
	(ca.est_cierre=0 OR ca.est_cierre=1 OR ca.est_cierre=3) 
	AND ca.fec_carrera=%s
	AND ca.eje_primero=0
	AND hi.mtp_betamerica=1
	AND ca.cod_hipodromo=hi.cod_hipodromo ORDER BY hor_carrera",
        GetSQLValueString($fech, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo $totalRows_Recordset1;
?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 10000);
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
    function betamerica($p)
    {
        date_default_timezone_set("America/Puerto_Rico");
        $hoy=fechaactualbd();
        switch ($p) {
        case "1": $url = 'https://api.betamerica.com/hds/service/tracklistitems'; break;
        case "2": $url = 'https://www.racebets.com/ajax/events/calendar/date/yesterday'; break;
        case "3": $url = 'https://www.racebets.com/ajax/events/calendar/date/tomorrow'; break;
    }
        $str_datos = get_url_contents($url);
        $fulldatos = json_decode($str_datos, true);
        $g=0;
        $nHipodro[$g]=0;
        $nCarrera[$g]=0;
        $horagmt[$g]=0;
        if (isset($fulldatos)) {
            foreach ($fulldatos as $da) {
                if ($fulldatos[$g]["trackName"]==$fulldatos[$g]["raceNum"]); else {
                    $nHipodro[$g]=$fulldatos[$g]["trackName"];
                }
            
                $nHipodro[$g]=strtoupper($fulldatos[$g]["trackName"]);
                $nCarrera[$g]=$fulldatos[$g]["raceNum"];
                $horagmt[$g]=$fulldatos[$g]["gmtPostDttm"];
                $cerradoono[$g]=strtoupper($fulldatos[$g]["isWageringClosed"])/1;
                $g++;
            }
        }
        return array($nHipodro,$nCarrera,$horagmt,$cerradoono);
    }
    list($hipodomo, $numeroca, $horagmt, $cerradoono)=betamerica(1);


    $t=0;
    $g=1;
    do {
        $f=0;
        $cont=1;
        if ($hipodomo[0]!="") {
            foreach ($hipodomo as $hip) {
                if (trim($hipodomo[$f])==trim($row_Recordset1['mtp_betamericanom']) && $numeroca[$f]==$row_Recordset1['num_carrera'] && $horagmt[$f] <= $cuarentaminmas && $cerradoono[$f]==0) {
                    $hor_carrera = date('H:i:s', strtotime($horagmt[$f]));
                    echo $hor_carrera;
                    echo '<br/>';
                    $nuevahora1 = strtotime('-10 hour', strtotime($hor_carrera)) ;
                    $nuevahora1 = date('H:i:s', $nuevahora1);
                    echo $nuevahora1;
                    echo '<br/>';
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $mtp_control=1;
                    $cie=2;
                    $est=1;
                    $mtc=5;
                    if ($g%2==0) {?>
					  <tr bgcolor="#FFFFFF" style="color:#003" height="31" >
                      <?php } else {?>
                      <tr bgcolor="#FFFF99" style="color:#003" height="31">
                     <?php  } ?>
						<td width="510"><?php echo $row_Recordset1['mtp_betamericanom']; ?></td>
						<td width="51" align="center"><?php echo $row_Recordset1['num_carrera']; ?></td>

						
					  </tr>
					<?php
                    
                    if ($row_Recordset1['delayapertura']<=5) {
                        $aperura=$row_Recordset1['delayapertura']+1;
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 new\includes\mtp_betamericaapertura.php - QUERY 2 */ UPDATE carrera SET delayapertura=%s 
											  WHERE cod_carrera=%s",
                            GetSQLValueString($aperura, "int"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    } else {
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 new\includes\mtp_betamericaapertura.php - QUERY 3 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_cierre=%s, est_carrera=%s, supercontrol=%s, mtp_control=%s 
											  WHERE cod_carrera=%s",
                            GetSQLValueString($nuevahora1, "date"),
                            GetSQLValueString($nuevahora1, "date"),
                            GetSQLValueString(2, "int"),
                            GetSQLValueString(1, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(3, "int"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    }
                        

                    $cont=0;
                    $g++;
                    break;
                }
                $f++;
            }
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}
?>
</table>
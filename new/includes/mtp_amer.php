<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
$fech=fechaactualbd();
$horasistema=horaactual();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\mtp_amer.php - QUERY 1 */ SELECT * FROM carrera ca, hipodromo hi WHERE hi.mtp_ameridatos=1 AND ca.eje_primero=0 AND ca.fec_carrera=%s AND 
(ca.mtp_control=7 OR ca.mtp_control=9) AND ca.cod_hipodromo=hi.cod_hipodromo ORDER BY hor_carrera",
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
    function consultaPacificna()
    {
        set_time_limit(0);
        date_default_timezone_set("Pacific/Honolulu");
        $url='http://web1.ameridatos.com:6850/program1.asp';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        preg_match_all("(<font color=#0000CC>&nbsp;<B>(.*)</font> <font color=red><font size=3>&nbsp;(.*)</B></font><br><br></td><td align=center>&nbsp;&nbsp;<B><b><font size=3><font color=red>(.*)&nbsp;min.</b>)siU", $result, $matches1);
        $horaCa[0]="";
        $hipodr[0]="";
        $carrer[0]="";
        $tiempo[0]="";
        $horacier[0]="";
        if (!empty($matches1[1])) {
            $carrer=$matches1[2];
            $tiempo=$matches1[3];
            $x=0;
            foreach ($matches1[1] as $datos) {
                $hipodr[$x]=trim(strtoupper($datos));
                $h1="+".$tiempo[$x]." minute";
                $horacier[$x]=date("H:i:s", strtotime($h1));
                $horaCa[$x]=date("h:i:s", strtotime($h1));
                $x++;
            }
        }
        return array($horaCa, $hipodr, $carrer, $tiempo, $horacier);
    }

    list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=consultaPacificna();

    $t=0;
    $g=1;
    do {
        $f=0;
        $cont=1;
        if ($hipodomo[0]!="") {
            foreach ($hipodomo as $hip) {
                if (trim($hipodomo[$f])==trim($row_Recordset1['nom_hipodromo_sup']) && $numeroca[$f]==$row_Recordset1['num_carrera'] &&  $restante[$f]<=50) {
                    $hor_carrera=$horacier[$f];
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $mtp_control=1;
                    $cie=2;
                    $est=1;
                    if ($g%2==0) {?>
					  <tr bgcolor="#FFFFFF" style="color:#003" height="31" >
                      <?php } else {?>
                      <tr bgcolor="#FFFF99" style="color:#003" height="31">
                     <?php  } ?>
						<td width="100" align="center"><?php echo $horacarr[$f]; ?></td>
						<td width="510"><?php echo $row_Recordset1['nom_hipodromo_sup']; ?></td>
						<td width="51" align="center"><?php echo $row_Recordset1['num_carrera']; ?></td>
						<td width="80" align="right"><?php
                            if ($restante[$f]<=1) {
                                echo "<font color='red'>";
                            } else {
                                echo "<font>";
                            }
                    echo $restante[$f]." min. </font>"; ?>
                        </td>
						
					  </tr>
					<?php
                                         $updateSQL = sprintf(
                        "/* PARSEADORES1 new\includes\mtp_amer.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_cierre=%s, est_carrera=%s, supercontrol=%s, CERRADOX=%s 
											  WHERE cod_carrera=%s",
                        GetSQLValueString($hor_carrera, "date"),
                        GetSQLValueString($hor_carrera, "date"),
                        GetSQLValueString(2, "int"),
                        GetSQLValueString(1, "int"),
                        GetSQLValueString(0, "int"),
                        GetSQLValueString("...", "text"),
                        GetSQLValueString($cod_carrera, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    $cont=0;
                    $g++;
                    break;
                }
                $f++;
            }
        }
        if ($cont==1) {
            if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $row_Recordset1['supercontrol']<=2) {
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $supercontrol=$row_Recordset1['supercontrol']+1;
                $updateSQL = sprintf(
                    "/* PARSEADORES1 new\includes\mtp_amer.php - QUERY 3 */ UPDATE carrera SET supercontrol=%s
                                                          WHERE cod_carrera=%s",
                    GetSQLValueString($supercontrol, "int"),
                    GetSQLValueString($cod_carrera, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
            }
        }
        if ($cont==1) {
            if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $row_Recordset1['supercontrol']>=3) {
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $contador_cierres=$row_Recordset1['contador_cierres']+1;
                $est=0;
                $cie=1;
                $updateSQL = sprintf(
                    "/* PARSEADORES1 new\includes\mtp_amer.php - QUERY 4 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, est_cierre=%s, CERRADOX=%s, contador_cierres=%s
							  WHERE cod_carrera=%s",
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString("AMERIDATOS", "text"),
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
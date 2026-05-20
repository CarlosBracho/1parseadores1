<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\includes\mtp_paribetx.php - QUERY 1 */ SELECT carrera.cod_carrera,carrera.nom_hipodromo,hipodromo.mtp_paribetnom,carrera.num_carrera,carrera.hor_carrera,
carrera.hor_mtp,
carrera.est_carrera,
carrera.est_cierre,
carrera.supercontrol,
carrera.contador_cierres,
hipodromo.mtp_paribet,
		carrera.mtp1,
		carrera.mtp2,
		carrera.mtp3,
		carrera.mtp4,
		carrera.mtp5,
                carrera.mtp6,
		carrera.mtp7     
	FROM carrera, hipodromo 
	WHERE
		carrera.cod_hipodromo=hipodromo.cod_hipodromo AND
		hipodromo.mtp_paribet=1 AND 
		carrera.est_cierre=2 AND 
		carrera.est_carrera=1 AND 
		carrera.eje_primero=0 AND 
		carrera.fec_carrera=%s AND 
		carrera.num_carrera<=11",
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
  setTimeout("location.reload()", 3000);
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
    function paribet2()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.paribet.com/');
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = strtoupper(curl_exec($ch));
        $data = curl_error($ch);
        curl_close($ch);
    
        preg_match_all("(\s\s\s\s\s\s\s\s\s\s\s\s<a+\s+\s+href=\"\/race\/(.*)\/(.*)\/(.*)\/(.*)\"\sclass=\"(.*)\">(.*)<\/a>)siU", $result, $matches1);
        $hipodr[0]="";
        $carrer[0]="";
        $estado[0]="";
        if (!empty($matches1[3])) {
            $x=0;
            $y=0;
            foreach ($matches1[3] as $datos) {
                if ($matches1[5][$y]==trim("") or $matches1[5][$y]==trim("ORANGE")) {
                    $carrer[$x]=$matches1[6][$y];
                    $hipodr[$x]=trim(strtoupper($datos));
                    $x++;
                }
                $y++;
            }
        }
        return array($hipodr, $carrer);
    }
    list($hipodr, $carrer)=paribet2();
    $last = end($carrer);
    $last = $last/1;
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


        echo "mtp paribet esta fallando";
    }
    $g=1;
    do {
        $cerradores=$row_Recordset1['mtp1']+$row_Recordset1['mtp2']+$row_Recordset1['mtp3']+$row_Recordset1['mtp4']+$row_Recordset1['mtp5']+$row_Recordset1['mtp6']+$row_Recordset1['mtp7'];

        $f=0;
        $control=1;
        if ($hipodr[0]!="") {
            foreach ($hipodr as $hip) {
                $horaactualcarrera2=horaactual();
                $faltan2=restahoras($horaactualcarrera2, $row_Recordset1['hor_carrera']);

                $cod_carrera=$row_Recordset1['cod_carrera'];

                $horaInicial=horaactual();
                list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);
                $h=$h/1;
                $m=$m/1;
                $s=$s/1;
                if (($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $faltan2<="00:00:30" && $last!=0) or ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $row_Recordset1['hor_carrera']<=$horasistema && $last!=0)) {
                    $minutoAnadir=3;
                    $segundos_horaInicial=strtotime($horaInicial);
                    $segundos_minutoAnadir=$minutoAnadir*60;
                    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);

                    $updateSQL = sprintf(
                        "/* PARSEADORES1 new\includes\mtp_paribetx.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s 
											  WHERE cod_carrera=%s",
                        GetSQLValueString($nuevaHora, "date"),
                        GetSQLValueString($nuevaHora, "date"),
                        GetSQLValueString($cod_carrera, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                }







                if (trim($hipodr[$f])==trim($row_Recordset1['mtp_paribetnom']) && $carrer[$f]==$row_Recordset1['num_carrera'] && $last!=0) {
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    /*


                        */
                    $control=0;
                }

                $f++;
            }
        }

        if ($control==1) {
            if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $last!=0) {
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $contador_cierres=$row_Recordset1['contador_cierres']+1;
                $est=0;
                $cie=1;
                $updateSQL = sprintf(
                    "/* PARSEADORES1 new\includes\mtp_paribetx.php - QUERY 3 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, est_cierre=%s, CERRADOX=%s, contador_cierres=%s
							  WHERE cod_carrera=%s",
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString("PARIBET", "text"),
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
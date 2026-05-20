<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
//include('../includes/mtp_funcion.php');
//list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=new_consultaCierreWatchandWager2();


include('../includes/mtp_funcion5.php');
list($hipodr, $carrer)=paribet2();


$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\mtp_paribetenprueba version nueva.php - QUERY 1 */ SELECT carrera.cod_carrera,carrera.nom_hipodromo,hipodromo.mtp_paribetnom,carrera.num_carrera,carrera.hor_carrera,carrera.hor_mtp,carrera.est_carrera,carrera.est_cierre,carrera.supercontrol,carrera.contador_cierres,hipodromo.mtp_paribet     
	FROM carrera, hipodromo 
	WHERE
		carrera.cod_hipodromo=hipodromo.cod_hipodromo AND
		hipodromo.mtp_paribet=1 AND 
		carrera.est_cierre=2 AND 
		carrera.est_carrera=1 AND 
		carrera.eje_primero=0 AND 
		carrera.fec_carrera=%s AND 
		carrera.num_carrera<=11 AND
		(carrera.mtp_control=0 OR carrera.mtp_control=1 OR carrera.mtp_control=2 OR carrera.mtp_control=3 OR carrera.mtp_control=4 OR carrera.mtp_control=5 OR carrera.mtp_control=6 OR carrera.mtp_control=7 OR carrera.mtp_control=8 OR carrera.mtp_control=9)",
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
    $g=1;
    do {
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
                if (($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $faltan2<="00:00:30") or ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $row_Recordset1['hor_carrera']<=$horasistema)) {
                    $minutoAnadir=3;
                    $segundos_horaInicial=strtotime($horaInicial);
                    $segundos_minutoAnadir=$minutoAnadir*60;
                    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);

                    $updateSQL = sprintf(
                        "/* PARSEADORES1 includes\mtp_paribetenprueba version nueva.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s 
											  WHERE cod_carrera=%s",
                        GetSQLValueString($nuevaHora, "date"),
                        GetSQLValueString($nuevaHora, "date"),
                        GetSQLValueString($cod_carrera, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                }







                if (trim($hipodr[$f])==trim($row_Recordset1['mtp_paribetnom']) && $carrer[$f]==$row_Recordset1['num_carrera']) {
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    /*


                        */
                    $control=0;
                }

                $f++;
            }
        }

        if ($control==1) {
            if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2) {
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $contador_cierres=$row_Recordset1['contador_cierres']+1;
                $est=0;
                $cie=1;
                $updateSQL = sprintf(
                    "/* PARSEADORES1 includes\mtp_paribetenprueba version nueva.php - QUERY 3 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, est_cierre=%s, CERRADOX=%s, contador_cierres=%s
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
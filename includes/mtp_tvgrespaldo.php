<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
$fech=fechaactualbd();
$horasistema=horaactual();
            list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);

                        $horaactualcarrera=horaactual(); $faltan=restahoras($horaactualcarrera, $row_Recordset1['hor_carrera']);

    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 includes\mtp_tvgrespaldo.php - QUERY 1 */ SELECT * FROM carrera ca, hipodromo hi WHERE ca.est_cierre=2 AND ca.eje_primero=0 AND ca.fec_carrera=%s AND (ca.mtp_control=0 OR ca.mtp_control=1 OR ca.mtp_control=2 OR ca.mtp_control=3 OR ca.mtp_control=4 OR ca.mtp_control=7 OR ca.mtp_control=8 OR ca.mtp_control=9) AND ca.cod_hipodromo=hi.cod_hipodromo AND (hi.mtp_betbird=0 OR hi.mtp_betbird=1) ORDER BY hor_carrera",
        GetSQLValueString($fech, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
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
    list($nHipodro, $nCarrera)=mtptvg2(1);
    $t=0;
    $g=1;
    do {
        $f=0;
        $cont=1;
        list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);

        if ($nHipodro[0]!="") {
            foreach ($nHipodro as $hip) {
                if (trim($nHipodro[$f])==trim($row_Recordset1['pre_hipodromo']) && $nCarrera[$f]==$row_Recordset1['num_carrera']) {
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
            if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2) {
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $est=0;
                $cie=1;
                $mtp=0;
                $updateSQL = sprintf(
                    "/* PARSEADORES1 includes\mtp_tvgrespaldo.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, est_cierre=%s, mtp_control=%s, CERRADOX=%s
							  WHERE cod_carrera=%s",
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($mtp, "int"),
                    GetSQLValueString(TVG, "text"),
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
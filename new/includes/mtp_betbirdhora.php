<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
include('../includes/mtp_funcion5.php');
function consultaCierrebetbird()
{
    //$url = 'localhost/1/includes/betbird.json';
    $url = 'http://www.localhost/includes/betbird.json';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $track_name=array();
    $number=array();
    if (isset($fulldatos["data"]["races"])) {
        $g=0;

        foreach ($fulldatos["data"]["races"] as $data) {
            $hipodomo[$g]=strtoupper($data["track_name"]);
            $numeroca[$g]=$data["number"];
            $fecha = date_create();
            $fechayhora= date_timestamp_get($fecha);
            $mtp[$g]=ceil((((strtotime($data["schedule_time_utc"]))-$fechayhora)/60)-600);

            $g++;
        }
    }
    return array($hipodomo, $numeroca, $mtp);
}



list($hipodomo, $numeroca, $mtp)=consultaCierrebetbird();
$fech=fechaactualbd();
$horasistema=horaactual();
            list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);

                        $horaactualcarrera=horaactual(); $faltan=restahoras($horaactualcarrera, $row_Recordset1['hor_carrera']);

    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\mtp_betbirdhora.php - QUERY 1 */ SELECT 
		hi.pre_twin,
		hi.nom_hipodromo,
				hi.nom_betbird,
		ca.cod_carrera,
		ca.num_carrera,
 		ca.est_carrera,
 		ca.hor_carrera,
		ca.est_cierre,
		ca.contador_cierres,
		ca.mtp1,
		ca.mtp2,
		ca.mtp3,
		ca.mtp4,
		ca.mtp5,		
        ca.mtp6,
		ca.mtp7
	FROM carrera ca, hipodromo hi
	WHERE	ca.cod_hipodromo=hi.cod_hipodromo AND
		hi.mtp_betbird=1 AND 
		    ca.est_carrera=1 AND 
		    ca.eje_primero=0 AND
	        ca.est_cierre=3	AND
		    ca.fec_carrera=%s AND 
		   (ca.mtp_control=1 OR ca.mtp_control=3 OR ca.mtp_control=6)",
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
  setTimeout("location.reload()", 11000);
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
    $last = end($numeroca);
    $last = $last/1;
    echo $last;

    $t=0;
    $g=1;
    do {
        $f=0;
        $cont=1;
        list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);

        if ($hipodomo[0]!="") {
            foreach ($hipodomo as $hip) {
                if (trim($hipodomo[$f])==trim($row_Recordset1['nom_betbird']) && $numeroca[$f]==$row_Recordset1['num_carrera']  && $mtp[$f]<=11 && $last!=0) {
                    echo 'hor_carrera';


                    //$hora=explode(" ",$horacarr[$f]);
                    //$hor_carrera=horamysqlMTP($horacier[$f].":".$hora[1]);

                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $mtp_control=1;
                    $cie=2;
                    $est=1;
                    $mtc=5;
                    $horaactualcarrera=horaactual();
                    $faltan=restahoras($horaactualcarrera, $row_Recordset1['hor_carrera']);
                                                    
                    $horaInicial=horaactual();
                    $minutoAnadir=$mtp[$f];
                    $segundos_horaInicial=strtotime($horaInicial);
                    $segundos_minutoAnadir=$minutoAnadir*60;
            
                    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);

                    $updateSQL = sprintf(
                        "/* PARSEADORES1 new\includes\mtp_betbirdhora.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_cierre=%s, est_carrera=%s, supercontrol=%s, mtp_control=%s 
											  WHERE cod_carrera=%s",
                        GetSQLValueString($nuevaHora, "date"),
                        GetSQLValueString($nuevaHora, "date"),
                        GetSQLValueString(2, "int"),
                        GetSQLValueString(1, "int"),
                        GetSQLValueString(0, "int"),
                        GetSQLValueString(3, "int"),
                        GetSQLValueString($cod_carrera, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));






                    if ($g%2==0) {?>
					  <tr bgcolor="#FFFFFF" style="color:#003" height="31" >
                      <?php } else {?>
                      <tr bgcolor="#FFFF99" style="color:#003" height="31">
                     <?php  } ?>
						<td width="510"><?php echo $row_Recordset1['nom_betbird']; ?></td>
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
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}

?>
</table>
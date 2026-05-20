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
    "/* PARSEADORES1 new\includes\admin_mtp_watchandwager_hora2.php - QUERY 1 */ SELECT carrera.cod_carrera,carrera.nom_hipodromo,hipodromo.nom_hipodromo_hpi,carrera.num_carrera,carrera.hor_carrera,carrera.est_carrera,carrera.est_cierre,carrera.supercontrol  
	FROM carrera, hipodromo 
	WHERE
		carrera.cod_hipodromo=hipodromo.cod_hipodromo AND
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
                        $horacarr[$g]=horaactual();
                        $horacier[$g]=horaactual();
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
                    if ($est!=0) {
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 new\includes\admin_mtp_watchandwager_hora2.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, est_cierre=%s, supercontrol=%s 
												  WHERE cod_carrera=%s",
                            GetSQLValueString($hor_carrera, "date"),
                            GetSQLValueString($hor_carrera, "date"),
                            GetSQLValueString($est, "int"),
                            GetSQLValueString($cie, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    }
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

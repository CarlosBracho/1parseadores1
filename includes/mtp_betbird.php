<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
include('../includes/mtp_funcion5.php');
$hipodomo=""; $numeroca=""; $mtp="";
//$salida = shell_exec('root curl "https://www.betbird.com/data/race/nextbetchances/70/?kgobaq1ali" -H "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0" -H "Accept: application/json, text/javascript" -H "Accept-Language: es-AR,es;q=0.8,en-US;q=0.5,en;q=0.3" --compressed -H "Referer: https://www.betbird.com/races/nextchances" -H "X-Requested-With: XMLHttpRequest" -H "X-User-Timezone: 14400000" -H "Cookie: CTY=ve; DVC=desktop; LNG=english; LaVisitorNew=Y; LaVisitorId=wuq6tdk1u6qpj1lw8mg8r0rx1wopb; LaSID=v5aysei1xx28yun60tv7ebjdf3yuv; _ga=GA1.2.1520251148.1559934513; _gid=GA1.2.1638060358.1559934513" -H "Connection: keep-alive" -o  ../home/apuestas/public_html/includes/betbird.json > /dev/null 2>&1');
//echo "<pre>$salida</pre>";
$fecha=fechaactualbd();
$hora=horaactual();
//prueba.bot.nu/includes/108.json
$fechahora=$fecha.' '.$hora;
echo '.<br>';
echo $fechahora.'<br>';

$query_Recordset1_alertas = sprintf(
        "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 1 */ SELECT * FROM 
alertas
WHERE  
idalertas=24",
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
include_once("../parseadores_ia/betbird_generador_json.php");
rename("betbird.json", "betbird.json");

function consultaCierrebetbird()
{
    //$url = 'localhost/1/includes/betbird.json';
    $url = 'http://parseadores1.us.to/includes/betbird.json';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);

    //print_r($fulldatos);

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
$fech=fechaactualbd();
$horasistema=horaactual();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 2 */ SELECT * FROM carrera ca, 
hipodromo hi, 
alertas al 
WHERE  
al.idalertas=1 AND 
ca.simulcast=0 AND
ca.est_cierre=2 AND 
ca.eje_primero=0 AND 
ca.fec_carrera=%s AND 
(ca.mtp_control=1 OR ca.mtp_control=3 OR ca.mtp_control=5 OR ca.mtp_control=6) AND 
ca.cod_hipodromo=hi.cod_hipodromo AND 
hi.mtp_betbird=1 
ORDER BY hor_carrera",
        GetSQLValueString($fech, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo $totalRows_Recordset1;

list($hipodomo, $numeroca, $mtp)=consultaCierrebetbird();

            list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);

                        $horaactualcarrera=horaactual(); $faltan=restahoras($horaactualcarrera, $row_Recordset1['hor_carrera']);



?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 20000);
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

    if ($last==0) {
        $updateSQL = sprintf(
            "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 3 */ UPDATE alertas SET contadorfallos=1+contadorfallos
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
            "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 4 */ UPDATE alertas SET contadorfallos=%s
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
            "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 5 */ UPDATE alertas SET contadorfallos=0, ultima_bien=%s
                              WHERE idalertas=%s",
            GetSQLValueString($fechahora, "date"),
            GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));


    $t=0;
    $g=1;
    do {
        $f=0;
        $cont=1;
        list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);

        if ($hipodomo[0]!="") {
            foreach ($hipodomo as $hip) {
                if (trim($hipodomo[$f])==trim($row_Recordset1['nom_betbird']) && $numeroca[$f]==$row_Recordset1['num_carrera'] && $mtp[$f]<=47 && $last>0) {
                    if ($row_Recordset1['contadoralerta']>0) {
                        $updateSQL222 = sprintf(
                            "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 6 */ UPDATE alertas SET contadoralerta=%s
							  WHERE idalertas=%s",
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(1, "int")
                        );
                        $Result222 = mysqli_query($conexionbanca, $updateSQL222) or die(mysqli_error($conexionbanca));
                    }

                    //$hora=explode(" ",$horacarr[$f]);
                    //$hor_carrera=horamysqlMTP($horacier[$f].":".$hora[1]);
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $mtp_control=1;
                    $cie=2;
                    $est=1;
                    $mtc=5;
                    $horaactualcarrera=horaactual();
                    $faltan=restahoras($horaactualcarrera, $row_Recordset1['hor_carrera']);

                    if (trim($hipodomo[$f])==trim($row_Recordset1['nom_betbird']) && $numeroca[$f]==$row_Recordset1['num_carrera'] && $row_Recordset1['betbirdvista']==0) {
                        $cod_carrera=$row_Recordset1['cod_carrera'];

                        $updateSQL = sprintf(
                            "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 7 */ UPDATE carrera SET betbirdvista=%s
							  WHERE cod_carrera=%s",
                            GetSQLValueString(1, "int"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    }
                    $horaactualcarrera2=horaactual();
                    $faltan2=restahoras($horaactualcarrera2, $row_Recordset1['hor_carrera']);
                    $horaInicial=horaactual();
                    list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);
                    $h=$h/1;
                    $m=$m/1;
                    $s=$s/1;
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
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 8 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s 
											  WHERE cod_carrera=%s",
                            GetSQLValueString($nuevaHora, "date"),
                            GetSQLValueString($nuevaHora, "date"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    }









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
                    echo 'break';
                }
                $f++;
            }
        }
        if ($cont==1) {
            $mtpx=restahoraRB(horaactual2(), $row_Recordset1['hor_carrera']);
            if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $row_Recordset1['betbirdvista']==1 && $mtp[$f]<=3 && $last>=1 && $mtpx<=5) {
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $est=0;
                $cie=1;
                $mtp=1;
                $updateSQL = sprintf(
                    "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 9 */ UPDATE carrera SET hor_carrera=%s, 
                    hor_mtp=%s, 
                    est_carrera=%s, 
                    est_cierre=%s, 
                    mtp_control=%s, 
                    CERRADOX=%s,
                    contador_cierres=contador_cierres+1 
							  WHERE cod_carrera=%s",
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($mtp, "int"),
                    GetSQLValueString('BETBIRD', "text"),
                    GetSQLValueString($cod_carrera, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                
                
                $fechaactual=fechaactualbd();
                $insertSQL = sprintf(
                    "/* PARSEADORES1 includes\mtp_betbird.php - QUERY 10 */ INSERT INTO quiencierrayabre 
					(codcarrera, 
					fechaquien, 
					que) 
					VALUES (%s, %s, %s)",
                    GetSQLValueString($cod_carrera, "int"),
                    GetSQLValueString($fechaactual, "date"),
                    GetSQLValueString(3, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
            }
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}}

rename("betbird.json", "betbird2.json");
}
?>
</table>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
include('../includes/mtp_funcion5.php');

$fecha=fechaactualbd();
$hora=horaactual();
//prueba.bot.nu/includes/108.json
$fechahora=$fecha.' '.$hora;
echo '.<br>';
echo $fechahora.'<br>';

$query_Recordset1_alertas = sprintf(
        "/* PARSEADORES1 includes\mtp_betbirdhora.php - QUERY 1 */ SELECT * FROM 
alertas
WHERE  
idalertas=25",
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


function consultaCierrebetbird()
{
    //$url = 'localhost/1/includes/betbird.json';
    $url = 'localhost/includes/betbird2.json';
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
        "/* PARSEADORES1 includes\mtp_betbirdhora.php - QUERY 2 */ SELECT 
		hi.pre_twin,
		hi.nom_hipodromo,
		hi.nom_betbird,
		ca.cod_carrera,
		ca.num_carrera,
 		ca.est_carrera,
 		ca.hor_carrera,
		ca.est_cierre,
		ca.contador_cierres,
        ca.ABIERTOX,
		ca.mtp1,
		ca.mtp2,
		ca.mtp3,
		ca.mtp4,
		ca.mtp5,		
        ca.mtp6,
		ca.mtp7,
        ca.horaapertura
	FROM carrera ca, hipodromo hi
	WHERE	ca.cod_hipodromo=hi.cod_hipodromo AND
ca.simulcast=0 AND
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
    if ($last==0) {
        $updateSQL = sprintf(
            "/* PARSEADORES1 includes\mtp_betbirdhora.php - QUERY 3 */ UPDATE alertas SET contadorfallos=1+contadorfallos
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
            "/* PARSEADORES1 includes\mtp_betbirdhora.php - QUERY 4 */ UPDATE alertas SET contadorfallos=%s
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
            "/* PARSEADORES1 includes\mtp_betbirdhora.php - QUERY 5 */ UPDATE alertas SET contadorfallos=0, ultima_bien=%s
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
                    if($row_Recordset1['ABIERTOX']==0){$abiertox="BETBIRD";}else{$abiertox=0;}
                    if($row_Recordset1['horaapertura']=='00:00:00'){$horaapertura=$horasistema;}else{$horaapertura=$row_Recordset1['horaapertura'];}
                    $updateSQL = sprintf(
                        "/* PARSEADORES1 includes\mtp_betbirdhora.php - QUERY 6 */ UPDATE carrera SET hor_carrera=%s, 
                        hor_mtp=%s, 
                        est_cierre=%s, 
                        est_carrera=%s, 
                        supercontrol=%s, 
                        mtp_control=%s, 
                        ABIERTOX=%s, 
                        horaapertura=%s 
											  WHERE cod_carrera=%s",
                        GetSQLValueString($nuevaHora, "date"),
                        GetSQLValueString($nuevaHora, "date"),
                        GetSQLValueString(2, "int"),
                        GetSQLValueString(1, "int"),
                        GetSQLValueString(0, "int"),
                        GetSQLValueString(3, "int"),
                        GetSQLValueString($abiertox, "text"),
                        GetSQLValueString($horaapertura, "date"),
                        GetSQLValueString($cod_carrera, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));

                                  $fechaactual=fechaactualbd();
                $insertSQL = sprintf(
                    "/* PARSEADORES1 includes\mtp_betbirdhora.php - QUERY 7 */ INSERT INTO quiencierrayabre 
					(codcarrera, 
					fechaquien, 
					que) 
					VALUES (%s, %s, %s)",
                    GetSQLValueString($cod_carrera, "int"),
                    GetSQLValueString($fechaactual, "date"),
                    GetSQLValueString(12, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));





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
}}}
$file = "betbird2.json";
if (!unlink($file)) {
    echo("Error deleting $file");
} else {
    echo("Deleted $file");
}
?>
</table>
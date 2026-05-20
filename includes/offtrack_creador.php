<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu");
$fecha=fechaactualbd();
$hora=horaactual();
set_time_limit(600);
$fechahora=$fecha.' '.$hora;
echo '.<br>';
echo $fechahora.'<br>';

$query_Recordset1_alertas = sprintf(
        "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 1 */ SELECT * FROM 
alertas
WHERE  
idalertas=19",
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
$urlx='https://us-west-2.aws.data.mongodb-api.com/app/races-bwsnh/endpoint/current_races/v2';

//echo $urlx.'<br>';
$str_datosx = get_url_contents($urlx);
$fulldatosx = json_decode($str_datosx, true);

foreach ($fulldatosx["todaysraces"]["tracks"] as $fulldatosx22) {
//var_dump($fulldatosx22);
echo 'Nombre hipodromo= '.$fulldatosx22["name"].'. Cod confirmacion= '.$fulldatosx22["meetno"].'.<br>';
}

//inicia creacion de carreras
$url = 'https://otb-gw.prod.rushracing.app/adw/programs';
$str_datos = get_url_contents($url);
if (strlen($str_datos) < 20) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 2 */ UPDATE alertas SET contadorfallos=1+contadorfallos
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
        "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 3 */ UPDATE alertas SET contadorfallos=%s
                          WHERE idalertas=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    //fin reinicio de contador de fallos
    
    
    }


}else{
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 4 */ UPDATE alertas SET contadorfallos=0, ultima_bien=%s
                          WHERE idalertas=%s",
        GetSQLValueString($fechahora, "date"),
        GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));


$fulldatos = json_decode($str_datos, true);
//var_dump($fulldatos);
if (isset($fulldatos['0'])) {


    foreach ($fulldatos as $data) {
        if($data["programDate"]==$fecha){
        if($data["currentRaceStatus"]==='OPEN'){
            $data["postTime"]=str_replace('T', ' ', $data["postTime"]); 
            $data["postTime"] = strtotime($data["postTime"]);
            $horaactualservidor=strtotime(horaactual());
            $horaactualservidor = strtotime('+10 hour', $horaactualservidor);
            $tiemporestante=($data["postTime"]-$horaactualservidor)/60;
            $tiemporestante=explode(".", $tiemporestante);
            $numberOfRaces=strtoupper($data["numberOfRaces"]);

            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 5 */ SELECT *
                FROM hipodromo 
                WHERE
                hipodromo.offtrack_sino=1 AND 
                hipodromo.offtrack_cod=%s ",
                GetSQLValueString(strtoupper($data["programName"]), "text")
            );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            echo 'Nombre= '.strtoupper($data["itpTrackName"]).'. Cod= '; echo strtoupper($data["programName"]).'. Carreras= '; echo strtoupper($numberOfRaces).'.<br>';
            if($totalRows_Recordset1>0){

                $query_Recordset2 = sprintf(
                    "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 6 */ SELECT *
                    FROM carrera 
                    WHERE
                    carrera.cod_hipodromo=%s ",
                    GetSQLValueString($row_Recordset1['cod_hipodromo'], "int")
                );
                $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
                $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
if($totalRows_Recordset2=0 OR $numberOfRaces<> $totalRows_Recordset2){
if($numberOfRaces>0){

    $x = 1;

    do {

        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 7 */ SELECT *
            FROM carrera 
            WHERE
            carrera.fec_carrera=%s AND
            carrera.cod_hipodromo=%s AND
            carrera.num_carrera=%s",
            GetSQLValueString($fecha, "date"),
            GetSQLValueString($row_Recordset1['cod_hipodromo'], "int"),
            GetSQLValueString($x, "int")
        );
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
        if($totalRows_Recordset3==0){
            $insertSQL = sprintf("/* PARSEADORES1 includes\offtrack_creador.php - QUERY 8 */ INSERT INTO carrera 
            (cod_banca,
            cod_hipodromo, 
            nom_hipodromo, 
            nom_hipodromo_hpi, 
            fec_carrera, 
            hor_carrera, 
            hor_mtp, 
            num_carrera, 
            est_carrera, 
            est_cierre, 
            est_confirmacion,  
            mtp_control, 					
            can_caballos, 					
            simulcast) 
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
               GetSQLValueString(2, "int"),
               GetSQLValueString($row_Recordset1['cod_hipodromo'], "int"),
               GetSQLValueString($row_Recordset1['nom_hipodromo'], "text"),
               GetSQLValueString($row_Recordset1['nom_hipodromo_hpi'], "text"),
               GetSQLValueString($fecha, "date"),
               GetSQLValueString("01:00:00", "date"),
               GetSQLValueString("01:00:00", "date"),
               GetSQLValueString($x, "int"),
               GetSQLValueString(1, "int"),
               GetSQLValueString(3, "int"),
               GetSQLValueString(1, "int"),
               GetSQLValueString(3, "int"),
               GetSQLValueString(55, "int"),
               GetSQLValueString(0, "int"));
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));


        }
      echo "The number is: $x <br>";
      $x++;
    } while ($x <= $numberOfRaces);
}
}

            }
        }} }}


//fin creacion de carreras

//inicio de crreacion de cantidad de caballos
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 9 */ SELECT * FROM carrera, hipodromo 
	WHERE
	carrera.nom_hipodromo=hipodromo.nom_hipodromo AND
    (carrera.can_caballos>19 OR carrera.can_caballos=0) AND
	carrera.fec_carrera=%s",
    GetSQLValueString($fecha, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($totalRows_Recordset1>0) {
    do {
//    https://otb-gw.prod.rushracing.app/adw/races/v2/2023-11-04/AQD/1

$url='https://otb-gw.prod.rushracing.app/adw/races/v2/'.$fecha.'/'.$row_Recordset1['offtrack_cod'].'/'.$row_Recordset1['num_carrera'];

echo $url.'<br>';
$str_datos = get_url_contents($url);
$str_datos=str_replace('$', '', $str_datos); 
$str_datos=str_replace('1A', '1', $str_datos); 
$str_datos=str_replace('2A', '2', $str_datos); 
$str_datos=str_replace('3A', '3', $str_datos); 
$str_datos=str_replace('1B', '1', $str_datos); 
$str_datos=str_replace('2B', '2', $str_datos); 
$str_datos=str_replace('3B', '3', $str_datos); 
$str_datos=str_replace('1X', '1', $str_datos); 
$str_datos=str_replace('2X', '2', $str_datos); 
$str_datos=str_replace('3X', '3', $str_datos); 
$fulldatos = json_decode($str_datos, true);
//var_dump($fulldatos);

foreach ($fulldatos["runners"] as $fulldatos2) {
    if($fulldatos2["scratched"]==1){
        $RetiradoArray[]=$fulldatos2["programNumber"]; 
    }else{
        $NoRetiradoArray[]=$fulldatos2["programNumber"];
    }
    $todos[]=$fulldatos2["programNumber"];
}
$simulcastdata='.'.$fulldatos["raceCaption"].'.'.$fulldatos["raceDescription"].'.';
echo '$simulcastdata'.$simulcastdata.'<br>';
$simulcast=0;
if(strpos($simulcastdata, 'Simulcast')) {$simulcast=1; }
if(strpos($simulcastdata, 'SIMULCAST')) {$simulcast=1; }
    $NoRetiradoArray = array_unique($NoRetiradoArray);
    echo '<br>$NoRetiradoArray= ';
    var_dump($NoRetiradoArray);
    
    echo '<br>$cantidadcaballos= ';
    $cantidadcaballos=max($todos);
    
    if ($row_Recordset1['can_caballos']<>$cantidadcaballos && $cantidadcaballos>1) {
        $updateSQL = sprintf(
            "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 10 */ UPDATE carrera SET 
            simulcast=%s,
            can_caballos=%s
                                  WHERE cod_carrera=%s",
GetSQLValueString($simulcast, "int"),
            GetSQLValueString($cantidadcaballos, "int"),
            GetSQLValueString($row_Recordset1['cod_carrera'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $simulcast=0;




    } 
    echo '$cantidadcaballos= '.$cantidadcaballos;
    echo '<br><br>';

    if (isset($RetiradoArray)) {
    foreach ($RetiradoArray as $RetiradoArray2) {
echo '$RetiradoArray2= '.$RetiradoArray2.'<br>';
if (in_array($RetiradoArray2, $NoRetiradoArray)) {

    echo 'No Hay que retirarlo<br>';
    }else{



//aqui lod e retirar select y despues insert

$query_Recordset1ret = sprintf(
    "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 11 */ SELECT * FROM retirados 
	WHERE
	num_rcaballo=%s AND
	cod_carrera=%s AND
	fec_retirado>%s LIMIT 1",
    GetSQLValueString($RetiradoArray2, "int"),
    GetSQLValueString($row_Recordset1['cod_carrera'], "int"),
    GetSQLValueString($fecha.' 00:00:01', "date")
);
$Recordset1ret = mysqli_query($conexionbanca, $query_Recordset1ret) or die(mysqli_error($conexionbanca));
$row_Recordset1ret = mysqli_fetch_assoc($Recordset1ret);
$totalRows_Recordset1ret = mysqli_num_rows($Recordset1ret);

if ($totalRows_Recordset1ret==0) {
$insertSQL = sprintf(
    "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 12 */ INSERT INTO retirados 
              (cod_carrera, quienretiro, num_rcaballo) VALUES (%s, %s, %s)",
    GetSQLValueString($row_Recordset1['cod_carrera'], "int"),
    GetSQLValueString('offtrack', "text"),
    GetSQLValueString($RetiradoArray2, "int")
);
$Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
$cod_carrera=$row_Recordset1['cod_carrera'];
$tipoProceso=4;
$num_caballo=$RetiradoArray2;
$fech=$fecha;
include("../includes/procesar_resultados_tickets_ame.php");

$insertSQL = sprintf(
    "/* PARSEADORES1 includes\offtrack_creador.php - QUERY 13 */ INSERT INTO quiencierrayabre 
    (codcarrera, 
    fechaquien, 
    que) 
    VALUES (%s, %s, %s)",
    GetSQLValueString($cod_carrera, "int"),
    GetSQLValueString($fech, "date"),
    GetSQLValueString(32, "int")
);
$Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));


}

        echo 'Hay que retirarlo<br>';
    }


}
echo '<br><br>$RetiradoArray= ';
var_dump($RetiradoArray);

}
echo '<br><br><br>';
unset($RetiradoArray);
unset($NoRetiradoArray);
unset($todos);


sleep(3);
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}




//fin de crreacion de cantidad de caballos
}}
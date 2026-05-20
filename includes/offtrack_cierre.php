<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu");
$fecha=fechaactualbd();
$hora=horaactual();
$fechahora=$fecha.' '.$hora;
echo '.<br>';
echo $fechahora.'<br>';

$query_Recordset1_alertas = sprintf(
        "/* PARSEADORES1 includes\offtrack_cierre.php - QUERY 1 */ SELECT * FROM 
alertas
WHERE  
idalertas=17",
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




//inicio codigo buscar en la base de datos las carreras que se verificaran si seguiran abiertas o se cerraran
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\offtrack_cierre.php - QUERY 2 */ SELECT *
	FROM carrera, hipodromo 
	WHERE
		carrera.cod_hipodromo=hipodromo.cod_hipodromo AND
        carrera.simulcast=0 AND 
		carrera.eje_primero=0 AND 
        carrera.est_carrera=1 AND 
        carrera.est_cierre=2 AND 
        hipodromo.offtrack_sino=1 AND 
        hipodromo.offtrack_num_link>0 AND 

		carrera.fec_carrera=%s",
    GetSQLValueString($fecha, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo 'totalRows_Recordset1= '.$totalRows_Recordset1.'<br>';
//fin codigo buscar en la base de datos las carreras que se verificaran si seguiran abiertas o se cerraran

if($totalRows_Recordset1>0){
//inicia creacion del array de carreras abiertas en la pagina remota
$url = 'https://otb-gw.prod.rushracing.app/adw/programs';
$str_datos = get_url_contents($url);
if (strlen($str_datos) < 20) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_cierre.php - QUERY 3 */ UPDATE alertas SET contadorfallos=1+contadorfallos
                          WHERE idalertas=%s",
        GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    if($row_Recordset1_alertas['contadorfallos']>$row_Recordset1_alertas['cont_fallos_reporte'] && $row_Recordset1_alertas['id_chat_error']<>0 && $tiemporeportar>$row_Recordset1_alertas['ultima_bien']){
        echo 'se envio alerta por contador de fallos<br>';
    $msj=$row_Recordset1_alertas['mensajealerta_error'];
    $msjx=utf8_encode($msj);
    $post=[
    'chat_id'=>$row_Recordset1_alertas['id_chat'],
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
        "/* PARSEADORES1 includes\offtrack_cierre.php - QUERY 4 */ UPDATE alertas SET contadorfallos=%s
                          WHERE idalertas=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    //fin reinicio de contador de fallos
    
    
    }


}else{
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_cierre.php - QUERY 5 */ UPDATE alertas SET contadorfallos=0, ultima_bien=%s
                          WHERE idalertas=%s",
        GetSQLValueString($fechahora, "date"),
        GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
$fulldatos = json_decode($str_datos, true);
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

        $carreras_abiertas_array[] =array(
            "hipodromo"    => strtoupper($data["programName"]),
            "numero_carrera"    => $data["currentRace"],
            "tiempo_para_inicio_min"    => ($tiemporestante[0]+1), 
          );



    } }}}

    //var_dump($carreras_abiertas_array);
//fin creacion del array de carreras abiertas en la pagina remota


}

//aqui inicia el codigo donde las carreras abiertas se verifican
if($totalRows_Recordset1>0){
do {
    $siestadisponibleparabarir=0;
    $veriricartiempo=0;
    foreach ($carreras_abiertas_array as $carreras_abiertas_array2) {
if($carreras_abiertas_array2["hipodromo"]==$row_Recordset1['offtrack_cod'] && $carreras_abiertas_array2["numero_carrera"]==$row_Recordset1['num_carrera']){
    $siestadisponibleparabarir=1;
    $veriricartiempo=1;

    if($veriricartiempo==1){ 
        echo $carreras_abiertas_array2["hipodromo"].'<br>';
        echo $carreras_abiertas_array2["numero_carrera"].'<br>';
            $minute='+'.$carreras_abiertas_array2["tiempo_para_inicio_min"].' minute'; //'+0 minute'
        
            echo $minute.'<br>';
            $hor_carrera = strtotime($minute, strtotime($hora));
            $hor_carrera = date('H:i:s', $hor_carrera);
            echo 'Hora servidor= '.$hora.'. hora de inicio de la carrera= '.$hor_carrera.'<br><br>';
//inicio codigo para verificar tiempo restante y sio faltan menos de 30 segundos agrega 3 minutos
            $faltan=restahoras($hora, $row_Recordset1['hor_carrera']);
            if (($faltan<="00:00:30") or ($row_Recordset1['hor_carrera']<=$hora)) {
                $minutoAnadir=3;
                $segundos_horaInicial=strtotime($hora);
                $segundos_minutoAnadir=$minutoAnadir*60;
                echo $row_Recordset1['hor_carrera'];
                echo "<br/>";
                $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                echo $faltan;
                echo "<br/>";
                echo $nuevaHora;
                echo "<br/>";

                $updateSQL = sprintf(
                    "/* PARSEADORES1 includes\offtrack_cierre.php - QUERY 6 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s 
                              WHERE cod_carrera=%s",
                    GetSQLValueString($nuevaHora, "date"),
                    GetSQLValueString($nuevaHora, "date"),
                    GetSQLValueString($row_Recordset1['cod_carrera'], "int")
                );
                $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
            }

//fin codigo para verificar tiempo restante y sio faltan menos de 30 segundos agrega 3 minutos




            $veriricartiempo=0;



        }


}

    }//final foreach 

    if($siestadisponibleparabarir==0){ //fuera del foreach

        
          //  /*
            $updateSQL = sprintf(
                "/* PARSEADORES1 includes\offtrack_cierre.php - QUERY 7 */ UPDATE carrera SET 
                hor_carrera=%s, 
                hor_mtp=%s, 
                est_carrera=%s, 
                est_cierre=%s, 
                CERRADOX=%s,
                contador_cierres=contador_cierres+1
                                      WHERE cod_carrera=%s",
                GetSQLValueString($hora, "date"),
                GetSQLValueString($hora, "date"),
                GetSQLValueString(0, "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString('offtrack', "text"),
                GetSQLValueString($row_Recordset1['cod_carrera'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));

            $insertSQL = sprintf(
                "/* PARSEADORES1 includes\offtrack_cierre.php - QUERY 8 */ INSERT INTO quiencierrayabre 
                (codcarrera, 
                fechaquien, 
                que) 
                VALUES (%s, %s, %s)",
                GetSQLValueString($row_Recordset1['cod_carrera'], "int"),
                GetSQLValueString($fecha, "date"),
                GetSQLValueString(6, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));


        // */
        

        }



} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}
//fin del codigo donde las carreras abiertas se verifican
}}













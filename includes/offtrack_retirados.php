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
        "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 1 */ SELECT * FROM 
alertas
WHERE  
idalertas=21",
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



$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 2 */ SELECT * FROM carrera, hipodromo 
	WHERE
	carrera.nom_hipodromo=hipodromo.nom_hipodromo AND
	carrera.est_confirmacion=1 AND
	carrera.est_cierre!=3 AND
    hipodromo.offtrack_num_link>0 AND 
    hipodromo.offtrack_sino=1 AND 
	carrera.fec_carrera=%s ORDER BY RAND() LIMIT 5",
    GetSQLValueString($fecha, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
echo 'totalRows_Recordset1= '.$totalRows_Recordset1.'<br>';
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
if (strlen($str_datos) < 20) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 3 */ UPDATE alertas SET contadorfallos=1+contadorfallos
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
        "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 4 */ UPDATE alertas SET contadorfallos=%s
                          WHERE idalertas=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    //fin reinicio de contador de fallos
    
    
    }


}else{
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 5 */ UPDATE alertas SET contadorfallos=0, ultima_bien=%s
                          WHERE idalertas=%s",
        GetSQLValueString($fechahora, "date"),
        GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));


$fulldatos = json_decode($str_datos, true);
//var_dump($fulldatos);


if($fulldatos["status"]=="CANCELED"){


    $nom_hipodro=$row_Recordset1['nom_hipodromo'];
    $num_carrera=$row_Recordset1['num_carrera'];

    $msj='Sistema esta cancelando automaticamente '.$nom_hipodro.' #'.$num_carrera.' por favor verifique que todo este correcto';
    $msjx=utf8_encode($msj);
    $post=[
    'chat_id'=>'-1001639542248',
    'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_exec($ch);
    curl_close($ch);




    $horaactual=horaactual();
    $_POST['est_carrera']=0;
    $_POST['est_cierre']=0;
    $_POST['est_confirmacion']=0;
    $_POST['cod_carrera']=$row_Recordset1['cod_carrera'];
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 6 */ UPDATE carrera 
                              SET 
                              est_carrera=%s, 
                              est_cierre=%s, 
                              est_confirmacion=%s, 
                              hor_carrera=%s, 
                              eje_primero=%s, 
                              div_primero_gan=%s, 
                              div_primero_pla=%s, 
                              div_primero_sho=%s, 
                              eje_segundo=%s, 
                              div_segundo_pla=%s, 
                              div_segundo_sho=%s, 
                              eje_tercero=%s, 
                              div_tercero_sho=%s, 
                              eje_doble_primero=%s, 
                              div_doble_primero_gan=%s, 
                              div_doble_primero_pla=%s, 
                              div_doble_primero_sho=%s, 
                              eje_doble_segundo=%s, 
                              div_doble_segundo_pla=%s, 
                              div_doble_segundo_sho=%s, 
                              eje_doble_tercero=%s, 
                              div_doble_tercero_sho=%s, 
                              eje_triple_primero=%s, 
                              div_triple_primero_gan=%s, 
                              div_triple_primero_pla=%s, 
                              div_triple_primero_sho=%s, 
                              eje_triple_segundo=%s, 
                              div_triple_segundo_pla=%s, 
                              div_triple_segundo_sho=%s, 
                              eje_triple_tercero=%s, 
                              div_triple_tercero_sho=%s,
                              div_exacta=%s,
                              fac_exacta=%s,
                              div_trifecta=%s,
                              fac_trifecta=%s,
                              div_superfecta=%s,
                              fac_superfecta=%s,
                              eje_cuarto=%s,
                              eje_doble_cuarto=%s,
                              eje_triple_cuarto=%s,
                              div_exacta_doble=%s,
                              div_exacta_triple=%s,
                              div_trifecta_doble=%s,
                              div_trifecta_triple=%s,
                              div_superfecta_doble=%s,
                              div_superfecta_triple=%s,
                              ord_exacta=%s,
                              ord_exacta_doble=%s,
                              ord_exacta_triple=%s,
                              ord_trifecta=%s,
                              ord_trifecta_doble=%s,
                              ord_trifecta_triple=%s,
                              ord_superfecta=%s,
                              ord_superfecta_doble=%s,
                              ord_superfecta_triple=%s
                  WHERE cod_carrera=%s",
        GetSQLValueString($_POST['est_carrera'], "int"),
        GetSQLValueString($_POST['est_cierre'], "int"),
        GetSQLValueString($_POST['est_confirmacion'], "int"),
        GetSQLValueString($horaactual, "date"),
        GetSQLValueString(99, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(99, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(99, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString(0, "double"),
        GetSQLValueString("0/0", "text"),
        GetSQLValueString("0/0", "text"),
        GetSQLValueString("0/0", "text"),
        GetSQLValueString("0/0/0", "text"),
        GetSQLValueString("0/0/0", "text"),
        GetSQLValueString("0/0/0", "text"),
        GetSQLValueString("0/0/0/0", "text"),
        GetSQLValueString("0/0/0/0", "text"),
        GetSQLValueString("0/0/0/0", "text"),
        GetSQLValueString($_POST['cod_carrera'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    $carrera=$nom_hipodro." Carr...".$num_carrera;
    $descripcion="CANCELADA <strong>".$carrera."</strong> por: <u> OffTrack Retirados</u>";
    $horaactual=horaactual();
    $fechaactual=fechaactualbd();
    $insertSQL2 = sprintf(
        "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 7 */ INSERT 
                      INTO bitacora 
                      (des_bitacora, hor_bitacora, fec_bitacora) 
                      VALUES (%s, %s, %s)",
        GetSQLValueString($descripcion, "text"),
        GetSQLValueString($horaactual, "date"),
        GetSQLValueString($fechaactual, "date")
    );
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
    mysqli_free_result($Recordset1);
    $tipoProceso=5;
    $cod_carrera=$_POST['cod_carrera'];
    if (is_file('../includes/procesar_resultados_tickets_ame.php')) {
        include("../includes/procesar_resultados_tickets_ame.php");
    }

    $insertSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 8 */ INSERT INTO quiencierrayabre 
        (codcarrera, 
        fechaquien, 
        que) 
        VALUES (%s, %s, %s)",
        GetSQLValueString($row_Recordset1['cod_carrera'], "int"),
        GetSQLValueString($fecha, "date"),
        GetSQLValueString(27, "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca)); 














}




foreach ($fulldatos["runners"] as $fulldatos2) {
    if($fulldatos2["scratched"]==1){
        $RetiradoArray[]=$fulldatos2["programNumber"]; 
    }else{
        $NoRetiradoArray[]=$fulldatos2["programNumber"];
    }
    $todos[]=$fulldatos2["programNumber"];
}

    $NoRetiradoArray = array_unique($NoRetiradoArray);
    echo '<br>$NoRetiradoArray= ';
    var_dump($NoRetiradoArray);
    
    echo '<br>$cantidadcaballos= ';
    $cantidadcaballos=max($todos);

    if ($row_Recordset1['can_caballos']<>$cantidadcaballos) {
        $updateSQL = sprintf(
            "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 9 */ UPDATE carrera SET 
            can_caballos=%s
                                  WHERE cod_carrera=%s",

            GetSQLValueString($cantidadcaballos, "int"),
            GetSQLValueString($row_Recordset1['cod_carrera'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));





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
    "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 10 */ SELECT * FROM retirados 
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
    "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 11 */ INSERT INTO retirados 
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
    "/* PARSEADORES1 includes\offtrack_retirados.php - QUERY 12 */ INSERT INTO quiencierrayabre 
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


sleep(2);
}
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}}
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../Connections/conexionbanca.php');
set_time_limit(0);
//error_reporting(0);
date_default_timezone_set("Pacific/Honolulu");
$fecha=fechaactualbd();
$hora=horaactual();
//parseadores2.us.to/includes/108.json
$fechahora=$fecha.' '.$hora;
echo '.<br>';
echo $fechahora.'<br>';

$query_Recordset1_alertas = sprintf(
        "/* PARSEADORES1 includes\offtrack_confirmacion.php - QUERY 1 */ SELECT * FROM 
alertas
WHERE  
idalertas=20",
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
    "/* PARSEADORES1 includes\offtrack_confirmacion.php - QUERY 2 */ SELECT * 
	FROM 
	hipodromo,
	carrera 
	WHERE
    hipodromo.cod_offtrack_confirmacion > 0 AND
	hipodromo.nom_hipodromo = carrera.nom_hipodromo AND
	carrera.est_confirmacion = 1 AND
	carrera.est_carrera = 0 AND
    hipodromo.offtrack_sino=1 AND 
(carrera.confirmandox = 0 OR carrera.confirmandox = 3) AND	
hipodromo.offtrack_num_link>0 AND 
	carrera.fec_carrera = %s  ORDER BY RAND() LIMIT 7",
    GetSQLValueString('', "text"),
    GetSQLValueString($fecha, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

if($totalRows_Recordset1>0){
    do {
        $num_carrera=($row_Recordset1['num_carrera']-1)/1;
echo '$num_carrera= '.$num_carrera.'<br>';
echo '$totalRows_Recordset1= '.$totalRows_Recordset1.' nom_hipodromo='.$row_Recordset1['nom_hipodromo'].' num_carrera='.$row_Recordset1['num_carrera'].'<br>';
//https://us-west-2.aws.data.mongodb-api.com/app/races-bwsnh/endpoint/current_races/v2 //aqui se ven los link
// https://us-west-2.aws.data.mongodb-api.com/app/races-bwsnh/endpoint/today/v2?meetno=1
//$url = 'parseadores2.us.to/includes/108.json';
$url = 'https://us-west-2.aws.data.mongodb-api.com/app/races-bwsnh/endpoint/today/v2?meetno='.$row_Recordset1['offtrack_num_link'];
echo $url.'<br>';
$str_datos = get_url_contents($url);
$str_datos=str_replace('$', '', $str_datos); 
$str_datos=str_replace('1A', '1', $str_datos); 
$str_datos=str_replace('2A', '2', $str_datos); 
$str_datos=str_replace('3A', '3', $str_datos); 
$str_datos=str_replace('1X', '1', $str_datos); 
$str_datos=str_replace('2X', '2', $str_datos); 
$str_datos=str_replace('3X', '3', $str_datos); 
if (strlen($str_datos) < 20) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_confirmacion.php - QUERY 3 */ UPDATE alertas SET contadorfallos=1+contadorfallos
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
        "/* PARSEADORES1 includes\offtrack_confirmacion.php - QUERY 4 */ UPDATE alertas SET contadorfallos=%s
                          WHERE idalertas=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    //fin reinicio de contador de fallos
    
    
    }


}else{
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\offtrack_confirmacion.php - QUERY 5 */ UPDATE alertas SET contadorfallos=0, ultima_bien=%s
                          WHERE idalertas=%s",
        GetSQLValueString($fechahora, "date"),
        GetSQLValueString($row_Recordset1_alertas['Idalertas'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
$fulldatos = json_decode($str_datos, true);
//var_dump($fulldatos);
//$datoscurl=str_replace('(', 'ZZ', $datoscurl); 
if (isset($fulldatos)) {
  // var_dump($fulldatos["events"][$num_carrera]["results"]["finisher"][0]["programNumber"]);
  //var_dump($fulldatos["events"][$num_carrera]["postTime"]["numberDouble"]);
   // echo '<br><br>';
   if (isset($fulldatos["events"][$num_carrera]["postTime"]["numberDouble"])) {
    echo $fulldatos["events"][$num_carrera]["postTime"]["numberDouble"].'<br>';
    $hor_carrera = date('Y-m-d H:i:s', $fulldatos["events"][$num_carrera]["postTime"]["numberDouble"]); //date('Y-m-d =2023-11-02 Y-m-j=2023-11-2
    $fecha_carrera = date('Y-m-d', $fulldatos["events"][$num_carrera]["postTime"]["numberDouble"]); //date('Y-m-d =2023-11-02 Y-m-j=2023-11-2
    if($fecha_carrera==$fecha){
echo $hor_carrera.'<br>';



if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][0]["programNumber"])) {
if($fulldatos["events"][$num_carrera]["results"]["finisher"][0]["programNumber"]>0){


$eje_primero=$fulldatos["events"][$num_carrera]["results"]["finisher"][0]["programNumber"]; 
$div_primero_gan=$fulldatos["events"][$num_carrera]["results"]["finisher"][0]["winAmount"]; 
if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][0]["placeAmount"])) {
$div_primero_pla=$fulldatos["events"][$num_carrera]["results"]["finisher"][0]["placeAmount"]; 
}else{$div_primero_pla=0; }
if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][0]["showAmount"])) {
$div_primero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][0]["showAmount"]; 
}else{$div_primero_sho=0; }



if($fulldatos["events"][$num_carrera]["results"]["finisher"][0]["programNumber"]==$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["programNumber"]){
    $eje_segundo=0;
    $div_segundo_pla=0;
    $div_segundo_sho=0;

    $eje_doble_primero=0;
    $div_doble_primero_gan=0;
    $div_doble_primero_pla=0;
    $div_doble_primero_sho=0;
//aquii es si es el mismo numero del primero

}else{
if(isset($fulldatos["events"][$num_carrera]["results"]["finisher"][1]["winAmount"]) && $fulldatos["events"][$num_carrera]["results"]["finisher"][1]["winAmount"]>0){
    $eje_doble_primero=$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["programNumber"];
    $div_doble_primero_gan=$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["winAmount"];
    $div_doble_primero_pla=$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["placeAmount"];
    if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][1]["showAmount"])) {
        $div_doble_primero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["showAmount"]; 
        }else{$div_doble_primero_sho=0; }

    //$div_doble_primero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["showAmount"];
     $eje_segundo=99;
     $div_segundo_pla=0;
     $div_segundo_sho=0;

    }else{

     $eje_segundo=$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["programNumber"]; 

     if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][1]["placeAmount"])) {
     $div_segundo_pla=$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["placeAmount"]; 
    }else{$div_segundo_pla=0; }


     //$div_segundo_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["showAmount"]; 

     if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][1]["showAmount"])) {
        $div_segundo_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["showAmount"]; 
        }else{$div_segundo_sho=0; }

     $eje_doble_primero=0;
     $div_doble_primero_gan=0;
     $div_doble_primero_pla=0;
     $div_doble_primero_sho=0;
    }
}


if($fulldatos["events"][$num_carrera]["results"]["finisher"][2]["programNumber"]==$fulldatos["events"][$num_carrera]["results"]["finisher"][0]["programNumber"] || 
$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["programNumber"]==$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["programNumber"]
){


    $eje_tercero=99;
    $div_tercero_sho=0;
    $eje_triple_primero=0;
    $div_triple_primero_gan=0;
    $div_triple_primero_pla=0;
    $div_triple_primero_sho=0;
    $eje_doble_segundo=0;
    $div_doble_segundo_pla=0;
    $div_doble_segundo_sho=0;

}else{
    if(isset($fulldatos["events"][$num_carrera]["results"]["finisher"][2]["winAmount"]) && $fulldatos["events"][$num_carrera]["results"]["finisher"][2]["winAmount"]>0){
        $eje_triple_primero=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["programNumber"];
        $div_triple_primero_gan=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["winAmount"];
        $div_triple_primero_pla=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["placeAmount"];
       // $div_triple_primero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["showAmount"];

        if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][2]["showAmount"])) {
            $div_triple_primero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["showAmount"]; 
            }else{$div_triple_primero_sho=0; }

        $eje_tercero=99;
        $div_tercero_sho=0;
        $eje_doble_segundo=0;
        $div_doble_segundo_pla=0;
        $div_doble_segundo_sho=0;
        }else{
            if(isset($fulldatos["events"][$num_carrera]["results"]["finisher"][2]["placeAmount"]) && $fulldatos["events"][$num_carrera]["results"]["finisher"][2]["placeAmount"]>0){

                $eje_doble_segundo=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["programNumber"]; 
                $div_doble_segundo_pla=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["placeAmount"]; 
                //$div_doble_segundo_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["showAmount"];

                if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][2]["showAmount"])) {
                    $div_doble_segundo_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["showAmount"]; 
                    }else{$div_doble_segundo_sho=0; }

                $eje_tercero=99;
                $div_tercero_sho=0;
                $eje_triple_primero=0;
                $div_triple_primero_gan=0;
                $div_triple_primero_pla=0;
                $div_triple_primero_sho=0;
            }else{
        $eje_tercero=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["programNumber"]; 
       // $div_tercero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["showAmount"]; 
        if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][2]["showAmount"])) {
            $div_tercero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["showAmount"]; 
            }else{$div_tercero_sho=0; }
        $eje_triple_primero=0;
        $div_triple_primero_gan=0;
        $div_triple_primero_pla=0;
        $div_triple_primero_sho=0;
        $eje_doble_segundo=0;
        $div_doble_segundo_pla=0;
        $div_doble_segundo_sho=0;
        } }
    }
    if (!isset($fulldatos["events"][$num_carrera]["results"]["finisher"][3]["programNumber"])) {
        $fulldatos["events"][$num_carrera]["results"]["finisher"][3]["programNumber"]=0;
    }


    if($fulldatos["events"][$num_carrera]["results"]["finisher"][3]["programNumber"]==$fulldatos["events"][$num_carrera]["results"]["finisher"][0]["programNumber"] || 
    $fulldatos["events"][$num_carrera]["results"]["finisher"][3]["programNumber"]==$fulldatos["events"][$num_carrera]["results"]["finisher"][1]["programNumber"] || 
    $fulldatos["events"][$num_carrera]["results"]["finisher"][3]["programNumber"]==$fulldatos["events"][$num_carrera]["results"]["finisher"][2]["programNumber"]
    ){ //aqui verifica que no hay numero duplicado
echo '1111<br>';
        $eje_cuarto=0;
        $eje_triple_segundo=0;
        $div_triple_segundo_pla=0;
        $div_triple_segundo_sho=0;

        $eje_triple_tercero=0;
        $div_triple_tercero_sho=0;

}else{
        if(isset($fulldatos["events"][$num_carrera]["results"]["finisher"][3]["placeAmount"]) && $fulldatos["events"][$num_carrera]["results"]["finisher"][3]["placeAmount"]>0){
            echo '2222<br>';
            $eje_triple_segundo=$fulldatos["events"][$num_carrera]["results"]["finisher"][3]["programNumber"];
            $div_triple_segundo_pla=$fulldatos["events"][$num_carrera]["results"]["finisher"][3]["placeAmount"];
            //$div_triple_segundo_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][3]["showAmount"];
            if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][3]["showAmount"])) {
                $div_triple_segundo_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][3]["showAmount"]; 
                }else{$div_triple_segundo_sho=0; }
            $eje_cuarto=0;


        }else{
            if(isset($fulldatos["events"][$num_carrera]["results"]["finisher"][3]["showAmount"]) && $fulldatos["events"][$num_carrera]["results"]["finisher"][3]["showAmount"]>0){
                $eje_doble_tercero=$fulldatos["events"][$num_carrera]["results"]["finisher"][3]["programNumber"];
                //$div_doble_tercero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][3]["showAmount"];
                if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][3]["showAmount"])) {
                    $div_doble_tercero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][3]["showAmount"]; 
                    }else{$div_doble_tercero_sho=0; }

                echo '33333<br>';


                $eje_cuarto=0;
                $eje_triple_segundo=0;
                $div_triple_segundo_pla=0;
                $div_triple_segundo_sho=0;
            }else{
            $eje_cuarto=$fulldatos["events"][$num_carrera]["results"]["finisher"][3]["programNumber"];
            echo '44444<br>';
            $eje_doble_tercero=0;
            $div_doble_tercero_sho=0;
          
            $eje_triple_segundo=0;
            $div_triple_segundo_pla=0;
            $div_triple_segundo_sho=0;
        }}

        if(isset($fulldatos["events"][$num_carrera]["results"]["finisher"][4]["showAmount"]) && $fulldatos["events"][$num_carrera]["results"]["finisher"][4]["showAmount"]>0){
            $eje_triple_tercero=$fulldatos["events"][$num_carrera]["results"]["finisher"][4]["programNumber"];
           // $div_triple_tercero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][4]["showAmount"];
            if (isset($fulldatos["events"][$num_carrera]["results"]["finisher"][4]["showAmount"])) {
                $div_triple_tercero_sho=$fulldatos["events"][$num_carrera]["results"]["finisher"][4]["showAmount"]; 
                }else{$div_triple_tercero_sho=0; }
           // echo '55555<br>';
        }else{
            $eje_triple_tercero=0;
            $div_triple_tercero_sho=0;
           // echo '66666<br>';
        }

    }


$cAct=0; echo '<br>$cAct '.$cAct.'<br>';
$eje_primero=$eje_primero; echo '$eje_primero '.$eje_primero.'<br>';
$eje_doble_primero=$eje_doble_primero; echo '$eje_doble_primero '.$eje_doble_primero.'<br>';
$eje_triple_primero=$eje_triple_primero; echo '$eje_triple_primero '.$eje_triple_primero.'<br>';

$eje_segundo=$eje_segundo; echo '$eje_segundo '.$eje_segundo.'<br>';
$eje_doble_segundo=$eje_doble_segundo; echo '$eje_doble_segundo '.$eje_doble_segundo.'<br>';
$eje_triple_segundo=$eje_triple_segundo; echo '$eje_triple_segundo '.$eje_triple_segundo.'<br>';

$eje_tercero=$eje_tercero; echo '$eje_tercero '.$eje_tercero.'<br>';
$eje_doble_tercero=$eje_doble_tercero; echo '$eje_doble_tercero '.$eje_doble_tercero.'<br>';
$eje_triple_tercero=$eje_triple_tercero; echo '$eje_triple_tercero '.$eje_triple_tercero.'<br>';

$eje_cuarto=$eje_cuarto; echo '$eje_cuarto '.$eje_cuarto.'<br>';




$div_primero_gan=$div_primero_gan; echo '$div_primero_gan '.$div_primero_gan.'<br>';
$div_doble_primero_gan=$div_doble_primero_gan; echo '$div_doble_primero_gan '.$div_doble_primero_gan.'<br>';
$div_triple_primero_gan=$div_triple_primero_gan; echo '$div_triple_primero_gan '.$div_triple_primero_gan.'<br>';

$div_primero_pla=$div_primero_pla; echo '$div_primero_pla '.$div_primero_pla.'<br>';
$div_doble_primero_pla=$div_doble_primero_pla; echo '$div_doble_primero_pla '.$div_doble_primero_pla.'<br>';
$div_triple_primero_pla=$div_triple_primero_pla; echo '$div_triple_primero_pla '.$div_triple_primero_pla.'<br>';

$div_primero_sho=$div_primero_sho; echo '$div_primero_sho '.$div_primero_sho.'<br>';
$div_doble_primero_sho=$div_doble_primero_sho; echo '$div_doble_primero_sho '.$div_doble_primero_sho.'<br>';
$div_triple_primero_sho=$div_triple_primero_sho; echo '$div_triple_primero_sho '.$div_triple_primero_sho.'<br>';

$div_segundo_pla=$div_segundo_pla; echo '$DivPlaSegLuga '.$div_segundo_pla.'<br>';
$div_doble_segundo_pla=$div_doble_segundo_pla; echo '$div_doble_segundo_pla '.$div_doble_segundo_pla.'<br>';
$div_triple_segundo_pla=$div_triple_segundo_pla; echo '$div_triple_segundo_pla '.$div_triple_segundo_pla.'<br>';

$div_segundo_sho=$div_segundo_sho; echo '$div_segundo_sho '.$div_segundo_sho.'<br>';
$div_doble_segundo_sho=$div_doble_segundo_sho; echo '$div_doble_segundo_sho '.$div_doble_segundo_sho.'<br>';
$div_triple_segundo_sho=$div_triple_segundo_sho; echo '$div_triple_segundo_sho '.$div_triple_segundo_sho.'<br>';

$div_tercero_sho=$div_tercero_sho; echo '$div_tercero_sho '.$div_tercero_sho.'<br>';
$div_doble_tercero_sho=$div_doble_tercero_sho; echo '$div_doble_tercero_sho '.$div_doble_tercero_sho.'<br>';
$div_triple_tercero_sho=$div_triple_tercero_sho; echo '$div_triple_tercero_sho '.$div_triple_tercero_sho.'<br>';
$exa=0;
$exa1=0;
$exa2=0;
$exa3=0;
$tri=0;
$tri1=0;
$tri2=0;
$tri3=0;
$sup=0;
$sup1=0;
$sup2=0;
$sup3=0;
foreach ($fulldatos["events"][$num_carrera]["results"]["dividends"] as $exoticas2) {
if($exoticas2["betType"]=='EX' && $exa==0){
    $div_exacta=$exoticas2["amount"]["numberDouble"];
    $fac_exacta=$exoticas2["baseAmount"]["numberDouble"]/100;
    $ord_exacta=str_replace('-', '/', $exoticas2["finishers"]); 
    echo $div_exacta.'<br>';
    echo $fac_exacta.'<br>';
    echo $ord_exacta.'<br><br>';
    $exa1++;
}
if($exoticas2["betType"]=='EX' && $exa==1){
    $div_exacta_doble=$exoticas2["amount"]["numberDouble"];
    $ord_exacta_doble=str_replace('-', '/', $exoticas2["finishers"]); 
    echo $div_exacta_doble.'<br>';
    echo $ord_exacta_doble.'<br><br>';
    $exa2++;
}

if($exoticas2["betType"]=='EX' && $exa==2){
    $div_exacta_triple=$exoticas2["amount"]["numberDouble"];
    $ord_exacta_triple=str_replace('-', '/', $exoticas2["finishers"]); 
    echo $div_exacta_triple.'<br>';
    echo $ord_exacta_triple.'<br><br>';
    $exa3++;
    
}

if($exoticas2["betType"]=='TR' && $tri==0){
    $div_trifecta=$exoticas2["amount"]["numberDouble"];
    $fac_trifecta=$exoticas2["baseAmount"]["numberDouble"]/100;
    $ord_trifecta=str_replace('-', '/', $exoticas2["finishers"]); 
    echo $div_trifecta.'<br>';
    echo $fac_trifecta.'<br>';
    echo $ord_trifecta.'<br><br>';
    $tri1++;
}
if($exoticas2["betType"]=='TR' && $tri==1){
    $div_trifecta_doble=$exoticas2["amount"]["numberDouble"];
    $ord_trifecta_doble=str_replace('-', '/', $exoticas2["finishers"]); 
    echo $div_trifecta_doble.'<br>';
    echo $ord_trifecta_doble.'<br><br>';
    $tri2++;
}

if($exoticas2["betType"]=='TR' && $tri==2){
    $div_trifecta_triple=$exoticas2["amount"]["numberDouble"];
    $ord_trifecta_triple=str_replace('-', '/', $exoticas2["finishers"]); 
    echo $div_trifecta_triple.'<br>';
    echo $ord_trifecta_triple.'<br><br>';
    $tri3++;
}




if($exoticas2["betType"]=='SU' && $sup==0){
    $div_superfecta=$exoticas2["amount"]["numberDouble"];
    $fac_superfecta=$exoticas2["baseAmount"]["numberDouble"]/100;
    $ord_superfecta=str_replace('-', '/', $exoticas2["finishers"]); 
    echo $div_superfecta.'<br>';
    echo $fac_superfecta.'<br>';
    echo $ord_superfecta.'<br><br>';
    $sup1++;
}
if($exoticas2["betType"]=='SU' && $sup==1){
    $div_superfecta_doble=$exoticas2["amount"]["numberDouble"];
    $ord_superfecta_doble=str_replace('-', '/', $exoticas2["finishers"]); 
    echo $div_superfecta_doble.'<br>';
    echo $ord_superfecta_doble.'<br><br>';
    $sup2++;
}

if($exoticas2["betType"]=='SU' && $sup==2){
    $div_superfecta_triple=$exoticas2["amount"]["numberDouble"];
    $ord_superfecta_triple=str_replace('-', '/', $exoticas2["finishers"]); 
    echo $div_superfecta_triple.'<br>';
    echo $ord_superfecta_triple.'<br><br>';
    $sup3++;
}
if($exa1==1){ $exa++;  } if($exa2==1){ $exa++;  } if($exa3==1){ $exa++;  }
if($tri1==1){ $tri++;  } if($tri2==1){ $tri++;  } if($tri3==1){ $tri++;  }
if($sup1==1){ $sup++;  } if($sup2==1){ $sup++;  } if($sup3==1){ $sup++;  }


echo $exoticas2["betType"].'<br>';
echo $exoticas2["finishers"].'<br>';
echo $exoticas2["baseAmount"]["numberDouble"].'<br>';
echo $exoticas2["amount"]["numberDouble"].'<br><br>';
}

if (!isset($div_exacta_doble)) { $div_exacta_doble=0;  $ord_exacta_doble=0; }
if (!isset($div_exacta_triple)) { $div_exacta_triple=0;  $ord_exacta_triple=0; }

if (!isset($div_trifecta)) { $div_trifecta=0;  $ord_trifecta=0; $fac_trifecta=0; }
if (!isset($div_trifecta_doble)) { $div_trifecta_doble=0;  $ord_trifecta_doble=0; }
if (!isset($div_trifecta_triple)) { $div_trifecta_triple=0;  $ord_trifecta_triple=0; }

if (!isset($div_superfecta)) { $div_superfecta=0;  $ord_superfecta=0; $fac_superfecta=0; }
if (!isset($div_superfecta_doble)) { $div_superfecta_doble=0;  $ord_superfecta_doble=0; }
if (!isset($div_superfecta_triple)) { $div_superfecta_triple=0;  $ord_superfecta_triple=0; }

//"dividends": 
//$div_exacta=0;
//$fac_exacta=0;
//$div_trifecta=0;
//$fac_trifecta=0;
//$div_superfecta=0;
//$fac_superfecta=0;
//$div_exacta_doble=0;
//$div_exacta_triple=0;
//$div_trifecta_doble=0;
//$div_trifecta_triple=0;
//$div_superfecta_doble=0;
//$div_superfecta_triple=0;
//$ord_exacta=0;
//$ord_exacta_doble=0;
//$ord_exacta_triple=0;
//$ord_trifecta=0;
//$ord_trifecta_doble=0;
//$ord_trifecta_triple=0;
//$ord_superfecta=0;
//$ord_superfecta_doble=0;
//$ord_superfecta_triple=0;

$divExotic=0; echo '$divExotic '.$divExotic.'<br>';
$existe=0; echo '$existe '.$existe.'<br>';


$control_dividendo=$row_Recordset1['control_dividendo'];
if(
    $eje_primero==$row_Recordset1['eje_primero']
    && $div_primero_gan==$row_Recordset1['div_primero_gan']
    && $div_primero_pla==$row_Recordset1['div_primero_pla']
    && $div_primero_sho==$row_Recordset1['div_primero_sho']
    && $eje_segundo==$row_Recordset1['eje_segundo']
    && $div_segundo_pla==$row_Recordset1['div_segundo_pla']
    && $div_segundo_sho==$row_Recordset1['div_segundo_sho']
    && $eje_tercero==$row_Recordset1['eje_tercero']
    && $div_tercero_sho==$row_Recordset1['div_tercero_sho']
    && $eje_doble_primero==$row_Recordset1['eje_doble_primero']
    && $div_doble_primero_gan==$row_Recordset1['div_doble_primero_gan']
    && $div_doble_primero_pla==$row_Recordset1['div_doble_primero_pla']
    && $div_doble_primero_sho==$row_Recordset1['div_doble_primero_sho']
    && $eje_doble_segundo==$row_Recordset1['eje_doble_segundo']
    && $div_doble_segundo_pla==$row_Recordset1['div_doble_segundo_pla']
    && $div_doble_segundo_sho==$row_Recordset1['div_doble_segundo_sho']
    && $eje_doble_tercero==$row_Recordset1['eje_doble_tercero']
    && $div_doble_tercero_sho==$row_Recordset1['div_doble_tercero_sho']
    && $eje_triple_primero==$row_Recordset1['eje_triple_primero']
    && $div_triple_primero_gan==$row_Recordset1['div_triple_primero_gan']
    && $div_triple_primero_pla==$row_Recordset1['div_triple_primero_pla']
    && $div_triple_primero_sho==$row_Recordset1['div_triple_primero_sho']
    && $eje_triple_segundo==$row_Recordset1['eje_triple_segundo']
    && $div_triple_segundo_pla==$row_Recordset1['div_triple_segundo_pla']
    && $div_triple_segundo_sho==$row_Recordset1['div_triple_segundo_sho']
    && $eje_triple_tercero==$row_Recordset1['eje_triple_tercero']
    && $div_triple_tercero_sho==$row_Recordset1['div_triple_tercero_sho']
    && $eje_cuarto==$row_Recordset1['eje_cuarto']
    && $div_exacta==$row_Recordset1['div_exacta']
    && $fac_exacta==$row_Recordset1['fac_exacta']
    && $div_trifecta==$row_Recordset1['div_trifecta']
    && $fac_trifecta==$row_Recordset1['fac_trifecta']
    && $div_superfecta==$row_Recordset1['div_superfecta']
    && $fac_superfecta==$row_Recordset1['fac_superfecta']
    && $div_exacta_doble==$row_Recordset1['div_exacta_doble']
    && $div_exacta_triple==$row_Recordset1['div_exacta_triple']
    && $div_trifecta_doble==$row_Recordset1['div_trifecta_doble']
    && $div_trifecta_triple==$row_Recordset1['div_trifecta_triple']
    && $div_superfecta_doble==$row_Recordset1['div_superfecta_doble']
    && $div_superfecta_triple==$row_Recordset1['div_superfecta_triple']
    && $ord_exacta==$row_Recordset1['ord_exacta']
    && $ord_exacta_doble==$row_Recordset1['ord_exacta_doble']
    && $ord_exacta_triple==$row_Recordset1['ord_exacta_triple']
    && $ord_trifecta==$row_Recordset1['ord_trifecta']
    && $ord_trifecta_doble==$row_Recordset1['ord_trifecta_doble']
    && $ord_trifecta_triple==$row_Recordset1['ord_trifecta_triple']
    && $ord_superfecta==$row_Recordset1['ord_superfecta']
    && $ord_superfecta_doble==$row_Recordset1['ord_superfecta_doble']
    && $ord_superfecta_triple==$row_Recordset1['ord_superfecta_triple']

){
    echo '$eje_primero= '.$eje_primero.' eje_primero= '.$row_Recordset1['eje_primero'].' si es igual <br>';
    $control_dividendo=2;
    $hconfir=$hora;
    $est_confirmacion=0;

}else{
    echo '$eje_primero= '.$eje_primero.' eje_primero= '.$row_Recordset1['eje_primero'].' no es igual <br>';
    $control_dividendo=1;
    $hconfir='00:00:00';
    $est_confirmacion=1;
}








 //significa que ya la confirmo


$updateSQL = sprintf(
    "/* PARSEADORES1 includes\offtrack_confirmacion.php - QUERY 6 */ UPDATE carrera 
SET 
confirmandox=%s,
est_confirmacion=%s,
control_dividendo=%s,
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
eje_cuarto=%s,
div_exacta=%s,
fac_exacta=%s,
div_trifecta=%s,
fac_trifecta=%s,
div_superfecta=%s,
fac_superfecta=%s,
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
ord_superfecta_triple=%s,
hconfir=%s

WHERE cod_carrera=%s",
    GetSQLValueString(3, "int"),
    GetSQLValueString($est_confirmacion, "int"),
    GetSQLValueString($row_Recordset1['control_dividendo'], "int"),
    GetSQLValueString($eje_primero, "int"),
    GetSQLValueString($div_primero_gan, "double"),
    GetSQLValueString($div_primero_pla, "double"),
    GetSQLValueString($div_primero_sho, "double"),
    GetSQLValueString($eje_segundo, "int"),
    GetSQLValueString($div_segundo_pla, "double"),
    GetSQLValueString($div_segundo_sho, "double"),
    GetSQLValueString($eje_tercero, "int"),
    GetSQLValueString($div_tercero_sho, "double"),
    GetSQLValueString($eje_doble_primero, "int"),
    GetSQLValueString($div_doble_primero_gan, "double"),
    GetSQLValueString($div_doble_primero_pla, "double"),
    GetSQLValueString($div_doble_primero_sho, "double"),
    GetSQLValueString($eje_doble_segundo, "int"),
    GetSQLValueString($div_doble_segundo_pla, "double"),
    GetSQLValueString($div_doble_segundo_sho, "double"),
    GetSQLValueString($eje_doble_tercero, "int"),
    GetSQLValueString($div_doble_tercero_sho, "double"),
    GetSQLValueString($eje_triple_primero, "int"),
    GetSQLValueString($div_triple_primero_gan, "double"),
    GetSQLValueString($div_triple_primero_pla, "double"),
    GetSQLValueString($div_triple_primero_sho, "double"),
    GetSQLValueString($eje_triple_segundo, "int"),
    GetSQLValueString($div_triple_segundo_pla, "double"),
    GetSQLValueString($div_triple_segundo_sho, "double"),
    GetSQLValueString($eje_triple_tercero, "int"),
    GetSQLValueString($div_triple_tercero_sho, "double"),
    GetSQLValueString($eje_cuarto, "int"),
    GetSQLValueString($div_exacta, "double"),
    GetSQLValueString($fac_exacta, "double"),
    GetSQLValueString($div_trifecta, "double"),
    GetSQLValueString($fac_trifecta, "double"),
    GetSQLValueString($div_superfecta, "double"),
    GetSQLValueString($fac_superfecta, "double"),
    GetSQLValueString($div_exacta_doble, "double"),
    GetSQLValueString($div_exacta_triple, "double"),
    GetSQLValueString($div_trifecta_doble, "double"),
    GetSQLValueString($div_trifecta_triple, "double"),
    GetSQLValueString($div_superfecta_doble, "double"),
    GetSQLValueString($div_superfecta_triple, "double"),
    GetSQLValueString($ord_exacta, "text"),
    GetSQLValueString($ord_exacta_doble, "text"),
    GetSQLValueString($ord_exacta_triple, "text"),
    GetSQLValueString($ord_trifecta, "text"),
    GetSQLValueString($ord_trifecta_doble, "text"),
    GetSQLValueString($ord_trifecta_triple, "text"),
    GetSQLValueString($ord_superfecta, "text"),
    GetSQLValueString($ord_superfecta_doble, "text"),
    GetSQLValueString($ord_superfecta_triple, "text"),
    GetSQLValueString($hconfir, "date"),
    GetSQLValueString($row_Recordset1['cod_carrera'], "int")
);
$Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
$cod_carrera=$row_Recordset1['cod_carrera'];
if ($est_confirmacion==1) {
$insertSQL = sprintf(
"/* PARSEADORES1 includes\offtrack_confirmacion.php - QUERY 7 */ INSERT INTO quiencierrayabre 
(codcarrera, 
fechaquien, 
que) 
VALUES (%s, %s, %s)",
GetSQLValueString($row_Recordset1['cod_carrera'], "int"),
GetSQLValueString($fecha, "date"),
GetSQLValueString(22, "int")
);
$Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca)); }


if ($est_confirmacion==0) {
    $tipoProceso=2;
    include("procesar_resultados_tickets_ame.php");
    echo "<h3><font color='#027BAD'>Proceso de cÃ¡lculo culminado! ".$row_Recordset1['num_carrera']."</font></h3>";


$insertSQL = sprintf(
"/* PARSEADORES1 includes\offtrack_confirmacion.php - QUERY 8 */ INSERT INTO quiencierrayabre 
(codcarrera, 
fechaquien, 
que) 
VALUES (%s, %s, %s)",
GetSQLValueString($row_Recordset1['cod_carrera'], "int"),
GetSQLValueString($fecha, "date"),
GetSQLValueString(27, "int")
);
$Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca)); }
}}}}}}
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}}
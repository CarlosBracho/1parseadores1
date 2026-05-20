<?php
require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();
$horasistema=horaactual();
$fechasistema=fechaactualbd();
$bottoken = "5177777674:AAGLGpVZdN3AfZDLoyOzJLr-CR6CB8QG7jQ";
$website = "https://api.telegram.org/bot".$bottoken;
 
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
 
$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];
$message=str_replace('@sistemaapuestasbot', '', $message);

if($chatId=="-724642930"){

if($message=="/lista"){                
sendMessage($chatId, "muestra todas las funciones /lista
\nmuestra las nacionales abiertas /nacionales");
 }







 if($message=="/nacionales"){ 
        $query_Carrera= sprintf(
                "/* PARSEADORES1 telegram\telegram1.php - QUERY 1 */ SELECT 
                    hipodromo_hnac.nom_hipodromo_hnac,
                    carrera_hnac.num_carrera_hnac,
                    carrera_hnac.cod_carrera_hnac,
                    carrera_hnac.hor_carrera_hnac, 
                    carrera_hnac.est_cierre_hnac,
                    carrera_hnac.est_carrera_hnac
            FROM 
                    carrera_hnac, 
                    hipodromo_hnac
            WHERE
                    carrera_hnac.cod_hipodromo_hnac =  hipodromo_hnac.cod_hipodromo_hnac AND
                    carrera_hnac.fec_carrera_hnac = %s
            ORDER BY 
                    carrera_hnac.num_carrera_hnac",
                GetSQLValueString($fechasistema, "date"));
            $Carrera = mysqli_query($conexionbanca, $query_Carrera) or die(mysqli_error($conexionbanca));
            $row_Carrera = mysqli_fetch_assoc($Carrera);
            $totalRows_Carrera = mysqli_num_rows($Carrera);
            $carreranacabierta='No Hay Carrera Nacionales Abiertas';
            if ($totalRows_Carrera >=1) {
                $carreranacabierta='';
                do {
                        list($h, $m, $s)=restahoraVenta(horaactual(), $row_Carrera['hor_carrera_hnac']);
                        if ($h<23 && $m<59) {
                            $horaactualcarrera=horaactual();
                            $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_carrera_hnac']); ?>
                                            <tr class="brillo">
                                              <td align="left"><?php echo $row_Carrera['nom_hipodromo_hnac']." Carr: ...".$row_Carrera['num_carrera_hnac']; ?></td>
                                              <?php $horaactualcarrera=horaactual();
                            $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_carrera_hnac']);
                            if ($horaactualcarrera>$row_Carrera['hor_carrera_hnac']) {
                                $faltan="00:00:00";
                            } ?>
                                              <td align="left" style="font-size:18px"><strong><?php echo $faltan; ?></strong></td>
                                            </tr>
                                        <?php
                            $f++;
                        } ?>
                <?php
$estadon=' Sin estado definido ';

if($row_Carrera['hor_carrera_hnac']<=horaactual2() && $row_Carrera['est_carrera_hnac']==1 && $row_Carrera['est_cierre_hnac']==3){ $estadon=' Precerrada ';}
if($row_Carrera['hor_carrera_hnac']>horaactual2() && $row_Carrera['est_carrera_hnac']==1 && $row_Carrera['est_cierre_hnac']==3){ $estadon=' Abierta Le quedan '.$faltan;}
if($row_Carrera['est_carrera_hnac']==5 && $row_Carrera['est_cierre_hnac']==5){ $estadon=' Pendiente Por Abrir ';}
if($row_Carrera['est_carrera_hnac']==0 && $row_Carrera['est_cierre_hnac']==1){ $estadon=' Cerrada ';}

$accionn='  ';
$carreranacabierta=$carreranacabierta.chr(10).'--- '.$row_Carrera['nom_hipodromo_hnac']." Carr: ...".$row_Carrera['num_carrera_hnac'].$estadon.$accionn.'  /'.$row_Carrera['cod_carrera_hnac'].'cierre /'.$row_Carrera['cod_carrera_hnac'].'abrir5m ';




                } while ($row_Carrera = mysqli_fetch_assoc($Carrera));
        }
        sendMessage($chatId, $carreranacabierta);


}













 $query_Carrera= sprintf(
        "/* PARSEADORES1 telegram\telegram1.php - QUERY 2 */ SELECT 
            hipodromo_hnac.nom_hipodromo_hnac,
            carrera_hnac.num_carrera_hnac,
            carrera_hnac.cod_carrera_hnac,
            carrera_hnac.hor_carrera_hnac 
    FROM 
            carrera_hnac, 
            hipodromo_hnac
    WHERE
            carrera_hnac.cod_hipodromo_hnac =  hipodromo_hnac.cod_hipodromo_hnac AND
            carrera_hnac.fec_carrera_hnac = %s
    ORDER BY 
            carrera_hnac.hor_carrera_hnac",
        GetSQLValueString($fechasistema, "date"),
        GetSQLValueString($horasistema, "date")
    );
    $Carrera = mysqli_query($conexionbanca, $query_Carrera) or die(mysqli_error($conexionbanca));
    $row_Carrera = mysqli_fetch_assoc($Carrera);
    $totalRows_Carrera = mysqli_num_rows($Carrera);
    $carreranacabierta='No Hay Carrera Nacionales Abiertas';
    if ($totalRows_Carrera >=1) {
        $carreranacabierta='';
        do {
                list($h, $m, $s)=restahoraVenta(horaactual(), $row_Carrera['hor_carrera_hnac']);
                if ($h<11 && $m<59) {
                    $horaactualcarrera=horaactual();
                    $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_carrera_hnac']); ?>
                                    <tr class="brillo">
                                      <td align="left"><?php echo $row_Carrera['nom_hipodromo_hnac']." Carr: ...".$row_Carrera['num_carrera_hnac']; ?></td>
                                      <?php $horaactualcarrera=horaactual();
                    $faltan=restahoras($horaactualcarrera, $row_Carrera['hor_carrera_hnac']);
                    if ($horaactualcarrera>$row_Carrera['hor_carrera_hnac']) {
                        $faltan="00:00:00";
                    } ?>
                                      <td align="left" style="font-size:18px"><strong><?php echo $faltan; ?></strong></td>
                                    </tr>
                                <?php
                    $f++;
                } ?>
        <?php

$carreranacabierta=$carreranacabierta.' '.$row_Carrera['nom_hipodromo_hnac']." Carr: ...".$row_Carrera['num_carrera_hnac'].' /'.$row_Carrera['cod_carrera_hnac'];
$carrera="/".$row_Carrera['cod_carrera_hnac'];

//aqui verifica si la carrera es la correcta
$pos = strpos($message, $row_Carrera['cod_carrera_hnac']);
if($pos !== false){              
        
        



//inicio orden de cierre
$pos2 = strpos($message, 'cierre');

if($pos2 !== false){ 
sendMessage($chatId, "cerrando ".$carreranacabierta.' '.$carrera);
$codcarreraacerrar=str_replace('/', '', $message);

$updateSQL = sprintf(
        "/* PARSEADORES1 telegram\telegram1.php - QUERY 3 */ UPDATE 
                            carrera_hnac 
                          SET 
                          est_carrera_hnac=%s, 
                          est_cierre_hnac=%s, 
                          mtp_control_hnac=%s, 
                          hor_carrera_hnac=%s 
                          WHERE 
                          cod_carrera_hnac = %s",
        GetSQLValueString(0, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString($horasistema, "date"),
        GetSQLValueString($codcarreraacerrar, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}


//fin orden de cierre
    //inicio orden de abrir con 5 minutos


    $pos3 = strpos($message, 'abrir5m');

    if($pos3 !== false){ 
    $messageabrir5m=str_replace('/', '', $message);
  $messageabrir5m=str_replace('abrir5m', '', $messageabrir5m);




        $query_Recordset1 = sprintf(
                "/* PARSEADORES1 telegram\telegram1.php - QUERY 4 */ SELECT 
                            carrera_hnac.cod_carrera_hnac,
                            carrera_hnac.num_carrera_hnac,
                            carrera_hnac.hor_carrera_hnac,
                            hipodromo_hnac.nom_hipodromo_hnac
                            FROM 
                                    carrera_hnac, 
                                    hipodromo_hnac 
                            WHERE 
                            carrera_hnac.cod_carrera_hnac = %s AND
                            carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac",
                GetSQLValueString($messageabrir5m, "int")
            );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            $nom_hipodro=$row_Recordset1['nom_hipodromo_hnac'];
            $num_carrera=$row_Recordset1['num_carrera_hnac'];
            $hor_carrera=$row_Recordset1['hor_carrera_hnac'];
            $statuscarrera=1;
            $statuscierre=3;
            $hora = $hor_carrera;
            $_GET["tempo"]=5;
            $m=abs($_GET["tempo"]);
            if ($_GET["tempo"]==0.5) {
                $min = "00:00:30";
            } else {
                $min = "00:0".$m.":00";
            }
            if ($_GET["tempo"]<0) {
                $horaapertura=MenosHoras($hora, $min);
            } else {
                $horaapertura=SumaHoras($hora, $min);
            }
            $mtp_control=0;
            $updateSQL = sprintf(
                "/* PARSEADORES1 telegram\telegram1.php - QUERY 5 */ UPDATE 
                                    carrera_hnac 
                                    SET 
                                    hor_carrera_hnac=%s, 
                                    hor_carrera_hnac=%s, 
                                    mtp_control_hnac=%s, 
                                    est_carrera_hnac=%s, 
                                    est_cierre_hnac=%s,
                                    est_confirmacion_hnac=%s 
                                    WHERE cod_carrera_hnac=%s",
                GetSQLValueString($horaapertura, "date"),
                GetSQLValueString($horaapertura, "date"),
                GetSQLValueString($mtp_control, "int"),
                GetSQLValueString($statuscarrera, "int"),
                GetSQLValueString($statuscierre, "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString($messageabrir5m, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));







        sendMessage($chatId, "Abriendo si esta cerrada y agregando 5 minutios ");




}
 //fin orden de abrir con 5 minutos
 }



        } while ($row_Carrera = mysqli_fetch_assoc($Carrera));
}








}else{

    sendMessage($chatId, "Comando No Valido".$chatId);
}
 
function sendMessage ($chatId, $message) {
 
        $url = $GLOBALS['website']."/sendMessage?chat_id=".$chatId."&text=".urlencode($message);
        file_get_contents($url);
 
}

?>
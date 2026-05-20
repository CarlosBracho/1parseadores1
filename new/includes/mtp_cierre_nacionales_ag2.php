<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');set_time_limit(0);
$fech=fechaactualbd();
$horasistema=horaactual();
echo $horasistema;
$query_Recordset1 = sprintf("/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 1 */ SELECT * FROM carrera_hnac, hipodromo_hnac WHERE carrera_hnac.cod_hipodromo_hnac=hipodromo_hnac.cod_hipodromo_hnac AND carrera_hnac.est_confirmacion_hnac=0 AND (carrera_hnac.est_carrera_hnac=0 OR carrera_hnac.est_carrera_hnac=1) AND (carrera_hnac.est_cierre_hnac=1 OR carrera_hnac.est_cierre_hnac=3) AND (carrera_hnac.mtp_control_hnac=1 OR carrera_hnac.mtp_control_hnac=2 OR carrera_hnac.mtp_control_hnac=3) AND fec_carrera_hnac=%s", GetSQLValueString($fech, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$nCarrera=$row_Recordset1['num_carrera_hnac'];
$cod_carrera_hnac1=$row_Recordset1['cod_carrera_hnac'];
$xdelaycierre=$row_Recordset1['cierredelay'];
$numeroca=0;
$estadodecarrera=$row_Recordset1['est_carrera_hnac'];
echo $row_Recordset1['hor_carrera_hnac'];
?>
<?php
                    if ($nCarrera>=1) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'http://www.aganador.net.ve/apuestas/demo.php');
                        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language; es-es,en"));
                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                        $result = curl_exec($ch);
                        $data = curl_error($ch);
                        curl_close($ch);

                        preg_match_all("(<div class=\"parte\"><center>Apuestas abiertas para Carrera No. (.*) (.*)<hr>)siU", $result, $matches1);

                        $numeroca = $matches1[1][0];
                    }



?>
<?php

$horaInicial=horaactual();
list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera_hnac']);
$h=$h/1; $m=$m/1; $s=$s/1;

    
if ($nCarrera == $numeroca  && $horaInicial >= $row_Recordset1['hor_carrera_hnac'] && $nCarrera>=1) {
    $minutoAnadir=2;
    $segundos_horaInicial=strtotime($horaInicial);
    $segundos_minutoAnadir=$minutoAnadir*60;
    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
    $row_Recordset1['nom_hipodromo_hnac']." | ".$h.":".$m.".".$s." +2<br/>";
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 2 */ UPDATE carrera_hnac SET hor_carrera_hnac=%s 
											  WHERE cod_carrera_hnac=%s",
        GetSQLValueString($nuevaHora, "date"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    ;
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}

?>

<?php

$horaInicial=horaactual();
list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera_hnac']);
$h=$h/1; $m=$m/1; $s=$s/1;

    
if ($nCarrera == $numeroca  && $h<=0 && $m<=01  && $s<=59 && $nCarrera>=1) {
    $minutoAnadir=2;
    $segundos_horaInicial=strtotime($horaInicial);
    $segundos_minutoAnadir=$minutoAnadir*60;
    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
    $row_Recordset1['nom_hipodromo_hnac']." | ".$h.":".$m.".".$s." +2<br/>";
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 3 */ UPDATE carrera_hnac SET hor_carrera_hnac=%s 
											  WHERE cod_carrera_hnac=%s",
        GetSQLValueString($nuevaHora, "date"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    ;
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}

?>
<?php

if ($nCarrera <> $numeroca && $nCarrera>=1 && $xdelaycierre==5) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 4 */ UPDATE carrera_hnac SET hor_carrera_hnac=%s, est_carrera_hnac=%s,	est_cierre_hnac=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString($horasistema, "date"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($nCarrera <> $numeroca && $nCarrera>=1 && $xdelaycierre==4) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 5 */ UPDATE carrera_hnac SET cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(5, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($nCarrera <> $numeroca && $nCarrera>=1 && $xdelaycierre==3) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 6 */ UPDATE carrera_hnac SET cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(4, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($nCarrera <> $numeroca && $nCarrera>=1 && $xdelaycierre==2) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 7 */ UPDATE carrera_hnac SET cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(3, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($nCarrera <> $numeroca && $nCarrera>=1 && $xdelaycierre==1) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 8 */ UPDATE carrera_hnac SET cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(2, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($nCarrera <> $numeroca && $nCarrera>=1 && $xdelaycierre==0) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 9 */ UPDATE carrera_hnac SET cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>



<?php

if ($nCarrera == $numeroca && horaactual()>=$row_Recordset1['hor_carrera_hnac'] && $nCarrera>=1) {
    $minutoAnadir=2;
    $segundos_horaInicial=strtotime($horaInicial);
    $segundos_minutoAnadir=$minutoAnadir*60;
    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
    $row_Recordset1['nom_hipodromo_hnac']." | ".$h.":".$m.".".$s." +2<br/>";
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 10 */ UPDATE carrera_hnac SET hor_carrera_hnac=%s 
											  WHERE cod_carrera_hnac=%s",
        GetSQLValueString($nuevaHora, "date"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}


?>
<?php

if ($nCarrera == $numeroca && $nCarrera>=1 && $xdelaycierre>=1) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 11 */ UPDATE carrera_hnac SET cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}


?>
<?php

if ($nCarrera == $numeroca && $nCarrera>=1 && $estadodecarrera==0) {
    $minutoAnadir=2;
    $segundos_horaInicial=strtotime($horaInicial);
    $segundos_minutoAnadir=$minutoAnadir*60;
    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);

    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag2.php - QUERY 12 */ UPDATE carrera_hnac SET hor_carrera_hnac=%s, est_carrera_hnac=%s,	est_cierre_hnac=%s, cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString($nuevaHora, "date"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(3, "int"),
        GetSQLValueString(0, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

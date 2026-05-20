<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');set_time_limit(0);
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf("/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ah.php - QUERY 1 */ SELECT * FROM carrera_hnac, hipodromo_hnac WHERE carrera_hnac.cod_hipodromo_hnac=hipodromo_hnac.cod_hipodromo_hnac AND carrera_hnac.est_carrera_hnac=2 AND carrera_hnac.est_cierre_hnac=3 AND (carrera_hnac.mtp_control_hnac=1 OR carrera_hnac.mtp_control_hnac=2 OR carrera_hnac.mtp_control_hnac=4) AND fec_carrera_hnac=%s", GetSQLValueString($fech, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$nHipodro=$row_Recordset1['nom_hipodromo_hnac'];
$nCarrera=$row_Recordset1['num_carrera_hnac'];
$codigo=$row_Recordset1['cod_pagina_accionhipica2']+$nCarrera-1;
$cod_carrera_hnac1=$row_Recordset1['cod_carrera_hnac'];
$nom=('https://hipismoactivo.com/juegos/estado_carrera_server_ganador.php?id_carrera=');
$ape=$codigo;
$jj=($nom."".$ape."");
$xdelaycierre=$row_Recordset1['cierredelay'];
$matches1 = 1;
echo $totalRows_Recordset1;
echo "</br>";
echo $xdelaycierre;
?>
<?php
                    if ($nCarrera>=1) {
                        $ch = curl_init($jj);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                        $result = curl_exec($ch);
                        $matches1 = $result[0];
                    }

$xEstado=$matches1;
?>
<?php
                    if ($xEstado=="1" && $nCarrera>=1 && $xdelaycierre==3) {
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ah.php - QUERY 2 */ UPDATE carrera_hnac SET hor_carrera_hnac=%s, est_carrera_hnac=%s,	est_cierre_hnac=%s 
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

if ($xEstado=="1" && $nCarrera>=1 && $xdelaycierre==2) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ah.php - QUERY 3 */ UPDATE carrera_hnac SET cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(3, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($xEstado=="1" && $nCarrera>=1 && $xdelaycierre==1) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ah.php - QUERY 4 */ UPDATE carrera_hnac SET cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(2, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($xEstado=="1" && $nCarrera>=1 && $xdelaycierre==0) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ah.php - QUERY 5 */ UPDATE carrera_hnac SET cierredelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php
$horaInicial=horaactual();
list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera_hnac']);
$h=$h/1; $m=$m/1; $s=$s/1;

if ($xEstado=="0" && $h<=0 && $m<=01  && $s<=59 && $nCarrera>=1) {
    $minutoAnadir=2;
    $segundos_horaInicial=strtotime($horaInicial);
    $segundos_minutoAnadir=$minutoAnadir*60;
    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
    echo $row_Recordset1['nom_hipodromo_hnac']." | ".$h.":".$m.".".$s." +2<br/>";
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ah.php - QUERY 6 */ UPDATE carrera_hnac SET hor_carrera_hnac=%s 
											  WHERE cod_carrera_hnac=%s",
        GetSQLValueString($nuevaHora, "date"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}

?>
<?php
$horaInicial=horaactual();
list($h, $m, $s)=restahoraVenta(horaactual(), $horaInicial);
$h=$h/1; $m=$m/1; $s=$s/1;

if ($xEstado=="0" && horaactual()>=$row_Recordset1['hor_carrera_hnac'] && $nCarrera>=1) {
    $minutoAnadir=2;
    $segundos_horaInicial=strtotime($horaInicial);
    $segundos_minutoAnadir=$minutoAnadir*60;
    $nuevaHora=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
    echo $row_Recordset1['nom_hipodromo_hnac']." | ".$h.":".$m.".".$s." +2<br/>";
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ah.php - QUERY 7 */ UPDATE carrera_hnac SET hor_carrera_hnac=%s 
											  WHERE cod_carrera_hnac=%s",
        GetSQLValueString($nuevaHora, "date"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}

?>
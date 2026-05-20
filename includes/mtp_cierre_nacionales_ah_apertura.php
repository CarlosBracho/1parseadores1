<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');set_time_limit(0);
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf("/* PARSEADORES1 includes\mtp_cierre_nacionales_ah_apertura.php - QUERY 1 */ SELECT * FROM carrera_hnac, hipodromo_hnac WHERE carrera_hnac.cod_hipodromo_hnac=hipodromo_hnac.cod_hipodromo_hnac AND carrera_hnac.est_carrera_hnac=5 AND carrera_hnac.est_cierre_hnac=5 AND (carrera_hnac.mtp_control_hnac=2 OR carrera_hnac.mtp_control_hnac=4) AND fec_carrera_hnac=%s", GetSQLValueString($fech, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$nHipodro=$row_Recordset1['nom_hipodromo_hnac'];
$nCarrera=$row_Recordset1['num_carrera_hnac'];
$codigo=$row_Recordset1['cod_pagina_accionhipica2']+$nCarrera-1;
$id1=$codigo;
$cod_carrera_hnac1=$row_Recordset1['cod_carrera_hnac'];
$nom=('https://hipismoactivo.com/juegos/estado_carrera_server_ganador.php?id_carrera=');
$ape=$codigo;
$ape2=$codigo-1;
$xdelay=$row_Recordset1['aperturadelay'];
$jj=($nom."".$ape."");
$jj2=($nom."".$ape2."");
$matches1 = 1;
$matches12 = 1;
echo $totalRows_Recordset1;
echo "</br>";
echo $xdelay;
?>
<?php
                    if ($nCarrera>=1) {
                        $ch = curl_init($jj);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                        $result = curl_exec($ch);
                        $matches1 = $result[0];


                        $ch2 = curl_init($jj2);
                        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch2, CURLOPT_AUTOREFERER, true);
                        $result2 = curl_exec($ch2);
                        $matches12 = $result2[0];
                    }



$xEstado=$matches1;

$xEstadoanteriol=$matches12;
echo "</br>";
echo "Estado";
echo "</br>";
echo $xEstado;
echo "</br>";
echo "Estadoanteriol";
echo "</br>";
echo $xEstadoanteriol;
echo "</br>";
echo "codigp";
echo $codigo;
?>
<?php

if ($xEstado=="0" && $xEstadoanteriol=="1" && $nCarrera>=1 && $xdelay==6) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\mtp_cierre_nacionales_ah_apertura.php - QUERY 2 */ UPDATE carrera_hnac SET est_carrera_hnac=%s,	est_cierre_hnac=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString(3, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($xEstado=="0" && $xEstadoanteriol=="1" && $nCarrera>=1 && $xdelay==5) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\mtp_cierre_nacionales_ah_apertura.php - QUERY 3 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(6, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

<?php

if ($xEstado=="0" && $xEstadoanteriol=="1" && $nCarrera>=1 && $xdelay==4) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\mtp_cierre_nacionales_ah_apertura.php - QUERY 4 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(5, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

<?php

if ($xEstado=="0" && $xEstadoanteriol=="1" && $nCarrera>=1 && $xdelay==3) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\mtp_cierre_nacionales_ah_apertura.php - QUERY 5 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(4, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

<?php

if ($xEstado=="0" && $xEstadoanteriol=="1" && $nCarrera>=1 && $xdelay==2) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\mtp_cierre_nacionales_ah_apertura.php - QUERY 6 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(3, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($xEstado=="0" && $xEstadoanteriol=="1" && $nCarrera>=1 && $xdelay==1) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\mtp_cierre_nacionales_ah_apertura.php - QUERY 7 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(2, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

<?php

if ($xEstado=="0" && $xEstadoanteriol=="1" && $nCarrera>=1 && $xdelay==0) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 includes\mtp_cierre_nacionales_ah_apertura.php - QUERY 8 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');set_time_limit(0);
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf("/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag_apertura_rin.php - QUERY 1 */ SELECT * FROM carrera_hnac, hipodromo_hnac WHERE carrera_hnac.cod_hipodromo_hnac=hipodromo_hnac.cod_hipodromo_hnac AND carrera_hnac.est_carrera_hnac=5 AND carrera_hnac.est_cierre_hnac=5 AND carrera_hnac.mtp_control_hnac=6 AND fec_carrera_hnac=%s", GetSQLValueString($fech, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$nCarrera=$row_Recordset1['num_carrera_hnac'];
$cod_carrera_hnac1=$row_Recordset1['cod_carrera_hnac'];
$xdelay=$row_Recordset1['aperturadelay'];
$numeroca=0;

?>
<?php
                    if ($nCarrera>=1) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'http://www.aganador.net.ve/apuestas_rin/demo.php');
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

if ($nCarrera == $numeroca && $nCarrera>=1 && $xdelay==6) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag_apertura_rin.php - QUERY 2 */ UPDATE carrera_hnac SET est_carrera_hnac=%s,	est_cierre_hnac=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString(3, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($nCarrera == $numeroca && $nCarrera>=1 && $xdelay==5) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag_apertura_rin.php - QUERY 3 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(6, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

<?php

if ($nCarrera == $numeroca && $nCarrera>=1 && $xdelay==4) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag_apertura_rin.php - QUERY 4 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(5, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

<?php

if ($nCarrera == $numeroca && $nCarrera>=1 && $xdelay==3) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag_apertura_rin.php - QUERY 5 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(4, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

<?php

if ($nCarrera == $numeroca && $nCarrera>=1 && $xdelay==2) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag_apertura_rin.php - QUERY 6 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(3, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>
<?php

if ($nCarrera == $numeroca && $nCarrera>=1 && $xdelay==1) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag_apertura_rin.php - QUERY 7 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(2, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

<?php

if ($nCarrera == $numeroca && $nCarrera>=1 && $xdelay==0) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\mtp_cierre_nacionales_ag_apertura_rin.php - QUERY 8 */ UPDATE carrera_hnac SET aperturadelay=%s 
										  WHERE cod_carrera_hnac=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString($cod_carrera_hnac1, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
}
?>

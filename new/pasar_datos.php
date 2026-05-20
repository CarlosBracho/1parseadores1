<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('./Connections/conexionbanca.php');
set_time_limit(0);
$query_Recordset1 = sprintf("/* PARSEADORES1 new\pasar_datos.php - QUERY 1 */ SELECT 
ta.nom_taquilla, ta.cod_taquilla, tp.por_taquilla
 FROM taquilla ta, taquilla_opc_ame tp
WHERE tp.por_taquilla > 0 AND tp.cod_taquilla=ta.cod_taquilla LIMIT 99999");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    echo $totalRows_Recordset1;
    echo "<br/>";

    do {
        echo $row_Recordset1['nom_taquilla'];
        echo "<br/>";


        $updateSQL = sprintf(
            "/* PARSEADORES1 new\pasar_datos.php - QUERY 2 */ UPDATE taquilla SET taq_por_ame=%s
                                                          WHERE cod_taquilla=%s",
            GetSQLValueString($row_Recordset1['por_taquilla'], "double"),
            GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

mysqli_free_result($Recordset1);
    echo "<br/>";	echo "<br/>";	echo "<br/>";	echo "<br/>";	echo "<br/>";
?>
<?php
$query_Recordset2 = sprintf("/* PARSEADORES1 new\pasar_datos.php - QUERY 3 */ SELECT 
ta.nom_taquilla, ta.cod_taquilla, tpn.cob_taquilla_hnac
 FROM taquilla ta, taquilla_opc_hnac tpn
WHERE tpn.cob_taquilla_hnac > 0 AND tpn.cod_taquilla = ta.cod_taquilla LIMIT 99999");
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    echo $totalRows_Recordset2;
    echo "<br/>";

    do {
        echo $row_Recordset2['nom_taquilla'];
        echo "<br/>";


        $updateSQL = sprintf(
            "/* PARSEADORES1 new\pasar_datos.php - QUERY 4 */ UPDATE taquilla SET taq_cob_hnac=%s
                                                          WHERE cod_taquilla=%s",
            GetSQLValueString($row_Recordset2['cob_taquilla_hnac'], "double"),
            GetSQLValueString($row_Recordset2['cod_taquilla'], "int")
        );
        $Result2 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));

mysqli_free_result($Recordset2);
    echo "<br/>";	echo "<br/>";	echo "<br/>";	echo "<br/>";	echo "<br/>";
?>
<?php
$query_Recordset2 = sprintf("/* PARSEADORES1 new\pasar_datos.php - QUERY 5 */ SELECT 
ta.nom_taquilla, ta.cod_taquilla, tpn.est_taquilla_hnac
 FROM taquilla ta, taquilla_opc_hnac tpn
WHERE tpn.est_taquilla_hnac > 0 AND tpn.cod_taquilla = ta.cod_taquilla LIMIT 99999");
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    echo $totalRows_Recordset2;
    echo "<br/>";

    do {
        echo $row_Recordset2['nom_taquilla'];
        echo "<br/>";


        $updateSQL = sprintf(
            "/* PARSEADORES1 new\pasar_datos.php - QUERY 6 */ UPDATE taquilla SET taq_vende_hnac=%s
                                                          WHERE cod_taquilla=%s",
            GetSQLValueString($row_Recordset2['est_taquilla_hnac'], "double"),
            GetSQLValueString($row_Recordset2['cod_taquilla'], "int")
        );
        $Result2 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));

mysqli_free_result($Recordset2);
    echo "<br/>";	echo "<br/>";	echo "<br/>";	echo "<br/>";	echo "<br/>";
?>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$query_Recordset10 = sprintf(
    "/* PARSEADORES1 new\includes\confirma_dividendos_hnac.php - QUERY 1 */ SELECT hi.nom_hipodromo_hnac, ca.num_carrera_hnac, hi.cod_hipodromo_hnac, ca.fec_carrera_hnac 
FROM carrera_hnac ca, hipodromo_hnac hi
WHERE ca.cod_carrera_hnac=%s AND hi.cod_hipodromo_hnac=ca.cod_hipodromo_hnac LIMIT 1",
    GetSQLValueString($_POST['rA'], "int")
);
$Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
$row_Recordset10 = mysqli_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysqli_num_rows($Recordset10);
if ($totalRows_Recordset10>0) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\confirma_dividendos_hnac.php - QUERY 2 */ UPDATE carrera_hnac SET est_confirmacion_hnac=%s WHERE cod_carrera_hnac=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString($_POST['rA'], "int")
    );
    
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    $mensaje="<font color='#FF0000'>".$row_Recordset10['nom_hipodromo_hnac']." Carr...".$row_Recordset10['num_carrera_hnac']." CONFIRMADA</font>";
} else {
    $mensaje="<font color='#FF0000'>HUBO UN ERROR! Recargue la página y vuelva a intentarlo</font>";
}
mysqli_free_result($Recordset10);
echo $mensaje;
echo "<br/>";
if ($totalRows_Recordset10>0) {
    if (is_file('../includes/procesar_ticket_hnac.php')) {
        include("../includes/procesar_ticket_hnac.php");
    }
    echo " Proceso de cálculo culminado!";
}

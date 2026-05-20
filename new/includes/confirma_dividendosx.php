<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\includes\confirma_dividendosx.php - QUERY 1 */ SELECT nom_hipodromo, num_carrera FROM carrera WHERE cod_carrera=%s",
    GetSQLValueString($_POST['rA'], "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($totalRows_Recordset1>0) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\includes\confirma_dividendosx.php - QUERY 2 */ UPDATE carrera SET est_confirmacion=%s WHERE cod_carrera=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($_POST['rA'], "int")
    );
    
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    $mensaje="<font color='#FF0000'>".$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera']." CONFIRMADA</font>";
} else {
    $mensaje="<font color='#FF0000'>HUBO UN ERROR! Recargue la página y vuelva a intentarlo</font>";
}
mysqli_free_result($Recordset1);
echo $mensaje;

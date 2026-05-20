<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$query_Recordset15 = sprintf(
    "/* PARSEADORES1 includes\confirma_dividendos.php - QUERY 1 */ SELECT nom_hipodromo, num_carrera FROM carrera WHERE cod_carrera=%s",
    GetSQLValueString($_POST['rA'], "int")
);
$Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
$row_Recordset15 = mysqli_fetch_assoc($Recordset15);
$totalRows_Recordset15 = mysqli_num_rows($Recordset15);
if ($totalRows_Recordset15>0) {
    $updateSQL15 = sprintf(
        "/* PARSEADORES1 includes\confirma_dividendos.php - QUERY 2 */ UPDATE carrera SET est_confirmacion=%s WHERE cod_carrera=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($_POST['rA'], "int")
    );
    
    $Result15 = mysqli_query($conexionbanca, $updateSQL15) or die(mysqli_error($conexionbanca));
    $carrera=$row_Recordset15['nom_hipodromo']." Carr...".$row_Recordset15['num_carrera'];
    $mensaje="<font color='#FF0000'>".$carrera." CONFIRMADA</font><br/>";
    $cod_carrera=$_POST['rA'];
    $tipoProceso=2;
    if (is_file('../includes/procesar_resultados_tickets_ame.php')) {
        include("../includes/procesar_resultados_tickets_ame.php");
    }
    echo "<h4><font color='#027BAD'>Cálculo culminado! ".$carrera."</font></h4>";
} else {
    $mensaje="<font color='#FF0000'>HUBO UN ERROR! Recargue la página y vuelva a intentarlo</font>";
}
mysqli_free_result($Recordset15);
echo $mensaje;

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$fechasistema=fechaactualbd();
$horasistema=horaactual();
$query_Recordset12 = sprintf("
/* PARSEADORES1 includes\admin_nuevoMen.php - QUERY 1 */ SELECT * 
FROM 
chat2
WHERE sentdate=%s AND tipo=%s AND recd=1
LIMIT 1", GetSQLValueString($fechasistema, "date"), GetSQLValueString(0, "int"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);
if ($totalRows_Recordset12==1) {
    //echo $totalRows_Recordset12;
    echo '<i class="fa fa-bell"></i>';
    echo '<script>';
    echo '$("#nuevoMen").css("display","block");'; ?>
	alertify.success('<font size="4">Usted tiene algun(os) mensaje(s) sin responder!</font>');
    <?php
    echo '</script>';
} else {
    //echo $totalRows_Recordset12;
    echo '<script>';
    echo '$("#nuevoMen").css("display","none");';
    echo '</script>';
}
?>


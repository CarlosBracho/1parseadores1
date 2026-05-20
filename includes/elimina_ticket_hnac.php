<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1 = "0";
$xserTic="";
$xnroTicket="";
if (isset($_POST["cTic"])) {
    $numerotiket2=substr($_POST['cTic'], 2, strlen($_POST['cTic'])-2);
    $serial=substr($_POST['cTic'], 0, 2);
}
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 includes\elimina_ticket_hnac.php - QUERY 1 */ SELECT num_ticket_hnac, id_usuario 
	FROM 
	venta_hnac 
	WHERE 
	venta_hnac.ticket_hnac = %s",
    GetSQLValueString($numerotiket2, "int")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$y=0;
if ($totalRows_Recordset3>0) {
    do {
        $nTicket[]=$row_Recordset3['num_ticket_hnac'];
        $y++;
    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
    $x=0;
    $fec_pago=fechaactualbd();
    $horaPago=horaactual();
    $est_ticket="0";
    do {
        $updateSQL3 = sprintf(
            "/* PARSEADORES1 includes\elimina_ticket_hnac.php - QUERY 2 */ UPDATE venta_hnac SET est_ticket_hnac=%s, fec_pago_hnac=%s, hor_pago_hnac=%s 
					WHERE num_ticket_hnac=%s",
            GetSQLValueString($est_ticket, "int"),
            GetSQLValueString($fec_pago, "date"),
            GetSQLValueString($horaPago, "date"),
            GetSQLValueString($nTicket[$x], "int")
        );
        
        $Result3 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));
        $x++;
    } while ($x < $y);
}
mysqli_free_result($Recordset3);

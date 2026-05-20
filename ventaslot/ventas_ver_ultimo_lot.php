<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$usuario=$_SESSION['MM_id_usuario'];
$FechaTxt=fechaactualbd();
$query_Recordset12 = sprintf("/* PARSEADORES1 ventaslot\ventas_ver_ultimo_lot.php - QUERY 1 */ SELECT ticket_lot FROM venta_lot WHERE id_usuario = %s AND fec_venta_lot = %s AND est_ticket_lot >= 0 AND est_ticket_lot <= 1 AND tip_loteria_lot <= 3
ORDER BY num_ticket_lot DESC LIMIT 1", GetSQLValueString($usuario, "int"), GetSQLValueString($FechaTxt, "date"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);
$xTicket_Recordset1=$row_Recordset12['ticket_lot'];
$query_Recordset11 = sprintf(
    "/* PARSEADORES1 ventaslot\ventas_ver_ultimo_lot.php - QUERY 2 */ SELECT ser_ticket_lot, est_ticket_lot, mon_apuesta_lot,
	SUM(mon_apuesta_lot) AS tot_apuesta
FROM 
venta_lot ve,
usuario us,
taquilla ta
WHERE 
ve.ticket_lot = %s AND
ve.id_usuario = %s AND
ve.fec_venta_lot = %s AND
us.id_usuario = ve.id_usuario AND
us.cod_taquilla = ta.cod_taquilla 
ORDER BY ve.tip_loteria_lot",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
    GetSQLValueString($FechaTxt, "date")
);
$Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
$row_Recordset11 = mysqli_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysqli_num_rows($Recordset11);
if ($totalRows_Recordset11>0 && $row_Recordset11['tot_apuesta']>0) {
    $serial=$row_Recordset11['ser_ticket_lot'];
    $rest = substr($serial, 0, 2);
    $rest = $rest.$xTicket_Recordset1;
    $estadoTicket=$row_Recordset11['est_ticket_lot'];
    echo '<div id="men_pagar" style="width:265px; float:left; height:18px;background: #333;padding:3px 0px 0px 0px;">';
    echo " Cod: ".$rest." Monto:".$row_Recordset11['tot_apuesta'];
    echo '</div>';
    echo '<div id="men_pagar" style="font-size:12px;width:100%;float:left;height:28px;text-align:right;">';
    if ($estadoTicket==1) { ?>
			<input type="button" style="width:85px; font-size:10px; height:24px" title=" reimprimir último ticket "
            value="REIMPRIMIR" onclick="javascript:window.open('../ventaslot/ventas_reimprimir_ultimo_lot.php?tID=1','_blank','width=230,height=620,left=0, top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes');return false;"/>
	<?php
        }
    if ($estadoTicket==0) {
        echo '<font color="red" style="background:#000">&nbsp;&nbsp;ELIMINADO&nbsp;&nbsp;</font>';
    }
    echo '</div>';
}
?>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$usuario=$_SESSION['MM_id_usuario'];
$FechaTxt=fechaactualbd();
$query_Recordset12 = sprintf("/* PARSEADORES1 new\ventashnac_mie\ventas_ver_ultimo.php - QUERY 1 */ SELECT ticket_hnac FROM venta_hnac WHERE id_usuario = %s AND fec_venta_hnac = %s AND est_ticket_hnac >= 0 AND est_ticket_hnac <= 1
ORDER BY num_ticket_hnac DESC LIMIT 1", GetSQLValueString($usuario, "int"), GetSQLValueString($FechaTxt, "date"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);
$xTicket_Recordset1=$row_Recordset12['ticket_hnac'];
$query_Recordset11 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\ventas_ver_ultimo.php - QUERY 2 */ SELECT 
venta_hnac.fec_venta_hnac, 
venta_hnac.hor_venta_hnac,
venta_hnac.ser_venta_hnac,
venta_hnac.can_ticket_hnac,
venta_hnac.num_caballo_hnac,
venta_hnac.ip_venta_hnac,
venta_hnac.ticket_hnac,
venta_hnac.cod_tventa_hnac,
venta_hnac.mon_venta_hnac,
venta_hnac.est_ticket_hnac,
venta_hnac.efectivoOn,
usuario.nom_usuario,
usuario.cod_barra,
taquilla.nom_taquilla,
hipodromo_hnac.nom_hipodromo_hnac,
carrera_hnac.num_carrera_hnac,
carrera_hnac.hor_carrera_hnac,
carrera_hnac.est_carrera_hnac
FROM 
venta_hnac,
carrera_hnac,
hipodromo_hnac,
usuario,
taquilla 
WHERE 
venta_hnac.ticket_hnac = %s AND
venta_hnac.id_usuario = %s AND
venta_hnac.fec_venta_hnac = %s AND
carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
usuario.id_usuario = venta_hnac.id_usuario AND
usuario.cod_taquilla = taquilla.cod_taquilla AND
hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac
ORDER BY venta_hnac.cod_tventa_hnac",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
    GetSQLValueString($FechaTxt, "date")
);
$Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
$row_Recordset11 = mysqli_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysqli_num_rows($Recordset11);
$efectivoOn=$row_Recordset11['efectivoOn'];
if ($totalRows_Recordset11>0) {
    $serial=$row_Recordset11['ser_venta_hnac'];
    $rest = substr($serial, 0, 2);
    $rest = $rest.$xTicket_Recordset1;
    $estadoTicket=$row_Recordset11['est_ticket_hnac'];
    $estadoCarrer=$row_Recordset11['est_carrera_hnac'];
    echo '<div id="men_pagar" style="width:99%; float:left; height:50px;background: #333;padding:3px 0px 0px 0px;">';
    echo $row_Recordset11['nom_hipodromo_hnac']."...".$row_Recordset11['num_carrera_hnac']." Cod: ".$rest." ";
    echo"<br/>";
    do {
        echo "|N:".$row_Recordset11['num_caballo_hnac']." ";
        echo ObtenerNombreApuesta($row_Recordset11['cod_tventa_hnac']);
        echo " ".$row_Recordset11['mon_venta_hnac']."";
    } while ($row_Recordset11 = mysqli_fetch_assoc($Recordset11));
    echo '</br>';
    if ($efectivoOn==0) {
        echo 'APOSTADO POR BSS';
    }
    if ($efectivoOn==1) {
        echo 'APOSTADO POR DEBITO BSS';
    }
    if ($efectivoOn==2) {
        echo 'APOSTADO POR TRANSFERENCIA BSS';
    }
    if ($efectivoOn==3) {
        echo 'APOSTADO POR DOLAR AMERICANO';
    }
    if ($efectivoOn==4) {
        echo 'APOSTADO POR PESO COLOMBIANO';
    }
    if ($efectivoOn==5) {
        echo 'APOSTADO POR SOLES PERUANOS';
    }
    echo '</div>';
    echo '<div id="men_pagar" style="font-size:12px;width:100%;float:left;height:28px;text-align:right;padding:5px 0px 0px 0px;">';
    if ($estadoTicket==1) { ?>
			<input type="button" style="width:85px; font-size:10px; height:24px" title=" reimprimir último ticket "
            value="REIMPRIMIR" onclick="javascript:window.open('../ventashnac_mie/ventas_reimprimir_ultimo_hnac.php','_blank','width=230,height=620,left=0, top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes');return false;"/>
	<?php
        }
    if ($estadoTicket==0 && $estadoCarrer==1) {
        echo '<font color="red" style="background:#000">&nbsp;&nbsp;ELIMINADA&nbsp;&nbsp;</font>';
    }
    echo '</div>';
}
?>
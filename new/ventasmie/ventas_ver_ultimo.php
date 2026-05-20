<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$usuario=$_SESSION['MM_id_usuario'];
$FechaTxt=fechaactualbd();
$query_Recordset2 = sprintf("/* PARSEADORES1 new\ventasmie\ventas_ver_ultimo.php - QUERY 1 */ SELECT ticket FROM venta 
WHERE venta.id_usuario = %s AND venta.fec_venta = %s AND est_ticket >= 0 AND est_ticket <= 1
ORDER BY venta.num_ticket DESC LIMIT 1", GetSQLValueString($usuario, "int"), GetSQLValueString($FechaTxt, "date"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$xTicket_Recordset1=$row_Recordset2['ticket'];
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventasmie\ventas_ver_ultimo.php - QUERY 2 */ SELECT 
venta.fec_venta, 
venta.hor_venta,
venta.ser_venta,
venta.cod_cliente,
venta.tra_codigo,
venta.can_ticket,
venta.num_caballo,
venta.ip_venta,
venta.ticket,
venta.cod_tventa,
venta.mon_venta,
venta.est_ticket,
venta.efectivoO,
usuario.nom_usuario,
usuario.cod_barra,
taquilla.nom_taquilla,
carrera.nom_hipodromo,
carrera.num_carrera,
carrera.hor_carrera,
carrera.est_carrera
FROM 
venta,
carrera,
usuario,
taquilla 
WHERE 
venta.ticket = %s AND
venta.id_usuario = %s AND
venta.fec_venta = %s AND
carrera.cod_carrera = venta.cod_carrera AND
usuario.id_usuario = venta.id_usuario AND
usuario.cod_taquilla = taquilla.cod_taquilla
ORDER BY venta.cod_tventa",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
    GetSQLValueString($FechaTxt, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$efectivoO=$row_Recordset1['efectivoO']/1;
if ($totalRows_Recordset1>0) {
    $serial=$row_Recordset1['ser_venta'];
    $rest = substr($serial, 0, 3);
    $estadoTicket=$row_Recordset1['est_ticket'];
    $estadoCarrer=$row_Recordset1['est_carrera'];
    $cod_cliente=$row_Recordset1['cod_cliente'];
    $tra_codigo=$row_Recordset1['tra_codigo'];
    if ($tra_codigo==1) {
        $rest=$cod_cliente;
    }
    //echo $estadoTicket;
    echo '<div id="men_pagar" style="width:280px; float:left; height:30px;background: #333;padding:3px 0px 0px 0px;">';
    echo $row_Recordset1['nom_hipodromo']."...".$row_Recordset1['num_carrera']." Cod: ".$rest." ";
    echo"  ";
    do {
        echo "|N:".$row_Recordset1['num_caballo']." ";
        echo ObtenerNombreApuesta($row_Recordset1['cod_tventa']);
        echo " ".$row_Recordset1['mon_venta']."";
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    echo " </br>";
    if ($efectivoO==0) {
        echo 'APOSTADO POR BSS';
    }
    if ($efectivoO==1) {
        echo 'APOSTADO POR DEBITO BSS';
    }
    if ($efectivoO==2) {
        echo 'APOSTADO POR TRANSFERENCIA BSS';
    }
    if ($efectivoO==3) {
        echo 'APOSTADO POR DOLAR AMERICANO';
    }
    if ($efectivoO==4) {
        echo 'APOSTADO POR PESO COLOMBIANO';
    }
    if ($efectivoO==5) {
        echo 'APOSTADO POR SOLES PERUANOS';
    }
    echo '</div>';
    echo '<div id="men_pagar" style="font-size:12px;width:90px;float:left;height:28px;text-align:center;padding:5px 0px 0px 0px;background: #333;">';
    if ($estadoTicket==1) {
        if ($tra_codigo==1) {
            $valor="VER";
        } else {
            $valor="REIMPRIMIR";
        } ?>
			<input type="button" style="width:85px; font-size:10px; height:24px" value="<?php echo $valor; ?>" 
            onclick="javascript:window.open('../ventasmie/ventas_reimprimir_ultimo.php','_blank','width=200,height=620,left=0, top=0,toolbar=no,menubar=no,scrollbars=no,status=no,Aresizable=no,location=no,fullscreen=no,dependent=yes');return false;"/>
	<?php
    }
    if ($estadoTicket==0 && $estadoCarrer==1) {
        echo '<font color="red">ELIMINADA</font>';
    }
    echo '</div>';
}
?>
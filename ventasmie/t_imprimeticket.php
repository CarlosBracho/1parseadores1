<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$xTicket_Recordset1=0;
$usuario_venta=0;
if (isset($_GET["recordID"]) && isset($_GET["uVenta"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
    $usuario_venta = $_GET["uVenta"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventasmie\t_imprimeticket.php - QUERY 1 */ SELECT 
venta.fec_venta, 
venta.hor_venta,
venta.ser_venta,
venta.can_ticket,
venta.num_caballo,
venta.ip_venta,
venta.ticket,
venta.cod_tventa,
venta.mon_venta,
venta.efectivoO,
usuario.nom_completo,
usuario.cod_barra,
taquilla.nom_taquilla,
carrera.nom_hipodromo,
carrera.num_carrera,
carrera.hor_carrera,
taquilla_opc_ame.tic_caduca,
taquilla_opc_ame.tip_ticket,
taquilla_opc_ame.lar_ticket
FROM 
venta,
carrera,
usuario,
taquilla,
taquilla_opc_ame 
WHERE 
venta.ticket = %s AND
venta.id_usuario = %s AND
carrera.cod_carrera = venta.cod_carrera AND
usuario.id_usuario = venta.id_usuario AND
taquilla.cod_taquilla = usuario.cod_taquilla AND
taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla
ORDER BY venta.cod_tventa",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($usuario_venta, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$horacarrerabd=$row_Recordset1['hor_carrera'];
if ($horacarrerabd<"23:55:00") {
    $aumento=$horacarrerabd."+5 min";
    $horacarrerabd=(date('H:i', strtotime($aumento)));
}
$cod=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hipicas:.</title>
<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72">
</object>
<script language="vbscript">
<!--
function doPrint()
	document.all.item("noprint").style.display="none"
	document.all.item()
	with factory.printing
	.header = ""
	.footer = ""
	.topMargin = 0.4
	.bottomMargin = 0.4
	.leftMargin = 0.4
	.rightMargin = 0.4
	.Print(false)
	end with
	document.all.item("noprint").style.display=""
end function
//-->
</script>
</head>
<?php
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta']==fechaactualbd() && $totalRows_Recordset1>0) {
    $serial=$row_Recordset1['ser_venta'];
    $estadoCodBarra=$row_Recordset1['cod_barra'];
    $rest = substr($serial, 0, 3);
    $tic_caduca=$row_Recordset1['tic_caduca'];
    $tipo=$row_Recordset1['tip_ticket'];
    $largo=$row_Recordset1['lar_ticket']+1;
 
    echo '<div id="printtitle" align="left" style="margin: 0px">';
    switch ($tipo) {
            case 0: include("ticket_0.php"); break;
            case 1: include("ticket_1.php"); break;
            case 2: include("ticket_2.php"); break;
            case 3: include("ticket_3.php"); break;
	    case 4: include("ticket_4.php"); break;
        }
    $cod=1;
    echo "</div>"; ?>
	<div id="noprint" align="center">
		<div align="left">
			<br>.<br><br>
			<script language="JavaScript">
				doprint();
				
				
				<?php
                if ($_GET["xIndex"]==1) {?>
					setTimeout("window.location='index_ventas.php?rID=<?php echo $cod ?>'",10);
				<?php } else {?>
					setTimeout("window.location='index.php?rID=<?php echo $cod ?>'",10);
				<?php } ?>	          
			</script>
	    </div>
    </div>
<?php
} else {
                    $cod=2;
                    echo "<p><h1>No se produjo ningun resultado</h1></p>";
                    echo '<p><a href="index.php?rID=<?php echo $cod ?>">Volver a taquilla</a></p>';
                } ?>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
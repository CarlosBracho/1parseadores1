<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1=0;
$usuario_venta=0;
if (isset($_GET["recordID"]) && isset($_GET["uVenta"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
    $usuario_venta = $_GET["uVenta"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventashnac_mie\t_imprimeticket.php - QUERY 1 */ SELECT 
venta_hnac.fec_venta_hnac, 
venta_hnac.hor_venta_hnac,
venta_hnac.ser_venta_hnac,
venta_hnac.can_ticket_hnac,
venta_hnac.num_caballo_hnac,
venta_hnac.ip_venta_hnac,
venta_hnac.ticket_hnac,
venta_hnac.cod_tventa_hnac,
venta_hnac.mon_venta_hnac,
venta_hnac.efectivoOn,
usuario.nom_completo,
usuario.cod_barra,
taquilla.nom_taquilla,
carrera_hnac.num_carrera_hnac,
carrera_hnac.hor_carrera_hnac,
hipodromo_hnac.nom_hipodromo_hnac,
taquilla_opc_hnac.anc_ticket_hnac,
taquilla_opc_hnac.lar_ticket_hnac,
taquilla_opc_hnac.tip_ticket_hnac,
taquilla_opc_hnac.tic_caduca_hnac
FROM 
venta_hnac,
carrera_hnac,
usuario,
taquilla,
hipodromo_hnac,
taquilla_opc_hnac 
WHERE
carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac AND
venta_hnac.ticket_hnac = %s AND
venta_hnac.id_usuario = %s AND
carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
usuario.id_usuario = venta_hnac.id_usuario AND
usuario.cod_taquilla = taquilla.cod_taquilla AND
taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla
ORDER BY venta_hnac.cod_tventa_hnac, venta_hnac.num_caballo_hnac ASC",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($usuario_venta, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$horacarrerabd=$row_Recordset1['hor_carrera_hnac'];
if ($horacarrerabd<"23:55:00") {
    $aumento=$horacarrerabd."+5 min";
    $horacarrerabd=(date('H:i', strtotime($aumento)));
}
$cod=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
<style type="text/css" media="print">
#Imprime {
	height: auto;
	width: 0px;
	margin: 0px;
	padding: 0px;
	float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 7px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	color: #000;
}
@page{
   margin: 0;
}
</style>
<script language="JavaScript">function GetIEVersion(){var e=window.navigator.userAgent,t=e.indexOf("MSIE");return t>0?parseInt(e.substring(t+5,e.indexOf(".",t))):navigator.userAgent.match(/Trident\/7\./)?11:0}function doprint2(e){document.getElementById(e);window.print(e)}("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0)&&document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');</script>
<script language="vbscript">
function doPrint1()
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
</script>
</head>
<script language="JavaScript">document.write("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0?'<body onload="javascript:document.all.cmdPrint.focus();">':"<body>");</script>
<?php
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta_hnac']==fechaactualbd() && $totalRows_Recordset1>0) {
    $serial=$row_Recordset1['ser_venta_hnac'];
    $estadoCodBarra=$row_Recordset1['cod_barra'];
    $rest = substr($serial, 0, 3);
    $largo=$row_Recordset1['lar_ticket_hnac']+1;
    $tipo=$row_Recordset1['tip_ticket_hnac'];
    $tic_caduca=$row_Recordset1['tic_caduca_hnac'];
    echo '<div id="printtitle" align="left" style="margin: 0px">';
    switch ($tipo) {
            case 0: include("ticket_hnac0.php"); break;
            case 1: include("ticket_hnac1.php"); break;
            case 2: include("ticket_hnac2.php"); break;
            case 3: include("ticket_hnac3.php"); break;
            case 4: include("ticket_hnac4.php"); break;
        }
    $cod=1;
    echo "</div>";
    $_SESSION['MM_mensaje2'] ="APUESTA REALIZADA CORRECTAMENTE!"; ?>
	<div id="noprint" align="center">
		<div align="left">
			<script language="JavaScript">"Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0?doprint1():doprint2("printtitle"),setTimeout("window.location='index.php'",10);</script>
	    </div>
    </div>
<?php
} else {
        $cod=2;
        $_SESSION['MM_mensaje2'] ="No se produjo ningún resultado";
        echo "<p><h1>".$_SESSION['MM_mensaje2']."</h1></p>";
        echo '<p><a href="index.php">Volver a taquilla</a></p>';
    } ?>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
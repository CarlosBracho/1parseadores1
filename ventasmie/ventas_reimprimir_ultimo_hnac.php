<?php
if (!isset($_SESSION)){session_start();} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$navegador=detect();
$usuario=$_SESSION['MM_id_usuario'];
$xHora=horaactual2();
if (isset($_GET["recordID"])) {
	
	$query_Recordset2 = sprintf("/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo_hnac.php - QUERY 1 */ SELECT 
		venta_hnac.ticket_hnac 
		FROM 
			venta_hnac 
		WHERE 
			venta_hnac.id_usuario = %s AND 
			venta_hnac.est_ticket_hnac = 1 AND
			venta_hnac.ticket_hnac = %s
		ORDER BY 
			venta_hnac.num_ticket_hnac LIMIT 1", 
	GetSQLValueString($usuario, "int"),
	GetSQLValueString($_GET["recordID"], "int"));
}
else {
	$query_Recordset2 = sprintf("/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo_hnac.php - QUERY 2 */ SELECT venta_hnac.ticket_hnac 
		FROM venta_hnac WHERE venta_hnac.id_usuario = %s AND venta_hnac.est_ticket_hnac = 1
	ORDER BY venta_hnac.num_ticket_hnac DESC LIMIT 1", GetSQLValueString($usuario, "int"));
}
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$xTicket_Recordset1=$row_Recordset2['ticket_hnac'];
$query_Recordset1 = sprintf("/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo_hnac.php - QUERY 3 */ SELECT 
venta_hnac.fec_venta_hnac, 
venta_hnac.hor_venta_hnac,
venta_hnac.num_ticket_hnac,
venta_hnac.ser_venta_hnac,
venta_hnac.can_ticket_hnac,
venta_hnac.num_caballo_hnac,
venta_hnac.ip_venta_hnac,
venta_hnac.ticket_hnac,
venta_hnac.cod_tventa_hnac,
venta_hnac.mon_venta_hnac,
venta_hnac.rei_ticket_hnac,
usuario.id_usuario,
usuario.nom_completo,
usuario.cod_barra,
usuario.can_reimpresion_hnac,
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
carrera_hnac.est_carrera_hnac = 1 AND
carrera_hnac.hor_carrera_hnac >= %s AND
usuario.cod_taquilla = taquilla.cod_taquilla AND
taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla
ORDER BY venta_hnac.cod_tventa_hnac", 
GetSQLValueString($xTicket_Recordset1, "int"),
GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
GetSQLValueString($xHora, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
<script language="JavaScript">
function GetIEVersion(){
	var e=window.navigator.userAgent,t=e.indexOf("MSIE");
	return t>0?parseInt(e.substring(t+5,e.indexOf(".",t))):navigator.userAgent.match(/Trident\/7\./)?11:0;
}
function doprint2(){
	var el = document.getElementById("noprint");
	el.style.display = (el.style.display == 'none') ? 'block' : 'none';
	document.getElementById("printtitle");
	window.print("printtitle");
	el.style.display = (el.style.display == 'none') ? 'block' : 'none';
}
if("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0)
document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');
</script>
<script language="vbscript">
function doPrint1()
	document.all.item("noprint").style.display="none"
	document.all.item("noprint2").style.display="none"
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
	document.all.item("noprint2").style.display=""
end function
</script>
</head>
<script language="JavaScript">document.write("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0?'<body onload="javascript:document.all.cmdPrint.focus();">':"<body>");</script>
<?php
$horacarrerabd=$row_Recordset1['hor_carrera_hnac'];
if ($horacarrerabd<"23:55:00") {
	$aumento=$horacarrerabd."+5 min"; $horacarrerabd=(date('H:i',strtotime($aumento)));
	list($ctaRimp, $idReim)=ctaReimpresion($row_Recordset1['id_usuario'],2); //id usuario - tipo programa
	if ($row_Recordset1['can_reimpresion_hnac']>0 && $row_Recordset1['rei_ticket_hnac']==0) { 
		$totRimp=$row_Recordset1['can_reimpresion_hnac'];
		if ($ctaRimp>=$totRimp)
			$rimp=-1;
		else {
			$rimp=1;
			$conte=$ctaRimp+1;
		}
	}
	else $rimp=0;
	if ($row_Recordset1['can_reimpresion_hnac']==0) $rimp=-1;
}
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta_hnac']==fechaactualbd() && $totalRows_Recordset1>0 && 		
	$rimp!=-1){
	$serial=$row_Recordset1['ser_venta_hnac'];
	$idTic=$row_Recordset1['num_ticket_hnac'];
	$estadoCodBarra=$row_Recordset1['cod_barra'];
	$rest = substr($serial, 0, 2);
	$rest = $rest.$xTicket_Recordset1;
	$mar=$row_Recordset1['anc_ticket_hnac']*40;
	$largo=$row_Recordset1['lar_ticket_hnac']+1;
	$tipo=$row_Recordset1['tip_ticket_hnac'];
	if ($row_Recordset1['rei_ticket_hnac']==0) $rT=$row_Recordset1['can_reimpresion_hnac']-($ctaRimp+1);
	else $rT=$row_Recordset1['can_reimpresion_hnac']-$ctaRimp;
	echo "<div id='noprint2' style='background:#990000; color:#FFFFFF'>";
	echo "Reimpresiones restantes: ".$rT;
	echo "</div>";
	$tic_caduca=$row_Recordset1['tic_caduca_hnac'];
	if ($rimp==1 && $row_Recordset1['rei_ticket_hnac']==0) {
		if ($conte==1) {
			$insertSQL = sprintf("/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo_hnac.php - QUERY 4 */ INSERT 
					INTO reimpresion 
					(id_usuario, can_actual, fec_reimpresion, tip_programa) 
					VALUES (%s, %s, %s, %s)",
							   GetSQLValueString($row_Recordset1['id_usuario'], "int"),
							   GetSQLValueString(1, "int"),
							   GetSQLValueString(fechaactualbd(), "date"),
							   GetSQLValueString(2, "int"));
			$Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
		}
		else {
			$insertSQL1 = sprintf("/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo_hnac.php - QUERY 5 */ UPDATE reimpresion 
					SET can_actual=%s
					WHERE id_reimpresion=%s",
							   GetSQLValueString($conte, "int"),
							   GetSQLValueString($idReim, "int"));
			$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
		}
		$insertSQL2 = sprintf("/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo_hnac.php - QUERY 6 */ UPDATE venta_hnac 
				SET rei_ticket_hnac=%s
				WHERE num_ticket_hnac=%s",
						   GetSQLValueString(1, "int"),
						   GetSQLValueString($idTic, "int"));
		$Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
	}
	echo '<div id="printtitle" align="left" style="margin: 0px">';
		switch ($tipo) { 
			case 0: include("ticket_copia_hnac0.php"); break; 
			case 1: include("ticket_copia_hnac1.php"); break; 
			case 2: include("ticket_copia_hnac2.php"); break; 
			case 3: include("ticket_copia_hnac3.php"); break; 
		}	
	echo "</div>";
	} 
	?>
<DIV id="noprint" align="center" style="float:left; width:250px;">
	<DIV align="center">
		<FORM name="form1">
			<INPUT style="FONT-STYLE: normal; FONT-FAMILY: 'MS Sans Serif'; FONT-SIZE: 15px; FONT-WEIGHT: normal" id="cmdPrint" class="boton" onclick="doPrint()" name="cmdPrint" value="Imprimir" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <A onclick=window.close() href="#"><FONT color=#1b007f><SPAN style="FONT-SIZE: 16pt"><B>Cerrar</B></SPAN></FONT></A>
		</FORM>
	</DIV>
</DIV>
<?php
	else { echo "No se produjo ningún resultado<br/><br/>";} 
	if (isset($ctaRimp) && isset($totRimp) && $ctaRimp>=$totRimp) echo "ATENCION: No puede reimprimir más tickets por hoy";
?>
</body>
</html>
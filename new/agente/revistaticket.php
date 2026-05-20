<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1 = "0";
$navegador=detect();
if (isset($_GET["recordID"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\agente\revistaticket.php - QUERY 1 */ SELECT * 
			FROM
				agencia,
				usuario,
				taquilla,
				venta,
				taquilla_opc_ame,
				carrera

			WHERE
				taquilla.cod_agencia = agencia.cod_agencia AND
				
				venta.cod_taquilla = taquilla.cod_taquilla AND
				
				carrera.cod_carrera = venta.cod_carrera AND
				
				usuario.cod_taquilla = taquilla.cod_taquilla AND
				
				usuario.id_usuario = venta.id_usuario AND
				
				taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND 
				venta.ticket = %s AND
				agencia.cod_agencia = %s
			ORDER BY venta.cod_tventa",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($_SESSION['MM_cod_agente'], "int")
);
$Recordset1 =mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$serial=$row_Recordset1['ser_venta'];
$estadoCodBarra=$row_Recordset1['cod_barra'];
$rest = substr($serial, 0, 3);
$tic_caduca=$row_Recordset1['tic_caduca'];
$tipo=$row_Recordset1['tip_ticket'];
$largo=$row_Recordset1['lar_ticket']+1;
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
if ($totalRows_Recordset1>0) {?>
<DIV id="siprint" style="float:left">
<?php
    switch ($tipo) {
        case 0: include("../ventasmie/ticket_r0.php"); break;
        case 1: include("../ventasmie/ticket_r1.php"); break;
        case 2: include("../ventasmie/ticket_r2.php"); break;
        case 3: include("../ventasmie/ticket_r3.php"); break;
    }
?>
</DIV>
<DIV id="noprint" align="center" style="float:left; width:250px;">
	<DIV align="center">
		<form name="form1">
			<input style="FONT-STYLE: normal; FONT-FAMILY: 'MS Sans Serif'; FONT-SIZE: 15px; FONT-WEIGHT: normal" id="cmdPrint" class="boton"  <?php if ($navegador['browser']=="IE") {
    echo 'onclick="doprint1()"';
} else {
    echo 'onclick="doprint2()"';
} ?> name="cmdPrint" value="Imprimir" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <A onclick=window.close() href="#"><FONT color=#1b007f><SPAN style="FONT-SIZE: 16pt"><B>Cerrar</B></SPAN></FONT></A>
		</form>
	</DIV>
</DIV>
<?php
} else {
    echo "NO SE PRODUJO NINGUN RESULTADO";
}?>    
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
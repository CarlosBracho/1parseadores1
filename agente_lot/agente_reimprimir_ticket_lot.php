<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo = $_SESSION['MM_cod_banca'];
$cod_agencia = $_SESSION['MM_cod_agencia'];
$navegador=detect();
$xTicket_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xTicket_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 agente_lot\agente_reimprimir_ticket_lot.php - QUERY 1 */ SELECT 
	ta.nom_taquilla,
	ta.nom_taquilla,
 	ve.fec_venta_lot,
	ve.hor_venta_lot,
	ve.ticket_lot,
	ve.ser_ticket_lot,
	ve.id_loteria,
	ve.ip_venta_lot,
	ve.tip_loteria_lot,
	ve.id_signo,
	ve.num_apuesta_lot,
	ve.mon_apuesta_lot,
	ve.can_ticket_lot,
	ve.rei_ticket_lot,
	ve.num_ticket_lot,
	tp.anc_ticket_lot,
	tp.lar_ticket_lot,
	tp.tip_ticket_lot,
	tp.tic_caduca_lot,
	us.can_reimpresion,
	us.cod_barra,
	us.id_usuario,
	us.nom_completo,
	us.can_reimpresion_lot,
	lt.nom_loteria,
	CASE lt.tip_loteria  
		WHEN 2 THEN (/* PARSEADORES1 agente_lot\agente_reimprimir_ticket_lot.php - QUERY 2 */ SELECT sor.nom_corto FROM signos sor WHERE sor.id_signo = ve.id_signo LIMIT 1)
		WHEN 3 THEN (/* PARSEADORES1 agente_lot\agente_reimprimir_ticket_lot.php - QUERY 3 */ SELECT sor.nom_corto FROM signos sor WHERE sor.id_signo = ve.id_signo LIMIT 1)
		WHEN 4 THEN (/* PARSEADORES1 agente_lot\agente_reimprimir_ticket_lot.php - QUERY 4 */ SELECT ani.nom_animal FROM animales ani WHERE ani.num_animal = ve.num_apuesta_lot LIMIT 1)
		WHEN 5 THEN (/* PARSEADORES1 agente_lot\agente_reimprimir_ticket_lot.php - QUERY 5 */ SELECT fru.nom_corto FROM frutas fru WHERE fru.id_fruta = ve.id_signo LIMIT 1)
		WHEN 6 THEN (/* PARSEADORES1 agente_lot\agente_reimprimir_ticket_lot.php - QUERY 6 */ SELECT pal.nom_corto FROM palos_cartas pal WHERE pal.id_palo = ve.id_signo LIMIT 1)
		ELSE ''
	END AS nsigno,
	ba.hor_cierre
FROM 
	venta_lot ve,
	loterias lt,
	bancaloterias ba,
	agencia ag,
	taquilla ta,
	taquilla_opc_lot tp,
	usuario us
WHERE 
	ve.ticket_lot = %s AND us.id_usuario = ve.id_usuario AND
	us.cod_taquilla = ta.cod_taquilla AND 
	tp.cod_taquilla = ta.cod_taquilla AND lt.id_loteria = ve.id_loteria AND
	ta.cod_agencia = ag.cod_agencia AND ba.id_banca = ag.cod_banca AND
	ba.id_loteria = ve.id_loteria AND ag.cod_banca = %s AND ag.cod_agencia = %s
ORDER BY hor_venta_lot ASC, id_loteria ASC, num_apuesta_lot ASC",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($xCodigo, "int"),
    GetSQLValueString($cod_agencia, "int")
);
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
<script language="JavaScript">function GetIEVersion(){var e=window.navigator.userAgent,t=e.indexOf("MSIE");return t>0?parseInt(e.substring(t+5,e.indexOf(".",t))):navigator.userAgent.match(/Trident\/7\./)?11:0}function doprint2(e){document.getElementById(e);window.print(e)}("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0)&&document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');</script>
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
$cod=0; $filas=0; $columnas=1; $sig=0; $montoapagar=0;
$serial=$row_Recordset1['ser_ticket_lot'];
$idTic=$row_Recordset1['num_ticket_lot'];
$estadoCodBarra=$row_Recordset1['cod_barra'];
$rest = substr($serial, 0, 2);
$rest = $rest.$xTicket_Recordset1;
$mar=$row_Recordset1['anc_ticket_lot']*40;
$largo=$row_Recordset1['lar_ticket_lot']+1;
$tipo=$row_Recordset1['tip_ticket_lot'];
$tic_caduca=$row_Recordset1['tic_caduca_lot'];
if ($totalRows_Recordset1>0) {
    echo '<div id="printtitle" align="left" style="margin: 0px">';
    switch ($tipo) {
            case 0: include("../ventaslot/ticket_copia_lot0.php"); break;
            case 1: include("../ventaslot/ticket_copia_lot1.php"); break;
            default:include("../ventaslot/ticket_copia_lot0.php"); break;
        }
    echo "</div>"; ?>
    <div id="noprint" align="center" style="float:left; width:250px;">
        <div align="center">
            <form name="form1">
                <input style="font-style:normal;font-family:'MS Sans Serif';font-size:15px;font-weight:normal; 
                	background: #CBCBCB;color:#000000;border:1px solid #000000;" 
                    id="cmdPrint" onclick="bimprimir()" name="cmdPrint" value="Imprimir" type="button">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					<a onclick=window.close() href="#">
						<font color="#1b007f">
							<span style="font-size:16pt"><b>Cerrar</b></span>
						</font>
					</a>
            </form>
        </div>
    </div>
	<script language="JavaScript">
	function bimprimir() {
		"Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0?doprint1():doprint2("printtitle");
	}
    </script><?php
} else {
        echo "No se produjo ningún resultado<br/><br/>";
    }?>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
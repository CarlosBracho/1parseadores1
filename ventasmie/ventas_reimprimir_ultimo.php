<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$usuario=$_SESSION['MM_id_usuario'];
$xHora=horaactual2();
$FechaTxt=fechaactualbd();
//USE INDEX(id_us_fe_fe)
$query_Recordset2 = sprintf("/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo.php - QUERY 1 */ SELECT ticket FROM venta

 WHERE venta.id_usuario = %s AND venta.fec_venta = %s AND est_ticket = 1
ORDER BY venta.num_ticket DESC LIMIT 1", GetSQLValueString($usuario, "int"), GetSQLValueString($FechaTxt, "date"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$xTicket_Recordset1=$row_Recordset2['ticket'];
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo.php - QUERY 2 */ SELECT 
venta.fec_venta, 
venta.hor_venta,
venta.ser_venta,
venta.tra_codigo,
venta.cod_cliente,
venta.can_ticket,
venta.num_caballo,
venta.ip_venta,
venta.ticket,
venta.cod_tventa,
venta.mon_venta,
venta.num_ticket,
venta.rei_ticket,
venta.efectivoO,
usuario.nom_completo,
usuario.cod_barra,
usuario.id_usuario,
usuario.can_reimpresion,
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
    GetSQLValueString($_SESSION['MM_id_usuario'], "int"),
    GetSQLValueString($xHora, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$cod_cliente=$row_Recordset1['cod_cliente'];
$tra_codigo=$row_Recordset1['tra_codigo'];
?>
<HEAD><TITLE>.:Apuestas Hípicas:.</TITLE>
<META name=generator content="Namo WebEditor">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<OBJECT id=factory codeBase="ScriptX.cab#Version=6,5,439,72" classid=clsid:1663ed61-23eb-11d2-b92f-008048fdd814></OBJECT>
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
<SCRIPT language=vbscript>
<!--
function doPrint()
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
//-->
</SCRIPT>
</HEAD>
<BODY onload="javascript:document.all.cmdPrint.focus();" aLink="red" bgColor="#e1f0f8" text="black" vLink="purple" link="blue">
<?php
$horacarrerabd=horaactual2();
if ($horacarrerabd<"23:55:00") {
    $aumento=$horacarrerabd."+5 min";
    $horacarrerabd=(date('H:i', strtotime($aumento)));
}
$rimp=-1;
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta']==fechaactualbd() && $totalRows_Recordset1>0) {
    list($ctaRimp, $idReim)=ctaReimpresion($row_Recordset1['id_usuario'], 1); //id usuario - tipo programa
    if ($row_Recordset1['can_reimpresion']>0 && $row_Recordset1['rei_ticket']==0) {
        $totRimp=$row_Recordset1['can_reimpresion'];
        if ($ctaRimp>=$totRimp) {
            $rimp=-1;
        } else {
            $rimp=1;
            $conte=$ctaRimp+1;
        }
    } else {
        $rimp=0;
        $ctaRimp++;
    }
}
if ($horacarrerabd >= horaactual() && $row_Recordset1['fec_venta']==fechaactualbd() && $totalRows_Recordset1>0 &&
    $rimp!=-1) {
    if ($row_Recordset1['rei_ticket']==0) {
        $rT=$row_Recordset1['can_reimpresion']-($ctaRimp+1);
    } else {
        $rT=$row_Recordset1['can_reimpresion']-$ctaRimp;
    }
    echo "<div id='noprint2' style='background:#990000; color:#FFFFFF'>";
    echo "Reimpresiones restantes: ".$rT;
    echo "</div>";
    $serial=$row_Recordset1['ser_venta'];
    $idTic=$row_Recordset1['num_ticket'];
    $estadoCodBarra=$row_Recordset1['cod_barra'];
    $rest = substr($serial, 0, 3);
    $tic_caduca=$row_Recordset1['tic_caduca'];
    $tipo=$row_Recordset1['tip_ticket'];
    $largo=$row_Recordset1['lar_ticket']+1;
    if ($rimp==1 && $row_Recordset1['rei_ticket']==0) {
        if ($conte==1) {
            $insertSQL = sprintf(
                "/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo.php - QUERY 3 */ INSERT 
					INTO reimpresion 
					(id_usuario, can_actual, fec_reimpresion, tip_programa) 
					VALUES (%s, %s, %s, %s)",
                GetSQLValueString($row_Recordset1['id_usuario'], "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString(fechaactualbd(), "date"),
                GetSQLValueString(1, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        } else {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo.php - QUERY 4 */ UPDATE reimpresion 
					SET can_actual=%s
					WHERE id_reimpresion=%s",
                GetSQLValueString($conte, "int"),
                GetSQLValueString($idReim, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        }
        $insertSQL2 = sprintf(
            "/* PARSEADORES1 ventasmie\ventas_reimprimir_ultimo.php - QUERY 5 */ UPDATE venta 
				SET rei_ticket=%s
				WHERE num_ticket=%s",
            GetSQLValueString(1, "int"),
            GetSQLValueString($idTic, "int")
        );
        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
    } //var_dump( $tra_codigo.'DD');?>
<DIV id="siprint" style="float:left">
<?php
    if ($tra_codigo==1) {
        echo "CLIENTE: ".$cod_cliente."<br/>";
    }
    switch ($tipo) {
        case 0: include("ticket_r0.php"); break;
        case 1: include("ticket_r1.php"); break;
        case 2: include("ticket_r2.php"); break;
        case 3: include("ticket_r3.php"); break;
        case 4: include("ticket_r4.php"); break;
    } ?>
</DIV>
    <?php
} else {
            echo "No se produjo ningún resultado<br/><br/>";
        }
        if (isset($ctaRimp) && isset($totRimp) && $ctaRimp>=$totRimp) {
            echo "ATENCION: No puede reimprimir más tickets por hoy";
        }
        ?>
</BODY>

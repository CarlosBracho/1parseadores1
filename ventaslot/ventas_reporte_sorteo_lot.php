<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$codigoUsuario=$_SESSION['MM_id_usuario'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset2 = sprintf("/* PARSEADORES1 ventaslot\ventas_reporte_sorteo_lot.php - QUERY 1 */ SELECT us.nom_usuario, us.id_usuario, ta.nom_taquilla, ag.cod_agencia, ba.cod_banca, ta.cod_taquilla 
	FROM usuario us, taquilla ta, agencia ag, banca ba 
	WHERE us.id_usuario = %s AND us.cod_taquilla = ta.cod_taquilla AND ag.cod_agencia = ta.cod_agencia AND
	ag.cod_banca = ba.cod_banca
	ORDER BY us.nom_usuario LIMIT 1", GetSQLValueString($codigoUsuario, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$fechahoy=fechaactualbd();
$osorteo = array();
$contado=0;
if ((isset($_POST["MM_inserto"])) && ($_POST["MM_inserto"] == "formo") && (isset($_POST["od_sorteo"])) &&
    (isset($_POST["fecha_inicio"])) && (isset($_POST["id_usuario"])) && (isset($_POST["cod_taquilla"]))) {
    $fechahoy=fechaymd($_POST["fecha_inicio"]);
    $osorteo = implode("','", $_POST["od_sorteo"]);
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 ventaslot\ventas_reporte_sorteo_lot.php - QUERY 2 */ SELECT 
		lo.nom_loteria, lo.id_triple, nom_sorteo, lo.id_sorteo,
		SUM(mon_apuesta_lot) AS ven_triple,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 ventaslot\ventas_reporte_sorteo_lot.php - QUERY 3 */ SELECT SUM(mon_apuesta_lot) FROM venta_lot ven WHERE ven.id_loteria=lo.id_terminal)
			WHEN 3 THEN (/* PARSEADORES1 ventaslot\ventas_reporte_sorteo_lot.php - QUERY 4 */ SELECT SUM(mon_apuesta_lot) FROM venta_lot ven WHERE ven.id_loteria=lo.id_terminal)
			ELSE 0
		END AS ven_terminal
		FROM
			bancaloterias bl,
			agencialoterias al,
			agencia ag,
			sorteos so,
			taquilla ta,
			usuario us
		LEFT JOIN loterias lo ON lo.id_sorteo IN ('$osorteo') AND lo.tip_loteria!=2 
		LEFT JOIN venta_lot ve ON us.id_usuario = ve.id_usuario AND 
			ve.id_loteria = lo.id_loteria AND ve.fec_venta_lot >= %s AND ve.fec_venta_lot <= %s
		WHERE
		so.id_sorteo = lo.id_sorteo AND
		bl.id_banca = ag.cod_banca AND
		al.id_agencia = ag.cod_agencia AND
		ag.cod_agencia = ta.cod_agencia AND
		us.cod_taquilla = ta.cod_taquilla AND 
		lo.est_loteria=1 AND
		bl.est_banlot = 1 AND bl.id_loteria = lo.id_loteria AND
		al.est_agelot=1 AND al.id_loteria = lo.id_loteria AND
		ta.cod_taquilla = %s 
		GROUP BY lo.id_loteria",
        GetSQLValueString($fechahoy, "date"),
        GetSQLValueString($fechahoy, "date"),
        GetSQLValueString($_POST["cod_taquilla"], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $osorteo = $_POST["od_sorteo"];
}
$query_Recordset3 =  sprintf("/* PARSEADORES1 ventaslot\ventas_reporte_sorteo_lot.php - QUERY 5 */ SELECT so.id_sorteo, so.nom_sorteo
	FROM loterias lo, sorteos so 
	WHERE lo.tip_loteria != 2 AND lo.est_loteria=1 AND 
	so.id_sorteo = lo.id_sorteo  AND so.est_sorteo=1
	GROUP BY so.id_sorteo
	ORDER BY so.nom_sorteo ASC");
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../admin_lot/csslot/selectric.css">

<style>
height: 0;
width: 0;
position: absolute;
</style>
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="../admin_lot/csslot/selectric.css">

<script language="JavaScript">
function cambiacolor_over(celda){ celda.style.backgroundColor="#9FBFD7" }  
function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFDD" } 
function GetIEVersion(){
	var e=window.navigator.userAgent,t=e.indexOf("MSIE");
	return t>0?parseInt(e.substring(t+5,e.indexOf(".",t))):navigator.userAgent.match(/Trident\/7\./)?11:0;
}
function vernover(){
	var el1 = document.getElementById("noprint1");
	var el2 = document.getElementById("noprint2");
	var el3 = document.getElementById("noprint3");
	var el4 = document.getElementById("noprint4");
	var el5 = document.getElementById("noprint5");
	el1.style.display = (el1.style.display == 'none') ? 'block' : 'none';
	el2.style.display = (el2.style.display == 'none') ? 'block' : 'none';
	el3.style.display = (el3.style.display == 'none') ? 'block' : 'none';
	el4.style.display = (el4.style.display == 'none') ? 'block' : 'none';
	el5.style.display = (el5.style.display == 'none') ? 'block' : 'none';
}
function doprint2(){
	vernover();
	document.getElementById("printtitle");
	window.print("printtitle");
	vernover();
}
if("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0)
document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');
</script>
<script language="vbscript">
function doPrint1()
	document.all.item("noprint1").style.display="none"
	document.all.item("noprint2").style.display="none"
	document.all.item("noprint3").style.display="none"
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
	document.all.item("noprint1").style.display=""
	document.all.item("noprint2").style.display=""
	document.all.item("noprint3").style.display=""
end function
</script>
<script LANGUAGE="JavaScript"> var statusEnvio = false; function chequearEnvio() {if (!statusEnvio) { statusEnvio = true; return true;} else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false;}}</script>
</head>
<script language="JavaScript">document.write("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0?'<body onload="javascript:document.all.cmdPrint.focus();">':"<body>");</script>
	<div style="background:#333; width:100%; float:left; padding:20px 2px 2px 2px;
		color:#FFF; font-size:22px; text-align:center" id="noprint1">
        RESUMEN DE VENTAS POR SORTEOS
	</div><!-- end .container -->
	<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
		onsubmit="return chequearEnvio();">
       <div style="background: #FFF; width:100%; float:left; padding:10px 0px 0px 10px;
            color:#000; font-size:18px; text-align: left"  id="noprint2">
            <div style="float:left;width:400px; padding:0 20px 0 0;">
            	FILTRAR POR SORTEO:<br/>
				<select multiple="multiple" name="od_sorteo[]" id="od_sorteo" tabindex="0">
					<option value="">Seleccione</option><?php
                    do {?>
						<option value="<?php echo $row_Recordset3['id_sorteo']?>" 
						<?php if (in_array($row_Recordset3['id_sorteo'], $osorteo)) {
                        echo"selected=\"selected\"";
                    }?>>
						<?php echo $row_Recordset3['nom_sorteo']?></option><?php
                    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
				</select>
            </div>
            <div style="float:left;">
                FECHA:<br/>
                <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" style="width:90px; font-size:16px; height:20px"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities(fechanueva($fechahoy), ENT_COMPAT, 'utf-8'); ?>"/>
				<input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                     style="width:80px; height:30px; margin: -8px 0px 0px 0px"/>
            </div>         
			<input type="hidden" name="MM_inserto" value="formo" />
			<input type="hidden" name="id_usuario" value="<?php echo $row_Recordset2['id_usuario']; ?>"/>
			<input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset2['cod_taquilla']; ?>"/>
       </div><!-- end .container -->
	</form>  
   <div id="mostrar" style="width:100%; float:left; border-top: 1px solid #C1BDBE;">
	<?php
    if (isset($totalRows_Recordset1) && $totalRows_Recordset1>0) {?>
     	<div style="width:98%; float:left; padding:0px 0px 0px 10px; height:430px; overflow:auto;overflow-x:hidden;">
			<div id="printtitle" style="float:left;">
              <table width="65%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px;">
                    <tr align="center" style="line-height: 1">
                        <td height="18" colspan="4" valign="bottom">
						<?php echo '<font size="2">Resumen de ventas del '.verfechaF($fechahoy).'</font>'; ?>
                        </td>
					</tr>
                  <tr align="center" style="background: #DBDBDB;line-height: 1">
                        <td height="26">LOTERIA</td>
                    <td>TOTAL<br/>TRIPLE</td>
                        <td>TOTAL<br/>TERMINAL</td>
                        <td>TOTAL<br/>VENTAS</td>
                    </tr><?php
                    $totalTr=0;
                    $totalTe=0;
                    do {?>
                    	<tr style="font-size:12px;">
							<td bgcolor="#FFFFFF" width="22%" style="font-size:11px">
								<?php echo $row_Recordset1['nom_loteria'];?>
                            </td>
							<td bgcolor="#EAEAEA" width="14%" style="text-align:right">
								<?php echo number_format($row_Recordset1['ven_triple'], 2, ",", ".");?>
                            </td>
						  <td bgcolor="#F3F3F3" width="14%" style="text-align:right">
								<?php echo number_format($row_Recordset1['ven_terminal'], 2, ",", "."); ?>
                            </td>
						  <td bgcolor="#CCCCCC" width="15%" style="text-align:right">
								<?php echo number_format($row_Recordset1['ven_triple']+$row_Recordset1['ven_terminal'], 2, ",", ".");?>
                            </td>
						<tr><?php
                        $totalTr=$totalTr+$row_Recordset1['ven_triple'];
                        $totalTe=$totalTe+$row_Recordset1['ven_terminal'];
                        
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));?>
                    <tr align="right" style="background: #DBDBDB;line-height: 1;font-weight: bold;">
                        <td height="18">TOTALES:</td>
                        <td><?php echo number_format($totalTr, 2, ",", ".");?></td>
                        <td><?php echo number_format($totalTe, 2, ",", ".");?></td>
                        <td><?php echo number_format($totalTr+$totalTe, 2, ",", ".");?></td>
                    </tr>
				</table>
            </div>
	 </div>
     <div style="background: #333; width:99%; float:left; color:#FFF; text-align:right; font-size:16px; 
     	padding:5px 10px 0px 5px" id="noprint3">
		<form name="form1">
			<input style="FONT-STYLE: normal; FONT-FAMILY: 'MS Sans Serif'; FONT-SIZE: 15px; FONT-WEIGHT: normal" id="cmdPrint" class="boton"  <?php if ($navegador['browser']=="IE") {
                        echo 'onclick="doprint1()"';
                    } else {
                        echo 'onclick="doprint2()"';
                    } ?> name="cmdPrint" value="Imprimir" type="button"><A onclick=window.close() href="#">
            <FONT color="#F9E209" style="padding:0 10px" ><SPAN style="FONT-SIZE: 16pt"><B>Cerrar</B></SPAN></FONT></A>
		</form>
     </div><!-- end .container -->
        <?php } else {?>
        <div style="text-align:center; width:100%; color:#A2A2A2; font-size:20px; padding:50px 0;line-height: 26px;">
        	Seleccione los sorteos, indique Fecha <br/>y presione Buscar
        </div>
        <?php }?>  
   </div><!-- end .mostrar -->
			<script src="../admin_lot/jslot/jquery.min.js"></script>
            <script src="../admin_lot/jslot/jquery.selectric.js"></script>
            <script>
                $(function() {
                    $('/* PARSEADORES1 ventaslot\ventas_reporte_sorteo_lot.php - QUERY 6 */ select').selectric({
                        disableOnMobile: false,	preventWindowScroll: true, maxHeight: 300,
                        multiple: {separator: '-', keepMenuOpen: true, maxLabelEntries: false}				
                    });
                });
            </script>
</body>
</html>
<?php
if (isset($Recordset1)) {
            mysqli_free_result($Recordset1);
        }
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
if (isset($Recordset3)) {
    mysqli_free_result($Recordset3);
}
?>
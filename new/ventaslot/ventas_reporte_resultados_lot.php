<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
$codigoUsuario=$_SESSION['MM_id_usuario'];
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset2 = sprintf("/* PARSEADORES1 new\ventaslot\ventas_reporte_resultados_lot.php - QUERY 1 */ SELECT us.nom_usuario, us.id_usuario, ta.nom_taquilla, ag.cod_agencia, ba.cod_banca, ba.mod_resultado FROM usuario us, taquilla ta, agencia ag, banca ba 
	WHERE us.id_usuario = %s AND us.cod_taquilla = ta.cod_taquilla AND ag.cod_agencia = ta.cod_agencia AND
	ag.cod_banca = ba.cod_banca
	ORDER BY us.nom_usuario LIMIT 1", GetSQLValueString($codigoUsuario, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$diahoy=diaactual();
list($aDia, $bDia)=loteriaHoy($diahoy);
if ($row_Recordset2['mod_resultado']==1) {
    $codBusqueda=0;
} else {
    $codBusqueda=$row_Recordset2['cod_banca'];
}
$cod_banca=$row_Recordset2['cod_banca'];
$cod_agencia=$row_Recordset2['cod_agencia'];
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio'])) {
        if ($_POST['fecha_inicio']!="") {
            $inicio=$_POST['fecha_inicio'];
            $in=fechaymd($inicio);
            list($aDia, $bDia)=loteriaHoy(date('w', strtotime($in)));
            $codBusqueda=$_POST['cBus'];
            $cod_banca=$_POST['cod_banca'];
            $cod_agencia=$_POST['cod_agencia'];
        }
    }
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventaslot\ventas_reporte_resultados_lot.php - QUERY 2 */ SELECT 
	so.nom_sorteo, tip_loteria,
	CASE lo.tip_loteria  
		WHEN 3 THEN (/* PARSEADORES1 new\ventaslot\ventas_reporte_resultados_lot.php - QUERY 3 */ SELECT sor.nom_corto FROM signos sor WHERE sor.id_signo = rs.sig_resultado LIMIT 1)
		WHEN 4 THEN (/* PARSEADORES1 new\ventaslot\ventas_reporte_resultados_lot.php - QUERY 4 */ SELECT ani.nom_animal FROM animales ani WHERE ani.num_animal = rs.num_resultado LIMIT 1)
		WHEN 5 THEN (/* PARSEADORES1 new\ventaslot\ventas_reporte_resultados_lot.php - QUERY 5 */ SELECT fru.nom_fruta FROM frutas fru WHERE fru.id_fruta = rs.num_resultado LIMIT 1)
		WHEN 6 THEN (/* PARSEADORES1 new\ventaslot\ventas_reporte_resultados_lot.php - QUERY 6 */ SELECT pal.nom_palo FROM palos_cartas pal WHERE pal.id_palo = rs.sig_resultado LIMIT 1)
		ELSE ''
	END AS nom_signo,
	CASE lo.tip_loteria
		WHEN 4 THEN CONCAT(rs.num_resultado, '-') 
		WHEN 5 THEN CONCAT(rs.num_resultado, '-')  
		WHEN 6 THEN CONCAT(rs.num_resultado, '-') 
		ELSE GROUP_CONCAT(let_loteria, '-', rs.num_resultado, '&nbsp;&nbsp;' ORDER BY let_loteria ASC SEPARATOR ' ')
	END AS loterias	
	FROM 
		agencialoterias ag,
		loterias lo,
		sorteos so,
		bancaloterias bl
	LEFT JOIN resultados_lot rs ON rs.id_banca = %s AND rs.id_loteria = bl.id_loteria AND rs.fec_resultado = %s
	WHERE
		so.id_sorteo = lo.id_sorteo AND 
		lo.tip_loteria != 2 AND lo.est_loteria=1 AND 
		bl.id_loteria = lo.id_loteria AND
		bl.id_banca = %s AND 
		$bDia = 1 AND 
		bl.est_banlot = 1 AND 
		ag.id_agencia=%s AND
		$aDia=1 AND 
		ag.est_agelot=1 AND 
		ag.id_loteria = bl.id_loteria
	GROUP BY lo.id_sorteo	
	ORDER BY bl.hor_cierre, lo.nom_loteria, lo.tip_loteria, lo.ord_loteria ASC",
    GetSQLValueString($codBusqueda, "int"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($cod_banca, "int"),
    GetSQLValueString($cod_agencia, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<br>
<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
lang=ES-VE style='font-size:15.0pt;font-family:"Arial Black","sans-serif";
mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:Arial;
color:black;mso-ansi-language:ES-VE;mso-fareast-language:ES-VE'><a
href="../guias/tuazaranimalitos.php" target="_blank">
  <span class=SpellE>RESULTADOS ANIMALITOS PAGINA TU AZAR</span></a></span></b><b style='mso-bidi-font-weight:
normal'><span lang=ES-VE style='font-size:15.0pt;font-family:"Arial Black","sans-serif";
mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:"Times New Roman";
mso-ansi-languaghttp://localhost/admin/mensajes_control.php#e:ES-VE;mso-fareast-language:ES-VE'><o:p></o:p></span></b></p>
<br>
<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b style='mso-bidi-font-weight:normal'><span
lang=ES-VE style='font-size:15.0pt;font-family:"Arial Black","sans-serif";
mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:Arial;
color:black;mso-ansi-language:ES-VE;mso-fareast-language:ES-VE'><a
href="../guias/loteriadehoytrucoactivo.php" target="_blank">
  <span class=SpellE>RESULTADOS TRUCO ACTIVO PAGINA LOTERIA DE HOY</span></a></span></b><b style='mso-bidi-font-weight:
normal'><span lang=ES-VE style='font-size:15.0pt;font-family:"Arial Black","sans-serif";
mso-fareast-font-family:"Times New Roman";mso-bidi-font-family:"Times New Roman";
mso-ansi-languaghttp://localhost/admin/mensajes_control.php#e:ES-VE;mso-fareast-language:ES-VE'><o:p></o:p></span></b></p>



<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<style>
height: 0;
width: 0;
position: absolute;
</style>
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
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
	<div style="background:#333; width:100%; float:left; padding:50px 2px 2px 2px;
		color:#FFF; font-size:22px; text-align:center" id="noprint1">
        RESULTADOS DE SORTEOS
	</div><!-- end .container -->
	<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
		onsubmit="return chequearEnvio();">
       <div style="background: #FFF; width:100%; float:left; padding:10px 0px 0px 10px;
            color:#000; font-size:20px; text-align: left"  id="noprint2">
                Fecha:
                <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" style="width:90px; font-size:16px; height:20px"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
                    <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                     style="width:80px; height:35px; margin: -8px 0px 0px 0px"/>
                    <input type="hidden" name="MM_update" value="form1" />
                    <input type="hidden" name="cod_banca" value="<?php echo $row_Recordset2['cod_banca']; ?>"/>
                    <input type="hidden" name="cBus" value="<?php echo $codBusqueda; ?>"/>
                    <input type="hidden" name="cod_agencia" value="<?php echo $row_Recordset2['cod_agencia']; ?>"/>
       </div><!-- end .container -->
	</form>  
   <div id="mostrar" style="width:100%; float:left; border-top: 1px solid #C1BDBE;">
	<?php
    if (isset($totalRows_Recordset1) && $totalRows_Recordset1>0) {?>
     	<div style="width:98%; float:left; padding:0px 0px 0px 10px; height:400px; overflow:auto;overflow-x:hidden;">
			<div id="printtitle" style="float:left;">
                <table width="500" border="0" cellpadding="0" cellspacing="0" style="font-size:12px">
                  <tbody>
                    <tr>
                      <td colspan="3" align="left"><?php echo "Sorteo: ".verfechaF($in); ?></td>
                    </tr>
                    <tr>
                      <td width="56%">NOMBRE DE SORTEO</td>
                      <td colspan="2">RESULTADO</td>
                    </tr>
					<?php
                    do {?>
                            <tr bgcolor="#FFFFDD" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
                              <td><?php echo $row_Recordset1['nom_sorteo']; ?></td><?php
                              if ($row_Recordset1['tip_loteria']<4) {?>
                                  <td width="38%" align="right"><?php echo $row_Recordset1['loterias']; ?></td>
                                  <td width="6%" align="left"><?php echo $row_Recordset1['nom_signo']; ?></td><?php
                              } else {?>
                                  <td colspan="2" align="left">
								  	<?php echo $row_Recordset1['loterias'].$row_Recordset1['nom_signo']; ?></td><?php
                              }?>
                            </tr>
        
                    <?php
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>	
                  </tbody>
                </table>
            </div>
	 </div>
     <div style="background: #333; width:98%; float:left; color:#FFF; text-align:right; font-size:16px; 
     	padding:5px 10px 0px 5px" id="noprint3">
		<form name="form1">
			<input style="FONT-STYLE: normal; FONT-FAMILY: 'MS Sans Serif'; FONT-SIZE: 15px; FONT-WEIGHT: normal" id="cmdPrint" class="boton"  <?php if ($navegador['browser']=="IE") {
                        echo 'onclick="doprint1()"';
                    } else {
                        echo 'onclick="doprint2()"';
                    } ?> name="cmdPrint" value="Imprimir" type="button">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <A onclick=window.close() href="#">
            <FONT color="#F9E209" ><SPAN style="FONT-SIZE: 16pt"><B>Cerrar</B></SPAN></FONT></A>
		</form>
     </div><!-- end .container -->
        <?php } else {?>
        <h4 style="text-align:left; padding:0px 0px 0px 15px">No existen datos</h4>
        <?php }?>  
   </div><!-- end .mostrar -->
</body>
</html>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset2);
?>
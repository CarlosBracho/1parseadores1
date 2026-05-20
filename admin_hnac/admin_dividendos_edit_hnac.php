<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
function guardaBD($fec, $car, $cab, $div, $fac, $lin, $tip, $emp)
{
    $cab=$cab*1;
    global $conexionbanca;
    $insertSQL = sprintf(
        "/* PARSEADORES1 admin_hnac\admin_dividendos_edit_hnac.php - QUERY 1 */ INSERT 
		INTO resultados_oficiales_hnac 
		(fec_resultado_hnac, cod_carrera_hnac, num_caballo_hnac, div_pago_hnac, fac_div_hnac, lin_dividendo, cod_tventa_hnac,
			est_empate_hnac) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($fec, "date"),
        GetSQLValueString($car, "int"),
        GetSQLValueString($cab, "text"),
        GetSQLValueString($div, "double"),
        GetSQLValueString($fac, "double"),
        GetSQLValueString($lin, "int"),
        GetSQLValueString($tip, "int"),
        GetSQLValueString($emp, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    return 1;
}
function modifiBD($id, $cab, $div, $fac, $emp)
{
    $cab=$cab*1;
    global $conexionbanca;
    $insertSQL2 = sprintf(
        "/* PARSEADORES1 admin_hnac\admin_dividendos_edit_hnac.php - QUERY 2 */ UPDATE resultados_oficiales_hnac SET
			fac_div_hnac=%s,
			num_caballo_hnac=%s,
			div_pago_hnac=%s,
			est_empate_hnac=%s 
			WHERE cod_resultado_hnac=%s",
        GetSQLValueString($fac, "double"),
        GetSQLValueString($cab, "text"),
        GetSQLValueString($div, "double"),
        GetSQLValueString($emp, "int"),
        GetSQLValueString($id, "int")
    );
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
    return 1;
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $insertSQL22 = sprintf(
        "/* PARSEADORES1 admin_hnac\admin_dividendos_edit_hnac.php - QUERY 3 */ UPDATE carrera_hnac SET
				est_confirmacion_hnac=%s
				WHERE cod_carrera_hnac=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString($_POST['cod'], "int")
    );
    $Result22 = mysqli_query($conexionbanca, $insertSQL22) or die(mysqli_error($conexionbanca));
    if ($_POST['ej1si']>0 || $_POST['di1si']>0) { // 1er lugar simple
        if ($_POST['ej1do']>0 && $_POST['di1do']>0) {
            $emp=1;
        } else {
            $emp=0;
        }
        if ($_POST['id1si']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej1si'], $_POST['di1si'], $_POST['fa1si'], 11, 1, $emp);
        }
        if ($_POST['id1si']>0) {
            $a=modifiBD($_POST['id1si'], $_POST['ej1si'], $_POST['di1si'], $_POST['fa1si'], $emp);
        }
    }
    if ($_POST['ej2si']>0) { // 2do lugar simple
        if ($_POST['ej2do']>0) {
            $emp=1;
        } else {
            $emp=0;
        }
        if ($_POST['id2si']==-1) {
            guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej2si'], 0, 0, 12, 2, $emp);
        }
        if ($_POST['id2si']>0) {
            $a=modifiBD($_POST['id2si'], $_POST['ej2si'], 0, 0, $emp);
        }
    }
    if ($_POST['ej3si']>0) {// 3er lugar simple
        if ($_POST['ej3do']>0) {
            $emp=1;
        } else {
            $emp=0;
        }
        if ($_POST['id3si']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej3si'], 0, 0, 13, 3, $emp);
        }
        if ($_POST['id3si']>0) {
            $a=modifiBD($_POST['id3si'], $_POST['ej3si'], 0, 0, $emp);
        }
    }
    if ($_POST['ej4si']>0) {// 2do lugar simple
        if ($_POST['ej4do']>0) {
            $emp=1;
        } else {
            $emp=0;
        }
        if ($_POST['id4si']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej4si'], 0, 0, 14, 4, $emp);
        }
        if ($_POST['id4si']>0) {
            $a=modifiBD($_POST['id4si'], $_POST['ej4si'], 0, 0, $emp);
        }
    }
    //-------------------------------------------doble empate---------------------------------------------------
    if ($_POST['ej1do']>0 || $_POST['di1do']>0) { // 1er lugar empate doble
        if ($_POST['id1do']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej1do'], $_POST['di1do'], $_POST['fa1do'], 21, 1, 1);
        }
        if ($_POST['id1do']>0) {
            $a=modifiBD($_POST['id1do'], $_POST['ej1do'], $_POST['di1do'], $_POST['fa1do'], 1);
        }
    }
    if ($_POST['ej2do']>0) { // 2do lugar simple
        if ($_POST['id2do']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej2do'], 0, 0, 22, 2, 1);
        }
        if ($_POST['id2do']>0) {
            $a=modifiBD($_POST['id2do'], $_POST['ej2do'], 0, 0, 1);
        }
    }
    if ($_POST['ej3do']>0) {// 3er lugar simple
        if ($_POST['id3do']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej3do'], 0, 0, 23, 3, 1);
        }
        if ($_POST['id3do']>0) {
            $a=modifiBD($_POST['id3do'], $_POST['ej3do'], 0, 0, 1);
        }
    }
    if ($_POST['ej4do']>0) {// 2do lugar simple
        if ($_POST['id4do']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej4do'], 0, 0, 24, 4, 1);
        }
        if ($_POST['id4do']>0) {
            $a=modifiBD($_POST['id4do'], $_POST['ej4do'], 0, 0, 1);
        }
    }
    //--------------------------------------------triple empate------------------------------------
    if ($_POST['ej1tr']>0 || $_POST['di1tr']>0) { // 1er lugar empate triple
        if ($_POST['id1tr']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej1tr'], $_POST['di1tr'], $_POST['fa1tr'], 31, 1, 2);
        }
        if ($_POST['id1tr']>0) {
            $a=modifiBD($_POST['id1tr'], $_POST['ej1tr'], $_POST['di1tr'], $_POST['fa1tr'], 2);
        }
    }
    if ($_POST['ej2tr']>0) {// 2do lugar simple
        if ($_POST['id2tr']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej2tr'], 0, 0, 32, 2, 2);
        }
        if ($_POST['id2tr']>0) {
            $a=modifiBD($_POST['id2tr'], $_POST['ej2tr'], 0, 0, 2);
        }
    }
    if ($_POST['ej3tr']>0) {// 3er lugar simple
        if ($_POST['id3tr']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej3tr'], 0, 0, 33, 3, 2);
        }
        if ($_POST['id3tr']>0) {
            $a=modifiBD($_POST['id3tr'], $_POST['ej3tr'], 0, 0, 2);
        }
    }
    if ($_POST['ej4tr']>0) {// 2do lugar simple
        if ($_POST['id4tr']==-1) {
            $a=guardaBD($_POST['fec'], $_POST['cod'], $_POST['ej4tr'], 0, 0, 34, 4, 2);
        }
        if ($_POST['id4tr']>0) {
            $a=modifiBD($_POST['id4tr'], $_POST['ej4tr'], 0, 0, 2);
        }
    }
    if (isset($a) && $a==1) {
        $_POST['rA']=$_POST['cod'];
        $query_Recordset10 = sprintf(
            "/* PARSEADORES1 admin_hnac\admin_dividendos_edit_hnac.php - QUERY 4 */ SELECT hi.nom_hipodromo_hnac, ca.num_carrera_hnac, hi.cod_hipodromo_hnac,
		ca.fec_carrera_hnac 
		FROM carrera_hnac ca, hipodromo_hnac hi
		WHERE ca.cod_carrera_hnac=%s AND hi.cod_hipodromo_hnac=ca.cod_hipodromo_hnac LIMIT 1",
            GetSQLValueString($_POST['rA'], "int")
        );
        $Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
        $row_Recordset10 = mysqli_fetch_assoc($Recordset10);
        $totalRows_Recordset10 = mysqli_num_rows($Recordset10);
        if ($totalRows_Recordset10>0) {
            if (is_file('../includes/procesar_ticket_hnac.php')) {
                include("../includes/procesar_ticket_hnac.php");
            }
        }
    }
    $updateGoTo = "admin_historial_lista_hnac.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    //header(sprintf("Location: %s", $updateGoTo));
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin_hnac\admin_dividendos_edit_hnac.php - QUERY 5 */ SELECT hi.nom_hipodromo_hnac, ca.cod_carrera_hnac, ca.num_carrera_hnac, ca.fec_carrera_hnac,
	ca.est_carrera_hnac, ca.cod_carrera_hnac
	FROM carrera_hnac ca, hipodromo_hnac hi 
	WHERE ca.cod_carrera_hnac = %s AND ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac",
    GetSQLValueString($xCarrera_Recordset1, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
list($ej1si, $di1si, , $id1si, $fa1si)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 1, 11);
list($ej2si, , , $id2si)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 2, 12);
list($ej3si, , , $id3si)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 3, 13);
list($ej4si, , , $id4si)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 4, 14);
list($ej1do, $di1do, , $id1do, $fa1do)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 1, 21);
list($ej2do, , , $id2do)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 2, 22);
list($ej3do, , , $id3do)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 3, 23);
list($ej4do, , , $id4do)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 4, 24);
list($ej1tr, $di1tr, , $id1tr, $fa1tr)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 1, 31);
list($ej2tr, , , $id2tr)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 2, 32);
list($ej3tr, , , $id3tr)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 3, 33);
list($ej4tr, , , $id4tr)=buscaDivOficiales($xCarrera_Recordset1, $row_Recordset1['fec_carrera_hnac'], 4, 34);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #eeeeee;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Ganadores y Dividendos
			</div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="height:100%; padding:70px 10px 20px 10px; text-align:left">
      <table width="100%" border="0" height="50" align="center" style="background:#0E5157; color:#FFFFFF; font-size:16px;">
        <tr>
          <td colspan="2"><?php  echo $row_Recordset1['nom_hipodromo_hnac']." Carr: ...".$row_Recordset1['num_carrera_hnac']; ?>            
		  <?php  echo " - Fecha de cierre: ".fechanueva($row_Recordset1['fec_carrera_hnac']);?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="380"></td>
          <td width="524"></td>
        </tr>
 </table>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="100%" align="center">
          <tr valign="baseline" height="40">
            <td width="61" align="right" nowrap="nowrap">&nbsp;</td>
            <td colspan="3" align="center" valign="bottom" bgcolor="#3399CC" style="color:#FFF;font-size:20px">Carrera Simple</td>
            <td width="37" valign="bottom">&nbsp;</td>
            <td colspan="2" valign="bottom">&nbsp;</td>
            <td colspan="3" align="center" valign="bottom" bgcolor="#009999" style="color:#FFF;font-size:20px">
            	Carrera Doble Empate
            </td>
            <td width="45" valign="bottom">&nbsp;</td>
            <td colspan="4" align="center" valign="bottom" bgcolor="#3399FF" style="color:#FFF;font-size:20px">
            	Carrera Triple Empate
            </td>
          </tr>
          <tr valign="baseline">
            <td width="61" align="right" nowrap="nowrap">&nbsp;</td>
            <td width="84" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="73" align="center" bgcolor="#333" style="color:#FFF">DIV</td>
            <td width="83" align="center" bgcolor="#333" style="color:#FFF">FACTOR</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td width="73" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="65" align="center" bgcolor="#333" style="color:#FFF">DIV</td>
            <td width="95" align="center" bgcolor="#333" style="color:#FFF">FACTOR</td>
            <td width="45">&nbsp;</td>
            <td width="91" align="center" bgcolor="#333" style="color:#FFF">LLEGADA</td>
            <td width="52" align="center" bgcolor="#333" style="color:#FFF">DIV</td>
            <td width="56" colspan="2" align="center" bgcolor="#333" style="color:#FFF">FACTOR</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">1er Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
				<input name="ej1si" type="text" value="<?php echo $ej1si; ?>"  
				style="width:30px; font-size:18px" maxlength="2" />
				<input type="hidden" name="id1si" value="<?php echo $id1si ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
				<input name="di1si" type="text" value="<?php echo $di1si; ?>" 
				style="width:50px; font-size:18px" size="2" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
				<input type="text" name="fa1si" value="<?php echo $fa1si; ?>" 
				style="width:50px; font-size:18px" />
            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej1do" type="text" value="<?php echo $ej1do; ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id1do" value="<?php echo $id1do ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="di1do" value="<?php echo $di1do; ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="fa1do" value="<?php echo $fa1do; ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej1tr" type="text" value="<?php echo $ej1tr; ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id1tr" value="<?php echo $id1tr ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">
                <input type="text" name="di1tr" value="<?php echo $di1tr; ?>" 
                style="width:50px; font-size:18px" />
            </td>
            <td colspan="2" align="center" bgcolor="#CCCCCC">
                <input type="text" name="fa1tr" value="<?php echo $fa1tr; ?>" 
                style="width:50px; font-size:18px" />
            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">2do Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
                    <input name="ej2si" type="text" value="<?php echo $ej2si; ?>"
                    style="width:30px; font-size:18px" maxlength="2" />
                    <input type="hidden" name="id2si" value="<?php echo $id2si ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td rowspan="3" align="center" bgcolor="#CCCCCC">
            </td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej2do" type="text"  value="<?php echo $ej2do; ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id2do" value="<?php echo $id2do ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td rowspan="3" align="center" bgcolor="#CCCCCC">
            </td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej2tr" type="text" value="<?php echo $ej2tr; ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id2tr" value="<?php echo $id2tr ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td colspan="2" rowspan="3" align="center" bgcolor="#CCCCCC">
            </td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">3er Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
				<input name="ej3si" type="text" value="<?php echo $ej3si; ?>" 
				style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id3si" value="<?php echo $id3si ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
            	<input name="ej3do" type="text" value="<?php echo $ej3do; ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id3do" value="<?php echo $id3do ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej3tr" type="text" value="<?php echo $ej3tr; ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id3tr" value="<?php echo $id3tr ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td align="right" nowrap="nowrap" bgcolor="#FFFFCC">4to Lugar:</td>
            <td align="center" bgcolor="#CCCCCC">
				<input name="ej4si" type="text" value="<?php echo $ej4si; ?>" 
				style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id4si" value="<?php echo $id4si ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej4do" type="text" value="<?php echo $ej4do; ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id4do" value="<?php echo $id4do ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center" bgcolor="#CCCCCC">
                <input name="ej4tr" type="text" value="<?php echo $ej4tr; ?>" 
                style="width:30px; font-size:18px" maxlength="2" />
                <input type="hidden" name="id4tr" value="<?php echo $id4tr ?>" />
            </td>
            <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="14"><p>&nbsp;</p>
            <p>&nbsp;</p></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="14" align="center"> 
            	<input type="submit" value="Guardar dividendos" class="btn-success" 
                	style="width:180px; height:40px; font-size:16px; margin:0px 20px 0px 0px"/>
            <a href="admin_historial_lista_hnac.php" class="btn btn-warning" 
           	style="width:100px; height:25px; font-size:16px; text-decoration:none; padding:11px 0px 0px 0px">Volver</a>
            </td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="cod" value="<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" />
        <input type="hidden" name="fec" value="<?php echo $row_Recordset1['fec_carrera_hnac']; ?>" />
      </form>
      <p>&nbsp;</p>
    </blockquote>
    </div>
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
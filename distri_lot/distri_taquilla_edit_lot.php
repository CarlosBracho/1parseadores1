<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$cod_banca = $_SESSION['MM_cod_banca'];
$xCodigo=0;
$menPrin="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction2 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$editFormAction3 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction3 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $graba=31;
    if ($_POST['min_jugtic_lot']<=0) {
        $menPrin="&nbsp;&nbsp; MONTO MÍNIMO EN TICKET INVALIDO &nbsp;&nbsp;";
        $graba--;
    }
    if ($graba==31) {
        $menPrin="&nbsp;&nbsp; DATOS GUARDADOS CORRECTAMENTE &nbsp;&nbsp;";
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 1 */ UPDATE taquilla 
				SET nom_representante=%s, tel_taquilla=%s, tel_taquilla2=%s, tel_taquilla3=%s, est_taquilla=%s
				WHERE cod_taquilla=%s",
            GetSQLValueString($_POST['nom_representante'], "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString($_POST['tel_taquilla2'], "text"),
            GetSQLValueString($_POST['tel_taquilla3'], "text"),
            GetSQLValueString($_POST['est_taquilla'], "int"),
            GetSQLValueString($_POST['cod_taquilla'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 2 */ UPDATE taquilla_opc_lot 
				SET mon_minticket_lot=%s, tic_caduca_lot=%s, pag_codigo_lot=%s, ver_porpagar_lot=%s, tip_ticket_lot=%s,
					por_taquilla_lot=%s, por_taquilla_ani=%s, cob_sistema_lot=%s, est_venta_lot=%s, est_venta_ani=%s, ord_turno=%s 
				WHERE cod_taopclot=%s",
            GetSQLValueString($_POST['min_jugtic_lot'], "int"),
            GetSQLValueString($_POST['tic_caduca_lot'], "int"),
            GetSQLValueString($_POST['pag_codigo_lot'], "int"),
            GetSQLValueString($_POST['ver_porpagar_lot'], "int"),
            GetSQLValueString($_POST['tip_ticket_lot'], "int"),
            GetSQLValueString($_POST['por_taquilla_lot'], "double"),
            GetSQLValueString($_POST['por_taquilla_ani'], "double"),
            GetSQLValueString($_POST['cos_sistema_lot'], "double"),
            GetSQLValueString($_POST['est_venta_lot'], "int"),
            GetSQLValueString($_POST['est_venta_ani'], "int"),
            GetSQLValueString($_POST['ord_turno_lot'], "int"),
            GetSQLValueString($_POST['cod_taopc_lot'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    }
}
if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
    $query_Recordset7 =  sprintf(
        "/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 3 */ SELECT ta.cod_agencia FROM taquilla ta WHERE ta.cod_taquilla = %s LIMIT 1",
        GetSQLValueString($_POST['cod_taquilla'], "int")
    );
    $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
    $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
    $totalRows_Recordset7 = mysqli_num_rows($Recordset7);
    $query_Recordset6 =  sprintf(
        "/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 4 */ SELECT 
			lo.id_loteria, lo.tip_loteria, lo.id_triple, lo.id_terminal, lo.id_sorteo, lo.nom_loteria, 
			bl.est_banlot, bl.top_venta, bl.lun_loteriabanca, bl.mar_loteriabanca, bl.mie_loteriabanca, bl.jue_loteriabanca, 
			bl.vie_loteriabanca, bl.sab_loteriabanca, bl.dom_loteriabanca
		FROM loterias lo, sorteos so, bancaloterias bl, agencia ag 
		WHERE lo.id_sorteo = so.id_sorteo AND lo.id_loteria = bl.id_loteria AND ag.cod_banca = bl.id_banca AND ag.cod_agencia = %s",
        GetSQLValueString($row_Recordset7['cod_agencia'], "int")
    );
    $Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
    $row_Recordset6 = mysqli_fetch_assoc($Recordset6);
    $totalRows_Recordset6 = mysqli_num_rows($Recordset6);
    $query_Recordset8 =  sprintf(
        "/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 5 */ SELECT cod_taquilla FROM taquilla_opc_lot WHERE cod_taquilla = %s LIMIT 1",
        GetSQLValueString($_POST['cod_taquilla'], "int")
    );
    $Recordset8 = mysqli_query($conexionbanca, $query_Recordset8) or die(mysqli_error($conexionbanca));
    $row_Recordset8 = mysqli_fetch_assoc($Recordset8);
    $totalRows_Recordset8 = mysqli_num_rows($Recordset8);
    if ($totalRows_Recordset6>0&&$totalRows_Recordset7>0&&$totalRows_Recordset8==0) {
        $menPrin="&nbsp;&nbsp; OPCIONES CREADAS CORRECTAMENTE &nbsp;&nbsp;";
        $insertSQL3 = sprintf(
            "/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 6 */ INSERT 
			INTO taquilla_opc_lot
			(cod_taquilla, mon_minticket_lot, tic_caduca_lot, pag_codigo_lot, ver_porpagar_lot, tip_ticket_lot, por_taquilla_lot, 
			por_taquilla_ani, cob_sistema_lot, est_venta_lot, est_venta_ani, tie_reclamo_lot, est_impresion_lot, ord_turno) 
			VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($_POST['cod_taquilla'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(0, "double"),
            GetSQLValueString(0, "double"),
            GetSQLValueString(0, "double"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(0, "int"),
            GetSQLValueString(1, "int")
        );
        $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
        do {
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 7 */ INSERT 
				INTO agencialoterias
				(id_agencia, id_loteria, est_agelot, top_ventaage, lun_loteria, mar_loteria, 
				mie_loteria, jue_loteria, vie_loteria, sab_loteria, dom_loteria) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset7['cod_agencia'], "int"),
                GetSQLValueString($row_Recordset6['id_loteria'], "int"),
                GetSQLValueString($row_Recordset6['est_banlot'], "int"),
                GetSQLValueString($row_Recordset6['top_venta'], "int"),
                GetSQLValueString($row_Recordset6['lun_loteriabanca'], "int"),
                GetSQLValueString($row_Recordset6['mar_loteriabanca'], "int"),
                GetSQLValueString($row_Recordset6['mie_loteriabanca'], "int"),
                GetSQLValueString($row_Recordset6['jue_loteriabanca'], "int"),
                GetSQLValueString($row_Recordset6['vie_loteriabanca'], "int"),
                GetSQLValueString($row_Recordset6['sab_loteriabanca'], "int"),
                GetSQLValueString($row_Recordset6['dom_loteriabanca'], "int")
            );
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
        } while ($row_Recordset6 = mysqli_fetch_assoc($Recordset6));
    } else {
        $menPrin="&nbsp;&nbsp; HUBO UN ERROR INTENTE NUEVAMENTE &nbsp;&nbsp;";
    }
    if (isset($Recordset6)) {
        mysqli_free_result($Recordset6);
    }
}
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 8 */ SELECT 
	ta.cod_taquilla, ta.nom_taquilla, ta.nom_representante, ta.tel_taquilla, ta.tel_taquilla2, ta.tel_taquilla3,
	ag.nom_agencia, cod_taopclot, ta.est_taquilla	
	FROM 
		taquilla ta, taquilla_opc_lot tp, agencia ag 
	WHERE ta.cod_taquilla = tp.cod_taquilla AND
		ta.cod_agencia = ag.cod_agencia AND
		ta.cod_taquilla = %s AND ag.cod_banca = %s 
	LIMIT 1",
    GetSQLValueString($xCodigo, "int"),
    GetSQLValueString($cod_banca, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$cod_taopc_lot=$row_Recordset1['cod_taopclot'];
$est_taquilla=$row_Recordset1['est_taquilla'];
if ((isset($_POST["MM_insert3"])) && ($_POST["MM_insert3"] == "form3")) {
    $query_Recordset4 =  sprintf("/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 9 */ SELECT 
		tp.tic_caduca_lot, tp.mon_minticket_lot, tp.pag_codigo_lot, tp.tip_ticket_lot, tp.por_taquilla_lot,
		tp.por_taquilla_ani, tp.cob_sistema_lot, tp.ver_porpagar_lot, est_venta_lot, est_venta_ani, tp.ord_turno
		FROM taquilla_opc_lot tp
		WHERE tp.cod_taquilla = %s LIMIT 1", GetSQLValueString($_POST["exp_taquilla"], "int"));
} else {
    $query_Recordset4 =  sprintf("/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 10 */ SELECT 
		tp.tic_caduca_lot, tp.mon_minticket_lot, tp.pag_codigo_lot, tp.tip_ticket_lot, tp.por_taquilla_lot,
		tp.por_taquilla_ani, tp.cob_sistema_lot, tp.ver_porpagar_lot, tp.est_venta_lot, tp.est_venta_ani, tp.ord_turno
		FROM taquilla_opc_lot tp
		WHERE tp.cod_taquilla = %s LIMIT 1", GetSQLValueString($xCodigo, "int"));
}
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$menNre="";
$menTel="";
$min_jugtic_lot=$row_Recordset4['mon_minticket_lot'];
$tic_caduca_lot=$row_Recordset4['tic_caduca_lot'];
$pag_codigo_lot=$row_Recordset4['pag_codigo_lot'];
$tip_taq_lot=$row_Recordset4['pag_codigo_lot'];
$ver_porpagar_lot=$row_Recordset4['ver_porpagar_lot'];
$tip_ticket_lot=$row_Recordset4['tip_ticket_lot'];
$cos_sistema_lot=$row_Recordset4['cob_sistema_lot'];
$por_taquilla_lot=$row_Recordset4['por_taquilla_lot'];
$por_taquilla_ani=$row_Recordset4['por_taquilla_ani'];
$est_venta_lot=$row_Recordset4['est_venta_lot'];
$est_venta_ani=$row_Recordset4['est_venta_ani'];
$ord_turno_lot=$row_Recordset4['ord_turno'];
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 distri_lot\distri_taquilla_edit_lot.php - QUERY 11 */ SELECT ta.cod_taquilla, ta.nom_taquilla 
FROM taquilla ta, taquilla_opc_lot tp, agencia ag 
WHERE ta.cod_taquilla = tp.cod_taquilla AND ta.cod_taquilla != %s AND ag.cod_agencia = ta.cod_agencia AND ag.cod_banca = %s
ORDER BY nom_taquilla",
    GetSQLValueString($xCodigo, "int"),
    GetSQLValueString($cod_banca, "int")
);
$Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
.textbox, .textboxsmal {
	  border: 1px solid #DBE1EB;
	  font-size: 18px;
	  font-family: Arial, Verdana;
	  padding-left: 7px;
	  padding-right: 7px;
	  padding-top: 10px;
	  padding-bottom: 10px;
	  border-radius: 4px;
	  -moz-border-radius: 4px;
	  -webkit-border-radius: 4px;
	  -o-border-radius: 4px;
	  background: #FFFFFF;
	  background: linear-gradient(left, #FFFFFF, #F7F9FA);
	  background: -moz-linear-gradient(left, #FFFFFF, #F7F9FA);
	  background: -webkit-linear-gradient(left, #FFFFFF, #F7F9FA);
	  background: -o-linear-gradient(left, #FFFFFF, #F7F9FA);
	  color: #2E3133;
	  height:20px;
  }
  .textbox:focus, .textboxsmal:focus {
	  color: #2E3133;
	  border-color: #FBFFAD;
  }
  .textboxsmal {
	  width:50px;
	  height:10px;
  }
 </style>

<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script type="text/javascript" src="../admin_lot/jslot/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);$('#divPrin').fadeOut(12000);});
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true; return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false; }
}
function ValidaSoloNumeros(){if (event.keyCode!=46){if ((event.keyCode<48) || (event.keyCode>57)) event.returnValue=false;}} 
function handleEnter (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	} 
	else
	return true;
} 
$(document).ready(function() {
$('#exp_taquilla').change(function(){if($("#exp_taquilla").val()>0) {$("#botExp").removeAttr("disabled");}
else {$("#botExp").attr('disabled', 'disabled');}});
});
  
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<div class="container">
		<div class="header" style="height:100px; background:#0084B4">
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabeceradistri_lot.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
        	id="datosUsuario">
        	<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            	margin:20px 0px 0px 0px; width:240px; font-size:16px"> 
              EDITAR TAQUILLA<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
		<div class="contentAdmin"><?php
            if ($totalRows_Recordset3>0&&$totalRows_Recordset1>0) {?>
                <div style="width:98%; float:right; text-align:right; padding:1.5% 2% 0 0; height:40px; font-size:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
                    <form method="post" name="form3" action="<?php echo $editFormAction3; ?>" onsubmit="return chequearEnvio();">
                        Exportar opciones de:
                        <select name="exp_taquilla" id="exp_taquilla" 
                        	style="width:25%; height: auto; background:#9E1C0A; color:#FFFFFF" 
                            class="textbox">
                            <option value="" style="background:#9E1C0A; color:#FFFFFF">SELECCIONE<?php
                            do {?>
                                <option value="<?php echo $row_Recordset3['cod_taquilla']?>" style="background:#FFF; color:#000">
                                    <?php echo $row_Recordset3['nom_taquilla']?></option><?php
                            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
                        </select>
                        <input name="botExp" id="botExp" type="submit"  value="Exportar" class=" btn-info" 
                            style="width:70px; height:35px; font-size:12px;" disabled="disabled"/>
                        <input type="hidden" name="MM_insert3" value="form3"/>
                    </form>
                </div><?php
            } ?>
			<div style="padding:15px 0; float:right; color:#FFFFFF; background:#FF9A9C; border: 0px solid #000000; margin:5px; 
            	font-size:20px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;
                border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px"
                id="divPrin">
				<?php echo $menPrin; ?>
			</div>
			<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto"><?php
                if ($totalRows_Recordset1>0) {?>
				<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1;">
					<form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
						<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td colspan="5" bgcolor="#0084B4" height="44" style="color:#FFF; font-size:24px; font-weight: bold;"
                              align="center">
                              DATOS DE TAQUILLA
                              </td>
                            </tr>
                            <tr>
                                <td width="1%">&nbsp;</td>
                                <td colspan="3">
                                    Nombre de taquilla:<br>
                                    <div style="width:95%;text-align:left;padding:7px 0px 7px 8px;font-size:18px;background:#FFF">
                                    <?php echo $row_Recordset1['nom_taquilla']." | Agente: ".$row_Recordset1['nom_agencia'];?>
                                    </div>
                                </td>
                                <td width="19%">Status de taquilla:<br/>
                                    <select name="est_taquilla" style="width:auto; height: auto" class="textbox">
                                    <option value="1" 
                                    <?php if (!(strcmp(1, htmlentities($est_taquilla, ENT_COMPAT, 'utf-8')))) {
                    echo "SELECTED";
                } ?>>
                                    ACTIVO
                                    </option>
                                    <option value="0" 
                                    <?php if (!(strcmp(0, htmlentities($est_taquilla, ENT_COMPAT, 'utf-8')))) {
                    echo "SELECTED";
                } ?>>
                                    INACTIVO
                                    </option>
                                    </select>
                                </td>
                            </tr>
                            <tr style="font-size:16px">
                                <td>&nbsp;</td>
                                <td width="42%">
                                    Nombre de representante:<br />
                                  <input type="text" name="nom_representante" class="textbox" tabindex="2" 
                                    placeholder="nombre completo"
                                    value="<?php echo htmlentities($row_Recordset1['nom_representante'], ENT_COMPAT, 'utf-8'); ?>" 
                                    size="42" title="indique un nombre de representante. 4-30 caracteres" 
                                    onclick="ocultaDiv('Info2');"/>
                                    <div id="Info2" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
                                    <?php echo $menNre; ?></div>
                                </td>
                                <td width="19%">
                                  Nro de contacto principal:<br />
                                  <input type="text" name="tel_taquilla" class="textbox" tabindex="3"
                                  size="32" maxlength="20" onkeypress="ValidaSoloNumeros()"
                                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla'], ENT_COMPAT, 'utf-8'); ?>"  
                                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
                                  <?php echo $menTel; ?></div>
                                </td>
                                <td width="19%">
                                  Nro de contacto 1er auxiliar:<br />
                                  <input type="text" name="tel_taquilla2" class="textbox" tabindex="4"
                                  size="32" maxlength="20" onkeypress="ValidaSoloNumeros()"
                                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla2'], ENT_COMPAT, 'utf-8'); ?>"  
                                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                                  onKeyUp="return handleEnter(this, event)"/>
                                </td>
                                <td width="19%">
                                  Nro de contacto 2do auxiliar:<br />
                                  <input type="text" name="tel_taquilla3" class="textbox" tabindex="5"
                                  size="32" maxlength="20" onkeypress="ValidaSoloNumeros()"
                                  value="<?php echo htmlentities($row_Recordset1['tel_taquilla3'], ENT_COMPAT, 'utf-8'); ?>"  
                                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                                  onKeyUp="return handleEnter(this, event)"/>
                                </td>
                            </tr>
						</table>
						<table width="920" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr valign="baseline">
                              <td height="52" colspan="10" align="center" valign="middle" nowrap 
                              style="background:#333333; font-size:24px; color: #FFF">
                              <strong>OPCIONES DE TAQUILLA LOTERIAS</strong>
                              </td>
                            </tr>
						</table>
						<div id="loteria" style="float: left; width:auto; color: #F00; width:100%">
                            <table width="100%" border="0" style="background:#0084B4;color:#FFF; font-size:10px; line-height:11px" 
                            	cellpadding="0" cellspacing="0">
                              <tbody>
                                <tr align="center">
                                  <td colspan="8">&nbsp;</td>
                                </tr>
                                <tr align="center">
                                  <td width="10%">MONTO MÍNIMO<br/>EN TICKET:<br/>
                                    <input type="text" name="min_jugtic_lot" class="textboxsmal" style="height:16px; width:70px;"
                                    onkeypress="ValidaSoloNumeros()" title="indique monto mínimo en ticket"
                                    onKeyUp="return handleEnter(this, event)"
                                    value="<?php echo htmlentities($min_jugtic_lot, ENT_COMPAT, 'utf-8'); ?>">
                                  </td>
                                  <td width="8%">TICKET<br/>CADUCA:<br/>
                                   <select name="tic_caduca_lot" style="width:59px; height: 39px" class="textbox" 
                                    title="(0) no caduca">
                                      <?php for ($i = 0; $i <= 30; $i++) {?>
                                        <option value="<?php echo $i; ?>" <?php
                                            if (!(strcmp($i, htmlentities($tic_caduca_lot, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>><?php echo $i; ?>
                                      </option>                           <?php  }?>
                                    </select>
                                  </td>
                                  <td width="17%">FORMA DE PAGAR APUESTA Y<br/>ELIMINAR TICKET:
                                    <select name="pag_codigo_lot" style="width:auto; height:40px" class="textbox" tabindex="4"> 
                                      <option value="1" <?php if (!(strcmp(1, htmlentities($pag_codigo_lot, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>SIN CÓDIGO</option>
                                      <option value="0" <?php if (!(strcmp(0, htmlentities($pag_codigo_lot, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>CON CÓDIGO</option>
                                    </select> 
                                  </td>
                                  <td width="8%">TIPO<br/>TAQUILLA:<br/>
                                      <select name="tip_taq_lot" 
                                        style="width:50px; height: 41px; font-size:20px;" class="textbox">
                                        <option value="0" 
                                        <?php if (!(strcmp(0, htmlentities($tip_taq_lot, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>A</option>
                                        <option value="1" 
                                        <?php if (!(strcmp(1, htmlentities($tip_taq_lot, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>B</option>
                                        <option value="2" 
                                        <?php if (!(strcmp(2, htmlentities($tip_taq_lot, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>C</option>
                                        <option value="3" 
                                        <?php if (!(strcmp(3, htmlentities($tip_taq_lot, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>D</option>
                                    </select>
                                  </td>
                                  <td width="10%">VER PREMIOS <br/>POR PAGAR:<br/>
                                      <select name="ver_porpagar_lot" style="width:68px; height: 39px" class="textbox">
                                        <option value="1" 
                                        <?php if (!(strcmp(1, htmlentities($ver_porpagar_lot, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>SI
                                        </option>
                                        <option value="0" 
                                        <?php if (!(strcmp(0, htmlentities($ver_porpagar_lot, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>NO
                                        </option>
                                    </select>
                                  </td>
                                  <td width="8%">TIPO<br/>DE TICKET:<br/>
                                    <select name="tip_ticket_lot" style="width:59px; height: 39px" class="textbox">
                                    <?php
                                    for ($i = 0;  $i <= 10; $i++) {?>
                                        <option value="<?php echo $i; ?>" 
                                        <?php if (!(strcmp($i, htmlentities($tip_ticket_lot, ENT_COMPAT, 'utf-8')))) {
                                        echo "SELECTED";
                                    } ?>>
                                        <?php echo $i; ?>
                                        </option><?php
                                    }?>  
                                    </select>                    
                                  </td>
                                  <td width="13%">COSTO<br/>SISTEMA:<br/>
                                    <input type="text" name="cos_sistema_lot" class="textboxsmal" style="height:16px; width:90px"
                                    onkeypress="ValidaSoloNumeros()" title="indique costo del sistema"
                                    onKeyUp="return handleEnter(this, event)"
                                    value="<?php echo htmlentities($cos_sistema_lot, ENT_COMPAT, 'utf-8'); ?>">
                                  </td>
                                  <td width="13%">%GANANCIA VENTA<br/>TRIPLES/TERM:<br/>
                                    <input type="text" name="por_taquilla_lot" class="textboxsmal" style="height:16px; width:60px"
                                    onkeypress="ValidaSoloNumeros()" title="indique costo del sistema"
                                    onKeyUp="return handleEnter(this, event)"
                                    value="<?php echo htmlentities($por_taquilla_lot, ENT_COMPAT, 'utf-8'); ?>">
                                  </td>
                                  <td width="13%">%GANANCIA VENTA<br/>ANIMALITOS:<br/>
                                    <input type="text" name="por_taquilla_ani" class="textboxsmal" style="height:16px; width:60px"
                                    onkeypress="ValidaSoloNumeros()" title="indique costo del sistema"
                                    onKeyUp="return handleEnter(this, event)"
                                    value="<?php echo htmlentities($por_taquilla_ani, ENT_COMPAT, 'utf-8'); ?>">
                                  </td>
                                </tr>
                                <tr align="center">
                                  <td>ORGANIZAR<br/>POR TURNOS:<br/>
									<select name="ord_turno_lot" style="width:68px; height: 39px" class="textbox">
                                        <option value="1" 
                                        <?php if (!(strcmp(1, htmlentities($ord_turno_lot, ENT_COMPAT, 'utf-8')))) {
                                        echo "SELECTED";
                                    } ?>>SI
                                        </option>
                                        <option value="0" 
                                        <?php if (!(strcmp(0, htmlentities($ord_turno_lot, ENT_COMPAT, 'utf-8')))) {
                                        echo "SELECTED";
                                    } ?>>NO
                                        </option>
									</select>
                                  </td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td>ACTIVAR VENTAS<br/>TRIPLES/TERM:<br/>
									<select name="est_venta_lot" style="width:68px; height: 39px" class="textbox">
                                        <option value="1" 
                                        <?php if (!(strcmp(1, htmlentities($est_venta_lot, ENT_COMPAT, 'utf-8')))) {
                                        echo "SELECTED";
                                    } ?>>SI
                                        </option>
                                        <option value="0" 
                                        <?php if (!(strcmp(0, htmlentities($est_venta_lot, ENT_COMPAT, 'utf-8')))) {
                                        echo "SELECTED";
                                    } ?>>NO
                                        </option>
									</select>
                                  </td>
                                  <td>ACTIVAR VENTAS<br/>ANIMALITOS:<br/>
									<select name="est_venta_ani" style="width:68px; height: 39px" class="textbox">
                                        <option value="1" 
                                        <?php if (!(strcmp(1, htmlentities($est_venta_ani, ENT_COMPAT, 'utf-8')))) {
                                        echo "SELECTED";
                                    } ?>>SI
                                        </option>
                                        <option value="0" 
                                        <?php if (!(strcmp(0, htmlentities($est_venta_ani, ENT_COMPAT, 'utf-8')))) {
                                        echo "SELECTED";
                                    } ?>>NO
                                        </option>
									</select>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
						</div>  
						<table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr bgcolor="#FFFFFF">
                                <td height="82" align="center" valign="bottom">
                                    <input type="submit" class="btn btn-success" value="GUARDAR CAMBIOS"
                                    style="width:180px; height:50px; font-size:16px;" />
                                </td>
                                <td align="center" valign="bottom">
                                    <a href='distri_taquillas_lista_lot.php' class="btn  btn-danger"
                                         style="width:150px; height:40px; font-size:16px; text-decoration:none; color:#FFFFFF">
                                    <div style="padding:10px 0px 0px 0px">SALIR</div>
                                  </a>
                              </td>
                        </tr>
						</table>
                        <input type="hidden" name="MM_update" value="form1">
                        <input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset1['cod_taquilla']; ?>">
                        <input type="hidden" name="cod_taopc_lot" value="<?php echo $cod_taopc_lot; ?>">
					</form>
				</div><?php
                } else {?>
					<div style="font-size:24px; text-align:center; line-height:1; padding:120px 0 ; 
                    	font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
                    	ATENCION:<br/><br/>LAS OPCIONES DE LOTERIAS PARA ESTA TAQUILLA<br/>NO HAN SIDO CREADAS
                    
                        <table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td align="center">
                                    <td height="82" align="center" valign="bottom"><?php
                                    if (isset($xCodigo) && $xCodigo>0) {?>
                                        <form method="post" name="form2" action="<?php echo $editFormAction2; ?>"  
                                            onsubmit="return chequearEnvio();">
                                            <input type="submit" class="btn btn-warning" value="CREAR OPCIONES"
                                            style="width:180px; height:50px; font-size:16px;" />
                                            <input type="hidden" name="MM_insert2" value="form2"/>
                                            <input type="hidden" name="cod_taquilla" value="<?php echo $xCodigo;?>"/>
                                        </form><?php
                                    } else {?> 
                                        <a href='distri_taquillas_lista_lot.php' class="btn  btn-danger"
                                             style="width:150px; height:40px; font-size:16px; text-decoration:none; color:#FFFFFF">
                                        	<div style="padding:10px 0px 0px 0px">SALIR</div>
										</a>
                                    <?php }?>   
                                    </td>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div><?php
                }?>
			</div>
		</div>
		<div class="footer" style="background:#0084B4">Copyright © Apuestas Hípicas</div>
	</div>
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
if (isset($Recordset3)) {
    mysqli_free_result($Recordset4);
}
if (isset($Recordset6)) {
    mysqli_free_result($Recordset6);
}
if (isset($Recordset7)) {
    mysqli_free_result($Recordset7);
}
if (isset($Recordset8)) {
    mysqli_free_result($Recordset8);
}
?>
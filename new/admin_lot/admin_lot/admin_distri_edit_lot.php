<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menPrin="";
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST["guardar"])) {
    $d=0;
    $cta=0;
    $graba=31;
    $pre_triple=$_POST['pre_triple'];
    $pre_terminal=$_POST['pre_terminal'];
    $tip_loteria=$_POST['tip_loteria'];
    $nom_loteria=$_POST['nom_loteria'];
    foreach ($_POST["idtr_banlot"] as $nom) {
        if ($pre_triple[$d]==0) {
            $menPrin="&nbsp;&nbsp; ".$nom_loteria[$d]." &nbsp;&nbsp;<br/>";
            $menPrin.="&nbsp;&nbsp;MONTO DEL PREMIO DEL TRIPLE DEBE SER MAYOR A CERO &nbsp;&nbsp;";
            $graba--;
            break;
        }
        if ($pre_terminal[$d]==0&&$tip_loteria[$d]<4) {
            $menPrin="&nbsp;&nbsp; ".$nom_loteria[$d]." &nbsp;&nbsp;<br/>";
            $menPrin.="&nbsp;&nbsp;MONTO DEL PREMIO DE TERMINAL DEBE SER MAYOR A CERO &nbsp;&nbsp;";
            $graba--;
            break;
        }
        $d++;
    }
    if ($graba==31) {
        $hor=$_POST['hor'];
        $min=$_POST['min'];
        $am=$_POST['am'];
        $nom_loteria=$_POST['nom_loteria'];
        $est_loteria=$_POST['est_loteria'];
        $id_ter_banlot=$_POST['idte_banlot'];
        $cta=0;
        $query_Recordset7 =  sprintf(
            "/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 1 */ SELECT so.id_sorteo, so.nom_sorteo
			FROM banca ba, bancaloterias bl, loterias lo, sorteos so 
			WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND lo.tip_loteria != 2 AND
			lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1
			GROUP BY so.id_sorteo
			ORDER BY lo.nom_loteria ASC",
            GetSQLValueString($xCodigo, "int")
        );
        $Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
        $row_Recordset7 = mysqli_fetch_assoc($Recordset7);
        $totalRows_Recordset7 = mysqli_num_rows($Recordset7);
        
        foreach ($_POST["idtr_banlot"] as $idl) {
            if ($am[$cta]=="PM") {
                if ($hor[$cta]!=12) {
                    $hor[$cta]=$hor[$cta]+12;
                }
            }
            $hora=$hor[$cta].":".$min[$cta].":00";
            if (!isset($_POST['lun'.$idl])) {
                $lun=0;
            } else {
                $lun=1;
            }
            if (!isset($_POST['mar'.$idl])) {
                $mar=0;
            } else {
                $mar=1;
            }
            if (!isset($_POST['mie'.$idl])) {
                $mie=0;
            } else {
                $mie=1;
            }
            if (!isset($_POST['jue'.$idl])) {
                $jue=0;
            } else {
                $jue=1;
            }
            if (!isset($_POST['vie'.$idl])) {
                $vie=0;
            } else {
                $vie=1;
            }
            if (!isset($_POST['sab'.$idl])) {
                $sab=0;
            } else {
                $sab=1;
            }
            if (!isset($_POST['dom'.$idl])) {
                $dom=0;
            } else {
                $dom=1;
            }
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 2 */ UPDATE bancaloterias 
					SET
					hor_cierre=%s,
					est_banlot=%s,
					lun_loteriabanca=%s,
					mar_loteriabanca=%s,
					mie_loteriabanca=%s,
					jue_loteriabanca=%s,
					vie_loteriabanca=%s,
					sab_loteriabanca=%s,
					dom_loteriabanca=%s,
					pre_loteria=%s
					WHERE id_banlot=%s",
                GetSQLValueString($hora, "date"),
                GetSQLValueString($est_loteria[$cta], "int"),
                GetSQLValueString($lun, "int"),
                GetSQLValueString($mar, "int"),
                GetSQLValueString($mie, "int"),
                GetSQLValueString($jue, "int"),
                GetSQLValueString($vie, "int"),
                GetSQLValueString($sab, "int"),
                GetSQLValueString($dom, "int"),
                GetSQLValueString($pre_triple[$cta], "double"),
                GetSQLValueString($idl, "int")
            );
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            if ($tip_loteria[$cta]<4) {
                $insertSQL3 = sprintf(
                    "/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 3 */ UPDATE bancaloterias 
						SET
						hor_cierre=%s,
						est_banlot=%s,
						lun_loteriabanca=%s,
						mar_loteriabanca=%s,
						mie_loteriabanca=%s,
						jue_loteriabanca=%s,
						vie_loteriabanca=%s,
						sab_loteriabanca=%s,
						dom_loteriabanca=%s,
						pre_loteria=%s
						WHERE id_banlot=%s",
                    GetSQLValueString($hora, "date"),
                    GetSQLValueString($est_loteria[$cta], "int"),
                    GetSQLValueString($lun, "int"),
                    GetSQLValueString($mar, "int"),
                    GetSQLValueString($mie, "int"),
                    GetSQLValueString($jue, "int"),
                    GetSQLValueString($vie, "int"),
                    GetSQLValueString($sab, "int"),
                    GetSQLValueString($dom, "int"),
                    GetSQLValueString($pre_terminal[$cta], "double"),
                    GetSQLValueString($id_ter_banlot[$cta], "int")
                );
                $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
            }
            $cta++;
        }
        $menPrin="&nbsp;&nbsp; LOS DATOS DEL SORTEO <strong>".$_POST['sorteo']."</strong> &nbsp;&nbsp;<br/>";
        $menPrin.="&nbsp;&nbsp; SE GUARDARON CORRECTAMENTE &nbsp;&nbsp;";
    }
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1" && isset($_POST["guardarDis"]))) {
    $graba=31;
    if ($_POST['por_lot']<0) {
        $menPrin.="&nbsp;&nbsp;COSTO DEL SISTEMA DEBE SER MAYOR O IGUAL A CERO &nbsp;&nbsp;";
        $graba--;
    }
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 4 */ UPDATE banca 
			SET
			por_banca_lot=%s, 
			mod_resultado=%s
			WHERE cod_banca=%s",
            GetSQLValueString($_POST['por_lot'], "double"),
            GetSQLValueString($_POST['mod_resultado'], "int"),
            GetSQLValueString($_POST['cod_banca'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $menPrin="&nbsp;&nbsp; DATOS DEL <strong>DISTRIBUIDOR</strong> &nbsp;&nbsp;<br/>";
        $menPrin.="&nbsp;&nbsp; SE GUARDARON CORRECTAMENTE &nbsp;&nbsp;";
    }
}
if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 5 */ UPDATE banca 
		SET
		mod_resultado=%s
		WHERE cod_banca=%s",
        GetSQLValueString(1, "int"),
        GetSQLValueString($_POST['cod_banca'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    $query_Recordset6 =  sprintf("/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 6 */ SELECT 
			lo.id_loteria, lo.tip_loteria, lo.id_triple, lo.id_terminal, lo.id_sorteo, lo.nom_loteria, 
			so.hor_sorteo, so.lun, so.mar, so.mie, so.jue, so.vie, so.sab, so.dom,
			CASE lo.tip_loteria  
				WHEN 2 THEN (/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 7 */ SELECT lot.tip_loteria FROM loterias lot WHERE lo.id_triple = lot.id_loteria LIMIT 1)
				ELSE '0'
			END AS tipo
		FROM loterias lo, sorteos so 
		WHERE lo.id_sorteo = so.id_sorteo");
    $Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
    $row_Recordset6 = mysqli_fetch_assoc($Recordset6);
    $totalRows_Recordset6 = mysqli_num_rows($Recordset6);
    if ($totalRows_Recordset6>0) {
        $menPrin="&nbsp;&nbsp; OPCIONES CREADAS CORRECTAMENTE &nbsp;&nbsp;";
        do {
            $premio=0;
            if ($row_Recordset6['tip_loteria']==1) {
                $premio=600;
            } elseif ($row_Recordset6['tip_loteria']==2) {
                if ($row_Recordset6['tipo']==1) {
                    $premio=60;
                } elseif ($row_Recordset6['tipo']==3) {
                    $premio=600;
                }
            } elseif ($row_Recordset6['tip_loteria']==3) {
                $premio=6000;
            }
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 8 */ INSERT 
				INTO bancaloterias 
				(id_banca, id_loteria, est_banlot, hor_cierre, top_venta, pre_loteria, lun_loteriabanca, mar_loteriabanca, 
				mie_loteriabanca, jue_loteriabanca, vie_loteriabanca, sab_loteriabanca, dom_loteriabanca) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($_POST['cod_banca'], "int"),
                GetSQLValueString($row_Recordset6['id_loteria'], "int"),
                GetSQLValueString(0, "int"),
                GetSQLValueString($row_Recordset6['hor_sorteo'], "date"),
                GetSQLValueString(150, "int"),
                GetSQLValueString($premio, "double"),
                GetSQLValueString($row_Recordset6['lun'], "int"),
                GetSQLValueString($row_Recordset6['mar'], "int"),
                GetSQLValueString($row_Recordset6['mie'], "int"),
                GetSQLValueString($row_Recordset6['jue'], "int"),
                GetSQLValueString($row_Recordset6['vie'], "int"),
                GetSQLValueString($row_Recordset6['sab'], "int"),
                GetSQLValueString($row_Recordset6['dom'], "int")
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
if ((isset($_POST["MM_inserto"])) && ($_POST["MM_inserto"] == "formo") && (isset($_POST["od_sorteo"]))) {
    $osorteo = implode("','", $_POST["od_sorteo"]);
    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 9 */ SELECT ba.cod_banca, ba.nom_banca, ba.por_banca_lot, ba.mod_resultado,
		bl.lun_loteriabanca, bl.mar_loteriabanca, bl.mie_loteriabanca, bl.jue_loteriabanca, bl.vie_loteriabanca, 
		bl.sab_loteriabanca, bl.dom_loteriabanca, bl.est_banlot, bl.hor_cierre, bl.pre_loteria, bl.id_banlot,
		lo.nom_loteria, lo.id_loteria, lo.id_terminal, lo.tip_loteria, so.nom_sorteo,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 10 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 11 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal LIMIT 1)
			ELSE 0
		END AS pre_terminal,	
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 12 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 13 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal LIMIT 1)
			ELSE 0
		END AS id_banlot_ter	
		FROM banca ba, bancaloterias bl, loterias lo, sorteos so 
		WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND lo.tip_loteria != 2 AND
		lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1 AND so.id_sorteo IN ('$osorteo')
		ORDER BY lo.id_sorteo ASC, let_loteria ASC",
        GetSQLValueString($xCodigo, "int")
    );
    $osorteo = $_POST["od_sorteo"];
} else {
    $osorteo=array();
    $query_Recordset1 =  sprintf(
        "/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 14 */ SELECT ba.cod_banca, ba.nom_banca, ba.por_banca_lot, ba.mod_resultado,
		bl.lun_loteriabanca, bl.mar_loteriabanca, bl.mie_loteriabanca, bl.jue_loteriabanca, bl.vie_loteriabanca, 
		bl.sab_loteriabanca, bl.dom_loteriabanca, bl.est_banlot, bl.hor_cierre, bl.pre_loteria, bl.id_banlot,
		lo.nom_loteria, lo.id_loteria, lo.id_terminal, lo.tip_loteria, so.nom_sorteo,
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 15 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 16 */ SELECT blo.pre_loteria FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal LIMIT 1)
			ELSE 0
		END AS pre_terminal,	
		CASE lo.tip_loteria
			WHEN 1 THEN (/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 17 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 18 */ SELECT blo.id_banlot FROM bancaloterias blo WHERE blo.id_loteria = lo.id_terminal LIMIT 1)
			ELSE 0
		END AS id_banlot_ter	
		FROM banca ba, bancaloterias bl, loterias lo, sorteos so 
		WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND lo.tip_loteria != 2 AND
		lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1
		ORDER BY lo.id_sorteo ASC, let_loteria ASC",
        GetSQLValueString($xCodigo, "int")
    );
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_lot\admin_distri_edit_lot.php - QUERY 19 */ SELECT so.id_sorteo, so.nom_sorteo
	FROM banca ba, bancaloterias bl, loterias lo, sorteos so 
	WHERE ba.cod_banca = %s AND bl.id_banca = ba.cod_banca AND lo.id_loteria = bl.id_loteria AND lo.tip_loteria != 2 AND
	lo.est_loteria = 1 AND lo.id_sorteo = so.id_sorteo AND so.est_sorteo = 1
	GROUP BY so.id_sorteo
	ORDER BY lo.nom_loteria ASC",
    GetSQLValueString($xCodigo, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]><link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" /><![endif]-->
<style>
body {background-color: #eeeeee;padding:0;margin:0 auto;font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;	font-size:11px;}
    #example-optionClass-container .multiselect-container li.odd {background:#eeeeee;}
    #example-optionClass-container .multiselect-all {background: #eeeeee; color:#EB0408}

</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
 <script type="text/javascript" src="jslot/bootstrap.min.js"></script>
 <script type="text/javascript" src="jslot/multiselect.js"></script>
<script>
$(document).ready(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());var refreshId1 = setInterval(function() {
$("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);$('#divPrin').fadeOut(12000);
	$('#od_sorteo').multiselect({
		includeSelectAllOption: true, // add select all option as usual
		enableCaseInsensitiveFiltering: true, numberDisplayed: 3, buttonWidth: 285, maxHeight: 500,
		optionClass: function(element) {
			var value = $(element).val();
			if (value%2 == 0) { return 'odd'; }
			else { return 'even'; }
		}
	});
	$("#filtro").css('display','');
});
var statusEnvio = false;
function chequearEnvio() {if (!statusEnvio) { statusEnvio = true; return true;} else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false; }}
function ValidaSoloNumeros(){if (event.keyCode!=46){if ((event.keyCode<48) || (event.keyCode>57)) event.returnValue=false;}} 
function handleEnter (field, event) {var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode==13) {var i;for (i = 0; i<field.form.elements.length; i++) if (field==field.form.elements[i]) break; i=(i+1) % field.form.elements.length;field.form.elements[i].focus();return false;}else return true;} 
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<div class="container">
		<div class="header" style="height:100px; background:#0084B4">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_lot.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
        	id="datosUsuario">
        	<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            	margin:20px 0px 0px 0px; width:240px; font-size:16px"> 
              EDITAR DISTRIBUIDOR<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
		<div class="contentAdmin">
			<div style="padding:15px 0; float:right; color:#FFFFFF; background:#FF9A9C; border: 0px solid #000000; margin:5px; 
            	font-size:20px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;
                border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px"
                id="divPrin">
				<?php echo $menPrin; ?>
			</div>
			<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto"><?php
                if ($totalRows_Recordset1>0) {?>
				<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
					<form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
						<table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr valign="baseline">
								<td height="52" colspan="10" align="center" valign="middle" nowrap 
									style="background:#333333; font-size:24px; color: #FFF">
									<strong>DATOS Y OPCIONES DE DISTRIBUIDOR</strong>
								</td>
							</tr>
						</table>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="37%">Nombre de Distribuidor:<br />
                                  <input type="text" class="textbox" value="<?php echo $row_Recordset1['nom_banca']; ?>" 
                                    readonly="readonly"/>
                                </td>
								<td width="19%">Costo del Sistema:<br />
                                  <input type="text" name="por_lot" class="textbox" style="height:auto; width:50px" 
                                    value="<?php echo htmlentities($row_Recordset1['por_banca_lot'], ENT_COMPAT, 'utf-8'); ?>" 
                                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                                    onKeyUp="return handleEnter(this, event)" tabindex="1" max="100"/>
                                    %
                                </td>
								<td width="27%">Resultados de loterias:<br />
								  <select name="mod_resultado" style="width:160px; height: auto" class="textbox"> 
										<option value="1" <?php
                                            if (!(strcmp(1, htmlentities($row_Recordset1['mod_resultado'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>AUTOMATICO</option>
                                      	<option value="0" <?php
                                            if (!(strcmp(0, htmlentities($row_Recordset1['mod_resultado'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>MANUAL</option>
                                    </select>
                                </td>
								<td width="17%">
									<input type="submit" name="guardarDis" class="btn btn-primary" value="GUARDAR CAMBIOS" style="width:140px; height:30px; font-size:12px; margin:5px" title="guardar datos de distribuidor" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="cod_banca" value="<?php echo $xCodigo;?>"/>
						<input type="hidden" name="MM_update" value="form1"/>
					</form>
                      <table width="100%" border="0" style="font-size:12px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;text-align:center" cellpadding="0" cellspacing="0">
                          <tr style="background:#0084B4;color:#FFFFFF" valign="bottom">
							<form action="<?php echo $editFormAction; ?>" method="POST" name="formo" id="formo" 
                                autocomplete="off" onsubmit="return chequearEnvio();">
                                <td height="30" align="left" valign="bottom" nowrap colspan="3" 
                                    style="font-size:18px;color:#FFF; padding:0 0 0 10px; display:none" id="filtro">
                                    <div style="width:350px; float:left; padding:0px 0 0 0; background:">
                                    FILTRAR POR SORTEO:
                                    </div>
                                    <div style="float:left; margin:1px 0 0 5px">
                                    <select multiple="multiple" name="od_sorteo[]" id="od_sorteo"
                                        style="width:227px; height:50px; font-size:16px;margin:2px 0 2px 10px;float:left;"><?php
                                        //$osorteo=array();
                                        do {?>
                                            <option value="<?php echo $row_Recordset2['id_sorteo']?>" 
											<?php if (in_array($row_Recordset2['id_sorteo'], $osorteo)) {
                                            echo"selected=\"selected\"";
                                        }?>>
                                            <?php echo $row_Recordset2['nom_sorteo']?></option><?php
                                        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));?>
                                    </select>
									</div>
                                    <div style="width:80px; float:left; margin:0 0 0 5px;">
									<input type="submit" value="Filtrar" class="btn btn-danger" title="iniciar busqueda" 
										onClick="return enviado()"
										style="width:80px; height:30px;"/>
									</div>
                                    <input type="hidden" name="MM_inserto" value="formo"/>
                                </td>
                                <td align="left" valign="bottom" nowrap colspan="4"> 
                                </td>
							</form>
                          </tr>
                          <tr style="background:#0084B4;color:#FFFFFF;letter-spacing: -1px;line-height: 1" valign="bottom">
                            <td width="20%" style="font-size:12px">SORTEOS</td>
                            <td width="21%" style="font-size:12px">LOTERIAS</td>
                            <td width="14%" style="font-size:11px">DIAS<br/>LU-MA-MI-JU-VI-SA-DO</td>
                            <td width="15%" style="font-size:12px">CIERRE</td>
                            <td width="10%" style="font-size:12px">PREMIO<br/>TRIPLE</td>
                            <td width="10%" style="font-size:12px">PREMIO<br/>TERMINAL</td>
                            <td width="10%" style="font-size:12px">STATUS</td>
                          </tr>
						</table><?php
                        $sorteo="";$c=0;$cambio=1;
                        $nom_sorteo=$row_Recordset1['nom_sorteo'];
                        do {
                            list($hor, $min, $am)=explode(":", cambioHoramysql($row_Recordset1['hor_cierre']));
                            if ($sorteo!=$row_Recordset1['nom_sorteo']) {
                                if ($c>0) {
                                    echo '<table width="100%" border="0">';
                                    echo '<tr valign="bottom" align="right">';
                                    echo '<td>'; ?>
										<input type="submit" name="guardar" class="btn btn-success" value="GUARDAR CAMBIOS" style="width:140px; height:30px; font-size:12px; margin:5px" title="&nbsp;guardar cambios<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo; ?>" />
                                        
										<?php
                                        echo '</td>';
                                    echo '</tr>';
                                    echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                                    echo '<td>';
                                    echo '</td>';
                                    echo '</tr>';
                                    echo '</table>';
                                    echo '</form>';
                                }
                                $cambio=1;
                                $nom_sorteo=$row_Recordset1['nom_sorteo'];
                            }
                            if ($cambio==1) {
                                echo '<form method="post" action="'.$editFormAction.'" onsubmit="return chequearEnvio();">';
                            }
                            if ($c==0) {
                                echo "<br/>";
                            } ?>
							<table width="100%" border="0" style="font-size:12px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;text-align:center;" cellpadding="0" cellspacing="0">
								<tr valign="bottom">
                                    <td width="20%" align="left" style="font-size:12px;" title="nombre de sorteo">
                                        <?php
                                        if ($sorteo!=$row_Recordset1['nom_sorteo']) {
                                            echo "&nbsp;".$row_Recordset1['nom_sorteo'];
                                            $sorteo=$row_Recordset1['nom_sorteo'];
                                            echo '<input type="hidden" name="sorteo" value="'.$sorteo.'"/>';
                                        } ?>
                                    </td>
                                    <td width="80%" align="left" style="font-size:12px;">
                                        <table width="100%" border="0">
                                            <tr class="brillo" style="border-bottom:1px solid  #D5D5D5;line-height:-1;" >
                                                <td width="27%" title="nombre de loteria">
													<?php echo "&nbsp;".$row_Recordset1['nom_loteria']; ?>
                                                </td>
                                                <td width="17%">
                                                    <input type="checkbox" name="lun<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['lun_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                            echo "checked=\"checked\"";
                                        } ?> title="lunes"/>
                                                    <input type="checkbox" name="mar<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['mar_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                            echo "checked=\"checked\"";
                                        } ?> title="martes"/>
                                                    <input type="checkbox" name="mie<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['mie_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                            echo "checked=\"checked\"";
                                        } ?> title="miercoles"/>
                                                    <input type="checkbox" name="jue<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['jue_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                            echo "checked=\"checked\"";
                                        } ?> title="jueves"/>
                                                    <input type="checkbox" name="vie<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['vie_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                            echo "checked=\"checked\"";
                                        } ?> title="viernes"/>
                                                    <input type="checkbox" name="sab<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['sab_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                            echo "checked=\"checked\"";
                                        } ?> title="sabado"/>
                                                    <input type="checkbox" name="dom<?php echo $row_Recordset1['id_banlot']; ?>" value="0" style="padding:0px; -webkit-transform: scale(1.2,1.2); transform: scale(1.2,1.2);" <?php if (!(strcmp(htmlentities($row_Recordset1['dom_loteriabanca'], ENT_COMPAT, 'utf-8'), 1))) {
                                            echo "checked=\"checked\"";
                                        } ?> title="domingo"/>
                                                </td>
                                                <td width="18%" title="hora de cierre de loteria">
                                                    <select name="hor[]"
                                                        style="width:40px;height:22px;font-size:12px;padding:0;margin:1px 0 0 0">
                                                        <?php for ($i = 1; $i <= 12; $i++) {
                                            if ($i<10) {
                                                $v="0".$i;
                                            } else {
                                                $v=$i;
                                            } ?>
                                                      <option value="<?php echo $i; ?>" <?php
                                                            if (!(strcmp($v, htmlentities($hor, ENT_COMPAT, 'utf-8')))) {
                                                                echo "SELECTED";
                                                            } ?>><?php echo $v; ?>
                                                      </option>
                                                       <?php
                                        } ?>
                                                    </select>
                                                    <select name="min[]" 
                                                    	style="width:40px;height:22px;font-size:12px;padding:0;margin:1px 0 0 -5px">
                                                        <?php for ($i = 0; $i <= 55; $i=$i+5) {
                                            if ($i<10) {
                                                $v="0".$i;
                                            } else {
                                                $v=$i;
                                            } ?>
                                                      <option value="<?php echo $i; ?>" <?php
                                                            if (!(strcmp($v, htmlentities($min, ENT_COMPAT, 'utf-8')))) {
                                                                echo "SELECTED";
                                                            } ?>><?php echo $v; ?>
                                                      </option>
                                                        <?php
                                        } ?>
                                                    </select>
                                                    <select name="am[]" 
                                                    	style="width:40px;height:22px;font-size:12px;padding:0;margin:1px 0 0 -5px">
                                                        <option value="AM" <?php
                                                        if (!(strcmp("AM", htmlentities($am, ENT_COMPAT, 'utf-8')))) {
                                                            echo "SELECTED";
                                                        } ?>>AM
                                                        </option>
                                                        <option value="PM" <?php
                                                        if (!(strcmp("PM", htmlentities($am, ENT_COMPAT, 'utf-8')))) {
                                                            echo "SELECTED";
                                                        } ?>>PM
                                                        </option>
                                                    </select>
                                                </td>
                                                <td width="13%" title="premio de triple">
                                                    <input type="text" name="pre_triple[]" style="height:20px;width:85px;font-size:12px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al triple" onKeyUp="return handleEnter(this, event)" value="<?php echo $row_Recordset1['pre_loteria']; ?>">   
                                                </td>
                                                <td width="13%" title="premio de terminal">
												  <?php if ($row_Recordset1['tip_loteria']<4) {?>
                                                        <input type="text" name="pre_terminal[]" style="height:20px;width:85px;font-size:12px;text-align:right;padding:0; margin:1px 0 0 0" onkeypress="ValidaSoloNumeros()" title="indique premio a pagar al terminal" onKeyUp="return handleEnter(this, event)" value="<?php echo $row_Recordset1['pre_terminal']; ?>">
                                                  <?php } else { ?>  
                                                        <input type="hidden" name="pre_terminal[]" value="0">
                                                  <?php } ?>
                                                </td>
                                                <td width="12%" title="status de loteria">
                                                    <select name="est_loteria[]" class="textbox" style="width:80px; height:22px; font-size:12px; padding:0; margin:1px 0 0 0;"> 
                                                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['est_banlot'], ENT_COMPAT, 'utf-8')))) {
                                                            echo "SELECTED";
                                                        } ?>>ACTIVO</option>
                                                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['est_banlot'], ENT_COMPAT, 'utf-8')))) {
                                                            echo "SELECTED";
                                                        } ?>>INACTIVO</option>
                                                    </select>
										<input type="hidden" name="idtr_banlot[]"
                                        	value="<?php echo $row_Recordset1['id_banlot']; ?>"/>
										<input type="hidden" name="idte_banlot[]"
                                        	value="<?php echo $row_Recordset1['id_banlot_ter']; ?>"/>
                                        <input type="hidden" name="tip_loteria[]" 
                                        	value="<?php echo $row_Recordset1['tip_loteria']; ?>"/>
                                        <input type="hidden" name="nom_loteria[]" 
                                        	value="<?php echo $row_Recordset1['nom_loteria']; ?>"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
								</tr>
							</table>
							
							<?php
                            $c++;
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                        echo '<table width="100%" border="0">';
                        echo '<tr valign="bottom" align="right">';
                        echo '<td>';?>
						<input type="submit" name="guardar" class="btn btn-success" value="GUARDAR CAMBIOS" style="width:140px; height:30px; font-size:12px; margin:5px" title="&nbsp;guardar cambios<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo;?>" /><?php
                        echo '</td>';
                        echo '</tr>';
                        echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                        echo '<td>';
                        echo '</td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</form>';?>
				</div><?php
                } else {?>
					<div style="font-size:24px; text-align:center; line-height:1; padding:120px 0 ; 
                    	font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
                    	ATENCION:<br/><br/>LAS OPCIONES DE LOTERIAS PARA ESTE DISTRIBUIDOR<br/>NO HAN SIDO CREADAS
                    
                        <table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td align="center">
                                    <td height="82" align="center" valign="bottom"><?php
                                    if (isset($xCodigo) && $xCodigo>0) {?>
                                        <form method="post" name="form2" action="<?php echo $editFormAction; ?>"  
                                            onsubmit="return chequearEnvio();">
                                            <input type="submit" class="btn btn-warning" value="CREAR OPCIONES"
                                            style="width:180px; height:50px; font-size:16px;" />
                                            <input type="hidden" name="MM_insert2" value="form2"/>
                                            <input type="hidden" name="cod_banca" value="<?php echo $xCodigo;?>"/>
                                        </form><?php
                                    } else {?> 
                                        <a href='admin_distri_lista_lot.php' class="btn  btn-danger"
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
?>
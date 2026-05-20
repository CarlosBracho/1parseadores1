<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$menSorteo="";
$menS="";
$menE="";
$fechahoy=fechaactualbd();
$osorteo=array();
$agencia=array();
$conforma=0;
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_inserto"])) && ($_POST["MM_inserto"] == "formo") && (isset($_POST["procesar"]))) {
    if (isset($_POST["fecha"])&&fechaymd($_POST['fecha'])<=fechaactualbd()&&isset($_POST["od_sorteo"])&&
        isset($_POST["od_agencia"])) {
    } else {
        $menS="";
        if (!isset($_POST["fecha"])) {
            $menE="<br/>&nbsp;&nbsp;Indique una fecha valida&nbsp;&nbsp;";
        } elseif (fechaymd($_POST['fecha'])>fechaactualbd()) {
            $menE="<br/>&nbsp;&nbsp;Fecha deber ser menor o igual a la actual&nbsp;&nbsp;";
        } elseif (!isset($_POST["od_agencia"])) {
            $menE="<br/>&nbsp;&nbsp;Seleccione al menos un agente&nbsp;&nbsp;";
        } elseif (!isset($_POST["od_sorteo"])) {
            $menE="<br/>&nbsp;&nbsp;Seleccione al menos un sorteo&nbsp;&nbsp;";
        }
    }
    if (isset($_POST['fecha'])) {
        $fechahoy=fechaymd($_POST['fecha']);
    } else {
        $fechahoy=fechaactualbd();
    }
    if (isset($_POST['od_agencia'])) {
        $agencia=$_POST['od_agencia'];
    }
    if (isset($_POST['od_sorteo'])) {
        $osorteo=$_POST['od_sorteo'];
    }
}
if ((isset($_POST["MM_update"])) && (isset($_POST["guardar"]))) {
}
if ((isset($_POST["MM_update2"])) && ($_POST["MM_update2"] == "form2")) {
    if (fechaymd($_POST['fecha'])<=fechaactualbd()) {
        $_POST['fecha']=fechaymd($_POST['fecha']);
        $_POST["fec_filtro"]=$_POST['fecha'];
        $fechahoy=$_POST['fecha'];
        $diahoy=diaSegunFecha($_POST['fecha']);
        $cDia=loteriaHoyAdmin($diahoy);
    }
}


$diahoy=diaSegunFecha(fechaactualbd());
$cDia=loteriaHoyAdmin($diahoy);
$query_Recordset2 = "/* PARSEADORES1 new\admin_lot\admin_devolucion_lot.php - QUERY 1 */ SELECT id_signo, nom_corto FROM signos ORDER BY id_signo";
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$query_Recordset3 =  sprintf("/* PARSEADORES1 new\admin_lot\admin_devolucion_lot.php - QUERY 2 */ SELECT so.id_sorteo, so.nom_sorteo
	FROM loterias lo, sorteos so 
	WHERE ((lo.tip_loteria = 1 OR lo.tip_loteria>=3) AND lo.est_loteria=1) AND 
	so.id_sorteo = lo.id_sorteo  AND so.est_sorteo=1
	GROUP BY so.id_sorteo
	ORDER BY lo.nom_loteria ASC");
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$query_Recordset4 =  sprintf("/* PARSEADORES1 new\admin_lot\admin_devolucion_lot.php - QUERY 3 */ SELECT ag.cod_agencia, ag.nom_agencia 
	FROM agencia ag, agencialoterias al, taquilla ta, taquilla_opc_lot tp 
	WHERE ag.cod_agencia = al.id_agencia AND ta.cod_agencia = ag.cod_agencia AND ta.cod_taquilla = tp.cod_taquilla
	GROUP BY ag.cod_agencia
	ORDER BY ag.nom_agencia ASC");
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
  .textbox, .textboxsmal {
  border: 1px solid #DBE1EB;
  font-size: 16px;
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
  height:24px;
  }
  .textbox:focus, .textboxsmal:focus {color:#2E3133;border-color:#FBFFAD;}
  .textboxsmal {width:80px;height:8px;}
  .divin {
	vertical-align:top;
	width: 33.3%;
	height: 130px;
	float: left;
	font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;
	}
    #example-optionClass-container .multiselect-container li.odd {background:#eeeeee;}
    #example-optionClass-container .multiselect-all {background: #eeeeee; color:#EB0408}
 </style>
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
<script type="text/javascript" src="jslot/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="jslot/bootstrap.min.js"></script>
<script type="text/javascript" src="jslot/multiselect.js"></script>
<script>
var xerror='<p id="mpaga" style="padding:120px 0px;"><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/><h4>Por favor intentelo de nuevo</h4></p>';
var esp1='<div style="text-align:center"><div style="padding:120px 0px;font-size:20px"><i class="fa fa-spinner fa-spin fa-2x"></i>';
var esp2='<br/><font size=2>PROCESANDO DEVOLUCION EN TICKETS ';
var esp3='</font><br/>Por favor espere...';
var esp4='</div></div>';
$(document).ready(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());var refreshId1 = setInterval(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);$('#divS').fadeOut(12000);$('#divE').fadeOut(12000);
	$('#od_sorteo, #od_agencia').multiselect({
		includeSelectAllOption: true, // add select all option as usual
		enableCaseInsensitiveFiltering: true, numberDisplayed: 1, buttonWidth: 285, maxHeight: 400,
		optionClass: function(element) {
			var value = $(element).val();
			if (value%2 == 0) { return 'odd'; }
			else { return 'even'; }
		}
	});
	$( "#od_sorteo" ).change(function() {
		var data = $("#od_sorteo option:selected").text();
		if (data=="") $("#ssorteo").html('');
		else $("#ssorteo").html('<h4 style="text-align:center;">Sorteos seleccionados:</h4><br/>'+data);
	});
	$( "#od_agencia" ).change(function() {
		var data = $("#od_agencia option:selected").text();
		if (data=="") $("#sagente").html('');
		else $("#sagente").html('<h4 style="text-align:center;">Agentes seleccionados:</h4><br/>'+data);
	});
	$('#procesar').click(function(){
		var resp = confirm("¿Confirma devolucion de tickets?");
		if (resp == true) {
			var url = "procesar_devolucion_lot.php"; form1=this.form;
			$.ajax({ type: "POST", url: url, global : false, data: $(form1).serialize(), dataType: "html",
				beforeSend: function(){ $('#divProceso').html(esp1+esp2+esp3+esp4);},
				success: function(data) {$("#divProceso").html(data);},
				error: function(){ $("#divProceso").html(xerror);}
			});
		}
	});	
});
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
	<div class="header" style="height:100px; background:#0084B4;">
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
			DEVOLUCION DE JUGADAS<br/>
		</div>
		Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
		<span id="reloj"></span>
	</div>
	<div class="contentAdmin">
		<div style="padding:5px 0px; float:right; color:#FFFFFF;background: #58D98F;font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divS">
        	<?php echo $menS; ?>
		</div>
		<div style="padding:5px 0px; float:right; color:#FFFFFF;background:#FF9A9C;font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divE">
			<?php echo $menE; ?>   
		</div>
		<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
			<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;" id="inicial">
            	<div style=" background:#333333;font-size:24px;color:#FFF; width:100%; text-align:center;
                	padding:3px 0">
					<strong>DEVOLUCION DE JUGADAS</strong>
					<?php echo '<font size="2"><br/>Fecha actual: '.verfechaF($fechahoy).'</font>'; ?>
                </div>
                <div style=" background:#FEFCE7;font-size:18px;color:#333; width:100%; text-align:center" id="divProceso">
					<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr valign="baseline" style="border-bottom:1px solid  #D5D5D5; background:#D5D5D5;">
							<form action="<?php echo $editFormAction; ?>" method="POST" name="formo" id="formo" 
                                autocomplete="off" onsubmit="return chequearEnvio();">
                                <td width="39%" height="30" align="left" valign="bottom" nowrap 
                                    style="font-size:18px;color:#000; padding:0 0 0 10px">
                                    <div style="width:350px; float:left; padding:0px 0 0 0;">
                                    SELECCIONE SORTEOS:
                                    </div>
                                    <div style="float:left; margin:1px 0 0 5px;">
                                    <select multiple="multiple" name="od_sorteo[]" id="od_sorteo"
                                        style="width:227px; height:50px; font-size:16px;margin:2px 0 2px 10px;float:left;"><?php
                                        do {?>
                                            <option value="<?php echo $row_Recordset3['id_sorteo']?>" 
											<?php if (in_array($row_Recordset3['id_sorteo'], $osorteo)) {
                                            echo"selected=\"selected\"";
                                        }?>>
                                            <?php echo str_pad($row_Recordset3['nom_sorteo'], 24, "_"); ?></option><?php
                                        } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
                                    </select>
									</div>
                                </td>
                                <td width="38%" align="left" valign="bottom" nowrap>
                                    <div style="width:300px; float:left; padding:0px 0 0 5px;">
                                        SELECCIONE AGENTE:
                                    </div>
                                    <div style="float:left; margin:1px 0 0 10px;">
                                    <select multiple="multiple" name="od_agencia[]" id="od_agencia"
                                        style="width:227px; height:50px; font-size:16px;margin:2px 0 2px 10px;float:left;"><?php
                                        do {?>
                                            <option value="<?php echo $row_Recordset4['cod_agencia']?>" 
											<?php if (in_array($row_Recordset4['cod_agencia'], $agencia)) {
                                            echo"selected=\"selected\"";
                                        }?>>
                                            <?php echo str_pad($row_Recordset4['nom_agencia'], 25, "_");?></option><?php
                                        } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));?>
                                    </select>
                                    </div>
                                </td>
								<td width="23%" align="left" valign="bottom" nowrap 
									style="font-size:18px;color:#000000;">
									FECHA:<BR/>
									<input name="fecha" type="text" id="dateArrival1" tabindex="0" 
										style="width:90px; font-size:16px; height:19px; margin:2px 0 2px 0"
										title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
										value="<?php echo htmlentities(fechanueva($fechahoy), ENT_COMPAT, 'utf-8'); ?>"/>
									<input type="submit" value="Procesar" class="btn btn-danger" 
                                    	id="procesar" name="procesar" title="iniciar proceso de devolucion" 
										style="width:80px; height:30px"/>
                                    <input type="hidden" name="MM_inserto" value="formo"/>
								</td>
							</form>
                        </tr>
                    </table>
					<div style="padding:90px 0px; text-align:center; font-size:20px; background: #FEFCE7; color:#A6A6A6"
                    	id="infor">
                        SELECCIONE LOS SORTEOS, ESCOJA LOS AGENTES, INDIQUE FECHA<br/>Y PRESIONE EL BOTON PROCESAR<br/><br/><br/>
                        <font color="RED" size="2">¡ATENCION!: ESTE PROCESO ES IRREVERSIBLE</font><br/>
                        <div style="width:230px;margin:20px 10px 0 200px;text-align:left;font-size:16px;padding:15px 15px 30px 15px; color:#333;float:left"
                        	id="ssorteo">
                        </div>
                        <div style="width:230px;margin:20px 10px 0 20px;text-align:left;font-size:16px;padding:15px 15px 30px 15px; color:#333;float:left"
                        	id="sagente">
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer" style="background:#0084B4">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
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
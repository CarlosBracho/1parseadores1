<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$cod_banca = $_SESSION['MM_cod_banca'];
$cod_agencia = $_SESSION['MM_cod_agencia'];
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}
$menS="";
$menE="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    $hora_ini="00:00:00";
    $hora_fin="23:59:00";
    $trabaja="1-1-1-1-1-1-1";
    $control=0;
    $contron=0;
    $letras = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $fecInicio=fechaactualbd();
    for ($i=0; $i<strlen($_POST['pas_usuario']); $i++) {
        if (strpos($letras, substr($_POST['pas_usuario'], $i, 1))!==false) {
            $control++;
        }
    }
    if ($control==0) {
        $menE="<br/>&nbsp;&nbsp;CLAVE DEBE CONTENER LETRAS&nbsp;&nbsp;<br/>&nbsp;";
        $graba--;
    }
    $numeros="0123456789";
    for ($i=0; $i<strlen($_POST['pas_usuario']); $i++) {
        if (strpos($numeros, substr($_POST['pas_usuario'], $i, 1))!==false) {
            $contron++;
        }
    }
    if ($contron==0) {
        $menE="<br/>&nbsp;nbsp;CLAVE DEBE CONTENER NÚMEROS&nbsp;&nbsp;<br/>&nbsp;";
        $graba--;
    }
    if ($_POST['nom_completo']=="" || strlen($_POST['nom_completo'])<=4) {
        $menE="nombre no válido";
        $graba--;
    }
    if ($_POST['pas_usuario']=="" || strlen($_POST['pas_usuario'])<=4) {
        $menE="<br/>&nbsp;&nbsp;debe contener 5 caracteres o mas&nbsp;&nbsp;<br/>&nbsp;";
        $graba--;
    }
    $hora_ini=$_POST['hor_in'].":".$_POST['min_in'].":".$_POST['am_in'];
    $hora_fin=$_POST['hor_fi'].":".$_POST['min_fi'].":".$_POST['am_fi'];
    $hora_ini=horamysql($hora_ini);
    $hora_fin=horamysql($hora_fin);
    if ($hora_ini>$hora_fin || $hora_ini==$hora_fin) {
        $menE="error en horas";
        $graba--;
    }
    if (isset($_POST['dia7'])) {
        $trabaja="1";
    } else {
        $trabaja="0";
    }
    if (isset($_POST['dia1'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia2'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia3'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia4'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia5'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia6'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if ($graba==31) {
        $menS="<br/>&nbsp;&nbsp; DATOS GUARDADOS CORRECTAMENTE &nbsp;&nbsp;<br/>&nbsp;";
        $menE="";
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 agente_lot\agente_usuario_ven_edit_lot.php - QUERY 1 */ UPDATE usuario 
				SET
				nom_completo=%s, 
				pas_usuario=%s,
				est_usuario=%s, 
				tic_eliminados=%s, 
				cod_barra=%s, 
				hor_inicio=%s, 
				hor_fin=%s, 
				dia_entrada=%s,
				can_reimpresion_lot=%s
				WHERE id_usuario=%s",
            GetSQLValueString(strtoupper($_POST['nom_completo']), "text"),
            GetSQLValueString($_POST['pas_usuario'], "text"),
            GetSQLValueString($_POST['est_usuario'], "int"),
            GetSQLValueString($_POST['tic_eliminados'], "int"),
            GetSQLValueString($_POST['cod_barra'], "int"),
            GetSQLValueString($hora_ini, "date"),
            GetSQLValueString($hora_fin, "date"),
            GetSQLValueString($trabaja, "text"),
            GetSQLValueString($_POST['can_reimpresion_lot'], "int"),
            GetSQLValueString($_POST['id_usuario'], "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    }
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 agente_lot\agente_usuario_ven_edit_lot.php - QUERY 2 */ SELECT 
	us.id_usuario, us.nom_usuario, us.nom_completo, us.tip_usuario, us.cod_taquilla, us.pas_usuario, us.est_usuario, 
	us.tic_eliminados, us.cod_barra, us.hor_inicio, us.hor_fin, us.dia_entrada, us.can_reimpresion_lot, ta.nom_taquilla
	FROM 
	usuario us, taquilla ta, agencia ag
	WHERE 
	us.id_usuario = %s AND ta.cod_taquilla = us.cod_taquilla AND us.tip_usuario = 'U' AND ag.cod_agencia = ta.cod_agencia AND
	ag.cod_banca = %s AND ag.cod_agencia = %s
	LIMIT 1",
    GetSQLValueString($xCodigo, "int"),
    GetSQLValueString($cod_banca, "int"),
    GetSQLValueString($cod_agencia, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
list($dia7, $dia1, $dia2, $dia3, $dia4, $dia5, $dia6)=explode("-", $row_Recordset1['dia_entrada']);
list($hor_in, $min_in, $am_in)=explode(":", cambioHoramysql($row_Recordset1['hor_inicio']));
list($hor_fi, $min_fi, $am_fi)=explode(":", cambioHoramysql($row_Recordset1['hor_fin']));
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
<script type="text/javascript" src="../admin_lot/jslot/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" href="../modal/css/alertify.min.css" />
<script src="../modal/js/alertify.min.js"></script>
<script>
 $(document).ready(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);$('#divPrin').fadeOut(12000);
    $('#nom_taquilla').blur(function(){
		var taquilla = $('input[name=nom_taquilla]').val();
		if(taquilla != '') { var nom_taquilla = $(this).val(); var dataString = 'nom_taquilla='+nom_taquilla;
			$.ajax({ type: "POST", url: "../includes/comprobarDistribuidor.php", data: dataString,
				success: function(data) {if (data*1!=0) { alertify.error(data); $('#nom_taquilla').focus();}}
			});
		};
    });
    $('#username').blur(function(){
		var usern = $('input[name=username]').val();
		if(usern != '') { var username = $(this).val(); var dataString = 'username='+username;
			$.ajax({ type: "POST", url: "../includes/comprobarUsuario.php", data: dataString,
				success: function(data) {if (data*1!=0) { alertify.error(data); $('#username').focus();} }
			});
		};	
    });              
});
var statusEnvio = false;
function chequearEnvio(){
	if (!statusEnvio) { statusEnvio = true; return true;} 
	else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false; }
}
function FX_passGenerator(form,element) {
	var thePass = ""; var randomchar = ""; var numberofdigits = '5';
	for (var count=1; count<=numberofdigits; count++) { 
		var chargroup = Math.floor((Math.random() * 3) + 1);
		if (chargroup==1) { randomchar = Math.floor((Math.random() * 26) + 65);}
		if (chargroup==2) { randomchar = Math.floor((Math.random() * 10) + 48);}
		if (chargroup==3) { randomchar = Math.floor((Math.random() * 26) + 97);}
		thePass+=String.fromCharCode(randomchar);
	}
	thePass = thePass.toUpperCase();
	eval('document.'+form+'.'+element+'.value = thePass');
}
function ValidaSoloNumeros() {
	if (event.keyCode != 46) { if ((event.keyCode < 48) || (event.keyCode > 57)) event.returnValue = false;}
}    
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
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
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<div class="container">
		<div class="header" style="height:100px; background:#0084B4">
			<?php include("../includes/cabeceraamericana_ag.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabeceraagente_lot.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              EDITAR DATOS DE USUARIO<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
		<div class="contentAdmin">
            <div style="padding:0px 5px; float:right; color:#FFFFFF;background: #58D98F;font-size:22px; text-align:center; 
                font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;
                border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;
                border: 0px solid #000000; margin:5px; position:absolute;" id="divS">
                <?php echo $menS; ?>
            </div>
            <div style="padding:0px 5px; float:right; color:#FFFFFF;background:#FF9A9C;font-size:22px; text-align:center;
                font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;
                border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;
                border: 0px solid #000000; margin:5px; position:absolute;" id="divE">
                <?php echo $menE; ?>   
            </div>
			<div style="padding:50px 0px 20px 0px; text-align:left; font-size:18px; height: auto">
				<form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();"
                	style="margin:0; padding:0">
				 	<div style="width:100%; text-align:left; font-size:18px; background: #E1E1E1;
                		font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="font-size:10px;border-bottom:1px solid  #D5D5D5;" height="45" align="center">
                                    <?php echo '<font size="1">TAQUILLA '.$row_Recordset1['nom_taquilla'].'</font><br/>'; ?>
                                    <?php echo '<font size="5">--- '.$row_Recordset1['nom_usuario'].' ---</font><br/>'; ?>
                                    <?php echo '<font size="2">'.$row_Recordset1['nom_completo'].'</font><br/>'; ?>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td height="36" align="center" valign="bottom" nowrap bgcolor="#333" style="color:#FFF">
                                    DATOS Y OPCIONES DE USUARIO VENDEDOR
                                </td>
                            </tr>
						</table>
                        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr valign="bottom" style="border-bottom:1px solid #D5D5D5">
                                <td width="276" align="left" nowrap>&nbsp;
									Status:<br />&nbsp;
                                    <select name="est_usuario" style="width:250px; height: auto" class="textbox"> 
										<option value="1" <?php
                                            if (!(strcmp(1, htmlentities($row_Recordset1['est_usuario'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>ACTIVO</option>
										<option value="0" <?php
                                            if (!(strcmp(0, htmlentities($row_Recordset1['est_usuario'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>INACTIVO</option>
                                    </select>
                                </td>
                                <td width="230">
                                    Contraseña de acceso:<br />
                                    <input type="text" name="pas_usuario" id="pas_usuario" size="32" class="textbox" 
                                    placeholder="contraseña" pattern="[A-Z a-z0-9]{5,20}" maxlength="20" style="height:auto"
                                    value="<?php echo $row_Recordset1['pas_usuario']?>" 
                                    tabindex="33" onKeyUp="return handleEnter(this, event)"/>
                                </td>
                                <td width="135" align="left">
                                    <input name="Botón" type="button" class="btn-primary" value="Generar clave"
                                    style="width:auto; height:40px; font-size:11px" 
                                    onClick="FX_passGenerator('form1','pas_usuario')"/>
                                </td>
                                <td width="289">
                                    Nombre completo:<br />
                                    <input type="text" name="nom_completo" class="textbox" placeholder="nombre completo" 
                                    value="<?php echo $row_Recordset1['nom_completo']?>"
                                    pattern="[A-Z a-z0-9]{4,20}" title="indique nombre completo. 4-20 caracteres" maxlength="20"
                                    onKeyUp="return handleEnter(this, event)" tabindex="34"  style="height:auto; width:250px"
                                    required size="32" />
                                </td>
                            </tr>
                        </table>
                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr align="center" style="border-bottom:1px solid #D5D5D5">
								<td width="17%">
									Ticket a eliminar:<br/>
									<select name="tic_eliminados" style="width: auto; height: auto" class="textbox" tabindex="41">
										<?php for ($i = 0; $i <= 50; $i++) {?>
										<option value="<?php echo $i; ?>" <?php
                                            if (!(strcmp($i, htmlentities($row_Recordset1['tic_eliminados'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>><?php echo $i; ?>
										</option>
										<?php  }?>
									</select>                  
								</td>
								<td width="20%">
									Tickets a reimprimir:<br/>
									<select name="can_reimpresion_lot" style="width: auto; height: auto" class="textbox">
										<?php for ($i = 0; $i <= 50; $i++) {?>
										<option value="<?php echo $i; ?>" <?php
                                            if (!(strcmp($i, htmlentities($row_Recordset1['can_reimpresion_lot'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>><?php echo $i; ?>
										</option>
										<?php  }?>
									</select>                  
								</td>
								<td width="17%">
									Codigo de barra:<br/>
                                    <select name="cod_barra" style="width: auto; height: auto" class="textbox" tabindex="36">
                                        <option value="1" <?php
                                        if (!(strcmp(1, htmlentities($row_Recordset1['cod_barra'], ENT_COMPAT, 'utf-8')))) {
                                            echo "SELECTED";
                                        } ?>>SI
                                        </option>
                                        <option value="0" <?php
                                        if (!(strcmp(0, htmlentities($row_Recordset1['cod_barra'], ENT_COMPAT, 'utf-8')))) {
                                            echo "SELECTED";
                                        } ?>>NO
                                        </option>
                                    </select>
								</td>
								<td width="23%">
									Hora de inicio de venta:<br/>
									<select name="hor_in" style="width: auto; height: auto" class="textbox" tabindex="37">
										<?php for ($i = 1; $i <= 12; $i++) {
                                            if ($i<10) {
                                                $v="0".$i;
                                            } else {
                                                $v=$i;
                                            } ?>
                                            <option value="<?php echo $i; ?>" <?php
                                                if (!(strcmp($i, htmlentities($hor_in, ENT_COMPAT, 'utf-8')))) {
                                                    echo "SELECTED";
                                                } ?>><?php echo $v; ?>
                                            </option>
										<?php
                                        }?>
									</select>
									<select name="min_in" style="width: auto; height: auto" class="textbox" tabindex="38">
                        				<?php for ($i = 0; $i <= 55; $i=$i+5) {
                                            if ($i<10) {
                                                $v="0".$i;
                                            } else {
                                                $v=$i;
                                            } ?>
											<option value="<?php echo $i; ?>" <?php
                                                if (!(strcmp($i, htmlentities($min_in, ENT_COMPAT, 'utf-8')))) {
                                                    echo "SELECTED";
                                                } ?>><?php echo $v; ?>
                                          </option>
										<?php
                                        }?>
									</select>
									<select name="am_in" style="width: auto; height: auto" class="textbox" tabindex="39">
										<option value="AM" <?php
                                            if (!(strcmp("AM", htmlentities($am_in, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>AM
                                        </option>
                                        <option value="PM" <?php
                                            if (!(strcmp("PM", htmlentities($am_in, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>PM
                                        </option>
									</select>
								</td>
								<td width="23%">
									Hora de cierre de venta:<br/>
                                    <select name="hor_fi" style="width: auto; height: auto" class="textbox" tabindex="40" 
                                        onfocus="ocultaDiv('Info37');">
                                            <?php for ($i = 1; $i <= 12; $i++) {
                                                if ($i<10) {
                                                    $v="0".$i;
                                                } else {
                                                    $v=$i;
                                                } ?>
                                                <option value="<?php echo $i; ?>" <?php
                                                if (!(strcmp($i, htmlentities($hor_fi, ENT_COMPAT, 'utf-8')))) {
                                                    echo "SELECTED";
                                                } ?>><?php echo $v; ?>
                                                </option>
                                           <?php
                                            }?>
                                    </select>
                                    <select name="min_fi" style="width: auto; height: auto" class="textbox" tabindex="41" 
                                        onfocus="ocultaDiv('Info37');">
                                            <?php for ($i = 0; $i <= 55; $i=$i+5) {
                                                if ($i<10) {
                                                    $v="0".$i;
                                                } else {
                                                    $v=$i;
                                                } ?>
                                                <option value="<?php echo $i; ?>" <?php
                                                if (!(strcmp($i, htmlentities($min_fi, ENT_COMPAT, 'utf-8')))) {
                                                    echo "SELECTED";
                                                } ?>><?php echo $v; ?>
                                                </option>
                                            <?php
                                            }?>
                                    </select>
                                      <select name="am_fi" style="width: auto; height: auto" class="textbox" tabindex="42" 
                                        onfocus="ocultaDiv('Info37');">
                                            <option value="AM" <?php
                                            if (!(strcmp("AM", htmlentities($am_fi, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>AM
                                            </option>
                                            <option value="PM" <?php
                                            if (!(strcmp("PM", htmlentities($am_fi, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>PM
                                            </option>
                                    </select>
								</td>
							</tr>
						</table>
                        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr height="100" valign="middle">
                                <td width="46%" align="right">
                                    <input type="submit" class="btn btn-success" value="GUARDAR DATOS" tabindex="50"
                                    style="width:180px; height:50px; font-size:16px;" />
                                </td>
                                <td width="4%" align="left">&nbsp;</td>
                                <td width="4%" align="left">&nbsp;</td>
                                <td width="46%" align="eft">
                                    <a href='agente_usuarios_ven_lista_lot.php' class="btn  btn-danger" 
                                    	style="width:150px; height:40px; font-size:16px;">
                                        <div style="padding:10px 0px 0px 0px">CANCELAR</div>
                                    </a>
                                </td>
                            </tr>
                        </table>
					</div>
					<input type="hidden" name="MM_insert" value="form1"/>
                    <input type="hidden" name="id_usuario" value="<?php echo $row_Recordset1['id_usuario'] ?>"/>
				</form>
			</div>
		</div>
		<div class="footer" style="background:#0084B4">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
	</div>
</body>
</html>
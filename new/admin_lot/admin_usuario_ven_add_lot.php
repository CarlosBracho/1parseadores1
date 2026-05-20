<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$hor_in="9";
$min_in="0";
$am_in="AM";
$hor_fi="11";
$min_fi="30";
$am_fi="PM";
$dia1="1";
$dia2="1";
$dia3="1";
$dia4="1";
$dia5="1";
$dia6="1";
$dia7="1";
$menDir="";
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
        $menE="CLAVE DEBE CONTENER LETRAS";
        $graba--;
    }
    $numeros="0123456789";
    for ($i=0; $i<strlen($_POST['pas_usuario']); $i++) {
        if (strpos($numeros, substr($_POST['pas_usuario'], $i, 1))!==false) {
            $contron++;
        }
    }
    if ($contron==0) {
        $menE="CLAVE DEBE CONTENER NÚMEROS";
        $graba--;
    }
    if (isset($_POST['nom_usuario']) && $_POST['nom_usuario']!="") {
        if (buscaUsu($_POST['nom_usuario'])>0) {
            $menE="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_usuario']=="" || strlen($_POST['nom_usuario'])<=4) {
        $menE="nombre no válido";
        $graba--;
    }
    if ($_POST['nom_completo']=="" || strlen($_POST['nom_completo'])<=4) {
        $menE="nombre no válido";
        $graba--;
    }
    if ($_POST['pas_usuario']=="" || strlen($_POST['pas_usuario'])<=4) {
        $menE="debe contener 5 caracteres o mas";
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
        $_POST['tip_usuario']="U";
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\admin_lot\admin_usuario_ven_add_lot.php - QUERY 1 */ INSERT 
		INTO usuario 
		(nom_usuario, nom_completo, tip_usuario, cod_taquilla, pas_usuario, est_usuario, tic_eliminados, 
		cod_barra, hor_inicio, hor_fin, dia_entrada, can_reimpresion_lot, niv_acceso) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_usuario']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_completo']), "text"),
            GetSQLValueString($_POST['tip_usuario'], "text"),
            GetSQLValueString($_POST['cod_taquilla'], "int"),
            GetSQLValueString($_POST['pas_usuario'], "text"),
            GetSQLValueString($_POST['est_usuario'], "int"),
            GetSQLValueString($_POST['tic_eliminados'], "int"),
            GetSQLValueString($_POST['cod_barra'], "int"),
            GetSQLValueString($hora_ini, "date"),
            GetSQLValueString($hora_fin, "date"),
            GetSQLValueString($trabaja, "text"),
            GetSQLValueString($_POST['can_reimpresion_lot'], "int"),
            GetSQLValueString(1, "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertGoTo = "admin_usuarios_ven_lista_lot.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$query_Recordset2 = "/* PARSEADORES1 new\admin_lot\admin_usuario_ven_add_lot.php - QUERY 2 */ SELECT ta.cod_taquilla, ta.nom_taquilla, ag.nom_agencia FROM taquilla ta, agencia ag, agencialoterias al 
	WHERE ag.cod_agencia = al.id_agencia AND ta.cod_agencia = ag.cod_agencia GROUP BY ag.cod_agencia ORDER BY ta.nom_taquilla";
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
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
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_lot.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              NUEVO USUARIO<br/>
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
                                    DATOS DEL VENDEDOR:<br />
                                    <?php echo '<font size="5">--- NUEVO USUARIO VENDEDOR ---</font><br/>'; ?>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td height="36" align="center" valign="bottom" nowrap bgcolor="#333" style="color:#FFF">
                                    DATOS Y OPCIONES DE USUARIO VENDEDOR
                                </td>
                            </tr>
						</table>
                        <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr height="70" valign="bottom">
                                <td align="left" colspan="2" nowrap>&nbsp;
                                	Taquilla: <font size="2">(agente)</font><br />&nbsp;
 									<select name="cod_taquilla" style="width:475px; height: auto" class="textbox">
										<option value="">SELECCIONE<?php
                                        do {?>
											<option value="<?php echo $row_Recordset2['cod_taquilla']?>">
												<?php echo $row_Recordset2['nom_taquilla']?>
												<?php echo " (".$row_Recordset2['nom_agencia'].")";?>
											</option><?php
                                        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));?>
									</select>
                                </td>
                                <td align="left" colspan="2">
									Status:<br />
									<select name="est_usuario" style="width:140px; font-size:14px; height:32px" class="textbox"
                                    	tabindex="4"> 
										<option value="1">ACTIVO</option>
										<option value="0">INACTIVO</option>
									</select>
                                </td>
                            </tr>
                            <tr valign="bottom" style="border-bottom:1px solid #D5D5D5">
                                <td width="276" align="left" nowrap>&nbsp;
                                    Nombre de usuario:<br>&nbsp;
                                    <input type="text" name="nom_usuario" class="textbox" id="username" value=""
                                    size="32" placeholder="nombre de usuario" tabindex="32" required style="height:auto"
                                    maxlength="20" pattern="[A-Z a-z0-9]{4,20}" title="indique un nombre de usuario. 4-20 caracteres"
                                    onKeyUp="return handleEnter(this, event)"/>
                                </td>
                                <td width="230">
                                    Contraseña de acceso:<br />
                                    <input type="text" name="pas_usuario" id="pas_usuario" size="32" class="textbox" 
                                    placeholder="contraseña" pattern="[A-Z a-z0-9]{5,20}" maxlength="20" style="height:auto"
                                    value="" tabindex="33" onKeyUp="return handleEnter(this, event)"/>
                                </td>
                                <td width="135" align="left">
                                    <input name="Botón" type="button" class="btn-primary" value="Generar clave"
                                    style="width:auto; height:40px; font-size:11px" 
                                    onClick="FX_passGenerator('form1','pas_usuario')"/>
                                </td>
                                <td width="289">
                                    Nombre completo:<br />
                                    <input type="text" name="nom_completo" class="textbox" placeholder="nombre completo" value=""
                                    pattern="[A-Z a-z0-9]{4,20}" title="indique nombre completo. 4-20 caracteres" maxlength="20"
                                    onKeyUp="return handleEnter(this, event)" tabindex="34"  style="height:auto"
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
                                            if (!(strcmp($i, htmlentities(20, ENT_COMPAT, 'utf-8')))) {
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
                                            if (!(strcmp($i, htmlentities(20, ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>><?php echo $i; ?>
										</option>
										<?php  }?>
									</select>                  
								</td>
								<td width="17%">
									Codigo de barra:<br/>
									<select name="cod_barra" style="width: auto; height: auto" class="textbox" tabindex="36">
										<option value="0">NO</option>
										<option value="1">SI</option>
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
                                    <a href='admin_usuarios_ven_lista_lot.php' class="btn  btn-danger" 
                                    	style="width:150px; height:40px; font-size:16px;">
                                        <div style="padding:10px 0px 0px 0px">CANCELAR</div>
                                    </a>
                                </td>
                            </tr>
                        </table>
					</div>
					<input type="hidden" name="MM_insert" value="form1"/>
				</form>
			</div>
		</div>
		<div class="footer" style="background:#0084B4">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
	</div>
</body>
</html>
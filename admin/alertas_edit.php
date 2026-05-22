<?php
  
 echo 'opcache_reset<br>';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menTaq="";
$menNre="";
$menTel="";
$menAmig="";	//monto apuesta minima a gan
$menMaxTicket="";
$cierre_adelantado="";
$mentope_animalito_todos="";
$menAmag="";
$menRgan="";
$menMgan="";	// monto maximo a ganar a ganador
$menMmt="";		// monto maximo en ticket
$menAmip="";	//monto apuesta minima a pla
$menAmap="";
$menRpla="";
$menMpla="";
$menAmis="";	//monto apuesta minima a sho
$menAmas="";
$menRsho="";
$menMsho="";
$menMmae="";
$menAmie="";	//monto apuesta minima a exa
$menAmae="";
$menRexa="";
$menMexa="";
$menAmit="";	//monto apuesta minima a tri
$menAmat="";
$menRtri="";
$menMtri="";
$menAmisu="";	//monto apuesta minima a sup
$menAmasu="";
$menRsup="";
$menMsup="";
$menNus="";
$menNti="";
$menTeli="";	// maximo ticket a eliminar
$menOpNac="";
$monto_apuesta="";
$factor_pago="";
//include("../includes/taquilla_estandar.php");

$xCodigo = "-1";
$xCodigo2 = "-1";
$editFormAction = $_SERVER['PHP_SELF'];
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction2 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
    $xCodigo2 = $_GET["recordID"];
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {




  $hora_inicio=str_replace("+", "-", $_SESSION['ZonaHorario']);
  //$hora_inicio = strtotime($hora_inicio, strtotime($_POST['hora_inicio']));
  $hora_inicio = strtotime('-6 hour', strtotime($_POST['hora_inicio']));
  $hora_inicio = date('H:i:s', $hora_inicio);
  
  //echo $_POST['hora_inicio']." ".$hora_inicio.$_SESSION['ZonaHorario'];
  
  $hora_fin=str_replace("+", "-", $_SESSION['ZonaHorario']);
  //$hora_fin = strtotime($hora_fin, strtotime($_POST['hora_fin']));
  $hora_fin = strtotime('-6 hour', strtotime($_POST['hora_fin']));
  $hora_fin = date('H:i:s', $hora_fin);






$insertSQL2 = sprintf(
    "/* admin\alertas_edit.php - QUERY 1 */ UPDATE alertas
        SET
    horainicio=%s, 
    horafin=%s,
    activo_archivo=%s, 
    pausa=%s,
    cont_fallos_reporte=%s,
    min_para_reportar=%s,
    link_principal=%s,	
    comentario=%s,	
    mensajealerta=%s,	
    mensajealerta_error=%s,	
    id_chat=%s,	
    id_chat_error=%s,	
    mini_para_repetir=%s WHERE Idalertas=%s",
    GetSQLValueString($hora_inicio, "date"),
    GetSQLValueString($hora_fin, "date"),
    GetSQLValueString($_POST['activo_archivo'], "int"),
    GetSQLValueString($_POST['PAUSA'], "int"),
    GetSQLValueString($_POST['CONTEO'], "int"),
    GetSQLValueString($_POST['REPORTE'], "int"),
    GetSQLValueString($_POST['link_principal'], "text"),   
    GetSQLValueString($_POST['comentario'], "text"),   
    GetSQLValueString($_POST['MENSAJE'], "text"),  
    GetSQLValueString($_POST['MENSAJE_error'], "text"), 
    GetSQLValueString($_POST['id_chat'], "text"),
    GetSQLValueString($_POST['id_chat_error'], "text"),   
    GetSQLValueString($_POST['MINIMOP'], "int"),
    GetSQLValueString($_POST['IDA'], "int")

);

$Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
}


$query_Recordset1 = sprintf("/* admin\alertas_edit.php - QUERY 2 */ SELECT *  
FROM alertas
WHERE
Idalertas = %s",
GetSQLValueString($xCodigo, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

echo $_SESSION['ZonaHorario'].' ZonaHorario';

$inicio=$row_Recordset1['horainicio'];
//$inicio = strtotime($_SESSION['ZonaHorario'], strtotime($inicio));
$inicio = strtotime('+6 hour', strtotime($inicio));
$inicio = date('H:i:s', $inicio);




$fin=$row_Recordset1['horafin'];
//$fin = strtotime($_SESSION['ZonaHorario'], strtotime($fin));
$fin = strtotime('+6 hour', strtotime($fin));
$fin = date('H:i:s', $fin);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>í</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
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
<!-- InstanceEndEditable -->
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
<link rel="stylesheet" href="../modal/css/alertify.min.css" />
<script src="../modal/js/alertify.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<!-- InstanceBeginEditable name="aHead" -->
<script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
function ValidaSoloNumerosx() {
	if (event.keyCode != 110) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
}    

function ValidaSoloNumeros(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}








function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
$(document).ready(function() {
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
 });
</script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
<div class="header" style="height:100px; background:#333">
  <?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceraadmin.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                EDITAR TAQUILLA<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
    <div style="width:98%; float:right; text-align:right; padding:1.5% 2% 0 0; height:40px; font-size:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
       
    </div>
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="POST" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
            <div style="width:920px; margin:0 auto; text-align:left; font-size:14px; background: #E1E1E1; border: 1px solid #CCC; font-family: Tahoma, Geneva, sans-serif;">
                <table width="100%" border="0" align="center" cellpadding="8" cellspacing="0">
                    <tr valign="baseline">
                        <td height="50" colspan="2" align="center" valign="middle" bgcolor="#333333" style="color:#FFF; font-size:22px; font-weight: bold;">
                            CONFIGURAR ALERTA
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td width="30%" align="right" valign="middle" style="font-weight: bold;">Nombre de Alerta:</td>
                        <td width="70%" align="left" valign="middle">
                            <input type="text" class="textbox" style="width: 90%; background: #EEE; font-weight: bold; height: auto;" readonly value="<?php echo htmlspecialchars($row_Recordset1['nombrealerta']); ?>">
                        </td>
                    </tr>
                    
                    <tr valign="baseline">
                        <td height="35" colspan="2" align="center" valign="middle" bgcolor="#F90" style="color:#FFF; font-size:15px; font-weight: bold;">
                            Parámetros de Ejecución
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Hora de Inicio:</td>
                        <td align="left" valign="middle">
                            <input type="time" name="hora_inicio" class="textbox" style="width: 200px; height: auto;" value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>">
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Hora de Fin:</td>
                        <td align="left" valign="middle">
                            <input type="time" name="hora_fin" class="textbox" style="width: 200px; height: auto;" value="<?php echo htmlentities($fin, ENT_COMPAT, 'utf-8'); ?>">
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Ejecución Código:</td>
                        <td align="left" valign="middle">
                            <select name="activo_archivo" class="textbox" style="width: 200px; height: auto;">
                                <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['activo_archivo'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>ACTIVO</option>
                                <option value="3" <?php if (!(strcmp(3, htmlentities($row_Recordset1['activo_archivo'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>INACTIVO</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Estatus de Pausa Alerta:</td>
                        <td align="left" valign="middle">
                            <select name="PAUSA" class="textbox" style="width: 200px; height: auto;">
                                <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['pausa'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>ACTIVO</option>
                                <option value="3" <?php if (!(strcmp(3, htmlentities($row_Recordset1['pausa'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>INACTIVO</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Máx. Conteo Fallos para Reportar:</td>
                        <td align="left" valign="middle">
                            <input type="text" name="CONTEO" class="textbox" style="width: 200px; height: auto;" value="<?php echo htmlentities($row_Recordset1['cont_fallos_reporte'], ENT_COMPAT, 'utf-8'); ?>">
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Minutos para Reportar:</td>
                        <td align="left" valign="middle">
                            <input type="text" name="REPORTE" class="textbox" style="width: 200px; height: auto;" value="<?php echo htmlentities($row_Recordset1['min_para_reportar'], ENT_COMPAT, 'utf-8'); ?>">
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Reposo para Repetir (segundos):</td>
                        <td align="left" valign="middle">
                            <input type="text" name="MINIMOP" class="textbox" style="width: 200px; height: auto;" value="<?php echo htmlentities($row_Recordset1['mini_para_repetir'], ENT_COMPAT, 'utf-8'); ?>">
                        </td>
                    </tr>
                    
                    <tr valign="baseline">
                        <td height="35" colspan="2" align="center" valign="middle" bgcolor="#F90" style="color:#FFF; font-size:15px; font-weight: bold;">
                            Enlaces y Comentarios
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Link Principal:</td>
                        <td align="left" valign="middle">
                            <input type="text" name="link_principal" class="textbox" style="width: 90%; height: auto;" value="<?php echo htmlentities($row_Recordset1['link_principal'], ENT_COMPAT, 'utf-8'); ?>">
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="top" style="font-weight: bold; padding-top: 12px;">Comentario:</td>
                        <td align="left" valign="middle">
                            <textarea name="comentario" class="textbox" style="width: 90%; height: 80px; font-family: Tahoma, Geneva, sans-serif; font-size: 12px; padding: 5px; resize: vertical;"><?php echo htmlentities($row_Recordset1['comentario'], ENT_COMPAT, 'utf-8'); ?></textarea>
                        </td>
                    </tr>
                    
                    <tr valign="baseline">
                        <td height="35" colspan="2" align="center" valign="middle" bgcolor="#F90" style="color:#FFF; font-size:15px; font-weight: bold;">
                            Notificaciones Telegram (Funcionamiento Normal)
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Chat Telegram:</td>
                        <td align="left" valign="middle">
                            <select name="id_chat" class="textbox" style="width: 350px; height: auto;">
                                <option value="0" <?php if (!(strcmp("0", htmlentities($row_Recordset1['id_chat'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Ningún Chat Seleccionado</option>
                                <option value="-1001639542248" <?php if (!(strcmp("-1001639542248", htmlentities($row_Recordset1['id_chat'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Operador</option>
                                <option value="-214345883" <?php if (!(strcmp("-214345883", htmlentities($row_Recordset1['id_chat'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Funcionamiento Ame Nac Ani</option>
                                <option value="-576782283" <?php if (!(strcmp("-576782283", htmlentities($row_Recordset1['id_chat'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Funcionamiento Parley</option>
                                <option value="-1001346769670" <?php if (!(strcmp("-1001346769670", htmlentities($row_Recordset1['id_chat'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Criticas</option>
                                <option value="-641022783" <?php if (!(strcmp("-641022783", htmlentities($row_Recordset1['id_chat'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Pruebas</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Mensaje Telegram:</td>
                        <td align="left" valign="middle">
                            <input type="text" name="MENSAJE" class="textbox" style="width: 90%; height: auto;" value="<?php echo htmlentities($row_Recordset1['mensajealerta'], ENT_COMPAT, 'utf-8'); ?>">
                        </td>
                    </tr>
                    
                    <tr valign="baseline">
                        <td height="35" colspan="2" align="center" valign="middle" bgcolor="#F90" style="color:#FFF; font-size:15px; font-weight: bold;">
                            Notificaciones Telegram (Mal Funcionamiento / Fallos)
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Chat Telegram Fallos:</td>
                        <td align="left" valign="middle">
                            <select name="id_chat_error" class="textbox" style="width: 350px; height: auto;">
                                <option value="0" <?php if (!(strcmp("0", htmlentities($row_Recordset1['id_chat_error'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Ningún Chat Seleccionado</option>
                                <option value="-1001639542248" <?php if (!(strcmp("-1001639542248", htmlentities($row_Recordset1['id_chat_error'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Operador</option>
                                <option value="-214345883" <?php if (!(strcmp("-214345883", htmlentities($row_Recordset1['id_chat_error'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Funcionamiento Ame Nac Ani</option>
                                <option value="-576782283" <?php if (!(strcmp("-576782283", htmlentities($row_Recordset1['id_chat_error'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Funcionamiento Parley</option>
                                <option value="-1001346769670" <?php if (!(strcmp("-1001346769670", htmlentities($row_Recordset1['id_chat_error'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Criticas</option>
                                <option value="-641022783" <?php if (!(strcmp("-641022783", htmlentities($row_Recordset1['id_chat_error'], ENT_COMPAT, 'utf-8')))) { echo "SELECTED"; } ?>>Alertas Pruebas</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #FFF;">
                        <td align="right" valign="middle" style="font-weight: bold;">Mensaje Telegram Fallos:</td>
                        <td align="left" valign="middle">
                            <input type="text" name="MENSAJE_error" class="textbox" style="width: 90%; height: auto;" value="<?php echo htmlentities($row_Recordset1['mensajealerta_error'], ENT_COMPAT, 'utf-8'); ?>">
                        </td>
                    </tr>
                    
                    <tr valign="baseline" style="background: #E1E1E1;">
                        <td colspan="2" align="center" style="padding: 20px 0;">
                            <input type="submit" class="btn badge-warning" value="GUARDAR DATOS" style="width: 180px; height: 45px; font-size: 16px; font-weight: bold; background: #F90; color: #FFF; border: 1px solid #E08000; border-radius: 4px; cursor: pointer;" />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="../admin/alertas_lista.php" class="btn btn-danger" style="display: inline-block; width: 150px; height: 35px; font-size: 16px; font-weight: bold; text-decoration: none; background: #D70000; color: #FFF; border: 1px solid #C00; border-radius: 4px; text-align: center; line-height: 35px;">
                                CANCELAR
                            </a>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="IDA" value="<?php echo $row_Recordset1['Idalertas']; ?>">
                <input type="hidden" name="MM_update" value="form1">
            </div>
        </form>
    </div>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>
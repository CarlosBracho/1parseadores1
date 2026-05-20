<?php
 opcache_reset();
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


echo $_POST['fecha_inicio'].$_POST['fecha_fin'].$_POST['STATUS'].$_POST['PAUSA'].$_POST['CONTEO'].$_POST['MM_update'];
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
$insertSQL2 = sprintf(
    "/* PARSEADORES1 admin\alertas_edit.php - QUERY 1 */ UPDATE alertas
        SET
    horainicio=%s, 
    horafin=%s,
    activo_archivo=%s, 
    pausa=%s,
    min_para_reportar=%s,
    mensajealerta=%s,	
    mini_para_repetir=%s WHERE Idalertas=%s",
    GetSQLValueString($_POST['fecha_inicio'], "date"),
    GetSQLValueString($_POST['fecha_fin'], "date"),
    GetSQLValueString($_POST['STATUS'], "int"),
    GetSQLValueString($_POST['PAUSA'], "int"),
    GetSQLValueString($_POST['REPORTE'], "int"),
    GetSQLValueString($_POST['MENSAJE'], "text"),   
    GetSQLValueString($_POST['MINIMOP'], "int"),
    GetSQLValueString($_POST['IDA'], "int")

);

$Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
}


$query_Recordset1 = sprintf("/* PARSEADORES1 admin\alertas_edit.php - QUERY 2 */ SELECT *  
FROM alertas
WHERE
Idalertas = %s",
GetSQLValueString($xCodigo, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$inicio=$row_Recordset1['horainicio'];
$fin=$row_Recordset1['horafin'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
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
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:13px">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	CONFIGURAR ALERTA
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" valign="middle" nowrap><br>
                  	<div style="width:98.5%; text-align:left; padding:6px 0px 6px 8px; font-size:18px; background: #FFF">
                    Nombre de alerta:
                  	<?php echo $row_Recordset1['nombrealerta']; ?>
                    </div>
                    <br>
                  </td>


                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
              
                


<table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">

                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">EDITAR ALERTAS</td>
                </tr>
               
                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#00fbff"> 
               HORAS
                  </td>
                </tr>

                <tr valign="baseline">
            <td nowrap align="left">Hora Inicio</td>
            <td>
            <input type="time" name="fecha_inicio" id="datepicker" style="width:140px; height: auto" value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>" />

            </td>

            <td nowrap align="left">Hora fin</td>
            <td>
            <input type="time" name="fecha_fin" id="datepicker" style="width:140px; height: auto" value="<?php echo htmlentities($fin, ENT_COMPAT, 'utf-8'); ?>" />

            </td>

            </tr>

            <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#00fbff"> 
               DESACTIVAR ALERTA
                  </td>
                </tr>
          
                <tr valign="baseline">
            <td nowrap align="left">STATUS ALERTA</td>
            <td>
            <select name="STATUS" style="width:140px; height: auto" class="textbox" tabindex="4"> 
					                        <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['activo_archivo'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="3" <?php if (!(strcmp(3, htmlentities($row_Recordset1['activo_archivo'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
                  </select>
            </td>
           </tr>


           <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#00fbff"> 
               PAUSAR ALERTA
                  </td>
                </tr>
          
                <tr valign="baseline">
            <td nowrap align="left">STATUS DE PAUSA ALERTA</td>
            <td>
            <select name="PAUSA" style="width:140px; height: auto" class="textbox" tabindex="4"> 
					                        <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['pausa'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>ACTIVO</option>
                      <option value="3" <?php if (!(strcmp(1, htmlentities($row_Recordset1['pausa'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>INACTIVO</option>
                  </select>
            </td>
           </tr>

           <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#00fbff"> 
               MAXIMO DE CONTEO DE FALLOS PARA REPORTAR
                  </td>
                </tr>

                <tr valign="baseline">
            <td nowrap align="left">NUMERO DE CONTEOS</td>
            <td>
            <input type="text" name="CONTEO" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
              value="<?php echo htmlentities($row_Recordset1['cont_fallos_reporte'], ENT_COMPAT, 'utf-8'); ?>" 
              size="10"/>
            </td>
           </tr>

           <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#00fbff"> 
               MINUTOS QUE TIENEN QUE PASAR PARA REPORTAR
                  </td>
                </tr>

                <tr valign="baseline">
            <td nowrap align="left">INGRESE MINUTOS</td>
            <td>
            <input type="text" name="REPORTE" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
              value="<?php echo htmlentities($row_Recordset1['min_para_reportar'], ENT_COMPAT, 'utf-8'); ?>" 
              size="10"/>
              <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
              <?php echo $row_Recordset1['min_para_reportar']; ?></div>
            </td>
           </tr>
           
           <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#00fbff"> 
               MINIMO PARA REPETIR LA ALERTA(OPCION NUEVA)
                  </td>
                </tr>

                <tr valign="baseline">
            <td nowrap align="left">POR SEGUNDOS SE INGRESA</td>
            <td>
            <input type="text" name="MINIMOP" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
              value="<?php echo htmlentities($row_Recordset1['mini_para_repetir'], ENT_COMPAT, 'utf-8'); ?>" 
              size="10"/>
            </td>
           </tr>

           <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#00fbff"> 
               MENSAJE QUE ENVIA LA ALERTA
                  </td>
                </tr>

                <tr valign="baseline">
            <td nowrap align="left">INGRESE MENSAJE</td>
            <td>
            <input type="text" name="MENSAJE" class="textboxsmal" style="height:100px; width:400px" onclick="ocultaDiv('Info4');"
              value="<?php echo htmlentities($row_Recordset1['mensajealerta'], ENT_COMPAT, 'utf-8'); ?>" 
              size="10"/>
            </td>
           </tr>

<input type="hidden" name="IDA" value="<?php echo $row_Recordset1['Idalertas']; ?>">
           











                <tr valign="baseline">
                  <td height="20" colspan="11" align="center" valign="bottom" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                </tr>
                </table>
              <table width="924" align="center">
                <tr valign="baseline">
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="362" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>

                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <!--<td align="center" valign="bottom" nowrap>
                  <a href='../agente/agente_restringir_jugadas_parley.php?recordID=<?php //echo $row_Recordset1['cod_taquilla']; ?>' target="_blank" class="btn btn-success" style="width:180px; height:40px; font-size:16px;">
                  <div style="padding:10px 0px 0px 0px">BLOQUEAR JUGADAS</div></a>
                  </td>-->
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  
                  <td align="right" valign="bottom" nowrap>
                  <a href='../admin/alertas_lista.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="37" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="9" align="left" nowrap>&nbsp;</td>
                </tr>

              </table>
               
          </div>
          <input type="hidden" name="MM_update" value="form1">

          <?php
?>
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
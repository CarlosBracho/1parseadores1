<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "S"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$horaactual=horaactual();
$fechasistema=fechaactualbd();
$fecha=fechanueva(fechaactualbd());
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechasistema=fechaymd($_POST["mostrarhasta"]);
    $fecha=$_POST["mostrarhasta"];
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    if ($graba==31) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 multidistri\distri_crear_mensaje_ataquilla.php - QUERY 1 */ INSERT 
		INTO mensajesyalertas 
		(para, tipo, mensaje, mostrarhasta, creadopor) 
		VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString($_POST['cod_taquilla'], "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['mensaje'], "text"),
            GetSQLValueString($fechasistema, "date"),
            GetSQLValueString(2, "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertGoTo = "distri_mensajesyalertas.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$query_Recordset2 = sprintf(
    "/* PARSEADORES1 multidistri\distri_crear_mensaje_ataquilla.php - QUERY 2 */ SELECT taquilla.cod_taquilla, taquilla.nom_taquilla 
			FROM 
				taquilla,
			 	agencia,
				banca,
        multidistriMD
			WHERE
				taquilla.cod_agencia = agencia.cod_agencia AND
				agencia.cod_banca = banca.cod_banca AND
        multidistriMD.cod_multidistriMD = banca.cod_multidistriMDBA AND
				multidistriMD.cod_multidistriMD = %s",
    GetSQLValueString($_SESSION['MM_cod_multidistriMD'], "int")
);
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<style>
  .textbox, .textboxsmal
  {
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
  .textbox:focus, .textboxsmal:focus
  {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxsmal
  {
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
$(document).ready(function() {    
    $('#username').blur(function(){
		var usern = $('input[name=username]').val();
		if(usern != '') {
			var username = $(this).val();        
			var dataString = 'username='+username;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarUsuario.php",
				data: dataString,
				success: function(data) {
					$('#Info32').fadeIn(200).html(data);
				}
			});
		};	
    });              
});    
function FX_passGenerator(form,element) {
  var thePass = "";
  var randomchar = "";
  var numberofdigits = '5';
  for (var count=1; count<=numberofdigits; count++) {
    var chargroup = Math.floor((Math.random() * 3) + 1);
    if (chargroup==1) {
      randomchar = Math.floor((Math.random() * 26) + 65);
    }
    if (chargroup==2) {
      randomchar = Math.floor((Math.random() * 10) + 48);
    }
    if (chargroup==3) {
      randomchar = Math.floor((Math.random() * 26) + 97);
    }
    thePass+=String.fromCharCode(randomchar);
  }
  thePass = thePass.toUpperCase();
  eval('document.'+form+'.'+element+'.value = thePass');
}
function ValidaSoloNumeros() {
	$('#imprimir').prop("disabled", false);
	cuenta=0;
	if ((event.keyCode < 48) || (event.keyCode > 57)) 
  		event.returnValue = false;
}    
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
</script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana_multidistri.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 30px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceramultidistri.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                Crear Mensaje a Taquilla<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
	
	
	
	
	
	
        <form method="post" name="form1" id="form1" action="<?php echo $editFormAction; ?>"  autocomplete="off" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	Crear Mensaje a Taquilla
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="365" align="left" valign="middle" nowrap>Seleccione Taquilla:<br>

                    <select name="cod_taquilla" style="width:327px; height: auto" class="textbox"  required="required">
					                    <option value="">SELECCIONE

                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_Recordset2['cod_taquilla']?>">
                        <?php echo $row_Recordset2['nom_taquilla']?></option>
                    <?php
                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                    ?>
                    </select>
					
					
				 
				 
				 
				 

                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="365" align="left" valign="middle" nowrap>Selecione Hasta Que Fecha Desea Que Se Muestre:<br>


					
					
					
					
					                <input name="mostrarhasta" type="text" id="mostrarhasta" form="form1" tabindex="1" 
                	style="width:100px; font-size:18px; height: 24px; background-color: #FFFFFF;"
                    title="fecha inicio. formato: aaaa-mm-dd" class="tcal" 
                    value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
                <input type="hidden" name="MM_update" value="form1" />

				 
				 
				 
				 
				 
                  </td>
                  <td width="117">&nbsp;</td>
                  <td width="232">&nbsp;</td>
                  <td width="180">&nbsp;</td>
                
                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">
                  Escriba El Mensaje A Continuacion</td>
                </tr>
              </table>
              <table width="921" align="center">
                <tr valign="baseline">
                  <td  align="center" nowrap>
				                        <input type="text" name="mensaje" class="textboxLargo" 
                      size="100" value="" style="width:800px; height:50px;" id="mensaje" required="required"
                      title="" maxlength="140"
                      onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
				  
				  
				  </td>

				  
				  
				  
                </tr>
              </table>
<table width="924" align="center">
            <tr valign="baseline">
              <td colspan="11" align="left" nowrap>&nbsp;</td>
              </tr>
                <tr valign="baseline">
                  <td colspan="11" align="left" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                  </tr>
                <tr valign="baseline">
                  <td width="37" align="left" nowrap>&nbsp;</td>
                  <td width="482" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR MENSAJE A TAQUILLA"  tabindex="50"
                  	style="width:482px; height:50px; font-size:16px;" />
                  </td>

                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="206" colspan="2" align="right" valign="bottom" nowrap>
                  <a href='distri_mensajesyalertas.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="36" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="10" align="left" nowrap>&nbsp;</td>
                  </tr>
              </table>
               
          </div>
          <input type="hidden" name="MM_insert" value="form1"/>
          <input type="hidden" name="tip_usuario" value="D"/>
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
mysqli_free_result($Recordset2);
?>
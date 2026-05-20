<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//include ("file.php");
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$fechahora=fechaactualbd().' '.horaactual();

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;

    if ($graba==31) {








      $query_Recordset2c = sprintf(
        "/* PARSEADORES1 admin\1cobranza_agregar.php - QUERY 1 */ SELECT  * FROM  cobranza WHERE identificadorCOB = %s AND tipoclienteCOB=2  ORDER BY idcobranzaCOB DESC LIMIT 1", 
        GetSQLValueString($_POST['cod_multidistriMD'], "int"));
    $Recordset2c = mysqli_query($conexionbanca, $query_Recordset2c) or die(mysqli_error($conexionbanca));
    $row_Recordset2c = mysqli_fetch_assoc($Recordset2c);
    $totalRows_Recordset2c = mysqli_num_rows($Recordset2c);

    $montototal=0;
if($totalRows_Recordset2c==1){
  $montototal=$_POST['montoagregarCOB']+$row_Recordset2c['montototalCOB'];
}else{

  $montototal=$_POST['montoagregarCOB'];
}





      
        $insertSQL3 = sprintf(
            "/* PARSEADORES1 admin\1cobranza_agregar.php - QUERY 2 */ INSERT 
		INTO cobranza 
		(tipoCOB, comentarioCOB, tipoclienteCOB, identificadorCOB, montoagregarCOB, montototalCOB, confirmadoCOB, fechacreacionCOB, 
		fechaconfirmacionCOB) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($_POST['tipoCOB'], "int"),
            GetSQLValueString(strtoupper($_POST['comentarioCOB']), "text"),
            GetSQLValueString(2, "int"),
            GetSQLValueString($_POST['cod_multidistriMD'], "int"),
            GetSQLValueString($_POST['montoagregarCOB'], "double"),
            GetSQLValueString($montototal, "double"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($fechahora, "date"),
            GetSQLValueString($fechahora, "date")
        );
        
        $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));










        
    }
}

$query_Recordset2 = "/* PARSEADORES1 admin\1cobranza_agregar.php - QUERY 3 */ SELECT * FROM multidistriMD WHERE cod_multidistriMD >=2";
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas HÃ­picas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
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
    } else { alert("El formulario ya estÃ¡ siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
$(document).ready(function() {    
    $('#nom_taquilla').blur(function(){
		var taquilla = $('input[name=nom_taquilla]').val();
		if(taquilla != '') {
			var nom_taquilla = $(this).val();        
			var dataString = 'nom_taquilla='+nom_taquilla;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarAgente.php",
				data: dataString,
				success: function(data) {
					$('#Info1').fadeIn(200).html(data);
				}
			});
		};
    });              
});
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
	if (event.keyCode != 46) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
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
                AGREGAR REGISTRO A COBRANZA<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
		             
        
        
        
        







        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	AGREGAR REGISTRO EN COBRANZA
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" valign="middle" nowrap>Multi Distribuidor:<br>
                 

 <select name="cod_multidistriMD" style="width:247px; height: auto" class="textbox"  require>
                    <option value="">SELECCIONE
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_Recordset2['cod_multidistriMD']?>">
                        <?php echo $row_Recordset2['nom_multidistriMD']?></option>
                    <?php
                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                    ?>
                    </select>













<br />
                  SELECIONE TIPO DE REGISTRO:<br /><br />

                  <select name="tipoCOB" style="width:140px; height: auto" class="textbox" tabindex="4" require> 
                      
                      <option value="0">REGISTRO DE COBRANZA</option>
                      <option value="1">REGISTRO DE PAGO</option>
                      <option value="2">AJUSTE DE CUENTA</option>
					</select>










                  <td width="232">&nbsp;</td>
                  <td width="180">&nbsp;</td>
                <tr valign="baseline">
                  <td align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="240" align="left" valign="middle" nowrap>
                  MONTO A AGREGAR:<br>
                    <input type="text" name="montoagregarCOB" id="nom_taquilla" class="textbox" tabindex="1"
                    value="" 
                    size="32" placeholder="Monto a agregar" title="indique un monto 1-30 caracteres" 
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info1');"
                    maxlength="33"  required/>
                    <div id="Info1" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">

                  </td>


                  <td align="left">

                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
					Comentario:
                  	<input type="text" name="comentarioCOB" class="textbox" placeholder="indique comentario" maxlength="300"
                     title="indique comentario. 4-150 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34"
                    value="" style="width:750px"
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
                 </td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
              </table>  

              





<table width="924" align="center">
            <tr valign="baseline">
              <td colspan="11" align="left" nowrap bgcolor="#5EAEFF">&nbsp;</td>
              </tr>
                <tr valign="baseline">
                  <td width="37" align="left" nowrap>&nbsp;</td>
                  <td width="182" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="70" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="199" colspan="2" align="right" valign="bottom" nowrap>
                  <a href='agencias_listas.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="43" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="10" align="left" nowrap>&nbsp;</td>
                  </tr>
              </table>
               
          </div>
          <input type="hidden" name="MM_insert" value="form1"/>
          <input type="hidden" name="tip_usuario" value="G"/>
      </form>
    </div>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright Â© Apuestas HÃ­picas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset2);
?>
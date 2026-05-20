<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A,G,D,U,S"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$idUsuario=$_SESSION['MM_id_usuario'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset1 = sprintf("/* PARSEADORES1 ventas\ventas_cambiar_clave_usuario.php - QUERY 1 */ SELECT * FROM usuario WHERE usuario.id_usuario = %s", GetSQLValueString($idUsuario, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$guardar=0;
$mensaje="";
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $control=0;
    $contron=0;
    $mensaje="";
    for ($i=0; $i<strlen($_POST['pas_usuario']); $i++) {
        if (strpos($letras, substr($_POST['pas_usuario'], $i, 1))!==false) {
            $control++;
        }
    }
    if ($row_Recordset1['pas_usuario']!=$_POST['password_antigua']) {
        $guardar=1;
        $mensaje="CLAVE ACTUAL INVALIDA";
    }
    if ($_POST['pas_usuario']=="") {
        $mensaje="INDIQUE NUEVA CLAVE";
    }
    if (strlen($_POST['pas_usuario'])<=2) {
        $mensaje="CLAVE DEBE CONTENER 3 CARACTERES COMO MÍNIMO";
    }
    if (strlen($_POST['pas_usuario'])>=21) {
        $mensaje="CLAVE DEBE CONTENER 20 CARACTERES COMO MÁXIMO";
    }
    if ($_POST['pas_usuario']!="" && strlen($_POST['pas_usuario'])>=3 && strlen($_POST['pas_usuario'])<=21 &&
        $row_Recordset1['pas_usuario']==$_POST['password_antigua']) {
        $updateSQL = sprintf(
            "/* PARSEADORES1 ventas\ventas_cambiar_clave_usuario.php - QUERY 2 */ UPDATE usuario SET pas_usuario=%s WHERE id_usuario=%s",
            GetSQLValueString($_POST['pas_usuario'], "text"),
            GetSQLValueString($idUsuario, "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        $guardar=2;
        $mensaje="DATOS GUARDADOS<br>CORRECTAMENTE!";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script LANGUAGE="JavaScript">
var cuenta=0;
function enviado() { 
	if (cuenta == 0) {
		cuenta++;
		return true;
	}
	else { 
		alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
	return false;
	}
}
// -->
</script>
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<style>
.textbox .textboxsmal {  border: 1px solid #DBE1EB;
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
}
.textbox {	  
	width:150px;
	height:25px;
}
.textboxsmal {	  
	width:90px;
	height:25px;
}
</style>
<script>
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
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div style="background: #333; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center">
       CAMBIAR CLAVE
  </div><!-- end .container -->
  <div style="background: #FFF; width:100%; float:left; padding:25px 0px 0px 10px; font-size:18px">
    <?php if ($guardar!=2) { ?>
     <form action="<?php echo $editFormAction; ?>" method="post" 
     	name="form1" id="form1" autocomplete="off" onsubmit="return chequearEnvio();">
         <center>
         <div style="background: #FFF; width:100%; float:left; padding:25px 0px 0px 70px;">
        	CLAVE ACTUAL: 
          <input type="text" name="password_antigua" value="" maxlength="20" class="textboxsmal" 
            title="indique clave actual" onclick="ocultaDiv('Info1'),ocultaDiv('Info2');"/>
        </div>

        
       <div style="background: #FFF; width:100%; float:left; padding:0px 0px 0px 66px;">
        	NUEVA CLAVE: 
			<input type="text" name="pas_usuario" id="pas_usuario" size="32" 
            pattern="[A-Z a-z0-9]{3,20}" maxlength="20" class="textboxsmal"
            value="" tabindex="33" style="font-size:22px"/>

            </div>
            

            <div style="background: #FFF; width:100%; float:left; padding:0px 0px 0px 0px; font-size:12px; 
            color:#C30; text-align:center">
            	Recomendamos colocar por lo menos una letra o un numero<br/> se aceptan como minimo de 3 caracteres y un maximo de 20 ej: 12A
            </div>

       <div style="background: #FFF; width:100%; float:left; text-align:center; padding:50px 0px 0px 0px;">
           <input id="btsubmit" onclick="return enviado()" type="submit" value="GUARDAR CAMBIOS" 
           class="btn-success" title="guardar cambios" style="font-size:18px; height:40px" />
        </div>
        </center>
        <center>
        <div>
            <input name="Botón" type="button" class="btn-danger" value="Generar clave"
            style="width:auto; height:40px; font-size:11px" 
            onClick="FX_passGenerator('form1','pas_usuario')"/>
        </div>
        </center>
            
       <input type="hidden" name="MM_update" value="form1" />
    </form>
        <div style="background: #FFF; width:100%; float:left; padding:30px 0px 0px 0px; font-size:24px;
        line-height:25px; text-align:center; color:#FF3333" id="Info1">
        <?php echo $mensaje; ?>
        </div>
    <?php } else {?>
        <div style="background: #FFF; width:100%; float:left; padding:60px 0px 0px 0px; font-size:24px;
        line-height:25px; text-align:center; color: #393" id="Info2">
        <?php echo $mensaje; ?>
        </div>
  <?php }?>
</div>  
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
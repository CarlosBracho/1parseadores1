<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}

$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\caballos_retirar_add.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", GetSQLValueString($xCarrera_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $_POST['cod_carrera']=$xCarrera_Recordset1;
    $insertSQL = sprintf(
        "/* PARSEADORES1 new\admin\caballos_retirar_add.php - QUERY 2 */ INSERT INTO retirados (cod_carrera, num_rcaballo) VALUES (%s, %s)",
        GetSQLValueString($_POST['cod_carrera'], "int"),
        GetSQLValueString($_POST['num_rcaballo'], "int")
    );

  
    $nom_usuario=$_SESSION['MM_nom_usuario'];
    $carrera=$nom_hipodro." Carr...".$num_carrera;
    $descripcion="SE HIZO UN RETIRO MANUAL AME <strong>".$_POST['cod_carrera'].' --- '.$_POST['num_rcaballo']."</strong> por: <u>".$nom_usuario."</u>";
    $horaactual=horaactual();
    $fechaactual=fechaactualbd();
    $insertSQL2 = sprintf(
        "/* PARSEADORES1 new\admin\caballos_retirar_add.php - QUERY 3 */ INSERT 
					INTO bitacora 
					(des_bitacora, hor_bitacora, fec_bitacora) 
					VALUES (%s, %s, %s)",
        GetSQLValueString($descripcion, "text"),
        GetSQLValueString($horaactual, "date"),
        GetSQLValueString($fechaactual, "date")
    );
    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
  
    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    $tipoProceso=4;
    $num_caballo=$_POST['num_rcaballo'];
    $cod_carrera=$_POST['cod_carrera'];
    if (is_file('../includes/procesar_resultados_tickets_ame.php')) {
        include("../includes/procesar_resultados_tickets_ame.php");
    }
    $insertGoTo = "caballos_retirar_add.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}
$query_Recordset2 = "/* PARSEADORES1 new\admin\caballos_retirar_add.php - QUERY 4 */ SELECT * FROM retirados";
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
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
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
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
                Retiro de Ejemplar <br/>por Carreras
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="height:100%; padding:70px 10px 110px 10px; text-align:left">
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:18px">
  <tr>
    <td height="34" align="center" valign="middle" class="tablajugada"><strong><?php echo ObtenerNombreynumeroJugadaCarrera($row_Recordset1['cod_carrera']); ?></strong></td>
  </tr>
  <tr>
    <td align="center"><?php echo "Hora: ".$row_Recordset1['hor_carrera']; ?></td>
  </tr>
  <tr>
    <td align="right"  style="background:#5EAEFF; color:#FFFFFF; height:30px;">
		<?php echo "Ejemplares retirados: ".BuscarRetirados($row_Recordset1['cod_carrera']);?>
    </td>
  </tr>
</table>
<br/>
<?php
for ($i = 1 ; $i <= 30 ; $i ++) {
    //$dias($i) = array($i=>$i);
    $identificador=RetiradosSimple($row_Recordset1['cod_carrera'], $i);
    if ($identificador==0) {
        $ejemplares[$i] = $i;
    }
}
function doSelect($n, $d, $s=null)
{
    $doSelect = "<select style='width:50px; font-size:18px' name=\"$n\">\n";
    foreach ($d as $i=>$v) {
        $doSelect.="\t<option value=\"$i\"";
        $doSelect.=$s==$i?" selected":"";
        $doSelect.=">".$v."</option>\n";
    }
    $doSelect.="</select>";
    return $doSelect;
}
?>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return chequearEnvio();">
      <table width="393" height="190" align="center">
        <tr valign="baseline">
          <td height="73" colspan="2" align="right" valign="middle" nowrap="nowrap" style=" font-size:18px">&nbsp;</td>
          </tr>
        <tr valign="baseline">
          <td width="295" height="48" align="right" valign="middle" nowrap="nowrap" bgcolor="#CCCCCC" style=" font-size:18px">
          Número del ejemplar a retirar: </td>
          <td width="86" valign="bottom" bgcolor="#CCCCCC"><?php echo doSelect("num_rcaballo", $ejemplares, 1);?></td>
        </tr>
        <tr valign="baseline">
          <td colspan="2" align="center" valign="bottom" nowrap="nowrap">
          <input type="submit" value="Aceptar" class="btn btn-success" style="width:150px; font-size:16px;"/>
          <a href="caballos_lista.php" class="btn btn-warning" style="width:100px; font-size:18px;"> Volver </a></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
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
mysqli_free_result($Recordset2);
?>
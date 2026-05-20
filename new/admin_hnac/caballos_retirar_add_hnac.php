<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}

$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\admin_hnac\caballos_retirar_add_hnac.php - QUERY 1 */ SELECT * 
	FROM carrera_hnac, hipodromo_hnac 
	WHERE 
	carrera_hnac.cod_carrera_hnac = %s AND
	hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac",
    GetSQLValueString($xCarrera_Recordset1, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 new\admin_hnac\caballos_retirar_add_hnac.php - QUERY 2 */ UPDATE inscritos 
			SET
			est_inscrito_hnac=%s 
			WHERE 
			cod_inscrito_hnac=%s",
        GetSQLValueString(0, "int"),
        GetSQLValueString($_POST['cod_caballo'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    $car=$_POST['codCarrera'];
    include('../includes/procesar_ticket_retirados_hnac.php');
    $insertGoTo = "caballos_retirar_add_hnac.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 new\admin_hnac\caballos_retirar_add_hnac.php - QUERY 3 */ SELECT * 
	FROM carrera_hnac, inscritos 
	WHERE 
	carrera_hnac.cod_carrera_hnac = %s AND
	inscritos.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac",
    GetSQLValueString($xCarrera_Recordset1, "int")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
					<?php include("../includes/cabecera_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
        	id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
             Retiro de Ejemplar <br/>por Carreras
			</div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="height:100%; padding:70px 10px 110px 10px; text-align:left">
  <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:18px">
    <tr>
      <td height="34" align="center" valign="middle" class="tablajugada">
      <strong>
	  <?php echo $row_Recordset1['nom_hipodromo_hnac'].": ...".$row_Recordset1['num_carrera_hnac']; ?>
      </strong></td>
      </tr>
    <tr>
      <td align="center"><?php echo "Hora: ".$row_Recordset1['hor_carrera_hnac']; ?></td>
      </tr>
    <tr>
      <td align="right"  style="background:#5EAEFF; color:#FFFFFF; height:30px;">
        <?php
        if ($totalRows_Recordset3>0) {
            $g=0;
            echo "Ejemplares retirados: ";
            do {
                if ($row_Recordset3['est_inscrito_hnac']==0) {
                    echo "[<font color='#990000'>".$row_Recordset3['num_caballo_hnac']."</font>]";
                } else {
                    $numCa[$g]=$row_Recordset3['num_caballo_hnac'];
                    $codCa[$g]=$row_Recordset3['cod_inscrito_hnac'];
                    $g++;
                }
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
        }
        if ($g==0) {
            echo "NINGUNO&nbsp;";
        }
        ?>
        </td>
      </tr>
  </table>
  <br/>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return chequearEnvio();">
    <table width="393" height="190" align="center">
      <tr valign="baseline">
        <td height="73" colspan="2" align="right" valign="middle" nowrap="nowrap" style=" font-size:18px">&nbsp;</td>
        </tr>
      <tr valign="baseline">
        <td width="295" height="48" align="right" valign="middle" nowrap="nowrap" bgcolor="#CCCCCC" style=" font-size:18px">
          Número del ejemplar a retirar: </td>
        <td width="86" valign="bottom" bgcolor="#CCCCCC">
		<?php
        if ($g>0) {
            $f=0; ?>
			<select name="cod_caballo" style="width:67px; height: auto" class="textbox">
            <?php
            foreach ($codCa as $cC) {?>
				<option value="<?php echo $cC;?>">
				<?php echo $numCa[$f];?></option>
			<?php
            $f++;
            }
            echo "</select>";
        } else {
            echo "Ha ocurrido un error, no existen ejemplares para la carrera";
        }
        ?>
        </td>
        </tr>
      <tr valign="baseline">
        <td colspan="2" align="center" valign="bottom" nowrap="nowrap">
          <input type="submit" value="Aceptar" class="btn btn-success" 
          style="width:150px; font-size:18px; padding:10px"/>
          <a href="caballos_lista_hnac.php" class="btn btn-warning" 
          style="width:150px; font-size:18px; padding:10px; text-decoration:none"> Volver <a></td>
        </tr>
      </table>
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="codCarrera" value="<?php echo $xCarrera_Recordset1; ?>" />
    </form>
</div>
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset3);
?>
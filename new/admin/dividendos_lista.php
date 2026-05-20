<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$fechaactual_Recordset1 = fechaactualbd();
$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\dividendos_lista.php - QUERY 1 */ SELECT * FROM carrera WHERE eje_primero=0 AND carrera.est_carrera=0 AND carrera.fec_carrera = %s ORDER BY carrera.hor_carrera DESC", GetSQLValueString($fechaactual_Recordset1, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$fecha=fechanueva(fechaactualbd());
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechaactual_Recordset1=fechaymd($_POST["fecha"]);
    if ($fechaactual_Recordset1==fechaactualbd()) {
        $query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\dividendos_lista.php - QUERY 2 */ SELECT * FROM carrera 
			WHERE eje_primero=0 AND carrera.est_carrera=0 AND 
				  carrera.fec_carrera = %s 
			ORDER BY carrera.hor_carrera DESC", GetSQLValueString($fechaactual_Recordset1, "date"));
    } else {
        $query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\dividendos_lista.php - QUERY 3 */ SELECT * FROM carrera 
			WHERE eje_primero=0 AND carrera.est_carrera=0 AND
				  carrera.fec_carrera = %s 
			ORDER BY carrera.hor_carrera DESC", GetSQLValueString($fechaactual_Recordset1, "date"));
    }
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $fecha=$_POST["fecha"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
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
<link href='../css/font-awesome.css' rel='stylesheet'/>
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
                Resultados y <br/>Ejemplares ganadores
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  <div style="height:100%; padding:40px 10px 180px 10px; text-align:left">
      <div style="text-align: right;" id="fecha">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                Fecha:
                <input name="fecha" type="text" id="dateArrival1" tabindex="1" style="width:100px; font-size:18px; height: 24px"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:34px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
      </div>
   <?php if ($totalRows_Recordset1>=1) {  ?> 
<table width="100%" border="0" align="center">
  <tr style="background:#5EAEFF; color:#FFFFFF; height:30px; text-align:center">
  <td width="330">HIPÓDROMO</td>
    <td width="120">ABIERTO POR</td>
    <td width="120">CERRADO POR</td>
    <td width="110">HORA CIERRE</td>
    <td>ACCIÓN</td>
  </tr>
  <?php do { ?>
    <tr class="brillo">
      <td align="left"><?php echo ObtenerNombreynumeroJugadaCarrera($row_Recordset1['cod_carrera']); ?></td>
      <td align="center"><?php echo 'ABIER '; echo substr($row_Recordset1['ABIERTOX'], 0, 6);  ?></td>
      <td align="center"><?php echo 'CERRA '; echo substr($row_Recordset1['CERRADOX'], 0, 6); ?></td>

      <td align="center"><?php echo horaampm($row_Recordset1['hor_carrera']); ?></td>
      <td align="center">
      <?php if ($row_Recordset1['fec_carrera']<$fecha && $row_Recordset1['est_carrera']==1) {?>
      <a href="dividendos_cerrar_anterior.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>" title="cerrar carrera"><i class="fa fa-lock fa-2x"></i></a>
      <?php } else {?>
      <a href="dividendos_add.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>" title="incluir dividendos"><i class="fa fa-plus-circle fa-2x"></i></a>  <?php }?>    </td>
      </tr>
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</table>
<?php } else { ?>
        <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <tr class="tablajugada">
            <td width="280">HIPÓDROMO</td>
            <td width="90">FECHA</td>
            <td width="90">HORA</td>
            <td width="140" colspan="3">ACCIONES</td>
          </tr>
        </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 80px 0px; text-align:center ">
            No existen registros
        </div>
<?php }?>
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
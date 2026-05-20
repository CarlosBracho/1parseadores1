<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$varBanca_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $varBanca_Recordset1 = $_GET["recordID"];
}

$query_Recordset1 = sprintf("/* PARSEADORES1 admin\bancas_info.php - QUERY 1 */ SELECT * FROM banca WHERE banca.cod_banca = %s", GetSQLValueString($varBanca_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
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
                Información de Distribuidor<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  <div style="height:100%; padding:70px 10px 120px 10px; text-align:left; font-size:18px">
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px" >
      <tr>
        <td width="519" align="right">&nbsp;
        </td>
        </tr>
    </table>
      <table width="100%" height="269" border="0">
        <tr>
          <td width="112" height="36" align="right">Distribuidor:</td>
          <td width="209" bgcolor="#FFFFCC"><?php echo $row_Recordset1['nom_banca']; ?></td>
          <td width="13">&nbsp;</td>
          <td width="122" align="right">Representante:</td>
          <td width="221" bgcolor="#FFFFCC"><?php echo $row_Recordset1['nom_representante']; ?></td>
        </tr>
        <tr>
          <td height="36" align="right">Contacto:</td>
          <td bgcolor="#FFFFCC"><?php echo $row_Recordset1['tel_banca']; ?></td>
          <td>&nbsp;</td>
          <td align="right">Email:</td>
          <td bgcolor="#FFFFCC"><?php echo $row_Recordset1['cor_banca']; ?></td>
        </tr>
        <tr>
          <td height="36" align="right">Dirección:</td>
          <td bgcolor="#FFFFCC"><?php echo $row_Recordset1['dir_banca']; ?></td>
          <td>&nbsp;</td>
          <td align="right">Porcentaje:</td>
          <td bgcolor="#FFFFCC"><?php echo $row_Recordset1['por_banca']; ?></td>
        </tr>
        <tr>
          <td height="36" align="right">Fecha de Ingreso:</td>
          <td bgcolor="#FFFFCC"><?php echo fechanueva($row_Recordset1['fec_banca']); ?></td>
          <td>&nbsp;</td>
          <td align="right">Status:</td>
          <td bgcolor="#FFFFCC"><?php echo ObtenerNombreStatus($row_Recordset1['est_banca']); ?></td>
        </tr>
        <tr>
          <td colspan="5" align="center">
          <a href="bancas_lista.php" class="btn btn-warning" style="width:100px; font-size:18px;"> Volver <a></td>
        </tr>
      </table>
     
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
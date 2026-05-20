<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTaquilla_Recordset1 = "-1";
if (isset($_GET["recordID"])) {
    $xTaquilla_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf("/* PARSEADORES1 admin\taquillas_info.php - QUERY 1 */ SELECT * FROM taquilla WHERE taquilla.cod_taquilla = %s", GetSQLValueString($xTaquilla_Recordset1, "int"));
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
               <img src="../images/info.png" alt="" width="24" height="24" />Información de Taquilla<br/>
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
    <td colspan="2" align="right">&nbsp;</td>
    </tr>
  <tr>
    <td width="154" align="right">Nombre de Taquilla:</td>
    <td width="272" align="left" bgcolor="#FFFFCC"><?php echo $row_Recordset1['nom_taquilla']; ?></td>
  </tr>
  <tr>
    <td align="right">Representante:</td>
    <td align="left" bgcolor="#FFFFCC"><?php echo $row_Recordset1['nom_representante']; ?></td>
  </tr>
  <tr>
    <td align="right">Contacto:</td>
    <td align="left" bgcolor="#FFFFCC"><?php echo $row_Recordset1['tel_taquilla']; ?></td>
  </tr>
  <?php $xagente=ObtenerCodigoTaquillaAgencia($row_Recordset1['cod_taquilla']);
   $xbanca=ObtenerCodigoAgenciaBanca($xagente);?>    
  <tr>
    <td align="right">Distribuidor:</td>
    <td align="left" bgcolor="#FFFFCC"><?php echo ObtenerNombreBanca($xbanca); ?></td>
  </tr>
  <tr>
 
    <td align="right">Agente:</td>
    <td align="left" bgcolor="#FFFFCC"><?php echo ObtenerNombreAgencia($xagente); ?></td>
  </tr>
  <tr>
    <td align="right">Status:</td>
    <td align="left" bgcolor="#FFFFCC"><?php echo ObtenerNombreStatus($row_Recordset1['est_taquilla']); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
    </tr>
</table>
 <table width="200" border="0" align="center">
   <tr>
     <td align="center"><a href="taquillas_lista.php" class="btn btn-warning" style="width:100px; font-size:18px;"> Volver
       </a></td>
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

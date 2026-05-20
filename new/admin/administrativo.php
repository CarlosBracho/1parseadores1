<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 15;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$query_Recordset1 = "/* PARSEADORES1 new\admin\administrativo.php - QUERY 1 */ SELECT * FROM agencia, banca WHERE banca.cod_banca = agencia.cod_banca ORDER BY agencia.nom_agencia, banca.cod_banca";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysqli_query($conexionbanca, $query_limit_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
if (isset($_GET['totalRows_Recordset1'])) {
    $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
    $all_Recordset1 = mysqli_query($conexionbanca, $query_Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (stristr($param, "pageNum_Recordset1") == false &&
        stristr($param, "totalRows_Recordset1") == false) {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0) {
        $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
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
                ADMINISTRATIVO<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px; padding:0px 0px 0px 0px ">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
          <a href="agencias_add.php" class="btn btn-danger" title="incluir egresos" 
            	style="font-size:18px; width:170px; height:30px; padding:10px 0px 0px 0px;text-align:center;text-decoration:none">
                EGRESOS -
          </a>
        </div>
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="agencias_add.php" class="btn btn-success" title="incluir ingresos"
            	style="font-size:18px; width:170px; height:30px; padding:10px 0px 0px 0px;text-align:center;text-decoration:none">
                INGRESOS +
          </a>
        </div>
    	<div style=" width:100%; margin:-30px 0px 0px 0px; float:left; text-align:left ">
        <select name="seleccionaMes" class="fecha" style="font-size:18px; width:200px; height:auto" id="soflow">
            <option>Enero
            <option>Febrero
            <option>Marzo
            <option>Abril
            <option>Mayo
            <option>Junio
            <option>Julio
            <option>Agosto
            <option>Septiembre
            <option>Octubre
            <option>Noviembre
            <option>Diciembre
        </select>
		</div>
      <?php if ($totalRows_Recordset1>0) {?>
    <div style="height:100%; padding:0px 0px 300px 0px;">   
	<table width="100%" border="0" align="center">
        <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td width="700">CONCEPTO</td>
          <td width="106">INGRESOS</td>
          <td width="106">EGRESOS</td>
          <td width="14" align="right"></td>
        </tr>
        <?php do { ?>
          <tr class="brillo">
            <td align="left"><?php echo $row_Recordset1['nom_agencia']; ?></td>
            <td><?php echo $row_Recordset1['tel_agencia']; ?></td>
            <td align="right">-10.000,00</td>
            <td align="right">-</td>
            </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
      </table>
      </div>
      <?php } else {?>
      <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
        <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td width="198">AGENTE</td>
          <td width="136">CONTACTO</td>
          <td width="55">STATUS</td>
          <td width="201">DISTRIBUIDOR</td>
          <td width="78" colspan="3">ACCIONES</td>
        </tr>
      </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
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
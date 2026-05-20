<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 10000;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$query_Recordset1 = sprintf(
"/* PARSEADORES1 admin\taquillas_lista.php - QUERY 1 */ SELECT 
	ta.tel_taquilla, ta.tel_taquilla2, ta.tel_taquilla3, ta.cod_taquilla, ta.nom_taquilla, ag.nom_agencia, ta.est_taquilla, ba.nom_banca 
	FROM 
	taquilla ta,
	agencia ag,
  banca ba
	WHERE ba.cod_banca = ag.cod_banca AND ag.cod_agencia = ta.cod_agencia AND ta.est_taquilla = 1
	ORDER BY ta.nom_taquilla"
);
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
<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
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
                Lista de Taquillas<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 10px 10px; float:right;">
            <a href="taquillas_add.php" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nueva taquilla">
                Añadir Nueva Taquilla
            </a>
        </div>
        <div style="height:100%; font-size:28px; padding:10px 10px 10px 10px; float:right;">
            <a href="taquillas_listadesactivadas.php" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="Taquillas Desactivadas">
                Taquillas Desactivadas
            </a>
        </div>
          <?php if ($totalRows_Recordset1>0) {?>
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;" >
        <tr>
          <td width="594" align="right" class="diezpunto">Taquillas <?php echo($startRow_Recordset1 + 1) ?>-<?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> de <?php echo $totalRows_Recordset1 ?></td>
          <td width="18"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page?>
            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="../images/First.gif" width="18" height="13" /></a>
          <?php } // Show if not first page?></td>
          <td width="14"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page?>
            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="../images/Previous.gif" width="14" height="13" /></a>
          <?php } // Show if not first page?></td>
          <td width="14"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page?>
            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="../images/Next.gif" width="14" height="13" /></a>
          <?php } // Show if not last page?></td>
          <td width="18"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page?>
            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="../images/Last.gif" width="18" height="13" /></a>
          <?php } // Show if not last page?></td>
        </tr>
      </table>
    <div style="height:100%; padding:0px 0px 200px 0px ">   
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  		<tr style="background:#333333; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
    <td width="300">TAQUILLA</td>
    <td width="412">NÚMEROS DE CONTACTO</td>
    <td width="116">STATUS</td>
    <td>ACCIONES</td>
  </tr>
  <?php do { ?>
    <tr class="brillo" style="border-bottom:1px solid  #D5D5D5">
      <td align="left"><?php
      echo "Taquilla:.".$row_Recordset1['nom_taquilla']."<br/><FONT FACE='times new roman' SIZE=2>Agente:."  .$row_Recordset1['nom_agencia']."---Distribuidor:.".$row_Recordset1['nom_banca']."</FONT>"; ?>
      </td>
      <td align="left"><?php
      $telefono=$row_Recordset1['tel_taquilla'];
      if ($row_Recordset1['tel_taquilla2']!="") {
          $telefono.=" / ".$row_Recordset1['tel_taquilla2'];
      }
      if ($row_Recordset1['tel_taquilla3']!="") {
          $telefono.=" / ".$row_Recordset1['tel_taquilla3'];
      }
      echo $telefono; ?>
      </td>
      <td align="center"><?php echo ObtenerNombreStatus($row_Recordset1['est_taquilla']); ?></td>
      <td align="center">
      	<a href='taquillas_edit.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'class="btn btn-info"> EDITAR </a>
      </td>
    </tr>
<?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
   </table>
      </div>
       <?php } else {?>
      <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
  <tr  class="tablajugada">
    <td width="146">TAQUILLA</td>
    <td width="146">AGENTE</td>
    <td width="90">STATUS</td>
    <td colspan="3">ACCIONES</td>
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

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "S"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Bancas = 10000;
$pageNum_Bancas = 0;
if (isset($_GET['pageNum_Bancas'])) {
    $pageNum_Bancas = $_GET['pageNum_Bancas'];
}
$startRow_Bancas = $pageNum_Bancas * $maxRows_Bancas;

$query_Bancas = sprintf(
"/* PARSEADORES1 multidistri\bancas_lista.php - QUERY 1 */ SELECT * 
FROM 
banca,
multidistriMD
WHERE
multidistriMD.cod_multidistriMD = banca.cod_multidistriMDBA AND banca.est_banca = 1 AND
multidistriMD.cod_multidistriMD = %s
ORDER BY banca.nom_banca, multidistriMD.cod_multidistriMD",
GetSQLValueString($_SESSION['MM_cod_multidistriMD'], "int")
);

$query_limit_Bancas = sprintf("%s LIMIT %d, %d", $query_Bancas, $startRow_Bancas, $maxRows_Bancas);
$Bancas = mysqli_query($conexionbanca, $query_limit_Bancas) or die(mysqli_error($conexionbanca));
$row_Bancas = mysqli_fetch_assoc($Bancas);
if (isset($_GET['totalRows_Bancas'])) {
    $totalRows_Bancas = $_GET['totalRows_Bancas'];
} else {
    $all_Bancas = mysqli_query($conexionbanca, $query_Bancas);
    $totalRows_Bancas = mysqli_num_rows($all_Bancas);
}
$totalPages_Bancas = ceil($totalRows_Bancas/$maxRows_Bancas)-1;
$queryString_Bancas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (stristr($param, "pageNum_Bancas") == false &&
        stristr($param, "totalRows_Bancas") == false) {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0) {
        $queryString_Bancas = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_Bancas = sprintf("&totalRows_Bancas=%d%s", $totalRows_Bancas, $queryString_Bancas);
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
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
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
                Lista de Distribuidores <br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="bancas_add.php" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nuevo distribuidor">
                 Añadir Nuevo Distribuidor
            </a>
        </div>
      <?php if ($totalRows_Bancas>0) { ?>  
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px">
    <tr>
      <td width="574" align="right">Distribuidores <?php echo($startRow_Bancas + 1) ?>-<?php echo min($startRow_Bancas + $maxRows_Bancas, $totalRows_Bancas) ?> de <?php echo $totalRows_Bancas ?></td>
      <td width="18"><?php if ($pageNum_Bancas > 0) { // Show if not first page?>
        <a href="<?php printf("%s?pageNum_Bancas=%d%s", $currentPage, 0, $queryString_Bancas); ?>"><img src="../images/First.gif" width="18" height="13" /></a>
        <?php } // Show if not first page?></td>
      <td width="14"><?php if ($pageNum_Bancas > 0) { // Show if not first page?>
        <a href="<?php printf("%s?pageNum_Bancas=%d%s", $currentPage, max(0, $pageNum_Bancas - 1), $queryString_Bancas); ?>"><img src="../images/Previous.gif" width="14" height="13" /></a>
        <?php } // Show if not first page?></td>
      <td width="14"><?php if ($pageNum_Bancas < $totalPages_Bancas) { // Show if not last page?>
        <a href="<?php printf("%s?pageNum_Bancas=%d%s", $currentPage, min($totalPages_Bancas, $pageNum_Bancas + 1), $queryString_Bancas); ?>"><img src="../images/Next.gif" width="14" height="13" /></a>
        <?php } // Show if not last page?></td>
      <td width="18"><?php if ($pageNum_Bancas < $totalPages_Bancas) { // Show if not last page?>
        <a href="<?php printf("%s?pageNum_Bancas=%d%s", $currentPage, $totalPages_Bancas, $queryString_Bancas); ?>"><img src="../images/Last.gif" width="18" height="13" /></a>
        <?php } // Show if not last page?></td>
      </tr>
    </table>    
    <div style="height:100%; padding:0px 0px 300px 0px ">   
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  		<tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td width="300" align="center">DISTRIBUIDOR</td>
          <td width="420" align="center">NÚMEROS DE CONTACTO</td>
          <td width="100" align="center">STATUS</td>
          <td colspan="2" align="center">ACCIONES</td>
        </tr>
        <?php do { ?>
          <tr class="brillo" style="border-bottom:1px solid  #D5D5D5">
            <td align="left"><?php
            echo $row_Bancas['nom_banca']."<br/><FONT FACE='times new roman' SIZE=2>".$row_Bancas['nom_representante']."</FONT>"; ?>
            </td>
            <td align="left">
			<?php
            $telbanca=$row_Bancas['tel_banca'];
            if ($row_Bancas['tel_banca2']!="") {
                $telbanca.=" / ".$row_Bancas['tel_banca2'];
            }
            if ($row_Bancas['tel_banca3']!="") {
                $telbanca.=" / ".$row_Bancas['tel_banca3'];
            }
            echo $telbanca; ?>
            </td>
            <td align="center"><?php echo ObtenerNombreStatus($row_Bancas['est_banca']); ?></td>
            <td align="center">
            <a class="btn btn-primary" style="text-decoration:none;" 
            	href='bancas_edit.php?recordID=<?php echo $row_Bancas['cod_banca']; ?>'>
            <i class="fa fa-pencil fa-lg"></i> EDITAR</a>
            </td>
            </tr>
          <?php } while ($row_Bancas = mysqli_fetch_assoc($Bancas)); ?>
      </table>
      </div>
      <?php } else {?>
      <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
        <tr >
          <td width="351" align="center">DISTRIBUIDOR</td>
          <td width="167" align="center">USUARIO</td>
          <td width="304" align="center">REPRESENTANTE</td>
          <td width="167" align="center">STATUS</td>
          <td width="100" colspan="3" align="center">ACCIONES</td>
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
mysqli_free_result($Bancas);
?>
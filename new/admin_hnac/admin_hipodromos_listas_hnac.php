<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 600;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$query_Recordset1 = "/* PARSEADORES1 new\admin_hnac\admin_hipodromos_listas_hnac.php - QUERY 1 */ SELECT cod_hipodromo_hnac, nom_hipodromo_hnac, est_hipodromo_hnac FROM hipodromo_hnac ORDER BY nom_hipodromo_hnac ASC";
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<style>
	.boton-top{
		display: none;
		position:fixed;
		bottom:0;
		right:0;
		width:50px;
		height: 50px;
		text-align:center;
		line-height:50px;
		color:#fff;
		background: #F93;
		cursor:pointer;
		font-size:20px;
	}
</style>
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
<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
<script type="text/javascript">
function cStatus(id, cCar) {
	if (id==0) modo=" modo MANUAL?";
	if (id==1) modo=" MTP MAQUINA AZUL?";
	if (id==2) modo=" MTP TU HIPISMO?";
	confirma = confirm('¿Desea cambiar Hipódromo a'+modo);
	if(confirma==true){
		var rA=Math.random();
		var parametros = { "codCar":cCar, "modo":id, "rA":Math.random() };
		$.ajax({ data:parametros, url:'../includes/cambio_mtp_hipodromo_hnac.php', type:'post',
			success:function (response) { 
				$("#hipodromo").html(response);
				window.location='hipodromos_listas_hnac.php';
			}
		}); 
	} else window.location='hipodromos_listas_hnac.php';
	
}
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">

<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
  </div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Lista de hipódromos<br/>nacionales
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="admin_hipodromo_add_hnac.php" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nuevo hipódromo">
                 AÑADIR NUEVO HIPÓDROMO
            </a>
        </div>
      <?php if ($totalRows_Recordset1>0) {?>
    <table width="100%" border="0" align="center" style="background:#0E5157; color:#FFF; font-size:14px" >
        <tr>
          <td width="594" align="right" class="diezpunto">Hipódromos <?php echo($startRow_Recordset1 + 1) ?>-<?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> de <?php echo $totalRows_Recordset1 ?></td>
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
    <div style="height:100%; padding:0px 0px 300px 0px ">   
	<table width="100%" border="0" align="center">
        <tr style="background:#0E5157; color:#FFFFFF; height:30px">
          <td width="467">HIPÓDROMOS NACIONALES</td>
          <td width="154">-</td>
          <td width="198" align="center">STATUS</td>
          <td width="103" colspan="2" align="center">ACCIONES</td>
        </tr>
        <?php do { ?>
          <tr class="brillo" style="font-size:14px">
            <td align="left"><?php echo $row_Recordset1['nom_hipodromo_hnac']; ?></td>
            <td align="left">
            </td>
            <td align="center"><?php echo ObtenerNombreStatus($row_Recordset1['est_hipodromo_hnac']); ?></td>
            <td align="center">
            	<a href='admin_hipodromo_edit_hnac.php?recordID=<?php echo $row_Recordset1['cod_hipodromo_hnac']; ?>'
                class="btn btn-info" style="height:15px; width:50px; font-size:12px; text-decoration:none;"> EDITAR </a>
            </td>
            </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
      </table>
      </div>
      <?php } else {?>
      <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
        <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td>AGENTE</td>
          <td width="227">STATUS</td>
          <td width="127" colspan="3">ACCIONES</td>
        </tr>
      </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
         
      <?php }?>
    </div>
<span class="boton-top" title="ir arriba">▲</span>
	<script>
	$(window).scroll(function(){
	    if ($(this).scrollTop() > 0) {
	        $('.boton-top').fadeIn();
	    } else {
	        $('.boton-top').fadeOut();
	    }
	});

	$('.boton-top').click(function(){
	    $(document.body).animate({scrollTop : 0}, 100);
	    return false;
	});
	</script>
    
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
</div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
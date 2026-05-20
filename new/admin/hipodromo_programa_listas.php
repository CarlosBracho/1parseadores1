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

$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\hipodromo_programa_listas.php - QUERY 1 */ SELECT hipodromo.cod_hipodromo, carrera.mtp_tipo, hipodromo.mtp_paribet, hipodromo.mtp_tvg, hipodromo.mtp_twinspire, hipodromo.mtp_WatchandWager, hipodromo.mtp_betbird, hipodromo.nom_hipodromo, hipodromo.est_hipodromo, hipodromo.bus_auto FROM hipodromo, carrera WHERE hipodromo.cod_hipodromo=carrera.cod_hipodromo AND carrera.fec_carrera = %s GROUP BY hipodromo.cod_hipodromo ORDER BY carrera.hor_carrera DESC, nom_hipodromo ASC, carrera.num_carrera ASC", GetSQLValueString(fechaactualbd(), "date"));
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
<script type="text/javascript">
function cStatus(id, cCar) {
  if (id==0) modo=" modo MANUAL?";
  if (id==1) modo=" 1 opcion 1?";
  if (id==2) modo=" 2 opcion 2?";
  if (id==3) modo=" 3 opcion 3?";
  if (id==4) modo=" 4 opcion 4?";
  if (id==5) modo=" 5 opcion 5?";
  if (id==6) modo=" 6 opcion 6?";
  if (id==7) modo=" 7 opcion 7?";
  if (id==8) modo=" WATCHANDWAGER?";
  if (id==9) modo=" BUILDABET2?";
	confirma = confirm('¿Desea cambiar Carrera a'+modo);
	if(confirma==true){
		var rA=Math.random();
		var parametros = { "codCar":cCar, "modo":id, "rA":Math.random() };
		$.ajax({ data:parametros, url:'../includes/cambio_mtp_hipodromo.php', type:'post',
			success:function (response) { 
				$("#hipodromo").html(response);
				window.location='hipodromo_programa_listas.php';
			}
		}); 
	} else window.location='hipodromo_programa_listas.php';
	
}
</script>

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
                Hipódromos con<br/>carreras programadas
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="../admin/hipodromos_listas.php" class="btn alert-success" 
            	style="font-size:18px; width:140px; height:40px; padding:5px 0px 0px 0px; text-align:center; background: #0CF;
                text-decoration:none; " title="crear carreras desde tvg automáticamente">
                Listar todos<br/>los hipódromos
            </a>
            <a href="hipodromos_add.php" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nuevo hipódromo">
                 Añadir Nuevo hipódromo
            </a>
        </div>
      <?php if ($totalRows_Recordset1>0) {?>
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px" >
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
        <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td width="267">HIPÓDROMOS</td>
          <td width="254">CERRADORES</td>
          <td width="154">MTP</td>
          <td width="100" align="center">STATUS</td>
          <td width="103" colspan="2" align="center">ACCIONES</td>
        </tr>
        <?php do { ?>
          <tr class="brillo" style="font-size:14px">
            <td align="left"><?php echo $row_Recordset1['nom_hipodromo']; ?></td>
            <td align="left">
       
            
            <?php  
            $cerradores=0;
            if ($row_Recordset1['mtp_WatchandWager']==1) {
echo ' watch ';
$cerradores=$cerradores+1;
          }
          if ($row_Recordset1['mtp_betbird']==1) {
            echo ' betbird ';
            $cerradores=$cerradores+1;
                      }
                      if ($row_Recordset1['mtp_twinspire']==1) {
                        echo ' twins ';
                        $cerradores=$cerradores+1;
                                  }
                                  if ($row_Recordset1['mtp_tipo']==1) {
                                    echo ' build ';
                                    $cerradores=$cerradores+1;
                                              }
                                              if ($row_Recordset1['mtp_paribet']==1) {
                                                echo ' capit ';
                                                $cerradores=$cerradores+1;
                                                          }
                                                          if ($row_Recordset1['mtp_tvg']==1) {
                                                            echo ' tvg ';
                                                            $cerradores=$cerradores+1;
                                                                      }
                                  
          echo ' C X '.$cerradores;
            //ESTOY AQUI 
            ?>
            



            </td>
            <td align="left">
			<select name="mtp_control" class="alert-success2" tabindex="4"
            style="width:155px; height:32px; font-size:13px; margin:1px 0px 0px 0px"  
        	onchange="cStatus(this.value, <?php echo $row_Recordset1['cod_hipodromo'] ?>)"> 

        <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">MANUAL</option>
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">1 opcion 1</option>
        <option value="2" <?php if (!(strcmp(2, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">2 opcion 2</option>
        <option value="3" <?php if (!(strcmp(3, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">3 opcion 3</option>
        <option value="4" <?php if (!(strcmp(4, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">4 opcion 4</option>
        <option value="5" <?php if (!(strcmp(5, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">5 opcion 5</option>
        <option value="6" <?php if (!(strcmp(6, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">6 opcion 6</option>
        <option value="7" <?php if (!(strcmp(7, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">7 opcion 7</option>
        <option value="8" <?php if (!(strcmp(8, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">WATCHANDWAGER</option>  
       <option value="9" <?php if (!(strcmp(9, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?> style="background:#000;color:#CCC">BUILDABET2</option>   
              </select>       
            </td>
            <td align="center"><?php echo ObtenerNombreStatus($row_Recordset1['est_hipodromo']); ?></td>
            <td align="center">
            	<a href='hipodromos_edit.php?recordID=<?php echo $row_Recordset1['cod_hipodromo']; ?>'class="btn btn-info"
                style="height:15px; width:50px; font-size:12px; text-decoration:none;"> EDITAR </a>
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
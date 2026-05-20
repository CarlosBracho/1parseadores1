<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$maxRows_Recordset1 = 800;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$xFechaCarrera_Recordset1 = fechaactualbd();
$fecha=fechanueva(fechaactualbd());
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $xFechaCarrera_Recordset1=fechaymd($_POST["fecha"]);
    $fecha=$_POST["fecha"];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\admin_hnac\caballos_lista_hnac.php - QUERY 1 */ SELECT * 
	FROM carrera_hnac, hipodromo_hnac
	WHERE 
	carrera_hnac.fec_carrera_hnac = %s AND
	hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac",
    GetSQLValueString($xFechaCarrera_Recordset1, "date")
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
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
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
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
<div style="height:100%; padding:70px 10px 280px 10px; text-align:left">
       <div style="height:40px; font-size:18px; padding:4px 0px 0px 4px; background:#0E5157; color: #fff ">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                Fecha:
                <input name="fecha" type="text" id="dateArrival1" tabindex="1" 
                	style="width:100px; font-size:18px; height: 24px; background-color: #FFFFFF;"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:34px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
       </div>
      <table width="100%" border="0" align="center" style="background:#0E5157; color:#FFF; font-size:14px">
        <tr>
          <td width="614" align="right">&nbsp;
Carreras <?php echo($startRow_Recordset1 + 1) ?>-<?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> de <?php echo $totalRows_Recordset1 ?></td>
          <td width="18"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page?>
            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="../images/First.gif" /></a>
          <?php } // Show if not first page?></td>
          <td width="14"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="../images/Previous.gif" /></a>
          <?php } // Show if not first page?></td>
          <td width="14"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="../images/Next.gif" /></a>
          <?php } // Show if not last page?></td>
          <td width="18"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page?>
              <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="../images/Last.gif" /></a>
          <?php } // Show if not last page?></td>
        </tr>
      </table>
  <?php if ($totalRows_Recordset1>0) {  ?>
<table width="100%" border="0" align="center" bordercolor="#CCCCCC">
  <tr style="background:#333; color:#FFFFFF; height:30px; text-align:center">
    <td>&nbsp;</td>
    <td>Haga clic sobre el número del ejemplar para reintegarlo</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr style="background:#333; color:#FFFFFF; height:30px; text-align:center">
    <td width="382">HIPÓDROMO</td>
    <td width="435">EJEMPLARES RETIRADOS</td>
    <td colspan="2">ACCIÓN</td>
    </tr>
  	<?php
    do { ?>
    <tr class="brillo" style="font-size:18px">
      <td align="left"><?php echo $row_Recordset1['nom_hipodromo_hnac']." Carr: ...".$row_Recordset1['num_carrera_hnac']; ?></td>
      <td style="font-size:18px">
        <?php
            $query_Recordset3 = sprintf(
    "/* PARSEADORES1 new\admin_hnac\caballos_lista_hnac.php - QUERY 2 */ SELECT * 
				FROM carrera_hnac, inscritos 
				WHERE 
				carrera_hnac.cod_carrera_hnac = %s AND
				inscritos.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac",
    GetSQLValueString($row_Recordset1['cod_carrera_hnac'], "int")
);
            $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
            $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
            $totalRows_Recordset3 = mysqli_num_rows($Recordset3);

        
        if ($totalRows_Recordset3>0) {
            $g=0;
            do {
                if ($row_Recordset3['est_inscrito_hnac']==0) {?>
					[<a href="caballos_reintegrar_hnac.php?recordID=<?php echo $row_Recordset3['cod_inscrito_hnac']; ?>&codCarr=<?php echo $row_Recordset3['cod_carrera_hnac']; ?>&numCab=<?php echo $row_Recordset3['num_caballo_hnac']; ?>" title="reintegrar ejemplar"><?php echo $row_Recordset3['num_caballo_hnac']; ?></a>]
					
				<?php
                $g++;
                }
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
        } else {
            echo "NINGUNO";
        }
        ?>
      </td>
      <td width="36" align="center"><strong><a href="caballos_retirar_add_hnac.php?recordID=<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" title="retirar ejemplares"><i class="fa fa-plus-circle fa-2x"></i></a></strong></td>
      <td width="39" align="center">
      <?php if ($g>1) {?>
      	<strong><a href="caballos_reintegrar_all_hnac.php?recordID=<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" title="reintegrar todos los ejemplares"><i class="fa fa-undo fa-2x"></i></a></strong>
      <?php }?>
      </td>
      </tr>
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
      </table>
  <?php } else { ?>
    <table width="100%" border="0" align="center">
    <tr>
      <td colspan="3">
      <div style="height:100%; font-size:24px; padding:150px 0px 0px 0px; text-align:center ">
            No existen carreras programadas
        </div></td>
      </tr>
      </table>

 <?php  } ?>
</div>
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
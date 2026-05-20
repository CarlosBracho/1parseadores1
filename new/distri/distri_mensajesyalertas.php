<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_mensajesyalertas = 10000;
$pageNum_mensajesyalertas = 0;
if (isset($_GET['pageNum_Bancas'])) {
    $pageNum_mensajesyalertas = $_GET['pageNum_mensajesyalertas'];
}
$startRow_mensajesyalertas = $pageNum_mensajesyalertas * $maxRows_mensajesyalertas;

$query_mensajesyalertas = "/* PARSEADORES1 new\distri\distri_mensajesyalertas.php - QUERY 1 */ SELECT me.tipo, me.para, me.mensaje, me.mostrarhasta, me.Id_mensajesyalertas  FROM mensajesyalertas me WHERE (me.mostrarhasta >= CURDATE()) AND me.creadopor = 2 ORDER BY me.Id_mensajesyalertas DESC";
$query_limit_mensajesyalertas = sprintf("%s LIMIT %d, %d", $query_mensajesyalertas, $startRow_mensajesyalertas, $maxRows_mensajesyalertas);
$mensajesyalertas = mysqli_query($conexionbanca, $query_limit_mensajesyalertas) or die(mysqli_error($conexionbanca));
$row_mensajesyalertas = mysqli_fetch_assoc($mensajesyalertas);
if (isset($_GET['totalRows_mensajesyalertas'])) {
    $totalRows_mensajesyalertas = $_GET['totalRows_mensajesyalertas'];
} else {
    $all_mensajesyalertas = mysqli_query($conexionbanca, $query_mensajesyalertas);
    $totalRows_mensajesyalertas = mysqli_num_rows($all_mensajesyalertas);
}
$totalPages_mensajesyalertas = ceil($totalRows_mensajesyalertas/$maxRows_mensajesyalertas)-1;
$queryString_mensajesyalertas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (stristr($param, "pageNum_mensajesyalertas") == false &&
        stristr($param, "totalRows_mensajesyalertas") == false) {
            array_push($newParams, $param);
        }
    }
    if (count($newParams) != 0) {
        $queryString_mensajesyalertas = "&" . htmlentities(implode("&", $newParams));
    }
}
$queryString_mensajesyalertas = sprintf("&totalRows_mensajesyalertas=%d%s", $totalRows_mensajesyalertas, $queryString_mensajesyalertas);
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    if ($graba==31) {
        $Id_mensajesyalertas = $_POST['Id_mensajesyalertas'];
        echo $Id_mensajesyalertas;
  
        $updateSQL = sprintf(
            "/* PARSEADORES1 new\distri\distri_mensajesyalertas.php - QUERY 2 */ UPDATE mensajesyalertas 
										   SET mostrarhasta='2000-09-10' 
											   WHERE Id_mensajesyalertas=%s",
            GetSQLValueString($Id_mensajesyalertas, "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                                        
                                    



        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
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
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceradistri.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                Lista de Mensajes y Alertas <br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px;" class="xfirefox">
				        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="distri_crear_mensaje_ataquilla.php" class="btn alert-success" 
            	style="font-size:18px; width:200px; height:70px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="Añadir Nuevo Mensaje A Taquilla">
                 Añadir Nuevo Mensaje A Taquilla
            </a>
        </div>
			        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
            <a href="distri_crear_mensaje_ataquillasdelagente.php" class="btn alert-success" 
            	style="font-size:18px; width:200px; height:70px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="Añadir Nuevo Mensaje A Taquillas De Un Agente">
                 Añadir Nuevo Mensaje A Taquillas De Un Agente
            </a>
        </div>

      <?php if ($totalRows_mensajesyalertas>0) { ?>  
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px">
    <tr>
      <td width="574" align="right">Distribuidores <?php echo($startRow_mensajesyalertas + 1) ?>-<?php echo min($startRow_mensajesyalertas + $maxRows_mensajesyalertas, $totalRows_mensajesyalertas) ?> de <?php echo $totalRows_mensajesyalertas ?></td>
      <td width="18"><?php if ($pageNum_mensajesyalertas > 0) { // Show if not first page?>
        <a href="<?php printf("%s?pageNum_mensajesyalertas=%d%s", $currentPage, 0, $queryString_Bancas); ?>"><img src="../images/First.gif" width="18" height="13" /></a>
        <?php } // Show if not first page?></td>
      <td width="14"><?php if ($pageNum_mensajesyalertas > 0) { // Show if not first page?>
        <a href="<?php printf("%s?pageNum_mensajesyalertas=%d%s", $currentPage, max(0, $pageNum_mensajesyalertas - 1), $queryString_mensajesyalertas); ?>"><img src="../images/Previous.gif" width="14" height="13" /></a>
        <?php } // Show if not first page?></td>
      <td width="14"><?php if ($pageNum_mensajesyalertas < $totalPages_mensajesyalertas) { // Show if not last page?>
        <a href="<?php printf("%s?pageNum_mensajesyalertas=%d%s", $currentPage, min($totalPages_mensajesyalertas, $pageNum_mensajesyalertas + 1), $queryString_mensajesyalertas); ?>"><img src="../images/Next.gif" width="14" height="13" /></a>
        <?php } // Show if not last page?></td>
      <td width="18"><?php if ($pageNum_mensajesyalertas < $totalPages_mensajesyalertas) { // Show if not last page?>
        <a href="<?php printf("%s?pageNum_mensajesyalertas=%d%s", $currentPage, $totalPages_mensajesyalertas, $queryString_mensajesyalertas); ?>"><img src="../images/Last.gif" width="18" height="13" /></a>
        <?php } // Show if not last page?></td>
      </tr>
    </table>    
    <div style="height:100%; padding:0px 0px 300px 0px ">   
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  		<tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td width="300" align="center">MENSAJE A</td>
          <td width="420" align="center">MENSAJE</td>
          <td width="100" align="center">VENCE</td>
          <td colspan="2" align="center">ACCIONES</td>
        </tr>
        <?php do { ?>
          <tr class="brillo" style="border-bottom:1px solid  #D5D5D5">
            <td align="left"><?php
                    


if ($row_mensajesyalertas['tipo']==1) {
    $query_Recordset4 = sprintf(
        "/* PARSEADORES1 new\distri\distri_mensajesyalertas.php - QUERY 3 */ SELECT nom_taquilla FROM taquilla
WHERE cod_taquilla = %s
ORDER BY RAND() LIMIT 1",
        GetSQLValueString($row_mensajesyalertas['para'], "int")
    );
    $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
    $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
    $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
    $nomdedetaquilla = trim($row_Recordset4['nom_taquilla']);
    
    
    
    echo 'Taquilla'."<br/><FONT FACE='times new roman' SIZE=4>".$nomdedetaquilla."</FONT>";
}
if ($row_mensajesyalertas['tipo']==2) {
    $query_Recordset4 = sprintf(
        "/* PARSEADORES1 new\distri\distri_mensajesyalertas.php - QUERY 4 */ SELECT ag.nom_agencia FROM agencia ag
WHERE ag.cod_agencia = %s
ORDER BY RAND() LIMIT 1",
        GetSQLValueString($row_mensajesyalertas['para'], "int")
    );
    $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
    $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
    $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
    $nomdedeagente = trim($row_Recordset4['nom_agencia']);

    echo 'Taquillas del Agente'."<br/><FONT FACE='times new roman' SIZE=4>".$nomdedeagente."</FONT>";
}
if ($row_mensajesyalertas['tipo']==3) {
    $query_Recordset4 = sprintf(
        "/* PARSEADORES1 new\distri\distri_mensajesyalertas.php - QUERY 5 */ SELECT ba.nom_banca FROM banca ba
WHERE ba.cod_banca = %s
ORDER BY RAND() LIMIT 1",
        GetSQLValueString($row_mensajesyalertas['para'], "int")
    );
    $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
    $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
    $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
    $nomdedistribuidor = $row_Recordset4['nom_banca'];

    echo 'Taquillas del Distribuidor'."<br/><FONT FACE='times new roman' SIZE=4>".$nomdedistribuidor."</FONT>";
}

 ?>

            
			
			
			
			
			
			</td>
            <td align="left">
			<?php echo $row_mensajesyalertas['mensaje']; ?>
            </td>
            <td align="center">
			<?php echo $row_mensajesyalertas['mostrarhasta']; ?>
			</td>
            <td align="center">
		
			<form method="POST" name="form1" id="form1" > 
            <input type="hidden" name="Id_mensajesyalertas" value="<?php echo $row_mensajesyalertas['Id_mensajesyalertas']; ?>" />
            <input type="submit" value="Eliminar Mensaje" name="B1"></td> 
			          <input type="hidden" name="MM_insert" value="form1"/>
 
			        </form>
			
			
			
			
			

			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
            </td>
            </tr>
          <?php } while ($row_mensajesyalertas = mysqli_fetch_assoc($mensajesyalertas)); ?>
      </table>
      </div>
      <?php } else {?>
      <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
        <tr >
          <td width="300" align="center">MENSAJE A</td>
          <td width="420" align="center">MENSAJE</td>
          <td width="100" align="center">VENCE</td>
          <td colspan="2" align="center">ACCIONES</td>
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
mysqli_free_result($mensajesyalertas);
?>
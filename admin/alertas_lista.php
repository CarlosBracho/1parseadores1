<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_Recordset1 = 10000;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
    $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}


if(isset($_POST['ESTADO_CODIGO'])){
  $insertSQL1 = sprintf(
    "/* PARSEADORES1 admin\alertas_lista.php - QUERY 1 */ UPDATE alertas

SET
activo_archivo = %s
    WHERE
    Idalertas = %s
    ",
  GetSQLValueString(($_POST['ESTADO_CODIGO']), "int"),
  GetSQLValueString(($_POST['Idalertas']), "int"));
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
  }

  if(isset($_POST['FinalizarReabrir'])){
    $insertSQL1 = sprintf(
      "/* PARSEADORES1 admin\alertas_lista.php - QUERY 2 */ UPDATE alertas
  
  SET
  pausa = %s
      WHERE
      Idalertas = %s
      ",
    GetSQLValueString(($_POST['pausa']), "int"),
    GetSQLValueString(($_POST['Idalertas']), "int"));
      $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    }




$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;
$query_Recordset1 = sprintf(
"/* PARSEADORES1 admin\alertas_lista.php - QUERY 3 */ SELECT *
	FROM 
	alertas"
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
                Panel de Alertas
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px;" class="xfirefox">
        
          <?php if ($totalRows_Recordset1>0) {?>
    
    <div style="height:100%; padding:0px 0px 200px 0px ">   
	<br><br><br><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  	<tr style="background:#333333; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
    <td># ALERTA</td>
    <td>NOMBRE DE ALERTA</td>
    <td>PAUSAR O INICIAR</td>
    <td>DESACTIVAR CODIGO SI O NO</td>
    <td>EDITAR</td>
  </tr>
  <?php do { ?>
    <tr class="brillo" style="border-bottom:1px solid  #D5D5D5">
    <td align="left"><?php
      echo $row_Recordset1['Idalertas']?>
      </td>
      <td align="left"><?php
      echo $row_Recordset1['nombrealerta']?>
      </td>
      <td align="center">
      <?php  if($row_Recordset1['pausa']==0){ ?>
        <form method="POST" name="Finalizar" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
            <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
            <input type="hidden" name="pausa" value="1">
            <input type="hidden" name="FinalizarReabrir" value="1">
            <div class="d-grid gap-2">
                <button class="btn btn-danger" type="submit">PAUSAR</button>
            </div>
        </form>
        <?php  }else{ ?>
        <form method="POST" name="Reabrir" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
            <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
            <input type="hidden" name="pausa" value="0">
            <input type="hidden" name="FinalizarReabrir" value="0">
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">INICIAR</button>
            </div>
        </form>
        <?php  } ?>
      </td>



      <td align="center">
      <?php  if($row_Recordset1['activo_archivo']==3){ 


 } else{if($row_Recordset1['activo_archivo']==0){ ?>
        <form method="POST" name="CODIGO" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
            <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
            <input type="hidden" name="ESTADO_CODIGO" value="1">
            <div class="d-grid gap-2">
                <button class="btn btn-danger" type="submit">DESACTIVAR_CODIGO</button>
            </div>
        </form>
        <?php  }else{ ?>
        <form method="POST" name="CODIGO" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
            <input type="hidden" name="Idalertas" value="<?php echo $row_Recordset1['Idalertas']; ?>">
            <input type="hidden" name="ESTADO_CODIGO" value="0">
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">ACTIVAR_CODIGO</button>
            </div>
        </form>
        <?php  } }?>
      </td>

      <td align="center">
      	<a href='alertas_edit.php?recordID=<?php echo $row_Recordset1['Idalertas']; ?>'class="btn btn-info"> EDITAR </a>
      </td>



    </tr>
<?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
   </table>
      </div>
       <?php } else {?>
      <table width="100%" border="0" align="center" style="background:#5EAEFF; color:#FFFFFF; height:30px">
  <tr  class="tablajugada">
  
    <td width="146">NOMBRE DE ALERTA</td>
    <td colspan="3">PAUSAR O INICIAR</td>
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

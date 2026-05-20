<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$fechaactual_Recordset1 = fechaactualbd();
$query_Recordset1 = sprintf("/* PARSEADORES1 new\admin\admin_bitacora_lista.php - QUERY 1 */ SELECT * FROM bitacora WHERE bitacora.fec_bitacora = %s ORDER BY bitacora.hor_bitacora DESC", GetSQLValueString($fechaactual_Recordset1, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$fecha=fechanueva(fechaactualbd());
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechaactual_Recordset1=fechaymd($_POST["fecha"]);
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\admin\admin_bitacora_lista.php - QUERY 2 */ SELECT * FROM bitacora 
					WHERE bitacora.fec_bitacora = %s 
					ORDER BY bitacora.hor_bitacora DESC",
        GetSQLValueString($fechaactual_Recordset1, "date")
    );
    $fecha=$_POST["fecha"];
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#FFFFDD" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
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
<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabeceraadmin.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Bitácoras<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">&nbsp;
        </div>
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px" >
      <tr>
        <td width="160" align="left">
          <div style="height:40px; font-size:18px; padding:4px 0px 0px 4px; background: #333; color: #fff ">
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
        </td>
        <td width="359" align="right">&nbsp;</td>
        </tr>
    </table>
    <?php if ($totalRows_Recordset1>=1) { ?>
    <div style="height:100%; padding:0px 0px 90px 0px ">
        <table width="100%" border="1" align="center" bordercolor="#F4F4F4">
          <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
            <td width="13%">HORA</td>
            <td width="87%">DESCRIPCIÓN</td>
          </tr>
          <?php do { ?>
          <tr align="left" valign="middle" bgcolor="#FFFFFF" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
            <td height="36"><?php echo horaampm($row_Recordset1['hor_bitacora']); ?></td>
            <td style="font-size:12px"><?php echo $row_Recordset1['des_bitacora']; ?></td>
          </tr>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
        </table>
    </div>
    <?php } else {?>
        <table width="100%" border="1" align="center" bordercolor="#F4F4F4">
          <tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
            <td width="13%">HORA</td>
            <td width="87%">DESCRIPCIÓN</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
	<?php }?>    
  </div> 
  <div id="hipodromo">
  </div>
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
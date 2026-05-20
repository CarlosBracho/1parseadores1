<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$_SESSION['username'] = "Soporte";
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset2 = "/* PARSEADORES1 admin\reporte_ventas_agentes.php - QUERY 1 */ SELECT * FROM agencia ORDER BY agencia.nom_agencia";
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
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
                Reporte de ventas <br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="height:100%; font-size:26px; padding:50px 0px 200px 0px ">
		<div style="background: #333; width:100%; float:left; padding:50px 2px 10px 2px;
            color:#FFF; font-size:28px; text-align:center">
            REPORTE DE VENTAS
		</div><!-- end .container -->
           <div style="background: #eee; width:100%; float:left; padding:15px 2px 0px 2px;
                color:#000; font-size:20px; text-align: left; height:60px">
               <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                    onsubmit="return chequearEnvio();">
                    Desde:
                    <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" 
                    	style="width:110px; font-size:20px; height:35px; margin:0px 10px 0px 0px"
                        title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                        value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
                    Hasta:    
                    <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" 
                    	style="width:110px; font-size:20px; height:35px; margin:0px 10px 0px 0px"
                        size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                        value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" /> 
                     Agentes:
                 <select name="id_usuario" id="soflow" style="height:45px; width:280px; margin:-5px 10px 0px 0px; font-size:20px ">
                          <option value="todos" >TODOS</option>
                          <?php
                    do {
                        ?>
                   <option value="<?php echo $row_Recordset2['cod_agencia']?>">
				   		<?php echo strtoupper($row_Recordset2['nom_agencia']); ?>
                   </option>
                          <?php
                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                    ?>
                        </select>
                    <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                     style="width:80px; height:42px; font-size:16px"/>
                    <input type="hidden" name="MM_update" value="form1" />
             </form>  
           </div><!-- end .container -->
        
	</div>
    <script src="../js/jquery.scrollUp.min.js"></script>	
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca2.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$query_Recordset2 = sprintf(
    "
/* PARSEADORES1 new\admin\apuestas_pendientes.php - QUERY 1 */ SELECT * 
FROM 
venta, 
agencia, 
taquilla,
usuario, 
carrera
WHERE
venta.fec_venta >= %s AND venta.fec_venta <= %s AND 
venta.cod_carrera = carrera.cod_carrera AND
taquilla.cod_agencia = agencia.cod_agencia AND 
usuario.id_usuario = venta.id_usuario AND 
usuario.cod_taquilla = taquilla.cod_taquilla AND 
venta.est_ticket != 0 
ORDER BY venta.fec_venta, venta.hor_venta, agencia.cod_agencia, usuario.nom_usuario ASC",
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
        if ($_POST['fecha_inicio']!="" && $_POST['fecha_fin']!="") {
            if (strtotime(fechaymd($_POST['fecha_inicio'])) < strtotime(fechaymd($_POST['fecha_fin']))) {
                $inicio=$_POST['fecha_inicio'];
                $final=$_POST['fecha_fin'];
            } else {
                $final=$_POST['fecha_inicio'];
                $inicio=$_POST['fecha_fin'];
            }
            $in=fechaymd($inicio);
            $fi=fechaymd($final);
            $query_Recordset2 = sprintf(
                "
			/* PARSEADORES1 new\admin\apuestas_pendientes.php - QUERY 2 */ SELECT * 
			FROM 
			carrera, 
			agencia, 
			taquilla,
			usuario, 
			venta

			WHERE
			venta.fec_venta >= %s AND venta.fec_venta <= %s AND 
			venta.cod_carrera = carrera.cod_carrera AND
			taquilla.cod_agencia = agencia.cod_agencia AND 
			usuario.id_usuario = venta.id_usuario AND 
			usuario.cod_taquilla = taquilla.cod_taquilla AND 
			venta.est_ticket != 0 
			ORDER BY venta.fec_venta, venta.hor_venta, agencia.cod_agencia, usuario.nom_usuario ASC",
                GetSQLValueString($in, "date"),
                GetSQLValueString($fi, "date")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        }
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
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#9FBFD7" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
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
                Administración <br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
<div style="height:100%; padding:50px 10px 80px 10px; text-align:left">
       <div style="background: #FFF; width:100%; float:left; padding:15px 0px 0px 10px;
            color:#000; font-size:20px; text-align: left">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                Desde:
                <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" 
                	style="width:100px; font-size:16px; height:30px"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
                Hasta:    
                <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" 
                	style="width:100px; font-size:16px; height:30px"
                    size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" /> 
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:40px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
       </div><!-- end .container -->
<tr style="background: #333; color:#FFFFFF; font-size:16px">
	<td width="856" height="37" align="right" ><strong>TOTAL GENERAL:</strong></td>  
    <td align="right"><strong><div id="totalventas"></div></strong></td>
  </tr>

  <div style="background: #333; width:100%; float:left; padding:12px 0px 0px 0px;
   		color:#FFF; font-size:18px; text-align: center">
        APUESTAS PENDIENTES<br/><br/>
  <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo ""; ?></div> 
  <table width="100%" border="0"  style="background: #FFF;color:#000; font-size:12px; text-align:center;">
      <tr style="background:#5EAEFF;color:#FFF; font-size:12px; text-align:center;">
        <td height="48" valign="bottom">AGENTE</td>
        <td valign="bottom">TAQUILLA</td>
        <td valign="bottom">VENDEDOR</td>
        <td valign="bottom">TICKET#</td>
        <td valign="bottom">FECHA</td>
        <td valign="bottom">HORA</td>
        <td valign="bottom">DESCRIPCIÓN</td>
      </tr>
        <?php
        $agenteActual="";
        $taquillaActual="";
        $montototal=0;
        $contador=1;
        do {
            $ganador=0;
            if ($row_Recordset2['est_ticket']==1 || $row_Recordset2['est_ticket']==3) {
                if ($row_Recordset2['eje_primero']<=0 && $row_Recordset2['eje_segundo']<=0 && $row_Recordset2['eje_tercero']<=0) {
                    $ganador=1;
                }
            }
            if ($ganador>0) {
                $montototal=$montototal+$row_Recordset2['mon_venta']; ?>         
  	<tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
    	<td align="left"><?php echo $row_Recordset2['nom_agencia']; ?></td>
    	<td align="left"><?php echo $row_Recordset2['nom_taquilla']; ?></td>
        <td align="left"><?php echo $row_Recordset2['nom_usuario']; ?></td>
    	<td align="right"><?php echo $row_Recordset2['ticket']; ?></td>
    	<td><?php echo fechanueva($row_Recordset2['fec_venta']); ?></td>
    	<td><?php echo horaampm($row_Recordset2['hor_venta']); ?></td>
    	<td align="left" class="docepunto"><?php echo $row_Recordset2['nom_hipodromo']." Carr. ...".$row_Recordset2['num_carrera']." ".$row_Recordset2['num_caballo']."-".ObtenerNombreApuesta2($row_Recordset2['cod_tventa'])."-".$row_Recordset2['mon_venta']; ?></td>
  	</tr>
 <?php
            }
        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2)); ?>      
</table>
<table width="100%" border="0">
<?php if ($montototal<=0) {?>
    <tr style="background:#FFFFFF; color:#000000">
    	<td align="left" valign="middle"><h3>NO EXISTEN APUESTAS PENDIENTES</h3></td>
  	</tr>
    <tr style="background:#FFFFFF" height="37">
    	<td align="left" valign="middle"></td>
  	</tr>
 <?php } else {?>
  <tr>
    <td>&nbsp;</td>
    <td width="18">&nbsp;</td>
  </tr>
  <tr style="background: #333; color:#FFFFFF; font-size:16px">
	<td width="856" height="37" align="right" ><strong>TOTAL GENERAL:</strong></td>  
    <td align="right"><strong><?php echo number_format($montototal, 2, ",", "."); ?></strong></td>
  </tr>
  <tr style="background: #FFF; color:#FFFFFF; font-size:16px">
	<td width="856" height="37" align="right" ><strong>TOTAL GENERAL:</strong></td>  
    <td align="right"><strong><?php echo number_format($montototal, 2, ",", "."); ?></strong></td>
  </tr>
 <?php }?>   
</table>
      </div><!-- end .container -->
</div>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});document.getElementById('totalventas').innerHTML = "<?php echo number_format($montototal, 2, ",", "."); ?>";</script>

<script src="../js/up.js"></script>
<a class="go-top" href="#">Subir</a>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset2);
?>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechaactual_Recordset1=fechaymd($_POST["fecha"]);
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 admin_hnac\admin_dividendos_lista_hnac.php - QUERY 1 */ SELECT 
		hi.nom_hipodromo_hnac, ca.num_carrera_hnac, ca.fec_carrera_hnac, ca.hor_carrera_hnac, ca.cod_carrera_hnac,
		ca.est_carrera_hnac 
		FROM carrera_hnac ca, hipodromo_hnac hi
		WHERE
		ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac AND  
		ca.est_carrera_hnac = 0 AND 
		ca.est_confirmacion_hnac = 0 AND 
		ca.est_cierre_hnac = 1 AND 
		ca.fec_carrera_hnac = %s 
		ORDER BY ca.hor_carrera_hnac DESC",
        GetSQLValueString($fechaactual_Recordset1, "date")
    );
    $fecha=$_POST["fecha"];
} else {
    $fechaactual_Recordset1 = fechaactualbd();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 admin_hnac\admin_dividendos_lista_hnac.php - QUERY 2 */ SELECT hi.nom_hipodromo_hnac, ca.num_carrera_hnac, ca.fec_carrera_hnac, ca.hor_carrera_hnac,
		ca.cod_carrera_hnac, ca.est_carrera_hnac 
		FROM carrera_hnac ca, hipodromo_hnac hi
		WHERE
		ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac AND  
		ca.est_carrera_hnac = 0 AND 
		ca.est_confirmacion_hnac = 0 AND 
		ca.est_cierre_hnac = 1 AND 
		ca.fec_carrera_hnac = %s 
		ORDER BY ca.hor_carrera_hnac DESC",
        GetSQLValueString($fechaactual_Recordset1, "date")
    );
    $fecha=fechanueva(fechaactualbd());
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
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Resultados y <br/>Ejemplares ganadores
			</div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
		</div>
  <div class="contentAdmin">
<div style="height:100%; padding:40px 10px 180px 10px; text-align:left">
      <div style="text-align: right;" id="fecha">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                Fecha:
                <input name="fecha" type="text" id="dateArrival1" tabindex="1" style="width:100px; font-size:18px; height: 24px"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:34px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
      </div>
   <?php if ($totalRows_Recordset1>=1) {  ?> 
<table width="100%" border="1" align="center" bordercolor="#0E5157">
  <tr style="background:#0E5157; color:#FFFFFF; height:30px;">
    <td width="560">HIPÓDROMO</td>
    <td width="142" align="center">FECHA</td>
    <td width="143" align="center">HORA</td>
    <td align="center">ACCIÓN</td>
  </tr>
  <?php
  $k=1;
  do {
      list($ej1si, , , , )=buscaDivOficiales($row_Recordset1['cod_carrera_hnac'], $row_Recordset1['fec_carrera_hnac'], 1, 11);
      if ($ej1si==0) {
          ?>
		<tr class="brillo">
		  <td align="left"><?php echo $row_Recordset1['nom_hipodromo_hnac'].": ...".$row_Recordset1['num_carrera_hnac']; ?></td>
		  <td align="center"><?php echo fechanueva($row_Recordset1['fec_carrera_hnac']); ?></td>
		  <td align="center"><?php echo horaampm($row_Recordset1['hor_carrera_hnac']); ?></td>
		  <td align="center">
		  <?php if ($row_Recordset1['fec_carrera_hnac']<$fecha && $row_Recordset1['est_carrera_hnac']==1) {?>
		  <a href="dividendos_cerrar_anterior.php?recordID=<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" title="cerrar carrera"><i class="fa fa-lock fa-2x"></i></a>
		  <?php } else {?>
			<a href="admin_dividendos_add_hnac.php?recordID=<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" title="incluir dividendos"><i class="fa fa-plus-circle fa-2x"></i></a>
	
		<?php } ?>    
		</td>
		  </tr>
	  <tr bgcolor="#FFFFFF" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" 
		style="font-size:14px; display:none" class="<?php echo $ca?>" id="<?php echo $ca?>">
		<td height="1" colspan="4" style="text-align:left">11
		</td>
	  </tr>
		  
		<?php
        $k++;
      }
  } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    </table>
    <?php if ($k==1) {?>
        <div style="height:100%; font-size:24px; padding:200px 0px 80px 0px; text-align:center ">
            No existen registros
        </div>
    <?php }?>
<?php } else { ?>
        <table width="100%" border="1" align="center" bordercolor="#0E5157">
          <tr style="background:#0E5157; color:#FFFFFF; height:30px">
            <td width="483">HIPÓDROMO</td>
            <td width="178" align="center">FECHA</td>
            <td width="182" align="center">HORA</td>
            <td width="49" align="center">ACCIÓN</td>
          </tr>
        </table>
        <div style="height:100%; font-size:24px; padding:200px 0px 80px 0px; text-align:center ">
            No existen registros
        </div>
<?php }?>
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

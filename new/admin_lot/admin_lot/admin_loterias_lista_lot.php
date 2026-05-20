<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$query_Recordset1 =  sprintf("/* PARSEADORES1 new\admin_lot\admin_lot\admin_loterias_lista_lot.php - QUERY 1 */ SELECT 
	lo.id_loteria, lo.nom_loteria, lo.est_loteria, so.id_sorteo,
	CASE lo.tip_loteria  
		WHEN 1 THEN 'TRIPLE'
		WHEN 3 THEN 'ZODIACAL'
		WHEN 4 THEN 'ANIMALITOS'
		ELSE 'NO DEFINIDO'
	END AS tipo,
	CASE lo.est_loteria  
		WHEN 0 THEN '<font color=red>INACTIVO</font>'
		WHEN 1 THEN 'ACTIVO'
		ELSE 'NO DEFINIDO'
	END AS estado,
	so.nom_sorteo
	FROM loterias lo
	LEFT JOIN sorteos so ON (lo.id_sorteo = so.id_sorteo)
	WHERE lo.tip_loteria=1 OR lo.tip_loteria=3 OR lo.tip_loteria=4
	ORDER BY so.nom_sorteo ASC, id_grupo_lot ASC, so.hor_sorteo ASC, lo.nom_loteria ASC");
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
</script></script><script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0084B4">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_lot.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Lista de Loterias<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:40px; font-size:28px; padding:10px 10px 10px 10px; float:right;"></div>
          <?php if ($totalRows_Recordset1>0) {?>
        <div style="height:100%; padding:0px 0px 200px 0px ">
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr valign="bottom" style="background:#0084B4; color:#FFFFFF; height:30px; 
                    font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
                    <td width="44%" height="40">LOTERIA</td>
                    <td width="22%">SORTEO</td>
                    <td width="15%">TIPO</td>
                    <td width="10%">STATUS</td>
                    <td width="9%">ACCION</td>
                </tr><?php
                do { ?>
                    <tr class="brillo" style="border-bottom:1px solid  #D5D5D5; font-size:14px">
                        <td align="left"><strong><?php echo $row_Recordset1['nom_loteria']; ?></strong></td>
                        <td><?php echo $row_Recordset1['nom_sorteo']; ?></td>
                        <td><?php echo $row_Recordset1['tipo']; ?></td>
                        <td><?php echo $row_Recordset1['estado']; ?></td>
                        <td>
                            <a href='admin_sorteos_edit_lot.php?recordID=<?php echo $row_Recordset1['id_sorteo']; ?>'
                            class="btn btn-info" 
                            style="text-decoration:none;height:10px;font-size:11px; padding:1px 0 6px 0; width:60px"> EDITAR </a>
                        </td>
                    </tr><?php
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
                <tr>
                    <td style="background:#0084B4;" colspan="6">&nbsp;</td>
                </tr>
            </table>
    
        </div>
       <?php } else {?>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr style="background:#0084B4; color:#FFFFFF; height:30px; 
                    font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
                    <td width="44%">LOTERIA</td>
                    <td width="22%">SORTEO</td>
                    <td width="15%">TIPO</td>
                    <td width="10%">STATUS</td>
                    <td width="9%">ACCION</td>
                </tr>
            </table>
          <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px ">
            No existen registros
        </div>
   
      <?php }?>  
</div>
  </div>
  <div class="footer" style="background:#0084B4">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>
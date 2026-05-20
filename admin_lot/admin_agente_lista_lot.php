<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$currentPage = $_SERVER["PHP_SELF"];
$query_Recordset1 =  sprintf("/* PARSEADORES1 admin_lot\admin_agente_lista_lot.php - QUERY 1 */ SELECT 
		ag.tel_agencia, ag.tel_agencia2, ag.tel_agencia3, ag.nom_agencia, ag.cod_agencia, 
		ba.nom_banca, ba.cod_banca, 
		
		CASE ag.est_agencia  
			WHEN 0 THEN '<font color=red>INACTIVO</font>'
			WHEN 1 THEN 'ACTIVO'
			ELSE 'NO DEFINIDO'
		END AS estado,
		(/* PARSEADORES1 admin_lot\admin_agente_lista_lot.php - QUERY 2 */ SELECT bl.id_banlot FROM bancaloterias bl WHERE ag.cod_banca = bl.id_banca LIMIT 1) AS idbanlot,
		(/* PARSEADORES1 admin_lot\admin_agente_lista_lot.php - QUERY 3 */ SELECT al.id_agelot FROM agencialoterias al WHERE ag.cod_agencia = al.id_agencia LIMIT 1) AS idagelot
		
		
	FROM 
	agencia ag, banca ba
	WHERE ag.cod_banca = ba.cod_banca
	ORDER BY 
	 ba.nom_banca ASC, ag.nom_agencia ASC, ba.est_banca DESC");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
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
<script type="text/javascript" src="jslot/jquery-1.9.1.min.js"></script>
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
              Lista de Distribuidores<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
	<div style="height:100%; font-size:18px;" class="xfirefox">
        <div style="height:100%; font-size:28px; padding:10px 10px 10px 10px; float:right;">
            <a href="admin_agente_add_lot.php" class="btn alert-success" 
            	style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nueva taquilla">
                Añadir Nuevo Agente
            </a>
        </div>
          <?php if ($totalRows_Recordset1>0) {?>
    <div style="height:100%; padding:0px 0px 200px 0px ">   
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
  		  <td height="37" colspan="4">&nbsp;</td>
	</tr>
	<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;" valign="bottom">
        <td width="33%">AGENTE</td>
        <td width="33%" align="center">CONTACTO</td>
        <td width="12%">STATUS</td>
        <td width="22%">ACCION</td>
  </tr>
  <?php do { ?>
    <tr class="brillo" style="border-bottom:1px solid  #D5D5D5" valign="bottom">
      <td align="left" style="line-height:1.1">
		<?php
        echo $row_Recordset1['nom_agencia']."<br/><font face='times new roman' size=1.5>";
        echo $row_Recordset1['nom_banca']."</font>";?>
        </td>
      <td align="center" style="font-size:14px">
	  	<?php
            echo $row_Recordset1['tel_agencia'].".".$row_Recordset1['tel_agencia2'].".".$row_Recordset1['tel_agencia3']; ?>
	  </td>
      <td align="center" valign="middle"><?php echo $row_Recordset1['estado']; ?></td>
      <td align="center" valign="middle">
		  <?php
          $bo=1;
          if ($row_Recordset1['idbanlot']==0) {
              $acc='<font size="1.5">CREE LAS OPCIONES DEL DISTRIBUIDOR PRIMERO</font>';
              $url='admin_distri_edit_lot.php?recordID='.$row_Recordset1['cod_banca'];
              $bo=0;
          } else {
              $url='admin_agente_edit_lot.php?recordID='.$row_Recordset1['cod_agencia'];
              if ($row_Recordset1['idagelot']==0) {
                  $acc="CREAR OPCIONES";
              } else {
                  $acc="EDITAR";
              }
          }
          if ($bo==1) {?>
          		<a href='<?php echo $url;?>' class="btn btn-info" style="text-decoration:none"><?php echo $acc; ?></a><?php
          } else {?>
				<a href='<?php echo $url;?>' class="btn btn-success" 
                	style="text-decoration:none; width:140px; height:22px; line-height:13px"><?php echo $acc; ?></a><?php
          }?>
            
      </td>
    </tr>
<?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
	<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;" valign="bottom">
        <td height="10" colspan="4">&nbsp;</td>
	</tr>
	</table>
      </div>
       <?php } else {?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
  		  <td height="37" colspan="4">&nbsp;</td>
	</tr>
	<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;" valign="bottom">
        <td width="33%">AGENTE</td>
        <td width="33%" align="center">CONTACTO</td>
        <td width="12%">STATUS</td>
        <td width="22%">ACCION</td>
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
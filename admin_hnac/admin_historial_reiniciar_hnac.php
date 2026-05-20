<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_GET["fechaID"])) {
    $fechaactual_Recordset1 = $_GET["fechaID"];
    $fecha=fechanueva($_GET["fechaID"]);
} else {
    $fechaactual_Recordset1 = fechaactualbd();
    $fecha=fechanueva(fechaactualbd());
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechaactual_Recordset1=fechaymd($_POST["fecha"]);
    $fecha=$_POST["fecha"];
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 admin_hnac\admin_historial_reiniciar_hnac.php - QUERY 1 */ SELECT hi.nom_hipodromo_hnac, ca.num_carrera_hnac, ca.fec_carrera_hnac, ca.hor_carrera_hnac,
			ca.cod_carrera_hnac, ca.est_cierre_hnac, ca.est_confirmacion_hnac, ca.mtp_control_hnac, ca.mtp_control_hnac 
	FROM carrera_hnac ca, hipodromo_hnac hi, resultados_oficiales_hnac re
	WHERE
	re.cod_carrera_hnac = ca.cod_carrera_hnac AND
	ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac AND  
	ca.est_carrera_hnac = 0 AND 
	ca.est_cierre_hnac >= 0 AND ca.est_cierre_hnac <= 1 AND 
	ca.fec_carrera_hnac = %s
	GROUP BY re.cod_carrera_hnac
	ORDER BY ca.hor_carrera_hnac DESC",
        GetSQLValueString($fechaactual_Recordset1, "date")
    );
} else {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 admin_hnac\admin_historial_reiniciar_hnac.php - QUERY 2 */ SELECT hi.nom_hipodromo_hnac, ca.num_carrera_hnac, ca.fec_carrera_hnac, ca.hor_carrera_hnac,
		ca.cod_carrera_hnac, ca.est_cierre_hnac, ca.est_confirmacion_hnac, ca.mtp_control_hnac, ca.mtp_control_hnac 
	FROM carrera_hnac ca, hipodromo_hnac hi
	WHERE
	ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac AND  
	ca.est_carrera_hnac = 0 AND 
	ca.est_cierre_hnac >= 0 AND ca.est_cierre_hnac <= 1 AND 
	ca.fec_carrera_hnac = %s
	ORDER BY ca.hor_carrera_hnac DESC",
        GetSQLValueString($fechaactual_Recordset1, "date")
    );
}
if(isset($_POST['ticket'])){
    $insertSQL1 = sprintf(
      "/* PARSEADORES1 admin_hnac\admin_historial_reiniciar_hnac.php - QUERY 3 */ UPDATE carrera_hnac
  
  SET
  est_confirmacion_hnac = %s
      WHERE
      cod_carrera_hnac = %s
      ",
      GetSQLValueString(($_POST['est_confirmacion_hnac']), "int"),
      GetSQLValueString(($_POST['ticket']), "text"));
      $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));



      $_POST['rA']=$_POST['ticket'];
      $query_Recordset10 = sprintf(
          "/* PARSEADORES1 admin_hnac\admin_historial_reiniciar_hnac.php - QUERY 4 */ SELECT hi.nom_hipodromo_hnac, ca.num_carrera_hnac, hi.cod_hipodromo_hnac,
      ca.fec_carrera_hnac 
      FROM carrera_hnac ca, hipodromo_hnac hi
      WHERE ca.cod_carrera_hnac=%s AND hi.cod_hipodromo_hnac=ca.cod_hipodromo_hnac LIMIT 1",
          GetSQLValueString($_POST['rA'], "int")
      );
      $Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
      $row_Recordset10 = mysqli_fetch_assoc($Recordset10);
      $totalRows_Recordset10 = mysqli_num_rows($Recordset10);
      if ($totalRows_Recordset10>0) {
          if (is_file('../includes/procesar_ticket_hnac.php')) {
              include("../includes/procesar_ticket_hnac.php");
          }
      }
    }



    if(isset($_POST['reiniciar'])){
        $insertSQL1 = sprintf(
          "/* PARSEADORES1 admin_hnac\admin_historial_reiniciar_hnac.php - QUERY 5 */ UPDATE carrera_hnac
      
      SET
      est_carrera_hnac = %s,
      est_cierre_hnac = %s,
      mtp_control_hnac = %s,
      est_confirmacion_hnac = %s
          WHERE
          cod_carrera_hnac = %s
          ",
        GetSQLValueString(($_POST['est_carrera_hnac']), "int"),
        GetSQLValueString(($_POST['est_cierre_hnac']), "int"),
        GetSQLValueString(($_POST['mtp_control_hnac']), "int"),
        GetSQLValueString(($_POST['est_confirmacion_hnac']), "int"),
        GetSQLValueString(($_POST['reiniciar']), "text"));
          $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

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
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya estÃ¡ siendo enviado, por favor aguarde un instante.");
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
<link href="../fonts/font-awesome.min4.7.0.css" rel="stylesheet">
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
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
        	<div style="background: #0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              REINICIO DE CARRERAS<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="height:100%; padding:40px 10px 80px 10px; text-align:left">
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
<table width="100%" border="0" align="center">
  <tr style="background:#0E5157; color:#FFFFFF; height:30px;">
    <td width="444">HIPÓDROMO</td>
    <td width="175">FECHA CIERRE</td>
    <td width="177">HORA CIERRE</td>
    <td width="180">REINICIAR CARRERAS <br> (DESCUENTO 50% A <br> QUIEN LO USE MAL)</td>
    
  </tr>
  <?php do { ?>
    <tr class="brillo">
      <td align="left">
	  <?php echo $row_Recordset1['nom_hipodromo_hnac'].": ...".$row_Recordset1['num_carrera_hnac'];
      if ($row_Recordset1['est_confirmacion_hnac']==0) {
          echo ' <font size="3" color="red">***SIN CONFIRMAR***</font';
      }
      ?>
      </td>
      <td align="center"><?php echo fechanueva($row_Recordset1['fec_carrera_hnac']); ?></td>
      <td align="center"><?php echo horaampm($row_Recordset1['hor_carrera_hnac']); ?></td>
      
      
        <?php if ($row_Recordset1['est_confirmacion_hnac']==0 && $row_Recordset1['mtp_control_hnac']==0) {?>
       
        
        
        <?php }?>
        <td width="33" align="center">
        
        <form method="POST" name="est_carrera_hnac" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
                <input type="hidden" name="reiniciar" value="<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">    
                <input type="hidden" name="est_carrera_hnac" value="5">
                <input type="hidden" name="est_cierre_hnac" value="5">
                <input type="hidden" name="mtp_control_hnac" value="1">
                <input type="hidden" name="est_confirmacion_hnac" value="0">
                
                <br><button style="width:100px; height:50px; font-size:10px;" title="Reiniciar" class="btn btn-danger">REINICIAR CARRERA</button>
                
            </form>
      
            
    
       </td>

        
        
    </tr>
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</table>
<?php } else { ?>
<br/>
<table width="100%" border="0" align="center">
  <tr style="background:#0E5157; color:#FFFFFF; height:30px;">
    <td width="444">HIPÓDROMO</td>
    <td width="173">FECHA CIERRE</td>
    <td width="177">HORA CIERRE</td>
    <td width="98" colspan="2">ACCIÓN</td>
  </tr>
</table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px; text-align:center ">
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
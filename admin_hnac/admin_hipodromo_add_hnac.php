<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$hoy=fechaactualve();
$men1="";
$men2="";
$hip="";
$dia="-1";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    if (isset($_POST['nom_hipodromo_hnac']) && $_POST['nom_hipodromo_hnac']!="") {
        if (buscaHip_hnac($_POST['nom_hipodromo_hnac'])>0) {
            $men1="ERROR! Nombre de hipódromo ya existe";
            $graba--;
        }
    }
    if (!isset($_POST['dia_lun']) && !isset($_POST['dia_mar']) && !isset($_POST['dia_mie']) && !isset($_POST['dia_jue']) &&
        !isset($_POST['dia_vie']) && !isset($_POST['dia_sab']) && !isset($_POST['dia_dom'])) {
        $men1="ERROR! Indique día";
        $graba--;
    }
    if ($_POST['nom_hipodromo_hnac']=="" || strlen($_POST['nom_hipodromo_hnac'])<4) {
        $men1="nombre no válido";
        $graba--;
    }
    if ($graba==131) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 admin_hnac\admin_hipodromo_add_hnac.php - QUERY 1 */ INSERT INTO hipodromo_hnac
				(nom_hipodromo_hnac,
				est_hipodromo_hnac,
				bus_resultado_hnac,
				bus_inscrito_hnac,
				bus_retirado_hnac) 
				VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo_hnac'])), "text"),
            GetSQLValueString($_POST['est_hipodromo_hnac'], "int"),
            GetSQLValueString($_POST['bus_resultado_hnac'], "int"),
            GetSQLValueString($_POST['bus_inscrito_hnac'], "int"),
            GetSQLValueString($_POST['bus_retirado_hnac'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $insertGoTo = "admin_hipodromos_listas_hnac.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
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
$(document).ready(function() {    
    $('#nom_hipodromo_hnac').blur(function(){
		var taquilla = $('input[name=nom_hipodromo_hnac]').val();
		if(taquilla != '') {
			var nom_taquilla = $(this).val();        
			var dataString = 'nom_taquilla='+nom_taquilla;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarHipodromo_hnac.php",
				data: dataString,
				success: function(data) {
					$('#Info1').html(data);
				}
			});
		};
    });              
});
    
</script>
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
              Apertura de <br/>carreras nacionales
			</div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
  
  <div style="height:100%; padding:80px 10px 80px 10px; text-align:left">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return chequearEnvio();">
      <div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
        <table width="920" align="center">
          <tr valign="baseline">
            <td colspan="11" height="44" align="center" valign="middle" nowrap="nowrap" bgcolor="#333333"
            style="color:#FFF; font-size:24px; font-weight: bold;">
            	DATOS DE HIPÓDROMO NACIONAL
            </td>
          </tr>
          <tr valign="baseline">
            <td width="1" height="68" align="right" nowrap="nowrap">&nbsp;</td>
            <td colspan="5" align="left" valign="bottom" nowrap="nowrap"><br/>Nombre de hipódromo:<br/>
				<input type="text" name="nom_hipodromo_hnac" id="nom_hipodromo_hnac" tabindex="1"
                value="" size="60" placeholder="nombre de hipódromo" title="indique un nombre 4-60 caracteres"
                onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info1');" maxlength="60" required
                style="width:400px; height:30px; font-size:16px"/><br/>
                <div id="Info1" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00;">
				</div>
            </td>
            <td colspan="5" align="left" valign="bottom" nowrap="nowrap" style="color:#C00; text-align:center">
				<?php echo "<strong>".$men1."</strong><br/>".$men2; ?>
            </td>
            </tr>
          <tr valign="baseline">
            <td colspan="11" align="right" nowrap="nowrap"><hr/></td>
            </tr>
          </table>

          <table width="823" border="0">
          <tr style="font-size:12px">
            <td width="61" height="104">&nbsp;</td>
            <td width="162" valign="top" style="font-size:18px">Status:<br/>
              <select name="est_hipodromo_hnac" style="width:120px; height:40px;font-size:16px" class="textbox" tabindex="9">
                <option value="1">ACTIVO</option>
                <option value="0">INACTIVO</option>
                </select>
              </td>
            <td width="202" valign="top" style="font-size:18px">Búsqueda resultados<br/>
              <select name="bus_resultado_hnac" style="width:160px; height:40px;font-size:16px" class="textbox" tabindex="10">
                <option value="0">MANUAL</option>
                <option selected value="1">MAQUINA AZUL</option>
                <option value="2">TU HIPISMO</option>
                </select>            
              </td>
            <td width="205" valign="top" style="font-size:18px">Búsqueda inscritos<br/>
              <select name="bus_inscrito_hnac"  style="width:160px; height:40px;font-size:16px" class="textbox" tabindex="11">
                <option value="0">MANUAL</option>
                <option selected value="1">MAQUINA AZUL</option>
                <option value="2">TU HIPISMO</option>
                </select>            
              </td>
            <td width="171" valign="top" style="font-size:18px">Búsqueda retirados:<br/>
              <select name="bus_retirado_hnac"  style="width:160px; height:40px;font-size:16px" class="textbox" tabindex="11">
                <option value="0">MANUAL</option>
                <option selected value="1">MAQUINA AZUL</option>
                <option value="2">TU HIPISMO</option>
                </select>            
              </td>
          </tr>
          </table>
          
          
          <table width="920" border="0">
          <tr>
            <td width="440" height="67" align="right" valign="top">
              <input type="submit" value="CREAR HIPÓDROMO" class="btn badge-success" title="crear hipódromo" 
              style="width:180px; height:50px; font-size:16px; background:#093; color: #000"/>            
            </td>
            <td width="42">&nbsp;</td>
            <td width="424" align="left" valign="top">
              <a href='admin_hipodromos_listas_hnac.php'
    	             class="btn alert-info" title="cancelar"
                     style="width:150px; height:40px; font-size:16px; background:#900; text-decoration:none">
                <div style="padding:10px 0px 0px 0px; color:#FFFFFF;">CANCELAR</div>
                </a>
            </td>
          </tr>
          </table>
        <input type="hidden" name="MM_insert" value="form1" />
        </div>
      </form>
  </div>  
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>

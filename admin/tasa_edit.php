<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$menNus="";
$menNcus="";
$menPass="";
$menNti="";
$menPas="";
$menHin="";
$menRsup="";
$menMsup="";
$menNti="";
$menTeli="";	// maximo ticket a eliminar
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    $control=0;
    $contron=0;

    if ($graba==31 && $_POST['usdabss']>=1) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 admin\tasa_edit.php - QUERY 1 */ UPDATE tasadecambio
				SET 
                apuestaminbs=%s,
                usdabss=%s,
				copabss=%s,
				solabss=%s 
				WHERE Idtasadecambio=%s",
            GetSQLValueString($_POST['apuestaminbs'], "double"),
            GetSQLValueString($_POST['usdabss'], "double"),
            GetSQLValueString($_POST['copabss'], "double"),
            GetSQLValueString($_POST['solabss'], "double"),
            GetSQLValueString(1, "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        $insertGoTo = "../admin/tasa_edit.php";
        //  if (isset($_SERVER['QUERY_STRING'])) {
        //	$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        // }
        header(sprintf("Location: %s", $insertGoTo));
    }
}


$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 admin\tasa_edit.php - QUERY 2 */ SELECT *
	FROM 
	tasadecambio
	WHERE 
	tasadecambio.Idtasadecambio = %s LIMIT 1",
    GetSQLValueString(1, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
  .textbox, .textboxsmal {
  border: 1px solid #DBE1EB;
  font-size: 18px;
  font-family: Arial, Verdana;
  padding-left: 7px;
  padding-right: 7px;
  padding-top: 10px;
  padding-bottom: 10px;
  border-radius: 4px;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  -o-border-radius: 4px;
  background: #FFFFFF;
  background: linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -moz-linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -webkit-linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -o-linear-gradient(left, #FFFFFF, #F7F9FA);
  color: #2E3133;
  height:20px;
  }
  .textbox:focus, .textboxsmal:focus {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxsmal {
	  width:50px;
	  height:10px;
  }
 </style>
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
<script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
  


</script>
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
                EDITAR TASA<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center">
                <tr valign="baseline">
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td align="left" valign="middle" nowrap>
                    <br>
                  
					
                  </td>
                  <td width="180">&nbsp;</td>
                
                <tr valign="baseline">
                  <td height="26" colspan="3" align="center" valign="middle" nowrap bgcolor="#5EAEFF">DATOS Y OPCIONES DE USUARIO</td>
                </tr>
              </table>
              <table width="921" align="center">
                <tr valign="baseline">
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td width="212">
                  	Min Bs En Usd:<br />
                    <input type="text" name="apuestaminbs" id="apuestaminbs" size="32" class="textbox"  
                     maxlength="20" style="height: auto"
                    value="<?php echo htmlentities($row_Recordset1['apuestaminbs'], ENT_COMPAT, 'utf-8'); ?>" 
                    tabindex="33" />
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menPass; ?></div>
                  </td>

                  <td width="212">
                  	Tasa Usd:<br />
                    <input type="text" name="usdabss" id="usdabss" size="32" class="textbox"  
                     maxlength="20" style="height: auto"
                    value="<?php echo htmlentities($row_Recordset1['usdabss'], ENT_COMPAT, 'utf-8'); ?>" 
                    tabindex="33" />
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menPass; ?></div>
                  </td>
				  
				                    <td width="212">
                  	Tasa Cop:<br />
                    <input type="text" name="copabss" id="copabss" size="32" class="textbox"  
                      maxlength="20" style="height: auto"
                    value="<?php echo htmlentities($row_Recordset1['copabss'], ENT_COMPAT, 'utf-8'); ?>" 
                    tabindex="33" />
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menPass; ?></div>
                  </td>
				  
				                    <td width="212">
                  	Tasa Sol:<br />
                    <input type="text" name="solabss" id="solabss" size="32" class="textbox"  
                      maxlength="20" style="height: auto"
                    value="<?php echo htmlentities($row_Recordset1['solabss'], ENT_COMPAT, 'utf-8'); ?>" 
                    tabindex="33" />
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menPass; ?></div>
                  </td>

                </tr>
              </table>
              <table width="920" border="0">
                  <tr>
                    <td width="16">&nbsp;</td>
                    <td width="123">&nbsp;</td>
                    <td width="66">&nbsp;</td>
                    <td width="141">&nbsp;</td>
                    <td width="97">&nbsp;</td>
                  </tr>
                  <tr>



                    <td>



                  <td>


</td>
                  </tr>
                </table>
                <table width="924" align="center">
                <tr valign="baseline" style="font-size:12px">

                  <td colspan="2" rowspan="2" align="left" valign="top">                 
                  </td>
                  </tr>

                <tr valign="baseline">
                  <td colspan="12" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td colspan="12" align="left" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td colspan="3" align="right" valign="bottom" nowrap>
                  <a href='../admin/taquillas_edit.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="11" align="left" nowrap>&nbsp;</td>
                  </tr>
              </table>
          </div>
          <input type="hidden" name="MM_insert" value="form1"/>



      </form>
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
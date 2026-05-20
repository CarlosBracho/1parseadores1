<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$menSorteo="";
$menPrin="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    $query_Recordset2 =  sprintf(
        "/* PARSEADORES1 admin_lot\admin_lot\admin_grupos_add_lot.php - QUERY 1 */ SELECT 
		nom_grupo_lot
		FROM grupo_loterias 
		WHERE nom_grupo_lot = %s LIMIT 1",
        GetSQLValueString(trim($_POST['nom_grupo_lot']), "text")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    if ($totalRows_Recordset2>0) {
        $menPrin="&nbsp;&nbsp; GRUPO YA EXISTE &nbsp;&nbsp;";
        $graba--;
    }
    if ($_POST['nom_grupo_lot']>=4) {
        $menPrin="&nbsp;&nbsp; INDIQUE NOMBRE DE GRUPO VALIDO &nbsp;&nbsp;";
        $graba--;
    }
    if ($graba==31) {
        $insertSQL2 = sprintf(
            "/* PARSEADORES1 admin_lot\admin_lot\admin_grupos_add_lot.php - QUERY 2 */ INSERT 
			INTO grupo_loterias 
			(nom_grupo_lot, est_grupo_lot) 
			VALUES (%s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_grupo_lot']), "text"),
            GetSQLValueString($_POST['est_grupo_lot'], "int")
        );
        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
        $menPrin="&nbsp;&nbsp; DATOS DE SORTEO GUARDADOS CORRECTAMENTE &nbsp;&nbsp;";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
  .textbox, .textboxsmal {
  border: 1px solid #DBE1EB;
  font-size: 16px;
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
  height:24px;
  width:400PX;
  }
  .textbox:focus {
  color: #2E3133;
  border-color: #FBFFAD;
  }
 </style>
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
 var refreshId1 = setInterval(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);
$('#divPrin').fadeOut(12000);
});
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
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
        <div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
        	id="datosUsuario">
        	<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            	margin:20px 0px 0px 0px; width:240px; font-size:16px"> 
              NUEVO GRUPO<br/>
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
  	<div style="padding:15px 0; float:right; color:#FFFFFF; background:#FF9A9C; font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divPrin">
		<?php echo $menPrin; ?>
    </div>
<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
   	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
            <form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
              <table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline">
                  <td height="52" colspan="10" align="center" valign="middle" nowrap 
                  style="background:#333333; font-size:24px; color: #FFF">
               	  <strong>DATOS DEL GRUPO</strong>
                  </td>
                </tr>
              </table>
              <table width="921" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td width="183">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td width="48" align="left" nowrap>&nbsp;</td>
                  <td width="490" align="left" nowrap>
                  	Nombre del grupo:<br />
                  	<input type="text" name="nom_grupo_lot" class="textbox" placeholder="nombre de grupo" maxlength="30"
                    title="indique un nombre para mostrar en ticket. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" tabindex="1" required
                    value="" size="42" />
                  </td>
                  <td width="200">
                        Status del grupo:<br />
                        <select name="est_grupo_lot" style="width:140px; height: auto" class="textbox" tabindex="6"> 
                          <option value="1">ACTIVO</option>
                          <option value="0">INACTIVO</option>
                        </select>
                  </td>
                  <td width="183" valign="middle">
						<input type="submit" class=" btn btn-success" value="CREAR GRUPO"  tabindex="14"
							style="width:140px; height:40px; font-size:14px;" />
                  </td>
                </tr>
              </table>
                <table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="center" valign="top">
                  </td>
                  </tr>
				</table>
			<input type="hidden" name="MM_insert" value="form1"/>
		</form>
		<table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td align="center">
                  <a href='admin_grupos_lista_lot.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px; text-decoration:none; color:#FFFFFF">
                  	<div style="padding:10px 0px 0px 0px">SALIR</div>
                  </a>
              </td>
            </tr>
          </tbody>
		</table>
          </div>
    </div>
  </div>
  <div class="footer" style="background:#0084B4">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>

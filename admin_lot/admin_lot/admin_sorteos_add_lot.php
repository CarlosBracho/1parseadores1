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
    if ($_POST["id_grupo_lot"]==-1) {
        $menPrin=" SELECCIONE UN GRUPO ";
        $graba--;
    } else {
        $query_Recordset3 =  sprintf(
            "/* PARSEADORES1 admin_lot\admin_lot\admin_sorteos_add_lot.php - QUERY 1 */ SELECT 
			id_grupo_lot, nom_grupo_lot
			FROM grupo_loterias 
			WHERE nom_grupo_lot = %s LIMIT 1",
            GetSQLValueString(trim($_POST['id_grupo_lot']), "text")
        );
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
        if ($totalRows_Recordset3==0) {
            $menPrin="&nbsp;grupo no existe&nbsp;";
            $graba--;
        } else {
            $hora=$_POST['hor'];
            if ($_POST['am']=="PM") {
                if ($_POST['hor']!=12) {
                    $_POST['hor']=$_POST['hor']+12;
                }
            }
            $_POST['nom_sorteo']=$_POST["id_grupo_lot"]." ".$hora.$_POST['am'];
            $query_Recordset2 =  sprintf(
                "/* PARSEADORES1 admin_lot\admin_lot\admin_sorteos_add_lot.php - QUERY 2 */ SELECT 
				nom_sorteo
				FROM sorteos 
				WHERE nom_sorteo = %s LIMIT 1",
                GetSQLValueString(trim($_POST['nom_sorteo']), "text")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2>0) {
                $menPrin="&nbsp;&nbsp;nombre ya existe&nbsp;&nbsp;";
                $graba--;
            }
            if ($_POST['nom_sorteo']=="" || strlen($_POST['nom_sorteo'])<=3) {
                $menPrin="&nbsp;nombre no válido&nbsp;";
                $graba--;
            }
            $hora=$_POST['hor'].":".$_POST['min'].":00";
            if (!isset($_POST['lun'])) {
                $_POST['lun']=0;
            } else {
                $_POST['lun']=1;
            }
            if (!isset($_POST['mar'])) {
                $_POST['mar']=0;
            } else {
                $_POST['mar']=1;
            }
            if (!isset($_POST['mie'])) {
                $_POST['mie']=0;
            } else {
                $_POST['mie']=1;
            }
            if (!isset($_POST['jue'])) {
                $_POST['jue']=0;
            } else {
                $_POST['jue']=1;
            }
            if (!isset($_POST['vie'])) {
                $_POST['vie']=0;
            } else {
                $_POST['vie']=1;
            }
            if (!isset($_POST['sab'])) {
                $_POST['sab']=0;
            } else {
                $_POST['sab']=1;
            }
            if (!isset($_POST['dom'])) {
                $_POST['dom']=0;
            } else {
                $_POST['dom']=1;
            }
        }
    }
    if ($graba==31) {
        $insertSQL2 = sprintf(
            "/* PARSEADORES1 admin_lot\admin_lot\admin_sorteos_add_lot.php - QUERY 3 */ INSERT 
			INTO sorteos 
			(nom_sorteo, hor_sorteo, tur_sorteo, est_sorteo, id_grupo_lot, lun, mar, mie, jue, vie, sab, dom) 
			VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_sorteo']), "text"),
            GetSQLValueString($hora, "date"),
            GetSQLValueString($_POST['tur_sorteo'], "text"),
            GetSQLValueString($_POST['est_sorteo'], "int"),
            GetSQLValueString($row_Recordset3['id_grupo_lot'], "int"),
            GetSQLValueString($_POST['lun'], "int"),
            GetSQLValueString($_POST['mar'], "int"),
            GetSQLValueString($_POST['mie'], "int"),
            GetSQLValueString($_POST['jue'], "int"),
            GetSQLValueString($_POST['vie'], "int"),
            GetSQLValueString($_POST['sab'], "int"),
            GetSQLValueString($_POST['dom'], "int")
        );
        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
        $menPrin="&nbsp;&nbsp; DATOS DE SORTEO GUARDADOS CORRECTAMENTE &nbsp;&nbsp;";
    }
}
$hora="11:30:00";
list($hor, $min, $am)=explode(":", cambioHoramysql($hora));
$query_Recordset1 =  sprintf("/* PARSEADORES1 admin_lot\admin_lot\admin_sorteos_add_lot.php - QUERY 4 */ SELECT id_grupo_lot, nom_grupo_lot FROM grupo_loterias ORDER BY nom_grupo_lot ASC");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
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
  }
  .textbox:focus, .textboxsmal:focus {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxsmal {
	  width:80px;
	  height:8px;
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
function cGrupo() {
	var grupo=document.getElementById('id_grupo_lot').value;document.getElementById('nom_sorteo').value="";
	if (grupo!=""&&grupo!="-1") {
		var grupo=document.getElementById('id_grupo_lot').value;
		var hora=document.getElementById('hor').value+document.getElementById('am').value;
		document.getElementById('nom_sorteo').value=grupo+" "+hora;
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
              NUEVO SORTEO<br/>
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
               	  <strong>DATOS DE SORTEO</strong>
                  </td>
                </tr>
              </table>
              <table width="921" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" nowrap>&nbsp;
                  GRUPO:<br/>
 					<select name="id_grupo_lot" id="id_grupo_lot" class="textbox" onchange="cGrupo()"
                    	style="width:247px; height: auto">
						<option value="-1">SELECCIONE<?php
                        do {?>
                        	<option value="<?php echo $row_Recordset1['nom_grupo_lot']?>">
                        	<?php echo $row_Recordset1['nom_grupo_lot']?></option><?php
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));?>
                    </select>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td width="45" align="left" nowrap>&nbsp;</td>
                  <td width="309" align="left" nowrap>
                  	Nombre de sorteo:<br />
                  	<input type="text" name="nom_sorteo" class="textbox" placeholder="nombre de sorteo" maxlength="30"
                    pattern="[A-Z a-z0-9]{4,30}" title="indique un nombre para mostrar en ticket. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" tabindex="1" disabled="disabled"
                    value="" size="42" id="nom_sorteo" />
                  </td>
                  <td width="161" align="left" nowrap>
                  		Turno:<br/>
                        <select name="tur_sorteo" style="width:140px; height: auto" class="textbox" tabindex="2"> 
                          <option value="M">MAÑANA</option>
                          <option value="T">TARDE</option>
                          <option value="N">NOCHE</option>
                        </select>
                  </td>
                  <td width="200">
                  		Hora cierre de venta:<br/>
                    	<select name="hor" id="hor" style="width: auto; height: auto" class="textbox" tabindex="3"
                        	 onchange="cGrupo()">
                        	<?php for ($i = 1; $i <= 12; $i++) {
                            if ($i<10) {
                                $v="0".$i;
                            } else {
                                $v=$i;
                            } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($v, htmlentities($hor, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                           <?php
                        }?>
                        </select>
                      	<select name="min" style="width: auto; height: auto" class="textbox" tabindex="4">
                        	<?php for ($i = 0; $i <= 55; $i=$i+5) {
                            if ($i<10) {
                                $v="0".$i;
                            } else {
                                $v=$i;
                            } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($v, htmlentities($min, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                            <?php
                        }?>
                      </select>
                      <select name="am" id="am" style="width: auto; height: auto" class="textbox" tabindex="5"
                      	 onchange="cGrupo()">
	                        <option value="AM" <?php
                            if (!(strcmp("AM", htmlentities($am, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>AM
                            </option>
                        	<option value="PM" <?php
                            if (!(strcmp("PM", htmlentities($am, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>PM
                            </option>
                      </select>
                  </td>
                  <td width="172">
                        Status de sorteo:<br />
                        <select name="est_sorteo" style="width:140px; height: auto" class="textbox" tabindex="6"> 
                          <option value="1">ACTIVO</option>
                          <option value="0">INACTIVO</option>
                        </select>
                  </td>
                </tr>
              </table>
                <table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline" style="font-size:12px">
                  <td width="14" align="left" nowrap>&nbsp;</td>
                  <td width="202" align="left" nowrap>&nbsp;</td>
                  <td width="70" align="center" valign="bottom">LUNES</td>
                  <td align="center" valign="bottom">MARTES</td>
                  <td align="center" valign="bottom">MIÉRCOLES</td>
                  <td width="70" align="center" valign="bottom">JUEVES</td>
                  <td width="70" align="center" valign="bottom">VIERNES</td>
                  <td width="70" align="center" valign="bottom">SÁBADO</td>
                  <td width="70" align="center" valign="bottom">DOMINGO</td>
                  <td width="10" rowspan="2" align="right" valign="top">&nbsp;</td>
                  <td width="148" colspan="2" align="left" valign="top">&nbsp;</td>
                  </tr>
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td nowrap align="right">Días de sorteo:</td>
                  <td align="center"><input type="checkbox" name="lun" class="textboxsmal" tabindex="7"
                  value="" checked="checked"/></td>
                  <td width="86" align="center"><input type="checkbox" name="mar" class="textboxsmal" tabindex="8"
                  value="" checked="checked"/></td>
                  <td width="86" align="center"><input type="checkbox" name="mie" class="textboxsmal" tabindex="9"
                  value="" checked="checked"/></td> 
                  <td align="center"><input type="checkbox" name="jue" class="textboxsmal" tabindex="10"
                  value="" checked="checked"/></td>
                  <td align="center"><input type="checkbox" name="vie" class="textboxsmal" tabindex="11"
                  value="" checked="checked"/></td>
                  <td align="center"><input type="checkbox" name="sab" class="textboxsmal" tabindex="12"
                  value="" checked="checked"/></td>
                  <td align="center"><input type="checkbox" name="dom" class="textboxsmal" tabindex="13"
                  value=""/></td>
                  <td colspan="2" align="center" valign="top">
                  	<input type="submit" class=" btn btn-success" value="CREAR SORTEO"  tabindex="14"
                  	style="width:140px; height:40px; font-size:14px;" />
                  </td>
                  </tr>
				</table>
			<input type="hidden" name="MM_insert" value="form1"/>
		</form>
		<table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
          <tbody>
            <tr>
              <td align="center">
                  <a href='admin_sorteos_lista_lot.php'
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
  <div class="footer" style="background:#0084B4">Copyright © Apuestas Hípicas</div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
if (isset($Recordset1)) {
                                mysqli_free_result($Recordset1);
                            }
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
if (isset($Recordset3)) {
    mysqli_free_result($Recordset3);
}
?>

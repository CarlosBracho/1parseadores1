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
$cantidadCarreras=25;
$mesaje="";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    if (isset($_POST["volver"])) {
        $insertGoTo = "admin_apertura_lista.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    } // fin volver
    $bandera=0;
    if (isset($_POST['aceptar'])) {
        if ($_POST['nom_hipodromo']!="") {
            $c=0;
            for ($i = 1 ; $i <= $cantidadCarreras ; $i ++) {
                if (isset($_POST['box_carrera'.$i])) {
                    $bandera=1;
                    $c++;
                }
            }
            if ($c==0) {
                $bandera=3;
            }
            if ($bandera==1) {
                $_POST['fec_carrera']=fechaymd($_POST['fec_carrera']);
                $_POST['cod_banca']=2;
                $_POST['nom_hipodromo']=strtoupper($_POST['nom_hipodromo']);
                $_POST['cod_hipodromo']=strtoupper($_POST['cod_hipodromo']);

                for ($i = 1; $i <= 21; $i++) {
                    if (isset($_POST['box_carrera'.$i])) {
                        if ($_POST['ampm'.$i]=="pm") {
                            $_POST['hor_carrera'.$i]=(int)$_POST['hor_carrera'.$i]+12;
                            if ($_POST['hor_carrera'.$i]==24) {
                                $_POST['hor_carrera'.$i]=12;
                            }
                        }
                        if ($_POST['ampm'.$i]=="am" && $_POST['hor_carrera'.$i]==12) {
                            $_POST['hor_carrera'.$i]="00";
                        }
                        $_POST['hor_carrera']=$_POST['hor_carrera'.$i].":".$_POST['min_carrera'.$i].":00";
                        $_POST['num_carrera']=$i;
                        $_POST['can_caballos']=$_POST['ejemplares'.$i];
                        $hipodomo2=buscaHip2($_POST['nom_hipodromo']);
                        $insertSQL = sprintf(
                            "/* PARSEADORES1 admin\apertura_multiple.php - QUERY 1 */ INSERT INTO carrera (cod_banca, cod_hipodromo, nom_hipodromo, nom_hipodromo_hpi, 
							fec_carrera, hor_carrera, hor_mtp, 
							num_carrera, est_carrera, est_cierre, est_confirmacion, mtp_control, can_caballos) 
							VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($_POST['cod_banca'], "int"),
                            GetSQLValueString(777, "int"),
                            GetSQLValueString($_POST['nom_hipodromo'], "text"),
                            GetSQLValueString($hipodomo2, "text"),
                            GetSQLValueString($_POST['fec_carrera'], "date"),
                            GetSQLValueString($_POST['hor_carrera'], "date"),
                            GetSQLValueString($_POST['hor_carrera'], "date"),
                            GetSQLValueString($_POST['num_carrera'], "int"),
                            GetSQLValueString($_POST['est_carrera'], "int"),
                            GetSQLValueString($_POST['est_cierre'], "int"),
                            GetSQLValueString(1, "int"),
                            GetSQLValueString(1, "int"),
                            GetSQLValueString($_POST['can_caballos'], "int")
                        );
                        
                        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                    }
                }
                $insertGoTo = "admin_apertura_lista.php";
                if (isset($_SERVER['QUERY_STRING'])) {
                    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                    $insertGoTo .= $_SERVER['QUERY_STRING'];
                }
                header(sprintf("Location: %s", $insertGoTo));
            }
        } else {
            $bandera=2;
        }
        switch ($bandera) {
            case "2": $mesaje="Indique nombre de hipódromo. Datos no guardados."; break;
            case "3": $mesaje="Seleccione una carrera. Datos no guardados."; break;
        }
    }
}
$horaArray=array(1,2,3,4,5,6,7,8,9,10,11,12);
$minutoArray=array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59");
$carrerasArray=array(21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40);
 
$query_Recordset2 = "/* PARSEADORES1 admin\apertura_multiple.php - QUERY 2 */ SELECT cod_hipodromo, nom_hipodromo FROM hipodromo WHERE est_hipodromo = 1 ORDER BY nom_hipodromo";
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
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
<script language='javascript' src="../calendario/popcalendar.js"></script>
<script language="JavaScript"> 
function habilita(field1,field2,field3,field4){
	document.getElementById(field1).disabled=!document.getElementById(field1).disabled;
	document.getElementById(field2).disabled=!document.getElementById(field2).disabled;
	document.getElementById(field3).disabled=!document.getElementById(field3).disabled;
	document.getElementById(field4).disabled=!document.getElementById(field4).disabled;
}
</script> 
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
<style>
  .textbox, .textboxsmal
  {
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
  .textbox:focus, .textboxsmal:focus
  {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxsmal
  {
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
                Apertura y Cierre <br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="height:100%; padding:80px 10px 80px 10px; text-align:left;">
		<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return chequearEnvio();">
             <table width="50%" border="0" align="center">
              <tr>
                <td align="left"> Nombre de hipódromo: </td>
                <td align="left">Fecha: </td>
              </tr>
              <tr>
                <td align="left">
                      <select name="nom_hipodromo" style="width:410px; height: auto" class="textbox">
                        <?php
                      do {
                          ?>
                        <option value="<?php echo $row_Recordset2['nom_hipodromo']?>"> 
						<?php echo $row_Recordset2['nom_hipodromo']?></option>
$codhipodromo=$row_Recordset2['nom_hipodromo'];
                        <?php
                      } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                      ?>
                      </select>
                </td>
                <td align="left">
                    <input name="fec_carrera" type="text" class="tcal" style="width:100px; height:25px; font-size:18px" 
                        value="<?php echo $hoy; ?>"/>    
                </td>
              </tr>
            </table>
            <table width="50%" border="0" align="center" bgcolor="#CCCCCC">
              <tr>
                <td colspan="3" align="right"><font color="#FF0000"><?php echo $mesaje; ?></font></td>
              </tr>
              <tr style="background:#333; color:#FFF; height:30px">
                <td width="104" align="center" valign="middle">Número de Carrera</td>
                <td width="223" align="center" valign="middle">Hora de cierre</td>
                <td width="111" align="center" valign="middle">Cantidad de Ejemplares</td>
              </tr>
             <?php for ($i = 1 ; $i <= $cantidadCarreras ; $i ++) {
                          $box_carrera="box_carrera".$i;
                          $hor_carrera="hor_carrera".$i;
                          $min_carrera="min_carrera".$i;
                          $ampm="ampm".$i;
                          $ejemplares="ejemplares".$i; ?>
              <tr  bgcolor="#FFFFCC">
                <td>
                	<input type="checkbox" name="<?php echo $box_carrera ?>" id="<?php echo $box_carrera ?>" 
                    onClick="habilita('<?php echo $hor_carrera ?>','<?php echo $min_carrera ?>','<?php echo $ampm ?>',
                    '<?php echo $ejemplares ?>')" title="<?php echo 'habilitar carrera # '.$i; ?>" style="width:20px;"/>
					<?php echo " Número: ".$i; ?>
                </td>
                <td align="center">
                    <select name="<?php echo $hor_carrera ?>" id="<?php echo $hor_carrera ?>" 
                    style="width:60px; font-size:14px; height:27px" 
                    disabled title="<?php echo 'indique hora de carrera #'.$i; ?>">
                    <?php foreach ($horaArray as $n) { ?>
                    <option value=<?php echo $n ?>><?php echo $n ?></option>
                    <?php  } ?>
                    </select>:<select name="<?php echo $min_carrera ?>" id="<?php echo $min_carrera ?>" 
                    style="width:60px; font-size:14px; height:27px" 
                    disabled title="<?php echo 'indique minutos de carrera #'.$i; ?>">
                    <?php foreach ($minutoArray as $n2) { ?>
                    	<option value="<?php echo $n2 ?>"><?php echo $n2 ?></option>
                    <?php  } ?>
                    </select>
                    <select name="<?php echo $ampm ?>" id="<?php echo $ampm ?>" 
                    style="width:60px; font-size:14px; height:27px" disabled title="am o pm">
                    <option value="am"  selected="selected" >am</option>
                    <option value="pm" >pm</option>
                    </select>
                </td>
                <td align="center">
                	<select name="<?php echo $ejemplares ?>" id="<?php echo $ejemplares ?>" 
                    style="width:60px; font-size:14px; height:27px" 
                    disabled title="<?php echo 'elemplares para carrera #'.$i; ?>">
                    <?php foreach ($carrerasArray as $n3) { ?>
                    	<option value="<?php echo $n3 ?>"><?php echo $n3 ?></option>
                    <?php  } ?>
                    </select>
                </td>
              </tr>
              <?php
                      }?>
                <tr>
                <td colspan="3" align="center">&nbsp;</td>
                </tr>
                <td colspan="3" align="center">
                    <button onClick="return enviado()" type="submit" name="aceptar" title="crear carreras" class="btn badge-warning"
                    style="width:150px;  height:50px; font-size:18px;">Crear carreras</button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" name="volver" title="volver a lista" class="btn btn-danger" 
                    style="width:150px;  height:50px; font-size:18px;">Ir a lista</button>
                 </td>
                </tr>
            </table>  
        <input type="hidden" name="cod_banca" value="" />
        <input type="hidden" name="cod_hipodromo" value="<?php echo $codhipodromo; ?>" />
        <input type="hidden" name="est_carrera" value="1" />
        <input type="hidden" name="est_cierre" value="3" />
        <input type="hidden" name="MM_insert" value="form1" />
	</form>
</div>    
   <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
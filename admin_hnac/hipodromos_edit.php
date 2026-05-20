<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$men0="";
$men1="";
$men2="";
$men3="";
$men4="";
$men5="";
$men6="";
$men7="";
$men8="";
$men9="";
$men10="";
$men11="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    if ($_POST['pre_hipodromo']=="" || strlen($_POST['pre_hipodromo'])<2 || $_POST['pre_hipodromo']==" ") {
        $men2="prefijo no válido";
        $graba--;
    }

    if ($_POST['pre_build']=="" || strlen($_POST['pre_build'])<2 || $_POST['pre_build']==" ") {
        $men2="prefijo build no válido";
        $graba--;
    }

    if ($_POST['nom_hipodromo_hpi']=="" || strlen($_POST['nom_hipodromo_hpi'])<4) {
        $men3="nombre no válido (HorsePlayer).";
        $graba--;
    }
    if ($_POST['nom_hipodromo_sup']=="" || strlen($_POST['nom_hipodromo_sup'])<4) {
        $men4="nombre no válido (Super).";
        $graba--;
    }
    if ($_POST['nom_hipodromo_rac']=="" || strlen($_POST['nom_hipodromo_rac'])<4) {
        $men5="nombre no válido (BuildaBet2).";
        $graba--;
    }



    if ($_POST['dir_pagresultado']=="" || strlen($_POST['dir_pagresultado'])<4) {
        $men6="dirección (TRACK INFO).";
        $graba--;
    }
    if ($_POST['ext_pagresultado']=="" || strlen($_POST['ext_pagresultado'])<4) {
        $men7="extensión (TRACK INFO).";
        $graba--;
    }

    if ($_POST['dir_pagresultado_tvg']=="" || strlen($_POST['dir_pagresultado_tvg'])<4) {
        $men8="dirección (BASIC TVG).";
        $graba--;
    }
    if ($_POST['ext_pagresultado_tvg']=="" || strlen($_POST['ext_pagresultado_tvg'])<4) {
        $men9="extensión (BASIC TVG).";
        $graba--;
    }

    if ($_POST['dir_retirado']=="" || strlen($_POST['dir_retirado'])<4) {
        $men10="dirección (RETIRADOS).";
        $graba--;
    }
    if ($_POST['ext_retirado']=="" || strlen($_POST['ext_retirado'])<4) {
        $men11="extensión (RETIRADOS).";
        $graba--;
    }
    
    if ($graba==31) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 admin_hnac\hipodromos_edit.php - QUERY 1 */ UPDATE hipodromo
				SET
				nom_hipodromo_hpi=%s,
                                mtp_WatchandWager=%s,
				nom_hipodromo_sup=%s,
				nom_hipodromo_rac=%s,

				pre_hipodromo=%s,
				
				pre_build=%s,
				nom_hipodromo_twi=%s,
				pre_twin=%s,
				tip_hipodromo=%s,
				
				pro_desde=%s,
				dir_pagresultado=%s, 
				ext_pagresultado=%s, 

				dir_pagresultado_tvg=%s, 
				ext_pagresultado_tvg=%s,
				
				cod_pagina_rb=%s, 
				
				bus_retirado=%s,
				
				dir_retirado=%s, 
				ext_retirado=%s, 
				est_hipodromo=%s,
				bus_auto=%s,
				bus_resultado_tip=%s,
				mtp_paribetnom=%s,
				mtp_paribet=%s,
				nom_betbird=%s,
				mtp_betbird=%s,
				mtp_betamericanom=%s,
				mtp_betamerica=%s,
				cod_confirmacion=%s
				WHERE cod_hipodromo=%s",
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo_hpi'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['mtp_WatchandWager'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo_sup'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo_rac'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['pre_hipodromo'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['pre_build'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['nom_hipodromo_twi'])), "text"),
            GetSQLValueString(trim(strtoupper($_POST['pre_twin'])), "text"),
            GetSQLValueString($_POST['tip_hipodromo'], "int"),
            GetSQLValueString($_POST['programar_desde'], "int"),
            GetSQLValueString($_POST['dir_pagresultado'], "text"),
            GetSQLValueString($_POST['ext_pagresultado'], "text"),
            GetSQLValueString($_POST['dir_pagresultado_tvg'], "text"),
            GetSQLValueString($_POST['ext_pagresultado_tvg'], "text"),
            GetSQLValueString($_POST['cod_pagina_rb'], "text"),
            GetSQLValueString($_POST['bus_retirado'], "int"),
            GetSQLValueString($_POST['dir_retirado'], "text"),
            GetSQLValueString($_POST['ext_retirado'], "text"),
            GetSQLValueString($_POST['est_hipodromo'], "int"),
            GetSQLValueString($_POST['bus_auto'], "int"),
            GetSQLValueString($_POST['bus_resultado_tip'], "int"),
            GetSQLValueString(trim(strtoupper($_POST['mtp_paribetnom'])), "text"),
            GetSQLValueString($_POST['mtp_paribet'], "int"),
            GetSQLValueString(trim(strtoupper($_POST['nom_betbird'])), "text"),
            GetSQLValueString($_POST['mtp_betbird'], "int"),
            GetSQLValueString(trim(strtoupper($_POST['mtp_betamericanom'])), "text"),
            GetSQLValueString($_POST['mtp_betamerica'], "int"),
            GetSQLValueString($_POST['cod_confirmacion'], "int"),
            GetSQLValueString($_POST['cod_hipodromo'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $insertGoTo = "hipodromo_programa_listas.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}

$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 admin_hnac\hipodromos_edit.php - QUERY 2 */ SELECT *
	FROM  
	hipodromo
	WHERE 
	hipodromo.cod_hipodromo = %s",
    GetSQLValueString($xCodigo, "int")
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
  width:420px;
  }
  .textbox:focus, .textboxLargo:focus {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxLargo {
	  width:50px;
	  height:20px;
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
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}


	function WatchandWager() { 
	propiedades="width=800,height=480,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes";
	window.open("../includes/watchandwager.php","_blank",propiedades); 
	
	
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
                Editar hipódromo<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
    	<div id="Info" style="float: left;font-size:18px; color:#F00; width:100%; background:#FFFFFF; text-align:center">
		<?php
        echo $men0." ".$men1." ".$men2." ".$men3." ".$men4." ".$men5." ".$men6." ".$men7." ".$men8." ".$men9." ".$men10." ".$men11;
        ?>
        </div>
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0">
                <tr valign="baseline">
                  <td height="44" colspan="6" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE HIPÓDROMO
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" valign="middle" nowrap>
                  <div style="float: left; padding:20px 0px 0px 0px; font-size:20px; color: #000; width:525px; height:25px;
                   background:#FFF">
                  Nombre:
                  <?php echo $row_Recordset1['nom_hipodromo']." (".$row_Recordset1['pre_hipodromo'].")"?>
                  </div>
                  </td>

                  <td width="208" align="left">Status:<br/>
                    <select name="est_hipodromo" style="width:140px; height: auto" class="textbox" tabindex="2" >
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($row_Recordset1['est_hipodromo'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>ACTIVO</option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($row_Recordset1['est_hipodromo'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>INACTIVO</option>
                  </select>
                  </td>
                </tr>

                <tr valign="baseline">
                  <td height="51" align="right" nowrap>&nbsp;</td>
                  <td colspan="5" align="left" nowrap>
                                       Prefijo TVG:<br>
                      <input type="text" name="pre_hipodromo" class="textboxLargo" tabindex="1" placeholder="prefijo" 
                      required="required" 
                      value="<?php echo htmlentities($row_Recordset1['pre_hipodromo'], ENT_COMPAT, 'utf-8'); ?>" 
                      id="pre_hipodromo"  size="5" title="indique un prefijo. 1-3 caracteres" style="height:25px; width:70px"/></td>
 </tr>

                <tr valign="baseline">
                  <td height="51" align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
                  Hipódromo WatchandWager: <span style="padding:0px 0px 0px 249px"></span><br>
                  <input type="text" name="nom_hipodromo_hpi" id="nom_hipodromo_hpi" class="textbox" 
                  tabindex="3" style="width:430px; height:25px" required="required" onclick="ocultaDiv('Info');"
                    value="<?php echo htmlentities($row_Recordset1['nom_hipodromo_hpi'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="32" placeholder="nombre de hipódromo (WatchandWager)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60" />
					    <div style="width:6.5%; float:left">
        <br/><br/><br/><a href="javascript:WatchandWager()" title="Ir A Nombres De Hipodromos en WatchandWager ">Ir A Nombres De Hipodromos en WatchandWager</a><br/><br/>
    </div>

</td>



 <td colspan="2" align="right" nowrap>ACTIVAR WatchandWager:<br />

                    <select name="mtp_WatchandWager" style="width:150px; height:35px" class="textbox"  
                    id="mtp_WatchandWager">
                      <option 
                      value="1"
					  <?php if (!(strcmp(1, htmlentities($row_Recordset1['mtp_WatchandWager'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        }?>>Si</option>
                      <option 
                      value="0"
					  <?php if (!(strcmp(0, htmlentities($row_Recordset1['mtp_WatchandWager'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>No</option>
                  </select>  



                  </td>
 </tr>


   <tr valign="baseline">
                  <td height="51" align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
                  NOMBRE AMERIDATOS: <span style="padding:0px 0px 0px 249px"></span><br>

                  <input type="text" name="nom_hipodromo_sup" id="nom_hipodromo_sup" class="textbox" 
                  tabindex="4" style="width:430px; height:25px" required="required" onclick="ocultaDiv('Info');"
                    value="<?php echo htmlentities($row_Recordset1['nom_hipodromo_sup'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="32" placeholder="nombre de hipódromo (Super)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60" />
                  </td>
                  <td colspan="2" align="right" nowrap>ACTIVAR AMERIDATOS:<br />

                    <select name="mtp_paribet" style="width:150px; height:35px" class="textbox" tabindex="7" 
                    id="mtp_paribet">
                      <option 
                      value="1"
					  <?php if (!(strcmp(1, htmlentities($row_Recordset1['mtp_paribet'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        }?>>Si</option>
                      <option 
                      value="0"
					  <?php if (!(strcmp(0, htmlentities($row_Recordset1['mtp_paribet'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>No</option>
                  </select>  
                  </td>


                </tr>
                <tr valign="baseline">
                  <td height="51" align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" nowrap>
                  Hipódromo BuildaBet2:<br>
                  <input type="text" name="nom_hipodromo_rac" id="nom_hipodromo_rac" class="textbox" 
                  tabindex="5" style="width:430px; height:25px" required="required" onclick="ocultaDiv('Info');"
                    value="<?php echo htmlentities($row_Recordset1['nom_hipodromo_rac'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="32" placeholder="nombre de hipódromo (BuildaBet2)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60"/>
                  </td>
                  <td colspan="2" align="left" nowrap>Prefijo BuildaBet2:<br />
                  <input type="text" name="pre_build" class="textboxLargo1" tabindex="1"
                      required="required" 
                      value="<?php echo htmlentities($row_Recordset1['pre_build'], ENT_COMPAT, 'utf-8'); ?>" 
                      id="pre_build"  size="5" title="indique un prefijo. 1-3 caracteres" style="height:25px; width:70px"/>                  </td>
                  <td align="left" nowrap></td>
                </tr>
<tr valign="baseline">
                  <td height="51" align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
                  NOMBRE BETBIRD:<br>
                  <input type="text" name="nom_betbird" id="nom_betbird" class="textbox" 
                  tabindex="5" style="width:430px; height:25px" required="required" onclick="ocultaDiv('Info');"
                    value="<?php echo htmlentities($row_Recordset1['nom_betbird'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="32" placeholder="nombre de hipódromo (betbird)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60"/>
                  </td>
                  <td colspan="2" align="right" nowrap>ACTIVAR BETBIRD:<br />

                    <select name="mtp_betbird" style="width:150px; height:35px" class="textbox" tabindex="7" 
                    id="mtp_paribet">
                      <option 
                      value="1"
					  <?php if (!(strcmp(1, htmlentities($row_Recordset1['mtp_betbird'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        }?>>Si</option>
                      <option 
                      value="0"
					  <?php if (!(strcmp(0, htmlentities($row_Recordset1['mtp_betbird'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>No</option>
                  </select>  
                  </td>
                </tr>
				<tr valign="baseline">
                  <td height="51" align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
                  NOMBRE CAPITALOTBBET:<br>
                  <input type="text" name="mtp_paribetnom" id="mtp_paribetnom" class="textbox" 
                  tabindex="5" style="width:430px; height:25px" required="required" onclick="ocultaDiv('Info');"
                    value="<?php echo htmlentities($row_Recordset1['mtp_paribetnom'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="32" placeholder="nombre de hipódromo (CAPITALOTBBET)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60"/>
                  </td>
                  <td colspan="2" align="right" nowrap>ACTIVAR CAPITALOTBBET:<br />

                    <select name="mtp_paribet" style="width:150px; height:35px" class="textbox" tabindex="7" 
                    id="mtp_paribet">
                      <option 
                      value="1"
					  <?php if (!(strcmp(1, htmlentities($row_Recordset1['mtp_paribet'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        }?>>Si</option>
                      <option 
                      value="0"
					  <?php if (!(strcmp(0, htmlentities($row_Recordset1['mtp_paribet'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>No</option>
                  </select>  
                  </td>
                </tr>
				<tr valign="baseline">
                  <td height="51" align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
                  NOMBRE BETAMERICA:<br>
                  <input type="text" name="mtp_betamericanom" id="mtp_betamericanom" class="textbox" 
                  tabindex="5" style="width:430px; height:25px" required="required" onclick="ocultaDiv('Info');"
                    value="<?php echo htmlentities($row_Recordset1['mtp_betamericanom'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="32" placeholder="nombre de hipódromo (BETAMERICA)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60"/>
                  </td>
                  <td colspan="2" align="right" nowrap>ACTIVAR BETAMERICA:<br />

                    <select name="mtp_betamerica" style="width:150px; height:35px" class="textbox" tabindex="7" 
                    id="mtp_paribet">
                      <option 
                      value="1"
					  <?php if (!(strcmp(1, htmlentities($row_Recordset1['mtp_betamerica'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        }?>>Si</option>
                      <option 
                      value="0"
					  <?php if (!(strcmp(0, htmlentities($row_Recordset1['mtp_betamerica'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>No</option>
                  </select>  
                  </td>
                </tr>
                <tr valign="baseline">
                  <td height="51" align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" nowrap>
                  Hipódromo Twinspires:<br>
                  <input type="text" name="nom_hipodromo_twi" id="nom_hipodromo_twi" class="textbox" 
                  tabindex="5" style="width:430px; height:25px" required="required" onclick="ocultaDiv('Info');"
                    value="<?php echo htmlentities($row_Recordset1['nom_hipodromo_twi'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="32" placeholder="nombre de hipódromo (Twinspires)" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60" />
                  </td>
 </td>
        <tr valign="baseline">
                  <td colspan="2" align="left" nowrap>Prefijo Twinspires:<br />
                  <input type="text" name="pre_twin" class="textboxLargo1" tabindex="1"
                      required="required" 
                      value="<?php echo htmlentities($row_Recordset1['pre_twin'], ENT_COMPAT, 'utf-8'); ?>" 
                      id="pre_twin"  size="5" title="indique un prefijo. 1-3 caracteres" style="height:25px; width:70px"/>                  </td>
                  <td align="left" nowrap>Status:<br/>
                    <select name="tip_hipodromo" style="width:140px; height: auto" class="textbox" tabindex="2" >
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($row_Recordset1['tip_hipodromo'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>CABALLOS</option>
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($row_Recordset1['tip_hipodromo'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>CARRETAS</option>
                    <option value="1" 
					<?php if (!(strcmp(2, htmlentities($row_Recordset1['tip_hipodromo'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>CANINOS</option>
                  </select>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td colspan="6" align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="64" align="right" nowrap>&nbsp;</td>
                  <td width="223" align="left" valign="bottom" nowrap>
					Busqueda resultados:<br/>
                    <select name="bus_resultado_tip" style="width:200px; height:35px" class="textbox" tabindex="6" 
                    id="bus_resultado_tip">
                      <option style=" color:#CC0000" 
                      value="0"
					  <?php if (!(strcmp(0, htmlentities($row_Recordset1['bus_resultado_tip'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        }?>>DESHABILITADO</option>
                      <option 
                      value="1"
					  <?php if (!(strcmp(1, htmlentities($row_Recordset1['bus_resultado_tip'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        }?>>TRACK INFO</option>
                      <option 
                      value="2"
					  <?php if (!(strcmp(2, htmlentities($row_Recordset1['bus_resultado_tip'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>BASIC TVG</option>
                      <option 
                      value="3"
					  <?php if (!(strcmp(3, htmlentities($row_Recordset1['bus_resultado_tip'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>BUILDABET2</option>
                      <option 
                      value="4"
					  <?php if (!(strcmp(4, htmlentities($row_Recordset1['bus_resultado_tip'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>TWINSPIRES</option>
                  </select>                  
                  </td>
                  <td width="232" align="left" valign="bottom" nowrap>
					Pedir confirmación:<br/>
                    <select name="cod_confirmacion" style="width:150px; height:35px" class="textbox" tabindex="7" 
                    id="cod_confirmacion">
                      <option 
                      value="1"
					  <?php if (!(strcmp(1, htmlentities($row_Recordset1['cod_confirmacion'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        }?>>Si</option>
                      <option 
                      value="0"
					  <?php if (!(strcmp(0, htmlentities($row_Recordset1['cod_confirmacion'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>No</option>
                  </select>                  
                  </td>
                  <td colspan="2" align="left" valign="bottom" nowrap>
                  	Programar desde:<br />
                    <select name="programar_desde" style="width:182px; height:35px" class="textbox" tabindex="8" 
                    id="programar_desde">
                      <option 
                      value="0"<?php if (!(strcmp(0, htmlentities($row_Recordset1['pro_desde'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        }?>>DESHABILITADO</option>
                      <option 
                      value="1"<?php if (!(strcmp(1, htmlentities($row_Recordset1['pro_desde'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>BUILDABET2</option>
                      <option 
                      value="2"<?php if (!(strcmp(2, htmlentities($row_Recordset1['pro_desde'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>BASIC TVG</option>
                      <option     
                      value="3"<?php if (!(strcmp(3, htmlentities($row_Recordset1['pro_desde'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>TWINSPIRES</option>
	                </select>
                  </td>
                  <td align="left" valign="bottom" nowrap>
					Control hora y cierre:<br/>
                    <select name="bus_auto" style="width:190px; height:35px" class="textbox" tabindex="9" id="bus_auto">
                    <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>MANUAL</option>
                    <option value="1"<?php if (!(strcmp(1, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>TWINSPIRES</option>
                    <option value="2"<?php if (!(strcmp(2, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>TRACK INFO</option>
                    <option value="3"<?php if (!(strcmp(3, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>BUILDABET2</option>
                    <option value="4"<?php if (!(strcmp(4, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>BASIC TVG</option>
                    <option value="5"<?php if (!(strcmp(5, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>WATCHANDWAGER</option>
                    <option value="6"<?php if (!(strcmp(6, htmlentities($row_Recordset1['bus_auto'], ENT_COMPAT, 'utf-8')))) {
            echo "SELECTED";
        } ?>>SUPERAMERICANA</option>
                  </select>
                  <?php
                    /* 	2-TRACK INFO
                        3-BUILDABET2
                        4-TVG
                        5-HORSE PLAYER
                        1-TWINSPIRES
                    */
                  ?>
                  
                  </td>
                </tr>
                <tr valign="baseline">
                  <td height="69" align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" valign="bottom" nowrap>
                      TRACK INFO - Buscar resultados desde:<br />
                      <input type="text" name="dir_pagresultado" class="textbox" tabindex="10"
                      size="92" value="<?php echo htmlentities($row_Recordset1['dir_pagresultado'], ENT_COMPAT, 'utf-8'); ?>"
                      id="dir_pagresultado" style="width:500px" required="required"
                      title="indique página de dividendos"
                      onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
                      <div id="Info5" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
                      <?php echo $men5; ?></div>
                  </td>
                  <td colspan="2" align="left" valign="bottom" nowrap>
                  	Extensión resultados:<br />
                    <input type="text" name="ext_pagresultado" class="textboxLargo" tabindex="11"
                    size="17" value="<?php echo htmlentities($row_Recordset1['ext_pagresultado'], ENT_COMPAT, 'utf-8'); ?>" 
                    id="ext_pagresultado" style="width:280px" required="required"
                    title="indique extensión página de dividendos"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
                    <div id="Info6" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
                    <?php echo $men6; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
                      TVG - Buscar resultados desde:<br />
                      <input type="text" name="dir_pagresultado_tvg" class="textbox" tabindex="12" size="92" 
                      value="<?php echo htmlentities($row_Recordset1['dir_pagresultado_tvg'], ENT_COMPAT, 'utf-8'); ?>"
                      id="dir_pagresultado_tvg" style="width:500px"
                      title="indique página de dividendos" required="required"
                      onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
                  </td>
                  <td colspan="2" align="left" nowrap>
                  	Extensión resultados:<br />
                    <input type="text" name="ext_pagresultado_tvg" class="textboxLargo" tabindex="13"
                    size="17" value="<?php echo htmlentities($row_Recordset1['ext_pagresultado_tvg'], ENT_COMPAT, 'utf-8'); ?>"                    id="ext_pagresultado_tvg" style="width:280px" required="required"
                    title="indique extensión página de dividendos"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
                      BUILDABET2 - indique código:<br />
                      <input type="text" name="cod_pagina_rb" class="textbox" tabindex="14"
                      size="400" value="<?php echo htmlentities($row_Recordset1['cod_pagina_rb'], ENT_COMPAT, 'utf-8'); ?>"
                      id="cod_pagina_rb" style="width:500px"
                      title="indique página de dividendos"
                      onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
                  </td>
                  <td colspan="2" align="left" nowrap>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td colspan="6" align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
                  	Busqueda retirados:
                    <select name="bus_retirado" style="width:200px; height:35px" class="textbox" tabindex="15" 
                    id="bus_retirado">
                      <option 
                      value="0"<?php if (!(strcmp(0, htmlentities($row_Recordset1['bus_retirado'], ENT_COMPAT, 'utf-8')))) {
                      echo "SELECTED";
                  }?>>DESHABILITADO</option>
                      <option 
                      value="1"<?php if (!(strcmp(1, htmlentities($row_Recordset1['bus_retirado'], ENT_COMPAT, 'utf-8')))) {
                      echo "SELECTED";
                  } ?>>BASIC TVG</option>
                      <option 
                      value="2"<?php if (!(strcmp(2, htmlentities($row_Recordset1['bus_retirado'], ENT_COMPAT, 'utf-8')))) {
                      echo "SELECTED";
                  } ?>>BUILDABET2</option>
                      <option 
                      value="3"<?php if (!(strcmp(3, htmlentities($row_Recordset1['bus_retirado'], ENT_COMPAT, 'utf-8')))) {
                      echo "SELECTED";
                  } ?>>TWINSPIRES</option>
                  </select><br />                  
                  </td>
                  <td colspan="2" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="3" align="left" nowrap>
                      TVG - Buscar ejemplares retirados desde:<br />
                      <input type="text" name="dir_retirado" class="textbox" tabindex="16"
                      size="92" value="<?php echo htmlentities($row_Recordset1['dir_retirado'], ENT_COMPAT, 'utf-8'); ?>" 
                      id="dir_retirado" style="width:500px" required="required"
                      title="indique página de retirados"
                      onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
                  <td colspan="2" align="left" nowrap>
                      Extensión retirados:<br />
                      <input type="text" name="ext_retirado" class="textboxLargo" tabindex="17"
                      size="17" value="<?php echo htmlentities($row_Recordset1['ext_retirado'], ENT_COMPAT, 'utf-8'); ?>" 
                      id="ext_retirado" style="width:280px" required="required"
                      title="indique extensión página de retirados"
                      onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info');"/>
                    <div id="Info8" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $men8; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td colspan="2" align="right" nowrap>&nbsp;</td>
                  <td width="79" align="right" nowrap>&nbsp;</td>
                  <td width="148" align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
              </table>
		<table width="924" align="center">
            <tr valign="baseline">
              <td colspan="11" align="left" nowrap bgcolor="#5EAEFF">&nbsp;</td>
            </tr>
                <tr valign="baseline">
                  <td width="37" align="left" nowrap>&nbsp;</td>
                  <td width="182" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="18"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="70" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="69" align="left" nowrap>&nbsp;</td>
                  <td width="199" colspan="2" align="right" valign="bottom" nowrap>
                  <a href='hipodromo_programa_listas.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="43" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="10" align="left" nowrap>&nbsp;</td>
            </tr>
              </table>
               
          </div>
          <input type="hidden" name="MM_insert" value="form1"/>
          <input type="hidden" name="cod_hipodromo" value="<?php echo $xCodigo ?>">
      </form>
    </div>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
if (!isset($_SESSION)){session_start();} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$hoy=fechaactualve();
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$_POST['cod_banca']=2;
	$_POST['est_cierre']=3;
	$_POST['nom_hipodromo']=strtoupper($_POST['nom_hipodromo']);
	$_POST['est_carrera']="1";
	if ($_POST['ampm']=="pm") { $_POST['hora']=(int)$_POST['hora']+12; 
		if ($_POST['hora']==24) {$_POST['hora']=12; }
	}
	if ($_POST['ampm']=="am" && $_POST['hora']==12) { $_POST['hora']="00";}
	$_POST['hor_carrera']=$_POST['hora'].":".$_POST['minutos'].":00";
	$_POST['fec_carrera']=fechaymd($_POST['fec_carrera']);
	$hipodomo2=buscaHip2($_POST['nom_hipodromo']);
	if ($_POST['hor_carrera']>horaactual()) $_POST['est_cierre']=2;
  $insertSQL = sprintf("/* PARSEADORES1 new\admin\admin_apertura_add.php - QUERY 1 */ INSERT INTO carrera 
  				(cod_banca, 
				nom_hipodromo, 
				nom_hipodromo_hpi, 
				fec_carrera, 
				hor_carrera, 
				hor_mtp, 
				num_carrera, 
				est_carrera, 
				est_cierre, 
				est_confirmacion,
				mtp_control, 
				can_caballos) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cod_banca'], "int"),
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
					   GetSQLValueString($_POST['can_caballos'], "int"));
  
  $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
  $insertGoTo = "admin_apertura_lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$query_Recordset2 = "/* PARSEADORES1 new\admin\admin_apertura_add.php - QUERY 2 */ SELECT cod_hipodromo, nom_hipodromo FROM hipodromo WHERE est_hipodromo = 1 ORDER BY nom_hipodromo ASC";
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
                Apertura de carrera<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  <div style="height:100%; padding:80px 10px 80px 10px; text-align:left">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return chequearEnvio();">
      <div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
        <table width="920" align="center">
          <tr valign="baseline">
            <td colspan="10" height="44" align="center" valign="middle" nowrap="nowrap" bgcolor="#5EAEFF"
            style="color:#FFF; font-size:24px; font-weight: bold;">
            	DATOS DE CARRERA
            </td>
          </tr>
          <tr valign="baseline">
            <td width="1" height="68" align="right" nowrap="nowrap">&nbsp;</td>
            <td colspan="9" align="left" valign="bottom" nowrap="nowrap">Nombre de hipódromo:<br>
              <select name="nom_hipodromo" style="width:410px; height: auto" class="textbox">
                <?php 
          	  do {  
              ?>
                <option value="<?php echo $row_Recordset2['nom_hipodromo']?>"> <?php echo $row_Recordset2['nom_hipodromo']?></option>
                <?php
              } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
              ?>
              </select>
              </td>
            </tr>
          <tr valign="baseline">
            <td colspan="10" align="right" nowrap="nowrap"><hr/></td>
            </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td width="121" align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
            <td colspan="2" align="left" valign="middle" nowrap="nowrap">Fecha de carrera:</td>
            <td width="203" align="left" nowrap="nowrap">Hora de carrera:</td>
            <td colspan="2" align="left" nowrap="nowrap">Núm. carrera:</td>
            <td colspan="3" valign="middle">Cant. Ejemplares:</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
            <td colspan="2" align="left" valign="middle" nowrap="nowrap">
            	<input name="fec_carrera" type="text" class="tcal" style="width:120px; font-size:20px; height:25px" 
             	 value="<?php echo $hoy; ?>"/>
              </td>
            <td nowrap="nowrap" align="left"><select name="hora" style="width: auto; height: auto" class="textbox">
              <option value="01" <?php if (!(strcmp(01, ""))) {echo "SELECTED";} ?>>01</option>
              <option value="02" <?php if (!(strcmp(02, ""))) {echo "SELECTED";} ?>>02</option>
              <option value="03" <?php if (!(strcmp(03, ""))) {echo "SELECTED";} ?>>03</option>
              <option value="04" <?php if (!(strcmp(04, ""))) {echo "SELECTED";} ?>>04</option>
              <option value="05" <?php if (!(strcmp(05, ""))) {echo "SELECTED";} ?>>05</option>
              <option value="06" <?php if (!(strcmp(06, ""))) {echo "SELECTED";} ?>>06</option>
              <option value="07" <?php if (!(strcmp(07, ""))) {echo "SELECTED";} ?>>07</option>
              <option value="08" <?php if (!(strcmp(08, ""))) {echo "SELECTED";} ?>>08</option>
              <option value="09" <?php if (!(strcmp(09, ""))) {echo "SELECTED";} ?>>09</option>
              <option value="10" <?php if (!(strcmp(10, ""))) {echo "SELECTED";} ?>>10</option>
              <option value="11" <?php if (!(strcmp(11, ""))) {echo "SELECTED";} ?>>11</option>
              <option value="12" <?php if (!(strcmp(12, ""))) {echo "SELECTED";} ?>>12</option>
              </select>
              <select name="minutos"style="width: auto; height: auto" class="textbox">
                <option value="00" <?php if (!(strcmp(00, ""))) {echo "SELECTED";} ?>>00</option>
                <option value="01" <?php if (!(strcmp(01, ""))) {echo "SELECTED";} ?>>01</option>
                <option value="02" <?php if (!(strcmp(02, ""))) {echo "SELECTED";} ?>>02</option>
                <option value="03" <?php if (!(strcmp(03, ""))) {echo "SELECTED";} ?>>03</option>
                <option value="04" <?php if (!(strcmp(04, ""))) {echo "SELECTED";} ?>>04</option>
                <option value="05" <?php if (!(strcmp(05, ""))) {echo "SELECTED";} ?>>05</option>
                <option value="06" <?php if (!(strcmp(06, ""))) {echo "SELECTED";} ?>>06</option>
                <option value="07" <?php if (!(strcmp(07, ""))) {echo "SELECTED";} ?>>07</option>
                <option value="08" <?php if (!(strcmp(08, ""))) {echo "SELECTED";} ?>>08</option>
                <option value="09" <?php if (!(strcmp(09, ""))) {echo "SELECTED";} ?>>09</option>
                <option value="10" <?php if (!(strcmp(10, ""))) {echo "SELECTED";} ?>>10</option>
                <option value="11" <?php if (!(strcmp(11, ""))) {echo "SELECTED";} ?>>11</option>
                <option value="12" <?php if (!(strcmp(12, ""))) {echo "SELECTED";} ?>>12</option>
                <option value="13" <?php if (!(strcmp(13, ""))) {echo "SELECTED";} ?>>13</option>
                <option value="14" <?php if (!(strcmp(14, ""))) {echo "SELECTED";} ?>>14</option>
                <option value="15" <?php if (!(strcmp(15, ""))) {echo "SELECTED";} ?>>15</option>
                <option value="16" <?php if (!(strcmp(16, ""))) {echo "SELECTED";} ?>>16</option>
                <option value="17" <?php if (!(strcmp(17, ""))) {echo "SELECTED";} ?>>17</option>
                <option value="18" <?php if (!(strcmp(18, ""))) {echo "SELECTED";} ?>>18</option>
                <option value="19" <?php if (!(strcmp(19, ""))) {echo "SELECTED";} ?>>19</option>
                <option value="20" <?php if (!(strcmp(20, ""))) {echo "SELECTED";} ?>>20</option>
                <option value="21" <?php if (!(strcmp(21, ""))) {echo "SELECTED";} ?>>21</option>
                <option value="22" <?php if (!(strcmp(22, ""))) {echo "SELECTED";} ?>>22</option>
                <option value="23" <?php if (!(strcmp(23, ""))) {echo "SELECTED";} ?>>23</option>
                <option value="24" <?php if (!(strcmp(24, ""))) {echo "SELECTED";} ?>>24</option>
                <option value="25" <?php if (!(strcmp(25, ""))) {echo "SELECTED";} ?>>25</option>
                <option value="26" <?php if (!(strcmp(26, ""))) {echo "SELECTED";} ?>>26</option>
                <option value="27" <?php if (!(strcmp(27, ""))) {echo "SELECTED";} ?>>27</option>
                <option value="28" <?php if (!(strcmp(28, ""))) {echo "SELECTED";} ?>>28</option>
                <option value="29" <?php if (!(strcmp(29, ""))) {echo "SELECTED";} ?>>29</option>
                <option value="30" <?php if (!(strcmp(30, ""))) {echo "SELECTED";} ?>>30</option>
                <option value="31" <?php if (!(strcmp(31, ""))) {echo "SELECTED";} ?>>31</option>
                <option value="32" <?php if (!(strcmp(32, ""))) {echo "SELECTED";} ?>>32</option>
                <option value="33" <?php if (!(strcmp(33, ""))) {echo "SELECTED";} ?>>33</option>
                <option value="34" <?php if (!(strcmp(34, ""))) {echo "SELECTED";} ?>>34</option>
                <option value="35" <?php if (!(strcmp(35, ""))) {echo "SELECTED";} ?>>35</option>
                <option value="36" <?php if (!(strcmp(36, ""))) {echo "SELECTED";} ?>>36</option>
                <option value="37" <?php if (!(strcmp(37, ""))) {echo "SELECTED";} ?>>37</option>
                <option value="38" <?php if (!(strcmp(38, ""))) {echo "SELECTED";} ?>>38</option>
                <option value="39" <?php if (!(strcmp(39, ""))) {echo "SELECTED";} ?>>39</option>
                <option value="40" <?php if (!(strcmp(40, ""))) {echo "SELECTED";} ?>>40</option>
                <option value="41" <?php if (!(strcmp(41, ""))) {echo "SELECTED";} ?>>41</option>
                <option value="42" <?php if (!(strcmp(42, ""))) {echo "SELECTED";} ?>>42</option>
                <option value="43" <?php if (!(strcmp(43, ""))) {echo "SELECTED";} ?>>43</option>
                <option value="44" <?php if (!(strcmp(44, ""))) {echo "SELECTED";} ?>>44</option>
                <option value="45" <?php if (!(strcmp(45, ""))) {echo "SELECTED";} ?>>45</option>
                <option value="46" <?php if (!(strcmp(46, ""))) {echo "SELECTED";} ?>>46</option>
                <option value="47" <?php if (!(strcmp(47, ""))) {echo "SELECTED";} ?>>47</option>
                <option value="48" <?php if (!(strcmp(48, ""))) {echo "SELECTED";} ?>>48</option>
                <option value="49" <?php if (!(strcmp(49, ""))) {echo "SELECTED";} ?>>49</option>
                <option value="50" <?php if (!(strcmp(50, ""))) {echo "SELECTED";} ?>>50</option>
                <option value="51" <?php if (!(strcmp(51, ""))) {echo "SELECTED";} ?>>51</option>
                <option value="52" <?php if (!(strcmp(52, ""))) {echo "SELECTED";} ?>>52</option>
                <option value="53" <?php if (!(strcmp(53, ""))) {echo "SELECTED";} ?>>53</option>
                <option value="54" <?php if (!(strcmp(54, ""))) {echo "SELECTED";} ?>>54</option>
                <option value="55" <?php if (!(strcmp(55, ""))) {echo "SELECTED";} ?>>55</option>
                <option value="56" <?php if (!(strcmp(56, ""))) {echo "SELECTED";} ?>>56</option>
                <option value="57" <?php if (!(strcmp(57, ""))) {echo "SELECTED";} ?>>57</option>
                <option value="58" <?php if (!(strcmp(58, ""))) {echo "SELECTED";} ?>>58</option>
                <option value="59" <?php if (!(strcmp(59, ""))) {echo "SELECTED";} ?>>59</option>
                </select>
              <select name="ampm" id="ampm" style="width: auto; height: auto" class="textbox">
                <option value="pm" <?php if (!(strcmp("pm", ""))) {echo "SELECTED";} ?>>pm</option>
                <option selected value="am" <?php if (!(strcmp("am", ""))) {echo "SELECTED";} ?>>am</option>
              </select></td>
            <td width="110" align="center" valign="top" nowrap="nowrap">
            <select name="num_carrera" style="width: auto; height: auto" class="textbox">
              <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>1</option>
              <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>2</option>
              <option value="3" <?php if (!(strcmp(3, ""))) {echo "SELECTED";} ?>>3</option>
              <option value="4" <?php if (!(strcmp(4, ""))) {echo "SELECTED";} ?>>4</option>
              <option value="5" <?php if (!(strcmp(5, ""))) {echo "SELECTED";} ?>>5</option>
              <option value="6" <?php if (!(strcmp(6, ""))) {echo "SELECTED";} ?>>6</option>
              <option value="7" <?php if (!(strcmp(7, ""))) {echo "SELECTED";} ?>>7</option>
              <option value="8" <?php if (!(strcmp(8, ""))) {echo "SELECTED";} ?>>8</option>
              <option value="9" <?php if (!(strcmp(9, ""))) {echo "SELECTED";} ?>>9</option>
              <option value="10" <?php if (!(strcmp(10, ""))) {echo "SELECTED";} ?>>10</option>
              <option value="11" <?php if (!(strcmp(11, ""))) {echo "SELECTED";} ?>>11</option>
              <option value="12" <?php if (!(strcmp(12, ""))) {echo "SELECTED";} ?>>12</option>
              <option value="13" <?php if (!(strcmp(13, ""))) {echo "SELECTED";} ?>>13</option>
              <option value="14" <?php if (!(strcmp(14, ""))) {echo "SELECTED";} ?>>14</option>
              <option value="15" <?php if (!(strcmp(15, ""))) {echo "SELECTED";} ?>>15</option>
              <option value="16" <?php if (!(strcmp(16, ""))) {echo "SELECTED";} ?>>16</option>
              <option value="17" <?php if (!(strcmp(17, ""))) {echo "SELECTED";} ?>>17</option>
              <option value="18" <?php if (!(strcmp(18, ""))) {echo "SELECTED";} ?>>18</option>
              <option value="19" <?php if (!(strcmp(19, ""))) {echo "SELECTED";} ?>>19</option>
              <option value="20" <?php if (!(strcmp(20, ""))) {echo "SELECTED";} ?>>20</option>
              <option value="21" <?php if (!(strcmp(21, ""))) {echo "SELECTED";} ?>>21</option>
              <option value="22" <?php if (!(strcmp(22, ""))) {echo "SELECTED";} ?>>22</option>
              <option value="23" <?php if (!(strcmp(23, ""))) {echo "SELECTED";} ?>>23</option>
              <option value="24" <?php if (!(strcmp(24, ""))) {echo "SELECTED";} ?>>24</option>
              <option value="25" <?php if (!(strcmp(25, ""))) {echo "SELECTED";} ?>>25</option>
              <option value="26" <?php if (!(strcmp(26, ""))) {echo "SELECTED";} ?>>26</option>
              <option value="27" <?php if (!(strcmp(27, ""))) {echo "SELECTED";} ?>>27</option>
              <option value="28" <?php if (!(strcmp(28, ""))) {echo "SELECTED";} ?>>28</option>
              <option value="29" <?php if (!(strcmp(29, ""))) {echo "SELECTED";} ?>>29</option>
              <option value="30" <?php if (!(strcmp(30, ""))) {echo "SELECTED";} ?>>30</option>
            </select></td>
            <td width="34" align="center" nowrap="nowrap">&nbsp;</td>
            <td align="center" valign="top">
            <select name="can_caballos" style="width: auto; height: auto" class="textbox">
              <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>1</option>
              <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>2</option>
              <option value="3" <?php if (!(strcmp(3, ""))) {echo "SELECTED";} ?>>3</option>
              <option value="4" <?php if (!(strcmp(4, ""))) {echo "SELECTED";} ?>>4</option>
              <option value="5" <?php if (!(strcmp(5, ""))) {echo "SELECTED";} ?>>5</option>
              <option value="6" <?php if (!(strcmp(6, ""))) {echo "SELECTED";} ?>>6</option>
              <option value="7" <?php if (!(strcmp(7, ""))) {echo "SELECTED";} ?>>7</option>
              <option value="8" <?php if (!(strcmp(8, ""))) {echo "SELECTED";} ?>>8</option>
              <option value="9" <?php if (!(strcmp(9, ""))) {echo "SELECTED";} ?>>9</option>
              <option value="10" <?php if (!(strcmp(10, ""))) {echo "SELECTED";} ?>>10</option>
              <option value="11" <?php if (!(strcmp(11, ""))) {echo "SELECTED";} ?>>11</option>
              <option value="12" <?php if (!(strcmp(12, ""))) {echo "SELECTED";} ?>>12</option>
              <option value="13" <?php if (!(strcmp(13, ""))) {echo "SELECTED";} ?>>13</option>
              <option value="14" <?php if (!(strcmp(14, ""))) {echo "SELECTED";} ?>>14</option>
              <option value="15" <?php if (!(strcmp(15, ""))) {echo "SELECTED";} ?>>15</option>
              <option value="16" <?php if (!(strcmp(16, ""))) {echo "SELECTED";} ?>>16</option>
              <option value="17" <?php if (!(strcmp(17, ""))) {echo "SELECTED";} ?>>17</option>
              <option value="18" <?php if (!(strcmp(18, ""))) {echo "SELECTED";} ?>>18</option>
              <option value="19" <?php if (!(strcmp(19, ""))) {echo "SELECTED";} ?>>19</option>
              <option value="20" <?php if (!(strcmp(20, ""))) {echo "SELECTED";} ?>selected>20</option>
              <option value="21" <?php if (!(strcmp(21, ""))) {echo "SELECTED";} ?>>21</option>
              <option value="22" <?php if (!(strcmp(22, ""))) {echo "SELECTED";} ?>>22</option>
              <option value="23" <?php if (!(strcmp(23, ""))) {echo "SELECTED";} ?>>23</option>
              <option value="24" <?php if (!(strcmp(24, ""))) {echo "SELECTED";} ?>>24</option>
              <option value="25" <?php if (!(strcmp(25, ""))) {echo "SELECTED";} ?>>25</option>
              <option value="26" <?php if (!(strcmp(26, ""))) {echo "SELECTED";} ?>>26</option>
              <option value="27" <?php if (!(strcmp(27, ""))) {echo "SELECTED";} ?>>27</option>
              <option value="28" <?php if (!(strcmp(28, ""))) {echo "SELECTED";} ?>>28</option>
              <option value="29" <?php if (!(strcmp(29, ""))) {echo "SELECTED";} ?>>29</option>
              <option value="30" <?php if (!(strcmp(30, ""))) {echo "SELECTED";} ?>>30</option>
            </select></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="left">&nbsp;</td>
            <td colspan="2" align="left" nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap" align="left">&nbsp;</td>
            <td colspan="2" align="left" nowrap="nowrap">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="left">&nbsp;</td>
            <td colspan="2" align="left" nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap" align="left">&nbsp;</td>
            <td colspan="2" align="left" nowrap="nowrap">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td width="141" align="right" nowrap="nowrap">&nbsp;</td>
            <td colspan="2" align="left" nowrap="nowrap">
              <input type="submit" value="Crear carrera" class="btn badge-warning" style="width:180px; height:50px; font-size:18px;"/>            </td>
            <td colspan="3" align="left" valign="bottom" nowrap="nowrap">
	        	<a href='admin_apertura_lista.php'
    	             class="btn btn-danger" style="width:150px; height:40px; font-size:16px;">
                 	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
            
            <td>&nbsp;</td>
            <td></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td colspan="2" align="right" nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap" align="left">&nbsp;</td>
            <td colspan="2" align="left" nowrap="nowrap">
            	</td>
            <td width="142">&nbsp;</td>
            <td width="66">&nbsp;</td>
            <td width="38"></td>
          </tr>
        </table>
        <input type="hidden" name="cod_banca" value="" />
        <input type="hidden" name="est_carrera" value="" />
        <input type="hidden" name="MM_insert" value="form1" />
        </div>
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
mysqli_free_result($Recordset2);
?>
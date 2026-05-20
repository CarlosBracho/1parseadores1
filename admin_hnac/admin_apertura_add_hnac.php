<?php
if (!isset($_SESSION)){session_start();} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$hoy=fechaactualve();
$men1="";
$men2="";
$hip="";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if ($_POST['ampm']=="pm") { $_POST['hora']=(int)$_POST['hora']+12; 
		if ($_POST['hora']==24) {$_POST['hora']=12; }
	}
	if ($_POST['ampm']=="am" && $_POST['hora']==12) { $_POST['hora']="00";}
	$_POST['hor_carrera']=$_POST['hora'].":".$_POST['minutos'].":00";
	$_POST['fec_carrera']=fechaymd($_POST['fec_carrera']);
	if ($_POST['hor_carrera']>horaactual()) $_POST['est_cierre']=3; else $_POST['est_cierre']=0;
	$estado=compruebaCarr_hnac($_POST['cod_hipodromo'], $_POST['num_carrera'], $_POST['fec_carrera']);
	if ($estado==0) {
$fichero = './parseonacionales';
$nuevo_fichero = '../parseonacionales';

if (!copy($fichero, $nuevo_fichero)) {
}
$fichero = './parseonacionaleshora';
$nuevo_fichero = '../parseonacionaleshora';

if (!copy($fichero, $nuevo_fichero)) {
}
		$insertSQL = sprintf("/* PARSEADORES1 admin_hnac\admin_apertura_add_hnac.php - QUERY 1 */ INSERT INTO carrera_hnac 
					(cod_hipodromo_hnac, 
					fec_carrera_hnac, 
					hor_carrera_hnac,
					est_carrera_hnac,
					est_cierre_hnac,
					can_caballos_hnac,
					num_carrera_hnac,
					dis_carrera_hnac,
					mtp_control_hnac,
					est_confirmacion_hnac) 
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['cod_hipodromo'], "int"),
						   GetSQLValueString($_POST['fec_carrera'], "date"),
						   GetSQLValueString($_POST['hor_carrera'], "date"),
						   GetSQLValueString(5, "int"),
						   GetSQLValueString(5, "int"),
						   GetSQLValueString($_POST['can_caballos'], "int"),
						   GetSQLValueString($_POST['num_carrera'], "int"),
						   GetSQLValueString(0, "int"),
						   GetSQLValueString(0, "int"),
						   GetSQLValueString(0, "int"));
	  
	  $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
		$query_RecT = "/* PARSEADORES1 admin_hnac\admin_apertura_add_hnac.php - QUERY 2 */ SELECT cod_carrera_hnac FROM carrera_hnac ORDER BY cod_carrera_hnac DESC LIMIT 1";
		$RecT = mysqli_query($conexionbanca, $query_RecT) or die(mysqli_error($conexionbanca));
		$row_RecT = mysqli_fetch_assoc($RecT);
		$totalRows_RecT = mysqli_num_rows($RecT);
		$codCarrera=$row_RecT['cod_carrera_hnac'];
		for ($x = 1;  $x <= $_POST['can_caballos']; $x++) {	//guarda los ejemplares
			$insertSQL2 = sprintf("/* PARSEADORES1 admin_hnac\admin_apertura_add_hnac.php - QUERY 3 */ INSERT INTO inscritos 
			(cod_carrera_hnac, 
			num_caballo_hnac, 
			nom_caballo_hnac, 
			nom_jinete_hnac, 
			est_inscrito_hnac) 
			VALUES (%s, %s, %s, %s, %s)",
				GetSQLValueString($codCarrera, "int"),
		   		GetSQLValueString($x, "text"),
		   		GetSQLValueString("SIN ASIGNAR", "text"),
		   	GetSQLValueString("SIN ASIGNAR", "text"),
		   	GetSQLValueString(1, "int"));
			$Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
		}
	  
	  $insertGoTo = "admin_apertura_lista_hnac.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $insertGoTo));
  }
  else {
	  $men1="CARRERA #".$_POST['num_carrera']." NO CREADA";
	  $men2="HA SIDO CREADA ANTERIORMENTE";
	  $hip=$_POST['cod_hipodromo'];
  }
}
$query_Recordset2 = "/* PARSEADORES1 admin_hnac\admin_apertura_add_hnac.php - QUERY 4 */ SELECT cod_hipodromo_hnac, nom_hipodromo_hnac FROM hipodromo_hnac WHERE est_hipodromo_hnac = 1 ORDER BY nom_hipodromo_hnac ASC";
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin_hnac.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabecera_hnac.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
                <!-- InstanceBeginEditable name="pagina" -->
                Apertura de <br/>carreras nacionales
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
              <a href="../admin_hnac/admin_apertura_lista_hnac.php" class="btn alert-success" 
            	style="font-size:14px;width:140px;height:30px;padding:10px 0px 0px 0px;text-align:center;color:#FFFFFF;
                background: #009;text-decoration:none; " title="ir a listas">
                 Volver a listas
              </a>
	</div>
  
  <div style="height:100%; padding:80px 10px 80px 10px; text-align:left">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return chequearEnvio();">
      <div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
        <table width="920" align="center">
          <tr valign="baseline">
            <td colspan="10" height="44" align="center" valign="middle" nowrap="nowrap" bgcolor="#333333"
            style="color:#FFF; font-size:24px; font-weight: bold;">
            	DATOS DE CARRERA NACIONAL
            </td>
          </tr>
          <tr valign="baseline">
            <td width="1" height="68" align="right" nowrap="nowrap">&nbsp;</td>
            <td colspan="4" align="left" valign="bottom" nowrap="nowrap">Nombre de hipódromo:<br>
              <select name="cod_hipodromo" style="width:410px; height: auto" class="textbox">
                <?php 
          	  do {  
              ?>
                <option value="<?php echo $row_Recordset2['cod_hipodromo_hnac'];?>" <?php if (!(strcmp($hip, htmlentities($row_Recordset2['cod_hipodromo_hnac'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>> <?php echo $row_Recordset2['nom_hipodromo_hnac'];?></option>
                <?php
              } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
              ?>
              </select>
              </td>
            <td colspan="5" align="left" valign="bottom" nowrap="nowrap" style="color:#C00; text-align:center">
				<?php echo "<strong>".$men1."</strong><br/>".$men2; ?>
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
            <td colspan="3" valign="middle">Inscritos:</td>
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
              <option value="11" <?php if (!(strcmp(11, ""))) {echo "SELECTED";} ?> selected="selected">11</option>
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
            <select name="num_carrera" style="width: auto; height: auto;" class="textbox">
            <?php 
			for ($i = 1;  $i <= 20; $i++) {?>
            	<option value="<?php echo $i; ?>" <?php if (!(strcmp($i, ""))) {echo "SELECTED";} ?>><?php echo $i; ?></option>
            <?php 
			}?>  
            </select></td>
            <td width="34" align="center" nowrap="nowrap">&nbsp;</td>
            <td align="left" valign="top">
            <select name="can_caballos" style="width: auto; height: auto" class="textbox">
            <?php 
			for ($i = 1;  $i <= 30; $i++) {
				if ($i==20 ) { ?><option value="20" <?php if (!(strcmp(20, ""))) {echo "SELECTED";} ?>
                	selected>20</option> <?php } 
				else {?>
              	<option value="<?php echo $i; ?>" <?php if (!(strcmp($i, ""))) {echo "SELECTED";} ?>><?php echo $i; ?></option>
				<?php } 
			}?>   
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
              <input type="submit" value="CREAR CARRERA" class="btn badge-success" title="crear carrera" 
              style="width:180px; height:50px; font-size:16px; background:#093"/>            </td>
            <td colspan="3" align="left" valign="bottom" nowrap="nowrap">
	        	<a href='admin_apertura_lista_hnac.php'
    	             class="btn alert-info" title="cancelar"
                     style="width:150px; height:40px; font-size:16px; background:#900; text-decoration:none">
                 	<div style="padding:10px 0px 0px 0px; color:#FFFFFF;">CANCELAR</div>
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
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset2);
?>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}

$query_Recordset1 = sprintf("/* PARSEADORES1 admin\apertura_edit.php - QUERY 1 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", GetSQLValueString($xCarrera_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if ($_POST['amopm']=="pm") {
        $_POST['hora']=(int)$_POST['hora']+12;
        if ($_POST['hora']==24) {
            $_POST['hora']=12;
        }
    }
    if ($_POST['amopm']=="am" && $_POST['hora']==12) {
        $_POST['hora']="00";
    }
    $_POST['hor_carrera']=$_POST['hora'].":".$_POST['minutos'].":00";
    $updateSQL = sprintf(
        "/* PARSEADORES1 admin\apertura_edit.php - QUERY 2 */ UPDATE carrera SET 
  		hor_carrera=%s, num_carrera=%s, hor_mtp=%s, can_caballos=%s, est_carrera=%s WHERE cod_carrera=%s",
        GetSQLValueString($_POST['hor_carrera'], "date"),
        GetSQLValueString($_POST['num_carrera'], "int"),
        GetSQLValueString($_POST['hor_carrera'], "date"),
        GetSQLValueString($_POST['can_caballos'], "int"),
        GetSQLValueString("1", "int"),
        GetSQLValueString($_POST['cod_carrera'], "int")
    );
  
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    $updateGoTo = "apertura_lista.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />
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
                <img src="../images/edit-icon.png" alt="" width="24" height="24" /> Editar Carrera<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
	<div style="height:100%; padding:120px 10px 80px 10px; text-align:left">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return chequearEnvio();">
        <table width="374" align="center" class="lista">
          <tr valign="baseline">
            <td width="150" align="right" nowrap="nowrap">Nombre de hipódromo:</td>
            <td width="212"><input name="nom_hipodromo" type="text" id="sprytrigger5" value="<?php echo htmlentities($row_Recordset1['nom_hipodromo'], ENT_COMPAT, 'utf-8'); ?>" size="32" readonly="readonly" style="width:300px; font-size:16px" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Fecha de carrera:</td>
            <td><input name="fec_carrera" type="text" id="sprytrigger4" value="<?php echo htmlentities(fechanueva($row_Recordset1['fec_carrera']), ENT_COMPAT, 'utf-8'); ?>" size="10" readonly="readonly" style='width:100px; font-size:18px'/></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Hora de carrera:</td>
            <td><select name="hora" id="sprytrigger3" style="width:60px; font-size:18px">
            <?php $row_Recordset1['hor_carrera']=horaampm($row_Recordset1['hor_carrera']);
            list($hora, $minutos, $seg)=explode(":", $row_Recordset1['hor_carrera']);
            $ampm=substr($seg, 2, 2);
            $hora = (int)$hora;
            echo $row_Recordset1['hor_carrera']; ?>
   <option value="01" <?php if (!(strcmp(01, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>01</option>
   <option value="02" <?php if (!(strcmp(02, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>02</option>
   <option value="03" <?php if (!(strcmp(03, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>03</option>
   <option value="04" <?php if (!(strcmp(04, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>04</option>
   <option value="05" <?php if (!(strcmp(05, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>05</option>
   <option value="06" <?php if (!(strcmp(06, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>06</option>
   <option value="07" <?php if (!(strcmp(07, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>07</option>
   <option value="08" <?php if (!(strcmp(8, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>08</option>
   <option value="09" <?php if (!(strcmp(9, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>09</option>
   <option value="10" <?php if (!(strcmp(10, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>10</option>
   <option value="11" <?php if (!(strcmp(11, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>11</option>
   <option value="12" <?php if (!(strcmp(12, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>12</option>
            </select>
              <select name="minutos" id="sprytrigger2" style="width:60px; font-size:18px">
              <?php $minutos = (int)$minutos;
                    if ((int)$minutos ==0) {
                        $minutos = "00";
                    } else {
                        $minutos=(int)$minutos;
                    }
                    if ((int)$minutos ==8) {
                        $minutos = "8";
                    }
                    if ((int)$minutos ==9) {
                        $minutos = "9";
                    }
              ?>
    <option value="00" <?php if (!(strcmp(00, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>00</option>
    <option value="01" <?php if (!(strcmp(01, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>01</option>    
    <option value="02" <?php if (!(strcmp(02, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>02</option>
    <option value="03" <?php if (!(strcmp(03, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>03</option>    
    <option value="04" <?php if (!(strcmp(04, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>04</option>
    <option value="05" <?php if (!(strcmp(05, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>05</option>    
    <option value="06" <?php if (!(strcmp(06, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>06</option>
    <option value="07" <?php if (!(strcmp(07, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>07</option>    
    <option value="08" <?php if (!(strcmp(8, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>08</option>
    <option value="09" <?php if (!(strcmp(9, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>09</option>
    <option value="10" <?php if (!(strcmp(10, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>10</option>

    <option value="11" <?php if (!(strcmp(11, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>11</option>    
    <option value="12" <?php if (!(strcmp(12, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>12</option>
    <option value="13" <?php if (!(strcmp(13, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>13</option>    
    <option value="14" <?php if (!(strcmp(14, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>14</option>
    <option value="15" <?php if (!(strcmp(15, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>15</option>    
    <option value="16" <?php if (!(strcmp(16, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>16</option>
    <option value="17" <?php if (!(strcmp(17, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>17</option>    
    <option value="18" <?php if (!(strcmp(18, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>18</option>
    <option value="19" <?php if (!(strcmp(19, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>19</option>
    <option value="20" <?php if (!(strcmp(20, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>20</option>
    
    <option value="21" <?php if (!(strcmp(21, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>21</option>    
    <option value="22" <?php if (!(strcmp(22, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>22</option>
    <option value="23" <?php if (!(strcmp(23, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>23</option>    
    <option value="24" <?php if (!(strcmp(24, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>24</option>
    <option value="25" <?php if (!(strcmp(25, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>25</option>    
    <option value="26" <?php if (!(strcmp(26, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>26</option>
    <option value="27" <?php if (!(strcmp(27, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>27</option>    
    <option value="28" <?php if (!(strcmp(28, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>28</option>
    <option value="29" <?php if (!(strcmp(29, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>29</option>
    <option value="30" <?php if (!(strcmp(30, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>30</option>
    
    <option value="31" <?php if (!(strcmp(31, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>31</option>    
    <option value="32" <?php if (!(strcmp(32, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>32</option>
    <option value="33" <?php if (!(strcmp(33, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>33</option>    
    <option value="34" <?php if (!(strcmp(34, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>34</option>
    <option value="35" <?php if (!(strcmp(35, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>35</option>    
    <option value="36" <?php if (!(strcmp(36, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>36</option>
    <option value="37" <?php if (!(strcmp(37, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>37</option>    
    <option value="38" <?php if (!(strcmp(38, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>38</option>
    <option value="39" <?php if (!(strcmp(39, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>39</option>
    <option value="40" <?php if (!(strcmp(40, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>40</option>
    
    <option value="41" <?php if (!(strcmp(41, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>41</option>    
    <option value="42" <?php if (!(strcmp(42, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>42</option>
    <option value="43" <?php if (!(strcmp(43, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>43</option>    
    <option value="44" <?php if (!(strcmp(44, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>44</option>
    <option value="45" <?php if (!(strcmp(45, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>45</option>    
    <option value="46" <?php if (!(strcmp(46, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>46</option>
    <option value="47" <?php if (!(strcmp(47, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>47</option>    
    <option value="48" <?php if (!(strcmp(48, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>48</option>
    <option value="49" <?php if (!(strcmp(49, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>49</option>
    <option value="50" <?php if (!(strcmp(50, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>50</option>
    
    <option value="51" <?php if (!(strcmp(51, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>51</option>    
    <option value="52" <?php if (!(strcmp(52, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>52</option>
    <option value="53" <?php if (!(strcmp(53, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>53</option>    
    <option value="54" <?php if (!(strcmp(54, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>54</option>
    <option value="55" <?php if (!(strcmp(55, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>55</option>    
    <option value="56" <?php if (!(strcmp(56, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>56</option>
    <option value="57" <?php if (!(strcmp(57, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>57</option>    
    <option value="58" <?php if (!(strcmp(58, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>58</option>
    <option value="59" <?php if (!(strcmp(59, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>59</option>
        
            </select>
              <select name="amopm" id="sprytrigger1" style="width:70px; font-size:16px">
                <option value="am" <?php if (!(strcmp("am", htmlentities($ampm, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>am</option>
                <option value="pm" <?php if (!(strcmp("pm", htmlentities($ampm, ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>pm</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Número de carrera:</td>
            <td><select name="num_carrera" id="sprytrigger6" style="width:60px; font-size:18px">
              <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>1</option>
              <option value="2" <?php if (!(strcmp(2, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>2</option>
              <option value="3" <?php if (!(strcmp(3, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>3</option>
              <option value="4" <?php if (!(strcmp(4, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>4</option>
              <option value="5" <?php if (!(strcmp(5, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>5</option>
              <option value="6" <?php if (!(strcmp(6, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>6</option>
              <option value="7" <?php if (!(strcmp(7, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>7</option>
              <option value="8" <?php if (!(strcmp(8, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>8</option>
              <option value="9" <?php if (!(strcmp(9, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>9</option>
              <option value="10" <?php if (!(strcmp(10, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>10</option>
              <option value="11" <?php if (!(strcmp(11, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>11</option>
              <option value="12" <?php if (!(strcmp(12, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>12</option>
              <option value="13" <?php if (!(strcmp(13, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>13</option>
              <option value="14" <?php if (!(strcmp(14, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>14</option>
              <option value="15" <?php if (!(strcmp(15, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>15</option>
              <option value="16" <?php if (!(strcmp(16, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>16</option>
              <option value="17" <?php if (!(strcmp(17, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>17</option>
              <option value="18" <?php if (!(strcmp(18, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>18</option>
              <option value="19" <?php if (!(strcmp(19, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>19</option>
              <option value="20" <?php if (!(strcmp(20, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>20</option>
              <option value="21" <?php if (!(strcmp(21, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>21</option>
              <option value="22" <?php if (!(strcmp(22, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>22</option>
              <option value="23" <?php if (!(strcmp(23, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>23</option>
              <option value="24" <?php if (!(strcmp(24, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>24</option>
              <option value="25" <?php if (!(strcmp(25, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>25</option>
              <option value="26" <?php if (!(strcmp(26, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>26</option>
              <option value="27" <?php if (!(strcmp(27, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>27</option>
              <option value="28" <?php if (!(strcmp(28, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>28</option>
              <option value="29" <?php if (!(strcmp(29, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>29</option>
              <option value="30" <?php if (!(strcmp(30, htmlentities($row_Recordset1['num_carrera'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>30</option>
            </select></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Cantidad de Ejemplares:</td>
            <td><select name="can_caballos" id="can_caballos" style="width:60px; font-size:18px">
              <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>1</option>
              <option value="2" <?php if (!(strcmp(2, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>2</option>
              <option value="3" <?php if (!(strcmp(3, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>3</option>
              <option value="4" <?php if (!(strcmp(4, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>4</option>
              <option value="5" <?php if (!(strcmp(5, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>5</option>
              <option value="6" <?php if (!(strcmp(6, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>6</option>
              <option value="7" <?php if (!(strcmp(7, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>7</option>
              <option value="8" <?php if (!(strcmp(8, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>8</option>
              <option value="9" <?php if (!(strcmp(9, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>9</option>
              <option value="10" <?php if (!(strcmp(10, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>10</option>
              <option value="11" <?php if (!(strcmp(11, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>11</option>
              <option value="12" <?php if (!(strcmp(12, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>12</option>
              <option value="13" <?php if (!(strcmp(13, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>13</option>
              <option value="14" <?php if (!(strcmp(14, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>14</option>
              <option value="15" <?php if (!(strcmp(15, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>15</option>
              <option value="16" <?php if (!(strcmp(16, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>16</option>
              <option value="17" <?php if (!(strcmp(17, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>17</option>
              <option value="18" <?php if (!(strcmp(18, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>18</option>
              <option value="19" <?php if (!(strcmp(19, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>19</option>
              <option value="20" <?php if (!(strcmp(20, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>20</option>
              <option value="21" <?php if (!(strcmp(21, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>21</option>
              <option value="22" <?php if (!(strcmp(22, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>22</option>
              <option value="23" <?php if (!(strcmp(23, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>23</option>
              <option value="24" <?php if (!(strcmp(24, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>24</option>
              <option value="25" <?php if (!(strcmp(25, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>25</option>
              <option value="26" <?php if (!(strcmp(26, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>26</option>
              <option value="27" <?php if (!(strcmp(27, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>27</option>
              <option value="28" <?php if (!(strcmp(28, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>28</option>
              <option value="29" <?php if (!(strcmp(29, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>29</option>
              <option value="30" <?php if (!(strcmp(30, htmlentities($row_Recordset1['can_caballos'], ENT_COMPAT, 'utf-8')))) {
                  echo "SELECTED";
              } ?>>30</option>
            </select></td>
          </tr>
 
          <tr valign="baseline">
            <td colspan="2" align="center" nowrap="nowrap">
            	<input type="submit" value="Actualizar carrera" class="btn btn-success" style="width:150px; font-size:16px;"/>
            	<a href="apertura_lista.php" class="btn btn-warning" style="width:100px; font-size:18px;">Cancelar</a></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="cod_carrera" value="<?php echo $row_Recordset1['cod_carrera']; ?>" />
      </form>
    </blockquote>
    <div class="tooltipContent" id="sprytooltip6">Número de carrera</div>
    <div class="tooltipContent" id="sprytooltip5">Hipódromo no modificable</div>
    <div class="tooltipContent" id="sprytooltip4">Fecha no modificable</div>
    <div class="tooltipContent" id="sprytooltip3">Hora de la carrera</div>
    <div class="tooltipContent" id="sprytooltip2">Indique minutos</div>
    <div class="tooltipContent" id="sprytooltip1">am ó pm</div>
    <script type="text/javascript">
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1");
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger2");
var sprytooltip3 = new Spry.Widget.Tooltip("sprytooltip3", "#sprytrigger3");
var sprytooltip4 = new Spry.Widget.Tooltip("sprytooltip4", "#sprytrigger4");
var sprytooltip5 = new Spry.Widget.Tooltip("sprytooltip5", "#sprytrigger5");
var sprytooltip6 = new Spry.Widget.Tooltip("sprytooltip6", "#sprytrigger6");
    </script>
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
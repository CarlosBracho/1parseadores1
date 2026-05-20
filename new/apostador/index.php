<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "C"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico">
<title>.:Apuestas Hípicas:.</title>
</head>
<body>
<CENTER>

<table>
<tr>
    <th>

<FONT SIZE=6 COLOR=red>Seleccione una opcion para continuar</FONT>
</th>
</tr>
<?php if ($dist_vende_amex==1 && $agen_vende_amex==1 && $taq_vende_amex==1) { ?>
        <tr><td>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"><img src="images/mf.png" onclick="window.location='internacionalesc.php';" alt="Ventas Full Internacionales" name="mf" width="62" height="75" id="ie2" /></div>
            <br/><input type="button" onclick="window.location='internacionalesc.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Ventas Full Internacionales" />
</td></tr>
        <tr><td>

	  <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"><img src="images/ie.jpg" onclick="window.location='internacionalesc.php';" alt="Ventas Light Internacionales" name="ie" width="62" height="75" id="ie" /></div>
	  <br/><input align="center" type="button" onclick="window.location='internacionalesc.php';"
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Ventas Light Internacionales" />
</td></tr>
<?php } ?>
<?php if ($dist_vende_hnacx==1 && $agen_vende_hnacx==1 && $taq_vende_hnacx==1) { ?>

        <tr><td>

	  <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"><img src="images/ie.jpg" onclick="window.location='ventashnac_mie/index.php';" alt="Ventas Light Nacionales" name="ie" width="62" height="75" id="ie" /></div>
	  <br/><input align="center" type="button" onclick="window.location='ventashnac_mie/index.php';"
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Ventas Light Nacionales" />
</td></tr>
<?php } ?>

</table>

</CENTER>

</body>

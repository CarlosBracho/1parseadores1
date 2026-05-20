<?php
//echo '<br>';
//echo 'v3<br>';
if (!isset($_SESSION)) {
    session_start();
} require_once('Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "index.php"; include("includes/comprobar_acceso.php");
$_SESSION['camino']=0;
$info=detect2();
if (isset($info["version"])) {
} else {
    $info["version"]=11;
}
$infoversionyexp=$_SESSION['MM_Username'].' '.$info["browser"].' '.$info["version"];
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 acceso.php - QUERY 1 */ SELECT exploradorversion
  FROM 
  exploradorversion 
  WHERE 
  exploradorversion = %s",
    GetSQLValueString($infoversionyexp, "text")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($totalRows_Recordset1<1) {
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 acceso.php - QUERY 2 */ INSERT 
		INTO exploradorversion 
		(exploradorversion) 
		VALUES (%s)",
        GetSQLValueString(strtoupper($infoversionyexp), "text")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
}
if ($info["version"]<=9 & $info["browser"]=='IE') {
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
        	padding:5px 5px 5px 5px;"><img src="images/mf.png" onclick="window.location='ventas/index.php';" alt="Ventas Full Internacionales" name="mf" width="62" height="75" id="ie2" /></div>
            <br/><input type="button" onclick="window.location='ventas/index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Ventas Full Internacionales" />
</td></tr>
        <tr><td>

	  <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"><img src="images/ie.jpg" onclick="window.location='ventasmie/index.php';" alt="Ventas Light Internacionales" name="ie" width="62" height="75" id="ie" /></div>
	  <br/><input align="center" type="button" onclick="window.location='ventasmie/index.php';"
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
<?php if ($dist_vende_hnacx==1 && $agen_vende_hnacx==1 && $taq_vende_hnacx==1) { ?>

<tr><td>

<div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
  padding:5px 5px 5px 5px;"><img src="images/mf.png" onclick="window.location='ventashnac_mie/index.php';" alt="Ventas Parley" name="mf" width="62" height="75" id="mf" /></div>
<br/><input align="center" type="button" onclick="window.location='new/parley/1taparley.php';"
      style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
      value="Ventas Parley" />
</td></tr>
<?php } ?>


</table>

</CENTER>

</body>
<?php
} else {?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="./css/bootstrap3.4.1.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

  </head>   
  <body>
  <?php if ($dist_vende_amex==1 && $agen_vende_amex==1 && $taq_vende_amex==1) { ?>
  <br>

  <center>
  <a href='ventas/index.php';> <img src="images/mf.png"> </a>
  </center>
  <button type="button" onclick="window.location='ventas/index.php';" class="btn btn-warning btn-lg btn-block">Ventas Full Internacionales</button>
  
  
  <br>

  <center>
 <a href='ventasmie/index.php';> <img src="images/ie.jpg"> </a>
 </center>
  </div>

  <button type="button" onclick="window.location='ventasmie/index.php';" class="btn btn-primary btn-lg btn-block">Ventas Light Internacionales</button>
  
  <?php } ?>
  <?php if ($dist_vende_hnacx==1 && $agen_vende_hnacx==1 && $taq_vende_hnacx==1) { ?>
  <br>

  <center> 
  <a href='ventashnac_mie/index.php';> <img src="images/ie.jpg"> </a>
  </center>
  </div>

  <button type="button" onclick="window.location='ventashnac_mie/index.php';"class="btn btn-primary btn-lg btn-block">Ventas Light Nacionales</button>
  
  <?php } ?>
  <?php if ($dist_vende_parley==1 && $agen_vende_parley==1 && $taq_vende_parley==1) { ?>
  <br>


  <center>
  <a href='new/parley/1taparley.php';> <img src="images/mf.png"> </a>
  </center>
  <button type="button" onclick="window.location='new/parley/1taparley.php';" class="btn btn-warning btn-lg btn-block">Ventas Parley</button>
  
  <?php } ?>
  <br>



  <?php if ($dist_vende_ani==1 && $agen_vende_ani==1 && $taq_vende_ani==1) { ?>


  <center>
  <a href='/Venta_Animalitos/index.php';> <img src="images/mf.png"> </a>
  </center>
  <button type="button" onclick="window.location='/Venta_Animalitos/index.php';" class="btn btn-warning btn-lg btn-block">Ventas Animalitos</button>
  
  <?php } ?>
  <br>











    <h1></h1>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="./js/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./js/bootstrap3.4.1.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  </body>
</html>






<?php
} ?>
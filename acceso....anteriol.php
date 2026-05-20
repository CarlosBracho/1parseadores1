<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "index.php"; include("includes/comprobar_acceso.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico">
<title>.:Apuestas Hípicas:.</title>
<!--[if lt IE 7]><script type="text/javascript">alert("ATENCIÓN: Este software solo funciona con \nMicrosoft Internet Explorer 7 o superior\n\nPor favor, actualice su navegador");location.href='../index.php';</script><![endif]-->
<!--[if lt IE 8]><link href="../estilo/styleIE7.css" rel="stylesheet"> <!--<![endif]-->
<style type="text/css">
html, body {
  font-family: Arial, sans-serif;
  background: #fff;
  margin: 0;
  padding: 0;
  border: 0;
  position: absolute;
  height: 100%;
  min-width: 100%;
  font-size: 13px;
  color: #404040;
  direction: ltr;
  -webkit-text-size-adjust: none;
  }
  button,
  input[type=button],
  input[type=submit] {
  font-family: Arial, sans-serif;
  font-size: 13px;
  }
  h1 {
  font-size: 20px;
  color: #262626;
  margin: 0 0 15px;
  font-weight: normal;
  }
  h2 {
  font-size: 14px;
  color: #262626;
  margin: 0 0 15px;
  font-weight: bold;
  }
a img {
border: none;
}
a:link   
{   
 text-decoration:none;   
}   
</style>
</head>
<body>
<div id="centro" style=" font-size:30px;position:absolute; left:50%; top:50%; width:400px; height:300px; 
    margin-top: -150px; margin-left: -200px; overflow:hidden; text-align:center;">
    <br/>
	Seleccione para continuar
    <div style="background: #F7F7F7; position:absolute; left:50%; top:50%; width:300px; height:200px; 
    	margin-top: -100px; margin-left: -150px; overflow:hidden; border: 1px solid  #DFDFDF;">
        
	  <div style="font-size:18px;width:140px; height:140px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;">
			<?php
            $info=detect();
            if ($info['browser']=="IE" && $info['version']=="7.0") {
                $ver1='<img src="images/ie.jpg" width="84" height="94" />';
                $ver2='<img src="images/mf.png" width="84" height="94" /><br/>';
            } else {
                $ver1='<i class="fa fa-internet-explorer fa-5x"></i>';
                $ver2='<i class="fa fa-firefox fa-5x"></i>Firefox';
            }
            echo '<a href="ventasmie/index.php">'.$ver1.'Internet Explorer</a>';
            ?>
      </div>
	  <div style="font-size:18px;width:140px; height:140px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px; color:#F90">
			<?php
            echo '<a href="ventasmie/index.php">'.$ver2.'Firefox </a>';
            ?>
      </div>
      <form id="inicio" name="inicio">
        	<input type="button" onclick="window.location='ventasmie/index.php';"
            	style="height:35px; width:120px; font-size:18px; margin:0px 15px 0px 0px" 
            	value="Ventas Light" />
            <input type="button" onclick="window.location='ventas/index.php';" 
            	style="height:35px; width:120px; font-size:18px; margin:1px 0px 0px 0px" 
            	value="Ventas Full" />
      </form>
    </div>
    <p style="padding:430px 0px 0px 0px; font-size:12px; color:#4888F2">
    localhost. © Copyright 2012. apuestas hípicas
    </p>
</div>
</body>
</html>
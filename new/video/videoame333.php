<?php 
//if (!isset($_SESSION)){session_start();} require_once('../Connections/conexionbanca.php'); 
//$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
?>
<?php
// Referrer válido 
$string="http://localhost/";
$string1="http://www.localhost/";




// Controlo que el referrer sea el correcto
if

(substr($_SERVER["HTTP_REFERER"],0,strlen($string))!=$string   and 
substr($_SERVER["HTTP_REFERER"],0,strlen($string1))!=$string1  and
substr($_SERVER["HTTP_REFERER"],0,strlen($string2))!=$string2  and
substr($_SERVER["HTTP_REFERER"],0,strlen($string3))!=$string3  and
substr($_SERVER["HTTP_REFERER"],0,strlen($string4))!=$string4  and
substr($_SERVER["HTTP_REFERER"],0,strlen($string5))!=$string5  )        
{
// Si el referrer no es válido, se prohibe el acceso
?>

<html>


<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">

</head>
<body> 
 
<iframe scrolling=no frameborder="0 "width="1300" height="1000" src="http://www.tvodirect.com.ve/video333.php"></iframe>

</body>
</html>
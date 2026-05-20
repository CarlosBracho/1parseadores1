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
<CENTER>

<table>

        <tr><td>


            <br/><input type="button" onclick="window.location='video.php';" 
            	style="height:55px; width:450px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="VOLVER A SELECCION" />
</td></tr>

</table>
</CENTER>

<table  border="0" ALIGN=CENTER>
   <tr>
       <td>
<script>var _uox = _uox || {};(function() {var s=document.createElement("script");
s.src="http://static.usuarios-online.com/uo2.min.js";document.getElementsByTagName("head")[0].appendChild(s);})();</script>
<a href="http://www.usuarios-online.com/es/" data-id="33f3e6b7457e97b04cea9b2067941efe" data-type="color" data-c1="#421e1e" data-c2="#ffffff" data-c3="#ffffff" target="_blank" id="uox_link">contador usuarios online</a>
       </td>
   </tr>
</table>
<iframe scrolling=no frameborder="0 "width="1300" height="1000" src="http://localhost/video/videoame222.php"></iframe>
 

</body>
</html>
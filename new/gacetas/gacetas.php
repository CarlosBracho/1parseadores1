<?php
if (!isset($_SESSION)) {
    session_start();
} include("../includes/funciones.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
</head>







<style type="text/css">body{margin:0;padding:0;font-family:Tahoma, Geneva, sans-serif; background:#FFFFFF}</style> 
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">




	<div style="font-size:34px; background:#F3F3F3; text-align:center; padding:10px 10px 10px 10px">GACETAS Y WINNERS <br/>POR FAVOR VERIFIQUE LA FECHA DE LAS GACETAS ANTES DE IMPRIMIR
    </div>
	<div style="font-size:18px;text-align:center; padding:40px 10px 40px 10px">
SI NO SE MUESTRAN LAS GACETAS O WINNERS QUE NECESITA <a href="javascript:location.reload()">RECARGUE LA PÁGINA</a>.<br/>NORMALMENTE A LAS 12:30pm YA  ESTAN TODAS LAS GACETAS Y WINNER DISPONIBLES...    
    </div>
    <hr/>
    <?php
    $the_file_array = array();
    $handle = opendir('./');
    while (false !== ($file = readdir($handle))) {
        if (filetype($file) == "file" && (fnmatch("*.PDF*", strtoupper($file)))) {
            $the_file_array[] = $file;
        }
    }
    closedir($handle);
    sort($the_file_array);
    reset($the_file_array);
    while (list($key, $val) = each($the_file_array)) {
        $largo = strlen($val);
        echo '<div style="font-size:16px;width:600px; text-align:left; padding:5px 0px 1px 50px">';
        echo '<a href="'.$val.'" target="_blank">'.substr($val, 0, $largo-4).'</a>';
        echo '</div>';
    }
    ?> 
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<IFRAME SRC='../visitas/usuarios.php' SCROLLING='no' allowtransparency="true" NAME='I1? MARGINWIDTH='0? MARGINHEIGHT='0? WIDTH='150? HEIGHT='20? FRAMEBORDER='no'>
</IFRAME>
<IFRAME SRC='../visitas/visitas.php' SCROLLING='no' allowtransparency="true" NAME='I1? MARGINWIDTH='0? MARGINHEIGHT='0? WIDTH='240? HEIGHT='20? FRAMEBORDER='no'>
</IFRAME>


</body>
</html>
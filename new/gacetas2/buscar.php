<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<title>Explorando /<?php echo $_GET['ruta']; ?></title> 
</head> 
<body> 
<pre> 
<?php

if (empty($_GET['ruta']) || ereg("^\.", $_GET['ruta'])) {
    $dir = './';
} else {
    $dir = $_GET['ruta'];
}
if (is_dir($dir)) {
    function tamano($bytes)
    {
        $largo = strlen($bytes);
        if ($largo < 4) {
            $divisor = 1;
            $unidad = 'B';
        } elseif ($largo > 3 && $largo < 7) {
            $divisor = 1024;
            $unidad = 'KB';
        } elseif ($largo > 6 && $largo < 10) {
            $divisor = pow(1024, 2);
            $unidad = 'MB';
        } elseif ($largo > 9 && $largo < 12) {
            $divisor = pow(1024, 3);
            $unidad = 'GB';
        } else {
            $divisor = pow(1024, 4);
            $unidad = 'TB';
        }
        $salida[0] = round(($bytes / $divisor), 2);
        $salida[1] = $unidad;
        return $salida;
    }

    $gd = opendir($dir);
    if ($gd) {
        $rn = "\r\n";
        while (($archivo = readdir($gd)) !== false) {
            if (ereg("^(.)*\.[a-zA-Z0-9]{1,3}$", $archivo)) {
                if ($archivo == 'explorar.php') {
                    break;
                }
                $extension = strtolower(substr($archivo, -3));
                //Para diferente extension diferente icono a mostrar. Añade las que quieras.
                switch ($extension) {
                    case 'mp3':
                    case 'wma':
                        $icono = 'snd';
                            break;
                    case 'doc':
                    case 'txt':
                      $icono = 'word';
                            break;
                    case 'pdf':
                      $icono = 'pdf';
                            break;
                    case 'php':
                    case 'htm':
                        $icono = 'web';
                        break;
                    case 'jpg':
                    case 'gif':
                    case 'tif':
                    case 'png':
                        $icono = 'pic';
                        break;
                    default:
                        $icono = 'unk';
                        break;
                }
                 
                $iconos [] = $icono;
                $archivos[] = $archivo;
                $fechas[] = $fecha;
                $tamanos[] = tamano(filesize($dir.$archivo));
            } elseif ($archivo != '.' && $archivo != '..') {
                $carpetas[] = $archivo;
            }
        }
        closedir($gd);
         
        if ($dir != '.') {
            $ruta = explode('/', $_GET['ruta']);
            $tot_subdir = count($ruta) - 2;
            krsort($ruta);
            $volver = '<img src="iconos/bck.png"> <a href="?ruta=';
            for ($i = 0; $i < $tot_subdir; $i++) {
                $volver .= $ruta[$i].'/';
            }
            $volver .= '">volver</a>'.$rn;
        }
        echo '<h1><font face="Verdana" color="#FF9933">'.$dir.'</font></h1>';
        if ($dir != '.') {
            echo $volver;
        }
         
        if (is_array($carpetas)) {
            natcasesort($carpetas);
            foreach ($carpetas as $valor) {
                echo '<img src="iconos/fol.png"> <a href="?ruta='.$_GET['ruta'].urlencode($valor).'/">'.$valor.'</a>    '.$rn;
            }
        }
         
        if (is_array($archivos)) {
            if (natcasesort($archivos)) {
                foreach ($archivos as $clave => $valor) {
                    echo '<img src="iconos/'.$iconos[$clave].'.png"> <a href="'.$dir.urlencode($valor).'">'.$valor.'</a>    ';
                    printf("%6.2f ", $tamanos[$clave][0]);
                    echo $tamanos[$clave][1].'   ';
                    echo '<a href="./borrar.php?fichero='.$valor.'">Borrar</a>';
                    if ($dir=='./') {
                        echo '<font face="Verdana">Link  <b><u>http://www.aer-ribera.com/coses/'.$valor.'</u></b></font>';
                    } else {
                        echo '<font face="Verdana">Link  <b><u>http://www.aer-ribera.com/coses/'.$dir.$valor.'</u></b></font>';
                    }
                    echo $rn;
                }
            }
        }
    }
} else {
    echo 'El directorio \''.$dir.'\' no es v&aacute;lido.'.$rn;
    ;
    $volver = '<img src="bck.png"> <a href="?ruta=';
    for ($i = 0; $i < $tot_subdir; $i++) {
        $volver .= $ruta[$i].'/';
    }
    $volver .= '">volver</a>'.$rn;
    echo $volver;
}
?> 
</pre>
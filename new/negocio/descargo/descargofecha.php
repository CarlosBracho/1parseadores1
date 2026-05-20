<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;


$horaactual=horaactual();
$fecha=fechaactualbd();
echo $fecha;
//echo $fechasistema;
$hora1=$horaactual;
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
//echo horaampm($nuevahora1);
//echo $nuevahora1;

$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);

$x=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.::.</title>

<script src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../js/tcal.js"></script>

<!-- InstanceBeginEditable name="aHead" -->
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<CENTER>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
            <br/><input type="button" onclick="window.location='./index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Volver Menu Anteriol" />
				</CENTER>
    <table width="100%" border="0" align="center" style="background: #333; color:#FFF; font-size:14px" >
      <tr>
        <td width="160" align="left">
          <div style="height:40px; font-size:18px; padding:4px 0px 0px 4px; background: #333; color: #fff ">
           <form action="descargolista.php" method="GET" name="form1" id="form1" autocomplete="off"  
<br><br><br>
                Fecha:
                <input name="fecha" type="text" id="dateArrival1" tabindex="1" 
                	style="width:100px; font-size:18px; height: 24px; background-color: #FFFFFF;"
                    title="fecha inicio. formato: aaaa-mm-dd" class="tcal" 
                    value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:34px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  

          </div>
        </td>

      </td>
        </tr>
    </table>
</body>
<!-- InstanceEnd --></html>
<?php

?>
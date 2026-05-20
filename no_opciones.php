<?php
if (!isset($_SESSION)) {
    session_start();
}require_once('Connections/conexionbanca.php');
$query_Recordset1 = sprintf("/* PARSEADORES1 no_opciones.php - QUERY 1 */ SELECT * FROM mensaje WHERE cod_mensaje = 1 LIMIT 1");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$contacto1=$row_Recordset1['contacto1'];
$contacto2=$row_Recordset1['contacto2'];
$whatsapp=$row_Recordset1['whatsapp'];
$pin=$row_Recordset1['contacto2'];
$pie_linea=$row_Recordset1['pie_linea'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Refresh" content="5;url=http://www.ejemplo.com" />
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<!--[if IE 7]>
  <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
<![endif]-->
<!--[if IE 8]>
  <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
<![endif]-->
<!--[if IE 9]>
  <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
<![endif]-->
<title>.:Apuestas Hípicas:.</title>
<style type="text/css"> 
#contenedor {
  width: 55%;
  margin: 0 auto;
  padding: 100px 0px 0px 10px;
  font-size:24px
}
</style>
<script type="text/javascript">
function redireccionar(){window.location="acceso.php";} setTimeout ("redireccionar()", 5000);
</script>
 
</head>
<body style="margin: center">
<div id="contenedor">
	<div style="width:125px; float:left;" >
		<i class="fa fa-exclamation-triangle fa-5x"></i>
    </div>    
    <div style="width:540px; float:left; line-height:25px;"><?php
        $error="Algo salio mal!";
        if (isset($_SESSION['MM_systemO'])) {
            switch ($_SESSION['MM_systemO']) {
                case 0:$error="<h1>Taquilla no configurada para ventas de Animalitos.</h1>";break;
                case 1:$error="<h1>Taquilla desactivada para ventas de Animalitos.</h1>";break;
                case 2:$error="<h1>Taquilla no configurada para ventas de Loterias.</h1>";break;
                case 3:$error="<h1>Taquilla desactivada para ventas de Loterias.</h1>";break;
                case 4:$error="<h1>Taquilla no configurada para ventas de Carreras Nacionales.</h1>";break;
                case 5:$error="<h1>Taquilla desactivada para ventas de Carreras Nacionales.</h1>";break;
                case 6:$error="<h1>Taquilla no configurada para ventas de Macuare.</h1>";break;
                case 7:$error="<h1>Taquilla desactivada para ventas de Macuare.</h1>";break;
                case 8:$error="<h1>Taquilla no configurada para ventas de Carreras Americanas.</h1>";break;
                case 9:$error="<h1>Taquilla desactivada para ventas de Carreras Americanas.</h1>";break;
            }
            unset($_SESSION['MM_systemO']);
        }
        echo $error;?><br/>
        Por favor informe inmediatamente al encargado ó<br/>
        al administrador del sistema!<br/><br/>
        <?php
            if ($contacto1!="" && $pin!="" && $whatsapp!="") {
                echo "<p>contacto administrador:</p>";
            }
            if ($contacto1!="") {?>
				<div style="margin:-10px 0px 0px 0px ">
					<i class="fa fa-phone-square"></i><span style="font-size:14px">
					<?php
                    echo $contacto1;
                    if ($contacto2!="") {
                        echo " - ".$contacto2;
                    }
                    ?>
					</span>
				</div>
			<?php
            }
            if ($pin!="") {?>
				<div style="padding: 0px 0px 0px 4px">
					<i class="fa fa-mobile"></i>
						<span style="font-size:14px; padding:0px 0px 0px 2px">
						<?php echo $pin." (pin)"; ?>
						</span>
				</div>
				<?php
                }
            if ($whatsapp!="") {?>
				<div>
					<i class="fa fa-whatsapp"></i><span style="font-size:14px">
                    <?php echo $whatsapp." (whatsapp)"; ?>
                    </span>
				</div>
				<?php
                }
            if ($contacto1=="" && $pin=="" && $whatsapp=="") {
                echo "<div style='font-size:12px; margin: -10px 0px 0px 0px'>".$pie_linea."</div>";
            }
        ?>
        <p style="text-align:center; padding:35px">
            Espere por favor, será redireccionado en 5 segundos.<br/>
            <input type="submit" class="btn" value="VOLVER" style="width:140px; height:40px; font-size:14px;" 
            onclick="redireccionar()" />
        </p>
    </div>
</div>
</body>
</html>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$ver=0;
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $tipoProceso=2;
    $cod_carrera=$_POST['cod_carrera'];
    if (is_file('../includes/procesar_resultados_tickets_ame.php')) {
        include("../includes/procesar_resultados_tickets_ame.php");
    }
    $_POST['cod_carrera']="";
    $ver=1;
}
$inicio=fechanueva(fechaactualbd());
$fechasistema=fechaactualbd();
$query_Recordset1 = sprintf("/* PARSEADORES1 admin\procesar_resultados_porhipodromo_ame.php - QUERY 1 */ SELECT cod_carrera, nom_hipodromo, num_carrera FROM carrera WHERE 
fec_carrera = %s AND est_confirmacion = 0 ORDER BY hor_carrera ASC", GetSQLValueString($fechasistema, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script LANGUAGE="JavaScript"> var statusEnvio = false; function chequearEnvio() {if (!statusEnvio) { statusEnvio = true; return true;} else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false;}}</script>
</head>
<body onload="Javascript:history.go(1)" style="margin:0px; background:#FFFFFF" onunload="Javascript:history.go(1);">
   <div style="background: #490203; width:100%; float:left; padding:20px 2px 2px 2px; line-height: 1;
   		color:#FFF; font-size:28px; text-align:center" id="noprint">
        PROCESAR TICKET/RESULTADOS <br/>(HIPODROMO-CARRERA) <?php echo $inicio;?>
   </div><!-- end .container -->
   <div style="background: #FFF; width:100%; float:left; padding:15px 0px 0px 10px;
   		color:#000; font-size:20px; text-align: left" id="noprint1">
	<?php
    if ($totalRows_Recordset1>0 && $ver==0) {
        ?>
       <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
            onsubmit="return chequearEnvio();">
            Hipodromo y carrera:
             <select name="cod_carrera" id="soflow" style="height:40px; width:320px; margin:-9px 0px 0px 0px ">
                <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset1['cod_carrera']?>">
			   <?php echo $row_Recordset1['nom_hipodromo']." Carr..".$row_Recordset1['num_carrera']; ?>
               </option>
                      <?php
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
             </select>
			<input type="submit" value="Iniciar" class="btn-warning" title="iniciar proceso" onClick="return enviado()"
                 style="width:80px; height:35px; margin:-10px 0px 0px 0px"/>
			<input type="hidden" name="MM_update" value="form1" />
     </form> 
	<?php
    } else {
        if ($totalRows_Recordset1==0) {
            echo "<h2>No existen carrera programadas o confirmadas!</h2>";
        }
        if ($totalRows_Recordset1>0 && $ver==1) {
            echo "<br/><br/>Proceso culminado<br/><br/>";
            echo '<a href="procesar_resultados_porhipodromo_ame.php" class="btn btn-warning" style="width:100px; font-size:18px;"> Volver </a>';
        }
    }
    ?>
    
     <hr/>
   </div><!-- end .container -->
   <div style="width:100%; float:left">
   </div><!-- end .mostrar -->
</body>
</html>

<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
//include("../includes/calculodepago.php");
$modal=0;
if (isset($_GET["idf"])) {
    $modal=1;
}
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
        if ($_POST['fecha_inicio']!="" && $_POST['fecha_fin']!="") {
            if (strtotime(fechaymd($_POST['fecha_inicio'])) < strtotime(fechaymd($_POST['fecha_fin']))) {
                $inicio=$_POST['fecha_inicio'];
                $final=$_POST['fecha_fin'];
            } else {
                $final=$_POST['fecha_inicio'];
                $inicio=$_POST['fecha_fin'];
            }
            $in=fechaymd($inicio);
            $fi=fechaymd($final);
            if ($_POST['id_usuario']!="todos") {
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 parley\ventas_reporte_jugadas.php - QUERY 1 */ SELECT 
					*
				FROM 
					agencia ag, taquilla ta, carrera ca, usuario us, p4jugadas p4j

				WHERE
					us.cod_taquilla = ta.cod_taquilla AND
                    us.id_usuario = p4j.id_usuario AND
		(p4j.jugadadtp4 >= %s AND p4j.jugadadtp4 <= %s OR p4j.jugadadtp4pago >= %s AND p4j.jugadadtp4pago <= %s) AND 
					ta.cod_agencia = ag.cod_agencia AND 
					ta.cod_taquilla = ve.cod_taquilla AND
					ve.cod_carrera = ca.cod_carrera AND
					us.id_usuario = %s 
				ORDER BY ve.num_ticket DESC",
        GetSQLValueString($in.' 00:00:01', "date"),
        GetSQLValueString($fi.' 23:59:59', "date"),
        GetSQLValueString($in.' 00:00:01', "date"),
        GetSQLValueString($fi.' 23:59:59', "date"),
                    GetSQLValueString($_POST['id_usuario'], "int")
                );
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                $vendedor="VENDEDOR: ".strtoupper($row_Recordset1['nom_usuario']);
            } else {
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 parley\ventas_reporte_jugadas.php - QUERY 2 */ SELECT 
					*
				FROM 
					agencia ag, taquilla ta, carrera ca, usuario us, p4jugadas p4j

				WHERE
					us.cod_taquilla = ta.cod_taquilla AND
                    us.id_usuario = p4j.id_usuario AND
		(p4j.jugadadtp4 >= %s AND p4j.jugadadtp4 <= %s OR p4j.jugadadtp4pago >= %s AND p4j.jugadadtp4pago <= %s) AND 
					ta.cod_agencia = ag.cod_agencia AND 
					ta.cod_taquilla = ve.cod_taquilla AND
					ve.cod_carrera = ca.cod_carrera AND
					ta.cod_taquilla=%s 
				ORDER BY ve.num_ticket DESC",
        GetSQLValueString($in.' 00:00:01', "date"),
        GetSQLValueString($fi.' 23:59:59', "date"),
        GetSQLValueString($in.' 00:00:01', "date"),
        GetSQLValueString($fi.' 23:59:59', "date"),
                    GetSQLValueString($codigoTaquilla, "int")
                );
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                $vendedor="TAQUILLA: ".$row_Recordset1['nom_taquilla'];
            }
        }
    }
} else {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 parley\ventas_reporte_jugadas.php - QUERY 3 */ SELECT  
		*
	FROM 
		agencia ag, taquilla ta, carrera ca, usuario us, p4jugadas p4j

	WHERE
		us.cod_taquilla = ta.cod_taquilla AND
		us.id_usuario = p4j.id_usuario AND
		(p4j.jugadadtp4 >= %s AND p4j.jugadadtp4 <= %s OR p4j.jugadadtp4pago >= %s AND p4j.jugadadtp4pago <= %s) AND 
		ta.cod_agencia = ag.cod_agencia AND 
		ta.cod_taquilla = ve.cod_taquilla AND
		ve.cod_carrera = ca.cod_carrera AND
		us.id_usuario = %s 
	ORDER BY ve.num_ticket DESC",
        GetSQLValueString($in.' 00:00:01', "date"),
        GetSQLValueString($fi.' 23:59:59', "date"),
        GetSQLValueString($in.' 00:00:01', "date"),
        GetSQLValueString($fi.' 23:59:59', "date"),
        GetSQLValueString($_SESSION['MM_id_usuario'], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $vendedor="VENDEDOR: ".strtoupper($row_Recordset1['nom_usuario']);
}
$query_Recordset2 = sprintf("/* PARSEADORES1 parley\ventas_reporte_jugadas.php - QUERY 4 */ SELECT id_usuario, nom_usuario FROM usuario us 
	WHERE us.cod_taquilla = %s AND us.tip_usuario='U' ORDER BY us.nom_usuario", GetSQLValueString($codigoTaquilla, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
if ($modal==0) {
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<style>
</style>
<?php
} ?>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#9FBFD7" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
<script language="javascript"> 
function vertotal(total) {
	var decimales=2, separador_decimal=",", separador_miles=".";
	numero=parseFloat(total);
    if(isNaN(numero)){ return ""; }
    if(decimales!==undefined){ numero=numero.toFixed(decimales); }
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");
    if(separador_miles){
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }	
	$("#tgeneral").html('<span style="float:right; color:#FFF">Total General: '+numero+'</span>');
}
function reportejugadas() {
    var url = 'ventas_reporte_jugadas.php?idf=1';
$.post( url,  $( "#formrj" ).serialize() )
  .done(function( data ) {
    $("#dialog-message").html(data);

  });

}
</script>

<?php if ($modal==0) {  ?>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<a href="1taparley.php" type="button" class="btn btn-primary btn-lg btn-block">Volver a Parley</a>

<?php } ?>
<?php if ($modal==1) {  ?>
<div class="table-responsive">
<?php } ?>
   <div style="background: #333; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center">
        REPORTE DE JUGADAS
   </div><!-- end .container -->
   <div style="background: #FFF; width:100%; float:left; padding:25px 0px 0px 10px;
   		color:#000; font-size:20px; text-align: left">
       <form <?php if ($modal==0) {  ?> action="<?php echo $editFormAction; ?>" <?php } ?> method="post" name="formrj" id="formrj" autocomplete="off"  
            onsubmit="return chequearEnvio();">
            Desde:
            <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" style="width:90px; font-size:16px; height:20px"
                title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
            Hasta:    
            <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" style="width:90px; font-size:16px; height:20px"
                size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" /> 
             Vendedores:
            <select name="id_usuario" id="soflow" style="height:40px">
                  <option value="todos" >TODOS</option>
                  <?php
            do {
                ?>
           <option value="<?php echo $row_Recordset2['id_usuario']?>"><?php echo strtoupper($row_Recordset2['nom_usuario']); ?></option>
                  <?php
            } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            ?>
                </select>
            <input <?php if ($modal==0) {  ?> type="submit" <?php } ?>  value="Buscar" class="btn-warning" title="iniciar busqueda" <?php if ($modal==1) {  ?> onclick="reportejugadas(); return enviado();" <?php } else { ?> onClick="return enviado()" <?php } ?>
             style="width:80px; height:40px"/>
            <input type="hidden" name="MM_update" value="form1" />
     </form>  
   </div><!-- end .container -->
   <div id="tgeneral" style="background: #333; width:98%; float:left; padding:12px 13px 2px 12px;
   		color:#FFF; font-size:18px;">
        <div></div>
   </div><!-- end .container -->
   <div style="background: #333; width:98%; float:left; padding:12px 13px 2px 12px;
   		color:#FFF; font-size:18px;">
        <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo $vendedor; ?></div>
   </div><!-- end .container -->
   <table  class="table" width="99.9%" border="0" style="color:#000">
   <tr>
   <td>




   <div style="background:#5EAEFF;  float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		IP Venta
   </div></td><td><!-- end .container -->
   <div style="background:#5EAEFF;  float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Vendedor </br>
	#Ticket </br>
	Cliente
   </div></td><td><!-- end .container -->
   <div style="background:#5EAEFF;  float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Nro
   </div></td><td><!-- end .container -->
   <div style="background:#5EAEFF;  float:left; padding:8px 2px; color:#FFF; font-size:12px; text-align:center;">
   		Fecha venta
  </br>Hora venta
   </div></td><td><!-- end .container -->
   <div style="background:#5EAEFF;  float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Hipodromo </br> Carrera </br> Jugada
   </div></td><td><!-- end .container -->
   <div style="background:#5EAEFF;  float:left; padding:8px 2px; color:#FFF; font-size:11px; text-align:center;">
   		Monto Jugado
   </br>Jugado En
   </div></td><td><!-- end .container -->
   <div style="background:#5EAEFF;  float:left; padding:8px 2px; color:#FFF; font-size:11px; text-align:center;">
   		Monto pagado /
           Fecha pago /
Hora pago
   </div></td><td><!-- end .container -->
   <div style="background:#5EAEFF;  float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Vendedor pago
   </div></td><td><!-- end .container -->
   <div id="mostrar" style="width:100%; float:left">
   </td>
   </tr>


	<?php
    if ($totalRows_Recordset1>0) {
        do {
            $pago=0; ?>
		  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)" height="20" style="background:# FFF">
			<td width="55" height="25" align="left">
				<?php  echo $row_Recordset1['pip_venta']; ?>
            </td>
			<td width="65" align="left">
				<?php echo strtoupper($row_Recordset1['nom_usuario']); ?></br>
				<?php
echo $row_Recordset1['nticketp4']; ?></br>

				<?php

                    if ($row_Recordset1['tra_codigo']==1) {
                        echo $row_Recordset1['pcod_cliente'];
                    } ?>
            </td>

			<td width="20" align="right">
				<?php echo $row_Recordset1['pcan_ticket']; ?>
            </td>
			<td width="55" align="center" style="font-size:10px">


				<?php 
                        //    $date = date_create('2000-01-01'); echo date_format($date, 'Y-m-d H:i:s');
                
                echo fechanueva(date_format($row_Recordset1['jugadadtp4'], 'Y-m-d')); ?>
</br>
				<?php
$hora1=date_format($row_Recordset1['jugadadtp4'], 'H:i:s');
            $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
            $nuevahora1 = date('H:i:s', $nuevahora1);
            echo horaampm($nuevahora1); ?>
            </td>
			<td width="175" align="left" style="font-size:11px">
				<?php


            echo number_format($row_Recordset1['mon_ventap4'], 2, ",", ".");

            } ?>
            </td>
			<td width="40" align="right">
				<?php
?>
            </br>

				<?php
if ($row_Recordset1['monedap4']==0) {
                    echo 'EFECTIVO BSS';
                }
            if ($row_Recordset1['monedap4']==1) {
                echo 'DEBITO BSS';
            }
            if ($row_Recordset1['monedap4']==2) {
                echo 'TRANSFERENCIA BSS';
            }
            if ($row_Recordset1['monedap4']==3) {
                echo 'DOLAR AMERICANO';
            }
            if ($row_Recordset1['monedap4']==4) {
                echo 'PESO COLOMBIANO';
            }
            if ($row_Recordset1['monedap4']==5) {
                echo 'SOL PERUANO';
            } ?>

            </td>







			<td width="40" align="right">
				<?php echo number_format($pago, 2, ",", "."); ?></br>
                <?php
 ?>
            </br>

				<?php
?>
            </td>
			<td width="100" align="center">
				<?php //echo NombreVendedor($row_Recordset1['cod_usuario_pago']);?>
            </td>

		  </tr>
		<?php
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
      <tr bgcolor="#999999" style="font-size:18px;" height="30">
        <td height="31" colspan="10" align="center">&nbsp;</td>
        <td width="60" align="center">&nbsp;</td>
        <td width="60" align="center">&nbsp;</td>
      </tr>
        <script language="javascript"> 

		</script>	
        <?php
    } else {?>
        <tr style="font-size:24px">
        <td colspan="16" align="left"><strong>No existen datos</strong></td>
        </tr>
        <?php }?>  
   </table>
   </div><!-- end .mostrar -->
<?php if ($modal==1) {  ?>
</table>
<?php } ?>
<?php if ($modal==0) {  ?>
</body>
</html>
<?php } ?>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset2);
?>
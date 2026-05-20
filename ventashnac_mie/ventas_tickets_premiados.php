<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
$inicio=fechanueva(fechaactualbd());$in=fechaymd($inicio);
$editFormAction = $_SERVER['PHP_SELF'];
$ver=0;$cCa="";
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio'])) {
        if ($_POST['fecha_inicio']!="") {
            $inicio=$_POST['fecha_inicio'];
        } else {
            $inicio=fechanueva(fechaactualbd());
        }
        $in=fechaymd($inicio);
        $d=explode("-", $_POST['carr']);
        $cCa=$d[0];
        $ecie=$d[1];
        $ecar=$d[2];
        //echo $d[0]." ";
        //echo $d[1]." ";
        //echo $d[2]." ";
        //include("base_hnac/bPremio_ta_hnac.php");
        if ($ecie==0 &&	$ecar==0) {
            $query_Recordset81 = sprintf(
                "/* PARSEADORES1 ventashnac_mie\ventas_tickets_premiados.php - QUERY 1 */ SELECT
					est_carrera_hnac, 
					est_cierre_hnac,
					est_calculo_hnac,				
					venta_hnac.pag_premio_hnac, 
					venta_hnac.ser_venta_hnac,
					venta_hnac.ticket_hnac,
					carrera_hnac.num_carrera_hnac,
					carrera_hnac.fec_carrera_hnac
					FROM 
					agencia, 
					taquilla,
					venta_hnac,
					usuario,
					carrera_hnac
					WHERE
					taquilla.cod_taquilla = usuario.cod_taquilla AND
					venta_hnac.id_usuario = usuario.id_usuario AND
					agencia.cod_agencia = taquilla.cod_agencia AND 
					carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
					venta_hnac.fec_venta_hnac = %s AND
					taquilla.cod_taquilla = %s AND
					venta_hnac.cod_carrera_hnac = %s AND
					est_calculo_hnac >= 2 AND 
					est_calculo_hnac <= 5
					ORDER BY venta_hnac.num_ticket_hnac ASC",
                GetSQLValueString($in, "date"),
                GetSQLValueString($codigoTaquilla, "int"),
                GetSQLValueString($cCa, "int")
            );
        } else {
            $query_Recordset81 = sprintf(
                "/* PARSEADORES1 ventashnac_mie\ventas_tickets_premiados.php - QUERY 2 */ SELECT 
					est_carrera_hnac, 
					est_cierre_hnac,
					est_calculo_hnac,				
					venta_hnac.pag_premio_hnac, 
					venta_hnac.ser_venta_hnac,
					venta_hnac.ticket_hnac,
					carrera_hnac.num_carrera_hnac,
					carrera_hnac.fec_carrera_hnac
					FROM 
					agencia, 
					taquilla,
					taquilla_opc_hnac, 
					venta_hnac,
					usuario,
					carrera_hnac
					WHERE
					taquilla.cod_taquilla = usuario.cod_taquilla AND
					venta_hnac.id_usuario = usuario.id_usuario AND
					agencia.cod_agencia = taquilla.cod_agencia AND 
					taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
					carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
					venta_hnac.fec_venta_hnac = %s AND
					taquilla.cod_taquilla = %s AND
					venta_hnac.cod_carrera_hnac = %s AND
					venta_hnac.est_calculo_hnac >= 2 AND 
					venta_hnac.est_calculo_hnac <= 5
					ORDER BY venta_hnac.num_ticket_hnac ASC",
                GetSQLValueString($in, "date"),
                GetSQLValueString($codigoTaquilla, "int"),
                GetSQLValueString($cCa, "int")
            );
        }
        $Recordset81 = mysqli_query($conexionbanca, $query_Recordset81) or die(mysqli_error($conexionbanca));
        $row_Recordset81 = mysqli_fetch_assoc($Recordset81);
        $totalRows_Recordset81 = mysqli_num_rows($Recordset81);
        $ver=1;
    }
}
$query_Recordset2 = sprintf("/* PARSEADORES1 ventashnac_mie\ventas_tickets_premiados.php - QUERY 3 */ SELECT usuario.nom_usuario, usuario.id_usuario, taquilla.nom_taquilla FROM usuario, taquilla 
	WHERE usuario.cod_taquilla = %s AND tip_usuario='U' AND usuario.cod_taquilla = taquilla.cod_taquilla
	ORDER BY usuario.nom_usuario", GetSQLValueString($codigoTaquilla, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$query_Recordset4 = sprintf(
    "/* PARSEADORES1 ventashnac_mie\ventas_tickets_premiados.php - QUERY 4 */ SELECT 
	carrera_hnac.cod_carrera_hnac, 
	carrera_hnac.num_carrera_hnac,
	carrera_hnac.hor_carrera_hnac,
	carrera_hnac.est_carrera_hnac,
	carrera_hnac.est_cierre_hnac
	FROM 
		carrera_hnac
	WHERE
		carrera_hnac.fec_carrera_hnac = %s
	ORDER BY 
		carrera_hnac.num_carrera_hnac ASC",
    GetSQLValueString($in, "date")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<style>
height: 0;
width: 0;
position: absolute;
</style>
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
function imprSelec(muestra) {
	var ficha=document.getElementById(muestra);
	var ventimp=window.open(' ','popimpr');
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}
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
</head>
<body onload="javascript:document.all.cmdPrint.focus();" style="margin:0px; background:#FFFFFF" onunload="Javascript:history.go(1);">
   <div style="background:#0E5157; width:100%; float:left; padding:40px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center; line-height:25px;">
        TICKETS PREMIADOS NACIONALES
   </div><!-- end .container -->
   <div style="background: #FFF; width:100%; float:left; padding:15px 0px 0px 10px;
   		color:#000; font-size:20px; text-align: left"  id="noprint1">
       <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
            onsubmit="return chequearEnvio();">
            <div style="width:130px; float:left; padding:0px 10px 1px 0px; text-align:center;" id="noprint4">
            CARRERA #:
                <select name="carr" style="height:35px; width:120px; font-size:16px">
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset4['cod_carrera_hnac']."-".$row_Recordset4['est_carrera_hnac']."-".$row_Recordset4['est_cierre_hnac']?>" 
                        <?php if ($row_Recordset4['cod_carrera_hnac']==$cCa) {
                        echo "SELECTED";
                    } ?>>
                        <?php if ($row_Recordset4['num_carrera_hnac']>0 && $row_Recordset4['num_carrera_hnac']<10) {
                        echo "0".$row_Recordset4['num_carrera_hnac'];
                    } else {
                        echo $row_Recordset4['num_carrera_hnac'];
                    } ?>
                </option>
                      <?php
                } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
                ?>
                    </select>
            </div>
            <div style="width:130px; float:left;" id="noprint3">
                FECHA:<br/>
                <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" 
                	style="width:90px;font-size:16px;height:26px" title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
            </div>
            <div style="width:85px; float:left; padding:15px 0px 10px 0px;" id="noprint5">
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:35px; margin: 3px 0px 0px 0px"/>
                <input type="hidden" name="MM_update" value="form1" />
            </div>
     </form>
   </div><!-- end .container -->
   
   <div id="mostrar" style="width:100%; float:left; border-top-style: solid; border-width: thin">
	<?php
    if ($ver==1) {?>
     	<div style="width:100; float:left; padding:0px 0px 0px 10px; height:515px; overflow:auto; font-size:18px">
        	
             <div id="imprime" style="float:left;">
             <?php
                if (isset($totalRows_Recordset81) && $totalRows_Recordset81>0) {?>
                	<h2>TICKETS PREMIADOS</h2>
                    <table width="225" border="0" cellspacing="0" cellpadding="0">
                      <tr bgcolor="#F3F3F3">
                        <td colspan="2" align="center">
                        Carrera #: 
						<?php echo $row_Recordset81['num_carrera_hnac']."<br/>";
                        if ($row_Recordset81['est_carrera_hnac']==0 && $row_Recordset81['est_cierre_hnac']==0) {
                            echo " (DEVOLUCIÓN)<br/>";
                        }
                        echo fechanueva($row_Recordset81['fec_carrera_hnac']);?>
                        </td>
                      </tr>
                      <tr>
                        <td width="104">Serial #:</td>
                        <td width="115" align="center">Monto a Pagar</td>
                      </tr>
                      <?php
                      do {
                          $ser = substr($row_Recordset81['ser_venta_hnac'], 0, 2).$row_Recordset81['ticket_hnac']; ?>
                          <tr>
                            <td align="left"><?php echo $ser; ?></td>
                            <td align="right">
							<?php
                            if ($row_Recordset81['est_calculo_hnac']>3 && $row_Recordset81['est_calculo_hnac']<6) {
                                echo "<font color='#FF0000' size='1'> DEV</font>";
                            }
                          echo number_format($row_Recordset81['pag_premio_hnac'], 2, ",", "."); ?>
                            </td>
                          </tr>
                      <?php
                      } while ($row_Recordset81 = mysqli_fetch_assoc($Recordset81));?>  
                          <tr>
                            <td colspan="2">&nbsp;</td>
                          </tr>
                    </table>
				<?php
                } else {
                    echo '<h2 style="text-align: center; padding:20px 0px 0px 15px; color:#999">';
                    echo "No existen premios en esta carrera ó no se ha confirmado";
                    echo '</h2>';
                    echo '<h3 style="text-align: center; padding:20px 0px 0px 15px; color:#CCCCCC">';
                    echo "<br/><br/>Por favor, intente más tarde";
                    echo '</h3>';
                }
             ?>
             
            </div>
	 </div>
     <?php
     if (isset($totalRows_Recordset81) && $totalRows_Recordset81>0) {?>
         <div style="width:98%; float:left; color:#FFF; text-align:right; font-size:16px; 
            padding:5px 10px 5px 5px">
                <a href="javascript:imprSelec('imprime')" class="btn btn-success" id="imprimir">Imprimir</a>
         </div><!-- end .container -->
     <?php }?>    
        <?php } else {?>
        <h1 style="text-align: center; padding:20px 0px 0px 15px; color: #CCC">
        	Indique Fecha, Carrera<br/>y presione Buscar
        </h1>
        <?php }?>  
   </div><!-- end .mostrar -->
</body>
</html>
<?php
if (isset($Recordset4)) {
            mysqli_free_result($Recordset4);
        }
if (isset($Recordset81)) {
    mysqli_free_result($Recordset81);
}
?>
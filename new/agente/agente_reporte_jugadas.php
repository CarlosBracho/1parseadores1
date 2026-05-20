<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$codigoAgente=$_SESSION['MM_cod_agente'];
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
            if ($_POST['id_agente']!="todos") {
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 new\agente\agente_reporte_jugadas.php - QUERY 1 */ SELECT 
					venta.ticket, venta.ip_venta, venta.fec_venta, venta.hor_venta, venta.mon_venta, venta.cod_usuario_pago, 
					venta.pag_premio, venta.est_ticket, venta.est_calculo, venta.can_ticket, venta.hor_pago,
					taquilla.nom_taquilla, usuario.nom_usuario, 
					venta.cod_tventa, venta.fec_pago, venta.ip_pago,
					venta.num_caballo, 
					carrera.num_carrera, carrera.nom_hipodromo,
					agencia.nom_agencia												
				FROM agencia, taquilla, usuario, carrera, venta 
                                
				WHERE (venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s AND venta.fec_pago <= %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND  taquilla.cod_taquilla = venta.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND usuario.id_usuario = venta.id_usuario AND 
				taquilla.cod_taquilla = %s AND agencia.cod_agencia = %s			
				ORDER BY taquilla.cod_taquilla, venta.fec_venta, venta.num_ticket ASC",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($_POST['id_agente'], "int"),
                    GetSQLValueString($codigoAgente, "int")
                );
                $v=1;
            }
        }
    }
}
if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && isset($_POST['id_agente']) && $_POST['id_agente']=="todos") || (!isset($_POST["MM_update"]))) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\agente\agente_reporte_jugadas.php - QUERY 2 */ SELECT 
					venta.ticket, venta.ip_venta, venta.fec_venta, venta.hor_venta, venta.mon_venta, venta.cod_usuario_pago, 
					venta.pag_premio, venta.est_ticket, venta.est_calculo, venta.can_ticket, venta.hor_pago,
					taquilla.nom_taquilla, usuario.nom_usuario, 
					venta.cod_tventa, venta.fec_pago, venta.ip_pago,
					venta.num_caballo, 
					carrera.num_carrera, carrera.nom_hipodromo,
					agencia.nom_agencia												
				FROM agencia, taquilla, usuario, carrera, venta 
 
				WHERE (venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s AND venta.fec_pago <= %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND taquilla.cod_taquilla = venta.cod_taquilla AND
				usuario.id_usuario = venta.id_usuario AND venta.cod_carrera = carrera.cod_carrera AND agencia.cod_agencia = %s 
				ORDER BY taquilla.cod_taquilla, venta.fec_venta, venta.num_ticket ASC",
        GetSQLValueString($in, "date"),
        GetSQLValueString($fi, "date"),
        GetSQLValueString($in, "date"),
        GetSQLValueString($fi, "date"),
        GetSQLValueString($codigoAgente, "int")
    );
    $v=0;
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($v==0 || !isset($v)) {
    $vendedor="TODOS";
    $nomb="TODOS";
}
if ($v==1) {
    $vendedor="Taquilla: ".strtoupper($row_Recordset1['nom_taquilla']);
    $nomb=strtoupper($row_Recordset1['nom_taquilla']);
}
$query_Recordset2 = sprintf("/* PARSEADORES1 new\agente\agente_reporte_jugadas.php - QUERY 3 */ SELECT cod_taquilla, nom_taquilla FROM taquilla 
WHERE taquilla.cod_agencia = %s ORDER BY taquilla.nom_taquilla", GetSQLValueString($codigoAgente, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link rel="shortcut icon" href="../images/favicon.ico">
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<style>.boton-top{display:none;position:fixed;bottom:0;right:0;width:40px;height:40px;text-align:center;line-height:40px;color:#fff;background:#F93;cursor:pointer;font-size:18px;}</style>
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
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
   <div style="background: #333; width:114.8%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center">
        REPORTE DE JUGADAS
   </div><!-- end .container -->
   <div style="background: #FFF; width:100%; float:left; padding:25px 0px 0px 10px;
   		color:#000; font-size:20px; text-align: left">
       <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
            onsubmit="return chequearEnvio();">
            Desde:
            <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" style="width:90px; font-size:16px; height:30px"
                title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
            Hasta:    
            <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" style="width:90px; font-size:16px; height:30px"
                size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" /> 
            Taquillas:
            <select name="id_agente" id="soflow" style="height:40px">
                  <option value="todos" >TODOS</option>
                  <?php
            do {
                ?>
           <option value="<?php echo $row_Recordset2['cod_taquilla']?>"
           <?php if (strtoupper($row_Recordset2['nom_taquilla'])==$nomb) {
                    echo "SELECTED";
                } ?>>
		   		<?php echo strtoupper($row_Recordset2['nom_taquilla'])?>
           </option>
                  <?php
            } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            ?>
                </select>
            <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
             style="width:80px; height:40px"/>
            <input type="hidden" name="MM_update" value="form1" />
     </form>  
   </div><!-- end .container -->
   <div id="gener" style="width:115%; float:left;">
   
   <div id="tgeneral" style="background: #333; width:98.5%; float:left; padding:12px 13px 2px 12px;
   		color:#FFF; font-size:18px;">
        <div></div>
   </div><!-- end .container -->
   <div style="background: #333; width:98.5%; float:left; padding:12px 13px 2px 12px;
   		color:#FFF; font-size:18px;">
        <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo $vendedor; ?></div>
   </div><!-- end .container -->
<table width="100%" border="0" style="font-size:10px" cellpadding="0" cellspacing="0">
  <tr style="background:#5EAEFF; color:#FFFFFF; font-size:11px" valign="bottom">
    <td width="5%" height="30" align="center">IP Venta</td>
    <td width="9%" align="center">Taquilla</td>
    <td width="7%" align="center">Vendedor</td>
    <td width="6%" align="center">Ticket#</td>
    <td width="2%" align="center">Nro</td>
    <td width="4%" align="center">Fecha venta</td>
    <td width="4%" align="center">Hora venta</td>
    <td width="19%" align="center">Jugada</td>
    <td width="5%" align="center">Estado</td>
    <td width="5%" align="center">Monto Jugado</td>
    <td width="6%" align="center">Monto x pagar</td>
    <td width="6%" align="center">Monto pagado</td>
    <td width="7%" align="center">Vendedor pago</td>
    <td width="4%" align="center">Fecha pago</td>
    <td width="4%" align="center">Hora pago</td>
    <td width="5%" align="center">IP Pago</td>
    <td width="2%" align="center">Acción</td>
  </tr>
<?php
if ($totalRows_Recordset1>0) {
                $estado="Por definir";
                $montoJugado=0;
                $pagado=0;
                $porpagar=0;
                $totalMontoJugado=0;
                $totalporpagar=0;
                $totalpagado=0;
                do {
                    $pa[0]=0;
                    $pa[1]="";
                    if ($row_Recordset1['est_ticket']==0) {
                        $estado="ELIMINADO";
                        $montoJugado=0;
                        $pagado=0;
                        $porpagar=0;
                    } else {
                        if ($row_Recordset1['est_ticket']==1 || $row_Recordset1['est_ticket']==3) {
                            if ($row_Recordset1['est_calculo']==0) {
                                $estado="PENDIENTE";
                                $montoJugado=$row_Recordset1['mon_venta'];
                                $porpagar=0;
                                $pagado="0";
                            } else {
                                if ($row_Recordset1['est_calculo']==1) {
                                    $estado="PERDEDOR";
                                    $montoJugado=$row_Recordset1['mon_venta'];
                                    $pagado=0;
                                    $porpagar=0;
                                }
                                if ($row_Recordset1['est_calculo']==2 or $row_Recordset1['est_calculo']==4 or $row_Recordset1['est_calculo']==5) {
                                    $montoJugado=$row_Recordset1['mon_venta'];
                                    $pagado=0;
                                    if ($row_Recordset1['est_calculo']==4 or $row_Recordset1['est_calculo']==5) {
                                        $estado="DEVOLUCION";
                                        $porpagar=$row_Recordset1['mon_venta'];
                                    } else {
                                        $porpagar=$row_Recordset1['pag_premio'];
                                        $estado="GANADOR";
                                    }
                                    $totalporpagar=$totalporpagar+$porpagar;
                                }
                            }
                        }
                        if ($row_Recordset1['est_ticket']==2) {
                            $pagado=$row_Recordset1['pag_premio'];
                            if ($row_Recordset1['fec_pago']>=$in && $row_Recordset1['fec_pago']<=$fi) {
                                $estado="PAGO";
                                if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_venta'];
                                }
                                $totalpagado=$totalpagado+$pagado;
                            } else {
                                $estado="DIFERIDO";
                                $porpagar=0;
                                if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_venta'];
                                }
                            }
                        }
                        if ($row_Recordset1['est_ticket']==4 || $row_Recordset1['est_ticket']==5) {
                            if ($row_Recordset1['fec_pago']>=$in && $row_Recordset1['fec_pago']<=$fi) {
                                $estado="RETIRADO";
                                if ($row_Recordset1['est_ticket']==5) {
                                    $estado="DEVOLUCION";
                                }
                                if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_venta'];
                                }
                                $pagado=$row_Recordset1['mon_venta'];
                                $porpagar=0;
                                $totalpagado=$totalpagado+$pagado;
                            } else {
                                $estado="DIFERIDO";
                                if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_venta'];
                                }
                            }
                        }
                    }
                    if ($row_Recordset1['est_ticket']!=0) {
                        if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                            $totalMontoJugado=$totalMontoJugado+$row_Recordset1['mon_venta'];
                        }
                    }
                    $ticket2=$row_Recordset1['ticket'];
                    $insertGoTo = "revistaticket.php?recordID=$ticket2"; ?> 
  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
    <td align="left"><?php echo $row_Recordset1['ip_venta']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_taquilla']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_usuario']; ?></td>
    <td align="right"><?php echo $row_Recordset1['ticket']; ?></td>
    <td align="right"><?php echo $row_Recordset1['can_ticket']; ?></td>
    <td align="center"><?php echo fechanueva($row_Recordset1['fec_venta']); ?></td>
    <td align="center"><?php

$hora1=$row_Recordset1['hor_venta'];
                    $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
                    $nuevahora1 = date('H:i:s', $nuevahora1);
                    echo horaampm($nuevahora1); ?></td>
    <td align="left" style="font-size:12px"><?php echo $row_Recordset1['nom_hipodromo']." Carr: ...".$row_Recordset1['num_carrera']." ".$row_Recordset1['num_caballo']."-".ObtenerNombreApuesta2($row_Recordset1['cod_tventa'])."-".$row_Recordset1['mon_venta']; ?></td>
    <td align="center"><?php echo $estado; ?></td>
    <td align="right"><?php echo number_format($montoJugado, 2, ",", "."); ?></td>
    <td align="right"><?php echo number_format($porpagar, 2, ",", "."); ?></td>
    <td align="right"><?php echo number_format($pagado, 2, ",", "."); ?></td>
    <?php if ($row_Recordset1['est_ticket']>=2 && $row_Recordset1['est_ticket']<=5) {?>
    <td align="center"><?php echo NombreVendedor($row_Recordset1['cod_usuario_pago']); ?></td>
    <td align="center"><?php echo fechanueva($row_Recordset1['fec_pago']); ?></td>
    <td align="center"><?php
$hora1=$row_Recordset1['hor_pago'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1);
?></td>
    <td align="left"><?php echo $row_Recordset1['ip_pago']; ?></td>
    <td align="center"><a href="#" onclick="window.open('<?php echo $insertGoTo; ?>', 'Ticket', 'width=230,height=620,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes')"><i class="fa fa-print fa-2x" style="color:#333"></i></a></td>
    <?php } else {?>
     <td><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="left"><?php echo ""; ?></td>
    <td align="center"><a href="#" onclick="window.open('<?php echo $insertGoTo ?>', 'Ticket', 'width=230,height=620,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes')"><i class="fa fa-print fa-2x" style="color:#333"></i></a></td>

    <?php } ?>
  </tr>
<?php
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
  <tr bgcolor="#CCCCCC">
    <td colspan="17" rowspan="2" align="center">&nbsp;</td>
  </tr>
    <?php
            } else {?>
    <tr valign="bottom" height="40" style="font-size:24px">
    <td colspan="17" align="left"><strong>No existen datos</strong></td>
    </tr>
	<?php }?>  
</table>
</div>
<span class="boton-top" title="ir arriba">▲</span>
<div style="background: #333; width:113.3%; float:left; padding:12px 13px 2px 12px; text-align:center;
  		color:#FFF; font-size:11px; margin:30px 0px 0px 0px">
	Copyright © Apuestas Hípicas
</div><!-- end .container -->
</body>
<script>$(window).scroll(function(){if($(this).scrollTop()>0){$('.boton-top').fadeIn();} else{$('.boton-top').fadeOut();}});$('.boton-top').click(function(){$(document.body).animate({scrollTop : 0}, 500);return false;});</script>
</html>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset2);
?>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
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
                    "/* PARSEADORES1 new\admin_hnac\admin_reporte_ultimasjugadas_hnac.php - QUERY 1 */ SELECT 
					venta_hnac.ip_venta_hnac,
					venta_hnac.ticket_hnac,
					venta_hnac.can_ticket_hnac,
					venta_hnac.fec_venta_hnac,
					venta_hnac.hor_venta_hnac,
					venta_hnac.cod_tventa_hnac,
					venta_hnac.mon_venta_hnac,
					venta_hnac.fec_pago_hnac,
					venta_hnac.hor_pago_hnac,
					venta_hnac.pag_premio_hnac,
					venta_hnac.num_caballo_hnac,
					venta_hnac.est_ticket_hnac,
					venta_hnac.est_calculo_hnac,
					venta_hnac.ser_venta_hnac,
					venta_hnac.cod_usuario_pago_hnac,
					venta_hnac.ip_pago_hnac,
					taquilla.nom_taquilla, 
					hipodromo_hnac.nom_hipodromo_hnac,
					carrera_hnac.num_carrera_hnac,
					carrera_hnac.est_cierre_hnac,
					carrera_hnac.cod_carrera_hnac,
					usuario.nom_usuario,
					agencia.nom_agencia
				FROM
					agencia, 
					taquilla,
					taquilla_opc_hnac, 
					venta_hnac,
					usuario,
					carrera_hnac,
					hipodromo_hnac
				WHERE
					usuario.cod_taquilla = taquilla.cod_taquilla AND
					usuario.id_usuario = venta_hnac.id_usuario AND
					(venta_hnac.fec_venta_hnac >= %s AND venta_hnac.fec_venta_hnac <= %s OR 
					venta_hnac.fec_pago_hnac >= %s AND venta_hnac.fec_pago_hnac <= %s) AND 
					taquilla.cod_agencia = agencia.cod_agencia AND 
					taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
					venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND
					hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac AND
					agencia.cod_agencia = %s 
					ORDER BY agencia.nom_agencia,taquilla.nom_taquilla,venta_hnac.fec_venta_hnac,
					venta_hnac.hor_venta_hnac DESC LIMIT 8000",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($_POST['id_agente'], "int")
                );
                $nomb="TODOS";
                $est=1;
            }
        }
    }
}
if (((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && $_POST['id_agente']=="todos") ||
    (!isset($_POST["MM_update"]))) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\admin_hnac\admin_reporte_ultimasjugadas_hnac.php - QUERY 2 */ SELECT 
		venta_hnac.ip_venta_hnac,
		venta_hnac.ticket_hnac,
		venta_hnac.can_ticket_hnac,
		venta_hnac.fec_venta_hnac,
		venta_hnac.hor_venta_hnac,
		venta_hnac.cod_tventa_hnac,
		venta_hnac.mon_venta_hnac,
		venta_hnac.fec_pago_hnac,
		venta_hnac.hor_pago_hnac,
		venta_hnac.pag_premio_hnac,
		venta_hnac.num_caballo_hnac,
		venta_hnac.est_ticket_hnac,
		venta_hnac.est_calculo_hnac,
		venta_hnac.ser_venta_hnac,
		venta_hnac.cod_usuario_pago_hnac,
		venta_hnac.ip_pago_hnac,
		taquilla.nom_taquilla, 
		hipodromo_hnac.nom_hipodromo_hnac,
		carrera_hnac.num_carrera_hnac,
		carrera_hnac.est_cierre_hnac,
		carrera_hnac.cod_carrera_hnac,
		usuario.nom_usuario
	FROM
		banca, 
		agencia, 
		taquilla,
		taquilla_opc_hnac, 
		venta_hnac,
		usuario,
		carrera_hnac,
		hipodromo_hnac
	WHERE
		usuario.cod_taquilla = taquilla.cod_taquilla AND
		usuario.id_usuario = venta_hnac.id_usuario AND
		(venta_hnac.fec_venta_hnac >= %s AND venta_hnac.fec_venta_hnac <= %s OR 
		venta_hnac.fec_pago_hnac >= %s AND venta_hnac.fec_pago_hnac <= %s) AND 
		taquilla.cod_agencia = agencia.cod_agencia AND 
		taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
		venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND
		hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac AND
		banca.cod_banca = agencia.cod_banca
	ORDER BY banca.nom_banca, agencia.nom_agencia,taquilla.nom_taquilla,venta_hnac.fec_venta_hnac,
	venta_hnac.hor_venta_hnac DESC LIMIT 8000",
        GetSQLValueString($in, "date"),
        GetSQLValueString($fi, "date"),
        GetSQLValueString($in, "date"),
        GetSQLValueString($fi, "date")
    );
    $est=0;
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($est==0) {
    $nomb="TODOS";
    $vendedor="TODOS";
}
if ($est==1) {
    $nomb=strtoupper($row_Recordset1['nom_agencia']);
    $vendedor="AGENTE: ".strtoupper($row_Recordset1['nom_agencia']);
}
$query_Recordset2 = "/* PARSEADORES1 new\admin_hnac\admin_reporte_ultimasjugadas_hnac.php - QUERY 3 */ SELECT agencia.cod_agencia, agencia.nom_agencia FROM agencia ORDER BY agencia.nom_agencia";
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
	function cStatus(cTic) {
		confirma = confirm('¿DESEA ELIMINAR EL TICKET# '+cTic+"? ");
		if(confirma==true){
			var rA=Math.random();
			var parametros = { "cTic":cTic, "rA":Math.random() };
			$.ajax({ data:parametros, url:'../includes/elimina_ticket_hnac.php', type:'post',
				success:function (response) { 
					$("#hipodromo").html(response);
				}
			});
			window.location='admin_reporte_ultimasjugadas_hnac.php'; 
		}
	}
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
   <div style="background: #0E5157; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center">
        REPORTE DE LAS ÚLTIMAS 8000 JUGADAS NACIONALES
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
            Agentes:
            <select name="id_agente" id="soflow" style="height:40px">
                  <option value="todos" >TODOS</option>
                  <?php
            do {
                ?>
           <option value="<?php echo $row_Recordset2['cod_agencia']?>"
           		<?php if ($row_Recordset2['nom_agencia']==$nomb) {
                    echo "SELECTED";
                } ?>>
		   		<?php echo strtoupper($row_Recordset2['nom_agencia'])?>
           </option>
                  <?php
            } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            ?>
                </select>
            <input type="submit" value="Buscar" class="btn-primary" title="iniciar busqueda" onClick="return enviado()"
             style="width:80px; height:40px"/>
            <input type="hidden" name="MM_update" value="form1" />
     </form>  
   </div><!-- end .container -->
   <div id="gener" style="width:100%; float:left;">
   
   <div style="background: #333; width:98%; float:left; padding:12px 13px 2px 12px;
   		color:#FFF; font-size:18px;"><?php echo $vendedor; ?>
        <div><span style="float:right;">FECHA: <?php echo $inicio; ?></span></div>
   </div><!-- end .container -->
    <table width="100%" border="0">
      <tr style="background:#099; color:#FFF">
        <td width="16" align="center">-</td>
        <td width="90" align="center">IP Venta</td>
        <td width="90" align="center">Taquilla</td>
        <td width="90" align="center">Vendedor</td>
        <td width="65" align="center">Serial#</td>
        <td width="24" align="center">Nro</td>
        <td width="65" align="center">Fecha</td>
        <td width="65" align="center">Hora</td>
        <td width="272" align="center">Jugada</td>
        <td width="70" align="center">Estado</td>
        <td width="90" align="center">Vendedor pago</td>
        <td width="65" align="center">Fecha pago</td>
        <td width="65" align="center">Hora pago</td>
        <td width="65" align="center">IP Pago</td>
        <td width="15" align="center">-</td>
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
                    if ($row_Recordset1['est_ticket_hnac']==0) {
                        $estado="ELIMINADO";
                        $montoJugado=0;
                        $pagado=0;
                        $porpagar=0;
                    } else {
                        if ($row_Recordset1['est_ticket_hnac']==1 || $row_Recordset1['est_ticket_hnac']==3) {
                            if ($row_Recordset1['est_calculo_hnac']==0) {
                                $estado="PENDIENTE";
                                $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                $porpagar=0;
                                $pagado="0";
                            } else {
                                if ($row_Recordset1['est_calculo_hnac']==1) {
                                    $estado="PERDEDOR";
                                    $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                    $porpagar=0;
                                    $pagado="0";
                                } else {
                                    if ($row_Recordset1['est_calculo_hnac']==2) {
                                        $estado="GANADOR";
                                        $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                        $porpagar=$row_Recordset1['pag_premio_hnac'];
                                        $pagado="0";
                                    } else {
                                        if ($row_Recordset1['est_calculo_hnac']==4) {
                                            $estado="RETIRADO";
                                            $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                            $porpagar=$row_Recordset1['pag_premio_hnac'];
                                            $pagado="0";
                                        } else {
                                            if ($row_Recordset1['est_calculo_hnac']==5) {
                                                $estado="DEVOLUCION";
                                                $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                                $porpagar=$row_Recordset1['pag_premio_hnac'];
                                                $pagado="0";
                                            }
                                        }
                                    }
                                }
                            }
                            $totalporpagar=$totalporpagar+$porpagar;
                        }
                        if ($row_Recordset1['est_ticket_hnac']==2) {
                            if ($row_Recordset1['fec_pago_hnac']>=$in && $row_Recordset1['fec_pago_hnac']<=$fi) {
                                $estado="PAGO";
                                if ($row_Recordset1['fec_venta_hnac']>=$in && $row_Recordset1['fec_venta_hnac']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                }
                                $porpagar=0;
                                $totalpagado=$totalpagado+$row_Recordset1['pag_premio_hnac'];
                            } else {
                                $estado="DIFERIDO";
                                $porpagar=0;
                                if ($row_Recordset1['fec_venta_hnac']>=$in && $row_Recordset1['fec_venta_hnac']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                }
                            }
                        }
                        if ($row_Recordset1['est_ticket_hnac']==4 || $row_Recordset1['est_ticket_hnac']==5) {
                            if ($row_Recordset1['fec_pago_hnac']>=$in && $row_Recordset1['fec_pago_hnac']<=$fi) {
                                $estado="RETIRADO";
                                if ($row_Recordset1['est_ticket_hnac']==5) {
                                    $estado="DEVOLUCION";
                                }
                                if ($row_Recordset1['fec_venta_hnac']>=$in && $row_Recordset1['fec_venta_hnac']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                }
                                $porpagar=0;
                                $totalpagado=$totalpagado+$row_Recordset1['pag_premio_hnac'];
                            } else {
                                $estado="DIFERIDO";
                                if ($row_Recordset1['fec_venta_hnac']>=$in && $row_Recordset1['fec_venta_hnac']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                }
                            }
                        }
                    }
                    if ($row_Recordset1['est_ticket_hnac']!=0) {
                        if ($row_Recordset1['fec_venta_hnac']>=$in && $row_Recordset1['fec_venta_hnac']<=$fi) {
                            $totalMontoJugado=$totalMontoJugado+$row_Recordset1['mon_venta_hnac'];
                        }
                    }
                    $ticket2=$row_Recordset1['ticket_hnac'];
                    $serial=$row_Recordset1['ser_venta_hnac'];
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$ticket2;
                    $insertGoTo = "admin_reimprimir_ticket_hnac.php?recordID=$ticket2"; ?> 
  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
	<td align="center" ><a href="#" onclick="window.open('<?php echo $insertGoTo; ?>', 'Ticket', 'width=250,height=620,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes')"><i class="fa fa-print fa-1x" style="color:#333"></i></a></td>  
    <td align="left" height="25"><?php echo $row_Recordset1['ip_venta_hnac']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_taquilla']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_usuario']; ?></td>
    <td align="right"><?php echo $rest; ?></td>
    <td align="right"><?php echo $row_Recordset1['can_ticket_hnac']; ?></td>
    <td align="center" style="font-size:12px"><?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?></td>
    <td align="center" style="font-size:12px"><?php echo $row_Recordset1['hor_venta_hnac']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_hipodromo_hnac']." Carr: ...".$row_Recordset1['num_carrera_hnac']." ".$row_Recordset1['num_caballo_hnac']."-".ObtenerNombreApuesta2($row_Recordset1['cod_tventa_hnac'])."-".$row_Recordset1['mon_venta_hnac']; ?></td>
    <td align="center"><?php echo $estado; ?></td>
    <?php if ($row_Recordset1['est_ticket_hnac']==2 || $row_Recordset1['est_ticket_hnac']==3  || $row_Recordset1['est_ticket_hnac']==4) {?>
    <td><?php echo NombreVendedor($row_Recordset1['cod_usuario_pago_hnac']); ?></td>
    <td align="center" style="font-size:12px"><?php echo fechanueva($row_Recordset1['fec_pago_hnac']); ?></td>
    <td align="center" style="font-size:12px"><?php echo $row_Recordset1['hor_pago_hnac']; ?></td>
    <td align="left"><?php echo $row_Recordset1['ip_pago_hnac']; ?></td>
    <td align="center" >
    <?php if ($row_Recordset1['est_ticket_hnac']==1) {?>
    <a href="#" onclick="cStatus(<?php echo $rest ?>)" title="eliminar ticket"><i class="fa fa-times fa-2x"></i></a>
    <?php }?>
    </td>
    <?php } else {?>
     <td><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="left"><?php echo ""; ?></td>
    <td align="center">
    <?php if ($row_Recordset1['est_ticket_hnac']==1) {?>
    <a href="#" onclick="cStatus(<?php echo $rest ?>)" title="eliminar ticket: <?php echo $rest ?>">
    	<i class="fa fa-times fa-2x" style="color:#C00"></i>
    </a>
     <?php }?>
    </td>

    <?php } ?>
  </tr>
<?php
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    <?php
            } else {?>
    <tr class="docepunto">
    <td colspan="17" align="left" style="font-size:18px"><strong>No existen datos</strong></td>
    </tr>
	<?php }?>  
</table>
</div>
<span class="boton-top" title="ir arriba">▲</span>
<div style="background: #333; width:100%; float:left; padding:12px 13px 2px 12px; text-align:center;
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
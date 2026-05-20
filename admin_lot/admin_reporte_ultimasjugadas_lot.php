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
                    "/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 1 */ SELECT 
					ve.ip_venta_lot,
					ve.est_ticket_lot,
					ve.ser_ticket_lot,
					ve.est_calculo_lot,
					ve.mon_apuesta_lot,
					ve.fec_venta_lot,
					ve.ticket_lot,
					ve.can_ticket_lot,
					ve.hor_venta_lot,
					ve.num_apuesta_lot,
					ve.pag_premio_lot,
					ve.fec_pago_lot,
					ve.hor_pago_lot,
					ve.ip_pago_lot,
					
					(/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 2 */ SELECT usu.nom_usuario FROM usuario usu WHERE usu.id_usuario = ve.cod_usuario_pago_lot) AS nom_pago_lot,
					CASE ve.tip_loteria_lot  
						WHEN 2 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 3 */ SELECT sor.nom_corto FROM signos sor WHERE sor.id_signo = ve.id_signo LIMIT 1)
						WHEN 3 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 4 */ SELECT sor.nom_corto FROM signos sor WHERE sor.id_signo = ve.id_signo LIMIT 1)
						WHEN 4 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 5 */ SELECT ani.nom_animal FROM animales ani WHERE ani.num_animal = ve.num_apuesta_lot LIMIT 1)
						WHEN 5 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 6 */ SELECT fru.nom_corto FROM frutas fru WHERE fru.id_fruta = ve.id_signo LIMIT 1)
						WHEN 6 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 7 */ SELECT pal.nom_corto FROM palos_cartas pal WHERE pal.id_palo = ve.id_signo LIMIT 1)
						ELSE ''
					END AS nsigno,
					lo.nom_loteria,
					ta.nom_taquilla,
					us.nom_usuario,
					ag.nom_agencia
				FROM
					usuario us,
					agencia ag, 
					taquilla ta,
					venta_lot ve,
					loterias lo
				WHERE
					ag.cod_agencia = ta.cod_agencia AND
					us.cod_taquilla = ta.cod_taquilla AND
					us.id_usuario = ve.id_usuario AND
					lo.id_loteria = ve.id_loteria AND
					(ve.fec_venta_lot >= %s AND ve.fec_venta_lot <= %s OR 
					ve.fec_pago_lot >= %s AND ve.fec_pago_lot <= %s) AND
					ag.cod_agencia = %s
				ORDER BY ag.nom_agencia, ta.nom_taquilla, ve.fec_venta_lot, ve.hor_venta_lot DESC LIMIT 8000",
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
        "/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 8 */ SELECT 
		ve.ip_venta_lot,
		ve.est_ticket_lot,
		ve.ser_ticket_lot,
		ve.est_calculo_lot,
		ve.mon_apuesta_lot,
		ve.fec_venta_lot,
		ve.ticket_lot,
		ve.can_ticket_lot,
		ve.hor_venta_lot,
		ve.num_apuesta_lot,
		ve.pag_premio_lot,
		ve.fec_pago_lot,
		ve.hor_pago_lot,
		ve.ip_pago_lot,
		(/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 9 */ SELECT usu.nom_usuario FROM usuario usu WHERE usu.id_usuario = ve.cod_usuario_pago_lot) AS nom_pago_lot,
		CASE ve.tip_loteria_lot  
			WHEN 2 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 10 */ SELECT sor.nom_corto FROM signos sor WHERE sor.id_signo = ve.id_signo LIMIT 1)
			WHEN 3 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 11 */ SELECT sor.nom_corto FROM signos sor WHERE sor.id_signo = ve.id_signo LIMIT 1)
			WHEN 4 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 12 */ SELECT ani.nom_animal FROM animales ani WHERE ani.num_animal = ve.num_apuesta_lot LIMIT 1)
			WHEN 5 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 13 */ SELECT fru.nom_corto FROM frutas fru WHERE fru.id_fruta = ve.id_signo LIMIT 1)
			WHEN 6 THEN (/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 14 */ SELECT pal.nom_corto FROM palos_cartas pal WHERE pal.id_palo = ve.id_signo LIMIT 1)
			ELSE ''
		END AS nsigno,
		lo.nom_loteria,
		ta.nom_taquilla,
		us.nom_usuario,
		ag.nom_agencia
	FROM
		usuario us,
		agencia ag, 
		taquilla ta,
		venta_lot ve,
		loterias lo
	WHERE
		ag.cod_agencia = ta.cod_agencia AND
		us.cod_taquilla = ta.cod_taquilla AND
		us.id_usuario = ve.id_usuario AND
		lo.id_loteria = ve.id_loteria AND
		(ve.fec_venta_lot >= %s AND ve.fec_venta_lot <= %s OR 
		ve.fec_pago_lot >= %s AND ve.fec_pago_lot <= %s) 
	ORDER BY ag.nom_agencia, ta.nom_taquilla, ve.fec_venta_lot, ve.hor_venta_lot DESC LIMIT 8000",
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
$query_Recordset2 = "/* PARSEADORES1 admin_lot\admin_reporte_ultimasjugadas_lot.php - QUERY 15 */ SELECT ag.cod_agencia, ag.nom_agencia 
	FROM 
		agencia ag, agencialoterias al 
	WHERE ag.cod_agencia = al.id_agencia
	GROUP BY ag.cod_agencia
	ORDER BY ag.nom_agencia";
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
			$.ajax({ data:parametros, url:'../includes/elimina_ticket_lot.php', type:'post',
				success:function (response) { 
					$("#hipodromo").html(response);
				}
			});
			document.getElementById("form1").submit();
			//window.location='admin_reporte_ultimasjugadas_lot.php'; 
		}
	}
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<div id="hipodromo"></div>
   <div style="background: #0084B4; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center">
        REPORTE DE LAS ÚLTIMAS 8000 JUGADAS LOTERIAS/ANIMALITOS
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
      <tr style="background:#0084B4; color:#FFF">
        <td width="16" align="center">-</td>
        <td width="90" align="center">IP Venta</td>
        <td width="90" align="center">Taquilla</td>
        <td width="90" align="center">Vendedor</td>
        <td width="65" align="center">Ticket#</td>
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
                    if ($row_Recordset1['est_ticket_lot']==0) {
                        $estado="ELIMINADO";
                        $montoJugado=0;
                        $pagado=0;
                        $porpagar=0;
                    } else {
                        if ($row_Recordset1['est_ticket_lot']==1 || $row_Recordset1['est_ticket_lot']==3) {
                            if ($row_Recordset1['est_calculo_lot']==0) {
                                $estado="PENDIENTE";
                                $montoJugado=$row_Recordset1['mon_apuesta_lot'];
                                $porpagar=0;
                                $pagado="0";
                            } elseif ($row_Recordset1['est_calculo_lot']==1) {
                                $estado="PERDEDOR";
                                $montoJugado=$row_Recordset1['mon_apuesta_lot'];
                                $porpagar=0;
                                $pagado="0";
                            } elseif ($row_Recordset1['est_calculo_lot']==2) {
                                $estado="GANADOR";
                                $montoJugado=$row_Recordset1['mon_apuesta_lot'];
                                $porpagar=$row_Recordset1['pag_premio_lot'];
                                $pagado="0";
                            } elseif ($row_Recordset1['est_calculo_lot']==4) {
                                $estado="DEVOLUCION";
                                $montoJugado=$row_Recordset1['mon_apuesta_lot'];
                                $porpagar=$row_Recordset1['pag_premio_lot'];
                                $pagado="0";
                            }
                            $totalporpagar=$totalporpagar+$porpagar;
                        }
                        if ($row_Recordset1['est_ticket_lot']==2) {
                            if ($row_Recordset1['fec_pago_lot']>=$in && $row_Recordset1['fec_pago_lot']<=$fi) {
                                $estado="PAGO";
                                if ($row_Recordset1['fec_venta_lot']>=$in && $row_Recordset1['fec_venta_lot']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_apuesta_lot'];
                                }
                                $porpagar=0;
                                $totalpagado=$totalpagado+$row_Recordset1['pag_premio_lot'];
                            } else {
                                $estado="DIFERIDO";
                                $porpagar=0;
                                if ($row_Recordset1['fec_venta_lot']>=$in && $row_Recordset1['fec_venta_lot']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_apuesta_lot'];
                                }
                            }
                        }
                        if ($row_Recordset1['est_ticket_lot']==5) {
                            if ($row_Recordset1['fec_pago_lot']>=$in && $row_Recordset1['fec_pago_lot']<=$fi) {
                                $estado="DEVOLUCION";
                                if ($row_Recordset1['fec_venta_lot']>=$in && $row_Recordset1['fec_venta_lot']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_apuesta_lot'];
                                }
                                $porpagar=0;
                                $totalpagado=$totalpagado+$row_Recordset1['pag_premio_lot'];
                            } else {
                                $estado="DIFERIDO";
                                if ($row_Recordset1['fec_venta_lot']>=$in && $row_Recordset1['fec_venta_lot']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_apuesta_lot'];
                                }
                            }
                        }
                    }
                    if ($row_Recordset1['est_ticket_lot']!=0) {
                        if ($row_Recordset1['fec_venta_lot']>=$in && $row_Recordset1['fec_venta_lot']<=$fi) {
                            $totalMontoJugado=$totalMontoJugado+$row_Recordset1['mon_apuesta_lot'];
                        }
                    }
                    $ticket2=$row_Recordset1['ticket_lot'];
                    $serial=$row_Recordset1['ser_ticket_lot'];
                    $rest = substr($serial, 0, 2);
                    $rest = $rest.$ticket2;
                    $insertGoTo = "admin_reimprimir_ticket_lot.php?recordID=$ticket2"; ?> 
  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
	<td align="center" ><a href="#" onclick="window.open('<?php echo $insertGoTo; ?>', 'Ticket', 'width=250,height=620,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes')"><i class="fa fa-print fa-1x" style="color:#333"></i></a></td>  
    <td align="left" height="25"><?php echo $row_Recordset1['ip_venta_lot']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_taquilla']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_usuario']; ?></td>
    <td align="right"><?php echo $rest; ?></td>
    <td align="right"><?php echo $row_Recordset1['can_ticket_lot']; ?></td>
    <td align="center" style="font-size:12px"><?php echo fechanueva($row_Recordset1['fec_venta_lot']); ?></td>
    <td align="center" style="font-size:12px"><?php echo $row_Recordset1['hor_venta_lot']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_loteria']." (".$row_Recordset1['num_apuesta_lot']."x".$row_Recordset1['mon_apuesta_lot'];
                    if ($row_Recordset1['nsigno']!="") {
                        echo "-".$row_Recordset1['nsigno'];
                    }
                    echo ")"; ?></td>
    <td align="center"><?php echo $estado; ?></td>
    <?php if ($row_Recordset1['est_ticket_lot']==2 || $row_Recordset1['est_ticket_lot']==3  || $row_Recordset1['est_ticket_lot']==4) {?>
    <td><?php echo $row_Recordset1['nom_pago_lot']; ?></td>
    <td align="center" style="font-size:12px"><?php echo fechanueva($row_Recordset1['fec_pago_lot']); ?></td>
    <td align="center" style="font-size:12px"><?php echo $row_Recordset1['hor_pago_lot']; ?></td>
    <td align="left"><?php echo $row_Recordset1['ip_pago_lot']; ?></td>
    <td align="center" >
    <?php if ($row_Recordset1['est_ticket_lot']==1) {?>
    <a href="#" onclick="cStatus(<?php echo $rest ?>)" title="eliminar ticket"><i class="fa fa-times fa-2x"></i></a>
    <?php }?>
    </td>
    <?php } else {?>
     <td><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="left"><?php echo ""; ?></td>
    <td align="center">
    <?php if ($row_Recordset1['est_ticket_lot']==1) {?>
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
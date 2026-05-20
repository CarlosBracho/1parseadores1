<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
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
            if ($_POST['id_taquilla']!="todos") {
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 agente_hnac\agente_reporte_jugadas_hnac.php - QUERY 1 */ SELECT 
						agencia.nom_agencia,
						venta_hnac.est_ticket_hnac,
						venta_hnac.ser_venta_hnac,
						venta_hnac.ticket_hnac,
						venta_hnac.ip_venta_hnac,
						venta_hnac.num_caballo_hnac,
						venta_hnac.cod_tventa_hnac,
						venta_hnac.cod_usuario_pago_hnac,
						venta_hnac.fec_pago_hnac,
						venta_hnac.hor_pago_hnac,
						venta_hnac.mon_venta_hnac,
						venta_hnac.ip_pago_hnac,
						venta_hnac.fec_venta_hnac,
						venta_hnac.hor_venta_hnac,
						venta_hnac.pag_premio_hnac,
						usuario.nom_usuario,
						can_ticket_hnac,
						hipodromo_hnac.nom_hipodromo_hnac,
						carrera_hnac.num_carrera_hnac,
						carrera_hnac.cod_carrera_hnac,
						taquilla.nom_taquilla,
						taquilla.cod_taquilla 
					FROM 
						agencia, 
						taquilla,
						taquilla_opc_hnac, 
						hipodromo_hnac,
						usuario,
						carrera_hnac,
						venta_hnac 
USE INDEX(id_us_fe_fe)
					WHERE
						
						usuario.cod_taquilla = taquilla.cod_taquilla AND
						
						usuario.id_usuario = venta_hnac.id_usuario AND
						
						(venta_hnac.fec_venta_hnac >= %s AND venta_hnac.fec_venta_hnac <= %s OR 
						venta_hnac.fec_pago_hnac >= %s AND venta_hnac.fec_pago_hnac <= %s) AND 
						
						taquilla.cod_agencia = agencia.cod_agencia AND
						
						taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
						venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND
						hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac AND
						taquilla.cod_taquilla = %s
					ORDER BY venta_hnac.fec_venta_hnac,taquilla.cod_taquilla,venta_hnac.num_ticket_hnac ASC",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($_POST['id_taquilla'], "int")
                );
            } else {
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 agente_hnac\agente_reporte_jugadas_hnac.php - QUERY 2 */ SELECT 
						agencia.nom_agencia,
						venta_hnac.est_ticket_hnac,
						venta_hnac.ser_venta_hnac,
						venta_hnac.ticket_hnac,
						venta_hnac.ip_venta_hnac,
						venta_hnac.num_caballo_hnac,
						venta_hnac.cod_tventa_hnac,
						venta_hnac.cod_usuario_pago_hnac,
						venta_hnac.fec_pago_hnac,
						venta_hnac.hor_pago_hnac,
						venta_hnac.mon_venta_hnac,
						venta_hnac.ip_pago_hnac,
						venta_hnac.fec_venta_hnac,
						venta_hnac.hor_venta_hnac,
						venta_hnac.pag_premio_hnac,
						usuario.nom_usuario,
						can_ticket_hnac,
						hipodromo_hnac.nom_hipodromo_hnac,
						carrera_hnac.num_carrera_hnac,
						carrera_hnac.cod_carrera_hnac,
						taquilla.nom_taquilla,
						taquilla.cod_taquilla 
					FROM 
						agencia, 
						taquilla,
						taquilla_opc_hnac, 
						hipodromo_hnac,
						usuario,
						carrera_hnac,
						venta_hnac 
USE INDEX(id_us_fe_fe)
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
					ORDER BY venta_hnac.fec_venta_hnac,taquilla.cod_taquilla,venta_hnac.num_ticket_hnac ASC",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($codigoAgente, "int")
                );
            }
        }
    }
} else {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 agente_hnac\agente_reporte_jugadas_hnac.php - QUERY 3 */ SELECT 
			agencia.nom_agencia,
			venta_hnac.est_ticket_hnac,
			venta_hnac.ser_venta_hnac,
			venta_hnac.ticket_hnac,
			venta_hnac.ip_venta_hnac,
			venta_hnac.num_caballo_hnac,
			venta_hnac.cod_tventa_hnac,
			venta_hnac.cod_usuario_pago_hnac,
			venta_hnac.fec_pago_hnac,
			venta_hnac.hor_pago_hnac,
			venta_hnac.mon_venta_hnac,
			venta_hnac.ip_pago_hnac,
			venta_hnac.fec_venta_hnac,
			venta_hnac.hor_venta_hnac,
			venta_hnac.pag_premio_hnac,
			usuario.nom_usuario,
			can_ticket_hnac,
			hipodromo_hnac.nom_hipodromo_hnac,
			carrera_hnac.num_carrera_hnac,
			carrera_hnac.cod_carrera_hnac,
			taquilla.nom_taquilla,
			taquilla.cod_taquilla 
		FROM 
			agencia, 
			taquilla,
			taquilla_opc_hnac, 
			hipodromo_hnac,
			usuario,
			carrera_hnac,
			venta_hnac 
USE INDEX(id_us_fe_fe)
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
		ORDER BY venta_hnac.fec_venta_hnac,taquilla.cod_taquilla,venta_hnac.num_ticket_hnac ASC",
        GetSQLValueString($in, "date"),
        GetSQLValueString($fi, "date"),
        GetSQLValueString($in, "date"),
        GetSQLValueString($fi, "date"),
        GetSQLValueString($codigoAgente, "int")
    );
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$vendedor="AGENTE: ".strtoupper($row_Recordset1['nom_agencia']);

$query_Recordset2 = sprintf(
    "/* PARSEADORES1 agente_hnac\agente_reporte_jugadas_hnac.php - QUERY 4 */ SELECT nom_taquilla, cod_taquilla 
	FROM 
		taquilla 
	WHERE 
		taquilla.cod_agencia = %s 
	ORDER BY taquilla.nom_taquilla",
    GetSQLValueString($codigoAgente, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
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
	.boton-top{
		display: none;
		position:fixed;
		bottom:0;
		right:0;
		width:50px;
		height: 50px;
		text-align:center;
		line-height:50px;
		color:#fff;
		background: #F93;
		cursor:pointer;
	}
</style>
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
   <div style="background:#0E5157; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center">
        REPORTE DE JUGADAS NACIONALES
   </div><!-- end .container -->
   <div style="background: #FFF; width:150%; float:left; padding:25px 0px 0px 10px;
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
            <select name="id_taquilla" id="soflow" style="height:40px">
                  <option value="todos" >TODOS</option>
                  <?php
            do {
                ?>
           <option value="<?php echo $row_Recordset2['cod_taquilla']?>">
		   		<?php echo strtoupper($row_Recordset2['nom_taquilla'])?>
           </option>
                  <?php
            } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            ?>
                </select>
            <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
             style="width:80px"/>
            <input type="hidden" name="MM_update" value="form1" />
     </form>  
   </div><!-- end .container -->
   <div id="gener" style="width:140%; float:left;">
   
   <div id="tgeneral" style="background: #333; width:98%; float:left; padding:12px 13px 2px 12px;
   		color:#FFF; font-size:18px;">
        <div></div>
   </div><!-- end .container -->
   <div style="background: #333; width:98%; float:left; padding:12px 13px 2px 12px;
   		color:#FFF; font-size:18px;">
        <div><span style="float:right;">FECHA: del <?php echo $inicio." al ".$final; ?></span><?php echo $vendedor; ?></div>
   </div><!-- end .container -->
   <div style="background:#0E5157; width:80px; float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		IP Venta
   </div><!-- end .container -->
   <div style="background:#0E5157; width:158px; float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Taquilla
   </div><!-- end .container -->
   <div style="background:#0E5157; width:105px; float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Vendedor
   </div><!-- end .container -->
   <div style="background:#0E5157; width:78px; float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Ticket#
   </div><!-- end .container -->
   <div style="background:#0E5157; width:28px; float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Nro
   </div><!-- end .container -->
   <div style="background:#0E5157; width:78px; float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Serial#
   </div><!-- end .container -->
   <div style="background:#0E5157; width:75px; float:left; padding:8px 2px; color:#FFF; font-size:12px; text-align:center;">
   		Fecha venta
   </div><!-- end .container -->
   <div style="background:#0E5157; width:75px; float:left; padding:8px 2px; color:#FFF; font-size:12px; text-align:center;">
   		Hora venta
   </div><!-- end .container -->
   <div style="background:#0E5157; width:305px; float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Jugada
   </div><!-- end .container -->
   <div style="background:#0E5157; width:90px; float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Estado
   </div><!-- end .container -->
   <div style="background:#0E5157; width:80px; float:left; padding:8px 2px; color:#FFF; font-size:11px; text-align:center;">
   		Monto Jugado
   </div><!-- end .container -->
   <div style="background:#0E5157; width:75px; float:left; padding:8px 2px; color:#FFF; font-size:12px; text-align:center;">
   		Por pagar
   </div><!-- end .container -->
   <div style="background:#0E5157; width:75px; float:left; padding:8px 2px; color:#FFF; font-size:11px; text-align:center;">
   		Monto pagado
   </div><!-- end .container -->
   <div style="background:#0E5157; width:130px; float:left; padding:8px 2px; color:#FFF; font-size:14px; text-align:center;">
   		Vendedor pago
   </div><!-- end .container -->
   <div style="background:#0E5157; width:70px; float:left; padding:8px 2px; color:#FFF; font-size:12px; text-align:center;">
   		Fecha pago
   </div><!-- end .container -->
   <div style="background:#0E5157; width:80px; float:left; padding:8px 2px; color:#FFF; font-size:12px; text-align:center;">
   		Hora pago
   </div><!-- end .container -->
   <div style="background:#0E5157; width:70px; float:left; padding:8px 2px; color:#FFF; font-size:12px; text-align:center;">
   		IP Pago
   </div><!-- end .container -->
   <div style="background:#333333; width:57px; float:left; padding:8px 2px; color:#FFF; font-size:12px; text-align:center;">
   		Acción
   </div><!-- end .container -->
<table width="1780" border="1" class="oncepunto">
  <tr bgcolor="#CCCCCC">
    <td width="60" align="center"></td>
    <td width="122" align="center"></td>
    <td width="90" align="center"></td>
    <td width="65" align="center"></td>
    <td width="24" align="center"></td>
    <td width="60" align="center"></td>
    <td width="60" align="center"></td>
    <td width="60" align="center"></td>
    <td width="273" align="center"></td>
    <td width="70" align="center"></td>
    <td width="62" align="center"></td>
    <td width="62" align="center"></td>
    <td width="70" align="center"></td>
    <td width="100" align="center"></td>
    <td width="60" align="center"></td>
    <td width="60" align="center"></td>
    <td width="65" align="center"></td>
    <td width="47" align="center"></td>
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
                $cCar=0;
                $fCar=0;
                $cTaq=0;
                $retiros=array();
                do {
                    $pa[0]=0;
                    $pa[1]="";
                    if ($row_Recordset1['est_ticket_hnac']==0) {
                        $estado="ELIMINADO";
                        $montoJugado=0;
                        $pagado=0;
                        $porpagar=0;
                    } else {
                        if ($row_Recordset1['est_ticket_hnac']==1 || $row_Recordset1['est_ticket_hnac']==3) {
                            if ($row_Recordset1['cod_carrera_hnac']!=$cCar || $row_Recordset1['fec_venta_hnac']!=$fCar ||
                 $row_Recordset1['cod_taquilla']!=$cTaq) {
                                list($ejem, $div, $rows, $codR)=buscaDivTaquilla(
                                    $row_Recordset1['cod_carrera_hnac'],
                                    $row_Recordset1['fec_venta_hnac'],
                                    $row_Recordset1['cod_taquilla'],
                                    $row_Recordset1['cod_tventa_hnac'],
                                    11
                                );
                                if ($row_Recordset1['cod_carrera_hnac']!=$cCar) {
                                    $retiros=arrayRetiradosHNAC($row_Recordset1['cod_carrera_hnac']);
                                }
                                $cCar=$row_Recordset1['cod_carrera_hnac'];
                                $fCar=$row_Recordset1['fec_venta_hnac'];
                                $cTaq=$row_Recordset1['cod_taquilla'];
                            }
                            if ($rows<=0) {
                                $estado="PENDIENTE";
                                $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                $porpagar=0;
                                $pagado="0";
                            } else {
                                if ($row_Recordset1['cod_tventa_hnac']>=1 && $row_Recordset1['cod_tventa_hnac']<=3) {
                                    if (in_array($row_Recordset1['num_caballo_hnac'], $retiros)) {
                                        $pa[1]="5";
                                        $pa[0]=$row_Recordset1['mon_venta_hnac'];
                                    } else {
                                        if ($row_Recordset1['cod_tventa_hnac']==1) {
                                            if ($ejem==$row_Recordset1['num_caballo_hnac']) {
                                                $pa[0]=($row_Recordset1['mon_venta_hnac']*$div)/10;
                                                $pa[1]="1";
                                            }
                                        }
                                    }
                                    $bandera=$pa[0];
                                }
                                if ($bandera>0) {
                                    $estado="GANADOR";
                                    if ($pa[1]=="5") {
                                        $estado="DEVOLUCION";
                                    }
                                    $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                    $pagado=0;
                                    $porpagar=$bandera;
                                    $totalporpagar=$totalporpagar+$porpagar;
                                }
                                if ($bandera<=0) {
                                    $estado="PERDEDOR";
                                    $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                    $pagado=0;
                                    $porpagar=0;
                                }
                            }
                        }
                        if ($row_Recordset1['est_ticket_hnac']==2) {
                            if ($row_Recordset1['fec_pago_hnac']>=$in && $row_Recordset1['fec_pago_hnac']<=$fi) {
                                $estado="PAGO";
                                if ($row_Recordset1['fec_venta_hnac']>=$in && $row_Recordset1['fec_venta_hnac']<=$fi) {
                                    $montoJugado=$row_Recordset1['mon_venta_hnac'];
                                }
                                if ($row_Recordset1['cod_tventa_hnac']>=1 && $row_Recordset1['cod_tventa_hnac']<=3) {
                                    $pa[0]=$row_Recordset1['pag_premio_hnac'];
                                }
                                $porpagar=0;
                                $pagado=$pa[0];
                                $totalpagado=$totalpagado+$pagado;
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
                                $pagado=$row_Recordset1['mon_venta_hnac'];
                                $porpagar=0;
                                $totalpagado=$totalpagado+$pagado;
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
                    $insertGoTo = "revistaticket_hnac.php?recordID=$ticket2"; ?> 
  <tr onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)">
    <td align="left"><?php echo $row_Recordset1['ip_venta_hnac']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_taquilla']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_usuario']; ?></td>
    <td align="right"><?php echo $row_Recordset1['ticket_hnac']; ?></td>
    <td align="right"><?php echo $row_Recordset1['can_ticket_hnac']; ?></td>
    <td align="right"><?php echo $rest; ?></td>
    <td align="center"><?php echo fechanueva($row_Recordset1['fec_venta_hnac']); ?></td>
    <td align="center"><?php echo $row_Recordset1['hor_venta_hnac']; ?></td>
    <td align="left"><?php echo $row_Recordset1['nom_hipodromo_hnac']." Carr: ...".$row_Recordset1['num_carrera_hnac']." ".$row_Recordset1['num_caballo_hnac']."-".ObtenerNombreApuesta2($row_Recordset1['cod_tventa_hnac'])."-".$row_Recordset1['mon_venta_hnac']; ?></td>
    <td align="center"><?php echo $estado; ?></td>
    <td align="right"><?php echo number_format($montoJugado, 2, ",", "."); ?></td>
    <td align="right"><?php echo number_format($porpagar, 2, ",", "."); ?></td>
    <td align="right"><?php echo number_format($pagado, 2, ",", "."); ?></td>
    <?php if ($row_Recordset1['est_ticket_hnac']==2 || $row_Recordset1['est_ticket_hnac']==3  || $row_Recordset1['est_ticket_hnac']==4) {?>
    <td><?php echo NombreVendedor($row_Recordset1['cod_usuario_pago_hnac']); ?></td>
    <td align="center"><?php echo fechanueva($row_Recordset1['fec_pago_hnac']); ?></td>
    <td align="center"><?php echo $row_Recordset1['hor_pago_hnac']; ?></td>
    <td align="left"><?php echo $row_Recordset1['ip_pago_hnac']; ?></td>
    <td align="center"><a href="#" onclick="window.open('<?php echo $insertGoTo; ?>', 'Ticket', 'width=210,height=620,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes')"><img src="../images/printer-icon.png" width="16" height="16" /> </a></td>
    <?php } else {?>
     <td><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="center"><?php echo ""; ?></td>
    <td align="left"><?php echo ""; ?></td>
    <td align="center"><a href="#" onclick="window.open('<?php echo $insertGoTo ?>', 'Ticket', 'width=200,height=620,Aresizable=no,location=no,menubar=no,scrollbars=no,status=no,toolbar=no,fullscreen=no,dependent=yes')"><img src="../images/printer-icon.png" width="16" height="16" /> </a></td>

    <?php } ?>
  </tr>
<?php
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
  <tr bgcolor="#CCCCCC">
    <td colspan="10" align="right"><strong>SUBTOTAL:</strong></td>
    <td align="right"><strong><?php echo number_format($totalMontoJugado, 2, ",", "."); ?></strong></td>
    <td align="right"><strong><?php echo number_format($totalporpagar, 2, ",", "."); ?></strong></td>
    <td align="right"><strong><?php echo number_format($totalpagado, 2, ",", "."); ?></strong></td>
    <td colspan="5" align="center">&nbsp;</td>
    </tr>
  <tr bgcolor="#CCCCCC" class="docepunto">
    <?php $totalgeneral=$totalMontoJugado-$totalpagado; ?>
    <td colspan="10" align="right"><strong>TOTAL GENERAL:</strong></td>
    <td colspan="2" align="right"><strong><?php echo number_format($totalgeneral, 2, ",", "."); ?></strong></td>
    <td colspan="6" align="center">&nbsp;</td>
    </tr>
    </table>
    
   	  <?php
            } else {?>
    	<h2>No existen datos</h2>
	<?php }?>  

    <span class="boton-top" title="ir arriba">▲</span>
</div>
	<script>
	$(window).scroll(function(){
	    if ($(this).scrollTop() > 0) {
	        $('.boton-top').fadeIn();
	    } else {
	        $('.boton-top').fadeOut();
	    }
	});
	$('.boton-top').click(function(){
	    $(document.body).animate({scrollTop : 0}, 500);
	    return false;
	});
	</script>
</body>
</html>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset2);
?>
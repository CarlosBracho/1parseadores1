<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
$codigoUsuario=$_SESSION['MM_id_usuario'];

$query_Recordset3 = sprintf(
    "/* PARSEADORES1 ventashnac_mie\ventas_reporte_cuadre_combinado - Copia.php - QUERY 1 */ SELECT * 
FROM agencia, taquilla, taquilla_opc_hnac, venta_hnac, usuario, carrera_hnac 
WHERE taquilla.cod_taquilla = usuario.cod_taquilla AND venta_hnac.id_usuario = usuario.id_usuario AND
(venta_hnac.fec_venta_hnac >= %s AND venta_hnac.fec_venta_hnac <= %s OR 
venta_hnac.fec_pago_hnac >= %s AND venta_hnac.fec_pago_hnac <= %s) AND 
agencia.cod_agencia = taquilla.cod_agencia AND 
taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND usuario.id_usuario = %s 
ORDER BY venta_hnac.fec_venta_hnac,taquilla.cod_taquilla,venta_hnac.num_ticket_hnac ASC",
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$vendedor=strtoupper($row_Recordset3['nom_usuario']);
$taquillaV=$row_Recordset3['nom_taquilla'];

//-------------------------------------- AMERICANAS
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventashnac_mie\ventas_reporte_cuadre_combinado - Copia.php - QUERY 2 */ SELECT * 
FROM agencia, taquilla, taquilla_opc_ame, venta, usuario, carrera 
WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND usuario.id_usuario = venta.id_usuario AND
(venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s AND venta.fec_pago <= %s) AND 
taquilla.cod_agencia = agencia.cod_agencia AND taquilla.cod_taquilla = venta.cod_taquilla AND
taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
venta.cod_carrera = carrera.cod_carrera AND usuario.id_usuario = %s 
ORDER BY venta.fec_venta,venta.cod_taquilla,venta.num_ticket ASC",
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($in, "date"),
    GetSQLValueString($fi, "date"),
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

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
                $query_Recordset3 = sprintf(
                    "/* PARSEADORES1 ventashnac_mie\ventas_reporte_cuadre_combinado - Copia.php - QUERY 3 */ SELECT * 
				FROM 
				agencia, taquilla, taquilla_opc_hnac, venta_hnac, usuario, carrera_hnac 
				WHERE taquilla.cod_taquilla = usuario.cod_taquilla AND venta_hnac.id_usuario = usuario.id_usuario AND
				(venta_hnac.fec_venta_hnac >= %s AND venta_hnac.fec_venta_hnac <= %s OR 
				venta_hnac.fec_pago_hnac >= %s AND venta_hnac.fec_pago_hnac <= %s) AND 
				agencia.cod_agencia = taquilla.cod_agencia AND taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
				venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND usuario.id_usuario = %s 
				ORDER BY venta_hnac.fec_venta_hnac,taquilla.cod_taquilla,venta_hnac.num_ticket_hnac ASC",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($_POST['id_usuario'], "int")
                );
                $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                $vendedor=strtoupper($row_Recordset3['nom_usuario']);
                $taquillaV=$row_Recordset3['nom_taquilla'];
                //-------------------------------------- AMERICANAS --- INICIO
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 ventashnac_mie\ventas_reporte_cuadre_combinado - Copia.php - QUERY 4 */ SELECT * 
				FROM agencia, taquilla, taquilla_opc_ame, venta, usuario, carrera 
				WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND usuario.id_usuario = venta.id_usuario AND
				(venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s AND venta.fec_pago <= %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND taquilla.cod_taquilla = venta.cod_taquilla AND
				taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND usuario.id_usuario = %s 
				ORDER BY venta.fec_venta,venta.cod_taquilla,venta.num_ticket ASC",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($_POST['id_usuario'], "int")
                );
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            //-------------------------------------- AMERICANAS --- FIN
            } else {
                $query_Recordset3 = sprintf(
                    "/* PARSEADORES1 ventashnac_mie\ventas_reporte_cuadre_combinado - Copia.php - QUERY 5 */ SELECT * 
				FROM agencia, taquilla, taquilla_opc_hnac, venta_hnac, usuario, carrera_hnac 
				WHERE taquilla.cod_taquilla = usuario.cod_taquilla AND venta_hnac.id_usuario = usuario.id_usuario AND
				(venta_hnac.fec_venta_hnac >= %s AND venta_hnac.fec_venta_hnac <= %s OR 
				venta_hnac.fec_pago_hnac >= %s AND venta_hnac.fec_pago_hnac <= %s) AND 
				agencia.cod_agencia = taquilla.cod_agencia AND taquilla_opc_hnac.cod_taquilla = taquilla.cod_taquilla AND
				venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND taquilla.cod_taquilla = %s 
				ORDER BY venta_hnac.fec_venta_hnac,taquilla.cod_taquilla,venta_hnac.num_ticket_hnac ASC",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($codigoTaquilla, "int")
                );
                $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                $vendedor="TODOS";
                $taquillaV=$row_Recordset3['nom_taquilla'];
                
                //-------------------------------------- AMERICANAS --- INICIO
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 ventashnac_mie\ventas_reporte_cuadre_combinado - Copia.php - QUERY 6 */ SELECT * 
				FROM agencia, taquilla, taquilla_opc_ame, venta, usuario, carrera 
				WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND usuario.id_usuario = venta.id_usuario AND
				(venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s AND venta.fec_pago <= %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND taquilla.cod_taquilla = venta.cod_taquilla AND
				taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND taquilla.cod_taquilla=%s 
				ORDER BY venta.fec_venta,venta.cod_taquilla,venta.num_ticket ASC",
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($codigoTaquilla, "int")
                );
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                //-------------------------------------- AMERICANAS --- FIN
            }
        }
    }
}
$query_Recordset2 = sprintf("/* PARSEADORES1 ventashnac_mie\ventas_reporte_cuadre_combinado - Copia.php - QUERY 7 */ SELECT * FROM usuario 
	WHERE usuario.cod_taquilla = %s AND tip_usuario='U' ORDER BY usuario.nom_usuario", GetSQLValueString($codigoTaquilla, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$canJugada=$row_Recordset3['jug_alquiler_hanc'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
   <div style="background: #036; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:26px; text-align:center">
        CUADRE AMERICANAS - NACIONALES
   </div><!-- end .container -->
   <div style="background: #FFF; width:100%; float:left; padding:15px 0px 0px 10px;
   		color:#000; font-size:20px; text-align: left"  id="noprint1">
       <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
            onsubmit="return chequearEnvio();">
            Desde:
            <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" style="width:90px; font-size:16px; height:20px"
                title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
            Hasta:    
            <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" style="width:90px; font-size:16px; height:20px"
                size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" /> 
            <div style="background: #FFF; width:495px; float:left; padding:0px 0px 5px 0px;" id="noprint2">
                Vendedores:
                <select name="id_usuario" style="height:35px; width:280px; margin:0px 0px 0px -4px">
                      <option value="todos" <?php if ($vendedor=="TODOS") {
    echo "SELECTED";
} ?>>
                    TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset2['id_usuario']?>" 
                        <?php if ($row_Recordset2['nom_usuario']==$vendedor) {
                        echo "SELECTED";
                    } ?>>
                        <?php echo strtoupper($row_Recordset2['nom_usuario']); ?>
                </option>
                      <?php
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                ?>
                    </select>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:35px; margin: 3px 0px 0px 0px"/>
                <input type="hidden" name="MM_update" value="form1" />
            </div>
     </form>  
   </div><!-- end .container -->
   <div style="background:#036; width:100%;float:left; padding:5px 0px 5px 0px;">.
		<a href="../ventasmie/ventas_reporte_cuadre_americana.php" style="font-size:11px; margin:0px 10px 0px 0px; line-height:12px;" 
        class="btn btn-info">Ver Cuadre de Caja <br/>Americanas</a>   
		<a href="../ventashnac_mie/ventas_reporte_cuadre_hnac.php" style="font-size:11px; line-height:12px;" 
        class="btn btn-alert">Ver Cuadre de Caja <br/>Nacionales</a>   
   </div><!-- end .container -->
   <div id="mostrar" style="width:100%; float:left">
	<?php
    
    
    if ($totalRows_Recordset3>0 || $totalRows_Recordset1>0) {
        
        
        //-------------------------------------------- VARIABLES CAJA NACIONALES--------------------------
        $pagoSistema3=0;
        $eliminados3=0;
        $totalventa3=0;
        $totalPagado3=0;
        $invalidados3=0;
        $porPagarTaquilla3=0;
        $ctaJugada3=0;
        $semAnt="";
        if ($totalRows_Recordset3>0) { //-------------------------------------------- CAJA NACIONALES--------------------------
            do {
                $pago=0;
                $pa[0]=0;
                $pa[1]="";
                $aE1=0;
                list($pDia, $uDia, $semana)=semana($row_Recordset3['fec_venta_hnac']);
                if ($semAnt!=$semana && $row_Recordset3['est_cierre_hnac']!=0
                        && $row_Recordset3['est_ticket_hnac']!=0) {
                    $ctaJugada=BuscarTicketVendidosHNAC($codigoTaquilla, $row_Recordset3['id_usuario'], $pDia, $uDia);
                    $semAnt=$semana;
                    if ($ctaJugada>=$canJugada) {
                        $pagoSistema3=$pagoSistema3+500;
                    }
                }
                if ($row_Recordset3['est_ticket_hnac']==1 && $row_Recordset3['est_cierre_hnac']!=0) {
                    list($a1, $a2, $aE1, $t1)=
                        buscaDivTaquilla(
                            $row_Recordset3['cod_carrera_hnac'],
                            $row_Recordset3['fec_carrera_hnac'],
                            $row_Recordset3['cod_taquilla'],
                            1,
                            11
                        );
                    list($b1, $b2, $aE3, $t3)=
                        buscaDivTaquilla(
                            $row_Recordset3['cod_carrera_hnac'],
                            $row_Recordset3['fec_carrera_hnac'],
                            $row_Recordset3['cod_taquilla'],
                            1,
                            21
                        );
                    $query_Recordset21 = sprintf(
                        "/* PARSEADORES1 ventashnac_mie\ventas_reporte_cuadre_combinado - Copia.php - QUERY 8 */ SELECT resultados_hnac.div_pago_hnac, inscritos.est_favorito_hnac,
								 resultados_hnac.num_caballo_hnac
							FROM 
							resultados_hnac,
							inscritos 
							WHERE
							resultados_hnac.cod_carrera_hnac = inscritos.cod_carrera_hnac AND
							resultados_hnac.num_caballo_hnac = inscritos.num_caballo_hnac AND
							resultados_hnac.num_caballo_hnac = %s AND
							resultados_hnac.cod_carrera_hnac = %s AND
							resultados_hnac.fec_resultado_hnac = %s AND
							resultados_hnac.cod_taquilla = %s AND
							resultados_hnac.cod_tventa_hnac = %s",
                        GetSQLValueString($row_Recordset3['num_caballo_hnac'], "text"),
                        GetSQLValueString($row_Recordset3['cod_carrera_hnac'], "int"),
                        GetSQLValueString($row_Recordset3['fec_carrera_hnac'], "date"),
                        GetSQLValueString($row_Recordset3['cod_taquilla'], "int"),
                        GetSQLValueString($row_Recordset3['cod_tventa_hnac'], "int")
                    );
                    $Recordset21 = mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
                    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
                    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
                }
                if ($row_Recordset3['est_ticket_hnac']==1 && $aE1!=0 && $totalRows_Recordset21>0) {
                    if ($row_Recordset3['cod_tventa_hnac']>=1 && $row_Recordset3['cod_tventa_hnac']<=3) {
                        if ($row_Recordset3['num_caballo_hnac']==$row_Recordset21['num_caballo_hnac']) {
                            $pago=($row_Recordset21['div_pago_hnac']/10)*$row_Recordset3['mon_venta_hnac'];
                        }
                    }
                    if ($row_Recordset3['cod_tventa_hnac']>=4 && $row_Recordset3['cod_tventa_hnac']<=9) {
                    }
                    $porPagarTaquilla3=$porPagarTaquilla3+$pago;
                    $pago=0;
                }
                if ($row_Recordset3['est_cierre_hnac']==0 && $row_Recordset3['est_ticket_hnac']==1) {
                    $invalidados3=$invalidados3+$row_Recordset3['mon_venta_hnac'];
                    $porPagarTaquilla3=$porPagarTaquilla3+$row_Recordset3['mon_venta_hnac'];
                }
                if ($row_Recordset3['est_ticket_hnac']==2 && $row_Recordset3['fec_pago_hnac']>=$in &&
                        $row_Recordset3['fec_pago_hnac']<=$fi) {
                    $pago=0;
                    $pa[0]=0;
                    $pa[1]="";
                    if ($row_Recordset3['cod_tventa_hnac']>=1 && $row_Recordset3['cod_tventa_hnac']<=3) {
                        $pago=($row_Recordset3['div_pago_hnac']/10)*$row_Recordset3['mon_venta_hnac'];
                    }
                    if ($row_Recordset3['cod_tventa_hnac']>=4 && $row_Recordset3['cod_tventa_hnac']<=9) {
                    }
                }
                if (($row_Recordset3['est_ticket_hnac']==4 || $row_Recordset3['est_ticket_hnac']==5)
                        && $row_Recordset3['fec_pago_hnac']>=$in && $row_Recordset3['fec_pago_hnac']<=$fi) {
                    $invalidados3=$invalidados3+$row_Recordset3['mon_venta_hnac'];
                }
                if ($row_Recordset3['est_ticket_hnac']==0 && $row_Recordset3['fec_pago_hnac']>=$in &&
                        $row_Recordset3['fec_pago_hnac']<=$fi) {
                    $eliminados3=$eliminados3+$row_Recordset3['mon_venta_hnac'];
                }
                $totalPagado3=$totalPagado3+$pago;
                if ($row_Recordset3['fec_venta_hnac']>=$in && $row_Recordset3['fec_venta_hnac']<=$fi) {
                    $totalventa3=$row_Recordset3['mon_venta_hnac']+$totalventa3;
                }
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
        } //-------------------------------------------- CAJA NACIONALES--------------------------
        $totInvaCanc3=$invalidados3+$eliminados3;
        $totalGeneral3=$totalventa3-($totalPagado3+$totInvaCanc3);
        //-------------------------------------------- FIN CAJA NACIONALES--------------------------
        //-------------------------------------------- INICIO CAJA AMERICANAS--------------------------
        $eliminados=0;
        $totalventa=0;
        $totalPagado=0;
        $invalidados=0;
        $porPagarTaquilla=0;
        $porcTaquilla=0;
        if ($totalRows_Recordset1>0) { //-------------------------------------------- CAJA AMERICANAS--------------------------
            $porcTaquilla=$row_Recordset1['por_taquilla'];
            do {
                $pago=0;
                $pa[0]=0;
                $pa[1]="";
                if ($row_Recordset1['est_ticket']==1 && $row_Recordset1['est_confirmacion']==0) {
                    if ($row_Recordset1['cod_tventa']>=1 && $row_Recordset1['cod_tventa']<=3) {
                        if ($row_Recordset1['cod_tventa']==1) {
                            $topJugada=$row_Recordset1['max_aganar_gan'];
                            $regalo=$row_Recordset1['reg_gan'];
                        }
                        if ($row_Recordset1['cod_tventa']==2) {
                            $topJugada=$row_Recordset1['max_aganar_pla'];
                            $regalo=$row_Recordset1['reg_pla'];
                        }
                        if ($row_Recordset1['cod_tventa']==3) {
                            $topJugada=$row_Recordset1['max_aganar_sho'];
                            $regalo=$row_Recordset1['reg_sho'];
                        }
                        $pa=jNormal(
                            $row_Recordset1['num_caballo'],
                            $row_Recordset1['cod_tventa'],
                            $row_Recordset1['mon_venta'],
                            $row_Recordset1['eje_primero'],
                            $row_Recordset1['eje_doble_primero'],
                            $row_Recordset1['eje_triple_primero'],
                            $row_Recordset1['div_primero_gan'],
                            $row_Recordset1['div_primero_pla'],
                            $row_Recordset1['div_primero_sho'],
                            $row_Recordset1['div_doble_primero_gan'],
                            $row_Recordset1['div_doble_primero_pla'],
                            $row_Recordset1['div_doble_primero_sho'],
                            $row_Recordset1['div_triple_primero_gan'],
                            $row_Recordset1['div_triple_primero_pla'],
                            $row_Recordset1['div_triple_primero_sho'],
                            $row_Recordset1['eje_segundo'],
                            $row_Recordset1['eje_doble_segundo'],
                            $row_Recordset1['eje_triple_segundo'],
                            $row_Recordset1['div_segundo_pla'],
                            $row_Recordset1['div_segundo_sho'],
                            $row_Recordset1['div_doble_segundo_pla'],
                            $row_Recordset1['div_doble_segundo_sho'],
                            $row_Recordset1['div_triple_segundo_pla'],
                            $row_Recordset1['div_triple_segundo_sho'],
                            $row_Recordset1['eje_tercero'],
                            $row_Recordset1['eje_doble_tercero'],
                            $row_Recordset1['eje_triple_tercero'],
                            $row_Recordset1['div_tercero_sho'],
                            $row_Recordset1['div_doble_tercero_sho'],
                            $row_Recordset1['div_triple_tercero_sho'],
                            $topJugada,
                            $regalo
                        );
                        $pago=$pa[0];
                    }
                    if ($row_Recordset1['cod_tventa']>=4 && $row_Recordset1['cod_tventa']<=9) {
                        if ($row_Recordset1['cod_tventa']==4 || $row_Recordset1['cod_tventa']==7) {
                            $fact=$row_Recordset1['fac_exacta'];
                            $topJugada=$row_Recordset1['max_aganar_exa'];
                            $regalo=$row_Recordset1['reg_exa'];
                        }
                        if ($row_Recordset1['cod_tventa']==5 || $row_Recordset1['cod_tventa']==8) {
                            $fact=$row_Recordset1['fac_trifecta'];
                            $topJugada=$row_Recordset1['max_aganar_tri'];
                            $regalo=$row_Recordset1['reg_tri'];
                        }
                        if ($row_Recordset1['cod_tventa']==6 || $row_Recordset1['cod_tventa']==9) {
                            $fact=$row_Recordset1['fac_superfecta'];
                            $topJugada=$row_Recordset1['max_aganar_sup'];
                            $regalo=$row_Recordset1['reg_sup'];
                        }
                        $base=2;
                        $pa=jExotica2(
                            $row_Recordset1['num_caballo'],
                            $row_Recordset1['cod_tventa'],
                            $row_Recordset1['mon_venta'],
                            $row_Recordset1['div_exacta'],
                            $row_Recordset1['ord_exacta'],
                            $row_Recordset1['div_trifecta'],
                            $row_Recordset1['ord_trifecta'],
                            $row_Recordset1['div_superfecta'],
                            $row_Recordset1['ord_superfecta'],
                            $row_Recordset1['div_exacta_doble'],
                            $row_Recordset1['ord_exacta_doble'],
                            $row_Recordset1['div_trifecta_doble'],
                            $row_Recordset1['ord_trifecta_doble'],
                            $row_Recordset1['div_superfecta_doble'],
                            $row_Recordset1['ord_superfecta_doble'],
                            $row_Recordset1['div_exacta_triple'],
                            $row_Recordset1['ord_exacta_triple'],
                            $row_Recordset1['div_trifecta_triple'],
                            $row_Recordset1['ord_trifecta_triple'],
                            $row_Recordset1['div_superfecta_triple'],
                            $row_Recordset1['ord_superfecta_triple'],
                            $topJugada,
                            $regalo,
                            $fact,
                            $base
                        );
                        $pago=$pa[0];
                    }
                    $porPagarTaquilla=$porPagarTaquilla+$pago;
                    $pago=0;
                }
                if ($row_Recordset1['est_ticket']==2) {
                    //$topJugada=20;
                    //$regalo=0;
                    $pago=0;
                    $pa[0]=0;
                    $pa[1]="";
                    if ($row_Recordset1['est_ticket']==2 && $row_Recordset1['fec_pago']>=$in && $row_Recordset1['fec_pago']<=$fi) {
                        if ($row_Recordset1['cod_tventa']==1) {
                            $topJugada=$row_Recordset1['max_aganar_gan'];
                            $regalo=$row_Recordset1['reg_gan'];
                        }
                        if ($row_Recordset1['cod_tventa']==2) {
                            $topJugada=$row_Recordset1['max_aganar_pla'];
                            $regalo=$row_Recordset1['reg_pla'];
                        }
                        if ($row_Recordset1['cod_tventa']==3) {
                            $topJugada=$row_Recordset1['max_aganar_sho'];
                            $regalo=$row_Recordset1['reg_sho'];
                        }
                        $pa=jNormal(
                            $row_Recordset1['num_caballo'],
                            $row_Recordset1['cod_tventa'],
                            $row_Recordset1['mon_venta'],
                            $row_Recordset1['eje_primero'],
                            $row_Recordset1['eje_doble_primero'],
                            $row_Recordset1['eje_triple_primero'],
                            $row_Recordset1['div_primero_gan'],
                            $row_Recordset1['div_primero_pla'],
                            $row_Recordset1['div_primero_sho'],
                            $row_Recordset1['div_doble_primero_gan'],
                            $row_Recordset1['div_doble_primero_pla'],
                            $row_Recordset1['div_doble_primero_sho'],
                            $row_Recordset1['div_triple_primero_gan'],
                            $row_Recordset1['div_triple_primero_pla'],
                            $row_Recordset1['div_triple_primero_sho'],
                            $row_Recordset1['eje_segundo'],
                            $row_Recordset1['eje_doble_segundo'],
                            $row_Recordset1['eje_triple_segundo'],
                            $row_Recordset1['div_segundo_pla'],
                            $row_Recordset1['div_segundo_sho'],
                            $row_Recordset1['div_doble_segundo_pla'],
                            $row_Recordset1['div_doble_segundo_sho'],
                            $row_Recordset1['div_triple_segundo_pla'],
                            $row_Recordset1['div_triple_segundo_sho'],
                            $row_Recordset1['eje_tercero'],
                            $row_Recordset1['eje_doble_tercero'],
                            $row_Recordset1['eje_triple_tercero'],
                            $row_Recordset1['div_tercero_sho'],
                            $row_Recordset1['div_doble_tercero_sho'],
                            $row_Recordset1['div_triple_tercero_sho'],
                            $topJugada,
                            $regalo
                        );
                        $pago=$pa[0];
                    }
                    if ($row_Recordset1['cod_tventa']>=4 && $row_Recordset1['cod_tventa']<=9) {
                        if ($row_Recordset1['cod_tventa']==4 || $row_Recordset1['cod_tventa']==7) {
                            $fact=$row_Recordset1['fac_exacta'];
                            $topJugada=$row_Recordset1['max_aganar_exa'];
                            $regalo=$row_Recordset1['reg_exa'];
                        }
                        if ($row_Recordset1['cod_tventa']==5 || $row_Recordset1['cod_tventa']==8) {
                            $fact=$row_Recordset1['fac_trifecta'];
                            $topJugada=$row_Recordset1['max_aganar_tri'];
                            $regalo=$row_Recordset1['reg_tri'];
                        }
                        if ($row_Recordset1['cod_tventa']==6 || $row_Recordset1['cod_tventa']==9) {
                            $fact=$row_Recordset1['fac_superfecta'];
                            $topJugada=$row_Recordset1['max_aganar_sup'];
                            $regalo=$row_Recordset1['reg_sup'];
                        }
                        $base=2;
                        $pa=jExotica2(
                            $row_Recordset1['num_caballo'],
                            $row_Recordset1['cod_tventa'],
                            $row_Recordset1['mon_venta'],
                            $row_Recordset1['div_exacta'],
                            $row_Recordset1['ord_exacta'],
                            $row_Recordset1['div_trifecta'],
                            $row_Recordset1['ord_trifecta'],
                            $row_Recordset1['div_superfecta'],
                            $row_Recordset1['ord_superfecta'],
                            $row_Recordset1['div_exacta_doble'],
                            $row_Recordset1['ord_exacta_doble'],
                            $row_Recordset1['div_trifecta_doble'],
                            $row_Recordset1['ord_trifecta_doble'],
                            $row_Recordset1['div_superfecta_doble'],
                            $row_Recordset1['ord_superfecta_doble'],
                            $row_Recordset1['div_exacta_triple'],
                            $row_Recordset1['ord_exacta_triple'],
                            $row_Recordset1['div_trifecta_triple'],
                            $row_Recordset1['ord_trifecta_triple'],
                            $row_Recordset1['div_superfecta_triple'],
                            $row_Recordset1['ord_superfecta_triple'],
                            $topJugada,
                            $regalo,
                            $fact,
                            $base
                        );
                        $pago=$pa[0];
                    }
                }
                if (($row_Recordset1['est_ticket']==4 || $row_Recordset1['est_ticket']==5)  && $row_Recordset1['fec_pago']>=$in
                    && $row_Recordset1['fec_pago']<=$fi) {
                    //$pago=$row_Recordset1['mon_venta'];
                    $invalidados=$invalidados+$row_Recordset1['mon_venta'];
                }
                if ($row_Recordset1['est_ticket']==0 && $row_Recordset1['fec_pago']>=$in && $row_Recordset1['fec_pago']<=$fi) {
                    $eliminados=$eliminados+$row_Recordset1['mon_venta'];
                }
                $totalPagado=$totalPagado+$pago;
                if ($row_Recordset1['fec_venta']>=$in && $row_Recordset1['fec_venta']<=$fi) {
                    $totalventa=$row_Recordset1['mon_venta']+$totalventa;
                }
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        }//-------------------------------------------- CAJA AMERICANAS--------------------------
        $totInvaCanc=$invalidados+$eliminados;
        $totalGeneral=$totalventa-($totalPagado+$totInvaCanc);
        $pagoSistema=(($totalventa-$totInvaCanc)*$porcTaquilla)/100;
        
        
        $toVentC=$totalventa3+$totalventa;
        $toPagaC=$totalPagado3+$totalPagado;
        $toInCaC=$totInvaCanc3+$totInvaCanc;
        $pagoSiC=$pagoSistema3+$pagoSistema;
        $xPagTaC=$porPagarTaquilla3+$porPagarTaquilla;
        $toGeneC=$totalGeneral3+$totalGeneral; ?>
     <div style="width:100; float:left; padding:0px 0px 0px 10px">
             <div id="imprime" style="float:left;">
               <table width="265" border="0">
                  <tr>
                    <td height="25" colspan="2" align="center" valign="bottom">TAQUILLA:<?php echo $taquillaV."<br>"; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">VENDEDOR:<?php echo $vendedor."<br>"; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">DESDE:<?php echo $inicio."<br>"; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">HASTA:<?php echo $final."<br>"; ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">HORA:<?php echo horaactual() ?></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><strong>CUADRE <br/> AMERICANAS NACIONALES</strong></td>
                  </tr>
                  <tr>
                    <td width="135" align="right">VENTAS:</td>
                    <td width="116" align="right" bgcolor="#DADADA"><?php echo number_format($toVentC, 2, ",", "."); ?></td>
                  </tr>
                  <tr>
                    <td align="right">PREMIOS:</td>
                    <td align="right" bgcolor="#DADADA"><?php echo number_format($toPagaC, 2, ",", "."); ?></td>
                  </tr>
                  <tr>
                    <td align="right">INVAL/CANC/ANUL:</td>
                    <td align="right" bgcolor="#DADADA"> <?php echo number_format($toInCaC, 2, ",", "."); ?></td>
                  </tr>
                  <tr>
                    <td align="right">DINERO EN CAJA:</td>
                    <td align="right" bgcolor="#E8E8E8">
               	    <strong><?php echo number_format($toGeneC, 2, ",", "."); ?></strong></td>
                  </tr>
                  <tr>
                    <td height="3" colspan="2" align="right" style="font-size:1px; background:#036"></td>
                  </tr>
                  <tr>
                    <td align="right" style="font-size:12px"><?php //echo "TICKETS PENDIENTES POR PAGAR:";?></td>
                    <td align="right" bgcolor="#E8E8E8"><?php //echo number_format($xPagTaC,2,",",".");?></td>
                  </tr>
                  <tr>
                    <td height="2" colspan="2" align="right" bgcolor="#CCCCCC" style="color:#000">
                    Cantidad de apuestas en taquilla: <?php echo $ctaJugada3; ?>
                    </td>
                  </tr>
                  <tr>
                    <td height="35" align="right" bgcolor="#CCCCCC" style="color:#000">COSTO DEL SISTEMA:</td>
                    <td align="right" bgcolor="#CCCCCC" style="color:#000"><?php echo number_format($pagoSiC, 2, ",", "."); ?></td>
                  </tr>
                  <tr>
                    <td height="10" colspan="2" align="right" bgcolor="#FFFFFF">
                    </td>
                  </tr>
                </table>
            </div>
	 </div>
     <div style="background: #333; width:98%; float:left; color:#FFF; text-align:right; font-size:16px; padding:5px 10px 5px 5px">
          	<a href="javascript:imprSelec('imprime')" class="btn btn-success">Imprimir</a>
     </div><!-- end .container -->
        <?php
    } else {?>
        <h4 style="text-align:left; padding:0px 0px 0px 15px">No existen datos</h4>
        <?php }?>  
   </div><!-- end .mostrar -->
</body>
</html>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset2);
mysqli_free_result($Recordset3);
?>
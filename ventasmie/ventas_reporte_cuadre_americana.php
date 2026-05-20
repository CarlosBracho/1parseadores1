<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
include("../includes/calculodepago.php");
$MM_authorizedUsers = "U";
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventasmie\ventas_reporte_cuadre_americana.php - QUERY 1 */ SELECT * 
FROM 
agencia, 
taquilla,
taquilla_opc_ame, 
carrera,
usuario,
venta 

WHERE
usuario.cod_taquilla = taquilla.cod_taquilla AND
usuario.id_usuario = venta.id_usuario AND
(venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s AND venta.fec_pago <= %s) AND 
taquilla.cod_agencia = agencia.cod_agencia AND 
taquilla.cod_taquilla = venta.cod_taquilla AND
taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
venta.cod_carrera = carrera.cod_carrera AND
usuario.id_usuario = %s 
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
$vendedor=strtoupper($row_Recordset1['nom_usuario']);
$taquillaV=$row_Recordset1['nom_taquilla'];
echo $row_Recordset1['num_ticketAME'];
echo "MM_update";
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
                    "/* PARSEADORES1 ventasmie\ventas_reporte_cuadre_americana.php - QUERY 2 */ SELECT * 
				FROM 
				agencia, 
				taquilla,
				taquilla_opc_ame, 
				carrera,
				usuario,
				venta 
USE INDEX(id_us_fe_fe)
				WHERE
				usuario.cod_taquilla = taquilla.cod_taquilla AND
				usuario.id_usuario = venta.id_usuario AND
				(venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s AND venta.fec_pago <= %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND 
				taquilla.cod_taquilla = venta.cod_taquilla AND
				taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND
				usuario.id_usuario = %s 
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
                $vendedor=strtoupper($row_Recordset1['nom_usuario']);
                $taquillaV=$row_Recordset1['nom_taquilla'];
            } else {
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 ventasmie\ventas_reporte_cuadre_americana.php - QUERY 3 */ SELECT * 
				FROM 
				agencia, 
				taquilla,
				taquilla_opc_ame, 
				carrera,
				usuario,
				venta 

				WHERE
				usuario.cod_taquilla = taquilla.cod_taquilla AND
				usuario.id_usuario = venta.id_usuario AND
				(venta.fec_venta >= %s AND venta.fec_venta <= %s OR venta.fec_pago >= %s AND venta.fec_pago <= %s) AND 
				taquilla.cod_agencia = agencia.cod_agencia AND 
				taquilla.cod_taquilla = venta.cod_taquilla AND
				taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND
				venta.cod_carrera = carrera.cod_carrera AND
				taquilla.cod_taquilla=%s 
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
                $vendedor="TODOS";
                $taquillaV=$row_Recordset1['nom_taquilla'];
            }
        }
    }
}
$query_Recordset2 = sprintf("/* PARSEADORES1 ventasmie\ventas_reporte_cuadre_americana.php - QUERY 4 */ SELECT * FROM usuario 
	WHERE usuario.cod_taquilla = %s AND tip_usuario='U' ORDER BY usuario.nom_usuario", GetSQLValueString($codigoTaquilla, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link href="../estilo/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<title>.:Apuestas Hípicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72">
</object>
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script language="vbscript">
function doPrint()
	document.all.item("noprint").style.display="none"
	document.all.item("noprint1").style.display="none"
	document.all.item("noprint2").style.display="none"
	document.all.item("noprint3").style.display="none"
	document.all.item("noprint6").style.display="none"
	document.all.item("noprint7").style.display="none"
	document.all.item()
	with factory.printing
	.header = ""
	.footer = ""
	.topMargin = 0.4
	.bottomMargin = 0.4
	.leftMargin = 0.4
	.rightMargin = 0.4
	.Print(false)
	end with
	document.all.item("noprint").style.display=""
	document.all.item("noprint1").style.display=""
	document.all.item("noprint2").style.display=""
	document.all.item("noprint3").style.display=""
	document.all.item("noprint6").style.display=""
	document.all.item("noprint7").style.display=""
end function
</script>
<script LANGUAGE="JavaScript"> var statusEnvio = false; function chequearEnvio() {if (!statusEnvio) { statusEnvio = true; return true;} else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false;}}</script>
</head>
<html>
<body onload="javascript:document.all.cmdPrint.focus();" style="margin:0px; background:#FFFFFF" onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
   <div style="background: #333; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center" id="noprint">
        CUADRE DE CAJA AMERICANAS
   </div><!-- end .container -->
   <div style="background: #FFF; width:100%; float:left; padding:15px 0px 0px 10px;
   		color:#000; font-size:20px; text-align: left" id="noprint1">
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
            <div style="background: #FFF; width:495px; float:left; padding:0px 0px 0px 0px;" id="noprint2">
                Vendedores:
                <select name="id_usuario" style="height:35px; width:280px; margin:0px 0px 0px -4px">
                      <option value="todos" >TODOS</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset2['id_usuario']?>"><?php echo strtoupper($row_Recordset2['nom_usuario']); ?>
               </option>
                      <?php
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                ?>
                    </select>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:35px; margin:3px 0px 0px 0px"/>
                <input type="hidden" name="MM_update" value="form1" />
            </div>
     </form>  
   </div><!-- end .container -->
   <div style="background: #333; width:100%; float:left; text-align:left; padding:5px 0px 5px 0px; margin: 5px 0px 0px 0px;" 
   		id="noprint3">.
		<a href="../ventashnac_mie/ventas_reporte_cuadre_hnac.php" 
        style="font-size:11px; margin:0px 10px 0px 0px; line-height:12px; text-decoration:none" 
        class="btn btn-info">Ver Cuadre de Caja <br/>Nacionales</a>   
		<a href="../ventashnac_mie/ventas_reporte_cuadre_combinado.php" style="font-size:11px; line-height:12px; text-decoration:none" 
        class="btn btn-alert">Ver Cuadre de Caja <br/>Combinado</a>   
   </div><!-- end .container -->
   <div style="width:100%; float:left">
	<?php
$largo=$row_Recordset1['lar_ticket']+1;
    if ($totalRows_Recordset1>0) {
        $eliminados=0;
        $totalventa=0;
        $totalPagado=0;
        $invalidados=0;
        $porPagarTaquilla=0;
        $porcTaquilla=$row_Recordset1['por_taquilla'];
        do {
            $pago=0;
            $pa[0]=0;
            $pa[1]="";
            $anuReg=$row_Recordset1['anu_regalia'];
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
                        $regalo,
                        $anuReg
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
                        $regalo,
                        $anuReg
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
                //if ($row_Recordset1['est_ticket']!=0) {
                $totalventa=$row_Recordset1['mon_venta']+$totalventa;
                //}
            }
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        $totInvaCanc=$invalidados+$eliminados;
        $totalGeneral=$totalventa-($totalPagado+$totInvaCanc);
        $pagoSistema=(($totalventa-$totInvaCanc)*$porcTaquilla)/100; ?>
     <div style="width:100; float:left; padding:0px 0px 0px 10px">
     		<div style="width:100%; float:center;" id="noprint6">.
       </div>
             <div id="printtitle" style="float:left; margin: 0px;">
                TAQUILLA: <?php echo $taquillaV."<br>"; ?>
VENDEDOR: <?php echo $vendedor."<br>"; ?>
DESDE: <?php echo $inicio."<br>"; ?>
HASTA: <?php echo $final."<br>"; ?>
HORA: <?php echo horaactual() ?>
<br/><strong>CUADRE AMERICANA</strong>
<br/>VENTAS: <?php echo number_format($totalventa, 2, ",", "."); ?>
<br/>PREMIOS: <?php echo number_format($totalPagado, 2, ",", "."); ?>
<br/>INVAL/CANC/ANUL: <?php echo number_format($totInvaCanc, 2, ",", "."); ?>
<br/><strong>DINERO EN CAJA: <?php echo number_format($totalGeneral, 2, ",", "."); ?></strong>
                    <?php //echo "TICKETS PENDIENTES POR PAGAR:";?>
                                        <?php //echo number_format($porPagarTaquilla,2,",",".");?>
    <br/>                COSTO DEL SISTEMA: <?php echo number_format($pagoSistema, 2, ",", "."); ?>  <?php for ($i = 0; $i < $largo; ++$i) {?><br/><?php } ?>          </div>
          <br/><br/><br/><br/><br/>.<br/><br/><br/>.
	 </div>

     <div id="noprint7" style="background: #333; width:98%; float:left; color:#FFF; text-align:right; font-size:16px; padding:5px 10px 5px 5px">
          	<a href="javascript:doprint()" class="btn btn-success" style="text-decoration:none">Imprimir</a>
        </div><!-- end .container -->
        <?php
    } else {?>
        	<h4 style="text-align:left">No existen datos</h4>
        <?php }?>  
   </div><!-- end .mostrar -->
</body>
</html>
<?php mysqli_free_result($Recordset1); mysqli_free_result($Recordset2); ?>
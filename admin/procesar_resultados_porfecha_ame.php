<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$ver=0;
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
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
            if (is_file('../includes/calculodepago.php')) {
                include("../includes/calculodepago.php");
            }
            $query_Recordset0 = sprintf("/* PARSEADORES1 admin\procesar_resultados_porfecha_ame.php - QUERY 1 */ SELECT cod_taquilla FROM taquilla");
            $Recordset0 = mysqli_query($conexionbanca, $query_Recordset0) or die(mysqli_error($conexionbanca));
            $row_Recordset0 = mysqli_fetch_assoc($Recordset0);
            $totalRows_Recordset0 = mysqli_num_rows($Recordset0);
            $x=0;
            do {
                $taq=$row_Recordset0['cod_taquilla'];
                $query_Recordset1 = sprintf(
                    "/* PARSEADORES1 admin\procesar_resultados_porfecha_ame.php - QUERY 2 */ SELECT 
					ve.num_caballo, ve.cod_tventa, ve.mon_venta, ve.num_ticket, ve.pag_premio, ve.est_ticket,
					ca.eje_primero, ca.eje_doble_primero, ca.eje_triple_primero, ca.div_primero_gan, ca.div_primero_pla,
					ca.div_primero_sho, ca.div_doble_primero_gan, ca.div_doble_primero_pla, ca.div_doble_primero_sho,
					ca.div_triple_primero_gan, ca.div_triple_primero_pla, ca.div_triple_primero_sho, ca.eje_segundo,
					ca.eje_doble_segundo, ca.eje_triple_segundo, ca.div_segundo_pla, ca.div_segundo_sho,
					ca.div_doble_segundo_pla, ca.div_doble_segundo_sho, ca.div_triple_segundo_pla, ca.div_triple_segundo_sho,
					ca.eje_tercero, ca.eje_doble_tercero, ca.eje_triple_tercero, ca.div_tercero_sho, ca.div_doble_tercero_sho, 
					ca.div_triple_tercero_sho, ca.fac_exacta, ca.fac_trifecta, ca.fac_superfecta, ca.div_exacta, ca.ord_exacta,
					ca.div_trifecta, ca.ord_trifecta, ca.div_superfecta, ca.ord_superfecta, ca.div_exacta_doble, ca.ord_exacta_doble,
					ca.div_trifecta_doble, ca.ord_trifecta_doble, ca.div_superfecta_doble, ca.ord_superfecta_doble, ca.div_exacta_triple,
					ca.ord_exacta_triple, ca.div_trifecta_triple, ca.ord_trifecta_triple, ca.div_superfecta_triple,
					ca.ord_superfecta_triple, ca.cod_carrera, ca.est_confirmacion, tp.anu_regalia, tp.max_aganar_gan, tp.reg_gan,
					tp.max_aganar_pla, tp.reg_pla, tp.max_aganar_sho, tp.reg_sho, tp.max_aganar_exa, tp.reg_exa, tp.max_aganar_tri,
					tp.reg_tri, tp.max_aganar_sup, tp.reg_sup
					FROM 
						venta ve,
						carrera ca, 
						taquilla_opc_ame tp 
					WHERE 
						tp.cod_taquilla = ve.cod_taquilla AND
						ca.cod_carrera = ve.cod_carrera AND
						ve.cod_taquilla = %s AND
						ve.fec_venta >= %s AND ve.fec_venta <= %s AND
						ve.est_ticket != 0
					ORDER BY ca.cod_carrera",
                    GetSQLValueString($taq, "int"),
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date")
                );
                $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
                $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
                $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
                if ($totalRows_Recordset1>0) {
                    do {
                        $codigoCarrera=$row_Recordset1['cod_carrera'];
                        $retirados=arrayRetirados($codigoCarrera);
                        $pago[0]=0;
                        $pago[1]="";
                        $retiro=0;
                        $_nTicket=$row_Recordset1['num_ticket'];
                        $_xPremio=0;
                        $_xEstado=1;
                        if ($retirados[0]!="0") {
                            if (in_array($row_Recordset1['num_caballo'], $retirados, true)) {
                                $retiro=1;
                            }
                            if ((int)$row_Recordset1['cod_tventa']>=4 && (int)$row_Recordset1['cod_tventa']<=9) {
                                $fcab=explode("-", $row_Recordset1['num_caballo']);
                                foreach ($fcab as $mtz1) {
                                    if (in_array($mtz1, $retirados, true)) {
                                        $retiro=1;
                                        break;
                                    }
                                }
                            }
                        }
                        if ($retiro==0) {
                            if ($row_Recordset1['est_confirmacion']==0) {
                                $anuReg=$row_Recordset1['anu_regalia'];
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
                                    $pago=jNormal(
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
                                    if ($pago[0]>0) {
                                        $_xPremio=$pago[0];
                                        $_nTicket=$row_Recordset1['num_ticket'];
                                        $_xEstado=$pago[1];
                                    }
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
                                    $pago=jExotica2(
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
                                    if ($pago[0]>0) {
                                        $_xPremio=$pago[0];
                                        $_xEstado=$pago[1];
                                    }
                                }
                            }
                        }///
                        else {
                            $_xPremio=$row_Recordset1['mon_venta'];
                            $_xEstado=4;
                        }
                        //est_ticket
                        if ($row_Recordset1['est_ticket']==5 or $row_Recordset1['est_ticket']==4) {
                            $_xPremio=$row_Recordset1['mon_venta'];
                            if ($row_Recordset1['est_ticket']==4) {
                                $_xEstado=4;
                            }
                            if ($row_Recordset1['est_ticket']==5) {
                                $_xEstado=5;
                            }
                        }
                        //$sta=$row_Recordset1['est_ticket'];
                        //$pag=$row_Recordset1['pag_premio'];
                        //echo " / #".$_nTicket." antes:".$pag." ahora:".$_xPremio." st antes:".$sta." st ahora:".$_xEstado;
                        //echo $totalRows_Recordset1."<br/>";
                        echo "<br/>-----------------------------------<br/>";
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 admin\procesar_resultados_porfecha_ame.php - QUERY 3 */ UPDATE venta 
							SET est_calculo=%s, pag_premio=%s 
							WHERE num_ticket=%s",
                            GetSQLValueString($_xEstado, "int"),
                            GetSQLValueString($_xPremio, "double"),
                            GetSQLValueString($_nTicket, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                    mysqli_free_result($Recordset1);
                }
            } while ($row_Recordset0 = mysqli_fetch_assoc($Recordset0));
            mysqli_free_result($Recordset0);
            $ver=1;
        }
    }
}
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
   <div style="background: #004D0F; width:100%; float:left; padding:20px 2px 2px 2px; line-height: 1;
   		color:#FFF; font-size:28px; text-align:center" id="noprint">
        PROCESAR TICKET/RESULTADOS <br/>(POR FECHA) 
   </div><!-- end .container -->
   <div style="background: #FFF; width:100%; float:left; padding:15px 0px 0px 10px;
   		color:#000; font-size:20px; text-align: left" id="noprint1">
		<?php
        if ($ver==0) {
            ?>
       <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
            onsubmit="return chequearEnvio();">
            Desde:
            <input name="fecha_inicio" type="text" id="dateArrival1" tabindex="1" style="width:130px; font-size:16px; height:30px"
                title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
            Hasta:    
            <input name="fecha_fin" type="text" id="dateArrival2"  tabindex="2" style="width:130px; font-size:16px; height:30px"
                size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>" />
			<input type="submit" value="Iniciar" class="btn-warning" title="iniciar proceso" onClick="return enviado()"
                 style="width:80px; height:35px; margin:-10px 0px 0px 0px"/>
			<input type="hidden" name="MM_update" value="form1" />
     </form>
	<?php
        } else {
            echo "<br/><br/>Proceso culminado<br/><br/>";
            echo '<a href="procesar_resultados_porfecha_ame.php" class="btn btn-warning" style="width:100px;font-size:18px"> Volver </a>';
        }
    ?>
     <hr/>
   </div><!-- end .container -->
   <div style="width:100%; float:left">
   </div><!-- end .mostrar -->
</body>
</html>

<?php
date_default_timezone_set("America/Puerto_Rico") ;
include("../includes/comprobar_acceso.php");
function ObtenerMontoEjeTaq($codT, $fecV, $numE, $codC, $codA)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 1 */ SELECT SUM(mon_venta_hnac) AS total FROM venta_hnac 
	WHERE 
	cod_taquilla = %s AND
	fec_venta_hnac = %s AND
	num_caballo_hnac = %s AND
	cod_carrera_hnac = %s AND
	cod_tventa_hnac = %s AND
	est_ticket_hnac = 1",
        GetSQLValueString($codT, "int"),
        GetSQLValueString($fecV, "date"),
        GetSQLValueString($numE, "text"),
        GetSQLValueString($codC, "int"),
        GetSQLValueString($codA, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $total=$row_Recordset1['total'];
    mysqli_free_result($Recordset1);
    return $total;
}
$usuarioVenta=$_SESSION['MM_id_usuario'];


$query_Recordset6 = sprintf("/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 2 */ SELECT 
	tn.est_taquilla_hnac, tp.est_venta_ame, ta.tra_codigo, ta.moneda, ta.saldoactual, ta.tipotaquilla, ta.tipo_pago, ta.cod_agencia, ag.tipo_pagoa
	FROM taquilla ta, usuario us, taquilla_opc_ame tp , agencia ag, taquilla_opc_hnac tn 
	WHERE   tn.cod_taquilla = tp.cod_taquilla AND ta.cod_agencia = ag.cod_agencia AND tp.cod_taquilla = us.cod_taquilla AND ta.cod_taquilla = us.cod_taquilla AND us.id_usuario = %s LIMIT 1", GetSQLValueString($usuarioVenta, "int"));
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));



$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);
if (($totalRows_Recordset6>0 && $row_Recordset6['est_taquilla_hnac']==0) or $totalRows_Recordset6<=0) {
    if ($totalRows_Recordset6<=0) {
        $_SESSION['MM_systemO']=4;
    } elseif ($row_Recordset6['est_taquilla_hnac']==0) {
        $_SESSION['MM_systemO']=5;
    }
    $MM_redirectLoginSuccess = "../no_opciones.php";
    header("Location: ".$MM_redirectLoginSuccess);
}
if (isset($Recordset6)) {
    mysqli_free_result($Recordset6);
}

$hor=horaactual();
$fec=fechaactualbd();
$selCarrera="";

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset4 = "/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 3 */ SELECT * FROM mensaje WHERE cod_mensaje = 1";
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
if ($row_Recordset4['est_mensaje']==1) {
    $mensaje1=$row_Recordset4['pri_linea'];
} else {
    $mensaje1="";
}

$query_Recordset44 = sprintf("/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 4 */ SELECT 
	me.mensaje
	FROM agencia ag, taquilla ta, usuario us,  mensajesyalertas me 
	USE INDEX(mostrarhasta)
	WHERE 
	(me.mostrarhasta >= CURDATE()) AND 
    ((tipo = 3 AND ag.cod_banca = me.para)  OR
	(tipo = 2 AND ta.cod_agencia = me.para)  OR
	(tipo = 1 AND ta.cod_taquilla = me.para)) 	
	AND ag.cod_agencia = ta.cod_agencia AND ta.cod_taquilla = us.cod_taquilla AND us.id_usuario = %s 
	
	ORDER BY RAND() LIMIT 1", GetSQLValueString($usuarioVenta, "int"));
$Recordset44 = mysqli_query($conexionbanca, $query_Recordset44) or die(mysqli_error($conexionbanca));
$row_Recordset44 = mysqli_fetch_assoc($Recordset44);
$totalRows_Recordset44 = mysqli_num_rows($Recordset44);
$mensaje44 = trim($row_Recordset44['mensaje']);

$query_Recordset7 = sprintf("/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 5 */ SELECT * FROM ctrol_ventpag_global_hnac WHERE cod_ctrol_ventpag_global_hnac = 1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$cod_control=$row_Recordset7['cod_ctrol_ventpag_global_hnac'];
$est_control_ventas=$row_Recordset7['est_control_ventas_hnac'];//todas las ventas globales
$est_control_pagos=$row_Recordset7['est_control_pagos_hnac']; //todos los pagos globales
$pau_ventas=0;// ventas por carrera

 
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1" && isset($_POST["cod_carrera"]) && $_POST["cod_carrera"]==-1) {
    $_SESSION['MM_mensaje3']="APUESTA NO REALIZADA. Seleccione un hipodromo.";
    $mensaje1="";
}
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1" && isset($_POST["cod_carrera"]) && $_POST["cod_carrera"]!=-1 && $est_control_ventas==0) {
    $_SESSION['selCarrera']=$_POST['cod_carrera'];
    $_SESSION['efectivoOnx']=$_POST['efectivoOn'];
    $fechasistema=fechaactualbd();
    $exito=0;
    $cCab="";
    $_SESSION['MM_mensaje3']="";
    $mensaje1="";
    $menValida="";
    $fueFec=1;
    $fueHor=1;
    $maxCa="";
    $numerotiket2="";
    $query_Recordset1 = sprintf("/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 6 */ SELECT can_caballos_hnac, hor_carrera_hnac, fec_carrera_hnac, est_carrera_hnac, pau_ventas_hnac
		FROM carrera_hnac WHERE cod_carrera_hnac = %s LIMIT 1", GetSQLValueString($_POST['cod_carrera'], "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $tp1=0;
    $ju1=0;
    $tp2=0;
    $ju2=0;
    $tp3=0;
    $ju3=0;
    $tp4=0;
    $ju4=0;
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $cCab=$row_Recordset1['can_caballos_hnac']; // cantidad de caballo
    $canRetirados=cantRetirados_hnac($_POST['cod_carrera']);
    $vanEnCarrera=$row_Recordset1['can_caballos_hnac']-$canRetirados;
    $fechacarrerabd=$row_Recordset1['fec_carrera_hnac'];
    $horacarrerabd=$row_Recordset1['hor_carrera_hnac'];
    $statuscarrerabd=$row_Recordset1['est_carrera_hnac'];
    $pau_ventas=$row_Recordset1['pau_ventas_hnac'];
    $usuarioVenta=$_SESSION['MM_id_usuario'];
    $codigoTaquilla=$_POST["cod_taquilla"];
    $ipVenta=getRealIP();
    $cantTicket=ObtenerNumeroJugada_hnac($usuarioVenta, $fechasistema)+1;
    $numerotiket2=$usuarioVenta.ObtenerUltimaVenta_hnac();
    $serial=generarCodigo(5, $numerotiket2);
    $maxCa=0; // bandera maxima de caballo
    $cabR=0;
    $mCero=0;
    $_POST["monGan1"]=$_POST["monGan1"]/1;
    //$_POST["monPla1"]=$_POST["monPla1"]/1; $_POST["monSho1"]=$_POST["monSho1"]/1; modificado 9 13 septiembre agregue la de abajo
    $_POST["monPla1"]=0;
    $_POST["monSho1"]=0;
    $_POST["monGan2"]=$_POST["monGan2"]/1;
    //$_POST["monPla2"]=$_POST["monPla2"]/1; $_POST["monSho2"]=$_POST["monSho2"]/1; modificado 9 13 septiembre agregue la de abajo
    $_POST["monPla2"]=0;
    $_POST["monSho2"]=0;
    $_POST["monGan3"]=$_POST["monGan3"]/1;
    //$_POST["monPla3"]=$_POST["monPla3"]/1; $_POST["monSho3"]=$_POST["monSho3"]/1; modificado 9 13 septiembre agregue la de abajo
    $_POST["monPla3"]=0;
    $_POST["monSho3"]=0;
    $_POST["monGan4"]=$_POST["monGan4"]/1;
    //$_POST["monPla4"]=$_POST["monPla4"]/1; $_POST["monSho4"]=$_POST["monSho4"]/1; modificado 9 13 septiembre agregue la de abajo
    $_POST["monPla4"]=0;
    $_POST["monSho4"]=0;
    $_POST["numCa11"]=$_POST["numCa11"]/1;
    $_POST["numCa21"]=$_POST["numCa21"]/1;
    $_POST["numCa31"]=$_POST["numCa31"]/1;
    $_POST["numCa41"]=$_POST["numCa41"]/1;
    $_POST["numCa12"]=$_POST["numCa12"]/1;
    $_POST["numCa22"]=$_POST["numCa22"]/1;
    $_POST["numCa32"]=$_POST["numCa32"]/1;
    $_POST["numCa42"]=$_POST["numCa42"]/1;
    $_POST["numCa13"]=$_POST["numCa13"]/1;
    $_POST["numCa23"]=$_POST["numCa23"]/1;
    $_POST["numCa33"]=$_POST["numCa33"]/1;
    $_POST["numCa43"]=$_POST["numCa43"]/1;
    $_POST["numCa14"]=$_POST["numCa14"]/1;
    $_POST["numCa24"]=$_POST["numCa24"]/1;
    $_POST["numCa34"]=$_POST["numCa34"]/1;
    $_POST["numCa44"]=$_POST["numCa44"]/1;
    if (($_POST["numCa11"]=="" || $_POST["numCa11"]<=0) && ($_POST["numCa21"]>0) &&
        ($_POST["numCa31"]=="" || $_POST["numCa31"]<=0) && ($_POST["numCa41"]=="" || $_POST["numCa41"]<=0)) {
        $_POST["numCa11"]=$_POST["numCa21"];
    }
    if (($_POST["numCa11"]=="" || $_POST["numCa11"]<=0) && ($_POST["numCa31"]>0) &&
        ($_POST["numCa21"]=="" || $_POST["numCa21"]<=0) && ($_POST["numCa41"]=="" || $_POST["numCa41"]<=0)) {
        $_POST["numCa11"]=$_POST["numCa31"];
    }
    if (($_POST["numCa11"]=="" || $_POST["numCa11"]<=0) && ($_POST["numCa41"]>0) &&
        ($_POST["numCa21"]=="" || $_POST["numCa21"]<=0) && ($_POST["numCa31"]=="" || $_POST["numCa31"]<=0)) {
        $_POST["numCa11"]=$_POST["numCa41"];
    }
    if (($_POST["numCa12"]=="" || $_POST["numCa12"]<=0) && ($_POST["numCa22"]>0) &&
        ($_POST["numCa32"]=="" || $_POST["numCa32"]<=0) && ($_POST["numCa42"]=="" || $_POST["numCa42"]<=0)) {
        $_POST["numCa12"]=$_POST["numCa22"];
    }
    if (($_POST["numCa12"]=="" || $_POST["numCa12"]<=0) && ($_POST["numCa32"]>0) &&
        ($_POST["numCa22"]=="" || $_POST["numCa22"]<=0) && ($_POST["numCa42"]=="" || $_POST["numCa42"]<=0)) {
        $_POST["numCa12"]=$_POST["numCa32"];
    }
    if (($_POST["numCa12"]=="" || $_POST["numCa12"]<=0) && ($_POST["numCa42"]>0) &&
        ($_POST["numCa22"]=="" || $_POST["numCa22"]<=0) && ($_POST["numCa32"]=="" || $_POST["numCa32"]<=0)) {
        $_POST["numCa12"]=$_POST["numCa42"];
    }
    if (($_POST["numCa13"]=="" || $_POST["numCa13"]<=0) && ($_POST["numCa23"]>0) &&
        ($_POST["numCa33"]=="" || $_POST["numCa33"]<=0) && ($_POST["numCa43"]=="" || $_POST["numCa43"]<=0)) {
        $_POST["numCa13"]=$_POST["numCa23"];
    }
    if (($_POST["numCa13"]=="" || $_POST["numCa13"]<=0) && ($_POST["numCa33"]>0) &&
        ($_POST["numCa23"]=="" || $_POST["numCa23"]<=0) && ($_POST["numCa43"]=="" || $_POST["numCa43"]<=0)) {
        $_POST["numCa13"]=$_POST["numCa33"];
    }
    if (($_POST["numCa13"]=="" || $_POST["numCa13"]<=0) && ($_POST["numCa43"]>0) &&
        ($_POST["numCa23"]=="" || $_POST["numCa23"]<=0) && ($_POST["numCa33"]=="" || $_POST["numCa33"]<=0)) {
        $_POST["numCa13"]=$_POST["numCa43"];
    }
    if (($_POST["numCa14"]=="" || $_POST["numCa14"]<=0) && ($_POST["numCa24"]>0) &&
        ($_POST["numCa34"]=="" || $_POST["numCa34"]<=0) && ($_POST["numCa44"]=="" || $_POST["numCa44"]<=0)) {
        $_POST["numCa14"]=$_POST["numCa24"];
    }
    if (($_POST["numCa14"]=="" || $_POST["numCa14"]<=0) && ($_POST["numCa34"]>0) &&
        ($_POST["numCa24"]=="" || $_POST["numCa24"]<=0) && ($_POST["numCa44"]=="" || $_POST["numCa44"]<=0)) {
        $_POST["numCa14"]=$_POST["numCa34"];
    }
    if (($_POST["numCa14"]=="" || $_POST["numCa14"]<=0) && ($_POST["numCa44"]>0) &&
        ($_POST["numCa24"]=="" || $_POST["numCa24"]<=0) && ($_POST["numCa34"]=="" || $_POST["numCa34"]<=0)) {
        $_POST["numCa14"]=$_POST["numCa44"];
    }
    $exito=0;
    $z=0;
    if ($_POST["numCa11"]>0 && $_POST["numCa11"]!="") { // si esta definido 1er caballo LINEA 1 //inicio permuta 1
        $cabDefinido=1;
        if (isset($_POST["per1"])) {
            $tp1=9;
        } //fin permuta 1
        //superfecta
        if (isset($_POST["numCa11"]) && isset($_POST["numCa21"]) && isset($_POST["numCa31"]) && isset($_POST["numCa41"]) &&
            $_POST["numCa11"]>0 && $_POST["numCa21"]>0 && $_POST["numCa31"]>0 && $_POST["numCa41"]>0) {
            if ($_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa11"]!=$_POST["numCa31"] &&
                $_POST["numCa11"]!=$_POST["numCa41"] && $_POST["numCa21"]!=$_POST["numCa31"] &&
                $_POST["numCa21"]!=$_POST["numCa41"] && $_POST["numCa31"]!=$_POST["numCa41"]) {
                if ($tp1==0) {
                    $tp1=6;
                }
                if ($_POST["numCa11"]<=$cCab && $_POST["numCa21"]<=$cCab && $_POST["numCa31"]<=$cCab &&
                    $_POST["numCa41"]<=$cCab) {
                    $ju1=$_POST["numCa11"]."-".$_POST["numCa21"]."-".$_POST["numCa31"]."-".$_POST["numCa41"];
                } else {
                    $maxCa=1;
                }
            }
        } else {
            if ((isset($_POST["numCa11"]) && isset($_POST["numCa21"]) && isset($_POST["numCa31"]) &&
                ($_POST["numCa11"]>0 && $_POST["numCa21"]>0 && $_POST["numCa31"]>0) &&
                ($_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa11"]!=$_POST["numCa31"] &&
                 $_POST["numCa21"]!=$_POST["numCa31"])) ||
                (isset($_POST["numCa11"]) && isset($_POST["numCa21"]) && isset($_POST["numCa41"]) &&
                ($_POST["numCa11"]>0 && $_POST["numCa21"]>0 && $_POST["numCa41"]>0) &&
                ($_POST["numCa11"]!=$_POST["numCa21"]) && $_POST["numCa11"]!=$_POST["numCa41"] &&
                 $_POST["numCa21"]!=$_POST["numCa41"]) ||
                (isset($_POST["numCa21"]) && isset($_POST["numCa31"]) && isset($_POST["numCa41"]) &&
                ($_POST["numCa21"]>0 && $_POST["numCa31"]>0 && $_POST["numCa41"]>0) &&
                ($_POST["numCa21"]!=$_POST["numCa31"] && $_POST["numCa31"]!=$_POST["numCa41"]) &&
                $_POST["numCa21"]!=$_POST["numCa41"])) {
                if ($tp1==0) {
                    $tp1=5;
                } else {
                    $tp1=$tp1-1;
                }
                if ($_POST["numCa11"]>0 && $_POST["numCa21"]>0 && $_POST["numCa31"]>0 &&
                        $_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa11"]!=$_POST["numCa31"] &&
                        $_POST["numCa21"]!=$_POST["numCa31"]) {
                    if ($_POST["numCa11"]<=$cCab && $_POST["numCa21"]<=$cCab && $_POST["numCa31"]<=$cCab) {
                        $ju1=$_POST["numCa11"]."-".$_POST["numCa21"]."-".$_POST["numCa31"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa11"]>0 && $_POST["numCa31"]>0 && $_POST["numCa41"]>0 &&
                        $_POST["numCa11"]!=$_POST["numCa31"] && $_POST["numCa11"]!=$_POST["numCa41"] &&
                        $_POST["numCa31"]!=$_POST["numCa41"]) {
                    if ($_POST["numCa11"]<=$cCab && $_POST["numCa31"]<=$cCab && $_POST["numCa41"]<=$cCab) {
                        $ju1=$_POST["numCa11"]."-".$_POST["numCa31"]."-".$_POST["numCa41"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa21"]>0 && $_POST["numCa31"]>0 && $_POST["numCa41"]>0 &&
                        $_POST["numCa21"]!=$_POST["numCa31"] && $_POST["numCa31"]!=$_POST["numCa41"] &&
                        $_POST["numCa21"]!=$_POST["numCa41"]) {
                    if ($_POST["numCa21"]<=$cCab && $_POST["numCa31"]<=$cCab && $_POST["numCa41"]<=$cCab) {
                        $ju1=$_POST["numCa21"]."-".$_POST["numCa31"]."-".$_POST["numCa41"];
                    } else {
                        $maxCa=1;
                    }
                }
            } else {
                if ((isset($_POST["numCa11"]) && isset($_POST["numCa21"]) && $_POST["numCa11"]>0 && $_POST["numCa21"]>0 &&
                    $_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa31"]=="" && $_POST["numCa41"]=="") ||
                    (isset($_POST["numCa11"]) && isset($_POST["numCa31"]) && $_POST["numCa11"]>0 && $_POST["numCa31"]>0 &&
                    $_POST["numCa11"]!=$_POST["numCa31"] && $_POST["numCa21"]=="" && $_POST["numCa41"]=="") ||
                    (isset($_POST["numCa11"]) && isset($_POST["numCa41"]) && $_POST["numCa11"]>0 && $_POST["numCa41"]>0 &&
                    $_POST["numCa11"]!=$_POST["numCa41"]&& $_POST["numCa21"]=="" && $_POST["numCa31"]=="") ||
                    (isset($_POST["numCa21"]) && isset($_POST["numCa31"]) && $_POST["numCa21"]>0 && $_POST["numCa31"]>0 &&
                    $_POST["numCa21"]!=$_POST["numCa31"]&& $_POST["numCa11"]=="" && $_POST["numCa41"]=="") ||
                    (isset($_POST["numCa21"]) && isset($_POST["numCa41"]) && $_POST["numCa21"]>0 && $_POST["numCa41"]>0 &&
                    $_POST["numCa21"]!=$_POST["numCa41"]&& $_POST["numCa11"]=="" && $_POST["numCa31"]=="") ||
                    (isset($_POST["numCa31"]) && isset($_POST["numCa41"]) && $_POST["numCa31"]>0 && $_POST["numCa41"]>0) &&
                    $_POST["numCa31"]!=$_POST["numCa41"]&& $_POST["numCa11"]=="" && $_POST["numCa21"]=="") {
                    if ($tp1==0) {
                        $tp1=4;
                    } else {
                        $tp1=$tp1-2;
                    }
                    if ($_POST["numCa11"]>0 && $_POST["numCa21"]>0 &&
                            $_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa31"]=="" && $_POST["numCa41"]=="") {
                        if ($_POST["numCa11"]<=$cCab && $_POST["numCa21"]<=$cCab) {
                            $ju1=$_POST["numCa11"]."-".$_POST["numCa21"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa11"]>0 && $_POST["numCa31"]>0 &&
                            $_POST["numCa11"]!=$_POST["numCa31"] && $_POST["numCa21"]=="" && $_POST["numCa41"]=="") {
                        if ($_POST["numCa11"]<=$cCab && $_POST["numCa31"]<=$cCab) {
                            $ju1=$_POST["numCa11"]."-".$_POST["numCa31"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa11"]>0 && $_POST["numCa41"]>0 &&
                            $_POST["numCa11"]!=$_POST["numCa41"] && $_POST["numCa21"]=="" && $_POST["numCa31"]=="") {
                        if ($_POST["numCa11"]<=$cCab && $_POST["numCa41"]<=$cCab) {
                            $ju1=$_POST["numCa11"]."-".$_POST["numCa41"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa21"]>0 && $_POST["numCa31"]>0 &&
                            $_POST["numCa21"]!=$_POST["numCa31"] && $_POST["numCa11"]=="" && $_POST["numCa41"]=="") {
                        if ($_POST["numCa21"]<=$cCab && $_POST["numCa31"]<=$cCab) {
                            $ju1=$_POST["numCa21"]."-".$_POST["numCa31"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa31"]>0 && $_POST["numCa41"]>0 &&
                            $_POST["numCa31"]!=$_POST["numCa41"] && $_POST["numCa11"]=="" && $_POST["numCa21"]=="") {
                        if ($_POST["numCa31"]<=$cCab && $_POST["numCa41"]<=$cCab) {
                            $ju1=$_POST["numCa31"]."-".$_POST["numCa41"];
                        } else {
                            $maxCa=1;
                        }
                    }
                }
            }
        }
        if ($_POST["numCa11"]>0 && (!isset($_POST["per1"])) && $tp1==0 && $maxCa!=1) {
            if ($_POST["monGan1"]>0 && ($_POST["monPla1"]==0 || $_POST["monPla1"]=="")
                && ($_POST["monSho1"]==0 || $_POST["monSho1"]=="")) {
                $tp1=1;
                if ($_POST["numCa11"]<=$cCab) {
                    $ju1=$_POST["numCa11"];
                }
            } else {
                if ($_POST["monGan1"]>0 && $_POST["monPla1"]>0 && ($_POST["monSho1"]==0 || $_POST["monSho1"]=="")) {
                    $tp1=12;
                    if ($_POST["numCa11"]<=$cCab) {
                        $ju1=$_POST["numCa11"];
                    }
                } else {
                    if ($_POST["monGan1"]>0 && $_POST["monPla1"]>0 && $_POST["monSho1"]>0) {
                        $tp1=123;
                        if ($_POST["numCa11"]<=$cCab) {
                            $ju1=$_POST["numCa11"];
                        }
                    }
                }
            }
            if ($_POST["monPla1"]>0 && ($_POST["monGan1"]==0 || $_POST["monGan1"]=="") &&
                ($_POST["monSho1"]==0 || $_POST["monSho1"]=="")) {
                $tp1=2;
                if ($_POST["numCa11"]<=$cCab) {
                    $ju1=$_POST["numCa11"];
                }
            } else {
                if ($_POST["monPla1"]>0 && $_POST["monSho1"]>0 && ($_POST["monGan1"]==0 || $_POST["monGan1"]=="")) {
                    $tp1=23;
                    if ($_POST["numCa11"]<=$cCab) {
                        $ju1=$_POST["numCa11"];
                    }
                }
            }
            if ($_POST["monGan1"]>0 && ($_POST["monPla1"]==0 || $_POST["monPla1"]=="") && $_POST["monSho1"]>0) {
                $tp1=13;
                if ($_POST["numCa11"]<=$cCab) {
                    $ju1=$_POST["numCa11"];
                }
            } else {
                if (($_POST["monGan1"]==0 || $_POST["monGan1"]=="") && ($_POST["monPla1"]==0 || $_POST["monPla1"]=="") &&
                    $_POST["monSho1"]>0) {
                    $tp1=3;
                    if ($_POST["numCa11"]<=$cCab) {
                        $ju1=$_POST["numCa11"];
                    }
                }
            }
        }
        if ($maxCa==0 && $tp1!=0 && $ju1!=0) {// si no existen ejemplares retirados seleccionados
            if ($tp1==1 || $tp1==2 || $tp1==3 || $tp1==12 || $tp1==13 || $tp1==23 || $tp1==123) {
                list($sRetiro1, )=RetiradosSimple_hnac($_POST['cod_carrera'], $ju1); // verifica estado de retirado
                if ($sRetiro1==0) {
                    if ($tp1==1 && ($_POST["monGan1"]>0 || $_POST["monGan1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monGan1"];
                        $tipo[$z]=1;
                        $z++;
                    }
                    if ($tp1==2 && ($_POST["monPla1"]>0 || $_POST["monPla1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monPla1"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp1==3 && ($_POST["monSho1"]>0 || $_POST["monSho1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monSho1"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp1==12 && ($_POST["monGan1"]>0 || $_POST["monGan1"]!="") &&
                        ($_POST["monPla1"]>0 || $_POST["monPla1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monGan1"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monPla1"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp1==13 && ($_POST["monGan1"]>0 || $_POST["monGan1"]!="") &&
                        ($_POST["monSho1"]>0 || $_POST["monSho1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monGan1"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monSho1"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp1==23 && ($_POST["monPla1"]>0 || $_POST["monPla1"]!="") &&
                        ($_POST["monSho1"]>0 || $_POST["monSho1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monPla1"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monSho1"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp1==123 && ($_POST["monGan1"]>0 || $_POST["monGan1"]!="") &&
                        ($_POST["monPla1"]>0 || $_POST["monPla1"]!="") &&
                        ($_POST["monSho1"]>0 || $_POST["monSho1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monGan1"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monPla1"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monSho1"];
                        $tipo[$z]=3;
                        $z++;
                    }
                } else {
                    $mRet1="[".$ju1."]";
                    $CRet1=1;
                } // mensaje de caballo retirado //////////////////////////
            } else {
                if ($tp1==4 || $tp1==5 || $tp1==6 || $tp1==7 || $tp1==8 || $tp1==9) { //
                    $du=explode("-", $ju1);
                    foreach ($du as $ejem) {
                        list($sRetiro1, )=RetiradosSimple_hnac($_POST['cod_carrera'], $ejem); // verifica estado de retirado
                        if ($sRetiro1==1) {
                            $mRet2="[".$ju1."]";
                            $CRet2=1;
                            break;
                        } // mens caballo retirado /////////////
                    }
                    if ($sRetiro1==0) {
                        if ($_POST["monSho1"]>0) {
                            $monto[$z]=$_POST["monSho1"];
                        }
                        if ($_POST["monPla1"]>0) {
                            $monto[$z]=$_POST["monPla1"];
                        }
                        if ($_POST["monGan1"]>0) {
                            $monto[$z]=$_POST["monGan1"];
                        }
                        $apuesta[$z]=$ju1;
                        $tipo[$z]=$tp1;
                        $z++;
                    }
                }
            }
            if ($sRetiro1==0 && ($_POST["monGan1"]>0 || $_POST["monPla1"]>0 || $_POST["monSho1"]>0)) {
                if ($fechacarrerabd == $FechaTxt && $horacarrerabd > $horaTxt && $statuscarrerabd == 1) {
                    $f=1;
                    $exito=1;
                } else {
                    if ($fechacarrerabd != $FechaTxt) {
                        $fueFec=0;
                    } ////////////////////////////////////////////////////////
                    if ($horacarrerabd < $horaTxt || $statuscarrerabd!= 1) {
                        $fueHor=0;
                    }	/////////////////////////////////
                }
            } else {
                if ($_POST["monGan1"]<=0) {
                    $mMenG=1;
                }	// monto a ganador incorrecto
                if ($_POST["monPla1"]<=0) {
                    $mMenP=1;
                }	// monto a place incorrecto
                if ($_POST["monSho1"]<=0) {
                    $mMenS=1;
                }	// monto a show incorrecto
            }
        } //fin no existen ejemplares retirados seleccionados
        else {
            //$cabR=1;
            if ($_POST["monGan1"]<=0 && $_POST["monPla1"]<=0 && $_POST["monSho1"]<=0) {
                $mCero=1;
            } //monto a ganador incorrecto
            else {
                $cabR=1;
            }
        }//hay caballos retirados/////////////////////////////////////
    } // fin si esta definido 1er caballo
    else {
        $cabDefinido=0;
    } /// no hay caballo definido
    /************************************************************* 2 ************************************************************/
    if ($_POST["numCa12"]>0 && $_POST["numCa12"]!="" && $maxCa!=1) {  // si esta definido 2do caballo LINEA 2//inicio permuta 2
        $cabDefinido=1;
        if (isset($_POST["per2"])) {
            $tp2=9;
        } //fin permuta 1
        //superfecta
        if (isset($_POST["numCa12"]) && isset($_POST["numCa22"]) && isset($_POST["numCa32"]) && isset($_POST["numCa42"]) &&
            $_POST["numCa12"]>0 && $_POST["numCa22"]>0 && $_POST["numCa32"]>0 && $_POST["numCa42"]>0) {
            if ($_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa12"]!=$_POST["numCa32"] &&
                $_POST["numCa12"]!=$_POST["numCa42"] && $_POST["numCa22"]!=$_POST["numCa32"] &&
                $_POST["numCa22"]!=$_POST["numCa42"] && $_POST["numCa32"]!=$_POST["numCa42"]) {
                if ($tp2==0) {
                    $tp2=6;
                }
                if ($_POST["numCa12"]<=$cCab && $_POST["numCa22"]<=$cCab && $_POST["numCa32"]<=$cCab &&
                    $_POST["numCa42"]<=$cCab) {
                    $ju2=$_POST["numCa12"]."-".$_POST["numCa22"]."-".$_POST["numCa32"]."-".$_POST["numCa42"];
                } else {
                    $maxCa=1;
                }
            }
        } else {
            if ((isset($_POST["numCa12"]) && isset($_POST["numCa22"]) && isset($_POST["numCa32"]) &&
                ($_POST["numCa12"]>0 && $_POST["numCa22"]>0 && $_POST["numCa32"]>0) &&
                ($_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa12"]!=$_POST["numCa32"] &&
                 $_POST["numCa22"]!=$_POST["numCa32"])) ||
                (isset($_POST["numCa12"]) && isset($_POST["numCa22"]) && isset($_POST["numCa42"]) &&
                ($_POST["numCa12"]>0 && $_POST["numCa22"]>0 && $_POST["numCa42"]>0) &&
                ($_POST["numCa12"]!=$_POST["numCa22"]) && $_POST["numCa12"]!=$_POST["numCa42"] &&
                 $_POST["numCa22"]!=$_POST["numCa42"]) ||
                (isset($_POST["numCa22"]) && isset($_POST["numCa32"]) && isset($_POST["numCa42"]) &&
                ($_POST["numCa22"]>0 && $_POST["numCa32"]>0 && $_POST["numCa42"]>0) &&
                ($_POST["numCa22"]!=$_POST["numCa32"] && $_POST["numCa32"]!=$_POST["numCa42"]) &&
                $_POST["numCa22"]!=$_POST["numCa42"])) {
                if ($tp2==0) {
                    $tp2=5;
                } else {
                    $tp2=$tp2-1;
                }
                if ($_POST["numCa12"]>0 && $_POST["numCa22"]>0 && $_POST["numCa32"]>0 &&
                        $_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa12"]!=$_POST["numCa32"] &&
                        $_POST["numCa22"]!=$_POST["numCa32"]) {
                    if ($_POST["numCa12"]<=$cCab && $_POST["numCa22"]<=$cCab && $_POST["numCa32"]<=$cCab) {
                        $ju2=$_POST["numCa12"]."-".$_POST["numCa22"]."-".$_POST["numCa32"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa12"]>0 && $_POST["numCa32"]>0 && $_POST["numCa42"]>0 &&
                        $_POST["numCa12"]!=$_POST["numCa32"] && $_POST["numCa12"]!=$_POST["numCa42"] &&
                        $_POST["numCa32"]!=$_POST["numCa42"]) {
                    if ($_POST["numCa12"]<=$cCab && $_POST["numCa32"]<=$cCab && $_POST["numCa42"]<=$cCab) {
                        $ju2=$_POST["numCa12"]."-".$_POST["numCa32"]."-".$_POST["numCa42"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa22"]>0 && $_POST["numCa32"]>0 && $_POST["numCa42"]>0 &&
                        $_POST["numCa22"]!=$_POST["numCa32"] && $_POST["numCa32"]!=$_POST["numCa42"] &&
                        $_POST["numCa22"]!=$_POST["numCa42"]) {
                    if ($_POST["numCa22"]<=$cCab && $_POST["numCa32"]<=$cCab && $_POST["numCa42"]<=$cCab) {
                        $ju2=$_POST["numCa22"]."-".$_POST["numCa32"]."-".$_POST["numCa42"];
                    } else {
                        $maxCa=1;
                    }
                }
            } else {
                if ((isset($_POST["numCa12"]) && isset($_POST["numCa22"]) && $_POST["numCa12"]>0 && $_POST["numCa22"]>0 &&
                    $_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa32"]=="" && $_POST["numCa42"]=="") ||
                    (isset($_POST["numCa12"]) && isset($_POST["numCa32"]) && $_POST["numCa12"]>0 && $_POST["numCa32"]>0 &&
                    $_POST["numCa12"]!=$_POST["numCa32"] && $_POST["numCa22"]=="" && $_POST["numCa42"]=="") ||
                    (isset($_POST["numCa12"]) && isset($_POST["numCa42"]) && $_POST["numCa12"]>0 && $_POST["numCa42"]>0 &&
                    $_POST["numCa12"]!=$_POST["numCa42"]&& $_POST["numCa22"]=="" && $_POST["numCa32"]=="") ||
                    (isset($_POST["numCa22"]) && isset($_POST["numCa32"]) && $_POST["numCa22"]>0 && $_POST["numCa32"]>0 &&
                    $_POST["numCa22"]!=$_POST["numCa32"]&& $_POST["numCa12"]=="" && $_POST["numCa42"]=="") ||
                    (isset($_POST["numCa22"]) && isset($_POST["numCa42"]) && $_POST["numCa22"]>0 && $_POST["numCa42"]>0 &&
                    $_POST["numCa22"]!=$_POST["numCa42"]&& $_POST["numCa12"]=="" && $_POST["numCa32"]=="") ||
                    (isset($_POST["numCa32"]) && isset($_POST["numCa42"]) && $_POST["numCa32"]>0 && $_POST["numCa42"]>0) &&
                    $_POST["numCa32"]!=$_POST["numCa42"]&& $_POST["numCa12"]=="" && $_POST["numCa22"]=="") {
                    if ($tp2==0) {
                        $tp2=4;
                    } else {
                        $tp2=$tp2-2;
                    }
                    if ($_POST["numCa12"]>0 && $_POST["numCa22"]>0 &&
                            $_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa32"]=="" && $_POST["numCa42"]=="") {
                        if ($_POST["numCa12"]<=$cCab && $_POST["numCa22"]<=$cCab) {
                            $ju2=$_POST["numCa12"]."-".$_POST["numCa22"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa12"]>0 && $_POST["numCa32"]>0 &&
                            $_POST["numCa12"]!=$_POST["numCa32"] && $_POST["numCa22"]=="" && $_POST["numCa42"]=="") {
                        if ($_POST["numCa12"]<=$cCab && $_POST["numCa32"]<=$cCab) {
                            $ju2=$_POST["numCa12"]."-".$_POST["numCa32"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa12"]>0 && $_POST["numCa42"]>0 &&
                            $_POST["numCa12"]!=$_POST["numCa42"] && $_POST["numCa22"]=="" && $_POST["numCa32"]=="") {
                        if ($_POST["numCa12"]<=$cCab && $_POST["numCa42"]<=$cCab) {
                            $ju2=$_POST["numCa12"]."-".$_POST["numCa42"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa22"]>0 && $_POST["numCa32"]>0 &&
                            $_POST["numCa22"]!=$_POST["numCa32"] && $_POST["numCa12"]=="" && $_POST["numCa42"]=="") {
                        if ($_POST["numCa22"]<=$cCab && $_POST["numCa32"]<=$cCab) {
                            $ju2=$_POST["numCa22"]."-".$_POST["numCa32"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa32"]>0 && $_POST["numCa42"]>0 &&
                            $_POST["numCa32"]!=$_POST["numCa42"] && $_POST["numCa12"]=="" && $_POST["numCa22"]=="") {
                        if ($_POST["numCa32"]<=$cCab && $_POST["numCa42"]<=$cCab) {
                            $ju2=$_POST["numCa32"]."-".$_POST["numCa42"];
                        } else {
                            $maxCa=1;
                        }
                    }
                }
            }
        }
        if ($_POST["numCa12"]>0 && (!isset($_POST["per2"])) && $tp2==0 && $maxCa!=1) {
            if ($_POST["monGan2"]>0 && ($_POST["monPla2"]==0 || $_POST["monPla2"]=="")
                && ($_POST["monSho2"]==0 || $_POST["monSho2"]=="")) {
                $tp2=1;
                if ($_POST["numCa12"]<=$cCab) {
                    $ju2=$_POST["numCa12"];
                }
            } else {
                if ($_POST["monGan2"]>0 && $_POST["monPla2"]>0 && ($_POST["monSho2"]==0 || $_POST["monSho2"]=="")) {
                    $tp2=12;
                    if ($_POST["numCa12"]<=$cCab) {
                        $ju2=$_POST["numCa12"];
                    }
                } else {
                    if ($_POST["monGan2"]>0 && $_POST["monPla2"]>0 && $_POST["monSho2"]>0) {
                        $tp2=123;
                        if ($_POST["numCa12"]<=$cCab) {
                            $ju2=$_POST["numCa12"];
                        }
                    }
                }
            }
            if ($_POST["monPla2"]>0 && ($_POST["monGan2"]==0 || $_POST["monGan2"]=="") &&
                ($_POST["monSho2"]==0 || $_POST["monSho2"]=="")) {
                $tp2=2;
                if ($_POST["numCa12"]<=$cCab) {
                    $ju2=$_POST["numCa12"];
                }
            } else {
                if ($_POST["monPla2"]>0 && $_POST["monSho2"]>0 && ($_POST["monGan2"]==0 || $_POST["monGan2"]=="")) {
                    $tp2=23;
                    if ($_POST["numCa12"]<=$cCab) {
                        $ju2=$_POST["numCa12"];
                    }
                }
            }
            if ($_POST["monGan2"]>0 && ($_POST["monPla2"]==0 || $_POST["monPla2"]=="") && $_POST["monSho2"]>0) {
                $tp2=13;
                if ($_POST["numCa12"]<=$cCab) {
                    $ju2=$_POST["numCa12"];
                }
            } else {
                if (($_POST["monGan2"]==0 || $_POST["monGan2"]=="") && ($_POST["monPla2"]==0 || $_POST["monPla2"]=="") &&
                    $_POST["monSho2"]>0) {
                    $tp2=3;
                    if ($_POST["numCa12"]<=$cCab) {
                        $ju2=$_POST["numCa12"];
                    }
                }
            }
        }
        if ($maxCa==0 && $tp2!=0 && $ju2!=0) {// si no existen ejemplares retirados seleccionados
            if ($tp2==1 || $tp2==2 || $tp2==3 || $tp2==12 || $tp2==13 || $tp2==23 || $tp2==123) {
                list($sRetiro2, )=RetiradosSimple_hnac($_POST['cod_carrera'], $ju2); // verifica estado de retirado
                if ($sRetiro2==0) {
                    if ($tp2==1 && ($_POST["monGan2"]>0 || $_POST["monGan2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monGan2"];
                        $tipo[$z]=1;
                        $z++;
                    }
                    if ($tp2==2 && ($_POST["monPla2"]>0 || $_POST["monPla2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monPla2"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp2==3 && ($_POST["monSho2"]>0 || $_POST["monSho2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monSho2"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp2==12 && ($_POST["monGan2"]>0 || $_POST["monGan2"]!="") &&
                        ($_POST["monPla2"]>0 || $_POST["monPla2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monGan2"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monPla2"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp2==13 && ($_POST["monGan2"]>0 || $_POST["monGan2"]!="") &&
                        ($_POST["monSho2"]>0 || $_POST["monSho2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monGan2"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monSho2"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp2==23 && ($_POST["monPla2"]>0 || $_POST["monPla2"]!="") &&
                        ($_POST["monSho2"]>0 || $_POST["monSho2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monPla2"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monSho2"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp2==123 && ($_POST["monGan2"]>0 || $_POST["monGan2"]!="") &&
                        ($_POST["monPla2"]>0 || $_POST["monPla2"]!="") &&
                        ($_POST["monSho2"]>0 || $_POST["monSho2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monGan2"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monPla2"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monSho2"];
                        $tipo[$z]=3;
                        $z++;
                    }
                } else {
                    $mRet3="[".$ju2."]";
                    $CRet3=1;
                } // mensaje de caballo retirado //////////////////////////
            } else {
                if ($tp2==4 || $tp2==5 || $tp2==6 || $tp2==7 || $tp2==8 || $tp2==9) { //
                    $du=explode("-", $ju2);
                    foreach ($du as $ejem) {
                        list($sRetiro2, )=RetiradosSimple_hnac($_POST['cod_carrera'], $ejem); // verifica estado de retirado
                        if ($sRetiro2==1) {
                            $mRet4="[".$ju2."]";
                            $CRet4=2;
                            break;
                        } // mensaje de caballo retirado ////////
                    }
                    if ($sRetiro2==0) {
                        if ($_POST["monSho2"]>0) {
                            $monto[$z]=$_POST["monSho2"];
                        }
                        if ($_POST["monPla2"]>0) {
                            $monto[$z]=$_POST["monPla2"];
                        }
                        if ($_POST["monGan2"]>0) {
                            $monto[$z]=$_POST["monGan2"];
                        }
                        
                        $apuesta[$z]=$ju2;
                        $tipo[$z]=$tp2;
                        $z++;
                    }
                }
            }
            if ($sRetiro2==0 && ($_POST["monGan2"]>0 || $_POST["monPla2"]>0 || $_POST["monSho2"]>0)) {
                if ($fechacarrerabd == $FechaTxt && $horacarrerabd > $horaTxt && $statuscarrerabd == 1) {
                    $f=1;
                    $exito=1;
                } else {
                    if ($fechacarrerabd != $FechaTxt) {
                        $fueFec=0;
                    } ////////////////////////////////////////////////////////
                    if ($horacarrerabd < $horaTxt || $statuscarrerabd!= 1) {
                        $fueHor=0;
                    } ///////////////////////////////////
                }
            } else {
                if ($_POST["monGan2"]<=0) {
                    $mMenG=1;
                }	// monto a ganador incorrecto
                if ($_POST["monPla2"]<=0) {
                    $mMenP=1;
                }	// monto a place incorrecto
                if ($_POST["monSho2"]<=0) {
                    $mMenS=1;
                }	// monto a show incorrecto
            }
        } //fin no existen ejemplares retirados seleccionados
        else {
            //$cabR=1;
            if ($_POST["monGan2"]<=0 && $_POST["monPla2"]<=0 && $_POST["monSho2"]<=0) {
                $mCero=1;
            } //monto a ganador incorrecto
            else {
                $cabR=1;
            }
        }//hay caballos retirados/////////////////////////////////////
    } // fin si esta definido 2DO caballo
    elseif (!isset($cabDefinido)) {
        $cabDefinido=0;
    } /// no hay caballo definido
    /************************************************************* 3 ************************************************************/
    if ($_POST["numCa13"]>0 && $_POST["numCa13"]!="" && $maxCa!=1) {  // si esta definido 3r caballo LINEA 3//inicio permuta 2
        $cabDefinido=1;
        if (isset($_POST["per3"])) {
            $tp3=9;
        } //fin permuta 1
        //superfecta
        if (isset($_POST["numCa13"]) && isset($_POST["numCa23"]) && isset($_POST["numCa33"]) && isset($_POST["numCa43"]) &&
            $_POST["numCa13"]>0 && $_POST["numCa23"]>0 && $_POST["numCa33"]>0 && $_POST["numCa43"]>0) {
            if ($_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa13"]!=$_POST["numCa33"] &&
                $_POST["numCa12"]!=$_POST["numCa43"] && $_POST["numCa23"]!=$_POST["numCa33"] &&
                $_POST["numCa22"]!=$_POST["numCa43"] && $_POST["numCa33"]!=$_POST["numCa43"]) {
                if ($tp3==0) {
                    $tp3=6;
                }
                if ($_POST["numCa13"]<=$cCab && $_POST["numCa23"]<=$cCab && $_POST["numCa33"]<=$cCab &&
                    $_POST["numCa43"]<=$cCab) {
                    $ju3=$_POST["numCa13"]."-".$_POST["numCa23"]."-".$_POST["numCa33"]."-".$_POST["numCa43"];
                } else {
                    $maxCa=1;
                }
            }
        } else {
            if ((isset($_POST["numCa13"]) && isset($_POST["numCa23"]) && isset($_POST["numCa33"]) &&
                ($_POST["numCa13"]>0 && $_POST["numCa23"]>0 && $_POST["numCa33"]>0) &&
                ($_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa13"]!=$_POST["numCa33"] &&
                 $_POST["numCa23"]!=$_POST["numCa33"])) ||
                (isset($_POST["numCa13"]) && isset($_POST["numCa23"]) && isset($_POST["numCa43"]) &&
                ($_POST["numCa13"]>0 && $_POST["numCa23"]>0 && $_POST["numCa43"]>0) &&
                ($_POST["numCa13"]!=$_POST["numCa23"]) && $_POST["numCa13"]!=$_POST["numCa43"] &&
                 $_POST["numCa23"]!=$_POST["numCa43"]) ||
                (isset($_POST["numCa23"]) && isset($_POST["numCa33"]) && isset($_POST["numCa43"]) &&
                ($_POST["numCa23"]>0 && $_POST["numCa33"]>0 && $_POST["numCa43"]>0) &&
                ($_POST["numCa23"]!=$_POST["numCa33"] && $_POST["numCa33"]!=$_POST["numCa43"]) &&
                $_POST["numCa23"]!=$_POST["numCa43"])) {
                if ($tp3==0) {
                    $tp3=5;
                } else {
                    $tp3=$tp3-1;
                }
                if ($_POST["numCa13"]>0 && $_POST["numCa23"]>0 && $_POST["numCa33"]>0 &&
                        $_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa13"]!=$_POST["numCa33"] &&
                        $_POST["numCa23"]!=$_POST["numCa33"]) {
                    if ($_POST["numCa13"]<=$cCab && $_POST["numCa23"]<=$cCab && $_POST["numCa33"]<=$cCab) {
                        $ju3=$_POST["numCa13"]."-".$_POST["numCa23"]."-".$_POST["numCa33"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa13"]>0 && $_POST["numCa33"]>0 && $_POST["numCa43"]>0 &&
                        $_POST["numCa13"]!=$_POST["numCa33"] && $_POST["numCa13"]!=$_POST["numCa43"] &&
                        $_POST["numCa33"]!=$_POST["numCa43"]) {
                    if ($_POST["numCa13"]<=$cCab && $_POST["numCa33"]<=$cCab && $_POST["numCa43"]<=$cCab) {
                        $ju3=$_POST["numCa13"]."-".$_POST["numCa33"]."-".$_POST["numCa43"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa23"]>0 && $_POST["numCa33"]>0 && $_POST["numCa43"]>0 &&
                        $_POST["numCa23"]!=$_POST["numCa33"] && $_POST["numCa33"]!=$_POST["numCa43"] &&
                        $_POST["numCa23"]!=$_POST["numCa43"]) {
                    if ($_POST["numCa23"]<=$cCab && $_POST["numCa33"]<=$cCab && $_POST["numCa43"]<=$cCab) {
                        $ju3=$_POST["numCa23"]."-".$_POST["numCa33"]."-".$_POST["numCa43"];
                    } else {
                        $maxCa=1;
                    }
                }
            } else {
                if ((isset($_POST["numCa13"]) && isset($_POST["numCa23"]) && $_POST["numCa13"]>0 && $_POST["numCa23"]>0 &&
                    $_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa33"]=="" && $_POST["numCa43"]=="") ||
                    (isset($_POST["numCa13"]) && isset($_POST["numCa33"]) && $_POST["numCa13"]>0 && $_POST["numCa33"]>0 &&
                    $_POST["numCa13"]!=$_POST["numCa33"] && $_POST["numCa23"]=="" && $_POST["numCa43"]=="") ||
                    (isset($_POST["numCa13"]) && isset($_POST["numCa43"]) && $_POST["numCa13"]>0 && $_POST["numCa43"]>0 &&
                    $_POST["numCa13"]!=$_POST["numCa43"]&& $_POST["numCa23"]=="" && $_POST["numCa33"]=="") ||
                    (isset($_POST["numCa23"]) && isset($_POST["numCa33"]) && $_POST["numCa23"]>0 && $_POST["numCa33"]>0 &&
                    $_POST["numCa23"]!=$_POST["numCa33"]&& $_POST["numCa13"]=="" && $_POST["numCa43"]=="") ||
                    (isset($_POST["numCa23"]) && isset($_POST["numCa43"]) && $_POST["numCa23"]>0 && $_POST["numCa43"]>0 &&
                    $_POST["numCa23"]!=$_POST["numCa43"]&& $_POST["numCa13"]=="" && $_POST["numCa33"]=="") ||
                    (isset($_POST["numCa33"]) && isset($_POST["numCa43"]) && $_POST["numCa33"]>0 && $_POST["numCa43"]>0) &&
                    $_POST["numCa33"]!=$_POST["numCa43"]&& $_POST["numCa13"]=="" && $_POST["numCa23"]=="") {
                    if ($tp3==0) {
                        $tp3=4;
                    } else {
                        $tp3=$tp3-2;
                    }
                    if ($_POST["numCa13"]>0 && $_POST["numCa23"]>0 &&
                            $_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa33"]=="" && $_POST["numCa43"]=="") {
                        if ($_POST["numCa13"]<=$cCab && $_POST["numCa23"]<=$cCab) {
                            $ju3=$_POST["numCa13"]."-".$_POST["numCa23"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa13"]>0 && $_POST["numCa33"]>0 &&
                            $_POST["numCa13"]!=$_POST["numCa33"] && $_POST["numCa23"]=="" && $_POST["numCa43"]=="") {
                        if ($_POST["numCa13"]<=$cCab && $_POST["numCa33"]<=$cCab) {
                            $ju3=$_POST["numCa13"]."-".$_POST["numCa33"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa13"]>0 && $_POST["numCa43"]>0 &&
                            $_POST["numCa13"]!=$_POST["numCa43"] && $_POST["numCa23"]=="" && $_POST["numCa33"]=="") {
                        if ($_POST["numCa13"]<=$cCab && $_POST["numCa43"]<=$cCab) {
                            $ju3=$_POST["numCa13"]."-".$_POST["numCa43"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa23"]>0 && $_POST["numCa33"]>0 &&
                            $_POST["numCa23"]!=$_POST["numCa33"] && $_POST["numCa13"]=="" && $_POST["numCa43"]=="") {
                        if ($_POST["numCa23"]<=$cCab && $_POST["numCa33"]<=$cCab) {
                            $ju3=$_POST["numCa22"]."-".$_POST["numCa33"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa33"]>0 && $_POST["numCa43"]>0 &&
                            $_POST["numCa33"]!=$_POST["numCa43"] && $_POST["numCa13"]=="" && $_POST["numCa23"]=="") {
                        if ($_POST["numCa33"]<=$cCab && $_POST["numCa43"]<=$cCab) {
                            $ju3=$_POST["numCa33"]."-".$_POST["numCa43"];
                        } else {
                            $maxCa=1;
                        }
                    }
                }
            }
        }
        if ($_POST["numCa13"]>0	&& (!isset($_POST["per3"])) && $tp3==0 && $maxCa!=1) {
            if ($_POST["monGan3"]>0 && ($_POST["monPla3"]==0 || $_POST["monPla3"]=="")
                && ($_POST["monSho3"]==0 || $_POST["monSho3"]=="")) {
                $tp3=1;
                if ($_POST["numCa13"]<=$cCab) {
                    $ju3=$_POST["numCa13"];
                }
            } else {
                if ($_POST["monGan3"]>0 && $_POST["monPla3"]>0 && ($_POST["monSho3"]==0 || $_POST["monSho3"]=="")) {
                    $tp3=12;
                    if ($_POST["numCa13"]<=$cCab) {
                        $ju3=$_POST["numCa13"];
                    }
                } else {
                    if ($_POST["monGan3"]>0 && $_POST["monPla3"]>0 && $_POST["monSho3"]>0) {
                        $tp3=123;
                        if ($_POST["numCa13"]<=$cCab) {
                            $ju3=$_POST["numCa13"];
                        }
                    }
                }
            }
            if ($_POST["monPla3"]>0 && ($_POST["monGan3"]==0 || $_POST["monGan3"]=="") &&
                ($_POST["monSho3"]==0 || $_POST["monSho3"]=="")) {
                $tp3=2;
                if ($_POST["numCa13"]<=$cCab) {
                    $ju3=$_POST["numCa13"];
                }
            } else {
                if ($_POST["monPla3"]>0 && $_POST["monSho3"]>0 && ($_POST["monGan3"]==0 || $_POST["monGan3"]=="")) {
                    $tp3=23;
                    if ($_POST["numCa13"]<=$cCab) {
                        $ju3=$_POST["numCa13"];
                    }
                }
            }
            if ($_POST["monGan3"]>0 && ($_POST["monPla3"]==0 || $_POST["monPla3"]=="") && $_POST["monSho3"]>0) {
                $tp3=13;
                if ($_POST["numCa13"]<=$cCab) {
                    $ju3=$_POST["numCa13"];
                }
            } else {
                if (($_POST["monGan3"]==0 || $_POST["monGan3"]=="") && ($_POST["monPla3"]==0 || $_POST["monPla3"]=="") &&
                    $_POST["monSho3"]>0) {
                    $tp3=3;
                    if ($_POST["numCa13"]<=$cCab) {
                        $ju3=$_POST["numCa13"];
                    }
                }
            }
        }
        if ($maxCa==0 && $tp3!=0 && $ju3!=0) {// si no existen ejemplares retirados seleccionados
            if ($tp3==1 || $tp3==2 || $tp3==3 || $tp3==12 || $tp3==13 || $tp3==23 || $tp3==123) {
                list($sRetiro3, )=RetiradosSimple_hnac($_POST['cod_carrera'], $ju3); // verifica estado de retirado
                if ($sRetiro3==0) {
                    if ($tp3==1 && ($_POST["monGan3"]>0 || $_POST["monGan3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monGan3"];
                        $tipo[$z]=1;
                        $z++;
                    }
                    if ($tp3==2 && ($_POST["monPla3"]>0 || $_POST["monPla3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monPla3"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp3==3 && ($_POST["monSho3"]>0 || $_POST["monSho3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monSho3"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp3==12 && ($_POST["monGan3"]>0 || $_POST["monGan3"]!="") &&
                        ($_POST["monPla3"]>0 || $_POST["monPla3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monGan3"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monPla3"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp3==13 && ($_POST["monGan3"]>0 || $_POST["monGan3"]!="") &&
                        ($_POST["monSho3"]>0 || $_POST["monSho3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monGan3"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monSho3"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp3==23 && ($_POST["monPla3"]>0 || $_POST["monPla3"]!="") &&
                        ($_POST["monSho3"]>0 || $_POST["monSho3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monPla3"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monSho3"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp3==123 && ($_POST["monGan3"]>0 || $_POST["monGan3"]!="") &&
                        ($_POST["monPla3"]>0 || $_POST["monPla3"]!="") &&
                        ($_POST["monSho3"]>0 || $_POST["monSho3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monGan3"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monPla3"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monSho3"];
                        $tipo[$z]=3;
                        $z++;
                    }
                } else {
                    $mRet5="[".$ju3."]";
                    $CRet5=1;
                } // mensaje de caballo retirado //////////////////
            } else {
                if ($tp3==4 || $tp3==5 || $tp3==6 || $tp3==7 || $tp3==8 || $tp3==9) { //
                    $du=explode("-", $ju3);
                    foreach ($du as $ejem) {
                        list($sRetiro3, )=RetiradosSimple_hnac($_POST['cod_carrera'], $ejem); // verifica estado de retirado
                        if ($sRetiro3==1) {
                            $mRet6="[".$ju3."]";
                            $CRet6=1;
                            break;
                        } // mensaje de caballo retirado ////////
                    }
                    if ($sRetiro3==0) {
                        if ($_POST["monSho3"]>0) {
                            $monto[$z]=$_POST["monSho3"];
                        }
                        if ($_POST["monPla3"]>0) {
                            $monto[$z]=$_POST["monPla3"];
                        }
                        if ($_POST["monGan3"]>0) {
                            $monto[$z]=$_POST["monGan3"];
                        }
                        $apuesta[$z]=$ju3;
                        $tipo[$z]=$tp3;
                        $z++;
                    }
                }
            }
            if ($sRetiro3==0 && ($_POST["monGan3"]>0 || $_POST["monPla3"]>0 || $_POST["monSho3"]>0)) {
                if ($fechacarrerabd == $FechaTxt && $horacarrerabd > $horaTxt && $statuscarrerabd == 1) {
                    $f=1;
                    $exito=1;
                } else {
                    if ($fechacarrerabd != $FechaTxt) {
                        $fueFec=0;
                    } //////////////////////////////////////////////////////////
                    if ($horacarrerabd < $horaTxt || $statuscarrerabd!= 1) {
                        $fueHor=0;
                    } /////////////////////////////////////
                }
            } else {
                if ($_POST["monGan3"]<=0) {
                    $mMenG=1;
                }	// monto a ganador incorrecto
                if ($_POST["monPla3"]<=0) {
                    $mMenP=1;
                }	// monto a place incorrecto
                if ($_POST["monSho3"]<=0) {
                    $mMenS=1;
                }	// monto a show incorrecto
            }
        } //fin no existen ejemplares retirados seleccionados
        else {
            //$cabR=1;
            if ($_POST["monGan3"]<=0 && $_POST["monPla3"]<=0 && $_POST["monSho3"]<=0) {
                $mCero=1;
            } //monto a ganador incorrecto
            else {
                $cabR=1;
            }
        }//hay caballos retirados/////////////////////////////////////
    } // fin si esta definido 3r caballo
    elseif (!isset($cabDefinido)) {
        $cabDefinido=0;
    } /// no hay caballo definido
    /************************************************************* 4 ************************************************************/
    if ($_POST["numCa14"]>0 && $_POST["numCa14"]!="" && $maxCa!=1) {  // si esta definido 4o caballo LINEA 4//inicio permuta 2
        $cabDefinido=1;
        if (isset($_POST["per4"])) {
            $tp4=9;
        } //fin permuta 1
        //superfecta
        if (isset($_POST["numCa14"]) && isset($_POST["numCa24"]) && isset($_POST["numCa34"]) && isset($_POST["numCa44"]) &&
            $_POST["numCa14"]>0 && $_POST["numCa24"]>0 && $_POST["numCa34"]>0 && $_POST["numCa44"]>0) {
            if ($_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa14"]!=$_POST["numCa34"] &&
                $_POST["numCa14"]!=$_POST["numCa44"] && $_POST["numCa24"]!=$_POST["numCa34"] &&
                $_POST["numCa24"]!=$_POST["numCa44"] && $_POST["numCa34"]!=$_POST["numCa44"]) {
                if ($tp4==0) {
                    $tp4=6;
                }
                if ($_POST["numCa14"]<=$cCab && $_POST["numCa24"]<=$cCab && $_POST["numCa34"]<=$cCab &&
                    $_POST["numCa44"]<=$cCab) {
                    $ju4=$_POST["numCa14"]."-".$_POST["numCa24"]."-".$_POST["numCa34"]."-".$_POST["numCa44"];
                } else {
                    $maxCa=1;
                }
            }
        } else {
            if ((isset($_POST["numCa14"]) && isset($_POST["numCa24"]) && isset($_POST["numCa34"]) &&
                ($_POST["numCa14"]>0 && $_POST["numCa24"]>0 && $_POST["numCa34"]>0) &&
                ($_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa14"]!=$_POST["numCa34"] &&
                 $_POST["numCa24"]!=$_POST["numCa34"])) ||
                (isset($_POST["numCa14"]) && isset($_POST["numCa24"]) && isset($_POST["numCa44"]) &&
                ($_POST["numCa14"]>0 && $_POST["numCa24"]>0 && $_POST["numCa44"]>0) &&
                ($_POST["numCa14"]!=$_POST["numCa24"]) && $_POST["numCa14"]!=$_POST["numCa44"] &&
                 $_POST["numCa24"]!=$_POST["numCa44"]) ||
                (isset($_POST["numCa24"]) && isset($_POST["numCa34"]) && isset($_POST["numCa44"]) &&
                ($_POST["numCa24"]>0 && $_POST["numCa34"]>0 && $_POST["numCa44"]>0) &&
                ($_POST["numCa24"]!=$_POST["numCa34"] && $_POST["numCa34"]!=$_POST["numCa44"]) &&
                $_POST["numCa24"]!=$_POST["numCa44"])) {
                if ($tp4==0) {
                    $tp4=5;
                } else {
                    $tp4=$tp4-1;
                }
                if ($_POST["numCa14"]>0 && $_POST["numCa24"]>0 && $_POST["numCa34"]>0 &&
                        $_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa14"]!=$_POST["numCa34"] &&
                        $_POST["numCa24"]!=$_POST["numCa34"]) {
                    if ($_POST["numCa14"]<=$cCab && $_POST["numCa24"]<=$cCab && $_POST["numCa34"]<=$cCab) {
                        $ju4=$_POST["numCa14"]."-".$_POST["numCa24"]."-".$_POST["numCa34"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa14"]>0 && $_POST["numCa34"]>0 && $_POST["numCa44"]>0 &&
                        $_POST["numCa14"]!=$_POST["numCa34"] && $_POST["numCa14"]!=$_POST["numCa43"] &&
                        $_POST["numCa34"]!=$_POST["numCa44"]) {
                    if ($_POST["numCa14"]<=$cCab && $_POST["numCa34"]<=$cCab && $_POST["numCa44"]<=$cCab) {
                        $ju4=$_POST["numCa14"]."-".$_POST["numCa34"]."-".$_POST["numCa44"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa24"]>0 && $_POST["numCa34"]>0 && $_POST["numCa44"]>0 &&
                        $_POST["numCa24"]!=$_POST["numCa34"] && $_POST["numCa34"]!=$_POST["numCa44"] &&
                        $_POST["numCa24"]!=$_POST["numCa44"]) {
                    if ($_POST["numCa24"]<=$cCab && $_POST["numCa34"]<=$cCab && $_POST["numCa44"]<=$cCab) {
                        $ju4=$_POST["numCa24"]."-".$_POST["numCa34"]."-".$_POST["numCa44"];
                    } else {
                        $maxCa=1;
                    }
                }
            } else {
                if ((isset($_POST["numCa14"]) && isset($_POST["numCa24"]) && $_POST["numCa14"]>0 && $_POST["numCa24"]>0 &&
                    $_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa34"]=="" && $_POST["numCa44"]=="") ||
                    (isset($_POST["numCa14"]) && isset($_POST["numCa34"]) && $_POST["numCa14"]>0 && $_POST["numCa34"]>0 &&
                    $_POST["numCa14"]!=$_POST["numCa34"] && $_POST["numCa24"]=="" && $_POST["numCa44"]=="") ||
                    (isset($_POST["numCa14"]) && isset($_POST["numCa44"]) && $_POST["numCa14"]>0 && $_POST["numCa44"]>0 &&
                    $_POST["numCa14"]!=$_POST["numCa44"]&& $_POST["numCa24"]=="" && $_POST["numCa34"]=="") ||
                    (isset($_POST["numCa24"]) && isset($_POST["numCa34"]) && $_POST["numCa24"]>0 && $_POST["numCa34"]>0 &&
                    $_POST["numCa24"]!=$_POST["numCa34"]&& $_POST["numCa14"]=="" && $_POST["numCa44"]=="") ||
                    (isset($_POST["numCa24"]) && isset($_POST["numCa44"]) && $_POST["numCa24"]>0 && $_POST["numCa44"]>0 &&
                    $_POST["numCa24"]!=$_POST["numCa44"]&& $_POST["numCa14"]=="" && $_POST["numCa34"]=="") ||
                    (isset($_POST["numCa34"]) && isset($_POST["numCa44"]) && $_POST["numCa34"]>0 && $_POST["numCa44"]>0) &&
                    $_POST["numCa34"]!=$_POST["numCa44"]&& $_POST["numCa14"]=="" && $_POST["numCa24"]=="") {
                    if ($tp4==0) {
                        $tp4=4;
                    } else {
                        $tp4=$tp4-2;
                    }
                    if ($_POST["numCa14"]>0 && $_POST["numCa24"]>0 &&
                            $_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa34"]=="" && $_POST["numCa44"]=="") {
                        if ($_POST["numCa14"]<=$cCab && $_POST["numCa24"]<=$cCab) {
                            $ju4=$_POST["numCa14"]."-".$_POST["numCa24"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa14"]>0 && $_POST["numCa34"]>0 &&
                            $_POST["numCa14"]!=$_POST["numCa34"] && $_POST["numCa24"]=="" && $_POST["numCa44"]=="") {
                        if ($_POST["numCa14"]<=$cCab && $_POST["numCa34"]<=$cCab) {
                            $ju4=$_POST["numCa14"]."-".$_POST["numCa34"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa14"]>0 && $_POST["numCa44"]>0 &&
                            $_POST["numCa14"]!=$_POST["numCa44"] && $_POST["numCa24"]=="" && $_POST["numCa34"]=="") {
                        if ($_POST["numCa14"]<=$cCab && $_POST["numCa44"]<=$cCab) {
                            $ju4=$_POST["numCa14"]."-".$_POST["numCa44"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa24"]>0 && $_POST["numCa34"]>0 &&
                            $_POST["numCa24"]!=$_POST["numCa34"] && $_POST["numCa14"]=="" && $_POST["numCa44"]=="") {
                        if ($_POST["numCa24"]<=$cCab && $_POST["numCa34"]<=$cCab) {
                            $ju4=$_POST["numCa24"]."-".$_POST["numCa34"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa34"]>0 && $_POST["numCa44"]>0 &&
                            $_POST["numCa34"]!=$_POST["numCa44"] && $_POST["numCa14"]=="" && $_POST["numCa24"]=="") {
                        if ($_POST["numCa34"]<=$cCab && $_POST["numCa44"]<=$cCab) {
                            $ju4=$_POST["numCa34"]."-".$_POST["numCa44"];
                        } else {
                            $maxCa=1;
                        }
                    }
                }
            }
        }
        if ($_POST["numCa14"]>0 && (!isset($_POST["per4"])) && $tp4==0 && $maxCa!=1) {
            if ($_POST["monGan4"]>0 && ($_POST["monPla4"]==0 || $_POST["monPla4"]=="")
                && ($_POST["monSho4"]==0 || $_POST["monSho4"]=="")) {
                $tp4=1;
                if ($_POST["numCa14"]<=$cCab) {
                    $ju4=$_POST["numCa14"];
                }
            } else {
                if ($_POST["monGan4"]>0 && $_POST["monPla4"]>0 && ($_POST["monSho4"]==0 || $_POST["monSho4"]=="")) {
                    $tp4=12;
                    if ($_POST["numCa14"]<=$cCab) {
                        $ju4=$_POST["numCa14"];
                    }
                } else {
                    if ($_POST["monGan4"]>0 && $_POST["monPla4"]>0 && $_POST["monSho4"]>0) {
                        $tp4=123;
                        if ($_POST["numCa14"]<=$cCab) {
                            $ju4=$_POST["numCa14"];
                        }
                    }
                }
            }
            if ($_POST["monPla4"]>0 && ($_POST["monGan4"]==0 || $_POST["monGan4"]=="") &&
                ($_POST["monSho4"]==0 || $_POST["monSho4"]=="")) {
                $tp4=2;
                if ($_POST["numCa14"]<=$cCab) {
                    $ju4=$_POST["numCa14"];
                }
            } else {
                if ($_POST["monPla4"]>0 && $_POST["monSho4"]>0 && ($_POST["monGan4"]==0 || $_POST["monGan4"]=="")) {
                    $tp4=23;
                    if ($_POST["numCa14"]<=$cCab) {
                        $ju4=$_POST["numCa14"];
                    }
                }
            }
            if ($_POST["monGan4"]>0 && ($_POST["monPla4"]==0 || $_POST["monPla4"]=="") && $_POST["monSho4"]>0) {
                $tp4=13;
                if ($_POST["numCa14"]<=$cCab) {
                    $ju4=$_POST["numCa14"];
                }
            } else {
                if (($_POST["monGan4"]==0 || $_POST["monGan4"]=="") && ($_POST["monPla4"]==0 || $_POST["monPla4"]=="") &&
                    $_POST["monSho4"]>0) {
                    $tp4=3;
                    if ($_POST["numCa14"]<=$cCab) {
                        $ju4=$_POST["numCa14"];
                    }
                }
            }
        }
        if ($maxCa==0 && $tp4!=0 && $ju4!=0) {// si no existen ejemplares retirados seleccionados
            if ($tp4==1 || $tp4==2 || $tp4==3 || $tp4==12 || $tp4==13 || $tp4==23 || $tp4==123) {
                list($sRetiro4, )=RetiradosSimple_hnac($_POST['cod_carrera'], $ju4); // verifica estado de retirado
                if ($sRetiro4==0) {
                    if ($tp4==1 && ($_POST["monGan4"]>0 || $_POST["monGan4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monGan4"];
                        $tipo[$z]=1;
                        $z++;
                    }
                    if ($tp4==2 && ($_POST["monPla4"]>0 || $_POST["monPla4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monPla4"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp4==3 && ($_POST["monSho4"]>0 || $_POST["monSho4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monSho4"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp4==12 && ($_POST["monGan4"]>0 || $_POST["monGan4"]!="") &&
                        ($_POST["monPla4"]>0 || $_POST["monPla4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monGan4"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monPla4"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp4==13 && ($_POST["monGan4"]>0 || $_POST["monGan4"]!="") &&
                        ($_POST["monSho4"]>0 || $_POST["monSho4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monGan4"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monSho4"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp4==23 && ($_POST["monPla4"]>0 || $_POST["monPla4"]!="") &&
                        ($_POST["monSho4"]>0 || $_POST["monSho4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monPla4"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monSho4"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp4==123 && ($_POST["monGan4"]>0 || $_POST["monGan4"]!="") &&
                        ($_POST["monPla4"]>0 || $_POST["monPla4"]!="") &&
                        ($_POST["monSho4"]>0 || $_POST["monSho4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monGan4"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monPla4"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monSho4"];
                        $tipo[$z]=3;
                        $z++;
                    }
                } else {
                    $mRet7="[".$ju4."]";
                    $CRet7=1;
                } // mensaje de caballo retirado //////////////////////
            } else {
                if ($tp4==4 || $tp4==5 || $tp4==6 || $tp4==7 || $tp4==8 || $tp4==9) { //
                    $du=explode("-", $ju4);
                    foreach ($du as $ejem) {
                        list($sRetiro4, )=RetiradosSimple_hnac($_POST['cod_carrera'], $ejem); // verifica estado de retirado
                        if ($sRetiro4==1) {
                            $mRet8="[".$ju4."]";
                            $CRet8=1;
                            break;
                        } // mensaje de caballo retirado ////////
                    }
                    if ($sRetiro4==0) {
                        if ($_POST["monSho4"]>0) {
                            $monto[$z]=$_POST["monSho4"];
                        }
                        if ($_POST["monPla4"]>0) {
                            $monto[$z]=$_POST["monPla4"];
                        }
                        if ($_POST["monGan4"]>0) {
                            $monto[$z]=$_POST["monGan4"];
                        }
                        $apuesta[$z]=$ju4;
                        $tipo[$z]=$tp4;
                        $z++;
                    }
                }
            }
            if ($sRetiro4==0 && ($_POST["monGan4"]>0 || $_POST["monPla4"]>0 || $_POST["monSho4"]>0)) {
                if ($fechacarrerabd == $FechaTxt && $horacarrerabd > $horaTxt && $statuscarrerabd == 1) {
                    $f=1;
                    $exito=1;
                } else {
                    if ($fechacarrerabd != $FechaTxt) {
                        $fueFec=0;
                    } ///////////////////////////////////////////////////
                    if ($horacarrerabd < $horaTxt || $statuscarrerabd!= 1) {
                        $fueHor=0;
                    } //////////////////////////////
                }
            } else {
                if ($_POST["monGan4"]<=0) {
                    $mMenG=1;
                }	// monto a ganador incorrecto
                if ($_POST["monPla4"]<=0) {
                    $mMenP=1;
                }	// monto a place incorrecto
                if ($_POST["monSho4"]<=0) {
                    $mMenS=1;
                }	// monto a show incorrecto
            }
        } //fin no existen ejemplares retirados seleccionados
        else {
            //$cabR=1;
            if ($_POST["monGan4"]<=0 && $_POST["monPla4"]<=0 && $_POST["monSho4"]<=0) {
                $mCero=1;
            } //monto a ganador incorrecto
            else {
                $cabR=1;
            }
        }//hay caballos retirados/////////////////////////////////////
    } // fin si esta definido 4o caballo
    elseif (!isset($cabDefinido)) {
        $cabDefinido=0;
    } /// no hay caballo definido
//****************************************************************************************************************************
    if ($exito==1 && $maxCa!=1 && $pau_ventas==0) {// guarda e imprime ticket
        $t=0;
        $u=0;
        $apuesta2=$apuesta;
        $tipo2=$tipo;
        $valida=1;
        foreach ($apuesta as $busca) {  //busca exceso de montos
            $apTotCab[$t][0]=0;
            $apTotCab[$t][1]="";
            $apTotCab[$t][2]="";
            $actualCab=$busca;
            $actualTip=$tipo[$t];
            $u=0;
            foreach ($apuesta2 as $busca2) {
                if ($actualCab==$busca2 && $tipo2[$u]==$actualTip) {
                    $apTotCab[$t][0]=$apTotCab[$t][0]+$monto[$u];
                    $apTotCab[$t][1]=$actualCab;
                    $apTotCab[$t][2]=$actualTip;
                    $apuesta2[$u]=0;
                }
                $u++;
            }
            $t++;
        }
        //ObtenerMontoEjeTaq($codT, $fecV, $numE, $codC, $codA) {
        foreach ($apTotCab as $busca) {
            if ($busca[2]==1) {
                if ($busca[0]>$_POST["apMaxGan"]) {
                    $valida=0;
                    $cExMonGa=1;
                    $exito=0;
                    break;
                } //Monto excedido a ganador
                $vendido=MontodeEjempar($codigoTaquilla, $_POST['cod_carrera'], $busca[1], 1);
                $exces=$vendido+$busca[0];
                if ($exces>$_POST["monMaxEj"]) {
                    $mensaje1="Excede monto";
                    $valida=0;
                    $cMonMaxGa=1;
                    $exito=0;
                    $mEjeMax=$busca[1];
                    $exMon=$_POST["monMaxEj"]-$vendido;
                    if ($exMon<=0) {
                        $mEjeMax=$busca[1].". NO SE PERMITEN MAS APUESTAS PARA EL EJEMPLAR<br/>TICKET NO GUARDADO";
                    } else {
                        $mEjeMax=$busca[1].". Monto maximo permitido:".$exMon."<br/>TICKET NO GUARDADO";
                    }
                    break;
                } //Monto Max alcanzado a ganador
            }
            if ($busca[2]==2) {
                if ($busca[0]>$_POST["apMaxPla"]) {
                    $valida=0;
                    $cExMonPl=1;
                    $exito=0;
                    break;
                } //Monto excedido
                $vendido=MontodeEjempar($codigoTaquilla, $_POST['cod_carrera'], $busca[1], 2);
                $exces=$vendido+$busca[0];
                if ($exces>$_POST["monMaxEj"]) {
                    $mensaje1="Excede monto";
                    $valida=0;
                    $cMonMaxPl=1;
                    $exito=0;
                    $mEjeMax=$busca[1];
                    $exMon=$_POST["monMaxEj"]-$vendido;
                    if ($exMon<=0) {
                        $mEjeMax=$busca[1].". NO SE PERMITEN MAS APUESTAS PARA EL EJEMPLAR<br/>TICKET NO GUARDADO";
                    } else {
                        $mEjeMax=$busca[1].". Monto maximo permitido:".$exMon."<br/>TICKET NO GUARDADO";
                    }
                    break;
                } //Monto Max alcanzado a place
            }
            if ($busca[2]==3) {
                if ($busca[0]>$_POST["apMaxSho"]) {
                    $valida=0;
                    $cExMonSh=1;
                    $exito=0;
                    break;
                } //Monto excedido
                $vendido=MontodeEjempar($codigoTaquilla, $_POST['cod_carrera'], $busca[1], 3);
                $exces=$vendido+$busca[0];
                if ($exces>$_POST["monMaxEj"]) {
                    $mensaje1="Excede monto";
                    $valida=0;
                    $cMonMaxSh=1;
                    $exito=0;
                    $mEjeMax=$busca[1];
                    $exMon=$_POST["monMaxEj"]-$vendido;
                    if ($exMon<=0) {
                        $mEjeMax=$busca[1].". NO SE PERMITEN MAS APUESTAS PARA EL EJEMPLAR<br/>TICKET NO GUARDADO";
                    } else {
                        $mEjeMax=$busca[1].". Monto maximo permitido:".$exMon."<br/>TICKET NO GUARDADO";
                    }
                    break;
                } //Monto Max alcanzado a show
            }
            if ($busca[2]==4 || $busca[2]==7) {
                if ($busca[2]==4) {
                    $montoV=MontodeEjempar($codigoTaquilla, $_POST['cod_carrera'], $busca[1], 4);
                } else {
                    $montoV=MontodeEjempar($codigoTaquilla, $_POST['cod_carrera'], $busca[1], 7);
                }
                $exces=$montoV+$busca[0];
                if ($exces>$_POST["apMaxExa"] || $montoV>$_POST["apMaxExa"]) {
                    $mensaje1="Excede monto";
                    $exMon=$_POST["apMaxExa"]-$montoV;
                    $valida=0;
                    $cExMonEz=1;
                    $exito=0;
                    if ($exMon<=0) {
                        $mEjeMax=$busca[1].". NO SE PERMITEN MAS APUESTAS PARA EL EJEMPLAR<br/>TICKET NO GUARDADO";
                    } else {
                        $mEjeMax=$busca[1].". Monto maximo permitido:".$exMon."<br/>TICKET NO GUARDADO";
                    }
                    break;
                } //Monto excedido a exacta
            }
            if ($busca[2]==5 || $busca[2]==8) {
                if ($busca[2]==5) {
                    $montoV=MontodeEjempar($codigoTaquilla, $_POST['cod_carrera'], $busca[1], 5);
                } else {
                    $montoV=MontodeEjempar($codigoTaquilla, $_POST['cod_carrera'], $busca[1], 8);
                }
                $exces=$montoV+$busca[0];
                if ($exces>$_POST["apMaxTri"] || $montoV>$_POST["apMaxTri"]) {
                    $mensaje1="Excede monto";
                    $exMon=$_POST["apMaxTri"]-$montoV;
                    $valida=0;
                    $cExMonTr=1;
                    $exito=0;
                    if ($exMon<=0) {
                        $mEjeMax=$busca[1].". NO SE PERMITEN MAS APUESTAS PARA EL EJEMPLAR<br/>TICKET NO GUARDADO";
                    } else {
                        $mEjeMax=$busca[1].". Monto maximo permitido:".$exMon."<br/>TICKET NO GUARDADO";
                    }
                    break;
                } //Monto excedido a trif
            }
            if ($busca[2]==6 || $busca[2]==9) {
                if ($busca[2]==6) {
                    $montoV=MontodeEjempar($codigoTaquilla, $_POST['cod_carrera'], $busca[1], 6);
                } else {
                    $montoV=MontodeEjempar($codigoTaquilla, $_POST['cod_carrera'], $busca[1], 9);
                }
                $exces=$montoV+$busca[0];
                if ($exces>$_POST["apMaxSup"] || $montoV>$_POST["apMaxSup"]) {
                    $mensaje1="Excede monto";
                    $exMon=$_POST["apMaxSup"]-$montoV;
                    $valida=0;
                    $cExMonSu=1;
                    $exito=0;
                    if ($exMon<=0) {
                        $mEjeMax=$busca[1].". NO SE PERMITEN MAS APUESTAS PARA EL EJEMPLAR<br/>TICKET NO GUARDADO";
                    } else {
                        $mEjeMax=$busca[1].". Monto maximo permitido:".$exMon."<br/>TICKET NO GUARDADO";
                    }
                    break;
                } //Monto excedido a super
            }
        }
        if ($valida==1) {
            $t=1;
            $totalTicket=0;
            foreach ($apuesta as $busca) {  //busca exceso o minimos de montos
                // valida si tipo de jugada esta activa
                if ($tipo[$t-1]==1) { // ganador
                    if ($_POST["est_gan"]==0) {
                        $valida=0;
                        $cTipJugGa=1;
                        $exito=0;
                        break;
                    } //Tipo de jugada no permitida por el Banquero
                }
                if ($tipo[$t-1]==2) { // place
                    if ($_POST["est_pla"]==0) {
                        $valida=0;
                        $cTipJugPl=1;
                        $exito=0;
                        break;
                    } //Tipo de jugada no permitida por el Banquero
                }
                if ($tipo[$t-1]==3) { // show
                    if ($_POST["est_sho"]==0) {
                        $valida=0;
                        $cTipJugSh=1;
                        $exito=0;
                        break;
                    } //Tipo de jugada no permitida por el Banquero
                }
                if ($tipo[$t-1]==4 || $tipo[$t-1]==7) { // exacta
                    if ($_POST["est_exa"]==0) {
                        $valida=0;
                        $cTipJugEx=1;
                        $exito=0;
                        break;
                    } //Tipo de jugada no permitida por el Banquero
                }
                if ($tipo[$t-1]==5 || $tipo[$t-1]==8) { // trifecta
                    if ($_POST["est_tri"]==0) {
                        $valida=0;
                        $cTipJugTr=1;
                        $exito=0;
                        break;
                    } //Tipo de jugada no permitida por el Banquero
                }
                if ($tipo[$t-1]==6 || $tipo[$t-1]==9) { // superfecta
                    if ($_POST["est_sup"]==0) {
                        $valida=0;
                        $cTipJugSu=1;
                        $exito=0;
                        break;
                    } //Tipo de jugada no permitida por el Banquero
                }
                // si excede monto
                if ($tipo[$t-1]==1) { // ganador
                    if ($monto[$t-1]>$_POST["apMaxGan"]) {
                        $valida=0;
                        $cExMonGa2=1;
                        $exito=0;
                        break;
                    } //Monto excedido a ganador
                }
                if ($tipo[$t-1]==2) { // pace
                    if ($monto[$t-1]>$_POST["apMaxPla"]) {
                        $valida=0;
                        $cExMonPl2=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                }
                if ($tipo[$t-1]==3) { // show
                    if ($monto[$t-1]>$_POST["apMaxSho"]) {
                        $valida=0;
                        $cExMonSh2=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                }
                if ($tipo[$t-1]==4 || $tipo[$t-1]==7) { // exacta
                    if ($monto[$t-1]>$_POST["apMaxExa"]) {
                        $valida=0;
                        $cExMonEx2=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                }
                if ($tipo[$t-1]==5 || $tipo[$t-1]==8) { // trifecta
                    if ($monto[$t-1]>$_POST["apMaxTri"]) {
                        $valida=0;
                        $cExMonTr2=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                }
                if ($tipo[$t-1]==6 || $tipo[$t-1]==9) { // superfecta
                    if ($monto[$t-1]>$_POST["apMaxSup"]) {
                        $valida=0;
                        $cExMonSu2=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                }
                // si monto es menor
                if ($tipo[$t-1]==1) { // ganador
                    if ($monto[$t-1]<$_POST["apMinGan"]) {
                        $valida=0;
                        $mMenG2=1;
                        $exito=0;
                        break;
                    } //
                }
                if ($tipo[$t-1]==2) { // pace
                    if ($monto[$t-1]<$_POST["apMinPla"]) {
                        $valida=0;
                        $mMenP2=1;
                        $exito=0;
                        break;
                    } //
                }
                if ($tipo[$t-1]==3) { // show
                    if ($monto[$t-1]<$_POST["apMinSho"]) {
                        $valida=0;
                        $mMenS2=1;
                        $exito=0;
                        break;
                    } //
                }
                if ($tipo[$t-1]==4 || $tipo[$t-1]==7) { // exacta
                    if ($monto[$t-1]<$_POST["apMinExa"]) {
                        $valida=0;
                        $mMenEx2=1;
                        $exito=0;
                        break;
                    } //
                }
                if ($tipo[$t-1]==5 || $tipo[$t-1]==8) { // trifecta
                    if ($monto[$t-1]<$_POST["apMinTri"]) {
                        $valida=0;
                        $mMenTr2=1;
                        $exito=0;
                        break;
                    } //
                }
                if ($tipo[$t-1]==6 || $tipo[$t-1]==9) { // superfecta
                    if ($monto[$t-1]<$_POST["apMinSup"]) {
                        $valida=0;
                        $mMenSu2=1;
                        $exito=0;
                        break;
                    } //
                }
                $totalTicket=$totalTicket+$monto[$t-1];
                $t++;
            }
            if ($totalTicket>$_POST["monMaxTi"]) {
                $valida=0;
                $mMonTic=1;
                $exito=0;  //Monto de ticket excedido
            }
            if ($totalTicket==0) {
                $valida=0;
                $montoT=1;
                $exito=0;  //Monto de ticket excedido
            }
        }
        if ($_POST["ejeMinC"]>$vanEnCarrera) {
            $valida=0;
            $mExEjCar=1;  //Excede Ejemplares en carrera
        } else {
            $mExEjCar=0;
        }
        if ($valida==1 && !isset($CRet1) && !isset($CRet2) && !isset($CRet3) && !isset($CRet4) && !isset($CRet5) &&
                           !isset($CRet6) && !isset($CRet7) && !isset($CRet8) && $maxCa==0 && $mExEjCar==0 &&
                           $cabR==0 && $mCero==0) {
            $f=0;
            $exito=1;
            foreach ($apuesta as $apta) {
                $yu=$f+1;
                

                $insertSQL = sprintf(
                    "/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 7 */ INSERT INTO venta_hnac (ser_venta_hnac, ticket_hnac, fec_venta_hnac, 
					hor_venta_hnac, cod_tventa_hnac, num_caballo_hnac, mon_venta_hnac, cod_carrera_hnac, id_usuario, est_ticket_hnac,
					can_ticket_hnac, ip_venta_hnac, lin_ticket_hnac, efectivoOn) 
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($serial, "text"),
                    GetSQLValueString($numerotiket2, "int"),
                    GetSQLValueString($FechaTxt, "date"),
                    GetSQLValueString($horaTxt, "date"),
                    GetSQLValueString($tipo[$f], "int"),
                    GetSQLValueString($apta, "text"),
                    GetSQLValueString($monto[$f], "double"),
                    GetSQLValueString($_POST['cod_carrera'], "int"),
                    GetSQLValueString($usuarioVenta, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($cantTicket, "int"),
                    GetSQLValueString($ipVenta, "text"),
                    GetSQLValueString($yu, "int"),
                    GetSQLValueString($_POST['efectivoOn'], "int")
                );
                
                $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                $f++;
            }
            
            if (isset($_POST["xindex"])) {
                $xindex=1;
            } else {
                $xindex=0;
            }

            $insertGoTo = "t_imprimeticket.php?recordID=$numerotiket2&uVenta=$usuarioVenta&xIndex=$xindex";
            if (isset($_SERVER['QUERY_STRING'])) {
                $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                $insertGoTo .= $_SERVER['QUERY_STRING'];
            } else {
                if (isset($_POST["xindex"])) {
                    $insertGoTo = "index_ventas.php";
                } else {
                    $insertGoTo = "index.php";
                }
            }
            header(sprintf("Location: %s", $insertGoTo));
        }
    } else {
        if ($exito==0) {
            if (!isset($montoT)) {
                $montoT=0;
                for ($i = 1; $i <= 4; $i++) {
                    $a="monGan".$i;
                    $b="monPla".$i;
                    $c="monSho".$i;
                    $montoT+=$_POST[$a]+$_POST[$b]+$_POST[$c];
                }
            }
        }
    }
    if (isset($montoT) && $montoT==0) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Indique monto de apuesta";
    } elseif (isset($_POST["ejeMinC"]) && $_POST["ejeMinC"]>$vanEnCarrera) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede Ejemplares en carrera2";
    } elseif (isset($fueFec) && $fueFec==0) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Jugada fuera de fecha";
    } elseif (isset($fueHor) && $fueHor==0) {
        $iR=1;
        $_SESSION['MM_mensaje3']="APUESTA NO REALIZADA. Carrera cerrada";
    } elseif (isset($CRet1) && $CRet1==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Existe ejemplares retirados en la jugada -".$mRet1;
    } elseif (isset($CRet2) && $CRet2==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Existe ejemplares retirados en la jugada -".$mRet2;
    } elseif (isset($CRet3) && $CRet3==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Existe ejemplares retirados en la jugada -".$mRet3;
    } elseif (isset($CRet4) && $CRet4==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Existe ejemplares retirados en la jugada -".$mRet4;
    } elseif (isset($CRet5) && $CRet5==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Existe ejemplares retirados en la jugada -".$mRet5;
    } elseif (isset($CRet6) && $CRet6==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Existe ejemplares retirados en la jugada -".$mRet6;
    } elseif (isset($CRet7)&&$CRet7==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Existe ejemplares retirados en la jugada -".$mRet7;
    } elseif (isset($CRet8)&&$CRet8==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Existe ejemplares retirados en la jugada -".$mRet8;
    } elseif (isset($cabDefinido) && $cabDefinido==0) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Indique ejemplar";
    } elseif (isset($cExMonGa2) && $cExMonGa2==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto a ganador-";
    } elseif (isset($cExMonPl2) && $cExMonPl2==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto a place-";
    } elseif (isset($cExMonSh2) && $cExMonSh2==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto a show-";
    } elseif (isset($cExMonEx2) && $cExMonEx2==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto en exacta-";
    } elseif (isset($cExMonTr2) && $cExMonTr2==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto en trifecta-";
    } elseif (isset($cExMonSu2) && $cExMonSu2==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto en superfecta-";
    } elseif (isset($cTipJugGa)&&$cTipJugGa==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Jugada a ganador no permitida por el banquero";
    } elseif (isset($cTipJugPl) && $cTipJugPl==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Jugada a place no permitida por el banquero";
    } elseif (isset($cTipJugSh) && $cTipJugSh==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Jugada a show no permitida por el banquero";
    } elseif (isset($cTipJugEx)&&$cTipJugEx==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Jugada exacta no permitida por el banquero";
    } elseif (isset($cTipJugTr)&&$cTipJugTr==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Jugada trifecta no permitida por el banquero";
    } elseif (isset($cTipJugSu)&&$cTipJugSu==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Jugada superfecta no permitida por el banquero";
    } elseif (isset($mMonTic) && $mMonTic==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Monto de ticket excedido";
    } elseif (isset($maxCa) && $maxCa==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="supera los ejemplares en carrera";
    } elseif (isset($mCero) && $mCero==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Indique monto de apuesta";
    } elseif (isset($cabR) && $cabR==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede Ejemplares en carrera";
    } elseif (isset($mMenP) && $mMenP==1) {
        $_SESSION['MM_mensaje3']="Monto a place debe ser mayor a cero";
    } elseif (isset($mMenS) && $mMenS==1) {
        $_SESSION['MM_mensaje3']="Monto a show debe ser mayor a cero";
    } elseif (isset($cExMonGa) && $cExMonGa==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto";
    } elseif (isset($cExMonPl) && $cExMonPl==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto";
    } elseif (isset($cExMonSh) && $cExMonSh==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto";
    } elseif (isset($cExMonEx) && $cExMonEx==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto";
    } elseif (isset($cExMonTr) && $cExMonTr==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto";
    } elseif (isset($cExMonSu) && $cExMonSu==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="Excede monto";
    } elseif (isset($cMonMaxGa) && $cMonMaxGa==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="<font size=3>Limite a ganador excedido en ejemplar #".$mEjeMax."</font>";
    } elseif (isset($cMonMaxPl) && $cMonMaxPl==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="<font size=3>Limite a place excedido en ejemplar #".$mEjeMax."</font>";
    } elseif (isset($cMonMaxSh) && $cMonMaxSh==1) {
        $iR=1;
        $_SESSION['MM_mensaje3']="<font size=3>Limite a show excedido en ejemplar #".$mEjeMax."</font>";
    }
}
$query_Recordset15 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 8 */ SELECT ta.est_taquilla, tn.puedecerrar
		FROM 
			usuario us, 
			taquilla ta, 
			taquilla_opc_ame tp, 
			taquilla_opc_hnac tn  
		WHERE 
			us.id_usuario = %s AND 
			us.cod_taquilla = ta.cod_taquilla AND
			ta.cod_taquilla = tn.cod_taquilla AND
			tn.cod_taquilla = tp.cod_taquilla AND
			tp.cod_taquilla = us.cod_taquilla
		LIMIT 1",
    GetSQLValueString($usuarioVenta, "int")
);
$Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
$row_Recordset15 = mysqli_fetch_assoc($Recordset15);
$totalRows_Recordset15 = mysqli_num_rows($Recordset15);
if ($totalRows_Recordset15>0) {
    $est_ame=$row_Recordset15['est_taquilla'];
} else {
    $est_ame=0;
}
$query_Recordset5 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 9 */ SELECT 
	ta.nom_taquilla,
	ta.cod_taquilla, ta.alerta_corte_taq, ta.tipotaquilla, ta.saldoactual, ta.efectivoO,
	us.nom_completo,
	tp.puedecerrar,
	tp.max_eje_hnac,
	tp.min_jugtic_hnac,
	tp.max_eje_hnac,
	tp.cab_min_hnac,
	ta.est_taquilla_hnac,
	tp.est_gan_hnac,
	tp.est_pla_hnac,
	tp.est_exa_hnac,
	tp.est_tri_hnac,
	tp.est_sup_hnac,
	tp.mod_divid_hnac,
	tp.tie_venta_hnac,
	tp.est_ven_macu,
	tp.max_jugtic_hnac,
	tp.pag_codigo_hnac, ag.cod_agencia, ag.alerta_corte_age, ba.cod_banca, ba.alerta_corte_dis
	
	FROM 
		usuario us, 
		taquilla ta, 
		taquilla_opc_hnac tp,
			agencia ag,
			banca ba 
	WHERE 
		us.id_usuario = %s AND 
		us.cod_taquilla = ta.cod_taquilla AND
		tp.cod_taquilla = ta.cod_taquilla AND
					ta.cod_agencia = ag.cod_agencia AND
			ag.cod_banca = ba.cod_banca
		
		
	LIMIT 1",
    GetSQLValueString($usuarioVenta, "int")
);
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
$taquilla=$row_Recordset5['cod_taquilla'];
$nombredetaquilla=$row_Recordset5['nom_taquilla'];
$nomcompleto=$row_Recordset5['nom_completo'];
$efectivoOt=$row_Recordset5['efectivoO']/1;
$tipotaquilla=$row_Recordset5['tipotaquilla']/1;
$saldoactual=$row_Recordset5['saldoactual']/1;
$apGaMax=$row_Recordset5['max_eje_hnac'];
$apPlMax=$row_Recordset5['max_eje_hnac'];
$apShMax=$row_Recordset5['max_eje_hnac'];
$apMin=$row_Recordset5['min_jugtic_hnac'];
$apMinGan=$row_Recordset5['min_jugtic_hnac'];
$apMinPla=$row_Recordset5['min_jugtic_hnac'];
$apMinSho=$row_Recordset5['min_jugtic_hnac'];
$apMinExa=$row_Recordset5['min_jugtic_hnac'];
$apMinTri=$row_Recordset5['min_jugtic_hnac'];
$apMinSup=$row_Recordset5['min_jugtic_hnac'];
$apExMax=$row_Recordset5['max_eje_hnac'];
$apTrMax=$row_Recordset5['max_eje_hnac'];
$apSuMax=$row_Recordset5['max_eje_hnac'];
$monMaxTi=$row_Recordset5['max_jugtic_hnac'];
$ejeMinCar=$row_Recordset5['cab_min_hnac'];
$est_hnac=$row_Recordset5['est_taquilla_hnac'];////***pendiente
$est_gan=$row_Recordset5['est_gan_hnac'];
$est_pla=$row_Recordset5['est_pla_hnac'];
//$est_sho=$row_Recordset5['est_sho_hnac'];////***pendiente
$est_exa=$row_Recordset5['est_exa_hnac'];
$est_tri=$row_Recordset5['est_tri_hnac'];
$est_sup=$row_Recordset5['est_sup_hnac'];
$monMaxEj=$row_Recordset5['max_eje_hnac'];
$est_sho=0;
$mod_divid_hnac=$row_Recordset5['mod_divid_hnac'];
$tie_venta_hnac=$row_Recordset5['tie_venta_hnac'];
$est_ven_macu=$row_Recordset5['est_ven_macu'];
$pedirCodigoPago=$row_Recordset5['pag_codigo_hnac'];

$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 10 */ SELECT
	CONCAT(hi.nom_hipodromo_hnac, ' Carr...', ca.num_carrera_hnac) AS carrera, 
	ca.cod_carrera_hnac, 
	ca.can_caballos_hnac, 
	ca.hor_carrera_hnac 
	FROM 
		carrera_hnac ca,
		hipodromo_hnac hi
	WHERE
		hi.cod_hipodromo_hnac =  ca.cod_hipodromo_hnac AND
		ca.fec_carrera_hnac = %s AND 
		ca.hor_carrera_hnac >= %s AND 
		ca.est_carrera_hnac = 1 AND 
		ca.can_caballos_hnac>=%s 
	ORDER BY 
		ca.hor_carrera_hnac  
	LIMIT 15",
    GetSQLValueString($fec, "date"),
    GetSQLValueString($hor, "date"),
    GetSQLValueString($ejeMinCar, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset51 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\index_datos.php - QUERY 11 */ SELECT 
	CONCAT(hi.nom_hipodromo_hnac, ' Carr...', ca.num_carrera_hnac) AS carrera,
	ca.cod_carrera_hnac,
	ca.num_carrera_hnac
	FROM 
		carrera_hnac ca, hipodromo_hnac hi
        WHERE hi.cod_hipodromo_hnac > 0 AND
		ca.fec_carrera_hnac = %s AND
		hi.cod_hipodromo_hnac = ca.cod_hipodromo_hnac",
    GetSQLValueString($fec, "date")
);
$Recordset51 = mysqli_query($conexionbanca, $query_Recordset51) or die(mysqli_error($conexionbanca));
$row51 = mysqli_fetch_assoc($Recordset51);
$totalRows_Recordset51 = mysqli_num_rows($Recordset51);
if ($totalRows_Recordset51>0 && $_SESSION['selCarrera']==-1) {
    $carreraActual=$row51['cod_carrera_hnac'];
} else {
    $carreraActual=$_SESSION['selCarrera'];
}
$t=0;
$x=0;
if ($totalRows_Recordset1>0) {
    do {
        list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera_hnac']);
        $canRetirados=cantRetirados_hnac($row_Recordset1['cod_carrera_hnac']);
        $vanEnCarrera=$row_Recordset1['can_caballos_hnac']-$canRetirados;
        if ($h<19 && $m<59 && $ejeMinCar<=$vanEnCarrera) {
            $cod[$t]=$row_Recordset1['cod_carrera_hnac'];
            $carrera[$t]=$row_Recordset1['carrera'];
            $t++;
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}
if ($est_control_ventas==1 or $pau_ventas==1) {
    $mensaje1="VENTAS PAUSADAS MOMENTANEAMENTE";
    $_SESSION['MM_mensaje3']=" POR FAVOR INTENTELO MAS TARDE";
}
if ($t==0) {
    $totalRows_Recordset1=0;
}
$insertGoTo = "index.php";
if (isset($iR) && $iR==1) {
    header(sprintf("Location: %s", $insertGoTo));
} else {
    $iR=0;
}

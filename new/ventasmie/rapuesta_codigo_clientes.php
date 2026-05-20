<?php
date_default_timezone_set("Pacific/Honolulu") ;
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$volver=0;
 include("../includes/montosminimos.php");
$mensaje_cliente="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if (isset($_POST["MM_insert12"]) && isset($_POST["MM_insert12"])) {
    if (isset($_POST["aceptar"]) or isset($_POST["generar"])) {
        $fechasistema=fechaactualbd();
        $horaTxt=horaactual();
        $FechaTxt=fechaactualbd();
        $query_Recordset19 = sprintf(
            "/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 1 */ SELECT can_caballos, hor_carrera, fec_carrera, est_carrera, pau_ventas, 
				num_carrera, nom_hipodromo, cod_carrera
				FROM carrera
				WHERE cod_carrera = %s 
				LIMIT 1",
            GetSQLValueString($_POST['cod_carrera12'], "int")
        );
        $Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
        $row_Recordset19 = mysqli_fetch_assoc($Recordset19);
        $totalRows_Recordset19 = mysqli_num_rows($Recordset19);
        $nom_hipodromo=$row_Recordset19['nom_hipodromo'];
        $num_carrera=$row_Recordset19['num_carrera'];
        $cod_carrera=$row_Recordset19['cod_carrera'];
        $cod_taquilla=$_POST["cod_taquilla"];
        $statuscarrerabd=$row_Recordset19['est_carrera'];
        $fechacarrerabd=$row_Recordset19['fec_carrera'];
        $horacarrerabd=$row_Recordset19['hor_carrera'];
        $usuario=$_POST["usuario"];
        $ipVenta=getRealIP();
        $cantTicket=ObtenerNumeroJugada($usuario, $fechasistema)+1;
        $numerotiket2=$usuario.ObtenerUltimaVenta();
        $serial=generarCodigo(5, $numerotiket2);
        $apuesta=$_POST["apuesta"];
        $tipo=$_POST["tipo"];
        $monto=$_POST["monto"];
        $efectivoOx=$_POST['efectivoOxxx'];
        $fueFec=1;
        $fueHor=1;
        if ((isset($_POST["cod_cliente"])&&$_POST["cod_cliente"]!="") or (isset($_POST["generar"])&&$_POST["tra_codigo"]==2)
            or (isset($_POST["cod_cliente"])&&$_POST["cod_cliente"]==""&&isset($_POST["cod_cliente2"])&&$_POST["cod_cliente2"]!=""
            &&$_POST["cod_cliente2"]!="-1X")) {
            if ($_POST["cod_cliente"]==""&&$_POST["cod_cliente2"]!="-1X") {
                $_POST["cod_cliente"]=$_POST["cod_cliente2"];
            }
            if ($fechacarrerabd != $FechaTxt) {
                $fueFec=0;
            }
            if ($horacarrerabd < $horaTxt || $statuscarrerabd!= 1) {
                $fueHor=0;
                $mensaje_cliente="APUESTA NO REALIZADA. Carrera cerrada";
            }
            if ($fueHor==1 && $fueFec==1) {
                $f=0;



                $usuario=$_POST['usuario'];
                $tra_cod=1;

                if (isset($_POST["generar"])) {
                    $tra_cod=0;
                    $_POST["cod_cliente"]=$_POST["tra_codigo"];
                }
                foreach ($apuesta as $apta) {
                    $yu=$f+1;
                    $insertSQL = sprintf(
                        "/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 2 */ INSERT INTO venta (ser_venta, ticket, cod_cliente, cod_taquilla, fec_venta, hor_venta,
						cod_tventa,	num_caballo, mon_venta, cod_carrera, id_usuario, est_ticket, can_ticket, ip_venta, 
						lin_ticket, tra_codigo, efectivoO) 
						 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                        GetSQLValueString($serial, "text"),
                        GetSQLValueString($numerotiket2, "int"),
                        GetSQLValueString(strtoupper($_POST["cod_cliente"]), "text"),
                        GetSQLValueString($_POST['cod_taquilla'], "int"),
                        GetSQLValueString($FechaTxt, "date"),
                        GetSQLValueString($horaTxt, "date"),
                        GetSQLValueString($tipo[$f], "int"),
                        GetSQLValueString($apta, "text"),
                        GetSQLValueString($monto[$f], "double"),
                        GetSQLValueString($_POST['cod_carrera12'], "int"),
                        GetSQLValueString($_POST['usuario'], "int"),
                        GetSQLValueString(1, "int"),
                        GetSQLValueString($cantTicket, "int"),
                        GetSQLValueString($ipVenta, "text"),
                        GetSQLValueString($yu, "int"),
                        GetSQLValueString($tra_cod, "int"),
                        GetSQLValueString($efectivoOx, "int")
                    );
                     
                    $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                    
                    $query_Recordset55 = sprintf(
                        "
/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 3 */ SELECT 
tasadecambio.usdabss, tasadecambio.copabss, tasadecambio.solabss, 
agencia.tipo_pagoa, agencia.saldoactuala,
taquilla.tipo_pago, taquilla.saldoactual
FROM 
tasadecambio, taquilla, agencia
WHERE 
taquilla.cod_taquilla = %s AND
taquilla.cod_agencia = agencia.cod_agencia AND
tasadecambio.Idtasadecambio = %s",
                        GetSQLValueString($_POST['cod_taquilla'], "int"),
                        GetSQLValueString(1, "int")
                    );
                    $Recordset55 = mysqli_query($conexionbanca, $query_Recordset55) or die(mysqli_error($conexionbanca));
                    $row_Recordset55 = mysqli_fetch_assoc($Recordset55);
                    $totalRows_Recordset55 = mysqli_num_rows($Recordset55);
                    $saldoactuala=$row_Recordset55['saldoactuala'];
                    $saldoactual=$row_Recordset55['saldoactual'];
                    $tipo_pagoa=$row_Recordset55['tipo_pagoa'];
                    $tipo_pago=$row_Recordset55['tipo_pago'];
                    $usdabss=$row_Recordset55['usdabss'];
                    $copabss=$row_Recordset55['copabss'];
                    $solabss=$row_Recordset55['solabss'];
                    $tasa=1;
                    if ($efectivoOx<=2) {
                        $tasa=1;
                    }
                    if ($efectivoOx==3) {
                        $tasa=$usdabss;
                    }
                    if ($efectivoOx==4) {
                        $tasa=$copabss;
                    }
                    if ($efectivoOx==5) {
                        $tasa=$solabss;
                    }
                    
                    if ($tipo_pago==1) {
                        $insertSQL15 = sprintf(
                            "/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 4 */ UPDATE taquilla 
				SET
				saldoactual=saldoactual-%s
				WHERE 
				cod_taquilla=%s",
                            GetSQLValueString($monto[$f]*$tasa, "double"),
                            GetSQLValueString($_POST['cod_taquilla'], "int")
                        );

                        $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));
                    }
                    if ($tipo_pagoa==1) {
                        $insertSQL15 = sprintf(
                            "/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 5 */ UPDATE agencia 
				SET
				saldoactuala=saldoactuala-%s
				WHERE 
				cod_agencia=%s",
                            GetSQLValueString($monto[$f]*$tasa, "double"),
                            GetSQLValueString($cod_agencia, "int")
                        );

                        $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));
                    }
                    
                    
                    
                    
                    $f++;
                }
                $volver=1;
                $_SESSION['MM_mensaje3']="APUESTA REALIZADA CORRECTAMENTE";
                if (isset($_POST["generar"])&&$_POST["tra_codigo"]==2) {
                    $imprime=1;
                } else {
                    $imprime=0;
                }
            } else {
                $mensaje1="";
                $volver=1;
                if ($fueHor==0) {
                    $_SESSION['MM_mensaje3']="APUESTA NO REALIZADA. Carrera cerrada";
                }
                if ($fueFec==0) {
                    $_SESSION['MM_mensaje3']="Jugada fuera de fecha";
                }
            }
        } else {
            $mensaje_cliente="INDIQUE CODIGO DE CLIENTE";
            $volver=0;
        }
    } else {
        $_SESSION['MM_mensaje3']="APUESTA NO REALIZADA - CANCELADA POR EL OPERADOR";
        $mensaje1="";
        $volver=1;
    }
} elseif (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1" && isset($_POST["cod_carrera"]) && $_POST["cod_carrera"]==-1) {
    $_SESSION['MM_mensaje3']="APUESTA NO REALIZADA. Seleccione un hipodromo.";
    $mensaje1="";
    $volver=1;
} else {
    function ObtenerMontoEjeTaq($codT, $fecV, $numE, $codC, $codA)
    {
        global $conexionbanca;
        $query_Recordset20 = sprintf(
            "/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 6 */ SELECT 
			SUM(mon_venta) AS total FROM venta 
		WHERE cod_taquilla = %s AND fec_venta = %s AND num_caballo = %s AND cod_carrera = %s AND cod_tventa = %s AND est_ticket = 1",
            GetSQLValueString($codT, "int"),
            GetSQLValueString($fecV, "date"),
            GetSQLValueString($numE, "text"),
            GetSQLValueString($codC, "int"),
            GetSQLValueString($codA, "int")
        );
        $Recordset20 = mysqli_query($conexionbanca, $query_Recordset20) or die(mysqli_error($conexionbanca));
        $row_Recordset20 = mysqli_fetch_assoc($Recordset20);
        $totalRows_Recordset20 = mysqli_num_rows($Recordset20);
        $total=$row_Recordset20['total'];
        mysqli_free_result($Recordset20);
        return $total;
    }
    $est_control_ventas=$_POST["est_control_ventas"];
    if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1" && isset($_POST["cod_carrera"]) && $_POST["cod_carrera"]!=-1 &&
        $est_control_ventas==0) {
        $volver=1;
        $_SESSION['selCarrera']=$_POST['cod_carrera'];
        $_SESSION['efectivoOx']=$_POST['efectivoO'];
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
        $query_Recordset19 = sprintf(
            "/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 7 */ SELECT can_caballos, hor_carrera, fec_carrera, est_carrera, pau_ventas, 
				num_carrera, nom_hipodromo, cod_carrera
				FROM carrera
				WHERE cod_carrera = %s 
				 LIMIT 1",
            GetSQLValueString($_POST['cod_carrera'], "int")
        );
        $Recordset19 = mysqli_query($conexionbanca, $query_Recordset19) or die(mysqli_error($conexionbanca));
        $row_Recordset19 = mysqli_fetch_assoc($Recordset19);
        $totalRows_Recordset19 = mysqli_num_rows($Recordset19);
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
        $nom_hipodromo=$row_Recordset19['nom_hipodromo'];
        $num_carrera=$row_Recordset19['num_carrera'];
        $cod_carrera=$_POST['cod_carrera'];
        
        $cCab=$row_Recordset19['can_caballos']; // cantidad de caballo
        $canRetirados=cantRetirados($_POST['cod_carrera']);
        $vanEnCarrera=$row_Recordset19['can_caballos']-$canRetirados;
        $fechacarrerabd=$row_Recordset19['fec_carrera'];
        $horacarrerabd=$row_Recordset19['hor_carrera'];
        $statuscarrerabd=$row_Recordset19['est_carrera'];
        $pau_ventas=$row_Recordset19['pau_ventas'];
        mysqli_free_result($Recordset19);
        
        $usuario=$_POST["id_usuario"];
        
        $maxCa=0; // bandera maxima de caballo
        $cabR=0;
        $mCero=0;
        $_POST["monGan1"]=((float)$_POST["monGan1"]/(float)1);
        $_POST["monPla1"]=((float)$_POST["monPla1"]/(float)1);
        $_POST["monSho1"]=((float)$_POST["monSho1"]/(float)1);
        $_POST["monGan2"]=((float)$_POST["monGan2"]/(float)1);
        $_POST["monPla2"]=((float)$_POST["monPla2"]/(float)1);
        $_POST["monSho2"]=((float)$_POST["monSho2"]/(float)1);
        $_POST["monGan3"]=((float)$_POST["monGan3"]/(float)1);
        $_POST["monPla3"]=((float)$_POST["monPla3"]/(float)1);
        $_POST["monSho3"]=((float)$_POST["monSho3"]/(float)1);
        $_POST["monGan4"]=((float)$_POST["monGan4"]/(float)1);
        $_POST["monPla4"]=((float)$_POST["monPla4"]/(float)1);
        $_POST["monSho4"]=((float)$_POST["monSho4"]/(float)1);
        $_POST["numCa11"]=((float)$_POST["numCa11"]/(float)1);
        $_POST["numCa21"]=((float)$_POST["numCa21"]/(float)1);
        $_POST["numCa31"]=((float)$_POST["numCa31"]/(float)1);
        $_POST["numCa41"]=((float)$_POST["numCa41"]/(float)1);
        $_POST["numCa12"]=((float)$_POST["numCa12"]/(float)1);
        $_POST["numCa22"]=((float)$_POST["numCa22"]/(float)1);
        $_POST["numCa32"]=((float)$_POST["numCa32"]/(float)1);
        $_POST["numCa42"]=((float)$_POST["numCa42"]/(float)1);
        $_POST["numCa13"]=((float)$_POST["numCa13"]/(float)1);
        $_POST["numCa23"]=((float)$_POST["numCa23"]/(float)1);
        $_POST["numCa33"]=((float)$_POST["numCa33"]/(float)1);
        $_POST["numCa43"]=((float)$_POST["numCa43"]/(float)1);
        $_POST["numCa14"]=((float)$_POST["numCa14"]/(float)1);
        $_POST["numCa24"]=((float)$_POST["numCa24"]/(float)1);
        $_POST["numCa34"]=((float)$_POST["numCa34"]/(float)1);
        $_POST["numCa44"]=((float)$_POST["numCa44"]/(float)1);
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
                    $sRetiro1=RetiradosSimple($_POST['cod_carrera'], $ju1); // verifica estado de retirado
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
                            $sRetiro1=RetiradosSimple($_POST['cod_carrera'], $ejem); // verifica estado de retirado
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
                    $sRetiro2=RetiradosSimple($_POST['cod_carrera'], $ju2); // verifica estado de retirado
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
                            $sRetiro2=RetiradosSimple($_POST['cod_carrera'], $ejem); // verifica estado de retirado
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
                    $sRetiro3=RetiradosSimple($_POST['cod_carrera'], $ju3); // verifica estado de retirado
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
                            $sRetiro3=RetiradosSimple($_POST['cod_carrera'], $ejem); // verifica estado de retirado
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
                    $sRetiro4=RetiradosSimple($_POST['cod_carrera'], $ju4); // verifica estado de retirado
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
                            $sRetiro4=RetiradosSimple($_POST['cod_carrera'], $ejem); // verifica estado de retirado
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
            $apTotCab=array();
            foreach ($apuesta as $busca) {  //busca exceso de montos
                $actualCab=$busca;
                $actualTip=$tipo[$t];
                $u=0;
                foreach ($apuesta2 as $busca2) {
                    if ($actualCab==$busca2 && $tipo2[$u]==$actualTip) {
                        if (isset($apTotCab[$t][0])) {
                            $apTotCab[$t][0]=$apTotCab[$t][0]+$monto[$u];
                        } else {
                            $apTotCab[$t][0]=$monto[$u];
                        }
                        $apTotCab[$t][1]=$actualCab;
                        $apTotCab[$t][2]=$actualTip;
                        $apuesta2[$u]=0;
                    }
                    $u++;
                }
                $t++;
            }
            $query_Recordset18 = sprintf(
                "/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 8 */ SELECT
					us.cod_taquilla, apu_maxgan, mon_maxejemplar, apu_maxpla, apu_maxsho, apu_maxexa, apu_maxtri, apu_maxsup,
					apu_mingan, apu_minpla, apu_minsho, apu_minexa, apu_maxtri, apu_maxsup, mon_maxticket, est_gan, est_pla, 
					est_sho, est_exa, est_tri, est_sup, min_ejecarrera
				FROM usuario us, taquilla_opc_ame tp 
				WHERE us.id_usuario = %s AND tp.cod_taquilla = us.cod_taquilla LIMIT 1",
                GetSQLValueString($usuario, "int")
            );
            $Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
            $row_Recordset18 = mysqli_fetch_assoc($Recordset18);
            $totalRows_Recordset18 = mysqli_num_rows($Recordset18);
            $cod_taquilla=$row_Recordset18['cod_taquilla'];
            $apu_maxgan=$row_Recordset18['apu_maxgan'];
            $apu_maxpla=$row_Recordset18['apu_maxpla'];
            $apu_maxsho=$row_Recordset18['apu_maxsho'];
            $apu_maxexa=$row_Recordset18['apu_maxexa'];
            $apu_maxtri=$row_Recordset18['apu_maxtri'];
            $apu_maxsup=$row_Recordset18['apu_maxsup'];
            $mon_maxejemplar=$row_Recordset18['mon_maxejemplar'];
            $apu_mingan=$row_Recordset18['apu_mingan'];
            $apu_minpla=$row_Recordset18['apu_minpla'];
            $apu_minsho=$row_Recordset18['apu_minsho'];
            $apu_minexa=$row_Recordset18['apu_minexa'];
            $apu_maxtri=$row_Recordset18['apu_maxtri'];
            $apu_maxsup=$row_Recordset18['apu_maxsup'];
            $mon_maxticket=$row_Recordset18['mon_maxticket'];
            $est_gan=$row_Recordset18['est_gan'];
            $est_pla=$row_Recordset18['est_pla'];
            $est_sho=$row_Recordset18['est_sho'];
            $est_exa=$row_Recordset18['est_exa'];
            $est_tri=$row_Recordset18['est_tri'];
            $est_sup=$row_Recordset18['est_sup'];
            $min_ejecarrera=$row_Recordset18['min_ejecarrera'];
            mysqli_free_result($Recordset18);
            foreach ($apTotCab as $busca) {
                if ($busca[2]==1) { //tipo de apuesta
                    if ($busca[0]>$apu_maxgan) {
                        $valida=0;
                        $cExMonGa=1;
                        $exito=0;
                        break;
                    } //Monto excedido a ganador
                    $vendido=ObtenerMontoEjeTaq($cod_taquilla, $FechaTxt, $busca[1], $_POST['cod_carrera'], 1);
                    $exces=$vendido+$busca[0];
                    if ($exces>$mon_maxejemplar) {
                        //$mensaje1="Excede monto";
                        $valida=0;
                        $cMonMaxGa=1;
                        $exito=0;
                        $mEjeMax=$busca[1];
                        $exMon=$mon_maxejemplar-$vendido;
                        if ($exMon<=0) {
                            $mEjeMax=$busca[1].". NO SE PERMITEN MAS APUESTAS PARA EL EJEMPLAR<br/>TICKET NO GUARDADO";
                        } else {
                            $mEjeMax=$busca[1].". Monto maximo permitido:".$exMon."<br/>TICKET NO GUARDADO";
                        }
                        break;
                    } //Monto Max alcanzado a ganador
                } elseif ($busca[2]==2) {
                    if ($busca[0]>$apu_maxpla) {
                        $valida=0;
                        $cExMonPl=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                    $vendido=ObtenerMontoEjeTaq($cod_taquilla, $FechaTxt, $busca[1], $_POST['cod_carrera'], 2);
                    $exces=$vendido+$busca[0];
                    if ($exces>$mon_maxejemplar) {
                        //$mensaje1="Excede monto";
                        $valida=0;
                        $cMonMaxPl=1;
                        $exito=0;
                        $mEjeMax=$busca[1];
                        $exMon=$mon_maxejemplar-$vendido;
                        if ($exMon<=0) {
                            $mEjeMax=$busca[1].". NO SE PERMITEN MAS APUESTAS PARA EL EJEMPLAR<br/>TICKET NO GUARDADO";
                        } else {
                            $mEjeMax=$busca[1].". Monto maximo permitido:".$exMon."<br/>TICKET NO GUARDADO";
                        }
                        break;
                    } //Monto Max alcanzado a place
                } elseif ($busca[2]==3) {
                    if ($busca[0]>$apu_maxsho) {
                        $valida=0;
                        $cExMonSh=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                    $vendido=ObtenerMontoEjeTaq($cod_taquilla, $FechaTxt, $busca[1], $_POST['cod_carrera'], 3);
                    $exces=$vendido+$busca[0];
                    if ($exces>$mon_maxejemplar) {
                        //$mensaje1="Excede monto";
                        $valida=0;
                        $cMonMaxSh=1;
                        $exito=0;
                        $mEjeMax=$busca[1];
                        $exMon=$mon_maxejemplar-$vendido;
                        if ($exMon<=0) {
                            $mEjeMax=$busca[1].". NO SE PERMITEN MAS APUESTAS PARA EL EJEMPLAR<br/>TICKET NO GUARDADO";
                        } else {
                            $mEjeMax=$busca[1].". Monto maximo permitido:".$exMon."<br/>TICKET NO GUARDADO";
                        }
                        break;
                    } //Monto Max alcanzado a show
                } elseif ($busca[2]==4 || $busca[1]==7) {
                    if ($busca[0]>$apu_maxexa) {
                        $valida=0;
                        $cExMonEx=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                } elseif ($busca[2]==5 || $busca[1]==8) {
                    if ($busca[0]>$apu_maxtri) {
                        $valida=0;
                        $cExMonTr=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                } elseif ($busca[2]==6 || $busca[1]==9) {
                    if ($busca[0]>$apu_maxsup) {
                        $valida=0;
                        $cExMonSu=1;
                        $exito=0;
                        break;
                    } //Monto excedido
                }
            }
            if ($valida==1) {
                $t=1;
                $totalTicket=0;
                foreach ($apuesta as $busca) {  //busca exceso o minimos de montos
                    // valida si tipo de jugada esta activa
                    if ($tipo[$t-1]==1) { // ganador
                        if ($est_gan==0) {
                            $valida=0;
                            $cTipJugGa=1;
                            $exito=0;
                            break;
                        } //Tipo de jugada no permitida por el Banquero
                    } elseif ($tipo[$t-1]==2) { // place
                        if ($est_pla==0) {
                            $valida=0;
                            $cTipJugPl=1;
                            $exito=0;
                            break;
                        } //Tipo de jugada no permitida por el Banquero
                    } elseif ($tipo[$t-1]==3) { // show
                        if ($est_sho==0) {
                            $valida=0;
                            $cTipJugSh=1;
                            $exito=0;
                            break;
                        } //Tipo de jugada no permitida por el Banquero
                    } elseif ($tipo[$t-1]==4 || $tipo[$t-1]==7) { // exacta
                        if ($est_exa==0) {
                            $valida=0;
                            $cTipJugEx=1;
                            $exito=0;
                            break;
                        } //Tipo de jugada no permitida por el Banquero
                    } elseif ($tipo[$t-1]==5 || $tipo[$t-1]==8) { // trifecta
                        if ($est_tri==0) {
                            $valida=0;
                            $cTipJugTr=1;
                            $exito=0;
                            break;
                        } //Tipo de jugada no permitida por el Banquero
                    } elseif ($tipo[$t-1]==6 || $tipo[$t-1]==9) { // superfecta
                        if ($est_sup==0) {
                            $valida=0;
                            $cTipJugSu=1;
                            $exito=0;
                            break;
                        } //Tipo de jugada no permitida por el Banquero
                    }
                            
    
                    // si monto es menor
                    
                    
                    echo $row_Recordset18['cod_taquilla'];
                    $query_Recordset55 = sprintf(
                        "
/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 9 */ SELECT 
tasadecambio.usdabss, tasadecambio.copabss, tasadecambio.solabss, 
agencia.tipo_pagoa, agencia.saldoactuala,
taquilla.tipo_pago, taquilla.saldoactual
FROM 
tasadecambio, taquilla, agencia
WHERE 
taquilla.cod_taquilla = %s AND
taquilla.cod_agencia = agencia.cod_agencia AND
tasadecambio.Idtasadecambio = %s",
                        GetSQLValueString($row_Recordset18['cod_taquilla'], "int"),
                        GetSQLValueString(1, "int")
                    );
                    $Recordset55 = mysqli_query($conexionbanca, $query_Recordset55) or die(mysqli_error($conexionbanca));
                    $row_Recordset55 = mysqli_fetch_assoc($Recordset55);
                    $totalRows_Recordset55 = mysqli_num_rows($Recordset55);
                    $saldoactuala=$row_Recordset55['saldoactuala'];
                    $saldoactual=$row_Recordset55['saldoactual'];
                    $tipo_pagoa=$row_Recordset55['tipo_pagoa'];
                    $tipo_pago=$row_Recordset55['tipo_pago'];
                    $usdabss=$row_Recordset55['usdabss'];
                    $copabss=$row_Recordset55['copabss'];
                    $solabss=$row_Recordset55['solabss'];
                    $tasa=1;
                    if ($_POST['efectivoO']<=2) {
                        $tasa=1;
                    }
                    if ($_POST['efectivoO']==3) {
                        $tasa=$usdabss;
                    }
                    if ($_POST['efectivoO']==4) {
                        $tasa=$copabss;
                    }
                    if ($_POST['efectivoO']==5) {
                        $tasa=$solabss;
                    }

                    // si monto es menor
                    if ($_POST['efectivoO']<=2 && $monto[$t-1]<$apuestasminimaaganadorbss0) {
                        $valida=0;
                        $mMenG2bss=1;
                        $exito=0;
                        break;
                    }
                    if ($_POST['efectivoO']==3 && $monto[$t-1]<$apuestasminimaaganadorusd1) {
                        $valida=0;
                        $mMenG2usd=1;
                        $exito=0;
                        break;
                    }
                    if ($_POST['efectivoO']==4 && $monto[$t-1]<$apuestasminimaaganadorpc2) {
                        $valida=0;
                        $mMenG2pc=1;
                        $exito=0;
                        break;
                    }
                    if ($_POST['efectivoO']==5 && $monto[$t-1]<$apuestasminimaaganadorsp3) {
                        $valida=0;
                        $mMenG2sp=1;
                        $exito=0;
                        break;
                    }
                
                    
                    
                    
                    
                    
                    
                    
                    
                    if ($tipo[$t-1]==1) { // ganador
                        if ($monto[$t-1]<$apu_mingan) {
                            $valida=0;
                            $mMenG2=1;
                            $exito=0;
                            break;
                        } //
                    } elseif ($tipo[$t-1]==2) { // pace
                        if ($monto[$t-1]<$apu_minpla) {
                            $valida=0;
                            $mMenP2=1;
                            $exito=0;
                            break;
                        } //
                    } elseif ($tipo[$t-1]==3) { // show
                        if ($monto[$t-1]<$apu_minsho) {
                            $valida=0;
                            $mMenS2=1;
                            $exito=0;
                            break;
                        } //
                    } elseif ($tipo[$t-1]==4 || $tipo[$t-1]==7) { // exacta
                        if ($monto[$t-1]<$apu_minexa) {
                            $valida=0;
                            $mMenEx2=1;
                            $exito=0;
                            break;
                        } //
                    } elseif ($tipo[$t-1]==5 || $tipo[$t-1]==8) { // trifecta
                        if ($monto[$t-1]<$apu_mintri) {
                            $valida=0;
                            $mMenTr2=1;
                            $exito=0;
                            break;
                        } //
                    } elseif ($tipo[$t-1]==6 || $tipo[$t-1]==9) { // superfecta
                        if ($monto[$t-1]<$apu_minsup) {
                            $valida=0;
                            $mMenSu2=1;
                            $exito=0;
                            break;
                        } //
                    }
                    $totalTicket=$totalTicket+$monto[$t-1];
                    $t++;
                }
                echo $row_Recordset18['cod_taquilla'];
                $query_Recordset55 = sprintf(
                    "
/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 10 */ SELECT 
tasadecambio.usdabss, tasadecambio.copabss, tasadecambio.solabss, 
agencia.tipo_pagoa, agencia.saldoactuala,
taquilla.tipo_pago, taquilla.saldoactual
FROM 
tasadecambio, taquilla, agencia
WHERE 
taquilla.cod_taquilla = %s AND
taquilla.cod_agencia = agencia.cod_agencia AND
tasadecambio.Idtasadecambio = %s",
                    GetSQLValueString($row_Recordset18['cod_taquilla'], "int"),
                    GetSQLValueString(1, "int")
                );
                $Recordset55 = mysqli_query($conexionbanca, $query_Recordset55) or die(mysqli_error($conexionbanca));
                $row_Recordset55 = mysqli_fetch_assoc($Recordset55);
                $totalRows_Recordset55 = mysqli_num_rows($Recordset55);
                $saldoactuala=$row_Recordset55['saldoactuala'];
                $saldoactual=$row_Recordset55['saldoactual'];
                $tipo_pagoa=$row_Recordset55['tipo_pagoa'];
                $tipo_pago=$row_Recordset55['tipo_pago'];
                $usdabss=$row_Recordset55['usdabss'];
                $copabss=$row_Recordset55['copabss'];
                $solabss=$row_Recordset55['solabss'];
                $tasa=1;
                if ($_POST['efectivoO']<=2) {
                    $tasa=1;
                }
                if ($_POST['efectivoO']==3) {
                    $tasa=$usdabss;
                }
                if ($_POST['efectivoO']==4) {
                    $tasa=$copabss;
                }
                if ($_POST['efectivoO']==5) {
                    $tasa=$solabss;
                }

                $totalTicketx=$totalTicket*$tasa;
            
            
            
            
                if ($totalTicket>$saldoactual && $tipo_pago==1) {
                    $valida=0;
                    $saldobajo=1;
                    $exito=0;  //Monto de ticket excedido
                }
                if ($totalTicket>$saldoactuala && $tipo_pagoa==1) {
                    $valida=0;
                    $saldobajoa=1;
                    $exito=0;  //Monto de ticket excedido
                }

                
                
                
                
                
                if ($totalTicket>$mon_maxticket) {
                    $valida=0;
                    $mMonTic=1;
                    $exito=0;  //Monto de ticket excedido
                }

                if ($totalTicket>500 && $_POST['efectivoO']==3) {
                    $valida=0;
                    $mMonTicusd500=1;
                    $exito=0;  //Monto de ticket excedido en usd
                }

                if ($totalTicket==0) {
                    $valida=0;
                    $montoT=1;
                    $exito=0;  //Monto de ticket excedido
                }
            }
            if ($min_ejecarrera>$vanEnCarrera) {
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
                $volver=0;
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
        } elseif (isset($mExEjCar) && $mExEjCar>$vanEnCarrera) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Excede Ejemplares en carrera";
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
        } elseif (isset($CRet7) && $CRet7==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Existe ejemplares retirados en la jugada -".$mRet7;
        } elseif (isset($CRet8) && $CRet8==1) {
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
        } elseif (isset($cTipJugGa) && $cTipJugGa==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Jugada a ganador no permitida por el banquero";
        } elseif (isset($cTipJugPl) && $cTipJugPl==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Jugada a place no permitida por el banquero";
        } elseif (isset($cTipJugSh) && $cTipJugSh==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Jugada a show no permitida por el banquero";
        } elseif (isset($cTipJugEx) && $cTipJugEx==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Jugada exacta no permitida por el banquero";
        } elseif (isset($cTipJugTr) && $cTipJugTr==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Jugada trifecta no permitida por el banquero";
        } elseif (isset($cTipJugSu) && $cTipJugSu==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Jugada superfecta no permitida por el banquero";
        } elseif (isset($mMonTic) && $mMonTic==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Monto de ticket excedido";
        } elseif (isset($mMonTicusd500) && $mMonTicusd500==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Monto en USD Supera el maximo de 500 USD";
        } elseif (isset($saldobajo) && $saldobajo==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="..Monto excede saldo recargue por favor";
        } elseif (isset($saldobajoa) && $saldobajoa==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="..Monto excede saldo en agente comunique al encargador";
        } elseif (isset($mMenG2bss) && $mMenG2bss==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Monto menor al minimo permitido en bss ".$apuestasminimaaganadorbss0;
        } elseif (isset($mMenG2usd) && $mMenG2usd==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Monto menor al minimo permitido en usd ".$apuestasminimaaganadorusd1;
        } elseif (isset($mMenG2pc) && $mMenG2pc==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Monto menor al minimo permitido en pesos ".$apuestasminimaaganadorpc2;
        } elseif (isset($cExMonGa2sp) && $cExMonGa2sp==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Monto menor al minimo permitido en soles ".$apuestasminimaaganadorsp3;
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
            $_SESSION['MM_mensaje3']="Excede monto de APUESTA MÁXIMA a GANADOR por ticket";
        } elseif (isset($cExMonPl) && $cExMonPl==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Excede monto de APUESTA MÁXIMA a PLACE por ticket";
        } elseif (isset($cExMonSh) && $cExMonSh==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Excede monto de APUESTA MÁXIMA SHOW por ticket";
        } elseif (isset($cExMonEx) && $cExMonEx==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Excede monto de APUESTA MÁXIMA en EXACTA por ticket";
        } elseif (isset($cExMonTr) && $cExMonTr==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Excede monto de APUESTA MÁXIMA a TRIFECTA por ticket";
        } elseif (isset($cExMonSu) && $cExMonSu==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="Excede monto de APUESTA MÁXIMA a SUPERFECTA por ticket";
        } elseif (isset($cMonMaxGa) && $cMonMaxGa==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="<font size=3>Limite a GANADOR excedido en ejemplar #".$mEjeMax."</font>";
        } elseif (isset($cMonMaxPl) && $cMonMaxPl==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="<font size=3>Limite a PLACE excedido en ejemplar #".$mEjeMax."</font>";
        } elseif (isset($cMonMaxSh) && $cMonMaxSh==1) {
            $iR=1;
            $_SESSION['MM_mensaje3']="<font size=3>Limite en SHOW excedido en ejemplar #".$mEjeMax."</font>";
        }
    }
}
if ($volver==1) {
    if (isset($_POST["xindex"])) {
        $xindex=1;
    } else {
        $xindex=0;
    }
    if (isset($_POST["xindex"])) {
        $insertGoTo = "index_ventas.php";
    } else {
        $insertGoTo = "index.php";
    }
    //imprimir ticket
    if (isset($imprime)&&$imprime==1) {
        $insertGoTo = "t_imprimeticket.php?recordID=$numerotiket2&uVenta=$usuario&xIndex=$xindex";
    }
    header(sprintf("Location: %s", $insertGoTo));
}
$tra_codigo=$_POST["tra_codigo"];
$query_Recordset115 = sprintf(
    "/* PARSEADORES1 new\ventasmie\rapuesta_codigo_clientes.php - QUERY 11 */ SELECT ve.cod_cliente 
		FROM 
			usuario us, 
			taquilla ta, 
			venta ve 
		WHERE 
			us.id_usuario = %s AND 
			us.cod_taquilla = ta.cod_taquilla AND
			ve.cod_taquilla = us.cod_taquilla AND
			ve.tra_codigo = 1 AND
			ve.fec_venta = %s 
		GROUP BY ve.cod_cliente",
    GetSQLValueString($usuario, "int"),
    GetSQLValueString(fechaactualbd(), "date")
);
$Recordset115 = mysqli_query($conexionbanca, $query_Recordset115) or die(mysqli_error($conexionbanca));
$row_Recordset115 = mysqli_fetch_assoc($Recordset115);
$totalRows_Recordset115 = mysqli_num_rows($Recordset115);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link href="../estilo/ventasmie.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 6]><script type="text/javascript">alert("ATENCIÓN: Este software solo funciona con \nMicrosoft Internet Explorer 6 o superior\n\nPor favor, actualice su navegador");location.href='../index.php';</script><![endif]-->
<!--[if lt IE 8]><link href="../estilo/styleIE7.css" rel="stylesheet"> <!--<![endif]-->
<style> body{ background:#e0e0e0;} input:focus{ outline:none !important;border-color:#719ECE;box-shadow:0 0 20px #719ECE;
font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif} 
input#cancelar{cursor:pointer;padding:5px 18px;border:1px solid #D70000;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;-webkit-box-shadow:0 0 4px rgba(0,0,0, .75);-moz-box-shadow:0 0 4px rgba(0,0,0, .75);box-shadow:0 0 4px rgba(0,0,0, .75);color:#f3f3f3;font-size:1em;background-color:#D70000;text-shadow:1 2px 0px rgba(0, 0, 0, 0.3);}input#cancelar:hover,input#cancelar:focus{background-color:#A80000;-webkit-box-shadow:0 0 1px rgba(0,0,0, .75);-moz-box-shadow:0 0 1px rgba(0,0,0, .75);box-shadow:0 0 1px rgba(0,0,0, .75)}
input#aceptar{cursor:pointer;padding:5px 14px;background:#35b128;border:1px solid #33842a;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;-webkit-box-shadow:0 0 4px rgba(0,0,0, .75);-moz-box-shadow:0 0 4px rgba(0,0,0, .75);box-shadow:0 0 4px rgba(0,0,0, .75);color:#f3f3f3;font-size:1em;text-shadow:1 2px 0px rgba(0, 0, 0, 0.3);}input#aceptar:hover,input#aceptar:focus{background-color:#399630;-webkit-box-shadow:0 0 1px rgba(0,0,0, .75);-moz-box-shadow:0 0 1px rgba(0,0,0, .75);box-shadow:0 0 1px rgba(0,0,0, .75)}

input#generar{cursor:pointer;padding:5px 14px;background:#0072C6;border:1px solid #005F87;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;-webkit-box-shadow:0 0 4px rgba(0,0,0, .75);-moz-box-shadow:0 0 4px rgba(0,0,0, .75);box-shadow:0 0 4px rgba(0,0,0, .75);color:#f3f3f3;font-size:1em;text-shadow:1 2px 0px rgba(0, 0, 0, 0.3);}input#generar:hover,input#generar:focus{background-color:#0072C6;-webkit-box-shadow:0 0 1px rgba(0,0,0, .75);-moz-box-shadow:0 0 1px rgba(0,0,0, .75);box-shadow:0 0 1px rgba(0,0,0, .75)}
</style>
<script src="../js/jquery-1.9.1.min.js"></script>
<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true;}else{alert("Datos enviados por favor presione enter solo una vez mas.");return false;}}
function handleEnter (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		alert();
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	} 
	else
	return true;
} 
</script>
</head>
<body onload="javascript:document.all.form12.focus(); Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<form action="<?php echo $editFormAction; ?>" method="post" name="form12" id="form12" autocomplete="off"
		onsubmit="return chequearEnvio();">
        <table width="50%" border="0" cellpadding="0" cellspacing="0" 
        	style="line-height:12px; font-size:16px; background:#FFF; color:#0287AF">
            <tr>
                <td height="39" colspan="2" style="background:#e0e0e0; font-size:18px">
                	<font color="#FF0004"><?php echo $mensaje_cliente; ?></font>
                </td>
            </tr>
            <tr>
            	<td height="25" colspan="2" style="background:#0287AF;color:#FFF">VERIFIQUE LA JUGADA Y ACEPTE SI ES CORRECTA</td>
			</tr>
            <tr>
                <td colspan="2" align="center">CODIGO CLIENTE:
                    <input class="textbox" tabindex="0" 
                    type="text" name="cod_cliente" style="width:140px; font-size:22px" 
                    maxlength="15" value="" id="cod_cliente" 
                    onKeyDown="return handleEnter(this, event)" title="indique codigo cliente"/><?php
                    if ($totalRows_Recordset115>0) {?>
                        <select name="cod_cliente2" tabindex="4" style="font-size:16px; width:280px; height:28px">
                        	<option value="-1X" style="background: #C15; color:#FFFFFF;">
                        		<?php echo "SELECCIONE CODIGO AQUI";?>
                        	</option><?php
                            do {?>
								<option value="<?php echo $row_Recordset115['cod_cliente'];?>">
									<?php echo $row_Recordset115['cod_cliente'];?>
								</option><?php
                            } while ($row_Recordset115 = mysqli_fetch_assoc($Recordset115));?>
						</select><?php
                    } else {?>
                    	<input type="hidden" name="cod_cliente2" value="-1X" /><?php
                    }?>
				</td>
            </tr>
            <tr>
                <td width="50%" height="30" align="center">
                	HIPODROMO:&nbsp;<font color="#000000"><?php echo $nom_hipodromo; ?></font>
                </td>
                <td width="50%" align="center">CARRERA:&nbsp;<font color="#000000"><?php echo $num_carrera; ?></font></td>
            </tr>
        </table>
      <table width="50%" border="0" cellpadding="0" cellspacing="0" 
        	style="line-height:12px; font-size:16px; background:#FFF; color:#0287AF">
        	<tr>
                <td width="20%" height="21" align="center">EJEMPLAR</td>
                <td width="30%" align="center">TIPO DE APUESTA</td>
                <td width="50%" align="center">APOSTADO</td>
            </tr><?php
            $s=0;
            $apostado=0;
            foreach ($apuesta as $apta) {
                $apostado=$apostado+$monto[$s]; ?>
                <tr>
                    <td height="21" align="center">
						<font color="#000000"><?php echo $apta; ?></font>
                    </td>
                    <td align="center">
						<font color="#000000">
						<?php
                        if ($tipo[$s]=="1") {
                            echo "GANADOR";
                        } elseif ($tipo[$s]=="2") {
                            echo "PLACE";
                        } elseif ($tipo[$s]=="3") {
                            echo "SHOW";
                        } elseif ($tipo[$s]=="4") {
                            echo "EXACTA";
                        } elseif ($tipo[$s]=="5") {
                            echo "TRIFECTA";
                        } elseif ($tipo[$s]=="6") {
                            echo "SUPERFECTA";
                        } elseif ($tipo[$s]=="7") {
                            echo "(P)EXACTA";
                        } elseif ($tipo[$s]=="8") {
                            echo "(P)TRIFECTA";
                        } elseif ($tipo[$s]=="9") {
                            echo "(P)SUPERFECTA";
                        } ?>
                        </font>
                        <input type="hidden" name="apuesta[]" value="<?php echo $apta; ?>" />
                        <input type="hidden" name="tipo[]" value="<?php echo $tipo[$s]; ?>" />
                        <input type="hidden" name="monto[]" value="<?php echo $monto[$s]; ?>" />

<?php
    $_POST["efectivoO"]=$_POST["efectivoO"]/1; ?> 


                        <input type="hidden" name="efectivoOxxx" value="<?php echo $_POST['efectivoO']; ?>" />

                    </td>
                    <td align="center">
						<font color="#000000"><?php echo $monto[$s]; ?></font>
<?php
if ($_POST["efectivoO"]==1) {
        echo '<br/><br/>APOSTADO POR DEBITO BSS';
    }
                if ($_POST["efectivoO"]==2) {
                    echo '<br/><br/>APOSTADO POR TRANSFERENCIA BSS';
                }
                if ($_POST["efectivoO"]==3) {
                    echo '<br/><br/>APOSTADO POR DOLAR AMERICANO';
                }
                if ($_POST["efectivoO"]==4) {
                    echo '<br/><br/>APOSTADO POR PESO COLOMBIANO';
                }
                if ($_POST["efectivoO"]==5) {
                    echo '<br/><br/>APOSTADO POR SOLES PERUANOS';
                } ?>

                    </td>
                </tr><?php
                $s++;
            }?> 
        	<tr>
                <td colspan="3" height="21" align="right">TOTAL:<font color="#000000"><?php echo $apostado; ?>&nbsp;</font></td>
            </tr> 
        </table>
      <table width="50%" border="0" cellpadding="0" cellspacing="0" 
        	style="line-height:12px; font-size:16px; background:#FFF; color:#0287AF">
            <tr>
                <td width="50%" height="50" align="center">
					<input type="submit" id="aceptar" name="aceptar" 
					value="ACEPTE" onKeyDown="return handleEnter(this, event)"
					tabindex="1" title="realiza apuesta"/>
                </td>
		  </tr><?php
          if ($tra_codigo==2) {?>
            <tr>
                <td width="50%" height="50" align="center">
					<input type="submit" id="generar" name="generar" 
					value="GENERE TICKET" onKeyDown="return handleEnter(this, event)"
					tabindex="2" title="realiza apuesta e imprime"/>
                </td>
		  </tr><?php
          }

?>
            <tr>
              <td width="50%" height="50" align="center">
					<input type="submit" id="cancelar" name="cancelar" tabindex="3" onKeyDown="return handleEnter(this, event)"
					value="CANCELE" title="cancela apuesta"/>
                </td>
            </tr>
        </table>
		<input type="hidden" name="MM_insert12" value="form12" />
		<input type="hidden" name="usuario" value="<?php echo $usuario; ?>" />
		<input type="hidden" name="cod_taquilla" value="<?php echo $cod_taquilla; ?>" />
		<input type="hidden" name="tra_codigo" value="<?php echo $tra_codigo; ?>" />
		<input type="hidden" name="cod_carrera12" value="<?php echo $cod_carrera; ?>" />
	</form>
</body>
</html>
<script language="javascript">document.getElementById("cod_cliente").focus();</script>
<?php
mysqli_free_result($Recordset115);?>
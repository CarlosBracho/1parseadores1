<?php
require_once('../Connections/conexionbanca.php');
include("../includes/montosminimos.php");
$maximo=0;
$minimo=0;
function ObtenerMontoEjeTaq($codT, $fecV, $numE, $codC, $codA)
{
    global $conexionbanca;
    $query_Recordset11 = sprintf(
        "/* PARSEADORES1 apostador\grabarjugada.php - QUERY 1 */ SELECT 
		SUM(mon_venta) AS total FROM venta 
	WHERE cod_taquilla = %s AND fec_venta = %s AND num_caballo = %s AND cod_carrera = %s AND cod_tventa = %s AND est_ticket = 1",
        GetSQLValueString($codT, "int"),
        GetSQLValueString($fecV, "date"),
        GetSQLValueString($numE, "text"),
        GetSQLValueString($codC, "int"),
        GetSQLValueString($codA, "int")
    );
    $Recordset11 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
    $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
    $total=$row_Recordset11['total'];

    mysqli_free_result($Recordset1);
    return $total;
}
$fechasistema=fechaactualbd();

$query_Recordset1 = sprintf(
    "/* PARSEADORES1 apostador\grabarjugada.php - QUERY 2 */ SELECT can_caballos, hor_carrera, fec_carrera, est_carrera, pau_ventas, cod_carrera
								 FROM carrera
								 WHERE cod_carrera = %s 
								 LIMIT 1",
    GetSQLValueString($_POST['cod_carrera'], "int")
);
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $tp1=0; $ju1=0; $tp2=0; $ju2=0; $tp3=0; $ju3=0;	$tp4=0; $ju4=0;
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $cCab=$row_Recordset1['can_caballos']; // cantidad de caballo
    $cod_carrera=$row_Recordset1['cod_carrera'];
    $fechacarrerabd=$row_Recordset1['fec_carrera'];
    $horacarrerabd=$row_Recordset1['hor_carrera'];
    $statuscarrerabd=$row_Recordset1['est_carrera'];
    $pau_ventas=$row_Recordset1['pau_ventas'];
    $usuarioVenta=$_POST["id_usuario"];
    $codigoTaquilla=$_POST["cod_taquilla"];
    $ipVenta=getRealIP();
    $cantTicket=ObtenerNumeroJugada($usuarioVenta, $fechasistema)+1;
    $numerotiket2=$usuarioVenta.ObtenerUltimaVenta();
    $serial=generarCodigo(5, $numerotiket2);
    $maxCa=0; // bandera maxima de caballo
    $_POST["tipotaquilla"]=((int)$_POST["tipotaquilla"]/(int)1);
    $tipotaquilla=$_POST["tipotaquilla"];
    $_POST["saldoactual"]=((float)$_POST["saldoactual"]/(float)1);
    $saldoactual=$_POST["saldoactual"];
    $_POST["tra_codigo"]=((int)$_POST["tra_codigo"]/(int)1);
    $tra_codigo=$_POST["tra_codigo"];
    $_POST["tipo_pago"]=((int)$_POST["tipo_pago"]/(int)1);
    $tipo_pago=$_POST["tipo_pago"];
        $_POST["tipo_pagoa"]=((int)$_POST["tipo_pagoa"]/(int)1);
    $tipo_pagoa=$_POST["tipo_pagoa"];
    $_POST["cod_agencia"]=((int)$_POST["cod_agencia"]/(int)1);
    $cod_agencia=$_POST["cod_agencia"];
        $_POST["moneda"]=((int)$_POST["moneda"]/(int)1);
    $moneda=$_POST["moneda"];
        $_POST["apMinGan"]=((float)$_POST["apMinGan"]/(float)1);
    $apMinGan=$_POST["apMinGan"];
        $_POST["apMaxGan"]=((float)$_POST["apMaxGan"]/(float)1);
    $apGaMax=$_POST["apMaxGan"];
    $exito=1; $mensaje="";
                            $query_Recordset13 = sprintf(
                                "/* PARSEADORES1 apostador\grabarjugada.php - QUERY 3 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
                                GetSQLValueString($_POST['moneda'], "int"),
                                GetSQLValueString($codigoTaquilla, "int")
                            );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    $Idbalancecli=((int)$row_Recordset13['MAX(Idbalancecli)']);
    
                            $query_Recordset14 = sprintf(
                                "/* PARSEADORES1 apostador\grabarjugada.php - QUERY 4 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
                                GetSQLValueString($_POST['moneda'], "int"),
                                GetSQLValueString($Idbalancecli, "int")
                            );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    $saldoactualc=((float)$row_Recordset14['saldoactualc']);
    $ret=0;

if ($fechacarrerabd == $FechaTxt && $horacarrerabd > $horaTxt && $statuscarrerabd == 1) {
    $carreracerrada=1;
} else {
    $carreracerrada=0;
    $mensaje="Carrera cerrada por favor actualice pagina";
}
    
    if ($moneda <= 2) {
        $minimo=$apuestasminimaaganadorbss0;
        $minimoes=$apuestasminimaaganadorbss0.'BSS';
        $maximoes=($apuestasminimaaganadorbss0*5000).'BSS';
        $minimoban=($apMinGan*$usdalcambiodolartoday);
        $minimobanes=$minimoban.'BSS';
        $maximoban=($apGaMax*$usdalcambiodolartoday);
        $maximobanes=$maximoban.'BSS';
    }
    if ($moneda == 3) {
        $minimo=$apuestasminimaaganadorusd1;
        $minimoes=$apuestasminimaaganadorusd1.'USD';
        $maximoes=($apuestasminimaaganadorusd1*5000).'USD';
        $minimoban=$apMinGan;
        $minimobanes=$minimoban.'USD';
        $maximoban=$apGaMax;
        $maximobanes=$maximoban.'USD';
    }
    if ($moneda == 4) {
        $minimo=$apuestasminimaaganadorpc2;
        $minimoes=$apuestasminimaaganadorpc2.'COP';
        $maximoes=($apuestasminimaaganadorpc2*5000).'COP';
        $minimoban=($apMinGan*3500);
        $minimobanes=$minimoban.'COP';
        $maximoban=($apGaMax*3500);
        $maximobanes=$maximoban.'COP';
    }
    if ($moneda == 5) {
        $minimo=$apuestasminimaaganadorsp3;
        $minimoes=$apuestasminimaaganadorsp3.'SOL';
        $maximoes=($apuestasminimaaganadorsp3*5000).'SOL';
        $minimoban=($apMinGan*3.53);
        $minimobanes=$minimoban.'SOL';
        $maximoban=($apGaMax*3.53);
        $maximobanes=$maximoban.'SOL';
    }


    $maximo=$minimo*5000;
if ($carreracerrada==1) {
    if (empty($_POST["monGan1"])) {
        $monGan1=0;
    } else {
        $monGan1=$_POST["monGan1"];
    }
    if (empty($_POST["monPla1"])) {
        $monPla1=0;
    } else {
        $monPla1=$_POST["monPla1"];
    }
    if (empty($_POST["monSho1"])) {
        $monSho1=0;
    } else {
        $monSho1=$_POST["monSho1"];
    }
    $mon1=$monGan1+$monPla1+$monSho1;
    if ($mon1!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 1);
    }
    if (empty($_POST["monGan2"])) {
        $monGan2=0;
    } else {
        $monGan2=$_POST["monGan2"];
    }
    if (empty($_POST["monPla2"])) {
        $monPla2=0;
    } else {
        $monPla2=$_POST["monPla2"];
    }
    if (empty($_POST["monSho2"])) {
        $monSho2=0;
    } else {
        $monSho2=$_POST["monSho2"];
    }
    $mon2=$monGan2+$monPla2+$monSho2;
    if ($mon2!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 2);
    }
    if (empty($_POST["monGan3"])) {
        $monGan3=0;
    } else {
        $monGan3=$_POST["monGan3"];
    }
    if (empty($_POST["monPla3"])) {
        $monPla3=0;
    } else {
        $monPla3=$_POST["monPla3"];
    }
    if (empty($_POST["monSho3"])) {
        $monSho3=0;
    } else {
        $monSho3=$_POST["monSho3"];
    }
    $mon3=$monGan3+$monPla3+$monSho3;
    if ($mon3!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 3);
    }
    if (empty($_POST["monGan4"])) {
        $monGan4=0;
    } else {
        $monGan4=$_POST["monGan4"];
    }
    if (empty($_POST["monPla4"])) {
        $monPla4=0;
    } else {
        $monPla4=$_POST["monPla4"];
    }
    if (empty($_POST["monSho4"])) {
        $monSho4=0;
    } else {
        $monSho4=$_POST["monSho4"];
    }
    $mon4=$monGan4+$monPla4+$monSho4;
    if ($mon4!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 4);
    }
    if (empty($_POST["monGan5"])) {
        $monGan5=0;
    } else {
        $monGan5=$_POST["monGan5"];
    }
    if (empty($_POST["monPla5"])) {
        $monPla5=0;
    } else {
        $monPla5=$_POST["monPla5"];
    }
    if (empty($_POST["monSho5"])) {
        $monSho5=0;
    } else {
        $monSho5=$_POST["monSho5"];
    }
    $mon5=$monGan5+$monPla5+$monSho5;
    if ($mon5!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 5);
    }
    if (empty($_POST["monGan6"])) {
        $monGan6=0;
    } else {
        $monGan6=$_POST["monGan6"];
    }
    if (empty($_POST["monPla6"])) {
        $monPla6=0;
    } else {
        $monPla6=$_POST["monPla6"];
    }
    if (empty($_POST["monSho6"])) {
        $monSho6=0;
    } else {
        $monSho6=$_POST["monSho6"];
    }
    $mon6=$monGan6+$monPla6+$monSho6;
    if ($mon6!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 6);
    }
    if (empty($_POST["monGan7"])) {
        $monGan7=0;
    } else {
        $monGan7=$_POST["monGan7"];
    }
    if (empty($_POST["monPla7"])) {
        $monPla7=0;
    } else {
        $monPla7=$_POST["monPla7"];
    }
    if (empty($_POST["monSho7"])) {
        $monSho7=0;
    } else {
        $monSho7=$_POST["monSho7"];
    }
    $mon7=$monGan7+$monPla7+$monSho7;
    if ($mon7!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 7);
    }
    if (empty($_POST["monGan8"])) {
        $monGan8=0;
    } else {
        $monGan8=$_POST["monGan8"];
    }
    if (empty($_POST["monPla8"])) {
        $monPla8=0;
    } else {
        $monPla8=$_POST["monPla8"];
    }
    if (empty($_POST["monSho8"])) {
        $monSho8=0;
    } else {
        $monSho8=$_POST["monSho8"];
    }
    $mon8=$monGan8+$monPla8+$monSho8;
    if ($mon8!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 8);
    }
    if (empty($_POST["monGan9"])) {
        $monGan9=0;
    } else {
        $monGan9=$_POST["monGan9"];
    }
    if (empty($_POST["monPla9"])) {
        $monPla9=0;
    } else {
        $monPla9=$_POST["monPla9"];
    }
    if (empty($_POST["monSho9"])) {
        $monSho9=0;
    } else {
        $monSho9=$_POST["monSho9"];
    }
    $mon9=$monGan9+$monPla9+$monSho9;
    if ($mon9!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 9);
    }
    if (empty($_POST["monGan10"])) {
        $monGan10=0;
    } else {
        $monGan10=$_POST["monGan10"];
    }
    if (empty($_POST["monPla10"])) {
        $monPla10=0;
    } else {
        $monPla10=$_POST["monPla10"];
    }
    if (empty($_POST["monSho10"])) {
        $monSho10=0;
    } else {
        $monSho10=$_POST["monSho10"];
    }
    $mon10=$monGan10+$monPla10+$monSho10;
    if ($mon10!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 10);
    }
    if (empty($_POST["monGan11"])) {
        $monGan11=0;
    } else {
        $monGan11=$_POST["monGan11"];
    }
    if (empty($_POST["monPla11"])) {
        $monPla11=0;
    } else {
        $monPla11=$_POST["monPla11"];
    }
    if (empty($_POST["monSho11"])) {
        $monSho11=0;
    } else {
        $monSho11=$_POST["monSho11"];
    }
    $mon11=$monGan11+$monPla11+$monSho11;
    if ($mon11!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 11);
    }
    if (empty($_POST["monGan12"])) {
        $monGan12=0;
    } else {
        $monGan12=$_POST["monGan12"];
    }
    if (empty($_POST["monPla12"])) {
        $monPla12=0;
    } else {
        $monPla12=$_POST["monPla12"];
    }
    if (empty($_POST["monSho12"])) {
        $monSho12=0;
    } else {
        $monSho12=$_POST["monSho12"];
    }
    $mon12=$monGan12+$monPla12+$monSho12;
    if ($mon12!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 12);
    }
    if (empty($_POST["monGan13"])) {
        $monGan13=0;
    } else {
        $monGan13=$_POST["monGan13"];
    }
    if (empty($_POST["monPla13"])) {
        $monPla13=0;
    } else {
        $monPla13=$_POST["monPla13"];
    }
    if (empty($_POST["monSho13"])) {
        $monSho13=0;
    } else {
        $monSho13=$_POST["monSho13"];
    }
    $mon13=$monGan13+$monPla13+$monSho13;
    if ($mon13!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 13);
    }
    if (empty($_POST["monGan14"])) {
        $monGan14=0;
    } else {
        $monGan14=$_POST["monGan14"];
    }
    if (empty($_POST["monPla14"])) {
        $monPla14=0;
    } else {
        $monPla14=$_POST["monPla14"];
    }
    if (empty($_POST["monSho14"])) {
        $monSho14=0;
    } else {
        $monSho14=$_POST["monSho14"];
    }
    $mon14=$monGan14+$monPla14+$monSho14;
    if ($mon14!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 14);
    }
    if (empty($_POST["monGan15"])) {
        $monGan15=0;
    } else {
        $monGan15=$_POST["monGan15"];
    }
    if (empty($_POST["monPla15"])) {
        $monPla15=0;
    } else {
        $monPla15=$_POST["monPla15"];
    }
    if (empty($_POST["monSho15"])) {
        $monSho15=0;
    } else {
        $monSho15=$_POST["monSho15"];
    }
    $mon15=$monGan15+$monPla15+$monSho15;
    if ($mon15!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 15);
    }
    if (empty($_POST["monGan16"])) {
        $monGan16=0;
    } else {
        $monGan16=$_POST["monGan16"];
    }
    if (empty($_POST["monPla16"])) {
        $monPla16=0;
    } else {
        $monPla16=$_POST["monPla16"];
    }
    if (empty($_POST["monSho16"])) {
        $monSho16=0;
    } else {
        $monSho16=$_POST["monSho16"];
    }
    $mon16=$monGan16+$monPla16+$monSho16;
    if ($mon16!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 16);
    }
    if (empty($_POST["monGan17"])) {
        $monGan17=0;
    } else {
        $monGan17=$_POST["monGan17"];
    }
    if (empty($_POST["monPla17"])) {
        $monPla17=0;
    } else {
        $monPla17=$_POST["monPla17"];
    }
    if (empty($_POST["monSho17"])) {
        $monSho17=0;
    } else {
        $monSho17=$_POST["monSho17"];
    }
    $mon17=$monGan17+$monPla17+$monSho17;
    if ($mon17!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 17);
    }
    if (empty($_POST["monGan18"])) {
        $monGan18=0;
    } else {
        $monGan18=$_POST["monGan18"];
    }
    if (empty($_POST["monPla18"])) {
        $monPla18=0;
    } else {
        $monPla18=$_POST["monPla18"];
    }
    if (empty($_POST["monSho18"])) {
        $monSho18=0;
    } else {
        $monSho18=$_POST["monSho18"];
    }
    $mon18=$monGan18+$monPla18+$monSho18;
    if ($mon18!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 18);
    }
    if (empty($_POST["monGan19"])) {
        $monGan19=0;
    } else {
        $monGan19=$_POST["monGan19"];
    }
    if (empty($_POST["monPla19"])) {
        $monPla19=0;
    } else {
        $monPla19=$_POST["monPla19"];
    }
    if (empty($_POST["monSho19"])) {
        $monSho19=0;
    } else {
        $monSho19=$_POST["monSho19"];
    }
    $mon19=$monGan19+$monPla19+$monSho19;
    if ($mon19!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 19);
    }
    if (empty($_POST["monGan20"])) {
        $monGan20=0;
    } else {
        $monGan20=$_POST["monGan20"];
    }
    if (empty($_POST["monPla20"])) {
        $monPla20=0;
    } else {
        $monPla20=$_POST["monPla20"];
    }
    if (empty($_POST["monSho20"])) {
        $monSho20=0;
    } else {
        $monSho20=$_POST["monSho20"];
    }
    $mon20=$monGan20+$monPla20+$monSho20;
    if ($mon20!=0 && $ret==0) {
        $Ret=RetiradosSimple($cod_carrera, 20);
    }
    
    
    if ($Ret!=0) {
        $mensaje="Existen caballos retirados en la jugada";
    } else {
        $montototalapos=$mon1+$mon2+$mon3+$mon4+$mon5+$mon6+$mon7+$mon8+$mon9+$mon10+$mon11+$mon12+$mon13+$mon14+$mon15+$mon16+$mon17+$mon18+$mon19+$mon20;
        if ($montototalapos<$minimoban) {
            $mensaje="Monto Apostado es Menor al Minimo Permitido Por El Banquero ".$minimobanes;
        } else {
            if ($montototalapos<$minimo) {
                $mensaje="Monto Apostado es Menor al Minimo ".$minimoes;
            } else {
                if ($montototalapos>$maximoban) {
                    $mensaje="Monto Apostado es Mayor al Maximo Permitido Por El Banquero ".$maximobanes;
                } else {
                    if ($montototalapos>$maximo) {
                        $mensaje="Monto Apostado es Mayor al Maximo Permitido ".$maximoes;
                    } else {
                        if ($montototalapos>$saldoactualc) {
                            $mensaje="Monto Apostado exede saldo disponible";
                        } else {
                            if ($exito==1) {
                                $numcaballo=0;
                                $linea=1;
                                if (empty($_POST["monGan1"])) {
                                } else {
                                    if ($_POST["monGan1"]>=0.1) {
                                        $numcaballo=1;
                                        $tipo=1;
                                        $monto=$_POST["monGan1"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla1"])) {
                                } else {
                                    if ($_POST["monPla1"]>=0.1) {
                                        $numcaballo=1;
                                        $tipo=2;
                                        $monto=$_POST["monPla1"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho1"])) {
                                } else {
                                    if ($_POST["monSho1"]>=0.1) {
                                        $numcaballo=1;
                                        $tipo=3;
                                        $monto=$_POST["monSho1"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan2"])) {
                                } else {
                                    if ($_POST["monGan2"]>=0.1) {
                                        $numcaballo=2;
                                        $tipo=1;
                                        $monto=$_POST["monGan2"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla2"])) {
                                } else {
                                    if ($_POST["monPla2"]>=0.1) {
                                        $numcaballo=2;
                                        $tipo=2;
                                        $monto=$_POST["monPla2"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho2"])) {
                                } else {
                                    if ($_POST["monSho2"]>=0.1) {
                                        $numcaballo=2;
                                        $tipo=3;
                                        $monto=$_POST["monSho2"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan3"])) {
                                } else {
                                    if ($_POST["monGan3"]>=0.1) {
                                        $numcaballo=3;
                                        $tipo=1;
                                        $monto=$_POST["monGan3"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla3"])) {
                                } else {
                                    if ($_POST["monPla3"]>=0.1) {
                                        $numcaballo=3;
                                        $tipo=2;
                                        $monto=$_POST["monPla3"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho3"])) {
                                } else {
                                    if ($_POST["monSho3"]>=0.1) {
                                        $numcaballo=3;
                                        $tipo=3;
                                        $monto=$_POST["monSho3"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan4"])) {
                                } else {
                                    if ($_POST["monGan4"]>=0.1) {
                                        $numcaballo=4;
                                        $tipo=1;
                                        $monto=$_POST["monGan4"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla4"])) {
                                } else {
                                    if ($_POST["monPla4"]>=0.1) {
                                        $numcaballo=4;
                                        $tipo=2;
                                        $monto=$_POST["monPla4"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho4"])) {
                                } else {
                                    if ($_POST["monSho4"]>=0.1) {
                                        $numcaballo=4;
                                        $tipo=3;
                                        $monto=$_POST["monSho4"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan5"])) {
                                } else {
                                    if ($_POST["monGan5"]>=0.1) {
                                        $numcaballo=5;
                                        $tipo=1;
                                        $monto=$_POST["monGan5"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla5"])) {
                                } else {
                                    if ($_POST["monPla5"]>=0.1) {
                                        $numcaballo=5;
                                        $tipo=2;
                                        $monto=$_POST["monPla5"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho5"])) {
                                } else {
                                    if ($_POST["monSho5"]>=0.1) {
                                        $numcaballo=5;
                                        $tipo=3;
                                        $monto=$_POST["monSho5"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan6"])) {
                                } else {
                                    if ($_POST["monGan6"]>=0.1) {
                                        $numcaballo=6;
                                        $tipo=1;
                                        $monto=$_POST["monGan6"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla6"])) {
                                } else {
                                    if ($_POST["monPla6"]>=0.1) {
                                        $numcaballo=6;
                                        $tipo=2;
                                        $monto=$_POST["monPla6"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho6"])) {
                                } else {
                                    if ($_POST["monSho6"]>=0.1) {
                                        $numcaballo=6;
                                        $tipo=3;
                                        $monto=$_POST["monSho6"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan7"])) {
                                } else {
                                    if ($_POST["monGan7"]>=0.1) {
                                        $numcaballo=7;
                                        $tipo=1;
                                        $monto=$_POST["monGan7"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla7"])) {
                                } else {
                                    if ($_POST["monPla7"]>=0.1) {
                                        $numcaballo=7;
                                        $tipo=2;
                                        $monto=$_POST["monPla7"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho7"])) {
                                } else {
                                    if ($_POST["monSho7"]>=0.1) {
                                        $numcaballo=7;
                                        $tipo=3;
                                        $monto=$_POST["monSho7"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan8"])) {
                                } else {
                                    if ($_POST["monGan8"]>=0.1) {
                                        $numcaballo=8;
                                        $tipo=1;
                                        $monto=$_POST["monGan8"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla8"])) {
                                } else {
                                    if ($_POST["monPla8"]>=0.1) {
                                        $numcaballo=8;
                                        $tipo=2;
                                        $monto=$_POST["monPla8"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho8"])) {
                                } else {
                                    if ($_POST["monSho8"]>=0.1) {
                                        $numcaballo=8;
                                        $tipo=3;
                                        $monto=$_POST["monSho8"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan9"])) {
                                } else {
                                    if ($_POST["monGan9"]>=0.1) {
                                        $numcaballo=9;
                                        $tipo=1;
                                        $monto=$_POST["monGan9"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla9"])) {
                                } else {
                                    if ($_POST["monPla9"]>=0.1) {
                                        $numcaballo=9;
                                        $tipo=2;
                                        $monto=$_POST["monPla9"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho9"])) {
                                } else {
                                    if ($_POST["monSho9"]>=0.1) {
                                        $numcaballo=9;
                                        $tipo=3;
                                        $monto=$_POST["monSho9"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan10"])) {
                                } else {
                                    if ($_POST["monGan10"]>=0.1) {
                                        $numcaballo=10;
                                        $tipo=1;
                                        $monto=$_POST["monGan10"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla10"])) {
                                } else {
                                    if ($_POST["monPla10"]>=0.1) {
                                        $numcaballo=10;
                                        $tipo=2;
                                        $monto=$_POST["monPla10"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho10"])) {
                                } else {
                                    if ($_POST["monSho10"]>=0.1) {
                                        $numcaballo=10;
                                        $tipo=3;
                                        $monto=$_POST["monSho10"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan11"])) {
                                } else {
                                    if ($_POST["monGan11"]>=0.1) {
                                        $numcaballo=11;
                                        $tipo=1;
                                        $monto=$_POST["monGan11"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla11"])) {
                                } else {
                                    if ($_POST["monPla11"]>=0.1) {
                                        $numcaballo=11;
                                        $tipo=2;
                                        $monto=$_POST["monPla11"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho11"])) {
                                } else {
                                    if ($_POST["monSho11"]>=0.1) {
                                        $numcaballo=11;
                                        $tipo=3;
                                        $monto=$_POST["monSho11"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan12"])) {
                                } else {
                                    if ($_POST["monGan12"]>=0.1) {
                                        $numcaballo=12;
                                        $tipo=1;
                                        $monto=$_POST["monGan12"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla12"])) {
                                } else {
                                    if ($_POST["monPla12"]>=0.1) {
                                        $numcaballo=12;
                                        $tipo=2;
                                        $monto=$_POST["monPla12"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho12"])) {
                                } else {
                                    if ($_POST["monSho12"]>=0.1) {
                                        $numcaballo=12;
                                        $tipo=3;
                                        $monto=$_POST["monSho12"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan13"])) {
                                } else {
                                    if ($_POST["monGan13"]>=0.1) {
                                        $numcaballo=13;
                                        $tipo=1;
                                        $monto=$_POST["monGan13"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla13"])) {
                                } else {
                                    if ($_POST["monPla13"]>=0.1) {
                                        $numcaballo=13;
                                        $tipo=2;
                                        $monto=$_POST["monPla13"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho13"])) {
                                } else {
                                    if ($_POST["monSho13"]>=0.1) {
                                        $numcaballo=13;
                                        $tipo=3;
                                        $monto=$_POST["monSho13"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan14"])) {
                                } else {
                                    if ($_POST["monGan14"]>=0.1) {
                                        $numcaballo=14;
                                        $tipo=1;
                                        $monto=$_POST["monGan14"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla14"])) {
                                } else {
                                    if ($_POST["monPla14"]>=0.1) {
                                        $numcaballo=14;
                                        $tipo=2;
                                        $monto=$_POST["monPla14"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho14"])) {
                                } else {
                                    if ($_POST["monSho14"]>=0.1) {
                                        $numcaballo=14;
                                        $tipo=3;
                                        $monto=$_POST["monSho14"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan15"])) {
                                } else {
                                    if ($_POST["monGan15"]>=0.1) {
                                        $numcaballo=15;
                                        $tipo=1;
                                        $monto=$_POST["monGan15"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla15"])) {
                                } else {
                                    if ($_POST["monPla15"]>=0.1) {
                                        $numcaballo=15;
                                        $tipo=2;
                                        $monto=$_POST["monPla15"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho15"])) {
                                } else {
                                    if ($_POST["monSho15"]>=0.1) {
                                        $numcaballo=15;
                                        $tipo=3;
                                        $monto=$_POST["monSho15"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan16"])) {
                                } else {
                                    if ($_POST["monGan16"]>=0.1) {
                                        $numcaballo=16;
                                        $tipo=1;
                                        $monto=$_POST["monGan16"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla16"])) {
                                } else {
                                    if ($_POST["monPla16"]>=0.1) {
                                        $numcaballo=16;
                                        $tipo=2;
                                        $monto=$_POST["monPla16"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho16"])) {
                                } else {
                                    if ($_POST["monSho16"]>=0.1) {
                                        $numcaballo=16;
                                        $tipo=3;
                                        $monto=$_POST["monSho16"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan17"])) {
                                } else {
                                    if ($_POST["monGan17"]>=0.1) {
                                        $numcaballo=17;
                                        $tipo=1;
                                        $monto=$_POST["monGan17"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla17"])) {
                                } else {
                                    if ($_POST["monPla17"]>=0.1) {
                                        $numcaballo=17;
                                        $tipo=2;
                                        $monto=$_POST["monPla17"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho17"])) {
                                } else {
                                    if ($_POST["monSho17"]>=0.1) {
                                        $numcaballo=17;
                                        $tipo=3;
                                        $monto=$_POST["monSho17"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan18"])) {
                                } else {
                                    if ($_POST["monGan18"]>=0.1) {
                                        $numcaballo=18;
                                        $tipo=1;
                                        $monto=$_POST["monGan18"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla18"])) {
                                } else {
                                    if ($_POST["monPla18"]>=0.1) {
                                        $numcaballo=18;
                                        $tipo=2;
                                        $monto=$_POST["monPla18"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho18"])) {
                                } else {
                                    if ($_POST["monSho18"]>=0.1) {
                                        $numcaballo=18;
                                        $tipo=3;
                                        $monto=$_POST["monSho18"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan19"])) {
                                } else {
                                    if ($_POST["monGan19"]>=0.1) {
                                        $numcaballo=19;
                                        $tipo=1;
                                        $monto=$_POST["monGan19"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla19"])) {
                                } else {
                                    if ($_POST["monPla19"]>=0.1) {
                                        $numcaballo=19;
                                        $tipo=2;
                                        $monto=$_POST["monPla19"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho19"])) {
                                } else {
                                    if ($_POST["monSho19"]>=0.1) {
                                        $numcaballo=19;
                                        $tipo=3;
                                        $monto=$_POST["monSho19"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monGan20"])) {
                                } else {
                                    if ($_POST["monGan20"]>=0.1) {
                                        $numcaballo=20;
                                        $tipo=1;
                                        $monto=$_POST["monGan20"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monPla20"])) {
                                } else {
                                    if ($_POST["monPla20"]>=0.1) {
                                        $numcaballo=20;
                                        $tipo=2;
                                        $monto=$_POST["monPla20"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                                if (empty($_POST["monSho20"])) {
                                } else {
                                    if ($_POST["monSho20"]>=0.1) {
                                        $numcaballo=20;
                                        $tipo=3;
                                        $monto=$_POST["monSho20"];
                                        include("../apostador/grabarjugada2.php");
                                        $linea=$linea+1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

    echo "<div id='resultado' style='line-height: 0.5em;'>";
    echo $mensaje;
    echo "</div>";

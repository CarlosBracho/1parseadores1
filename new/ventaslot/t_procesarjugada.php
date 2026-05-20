<?php
include("../includes/libreria.php");
require_once('../Connections/conexionbanca.php');
if ($_POST['inicio']>=0 && $_POST['fin']>=0 && $_POST['mon_seguidilla']>0 && $_POST['inicio']!="" && $_POST['fin']!="") {
    $_POST['mon_apuesta']="";
    $_POST['num_apuesta']="";
    if ((strlen($_POST['inicio'])==2 && strlen($_POST['fin'])==2) || (strlen($_POST['inicio'])==3 && strlen($_POST['fin'])==3)) {
        $_POST['num_apuesta']=$_POST['inicio'];
        $final=$_POST['fin'];
        if ($_POST['inicio']>$_POST['fin']) {
            $final=$_POST['inicio'];
            $_POST['num_apuesta']=$_POST['fin'];
        }
        $_POST['mon_apuesta']=$_POST['mon_seguidilla'];
        $acept_seguidilla=1;
    }
}
if ($_POST['mon_terminales']>0) {
    $montoTer=(float)$_POST['mon_terminales'];
    $incarro=$_SESSION["ocarrito"]->recorre_carrito($montoTer);
    if ($incarro[0]!="-0") {
        $carrito1=$incarro;
        $_POST['num_apuesta']="1000";
        $_POST['mon_apuesta']=$montoTer;
    }
}
$bandera=0;
if (isset($_POST['num_apuesta']) && isset($_POST['num_apuesta']) && strlen($_POST['num_apuesta'])>1) {
    $numero=$_POST['num_apuesta'];
    $monto=(float)$_POST['mon_apuesta'];
    $numeroPorParte=str_split($numero);
    $acceso=1;
    if (($numero>=0 && $monto>0) || ($_POST['RadioGroup1']==3 && $monto>0)) {//si el nro apueta y monto es mayor a cero
        if ($_POST['RadioGroup1']!=3) {
            foreach ($numeroPorParte as $parte) {
                if ($parte=="*") {
                    $acceso=0;
                }
            }
        }
        if ($_POST['RadioGroup1']==5) {
            if (!isset($acept_seguidilla)) {
                $acceso=0;
            }
        }
        if ($acceso==1) {
            if (isset($_POST['lot_apuesta'])) { // si esta definida alguna loteria
                $guardarSeleccion=$_POST['lot_apuesta'];
                if ($_POST['RadioGroup1']==2) { // si es permuta
                    $numeroArray=permutar($numero);
                }
                if ($_POST['RadioGroup1']==5) { // si es seguidilla
                    $numeroArray=seguidilla($numero, $final);
                }
                $loterias=$_POST['lot_apuesta'];
                if (isset($_POST['cod_signo'])) { // si la loteria tiene signos
                    $signo=$_POST['cod_signo'];
                }
                foreach ($loterias as $valores) {
                    $separar = explode('-', $valores);
                    $codigoloteria=$separar[0];
                    $tipoloteria=$separar[1];
                    if ($tipoloteria==3) {
                        if (isset($signo)) {	// con signos
                            foreach ($signo as $resultado) {
                                $separarresultado = explode('-', $resultado); // separa codigo de loteria y signo
                                if ($codigoloteria==$separarresultado[0]) {
                                    if ($_POST['RadioGroup1']==1) { // si es triple o terminal
                                        $tertri="-3-";
                                        if (strlen($numero)==2) {
                                            $separarresultado[0]=ObtenerTerminalLoteria($separarresultado[0]);
                                            $tertri="-2-";
                                        }
                                        $carrito1[]=$numero."-".$monto."-".$separarresultado[0].$tertri.$separarresultado[1];
                                    }
                                    if ($_POST['RadioGroup1']==2) { // si es permuta
                                        foreach ($numeroArray as $numero2) {
                                            $tertri="-3-";
                                            $separarresultado1=$separarresultado[0];
                                            if (strlen($numero2)==2) {
                                                $separarresultado1=ObtenerTerminalLoteria($separarresultado[0]);
                                                $tertri="-2-";
                                            }
                                            $carrito1[]=$numero2."-".$monto."-".$separarresultado1.$tertri.$separarresultado[1];
                                        }
                                    }
                                    if ($_POST['RadioGroup1']==3) { // serie
                                        $asteriscos=0;
                                        $numeroParte=str_split($numero);
                                        foreach ($numeroParte as $numSeries) {
                                            if ($numSeries=="*") {
                                                $asteriscos=$asteriscos+1;
                                            }
                                        }
                                        if ($asteriscos==1) {
                                            if (strlen($numero)==3) {
                                                if ($numeroParte[0]=="*" || $numeroParte[1]=="*" || $numeroParte[2]=="*") {
                                                    $numeroArray=series($numero, 3);
                                                    foreach ($numeroArray as $numero2) {
                                                        $tertri="-3-";
                                                        $separarresultado1=$separarresultado[0];
                                                        $carrito1[]=$numero2."-".$monto."-".$separarresultado1.$tertri.$separarresultado[1];
                                                    }
                                                }
                                            }
                                            if (strlen($numero)==2) {
                                                if ($numeroParte[0]=="*" || $numeroParte[1]=="*") {
                                                    $numeroArray=series($numero, 2);
                                                    foreach ($numeroArray as $numero2) {
                                                        $tertri="-2-";
                                                        $separarresultado1=ObtenerTerminalLoteria($separarresultado[0]);
                                                        $carrito1[]=$numero2."-".$monto."-".$separarresultado1.$tertri.$separarresultado[1];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if ($_POST['RadioGroup1']==4) { // con terminales auto
                                        if (strlen($numero)==3) {
                                            $numeroArray[0]=$numero;
                                            $numeroArray[1]=substr($numero, 1, 2);
                                            foreach ($numeroArray as $numero2) {
                                                $tertri="-3-";
                                                $separarresultado1=$separarresultado[0];
                                                if (strlen($numero2)==2) {
                                                    $separarresultado1=ObtenerTerminalLoteria($separarresultado[0]);
                                                    $tertri="-2-";
                                                }
                                                $carrito1[]=$numero2."-".$monto."-".$separarresultado1.$tertri.$separarresultado[1];
                                            }
                                        }
                                        if (strlen($numero)==2) {
                                            $separarresultado1=ObtenerTerminalLoteria($separarresultado[0]);
                                            $carrito1[]=$numero."-".$monto."-".$separarresultado1."-2-".$separarresultado[1];
                                        }
                                    }
                                    if ($_POST['RadioGroup1']==5) { // seguidilla
                                        foreach ($numeroArray as $numero2) {
                                            $tertri="-3-";
                                            $separarresultado1=$separarresultado[0];
                                            if (strlen($numero2)==2) {
                                                $separarresultado1=ObtenerTerminalLoteria($separarresultado[0]);
                                                $tertri="-2-";
                                            }
                                            $carrito1[]=$numero2."-".$monto."-".$separarresultado1.$tertri.$separarresultado[1];
                                        }
                                    }
                                }
                            }
                        }
                    } else { // sin signos
                    if ($_POST['RadioGroup1']==1) { // si es triple o terminal
                        if (strlen($numero)==2) {
                            $separar[0]=ObtenerTerminalLoteria($separar[0]);
                            $separar[1]=2;
                        }
                        $carrito1[]=$numero."-".$monto."-".$separar[0]."-".$separar[1]."-0";
                    }
                        if ($_POST['RadioGroup1']==2) { // si es permuta
                            foreach ($numeroArray as $numero3) {
                                $separar1=$separar[0];
                                if (strlen($numero3)==2) {
                                    $separar1=ObtenerTerminalLoteria($separar[0]);
                                    $separar[1]="2";
                                }
                                //			num apost	  monto		codloter		tri/ter/sig	signo
                                $carrito1[]=$numero3."-".$monto."-".$separar1."-".$separar[1]."-0";
                            }
                        }
                        if ($_POST['RadioGroup1']==3) { // serie
                            $asteriscos=0;
                            $numeroParte=str_split($numero);
                            foreach ($numeroParte as $numSeries) {
                                if ($numSeries=="*") {
                                    $asteriscos=$asteriscos+1;
                                }
                            }
                            if ($asteriscos==1) {
                                if (strlen($numero)==3) {
                                    if ($numeroParte[0]=="*" || $numeroParte[1]=="*" || $numeroParte[2]=="*") {
                                        $numeroArray=series($numero, 3);
                                        foreach ($numeroArray as $numero2) {
                                            $tertri="-1-";
                                            $separarresultado1=$separar[0];
                                            $carrito1[]=$numero2."-".$monto."-".$separarresultado1.$tertri."0";
                                        }
                                    }
                                }
                                if (strlen($numero)==2) {
                                    if ($numeroParte[0]=="*" || $numeroParte[1]=="*") {
                                        $numeroArray=series($numero, 2);
                                        foreach ($numeroArray as $numero2) {
                                            $tertri="-2-";
                                            $separarresultado1=ObtenerTerminalLoteria($separar[0]);
                                            $carrito1[]=$numero2."-".$monto."-".$separarresultado1.$tertri."0";
                                        }
                                    }
                                }
                            }
                        }
                        if ($_POST['RadioGroup1']==4) { // con terminales auto
                            if (strlen($numero)==3) {
                                $numeroArray[0]=$numero;
                                $numeroArray[1]=substr($numero, 1, 2);
                                foreach ($numeroArray as $numero2) {
                                    $tertri="-3-";
                                    $separarresultado1=$separar[0];
                                    if (strlen($numero2)==2) {
                                        $separarresultado1=ObtenerTerminalLoteria($separar[0]);
                                        $tertri="-2-";
                                    }
                                    $carrito1[]=$numero2."-".$monto."-".$separarresultado1.$tertri."0";
                                }
                            }
                            if (strlen($numero)==2) {
                                $separarresultado1=ObtenerTerminalLoteria($separar[0]);
                                $carrito1[]=$numero."-".$monto."-".$separarresultado1."-2-"."0";
                            }
                        }
                        if ($_POST['RadioGroup1']==5) { // si es permuta
                            foreach ($numeroArray as $numero3) {
                                $separar1=$separar[0];
                                if (strlen($numero3)==2) {
                                    $separar1=ObtenerTerminalLoteria($separar[0]);
                                    $separar[1]="2";
                                }
                                //			num apost	  monto		codloter		tri/ter/sig	signo
                                $carrito1[]=$numero3."-".$monto."-".$separar1."-".$separar[1]."-0";
                            }
                        }
                    }
                }
            }
            if (isset($carrito1)) {
                if ($_POST['con_tope']==2) {
                    $query_Recordset11 = sprintf(
                        "/* PARSEADORES1 new\ventaslot\t_procesarjugada.php - QUERY 1 */ SELECT ba.top_triple_lot, ba.top_terminal_lot FROM banca ba
				WHERE cod_banca = %s LIMIT 1",
                        GetSQLValueString($_POST['banca'], "int")
                    );
                    $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
                    $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
                    $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
                    $topeVentaTer=$row_Recordset11['top_terminal_lot'];
                    $topeVentaTri=$row_Recordset11['top_triple_lot'];
                    mysqli_free_result($Recordset11);
                }
                foreach ($carrito1 as $pedido) {
                    $separarcarrito = explode('-', $pedido);
                    $numero1=$separarcarrito[0];
                    $monto1=$separarcarrito[1];
                    $loteria1=$separarcarrito[2];
                    $signo1=$separarcarrito[4];
                    $hoy=fechaactualbd();
                    $tLot=tipoLoterias($loteria1);
                    if ($_POST['con_tope']<=1) {
                        $topeagencia=agenciaTopeLot($_POST['banca'], $_POST['agencia'], $loteria1, $_POST['con_tope']);
                    } else {
                        if ($tLot==2) {
                            $topeagencia=$topeVentaTer;
                        } else {
                            $topeagencia=$topeVentaTri;
                        }
                    }
                    $montoVendido=numMontoVendidoLot($_POST['agencia'], $numero1, $loteria1, $signo1, $hoy);
                    $ventaEnCarrito=$_SESSION["ocarrito"]->contar_carrito_loteria($loteria1, $numero1, $signo1);
                    $quedanAgencia=$topeagencia-$montoVendido;
                    $xhoraActual=horaactual();
                    $horaCierre=horaCierreSorteo($loteria1, $_POST['banca']);
                    $bloqueado=NumBloqueado($_POST['taquilla'], $_POST['agencia'], $_POST['banca'], $numero1, $loteria1);
                    if ($xhoraActual<=$horaCierre && $bloqueado==0) {
                        if ($quedanAgencia>0) { // pregunta si no ha excedido el limite en agencia
                            $totalVendido=$ventaEnCarrito+$monto1;
                            if ($totalVendido>$quedanAgencia) {
                                $monto1=($quedanAgencia-$totalVendido)+$monto1;
                                $bandera=1;
                            }
                            if ($monto1>0) {
                                $sesioncarrito = $_SESSION['ocarrito'];
                                $_SESSION["ocarrito"]->introduce_jugada($numero1, $monto1, $loteria1, $signo1);
                            }
                        } else {
                            $bandera=1;
                        }
                    } else {
                        $bandera=1;
                    }
                }
            }
        }
    }
}
$_SESSION["ocarrito"]->ordena_ticket();
$_SESSION['MM_monto']=$_SESSION["ocarrito"]->imprime_carrito();
$mensaje="Guardado Correctamente";?>
<script type="text/javascript">$("#mensaje").html("");document.getElementById('num_apuesta').value="";</script>
<?php
if ($bandera==1) {?>
	<script type="text/javascript">
		$("#mensaje").html("Una o varias apuestas no se realizaron segun lo solicitado! Por favor revise la jugada");
	</script>
	<?php
}?>

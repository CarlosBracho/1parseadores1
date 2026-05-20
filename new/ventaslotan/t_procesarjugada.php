<?php
include("../includes/libreria.php");
require_once('../Connections/conexionbanca.php');
$bandera=0;
$eHora="";
$eTope="";
if (isset($_POST['mon_apuesta']) && $_POST['mon_apuesta']>0 && isset($_POST['cod_signo'])) {
    $monto=(float)$_POST['mon_apuesta'];
    $acceso=1;
    if ($acceso==1) {
        foreach ($_POST['cod_signo'] as $valores) {
            $lotSig = explode('-', $valores);
            $loteria=$lotSig[0];
            $numero=str_pad((int) $lotSig[1], 2, "0", STR_PAD_LEFT);
            $numero=$lotSig[1];
            if (isset($lotSig[2])) {
                $carrito1[]=$numero."-".$_POST['mon_apuesta']."-".$loteria."-".$lotSig[2];
            } else {
                $carrito1[]=$numero."-".$_POST['mon_apuesta']."-".$loteria."-".$lotSig[1];
            }
            //			num apost	  monto		codloter		tri/ter/sig	signo
            //echo $numero."-".$_POST['mon_apuesta']."-".$loteria."-".$lotSig[2];
            //echo $lotSig[0]."-".$lotSig[1]."-".$lotSig[2];
        }
        if (isset($carrito1)) {
            if ($_POST['con_tope']==2) {
                $query_Recordset11 = sprintf(
                    "/* PARSEADORES1 new\ventaslotan\t_procesarjugada.php - QUERY 1 */ SELECT ba.top_triple_lot FROM banca ba
				WHERE cod_banca = %s LIMIT 1",
                    GetSQLValueString($_POST['banca'], "int")
                );
                $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
                $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
                $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
                $topeVentaTri=$row_Recordset11['top_triple_lot'];
                mysqli_free_result($Recordset11);
            }
            foreach ($carrito1 as $pedido) {
                $separarcarrito = explode('-', $pedido);
                $numero1=$separarcarrito[0];
                $monto1=$separarcarrito[1];
                $loteria1=$separarcarrito[2];
                $signo1=$separarcarrito[3];
                $hoy=fechaactualbd();
                if ($_POST['con_tope']<=1) {
                    $topeagencia=agenciaTopeLot($_POST['banca'], $_POST['agencia'], $loteria1, $_POST['con_tope']);
                } else {
                    $topeagencia=$topeVentaTri;
                }
                $montoVendido=numMontoVendidoLot($_POST['agencia'], $numero1, $loteria1, $signo1, $hoy);
                $ventaEnCarrito=$_SESSION["ocarritoAni"]->contar_carrito_loteria($loteria1, $numero1, $signo1);
                $quedanAgencia=$topeagencia-$montoVendido;
                $xhoraActual=horaactual();
                $horaCierre=horaCierreSorteo($loteria1, $_POST['banca']);
                if ($xhoraActual<=$horaCierre) {
                    if ($quedanAgencia>0) { // pregunta si no ha excedido el limite en agencia
                        $totalVendido=$ventaEnCarrito+$monto1;
                        if ($totalVendido>$quedanAgencia) {
                            $monto1=($quedanAgencia-$totalVendido)+$monto1;
                            $bandera=1;
                            $eTope="(EXCEDE TOPE)";
                        }
                        if ($monto1>0) {
                            $sesioncarrito = $_SESSION['ocarritoAni'];
                            $_SESSION["ocarritoAni"]->introduce_jugada($numero1, $monto1, $loteria1, $signo1);
                        }
                    } else {
                        $bandera=1;
                        $eTope="(EXCEDE TOPE)";
                    }
                } else {
                    $bandera=1;
                    $eHora="(SORTEO CERRADO)";
                }
            }
        }
    }
}
$_SESSION["ocarritoAni"]->ordena_ticket();
$_SESSION['MM_montoAni']=$_SESSION["ocarritoAni"]->imprime_carrito();
$mensaje="Guardado Correctamente";?>
<script type="text/javascript">$("#mensaje").html("");document.getElementById('mon_apuesta').value="";</script>
<?php
if ($bandera==1) {
    $menError="Una o varias apuestas no se realizaron según lo solicitado! Por favor revise la jugada ".$eTope." ".$eHora; ?>
	<script type="text/javascript">
		$("#mensaje").html("<?php echo $menError; ?>");
	</script>
	<?php
}?>
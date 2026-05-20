<?php
include("../includes/libreria.php");
require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1 = "0";
$bandera=0;
$monTotal=0;
echo '<script type="text/javascript">$("#mensaje").html("");document.getElementById("mon_apuesta").value="";</script>';
if (isset($_POST["repetirT"])&&isset($_POST["repetirT"])&&isset($_POST["taRep"])&&isset($_POST["agRep"])) {
    $ticket=substr($_POST["repetirT"], 2, (strlen($_POST["repetirT"])-2));
    //$ticket=substr($_POST["repetirT"], 2, 5);
    $diahoy=diaactual();
    list($aDia, $bDia)=loteriaHoy($diahoy);
    $query_Recordset1 = sprintf("/* PARSEADORES1 new\ventaslotan\repetir_ticket_lotan.php - QUERY 1 */ SELECT 
		ve.id_loteria,
		ve.tip_loteria_lot,
		ve.id_signo,
		ve.num_apuesta_lot,
		ve.mon_apuesta_lot,
		ag.cod_agencia,
		ba.cod_banca,
		ba.top_triple_lot, 
		ba.con_tope,
		ta.cod_taquilla
	FROM 
		venta_lot ve,
		loterias lo,
		bancaloterias bl,
		agencialoterias al,
		taquilla ta,
		agencia ag,
		banca ba,
		usuario us
	WHERE
		ve.id_loteria = lo.id_loteria AND
		ve.id_loteria = bl.id_loteria AND
		ve.id_loteria = al.id_loteria AND
		ve.id_usuario = us.id_usuario AND
		ve.ticket_lot = %s AND
		ve.tip_loteria_lot >3 AND
		lo.est_loteria = 1 AND
		bl.est_banlot = 1 AND
		al.est_agelot = 1 AND
		al.id_agencia = ag.cod_agencia AND
		bl.id_banca = ba.cod_banca AND
		ba.cod_banca = ag.cod_banca AND 
		ta.cod_agencia = ag.cod_agencia AND
		ta.cod_taquilla = us.cod_taquilla AND
		ta.cod_taquilla = %s AND
		$bDia = 1 AND
		$aDia=1
	ORDER BY ve.id_loteria ASC", GetSQLValueString($ticket, "int"), GetSQLValueString($_POST["taRep"], "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $u=0;
        do {
            $numero1=$row_Recordset1['num_apuesta_lot'];
            $monto1=$row_Recordset1['mon_apuesta_lot'];
            $loteria1=$row_Recordset1['id_loteria'];
            $signo1=$row_Recordset1['id_signo'];
            $cod_taquilla=$row_Recordset1['cod_taquilla'];
            $cod_agencia=$row_Recordset1['cod_agencia'];
            $cod_banca=$row_Recordset1['cod_banca'];
            $con_tope=$row_Recordset1['con_tope'];
            $topeVentaTri=$row_Recordset1['top_triple_lot'];
            $hoy=fechaactualbd();
            if ($con_tope<=1) {
                $topeagencia=agenciaTopeLot($cod_banca, $cod_agencia, $loteria1, $con_tope);
            } else {
                $topeagencia=$topeVentaTri;
            }
            $montoVendido=numMontoVendidoLot($cod_agencia, $numero1, $loteria1, $signo1, $hoy);
            // busca cuanto se ha vendido nro en el carrito
            //echo $numero1." ".$monto1." ".$loteria1." ".$signo1." ".$cod_taquilla." ".$cod_agencia." ".$cod_banca." ".$hoy." ".$topeagencia." ".$montoVendido;
            //echo "<br/>";
            $ventaEnCarrito=0;
            $ventaEnCarrito=$_SESSION["ocarritoAni"]->contar_carrito_loteria($loteria1, $numero1, $signo1);
            $quedanAgencia=$topeagencia-$montoVendido;
            $xhoraActual=horaactual();
            $horaCierre=horaCierreSorteo($loteria1, $cod_banca);
            $bloqueado=NumBloqueado($cod_taquilla, $cod_agencia, $cod_banca, $numero1, $loteria1);
            if ($xhoraActual<=$horaCierre && $bloqueado==0) {
                if ($quedanAgencia>0) { // pregunta si no ha excedido el limite en agencia
                    $totalVendido=$ventaEnCarrito+$monto1;
                    if ($totalVendido>$quedanAgencia) {
                        $monto1=($quedanAgencia-$totalVendido)+$monto1;
                        $bandera=1;
                    }
                    if ($monto1>0) {
                        $sesioncarrito = $_SESSION['ocarritoAni'];
                        $_SESSION["ocarritoAni"]->introduce_jugada($numero1, $monto1, $loteria1, $signo1);
                        $monTotal.=$monto1;
                        $u++;
                    }
                } else {
                    $bandera=1;
                }
            } else {
                $bandera=1;
            }
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        if ($u==0) {
            echo '<script type="text/javascript">';
            echo '$("#mensaje").html("REPETIR TICKET: Una o varias apuestas no se realizaron segun lo solicitado! Por favor revise la jugada");';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo '$("#mensaje").html("REPETIR TICKET: <font color=RED size=+1>Ticket# '.$_POST["repetirT"].' no encontrado</font>");';
        echo '</script>';
    }
    $_SESSION["ocarritoAni"]->ordena_ticket();
    $_SESSION['MM_monto']=$_SESSION["ocarritoAni"]->imprime_carrito();
    mysqli_free_result($Recordset1);
}
if ($bandera==1&&$monTotal>0) {
    echo '<script type="text/javascript">';
    echo '$("#mensaje").html("REPETIR TICKET: Una o varias apuestas no se realizaron segun lo solicitado! Por favor revise la jugada");';
    echo '</script>';
}?>


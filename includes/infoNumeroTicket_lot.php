<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$fechasistema=fechaactualbd(); $TicketVendidos=ObtenerNumeroJugada_lot($_SESSION['MM_id_usuario'], $fechasistema, $modulo);
echo $TicketVendidos;

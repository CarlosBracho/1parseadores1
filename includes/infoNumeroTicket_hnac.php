<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$fechasistema=fechaactualbd(); $TicketVendidos=ObtenerNumeroJugada_hnac($_SESSION['MM_id_usuario'], $fechasistema);
echo $TicketVendidos;

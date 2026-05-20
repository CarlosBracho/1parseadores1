<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$fechasistema=fechaactualbd();
$TicketVendidos=ObtenerNumeroJugada($_SESSION['MM_id_usuario'], $fechasistema);
echo $TicketVendidos;

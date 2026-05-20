<?php
require_once('../Connections/conexionbanca.php');

$insertSQL155 = sprintf(
    "/* PARSEADORES1 parley\parley\parleyregistrar2.php - QUERY 1 */ INSERT INTO p4jugadas  
(nticketp4, ser_ventap4, cod_taquillap4, jugadadtp4, ip_ventap4, mon_ventap4, 
id_usuariop4, codigop4, tipojp4, referenciap4, logrop4, equipop4, juegop4, numerojp4, padrep4, deportep4, lineatp4, monedap4, ab_o_rlp4)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
    GetSQLValueString($numeroticket, "int"),
    GetSQLValueString($serial, "text"),
    GetSQLValueString($taquilla, "int"),
    GetSQLValueString($datetime, "date"),
    GetSQLValueString($ip_ventap, "text"),
    GetSQLValueString($montoApuesta, "double"),
    GetSQLValueString($usuario, "int"),
    GetSQLValueString($codigo, "int"),
    GetSQLValueString($tipo, "text"),
    GetSQLValueString($referencia, "int"),
    GetSQLValueString(filter_var($logro, FILTER_SANITIZE_NUMBER_INT), "text"),
    GetSQLValueString($equipo, "text"),
    GetSQLValueString($juego, "int"),
    GetSQLValueString($numero, "int"),
    GetSQLValueString($padre, "int"),
    GetSQLValueString($deporte, "int"),
    GetSQLValueString($lineatp, "int"),
    GetSQLValueString($moneda, "int"),
    GetSQLValueString($ab_o_rlp4, "text")
);

        $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));

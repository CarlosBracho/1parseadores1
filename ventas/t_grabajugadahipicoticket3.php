<?php
require_once('../Connections/conexionbanca.php');
$carrerax1=$_POST['car'];
if($tipo==22){$carrerax1=$_POST['car']+1;}
if($tipo==23){$carrerax1=$_POST['car']+2;}
if($tipo==24){$carrerax1=$_POST['car']+3;}
if($tipo==25){$carrerax1=$_POST['car']+4;}
if($tipo==26){$carrerax1=$_POST['car']+5;}
$insertSQL = sprintf(
        "/* PARSEADORES1 ventas\t_grabajugadahipicoticket3.php - QUERY 1 */ INSERT INTO venta (ser_venta, ticket, cod_taquilla, fec_venta, hor_venta, cod_tventa,
                             num_caballo, mon_venta, cod_carrera, id_usuario, est_ticket, can_ticket, ip_venta, lin_ticket, cod_cliente, tra_codigo, efectivoO) 
                             VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($serial, "text"),
        GetSQLValueString($numerotiket2, "int"),
        GetSQLValueString($codigoTaquilla, "int"),
        GetSQLValueString($FechaTxt, "date"),
        GetSQLValueString($horaTxt, "date"),
        GetSQLValueString($tipo, "int"),
        GetSQLValueString($ncab, "text"),
        GetSQLValueString($_POST['bs'], "double"),
        GetSQLValueString($carrerax1, "int"),
        GetSQLValueString($_POST['id_usu'], "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString($cantTicket, "int"),
        GetSQLValueString($ipVenta, "text"),
        GetSQLValueString($cantju, "int"),
        GetSQLValueString(strtoupper(''), "text"),
        GetSQLValueString(1, "int"),
        GetSQLValueString(1, "int")
    );
    
    $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    
















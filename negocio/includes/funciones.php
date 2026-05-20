<?php
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }
        global $conexionbanca;
        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conexionbanca, $theValue) : mysqli_escape_string($conexionbanca, $theValue);
        switch ($theType) { case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;     case "long": case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break; case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break; case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break; case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break; }
        return $theValue;
    }
} if (!function_exists("isAuthorized")) {
    function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
    {
        $isValid = false;
        if (!empty($UserName)) {
            $arrUsers = Explode(",", $strUsers);
            $arrGroups = Explode(",", $strGroups);
            if (in_array($UserName, $arrUsers)) {
                $isValid = true;
            }
            if (in_array($UserGroup, $arrGroups)) {
                $isValid = true;
            }
            if (($strUsers == "") && false) {
                $isValid = true;
            }
        }
        return $isValid;
    }
} function mysqli_result($res, $row, $field=0)
{
    $res->data_seek($row);
    $datarow = $res->fetch_array();
    return $datarow[$field];
}function piedepagina()
{
    global $conexionbanca;
    $query_Recordset4 = "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 1 */ SELECT * FROM mensaje WHERE cod_mensaje = 1";
    $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
    $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
    $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
    return $row_Recordset4['pie_linea'];
    mysqli_free_result($ConsultaFuncion);
} function ObtenerNombreVendedor($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 2 */ SELECT usuario.nom_usuario FROM usuario WHERE usuario.id_usuario = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $nomb1=strtoupper($row_ConsultaFuncion['nom_usuario']);
    echo $nomb1;
    mysqli_free_result($ConsultaFuncion);
} function buscaHip($identificador)
{
    $identificador=strtoupper($identificador);
    $total=0;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 3 */ SELECT nom_hipodromo FROM hipodromo  WHERE nom_hipodromo = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $total=$totalRows_ConsultaFuncion;
    mysqli_free_result($ConsultaFuncion);
    return $total;
} function buscaHip2($identificador)
{
    $identificador=strtoupper($identificador);
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 4 */ SELECT nom_hipodromo_hpi FROM hipodromo  WHERE nom_hipodromo = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $nomb2=$row_ConsultaFuncion['nom_hipodromo_hpi'];
        if ($nomb2=="") {
            $nomb2=$identificador;
        }
    }
    mysqli_free_result($ConsultaFuncion);
    return $nomb2;
} function buscaHip3($identificador)
{
    $nomb2="";
    $identificador=strtoupper($identificador);
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 5 */ SELECT nom_hipodromo FROM hipodromo  WHERE nom_hipodromo_hpi = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $nomb2=$row_ConsultaFuncion['nom_hipodromo'];
        if ($nomb2=="") {
            $nomb2=$identificador;
        }
    }
    mysqli_free_result($ConsultaFuncion);
    return $nomb2;
}

function buscaHip4($identificador)
{
    $nomb2="";
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 6 */ SELECT nom_hipodromo 
		FROM hipodromo 
		WHERE cod_hipodromo = %s 
		LIMIT 1",
        GetSQLValueString($identificador, "text")
    );
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $nomb2=$row_ConsultaFuncion['nom_hipodromo'];
    }
    mysqli_free_result($ConsultaFuncion);
    return $nomb2;
}
function buscaHipBuild($identificador, $nomb)
{
    $nomb2="";
    $ncod2="";
    global $conexionbanca;
    /*
        $query_ConsultaFuncion = sprintf("SELECT nom_hipodromo, cod_hipodromo, pre_build
            FROM hipodromo
            WHERE nom_hipodromo = %s
            LIMIT 1",
        GetSQLValueString($nomb, "text"));
        $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
        $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
        $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    */
    $query_ConsultaFuncion = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 7 */ SELECT nom_hipodromo, cod_hipodromo, pre_build 
		FROM hipodromo 
		WHERE pre_build = %s 
		LIMIT 1",
        GetSQLValueString($identificador, "text")
    );
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $nomb2=$row_ConsultaFuncion['nom_hipodromo'];
        $ncod2=$row_ConsultaFuncion['cod_hipodromo'];
        /*
        if ($row_ConsultaFuncion['pre_build']=="") {
            $updateSQL = sprintf("UPDATE hipodromo SET
                        pre_build=%s
                    WHERE
                        cod_hipodromo=%s",
                    GetSQLValueString($identificador, "text"),
                    GetSQLValueString($ncod2, "int"));
                $Result2 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        }
        */
    }
    
    mysqli_free_result($ConsultaFuncion);
    return array($nomb2,$totalRows_ConsultaFuncion,$ncod2);
}

function buscaHipPre($identificador)
{
    $identificador=strtoupper($identificador);
    $total=0;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 8 */ SELECT pre_hipodromo FROM hipodromo  WHERE pre_hipodromo = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $total=$totalRows_ConsultaFuncion;
    mysqli_free_result($ConsultaFuncion);
    return $total;
} function buscaTaq($identificador)
{
    $identificador=strtoupper($identificador);
    $total=0;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 9 */ SELECT nom_taquilla FROM taquilla  WHERE nom_taquilla = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $total=$totalRows_ConsultaFuncion;
    mysqli_free_result($ConsultaFuncion);
    return $total;
} function buscaUsu($identificador)
{
    $identificador=trim(strtoupper($identificador));
    $total=0;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 10 */ SELECT nom_usuario FROM usuario  WHERE nom_usuario = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $total=$totalRows_ConsultaFuncion;
    mysqli_free_result($ConsultaFuncion);
    return $total;
} function buscaAge($identificador)
{
    $identificador=trim(strtoupper($identificador));
    $total=0;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 11 */ SELECT nom_agencia FROM agencia  WHERE nom_agencia = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $total=$totalRows_ConsultaFuncion;
    mysqli_free_result($ConsultaFuncion);
    return $total;
} function buscaDis($identificador)
{
    $identificador=trim(strtoupper($identificador));
    $total=0;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 12 */ SELECT banca.nom_banca FROM banca  WHERE banca.nom_banca = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $total=$totalRows_ConsultaFuncion;
    mysqli_free_result($ConsultaFuncion);
    return $total;
} function NombreVendedor($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 13 */ SELECT usuario.nom_usuario FROM usuario WHERE usuario.id_usuario = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $vendedor=$row_ConsultaFuncion['nom_usuario'];
    mysqli_free_result($ConsultaFuncion);
    return $vendedor;
} function Obtenerticketaeliminar($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 14 */ SELECT usuario.tic_eliminados FROM usuario WHERE usuario.id_usuario = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $ticket=$row_ConsultaFuncion['tic_eliminados'];
    mysqli_free_result($ConsultaFuncion);
    return $ticket;
} function ObtenerNombreadministrador($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 15 */ SELECT uadmin.nom_uadmin FROM uadmin WHERE uadmin.cod_uadmin = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    echo $row_ConsultaFuncion['nom_uadmin'];
    mysqli_free_result($ConsultaFuncion);
} function ObtenerNombreBanca($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 16 */ SELECT banca.nom_banca FROM banca WHERE banca.cod_banca = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    echo $row_ConsultaFuncion['nom_banca'];
    mysqli_free_result($ConsultaFuncion);
} function ObtenerMarquesinaBanca($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 17 */ SELECT banca.marquesina FROM banca WHERE banca.cod_banca = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    echo $row_ConsultaFuncion['marquesina'];
    mysqli_free_result($ConsultaFuncion);
} function ObtenerNombreAgencia($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 18 */ SELECT agencia.nom_agencia FROM agencia WHERE agencia.cod_agencia = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    echo $row_ConsultaFuncion['nom_agencia'];
    mysqli_free_result($ConsultaFuncion);
} function NombreAgencia($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 19 */ SELECT agencia.nom_agencia FROM agencia WHERE agencia.cod_agencia = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $agencia=$row_ConsultaFuncion['nom_agencia'];
    mysqli_free_result($ConsultaFuncion);
    return $agencia;
} function ObtenerNombreAgenciados($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 20 */ SELECT agencia.nom_agencia FROM agencia WHERE agencia.cod_agencia = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $xagencia=" (".$row_ConsultaFuncion['nom_agencia'].")";
    echo $xagencia;
    mysqli_free_result($ConsultaFuncion);
} function ObtenerCodigoAgencia($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 21 */ SELECT usuario.cod_agencia FROM usuario WHERE usuario.id_usuario = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $codigo=$row_ConsultaFuncion['cod_agencia'];
    mysqli_free_result($ConsultaFuncion);
    return $codigo;
} function ObtenerNombreTaquilla($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 22 */ SELECT taquilla.nom_taquilla FROM taquilla WHERE taquilla.cod_taquilla = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $xtaquilla=$row_ConsultaFuncion['nom_taquilla'];
    mysqli_free_result($ConsultaFuncion);
    return $xtaquilla;
} function ObtenerCodigoTaquillaAgencia($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 23 */ SELECT taquilla.cod_agencia FROM taquilla WHERE taquilla.cod_taquilla = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $xagencia=$row_ConsultaFuncion['cod_agencia'];
    mysqli_free_result($ConsultaFuncion);
    return $xagencia;
} function ObtenerCodigoUsuarioTaquilla($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 24 */ SELECT usuario.cod_taquilla FROM usuario WHERE usuario.id_usuario = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $xtaquilla=$row_ConsultaFuncion['cod_taquilla'];
    mysqli_free_result($ConsultaFuncion);
    return $xtaquilla;
} function ContarTaquillas($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 25 */ SELECT * FROM taquilla WHERE taquilla.cod_agencia = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $xtaquillas=array();
    $x=0;
    if ($totalRows_ConsultaFuncion>0) {
        do {
            $xtaquillas[$x]=$row_ConsultaFuncion['cod_taquilla'];
            $x++;
        } while ($row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion));
    }
    mysqli_free_result($ConsultaFuncion);
    return $xtaquillas;
} function ObtenerCodigoAgenciaBanca($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 26 */ SELECT agencia.cod_banca FROM agencia WHERE agencia.cod_agencia = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $codigo=$row_ConsultaFuncion['cod_banca'];
    mysqli_free_result($ConsultaFuncion);
    return $codigo;
} function ObtenerNombreStatus($identificador)
{
    if ($identificador == 1) {
        echo "ACTIVO";
    } else {
        echo "<font color=#FF0000>INACTIVO";
    }
} function ObtenerNombreAlerta($identificador, $mensaje)
{
    if ($identificador == 1) {
        echo "<script>";
        echo "alert ('$mensaje')";
        echo "</script>";
    }
} function generarCodigo($longitud, $texto)
{
    $key = '';
    $pattern = '123456789'.$texto;
    $max = strlen($pattern)-1;
    for ($i=0;$i < $longitud;$i++) {
        $key .= $pattern{mt_rand(0, $max)};
    }
    return $key;
} function buscaResultadosPorHipodromo($nomHip, $carAnt, $fecSis)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 27 */ SELECT carrera.eje_primero, carrera.div_primero_gan FROM carrera WHERE carrera.nom_hipodromo = %s AND carrera.num_carrera = %s AND carrera.fec_carrera = %s LIMIT 1", GetSQLValueString($nomHip, "text"), GetSQLValueString($carAnt, "int"), GetSQLValueString($fecSis, "date"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $res=1;
    if ($totalRows_ConsultaFuncion>0) {
        if ($row_ConsultaFuncion['eje_primero']<=0 && $row_ConsultaFuncion['div_primero_gan']<=0) {
            $res=0;
        }
    }
    mysqli_free_result($ConsultaFuncion);
    return $res;
} function buscaResultadosLista($nomHip, $carAnt, $fecSis)
{
    $nomHip=trim($nomHip);
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 28 */ SELECT carrera.eje_primero, carrera.div_primero_gan FROM carrera WHERE carrera.nom_hipodromo = %s AND carrera.num_carrera = %s AND carrera.fec_carrera = %s LIMIT 1", GetSQLValueString($nomHip, "text"), GetSQLValueString($carAnt, "int"), GetSQLValueString($fecSis, "date"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $resultado=1;
    if ($totalRows_ConsultaFuncion>0) {
        if ($row_ConsultaFuncion['eje_primero']<=0 && $row_ConsultaFuncion['div_primero_gan']<=0) {
            $resultado=0;
        }
    } else {
        $resultado=0;
        if ($carAnt>1) {
            $carAnt=$carAnt-1;
            for ($i = $carAnt; $i <= 1; $i--) {
                $resultado=buscaResultadosPorHipodromo($nomHip, $i, $fecSis);
                if ($resultado==0) {
                    break;
                }
            }
        }
    }
    mysqli_free_result($ConsultaFuncion);
    return $resultado;
} function ObtenerFechaJugadaCarrera($identificador)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 29 */ SELECT carrera.fec_carrera FROM carrera WHERE carrera.cod_carrera = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $fecharesultado = $row_ConsultaFuncion['fec_carrera'];
    mysqli_free_result($ConsultaFuncion);
    return $fecharesultado;
} function ObtenerHoraJugadaCarrera($identificador)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 30 */ SELECT carrera.hor_carrera FROM carrera WHERE carrera.cod_carrera = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $horaresultado = $row_ConsultaFuncion['hor_carrera'];
    mysqli_free_result($ConsultaFuncion);
    return $horaresultado;
} function ObtenerStatusJugadaCarrera($identificador)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 31 */ SELECT carrera.est_carrera FROM carrera WHERE carrera.cod_carrera = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $statusresultado = $row_ConsultaFuncion['est_carrera'];
    mysqli_free_result($ConsultaFuncion);
    return $statusresultado;
} function ObtenerCantidadcaballosCarrera($identificador)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 32 */ SELECT carrera.can_caballos FROM carrera WHERE carrera.cod_carrera = %s LIMIT 1", GetSQLValueString($identificador, "int"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $sresultado = $row_ConsultaFuncion['can_caballos'];
    mysqli_free_result($ConsultaFuncion);
    return $sresultado;
} function ObtenerNombreynumeroJugadaCarrera($identificador)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 33 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $nombrehipodromo = $row_ConsultaFuncion['nom_hipodromo'];
    $numerocarrera = $row_ConsultaFuncion['num_carrera'];
    mysqli_free_result($ConsultaFuncion);
    return $nombrehipodromo." Carr: ...".$numerocarrera;
} function ObtenerStatusCarreraSinProcesar($identificador, $status)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 34 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", $identificador);
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $estatusdelacarrera=$row_Recordset1['est_carrera'];
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $bandera=0;
    if ($totalRows_Recordset1>=1) {
        if ($row_Recordset1['eje_primero']<=0 && $row_Recordset1['eje_segundo']<=0 && $row_Recordset1['eje_tercero']<=0) {
            if ($status==1 || $status==3) {
                $bandera=1;
            }
        }
    }
    mysqli_free_result($Recordset1);
    return $bandera;
} function GanEjemplar($identificador)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 35 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", $identificador);
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $estatusdelacarrera=$row_Recordset1['est_carrera'];
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $ganadores[0]=$row_Recordset1['eje_primero'];
    $ganadores[1]=$row_Recordset1['eje_segundo'];
    $ganadores[2]=$row_Recordset1['eje_tercero'];
    $ganadores[3]=$row_Recordset1['eje_doble_primero'];
    $ganadores[4]=$row_Recordset1['eje_doble_segundo'];
    $ganadores[5]=$row_Recordset1['eje_doble_tercero'];
    $ganadores[6]=$row_Recordset1['eje_triple_primero'];
    $ganadores[7]=$row_Recordset1['eje_triple_primero'];
    $ganadores[8]=$row_Recordset1['eje_triple_tercero'];
    mysqli_free_result($Recordset1);
    return $ganadores;
} function ObtenerGanDivCarrera($identificador, $campo)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 36 */ SELECT * FROM carrera WHERE carrera.cod_carrera = %s", $identificador);
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    switch ($campo) {  case 1: $campodevuelto=$row_ConsultaFuncion['eje_primero']; break;  case 2: $campodevuelto=$row_ConsultaFuncion['div_primero_gan']; break;  case 3: $campodevuelto=$row_ConsultaFuncion['div_primero_pla']; break;  case 4: $campodevuelto=$row_ConsultaFuncion['div_primero_sho']; break;  case 5: $campodevuelto=$row_ConsultaFuncion['eje_segundo']; break;  case 6: $campodevuelto=$row_ConsultaFuncion['div_segundo_pla']; break;  case 7: $campodevuelto=$row_ConsultaFuncion['div_segundo_sho']; break;  case 8: $campodevuelto=$row_ConsultaFuncion['eje_tercero']; break;  case 9: $campodevuelto=$row_ConsultaFuncion['div_tercero_sho']; break;  case 10: $campodevuelto=$row_ConsultaFuncion['eje_doble_primero']; break; case 11: $campodevuelto=$row_ConsultaFuncion['div_doble_primero_gan']; break;  case 12: $campodevuelto=$row_ConsultaFuncion['div_doble_primero_pla']; break;  case 13: $campodevuelto=$row_ConsultaFuncion['div_doble_primero_sho']; break;  case 14: $campodevuelto=$row_ConsultaFuncion['eje_doble_segundo']; break;  case 15: $campodevuelto=$row_ConsultaFuncion['div_doble_segundo_pla']; break;  case 16: $campodevuelto=$row_ConsultaFuncion['div_doble_segundo_sho']; break;  case 17: $campodevuelto=$row_ConsultaFuncion['eje_doble_tercero']; break;  case 18: $campodevuelto=$row_ConsultaFuncion['div_doble_tercero_sho']; break; case 19: $campodevuelto=$row_ConsultaFuncion['eje_triple_primero']; break;  case 20: $campodevuelto=$row_ConsultaFuncion['div_triple_primero_gan']; break;  case 21: $campodevuelto=$row_ConsultaFuncion['div_triple_primero_pla']; break;  case 22: $campodevuelto=$row_ConsultaFuncion['div_triple_primero_sho']; break;  case 23: $campodevuelto=$row_ConsultaFuncion['eje_triple_segundo']; break;  case 24: $campodevuelto=$row_ConsultaFuncion['div_triple_segundo_pla']; break;  case 25: $campodevuelto=$row_ConsultaFuncion['div_triple_segundo_sho']; break;  case 26: $campodevuelto=$row_ConsultaFuncion['eje_triple_tercero']; break;  case 27: $campodevuelto=$row_ConsultaFuncion['div_triple_tercero_sho']; break; }
    mysqli_free_result($ConsultaFuncion);
    return $campodevuelto;
}

function ObtenerUltimaVenta()
{
    global
$conexionbanca;
    $query_Recordset1 = "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 37 */ SELECT MAX(num_ticket) FROM venta";
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $numeroticket=((int)$row_Recordset1['MAX(num_ticket)'])+1;
    return $numeroticket;
}

function ObtenerVentaDiaVendedor($identificador, $fechaInicio, $fechaFin)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 38 */ SELECT * FROM venta WHERE venta.id_usuario = %s AND venta.est_ticket != 0 AND (venta.fec_venta BETWEEN %s AND %s)", GetSQLValueString($identificador, "int"), GetSQLValueString($fechaInicio, "date"), GetSQLValueString($fechaFin, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $ventatotal=0;
    do {
        $ventatotal=$ventatotal+$row_Recordset1['mon_venta'];
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    return $ventatotal;
} function ObtenerVentaUsuarioTipoVenta($identificador, $fechaInicio, $fechaFin, $tipoVenta)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 39 */ SELECT * FROM venta WHERE venta.id_usuario = %s AND venta.cod_tventa = %s AND venta.est_ticket != 0 AND (venta.fec_venta BETWEEN %s AND %s)", GetSQLValueString($identificador, "int"), GetSQLValueString($tipoVenta, "int"), GetSQLValueString($fechaInicio, "date"), GetSQLValueString($fechaFin, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $ventatotal=0;
    do {
        $ventatotal=$ventatotal+$row_Recordset1['mon_venta'];
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    return $ventatotal;
} function ObtenerInvalidadosUsuario($identificador, $fechaInicio, $fechaFin)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 40 */ SELECT * FROM venta WHERE venta.id_usuario = %s AND venta.est_ticket = 4 AND (venta.fec_venta BETWEEN %s AND %s)", GetSQLValueString($identificador, "int"), GetSQLValueString($fechaInicio, "date"), GetSQLValueString($fechaFin, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $ventatotal=0;
    do {
        $ventatotal=$ventatotal+$row_Recordset1['mon_venta'];
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    return $ventatotal;
} function ObtenerVentaDiaTaquilla($identificador, $fechaInicio, $fechaFin)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 41 */ SELECT * FROM venta WHERE venta.cod_taquilla = %s AND venta.est_ticket != 0 AND (venta.fec_venta BETWEEN %s AND %s)", GetSQLValueString($identificador, "int"), GetSQLValueString($fechaInicio, "date"), GetSQLValueString($fechaFin, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $ventatotal=0;
    do {
        $ventatotal=$ventatotal+$row_Recordset1['mon_venta'];
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    return $ventatotal;
} function ObtenerVentaTaquillaTipoVenta($identificador, $fechaInicio, $fechaFin, $tipoVenta)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 42 */ SELECT * FROM venta WHERE venta.cod_taquilla = %s AND venta.cod_tventa = %s AND venta.est_ticket != 0 AND (venta.fec_venta BETWEEN %s AND %s)", GetSQLValueString($identificador, "int"), GetSQLValueString($tipoVenta, "int"), GetSQLValueString($fechaInicio, "date"), GetSQLValueString($fechaFin, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $ventatotal=0;
    do {
        $ventatotal=$ventatotal+$row_Recordset1['mon_venta'];
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    return $ventatotal;
} function ObtenerInvalidadosTaquilla($identificador, $fechaInicio, $fechaFin)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 43 */ SELECT * FROM venta WHERE venta.cod_taquilla = %s AND venta.est_ticket = 4 AND (venta.fec_venta BETWEEN %s AND %s)", GetSQLValueString($identificador, "int"), GetSQLValueString($fechaInicio, "date"), GetSQLValueString($fechaFin, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $ventatotal=0;
    do {
        $ventatotal=$ventatotal+$row_Recordset1['mon_venta'];
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    return $ventatotal;
}

function ObtenerNumeroJugada($identificador, $fechajugada)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 44 */ SELECT * FROM venta 
USE INDEX(id_us_fe_fe)
WHERE venta.fec_venta = %s AND venta.id_usuario = %s", GetSQLValueString($fechajugada, "date"), GetSQLValueString($identificador, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $ticketanterior="";
    $contador=0;
    if ($totalRows_Recordset1>0) {
        do {
            if ($row_Recordset1['ticket']!=$ticketanterior) {
                $contador=$contador+1;
                $ticketanterior=$row_Recordset1['ticket'];
            }
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    }
    $contador=str_pad($contador, 5, "0", STR_PAD_LEFT);
    return $contador;
} function ObtenerMonTototalVenta($identificador)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 45 */ SELECT * FROM venta WHERE venta.ticket = %s", $identificador, "int");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $montojugada=0;
    do {
        $montojugada=((int)$row_Recordset1['mon_venta'])+$montojugada;
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    return $montojugada.".00";
} function BuscarRetirados($identificador)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 46 */ SELECT * FROM retirados WHERE retirados.cod_carrera = %s ORDER BY retirados.num_rcaballo ASC", $identificador, "int");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $retirados="";
    if ($totalRows_Recordset1<=0) {
        $retirados ="NINGUNO";
    } else {
        do {
            $retirados=$retirados."[".(string)($row_Recordset1['num_rcaballo'])."] ";
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    }
    return $retirados;
} function bRetirados($identificador)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 47 */ SELECT * FROM retirados WHERE retirados.cod_carrera = %s ORDER BY retirados.num_rcaballo ASC", $identificador, "int");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $retirados="";
    if ($totalRows_Recordset1<=0) {
        $retirados ="NINGUNO";
    } else {
        do {
            $codRe=$row_Recordset1['cod_retirado'];
            $numEj=$row_Recordset1['num_rcaballo'];
            $retirados=$retirados." <a href='caballos_retirar_del.php?recordID=$codRe' title='reintegrar ejemplar# $numEj'> [$numEj] </a> ";
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    }
    return $retirados;
} function cantRetirados($codCarrera)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 48 */ SELECT retirados.cod_carrera FROM retirados WHERE retirados.cod_carrera = %s", GetSQLValueString($codCarrera, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    return $totalRows_Recordset1;
} function RetiradosSimple($codcarrera, $ejemplar)
{
    $totalRows_Recordset1=0;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 49 */ SELECT num_rcaballo FROM retirados  WHERE retirados.cod_carrera = %s AND retirados.num_rcaballo = %s LIMIT 1", GetSQLValueString($codcarrera, "int"), GetSQLValueString($ejemplar, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    return $totalRows_Recordset1;
} function arrayRetirados($carrera)
{
    global $conexionbanca;
    $reti[0]="";
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 50 */ SELECT retirados.num_rcaballo FROM retirados WHERE retirados.cod_carrera = %s", GetSQLValueString($carrera, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $s=0;
    if ($totalRows_Recordset1>0) {
        do {
            $reti[$s]=$row_Recordset1['num_rcaballo'];
            $s++;
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    }
    return $reti;
} function BuscarTicketEliminados($codusuario, $fechaactual)
{
    $totalRows_Recordset1=0;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 51 */ SELECT est_ticket  FROM  venta  WHERE  venta.est_ticket = 0 AND  venta.id_usuario = %s AND  venta.fec_venta = %s GROUP BY ticket", GetSQLValueString($codusuario, "int"), GetSQLValueString($fechaactual, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    return $totalRows_Recordset1;
} function BuscarTicketganador($xTicket)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 52 */ SELECT * FROM venta, carrera WHERE venta.num_ticket = %s AND venta.cod_carrera = carrera.cod_carrera", GetSQLValueString($xTicket, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $montoapagar=0;
    if ($row_Recordset1['num_caballo']==$row_Recordset1['eje_primero']) {
        if ((int)$row_Recordset1['cod_tventa']==1) {
            $montoapagar=(($row_Recordset1['div_primero_gan'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
        if ((int)$row_Recordset1['cod_tventa']==2) {
            $montoapagar=(($row_Recordset1['div_primero_pla'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
        if ((int)$row_Recordset1['cod_tventa']==3) {
            $montoapagar=(($row_Recordset1['div_primero_sho'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
    }
    if ($row_Recordset1['num_caballo']==$row_Recordset1['eje_segundo']) {
        if ((int)$row_Recordset1['cod_tventa']==2) {
            $montoapagar=(($row_Recordset1['div_segundo_pla'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
        if ((int)$row_Recordset1['cod_tventa']==3) {
            $montoapagar=(($row_Recordset1['div_segundo_sho'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
    }
    if ($row_Recordset1['num_caballo']==$row_Recordset1['eje_tercero']) {
        if ((int)$row_Recordset1['cod_tventa']==3) {
            $montoapagar=(($row_Recordset1['div_tercero_sho'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
    }
    if ($row_Recordset1['num_caballo']==$row_Recordset1['eje_doble_primero']) {
        if ((int)$row_Recordset1['cod_tventa']==1) {
            $montoapagar=(($row_Recordset1['div_doble_primero_gan'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
        if ((int)$row_Recordset1['cod_tventa']==2) {
            $montoapagar=(($row_Recordset1['div_doble_primero_pla'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
        if ((int)$row_Recordset1['cod_tventa']==3) {
            $montoapagar=(($row_Recordset1['div_doble_primero_sho'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
    }
    if ($row_Recordset1['num_caballo']==$row_Recordset1['eje_doble_segundo']) {
        if ((int)$row_Recordset1['cod_tventa']==2) {
            $montoapagar=(($row_Recordset1['div_doble_segundo_pla'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
        if ((int)$row_Recordset1['cod_tventa']==3) {
            $montoapagar=(($row_Recordset1['div_doble_segundo_sho'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
    }
    if ($row_Recordset1['num_caballo']==$row_Recordset1['eje_doble_tercero']) {
        if ((int)$row_Recordset1['cod_tventa']==3) {
            $montoapagar=(($row_Recordset1['div_doble_tercero_sho'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
    }
    if ($row_Recordset1['num_caballo']==$row_Recordset1['eje_triple_primero']) {
        if ((int)$row_Recordset1['cod_tventa']==1) {
            $montoapagar=(($row_Recordset1['div_triple_primero_gan'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
        if ((int)$row_Recordset1['cod_tventa']==2) {
            $montoapagar=(($row_Recordset1['div_triple_primero_pla'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
        if ((int)$row_Recordset1['cod_tventa']==3) {
            $montoapagar=(($row_Recordset1['div_triple_primero_sho'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
    }
    if ($row_Recordset1['num_caballo']==$row_Recordset1['eje_triple_segundo']) {
        if ((int)$row_Recordset1['cod_tventa']==2) {
            $montoapagar=(($row_Recordset1['div_triple_segundo_pla'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
        if ((int)$row_Recordset1['cod_tventa']==3) {
            $montoapagar=(($row_Recordset1['div_triple_segundo_sho'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
    }
    if ($row_Recordset1['num_caballo']==$row_Recordset1['eje_triple_tercero']) {
        if ((int)$row_Recordset1['cod_tventa']==3) {
            $montoapagar=(($row_Recordset1['div_triple_tercero_sho'] / 2) * $row_Recordset1['mon_venta']) + $montoapagar;
        }
    }
    return $montoapagar;
} function GanadoresporTaquilla($codTaquilla, $fecInicio, $fecFin, $tipoVenta)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 53 */ SELECT * FROM venta WHERE venta.cod_taquilla = %s AND venta.cod_tventa = %s AND (venta.fec_venta BETWEEN %s AND %s)", GetSQLValueString($codTaquilla, "int"), GetSQLValueString($tipoVenta, "int"), GetSQLValueString($fecInicio, "date"), GetSQLValueString($fecFin, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $premios=0;
    do {
        if ($row_Recordset1['est_ticket']==2) {
            $premios=BuscarTicketganador($row_Recordset1['num_ticket'])+$premios;
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    return $premios;
} function GanadoresporUsuario($idusuario, $fecInicio, $fecFin, $tipoVenta)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 54 */ SELECT * FROM venta WHERE venta.id_usuario = %s AND venta.cod_tventa = %s AND (venta.fec_venta BETWEEN %s AND %s)", GetSQLValueString($idusuario, "int"), GetSQLValueString($tipoVenta, "int"), GetSQLValueString($fecInicio, "date"), GetSQLValueString($fecFin, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $premios=0;
    do {
        if ($row_Recordset1['est_ticket']==2 && $row_Recordset1['cod_usuario_pago']==$idusuario) {
            $premios=BuscarTicketganador($row_Recordset1['num_ticket'])+$premios;
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    return $premios;
} function ObtenerNombreApuesta($identificador)
{
    if ($identificador == 1) {
        echo "GAN";
    }
    if ($identificador == 2) {
        echo "PLA";
    }
    if ($identificador == 3) {
        echo "SHW";
    }
    if ($identificador == 4) {
        echo "EXA";
    }
    if ($identificador == 5) {
        echo "TRI";
    }
    if ($identificador == 6) {
        echo "SUP";
    }
    if ($identificador == 7) {
        echo "(P)EXA";
    }
    if ($identificador == 8) {
        echo "(P)TRI";
    }
    if ($identificador == 9) {
        echo "(P)SUP";
    }
} function ObtenerNombreApuesta2($identificador)
{
    if ($identificador == 1) {
        $nombre="GAN";
    }
    if ($identificador == 2) {
        $nombre="PLA";
    }
    if ($identificador == 3) {
        $nombre="SHW";
    }
    if ($identificador == 4) {
        $nombre="EXA";
    }
    if ($identificador == 5) {
        $nombre="TRI";
    }
    if ($identificador == 6) {
        $nombre="SUP";
    }
    if ($identificador == 7) {
        $nombre="(P)EXA";
    }
    if ($identificador == 8) {
        $nombre="(P)TRI";
    }
    if ($identificador == 9) {
        $nombre="(P)SUP";
    }
    return $nombre;
} function ObtenerNombreTipo($identificador)
{
    if ($identificador == 1) {
        echo "ADMINISTRADOR";
    } else {
        echo "<font color=#339900>APERTURA CIERRE";
    }
} function ObtenerNombreStatusCarrera($identificador)
{
    if ($identificador == 0) {
        echo "<font color=#FF0000>CERRADA";
    }
    if ($identificador == 1) {
        echo "<font color=#339900>ABIERTA";
    }
    if ($identificador == 3) {
        echo "<font color=#FF0000>INVALIDADA";
    }
} function getRealIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $_SERVER['REMOTE_ADDR'];
} function idpadre1($nombre, $valor)
{
    $query = "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 55 */ SELECT * from agencia order by nom_agencia";
    mysql_select_db($dbname);
    $result = mysqli_query($conexionbanca, $query);
    echo "<select name='$nombre' id='$nombre'>";
    echo "<option value=''>Selecciona un Padre...</option>";
    while ($registro=mysql_fetch_array($result)) {
        echo "<option value='".$registro["idpadre"]."'";
        if ($registro["idpadre"]==$valor) {
            echo " selected";
        }
        echo ">".$registro["padre"]."</option>\r\n";
    }
    echo "</select>";
} function idhijo1($nombre, $valor)
{
    $query = "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 56 */ SELECT * FROM hijo order by hijo";
    mysql_select_db($dbname);
    $result = mysqli_query($conexionbanca, $query);
    echo "<select name='$nombre' id='$nombre'>";
    echo "<option value=''>Selecciona un Hijo...</option>";
    while ($registro=mysql_fetch_array($result)) {
        echo "<option value='".$registro["idhijo"]."'";
        if ($registro["idhijo"]==$valor) {
            echo " selected";
        }
        echo ">".$registro["hijo"]."</option>\r\n";
    }
    echo "</select>";
} function idnieto1($nombre, $valor)
{
    $query = "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 57 */ SELECT * FROM nieto order by nieto";
    mysql_select_db($dbname);
    $result = mysqli_query($conexionbanca, $query);
    echo "<select name='$nombre' id='$nombre'>";
    echo "<option value=''>Selecciona un Nieto...</option>";
    while ($registro=mysql_fetch_array($result)) {
        echo "<option value='".$registro["idnieto"]."'";
        if ($registro["idnieto"]==$valor) {
            echo " selected";
        }
        echo ">".$registro["nieto"]."</option>\r\n";
    }
    echo "</select>";
} function permutarExoticas($str)
{
    $str="1-2-3-4";
    $separa=explode("-", $str);
    $y=0;
    $longitud=count($separa)-1;
    $num=array();
    $a=0;
    for ($x = 0; $x <= $longitud; $x++) {
        $num[$x]=$separa[$x];
        for ($y = 0; $y <= $longitud; $y++) {
            if ($y!=$x) {
                $num[$x]=$num[$x]."-".$separa[$y];
            }
        }
        echo $num[$x]."<br>";
    }
    return $num;
} function dividirMontoExoticas($inicio, $tipo)
{
    if ($tipo>=1 && $tipo<=6) {
        $fin[0]="";
    } else {
        $fin[0] ="c/u";
    }
    $fin[1]=$inicio;
    if ($tipo==7) {
        $fin[1]=$inicio/2;
    }
    if ($tipo==8) {
        $fin[1]=$inicio/6;
    }
    if ($tipo==9) {
        $fin[1]=$inicio/24;
    }
    return $fin;
}

function UltimoTicket($usu)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 58 */ SELECT num_ticket, est_impresion, ticket 
		FROM venta 
		WHERE id_usuario = %s 
		ORDER BY num_ticket DESC",
        GetSQLValueString($usu, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $numeroticket=$row_Recordset1['num_ticket'];
    $ticket=$row_Recordset1['ticket'];
    $estimpresion=$row_Recordset1['est_impresion'];
    return array($numeroticket, $ticket, $estimpresion);
}
function CambiarEstImpresion($nti)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 59 */ SELECT num_ticket
		FROM venta 
		WHERE num_ticket = %s",
        GetSQLValueString($nti, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
}
function CambiarEstImpresion1($numerotiket2)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 60 */ SELECT num_ticket 
		FROM venta 
		WHERE ticket = %s", GetSQLValueString($numerotiket2, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    /*
    if ($totalRows_Recordset1>0) {
        do {
            $ntic=$row_Recordset1['num_ticket'];
            $insertSQL2 = sprintf("UPDATE venta
                        SET
                        est_impresion=%s,
                        WHERE num_ticket=%s",
                        GetSQLValueString(1,  "int"),
                        GetSQLValueString($ntic, "int"));
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    }
    */
}
function ctaReimpresion($idu, $tp)
{ //id usuario - tipo programa
    $h=fechaactualbd();
    $can=0;
    $idI=-1;
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 61 */ SELECT can_actual, id_reimpresion
		FROM reimpresion 
		WHERE id_usuario = %s AND fec_reimpresion = %s AND tip_programa = %s LIMIT 1",
        GetSQLValueString($idu, "int"),
        GetSQLValueString($h, "date"),
        GetSQLValueString($tp, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $can=$row_Recordset1['can_actual'];
        $idI=$row_Recordset1['id_reimpresion'];
    }
    mysqli_free_result($Recordset1);
    return array($can, $idI);
}
function tipProHipodromo($identificador)
{
    $hipodromo[0]=0;
    $hipodromo[1]=-1;
    $hipodromo[2]=-1;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 62 */ SELECT cod_hipodromo, pro_desde 
			FROM hipodromo 
			WHERE nom_hipodromo_rac = %s LIMIT 1",
        GetSQLValueString($identificador, "text")
    );
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $hipodromo[0]=1;
        $hipodromo[1]=$row_ConsultaFuncion['cod_hipodromo'];
        $hipodromo[2]=$row_ConsultaFuncion['pro_desde'];
    }
    mysqli_free_result($ConsultaFuncion);
    return $hipodromo;
}
function busHipodromo($identificador)
{
    $hipodromo[0]=0;
    $hipodromo[1]=-1;
    $hipodromo[2]=-1;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 63 */ SELECT cod_hipodromo, pro_desde FROM hipodromo WHERE pre_hipodromo = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $hipodromo[0]=1;
        $hipodromo[1]=$row_ConsultaFuncion['cod_hipodromo'];
        $hipodromo[2]=$row_ConsultaFuncion['pro_desde'];
    }
    mysqli_free_result($ConsultaFuncion);
    return $hipodromo;
}

function verificarCarrera($identificador, $carr, $fecha)
{
    $hipodromo=trim(strtoupper($identificador));
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 64 */ SELECT est_carrera 
		FROM carrera  
		WHERE  nom_hipodromo = %s AND  num_carrera = %s AND  fec_carrera = %s LIMIT 1",
        GetSQLValueString($hipodromo, "text"),
        GetSQLValueString($carr, "int"),
        GetSQLValueString($fecha, "date")
    );
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    mysqli_free_result($ConsultaFuncion);
    return $totalRows_ConsultaFuncion;
}
function buscaHip5($identificador)
{
    $nomb2="";
    $tipo=-1;
    $cod=-1;
    $identificador=strtoupper($identificador);
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 65 */ SELECT cod_hipodromo, nom_hipodromo, bus_auto FROM hipodromo WHERE nom_hipodromo_rac = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $nomb2=$row_ConsultaFuncion['nom_hipodromo'];
        $tipo=$row_ConsultaFuncion['bus_auto'];
        $cod=$row_ConsultaFuncion['cod_hipodromo'];
        if ($nomb2=="") {
            $nomb2=$identificador;
            $tipo=-1;
            $cod=-1;
        }
    }
    mysqli_free_result($ConsultaFuncion);
    return array($cod, $nomb2, $tipo);
}

function buscaHip6($identificador)
{
    $nomb2="";
    $tipo=-1;
    $cod=-1;
    $identificador=strtoupper($identificador);
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 66 */ SELECT cod_hipodromo, nom_hipodromo, bus_auto FROM hipodromo WHERE pre_build = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $nomb2=$row_ConsultaFuncion['nom_hipodromo'];
        $tipo=$row_ConsultaFuncion['bus_auto'];
        $cod=$row_ConsultaFuncion['cod_hipodromo'];
        if ($nomb2=="") {
            $nomb2=$identificador;
            $tipo=-1;
            $cod=-1;
        }
    }
    mysqli_free_result($ConsultaFuncion);
    return array($cod, $nomb2, $tipo);
}



function buscaHipBuild5($identificador)
{
    $tipo=-1;
    $nomb2="";
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 67 */ SELECT nom_hipodromo, bus_auto 
		FROM hipodromo 
		WHERE cod_hipodromo = %s 
		LIMIT 1",
        GetSQLValueString($identificador, "int")
    );
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    if ($totalRows_ConsultaFuncion>0) {
        $nomb2=$row_ConsultaFuncion['nom_hipodromo'];
        $tipo=$row_ConsultaFuncion['bus_auto'];
        if ($nomb2=="") {
            $tipo=-1;
        }
    }
    mysqli_free_result($ConsultaFuncion);
    return array($tipo,$nomb2);
}

function verificarCarrera2($cod, $num, $fec)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 68 */ SELECT est_carrera FROM carrera  WHERE cod_hipodromo = %s AND num_carrera = %s AND  fec_carrera = %s LIMIT 1", GetSQLValueString($cod, "int"), GetSQLValueString($num, "int"), GetSQLValueString($fec, "date"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    mysqli_free_result($ConsultaFuncion);
    return $totalRows_ConsultaFuncion;
}
function verificarPremio($xnroTicket, $uVenta)
{
    $montoapagar=0;
    $jugada="";
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 69 */ SELECT * FROM venta, carrera, taquilla, taquilla_opc_ame, usuario  WHERE usuario.cod_taquilla = taquilla.cod_taquilla AND taquilla_opc_ame.cod_taquilla = taquilla.cod_taquilla AND usuario.id_usuario = venta.id_usuario AND usuario.id_usuario = %s AND venta.ticket = %s AND  venta.cod_carrera = carrera.cod_carrera", GetSQLValueString($uVenta, "int"), GetSQLValueString($xnroTicket, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $carrera=$row_Recordset1['nom_hipodromo']."...".$row_Recordset1['num_carrera']."&nbsp;";
    if ($totalRows_Recordset1>0 && $row_Recordset1['est_carrera']==0 && $row_Recordset1['est_confirmacion']==0  &&
        $row_Recordset1['eje_primero']>0 && $row_Recordset1['est_ticket']==1) {
        $retirados=arrayRetirados($row_Recordset1['cod_carrera']);
        $montoapagar=0;
        $montoretiro=0;
        $i=0;
        $estado=array(0);
        $_nTicket=array(0);
        $stPag=0;
        do {
            if ($row_Recordset1['est_ticket']==2) {
                $montoapagar=0;
                $montoretiro=0;
                break;
            }
            $tV=ObtenerNombreApuesta2($row_Recordset1['cod_tventa']);
            $jugada=$jugada."&nbsp;|N:".$tV." ".$row_Recordset1['mon_venta'];
            $pago[0]=0;
            $pago[1]="";
            $retiro=0;
            if ($retirados[0]!="0") {
                if (in_array($row_Recordset1['num_caballo'], $retirados, true)) {
                    $retiro=1;
                }
                if ((int)$row_Recordset1['cod_tventa']>=4 && (int)$row_Recordset1['cod_tventa']<=9) {
                    $fcab=explode("-", $row_Recordset1['num_caballo']);
                    foreach ($fcab as $mtz1) {
                        if (in_array($mtz1, $retirados, true)) {
                            $retiro=1;
                            break;
                        }
                    }
                }
            }
            if ($retiro==0) {
                if ($row_Recordset1['cod_tventa']>=1 && $row_Recordset1['cod_tventa']<=3) {
                    if ($row_Recordset1['cod_tventa']==1) {
                        $topJugada=$row_Recordset1['max_aganar_gan'];
                        $regalo=$row_Recordset1['reg_gan'];
                    }
                    if ($row_Recordset1['cod_tventa']==2) {
                        $topJugada=$row_Recordset1['max_aganar_pla'];
                        $regalo=$row_Recordset1['reg_pla'];
                    }
                    if ($row_Recordset1['cod_tventa']==3) {
                        $topJugada=$row_Recordset1['max_aganar_sho'];
                        $regalo=$row_Recordset1['reg_sho'];
                    }
                    $pago=jNormal($row_Recordset1['num_caballo'], $row_Recordset1['cod_tventa'], $row_Recordset1['mon_venta'], $row_Recordset1['eje_primero'], $row_Recordset1['eje_doble_primero'], $row_Recordset1['eje_triple_primero'], $row_Recordset1['div_primero_gan'], $row_Recordset1['div_primero_pla'], $row_Recordset1['div_primero_sho'], $row_Recordset1['div_doble_primero_gan'], $row_Recordset1['div_doble_primero_pla'], $row_Recordset1['div_doble_primero_sho'], $row_Recordset1['div_triple_primero_gan'], $row_Recordset1['div_triple_primero_pla'], $row_Recordset1['div_triple_primero_sho'], $row_Recordset1['eje_segundo'], $row_Recordset1['eje_doble_segundo'], $row_Recordset1['eje_triple_segundo'], $row_Recordset1['div_segundo_pla'], $row_Recordset1['div_segundo_sho'], $row_Recordset1['div_doble_segundo_pla'], $row_Recordset1['div_doble_segundo_sho'], $row_Recordset1['div_triple_segundo_pla'], $row_Recordset1['div_triple_segundo_sho'], $row_Recordset1['eje_tercero'], $row_Recordset1['eje_doble_tercero'], $row_Recordset1['eje_triple_tercero'], $row_Recordset1['div_tercero_sho'], $row_Recordset1['div_doble_tercero_sho'], $row_Recordset1['div_triple_tercero_sho'], $topJugada, $regalo, $row_Recordset1['anu_regalia']);
                    if ($pago[0]>0) {
                        $montoapagar=$pago[0]+$montoapagar;
                        $_nTicket[$i]=$row_Recordset1['num_ticket'];
                        $estado[$i]=$pago[1];
                        $i=$i+1;
                    }
                }
                if ($row_Recordset1['cod_tventa']>=4 && $row_Recordset1['cod_tventa']<=9) {
                    if ($row_Recordset1['cod_tventa']==4 || $row_Recordset1['cod_tventa']==7) {
                        $fact=$row_Recordset1['fac_exacta'];
                        $topJugada=$row_Recordset1['max_aganar_exa'];
                        $regalo=$row_Recordset1['reg_exa'];
                    }
                    if ($row_Recordset1['cod_tventa']==5 || $row_Recordset1['cod_tventa']==8) {
                        $fact=$row_Recordset1['fac_trifecta'];
                        $topJugada=$row_Recordset1['max_aganar_tri'];
                        $regalo=$row_Recordset1['reg_tri'];
                    }
                    if ($row_Recordset1['cod_tventa']==6 || $row_Recordset1['cod_tventa']==9) {
                        $fact=$row_Recordset1['fac_superfecta'];
                        $topJugada=$row_Recordset1['max_aganar_sup'];
                        $regalo=$row_Recordset1['reg_sup'];
                    }
                    $base=2;
                    $pago=jExotica2($row_Recordset1['num_caballo'], $row_Recordset1['cod_tventa'], $row_Recordset1['mon_venta'], $row_Recordset1['div_exacta'], $row_Recordset1['ord_exacta'], $row_Recordset1['div_trifecta'], $row_Recordset1['ord_trifecta'], $row_Recordset1['div_superfecta'], $row_Recordset1['ord_superfecta'], $row_Recordset1['div_exacta_doble'], $row_Recordset1['ord_exacta_doble'], $row_Recordset1['div_trifecta_doble'], $row_Recordset1['ord_trifecta_doble'], $row_Recordset1['div_superfecta_doble'], $row_Recordset1['ord_superfecta_doble'], $row_Recordset1['div_exacta_triple'], $row_Recordset1['ord_exacta_triple'], $row_Recordset1['div_trifecta_triple'], $row_Recordset1['ord_trifecta_triple'], $row_Recordset1['div_superfecta_triple'], $row_Recordset1['ord_superfecta_triple'], $topJugada, $regalo, $fact, $base);
                    if ($pago[0]>0) {
                        $montoapagar=$pago[0]+$montoapagar;
                        $_nTicket[$i]=$row_Recordset1['num_ticket'];
                        $estado[$i]=$pago[1];
                        $i=$i+1;
                    }
                }
            } else {
                $montoretiro=$montoretiro+$row_Recordset1['mon_venta'];
                $_nTicket[$i]=$row_Recordset1['num_ticket'];
                $estado[$i]="4";
                $i=$i+1;
            }
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        $montoapagar=$montoapagar+$montoretiro;
    } else {
        $montoapagar=0;
        if ($totalRows_Recordset1>0 && $row_Recordset1['est_carrera']==0 && $row_Recordset1['est_cierre']==0 &&
            $row_Recordset1['est_ticket']==1 && $row_Recordset1['eje_primero']==99) {
            do {
                $tV=ObtenerNombreApuesta2($row_Recordset1['cod_tventa']);
                $jugada=$jugada."&nbsp;|N:".$tV." ".$row_Recordset1['mon_venta'];
                $montoapagar=$montoapagar+$row_Recordset1['mon_venta'];
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        }
    }
    $jugada=$carrera.$jugada;
    return array($montoapagar, $jugada);
}
function montoEjemplarxCarrera($carr, $fec, $taq, $eje)
{
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 70 */ SELECT SUM(mon_venta) as monto FROM venta  WHERE  cod_carrera = %s AND fec_venta = %s AND  cod_taquilla = %s AND  num_caballo = %s", GetSQLValueString($carr, "int"), GetSQLValueString($fec, "date"), GetSQLValueString($taq, "int"), GetSQLValueString($eje, "int"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $monto=$row_ConsultaFuncion['monto'];
    mysqli_free_result($ConsultaFuncion);
    return $monto;
}

function verCarrera($nom, $num, $fec)
{
    global $conexionbanca;
    $exist=-1;
    $hora=-1;
    $esta=-1;
    if ($num>1) {
        $num=$num-1;
        $query_ConsultaFuncion = sprintf(
            "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 71 */ SELECT hor_carrera, est_carrera FROM carrera  
				WHERE  nom_hipodromo = %s AND num_carrera = %s AND fec_carrera = %s",
            GetSQLValueString($nom, "text"),
            GetSQLValueString($num, "int"),
            GetSQLValueString($fec, "date")
        );
        $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
        $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
        $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
        $exit=$totalRows_ConsultaFuncion;
        $hora=$row_ConsultaFuncion['hor_carrera'];
        $esta=$row_ConsultaFuncion['est_carrera'];
        mysqli_free_result($ConsultaFuncion);
    }
    return array($exist, $hora, $esta);
}
function get_url_contents($url)
{
    if (function_exists('file_get_contents')) {
        $result = @file_get_contents($url);
    }
    if ($result == '') {
        $ch = curl_init();
        $timeout = 30;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
    }
    return $result;
}
 
function programar_carreras_BuildABet2()
{
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    $y=0;
    $nhipo[$y]="";
    $tcarr[$y]="";
    $ccarr[$y]="";
    $idcar[$y]="";
    $chora[$y]="";
    $pre_hipodromo[$y]="";
    $url = 'https://bab2ghc.usofftrack.com/data/ProgramList.json?ScanDate='.$hoy.'&lsa=';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $g=0;
    if (isset($fulldatos["Result"])) {
        foreach ($fulldatos["Result"]["progs"] as $da) {
            $hora = new DateTime();
            $hora->setTimestamp($fulldatos["Result"]["progs"][$g]["FirstRacePostTimeMs"]);
            $horaC=$hora->format('H:i:s');
            $nhipo[$g]=strtoupper($fulldatos["Result"]["progs"][$g]["ProgramName"]);
            $idcar[$g]=$fulldatos["Result"]["progs"][$g]["ProgramID"]."/".$fulldatos["Result"]["progs"][$g]["FirstRaceID"];
            $idH=$fulldatos["Result"]["progs"][$g]["ProgramID"];
            $idP=$fulldatos["Result"]["progs"][$g]["FirstRaceID"];
            $tcarr[$g]="";
            $ccarr[$g]=$fulldatos["Result"]["progs"][$g]["HighestRace"];
            $chora[$g]=$horaC;
            $pre_hipodromo[$g]=$fulldatos["Result"]["progs"][$g]["ProgramKeyCode"];
            $g++;
        }
    }
    //-----------
    return array($nhipo, $idcar, $tcarr, $ccarr, $chora, $pre_hipodromo);
}
function programar_carreras_BuildABet22()
{
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    $y=0;
    $nhipo[$y]="";
    $tcarr[$y]="";
    $ccarr[$y]="";
    $idcar[$y]="";
    $chora[$y]="";
    $pre_hipodromo[$y]="";
    $url = 'https://bab2ghc.usofftrack.com/data/ProgramList.json?ScanDate='.$hoy.'&lsa=';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $g=0;
    if (isset($fulldatos["Result"])) {
        foreach ($fulldatos["Result"]["progs"] as $da) {
            $hora = new DateTime();
            $hora->setTimestamp($fulldatos["Result"]["progs"][$g]["FirstRacePostTimeMs"]);
            $horaC=$hora->format('H:i:s');
            $nhipo[$g]=strtoupper($fulldatos["Result"]["progs"][$g]["ProgramName"]);
            $idcar[$g]=$fulldatos["Result"]["progs"][$g]["ProgramID"]."/".$fulldatos["Result"]["progs"][$g]["FirstRaceID"];
            $idH=$fulldatos["Result"]["progs"][$g]["ProgramID"];
            $idP=$fulldatos["Result"]["progs"][$g]["FirstRaceID"];
            $tcarr[$g]="";
            $ccarr[$g]=$fulldatos["Result"]["progs"][$g]["HighestRace"];
            $chora[$g]=$horaC;
            $pre_hipodromo[$g]=$fulldatos["Result"]["progs"][$g]["ProgramName"];
            $g++;
        }
    }
    //-----------
    return array($nhipo, $idcar, $tcarr, $ccarr, $chora, $pre_hipodromo);
}

function consultaBuildRetirados($idH, $idC, $hoy)
{
    $url='http://bab2ghc.usofftrack.com/data/ProgramDetail.json?sdt='.$hoy.'&aid=&pid='.$idH.'&rid='.$idC.'&init=true';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $g=0;
    $f=0;
    $nRetirados[$g]="";
    $corren=0;
    $retirados=0;
    $programados=0;
    if (isset($fulldatos["Result"])) {
        $programados=$fulldatos["Result"]["raceinfo"]["NumberOfRunners"];
        foreach ($fulldatos["Result"]["entries"] as $da) {
            if ($fulldatos["Result"]["entries"][$g]["sc"]==true) {
                $nRetirados[$f]=$fulldatos["Result"]["entries"][$g]["n"];
                $f++;
            }
            $g++;
        }
        $retirados=$f;
        $corren=$programados-$retirados;
    }
    return array($nRetirados, $programados, $retirados);
}

function consultaRacebetsRetirados($id, $carr)
{
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    $nRetirados[0]="";
    $retirados=0;
    $url ="";
    if ($_SERVER['HTTP_HOST']=="l\157c\x61l\x68\x6f\x73t") {
        $url = 'https://ajax.racebets.com/ajax/races/details/id/'.$id.'/version/detailed/';
    }
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    if (isset($fulldatos["timestamp"])) {
        $nHipodromo=$fulldatos["event"]["title"];
        $ncarrera=$fulldatos["race"]["raceNumber"];
        if (isset($fulldatos["race"]["raceNumber"]) && $carr==$fulldatos["race"]["raceNumber"]) {
            $fecha = new DateTime();
            $postTime=$fulldatos["timestamp"];
            $fecha->setTimestamp($postTime);
            $fec=$fecha->format('Y-m-d');
            if ($hoy==$fec) {
                $xReti=$fulldatos["runners"]["data"];
                $firt=current($xReti);
                $inicio=$firt["idRunner"];
                for ($w = 1; $w <= 40; $w++) {
                    $igualesRet[$w]=0;
                    $igualesCab[$w]=0;
                }
                for ($i = 0; $i <= 40; $i++) {
                    if (isset($fulldatos["runners"]["data"][$inicio+$i]["idRunner"])) {
                        $rest = substr($fulldatos["runners"]["data"][$inicio+$i]["programNumber"], -1);
                        if ($rest=="A" || $rest=="B" ||  $rest=="C" ||  $rest=="D" ||  $rest=="E" ||  $rest=="F" ||  $rest=="X") {
                            $rest2 = substr($fulldatos["runners"]["data"][$inicio+$i]["programNumber"], 0, -1);
                            $igualesCab[$rest2]++;
                        } else {
                            $igualesCab[$fulldatos["runners"]["data"][$inicio+$i]["programNumber"]]++;
                        }
                        if ($fulldatos["runners"]["data"][$inicio+$i]["scratched"]===true) {
                            $xR=$fulldatos["runners"]["data"][$inicio+$i]["programNumber"];
                            $rest = substr($xR, -1);
                            if ($rest=="A" || $rest=="B" || $rest=="C" || $rest=="D" || $rest=="E" || $rest=="F" || $rest=="X") {
                                $rest = substr($xR, 0, -1);
                            } else {
                                $rest = $fulldatos["runners"]["data"][$inicio+$i]["programNumber"];
                            }
                            $igualesRet[$rest]++;
                        }
                        $programados=$fulldatos["runners"]["data"][$inicio+$i]["programNumber"];
                    } else {
                        $programados=$fulldatos["runners"]["data"][$inicio+$i-1]["programNumber"];
                        break;
                    }
                }
                $h=0;
                for ($w = 1; $w <= $i; $w++) {
                    if ($igualesRet[$w]>0) {
                        if ($igualesRet[$w]==$igualesRet[$w]) {
                            $nRetirados[$h]=$w;
                            $h++;
                        }
                    }
                }
                $retirados=$h;
                $corren=$programados-$retirados;
            }
        }
    }
    return array($nRetirados, $programados, $retirados);
} function mtpCierreRetiroRacebets($id, $carr)
{
    set_time_limit(0);
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    $url = 'https://ajax.racebets.com/ajax/races/details/id/'.$id.'/version/detailed/';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $nHipodromo="";
    $ncarrera=0;
    $fec="";
    $hor="";
    $status="";
    $programados=0;
    $retirados=0;
    $nRetirados[0]=0;
    $corren=0;
    if (isset($fulldatos["timestamp"])) {
        $nHipodromo=strtoupper($fulldatos["event"]["title"]);
        $ncarrera=$fulldatos["race"]["raceNumber"];
        $status=$fulldatos["race"]["raceStatus"];
        if (isset($fulldatos["race"]["raceNumber"]) && $carr==$ncarrera) {
            $fecha = new DateTime();
            $postTime=$fulldatos["timestamp"];
            $fecha->setTimestamp($postTime);
            $fec=$fecha->format('Y-m-d');
            if ($hoy==$fec) {
                $hora = new DateTime();
                $hora->setTimestamp($postTime);
                $hor=$hora->format('H:i');
                $xReti=$fulldatos["runners"]["data"];
                $firt=current($xReti);
                $inicio=$firt["idRunner"];
                for ($w = 1; $w <= 40; $w++) {
                    $igualesRet[$w]=0;
                    $igualesCab[$w]=0;
                }
                for ($i = 0; $i <= 40; $i++) {
                    if (isset($fulldatos["runners"]["data"][$inicio+$i]["idRunner"])) {
                        $rest = substr($fulldatos["runners"]["data"][$inicio+$i]["programNumber"], -1);
                        if ($rest=="A" || $rest=="B" ||  $rest=="C" ||  $rest=="D" ||  $rest=="E" ||  $rest=="F" ||  $rest=="X") {
                            $rest2 = substr($fulldatos["runners"]["data"][$inicio+$i]["programNumber"], 0, -1);
                            $igualesCab[$rest2]++;
                        } else {
                            $igualesCab[$fulldatos["runners"]["data"][$inicio+$i]["programNumber"]]++;
                        }
                        if ($fulldatos["runners"]["data"][$inicio+$i]["scratched"]===true) {
                            $xR=$fulldatos["runners"]["data"][$inicio+$i]["programNumber"];
                            $rest = substr($xR, -1);
                            if ($rest=="A" || $rest=="B" ||  $rest=="C" ||  $rest=="D" ||  $rest=="E" ||  $rest=="F" ||   $rest=="X") {
                                $rest = substr($xR, 0, -1);
                            } else {
                                $rest = $fulldatos["runners"]["data"][$inicio+$i]["programNumber"];
                            }
                            $igualesRet[$rest]++;
                        }
                        $programados=$fulldatos["runners"]["data"][$inicio+$i]["programNumber"];
                    } else {
                        break;
                    }
                }
                $h=0;
                for ($w = 1; $w <= $i; $w++) {
                    if ($igualesRet[$w]>0) {
                        if ($igualesRet[$w]==$igualesRet[$w]) {
                            $nRetirados[$h]=$w;
                            $h++;
                        }
                    }
                }
                $retirados=$h;
                $corren=$programados-$retirados;
            }
        }
    }
    return array($nHipodromo,$ncarrera,$fec,$hor,$status,$programados,$retirados,$nRetirados,$corren);
} function mtpCierreRacebets($p)
{
    date_default_timezone_set("America/Puerto_Rico");
    switch ($p) {  case "1": $url = 'https://www.racebets.com/ajax/events/calendar'; break;  case "2": $url = 'https://www.racebets.com/ajax/events/calendar/date/yesterday'; break;  case "3": $url = 'https://www.racebets.com/ajax/events/calendar/date/tomorrow'; break;  }
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $hoy=fechaactualbd();
    $y=0;
    $k=0;
    $nHipodro[$k]=0;
    $nCarrera[$k]=0;
    $xEstado[$k]=0;
    $xhora[$k]=0;
    $restan[$k]=0;
    for ($i = 0; $i <= 300; $i++) {
        if (isset($fulldatos[$i]["firstStart"])) {
            $postTime=$fulldatos[$i]["firstStart"];
            $ccarr[$y]=$fulldatos[$i]["races"];
            $nhipo[$y]=strtoupper($fulldatos[$i]["title"]);
            for ($s = 1; $s <= $ccarr[$y]; $s++) {
                $status=$fulldatos[$i]["relatedRaces"][$s-1]["raceStatus"];
                if ($status=="STR" || $status=="OPN") {
                    if (isset($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]) && $status=="OPN") {
                        $nHipodro[$k]=$nhipo[$y];
                        $nCarrera[$k]=$s-1;
                        $xEstado[$k]=$fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"];
                        $xTime=$fulldatos[$i]["relatedRaces"][$s-2]["postTime"];
                        $tiempo = new DateTime();
                        $tiempo->setTimestamp($xTime);
                        $xhora[$k]=$tiempo->format('H:i');
                        $tiempo = new DateTime();
                        $actual=$tiempo->getTimestamp();
                        $faltan=$xTime-$actual;
                        $restan[$k]=timestampToH($faltan);
                        if ($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="TMP") {
                            $nuevafecha1=0;
                        }
                        if ($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="FNL") {
                            $nuevafecha1=0;
                        }
                        if ($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="STR") {
                            $nuevafecha1=0;
                        }
                        $k++;
                        if ($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="OPN" || $fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="STR") {
                            break;
                        }
                    }
                    if (isset($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]) && $status!="TMP") {
                        $nHipodro[$k]=$nhipo[$y];
                        $nCarrera[$k]=$s;
                        $xEstado[$k]=$fulldatos[$i]["relatedRaces"][$s-1]["raceStatus"];
                        if ($fulldatos[$i]["relatedRaces"][$s-1]["postTime"]=="STR") {
                            $xTime=0;
                        } else {
                            $xTime=$fulldatos[$i]["relatedRaces"][$s-1]["postTime"];
                        }
                        $tiempo = new DateTime();
                        $tiempo->setTimestamp($xTime);
                        $xhora[$k]=$tiempo->format('H:i');
                        $tiempo = new DateTime();
                        $actual=$tiempo->getTimestamp();
                        $faltan=$xTime-$actual;
                        $restan[$k]=timestampToH($faltan);
                        if ($fulldatos[$i]["relatedRaces"][$s-1]["raceStatus"]=="STR") {
                            $nuevafecha=0;
                        }
                        $k++;
                        break;
                    }
                }
            }
            $y++;
        } else {
            break;
        }
    }
    return array($nHipodro,$nCarrera,$xEstado,$xhora,$restan);
} function mtpCierreRacebets2($p)
{
    date_default_timezone_set("America/Puerto_Rico");
    switch ($p) {  case "1": $url = 'https://www.racebets.com/ajax/events/calendar'; break;  case "2": $url = 'https://www.racebets.com/ajax/events/calendar/date/yesterday'; break;  case "3": $url = 'https://www.racebets.com/ajax/events/calendar/date/tomorrow'; break;  }
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $hoy=fechaactualbd();
    $y=0;
    $k=0;
    $nHipodro[$k]=0;
    $nCarrera[$k]=0;
    $xEstado[$k]=0;
    $xhora[$k]=0;
    $idCarrrera[$k]=0;
    for ($i = 0; $i <= 300; $i++) {
        if (isset($fulldatos[$i]["firstStart"])) {
            $postTime=$fulldatos[$i]["firstStart"];
            $fecha = new DateTime();
            $fecha->setTimestamp($postTime);
            $fech=$fecha->format('Y-m-d');
            $ccarr[$y]=$fulldatos[$i]["races"];
            $nhipo[$y]=strtoupper($fulldatos[$i]["title"]);
            for ($s = 1; $s <= $ccarr[$y]; $s++) {
                $status=$fulldatos[$i]["relatedRaces"][$s-1]["raceStatus"];
                if ($status=="STR" || $status=="OPN") {
                    if (isset($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]) && $status=="OPN") {
                        $nHipodro[$k]=$nhipo[$y];
                        $nCarrera[$k]=$s-1;
                        $xEstado[$k]=$fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"];
                        $idCarrrera[$k]=$fulldatos[$i]["relatedRaces"][$s-2]["idRace"];
                        $xTime=$fulldatos[$i]["relatedRaces"][$s-2]["postTime"];
                        $tiempo = new DateTime();
                        $tiempo->setTimestamp($xTime);
                        $xhora[$k]=$tiempo->format('H:i');
                        $tiempo = new DateTime();
                        $actual=$tiempo->getTimestamp();
                        $faltan=$xTime-$actual;
                        $restan[$k]=timestampToH($faltan);
                        if ($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="TMP") {
                            $nuevafecha1=0;
                        }
                        if ($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="FNL") {
                            $nuevafecha1=0;
                        }
                        if ($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="STR") {
                            $nuevafecha1=0;
                        }
                        $k++;
                        if ($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="OPN" || $fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]=="STR") {
                            break;
                        }
                    }
                    if (isset($fulldatos[$i]["relatedRaces"][$s-2]["raceStatus"]) && $status!="TMP") {
                        $nHipodro[$k]=$nhipo[$y];
                        $nCarrera[$k]=$s;
                        $xEstado[$k]=$fulldatos[$i]["relatedRaces"][$s-1]["raceStatus"];
                        $idCarrrera[$k]=$fulldatos[$i]["relatedRaces"][$s-1]["idRace"];
                        if ($fulldatos[$i]["relatedRaces"][$s-1]["postTime"]=="STR") {
                            $xTime=0;
                        } else {
                            $xTime=$fulldatos[$i]["relatedRaces"][$s-1]["postTime"];
                        }
                        $tiempo = new DateTime();
                        $tiempo->setTimestamp($xTime);
                        $xhora[$k]=$tiempo->format('H:i');
                        $tiempo = new DateTime();
                        $actual=$tiempo->getTimestamp();
                        $faltan=$xTime-$actual;
                        $restan[$k]=timestampToH($faltan);
                        if ($fulldatos[$i]["relatedRaces"][$s-1]["raceStatus"]=="STR") {
                            $nuevafecha=0;
                        }
                        $k++;
                        break;
                    }
                }
            }
            $y++;
        } else {
            break;
        }
    }
    return array($idCarrrera,$nHipodro,$nCarrera,$xEstado,$xhora,$restan);
}
function mtpCierreBuildaBet2($p)
{
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    switch ($p) {
        case "1": $url = 'https://bab2ghc.usofftrack.com/data/ProgramList.json?ScanDate='.$hoy.'&lsa='; break;
        case "2": $url = 'https://www.racebets.com/ajax/events/calendar/date/yesterday'; break;
        case "3": $url = 'https://www.racebets.com/ajax/events/calendar/date/tomorrow'; break;
    }
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $g=0;
    $nHipodro[$g]=0;
    $nCarrera[$g]=0;
    $xEstado[$g]=0;
    $xhora[$g]=0;
    $idCarrrera[$g]=0;
    $restan[$g]=0;
    if (isset($fulldatos["Result"])) {
        foreach ($fulldatos["Result"]["progs"] as $da) {
            $horaInicial=strftime("%H:%M");
            $minutoAnadir=$fulldatos["Result"]["progs"][$g]["MTP"];
            $segundos_horaInicial=strtotime($horaInicial);
            $segundos_minutoAnadir=$minutoAnadir*60;
            
            
            if ($fulldatos["Result"]["progs"][$g]["HighestRace"]==$fulldatos["Result"]["progs"][$g]["CurrentRace"]) {
                $idCarrrera[$g]=$fulldatos["Result"]["progs"][$g]["LastRaceID"];
            } else {
                $idCarrrera[$g]=$fulldatos["Result"]["progs"][$g]["RaceID"];
            }
            
            $nHipodro[$g]=$fulldatos["Result"]["progs"][$g]["ProgramName"];
            $nCarrera[$g]=$fulldatos["Result"]["progs"][$g]["CurrentRace"];
            $xEstado[$g]=$fulldatos["Result"]["progs"][$g]["RaceStatus"];
            $xhora[$g]=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
            $restan[$g]=$fulldatos["Result"]["progs"][$g]["MTP"];
            $g++;
        }
    }
    return array($idCarrrera,$nHipodro,$nCarrera,$xEstado,$xhora,$restan);
}
function twinspires($p)
{
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    switch ($p) {
        case "1": $url = 'http://www.twinspires.com/php/fw/php_BRIS_BatchAPI/2.3/Tote/CurrentRace?ip=71.212.122.168&affid=2800&debug=off&username=my_sports&cDate=20150817&password=Gltbatm&output=json'; break;
        case "2": $url = 'https://www.racebets.com/ajax/events/calendar/date/yesterday'; break;
        case "3": $url = 'https://www.racebets.com/ajax/events/calendar/date/tomorrow'; break;
    }
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $g=0;
    $nHipodro[$g]=0;
    $nCarrera[$g]=0;
    $nstatus[$g]=0;
    $xhora[$g]=0;
    $restan[$g]=0;
    $TrackCanceled[$g]=0;
    if (isset($fulldatos["CurrentRace"])) {
        foreach ($fulldatos["CurrentRace"] as $da) {
            $horaInicial=strftime("%H:%M");
            $minutoAnadir=$fulldatos["CurrentRace"][$g]["Mtp"];
            $segundos_horaInicial=strtotime($horaInicial);
            $segundos_minutoAnadir=$minutoAnadir*60;
            
            
            if ($fulldatos["CurrentRace"][$g]["HighestRace"]==$fulldatos["CurrentRace"][$g]["RaceNum"]) {
                $idCarrrera[$g]=$fulldatos["CurrentRace"][$g]["LastRaceID"];
            } else {
                $idCarrrera[$g]=$fulldatos["CurrentRace"][$g]["RaceID"];
            }
            
            $nHipodro[$g]=$fulldatos["CurrentRace"][$g]["DisplayName"];
            $nCarrera[$g]=$fulldatos["CurrentRace"][$g]["RaceNum"];
            $nstatus[$g]=$fulldatos["CurrentRace"][$g]["Status"];
            $xhora[$g]=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
            $restan[$g]=$fulldatos["CurrentRace"][$g]["Mtp"];
            $TrackCanceled[$g]=$fulldatos["CurrentRace"][$g]["TrackCanceled"];
            $g++;
        }
    }
    return array($nHipodro,$nCarrera,$nstatus,$xhora,$restan,$TrackCanceled);
}
function programar_carreras_tvg()
{
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    $url = 'https://www.tvg.com/ajax/track/wp/PORT-Generic';
    $str_datos = get_url_contents($url);
    $nHi[0]="";
    $dTN[0]="";
    $cCa[0]="";
    $abb[0]="";
    $hIn[0]="";
    $tip[0]="";
    $cHi[0]="";
    $cod_hipodromo[0]="";
    $y=0;
    $datos = json_decode($str_datos, true);
    if (is_array($datos)) {
        for ($i = 0; $i <= 400; $i++) {
            $actual=current($datos);
            if ($actual["Name"]!="") {
                $n=strtoupper($actual["Abbreviation"]);
                $hi=busHipodromo($n);
                if ($hi[0]==1) {
                    $nHi[$y]=strtoupper($actual["Name"]);
                    $dTN[$y]=$actual["PerfAbbr"];
                    $cCa[$y]=$actual["RaceCount"];
                    $abb[$y]=$actual["Abbreviation"];
                    $tip[$y]=$actual["TrackStatusID"];
                    $cHi[$y]=$hi[1];
                    $cod_hipodromo[$y]=$hi[1];
                    $hIn[$y]="01:00:00";
                    $y++;
                }
            } else {
                break;
            }
            next($datos);
        }
    }
    return array($nHi, $dTN, $abb, $cCa, $hIn, $tip, $cHi, $cod_hipodromo);
}

function RacebetHoraPartida($id, $carr)
{
    date_default_timezone_set("America/Puerto_Rico");
    $hoy=fechaactualbd();
    $url = 'https://ajax.racebets.com/ajax/races/details/id/'.$id.'/version/detailed/';
    $str_datos = get_url_contents($url);
    $fulldatos = json_decode($str_datos, true);
    $offHora=0;
    if (isset($fulldatos["timestamp"])) {
        $nHipodromo=$fulldatos["event"]["title"];
        $ncarrera=$fulldatos["race"]["raceNumber"];
        if (isset($fulldatos["race"]["raceNumber"]) && $carr==$fulldatos["race"]["raceNumber"]) {
            $fecha = new DateTime();
            $postTime=$fulldatos["timestamp"];
            $fecha->setTimestamp($postTime);
            $fec=$fecha->format('Y-m-d');
            $offHora=0;
            if ($fec==$hoy) {
                $offHora = new DateTime();
                $offTime=$fulldatos["race"]["offTime"];
                if ($fulldatos["race"]["offTime"]==0) {
                    $offHora=0;
                } else {
                    $offTime=$fulldatos["race"]["offTime"];
                    $offHora->setTimestamp($offTime);
                    $offHora=$offHora->format('h:i:s');
                }
            } else {
                $offHora=1;
            } // "Fecha no corresponde a la actual"
        }
    }
    return $offHora;
}
//--------------------------------------------------------------------------------------------------
function detect()
{
    $browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
    $os=array("WIN","MAC","LINUX");
    $info['browser'] = "OTHER";
    $info['os'] = "OTHER";
    foreach ($browser as $parent) {
        $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
        $f = $s + strlen($parent);
        $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
        $version = preg_replace('/[^0-9,.]/', '', $version);
        if ($s) {
            $info['browser'] = $parent;
            $info['version'] = $version;
        }
    }
    foreach ($os as $val) {
        if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $val)!==false) {
            $info['os'] = $val;
        }
    }
    return $info;
}
//------------------------------------------------------NACIONALES-----------------------------------------------------------
//------------------------------------------------------NACIONALES-----------------------------------------------------------
//------------------------------------------------------NACIONALES-----------------------------------------------------------
//------------------------------------------------------NACIONALES-----------------------------------------------------------
function pNacMaqAzul($dia)
{
    switch ($dia) {
    case "1": $dnom="LUNES"; break; case "2": $dnom="MARTES"; break; case "3": $dnom="MIERCOLES"; break;
    case "4": $dnom="JUEVES"; break; case "5": $dnom="VIERNES"; break; case "6": $dnom="SABADO"; break;
    case "0": $dnom="DOMINGO"; break;
    }
    $url = 'http://www.maquinaazul.com.ve/programacionact.php?dia='.$dnom;
    $existe=1;
    $NumEjem[0][0]=0;
    $ejeCarr[0][0]=0;
    $jinCarr[0][0]=0;
    $enCarre[0]=0;
    $distancia[0]=0;
    $hora[0]=0;
    $cantCarreras=0;
    $p=0;
    $nomHip="";
    if ($existe==1) {
        $html = file_get_html($url);
        $c=0;
        $acceso=0;
        foreach ($html->find('table') as $article) {
            foreach ($article->find("text") as $article2) {
                if (trim($article2)!="") {
                    $resultado0 = strpos($article2, "Hip");
                    if ($resultado0 !== false) {
                        $c=0;
                        if ($p==0) {
                            $r1 = strpos($article2, "RANCHO ALEGRE");
                            $r2 = strpos($article2, "SANTA RITA");
                            $r3 = strpos($article2, "VALENCIA");
                            $r4 = strpos($article2, "LA RINCONADA");
                            if ($r1 !== false) {
                                $nomHip="RANCHO ALEGRE";
                            } elseif ($r2 !== false) {
                                $nomHip="SANTA RITA";
                            } elseif ($r3 !== false) {
                                $nomHip="VALENCIA";
                            } elseif ($r4 !== false) {
                                $nomHip="LA RINCONADA";
                            }
                            $p++;
                        }
                    }
                    $datos[$c]=trim($article2);
                    $c++;
                }
            }
        }
        $acc=1;
        $resultado5 = strpos($datos[5], "NO DISPONIBLE");
        if ($resultado5 !== false) {
            $acc=0;
        }
        if ($acc==1) {
            $c=0;
            $d=0;
            $e=0;
            $f=0;
            $dx=explode(" ", $datos[2]);
            $cantCarreras=$dx[3];
            $acceso=0;
            foreach ($datos as $pr) {
                $resultado1 = strpos($pr, "Carrera:");
                $resultado2 = strpos($pr, "Distancia:");
                $resultado3 = strpos($pr, "JINETE");
                $resultado4 = strpos($pr, "Retirado");
                if ($resultado1 !== false) {
                    $d++;
                }
                if ($resultado2 !== false) {
                    $distancia[$d]=$datos[$c+1];
                    $distancia[$d]=str_replace("mts", "", $distancia[$d]);
                    $hora[$d]=$datos[$c+3];
                }
                if ($resultado3 !== false && $acceso==0) {
                    $acceso=1;
                }
                if ($resultado4 !== false) {
                    $acceso=0;
                }
                if ($acceso==1) {
                    if (($e % 3) == 0) {
                        if ($datos[$c+1]!="Retirado") {
                            $NumEjem[$d][$f]=$datos[$c+1];
                            $ejeCarr[$d][$f]=$datos[$c+2];
                            $jinCarr[$d][$f]=$datos[$c+3];
                            $f++;
                            $enCarre[$d]=$f;
                        }
                    }
                    $e++;
                }
                if ($acceso==0) {
                    $e=0;
                    $f=0;
                }
                $c++;
                if ($d>$cantCarreras) {
                    break;
                }
            }
        }
    } // FIN SI EXISTE LA PAGINA

    return array($nomHip, $cantCarreras, $hora, $distancia, $NumEjem, $ejeCarr, $jinCarr, $enCarre);
}
function hipodromoNac($busca)
{
    $hipodromo[0]="";
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 72 */ SELECT cod_hipodromo_hnac, nom_hipodromo_hnac 
	FROM hipodromo_hnac
	WHERE nom_hipodromo_hnac = %s",
        GetSQLValueString($busca, "text")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $hipodromo[0]=$row_Recordset1['cod_hipodromo_hnac'];
    $hipodromo[1]=$row_Recordset1['nom_hipodromo_hnac'];
    mysqli_free_result($Recordset1);
    return $hipodromo;
}
function buscaHip_hnac($identificador)
{
    $identificador=strtoupper($identificador);
    $total=0;
    global $conexionbanca;
    $query_ConsultaFuncion = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 73 */ SELECT nom_hipodromo_hnac FROM hipodromo_hnac  WHERE nom_hipodromo_hnac = %s LIMIT 1", GetSQLValueString($identificador, "text"));
    $ConsultaFuncion = mysqli_query($conexionbanca, $query_ConsultaFuncion) or die(mysqli_error($conexionbanca));
    $row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
    $totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
    $total=$totalRows_ConsultaFuncion;
    mysqli_free_result($ConsultaFuncion);
    return $total;
}
function cantRetirados_hnac($codCarrera)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 74 */ SELECT inscritos.cod_carrera_hnac FROM inscritos 
		WHERE 
		inscritos.cod_carrera_hnac = %s AND
		inscritos.est_inscrito_hnac != 1",
        GetSQLValueString($codCarrera, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $total=$totalRows_Recordset1;
    mysqli_free_result($Recordset1);
    return $total;
}
function RetiradosSimple_hnac($codcarrera, $ejemplar)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 75 */ SELECT est_inscrito_hnac, cod_inscrito_hnac FROM inscritos 
			WHERE cod_carrera_hnac = %s AND num_caballo_hnac = %s LIMIT 1",
        GetSQLValueString($codcarrera, "int"),
        GetSQLValueString($ejemplar, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($row_Recordset1['est_inscrito_hnac']==0) {
        $estado=1;
    } else {
        $estado=0;
    }
    $cod=$row_Recordset1['cod_inscrito_hnac'];
    mysqli_free_result($Recordset1);
    return array($estado, $cod);
}
function verRetirados_hnac($codcarrera)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 76 */ SELECT num_caballo_hnac, nom_caballo_hnac FROM inscritos 
			WHERE cod_carrera_hnac = %s AND est_inscrito_hnac = 0",
        GetSQLValueString($codcarrera, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        do {
            echo '&nbsp;<font color="RED">'.$row_Recordset1['num_caballo_hnac']."-";
            echo $row_Recordset1['nom_caballo_hnac'].'</font><BR/>';
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    } else {
        echo '&nbsp;<font color="GREEN">&nbsp;NINGUNO&nbsp;</font>';
    }
    mysqli_free_result($Recordset1);
    return;
}
function arrayRetiradosHNAC($carrera)
{
    global $conexionbanca;
    $reti[0]="";
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 77 */ SELECT inscritos.num_caballo_hnac 
		FROM 
			inscritos 
		WHERE 
			inscritos.cod_carrera_hnac = %s AND
			inscritos.est_inscrito_hnac = 0",
        GetSQLValueString($carrera, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $s=0;
    if ($totalRows_Recordset1>0) {
        do {
            $reti[$s]=$row_Recordset1['num_caballo_hnac'];
            $s++;
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    }
    mysqli_free_result($Recordset1);
    return $reti;
}
function buscaDivTaquilla($codCar, $fec, $codTaq, $tipVen, $lin)
{
    global $conexionbanca;
    $ejem="";
    $div="";
    $codResult="";
    $query_Recordset111 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 78 */ SELECT 
	resultados_hnac.num_caballo_hnac,
	resultados_hnac.div_pago_hnac,
	resultados_hnac.cod_resultado_hnac
	FROM 
		carrera_hnac,
		resultados_hnac
	WHERE
		resultados_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND
		carrera_hnac.fec_carrera_hnac = %s AND
		resultados_hnac.fec_resultado_hnac = carrera_hnac.fec_carrera_hnac AND
		resultados_hnac.cod_taquilla = %s AND
		resultados_hnac.cod_tventa_hnac = %s AND
		resultados_hnac.lin_dividendo = %s AND
		carrera_hnac.cod_carrera_hnac = %s 
	LIMIT 1",
        GetSQLValueString($fec, "date"),
        GetSQLValueString($codTaq, "int"),
        GetSQLValueString($tipVen, "int"),
        GetSQLValueString($lin, "int"),
        GetSQLValueString($codCar, "int")
    );
    $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
    $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
    $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
    if ($totalRows_Recordset111>0) {
        $ejem=$row_Recordset111['num_caballo_hnac'];
        $div=$row_Recordset111['div_pago_hnac'];
        $codResult=$row_Recordset111['cod_resultado_hnac'];
    }
    mysqli_free_result($Recordset111);
    return array($ejem, $div, $totalRows_Recordset111, $codResult);
}
function ObtenerNumeroJugada_hnac($identificador, $fechajugada)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 79 */ SELECT ticket_hnac FROM venta_hnac WHERE fec_venta_hnac = %s AND id_usuario = %s GROUP BY ticket_hnac", GetSQLValueString($fechajugada, "date"), GetSQLValueString($identificador, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $contador=str_pad($totalRows_Recordset1, 5, "0", STR_PAD_LEFT);
    mysqli_free_result($Recordset1);
    return $contador;
}
function ObtenerUltimaVenta_hnac()
{
    global $conexionbanca;
    $query_Recordset1 = "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 80 */ SELECT MAX(num_ticket_hnac) FROM venta_hnac";
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $numeroticket=((int)$row_Recordset1['MAX(num_ticket_hnac)'])+1;
    mysqli_free_result($Recordset1);
    return $numeroticket;
}
function favoritos_hnac($codcarrera, $ejemplar, $tipo)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 81 */ SELECT 
			inscritos.est_favorito_hnac,
			SUM(mon_venta_hnac) as monto
			FROM
				venta_hnac, 
				inscritos,
				carrera_hnac 
			WHERE 
				carrera_hnac.cod_carrera_hnac = %s AND
				venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND
				venta_hnac.num_caballo_hnac = inscritos.num_caballo_hnac AND
				venta_hnac.cod_tventa_hnac = %s AND
				venta_hnac.est_ticket_hnac = 1 AND
				inscritos.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND 
				inscritos.num_caballo_hnac = %s 
			LIMIT 1",
        GetSQLValueString($codcarrera, "int"),
        GetSQLValueString($tipo, "int"),
        GetSQLValueString($ejemplar, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $favor=$row_Recordset1['est_favorito_hnac'];
    $monto=$row_Recordset1['monto'];
    mysqli_free_result($Recordset1);
    return array($favor, $monto);
}
function MontodeEjempar($codTaq, $codCar, $numEje, $tipVen)
{
    global $conexionbanca;
    $monto=0;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 82 */ SELECT 
			ve.est_ticket_hnac,
			SUM(mon_venta_hnac) as monto
			FROM
				usuario us,
				taquilla ta,
				venta_hnac ve, 
				carrera_hnac ca 
			WHERE 
				ta.cod_taquilla = %s AND
				us.cod_taquilla = ta.cod_taquilla AND
				us.id_usuario = ve.id_usuario AND 
				ca.cod_carrera_hnac = %s AND
				ve.cod_carrera_hnac = ca.cod_carrera_hnac AND
				ve.cod_tventa_hnac = %s AND
				ve.est_ticket_hnac = 1 AND
				ve.num_caballo_hnac = %s",
        GetSQLValueString($codTaq, "int"),
        GetSQLValueString($codCar, "int"),
        GetSQLValueString($tipVen, "text"),
        GetSQLValueString($numEje, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $monto=$row_Recordset1['monto'];
    }
    mysqli_free_result($Recordset1);
    return $monto;
}
function MontoFijo($codTaq, $codCar, $numEje)
{
    //echo $codTaq." ".$codCar." ".$numEje;
    $mJu=0;
    $jMi=0;
    $jMa=0;
    global $conexionbanca;
    $monto=0;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 83 */ SELECT 
			pr.max_eje_hnac,
			pr.max_jug_hnac,
			pr.min_jug_hnac
			FROM
				carrera_hnac ca,
				inscritos ins,
				precio_fijo_hnac pr 
			WHERE 
				pr.cod_taquilla = %s AND
				ca.cod_carrera_hnac = %s AND
				ins.cod_carrera_hnac = ca.cod_carrera_hnac AND
				pr.cod_carrera_hnac = ca.cod_carrera_hnac AND
				pr.cod_inscrito_hnac = ins.cod_inscrito_hnac AND
				ins.num_caballo_hnac = %s",
        GetSQLValueString($codTaq, "int"),
        GetSQLValueString($codCar, "int"),
        GetSQLValueString($numEje, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $mJu=$row_Recordset1['max_eje_hnac'];
        $jMi=$row_Recordset1['min_jug_hnac'];
        $jMa=$row_Recordset1['max_jug_hnac'];
    }
    mysqli_free_result($Recordset1);
    return array($mJu,$jMi,$jMa);
}
function inscritos_hnac($codcarrera)
{
    global $conexionbanca;
    $query_Recordset = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 84 */ SELECT *
			FROM
				inscritos
			WHERE 
				cod_carrera_hnac = %s
			ORDER BY num_caballo_hnac",
        GetSQLValueString($codcarrera, "int")
    );
    $Recordset = mysqli_query($conexionbanca, $query_Recordset) or die(mysqli_error($conexionbanca));
    $row_Recordset = mysqli_fetch_assoc($Recordset);
    $totalRows_Recordset = mysqli_num_rows($Recordset);
    $k=0;
    do {
        $datEje[$k][0]=$row_Recordset['nom_caballo_hnac'];
        $datEje[$k][1]=$row_Recordset['est_inscrito_hnac'];
        $datEje[$k][2]=$row_Recordset['est_favorito_hnac'];
        $datEje[$k][3]=$row_Recordset['cod_inscrito_hnac'];
        $k++;
    } while ($row_Recordset = mysqli_fetch_assoc($Recordset));
    mysqli_free_result($Recordset1);
    return $datEje;
}

function venPorCabUsu($cod, $usu, $num, $hoy)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 85 */ SELECT 
		SUM(CASE WHEN cod_tventa_hnac = 1 THEN mon_venta_hnac ELSE 0 END) AS gan,		
		SUM(CASE WHEN cod_tventa_hnac = 2 THEN mon_venta_hnac ELSE 0 END) AS pla,		
		SUM(CASE WHEN cod_tventa_hnac = 3 THEN mon_venta_hnac ELSE 0 END) AS sho		
		FROM venta_hnac 
		WHERE 
		cod_carrera_hnac = %s AND
		num_caballo_hnac = %s AND
		id_usuario = %s AND
		fec_venta_hnac = %s AND
		est_ticket_hnac <> 0 AND
		cod_tventa_hnac > 0 AND cod_tventa_hnac < 4",
        GetSQLValueString($cod, "int"),
        GetSQLValueString($num, "text"),
        GetSQLValueString($usu, "int"),
        GetSQLValueString($hoy, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $gan=$row_Recordset1['gan'];
    $pla=$row_Recordset1['pla'];
    $mon=$pla+$gan;
    mysqli_free_result($Recordset1);
    return array($gan,$pla,$mon);
}

function compruebaCarr_hnac($cod, $num, $fec)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 86 */ SELECT cod_carrera_hnac FROM carrera_hnac 
		WHERE cod_hipodromo_hnac = %s AND num_carrera_hnac = %s AND fec_carrera_hnac = %s
		LIMIT 1", GetSQLValueString($cod, "int"), GetSQLValueString($num, "int"), GetSQLValueString($fec, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $total=$totalRows_Recordset1;
    mysqli_free_result($Recordset1);
    return $total;
}
function ObtenerMonTototalVentaHNAC($identificador)
{
    $identificador=(int)$identificador;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 87 */ SELECT mon_venta_hnac FROM venta_hnac WHERE venta_hnac.ticket_hnac = %s", $identificador, "int");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $montojugada=0;
    do {
        $montojugada=((int)$row_Recordset1['mon_venta_hnac'])+$montojugada;
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
    return $montojugada.".00";
}
function buscarSiTicketpremiado_hnac($xnroTicket)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 88 */ SELECT ve.est_ticket_hnac 
	FROM venta_hnac ve 
	WHERE ve.ticket_hnac = %s AND ve.est_ticket_hnac >=2 AND
	ve.est_ticket_hnac <=5", GetSQLValueString($xnroTicket, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $total=$totalRows_Recordset1;
    mysqli_free_result($Recordset1);
    return($total);
}
function enCarrera_HNAC($car)
{
    global $conexionbanca;
    $query_Recordset2 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 89 */ SELECT ic.est_inscrito_hnac FROM inscritos ic 
			WHERE ic.est_inscrito_hnac = 1 AND ic.cod_carrera_hnac = %s", GetSQLValueString($car, "int"));
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $tEjem = mysqli_num_rows($Recordset2);
    mysqli_free_result($Recordset2);
    return $tEjem;
}
function ctaRetTik_HNAC($retirados, $xnroTicket)
{
    $retiro=0;
    global $conexionbanca;
    $query_Recordset2 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 90 */ SELECT ve.num_caballo_hnac, ve.cod_tventa_hnac FROM venta_hnac ve
			WHERE ve.ticket_hnac = %s", GetSQLValueString($xnroTicket, "int"));
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $tEjem = mysqli_num_rows($Recordset2);
    if ($retirados[0]!="0") {
        do {
            if (in_array($row_Recordset2['num_caballo_hnac'], $retirados, true)) {
                $retiro++;
            }
        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
    }
    mysqli_free_result($Recordset2);
    return $retiro;
}
function retTicket_HNAC($retirados, $xnroTicket)
{
    $retiro=0;
    global $conexionbanca;
    $query_Recordset2 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 91 */ SELECT ve.num_caballo_hnac, ve.cod_tventa_hnac FROM venta_hnac ve
			WHERE ve.ticket_hnac = %s", GetSQLValueString($xnroTicket, "int"));
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $tEjem = mysqli_num_rows($Recordset2);
    if ($retirados[0]!="0") {
        do {
            if (in_array($row_Recordset2['num_caballo_hnac'], $retirados, true)) {
                $retiro=1;
            }
            if ((int)$row_Recordset2['cod_tventa_hnac']>=4 && (int)$row_Recordset2['cod_tventa_hnac']<=9) {
                $fcab=explode("-", $row_Recordset2['num_caballo_hnac']);
                foreach ($fcab as $mtz1) {
                    if (in_array($mtz1, $retirados, true)) {
                        $retiro=1;
                        break;
                    }
                }
            }
        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
    }
    mysqli_free_result($Recordset2);
    return $retiro;
}
function verificarPremio_hnac($xnroTicket, $uVenta)
{
    $montoapagar=0;
    $jugada="";
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 92 */ SELECT 
	hi.nom_hipodromo_hnac, 
	ca.num_carrera_hnac, 
	ca.est_cierre_hnac, 
	ca.cod_carrera_hnac,
	ca.est_confirmacion_hnac, 
	ca.cod_hipodromo_hnac, 
	ca.est_carrera_hnac, 
	ca.fec_carrera_hnac, 
	ta.cod_taquilla, 
	tp.cab_min_hnac, 
	tp.def_ran_regdiv_hnac, 
	tp.def_san_regdiv_hnac,
	tp.def_val_regdiv_hnac, 
	tp.def_rin_regdiv_hnac, 
	ve.est_ticket_hnac,
	ve.num_caballo_hnac, 
	ve.cod_tventa_hnac, 
	ve.mon_venta_hnac, 
	ve.num_ticket_hnac, 
	ve.ticket_hnac  
	FROM  
	venta_hnac ve, 
	carrera_hnac ca, 
	taquilla ta, 
	usuario us, 
	hipodromo_hnac hi, 
	taquilla_opc_hnac tp  
	WHERE 
	us.cod_taquilla = ta.cod_taquilla AND 
	us.id_usuario = ve.id_usuario AND 
	us.id_usuario = %s AND 
	ve.ticket_hnac = %s AND 
	ve.cod_carrera_hnac = ca.cod_carrera_hnac AND 
	hi.cod_hipodromo_hnac = ca.cod_hipodromo_hnac AND
	tp.cod_taquilla = ta.cod_taquilla",
        GetSQLValueString($uVenta, "int"),
        GetSQLValueString($xnroTicket, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $carrera=$row_Recordset1['nom_hipodromo_hnac']." Carr: ...".$row_Recordset1['num_carrera_hnac']."&nbsp;";
    $cabMin=$row_Recordset1['cab_min_hnac'];
    $tEjem=enCarrera_HNAC($row_Recordset1['cod_carrera_hnac']);//ejemplares en carrera
    $retirados=arrayRetiradosHNAC($row_Recordset1['cod_carrera_hnac']);
    $rT=ctaRetTik_HNAC($retirados, $xnroTicket);
    if (($totalRows_Recordset1>0 && $row_Recordset1['est_carrera_hnac']==0 && $row_Recordset1['est_cierre_hnac']==1 &&
        $row_Recordset1['est_ticket_hnac']==1 && $tEjem>=$cabMin) || $rT>=1) {
        $montoapagar=0;
        $montoretiro=0;
        $i=0;
        $estado=array(0);
        $_nTicket=array(0);
        do {
            $tV=$row_Recordset1['num_caballo_hnac']."-".ObtenerNombreApuesta2($row_Recordset1['cod_tventa_hnac']);
            $jugada=$jugada."&nbsp;|N:".$tV." ".$row_Recordset1['mon_venta_hnac'];
            $pago=0;
            $retiro=0;
            if ($retirados[0]!="0") {
                if (in_array($row_Recordset1['num_caballo_hnac'], $retirados, true)) {
                    $retiro=1;
                }
                if ((int)$row_Recordset1['cod_tventa_hnac']>=4 && (int)$row_Recordset1['cod_tventa_hnac']<=9) {
                    $fcab=explode("-", $row_Recordset1['num_caballo_hnac']);
                    foreach ($fcab as $mtz1) {
                        if (in_array($mtz1, $retirados, true)) {
                            $retiro=1;
                            break;
                        }
                    }
                }
            }
            if ($retiro==0) {
                $pago=0;
                if ($row_Recordset1['cod_tventa_hnac']>=1 && $row_Recordset1['cod_tventa_hnac']<=3) {
                    if ($row_Recordset1['cod_hipodromo_hnac']==1) {
                        $defi_regla=$row_Recordset1['def_ran_regdiv_hnac'];
                    }//ran
                    if ($row_Recordset1['cod_hipodromo_hnac']==2) {
                        $defi_regla=$row_Recordset1['def_san_regdiv_hnac'];
                    }//san
                    if ($row_Recordset1['cod_hipodromo_hnac']==3) {
                        $defi_regla=$row_Recordset1['def_val_regdiv_hnac'];
                    }//val
                    if ($row_Recordset1['cod_hipodromo_hnac']==4) {
                        $defi_regla=$row_Recordset1['def_rin_regdiv_hnac'];
                    }//rin
                    if ($defi_regla==0) {
                        $query_Recordset2 = sprintf(
                            "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 93 */ SELECT re.div_pago_hnac
							FROM resultados_hnac re, inscritos ic
							WHERE
							re.cod_carrera_hnac = ic.cod_carrera_hnac AND re.num_caballo_hnac = ic.num_caballo_hnac AND
							re.num_caballo_hnac = %s AND re.cod_carrera_hnac = %s AND re.fec_resultado_hnac = %s AND
							re.cod_taquilla = %s AND re.cod_tventa_hnac = %s",
                            GetSQLValueString($row_Recordset1['num_caballo_hnac'], "text"),
                            GetSQLValueString($row_Recordset1['cod_carrera_hnac'], "int"),
                            GetSQLValueString($row_Recordset1['fec_carrera_hnac'], "date"),
                            GetSQLValueString($row_Recordset1['cod_taquilla'], "int"),
                            GetSQLValueString($row_Recordset1['cod_tventa_hnac'], "int")
                        );
                    } else {
                        $query_Recordset2 = sprintf(
                            "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 94 */ SELECT re.div_pago_hnac, ic.est_favorito_hnac 
							FROM resultados_oficiales_hnac re, inscritos ic
							WHERE
							re.cod_carrera_hnac = ic.cod_carrera_hnac AND re.num_caballo_hnac = ic.num_caballo_hnac AND
							re.num_caballo_hnac = %s AND re.cod_carrera_hnac = %s AND re.fec_resultado_hnac = %s AND
							re.cod_tventa_hnac = %s",
                            GetSQLValueString($row_Recordset1['num_caballo_hnac'], "text"),
                            GetSQLValueString($row_Recordset1['cod_carrera_hnac'], "int"),
                            GetSQLValueString($row_Recordset1['fec_carrera_hnac'], "date"),
                            GetSQLValueString($row_Recordset1['cod_tventa_hnac'], "int")
                        );
                    }
                    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
                    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
                    $montoapagar=$montoapagar+$totalRows_Recordset2;
                    mysqli_free_result($Recordset2);
                }
            } else {
                $montoretiro=$montoretiro+$row_Recordset1['mon_venta_hnac'];
            }
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        $montoapagar=$montoapagar+$montoretiro;
    } else {
        $montoapagar=0;
        if (($totalRows_Recordset1>0 && $row_Recordset1['est_carrera_hnac']==0 && $row_Recordset1['est_cierre_hnac']==0 &&
            $row_Recordset1['est_ticket_hnac']==1) || ($totalRows_Recordset1>0 && $tEjem<$cabMin &&
            $row_Recordset1['est_ticket_hnac']==1)) {
            $jugada='';
            do {
                $tV=$row_Recordset1['num_caballo_hnac']."-".ObtenerNombreApuesta2($row_Recordset1['cod_tventa_hnac']);
                $jugada=$jugada."&nbsp;|N:".$tV." ".$row_Recordset1['mon_venta_hnac'];
                $montoapagar=$montoapagar+$row_Recordset1['mon_venta_hnac'];
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        }
    }
    $jugada=$carrera."<font size=2>$jugada</font>";
    mysqli_free_result($Recordset1);
    return array($montoapagar, $jugada, $rT, $cabMin, $tEjem);
}
function buscaDivOficiales($codCar, $fec, $tipVen, $lin)
{
    global $conexionbanca;
    $ejem=0;
    $div=0;
    $codR=-1;
    $fac=0;
    $query_Recordset111 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 95 */ SELECT num_caballo_hnac, div_pago_hnac, cod_resultado_hnac, fac_div_hnac
	FROM  resultados_oficiales_hnac
	WHERE fec_resultado_hnac = %s AND cod_carrera_hnac = %s AND cod_tventa_hnac = %s AND lin_dividendo = %s
	LIMIT 1",
        GetSQLValueString($fec, "date"),
        GetSQLValueString($codCar, "int"),
        GetSQLValueString($tipVen, "text"),
        GetSQLValueString($lin, "int")
    );
    $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
    $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
    $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
    $to=$totalRows_Recordset111;
    if ($totalRows_Recordset111>0) {
        $ejem=$row_Recordset111['num_caballo_hnac'];
        $div=$row_Recordset111['div_pago_hnac'];
        $codR=$row_Recordset111['cod_resultado_hnac'];
        $fac=$row_Recordset111['fac_div_hnac'];
    }
    mysqli_free_result($Recordset111);
    return array($ejem, $div, $to, $codR, $fac);
}
function buscaDivOficialesSimple($codCar, $fec, $hasta)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 96 */ SELECT num_caballo_hnac
	FROM  resultados_oficiales_hnac
	WHERE 
		fec_resultado_hnac = %s AND 
		cod_carrera_hnac = %s AND 
		cod_tventa_hnac >= 1 AND 
		cod_tventa_hnac <= %s",
        GetSQLValueString($fec, "date"),
        GetSQLValueString($codCar, "int"),
        GetSQLValueString($hasta, "text")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $x=0;
    do {
        $ejem[$x]=$row_Recordset1['num_caballo_hnac'];
        $x++;
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
    return $ejem;
}
function BuscarTicketEliminadosHNAC($codusuario, $fechaactual)
{
    $totalRows_Recordset1=0;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 97 */ SELECT est_ticket_hnac  
		FROM venta_hnac 
		WHERE venta_hnac.est_ticket_hnac = 0 AND  venta_hnac.id_usuario = %s AND venta_hnac.fec_venta_hnac = %s 
		GROUP BY ticket_hnac", GetSQLValueString($codusuario, "int"), GetSQLValueString($fechaactual, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $total=$totalRows_Recordset1;
    mysqli_free_result($Recordset1);
    return $total;
}
function BuscarTicketVendidosHNAC($codigoTaquilla, $id_usuario, $in, $fi)
{
    $totalRows_Recordset1=0;
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 98 */ SELECT est_ticket_hnac  
		FROM 
			venta_hnac,
			taquilla,
			usuario,
			carrera_hnac 
		WHERE
			carrera_hnac.cod_carrera_hnac = venta_hnac.cod_carrera_hnac AND
			taquilla.cod_taquilla = usuario.cod_taquilla AND
			usuario.cod_taquilla = %s AND
			usuario.id_usuario = %s AND
			venta_hnac.id_usuario = usuario.id_usuario AND
			venta_hnac.est_ticket_hnac >= 1 AND
			venta_hnac.est_ticket_hnac <= 2 AND  
			(venta_hnac.fec_venta_hnac >= %s AND 
			venta_hnac.fec_venta_hnac <= %s) 
		GROUP BY venta_hnac.ticket_hnac
		ORDER BY venta_hnac.fec_venta_hnac",
        GetSQLValueString($codigoTaquilla, "int"),
        GetSQLValueString($id_usuario, "int"),
        GetSQLValueString($in, "date"),
        GetSQLValueString($fi, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $total=$totalRows_Recordset1;
    mysqli_free_result($Recordset1);
    return $total;
}
//------------------------------------------------------LOTERIA-------------------------------------------------------------



function agenciaTopeLot($banca, $agencia, $loteria, $con_tope)
{
    global $conexionbanca;
    $topeVenta=-1;
    if ($con_tope==0) {
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 99 */ SELECT top_ventaage FROM agencialoterias 
		WHERE id_agencia = %s AND id_loteria = %s LIMIT 1",
            GetSQLValueString($agencia, "int"),
            GetSQLValueString($loteria, "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        $topeVenta=$row_Recordset1['top_ventaage'];
    } elseif ($con_tope==1) {
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 100 */ SELECT top_venta FROM bancaloterias 
		WHERE id_banca = %s AND id_loteria = %s LIMIT 1",
            GetSQLValueString($banca, "int"),
            GetSQLValueString($loteria, "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        $topeVenta=$row_Recordset1['top_venta'];
    }
    if (isset($Recordset1)) {
        mysqli_free_result($Recordset1);
    }
    return $topeVenta;
}
function numMontoVendidoLot($agencia, $numero, $loteria, $sig, $hoy)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 101 */ SELECT 
		SUM(mon_apuesta_lot) as monto 
		FROM 
			venta_lot lo, taquilla ta, usuario us
		WHERE
			us.id_usuario = lo.id_usuario AND 
			ta.cod_taquilla = us.cod_taquilla AND 
			ta.cod_agencia = %s AND 
			lo.num_apuesta_lot = %s  AND 
			lo.id_loteria = %s AND 
			lo.fec_venta_lot = %s AND 
			lo.id_signo = %s AND 
			lo.est_ticket_lot = 1",
        GetSQLValueString($agencia, "int"),
        GetSQLValueString($numero, "text"),
        GetSQLValueString($loteria, "int"),
        GetSQLValueString($hoy, "date"),
        GetSQLValueString($sig, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $monto=$row_Recordset1['monto'];
    mysqli_free_result($Recordset1);
    return $monto;
}
function horaCierreSorteo($identificador, $banca)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 102 */ SELECT hor_cierre FROM bancaloterias bl WHERE 
	bl.id_loteria = %s AND bl.id_banca = %s LIMIT 1", GetSQLValueString($identificador, "int"), GetSQLValueString($banca, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $cierre=$row_Recordset1['hor_cierre'];
    mysqli_free_result($Recordset1);
    return $cierre;
}
function NumBloqueado($xTaq, $xAge, $xBan, $xNum, $xlot)
{
    global $conexionbanca;
    $resultado=0;
    $xhoy=fechaactualbd();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 103 */ SELECT 
		bl.num_bloqueado, id_sorteo, id_loteria, tip_rango, des_bloqueado, has_bloqueado, id_taquilla, id_agencia,
		(CASE bl.id_sorteo
			WHEN 0 THEN bl.id_sorteo
			ELSE (/* PARSEADORES1 negocio\includes\funciones.php - QUERY 104 */ SELECT id_sorteo FROM loterias lo WHERE lo.id_loteria = %s LIMIT 1)
		END) AS sorteo_loteria
	FROM bloqueadoloterias bl
	WHERE 
	(
	bl.id_banca = %s AND bl.num_bloqueado = %s AND 
	((bl.id_agencia=%s AND id_taquilla=%s) OR (bl.id_agencia=%s AND id_taquilla=0) OR (bl.id_agencia=0 AND bl.id_taquilla=0)) AND
	
	(bl.tip_rango=1 OR (bl.tip_rango=2 AND bl.des_bloqueado<=%s AND bl.has_bloqueado>=%s)) AND
	
	((bl.id_sorteo>=0 AND bl.id_loteria=0) OR (bl.id_sorteo=0 AND bl.id_loteria=%s))
	)",
        GetSQLValueString($xlot, "int"),
        GetSQLValueString($xBan, "int"),
        GetSQLValueString($xNum, "text"),
        GetSQLValueString($xAge, "int"),
        GetSQLValueString($xTaq, "int"),
        GetSQLValueString($xAge, "int"),
        GetSQLValueString($xhoy, "date"),
        GetSQLValueString($xhoy, "date"),
        GetSQLValueString($xlot, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        if ($row_Recordset1['id_sorteo']==$row_Recordset1['sorteo_loteria']) {
            $resultado=1;
        }
    }
    //echo $totalRows_Recordset1." sorteo_loteria:".$row_Recordset1['sorteo_loteria'];
    //echo "<br/>";
    //echo "sorteo: ".$row_Recordset1['id_sorteo'];
    return $resultado;
}
function ObtenerNombreLoteria($identificador)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 105 */ SELECT nom_loteria FROM loterias 
	WHERE loterias.id_loteria = %s LIMIT 1", GetSQLValueString($identificador, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $nombreloteria=$row_Recordset1['nom_loteria'];
    mysqli_free_result($Recordset1);
    return $nombreloteria;
}
function ObtenerTipoLoteria($identificador)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 106 */ SELECT tip_loteria FROM loterias 
	WHERE id_loteria = %s LIMIT 1", GetSQLValueString($identificador, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $tip_loteria=$row_Recordset1['tip_loteria'];
    mysqli_free_result($Recordset1);
    return $tip_loteria;
}
function ObtenerNombreSigno($identificador)
{
    $nombresigno="";
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 107 */ SELECT nom_corto FROM signos 
	WHERE signos.id_signo = %s LIMIT 1", GetSQLValueString($identificador, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $nombresigno=$row_Recordset1['nom_corto'];
    mysqli_free_result($Recordset1);
    return $nombresigno;
}
function ObtenerNombreAnimal($id)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 108 */ SELECT nom_animal, num_animal FROM animales 
	WHERE num_animal = %s LIMIT 1", GetSQLValueString($id, "text"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $nom_animal=$row_Recordset1['nom_animal'];
    $num_animal=$row_Recordset1['num_animal'];
    mysqli_free_result($Recordset1);
    return array($nom_animal, $num_animal);
}
function ObtenerNombreFruta($id)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 109 */ SELECT nom_fruta, num_fruta FROM frutas 
	WHERE num_fruta = %s LIMIT 1", GetSQLValueString($id, "text"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $nom_fruta=$row_Recordset1['nom_fruta'];
    $num_fruta=$row_Recordset1['num_fruta'];
    mysqli_free_result($Recordset1);
    return  array($nom_fruta, $num_fruta);
}
function ObtenerTerminalLoteria($identificador)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 110 */ SELECT id_terminal FROM loterias 
	WHERE loterias.id_loteria = %s LIMIT 1", GetSQLValueString($identificador, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $codTerminal=$row_Recordset1['id_terminal'];
    mysqli_free_result($Recordset1);
    return $codTerminal;
}
function ObtenerTripledeTerminal($identificador)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 111 */ SELECT id_triple FROM loterias WHERE id_loteria = %s LIMIT 1", $identificador, "int");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $codTriple=$row_Recordset1['id_triple'];
    mysqli_free_result($Recordset1);
    return $codTriple;
}
function ultimaVentaLot()
{
    global $conexionbanca;
    $query_Recordset1 = "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 112 */ SELECT num_ticket_lot FROM venta_lot ORDER BY num_ticket_lot DESC LIMIT 1";
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $numeroticket=((int)$row_Recordset1['num_ticket_lot'])+1;
    mysqli_free_result($Recordset1);
    return $numeroticket;
}
function tipoLoterias($identificador)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 113 */ SELECT tip_loteria FROM loterias WHERE id_loteria = %s LIMIT 1", $identificador, "int");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $tiploteria=$row_Recordset1['tip_loteria'];
    mysqli_free_result($Recordset1);
    return $tiploteria;
}
function NombreSigno2($identificador)
{
    $nombresigno="";
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 114 */ SELECT nom_corto FROM signos WHERE id_signo = %s LIMIT 1", $identificador, "int");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $nombresigno="-".$row_Recordset1['nom_corto'];
    }
    mysqli_free_result($Recordset1);
    return $nombresigno;
}
function ObtenerNumeroJugada_lot($identificador, $fechajugada, $modulo)
{
    global $conexionbanca;
    if ($modulo==1) {
        $tipVentaD=1;
        $tipVentaH=3;
    } else {
        $tipVentaD=4;
        $tipVentaH=6;
    }
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 115 */ SELECT ticket_lot FROM venta_lot WHERE fec_venta_lot = %s AND id_usuario = %s AND 
		tip_loteria_lot >= %s AND tip_loteria_lot <= %s
	GROUP BY ticket_lot",
        GetSQLValueString($fechajugada, "date"),
        GetSQLValueString($identificador, "int"),
        GetSQLValueString($tipVentaD, "int"),
        GetSQLValueString($tipVentaH, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $contador=str_pad($totalRows_Recordset1, 5, "0", STR_PAD_LEFT);
    mysqli_free_result($Recordset1);
    return $contador;
}
function BuscarTicketEliminadosLOT($codusuario, $fechaactual)
{
    $totalRows_Recordset1=0;
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 116 */ SELECT est_ticket_lot  
		FROM venta_lot ve 
		WHERE ve.est_ticket_lot = 0 AND  ve.id_usuario = %s AND ve.fec_venta_lot = %s 
		GROUP BY ticket_lot", GetSQLValueString($codusuario, "int"), GetSQLValueString($fechaactual, "date"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $total=$totalRows_Recordset1;
    mysqli_free_result($Recordset1);
    return $total;
}
function ObtenerNombreCarta($id)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 117 */ SELECT nom_palo FROM palos_cartas 
	WHERE id_palo = %s LIMIT 1", GetSQLValueString($id, "text"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $nom_palo=$row_Recordset1['nom_palo'];
    mysqli_free_result($Recordset1);
    return $nom_palo;
}
//**********************************************MACUARE********************************************
//**********************************************MACUARE********************************************
//**********************************************MACUARE********************************************
//**********************************************MACUARE********************************************
function ObtenerNumeroJugada_macu($identificador, $fechajugada, $xtipo)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf("/* PARSEADORES1 negocio\includes\funciones.php - QUERY 118 */ SELECT ticket_macu FROM venta_macu WHERE fec_venta_macu = %s AND id_usuario = %s GROUP BY ticket_macu", GetSQLValueString($fechajugada, "date"), GetSQLValueString($identificador, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $contador=str_pad($totalRows_Recordset1, 5, "0", STR_PAD_LEFT);
    mysqli_free_result($Recordset1);
    return $contador;
}
function RetiradosSimple_macu($codcarrera, $ejemplar)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 119 */ SELECT est_inscrito_hnac, cod_inscrito_hnac FROM inscritos 
			WHERE cod_carrera_hnac = %s AND num_caballo_hnac = %s LIMIT 1",
        GetSQLValueString($codcarrera, "int"),
        GetSQLValueString($ejemplar, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $estado=-1;
    if ($totalRows_Recordset1>0) {
        if ($row_Recordset1['est_inscrito_hnac']==0) {
            $estado=1;
        } else {
            $estado=0;
        }
    }
    $cod=$row_Recordset1['cod_inscrito_hnac'];
    mysqli_free_result($Recordset1);
    return array($estado, $cod);
}
function verifica_carrera_hnac($codcarrera)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 120 */ SELECT est_cierre_hnac, num_carrera_hnac FROM carrera_hnac 
			WHERE cod_carrera_hnac = %s LIMIT 1",
        GetSQLValueString($codcarrera, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $estado=$row_Recordset1['est_cierre_hnac'];
    $numCa=$row_Recordset1['num_carrera_hnac'];
    mysqli_free_result($Recordset1);
    return array($estado,$numCa);
}
function ObtenerUltimaVenta_macu()
{
    global $conexionbanca;
    $query_Recordset1 = "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 121 */ SELECT num_ticket_macu FROM venta_macu ORDER BY num_ticket_macu DESC";
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $numeroticket=((int)$row_Recordset1['num_ticket_macu'])+1;
    mysqli_free_result($Recordset1);
    return $numeroticket;
}
function toTicIgual_macu($codTaq, $apta, $fecha, $codVen)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 122 */ SELECT ve.num_ticket_macu FROM venta_macu ve, usuario us, taquilla ta
	WHERE us.id_usuario = ve.id_usuario AND ta.cod_taquilla = %s AND us.cod_taquilla = ta.cod_taquilla AND
		ve.num_caballo_macu = %s AND ve.fec_venta_macu = %s AND cod_tventa_macu = %s AND est_ticket_macu = 1",
        GetSQLValueString($codTaq, "int"),
        GetSQLValueString($apta, "int"),
        GetSQLValueString($fecha, "date"),
        GetSQLValueString($codVen, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 negocio\includes\funciones.php - QUERY 123 */ SELECT  
	SUM(CASE WHEN ve.est_ticket_macu = 1 THEN ve.mon_venta_macu ELSE 0 END) AS tVendido
	FROM venta_macu ve, usuario us, taquilla ta
	WHERE us.id_usuario = ve.id_usuario AND ta.cod_taquilla = %s AND us.cod_taquilla = ta.cod_taquilla AND
		ve.num_caballo_macu = %s AND ve.fec_venta_macu = %s AND cod_tventa_macu = %s AND est_ticket_macu = 1",
        GetSQLValueString($codTaq, "int"),
        GetSQLValueString($apta, "int"),
        GetSQLValueString($fecha, "date"),
        GetSQLValueString($codVen, "int")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    $tApta=$totalRows_Recordset1;
    $tVendido=$row_Recordset2['tVendido'];
    mysqli_free_result($Recordset1);
    mysqli_free_result($Recordset2);
    return array($tApta, $tVendido);
}

<?php
require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$usuario=222;
$taquilla=111;
$ip_ventap=getRealIP();
$query_Recordset1 = "/* PARSEADORES1 new\parley\parleyregistrar.php - QUERY 1 */ SELECT MAX(Id_p4jugadas) FROM p4jugadas";
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$numeroticket=((int)$row_Recordset1['MAX(Id_p4jugadas)'])+1;
$serial=generarCodigo(5, $numeroticket);
// logrosCalc[1][logro]: -110
$montoApuesta=$_POST['montoApostar_mobil'];
$momontoPremio=$_POST['montoPremio_mobil'];


if (empty($_POST['logrosCalc'][0]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][0]['codigo'];
    $tipo=$_POST['logrosCalc'][0]['tipo'];
    $referencia=$_POST['logrosCalc'][0]['referencia'];
    $logro=$_POST['logrosCalc'][0]['logro'];
    $equipo=$_POST['logrosCalc'][0]['equipo'];
    $juego=$_POST['logrosCalc'][0]['juego'];
    $numero=$_POST['logrosCalc'][0]['numero'];
    $padre=$_POST['logrosCalc'][0]['padre'];
    $deporte=$_POST['logrosCalc'][0]['deporte'];
    $lineatp=1;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}
if (empty($_POST['logrosCalc'][1]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][1]['codigo'];
    $tipo=$_POST['logrosCalc'][1]['tipo'];
    $referencia=$_POST['logrosCalc'][1]['referencia'];
    $logro=$_POST['logrosCalc'][1]['logro'];
    $equipo=$_POST['logrosCalc'][1]['equipo'];
    $juego=$_POST['logrosCalc'][1]['juego'];
    $numero=$_POST['logrosCalc'][1]['numero'];
    $padre=$_POST['logrosCalc'][1]['padre'];
    $deporte=$_POST['logrosCalc'][1]['deporte'];
    $lineatp=2;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}
if (empty($_POST['logrosCalc'][2]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][2]['codigo'];
    $tipo=$_POST['logrosCalc'][2]['tipo'];
    $referencia=$_POST['logrosCalc'][2]['referencia'];
    $logro=$_POST['logrosCalc'][2]['logro'];
    $equipo=$_POST['logrosCalc'][2]['equipo'];
    $juego=$_POST['logrosCalc'][2]['juego'];
    $numero=$_POST['logrosCalc'][2]['numero'];
    $padre=$_POST['logrosCalc'][2]['padre'];
    $deporte=$_POST['logrosCalc'][2]['deporte'];
    $lineatp=3;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}
if (empty($_POST['logrosCalc'][3]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][3]['codigo'];
    $tipo=$_POST['logrosCalc'][3]['tipo'];
    $referencia=$_POST['logrosCalc'][3]['referencia'];
    $logro=$_POST['logrosCalc'][3]['logro'];
    $equipo=$_POST['logrosCalc'][3]['equipo'];
    $juego=$_POST['logrosCalc'][3]['juego'];
    $numero=$_POST['logrosCalc'][3]['numero'];
    $padre=$_POST['logrosCalc'][3]['padre'];
    $deporte=$_POST['logrosCalc'][3]['deporte'];
    $lineatp=4;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}
if (empty($_POST['logrosCalc'][4]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][4]['codigo'];
    $tipo=$_POST['logrosCalc'][4]['tipo'];
    $referencia=$_POST['logrosCalc'][4]['referencia'];
    $logro=$_POST['logrosCalc'][4]['logro'];
    $equipo=$_POST['logrosCalc'][4]['equipo'];
    $juego=$_POST['logrosCalc'][4]['juego'];
    $numero=$_POST['logrosCalc'][4]['numero'];
    $padre=$_POST['logrosCalc'][4]['padre'];
    $deporte=$_POST['logrosCalc'][4]['deporte'];
    $lineatp=5;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}
if (empty($_POST['logrosCalc'][5]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][5]['codigo'];
    $tipo=$_POST['logrosCalc'][5]['tipo'];
    $referencia=$_POST['logrosCalc'][5]['referencia'];
    $logro=$_POST['logrosCalc'][5]['logro'];
    $equipo=$_POST['logrosCalc'][5]['equipo'];
    $juego=$_POST['logrosCalc'][5]['juego'];
    $numero=$_POST['logrosCalc'][5]['numero'];
    $padre=$_POST['logrosCalc'][5]['padre'];
    $deporte=$_POST['logrosCalc'][5]['deporte'];
    $lineatp=6;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}
if (empty($_POST['logrosCalc'][6]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][6]['codigo'];
    $tipo=$_POST['logrosCalc'][6]['tipo'];
    $referencia=$_POST['logrosCalc'][6]['referencia'];
    $logro=$_POST['logrosCalc'][6]['logro'];
    $equipo=$_POST['logrosCalc'][6]['equipo'];
    $juego=$_POST['logrosCalc'][6]['juego'];
    $numero=$_POST['logrosCalc'][6]['numero'];
    $padre=$_POST['logrosCalc'][6]['padre'];
    $deporte=$_POST['logrosCalc'][6]['deporte'];
    $lineatp=7;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}
if (empty($_POST['logrosCalc'][7]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][7]['codigo'];
    $tipo=$_POST['logrosCalc'][7]['tipo'];
    $referencia=$_POST['logrosCalc'][7]['referencia'];
    $logro=$_POST['logrosCalc'][7]['logro'];
    $equipo=$_POST['logrosCalc'][7]['equipo'];
    $juego=$_POST['logrosCalc'][7]['juego'];
    $numero=$_POST['logrosCalc'][7]['numero'];
    $padre=$_POST['logrosCalc'][7]['padre'];
    $deporte=$_POST['logrosCalc'][7]['deporte'];
    $lineatp=8;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}
if (empty($_POST['logrosCalc'][8]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][8]['codigo'];
    $tipo=$_POST['logrosCalc'][8]['tipo'];
    $referencia=$_POST['logrosCalc'][8]['referencia'];
    $logro=$_POST['logrosCalc'][8]['logro'];
    $equipo=$_POST['logrosCalc'][8]['equipo'];
    $juego=$_POST['logrosCalc'][8]['juego'];
    $numero=$_POST['logrosCalc'][8]['numero'];
    $padre=$_POST['logrosCalc'][8]['padre'];
    $deporte=$_POST['logrosCalc'][8]['deporte'];
    $lineatp=9;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}
if (empty($_POST['logrosCalc'][9]['codigo'])) {
} else {
    $codigo=$_POST['logrosCalc'][9]['codigo'];
    $tipo=$_POST['logrosCalc'][9]['tipo'];
    $referencia=$_POST['logrosCalc'][9]['referencia'];
    $logro=$_POST['logrosCalc'][9]['logro'];
    $equipo=$_POST['logrosCalc'][9]['equipo'];
    $juego=$_POST['logrosCalc'][9]['juego'];
    $numero=$_POST['logrosCalc'][9]['numero'];
    $padre=$_POST['logrosCalc'][9]['padre'];
    $deporte=$_POST['logrosCalc'][9]['deporte'];
    $lineatp=10;
    if ($codigo>0) {
        include("../parley/parleyregistrar2.php");
    }
}

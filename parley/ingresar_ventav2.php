<?php
require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;
$usuario=$_POST['usuario'];
$taquilla=$_POST['taquilla'];
if($_POST['monedacod']==12){
$moneda=$_POST['monedaD'];
}else{
$moneda=$_POST['monedacod'];  
}
$query_Recordset5 = sprintf(
    "
/* PARSEADORES1 parley\ingresar_ventav2.php - QUERY 1 */ SELECT * FROM   taquilla, usuario, taquilla_opc_parley, agencia,
			banca
WHERE 
taquilla.cod_taquilla = %s AND
usuario.cod_taquilla = taquilla.cod_taquilla AND
taquilla_opc_parley.cod_taquilla = taquilla.cod_taquilla AND
taquilla.cod_agencia = agencia.cod_agencia AND
agencia.cod_banca = banca.cod_banca
LIMIT 1",
    GetSQLValueString($taquilla, "int")
);
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$tipot=$row_Recordset5['ImpSI0NO1']/1;
$tipotaquilla=$row_Recordset5['tipotaquilla']/1;
$tra_codigo=$row_Recordset5['tra_codigo']/1;
$saldoactual=$row_Recordset5['saldoactual']/1;
$cod_agencia=$row_Recordset5['cod_agencia']/1;
$tipo_pagoa=$row_Recordset5['tipo_pagoa']/1;
$tel_agencia=$row_Recordset5['tel_agencia']/1;
$apu_maxparley=$row_Recordset5['apu_maxparley']/1;
$apu_minparley=$row_Recordset5['apu_minparley']/1;
$comb_minparley=$row_Recordset5['comb_minparley']/1;
$comb_maxparley=$row_Recordset5['comb_maxparley']/1;
$cantTicket=ObtenerNumeroJugadap($usuario, $FechaTxt)+1;

$ip_ventap=getRealIP();
$query_Recordset1 = "/* PARSEADORES1 parley\ingresar_ventav2.php - QUERY 2 */ SELECT MAX(Id_p4jugadasp4) FROM p4jugadas";
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$numeroticket=((int)$row_Recordset1['MAX(Id_p4jugadasp4)'])+1;
$numeroticket=$usuario.$numeroticket;
function generarCodigo2($longitud, $texto)
{
    $key = '';
    $pattern = '123456789'.$texto;
    $max = strlen($pattern)-1;
    for ($i=0;$i < $longitud;$i++) {
        $key .= $pattern{mt_rand(0, $max)};
    }
    return $key;
}
$serial=generarCodigo2(5, $numeroticket);
//$serial=$numeroticket;
$errordata=0;
$juegocerrado=0;
$logronoigual=0;
// logrosCalc[1][logro]: -110
if (empty($_POST['montoApostar_mobil'])) {
    $montoApuesta=$_POST['montoApostar'];
} else {
    $montoApuesta=$_POST['montoApostar_mobil'];
}
if (empty($_POST['montoApostar'])) {
    $montoApuesta=$_POST['montoApostar_mobil'];
} else {
    $montoApuesta=$_POST['montoApostar'];
}


$data=$_POST['logrosCalc'];
$data= json_decode($data, true);
$tt=0;
foreach ($data as $key => $value) {
    $query_Recordset1cc =  sprintf(
        "/* PARSEADORES1 parley\ingresar_ventav2.php - QUERY 3 */ SELECT 
*
FROM
p2juegos
WHERE
Id_p2juegosp2 = %s AND   iniciodtp2 < %s",
        GetSQLValueString($data[$tt]['juego'], "int"),
        GetSQLValueString($datetime, "date")
    );
    $Recordset1cc = mysqli_query($conexionbanca, $query_Recordset1cc) or die(mysqli_error($conexionbanca));
    $row_Recordset1cc = mysqli_fetch_assoc($Recordset1cc);
    $totalRows_Recordset1cc = mysqli_num_rows($Recordset1cc);
    $juegocerrado=$juegocerrado+$totalRows_Recordset1cc;
    //if($data[$tt]['cantidad']==""){$data[$tt]['cantidad']=0;}
    
    $query_Recordset1lc =  sprintf(
        "/* PARSEADORES1 parley\ingresar_ventav2.php - QUERY 4 */ SELECT 
*
FROM
p3logros
WHERE
Id_p3logrosp3 = %s AND   idjuegop3 = %s AND 
(logrop3 <> %s OR logroABoRLp3 <> %s)
AND   tipojugadap3 = %s",
        GetSQLValueString($data[$tt]['referencia'], "int"),
        GetSQLValueString($data[$tt]['juego'], "int"),
        GetSQLValueString(filter_var($data[$tt]['logro'], FILTER_SANITIZE_NUMBER_INT), "text"),
        GetSQLValueString($data[$tt]['cantidad'], "text"),
        GetSQLValueString($data[$tt]['tipo'], "text")
    );
    $Recordset1lc = mysqli_query($conexionbanca, $query_Recordset1lc) or die(mysqli_error($conexionbanca));
    $row_Recordset1lc = mysqli_fetch_assoc($Recordset1lc);
    $totalRows_Recordset1lc = mysqli_num_rows($Recordset1lc);
    $logronoigual=$logronoigual+$totalRows_Recordset1lc;

    $tt++;
};
$ncombinacion=$tt; //estoy aqui verificar con inser en nada si guardas las combinaciones correctas



if ($apu_maxparley>=$montoApuesta) {  //6verifica monto maximo apuesta parley
if ($apu_minparley<=$montoApuesta) {  //5verifica monto minimo apuesta parley
if ($ncombinacion>=$comb_minparley) { //4verifica combinacion minima parley
if ($ncombinacion<=$comb_maxparley) { //3verifica combinacion maxima parley
if ($logronoigual==0) {   //2verifica si los logros no se han actualizado estoy aqui
if ($juegocerrado==0) {   //1verifica si no hay juegos cerrados
    if (empty($data[0]['codigo'])) {
    } else {
        $codigo=$data[0]['codigo'];
        $tipo=$data[0]['tipo'];
        $referencia=$data[0]['referencia'];
        $logro=filter_var($data[0]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[0]['equipo'];
        $juego=$data[0]['juego'];
        $numero=$data[0]['numero'];
        $padre=$data[0]['padre'];
        $deporte=$data[0]['deporte'];
        $ab_o_rlp4=$data[0]['cantidad'];
        $lineatp=1;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[1]['codigo'])) {
    } else {
        $codigo=$data[1]['codigo'];
        $tipo=$data[1]['tipo'];
        $referencia=$data[1]['referencia'];
        $logro=filter_var($data[1]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[1]['equipo'];
        $juego=$data[1]['juego'];
        $numero=$data[1]['numero'];
        $padre=$data[1]['padre'];
        $deporte=$data[1]['deporte'];
        $ab_o_rlp4=$data[1]['cantidad'];
        $lineatp=2;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[2]['codigo'])) {
    } else {
        $codigo=$data[2]['codigo'];
        $tipo=$data[2]['tipo'];
        $referencia=$data[2]['referencia'];
        $logro=filter_var($data[2]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[2]['equipo'];
        $juego=$data[2]['juego'];
        $numero=$data[2]['numero'];
        $padre=$data[2]['padre'];
        $deporte=$data[2]['deporte'];
        $ab_o_rlp4=$data[2]['cantidad'];
        $lineatp=3;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[3]['codigo'])) {
    } else {
        $codigo=$data[3]['codigo'];
        $tipo=$data[3]['tipo'];
        $referencia=$data[3]['referencia'];
        $logro=filter_var($data[3]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[3]['equipo'];
        $juego=$data[3]['juego'];
        $numero=$data[3]['numero'];
        $padre=$data[3]['padre'];
        $deporte=$data[3]['deporte'];
        $ab_o_rlp4=$data[3]['cantidad'];
        $lineatp=4;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[4]['codigo'])) {
    } else {
        $codigo=$data[4]['codigo'];
        $tipo=$data[4]['tipo'];
        $referencia=$data[4]['referencia'];
        $logro=filter_var($data[4]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[4]['equipo'];
        $juego=$data[4]['juego'];
        $numero=$data[4]['numero'];
        $padre=$data[4]['padre'];
        $deporte=$data[4]['deporte'];
        $ab_o_rlp4=$data[4]['cantidad'];
        $lineatp=5;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[5]['codigo'])) {
    } else {
        $codigo=$data[5]['codigo'];
        $tipo=$data[5]['tipo'];
        $referencia=$data[5]['referencia'];
        $logro=filter_var($data[5]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[5]['equipo'];
        $juego=$data[5]['juego'];
        $numero=$data[5]['numero'];
        $padre=$data[5]['padre'];
        $deporte=$data[5]['deporte'];
        $ab_o_rlp4=$data[5]['cantidad'];
        $lineatp=6;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[6]['codigo'])) {
    } else {
        $codigo=$data[6]['codigo'];
        $tipo=$data[6]['tipo'];
        $referencia=$data[6]['referencia'];
        $logro=filter_var($data[6]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[6]['equipo'];
        $juego=$data[6]['juego'];
        $numero=$data[6]['numero'];
        $padre=$data[6]['padre'];
        $deporte=$data[6]['deporte'];
        $ab_o_rlp4=$data[6]['cantidad'];
        $lineatp=7;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[7]['codigo'])) {
    } else {
        $codigo=$data[7]['codigo'];
        $tipo=$data[7]['tipo'];
        $referencia=$data[7]['referencia'];
        $logro=filter_var($data[7]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[7]['equipo'];
        $juego=$data[7]['juego'];
        $numero=$data[7]['numero'];
        $padre=$data[7]['padre'];
        $deporte=$data[7]['deporte'];
        $ab_o_rlp4=$data[7]['cantidad'];
        $lineatp=8;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[8]['codigo'])) {
    } else {
        $codigo=$data[8]['codigo'];
        $tipo=$data[8]['tipo'];
        $referencia=$data[8]['referencia'];
        $logro=filter_var($data[8]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[8]['equipo'];
        $juego=$data[8]['juego'];
        $numero=$data[8]['numero'];
        $padre=$data[8]['padre'];
        $deporte=$data[8]['deporte'];
        $ab_o_rlp4=$data[8]['cantidad'];
        $lineatp=9;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[9]['codigo'])) {
    } else {
        $codigo=$data[9]['codigo'];
        $tipo=$data[9]['tipo'];
        $referencia=$data[9]['referencia'];
        $logro=filter_var($data[9]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[9]['equipo'];
        $juego=$data[9]['juego'];
        $numero=$data[9]['numero'];
        $padre=$data[9]['padre'];
        $deporte=$data[9]['deporte'];
        $ab_o_rlp4=$data[9]['cantidad'];
        $lineatp=10;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[10]['codigo'])) {
    } else {
        $codigo=$data[10]['codigo'];
        $tipo=$data[10]['tipo'];
        $referencia=$data[10]['referencia'];
        $logro=filter_var($data[10]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[10]['equipo'];
        $juego=$data[10]['juego'];
        $numero=$data[10]['numero'];
        $padre=$data[10]['padre'];
        $deporte=$data[10]['deporte'];
        $ab_o_rlp4=$data[10]['cantidad'];
        $lineatp=11;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[11]['codigo'])) {
    } else {
        $codigo=$data[11]['codigo'];
        $tipo=$data[11]['tipo'];
        $referencia=$data[11]['referencia'];
        $logro=filter_var($data[11]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[11]['equipo'];
        $juego=$data[11]['juego'];
        $numero=$data[11]['numero'];
        $padre=$data[11]['padre'];
        $deporte=$data[11]['deporte'];
        $ab_o_rlp4=$data[11]['cantidad'];
        $lineatp=12;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[12]['codigo'])) {
    } else {
        $codigo=$data[12]['codigo'];
        $tipo=$data[12]['tipo'];
        $referencia=$data[12]['referencia'];
        $logro=filter_var($data[12]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[12]['equipo'];
        $juego=$data[12]['juego'];
        $numero=$data[12]['numero'];
        $padre=$data[12]['padre'];
        $deporte=$data[12]['deporte'];
        $ab_o_rlp4=$data[12]['cantidad'];
        $lineatp=13;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[13]['codigo'])) {
    } else {
        $codigo=$data[13]['codigo'];
        $tipo=$data[13]['tipo'];
        $referencia=$data[13]['referencia'];
        $logro=filter_var($data[13]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[13]['equipo'];
        $juego=$data[13]['juego'];
        $numero=$data[13]['numero'];
        $padre=$data[13]['padre'];
        $deporte=$data[13]['deporte'];
        $ab_o_rlp4=$data[13]['cantidad'];
        $lineatp=14;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[14]['codigo'])) {
    } else {
        $codigo=$data[14]['codigo'];
        $tipo=$data[14]['tipo'];
        $referencia=$data[14]['referencia'];
        $logro=filter_var($data[14]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[14]['equipo'];
        $juego=$data[14]['juego'];
        $numero=$data[14]['numero'];
        $padre=$data[14]['padre'];
        $deporte=$data[14]['deporte'];
        $ab_o_rlp4=$data[14]['cantidad'];
        $lineatp=15;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[15]['codigo'])) {
    } else {
        $codigo=$data[15]['codigo'];
        $tipo=$data[15]['tipo'];
        $referencia=$data[15]['referencia'];
        $logro=filter_var($data[15]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[15]['equipo'];
        $juego=$data[15]['juego'];
        $numero=$data[15]['numero'];
        $padre=$data[15]['padre'];
        $deporte=$data[15]['deporte'];
        $ab_o_rlp4=$data[15]['cantidad'];
        $lineatp=16;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[16]['codigo'])) {
    } else {
        $codigo=$data[16]['codigo'];
        $tipo=$data[16]['tipo'];
        $referencia=$data[16]['referencia'];
        $logro=filter_var($data[16]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[16]['equipo'];
        $juego=$data[16]['juego'];
        $numero=$data[16]['numero'];
        $padre=$data[16]['padre'];
        $deporte=$data[16]['deporte'];
        $ab_o_rlp4=$data[16]['cantidad'];
        $lineatp=17;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[17]['codigo'])) {
    } else {
        $codigo=$data[17]['codigo'];
        $tipo=$data[17]['tipo'];
        $referencia=$data[17]['referencia'];
        $logro=filter_var($data[17]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[17]['equipo'];
        $juego=$data[17]['juego'];
        $numero=$data[17]['numero'];
        $padre=$data[17]['padre'];
        $deporte=$data[17]['deporte'];
        $ab_o_rlp4=$data[17]['cantidad'];
        $lineatp=18;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[18]['codigo'])) {
    } else {
        $codigo=$data[18]['codigo'];
        $tipo=$data[18]['tipo'];
        $referencia=$data[18]['referencia'];
        $logro=filter_var($data[18]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[18]['equipo'];
        $juego=$data[18]['juego'];
        $numero=$data[18]['numero'];
        $padre=$data[18]['padre'];
        $deporte=$data[18]['deporte'];
        $ab_o_rlp4=$data[18]['cantidad'];
        $lineatp=19;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }
    if (empty($data[19]['codigo'])) {
    } else {
        $codigo=$data[19]['codigo'];
        $tipo=$data[19]['tipo'];
        $referencia=$data[19]['referencia'];
        $logro=filter_var($data[19]['logro'], FILTER_SANITIZE_NUMBER_INT);
        $equipo=$data[19]['equipo'];
        $juego=$data[19]['juego'];
        $numero=$data[19]['numero'];
        $padre=$data[19]['padre'];
        $deporte=$data[19]['deporte'];
        $ab_o_rlp4=$data[19]['cantidad'];
        $lineatp=20;
        if ($codigo>0) {
            include("../parley/parleyregistrar2.php");
        }
    }

    $query_Recordset13 = sprintf(
        "/* PARSEADORES1 parley\ingresar_ventav2.php - QUERY 5 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
        GetSQLValueString($moneda, "int"),
        GetSQLValueString($taquilla, "int")
    );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
    $Idbalancecli=((int)$row_Recordset13['MAX(Idbalancecli)']);
    $query_Recordset14 = sprintf(
        "/* PARSEADORES1 parley\ingresar_ventav2.php - QUERY 6 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
        GetSQLValueString($moneda, "int"),
        GetSQLValueString($Idbalancecli, "int")
    );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
    $saldoactualc=((float)$row_Recordset14['saldoactualc']);
    
    $query_Recordset12 = sprintf(
        "/* PARSEADORES1 parley\ingresar_ventav2.php - QUERY 7 */ SELECT MAX(nticketp4) 
					FROM p4jugadas
					WHERE cod_taquillap4 = %s",
        GetSQLValueString($taquilla, "int")
    );
    $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
    $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
    $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
    $numeroticket=((int)$row_Recordset12['MAX(nticketp4)']);
    
    $query_Recordset15 = sprintf(
        "/* PARSEADORES1 parley\ingresar_ventav2.php - QUERY 8 */ SELECT 
	*
FROM 
	p4jugadas
WHERE 
nticketp4 = %s AND
	cod_taquillap4 = %s",
        GetSQLValueString($numeroticket, "int"),
        GetSQLValueString($taquilla, "int")
    );
    $Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
    $row_Recordset15 = mysqli_fetch_assoc($Recordset15);
    $totalRows_Recordset15 = mysqli_num_rows($Recordset15);
    $www="";
    $esp=" ";
    $sal="</br>";
    do {
        $w=$esp.$esp.$row_Recordset15['equipop4'].$esp.$esp.$row_Recordset15['tipojp4'].$esp.$esp.$row_Recordset15['ab_o_rlp4'].$esp.$esp.$row_Recordset15['logrop4'].$esp.$esp.$sal;
        $www=$www.$w;
    } while ($row_Recordset15 = mysqli_fetch_assoc($Recordset15));
     
     
     
    $insertSQL155 = sprintf(
        "/* PARSEADORES1 parley\ingresar_ventav2.php - QUERY 9 */ INSERT INTO balanceclientes  
(numticket, agregadox, cod_taquilla, monto, jugada, fec_venta, hor_venta, saldoactualc, monedac, modulo)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($numeroticket, "int"),
        GetSQLValueString(1, "int"),
        GetSQLValueString($taquilla, "int"),
        GetSQLValueString('-'.$montoApuesta, "double"),
        GetSQLValueString($www, "text"),
        GetSQLValueString($FechaTxt, "date"),
        GetSQLValueString($horaTxt, "date"),
        GetSQLValueString($saldoactualc-$montoApuesta, "double"),
        GetSQLValueString($moneda, "int"),
        GetSQLValueString(2, "int")
    );

    $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
} else {
    $errordata=1;
}
} else {
    $errordata=2;
}
} else {
    $errordata=3; //verifica combinacion maxima parley
}
} else {
    $errordata=4; //verifica combinacion minima parley
}
} else {
    $errordata=5;  //verifica monto minimo apuesta parley
}
} else {
    $errordata=6; //verifica monto maximo apuesta parley
}
     
     
$data = array("nticket"=>$numeroticket, "error"=>$errordata, "actualiza"=>1);
    // $data =  array("whatApp"=>"FALCON","ticket"=>$impresiondd ,"sms"=>"Ticket Registrado con Exitos.... ","pdf"=>"FALCON","nticket"=>$numeroticket, "error"=>"0");
echo json_encode($data);

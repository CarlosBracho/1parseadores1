<?php
require_once('../Connections/conexionbanca.php');
$fechasistema=fechaactualbd();
$horasistema=horaactual();

$query_Recordset1 = "/* PARSEADORES1 new\includes\replicaciontest.php - QUERY 1 */ SELECT MAX(num_ticket) FROM venta";
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$numeroticket=((int)$row_Recordset1['MAX(num_ticket)'])+1;
echo 'ULTIMA JUGADA DEL MASTER:.';
echo $numeroticket;
echo '<br/>';

require_once('../Connections/conexionbancaesclavo.php');
$query_Recordset15 = "/* PARSEADORES1 new\includes\replicaciontest.php - QUERY 2 */ SELECT MAX(num_ticket) FROM venta";
$Recordset15 = mysqli_query($conexionbanca15, $query_Recordset15) or die(mysqli_error($conexionbanca15));
$row_Recordset15 = mysqli_fetch_assoc($Recordset15);
$totalRows_Recordset15 = mysqli_num_rows($Recordset1);
$numeroticket15=((int)$row_Recordset15['MAX(num_ticket)'])+1;
echo 'ULTIMA JUGADA DEL ESCLAVO:.';
echo $numeroticket15;
echo '<br/>';

mysqli_free_result($Recordset1);
mysqli_free_result($Recordset15);
$estado='0';
if ($numeroticket === $numeroticket15) {
    echo '<br/>';
    echo 'si esta replicando';
    $estado=1;

    define('BOT_TOKEN', '309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE');
    define('CHAT_ID', '138894409');
    define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');




    function enviar_telegram($msj)
    {
        $queryArray = [
    'chat_id'  => CHAT_ID,
    'text'     => $msj,
    ];
        $url = 'https://api.telegram.org/bot'.BOT_TOKEN.'/sendMessage?'
           . http_build_query($queryArray);
        $result = file_get_contents($url);
    }

    enviar_telegram("Replicacion esta respaldando los datos");
} else {
    echo '<br/>';
    echo 'no esta replicando';
}
if ($estado === 0) {
    echo '<br/>';
    echo 'no esta replicando';
}

echo $estado;

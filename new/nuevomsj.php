<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('./Connections/conexionbanca.php');
$fechasistema=fechaactualbd();
$horasistema=horaactual();
$query_Recordset12 = sprintf("
/* PARSEADORES1 new\nuevomsj.php - QUERY 1 */ SELECT * 
FROM 
chat2
USE INDEX(sentdate)
WHERE sentdate=%s AND tipo=%s AND recd=1
LIMIT 1", GetSQLValueString($fechasistema, "date"), GetSQLValueString(0, "int"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);

?>



<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>

</head>
<body>

<?php

if ($totalRows_Recordset12==1 && $horasistema<="17:00:00") {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/nuevomsj_avisotelegram.php');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);


    $result = curl_exec($ch);
    $data = curl_error($ch);
    curl_close($ch);
}
if ($totalRows_Recordset12==0) {
}
?>
<br/>

<?php
?>
</body>

    <script>
     </script>
</html>
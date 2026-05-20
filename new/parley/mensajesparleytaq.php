<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');


$query_Recordset4 = "/* PARSEADORES1 new\parley\mensajesparleytaq.php - QUERY 1 */ SELECT * FROM mensajes
WHERE (est_mensaje=1 OR est_mensaje=9)
ORDER BY RAND() LIMIT 1";
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$mensaje1 = trim($row_Recordset4['mensaje']);
echo $mensaje1;








?>
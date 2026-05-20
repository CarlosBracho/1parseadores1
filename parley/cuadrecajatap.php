<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (!isset($_SESSION['MM_id_usuario'])) {
    $id_usuarioO=$_SESSION['MM_id_usuario'];
} else {
    $id_usuarioO=0;
}
$query_Recordset13 = sprintf(
    "/* PARSEADORES1 parley\cuadrecajatap.php - QUERY 1 */ SELECT 
p4jugadas.lineatp4,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.monedap4 <= 2 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventabss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.estadoticketp4 >= 7 AND p4jugadas.monedap4 <= 2  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadobss,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.monedap4 = 3 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventausd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.estadoticketp4 >= 7 AND p4jugadas.monedap4 = 3  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadousd,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.monedap4 = 4 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventacop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.estadoticketp4 >= 7 AND p4jugadas.monedap4 = 4  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadocop,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.monedap4 = 5 THEN p4jugadas.mon_ventap4 ELSE 0 END) AS total_ventasol,
SUM(CASE WHEN p4jugadas.lineatp4 = 1 AND p4jugadas.estadoticketp4 >= 7 AND p4jugadas.monedap4 = 5  THEN p4jugadas.premioapagarp4 ELSE 0 END) AS total_pagadosol
FROM 
p4jugadas
WHERE
p4jugadas.id_usuariop4= %s AND 
p4jugadas.lineatp4= 1",
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);






?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>.:Apuestas:.</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrap4.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<script src="../js/jquery-3.5.1.min.js"></script>

</head>

<body>
<header> 
  <!-- Fixed navbar -->
  <?php include('../parley/menutap.php'); ?>
</header>
<?php
if ($row_Recordset13['total_ventabss']>0 or $row_Recordset13['total_pagadobss']>0) {
    echo 'Bss</br>';
    echo 'Total ventas:.'.$row_Recordset13['total_ventabss'].' Bss';
    echo '</br>';
    echo 'Total pagos:.'.$row_Recordset13['total_pagadobss'].' Bss';
    echo '</br>';
    echo 'Total en caja:.'.($row_Recordset13['total_ventabss']-$row_Recordset13['total_pagadobss']).' Bss';
}
if ($row_Recordset13['total_ventausd']>0 or $row_Recordset13['total_pagadousd']>0) {
    echo '</br></br>Usd</br>';
    echo 'Total ventas:.'.$row_Recordset13['total_ventausd'].' Usd';
    echo '</br>';
    echo 'Total pagos:.'.$row_Recordset13['total_pagadousd'].' Usd';
    echo '</br>';
    echo 'Total en caja:.'.($row_Recordset13['total_ventausd']-$row_Recordset13['total_pagadousd']).' Usd';
}
if ($row_Recordset13['total_ventacop']>0 or $row_Recordset13['total_pagadocop']>0) {
    echo '</br></br>Cop</br>';
    echo 'Total ventas:.'.$row_Recordset13['total_ventacop'].' Cop';
    echo '</br>';
    echo 'Total pagos:.'.$row_Recordset13['total_pagadocop'].' Cop';
    echo '</br>';
    echo 'Total en caja:.'.($row_Recordset13['total_ventacop']-$row_Recordset13['total_pagadocop']).' Cop';
}
if ($row_Recordset13['total_ventasol']>0 or $row_Recordset13['total_pagadosol']>0) {
    echo '</br></br>Sol</br>';
    echo 'Total ventas:.'.$row_Recordset13['total_ventasol'].' Sol';
    echo '</br>';
    echo 'Total pagos:.'.$row_Recordset13['total_pagadosol'].' Sol';
    echo '</br>';
    echo 'Total en caja:.'.($row_Recordset13['total_ventasol']-$row_Recordset13['total_pagadosol']).' Sol';
}



?>

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="../js/bootstrap4.min.js"></script>
</body>
</html>

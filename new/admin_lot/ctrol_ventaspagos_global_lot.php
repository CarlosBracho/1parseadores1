<?php
require_once('../Connections/conexionbanca.php');
if (isset($_POST["cod_control"])) {
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 new\admin_lot\ctrol_ventaspagos_global_lot.php - QUERY 1 */ UPDATE ctrol_ventpag_global_lot
		SET
			est_control_ventas_lot=%s, 
			est_control_pagos_lot=%s
		WHERE cod_ctrol_ventpag_global_lot=%s",
        GetSQLValueString($_POST["est_control_ventas"], "int"),
        GetSQLValueString($_POST["est_control_pagos"], "int"),
        GetSQLValueString($_POST["cod_control"], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
}

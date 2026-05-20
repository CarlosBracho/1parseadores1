<?php
require_once('../Connections/conexionbanca.php');
 if (isset($_POST["cod_control"])) {
     $insertSQL1 = sprintf(
         "/* PARSEADORES1 admin_hnac\ctrol_ventaspagos_global_hnac.php - QUERY 1 */ UPDATE ctrol_ventpag_global_hnac
		SET
			est_control_ventas_hnac=%s, 
			est_control_pagos_hnac=%s
		WHERE cod_ctrol_ventpag_global_hnac=%s",
         GetSQLValueString($_POST["est_control_ventas_hnac"], "int"),
         GetSQLValueString($_POST["est_control_pagos_hnac"], "int"),
         GetSQLValueString($_POST["cod_control"], "int")
     );
     $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

     $query_Recordset13 = sprintf("/* PARSEADORES1 admin_hnac\ctrol_ventaspagos_global_hnac.php - QUERY 2 */ SELECT * FROM ctrol_ventpag_global_hnac WHERE cod_ctrol_ventpag_global_hnac = 1");
     $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
     $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
     $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
     $cod_control=$row_Recordset13['cod_ctrol_ventpag_global_hnac'];
     $est_control_ventas_hnac=$row_Recordset13['est_control_ventas_hnac'];
     $est_control_pagos_hnac=$row_Recordset13['est_control_pagos_hnac'];

     echo "ventas: ".$est_control_ventas_hnac." pagos".$est_control_pagos_hnac;


     //echo $_POST["est_control_ventas_hnac"];
    
    //echo $_POST["est_control_pagos_hnac"];
 }

/*
        echo"<script>";
        echo"$('#refrescar').bootstrapToggle('off');";
        echo"$('#refrescar').bootstrapToggle('disable');";
        echo"</script>";
*/

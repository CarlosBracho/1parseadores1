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
                                "/* PARSEADORES1 new\apostador\saldocliente.php - QUERY 1 */ SELECT cod_taquilla
					FROM usuario
					WHERE
					id_usuario = %s",
                                GetSQLValueString($_SESSION['MM_id_usuario'], "int")
                            );
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);


                            $query_Recordset14 = sprintf(
                                "/* PARSEADORES1 new\apostador\saldocliente.php - QUERY 2 */ SELECT saldoactualc, Idbalancecli
					FROM balanceclientes
					WHERE monedac <= 2 AND
					cod_taquilla = %s 
					ORDER 
					BY Idbalancecli 
					DESC LIMIT 0, 1",
                                GetSQLValueString($row_Recordset13['cod_taquilla'], "int")
                            );
    $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
    $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
    $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
                                $query_Recordset15 = sprintf(
                                    "/* PARSEADORES1 new\apostador\saldocliente.php - QUERY 3 */ SELECT saldoactualc, Idbalancecli
					FROM balanceclientes
					WHERE monedac = 3 AND
					cod_taquilla = %s ORDER BY Idbalancecli DESC LIMIT 1",
                                    GetSQLValueString($row_Recordset13['cod_taquilla'], "int")
                                );
    $Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
    $row_Recordset15 = mysqli_fetch_assoc($Recordset15);
    $totalRows_Recordset15 = mysqli_num_rows($Recordset15);
                                $query_Recordset16 = sprintf(
                                    "/* PARSEADORES1 new\apostador\saldocliente.php - QUERY 4 */ SELECT saldoactualc, Idbalancecli
					FROM balanceclientes
					WHERE monedac = 4 AND
					cod_taquilla = %s ORDER BY Idbalancecli DESC LIMIT 1",
                                    GetSQLValueString($row_Recordset13['cod_taquilla'], "int")
                                );
    $Recordset16 = mysqli_query($conexionbanca, $query_Recordset16) or die(mysqli_error($conexionbanca));
    $row_Recordset16 = mysqli_fetch_assoc($Recordset16);
    $totalRows_Recordset16 = mysqli_num_rows($Recordset16);
                                $query_Recordset17 = sprintf(
                                    "/* PARSEADORES1 new\apostador\saldocliente.php - QUERY 5 */ SELECT saldoactualc, Idbalancecli
					FROM balanceclientes
					WHERE monedac = 5 AND
					cod_taquilla = %s ORDER BY Idbalancecli DESC LIMIT 1",
                                    GetSQLValueString($row_Recordset13['cod_taquilla'], "int")
                                );
    $Recordset17 = mysqli_query($conexionbanca, $query_Recordset17) or die(mysqli_error($conexionbanca));
    $row_Recordset17 = mysqli_fetch_assoc($Recordset17);
    $totalRows_Recordset17 = mysqli_num_rows($Recordset17);

if ($row_Recordset14['saldoactualc']>0) {
    echo $row_Recordset14['saldoactualc'];
    echo ' BSS  ';
} if ($row_Recordset15['saldoactualc']>0) {
    echo $row_Recordset15['saldoactualc'];
    echo ' USD  ';
} if ($row_Recordset16['saldoactualc']>0) {
    echo $row_Recordset16['saldoactualc'];
    echo ' COP  ';
} if ($row_Recordset17['saldoactualc']>0) {
    echo $row_Recordset17['saldoactualc'];
    echo ' SOL ';
}
?>




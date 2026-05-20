<?php 
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');

$query_Recordset1_solteos_resultados = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\eliminar_resul_ani.php - QUERY 1 */ DELETE 
    FROM  ani6_resultados
    WHERE 
    id_solteo_ani6 = %s",
    GetSQLValueString($_POST['nticket'], "int"));
    $Recordset1_solteos_resultados =mysqli_query($conexionbanca, $query_Recordset1_solteos_resultados) or die(mysqli_error($conexionbanca));
    $row_Recordset1_solteos_resultados = mysqli_fetch_assoc($Recordset1_solteos_resultados);
    $totalRows_Recordset1_solteos_resultados = mysqli_num_rows($Recordset1_solteos_resultados);

    ?>
    <div class="card">
    <div class="card-body">
    <center><p><H1><FONT SIZE=25>

        RESULTADO A SIDO ELMININADO
        </FONT></H1></p></center><br/>
       
</div></div>
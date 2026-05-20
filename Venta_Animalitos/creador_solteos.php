<?php
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;

$query_Recordset1_buscasolteos_activos = sprintf(
    "/* PARSEADORES1 Venta_Animalitos\creador_solteos.php - QUERY 1 */ SELECT  
id_Loterias_y_nombres_ani1,
nom_Loterias_y_nombres_ani1,
animales_Loterias_y_nombres_ani1,
horas_solteos_ani1
    FROM 
    ani1_loterias_y_nombres
   WHERE estado_ani1=%s",
   GetSQLValueString(0, "int"));
    $Recordset1_buscasolteos_activos = mysqli_query($conexionbanca, $query_Recordset1_buscasolteos_activos) or die(mysqli_error($conexionbanca));
    $row_Recordset1_buscasolteos_activos = mysqli_fetch_assoc($Recordset1_buscasolteos_activos);
    $totalRows_Recordset1_buscasolteos_activos = mysqli_num_rows($Recordset1_buscasolteos_activos);


   // echo $totalRows_Recordset1_buscasolteos_activos.'<br><br><br>';


    do{
       echo 'id_Loterias_y_nombres_ani1 = '.$row_Recordset1_buscasolteos_activos["id_Loterias_y_nombres_ani1"].'<br>';
       echo 'nom_Loterias_y_nombres_ani1 = '.$row_Recordset1_buscasolteos_activos["nom_Loterias_y_nombres_ani1"].'<br>';
        $horas_solteos_ani1 = explode(",", $row_Recordset1_buscasolteos_activos["horas_solteos_ani1"]);
        foreach ($horas_solteos_ani1 as $valor_horas_solteos_ani1) {
            

            $valor_horas_solteos_ani1 =str_replace('.', ' ', $valor_horas_solteos_ani1);
            $valor_horas_solteos_ani1 = date("Y-m-d H:i:s", strtotime($valor_horas_solteos_ani1));
            echo $valor_horas_solteos_ani1.'<br>';

            $query_Recordset1_si_solteo_esta = sprintf(
                "/* PARSEADORES1 Venta_Animalitos\creador_solteos.php - QUERY 2 */ SELECT  
id_solteo_ani4
                FROM 
                ani4_solteos
               WHERE fechahora_solteo_ani4=%s AND id_Loterias_y_nombres_ani4=%s",
               GetSQLValueString($valor_horas_solteos_ani1, "date"),
               GetSQLValueString($row_Recordset1_buscasolteos_activos["id_Loterias_y_nombres_ani1"], "int"));
                $Recordset1_si_solteo_esta  = mysqli_query($conexionbanca, $query_Recordset1_si_solteo_esta ) or die(mysqli_error($conexionbanca));
                $row_Recordset1_si_solteo_esta  = mysqli_fetch_assoc($Recordset1_si_solteo_esta );
                $totalRows_Recordset1_si_solteo_esta  = mysqli_num_rows($Recordset1_si_solteo_esta );
echo 'totalRows_Recordset1_si_solteo_esta = '.$totalRows_Recordset1_si_solteo_esta.'<br>';
if($totalRows_Recordset1_si_solteo_esta==0){

    $insertSQL1_crea_solteo = sprintf(
        "/* PARSEADORES1 Venta_Animalitos\creador_solteos.php - QUERY 3 */ INSERT INTO ani4_solteos 
(id_Loterias_y_nombres_ani4, fechahora_solteo_ani4)
VALUES (%s, %s)",
        GetSQLValueString($row_Recordset1_buscasolteos_activos["id_Loterias_y_nombres_ani1"], "int"),
        GetSQLValueString($valor_horas_solteos_ani1, "date")
    );

    $Result1_crea_solteo = mysqli_query($conexionbanca, $insertSQL1_crea_solteo) or die(mysqli_error($conexionbanca));

}






        }






        echo '<br><br><br>';
    } while ($row_Recordset1_buscasolteos_activos = mysqli_fetch_assoc($Recordset1_buscasolteos_activos));
<?php
require_once('../Connections/conexionbanca.php');
 if (isset($_POST["cod_hipodromo"]) && isset($_POST["fecCarrera"])) {
     $_POST["fecCarrera"]=fechaymd($_POST["fecCarrera"]);
     ;
     $query_Recordset4 = sprintf(
         "/* PARSEADORES1 admin\ver_carrera_reporte.php - QUERY 1 */ SELECT 
		cod_carrera, nom_hipodromo, num_carrera, cod_hipodromo
	FROM 
		carrera
	WHERE 	
		fec_carrera	= %s AND cod_hipodromo = %s
	ORDER BY 
		num_carrera ASC",
         GetSQLValueString($_POST["fecCarrera"], "date"),
         GetSQLValueString($_POST["cod_hipodromo"], "int")
     );
     $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
     $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
     $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
     if ($totalRows_Recordset4>0) {
         $opciones = '<option value="todas"> TODAS</option>';
         do {
             $opciones.='<option value="'.$row_Recordset4['cod_carrera'].'">'.$row_Recordset4['num_carrera'].'</option>';
         } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
     } else {
         $opciones = '<option value="todas"> NO EXISTEN CARRERAS</option>';
     }
     echo $opciones;
 }

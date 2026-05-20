<?php
require_once('../Connections/conexionbanca.php');
 if (isset($_POST["cod_hipodromo"]) && isset($_POST["fecCarrera"])) {
     $_POST["fecCarrera"]=fechaymd($_POST["fecCarrera"]);
     ;
     $query_Recordset4 = sprintf(
         "/* PARSEADORES1 admin\filt_carrera_hipodromo.php - QUERY 1 */ SELECT 
		ca.cod_carrera, hi.nom_hipodromo, ca.num_carrera, hi.cod_hipodromo
	FROM 
		carrera ca,
		hipodromo hi
	WHERE 	
		ca.fec_carrera = %s AND 
		hi.cod_hipodromo = %s AND
		ca.nom_hipodromo = hi.nom_hipodromo
	ORDER BY 
		ca.num_carrera ASC",
         GetSQLValueString($_POST["fecCarrera"], "date"),
         GetSQLValueString($_POST["cod_hipodromo"], "int")
     );
     $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
     $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
     $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
     if ($totalRows_Recordset4>0) {
         $opciones .= '<option value="todas"> TODAS</option>';
         do {
             $opciones.='<option value="'.$row_Recordset4['cod_carrera'].'">'.$row_Recordset4['num_carrera'].'</option>';
         } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
     } else {
         $opciones = '<option value="-1"> ----------------</option>';
     }
     echo $opciones;
 }

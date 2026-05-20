<?php
require_once('../Connections/conexionbanca.php');
 if (isset($_POST["cod_hipodromo"]) && isset($_POST["fecCarrera"])) {
     $_POST["fecCarrera"]=fechaymd($_POST["fecCarrera"]);
     ;
     $query_Recordset4 = sprintf(
         "/* PARSEADORES1 admin_hnac\filt_carrera_hipodromo_hnac.php - QUERY 1 */ SELECT 
		ca.cod_carrera_hnac,
		ca.num_carrera_hnac, 
		hi.nom_hipodromo_hnac, 
		hi.cod_hipodromo_hnac
	FROM 
		carrera_hnac ca,
		hipodromo_hnac hi
	WHERE 	
		ca.fec_carrera_hnac = %s AND 
		hi.cod_hipodromo_hnac = %s AND
		ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac
	ORDER BY 
		ca.num_carrera_hnac ASC",
         GetSQLValueString($_POST["fecCarrera"], "date"),
         GetSQLValueString($_POST["cod_hipodromo"], "int")
     );
     $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
     $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
     $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
     if ($totalRows_Recordset4>0) {
         $opciones .= '<option value="todas"> TODAS</option>';
         do {
             $opciones.='<option value="'.$row_Recordset4['cod_carrera_hnac'].'">'.$row_Recordset4['num_carrera_hnac'].'</option>';
         } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
     } else {
         $opciones = '<option value="-1"> ----------------</option>';
     }
     echo $opciones;
 }

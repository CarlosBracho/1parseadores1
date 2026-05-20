<?php
require_once('../Connections/conexionbanca.php');
 if (isset($_POST["fecCarrera"])) {
     $_POST["fecCarrera"]=fechaymd($_POST["fecCarrera"]);
     $query_Recordset4 = sprintf(
         "/* PARSEADORES1 new\admin\filt_carrera_fecha.php - QUERY 1 */ SELECT 
		hi.nom_hipodromo, hi.cod_hipodromo
	FROM 
		carrera ca,
		hipodromo hi
	WHERE 	
		ca.fec_carrera = %s AND
		ca.nom_hipodromo = hi.nom_hipodromo
	GROUP BY
		hi.nom_hipodromo	
	ORDER BY 
		hi.nom_hipodromo ASC",
         GetSQLValueString($_POST["fecCarrera"], "date")
     );
     $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
     $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
     $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
     if ($totalRows_Recordset4>0) {
         $opciones = '<option value="-1"> SELECCIONE</option>';
         do {
             $opciones.='<option value="'.$row_Recordset4['cod_hipodromo'].'">'.$row_Recordset4['nom_hipodromo'].'</option>';
         } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
     } else {
         $opciones = '<option value="-1"> NO EXISTEN CARRERAS</option>';
         echo"<script>";
         echo"$('#refrescar').bootstrapToggle('off');";
         echo"$('#refrescar').bootstrapToggle('disable');";
         echo"</script>";
     }
     echo $opciones;
 }

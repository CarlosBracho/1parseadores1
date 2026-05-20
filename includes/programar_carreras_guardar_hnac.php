<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$mensaje1="";
$mensaje2="";
if (isset($_POST["cod"]) && isset($_POST["dia"])) {
    include('simple_html_dom.php');
    list($nomHip, $cantCarreras, $hora, $distancia, $NumEjem, $ejeCarr, $jinCarr, $enCarre)=pNacMaqAzul($_POST["dia"]);
    if (isset($cantCarreras) && $cantCarreras>0) {
        $hoy=fechaactualbd();
        for ($i = 1;  $i <= $cantCarreras; $i++) {
            $_POST['num_carrera']=$i;
            $estado=compruebaCarr_hnac($_POST["cod"], $_POST['num_carrera'], $hoy);
            if ($estado==0) {
                $fichero = '../admin_hnac/parseonacionales';
                $nuevo_fichero = '../parseonacionales';

                if (!copy($fichero, $nuevo_fichero)) {
                }
                $fichero = '../admin_hnac/parseonacionaleshora';
                $nuevo_fichero = '../parseonacionaleshora';

                if (!copy($fichero, $nuevo_fichero)) {
                }
                $ho1=convierteHora($hora[$i], 1);
                $hora1=$ho1;
                $nuevahora1 = strtotime('-6 hour', strtotime($hora1)) ;
                $ho = date('H:i:s', $nuevahora1);

                $insertSQL = sprintf(
                    "/* PARSEADORES1 includes\programar_carreras_guardar_hnac.php - QUERY 1 */ INSERT INTO carrera_hnac 
					(cod_hipodromo_hnac, 
					fec_carrera_hnac, 
					hor_carrera_hnac, 
					est_carrera_hnac, 
					est_cierre_hnac, 
					can_caballos_hnac, 
					num_carrera_hnac, 
					dis_carrera_hnac, 
					mtp_control_hnac, 
					est_confirmacion_hnac) 
					VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($_POST["cod"], "int"),
                    GetSQLValueString($hoy, "date"),
                    GetSQLValueString($ho, "date"),
                    GetSQLValueString(5, "int"),
                    GetSQLValueString(5, "int"),
                    GetSQLValueString($enCarre[$i], "int"),
                    GetSQLValueString($i, "int"),
                    GetSQLValueString($distancia[$i], "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString(0, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                
                $query_RecT = "/* PARSEADORES1 includes\programar_carreras_guardar_hnac.php - QUERY 2 */ SELECT cod_carrera_hnac FROM carrera_hnac ORDER BY cod_carrera_hnac DESC LIMIT 1";
                $RecT = mysqli_query($conexionbanca, $query_RecT) or die(mysqli_error($conexionbanca));
                $row_RecT = mysqli_fetch_assoc($RecT);
                $totalRows_RecT = mysqli_num_rows($RecT);
                $codCarrera=$row_RecT['cod_carrera_hnac'];
                
                for ($x = 1;  $x <= $enCarre[$i]; $x++) {	//guarda los ejemplares
                    $insertSQL2 = sprintf(
                        "/* PARSEADORES1 includes\programar_carreras_guardar_hnac.php - QUERY 3 */ INSERT INTO inscritos 
						(cod_carrera_hnac, 
						num_caballo_hnac, 
						nom_caballo_hnac, 
						nom_jinete_hnac, 
						est_inscrito_hnac) 
						VALUES (%s, %s, %s, %s, %s)",
                        GetSQLValueString($codCarrera, "int"),
                        GetSQLValueString($x, "text"),
                        GetSQLValueString($ejeCarr[$i][$x-1], "text"),
                        GetSQLValueString($jinCarr[$i][$x-1], "text"),
                        GetSQLValueString(1, "int")
                    );
                    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                }
            }
        }
        echo '<div style="height:40px;font-size:24px;padding:4px 0px 70px 0px;margin:150px 0px 0px 4px;';
        echo 'color:#393;text-align:center">';
        echo "DATOS GUARDADOS CORECTAMENTE ";
        echo ' <i class="fa fa fa-check fa-2x"></i>';
        echo '</div>';
    }
}
if ($mensaje1!="") {
    echo '<font size="1" face="verdana" color="green">'.$mensaje1.'<br/></font>';
}
echo '<font size="1" face="verdana" color="red">'.$mensaje2.'</font>';

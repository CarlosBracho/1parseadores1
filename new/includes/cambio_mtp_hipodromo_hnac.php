<?php ?><?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (isset($_POST["codCar"]) && isset($_POST["modo"])) {
    $query_Recordset2 = sprintf("/* PARSEADORES1 new\includes\cambio_mtp_hipodromo_hnac.php - QUERY 1 */ SELECT cod_hipodromo_hnac, nom_hipodromo_hnac FROM hipodromo_hnac 
	WHERE cod_hipodromo_hnac = %s", GetSQLValueString($_POST["codCar"], "int"));
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    if ($totalRows_Recordset2>0) {
        if ($_POST["modo"]==0) {
            $modo="MODO MANUAL ";
        }
        if ($_POST["modo"]==1) {
            $modo="MTP MAQUINA AZUL ";
        }
        if ($_POST["modo"]==2) {
            $modo="MTP TU HIPISMO ";
        }
        $nom_usuario=$_SESSION['MM_nom_usuario'];
        $nom_hipodro=$row_Recordset2['nom_hipodromo_hnac'];
        
        $updateSQL2 = sprintf(
            "/* PARSEADORES1 new\includes\cambio_mtp_hipodromo_hnac.php - QUERY 2 */ UPDATE hipodromo_hnac SET bus_resultado_hnac=%s, bus_inscrito_hnac=%s, bus_retirado_hnac=%s 
				  WHERE cod_hipodromo_hnac=%s",
            GetSQLValueString($_POST["modo"], "int"),
            GetSQLValueString($_POST["modo"], "int"),
            GetSQLValueString($_POST["modo"], "int"),
            GetSQLValueString($_POST["codCar"], "int")
        );
        $Result2 = mysqli_query($conexionbanca, $updateSQL2) or die(mysqli_error($conexionbanca));
        $des="CAMBIO A ".$modo."<strong> ".$nom_hipodro."</strong> por: <u>".$nom_usuario."</u> desde módulo hipodromo";
        $insertSQL3 = sprintf(
            "/* PARSEADORES1 new\includes\cambio_mtp_hipodromo_hnac.php - QUERY 3 */ INSERT 
						INTO bitacora 
						(des_bitacora, hor_bitacora, fec_bitacora) 
						VALUES (%s, %s, %s)",
            GetSQLValueString($des, "text"),
            GetSQLValueString(horaactual(), "date"),
            GetSQLValueString(fechaactualbd(), "date")
        );
        $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));

        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\includes\cambio_mtp_hipodromo_hnac.php - QUERY 4 */ SELECT carrera.cod_carrera_hnac, carrera.num_carrera_hnac, 
		carrera.est_carrera_hnac, hipodromo.nom_hipodromo_hnac FROM carrera_hnac, hipodromo_hnac 
		WHERE hipodromo.cod_hipodromo_hnac=carrera.cod_hipodromo_hnac AND carrera.fec_carrera = %s",
            GetSQLValueString(fechaactualbd(), "date")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        if ($totalRows_Recordset1>0) {
            $s=0;
            do {
                $cod=$row_Recordset1['cod_carrera_hnac'];
                $est=$row_Recordset1['est_carrera_hnac'];
                $num=$row_Recordset1['num_carrera_hnac'];
                if ($est==0) {
                    $modo=$modo." (con estado de carrera CERRADA) ";
                } else {
                    $modo=$modo." (con estado de carrera ABIERTA) ";
                }
                
                
                if ($_POST["modo"]==0 || $_POST["modo"]==1 || $_POST["modo"]==2) {
                    $updateSQL1 = sprintf(
                        "/* PARSEADORES1 new\includes\cambio_mtp_hipodromo_hnac.php - QUERY 5 */ UPDATE carrera_hnac SET mtp_control_hnac=%s 
							  WHERE cod_carrera_hnac=%s",
                        GetSQLValueString($_POST["modo"], "int"),
                        GetSQLValueString($cod, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $updateSQL1) or die(mysqli_error($conexionbanca));
                    $des1="CAMBIO A ".$modo."<strong> ".$nom_hipodro." Carr...".$num."</strong> por: <u>".$nom_usuario."</u>";
                    $des2=" desde módulo hipodromo";
                    $des=$des1.$des2;
                    $insertSQL12 = sprintf(
                        "/* PARSEADORES1 new\includes\cambio_mtp_hipodromo_hnac.php - QUERY 6 */ INSERT 
									INTO bitacora 
									(des_bitacora, hor_bitacora, fec_bitacora) 
									VALUES (%s, %s, %s)",
                        GetSQLValueString($des, "text"),
                        GetSQLValueString(horaactual(), "date"),
                        GetSQLValueString(fechaactualbd(), "date")
                    );
                    $Result12 = mysqli_query($conexionbanca, $insertSQL12) or die(mysqli_error($conexionbanca));
                }
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        }
    }
}
?>
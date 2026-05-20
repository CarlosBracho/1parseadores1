<?php
require_once('../Connections/conexionbanca.php');
$fecha=fechaactualbd();
$menosdias=date("Y-m-d",strtotime($fecha."- 425 days")); 

$deleteSQL2 = sprintf(
    "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 1 */ DELETE
    FROM
    venta
    WHERE fec_venta<%s",
    GetSQLValueString($menosdias, "date"));
    $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));

    $deleteSQL2 = sprintf(
        "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 2 */ DELETE
        FROM
        venta_hnac
        WHERE fec_venta_hnac<%s",
        GetSQLValueString($menosdias, "date"));
        $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
        
        $deleteSQL2 = sprintf(
            "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 3 */ DELETE
            FROM
            chat2
            WHERE sentdate<%s",
            GetSQLValueString($menosdias, "date"));
            $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
          
            $deleteSQL2 = sprintf(
                "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 4 */ DELETE
                FROM
                chat7
                WHERE sentdate<%s",
                GetSQLValueString($menosdias, "date"));
                $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
            
                $deleteSQL2 = sprintf(
                    "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 5 */ DELETE
                    FROM
                    bitacora
                    WHERE fec_bitacora<%s",
                    GetSQLValueString($menosdias, "date"));
                    $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
                    
                    $deleteSQL2 = sprintf(
                        "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 6 */ DELETE
                        FROM
                        retirados
                        WHERE fec_retirado<%s",
                        GetSQLValueString($menosdias.' 00:00:00', "date"));
                        $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
                        
                        $deleteSQL2 = sprintf(
                            "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 7 */ DELETE
                            FROM
                            reimpresion
                            WHERE fec_reimpresion<%s",
                            GetSQLValueString($menosdias, "date"));
                            $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
                            
                            $deleteSQL2 = sprintf(
                                "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 8 */ DELETE
                                FROM
                                resultados_hnac
                                WHERE fec_resultado_hnac<%s",
                                GetSQLValueString($menosdias, "date"));
                                $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
                                
                                $deleteSQL2 = sprintf(
                                    "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 9 */ DELETE
                                    FROM
                                    inscritos
                                    WHERE fecha_inscritos<%s",
                                    GetSQLValueString($menosdias.' 00:00:00', "date"));
                                    $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
                                                                                                  
                                    $deleteSQL2 = sprintf(
                                        "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 10 */ DELETE
                                        FROM
                                        carrera_hnac
                                        WHERE fec_carrera_hnac<%s",
                                        GetSQLValueString($menosdias, "date"));
                                        $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
                                        
                                        $deleteSQL2 = sprintf(
                                            "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 11 */ DELETE
                                            FROM
                                            carrera
                                            WHERE fec_carrera<%s",
                                            GetSQLValueString($menosdias, "date"));
                                            $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
                                            
                                            $deleteSQL2 = sprintf(
                                                "/* PARSEADORES1 includes\bd_borradoautomatico.php - QUERY 12 */ DELETE
                                                FROM
                                                quiencierrayabre
                                                WHERE fechaquien<%s",
                                                GetSQLValueString($menosdias, "date"));
                                                $Result2 = mysqli_query($conexionbanca, $deleteSQL2) or die(mysqli_error($conexionbanca));
                                                                 
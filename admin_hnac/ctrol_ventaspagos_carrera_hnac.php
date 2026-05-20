<?php
require_once('../Connections/conexionbanca.php');
 if (isset($_POST["cCar"]) && isset($_POST["cambio"]) && isset($_POST["pV"])) {
     if ($_POST["pV"]=="P" or $_POST["pV"]=="V") {
         if ($_POST["cambio"]==0) {
             $cambio=1;
         } else {
             $cambio=0;
         }
         if ($_POST["pV"]=="P") {
             $insertSQL1 = sprintf(
                 "/* PARSEADORES1 admin_hnac\ctrol_ventaspagos_carrera_hnac.php - QUERY 1 */ UPDATE carrera_hnac
					SET
						pau_pagos_hnac=%s 
					WHERE cod_carrera_hnac=%s",
                 GetSQLValueString($cambio, "int"),
                 GetSQLValueString($_POST["cCar"], "int")
             );
             $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
         }
         if ($_POST["pV"]=="V") {
             $insertSQL1 = sprintf(
                 "/* PARSEADORES1 admin_hnac\ctrol_ventaspagos_carrera_hnac.php - QUERY 2 */ UPDATE carrera_hnac
					SET
						pau_ventas_hnac=%s 
					WHERE cod_carrera_hnac=%s",
                 GetSQLValueString($cambio, "int"),
                 GetSQLValueString($_POST["cCar"], "int")
             );
             $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
         }
     }
 }

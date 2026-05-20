<?php
include("../includes/comprobar_acceso.php");
$hor=horaactual();
$fec=fechaactualbd();
$usuarioVenta=$_SESSION['MM_id_usuario'];
$query_Recordset6 = sprintf("/* PARSEADORES1 new\ventas_macuare\index_datos.php - QUERY 1 */ SELECT 
	tp.est_ven_macu
	FROM usuario us, taquilla_opc_hnac tp 
	WHERE tp.cod_taquilla = us.cod_taquilla AND us.id_usuario = %s LIMIT 1", GetSQLValueString($usuarioVenta, "int"));
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);
if (($totalRows_Recordset6>0 && $row_Recordset6['est_ven_macu']==0) or $totalRows_Recordset6<=0) {
    if ($totalRows_Recordset6<=0) {
        $_SESSION['MM_systemO']=6;
    } elseif ($row_Recordset6['est_ven_macu']==0) {
        $_SESSION['MM_systemO']=7;
    }
    $MM_redirectLoginSuccess = "../no_opciones.php";
    header("Location: ".$MM_redirectLoginSuccess);
}
if (isset($Recordset6)) {
    mysqli_free_result($Recordset6);
}

$selCarrera="";
$editFormAction = $_SERVER['PHP_SELF'];
$query_Recordset4 = "/* PARSEADORES1 new\ventas_macuare\index_datos.php - QUERY 2 */ SELECT * FROM mensaje WHERE cod_mensaje = 1";
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
if ($row_Recordset4['est_mensaje']==1) {
    $mensaje1=$row_Recordset4['pri_linea'];
} else {
    $mensaje1="";
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
    $grabar=30;
    $in=$_POST['CC_inicial'];
    $jugada="";
    $carrer="";
    $n=0;
    for ($s = $_POST["cod_carrera"]; $s <= $_POST["cod_carrera"]+5; $s++) {
        list($sRetiro, $cod)=RetiradosSimple_macu($s, $_POST[$s]);
        list($xEstado, $numCa)=verifica_carrera_hnac($s);
        if ($sRetiro==0 && $xEstado!=1) {
            if ($n==0) {
                $delimita="";
            } else {
                $delimita="-";
            }
            $jugada=$jugada.$delimita.$_POST[$s];
            $carrer=$carrer.$delimita.$s;
            $n++;
        } else {
            if ($sRetiro==1 or $sRetiro==-1) {
                $iR=1;
                $grabar--;
                $_SESSION['MM_mensaje2']="Existen ejemplares retirados en la jugada - Carr:".$numCa." #".$_POST[$s]." - APUESTA NO REALIZADA!";
                break;
            }
            if ($xEstado==1) {
                $iR=1;
                $grabar--;
                $_SESSION['MM_mensaje2']="VENTA CERRADA - APUESTA NO REALIZADA!";
                break;
            }
        }
    }
    $canTicketIg=50000;//CANTIDAD DE TICKET IGUALES
    list($ticIgual, $tVendido)=toTicIgual_macu($_POST["codTaq"], $jugada, fechaactualbd(), 1);//busca ticket iguales
    if (($ticIgual+1)>$canTicketIg) {
        $iR=1;
        $_SESSION['MM_mensaje2']="Supera la cantidad de ticket iguales<br/>TICKET NO GUARDADO";
        $grabar--;
    }
    if ($_POST["monto"]<=0) {
        $iR=1;
        $_SESSION['MM_mensaje2']="Indique monto de apuesta<br/>TICKET NO GUARDADO";
        $grabar--;
    } else {
        if ($_POST["monto"]<$_POST["apu_min_macu"]) {
            $iR=1;
            $grabar--;
            $_SESSION['MM_mensaje2']="Monto minimo permitido:".$_POST["apu_min_macu"]."<br/>TICKET NO GUARDADO";
        } else {
            if ($_POST["monto"]>$_POST["apu_max_macu"]) {
                $iR=1;
                $grabar--;
                $_SESSION['MM_mensaje2']="Monto maximo permitido:".$_POST["apu_max_macu"]."<br/>TICKET NO GUARDADO";
            } else {
                $limVenta=$tVendido+$_POST["monto"];
                if ($limVenta>$_POST["lim_max_macu"]) {
                    $iR=1;
                    $grabar--;
                    $limite=$_POST["lim_max_macu"]-$tVendido;
                    if ($limite<=0) {
                        $_SESSION['MM_mensaje2']="Supera el monto de ticket iguales<br/>TICKET NO GUARDADO";
                    }
                    if ($limite>0) {
                        $_SESSION['MM_mensaje2']="Monto maximo permitido:".$limite."<br/>TICKET NO GUARDADO";
                    }
                }
            }
        }
    }
    if ($grabar==30) {
        $codVe=1;
        $hoTxt=horaactual();
        $FeTxt=fechaactualbd();
        $ipVen=getRealIP();
        $cdTaq=$_POST["codTaq"];
        $usVen=$_POST['codUsu'];
        $xMonA=$_POST["monto"];
        $xDivP=$_POST["div_pago"];
        $codIn=$_POST["cod_carrera"];//codigo inicio de carreras validas
        $caTic=ObtenerNumeroJugada_macu($usVen, $FeTxt, $codVe)+1;
        $ntick=$usVen.ObtenerUltimaVenta_macu();
        $serTi=generarCodigo(5, $ntick);
        $aPagar=$xDivP*$xMonA;
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\ventas_macuare\index_datos.php - QUERY 3 */ INSERT INTO venta_macu (ser_venta_macu, ticket_macu, fec_venta_macu, 
			 hor_venta_macu, cod_tventa_macu, num_caballo_macu, mon_venta_macu, cod_carrera_hnac, id_usuario, 
			 est_ticket_macu, can_ticket_macu, ip_venta_macu, est_calculo_macu, pag_premio_macu) 
			 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($serTi, "text"),
            GetSQLValueString($ntick, "int"),
            GetSQLValueString($FeTxt, "date"),
            GetSQLValueString($hoTxt, "date"),
            GetSQLValueString($codVe, "int"),
            GetSQLValueString($jugada, "text"),
            GetSQLValueString($xMonA, "double"),
            GetSQLValueString($codIn, "int"),
            GetSQLValueString($usVen, "int"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($caTic, "int"),
            GetSQLValueString($ipVen, "text"),
            GetSQLValueString(0, "int"),
            GetSQLValueString($aPagar, "int")
        );
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $_SESSION['MM_mensaje2']="APUESTA REALIZADA CORRECTAMENTE!";
        $insertGoTo = "t_imprimeticket_mac.php?recordID=$ntick&uVenta=$usVen";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        } else {
            $insertGoTo = "index.php";
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
$query_Recordset6 = sprintf(
    "/* PARSEADORES1 new\ventas_macuare\index_datos.php - QUERY 4 */ SELECT 
		ta.cod_taquilla, ta.nom_taquilla, 
		us.nom_completo, tp.pag_codigo_hnac,
		tp.est_ven_rin_macu, tp.est_ven_val_macu,
		tp.est_ven_san_macu, tp.est_ven_ran_macu,
		tp.est_ven_macu, tp.apu_min_macu,
		tp.apu_max_macu, tp.lim_max_macu,
		tp.apu_cor_macu, tp.div_ofi_macu
		FROM 
			usuario us, 
			taquilla ta, 
			taquilla_opc_hnac tp 
		WHERE 
			us.id_usuario = %s AND 
			us.cod_taquilla = ta.cod_taquilla AND
			tp.cod_taquilla = us.cod_taquilla
		LIMIT 1",
    GetSQLValueString($usuarioVenta, "int")
);
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);
$taquilla=$row_Recordset6['cod_taquilla'];
$pedirCodigoPago=$row_Recordset6['pag_codigo_hnac'];
$est_ven_macu=$row_Recordset6['est_ven_macu'];
$est_ven_rin_macu=$row_Recordset6['est_ven_rin_macu'];
$est_ven_val_macu=$row_Recordset6['est_ven_val_macu'];
$est_ven_san_macu=$row_Recordset6['est_ven_san_macu'];
$est_ven_ran_macu=$row_Recordset6['est_ven_ran_macu'];
$apu_min_macu=$row_Recordset6['apu_min_macu'];
$apu_max_macu=$row_Recordset6['apu_max_macu'];
$lim_max_macu=$row_Recordset6['lim_max_macu'];
$apu_cor_macu=$row_Recordset6['apu_cor_macu'];
$div_ofi_macu=$row_Recordset6['div_ofi_macu'];
$estVenta=1;
$hor=horaactual();
$fec=fechaactualbd();
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 new\ventas_macuare\index_datos.php - QUERY 5 */ SELECT 
		ca.cod_carrera_hnac, 
		ca.can_caballos_hnac, 
		ca.num_carrera_hnac,
		ca.hor_carrera_hnac, 
		ca.est_cierre_hnac,
		hi.nom_hipodromo_hnac,
		hi.cod_hipodromo_hnac
		FROM 
			carrera_hnac ca,
			hipodromo_hnac hi
		WHERE
			hi.cod_hipodromo_hnac = ca.cod_hipodromo_hnac AND
			ca.fec_carrera_hnac = %s
		ORDER BY ca.num_carrera_hnac",
    GetSQLValueString($fec, "date")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$validas=0;
$tieVenta=0;
$nom_hipodromo="";
$div_pago=-2;
if ($totalRows_Recordset3>5) {
    $validas=$totalRows_Recordset3-6;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\ventas_macuare\index_datos.php - QUERY 6 */ SELECT 
			ca.cod_carrera_hnac, 
			ca.can_caballos_hnac, 
			ca.num_carrera_hnac,
			ca.hor_carrera_hnac,
			ca.est_cierre_hnac, 
			hi.nom_hipodromo_hnac,
			hi.cod_hipodromo_hnac
			FROM 
				carrera_hnac ca,
				hipodromo_hnac hi
			WHERE
				hi.cod_hipodromo_hnac = ca.cod_hipodromo_hnac AND
				ca.fec_carrera_hnac = %s
			ORDER BY ca.num_carrera_hnac ASC 
			LIMIT $validas, 7",
        GetSQLValueString($fec, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $nom_hipodromo=$row_Recordset1['nom_hipodromo_hnac'];
    $codi=$row_Recordset1['cod_carrera_hnac'];
    if ($row_Recordset1['est_cierre_hnac']==1 or $row_Recordset1['est_cierre_hnac']==0 or $totalRows_Recordset1!=6) {
        $tieVenta=0;
    } else {
        $tieVenta=1;
    }
    if ($div_ofi_macu==1) {
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 new\ventas_macuare\index_datos.php - QUERY 7 */ SELECT div_pago_macu FROM div_oficiales_macu
				WHERE fec_dividendo_macu = %s AND cod_tventa_macu=1 LIMIT 1",
            GetSQLValueString($fec, "date")
        );
        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
        if ($totalRows_Recordset11>0) {
            $div_pago=$row_Recordset11['div_pago_macu'];
        } else {
            $div_pago=0;
        }
    } else {
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 new\ventas_macuare\index_datos.php - QUERY 8 */ SELECT 
				div_pago_macu
				FROM
					div_taquilla_macu
				WHERE
					fec_dividendo_macu = %s AND cod_tventa_macu=1 AND cod_taquilla = %s LIMIT 1",
            GetSQLValueString($fec, "date"),
            GetSQLValueString($taquilla, "int")
        );
        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
        if ($totalRows_Recordset11>0) {
            $div_pago=$row_Recordset11['div_pago_macu'];
        } else {
            $div_pago=-1;
        }
    }
    $query_Recordset15 = sprintf(
        "/* PARSEADORES1 new\ventas_macuare\index_datos.php - QUERY 9 */ SELECT 
			ca.cod_carrera_hnac
			FROM 
				carrera_hnac ca
			WHERE
				est_confirmacion_hnac!=1 AND
				est_cierre_hnac!=0 AND
				est_carrera_hnac!=0 AND
				ca.fec_carrera_hnac = %s AND
				ca.cod_carrera_hnac >= %s
			ORDER BY ca.num_carrera_hnac ASC",
        GetSQLValueString($fec, "date"),
        GetSQLValueString($codi, "date")
    );
    $Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
    $row_Recordset15 = mysqli_fetch_assoc($Recordset15);
    $totalRows_Recordset15 = mysqli_num_rows($Recordset15);
    if ($totalRows_Recordset15<6) {
        $estVenta=0;
    }
}
if ($est_ven_macu==0) {
    $estVenta=0;
} else {
    if ($apu_cor_macu==0) {
        $estVenta=0;
    } else {
        if ($nom_hipodromo=="LA RINCONADA") {
            if ($est_ven_rin_macu==0) {
                $estVenta=0;
            }
        }
        if ($nom_hipodromo=="VALENCIA") {
            if ($est_ven_val_macu==0) {
                $estVenta=0;
            }
        }
        if ($nom_hipodromo=="SANTA RITA") {
            if ($est_ven_san_macu==0) {
                $estVenta=0;
            }
        }
        if ($nom_hipodromo=="RANCHO ALEGRE") {
            if ($est_ven_ran_macu==0) {
                $estVenta=0;
            }
        }
    }
}
if ($estVenta==0) {
    $mensaje1="EL HIPODROMO CON CARRERAS ABIERTAS EN ESTE MOMENTO";
    $_SESSION['MM_mensaje2']=" NO ESTA SIENDO BANQUEADO POR EL AGENTE";
}
$iR=0;
$insertGoTo = "index.php";
if (isset($iR) && $iR==1) {
    header(sprintf("Location: %s", $insertGoTo));
} else {
    $iR=0;
}

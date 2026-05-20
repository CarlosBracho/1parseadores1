<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (is_file('../includes/calculodepago_hnac.php')) {
    include("../includes/calculodepago_hnac.php");
}
//cierre_procesar_apuestas_hnac.php
if (isset($_POST["idUs"])) {
    $usT=$_POST["idUs"];
    $car=$_POST["idCa"];
}
$query_Recordset8 = sprintf(
    "/* PARSEADORES1 new\ventashnac_mie\cierre_procesar_apuestas_hnac.php - QUERY 1 */ SELECT cod_taquilla
	FROM usuario 
	WHERE id_usuario = %s LIMIT 1",
    GetSQLValueString($usT, "int")
);
$Recordset8 = mysqli_query($conexionbanca, $query_Recordset8) or die(mysqli_error($conexionbanca));
$row_Recordset8 = mysqli_fetch_assoc($Recordset8);
$totalRows_Recordset8 = mysqli_num_rows($Recordset8);
if ($totalRows_Recordset8>0 && isset($_POST["idUs"]) && isset($_POST["idCa"])) {
    $taq=$row_Recordset8['cod_taquilla'];
    $fec=fechaactualbd();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\ventashnac_mie\cierre_procesar_apuestas_hnac.php - QUERY 2 */ SELECT 
		ve.num_ticket_hnac, ve.mon_venta_hnac, ve.cod_tventa_hnac, ca.est_cierre_hnac, ve.num_caballo_hnac, tp.cab_min_hnac
		FROM 
		venta_hnac ve, 
		carrera_hnac ca, 
		usuario us,
		taquilla_opc_hnac tp
		WHERE 
		ve.cod_carrera_hnac = %s AND
		tp.cod_taquilla = %s AND
		ve.fec_venta_hnac = %s AND
		ve.est_ticket_hnac = 1 AND
		ve.id_usuario = us.id_usuario AND
		us.cod_taquilla  = tp.cod_taquilla AND 
		ca.cod_carrera_hnac = ve.cod_carrera_hnac",
        GetSQLValueString($car, "int"),
        GetSQLValueString($taq, "int"),
        GetSQLValueString($fec, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $montoapagar=0;
        $query_Recordset13 = sprintf("/* PARSEADORES1 new\ventashnac_mie\cierre_procesar_apuestas_hnac.php - QUERY 3 */ SELECT num_caballo_hnac FROM resultados_oficiales_hnac WHERE 
			cod_carrera_hnac = %s", GetSQLValueString($car, "int"));
        $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
        $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
        $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
        if ($totalRows_Recordset13>0) {
            $retirados=arrayRetiradosHNAC($car);
            $editFormAction = $_SERVER['PHP_SELF'];
            $montoapagar=0;
            $montoretiro=0;
            $i=0;
            $estado=array(0);
            $x_nTicket=array(0);
            $x_pagoSencillo=array(0);
            $cabMin=$row_Recordset1['cab_min_hnac'];
            $tEjem=enCarrera_HNAC($car);//ejemplares en carrera
            if ($row_Recordset1['est_cierre_hnac']!=0 && $tEjem>=$cabMin) {
                do {
                    $pago[0]=0;
                    $pago[1]="";
                    $retiro=0;
                    if ($retirados[0]!="0") {
                        if (in_array($row_Recordset1['num_caballo_hnac'], $retirados, true)) {
                            $retiro=1;
                        }
                        if ($row_Recordset1['cod_tventa_hnac']>=4 && $row_Recordset1['cod_tventa_hnac']<=9) {
                            $fcab=explode("-", $row_Recordset1['num_caballo_hnac']);
                            foreach ($fcab as $mtz1) {
                                if (in_array($mtz1, $retirados, true)) {
                                    $retiro=1;
                                    break;
                                }
                            }
                        }
                    }
                    if ($retiro==0) {
                        if ($row_Recordset1['cod_tventa_hnac']>=1 && $row_Recordset1['cod_tventa_hnac']<=3) {
                            $numCab=$row_Recordset1['num_caballo_hnac'];
                            $tipVenta=$row_Recordset1['cod_tventa_hnac'];
                            $monVenta=$row_Recordset1['mon_venta_hnac'];
                            $pago=jNormaSimpleHNAC($numCab, $car, $fec, $monVenta, $taq, $tipVenta);
                            if ($pago[0]>0) {
                                $montoapagar=$pago[0]+$montoapagar;
                                $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                                $estado[$i]=$pago[1];
                                $x_pagoSencillo[$i]=$pago[0];
                                $i=$i+1;
                            } else {
                                $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                                $estado[$i]=1;
                                $x_pagoSencillo[$i]=0;
                                $i=$i+1;
                            }
                        }
                    } else {
                        $montoretiro=$montoretiro+$row_Recordset1['mon_venta_hnac'];
                        $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                        $estado[$i]="4";
                        $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                        $i=$i+1;
                    }
                } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
            } else {
                if ($tEjem<$cabMin) {
                    do {
                        $montoapagar=$montoapagar+$row_Recordset1['mon_venta_hnac'];
                        $x_nTicket[$i]=$row_Recordset1['num_ticket_hnac'];
                        $estado[$i]="5";
                        $x_pagoSencillo[$i]=$row_Recordset1['mon_venta_hnac'];
                        $i=$i+1;
                    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                }
            }
            $x=0;
            do {
                $updateSQL = sprintf(
                    "/* PARSEADORES1 new\ventashnac_mie\cierre_procesar_apuestas_hnac.php - QUERY 4 */ UPDATE venta_hnac 
					SET pag_premio_hnac=%s, est_calculo_hnac=%s 
					WHERE num_ticket_hnac=%s",
                    GetSQLValueString($x_pagoSencillo[$x], "double"),
                    GetSQLValueString($estado[$x], "int"),
                    GetSQLValueString($x_nTicket[$x], "int")
                );
                $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                $x++;
            } while ($x < $i);
        } else {// no hay resultados cargados
        }
    } else {// no hay ventas en esta carrera
        //echo "No hay ventas en esta carrera";
    }
} else {// usuario no encontrado
    //echo "Usuario no encontrado";
}
if (isset($Recordset1)) {
    mysqli_free_result($Recordset1);
}
if (isset($Recordset13)) {
    mysqli_free_result($Recordset13);
}
if (isset($Recordset8)) {
    mysqli_free_result($Recordset8);
}

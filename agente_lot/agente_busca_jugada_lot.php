<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$cod_agencia = $_SESSION['MM_cod_agencia'];
$xserTic="";
$xTicket_Recordset1="";
$usuarioPago="";
$hoy=fechaactualbd();
if (isset($_POST["pagarT"])) {
    $xTicket_Recordset1 = $_POST["pagarT"];
    $xTicket_Recordset1=substr($xTicket_Recordset1, 2, (strlen($xTicket_Recordset1)-2));
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 agente_lot\agente_busca_jugada_lot.php - QUERY 1 */ SELECT 
	ta.nom_taquilla,
	ve.fec_venta_lot,
	ve.hor_venta_lot,
	ve.ticket_lot,
	ve.ser_ticket_lot,
	ve.id_loteria,
	ve.ip_venta_lot,
	ve.tip_loteria_lot,
	ve.id_signo,
	ve.num_apuesta_lot,
	ve.mon_apuesta_lot,
	ve.can_ticket_lot,
	ve.pag_premio_lot,
	ve.est_ticket_lot,
	ve.est_calculo_lot,
	us.nom_completo,
	tp.anc_ticket_lot,
	tp.lar_ticket_lot,
	tp.tip_ticket_lot,
	tp.tic_caduca_lot,
	us.cod_barra,
	lt.nom_loteria,
	ba.hor_cierre,
	CASE lt.tip_loteria  
		WHEN 3 THEN (/* PARSEADORES1 agente_lot\agente_busca_jugada_lot.php - QUERY 2 */ SELECT sor.nom_corto FROM signos sor WHERE sor.id_signo = ve.id_signo LIMIT 1)
		WHEN 4 THEN (/* PARSEADORES1 agente_lot\agente_busca_jugada_lot.php - QUERY 3 */ SELECT ani.nom_corto FROM animales ani WHERE ani.id_animal = ve.id_signo LIMIT 1)
		ELSE ''
	END AS nsigno
	FROM 
		venta_lot ve,
		loterias lt,
		bancaloterias ba,
		agencia ag,
		taquilla ta,
		taquilla_opc_lot tp,
		usuario us
	WHERE 
		ve.ticket_lot = %s AND us.id_usuario = ve.id_usuario AND
		us.cod_taquilla = ta.cod_taquilla AND 
		tp.cod_taquilla = ta.cod_taquilla AND lt.id_loteria = ve.id_loteria AND
		ta.cod_agencia = ag.cod_agencia AND ba.id_banca = ag.cod_banca AND
		ba.id_loteria = ve.id_loteria AND ag.cod_agencia = %s
	ORDER BY hor_venta_lot ASC, id_loteria ASC, num_apuesta_lot ASC",
    GetSQLValueString($xTicket_Recordset1, "int"),
    GetSQLValueString($cod_agencia, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$pag_premio=0;$nopro=0;$sipro=0;$premi=0;$devue=0;$pcobr=0;$pdevu=0;$elimi=0;
do {
    if ($row_Recordset2['est_calculo_lot']==0) {
        $nopro+=1;
    } elseif ($row_Recordset2['est_calculo_lot']==1) {
        $sipro+=1;
    } elseif ($row_Recordset2['est_calculo_lot']==2) {
        $premi+=1;
        $pag_premio+=$row_Recordset2['pag_premio_lot'];
    } elseif ($row_Recordset2['est_calculo_lot']==5) {
        $devue+=1;
        $pag_premio+=$row_Recordset2['pag_premio_lot'];
    }
    if ($row_Recordset2['est_ticket_lot']==2) {
        $pcobr+=1;
    } elseif ($row_Recordset2['est_ticket_lot']==0) {
        $elimi+=1;
    } elseif ($row_Recordset2['est_ticket_lot']==5) {
        $pdevu+=1;
    }
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
$pag_premio=number_format($pag_premio, 2, ",", ".");
$controlSer=1;
$ver=0;
if ($totalRows_Recordset1>0) {
    if ($xserTic==substr($row_Recordset1['ser_ticket_lot'], 0, 2)) {
        $controlSer=1;
    }
    $serial=$row_Recordset1['ser_ticket_lot'];
    $estadoCodBarra=$row_Recordset1['cod_barra'];
    $rest = substr($serial, 0, 2);
    $rest = $rest.$xTicket_Recordset1;
    $tic_caduca=$row_Recordset1['tic_caduca_lot'];
    $mar=$row_Recordset1['anc_ticket_lot']*40;
    $largo=$row_Recordset1['lar_ticket_lot']+1;
    $cod=0;
    $columnas=1;
    $filas=0;
    $sig=0;
    $montoapagar=0;
    $status='';
    $status2='';
    if ($elimi>0) {
        $status='TICKET ELIMINADO';
    } else {
        if ($pcobr>0 or $pdevu>0) {
            if ($pcobr>0&&$pdevu>0) {
                $status='<font color="GREEN">GANADOR+DEVOLUCION<br/>YA PAGADO<br/>Monto: '.$pag_premio.'</font>';
            } else {
                if ($pcobr>0&&$pdevu==0) {
                    $status='TICKET YA PAGADO<br/>Monto: '.$pag_premio;
                } elseif ($pcobr==0&&$pdevu>0) {
                    $status='<font color="GREEN">DEVOLUCION YA PAGADA<br/>Monto: '.$pag_premio.'</font>';
                }
            }
        } elseif ($nopro==$totalRows_Recordset2) {
            $status='TICKET AUN NO PROCESADO';
        } elseif ($sipro==$totalRows_Recordset2) {
            $status='TICKET NO GANADOR';
        } elseif ($premi>0&&$devue==0) {
            $status='<font color="GREEN">GANADOR<br/>Monto: '.$pag_premio.'</font>';
        } elseif ($premi==0&&$devue>0) {
            $status='<font color="GREEN">DEVOLUCION<br/>Monto: '.$pag_premio.'</font>';
        } elseif ($premi>0&&$devue>0) {
            $status='<font color="GREEN">GANADOR+DEVOLUCION<br/>Monto: '.$pag_premio.'</font>';
        }
        //--------------------------------------
        if ($nopro>0&&$nopro<$totalRows_Recordset2) {
            $status2='AUN POSEE JUGADA(S) SIN PROCESAR';
        }
    }
    print '<div style="background:#FFFFFF;height:500px;margin:0 0 0 100px;width:230px;text-align:left;">';
    print '<div id="printtitle" align="left" style="text-align:left;width:210px; background:#DDDDDD;padding:0 0 0 20px;overflow:auto; height:420px">';
    switch ($row_Recordset1['tip_ticket_lot']) {
                case 0: include("../ventaslot/ticket_copia_lot0.php"); break;
                case 1: include("../ventaslot/ticket_copia_lot1.php"); break;
                default:include("../ventaslot/ticket_0_lot.php"); break;
            }
    print "</div>";
    print "<strong>Total pagado: ".number_format($montoapagar, 2, ",", ".")."</strong>";
    print '<br/><br/><p style="font-size:14px;color:#CC0000;text-align:center;"><strong>'.$status.'</strong></p>';
    print '<p style="font-size:14px;color:#CC0000;text-align:center;"><strong>'.$status2.'</strong></p>';
    print "</div>";
} else {
    echo '<br/><br/><br/><p style="font-size:20px;color:#CC0000;"><strong>TICKET NO ENCONTRADO!</strong></p>';
}
mysqli_free_result($Recordset1);

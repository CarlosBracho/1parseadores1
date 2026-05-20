<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//include ("file.php");
require_once('../Connections/conexionbanca.php');






$fechasistema=fechaactualbd();
$fi=fechaactualbd();

//esats dos lineas se tieen que eliminar
$fi = strtotime('-2 day', strtotime($fechasistema));
$fi = date('Y-m-d', $fi);



//colocar 7 en ves de 8
$fechasistemamenos7 = strtotime('-8 day', strtotime($fechasistema));
$fechasistemamenos7 = date('Y-m-d', $fechasistemamenos7);
$in=$fechasistemamenos7;

$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$fechasistemamenos7x = strtotime('-8 day', strtotime($fechasistema));

$dias2=date("w", $fechasistemamenos7x);
echo ' '.$dias[$dias2].' ';
echo 'fecha inicio '.$in.'<br>';
$fix = strtotime('-2 day', strtotime($fechasistema));
$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");
$dias2=date("w", $fix);
echo ' '.$dias[$dias2].' ';
echo 'fecha fin '.$fi.'<br>';
$query_Recordset555 = sprintf("/* PARSEADORES1 admin\1cobro_directo.php - QUERY 1 */ SELECT * FROM tasadecambio WHERE Idtasadecambio = 1");
$Recordset555 = mysqli_query($conexionbanca, $query_Recordset555) or die(mysqli_error($conexionbanca));
$row_Recordset555 = mysqli_fetch_assoc($Recordset555);
$totalRows_Recordset555 = mysqli_num_rows($Recordset555);
echo '<br>';
echo 'Tasa USD '.$row_Recordset555['usdabss'].'<br>';
echo 'Tasa COP '.$row_Recordset555['copabss'].'<br>';
echo 'Tasa SOL '.$row_Recordset555['solabss'].'<br><br>';

$query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 2 */ SELECT  * FROM multidistriMD WHERE cod_multidistriMD >= 2");

$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$md=1;
$total_venta3=0;
$total_ventausd3=0;
$total_ventacop3=0;
$total_ventasol3=0;
echo '---------------------------------Multidistribuidores---------------------------------<br>';
if($totalRows_Recordset1>0){
do {
    $puntosnacionales=0;
echo $md.' * Multidistribuidor '.$row_Recordset1['nom_multidistriMD'].' % '.$row_Recordset1['multi_por_ameMD'].'<br>';


$query_Recordset2 = sprintf(
    "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 3 */ SELECT  * FROM  banca WHERE cod_multidistriMDBA = %s", 
    GetSQLValueString($row_Recordset1['cod_multidistriMD'], "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$dt=1;
$total_venta22=0;
$total_ventausd22=0;
$total_ventacop22=0;
$total_ventasol22=0;

if($totalRows_Recordset2>0){
    do {
       // echo $dt.' ** Distribuidor '.$row_Recordset2['nom_banca'].'<br>';


        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 4 */ SELECT  * FROM  agencia WHERE cod_banca = %s", 
            GetSQLValueString($row_Recordset2['cod_banca'], "int"));
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
        $query_Recordset3n = sprintf(
            "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 5 */ SELECT  * FROM  cobro_hnac WHERE fec_creacion >= %s AND	fec_creacion <= %s AND cod_banca = %s", 
            GetSQLValueString($in, "date"),
            GetSQLValueString($fi, "date"),
            GetSQLValueString($row_Recordset2['cod_banca'], "int"));
        $Recordset3n = mysqli_query($conexionbanca, $query_Recordset3n) or die(mysqli_error($conexionbanca));
        $row_Recordset3n = mysqli_fetch_assoc($Recordset3n);
        $totalRows_Recordset3n = mysqli_num_rows($Recordset3n);



        $ag=1;
        if($totalRows_Recordset3>0){
            $total_venta2=0;
            $total_ventausd2=0;
            $total_ventacop2=0;
            $total_ventasol2=0;
            do {
               // echo $ag.' *** Agencia '.$row_Recordset3['nom_agencia'].'<br>';


                $query_Recordset4 = sprintf(
                    "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 6 */ SELECT  * FROM  taquilla WHERE cod_agencia = %s", 
                    GetSQLValueString($row_Recordset3['cod_agencia'], "int"));
                $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
                $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
                $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
                $tq=1;
                $total_venta=0;
                $total_ventausd=0;
                $total_ventacop=0;
                $total_ventasol=0;
                if($totalRows_Recordset4>0){
                    do {
                   //   echo $tq.' **** taquilla '.$row_Recordset4['nom_taquilla'].'<br>';









                        $query_Recordset5 = sprintf(
                            "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 7 */ SELECT
                             ta.cod_taquilla, ta.nom_taquilla, 
                             ta.taq_por_ame,
                             ag.agen_por_ame,
                             
                             
                             
                 SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2) 
                     THEN ve.mon_venta ELSE 0 END) AS total_venta,
                 SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN ve.pag_premio ELSE 0 END) AS tot_premios,
                 SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN ve.mon_venta ELSE 0 END) AS tot_eliminad,
                 SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN ve.mon_venta ELSE 0 END) AS ret_pagos,
                 SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN ve.mon_venta ELSE 0 END) AS ret_total,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN ve.mon_venta ELSE 0 END) AS ret_porpagar,
                 SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN ve.mon_venta ELSE 0 END) AS inv_pagos,
                 SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN ve.mon_venta ELSE 0 END) AS inv_total,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN ve.mon_venta ELSE 0 END) AS inv_porpagar,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
                 SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                     THEN 1 ELSE 0 END) AS con_tic_eli,
                     
                     
                     SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                     THEN ve.mon_venta ELSE 0 END) AS total_ventausd,
                 SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 3
                     THEN ve.pag_premio ELSE 0 END) AS tot_premiosusd,
                 SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                     THEN ve.mon_venta ELSE 0 END) AS tot_eliminadusd,
                 SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND ve.efectivoO = 3
                     THEN ve.mon_venta ELSE 0 END) AS ret_pagosusd,
                 SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                     THEN ve.mon_venta ELSE 0 END) AS ret_totalusd,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                     THEN ve.mon_venta ELSE 0 END) AS ret_porpagarusd,
                 SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 3
                     THEN ve.mon_venta ELSE 0 END) AS inv_pagosusd,
                 SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                     THEN ve.mon_venta ELSE 0 END) AS inv_totalusd,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 3
                     THEN ve.mon_venta ELSE 0 END) AS inv_porpagarusd,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 3
                     THEN ve.pag_premio ELSE 0 END) AS pre_porpagarusd,
                 SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND ve.efectivoO = 3
                     THEN 1 ELSE 0 END) AS con_tic_eliusd,
                     
                     
                             
                             
                     
                     SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                     THEN ve.mon_venta ELSE 0 END) AS total_ventacop,
                 SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 4
                     THEN ve.pag_premio ELSE 0 END) AS tot_premioscop,
                 SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                     THEN ve.mon_venta ELSE 0 END) AS tot_eliminadcop,
                 SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND ve.efectivoO = 4
                     THEN ve.mon_venta ELSE 0 END) AS ret_pagoscop,
                 SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                     THEN ve.mon_venta ELSE 0 END) AS ret_totalcop,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                     THEN ve.mon_venta ELSE 0 END) AS ret_porpagarcop,
                 SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 4
                     THEN ve.mon_venta ELSE 0 END) AS inv_pagoscop,
                 SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                     THEN ve.mon_venta ELSE 0 END) AS inv_totalcop,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 4
                     THEN ve.mon_venta ELSE 0 END) AS inv_porpagarcop,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 4
                     THEN ve.pag_premio ELSE 0 END) AS pre_porpagarcop,
                 SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND ve.efectivoO = 4
                     THEN 1 ELSE 0 END) AS con_tic_elicop,
                     
                     
                             
     
                             
                     
                     SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                     THEN ve.mon_venta ELSE 0 END) AS total_ventasol,
                 SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 5
                     THEN ve.pag_premio ELSE 0 END) AS tot_premiossol,
                 SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                     THEN ve.mon_venta ELSE 0 END) AS tot_eliminadsol,
                 SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND ve.efectivoO = 5
                     THEN ve.mon_venta ELSE 0 END) AS ret_pagossol,
                 SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                     THEN ve.mon_venta ELSE 0 END) AS ret_totalsol,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                     THEN ve.mon_venta ELSE 0 END) AS ret_porpagarsol,
                 SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 5
                     THEN ve.mon_venta ELSE 0 END) AS inv_pagossol,
                 SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                     THEN ve.mon_venta ELSE 0 END) AS inv_totalsol,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 5
                     THEN ve.mon_venta ELSE 0 END) AS inv_porpagarsol,
                 SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 5
                     THEN ve.pag_premio ELSE 0 END) AS pre_porpagarsol,
                 SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND ve.efectivoO = 5
                     THEN 1 ELSE 0 END) AS con_tic_elisol
                                 
                                 
                                 
                                 
                                 
                                 
                         FROM
                             agencia ag, taquilla ta, taquilla_opc_ame tp, venta ve

                         WHERE (ve.fec_venta >= %s AND ve.fec_venta <= %s OR ve.fec_pago >= %s AND ve.fec_pago <= %s) AND 
                             ag.cod_agencia = ta.cod_agencia AND ta.cod_taquilla = ve.cod_taquilla AND
                             tp.cod_taquilla = ta.cod_taquilla AND ta.cod_taquilla = %s 
                         GROUP BY ta.cod_taquilla 
                         ORDER BY ta.cod_taquilla, ve.fec_venta, ve.num_ticket ASC",
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($in, "date"),
                            GetSQLValueString($fi, "date"),
                            GetSQLValueString($row_Recordset4['cod_taquilla'], "int")
                        );
                        $Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
                        $row_Recordset5 = mysqli_fetch_assoc($Recordset5);
                        $totalRows_Recordset5 = mysqli_num_rows($Recordset5);


if($row_Recordset5['total_venta']>0 OR $row_Recordset5['total_ventausd']>0 OR $row_Recordset5['total_ventacop']>0 OR $row_Recordset5['total_ventasol']>0){
                    //    echo $tq.' ***** BS '.$row_Recordset5['total_venta'].' USD '.$row_Recordset5['total_ventausd'].' COP '.$row_Recordset5['total_ventacop'].' SOL '.$row_Recordset5['total_ventasol'].'<br>';
                        $total_venta=($row_Recordset5['total_venta']+$total_venta)-($row_Recordset5['ret_pagos']+$row_Recordset5['inv_pagos']+$row_Recordset5['tot_eliminad']);
                        $total_ventausd=($row_Recordset5['total_ventausd']+$total_ventausd)-($row_Recordset5['ret_pagosusd']+$row_Recordset5['inv_pagosusd']+$row_Recordset5['tot_eliminadusd']);;
                        $total_ventacop=($row_Recordset5['total_ventacop']+$total_ventacop)-($row_Recordset5['ret_pagoscop']+$row_Recordset5['inv_pagoscop']+$row_Recordset5['tot_eliminadcop']);;
                        $total_ventasol=($row_Recordset5['total_ventasol']+$total_ventasol)-($row_Recordset5['ret_pagossol']+$row_Recordset5['inv_pagossol']+$row_Recordset5['tot_eliminadsol']);;
                    }





                        $tq++;
                    } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
                   
                   
                   if($total_venta>0 OR $total_ventausd>0 OR $total_ventacop>0 OR $total_ventasol>0 OR $total_ventasol>0){
                   // echo $ag.' ***** BS '.$total_venta.' USD '.$total_ventausd.' COP '.$total_ventacop.' SOL '.$total_ventasol.'<br>';
                
                    $total_venta2=$total_venta+$total_venta2;
                    $total_ventausd2=$total_ventausd+$total_ventausd2;
                    $total_ventacop2=$total_ventacop+$total_ventacop2;
                    $total_ventasol2=$total_ventasol+$total_ventasol2;


                }

                }



                $ag++;
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
if($total_venta2>0 OR $total_ventausd2>0 OR $total_ventacop2>0  OR $total_ventasol2>0){
         echo $dt.' ****** BS '.$total_venta2.' USD '.$total_ventausd2.' COP '.$total_ventacop2.' SOL '.$total_ventasol2.'<br>';


            $total_venta22=$total_venta2+$total_venta22;
            $total_ventausd22=$total_ventausd2+$total_ventausd22;
            $total_ventacop22=$total_ventacop2+$total_ventacop22;
            $total_ventasol22=$total_ventasol2+$total_ventasol22;
        }

        }
        $puntosnacionales=$puntosnacionales+$totalRows_Recordset3n;
//echo $totalRows_Recordset3n.' ----<br>';
        $dt++;
    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
    $puntosnacionales2=$puntosnacionales;
    $total_venta3=$total_venta22+$total_venta3;
    $total_ventausd3=$total_ventausd22+$total_ventausd3;
    $total_ventacop3=$total_ventacop22+$total_ventacop3;
    $total_ventasol3=$total_ventasol22+$total_ventasol3;
    $totCobraBancax=$total_venta3;
    $totCobraBancausdx=$total_ventausd3*$row_Recordset555['usdabss'];
    $totCobraBancacopx=$total_ventacop3*$row_Recordset555['copabss'];
    $totCobraBancasolx=$total_ventasol3*$row_Recordset555['solabss'];

    $totaltotal=(($totCobraBancax+$totCobraBancausdx+$totCobraBancacopx+$totCobraBancasolx)/100)*$row_Recordset1['multi_por_ameMD'];
    echo $md.' '.number_format($totaltotal, 2, ",", ".").' ******* BS '.$total_venta3.' USD '.$total_ventausd3.' COP '.$total_ventacop3.' SOL '.$total_ventasol3.'<br>';
    echo $md.' '.number_format($totaltotal, 2, ",", ".").' ******* BS '.(($total_venta3/100)*($row_Recordset1['multi_por_ameMD'])).' USD '.(($total_ventausd3/100)*($row_Recordset1['multi_por_ameMD'])).' COP '.(($total_ventacop3/100)*($row_Recordset1['multi_por_ameMD'])).' SOL '.(($total_ventasol3/100)*($row_Recordset1['multi_por_ameMD'])).'<br>';
    echo $md.' '.number_format($totaltotal, 2, ",", ".").' ******* BS '.(($total_venta3/100)*($row_Recordset1['multi_por_ameMD'])).' USD '.(($total_ventausd3/100)*($row_Recordset1['multi_por_ameMD'])).' COP '.(($total_ventacop3/100)*($row_Recordset1['multi_por_ameMD'])).' SOL '.(($total_ventasol3/100)*($row_Recordset1['multi_por_ameMD'])).'<br>';
    echo $md.' '.number_format($totaltotal, 2, ",", ".").' ******* BS '.(($totCobraBancax/100)*($row_Recordset1['multi_por_ameMD'])).' USD '.(($totCobraBancausdx/100)*($row_Recordset1['multi_por_ameMD'])).' COP '.(($totCobraBancacopx/100)*($row_Recordset1['multi_por_ameMD'])).' SOL '.(($totCobraBancasolx/100)*($row_Recordset1['multi_por_ameMD'])).'<br>';

   echo 'total puntos nacionales '.$puntosnacionales2.'<br>'; 
    $acobrarporn=(($puntosnacionales2*$row_Recordset1['multi_por_ameMD'])*$row_Recordset555['usdabss'])+$totaltotal;
    echo 'Bs a cobrar en total '.number_format($acobrarporn, 2, ",", ".").'<br>';
    echo 'Bs a cobrar en total Sin nacionales '.number_format($totaltotal, 2, ",", ".").'<br>';

    $coversionadolares=$acobrarporn/$row_Recordset555['usdabss'];
    echo 'USD a cobrar en total '.number_format($coversionadolares, 2, ",", ".").'<br>';
    echo 'USD a cobrar en total Sin nacionales '.number_format(($totaltotal/$row_Recordset555['usdabss']), 2, ",", ".").'<br>';

    $puntosnacionales=0;
    $puntosnacionales2=0;
    $totalRows_Recordset3n=0;
    $totaltotal=0;
    $total_venta3=0;
    $total_ventausd3=0;
    $total_ventacop3=0;
    $total_ventasol3=0;

}
//echo number_format($porPagarEliTaq, 2, ",", ".");
$md++;
echo '<br><br>';
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}

//aqui termina cobro a multidistribuidor
echo '----------------------------distribuidores en multidistribuidor 1--------------------------<br>';

//aqui comienza cobro a distribuidor en multidistribuidor 1


$query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 8 */ SELECT  * FROM multidistriMD WHERE cod_multidistriMD = 1");

$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

if($totalRows_Recordset1>0){
    do {

        echo $md.' * Multidistribuidor '.$row_Recordset1['nom_multidistriMD'].'<br>';

        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 9 */ SELECT  * FROM  banca WHERE cod_multidistriMDBA = %s", 
            GetSQLValueString($row_Recordset1['cod_multidistriMD'], "int"));
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        $dt=1;
        $total_venta22=0;
        $total_ventausd22=0;
        $total_ventacop22=0;
        $total_ventasol22=0;
        
        if($totalRows_Recordset2>0){
            do {
      echo $dt.' ** Distribuidor '.$row_Recordset2['nom_banca'].' % '.$row_Recordset2['dist_por_ame'].'<br>';



                $query_Recordset3 = sprintf(
                    "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 10 */ SELECT  * FROM  agencia WHERE cod_banca = %s", 
                    GetSQLValueString($row_Recordset2['cod_banca'], "int"));
                $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
                $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
                $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
                $query_Recordset3n = sprintf(
                    "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 11 */ SELECT  * FROM  cobro_hnac WHERE fec_creacion >= %s AND	fec_creacion <= %s AND cod_banca = %s", 
                    GetSQLValueString($in, "date"),
                    GetSQLValueString($fi, "date"),
                    GetSQLValueString($row_Recordset2['cod_banca'], "int"));
                $Recordset3n = mysqli_query($conexionbanca, $query_Recordset3n) or die(mysqli_error($conexionbanca));
                $row_Recordset3n = mysqli_fetch_assoc($Recordset3n);
                $totalRows_Recordset3n = mysqli_num_rows($Recordset3n);
        
        
        
                $ag=1;
                if($totalRows_Recordset3>0){
                    $total_venta2=0;
                    $total_ventausd2=0;
                    $total_ventacop2=0;
                    $total_ventasol2=0;
                    do {

             //  echo $ag.' *** Agencia '.$row_Recordset3['nom_agencia'].'<br>';



               $query_Recordset4 = sprintf(
                "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 12 */ SELECT  * FROM  taquilla WHERE cod_agencia = %s", 
                GetSQLValueString($row_Recordset3['cod_agencia'], "int"));
            $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
            $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
            $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
            $tq=1;
            $total_venta=0;
            $total_ventausd=0;
            $total_ventacop=0;
            $total_ventasol=0;
            if($totalRows_Recordset4>0){
                do {
                //  echo $tq.' **** taquilla '.$row_Recordset4['nom_taquilla'].'<br>';









                    $query_Recordset5 = sprintf(
                        "/* PARSEADORES1 admin\1cobro_directo.php - QUERY 13 */ SELECT
                         ta.cod_taquilla, ta.nom_taquilla, 
                         ta.taq_por_ame,
                         ag.agen_por_ame,
                         
                         
                         
             SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2) 
                 THEN ve.mon_venta ELSE 0 END) AS total_venta,
             SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN ve.pag_premio ELSE 0 END) AS tot_premios,
             SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN ve.mon_venta ELSE 0 END) AS tot_eliminad,
             SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN ve.mon_venta ELSE 0 END) AS ret_pagos,
             SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN ve.mon_venta ELSE 0 END) AS ret_total,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN ve.mon_venta ELSE 0 END) AS ret_porpagar,
             SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN ve.mon_venta ELSE 0 END) AS inv_pagos,
             SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN ve.mon_venta ELSE 0 END) AS inv_total,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN ve.mon_venta ELSE 0 END) AS inv_porpagar,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN ve.pag_premio ELSE 0 END) AS pre_porpagar,
             SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND (ve.efectivoO IS NULL OR ve.efectivoO = 0 OR ve.efectivoO = 1 OR ve.efectivoO = 2)
                 THEN 1 ELSE 0 END) AS con_tic_eli,
                 
                 
                 SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                 THEN ve.mon_venta ELSE 0 END) AS total_ventausd,
             SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 3
                 THEN ve.pag_premio ELSE 0 END) AS tot_premiosusd,
             SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                 THEN ve.mon_venta ELSE 0 END) AS tot_eliminadusd,
             SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND ve.efectivoO = 3
                 THEN ve.mon_venta ELSE 0 END) AS ret_pagosusd,
             SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                 THEN ve.mon_venta ELSE 0 END) AS ret_totalusd,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                 THEN ve.mon_venta ELSE 0 END) AS ret_porpagarusd,
             SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 3
                 THEN ve.mon_venta ELSE 0 END) AS inv_pagosusd,
             SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 3
                 THEN ve.mon_venta ELSE 0 END) AS inv_totalusd,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 3
                 THEN ve.mon_venta ELSE 0 END) AS inv_porpagarusd,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 3
                 THEN ve.pag_premio ELSE 0 END) AS pre_porpagarusd,
             SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND ve.efectivoO = 3
                 THEN 1 ELSE 0 END) AS con_tic_eliusd,
                 
                 
                         
                         
                 
                 SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                 THEN ve.mon_venta ELSE 0 END) AS total_ventacop,
             SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 4
                 THEN ve.pag_premio ELSE 0 END) AS tot_premioscop,
             SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                 THEN ve.mon_venta ELSE 0 END) AS tot_eliminadcop,
             SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND ve.efectivoO = 4
                 THEN ve.mon_venta ELSE 0 END) AS ret_pagoscop,
             SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                 THEN ve.mon_venta ELSE 0 END) AS ret_totalcop,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                 THEN ve.mon_venta ELSE 0 END) AS ret_porpagarcop,
             SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 4
                 THEN ve.mon_venta ELSE 0 END) AS inv_pagoscop,
             SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 4
                 THEN ve.mon_venta ELSE 0 END) AS inv_totalcop,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 4
                 THEN ve.mon_venta ELSE 0 END) AS inv_porpagarcop,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 4
                 THEN ve.pag_premio ELSE 0 END) AS pre_porpagarcop,
             SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND ve.efectivoO = 4
                 THEN 1 ELSE 0 END) AS con_tic_elicop,
                 
                 
                         
 
                         
                 
                 SUM(CASE WHEN ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                 THEN ve.mon_venta ELSE 0 END) AS total_ventasol,
             SUM(CASE WHEN ve.est_ticket = 2 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 5
                 THEN ve.pag_premio ELSE 0 END) AS tot_premiossol,
             SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                 THEN ve.mon_venta ELSE 0 END) AS tot_eliminadsol,
             SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_pago >= %s AND ve.fec_pago <= %s   AND ve.efectivoO = 5
                 THEN ve.mon_venta ELSE 0 END) AS ret_pagossol,
             SUM(CASE WHEN ve.est_ticket = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                 THEN ve.mon_venta ELSE 0 END) AS ret_totalsol,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 4 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                 THEN ve.mon_venta ELSE 0 END) AS ret_porpagarsol,
             SUM(CASE WHEN ve.est_ticket = 5 AND ve.fec_pago >= %s AND ve.fec_pago <= %s  AND ve.efectivoO = 5
                 THEN ve.mon_venta ELSE 0 END) AS inv_pagossol,
             SUM(CASE WHEN ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s  AND ve.efectivoO = 5
                 THEN ve.mon_venta ELSE 0 END) AS inv_totalsol,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 5 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 5
                 THEN ve.mon_venta ELSE 0 END) AS inv_porpagarsol,
             SUM(CASE WHEN ve.est_ticket = 1 AND ve.est_calculo = 2 AND ve.fec_venta >= %s AND ve.fec_venta <= %s   AND ve.efectivoO = 5
                 THEN ve.pag_premio ELSE 0 END) AS pre_porpagarsol,
             SUM(CASE WHEN ve.est_ticket = 0 AND ve.fec_venta >= %s AND ve.fec_venta <= %s AND ve.lin_ticket = 1  AND ve.efectivoO = 5
                 THEN 1 ELSE 0 END) AS con_tic_elisol
                             
                             
                             
                             
                             
                             
                     FROM
                         agencia ag, taquilla ta, taquilla_opc_ame tp, venta ve

                     WHERE (ve.fec_venta >= %s AND ve.fec_venta <= %s OR ve.fec_pago >= %s AND ve.fec_pago <= %s) AND 
                         ag.cod_agencia = ta.cod_agencia AND ta.cod_taquilla = ve.cod_taquilla AND
                         tp.cod_taquilla = ta.cod_taquilla AND ta.cod_taquilla = %s 
                     GROUP BY ta.cod_taquilla 
                     ORDER BY ta.cod_taquilla, ve.fec_venta, ve.num_ticket ASC",
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($in, "date"),
                        GetSQLValueString($fi, "date"),
                        GetSQLValueString($row_Recordset4['cod_taquilla'], "int")
                    );
                    $Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
                    $row_Recordset5 = mysqli_fetch_assoc($Recordset5);
                    $totalRows_Recordset5 = mysqli_num_rows($Recordset5);



                    //echo $tq.' ***** BS '.$row_Recordset5['total_venta'].' USD '.$row_Recordset5['total_ventausd'].' COP '.$row_Recordset5['total_ventacop'].' SOL '.$row_Recordset5['total_ventasol'].'<br>';
                    $total_venta=($row_Recordset5['total_venta']+$total_venta)-($row_Recordset5['ret_pagos']+$row_Recordset5['inv_pagos']+$row_Recordset5['tot_eliminad']);
                    $total_ventausd=($row_Recordset5['total_ventausd']+$total_ventausd)-($row_Recordset5['ret_pagosusd']+$row_Recordset5['inv_pagosusd']+$row_Recordset5['tot_eliminadusd']);;
                    $total_ventacop=($row_Recordset5['total_ventacop']+$total_ventacop)-($row_Recordset5['ret_pagoscop']+$row_Recordset5['inv_pagoscop']+$row_Recordset5['tot_eliminadcop']);;
                    $total_ventasol=($row_Recordset5['total_ventasol']+$total_ventasol)-($row_Recordset5['ret_pagossol']+$row_Recordset5['inv_pagossol']+$row_Recordset5['tot_eliminadsol']);;






                    $tq++;
                } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
               
               
               if($total_venta>0 OR $total_ventausd>0 OR $total_ventacop>0 OR $total_ventasol>0){
             //echo $ag.' ***** BS '.$total_venta.' USD '.$total_ventausd.' COP '.$total_ventacop.' SOL '.$total_ventasol.'<br>';
            
                $total_venta2=$total_venta+$total_venta2;
                $total_ventausd2=$total_ventausd+$total_ventausd2;
                $total_ventacop2=$total_ventacop+$total_ventacop2;
                $total_ventasol2=$total_ventasol+$total_ventasol2;


            }

            }










                        $ag++;
                    } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
        
                    $total_venta22=$total_venta2+$total_venta22;
                    $total_ventausd22=$total_ventausd2+$total_ventausd22;
                    $total_ventacop22=$total_ventacop2+$total_ventacop22;
                    $total_ventasol22=$total_ventasol2+$total_ventasol22;
                    if($total_venta22>0 OR $total_ventausd22>0 OR $total_ventacop22>0 OR $total_ventasol22>0){

                       echo $dt.' ****** BS '.$total_venta2.' USD '.$total_ventausd2.' COP '.$total_ventacop2.' SOL '.$total_ventasol2.'<br>';
                      
                    


                       $puntosnacionales=$puntosnacionales+$totalRows_Recordset3n;



                       $puntosnacionales2=$puntosnacionales;

                       $totCobraBancax=$total_venta22;
                       $totCobraBancausdx=$total_ventausd22*$row_Recordset555['usdabss'];
                       $totCobraBancacopx=$total_ventacop22*$row_Recordset555['copabss'];
                       $totCobraBancasolx=$total_ventasol22*$row_Recordset555['solabss'];
                   
                       $totaltotal=(($totCobraBancax+$totCobraBancausdx+$totCobraBancacopx+$totCobraBancasolx)/100)*$row_Recordset2['dist_por_ame'];
                       echo $dt.' '.$totaltotal.' ******* BS '.$total_venta22.' USD '.$total_ventausd22.' COP '.$total_ventacop22.' SOL '.$total_ventasol22.'<br>';
                   
                      echo 'total puntos nacionales '.$puntosnacionales2.'<br>'; 
                       $acobrarporn=(($puntosnacionales2*$row_Recordset2['dist_por_ame'])*$row_Recordset555['usdabss'])+$totaltotal;
                       echo 'Bs a cobrar en total '.number_format($acobrarporn, 2, ",", ".").'<br>';
                       echo 'Bs a cobrar en total Sin nacionales '.number_format($totaltotal, 2, ",", ".").'<br>';

                       $coversionadolares=$acobrarporn/$row_Recordset555['usdabss'];
                       echo 'USD a cobrar en total '.number_format($coversionadolares, 2, ",", ".").'<br>';
                       $coversionadolares=$totaltotal/$row_Recordset555['usdabss'];

                       echo 'USD a cobrar en total Sin nacionales '.number_format($coversionadolares, 2, ",", ".").'<br>';

                       $puntosnacionales2=0;
                       $totaltotal=0;
                       $total_venta22=0;
                       $total_ventausd22=0;
                       $total_ventacop22=0;
                       $total_ventasol22=0;








                    
                    
                    
                    }
        



                }       


                    $total_venta22=0;
                    $total_ventausd22=0;
                    $total_ventacop22=0;
                    $total_ventasol22=0;


                $dt++;
                echo '<br>';
            } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
        }
echo '<br><br>';
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}



echo '----------------------------Agentes en distribuidor 1--------------------------<br>';






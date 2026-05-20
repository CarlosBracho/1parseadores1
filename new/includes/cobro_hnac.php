<?php
require_once('../Connections/conexionbanca.php');
function weekyear_hnac($date)
{
    list($year, $month, $day)=explode('-', $date);
    return strftime("%YW%W", mktime(0, 0, 0, $month, $day, $year));
}
function get_week_start_hnac($fecha)
{
    $dato=weekyear_hnac($fecha);
    $timestamp=strtotime($dato);
    return date('Y-m-d', $timestamp);
}
function get_week_end_hnac($fecha)
{
    list($year, $month, $day)=explode('-', $fecha);
    $dato=weekyear_hnac($fecha);
    $timestamp=strtotime($dato)+518400;
    return date('Y-m-d', $timestamp);
}
$fecha=fechaactualbd();
$semIni=get_week_start_hnac($fecha);
$semFin=get_week_end_hnac($fecha);
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 new\includes\cobro_hnac.php - QUERY 1 */ SELECT 
	SUM(CASE WHEN ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s 
		THEN ve.mon_venta_hnac ELSE 0 END) AS total_venta,
	ba.cod_banca, 
	ba.cob_banca_hnac,
	us.id_usuario,
	ta.cod_taquilla,
	ag.cod_agencia
FROM
	usuario us,
	taquilla ta,
	agencia ag,
	venta_hnac ve,
	banca ba
WHERE
	us.id_usuario = ve.id_usuario AND
	ta.cod_taquilla = us.cod_taquilla AND
	ag.cod_agencia = ta.cod_agencia AND
	ba.cod_banca = ag.cod_banca AND
	ve.est_ticket_hnac >= 1 AND
	ve.est_ticket_hnac <= 2 AND
	ve.est_calculo_hnac >= 0 AND
	ve.est_calculo_hnac <= 2 AND
	ve.fec_venta_hnac >= %s AND ve.fec_venta_hnac <= %s
GROUP BY	
	us.id_usuario
ORDER BY
	ba.cod_banca, ag.cod_agencia, ta.cod_taquilla, us.id_usuario ASC",
    GetSQLValueString($semIni, "date"),
    GetSQLValueString($semFin, "date"),
    GetSQLValueString($semIni, "date"),
    GetSQLValueString($semFin, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
do {
    if ($row_Recordset1['total_venta']>2000) {
        $id_usuario=$row_Recordset1['id_usuario'];
        $query_Recordset2 =  sprintf(
            "/* PARSEADORES1 new\includes\cobro_hnac.php - QUERY 2 */ SELECT id_usuario
			FROM  
			cobro_hnac
			WHERE 
			id_usuario = %s AND
			fec_creacion >= %s AND fec_creacion <= %s",
            GetSQLValueString($id_usuario, "int"),
            GetSQLValueString($semIni, "date"),
            GetSQLValueString($semFin, "date")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        if ($totalRows_Recordset2==0) {
            $cod_taquilla=$row_Recordset1['cod_taquilla'];
            $cod_agencia=$row_Recordset1['cod_agencia'];
            $cod_banca=$row_Recordset1['cod_banca'];
            $insertSQL3 = sprintf(
                "/* PARSEADORES1 new\includes\cobro_hnac.php - QUERY 3 */ INSERT 
			INTO cobro_hnac 
			(id_usuario, cod_taquilla, cod_agencia, cod_banca, fec_creacion) 
			VALUES (%s, %s, %s, %s, %s)",
                GetSQLValueString($id_usuario, "int"),
                GetSQLValueString($cod_taquilla, "int"),
                GetSQLValueString($cod_agencia, "int"),
                GetSQLValueString($cod_banca, "int"),
                GetSQLValueString($fecha, "date")
            );
            $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
        }
    }
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

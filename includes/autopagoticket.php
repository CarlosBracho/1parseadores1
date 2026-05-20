<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');


$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];


$query_Recordset1 = sprintf("/* PARSEADORES1 includes\autopagoticket.php - QUERY 1 */ SELECT 
	ve.fec_venta, 
	ve.ticket, 
	ve.cod_cliente,
	ve.tra_codigo,
	ve.efectivoO,
	ve.ip_venta,
	ca.pau_pagos,
	ve.cod_taquilla,	
    ve.efectivoO,
	ve.id_usuario,
	ve.pag_premio,
	ve.efectivoO,
	ve.num_ticket,
    ve.est_calculo
FROM 
 venta ve, carrera ca, taquilla ta
 
WHERE 
	ta.tipotaquilla = 3 AND
	ve.cod_taquilla = ta.cod_taquilla AND 
	ve.cod_carrera = ca.cod_carrera AND 
	ve.fec_venta = %s AND 
	ve.fec_venta <= %s AND 
	ve.est_ticket = 1 AND
	ve.est_calculo >= 2 AND
	ve.est_calculo <= 5
GROUP BY ve.num_ticket DESC", GetSQLValueString($in, "date"), GetSQLValueString($fi, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset7 = sprintf("/* PARSEADORES1 includes\autopagoticket.php - QUERY 2 */ SELECT est_control_pagos_ame FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame = 1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_pagos=$row_Recordset7['est_control_pagos_ame']; //todos los pagos globales
$acceso=1;
echo $totalRows_Recordset1;
echo "</br></br></br>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hipicas:.</title>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<style>@charset "utf-8";body{margin:0;padding:0;font-family:Tahoma, Geneva, sans-serif;font-size:14px;color:#000;background-color:#E5E5E5;background-repeat:repeat-x;background-image:none;text-align:center}.btn-primary,.btn-primary:hover{color:#fff;text-shadow:0 -1px 0 rgba(0,0,0,0.25)}.btn-primary.active{color:rgba(255,255,255,0.75)}.btn-primary{background-color:#0074cc;*background-color:#05c;background-image:-ms-linear-gradient(top,#08c,#05c);background-repeat:repeat-x;border-color:#05c #05c #003580;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc',endColorstr='#0055cc',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}
</style>
<script language="javascript">function cOver(celda){celda.style.backgroundColor="#FFFFDD"}function cOut(celda){ celda.style.backgroundColor="#E5E5E5"} 
</script>
</head>
<body style="margin: 0px">
	<?php
    if ($acceso==1 && $est_control_pagos==0) {
        if ($totalRows_Recordset1>0) {
            do {
                echo "</br>";
                echo $row_Recordset1['est_calculo'];
                echo "</br>";
                echo $row_Recordset1['ticket'];
                echo "</br>";
                echo $row_Recordset1['num_ticket'];
                echo "</br>";
                $horaPago=horaactual();
                $ipPago=$row_Recordset1['ip_venta'];
                $fecpago=fechaactualbd();
                    
                if ($row_Recordset1['efectivoO']<=2) {
                    $montobss=$row_Recordset1['pag_premio'];
                } else {
                    $montobss=0;
                }
                if ($row_Recordset1['efectivoO']==3) {
                    $montousd=$row_Recordset1['pag_premio'];
                } else {
                    $montousd=0;
                }
                if ($row_Recordset1['efectivoO']==4) {
                    $montocop=$row_Recordset1['pag_premio'];
                } else {
                    $montocop=0;
                }
                if ($row_Recordset1['efectivoO']==5) {
                    $montosol=$row_Recordset1['pag_premio'];
                } else {
                    $montosol=0;
                }
                echo $montousd;
                echo "</br></br>";

        
                $insertSQL15 = sprintf(
                    "/* PARSEADORES1 includes\autopagoticket.php - QUERY 3 */ UPDATE venta
				SET
				venta.est_ticket=%s, 
				venta.fec_pago=%s, 
				venta.cod_usuario_pago=%s, 
				venta.ip_pago=%s, 
				venta.hor_pago=%s
				WHERE 
				venta.num_ticket=%s",
                    GetSQLValueString($row_Recordset1['est_calculo'], "int"),
                    GetSQLValueString($fecpago, "date"),
                    GetSQLValueString($row_Recordset1['id_usuario'], "int"),
                    GetSQLValueString($ipPago, "text"),
                    GetSQLValueString($horaPago, "date"),
                    GetSQLValueString($row_Recordset1['num_ticket'], "int")
                );

                $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));
            

                
                
                        
                $query_Recordset13 = sprintf(
                    "/* PARSEADORES1 includes\autopagoticket.php - QUERY 4 */ SELECT MAX(Idbalancecli) 
					FROM balanceclientes
					WHERE monedac = %s AND 
					cod_taquilla = %s",
                    GetSQLValueString($row_Recordset1['efectivoO'], "int"),
                    GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
                );
                $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
                $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
                $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
                $Idbalancecli=((int)$row_Recordset13['MAX(Idbalancecli)']);
    
                $query_Recordset14 = sprintf(
                    "/* PARSEADORES1 includes\autopagoticket.php - QUERY 5 */ SELECT saldoactualc
					FROM balanceclientes
					WHERE monedac = %s AND
					Idbalancecli = %s",
                    GetSQLValueString($row_Recordset1['efectivoO'], "int"),
                    GetSQLValueString($Idbalancecli, "int")
                );
                $Recordset14 = mysqli_query($conexionbanca, $query_Recordset14) or die(mysqli_error($conexionbanca));
                $row_Recordset14 = mysqli_fetch_assoc($Recordset14);
                $totalRows_Recordset14 = mysqli_num_rows($Recordset14);
                $saldoactualc=((float)$row_Recordset14['saldoactualc']);

                $query_Recordset15 = sprintf(
                    "/* PARSEADORES1 includes\autopagoticket.php - QUERY 6 */ SELECT jugada
					FROM balanceclientes
					WHERE modulo = %s AND
					 numticket = %s",
                    GetSQLValueString(0, "int"),
                    GetSQLValueString($row_Recordset1['num_ticket'], "int")
                );
                $Recordset15 = mysqli_query($conexionbanca, $query_Recordset15) or die(mysqli_error($conexionbanca));
                $row_Recordset15 = mysqli_fetch_assoc($Recordset15);
                $totalRows_Recordset15 = mysqli_num_rows($Recordset15);
    
    

    
    
                $insertSQL155 = sprintf(
                    "/* PARSEADORES1 includes\autopagoticket.php - QUERY 7 */ INSERT INTO balanceclientes  
(numticket, cod_taquilla, monto, jugada, fec_venta, hor_venta, saldoactualc, monedac, tipo)
VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($row_Recordset1['num_ticket'], "int"),
                    GetSQLValueString($row_Recordset1['cod_taquilla'], "int"),
                    GetSQLValueString($row_Recordset1['pag_premio'], "double"),
                    GetSQLValueString($row_Recordset15['jugada'], "text"),
                    GetSQLValueString($fecpago, "date"),
                    GetSQLValueString($horaPago, "date"),
                    GetSQLValueString($saldoactualc+$row_Recordset1['pag_premio'], "double"),
                    GetSQLValueString($row_Recordset1['efectivoO'], "int"),
                    GetSQLValueString(1, "int")
                );

                $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        }
    }?>
</body>
</html>

<?php
mysqli_free_result($Recordset1);mysqli_free_result($Recordset7);?>

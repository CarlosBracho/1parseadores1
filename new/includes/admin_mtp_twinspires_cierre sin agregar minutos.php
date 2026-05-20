<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');include('../includes/mtp_funcion.php');
list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=consultaCierreTwinspires();
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\includes\admin_mtp_twinspires_cierre sin agregar minutos.php - QUERY 1 */ SELECT 
		hi.pre_twin,
		hi.nom_hipodromo,
		ca.cod_carrera,
		ca.num_carrera,
 		ca.est_carrera,
		ca.est_cierre
	FROM carrera ca, hipodromo hi
	WHERE	ca.cod_hipodromo=hi.cod_hipodromo AND
		(ca.est_cierre=1 OR ca.est_cierre=2) AND 
		ca.est_carrera=1 AND 
		ca.eje_primero=0 AND
(hi.mtp_betbird=0 OR hi.mtp_betbird=1) AND
		ca.fec_carrera=%s AND 
		(ca.mtp_control=1 OR ca.mtp_control=3)",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<div style="background:#eaeaea; color: #FFF; width:100%;">
<table width="100%" border="0">
  <tr>
  	<td height="41" colspan="2" align="left" valign="middle" style="font-size:28px; color:#32c75f">CONTROL CIERRE</td>
  	<td height="41" align="right" valign="middle" style="font-size:46px; color:#000000"><?php echo $horasistema ?></td>
    </tr>
</table>
</div>
<?php
if ($totalRows_Recordset1>0) {
    $g=1;
    do {
        $f=0;
        $control=1;
        if ($hipodomo[0]!="") {
            foreach ($hipodomo as $hip) {
                if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && trim($hipodomo[$f])==trim($row_Recordset1['pre_twin']) && $numeroca[$f]==$row_Recordset1['num_carrera']) {
                    $hor_carrera=horaactual();
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $cie=1;
                    if ($restante[$f]=="0") {
                        $est=0; ?>
                        <div style="background: #F2F2F2; color: #FFF; width:100%; text-align:right; height:40px; font-size:24px; 
                            margin:2px 0px 0px 0px ">
                            <div style="background:#20c8a8; color: #000; width:65%; height:30px; float:left; text-align:left; 
                                padding:10px 0px 0px 5px "><?php echo $row_Recordset1['nom_hipodromo']; ?>
                            </div>
                            <div style="background:#20c8a8; color: #000; width:10%; height:30px; float:left; text-align: center; 
                                padding:10px 0px 0px 0px">#<?php echo $row_Recordset1['num_carrera']; ?>
                            </div>
                            <div style="width:0; height:0; border-top: 20px solid transparent;  float:left;
                                border-bottom: 20px solid transparent; border-left: 20px solid #20c8a8;">
                            </div>
                            <div style="background: #F2F2F2; color: #000; width:20%; height:30px; float:left; text-align: right; 
                                padding:10px 0px 0px 0px">
                                <?php if ($restante[$f]==0) {
                            echo "<font style='color:#F03'>CERRADA</font>";
                        } else {
                            echo $restante[$f]." min.";
                        } ?>
                            </div>
                        </div>
						<?php
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 new\includes\admin_mtp_twinspires_cierre sin agregar minutos.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, est_cierre=%s, mtp_control=%s, CERRADOX=%s  
										  WHERE cod_carrera=%s",
                            GetSQLValueString($hor_carrera, "date"),
                            GetSQLValueString($hor_carrera, "date"),
                            GetSQLValueString($est, "int"),
                            GetSQLValueString($cie, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString("TWINSPIRES", "text"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                        $g++;
                    } else {
                    }
                    $control=0;
                    break;
                }
                $f++;
            }
        }
        if ($row_Recordset1['est_carrera']==1 && $row_Recordset1['est_cierre']==2 && $control==1) {
            $cod=$row_Recordset1['cod_carrera'];
            $hor=horaactual();
            $est=0;
            $cie=1;
            $updateSQL = sprintf(
                "/* PARSEADORES1 new\includes\admin_mtp_twinspires_cierre sin agregar minutos.php - QUERY 3 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, est_cierre=%s

						  WHERE cod_carrera=%s",
                GetSQLValueString($hor, "date"),
                GetSQLValueString($hor, "date"),
                GetSQLValueString($est, "int"),
                GetSQLValueString($cie, "int"),
                GetSQLValueString($cod, "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca)); ?>
            <div style="background: #F2F2F2; color: #FFF; width:100%; text-align:right; height:40px; font-size:24px; 
				margin:2px 0px 0px 0px ">
                <div style="background:#20c8a8; color: #000; width:65%; height:30px; float:left; text-align:left; 
					padding:10px 0px 0px 5px "><?php echo $row_Recordset1['nom_hipodromo']; ?>
				</div>
				<div style="background:#20c8a8; color: #000; width:10%; height:30px; float:left; text-align: center; 
					padding:10px 0px 0px 0px">#<?php echo $row_Recordset1['num_carrera']; ?>
				</div>
				<div style="width:0; height:0; border-top: 20px solid transparent;  float:left;
					border-bottom: 20px solid transparent; border-left: 20px solid #20c8a8;">
				</div>
				<div style="background: #F2F2F2; color: #F03; width:20%; height:30px; float:left; text-align: right; 
					padding:10px 0px 0px 0px">
					CERRADA
				</div>
			</div>
			<?php
            $g++;
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}
?>

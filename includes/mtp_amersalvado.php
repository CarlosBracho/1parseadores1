<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
include('../includes/mtp_funcion.php');
list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=consultaPacificna();
$fech=fechaactualbd();
$horasistema=horaactual();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 includes\mtp_amersalvado.php - QUERY 1 */ SELECT * FROM carrera, hipodromo WHERE carrera.eje_primero=0 AND carrera.fec_carrera=%s AND (carrera.mtp_control=5 OR carrera.mtp_control=6) AND carrera.cod_hipodromo=hipodromo.cod_hipodromo",
        GetSQLValueString($fech, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<div style="background: #F90; color: #FFF; width:100%">
<table width="100%" border="0">
  <tr>
  	<td height="41" colspan="4" align="right" valign="middle" style="font-size:36px; color:#000000"><?php echo $horasistema ?></td>
    </tr>
  <tr>
  	<td width="100"> CIERRE</td>
    <td width="510">HIPODROMO</td>
    <td width="51" align="center">#</td>
    <td width="80" align="center">RESTAN</td>
  </tr>
</table>
</div>
<table width="100%" border="1" bordercolor="#FFCC00">
<?php
if ($totalRows_Recordset1>0) {
    $t=0;
    $g=1;
    do {
        $f=0;
        $cont=1;
        if ($hipodomo[0]!="") {
            foreach ($hipodomo as $hip) {
                if (trim($hipodomo[$f])==trim($row_Recordset1['nom_hipodromo_sup']) && $numeroca[$f]==$row_Recordset1['num_carrera']) {
                    $hora=explode(" ", $horacarr[$f]);
                    $hor_carrera=horamysqlMTP($horacier[$f].":".$hora[1]);
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $mtp_control=1;
                    $cie=2;
                    $est=1;
                    $mtc=5;
                    if ($g%2==0) {?>
					  <tr bgcolor="#FFFFFF" style="color:#003" height="31" >
                      <?php } else {?>
                      <tr bgcolor="#FFFF99" style="color:#003" height="31">
                     <?php  } ?>
						<td width="100" align="center"><?php echo cambioHoramysql($hor_carrera); ?></td>
						<td width="510"><?php echo $row_Recordset1['nom_hipodromo_sup']; ?></td>
						<td width="51" align="center"><?php echo $row_Recordset1['num_carrera']; ?></td>
						<td width="80" align="right"><?php echo $restante[$f]." min."; ?></td>
						
					  </tr>
					<?php
                                         $updateSQL = sprintf(
                        "/* PARSEADORES1 includes\mtp_amersalvado.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_cierre=%s, est_carrera=%s, mtp_control=%s 
											  WHERE cod_carrera=%s",
                        GetSQLValueString($hor_carrera, "date"),
                        GetSQLValueString($hor_carrera, "date"),
                        GetSQLValueString(2, "int"),
                        GetSQLValueString(1, "int"),
                        GetSQLValueString(5, "int"),
                        GetSQLValueString($cod_carrera, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    $cont=0;
                    $g++;
                    break;
                }
                $f++;
            }
        }
        if ($cont==1) {
            if ($row_Recordset1['hor_carrera']>$horasistema && $row_Recordset1['est_carrera']==1) {
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $est=0;
                $mtc=6;
                $cie=1;
                $updateSQL = sprintf(
                    "/* PARSEADORES1 includes\mtp_amersalvado.php - QUERY 3 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s, mtp_control=%s, est_cierre=%s
							  WHERE cod_carrera=%s",
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString($horasistema, "date"),
                    GetSQLValueString(0, "int"),
                    GetSQLValueString(6, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($cod_carrera, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
            }
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}
?>
</table>
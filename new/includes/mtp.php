<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include('../includes/mtp_funcion.php');
$fech=fechaactualbd();
list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=consultaCierre();
if (!empty($hipodomo[0])) {
    $hipo=array_unique($hipodomo);
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\mtp.php - QUERY 1 */ SELECT * FROM carrera, hipodromo 
	WHERE
		carrera.cod_hipodromo=hipodromo.cod_hipodromo AND
		carrera.eje_primero=0 AND 
		carrera.mtp_control=4 AND
		carrera.fec_carrera=%s",
        GetSQLValueString($fech, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
}
?>
<div style="background:#5EAEFF; color: #FFF; width:100%">
<table width="100%" border="1">
  <tr>
    <td width="506">HIPODROMO</td>
    <td width="55" align="center">#</td>
    <td width="430" align="center">HORA DE CIERRE</td>
    </tr>
</table>
</div>
<table width="100%" border="1" bordercolor="#FFCC00">
<?php
    $g=1;
    do {
        $f=0;
        foreach ($hipodomo as $hip) {
            if (trim($hipodomo[$f])==trim($row_Recordset1['nom_hipodromo']) && $numeroca[$f]==$row_Recordset1['num_carrera']) {
                $hora=explode(" ", $horacarr[$f]);
                $hor_carrera=horamysqlMTP($horacier[$f].":".$hora[1]);
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $minAnadir=0;
                $seg_horInicial=strtotime($hor_carrera);
                $seg_minAnadir=$minAnadir*60;
                $nuevaHora=date("H:i", $seg_horInicial+$seg_minAnadir);
                $mtp_control=1;
                if ($g%2==0) {?>
				  <tr bgcolor="#FFFFFF" style="color:#003" height="31" >
                <?php } else {?>
                  <tr bgcolor="#FFFF99" style="color:#003" height="31">
                     <?php  } ?>
                    <td width="523"><?php echo $row_Recordset1['nom_hipodromo']; ?></td>
                    <td width="55" align="center"><?php echo $row_Recordset1['num_carrera']; ?></td>
                    <td width="229" align="center"><?php echo cambioHoramysql($hor_carrera); ?></td>
                    <td width="178" align="center"><?php echo $nuevaHora; ?></td>
                  </tr>
				<?php
                    $updateSQL = sprintf(
                    "/* PARSEADORES1 new\includes\mtp.php - QUERY 2 */ UPDATE carrera SET hor_mtp=%s, hor_carrera=%s 
										  WHERE cod_carrera=%s",
                    GetSQLValueString($hor_carrera, "date"),
                    GetSQLValueString($nuevaHora, "date"),
                    GetSQLValueString($cod_carrera, "int")
                );
                    
                $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                $g++;
                break;
            }
            $f++;
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
mysqli_free_result($Recordset1);
?>
</table>
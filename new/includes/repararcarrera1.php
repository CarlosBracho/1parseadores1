<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
set_time_limit(0);
$fech=fechaactualbd();
$horasistema=horaactual();
    $query_Recordset1 = sprintf("/* PARSEADORES1 new\includes\repararcarrera1.php - QUERY 1 */ SELECT 
	ca.cod_carrera,
	ca.nom_hipodromo,
	ca.num_carrera,
	ca.fec_carrera	
	FROM 
	carrera ca 
	WHERE 
	ca.est_carrera=1 AND 
	ca.est_confirmacion=0 AND 
	ca.est_carrera<>0
	ORDER BY 
	fec_carrera");
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);

echo $totalRows_Recordset1;
if ($totalRows_Recordset1>0) {
    do {
        $cod_carrera=$row_Recordset1['cod_carrera'];
        $updateSQL = sprintf(
            "/* PARSEADORES1 new\includes\repararcarrera1.php - QUERY 2 */ UPDATE carrera SET est_carrera=%s  
							  WHERE cod_carrera=%s",
            GetSQLValueString(0, "int"),
            GetSQLValueString($cod_carrera, "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}

?>
<div style="background: #F90; color: #FFF; width:100%">
<table width="100%" border="0">
  <tr>
  	<td height="41" colspan="4" align="right" valign="middle" style="font-size:36px; color:#000000"><?php echo $horasistema ?></td>
    </tr>
  <tr>
  	<td width="100"> HIPODROMO</td>
    <td width="510">CARRERA</td>
    <td width="51" align="center">FECHA</td>
  </tr>
</table>
</div>


<table width="100%" border="1" bordercolor="#FFCC00">
<?php
if ($totalRows_Recordset1>0) {
    do {
        ?>
  <tr>
  	<td width="100"><?php echo $row_Recordset1['nom_hipodromo']; ?></td>
    <td width="510"><?php echo $row_Recordset1['num_carrera']; ?></td>
    <td width="51" align="center"><?php echo $row_Recordset1['fec_carrera']; ?></td>
  </tr>

<?php
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}
?>
</table>
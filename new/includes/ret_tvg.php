<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include('../includes/mtp_funcion.php');
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\includes\ret_tvg.php - QUERY 1 */ SELECT * FROM carrera, hipodromo 
	WHERE
	carrera.nom_hipodromo=hipodromo.nom_hipodromo AND
	carrera.est_confirmacion=1 AND
	carrera.est_cierre!=3 AND
	hipodromo.bus_retirado=1 AND
	carrera.fec_carrera=%s ORDER BY carrera.hor_carrera DESC LIMIT 0, 15",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<div style="background: #096; color: #FFF; width:100%">
<table width="100%" border="0">
  <tr>
  	<td width="464" height="41">HIPODROMO</td>
    <td width="281" align="center">RETIRADOS</td>
  </tr>
</table>
</div>
<table width="100%" border="1">
<?php
if ($totalRows_Recordset1>0) {
    do {
        if ($row_Recordset1['bus_retirado']==1) {
            $pos = strpos($row_Recordset1['dir_retirado'], "http://basic.tvg.com/");
            if ($pos !== false) {
                $url=$row_Recordset1['dir_retirado'];
                $ext=$row_Recordset1['ext_retirado'];
                $car=$row_Recordset1['num_carrera'];
                list($horse, $oddss, $retiro, $cantProgramados)=consultaTVGRetirados($url, $ext, $car, $fech);
                if ($cantProgramados!=$row_Recordset1['can_caballos'] && $cantProgramados>0) {
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $updateSQL2 = sprintf(
                        "/* PARSEADORES1 new\includes\ret_tvg.php - QUERY 2 */ UPDATE carrera SET can_caballos=%s 
										  WHERE cod_carrera=%s",
                        GetSQLValueString($cantProgramados, "int"),
                        GetSQLValueString($cod_carrera, "int")
                    );
                    $Result2 = mysqli_query($conexionbanca, $updateSQL2) or die(mysqli_error($conexionbanca));
                }
                if (isset($retiro[0])) {
                    $ejemRetir="-";
                    foreach ($retiro as $ejem) {
                        $cod_carrera=$row_Recordset1['cod_carrera'];
                        $estado=RetiradosSimple($cod_carrera, $ejem);
                        $ejemRetir=$ejemRetir.$ejem."-";
                        if ($estado==0) { // retirar caballo
                            $insertSQL = sprintf(
                                "/* PARSEADORES1 new\includes\ret_tvg.php - QUERY 3 */ INSERT INTO retirados 
										(cod_carrera, num_rcaballo) VALUES (%s, %s)",
                                GetSQLValueString($cod_carrera, "int"),
                                GetSQLValueString($ejem, "int")
                            );
                            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                        }
                    } ?>
					<tr>
						<td width="464">
							<?php
                                echo $row_Recordset1['nom_hipodromo']." ".trim($row_Recordset1['num_carrera'])." "; ?>
						</td>
						<td width="281" align="center"><?php echo $ejemRetir; ?></td>
					</tr>
					<?php
                }
            }
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}
mysqli_free_result($Recordset1);
?>
</table>

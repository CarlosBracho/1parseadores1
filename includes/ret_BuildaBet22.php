<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\ret_BuildaBet22.php - QUERY 1 */ SELECT * FROM carrera, hipodromo 
	WHERE
	carrera.nom_hipodromo=hipodromo.nom_hipodromo AND
	carrera.est_confirmacion=1 AND
	carrera.est_cierre!=3 AND
	(hipodromo.bus_retirado=2 OR hipodromo.bus_retirado=4 OR hi.bus_retirado=5 OR hi.bus_retirado=7) AND
	carrera.fec_carrera=%s ORDER BY RAND() LIMIT 7",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<div style="background:#333; color: #FFF; width:100%">
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
        $id=explode("/", $row_Recordset1['cod_pagina_rb']);
        $car=$row_Recordset1['num_carrera'];
        $fec=$row_Recordset1['fec_carrera'];
        $idH=$id[0];
        $idC=$id[$car];
        list($retiro, $cantProgramados, $cantRetirados)=consultaBuildRetirados($idH, $idC, $fec);
        if ($cantProgramados!=$row_Recordset1['can_caballos'] && $row_Recordset1['can_caballos']>0) {
            $cod_carrera=$row_Recordset1['cod_carrera'];
            $updateSQL2 = sprintf(
                "/* PARSEADORES1 includes\ret_BuildaBet22.php - QUERY 2 */ UPDATE carrera SET can_caballos=%s 
								  WHERE cod_carrera=%s",
                GetSQLValueString($cantProgramados, "int"),
                GetSQLValueString($cod_carrera, "int")
            );
            $Result2 = mysqli_query($conexionbanca, $updateSQL2) or die(mysqli_error($conexionbanca));
        }
        if (isset($retiro[0]) && $retiro[0]!="") {
            $ejemRetir="-";
            foreach ($retiro as $ejem) {
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $estado=RetiradosSimple($cod_carrera, $ejem);
                $ejemRetir=$ejemRetir.$ejem."-";
                if ($estado==0) { // retirar caballo
                    $insertSQL = sprintf(
                        "/* PARSEADORES1 includes\ret_BuildaBet22.php - QUERY 3 */ INSERT INTO retirados 
					  			(cod_carrera, num_rcaballo) VALUES (%s, %s)",
                        GetSQLValueString($cod_carrera, "int"),
                        GetSQLValueString($ejem, "int")
                    );
                    $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
               
                    $insertSQL = sprintf(
                        "/* PARSEADORES1 includes\ret_BuildaBet22.php - QUERY 4 */ INSERT INTO quiencierrayabre 
                        (codcarrera, 
                        fechaquien, 
                        que) 
                        VALUES (%s, %s, %s)",
                        GetSQLValueString($cod_carrera, "int"),
                        GetSQLValueString($fech, "date"),
                        GetSQLValueString(32, "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));

               
               
               
               
                }
            } ?>
		  	<tr>
				<td width="464">
					<?php echo $row_Recordset1['nom_hipodromo']." ".trim($row_Recordset1['num_carrera']); ?>
                   </td>
				<td width="281" align="center"><?php echo $ejemRetir; ?></td>
		  	</tr>
			<?php
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}
mysqli_free_result($Recordset1);
?>
</table>

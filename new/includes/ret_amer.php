<?php
require_once('../Connections/conexionbanca.php');
include('../includes/mtp_funcion.php');
list($hipoCar, $caballo)=consultaPacificnaRetirados();
$fech=fechaactualbd();
$horasistema=horaactual();
if ($hipoCar[0]!="") {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\includes\ret_amer.php - QUERY 1 */ SELECT * FROM  carrera, hipodromo WHERE 
	carrera.nom_hipodromo=hipodromo.nom_hipodromo AND
	carrera.est_confirmacion=1 AND
	carrera.est_cierre!=3 AND
		(hipodromo.bus_retirado=5 OR hipodromo.bus_retirado=6 OR hipodromo.bus_retirado=7) AND
	carrera.fec_carrera=%s ORDER BY RAND() LIMIT 15",
        GetSQLValueString($fech, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    echo $totalRows_Recordset1;
}
?>
<div style="background: #090; color: #FFF; width:758px">
<table width="755" border="0">
  <tr>
  	<td width="464">HIPODROMO</td>
    <td width="281" align="center">RETIRADOS</td>
  </tr>
</table>
</div>
<table width="755" border="1">
<?php
if ($hipoCar[0]!="") {
    $t=0;
    do {
        $f=0;
        $cont=1;
        foreach ($hipoCar as $hip) {
            $hiC=($row_Recordset1['nom_hipodromo_sup'])." ".trim($row_Recordset1['num_carrera']);
            if ($hipoCar[$f]==$hiC) {
                ?>
                  <tr>
                  	<td width="461" align="left"><?php echo $hiC; ?></td>
                    <td width="278" align="center"><?php echo $caballo[$f]; ?></td>
                  </tr>
				<?php
                $cod_carrera=$row_Recordset1['cod_carrera'];
                $resultado1 = strpos($caballo[$f], "-");
                if ($resultado1 !== false) {
                    $ejemp=explode("-", $caballo[$f]);
                    foreach ($ejemp as $ej) {
                        $ret=RetiradosSimple($cod_carrera, $ej);
                        if ($ret==0) {
                            $insertSQL = sprintf(
                                "/* PARSEADORES1 new\includes\ret_amer.php - QUERY 2 */ INSERT INTO retirados 
							  			(cod_carrera, num_rcaballo) VALUES (%s, %s)",
                                GetSQLValueString($cod_carrera, "int"),
                                GetSQLValueString($ej, "int")
                            );
                            
                            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                        }
                    }
                } else {
                    $ret=RetiradosSimple($cod_carrera, $caballo[$f]);
                    $aRetirar=$caballo[$f];
                    if ($ret==0) {
                        $insertSQL2 = sprintf(
                            "/* PARSEADORES1 new\includes\ret_amer.php - QUERY 3 */ INSERT INTO retirados 
					  			(cod_carrera, num_rcaballo) VALUES (%s, %s)",
                            GetSQLValueString($cod_carrera, "int"),
                            GetSQLValueString($aRetirar, "int")
                        );
                        
                        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                    }
                }
                break;
            }
            $f++;
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}
?>
</table>
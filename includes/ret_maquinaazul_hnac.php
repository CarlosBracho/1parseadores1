<?php
require_once('../Connections/conexionbanca.php');
include('../includes/dividendos_funcion.php');
$fech=fechaactualbd();
$horasistema=horaactual();

$nomDia=nomDiaActual();
$retiro=retiradosNacionales($nomDia);
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\ret_maquinaazul_hnac.php - QUERY 1 */ SELECT * 
	FROM 
	hipodromo_hnac,
	carrera_hnac 
	WHERE
	hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac AND
	carrera_hnac.fec_carrera_hnac = %s
	ORDER BY carrera_hnac.num_carrera_hnac ASC",
    GetSQLValueString(fechaactualbd(), "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<div style="background: #6CF; color: #FFF; width:100%">
<table width="100%" border="0">
  <tr>
  	<td height="51" colspan="2" style="font-size:22px" align="center">
    	HIPODROMO <?php echo $row_Recordset1['nom_hipodromo_hnac']; ?></td>
    </tr>
  <tr style="background: #333;">
  	<td width="32%" height="41" align="center" style="font-size:36px"><?php echo $horasistema; ?></td>
    <td width="68%" align="center">RETIRADOS</td>
  </tr>
</table>
</div>
<table width="100%" border="1">
<?php
if ($totalRows_Recordset1>0) {
    //echo "siiiii ---- ".$retiro[1][0];
    do {
        if ($row_Recordset1['fec_carrera_hnac']==fechaactualbd()) {
            //RetiradosSimple_hnac($codcarrera,$ejemplar);
            
            $nc=$row_Recordset1['num_carrera_hnac'];
            if (isset($retiro[$nc][0])) {
                echo "<tr>";
                echo "<td  width='32%'>&nbsp;Carrera #".$nc."</td>";
                echo "<td  width='68%'>";
                foreach ($retiro[$nc] as $pr) {
                    echo "&nbsp;[".$pr."] ";
                    // $estRetiro=RetiradosSimple_hnac($row_Recordset1['cod_carrera_hnac'],$pr);
                                    
                                        
                                        
                    $query_Recordset2 = sprintf(
                        "/* PARSEADORES1 includes\ret_maquinaazul_hnac.php - QUERY 2 */ SELECT * 
	FROM 
	inscritos
	WHERE
	inscritos.cod_carrera_hnac = %s AND
	inscritos.num_caballo_hnac = %s AND 
	inscritos.est_inscrito_hnac = %s",
                        GetSQLValueString($row_Recordset1['cod_carrera_hnac'], "int"),
                        GetSQLValueString($pr, "int"),
                        GetSQLValueString(1, "int")
                    );
                    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
                    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
                                        
                                        

                    if ($totalRows_Recordset2==1) {
                        $insertSQL = sprintf(
                            "/* PARSEADORES1 includes\ret_maquinaazul_hnac.php - QUERY 3 */ UPDATE inscritos
				SET 
				est_inscrito_hnac=%s  
				WHERE cod_carrera_hnac=%s AND num_caballo_hnac=%s",
                            GetSQLValueString(0, "int"),
                            GetSQLValueString($row_Recordset1['cod_carrera_hnac'], "int"),
                            GetSQLValueString($pr, "int")
                        );
                        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                        echo 'retirando';
                    
                    
                    
                        // no retirado se procede a retirar
                    }
                }
                echo "</td>";
                echo "</tr>";
            }
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}
mysqli_free_result($Recordset1);
?>
</table>

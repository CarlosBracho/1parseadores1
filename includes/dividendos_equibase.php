<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include('../includes/dividendos_funcion.php');
$fech=fechaactualbd();
list($a, $m, $d)=explode("-", $fech);
$fe=$m.$d.substr($a, 2, 2);
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\dividendos_equibase.php - QUERY 1 */ SELECT * 
	FROM 
	hipodromo,
	carrera 
	WHERE
	hipodromo.nom_hipodromo = carrera.nom_hipodromo AND
	hipodromo.bus_auto = 1 AND
	carrera.eje_primero=0 AND
	carrera.est_carrera=0 AND 
	carrera.fec_carrera=%s",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<div style="background: #F90; color: #FFF; width:758px">
<table width="755" border="0">
  <tr>
  	<td height="41" colspan="3" align="right" valign="middle" style="font-size:36px; color:#000000"><?php echo $horasistema ?></td>
    </tr>
  <tr>
  	<td width="41"> CIERRE</td>
    <td width="520">HIPODROMO</td>
    <td width="180" align="center">RESULTADOS</td>
    </tr>
</table>
</div>
<table width="755" border="1">
<?php
if ($totalRows_Recordset1>0) {
    $t=0;
    do {
        $f=0;
        $cont=1;
        $dir_pag=trim($row_Recordset1['dir_pagresultado']);
        $pre_pag=trim($row_Recordset1['pre_hipodromo']);
        $ext_pag=trim($row_Recordset1['ext_pagresultado']);
        $url=$dir_pag.$pre_pag.$fe.$ext_pag;
        list($cAct, $eje1LugarSimple, $eje2LugarSimple, $eje3LugarSimple, $eje4LugarSimple, $DivWinPriLugar, $DivPlaPriLugar, $DivShoPriLugar, $DivPlaSegLugar, $DivShoSegLugar, $DivShoTerLugar, $eje1LugarDoble, $eje1LugarTriple, $eje2LugarDoble, $eje2LugarTriple, $eje3LugarDoble, $eje3LugarTriple, $eje4LugarTriple, $eje4LugarDoble, $divExotic)=resultadoCarreras($url);
        foreach ($cAct as $hip) {
            if ($hip==$row_Recordset1['num_carrera']) {
                ?>
                  <tr>
                    <td align="center">&nbsp;</td>
                    <td><?php echo $row_Recordset1['nom_hipodromo']."Carr#..".$row_Recordset1['num_carrera']; ?></td>
                    <td align="center"><?php echo $eje1LugarSimple[$hip]; ?></td>
                    <td align="right"><?php echo $DivWinPriLugar[$hip]; ?></td>
                    <td align="right"><?php echo $DivPlaPriLugar[$hip]; ?></td>
                    <td align="right"><?php echo $DivShoPriLugar[$hip]; ?></td>
                  </tr>
                  <tr>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center"><?php echo $eje2LugarSimple[$hip]; ?></td>
                    <td align="center">&nbsp;</td>
                    <td align="center"><?php echo $DivPlaSegLugar[$hip]; ?></td>
                    <td align="center"><?php echo $DivShoSegLugar[$hip]; ?></td>
                  </tr>
                  <tr>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center"><?php echo $eje3LugarSimple[$hip]; ?></td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                    <td align="center"><?php echo $DivShoTerLugar[$hip]; ?></td>
                  </tr>
                  <tr>
                  	<td width="53" align="center">&nbsp;</td>
                    <td width="462">&nbsp;</td>
                    <td width="80" align="center"><?php echo $eje4LugarSimple[$hip]; ?></td>
                    <td width="40" align="center">&nbsp;</td>
                    <td width="40" align="center">&nbsp;</td>
                    <td width="40" align="center">&nbsp;</td>
                  </tr>
				<?php
                /*
                    $updateSQL = sprintf("UPDATE carrera SET hor_carrera=%s, hor_mtp=%s
                                          WHERE cod_carrera=%s",
                                            GetSQLValueString($hor_carrera, "date"),
                                            GetSQLValueString($hor_carrera, "date"),
                                            GetSQLValueString($cod_carrera, "int"));

                    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                $cont=0;
                */
                break;
            }
            $f++;
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}
?>
</table>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include('../includes/dividendos_funcion.php');
$fech=fechaactualbd();
$horasistema=horaactual();

$nomDia=nomDiaActual();
list($divExotic, $cantCarreras)=dividendosNacionales($nomDia);
$ganSimple=ganSimpleHNAC($nomDia);
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 includes\dividendos_total_hnac.php - QUERY 1 */ SELECT * 
	FROM 
	hipodromo_hnac,
	carrera_hnac 
	WHERE
	hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac AND
	carrera_hnac.est_carrera_hnac = 0 AND
	carrera_hnac.est_cierre_hnac >= 1 AND
	carrera_hnac.est_cierre_hnac <= 2 AND
	carrera_hnac.est_confirmacion_hnac = 0 AND
	carrera_hnac.fec_carrera_hnac = %s
	ORDER BY carrera_hnac.num_carrera_hnac ASC",
    GetSQLValueString(fechaactualbd(), "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
function guardaDiv($fec, $codC, $num, $div, $codV, $lin)
{
    list($ejemp, $divid, $tot, $codR)=buscaDivOficiales($codC, $fec, $codV, $lin);


    if ($tot==0) {
        global $conexionbanca;
        $insertSQL = sprintf(
            "/* PARSEADORES1 includes\dividendos_total_hnac.php - QUERY 2 */ INSERT INTO resultados_oficiales_hnac (
			fec_resultado_hnac, 
			cod_carrera_hnac, 
			num_caballo_hnac, 
			div_pago_hnac, 
			cod_tventa_hnac, 
			lin_dividendo,
			fac_div_hnac) 
			VALUES (%s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($fec, "date"),
            GetSQLValueString($codC, "int"),
            GetSQLValueString($num, "text"),
            GetSQLValueString($div/10, "double"),
            GetSQLValueString($codV, "int"),
            GetSQLValueString($lin, "int"),
            GetSQLValueString(10, "double")
        );
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    } else {
        if ($codR>0) {
            global $conexionbanca;
            $insertSQL = sprintf(
                "/* PARSEADORES1 includes\dividendos_total_hnac.php - QUERY 3 */ UPDATE resultados_oficiales_hnac 
				SET 
				num_caballo_hnac=%s, 
				div_pago_hnac=%s 
				WHERE cod_resultado_hnac=%s",
                GetSQLValueString($num, "text"),
                GetSQLValueString($div/10, "double"),
                GetSQLValueString($codR, "int")
            );
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }
    }
    return;
}
?>
<div style="background: #333; color: #FFF; width:100%;">
<table width="100%" border="0">
  <tr>
  	<td height="41" align="right" valign="middle" style="font-size:36px; color:#000000">
	</td>
  	<td height="41" align="right" valign="middle" style="font-size:36px; color:#000000">&nbsp;</td>
  	<td width="417" height="41" align="right" valign="middle" style="font-size:36px; color:#FFFFFF"><?php echo $horasistema ?>.........</td>
  	<td width="4" align="right" valign="middle" style="font-size:36px; color:#000000">&nbsp;</td>
    </tr>
  <tr>
  	<td width="54"> CIERRE</td>
    <td width="520">&nbsp;</td>
    <td colspan="2" align="center">RESULTADOS</td>
    </tr>
</table>
</div>
<div style="background: #CCC; color: #FFF; width:100%;">

<?php
if ($totalRows_Recordset1>0) {
    $t=0;
    $j=0;
    $x=0;
    do {
        $c=$row_Recordset1['num_carrera_hnac'];
        $n=$row_Recordset1['nom_hipodromo_hnac'];
        $fec=$row_Recordset1['fec_carrera_hnac'];
        $codC=$row_Recordset1['cod_carrera_hnac'];
        $carrera=$n."...#".$c;
        if (isset($divExotic[$c][0][0][2]) && $divExotic[$c][0][0][2]!="NO HUBO") { //si hay dividendo a gan 1er lugar
            guardaDiv($fec, $codC, $divExotic[$c][0][0][1], $divExotic[$c][0][0][2], 1, 11);
        }

        if (isset($ganSimple[$c][1]) && $ganSimple[$c][1]!="NO HUBO") { //si hay dividendo a pla 2do lugar
            guardaDiv($fec, $codC, $ganSimple[$c][1], 0, 2, 12);
        }
        
        if (isset($ganSimple[$c][2])) {
            guardaDiv($fec, $codC, $ganSimple[$c][2], 0, 3, 13);
        }
        if (isset($ganSimple[$c][3])) {
            guardaDiv($fec, $codC, $ganSimple[$c][3], 0, 4, 14);
        }


        //NO BORRAR
        /*
        //-------------------------------------
        //if (isset($divExotic[$c][1][0][2]) && $divExotic[$c][1][0][2]!="NO HUBO") //si hay dividendo a pla 1er lugar
            //guardaDiv($fec, $codC, $divExotic[$c][0][0][1], $divExotic[$c][1][0][2], 2, 12);

        if (isset($divExotic[$c][2][0][2]) && $divExotic[$c][2][0][2]!="NO HUBO") //si hay dividendo en exacta
            guardaDiv($fec, $codC, $divExotic[$c][2][0][1], $divExotic[$c][2][0][2], 4, 11);
        if (isset($divExotic[$c][3][0][2]) && $divExotic[$c][3][0][2]!="NO HUBO") //si hay dividendo en trifecta
            guardaDiv($fec, $codC, $divExotic[$c][3][0][1], $divExotic[$c][3][0][2], 5, 11);
        if (isset($divExotic[$c][4][0][1]) && $divExotic[$c][4][0][1]!="NO HUBO") //si hay dividendo en superfecta
            guardaDiv($fec, $codC, $divExotic[$c][4][0][1], $divExotic[$c][4][0][1], 5, 11);
        //------------------------------------------
        */
            
        //echo " - ".$row_Recordset1['cod_carrera_hnac_hnac']." - ".$row_Recordset1['nom_hipodromo_hnac']."<br/>";
        //echo $divExotic[$c][0][0][1].") ".$divExotic[$c][0][0][2]."<br/>";
        //if ($row_Recordset1['bus_auto']>0 && $row_Recordset1['bus_resultado_tip']>0)	{?>
        <table width="100%" border="1" style="color:#000"><?php //echo $row_Recordset1['hor_carrera_hnac']?>
          <tr>
            <td width="6%" align="right"><?php echo $row_Recordset1['hor_carrera_hnac']; ?></td>
            <td width="61%" align="left"><?php echo $n."...#".$c; ?></td>
            <td width="11%" align="right">
            <div id="ejes1<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">
				<?php echo $divExotic[$c][0][0][1]; ?>
            </div>    
            </td>
            <td width="11%" align="right">
			
            <div id="div1<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">
				<?php echo $divExotic[$c][0][0][2]; ?>
            </div>    
            </td>
            <td width="11%" align="right">
            <div id="div2<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">
            </div>    
            </td>
          </tr>
          <tr>
            <td align="center" valign="middle">CORREN</td>
            <td style="font-size:12px">
			<div id="Exac<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">
				<?php if (isset($divExotic[$c][2][0][1])) {
            echo"Ex: ".$divExotic[$c][2][0][1]." => ".$divExotic[$c][2][0][2];
        } ?>
            </div>    
            </td>
            <td align="right">
            <div id="ejes2<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">
				<?php if (isset($ganSimple[$c][1])) {
            echo $ganSimple[$c][1];
        } ?>
            </div>    
            </td>
            <td>&nbsp;</td>
            <td align="right">
            <div id="div3<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">
            </div>    
            </td>
          </tr>
          <tr>
            <td rowspan="2" align="center" valign="middle" style="font-size:36px;">
            	<?php echo $row_Recordset1['can_caballos_hnac']; ?>
            </td>
            <td style="font-size:12px">  
			<div id="Trif<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">
				<?php if (isset($divExotic[$c][3][0][1])) {
            echo "Tr: ".$divExotic[$c][3][0][1]." => ".$divExotic[$c][3][0][2];
        } ?>
            </div>    
            </td>
            <td align="right"><?php if (isset($ganSimple[$c][2])) {
            echo $ganSimple[$c][2];
        } ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="font-size:12px"> 
			<div id="Supe<?php echo $row_Recordset1['cod_carrera_hnac']; ?>">
				<?php if (isset($divExotic[$c][4][0][1])) {
            echo "Su: ".$divExotic[$c][4][0][1]." => ".$divExotic[$c][4][0][2];
        } ?>
            </div>    
            </td>
            <td align="right"><?php if (isset($ganSimple[$c][3])) {
            echo $ganSimple[$c][3];
        } ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5">
				<div id="botReset<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" 
                	style="float:left; padding:0px 15px 0px 0px">
                    <a href="#" onClick="resetDiv('<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#ejes1<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#ejes2<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#div1<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#div2<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#div3<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#divps2<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#Exac<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#Trif<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#Supe<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
						'#botConfirma<?php echo $row_Recordset1['cod_carrera_hnac']; ?>')"
					id="confB<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" 
					title="reset dividendos <?php echo $carrera; ?>" class="btn btn-info" style="color: #FFF">Reset</a>
				</div>   
				<div id="botModifica<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" 
					style="float:left; padding:0px 15px 0px 0px;">
					<a href="#" onClick="ModiDiv('<?php echo $row_Recordset1['cod_carrera_hnac']; ?>','1')" 
					title="modificar dividendos <?php echo $carrera; ?>" 
					class="btn btn-inverse" style="color: #FFF">Modificar</a>
				</div>
				<div id="botCancela<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" 
					style="padding:0px 390px 0px 0px;float:left">
					<a onclick='if(confirm("¿Seguro quiere cancelar la carrera?"))cancelaCar(
						"<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#ejes1<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#ejes2<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#ejes3<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#ejes4<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#divws1<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#divps1<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#divss1<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#divps2<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#divss2<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#divss3<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#exac<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#trif<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#supe<?php echo $row_Recordset1['cod_carrera_hnac']; ?>",
						"#botCancela<?php echo $row_Recordset1['cod_carrera_hnac']; ?>", 
						"#botConfirma<?php echo $row_Recordset1['cod_carrera_hnac']; ?>", 
						"#botReset<?php echo $row_Recordset1['cod_carrera_hnac']; ?>", 
						"#botModifica<?php echo $row_Recordset1['cod_carrera_hnac']; ?>")' 
					class="btn btn-danger" 
					style="color: #FFF" 
					title="cancelar <?php echo $carrera; ?>">Cancelar</a>
				</div>
				<div id="botConfirma<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" 
					style="float:left; text-align:center">
					<?php
                    if ($divExotic[$c][0][0][1]>0  && $divExotic[$c][0][0][2]>0) {?>
						<a href="#" 
							onClick="confirmarDiv(<?php echo $row_Recordset1['cod_carrera_hnac']; ?>,
							'#botConfirma<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
							'#botReset<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
							'#botModifica<?php echo $row_Recordset1['cod_carrera_hnac']; ?>');"
						title="confirmar dividendos <?php echo $carrera; ?>" 
						class="btn btn-success" style="color: #FFF">Confirmar</a>
					<?php
$cont = file_get_contents("http://localhost/includes/ret_maquinaazul_hnac.php");



                    } ?>   
				</div>
            </td>
          </tr>
        </table>
		<?php
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}
?></div>
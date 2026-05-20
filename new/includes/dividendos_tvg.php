<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
include('../includes/dividendos_funcion.php');
$fech=fechaactualbd();
list($a, $m, $d)=explode("-", $fech);
$fe=$m.$d.substr($a, 2, 2);
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\includes\dividendos_tvg.php - QUERY 1 */ SELECT * 
	FROM 
	hipodromo,
	carrera 
	WHERE
	hipodromo.nom_hipodromo = carrera.nom_hipodromo AND
	hipodromo.bus_auto >= 0 AND
	carrera.est_confirmacion = 1 AND
	carrera.est_carrera = 0 AND 
	hipodromo.bus_resultado_tip = 2 AND 
	carrera.fec_carrera = %s",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 10000);
 //-->
 //]]>
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title></head><body>
<div style="background: #3A81B4; color: #FFF; width:100%;">
<table width="100%" border="0" style="font-family:Verdana, Geneva, sans-serif;font-size:16px; color:#FFFFFF">
  <tr  style="color: #FFF">
  	<td height="41" align="right" valign="middle">
	</td>
  	<td height="41" align="left" valign="middle" style="font-size:34px">TVG - DIVIDENDOS</td>
  	<td width="211" height="41" align="right" valign="middle" style="font-size:36px; color:#000000">
		<?php echo $horasistema ?>
    </td>
  	<td width="5" align="right" valign="middle">&nbsp;
    
    </td>
    </tr>
  <tr align="center">
  	<td width="73"> CIERRE</td>
    <td width="688"> HIPODROMO</td>
    <td colspan="2" align="center">RESULTADOS</td>
    </tr>
</table>
</div>
<?php
if ($totalRows_Recordset1>0) {
    $t=0;
    
    do {
        if ($row_Recordset1['bus_auto']>0 && $row_Recordset1['bus_resultado_tip']>0) {
            $f=0;
            $cont=1;
            if ($row_Recordset1['bus_resultado_tip']==2 && $row_Recordset1['fec_carrera']==$fech) {
                $f=explode("-", $fech);
                $fecha=$f[1]."/".$f[2]."/".$f[0];
                        
                $dir_pag=trim($row_Recordset1['dir_pagresultado_tvg']);
                $ext_pag=trim($row_Recordset1['ext_pagresultado_tvg']);
                $url=$dir_pag.$fecha.$ext_pag.$row_Recordset1['num_carrera'];
                list($cAct, $eje1LugarSimple, $eje1LugarDoble, $eje1LugarTriple, $eje2LugarSimple, $eje2LugarDoble, $eje2LugarTriple, $eje3LugarSimple, $eje3LugarDoble, $eje3LugarTriple, $eje4LugarSimple, $eje4LugarDoble, $eje4LugarTriple, $DivWinPriLugar, $DivWinPriLugarDoble, $DivWinPriLugarTriple, $DivPlaPriLugar, $DivPlaPriLugarDoble, $DivPlaPriLugarTriple, $DivShoPriLugar, $DivShoPriLugarDoble, $DivShoPriLugarTriple, $DivPlaSegLugar, $DivPlaSegLugarDoble, $DivPlaSegLugarTriple, $DivShoSegLugar, $DivShoSegLugarDoble, $DivShoSegLugarTriple, $DivShoTerLugar, $DivShoTerLugarDoble, $DivShoTerLugarTriple, $divExotic, $existe)=resultadoTVG($url, 1);
            }
            if (isset($cAct) && isset($cAct[0]) && $cAct[0]>0) {
                foreach ($cAct as $hip) {
                    if ($hip==$row_Recordset1['num_carrera']) {
                        $control_dividendo=$row_Recordset1['control_dividendo']; ?>
                    <table width="100%" border="1" bordercolor="#20c8a8">
					  <tr>
						<td width="53" align="center"><?php echo $row_Recordset1['hor_carrera'] ?></td>
						<td>
							<?php
                            if ($row_Recordset1['bus_resultado_tip']==0) {
                                $pagina="";
                            }
                        if ($row_Recordset1['bus_resultado_tip']==1) {
                            $pagina="--> TRACK INFO";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==2) {
                            $pagina="--> BASIC TVG";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==3) {
                            $pagina="--> BUILDABET";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==4) {
                            $pagina="--> ";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==5) {
                            $pagina="--> ";
                        }

                        list($a, $m, $d)=explode("-", $row_Recordset1['fec_carrera']);
                        $fecha=$d."-".$m."-".$a;
                        $carrera=$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera'];
                        echo $carrera." (".$fecha.") ".$pagina; ?>
                        </td>
						<td width="80" align="center">
                        <div id="ejes1<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php if (isset($eje1LugarSimple[$hip])) {
                            echo $eje1LugarSimple[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>    
                        </td>
						<td width="40" align="right">
                        <div id="divws1<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php if (isset($DivWinPriLugar[$hip])) {
                            echo $DivWinPriLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td width="40" align="right">
                        <div id="divps1<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivPlaPriLugar[$hip])) {
                            echo $DivPlaPriLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td width="40" align="right">
                        <div id="divss1<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivShoPriLugar[$hip])) {
                            echo $DivShoPriLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
						<td align="center" style="font-size:14px;">CORREN</td>
						<td style="font-size:12px">
						<div id="exac<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        /*
                        $divExotic[$hip][0][$ctaEx][0]="EXACTA"; // tipo de exotica
                        $divExotic[$hip][0][$ctaEx][1]=str_replace("/", "-",trim(strip_tags($df[2])));	 // llegada
                        $divExotic[$hip][0][$ctaEx][2]=str_replace("$", "",trim(strip_tags($df[4]))); // dividendo
                        $divExotic[$hip][0][$ctaEx][3]=str_replace("$", "",trim(strip_tags($df[0])));	 // factor
                        */
                        $div_exacta=0;
                        $fac_exacta=0;
                        $div_exacta_doble=0;
                        $div_exacta_triple=0;
                        
                        $ord_exacta="0/0";
                        $ord_exacta_doble="0/0";
                        $ord_exacta_triple="0/0";
                        if (isset($divExotic[$hip][0][0][0])) {
                            $div_exacta=$divExotic[$hip][0][0][2];
                            $fac_exacta=$divExotic[$hip][0][0][3];
                            $ord_exacta=str_replace("-", "/", $divExotic[$hip][0][0][1]);
                            echo"EX: ".$ord_exacta." Pago: ".$div_exacta." ->".$fac_exacta;
                            if (isset($divExotic[$hip][0][1][0])) {
                                $ord_exacta_doble=str_replace("-", "/", $divExotic[$hip][0][1][1]);

                                echo " | EX2: ".$ord_exacta_doble." Pago: ".$divExotic[$hip][0][1][2]." ->".$divExotic[$hip][0][1][3];
                                $div_exacta_doble=$divExotic[$hip][0][1][2];
                            }
                            if (isset($divExotic[$hip][0][2][0])) {
                                $ord_exacta_triple=str_replace("-", "/", $divExotic[$hip][0][2][1]);
                                echo " | EX3: ".$ord_exacta_triple." Pago: ".$divExotic[$hip][0][2][2]." ->".$divExotic[$hip][0][2][3];
                                $div_exacta_triple=$divExotic[$hip][0][2][2];
                            }
                        } ?>
                        </div>
                        </td>
						<td align="center">
						<div id="ejes2<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($eje2LugarSimple[$hip])) {
                            echo $eje2LugarSimple[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td align="right">&nbsp;</td>
						<td align="right">
						<div id="divps2<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivPlaSegLugar[$hip])) {
                            echo $DivPlaSegLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td align="right">
						<div id="divss2<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivShoSegLugar[$hip])) {
                            echo $DivShoSegLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
                      	<?php $van=$row_Recordset1['can_caballos']-cantRetirados($row_Recordset1['cod_carrera']); ?>
						<td rowspan="2" align="center" style="font-size:34px;color:#FFF;background:#C00;"><?php echo $van; ?></td>
						<td style="font-size:12px">
						<div id="trif<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        $div_trifecta=0;
                        $fac_trifecta=0;
                        $div_trifecta_doble=0;
                        $div_trifecta_triple=0;
                        $ord_trifecta="0/0/0";
                        $ord_trifecta_doble="0/0/0";
                        $ord_trifecta_triple="0/0/0";
                        if (isset($divExotic[$hip][1][0][0])) {
                            $div_trifecta=$divExotic[$hip][1][0][2];
                            $fac_trifecta=$divExotic[$hip][1][0][3];
                            
                            
                            $ord_trifecta=str_replace("-", "/", $divExotic[$hip][1][0][1]);
                            echo"TR: ".$ord_trifecta." Pago: ".$div_trifecta." ->".$fac_trifecta;
                            if (isset($divExotic[$hip][1][1][0])) {
                                $ord_trifecta_doble=str_replace("-", "/", $divExotic[$hip][1][1][1]);
                                echo " | TR2: ".$ord_trifecta_doble." Pago: ".$divExotic[$hip][1][1][2]." ->".$divExotic[$hip][1][1][3];
                                $div_trifecta_doble=$divExotic[$hip][1][1][2];
                            }
                            if (isset($divExotic[$hip][1][2][0])) {
                                $ord_trifecta_triple=str_replace("-", "/", $divExotic[$hip][1][2][1]);
                                echo " | TR3: ".$ord_trifecta_triple." Pago: ".$divExotic[$hip][1][2][2]." ->".$divExotic[$hip][1][2][3];
                                $div_trifecta_triple=$divExotic[$hip][1][2][2];
                            }
                        } ?>
                        </div>
                        </td>
						<td align="center">
						<div id="ejes3<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($eje3LugarSimple[$hip])) {
                            echo $eje3LugarSimple[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
						<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td align="right">
						<div id="divss3<?php echo $row_Recordset1['cod_carrera']; ?>">
                        <?php if (isset($DivShoTerLugar[$hip])) {
                            echo $DivShoTerLugar[$hip];
                        } else {
                            echo "&nbsp;";
                        } ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
					    <td style="font-size:12px">
						<div id="supe<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                        $div_superfecta=0;
                        $fac_superfecta=0;
                        $div_superfecta_doble=0;
                        $div_superfecta_triple=0;
                        $ord_superfecta="0/0/0/0";
                        $ord_superfecta_doble="0/0/0/0";
                        $ord_superfecta_triple="0/0/0/0";
                        if (isset($divExotic[$hip][2][0][0])) {
                            $div_superfecta=$divExotic[$hip][2][0][2];
                            $fac_superfecta=$divExotic[$hip][2][0][3];
                            $ord_superfecta=str_replace("-", "/", $divExotic[$hip][2][0][1]);
                            echo"SU: ".$ord_superfecta." Pago: ".$div_superfecta." ->".$fac_superfecta;
                            if (isset($divExotic[$hip][2][1][0])) {
                                $ord_superfecta_doble=str_replace("-", "/", $divExotic[$hip][2][1][1]);
                                echo " | SU2:".$ord_superfecta_doble." Pago: ".$divExotic[$hip][2][1][2]." ->".$divExotic[$hip][2][1][3];
                                $div_superfecta_doble=$divExotic[$hip][2][1][2];
                            }
                            if (isset($divExotic[$hip][2][2][0])) {
                                $ord_superfecta_triple=str_replace("-", "/", $divExotic[$hip][2][2][1]);
                                echo " | SU3:".$ord_superfecta_triple." Pago: ".$divExotic[$hip][2][2][2]." ->".$divExotic[$hip][2][2][3];
                                $div_superfecta_triple=$divExotic[$hip][2][2][2];
                            }
                        } ?>
                        </div>
                        </td>
					    <td align="center">
                        <div id="ejes4<?php echo $row_Recordset1['cod_carrera']; ?>">
                        	<?php
                                if (isset($eje4LugarSimple[$hip]) && $eje4LugarSimple[$hip]>0) {
                                    echo $eje4LugarSimple[$hip];
                                } ?>
                        </div>
                        </td>
					    <td align="right">&nbsp;</td>
					    <td align="right">&nbsp;</td>
					    <td align="right">&nbsp;</td>
  					  </tr>
					  <tr>
					    <td colspan="6" align="left" valign="top">
                        <?php
                        if ($row_Recordset1['cod_confirmacion']==1) {?>
                        	<div id="botReset<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            style="float:left; padding:0px 15px 0px 0px">
                            	<a href="#" onClick="resetDiv('<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divws1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divps1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divps2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss3<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#exac<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#trif<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#supe<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>')"
                                id="confB<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	title="reset dividendos <?php echo $carrera; ?>" class="btn btn-info" style="color: #FFF">Reset</a>
                            </div>   
                             
                            <div id="botModifica<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="float:left; padding:0px 15px 0px 0px;">
                            	<a href="#" onClick="ModiDiv('<?php echo $row_Recordset1['cod_carrera']; ?>','1')" 
                            	title="modificar dividendos <?php echo $carrera; ?>" 
                                class="btn btn-inverse" style="color: #FFF">Modificar</a>
                        	</div>
                        	<div id="botCancela<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="padding:0px 390px 0px 0px;float:left">
									<a onclick='if(confirm("¿Seguro quiere cancelar la carrera?"))cancelaCar(
										"<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divws1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#exac<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#trif<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#supe<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#botCancela<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botReset<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>")' 
                                    class="btn btn-danger" 
                                    style="color: #FFF" 
                                    title="cancelar <?php echo $carrera; ?>">Cancelar</a>
                            </div>
                        	<div id="botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="float:left; text-align:center">
                            <?php
                            if (($eje1LugarSimple[$hip]>0&&$DivWinPriLugar[$hip]>0&&$row_Recordset1['control_dividendo']==2
                            or ($eje1LugarSimple[$hip]==99&&$DivWinPriLugar[$hip]==0&&$row_Recordset1['control_dividendo']==2))) {	?>
                                <a href="#" 
                                onClick="confirmarDiv(<?php echo $row_Recordset1['cod_carrera']; ?>,
                                '#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botReset<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>');"
                                title="confirmar dividendos <?php echo $carrera; ?>" 
                                class="btn btn-success" style="color: #FFF">Confirmar</a>
                             	<?php
                             } else { ?>
                                 <div style="float:right; text-align:center; background: #903; width:195px; height:auto;
                                 	color:#FFF; padding:2px 0px 2px 0px; font-size:14px">
									<i>Verificando resultados<br/>antes de confirmar...</i>
                                 </div>
                                 <?php
                             }?>   
                            </div>
						<?php
                        } else {
                            if (isset($eje1LugarSimple[$hip]) && isset($DivWinPriLugar[$hip]) &&  $eje1LugarSimple[$hip]>0 && $DivWinPriLugar[$hip]>0 && $row_Recordset1['control_dividendo']==2) {
                                echo
                                "<DIV align='center' style='color:red; text-align:center'><strong>CARRERA CONFIRMADA</strong></DIV>";
                            } else {?>
                                 <div style="float:right; text-align:center; background: #F06; width:195px; height:auto;
                                 	color:#FFF; padding:5px 0px 2px 0px; font-size:18px">
									<i>Verificando resultados...</i>
                                 </div>
                                 <?php
                            }
                        } ?>
                        </td>
				      </tr>
                      </table>
					<?php
                        $cod_carrera=$row_Recordset1['cod_carrera'];
                        if (isset($eje1LugarSimple[$hip])) {
                            $eje_primero=$eje1LugarSimple[$hip];
                        } else {
                            $eje_primero=0;
                        }
                        if (isset($eje1LugarDoble[$hip])) {
                            $eje_doble_primero=$eje1LugarDoble[$hip];
                        } else {
                            $eje_doble_primero=0;
                        }
                        if (isset($eje1LugarTriple[$hip])) {
                            $eje_triple_primero=$eje1LugarTriple[$hip];
                        } else {
                            $eje_triple_primero=0;
                        }
                        if (isset($eje2LugarSimple[$hip])) {
                            $eje_segundo=$eje2LugarSimple[$hip];
                        } else {
                            $eje_segundo=0;
                        }
                        if (isset($eje2LugarDoble[$hip])) {
                            $eje_doble_segundo=$eje2LugarDoble[$hip];
                        } else {
                            $eje_doble_segundo=0;
                        }
                        if (isset($eje2LugarTriple[$hip])) {
                            $eje_triple_segundo=$eje2LugarTriple[$hip];
                        } else {
                            $eje_triple_segundo =0;
                        }
                        if (isset($eje3LugarSimple[$hip])) {
                            $eje_tercero =$eje3LugarSimple[$hip];
                        } else {
                            $eje_tercero=0;
                        }
                        if (isset($eje3LugarDoble[$hip])) {
                            $eje_doble_tercero=$eje3LugarDoble[$hip];
                        } else {
                            $eje_doble_tercero=0;
                        }
                        if (isset($eje3LugarTriple[$hip])) {
                            $eje_triple_tercero=$eje3LugarTriple[$hip];
                        } else {
                            $eje_triple_tercero=0;
                        }
                        if (isset($DivWinPriLugar[$hip])) {
                            $div_primero_gan=$DivWinPriLugar[$hip];
                        } else {
                            $div_primero_gan=0;
                        }
                        if (isset($DivPlaPriLugar[$hip])) {
                            $div_primero_pla=$DivPlaPriLugar[$hip];
                        } else {
                            $div_primero_pla=0;
                        }
                        if (isset($DivShoPriLugar[$hip])) {
                            $div_primero_sho=$DivShoPriLugar[$hip];
                        } else {
                            $div_primero_sho=0;
                        }
                        if (isset($DivWinPriLugarDoble[$hip])) {
                            $div_doble_primero_gan=$DivWinPriLugarDoble[$hip];
                        } else {
                            $div_doble_primero_gan =0;
                        }
                        if (isset($DivPlaPriLugarDoble[$hip])) {
                            $div_doble_primero_pla=$DivPlaPriLugarDoble[$hip];
                        } else {
                            $div_doble_primero_pla=0;
                        }
                        if (isset($DivShoPriLugarDoble[$hip])) {
                            $div_doble_primero_sho=$DivShoPriLugarDoble[$hip];
                        } else {
                            $div_doble_primero_sho=0;
                        }
                        if (isset($DivWinPriLugarTriple[$hip])) {
                            $div_triple_primero_gan=$DivWinPriLugarTriple[$hip];
                        } else {
                            $div_triple_primero_gan =0;
                        }
                        if (isset($DivPlaPriLugarTriple[$hip])) {
                            $div_triple_primero_pla=$DivPlaPriLugarTriple[$hip];
                        } else {
                            $div_triple_primero_pla=0;
                        }
                        if (isset($DivShoPriLugarTriple[$hip])) {
                            $div_triple_primero_sho=$DivShoPriLugarTriple[$hip];
                        } else {
                            $div_triple_primero_sho=0;
                        }
                        if (isset($DivPlaSegLugar[$hip])) {
                            $div_segundo_pla=$DivPlaSegLugar[$hip];
                        } else {
                            $div_segundo_pla=0;
                        }
                        if (isset($DivShoSegLugar[$hip])) {
                            $div_segundo_sho=$DivShoSegLugar[$hip];
                        } else {
                            $div_segundo_sho=0;
                        }
                        if (isset($DivPlaSegLugarDoble[$hip])) {
                            $div_doble_segundo_pla=$DivPlaSegLugarDoble[$hip];
                        } else {
                            $div_doble_segundo_pla=0;
                        }
                        if (isset($DivShoSegLugarDoble[$hip])) {
                            $div_doble_segundo_sho=$DivShoSegLugarDoble[$hip];
                        } else {
                            $div_doble_segundo_sho=0;
                        }
                        if (isset($DivPlaSegLugarTriple[$hip])) {
                            $div_triple_segundo_pla=$DivPlaSegLugarTriple[$hip];
                        } else {
                            $div_triple_segundo_pla=0;
                        }
                        if (isset($DivShoSegLugarTriple[$hip])) {
                            $div_triple_segundo_sho=$DivShoSegLugarTriple[$hip];
                        } else {
                            $div_triple_segundo_sho=0;
                        }
                        if (isset($DivShoTerLugar[$hip])) {
                            $div_tercero_sho=$DivShoTerLugar[$hip];
                        } else {
                            $div_tercero_sho=0;
                        }
                        if (isset($DivShoTerLugarDoble[$hip])) {
                            $div_doble_tercero_sho=$DivShoTerLugarDoble[$hip];
                        } else {
                            $div_doble_tercero_sho=0;
                        }
                        if (isset($DivShoTerLugarTriple[$hip])) {
                            $div_triple_tercero_sho=$DivShoTerLugarTriple[$hip];
                        } else {
                            $div_triple_tercero_sho=0;
                        }
                        if (isset($eje4LugarSimple[$hip])) {
                            $eje_cuarto=$eje4LugarSimple[$hip];
                        } else {
                            $eje_cuarto=0;
                        }
                        if ($eje_primero==0 && $eje_segundo==99 && $eje_tercero =99) {
                            $eje_primero=99;
                        }
                        if ($row_Recordset1['control_dividendo']==1) {
                            if ($row_Recordset1['eje_primero']==$eje_primero*1 &&
                    number_format($row_Recordset1['div_primero_gan'], 2)==number_format(floatval($div_primero_gan), 2) &&
                    number_format($row_Recordset1['div_primero_pla'], 2)==number_format(floatval($div_primero_pla), 2) &&
                    number_format($row_Recordset1['div_primero_sho'], 2)==number_format(floatval($div_primero_sho), 2) &&
                    $row_Recordset1['eje_segundo']==$eje_segundo*1 &&
                    number_format($row_Recordset1['div_segundo_pla'], 2)==number_format(floatval($div_segundo_pla), 2) &&
                    number_format($row_Recordset1['div_segundo_sho'], 2)==number_format(floatval($div_segundo_sho), 2) &&
                    $row_Recordset1['eje_tercero']==$eje_tercero*1 &&
                    number_format($row_Recordset1['div_tercero_sho'], 2)==number_format(floatval($div_tercero_sho), 2) &&
                    $row_Recordset1['eje_doble_primero']==$eje_doble_primero*1 &&
                    number_format($row_Recordset1['div_doble_primero_gan'], 2)==number_format(floatval($div_doble_primero_gan), 2) &&
                    number_format($row_Recordset1['div_doble_primero_pla'], 2)==number_format(floatval($div_doble_primero_pla), 2) &&
                    number_format($row_Recordset1['div_doble_primero_sho'], 2)==number_format(floatval($div_doble_primero_sho), 2) &&
                    $row_Recordset1['eje_doble_segundo']==$eje_doble_segundo*1 &&
                    number_format($row_Recordset1['div_doble_segundo_pla'], 2)==number_format(floatval($div_doble_segundo_pla), 2) &&
                    number_format($row_Recordset1['div_doble_segundo_sho'], 2)==number_format(floatval($div_doble_segundo_sho), 2) &&
                    $row_Recordset1['eje_doble_tercero']==$eje_doble_tercero*1 &&
                    number_format($row_Recordset1['div_doble_tercero_sho'], 2)==number_format(floatval($div_doble_tercero_sho), 2) &&
                    $row_Recordset1['eje_triple_primero']==$eje_triple_primero*1 &&
                    number_format($row_Recordset1['div_triple_primero_gan'], 2)==number_format(floatval($div_triple_primero_gan), 2) &&
                    number_format($row_Recordset1['div_triple_primero_pla'], 2)==number_format(floatval($div_triple_primero_pla), 2) &&
                    number_format($row_Recordset1['div_triple_primero_sho'], 2)==number_format(floatval($div_triple_primero_sho), 2) &&
                    $row_Recordset1['eje_triple_segundo']==$eje_triple_segundo*1 &&
                    number_format($row_Recordset1['div_triple_segundo_pla'], 2)==number_format(floatval($div_triple_segundo_pla), 2) &&
                    number_format($row_Recordset1['div_triple_segundo_sho'], 2)==number_format(floatval($div_triple_segundo_sho), 2) &&
                    $row_Recordset1['eje_triple_tercero']==$eje_triple_tercero*1 &&
                    number_format($row_Recordset1['div_triple_tercero_sho'], 2)==number_format(floatval($div_triple_tercero_sho), 2) &&
                    $row_Recordset1['eje_cuarto']==$eje_cuarto*1 &&
                    number_format($row_Recordset1['div_exacta'], 2)==number_format(floatval($div_exacta), 2) &&
                    number_format($row_Recordset1['fac_exacta'], 2)==number_format(floatval($fac_exacta), 2) &&
                    number_format($row_Recordset1['div_trifecta'], 2)==number_format(floatval($div_trifecta), 2) &&
                    number_format($row_Recordset1['fac_trifecta'], 2)==number_format(floatval($fac_trifecta), 2) &&
                    number_format($row_Recordset1['div_superfecta'], 2)==number_format(floatval($div_superfecta), 2) &&
                    number_format($row_Recordset1['fac_superfecta'], 2)==number_format(floatval($fac_superfecta), 2) &&
                    number_format($row_Recordset1['div_exacta_doble'], 2)==number_format(floatval($div_exacta_doble), 2) &&
                    number_format($row_Recordset1['div_exacta_triple'], 2)==number_format(floatval($div_exacta_triple), 2) &&
                    number_format($row_Recordset1['div_trifecta_doble'], 2)==number_format(floatval($div_trifecta_doble), 2) &&
                    number_format($row_Recordset1['div_trifecta_triple'], 2)==number_format(floatval($div_trifecta_triple), 2) &&
                    number_format($row_Recordset1['div_superfecta_doble'], 2)==number_format(floatval($div_superfecta_doble), 2) &&
                    number_format($row_Recordset1['div_superfecta_triple'], 2)==number_format(floatval($div_superfecta_triple), 2) &&
                    $row_Recordset1['ord_exacta']==trim($ord_exacta) &&
                    $row_Recordset1['ord_exacta_doble']==trim($ord_exacta_doble) &&
                    $row_Recordset1['ord_exacta_triple']==trim($ord_exacta_triple) &&
                    $row_Recordset1['ord_trifecta']==trim($ord_trifecta) &&
                    $row_Recordset1['ord_trifecta_doble']==trim($ord_trifecta_doble) &&
                    $row_Recordset1['ord_trifecta_triple']==trim($ord_trifecta_triple) &&
                    $row_Recordset1['ord_superfecta']==trim($ord_superfecta) &&
                    $row_Recordset1['ord_superfecta_doble']==trim($ord_superfecta_doble) &&
                    $row_Recordset1['ord_superfecta_triple']==trim($ord_superfecta_triple)) {
                                $control_dividendo=2;
                            } else {
                                $control_dividendo=1;
                                $est_confirmacion=1;
                            }
                        }
                        if ($row_Recordset1['cod_confirmacion']==1 && $eje1LugarSimple[$hip]>0) {
                            $est_confirmacion=1;
                        } else {
                            if ($row_Recordset1['control_dividendo']==2) {
                                $est_confirmacion=0;
                            } else {
                                $est_confirmacion=1;
                            }
                        }
                        //if ($control_dividendo==2) $est_confirmacion=0;
                        //echo number_format($row_Recordset1['div_superfecta'],2)." - ".number_format(floatval($div_superfecta),2);
                        if ((isset($eje1LugarSimple[$hip]) && isset($DivWinPriLugar[$hip]) && $eje1LugarSimple[$hip]>0 &&
                            $DivWinPriLugar[$hip]>0) ||
                            (isset($eje1LugarSimple[$hip]) && isset($DivWinPriLugar[$hip]) && $eje1LugarSimple[$hip]==99 &&
                            $DivWinPriLugar[$hip]==0)) {
                            if ($row_Recordset1['control_dividendo']==0) {
                                $control_dividendo=1;
                            }
                            $updateSQL = sprintf(
                                "/* PARSEADORES1 new\includes\dividendos_tvg.php - QUERY 2 */ UPDATE carrera 
							SET 
								est_confirmacion=%s,
								control_dividendo=%s,
								eje_primero=%s, 
								div_primero_gan=%s, 
								div_primero_pla=%s, 
								div_primero_sho=%s, 
								eje_segundo=%s, 
								div_segundo_pla=%s, 
								div_segundo_sho=%s, 
								eje_tercero=%s, 
								div_tercero_sho=%s, 
								eje_doble_primero=%s, 
								div_doble_primero_gan=%s, 
								div_doble_primero_pla=%s, 
								div_doble_primero_sho=%s, 
								eje_doble_segundo=%s, 
								div_doble_segundo_pla=%s, 
								div_doble_segundo_sho=%s, 
								eje_doble_tercero=%s, 
								div_doble_tercero_sho=%s, 
								eje_triple_primero=%s, 
								div_triple_primero_gan=%s, 
								div_triple_primero_pla=%s, 
								div_triple_primero_sho=%s, 
								eje_triple_segundo=%s, 
								div_triple_segundo_pla=%s, 
								div_triple_segundo_sho=%s, 
								eje_triple_tercero=%s, 
								div_triple_tercero_sho=%s,
								eje_cuarto=%s,
								div_exacta=%s,
								fac_exacta=%s,
								div_trifecta=%s,
								fac_trifecta=%s,
								div_superfecta=%s,
								fac_superfecta=%s,
								div_exacta_doble=%s,
								div_exacta_triple=%s,
								div_trifecta_doble=%s,
								div_trifecta_triple=%s,
								div_superfecta_doble=%s,
								div_superfecta_triple=%s,
								
								ord_exacta=%s,
								ord_exacta_doble=%s,
								ord_exacta_triple=%s,
								ord_trifecta=%s,
								ord_trifecta_doble=%s,
								ord_trifecta_triple=%s,
								ord_superfecta=%s,
								ord_superfecta_doble=%s,
								ord_superfecta_triple=%s
								
							WHERE cod_carrera=%s",
                                GetSQLValueString($est_confirmacion, "int"),
                                GetSQLValueString($control_dividendo, "int"),
                                GetSQLValueString($eje_primero, "int"),
                                GetSQLValueString($div_primero_gan, "double"),
                                GetSQLValueString($div_primero_pla, "double"),
                                GetSQLValueString($div_primero_sho, "double"),
                                GetSQLValueString($eje_segundo, "int"),
                                GetSQLValueString($div_segundo_pla, "double"),
                                GetSQLValueString($div_segundo_sho, "double"),
                                GetSQLValueString($eje_tercero, "int"),
                                GetSQLValueString($div_tercero_sho, "double"),
                                GetSQLValueString($eje_doble_primero, "int"),
                                GetSQLValueString($div_doble_primero_gan, "double"),
                                GetSQLValueString($div_doble_primero_pla, "double"),
                                GetSQLValueString($div_doble_primero_sho, "double"),
                                GetSQLValueString($eje_doble_segundo, "int"),
                                GetSQLValueString($div_doble_segundo_pla, "double"),
                                GetSQLValueString($div_doble_segundo_sho, "double"),
                                GetSQLValueString($eje_doble_tercero, "int"),
                                GetSQLValueString($div_doble_tercero_sho, "double"),
                                GetSQLValueString($eje_triple_primero, "int"),
                                GetSQLValueString($div_triple_primero_gan, "double"),
                                GetSQLValueString($div_triple_primero_pla, "double"),
                                GetSQLValueString($div_triple_primero_sho, "double"),
                                GetSQLValueString($eje_triple_segundo, "int"),
                                GetSQLValueString($div_triple_segundo_pla, "double"),
                                GetSQLValueString($div_triple_segundo_sho, "double"),
                                GetSQLValueString($eje_triple_tercero, "int"),
                                GetSQLValueString($div_triple_tercero_sho, "double"),
                                GetSQLValueString($eje_cuarto, "int"),
                                GetSQLValueString($div_exacta, "double"),
                                GetSQLValueString($fac_exacta, "double"),
                                GetSQLValueString($div_trifecta, "double"),
                                GetSQLValueString($fac_trifecta, "double"),
                                GetSQLValueString($div_superfecta, "double"),
                                GetSQLValueString($fac_superfecta, "double"),
                                GetSQLValueString($div_exacta_doble, "double"),
                                GetSQLValueString($div_exacta_triple, "double"),
                                GetSQLValueString($div_trifecta_doble, "double"),
                                GetSQLValueString($div_trifecta_triple, "double"),
                                GetSQLValueString($div_superfecta_doble, "double"),
                                GetSQLValueString($div_superfecta_triple, "double"),
                                GetSQLValueString($ord_exacta, "text"),
                                GetSQLValueString($ord_exacta_doble, "text"),
                                GetSQLValueString($ord_exacta_triple, "text"),
                                GetSQLValueString($ord_trifecta, "text"),
                                GetSQLValueString($ord_trifecta_doble, "text"),
                                GetSQLValueString($ord_trifecta_triple, "text"),
                                GetSQLValueString($ord_superfecta, "text"),
                                GetSQLValueString($ord_superfecta_doble, "text"),
                                GetSQLValueString($ord_superfecta_triple, "text"),
                                GetSQLValueString($cod_carrera, "int")
                            );
                            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                            if ($est_confirmacion==0) {
                                $tipoProceso=2;
                                include("procesar_resultados_tickets_ame.php");
                                echo "<h3><font color='#027BAD'>Proceso de cálculo culminado! ".$carrera."</font></h3>";
                            }
                        }
                        $cont=0;
                        break;
                    }
                    $f++;
                }
            } else {?>
			<table width="100%" border="1" bordercolor="#20c8a8">
				<tr>
					<td width="53" align="center"><?php echo $row_Recordset1['hor_carrera'] ?></td>
					<td width="678" rowspan="3"><?php
                        if ($row_Recordset1['bus_resultado_tip']==0) {
                            $pagina="";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==1) {
                            $pagina="--> TRACK INFO";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==2) {
                            $pagina="--> BASIC TVG";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==3) {
                            $pagina="--> BUILDABET";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==4) {
                            $pagina="--> ";
                        }
                        if ($row_Recordset1['bus_resultado_tip']==5) {
                            $pagina="--> ";
                        }
                        list($a, $m, $d)=explode("-", $row_Recordset1['fec_carrera']);
                        $fecha=$d."-".$m."-".$a;
                        $carrera=$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera'];
                        echo $carrera." (".$fecha.") ".$pagina; ?>
                        <div id="botCancela<?php echo $row_Recordset1['cod_carrera']; ?>" 
                           	style="padding:0px 390px 0px 0px;float:left">
							<a onclick='if(confirm("¿Seguro quiere cancelar la carrera?"))cancelaCar(
								"<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divws1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#exac<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#trif<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#supe<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#botCancela<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botReset<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>")' 
								class="btn btn-danger" style="color: #FFF" title="cancelar <?php echo $carrera; ?>">Cancelar
							</a>
						</div>
                    </td>
					<td width="379" rowspan="3" align="center">Esperando por resultados...
					</td>
				</tr>
				<tr>
					
					<td align="center"><span style="font-size:14px;">CORREN</span>
					</td>
			    </tr>
				<tr>
                	<?php $van=$row_Recordset1['can_caballos']-cantRetirados($row_Recordset1['cod_carrera']); ?>
					<td height="43" align="center"style="font-size:34px;color:#FFF;background:#C00;"><?php echo $van; ?></td>
				</tr>
			</table>
		<?php
        }
        }	//fin if si es track info
        else {?>
                    <table width="100%" border="1" bordercolor="#F90" style="color:#FF0000">
					  <tr>
					    <td colspan="6" align="center"><strong>--CARGAR DIVIDENDOS MANUALMENTE--</strong></td>
				      </tr>
					  <tr>
						<td width="53" align="center"><?php echo $row_Recordset1['hor_carrera'] ?></td>
						<td>
							<?php
                            list($a, $m, $d)=explode("-", $row_Recordset1['fec_carrera']);
                            $fecha=$d."-".$m."-".$a;
                            $carrera=$row_Recordset1['nom_hipodromo']." Carr...".$row_Recordset1['num_carrera'];
                            echo $carrera." (".$fecha.")"; ?>
                        </td>
						<td width="80" align="center">
                        <div id="ejes1<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['eje_primero']; ?>
                        </div>    
                        </td>
						<td width="40" align="right">
                        <div id="divws1<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_primero_gan']; ?>
                        </div>
                        </td>
						<td width="40" align="right">
                        <div id="divps1<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_primero_pla']; ?>
                        </div>
                        </td>
						<td width="40" align="right">
                        <div id="divss1<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_primero_sho']; ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
						<td align="center">&nbsp;</td>
						<td style="font-size:12px">
						<div id="exac<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                            if ($row_Recordset1['eje_tercero']>0 && $row_Recordset1['eje_segundo']>0) {
                                $eex=$row_Recordset1['eje_primero']."-".$row_Recordset1['eje_segundo'];
                                echo"EX: ".$eex." Pago: ".$row_Recordset1['div_exacta']." ->".$row_Recordset1['fac_exacta'];
                            }
                        ?>
                        </div>
                        </td>
						<td align="center">
						<div id="ejes2<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['eje_segundo']; ?>
                        </div>
                        </td>
						<td align="right">&nbsp;</td>
						<td align="right">
						<div id="divps2<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_segundo_pla']; ?>
                        </div>
                        </td>
						<td align="right">
						<div id="divss2<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_segundo_sho']; ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
						<td align="center">&nbsp;</td>
						<td style="font-size:12px">
						<div id="trif<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                            if ($row_Recordset1['eje_tercero']>0 && $row_Recordset1['eje_segundo']>0
                                && $row_Recordset1['eje_primero']>0) {
                                $etr=$row_Recordset1['eje_primero']."-".$row_Recordset1['eje_segundo']."-".$row_Recordset1['eje_tercero'];
                                echo "| TR".$etr." Pago: ".$row_Recordset1['div_trifecta'];
                                " ->".$row_Recordset1['fac_trifecta'];
                            }
                        ?>
                        </div>
                        </td>
						<td align="center">
						<div id="ejes3<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['eje_tercero']; ?>
                        </div>
                        </td>
						<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td align="right">
						<div id="divss3<?php echo $row_Recordset1['cod_carrera']; ?>">
							<?php echo $row_Recordset1['div_tercero_sho']; ?>
                        </div>
                        </td>
					  </tr>
					  <tr>
					    <td align="center">&nbsp;</td>
					    <td style="font-size:12px">
						<div id="supe<?php echo $row_Recordset1['cod_carrera']; ?>">
						<?php
                            if ($row_Recordset1['eje_tercero']>0 && $row_Recordset1['eje_segundo']>0
                                && $row_Recordset1['eje_primero']>0 && $row_Recordset1['eje_cuarto']>0) {
                                $esp=$row_Recordset1['eje_primero']."-".$row_Recordset1['eje_segundo']."-".$row_Recordset1['eje_tercero']."-".$row_Recordset1['eje_cuarto'];
                                echo"SU: ".$esp." Pago: ".$row_Recordset1['div_superfecta']." ->".$row_Recordset1['fac_superfecta'];
                            }
                        ?>
                        </div>
                        </td>
					    <td align="center">
                        <div id="ejes4<?php echo $row_Recordset1['cod_carrera']; ?>">
                        	<?php echo $row_Recordset1['eje_cuarto']; ?>
                        </div>
                        </td>
					    <td align="right">&nbsp;</td>
					    <td align="right">&nbsp;</td>
					    <td align="right">&nbsp;</td>
  					  </tr>
					  <tr>
					    <td colspan="6" align="left" valign="top">
                        	<div id="botReset<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            style="float:left; padding:0px 15px 0px 0px">
                            	<a href="#" onClick="resetDiv('<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divws1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divps1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss1<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divps2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss2<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#divss3<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#exac<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#trif<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#supe<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>')"
                                id="botR<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	title="reset dividendos <?php echo $carrera; ?>" class="btn btn-info" style="color: #FFF">Reset</a>
                            </div>   
                             
                            <div id="botModifica<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            style="float:left; padding:0px 15px 0px 0px">
                            	<a href="#" onClick="ModiDiv('<?php echo $row_Recordset1['cod_carrera']; ?>','1')" 
                            	title="modificar dividendos <?php echo $carrera; ?>" 
                                class="btn btn-inverse" style="color: #FFF">Modificar</a>
                        	</div>
                        	<div id="botCancela<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="padding:0px 390px 0px 0px;float:left">
									<a onclick='if(confirm("¿Seguro quiere cancelar la carrera?"))cancelaCar(
										"<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#ejes4<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divws1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss1<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divps2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss2<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#divss3<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#exac<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#trif<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#supe<?php echo $row_Recordset1['cod_carrera']; ?>",
                                        "#botCancela<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botReset<?php echo $row_Recordset1['cod_carrera']; ?>", 
                                        "#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>")' 
                                    class="btn btn-danger" 
                                    style="color: #FFF" 
                                    title="cancelar <?php echo $carrera; ?>">Cancelar</a>
                            </div>
                        	<div id="botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>" 
                            	style="float:left; text-align:center">
                            <?php
                            if ($row_Recordset1['eje_primero']>0) {?>
                                <a href="#" onClick="confirmarDiv(<?php echo $row_Recordset1['cod_carrera']; ?>,
                                '#botConfirma<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botReset<?php echo $row_Recordset1['cod_carrera']; ?>',
                                '#botModifica<?php echo $row_Recordset1['cod_carrera']; ?>');"
                                title="confirmar dividendos <?php echo $carrera; ?>" 
                                class="btn btn-success" style="color: #FFF">Confirmar</a>
                            	<?php
                            }?>    
                            </div>
                        </td>
				      </tr>
                      </table>
	<?php }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    
    mysqli_free_result($Recordset1);
}
if (!isset($f)) {?>
	<div style="float:right; text-align:center; background: #FFF; width:100%; height:auto;
	color: #333; padding:25px 0px 2px 0px; font-size:24px">
		<i class="fa fa-refresh fa-spin"></i> Esperando por cierre de alguna carrera
	</div>
	<?php
}
?>
</body></html>

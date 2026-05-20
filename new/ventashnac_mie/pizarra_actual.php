 					<?php
                    if (isset($_POST["iD"])) {
                        require_once('../Connections/conexionbanca.php');
                        $taquilla=$_POST["codtaquilla"];
                        $carreraActual=$_POST["iD"];
                        $usuarioVenta=$_POST["codusuario"];
                    }
                    $query_Recordset2 = sprintf(
                        "/* PARSEADORES1 new\ventashnac_mie\pizarra_actual.php - QUERY 1 */ SELECT 
							ins.num_caballo_hnac, 
							ins.nom_caballo_hnac,
							ins.est_inscrito_hnac, 
							ins.est_favorito_hnac,
							ins.cod_inscrito_hnac,
							ca.can_caballos_hnac,
							pr.max_eje_hnac,
							pr.pre_fijo_hnac,
							ca.fec_carrera_hnac,
							CONCAT(hi.nom_hipodromo_hnac, ' Carr...', ca.num_carrera_hnac) AS carrera
						FROM 
							hipodromo_hnac hi, carrera_hnac ca, precio_fijo_hnac pr
							RIGHT JOIN inscritos ins 
								ON pr.cod_inscrito_hnac = ins.cod_inscrito_hnac AND pr.cod_taquilla = %s
						WHERE
							hi.cod_hipodromo_hnac = ca.cod_hipodromo_hnac AND
							ca.cod_carrera_hnac =  ins.cod_carrera_hnac AND
							ca.cod_carrera_hnac = %s 
						ORDER BY 
							ins.num_caballo_hnac ASC",
                        GetSQLValueString($taquilla, "int"),
                        GetSQLValueString($carreraActual, "int")
                    );
                    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
                    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
                    if ((isset($totalRows_Recordset2) or isset($_POST["iD"])) && $totalRows_Recordset2>0) {?>
                    	<div style="height:37px; float:left; width:100%">
                            <table width="100%" border="0" style="font-size:10px;border-bottom: 1px solid #C1BDBE;"cellpadding="0" 
                                cellspacing="0">
                                <tr>
                                    <td colspan="5" style="font-size:14px; color:#FFFFFF">
                                    <?php echo $row_Recordset2['carrera']; ?>
                                    </td>
                                </tr>
                              <tr>
                                <td width="5%" >&nbsp;No</td>
                                <td width="38%" >EJEMPLAR</td>
                                <td width="18%" >GAN</td>
                                <td width="18%" >PLA</td>
                                <td width="21%" >TOTAL</td>
                              </tr>
                            </table>
                        </div>    
                        <div id="caballos" style="font-size:16px;width:100%;float:left;background:#e0e0e0;height:215px;
                        	background:#333;overflow: auto; text-align:center; 
                            font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
                          <table width="99%" border="0" style="font-size:10px;" cellpadding="0" cellspacing="0">  
                              <?php
                              $totCarr=0;
                              if (isset($totalRows_Recordset2) && $totalRows_Recordset2>0) {
                                  do {
                                      if ($row_Recordset2['max_eje_hnac']==false) {
                                          if ($row_Recordset2['est_favorito_hnac']==1) {
                                              $tipFav=" 1F";
                                          } elseif ($row_Recordset2['est_favorito_hnac']==2) {
                                              $tipFav=" 2F";
                                          } elseif ($row_Recordset2['est_favorito_hnac']==3) {
                                              $tipFav=" 3F";
                                          } else {
                                              $tipFav="&nbsp;";
                                          }
                                      } else {
                                          $tipFav='<font color="#FF0000">P.Fijo '.$row_Recordset2['pre_fijo_hnac'].'</font>';
                                      }
                                      if ($row_Recordset2['est_inscrito_hnac']==0) {?>
                                      <tr style="background: #C03; color:#FFFFFF;">
                                        <td width="5%">
										<?php echo $row_Recordset2['num_caballo_hnac']; ?>
                                        </td>
                                        <td width="33%" style="text-align:left">
										<?php
                                            $nomCab=$row_Recordset2['nom_caballo_hnac'];
                                            if (strlen($nomCab)>15) {
                                                $nomCab=substr($nomCab, 0, 10)."...";
                                            }
                                            echo $nomCab; ?>
                                        </td>
                                        <td colspan="5" >RETIRADO</td>
                                      </tr>  
                                      <?php
                                      } else {
                                          $gan=0;
                                          $pla=0;
                                          $mon=0;
                                          if (isset($totalRows_Recordset2)) {
                                              list($gan, $pla, $mon)=venPorCabUsu(
                                                  $carreraActual,
                                                  $usuarioVenta,
                                                  $row_Recordset2['num_caballo_hnac'],
                                                  $row_Recordset2['fec_carrera_hnac']
                                              );
                                              $totCarr=$totCarr+$mon;
                                          }
                                          if ($row_Recordset2['est_favorito_hnac']>0 && $row_Recordset2['est_favorito_hnac']<5 or
                                            $row_Recordset2['max_eje_hnac']==true) {?>
                                    <tr style="background: #FFC; color:#000000;"></tr>
                                    <?php } else {?>
                                    <tr style="background: #FFF; color:#000000;">
                                    <?php } ?>
                                        <td width="5%" height="11" style="border-bottom: 1px solid #C1BDBE;">
										<?php echo $row_Recordset2['num_caballo_hnac']; ?>
                                        </td>
                                        <td style="text-align:left;border-bottom: 1px solid #C1BDBE;" width="33%">
										<?php
                                            $nomCab=$row_Recordset2['nom_caballo_hnac'];
                                          if (strlen($nomCab)>15) {
                                              $nomCab=substr($nomCab, 0, 10)."...";
                                          }
                                          echo $nomCab; ?>
										</td>
                                        <td width="5%" align="left" style="border-bottom: 1px solid #C1BDBE;">
										<?php echo $tipFav; ?>
                                        </td>
                                        <td width="18%" align="right" style="border-bottom: 1px solid #C1BDBE;">
										<?php echo number_format($gan, 0, ",", "."); ?>
                                        </td>
                                        <td width="18%" align="right" style="border-bottom: 1px solid #C1BDBE;">
										<?php echo number_format($pla, 0, ",", "."); ?>
                                        </td>
                                        <td width="21%" align="right" style="border-bottom: 1px solid #C1BDBE;">
										<?php echo number_format($mon, 0, ",", "."); ?>
                                        </td>
                                      <?php
                                      } ?>
                                    </tr>
                                   <?php
                                  } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                              }?>
                              <tr style="background:#FFFFFF; color:#000000">
                                <td colspan="6" height="2" style="font-size:2px;background:#C1BDBE;">&nbsp;</td>
                              </tr>
                            </table>
                          </div>
                          <div style="background:#333; width:97.5%; height:38px; padding:4px">
                            <table width="99%" border="0" cellpadding="0" cellspacing="0">
                              <tr style="color:#000000">
                                <td style="font-size:14px; text-align:left">
                                	<?php if ($carreraActual>0) {?>
									<input type="button" style="width:80px; font-size:11px; margin:0px 0px 0px 0px" 
									value="Imp. Pizarra" onclick="javascript:window.open('t_imprimePizarra.php?uCarre=<?php echo $carreraActual?>&uVenta=<?php echo $usuarioVenta?>', '_blank');"/><?php
                                    }?>
                                </td>
                              </tr>
                                <tr style="font-size:20px">
                                    <td style="text-align:right">
                                        <?php if ($carreraActual>0) {?>
                                        TOTAL:&nbsp;<?php echo number_format($totCarr, 2, ",", ".");
                                        }?>
                                        </td>
                                      </tr>
                            </table>
						</div>	<?php
                    }?>
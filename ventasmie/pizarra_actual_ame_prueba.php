 					<?php
                    if (isset($_POST["iD"])) {
                        require_once('../Connections/conexionbanca.php');
                        
                        $carreraActual=$_POST["iD"];
                        $taquilla=$_POST["codtaquilla"];
                        $usuarioVenta=$_POST["codusuario"];

                        //echo $taquilla.' '.$usuarioVenta;
                    }
                    $query_Recordset2 = sprintf(
                        "/* PARSEADORES1 ventasmie\pizarra_actual_ame_prueba.php - QUERY 1 */ SELECT 
						re.num_rcaballo, ca.nom_hipodromo, ca.can_caballos, ve.mon_venta, ve.cod_tventa
						FROM 
                        retirados re, carrera ca, venta ve
						WHERE
						ca.cod_carrera=%s AND re.cod_carrera = ca.cod_carrera AND ve.cod_carrera=ca.cod_carrera",
                        GetSQLValueString($carreraActual, "int")        
                    );
                    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
                    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

                    $query_Recordset2d = sprintf(
                      "/* PARSEADORES1 ventasmie\pizarra_actual_ame_prueba.php - QUERY 2 */ SELECT 
          ca.nom_hipodromo, ca.can_caballos, fec_carrera
          FROM 
                     carrera ca
          WHERE
          ca.cod_carrera=%s ",
                      GetSQLValueString($carreraActual, "int")        
                  );
                  $Recordset2d = mysqli_query($conexionbanca, $query_Recordset2d) or die(mysqli_error($conexionbanca));
                  $row_Recordset2d = mysqli_fetch_assoc($Recordset2d);
                  $totalRows_Recordset2d = mysqli_num_rows($Recordset2d);
                  
                    
                    echo $row_Recordset2['nom_hipodromo'];
                    
                    if ((isset($totalRows_Recordset2d) or isset($_POST["iD"])) && $totalRows_Recordset2d>0) {?>
                    	<div style="height:15px; float:left; width:100%">
                            <table width="100%" border="0" style="font-size:10px;border-bottom: 1px solid #C1BDBE;"cellpadding="0" 
                                cellspacing="0">
                                <tr>
                                    <td colspan="5" style="font-size:14px; color:#FFFFFF">
                                    <?php //echo $row_Recordset2['carrera']; ?>
                                    </td>
                                </tr>
                              <tr>
                              <td width="5%" >&nbsp;No</td>
                                <td width="36%" >GAN</td>
                                <td width="28%" >PLA</td>
                                <td width="31%" >TOTAL</td>
                              </tr>
                            </table>
                        </div>
                        <div id="caballos" style="font-size:16px;width:100%;float:left;background:#e0e0e0;height:90px;
                        	background:#333;overflow: auto; text-align:center; 
                            font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
                          <table width="99%" border="0" style="font-size:10px;" cellpadding="0" cellspacing="0">  
                              <?php
                              $totCarr=0;
                              
                                  do {

                                    
                                    for ($i = 1; $i <= $row_Recordset2d['can_caballos']; $i++) {?>
                                    <?php if ($i==$row_Recordset2['num_rcaballo']){  ?>
                                     <tr style="background: #C03; color:#FFFFFF;"><?php }else{?>
                                        <tr style="background: #FFF; color:#000000;"><?php }?>
                                     <td width="5%">
										<?php echo $i.'<br>'; ?>
                    </td>
                                        <?php if ($i==$row_Recordset2['num_rcaballo']){  ?>
                                            <td colspan="5" >RETIRADO</td><?php }else{
                                              
                                              $gan=0;
                    $pla=0;
                    $mon=0;
                    
                                              list($gan, $pla, $mon)=venPorCabAme(
                                                $carreraActual,
                                                $usuarioVenta,
                                                $i,
                                                $row_Recordset2d['fec_carrera']
                                            );
                                            $totCarr=$totCarr+$mon;
                                              
                                              
                                              ?>
                                              <td width="15%" align="right" style="border-bottom: 1px solid #C1BDBE;">
										<?php echo number_format($gan, 0, ",", "."); ?>
                                        </td>
                                        <td width="28%" align="right" style="border-bottom: 1px solid #C1BDBE;">
										<?php echo number_format($pla, 0, ",", "."); ?>
                                        </td>
                                        <td width="31%" align="right" style="border-bottom: 1px solid #C1BDBE;">
										<?php echo number_format($mon, 0, ",", "."); ?>
                                        </td>
                                                <?php } ?>
                                                
                                        
                                        

                                        
                                <?php    }
                                       ?>

                                     
                                    
                                    </tr>
                                   <?php
                                  } while ($row_Recordset2d = mysqli_fetch_assoc($Recordset2d));
                              ?>
                              <tr style="background:#FFFFFF; color:#000000">
                                <td colspan="6" height="2" style="font-size:2px;background:#C1BDBE;">&nbsp;</td>
                              </tr>
                            </table>
                            
                          </div> 
                          <div id="" style="font-size:15px;width:100%;float:left;background:#e0e0e0;height:10px;
                        	background:#333; text-align:center; 
                            font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">&nbsp;
                            <tr style="background:#FFFFFF; color:#000000">
                            <td width="15%"  align="right" style="border-bottom: 0px solid #C1BDBE;">TOTAL:
										<?php echo number_format($totCarr, 2, ",", "."); ?></td>
                              </tr>
                          </div> 
                          
                        <?php  } ?>
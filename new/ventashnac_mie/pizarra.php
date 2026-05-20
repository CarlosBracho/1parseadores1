<?php
    require_once('../Connections/conexionbanca.php');
    $query_Recordset42 = sprintf(
        "/* PARSEADORES1 new\ventashnac_mie\pizarra.php - QUERY 1 */ SELECT 
			inscritos.num_caballo_hnac, 
			inscritos.nom_caballo_hnac,
			inscritos.est_inscrito_hnac, 
			inscritos.est_favorito_hnac,
			carrera_hnac.can_caballos_hnac,
			carrera_hnac.fec_carrera_hnac,
			carrera_hnac.num_carrera_hnac,
			precio_fijo_hnac.max_eje_hnac,
			precio_fijo_hnac.pre_fijo_hnac
			FROM 
				carrera_hnac,
				precio_fijo_hnac
				RIGHT JOIN inscritos 
				ON precio_fijo_hnac.cod_inscrito_hnac = inscritos.cod_inscrito_hnac AND
				   precio_fijo_hnac.cod_taquilla = %s
			WHERE
				carrera_hnac.cod_carrera_hnac =  inscritos.cod_carrera_hnac AND
				carrera_hnac.cod_carrera_hnac = %s 
			ORDER BY 
				inscritos.num_caballo_hnac ASC",
        GetSQLValueString($_POST["taquilla"], "int"),
        GetSQLValueString($_POST["carreraAnt"], "int")
    );
    $Recordset42 = mysqli_query($conexionbanca, $query_Recordset42) or die(mysqli_error($conexionbanca));
    $row_Recordset42 = mysqli_fetch_assoc($Recordset42);
    $totalRows_Recordset42 = mysqli_num_rows($Recordset42);
?>
					
					<table width="100%" border="0" style="font-size:10px;">
                      <tr style="font-size:18px">
                        <td height="30" colspan="2" align="right" valign="middle" >
                        PIZARRA
                        </td>
                        <td width="37%" align="right" valign="middle" >
							<a href="../ventashnac_mie/index.php" title="volver a carrera actual" 
                            style="font-size:11px;background: #FC0; color:#000; padding:5px 5px 5px 5px" >volver</a>   
                        </td>
                      </tr>
                      <tr style="font-size:16px">
                        <td height="28" colspan="3" align="center" valign="middle" >
                        CARRERA #<?php echo $row_Recordset42['num_carrera_hnac']; ?>
                        </td>
                      </tr>
					</table>
                    <table width="100%" border="0" style="font-size:10px;">
                      <tr>
                        <td width="2%" >No</td>
                        <td width="58%" >EJEMPLAR</td>
                        <td width="40%" >TOTAL</td>
                      </tr>
                    </table>
                    <div id="caballos" style="font-size:16px;width:277px;float:left;background:#e0e0e0;height:242px;
                	background: #CCC;overflow: auto;">
                    <table width="99%" border="0" style="font-size:10px;">  
                      <?php
                      $totCarr=0;
                      if (isset($totalRows_Recordset42) && $totalRows_Recordset42>0) {
                          do {
                              if ($row_Recordset42['max_eje_hnac']==false) {
                                  if ($row_Recordset42['est_favorito_hnac']==1) {
                                      $tipFav="1r Favorito";
                                  } elseif ($row_Recordset42['est_favorito_hnac']==2) {
                                      $tipFav="2o Favorito";
                                  } elseif ($row_Recordset42['est_favorito_hnac']==3) {
                                      $tipFav="3r Favorito";
                                  } else {
                                      $tipFav="";
                                  }
                              } else {
                                  $tipFav='<font color="#FF0000">P.Fijo '.$row_Recordset42['pre_fijo_hnac'].'</font>';
                              }
                              if ($row_Recordset42['est_inscrito_hnac']==0) {?>
							  <tr style="background: #CCC; color:#000000">
								<td width="7%"><?php echo $row_Recordset42['num_caballo_hnac']; ?></td>
								<td width="48%" style="text-align:left"><?php echo $row_Recordset42['nom_caballo_hnac']; ?></td>
								<td colspan="2" >RETIRADO</td>
                                
                              <?php
                              } else {
                                  $gan=0;
                                  $pla=0;
                                  $mon=0;
                                  $fecC=$row_Recordset42['fec_carrera_hnac'];
                                  $numC=$row_Recordset42['num_caballo_hnac'];
                                  //if ($totalRows_Recordset1>0) {
                                  list($gan, $pla, $mon)=venPorCabUsu($_POST["carreraAnt"], $_POST["usuario"], $numC, $fecC);
                                  $totCarr=$totCarr+$mon;
                                  if ($row_Recordset42['est_favorito_hnac']>0 && $row_Recordset42['est_favorito_hnac']<5 or $row_Recordset42['max_eje_hnac']==true) {?>
                                    <tr style="background: #FFC; color:#000000">
                                    <?php } else {?>
                                    <tr style="background: #FFF; color:#000000">
                                    <?php } ?>
                                        <td width="7%"><?php echo $row_Recordset42['num_caballo_hnac']; ?></td>
                                        <td style="text-align:left" width="40%">
										<?php echo $row_Recordset42['nom_caballo_hnac']; ?></td>
                                        <td width="21%" align="left"><?php echo $tipFav; ?></td>
                                        <td width="32%" align="right"><?php echo number_format($gan, 2, ",", "."); ?></td>
                                      <?php
                              } ?>
                                    </tr>
						   <?php
                          } while ($row_Recordset42 = mysqli_fetch_assoc($Recordset42));
                      }?>
                      <tr style="background: #999; color:#000000">
                        <td colspan="4">&nbsp;</td>
                      </tr>
					</table>
				</div>
				<table width="100%" border="0">
					<tr style="font-size:20px">
						<td height="59" style="text-align:right">
							<?php if (isset($_POST["carreraAnt"])) {?>
							<div style="height:auto; width:auto; float:left;">&nbsp;
								<input type="button" style="width:80px; font-size:11px; margin:-25px 0px 0px 0px" 
								value="Imp. Pizarra" 
                                    	onclick="javascript:window.open('t_imprimePizarra.php?uCarre=<?php echo $_POST["carreraAnt"]?>&uVenta=<?php echo $_POST["usuario"]?>&uTaqui=<?php echo $_POST["nomtaquilla"]?>&uNombr=<?php echo $_POST["nomcompleto"]?>', '_blank');"/>
							</div>
							<?php }?>
                            TOTAL:&nbsp;<?php echo number_format($totCarr, 2, ",", "."); ?>
                            </td>
                          </tr>
				</table>
<?php
if (isset($Recordset42)) {
                          mysqli_free_result($Recordset42);
                      }
?>
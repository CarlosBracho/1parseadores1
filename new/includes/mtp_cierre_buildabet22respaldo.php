<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');set_time_limit(0);$fech=fechaactualbd();$horasistema=horaactual();$query_Recordset1 = sprintf("/* PARSEADORES1 new\includes\mtp_cierre_buildabet22respaldo.php - QUERY 1 */ SELECT carrera.cod_carrera,carrera.nom_hipodromo,carrera.num_carrera,carrera.hor_carrera,carrera.mtp_control,carrera.est_carrera,carrera.est_cierre,carrera.contador_cierres,hipodromo.cod_pagina_rb FROM carrera, hipodromo WHERE carrera.cod_hipodromo=hipodromo.cod_hipodromo AND (carrera.mtp_control=0 OR carrera.mtp_control=1 OR carrera.mtp_control=2 OR carrera.mtp_control=3 OR carrera.mtp_control=4 OR carrera.mtp_control=5 OR carrera.mtp_control=6 OR carrera.mtp_control=7 OR carrera.mtp_control=8 OR carrera.mtp_control=9) AND carrera.est_cierre=2 AND carrera.est_carrera=1 AND carrera.mtp_tipo=1 AND eje_primero=0 AND fec_carrera=%s", GetSQLValueString($fech, "date"));$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));$row_Recordset1 = mysqli_fetch_assoc($Recordset1);$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 3000);
 //-->
 //]]>
</script>

<div style="background: #693; color: #FFF; width:100%;">
<table width="100%" border="0">
  <tr>
  	<td height="41" colspan="3" align="left" valign="middle" style="font-size:28px; color:#000000">CONTROL HORA Y CIERRE</td>
  	<td height="41" align="right" valign="middle" style="font-size:46px; color:#000000"><?php echo $horasistema ?></td>
    </tr>
  <tr bgcolor="#003">
    <td width="566">HIPODROMO</td>
    <td width="25" align="center">#</td>
    <td width="231" align="center">ESTADO</td>
    <td width="120" align="center">RESTAN</td>
  </tr>
</table>
</div>
<table width="100%" border="1" style="font-size:24px" bordercolor="#FFCC00">
<?php
if ($totalRows_Recordset1>0) {
    list($idCarrrera, $nHipodro, $nCarrera, $xEstado, $xhora, $restan)=mtpCierreBuildaBet2(1);
    $estado2=$xEstado;
    $g=1;
    $s=1;
    do {
        $f=0;
        if ($nHipodro[0]!="") {
            foreach ($nHipodro as $hip) {
                $anadir="";
                $n=$row_Recordset1['num_carrera'];
                $codid=explode("/", $row_Recordset1['cod_pagina_rb']);
                if (isset($codid[$n])) {
                    $id=$codid[$n];
                } else {
                    $id="";
                }
                
                if ($id==$idCarrrera[$f] && $restan[$f]<=50) {
                    if ($xEstado[$f]!="O" && $xEstado[$f]!="X") {
                        $xEstado[$f]="R";
                    }
                    $hor_carrera=$row_Recordset1['hor_carrera'];
                    $cod_carrera=$row_Recordset1['cod_carrera'];
                    $mtp_control=$row_Recordset1['mtp_control'];
                    $ver=0;
                    $act=0;
                    if ($xEstado[$f]=="O") {
                        $ver=1;
                    }
                    if ($xEstado[$f]=="O" && $row_Recordset1['hor_carrera']<$xhora[$f]) {
                        $hor_carrera=$xhora[$f];
                        $act=1;
                        $est=1;
                        $cie=2;
                        $mtp=$mtp_control;
                    }
                    if ($row_Recordset1['est_cierre']==3) {
                        $nom=$row_Recordset1['nom_hipodromo'];
                        $num=$row_Recordset1['num_carrera'];
                        //list($exist, $hora, $esta)=verCarrera($nom,$num,fechaactualbd());
                    }
                    if ($xEstado[$f]=="O" && $row_Recordset1['hor_carrera']=="01:00:00") {
                        $ver=1;
                        $hor_carrera=$xhora[$f];
                        $act=1;
                        $est=1;
                        $cie=2;
                        $mtp=$mtp_control;
                    } else {
                        $horaInicial=horaactual();
                        list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);
                        $h=$h/1;
                        $m=$m/1;
                        $s=$s/1;

                        $horaactualcarrera2=horaactual();
                        $faltan2=restahoras($horaactualcarrera2, $row_Recordset1['hor_carrera']);



                        if ($xEstado[$f]=="O" && $faltan2<="00:00:30") {
                            $minutoAnadir=3;
                            $segundos_horaInicial=strtotime(horaactual());
                            $segundos_minutoAnadir=$minutoAnadir*60;
                            $hor_carrera=date("H:i", $segundos_horaInicial+$segundos_minutoAnadir);
                            $act=1;
                            $est=1;
                            $cie=2;
                            $mtp=$mtp_control;
                        }
                        if ($xEstado[$f]=="R") {
                            $ver=0;
                            $act=0;
                        }
                        if (($xEstado[$f]=="R") && $row_Recordset1['est_carrera']==1) {
                            $hor_carrera=horaactual();
                            $ver=1;
                            $act=1;
                            $cie=1;
                            $est=0;
                            $mtp=9;
                        }
                    }
                    if ($xEstado[$f]=="R") {
                        if ($row_Recordset1['hor_carrera']=="01:00:00") {
                            $hor_carrera=horaactual();
                        } else {
                            $hor_carrera=horaactual();
                        }
                        if ($row_Recordset1['est_carrera']==0 && $row_Recordset1['est_cierre']==1) {
                            $act=0;
                        } else {
                            $act=1;
                        }
                        $ver=1;
                        $restan[$f]=0;
                        $cie=1;
                        $est=0;
                        $mtp=9;
                    }
                    if ($xEstado[$f]=="X") {
                        $ver=1;
                        $nom_hipodro=$row_Recordset1['nom_hipodromo'];
                        $num_carrera=$row_Recordset1['num_carrera'];
                        $horaactual=horaactual();
                        $_POST['est_carrera']=0;
                        $_POST['est_cierre']=0;
                        $_POST['est_confirmacion']=0;
                        $nm1="EL SISTEMA";
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 new\includes\mtp_cierre_buildabet22respaldo.php - QUERY 2 */ UPDATE carrera 
							SET 
								est_carrera=%s, est_cierre=%s, est_confirmacion=%s, hor_carrera=%s, 
								eje_primero=%s, div_primero_gan=%s, div_primero_pla=%s, div_primero_sho=%s, 
								eje_segundo=%s, div_segundo_pla=%s, div_segundo_sho=%s, eje_tercero=%s, 
								div_tercero_sho=%s, eje_doble_primero=%s, div_doble_primero_gan=%s, div_doble_primero_pla=%s, 
								div_doble_primero_sho=%s, eje_doble_segundo=%s, div_doble_segundo_pla=%s, 
								div_doble_segundo_sho=%s, eje_doble_tercero=%s, div_doble_tercero_sho=%s, 
								eje_triple_primero=%s, div_triple_primero_gan=%s, div_triple_primero_pla=%s, 
								div_triple_primero_sho=%s, eje_triple_segundo=%s, div_triple_segundo_pla=%s, 
								div_triple_segundo_sho=%s, eje_triple_tercero=%s, div_triple_tercero_sho=%s,
								div_exacta=%s, fac_exacta=%s, div_trifecta=%s, fac_trifecta=%s,
								div_superfecta=%s, fac_superfecta=%s, eje_cuarto=%s, eje_doble_cuarto=%s,
								eje_triple_cuarto=%s, div_exacta_doble=%s, div_exacta_triple=%s, div_trifecta_doble=%s,
								div_trifecta_triple=%s, div_superfecta_doble=%s, div_superfecta_triple=%s,
								ord_exacta=%s, ord_exacta_doble=%s, ord_exacta_triple=%s, ord_trifecta=%s,
								ord_trifecta_doble=%s, ord_trifecta_triple=%s, ord_superfecta=%s, 
								ord_superfecta_doble=%s,ord_superfecta_triple=%s
										WHERE cod_carrera=%s",
                            GetSQLValueString($_POST['est_carrera'], "int"),
                            GetSQLValueString($_POST['est_cierre'], "int"),
                            GetSQLValueString($_POST['est_confirmacion'], "int"),
                            GetSQLValueString($horaactual, "date"),
                            GetSQLValueString(99, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(99, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(99, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString(0, "double"),
                            GetSQLValueString("0/0", "text"),
                            GetSQLValueString("0/0", "text"),
                            GetSQLValueString("0/0", "text"),
                            GetSQLValueString("0/0/0", "text"),
                            GetSQLValueString("0/0/0", "text"),
                            GetSQLValueString("0/0/0", "text"),
                            GetSQLValueString("0/0/0/0", "text"),
                            GetSQLValueString("0/0/0/0", "text"),
                            GetSQLValueString("0/0/0/0", "text"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                        $descripcion="CANCELADA <strong>".$nom_hipodro." Carr...".$num_carrera."</strong> por: <u>".$nm1."</u>";
                        $horaactual=horaactual();
                        $fechaactual=fechaactualbd();
                        $insertSQL2 = sprintf(
                            "/* PARSEADORES1 new\includes\mtp_cierre_buildabet22respaldo.php - QUERY 3 */ INSERT 
								INTO bitacora 
								(des_bitacora, hor_bitacora, fec_bitacora) 
								VALUES (%s, %s, %s)",
                            GetSQLValueString($descripcion, "text"),
                            GetSQLValueString($horaactual, "date"),
                            GetSQLValueString($fechaactual, "date")
                        );
                        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        //----------------------
                    }
                    if ($act==1) {
                        $contador_cierres=$row_Recordset1['contador_cierres']+1;
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 new\includes\mtp_cierre_buildabet22respaldo.php - QUERY 4 */ UPDATE carrera SET 
											hor_carrera=%s, 
											hor_mtp=%s, 
											est_carrera=%s, 
											est_cierre=%s, 
                                                                                        mtp_control=%s,
											CERRADOX=%s, 
                                                                                        contador_cierres=%s  
										  WHERE cod_carrera=%s",
                            GetSQLValueString($hor_carrera, "date"),
                            GetSQLValueString($hor_carrera, "date"),
                            GetSQLValueString($est, "int"),
                            GetSQLValueString($cie, "int"),
                            GetSQLValueString($mtp, "int"),
                            GetSQLValueString("BUILDABET", "text"),
                            GetSQLValueString($contador_cierres, "int"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                        
                        
                        
                        $insertSQL = sprintf(
                            "/* PARSEADORES1 new\includes\mtp_cierre_buildabet22respaldo.php - QUERY 5 */ INSERT INTO quiencierrayabre 
					(codcarrera, 
					fechaquien, 
					cerro) 
					VALUES (%s, %s, %s)",
                            GetSQLValueString($cod_carrera, "int"),
                            GetSQLValueString($fechaactual, "date"),
                            GetSQLValueString(2, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                    }
                    if ($ver==1) {
                        if ($estado2[$f]=="O") {
                            $statusC='<FONT COLOR=#33CC33>ABIERTA</FONT>';
                        } elseif ($estado2[$f]=="R") {
                            $statusC="<FONT COLOR=#FF6600>Corriendo...</FONT>";
                        } elseif ($estado2[$f]=="X") {
                            $statusC="<FONT COLOR=red>CANCELADA!</FONT>";
                        } elseif ($estado2[$f]=="S") {
                            $statusC="<strong><FONT COLOR=#6600CC SIZE=2 FACE='arial'>Apuestas Cerradas!</FONT></strong>";
                        } else {
                            $statusC="<FONT COLOR=#3399FF>Finalizada!</FONT>";
                        }
                        if ($g%2==0) {?>
						  <tr bgcolor="#FFFFFF" style="color:#003" height="31" >
						  <?php } else {?>
						  <tr bgcolor="#FFFF99" style="color:#003" height="31">
						<?php  } ?>
							<td width="332" title="<?php echo " id:".$idCarrrera[$f]; ?>">
						    <?php echo $hip; ?></td>
							
                            <td width="51" align="center"><?php echo $nCarrera[$f]; ?></td>
                            <td width="100" align="center"><?php echo $statusC; ?></td>
							<td width="150" align="right" style="color:#FF0000">
								<?php
                                if ($restan[$f]=="") {
                                    $restan[$f]="+2";
                                }
                        if ($xEstado[$f]!="O") {
                            echo "CERRADA";
                        } else {
                            echo $restan[$f]."min";
                        }
                        if ($xEstado[$f]=="x") {
                            echo "CANCELADA";
                        } ?>
							</td>
  						</tr>
						<?php
                        $g++;
                    }
                    break;
                }
                $f++;
            }
        }
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    mysqli_free_result($Recordset1);
}
?>
</table>
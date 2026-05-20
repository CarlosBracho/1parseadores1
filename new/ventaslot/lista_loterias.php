<?php
require_once("../Connections/conexionbanca.php");
$xTicket_Recordset1 = "0";
$chequeo=1000;
if (isset($_GET["banca"])) {
    $xTicket_Recordset1 = $_GET["banca"];
    $banca = $_GET["banca"];
    $organiza=$_GET["ordturno"];
    if (isset($_GET["agencia"])) {
        $agencia = $_GET["agencia"];
    }
}
$horasistema=horaactual();
$diahoy=diaactual();
list($aDia, $bDia)=loteriaHoy($diahoy);
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventaslot\lista_loterias.php - QUERY 1 */ SELECT 
	lo.nom_loteria, 
	lo.tip_loteria, 
	lo.id_loteria,
	lo.let_loteria,
	so.nom_sorteo,
	so.tur_sorteo,
	so.id_sorteo,
	ba.id_banca,
	ag.id_agencia
	FROM 
		loterias lo,
		sorteos so,
		bancaloterias ba,
		agencialoterias ag
	WHERE ((lo.tip_loteria = 1 OR lo.tip_loteria=3) AND lo.est_loteria=1) AND ba.id_loteria = lo.id_loteria AND
		ba.id_banca = %s AND ba.hor_cierre >= %s AND $bDia = 1 AND ba.est_banlot = 1 AND ag.id_agencia=%s AND
		$aDia=1 AND ag.est_agelot=1 AND ag.id_loteria = ba.id_loteria AND so.id_sorteo = lo.id_sorteo AND so.est_sorteo = 1
	ORDER BY  ba.hor_cierre, so.id_sorteo, lo.let_loteria, lo.tip_loteria ASC",
    GetSQLValueString($banca, "int"),
    GetSQLValueString($horasistema, "date"),
    GetSQLValueString($agencia, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 new\ventaslot\lista_loterias.php - QUERY 2 */ SELECT 
	SUM(CASE so.tur_sorteo WHEN 'M' THEN 1 ELSE 0 END) AS est_man,	
	SUM(CASE so.tur_sorteo WHEN 'T' THEN 1 ELSE 0 END) AS est_tar,	
	SUM(CASE so.tur_sorteo WHEN 'N' THEN 1 ELSE 0 END) AS est_noc	
	FROM 
		loterias lo,
		sorteos so,
		bancaloterias ba,
		agencialoterias ag
	WHERE ((lo.tip_loteria = 1 OR lo.tip_loteria=3) AND lo.est_loteria=1) AND ba.id_loteria = lo.id_loteria AND
		ba.id_banca = %s AND ba.hor_cierre >= %s AND $bDia = 1 AND ba.est_banlot = 1 AND ag.id_agencia=%s AND
		$aDia=1 AND ag.est_agelot=1 AND ag.id_loteria = ba.id_loteria AND so.id_sorteo = lo.id_sorteo LIMIT 1",
    GetSQLValueString($banca, "int"),
    GetSQLValueString($horasistema, "date"),
    GetSQLValueString($agencia, "int")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$query_Recordset2 = "/* PARSEADORES1 new\ventaslot\lista_loterias.php - QUERY 3 */ SELECT id_signo, nom_corto, nom_signo FROM signos";
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$contador=0; $bandera=0;
do {
    $cod_signos[$contador]=$row_Recordset2['id_signo'];
    $nom_signos[$contador]=$row_Recordset2['nom_corto'];
    $nom_largoS[$contador]=$row_Recordset2['nom_signo'];
    $contador++;
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
$valormonto=""; $rad1=1; $rad2=0; $rad3=0; $rad4=0;
if (isset($_POST["mon_apuesta"])) {
    $valormonto=$_POST['mon_apuesta'];
}
if (isset($_POST["RadioGroup1"])) {
    if ($_POST["RadioGroup1"]==2) {
        $rad1=0;
        $rad2=1;
    }
    if ($_POST["RadioGroup1"]==3) {
        $rad1=0;
        $rad3=1;
    }
    if ($_POST["RadioGroup1"]==4) {
        $rad1=0;
        $rad4=1;
    }
}
if (isset($_COOKIE["xvar"])) {
    $loterias = explode(",", $_COOKIE["xvar"]);
    $d=0;
    $chequeo=array();
    foreach ($loterias as $valores) {
        $separar = explode('-', $valores);
        $chequeo[$d]=$separar[0]*1;
        $d++;
    }
} else {
    $chequeo=array("");
}
if ($xTicket_Recordset1!=0) {
    if ($totalRows_Recordset1>0) {
        $sorteo=0;
        $turno="";
        $c=0;
        $dAct="all";
        $idCla="all";
        $tab="height:315px;padding: 2px 0 0 0;";
        if ($row_Recordset3['est_tar']==0&&$row_Recordset3['est_noc']==0) {
            $organiza=0;
        } elseif ($row_Recordset3['est_man']==0&&$row_Recordset3['est_noc']==0) {
            $organiza=0;
        } elseif ($row_Recordset3['est_man']==0&&$row_Recordset3['est_tar']==0) {
            $organiza=0;
        }
        if ($organiza==0) {
            $tab="height:295px;overflow:auto;"; ?>
			<input type="checkbox" onclick="xGrupo(this,1),foco('num_apuesta')" name="todasninguna2" id="todasninguna" 
			title="Selecciona todas las loterias excepto las zodiacales" 
			<?php if ($totalRows_Recordset1<=0) {
                echo "disabled";
            } ?>/> <strong>Todas(+)/Ninguna(-)</strong>
			<br/><?php
        }
        echo '<div class="tab" style="float:left; width:100%;'.$tab.'">';
        if ($organiza==1) {
            $activo="background-color:#333;color:#FFF;";
            if ($row_Recordset3['est_man']>0) {
                $m=1;
                $dAct="man"; ?>
				<button id="b1" class="bhora" style=" <?php echo $activo; ?> float:left;border:1px solid #E1E1E1;outline: none;cursor: pointer; padding: 4px 12px;" onclick="openTab('b1','man'),foco('num_apuesta'); return false">MAÑANA</button><?php
            } else {
                $m=0;
            }
            
            if ($row_Recordset3['est_tar']>0) {
                $t=1;
                if ($m==1) {
                    $activo="background-color: inherit;";
                } else {
                    $dAct="tar";
                } ?>
				<button id="b2" class="bhora" style=" <?php echo $activo; ?> float:left;border:1px solid #E1E1E1;outline: none;cursor: pointer; padding: 4px 12px;" onclick="openTab('b2','tar'),foco('num_apuesta'); return false">TARDE</button><?php
            } else {
                $t=0;
            }
            if ($row_Recordset3['est_noc']>0) {
                if ($t==1) {
                    $activo="background-color: inherit;";
                } else {
                    $dAct="noc";
                } ?>
				<button id="b3" class="bhora" style=" <?php echo $activo; ?> float: left;border:1px solid #E1E1E1;outline: none;cursor: pointer; padding: 4px 12px;" onclick="openTab('b3','noc'),foco('num_apuesta'); return false">NOCHE</button><?php
            }
        } ?>
        <input id="dAct" value="<?php echo $dAct; ?>" type="hidden"/>
		<?php
        do {
            $idSor="lot".$row_Recordset1['id_loteria'];
            if ($row_Recordset1['tur_sorteo']=="M") {
                $disp="display:block;";
                if ($organiza==1) {
                    $idCla="man";
                }
            }
            if ($row_Recordset1['tur_sorteo']=="T") {
                if ($organiza==1) {
                    $idCla="tar";
                }
                if ($row_Recordset3['est_man']==0) {
                    $disp="display:block;";
                } else {
                    $disp="display:none";
                }
            }
            if ($row_Recordset1['tur_sorteo']=="N") {
                if ($organiza==1) {
                    $idCla="noc";
                }
                if ($row_Recordset3['est_man']==0&&$row_Recordset3['est_tar']==0) {
                    $disp="display:block;";
                } else {
                    $disp="display:none";
                }
            }
            if ($sorteo!=$row_Recordset1['id_sorteo']) {
                if ($c>0) {
                    echo "</div>";
                    if ($turno!=$row_Recordset1['tur_sorteo']&&$organiza==1) {
                        echo "</div>";
                    }
                }
                if ($turno!=$row_Recordset1['tur_sorteo']&&$organiza==1) {
                    echo '<div class="thora" id="'.$idCla.'" style="height:260px;float:left;overflow:auto;width:100%;'.$disp.'">'; ?>
                        <input type="checkbox" onclick="xGrupo(this,1),foco('num_apuesta')" name="todasninguna2" id="todasninguna" 
                        title=" Selecciona todas las loterias excepto las zodiacales "
                        style="margin:0px 0 0 2px; float:left" 
                        <?php if ($totalRows_Recordset1<=0) {
                        echo "disabled";
                    } ?>/>
                        <div style="margin:-16px 0 0 21px;width:90%; float:left">
                        <strong>Todas(+)/Ninguna(-)</strong>
                        </div>
                    <?php
                    $turno=$row_Recordset1['tur_sorteo'];
                }
                $sorteo=$row_Recordset1['id_sorteo']; ?>
			<div id="grupo<?php echo $row_Recordset1['id_sorteo']; ?>" style="width:95%; float:left; background:#E2E2E2;
            	margin:2px 0px">
            	<div id="sorteo<?php echo $row_Recordset1['id_sorteo']; ?>" 
                	style="width:58%; float:left; padding:5px 0px">
            		<?php echo "&nbsp;".$row_Recordset1['nom_sorteo']; ?>
                </div>
            <?php
            }
            if (in_array($row_Recordset1['id_loteria'], $chequeo)&&$row_Recordset1['tip_loteria']==1) {
                $backg="background:#333333; float:left; width:10%; margin:1px 0px 0px 1px; padding:1px 0px;color:#FFFFFF";
            } else {
                $backg="background:#FFFFFF; float:left; width:10%; margin:1px 0px 0px 1px; padding:1px 0px";
            } ?>
                <div id="loteria<?php echo $row_Recordset1['id_loteria']; ?>" 
                	style=" <?php echo $backg; ?>"><?php
                        echo "&nbsp;".$row_Recordset1['let_loteria'];
            if ($row_Recordset1['tip_loteria']==1) {?>
							<input type="checkbox" name="lot_apuesta[]" style="margin:0 0 0 -4px;"
								value="<?php echo $row_Recordset1['id_loteria']."-".$row_Recordset1['tip_loteria']?>" 
								title=" <?php echo $row_Recordset1['nom_loteria'];?> "
								onClick="cfon('loteria<?php echo $row_Recordset1['id_loteria'];?>', 
											  'lot<?php echo $row_Recordset1['id_loteria'];?>', 
											  '<?php echo $row_Recordset1['tip_loteria'];?>'),
										 foco('num_apuesta')"
								id="<?php echo $idSor;?>" class="<?php echo $idCla;?>"               
								<?php if (in_array($row_Recordset1['id_loteria'], $chequeo)) {
                echo "checked=\"checked\"";
            }?>/><?php
                        } elseif ($row_Recordset1['tip_loteria']==3) {?>
								<input type="checkbox" id="lot_apuesta[]" name="lot_apuesta[]" 
									style="margin:0 0 0 -4px"
									value="<?php echo $row_Recordset1['id_loteria']."-".$row_Recordset1['tip_loteria']?>" 
                                                onClick="cambiarDisplayAni('<?php echo $row_Recordset1['id_loteria']?>',
                                                						'loteria<?php echo $row_Recordset1['id_loteria'];?>'),
                                                         foco('num_apuesta')" 
									title=" <?php echo $row_Recordset1['nom_loteria'];?> "/>
								<span id="<?php echo $row_Recordset1['id_loteria']?>" 
									style="margin:10% 0 0 -715%;float:left;padding:0 0 0px 0; display:none; height:60px">
									<div id="signos" style="background: #333333; font-size:10px; width:260px;
										border-bottom:1px solid #999; color:#FFFFFF; height:60px; position: static"><?php
                                        for ($i=0; $i<6; $i++) { ?>
											<div style="font-size:10px; float:left; width:42px"> 
												<input type="checkbox" name="cod_signo[]" id="cod_signo[]" 
													onClick="foco('num_apuesta')"
													value="<?php echo $row_Recordset1['id_loteria']."-".$cod_signos[$i];?>" 
													title=" <?php echo $nom_largoS[$i];?> " /><?php echo $nom_signos[$i]." ";?>
											</div><?php
                                        }
                                        for ($i=6; $i<count($cod_signos); $i++) { ?>
											<div style="font-size:10px; float:left; width:42px">
												<input type="checkbox" name="cod_signo[]" id="cod_signo[]" 
													onClick="foco('num_apuesta')"
													value="<?php echo $row_Recordset1['id_loteria']."-". $cod_signos[$i];?>" 
													title=" <?php echo $nom_largoS[$i];?> "/><?php echo $nom_signos[$i]." ";?>
											</div><?php
                                        } ?><br/>
										<input id="lot_apuesta[]" type="checkbox" 
											onclick="xGrupo(this,2),foco('num_apuesta')" 
											title=" seleccionar todos los signos " /> TODOS/NINGUNO - 
											<?php echo "<font size='1'>".$row_Recordset1['nom_loteria']."</font>";?>
									</div>
								</span><?php
                        } ?>
                </div>
                <?php
            $c++;
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        echo '</div>';
        echo '</div>';
        if ($organiza==1) {
            echo "</div>";
        }
    } else {
        echo "No exiten sorteos programados";
    }
}
?>
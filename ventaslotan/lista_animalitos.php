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
    "/* PARSEADORES1 ventaslotan\lista_animalitos.php - QUERY 1 */ SELECT 
	lo.nom_loteria, 
	lo.tip_loteria, 
	lo.id_loteria,
	lo.let_loteria,
	so.nom_sorteo,
	so.id_sorteo
	FROM 
		loterias lo,
		sorteos so,
		bancaloterias ba,
		agencialoterias ag
	WHERE lo.tip_loteria > 3 AND lo.est_loteria=1 AND ba.id_loteria = lo.id_loteria AND
		ba.id_banca = %s AND ba.hor_cierre >= %s AND $bDia = 1 AND ba.est_banlot = 1 AND ag.id_agencia=%s AND
		$aDia=1 AND ag.est_agelot=1 AND ag.id_loteria = ba.id_loteria AND so.id_sorteo = lo.id_sorteo
	ORDER BY so.id_sorteo, lo.let_loteria, lo.tip_loteria ASC",
    GetSQLValueString($banca, "int"),
    GetSQLValueString($horasistema, "date"),
    GetSQLValueString($agencia, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 = "/* PARSEADORES1 ventaslotan\lista_animalitos.php - QUERY 2 */ SELECT id_animal, nom_animal, num_animal FROM animales ORDER BY num_animal";
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$c=0; $bandera=0;
do {
    $cod_signos[$c]=$row_Recordset2['id_animal'];
    $nom_signos[$c]=$row_Recordset2['nom_animal'];
    $num_signos[$c]=$row_Recordset2['num_animal'];
    $c++;
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
$query_Recordset3 = "/* PARSEADORES1 ventaslotan\lista_animalitos.php - QUERY 3 */ SELECT id_fruta, nom_fruta, num_fruta FROM frutas ORDER BY num_fruta";
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$c=0;
do {
    $cod_frutas[$c]=$row_Recordset3['id_fruta'];
    $nom_frutas[$c]=$row_Recordset3['nom_fruta'];
    $num_frutas[$c]=$row_Recordset3['num_fruta'];
    $c++;
} while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
$query_Recordset4 = "/* PARSEADORES1 ventaslotan\lista_animalitos.php - QUERY 4 */ SELECT id_palo, nom_palo FROM palos_cartas ORDER BY id_palo";
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$w=0;
do {
    $cod_palos[$w]=$row_Recordset4['id_palo'];
    $nom_palos[$w]=$row_Recordset4['nom_palo'];
    $w++;
} while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));

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
$nroPalos=array("1","2","3","4","5","6","7","8","9","10","11","12");
if ($xTicket_Recordset1!=0) {?>
 	<?php
    if ($totalRows_Recordset1>0) {
        $sorteo=0;
        $c=0;
        echo '<div style="overflow:auto;float:left; width:100%; height:365px;">';
        do {
            if ($row_Recordset1['tip_loteria']>=4) {
                $idL=$row_Recordset1['id_loteria']; ?>
            	<div style="background:#E2E2E2; font-size:14px; float:left; width:99%; margin:2px 0 0px 0">
                    
                    <div id="<?php echo "div".$row_Recordset1['id_loteria']; ?>" style="padding:2px 0">
                        <input type="checkbox" id="lot_apuesta[]" name="lot_apuesta[]"
                        value="<?php echo $row_Recordset1['id_loteria']."-".$row_Recordset1['tip_loteria']?>" 
                        onClick="desabilitAll('<?php echo "c".$idL; ?>'),
                        						cambiarDisplayAni('<?php echo $idL; ?>',
                                                'div<?php echo $idL; ?>'), 
                                                foco('mon_apuesta')" 
                        title="<?php echo $row_Recordset1['nom_loteria']; ?>"/>
                        <?php echo $row_Recordset1['nom_loteria']?>
                    </div>
                    <span id="<?php echo $row_Recordset1['id_loteria']?>" style="display:none; background:#E2E2E2">
                        <div id="signos<?php echo $row_Recordset1['id_loteria']?>" 
                        	style="background: #EDEDED; font-size:10px; width:330px;">
                            <?php
                            if ($row_Recordset1['tip_loteria']>=4&&$row_Recordset1['tip_loteria']<=5) {
                                if ($row_Recordset1['tip_loteria']==4) {
                                    $ruta="../admin_lot/animales/";
                                    $num=$num_signos;
                                    $cod=$cod_signos;
                                    $nom=$nom_signos;
                                } else {
                                    if ($row_Recordset1['tip_loteria']==5) {
                                        $ruta="../admin_lot/frutas/";
                                        $num=$num_frutas;
                                        $cod=$cod_frutas;
                                        $nom=$nom_frutas;
                                    }
                                }
                                for ($i=0; $i<38; $i++) {
                                    $img=$ruta.$num[$i].".png";//$numero=str_pad((int) $cod[$i],2,"0",STR_PAD_LEFT); ?>
									<div style="font-size:10px; float:left; width:15.5%;text-align:center; 
										border:1px solid #E0E0E0; color:#000000;background:#EDEDED"
										id="div<?php echo $row_Recordset1['id_loteria'].$cod[$i]; ?>"
										class="2c<?php echo $row_Recordset1['id_loteria']; ?>">
										
										<div style="width:100%; height:40px;float:left; margin:0 0 0 0">        
											<img src="<?php echo $img; ?>" width="40" height="35" alt=""/>
										</div>
										<div style="width:19px; height:19px;float:left; margin:-80% 0 0 0;position: static">
											<input type="checkbox" name="cod_signo[]" 
												class="c<?php echo $row_Recordset1['id_loteria']; ?>"
												id="s<?php echo $row_Recordset1['id_loteria'].$cod[$i]; ?>" 
												onClick="cfon('div<?php echo $row_Recordset1['id_loteria'].$cod[$i]; ?>',
															  's<?php echo $row_Recordset1['id_loteria'].$cod[$i]; ?>')"
												value="<?php echo $row_Recordset1['id_loteria']."-". $num[$i]; ?>" 
												title="<?php echo $num[$i]."-".$nom[$i]; ?>" />
										</div>
										<div style="width:11px; height:12px;float: right; margin:-80% 0 0 -3px;position: static;
											background:#FFFFFF">
											<?php echo $num[$i]; ?>
										</div>
										<div style="width:100%; height:12px;float:left; margin:-8px 0 0 0;">        
											<?php echo $nom[$i]; ?>
										</div>
									</div><?php
                                }
                            } elseif ($row_Recordset1['tip_loteria']==6) {
                                $k=0;
                                $ruta="../admin_lot/cartas/";
                                foreach ($cod_palos as $idpalos) {
                                    $img=$ruta."1".$idpalos.".png";
                                    foreach ($nroPalos as $nP) {
                                        $img=$ruta.$idpalos.$nP.".jpg";
                                        //$numero=str_pad((int) $cod[$i],2,"0",STR_PAD_LEFT); ?>
										<div style="font-size:10px; float:left; width:50px;text-align:center; 
											border:1px solid #E0E0E0; color:#000000;background:#EDEDED"
											id="div<?php echo $row_Recordset1['id_loteria'].$idpalos.$nP; ?>"
											class="2c<?php echo $row_Recordset1['id_loteria']; ?>">
											
											<div style="width:98%; height:36px;float:left; margin:2px 0 0 0">        
												<img src="<?php echo $img; ?>" width="35" height="30" alt=""/>
											</div>
                                            <div style="width:19px; height:19px;float:left; margin:-80% 0 0 0;position: static">
                                                <input type="checkbox" name="cod_signo[]" 
                                                    class="c<?php echo $row_Recordset1['id_loteria']; ?>"
                                                    id="s<?php echo $row_Recordset1['id_loteria'].$idpalos.$nP; ?>" 
                                                    onClick="cfon('div<?php echo $row_Recordset1['id_loteria'].$idpalos.$nP; ?>',
                                                                  's<?php echo $row_Recordset1['id_loteria'].$idpalos.$nP; ?>')"
                                                    value="<?php echo $row_Recordset1['id_loteria']."-".$nP."-".$idpalos; ?>" 
                                                    title="<?php echo "&nbsp;".$nP."-".$nom_palos[$k]; ?>" />
                                            </div>
                                            <div style="width:110%; height:12px;float:left; margin:-9px 0 0 -6px;">        
                                                <?php echo "&nbsp;".$nP."-".substr($nom_palos[$k], 0, 6); ?>
                                            </div>
										</div><?php
                                    }
                                    $k++;
                                }
                            } ?>
						</div>
                        <div style="background:#333; float:left; width:99%; height:2px">
                        </div>
           			</span>
                </div>
   				<?php
            }
            $sorteo=$row_Recordset1['id_sorteo'];
            $c++;
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        
        echo '</div>';
    } else {
        echo "No exiten sorteos programados";
    }
}
?>
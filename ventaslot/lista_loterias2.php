<?php
require_once("../Connections/conexionbanca.php");
$xTicket_Recordset1 = "0";
$chequeo=1000;
if (isset($_GET["banca"])) {
    $xTicket_Recordset1 = $_GET["banca"];
    $banca = $_GET["banca"];
    if (isset($_GET["agencia"])) {
        $agencia = $_GET["agencia"];
    }
    //if (isset($_GET["cheq"])) { $chequeo = explode('-',$_GET["cheq"]); echo "siiiii";} else echo "noooo";
}
//echo $banca." - ".$agencia;
$horasistema=horaactual();
$diahoy=diaactual();
list($aDia, $bDia)=loteriaHoy($diahoy);
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 ventaslot\lista_loterias2.php - QUERY 1 */ SELECT 
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
	WHERE ((lo.tip_loteria = 1 OR lo.tip_loteria=3) AND lo.est_loteria=1) AND ba.id_loteria = lo.id_loteria AND
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
//echo $agencia;

$query_Recordset2 = "/* PARSEADORES1 ventaslot\lista_loterias2.php - QUERY 2 */ SELECT id_signo, nom_corto, nom_signo FROM signos";
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
if ($xTicket_Recordset1!=0) {?>
	<input type="checkbox" onclick="cambiaGrupo(this,1),foco('num_apuesta')" name="todasninguna2" id="todasninguna" 
    title="Selecciona todas las loterias excepto las zodiacales" 
	<?php if ($totalRows_Recordset1<=0) {
    echo "disabled";
}?>/> <strong>Todas(+)/Ninguna(-)</strong>
    <br/>
 	<?php
    if ($totalRows_Recordset1>0) {
        $sorteo=0;
        $c=0;
        echo '<div style="overflow:auto;float:left; width:100%; height:315px;">';
        do {
            //foco('num_apuesta')
            //echo $sorteo." ".$row_Recordset1['id_sorteo']."<br/>";
            if ($row_Recordset1['tip_loteria']==1 or $row_Recordset1['tip_loteria']==3) {
                if (in_array($row_Recordset1['id_loteria'], $chequeo)) {
                    $estilo="#333333";
                    $color="#FFF";
                } else {
                    $estilo="#FFFFFF";
                    $color="#000";
                }
                //$estilo="#FFFFFF"; $color="#000";
                if ($sorteo!=$row_Recordset1['id_sorteo']) {
                    $sorteo=$row_Recordset1['id_sorteo'];
                    if ($c>0) {
                        echo '</tr>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                    } ?>
            	<div style="width:99%; background:#FFFFFF; color:#000;" 
                	id="<?php echo "divs".$row_Recordset1['id_sorteo']; ?>">
                    <div style="padding:1px 0 1px 0;">
                        <table border="1" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="180"  
                                    style="border-bottom:none; background:#E2E2E2; vertical-align:middle;"
                                    id="td<?php echo $row_Recordset1['id_sorteo']; ?>">
										<?php echo "&nbsp;".$row_Recordset1['nom_sorteo']; ?>
                                    </td>
				<?php
                } ?>
                                    <td width="33" align="left" style="font-size:13px; vertical-align:top; 
                                    	border-top:1px solid #E2E2E2;border-right:1px solid #E2E2E2;border-bottom:1px solid #E2E2E2;">
                                    	<div style="background:<?php echo $estilo; ?>; color:<?php echo $color; ?>; 
                                        	padding:0 0 0 2px; margin:4px 0 4px 1px; width:28px;"
                                        	id="<?php echo "div".$row_Recordset1['id_loteria']; ?>">
											<?php echo $row_Recordset1['let_loteria'];
                if ($row_Recordset1['tip_loteria']==1) {?>
                                                <input type="checkbox" name="lot_apuesta[]" style="margin:0 0 0 -4px;"
                                                value="<?php echo $row_Recordset1['id_loteria']."-".$row_Recordset1['tip_loteria']?>" 
                                                title="<?php echo $row_Recordset1['nom_loteria'];?>"
                                                onClick="cfon('div<?php echo $row_Recordset1['id_loteria'];?>', 
                                                              'lot<?php echo $row_Recordset1['id_loteria'];?>', 
                                                              '<?php echo $row_Recordset1['tip_loteria'];?>'),
                                                              foco('num_apuesta')"
                                                id="lot<?php echo $row_Recordset1['id_loteria'];?>"                
                                                <?php if (in_array($row_Recordset1['id_loteria'], $chequeo)) {
                    echo "checked=\"checked\"";
                }?>/><?php
                                            }
                if ($row_Recordset1['tip_loteria']==3) {?>
                                                <input type="checkbox" id="lot_apuesta[]" name="lot_apuesta[]" 
                                                style="margin:0 0 0 -4px"
                                                value="<?php echo $row_Recordset1['id_loteria']."-".$row_Recordset1['tip_loteria']?>" 
                                                onClick="cambiarDisplay('<?php echo $row_Recordset1['id_loteria']?>',
                                                						'div<?php echo $row_Recordset1['id_loteria'];?>',
                                                						'td<?php echo $row_Recordset1['id_sorteo'];?>'),
                                                         foco('num_apuesta')" 
                                                title="<?php echo $row_Recordset1['nom_loteria'];?>"/>
                                                <span id="<?php echo $row_Recordset1['id_loteria']?>" 
                                                	style="margin:10% 0 0 -870%;float:left;padding:0 0 0px 0;
                                                    display:none; height:60px">
                                                    <div id="signos" style="background: #333333; font-size:12px; width:270px;
                                                    	border-bottom:1px solid #999; color:#FFFFFF; height:60px; position: static"> 
                                                        <?php
                                                        for ($i=0; $i<6; $i++) { ?>
                                                            <div style="font-size:12px; float:left; width:45px"> 
                                                            <input type="checkbox" name="cod_signo[]" id="cod_signo[]" 
                                                            onClick="foco('num_apuesta')"
                                                            value="<?php echo $row_Recordset1['id_loteria']."-".$cod_signos[$i];?>" 
                                                            title="<?php echo $nom_largoS[$i];?>" /><?php echo $nom_signos[$i]." ";?>
                                                            </div><?php
                                                        }
                                                        for ($i=6; $i<count($cod_signos); $i++) { ?>
                                                            <div style="font-size:12px; float:left; width:45px">
                                                            <input type="checkbox" name="cod_signo[]" id="cod_signo[]" 
                                                            onClick="foco('num_apuesta')"
                                                            value="<?php echo $row_Recordset1['id_loteria']."-". $cod_signos[$i];?>" 
                                                            title="<?php echo $nom_largoS[$i];?>"/><?php echo $nom_signos[$i]." ";?>
                                                            </div><?php
                                                        } ?>
                                                        <input id="lot_apuesta[]" type="checkbox" 
                                                        onclick="cambiaGrupo(this,2),foco('num_apuesta')" 
                                                        title="seleccionar todos los signos" /> TODOS/NINGUNO - 
                                                        <?php echo "<font size='1'>".$row_Recordset1['nom_loteria']."</font>";?>
                                                    </div>
                                                </span>
                                            <?php
                                            } ?>
                                        </div> 
                                    </td><?php
                if ($sorteo!=$row_Recordset1['id_sorteo']) {?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
				</div>
        		<?php
                }
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
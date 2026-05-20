<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
date_default_timezone_set("America/Puerto_Rico");
if (isset($_SESSION['MM_UserChat']) && $_SESSION['MM_UserChat']!="") {
    $data = file_get_contents("chat.json");
    $json = json_decode($data, true);
    function color_var($i)
    {
        switch ($i) {
            case  0:$color="#FF851B";break; case  1:$color="#0074D9";break; case  2:$color="#FF4136";break;
            case  3:$color="#7FDBFF";break; case  4:$color="#39CCCC";break; case  5:$color="#F012BE";break;
            case  6:$color="#3D9970";break; case  7:$color="#B10DC9";break;	case  8:$color="#2ECC40";break;
            case  9:$color="#111111";break; case 10:$color="#01FF70";break; case 11:$color="#AAAAAA";break;
            case 12:$color="#FFDC00";break; case 13:$color="#DC143C";break; case 14:$color="#001f3f";break;
            case 15:$color="#85144b";break; case 16:$color="#eb315d";break; case 17:$color="#ebd231";break;
            case 18:$color="#bdc239";break; case 19:$color="#0fc77b";break; case 20:$color="#50795d";break;
        }
        return $color;
    }
    $nUsu=$_SESSION['MM_UserChat'];
    $query_Recordset102 = sprintf(
        "/* PARSEADORES1 new\chat\rjson.php - QUERY 1 */ SELECT ch.id, ch.connected	
		FROM chat ch 
		WHERE ch.from1=%s
		ORDER BY ch.id DESC
		LIMIT 1",
        GetSQLValueString($nUsu, "text")
    );
    $Recordset102 = mysqli_query($conexionbanca, $query_Recordset102) or die(mysqli_error($conexionbanca));
    $row_Recordset102 = mysqli_fetch_assoc($Recordset102);
    $totalRows_Recordset102 = mysqli_num_rows($Recordset102);
    $fechaActual = date('Y-m-d H:i:s');
    $nuevaFecha = strtotime('20 seconds', strtotime($fechaActual));
    $total = date(' Y-m-d H:i:s ', $nuevaFecha);
    if ($totalRows_Recordset102>0) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\chat\rjson.php - QUERY 2 */ UPDATE chat 
			SET connected=%s
			WHERE id=%s",
            GetSQLValueString($total, "date"),
            GetSQLValueString($row_Recordset102['id'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    } else {
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\chat\rjson.php - QUERY 3 */ INSERT INTO chat (from1, to1, message, sentdate, senttime, recd) 
				VALUES (%s, %s, %s, %s, %s, %s)",
            GetSQLValueString(trim($nUsu), "text"),
            GetSQLValueString('Soporte', "text"),
            GetSQLValueString(trim("inicio"), "text"),
            GetSQLValueString(fechaactualbd(), "date"),
            GetSQLValueString(horaactual(), "date"),
            GetSQLValueString(2, "int")
        );
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    }
    $x=0;
    $noLeidoGlobal="";
    $os[0]="";
    echo '<table id="latabla" cellpadding="0" cellspacing="0" style="width:100%;" border="0">';
    echo '<thead><tr><th></th></tr></thead>';
    foreach ($json['usuarios'] as $i => $v) {
        if (in_array($v['contactos'][$i]['enlace'], $os)) {
            $dup=true;
        } else {
            $dup=false;
        }
        if ($v['nombre_chat']==$nUsu && $dup==false) {
            $titl="";
            $os[$i]=$v['contactos'][$i]['enlace'];
            $abrNom=substr($v['contactos'][$i]['enlace'], 0, 2);
            $idtrT=$v['contactos'][$i]['id'].$v['contactos'][$i]['tipo'];
            $nom_chat=substr($v['contactos'][$i]['enlace'], 0, 14);
            switch ($v['contactos'][$i]['tipo']) {
                case "U":$tipo_chat="Taquilla";break;
                case "A":$tipo_chat="Soporte";break;
                case "G":$tipo_chat="Agente";break;
                case "D":$tipo_chat="Distribuidor";break;
            } ?>
			<tr height="40" style="border-bottom: 1px solid #C1BDBE;background:#FFFFFF; color:#000000;text-transform: none"
				onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"
				id="<?php echo $idtrT; ?>" title="<?php echo $titl; ?>">
				<td style="padding:1.5% 0 0 0">
					<div class="container-fluid">
						<div class="row">
							<a href="#" id="<?php echo "a".$idtrT; ?>" style="text-decoration:none" 
								onClick="clicAhref('<?php echo $idtrT; ?>','<?php echo "n".$idtrT; ?>',
								   '<?php echo "f".$idtrT; ?>','<?php echo "m".$idtrT; ?>',
								   '<?php echo $nUsu; ?>','<?php echo $v['contactos'][$i]['enlace']; ?>',
								   '<?php echo 'newT'.$idtrT; ?>')"
								class="two"> 
								<div class="circulo" style="background:<?php echo color_var($x); ?>;" id="<?php echo 'c'.$idtrT; ?>">
									<?php echo $abrNom; ?>
								</div>
								<div class="col8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8" 
									style="float:left; color:#333333;padding:0 0 0 10px;" 
									id="<?php echo 'n'.$idtrT; ?>">
									<?php echo strtoupper($nom_chat)." ".rand(5, 90);
            //." ".$idtrT." ".rand(5, 90);
            if ($v['contactos'][$i]['connected']==0) {
                echo '<div class="c1 c2" style=" background:#B50003; float:left"></div>';
            } else {
                echo '<div class="c1 c2" style=" background:#2ECC40; float:left"></div>';
            } ?>
								</div>
								<div class="col7 col-xl-2 col-lg-2 col-md-2 col-sm-2 hidden-xs" 
									style="float:left; color:#333333; padding:2px 0 0 0;" 
									id="<?php echo 'f'.$idtrT; ?>"><?php
                                        echo $v['contactos'][$i]['sdate']; ?>
								</div>
								<div class="col1 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8" 
									style="float:left; color:#333333;" id="<?php echo 'ti'.$idtrT; ?>">
									<?php echo $tipo_chat; ?>
								</div>
								<div class="col11 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8" 
									style="float:left; color:#333333;" id="<?php echo 'm'.$idtrT; ?>">
									<?php echo $v['contactos'][$i]['message']; ?>
								</div><?php
                                if ($v['contactos'][$i]['noleido']>0) {
                                    $nLeido=$v['contactos'][$i]['noleido'];
                                    $noLeidoGlobal=$noLeidoGlobal+$v['contactos'][$i]['noleido'];
                                    $noLClass="circulop";
                                } else {
                                    $nLeido="";
                                    $noLClass="circulopnone";
                                } ?>
								<div class="<?php echo $noLClass; ?>" id="<?php echo 'newT'.$idtrT; ?>">
									<?php echo $nLeido; ?>
								</div>
							</a>
						</div>
					</div>
				</td>
			</tr><?php
            $x++;
            if ($x>=21) {
                $x=0;
            }
        }
    }
    echo '</table>'; ?>
	<script>
		var caNL="<?php echo $noLeidoGlobal?>";
		if (caNL>0) $("#new-message").css("display", "block"); else $("#new-message").css("display", "none");
		document.getElementById("new-message").innerHTML = "<?php echo $noLeidoGlobal; ?>";
	</script><?php
} else {
    echo '<font size="+1" color="#000000">Inicie sesion</font>';
}
?>
<script>
	if( typeof colorActiva !== 'undefined' && jQuery.isFunction( colorActiva ) ) {colorActiva();}
	var xp=document.getElementById("q");theTable = $("#latabla");
	$(function() {theTable = $("#latabla");$("#q").keyup(function() {$.uiTableFilter(theTable, this.value);});});
	if(typeof xp !== 'undefined' && xp !== null) $.uiTableFilter(theTable, xp.value);
</script>
 
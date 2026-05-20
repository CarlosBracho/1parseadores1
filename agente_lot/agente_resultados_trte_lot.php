<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$id_banca = $_SESSION['MM_cod_banca'];

$query_Recordset31 =  sprintf(
    "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 1 */ SELECT mod_resultado
	FROM banca ba 
	WHERE ba.cod_banca = %s LIMIT 1",
    GetSQLValueString($id_banca, "int")
);
$Recordset31 = mysqli_query($conexionbanca, $query_Recordset31) or die(mysqli_error($conexionbanca));
$row_Recordset31 = mysqli_fetch_assoc($Recordset31);
$totalRows_Recordset31 = mysqli_num_rows($Recordset31);
$mod_resultado=$row_Recordset31['mod_resultado'];
$xCodigo=0;
$menSorteo="";
$menS="";
$menE="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_updateRes"])) && ($_POST["MM_updateRes"] == "form2") && (isset($_POST["guardar_Res"]))) {
    $t=0;
    $u=0;
    $premiar=0;
    $xcBanca=$_SESSION['MM_cod_banca'];
    if (isset($_POST["cod_triple"])) {
        foreach ($_POST["cod_triple"] as $cod_triple) {
            $cod_termin=$_POST["cod_termin"][$t];
            $x_ganador[0]=$_POST["num_resulA"][$t];
            $x_ganador[1]=$_POST["num_resulB"][$t];
            $x_ganador[2]=$_POST["num_resulC"][$t];
            $x_ganador[3]=$_POST["num_resulZ"][$t];
            $x_ganador[4]=$_POST["num_resulS"][$t];
            $pTriple = explode("-", $cod_triple);
            $pTermin = explode("-", $cod_termin);
            $signo=array("","ARI","TAU","GEM","CAN","LEO","VIR","LIB","ESC","SAG","CAP","ACU","PIS");
            for ($i = 0; $i < count($pTriple); ++$i) {
                if ($i==count($pTriple)-1) {
                    $cod_signo=array_search($x_ganador[$i+1], $signo);
                } else {
                    $cod_signo=0;
                }
                $cod_signo=$cod_signo*1;
                if (strlen(trim($x_ganador[$i]))==3) {
                    $query_Recordset13 =  sprintf(
                        "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 2 */ SELECT re.num_resultado, re.sig_resultado, re.id_resultado
						FROM resultados_lot re WHERE id_loteria=%s AND fec_resultado=%s AND id_banca=%s LIMIT 1",
                        GetSQLValueString($pTriple[$i], "int"),
                        GetSQLValueString($_POST["fec_resultado"], "date"),
                        GetSQLValueString($id_banca, "int")
                    );
                    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
                    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
                    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
                    if ($totalRows_Recordset13==0) {
                        $insertSQL2 = sprintf(
                            "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 3 */ INSERT 
							INTO resultados_lot 
							(num_resultado, id_loteria, sig_resultado, fec_resultado, id_banca) 
							VALUES (%s, %s, %s, %s, %s)",
                            GetSQLValueString(trim($x_ganador[$i]), "text"),
                            GetSQLValueString($pTriple[$i], "int"),
                            GetSQLValueString($cod_signo, "int"),
                            GetSQLValueString($_POST["fec_resultado"], "date"),
                            GetSQLValueString($id_banca, "int")
                        );
                        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                        $premiar=1;
                    } elseif ($row_Recordset13['num_resultado']!=$x_ganador[$i] or $row_Recordset13['sig_resultado']!=$cod_signo) {
                        $insertSQL1 = sprintf(
                            "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 4 */ UPDATE resultados_lot SET num_resultado=%s, sig_resultado=%s
							WHERE id_resultado=%s",
                            GetSQLValueString($x_ganador[$i], "text"),
                            GetSQLValueString($cod_signo, "int"),
                            GetSQLValueString($row_Recordset13['id_resultado'], "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                        $premiar=1;
                    }
                    mysqli_free_result($Recordset13);
                }
                if ($premiar==1) {
                    $xpTriple=$pTriple[$i];
                    $xpTermin=$pTermin[$i];
                    $xganador=$x_ganador[$i];
                    include("../admin_lot/procesar_premios_lot.php");
                }
            }
            $t++;
        }
    }
    $t=0;
    if (isset($_POST["cod_animal"])) {
        $premiar=0;
        foreach ($_POST["cod_animal"] as $cod_animal) {
            $termin=$_POST["res_animal"][$t];
            if ($cod_animal>0) {
                $query_Recordset13 =  sprintf(
                    "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 5 */ SELECT re.num_resultado, re.sig_resultado, re.id_resultado
					FROM resultados_lot re WHERE id_loteria=%s AND fec_resultado=%s AND id_banca=%s LIMIT 1",
                    GetSQLValueString($cod_animal, "int"),
                    GetSQLValueString($_POST["fec_resultado"], "date"),
                    GetSQLValueString($id_banca, "int")
                );
                $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
                $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
                $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
                if ($totalRows_Recordset13==0) {
                    $insertSQL2 = sprintf(
                        "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 6 */ INSERT 
						INTO resultados_lot 
						(num_resultado, id_loteria, fec_resultado, id_banca) 
						VALUES (%s, %s, %s, %s)",
                        GetSQLValueString(trim($termin), "text"),
                        GetSQLValueString($cod_animal, "int"),
                        GetSQLValueString($_POST["fec_resultado"], "date"),
                        GetSQLValueString($id_banca, "int")
                    );
                    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                    $premiar=1;
                } elseif ($row_Recordset13['num_resultado']!=$termin) {
                    $insertSQL1 = sprintf(
                        "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 7 */ UPDATE resultados_lot SET num_resultado=%s 
						WHERE id_resultado=%s",
                        GetSQLValueString($termin, "text"),
                        GetSQLValueString($row_Recordset13['id_resultado'], "int")
                    );
                    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                    $premiar=1;
                }
                mysqli_free_result($Recordset13);
            }
            if ($premiar==1) {
                $xpTriple=$cod_animal;
                $xpTermin=0;
                $xganador=$termin;
                $cod_signo=0;
                include("../admin_lot/procesar_premios_lot.php");
            }
            $t++;
        }
    }
    if (isset($ticketPre)) {
        include("../admin_lot/procesar_ticket_premiados_lot.php");
    }
    $menS="<br/>&nbsp;&nbsp;RESULTADO(S) GUARDADOS CORRECTAMENTE&nbsp;&nbsp;<br/>&nbsp;";
}
if ((isset($_POST["MM_update"])) && (isset($_POST["guardar"]))) {
    $y=0;
    $guarda=100;
    $ganador=$_POST["ganador"];
    $signo=$_POST["signo"];
    $tip_loteria=$_POST["tip_loteria"];
    $fec_resultado=$_POST["fec_resultado"];
    
    foreach ($_POST["id_loteria"] as $id_loteria) {
        if ($signo[$y]<0&&($tip_loteria[$y]==3 or $tip_loteria[$y]==6)) {
            $menE="&nbsp;&nbsp;Seleccione signo o carta&nbsp;&nbsp;";
            $guarda--;
            break;
        }
        if ($ganador[$y]=="") {
            $menE="&nbsp;&nbsp;Indique numero de resultado&nbsp;&nbsp;";
            $guarda--;
            break;
        }
        $y++;
    }
    if ($guarda==100) {
        $y=0;
        $u=0;
        if (isset($_POST["modificar"])&&$_POST["modificar"]==0) {
            $menS="&nbsp;&nbsp;RESULTADO GUARDADO CORRECTAMENTE&nbsp;&nbsp;";
            $id_terminal=$_POST["id_terminal"];
            $proceso=1;
            foreach ($_POST["id_loteria"] as $id_loteria) {
                $insertSQL2 = sprintf(
                    "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 8 */ INSERT 
					INTO resultados_lot 
					(num_resultado, id_loteria, sig_resultado, fec_resultado, id_banca) 
					VALUES (%s, %s, %s, %s, %s)",
                    GetSQLValueString($ganador[$y], "text"),
                    GetSQLValueString($id_loteria, "int"),
                    GetSQLValueString($signo[$y], "int"),
                    GetSQLValueString($fec_resultado, "date"),
                    GetSQLValueString($id_banca, "int")
                );
                $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                $xpTriple=$id_loteria;
                $xpTermin=$id_terminal[$y];
                $xganador=$ganador[$y];
                $cod_signo=$signo[$y];
                include("../admin_lot/procesar_premios_lot.php");
                $y++;
            }
        } elseif (isset($_POST["modificar"])&&$_POST["modificar"]==1) {
            $id_triple=$_POST["id_loteria"];
            $id_terminal=$_POST["id_terminal"];
            foreach ($_POST["id_resultado"] as $id_resultado) {
                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 9 */ UPDATE resultados_lot 
					SET
					num_resultado=%s, sig_resultado=%s 
					WHERE id_resultado=%s",
                    GetSQLValueString($ganador[$y], "text"),
                    GetSQLValueString($signo[$y], "int"),
                    GetSQLValueString($id_resultado, "int")
                );
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                $xpTriple=$id_triple[$y];
                $xpTermin=$id_terminal[$y];
                $xganador=$ganador[$y];
                $cod_signo=$signo[$y];
                include("../admin_lot/procesar_premios_lot.php");
                $y++;
            }
            $menS="&nbsp;&nbsp;RESULTADO MODIFICADO CORRECTAMENTE&nbsp;&nbsp;";
        }
        if (isset($ticketPre)) {
            include("../admin_lot/procesar_ticket_premiados_lot.php");
        }
        $menS.="<br/>".$_POST["nom_sorteo"];
        $menE="";
    } else {
        $menE.="<br/>".$_POST["nom_sorteo"];
        $menS="";
    }
}
$fechahoy=fechaactualbd();
$horasistema=horaactual();
if ((isset($_POST["MM_update2"])) && ($_POST["MM_update2"] == "form2")) {
    if (fechaymd($_POST['fecha'])<=fechaactualbd()) {
        $_POST['fecha']=fechaymd($_POST['fecha']);
        $_POST["fec_filtro"]=$_POST['fecha'];
        $fechahoy=$_POST['fecha'];
        $diahoy=diaSegunFecha($_POST['fecha']);
        $cDia=loteriaHoyAdmin($diahoy);
    }
}
if ((isset($_POST["MM_inserto"])) && ($_POST["MM_inserto"] == "formo") && (isset($_POST["od_sorteo"]))) {
    $fechahoy=$_POST["fec_filtro"];
    $diahoy=diaSegunFecha($_POST["fec_filtro"]);
    $cDia=loteriaHoyAdmin($diahoy);
    $osorteo = implode("','", $_POST["od_sorteo"]);
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 10 */ SELECT 
		lo.nom_loteria, lo.id_loteria, lo.id_terminal, lo.tip_loteria, lo.let_loteria,
		so.nom_sorteo, so.hor_sorteo, so.id_sorteo,
		re.id_resultado, re.fec_resultado, re.num_resultado, re.sig_resultado,
		CASE lo.tip_loteria
			WHEN 4 THEN (/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 11 */ SELECT ani.nom_animal FROM animales ani WHERE ani.id_animal=re.num_resultado LIMIT 1)
			WHEN 5 THEN (/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 12 */ SELECT fru.nom_fruta  FROM frutas fru   WHERE fru.id_fruta=re.num_resultado  LIMIT 1)
			ELSE '_'
		END AS nom_anifru
		FROM 
			sorteos so,
			loterias lo
		LEFT JOIN resultados_lot re ON re.id_loteria = lo.id_loteria AND re.fec_resultado = %s AND re.id_banca = %s
		WHERE ((lo.tip_loteria = 1 OR lo.tip_loteria>=3) AND lo.est_loteria=1) AND 
		$cDia = 1 AND so.id_sorteo = lo.id_sorteo  AND so.est_sorteo=1 AND so.id_sorteo IN ('$osorteo')
		ORDER BY  so.hor_sorteo, so.id_sorteo, lo.let_loteria, lo.tip_loteria ASC",
        GetSQLValueString($_POST["fec_filtro"], "date"),
        GetSQLValueString($id_banca, "int")
    );
    $osorteo = $_POST["od_sorteo"];
} else {
    $osorteo=array();
    if (!isset($_POST["fec_filtro"])) {
        $_POST["fec_filtro"]=$fechahoy;
    } else {
        $fechahoy=$_POST["fec_filtro"];
    }
    $diahoy=diaSegunFecha($_POST["fec_filtro"]);
    $cDia=loteriaHoyAdmin($diahoy);
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 13 */ SELECT 
		lo.nom_loteria, lo.id_loteria, lo.id_terminal, lo.tip_loteria, lo.let_loteria,
		so.nom_sorteo, so.hor_sorteo, so.id_sorteo,
		re.id_resultado, re.fec_resultado, re.num_resultado, re.sig_resultado,
		CASE lo.tip_loteria
			WHEN 4 THEN (/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 14 */ SELECT ani.nom_animal FROM animales ani WHERE ani.id_animal=re.num_resultado LIMIT 1)
			WHEN 5 THEN (/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 15 */ SELECT fru.nom_fruta  FROM frutas fru   WHERE fru.id_fruta=re.num_resultado  LIMIT 1)
			ELSE '_'
		END AS nom_anifru
		FROM 
			sorteos so,
			loterias lo
		LEFT JOIN resultados_lot re ON re.id_loteria = lo.id_loteria AND re.fec_resultado = %s AND re.id_banca = %s
		WHERE ((lo.tip_loteria = 1 OR lo.tip_loteria>=3) AND lo.est_loteria=1) AND 
		$cDia = 1 AND so.id_sorteo = lo.id_sorteo  AND so.est_sorteo=1
		ORDER BY  so.id_sorteo, lo.let_loteria, lo.tip_loteria, so.hor_sorteo ASC",
        GetSQLValueString($_POST["fec_filtro"], "date"),
        GetSQLValueString($id_banca, "int")
    );
}
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset2 = "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 16 */ SELECT id_signo, nom_corto FROM signos ORDER BY id_signo";
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$query_Recordset3 =  sprintf("/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 17 */ SELECT so.id_sorteo, so.nom_sorteo
	FROM loterias lo, sorteos so 
	WHERE ((lo.tip_loteria = 1 OR lo.tip_loteria>=3) AND lo.est_loteria=1) AND 
	$cDia = 1 AND so.id_sorteo = lo.id_sorteo  AND so.est_sorteo=1
	GROUP BY so.id_sorteo
	ORDER BY lo.nom_loteria ASC");
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$contador=0;
do {
    $cod_signos[$contador]=$row_Recordset2['id_signo'];
    $nom_signos[$contador]=$row_Recordset2['nom_corto'];
    $contador++;
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
$query_Recordset4 = "/* PARSEADORES1 agente_lot\agente_resultados_trte_lot.php - QUERY 18 */ SELECT id_palo, nom_palo FROM palos_cartas ORDER BY id_palo";
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$contador=0;
do {
    $cod_palos[$contador]=$row_Recordset4['id_palo'];
    $nom_palos[$contador]=$row_Recordset4['nom_palo'];
    $contador++;
} while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
  .textbox, .textboxsmal {
  border: 1px solid #DBE1EB;
  font-size: 16px;
  font-family: Arial, Verdana;
  padding-left: 7px;
  padding-right: 7px;
  padding-top: 10px;
  padding-bottom: 10px;
  border-radius: 4px;
  -moz-border-radius: 4px;
  -webkit-border-radius: 4px;
  -o-border-radius: 4px;
  background: #FFFFFF;
  background: linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -moz-linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -webkit-linear-gradient(left, #FFFFFF, #F7F9FA);
  background: -o-linear-gradient(left, #FFFFFF, #F7F9FA);
  color: #2E3133;
  height:24px;
  }
  .textbox:focus, .textboxsmal:focus {color:#2E3133;border-color:#FBFFAD;}
  .textboxsmal {width:80px;height:8px;}
  .divin {
	vertical-align:top;
	width: 33.3%;
	height: 90px;
	float: left;
	font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;
	}
    #example-optionClass-container .multiselect-container li.odd {background:#eeeeee;}
    #example-optionClass-container .multiselect-all {background: #eeeeee; color:#EB0408}
 </style>
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #eeeeee;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script type="text/javascript" src="../admin_lot/jslot/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../admin_lot/jslot/bootstrap.min.js"></script>
<script type="text/javascript" src="../admin_lot/jslot/multiselect.js"></script>
<script>
var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</h3></p>';
var esp1='<div style="text-align:center"><div style="padding:120px 0px;font-size:20px"><i class="fa fa-spinner fa-spin fa-2x"></i>';
var esp2='<br/><font size=2>BUSCANDO RESULTADO DESDE ';
var esp3='</font><br/>Por favor espere...';
var esp4='</div></div>';
$(document).ready(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());var refreshId1 = setInterval(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);$('#divS').fadeOut(12000);$('#divE').fadeOut(12000);
	$('input[type="text"]').keyup(function(){
		if($(this).val().length > 2){
			cb = parseInt($(this).attr('tabindex'));
			if ($(':input[tabindex=\'' + (cb + 1) + '\']') != null) {$(':input[tabindex=\'' + (cb + 1) + '\']').focus();
				$(':input[tabindex=\'' + (cb + 1) + '\']').select();e.preventDefault();return false;}
		}
	});
	$('#od_sorteo').multiselect({
		includeSelectAllOption: true, // add select all option as usual
		enableCaseInsensitiveFiltering: true, numberDisplayed: 3, buttonWidth: 285, maxHeight: 500,
		optionClass: function(element) {
			var value = $(element).val();
			if (value%2 == 0) { return 'odd'; }
			else { return 'even'; }
		}
	});
	$('#bu_sorteo').change(function(){
		if ($('#bu_sorteo').val()>0) {
			var valor = $("#bu_sorteo option:selected").html();
			var url = "../admin_lot/admin_resultado_buscar_lot.php"; 
			form1=this.form;
			$.ajax({ type: "POST", url: url, global : false, data: $(form1).serialize(), dataType: "html",
				beforeSend: function(){
					$('#inicial').html(esp1+esp2+valor+esp3+esp4);
				},
				success: function(data) {
					$("#inicial").html(data);
				},
				error: function(){ 
					$("#inicial").html(xerror);
				}
			});
		}
	});
	$('input[name="buscar"]').click(function(){
		var url = "../admin_lot/admin_resultado_buscar_lot.php"; form1=this.form;
		$.ajax({ type: "POST", url: url, global : false, data: $(form1).serialize(), dataType: "html",
			beforeSend: function(){
				$('#inicial').html(esper1+esper2);
			},
			success: function(data) {
				$("#inicial").html(data);
			},
			error: function(){ 
				$("#inicial").html(xerror);
			}
		});
	});	
});
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
function r_guardar() {
	//$('#inicial').html(esp1+'<br/><font size=2>GUARDANDO RESULTADOS Y PROCESANDO TICKETS'+esp3+esp4);
	alert('SE GUARDARAN RESULTADOS Y SE PROCESARAN TICKETS');
}
function solo_numero(e) {
 	tecla = (document.all) ? e.keyCode : e.which;
 	if (tecla==8) return true; 
	patron =/[0-9]/; 
	tecla_final = String.fromCharCode(tecla);
 	return patron.test(tecla_final); 
}
function habilitar(clase,idnum,bton) {
	$("."+clase).removeAttr('disabled');
	$("#cancelar"+clase).css('display','');
	$('input[class="'+clase+'"]').css('background-color', ' #FFF1C9');
	$('#'+idnum).focus();
	$(".btn-info").attr('disabled','disabled');
	$(bton).css('display','none');
	event.preventDefault();
} 
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
	<div class="header" style="height:100px; background:#0084B4;">
		<?php include("../includes/cabeceraamericana_ag.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabeceraagente_lot.php");?>
                </div>
            </div> <!-- end .menu -->
	</div> <!-- end .header -->
	<div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
		id="datosUsuario">
		<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
			margin:20px 0px 0px 0px; width:240px; font-size:16px"> 
			RESULTADOS DE SORTEOS<br/>
		</div>
		Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
		<span id="reloj"></span>
	</div>
	<div class="contentAdmin">
		<div style="padding:5px 0px; float:right; color:#FFFFFF;background: #58D98F;font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divS">
        	<?php echo $menS; ?>
		</div>
		<div style="padding:5px 0px; float:right; color:#FFFFFF;background:#FF9A9C;font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divE">
			<?php echo $menE; ?>   
		</div>
		<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
			<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;" id="inicial">
					<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr valign="baseline">
                            <td height="42" colspan="3" align="center" valign="middle" nowrap 
                            	style="background:#333333;font-size:24px;color:#FFF">
                                <strong>RESULTADOS DE SORTEOS</strong>
                                <?php echo '<font size="2"><br/>Fecha de resultado: '.verfechaF($fechahoy).'</font>'; ?>
                            </td>
                        </tr>
						<tr valign="baseline" style="border-bottom:1px solid  #D5D5D5; background:#D5D5D5;">
							<form action="<?php echo $editFormAction; ?>" method="POST" name="formo" id="formo" 
                                autocomplete="off" onsubmit="return chequearEnvio();">
                                <td width="65%" height="30" align="left" valign="bottom" nowrap 
                                    style="font-size:18px;color:#000; padding:0 0 0 10px">
                                    <div style="width:350px; float:left; padding:0px 0 0 0;">
                                    FILTRAR POR SORTEO:
                                    </div>
                                    <div style="float:left; margin:1px 0 0 5px;">
                                    <select multiple="multiple" name="od_sorteo[]" id="od_sorteo"
                                        style="width:227px; height:50px; font-size:16px;margin:2px 0 2px 10px;float:left;"><?php
                                        do {?>
                                            <option value="<?php echo $row_Recordset3['id_sorteo']?>" 
											<?php if (in_array($row_Recordset3['id_sorteo'], $osorteo)) {
                                            echo"selected=\"selected\"";
                                        }?>>
                                            <?php echo $row_Recordset3['nom_sorteo']?></option><?php
                                        } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
                                    </select>
									</div>
                                    <div style="width:80px; float:left; margin:0 0 0 5px;">
									<input type="submit" value="Filtrar" class="btn btn-danger" title="iniciar busqueda" 
										style="width:80px; height:30px;"/>
									</div>
                                    <input type="hidden" name="MM_inserto" value="formo"/>
                                    <input type="hidden" name="fec_filtro" value="<?php echo $fechahoy?>"/>
                                </td>
							</form>
							<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2" 
                                autocomplete="off" onsubmit="return chequearEnvio();">
                                <td width="14%" align="left" valign="bottom" nowrap><?php
                                    if ($mod_resultado==0) {?>
                                    <div style="width:300px; float:left; padding:0px 0 0 5px;">
                                        BUSCAR RESULTADOS:
                                    </div>
                                    <div style="float:left; margin:1px 0 0 10px;">
                                        <select name="bu_sorteo" id="bu_sorteo" class="btn"
                                            style="width:227px; height:28px; font-size:12px;margin:2px 0 2px 5px;float:left;">
                                            <option value="0">Seleccione</option>
                                            <option value="1">TUAZAR</option>
                                        </select>
                                    </div><?php
                                    }?>
                                </td>
								<td width="21%" align="left" valign="bottom" nowrap 
									style="font-size:18px;color:#000000;">
									FECHA:<BR/>
									<input name="fecha" type="text" id="dateArrival1" tabindex="0" 
										style="width:90px; font-size:16px; height:19px; margin:2px 0 2px 0"
										title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
										value="<?php echo htmlentities(fechanueva($fechahoy), ENT_COMPAT, 'utf-8'); ?>"/>
									<input type="submit" value="Buscar" class="btn btn-danger" title="iniciar busqueda" 
										style="width:80px; height:30px"/>
									<input type="hidden" name="MM_update2" value="form2" />
									<input type="hidden" name="cod_banca" value="<?php echo $id_banca;?>" />
                                          
								</td>
							</form>
                        </tr>
                    </table><?php
                    if ($totalRows_Recordset1>0) {
                        $sorteo="";
                        $c=0;
                        $cambio=1;
                        $nom_sorteo=$row_Recordset1['nom_sorteo'];
                        $tp_sorteo="";
                        do {
                            list($hor, $min, $am)=explode(":", cambioHoramysql($row_Recordset1['hor_sorteo']));
                            if ($sorteo!=$row_Recordset1['nom_sorteo']) {
                                if ($c>0) {
                                    if ($tp_sorteo<4) {
                                        echo '<table width="100%" border="0">';
                                        echo '<tr valign="bottom" align="left">';
                                        echo '<td>';
                                    } elseif ($mod_resultado==0) {
                                        echo'<div style="width:165px;float:left;height:37px;padding:5px 0 28px 20px">';
                                    }
                                    if ($modifica==1&&$mod_resultado==0) {?>
                                            <input type="submit" name="modificar" value="MODIFICAR"
                                            	class="btn btn-primary <?php echo $idsorteo?>" 
                                                style="width:75px; height:25px; font-size:10px; margin:2px" 
                                                onClick="habilitar('<?php echo $idsorteo?>','<?php echo $idloteria;?>',this)"
                                                title="modificar resultados<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo;?>" />
											<input type="hidden" name="modificar" value="1" /> <?php
                                        } else {
                                            if ($mod_resultado==0) {?>
                                            <input type="submit" name="incluir" value="INCLUIR" id="incluir"
                                            	class="btn btn-info <?php echo $idsorteo?>" 
                                                style="width:60px; height:25px; font-size:10px; margin:2px" 
                                                onClick="habilitar('<?php echo $idsorteo?>','<?php echo $idloteria;?>',this)"
                                                title="incluir resultados<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo;?>" />
											<input type="hidden" name="modificar" value="0" /><?php
                                            }
                                        }
                                    if ($mod_resultado==0) {?> 
										<input type="submit" name="cancelar" value="CANCELAR" id="cancelar<?php echo $idsorteo?>"
                                        	class="btn btn-danger <?php echo $idsorteo?>" 
                                        	style="width:75px; height:25px; font-size:10px; margin:1px; display:none;" 
                                            disabled="disabled" 
                                            title="&nbsp;cancelar" />

										<input type="submit" name="guardar" value="GUARDAR" 
                                        	class="btn btn-success <?php echo $idsorteo?>" 
                                        	style="width:75px; height:25px; font-size:10px; margin:1px" disabled="disabled" 
                                            title="&nbsp;guardar resultados<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo;?>" />

										<input type="hidden" name="MM_update" value="form1" /> 
                                        <input type="hidden" name="fec_resultado" value="<?php echo $fechahoy;?>" /><?php
                                        }
                                    if ($tp_sorteo<4) {
                                        echo '</td>';
                                        echo '</tr>';
                                        echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                                        echo '<td>';
                                        echo '</td>';
                                        echo '</tr>';
                                        echo '</table>';
                                    } else {
                                        if ($mod_resultado==0) {
                                            echo '</div>';
                                        }
                                        echo '<td><div style="margin:2px 0 0 0;"></div>';
                                        echo '<table width="100%" border="0">';
                                        echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                                        echo '<td>';
                                        echo '</td>';
                                        echo '</tr>';
                                        echo '</table>';
                                    }
                                    echo '</form>';
                                    echo '</div>';
                                }
                                $cambio=1;
                                $nom_sorteo=$row_Recordset1['nom_sorteo'];
                                if ($mod_resultado==0) {
                                    echo'<div class="divin" style="height:110px;">';
                                } else {
                                    echo'<div class="divin">';
                                }
                            }
                            if ($cambio==1) {
                                echo '<form method="post" action="'.$editFormAction.'" onsubmit="return chequearEnvio();" name="form[]" id="form" style="margin:0">';
                            }
                            if ($sorteo!=$row_Recordset1['nom_sorteo']) {
                                echo '<div style="width:100%;font-size:12px;float:left">';
                                echo "&nbsp;<br/>".$row_Recordset1['nom_sorteo'];
                                $sorteo=$row_Recordset1['nom_sorteo'];
                                $idsorteo="ls".$row_Recordset1['id_sorteo'];
                                $idloteria="res".$row_Recordset1['id_sorteo'];
                                echo '<input type="hidden" name="nom_sorteo" value="'.$sorteo.'"/>';
                                echo '<input type="hidden" name="id_sorteo" value="'.$row_Recordset1['id_sorteo'].'"/>';
                                echo '</div>';
                            } else {
                                echo '&nbsp;';
                            }
                            echo '<div style="width:50px;font-size:12px;float:left;background:#D5D5D5;text-align:center;">';
                            $tp_sorteo=$row_Recordset1['tip_loteria'];
                            if ($tp_sorteo<4) {
                                echo $row_Recordset1['let_loteria'];
                            } else {
                                echo substr($row_Recordset1['nom_sorteo'], -4, 4);
                            }
                            if ($row_Recordset1['num_resultado']!="") {
                                $modifica=1;
                            } else {
                                $modifica=0;
                            }
                                
                            if ($tp_sorteo<4) {
                                ?>
								<input style="height:20px; width:40px; font-size:18px" name="ganador[]" 
                                	id="<?php echo $idloteria?>" 
                                	class="<?php echo $idsorteo?>" 
                                    onKeyPress="return solo_numero(event)" type="text" size="3" maxlength="3"
                                     title=" indique número de resultado <?php echo "&nbsp;&#13;".$row_Recordset1['nom_loteria']; ?>" 
                                    onKeyUp="return handleEnter(this, event)" disabled="disabled"
                                    value="<?php echo $row_Recordset1['num_resultado']?>" 
                                    tabindex="<?php echo $c; ?>"/><?php
                            } else {
                                if ($tp_sorteo==4) {
                                    $d=0;
                                    $h=36;
                                } elseif ($tp_sorteo==5) {
                                    $d=1;
                                    $h=38;
                                } elseif ($tp_sorteo==6) {
                                    $d=1;
                                    $h=12;
                                } ?>
                                    <select name="ganador[]" style="width:48px; height:30px; font-size:16px" disabled="disabled" 
                                    	id="<?php echo $idloteria?>"  class="<?php echo $idsorteo?>">
                                        <option value="-1">---<?php
                                        if ($tp_sorteo==4) {?>
                                        <option value="00"<?php
                                            if (!(strcmp("00", htmlentities($row_Recordset1['num_resultado'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>00<?php
                                        }
                                for ($i = $d; $i <= $h; ++$i) {?>
                                            <option value="<?php echo $i?>"<?php
                                            if (!(strcmp($i, htmlentities($row_Recordset1['num_resultado'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>
                                            <?php echo $i?></option><?php
                                        } ?>
                                    </select>
                                
                                
                                <?php
                            } ?>
                                    
								<input type="hidden" name="id_resultado[]" value="<?php echo $row_Recordset1['id_resultado']?>" />
								<input type="hidden" name="id_loteria[]" value="<?php echo $row_Recordset1['id_loteria']?>"/>
								<input type="hidden" name="id_terminal[]" value="<?php echo $row_Recordset1['id_terminal']?>"/>
                                <input type="hidden" name="tip_loteria[]" value="<?php echo $row_Recordset1['tip_loteria']?>"/>
                            <?php
                            echo '</div>';
                            if ($row_Recordset1['tip_loteria']==4 or $row_Recordset1['tip_loteria']==5) {
                                echo '<div style="width:220px;font-size:12px;float:left;background:#D5D5D5;text-align:center;">';
                                echo "&nbsp;<strong>".$row_Recordset1['nom_anifru']."</strong>";
                                echo '</div>';
                            }
                            if ($row_Recordset1['tip_loteria']==3 or $row_Recordset1['tip_loteria']==6) {
                                if ($row_Recordset1['tip_loteria']==3) {?>
                                    <div style="width:70px;font-size:12px;float:left;background:#D5D5D5;text-align:left;">
                                        Signo
                                        <select name="signo[]" style="width:60px; height:30px" disabled="disabled" 
                                            class="<?php echo $idsorteo?>">
                                            <option value="-1">---<?php $x=0;
                                            foreach ($cod_signos as $cSigno) {?>
                                                <option value="<?php echo $cSigno?>"<?php
                                            if (!(strcmp($cSigno, htmlentities($row_Recordset1['sig_resultado'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>
                                                <?php echo $nom_signos[$x]?></option><?php $x++;
                                            }?>
                                        </select>
                                    </div><?php
                                } elseif ($row_Recordset1['tip_loteria']==6) {?>
									<div style="width:70px;font-size:12px;float:left;background:#D5D5D5;text-align:left;">
										Carta
										<select name="signo[]" style="width:60px; height:30px" disabled="disabled" 
											class="<?php echo $idsorteo?>">
											<option value="-1">---<?php $x=0;
                                            foreach ($cod_palos as $cSigno) {?>
												<option value="<?php echo $cSigno?>"<?php
                                            if (!(strcmp($cSigno, htmlentities($row_Recordset1['sig_resultado'], ENT_COMPAT, 'utf-8')))) {
                                                echo "SELECTED";
                                            } ?>>
												<?php echo $nom_palos[$x]?></option><?php $x++;
                                            }?>
										</select>
									</div><?php
                                }
                            } else {
                                echo '<input type="hidden" name="signo[]" value="0"/>';
                            }
                            $c++;
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                        if ($tp_sorteo<4) {
                            echo '<table width="100%" border="0">';
                            echo '<tr valign="bottom" align="left">';
                            echo '<td>';
                        } else {
                            echo'<div style="width:165px;float:left;height:37px;padding:5px 0 28px 20px">';
                        }
                        if ($modifica==1) {
                            if ($mod_resultado==0) {?>
								<input type="submit" name="modificar" value="MODIFICAR"
									class="btn btn-primary <?php echo $idsorteo?>" 
									style="width:75px; height:25px; font-size:10px; margin:2px" 
									onClick="habilitar('<?php echo $idsorteo?>','<?php echo $idloteria;?>',this)"
									title="modificar resultados<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo;?>" />
								<input type="hidden" name="modificar" value="1" /> <?php
                                }
                        } else {
                            if ($mod_resultado==0) {?>
								<input type="submit" name="incluir" value="INCLUIR" id="incluir"
									class="btn btn-info <?php echo $idsorteo?>" 
									style="width:60px; height:25px; font-size:10px; margin:2px" 
									onClick="habilitar('<?php echo $idsorteo?>','<?php echo $idloteria;?>',this)"
									title="incluir resultados<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo;?>" />
								<input type="hidden" name="modificar" value="0" /><?php
                                }
                        }
                        if ($mod_resultado==0) {?> 
							<input type="submit" name="cancelar" value="CANCELAR" id="cancelar<?php echo $idsorteo?>"
								class="btn btn-danger <?php echo $idsorteo?>" 
								style="width:75px; height:25px; font-size:10px; margin:1px; display:none" 
								disabled="disabled" 
								title="&nbsp;cancelar" />
							<input type="submit" name="guardar" value="GUARDAR" 
								class="btn btn-success <?php echo $idsorteo?>" 
								style="width:75px; height:25px; font-size:10px; margin:1px" disabled="disabled" 
								title="&nbsp;guardar resultados<?php echo '&nbsp;&#13;sorteo: '.$nom_sorteo;?>" />
							<input type="hidden" name="MM_update" value="form1" /> 
							<input type="hidden" name="fec_resultado" value="<?php echo $fechahoy;?>" /><?php
                            }
                        if ($tp_sorteo<4) {
                            echo '</td>';
                            echo '</tr>';
                            echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                            echo '<td>';
                            echo '</td>';
                            echo '</tr>';
                            echo '</table>';
                        } else {
                            echo '</div>';
                            if ($mod_resultado==0) {
                                echo '</div>';
                            }
                            echo '<td><div style="margin:2px 0 0 0;"></div>';
                            echo '<table width="100%" border="0">';
                            echo '<tr valign="bottom" style="background:#0084B4;color:#FFFFFF">';
                            echo '<td>';
                            echo '</td>';
                            echo '</tr>';
                            echo '</table>';
                        }
                        echo '</form>';
                        echo '</div>';
                    } else {?>
                    <div style="padding:90px 0px; text-align:center; font-size:20px; background: #FEFCE7">
                    ATENCION!<br/>
                    NO SE PUEDE INCLUIR RESULTADOS A LOS SORTEO(S) SELECCIONADOS 
                    </div>
                    <?php
                    }?>
			</div>
		</div>
	</div>
	<div class="footer" style="background:#0084B4">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
</div>
</body>
</html>
<?php
if (isset($Recordset1)) {
                        mysqli_free_result($Recordset1);
                    }
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
?>
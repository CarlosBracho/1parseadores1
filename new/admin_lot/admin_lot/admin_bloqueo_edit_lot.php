<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$menSorteo="";
$menPrin="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && isset($_POST["agregar"])) {
    //echo "aquii";
    $guarda=80;
    
    
    if (isset($_POST['tip_bloqueo'])&&isset($_POST['cod_banca'])&&isset($_POST['num_bloqueo'])&&$_POST['num_bloqueo']!=""
        &&isset($_POST['ran_fecha'])&&$_POST['ran_fecha']>0) {
        if ($_POST['tip_bloqueo']==1) {
            $_POST['cod_agencia']=0;
            $_POST['cod_taquilla']=0;
        } elseif ($_POST['tip_bloqueo']==2) {
            $_POST['cod_taquilla']=0;
        } elseif ($_POST['tip_bloqueo']==3) {
            $separa=explode("-", $_POST['cod_taquilla']);
            $_POST['cod_agencia']=$separa[1];
            $_POST['cod_taquilla']=$separa[0];
        }
        
        if ($_POST['fecha_inicio']>$_POST['fecha_fin']) {
            $fc=$_POST['fecha_inicio'];
            $_POST['fecha_inicio']=$_POST['fecha_fin'];
            $_POST['fecha_fin']=$fc;
        }
        $in=fechaymd($_POST['fecha_inicio']);
        $fi=fechaymd($_POST['fecha_fin']);
        
        if ($_POST['ran_lot']==0) {
            $_POST['id_loteria']=0;
            $_POST['id_sorteo']=0;
        } elseif ($_POST['ran_lot']==1&&$_POST['id_sorteo']>0) {
            $_POST['id_loteria']=0;
        } elseif ($_POST['ran_lot']==2&&$_POST['id_loteria']>0) {
            $_POST['id_sorteo']=0;
        }
        
        if ($guarda==80) {
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 1 */ INSERT 
				INTO bloqueadoloterias 
				(num_bloqueado, id_sorteo, id_loteria, tip_rango, des_bloqueado, has_bloqueado, id_taquilla, 
				id_agencia, id_banca) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($_POST['num_bloqueo'], "int"),
                GetSQLValueString($_POST['id_sorteo'], "int"),
                GetSQLValueString($_POST['id_loteria'], "int"),
                GetSQLValueString($_POST['ran_fecha'], "int"),
                GetSQLValueString($in, "date"),
                GetSQLValueString($fi, "date"),
                GetSQLValueString($_POST['cod_taquilla'], "int"),
                GetSQLValueString($_POST['cod_agencia'], "int"),
                GetSQLValueString($_POST['cod_banca'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                
            $menPrin="&nbsp;&nbsp;DATOS GUARDADOS CORECTAMENTE&nbsp;&nbsp;";
        }
        
        //echo $_POST['tip_bloqueo']." ".$_POST['cod_banca']." ".$_POST['cod_agencia']." ".$_POST['cod_taquilla'];
        //echo " ".$_POST['ran_fecha']." ".$_POST['fecha_inicio']." ".$_POST['fecha_fin'];
        //echo $_POST['ran_fecha']." ".$_POST['ran_lot']." ".$_POST['id_sorteo']." ".$_POST['id_loteria'];
    } else {
        if (!isset($_POST['tip_bloqueo'])) {
            $menPrin="&nbsp;&nbsp;INDIQUE TIPO DE BLOQUEO&nbsp;&nbsp;";
        }
        if ($_POST['num_bloqueo']=="") {
            $menPrin="&nbsp;&nbsp;INDIQUE TRIPLE O TERMINAL&nbsp;&nbsp;";
        }
        if (!isset($_POST['ran_fecha'])) {
            $menPrin="&nbsp;&nbsp;INDIQUE FECHA&nbsp;&nbsp;";
        }
    }
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1") && isset($_POST["eliminar"])) {
    $query_delete =  sprintf(
        "/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 2 */ DELETE FROM bloqueadoloterias WHERE id_bloqueado = %s",
        GetSQLValueString($_POST['eliminar'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $query_delete) or die(mysqli_error($conexionbanca));
}
$xCodigo = "-1";
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 3 */ SELECT 
		ba.nom_banca, ba.nom_representante, ba.cod_banca
	FROM banca ba 
	WHERE ba.cod_banca = %s",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset2 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 4 */ SELECT 
		ag.nom_agencia, ag.cod_agencia
	FROM agencia ag
	WHERE ag.cod_banca = %s
	ORDER BY ag.nom_agencia",
    GetSQLValueString($xCodigo, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$query_Recordset3 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 5 */ SELECT 
		ta.nom_taquilla, ta.cod_taquilla, ag.nom_agencia, ag.cod_agencia
	FROM agencia ag, taquilla ta 
	WHERE ag.cod_banca = %s AND ta.cod_agencia = ag.cod_agencia
	ORDER BY ta.nom_taquilla",
    GetSQLValueString($xCodigo, "int")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);

$query_Recordset4 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 6 */ SELECT 
		so.id_sorteo, so.nom_sorteo
	FROM sorteos so, loterias lo 
	WHERE  lo.id_sorteo = so.id_sorteo AND lo.est_loteria = 1 AND (lo.tip_loteria = 1 OR lo.tip_loteria = 3)
	GROUP BY so.id_sorteo
	ORDER BY so.nom_sorteo",
    GetSQLValueString($xCodigo, "int")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);

$query_Recordset5 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 7 */ SELECT 
		bl.id_banca, lo.nom_loteria, lo.id_loteria
	FROM bancaloterias bl, loterias lo 
	WHERE  bl.id_banca = %s AND lo.id_loteria = bl.id_loteria AND lo.est_loteria = 1 AND (lo.tip_loteria = 1 OR lo.tip_loteria = 3)
	ORDER BY lo.nom_loteria",
    GetSQLValueString($xCodigo, "int")
);
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);


$query_Recordset6 =  sprintf(
    "/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 8 */ SELECT 
	bl.id_bloqueado, bl.num_bloqueado, bl.des_bloqueado, bl.has_bloqueado, bl.tip_rango,
	(CASE bl.id_sorteo
		WHEN 0 THEN 
			(CASE bl.id_loteria
				WHEN -1 THEN 'TODAS'
				WHEN 0 THEN 'TODAS'
				ELSE (/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 9 */ SELECT CONCAT('LOTERIA: ',lo.nom_loteria) FROM loterias lo WHERE lo.id_loteria = bl.id_loteria LIMIT 1)
			END)
		ELSE (/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 10 */ SELECT CONCAT('SORTEO: ',so.nom_sorteo) FROM sorteos so WHERE so.id_sorteo = bl.id_sorteo LIMIT 1)
	END) AS nomloteria,
	
	(CASE bl.id_taquilla
		WHEN 0 THEN 'TODAS'
		ELSE (/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 11 */ SELECT ta.nom_taquilla FROM taquilla ta WHERE bl.id_taquilla = ta.cod_taquilla LIMIT 1)
	END) AS nomtaquilla,
	
	(CASE bl.id_agencia
		WHEN 0 THEN 'TODAS'
		ELSE (/* PARSEADORES1 new\admin_lot\admin_lot\admin_bloqueo_edit_lot.php - QUERY 12 */ SELECT ag.nom_agencia FROM agencia ag WHERE ag.cod_agencia = bl.id_agencia LIMIT 1)
	END) AS nomagencia
	FROM bloqueadoloterias bl 
	WHERE bl.id_banca = %s
	ORDER BY bl.num_bloqueado ASC, nomtaquilla ASC",
    GetSQLValueString($xCodigo, "int")
);
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
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
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());var refreshId1 = setInterval(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);$('#divPrin').fadeOut(12000);
 	$('.tblo').click(function(){
		ocultaDiv();tcalDiv();
		if ($('input:radio[name=tip_bloqueo]:checked').val()==1) {
			document.getElementById("pa4").style.display = "";}
		else if ($('input:radio[name=tip_bloqueo]:checked').val()==2) {
			document.getElementById("pa2").style.display = "";}
		else if ($('input:radio[name=tip_bloqueo]:checked').val()==3) {
			document.getElementById("pa3").style.display = "";}
    });
	$('#cod_agencia').change(function(){
		tcalDiv();
		var codA=document.getElementById("cod_agencia").value;
		if (codA!="-1") document.getElementById("pa4").style.display = "";
		else {
			document.getElementById("pa3").style.display = "none";
			document.getElementById("pa4").style.display = "none";
			document.getElementById("pa5").style.display = "none";
		}
	});
	$('#cod_taquilla').change(function(){
		var codT=document.getElementById("cod_taquilla").value;
		if (codT!="-1") document.getElementById("pa4").style.display = "";
		else {
			document.getElementById("pa3").style.display = "none";
			document.getElementById("pa4").style.display = "none";
			document.getElementById("pa5").style.display = "none";
		}
	});
	$('#id_loteria').change(function(){
		if (document.getElementById("id_loteria").value!="-1") document.getElementById("pa5").style.display = "";
	});
 	
	$('.rlot1').click(function(){
		document.getElementById("pa5").style.display = "none";
		document.getElementById("id_sorteo").value = "-1";
		document.getElementById("id_loteria").value = "-1";
		document.getElementById("rfecha").style.display = "none";
		$("input:radio[name='ran_fecha']").each(function(i) {
			   this.checked = false;
		});	
		if ($('input:radio[name=ran_lot]:checked').val()==0) {
			document.getElementById("rsorteo").style.display = "none";
			document.getElementById("rloteria").style.display = "none";
			document.getElementById("pa5").style.display = "";
		}
		if ($('input:radio[name=ran_lot]:checked').val()==1) {
			document.getElementById("rsorteo").style.display = "";
			document.getElementById("rloteria").style.display = "none";
		}
		else if ($('input:radio[name=ran_lot]:checked').val()==2) {
			document.getElementById("rsorteo").style.display = "none";
			document.getElementById("rloteria").style.display = "";
		}
    }); 
	$('.rlot2').change(function(){
		if ($(this).val()!="-1") document.getElementById("pa5").style.display = "";
		else document.getElementById("pa5").style.display = "none";
    }); 
	
	$('.rblo').click(function(){
		if ($('input:radio[name=ran_fecha]:checked').val()==1) {
			document.getElementById("rfecha").style.display = "none";
			document.getElementById("pa6").style.display = "";
			tcalDiv();
		}
		else if ($('input:radio[name=ran_fecha]:checked').val()==2) {
			document.getElementById("rfecha").style.display = "";
			document.getElementById("pa6").style.display = "";
		}
		document.getElementById("num_bloqueo").focus();
    }); 
 });
var statusEnvio = false;
function chequearEnvio() {
if (!statusEnvio) { statusEnvio = true; return true;
} else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false;}}
function ocultaDiv() {
	$("input:radio[name='ran_fecha']").each(function(i) {this.checked = false;});	
	$("input:radio[name='ran_lot']").each(function(i) {this.checked = false;});	
	document.getElementById("pa3").style.display = "none";
	document.getElementById("pa4").style.display = "none";
	document.getElementById("pa5").style.display = "none";
	document.getElementById("pa2").style.display = "none";
	document.getElementById("pa6").style.display = "none";
	document.getElementById("rfecha").style.display = "none";
	document.getElementById("rsorteo").style.display = "none";
	document.getElementById("rloteria").style.display = "none";
	
	document.getElementById("id_sorteo").value = "-1";
	document.getElementById("id_loteria").value = "-1";
	document.getElementById("cod_agencia").value = "-1";
	document.getElementById("cod_taquilla").value = "-1";
}
function tcalDiv() {
$("#tcal").css('visibility','');$("#dateArrival1").removeClass("tcalActive");$("#dateArrival2").removeClass("tcalActive");}
function validar_numero(e) {
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true; 
	patron =/[0-9*]/; 
	tecla_final = String.fromCharCode(tecla);
 	return patron.test(tecla_final); 
}

</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
	<div class="header" style="height:100px; background:#0084B4">
		<?php include("../includes/cabeceraamericana.php");?>
		<div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
			<div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
				position:absolute;border-radius: 0px 0px 5px 5px;">
				<?php include("../includes/cabecera_lot.php");?>
			</div>
		</div> <!-- end .menu -->
	</div> <!-- end .header -->
	<div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
		id="datosUsuario">
		<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
			margin:20px 0px 0px 0px; width:240px; font-size:16px"> 
			EDITAR SORTEO<br/>
		</div>
		Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
		<span id="reloj"></span>
	</div>
	<div class="contentAdmin">
		<div style="padding:15px 0; float:right; color:#FFFFFF; background:#FF9A9C; font-size:22px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px;border: 0px solid #000000; margin:5px" id="divPrin">
			<?php echo $menPrin; ?>
		</div>
		<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
			<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                        <tr valign="baseline">
                            <td height="52" align="center" valign="middle" nowrap 
                            	style="background:#333333;font-size:24px;color:#FFF">
                                <strong>DISTRIBUIDOR: <?php echo $row_Recordset1['nom_banca']; ?></strong>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr align="center">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>NUMEROS BLOQUEADOS</td>
                        </tr>
                        <tr align="left">
                            <td width="44%" style="font-size:14px; background: #EDEDED" valign="top">
                                <div id="pa1" style="width:98%;padding:5px 1px 0 0;float:left;border-bottom:1px solid #D5D5D5">&nbsp;
                                	INDIQUE TIPO BLOQUEO:<br/>
                                	<div style="width:25%; float:left; padding:0 0 0 8px">
                                	    <input type="radio" name="tip_bloqueo" value="1" id="tip_bloqueo1" class="tblo" />
                                	    TOTAL
									</div>
                                	<div style="width:35%; float:left">
                                	    <input type="radio" name="tip_bloqueo" value="2" id="tip_bloqueo2" class="tblo" />
                                	    POR AGENTE
									</div>
                                	<div style="width:35%; float:left">
                                	    <input type="radio" name="tip_bloqueo" value="3" id="tip_bloqueo3" class="tblo" />
                                	    POR TAQUILLA
									</div>
                                </div>
								<div style="width:98%;padding:5px 1px 0 0;float:left;border-bottom:1px solid #D5D5D5; display:none"
                                	id="pa2">&nbsp;
                            		AGENTE:<br/>&nbsp;
                                    <select name="cod_agencia" style="width:190px; height:30px" id="cod_agencia">
                                        <option value="-1">SELECCIONE AGENTE</option><?php
                                            do {?>
                                                <option value="<?php echo $row_Recordset2['cod_agencia']?>">
                                                    <?php echo $row_Recordset2['nom_agencia']?>
                                                </option><?php
                                            } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));?>
                                    </select>
                                </div>
								<div style="width:98%;padding:5px 1px 0 0;float:left;border-bottom:1px solid #D5D5D5; display:none"
                                	id="pa3">&nbsp;
                            		TAQUILLA:<br/>&nbsp;
                                    <select name="cod_taquilla" style="width:190px; height:30px" id="cod_taquilla">
                                        <option value="-1">SELECCIONE TAQUILLA</option><?php
                                            do {
                                                $cTa=$row_Recordset3['cod_taquilla']."-".$row_Recordset3['cod_agencia']; ?>
                                                <option value="<?php echo $cTa; ?>">
                                                    <?php echo $row_Recordset3['nom_taquilla']?>
                                                </option><?php
                                            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
                                    </select>
                                </div>
								<div style="width:98%;padding:5px 1px 0 0;float:left;border-bottom:1px solid #D5D5D5; display:none"
                                	id="pa4">&nbsp;
                                	INDIQUE LOTERIA:<br/>
                                	<div style="width:35%; float:left;">&nbsp;
                                	    <input type="radio" name="ran_lot" value="1" id="ran_lot1" class="rlot1" />
                                	    POR SORTEO
										<div style="float:left; font-size:11px;width:110px;display:none; margin:0 0 0 8px" 
                                        	id="rsorteo">
                                            <select name="id_sorteo" style="width:190px; height:30px" class="rlot2" id="id_sorteo">
                                                <option value="-1">SELECCIONE SORTEO</option><?php
                                                    do {?>
                                              <option value="<?php echo $row_Recordset4['id_sorteo']?>">
                                                            <?php echo $row_Recordset4['nom_sorteo']?>
                                                        </option><?php
                                                    } while ($row_Recordset4 = mysqli_fetch_assoc($Recordset4));?>
                                            </select>
										</div>
									</div>
                                	<div style="width:30%; float:left;">
                                	    <input type="radio" name="ran_lot" value="2" id="ran_lot2" class="rlot1" />
                                	    INDIVIDUAL
										<div style="float:left; font-size:11px;display:none" id="rloteria">&nbsp;
                                            <select name="id_loteria" 
                                            	style="width:190px; height:30px; margin:-18px 0 9px 0;" 
                                            	class="rlot2" id="id_loteria">
                                                <option value="-1">SELECCIONE LOTERIA</option><?php
                                                    do {?>
                                              <option value="<?php echo $row_Recordset5['id_loteria']?>">
                                                            <?php echo $row_Recordset5['nom_loteria']?>
                                                        </option><?php
                                                    } while ($row_Recordset5 = mysqli_fetch_assoc($Recordset5));?>
                                            </select>
										</div>
									</div>
                                	<div style="width:30%; float:left;">
                                	    <input type="radio" name="ran_lot" value="0" id="ran_lot3" class="rlot1" />
                                	    TODAS
									</div>
                                </div>
								<div style="width:98%;padding:5px 1px 0 0;float:left;border-bottom:1px solid #D5D5D5; display:none"
                                	id="pa5">&nbsp;
                                	INDIQUE FECHA BLOQUEO:<br/>
                                	<div style="width:32%; float:left; padding:0 0 0 5px">
                                	    <input type="radio" name="ran_fecha" value="1" id="ran_fecha1" class="rblo" />
                                	    PERMANENTE
									</div>
                                	<div style="width:65%; float:left;">
                                	    <input type="radio" name="ran_fecha" value="2" id="ran_fecha2" class="rblo" />
                                	    POR RANGO
										<div style="float: right; font-size:11px; margin:-20px 0 0 0; display:none; 
                                        	text-align:center;" id="rfecha">
											<div style="float: left;">
                                            	desde:<br/>
                                                <input name="fecha_inicio" type="text" id="dateArrival1"  
                                                    style="width:65px; font-size:12px; height:20px;"
                                                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                                                    value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
											</div>
											<div style="float: right;">
                                            	hasta:<br/>
                                                <input name="fecha_fin" type="text" id="dateArrival2"
                                                    style="width:65px; font-size:12px; height:20px"
                                                    size="9" title="fecha final. formato: dd-mm-aaaa" class="tcal" 
                                                    value="<?php echo htmlentities($final, ENT_COMPAT, 'utf-8'); ?>"/> 
											</div>
										</div>
									</div>
                                </div>
								<div style="width:98%;padding:5px 1px 0 0;float:left;border-bottom:1px solid #D5D5D5; display:none;
                                	text-align: left"
                                	id="pa6">&nbsp;
                                    	INDIQUE TRIPLE O TERMINAL:<br/>&nbsp;
                                        <input style="height:30px; width:63px; font-size:26px" name="num_bloqueo" id="num_bloqueo" 
                                        onKeyPress="return validar_numero(event)" type="text" value="" size="3" 
                                        maxlength="3" title=" indique triple o terminal "/>&nbsp;
										<input type="submit" value="Agregar" name="agregar" id="agregar" class="btn btn-primary"
                                        style="font-size:14px; cursor:pointer; height:42px; margin:-10px 0 0 0" 
										title="agregar numero"/>
                                </div>
                          </td>
                            <td width="1%">&nbsp;</td>
                            <td width="55%" valign="top">
                                <table width="100%" border="0" style="font-size:12px;" cellpadding="0" cellspacing="0">
                                    <tr style="font-size:11px;background:#333333;color:#FFF" align="center">
                                        <td width="9%">Numero</td>
                                        <td width="55%">Loteria/Agente/Taquilla</td>
                                        <td width="14%">Desde</td>
                                        <td width="14%">Hasta</td>
                                        <td width="8%">Accion</td>
                                    </tr><?php
                                    if ($totalRows_Recordset3>0&&$row_Recordset6['des_bloqueado']!="") {
                                        do {?>
                                            <tr class="brillo" style="border-bottom:1px solid  #D5D5D5" align="center">
                                                <td align="right" style='font-size:18px;'>
                                                    <?php echo $row_Recordset6['num_bloqueado']."&nbsp;";?>
                                                </td>
                                                <td align="left"><?php
                                                    echo $row_Recordset6['nomloteria'];
                                                    echo "<br/><div style='margin:-8px 0 0 0;font-size:9px;'>";
                                                    echo $row_Recordset6['nomagencia']."/".$row_Recordset6['nomtaquilla']."</div>";?>
                                                </td><?php
                                                if ($row_Recordset6['tip_rango']==2) {?>
													<td style="font-size:11px">
														<?php echo fechanueva($row_Recordset6['des_bloqueado']);?>
                                                    </td>
													<td style="font-size:11px">
													<?php echo fechanueva($row_Recordset6['has_bloqueado']);?>
                                                    </td><?php
                                                } else {
                                                    echo '<td colspan="2">PERMANENTE</td>';
                                                }?>
                                                <td>
													<input type="submit" value="<?php echo $row_Recordset6['id_bloqueado']?>" 
                                                    name="eliminar" id="eliminar" class="btn btn-danger" title="eliminar"
                                        			style="font-size:14px;cursor:pointer;height:10px;width:15px;margin:-2px 0 0 0"/>
                                                </td>
                                            </tr><?php
                                        } while ($row_Recordset6 = mysqli_fetch_assoc($Recordset6));
                                    } else {?>
										<tr class="brillo" style="border-bottom:1px solid  #D5D5D5" align="center">
											<td colspan="5" align="center" height="50" style='font-size:18px;'>
                                               	No existen numeros bloqueados
											</td>
										</tr><?php
                                    }?>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name="cod_banca" value="<?php echo $xCodigo; ?>"/>
                    <input type="hidden" name="MM_insert" value="form1"/>
                </form>
                <table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" height="20">
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <a href='admin_bloqueos_lista_lot.php'
                                class="btn  btn-danger" 
                                style="width:150px; height:40px; font-size:16px; text-decoration:none; color:#FFFFFF">
                                <div style="padding:10px 0px 0px 0px">SALIR</div>
                            </a>
                        </td>
                    </tr>
                </table>
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
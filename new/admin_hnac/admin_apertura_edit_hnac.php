<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCarrera_Recordset1 = "0";
if (isset($_GET["recordID"])) {
    $xCarrera_Recordset1 = $_GET["recordID"];
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\admin_hnac\admin_apertura_edit_hnac.php - QUERY 1 */ SELECT 
		ca.cod_carrera_hnac,
		ca.fec_carrera_hnac,
		ca.hor_carrera_hnac,
		ca.cod_carrera_hnac,
		ca.num_carrera_hnac,
		ca.can_caballos_hnac,
		hi.nom_hipodromo_hnac,
		hi.cod_hipodromo_hnac
		FROM 
			carrera_hnac ca, 
			hipodromo_hnac hi
		WHERE 
			ca.cod_carrera_hnac = %s AND
			ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac",
    GetSQLValueString($xCarrera_Recordset1, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

$query_Recordset2 = sprintf(
    "/* PARSEADORES1 new\admin_hnac\admin_apertura_edit_hnac.php - QUERY 2 */ SELECT 
		ito.cod_inscrito_hnac,
		ito.num_caballo_hnac,
		ito.nom_caballo_hnac,
		ito.est_inscrito_hnac,
		ito.est_favorito_hnac
		FROM 
			inscritos ito 
		WHERE 
			ito.cod_carrera_hnac = %s ORDER BY ito.num_caballo_hnac ASC",
    GetSQLValueString($xCarrera_Recordset1, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$men1="";
$men2="";
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if ($_POST['amopm']=="pm") {
        $_POST['hora']=(int)$_POST['hora']+12;
        if ($_POST['hora']==24) {
            $_POST['hora']=12;
        }
    }
    if ($_POST['amopm']=="am" && $_POST['hora']==12) {
        $_POST['hora']="00";
    }
    $_POST['hor_carrera']=$_POST['hora'].":".$_POST['minutos'].":00";
    $estado=0;
    if ($_POST['num_carrera_actual']!=$_POST['num_carrera']) {
        $estado=compruebaCarr_hnac($_POST['cod_hipodromo'], $_POST['num_carrera'], $_POST['fec_carrera_actual']);
        //echo $_POST['num_carrera_actual']." - ".$_POST['num_carrera']." - ".$_POST['fec_carrera_actual'];
    }
    if ($estado==0) {
        $updateSQL = sprintf(
            "/* PARSEADORES1 new\admin_hnac\admin_apertura_edit_hnac.php - QUERY 3 */ UPDATE carrera_hnac SET 
				hor_carrera_hnac=%s, 
				num_carrera_hnac=%s, 
				can_caballos_hnac=%s, 
				est_carrera_hnac=%s 
				WHERE cod_carrera_hnac=%s",
            GetSQLValueString($_POST['hor_carrera'], "date"),
            GetSQLValueString($_POST['num_carrera'], "int"),
            GetSQLValueString($_POST['can_caballos'], "int"),
            GetSQLValueString("1", "int"),
            GetSQLValueString($_POST['cod_carrera'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        if ($_POST['can_caballos']!=$_POST['caballos']) {
            $query_Recordset3 = sprintf(
                "/* PARSEADORES1 new\admin_hnac\admin_apertura_edit_hnac.php - QUERY 4 */ SELECT 
					ito.cod_inscrito_hnac,
					ito.num_caballo_hnac
					FROM 
						inscritos ito 
					WHERE 
						ito.cod_carrera_hnac = %s ORDER BY ito.num_caballo_hnac ASC",
                GetSQLValueString($_POST['cod_carrera'], "int")
            );
            $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
            $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
            $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
            if ($_POST['can_caballos']>$_POST['caballos']) {//agregar
                for ($x = $totalRows_Recordset3+1;  $x <= $_POST['can_caballos']; $x++) {	//guarda los ejemplares
                    $insertSQL2 = sprintf(
                        "/* PARSEADORES1 new\admin_hnac\admin_apertura_edit_hnac.php - QUERY 5 */ INSERT INTO inscritos 
					(cod_carrera_hnac, 
					num_caballo_hnac, 
					nom_caballo_hnac, 
					nom_jinete_hnac, 
					est_inscrito_hnac) 
					VALUES (%s, %s, %s, %s, %s)",
                        GetSQLValueString($_POST['cod_carrera'], "int"),
                        GetSQLValueString($x, "text"),
                        GetSQLValueString("SIN ASIGNAR", "text"),
                        GetSQLValueString("SIN ASIGNAR", "text"),
                        GetSQLValueString(1, "int")
                    );
                    $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
                }
            }
            if ($_POST['can_caballos']<$_POST['caballos']) {//eliminar
                $deleteSQL = sprintf(
                    "/* PARSEADORES1 new\admin_hnac\admin_apertura_edit_hnac.php - QUERY 6 */ DELETE 
					FROM inscritos 
					WHERE cod_carrera_hnac = %s AND num_caballo_hnac > %s AND num_caballo_hnac <= %s",
                    GetSQLValueString($_POST['cod_carrera'], "int"),
                    GetSQLValueString($_POST['can_caballos'], "int"),
                    GetSQLValueString($_POST['caballos'], "int")
                );
                $Result1 = mysqli_query($conexionbanca, $deleteSQL) or die(mysqli_error($conexionbanca));
            }
        }
        $updateGoTo = "admin_apertura_lista_hnac.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
            $updateGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $updateGoTo));
    } else {
        $men1="CARRERA #".$_POST['num_carrera_actual']." NO MODIFICADA ";
        $men2="YA EXISTE CARRERA ".$_POST['num_carrera'];
    }
}
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
<link href="../modal/css/sweetalert.css" rel="stylesheet">
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
<link rel="stylesheet" href="../modal/css/alertify.min.css" />
<link rel="stylesheet" href="../modal/css/default.min.css" />
<script src="../modal/js/alertify.min.js"></script>    
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<script type="text/javascript">
	function cambiarEst(titulo,pregunta,cod,cab,est,carr,sfav,camb) {
		if (est==0) tipo="info"; else tipo="warning";
		swal({
		  title: titulo,
		  text: pregunta,
		  type: tipo,
		  showCancelButton: true,
		  cancelButtonText: "Cancelar",
		  confirmButtonText: "Aceptar",
		  closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				var rA=Math.random();
				var ptos={"xCod":cod,"xCab":cab,"xEst":est,"xCarr":carr,"xFav":sfav,"xCam":camb,"rA":Math.random()};
				$.ajax({ data:ptos, url:'admin_cambiar_inscrito_hnac.php', type:'post',
					success:function (response) { 
						$("#hipodromo").html(response);
						location.reload();
					}
				});
			} else {
				location.reload();
			}
				 
		});
	}

</script>
<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
					<?php include("../includes/cabecera_hnac.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
              Editar datos<br/>carrera nacional
			</div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin">
<div style="height:100%; font-size:28px; padding:10px 10px 20px 10px; float:right;">
              <a href="../admin_hnac/admin_apertura_lista_hnac.php" class="btn alert-success" 
            	style="font-size:14px;width:140px;height:30px;padding:10px 0px 0px 0px;text-align:center;color:#FFFFFF;
                background: #009;text-decoration:none; " title="ir a listas">
                 Volver a listas
              </a>
	</div>
	<div style="height:100%; padding:80px 10px 20px 10px; text-align:left;font-size:18px;">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onsubmit="return chequearEnvio();">
        <table width="920" align="center" class="lista" border="0" style="font-size:18px; background:#CCCCCC">
          <tr valign="baseline">
            <td colspan="5" height="44" align="center" valign="middle" nowrap="nowrap" bgcolor="#333333"
            style="color:#FFF; font-size:24px; font-weight: bold;">
            	DATOS DE CARRERA NACIONAL
            </td>
          </tr>
		</table>
		<div style="background:#CCCCCC; float:left; width:58%; padding:1%; height:380px;border-bottom-style: solid;
        	border-bottom-width: 1px; border-bottom-color:#000000">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:18px; background:#CCCCCC">
              <tr>
                <td height="40" colspan="3">
					<span style="color:#C00;text-align:center"><?php echo "<strong>".$men1."</strong><br/>".$men2;?></span>
                </td>
              </tr>
              <tr>
                <td width="55%">Nombre de hipódromo:</td>
                <td width="3%">&nbsp;</td>
                <td width="42%">Fecha de carrera:</td>
              </tr>
              <tr>
                <td>
					<input name="nom_hipodromo" type="text" id="nom_hipodromo" 
                    value="<?php echo htmlentities($row_Recordset1['nom_hipodromo_hnac'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="32" readonly="readonly" style="width:300px; font-size:20px; height:30px" />                
                </td>
                <td>&nbsp;</td>
                <td>
					<input name="fec_carrera" type="text" id="fec_carrera" 
                    value="<?php echo htmlentities(fechanueva($row_Recordset1['fec_carrera_hnac']), ENT_COMPAT, 'utf-8'); ?>"
                    size="10" readonly="readonly" style='width:120px; font-size:20px; height:30px'/>                
                </td>
              </tr>
              <tr>
                <td height="34" align="left" valign="bottom">Hora de carrera:</td>
                <td align="left" valign="bottom">&nbsp;</td>
                <td align="left" valign="bottom">Cantidad de Ejemplares:</td>
              </tr>
              <tr>
                <td>
                    <select name="hora" id="hora" style="width:60px; font-size:20px; height:40px">
                        <?php $row_Recordset1['hor_carrera_hnac']=horaampm($row_Recordset1['hor_carrera_hnac']);
                        list($hora, $minutos, $seg)=explode(":", $row_Recordset1['hor_carrera_hnac']);
                        $ampm=substr($seg, 2, 2);
                        for ($i = 1; $i <= 12; $i++) {
                            if ($i<10) {
                                $xh="0".$i;
                            } else {
                                $xh=$i;
                            } ?>
                            <option value="<?php echo $xh; ?>" 
                            <?php if (!(strcmp($xh, htmlentities($hora, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>
                            <?php echo $xh; ?>		
                            </option>
                            <?php
                        }?>
                    </select>
                    <select name="minutos" id="minutos" style="width:60px; font-size:20px; height:40px">
                    <?php
                        for ($i = 0; $i <= 59; $i++) {
                            if ($i<10) {
                                $xm="0".$i;
                            } else {
                                $xm=$i;
                            } ?>
                            <option value="<?php echo $xm; ?>"
                            <?php if (!(strcmp($xm, htmlentities($minutos, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>
                            <?php echo $xm; ?>
                            </option>
                            <?php
                        }?>
                    </select>
                    <select name="amopm" id="amopm" style="width:70px; font-size:20px; height:40px">
                        <option value="am" 
                        <?php if (!(strcmp("am", htmlentities($ampm, ENT_COMPAT, 'utf-8')))) {
                            echo "SELECTED";
                        } ?>>
                        am
                        </option>
                        <option value="pm" 
                        <?php if (!(strcmp("pm", htmlentities($ampm, ENT_COMPAT, 'utf-8')))) {
                            echo "SELECTED";
                        } ?>>
                        pm
                        </option>
                    </select>
                </td>
                <td>&nbsp;</td>
                <td>
                    <select name="can_caballos" id="can_caballos" style="width:60px; font-size:20px; height:40px">
                    <?php
                        $xc=$row_Recordset1['can_caballos_hnac'];
                        for ($i = 1; $i <= 30; $i++) {?>
                            <option value="<?php echo $i ?>" 
                            <?php if (!(strcmp($i, htmlentities($xc, ENT_COMPAT, 'utf-8')))) {
                            echo "SELECTED";
                        } ?>>
                            <?php echo $i ?>
                            </option>
                            <?php
                        }?>
					</select>
                </td>
              </tr>
              <tr>
                <td height="34" align="left" valign="bottom">Número de carrera:</td>
                <td align="left" valign="bottom">&nbsp;</td>
                <td align="left" valign="bottom">&nbsp;</td>
              </tr>
              <tr>
                <td>
                    <select name="num_carrera" id="num_carrera" style="width:60px; font-size:20px; height:40px">
                    <?php
                        $xn=$row_Recordset1['num_carrera_hnac'];
                        for ($i = 1; $i <= 30; $i++) {?>
                        <option value="<?php echo $i ?>" 
                        <?php if (!(strcmp($i, htmlentities($xn, ENT_COMPAT, 'utf-8')))) {
                            echo "SELECTED";
                        } ?>>
                        <?php echo $i ?>
                            </option>
                            <?php
                        }?>
					</select>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
		</div>      
		<div style="background:#CCCCCC; float:left; width:39%; height:380px; padding:1% 0% 1% 1%;border-bottom-style: solid;
        	border-bottom-width: 1px; border-bottom-color:#000000">
			EJEMPLARES:
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px; background:#FFF">
                <tr style="background:#996">
                    <td width="5%" align="center">N°</td>
                    <td width="54%" align="left">NOMBRE DE EJEMPLAR</td>
                    <td width="9%" align="center" style="font-size:10px">FAV1</td>
                    <td width="9%" align="center" style="font-size:10px">FAV2</td>
                    <td width="8%" align="center" style="font-size:10px">FAV3</td>
                    <td width="15%" align="left" style="font-size:10px">&nbsp;RET</td>
                </tr>
			</table>
		  <div style="width:100%;height:92%;overflow:scroll; font-size:14px">
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; background:#FFF">
					<?php
                    $n=0;
                    do {
                        $tit1="#".$row_Recordset2['num_caballo_hnac']." ".$row_Recordset2['nom_caballo_hnac'];
                        if ($n%2==0) {?>
                        <tr height="28">
                        <?php } else {?>
                        <tr height="28" style="background:#999">
                        <?php } ?>
                            <td width="5%" align="right"><?php echo $row_Recordset2['num_caballo_hnac']; ?>&nbsp;</td>
                            <td width="57%" align="left" valign="middle">
                            <input type="text" name="nom_caballo_hnac" id="nom_caballo_hnac"
                            maxlength="25" 
                            <?php if ($n%2==0) {
                            echo
                            'style="height:10px; background:#FFFFFF; padding:13px 0px 0px 0px; border:none; width:200px "';
                        } else {
                            echo
                            'style="height:10px; background:#999999; padding:13px 0px 0px 0px; border:none; width:200px"';
                        } ?>
                            value="<?php echo htmlentities($row_Recordset2['nom_caballo_hnac'], ENT_COMPAT, 'utf-8'); ?>"/>                            </td>
							<?php
                            if ($row_Recordset2['est_inscrito_hnac']==1) {?>                            
                            	<td width="9%" align="center" style="font-size:10px">
                            	<?php
                                    if ($row_Recordset2['est_favorito_hnac']==0) {
                                        $tit21="¿ESTABLECE EJEMPLAR COMO 1er FAVORITO?";
                                        $f=1;
                                    } else {
                                        if ($row_Recordset2['est_favorito_hnac']!=0&&$row_Recordset2['est_favorito_hnac']!=1) {
                                            $tit21="¿CAMBIAR EJEMPLAR A 1er FAVORITO?";
                                            $f=1;
                                        } else {
                                            $tit21="¿QUITAR EJEMPLAR COMO 1er FAVORITO?";
                                            $f=0;
                                        }
                                    }?>
									<input type="checkbox" name="est_fav1<?php echo $row_Recordset2['num_caballo_hnac']; ?>" 
									<?php
                                    if (!(strcmp(htmlentities($row_Recordset2['est_favorito_hnac'], ENT_COMPAT, 'utf-8'), "1"))) {
                                        echo "checked=\"checked\"";
                                    } ?> value="" style="height:auto" title="1er favorito"
									onclick="cambiarEst('<?php echo $tit1; ?>','<?php echo $tit21; ?>',
									'<?php echo $row_Recordset2['cod_inscrito_hnac']; ?>',
									'<?php echo $row_Recordset2['num_caballo_hnac']; ?>',
									'<?php echo $row_Recordset2['est_favorito_hnac']; ?>', 
									'<?php echo $row_Recordset1['cod_carrera_hnac']; ?>','1',<?php echo $f; ?>)"
									id="est_fav1<?php echo $row_Recordset2['num_caballo_hnac']; ?>"
									<?php if ($row_Recordset2['est_inscrito_hnac']==0) {
                                        echo "disabled='disabled'";
                                    } ?>/>
                                </td>
                                <td width="9%" align="center" style="font-size:10px">
                                    <?php
                                    if ($row_Recordset2['est_favorito_hnac']==0) {
                                        $tit22="¿ESTABLECE EJEMPLAR COMO 2do FAVORITO?";
                                        $g=2;
                                    } else {
                                        if ($row_Recordset2['est_favorito_hnac']!=0&&$row_Recordset2['est_favorito_hnac']!=2) {
                                            $tit22="¿CAMBIAR EJEMPLAR A 2do FAVORITO?";
                                            $g=2;
                                        } else {
                                            $tit22="¿QUITAR EJEMPLAR COMO 2do FAVORITO?";
                                            $g=0;
                                        }
                                    }?>
                                    <input type="checkbox" name="est_fav2<?php echo $row_Recordset2['num_caballo_hnac']; ?>" 
                                    <?php
                                    if (!(strcmp(htmlentities($row_Recordset2['est_favorito_hnac'], ENT_COMPAT, 'utf-8'), "2"))) {
                                        echo "checked=\"checked\"";
                                    } ?> value="" style="height:auto" title="2do favorito"
                                    onclick="cambiarEst('<?php echo $tit1; ?>','<?php echo $tit22; ?>',
                                    '<?php echo $row_Recordset2['cod_inscrito_hnac']; ?>',
                                    '<?php echo $row_Recordset2['num_caballo_hnac']; ?>', 
                                    '<?php echo $row_Recordset2['est_favorito_hnac']; ?>', 
                                    '<?php echo $row_Recordset1['cod_carrera_hnac']; ?>','2',<?php echo $g; ?>)"
                                    id="est_fav2<?php echo $row_Recordset2['num_caballo_hnac']; ?>"
                                    <?php if ($row_Recordset2['est_inscrito_hnac']==0) {
                                        echo "disabled='disabled'";
                                    } ?>/>
                                </td>
                                <td width="9%" align="center" style="font-size:10px">
                                    <?php
                                    if ($row_Recordset2['est_favorito_hnac']==0) {
                                        $tit23="¿ESTABLECE EJEMPLAR COMO 3er FAVORITO?";
                                        $h=3;
                                    } else {
                                        if ($row_Recordset2['est_favorito_hnac']!=0&&$row_Recordset2['est_favorito_hnac']!=3) {
                                            $tit23="¿CAMBIAR EJEMPLAR A 3er FAVORITO?";
                                            $h=3;
                                        } else {
                                            $tit23="¿QUITAR EJEMPLAR COMO 3er FAVORITO?";
                                            $h=0;
                                        }
                                    }?>
                                    <input type="checkbox" name="est_fav3<?php echo $row_Recordset2['num_caballo_hnac']; ?>" 
                                    <?php
                                    if (!(strcmp(htmlentities($row_Recordset2['est_favorito_hnac'], ENT_COMPAT, 'utf-8'), "3"))) {
                                        echo "checked=\"checked\"";
                                    } ?> value="" style="height:auto;" title="3er favorito"
                                    onclick="cambiarEst('<?php echo $tit1; ?>','<?php echo $tit23; ?>',
                                    '<?php echo $row_Recordset2['cod_inscrito_hnac']; ?>',
                                    '<?php echo $row_Recordset2['num_caballo_hnac']; ?>', 
                                    '<?php echo $row_Recordset2['est_favorito_hnac']; ?>', 
                                    '<?php echo $row_Recordset1['cod_carrera_hnac']; ?>','3',<?php echo $h; ?>)"
                                    id="est_fav3<?php echo $row_Recordset2['num_caballo_hnac']; ?>"
                                    <?php if ($row_Recordset2['est_inscrito_hnac']==0) {
                                        echo "disabled='disabled'";
                                    } ?>/>
                                </td>
							<?php } else {?>
                            <td colspan="3" align="center" style="font-size:12px; background:#900; color:#FFF">RETIRADO</td>
                            <?php } ?>
                            <td width="11%" align="center" style="font-size:10px">
                            	<?php
                                if ($row_Recordset2['est_inscrito_hnac']==1) {
                                    $tit2="¿RETIRAR DE LA CARRERA A EJEMPLAR?";
                                    $tit="clic para retirar";
                                    $i=0;
                                } else {
                                    $tit="clic para reintegrar";
                                    $i=1;
                                    $tit2="¿RETIGRAR EJEMPLAR A LA CARRERA?";
                                } ?>
                                <input type="checkbox" name="est_ret<?php echo $row_Recordset2['num_caballo_hnac']; ?>" 
                                <?php if (!(strcmp(htmlentities($row_Recordset2['est_inscrito_hnac'], ENT_COMPAT, 'utf-8'), "0"))) {
                                    echo "checked=\"checked\"";
                                } ?> value="" style="height:auto" title="<?php echo $tit; ?>"
                                onclick="cambiarEst('<?php echo $tit1; ?>','<?php echo $tit2; ?>',
                                '<?php echo $row_Recordset2['cod_inscrito_hnac']; ?>',
                                '<?php echo $row_Recordset2['num_caballo_hnac']; ?>', 
                                '<?php echo $row_Recordset2['est_inscrito_hnac']; ?>', 
                                '<?php echo $row_Recordset1['cod_carrera_hnac']; ?>','0',<?php echo $i; ?>)"
                                id="est_ret<?php echo $row_Recordset2['num_caballo_hnac']; ?>"/>
						</td>
                        </tr>
                        <?php
                        $n++;
                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));?>
			  </table>
			</div>      
		</div> 

<?php /* ?>        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#CCC">
          <tr>
            <td width="45%" height="76" align="right" valign="bottom">
                <button type="submit" class="btn-success" title="actualizar datos"
                style="width:210px; height:50px; font-size:16px; background: #060;"/>ACTUALIZAR CARRERA</button>
            </td>
            <td width="10%" valign="bottom">&nbsp;</td>
            <td width="45%" align="left" valign="bottom">
                <button onclick="window.location.href='admin_apertura_lista_hnac.php'" class="btn-danger"
                title="cancelar edición"
                style="width:210px; height:50px; font-size:16px; background: #900;"/>CANCELAR</button>
            </td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
        </table>
<?php */ ?>

        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="num_carrera_actual" value="<?php echo $row_Recordset1['num_carrera_hnac']; ?>" />
        <input type="hidden" name="caballos" value="<?php echo $row_Recordset1['can_caballos_hnac']; ?>" />
        <input type="hidden" name="fec_carrera_actual" value="<?php echo $row_Recordset1['fec_carrera_hnac']; ?>" />
        <input type="hidden" name="cod_hipodromo" value="<?php echo $row_Recordset1['cod_hipodromo_hnac']; ?>" />
        <input type="hidden" name="cod_carrera" value="<?php echo $row_Recordset1['cod_carrera_hnac']; ?>" />
      </form>
    </div>
      <div id="hipodromo" name="hipodromo" class="hipodromo" style="background: #FC3"></div>
  </div>
  <div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
<script src="../modal/js/bootstrap.min.js"></script>
<script src="../modal/js/functions.js"></script>
<script src="../modal/js/sweetalert.min.js"></script>  
</body>
</html>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($Recordset2);
?>
<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
set_time_limit(0);
$inicio=fechanueva(fechaactualbd());
$in=fechaymd($inicio);
$codigoAgente=$_SESSION['MM_cod_agente'];
$editFormAction = $_SERVER['PHP_SELF'];
$taquil=-1;
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset4 = sprintf("/* PARSEADORES1 new\agente_hnac\agente_reporte_venta_carrera_hnac.php - QUERY 1 */ SELECT cod_banca FROM agencia 
	WHERE cod_agencia = %s LIMIT 1", GetSQLValueString($codigoAgente, "int"));
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$banca=$row_Recordset4['cod_banca'];
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if (isset($_POST['fecha_inicio'])) {
        if ($_POST['fecha_inicio']!="") {
            $in=fechaymd($_POST['fecha_inicio']);
            $inicio=$_POST['fecha_inicio'];
            $taquil=$_POST['id_taquilla'];
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_reporte_venta_carrera_hnac.php - QUERY 2 */ SELECT *
			FROM 
				carrera_hnac,
				hipodromo_hnac
			WHERE 
				carrera_hnac.fec_carrera_hnac = %s AND
				carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac
			ORDER BY carrera_hnac.num_carrera_hnac",
                GetSQLValueString($in, "date")
            );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        }
    }
} else {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\agente_hnac\agente_reporte_venta_carrera_hnac.php - QUERY 3 */ SELECT *
	FROM 
		carrera_hnac,
		hipodromo_hnac
	WHERE 
		carrera_hnac.fec_carrera_hnac = %s AND
		carrera_hnac.cod_hipodromo_hnac = hipodromo_hnac.cod_hipodromo_hnac
	ORDER BY carrera_hnac.num_carrera_hnac",
        GetSQLValueString($in, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
}
$query_Recordset2 = sprintf("/* PARSEADORES1 new\agente_hnac\agente_reporte_venta_carrera_hnac.php - QUERY 4 */ SELECT * FROM taquilla 
	WHERE taquilla.cod_agencia = %s ORDER BY taquilla.nom_taquilla", GetSQLValueString($codigoAgente, "int"));
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#9FBFD7" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
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
 $(document).ready(function() { 
	 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
	 var refreshId1 = setInterval(function() {
	 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
	 }, 60000);
});
function ver(codCarrera,numCarrera) {
	//alert(document.getElementById("soflow").value);
	if (document.getElementById("soflow").value!=-1) {
		var mError1 = "<br/><i class='fa  fa-exclamation-triangle fa-3x pull-left;' style='text-align:center'></i><br/>";
		var mError2 = "<br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/><h2>Verifique su conexión a internet<h2/>";
		var parametros1 = { "codCarrera":codCarrera, "numCarrera":numCarrera, "codTaquilla":document.getElementById("soflow").value, "fecCarrera":document.getElementById("fecha_inicio").value};
		$.ajax({ data:parametros1, url:'agente_ver_carrera.php', type:'post',
			beforeSend: function() {
				var espera1='<i class="fa fa-spinner fa-spin fa-3x"></i><br/>';
				var espera2='Generando Reporte<br/><br/>Por favor espere un momento...';
				$("#infoVer").html(espera1+espera2);
			},                   
			success: function(response) {                    
				$("#vista").html(response);
			},
			error: function(){ 
				$("#infoVer").html(mError1+mError2);
			}    
		});
	} else alert("Seleccione una taquilla por favor!");
}
function habil() { document.getElementById('divBuscar').style.display = 'block';}
function desha() { document.getElementById('divBuscar').style.display = 'none'; }
</script>
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
	<div class="header" style="height:100px; background:#0E5157">
		<?php include("../includes/cabeceraamericana_ag.php");?>
		<div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
            <div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
            <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                position:absolute;border-radius: 0px 0px 5px 5px;">
                <?php include("../includes/cabeceraagente_hnac.php");?>
            </div>
		</div> <!-- end .menu -->
	</div> <!-- end .header -->
	<div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
		<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
			<?php echo "AGENTE: ".$_SESSION['MM_nom_agente'] ?><br/>
		</div>
		Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
		<span id="reloj"></span>
	</div>
	<div class="contentAdmin">
		<div style="height:100%; font-size:26px; padding:50px 0px 100px 0px ">
			<div style="background:#0E5157; width:100%; float:left; padding:40px 2px 10px 2px;
				color:#FFF; font-size:28px; text-align:center">
				REPORTE DE VENTAS POR CARRERAS
			</div><!-- end .container -->
            
            
  
			<div id="seleccion" style="background: #FFF; width:35%; float:left; height:auto; margin:10px 0px 0px 0px;
            	padding:0px 0px 10px px;">
            	<div id="info" style="background: #9b59b6; width:100%; float:left; height:25px; border:1px solid #9b59b6;
                	padding:10px 0px 0px 2px; text-align:left; font-size:18px; color:#FFFFFF">
                	&nbsp;Selección:
                </div>
                <div id="datos" style="background: #FFF; width:97%; float:left; height:30%; font-size:20px; text-align:left;
                	border-left: 1px solid #E4CAFF; border-right: 1px solid #E4CAFF; border-bottom: 1px solid #E4CAFF; 
                    padding:10px 0px 0px 10px">
                    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                        onsubmit="return chequearEnvio();">
                        Fecha:<br/>
                        <input name="fecha_inicio" type="text" tabindex="1" class="tcal" id="fecha_inicio"
                            style="width:100px; font-size:16px; height:30px" onblur="habil()"
                            title="fecha inicio. formato: dd-mm-aaaa" 
                            value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"/>
                        <?php if ($totalRows_Recordset1<=0) {?>    
                        <div style="width:80px; height:40px; float:right; padding:0px 38px 0px 0px" id="divBuscar">
                        <?php } else {?>
                        <div style="width:80px; height:40px; float:right; padding:0px 38px 0px 0px; display:none" id="divBuscar">
                        <?php }?>    
                        <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 			style="width:80px; height:40px" id="Botbuscar"/>
                        </div>    
                        <br/>
                        <?php
                        if ($totalRows_Recordset1>0) {?>
                            Taquilla:<br/>
                            <select name="id_taquilla" id="soflow" style="height:40px; width:280px; margin:0px 0px 0px 0px"
                                onchange="desha()">
                                <option value="-1" <?php if ($taquil=="-1") {
                            echo "SELECTED";
                        } ?>>SELECCIONE TAQUILLA</option>
                                <?php
                                do {?>  
                                    <option value="<?php echo $row_Recordset2['cod_taquilla']?>"
                                    <?php if ($row_Recordset2['cod_taquilla']==$taquil) {
                                    echo "SELECTED";
                                } ?>>
                                    <?php echo strtoupper($row_Recordset2['nom_taquilla']);?>
                                    </option>
                                    <?php
                                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));?>
                            </select>
                        <?php } else {?> <input type="hidden" name="id_taquilla" value="-1" /> <?php }?>
                        <input type="hidden" name="MM_update" value="form1" />
                        <input type="hidden" name="canRegistro" value="<?php echo $totalRows_Recordset1;?>" />
                    </form>
                </div>
            	<div id="infocarreras" style="background: #000; width:100%; float:left; height:30%; 
                	border-left: 1px solid #E4CAFF; border-right: 1px solid #E4CAFF; border-bottom: 1px solid #E4CAFF;
                    text-align:left">
                    <div id="hipodromo" style="background: #9b59b6; width:100%; float:left; height:25px; border:2px solid #9b59b6;
                        text-align:left; font-size:18px; color:#FFFFFF; padding:10px 0px 0px 0px;">
						<?php
                        if ($totalRows_Recordset1>0) {
                            echo "&nbsp;".$row_Recordset1['nom_hipodromo_hnac'].":";
                        }?>                        
                    </div>
					<div id="carreras" style="background: #FFFFFF; width:97%; float:left; height:auto; border:1px solid #E4CAFF;
                        text-align:left; font-size:18px; color:#FFFFFF; padding:10px 0px 0px 10px;">
                        <?php
                        if ($totalRows_Recordset1>0) {
                            do {?>				
                            <a href="#" class="btn btn-lg btn-warning" id="botVer<?php echo $row_Recordset1['cod_carrera_hnac']; ?>"
                                style="width:90%; text-align:left; text-decoration:none; color:#000000; font-size:7px;
                                margin:0px 0px 10px 0px; background:#CCC" 
                                onClick="ver('<?php echo $row_Recordset1['cod_carrera_hnac']; ?>',
                                			 '<?php echo $row_Recordset1['num_carrera_hnac']; ?>');">
                                <i class="fa fa-search fa-2x pull-left">
                                    <?php
                                    echo "&nbsp;Carrera:...#".$row_Recordset1['num_carrera_hnac'];
                                    ?>
                                </i>
                            </a>
                        	<?php
                            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                        }?>                        
                    </div>                       
                </div>
                
            </div><!-- end .seleccion -->
			<div id="vista" style="background: #FFF; width:63%; float: right; height:600px; margin:10px 0px 10px 10px;
            	border-left: 1px solid #E1E1E1; border-right: 1px solid #E1E1E1; border-bottom: 1px solid #E1E1E1;
                padding:0px 0px 0px 0px;">
            	<div id="info" style="background:#333; width:99%; float: right; height:25px; border:1px solid #333;
                	text-align:center; font-size:18px; color:#FFFFFF; padding:10px 0px 0px 4px">
                	DATOS DE CARRERA
                </div>
                <div id="infoVer" style="padding:140px 0px 0px 20px;color:#CCC; text-align:center">
               
                	
					<?php
                    if ($totalRows_Recordset1>0) {?>
                    	<i class="fa fa-info-circle fa-3x pull-left;" style="text-align:center"></i><br/>
	                    1 - Seleccione una taquilla<br/><br/>
                        2 - Click sobre carrera
                    	<?php
                    } else {
                        echo "<i class='fa  fa-exclamation-triangle fa-3x pull-left;' style='text-align:center'></i><br/>";
                        echo "No existen carreras para este día";
                    }?>    
                </div>
			</div><!-- end .vista -->
		</div>
	</div>
	<div class="footer" style="background:#0E5157">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
</div><!-- end .container -->
</body>
</html>
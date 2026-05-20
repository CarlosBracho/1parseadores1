<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$cod_banca=$_SESSION['MM_cod_agente'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}
$xagencia="TODAS";
$vendedor="";
$xhipodromo="SELECCIONE";
$cambioCarrera=0;
$codHipodromo=-1;
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    if ((!isset($_POST['fecha_inicio']) or $_POST['fecha_inicio']=="")) {
        $_POST['fecha_inicio']=$inicio;
    }
    $in=fechaymd($_POST['fecha_inicio']);
    $inicio=$_POST['fecha_inicio'];
    if ($_POST['id_carrera']=="-1" && $_POST['id_hipod']>0) {
        $_POST['id_carrera']="todas";
    }
    if ($_POST['id_hipod']!="-1") {
        if ($_POST['id_hipod']!="-1" && $_POST['id_carrera']=="todas") {
            $query_Recordset4 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_reporte_carrera_carrera_hnac.php - QUERY 1 */ SELECT 
				nom_hipodromo_hnac
			FROM hipodromo_hnac
			WHERE cod_hipodromo_hnac = %s",
                GetSQLValueString($_POST['id_hipod'], "int")
            );
            $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
            $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
            $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
            $xhipodromo=strtoupper($row_Recordset4['nom_hipodromo_hnac']);
            $codcarrera="todas";
            $num_carrera="&nbsp;TODAS";
        } else {
            $query_Recordset4 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_reporte_carrera_carrera_hnac.php - QUERY 2 */ SELECT 
				ca.cod_carrera_hnac, 
				hi.nom_hipodromo_hnac, 
				ca.num_carrera_hnac
			FROM 
				carrera_hnac ca, 
				hipodromo_hnac hi
			WHERE 
				ca.fec_carrera_hnac = %s AND 
				ca.cod_carrera_hnac = %s AND 
				ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac",
                GetSQLValueString($in, "date"),
                GetSQLValueString($_POST['id_carrera'], "int")
            );
            $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
            $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
            $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
            $xhipodromo=strtoupper($row_Recordset4['nom_hipodromo_hnac']);
            $codcarrera=$row_Recordset4['cod_carrera_hnac'];
            $num_carrera=$row_Recordset4['num_carrera_hnac'];
        }
        $query_Recordset6 = sprintf(
            "/* PARSEADORES1 new\agente_hnac\agente_reporte_carrera_carrera_hnac.php - QUERY 3 */ SELECT 
			hi.nom_hipodromo_hnac, hi.cod_hipodromo_hnac, ca.cod_carrera_hnac, ca.num_carrera_hnac
		FROM 
			carrera_hnac ca,
			hipodromo_hnac hi
		WHERE 	
			ca.fec_carrera_hnac = %s AND
			ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac AND
			hi.cod_hipodromo_hnac = %s
		ORDER BY 
			hi.nom_hipodromo_hnac ASC",
            GetSQLValueString($in, "date"),
            GetSQLValueString($_POST['id_hipod'], "int")
        );
        $Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
        $row_Recordset6 = mysqli_fetch_assoc($Recordset6);
        $totalRows_Recordset6 = mysqli_num_rows($Recordset6);
        $vendedor="TAQUILLA: TODAS";
        $cambioCarrera=1;
        $codagencia="todos";
        if ($_POST['id_agente']!="todos") {
            $query_Recordset5 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_reporte_carrera_carrera_hnac.php - QUERY 4 */ SELECT nom_taquilla, cod_taquilla FROM taquilla WHERE cod_taquilla = %s",
                GetSQLValueString($_POST['id_agente'], "int")
            );
            $Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
            $row_Recordset5 = mysqli_fetch_assoc($Recordset5);
            $totalRows_Recordset5 = mysqli_num_rows($Recordset5);
            $xagencia=strtoupper($row_Recordset5['nom_taquilla']);
            $codagencia=strtoupper($row_Recordset5['cod_taquilla']);
            $vendedor="TAQUILLA: ".strtoupper($xagencia);
        }
        $vendedor=$vendedor." / ".strtoupper($row_Recordset4['nom_hipodromo_hnac'])." Carr#".$num_carrera;
        $codHipodromo=$_POST['id_hipod'];
    }
}
$query_Recordset2 = sprintf(
    "/* PARSEADORES1 new\agente_hnac\agente_reporte_carrera_carrera_hnac.php - QUERY 5 */ SELECT 
	ag.nom_agencia,
	ta.cod_taquilla,
	ta.nom_taquilla 
	FROM 
		agencia ag,
		taquilla ta
	WHERE
		ag.cod_agencia = %s AND
		ta.cod_agencia = ag.cod_agencia	 
	ORDER BY 
		ta.nom_taquilla ASC, ag.nom_agencia ASC",
    GetSQLValueString($cod_banca, "int")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 new\agente_hnac\agente_reporte_carrera_carrera_hnac.php - QUERY 6 */ SELECT 
		hi.nom_hipodromo_hnac, hi.cod_hipodromo_hnac
	FROM 
		carrera_hnac ca,
		hipodromo_hnac hi
	WHERE 	
		ca.fec_carrera_hnac = %s AND
		ca.cod_hipodromo_hnac = hi.cod_hipodromo_hnac
	GROUP BY
		hi.nom_hipodromo_hnac	
	ORDER BY 
		hi.nom_hipodromo_hnac ASC",
    GetSQLValueString($in, "date")
);
$Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>

<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#FC6" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="shortcut icon" href="../images/favicon.ico">
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<link rel="stylesheet" href="../css/zebra_datepicker.css" type="text/css">
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<style>.boton-top{display:none;position:fixed;bottom:0;right:0;width:40px;height:40px;text-align:center;line-height:40px;color:#fff;background:#F93;cursor:pointer;font-size:18px;}</style>
<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
<script language="javascript">
	var refreshIntervalId; 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#F93"; celda.style.color="#FFFFFF"; 
	celda.style.fontWeight="bold";}  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF"; celda.style.color="#000000";
	celda.style.fontWeight="normal";} 
	function clearVar() {
		$('#refrescar').bootstrapToggle('off');
		$('#refrescar').bootstrapToggle('disable');
		$("#reporte").html('');
		$("#vendedor").html('');
		$("#fecha").html('');
	}
	function ver2() {
		clearVar();
		var parametros1 = { "fecCarrera":document.getElementById("datepickeri").value};
		$.ajax({ data:parametros1, url:'../admin_hnac/filt_carrera_fecha_hnac.php', type:'post',
			success: function(opciones) {                    
				$("#id_hipod").html(opciones);
				var parametros = { "cod_hipodromo":$("#id_hipod").val(),"fecCarrera":document.getElementById("datepickeri").value};
				$.ajax({ url:"../admin_hnac/filt_carrera_hipodromo_hnac.php", type: "POST", data:parametros,
					success: function(opciones){ $("#nrocarrera").html(opciones); }
				});
				
			}   
		});
	}
	function verInfo() {
		var parametros1 = { 
			"codCar":document.getElementById("nrocarrera").value, 
			"codAge":document.getElementById("id_agente").value,
			"codBan":document.getElementById("cod_banca").value,
			"fecCar":document.getElementById("datepickeri").value,
			"codHipodromo":document.getElementById("id_hipod").value};
		$.ajax({ data:parametros1, url:'agente_reca_carrera_carrera_hnac.php', type:'post',
			beforeSend: function() {
				var espera1='<div style="text-align:center;width:100%;padding:10% 0 0 0"><i class="fa fa-spinner fa-spin fa-3x"></i>';
				var espera2='<br/>Cargando Reporte<br/>Por favor espere un momento...</div>';
				$("#reporte").html(espera1+espera2);
			},                   
			success: function(opciones) {                    
				$("#reporte").html(opciones);
			}   
		});
	}
</script>

<script type="text/javascript">
$(document).ready(function(){
	$('#refrescar').bootstrapToggle('off');
	$("#id_hipod").change(function(){
		clearVar();
		var parametros = { "cod_hipodromo":$("#id_hipod").val(), "fecCarrera":document.getElementById("datepickeri").value};
		$.ajax({ url:"../admin_hnac/filt_carrera_hipodromo_hnac.php", type: "POST", data:parametros,
			success: function(opciones){ $("#nrocarrera").html(opciones);}
		});
	});	
	$("#refrescar").change(function(){
		if ($(this).prop('checked')==true) refreshIntervalId = setInterval("verInfo()", 7000);
		if ($(this).prop('checked')==false) clearInterval(refreshIntervalId);
	});
	$("#nrocarrera").change(function(){
		clearVar();
	});		
});
</script>
<style>.toggle.android { border-radius: 0px;} .toggle.android .toggle-handle {border-radius: 0px;}</style>
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
		Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
		<span id="reloj"></span>
	</div>
    <div class="contentAdmin">
		<div style="background:#0E5157;width:99.6%;float:left;padding:15px 2px 10px 2px;color:#FFF;font-size:28px;text-align:center; 
			font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
			REPORTE CARRERA POR CARRERA NACIONALES
		</div><!-- end .container -->
        <div style="height:100%; font-size:18px; padding:50px 0 0 0; text-align:left" class="xfirefox">
			<div style="background: #FFF; width:100%; float:left; padding:5px 0px 0px 0px;color:#000;font-size:20px;text-align:left; 
                font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif;">
				<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td width="22%" align="left" valign="bottom">
                      Fecha:<br/>
                        <input name="fecha_inicio" id="datepickeri" onchange="ver2()" 
                        type="text" value="<?php echo htmlentities($inicio, ENT_COMPAT, 'utf-8'); ?>"
                        style="width:auto; font-size:16px; height:30px;" title="haga clic para seleccionar fecha">
                      </td>
                      <td width="32%" align="left" valign="bottom">
                        Taquillas:<br/>
                        <select name="id_agente" id="id_agente" style="height:40px; font-size:16px; width:99%;"
                        	onchange="clearVar(),form1.submit()">
                              <option value="todos" <?php if ($row_Recordset2['nom_taquilla']==$xagencia) {
    echo "SELECTED";
} ?>>
                              TODAS
                              </option>
                              <?php
                        do {
                            ?>
                       <option value="<?php echo $row_Recordset2['cod_taquilla']?>"
                            <?php if ($row_Recordset2['nom_taquilla']==$xagencia) {
                                echo "SELECTED";
                            } ?>>
                            <?php echo strtoupper($row_Recordset2['nom_taquilla']); ?>
                       </option>
                              <?php
                        } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                        ?>
                        </select>
                      </td>
                      <td width="30%" align="left" valign="bottom">
                      
                        Hipodromo:<br/>
                        <?php
                        if ($totalRows_Recordset3>0) {?>
                            <select name="id_hipod" id="id_hipod" style="height:40px; font-size:16px; width:99%" onchange="form1.submit()">
                                  <option value="-1">
                                  SELECCIONE
                                  </option>
                                  <?php
                            do {
                                ?>
                           <option value="<?php echo $row_Recordset3['cod_hipodromo_hnac']?>"
								<?php if ($row_Recordset3['nom_hipodromo_hnac']==$xhipodromo) {
                                    echo "SELECTED";
                                } ?>>
                                <?php echo strtoupper($row_Recordset3['nom_hipodromo_hnac'])?>
                           </option>
                                  <?php
                            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
                            ?>
                            </select><?php
                        } else {?>
                            <select name="id_hipod" id="id_hipod" style="height:40px; font-size:16px; width:99%" onchange="form1.submit()">
                                <option value="-1"> NO EXISTEN CARRERAS</option>
                            </select>
                            <script>$(document).ready(function(){clearVar();});</script><?php
                        }?>
                      </td>
                      <td width="16%" align="left" valign="bottom">
                      Carrera:<br/><?php
                      if ($cambioCarrera==0) {?>
                          <select id="nrocarrera" name="id_carrera" style="height:40px; width:99%; font-size:16px" onchange="form1.submit()">
                          <option value="-1"> ----------------</option></select>
                      <?php } else {?>
                            <select id="nrocarrera" name="id_carrera" style="height:40px; width:99%; font-size:16px" onchange="form1.submit()">
                           <option value="todas" <?php if ($row_Recordset6['cod_carrera_hnac']==$codcarrera) {
                          echo "SELECTED";
                      } ?>>
                                <?php echo "TODAS"?>
                           </option>
				    <?php
                            do {?>
                           <option value="<?php echo $row_Recordset6['cod_carrera_hnac'];?>"
								<?php if ($row_Recordset6['cod_carrera_hnac']==$codcarrera) {
                                echo "SELECTED";
                            } ?>>
                                <?php echo $row_Recordset6['num_carrera_hnac']?>
                           </option>
                                  <?php
                            } while ($row_Recordset6 = mysqli_fetch_assoc($Recordset6));?>
                            </select>
                      <?php }?>    
                      </td>
                    </tr>
                  </tbody>
                </table>
                <input type="hidden" name="cod_banca" id="cod_banca" value="<?php echo $cod_banca;?>" />
                <input type="hidden" name="MM_update" value="form1" />
				</form>  
			</div><!-- end .container -->
		  <div id="gener" style="width:100%; float:left; height:750px">
				<div style="background: #333; width:97.3%; float:left; padding:12px 13px 12px 12px;color:#FFF;font-size:18px;
                	font-family: 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif; 
                    height:20px">
					<span style="float:left;" id="vendedor"><?php echo $vendedor; ?></span>
					<span style="float:right;" id="fecha">FECHA: <?php echo $inicio; ?></span><br/>
					<span style="float:left;color:#333;background:#FFF; width:80.9%" id="monto">
                    </span>
				</div>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tbody>
                        <tr style="font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif; background:#099; color:#FFF; font-size:14px; text-align:center ">
                          <td width="4%" height="53" valign="bottom">&nbsp;</td>
                          <td width="10%" align="right" valign="bottom">EJEMPLAR</td>
                          <td width="22%" valign="bottom">APUESTAS</td>
                          <td width="22%" valign="bottom">POR PAGAR</td>
                          <td width="22%" valign="bottom">PAGADO</td>
                          <td width="20%" align="center" valign="middle" bgcolor="#333333">
                          <div style="font-size:36px">
                          <input id="refrescar" type="checkbox" checked data-toggle="toggle" data-onstyle="success" 
                          	data-offstyle="danger" data-width="150" data-height="25"
                          	data-off='<font size="4">RECARGAR OFF</font>' data-on='<font size="4">RECARGAR ON</font>'>
                          </div>   
                          </td>
                        </tr>
					</tbody>
				</table>
                <div id="reporte" style="width:100%; float:left; height:400px">
					<?php include("agente_reca_carrera_carrera_hnac.php"); ?>
                </div>
			</div>
        </div>
        
		<div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
	</div>  
</div>
<span class="boton-top" title="ir arriba">▲</span>
<link href="../css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../js/bootstrap-toggle.min.js"></script>
<script src="../modal/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/zebra_datepicker.src.js"></script>
<script type="text/javascript">$(document).ready(function(){$('#datepickeri').Zebra_DatePicker({onClose:function() {ver2();}});});</script>
</body>
</html>
<?php
if (isset($Recordset1)) {
                                mysqli_free_result($Recordset1);
                            }
?>
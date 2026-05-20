<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
$mError="";
$cAge=-1;
$cCar="todas";
$cTaq=-1;
$cTaq="todas";
$cCab=-1;
$codigoAgente=$_SESSION['MM_cod_agente'];
$hor=horaactual();
$fec=fechaactualbd();
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1") {
    $fec=fechaactualbd();
    $graba=30;
    $cAge=$_POST["cod_agencia"];
    if (isset($_POST["guarda"])) {
        if ($_POST["cod_carrera"]==-1) {
            $graba--;
            $mError="&nbsp;*Seleccione una carrera&nbsp;<br/>";
        }
        if ($_POST["cod_ejemplar"]==-1) {
            $graba--;
            $mError=$mError."&nbsp;*Indique ejempar&nbsp;<br/>";
        }
        if ($_POST["prFij"]<=0) {
            $graba--;
            $mError=$mError."&nbsp;*Indique Precio fijo&nbsp;<br/>";
        }
        if (isset($_POST["guarda"]) && $graba==30) {
            if ($_POST["cod_taquilla"]!="todas") {
                $query_Recordset13 = sprintf(
                    "/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 1 */ SELECT
				ta.cod_taquilla
				FROM taquilla ta, taquilla_opc_hnac tp
				WHERE
					ta.cod_taquilla = %s AND
					tp.cod_taquilla = ta.cod_taquilla AND
					ta.cod_agencia = %s
				LIMIT 1	",
                    GetSQLValueString($_POST["cod_taquilla"], "int"),
                    GetSQLValueString($_POST["cod_agencia"], "int")
                );
            } else {
                $query_Recordset13 = sprintf(
                    "/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 2 */ SELECT
				ta.cod_taquilla
				FROM taquilla ta, taquilla_opc_hnac tp
				WHERE
					ta.cod_agencia = %s AND
					tp.cod_taquilla = ta.cod_taquilla",
                    GetSQLValueString($_POST["cod_agencia"], "int")
                );
            }
            $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
            $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
            $totalRows_Recordset13 = mysqli_num_rows($Recordset13);
            if ($totalRows_Recordset13>0) {
                do {
                    $query_Recordset12 = sprintf(
                        "/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 3 */ SELECT
					pr.id_pfijo_hnac, ins.num_caballo_hnac
					FROM precio_fijo_hnac pr, inscritos ins
					WHERE
						ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
						pr.cod_taquilla = %s AND
						pr.fec_carrera_hnac = %s AND
						pr.cod_carrera_hnac = %s AND
						pr.cod_inscrito_hnac = %s
					LIMIT 1	",
                        GetSQLValueString($row_Recordset13['cod_taquilla'], "int"),
                        GetSQLValueString($fec, "date"),
                        GetSQLValueString($_POST["cod_carrera"], "int"),
                        GetSQLValueString($_POST["cod_ejemplar"], "int")
                    );
                    $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
                    $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
                    $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
                    if ($totalRows_Recordset12==0) {
                        $query_Recordset11 = sprintf(
                            "/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 4 */ SELECT 
							max_eje_hnac, max_jugtic_hnac, min_jugtic_hnac 
							FROM taquilla_opc_hnac
							WHERE cod_taquilla = %s LIMIT 1",
                            GetSQLValueString($row_Recordset13['cod_taquilla'], "date")
                        );
                        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
                        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
                        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
                        if ($totalRows_Recordset11<=0) {
                            $graba--;
                            if ($totalRows_Recordset11==1) {
                                $mError="&nbsp;*Configure&nbsp;<br/>&nbsp;primero&nbsp;<br/>&nbsp;datos de taquilla&nbsp;<br/>";
                            }
                        } else {
                            $_POST["apMax"]=$row_Recordset11['max_eje_hnac'];
                            $_POST["juMax"]=$row_Recordset11['max_jugtic_hnac'];
                            $_POST["juMin"]=$row_Recordset11['min_jugtic_hnac'];
                        }
                        if ($graba==30) {
                            $mError="&nbsp;***Datos guardados correctamente***&nbsp;<br/>";
                            $insertSQL = sprintf(
                                "/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 5 */ INSERT INTO precio_fijo_hnac (
								fec_carrera_hnac, cod_carrera_hnac, cod_inscrito_hnac, cod_taquilla, max_eje_hnac, 
								max_jug_hnac, min_jug_hnac, pre_fijo_hnac) 
								VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                                GetSQLValueString($fec, "date"),
                                GetSQLValueString($_POST["cod_carrera"], "int"),
                                GetSQLValueString($_POST["cod_ejemplar"], "int"),
                                GetSQLValueString($row_Recordset13['cod_taquilla'], "int"),
                                GetSQLValueString($_POST["apMax"], "int"),
                                GetSQLValueString($_POST["juMax"], "int"),
                                GetSQLValueString($_POST["juMin"], "int"),
                                GetSQLValueString($_POST["prFij"], "double")
                            );
                            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                        }
                    } elseif (isset($totalRows_Recordset11)&&$totalRows_Recordset11==1) {
                        $mError="&nbsp;*Ya existe un precio fijo&nbsp;<br/>&nbsp; para el ejemplar #:";
                        $mError.=$row_Recordset12['num_caballo_hnac']."&nbsp;<br/>";
                        $graba--;
                    }
                } while ($row_Recordset13 = mysqli_fetch_assoc($Recordset13));
            }
        }
    } elseif (isset($_POST["modifica"])&&isset($_POST["id_pfijo_hnac"])) {
        $cta=0;
        if ($_POST["amax"]<1&&$_POST["jmax"]<1&&$_POST["pfijo"]<1) {
            $graba--;
            $mError="&nbsp;*Indique monto a modificar&nbsp;<br/>";
        }
        if ($graba==30) {
            $mError="&nbsp;***Datos guardados correctamente***&nbsp;<br/>";
            if ($_POST["amax"]>0) {
                foreach ($_POST["id_pfijo_hnac"] as $id_pfijo_hnac) {
                    if ($id_pfijo_hnac>0) {
                        $insertSQL1 = sprintf(
                            "/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 6 */ UPDATE precio_fijo_hnac SET max_eje_hnac=%s WHERE id_pfijo_hnac=%s",
                            GetSQLValueString($_POST["amax"], "double"),
                            GetSQLValueString($id_pfijo_hnac, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                    }
                }
            }
            if ($_POST["jmax"]>0) {
                foreach ($_POST["id_pfijo_hnac"] as $id_pfijo_hnac) {
                    if ($id_pfijo_hnac>0) {
                        $insertSQL1 = sprintf(
                            "/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 7 */ UPDATE precio_fijo_hnac SET max_jug_hnac=%s WHERE id_pfijo_hnac=%s",
                            GetSQLValueString($_POST["jmax"], "double"),
                            GetSQLValueString($id_pfijo_hnac, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                    }
                }
            }
            if ($_POST["pfijo"]>0) {
                foreach ($_POST["id_pfijo_hnac"] as $id_pfijo_hnac) {
                    if ($id_pfijo_hnac>0) {
                        $insertSQL1 = sprintf(
                            "/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 8 */ UPDATE precio_fijo_hnac SET pre_fijo_hnac=%s WHERE id_pfijo_hnac=%s",
                            GetSQLValueString($_POST["pfijo"], "double"),
                            GetSQLValueString($id_pfijo_hnac, "int")
                        );
                        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                    }
                }
            }
        } else {
            { $graba--; $mError="&nbsp;*Hubo un error. Datos no modificados&nbsp;<br/>";}
        }
    }
}
$query_Recordset11 = sprintf("/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 9 */ SELECT 
	ag.nom_agencia, ag.cod_agencia 
	FROM agencia ag, taquilla ta, taquilla_opc_hnac tp
	WHERE ag.cod_agencia=%s AND ta.cod_agencia = ag.cod_agencia AND ta.cod_taquilla = tp.cod_taquilla
	GROUP BY ag.cod_agencia			
	ORDER BY ag.nom_agencia ASC",
    GetSQLValueString($codigoAgente, "int"));
$Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
$row_Recordset11 = mysqli_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysqli_num_rows($Recordset11);
$query_Recordset10 = sprintf(
    "/* PARSEADORES1 new\agente_hnac\agente_preciofijo.php - QUERY 10 */ SELECT 
	ca.cod_carrera_hnac, ca.can_caballos_hnac, ca.num_carrera_hnac, ca.hor_carrera_hnac,
	ca.est_carrera_hnac, ca.fec_carrera_hnac, ca.est_cierre_hnac, hi.nom_hipodromo_hnac,
	hi.cod_hipodromo_hnac
	FROM carrera_hnac ca, hipodromo_hnac hi
	WHERE hi.cod_hipodromo_hnac = ca.cod_hipodromo_hnac AND ca.fec_carrera_hnac = %s
	ORDER BY hi.nom_hipodromo_hnac, ca.num_carrera_hnac ASC",
    GetSQLValueString($fec, "date")
);
$Recordset10 = mysqli_query($conexionbanca, $query_Recordset10) or die(mysqli_error($conexionbanca));
$row_Recordset10 = mysqli_fetch_assoc($Recordset10);
$totalRows_Recordset10 = mysqli_num_rows($Recordset10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script language="javascript"> 
	function cambiacolor_over(celda){ celda.style.backgroundColor="#DDDDDD" }  
	function cambiacolor_out(celda){ celda.style.backgroundColor="#FFFFFF" } 
</script>
<script src="../js/jquery-1.9.1.min.js"></script>
<style type="text/css">A:link {text-decoration:none;color:#0000cc;} A:visited {text-decoration:none;color:#ffcc33;} 
A:active {text-decoration:none;color:#ff0000;} A:hover {text-decoration:underline;color:#999999;}
</style> 
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {background-color: #eeeeee;padding:0;margin:0 auto;font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
font-size:11px;}
input[type="checkbox"] {
	transform: scale(1,1); 
    -ms-transform: scale(1,1);
    -moz-transform: scale(1,1);
    -o-transform: scale(1,1);
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
<style>input[type="checkbox"]{transform:scale(1,1);-ms-transform:scale(1,1);-moz-transform:scale(1,1);-o-transform:scale(1,1);}
.c_over { background:#333; color:#FFF} .c_out { background: #D8FF00; color:#000}
</style>
<script>
$(document).ready(function() { $("#reloj").load('../includes/reloj.php?&js='+Math.random());
var refreshId1 = setInterval(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);});
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true; return true; }
	else { alert("El formulario ya está siendo enviado, por favor aguarde un instante."); return false; }
}
function aChecked(){
	var cont = $("input:checked").length;
	if (cont>0) {document.getElementById("oTaquillas").style.display = "";$("#cta").html("Seleccionado(s): "+cont);}
	else { document.getElementById("oTaquillas").style.display = "none";}
} 
function cfon(tr,chec) { 
if(document.getElementById(chec).checked) {tr.style.backgroundColor="#333";tr.style.color="#FFF";}
else {tr.style.backgroundColor="#FFF";tr.style.color="#000";}aChecked();}
function validarNro(e) {
	cuenta=0;
	var key; if(window.event) { key = e.keyCode; } else if(e.which) { key = e.which; } 
	if (key < 48 || key > 57) { if(key == 8 ) { return true; }
	else { return false; } } return true;
}
function ver() { 
	var xdata = {"ca":$("#cod_carrera").val(),"ta":$("#cod_taquilla").val(),"ra":Math.random()};
    $.ajax({url:"agente_buscaEjemplar.php",type: "GET",data:xdata,
    	success: function(opciones){
			$("#cod_ejemplar").html(opciones);
		}
    })
}
function verTaq(ti) {
	document.getElementById("oTaquillas").style.display = "none";
	var s1=document.getElementById("cod_carrera"),s2=document.getElementById("cod_ejemplar");
	var xdata = {"ag":$("#cod_agencia").val(),"ta":$("#cod_taquilla").val(),"ti":ti,"ca":$("#cod_carrera").val()};
    $.ajax({url:"agente_buscaTaquilla.php",type: "GET",data:xdata,
    	success: function(opciones){ 
			if (ti==1) { $("#cod_taquilla").html(opciones); s1.selectedIndex=1;s2.selectedIndex=-1;habOpc('guarda','cod_ejemplar');}
			if (ti==2) { $("#xTaquillas").html(opciones);s1.selectedIndex=1;$("#cod_ejemplar").html("");
				$("#cod_ejemplar").attr('disabled','disabled');habOpc('guarda','cod_ejemplar');
			}
			if (ti==3) { $("#xTaquillas").html(opciones);habOpc('guarda','cod_ejemplar');}
		}
    })
}
function eliminar(cod) {
	var xdata = {"id_pfijo" : cod, "cod_taquilla" : $("#cod_taquilla").val()};
    $.ajax({url:"agente_quitarPrecioFijo.php",type: "GET",data:xdata, success: function(opciones){verTaq(1);}})
}
function habOpc(el1, el2) {
	if(typeof(document.getElementById(el1)) !== "undefined"){ 
		if (document.getElementById(el2).value < 1) $('input[id="'+el1+'"]').attr('disabled','disabled');
		else $('input[id="'+el1+'"]').removeAttr('disabled');
	}
}
</script>
<script>var nav=navigator.userAgent.toLowerCase();if(nav.indexOf("firefox")!=-1){document.write('<link href="../estilo/adminFirefox.css" rel="stylesheet" type="text/css" />');}</script>
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
				<br/>Precio fijo
		    </div>
			Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
			<span id="reloj"></span>
        </div>
		<div class="contentAdmin" style="padding:80px 0 0 0">
			<div style="height:100%; font-size:18px;" class="xfirefox">
                <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                    onsubmit="return chequearEnvio();">
                    <table width="100%" border="1" align="center" style="background:#0E5157; color:#FFF; font-size:20px"
                        cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="35%" height="40" valign="bottom">
                            	&nbsp;CARRERAS NACIONALES:  <?php echo $totalRows_Recordset10 ?>&nbsp;
                            </td>
                            <td height="40" width="65%" valign="bottom" 
                                style="font-size:13px; text-align: right; background:#0E5157; color:#FFF">
                                <?php if (isset($graba) && $graba!=30) {?>
                                <span style="background:#FF0004"><?php echo $mError; ?></span>
                                <?php } else {
                                    if (isset($graba) && $graba==30) {?>
                                        <span style="background: #248311"><?php echo $mError; ?></span>
                                        <?php
                                    }
                                }?>				    
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="26%" align="left">
                                Nombre del Agente:<br/><br/>
                                <select name="cod_agencia" id="cod_agencia" style="width:220px; font-size:18px; height:40px"
                                onchange="verTaq(1);">
                                
                                    <option value="<?php echo $row_Recordset11['cod_agencia'];?>"
                                    <?php if ($row_Recordset11['cod_agencia']==$cAge) {
                                    echo "SELECTED";
                                } ?>> 
                                    <?php echo $row_Recordset11['nom_agencia'];?>
                                    </option>
                                <?php
                                ?>
                                </select>
                            </td>
                            <td width="22%" align="left">
                                Se Aplicara a todas sus Taquillas:<br/>
                                <select id="cod_taquilla" style="width:180px; height:40px" name="cod_taquilla" 
                                	 onchange="verTaq(2);">
                                    <option value="todas" <?php if ("todas"==$cTaq) {
                                       echo "SELECTED";
                                    } ?>
                                        style="background:#FF0004; color:#FFFFFF">TODAS
                                        
                                    </option>
                                </select>                     
                            </td>
                            <td width="52%" align="left">
                                Indique Hipodromo y Carrera:<br/><br/>
                                <select name="cod_carrera" id="cod_carrera" style="width:220px; font-size:14px; height:40px" 
                                    onchange="ver(this);verTaq(3)">
                                    <option value="-1" <?php if ($row_Recordset10['cod_carrera_hnac']==$cCar) {
                                    echo "SELECTED";
                                } ?>
                                    style="background:#FF0004; color:#FFFFFF">Seleccione
                                    </option>
                                    <option value="todas" <?php if ("todas"==$cCar) {
                                    echo "SELECTED";
                                } ?>
                                    style="background:#FF0004; color:#FFFFFF">TODAS
                                    </option>
                                <?php
                                do {?>
                                    <option value="<?php echo $row_Recordset10['cod_carrera_hnac'];?>"
                                    <?php if ($row_Recordset10['cod_carrera_hnac']==$cCar) {
                                    echo "SELECTED";
                                } ?>><?php
                                    echo $row_Recordset10['nom_hipodromo_hnac']." Carr...#".$row_Recordset10['num_carrera_hnac'];?>
                                    </option>
                                <?php
                                } while ($row_Recordset10 = mysqli_fetch_assoc($Recordset10));?>
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Si el nombre de Agente esta en blanco significa </br> que no esta configurado </br> para carreras nacionales
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="4" height="5" bgcolor="#E7E7E7"></td>
                        </tr>
                        <tr>
                            <td>
                                <div id="oTaquillas" style="height:65px;text-align:left;width:400px;background:#E3E3E3;
									display:none; font-size:10px">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td colspan="2">MODIFICAR:</td>
                                          <td id="cta"></td>
                                          <td width="25%" rowspan="2" valign="bottom">
                                            <input type="submit" value="Modificar" onClick="return enviado()" 
                                            title="guardar modificacion" id="modifica" name="modifica"
                                            style="font-size:12px; width:95px; height:40px"/>                                          </td>
                                        </tr>
                                        <tr align="center">
                                          <td width="25%">
                                          	APUESTA MAXIMA:
                                            <input name="amax"  type="text" onkeypress="javascript:return validarNro(event)"
                                            id="amax" title="indique monto de apuesta maxima" value="0"
                                            style="width:80px; height:18px; font-size:16px"/>
                                          </td>
                                          <td width="25%">
                                          	JUGADA MAXIMA:
                                            <input name="jmax"  type="text" onkeypress="javascript:return validarNro(event)"
                                            id="jmax" title="indique monto de apuesta maxima" value="0"
                                            style="width:80px; height:18px; font-size:16px"/>
                                          </td>
                                          <td width="25%">
                                          	PRECIO FIJO:
                                            <input name="pfijo"  type="text" onkeypress="javascript:return"
                                            id="pfijo" title="indique monto de apuesta maxima" value="0"
                                            style="width:80px; height:18px; font-size:16px"/>
                                          </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                            <td width="19%">
                                Ejemplar:<br/>
                                <select id="cod_ejemplar" style="width:180px; height:40px" name="cod_ejemplar" disabled="disabled"
                                onchange="habOpc('guarda','cod_ejemplar'), document.getElementById('prFij').focus();">
                                    <option value="-1">
                                    </option>
                                </select>                     
                            </td>
                            <td width="17%">
                                Monto precio fijo:
                                <input name="prFij"  type="text" onkeypress="javascript:return"
                                id="prFij" title="indique monto de precio fijo al ejemplar" disabled="disabled"
                                value="" style="width:80px; height:28px; font-size:20px" tabindex="3"/>
                            </td>
                            <td width="11%">
                                <input type="submit" value="Guardar" onClick="return enviado()" 
                                title="guardar resultados y dividendos" id="guarda" name="guarda" disabled="disabled"
                                style="font-size:18px; width:95px; height:60px"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" height="5" bgcolor="#E7E7E7"></td>
                        </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="form1" />
            	<div id="xTaquillas" style="height:300px; text-align:left">
                </div>
                </form>    
			</div> 
		</div>
		<div class="footer" style="background:#0E5157">Copyright © Apuestas Hípicas</div>
	</div>
	<script src="../modal/js/bootstrap.min.js"></script>
    <script src="../modal/js/functions.js"></script>
    <script src="../modal/js/sweetalert.min.js"></script> 
    <link href="../css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="../js/bootstrap-toggle.min.js"></script>
    <script src="../modal/js/bootstrap.min.js"></script>
    <script>$(document).ready(function(){<?php if ($cAge!=-1) {
                                    echo 'verTaq(1)';
                                }?>});</script>
</body>
</html>
<?php
if (isset($Recordset10)) {
                                    mysqli_free_result($Recordset10);
                                }
if (isset($Recordset11)) {
    mysqli_free_result($Recordset11);
}
if (isset($Recordset12)) {
    mysqli_free_result($Recordset12);
}
?>
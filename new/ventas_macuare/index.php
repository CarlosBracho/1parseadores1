<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include("index_datos.php");
$bg="#00BB7E";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<link href="../estilo/ventasmie.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.9.1.min.js"></script><script src="../js/fjava.js"></script>
<!--[if lt IE 7]><script type="text/javascript">alert("ATENCIÓN: Este software solo funciona con \nMicrosoft Internet Explorer 7 o superior\n\nPor favor, actualice su navegador");location.href='../index.php';</script><![endif]-->
<style> 
	body{ background:#e0e0e0;} input:focus{ outline:none !important;border-color:#719ECE;box-shadow:0 0 20px #719ECE;} 
	table{border-collapse: collapse;} td{ border-bottom: 1px solid #CCC;} .textboxsmal{width:25px;height:25px;}
	input[type="radio"]{width: 20px;height: 20px;}
</style>
<script>
var cuenta=0;
$(document).ready(function() {
	$("input[type=text]").focus(function(){this.select();});
 	 $("#buttonrojo").click(function(){
		if (document.getElementById('pagarT').value!=0) {
			document.getElementById('pagamensaje').style.display = 'block';
			document.getElementById('pagaTicket').style.display = 'none';
			document.getElementById('eliminaTicket').style.display = 'none';
			$('#buttonazul').prop("disabled", true);
			var elElemento=document.getElementById('pagamensaje');
			var url = "ventas_eliminar_ticket_mac.php"; // El script en dónde se realizará la petición.
			var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
	 		var esper1 = '<img src="../images/buscando.gif" width="60" height="60" />';
	  		var esper2 = '<br/>Eliminación en Proceso! Por favor espere ...';
			elElemento.style.display = 'block';
			$('#buttonrojo').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form2").serialize(),
				beforeSend: function(){ $('#pagamensaje').html(esper1+esper2); },
				success: function(data) { $("#pagamensaje").html(data); 
					$('#buttonrojo').prop("disabled", false);
					$('#buttonazul').prop("disabled", false);
					$("#men_pagar2").load('ventas_ver_ultimo_mac.php?&js='+Math.random());
				},
				error: function(){ 
					$("#pagamensaje").html(xerror);
					$('#pagamensaje').fadeOut(119000);
					$('#buttonrojo').prop("disabled", false);
					$('#buttonazul').prop("disabled", false);
				}
			});
		}
		return false; // Evitar ejecutar el submit del formulario.
	 });
	$("#buttonverde").click(function(){
		if (document.getElementById('pagarT').value!=0) {
			document.getElementById('pagamensaje').style.display = 'block';
			document.getElementById('pagaTicket').style.display = 'none';
			document.getElementById('eliminaTicket').style.display = 'none';
			$('#buttonazul').prop("disabled", true);
			var elElemento=document.getElementById('pagamensaje');
			var url = "ventas_pagar_apuestas_procesar_mac.php"; // El script en dónde se realizará la petición.
			var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
			var esper1 = '<img src="../images/buscando.gif" width="60" height="60" /><br/>En Proceso! Por favor espere ...';
			elElemento.style.display = 'block';
			$('#buttonrojo').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form2").serialize(),
				beforeSend: function(){ 
					$('#pagamensaje').html(esper1);
				},
				success: function(data) {
					$("#pagamensaje").html(data);
					$('#buttonrojo').prop("disabled", false);
					$('#buttonazul').prop("disabled", false);
				},
				error: function(){ 
					$("#pagamensaje").html(xerror);
					$('#pagamensaje').fadeOut(119000);
					$('#buttonrojo').prop("disabled", false);
					$('#buttonazul').prop("disabled", false);
				}
			});
		}
		return false; // Evitar ejecutar el submit del formulario.
	});
	 
});
</script>

<script>
	function GetIEVersion(){
		var sAgent=window.navigator.userAgent;
		var Idx=sAgent.indexOf("MSIE");
		if (Idx > 0) return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));
		else if(!!navigator.userAgent.match(/Trident\/7\./))return 11;else return 0;}
		if (navigator.appName=='Microsoft Internet Explorer' || GetIEVersion()>0){
			document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');
			document.write('<style>input[type="radio"]{width:25px;height:25px;}</style>');
			if(!factory.object){
				c=confirm('Por favor, descargue el Active X, Presionando Aceptar, la cual permitirá que el software pueda Imprimir, instálelo y al finalizar la instalación reinicie su equipo e intente de nuevo.');
				if(c==true){window.location = 'http://1h.superamericanas.com:5825/smsx.exe';}
				else window.location='../acceso.php';}}
			//if(navigator.javaEnabled()==false){location.href='../error_no_java.php';}
var statusEnvio=false;
function chequearEnvio(){
	if(!statusEnvio){statusEnvio=true;return true;}
	else{alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
	return false;}
}
$( document ).ready(function() {
	function efectoX(){
		capa = $(".noLeido");
		capa.fadeOut(900);
		capa.fadeIn(4000, efectoX);
	}
	efectoX();
});
function valjug(idChe,idnam,div,cab,div2) {
	var c="#ff0004";
	var idC=document.getElementById(idChe);
	var radioButTrat=document.getElementsByName(idnam);
	var cv=0;
	var form1="form1";
	for (var i=0; i<radioButTrat.length; i++) {
		if((i+1)%2==0) xcolor="#333"; else xcolor="#ccc"; 
		radioButTrat[i].style.backgroundColor = xcolor;
		if (radioButTrat[i].checked == true) {
			idC.style.backgroundColor=c;
			document.getElementById(div).innerHTML=cab;
			cuenta++;if(cuenta>6) cuenta=6;
		}  
	}
	document.getElementById("monto").focus();
	for (i=0; i < document.form1.length; i++){if (document.form1.elements[i].type=="radio"){
		if (document.form1.elements[i].checked){cv++;}}
	}
	if(cv==6){document.getElementById("imprimir").disabled=false;document.getElementById("selCarrera2").innerHTML="Indique monto y presione el boton Realizar apuesta e imprimir"} else document.getElementById("imprimir").disabled=true;
}
function verMon() {
if (document.getElementById("monto").value>0) { 
	prem=document.getElementById("monto").value*document.getElementById("div_pago").value;
	document.getElementById("premio").innerHTML=prem.toFixed(2);} 
if (document.getElementById("monto").value<=0 || document.getElementById("monto").value=="") { prem=0;
	document.getElementById("premio").innerHTML=prem.toFixed(2);}
}
$(document).ready(function(){ 
	$("#monto").keydown(function(event) {
	   if(event.shiftKey) { event.preventDefault(); } if (event.keyCode == 46 || event.keyCode == 8) {}
	   else { if (event.keyCode < 95) {  if (event.keyCode < 48 || event.keyCode > 57) { event.preventDefault(); }} 
	   else { if (event.keyCode < 96 || event.keyCode > 105) { event.preventDefault(); }}}});
});
function rangoNumeros(field, menor, mayor){
	var fi=document.getElementById(field);
	var va=document.getElementById(field).value;
	var me=menor, ma=mayor;
	var mensajeerror="valores entre "+me+" y "+ma;
	if (va!="") {
		if (va>ma){
			alert(mensajeerror);
			document.getElementById(field).focus();
			document.getElementById(field).value="";
		}
		if (va<me){
			alert(mensajeerror);
			document.getElementById(field).focus();
			document.getElementById(field).value="";
		}
	}
}
function handleEnter2 (field, event) {
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (keyCode == 13) {
			var i;
			for (i = 0; i < field.form.elements.length; i++)
				if (field == field.form.elements[i])
					break;
			i = (i + 1) % field.form.elements.length;
			if (field.form.elements[i].disabled==false) field.form.elements[i].focus();
			return false;
		} 
		else return true;
} 
function clean() {
	$("#info1").html('<font color="red"><strong><?php echo $mensaje1; ?></strong></font>');
	$("#info2").html('<font color="red"><strong><?php echo $_SESSION['MM_mensaje2']; ?></strong></font>');
	document.getElementById('pagamensaje').style.display = 'none';
	document.getElementById('pagaTicket').style.display = 'block';
	document.getElementById('eliminaTicket').style.display = 'block';
}
function clean2() {
	document.getElementById('pagarT').value="";
	$("#pagamensaje").html('');
}
function validarNro(e) {
	cuenta=0;
	var key; if(window.event) { key = e.keyCode; } else if(e.which) { key = e.which; } 
	if (key < 48 || key > 57) { if(key == 8 ) { return true; }
	else { return false; } } return true;
}
</script>
</head>
<body onload="javascript:document.all.form1.focus(); Javascript:history.go(1);" onunload="Javascript:history.go(1);">
    <div id="container" class="container">
		<div id="header" class="header" style="background: <?php echo $bg;?>;">
            <?php include("../includes/cabeceraventasmacuare.php");?>
		</div>
		<div id="content" class="content" style="border:3px solid <?php echo $bg;?>">
            <div id="taquilla" class="taquilla">
                <div id="datos" class="datos" style="background: #333; width:300px;float:left;">
                    TAQUILLA DE VENTAS: <?php echo strtoupper($row_Recordset6['nom_taquilla']); ?>
                </div>
				<div style="float:left;font-size:26px;padding:3px 0px 0px 0px; color:#00D81F;width:309px;background:#333;">
                &nbsp;<?php echo "MACUARE CORTO";?>
				</div>
                <div id="usuario" class="usuario" style="background:#333; width:320px; float:left">
                    <?php echo "Usuario: ".strtoupper($row_Recordset6['nom_completo']); ?> | <?php echo vfechaActual(); ?>
                </div>
            </div>
            <div id="mensaje" class="mensaje">
            	<?php echo $mensaje1; ?><BR/><?php echo $_SESSION['MM_mensaje2']; ?>
            </div>
			<div id="jugada" class="jugada">
             	<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                   	onsubmit="return chequearEnvio();">
                <div id="izquierda" class="izquierda" style="width:694px">
					<div id="men_canticket" style="font-size:16px; background:#333;width:620px; float:left; height:17px; 
                    	text-align:right; padding:12px 2px 2px 2px; color:#FFF; font-size:12px;">
                        <div style="background: #333; width:120px; float:left; text-align: left; padding:5px 0px 0px 0px">
                        HIPÓDROMO
                        </div>
                            Ticket creados por Vendedor:
                    </div><!-- end .men_canticket -->
					<div id="mon_canticket" style="font-size:24px; background: #333; width:65px; float:left; height:27px;
					 		text-align:left; padding:2px 3px 2px 2px; color: #F00;">
                            <?php $tipo=1;//tipo de macuare
                            include("../includes/infoNumeroTicket_macu.php");?>
					</div><!-- end .mon_canticket -->
					<div id="hipodromo" style="font-size:18px; float:left; width:694px; height:35px;
                    	background:#CCC; text-align: right;">
                        <div id="nomhipodromo" style="background:#333; width:450px;float:left;font-size:24px; 
                        	text-align:left;padding:0px 2px 0px 6px">
                          <div style="float:left; width:50%">
								<?php echo $nom_hipodromo; ?>
                            </div>    
                            <div style="float:left; width:50%; font-size:10px; text-align:right">
                            	<?php if ($div_pago>0) {?>
                                    Dividendo:
                                    <span style="font-size:20px">
                                    <?php echo number_format($div_pago, 2, ",", ".");?>
                                    </span>
                                <?php }?>
                            </div>    
                      </div>
						<?php
                        if (isset($totalRows_Recordset1) && $totalRows_Recordset1==6 && $tieVenta==1 && $estVenta==1 &&
                            $div_pago>0) {?>
							<div id="selCarrera2" style="font-size:15px;width:231px;height:50px;float:left; color: #FF0;
                            	text-align:center; background:#00BB7E; padding:0px 1px 0px 1px">
                            	Seleccione los ejemplares <br/>por carrera
                            </div>                         
                            <input type="hidden" name="cod_carrera" id="cod_carrera" value="<?php echo $cod ?>"/>
                        <?php
                        } else {
                            $_SESSION['selCarrera']=-1; //#e0e0e0?>
							<div id="selCarrera2" style="font-size:22px;width:236px;height:50px;float:left; color: #FFF;
                            	text-align:center; background:#C03">
                                <?php
                                if (isset($totalRows_Recordset1) && $totalRows_Recordset1==0 && $tieVenta==1) {
                                    echo "Aún no hay carreras";
                                } else {
                                    if ($tieVenta==0 or $apu_cor_macu==0 or $div_pago<=0) {
                                        echo'<font style="font-size:20px;">MACUARE CORTO CERRADO</font>';
                                    }
                                } ?>
                            </div>                         
                            <input type="hidden" name="cod_carrera2" id="cod_carrera2" value="-1" />
						<?php
                        }?>                            
					</div><!-- end .hipodromo -->
                    <div id="centroapuesta" class="centroapuesta" 
                    	style="font-size:16px; width:75%; float:left;">
						<?php
                        if (isset($totalRows_Recordset1) && $totalRows_Recordset1==6 && $tieVenta==1 && $estVenta==1 &&
                            $div_pago>0) {?>

                        <div style="float:left; width:20%; padding:25px 0px 0px 0px; color:#000;
                        border-bottom: 1px solid #000; border-right: 1px solid #000;">
                        	CARRERAS
                           
                        </div>
                        <div style="float:left;width:78%;padding:6px 0px 0px 0px;color:#000;
                        	border-bottom: 1px solid #000"">
                            <div style="height:17px">
                            	EJEMPLARES
                            </div>
                            <?php for ($d = 1; $d <= 15; $d++) {
                                if ($d%2==0) {
                                    $xcolor="#333";
                                    $xcolor2="#CCC";
                                } else {
                                    $xcolor="#CCC";
                                    $xcolor2="#333";
                                } ?>
                                <div style="width:6.6%;float:left; background:<?php echo $xcolor; ?>; 
                                	color:<?php echo $xcolor2; ?>; font-size:20px; height:21px">
								<?php echo str_pad((int) $d, 2, "0", STR_PAD_LEFT); ?>
                                </div>
							<?php
                            }?>
                        </div>
                         <?php }?>
                        <input type="hidden" name="cod_carrera" value="<?php echo $row_Recordset1['cod_carrera_hnac'];?>" />
                        <?php
                        if (isset($totalRows_Recordset1) && $totalRows_Recordset1==6 && $tieVenta==1 && $estVenta==1 &&
                            $div_pago>0) {
                            $inCar=$row_Recordset1['num_carrera_hnac'];
                            $fiCar=$totalRows_Recordset1;
                            do {?>
								<div style="float:left; width:20%; padding:6px 0px 0px 0px; color:#000; font-size:16px;
									border-bottom: 1px solid #000; border-right: 1px solid #000; height:19px"> 
									<span style="font-size:14px">
										CARRERA #<?php echo $row_Recordset1['num_carrera_hnac'];?>
									</span>
								</div>
								<?php
                                $codC=$row_Recordset1['cod_carrera_hnac'];
                                $query_Recordset2 = sprintf(
                                    "/* PARSEADORES1 new\ventas_macuare\index.php - QUERY 1 */ SELECT 
									ic.num_caballo_hnac,
									ic.est_inscrito_hnac,
									ic.nom_caballo_hnac
									FROM 
										carrera_hnac ca,
										inscritos ic
									WHERE
										ic.cod_carrera_hnac =  ca.cod_carrera_hnac AND
										ca.fec_carrera_hnac = %s AND
										ca.cod_carrera_hnac = %s LIMIT 15",
                                    GetSQLValueString($fec, "date"),
                                    GetSQLValueString($codC, "int")
                                );
                                $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or
                                    die(mysqli_error($conexionbanca));
                                $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
                                $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
                                ?>
								<div style="float:left;width:78%;padding:0px 0px 0px 0px;color:#000; font-size:14px;
									border-bottom: 1px solid #000;">
									<?php
                                    $d=0;
                                    do {
                                        $d++;
                                        $numCa=str_pad((int) $row_Recordset2['num_caballo_hnac'], 2, "0", STR_PAD_LEFT);
                                        $caballo=$numCa."-".$row_Recordset2['nom_caballo_hnac'];
                                        $crrCb=$codC."_".$row_Recordset2['num_caballo_hnac'];
                                        $idVal=$codC."_".$row_Recordset2['num_caballo_hnac'];
                                        $dV="dV".$row_Recordset1['num_carrera_hnac'];
                                        if ($row_Recordset2['est_inscrito_hnac']==1) {
                                            $idNom="c".$codC."_".$row_Recordset2['num_caballo_hnac'];
                                            $grupo="g-".$row_Recordset1['num_carrera_hnac']."-".$row_Recordset2['num_caballo_hnac'];
                                        } else {
                                            $idNom="r".$codC.$row_Recordset2['num_caballo_hnac'];
                                            $grupo=$idNom;
                                        }
                                        if ($d%2==0) {
                                            $xcolor="#333";
                                        } else {
                                            $xcolor="#CCC";
                                        } ?>
										<div id="<?php echo $crrCb; ?>" 
											style="width:6.6%;float:left; background:<?php echo $xcolor; ?>; font-size:9px;
                                            height:25px;">
										<input type="radio"
										name="<?php echo $codC; ?>" 
										id="<?php echo $grupo; ?>" 
										value="<?php echo $row_Recordset2['num_caballo_hnac']; ?>" 
										
										<?php if ($row_Recordset2['est_inscrito_hnac']==0) {
                                            echo "disabled='disabled'";
                                            echo"title='&nbsp;RETIRADO&nbsp;'";
                                        } else {
                                            echo"title='&nbsp;".$caballo."&nbsp;'";
                                        } ?>
										 onclick="valjug('<?php echo $grupo; ?>','<?php echo $codC; ?>','<?php echo $dV; ?>',
											'<?php echo "&nbsp;".$caballo; ?>','<?php echo $crrCb; ?>',clean(),clean2())">
										</div>
									<?php
                                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                                    if ($d<15) {
                                        for ($s = $d+1; $s <= 15; $s++) {
                                            if ($s%2==0) {
                                                $xcolor="#333";
                                            } else {
                                                $xcolor="#CCC";
                                            } ?>
											<div 
                                            style="width:6.6%;float:left;background:<?php echo $xcolor; ?>;font-size:14px;
												height:25px">X
											</div>
										<?php
                                        }
                                    }
                                    ?>
								</div>
							<?php
                            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
                        } else {?>
                        <div style="padding:100px 0px 0px 0px; font-size:30px; color:#000000;">
                        	<?php
                            if ($tieVenta==0 or $estVenta==0) {
                                echo "VENTA CERRADA";
                            }
                            if ($div_pago==0) {
                                echo '<font size="+2">DIVIDENDO AUN NO HA SIDO CARGADO</font>';
                                echo '<font size="+1"><br/>POR FAVOR INTENTE MAS TARDE</font>';
                            }
                            if ($div_pago==-1) {
                                echo 'DATOS AUN NO HAN SIDO CARGADOS';
                                echo '<font size="+2"><br/>POR FAVOR INCLUYA DIVIDENDO PARA EL MACUARE CORTO</font>';
                            }
                            ?>	
                        </div>
                        <?php }?>
                        <input type="hidden" name="CC_final" value="<?php echo $fiCar;?>" />
                        <input type="hidden" name="CC_inicial" value="<?php echo $inCar;?>" />
					</div><!-- end .centroapuesta -->
                        <div style="float:left; width:172px;margin:15px 0px 0px 0px; height:191px; color:#000000;
                        	font-size:18px;">
                        MONTO:<br/>
                        <input type="text" name="monto" style="width:100px; height:22px; font-size:18px;" id="monto" 
                        onKeyDown="return handleEnter2(this, event)" tabindex="1"
                        <?php if (!isset($totalRows_Recordset1) or $totalRows_Recordset1!=6 or $tieVenta==0 or $estVenta==0
                                or $div_pago<=0) {
                                echo 'disabled="disabled"';
                            }?>
                         onclick="clean(),clean2()"       
                     	 onblur="rangoNumeros('monto',<?php echo $apu_min_macu;?>,
					 								  <?php echo $apu_max_macu; ?>,<?php echo $div_pago; ?>),verMon()">
                        <br/><br/>
                        <?php
                        if (isset($totalRows_Recordset2) && $totalRows_Recordset2>0) {
                            for ($s = $inCar; $s <= ($inCar+$fiCar)-1; $s++) {?>
								<div id="<?php echo "dV".$s;?>" style="font-size:11px; width:98%;
									text-align:left;border-bottom: 1px solid #000;">
                                    <span style="color: #FF0000">
									<?php echo "&nbsp;Carr: #".$s." NO SELECCIONADO";?>
                                    </span>
								</div>
                                
							<?php }
                        }?>
                            <div id="texprem" style="font-size:12px; text-align: right">
                            Premio:
                              <strong><span id="premio" style="font-size:16px">0,00</span></strong>
                            </div>
                  		</div>
                        <div id="realizarapuesta" style="padding:10px 0px 0px 0px;float:left; width:100%;">
                            <input type="submit" id="imprimir" name="imprimir" onClick="return enviado();" 
                            value="REALIZAR APUESTA E IMPRIMIR" style="width:400px; font-size:20px; height:45px"
                            tabindex="2" title="realiza apuesta e imprimir" disabled="disabled"/>
                        </div><!-- end .realizarapuesta -->
                        <div id="recargar" style="padding:10px 0px 0px 0px;float:left; width:100%">
                            <input type="button" onclick="window.location='index.php';"  
                            value="ACTUALIZAR PÁGINA" style="width:300px; font-size:20px; height:45px"
                            tabindex="3" title="actualiza página"/>
                        </div><!-- end .realizarapuesta -->
                </div><!-- end .izquierda -->
                <input type="hidden" name="codUsu" value="<?php echo $usuarioVenta;?>" />
                <input type="hidden" name="codTaq" value="<?php echo $taquilla;?>" />
                
                <input type="hidden" name="apu_min_macu" value="<?php echo $apu_min_macu;?>" />
                <input type="hidden" name="apu_max_macu" value="<?php echo $apu_max_macu;?>" />
                <input type="hidden" name="lim_max_macu" value="<?php echo $lim_max_macu;?>" />
                
                <input type="hidden" name="div_pago" id="div_pago" value="<?php echo $div_pago;?>" />
                
                
                <input type="hidden" name="MM_insert" value="form1" />
                </form>                    
                <div id="derecha" style="font-size:16px;width:27.8%;float:left; background:#e0e0e0;height:386px;
                	margin:0px 0px 0px 0.2%; color:#000;">

				    <div id="men_pagar" style="font-size:12px; background: #333;  width:99%; float:left; height:13px; 
                    	text-align: left; padding:1px 0px 0px 3px; color: #FFF; line-height:13px;
                        border-bottom: 1px black solid;">
                   	  	Última jugada realizada:
					</div><!-- end .men_pagar -->                
				    <div id="men_pagar2" style="font-size:10px; background: #333;  width:99%; float:left; height:63px; 
                    	text-align: left; padding:0px 0px 0px 3px; color: #FFF;border-bottom: 1px black solid;">
                        <?php if ($estVenta==1) {
                            include("ventas_ver_ultimo_mac.php");
                        }?>
					</div><!-- end .men_pagar -->                
				    <div id="men_pagar3" style="font-size:20px; background: #333;  width:99%; float:left; height:30px; 
                    	text-align:center; padding:9px 0px 0px 3px; color: #FFF">
                   	  	PAGAR/ELIMINAR APUESTA
					</div><!-- end .men_pagar -->                
                    <div id="pagarapuesta" style="font-size:16px; height:57%; width:97%; float:left; text-align:center; 
                    	padding:0px 0px 49px 10px; line-height:80px;">
                        <form method="post" id="form2"><?php
                            if ($pedirCodigoPago==0) {?>
                                INSERTAR CÓDIGO DE TICKET:
                                <div id="codigoTicket" style="height:50px;width:95%;float:left;margin:-25px 0px 0px 0px;">
                                <input type="text" name="pagarT" id="pagarT"  value=""
                                onclick="clean(),clean2()" style="width:170px; height:30px; font-size:20px"
                                onkeypress="javascript:return validarNro(event)">
                                </div>
                                <div id="pagaTicket" style="height:70px; width:95%; float:left; padding:8px 0px 0px 0px;">
                                    <input type="submit" id="buttonverde" onclick="clean()" value="Procesar Pago" 
                                    title="paga apuesta" style="width:180px; font-size:18px; height:40px"/>
                                </div>
                                <div id="eliminaTicket" style="height:70px; width:95%; float:left; padding:10px 0px 0px 0px;">
                                    <input type="submit" id="buttonrojo" onclick="clean()" value="Eliminar ticket" 
                                    title="elimina apuesta" style="width:180px; font-size:18px; height:40px"/>
                                </div>
                                <input type="hidden" name="id_usuario_pago" value="<?php echo $usuarioVenta; ?>" />
                                <?php
                            } else {?>
                            	<div id="pagaTicket" style="height:70px; width:95%; float:left; padding:88px 0px 0px 0px;">
                                	<input type="button" style="width:180px; font-size:18px; height:40px" 
                                    	value="Ir a pagar apuesta" 
                                    	onclick="javascript:window.open('pag_tic_sincodigo_mac.php?uVenta=<?php echo $usuarioVenta?>', '_blank');"/>
                                </div>
								<div id="eliminaTicket" style="height:70px; width:95%; float:left; padding:0px 0px 0px 0px;">
                                	<input type="button" style="width:180px; font-size:18px; height:40px" 
                                    	value="Ir a eliminar ticket" 
                                    	onclick="javascript:window.open('eli_tic_sincodigo_mac.php?recordID=<?php echo $pedirCodigoPago?>&uVenta=<?php echo $usuarioVenta?>', '_blank');"/>
                                </div>
								<input type="hidden" name="pagarT" id="pagarT" value="" />

                            	<?php //#e0e0e0;
                            }?>
                        </form>
                  </div><!-- end .pagarapuesta -->
                  <div id="pagamensaje" style="height:130px; width:99%; float:left; color:#CC0000; 
                        text-align:center; margin:-150px  0px 0px 3px; line-height:16px;
                        background: #e0e0e0; display:none">
                  </div>
				</div> <!-- end .derecha -->
		  </div>            
		</div>
		<div class="footer" style="background:<?php echo $bg;?>"><?php echo piedepagina(); ?><!-- end .footer --></div>
	</div>
</body>
</html>
<script>if (document.getElementById("monto").disabled==false) document.getElementById("monto").focus();
document.getElementById("imprimir").disabled=true;</script>
<?php if (isset($Recordset1)) {
                                mysqli_free_result($Recordset1);
                            }mysqli_free_result($Recordset4);
if ($iR==0) {
    $_SESSION['MM_mensaje2']=$row_Recordset4['seg_linea'];
}
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
;?>

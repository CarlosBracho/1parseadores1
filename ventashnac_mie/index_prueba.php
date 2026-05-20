<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
include("index_datos2.php");


date_default_timezone_set('Pacific/Honolulu');
$hora1= date("D M j G:i:s T Y");
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
//echo horaampm($nuevahora1);






$horaactual=horaactual();
$fechasistema=fechaactualbd();
$fecha=fechanueva(fechaactualbd());
$query_Recordset111 = sprintf(
    "/* PARSEADORES1 ventashnac_mie\index_prueba.php - QUERY 1 */ SELECT 
	carrera_hnac.cod_carrera_hnac,
    carrera_hnac.cod_hipodromo_hnac,
	carrera_hnac.fec_carrera_hnac,
	carrera_hnac.hor_carrera_hnac,
	carrera_hnac.est_carrera_hnac,
	carrera_hnac.est_cierre_hnac,
	carrera_hnac.can_caballos_hnac,
	carrera_hnac.num_carrera_hnac,
	carrera_hnac.dis_carrera_hnac,
	carrera_hnac.mtp_control_hnac,
	carrera_hnac.est_confirmacion_hnac,
	carrera_hnac.pau_pagos_hnac,
	carrera_hnac.pau_ventas_hnac,
	hipodromo_hnac.nom_hipodromo_hnac
	FROM 
	carrera_hnac, 
	hipodromo_hnac 
	WHERE hipodromo_hnac.cod_hipodromo_hnac > 0 AND
	carrera_hnac.cod_hipodromo_hnac=hipodromo_hnac.cod_hipodromo_hnac AND
	carrera_hnac.fec_carrera_hnac = %s 
	ORDER BY carrera_hnac.num_carrera_hnac ASC",
    GetSQLValueString($fechasistema, "date")
);
$Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
$row_Recordset111 = mysqli_fetch_assoc($Recordset111);
$totalRows_Recordset111 = mysqli_num_rows($Recordset111);








?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>.:Apuestas H�picas:.</title>
<link href="../estilo/ventasmie.css" rel="stylesheet" type="text/css" />
<!--[if lt IE 6]><script type="text/javascript">alert("ATENCI�N: Este software solo funciona con \nMicrosoft Internet Explorer 6 o superior\n\nPor favor, actualice su navegador");location.href='../acceso.php';</script><![endif]-->
<!--[if lt IE 8]><link href="../estilo/styleIE7.css" rel="stylesheet"> <!--<![endif]-->
<style> body{ background:#e0e0e0;} input:focus{ outline:none !important;border-color:#719ECE;box-shadow:0 0 20px #719ECE;} </style>
<script src="../js/jquery-1.9.1.min.js"></script><script src="../js/fjava.js"></script>
<script>var statusEnvio=false;function chequearEnvio(){if(!statusEnvio){statusEnvio=true;return true;}else{alert("Datos enviados por favor presione enter solo una vez mas.");return false;}}
if (navigator.appName=='Microsoft Internet Explorer' || GetIEVersion()>0){
	document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');
	if(!factory.object){
		c=confirm('Este software solo funciona con Microsoft Internet Explorer. Por favor, descargue el Active X, Presionando Aceptar, la cual permitir� que el software pueda Imprimir, inst�lelo y al finalizar la instalaci�n reinicie su equipo e intente de nuevo.');
		if(c==true){window.location = '../download/smsx.exe';}
		else window.location='../acceso.php';}
	}
	else{
		//alert("La Taquilla Ligera Solo Funciona Con Internet Explorer");
		//location.href='../acceso.php';
	} 
	$( document ).ready(function() {
	function efectoX(){
		capa = $(".noLeido");
		capa.fadeOut(900);
		capa.fadeIn(4000, efectoX);
	}
	efectoX();
});
</script>
<script>var sAgent = window.navigator.userAgent;var Idx= sAgent.indexOf("MSIE");function GetIEVersion(){var sAgent=window.navigator.userAgent;var Idx=sAgent.indexOf("MSIE");if (Idx > 0) return parseInt(sAgent.substring(Idx+ 5, sAgent.indexOf(".", Idx)));else if(!!navigator.userAgent.match(/Trident\/7\./))return 11;else return 0;}
if (navigator.appName=='Microsoft Internet Explorer' || GetIEVersion()>0){
	if(!factory.object){
		c=confirm('Este software solo funciona con Microsoft Internet Explorer. Por favor, descargue el Active X, Presionando Aceptar, la cual permitir� que el software pueda Imprimir, inst�lelo y al finalizar la instalaci�n reinicie su equipo e intente de nuevo.');
		if(c==true){window.location = '../download/smsx.exe';}
		else window.location='../acceso.php';}
	}
	else{
		//alert("La Taquilla Ligera Solo Funciona Con Internet Explorer");
		//location.href='../acceso.php';
	} 
	$( document ).ready(function() {
});
function validarNro(e)
{
var tecla;
tecla = (document.all) ? e.keyCode : e.which;
if(tecla == 8)
{return true;}
var patron;
patron = /[0-9.]/
var te;
te = String.fromCharCode(tecla);
return patron.test(te);
}
function rangoNumeros(field, menor, mayor){
	var fi=document.getElementById(field);
	var va=document.getElementById(field).value;
	var me=menor, ma=mayor;
	var mensajeerror="valores entre "+me+" y "+ma;
	if (va!="") {
		if (va>ma){ alert(mensajeerror); document.getElementById(field).focus(); document.getElementById(field).value=""; }
		if (va<me){ alert(mensajeerror); document.getElementById(field).focus(); document.getElementById(field).value=""; }
	}
}
function pizActual(carrera) {
	if (carrera.value>0){
		document.getElementById("carreraAnt").value=carrera.value;
		var u=document.getElementById("idus").value, c=carrera.value, t=document.getElementById("ctaq").value;
		var parametros = { "iD":c, "codtaquilla":t, "codusuario":u, "rA":Math.random()};
		$.ajax({ data:parametros, url:'pizarra_actual.php', type:'post', cache: 'false', global : false,
			success:function (response) { $("#impPiza").html(response); }
		});
	}
}
</script>
<script>
function clean() {
	$("#mensaje").html('<font color="red"><strong><?php echo $mensaje1."<br/>".$_SESSION['MM_mensaje2']; ?></strong></font>');
	document.getElementById('pagamensaje').style.display = 'none';
	document.getElementById('pagaTicket').style.display = 'block';
	document.getElementById('eliminaTicket').style.display = 'block';
}
function clean2() {
	document.getElementById('pagarT').value="";
	$("#pagamensaje").html('');
}
$(document).ready(function() {
	$("input[type=text]").focus(function(){this.select();});
 	 $("#buttonrojo").click(function(){
		if (document.getElementById('pagarT').value!=0) {
			document.getElementById('pagamensaje').style.display = 'block';
			document.getElementById('pagaTicket').style.display = 'none';
			document.getElementById('eliminaTicket').style.display = 'none';
			$('#buttonazul').prop("disabled", true);
			var elElemento=document.getElementById('pagamensaje');
			var url = "ventas_eliminar_ticket_hnac.php"; // El script en d�nde se realizar� la petici�n.
			var xerror = '<p id="mpaga"><br/><br/><h3>NO HAY RESPUESTA DEL SERVIDOR<h3/>Por favor intente de nuevo</p>';
	 		var esper1 = '<img src="../images/buscando.gif" width="60" height="60" />';
	  		var esper2 = '<br/>Eliminaci�n en Proceso! Por favor espere ...';
			elElemento.style.display = 'block';
			$('#buttonrojo').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form2").serialize(),
				beforeSend: function(){ $('#pagamensaje').html(esper1+esper2); },
				success: function(data) { $("#pagamensaje").html(data); 
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
	$("#buttonverde").click(function(){
		if (document.getElementById('pagarT').value!=0) {
			document.getElementById('pagamensaje').style.display = 'block';
			document.getElementById('pagaTicket').style.display = 'none';
			document.getElementById('eliminaTicket').style.display = 'none';
			$('#buttonazul').prop("disabled", true);
			var elElemento=document.getElementById('pagamensaje');
			var url = "ventas_pagar_apuestas_procesar_hnac.php"; // El script en d�nde se realizar� la petici�n.
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

	var refreshId5 = null;
	function startChat() {
		refreshId5 = setInterval(function() {
		var rA=Math.random();
		var parametros = { "rA":Math.random() };
		$.ajax({ data:parametros, url:'chat_mostrar_hnac.php', type:'post',
			success:function (response) { 
				$("#Chat").html(response);
                                scrollChat()


			} 

		}); 

	 }, 7000);	}
	function stopChat() {
		clearInterval(refreshId5);

	}
</script>
<script language="javascript">

$(function(){
	$("#enviarChatBoton").click(function(){
		if (document.getElementById('txtMensaje').value!="") {
			var url = 'chat_enviar_hnac.php';
			$('#enviarChatBoton').prop("disabled", true);
			$.ajax({ type: "POST", url: url, global : false, data: $("#form4").serialize(),
				success: function(data) {
					$('#enviarChatBoton').prop("disabled", false);
					document.getElementById('txtMensaje').value="";
					 $("#Chat").load('chat_mostrar_hnac.php?&rA='+Math.random());
                                         scrollChat()
				}
			});
			return false; // Evitar ejecutar el submit del formulario.
		} else { cuenta=0; };
	});
});

function scrollChat() {
	 $("#Chat").animate({ scrollTop: $('#Chat')[0].scrollHeight}, 800);
}
	function accionCerrar(titulo,pregunta,cCar) {
		swal({
		  title: titulo,
		  text: pregunta,
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonText: "Cancelar",
		  confirmButtonClass: "btn-danger",
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Aceptar",
		  closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				var rA=Math.random();
				var parametros = { "recordID":cCar, "rA":Math.random() };
				$.ajax({ data:parametros, url:'admin_apertura_cierre_hnac.php', type:'get',
					success:function (response) { 
						window.location='admin_apertura_lista_hnac.php';
					}
				});
			} else {
				alertify.error('<font size="4">Acci�n cancelada!</font>');
			}
		});	
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
		function accionCancelar(titulo,pregunta,cCar) {
		swal({
		  title: titulo,
		  text: pregunta,
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonText: "Cancelar",
		  confirmButtonClass: "btn-danger",
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Aceptar",
		  closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				var rA=Math.random();
				var parametros = { "recordID":cCar, "rA":Math.random() };
				$.ajax({ data:parametros, url:'admin_apertura_cancelar_hnac.php', type:'get',
					success:function (response) { 
						window.location='admin_apertura_lista_hnactaquilla.php';
					}
				});
			} else {
				alertify.error('<font size="4">Acci�n cancelada!</font>');
			}
				 
		});	
	}
	function accionCerrar(titulo,pregunta,cCar) {
		swal({
		  title: titulo,
		  text: pregunta,
		  type: "warning",
		  showCancelButton: true,
		  cancelButtonText: "Cancelar",
		  confirmButtonClass: "btn-danger",
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Aceptar",
		  closeOnConfirm: true
		},
		function(isConfirm){
			if (isConfirm) {
				var rA=Math.random();
				var parametros = { "recordID":cCar, "rA":Math.random() };
				$.ajax({ data:parametros, url:'admin_apertura_cierre_hnac.php', type:'get',
					success:function (response) { 
						window.location='admin_apertura_lista_hnactaquilla.php';
					}
				});
			} else {
				alertify.error('<font size="4">Acci�n cancelada!</font>');
			}
		});	
	}
	function accionAumentar(titulo,pregunta, cCar, tempo, tipo) {
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
				var parametros = { "recordID":cCar, "tempo":tempo, "rA":Math.random() };
				$.ajax({ data:parametros, url:'admin_apertura_reabrir_hnac.php', type:'get',
					success:function (response) { 
						window.location='admin_apertura_lista_hnactaquilla.php';
					}
				});
			} else {
				alertify.error('<font size="4">Aumento de tiempo cancelado!</font>');
			}
		});	
	}
	function cambiarDividendo(titulo,pregunta,cDiv,mDiv,nUsu,tipo) {
		mDiv=document.getElementById(mDiv).value;
		
		if (mDiv>0) {
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
					var parametros = { "recordID":cDiv, "divpag":mDiv, "nusu":nUsu, "rA":Math.random() }
					$.ajax({ data:parametros, url:'admin_apertura_moddiv_macu.php', type:'post',
						success:function (response) { 
							window.location='admin_apertura_lista_hnactaquilla.php';
						}
					});
				} else {
					window.location='admin_apertura_lista_hnactaquilla.php';
				}
			});
		}
	}
	
	function accionPausar(titulo, pregunta, cCar, cambio, tipo, pV) {
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
				var parametros = { "cCar":cCar, "cambio":cambio, "rA":Math.random(), "pV":pV };
				$.ajax({ data:parametros, url:'ctrol_ventaspagos_carrera_hnac.php', type:'post',
					success:function (response) { 
						window.location='admin_apertura_lista_hnactaquilla.php';
					}
				});
			} else {
				if (cambio==0 && pV=="P") alertify.error('<font size="4">Pausar pagos cancelado!</font>');
				else if (cambio==1 && pV=="P") alertify.error('<font size="4">Reanudar pagos cancelado!</font>');
				else if (cambio==0 && pV=="V") alertify.error('<font size="4">Pausar ventas cancelado!</font>');
				else if (cambio==1 && pV=="V") alertify.error('<font size="4">Reanudar ventas cancelado!</font>');
			}
		});	
	}
	
	function NumCheck(e, field) {
	  key = e.keyCode ? e.keyCode : e.which
	  if (key == 8) return true
	  if (key > 47 && key < 58) {
		if (field.value == "") return true
		regexp = /.[0-9]{5}$/
		return !(regexp.test(field.value))
	  }
	  if (key == 46) {
		if (field.value == "") return false
		regexp = /^[0-9]+$/
		return regexp.test(field.value)
	  }
	  return false
	}
	$(document).ready(function(){
		if ($("#est_control_ventas_hnac").val()==0) $('#cVentas').bootstrapToggle('off');
		else $('#cVentas').bootstrapToggle('on');
		if ($("#est_control_pagos_hnac").val()==0) $('#cPagos').bootstrapToggle('off');
		else $('#cPagos').bootstrapToggle('on');
		$("#cVentas").change(function(){
			if ($(this).prop('checked')==true) {var cambio=1; $("#est_control_ventas_hnac").val("1");}
			if ($(this).prop('checked')==false) {var cambio=0; $("#est_control_ventas_hnac").val("0");}
			var parametros = {"cod_control":$("#cod_control").val(), "est_control_ventas_hnac":cambio, "est_control_pagos_hnac":$("#est_control_pagos_hnac").val()};
			$.ajax({ url:"../admin_hnac/ctrol_ventaspagos_global_hnac.php", type: "POST", data:parametros,
				success: function(){ window.location='admin_apertura_lista_hnactaquilla.php';}
			});
		});
		$("#cPagos").change(function(){
			if ($(this).prop('checked')==true) {var cambio=1; $("#est_control_pagos_hnac").val("1");}
			if ($(this).prop('checked')==false) {var cambio=0; $("#est_control_pagos_hnac").val("0");}
			var parametros = {"cod_control":$("#cod_control").val(), "est_control_ventas_hnac":$("#est_control_ventas_hnac").val(), "est_control_pagos_hnac":cambio};
			$.ajax({ url:"../admin_hnac/ctrol_ventaspagos_global_hnac.php", type: "POST", data:parametros,
				success: function(){ window.location='admin_apertura_lista_hnactaquilla.php';}
			});
		});
	});		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	</script>
</head>
<body onload="javascript:document.all.form1.focus(); scrollChat(); Javascript:history.go(1);" onunload="Javascript:history.go(1);">












<?php

    if ($totalRows_Recordset111 >=1 && $row_Recordset15['puedecerrar'] ==1) {
        ?>





  <div class="contentAdmin">
	<div style="height:70%; font-size:18px;" class="xfirefox">
       
    <?php if ($totalRows_Recordset111 >=1) { ?>

  <div style="height:70%; padding:0px 0px 2px 0px ">  
  <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">


  <?php
  $k=1;
  do {
      if ($totalRows_Recordset111 >=1 && $row_Recordset15['puedecerrar'] >=1 && $row_Recordset111['est_cierre_hnac']==3) {
          $van=$row_Recordset111['can_caballos_hnac']-cantRetirados_hnac($row_Recordset111['cod_carrera_hnac']);
          if ($row_Recordset111['mtp_control_hnac']==0) {
              $carrA='<font color="red">'.$row_Recordset111['nom_hipodromo_hnac'].': ...'.$row_Recordset111['num_carrera_hnac'].'</font>';
          } else {
              $carrA='<font color="green">'.$row_Recordset111['nom_hipodromo_hnac'].': ...'.$row_Recordset111['num_carrera_hnac'].'</font>';
          } ?>
  <tr bgcolor="#FFFFFF" onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"; style="font-size:14px;border-bottom: 1px solid #C1BDBE;">
    <td>
                  <a href='../ventashnac_mie/carrera_cierre_hnac.php?recordID=<?php echo $row_Recordset111['cod_carrera_hnac']; ?>'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px; color:#000">
                  	<div style="padding:10px 0px 0px 0px">CERRAR AQUI</div>
                  </a>   
        
      </td>
    <td width="170" align="left">
    <?php
    echo '<strong>'.$carrA.'</strong>';
          $vepa="";
          if ($row_Recordset111['pau_pagos_hnac']==1 && $row_Recordset111['pau_ventas_hnac']==0) {
              $vepa="&nbsp;&nbsp;(PAGOS PAUSADOS)";
          } elseif ($row_Recordset111['pau_pagos_hnac']==0 && $row_Recordset111['pau_ventas_hnac']==1) {
              $vepa="&nbsp;&nbsp;(VENTAS PAUSADAS)";
          } elseif ($row_Recordset111['pau_pagos_hnac']==1 && $row_Recordset111['pau_ventas_hnac']==1) {
              $vepa="&nbsp;&nbsp;(VENTAS Y PAGOS PAUSAD0S)";
          }
          echo '<font color="red"  style="font-size:10px;"><br/>'.$vepa.'</font>' ; ?>
    </td>
    <?php
    $status="";
          if ($row_Recordset111['est_carrera_hnac']==0 && $row_Recordset111['est_cierre_hnac']==2) {
              $status="<font color=\"red\">CERRADA AUTOMATICO</font>";
          }
          if ($row_Recordset111['est_carrera_hnac']==0 && $row_Recordset111['est_cierre_hnac']==1) {
              $status="<font color=\"red\">CERRADA MANUAL</font>";
          }
          if ($row_Recordset111['est_carrera_hnac']==0 && $row_Recordset111['est_cierre_hnac']==0) {
              $status="<font color=\"red\">CANCELADA</font>";
          }
          if ($row_Recordset111['hor_carrera_hnac']>horaactual2() && $row_Recordset111['est_carrera_hnac']==1 &&
        $row_Recordset111['est_cierre_hnac']==3) {
              $status="<font color=\"green\">ABIERTA</font>";
          }
          if ($row_Recordset111['hor_carrera_hnac']<=horaactual2() && $row_Recordset111['est_carrera_hnac']==1 && $row_Recordset111['est_cierre_hnac']==3) {
              $status="<font color=\"orange\">PRE-CERRADA</font>";
          }
          if ($row_Recordset111['est_carrera_hnac']==5 && $row_Recordset111['est_cierre_hnac']==5) {
              $status="<font color=\"gray\">EN ESPERA</font>";
          } ?>
    <td align="center">
      <?php
        if ($van<=3) {
            echo '<font color="red">'.$van."/".$row_Recordset111['can_caballos_hnac'].'</font>';
        } else {
            echo $van."/".$row_Recordset111['can_caballos_hnac'];
        } ?>
      </td>
    <td align="center">
      <?php echo $status; ?>      </td>
    
    <td align="center"><?php if ($row_Recordset111['hor_carrera_hnac']>horaactual2()) {
            echo restahoraRB(horaactual2(), $row_Recordset111['hor_carrera_hnac']);
        } ?>
      </td>








  </tr>
  <?php
    $k++;
      }
  } while ($row_Recordset111 = mysqli_fetch_assoc($Recordset111)); ?>
    </table>
    </div>
    <?php } ?>
		
        
 
  </div> 
  </div>
  <input type="hidden" name="cod_control" id="cod_control" value="<?php echo $cod_control; ?>" />
    

  </div>





<?php
    }
?>	

















<font size="6" style="color:red;" align="center"><?php echo $mensaje44;?></font>


   <div id="container" class="container">
		<div id="header" class="header" style="background: #0E5157">
            <?php include("../includes/cabeceraventashnacP.php");?>
		</div>
		<div id="content" class="content" style="border:3px solid #0E5157;">
			<div id="taquilla" class="taquilla">
                <div id="datos" class="datos" style="background:#333; width:250px;float:left;">
					TAQUILLA DE VENTAS: <?php echo strtoupper($row_Recordset5['nom_taquilla']); ?>
				</div>
											                          


																	  
																	  
																	  
																	  
																	  
																	  
																	  



					
<div style="float:left; font-size:26px;padding:3px 0px 0px 0px; color:#CF0;width:309px;background:#333;">&nbsp;
                	<?php echo "CARRERAS NACIONALES";?>
				</div>

							
							
								
							
							
							
							
							
							
							
							
							
							
							
							
							
							
                <div id="usuario" class="usuario" style="background:#333; width:250px; float:left">

				
<?php if ($tipotaquilla==1) {?>

SALDO DISPONIBLE: <?php echo $saldoactual." | "; ?>
<?php }?>
TAQUILLA EN
<?php if ($row_Recordset6['moneda']==0) {
    echo 'BOLIVARES | ';
}?> 
 <?php if ($row_Recordset6['moneda']==1) {
    echo 'DOLARES | ';
}?> 
 <?php if ($row_Recordset6['moneda']==2) {
    echo 'PESOS COL | ';
}?> 
  <?php if ($row_Recordset6['moneda']==3) {
    echo 'SOLES PER | ';
}?> 
   <?php if ($row_Recordset6['moneda']==10) {
    echo 'MULTIMONERDA | ';
}?>
					<?php echo "Usuario: ".strtoupper($row_Recordset5['nom_completo']); ?> | <?php echo vfechaActual(); ?>
 				</div>
            </div>
			
			
		
		
		
            <div id="mensaje" class="mensaje">
			
			
			
			
			
			

		
		
		
		
		
                <?php echo $mensaje1; ?><BR/><?php echo $_SESSION['MM_mensaje3'];?>
            </div>
                <?php $wJu=16;	$wCa=6;	$tSho="text";	$tPla="text";	$tGan="text";
                $iDiv=45;	$dDiv=31;	$un=7;	$do=35;	$tr=4;	$cu=15;	$ci=20;	$se=18;
                if ($est_sho==0) {
                    $tSho="hidden";
                    $wJu+=5.5;
                    $wCa+=1.5;
                    $un+=1;
                    $do+=4;
                    $tr+=0;
                    $cu+=10;
                }
                if ($est_pla==0) {
                    $tPla="hidden";
                    $wJu=$wJu+7;
                    $wCa=$wCa+3;
                    $un+=8;
                    $do+=8;
                    $tr+=0;
                }
                $wJu.="%"; $wCa.="%"; $iDiv.="%"; $dDiv.="%";
                ?>

            <div id="jugada" class="jugada" style="height:75%; width:100%">
 				<div id="izquierda" class="izquierda" style="width:<?php echo $iDiv;?>">
					
					
					
					
					
					
					
					
					
					
					
					
					<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"
						onsubmit="return chequearEnvio();">
                        <div id="men_canticket" style="font-size:16px; background: #333; width:82.9%; float:left; height:17px; 
                            text-align:right; padding:12px 2px 2px 2px; color:#FFF; font-size:12px;">
                            <div style="background:#333; width:34%; float:left; text-align: left; padding:5px 0px 0px 1%">
                            HIP�DROMO/CARRERA
                            </div>
                                Ticket creados por Vendedor:
                        </div><!-- end .men_canticket -->
			<div style="color:red; font-size:25px">
				<?php
				if ($row_Recordset6['24hr'] == 0 && $nuevahora1 > $row_Recordset6['hor_fin'] OR $nuevahora1 < $row_Recordset6['hor_inicio']) {
				echo 'TAQUILLA CERRADA <br> HORARIO DE VENTAS DE ' .$row_Recordset6['hor_inicio'] .'AM A '.$row_Recordset6['hor_fin']. 'PM'. '<br> COMUNIQUESE CON SU AGENTE';
				}
				else {
				?>
			</div>
                        <div id="mon_canticket" style="font-size:24px; background:#333; width:14.1%; float:left; height:27px;
                                text-align:left; padding:2px 1% 2px 1%; color: #F00;">
                                <?php include("../includes/infoNumeroTicket_hnac.php");?>
                        </div><!-- end .mon_canticket -->
                        <div id="hipodromo" style="font-size:18px; float:left; width:100%; height:35px;background:#333">
                        <?php
                        if ($t>0 && isset($cod)) {?>
                        	<select name="cod_carrera" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;"
                        		style="font-size:20px; width:100%; height:35px"
                        		onChange="pizActual(this);javascript:document.getElementById('numCa44').focus()">
                        		<option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                        			<?php echo "SELECCIONE HIP�DROMO AQU�";?>
                        		</option><?php
                                foreach ($cod as $cod_carrera) {?>
                                    <option value="<?php echo $cod_carrera;?>" 
                                        <?php if (!(strcmp(
                    htmlentities($cod_carrera, ENT_COMPAT, 'utf-8'),
                    $_SESSION['selCarrera']
                ))) {
                                    echo "selected=\"selected\"";
                                }?>>
                                        <?php echo $carrera[$x];?>
                                    </option><?php
                                $x++;
                                }?>
                        	</select><?php
                        } else {
                            $_SESSION['selCarrera']=-1; //#e0e0e0?>
                        	<select name="cod_carrera2" 
                        		tabindex="1" style="font-size:20px;width:100%;height:35px" disabled="disabled">
                        		<option value="-1" > <?php echo "En estos momentos no existen carreras abiertas"; ?></option>
                        	</select>
						<?php
                        }?>
						</div><!-- end .hipodromo -->
                        <div id="centroapuesta" class="centroapuesta" style="font-size:22px; width:100%; float:left">
                            <div style="background:#e0e0e0;float:left;width:2%;height:150px; padding:30px 0px 10px 0px ">
								<img src="../img/permutahnac.png" width="16" height="150" />	
							</div>
                            <div style="background:#e0e0e0; width:98%; float:left;height:28px;text-align:center;color:#000;">
                                <div style="float:left; width:<?php echo $un; ?>%">&nbsp;</div>
                                <div style="float:left; width:<?php echo $do; ?>%;">EJEMPLARES</div>
                                <div style="float:left; width:<?php echo $tr; ?>%">&nbsp;</div>
                                <div style="float:left; width:<?php echo $cu; ?>%;">GAN</div>
                                <div style="float:left; width:<?php echo $ci; ?>%;">PLA</div>
                                <div style="float:left; width:<?php echo $se; ?>%;">SHO</div>
                            </div>
                            <div id="apuesta" class="apuesta" style="float:left; font-size:18px; width:98%"><?php
                                $x=1;
                                for ($i = 1; $i <= 4; $i++) {?>
                            		<div style="margin:1px 0px 0px 5px; height:40px; background:#e0e0e0; width:98%">
                                        <input type="checkbox" name="<?php echo "per".$i; ?>" size="20" id="<?php echo "per".$i; ?>"
                                        onclick="clean(),clean2()" onchange="clean(),clean2()"
                                        onKeyDown="return handleEnter(this, event)"/>
                                        
                                        <input class="textbox" tabindex="<?php echo $x;?>" onchange="clean(),clean2()"
                                        type="text" name="<?php echo "numCa1".$i;?>" style="width:<?php echo $wCa;?>; font-size:20px" 
                                        maxlength="2" value="" id="<?php echo "numCa1".$i;?>" 
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" title="indique nro de ejemplar"
                                        onblur=""/>
                                         
                                        <input class="textbox" tabindex="<?php echo $x+1;?>" type="text" onchange="clean(),clean2()"
                                        name="<?php echo "numCa2".$i;?>" style="width:<?php echo $wCa;?>; font-size:20px"
                                        onkeypress="javascript:return validarNro(event)" onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)"
                                        onblur=""
                                        maxlength="2" value="" id="<?php echo "numCa2".$i;?>"
                                        title="indique nro de ejemplar"/>
                                         
                                        <input class="textbox" tabindex="<?php echo $x+2;?>" type="text" onchange="clean(),clean2()"
                                        name="<?php echo "numCa3".$i;?>" onkeypress="javascript:return validarNro(event)" 
                                        onclick="clean(),clean2()" onKeyDown="return handleEnter(this, event)"
                                        title="indique nro de ejemplar" maxlength="2" value=""
                                        style="width:<?php echo $wCa;?>; font-size:20px" id="<?php echo "numCa3".$i;?>"/>
                                         
                                        <input class="textbox" tabindex="<?php echo $x+3;?>" type="text" onchange="clean(),clean2()" 
                                        name="<?php echo "numCa4".$i;?>" onkeypress="javascript:return validarNro(event)" 
                                        onclick="clean(),clean2()" 
                                        onKeyDown="return handleEnter(this, event)" style="width:<?php echo $wCa;?>; font-size:20px"
                                        maxlength="2" value="" id="<?php echo "numCa4".$i;?>"
                                        title="indique nro de ejemplar"/> -
                                         
                                        <input class="textbox" tabindex="<?php echo $x+4;?>" 
                                        onkeypress="javascript:return validarNro(event)" type="<?php echo $tGan;?>" 
                                        name="<?php echo "monGan".$i; ?>" onKeyDown="return handleEnter(this, event)"
                                        onclick="clean(),clean2()" title="indique monto" onchange="clean(),clean2()"
                                        onblur="rangoNumeros('<?php echo "monGan".$i;?>',<?php echo $apMinGan;?>,<?php echo $apGaMax; ?>)"
                                        style="width:<?php echo $wJu;?>; font-size:19px" maxlength="8"value="" id="<?php echo "monGan".$i;?>"/>
                                         
                                        
									</div><!-- end .apuesta --><?php
                                    $x=$x+7;
                                }?>
							</div><!-- end .apuesta -->
                            <div id="realizarapuesta" style="padding:10px 0px 0px 0px;float:left; width:100%;">
                                <input type="submit" id="imprimir" name="imprimir" tabindex="<?php echo $x+5;?>"
                                value="REALIZAR APUESTA E IMPRIMIR" style="width:55%; font-size:17px; height:45px"
                                title="realiza apuesta"
                                <?php if ($totalRows_Recordset1==0 || $est_control_ventas==1) {
                                    echo 'disabled="disabled"';
                                } ?>/>
<?php if ($row_Recordset6['moneda']<=5) {
                                    ?><input type="hidden"  name="efectivoOn"  value="<?php

if ($row_Recordset6['moneda']==0) {
    echo "0";
}
                                    if ($row_Recordset6['moneda']==1) {
                                        echo "3";
                                    }
                                    if ($row_Recordset6['moneda']==2) {
                                        echo "4";
                                    }
                                    if ($row_Recordset6['moneda']==3) {
                                        echo "5";
                                    } ?>" />
 <?php
                                }



if ($row_Recordset6['moneda']==10) {
    if (!isset($_SESSION['efectivoOnx'])) {
        $_SESSION['efectivoOnx']=-1;
    } ?>

<select name="efectivoOn" style="width:175px; font-size:20px; background:#C00; color:#FFFFFF; height:45px" class="textbox" tabindex="3">
	  <option value="0" <?php if ($_SESSION['efectivoOnx']=='0') {
        echo 'SELECTED';
    } ?>>Efectivo Bss</option>
	  <option value="1" <?php if ($_SESSION['efectivoOnx']=='1') {
        echo 'SELECTED';
    } ?>>Debito Bss</option>
	  <option value="2" <?php if ($_SESSION['efectivoOnx']=='2') {
        echo 'SELECTED';
    } ?>>Transferencia Bss</option>
	  <option value="3" <?php if ($_SESSION['efectivoOnx']=='3') {
        echo 'SELECTED';
    } ?>>Dolar Americano</option>
	  <option value="4" <?php if ($_SESSION['efectivoOnx']=='4') {
        echo 'SELECTED';
    } ?>>Peso Colombiano</option>
	  <option value="5" <?php if ($_SESSION['efectivoOnx']=='5') {
        echo 'SELECTED';
    } ?>>Sol Peruano</option>
</select>

						  
<?php
} ?>
                            </div><!-- end .realizarapuesta -->
				<?php
				}
				?>
                            <div id="recargar" style="padding:10px 0px 0px 0px;float:left; width:100%">
                                <input type="button" onclick="window.location='index.php';"
                                value="ACTUALIZAR P�GINA" style="width:70%; font-size:20px; height:45px"
                                tabindex="<?php echo $x;?>" title="actualiza p�gina"/>
                            </div><!-- end .realizarapuesta -->

                        </div><!-- end .centroapuesta -->
						<input type="hidden" name="MM_insert" value="form1" />
						<input type="hidden" name="ser_venta" value="" />
						<input type="hidden" name="ticket" value="" />
						<input type="hidden" name="cod_taquilla" id="ctaq" value="<?php echo $row_Recordset5['cod_taquilla'];?>"/>
						<input type="hidden" name="fec_venta" value=""/>
						<input type="hidden" name="hor_venta" value="" />
						<input type="hidden" name="id_usuario" value="" />
                        <input type="hidden" id="idus" value="<?php echo $usuarioVenta; ?>" />
						<input type="hidden" name="est_ticket" value="1" />
						<input type="hidden" name="est_gan" value="<?php echo $est_gan; ?>" />
						<input type="hidden" name="est_pla" value="<?php echo $est_pla; ?>" />
						<input type="hidden" name="est_sho" value="<?php echo $est_sho; ?>" />
						<input type="hidden" name="est_exa" value="<?php echo $est_exa; ?>" />
						<input type="hidden" name="est_tri" value="<?php echo $est_tri; ?>" />
						<input type="hidden" name="est_sup" value="<?php echo $est_sup; ?>" />
						<input type="hidden" name="apMinGan" value="<?php echo $apMinGan; ?>" />
						<input type="hidden" name="apMinPla" value="<?php echo $apMinPla; ?>" />
						<input type="hidden" name="apMinSho" value="<?php echo $apMinSho; ?>" />
						<input type="hidden" name="apMaxGan" value="<?php echo $apGaMax; ?>" />
						<input type="hidden" name="apMaxPla" value="<?php echo $apPlMax; ?>" />
						<input type="hidden" name="apMaxSho" value="<?php echo $apShMax; ?>" />
						<input type="hidden" name="apMinExa" value="<?php echo $apMinExa; ?>" />
						<input type="hidden" name="apMinTri" value="<?php echo $apMinTri; ?>" />
						<input type="hidden" name="apMinSup" value="<?php echo $apMinSup; ?>" />
						<input type="hidden" name="apMaxExa" value="<?php echo $apExMax; ?>" />
						<input type="hidden" name="apMaxTri" value="<?php echo $apTrMax; ?>" />
						<input type="hidden" name="apMaxSup" value="<?php echo $apSuMax; ?>" />
						<input type="hidden" name="monMaxTi" value="<?php echo $monMaxTi; ?>" />
						<input type="hidden" name="monMaxEj" value="<?php echo $monMaxEj; ?>" />
						<input type="hidden" name="ejeMinC" id="ejeMinC" value="<?php echo $ejeMinCar; ?>" />
					</form>


















                </div><!-- end .izquierda -->
                <div id="centro" style="font-size:16px;width:22.9%;float:left; background:#e0e0e0;height:386px;
                    margin:0px 0px 0px 2px; color:#000">
					<div id="men_pagar" style="font-size:12px; background: #333;width:99.3%; float:left; height:13px; 
						text-align: left; padding:1px 0px 0px 3px; color: #FFF; line-height:13px;border-bottom: 1px black solid;">
						Última jugada realizada:
					</div><!-- end .men_pagar --> 
					<div id="men_pagar" style="font-size:10px; background: #333;width:99.3%; float:left; height:85px; 
						text-align: left; padding:0px 0px 0px 3px; color: #FFF;border-bottom: 1px black solid;">
						<?php include("ventas_ver_ultimoD.php");?>
					</div><!-- end .men_pagar --> 
					<div id="men_pagar" style="font-size:16px; background: #333;width:99.3%; float:left; height:20px; 
						text-align:center; padding:9px 0px 0px 3px; color: #FFF">
						PAGAR/ELIMINAR APUESTA
					</div><!-- end .men_pagar -->


                    <div id="pagarapuesta" style="font-size:14px; width:99.3%; height:70.6%; float:left; text-align:center; 
                        padding:15px 0px 0px 3px;">
                        <form method="post" id="form2"><?php
                            if ($pedirCodigoPago==0) {?>
                                <br/>
                                <div id="codigoTicket" style="height:50px; width:95%; float:left; margin:0px 0px 0px 0px;">
                                                               </div>
                                <div id="pagaTicket" style="height:70px; width:95%; float:left; padding:8px 0px 0px 0px;">
                                    <input type="button" style="width:180px; font-size:18px; height:40px" value="Ir a pagar apuesta" 
                                    onclick="javascript:window.open('pag_tic_hnac.php?uVenta=<?php echo $usuarioVenta?>', '_blank');" <?php if ($est_control_pagos==1) {
                                    echo 'disabled="disabled"';
                                } ?>/>                                </div>
                                <div id="eliminaTicket" style="height:70px; width:95%; float:left; padding:10px 0px 0px 0px;">
                                    <input type="button" style="width:180px; font-size:18px; height:40px" value="Ir a Eliminar Ticket" 
                                    onclick="javascript:window.open('eli_tic_hnac.php?uVenta=<?php echo $usuarioVenta?>', '_blank');" <?php if ($est_control_pagos==1) {
                                    echo 'disabled="disabled"';
                                } ?>/>                                </div>
                                <input type="hidden" name="id_usuario_pago" value="<?php echo $usuarioVenta; ?>" />
                                <?php
                            } else {?>
                            	<div id="pagaTicket" style="height:70px; width:95%; float:left; padding:88px 0px 0px 0px;">
                                	<input type="button" style="width:180px; font-size:18px; height:40px" 
                                    	value="Ir a pagar apuesta" 
                                    	onclick="javascript:window.open('pag_tic_sincodigo_hnac.php?uVenta=<?php echo $usuarioVenta?>', '_blank');" <?php if ($est_control_pagos==1) {
                                echo 'disabled="disabled"';
                            } ?>/>
                                </div>
								<div id="eliminaTicket" style="height:70px; width:95%; float:left; padding:40px 0px 0px 0px;">
                                	<input type="button" style="width:180px; font-size:18px; height:40px" 
                                    	value="Ir a eliminar ticket" 
                                    	onclick="javascript:window.open('eli_tic_sincodigo_hnac.php?recordID=<?php echo $pedirCodigoPago?>&uVenta=<?php echo $usuarioVenta?>', '_blank');"/>
                                </div>
                            	<?php //#e0e0e0;
                            }?>
                        </form>
                    </div><!-- end .pagarapuesta -->
                  <div id="pagamensaje" style="height:150px; width:220px; float:left; color:#CC0000; 
                        text-align:center; margin:-200px  0px 0px 3px; line-height:16px;
                        background:#e0e0e0;display:none">  
                  </div>
				</div>
                <div id="derecha" style="font-size:16px;width:<?php echo $dDiv;?>;float:left;background:#e0e0e0;height:386px;
                	background: #333;margin:0px 0px 0px 0.3%; color:#FFF; border-left:1px black solid; 
                    border-right:1px black solid;">PIZARRA<br/>
                    <?php
                    if (isset($row51['cod_carrera_hnac']) or isset($cod)) {?>
                    <form method="post" id="form3">
					<select name="carreraAnt" onchange="pizActual(this);" id="carreraAnt"
                    style="width:99%; height:30px; font-size:16px;background-color:#333; color:#fff;">
						<option value="-1" style="background: #000; color:#FFFFFF;">
							<?php echo "SELECCIONE";?>
						</option><?php
                    do {?>
						<option value="<?php echo $row51['cod_carrera_hnac'];?>" style="background: #000; color:#FFFFFF;"
						<?php if (!(strcmp($_SESSION['selCarrera'], htmlentities($row51['cod_carrera_hnac'], ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>> <?php echo $row51['carrera'];?>
						</option>
					<?php
                    } while ($row51 = mysqli_fetch_assoc($Recordset51));?>
					</select>
                    <input type="hidden" name="codigo" value="" />
                    <input type="hidden" name="taquilla" value="<?php echo $taquilla; ?>" />
                    <input type="hidden" name="usuario" value="<?php echo $usuarioVenta; ?>" />
                    <input type="hidden" name="nomtaquilla" value="<?php echo $nombredetaquilla; ?>" />
                    <input type="hidden" name="nomcompleto" value="<?php echo $nomcompleto; ?>" />
                    </form>
                    <?php } else {
                        echo "<h3 style='background: #333; color: #333'>-</h3>";
                    }?>
                    <div id="impPiza" style="width:100%; height:300px">
                    	<?php include("pizarra_actual.php");?>
					</div>
				</div>
			</div><!-- end .jugada -->
		</div><!-- end .content -->




 <div id="mensajeChat" style="font-size:16px; height:177px; width:100%; float:left; 
                    	text-align:center; padding:0px 0px 0px 0px;">
                        
                        <div id="membreteChat" style="font-size:12px; height:18px; width:99.5%; float:left; text-align:left; 
                    		padding:10px 0px 0px 5px; color: #FFF; background:#23528c; border-top-style: 
                        	solid;border-top-width: thin; border-top-color: #FFF;">
                            Por favor, ante cualquier duda o inconveniente env�enos un mensaje por este medio,
                             ser� respondido en breve
                        </div><!-- end .membreteChat -->
                        <div id="Chat" style="font-size:11px; height:90px; width:100%; float:left; text-align:left; 
                    		padding:0px 0px 0px 0px; background: #FFF; margin:0px 0px 0px 0px; overflow: auto;
                            position: relative;z-index: 0;" onmouseover="stopChat()" onmouseout="startChat()" >
	                            <?php include("chat_mostrar_hnac.php");?>


                        </div><!-- end .Chat -->
                        <form method="post" id="form4">
                            <div id="enviarChat" style="font-size:18px; height:50px; width:89.6%; float:left; text-align:left; 
                                padding:0px 0px 0px 0px;">
                                <textarea id="txtMensaje" name="txtMensaje" placeholder="ESCRIBA SU MENSAJE AQU�" 
                                style="width:98%; height:50px; overflow: auto;resize:none; border: 1px solid #888; font-size:12px;
                                font-family: Arial, Helvetica, sans-serif;"></textarea>
                            </div><!-- end .Chat -->
                            <div id="enviarBoton" style="font-size:14px; height:50px; width:98px; float:RIGHT; text-align: center; 
                                padding:5px 0px 0px 0px; border-top: 1px solid #888;">
                                <input name="enviarChatBoton" type="button" id="enviarChatBoton" 
                                    style="height:45px; background: #CCC; border-color:#CCC; color: #333"
                                    tabindex="<?php echo $x;?>" 
                                    value="ENVIAR"/>
                            </div><!-- end .Chat -->
                            <input type="hidden" name="cod_taquilla_chat" value="<?php echo $taquilla; ?>" />
                            <input type="hidden" name="nom_usuario_chat" value="<?php echo $_SESSION['MM_Username']; ?>" />
                        </form>    

              </div><!-- end .mensajeChat --> 



        <div class="footer" style="background:#0E5157"><!-- end .footer --></div>
    </div><!-- end .container -->
</body>
</html>
<script language="javascript">document.getElementById("numCa44").focus();</script>
<?php if ($iR==0) {
                        $_SESSION['MM_mensaje3']=$row_Recordset4['seg_linea'];
                    }
mysqli_free_result($Recordset1);mysqli_free_result($Recordset4);mysqli_free_result($Recordset5);


?>
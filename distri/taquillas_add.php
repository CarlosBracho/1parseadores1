<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$graba=0;
include("../includes/taquilla_estandar.php");


$editFormAction = $_SERVER['PHP_SELF'];
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction2 .= htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_POST['cod_agencia']) && $_POST['cod_agencia']==0) {
    $menAgen="indique agente";
    $graba--;
}
if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
    if (isset($_POST["exp_agencia"]) && $_POST["exp_agencia"]>0) {
        $xCodigo=$_POST["exp_agencia"];
        $query_Recordset4 =  sprintf(
            "/* PARSEADORES1 distri\taquillas_add.php - QUERY 1 */ SELECT  
		tp.pag_codigo, tp.apu_maxgan, tp.apu_maxpla, tp.apu_maxsho, tp.apu_maxexa, tp.apu_maxtri, tp.apu_maxsup, tp.apu_mingan,
		tp.apu_minpla, tp.apu_minsho, tp.apu_minexa, tp.apu_mintri, tp.apu_minsup, tp.reg_gan, tp.reg_pla, tp.reg_sho, tp.reg_exa,
		tp.reg_tri, tp.reg_sup, tp.est_gan, tp.est_pla, tp.est_sho, tp.est_exa, tp.est_tri, tp.est_sup, tp.max_aganar_gan,
		tp.max_aganar_pla, tp.max_aganar_sho, tp.max_aganar_exa, tp.max_aganar_tri, tp.max_aganar_sup, tp.mon_maxticket, 
		tp.mon_maxejemplar, tp.min_ejecarrera, tp.cod_taopcame, tp.por_taquilla, tp.est_impresion, tp.anu_regalia, tp.tic_caduca,
		tp.tip_ticket, tp.tie_reclamo, tp.ver_porpagar
			FROM taquilla ta, taquilla_opc_ame tp 
			WHERE ta.cod_taquilla = %s AND tp.cod_taquilla = ta.cod_taquilla
			LIMIT 1",
            GetSQLValueString($xCodigo, "int")
        );
        $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
        $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
        $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
        $apu_mingan=$row_Recordset4['apu_mingan'];
        $apu_maxgan=$row_Recordset4['apu_maxgan'];
        $reg_gan=$row_Recordset4['reg_gan'];
        $max_aganar_gan=$row_Recordset4['max_aganar_gan'];
        $est_gan=$row_Recordset4['est_gan'];
        $est_pla=$row_Recordset4['est_pla'];
        $est_sho=$row_Recordset4['est_sho'];
        $anu_regalia=$row_Recordset4['anu_regalia'];
        $ver_porpagar=$row_Recordset4['ver_porpagar'];
        $tie_reclamo=$row_Recordset4['tie_reclamo'];
        $tic_caduca=$row_Recordset4['tic_caduca'];
        $mon_maxejemplar=$row_Recordset4['mon_maxejemplar'];
        $tip_ticket=$row_Recordset4['tip_ticket'];
        $min_ejecarrera=$row_Recordset4['min_ejecarrera'];
        $pag_codigo=$row_Recordset4['pag_codigo'];
        $est_impresion=$row_Recordset4['est_impresion'];
        $mon_maxticket=$row_Recordset4['mon_maxticket'];
        $apu_minpla=$row_Recordset4['apu_minpla'];
        $apu_maxpla=$row_Recordset4['apu_maxpla'];
        $reg_pla=$row_Recordset4['reg_pla'];
        $max_aganar_pla=$row_Recordset4['max_aganar_pla'];
        $apu_minsho=$row_Recordset4['apu_minsho'];
        $apu_maxsho=$row_Recordset4['apu_maxsho'];
        $reg_sho=$row_Recordset4['reg_sho'];
        $max_aganar_sho=$row_Recordset4['max_aganar_sho'];
        $apu_minexa=$row_Recordset4['apu_minexa'];
        $apu_maxexa=$row_Recordset4['apu_maxexa'];
        $reg_exa=$row_Recordset4['reg_exa'];
        $max_aganar_exa=$row_Recordset4['max_aganar_exa'];
        $est_exa=$row_Recordset4['est_exa'];
        $apu_mintri=$row_Recordset4['apu_mintri'];
        $apu_maxtri=$row_Recordset4['apu_maxtri'];
        $reg_tri=$row_Recordset4['reg_tri'];
        $max_aganar_tri=$row_Recordset4['max_aganar_tri'];
        $est_tri=$row_Recordset4['est_tri'];
        $apu_minsup=$row_Recordset4['apu_minsup'];
        $apu_maxsup=$row_Recordset4['apu_maxsup'];
        $reg_sup=$row_Recordset4['reg_sup'];
        $max_aganar_sup=$row_Recordset4['max_aganar_sup'];
        $est_sup=$row_Recordset4['est_sup'];
    }
}

$query_Recordset94 =  sprintf(
  "/* PARSEADORES1 distri\taquillas_add.php - QUERY 2 */ SELECT
sinomonedadistri 
FROM banca
WHERE cod_banca= %s",
GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset94 = mysqli_query($conexionbanca, $query_Recordset94) or die(mysqli_error($conexionbanca));
$row_Recordset94 = mysqli_fetch_assoc($Recordset94);
$totalRows_Recordset94 = mysqli_num_rows($Recordset94);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    $control=0;
    $contron=0;
    $hora_ini=$_POST['hor_in'].":".$_POST['min_in'].":".$_POST['am_in'];
    $hora_fin=$_POST['hor_fi'].":".$_POST['min_fi'].":".$_POST['am_fi'];
    $hora_ini=horamysql($hora_ini);
    $hora_fin=horamysql($hora_fin);
    if (isset($_POST['nom_taquilla']) && $_POST['nom_taquilla']!="") {
        if (buscaTaq($_POST['nom_taquilla'])>0) {
            $menTaq="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_taquilla']=="" || strlen($_POST['nom_taquilla'])<=3) {
        $menTaq="nombre no válido";
        $graba--;
    }
    
    if (isset($_POST['nom_usuario']) && $_POST['nom_usuario']!="") {
        if (buscaUsu($_POST['nom_usuario'])>0) {
            $menNus="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_usuario']=="" || strlen($_POST['nom_usuario'])<=3) {
        $menNus="nombre no válido";
        $graba--;
    }
    if ($_POST['pas_usuario']=="" || strlen($_POST['pas_usuario'])<=3) {
        $menPass="debe contener 4 caracteres o mas";
        $graba--;
    }
    if ($hora_ini>$hora_fin || $hora_ini==$hora_fin) {
        $menHin="error en horas";
        $graba--;
    }
    if (isset($_POST['dia7'])) {
        $trabaja="1";
    } else {
        $trabaja="0";
    }
    if (isset($_POST['dia1'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia2'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia3'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia4'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia5'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    if (isset($_POST['dia6'])) {
        $trabaja=$trabaja."-1";
    } else {
        $trabaja=$trabaja."-0";
    }
    $graba--;
}
    if ($graba==30) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 distri\taquillas_add.php - QUERY 3 */ INSERT 
				INTO taquilla 
				(nom_taquilla, nom_representante, tel_taquilla, tel_taquilla2, tel_taquilla3, cod_agencia, 
taq_vende_ame,
taq_por_ame,
taq_vende_hnac,
taq_cob_hnac,
moneda,
				est_taquilla) 
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_taquilla']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_representante']), "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString($_POST['tel_taquilla2'], "text"),
            GetSQLValueString($_POST['tel_taquilla3'], "text"),
            GetSQLValueString($_POST['cod_agencia'], "int"),
            GetSQLValueString($_POST['taq_vende_ame'], "int"),
            GetSQLValueString($_POST['taq_por_ame'], "double"),
            GetSQLValueString($_POST['taq_vende_hnac'], "int"),
            GetSQLValueString($_POST['taq_cob_hnac'], "double"),
	    GetSQLValueString($_POST['moneda'], "int"),
            GetSQLValueString(1, "int")
        );// estatus de taquilla
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        
        $query_RecT = "/* PARSEADORES1 distri\taquillas_add.php - QUERY 4 */ SELECT cod_taquilla FROM taquilla ORDER BY cod_taquilla DESC LIMIT 1";
        $RecT = mysqli_query($conexionbanca, $query_RecT) or die(mysqli_error($conexionbanca));
        $row_RecT = mysqli_fetch_assoc($RecT);
        $totalRows_RecT = mysqli_num_rows($RecT);
        $codTaquilla=$row_RecT['cod_taquilla'];
        
        
        $insertSQL3 = sprintf(
            "/* PARSEADORES1 distri\taquillas_add.php - QUERY 5 */ INSERT 
		INTO usuario 
		(nom_usuario, nom_completo, tip_usuario, cod_taquilla, pas_usuario, est_usuario, tic_eliminados, cod_barra, 
		hor_inicio, hor_fin, dia_entrada, niv_acceso, ini_programa) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_usuario']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_completo']), "text"),
            GetSQLValueString($_POST['tip_usuario'], "text"),
            GetSQLValueString($codTaquilla, "int"),
            GetSQLValueString($_POST['pas_usuario'], "text"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['tic_eliminados'], "int"),
            GetSQLValueString($_POST['cod_barra'], "int"),
            GetSQLValueString($hora_ini, "date"),
            GetSQLValueString($hora_fin, "date"),
            GetSQLValueString($trabaja, "text"),
            GetSQLValueString(1, "int"),
            GetSQLValueString($_POST['ini_programa'], "int")
        );
        $Result3 = mysqli_query($conexionbanca, $insertSQL3) or die(mysqli_error($conexionbanca));
        $insertGoTo = "../distri/taquillas_edit.php?recordID=".$codTaquilla;

        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }

$query_Recordset2 = sprintf(
    "/* PARSEADORES1 distri\taquillas_add.php - QUERY 6 */ SELECT ag.cod_agencia, ag.nom_agencia,
ba.dist_vende_ame,
ba.dist_vende_hnac
FROM banca ba, agencia ag
WHERE ag.cod_banca = ba.cod_banca AND ba.cod_banca = %s ORDER BY ag.nom_agencia",
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
$query_Recordset3 = sprintf(
    "/* PARSEADORES1 distri\taquillas_add.php - QUERY 7 */ SELECT ta.cod_taquilla, ta.nom_taquilla,
ba.dist_vende_ame,
ba.dist_vende_hnac
FROM taquilla ta, taquilla_opc_ame tp, agencia ag, banca ba 
WHERE ta.cod_taquilla = tp.cod_taquilla AND ag.cod_agencia = ta.cod_agencia AND 
ba.cod_banca = ag.cod_banca AND ba.cod_banca = %s
ORDER BY nom_taquilla",
    GetSQLValueString($_SESSION['MM_cod_banca'], "int")
);
$Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
$dist_vende_ame2=$row_Recordset3['dist_vende_ame']/1;
$dist_vende_hnac2=$row_Recordset3['dist_vende_hnac']/1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<style>
  .textbox, .textboxsmal {
  border: 1px solid #DBE1EB;
  font-size: 18px;
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
  height:20px;
  }
  .textbox:focus, .textboxsmal:focus {
  color: #2E3133;
  border-color: #FBFFAD;
  }
  .textboxsmal {
	  width:50px;
	  height:10px;
  }
 </style>
<!-- InstanceEndEditable -->
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
</script>
<!-- InstanceBeginEditable name="aHead" -->
<script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
$(document).ready(function() {    
    $('#nom_taquilla').blur(function(){
		var taquilla = $('input[name=nom_taquilla]').val();
		if(taquilla != '') {
			var nom_taquilla = $(this).val();        
			var dataString = 'nom_taquilla='+nom_taquilla;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarTaquilla.php",
				data: dataString,
				success: function(data) {
					$('#Info1').fadeIn(200).html(data);
				}
			});
		};
    });              
    $('#username').blur(function(){
		var usern = $('input[name=username]').val();
		if(usern != '') {
			var username = $(this).val();        
			var dataString = 'username='+username;
			$.ajax({
				type: "POST",
				url: "../includes/comprobarUsuario.php",
				data: dataString,
				success: function(data) {
					$('#Info32').fadeIn(200).html(data);
				}
			});
		};	
    });
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
});    
function FX_passGenerator(form,element) {
  var thePass = "";
  var randomchar = "";
  var numberofdigits = '5';
  for (var count=1; count<=numberofdigits; count++) {
    var chargroup = Math.floor((Math.random() * 3) + 1);
    if (chargroup==1) {
      randomchar = Math.floor((Math.random() * 26) + 65);
    }
    if (chargroup==2) {
      randomchar = Math.floor((Math.random() * 10) + 48);
    }
    if (chargroup==3) {
      randomchar = Math.floor((Math.random() * 26) + 97);
    }
    thePass+=String.fromCharCode(randomchar);
  }
  thePass = thePass.toUpperCase();
  eval('document.'+form+'.'+element+'.value = thePass');
}
function ValidaSoloNumeros() {
	if (event.keyCode != 46) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
}    
function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
</script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana_di.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceradistri.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                AGREGAR TAQUILLA<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->

	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto; ">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:100%; text-align:left; font-size:18px; background: #E1E1E1">
			              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:14px">
<?php
                if ($row_Recordset94['sinomonedadistri']==0){
                  ?>
                    <tr>
                    <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                    <br> SELECIONE TIPO DE MONEDA DE ESTA TAQUILLA</br></br>RECUERDE QUE DEBE AJUSTAR LOS VALORES </br></br>MINIMOS Y MAXIMOS AL REALIZAR UN CAMBIO DE MONEDA
                    <br><br><select name="moneda" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                      <option value="0">BOLIVAR SOBERANO</option>
                      <option value="1">DOLAR AMERICANO</option>
                      <option value="2">PESO COLOMBIANO</option>
                      <option value="3">SOL PERUANO</option>
                      <option value="10">MULTIMONEDA</option>
                      
                 	</select>
                   </td>
                   </tr>
                   <?php
}  

?>


<?php
                if ($row_Recordset94['sinomonedadistri']==1){
                  ?>
                   <div style="display: none">
                  <select name="moneda" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                      <option value="1">DOLAR AMERICANO</option>
                      
                      
                 	</select>
                   </div>
                   <?php
}  

?>                  
<td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	COSTO DEL SISTEMA PARA ESTA TAQUILLA
                  </td>
                </tr>  
                 <tr valign="baseline">
                  <td width="450" height="41" align="center" valign="bottom" nowrap bgcolor="#999999">Estado Venta Internacionales:</td>
                  <td width="450" align="center" valign="bottom" nowrap>Estado Venta Nacionales:</td>
                  <td align="center" valign="bottom" nowrap>&nbsp;</td>
                </tr>  
                <tr valign="baseline">
                  <td width="120" height="88" align="center" valign="top" nowrap bgcolor="#999999">
										                 
                    <select name="taq_vende_ame" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1">ACTIVO</option>
                      <option value="0">INACTIVO</option>
					</select><br />
					Porcentaje Internacionales:<br />
					<input type="text" name="taq_por_ame" class="textbox" style="height:auto; width:50px" 
                    onclick="ocultaDiv('Info7');"
                    value="0.00" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                  	%

				 </td>
				                   <td width="120" align="center" valign="top" nowrap>
								                       <select name="taq_vende_hnac" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1">ACTIVO</option>
                      <option value="0">INACTIVO</option>
					</select>
					<br/>Costo x pto Nacionales:<br/>
                  	<input type="text" name="taq_cob_hnac" class="textbox" style="height:auto; width:100px" 
                    onclick="ocultaDiv('Info7');"
                    value="0.00" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
										

					
                  </td>
						  
						  </table>
              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:14px">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE TAQUILLA<br/>
                  </td>
                <tr valign="baseline">
                  <td width="1" height="66" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="2" align="left" valign="middle" nowrap>Agente:<font color="red">***</font><br>
                    
                  <select name="cod_agencia" style="width:100%; height: auto" class="textbox" required>
                    <option value="">SELECCIONE
                      <?php
                                    do {
                                        ?>
                    <option value="<?php echo $row_Recordset2['cod_agencia']?>">
                        <?php echo $row_Recordset2['nom_agencia']?></option>
                    <?php
                                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                                    ?>
                    </select>
                    <div id="Info46" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
                    <?php echo $menAgen; ?></div>
                    
                  </td>
                  <td colspan="2" align="center" style="font-size:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;"><font color="red">*** = DATOS REQUERIDOS</font></td>
                <tr valign="baseline">
                  <td align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="240" align="left" valign="middle" nowrap>
                  Nombre de taquilla:<font color="red">***</font><br>
                    <input type="text" name="nom_taquilla" id="nom_taquilla" class="textbox" tabindex="1"
                    value="" 
                    size="32" placeholder="nombre de taquilla" title="indique un nombre 4-30 caracteres" 
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info1');"
                    maxlength="33" pattern="[A-Z a-z0-9]{4,30}" required/>
                    <div id="Info1" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
					<?php echo $menTaq; ?></div>
                  </td>
                  <td width="242" align="left">
                  Nombre de representante:<br />
                  <input type="text" name="nom_representante" class="textbox" tabindex="2" placeholder="nombre completo"
                  value="representante" 
                  size="32" title="indique un nombre de representante. 4-30 caracteres" onclick="ocultaDiv('Info2');"/>
                  <div id="Info2" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menNre; ?></div>
                  </td>

                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="left" nowrap>
                  Nro de contacto principal:<br />
                  <input type="text" name="tel_taquilla" class="textbox" tabindex="3"
                  size="32" pattern="[0-9]{0,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value=""  
                  placeholder="021200000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td align="left" nowrap>
                  Nro de contacto 1er auxiliar:<br />
                  <input type="text" name="tel_taquilla2" class="textbox" tabindex="3"
                  size="32" pattern="[0-9]{0,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value=""  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  </td>
                  <td align="left" nowrap>
                  Nro de contacto 2do auxiliar:<br />
                  <input type="text" name="tel_taquilla3" class="textbox" tabindex="3"
                  size="32" pattern="[0-9]{0,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value=""  
                  placeholder="02120000000" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  </td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
               
              </table>
              <table width="920" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:11px">
 
                <tr valign="baseline">
                  <td nowrap align="right">&nbsp;</td>
                  <td nowrap align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="35" colspan="11" align="center" valign="middle" nowrap bgcolor="#5EAEFF">
                  DATOS Y OPCIONES DE USUARIO VENDEDOR</td>
                </tr>
              </table>
              <table width="921" align="center">
                <tr valign="baseline">
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td width="249" align="left" nowrap>
                  	Nombre de usuario:<font color="red">***</font><br>
                    <input type="text" name="nom_usuario" class="textbox" id="username"
                    value=""
                    size="32" placeholder="nombre de usuario" 
                    maxlength="30" pattern="[A-Z a-z0-9]{4,30}" title="indique un nombre de usuario. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');" tabindex="32" required />
                    <div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNus; ?></div>
                  </td>
                  <td width="212">
                  	Contraseña de acceso:<font color="red">***</font><br />
                    <input type="text" name="pas_usuario" id="pas_usuario" size="32" class="textbox" 
                    placeholder="contraseña" pattern="[A-Z a-z0-9]{4,20}" maxlength="20" 
                    value="" tabindex="33" onKeyUp="return handleEnter(this, event)"/>
                    <div id="Info34" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menPass; ?></div>
                  </td>
                  <td width="123" align="left" valign="middle">
                  	<input name="Botón" type="button" class="btn-primary" value="Generar clave"
                    style="width:auto; height:40px; font-size:11px" 
                    onClick="ocultaDiv('Info34'),FX_passGenerator('form1','pas_usuario')"/>
                  </td>
                  <td width="272">
                  	Nombre en ticket:<br />
                  	<input type="text" name="nom_completo" class="textbox" placeholder="nombre en ticket" maxlength="30"
                    pattern="[A-Z a-z0-9]{4,30}" title="indique un nombre para mostrar en ticket. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34"
                    value="" 
                    size="32" />
                    <div id="Info35" style="float: left; padding:-10px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNcus; ?></div>
                  </td>
                </tr>
              </table>
              <table width="920" border="0">
                  <tr>
                    <td width="16">&nbsp;</td>
                    <td width="123">&nbsp;</td>
                    <td width="66">&nbsp;</td>
                    <td width="141">&nbsp;</td>
                    <td width="97">&nbsp;</td>
                    <td width="208">Hora de inicio de venta:</td>
                    <td width="239">Hora de cierre de venta:</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right">Máx Ticket a eliminar:</td>
                    <td>
                    	<input type="text" name="tic_eliminados" class="textboxsmal" 
                        style="height:20px" onclick="ocultaDiv('Info36');"
                        value="15" 
                        size="32" onkeypress="ValidaSoloNumeros()" title="indique máximo a eliminar"
                    	onKeyUp="return handleEnter(this, event)" tabindex="35" required pattern="[0-9]{1,15}"/>
                    <div id="Info36" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menTeli; ?></div>
                    </td>
                    <td align="right">Codigo de barra en ticket:</td>
                    <td>
                    	<select name="cod_barra" style="width: auto; height: auto" class="textbox" tabindex="36">
                      		<option value="0">NO
                            </option>
                      		<option value="1">SI
                            </option>
                    	</select>
                    </td>
                    <td>
                    	<select name="hor_in" style="width: auto; height: auto" class="textbox" tabindex="37" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 1; $i <= 12; $i++) {
                                        if ($i<10) {
                                            $v="0".$i;
                                        } else {
                                            $v=$i;
                                        } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($hor_in, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                           <?php
                                    }?>
                        </select>
                      	<select name="min_in" style="width: auto; height: auto" class="textbox" tabindex="38" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 0; $i <= 55; $i=$i+5) {
                                        if ($i<10) {
                                            $v="0".$i;
                                        } else {
                                            $v=$i;
                                        } ?>
                          <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($min_in, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                          </option>
                            <?php
                                    }?>
                      </select>
                      <select name="am_in" style="width: auto; height: auto" class="textbox" tabindex="39" 
                        onfocus="ocultaDiv('Info37');">
	                        <option value="AM" <?php
                            if (!(strcmp("AM", htmlentities($am_in, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>AM
                            </option>
                        	<option value="PM" <?php
                            if (!(strcmp("PM", htmlentities($am_in, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>PM
                            </option>
                      </select>
                      <div id="Info37" style="float: left; width:auto; color: #F00; margin:-8px 0px 0px 0px; font-size:12px">
					  <?php echo $menHin; ?></div>
                  </td>
                  <td>
                   	<select name="hor_fi" style="width: auto; height: auto" class="textbox" tabindex="40" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 1; $i <= 12; $i++) {
                                if ($i<10) {
                                    $v="0".$i;
                                } else {
                                    $v=$i;
                                } ?>
                                <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($hor_fi, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                                </option>
                           <?php
                            }?>
                    </select>
                   	<select name="min_fi" style="width: auto; height: auto" class="textbox" tabindex="41" 
                        onfocus="ocultaDiv('Info37');">
                        	<?php for ($i = 0; $i <= 55; $i=$i+5) {
                                if ($i<10) {
                                    $v="0".$i;
                                } else {
                                    $v=$i;
                                } ?>
                                <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($min_fi, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $v; ?>
                                </option>
                            <?php
                            }?>
                    </select>
                      <select name="am_fi" style="width: auto; height: auto" class="textbox" tabindex="42" 
                        onfocus="ocultaDiv('Info37');">
                        	<option value="AM" <?php
                            if (!(strcmp("AM", htmlentities($am_fi, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>AM
                            </option>
                        	<option value="PM" <?php
                            if (!(strcmp("PM", htmlentities($am_fi, ENT_COMPAT, 'utf-8')))) {
                                echo "SELECTED";
                            } ?>>PM
                            </option>
                    </select></td>
                  </tr>
              </table>
                <table width="924" align="center">
                <tr valign="baseline" style="font-size:12px">
                  <td width="36" align="left" nowrap>&nbsp;</td>
                  <td width="182" align="left" nowrap>&nbsp;</td>
                  <td width="68" align="center" valign="bottom">LUNES</td>
                  <td align="center" valign="bottom">MARTES</td>
                  <td align="center" valign="bottom">MIÉRCOLES</td>
                  <td width="68" align="center" valign="bottom">JUEVES</td>
                  <td width="68" align="center" valign="bottom">VIERNES</td>
                  <td width="68" align="center" valign="bottom">SÁBADO</td>
                  <td width="68" align="center" valign="bottom">DOMINGO</td>
                  <td width="26" align="center" valign="bottom">&nbsp;</td>
                  <td colspan="2" align="left" valign="bottom" bgcolor="#333333" style="font-size:20px; color:#FFF">
                  &nbsp;Inicia sistema en:
                  </td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="right">Días que trabaja</td>
                  <td align="center"><input type="checkbox" name="dia1" class="textboxsmal" tabindex="43"
                  value=""  <?php if (!(strcmp(htmlentities($dia1, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td width="68" align="center"><input type="checkbox" name="dia2" class="textboxsmal" tabindex="44"
                  value=""  <?php if (!(strcmp(htmlentities($dia2, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td width="70" align="center"><input type="checkbox" name="dia3" class="textboxsmal" tabindex="45"
                  value=""  <?php if (!(strcmp(htmlentities($dia3, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td> 
                  <td align="center"><input type="checkbox" name="dia4" class="textboxsmal" tabindex="46"
                  value=""  <?php if (!(strcmp(htmlentities($dia4, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td align="center"><input type="checkbox" name="dia5" class="textboxsmal" tabindex="47"
                  value=""  <?php if (!(strcmp(htmlentities($dia5, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td align="center"><input type="checkbox" name="dia6" class="textboxsmal" tabindex="48"
                  value=""  <?php if (!(strcmp(htmlentities($dia6, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td align="center"><input type="checkbox" name="dia7" class="textboxsmal" tabindex="49"
                  value=""  <?php if (!(strcmp(htmlentities($dia7, ENT_COMPAT, 'utf-8'), ""))==0) {
                                echo "checked=\"checked\"";
                            } ?> /></td>
                  <td>&nbsp;</td>
                  <td colspan="2" align="left">
					<select name="ini_programa" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                      <option value="0">SELECCIÓN</option>
                      <option value="1">AMERICANAS</option>
                      <option value="2">NACIONALES</option>
                 	</select>
                  </td>
                  </tr>
                <tr valign="baseline">
                  <td colspan="12" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td colspan="12" align="left" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                  </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td align="left" nowrap>&nbsp;</td>
                  <td colspan="3" align="right" valign="bottom" nowrap>
                  <a href='taquillas_lista.php'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="50" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="11" align="left" nowrap>&nbsp;</td>
                  </tr>
              </table>
               
          </div>
          <input type="hidden" name="MM_insert" value="form1"/>
          <input type="hidden" name="tip_usuario" value="U"/>
      </form>
    </div>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset2);
?>
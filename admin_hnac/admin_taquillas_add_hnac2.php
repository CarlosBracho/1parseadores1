<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xCodigo=0;
$menTaq="";
$menNre="";
$menTel="";
$menNus="";
$menNcus="";
$menPass="";
$menNti="";
$menPas="";
$menHin="";
$menAmig="";	//monto apuesta minima a gan
$menAmag="";
$menRgan="";
$menMgan="";	// monto maximo a ganar a ganador
$menMmt="";		// monto maximo en ticket
$menAmip="";	//monto apuesta minima a pla
$menAmap="";
$menRpla="";
$menMpla="";
$menAmis="";	//monto apuesta minima a sho
$menAmas="";
$menRsho="";
$menMsho="";
$menMmae="";
$menAmie="";	//monto apuesta minima a exa
$menAmae="";
$menRexa="";
$menMexa="";
$menAmit="";	//monto apuesta minima a tri
$menAmat="";
$menRtri="";
$menMtri="";
$menAmisu="";	//monto apuesta minima a sup
$menAmasu="";
$menRsup="";
$menMsup="";
$menNus="";
$menNti="";
$menTeli="";	// maximo ticket a eliminar
$hor_in="9";
$min_in="0";
$am_in="AM";
$hor_fi="11";
$min_fi="55";
$am_fi="PM";
$dia1="1";
$dia2="1";
$dia3="1";
$dia4="1";
$dia5="1";
$dia6="1";
$dia7="1";
$min_eje="4";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $graba=31;
    $control=0;
    $contron=0;
    $letras = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i=0; $i<strlen($_POST['pas_usuario']); $i++) {
        if (strpos($letras, substr($_POST['pas_usuario'], $i, 1))!==false) {
            $control++;
        }
    }
    if ($control==0) {
        $menPass="CLAVE DEBE CONTENER LETRAS";
        $graba--;
    }
    $numeros="0123456789";
    for ($i=0; $i<strlen($_POST['pas_usuario']); $i++) {
        if (strpos($numeros, substr($_POST['pas_usuario'], $i, 1))!==false) {
            $contron++;
        }
    }
    if ($contron==0) {
        $menPass="CLAVE DEBE CONTENER NÚMEROS";
        $graba--;
    }
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
    if ($_POST['nom_taquilla']=="" || strlen($_POST['nom_taquilla'])<=4) {
        $menTaq="nombre no válido";
        $graba--;
    }
    if ($_POST['nom_representante']=="" || strlen($_POST['nom_representante'])<=4) {
        $menNre="nombre no válido";
        $graba--;
    }
    if ($_POST['tel_taquilla']=="" || strlen($_POST['tel_taquilla'])<9) {
        $menTel="número no válido";
        $graba--;
    }
    
    if (isset($_POST['nom_usuario']) && $_POST['nom_usuario']!="") {
        if (buscaUsu($_POST['nom_usuario'])>0) {
            $menNus="Ya existe";
            $graba--;
        }
    }
    if ($_POST['nom_usuario']=="" || strlen($_POST['nom_usuario'])<=4) {
        $menNus="nombre no válido";
        $graba--;
    }
    if ($_POST['nom_completo']=="" || strlen($_POST['nom_completo'])<=4) {
        $menNcus="nombre no válido";
        $graba--;
    }
    if ($_POST['pas_usuario']=="" || strlen($_POST['pas_usuario'])<=4) {
        $menPass="debe contener 5 caracteres o mas";
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
    if (isset($_POST['est_gan'])) {
        $_POST['est_gan']=1;
    } else {
        $_POST['est_gan']=0;
    }
    if (isset($_POST['est_pla'])) {
        $_POST['est_pla']=1;
    } else {
        $_POST['est_pla']=0;
    }
    if (isset($_POST['est_sho'])) {
        $_POST['est_sho']=1;
    } else {
        $_POST['est_sho']=0;
    }
    if (isset($_POST['est_exa'])) {
        $_POST['est_exa']=1;
    } else {
        $_POST['est_exa']=0;
    }
    if (isset($_POST['est_tri'])) {
        $_POST['est_tri']=1;
    } else {
        $_POST['est_tri']=0;
    }
    if (isset($_POST['est_sup'])) {
        $_POST['est_sup']=1;
    } else {
        $_POST['est_sup']=0;
    }
    if (!isset($_POST['apu_maxgan']) || $_POST['apu_maxgan']<11) {
        $_POST['apu_maxgan']="";
        $menAmag= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_maxpla']) || $_POST['apu_maxpla']<11) {
        $_POST['apu_maxpla']="";
        $menAmap= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_maxsho']) || $_POST['apu_maxsho']<11) {
        $_POST['apu_maxsho']="";
        $menAmas= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_maxexa']) || $_POST['apu_maxexa']<11) {
        $_POST['apu_maxexa']="";
        $menAmae= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_maxtri']) || $_POST['apu_maxtri']<11) {
        $_POST['apu_maxtri']="";
        $menAmat= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_maxsup']) || $_POST['apu_maxsup']<11) {
        $_POST['apu_maxsup']="";
        $menAmasu="indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_mingan']) || $_POST['apu_mingan']<10) {
        $_POST['apu_mingan']="";
        $menAmig= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_minpla']) || $_POST['apu_minpla']<10) {
        $_POST['apu_minpla']="";
        $menAmip= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_minsho']) || $_POST['apu_minsho']<10) {
        $_POST['apu_minsho']="";
        $menAmis= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_minexa']) || $_POST['apu_minexa']<10) {
        $_POST['apu_minexa']="";
        $menAmie= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_mintri']) || $_POST['apu_mintri']<10) {
        $_POST['apu_mintri']="";
        $menAmit= "indique monto válido";
        $graba--;
    }
    if (!isset($_POST['apu_minsup']) || $_POST['apu_minsup']<10) {
        $_POST['apu_minsup']="";
        $menAmisu="indique monto válido";
        $graba--;
    }
    if (!isset($_POST['reg_gan']) || $_POST['reg_gan']<0) {
        $_POST['reg_gan']="";
        $menRgan="indique monto válido";
        $graba--;
    }
    if (!isset($_POST['reg_pla']) || $_POST['reg_pla']<0) {
        $_POST['reg_pla']="";
        $menRpla="indique monto válido";
        $graba--;
    }
    if (!isset($_POST['reg_sho']) || $_POST['reg_sho']<0) {
        $_POST['reg_sho']="";
        $menRsho="indique monto válido";
        $graba--;
    }
    if (!isset($_POST['reg_exa']) || $_POST['reg_exa']<0) {
        $_POST['reg_exa']="";
        $menRexa="indique monto válido";
        $graba--;
    }
    if (!isset($_POST['reg_tri']) || $_POST['reg_tri']<0) {
        $_POST['reg_tri']="";
        $menRtri="indique monto válido";
        $graba--;
    }
    if (!isset($_POST['reg_sup']) || $_POST['reg_sup']<0) {
        $_POST['reg_sup']="";
        $menRsup="indique monto válido";
        $graba--;
    }
    if (!isset($_POST['max_aganar_gan'])||$_POST['max_aganar_gan']<0) {
        $_POST['max_aganar_gan']="";
        $menMgan="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_pla'])||$_POST['max_aganar_pla']<0) {
        $_POST['max_aganar_pla']="";
        $menMpla="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_sho'])||$_POST['max_aganar_sho']<0) {
        $_POST['max_aganar_sho']="";
        $menMsho="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_exa'])||$_POST['max_aganar_exa']<0) {
        $_POST['max_aganar_exa']="";
        $menMexa="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_tri'])||$_POST['max_aganar_tri']<0) {
        $_POST['max_aganar_tri']="";
        $menMtri="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_sup'])||$_POST['max_aganar_sup']<0) {
        $_POST['max_aganar_sup']="";
        $menMsup="indique monto";
        $graba--;
    }
    if (!isset($_POST['mon_maxticket'])||$_POST['mon_maxticket']<0) {
        $_POST['mon_maxticket']="";
        $menMmt="indique monto";
        $graba--;
    }
    if (!isset($_POST['mon_maxejemplar'])||$_POST['mon_maxejemplar']<0) {
        $_POST['mon_maxejemplar']="";
        $menMmae="indique monto";
        $graba--;
    }
    if ($graba==31) {
        $insertSQL = sprintf(
            "/* PARSEADORES1 admin_hnac\admin_taquillas_add_hnac2.php - QUERY 1 */ INSERT 
				INTO taquilla 
				(nom_taquilla, nom_representante, tel_taquilla, cod_agencia, est_taquilla) 
				VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString(strtoupper($_POST['nom_taquilla']), "text"),
            GetSQLValueString(strtoupper($_POST['nom_representante']), "text"),
            GetSQLValueString($_POST['tel_taquilla'], "text"),
            GetSQLValueString($_POST['cod_agencia'], "int"),
            GetSQLValueString(1, "int")
        );// estatus de taquilla
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        
        $query_RecT = "/* PARSEADORES1 admin_hnac\admin_taquillas_add_hnac2.php - QUERY 2 */ SELECT cod_taquilla FROM taquilla ORDER BY cod_taquilla DESC LIMIT 1";
        $RecT = mysqli_query($conexionbanca, $query_RecT) or die(mysqli_error($conexionbanca));
        $row_RecT = mysqli_fetch_assoc($RecT);
        $totalRows_RecT = mysqli_num_rows($RecT);
        $codTaquilla=$row_RecT['cod_taquilla'];
        $insertSQL2 = sprintf(
            "/* PARSEADORES1 admin_hnac\admin_taquillas_add_hnac2.php - QUERY 3 */ INSERT 
		INTO 
		taquilla_opc_ame 
		(cod_taquilla, apu_maxgan,
		pag_codigo, 
		apu_maxpla,		apu_maxsho, 
		apu_maxexa, 	apu_maxtri, 
		apu_maxsup, 	apu_mingan, 
		apu_minpla, 	apu_minsho,
		apu_minexa, 	apu_mintri, 
		apu_minsup, 	reg_gan, 
		reg_pla, 		reg_sho, 
		reg_exa, 		reg_tri, 
		reg_sup, 		est_gan, 
		est_pla, 		est_sho, 
		est_exa,		est_tri, 
		est_sup, 		max_aganar_gan, 
		max_aganar_pla, max_aganar_sho, 
		max_aganar_exa, max_aganar_tri, 
		max_aganar_sup,	mon_maxticket, 
		mon_maxejemplar,min_ejecarrera,
		por_taquilla) 
		VALUES 
		(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
		 %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
		 %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
		 %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($codTaquilla, "int"),
            GetSQLValueString($_POST['apu_maxgan'], "int"),
            GetSQLValueString($_POST['pag_codigo'], "int"),
            GetSQLValueString($_POST['apu_maxpla'], "int"),
            GetSQLValueString($_POST['apu_maxsho'], "int"),
            GetSQLValueString($_POST['apu_maxexa'], "int"),
            GetSQLValueString($_POST['apu_maxtri'], "int"),
            GetSQLValueString($_POST['apu_maxsup'], "int"),
            GetSQLValueString($_POST['apu_mingan'], "int"),
            GetSQLValueString($_POST['apu_minpla'], "int"),
            GetSQLValueString($_POST['apu_minsho'], "int"),
            GetSQLValueString($_POST['apu_minexa'], "int"),
            GetSQLValueString($_POST['apu_mintri'], "int"),
            GetSQLValueString($_POST['apu_minsup'], "int"),
            GetSQLValueString($_POST['reg_gan'], "int"),
            GetSQLValueString($_POST['reg_pla'], "int"),
            GetSQLValueString($_POST['reg_sho'], "int"),
            GetSQLValueString($_POST['reg_exa'], "int"),
            GetSQLValueString($_POST['reg_tri'], "int"),
            GetSQLValueString($_POST['reg_sup'], "int"),
            GetSQLValueString($_POST['est_gan'], "int"),
            GetSQLValueString($_POST['est_pla'], "int"),
            GetSQLValueString($_POST['est_sho'], "int"),
            GetSQLValueString($_POST['est_exa'], "int"),
            GetSQLValueString($_POST['est_tri'], "int"),
            GetSQLValueString($_POST['est_sup'], "int"),
            GetSQLValueString($_POST['max_aganar_gan'], "int"),
            GetSQLValueString($_POST['max_aganar_pla'], "int"),
            GetSQLValueString($_POST['max_aganar_sho'], "int"),
            GetSQLValueString($_POST['max_aganar_exa'], "int"),
            GetSQLValueString($_POST['max_aganar_tri'], "int"),
            GetSQLValueString($_POST['max_aganar_sup'], "int"),
            GetSQLValueString($_POST['mon_maxticket'], "int"),
            GetSQLValueString($_POST['mon_maxejemplar'], "int"),
            GetSQLValueString($_POST['min_ejecarrera'], "int"),
            GetSQLValueString($_POST['porcentaje'], "double")
        );
        
        $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
        $insertSQL3 = sprintf(
            "/* PARSEADORES1 admin_hnac\admin_taquillas_add_hnac2.php - QUERY 4 */ INSERT 
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
        $insertGoTo = "taquillas_lista.php";
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}

$query_Recordset2 = "/* PARSEADORES1 admin_hnac\admin_taquillas_add_hnac2.php - QUERY 5 */ SELECT cod_agencia, nom_agencia FROM agencia";
$Recordset2 =mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
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
</script><script>
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
});
$(document).ready(function() {    
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
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#0E5157">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 70px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabecera_hnac.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0E5157; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background:#0E5157;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px "> 
                <!-- InstanceBeginEditable name="pagina" -->
                Nueva Taquilla<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	DATOS DE TAQUILLA
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td width="240" align="left" valign="middle" nowrap>Agente:<br>
                    <select name="cod_agencia" style="width:227px; height: auto" class="textbox">
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_Recordset2['cod_agencia']?>">
                        <?php echo $row_Recordset2['nom_agencia']?></option>
                    <?php
                    } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                    ?>
                    </select>
                  </td>
                  <td width="242">&nbsp;</td>
                  <td width="232">&nbsp;</td>
                  <td align="left">
                  Porcentaje:<br />
                  	<input type="text" name="porcentaje" class="textbox" style="height:auto; width:50px" 
                    onclick="ocultaDiv('Info36');"
                    value="0" size="10" onkeypress="ValidaSoloNumeros()" title="indique pocentaje"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required max="100"/>
                    <div id="Info36" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMgan; ?></div>
                  </td>
                <tr valign="baseline">
                  <td align="left" valign="middle" nowrap>&nbsp;</td>
                  <td align="left" valign="middle" nowrap>
                  Nombre de taquilla:<br>
                    <input type="text" name="nom_taquilla" id="nom_taquilla" class="textbox" tabindex="1"
                    value="" 
                    size="32" placeholder="nombre de taquilla" title="indique un nombre 4-30 caracteres" 
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info1');"
                    maxlength="33" pattern="[A-Z a-z0-9]{4,30}" required/>
                    <div id="Info1" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
					<?php echo $menTaq; ?></div>
                  </td>
                  <td align="left">
                  Nombre de representante:<br />
                  <input type="text" name="nom_representante" class="textbox" tabindex="2" placeholder="nombre completo"
                  value="" 
                  size="32" title="indique un nombre de representante. 4-30 caracteres" onclick="ocultaDiv('Info2');"/>
                  <div id="Info2" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menNre; ?></div>
                  </td>
                  <td align="left">
                  Teléfono de taquilla:<br />
                  <input type="text" name="tel_taquilla" class="textbox" required tabindex="3"
                  size="32" pattern="[0-9]{9,20}" maxlength="20" onkeypress="ValidaSoloNumeros()"
                  value=""  
                  placeholder="02124124124" title="indique número de teléfono. 9 caracteres mín"
                  onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info3');"/>
                  <div id="Info3" style="float: left; padding:0px 0px 0px 0px; font-size:16px; color:#F00">
				  <?php echo $menTel; ?></div>
                  </td>
                  <td align="left">
                  Status de taquilla:<br />
                    <select name="est_taquilla" style="width:140px; height: auto" class="textbox" tabindex="4"> 
                      <option value="1">ACTIVO</option>
                      <option value="0">INACTIVO</option>
                  </select></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">OPCIONES DE TAQUILLA</td>
                </tr>
              </table>
              <table width="920" align="center">
                <tr valign="baseline" style="font-size:10px">
                  <td width="1" align="left" nowrap>&nbsp;</td>
                  <td width="134" align="left" nowrap>&nbsp;</td>
                  <td width="52" align="center" valign="middle">APUESTA MÍNIMA</td>
                  <td width="52" align="center" valign="middle">APUESTA MÁXIMA</td>
                  <td width="52" align="center" valign="middle">RAGALIA</td>
                  <td width="52" align="center" valign="middle">MAXIMO A PAGAR</td>
                  <td width="56" align="center" valign="middle">ACEPTAR JUGADA</td>
                  <td width="127">&nbsp;</td>
                  <td width="116" align="right" style="font-size:14px">&nbsp;</td>
                  <td width="234">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">GANADOR:</td>
                  <td>
                  	<input type="text" name="apu_mingan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info4');"
                    value="10" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="5" required pattern="[0-9]{1,5}"/>
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>
                  <td>
                    <input type="text" name="apu_maxgan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info5');"
                      value="10000" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="6" required pattern="[0-9]{1,5}"/>
                    <div id="Info5" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmag; ?></div>
                  </td>
                  <td>
                    <input type="text" name="reg_gan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info6');"
                      value="0" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="7" required pattern="[0-9]{1,5}"/>
                    <div id="Info6" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRgan; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="max_aganar_gan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info7');"
                    value="20" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique máxima a ganar"
                    onKeyUp="return handleEnter(this, event)" tabindex="8" required pattern="[0-9]{1,5}"/>
                    <div id="Info7" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMgan; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	<input type="checkbox" name="est_gan" class="textboxsmal" style="height:auto"
                    <?php echo "checked=\"checked\"";?>/>
                  </td>
                  <td>&nbsp;</td>
                  <td rowspan="2" align="right" valign="top" style="font-size:12px">Monto máximo en ticket:<br /></td>
                  <td rowspan="2" align="left" valign="top">
                    <input name="mon_maxticket" type="text" required class="textboxsmal" style="height:auto; width:90px" 
                    pattern="[0-9]{1,5}" tabindex="9" title="indique máximo en ticket" onclick="ocultaDiv('Info8');"
                    onkeypress="ValidaSoloNumeros()"
                    onKeyUp="return handleEnter(this, event)"
                    value="25000"/>
                    <div id="Info8" style="width:auto; color: #F00; margin:-10px 0px 0px 0px; font-size:10px;">
					<?php echo $menMmt; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">PLACE:      </td>
                  <td>
                  	<input type="text" name="apu_minpla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info9');" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima" value="10"
                    onKeyUp="return handleEnter(this, event)" tabindex="10" required pattern="[0-9]{1,5}"/>
                    <div id="Info9" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmip; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="apu_maxpla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info10');"
                    value="10000" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="11" required pattern="[0-9]{1,5}"/>
                    <div id="Info10" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmap; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="reg_pla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info11');"
                    value="0" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="12" required pattern="[0-9]{1,5}"/>
                    <div id="Info11" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRpla; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="max_aganar_pla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info12');"
                    value="16" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="13" required pattern="[0-9]{1,5}"/>
                    <div id="Info12" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMpla; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	<input type="checkbox" name="est_pla" class="textboxsmal"
                    <?php echo "checked=\"checked\"";?>/></td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">SHOW:      </td>
                  <td>
                  	<input type="text" name="apu_minsho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info13');"
                    value="10" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="14" required pattern="[0-9]{1,5}"/>
                    <div id="Info13" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmis; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="apu_maxsho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info14');"
                    value="10000" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="15" required pattern="[0-9]{1,5}"/>
                    <div id="Info14" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmas; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_sho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info15');"
                      value="0" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="16" required pattern="[0-9]{1,5}"/>
                    <div id="Info15" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRsho; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="max_aganar_sho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info16');"
                    value="10" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="17" required pattern="[0-9]{1,5}"/>
                    <div id="Info16" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMsho; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	<input type="checkbox" name="est_sho" class="textboxsmal" style="height:auto"
                    <?php echo "checked=\"checked\"";?>/></td>
                  <td>&nbsp;</td>
                  <td rowspan="2" align="right" valign="top" style="font-size:12px">Monto máximo por ejemplar:<br /></td>
                  <td rowspan="2" align="left" valign="top">
                    <input type="text" name="mon_maxejemplar" class="textboxsmal" style="height:auto; width:90px"
                      value="50000" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto" onclick="ocultaDiv('Info17');"
                    onKeyUp="return handleEnter(this, event)" tabindex="18" required pattern="[0-9]{1,5}"/>
                    <div id="Info17" style="width:auto; color: #F00; margin:-10px 0px 0px 0px; font-size:10px;">
					<?php echo $menMmae; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">EXACTA: </td>
                  <td>
                  	<input type="text" name="apu_minexa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info18');"
                    value="10" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="19" required pattern="[0-9]{1,5}"/>
                    <div id="Info18" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmie; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="apu_maxexa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info19');"
                    value="10000" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="20" required pattern="[0-9]{1,5}"/>
                    <div id="Info19" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmae; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_exa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info20');"
                      value="0" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique uregalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="21" required pattern="[0-9]{1,5}"/>
                    <div id="Info20" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRexa; ?></div>
                  </td>
                  <td>
                      <input type="text" name="max_aganar_exa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info21');"
                      value="100" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="22" required pattern="[0-9]{1,5}"/>
                    <div id="Info21" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMexa; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	  <input type="checkbox" name="est_exa" class="textboxsmal"
                      <?php echo "checked=\"checked\"";?>/></td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td height="28" align="left" nowrap>TRIFECTA:</td>
                  <td>
                      <input type="text" name="apu_mintri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info22');"
                      value="10" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="23" required pattern="[0-9]{1,5}"/>
                    <div id="Info22" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmit; ?></div>
                  </td>
                  <td>
                      <input type="text" name="apu_maxtri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info23');"
                      value="10000" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="24" required pattern="[0-9]{1,5}"/>
                    <div id="Info23" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmat; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_tri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info24');"
                      value="0" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="25" required pattern="[0-9]{1,5}"/>
                    <div id="Info24" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRtri; ?></div>
                  </td>
                  <td>
                      <input type="text" name="max_aganar_tri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info25');"
                      value="150" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="26" required pattern="[0-9]{1,5}"/>
                    <div id="Info25" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMtri; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	  <input type="checkbox" name="est_tri" class="textboxsmal"
                      <?php echo "checked=\"checked\"";?>/>
                  </td>
                  <td>&nbsp;</td>
                  <td align="right" valign="top" style="font-size:12px">Ejemplares mínimos en carrera:<br /></td>
                  <td align="left" valign="top">
					  <select name="min_ejecarrera" style="width: auto; height: auto" class="textbox" tabindex="27">
                        	<?php for ($i = 4; $i <= 15; $i++) {?>
                          <option value="<?php echo $i; ?>"><?php echo $i; ?>
                          </option>
                           <?php  }?>
                      </select>                      
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">SUPERFECTA:</td>
                  <td>
                      <input type="text" name="apu_minsup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info26');"
                      value="10" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="28" required pattern="[0-9]{1,5}"/>
                    <div id="Info26" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmisu; ?></div>
                  </td>
                  <td>
                      <input type="text" name="apu_maxsup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info27');"
                      value="10000" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="29" required pattern="[0-9]{1,5}"/>
                    <div id="Info27" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmasu; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_sup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info28');"
                      value="0" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="30" required pattern="[0-9]{1,5}"/>
                    <div id="Info28" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRsup; ?></div>
                  </td>
                  <td>
                      <input type="text" name="max_aganar_sup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info29');"
                      value="200" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="31" required pattern="[0-9]{1,5}"/>
                    <div id="Info29" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMsup; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	  <input type="checkbox" name="est_sup" class="textboxsmal"
                      <?php echo "checked=\"checked\"";?>/>
                  </td>
                  <td colspan="2" align="right" valign="top" style="font-size:12px; color: #F00">
                  	Forma de pagar apuesta y <br/>eliminar ticket:
                  </td>
                  <td align="left" valign="top">
					<select name="pag_codigo" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                      <option value="0">CON CÓDIGO</option>
                      <option value="1">SIN CÓDIGO</option>
                 	</select>                  </td>
                </tr>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">&nbsp;</td>
                  <td nowrap align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="35" colspan="10" align="center" valign="bottom" nowrap bgcolor="#5EAEFF">
                  DATOS Y OPCIONES DE USUARIO VENDEDOR</td>
                </tr>
              </table>
              <table width="921" align="center">
                <tr valign="baseline">
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td width="249" align="left" nowrap>
                  	Nombre de usuario:<br>
                    <input type="text" name="nom_usuario" class="textbox" id="username"
                    value=""
                    size="32" placeholder="nombre de usuario" 
                    maxlength="30" pattern="[A-Z a-z0-9]{4,30}" title="indique un nombre de usuario. 4-30 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info32');" tabindex="32" required />
                    <div id="Info32" style="float: left; padding:0px 0px 0px 0px; font-size:12px; color:#F00">
					<?php echo $menNus; ?></div>
                  </td>
                  <td width="212">
                  	Contraseña de acceso:<br />
                    <input type="text" name="pas_usuario" id="pas_usuario" size="32" class="textbox" 
                    placeholder="contraseña" pattern="[A-Z a-z0-9]{5,20}" maxlength="20" 
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
                  	<input type="text" name="nom_completo" class="textbox" placeholder="nombre en ticket" maxlength="10"
                    pattern="[A-Z a-z0-9]{4,10}" title="indique un nombre para mostrar en ticket. 4-10 caracteres"
                    onKeyUp="return handleEnter(this, event)" onclick="ocultaDiv('Info35');" tabindex="34" required
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
                        value="5" 
                        size="32" onkeypress="ValidaSoloNumeros()" title="indique máximo a eliminar"
                    	onKeyUp="return handleEnter(this, event)" tabindex="35" required pattern="[0-9]{1,5}"/>
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
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
</html>
<?php
mysqli_free_result($Recordset2);
?>
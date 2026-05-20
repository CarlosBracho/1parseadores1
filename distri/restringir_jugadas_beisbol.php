<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "D"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menTaq="";
$menNre="";
$menTel="";
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
$menOpNac="";
$monto_apuesta="";
$factor_pago="";
include("../includes/taquilla_estandar.php");

$xCodigo = "-1";
$xCodigo2 = "-1";
$editFormAction = $_SERVER['PHP_SELF'];
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction2 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
    $xCodigo2 = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 distri\restringir_jugadas_beisbol.php - QUERY 1 */ SELECT  
	ta.nom_taquilla, ta.nom_representante, ta.tel_taquilla, ta.tel_taquilla2, ta.tel_taquilla3, ta.est_taquilla, ta.cod_taquilla,
	ag.nom_agencia, ag.cod_agencia, ta.moneda  
	FROM  taquilla ta, agencia ag 
	WHERE ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset4 =  sprintf(
    "/* PARSEADORES1 distri\restringir_jugadas_beisbol.php - QUERY 2 */ SELECT  
*
	FROM  taquilla_opc_parley tp, taquilla ta 
	WHERE tp.cod_taquilla = %s AND tp.cod_taquilla = ta.cod_taquilla
	LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$r4=$totalRows_Recordset4;
$cod_taopcparley=$row_Recordset4['cod_taopcparley'];
$porcentaje=0;
if ($totalRows_Recordset4>0) {
    $existe=1;
    $porcentaje=$row_Recordset4['taq_por_parley'];
}
if ($totalRows_Recordset4==0 && (!isset($_POST["MM_insert2"]))) {
    $cod_taopcparley="";
    $est_impresion=0;
    $apu_mingan=10;
    $apu_maxgan=50000;
    $reg_gan=0;
    $max_aganar_gan=20;
    $est_gan=1;
    $est_pla=1;
    $est_sho=1;
    $anu_regalia=0;
    $ver_porpagar=0;
    $tie_reclamo=0;
    $tic_caduca=0;
    $mon_maxejemplar=20000;
    $tip_ticket=0;
    $min_ejecarrera=4;
    $pag_codigo=0;
    $est_impresion=0;
    $mon_maxticket=100000;
    $apu_minpla=10;
    $apu_maxpla=50000;
    $reg_pla=0;
    $max_aganar_pla=16;
    $apu_minsho=10;
    $apu_maxsho=50000;
    $reg_sho=0;
    $max_aganar_sho=10;
    $apu_minexa=10;
    $apu_maxexa=10000;
    $reg_exa=0;
    $max_aganar_exa=200;
    $est_exa=0;
    $apu_mintri=10;
    $apu_maxtri=10000;
    $reg_tri=0;
    $max_aganar_tri=300;
    $est_tri=0;
    $apu_minsup=10;
    $apu_maxsup=10000;
    $reg_sup=0;
    $max_aganar_sup=400;
    $est_sup=0;
    $menOpNac="ATENCIÓN: Los datos para Parley de esta taquilla no han sido creadas";
    $existe=0;
    $porcentaje=2;
    $apu_minparley=0.01;
    $apu_maxparley=99999999;
    $comb_minparley=1;
    $comb_maxparley=10;
    $comb_hembra=10;
    $min_eliminar=999;
    $factordehembra=0;
    $factordemacho=0;

    include("../includes/taquilla_estandar.php");
} else {
    if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
        if (isset($_POST["exp_agencia"]) && $_POST["exp_agencia"]>0) {
            $query_Recordset4 =  sprintf(
                "/* PARSEADORES1 distri\restringir_jugadas_beisbol.php - QUERY 3 */ SELECT  
* FROM  taquilla ta, taquilla_opc_parley tp 
				WHERE ta.cod_taquilla = %s AND tp.cod_taquilla = ta.cod_taquilla
				LIMIT 1",
                GetSQLValueString($_POST["exp_agencia"], "int")
            );
            $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
            $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
            $totalRows_Recordset4 = mysqli_num_rows($Recordset4);

            if ($r4==0) {
                $menOpNac="ATENCIÓN: Los datos para Parley de esta taquilla no han sido creadas*";
            }
        }
    }
    $apu_minparley=$row_Recordset4['apu_minparley'];
    $apu_maxparley=$row_Recordset4['apu_maxparley'];
    $comb_minparley=$row_Recordset4['comb_minparley'];
    $comb_maxparley=$row_Recordset4['comb_maxparley'];
    $comb_hembra=$row_Recordset4['comb_hembra'];
    $min_eliminar=$row_Recordset4['min_eliminar'];
    $monto_apuesta=$row_Recordset4['monto_apuesta'];
    $factor_pago=$row_Recordset4['factor_pago'];
    $factordehembra=$row_Recordset4['factor_de_hembra'];
    $factordemacho=$row_Recordset4['factor_de_macho'];
    if($factordehembra==0){
        $factordehembra=100;
    }
    if($factordemacho==0){
        $factordemacho=100;
    }
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $graba=31;


    





    if ($graba==31) {
        if ($_POST['existe']==1) {
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 distri\restringir_jugadas_beisbol.php - QUERY 4 */ UPDATE taquilla_opc_parley
					SET
                    beisbol_ml=%s,
                    beisbol_alta=%s,
                    beisbol_baja=%s,
                    beisbol_runline=%s,
                    beisbol_superl=%s,
                    beisbol_mj_ml=%s,
                    beisbol_mj_alta=%s,
                    beisbol_mj_baja=%s,
                    beisbol_mj_rl=%s,
                    beisbol_si=%s,
                    beisbol_no=%s,
                    beisbol_anotap=%s,
                    beisbol_hce=%s
					WHERE cod_taopcparley=%s",
                GetSQLValueString($_POST['beisbol_ml'], "int"),
                GetSQLValueString($_POST['beisbol_alta'], "int"),
                GetSQLValueString($_POST['beisbol_baja'], "int"),
                GetSQLValueString($_POST['beisbol_runline'], "int"),
                GetSQLValueString($_POST['beisbol_superl'], "int"),
                GetSQLValueString($_POST['beisbol_mj_ml'], "int"),
                GetSQLValueString($_POST['beisbol_mj_alta'], "int"),
                GetSQLValueString($_POST['beisbol_mj_baja'], "int"),
                GetSQLValueString($_POST['beisbol_mj_rl'], "int"),
                GetSQLValueString($_POST['beisbol_si'], "int"),
                GetSQLValueString($_POST['beisbol_no'], "int"),
                GetSQLValueString($_POST['beisbol_anotap'], "int"),
                GetSQLValueString($_POST['beisbol_hce'], "int"),           
                GetSQLValueString($_POST['cod_taopcparley'], "int"));
            
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));

            
            if ($_POST['beisbol_ml']<>$row_Recordset4['beisbol_ml'] or $_POST['beisbol_alta']<>$row_Recordset4['beisbol_alta'] or $_POST['beisbol_baja']<>$row_Recordset4['beisbol_baja'] or $_POST['beisbol_runline']<>$row_Recordset4['beisbol_runline'] or $_POST['beisbol_superl']<>$row_Recordset4['beisbol_superl'] or $_POST['beisbol_mj_ml']<>$row_Recordset4['beisbol_mj_ml'] or $_POST['beisbol_mj_alta']<>$row_Recordset4['beisbol_mj_alta'] or $_POST['beisbol_mj_baja']<>$row_Recordset4['beisbol_mj_baja'] or $_POST['beisbol_mj_rl']<>$row_Recordset4['beisbol_mj_rl'] or $_POST['beisbol_si']<>$row_Recordset4['beisbol_si'] or $_POST['beisbol_no']<>$row_Recordset4['beisbol_no'] or $_POST['beisbol_anotap']<>$row_Recordset4['beisbol_anotap'] or $_POST['beisbol_hce']<>$row_Recordset4['beisbol_hce']){


                $msj="HA HABIDO UNA MODIFICACION EN MODULO PARLEY DE UNA DE SUS TAQUILLAS  \n";
                $msj.= " TAQUILLA: " . $row_Recordset1['nom_taquilla'] . "\n";
                $msj.= " DEL AGENTE: " . $row_Recordset1['nom_agencia'] . "\n";
                $msj.= " DEPORTE: BEISBOL \n";
    
                if ($_POST['beisbol_ml']<>$row_Recordset4['beisbol_ml'] ) {
                    if($_POST['beisbol_ml']==1){
                    $msj.= " MONEYLINE: DESACTIVADO \n";}else{$msj.= " MONEYLINE: ACTIVADO \n";}}
    
                if ($_POST['beisbol_alta']<>$row_Recordset4['beisbol_alta'] ) {
                    if($_POST['beisbol_alta']==1){
                    $msj.= " ALTA: DESACTIVADO \n";}else{$msj.= " ALTA: ACTIVADO \n";}}
    
                if ($_POST['beisbol_baja']<>$row_Recordset4['beisbol_baja'] ) {
                    if($_POST['beisbol_baja']==1){
                    $msj.= " BAJA: DESACTIVADO \n";}else{$msj.= " BAJA: ACTIVADO \n";}}
    
                if ($_POST['beisbol_runline']<>$row_Recordset4['beisbol_runline'] ) {
                    if($_POST['beisbol_runline']==1){
                    $msj.= " RUNLINE: DESACTIVADO \n";}else{$msj.= " RUNLINE: ACTIVADO \n";}}
    
                if ($_POST['beisbol_superl']<>$row_Recordset4['beisbol_superl'] ) {
                    if($_POST['beisbol_superl']==1){
                    $msj.= " SUPERRUNLINE: DESACTIVADO \n";}else{$msj.= "SUPERRUNLINE: ACTIVADO \n";}}
    
                if ($_POST['beisbol_mj_ml']<>$row_Recordset4['beisbol_mj_ml'] ) {
                    if($_POST['beisbol_mj_ml']==1){
                    $msj.= " MITAD DE JUEGO MONEYLINE: DESACTIVADO \n";}else{$msj.= "MITAD DE JUEGO MONEYLINE: ACTIVADO \n";}}
    
                if ($_POST['beisbol_mj_alta']<>$row_Recordset4['beisbol_mj_alta'] ) {
                    if($_POST['beisbol_mj_alta']==1){
                    $msj.= " MITAD DE JUEGO ALTA: DESACTIVADO \n";}else{$msj.= "MITAD DE JUEGO ALTA: ACTIVADO \n";}}
            
                if ($_POST['beisbol_mj_baja']<>$row_Recordset4['beisbol_mj_baja'] ) {
                    if($_POST['beisbol_mj_baja']==1){
                    $msj.= " MITAD DE JUEGO BAJA: DESACTIVADO \n";}else{$msj.= "MITAD DE JUEGO BAJA: ACTIVADO \n";}}
    
                if ($_POST['beisbol_mj_rl']<>$row_Recordset4['beisbol_mj_rl'] ) {
                    if($_POST['beisbol_mj_rl']==1){
                    $msj.= " MITAD DE JUEGO RUNLINE: DESACTIVADO \n";}else{$msj.= "MITAD DE JUEGO RUNLINE: ACTIVADO \n";}}
                
                if ($_POST['beisbol_si']<>$row_Recordset4['beisbol_si'] ) {
                    if($_POST['beisbol_si']==1){
                    $msj.= " JUGADAS EXOTICAS BEISBOL SI: DESACTIVADO \n";}else{$msj.= "MITAD DE JUEGO SI: ACTIVADO \n";}}
                
                if ($_POST['beisbol_no']<>$row_Recordset4['beisbol_no'] ) {
                    if($_POST['beisbol_no']==1){
                    $msj.= " JUGADAS EXOTICAS BEISBOL NO: DESACTIVADO \n";}else{$msj.= "MITAD DE JUEGO NO: ACTIVADO \n";}}
                    
                if ($_POST['beisbol_anotap']<>$row_Recordset4['beisbol_anotap'] ) {
                    if($_POST['beisbol_anotap']==1){
                    $msj.= " JUGADAS EXOTICAS BEISBOL ANOTA PRIMERO: DESACTIVADO \n";}else{$msj.= "MITAD DE JUEGO ANOTA PRIMERO: ACTIVADO \n";}}
                        
                if ($_POST['beisbol_hce']<>$row_Recordset4['beisbol_hce'] ) {
                    if($_POST['beisbol_hce']==1){
                    $msj.= " JUGADAS EXOTICAS BEISBOL H+R+E: DESACTIVADO \n";}else{$msj.= "MITAD DE JUEGO H+R+E: ACTIVADO \n";}}
                            
        
                $msjx=utf8_encode($msj);
                $post=[
                'chat_id'=>-1001548429339,
                'text'=>$msjx,
            ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot5155928341:AAFaxAoro6OLjtRvCMwnri0Zyfnwd-MgPdY/sendMessage");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_exec($ch);
                curl_close($ch);
                
            
            }   


    


        } else {

            


            echo "/* PARSEADORES1 distri\restringir_jugadas_beisbol.php - QUERY 5 */ insert";
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 distri\restringir_jugadas_beisbol.php - QUERY 6 */ INSERT 
			INTO 
			taquilla_opc_parley 
			(cod_taquilla, apu_minparley, apu_maxparley, comb_minparley, comb_maxparley, min_eliminar, comb_hembra, monto_apuesta, factor_pago) 
			VALUES 
			(%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                GetSQLValueString($_POST['cod_taquilla'], "int"),
                GetSQLValueString($_POST['apu_minparley'], "double"),
                GetSQLValueString($_POST['apu_maxparley'], "double"),
                GetSQLValueString($_POST['comb_minparley'], "int"),
                GetSQLValueString($_POST['comb_maxparley'], "int"),
                GetSQLValueString($_POST['min_eliminar'], "int"),
                GetSQLValueString($_POST['comb_hembra'], "int"),
                GetSQLValueString($_POST['monto_apuesta'], "int"),
                GetSQLValueString($_POST['factor_pago'], "int")
            );
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            
            
            
            if ($row_Recordset1['moneda']==0) {
                $apuestasminimaausar=$apuestasminimaaganadorbss0;
            }
            if ($row_Recordset1['moneda']==1) {
                $apuestasminimaausar=$apuestasminimaaganadorusd1;
            }
            if ($row_Recordset1['moneda']==2) {
                $apuestasminimaausar=$apuestasminimaaganadorpc2;
            }
            if ($row_Recordset1['moneda']==3) {
                $apuestasminimaausar=$apuestasminimaaganadorsp3;
            }

            $query_Recordset22 =  sprintf(
                "/* PARSEADORES1 distri\restringir_jugadas_beisbol.php - QUERY 7 */ SELECT  
tp.apu_minparley, tp.apu_maxparley, tp.comb_minparley, tp.comb_maxparley
	FROM  taquilla_opc_parley tp 
	WHERE tp.cod_taquilla = %s
	LIMIT 1",
                GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
            );
            $Recordset22 = mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
            $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
            $totalRows_Recordset22 = mysqli_num_rows($Recordset22);

            if ($apuestasminimaausar > $row_Recordset22['apu_minparley']) {
                $insertSQL11 = sprintf(
                    "/* PARSEADORES1 distri\restringir_jugadas_beisbol.php - QUERY 8 */ UPDATE taquilla_opc_parley
					SET
					apu_minparley=%s
					WHERE cod_taquilla=%s",
                    GetSQLValueString($apuestasminimaausar, "int"),
                    GetSQLValueString($_POST['cod_taquilla'], "int")
                );
            
                $Result11 = mysqli_query($conexionbanca, $insertSQL11) or die(mysqli_error($conexionbanca));
            } else {
            }
        }
        $insertGoTo = "../distri/taquillas_edit_parley.php?recordID=".$row_Recordset1['cod_taquilla'];
        if (isset($_SERVER['QUERY_STRING'])) {
            $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
            $insertGoTo .= $_SERVER['QUERY_STRING'];
        }
        header(sprintf("Location: %s", $insertGoTo));
    }
}
    $agenteagente=$row_Recordset1['cod_agencia'];


$query_Recordset3 = sprintf(
    "/* PARSEADORES1 distri\restringir_jugadas_beisbol.php - QUERY 9 */ SELECT ta.cod_taquilla, ta.nom_taquilla
FROM taquilla ta, taquilla_opc_parley tp
WHERE ta.cod_agencia = %s AND ta.cod_taquilla = tp.cod_taquilla AND ta.cod_taquilla != %s
ORDER BY nom_taquilla",
    GetSQLValueString($agenteagente, "int"),
    GetSQLValueString($xCodigo2, "int")
);
$Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
function ValidaSoloNumerosx() {
	if (event.keyCode != 110) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
}    

function ValidaSoloNumeros(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}








function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
$(document).ready(function() {
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
 });
</script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
 
       
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
    <div style="width:98%; float:right; text-align:right; padding:1.5% 2% 0 0; height:40px; font-size:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
       
    </div>
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        <input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset1['cod_taquilla']; ?>">
          <input type="hidden" name="cod_taopcparley" value="<?php echo $cod_taopcparley; ?>">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:13px">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	BLOQUEAR JUGADAS DE BEISBOL
                  </td>
                
                
            
              <table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">
              
              <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">JUEGO COMPLETO</td>
              </tr>

                <tr valign="baseline">
                  <td nowrap align="left">MONEYLINE:</td>
                  <td>
            
          <select name="beisbol_ml" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_ml']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_ml']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  <td nowrap align="left">ALTA:</td>
                  <td>
                  <select name="beisbol_alta" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_alta']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_alta']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">BAJA:</td>
                  <td>
            
          <select name="beisbol_baja" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_baja']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_baja']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  <td nowrap align="left">RUNLINE:</td>
                  <td>
                  <select name="beisbol_runline" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_runline']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_runline']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  
                </tr>

                <tr valign="baseline">
                  <td nowrap align="left">SUPERRUNLINE:</td>
                  <td>
            
          <select name="beisbol_superl" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_superl']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_superl']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                 
                  
                </tr>
            </table>     
            <table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">
            <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">MITAD DE JUEGO</td>
                </tr>
              <tr valign="baseline">
                  <td nowrap align="left">MONEYLINE:</td>
                  <td>
            
          <select name="beisbol_mj_ml" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_mj_ml']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_mj_ml']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  <td nowrap align="left">ALTA:</td>
                  <td>
                  <select name="beisbol_mj_alta" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_mj_alta']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_mj_alta']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">BAJA:</td>
                  <td>
            
          <select name="beisbol_mj_baja" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_mj_baja']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_mj_baja']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  <td nowrap align="left">RUNLINE:</td>
                  <td>
                  <select name="beisbol_mj_rl" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_mj_rl']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_mj_rl']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  
                  
                </tr>

                </table>
                <table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">

                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">JUGADAS EXOTICAS BEISBOL</td>
                </tr>
              <tr valign="baseline">
                  <td nowrap align="left">SI:</td>
                  <td>
            
          <select name="beisbol_si" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_si']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_si']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  <td nowrap align="left">NO:</td>
                  <td>
                  <select name="beisbol_no" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_no']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_no']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  
                </tr>

                <tr valign="baseline">
                  <td nowrap align="left">ANOTA PRIMERO:</td>
                  <td>
            
          <select name="beisbol_anotap" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_anotap']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_anotap']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  <td nowrap align="left">H+R+E:</td>
                  <td>
                  <select name="beisbol_hce" style="width:200px; height: auto" class="textbox" tabindex="4"> 
                      <option style="color:red" value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset4['beisbol_hce']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>BLOQUEADO</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset4['beisbol_hce']/1, ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
    } ?>>ACTIVO</option>
						  </select>
                  </td>
                  
                </tr>

                </table>
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
                  <td height="20" colspan="11" align="center" valign="bottom" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                </tr>
                </table>
              <table width="924" align="center">
                <tr valign="baseline">
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="362" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td width="88" align="left" nowrap>&nbsp;</td>
                  <td width="66" align="left" nowrap>&nbsp;</td>
                  <td width="33" align="left" nowrap>&nbsp;</td>
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td align="right" valign="bottom" nowrap>
                  <a href='../distri/taquillas_edit.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="37" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="9" align="left" nowrap>&nbsp;</td>
                </tr>


                

              </table>
               
          </div>
          <input type="hidden" name="MM_update" value="form1">

          <?php
?>
          <input type="hidden" name="existe" value="<?php echo $existe; ?>">
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
mysqli_free_result($Recordset1);
?>